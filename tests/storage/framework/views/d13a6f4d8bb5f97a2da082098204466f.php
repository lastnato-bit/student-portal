<?php
    $role = auth()->user()?->getRoleNames()?->first();
?>

<nav class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 font-bold text-lg">
            <?php switch($role):
                case ('admin'): ?> 🛠️ Admin Panel <?php break; ?>
                <?php case ('superadmin'): ?> 🧑‍💻 Superadmin Panel <?php break; ?>
                <?php case ('student'): ?> 🎓 Student Portal <?php break; ?>
                <?php default: ?> 👤 User
            <?php endswitch; ?>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
        </form>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/layouts/partials/custom-navbar.blade.php ENDPATH**/ ?>