<script>
		$('#scheduler').fullCalendar({
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
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			//defaultDate: '2016-01-15T16:00:00',
			editable: false,
			events: [
				<?php foreach($promociones as $promo):?>
					{

						id: '<?php echo $promo->id ?>',
						title: '<?php echo $promo->promocion_nombre ?>',
						start :'07:00',
						end :'21:00',
						dow: <?php echo $promo->promocion_dias ?>,
						dowstart: new Date('<?php echo $promo->promocion_inicio ?>'),
						dowend: new Date('<?php echo $promo->promocion_fin ?>'),
						color: '<?php echo $promo->promocion_color ?>',
					},
				<?php endforeach; ?>
			]
		});
	</script>

	<script>
    	$(document).ready(function() {
    		$.ajax({
    			url: 'eventos',
    			method: "GET",
    			datatype: "json"
    		}).done(function(response) {
    			var events = [];
    			$.each(response, function(idx, e) {
    				events.push({
    					start: e.start_date_time,
    					end: e.end_date_time,
    					title: e.meeting_title,
    					url: e.web_link
    				});
    			});
    			$('#scheduler').fullCalendar({
    				events: events
    			});
    		});
    	});
    </script>

    	<script>
		/*$('#calendar').fullCalendar({
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
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			//defaultDate: '2016-01-15T16:00:00',
			editable: false,
			events:[
				<?php foreach($promociones as $promo):?>
					{
						id: '<?php echo $promo->id ?>',
						title: '<?php echo $promo->promocion_nombre ?>',
						start :'07:00',
						end :'21:00',
						dow: <?php echo $promo->promocion_dias ?>,
						dowstart: new Date('<?php echo $promo->promocion_inicio ?>'),
						dowend: new Date('<?php echo $promo->promocion_fin ?>'),
						color: '<?php echo $promo->promocion_color ?>',
					},
				<?php endforeach; ?>
			]
		});*/
	</script>
	<script>
		/*$(document).ready(function() {
	
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				//defaultDate: '2015-02-12',
				editable: true,
				eventLimit: true, // allow "more" link when too many events
				events: {
					url: 'eventos',
					error: function() {
						$('#script-warning').show();
					}
				},
				loading: function(bool) {
					$('#loading').toggle(bool);
				}
			});
			
		});*/
	</script>
	<script>
		/*$('#calendar').fullCalendar({
		 	events: function() {
		 		$.ajax({
		 			type: 'GET',
		 			url:'eventos',
		 			dataType: 'json',
		 			success: function(data){
		 				var newEvents = [];
		 				var events = new Object();
		 				$(data).each(function(i, index) {
		 					events = {
		 						id : data[i].id,
		 						title: data[i].promocion_nombre,
		 						start: data[i].promocion_inicio,
		 					}
		 					newEvents.push(events);
		 					$('#calendar').fullCalendar('renderEvent',newEvents[i]);
		 				});
		 			}
		 		});
		 	}
		 });*/
	</script>


	@foreach($promociones as $promo)
				{
					@switch($promo->promocion_repetir)
						@case('A')
							$f_inicio = $promo->promocion_inicio;
							$f_fin = $promo->promocion_inicio;
							$fecha = explode("-",$promo->promocion_inicio);
							$anio = $fecha[2]; //año
							$anio_actual =  date('Y');
							$inicio = str_replace($anio, $anio_actual, $f_inicio);
							$fin = str_replace($anio, $anio_actual, $f_fin);
						@break

						@case('S')
							$f_inicio = $promo->promocion_inicio;
							$f_fin = $promo->promocion_inicio;
							$fecha = explode("-",$promo->promocion_inicio);
							$anio = $fecha[2]; //año
							$anio_actual =  date('Y');
							$inicio = str_replace($anio, $anio_actual, $f_inicio);
							$fin = str_replace($anio, $anio_actual, $f_fin);
						@break

					@endswitch

					id: '{{$promo->id}} ',
					title: '{{$promo->promocion_nombre}}',
					start :'07:00',
					end :'21:00',
					dow: {{$promo->promocion_dias}},
					dowstart: new Date('{{$inicio}}'),
					dowend: new Date('{{$fin}}'),
					color: '{{$promo->promocion_color}}',
				},
			@endforeach


			@foreach($promociones as $promo)
			{
				@switch($promo->promocion_repetir)
					@case('A')
						@php
							$year = date('Y');
							$anio = explode('-', $promo->promocion_inicio);
							$anio = $anio[0];
							$fecha_bd = $promo->promocion_inicio;
							$fecha_c = str_replace($year, $anio, $fecha_bd);

						@endphp
							title: '{{$promo->promocion_nombre}}',
							start : {{ $fecha_c }},
							color: '{{$promo->promocion_color}}',
					@break

					@case('S')
						id: '{{$promo->id}} ',
						title: '{{$promo->promocion_nombre}}',
						start :'07:00',
						end :'21:00',
						dow: {{$promo->promocion_dias}},
						dowstart: new Date('{{$promo->promocion_inicio}}'),
						dowend: new Date('{{$promo->promocion_fin}}'),
						color: '{{$promo->promocion_color}}',
					@break

				@endswitch
			},
			@endforeach


@foreach ($empresas_insert as $empresa)
												<label class="form-check-label">
													<input class="form-check-input" type="checkbox" name="empresas_edit[]" value="{{$empresa->id}}" />{{$empresa->empresa_nombre}} | {{$empresa->ciudad->ciudad_nombre}}
												</label>
												<br>
											@endforeach