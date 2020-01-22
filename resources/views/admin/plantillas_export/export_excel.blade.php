<style>
	table { border-collapse: collapse; border-spacing: 0; }
	h1 { 
	  font-weight: bold;
	  font-size: 2.5rem;
	  line-height: 1.7em;
	  margin-bottom: 10px;
	  text-align: center;
	}
	#wrapper {
	  display: block;
	  background: #fff;
	  margin: 0 auto;
	  -webkit-box-shadow: 2px 2px 3px -1px rgba(0,0,0,0.35);
	}

	#keywords {
	  margin: 0 auto;
	  font-size: 12px;
	  margin-bottom: 15px;
	}
	#keywords thead {
	  cursor: pointer;
	  background: #c9dff0;
	}
	#keywords thead tr th { 
	  font-weight: bold;
	}
	td{
		border: 1px solid black;
	}
	#keywords thead tr th span { 
	  background-repeat: no-repeat;
	  background-position: 100% 100%;

	}
</style>
<table id="keywords" cellspacing="0" cellpadding="0">
	<thead>
		@if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
			<tr>
				<td colspan="13">
					<h1>Listado de Colaboradores Winky Coffee</h1>
				</td>
			</tr>
			<tr>
				<th><span>Puesto</span></th>
				<th><span>Correo</span></th>
				<th><span>Estatus</span></th>
				<th><span>Nombre</span></th>
				<th><span>Apellidos</span></th>
				<th><span>Tarjeta</span></th>
				<th><span>Genero</span></th>
				<th><span>Nacimiento</span></th>
				<th><span>Telefono</span></th>
				<th><span>Compañia</span></th>
				<th><span>Tipo</span></th>
				<th><span>Sucursal</span></th>
				<th><span>Ciudad</span></th>
			</tr>
		@else
			<tr>
				<td colspan="10">
					<h1>Listado de Colaboradores Winky Coffee</h1>
				</td>
			</tr>
			<tr>
				<th><span>No. Tarjeta</span></th>
				<th><span>Nombre</span></th>
				<th><span>Apellidos</span></th>
				<th><span>Correo</span></th>
				<th><span>Genero</span></th>
				<th><span>Nacimiento</span></th>
				<th><span>Telefono</span></th>
				<th><span>Compañia</span></th>
				<th><span>Tipo</span></th>
				<th><span>Estatus</span></th>
			</tr>
		@endif
	</thead>
	<tbody>
		@foreach($data as $user)
		<tr>
			@if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->estatus}}</td>
				<td>{{ $user->perfil->perfil_nombre}}</td>
				<td>{{ $user->perfil->perfil_apellidos}}</td>
				<td>{{ $user->perfil->perfil_tarjeta}}</td>
				<td>{{ $user->perfil->perfil_genero}}</td>
				<td>{{ $user->perfil->perfil_nacimiento}}</td>
				<td>{{ $user->perfil->perfil_celular}}</td>
				<td>{{ $user->perfil->perfil_compania}}</td>
				<td>{{ $user->perfil->perfil_tipo}}</td>
				<td>{{ $user->perfil->empresa->empresa_nombre}}</td>
				<td>{{ $user->perfil->ciudad->ciudad_nombre}}</td>
			@else
				<td>{{ $user->perfil->perfil_tarjeta}}</td>
				<td>{{ $user->perfil->perfil_nombre}}</td>
				<td>{{ $user->perfil->perfil_apellidos}}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->perfil->perfil_genero}}</td>
				<td>{{ $user->perfil->perfil_nacimiento}}</td>
				<td>{{ $user->perfil->perfil_celular}}</td>
				<td>{{ $user->perfil->perfil_compania}}</td>
				<td>{{ $user->perfil->perfil_tipo}}</td>
				<td>{{ $user->estatus}}</td>
			@endif
		</tr>
		@endforeach
	</tbody>
</table>