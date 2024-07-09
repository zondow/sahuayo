$(document).ready(function (e) {

    $.ajax({
        url: BASE_URL + "Personal/ajax_regresarEmpleados",
        async: false,
        dataType: "json"
    }).done(function (data) {
        if (data.response == "success") {
            var datab = data.result;
            var datac = data.general;
            google.charts.load('current', { packages: ["orgchart"] });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Name');
                data.addColumn('string', 'Manager');
                data.addColumn('string', 'ToolTip');
                arr2 = [];
                $.each(datab, function (index, item) {
                    if (item.Jefe == null) {
                        item.Jefe = "";
                    }
                    if (item.Jefe == 0) {
                        item.Jefe = "";
                    }
                    img = item.fotoperfil;
                    if (item.emp_Nombre == item.Jefe) {
                        arr2.push([{ 'v': item.emp_Nombre, 'f': item.emp_Nombre + '<img src="' + img + '" /><div style="color:#000000; font-style:italic">' + item.pue_Nombre + '<br><button style="background-color: transparent;border: transparent" class="btn-outline-dark  waves-light waves-effectmd abrirmodal" data-empleado="' + item.emp_EmpleadoID + '"> <i class="dripicons-information" style="font-size:15px"></i></button><br></div>' }, '', '' + item.emp_Nombre])
                    } else {
                        arr2.push([{ 'v': item.emp_Nombre, 'f': item.emp_Nombre + '<img src="' + img + '" /><div style="color:#000000; font-style:italic">' + item.pue_Nombre + '<br><button style="background-color: transparent;border: transparent" class="btn-outline-dark  waves-light waves-effectmd abrirmodal" data-empleado="' + item.emp_EmpleadoID + '"> <i class="dripicons-information" style="font-size:15px"></i></button><br></div>' }, '' + item.Jefe, '' + item.emp_Nombre])
                    }
                });
                img = datac.fotoperfil;
                arr2.push([{ 'v': datac.nombre, 'f': datac.nombre + '<img src="' + img + '" /><div style="color:#000000; font-style:italic">' + datac.puesto + '<br><button style="background-color: transparent;border: transparent" class="btn-outline-dark  waves-light waves-effectmd abrirmodal" data-empleado="' + datac.Ejf + '"> <i class="dripicons-information" style="font-size:15px"></i></button><br></div>' }, '', '' + datac.nombre])
                data.addRows(arr2);
                // Create the chart.
                var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
                // Draw the chart, setting the allowHtml option to true for the tooltips.
                chart.draw(data, { 'allowHtml': true, nodeClass: 'miclase', allowCollapse: true, size: 'small' });
                showVal(5)
            }

        } else {
            //alert("No hay datos de empleados")
            $.toast({
                text: "No hay datos de colaborador",
                icon: "warning",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }
    });

    $('body').on('click', '.abrirmodal', function (evt) {
        evt.preventDefault();
        id = $(this).data('empleado');
        $.ajax({
            url: BASE_URL + "Personal/ajax_getInfoEmpleado/" + id,
            type: "POST",
            async: true,
            cache: false,
            dataType: "json"
        }).done(function (data) {

            if (data.response === "success") {
                if (data.result.emp_Numero == null) { data.result.emp_Numero = 'N/A' }
                if (data.result.emp_Sexo == null) { data.result.emp_Sexo = 'N/A' }
                if (data.result.emp_FechaNacimiento === '0000-00-00') { data.result.emp_FechaNacimiento = 'N/A' }
                if (data.result.emp_Celular == null || data.result.emp_Celular === 0) { data.result.emp_Celular = 'N/A' }
                if (data.result.emp_Correo == null) { data.result.emp_Correo = 'N/A' }
                if (data.result.pue_Nombre == null) { data.result.pue_Nombre = 'N/A' }
                if (data.result.dep_Nombre == null) { data.result.dep_Nombre = 'N/A' }
                if (data.result.emp_FechaIngreso === '0000-00-00') { data.result.emp_FechaIngreso = 'N/A' }

                $("#imagenPerfil").attr("src", data.url);
                $("#infoNombre").html(data.result.emp_Nombre);
                $("#infoNumero").html(data.result.emp_Numero);
                $("#infoFN").html(data.result.emp_FechaNacimiento);
                $("#infoCelular").html(data.result.emp_Celular);
                $("#infoCorreo").html(data.result.emp_Correo);
                $("#infoSexo").html(data.result.emp_Sexo);
                $("#infoFI").html(data.result.emp_FechaIngreso);
                $("#infoPuesto").html(data.result.pue_Nombre);
                $("#infoDepartamento").html(data.result.dep_Nombre);
            }
        });
        $("#infoEmpleado").modal("show");


    });

    /// prueba
    $('body').on('click', '#btnCrearPdf', function (evt) {
        evt.preventDefault();
        $("#spin").show();
        const $elementoParaConvertir = document.querySelector("#mydiv"); // <-- Aquí puedes elegir cualquier elemento del DOM

        // Ajustar el tamaño del contenedor al tamaño del organigrama
        const organigramaWidth = $elementoParaConvertir.offsetWidth;
        const organigramaHeight = $elementoParaConvertir.offsetHeight;
        $elementoParaConvertir.style.width = `${organigramaWidth}px`;
        $elementoParaConvertir.style.height = `${organigramaHeight}px`;

        html2pdf()
            .set({
                /*
                margin: 1,
                filename: 'Organigrama.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 1, // A mayor escala, mejores gráficos, pero más peso
                    letterRendering: true,
                },
                jsPDF: {
                    unit: "in",
                    format: [organigramaWidth / 10, organigramaHeight / 20], // Tamaño del PDF en pulgadas
                    orientation: 'landscape' // landscape o portrait
                }
                */
                margin: 1,
                filename: 'Organigrama.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 1, // A mayor escala, mejores gráficos, pero más peso
                    letterRendering: true,
                },
                jsPDF: {
                    unit: "in",
                    format: "a0",
                    orientation: 'landscape' // landscape o portrait
                }
            })
            .from($elementoParaConvertir)
            .save()
            .catch(err => console.log(err))

            setTimeout(function(){
                $("#spin").hide();
            }, 1000);

        $elementoParaConvertir.style.width = "";
        $elementoParaConvertir.style.height = "";
    })  


});