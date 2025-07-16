<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <form wire:submit.prevent="login" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Superadmin Login</h2>

        <!--[if BLOCK]><![endif]--><?php if($errors->any()): ?>
            <div class="mb-4 text-red-500">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" wire:model.defer="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-2">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" wire:model.defer="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- ✅ Forgot Password Link -->
        <div class="mb-6 text-right">
            <a href="<?php echo e(route('superadmin.password.request')); ?>" class="text-sm text-indigo-600 hover:underline">
                Forgot your password?
            </a>
        </div>

        <div class="flex items-center justify-between mb-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Login
            </button>
        </div>

        <div class="text-center">
            <a href="<?php echo e(route('superadmin.register')); ?>" class="text-sm text-indigo-600 hover:underline">
                Don’t have an account? Register a Superadmin
            </a>
        </div>
    </form>
</div>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/auth/superadmin-login.blade.php ENDPATH**/ ?>