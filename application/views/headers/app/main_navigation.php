<?
	$modulo			= ($this->uri->segment(1)=="")? "inicio":$this->uri->segment(1);	//$this->uri->segment(1);
	$subModulo		= ($this->uri->segment(2)=="" || $this->uri->segment(1)=="inicio")? "inicio":$this->uri->segment(2);	
	$subSubSeccion	= ($this->uri->segment(3)=="" || $this->uri->segment(1)=="inicio")? "inicio":$this->uri->segment(3);
/*	
	echo "<pre>";
		print($modulo);
		echo "<br />";
		print($subModulo);
		echo "<br />";
		print($subSubSeccion);
	echo "</pre>";
*/
?>
		<!-- Main navigation -->
		<ul id="side-nav" class="main-menu navbar-collapse collapse">
            
            <!-- Actividades -->
            <li class="has-sub <?=($modulo=="actividades")? "active":""?>">
            	<a href="<?= base_url('actividades'); ?>">
                	<span>
                    	<image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuActividades.png">
					</span>
                    <span class="title">Actividades</span>
				</a>
				<ul class="nav">
					<li class="<?=($subModulo=="")? "active":""?>">
						<a href="<?=base_url()?>actividades">
							<span class="glyphicon glyphicon-eye-open"></span> Consultar
						</a>
                    </li>
					<li class="<?=($subModulo=="agregar")? "active":""?>">
						<a href="<?=base_url()?>actividades/agregar">
							<span class="glyphicon glyphicon-download-alt"></span> Crear
						</a>
                    </li>
					<li class="<?=($subModulo=="importante")? "active":""?>">
						<a href="<?=base_url()?>actividades/importante">
							<span class="glyphicon glyphicon-certificate"></span> Importantes
						</a>
                    </li>
                </ul>
            </li>
            							 
            <!-- Actividades -->
            <li class="has-sub <?=($modulo=="crmproyecto" || $modulo=="funnel")? "active":""?>">
            	<a href="<?= base_url('crmproyecto'); ?>">
					<span>
                    	<image src="<?= base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png">
					</span>
                    <span class="title">Prospección de Negocios</span>
                </a>
				<ul class="nav">
					<li class="<?=($subModulo=="proyecto100" && $subSubSeccion=="Alta")? "active":""?>">
						<a href="<?=base_url()?>crmproyecto/proyecto100/Alta">
							<span class="glyphicon glyphicon-zoom-in"></span> Alta de Prospecto
						</a>
                    </li>
					<li class="<?=($subModulo=="proyecto100" && $subSubSeccion=="Seguimiento")? "active":""?>">
						<a href="<?=base_url()?>crmproyecto/proyecto100/Seguimiento">
							<span class="glyphicon glyphicon-th"></span> Seguimiento de la Prospección
						</a><!-- onclick="cargarPagina('crmproyecto/seguimientoProspecto')"  -->
                    </li>
					<li class="<?=($subModulo=="proyecto100" && $subSubSeccion=="Administracion")? "active":""?>">
						<a href="<?=base_url()?>crmproyecto/proyecto100/Administracion">
							<span class="glyphicon glyphicon-list"></span> Administración del Prospecto
						</a><!--  onclick="cargarPagina('crmproyecto/Reportes')" -->
                    </li>
					<li class="<?=($subModulo=="proyecto100" && $subSubSeccion=="Reporte")? "active":""?>">
						<a href="<?=base_url()?>crmproyecto/proyecto100/Reporte">
							<span class="glyphicon glyphicon-list"></span> Reporte Comercial
						</a><!-- onclick="cargarPagina('crmproyecto/reporteComercial')" -->
                    </li>
					<li class="<?=($subModulo=="proyecto100" && $subSubSeccion=="Puntos")? "active":""?>">
						<a href="<?=base_url()?>crmproyecto/proyecto100/Puntos">
							<span class="glyphicon glyphicon-list"></span> Puntos Generados
						</a><!-- onclick="cargarPagina('crmproyecto/Estadistica')" -->
                    </li>
					<li class="<?=($subModulo=="proyecto100" && $subSubSeccion=="Funnel")? "active":""?>">
						<a href="<?=base_url()?>crmproyecto/proyecto100/Funnel">
							<span class="glyphicon glyphicon-filter"></span> Funnel de Ventas
						</a><!-- onclick="cargarPagina('funnel')" -->
                    </li>
                </ul>
            </li>
                            
			<!-- Car Capital -->
			<li class="has-sub <?=($modulo=="cotizador")? "active":""?>">
				<a href="<?=base_url()?>cotizador" title="Car Capital">
					<span class="glyphicon glyphicon-road"></span> Car Capital
				</a>
			</li>            

        </ul>
		<!-- /main navigation -->