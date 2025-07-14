@component('mail::message')
# Welcome to the Student Portal

Hi {{ $user->name }},

Your student account has been created successfully. You may now log in with the credentials below:

- **Email:** {{ $user->email }}
- **Password:** {{ $password }}

@component('mail::button', ['url' => url('/login')])
Login to Student Portal
@endcomponent

> Please change your password after logging in.

Thanks,  
{{ config('app.name') }}
@endcomponent
