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
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Editar vendedor</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="<?=base_url()?>" title="Inicio">Inicio</a></li>
                <li><a href="<?=base_url()."configuraciones"?>" title="Configuración">Configuración</a></li>
                <li><a href="<?=base_url()."configuraciones/listVend"?>" title="Configuración">Lista de vendedores</a></li>
                <li class="active">Editar vendedor</li>
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
		}  else if($alert=="success"){
	?>
	<div class="alert alert-success" role="alert">
		Vendedor Actualizado !!!
    </div>
    <?
		}
	?>
	<?php echo form_open('configuraciones/actualizarcontrasenia'); ?>
	    <div class="row">
	        <div class="col-md-12">
	            <div class="row">
	                <div class="form-group col-md-12 text-right">
						<input type="hidden" name="tipoEdicion" id="tipoEdicion" value="Vend" />
						<input type="hidden" name="idUser" value="<?=isset($detalleUsuario[0]->id)?$detalleUsuario[0]->id:'0'?>">
						<input type="hidden" name="emailUser" value="<?=isset($detalleUsuario[0]->email)?$detalleUsuario[0]->email:''?>">
	                    <a class="btn btn-default btn-sm" onclick="java:window.open('<?=base_url()?>configuraciones/listVend','_self');">CANCELAR</a>
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
                            <label for="Sucursal">Canal</label>
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
	                                   <label for="Contrasenia">Contraseña: <?php echo($detalleUsuario[0]->passwordVisible); ?></label>
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
	                            <label for="fechingreso">Fecha de ingreso</label>
                                            <input
                                            type="text" name="fechaStart" id="fechaStart"
                                            class="form-control input-sm fecha fechaStart"
                                            placeholder="1900-01-01"
                                            value="<?=isset($detalleUsuario[0]->email)?$detalleUsuario[0]->FechaIngresoAgente:''/*($this->input->post('fechaStart',TRUE)!="")?$this->input->post('fechaStart',TRUE):date('Y-m-d')*/ ?>"
                                            title="Fecha de Ingreso"
                                            />
	                        </div>
	                        <div class="form-group col-md-3 col-sm-3">
	                            <label for="fechingreso">Tipo Usuario</label>
								<select class="form-control input-sm" name="idTipoUser" id="idTipoUser">
                                	<option value="6" <?=($detalleUsuario[0]->idTipoUser==6)?'selected="selected"':''?>>Vendedores</option>
                                </select>
	                        </div>
	                    </div>
