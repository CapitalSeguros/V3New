<?php
$moduloConfiguraciones = "";
foreach($configModulos as $modulos){
	if($modulos['modulo'] == "configuraciones"){ $moduloConfiguraciones.= TRUE; } else { $moduloConfiguraciones.= FALSE; }
}

$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<link  href="<?php echo base_url().'assets/css' ?>/cropper.css" rel="stylesheet">
<link  href="<?php echo base_url().'assets/css' ?>/cropper.cenis.css" rel="stylesheet">

<!--:::::::::: INICIO CONTENIDO ::::::::::-->
    <section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Editar Credenciales</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li><a href="./" title="Inicio">Inicio</a></li>
                    <li><a href="<?=base_url()?>validaciones/obtieneInfo/" title="Perfil">Credenciales</a></li>
                    <li class="active">Editar Credenciales</li>
                </ol>
            </div>
        </div>
            <hr /> 
    </section>

 
    <section>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
               
                              <!--   <div class="media-left media-middle">
                                    <div class="icon-edit-img" data-toggle="modal" data-target="#dvPhoto"></div>

                                    <img id="imgPhoto" src="<?=$miInfo_Datos->fotoUser; ?>" class="media-object img-circle" width="150" alt="...">
                                </div>-->
                                <div class="media-body">
                                  <!--   <p><b>Sucursal:</b> <? echo $miInfo_Datos->sucursal; ?></p>-->
                                    <p><b>Usuario:</b> <? echo $miInfo_Datos->emailUser; ?></p>
                                     <p><b>Nombre:</b> <? echo $miInfo_Datos->apellidop . " "; echo $miInfo_Datos->apellidom . " "; echo $miInfo_Datos->nombre;?></p>
                                </div>
                      
                        </div>
                    </div>

         <div class="row">
                <div class="col-sm-12 col-md-12" align="left">
                        <form
                            class="form-horizontal" role="formvendedor"
                            id="formvendedor" name="formvendedor"
                            method="post" 
                            action="<?=base_url()?>validaciones/obtieneInfo/" 
                        >
                            <div class="input-group" style="width:50%;">
                                <select name="vendedor" id="vendedor" class="form-control input-sm" required="">

                                     <option value="">Seleccione un Agente</option>
                                                <? 
                                                    if(!empty($ListaVendedores))
                                                    { 
                                                        foreach ($ListaVendedores->result() as $Registro) {   
                                                     ?> 

                                                    <option value="<?=$Registro->email ?>"  >   
                                                     <? print $Registro->name_complete?> </option>

                                                     <?
                                                        }
                                                        } else {
                                                        ?>
                                                            <option value="false">
                                                                Vendedor No encontrado !!!
                                                            </option>
                                                        <?
                                                        }
                                                        ?>          
                                </select>

                                <span class="input-group-btn">
                                                    <button class="btn btn-primary btn-sm search-trigger"><i class="fa fa-search fa-sm"></i> Buscar</button>
                                </span>
                            </div>

                         </form>

                 </div> 
            </div> 

            <div class="row">
            <br>
            </div>
               
    </section>


    <section class="container-fluid">
        <form  role="form" id="form" name="form" action="<?=base_url()?>validaciones/guardar" method="POST">
            <input type="hidden" name="idCont" value="<?php echo $miInfo_Datos->emailUser; ?>">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="row">
                        <div class="form-group col-md-12 text-right">
                            <a class="btn btn-default btn-sm" onclick="java:window.open('<?=base_url()?>validaciones','_self');">CANCELAR<!-- <i class="fa fa-check"></i> --></a>
                            <input type="submit" name="Guardar" value="GUARDAR" class="btn btn-primary btn-sm">
                            
                        </div>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active" ><a href="#tab-01" aria-controls="tab-01" role="tab" data-toggle="tab">Perfil</a></li>
                        <li role="presentation"><a href="#tab-02" aria-controls="tab-02" role="tab" data-toggle="tab" >Docs.</a></li>
                        <li role="presentation"><a href="#tab-03" aria-controls="tab-03" role="tab" data-toggle="tab">Banco</a></li>
                        <li role="presentation"><a href="#tab-04" aria-controls="tab-04" role="tab" data-toggle="tab">Otros</a></li> 
                        <li role="presentation"><a href="#tab-05" aria-controls="tab-05" role="tab" data-toggle="tab">Especiales</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- INICIO CONTENIDO TAB -->
                        <div role="tabpanel" class="tab-pane fade in active" id="tab-01">
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control input-sm" placeholder="Nombre" value="<? echo $miInfo_Datos->nombre; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="apellidop">Apellido paterno</label>
                                    <input type="text" name="apellidop" id="apellidop" class="form-control input-sm" placeholder="Apellido paterno" value="<? echo $miInfo_Datos->apellidop; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="apellidom">Apellido materno</label>
                                    <input type="text" name="apellidom" id="apellidom" class="form-control input-sm" placeholder="Apellido materno" value="<? echo $miInfo_Datos->apellidom; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="RFC">RFC</label>
                                    <input type="text" name="rfc" id="rfc" class="form-control input-sm" placeholder="RFC" value="<? echo $miInfo_Datos->rfc; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="FechaNacimiento">Fecha nacimiento</label>
                                    <div class="input-group">
                                        <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control input-sm fecha" placeholder="01/01/1900" value="<? echo ($miInfo_Datos->fecha_nacimiento == "0000-00-00")? date('d/m/Y') : date('d/m/Y',strtotime($miInfo_Datos->fecha_nacimiento)) ; ?>">




                                        <span class="input-group-btn"><a href="#" class="btn btn-primary btn-sm"><i class="fa fa-calendar fa-lg"></i>&nbsp;</a></span>                        
                                    </div>
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="LugarNacimiento">Lugar nacimiento</label>
                                    <input type="text" name="lugar_nacimiento" id="LugarNacimiento" class="form-control input-sm" placeholder="Lugar nacimiento" value="<? echo $miInfo_Datos->lugar_nacimiento; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="estado_civil">Estado civil</label>
                                    <select name="estado_civil" id="estado_civil" class="form-control input-sm">
                                        <option value="">Seleccione estado civil</option>
                                        <option value="SOLTERO(A)" <? echo ($miInfo_Datos->estado_civil == "SOLTERO(A)")? "selected" : ""; ?>>Soltero(A)</option>
                                        <option value="CASADO(A)" <? echo ($miInfo_Datos->estado_civil == "CASADO(A)")? "selected" : ""; ?>>Casado(A)</option>
                                        <option value="DIVORCIADO(A)" <? echo ($miInfo_Datos->estado_civil == "DIVORCIADO(A)")? "selected" : ""; ?>>Divorciado(A)</option>
                                        <option value="UNIÓN LIBRE" <? echo ($miInfo_Datos->estado_civil == "UNIÓN LIBRE")? "selected" : ""; ?>>Unión Libre</option>
                                        <option value="VIEDO(A)" <? echo ($miInfo_Datos->estado_civil == "VIEDO(A)")? "selected" : ""; ?>>Viendo(A)</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="escolaridad">Escolaridad</label>
                                    <select name="escolaridad" id="escolaridad" class="form-control input-sm">
                                        <option value="">Seleccione escolaridad</option>
                                        <option value="primaria" <? echo ($miInfo_Datos->escolaridad == "primaria")? "selected" : ""; ?>>Primaria</option>
                                        <option value="secundaria" <? echo ($miInfo_Datos->escolaridad == "secundaria")? "selected" : ""; ?>>Secundaria</option>
                                        <option value="preparatorio" <? echo ($miInfo_Datos->escolaridad == "preparatorio")? "selected" : ""; ?>>Preparatoria</option>
                                        <option value="licenciatura" <? echo ($miInfo_Datos->escolaridad == "licenciatura")? "selected" : ""; ?>>Licenciatura</option>
                                        <option value="maestria" <? echo ($miInfo_Datos->escolaridad == "maestria")? "selected" : ""; ?>>Maestria</option>
                                        <option value="doctorado" <? echo ($miInfo_Datos->escolaridad == "doctorado")? "selected" : ""; ?>>Doctorado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="h4"><i class="glyphicon glyphicon-map-marker"></i> Dirección</p><hr />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="calle">Calle</label>
                                    <input type="text" name="calle" id="calle" class="form-control input-sm" placeholder="Calle" value="<? echo $miInfo_Datos->calle; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="cruzamiento">Referencia</label>
                                    <input type="text" name="cruzamiento" id="cruzamiento" class="form-control input-sm" placeholder="Referencia" value="<? echo $miInfo_Datos->cruzamiento; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="colonia">Colonia</label>
                                    <input type="text" name="colonia" id="colonia" class="form-control input-sm" placeholder="Colonia" value="<? echo $miInfo_Datos->colonia; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="no_ext">No. exterior</label>
                                    <input type="text" name="no_ext" id="no_ext" class="form-control input-sm" placeholder="No. exterior" value="<? echo $miInfo_Datos->no_ext; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="cp">C.P.</label>
                                    <input type="text" name="cp" id="cp" class="form-control input-sm" placeholder="Código postal" value="<? echo $miInfo_Datos->cp; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" class="form-control input-sm" placeholder="Ciudad" value="<? echo $miInfo_Datos->ciudad; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="h4"><i class="fa fa-phone"></i> Teléfono</p><hr />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="TelCasa">Tel casa</label>
                                    <input type="text" name="telefono_casa" id="TelCasa" class="form-control input-sm" placeholder="(999) 999-9999" value="<? echo $miInfo_Datos->telefono_casa; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="TelTrabajo">Tel trabajo</label>
                                    <input type="text" name="telefono_trabajo" id="TelTrabajo" class="form-control input-sm" placeholder="(999) 999-9999" value="<? echo $miInfo_Datos->telefono_trabajo; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="Celular">Celular</label>
                                    <input type="text" name="telefono_celular" id="TelTrabajo" class="form-control input-sm" placeholder="(999) 999-9999" value="<? echo $miInfo_Datos->telefono_celular; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="cia_celular">Comp. celular</label>
                                    <select name="cia_celular" id="cia_celular" class="form-control input-sm">
                                        <option value="">Seleccione compañia</option>
                                        <option value="telcel" <? echo ($miInfo_Datos->cia_celular == "telcel")? "selected" : ""; ?>>Telcel</option>
                                        <option value="movistar" <? echo ($miInfo_Datos->cia_celular == "movistar")? "selected" : ""; ?>>Movistar</option>
                                        <option value="iusacell" <? echo ($miInfo_Datos->cia_celular == "iusacell")? "selected" : ""; ?>>Iusacell</option>
                                        <option value="unefon" <? echo ($miInfo_Datos->cia_celular == "unefon")? "selected" : ""; ?>>Unef&oacute;n</option>
                                        <option value="nextel" <? echo ($miInfo_Datos->cia_celular == "nextel")? "selected" : ""; ?>>Nextel</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="h4"><i class="fa fa-car"></i> Vehículo</p><hr />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="vehiculo_propio">Vehículo propio</label>
                                    <select name="vehiculo_propio" id="vehiculo_propio" class="form-control input-sm">
                                        <option value="No">Seleccione una opción</option>
                                        <option value="Si" <? echo ($miInfo_Datos->vehiculo_propio == "Si")? "selected" : ""; ?>>Si</option>
                                        <option value="No" <? echo ($miInfo_Datos->vehiculo_propio == "No")? "selected" : ""; ?>>No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="modelo_vehiculo">Modelo vehículo</label>
                                    <input type="text" name="modelo_vehiculo" id="modelo_vehiculo" class="form-control input-sm" placeholder="Modelo vehículo" value="<? echo $miInfo_Datos->modelo_vehiculo; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- FIN CONTENIDO TAB -->
                        <!-- INICIO CONTENIDO TAB -->
                        <div role="tabpanel" class="tab-pane fade" id="tab-02">
                            <div class="row">
                               <!-- <div class="form-group col-md-3 col-sm-3">
                                    <label for="cedula_cnsf">Cedula CNSF</label>
                                    <input type="text" name="cedula_cnsf" id="cedula_cnsf" class="form-control input-sm" placeholder="Cedula CNSF" value="<? echo $miInfo_Datos->cedula_cnsf; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="vigencia_cnsf">Vigencia cedula</label>
                                    <div class="input-group">
                                        <input type="text" name="vigencia_cnsf" id="vigencia_cnsf" class="form-control input-sm fecha" placeholder="01/01/1900" value="<? echo $miInfo_Datos->vigencia_cnsf; ?>">
                                        <span class="input-group-btn"><a href="#" class="btn btn-primary btn-sm"><i class="fa fa-calendar fa-lg"></i>&nbsp;</a></span>                        
                                    </div>
                                </div>-->
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="licencia_conducir">Licencia de conducir</label>
                                    <input type="text" name="licencia_conducir" id="licencia_conducir" class="form-control input-sm" placeholder="Licencia de conducir" value="<? echo $miInfo_Datos->licencia_conducir; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="vigencia_licencia">Vigencia licencia</label>
                                    <div class="input-group">
                                        <input type="text" name="vigencia_licencia" id="vigencia_pasaporte" class="form-control input-sm fecha" placeholder="01/01/1900" value="<? echo ($miInfo_Datos->vigencia_licencia == "0000-00-00")? date('d/m/Y') : date('d/m/Y',strtotime($miInfo_Datos->vigencia_licencia)) ; ?>">
                                        <span class="input-group-btn"><a href="#" class="btn btn-primary btn-sm"><i class="fa fa-calendar fa-lg"></i>&nbsp;</a></span>                        
                                    </div>
                                </div>

                                 <div class="form-group col-md-3 col-sm-3">
                                    <label for="pasaporte">Pasaporte</label>
                                    <input type="text" name="pasaporte" id="pasaporte" class="form-control input-sm" placeholder="Pasaporte" value="<? echo $miInfo_Datos->pasaporte; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="vigencia_pasaporte">Vigencia pasaporte</label>
                                    <div class="input-group">
                                        <input type="text" name="vigencia_pasaporte" id="vigencia_pasaporte" class="form-control input-sm fecha" placeholder="01/01/1900" value="<? echo ($miInfo_Datos->vigencia_pasaporte == "0000-00-00")? date('d/m/Y') : date('d/m/Y',strtotime($miInfo_Datos->vigencia_pasaporte)) ; ?>">
                                        <span class="input-group-btn"><a href="#" class="btn btn-primary btn-sm"><i class="fa fa-calendar fa-lg"></i>&nbsp;</a></span>                        
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                               
                            </div>
                        </div>
                        <!-- FIN CONTENIDO TAB -->
                        <!-- INICIO CONTENIDO TAB -->
                        <div role="tabpanel" class="tab-pane fade" id="tab-03">
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="banco">Banco</label>
                                    <input type="text" name="banco" id="banco" class="form-control input-sm" placeholder="Banco" value="<? echo $miInfo_Datos->banco; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="clabe">Clabe</label>
                                    <input type="text" name="clabe" id="clabe" class="form-control input-sm" placeholder="Clabe" value="<? echo $miInfo_Datos->clabe; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="cuenta_bancaria">Cuenta</label>
                                    <input type="text" name="cuenta_bancaria" id="cuenta_bancaria" class="form-control input-sm" placeholder="Cuenta" value="<? echo $miInfo_Datos->cuenta_bancaria; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="tipo_cuenta">Tipo cuenta</label>
                                    <input type="text" name="tipo_cuenta" id="tipo_cuenta" class="form-control input-sm" placeholder="Tipo cuenta" value="<? echo $miInfo_Datos->tipo_cuenta; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- FIN CONTENIDO TAB -->
                        <!-- INICIO CONTENIDO TAB -->
                        <div role="tabpanel" class="tab-pane fade" id="tab-04">
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="accidente_avisar">Accidente avisar a</label>
                                    <input type="text" name="accidente_avisar" id="accidente_avisar" class="form-control input-sm" placeholder="Accidente avisar a" value="<? echo $miInfo_Datos->accidente_avisar; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="accidente_telefono">Tel accidente</label>
                                    <input type="text" name="accidente_telefono" id="accidente_telefono" class="form-control input-sm" placeholder="(999) 999-9999" value="<? echo $miInfo_Datos->accidente_telefono; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="recomendado_por">Recomendado por</label>
                                    <input type="text" name="recomendado_por" id="recomendado_por" class="form-control input-sm" placeholder="Recomendado por" value="<? echo $miInfo_Datos->recomendado_por; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="referencias">Referencias</label>
                                    <input type="text" name="referencias" id="referencias" class="form-control input-sm" placeholder="Referencias" value="<? echo $miInfo_Datos->referencias; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="imss">IMSS</label>
                                    <input type="text" name="imss" id="imss" class="form-control input-sm" placeholder="IMSS" value="<? echo $miInfo_Datos->imss; ?>">
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="tiene_hijos">Tiene hijos</label>
                                    <select name="tiene_hijos" id="tiene_hijos" class="form-control input-sm">
                                        <option value="No">Seleccione una opción</option>
                                        <option value="Si" <? echo ($miInfo_Datos->tiene_hijos == "Si")? "selected" : ""; ?>>Si</option>
                                        <option value="No" <? echo ($miInfo_Datos->tiene_hijos == "No")? "selected" : ""; ?>>No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="gasto_promedio_mensual">Gasto mensual</label>
                                    <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                        <input type="text" name="gasto_promedio_mensual" id="gasto_promedio_mensual" class="form-control input-sm" placeholder="$0.00" value="<? echo $miInfo_Datos->gasto_promedio_mensual; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="cuanto_te_gustaria_ganar">C.T.G. Ganar</label>
                                    <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                        <input type="text" name="cuanto_te_gustaria_ganar" id="cuanto_te_gustaria_ganar" class="form-control input-sm" placeholder="$0.00" value="<? echo $miInfo_Datos->cuanto_te_gustaria_ganar; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="comida_favorita">Comida favorita</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-spoon"></i></span>
                                        <input type="text" name="comida_favorita" id="comida_favorita" class="form-control input-sm" placeholder="Comida favorita" value="<? echo $miInfo_Datos->comida_favorita; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="color_favorito">Color favorito</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-text-color"></i></span>
                                        <input type="text" name="color_favorito" id="color_favorito" class="form-control input-sm" placeholder="Color favorito" value="<? echo $miInfo_Datos->color_favorito; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="pasatiempo">Pasatiempo favorito</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-bicycle"></i></span>
                                        <input type="text" name="pasatiempo" id="pasatiempo" class="form-control input-sm" placeholder="Pasatiempo favorito" value="<? echo $miInfo_Datos->pasatiempo; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="club_social">Club social</label>
                                    <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-smile-o"></i></span>
                                        <input type="text" name="club_social" id="club_social" class="form-control input-sm" placeholder="Club social" value="<? echo $miInfo_Datos->club_social; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN CONTENIDO TAB -->

                         <!-- INICIO CONTENIDO TAB ESEPCIALES-->

                        <div role="tabpanel" class="tab-pane fade" id="tab-05">


                            <div class="row">
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="cedula_cnsf">Cedula</label>
                                    <input type="text" name="cedula_cnsf" id="cedula_cnsf" class="form-control input-sm" placeholder="Cedula CNSF" value="<? echo $miInfo_Datos->cedula_cnsf; ?>">
                                </div>

                              
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="vigencia_cnsf">Vigencia de la Cedula</label>
                                    <div class="input-group">
                                        <input type="text" name="vigencia_cnsf" id="vigencia_cnsf" class="form-control input-sm fecha" placeholder="01/01/1900" value="<? echo ($miInfo_Datos->vigencia_cnsf == "0000-00-00")? date('d/m/Y') : date('d/m/Y',strtotime($miInfo_Datos->vigencia_cnsf)) ; ?>">
                                        <span class="input-group-btn"><a href="#" class="btn btn-primary btn-sm"><i class="fa fa-calendar fa-lg"></i>&nbsp;</a></span>                        
                                    </div>
                                </div>


                                 <div class="form-group col-md-3 col-sm-3">
                                    <label for="polrescivil">Pol. Resp. Civil Agentes</label>
                                    <input type="text" name="polrescivil" id="polrescivil" class="form-control input-sm" placeholder="Poliza RCA" value="<? echo $miInfo_Datos->polrescivil; ?>">
                                </div>

                                    <div class="form-group col-md-3 col-sm-3">
                                    <label for="vigenciapolrescivil">Vigencia Resp. Civil Agentes</label>
                                    <div class="input-group">
                                        <input type="text" name="vigenciapolrescivil" id="vigenciapolrescivil" class="form-control input-sm fecha" placeholder="01/01/1900" value="<? echo ($miInfo_Datos->vigenciapolrescivil == "0000-00-00")? date('d/m/Y') : date('d/m/Y',strtotime($miInfo_Datos->vigenciapolrescivil)) ; ?>">
                                        <span class="input-group-btn"><a href="#" class="btn btn-primary btn-sm"><i class="fa fa-calendar fa-lg"></i>&nbsp;</a></span>                        
                                    </div>
                                </div>


                                  <div class="form-group col-md-3 col-sm-3">
                                    <label for="sumaaseg">Suma Amparada Resp. Civil Agentes</label>
                                    <input type="text" name="sumaaseg" id="sumaaseg" class="form-control input-sm" placeholder="Suma Amparada RCA" value="<? echo $miInfo_Datos->sumaaseg; ?>">
                                </div>

                              
                             

                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="IDValida">ID Gafet</label>
                                    <input type="text" name="IDValida" id="IDValida" class="form-control input-sm" placeholder="(999) 999-9999" value="<? echo $miInfo_Datos->IDValida; ?>">
                                </div>


                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="certificacion">Hrs de Desarrollo Profesional</label>
                                    <input type="text" name="certificacion" id="certificacion" class="form-control input-sm" placeholder="Certificacion" value="<? echo $miInfo_Datos->certificacion; ?>">
                                </div>

                                 <div class="form-group col-md-3 col-sm-3">
                                    <label for="certificacionAutos">Hrs Autos</label>
                                    <input type="text" name="certificacionAutos" id="certificacionAutos" class="form-control input-sm" placeholder="Ceritificacion Autos" value="<? echo $miInfo_Datos->certificacionAutos; ?>">
                                </div>

                                 <div class="form-group col-md-3 col-sm-3">
                                    <label for="certificacionGmm">Hrs Gastos Medicos</label>
                                    <input type="text" name="certificacionGmm" id="certificacionGmm" class="form-control input-sm" placeholder="Certificacion Gmm" value="<? echo $miInfo_Datos->certificacionGmm; ?>">
                                </div>

                                 <div class="form-group col-md-3 col-sm-3">
                                    <label for="certificacionVida">Hrs Vida</label>
                                    <input type="text" name="certificacionVida" id="certificacionVida" class="form-control input-sm" placeholder="Certificacion Vida" value="<? echo $miInfo_Datos->certificacionVida; ?>">
                                </div>

                                 <div class="form-group col-md-3 col-sm-3">
                                    <label for="certificacionDanos">Hrs Daños</label>
                                    <input type="text" name="certificacionDanos" id="certificacionDanos" class="form-control input-sm" placeholder="Certificacion Danos" value="<? echo $miInfo_Datos->certificacionDanos; ?>">
                                </div>

                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="certificacionFianzas">Hrs Fianzas</label>
                                    <input type="text" name="certificacionFianzas" id="certificacionFianzas" class="form-control input-sm" placeholder="Certificacion Fianzas" value="<? echo $miInfo_Datos->certificacionFianzas; ?>">
                                </div>

                                 <div class="form-group col-md-3 col-sm-3">
                                    <font color='red'>
                                    <label color='red' for="porcentajesa">Porcentaje de Satisfaccion</label>
                                    </font>
                                    <input type="text" name="porcentajesa" id="porcentajesa" class="form-control input-sm" placeholder="Procentaje Valor entre (0-100)" value="<? echo $miInfo_Datos->porcentajesa; ?>">
                                </div>

                               
                            </div><!-- FIN DEL row -->

                             <div class="row">
                                         <div class="media media-perfil"> 
                                                <div class="media-left media-middle">

                                                        <div class="icon-edit-img" data-toggle="modal" data-target="#dvPhoto"></div>
                                                        <img id="imgPhoto" src="<?=$miInfo_Datos->fotoconcurso1; ?>" class="media-object img-circle" width="150" alt="...">
                                                 </div>

                                                 <div class="media-left media-middle">
                                                        <label for="comen1">Comentario Foto 1</label>
                                                        <input type="text" name="comen1" id="comen1" class="form-control input-sm" placeholder="Comentario Foto 1" value="<? echo $miInfo_Datos->comentariofoto1; ?>">
                                                </div>

                                                 <div class="media-left media-middle">
                                                        <div class="icon-edit-img" data-toggle="modal" data-target="#dvPhoto"></div>
                                                        <img id="imgPhoto" src="<?=$miInfo_Datos->fotoconcurso2; ?>" class="media-object img-circle" width="150" alt="...">
                                                </div> 

                                                <div class="media-left media-middle">
                                                        <label for="comen2">Comentario Foto 2</label>
                                                        <input type="text" name="comen2" id="comen2" class="form-control input-sm" placeholder="Comentario Foto 2" value="<? echo $miInfo_Datos->comentariofoto2; ?>">
                                                </div>

                                                <div class="media-left media-middle">
                                                        <div class="icon-edit-img" data-toggle="modal" data-target="#dvPhoto"></div>

                                                        <img id="imgPhoto" src="<?=$miInfo_Datos->fotoconcurso3; ?>" class="media-object img-circle" width="150" alt="...">
                                                </div>

                                                <div class="media-left media-middle">
                                                        <label for="comen3">Comentario Foto 3</label>
                                                        <input type="text" name="comen3" id="comen3" class="form-control input-sm" placeholder="Comentario Foto 3" value="<? echo $miInfo_Datos->comentariofoto3; ?>">
                                                </div>

                                         </div> 

                                         <div class="media media-perfil"> 


                                                 <div class="media-left media-middle">
                                                        <div class="icon-edit-img" data-toggle="modal" data-target="#dvPhoto"></div>

                                                        <img id="imgPhoto" src="<?=$miInfo_Datos->fotoconcurso4; ?>" class="media-object img-circle" width="150" alt="...">
                                                </div>

                                                <div class="media-left media-middle">
                                                        <label for="comen4">Comentario Foto 4</label>
                                                        <input type="text" name="comen4" id="comen4" class="form-control input-sm" placeholder="Comentario Foto 4" value="<? echo $miInfo_Datos->comentariofoto4; ?>">
                                                </div>


                                                <div class="media-left media-middle">
                                                        <div class="icon-edit-img" data-toggle="modal" data-target="#dvPhoto"></div>

                                                        <img id="imgPhoto" src="<?=$miInfo_Datos->fotoconcurso5; ?>" class="media-object img-circle" width="150" alt="...">
                                                 </div>

                                                  <div class="media-left media-middle">
                                                        <label for="comen5">Comentario Foto 5</label>
                                                        <input type="text" name="comen5" id="comen5" class="form-control input-sm" placeholder="Comentario Foto 5" value="<? echo $miInfo_Datos->comentariofoto5; ?>">
                                                </div>

                                                <div class="media-left media-middle">
                                                        <div class="icon-edit-img" data-toggle="modal" data-target="#dvPhoto"></div>

                                                        <img id="imgPhoto" src="<?=$miInfo_Datos->fotoconcurso6; ?>" class="media-object img-circle" width="150" alt="...">
                                                </div>  

                                                 <div class="media-left media-middle">
                                                        <label for="comen6">Comentario Foto 6</label>
                                                        <input type="text" name="comen6" id="comen6" class="form-control input-sm" placeholder="Comentario Foto 6" value="<? echo $miInfo_Datos->comentariofoto6; ?>">
                                                </div>
                                         </div> 

                            </div>
                                         
                        </div><!-- FIN CONTENIDO TAB -->




                        

                         </div><!-- FIN CONTENIDO TAB 05 ESPECIALES-->

                        

                    </div><!-- FIN CONTENIDO CONTENEDOR MAYOR-->
                </div>
            </div>
       </form>

    </section>




  
    <!--:::::::::: FIN CONTENIDO ::::::::::-->

