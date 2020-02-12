@extends('admin.plantilla')
	@section('content')
		<link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}">
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Menú</h1>
				</div>
			</div>
			<div class="carousel-wrapper" style="background-image: url('./img/login.png');">
				<div class="carousel" data-flickity>
					@for ($i = 1; $i < 27; $i++)
						<div class="carousel-cell">
							<img src="./images/menu/{{ $i }}.jpg" alt="">
						</div>
					@endfor
				</div>
			</div>
		</main>
	@endsection







