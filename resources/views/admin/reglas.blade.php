@extends('admin.plantilla')
	@section('content')
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1><i class="fa fa-file-text-o"></i> Reglas del Programa </h1>
				</div>
			</div>
			<div class="row user">
				<iframe width="100%" height="800px" src="{{asset('files/ReglamentoLealtadPuntos.pdf')}}"></iframe>
			</div>
		</main>
	@endsection