<?
	$sql_miInfoVendedor = "
		Select * From 
			`user_miInfo`
		Where
			`emailUser` = '".$detalleUsuario[0]->email."'
						";
	$query = $this->db->query($sql_miInfoVendedor);
	if($query->num_rows()>0){
		$detalleVendMiinfo = $query->result();
?>
                        <div class="row">
	                        <div class="form-group col-md-3 col-sm-3">
	                            <label for="NombreUsuario">Giro</label>
								<select class="form-control input-sm" name="Giro" id="Giro">
                                	<!--<option 
                                    	value="AGENTE" 
										<?=($detalleVendMiinfo[0]->Giro=="AGENTE")?'selected="selected"':''?>
                                    >AGENTE</option>
                                	<option 
                                    	value="AGENTE INTEGRAL" 
										<?=($detalleVendMiinfo[0]->Giro=="AGENTE INTEGRAL")?'selected="selected"':''?>
									>AGENTE INTEGRAL</option>
                                	<option 
                                    	value="ASESOR" <?=($detalleVendMiinfo[0]->Giro=="ASESOR")?'selected="selected"':''?>
                                    >ASESOR</option>
                                	<option 
                                    	value="ASESOR INTEGRAL" <?=($detalleVendMiinfo[0]->Giro=="ASESOR INTEGRAL")?'selected="selected"':''?>
                                    >ASESOR INTEGRAL</option>-->

                                       <option 
                                    	value="AGENTE DE FIANZAS" 
										<?=($detalleVendMiinfo[0]->Giro=="AGENTE DE FIANZAS")?'selected="selected"':''?>
                                    >AGENTE DE FIANZAS</option>
                                	<option 
                                    	value="AGENTE DE PROMOTORIA" 
										<?=($detalleVendMiinfo[0]->Giro=="AGENTE DE PROMOTORIA")?'selected="selected"':''?>
									>AGENTE DE PROMOTORIA</option>
                                	<option 
                                    	value="AGENTE ESPECIAL" <?=($detalleVendMiinfo[0]->Giro=="AGENTE ESPECIAL")?'selected="selected"':''?>
                                    >AGENTE ESPECIAL</option>
                                	<option 
                                    	value="COLABORADOR" <?=($detalleVendMiinfo[0]->Giro=="COLABORADOR")?'selected="selected"':''?>
                                    >COLABORADOR</option>

                                    <option 
                                    	value="AGENTE DE GESTION" <?=($detalleVendMiinfo[0]->Giro=="AGENTE DE GESTION")?'selected="selected"':''?>
                                    >AGENTE DE GESTION</option>



                                </select>




                             


                            </div>
	                        <div class="form-group col-md-3 col-sm-3">
	                            <label for="Contrasenia">Ranking</label>
								<select class="form-control input-sm" name="Ranking" id="Ranking">
                                    <option 
                                        value="PROVISIONAL PROM" 
                                        <?=($detalleVendMiinfo[0]->Ranking=="PROVISIONAL PROM")?'selected="selected"':''?>
                                    >PROVISIONAL PROM</option>

                                     <option 
                                        value="AGENTE EN CESION" 
                                        <?=($detalleVendMiinfo[0]->Ranking=="AGENTE EN CESION")?'selected="selected"':''?>
                                    >AGENTE EN CESION</option>

                                	<option 
                                    	value="PROVISIONAL" 
										<?=($detalleVendMiinfo[0]->Ranking=="PROVISIONAL")?'selected="selected"':''?>
                                    >PROVISIONAL</option>
                                	<option 
                                    	value="ESTANDAR" 
										<?=($detalleVendMiinfo[0]->Ranking=="ESTANDAR")?'selected="selected"':''?>
									>ESTANDAR</option>
                                	<option 
                                    	value="BRONCE" <?=($detalleVendMiinfo[0]->Ranking=="BRONCE")?'selected="selected"':''?>
                                    >BRONCE</option>
                                	<option 
                                    	value="PLATA" <?=($detalleVendMiinfo[0]->Ranking=="PLATA")?'selected="selected"':''?>
                                    >PLATA</option>
                                	<option 
                                    	value="ORO" <?=($detalleVendMiinfo[0]->Ranking=="ORO")?'selected="selected"':''?>
                                    >ORO</option>
                                	<option 
                                    	value="PLATINO" <?=($detalleVendMiinfo[0]->Ranking=="PLATINO")?'selected="selected"':''?>
                                    >PLATINO</option>
                                </select>
                            </div>
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

                            
                            <div class="form-group col-md-3 col-sm-3">
                                <label >Permitir ver sus actividades creadas por otro</label>
                                <select class="form-control input-sm" name="ActCreadaPorOtro" id="ActCreadaPorOtro">
                                    <option value="SI" <?=($detalleUsuario[0]->ActCreadaPorOtro=="SI")?'selected="selected"':''?>>Si</option>
                                    <option value="NO" <?=($detalleUsuario[0]->ActCreadaPorOtro=="NO")?'selected="selected"':''?>>No</option>
                                </select>
                            </div>



                                   <div class="form-group col-md-3 col-sm-3">
                               
                                
                            </div>
	                       <!-- <div class="form-group col-md-6 col-sm-6">
	                            <label for="Contrasenia">Certificaciones</label>
                                <br />
                                <input type="checkbox" name="certificacionAutos" id="certificacionAutos" value="SI"
									<?=($detalleVendMiinfo[0]->certificacionAutos=="SI")?'checked="checked"':''?> 
                                />Autos
                                &nbsp;
                                <input type="checkbox" name="certificacionGmm" id="certificacionGmm" value="SI"
									<?=($detalleVendMiinfo[0]->certificacionGmm=="SI")?'checked="checked"':''?> 
                                />Gmm
                                &nbsp;
                                <input type="checkbox" name="certificacionVida" id="certificacionVida" value="SI"
									<?=($detalleVendMiinfo[0]->certificacionVida=="SI")?'checked="checked"':''?> 
                                />Vida
                                &nbsp;
                                <input type="checkbox" name="certificacionDanos" id="certificacionDanos" value="SI"
									<?=($detalleVendMiinfo[0]->certificacionDanos=="SI")?'checked="checked"':''?> 
                                />Daños
                                &nbsp;
                                <input type="checkbox" name="certificacionFianzas" id="certificacionFianzas" value="SI"
									<?=($detalleVendMiinfo[0]->certificacionFianzas=="SI")?'checked="checked"':''?> 
                                />Fianzas
                            </div>-->
                        </div>
<?
	}
