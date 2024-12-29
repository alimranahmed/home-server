<?php
require_once __DIR__.'/vendor/autoload.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$requestUri = rtrim($requestUri, '/');

$routes = [
    '' => 'home.php',
];

//echo "<pre>";
//
//echo "</pre>";
//die;

if (array_key_exists($requestUri, $routes)) {
    $page = $routes[$requestUri];
    require __DIR__."/src/{$page}";
} else {
    require __DIR__.'/src/404.php';
}

function url(string $port): string {
    return 'http://'.getenv('HOST_IP').":$port";
}

function cpu_used(): string {
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

function memory(): array {
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

function disk(): array {
    // Get the disk usage statistics for the root directory
    $diskStats = shell_exec('df -h /');

    // Parse the output
    preg_match('/(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)/', $diskStats, $matches);

    // Total, Used, Available, Mounted on
    $totalDisk = $matches[2];
    $usedDisk = $matches[3];
    $availableDisk = $matches[4];

    return [
        'total' => $totalDisk,
        'used' => $usedDisk,
        'free' => $availableDisk,
    ];
}