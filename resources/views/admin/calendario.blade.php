<div id='calendar'></div>
<script>
	$('#calendar').fullCalendar({
		eventRender: function(event, element, view) {
			var theDate = event.start
			var endDate = event.dowend;
			var startDate = event.dowstart;
			if (theDate >= endDate) {
				return false;
			}
			if (theDate <= startDate) {
				return false;
			}
		},
		defaultView: 'month',
		header: {
			left: 'prev,next today',
			center: 'title'
		},
		editable: false,
		events: [
			@foreach($promociones as $promo)
				@switch($promo->promocion_repetir)
					@case('A')
						@php
							$year = date('Y');
							$fecha = explode('-', $promo->promocion_inicio);
							
							$mes = $fecha[1];
							$dia = $fecha[2];

						@endphp
						@for ($i = $year ; $i < $year + 2  ; $i++)
						{
							@php
								$fecha_c = $i . "-" . $mes . "-" . $dia ;
							@endphp
							
							title: '{{$promo->promocion_nombre}}',
							start : '{{ $fecha_c }}',
							color: '{{$promo->promocion_color}}',
							
						},
								
						@endfor
		
					@break

					@case('D')
					@php
						$fecha_ini =  date("Y-m-d H:i:s",strtotime($promo->promocion_inicio."- 1 days"));
					@endphp
							{
								id: '{{$promo->id}} ',
								title: '{{$promo->promocion_nombre}}',
								allDay: true,
								dow: [ {{$promo->promocion_dias}} ],
								dowstart: new Date('{{$fecha_ini}}'),
								dowend: new Date('{{$promo->promocion_fin}}'),
								color: '{{$promo->promocion_color}}',
							},
							
					@break

				@endswitch
			@endforeach
		]
	});
</script>
