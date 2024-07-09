$(document).ready(function (e) {

    var $formNuevo=$('#formNuevo');
    var $inp1=$('#password');
    var $inp2=$('#password2');
    var $id=$('#id');

    //Alain - Guardar nueva contraseña
    $('body').on('click', '#btnguardar',function(evt){
        evt.preventDefault();


        $formNuevo[0].reportValidity();

        if ($formNuevo[0].checkValidity()){

            if($inp1.val()===$inp2.val()){

                var data2 = {}
                data2.password=$inp1.val();
                data2.id=EMP_id;

                $.ajax({
                    url: BASE_URL + "Access/ajax_nuevopassword/",
                    type: "POST",
                    data: data2,
                    success: function(data){
                        window.location.replace(BASE_URL+"Access/recuperarE");
                    }
                })

            }else{
                $.toast({
                    text: "Las contraseñas no son iguales. Por favor Inténtelo de nuevo.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                    hideAfter: false,
                    stack: false
                });
                $formNuevo[0].reset();
            }

        }

    });

});