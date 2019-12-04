$(window).on( "load", function() {
    console.log( "window loaded" );

    $('body div.container table').on("load", 'button.reserva', function(event) {
        console.log(this);
        $(this).show();
    })
});