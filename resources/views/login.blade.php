<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
<form method="POST" action = "/login">
  @csrf
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="{{old('email')}}"><br>
    @error('email')
    {{$message}}<br>
    @enderror
    <label for="password">password:</label><br>
    <input type="password" id="password" name="password" value="{{old('password')}}"><br>
    @error('password')
    {{$message}}<br>
    @enderror
    <input type="checkbox" name="remember_me"  >Remember Me<br>
    
    <input type="submit" value="submit">
</form>
</body>
</html>