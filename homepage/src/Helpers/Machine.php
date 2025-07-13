<?php

namespace Alimranahmed\HomeServerHomepage\Helpers;

class Machine
{
    public static function cpu_used(): string {
        // Get the CPU statistics
        $cpuStats = file_get_contents('/proc/stat');

        // Extract the CPU data
        preg_match('/^cpu\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/', $cpuStats, $matches);

        // User, nice, system, idle, iowait, irq, softirq
        $user = (double)$matches[1];
        $nice = (double)$matches[2];
        $system = (double)$matches[3];
        $idle = (double)$matches[4];
        $iowait = (double)$matches[5];
        $irq = (double)$matches[6];
        $softirq = (double)$matches[7];

        // Calculate total CPU time and idle time
        $totalTime = $user + $nice + $system + $idle + $iowait + $irq + $softirq;
        $idleTime = $idle + $iowait;

        // CPU usage percentage = (totalTime - idleTime) / totalTime * 100
        $cpuUsage = ($totalTime - $idleTime) / $totalTime * 100;

        return round($cpuUsage, 2) . '%'; // Returns the CPU usage percentage
    }

    public static function memory(): array {
        // Get the memory statistics
        $memStats = file_get_contents('/proc/meminfo');

        // Parse the memory info
        preg_match('/MemTotal:\s+(\d+)/', $memStats, $totalMemory);
        preg_match('/MemFree:\s+(\d+)/', $memStats, $freeMemory);
        preg_match('/Buffers:\s+(\d+)/', $memStats, $buffers);
        preg_match('/Cached:\s+(\d+)/', $memStats, $cached);

        $totalMemory = $totalMemory[1] / 1024; // Convert to MB
        $freeMemory = $freeMemory[1] / 1024; // Convert to MB
        $buffers = $buffers[1] / 1024; // Convert to MB
        $cached = $cached[1] / 1024; // Convert to MB

        // Used memory = Total - Free - Buffers - Cached
        $usedMemory = $totalMemory - $freeMemory - $buffers - $cached;

        // Convert memory values to GB if they exceed 1000 MB
        $usedMemory = ($usedMemory > 1000) ? round($usedMemory / 1024, 2) . ' GB' : round($usedMemory, 2) . ' MB';
        $totalMemory = ($totalMemory > 1000) ? round($totalMemory / 1024, 2) . ' GB' : round($totalMemory, 2) . ' MB';
        $freeMemory = ($freeMemory > 1000) ? round($freeMemory / 1024, 2) . ' GB' : round($freeMemory, 2) . ' MB';

        return [
            'total' => $totalMemory,
            'used' => $usedMemory,
            'free' => $freeMemory,
        ];
    }

    public static function disk(): array {
        // Get the disk usage statistics
        $diskStats = shell_exec('df -h');

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

        // If no line for "/" is found, return null
        if ($dataLine === null) {
            return []; // Root mount point not found
        }

        // Match the relevant fields: Size, Used, Available
        preg_match('/\S+\s+([\d.]+[G|M|K|T])\s+([\d.]+[G|M|K|T])\s+([\d.]+[G|M|K|T])/', $dataLine, $matches);

        if (count($matches) < 4) {
            return []; // Unable to parse disk stats
        }

        // Extract total, used, and available space
        $totalDisk = $matches[1];
        $usedDisk = $matches[2];
        $availableDisk = $matches[3];

        return [
            'total' => $totalDisk,
            'used' => $usedDisk,
            'free' => $availableDisk
        ];
    }
}