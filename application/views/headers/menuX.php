<style type="text/css">
body {overflow-x: hidden;}
ul#menuSub {float:center;padding: 5px;position: relative;top:10px;color: #fff;font-size: 14px;}
ul#menuSub2 {border-style:solid; height: 80px; width: 80px;border-style: groove;font-size: 14px;top: 15px;position:  absolute;}
ul#menuSub li {color: white;float: left;list-style: none;margin: 0% 0%; }
ul#menuSub li:hover{color: blue;cursor:pointer;background: #9D8EBF;}
ul#menuSub ul {display: none;position: absolute;top: 18px;color: green;padding: 2px 0px 2px 2px;margin-top: 3px ;left: 5PX;height: auto;width: 140px;background: #59497A;}
ul#menuSub ul li{float: left;color: blue;width:130px;margin:2% 0%;}
ul#menuSub ul li a{color: white;}
ul#menuSub ul li a:hover{color: yellow;cursor:pointer;}
ul#menuSub li:hover ul ul,ul#menuSub li:hover ul ul ul,ul#menuSub li.iehover ul ul,ul#menuSub li.iehover ul ul ul {display: none;cursor:pointer;}
ul#menuSub li:hover ul,ul#menuSub ul li:hover ul,ul#menuSub ul ul li:hover ul,ul#menuSub li.iehover ul,ul#menuSub ul li.iehover ul,ul#menuSub ul ul li.iehover ul {display: block;cursor:pointer;}

.fondoCabeceraMenuGeneral{height: 130px;visibility: visible;background-repeat: no-repeat;margin-bottom: 0px;background-color: white}
.stiloLogo1{background-image: url("<?php echo base_url(); ?>assets/images/logo/B1366x100.png");}
.stiloLogo2{background-image: url("<?php echo base_url(); ?>assets/images/logo/B960X115.png");}
.stiloLogo3{background-image: url("<?php echo base_url(); ?>assets/images/logo/B900x100.png");}
.stiloLogo4{background-image: url("<?php echo base_url(); ?>assets/images/logo/B720x120.png");}
.stiloLogo5{background-image: url("<?php echo base_url(); ?>assets/images/logo/B320x120.png");}
.fondoNegro{color: black}

.popover-content{
	color: black;
	width: 200px;
	left: 410px;
}
.popover-title{
	background-color:#361866;
	color: white;
}
.popover .fade .bottom .in{
	left: 410px !important;
}
#test:focus{
	background-color: green;
}
.test{
	top:12vh; 
	right: 3vw;
	width: 400px;
	max-height: 200px; 
	background-color: white;
	position: absolute;
	z-index: 1;
	display: none;
	overflow: auto;
	overflow-x: hidden;
	border-radius: 5px;
	-webkit-box-shadow: -9px 9px 11px -5px rgba(0,0,0,0.75);
	-moz-box-shadow: -9px 9px 11px -5px rgba(0,0,0,0.75);
	box-shadow: -9px 9px 11px -5px rgba(0,0,0,0.75);
	/* recordar poner  en  fondoCabeceraMenu style="position: relative;" */
}
#campana{
	position: absolute;
	margin-left: -20px;
	margin-top: 40px; 
}

</style>
<style type="text/css">
	#menu_encuestas{
		float: left;
		margin-left: -40%;
		width: 100%;
		height: 120px;
		background-color: #361666;
	}
	#menu_encuestas ul li a span{
		color: #fff;
	}
</style>
<script type="text/javascript">
function cambiaVariableSecion(){
	document.getElementById("ventana-flotanteBL").className = "oculto";
	$.ajax({
		method:		"POST",
		dataType:	"html",
		url:		"<?=base_url()?>cambiaVariableSecion/cierraBox",
		data:		{gato:'perro'},
		async: 		true,
		success:	function(result){/*El codigo que vas a hacer funcionar cuando tenga exito el ajax*/},
		error:		function() {/*El codigo que vas a hacer cuando falle el ajax*/}
	})
}
</script>
<?php
	$ci = &get_instance();
	$ci->load->model("menu_model");
	$ci->load->model("personamodelo");
	/* Inicio Tic Consultores */
	$ci->load->model('evaluacion_periodos_model', 'periodo');
	$ci->load->model('notificacionmodel', 'notificacion');

	//data de las notificaciones de las evaluaciones
	$evalPendientes=$this->periodo->ntMyInfo($this->tank_auth->get_idPersonaPuesto(),$this->tank_auth->get_idPersona());
	//lista de las notificaciones del sistema
	$notificaciones=$this->notificacion->getAllNotificaciones($this->tank_auth->get_idPersona());
	$NotiPendientes=$this->notificacion->NuevasN($this->tank_auth->get_idPersona());

	/* fin Tic Consultores */

	//$menuprincipal= $ci->menu_model->llama();
	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($ci->menu_model->llama(), TRUE));fclose($fp);

	$configModulos = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
	foreach($configModulos as $modulos){ }
	
	$sqlConsultaBanners = "Select `directorio`,`img` From `banners` Where 1 Order By `id` Asc";
	$queryConsultaBanners	= $this->db->query($sqlConsultaBanners)->result();
	//echo "<pre>";
		//print_r($queryConsultaBanners);
	//echo "</pre>";
	
	$imgBanner_BoxLight	= base_url().$queryConsultaBanners[0]->directorio."/".$queryConsultaBanners[0]->img;
	//"assets/imgBanner/nuestrosagentes1.png";
	$imgBanner_Marq_0	= base_url().$queryConsultaBanners[1]->directorio."/".$queryConsultaBanners[1]->img;
	//"assets/imgBanner/B1/F-1366x100.png";
	$imgBanner_Marq_1	= base_url().$queryConsultaBanners[2]->directorio."/".$queryConsultaBanners[2]->img;
	//"assets/imgBanner/B2/F-1366x100.png";
	$imgBanner_Marq_2	= base_url().$queryConsultaBanners[3]->directorio."/".$queryConsultaBanners[3]->img;
	//"assets/imgBanner/B3/F-1366x100.png";
	$imgBanner_Marq_3	= base_url().$queryConsultaBanners[4]->directorio."/".$queryConsultaBanners[4]->img;
	//"assets/imgBanner/B4/F-1366x100.png";
	$imgBanner_CicVenta = base_url()."assets/imgBanner/B_CICLO_VENTA/BANNER_CICLO_1366x100.png";

?>
<?php
	$activa			= $this->uri->segment(1);
	$path_foto		= "assets/img/miInfo/userPhotos/";
	$foto			= "";
	$usermail		= $this->tank_auth->get_usermail();
	$idPersona		= $this->tank_auth->get_idPersona();
	$imagenPersona	= $ci->menu_model->buscaFotoPersonal($this->tank_auth->get_idPersona());

if(isset($imagenPersona)){ // count($imagenPersona) > 0

	//$foto="archivosPersona/".$imagenPersona[0]->idPersona."/miFoto/".$imagenPersona[0]->idPersonaImagen.$imagenPersona[0]->extensionPersonaImagen;
		
//Miguel Jaime 16/10/2020
	
	$foto = $path_foto.$imagenPersona;
		
} else {  
	$foto = $path_foto . "noPhoto.png";
}
?>

