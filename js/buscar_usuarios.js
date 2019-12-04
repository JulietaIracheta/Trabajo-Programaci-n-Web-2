$(document).ready(function() {
    $('#busca-usuarios').on('keyup','input', function(event) {
        event.preventDefault();
        form_data = $(this).serialize();
        console.log(form_data);

        $.ajax({
            url: 'busca_por_mail.php',
            type: 'POST',
            data: form_data,

            success: function (response) {
                	// console.log(response);
                resultados = JSON.parse(response);
                listado = '';

                resultados.forEach(resultado => {
                    listado += `<tr><td>
								${resultado.nombre}												
								</td>
								<td>
								${resultado.apellido}												
								</td>
								<td>
								${resultado.email}												
								</td>
								<td class="btn-reserva">
								<a class='w3-button w3-round-xlarge w3-green reserva' href='facturacionPorCliente.php?id=${resultado.id}'>Ver facturas</a>											
								</td></tr>`
                })
                $('#resultados').html(listado);
            }



        })
    })
})