$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault();
        form_data = $(this).serialize();
        console.log(form_data);

        $.ajax({
            url: 'control_reservas_pasajes.php',
            type: 'POST',
            data: form_data,
            success: function (response) {
                resultados = JSON.parse(response);

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
})