<!--:::::::::: INICIO MODAL PARA FOTO PERFIL::::::::::-->

<div id="dvPhoto" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cambiar foto de concurso 1</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-9">
                
                <div class="img-container">
                  <img id="image" src="" >
                </div>



            </div>
            <div class="col-md-3">
                <div class="docs-preview clearfix">
                  <div class="img-preview preview-lg"></div>
                </div>
            </div>
        </div>
    
      <div class="modal-footer " id="actions">

        <!-- <input type="file"  id="inputImage" name="file" accept="image/*"> -->

         <div class="docs-buttons">
            <div class="btn-group">
              <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                <span class="docs-tooltip" data-toggle="tooltip" title="Aumentar">
                  <span class="fa fa-search-plus"></span>
                </span>
              </button>
              <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                <span class="docs-tooltip" data-toggle="tooltip" title="Disminuir">
                  <span class="fa fa-search-minus"></span>
                </span>
              </button>
            </div>

            <div class="btn-group">
              <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Izquierda">
                  <span class="fa fa-arrow-left"></span>
                </span>
              </button>
              <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Derecha">
                  <span class="fa fa-arrow-right"></span>
                </span>
              </button>
              <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Arriba">
                  <span class="fa fa-arrow-up"></span>
                </span>
              </button>
              <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Abajo">
                  <span class="fa fa-arrow-down"></span>
                </span>
              </button>
            </div>

            <div class="btn-group">
              <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                <span class="docs-tooltip" data-toggle="tooltip" title="Subir image">
                  <span class="fa fa-upload"></span>
                </span>
              </label>
            </div>-->

            <button type="button" data-method="getCroppedCanvas" title="Guardar"  data-option="0" data-second-option="10" data-toggle="tooltip" title="Guardar" class="btn btn-primary" >Guardar</button>
        </div>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!--:::::::::: FIN MODAL PARA FOTO PERFIL ::::::::::-->










<script src="<?php echo base_url().'assets/js' ?>/cropper.js"></script>
<script src="<?php echo base_url().'assets/js' ?>/jquery.croppe.cenis.js"></script>
<script type="text/javascript">
    $(function () {
        var fecha = $('.fecha').datepicker({
            format: "dd/mm/yyyy",
            startDate: "01/01/1900",
            language: "es",
            autoclose: true,
            orientation: "top auto",
        });
    });
</script>

<?php $this->load->view('footers/footer'); ?>