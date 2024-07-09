$(document).ready(function (e) {
    //Minimizar un panel individualmente
    $(".minimize").click(function(e){

        var collapse = $(this).data("contenido");
        $("#"+collapse).slideUp();
    });//.minimize.click

    //Maximizar un panel individualmente
    $(".maximize").click(function(e){
        var collapse = $(this).data("contenido");
        $("#"+collapse).slideDown();

    });//.maximize.click

    //Minimizar todos los paneles
    $("#minimizar").click(function(e){
        e.preventDefault();
        $(".collapse").slideUp();
    });//minimizar.click

    //Maximizar todos los paneles
    $("#expandir").click(function(e){
        e.preventDefault();
        $(".collapse").slideDown();
    });//expandir.click
});