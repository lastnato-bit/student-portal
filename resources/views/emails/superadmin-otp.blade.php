<!DOCTYPE html>
<html>
<head>
    <title>Superadmin OTP Verification</title>
</head>
<body>
    <p>Hello {{ $firstname }}!</p>

    <p>Thank you for registering as Superadmin.</p>

    <p><strong>Your OTP Code: <span style="font-size: 20px;">{{ $otp }}</span></strong></p>

    <p>This code will expire in 10 minutes. Please use it to verify your account.</p>

    <p>If you didn’t request this, please ignore this email.</p>

    <br>
    <p>Regards,<br>
    <strong>Student Academic Portal Team</strong></p>
</body>
</html>
