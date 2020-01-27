@component('mail::message')
# Welcome {{ $user->name }}

Your property owner just created an account for you at SenRent.com. Login to start paying rent online.

In order to get started, first reset your password, then verify your email address. 

Click the button below to reset your password. 

After you have reset your password, please verify your email account. 

@component('mail::button', ['url' => 'https://app.senrent.com/password/reset'])
Set Password
@endcomponent

@endcomponent