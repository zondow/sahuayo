(function ($) {
    // Variables
    var $link = $('#confirmLink');
    var $tema = $('#confirmTema');

    // Fijar evento
    $('body').on('click', '.modal-confirmation', function (e) {
        e.preventDefault();

        var $this = $(this);

        // Asignar la URL y el tema a los elementos del modal
        $link.attr('href', $this.attr('href'));
        $tema.html($this.attr('data-action'));

        // Abrir el modal
        $('#confirmModal').modal('show');
    });
})(jQuery);

/*(function ($) {
    //Variables
    var $link = $('#confirmLink');
    var $tema = $('#confirmTema');

    //Fijar evento
    $('body').on('click','.modal-confirmation',function (e) {
        e.preventDefault();
        var modal = new Custombox.modal({
            content: {
                target: "#confirmModal",
                effect: "blur"
            },
            overlay: {
                color: "#36404a"
            }
        });

        var $this = $(this);
        $link.attr('href', $this.attr('href'));
        $tema.html($this.attr('data-action'));

        // Open
        modal.open();
    });
})(jQuery);*/