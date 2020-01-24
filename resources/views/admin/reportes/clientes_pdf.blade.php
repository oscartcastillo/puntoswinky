<style>
table {
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black;
}
.capital{
	text-transform: capitalize;
}
</style>
<h1>Listado de Clientes Winky</h1>
<table>
	<style>
		th{
			font-size: 11px;
			text-align: center;
		}
		td{
			font-size: 10px;
			text-align: center;
		}
	</style>
	<thead>
		<tr>
			<th>No. Tarjeta</th>
			<th>Nombre</th>
			<th>Apellidos</th>
			<th>Correo</th>
			<th>Genero</th>
			<th>Nacimiento</th>
			<th>Telefono</th>
			<th>Compañia</th>
			<th>Tipo</th>
			<th>Estatus</th>
		</tr>
	</thead>
	<tbody>
		@foreach($clientes as $user)
		<tr>
			@php
				$tarjeta_generica = str_pad($user->id, 12, "0", STR_PAD_LEFT);
			@endphp
			@if ($tarjeta_generica == $user->perfil->perfil_tarjeta)
				<td>Sin Tarjeta</td>
			@else
				<td>{{ $user->perfil->perfil_tarjeta}}</td>
			@endif
			<td class="capital">{{ $user->perfil->perfil_nombre}}</td>
			<td class="capital">{{ $user->perfil->perfil_apellidos}}</td>
			<td>{{ $user->email }}</td>
			<td>{{ $user->perfil->perfil_genero}}</td>
			<td>{{ $user->perfil->perfil_nacimiento}}</td>
			<td>{{ $user->perfil->perfil_celular}}</td>
			<td class="capital">{{ $user->perfil->perfil_compania}}</td>
			<td class="capital">{{ $user->perfil->perfil_tipo}}</td>
			<td>{{ $user->estatus}}</td>
		</tr>
		@endforeach
	</tbody>
</table>