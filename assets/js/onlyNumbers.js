$(document).ready(function () {
    $("body").on("click", ".onlyNumbers", function (evt) {
        evt.preventDefault();
        jQuery('.onlyNumbers').keypress(function (tecla) {
            if (tecla.charCode === 46) return true;
            if (tecla.charCode < 48 || tecla.charCode > 57) return false;
        });
    });

});