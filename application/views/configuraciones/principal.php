<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>

<!--:::::::::: INICIO CONTENIDO ::::::::::-->
    <section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Configuración</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li><a href="<?=base_url()?>" title="Inicio">Inicio</a></li>
                    <li class="active">Configuración</li>
                </ol>
            </div>
        </div>
            <hr /> 
    </section>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6 text-center">
                        <a href="<?=base_url()?>configuraciones/addUser" class="link-configuracion" title="Agregar usuarios">
                            <div class="icons-configuracion icon-add-usuario"></div>
                        </a>
                        <p class="h5"><a href="<?=base_url()?>configuraciones/addUser" title="Agregar usuarios">Agregar usuarios</a></p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6 text-center">
                        <a href="<?=base_url()?>configuraciones/listUser" class="link-configuracion" title="Editar usuarios">
                            <div class="icons-configuracion icon-editar-usuario"></div>
                        </a>
                        <p class="h5"><a href="<?=base_url()?>configuraciones/listUser" title="Agregar usuarios">Editar usuarios</a></p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6 text-center">
                        <a href="<?=base_url()?>configuraciones/listVend" class="link-configuracion" title="Editar Vendedores">
                            <div class="icons-configuracion icon-editar-usuario"></div>
                        </a>
                        <p class="h5"><a href="<?=base_url()?>configuraciones/listVend" title="Agregar usuarios">Editar Vendedores</a></p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6 text-center">
                        <a href="<?=base_url()?>configuraciones/userPermission" class="link-configuracion" title="Permisos Usuarios">
                            <div class="icons-configuracion icon-editar-usuario"></div>
                        </a>
                        <p class="h5"><a href="<?=base_url()?>configuraciones/userPermission" title="Permisos Usuarios">Permisos usuarios</a></p>

                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6 text-center">
                        <a href="<?=base_url()?>honorarios/restringirAgentes" class="link-configuracion" title="Permisos Usuarios">
                            <div class="icons-configuracion icon-editar-usuario"></div>
                        </a>
                        <p class="h5"><a href="<?=base_url()?>honorarios/restringirAgentes" title="Permisos Usuarios">Banear Vendedores por comision</a></p>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--:::::::::: FIN CONTENIDO ::::::::::-->

<?php $this->load->view('footers/footer'); ?>