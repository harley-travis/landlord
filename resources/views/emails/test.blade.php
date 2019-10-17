<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    
</head>
<body>

<div class="container-fluid bg-gray">
    <div class="container">
        <h1>Welcome {{ $user->name }}</h1>
        <p>{{ $tenant->phone }}</p>
        <p>Your property owner just created an account for you at SenRent.com. Login to start paying rent online.</p>
        
        <a href="http://senrent.com" style="color:white;background-color:purple;padding:10px;">Login</a>
    </div>
</div>

</body>
</html>
