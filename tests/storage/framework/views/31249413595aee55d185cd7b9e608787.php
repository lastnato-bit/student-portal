<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form method="POST" action="<?php echo e(route('login')); ?>" class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm">
        <?php echo csrf_field(); ?>

        <h2 class="text-2xl font-bold text-center mb-4">Student Login</h2>

        
        <?php if($errors->any()): ?>
            <div class="mb-4 text-sm text-red-600">
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <div class="mb-4">
            <label class="block text-sm mb-1" for="email">Email</label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required autofocus>
        </div>

        
        <div class="mb-4">
            <label class="block text-sm mb-1" for="password">Password</label>
            <input id="password" type="password" name="password"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember"
                   class="h-4 w-4 text-blue-600 border-gray-300 rounded">
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
        </div>

        
        <div class="flex items-center justify-between">
            <?php if(Route::has('password.request')): ?>
                <a class="text-sm text-blue-500 hover:underline" href="<?php echo e(route('password.request')); ?>">
                    Forgot your password?
                </a>
            <?php endif; ?>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Login
            </button>
        </div>
    </form>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/auth/login.blade.php ENDPATH**/ ?>