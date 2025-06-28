<script src="<?= base_url() ?>/assets/gap/js/jquery.validate.js"></script>
<style>
    .title-infoS {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .btnACt {
        float: right;
        margin-right: 15px;
        margin-top: 20px;
    }

    .card-round {
        border-radius: 5px;
        width: 100px;
        max-width: 100px;
    }

    .Siniestro-body {
        display: inline-block;
    }

    .box.first {
        float: left;
    }

    .edit {
        margin-bottom: unset !important;
    }

    dd button {
        margin-top: 10px;
    }

    .edit dt {
        margin-top: 10px;
        margin-bottom: 3px;
    }

    .col-M2 {
        width: 119px !important;
    }

    span {
        margin-right: 5px !important;
    }

    .edit dd {
        margin-top: 3px;
        margin-bottom: 3px;
    }

    .btn-filter {
        float: left;
        vertical-align: middle;
        margin-top: 20px;
        margin-left: 100px;
    }

    .datetimeI {
        width: 269px !important;
    }

    .erorrT {
        color: #a94442;
    }

    .erorrI input {
        color: #a94442;
        border-color: #a94442;
    }

    /* spiner */
    #nprogress {
        pointer-events: none;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1040;
    }

    #nprogress .spinner {
        display: block;
        position: fixed;
        right: 50%;
        top: 50%;
        margin-left: -10px;
        margin-top: -10px;
        z-index: 1031;
    }

    #nprogress .spinner-icon {
        border: solid 2px transparent;
        border-left-color: #8AD703;
        border-radius: 50%;
        border-top-color: #8AD703;
        box-sizing: border-box;
        height: 20px;
        width: 20px;
        position: absolute;
        -webkit-animation: nprogress-spinner 400ms linear infinite;
        animation: nprogress-spinner 400ms linear infinite;
    }

    #nprogress .spinner-icon-bg {
        border: solid 2px rgba(0, 0, 0, 0.2);
        border-radius: 50%;
        box-sizing: border-box;
        height: 20px;
        width: 20px;
    }

    #nprogress .overlay {
        background-color: #000;
        background-color: rgba(0, 0, 0, 0.4);
        color: #fff;
        display: block;
        height: 100%;
        position: fixed;
        text-align: center;
        top: 0;
        width: 100%;
        z-index: 1030;
    }

    .pagination {
        margin: unset !important;
    }

    .label-P {
        margin-top: 10px;
        font-weight: 700;
    }

    .btn-P {
        margin-top: 30px;
    }

    .dis-li {
        pointer-events: none;
        opacity: 0.6;
    }

    .li-info {
        cursor: pointer;
    }

    .blocker {
        position: absolute;
        top: 0px;
        left: 0px;
        height: 100%;
        width: 100%;
        z-index: 50;
    }

    input.ls {
        position: relative;
        color: white;
    }

    input.ls:before {
        position: absolute;
        /* top: 3px; */
        left: 10px;
        content: attr(data-date);
        display: inline-block;
        color: #472380 !important;
    }

    input.ls::-webkit-datetime-edit,
    input::-webkit-inner-spin-button,
    input::-webkit-clear-button {
        display: none;
    }

    input.ls::-webkit-calendar-picker-indicator {
        position: absolute;
        /* top: 3px; */
        right: 10px;
        color: #472380 !important;
        opacity: 1;
    }

    .Select-option:nth-child(n+6) {
        display: none;
    }

    .Select-option:last-child,
    .Select-option:nth-child(5) {
        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .css-dvua67-singleValue {
        color: #472380 !important;
    }

    .filter-input {
        height: 40px !important;
    }

    .progressBar {
        background-color: lightgrey;
        width: 200px;
        height: 20px;
    }

    .progressb {
        height: 100%;
    }

    span.multiselect-native-select {
        position: relative
    }

    span.multiselect-native-select select {
        border: 0 !important;
        clip: rect(0 0 0 0) !important;
        height: 1px !important;
        margin: -1px -1px -1px -3px !important;
        overflow: hidden !important;
        padding: 0 !important;
        position: absolute !important;
        width: 1px !important;
        left: 50%;
        top: 30px
    }

    .multiselect-container {
        position: absolute;
        list-style-type: none;
        margin: 0;
        padding: 0
    }

    .multiselect-container .input-group {
        margin: 5px
    }

    .multiselect-container>li {
        padding: 0
    }

    .multiselect-container>li>a.multiselect-all label {
        font-weight: 700
    }

    .multiselect-container>li.multiselect-group label {
        margin: 0;
        padding: 3px 20px 3px 20px;
        height: 100%;
        font-weight: 700
    }

    .multiselect-container>li.multiselect-group-clickable label {
        cursor: pointer
    }

    .multiselect-container>li>a {
        padding: 0
    }

    .multiselect-container>li>a>label {
        margin: 0;
        height: 100%;
        cursor: pointer;
        font-weight: 400;
        padding: 3px 0 3px 30px
    }

    .multiselect-container>li>a>label.radio,
    .multiselect-container>li>a>label.checkbox {
        margin: 0
    }

    .multiselect-container>li>a>label>input[type=checkbox] {
        margin-bottom: 5px
    }

    .btn-group>.btn-group:nth-child(2)>.multiselect.btn {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px
    }

    .form-inline .multiselect-container label.checkbox,
    .form-inline .multiselect-container label.radio {
        padding: 3px 20px 3px 40px
    }

    .form-inline .multiselect-container li a label.checkbox input[type=checkbox],
    .form-inline .multiselect-container li a label.radio input[type=radio] {
        margin-left: -20px;
        margin-right: 0
    }

    .dropdown-menu>.active>a,
    .dropdown-menu>.active>a:focus,
    .dropdown-menu>.active>a:hover {
        background-color: #472380 !important;
    }

    .contorno {
        padding-top: 9px;
        padding-bottom: 9px;
        font-size: 9px;
        color: white !important;
    }

    .modal-fullsize {
        width: 80vw !important;
        margin-left: -20vw;
    }

    .tab-tramites {
        overflow: auto;
        max-height: 50vh;
        overflow-x: hidden;
    }

    .documentos_see {
        text-align: center;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .maple {
        -webkit-transform: unset !important;
        transform: unset !important;
    }

    .inputdcss {
        pointer-events: none;
        color: #AAA;
        background: #F5F5F5;
    }
</style>
<script src="<?= base_url() ?>/assets/gap/js/Prueba.js"></script>
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Pólizas</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 d-flex">
            <ol class="breadcrumb text-right">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <li><a href="<?= base_url() ?>siniestroCorporativo/Polizas">Pólizas</a></li>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container-fluid">
    <?= $this->load->view('evaluaciones/_parts/sidemenu2', array("tipo" => $tipo)); ?>

    <div style="float: left; width: 90%;">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-primary" id="save_button">Guardar</button>
                    </div>
                    <!-- <button class="btn btn-primary">Guardar</button> -->
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" class="form-control siniestro-p" id="Id" name="Id" placeholder="Id" value="<?= isset($poliza['Id']) ? $poliza['Id'] : '' ?>" />
                            <label for="exampleInputEmail1">Póliza</label>
                            <input type="text" class="form-control siniestro-p" id="Poliza" name="Poliza" placeholder="Poliza" value="<?= isset($poliza['Poliza']) ? $poliza['Poliza'] : '' ?>" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Desde</label>
                            <input type="date" class="form-control siniestro-p" id="FDesde" name="FDesde" placeholder="FDesde" value="<?= isset($poliza['FDesde']) ? $poliza['FDesde'] : '' ?>" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hasta</label>
                            <input type="date" class="form-control siniestro-p" id="FHasta" name="FHasta" placeholder="FHasta" value="<?= isset($poliza['FHasta']) ? $poliza['FHasta'] : '' ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Endoso</label>
                            <input type="text" class="form-control siniestro-p" id="Endoso" name="Endoso" placeholder="Endoso" value="<?= isset($poliza['Endoso']) ? $poliza['Endoso'] : '' ?>" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Serie</label>
                            <input type="text" class="form-control siniestro-p" id="Serie" name="Serie" placeholder="Serie" value="<?= isset($poliza['Serie']) ? $poliza['Serie'] : '' ?>" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Modelo</label>
                            <input type="text" class="form-control siniestro-p" id="Modelo" name="Modelo" placeholder="Modelo" value="<?= isset($poliza['Modelo']) ? $poliza['Modelo'] : '' ?>" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Economico</label>
                            <input type="text" class="form-control siniestro-p" id="Economico" name="Economico" placeholder="Economico" value="<?= isset($poliza['Economico']) ? $poliza['Economico'] : '' ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Descripción</label>
                            <input type="text" class="form-control siniestro-p" id="Descripcion" name="Descripcion" placeholder="Descripcion" value="<?= isset($poliza['Descripcion']) ? $poliza['Descripcion'] : '' ?>" />
                        </div>
                    </div>
                </div>
            </div><!-- panel-body -->
        </div><!-- panel-default -->
        <div class="modal-seguimiento-container"></div>
        <!--  <div id="block" class="blocker" style="display: none"></div> -->
        <div id="siniestro-container">
        </div>
        <!--   <div id="selectm">
        </div> -->
        <button id="reloadT" style="display: none" onclick="reloadTable()">Algo</button>
    </div>


</section>


<div id="upProgressGeneral" style="display:none;" role="status" aria-hidden="true">
    <div id="nprogress" class="nprogress">
        <div class="spinner">
            <div class="spinner-icon"></div>
            <div class="spinner-icon-bg"></div>
        </div>
        <div class="overlay"></div>
    </div>
</div>
<script src="<?= base_url() ?>assets/gap/js/permisos.js"></script>
<script>
    $(document).ready(function() {
        var element = document.querySelector(".pace");
        element.classList.remove("pace-active");
        element.classList.add("pace-inactive");

        var label = '';
        const $IdNotificacion = $("#N").attr("data-idnotificacion");

        var element = document.querySelector(".pace");
        element.classList.remove("pace-active");
        element.classList.add("pace-inactive");
        //var isEdit = true;//Saber si se puede modificar el modal de tramites

        //console.log("Notificacion",$idNotificacion);
        $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
        const $path = $("#base_url").attr("data-base-url");

        //Guardado de la vista
        $(document).on('click', '#save_button', function(e) {
            //alert('cambio')
            var optSelect = $('#poliza').val();
            var idpoliza = $('#id').val();
            var dta = new FormData();

            var sp = document.getElementsByClassName("siniestro-p");
            for (var i = 0; i < sp.length; i++) {
                dta.append(`siniestro_poliza[${sp.item(i).name}]`, sp.item(i).value);
            }
            dta.append(`siniestro_poliza[accion]`, 1);
            /* if (idpoliza = "") {
                dta.append(`siniestro_poliza[accion]`, 1);
            } else {
                dta.append(`siniestro_poliza[accion]`, 2);
            } */

            //var dta = FormDataSiniestro();

            if (optSelect != "") {
                $.ajax({
                    type: 'POST',
                    url: `${$path}siniestroCorporativo/AccionesPoliza`,
                    data: dta,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.code == 200) {
                            toastr.success("Se guardo con éxito.");
                            window.location.replace(`${$path}siniestroCorporativo/Polizas`)
                        } else {
                            toastr.error(response.message);
                        }

                    }
                });
            } else {
                toastr.error('Ingrese una póliza');
                //alert("Ingrese una póliza")
            }
        });

    });
</script>