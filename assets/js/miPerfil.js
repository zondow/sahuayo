$(document).ready(function () {


    var url = $('#wizardPicturePreview').attr('src');//Foto que tenia el user
    var fileProfilePhoto = $("#fileProfilePhoto");//Area upload foto de perfil
    var txtPassword = $("#txtPassword");

    fileProfilePhoto.change(function () {
        //Verificar si sube una imagen de perfil

        var file = this.files.length;
        if (file == 1) {
            var typeDoc = this.files[0].type;
            if (typeDoc == "image/png" || typeDoc == "image/jpeg") {
                readURL(this);
                //Ajax update account
                $.ajax({
                    url: BASE_URL + 'Usuario/ajax_fotoPerfil/',
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'post',
                    dataType: 'json',
                    data: new FormData(document.getElementById('frmMiCuenta'))
                }).done(function (data) {
                    if (data.code === 1) {
                        toastr("La imagen se actualizó correctamente","success");
                        setTimeout(function (e) {
                            location.reload();
                        }, 1500);
                    }
                    else {
                        toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","info");
                    }

                }).fail(function (data) {
                    toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","info");
                }).always(function (e) {

                });//Peticion ajax

            }
            else {
                fileProfilePhoto.val('');
                toastr("Solo se permiten imagenes", 'warning');
                $('#wizardPicturePreview').attr('src', url).fadeIn('slow');
            }
        }
        else {
            $('#wizardPicturePreview').attr('src', url).fadeIn('slow');
        }

    });//fileProfilePhoto

    $("#btnactualizarPw").click(function (e) {
        if(validatePassword()){
            $("#lblPassword").html("");
            var fd = new FormData();
            fd.append("pw",txtPassword.val().trim())

            $.ajax({
                url: BASE_URL + "Usuario/ajax_actualizarPassword",
                cache: false,
                contentType: false,
                processData: false,
                type: 'post',
                dataType: 'json',
                data: fd
            }).done(function (data) {
                if (data.code === 1) {
                    toastr("¡ La contraseña se actualizó correctamente !","success");
                    setInterval(function (e) {
                        location.reload();
                    }, 1500);

                }
                else
                {
                    toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","info");
                }//if-else
            }).fail(function (data) {
                toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","info");
            }).always(function (e) {

            });//ajax
        }
    });

    //Ver-ocultar password
    $("#lblEye").click(function (e) {
        var icon = $(this).attr('class');

        if (icon == "fa fa-eye-slash") {
            $(this).attr('class', 'fa fa-eye');
            $("#txtPassword").attr("type", "text");
        }
        else {
            $(this).attr('class', 'fa fa-eye-slash');
            $("#txtPassword").attr("type", "password");
        }

    });//inputPw


    /*===================================FUNCTIONS=====================================*/

    //Cargar imagen
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }//readURL

    /*=============================VALIDATION==========================================*/

    var longitud = false,
    minuscula = false,
    numero = false,
    mayuscula = false;

    $('#txtPassword').keyup(function() {
        // set password variable
        var pswd = $(this).val();
        //validate the length
        if ( pswd.length < 8 ) {
            $('#length').removeClass('valid').addClass('invalid');
            longitud = false;
        } else {
            $('#length').removeClass('invalid').addClass('valid');
            longitud = true;
        }

        //validate letter
        if ( pswd.match(/[A-z]/) ) {
            $('#letter').removeClass('invalid').addClass('valid');
            minuscula = true;
        } else {
            $('#letter').removeClass('valid').addClass('invalid');
            minuscula = false;
        }

        //validate capital letter
        if ( pswd.match(/[A-Z]/) ) {
            $('#capital').removeClass('invalid').addClass('valid');
            mayuscula = true;
        } else {
            $('#capital').removeClass('valid').addClass('invalid');
            mayuscula = false;
        }

        //validate number
        if ( pswd.match(/\d/) ) {
            $('#number').removeClass('invalid').addClass('valid');
            numero = true;
        } else {
            $('#number').removeClass('valid').addClass('invalid');
            numero = false;
        }

    }).focus(function() {
        $('#pswd_info').show();
    }).blur(function() {
        $('#pswd_info').hide();
    });

    //Validar inputs
    function validatePassword() {
        var pw = txtPassword.val().trim();
        var lblPassword = $("#lblPassword");
        var response = false;

        //Validar pw
        if (pw == "") {

            lblPassword.html("*Este campo es requerido");
        }
        else {
            if(longitud && minuscula && numero && mayuscula){
                lblPassword.html("*Password correcto.");
                response = true;
            }
            else {

                lblPassword.html("*Password invalido.");
            }
        }
        return response;
    }//inputValidate

    $('#recibosNomina').jstree({
        get_selected: true,
        'core' : {
            'data' : {
                url:  BASE_URL+'Usuario/ajax_GetRecibosNomina',
                type: "POST",
                dataType : "json",
            }
        }
    }).on('select_node.jstree', function (e, data) {
        data.node; // this is the selected node
        //console.log(data.node.a_attr.href);
        window.open(data.node.a_attr.href);
    });

    function toastr(txt, tipo) {
        $.toast({
            text: txt,
            icon: tipo,
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose: true,
        });
    }//toastr
});