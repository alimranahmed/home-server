<?php use Alimranahmed\HomeServerHomepage\Helpers\Machine;?>

<div class="mt-6 grid gap-x-6 gap-y-8 grid-cols-3 xl:gap-x-8 py-5 border rounded-lg mx-2 md:mx-6">
    <div class="flex flex-col items-center px-3">
        <img class="block size-12" src="/assets/icons/cpu.png" alt="CPU">
        <div class="text-slate-500 text-sm whitespace-nowrap">
            <?php echo Machine::cpu_used() ?> Used
        </div>
    </div>
    <div class="flex flex-col items-center px-3">
        <img class="block size-12" src="/assets/icons/ram.png" alt="RAM">
        <div class="text-slate-500 text-sm whitespace-nowrap">
            <span>Total: <?php echo Machine::memory()['total']?></span><br>
            <span>Used: <?php echo Machine::memory()['used']?></span>
        </div>
    </div>
    <div class="flex flex-col items-center px-3">
        <img class="block size-12" src="/assets/icons/ssd.png" alt="Disk">
        <div class="text-slate-500 text-sm whitespace-nowrap">
            <span>Total: <?php echo Machine::disk()['total']?></span><br>
            <span>Used: <?php echo Machine::disk()['used']?></span>
        </div>
    </div>
</div>