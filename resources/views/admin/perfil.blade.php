@extends('admin.plantilla')
	<style>
		a:visited{
			color:#888;
		}
		a{
			color:#444;
			text-decoration:none;
		}
		p{
			margin-bottom:.3em;
		}
		.cc-selector-2 input{ 
			margin: 5px 0 0 12px;
		}
		.cc-selector-2 label{
			margin-left: 7px;
		}
		span.cc{
			color:#6d84b4
		}
	</style>
	@section('content')
	<main class="app-content">
		<div class="app-title">
			<div>
				<h1>Perfil</h1>
			</div>
		</div>
		<div class="user p-3">
			<div class="profile row">
				<div class="info col-12">
					<img id="img-avatar" class="user-img avatar-{{ Auth::User()->perfil->avatar_id }}">
					<br>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Cambiar Avatar</button>
				</div>
				<div class="info p-3 col-12">
					<h4>Cambiar Contraseña</h4>
					<div class="form-group">
						<label for="password_old">Contraseña Actual</label>
						<input type="password" class="form-control" id="password_prev">
						<p class="errorPassword text-center alert alert-danger" style="display: none;"></p>
					</div>
					<div class="form-group">
						<label for="password_new">Contraseña Nueva</label>
						<input type="password" class="form-control" id="password_new">
						<p class="errorPasswordNueva text-center alert alert-danger" style="display: none;"></p>
					</div>
					<div class="form-group">
						<label for="password_new_repeat">Contraseña Nueva Repetir</label>
						<input type="password" class="form-control" id="password_repeat">
						<p class="errorPasswordRepeat text-center alert alert-danger" style="display: none;"></p>
					</div>
					<button class="btn btn-primary change_pass">
						Cambiar Contraseña
					</button>
				</div>
			</div>
		</div>
		<form id="form-avatar">
			{{ csrf_field() }}
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Selecciona tu Avatar</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="cc-selector">
								<div class="row">
									<div class="col-md-3">
										<input id="avatar-5" type="radio" name="avatar" value="5" checked="checked"/>
										<label class="drinkcard-cc avatar-5" for="avatar-5"></label>
									</div>
									<div class="col-md-3">
										<input id="avatar-6" type="radio" name="avatar" value="6" />
										<label class="drinkcard-cc avatar-6" for="avatar-6"></label>
									</div>
									<div class="col-md-3">
										<input id="avatar-7" type="radio" name="avatar" value="7" />
										<label class="drinkcard-cc avatar-7" for="avatar-7"></label>
									</div>
									<div class="col-md-3">
										<input id="avatar-8" type="radio" name="avatar" value="8" />
										<label class="drinkcard-cc avatar-8" for="avatar-8"></label>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-primary">Actulizar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
    </main>

    @endsection