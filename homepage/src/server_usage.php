<div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8 py-5 border rounded-lg">
    <div class="flex items-center px-3">
        <img class="size-12" src="/assets/icons/cpu.png" alt="">
        <?php echo cpu_used() ?> Used
    </div>
    <div class="flex items-center px-3">
        <img class="size-12" src="/assets/icons/ram.png" alt="">
        <?php echo memory()['used'].' used / '.memory()['total'] ?>
    </div>
    <div class="flex items-center px-3">
        <img class="size-12" src="/assets/icons/ssd.png" alt="">
        <?php echo disk()['used'].' used / '.disk()['total'] ?>
    </div>
</div>