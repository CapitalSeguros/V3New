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
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Editar usuario</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="<?=base_url()?>" title="Inicio">Inicio</a></li>
                <li><a href="<?=base_url()."configuraciones"?>" title="Configuración">Configuración</a></li>
                <li><a href="<?=base_url()."configuraciones/listUser"?>" title="Configuración">Lista de usuarios</a></li>
                <li class="active">Editar usuario</li>
            </ol>
        </div>
    </div>
        <hr /> 
</section>
<section class="container-fluid">
	<?
		if(validation_errors() != false){
	?>
	<div class="alert alert-danger" role="alert">
		<?php echo validation_errors();?>
    </div>
    <?
		} else if($alert=="success"){
	?>
	<div class="alert alert-success" role="alert">
		Usuario Actualizado !!!
    </div>
    <?
		}
	?>
	<?php echo form_open('configuraciones/actualizarcontrasenia'); ?>
	    <div class="row">
	        <div class="col-md-12">
	            <div class="row">
	                <div class="form-group col-md-12 text-right">
						<input type="hidden" name="tipoEdicion" id="tipoEdicion" value="User" />
						<input type="hidden" name="idUser" value="<?=isset($detalleUsuario[0]->id)?$detalleUsuario[0]->id:'0'?>">
						<input type="hidden" name="emailUser" value="<?=isset($detalleUsuario[0]->email)?$detalleUsuario[0]->email:''?>">
	                    <a class="btn btn-default btn-sm" onclick="java:window.open('<?=base_url()?>configuraciones/listUser','_self');">CANCELAR</a>
	                    <button  class="btn btn-primary btn-sm">GUARDAR</button>
	                </div>
	            </div>
	            <div class="panel panel-default">
	                <div class="panel-body">

<?
    $sql_miInfoSucursal = "
        Select * From 
            `users`
        Where
            `email` = '".$detalleUsuario[0]->email."'
                        ";
    $query = $this->db->query($sql_miInfoSucursal);
    if($query->num_rows()>0){
        $detalleUser = $query->result();
?>

                    	<div class="row">
	                        <div class="form-group col-md-3 col-sm-3">
                            	 <label for="Sucursal">Sucursal</label>
	                             <select class="form-control input-sm" name="Sucursal" id="Sucursal">

                                     <option 
                                        value="1" 
                                        <?=($detalleUser[0]->IdSucursal=="1")?'selected="selected"':''?>
                                    >MERIDA BUENAVISTA</option>
                                    <option 
                                        value="2" 
                                        <?=($detalleUser[0]->IdSucursal=="2")?'selected="selected"':''?>
                                    >CANCUN</option>
 								</select>
<?
    }
?> 
                            </div>

 <?
    $sql_miInfoCanal = "
        Select * From 
            `users`
        Where
            `email` = '".$detalleUsuario[0]->email."'
                        ";
    $query = $this->db->query($sql_miInfoCanal);
    if($query->num_rows()>0){
        $detalleCanal = $query->result();
?>

	                        <div class="form-group col-md-3 col-sm-3">
                            	<label for="canal">Canal</label>
	                        <select class="form-control input-sm" name="Canal" id="Canal">
                                    
                                    <option 
                                        value="1" 
                                        <?=($detalleCanal[0]->IdCanal=="1")?'selected="selected"':''?>
                                    >GESTION CARTERA</option>
                                    <option 
                                        value="2" 
                                        <?=($detalleCanal[0]->IdCanal=="2")?'selected="selected"':''?>
                                    >GESTION INSTITUCIONAL</option>
                                     <option 
                                        value="3" 
                                        <?=($detalleCanal[0]->IdCanal=="3")?'selected="selected"':''?>
                                    >GESTION FIANZAS</option>
                                    <option 
                                        value="4" 
                                        <?=($detalleCanal[0]->IdCanal=="4")?'selected="selected"':''?>
                                    >GESTION PROMOTORIA</option>
                                     <option 
                                        value="5" 
                                        <?=($detalleCanal[0]->IdCanal=="5")?'selected="selected"':''?>
                                    >SINIESTROS</option>
                                    <option 
                                        value="9" 
                                        <?=($detalleCanal[0]->IdCanal=="9")?'selected="selected"':''?>
                                    >MASTER</option>

                          
                             </select>
 <?
    }
