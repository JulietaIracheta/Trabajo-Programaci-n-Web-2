$(document).ready(function() {
	var form_data;

	$('#campos-tarjeta').submit(function(event) {
		event.preventDefault();
		form_data = $(this).serialize();
		console.log(form_data);

		$.ajax({
			url: 'pago_tarjeta.php',
			type: 'POST',
			data: form_data,
			success: function (response) {
				resultados = JSON.parse(response);
				console.log(response);

				if(resultados.estado == "ok"){
					area_mensaje ='<div class="w3-panel ' + resultados.clase +' dialogo">' + resultados.mensaje + '</div>';
					$('#mensaje').html(area_mensaje);
					$('#btn-accion').hide();
				}
				else {
					area_mensaje ='<div class="w3-panel ' + resultados.clase +' dialogo">' + resultados.mensaje + '</div>';
					$('#mensaje').html(area_mensaje);
				}
			}
		})
	})
});