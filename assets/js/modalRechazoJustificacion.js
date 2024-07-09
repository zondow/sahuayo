(function ($) {
    //Variables
    var $link = $('#confirmLink');
    var $tema = $('#confirmTema');

    //Fijar evento
    $('body').on('click','.modal-rechazo',function (e) {
        e.preventDefault();
        var modal = new Custombox.modal({
            content: {
                target: "#rechazoModal",
                effect: "blur"
            },
            overlay: {
                color: "#36404a"
            }
        });

        var $this = $(this);
        $("#justificacionRechazo").attr('action',$this.attr('data-href'));
        $("#rechazoTema").html($this.attr('data-action'));

        // Open
        modal.open();
    });
})(jQuery);