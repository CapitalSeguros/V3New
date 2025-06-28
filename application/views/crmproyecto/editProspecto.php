<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<meta name="viewport" content="width=900px"/>
<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Editar Prospecto</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
          
        </div>
    </div>
        <hr /> 
</section>
<section class="container-fluid">
	
	<?php echo form_open('crmproyecto/actualizaProspecto'); ?>
	    <div class="row">
	        <div class="col-md-12">
	            <div class="row">
	                <div class="form-group col-md-12 text-right">

	                    <a class="btn btn-default btn-sm" onclick="java:window.open('<?=base_url()?>crmproyecto/Reportes','_self');">CANCELAR</a>
	                    <button  class="btn btn-primary btn-sm">GUARDAR</button>
	                </div>
	            </div>
	            <div class="panel panel-default">
	                <div class="panel-body">

	                        <div class="form-group col-md-3 col-sm-3">
                                <label for="apaterno">Apellido Paterno</label>
                                <input
                                    type="text" class="form-control input-sm"
                                    name="ApellidoP" id="ApellidoP"
                                    value="<?=isset($detalleUsuario[0]->ApellidoP)?$detalleUsuario[0]->ApellidoP:''?>"
                                    
                                />

                            </div>


                            <div class="form-group col-md-3 col-sm-3">
                                <label for="amaterno">Apellido Materno</label>
                                <input
                                    type="text" class="form-control input-sm"
                                    name="ApellidoM" id="ApellidoM"
                                    value="<?=isset($detalleUsuario[0]->ApellidoM)?$detalleUsuario[0]->ApellidoM:''?>"
                                    
                                />

                            </div>

	                        <div class="form-group col-md-3 col-sm-3">
                                <label for="amaterno">Nombres</label>
                                 <input
                                    type="text" class="form-control input-sm"
                                    name="Nombre" id="Nombre"
                                    value="<?=isset($detalleUsuario[0]->Nombre)?$detalleUsuario[0]->Nombre:''?>"
                                    
                                />
                            </div>

	                       <div class="row">
	                           <div class="form-group col-md-3 col-sm-3">
	                               <label for="NombreUsuario">Email</label>
	                               <input
                                	type="text" class="form-control input-sm"
                                    name="EMail1" id="EMail1"
                                    value="<?=isset($detalleUsuario[0]->EMail1)?$detalleUsuario[0]->EMail1:''?>"
                                    
                                    />
	                            </div>

	                           <div class="form-group col-md-3 col-sm-3">
	                               <label for="NombreUsuario">Telefono</label>
                                    <input
                                    type="text" class="form-control input-sm"
                                    name="Telefono1" id="Telefono1"
                                    value="<?=isset($detalleUsuario[0]->Telefono1)?$detalleUsuario[0]->Telefono1:''?>"
                                    
                                    />
	                            </div>

	                           <div class="form-group col-md-3 col-sm-3">
                                <label for="NombreUsuario">Razon Social</label>
                                <input
                                    type="text" class="form-control input-sm"
                                    name="RazonSocial" id="RazonSocial"
                                    value="<?=isset($detalleUsuario[0]->RazonSocial)?$detalleUsuario[0]->RazonSocial:''?>"
                                    
                                />
	                           
	                        </div>

	                        <div class="form-group col-md-3 col-sm-3">
                                <label for="NombreUsuario">RFC</label>
                                <input
                                    type="text" class="form-control input-sm"
                                    name="RFC" id="RFC"
                                    value="<?=isset($detalleUsuario[0]->RFC)?$detalleUsuario[0]->RFC:''?>"
                                    
                                />
	                            
	                        </div>

                            <div class="form-group col-md-3 col-sm-3">
                                <label for="NombreUsuario">ID Cliente</label>
                                <input
                                    type="text" class="form-control input-sm"
                                    name="IDCl" id="IDCl"
                                    value="<?=isset($detalleUsuario[0]->IDCli)?$detalleUsuario[0]->IDCli:''?>"
                                    
                                    readonly=""
                                />
                                
                            </div>

	                    </div>

                       
	                </div>
	            </div>
	        </div>
	    </div>
    <?php echo form_close(); ?>
</section>
<!--:::::::::: FIN CONTENIDO ::::::::::-->

<?php $this->load->view('footers/footer'); ?>