<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e(ucfirst(auth()->user()?->getRoleNames()?->first() ?? 'User')); ?> | Profile</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="min-h-screen">
        
        <?php echo $__env->make('layouts.partials.custom-navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <main class="py-10">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/layouts/custom.blade.php ENDPATH**/ ?>