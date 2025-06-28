<?php


		$inicioEmplreado			= strtotime($miInfo_Datos->FechaIniEmpl);
		$hoy 						= strtotime(date("Y-m-d"));
		$tipoRestanteProvisional	= intval(($hoy - $inicioEmplreado) / (24 * 60 * 60)); // /(365.25 * 24 * 60 * 60 * 1000);
	
	$moduloConfiguraciones = "";
	foreach($configModulos as $modulos){
		if($modulos['modulo'] == "configuraciones"){ $moduloConfiguraciones.= TRUE; } else { $moduloConfiguraciones.= FALSE; }
	}

	function formatMoney($num){
		echo '$ '.$num;
	}

	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
    <!--:::::::::: INICIO CONTENIDO ::::::::::-->
    <section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Info Agente</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li><a href="./">Inicio</a></li>
                    <li class="active">Info Agente</li>
                </ol>
            </div>
        </div>
            <hr /> 
    </section>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bank fa-lg"></i> Banco
                    </div>
                    <div class="panel-body">
                        <p><b>Nombre:</b> <? echo $miInfo_Datos->banco; ?></p>
                        <p><b>Clabe:</b> <? echo $miInfo_Datos->clabe; ?></p>
                        <p><b>Cuenta:</b> <? echo $miInfo_Datos->cuenta_bancaria; ?></p>
                        <p><b>Tipo cuenta:</b> <? echo $miInfo_Datos->tipo_cuenta; ?></p>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-heartbeat fa-lg"></i> En caso de accidente
                    </div>
                    <div class="panel-body">
                        <p><b>Avisar a:</b> <? echo $miInfo_Datos->accidente_avisar; ?></p>
                        <p><b>Recomendado por:</b> <? echo $miInfo_Datos->recomendado_por; ?></p>
                        <p><b>Teléfono accidente:</b> <? echo $miInfo_Datos->accidente_telefono; ?></p>
                        <p><b>IMSS:</b> <? echo $miInfo_Datos->imss; ?></p>
                        <p><b>Referencias:</b> <? echo $miInfo_Datos->referencias; ?></p>
                        <p><b>Tiene hijos:</b> <? echo $miInfo_Datos->tiene_hijos; ?></p>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-angellist fa-lg"></i> Otros
                    </div>
                    <div class="panel-body">
                        <p><b>Gasto mensual:</b><? echo  formatMoney($miInfo_Datos->gasto_promedio_mensual); ?></p>
                        <p><b>C.T.G. Ganar</b> <? echo formatMoney($miInfo_Datos->cuanto_te_gustaria_ganar); ?></p>
                        <p><b>Comida favorita:</b> <? echo $miInfo_Datos->comida_favorita; ?></p>
                        <p><b>Color favorito:</b> <? echo $miInfo_Datos->color_favorito; ?></p>
                        <p><b>Pasatiempo favorito:</b> <? echo $miInfo_Datos->pasatiempo; ?></p>
                        <p><b>Club social:</b> <? echo $miInfo_Datos->club_social; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <ul class="menu-panel text-left">
							<i class="fa fa-address-book fa-lg"></i> Generales
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-3">
								<?php //var_dump($miInfo_Datos); ?>
								<img src="<?php echo $miInfo_Datos->fotoUser; ?>" width="150"  class="img-responsive"/>
                            </div>
                            
                            <div class="col-md-10 col-sm-10 col-xs-9">
                                <?
								if(true){
                                ?>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                    	<p><b>Tiempo Transcurrido Alta: <?=$tipoRestanteProvisional?> Dias</b></p>
                                        <?
											if(90-$tipoRestanteProvisional > 0){
										?>
                                        <p style="color:#F00; font-style:italic;">
                                        	** Tiempo limite de permanencia es de 90 dias
                                            <br />
                                            (<?=90-$tipoRestanteProvisional;?> Dias Restantes)
                                        </p>
                                        <?
											} else if(90-$tipoRestanteProvisional < 0){
										?>
                                        <p style="color:#F00; font-style:italic;">
                                        	** Expiro
                                        </p>
                                        <?
											}
										?>
                                    </div>
								</div>
                                <?
								}
                                ?>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <p><b>Sucursal:</b> <? echo $miInfo_Datos->sucursal; ?></p>
                                        <p><b>Usuario:</b> <? echo $miInfo_Datos->emailUser; ?></p>
                                        <p><b>RFC:</b> <? echo $miInfo_Datos->rfc; ?></p>
                                        <p><b>Escolaridad:</b> <? echo $miInfo_Datos->escolaridad; ?></p>
                                        <p><b>Estado civil:</b> <? echo $miInfo_Datos->estado_civil; ?></p>                                        
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <p><b>Nombre:</b> <? echo $miInfo_Datos->nombre; ?></p>
                                        <p><b>Apellido:</b> <? echo $miInfo_Datos->apellidop.' '.$miInfo_Datos->apellidom; ?></p>
                                        <p><b>Fecha nac.:</b> <? echo $miInfo_Datos->fecha_nacimiento; ?></p>
                                        <p><b>Lugar nac.:</b> <? echo $miInfo_Datos->lugar_nacimiento; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="h4"><i class="glyphicon glyphicon-map-marker"></i> Dirección</p><hr />
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p><b>Calle:</b> <? echo $miInfo_Datos->calle; ?></p>
                                        <p><b>Referencia:</b> <? echo $miInfo_Datos->cruzamiento; ?></p>
                                        <p><b>Colonia:</b> <? echo $miInfo_Datos->colonia; ?></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p><b>No. ext:</b> <? echo $miInfo_Datos->no_ext; ?></p>
                                        <p><b>C.P:</b> <? echo $miInfo_Datos->cp; ?></p>
                                        <p><b>Ciudad:</b> <? echo $miInfo_Datos->ciudad; ?></p>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="h4"><i class="fa fa-phone"></i> Teléfono</p><hr />
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p><b>Tel casa:</b> <? echo $miInfo_Datos->telefono_casa; ?></p>
                                        <p><b>Celular:</b> <? echo $miInfo_Datos->telefono_celular; ?></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p><b>Tel. trabajo:</b> <? echo $miInfo_Datos->telefono_trabajo; ?></p>
                                        <p><b>Comp. cel:</b> <? echo $miInfo_Datos->cia_celular; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="h4"><i class="fa fa-car"></i> Vehículo</p><hr />
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p><b>Vehículo propio:</b> <? echo $miInfo_Datos->vehiculo_propio; ?></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p><b>Modelo vehículo:</b> <? echo $miInfo_Datos->modelo_vehiculo; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="h4"><i class="fa fa-file-text"></i> Documentos</p><hr />
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p><b>Cedula CNSF:</b>   <? echo $miInfo_Datos->cedula_cnsf; ?></p>
                                        <p><b>Licencia de Conducir:</b> <? echo $miInfo_Datos->licencia_conducir; ?></p>
                                        <p><b>Pasaporte:</b>  <? echo $miInfo_Datos->pasaporte; ?></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p><b>Vigencia cedula:</b> <? echo $miInfo_Datos->vigencia_cnsf; ?></p>
                                        <p><b>Vigencia licencia:</b> <? echo $miInfo_Datos->vigencia_licencia; ?></p>
                                        <p><b>Vigencia pasaporte:</b> <? echo $miInfo_Datos->vigencia_pasaporte; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--:::::::::: FIN CONTENIDO ::::::::::-->
<?php $this->load->view('footers/footer'); ?>