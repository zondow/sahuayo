<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!--<script type="text/javascript" src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>-->
    <link href="<?= base_url('assets/libs/spinkit/spinkit.css') ?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js" crossorigin="anonymous"></script>

    <style>
        #chart_div .google-visualization-orgchart-linebottom {
            border-bottom: 4px solid #70bf96;
        }

        #chart_div .google-visualization-orgchart-lineleft {
            border-left: 4px solid #70bf96;
        }

        #chart_div .google-visualization-orgchart-lineright {
            border-right: 4px solid #70bf96;
        }

        #chart_div .google-visualization-orgchart-linetop {
            border-top: 4px solid #70bf96;
        }

        .google-visualization-orgchart-table td {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 10px;
            padding-bottom: 10;
        }

        #chart_div {
            background: rgb(255, 255, 255);
        }

        .miclase {
            color: #ffffff;
            width: 100px;
            background: rgba(107, 145, 153, 0.51);
            border-radius: 18px;
            text-align: center;
            font-family: "Rubik", sans-serif;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 5px;
            padding-bottom: 0;
            border-top-width: 0;
            border-bottom-width: 0;
            font-size: 12px;
        }

        .miclase img {
            clear: both;
            display: block;
            margin: auto;
            border-radius: 18px;
            max-width: 40px;
            max-height: 40px;
        }

        .container {
            width: 450px;
            height: 450px;
        }

        .container2 {
            overflow: auto;
        }
    </style>

    <!--
    border: 1px solid #6c757d;
    azul rgba(112, 191, 150, 0.68)
    verde rgb(154, 193, 31);
    -->

</head>
<div class="container-fluid">

    <div class="card-box">

        <div class="row">
            <div class="col-xl-12">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button id="btnCrearPdf" type="button" class="btn btn-success">Imagen <i class="fe-camera "></i></button>
                </div>
                <div class="btn-group" role="group" aria-label="Basic example" hidden>
                    <button id="bpdf" type="button" class="btn btn-secondary">PDF <i class="mdi mdi-file-pdf-outline"></i></button>
                </div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <div id="spin" class="sk-fading-circle" style="margin-top: 0px;margin-bottom: 0px;margin-left: 10px;">
                        <div class="sk-circle1 sk-circle"></div>
                        <div class="sk-circle2 sk-circle"></div>
                        <div class="sk-circle3 sk-circle"></div>
                        <div class="sk-circle4 sk-circle"></div>
                        <div class="sk-circle5 sk-circle"></div>
                        <div class="sk-circle6 sk-circle"></div>
                        <div class="sk-circle7 sk-circle"></div>
                        <div class="sk-circle8 sk-circle"></div>
                        <div class="sk-circle9 sk-circle"></div>
                        <div class="sk-circle10 sk-circle"></div>
                        <div class="sk-circle11 sk-circle"></div>
                        <div class="sk-circle12 sk-circle"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3">
                <input id="test" class="custom-range" min="1" max="20" value="1" step="1" onchange="showVal(this.value)" type="range" />
            </div>
        </div>



        <div class="row container2" id="mydiv">
            <div class="col-xl-12 container">
                <div id="chart_div" class="pl-4 pr-4"></div>
            </div>
        </div>
    </div>

</div>


<!--------------- Modal  ----------------->
<div id="infoEmpleado" class="modal fade right-bar" style="width: max-content !important;margin: 0 0 0 auto !important; right: 0 !important;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Información del colaborador</h4>
            </div>
            <div class="modal-body" id="bodyInfoEmpleado">
                <div class="thumb-lg member-thumb mx-auto text-center">
                    <img src="" id="imagenPerfil" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                </div>
                <div class="text-center">
                    <h4 class="nombre" id="infoNombre"></h4>
                    <h4 class="numero"><span class="badge badge-blue "> Número de colaborador: <strong><span class="badge badge-blue" id="infoNumero" style="font-size: 13px"></span></strong></span></h4>

                    <span class="text-muted"> Fecha de nacimiento | </span><span id="infoFN"><br></span><br>
                    <span class="text-muted"> Sexo | </span><span id="infoSexo"><br></span><br>
                    <span class="text-muted"> Fecha de ingreso | </span><span id="infoFI"><br></span><br>
                    <span class="text-muted"> Correo | </span><span class="correo"></span><span id="infoCorreo"><br></span><br>
                    <span class="text-muted"> Celular | </span><span class="celular"></span><span id="infoCelular"><br></span><br>
                    <span class="text-muted"> Puesto | </span><span class="celular"></span><span id="infoPuesto"><br></span><br>
                    <span class="text-muted"> Departamento | </span><span class="celular"></span><span id="infoDepartamento"><br></span><br>

                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script>
    $("#spin").hide();

    function setZoom(zoom, el) {
        transformOrigin = [0, 0];
        el = el || instance.getContainer();
        var p = ["webkit", "moz", "ms", "o"],
            s = "scale(" + zoom + ")",
            oString = (transformOrigin[0] * 100) + "% " + (transformOrigin[1] * 100) + "%";

        for (var i = 0; i < p.length; i++) {
            el.style[p[i] + "Transform"] = s;
            el.style[p[i] + "TransformOrigin"] = oString;
        }
        el.style["transform"] = s;
        el.style["transformOrigin"] = oString;
    }

    function showVal(a) {
        var zoomScale = Number(a) / 10;
        setZoom(zoomScale, document.getElementsByClassName('container')[0])
    }
</script>