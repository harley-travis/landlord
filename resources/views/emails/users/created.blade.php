@component('mail::message')
# Welcome {{ $user->name }}

Thank you for signing up with SenRent.com! We are happy to help you manage your properties and tenants. 

We are always working on ways to improve our software so that you can maximize your experience. If you have any suggestions, please let us know!

Login to your account and get started! Here is a list to get you going. 

1) Create a property.

2) Create a tenant.

3) Add any additional users to your acocunt like office managers or maintenance workers. 

If you have any troubles navigating the site, you can always reach out for support. Contact us at support@senrent.com.

Welcome!

The SenRent Team
support@senrent.com

@component('mail::button', ['url' => 'https://app.senrent.com/login'])
Login
@endcomponent

@endcomponent