<script type="text/javascript">
	function cambiaVariableSecion(){
		document.getElementById("ventana-flotanteBL").className = "oculto";
		$.ajax({
			method:		"POST",
			dataType:	"html",
			url:		"<?= base_url();?>cambiaVariableSecion/cierraBox",              
			data:		{gato:'perro'},
			async:		true,
			success:	function(result){ /* El codigo que vas a hacer funcionar cuando tenga exito el ajax */ },
            error:		function() { /* El codigo que vas a hacer cuando falle el ajax */ }
		})
	}
</script>
<?
session_start(); 
	$configModulos	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
	$activa			= $this->uri->segment(1);
	$path_foto		= "assets/img/miInfo/userPhotos/";
    $foto			= "";
	$usermail		= $this->tank_auth->get_usermail();
	foreach($configModulos as $modulos){ }
	if(file_exists( $path_foto . $this->tank_auth->get_usermail().".jpg")){ 
		$foto = $path_foto . $this->tank_auth->get_usermail().".jpg"; 
	} else {
		$foto = $path_foto . "noPhoto.png";
	}
	if(isset($_SESSION['BOXLIGHT'])){
		if($_SESSION['BOXLIGHT']){
?>  
	<div id='ventana-flotanteBL'>
		<a class='cerrar' href='javascript:void(0);' onclick='cambiaVariableSecion ()'>x</a>
		<img style="height: 100%;width: 100%" src="<?= base_url(); ?>assets/imgBanner/nuestrosagentes.png">
	</div>
<? //$_SESSION['BOXLIGHT']=FALSE;
		}
	}
