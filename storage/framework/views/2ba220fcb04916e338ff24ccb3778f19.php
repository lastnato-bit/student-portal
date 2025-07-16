<!-- resources/views/layouts/auth-layout.blade.php -->

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e(config('app.name', 'Student Academic Portal')); ?></title>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('logo.png')); ?>" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-gray-100 antialiased font-sans text-gray-900 min-h-screen flex items-center justify-center px-4">

    <div class="flex flex-col items-center w-full max-w-md">
        <!-- Logo -->
        <div class="mb-6">
            <img src="<?php echo e(asset('logo.png')); ?>" class="h-14 w-auto" alt="Logo">
        </div>

        <!-- Form Slot -->
        <div class="bg-white shadow-md rounded w-full px-8 pt-6 pb-8">
            <?php if(isset($slot)): ?>
                <?php echo e($slot); ?>

            <?php else: ?>
                <?php echo $__env->yieldContent('content'); ?>
            <?php endif; ?>
        </div>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/layouts/auth.blade.php ENDPATH**/ ?>