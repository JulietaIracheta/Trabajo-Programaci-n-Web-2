$(document).ready(function() {

  /* Cambia de color segun se haya seleccionado o no un asiento */
    $('input[type=checkbox]').on('change', function() {
        if ($(this).is(':checked') ) {
            var seleccionado = $(this).parent();
            $(seleccionado).removeClass('vacante');
            $(seleccionado).addClass('seleccionado');
        } else {
            var seleccionado = $(this).parent();
            $(seleccionado).removeClass('seleccionado');
            $(seleccionado).addClass('vacante');
        }
    });

  /*************************************************************************************************/
  /* Persisto en la Bd los asientos seleccionados */

    $('#ubicacion_asientos').submit(function(event) {
        event.preventDefault();
        form_data = $(this).serialize();
        console.log(form_data);
        $.ajax({
            url: 'reserva_asiento.php',
            type: 'POST',
            data: form_data,
            // success:
                // function(html){
                // $("#mensaje").html(html);
            // }
            success: function (response) {
                resultados = JSON.parse(response);

                if(resultados.estado == "ok"){
                    area_mensaje ='<div class="w3-panel ' + resultados.clase +' dialogo">' + resultados.mensaje + '</div>';
                    $('#mensaje').html(area_mensaje);
                    $('#btn-accion').hide();
                    area_codigo = '<div>' +
                                  '<a href="codigo-qr.php?codigo_reserva=' + resultados.codigo_reserva + '">'
                                  + resultados.qr + '</a><p class="aviso_qr">Haga click sobre la imagen<br>para poder realizar<br>un escaneo QR<br>de la misma</p>' +
                                  '</div>' +
                                  '<div><p class="etiqueta">Asientos seleccionados</p>' + resultados.asientos + '<br>' +
                                  '<p class="etiqueta">Código de Embarque</p><p class="embarque">' + resultados.codigo_embarque + '</p></div>';
                    $('#codigo').html(area_codigo);
                }
                else{
                    area_mensaje ='<div class="w3-panel ' + resultados.clase +' dialogo">' + resultados.mensaje + '</div>';
                    $('#mensaje').html(area_mensaje);
                }

            }
        })
    })


});
