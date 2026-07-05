<?php
header('Content-Type: application/json');
header('Cache-Control: no-store');

$output = shell_exec('docker ps --format "{{.Names}}|{{.Status}}" 2>/dev/null');
$lines = array_filter(explode("\n", trim($output ?? '')));

$containers = [];
foreach ($lines as $line) {
    $parts = explode('|', $line, 2);
    if (count($parts) === 2) {
        $name = trim($parts[0]);
        $status = trim($parts[1]);
        $running = stripos($status, 'Up') === 0;
        $containers[$name] = [
            'status' => $status,
            'running' => $running,
        ];
    }
}

echo json_encode($containers);
