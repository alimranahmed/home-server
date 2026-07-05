<?php use Alimranahmed\HomeServerHomepage\Helpers\Machine;?>

<?php
$mem = Machine::memory();
$disk = Machine::disk();
$cpuPercent = Machine::cpu_used(false);
$memPercent = $mem['percent'] ?? 0;
$diskPercent = $disk['percent'] ?? 0;
$uptime = Machine::uptime();
$load = Machine::load_average();
$history = Machine::history();
$cpuHistory = array_column($history, 'cpu');
$memHistory = array_column($history, 'memory');
?>

<div class="mt-6 grid gap-x-6 gap-y-8 grid-cols-3 xl:gap-x-8 py-5 border rounded-lg mx-2 md:mx-6">
    <div class="flex flex-col items-center px-3" data-stat="cpu" data-percent="<?php echo htmlspecialchars((string)$cpuPercent) ?>">
        <img class="block size-12" src="/assets/icons/cpu.png" alt="CPU">
        <div class="text-slate-500 text-sm whitespace-nowrap">
            <span data-stat-value><?php echo $cpuPercent ?>%</span> Used
        </div>
        <div class="mt-2 h-1.5 w-20 overflow-hidden rounded-full bg-slate-200">
            <div data-stat-bar class="h-full rounded-full bg-slate-500 transition-[width] duration-500" style="width: <?php echo min(100, max(0, $cpuPercent)) ?>%"></div>
        </div>
    </div>
    <div class="flex flex-col items-center px-3" data-stat="memory" data-percent="<?php echo htmlspecialchars((string)$memPercent) ?>">
        <img class="block size-12" src="/assets/icons/ram.png" alt="RAM">
        <div class="text-slate-500 text-sm whitespace-nowrap">
            <span>Total: <?php echo $mem['total']?></span><br>
            <span>Used: <?php echo $mem['used']?></span>
        </div>
        <div class="mt-2 h-1.5 w-20 overflow-hidden rounded-full bg-slate-200">
            <div data-stat-bar class="h-full rounded-full bg-slate-500 transition-[width] duration-500" style="width: <?php echo min(100, max(0, $memPercent)) ?>%"></div>
        </div>
    </div>
    <div class="flex flex-col items-center px-3" data-stat="disk" data-percent="<?php echo htmlspecialchars((string)$diskPercent) ?>">
        <img class="block size-12" src="/assets/icons/ssd.png" alt="Disk">
        <div class="text-slate-500 text-sm whitespace-nowrap">
            <span>Total: <?php echo $disk['total']?></span><br>
            <span>Used: <?php echo $disk['used']?></span>
        </div>
        <div class="mt-2 h-1.5 w-20 overflow-hidden rounded-full bg-slate-200">
            <div data-stat-bar class="h-full rounded-full bg-slate-500 transition-[width] duration-500" style="width: <?php echo min(100, max(0, $diskPercent)) ?>%"></div>
        </div>
    </div>
</div>

<div class="mx-2 md:mx-6 mt-2 flex justify-between text-xs text-slate-400">
    <span id="uptime-display">Up <?php echo $uptime ?></span>
    <span id="load-display">Load <?php echo $load['1min'] ?> / <?php echo $load['5min'] ?> / <?php echo $load['15min'] ?></span>
    <span id="updated-display">Updated just now</span>
</div>

<div class="mx-2 md:mx-6 mt-3 flex gap-6 text-xs text-slate-400">
    <div class="flex items-center gap-2">
        <span>CPU</span>
        <span id="sparkline-cpu" class="inline-flex items-center"></span>
    </div>
    <div class="flex items-center gap-2">
        <span>MEM</span>
        <span id="sparkline-memory" class="inline-flex items-center"></span>
    </div>
</div>