?>
                        <div class="row">
                        	
<?
	$sql_permisosVendedor = "
		Select * From 
			`vend_permisos`
		Where
			`emailUser` = '".$detalleUsuario[0]->email."'
						";
	$query = $this->db->query($sql_permisosVendedor);
	if($query->num_rows()>0){
		$detalleVendPermisos = $query->result();
?>

                        	<div class="form-group col-md-9 col-sm-9">
	                            <label for="Contrasenia">Permisos</label>
                                <br />
                                <?
									foreach($detalleVendPermisos as $detalleVendPermiso){
										$permisoCoti = $detalleVendPermiso->modulo."_";
										$permisoCoti.= $detalleVendPermiso->subModulo."_";
										$permisoCoti.= $detalleVendPermiso->tipo."_";
										$permisoCoti.= $detalleVendPermiso->accion;
								?>
                                <input 
                                	type="checkbox" 
									name="<?=$permisoCoti?>[]" id="<?=$permisoCoti?>[]"
                                    value="<?=$detalleVendPermiso->ramo?>"
									<?=($detalleVendPermiso->permiso=="SI")?'checked="checked"':''?> 
                                />Cotizaci&oacute;n <?=$detalleVendPermiso->ramo?> &nbsp;
                                <?
									}
								?>
                            </div>
<?
	}
?>
						</div>


<div class="row">
<label>Facultades</label><br>
<?php 


$consulta="select id,descripcion from user_miinfofacultades order by ordenVista";
$traeFacultades='select agenteFacultades from user_miInfo where emailUser="'.$detalleUsuario[0]->email.'"';
$verDatos=$this->db->query($consulta);
$traeFacultadesAgente=$this->db->query($traeFacultades);
$facultades=explode(";",$traeFacultadesAgente->result()[0]->agenteFacultades);
//$fp = fopen('resultadoJason.txt', 'a+');fwrite($fp, print_r($facultades,TRUE));fclose($fp);
$contador=count($facultades);
foreach ($verDatos->result() as  $value) {
$bandera=0;
for($i=0;$i<$contador;$i++){
  if($facultades[$i]==$value->id){$bandera=1;$i=$contador;}
 
}
if($bandera==0){$var='<input type="checkbox" name="cb_Facultades[]" id="pruebaCB" value="'.$value->id.'">';}
else{$var='<input type="checkbox" name="cb_Facultades[]" id="pruebaCB" value="'.$value->id.'" checked="checked">';}

$var=$var.$value->descripcion;
echo($var);
}
?>

</div>    

	                </div>
	            </div>
	        </div>
	    </div>
    <?php echo form_close(); ?>
</section>
<!--:::::::::: FIN CONTENIDO ::::::::::-->


 <script>
 
  var fechaStart =
  $('.fechaStart').datepicker({
    format:   "yyyy-mm-dd",
    startDate:  "",
    language: "es",
    autoclose:  true
  });
  

 </script>

<?php $this->load->view('footers/footer'); ?>