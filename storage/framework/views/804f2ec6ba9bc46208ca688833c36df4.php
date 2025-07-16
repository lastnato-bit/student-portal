<!DOCTYPE html>
<html>
<head>
    <title>Admin Credentials</title>
</head>
<body>
    <h2>Welcome to the Student Academic Portal</h2>
    <p>Your admin account has been created.</p>
    <p><strong>Email:</strong> <?php echo e($email); ?></p>
    <p><strong>Temporary Password:</strong> <?php echo e($password); ?></p>
    <p>Please log in and change your password immediately.</p>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/emails/send-admin-credentials.blade.php ENDPATH**/ ?>