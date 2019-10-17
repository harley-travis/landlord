@component('mail::message')
# Welcome {{ $user->name }}

Your property owner just created an account for you at SenRent.com. Login to start paying rent online.

When you login, we encourage you to update your password.

@component('mail::button', ['url' => 'http://senrent.com/login'])
Login
@endcomponent

@endcomponent