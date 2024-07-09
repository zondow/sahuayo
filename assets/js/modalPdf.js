(function ($) {
    //Mostrar reporte en ventana modal
    $('body').on('click', '.show-pdf',function(evt){
        evt.preventDefault();
        //Mostrar la modal
        var $this = $(this);
        var href = $this.attr("href");
        var title = $this.attr("data-title");
        $("#modalPdf").modal("show");
        $("#modalTitlePdf").text(title);
        $("#iframePdf").attr("src", href);
    });//.show-pdf


    $(".show-pdf-checklist").click(function(e){
        var $this = $(this);
        var href = $this.attr("data-url");
        var title = $this.attr("data-title");

        if(href != "")
        {
            var res = href.split(".");
            var ext = res[res.length-1];

            if(ext == 'pdf')//Show modal if pdf
            {
                $("#modalPdf").modal("show");
                $("#modalTitlePdf").text(title);
                $("#iframePdf").attr("src", href);
            }
            else
            {
                $this.attr("data-lightbox","roadtrip");
                $this.attr("href",href);
            }
        }
        else
        {
            toastr.error("No hay archivo para mostrar")
        }

    });

})(jQuery);