<?php
session_start();
if(isset($_SESSION['BOXLIGHT'])){
	if($_SESSION['BOXLIGHT']){
?>
	<div id='ventana-flotanteBL'>
		<a class='cerrar' href='javascript:void(0);' onclick='cambiaVariableSecion ()'>x</a>
		<img style="height: 100%;width: 100%" src="<?=$imgBanner_BoxLight?>">
	</div>
<?php
	 //$_SESSION['BOXLIGHT']=FALSE;
	}
}
?>

<header> 
	<div id="fondoCabeceraMenu" class="fondoCabeceraMenuGeneral">
	<?php 
		$Evaluado=0;
		$Evaluador=0;
		foreach ($evalPendientes as $key => $value){
			if($value["tipo"]=="EVALUADO"){
				$Evaluado++;
			}else{
				$Evaluador++;
			}
		}
	?>
	<div id="test" class="test">
		<div class="row">
			<div>
				<div class="col-md-12" style="background-color: #361866;color: white; height: 30px;">
						<h5 style="color: white; padding-left: 10px;">Notificaciones</h5>
				</div>
			</div>
			<div>
				<div class="col-md-12">
					<ul style="list-style: none;padding-inline-start: 10px !important;">
					<?php if (!empty($evalPendientes)) : ?>
						<li style="border-bottom: 1px solid #e3e3e3;">
							<div class="media" style="margin: 10px;">
								<a href="<?=base_url()?>miInfo">
									<div class="media-body">
									<?php if ($Evaluado>0) : ?>
										<p>Siendo evaluado en <?=$Evaluado?> periodos.</p>
									<?php endif; ?>
									<?php if ($Evaluador>0) : ?>
										<p>Evaluaciones pendientes: <?=$Evaluador?></p>
									<?php endif; ?>
									<p>ir a miInfo para más información.</p>
									</div>
								</a>
							</div>
						</li>
					<?php endif; ?>
					<?php foreach ($notificaciones as $key => $value) : ?>
						<li style="border-bottom: 1px solid #e3e3e3;">
						<?php $texto = explode(",", $value->Contenido) ?>
						<div class="media" style="margin: 10px;">
							<a href="<?= base_url() ?>Notificaciones/<?= $value->referencia_id ?>/<?= $value->referencia ?>/<?= $value->id ?>">
								<div class="media-body">
									<small class="text-muted" style="float:right">
										<span class="glyphicon glyphicon-calendar alertNotificacao"></span>
										<?= date("d-m-Y, g:i a", strtotime($value->fecha_alta)) ?>
									</small>
									<h5 class="media-heading"><?php echo $texto[0] ?></h5>
									<p><?php echo $texto[1] ?></p>
								</div>
							</a>
						</div>
						</li>
					<?php endforeach; ?>
					<?php if (empty($notificaciones)) : ?>
						<li style="border-bottom: 1px solid #e3e3e3;">
						<div class="media" style="margin: 10px;">
							<a>
								<div class="media-body">
									<h5 class="media-heading"></h5>
									<p>No tiene notificaciones pendientes</p>
								</div>
							</a>
						</div>
						</li>
					<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
		<div  style="visibility: hidden;height: 1px">
			<a href="./" class="navbar-brand" title="Capsys Web - Inicio"></a>
		</div>
		<ul class="user-perfil pull-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> 
				<span class="usuario-nombre fondoNegro" style="color: black"><?=$this->tank_auth->get_usermail();?></span>
					<i class="caret"></i>
					<div class="user-perfil-extra hidden-xs">
						<p class="fondoNegro">
							<?= $this->tank_auth->get_usernamecomplete(); ?> 
                            <span class="badge">
							<?
                            	if($this->capsysdre->RankingUsuarioEmail($this->tank_auth->get_usermail()) != ""){
									$ranking=$ci->personamodelo->buscaPersonaPorCampo($idPersona,'idpersonarankingagente');
									echo $ranking->idpersonarankingagente;
								} else {
									echo $this->capsysdre->NombrePerfilUsuario($this->tank_auth->get_userprofile());
								}
							?>
							</span>
				<?php //print("<b>".$this->capsysdre->RankingUsuarioEmail($this->tank_auth->get_usernamecomplete())."</b>"); ?>
				<?php  ?>
				<?php //echo $this->tank_auth->get_usernamecomplete(); ?>
				<?php //echo $this->tank_auth->get_usernamecomplete(); ?>                            
						</p>
					</div>
					<img src="<?=base_url().$foto;?>" width="55;" alt="<?=$this->tank_auth->get_usernamecomplete()?>" class="img-circle">

					<!-- evalPendientes -->
					
					<i id="campana" style="color:<?=$NotiPendientes[0]["result"]!='0'?'red':'blue' ?>"  class="fa fa-bell" aria-hidden="true" onclick="display()"></i>
				</a> 
				<ul class="dropdown-menu dropdown-menu-right dropdown-menu-perfil">
                	<!-- <li><a href="<?=base_url()?>miInfo" title="Mi Info"><i class="fa fa-user"></i> Mi Info</a></li> -->
				<? if(in_array('configuraciones',$modulos)){ ?>
					<!--<li><a href="configuraciones" title="Configuración"><i class="fa fa-cogs"></i> Configuración</a></li>-->
				<? } ?>
                
				<? if(in_array('credenciales',$modulos)){ ?>
					<!--<li><a href="validaciones" title="credenciales"><i class="fa fa-cogs"></i> Credenciales</a></li>-->
				<? } ?>
					<li id="salir" ><a href="<?=base_url()?>auth/logout" title="Salir"><i class="fa fa-sign-out"></i> Salir</a>
					</li>

									
						<div id="salir2" class="row" style="height: 300px; width: 500px;display: block;overflow: scroll;position: relative;left:-180%; color: white;background-color: #251047">
							<?
							$array['grupos']=1;
                            $infoPersoana=$ci->personamodelo->clasificacionUsuariosParaEnvios($array); 							
							?>
							<?=imprimirColaboradoresCabecera( $infoPersoana);?>
								
						</div>
			
					</li>
				</ul>
			</li>
		</ul> 
	</div>

	<div id="marquesinaBanner" class="marquesinaGeneral"> 
	</div>

<!--Muestra la parte de notificaciones en caso de que exita una evalaucion-->

<script>
	function display(){
		if ($("#test:hidden").length) {
			$("#test").focus();
			$("#test").show();
			$("#salir").css("display","none");
			$("#salir2").css("display","none");
			$("#agrupa2").css("display","none");
			updateNotificaciones();

		} else if ($("#test:visible").length) {
			$("#test").hide();
			$("#salir").css("display","block");
			$("#salir2").css("display","block");
			$("#agrupa2").css("display","block");
		}
	}
	$(document).click(function(){
		$(".test").hide();
		$("#salir").css("display","block");
		$("#salir2").css("display","block");
		$("#agrupa2").css("display","block");
	});

	function updateNotificaciones(){
		var id=<?=$this->tank_auth->get_idPersona()?>;
		$.ajax('<?=base_url()?>Notificaciones/UpdateAll', {
			type: 'POST',  // http method
			data: { id: id },  // data to submit
			success: function (data, status, xhr) {
				$("#campana").css('color','blue')
			},
			error: function (jqXhr, textStatus, errorMessage) {
				
			}
		});
	}