?>
<header>
	<div>
		<div class="fondoCabeceraMenu" >
			<div  style="visibility: hidden;height: 1px">
				<a href="./" class="navbar-brand" title="Capsys Web - Inicio">
					<img src="<?= base_url(); ?>assets/images/logo-Capsys.png" alt="CAPSYS">
                </a>
            </div>
			<ul class="user-perfil pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="usuario-nombre"><?= $this->tank_auth->get_usermail(); ?></span>
						<i class="caret"></i>
						<div class="user-perfil-extra hidden-xs">
							<p>
								<?= $this->tank_auth->get_usernamecomplete(); ?> 
								<span class="badge">
								<?
									if($this->capsysdre->RankingUsuarioEmail($this->tank_auth->get_usermail()) != ""){
										echo $this->capsysdre->RankingUsuarioEmaildeMiinfo($this->tank_auth->get_usermail());
									} else {
										echo $this->capsysdre->NombrePerfilUsuario($this->tank_auth->get_userprofile());
									}
								?>
								</span>
							</p>
						</div>
						<img src="<?= base_url().$foto; ?>" width="55;" alt="<?= $this->tank_auth->get_usernamecomplete(); ?>" class="img-circle">
					</a> 
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-perfil">
						<li>
							<a href="<?=base_url()?>miInfo" title="Mi Info">
								<i class="fa fa-user"></i> Mi Info
                            </a>
                        </li>
						<?
						if(in_array('configuraciones',$modulos)){
						?>
                        <li>
							<a href="<?=base_url()?>configuraciones" title="Configuración">
								<i class="fa fa-cogs"></i> Configuración
							</a>
						</li>
						<?
						}
						?>
						<?
						if(in_array('credenciales',$modulos)){
                        ?>
						<li>
							<a href="<?=base_url()?>validaciones" title="credenciales">
								<i class="fa fa-cogs"></i> Credenciales
							</a>
                        </li>
						<?
						}
						?>
						<li>
							<a  href="<?=base_url()?>index.php/auth/logout" title="Salir">
								<i class="fa fa-sign-out"></i> Salir
							</a>
                        </li>
					</ul>
				</li>
			</ul>
		</div><!-- fondoCabeceraMenu -->
		<div id="bannerGira" name="bannerGira" class="bannerG"></div>
	</div>
    <!-- Menu Master -->
	<nav class="navbar navbar-default">
		<div class="container-fluid menu-navbar">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="navbar"  class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
                <?
				$correoProcedente	= $this->tank_auth->get_usermail();
				$carcapital 		= $this->capsysdre->GetCarcapitalxEmail($correoProcedente);
				if($carcapital=='1'){
				?>
                	<!-- Reportes -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#">Page 1-1</a></li>
							<li><a href="#">Page 1-2</a></li>
							<li><a href="#">Page 1-3</a></li>
						</ul>
					</li>
                	
                    <!-- Proyecto100 -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#">Page 1-1</a></li>
							<li><a href="#">Page 1-2</a></li>
							<li><a href="#">Page 1-3</a></li>
						</ul>
					</li>
                	
                    <!-- Car Capital -->
                    <li>
						<a href="<?=base_url()?>cotizador" title="Car Capital">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuMail.png"></span>Car Capital
                        </a>
					</li>
                <?
				} else {
				?>
                	<?
					/* Agentes */
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
					<!-- Agentes [01]				-->
					<li <?php if($activa == 'configuraciones' && $this->uri->segment(2)=="listVend2"){ echo "class='active'"; } ?>>
						<a href="<?=base_url()?>configuraciones/listVend2">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuDirectorio.png"></span> Agentes
						</a>
					</li>
					<?
					}
					/* /Agentes */
					?>

					<!-- Directorio [02]			-->
					<li <?php if ($activa == 'directorio'){ echo "class='active'"; } ?>>
						<a href="<?=base_url()?>directorio">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuDirectorio.png"></span> Directorio
						</a>
					</li>

					<!-- Reportes * [03]			-->
					<li class="dropdown <?= ($activa=="produccion" || $activa=="renovaciones" || $activa=="cobranzaPendiente" || $activa=="cobranzaEfectuada" || $activa=="cobranzaCancelada" || $activa=="siniestros" || $activa=="honorarios" || $activa=="buscaXfolio" || $activa=="ejecutivos")? "active":""; ?>">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span> Reportes
                            <span class="caret"></span>
                        </a>
						<ul class="dropdown-menu">
							<li class="<?= ($activa=="renovaciones")? "active":""; ?>">
								<a href="<?=base_url()?>renovaciones"><span class="glyphicon glyphicon-usd"></span> Renovaciones</a>
							</li>
							<li class="<?= ($activa=="produccion")? "active":""; ?>">
								<a href="<?=base_url()?>produccion"><span class="glyphicon glyphicon-usd"></span> Cartera</a>
							</li>
							<li class="<?= ($activa=="cobranzaPendiente")? "active":""; ?>">
    	                        <a href="<?=base_url()?>cobranzaPendiente"><span class="glyphicon glyphicon-usd"></span> Cob. Pendiente</a>
                            </li>
							<li class="<?= ($activa=="cobranzaEfectuada")? "active":""; ?>">
	                            <a href="<?=base_url()?>cobranzaEfectuada"><span class="glyphicon glyphicon-usd"></span> Cob. Efectuada</a>
                            </li>
							<li class="<?= ($activa=="cobranzaCancelada")? "active":""; ?>">
                            	<a href="<?=base_url()?>cobranzaCancelada"><span class="glyphicon glyphicon-usd"></span> Cob. Cancelada</a>
                            </li>
							<li class="<?= ($activa=="siniestros")? "active":""; ?>">
                            	<a href="<?=base_url()?>siniestros"><span class="glyphicon glyphicon-usd"></span> Siniestros</a>
                            </li>
							<li class="<?= ($activa=="honorarios")? "active":""; ?>">
                            	<a href="<?=base_url()?>honorarios"><span class="glyphicon glyphicon-usd"></span> Honorarios</a>
                            </li>
							<li class="<?= ($activa=="buscaXfolio")? "active":""; ?>">
                            	<div class="form-group form-group-sm">
								<form action="<?=base_url();?>buscaXfolio" method="POST" class="form">
									<input type="text" id="TbuscarXfolio" name="TbuscarXfolio" class="form-control input-sm">
                                    <div align="right">
										<button type="submit" class="btn btn-primary" name="Consulta" id="Consulta">Buscar Poliza</button>
									</div>
                            	</form>
                            	</div>                                
                            </li>
							<?
							if(
							$this->tank_auth->get_userprofile() == "2"
							||
							$this->tank_auth->get_userprofile() == "3"
							||
							$this->tank_auth->get_userprofile() == "4"
							){
							?>
							<li class="<?= ($activa=="ejecutivos")? "active":""; ?>">
								<a href="<?=base_url()?>ejecutivos"><span class="glyphicon glyphicon-usd"></span> Reportes Ejecutivos</a>
							</li>
							<li class="<?= ($activa=="ejecutivos" && $this->uri->segment(2)=="ConsultaGlobal")? "active":""; ?>">
                            	<a href="<?=base_url()?>ejecutivos/ConsultaGlobal"><span class="glyphicon glyphicon-usd"></span> Reportes Ejecutivos Global</a>
							</li>
                            <?
							}
							?>
                        </ul>
					</li>

					<!-- Monitores [04]				-->
					<?
					/* Monitores */
					if(
						$this->tank_auth->get_userprofile() == "2"
						||
						$this->tank_auth->get_userprofile() == "3"
						||
						$this->tank_auth->get_userprofile() == "4"
					){
					?>
					<li class="<?= ($activa=="monitores")?"active":""; ?>">
						<a href="<?=base_url()?>monitores">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuReportes.png"></span> Monitores
						</a>
					</li>
					<?
					}
					/* /Monitores */
					?>
                    
					<!-- Actividades * [05]			-->
					<li class="dropdown <?= ($activa=="actividades")? "active":""; ?>">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span> Actividades
                            <span class="caret"></span>
                        </a>
						<ul class="dropdown-menu">
							<li class="<?= ($activa=="actividades"  && $this->uri->segment(2)==NULL)? "active":""; ?>">
								<a  href="<?=base_url()?>actividades"><span class="glyphicon glyphicon-eye-open"></span> Consultar</a>
							</li>
							<li class="<?= ($activa=="actividades" && $this->uri->segment(2)=="agregar")? "active":""; ?>">
								<a href="<?=base_url()?>actividades/agregar"><span class="glyphicon glyphicon-download-alt"></span> Crear</a>
							</li>
						</ul>
					</li>

					<!-- Accesorios * [06]			-->
					<li class="dropdown <?= (($activa=="tienda" && $this->uri->segment(2)==NULL) || $activa=="capacita" || $activa=="mailMasivo" || $activa=="calendario")? "active":""; ?>">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span> Accesorios
                            <span class="caret"></span>
                        </a>
						<ul class="dropdown-menu">
							<li class="<?= ($activa=="tienda")? "active":""; ?>">
								<a href="<?=base_url()?>tienda">
									<span class="glyphicon glyphicon-shopping-cart"></span> Tienda
								</a>
							</li>
							<li class="<?= ($activa=="capacita")? "active":""; ?>">
								<a href="<?=base_url()?>capacita">
									<span class="glyphicon glyphicon-blackboard"></span> Cap.A.Cita
								</a>
							</li>
							<li class="<?= ($activa=="mailMasivo")? "active":""; ?>">
								<a href="<?=base_url()?>mailMasivo">
									<span class="glyphicon glyphicon-envelope"></span> Mail
								</a>
							</li>
							<li class="<?= ($activa=="calendario")? "active":""; ?>">
								<a href="<?=base_url()?>calendario/index">
									<span class="glyphicon glyphicon-calendar"></span> Calendario
								</a>
							</li>
						</ul>
					</li>

					<!-- Buzon Inconformidad [07]	-->
					<li class="<?= ($activa=="binconformidad")?"active":""; ?>">
						<a href="<?=base_url()?>binconformidad">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuMail.png"></span> Buzon Inconformidad
						</a>
					</li>
                    
					<!-- Sms [08]					-->
					<?
					/* Sms */
					if(
				        $usermail == "DESARROLLO@AGENTECAPITAL.COM"
				        ||
				        $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
				        ||
				        $usermail == "SISTEMAS@ASESORESCAPITAL.COM"
					){
					?>
					<li class="<?= ($activa=="smsMasivo")?"active":""; ?>">
						<a href="<?=base_url()?>smsMasivo">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuSms.png"></span> SMS
						</a>
					</li>
					<?
					}
					/* /Sms */
					?>
                    
					<!-- Catalogo tienda* [09]		-->
					<?
					/* Catalogo tienda */
					if(
						$usermail == "DESARROLLO@AGENTECAPITAL.COM"
						||
						$usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
						||
						$usermail == "SISTEMAS@ASESORESCAPITAL.COM"
						||
						$usermail == "MARKETING@AGENTECAPITAL.COM"
					){
					?>
					<li class="dropdown <?= ($activa=="tienda")? "active":""; ?>">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuTienda.png"></span> Catalogo Tienda
                            <span class="caret"></span>
                        </a>
						<ul class="dropdown-menu">
							<li class="<?= ($activa=="tienda" && $this->uri->segment(2)=="articulosAgregar")? "active":""; ?>">
								<a href="<?=base_url()?>tienda/articulosAgregar">
									<span class="glyphicon glyphicon-shopping-cart"></span> Agregar Articulos
								</a>
							</li>
							<li class="<?= ($activa=="tienda" && $this->uri->segment(2)=="articulosModificar")? "active":""; ?>">
								<a href="<?=base_url()?>tienda/articulosModificar">
									<span class="glyphicon glyphicon-shopping-cart"></span> Modificar Articulos
								</a>
							</li>                        
						</ul>
					</li>
                    <?
					}
					/* /Catalogo tienda */
					?>

					<!-- Proyecto100* [10]			-->
					<li class="dropdown <?= ($activa=="crmproyecto" || $activa=="funnel")? "active":""; ?>">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span> Proyecto100
                            <span class="caret"></span>
                        </a>
						<ul class="dropdown-menu">
							<li class="<?= ($activa=="crmproyecto" && $this->uri->segment(2)==NULL)?"active":""; ?>">
								<a href="<?=base_url()?>crmproyecto">
									<span class="glyphicon glyphicon-blackboard"></span> Proceso Prospeccion
								</a>
							</li>
							<li class="<?= ($activa=="crmproyecto" && $this->uri->segment(2)=="Reportes")?"active":""; ?>">
								<a href="<?=base_url()?>crmproyecto/Reportes">
									<span class="glyphicon glyphicon-blackboard"></span> Reportes Prospectos
								</a>
							</li>
							<li class="<?= ($activa=="funnel")?"active":""; ?>">
								<a href="<?=base_url()?>funnel">
									<span class="glyphicon glyphicon-blackboard"></span> Funnel
								</a>
							</li>
							<?
							if(
								$this->tank_auth->get_userprofile() == "3"
								||
								$this->tank_auth->get_userprofile() == "4"
							){
							?>
							<li class="<?= ($activa=="crmproyecto" && $this->uri->segment(2)=="Estadistica")?"active":""; ?>">
								<a href="<?=base_url()?>crmproyecto/Estadistica">
									<span class="glyphicon glyphicon-blackboard"></span> Concentrado
								</a>
							</li>
							<?
							}
							?>
						</ul>
					</li>

					<!-- Car Capital [11]			-->
					<li class="<?= ($activa=="cotizador")?"active":""; ?>">
						<a href="<?=base_url()?>cotizador" target="new">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuMail.png"></span> Car Capital
						</a>
					</li>

					<!-- Presupuestos * [12]		-->
					<?
					/* Presupuestos */
					$sqlConsultapermiso		= "Select Count(up.usuario) As resul From usuariospresupuesto up Where up.usuario='".$usermail."'";
					$queryConsultapermiso	= $this->db->query($sqlConsultapermiso);
					if($queryConsultapermiso != FALSE){
						foreach ($queryConsultapermiso->result() as $row){
							$totalResultados	= $row->resul;
						}
					}
					if($totalResultados>'0'){
					?>
					<li class="dropdown <?= ($activa=="presupuestos" || $activa=="funnel")? "active":""; ?>">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span> Presupuestos
                            <span class="caret"></span>
                        </a>
						<ul class="dropdown-menu">
							<li class="<?= ($activa=="presupuestos" && $this->uri->segment(2)==NULL)?"active":""; ?>">
								<a href="<?=base_url()?>presupuestos">
									<span class="glyphicon glyphicon-blackboard"></span> Proveedores
								</a>
							</li>
							<li class="<?= ($activa=="presupuestos" && $this->uri->segment(2)=="Vistafacturas")?"active":""; ?>">
								<a href="<?=base_url()?>presupuestos/Vistafacturas">
									<span class="glyphicon glyphicon-blackboard"></span> Agregar Factura
								</a>
							</li>
							<?
							if(
								$usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
								||
								$usermail == "SISTEMAS@ASESORESCAPITAL.COM"
								||
								$usermail == "CONTABILIDAD@AGENTECAPITAL.COM"
							){
							?>
							<li class="<?= ($activa=="presupuestos" && $this->uri->segment(2)=="Validaf")?"active":""; ?>">
								<a href="<?=base_url()?>presupuestos/Validaf">
									<span class="glyphicon glyphicon-blackboard"></span> Validar Factura
								</a>
							</li>
							<li class="<?= ($activa=="presupuestos" && $this->uri->segment(2)=="AutorizaPago")?"active":""; ?>">
								<a href="<?=base_url()?>presupuestos/AutorizaPago">
									<span class="glyphicon glyphicon-blackboard"></span> Autorizar Pago
								</a>
							</li>
							<li class="<?= ($activa=="presupuestos" && $this->uri->segment(2)=="ListaPagosAutorizar")?"active":""; ?>">
								<a href="<?=base_url()?>presupuestos/ListaPagosAutorizar">
									<span class="glyphicon glyphicon-blackboard"></span> Aplicar Pago
								</a>
							</li>
							<?
							}
							?>
                        </ul>
					</li>
					<?
					}
					/* /Presupuestos */
					?>

					<!-- Asistencias [13]			-->
					<?
					/* Asistencias */
					if(
						$this->tank_auth->get_userprofile() == "3"
						||
						$this->tank_auth->get_userprofile() == "4"
						||
						$this->tank_auth->get_userprofile() == "5"
					){
					?>
					<li class="<?= ($activa=="asistencias")?"active":""; ?>">
						<a href="<?=base_url()?>asistencias">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuReportes.png"></span> Asistencias
						</a>
					</li>
					<?
					}
					/* /Asistencias */
					?>
                    
                    <!-- Telemarketing * [14]		-->
					<?
					/* Telemarketing */
					if(
						$this->tank_auth->get_userprofile() == "3"
						||
						$this->tank_auth->get_userprofile() == "4"
						||
						$this->tank_auth->get_userprofile() == "5"
					){
					?>
					<li class="dropdown <?= ($activa=="callcenter" || $activa=="funnel")? "active":""; ?>">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span> Telemarketing
                            <span class="caret"></span>
                        </a>
						<ul class="dropdown-menu">
							<li class="<?= ($activa=="callcenter" && $this->uri->segment(2)==NULL)?"active":""; ?>">
								<a href="<?=base_url()?>callcenter">
									<span class="glyphicon glyphicon-blackboard"></span> Proceso Telemarketing
								</a>
							</li>
							<li class="<?= ($activa=="callcenter" && $this->uri->segment(2)=="Reportes")?"active":""; ?>">
								<a href="<?=base_url()?>callcenter/Reportes">
									<span class="glyphicon glyphicon-blackboard"></span> Edicion Prospectos Telemarketing
								</a>
							</li>
                        </ul>
					</li>
					<?
					}
					/* /Telemarketing */
					?>
                    
                <?
				} /* /$carcapital=='1' */
				?>      
                </ul><!-- /nav navbar-nav -->
			</div>
		</div>
	</nav>
    <!-- /Menu Master -->
</header>