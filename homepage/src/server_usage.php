<div class="mt-6 grid gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8 py-5 border rounded-lg mx-6">
    <div class="flex flex-col items-center px-3">
        <img class="block size-12" src="/assets/icons/cpu.png" alt="CPU">
        <div class="text-gray-400 text-sm">
            <?php echo cpu_used() ?> Used
        </div>
    </div>
    <div class="flex flex-col items-center px-3">
        <img class="block size-12" src="/assets/icons/ram.png" alt="RAM">
        <div class="text-gray-400 text-sm">
            <span>Total: <?php echo memory()['total']?></span><br>
            <span>Used: <?php echo memory()['used']?></span>
        </div>
    </div>
    <div class="flex flex-col items-center px-3">
        <img class="block size-12" src="/assets/icons/ssd.png" alt="Disk">
        <div class="text-gray-400 text-sm">
            <span>Total: <?php echo disk()['total']?></span><br>
            <span>Used: <?php echo disk()['used']?></span>
        </div>
    </div>
</div>