</script>


<ul class="menuPrincipal">

<? /* ================= VALIDAMOS SI ES USUARIO CARCAPITAL PARA SOLO ACTIVAR DOS OPCIONES ================= */ ?>

<?php
	$correoProcedente	= $this->tank_auth->get_usermail();
	$carcapital			= $this->capsysdre->GetCarcapitalxEmail($correoProcedente);
	if($carcapital=='1'){
?>
<? /* ================= MENU Reportes ================= */ ?>
<ul class="miUL">
	<label class="labelMenu">Reportes▼</label>

         
	<li><a href="<?=base_url()?>cobranzaPendiente" class="glyphicon glyphicon-usd">Cob. Pendiente</a></li>

	<li>
		<form action="<?=base_url();?>buscaXfolio" method="POST" class="form">
     		<input type="text" id="TbuscarXfolio" name="TbuscarXfolio" style="width: 95%; color: black" onclick="detienePropagacion(event)">
		<button type="submit" name="Consulta" id="Consulta" value="Buscar Poliza">Buscar Poliza</button>
		</form>
	</li>
	<!-- <li><a href="<?=base_url()?>siniestros" class="glyphicon glyphicon-usd">Siniestros</a></li> -->
	<li><a href="<?=base_url()?>honorarios" class="glyphicon glyphicon-usd">Honorarios</a></li>
</ul >
     
<? /* ================= MENU Proyecto 100 ================= */ ?>


<? /* ================= MENU COTIZADOR ================= */ ?>
<ul class="miUL">
	<a href="<?=base_url()?>cotizador" title="Car Capital">
    	<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuMail.png"></span>Car Capital
    </a>
</ul>

<? /* ================= MENU PRESUPUESTOS ================= */ ?>

<?php
	} else {
?>  


<?php
	if(
		$this->tank_auth->get_userprofile() == "2" 
		|| 
		$this->tank_auth->get_userprofile() == "3" 
		|| 
		$this->tank_auth->get_userprofile() == "4" 
		||
		$this->tank_auth->get_userprofile() == "5"
	){
?>
<!--
  <ul class="miUL">
   <a href="<?php //base_url(); ?>configuraciones/listVend2" title="Agentes"><span><image src="<?php //*echo base_url(); ?>assets/images/icons-menu/icon-menuDirectorio.png"></span> Agentes click</a>
  </ul>
-->
<?php
	}
?>
	<ul class="miUL">
		<a href="<?=base_url()?>miInfo" title="Mi Info"><i class="fa fa-user"></i> Mi Info</a>
	</ul>
	
    <ul class="miUL">
		<a href="<?=base_url()?>directorio" title="Directorio">
			<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuDirectorio.png"></span> Directorio
		</a>
	</ul>
	
    <ul class="miUL">
    	<label class="labelMenu">Reportes▼</label>
		<li><a href="<?=base_url()?>renovaciones"  class="glyphicon glyphicon-usd">Renovaciones</a></li>
		<li><a href="<?=base_url()?>produccion"  class="glyphicon glyphicon-usd">Cartera</a></li>   
		<!-- modificado migue jaime 20/07/20         
		<li><a href="<?=base_url()?>cobranzaPendiente" class="glyphicon glyphicon-usd">Cob. Pendiente</a></li>
		-->
		<li><a href="<?=base_url()?>cobranzaEfectuada" class="glyphicon glyphicon-usd">Cob. Efectuada</a></li>
		<li><a href="<?=base_url()?>cobranzaCancelada" class="glyphicon glyphicon-usd">Cob. Cancelada</a></li>
		<li><a href="<?=base_url()?>reportes/rendicionDeCuentas" class="glyphicon glyphicon-book">&nbspRendición de cuentas</a></li>
		<li>
			<form action="<?=base_url();?>buscaXfolio" method="POST" class="form" onclick="detienePropagacion(event)">
				<input type="text" id="TbuscarXfolio" name="TbuscarXfolio" style="width: 95%; color: black">
				<button type="submit" name="Consulta" id="Consulta" value="Buscar Poliza">Buscar Poliza</button>
			</form>
		</li>
		<!-- <li><a href="<?=base_url()?>siniestros" class="glyphicon glyphicon-usd">Siniestros</a></li> -->
		<li><a href="<?=base_url()?>honorarios" class="glyphicon glyphicon-usd">Honorarios</a></li>
		<?
			if($this->tank_auth->get_userprofile() == "2" || $this->tank_auth->get_userprofile() == "3" || $this->tank_auth->get_userprofile() == "4"){
		?>
		<!-- <li><a href="<?=base_url()?>ejecutivos/ConsultaGlobal" class="glyphicon glyphicon-usd">Reportes Ejecutivos Global</a></li> -->
		<li><a href="<?=base_url()?>flujoActividades">Flujo Actividades</a></li>
		<!-- Miguel Jaime 02/11/2020-->
		<li><a href="<?=base_url()?>reportes/reporteCitasOnline">Asesores Citas Online</a></li>
		
		<? } ?>  
	</ul>
                          
<?php
	if(
		$this->tank_auth->get_userprofile() == "2"
		|| 
		$this->tank_auth->get_userprofile() == "3" 
		|| 
		$this->tank_auth->get_userprofile() == "4"  
	){
?>
	<ul class="miUL">
		<label class="labelMenu">Monitores▼</label> 
		<!--
		<li><a href="<?=base_url()?>monitores" class="glyphicon glyphicon-eye-open"><span></span>Semaforo Actividades</a></li>
		-->
        <li>
        	<a 
            	class="glyphicon glyphicon-download-alt" 
				style="cursor: pointer;" 
				onclick="mandaSemaforoActividades(event,'SemaforoActividades')"
			>
				<span>Monitor Operativo</span>
			</a>
        </li>
		<li><a href="<?=base_url()?>ejecutivos" class="glyphicon glyphicon-usd">Reporte Operativo</a></li>
		<li><a href="<?=base_url()?>reportes/EstadoFinanciero" class="glyphicon glyphicon-usd">Estado financiero</a></li>
		<li><a href="<?=base_url()?>presupuestos/controlPresupuesto" class="glyphicon glyphicon-usd">Control de Presupuesto</a></li>
		<li><a href="<?=base_url()?>controlAsistenciaEvento" class="glyphicon glyphicon-check">&nbspMonitor de asistencia a capacitación</a></li>
		<!--<li><a href="<?=base_url()?>controlMetaComercial" class="glyphicon glyphicon-piggy-bank">&nbspMonitor de metas comerciales</a></li> -->
		<?
        if($usermail == "DESARROLLO@AGENTECAPITAL.COM" || $usermail=="AUDITORINTERNO@AGENTECAPITAL.COM"  || $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $usermail == "SISTEMAS@ASESORESCAPITAL.COM" || $usermail=="DIRECTORCOMERCIAL@AGENTECAPITAL.COM" || $usermail=="CONSULTOR@CAPITALRISK.COM.MX" || $usermail=="GERENTEOPERATIVO@AGENTECAPITAL.COM"){ 
		?> 
         	<li><a href="<?=base_url()?>reportes/pagoCompania" class="glyphicon glyphicon-usd">Pago de Companias</a></li>
		 <li><a href="<?=base_url()?>controlMetaComercial" class="glyphicon glyphicon-piggy-bank">&nbspMonitor de metas comerciales</a></li> 
		<?php } 
		if($usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"){ ?> 
		 <li><a href="<?=base_url()?>reportes/cuadroMando" class="glyphicon glyphicon-equalizer">Cuadro de Mando</a></li>
		<?php }?>

	</ul>
	<form method="post" action="<?=base_url()?>monitores/verMonitor" id="enviarFormMonitor">
		<input type="hidden" name="monitorear" id="monitorearMenu">
	</form>
<script>
	function mandaSemaforoActividades(objeto,vista){
		objeto.preventDefault();
		document.getElementById('monitorearMenu').value=vista;
		document.getElementById('enviarFormMonitor').submit();
	}
</script>
<?php
	}
?> 
	<ul class="miUL">
    	<label class="labelMenu">Actividades▼</label> 
		<li><a href="<?=base_url()?>actividades" class="glyphicon glyphicon-eye-open"><span></span>Consultar</a></li>
		<?php if($usermail!="CESCAMILLA@ASESORESCAPITAL.COM"){?>
		<li><a href="<?=base_url()?>actividades/agregar" class="glyphicon glyphicon-download-alt"><span></span>Crear</a></li><?php } ?>

		        <?php
		if($usermail == "DESARROLLO@AGENTECAPITAL.COM" || $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $usermail == "SISTEMAS@ASESORESCAPITAL.COM" || $usermail =="GERENTEOPERATIVO@AGENTECAPITAL.COM" || $usermail =="COORDINADOROPERATIVO@ASESORESCAPITAL.COM" || $usermail =="AUDITORINTERNO@AGENTECAPITAL.COM" || $usermail=="CONSULTOR@CAPITALRISK.COM.MX" || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"){
		?>
		<li><a href="<?=base_url()?>actividades/importante" class="glyphicon glyphicon-eye-open"><span></span>Importantes</a></li>
        <?php
		}
		?>
        <?php
		if($usermail == "DESARROLLO@AGENTECAPITAL.COM" || $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $usermail == "SISTEMAS@ASESORESCAPITAL.COM" || $usermail=="CONSULTOR@CAPITALRISK.COM.MX" || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"){
		?>
		<li><a href="<?=base_url()?>actividades/correosImportantes" class="glyphicon glyphicon-envelope"><span></span>Correos Importantes</a></li>
        <?php
		}
		?>
        <?php
		if($usermail == "DESARROLLO@AGENTECAPITAL.COM" || $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $usermail == "SISTEMAS@ASESORESCAPITAL.COM" || $usermail=="GERENTEOPERATIVO@AGENTECAPITAL.COM" || $usermail=="COORDINADOROPERATIVO@ASESORESCAPITAL.COM" || $usermail=="CONSULTOR@CAPITALRISK.COM.MX" || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"){
		?>
		<li><a href="<?=base_url()?>actividades/consultaActividades" class="glyphicon"><span>Consulta de Actividades</span></a></li>
        <?php
		}
		?>

		<li >
		<a href="<?=base_url()?>cobranza"><i class="fa fa-user"></i>Cobranza</a>
	</li>
	</ul>

	<ul class="miUL" >
		<label class="labelMenu">Accesorios▼</label>
		<li>
			<a href="<?=base_url()?>tienda" title="Tienda">
            	<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuTienda.png"></span> Tienda
			</a>
		</li>
		<li>
			<a href="<?=base_url()?>capacita" title="Cap.A.Cita">
            	<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Cap.A.Cita
			</a>
		</li>
		<li>
			<a href="<?=base_url()?>mailMasivo" title="Mail">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuMail.png"></span> Mail
			</a>
		</li>
		<li>
			<label class="labelMenu labelSubMenu" style="font-size: 12px;text-decoration: none;">
				&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar"></i> 
				&nbsp;Convocar de &nbsp;&nbsp;Reunion▼
				<div style="font-size: 12px">
		        	<a href="<?=base_url()?>calendario/index">
						<i class="fa fa-cogs"></i> Crear
					</a>
				</div>
				<div style="font-size: 12px">
					<a href="<?=base_url()?>crearLiga/crear_liga_reunion_enviados">
						<i class="fa fa-list"></i>
						 Consultar reuniones
					</a>
				</div>
			</label>
		</li>
		<li>
			<a href="<?=base_url()?>ListaAsistencia" title="Lista de asistencia de eventos">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCalendario.png"></span> Lista de asistencia
			</a>
		</li>
				<li>
			<a href="<?=base_url()?>cproyecto" title="Proyecto">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCalendario.png"></span> Seguimiento
			</a>
		</li>

	</ul>
    
	<ul class="miUL">
		<a  href="<?=base_url()?>binconformidad" title="Buzon">
			<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuMail.png"></span>Buzon Inconformidad
		</a>
	</ul>





<? /* ================= MENU Proyecto 100 ================= */ ?>

	<ul class="miUL" >
    	<a href="<?=base_url()?>crmproyecto/proyecto100" title="ProcesoProspecccion"><span>Prospeccion de negocios</span></a>
		<!--li>
        	<a href="<?=base_url()?>crmproyecto" title="ProcesoProspecccion">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Proceso Prospeccion
			</a>
		</li>
		<? if($this->tank_auth->get_userprofile() == "3" || $this->tank_auth->get_userprofile() == "4" ){ ?>
		<li>
			<a href="<?=base_url()?>crmproyecto/Estadistica" title="Concentrado">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Concentrado
			</a>
		</li>
		<? } ?>
		<li>
        	<a href="<?=base_url()?>crmproyecto/Reportes" title="EstadisticasGerenciales">
            	<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Reportes Prospectos
			</a>
		</li>  
		<li>
			<a href="<?=base_url()?>funnel" title="EstadisticasGerenciales">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Funnel
			</a>
		</li-->
	</ul>   

<? /* ================= MENU COTIZADOR ================= */ ?>
	<ul class="miUL">
		<a href="<?=base_url()?>cotizador" title="Car Capital">
			<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuMail.png"></span> Car Capital
		</a>
	</ul>
    




<? /* ================= MENU ACALL CENTER ================= */ ?>
<?php
	if(
		$usermail == "DESARROLLO@AGENTECAPITAL.COM" 
		|| 
		$usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" 
		|| 
		$usermail == "SISTEMAS@ASESORESCAPITAL.COM" 
		|| 
		$usermail == "MARKETING@AGENTECAPITAL.COM"
	    ||
	    $usermail=="CONSULTOR@CAPITALRISK.COM.MX"
	    || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"
	){
?>
<?/*======================================MENU ENCUESTA==================================*/?>          

	<ul class="miUL">
		
      
		<label class="labelMenu labelMenuAlto">Marketing▼</label>
	       <li>
               <a href="<?=base_url()?>crearLiga/crear_liga_asesores">
				<i class="fa fa-users"> </i>  Liga Asesores Online
               </a>
	       </li>
		<li>
        	<a href="<?=base_url()?>lealtadClientes">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuDirectorio.png"></span> Lealtad Clientes
            </a>
		</li>
		<li>		
			<a  href="<?=base_url()?>smsMasivo" title="Sms">
        	<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuSms.png"></span> SMS
		</a>
		</li>
		<li><label class="labelMenu labelSubMenu" >Telemarketing ►

			<div>
        	<a href="<?=base_url()?>callcenter" title="Prospeccion">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Proceso Telemarketing
			</a>
			<a style=" font-size: 10px"  href="<?=base_url()?>callcenter/Reportes" title="Prospectos Telemarketing">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Edicion Prospectos Telemarketing
			</a>
			</div>
			</label>
		</li>
				
		<li><label class="labelMenu labelSubMenu">Catalogo Tienda ►
			<div>
			<a href="<?=base_url()?>tienda/articulosAgregar" title="Agregar Articulos">
            	<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuTienda.png"></span> Agregar Articulos
			</a>
				<a href="<?=base_url()?>tienda/articulosModificar" title="Modificar Articulos">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Modificar Articulos
			</a>
		</div>
			</label> 
		</li>
	
		<li>
					<label class="labelMenu labelSubMenu">Banners ►
						<div>
        	<a href="<?=base_url()?>banners/slideInicio">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuDirectorio.png"></span> Slide Inicio
            </a>
            	<a href="<?=base_url()?>banners/fijos">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuDirectorio.png"></span> Fijos
            </a>
        </div>
            </label> 
		</li>

		

	</ul>
<?php
	}
?>

<? /* ================= MENU PRESUPUESTOS ================= */ ?> 
<?php
	$sqlConsultapermiso		= "select count(up.usuario) as resul from usuariospresupuesto up where up.usuario='".$usermail."'";
	$queryConsultapermiso	= $this->db->query($sqlConsultapermiso);
	if($queryConsultapermiso != FALSE){
		foreach($queryConsultapermiso->result() as $row){ $totalResultados=$row->resul; }
	}
	if($totalResultados>'0'){
?>
	<ul class="miUL">
    	<label class="labelMenu">Presupuestos▼</label> 
		<li>
        	<a href="<?=base_url()?>presupuestos" title="Proveedores">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Proveedores
            </a>
		</li>
		<li>
			<a href="<?=base_url()?>presupuestos/Vistafacturas" title="Facturas">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Agregar Factura
			</a>
		</li>  
				<li>
			<a href="<?=base_url()?>presupuestos/VistafacturasTodas" title="Facturas">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Facturas
			</a>
		</li>         
		<?
        if(
			$usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" 
			|| 
			$usermail == "SISTEMAS@ASESORESCAPITAL.COM" 
			||
			$usermail == "CONTABILIDAD@AGENTECAPITAL.COM"
			||
			$usermail=="CONSULTOR@CAPITALRISK.COM.MX"
			|| $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"
			|| $usermail =="ASISTENTEGENERAL@AGENTECAPITAL.COM"
		){
		?>
		<li>
			<a href="<?=base_url()?>presupuestos/Validaf" title="Validar Factura">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Validar Factura
			</a>
		</li>
				<li>
			<a href="<?=base_url()?>contabilidad" title="Validar Factura">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Contabilidad</image></span></a>
			</li>

		<? } ?>
		<? 
		if(
			$usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" 
			|| 
			$usermail == "SISTEMAS@ASESORESCAPITAL.COM" 
			|| 
			$usermail == "ASISTENTEGENERAL@AGENTECAPITAL.COM"
			||
			$usermail=="CONSULTOR@CAPITALRISK.COM.MX"
			|| $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"
		){?>  
							<li>
			<a href="<?=base_url()?>cheques" title="Validar Factura">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Depositos</image></span></a>
			</li>      
		<li>
			<a href="<?=base_url()?>presupuestos/AutorizaPago" title="Autorizar Pagos">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Autorizar Pago
			</a>
		</li>
		<? } ?>
		<? 
		if(
			$usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" 
			|| 
			$usermail == "SISTEMAS@ASESORESCAPITAL.COM" 
			|| 
			$usermail == "ASISTENTEGENERAL@AGENTECAPITAL.COM"
			||
			$usermail=="CONSULTOR@CAPITALRISK.COM.MX"
			|| 
			$usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"
            ||
            $usermail == "CONTABILIDAD@AGENTECAPITAL.COM"  
		){
		?>
		<li>
			<a href="<?=base_url()?>presupuestos/ListaPagosAutorizar" title="Aplicar Pagos">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Aplicar Pago
			</a>
		</li>
				<li>
			<a href="<?=base_url()?>ReportePresupuesto" title="Aplicar Pagos">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Reportes
			</a>
		</li>

		<? } ?>   
	</ul>
<?php
	}
?>

<? /* ================= MENU ASISTENCIAS ================= */ ?> 
<?php
	if(
		$this->tank_auth->get_userprofile() == "3" 
		|| 
		$this->tank_auth->get_userprofile() == "4" 
		|| 
		$this->tank_auth->get_userprofile() == "5"    
	){
?>
	 <ul class="miUL">
		<a href="<?=base_url()?>capitalHumano" title="Capital Humano">
			<span><i class="fa fa-users"></i></span> Capital Humano
		</a>
	</ul>
	<?php if($usermail=="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" ||
	$usermail=="COORDINADORCARIBE@AGENTECAPITAL.COM" ||
	$usermail=="COORDINADOR@FIANZASCAPITAL.COM" ||
	$usermail=="COORDINADOR@CAPCAPITAL.COM.MX" ||
	$usermail=="COORDINADOR@ASESORESCAPITAL.COM" ||
	$usermail=="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" ||
	$usermail=="COORDINADORCORPORATIVO@AGENTECAPITAL.COM" ||
	$usermail=="COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM" ||
	$usermail=="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" ||
	$usermail=="COORDINADOROPERATIVO@ASESORESCAPITAL.COM" ||
	$usermail=="COORDINADOR_BAJA@CAPCAPITAL.COM.MX") {?> 
	
		<ul class="miUL">
		<a href="<?=base_url()?>metacomercial" title="Capital Humano">
			<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span>
			Asigna mensualidad MC
		</a>
	</ul>
	
	<?php }?>
	<!--
	<ul class="miUL">
		<label>Capital Humano▼</label> 
		
		<li>
        	<a href="<?=base_url()?>persona/agente">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Alta Usuarios
            </a>
		</li>
		<li>
        	<a href="<?=base_url()?>evaluaciones">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Evaluaciones
            </a>
		</li>

<?php 
	$email	= $this->tank_auth->get_usermail(); 
	if(
		$email == "SISTEMAS@ASESORESCAPITAL.COM" 
		|| 
		$email == "AUDITORINTERNO@AGENTECAPITAL.COM" 
		|| 
		$email=="CAPITALHUMANO@AGENTECAPITAL.COM" 
		|| 
		$email=="DIRECTORGENERAL@AGENTECAPITAL.COM"
		||
		$email="PROYECTO@AGENTECAPITAL.COM.MX"
	){
?>
		<li>
        	<a href="<?=base_url()?>capitalHumano">
            	<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Puestos
			</a>
		</li>
<?php
	}
?>
		<li>
        	<a href="<?=base_url()?>asistencias">
            	<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Asistencias
			</a>
		</li>
	</ul>
<?php
	}
?>
-->



<?php
   $email	= $this->tank_auth->get_usermail(); 
	if($email == "SISTEMAS@ASESORESCAPITAL.COM" || $email == "AUDITORINTERNO@AGENTECAPITAL.COM" || $email=="CAPITALHUMANO@AGENTECAPITAL.COM" || $email=="DIRECTORGENERAL@AGENTECAPITAL.COM" || $email=="PROYECTO@AGENTECAPITAL.COM.MX" || $usermail=="CONSULTOR@CAPITALRISK.COM.MX" || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"
	){
?>
	<ul class="miUL">
		<label class="labelMenu">Auditoria▼</label> 
		<li>
        	<a href="<?=base_url()?>permisosOperativos">
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Configuraciones
            </a>            
		</li>
		<li>
        	<a href="<?=base_url()?>clientes" >
				<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Clientes
            </a>
		</li>

		<li>
			<label class="labelMenu labelSubMenu" >Modulo de Calidad ►
				<div>
		        	<a class="labelMenu labelSubMenu" href="<?=base_url()?>procesamientoNC" title="Incidencias">
						<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Incidencias
					</a>
				</div>

				<div style="position: relative;z-index: 3;">
		        	<a href="<?=base_url()?>encuesta/">	
					<span><image src="<?=base_url()?>assets/images/icons-menu/icon-menuCapacita.png"></span> Encuestas
					</a>
					<!--<div id="menu_encuestas">
						<a href="<?=base_url()?>encuesta/" title="Encuestas">
							<span><i class="fa fa-circle-thin"></i> Encuestas</span> 
						</a>
						<a href="<?=base_url()?>pregunta" title="Preguntas">
							<span><i class="fa fa-circle-thin"></i> Alta de Encuestas</span> 
						</a>
						<a href="<?=base_url()?>asigna" title="Asignar">
							<span><i class="fa fa-circle-thin"></i> Asignar</span> 
						</a>
						<a  href="<?=base_url()?>VerEncuesta" title="Encuestas Activas">
							<span><i class="fa fa-circle-thin"></i> Ver Encuestas</span>
						</a>
					</div> -->
				</div>
		</li>

	</ul>
<?php
	}
?>
<? /* ================= MENU Siniestros TIC ================= */ ?> 
<ul class="miUL">
		<a href="<?=base_url()?>Siniestros" title="Mi Info"><i class="fa fa-car"></i> Siniestros</a>
</ul>

<?php
	}
