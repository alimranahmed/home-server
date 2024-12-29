<?php require 'layout/header.php'; ?>

<div class="my-3">
    <div>Monitor</div>
    <ul role="list" class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
        <li class="overflow-hidden rounded-xl border border-gray-200">
            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-3">
                <img src="/assets/icons/uptime-kuma.svg" alt="Uptime Kuma" class="size-12">
                <div class="text-sm/6 font-medium text-gray-900">Uptime Kuma</div>
            </div>
            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm/6">
                <div class="flex justify-between gap-x-4 py-3">
                    <a href="<?php echo url('90')?>" class="text-blue-500 hover:underline">
                        <?php echo url('90')?>
                    </a>
                </div>
            </dl>
        </li>
    </ul>
</div>
<hr>
<div class="my-3">
    <div>Ad Blocker</div>
    <ul role="list" class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
        <li class="overflow-hidden rounded-xl border border-gray-200">
            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-3">
                <img src="/assets/icons/adguard-home.png" alt="Adguard Home" class="size-12">
                <div class="text-sm/6 font-medium text-gray-900">Adguard Home</div>
            </div>
            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm/6">
                <div class="flex justify-between gap-x-4 py-3">
                    <a href="<?php echo url('81')?>" class="text-blue-500 hover:underline">
                        Adblock: <?php echo url('90')?>
                    </a>
                </div>
            </dl>
        </li>
    </ul>
</div>
<hr>
<div class="my-3">
    <div>Media Server</div>
    <ul role="list" class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
        <li class="overflow-hidden rounded-xl border border-gray-200">
            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-3">
                <img src="/assets/icons/jellyfin.png" alt="Jellyfin" class="size-12">
                <div class="text-sm/6 font-medium text-gray-900">Jellyfin</div>
            </div>
            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm/6">
                <div class="flex justify-between gap-x-4 py-3">
                    <a href="<?php echo url('82')?>" class="text-blue-500 hover:underline">
                        Streaming: <?php echo url('82')?>
                    </a>
                </div>
            </dl>
        </li>
        <li class="overflow-hidden rounded-xl border border-gray-200">
            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-3">
                <img src="/assets/icons/prowlarr.png" alt="Prowlarr" class="size-12">
                <div class="text-sm/6 font-medium text-gray-900">Prowlarr</div>
            </div>
            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm/6">
                <div class="flex justify-between gap-x-4 py-3">
                    <a href="<?php echo url('9696')?>" class="text-blue-500 hover:underline">
                        Indexer: <?php echo url('9696')?>
                    </a>
                </div>
            </dl>
        </li>
        <li class="overflow-hidden rounded-xl border border-gray-200">
            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-3">
                <img src="/assets/icons/radarr.png" alt="Radarr" class="size-12">
                <div class="text-sm/6 font-medium text-gray-900">Radarr</div>
            </div>
            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm/6">
                <div class="flex justify-between gap-x-4 py-3">
                    <a href="<?php echo url('7878')?>" class="text-blue-500 hover:underline">
                        Movie: <?php echo url('7878')?>
                    </a>
                </div>
            </dl>
        </li>
        <li class="overflow-hidden rounded-xl border border-gray-200">
            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-3">
                <img src="/assets/icons/bazarr.png" alt="Bazarr" class="size-12">
                <div class="text-sm/6 font-medium text-gray-900">Bazarr</div>
            </div>
            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm/6">
                <div class="flex justify-between gap-x-4 py-3">
                    <a href="<?php echo url('6767')?>" class="text-blue-500 hover:underline">
                        Subtitle: <?php echo url('6767')?>
                    </a>
                </div>
            </dl>
        </li>
        <li class="overflow-hidden rounded-xl border border-gray-200">
            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-3">
                <img src="/assets/icons/qbittorrent.png" alt="Qbittorrent" class="size-12">
                <div class="text-sm/6 font-medium text-gray-900">Qbittorrent</div>
            </div>
            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm/6">
                <div class="flex justify-between gap-x-4 py-3">
                    <a href="<?php echo url('8080')?>" class="text-blue-500 hover:underline">
                        Torrent: <?php echo url('8080')?>
                    </a>
                </div>
            </dl>
        </li>
    </ul>
</div>

<?php require 'layout/footer.php'; ?>