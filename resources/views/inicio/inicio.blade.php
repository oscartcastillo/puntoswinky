<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="csrf-token" content="{{ csrf_token() }}">
	    <title>{{ config('app.name', 'Laravel') }}</title>
	    <!--<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">-->
	    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
	    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700&display=swap" rel="stylesheet"> 
	    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	    <link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	</head>
	<body class="app sidebar-mini rtl">
		<div class="form-body">
	        <div class="form-holder">
	            <div class="form-content">
	                <div class="form-items">
	                	<div class="logo text-center">
	                        <a href="">
	                            <img class="img-fluid" src="{{asset('img/logo.png')}}">
	                        </a>
	                    </div>
	                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
	                    	{{ csrf_field() }}
	                    	@if ($errors->has('email'))
	                    		<div class="p-3 mb-2 bg-danger text-white">{{ $errors->first('email') }}</div>
	                    	@endif
	                    	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} text-center">
	                    		<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
	                    		<label for="email">Correo electronico</label>
	                    	</div>
	                    	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} text-center" >
	                    		<input type="password" class="form-control" name="password" id="password" required>
	                    		<label for="pasword">Contraseña</label>
	                    	</div>
	                        <div class="form-group">
	                            <a class="contr" href="{{ route('password.request') }}">Olvidaste tu contraseña ?</a>
	                            <input class="btn ingresa" type="submit" value="Ingresar">
	                        </div>
	                    </form>
	                	<div class="sociales row">
	                		<div class="col-md-4 text-center">
	                			<a href=""><i class="fab fa-twitter"></i></a>
	                		</div>
	                		<div class="col-md-4 text-center">
	                			<a href=""><i class="fab fa-facebook-f"></i></a>
	                		</div>
	                		<div class="col-md-4 text-center">
	                			<a href=""><i class="fab fa-instagram"></i></a>
	                		</div>
		                </div>
	                </div>
	            </div>
	        </div>
	    </div>
		<script src="{{ asset('js/jquery-3.2.1.min.js')}}"></script>
		<script src="{{ asset('js/bootstrap.min.js')}}"></script>
	</body>
</html>