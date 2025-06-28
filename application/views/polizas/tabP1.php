<div class="col-md-12 bg-table tab-pane active" id="PanelP1" style="padding: 0px; margin-bottom: 0px;">
    <!-- Sección de Detalles -->
    <div class="col-md-12 content-detalles">
        <div class="segment-p-detalles">
            <div class="modal-header segment-header-detalles" id="Cabecera">
                <h4 class="title-result" id="TituloDetalles">Detalles del documento</h4>
                <h5 class="title-sub-result" id="SelectDocument"></h5>
            </div>
            <div class="content-solicitudes-y-polizas"></div>
            <div class="modal-body segment-body-detalles" id="Content-Info-Busqueda">
                <!-- Solicitudes y Pólizas | Series -->
                <div class="col-md-12 content-info-detalles hidden" id="VentPolizas">
                    <div class="row fila-input space-bottom">
                        <?php 
                        $ci =& get_instance();
                        $ci->load->model('capsysdre_actividades');
                        $selectTipoEndoso=$ci->capsysdre_actividades->SelectTipoEndoso("Endoso");
                        $str=str_replace("\"", "%", $selectTipoEndoso, $selectReplace);
                        $str = preg_replace("/[\r\n|\n|\r]+/", " ", $str);
                        if($this->tank_auth->get_idPersona()==1102){
                        ?>
                        <div class="input-width col-sm-12 text-right">
                            <button type="button" id="editarHorario" class="btn btn-primary" data-toggle="modal" data-target="#crearActividades"  data-dismiss="modal" data-backdrop="false" >Crear actividad</button>
                           
                        </div>
                                <!-- Modal -->
                        <div class="modal fade" id="crearActividades" role="dialog" >
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Crear actividades</h5>
                                <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
                                  <i class="fa fa-times"></i>
                                </button>
                              </div>
                              <div class="modal-body row" style="padding: 0px 15px 5px !important">
                        <div class="col-md-12" style="padding-top: 1%;"><div class="col-md-4" style="padding-top: 2%;"><label class="Responsivo lbEtiqueta">Actividad a realizar:</label></div><div id="divTipoActividad" class="col-md-8">
                                    <select name="tipoActividad" id="tipoActividad" onchange="addSelectTipoAct('<?echo($str)?>')" class="formEnviar form-control">
                                      <option value="0">Seleccione</option>
                                      <option value="Endoso">Endoso</option>
                                      <option value="Cancelacion">Cancelación</option>
                                    </select>
                                  </div>
                                   </div> <br>
                                   <div class="col-md-12" style="padding-top: 1%;"><div class="col-md-4" style="padding-top: 2%;"><label class="Responsivo lbEtiqueta">Folio actividad:</label></div><div id="divFolioActividad" class="col-md-8">
                                    <input type="text" id="folioSiniestros" class="form-control input-sm textSearch textSearch">
                                  </div>
                                   </div> <br>
                              <div id="divTipoEndoso" style="visibility: hidden;" class="col-md-12">
                                   
                                    </select>
                                  </div>
                            <div >
                            <input type="hidden" id="datosExpres" class="form-control input-sm textSearch mright"/>
                        </div>
                                  <div id="cargandoAct"  class="col-md-12 text-center" style="padding-top: 3%; "></div>
                             
                        <div class="col-md-12" style="padding-top: 1%;">
                            <button type="button" id="crearAct" class="btn btn-primary" onclick="crearActividadSiniestro()">Crear actividad</button>
                        </div>
                              </div>
                          </div>
                        </div>
                        </div>
                        <?}?>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Tipo documento</label>
                            <input type="text" id="TipoDocumento" class="form-control input-sm textSearch textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr no-info">
                            <label class="title-item-consult">Póliza maestra</label>
                            <input type="text" id="Poliza" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Estatus</label>
                            <input type="text" id="Estatus" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr no-info">
                            <label class="title-item-consult">No. de Folio</label>
                            <input type="text" id="Folio" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Documento</label>
                            <input type="text" id="Documento" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Inciso</label>
                            <input type="text" id="Inciso" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="text-bold">Anterior</label>
                            <input type="text" id="Anterior" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="text-bold">Posterior</label>
                            <input type="text" id="Posterior" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-7 dr">
                            <label class="title-item-consult">Cliente</label>
                            <input type="text" id="Cliente" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-4 dr">
                            <label class="title-item-consult">RFC</label>
                            <input type="text" id="RFC" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Grupo</label>
                            <input type="text" id="Grupo" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Subgrupo</label>
                            <input type="text" id="SubGrupo" class="form-control input-sm textSearch">
                	    </div>
                	    <div class="input-width col-sm-3 dr">
                	        <label class="title-item-consult">Sub subgrupo</label>
                	        <input type="text" id="Sub-SubGrupo" class="form-control input-sm textSearch">
                	    </div>
                	    <div class="input-width col-sm-3 dr no-info">
                	        <label class="title-item-consult">Expediente</label>
                	        <input type="text" id="Expediente" class="form-control input-sm textSearch">
                	    </div>
                	</div>
                	<div class="row fila-input space-bottom">
                	    <div class="input-width col-sm-8 dr">
                	        <label class="title-item-consult">Dirección</label>
                	        <input type="text" id="Direccion" class="form-control input-sm textSearch">
                	    </div>
                	    <div class="input-width col-sm-4 dr">
                	        <label class="title-item-consult">Subramo</label>
                	        <input type="text" id="SubRamo" class="form-control input-sm textSearch">
                	    </div>
                	</div>
                	<div class="row fila-input"> <!-- Dos columnas -->
                	    <div class="col-md-6 first-column">
                	        <div class="input-width col-md-12 space-bottom">
                	            <label class="title-item-consult">Agente</label>
                	            <input type="text" id="Agente" class="form-control input-sm textSearch">
                	        </div>
                	        <div class="input-width col-md-12 space-bottom">
                	            <label class="title-item-consult">Compañía</label>
                	            <input type="text" id="Compania" class="form-control input-sm textSearch">
                	        </div>
                	        <div class="input-width col-md-6 space-bottom">
                	            <label class="title-item-consult">Ejecutivo</label>
                	            <input type="text" id="Ejecutivo" class="form-control input-sm textSearch">
                	        </div>
                	        <div class="input-width col-md-6 space-bottom">
                	            <label class="title-item-consult">Forma de pago</label>
                	            <input type="text" id="Pago" class="form-control input-sm textSearch">
                	        </div>
                	        <div class="input-width col-md-6 space-bottom">
                	            <label class="title-item-consult">Vendedor</label>
                	            <input type="text" id="Vendedor" class="form-control input-sm textSearch">
                	        </div>
                	        <div class="input-width col-md-6 space-bottom">
                	            <label class="title-item-consult">Moneda</label>
                	            <input type="text" id="Moneda" class="form-control input-sm textSearch">
                	        </div>
                	    </div>
                        <div class="col-md-6 second-column" style="text-align:initial;">
                            <div class="input-width col-md-6 space-bottom">
                                <label class="title-item-consult">Desde</label>
                                <input type="text" id="Desde" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-md-6 space-bottom">
                                <label class="title-item-consult">Hasta</label>
                                <input type="text" id="Hasta" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-md-6 space-bottom">
                                <label class="title-item-consult">Renovación</label>
                                <input type="text" id="Renovacion" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-md-6 space-bottom">
                                <label class="title-item-consult">Fecha de antigüedad</label>
                                <input type="text" id="Antiguedad" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-md-6 space-bottom">
                                <label class="title-item-consult">Captura</label>
                                <input type="text" id="Captura" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-md-6 space-bottom">
                                <label class="title-item-consult">Envío</label>
                                <input type="text" id="Envio" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-md-6 space-bottom">
                                <label class="title-item-consult">Recepción</label>
                                <input type="text" id="Recepcion" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-md-6 space-bottom">
                                <label class="title-item-consult">Emisión</label>
                                <input type="text" id="Emision" class="form-control input-sm textSearch">
                            </div>
                        </div>
                    </div>
                    <div class="row space-bottom">
                        <div class="input-width col-sm-12 dr">
                            <label class="title-item-consult">Concepto</label>
                            <input type="text" id="Concepto" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <!-- Parte de la ventana Series -->
                    <div class="row space-table container-table hidden" id="Parte1-Series">
                        <div class="col-md-12 space-bottom fila-input-series">
                            <div class="input-width col-sm-3 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Marca</label>
                                <input type="text" id="sMarca" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-4 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Tipo</label>
                                <input type="text" id="sTipo" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-3 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Transmisión</label>
                                <input type="text" id="sTransmision" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-2 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Puertas</label>
                                <input type="text" id="sPuertas" class="form-control input-sm textSearch">
                            </div>
                        </div>
                        <div class="col-md-12 space-bottom fila-input-series">
                            <div class="input-width col-sm-2 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Modelo</label>
                                <input type="text" id="sModelo" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-2 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Clave</label>
                                <input type="text" id="sClave" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-4 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Placas</label>
                                <input type="text" id="sPlacas" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-4 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Serie</label>
                                <input type="text" id="sSerie" class="form-control input-sm textSearch">
                            </div>
                        </div>
                        <div class="col-md-12 space-bottom fila-input-series">
                            <div class="input-width col-sm-3 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Motor</label>
                                <input type="text" id="sMotor" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-2 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Repuve</label>
                                <input type="text" id="sRepuve" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-3 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Cía. Localización</label>
                                <input type="text" id="sCiaLocal" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-4 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Serie Localizador</label>
                                <input type="text" id="sSerieLocal" class="form-control input-sm textSearch">
                            </div>
                        </div>
                        <div class="col-md-12 space-bottom fila-input-series">
                            <div class="input-width col-sm-6 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Plan</label>
                                <input type="text" id="sPlan" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-width col-sm-6 dr" style="padding-left:5px; padding-right:5px;">
                                <label class="title-item-consult">Asegurado principal/conductor</label>
                                <input type="text" id="sAseguradoPC" class="form-control input-sm textSearch">
                            </div>
                        </div>
                    </div>
                    <div class="row space-table mg-row hidden" id="Parte2-Series">
                        <div class="col-md-12 container-table" style="">
                            <div class="col-md-12" style="overflow:auto; padding:0px; height: 260px;">
                                <table class="table table-striped table-recibos" id="TableListaCoberturas" style="margin-bottom: 0px;">
                                    <thead style="position: sticky;top: 0px;">
                                        <tr style="background: #5286b5;">
                                            <th colspan="24">
                                                <h5 style="margin:0px;">Coberturas</h5>
                                            </th>
                                        </tr>
                                        <tr style="background: #266093; font-size: 13px;">
                                            <th scope="col">Cobertura</th>
                                            <th scope="col">Suma Aseguradora</th>
                                            <th scope="col">Deducible local</th>
                                            <th scope="col">Deducible extranjero</th>
                                            <th scope="col">Comentario</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list-table-coberturas-body" style="font-size:13px; height:140px;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ////////////////////////// -->
                    <div class="row seccion-prima-columns"> <!-- Dos columnas -->
                        <div class="col-md-3 two-column">
                        	<div class="col-md-12" style="padding: 0px; display: grid;">
                            	<div class="input-width col-md-12 space-bottom">
                            	    <label class="title-item-consult">Referencia 1</label>
                            	    <input type="text" id="Referencia1" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-12 space-bottom">
                                    <label class="title-item-consult">Referencia 2</label>
                                    <input type="text" id="Referencia2" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-12 space-bottom">
                                    <label class="title-item-consult">Referencia 3</label>
                                    <input type="text" id="Referencia3" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-12 space-bottom" id="Parte4-Polizas">
                                    <label class="title-item-consult">Referencia 4</label>
                                    <input type="text" id="Referencia4" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-12 space-bottom">
                                    <label class="title-item-consult">Oficina</label>
                                    <input type="text" id="Oficina" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-12 space-bottom">
                                    <label class="title-item-consult">Despacho</label>
                                    <input type="text" id="Despacho" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-12 space-bottom">
                                    <label class="title-item-consult">Conducto de cobro</label>
                                    <input type="text" id="CondCobro" class="form-control input-sm textSearch">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 two-column">
                            <div class="col-md-12" style="padding: 0px; display: grid;">
                                <div class="col-md-12 fila-input-three" style="padding: 0px;">
                                    <div class="input-width col-md-12 space-bottom">
                                        <label class="title-item-consult">Estatus de cobro</label>
                                        <input type="text" id="Cobro" class="form-control input-sm textSearch">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom">
                                        <label class="title-item-consult">Estatus usuario</label>
                                        <input type="text" id="EstatusUsuario" class="form-control input-sm textSearch">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom">
                                        <label class="title-item-consult">Clasificación documento</label>
                                        <input type="text" id="ClasDoc" class="form-control input-sm textSearch">
                                    </div>
                                </div>
                                <div class="col-md-12 fila-input-three" style="padding: 0px;">
                                    <div class="input-width col-md-12 space-bottom">
                                        <label class="title-item-consult">Gerencia</label>
                                        <input type="text" id="Gerencia" class="form-control input-sm textSearch">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom">
                                        <label class="title-item-consult">Línea de negocio</label>
                                        <input type="text" id="LineaNegocio" class="form-control input-sm textSearch">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom">
                                        <label class="title-item-consult">Tipo de conducto cobro</label>
                                        <input type="text" id="TipoCondCobro" class="form-control input-sm textSearch">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 second-column segment-column" id="ColumnPrimas">
                            <div class="input-width col-sm-12 sub-dr space-bottom prs">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Prima neta: </label>
                                <input type="text" id="PrimaNeta" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Descuento:</label>
                                <input type="text" id="Descuento" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs" id="Parte1-Polizas">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Extra prima: </label>
                                <input type="text" id="ExtraPrima" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs">
                                <label class="title-sub-item-consult" id="Campo1" style="padding-right:3px;"></label>
                                <input type="text" id="Recargos" class="form-control input-sm textSearch align-money"/>
                                </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs">
                                <label class="title-sub-item-consult" id="Campo2" style="padding-right:3px;"></label>
                                <input type="text" id="Derechos" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs" id="Parte5-Polizas">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Gastos admin: </label>
                                <input type="text" id="GastosAdmin" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Subtotal: </label>
                                <input type="text" id="SubTotal" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs">
                                <label class="title-sub-item-consult" style="padding-right:3px;">IVA: </label>
                                <input type="text" id="IVA" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs hidden" id="Parte4-Series">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Ajuste: </label>
                                <input type="text" id="sAjuste" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs hidden">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Prima Pendiente: </label>
                                <input type="text" id="PrimaPend" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Prima Total: </label>
                                <input type="text" id="PrimaTotal" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs" id="Parte6-Polizas">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Monto: </label>
                                <input type="text" id="Monto" class="form-control input-sm textSearch align-money"/>
                            </div>
                            <div class="input-width col-sm-12 sub-dr space-bottom prs" id="Parte7-Polizas">
                                <label class="title-sub-item-consult" style="padding-right:3px;">Monto acumulado: </label>
                                <input type="text" id="MontoAcum" class="form-control input-sm textSearch align-money"/>
                            </div>
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-4 dr">
                            <label class="title-item-consult">Endoso</label>
                            <select  class="form-control input-sm textSearch mright" id="Endoso"></select>
                        </div>
                        <div class="input-width col-sm-4 dr">
                            <label class="title-item-consult">Tipo de pago</label>
                            <input type="text" id="TipoPago" class="form-control input-sm textSearch mright"/>
                        </div>
                        <div class="input-width col-sm-4 dr">
                            <label class="title-item-consult">Tipo de venta</label>
                            <input type="text" id="TipoVenta" class="form-control input-sm textSearch mright"/>
                        </div>
                        <div class="input-width col-sm-4 dr">
                            <input type="hidden" id="IDCont" class="form-control input-sm textSearch mright"/>
                        </div>
                    </div>
                    <div class="row space-table mg-row">
                        <div class="col-md-12 container-table" style="">
                            <div class="col-md-12" style="overflow:auto; padding:0px;">
                                <table class="table table-striped table-recibos" id="TablaListaRecibos" style="margin-bottom: 0px;">
                                    <thead style="position: sticky;top: 0px;">
                                        <tr style="background: #5286b5;">
                                            <th class="title-table" colspan="24">Lista de recibos</th>
                                        </tr>
                                        <tr class="title-sub-table" style="background: #266093;">
                                            <th scope="col">Estatus</th>
                                            <th scope="col">Comisión</th>
                                            <th scope="col">Documento</th>
                                            <th scope="col">Inciso</th>
                                            <th scope="col">Endoso</th>
                                            <th scope="col">Periodo</th>
                                            <th scope="col">Serie</th>
                                            <th scope="col">Desde</th>
                                            <th scope="col">Hasta</th>
                                            <th scope="col">Límite de Pago</th>
                                            <th scope="col">Fecha de Estatus</th>
                                            <th scope="col">Prima Neta</th>
                                            <th scope="col">Prima Total</th>
                                            <th scope="col">Prima Enviada</th>
                                            <th scope="col">Prima Pendiente</th>
                                            <th scope="col">Honorario</th>
                                            <th scope="col">Folio Liquidación</th>
                                            <th scope="col">Importe Cobro</th>
                                            <th scope="col">Fecha de Pago</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list-table-recibos-body"></tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="padding-top:5px;">
                                    <button class="btn btn-General btn-Refresh sub-dr" style="color:white; border-radius:4px;" onclick="TablaRecibos()">
                                        Recargar
                                        <i class="fa fa-refresh" aria-hidden="true" style="margin-left:5px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row space-table mg-row" id="Parte2-Polizas" style="overflow:auto;">
                        <div class="col-md-12 container-table">
                            <table class="table table-striped table-totales" id="TablaTotales" style="height:200px; margin-bottom: 0px;">
                                <thead style="position: sticky;top: 0px;">
                                    <tr style="opacity: .8;background: #266093;">
                                        <th class="title-table" colspan="24">Totales</th>
                                    </tr>
                                    <tr class="title-sub-table" style="background: #266093;">
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Prima neta</th>
                                        <th scope="col">Prima total</th>
                                    </tr>
                                </thead>
                                <tbody class="list-table-totales-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row space-table mg-row" id="Parte8-Polizas" style="overflow:auto;">
                        <div class="col-md-12 container-table">
                            <div class="col-md-12 columns-table-recibo" style="width: 100%; padding: 0px;">
                                <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                                    <div class="title-segment-user title-table" style="text-align:center;">
                                        <!-- padding-top:3px; padding-bottom:3px; display: flex; align-items: center; -->
                                        Detalle de comisiones
                                    </div>
                                </div>
                                <div class="col-md-12 segment-body-no-table" style="display: flex;justify-content: center;padding-left: 15px;padding-right: 15px;height: 150px;">
                                    <div class="col-md-5 column-primas">
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Neta: </label>
                                            <input type="text" id="Neta" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r hidden">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Extra prima: </label>
                                            <input type="text" id="ExtraPrimaC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Recargos: </label>
                                            <input type="text" id="RecargosC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Derechos: </label>
                                            <input type="text" id="DerechosC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Especial: </label>
                                            <input type="text" id="EspecialC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                    </div>
                                    <div class="col-md-5 column-primas" style="padding-right: 10px;">
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="NetaC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r hidden">
                                            <input type="text" id="ExtPrmC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="RcgsC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="DrchsC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="EspC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 column-primas">
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <span class="input-sm title-item-recibo">%</span>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <span class="input-sm title-item-recibo">%</span>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <span class="input-sm title-item-recibo">%</span>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <span class="input-sm title-item-recibo">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row space-bottom mg-row hidden" id="Parte3-Polizas" style="overflow:auto;">
                        <div class="col-md-12 container-table">
                            <table class="table table-striped table-pago" id="TableOpcionesPago" style="height:200px; margin-bottom: 0px;">
                                <thead style="position: sticky;top: 0px;">
                                    <tr style="opacity: .8;background: #266093;">
                                        <th colspan="24">
                                            <h5 style="margin:0px;">Opciones de pago</h5>
                                        </th>
                                    </tr>
                                    <tr style="background: #266093; font-size: 13px;">
                                        <th scope="col">Opción de pago</th>
                                        <th scope="col">Tarjeta</th>
                                        <th scope="col">Campo a solicitar</th>
                                        <th scope="col">Identificador de descuento</th>
                                        <th scope="col">Descripción</th>
                                    </tr>
                                </thead>
                                <tbody class="list-table-pago-body" style="font-size:13px;"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Detalles Clientes -->
                <div class="col-md-12 hidden" id="VentClientes" style="text-align:center; overflow:auto;">
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Tipo de entidad</label>
                            <input type="text" id="TipoEntidad" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Idioma</label>
                            <input type="text" id="nIdioma" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Estatus</label>
                            <input type="text" id="nEstatus" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-8 dr">
                            <label class="title-item-consult">Cliente</label>
                            <input type="text" id="nCliente" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-4 dr">
                            <label class="title-item-consult">Número de empleado</label>
                            <input type="text" id="nNumeroEmpleado" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">RFC</label>
                            <input type="text" id="nRFC" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Alias</label>
                            <input type="text" id="nAlias" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Clasificación</label>
                            <input type="text" id="nClasificacion" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Expediente</label>
                            <input type="text" id="nExpediente" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Grupo</label>
                            <input type="text" id="nGrupo" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Subgrupo</label>
                            <input type="text" id="nSubGrupo" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Sub Subgrupo</label>
                            <input type="text" id="nSSGrupo" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Calidad de cliente</label>
                            <input type="text" id="nCalidadCliente" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-4 dr">
                            <label class="title-item-consult">Ejecutivo de cuenta</label>
                            <input type="text" id="nEjecutivoCuenta" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-4 dr">
                            <label class="title-item-consult">Ejecutivo de cobranza</label>
                            <input type="text" id="nEjecutivoCobranzas" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-4 dr">
                            <label class="title-item-consult">Ejecutivo de reclamaciones</label>
                            <input type="text" id="nEjecutivoReclamacion" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Correo 1</label>
                            <input type="text" id="nCorreo1" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Correo 2</label>
                            <input type="text" id="nCorreo2" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Liga de Internet</label>
                            <input type="text" id="nLigaInternet" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Clave de telemarketing</label>
                            <input type="text" id="nClaveTeleMark" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Cómo se ingresó</label>
                            <input type="text" id="nModoIngreso" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Cómo se enteró</label>
                            <input type="text" id="nComoSeEntero" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Grupo de afinidad</label>
                            <input type="text" id="nGrupoAfinidad" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Centro de costo</label>
                            <input type="text" id="nCentroCosto" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Celular</label>
                            <input type="text" id="nCelular" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Teléfono 2</label>
                            <input type="text" id="nTelefono2" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Teléfono 3</label>
                            <input type="text" id="nTelefono3" class="form-control input-sm textSearch">
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Teléfono 4</label>
                            <input type="text" id="nTelefono4" class="form-control input-sm textSearch">
                        </div>
                    </div>
                    <div class="row space-table mg-row">
                        <div class="col-md-12 container-table">
                            <div class="col-md-12" style="height:250px;overflow:auto; padding:0px;">
                                <table class="table table-striped table-hover table-recibos" id="TablaListaDocumentos" style="margin-bottom: 0px;">
                                    <thead class="table-thead">
                                        <tr style="background: #5286b5;">
                                            <th class="title-table" colspan="24">Documentos</th>
                                        </tr>
                                        <tr class="title-sub-table" style="background: #266093;">
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Documento</th>
                                            <th scope="col">Estatus</th>
                                            <th scope="col">Vigencia</th>
                                            <th scope="col">Inciso</th>
                                            <th scope="col">Solicitud</th>
                                            <th scope="col">Cliente</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list-table-polizas-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row space-bottom c-column-empresa no-info hidden"> <!-- Dos columnas -->
                        <div class="col-md-6 second-column" style="text-align:initial;">
                            <div class="col-md-12 space-bottom">
                                <label class="title-item-consult">Empresa de cobro</label>
                                <input type="text" id="nCobroEmpresa" class="form-control input-sm textSearch">
                            </div>
                            <div class="col-md-12 space-bottom">
                                <label class="title-item-consult">Contacto de cobro</label>
                                <input type="text" id="nCobroContacto" class="form-control input-sm textSearch">
                            </div>
                            <div class="col-md-12 space-bottom">
                                <label class="title-item-consult">Horario de cobro</label>
                                <input type="text" id="nCobroHorario" class="form-control input-sm textSearch">
                            </div>
                            <div class="col-md-12 space-bottom">
                                <label class="title-item-consult">Observaciones de cobro</label>
                                <input type="text" id="nCobroObservacion" class="form-control input-sm textSearch">
                            </div>
                        </div>
                        <div class="col-md-5 second-column no-info" style="text-align:initial;">
                            <div class="col-md-12 segment-result" style="overflow:auto;padding:0px; height:260px;">
                                <table class="table table-datoscliente" style="margin-bottom:0px;">
                                    <thead style="position: sticky;top: 0px;">
                                        <tr style="background: #266093; font-size: 13px;">
                                            <th scope="col">Compañía</th>
                                            <th scope="col">Clave Cliente</th>
                                            <th scope="col">Fecha de Ingreso</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list-table-datoscliente-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-row hidden" style="margin-bottom:20px;">
                        <div class="col-md-12 container-table" style="">
                            <div class="col-md-12" style="overflow:auto; padding:0px; height: 260px;">
                                <table class="table table-striped" style="margin-bottom: 0px;">
                                    <thead style="position: sticky;top: 0px;">
                                        <tr style="background: #5286b5;">
                                            <th colspan="24">
                                                <h5 style="margin:0px;">Observaciones generales</h5>
                                            </th>
                                        </tr>
                                        <tr style="background: #266093; font-size: 13px;">
                                            <th scope="col">Observaciones</th>
                                            <th scope="col">Observaciones de salud</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list-table-observaciones1-body" style="font-size:13px; height:140px;"></tbody>
                                </table>
                            </div>
                            <div class="col-md-12" style="overflow:auto; padding:0px; height: 260px;">
                                <table class="table table-striped" style="margin-bottom: 0px;">
                                    <thead style="position: sticky;top: 0px;">
                                        <tr style="background: #5286b5;">
                                            <th colspan="24">
                                                <h5 style="margin:0px;"></h5>
                                            </th>
                                        </tr>
                                        <tr style="background: #266093; font-size: 13px;">
                                            <th scope="col">Dirección</th>
                                            <th scope="col">Teléfonos</th>
                                            <th scope="col">Tipo de dirección</th>
                                            <th scope="col">Tipo de entidad</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list-table-observaciones2-body" style="font-size:13px; height:140px;"></tbody>
                                </table>
                            </div>
                            <div class="col-md-12" style="overflow:auto; padding:0px; height: 260px;">
                                <table class="table table-striped" style="margin-bottom: 0px;">
                                    <thead style="position: sticky;top: 0px;">
                                        <tr style="background: #5286b5;">
                                            <th colspan="24">
                                                <h5 style="margin:0px;"></h5>
                                            </th>
                                        </tr>
                                        <tr style="background: #266093; font-size: 13px;">
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Puesto/Trato</th>
                                            <th scope="col">Actividad</th>
                                            <th scope="col">Nacionalidad/Idioma</th>
                                            <th scope="col">Correo</th>
                                            <th scope="col">Teléfonos</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list-table-observaciones3-body" style="font-size:13px; height:140px;"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-row hidden" style="margin-bottom:20px; overflow:auto;">
                        <div class="col-md-12 container-table">
                            <table class="table table-striped" style="height:200px; margin-bottom: 0px;">
                                <thead style="position: sticky;top: 0px;">
                                    <tr style="opacity: .8;background: #266093;">
                                        <th colspan="24">
                                            <h5 style="margin:0px;">Documentos artículo 492 (Fianzas)</h5>
                                        </th>
                                    </tr>
                                    <tr style="background: #266093; font-size: 13px;">
                                        <th scope="col">Documento</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Se tiene</th>
                                        <th scope="col">Escaneado</th>
                                        <th scope="col">Fecha de expedición</th>
                                        <th scope="col">Actualizar cada</th>
                                    </tr>
                                </thead>
                                <tbody class="list-table-documentos-fianzas-body" style="font-size:13px;">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Bitácoras -->
                <div class="col-md-12 hidden" id="SegBitacoras" style="text-align:center; overflow:auto;">
                   <div class="row mg-row" style="margin-bottom:20px;">
                       <div class="col-md-12 container-table">
                           <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                               <div class="title-segment-user title-table">Bitácora
                               </div>
                           </div>
                           <div class="col-md-12 segment-btc" id="Bitacoras"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Endosos -->
            <div class="modal-body segment-body-detalles hidden" id="Content-Endosos">
                <div class="col-md-12 content-info-detalles">
                    <div class="row fila-input space-bottom">
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Buscar</label>
                            <select type="text" id="EnBuscar" class="form-control input-sm textSearch"></select>
                        </div>
                        <div class="input-width col-sm-3 dr">
                            <label class="title-item-consult">Endoso</label>
                            <select type="text" id="EnEndosos" class="form-control input-sm textSearch"></select>
                        </div>
                        <div class="col-md-6 second-column segment-vig">
                            <h5 class="textAlert" id="EnStatus" style="margin:5px;color:red">
                                
                            </h5>
                            <hr style="margin-bottom: 5px; border-style: dotted; border-color: red;"/>
                            <h5 id="EnVigente" style="color: #303030"></h5>
                        </div>
                    </div>
                    <div class="row fila-input segment-en space-bottom">
                        <div class="col-md-12 space-bottom fila-input-endosos">
                            <div class="input-en col-sm-5 dr">
                                <label class="text-bold">Cliente</label>
                                <input type="text" id="EnCliente" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">RFC</label>
                                <input type="text" id="EnRFC" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-4 dr">
                                <label class="title-item-consult">Subramo</label>
                                <input type="text" id="EnSubRamo" class="form-control input-sm textAlert">
                            </div>
                        </div>
                        <div class="col-md-12 space-bottom fila-input-endosos">
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Forma de pago</label>
                                <input type="text" id="EnFormaPago" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Grupo</label>
                                <input type="text" id="EnGrupo" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Subgrupo</label>
                                <input type="text" id="EnSubGrupo" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Sub subgrupo</label>
                                <input type="text" id="EnSSubGrupo" class="form-control input-sm textAlert">
                            </div>
                        </div>
                        <div class="col-md-12 space-bottom fila-input-endosos">
                            <div class="input-en col-sm-9 dr">
                                <label class="title-item-consult">Compañía</label>
                                <input type="text" id="EnCompania" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Moneda</label>
                                <input type="text" id="EnMoneda" class="form-control input-sm textAlert">
                            </div>
                        </div>
                        <div class="col-md-12 space-bottom fila-input-endosos">
                            <div class="input-en col-sm-4 dr">
                                <label class="text-bold">Documento</label>
                                <input type="text" id="EnDocumento" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-4 dr">
                                <label class="title-item-consult">Inciso</label>
                                <input type="text" id="EnInciso" class="form-control input-sm textAlert">
                            </div>
                        </div>
                        <div class="col-md-12 fila-input-endosos">
                            <div class="input-en col-sm-9 dr">
                                <label class="title-item-consult">Agente</label>
                                <input type="text" id="EnAgente" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-2 dr">
                                <label class="title-item-consult">T. de cambio</label>
                                <input type="text" id="EnTCambio" class="form-control input-sm textAlert">
                            </div>
                        </div>
                    </div>
                    <div class="row fila-input segment-en space-bottom">
                        <div class="col-md-12 space-bottom fila-input-endosos">
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Tipo Docto</label>
                                <select type="text" id="EnTipoDoc" class="form-control input-sm textSearch"></select>
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">No. Solicitud</label>
                                <input type="text" id="EnNumberSolic" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Desde</label>
                                <input type="text" id="EnDesde" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Hasta</label>
                                <input type="text" id="EnHasta" class="form-control input-sm textAlert">
                            </div>
                            <div class="input-en col-sm-2 cont-btn-en hidden" style="margin-left: 20px;">
                                <button class="btn btn-General btn-Refresh sub-dr" style="color:white; border-radius:4px;">
                                    Distribuir...
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12 space-bottom fila-input-endosos">
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Endoso</label>
                                <input type="text" id="EnEndoso" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Tipo Endoso</label>
                                <select type="text" id="EnTipoEnd" class="form-control input-sm textSearch"></select>
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Fecha Desde</label>
                                <input type="date" id="EnFDesde" class="form-control input-sm textSearch in-dt">
                            </div>
                            <div class="input-en col-sm-3 dr">
                                <label class="title-item-consult">Fecha Hasta</label>
                                <input type="date" id="EnFHasta" class="form-control input-sm textSearch in-dt">
                            </div>
                        </div>
                        <div class="col-md-12 space-bottom fila-input-endosos">
                            <div class="input-en col-sm-5 dr">
                                <label class="title-item-consult">Estatus de usuario</label>
                                <select type="text" id="EnEstatusUs" class="form-control input-sm textSearch"></select>
                            </div>
                        </div>
                        <div class="col-md-12 space-bottom fila-input-endosos">
                            <div class="input-en col-sm-5 dr">
                                <label class="title-item-consult">Referencia 1</label>
                                <input type="text" id="EnReferencia1" class="form-control input-sm textSearch">
                            </div>
                            <div class="input-en col-sm-5 dr">
                                <label class="title-item-consult">Referencia 2</label>
                                <input type="text" id="EnReferencia2" class="form-control input-sm textSearch">
                            </div>
                        </div>
                        <div class="col-md-12 fila-input-endosos">
                            <div class="input-en col-sm-11 dr">
                                <label class="title-item-consult">Concepto</label>
                                <input type="text" id="EnConcepto" class="form-control input-sm textSearch">
                            </div>
                        </div>
                    </div>
                    <div class="row tables-tabP2">
                        <div class="col-md-6 columns-table-recibo container-com">
                            <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                                <div class="title-segment-user title-table" style="text-align: center;">
                                    Detalle de primas
                                </div>
                            </div>
                            <div class="col-md-12 segment-body-comision-en com1">  
                                <div class="col-md-7 column-primas column-com">
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Prima neta: </label>
                                        <input type="text" id="EnPrimaNeta" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Descuento: </label>
                                        <input type="text" id="EnDescuento" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Extra prima: </label>
                                        <input type="text" id="EnExtraPrima" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Recargos: </label>
                                        <input type="text" id="EnRecargos" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Derechos: </label>
                                        <input type="text" id="EnDerechos" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Subtotal: </label>
                                        <input type="text" id="EnSubTotal" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">De inversión:</label>
                                        <input type="text" id="EnInversion" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r hidden">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">IVA:</label>
                                        <input type="text" id="EnIVA" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r hidden">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Ajuste:</label>
                                        <input type="text" id="EnAjuste" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Prima Total: </label>
                                        <input type="text" id="EnPrimaTotal" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                </div>
                                <div class="col-md-5 column-primas" style="padding-right: 10px;">
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <span class="input-sm title-item-recibo">%</span>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <input type="text" id="EnDescPrctj" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <input type="text" id="EnExPrmPrctj" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <input type="text" id="EnRcgsPrctj" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <span class="input-sm textSearch align-money"></span>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <span class="input-sm textSearch align-money"></span>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <span class="input-sm textSearch align-money"></span>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r hidden">
                                        <input type="text" id="EnIVAPrctj" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 columns-table-recibo container-com">
                            <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                                <div class="title-segment-user title-table" style="text-align: center;">
                                    Primer recibo
                                </div>
                            </div>
                            <div class="col-md-12 segment-body-comision-en com2">  
                                <div class="col-md-11 column-primas">
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Prima neta: </label>
                                        <input type="text" id="EnPriNePR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Descuento: </label>
                                        <input type="text" id="EnDescPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Extra prima: </label>
                                        <input type="text" id="EnExPriPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Recargos: </label>
                                        <input type="text" id="EnRecPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Derechos: </label>
                                        <input type="text" id="EnDerPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Subtotal: </label>
                                        <input type="text" id="EnSubTotPR" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">De inversión:</label>
                                        <input type="text" id="EnInvPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r hidden">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">IVA:</label>
                                        <input type="text" id="EnIVAPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r hidden">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Ajuste:</label>
                                        <input type="text" id="EnAjustePR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Prima Total: </label>
                                        <input type="text" id="EnPrimTotPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                </div>
                                <!-- <div class="col-md-5 column-primas" style="padding-right: 10px;">
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <span class="input-sm title-item-recibo">%</span>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <input type="text" id="EnDescPrctPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <input type="text" id="EnExPrmPrcPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <input type="text" id="EnRcgsPrcPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <span class="input-sm textSearch align-money"></span>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <span class="input-sm textSearch align-money"></span>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <span class="input-sm textSearch align-money"></span>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r hidden">
                                        <input type="text" id="EnIVAPrcPR" class="form-control input-sm textSearch align-money"/>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row tables-tabP2">
                        <div class="col-md-6 columns-table-recibo container-com">
                            <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                                <div class="title-segment-user title-table" style="text-align:center;">
                                    <!-- padding-top:3px; padding-bottom:3px; display: flex; align-items: center; -->
                                    <div class="segment-btn-sigma hidden">
                                        <button class="btn btn-sigma" style="color: white;">
                                            Σ
                                        </button>
                                    </div>
                                    Detalle de comisiones
                                </div>
                            </div>
                            <div class="col-md-12 segment-body-comision-en com3">
                                <div class="col-md-7 column-primas column-com">
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Neta: </label>
                                        <input type="text" id="EnNeta" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Extra prima: </label>
                                        <input type="text" id="EnExtraPrimaC" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Recargos: </label>
                                        <input type="text" id="EnRecargosC" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Derechos: </label>
                                        <input type="text" id="EnDerechosC" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-com space-bottom-r">
                                        <label class="title-sub-item-consult" style="padding-right:3px;">Especial: </label>
                                        <input type="text" id="EnEspecialC" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                </div>
                                <div class="col-md-5 column-primas" style="padding-right: 10px;">
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <input type="text" id="EnNetaC" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <input type="text" id="EnExtPrmC" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <input type="text" id="EnRcgsC" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <input type="text" id="EnDrchsC" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                    <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                        <input type="text" id="EnEspC" class="form-control input-sm textAlert align-money"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 columns-table-recibo container-com">
                            <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                                <div class="title-segment-user title-table" style="text-align:center;">
                                    <!-- padding-top:3px; padding-bottom:3px; display: flex; align-items: center; -->
                                    <div class="segment-btn-sigma hidden">
                                        <button class="btn btn-sigma" style="color: white;">
                                            Σ
                                        </button>
                                    </div>
                                    Registro de fechas
                                </div>
                            </div>
                            <div class="col-md-12 segment-body-comision-en com4">
                                <div class="col-md-6" style="padding-right: 10px;">
                                    <div class="input-width col-md-12 space-bottom-r">
                                        <label class="title-item-recibo">Fecha solicitud</label>
                                        <input type="date" id="EnFSolicitud" class="form-control input-sm textSearch in-dt">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom-r">
                                        <label class="title-item-recibo">Envío</label>
                                        <input type="date" id="EnEnvio" class="form-control input-sm textSearch in-dt">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom-r">
                                        <label class="title-item-recibo">Recepción</label>
                                        <input type="date" id="EnRecepcion" class="form-control input-sm textSearch in-dt">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom-r">
                                        <label class="title-item-recibo">Fecha conversión</label>
                                        <input type="text" id="EnFConversion" class="form-control input-sm textSearch">
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding-left: 10px;">
                                    <div class="input-width col-md-12 space-bottom-r">
                                        <label class="title-item-recibo">Captura</label>
                                        <input type="text" id="EnCaptura" class="form-control input-sm textSearch">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom-r">
                                        <label class="title-item-recibo">Folio No.</label>
                                        <input type="text" id="EnFolioNumber" class="form-control input-sm textSearch">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom-r">
                                        <label class="title-item-recibo">Emisión</label>
                                        <input type="date" id="EnEmision" class="form-control input-sm textSearch in-dt">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom-r">
                                        <label class="title-item-recibo">Entrega</label>
                                        <input type="date" id="EnEntrega" class="form-control input-sm textSearch">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 15px; text-align: center;">
                                    <label id="EnRegistroUs" class="title-item-recibo-bold name-subr"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function PanelBitacoras(dato) {
        const clave = dato;

        $.ajax({
            type: "GET",
            url: `${baseUrl}/InformacionBitacoras`,
            data: {
                cl: dato
            },
            beforeSend: (load) => {
                $('#Bitacoras').html(`
                    <div class="container-spinner-table-polizas">
                        <div class="pb-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);

                $('#TablaTotales').addClass('opaco');
            },
            success: (data) => {
                const btc = JSON.parse(data);
                //console.log(btc);

                $('#Bitacoras').html("");
                var bt = ``;

                if (btc != 0) {
                    for (c in btc) {
                        //Valor
                        const UserGen = valor(btc[c].UserGen);
                        const Procedencia = valor(btc[c].Procedencia);
                        const Comentario = valor(btc[c].Comentario);

                        //Fecha
                        var FchBit = new Date(btc[c].FechaHora);
                        var FBitac = nombredias[FchBit.getDay()] + " " + fecha(btc[c].FechaHora) + " " + FchBit.toLocaleTimeString('en-US');

                        bt += `
                            <div class="col-md-12 btc-client">
                                <div class="col-md-3 sub-dr icon-responsive" style="flex-direction:column;">
                                    <div class="img-profile">
                                        <i class="fa fa-user icon-profile"></i>
                                    </div>
                                    <span class="badge title-tag-user" id="TagUser" style="background:#9a9240;">${UserGen}</span>
                                </div>
                                <div class="col-md-9 sub-dr container-info-bit" style="flex-direction:column;">
                                    <div class="col-md-12 sub-date-bit" style="padding-top:5px;">
                                        <div class="col-md-8">
                                            <h5 class="title-item-consult">
                                                <strong id="FechaOperacion">${FBitac}</strong>
                                            </h5>
                                        </div>
                                        <div class="col-md-5 proc-responsive" style="padding: 0px;">
                                            <h5 class="title-item-consult" style="margin-left:6px;">
                                                <strong id="Procedencia">${Procedencia}</strong>
                                            </h5>
                                        </div>
                                    </div>
                                    <p class="title-item-consult" id="TextComentario" style="text-align:left; padding:10px;">
                                        ${Comentario}
                                    </p>
                                </div>
                            </div>`;
                    }
                }
                else {
                    bt += `
                        <div class="col-md-12 btc-client-sinR">
                            <h4>Sin bitácoras generadas</h4>
                        </div>`;
                }

                $('#Bitacoras').html(bt);
            },
            error: (error) => {
                console.log("Hay problemas al buscar las bitácoras.");
            }
        })
    }

    function TablaPolizas(dato) {
        $.ajax({
            type: "GET",
            url: `${baseUrl}/InformacionPolizas`,
            data: {
                cl: dato
            },
            beforeSend: (load) => {
                $('.list-table-polizas-body').html(`
                    <div class="container-spinner-content-table-polizas">
                        <div class="tr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);
            },
            success: (data) => {
                const p = JSON.parse(data);
                //console.log(p);

                const r = p['polizas'];
                var trtd = ``;

                if (r != 0) {
                    for (a in r) {
                        const NombreCompleto = valor(r[a].NombreCompleto);
                        const TipoDocto_TXT = valor(r[a].TipoDocto_TXT);
                        const Documento = valor(r[a].Documento);
                        const Inciso =  valor(r[a].Inciso);
                        const Estatus =  valor(r[a].StatusDocto);
                        const FDesde = fecha(r[a].FDesdePoliza);
                        const FHasta = fecha(r[a].FHastaPoliza);
                        const Vigencia = FDesde + " a " + FHasta;
                        const Solicitud = valor(r[a].Solicitud);

                        trtd += `
                            <tr class="filaPolizas" data-id="${r[a].IDDocto}">
                                <td>${TipoDocto_TXT}</td>
                                <td data-doc="${Documento}" title="Copiar" onclick="ClickDoc(this)" style="cursor:pointer;">${Documento}</td>
                                <td>${Estatus}</td>
                                <td>${Vigencia}</td>
                                <td>${Inciso}</td>
                                <td>${Solicitud}</td>
                                <td>${NombreCompleto}</td>
                            </tr>`;
                    }
                }
                else {
                    trtd += `
                        <tr>
                            <td></td>
                            <td></td>
                            <td><h5>Sin resultados</h5></td>
                            <td></td>
                            <td></td>
                        </tr>`;
                }
                $(".list-table-polizas-body").html(trtd);
            },
            error: (error) => {
                console.log("Hay problemas al buscar los documentos del cliente.");
            }
        })
    }

    function ClickDoc(dato) {
        const documento = $(dato).data('doc');
        //console.log("Texto copiado: " + documento);
        var $temp = $("<input>")
        $("body").append($temp);
        $temp.val(documento).select();
        document.execCommand("copy");
        $temp.remove();
        toastr.info("Texto Copiado");
    }
</script>
<script>

     function addSelectTipoAct(select){
    selectTipoEndoso= select.replaceAll('%', '"');
     contenedorSelect=document.getElementById("tipoActividad");
     contenedorEndoso=document.getElementById("divTipoEndoso");
     if(contenedorSelect.value=="Endoso"){
        console.log("Entro");
        document.getElementById("divTipoEndoso").style.visibility="visible";
        document.getElementById("divTipoEndoso").innerHTML='<div class="col-md-4" style="padding-top: 2%;"><label class="Responsivo lbEtiqueta">Tipo de endoso:</label></div><div id="SelectTipoActividad" class="col-md-8">'+selectTipoEndoso+'</div>';
     }else{
        document.getElementById("divTipoEndoso").style.visibility="none";
        document.getElementById("divTipoEndoso").innerHTML='';
     }
     
     }
     function selecTipoEndoso(tipo){
        document.getElementById("datosExpres").value="ENDOSO DEL TIPO: "+tipo;
     }
     
    function crearActividadSiniestro(){
        idvend=document.getElementById('Vendedor').dataset.idvend;
        tipoActividad=document.getElementById('tipoActividad').value;
        subRamoActividad=document.getElementById('SubRamo').dataset.subramo;
        idcli=document.getElementById('Cliente').dataset.idcli;
        idcont=document.getElementById('IDCont').value;
        idagente=document.getElementById('Vendedor').dataset.idvend;
        idsramo=document.getElementById('SubRamo').dataset.idsubramo;
        ramoBefore= document.getElementById('Ejecutivo').dataset.ramo;
        ramo= ramoBefore.replaceAll('Ñ', 'N');
        ramo= ramo.replaceAll(' ', '_');
        documento=document.getElementById('Documento').value;
        tipodocto=document.getElementById('Documento').dataset.tipodocto;
        iddocto=document.getElementById('Documento').dataset.iddocto;
        idejecutivo= document.getElementById('Ejecutivo').dataset.idejecutivo;
        folioSiniestros=document.getElementById('folioSiniestros').value;
        datosExpres=document.getElementById('datosExpres').value;

        if(folioSiniestros==0||folioSiniestros==""){
            swal("¡Advertencia!", "No has ingresado el folio de la actividad", "warning");
        }else{
                   var parametros = {
                "IDVend" : idvend,
                "tipoActividad": tipoActividad,
                "subRamoActividad": subRamoActividad,
                "tipoSubRamo": subRamoActividad,
                "tipoCliente": "Existente",
                "IDCli": idcli,
                "IDAgente": "63",
                "IDGrupo" : "1",
                "IDSRamo": idsramo,
                "tipoRamo": ramo,
                "IDCont": idcont,
                "tipoActividadSicas": "tarea",
                "actividadUrgente" : "0",
                "poliza": documento,
                "IDUserR": "19",
                "IDTTarea": "0",
                "datosExpres":datosExpres,
                "IDDir" : "-1",
                "IDEjecut" : idejecutivo,
                "TipoDocto" : tipodocto,
                "usuarioCreacion": "CLIENTECORPORATIVO",
                "actividadUrgente" : "0",
                "usuarioResponsable": "EJECUTIVOCORPORATIVO@AGENTECAPITAL.COM",
                "usuarioBolita": "EJECUTIVOCORPORATIVO@AGENTECAPITAL.COM",
                "folioSiniestros" : folioSiniestros,  
                "IDDocto" : iddocto,
        };

        console.log(parametros);
        $.ajax({
            type: "post",
            url: "<?=base_url()?>actividades/agregarGuardar", 
            data: parametros,
            beforeSend: function (){
                $('#cargandoAct').html(`
                    <div class="container-spinner-content-solicitudes-polizas">
                        <div class="cr-spinner spinner-border" role="status" style="color:#472380 !important;">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:16px;color:#472380 !important;">Cargando...</p>
                    </div>
                `);
            },
            success: function(response){
               
                    if(response=="ActividadEncontrada"){
                        swal("¡Advertencia!", "Ya se encuentra registrada una actividad para este documento con el mismo folio", "warning");
                        $('#cargandoAct').html(``);
                    }
                else{
                swal("¡Exito!", "La actividad fue creada con exito", "success");
                $('#crearActividades').modal('hide');
                location.reload();
                }
                console.log(response);

            }

        }) 
        }



    }
    function isset(ref){
        return typeof ref !=='undefined'
    }
</script>