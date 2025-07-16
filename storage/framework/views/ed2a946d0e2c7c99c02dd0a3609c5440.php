<div class="w-full max-w-md mx-auto py-12">
    
    <div class="flex justify-center mb-6">
        <img src="<?php echo e(asset('logo.png')); ?>" alt="Student Academic Portal Logo" class="h-14 w-auto" />
    </div>

    
    <form wire:submit.prevent="login" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>

        
        <!--[if BLOCK]><![endif]--><?php if($errors->any()): ?>
            <div class="mb-4 text-red-500 text-sm">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input
                type="email"
                wire:model.defer="email"
                autocomplete="username"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
        </div>

        
        <div class="mb-2">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input
                type="password"
                wire:model.defer="password"
                autocomplete="current-password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
        </div>

         
<div class="mb-4" x-data x-init="
    window.recaptchaCallback = function(token) {
        Livewire.find($root.closest('[wire\\:id]').getAttribute('wire:id'))
                .call('setRecaptchaToken', { token: token });
    };
">

    <div
        class="g-recaptcha"
        data-sitekey="<?php echo e(config('services.nocaptcha.sitekey')); ?>"
        data-callback="recaptchaCallback"
        wire:ignore>
    </div>
    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['recaptchaToken'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
</div>

        
        <div class="mb-6 text-right">
            <a href="<?php echo e(route('admin.password.request')); ?>" class="text-sm text-indigo-600 hover:underline">
                Forgot your password?
            </a>
        </div>

        
        <div class="flex items-center justify-between mb-4">
            <button
                type="submit"
                class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline">
                Login
            </button>
        </div>

       


<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/auth/admin-login.blade.php ENDPATH**/ ?>