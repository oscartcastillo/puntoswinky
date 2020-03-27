<style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  color: #333;
}
table {
  text-align: left;
  line-height: 40px;
  border-collapse: separate;
  border-spacing: 0;
  width: 500px;
  margin: 10px auto;
  border-bottom: 2px solid black;
}
th:first-child,
td:first-child {
  padding: 0 15px 0 20px;
  font-weight: bold;
}
th {
  font-weight: 500;
}
thead tr:last-child th {
  border-bottom: 3px solid #ddd;
}
tbody tr:last-child td {
  border: none;
}
td:last-child {
  text-align: right;
  padding-right: 10px;
}
</style>
<table>
    <thead>
        <tr>
            <th colspan="3">
                <img width="160" src="{{ asset('img/logo.png') }}" alt="logo winky">
            </th>
        </tr>
    </thead>
    <tbody>
        <tr><td colspan="3" align="center" style="font-size: 16px;">TICKETS PUNTOS DE LEALTAD</td></tr>
        <tr><td colspan="3" align="center" style="font-size: 16px;">TRANSACCIÓN</td></tr>
        <tr><td colspan="3" style="text-align: left;">{{ Auth::User()->perfil->ciudad->ciudad_nombre }}. Pue {{ Auth::User()->perfil->empresa->empresa_cp }}</td></tr>
        <tr><td colspan="3" style="text-align: left;">{{ Auth::User()->perfil->empresa->empresa_ubicacion }}</td></tr>
        <tr><td colspan="3" style="text-align: left;">Tel : {{ Auth::User()->perfil->empresa->empresa_numero }}</td></tr>
        <tr>
          <td colspan="2">Movimiento</td>
          <td>{{ $transaccion->transaccion_ticket }}</td>
        </tr>
        <tr>
          <td colspan="2">Fecha de operación</td>
          <td><?php echo date('d-m-Y')?></td>
        </tr>
        <tr>
          <td colspan="2">Descripción de la transacción</td>
          <td>{{ $transaccion->transaccion_fecha }}</td>
        </tr>
        <tr>
            <td colspan="2">Cantidad</td>
            <td>{{ $transaccion->transaccion_cantidad }}</td>
        </tr>
        <tr>
            <td colspan="2">Abono</td>
            <td>{{ $transaccion->transaccion_abono }}</td>
        </tr>
        <tr>
            <td colspan="2">Tipo</td>
            <td>{{ $transaccion->transaccion_tipo }}</td>
        </tr>
        <tr>
            <td colspan="2">Descripción</td>
            <td>{{ $transaccion->transaccion_descripcion }}</td>
        </tr>
        <tr>
            <td colspan="2">Premio</td>
            <td>{{ @$transaccion->premio->premio_nombre }}</td>
        </tr>
        <tr>
            <td colspan="2">Nombre Promoción</td>
            <td>{{ @$transaccion->promocion->promocion_nombre }}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
      <tr>
        <th colspan="3">
          Datos Cliente
        </th>
      </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">Cliente :</td>
            <td>{{ $user->perfil->full_name }}</td>
        </tr>
        <tr>
            <td colspan="2">Tarjeta :</td>
            <td>{{ $tarjeta = (strlen($user->perfil->perfil_tarjeta) < 10) ? '' : $user->perfil->perfil_tarjeta }}</td>
        </tr>
        <tr>
            <td colspan="2">Puntos Acumulados :</td>
            <td>{{ @$puntos }}</td>
        </tr>
        <tr style="height: 100px;">
            <td valign="botton" colspan="3" style="font-size: 10px; text-align: center;">www.winky.mx</td>
        </tr>
    </tbody>
</table>