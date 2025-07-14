<h2>Hello {{ $user->name }},</h2>

<p>We received a request to reset your Superadmin password.</p>

<p>If this was you, please confirm:</p>

<a href="{{ $confirmUrl }}" style="background:#38bdf8;color:white;padding:10px 15px;">Yes, it’s me</a>
<a href="{{ $denyUrl }}" style="color:red;padding:10px 15px;">No, it’s not me</a>

<p>If you did not request this, we recommend reviewing your account activity.</p>
