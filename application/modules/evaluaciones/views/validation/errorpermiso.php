<style>

</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <!-- <h3 class="titulo-secciones">Registro de siniestros</h3> -->
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12 text-center" style="height: 40vh;" >
                   <div><h3>No se cuentan con los permisos necesarios para acceder a la configuración.</h3></div>
                   <div style="margin-top: 30px;"><a href="<?=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:base_url()?>" class="btn btn-primary btn-lg">Regresar</a></div>
                </div>
            </div>
        </div><!-- panel-body -->
    </div><!-- panel-default -->
</section>