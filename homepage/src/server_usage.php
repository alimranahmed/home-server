<?php use Alimranahmed\HomeServerHomepage\Helpers\Machine;?>

<?php
$mem = Machine::memory();
$disk = Machine::disk();
$cpuPercent = Machine::cpu_used(false);
$memPercent = $mem['percent'] ?? 0;
$diskPercent = $disk['percent'] ?? 0;
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

<script>
(function () {
    function setBar(block, percent) {
        var p = Math.max(0, Math.min(100, percent));
        var bar = block.querySelector('[data-stat-bar]');
        if (bar) bar.style.width = p + '%';
    }

    function refresh() {
        fetch('/api/stats', { cache: 'no-store' })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (data) {
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
            })
            .catch(function () { /* network blip — try again next tick */ });
    }

    setInterval(refresh, 5000);
})();
</script>