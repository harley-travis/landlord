@component('mail::message')
# Welcome {{ $user->name }}

Your property owner just created an account for you at SenRent.com. Login to start paying rent online.

Click here to reset your password.

@component('mail::button', ['url' => 'https://app.senrent.com/password/reset'])
Login
@endcomponent

@endcomponent