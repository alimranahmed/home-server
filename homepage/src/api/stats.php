<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Alimranahmed\HomeServerHomepage\Helpers\Machine;

header('Content-Type: application/json');
// Stats are fan-out-polled; let the browser cache-flag nothing but allow GET.
header('Cache-Control: no-store');

$mem = Machine::memory();
$disk = Machine::disk();
$cpuPercent = Machine::cpu_used(false);

echo json_encode([
    'cpu' => [
        'used'   => $cpuPercent,
        'percent' => (float)$cpuPercent,
    ],
    'memory' => [
        'total' => $mem['total'] ?? null,
        'used'  => $mem['used'] ?? null,
        'percent' => $mem['percent'] ?? 0,
    ],
    'disk' => [
        'total' => $disk['total'] ?? null,
        'used'  => $disk['used'] ?? null,
        'percent' => $disk['percent'] ?? 0,
    ],
]);