<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Superadmin | <?php echo e(config('app.name', 'Student Portal')); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white font-sans min-h-screen flex flex-col">

    
    <header class="bg-fuchsia-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wide">🎓 Student Portal - Superadmin</h1>
            <div class="flex items-center gap-4 text-sm">
                <span><?php echo e(Auth::user()->name); ?></span>
                <form method="POST" action="<?php echo e(route('superadmin.logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="text-white hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </header>

    
    <main class="flex-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <footer class="bg-fuchsia-800 text-white text-center py-4 mt-10">
        &copy; <?php echo e(date('Y')); ?> Superadmin Panel — Student Academic Portal
    </footer>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/layouts/superadmin.blade.php ENDPATH**/ ?>