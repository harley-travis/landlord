@component('mail::message')
# Welcome {{ $user->name }}

Your property manager has created an account for you.

You can login and begin managing your responsibilites. 

If you have any troubles navigating the site, you can always reach out for support. Contact us at support@senrent.com.

Welcome!

The SenRent Team
support@senrent.com

@component('mail::button', ['url' => 'https://app.senrent.com/login'])
Login
@endcomponent

@endcomponent