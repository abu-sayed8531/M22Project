<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Dashboard</h1>
    @auth
    <form method="POST" action="{{route('logout')}}">
        @csrf
        <input type="submit" value="Logout">
    </form>     

    @else
    <a href="{{route('login.page')}}">Login </a>
    @endauth
</body>
</html>