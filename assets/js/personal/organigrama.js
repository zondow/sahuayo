$(document).ready(function (e) {

    $.ajax({
        url: BASE_URL + "Personal/ajaxEmpleadosOrganigrama",
        type: "POST",
        dataType: "json"
    }).done(function (data) {
        var chart = new OrgChart(document.getElementById("tree"), {
            template: 'isla',
            layout: OrgChart.tree,
            scaleInitial:OrgChart.match.boundary,
            enableSearch: {
                searchField: "field_0",
                autoOpen: true,
                fullTextSearch: false,
                caseSensitive: false,
                hideNoResults: true,
            },
            align: OrgChart.ORIENTATION,
            toolbar: {
                layout: true,
                zoom: true,
                fit: true,
                expandAll: true
            },
            nodeBinding: {

                field_0: "Nombre",
                field_1: "Puesto",
                img_0: "img",
                field_2: "Departamento",

            },nodeMenu: {
                details: { text: "Detalles", tooltip: "Dealles"},

            },
            editForm: {
                buttons: {
                    edit: null,
                    share: null,
                    pdf: null,
                    remove: null
                }
            },
            enableDragDrop: false,
            collapse: {
                level: 2,
                allChildren: true
            },
            //mouseScrool: OrgChart.action.scroll,
            menu: {
                pdfPreview: {
                    text: "PDF Preview",
                    onClick: preview
                },
                pdf: { text: "Exportar PDF" },
                png: { text: "Exportar PNG" },
                svg: { text: "Exportar SVG" },
                csv: { text: "Exportar CSV" }
            },
           
            nodes:data.empleados
            
        });

        chart.on('init', function(){
            sender.toolbarUI.showLayout();
            
        });

        function preview(){
            OrgChart.pdfPrevUI.show(chart, {
                format: 'A4',
            
            });
        }

        
       
    });


});