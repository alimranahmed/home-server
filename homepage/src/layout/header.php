<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="border-b py-3 text-center">
    <h2 class="text-lg">
        <?php echo getenv('HOST_NAME') ?>
        <span class="text-slate-500">(<?php echo getenv('HOST_OS') ?>UBUNTU 20.04)</span>
    </h2>
    <span class="text-md text-slate-500"><?php echo getenv('HOST_IP') ?>192.168.0.161</span>
</div>
<div class="max-w-full mx-auto px-5 lg:px-10 min-h-screen">