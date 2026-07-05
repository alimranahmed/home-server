<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Alimranahmed\HomeServerHomepage\Helpers\Machine;
use Alimranahmed\HomeServerHomepage\Helpers\Url;

header('Content-Type: application/json');
header('Cache-Control: no-store');

$services = [
    ['name' => 'Uptime Kuma', 'port' => 90],
    ['name' => 'Adguard Home', 'port' => 81],
    ['name' => 'Stirling', 'port' => 50],
    ['name' => 'Mazanoke', 'port' => 51],
    ['name' => 'OpenClaw', 'port' => 18789],
    ['name' => 'Jellyfin', 'port' => 82],
    ['name' => 'Prowlarr', 'port' => 9696],
    ['name' => 'Radarr', 'port' => 7878],
    ['name' => 'Sonarr', 'port' => 8989],
    ['name' => 'Qbittorrent', 'port' => 8080],
];

$host = Url::host();
$results = [];

foreach ($services as $service) {
    $results[$service['name']] = Machine::check_port($host, $service['port']);
}

echo json_encode($results);
