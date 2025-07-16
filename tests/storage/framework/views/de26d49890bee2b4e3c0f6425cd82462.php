<?php
    $role = auth()->user()?->getRoleNames()?->first() ?? 'guest';
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 space-y-10">

    
    <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">👤 Profile Settings</h1>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Manage your account preferences, security, and personal details.
            </p>
        </div>
        <a href="<?php echo e(url('/dashboard')); ?>"
           class="inline-flex items-center px-4 py-2 
           <?php if($role === 'superadmin'): ?> bg-fuchsia-600 hover:bg-fuchsia-500
           <?php elseif($role === 'admin'): ?> bg-amber-600 hover:bg-amber-500
           <?php else: ?> bg-blue-600 hover:bg-blue-500 <?php endif; ?>
           text-white text-xs font-bold rounded-md transition">
            ← Back to Dashboard
        </a>
    </div>

    
    <div class="p-6 rounded-lg shadow bg-gradient-to-r 
        <?php if($role === 'superadmin'): ?> from-fuchsia-600 to-pink-500
        <?php elseif($role === 'admin'): ?> from-amber-500 to-yellow-400
        <?php else: ?> from-blue-600 to-indigo-500
        <?php endif; ?> text-white">
        <h2 class="text-xl font-semibold">
            <?php echo e(ucfirst($role)); ?> Settings
        </h2>
        <p class="text-sm opacity-90 mt-1">
            <?php if($role === 'superadmin'): ?>
                You have full access to manage system-wide settings, admins, and security.
            <?php elseif($role === 'admin'): ?>
                You manage users, platform content, and enrollment information.
            <?php else: ?>
                You manage your personal account, password, and security options.
            <?php endif; ?>
        </p>
    </div>

    
    <?php if(Laravel\Fortify\Features::canUpdateProfileInformation()): ?>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📄 Update Profile Information</h3>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.update-profile-information-form');

$__html = app('livewire')->mount($__name, $__params, 'lw-3441769620-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
    <?php endif; ?>

    
    <?php if(Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords())): ?>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">🔐 Update Password</h3>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.update-password-form');

$__html = app('livewire')->mount($__name, $__params, 'lw-3441769620-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
    <?php endif; ?>

    
    <?php if(Laravel\Fortify\Features::canManageTwoFactorAuthentication()): ?>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📱 Two-Factor Authentication</h3>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.two-factor-authentication-form');

$__html = app('livewire')->mount($__name, $__params, 'lw-3441769620-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
    <?php endif; ?>

    
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">💻 Active Browser Sessions</h3>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.logout-other-browser-sessions-form');

$__html = app('livewire')->mount($__name, $__params, 'lw-3441769620-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>

    
    <?php if(Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures()): ?>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-red-300 dark:border-red-500">
            <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-4">⚠️ Delete Account</h3>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.delete-user-form');

$__html = app('livewire')->mount($__name, $__params, 'lw-3441769620-4', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.custom', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\student-portal\resources\views/profile/show.blade.php ENDPATH**/ ?>