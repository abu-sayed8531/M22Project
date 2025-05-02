<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{route('register.form')}}">
        @csrf
        <label for="name"> name:</label><br>
        <input type="text" id="name" name="name" value="{{old('name')}}"><br>
        @error('name','register') 
        {{$message}}
        @enderror 
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="{{old('email')}}"><br>
        @error('email','register')
        {{$message}} <br>
        @enderror
        <label for="password">password:</label><br>
        <input type="password" id="password" name="password" value={{old('password')}} class="@error('password') is-invalid @enderror"><br>
        @error('password','register')
        {{$message}}
        @enderror
        <label for="password_confirmation">password_confirmation:</label><br>
        <input type="password_confirmation" id="password_confirmation" name="password_confirmation"><br>
        <input type="submit" value="submit">
    </form>
</body>
</html>