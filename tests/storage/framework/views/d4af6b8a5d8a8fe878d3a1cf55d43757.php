<nav class="bg-white dark:bg-gray-800 shadow border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="text-lg font-bold text-gray-800 dark:text-white">
            🛠️ Admin Panel
        </div>
        <div class="flex items-center gap-4">
            <a href="<?php echo e(url('/admin/dashboard')); ?>" class="text-sm text-gray-700 dark:text-gray-200 hover:underline">Dashboard</a>
            <a href="<?php echo e(url('/user/profile')); ?>" class="text-sm text-gray-700 dark:text-gray-200 hover:underline">Profile</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:underline">Logout</button>
            </form>
        </div>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/layouts/admin.blade.php ENDPATH**/ ?>