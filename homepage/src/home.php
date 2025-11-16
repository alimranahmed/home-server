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
            'clue' => null,
            "url" => Url::withPort('90'),
            "icon" => "/assets/icons/uptime-kuma.svg",
        ],
        [
            "name" => "Adguard Home",
            'clue' => null,
            "url" => Url::withPort('81'),
            "icon" => "/assets/icons/adguard-home.png",
        ],
    ],
    "Utilities" => [
        [
            "name" => "Stirling",
            'clue' => 'PDF Editor',
            "url" => Url::withPort('50'),
            "icon" => "/assets/icons/stirling-pdf.svg",
        ],
        [
            "name" => "Mazanoke",
            'clue' => 'Image Editor',
            "url" => Url::withPort('51'),
            "icon" => "/assets/icons/mazanoke.png",
        ],

    ],
    "Media Server" => [
        [
            "name" => "Jellyfin",
            'clue' => 'Media Player',
            "url" => Url::withPort('82'),
            "icon" => "/assets/icons/jellyfin.png",
        ],
        [
            "name" => "Prowlarr",
            'clue' => 'Index Manager',
            "url" => Url::withPort('9696'),
            "icon" => "/assets/icons/prowlarr.png",
        ],

        [
            "name" => "Radarr",
            'clue' => 'Movie Search',
            "url" => Url::withPort('7878'),
            "icon" => "/assets/icons/radarr.png",
        ],
        [
            "name" => "Qbittorrent",
            'clue' => null,
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
                    <div>
                        <span class="text-sm/6 font-medium text-slate-600"><?php echo $website['name'] ?></span>
                        <?php if ($website['clue']): ?>
                            <span class="text-xs font-medium text-slate-400">
                                (<?php echo $website['clue'] ?>)
                            </span>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<hr class="my-5">
<?php endforeach; ?>

<?php require 'layout/footer.php'; ?>