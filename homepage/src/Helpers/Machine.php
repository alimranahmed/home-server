<?php

namespace Alimranahmed\HomeServerHomepage\Helpers;

class Machine
{
    /**
     * Take a raw /proc/stat sample.
     * Returns ['total' => int, 'idle' => int, 'time' => float(microtime)].
     */
    private static function cpuSample(): array {
        $cpuStats = file_get_contents('/proc/stat');
        preg_match('/^cpu\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/', $cpuStats, $m);

        $user   = (double)$m[1];
        $nice   = (double)$m[2];
        $system = (double)$m[3];
        $idle   = (double)$m[4];
        $iowait = (double)$m[5];
        $irq    = (double)$m[6];
        $softirq = (double)$m[7];

        $total = $user + $nice + $system + $idle + $iowait + $irq + $softirq;
        $idleTime = $idle + $iowait;

        return ['total' => $total, 'idle' => $idleTime, 'time' => microtime(true)];
    }

    /**
     * Real current CPU usage computed as the delta between two samples
     * taken ~1s apart. The first sample is persisted to a temp file so each
     * call compares against the previous one (no blocking 1s sleep per request).
     *
     * Pass $format = true to get "X%" string (backward compatible with the old
     * cpu_used() used by server_usage.php).
     */
    public static function cpu_used(bool $format = true): string|float {
        $cacheFile = sys_get_temp_dir() . '/homeserver_cpu_sample';

        $prev = @file_get_contents($cacheFile);
        $cur = self::cpuSample();
        @file_put_contents($cacheFile, serialize($cur));

        if ($prev === false || $prev === '') {
            // No previous sample yet — fall back to instantaneous since-boot.
            $cpuUsage = ($cur['total'] - $cur['idle']) / max(1, $cur['total']) * 100;
        } else {
            $prev = unserialize($prev, ['allowed_classes' => false]);
            $dTotal = $cur['total'] - $prev['total'];
            $dIdle  = $cur['idle']  - $prev['idle'];
            // If samples are too far apart or equal, delta is meaningless.
            $cpuUsage = ($dTotal > 0) ? ($dTotal - $dIdle) / $dTotal * 100
                : ($cur['total'] - $cur['idle']) / max(1, $cur['total']) * 100;
        }

        $cpuUsage = max(0, min(100, $cpuUsage));

        return $format ? round($cpuUsage, 2) . '%' : round($cpuUsage, 2);
    }

    public static function memory(): array {
        // Get the memory statistics
        $memStats = file_get_contents('/proc/meminfo');

        // Parse the memory info (values in kB)
        preg_match('/MemTotal:\s+(\d+)/', $memStats, $totalMemory);
        preg_match('/MemFree:\s+(\d+)/', $memStats, $freeMemory);
        preg_match('/Buffers:\s+(\d+)/', $memStats, $buffers);
        preg_match('/Cached:\s+(\d+)/', $memStats, $cached);

        $totalKb = (int)$totalMemory[1];
        $freeKb  = (int)$freeMemory[1];
        $buffersKb = (int)$buffers[1];
        $cachedKb  = (int)$cached[1];

        $usedKb = $totalKb - $freeKb - $buffersKb - $cachedKb;

        // Convert to MB/GB for display (keep the legacy string keys)
        $totalMemoryMB = $totalKb / 1024;
        $usedMemoryMB  = $usedKb / 1024;
        $freeMemoryMB  = $freeKb / 1024;

        $fmt = static function (float $mb): string {
            return ($mb > 1000) ? round($mb / 1024, 2) . ' GB' : round($mb, 2) . ' MB';
        };

        return [
            'total' => $fmt($totalMemoryMB),
            'used'  => $fmt($usedMemoryMB),
            'free'  => $fmt($freeMemoryMB),
            // raw bytes + percentage for the usage bar
            'total_bytes' => $totalKb * 1024,
            'used_bytes'  => $usedKb * 1024,
            'percent'     => $totalKb > 0 ? round($usedKb / $totalKb * 100, 2) : 0,
        ];
    }

    public static function disk(): array {
        // Get the disk usage statistics
        $diskStats = shell_exec('df -B1 /');

        // Split the output into lines
        $lines = explode("\n", trim($diskStats));

        // Find the line for the root mount point "/"
        $dataLine = null;
        foreach ($lines as $line) {
            if (str_contains($line, ' /')) {
                $dataLine = $line;
                break;
            }
        }

        // If no line for "/" is found, return empty
        if ($dataLine === null) {
            return []; // Root mount point not found
        }

        // With -B1, the size/used/avail fields are integers in bytes
        // Fields: Filesystem 1B-blocks Used Available Use% Mounted-on
        preg_match('/\S+\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)%/', $dataLine, $matches);

        if (count($matches) < 5) {
            return []; // Unable to parse disk stats
        }

        $totalBytes = (int)$matches[1];
        $usedBytes  = (int)$matches[2];
        $availableBytes = (int)$matches[3];
        $percent = (int)$matches[4];

        // Human-readable strings (keep the legacy keys)
        $human = static function (int $bytes): string {
            $units = ['B', 'K', 'M', 'G', 'T'];
            $size = (float)$bytes;
            $i = 0;
            while ($size >= 1024 && $i < count($units) - 1) {
                $size /= 1024;
                $i++;
            }
            return round($size, 2) . $units[$i];
        };

        return [
            'total' => $human($totalBytes),
            'used'  => $human($usedBytes),
            'free'  => $human($availableBytes),
            // raw bytes + percentage for the usage bar
            'total_bytes' => $totalBytes,
            'used_bytes'  => $usedBytes,
            'percent'     => $percent,
        ];
    }

    public static function uptime(): string {
        $uptime = file_get_contents('/proc/uptime');
        $seconds = (int)strtok($uptime, ' ');

        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);

        if ($days > 0) {
            return "{$days}d {$hours}h";
        }
        return "{$hours}h";
    }

    public static function load_average(): array {
        $loadavg = file_get_contents('/proc/loadavg');
        $parts = explode(' ', $loadavg);

        return [
            '1min'  => (float)$parts[0],
            '5min'  => (float)$parts[1],
            '15min' => (float)$parts[2],
        ];
    }

    public static function check_port(string $host, int $port): bool {
        $sock = @fsockopen($host, $port, $errno, $errstr, 1);
        if ($sock === false) {
            return false;
        }
        fclose($sock);
        return true;
    }

    public static function history(): array {
        $cacheFile = sys_get_temp_dir() . '/homeserver_history';
        $mem = self::memory();
        $cpuPercent = self::cpu_used(false);

        $newSample = [
            'time' => time(),
            'cpu' => $cpuPercent,
            'memory' => $mem['percent'],
        ];

        $history = [];
        $existing = @file_get_contents($cacheFile);
        if ($existing) {
            $history = json_decode($existing, true) ?? [];
        }

        $history[] = $newSample;
        if (count($history) > 60) {
            $history = array_slice($history, -60);
        }

        @file_put_contents($cacheFile, json_encode($history));

        return $history;
    }

    public static function sparkline(array $values, int $width = 80, int $height = 20): string {
        if (count($values) < 2) {
            return '';
        }

        $min = min($values);
        $max = max($values);
        $range = $max - $min;
        if ($range < 1) $range = 1;

        $points = [];
        $count = count($values);
        foreach ($values as $i => $v) {
            $x = ($i / ($count - 1)) * $width;
            $y = $height - (($v - $min) / $range) * $height;
            $points[] = "$x,$y";
        }

        return '<svg width="' . $width . '" height="' . $height . '" class="inline"><polyline points="' . implode(' ', $points) . '" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>';
    }
}