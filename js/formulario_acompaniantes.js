$(document).ready(function() {
    var cant_acompaniantes;

    $('#reserva-lugares').on('change', '#acompaniantes',function (event) {
        event.preventDefault();
        cant_acompaniantes = $('#acompaniantes').val();
        // console.log(cant_acompaniantes);
        genera_formularios();
    })

    $('#reserva-lugares').on('keyup', '#acompaniantes', function (event) {
        event.preventDefault();
        cant_acompaniantes = $('#acompaniantes').val();
        console.log(cant_acompaniantes);
        genera_formularios();
    })

    var genera_formularios = function () {
        // console.log(cant_acompaniantes);
        formulario = '';

        if(cant_acompaniantes>1){
            var i=0;
            formulario += '<p>Ingrese el nombre y correo de los acompañantes, para que puedan loguearse en el sistema y pedir turno para el chequeo médico</p>';
            for(i;i<cant_acompaniantes-1;i++){
                formulario += `
                <div class="caja">
                <label class="acompaniante">Nombre: </label><input type="text" name="nombre[]" value=""><br>
                <label class="acompaniante">Apellido: </label><input type="text" name="apellido[]" value=""><br>
                <label class="acompaniante">E-mail: </label><input type="text" name="email[]" value="">
                </div>`
            }
        }

        $('#area-formularios').html(formulario);
    }
});