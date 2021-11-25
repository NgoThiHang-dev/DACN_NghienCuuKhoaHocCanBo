<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

<!-- Style --> 
<link rel="stylesheet" href="{{asset('loginalt/css/style.css')}}" type="text/css" media="all">

<!-- Fonts -->
<link href="//fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
<!-- //Fonts -->
</head>
<body>
    @if (count($errors)>0)
            <div class=" alert alert-danger">
                @foreach ($errors as $er)
                    {{$err}}<br>
                @endforeach
            </div>
        @endif
        
    <h1></h1>
    <div class="wp-content">
        <h2>Đăng nhập</h2>
        <form action="{{asset('login')}}" method="post" role="form">
            {{ csrf_field() }}
            <input type="email" name="email" placeholder="Email" require="">
            <input type="password" name="password" placeholder="Password" require="">
            <ul class="note_password">
                <li>
                    <input type="checkbox" id="brand1" value="">
					<label for="brand1"><span></span>Remember me</label>
					<a href="#">Forgot password?</a>
                </li>
            </ul>
            @if (session('thongbao'))
                <p style="margin-top:-30px; margin-bottom:15px;">{{session('thongbao')}}</p>
            @endif
            <div class="aitssendbuttonw3ls">
                <input type="submit" value="LOGIN">
            </div>
        </form>
        
    </div>
</body>
</html>