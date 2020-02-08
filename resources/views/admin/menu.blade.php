@extends('admin.plantilla')
	@section('content')
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Menu</h1>
				</div>
			</div>

			<style>
				@import url("https://fonts.googleapis.com/css?family=Hind:400,700");
				img {
					max-width: 100%;
					height: auto;
					display: block;
				}
				h3 {
					text-align: center;
					font-weight: 400;
					margin-bottom: 0;
				}
				.carousel-wrapper {
					position: relative;
					width: 70%;
					height: 70%;
					top: 50%;
					left: 50%;
					transform: translate(-50%, -50%);
					background-color: #FFFFFF;
					/*background-image: linear-gradient(#FFFFFF 50%, #FFFFFF 50%, #F0F3FC 50%);*/
					box-shadow: 0px 12px 39px -19px rgba(0, 0, 0, 0.75);
					overflow: hidden;
				}
				.carousel-wrapper .carousel {
					position: absolute;
					top: 50%;
					transform: translateY(-50%);
					width: 100%;
					height: auto;
				}
				.carousel-wrapper .carousel .carousel-cell {
					padding: 10px;
					background-color: #FFFFFF;
					width: 20%;
					height: auto;
					min-width: 120px;
					margin: 0 20px;
					transition: transform 500ms ease;
				}
				.carousel-wrapper .carousel .carousel-cell .more {
					display: block;
					opacity: 0;
					margin: 5px 0 15px 0;
					text-align: center;
					font-size: 10px;
					color: #CFCFCF;
					text-decoration: none;
					transition: opacity 300ms ease;
				}
				.carousel-wrapper .carousel .carousel-cell .more:hover, .carousel-wrapper .carousel .carousel-cell .more:active, .carousel-wrapper .carousel .carousel-cell .more:visited, .carousel-wrapper .carousel .carousel-cell .more:focus {
					color: #CFCFCF;
					text-decoration: none;
				}
				.carousel-wrapper .carousel .carousel-cell .line {
					position: absolute;
					width: 2px;
					height: 0;
					background-color: black;
					left: 50%;
					margin: 5px 0 0 -1px;
					transition: height 300ms ease;
					display: block;
				}
				.carousel-wrapper .carousel .carousel-cell .price {
					position: absolute;
					font-weight: 700;
					margin: 45px auto 0 auto;
					left: 50%;
					transform: translate(-50%);
					opacity: 0;
					transition: opacity 300ms ease 300ms;
				}
				.carousel-wrapper .carousel .carousel-cell .price sup {
					top: 2px;
					position: absolute;
				}
				.carousel-wrapper .carousel .carousel-cell.is-selected {
					transform: scale(1.2);
				}
				.carousel-wrapper .carousel .carousel-cell.is-selected .line {
					height: 35px;
				}
				.carousel-wrapper .carousel .carousel-cell.is-selected .price, .carousel-wrapper .carousel .carousel-cell.is-selected .more {
					opacity: 1;
				}
				.carousel-wrapper .flickity-page-dots {
					display: none;
				}
				.carousel-wrapper .flickity-viewport, .carousel-wrapper .flickity-slider {
					overflow: visible;
				}
			</style>
			<div class="row">
				<div class="carousel-wrapper">
					<div class="carousel" data-flickity>
						<div class="carousel-cell">
							<img src="https://images.unsplash.com/photo-1464305795204-6f5bbfc7fb81?dpr=2&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=" />
						</div>
						<div class="carousel-cell">
							<img src="https://images.unsplash.com/photo-1464305795204-6f5bbfc7fb81?dpr=2&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=" />
						</div>
						<div class="carousel-cell">
							<img src="https://images.unsplash.com/photo-1464305795204-6f5bbfc7fb81?dpr=2&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=" />
						</div>
					</div>
				</div>
			</div>
		</main>
	@endsection