<script>
(function () {
    var lastUpdate = Date.now();
    var cpuHistory = [];
    var memHistory = [];

    function getBarColor(percent) {
        if (percent > 95) return 'bg-red-500';
        if (percent > 85) return 'bg-amber-500';
        return 'bg-slate-500';
    }

    function setBar(block, percent) {
        var p = Math.max(0, Math.min(100, percent));
        var bar = block.querySelector('[data-stat-bar]');
        if (bar) {
            bar.style.width = p + '%';
            bar.className = 'h-full rounded-full transition-[width] duration-500 ' + getBarColor(percent);
        }
    }

    function renderSparkline(containerId, values, color) {
        var el = document.getElementById(containerId);
        if (!el || !values || values.length < 1) return;

        var width = 100, height = 28;
        var nums = values.map(Number);
        var min = Math.min.apply(null, nums);
        var max = Math.max.apply(null, nums);
        var range = max - min;
        if (range < 0.5) { min = Math.max(0, min - 1); max = max + 1; range = max - min; }

        var pts = [];
        var count = nums.length;
        for (var j = 0; j < count; j++) {
            var x = count === 1 ? width / 2 : (j / (count - 1)) * width;
            var y = height - 2 - ((nums[j] - min) / range) * (height - 4);
            pts.push([x, y]);
        }

        var svg = '<svg width="' + width + '" height="' + height + '" viewBox="0 0 ' + width + ' ' + height + '" class="overflow-visible">';

        if (count >= 2) {
            var d = 'M ' + pts[0][0].toFixed(2) + ',' + pts[0][1].toFixed(2);
            for (var k = 1; k < pts.length; k++) {
                var p0 = pts[k - 1];
                var p1 = pts[k];
                var cx = (p0[0] + p1[0]) / 2;
                d += ' Q ' + cx.toFixed(2) + ',' + p0[1].toFixed(2) + ' ' + cx.toFixed(2) + ',' + ((p0[1] + p1[1]) / 2).toFixed(2);
                d += ' Q ' + cx.toFixed(2) + ',' + p1[1].toFixed(2) + ' ' + p1[0].toFixed(2) + ',' + p1[1].toFixed(2);
            }

            var areaD = d + ' L ' + width + ',' + height + ' L 0,' + height + ' Z';
            var gradId = 'g' + containerId.replace(/[^a-z0-9]/g, '');

            svg += '<defs><linearGradient id="' + gradId + '" x1="0" x2="0" y1="0" y2="1">' +
                '<stop offset="0%" stop-color="' + color + '" stop-opacity="0.18"/>' +
                '<stop offset="100%" stop-color="' + color + '" stop-opacity="0"/>' +
                '</linearGradient></defs>' +
                '<path d="' + areaD + '" fill="url(#' + gradId + ')"/>' +
                '<path d="' + d + '" fill="none" stroke="' + color + '" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>';
        }

        svg += '<circle cx="' + pts[pts.length - 1][0].toFixed(2) + '" cy="' + pts[pts.length - 1][1].toFixed(2) + '" r="' + (count === 1 ? 2.5 : 1.75) + '" fill="' + color + '"/>' +
            '</svg>';

        el.innerHTML = svg;
    }

    function refresh() {
        fetch('/api/stats?t=' + Date.now(), { cache: 'no-store' })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (data) {
                lastUpdate = Date.now();

                var cpu = data.cpu, mem = data.memory, disk = data.disk;

                var cpuBlock = document.querySelector('[data-stat="cpu"]');
                if (cpuBlock) {
                    cpuBlock.querySelector('[data-stat-value]').textContent = cpu.percent + '%';
                    setBar(cpuBlock, cpu.percent);
                }

                var memBlock = document.querySelector('[data-stat="memory"]');
                if (memBlock) {
                    memBlock.querySelectorAll('.text-slate-500 span')[0].textContent = 'Total: ' + mem.total;
                    memBlock.querySelector('.text-slate-500 span + span').textContent = 'Used: ' + mem.used;
                    setBar(memBlock, mem.percent);
                }

                var diskBlock = document.querySelector('[data-stat="disk"]');
                if (diskBlock) {
                    diskBlock.querySelectorAll('.text-slate-500 span')[0].textContent = 'Total: ' + disk.total;
                    diskBlock.querySelector('.text-slate-500 span + span').textContent = 'Used: ' + disk.used;
                    setBar(diskBlock, disk.percent);
                }

                if (data.uptime) {
                    document.getElementById('uptime-display').textContent = 'Up ' + data.uptime;
                }
                if (data.load) {
                    document.getElementById('load-display').textContent = 'Load ' + data.load['1min'] + ' / ' + data.load['5min'] + ' / ' + data.load['15min'];
                }

                if (data.history && data.history.cpu && data.history.memory && data.history.cpu.length > 0) {
                    cpuHistory = data.history.cpu;
                    memHistory = data.history.memory;
                    renderSparkline('sparkline-cpu', cpuHistory, '#64748b');
                    renderSparkline('sparkline-memory', memHistory, '#64748b');
                }
            })
            .catch(function (err) { console.error('Stats fetch failed:', err); });
    }

    function updateTimestamp() {
        var seconds = Math.floor((Date.now() - lastUpdate) / 1000);
        if (seconds < 5) {
            document.getElementById('updated-display').textContent = 'Updated just now';
        } else {
            document.getElementById('updated-display').textContent = 'Updated ' + seconds + 's ago';
        }
    }

    setInterval(refresh, 5000);
    setInterval(updateTimestamp, 1000);
    refresh();
})();
</script>