?>


	<div id="agrupa2" class="miULDiv divhover" onclick="muestraContenido()"> 
		........▼
		<div class="divOculto" id="miCapaCont"></div>
	</div>

	<div style="clear: both;"></div>

</ul>

</header>
<?php
if($this->uri->segment(1) == "crmproyecto" || $this->uri->segment(1) == "funnel"){
	$bannerCicloV = TRUE;
?>
	<div id="marquesinaCiclo" class="marquesinaGeneral"></div>
<?php
} else {
	$bannerCicloV = "0";
}
?>

<style type="text/css">
#ventana-flotanteBL 
{width: 90%;height:90%;background: white;position: absolute;top: 10px;left: 5%;
 box-shadow: 0 5px 25px rgba(0,0,0,.1);  /* Sombra */
 z-index:999999;overflow:scroll;padding-bottom:50px;padding-top: 50px;bottom: 200px;
}
.ver{visibility:visible;}
#ventana-flotanteBL .cerrar {
float: right;border-bottom: 1px solid #bbb;border-left: 1px solid #bbb;color: #999;background: red;line-height: 17px;text-decoration: none;
padding: 0px 14px;font-family: Arial;border-radius: 0 0 0 5px;box-shadow: -1px 1px white;font-size: 18px;-webkit-transition: .3s;-moz-transition: .3s;-o-transition: .3s;
-ms-transition: .3s;
}
#ventana-flotanteBL .cerrar:hover {background: #ff6868;color: white;text-decoration: none;text-shadow: -1px -1px red;border-bottom: 1px solid red;border-left: 1px solid red;}
.ocultoInicio {visibility:hidden;}
.oculto {-webkit-transition:1s;-moz-transition:1s;-o-transition:1s;-ms-transition:1s;opacity:0;-ms-opacity:0;-moz-opacity:0;visibility:hidden;}

