@extends('admin.plantilla')
	@section('content')
		<link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}">
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Menú</h1>
				</div>
			</div>
			<div id="desktop" class="d-none d-md-none d-lg-block d-xl-block">
				<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img class="d-block w-100" src="./images/menu/d-1.jpg" alt="First slide">
						</div>
						@for ($i = 2; $i < 20; $i++)
							<div class="carousel-item">
								<img class="d-block w-100" src="./images/menu/d-{{$i}}.jpg" alt="">
							</div>
						@endfor
					</div>
					<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
			<div id="movil" class="d-block d-md-block d-lg-none d-xl-none">
				<div class="carousel-wrapper" style="background-image: url('./img/login.png');">
					<div class="carousel" data-flickity>
						@for ($i = 1; $i < 20; $i++)
							<div class="carousel-cell d-block d-md-none">
								<img src="./images/menu/m-{{ $i }}.jpg" alt="">
							</div>
						@endfor
					</div>
				</div>
			</div>
		</main>
	@endsection







