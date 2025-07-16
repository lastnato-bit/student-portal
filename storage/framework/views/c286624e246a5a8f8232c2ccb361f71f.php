<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to the Student Portal</title>
</head>
<body>
    <h2>Hello <?php echo e($user->name); ?>!</h2>

    <p>Your <strong>student account</strong> has been created successfully.</p>

    <p><strong>Login Credentials:</strong></p>
    <ul>
        <li><strong>Email:</strong> <?php echo e($user->email); ?></li>
        <li><strong>Temporary Password:</strong> <?php echo e($password); ?></li>
    </ul>

    <p>
        <a href="<?php echo e(url('/login')); ?>" style="background-color: #1d72b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Login to the Student Portal
        </a>
    </p>

    <p>Please change your password after logging in for security.</p>
    <p>Regards,<br>Your Academic Team</p>

    <hr>
    <p style="font-size: 12px;">
        If you're having trouble clicking the "Login to the Student Portal" button,
        copy and paste the URL below into your web browser: <br>
        <a href="<?php echo e(url('/login')); ?>"><?php echo e(url('/login')); ?></a>
    </p>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/emails/student_credentials.blade.php ENDPATH**/ ?>