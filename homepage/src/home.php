<?php
require 'layout/header.php';
require 'server_usage.php';
use Alimranahmed\HomeServerHomepage\Helpers\Url;
?>


<?php
$websiteGroups = [
    "Monitor" => [
        [
            "name" => "Uptime Kuma",
            "url" => Url::withPort('90'),
            "icon" => "/assets/icons/uptime-kuma.svg",
        ],
        [
            "name" => "Adguard Home",
            "url" => Url::withPort('81'),
            "icon" => "/assets/icons/adguard-home.png",
        ],
    ],
    "Utilities" => [
        [
            "name" => "Stirling PDF",
            "url" => Url::withPort('50'),
            "icon" => "/assets/icons/stirling-pdf.svg",
        ],
        [
            "name" => "Mazanoke(Image)",
            "url" => Url::withPort('51'),
            "icon" => "/assets/icons/mazanoke.png",
        ],

    ],
    "Media Server" => [
        [
            "name" => "Jellyfin",
            "url" => Url::withPort('82'),
            "icon" => "/assets/icons/jellyfin.png",
        ],
        [
            "name" => "Prowlarr",
            "url" => Url::withPort('9696'),
            "icon" => "/assets/icons/prowlarr.png",
        ],

        [
            "name" => "Radarr",
            "url" => Url::withPort('7878'),
            "icon" => "/assets/icons/radarr.png",
        ],
        [
            "name" => "Bazarr",
            "url" => Url::withPort('6767'),
            "icon" => "/assets/icons/bazarr.png",
        ],
        [
            "name" => "Qbittorrent",
            "url" => Url::withPort('8080'),
            "icon" => "/assets/icons/qbittorrent.png",
        ],
    ]
]
?>

<?php foreach ($websiteGroups as $group => $websites): ?>
<div class="my-3">
    <div class="mt-3 grid grid-cols-3 gap-x-6 gap-y-8 xl:gap-x-8 justify-items-center">
        <?php foreach ($websites as $website): ?>
            <div class="overflow-hidden">
                <a target="_blank" href="<?php echo $website['url'] ?>" class="text-center">
                    <div class="h-24 md:h-32 h-24 md:w-32 rounded-xl border border-gray-200 p-4 text-sm/6 flex justify-center items-center">
                        <img src="<?php echo $website['icon'] ?>" alt="<?php echo $website['name'] ?>" class="size-16"><br>
                    </div>
                    <div class="text-sm/6 font-medium text-slate-500"><?php echo $website['name'] ?></div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<hr class="my-5">
<?php endforeach; ?>

<?php require 'layout/footer.php'; ?>