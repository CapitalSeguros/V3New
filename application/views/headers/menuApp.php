<?
session_start();
$ci	= &get_instance();
$ci->load->model("menu_model");
?>

<?
$activa			= $this->uri->segment(1);
$path_foto		= "assets/img/miInfo/userPhotos/";
$foto			= "";
$usermail		= $this->tank_auth->get_usermail();
$idPersona		= $this->tank_auth->get_idPersona();
$imagenPersona	= $ci->menu_model->buscaFotoPersonal($this->tank_auth->get_idPersona());

if(count($imagenPersona)>0){

	$foto	= "archivosPersona/"
			  .$imagenPersona[0]->idPersona
			  ."/miFoto/"
			  .$imagenPersona[0]->idPersonaImagen
			  .$imagenPersona[0]->extensionPersonaImagen;

} else {
	$foto	= $path_foto . "noPhoto.png";
}
?>

<header>
	<div>
	  <div class="fondoCabeceraMenu" >
		<ul class="user-perfil pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="usuario-nombre fondoNegro"><?= $this->tank_auth->get_usermail(); ?></span>
						<i class="caret"></i>
						<div class="user-perfil-extra hidden-xs">
							<p class="fondoNegro">
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
							<a  href="<?=base_url()?>index.php/auth/logout" title="Salir">
								<i class="fa fa-sign-out"></i> Salir
							</a>
                        </li>
					</ul>
				</li>
			</ul>
		</div><!-- fondoCabeceraMenu -->
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
            <!-- 
            <a href="<?=base_url()?>inicio">
				<img src="<?=base_url()?>assets/img/logoCapsys_Navbar.png" height="50" width="100" />
            </a>
            -->
			</div>
			
            <div id="navbar"  class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
                <?
				//$correoProcedente	= $this->tank_auth->get_usermail();
				//$carcapital 		= $this->capsysdre->GetCarcapitalxEmail($correoProcedente);
				//if($carcapital=='1'){
				?>
                	<!-- Actividades -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuActividades.png"></span> 
                            Actividades
						</a>
						<ul class="dropdown-menu">
                        	<li class="<?= ($activa=="actividades"  && $this->uri->segment(2)==NULL)? "active":""; ?>">
								<a href="<?=base_url()?>actividades">
                                	<span class="glyphicon glyphicon-eye-open"></span> Consultar
								</a>
							</li>
							<li class="<?= ($activa=="actividades" && $this->uri->segment(2)=="agregar")? "active":""; ?>">
								<a href="<?=base_url()?>actividades/agregar">
									<span class="glyphicon glyphicon-download-alt"></span> Crear
								</a>
							</li>
							<li class="<?= ($activa=="actividades" && $this->uri->segment(2)=="importante")? "active":""; ?>">
								<a href="<?=base_url()?>actividades/importante">
									<span class="glyphicon glyphicon-certificate"></span> Importantes
								</a>
							</li>
						</ul>
					</li>
                	
                    <!-- Proyecto100 -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span><image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span> 
                            Proyecto 100
						</a>
						<ul class="dropdown-menu">
                        	<li class="<?= ($activa=="crmproyecto"  && $this->uri->segment(2)==NULL)? "active":""; ?>">
								<a href="<?=base_url()?>crmproyecto">
                                	<span class="glyphicon glyphicon-zoom-in"></span> Proceso Prospección
								</a>
							</li>
							<li class="<?= ($activa=="crmproyecto" && $this->uri->segment(2)=="Estadistica")? "active":""; ?>">
								<a href="<?=base_url()?>crmproyecto/Estadistica">
									<span class="glyphicon glyphicon-th"></span> Concentrado
								</a>
							</li>
							<li class="<?= ($activa=="crmproyecto" && $this->uri->segment(2)=="Reportes")? "active":""; ?>">
								<a href="<?=base_url()?>crmproyecto/Reportes">
									<span class="glyphicon glyphicon-list"></span> Reportes Prospectos
								</a>
							</li>
							<li class="<?= ($activa=="funnel" && $this->uri->segment(2)==NULL)? "active":""; ?>">
								<a href="<?=base_url()?>funnel">
									<span class="glyphicon glyphicon-filter"></span> Funnel
								</a>
							</li>
						</ul>
					</li>
                	
                    <!-- Car Capital -->
					<li>
						<a href="<?=base_url()?>cotizador" title="Car Capital">
                           	<span class="glyphicon glyphicon-road"></span> Car Capital
                        </a>
					</li>

                <?
				//} else {
				//} /* /$carcapital=='1' */
				?>      
                </ul><!-- /nav navbar-nav -->
			</div>
		</div>
	</nav>
    <!-- /Menu Master -->
</header>