?>  
                            </div>
	                        <div class="form-group col-md-3 col-sm-3">
                            	&nbsp;
                            </div>

                                <?
                                     $usermail =  $this->tank_auth->get_usermail();
                                     if(
                                     $usermail == "DESARROLLO@AGENTECAPITAL.COM"
                                     ||
                                     $usermail == "SISTEMAS@ASESORESCAPITAL.COM"

                                 ){
                                ?>   

	                                   <div class="form-group col-md-3 col-sm-3">
	                                       <label for="Contrasenia">Contraseña</label>
	                                            <div class="input-group">
	                                               <span class="input-group-addon"><i class="fa fa-lock"></i></span>
	                                               <input type="password" name="contrasenia" class="requiered form-control input-sm" />
	                                            </div>
	                                   </div>
                                <?  
                                  }
                                ?> 
                                
                        </div>
	                    <div class="row">
	                        <div class="form-group col-md-3 col-sm-3">
	                            <label for="NombreUsuario">Nombre</label>
	                            <input
                                	type="text" class="form-control input-sm"
                                    name="name_complete" id="name_complete"
                                    value="<?=isset($detalleUsuario[0]->name_complete)?$detalleUsuario[0]->name_complete:''?>" 
                                    required="required"
                                />
	                        </div>
	                        <div class="form-group col-md-3 col-sm-3">
	                            <label for="Email">Email</label>
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
	                                <input 
                                    	type="text" class="form-control input-sm"
                                        name="email" id="email"
                                        value="<?=isset($detalleUsuario[0]->email)?$detalleUsuario[0]->email:''?>"
										disabled="disabled"
                                    />
	                            </div>
	                        </div>
	                        <div class="form-group col-md-3 col-sm-3">
	                            <label for="Consultor">Perfil</label>
								<select class="form-control input-sm" name="profile" id="profile">
                                	<option value="3" <?=($detalleUsuario[0]->profile==3)?'selected="selected"':''?>>OPERATIVO</option>
                                	<option value="4" <?=($detalleUsuario[0]->profile==4)?'selected="selected"':''?>>MASTER</option>
                                    <option value="5" <?=($detalleUsuario[0]->profile==5)?'selected="selected"':''?>>NUBE</option>
                                </select>
	                        </div>
	                        <div class="form-group col-md-3 col-sm-3">
	                            <label for="Consultor">Tipo Usuario</label>
								<select class="form-control input-sm" name="idTipoUser" id="idTipoUser">
                                	<option value="1" <?=($detalleUsuario[0]->idTipoUser==1)?'selected="selected"':''?>>Operativos</option>
                                	<option value="2" <?=($detalleUsuario[0]->idTipoUser==2)?'selected="selected"':''?>>Administrativos</option>
                                    <option value="3" <?=($detalleUsuario[0]->idTipoUser==3)?'selected="selected"':''?>>Comercial</option>
                                    <option value="4" <?=($detalleUsuario[0]->idTipoUser==4)?'selected="selected"':''?>>Estrategicos</option>
                                    <option value="5" <?=($detalleUsuario[0]->idTipoUser==5)?'selected="selected"':''?>>Gerentes</option>
                                </select>
	                        </div>
	                    </div>
                        <div class="row">
                        	<div class="form-group col-md-3 col-sm-3">
	                            <label for="NombreUsuario">Tel Celular</label>
	                            <input
                                	type="text" class="form-control input-sm"
                                    name="CelularSMS" id="CelularSMS"
                                    value="<?=isset($detalleUsuario[0]->CelularSMS)?$detalleUsuario[0]->CelularSMS:''?>" 
                                    
                                />
	                        </div>
                        	<div class="form-group col-md-3 col-sm-3">
	                            <label for="Contrasenia">Suspender</label>
								<select class="form-control input-sm" name="banned" id="banned">
                                	<option value="1" <?=($detalleUsuario[0]->banned==1)?'selected="selected"':''?>>Si</option>
                                	<option value="0" <?=($detalleUsuario[0]->banned==0)?'selected="selected"':''?>>No</option>
                                </select>
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