.marquesinaGeneral{width: 100%;height: 100px; background-color: #361866; background-size: 100% 90%; background-repeat: no-repeat;}
</style>


<script>
	var bannerCicloV = <?=$bannerCicloV?>;
	var globalMarquesina = 0;
	setTimeout(marquesinaJS, 30000);
	document.getElementById('marquesinaBanner').style.backgroundImage="url('<?=base_url()?>assets/imgBanner/B1/F-1366x100.png')";
	if(bannerCicloV){
		document.getElementById('marquesinaCiclo').style.backgroundImage="url('<?=base_url()?>assets/imgBanner/B_CICLO_VENTA/BANNER_CICLO_1366x100.png')";
	}

	globalMarquesina=1;
	function marquesinaJS(){
		var w = window.outerWidth;var h = window.outerHeight;
		switch(globalMarquesina){
			case 0: 
				document.getElementById('marquesinaBanner').style.backgroundImage = "url('<?=$imgBanner_Marq_0?>')";
				if(bannerCicloV){
					document.getElementById('marquesinaCiclo').style.backgroundImage = "url('<?=$imgBanner_CicVenta?>')";
				}
				globalMarquesina++;  
			break;
			
			case 1: 
				document.getElementById('marquesinaBanner').style.backgroundImage = "url('<?=$imgBanner_Marq_1?>')";
				if(bannerCicloV){
					document.getElementById('marquesinaCiclo').style.backgroundImage = "url('<?=$imgBanner_CicVenta?>')";
				}
				globalMarquesina++; 
			break;
			
			case 2: 
				document.getElementById('marquesinaBanner').style.backgroundImage = "url('<?=$imgBanner_Marq_2?>')";
				if(bannerCicloV){
					document.getElementById('marquesinaCiclo').style.backgroundImage = "url('<?=$imgBanner_CicVenta?>')";
				}
				globalMarquesina++;
			break;
			
			case 3: 
				document.getElementById('marquesinaBanner').style.backgroundImage = "url('<?=$imgBanner_Marq_3?>')";
				if(bannerCicloV){
					document.getElementById('marquesinaCiclo').style.backgroundImage = "url('<?=$imgBanner_CicVenta?>')";
				}
				globalMarquesina=0;
			break;
  }
  setTimeout(marquesinaJS, 30000);
}


var globalAnchoPantalla=0;
window.addEventListener("resize", redimensionarMenu, true)
window.addEventListener("load", redimensionarMenu, true)

function redimensionarMenu(){	
var anchoPantalla=(window.innerWidth);
if(globalAnchoPantalla!=anchoPantalla){
	var menu=document.getElementsByClassName('miUL');var cantBtn=menu.length;
	var anchoBtn=200;var flecha="";var band0=0;	var stringDiv="";
	menu[cantBtn-1].classList.add("miULVisible");

	if(screen.width>=1000){		
	if(anchoPantalla>=600){	
	for(var i=0;i<cantBtn;i++)
	{   	
	   flecha="";
		menu[i].classList.remove("miULOculta");menu[i].classList.add("miULVisible");
		if(band0==0)
		{ 
		  if((anchoBtn+menu[i].clientWidth)<anchoPantalla){anchoBtn=anchoBtn+menu[i].clientWidth+10;}
		  else
		  {
			menu[i].classList.remove("miULVisible");
			menu[i].classList.add("miULOculta");
            stringDiv=stringDiv+'<ul class="divmiULocultar" onclick="muestraContenidSubMenu(this,event)">'+ menu[i].innerHTML+flecha+'</ul>';
			band0=1;
		  }
		}
		else
		{	menu[i].classList.remove("miULVisible");
			menu[i].classList.add("miULOculta");
            stringDiv=stringDiv+'<ul class="divmiULocultar" onclick="muestraContenidSubMenu(this,event)">'+ menu[i].innerHTML+flecha+'</ul>';		
		}

	}
	document.getElementById('miCapaCont').innerHTML=stringDiv;
	var classLabel=document.getElementsByClassName('labelMenu');var cant=classLabel.length;for(var j=0;j<cant;j++){classLabel[j].classList.remove("labelMenuMinimizar");}	
	document.getElementById('miCapaCont').classList.remove('divVisible');
  document.getElementById('miCapaCont').classList.add('divOculto');
  var miULDiv=document.getElementsByClassName('miULDiv');
	 miULDiv[0].style.width="150px";


	}
	else{  
		 		
		for(var i=0;i<cantBtn;i++)
	{    
			menu[i].classList.add("miULOculta");	
            stringDiv=stringDiv+'<ul class="divmiULocultarMovil" onclick="muestraContenidSubMenu(this,event)">'+ menu[i].innerHTML+flecha+'</ul>';
		
	}
	
	document.getElementById('miCapaCont').innerHTML=stringDiv;
	var classLabel=document.getElementsByClassName('labelMenu');var cant=classLabel.length;for(var j=0;j<cant;j++){classLabel[j].classList.add("labelMenuMinimizar");}	
	document.getElementById('miCapaCont').classList.remove('divVisible');
  document.getElementById('miCapaCont').classList.add('divOculto');

	 var miULDiv=document.getElementsByClassName('miULDiv');
	 miULDiv[0].style.width="100px";

}
	}
	else{

	if(menu[0].classList.contains("miULOculta")==false) {
   for(var i=0;i<cantBtn;i++)
	{   
		menu[i].classList.add("miULOculta");	
        stringDiv=stringDiv+'<ul class="divmiULocultarMovil" style="width:1000px"  onclick="muestraContenidSubMenu(this,event)">'+ menu[i].innerHTML+flecha+'</ul>';		
	}
	document.getElementById('miCapaCont').innerHTML=stringDiv;
	var classLabel=document.getElementsByClassName('labelMenu');var cant=classLabel.length;for(var j=0;j<cant;j++){classLabel[j].classList.add("labelMenuMinimizar");}	
	document.getElementById('miCapaCont').classList.remove('divVisible');
  document.getElementById('miCapaCont').classList.add('divOculto');
	 var miULDiv=document.getElementsByClassName('miULDiv');
	 miULDiv[0].style.width="400px";
   miULDiv[0].style.height="100px";
   miULDiv[0].style.fontSize="36px";



	}
	}
  globalAnchoPantalla=anchoPantalla;
 }
}
/*-------------MUESTRA LOS CONTENIDOS DE LOS SUBMENUS-----------------*/
function muestraContenidSubMenu(objeto,evento){
if(screen.width>=1000){var estadoClase=objeto.classList[0];		
  if((estadoClase=="divmiULocultar"))
  {objeto.classList.remove('divmiULocultar');objeto.classList.add('divmiULmostrar');}
  else
  {
	 if(estadoClase=="divmiULmostrar"){	objeto.classList.remove('divmiULmostrar');objeto.classList.add('divmiULocultar');
	 }else{
		if(estadoClase=="divmiULocultarMovil"){if(objeto.childNodes.length>4)
      {   objeto.classList.remove('divmiULocultarMovil');objeto.classList.add('divmiULmostrarMovil')}
      else{for(var i=0;i<objeto.childNodes.length;i++){if(objeto.childNodes[i].nodeName=="A"){location.href=objeto.childNodes[i].href}}};

		}else
		{objeto.classList.remove('divmiULmostrarMovil');objeto.classList.add('divmiULocultarMovil');}
	 }		
	}
}
else{var estadoClase=objeto.classList[0];
    if((estadoClase=="divmiULocultarMovil")){
      if(objeto.childNodes.length>4){objeto.classList.remove('divmiULocultarMovil');objeto.classList.add('divmiULmostrarMovil')}else{for(var i=0;i<objeto.childNodes.length;i++){if(objeto.childNodes[i].nodeName=="A"){location.href=objeto.childNodes[i].href}}};
	}else{objeto.classList.remove('divmiULmostrarMovil');objeto.classList.add('divmiULocultarMovil');}	
	}
//}

	}
/*---------------------------------------------------------------------------------*/
/*---------------MUESTRA EL CONTENIDO DEL MENU AL ESTAR MINIMIZADO-----------------*/
function muestraContenido(object){
//alert(object.nodeName);//event.srcElement.nodeName
if(event.srcElement.nodeName=="DIV"){var estadoClase=document.getElementById('miCapaCont').classList[0];
    if((estadoClase=="divOculto")){document.getElementById('miCapaCont').classList.remove('divOculto');document.getElementById('miCapaCont').classList.add('divVisible');
	}else{document.getElementById('miCapaCont').classList.remove('divVisible');document.getElementById('miCapaCont').classList.add('divOculto');		
	}

  }
   
}
function detienePropagacion(e)
{
	e.stopPropagation();
}
/*-------------------------------------------------------------------------------*/

</script>

<style>

label{font-size: 12px}
	.divOculto{display:none;}
	.divOculto:hover { background-color:green; cursor:progress}
	
	.divVisible{ display:block;  height: 50px; }
	.divVisible > ul{ position:relative; left:-40px; top:40px; margin: 0px; border:outset; width: 500px; background-color: #361866;}
	
	.miULDiv{ float:  left; height: 50px; border:solid ; position:relative; top:0px; background-color:#361866; background-size:50px;  background-repeat:no-repeat ;z-index:1; /*50;*/ ; color: white;padding-left: 40px}
	.miULDiv:hover{background-color:#9d8ebf}
	.miULResponsivo{ float:  left; height: 40px; width:1000px; border:solid ; position:relative; top:16px; background-color:#361866;background-size:40px;  background-repeat:no-repeat  }
	
	.miUL:hover > a {background-color:#9d8ebf}
	.miUL:hover > label {background-color:#9d8ebf}
	
	.divmiUL {background-color:#361866;  z-index:120;position:relative; left:-10px}
	
	.divmiULocultar {  position:relative; top:200px; margin:0px; width:50px; background:#361866}
	.divmiULocultar > li{ display:none;  position:relative; top:20px; width: 50px; height: 20px}
	.divmiULocultar > a {  color:white}
	.divmiULocultar > label {  color:white}
	.divmiULocultar:hover{background-color:#9d8ebf}
	.divmiULocultar:hover > a { background-color:#9d8ebf; color:white}
	.divmiULocultar:hover > label { background-color:#9d8ebf; color:white}
	
	.divmiULocultarMovil {  position:relative; top:200px; margin:0px; width:100px;height:100px ; background:#361866, }
	.divmiULocultarMovil > li{ display:none;  position:relative; top:20px; }
	.divmiULocultarMovil > a{  color:white; font-size:36px ;width: 300px;height: 100px;text-decoration: underline; }
	.divmiULocultarMovil > label{  color:white; font-size:36px ; padding: 10px;text-decoration: underline; }
	/*.divmiULocultarMovil:hover{background-color:#9d8ebf; }
	.divmiULocultarMovil:hover > a,label { background-color:#9d8ebf; color:white}*/
	
	.divmiULmostrar{width:150px;padding-left: 0px;}
	.divmiULmostrar > li{ display:block;  width:150px;background-color:#6218da;color:white; margin-left: 15px ;}
	.divmiULmostrar > li > a{ background-color:#6218da;color:white; width: 100px;}

	.divmiULmostrar > li > a:hover{ background-color:#9d8ebf; width: 100px }
	
	.divmiULmostrarMovil{background-color:#361866;color:white; width:1000px}
	.divmiULmostrarMovil > li{ display:block; width:300px; height: 120px;  margin-left:15px;background-color:#361866;color:white }
	.divmiULmostrarMovil > li > a{ background-color:#361866;color:white;font-size:36px;text-decoration: underline ;border: solid }
	.divmiULmostrarMovil > li:hover { background-color:#9d8ebf;font-size:36px }
	.divmiULmostrarMovil > li > a:hover{ background-color:#9d8ebf }
	
	.labelMenu{background-color:#361866;color:white; font-size: 14px; }
	.labelMenu:hover {background-color:#9d8ebf;color:white}
	.labelMenuMinimizar{font-size: 36px; width:1000px}

	
	.miUL{ float:  left; height: 40px; width:100px; border:solid ;display:block ; background-color:#361866;color:#361866; border:double}
	.muUL:hover{ background-color:#9d8ebf}
	.miUL > a{ background-color:#361866;color:white;width: 250px}
	.miUL > li{ display:none; position:relative;; top:-2px; width: 150px  }
	.miUL > li:hover{background-color:#9d8ebf ;border:groove }
	.miUL:hover li{display:block;   z-index:100;  }
	
	.miULVisible{display:block; background-color:#361866; height: 40px; width: auto;padding: 10px }
	.miULVisible > li{background-color:#361866; width: 150px }
	.miULVisible > li > a{color:white; width: 150px;border: outset}
	.miULVisible:hover{background-color:#9d8ebf; }
	
	.miULOculta{ display:none}
	.labelSubMenu{border: solid; width: 100%;text-decoration: underline;height: 40px }
.labelSubMenu > div{ display: none;position: relative;left: 140px; top: -25px; }
.labelSubMenu:hover > div{ display: block; }

	</style>
  <script type="text/javascript">
    window.addEventListener("resize",redimensionarCabecera);
redimensionarCabecera();
function redimensionarCabecera()
{var w = window.outerWidth;var h = window.outerHeight;
for(var i=1;i<=5;i++){document.getElementById('fondoCabeceraMenu').classList.remove('stiloLogo'+i);}
 if(w>=1360){document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo1');}
 else{if(w<1359 && w>959 ){document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo2');}
     else{if(w<960 && w>900){document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo3');}
         else{if(w<901 && w>320){document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo4');}
              else{document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo5');}}
         }

     }
 }

  </script>
<style type="text/css">
	.ocultarRowsDeColaboradores{display: none;}
</style>
<script type="text/javascript">
	function verRowsDeColaboradores(objeto,event,nombreClase)
 {
 	
 	event.preventDefault();
 	event.stopPropagation()
 	if(objeto.innerHTML=='+')
    {objeto.innerHTML='-';
      let cant=document.getElementsByName(nombreClase).length;
      for(let i=0;i<cant;i++)
      {
      	document.getElementsByName(nombreClase)[i].classList.remove('ocultarRowsDeColaboradores');
      }       
     }
 	else
 	{
 		objeto.innerHTML='+';
 		let cant=document.getElementsByName(nombreClase).length;
      for(let i=0;i<cant;i++)
      {
      	document.getElementsByName(nombreClase)[i].classList.add('ocultarRowsDeColaboradores');
      } 
 	}
 }
</script>
<?
function imprimirColaboradoresCabecera($datos)
{
	$div='<table class="table">';
   foreach ($datos as $key1 => $value1) 
   {
        $className=str_replace(' ', '', $value1['Name']);        
    $div.='<tr><td><button class="btn btn-primary" onclick="verRowsDeColaboradores(this,event,\''.$className.'\')">+</button></td><td>'.$value1['Name'].'</td></tr>';
    foreach ($value1['Data'] as $key => $value) 
    {
     $nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
     
     $div.='<tr class="bg-primary ocultarRowsDeColaboradores" name="'.$className.'"><td>'.$nombres.'</td><td><div class="row"><label class="glyphicon glyphicon-send">	'.$value['email'].'</label></div><div class="row"><label class="glyphicon glyphicon-earphone"> '.$value['telOficina'].'</label></div><div class="row"><label>Ext: '.$value['telOficinaExtension'].'</label></div><div class="row"><label class="glyphicon glyphicon-phone"> '.$value['celOficina'].'</label></div></td></tr>';
    }
    
  
  }	
  $div.='</table>';
  return $div;
}
?>
