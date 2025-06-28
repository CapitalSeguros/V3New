<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Cargar incidencias masivo</h3>

        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <?= $breadcrumbs ?>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <div style="float: left; width: 100%;">
        <div class="file-upload">
            <div class="file-select">
                <div class="file-select-button" id="fileName">Seleccionar archivo</div>
                <div class="file-select-name" id="noFile">Archivo no seleccionado...</div>
                <input type="file" name="chooseFile" id="chooseFile">
            </div>
        </div>
        <br />
        <table id="tb-empleado-incidencia" class="table table-condensed">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Fecha</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Incidencia</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</section>

<div class="js-incidencias"></div>