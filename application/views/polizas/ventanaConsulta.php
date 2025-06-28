<!-- Panel para la búsqueda de pólizas -->
<div class="table-resultados-modal view-search-polizas" id="search-polizas" style="display:none;">
    <div class="col-md-12" style="padding:0px;">
        <!-- Sección de Búsqueda-->
        <div class="modal-content" style="width:400px; opacity:1; margin:0px; margin-right:5px;">
            <div class="modal-header" id="seccionSearch" style="height:60px; border-radius:5px; cursor:all-scroll;">
                <div class="input-group mb-3" id="busqueda">
                    <select class="input-group-text select-buscar" id="SelectSearch" title="Tipo de búsqueda" style="font-size:14px; border-top-right-radius:0px; border-bottom-right-radius:0px; width: 110px; text-align: left;">
                        <option value="0">Buscar por</option>
                        <option class="" value="1">Número Cliente</option> <!-- Cambiar por empleado -->
                        <option value="2">Documento</option>
                        <option class="hidden" value="3">Contacto</option> <!-- Pendiente 41397-->
                        <option value="4">Nombre Cliente</option>
                        <option class="hidden" value="5">Cliente por grupo</option> <!-- Pendiente -->
                        <option class="hidden" value="6">Dependiente</option> <!-- Pendiente -->
                        <option class="hidden" value="7">Documento por grupo</option>
                        <option class="hidden" value="8">Referencia 1</option>
                        <option class="hidden" value="9">Referencia 2</option>
                        <option class="hidden" value="10">Folio documento</option> <!-- Pendiente FolioDocto: WUC-->
                        <option class="hidden" value="11">Contrato o folio</option> <!-- Pendiente -->
                        <option value="12">Serie</option> <!-- 001/002 -->
                        <option class="hidden" value="13">Placas</option> <!-- Pendiente -->
                        <option class="hidden" value="14">Folio de recibo</option> <!-- Pendiente -->
                        <option class="hidden" value="15">Número de reporte</option> <!-- Pendiente -->
                        <option class="hidden" value="16">Número de reclamación</option> <!-- Pendiente -->
                        <option class="hidden" value="17">Titular</option> <!-- Pendiente -->
                        <option class="hidden" value="18">Afectado</option> <!-- Afectado -->
                        <option class="hidden" value="19">Folio</option> <!-- Pendiente -->
                    </select>
                    <input type="text" class="form-control textSearch" id="text-search" placeholder="Buscar" style="width:60%; height:90%;"> <!-- 86% -->
                    <button class="input-group-text btn-buscar" id="SearchPoliza" onclick="BuscarDatos()">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="container-btn-search">
            <a type="button" class="btn-seg-search btn-resultados" id="ViewPanelResultadosBusqueda" title="Resultados de búsqueda" data-toggle="collapse" href="#PanelResultadosBusqueda" aria-expanded="false" aria-controls="popup-causally">
                <i class="fa fa-arrow-circle-down" id="icon-result" aria-hidden="true" style="font-size:40px;"></i>
            </a>
            <a type="button" class="btn-seg-search btn-panel" id="ViewPanelDetallesBusqueda" title="Info de resultado" data-toggle="collapse" href="#PanelDetallesBusqueda" aria-expanded="false" aria-controls="popup-causally">
                <i class="fa fa-arrow-circle-right" id="icon-form" aria-hidden="true" style="font-size:40px;"></i>
            </a>
            <a type="button" class="btn-seg-search btn-borrar" id="LimpiarBusqueda" title="Limpiar" style="width:35px; height:35px;">
                <i class="fa fa-eraser icon-borrar" aria-hidden="true" style="font-size:23px;"></i>
            </a>
            <a type="button" class="btn-seg-search btn-borrar hidden" id="AnclarVentana" title="Anclar" style="width:35px; height:35px;">
                <i class="fa fa-compress icon-anclar" aria-hidden="true" style="font-size:23px;"></i>
            </a>
            <a type="button" class="btn-seg-search btn-close" id="NoViewPanelResultadosBusqueda" title="Cerrar todo">
                <i class="fa fa-times-circle" aria-hidden="true" style="font-size:40px;"></i>
            </a>
        </div>
        <!-- Sección de Resultados -->
        <div class="modal-content collapse" id="PanelResultadosBusqueda" style="width: 400px; margin-top:5px; visibility:visible;">
            <div class="modal-header" style="height: 45px;">
                <h4 style="margin-top: 0px;margin-bottom: 0px;">Resultados de búsqueda</h4>
            </div>
            <div class="modal-body table-responsive">
                <div class="col-md-12 segment-result" id="view-table-polizas" style="overflow:auto; padding:0px; height: 260px;">
                </div>
            </div>
            <div class="container-refresh">
                <button class=" btn btn-General btn-Refresh-r sub-dr" onclick="BuscarDatos()" style="color:white; border-radius:4px; padding:0px;">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </button>
                <p class="hidden" id="CantidadResultados"></p>
            </div>
        </div>
    </div>
    <div class="col-md-13" style="padding:0px;">
        <!-- Sección de Detalles -->
        <div class="table-polizas-modal collapse" id="PanelDetallesBusqueda" style="visibility:visible;">
            <div class="modal-content" style="width: 800px;height: 500px;margin-top: 0px;">
                <div class="modal-header" style="height:109.4px; display:flex; flex-direction:row; align-items:center;"> <!-- height:150px; -->
                    <h4 id="TituloDetalles" style="margin-top: 0px;margin-bottom: 0px;">Detalles del documento</h4>
                    <h5 id="SelectDocument" style="margin: 0px; padding-left: 5px;"></h5>
                    <button type="button" class="close" id="ClosePanelDetallesBusqueda" style="padding:5px;margin-top:-12px;font-size:30px;color: lavender;">
                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="content-solicitudes-y-polizas"></div>
                <div class="modal-body table-responsive" id="Content-Info-Busqueda">
                    <!-- Solicitudes y Pólizas | Series -->
                    <div class="col-md-12 hidden" id="VentPolizas" style="text-align:center; overflow:auto;">
                        <h4 class="title-item-consult hidden">Poliza seleccionada<strong type="text" id="PolizaNumber" style="font-weight: 100;"></strong></h4>
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Tipo documento</label>
                                <input type="text" id="TipoDocumento" class="form-control input-sm" name="tipoDocumento" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Póliza maestra</label>
                                <input type="text" id="Poliza" class="form-control input-sm" name="polizaMuestra" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Estatus</label>
                                <input type="text" id="Estatus" class="form-control input-sm" name="estatus" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">No. de Folio</label>
                                <input type="text" id="Folio" class="form-control input-sm" name="numeroFolio" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Documento</label>
                                <input type="text" id="Documento" class="form-control input-sm" name="Documento" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Inciso</label>
                                <input type="text" id="Inciso" class="form-control input-sm" name="Inciso" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="text-bold">Anterior</label>
                                <input type="text" id="Anterior" class="form-control input-sm" name="anterior" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="text-bold">Posterior</label>
                                <input type="text" id="Posterior" class="form-control input-sm" name="posterior" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-7 dr">
                                <label class="title-item-consult">Cliente</label>
                                <input type="text" id="Cliente" class="form-control input-sm" name="cliente" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">RFC</label>
                                <input type="text" id="RFC" class="form-control input-sm" name="RFC" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Grupo</label>
                                <input type="text" id="Grupo" class="form-control input-sm" name="grupo" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Subgrupo</label>
                                <input type="text" id="SubGrupo" class="form-control input-sm" name="subgrupo" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Sub subgrupo</label>
                                <input type="text" id="Sub-SubGrupo" class="form-control input-sm" name="sub-subgrupo" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Expediente</label>
                                <input type="text" id="Expediente" class="form-control input-sm" name="expediente" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-8 dr">
                                <label class="title-item-consult">Dirección</label>
                                <input type="text" id="Direccion" class="form-control input-sm" name="direccion" style="width:100%;">
                            </div>
                            <div class="col-sm-4 dr">
                                <label class="title-item-consult">Subramo</label>
                                <input type="text" id="SubRamo" class="form-control input-sm" name="subramo" style="width:100%;">
                            </div>
                        </div>
                        <div class="row"> <!-- Dos columnas -->
                            <div class="col-md-6" style="margin-bottom:10px; width:50%; text-align:initial; padding-top:10px; padding-left: 0px;">
                                <div class="col-md-12 space-bottom">
                                    <label class="title-item-consult">Agente</label>
                                    <input type="text" id="Agente" class="form-control input-sm" name="agente" style="width:100%;">
                                </div>
                                <div class="col-md-12 space-bottom">
                                    <label class="title-item-consult">Compañía</label>
                                    <input type="text" id="Compania" class="form-control input-sm" name="compania" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Ejecutivo</label>
                                    <input type="text" id="Ejecutivo" class="form-control input-sm" name="ejecutivo" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Forma de pago</label>
                                    <input type="text" id="Pago" class="form-control input-sm" name="pago" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Vendedor</label>
                                    <input type="text" id="Vendedor" class="form-control input-sm" name="vendedor" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Moneda</label>
                                    <input type="text" id="Moneda" class="form-control input-sm" name="moneda" style="width:100%;">
                                </div>
                            </div>
                            <div class="col-md-6 second-column" style="text-align:initial;">
                                <div class="col-sm-6 space-bottom">
                                    <label class="title-item-consult">Desde</label>
                                    <input type="text" id="Desde" class="form-control input-sm" name="desde" style="width:100%;">
                                </div>
                                <div class="col-sm-6 space-bottom">
                                    <label class="title-item-consult">Hasta</label>
                                    <input type="text" id="Hasta" class="form-control input-sm" name="hasta" style="width:100%;">
                                </div>
                                <div class="col-sm-6 space-bottom">
                                    <label class="title-item-consult">Renovación</label>
                                    <input type="text" id="Renovacion" class="form-control input-sm" name="renovacion" style="width:100%;">
                                </div>
                                <div class="col-sm-6 space-bottom">
                                    <label class="title-item-consult">Fecha de antigüedad</label>
                                    <input type="text" id="Antiguedad" class="form-control input-sm" name="antiguedad" style="width:100%;">
                                </div>
                                <div class="col-sm-6 space-bottom">
                                    <label class="title-item-consult">Captura</label>
                                    <input type="text" id="Captura" class="form-control input-sm" name="captura" style="width:100%;">
                                </div>
                                <div class="col-sm-6 space-bottom">
                                    <label class="title-item-consult">Envío</label>
                                    <input type="text" id="Envio" class="form-control input-sm" name="envio" style="width:100%;">
                                </div>
                                <div class="col-sm-6">
                                    <label class="title-item-consult">Recepción</label>
                                    <input type="text" id="Recepcion" class="form-control input-sm" name="recepcion" style="width:100%;">
                                </div>
                                <div class="col-sm-6">
                                    <label class="title-item-consult">Emisión</label>
                                    <input type="text" id="Emision" class="form-control input-sm" name="emision" style="width:100%;">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-12 dr">
                                <label class="title-item-consult">Concepto</label>
                                <input type="text" id="Concepto" class="form-control input-sm" name="concepto" style="width:100%;">
                            </div>
                        </div>
                        <!-- Parte de la ventana Series -->
                        <div class="row container-table hidden" id="Parte1-Series" style="margin-bottom:20px;">
                            <div class="col-md-12 space-bottom">
                                <div class="col-sm-3 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Marca</label>
                                    <input type="text" id="sMarca" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-4 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Tipo</label>
                                    <input type="text" id="sTipo" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-3 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Transmisión</label>
                                    <input type="text" id="sTransmision" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-2 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Puertas</label>
                                    <input type="text" id="sPuertas" class="form-control input-sm" style="width:100%;">
                                </div>
                            </div>
                            <div class="col-md-12 space-bottom">
                                <div class="col-sm-2 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Modelo</label>
                                    <input type="text" id="sModelo" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-2 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Clave</label>
                                    <input type="text" id="sClave" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-4 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Placas</label>
                                    <input type="text" id="sPlacas" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-4 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Serie</label>
                                    <input type="text" id="sSerie" class="form-control input-sm" style="width:100%;">
                                </div>
                            </div>
                            <div class="col-md-12 space-bottom">
                                <div class="col-sm-3 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Motor</label>
                                    <input type="text" id="sMotor" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-2 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Repuve</label>
                                    <input type="text" id="sRepuve" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-3 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Cía. Localización</label>
                                    <input type="text" id="sCiaLocal" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-4 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Serie Localizador</label>
                                    <input type="text" id="sSerieLocal" class="form-control input-sm" style="width:100%;">
                                </div>
                            </div>
                            <div class="col-md-12 space-bottom">
                                <div class="col-sm-6 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Plan</label>
                                    <input type="text" id="sPlan" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-sm-6 dr" style="padding-left:5px; padding-right:5px;">
                                    <label class="title-item-consult">Asegurado principal/conductor</label>
                                    <input type="text" id="sAseguradoPC" class="form-control input-sm" style="width:100%;">
                                </div>
                            </div>
                        </div>
                        <div class="row mg-row hidden" id="Parte2-Series" style="margin-bottom:20px;">
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
                        <div class="row"> <!-- Dos columnas -->
                            <div class="col-md-7" style="margin-bottom:10px; width:50%; text-align:initial; padding-top:10px; padding-left: 0px;">
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Referencia 1</label>
                                    <input type="text" id="Referencia1" class="form-control input-sm" name="referencia1" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Estatus de cobro</label>
                                    <input type="text" id="Cobro" class="form-control input-sm" name="cobro" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Referencia 2</label>
                                    <input type="text" id="Referencia2" class="form-control input-sm" name="referencia2" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Estatus usuario</label>
                                    <input type="text" id="EstatusUsuario" class="form-control input-sm" name="estatusUsuario" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Referencia 3</label>
                                    <input type="text" id="Referencia3" class="form-control input-sm" name="referencia3" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Clasificación documento</label>
                                    <input type="text" id="ClasDoc" class="form-control input-sm" name="clasDoc" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult" id="Campo1-Cambio"></label>
                                    <input type="text" id="Referencia4" class="form-control input-sm" name="referencia4" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Gerencia</label>
                                    <input type="text" id="Gerencia" class="form-control input-sm" name="gerencia" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Despacho</label>
                                    <input type="text" id="Despacho" class="form-control input-sm" name="despacho" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom hidden" id="Parte3-Series">
                                    <label class="title-item-consult">Línea de negocio</label>
                                    <input type="text" id="sLineaNegocio" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Tipo de conducto cobro</label>
                                    <input type="text" id="TipoCondCobro" class="form-control input-sm" name="tipoCondCobro" style="width:100%;">
                                </div>
                                <div class="col-md-6 space-bottom">
                                    <label class="title-item-consult">Conducto de cobro</label>
                                    <input type="text" id="CondCobro" class="form-control input-sm" name="condCobro" style="width:100%;">
                                </div>
                            </div>
                            <div class="col-md-5 second-column" style="text-align:end; height:400px;">
                                <div class="col-sm-12 sub-dr space-bottom">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Prima neta: </label>
                                    <input type="text" id="PrimaNeta" class="form-control input-sm align-money"/>
                                </div>
                                <div class="col-sm-12 sub-dr space-bottom">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Descuento: </label>
                                    <input type="text" id="Descuento" class="form-control input-sm align-money" name="descuento"/>
                                </div>
                                <div class="col-sm-12 sub-dr space-bottom" id="Parte1-Polizas">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Extra prima: </label>
                                    <input type="text" id="ExtraPrima" class="form-control input-sm align-money" name="extraPrima"/>
                                </div>
                                <div class="col-sm-12 sub-dr space-bottom">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Recargos: </label>
                                    <input type="text" id="Recargos" class="form-control input-sm align-money" name="recargos"/>
                                </div>
                                <div class="col-sm-12 sub-dr space-bottom">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Derechos: </label>
                                    <input type="text" id="Derechos" class="form-control input-sm align-money" name="derechos"/>
                                </div>
                                <div class="col-sm-12 sub-dr space-bottom">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Subtotal: </label>
                                    <input type="text" id="SubTotal" class="form-control input-sm align-money" name="subtotal"/>
                                </div>
                                <div class="col-sm-12 sub-dr space-bottom">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">IVA: </label>
                                    <input type="text" id="IVA" class="form-control input-sm align-money" name="iva"/>
                                </div>
                                <div class="col-sm-12 sub-dr space-bottom hidden" id="Parte4-Series">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Ajuste: </label>
                                    <input type="text" id="sAjuste" class="form-control input-sm align-money"/>
                                </div>
                                <div class="col-sm-12 sub-dr space-bottom hidden">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Prima Pendiente: </label>
                                    <input type="text" id="PrimaPend" class="form-control input-sm align-money"/>
                                </div>
                                <div class="col-sm-12 sub-dr">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Prima Total: </label>
                                    <input type="text" id="PrimaTotal" class="form-control input-sm align-money" name="primaTotal"/>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-4 dr">
                                <label class="title-item-consult">Endoso</label>
                                <select  class="form-control input-sm mright" id="Endoso" name="endoso" placeholder="Ninguno">
                                    <option value="1"></option>
                                </select>
                            </div>
                            <div class="col-sm-4 dr">
                                <label class="title-item-consult">Tipo de pago</label>
                                <input type="text" id="TipoPago" class="form-control input-sm mright"  name="tipoPago"/>
                            </div>
                            <div class="col-sm-4 dr">
                                <label class="title-item-consult">Tipo de venta</label>
                                <input type="text" id="TipoVenta" class="form-control input-sm mright"  name="tipoVenta"/>
                            </div>
                        </div>
                        <div class="row mg-row" style="margin-bottom:20px;">
                            <div class="col-md-12 container-table" style="">
                                <div class="col-md-12" style="overflow:auto; padding:0px; height: 260px;">
                                    <table class="table table-striped table-recibos" id="TablaListaRecibos" style="margin-bottom: 0px;">
                                        <thead style="position: sticky;top: 0px;">
                                            <tr style="background: #5286b5;">
                                                <th colspan="24">
                                                    <h5 style="margin:0px;">Lista de recibos</h5>
                                                </th>
                                            </tr>
                                            <tr style="background: #266093; font-size: 13px;">
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
                                                <th scope="col">Prima Pagada</th>
                                                <th scope="col">Honorario</th>
                                                <th scope="col">Folio Liquidación</th>
                                                <th scope="col">Importe Cobro</th>
                                                <th scope="col">Fecha de Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list-table-recibos-body" style="font-size:13px; height:140px;">
                                        </tbody>
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
                        <div class="row mg-row" id="Parte2-Polizas" style="margin-bottom:20px; overflow:auto;">
                            <div class="col-md-12 container-table">
                                <table class="table table-striped table-totales" id="TablaTotales" style="height:200px; margin-bottom: 0px;">
                                    <thead style="position: sticky;top: 0px;">
                                        <tr style="opacity: .8;background: #266093;">
                                            <th colspan="24">
                                                <h5 style="margin:0px;">Totales</h5>
                                            </th>
                                        </tr>
                                        <tr style="background: #266093; font-size: 13px;">
                                            <th scope="col">Concepto</th>
                                            <th scope="col">Prima neta</th>
                                            <th scope="col">Prima total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list-table-totales-body" style="font-size:13px;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mg-row hidden" id="Parte3-Polizas" style="margin-bottom:20px; overflow:auto;">
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
                                    <tbody class="list-table-pago-body" style="font-size:13px;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Detalles Clientes -->
                    <div class="col-md-12 hidden" id="VentClientes" style="text-align:center; overflow:auto;">
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Tipo de entidad</label>
                                <input type="text" id="TipoEntidad" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Idioma</label>
                                <input type="text" id="nIdioma" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Estatus</label>
                                <input type="text" id="nEstatus" class="form-control input-sm" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-8 dr">
                                <label class="title-item-consult">Cliente</label>
                                <input type="text" id="nCliente" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-4 dr">
                                <label class="title-item-consult">Número de empleado</label>
                                <input type="text" id="nNumeroEmpleado" class="form-control input-sm" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">RFC</label>
                                <input type="text" id="nRFC" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Alias</label>
                                <input type="text" id="nAlias" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Clasificación</label>
                                <input type="text" id="nClasificacion" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Expediente</label>
                                <input type="text" id="nExpediente" class="form-control input-sm" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Grupo</label>
                                <input type="text" id="nGrupo" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Subgrupo</label>
                                <input type="text" id="nSubGrupo" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Sub Subgrupo</label>
                                <input type="text" id="nSSGrupo" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Calidad de cliente</label>
                                <input type="text" id="nCalidadCliente" class="form-control input-sm" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-4 dr">
                                <label class="title-item-consult">Ejecutivo de cuenta</label>
                                <input type="text" id="nEjecutivoCuenta" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-4 dr">
                                <label class="title-item-consult">Ejecutivo de cobranza</label>
                                <input type="text" id="nEjecutivoCobranzas" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-4 dr">
                                <label class="title-item-consult">Ejecutivo de reclamaciones</label>
                                <input type="text" id="nEjecutivoReclamacion" class="form-control input-sm" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Correo 1</label>
                                <input type="text" id="nCorreo1" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Correo 2</label>
                                <input type="text" id="nCorreo2" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Liga de Internet</label>
                                <input type="text" id="nLigaInternet" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Clave de telemarketing</label>
                                <input type="text" id="nClaveTeleMark" class="form-control input-sm" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Cómo se ingresó</label>
                                <input type="text" id="nModoIngreso" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Cómo se enteró</label>
                                <input type="text" id="nComoSeEntero" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Grupo de afinidad</label>
                                <input type="text" id="nGrupoAfinidad" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Centro de costo</label>
                                <input type="text" id="nCentroCosto" class="form-control input-sm" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Celular</label>
                                <input type="text" id="nCelular" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Teléfono 2</label>
                                <input type="text" id="nTelefono2" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Teléfono 3</label>
                                <input type="text" id="nTelefono3" class="form-control input-sm" style="width:100%;">
                            </div>
                            <div class="col-sm-3 dr">
                                <label class="title-item-consult">Teléfono 4</label>
                                <input type="text" id="nTelefono4" class="form-control input-sm" style="width:100%;">
                            </div>
                        </div>
                        <div class="row" style="display:flex; justify-content:space-between;"> <!-- Dos columnas -->
                            <div class="col-md-6 second-column" style="text-align:initial;">
                                <div class="col-md-12 space-bottom">
                                    <label class="title-item-consult">Empresa de cobro</label>
                                    <input type="text" id="nCobroEmpresa" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-md-12 space-bottom">
                                    <label class="title-item-consult">Contacto de cobro</label>
                                    <input type="text" id="nCobroContacto" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-md-12 space-bottom">
                                    <label class="title-item-consult">Horario de cobro</label>
                                    <input type="text" id="nCobroHorario" class="form-control input-sm" style="width:100%;">
                                </div>
                                <div class="col-md-12 space-bottom">
                                    <label class="title-item-consult">Observaciones de cobro</label>
                                    <input type="text" id="nCobroObservacion" class="form-control input-sm" style="width:100%;">
                                </div>
                            </div>
                            <div class="col-md-5 second-column" style="text-align:initial;">
                                <div class="col-md-12 segment-result" style="overflow:auto; padding:0px; height: 260px;">
                                    <table class="table table-datoscliente" style="margin-bottom:0px;">
                                        <thead style="position: sticky;top: 0px;">
                                            <tr style="background: #266093; font-size: 13px;">
                                                <th scope="col">Compañía</th>
                                                <th scope="col">Clave Cliente</th>
                                                <th scope="col">Fecha de Ingreso</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list-table-datoscliente-body">
                                        </tbody>
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
                                        <tbody class="list-table-observaciones1-body" style="font-size:13px; height:140px;">
                                        </tbody>
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
                                        <tbody class="list-table-observaciones2-body" style="font-size:13px; height:140px;">
                                        </tbody>
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
                                        <tbody class="list-table-observaciones3-body" style="font-size:13px; height:140px;">
                                        </tbody>
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
                                    <div class="title-segment-user">
                                        <h5 style="margin:0px;">Bitácora</h5>
                                    </div>
                                </div>
                                <div class="col-md-12" id="Bitacoras" style="background:#f9f9f9; overflow:auto; height:200px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer hidden">
                    <button type="button" class="btn btn-default close-list hidden" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .segment-result {
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .container-table {
        padding-top: 15px;
        padding-bottom: 15px;
        border: 1px solid #d9d8d8;
        border-radius: 5px;
    }
    .container-modal {

    }
    .mg-row {
        margin-left: 1px;
        margin-right: 1px;
    }
    .dr {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .sub-dr {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .mg-title {
        margin-left: 10px;
        margin-right: 10px;
    }
    .pdright {
        padding-right: 0px;
    }
    .pdleft {
        padding-left: 0px;
    }
    .second-column {
        margin-bottom: 10px;
        padding-top: 10px;
        width: 50%;
        border: 1px solid #d9d8d8;
        border-radius: 5px;
    }
    .container-refresh {
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 15px;
        padding-right: 15px;
        border-top: 1px solid #d9d8d8;
        display: flex;
    }
    .container-btn-search {
        width: 400px;
        background: none;
        margin-top: 5px;
        box-shadow: 0px 0px 0px 0px #8370a1;
        border: 0px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        position: relative;
        border-radius: 6px;
        outline: 0;
    } 
    .container-spinner-table-polizas {
        text-align: center;
        /* margin: 10px; */
        color: #266093;
        width: 100%;
        height: 100%;
        align-items: center;
        display: flex;
        justify-content: center;
        flex-direction: column;
        left: 0px;
        position: sticky;
    }
    .container-spinner-content-solicitudes-polizas {
        text-align: center;
        /* margin: 10px; */
        color: #266093;
        width: 100%;
        height: 100%;
        align-items: center;
        display: flex;
        justify-content: center;
        flex-direction: column;

    }
    .container-spinner-content-table-recibos {
        text-align: center;
        /* margin: 10px; */
        color: #266093;
        width: 995%;
        height: 140px;
        align-items: center;
        display: flex;
        justify-content: center;
        flex-direction: column;
        left: 0px;
        position: sticky;
    }
    .col-md-13 {
        width: 700%;
        padding-left: 5px;
    }
    .content-solicitudes-y-polizas {
        width: 100%;
        height: 100%;
        position: absolute;
        margin-top: 50px;
    }
    .space-bottom {
        margin-bottom:20px;
    }
    .text-bold {
        color: darkblue;
        font-weight: bold;
    }
    .title-item-consult {
        color: #303030;
    }
    .title-sub-item-consult {
        color: #303030;
        width: 150px;
        text-align: end;
        padding-right: 10px;
        margin-bottom: 0px;
    }
    .title-segment-user {
        width: 100%;
        height: 31.89px;
        background-color: #266093;
        color: white;
        opacity: .8;
        padding: 8px 15px;
        text-align: left;
    }
    .font-table {
        font-size: 13px;
    }
    .btn-General {
        border-radius: 5px;
        padding: 10px;
        color: white;
        margin-left: 10px;
    }
    .btn-Refresh {
        background: #266093; /* #2a5082 | #51698e -> rgba(081,105,142,1)*/
        border-color: #266093;
    }
    .btn-Refresh-r {
        background: #266093;
        border-color: #266093;
        margin: 0px;
        width: 34px;
        height: 34px;
        font-size: 13px;
    }
    .btn-Refresh:hover {
        background-color: #337ab7;
        border-color: #337ab7;
        color: white;
    }
    .btn-seg-search {
        padding: 0px;
        color: white;
        font-size: 35px;
        background: white;
        border-radius: 100px;
        margin-top: 5px;
        margin-bottom: 5px;
        margin-left: 10px;
        margin-right: 10px;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0px 0px 10px 2px #6a6a6a;
    }
    .btn-resultados {
        color: #9a9240;
        background: white;
    }
    .btn-panel {
        color: #9a9240;
    }
    .btn-borrar {
        background: #cf7725;
    }
    .icon-borrar {
        color: aliceblue;
        border: 1px solid transparent;
        border-radius: 20px;
    }
    .btn-close {
        color: #cf2727;
    }
    .btn-resultados:hover {
        color: #d5c521;
        background: #9a9240;
    }
    .btn-panel:hover {
        color: #d5c521;
        background: #9a9240;
    }
    .btn-borrar:hover {
        background: aliceblue;
    }
    .btn-close:hover {
        color: #e94c4c;
        background: #cbcbcb;
    }
    .btn-buscar:hover {
        color: white;
        border-color: #266093;
        background: #266093;
    }
    .seg-search-Active {
        color: #7955b2;
        background: white;
    }
    /*#ViewPanelResultadosBusqueda > .collapse ul li a:hover {
        background-color: white;
    }*/
    .select-buscar {
        float: left;
        height: 30px;
        cursor: pointer;
    }
    .img-profile {
        width: 100px;
        height: 100px;
        border: 2px solid #266093;
        border-radius: 5px;
        margin: 10px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .icon-profile {
        font-size: 90px;
        color: #303030;
    }

    .input-group-text {
        display: flex;
        align-items: center;
        padding: .375rem .75rem;
        font-size: 2.0rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: .375rem;
    }
    #busqueda .input-group>.form-control {
        position: relative;
        flex: 1 1 auto;
        width: 1%;
        min-width: 0;
    }
    #busqueda .form-control .textSearch {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: .375rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
        margin-left: -1px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .menu-icon-poliza {
        font-size: 15px;
        padding-left: 10px;
        padding-right: 10px;
    }
    .view-search-polizas {
        padding: 0px;
        top: 0px;
        left: 0px;
        width: 400px; /* 300 */
        display: flex;
        position: fixed; /*fixed*/
    }
    .view-window #seccionSearch.active {
        cursor: move;
        user-select: none;
    }
    .swal-modal {
        width: 28%;
    }
    .swal-button--confirm{
        background-color:#337ab7!important;
    }
    .swal-text{
        /*color:#472380 !important;*/
        font-size: 17px;
        text-align: center;
    }
    .seleccionResult {
        background: beige;
    }
    .opaco {
        opacity: .5;
    }
    .btc-client {
        border-bottom: 1px solid darkgray;
        padding: 15px;
    }
    .btc-client-sinR {
        padding: 15px;
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #2a2a2a;
    }
    .align-money {
        text-align: end;
    }
    .align-table-left {
        text-align: left;
    }
</style>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script> -->
<script src="<?=base_url()."assets/js/js_elementoArrastrable.js"?>"></script>
<script type="text/javascript">

    $(document).ready(function() {
        var panel = document.getElementById('search-polizas');
        var resul = document.getElementById('PanelResultadosBusqueda');
        var dtlls = document.getElementById('PanelDetallesBusqueda');
        var btnR = document.getElementsByClassName('btn-resultados');
        var btnD = document.getElementsByClassName('btn-panel');
        var R = document.getElementById('ViewPanelResultadosBusqueda');
        var D = document.getElementById('ViewPanelDetallesBusqueda');
        const filaR = document.getElementsByClassName('filaResultados'); 

        $('#modal-polizas').click(function() {
            //panel.style.transform = "translate(-140%, 10%)";
            $('#search-polizas').toggle(500, "easeInOutQuint");
            if (panel.style.display = "flex") {
                $('#icon-poliza').removeClass('fa-external-link');
                $('#icon-poliza').addClass('fa-compress');
            }
            else if (panel.style.display = "none") {
                $('#icon-poliza').removeClass('fa-compress');
                $('#icon-poliza').addClass('fa-external-link');
            }
        });

        $(btnR).click(function() {
            if ($(resul).hasClass('show')) { //<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                $(R).removeClass('seg-search-Active');
                $('#icon-result').addClass('fa-arrow-circle-down');
                $('#icon-result').removeClass('fa-arrow-circle-up');
            }
            else {
                $(R).addClass('seg-search-Active');
                $('#icon-result').removeClass('fa-arrow-circle-down');
                $('#icon-result').addClass('fa-arrow-circle-up');
            }
        });

        $(btnD).click(function() {
            if($(dtlls).hasClass('show')) { // <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                $(D).removeClass('seg-search-Active');
                $('#icon-form').addClass('fa-arrow-circle-right');
                $('#icon-form').removeClass('fa-arrow-circle-left');
            }
            else {
                $(D).addClass('seg-search-Active');
                $('#icon-form').removeClass('fa-arrow-circle-right');
                $('#icon-form').addClass('fa-arrow-circle-left');
            }
        });

        $('#LimpiarBusqueda').click(function() {
            $('#text-search').val('');
        });

        $('#AnclarVentana').click(function() {
            if (panel.style.position = "fixed") {
                panel.style.position = "absolute";
            }
            else if (panel.style.position = "absolute"){
                panel.style.position = "fixed";
            }
        })

        $('#NoViewPanelResultadosBusqueda').click(function() {
            panel.style.display = "none";
            $(resul).removeClass('show');
            $(dtlls).removeClass('show');
            $('#icon-poliza').addClass('fa-external-link');
            $('#icon-poliza').removeClass('fa-compress');
            $(R).removeClass('seg-search-Active');
            $(D).removeClass('seg-search-Active');
            $('#icon-result').addClass('fa-arrow-circle-down');
            $('#icon-result').removeClass('fa-arrow-circle-up');
            $('#icon-form').addClass('fa-arrow-circle-right');
            $('#icon-form').removeClass('fa-arrow-circle-left');

        });

        $('#ClosePanelDetallesBusqueda').click(function() {
            panel.style.display = "none";
            $(resul).removeClass('show');
            $(dtlls).removeClass('show');
            $('#icon-poliza').addClass('fa-external-link');
            $('#icon-poliza').removeClass('fa-compress');
                $(R).removeClass('seg-search-Active');
                $(D).removeClass('seg-search-Active');
        });

      //Mover Panel
        const container = document.querySelector(".view-search-polizas"),
        header = container.querySelector("#seccionSearch");

        function onDrag({movementX, movementY}){
            let getStyle = window.getComputedStyle(container);
            let leftVal = parseInt(getStyle.left);
            let topVal = parseInt(getStyle.top);
            container.style.left = `${leftVal + movementX}px`;
            container.style.top = `${topVal + movementY}px`;
        }

        header.addEventListener("mousedown", ()=>{
            header.classList.add("active");
            header.addEventListener("mousemove", onDrag);
        });

        document.addEventListener("mouseup", ()=>{
            header.classList.remove("active");
            header.removeEventListener("mousemove", onDrag);
        });

      //Mover Panel Método 2
        //var draggableElement = elementoArrastrable($(".view-search-polizas")[0]);

    });

    function BuscarDatos() { //Buscar por nombre, id y documento
        var tipo = document.getElementById('SelectSearch').value;
        var dato = document.getElementById('text-search');
        var info = $(dato).val();
        const baseUrl = $("#base_url").data("base-url");
        console.log(info,tipo);
        if (tipo != 0 && info != 0) {
            $.ajax({
                type: "GET",
                url: `${baseUrl}directorio/busquedaPolizas`,
                data: {
                    search: info,
                    type: tipo
                },
                beforeSend: (load) => {
                    $('#view-table-polizas').html(`
                        <div class="container-spinner-table-polizas">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <p style="font-size:18px;">Cargando...</p>
                        </div>
                    `);
                },
                success: (data) => {
                    const r = JSON.parse(data);
                    console.log(r);
                    //console.log(data);

                    $('#view-table-polizas').html("");
                    $(".list-table-resultados-body").html("");
                    var thead = ``;
                    var trtd = ``;
                    
                    if (tipo == 2 || tipo == 1) {

                        thead += `
                            <table class="table table-resultados" id="TableResultadosBusqueda" style="margin-bottom:0px;">
                                <thead style="position:sticky; top:0px;">
                                    <tr style="background: #266093; font-size: 13px;">
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Documento</th>
                                        <th scope="col">Inciso</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Solicitud</th>
                                    </tr>
                                </thead>
                                <tbody class="list-table-resultados-body"></tbody>
                            </table>`;

                        for(var a in r) {
                            const NombreCompleto = valor(r[a].NombreCompleto);
                            const TipoDocto_TXT = valor(r[a].TipoDocto_TXT);
                            const Documento = valor(r[a].Documento);
                            const Inciso =  valor(r[a].Inciso);
                            const Solicitud = valor(r[a].Solicitud);
                            var item = r.length;
                            $('#CantidadResultados').text(item);

                            trtd += `
                                <tr class="filaResultados" data-id="${r[a].IDDocto}" data-clave="${r[a].ClaveBit}" data-name="${r[a].Documento}" data-type="1" onclick="ClickResultado(this)" style="font-size:13px;">
                                    <td>${TipoDocto_TXT}</td>
                                    <td>${Documento}</td>
                                    <td>${Inciso}</td>
                                    <td>${NombreCompleto}</td>
                                    <td>${Solicitud}</td>
                                </tr>`;
                        }
                    }
                    else if (tipo == 4) {

                        thead += `
                            <table class="table table-resultados" id="TableResultadosBusqueda" style="margin-bottom:0px;">
                                <thead style="position:sticky; top:0px;">
                                    <tr style="background: #266093; font-size: 13px;">
                                        <th scope="col">Nombre Completo</th>
                                        <th scope="col">Grupo</th>
                                    </tr>
                                </thead>
                                <tbody class="list-table-resultados-body"></tbody>
                            </table>`;

                        for(var b in r) {
                            const NombreCompleto = valor(r[b].NombreCompleto);         
                            const Grupo = valor(r[b].Grupo);

                            trtd += `
                                <tr class="filaResultados" data-id="${r[b].IDCli}" data-clave="${r[b].ClaveBit}" data-name="${r[b].NombreCompleto}" data-type="4" onclick="ClickResultado(this)" style="font-size:13px;">
                                    <td>${NombreCompleto}</td>
                                    <td>${Grupo}</td>
                            </tr>`;
                        }
                    }
                    else if (tipo == 12) {

                        thead += `
                            <table class="table table-resultados" id="TableResultadosBusqueda" style="margin-bottom:0px;">
                                <thead style="position:sticky; top:0px;">
                                    <tr style="background: #266093; font-size: 13px;">
                                        <th scope="col">Documento</th>
                                        <th scope="col">Inciso</th>
                                        <th scope="col">Serie</th>
                                        <th scope="col">Cliente</th>
                                    </tr>
                                </thead>
                                <tbody class="list-table-resultados-body"></tbody>
                            </table>`;

                        for(var c in r) {
                            const Documento = valor(r[c].Documento);         
                            const Inciso = valor(r[c].Inciso);
                            const Serie = valor(r[c].Serie);         
                            const Cliente = valor(r[c].Serie); //Pendiente
                            trtd += `
                                <tr class="filaResultados" data-id="${r[c].IDDocto}" data-clave="${Documento}" data-name="${r[c].Serie}" data-type="12" onclick="ClickResultado(this)" style="font-size:13px;">
                                    <td>${Documento}</td>
                                    <td>${Inciso}</td>
                                    <td>${Serie}</td>
                                    <td id="ClaveBit"></td>
                            </tr>`;
                        }
                    }

                    $('#view-table-polizas').html(thead);
                    $(".list-table-resultados-body").html(trtd);
                    /*$('#TableResultadosBusqueda').DataTable({
                        language: {
                            url: `${baseUrl}assets/js/espanol.json`
                        },
                        dom: '<"toolbar toolbar-table-poliza">rtip ',
                        initComplete: function(row) {
                            var tmp = `
                            <div></div>`
                            $('div.toolbar-table-poliza').html(tmp);
                        },
                        columns:[
                        {
                            sortable: true,
                            orderable: true,
                        },
                        {
                            sortable: true,
                            orderable: true,
                        },
                        {
                            sortable: true,
                            orderable: true,
                        },
                        {
                            sortable: true,
                            orderable: true,
                        },
                        {
                            sortable: true,
                            orderable: true,
                        }],
                        order: [['0', 'desc']],
                    });*/
                },
                error: (error) => {
                    swal("¡Vaya!", "Hay problemas al buscar la información.", "error");
                }
            })
        }
        else if (tipo == null) {
            swal("¡Espera!", "Debes seleccionar el tipo de búsqueda.", "warning");
        }
        //Ejemplo documento: 93586R01 | 13514K03
        //Ejemplo nombre: huchim medina
        //Ejemplo serie: 3N1CK3CS9FL235369 -> 0880271801
    }

    
    function ClickResultado(dato) {
        const id = $(dato).data('id');
        const bit = $(dato).data('clave');
        const tipo = $(dato).data('type');
        const doc = $(dato).data('name');
        const baseUrl = $("#base_url").data("base-url");
        console.log(id);
        if(document.getElementsByClassName('seleccionResult')[0]){
            document.getElementsByClassName('seleccionResult')[0].classList.remove('seleccionResult');
        }
        dato.classList.add('seleccionResult');

        $('#SelectDocument').text('(' + doc + ')');

        $.ajax({
            type: "GET",
            url: `${baseUrl}directorio/ResultadoPolizas`,
            data: {
                id: id,
                cb: bit,
                tp: tipo,
                dc: doc
            },
            beforeSend: (load) => {
                $('.content-solicitudes-y-polizas').html(`
                    <div class="container-spinner-content-solicitudes-polizas">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p style="font-size:18px;">Cargando...</p>
                    </div>
                `);

                $('#Content-Info-Busqueda').addClass('opaco');
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);

                const doc = r['documentos']; //Una sola fila de dato
                const sre = r['serie'];
                //console.log(doc,btc);

                $('#Content-Info-Busqueda').removeClass('opaco');
                $('.content-solicitudes-y-polizas').html("");
                $(".list-table-recibos-body").html("");
                $(".list-table-totales-body").html("");
                $(".list-table-pago-body").html("");

                var trtd1 = ``;
                var trtd2 = ``;
                var trtd3 = ``;

                //Cambio de formato monetario
                const options = { style: 'currency', currency: 'USD' };
                const numberFormat = new Intl.NumberFormat('en-US', options);

                //Cambio de valor
                const TipoDocto_TXT = valor(doc.TipoDocto_TXT);
                const Status_TXT = valor(doc.Status_TXT);
                const Documento = valor(doc.Documento);
                const Inciso = valor(doc.Inciso);
                const DAnterior = valor(doc.DAnterior);
                const DPosterior = valor(doc.DPosterior);
                const NombreCompleto = valor(doc.NombreCompleto);
                const RFC = valor(doc.RFC);
                const Grupo = valor(doc.Grupo);
                const SubGrupo = valor(doc.SubGrupo);
                const SSGrupo = valor(doc.SSGrupo);
                const Calle = valor(doc.Calle);
                const Colonia = direccionClient(doc.Colonia);
                const Poblacion = direccionClient(doc.Poblacion);
                const Ciudad = direccionClient(doc.Ciudad);
                const Pais = direccionClient(doc.Pais);
                const CAgente =  "[" + valor(doc.CAgente) + "] ";
                const SRamoNombre = valor(doc.SRamoNombre);
                const AgenteNombre = valor(doc.AgenteNombre);
                const EjecutNombre = valor(doc.EjecutNombre);
                const FPago = valor(doc.FPago);
                const VendNombre = valor(doc.VendNombre);
                const Moneda = valor(doc.Moneda);
                const Renovacion = valor(doc.Renovacion);
                const Concepto = valor(doc.Concepto);
                const Referencia1 = valor(doc.Referencia1);
                const Referencia2 = valor(doc.Referencia2);
                const Referencia3 = valor(doc.Referencia3);
                const Referencia4 = valor(doc.Referencia4);
                const StatusUser_TXT = valor(doc.StatusUser_TXT);
                const GerenciaNombre = valor(doc.GerenciaNombre);
                const DespNombre = valor(doc.DespNombre);
                const CCobro_TXT = valor(doc.CCobro_TXT);
                const Endoso = valor(doc.Endoso);

                //Cambio de formato fechas
                var Captura = new Date(doc.FCaptura);
                const FDesde = fecha(doc.FDesde);
                const FHasta = fecha(doc.FHasta); //Problema con 13514K03
                const FAntig = fecha(doc.FAntiguedad);
                const FCaptr = fecha(doc.FCaptura) + ", " + Captura.toLocaleTimeString('en-US');
                const FEmisn = fecha(doc.FEmision);
                
                if (tipo == 1) {
                    $('#VentPolizas').removeClass('hidden');
                    $('#VentClientes').addClass('hidden');
                    $('#SegBitacoras').removeClass('hidden');
                    $('#TituloDetalles').text("Solicitudes y pólizas");
                    $('#Parte1-Series').addClass('hidden');
                    $('#Campo1-Cambio').text("Referencia 4");
                    $('#Parte3-Series').addClass('hidden');
                    $('#Parte4-Series').addClass('hidden');
                    $('#Parte1-Polizas').removeClass('hidden');
                    $('#Parte2-Polizas').removeClass('hidden');

                    const PPag = valor(doc.PPag);
                    const PPend = valor(doc.PPend);

                    TablaRecibos(doc.PrimaNeta,PPend);
                    PanelBitacoras(bit);

                    //Cambio de formato string
                    //var DPosterior = JSON.stringify(doc.DPosterior);

                    //Llenado de información
                    $('#TipoDocumento').val(TipoDocto_TXT);
                    //$('#Poliza').val(doc.); //Pendiente
                    $('#Estatus').val(Status_TXT);
                    //$('#Folio').val(doc.FolioNo); //Pendiente FolioDocto solo en Recibos
                    $('#Documento').val(Documento);
                    $('#Inciso').val(Inciso); //Pendiente
                    $('#Anterior').val(DAnterior);
                    $('#Posterior').val(DPosterior);
                    $('#Cliente').val(NombreCompleto);
                    $('#RFC').val(RFC);
                    $('#Grupo').val(Grupo);
                    $('#SubGrupo').val(SubGrupo);
                    $('#Sub-SubGrupo').val(SSGrupo);
                    //$('#Expediente').val(doc.); //Pendiente
                    $('#Direccion').val(Calle + Colonia + Poblacion + Ciudad + Pais);
                    $('#SubRamo').val(SRamoNombre);
                    $('#Agente').val(CAgente + AgenteNombre);
                    $('#Compania').val(AgenteNombre);
                    $('#Ejecutivo').val(EjecutNombre);
                    $('#Pago').val(FPago);
                    $('#Vendedor').val(VendNombre);
                    $('#Moneda').val(Moneda);
                    $('#Desde').val(FDesde);
                    $('#Hasta').val(FHasta);
                    $('#Renovacion').val(Renovacion);
                    $('#Antiguedad').val(FAntig);
                    $('#Captura').val(FCaptr);
                    //$('#Envio').val(doc.); //Pendiente
                    //$('#Recepcion').val(doc.); //Pendiente
                    $('#Emision').val(FEmisn);
                    $('#Concepto').val(Concepto);
                    $('#Referencia1').val(Referencia1); //Pendiente
                    //$('#Cobro').val(doc.); //Pendiente
                    $('#Referencia2').val(Referencia2); //Pendiente
                    $('#EstatusUsuario').val(StatusUser_TXT);
                    $('#Referencia3').val(Referencia3); //Pendiente
                    //$('#ClasDoc').val(doc.); //Pendiente
                    $('#Referencia4').val(Referencia4); //Pendiente
                    $('#Gerencia').val(GerenciaNombre);
                    $('#Despacho').val(DespNombre);
                    //$('#TipoCondCobro').val(doc.); //Pendiente
                    $('#CondCobro').val(CCobro_TXT);
                    $('#PrimaNeta').val(numberFormat.format(doc.PrimaNeta));
                    $('#Descuento').val(numberFormat.format(doc.Descuento));
                    $('#ExtraPrima').val(numberFormat.format(doc.ExtraPrima));
                    $('#Recargos').val(numberFormat.format(doc.Recargos));
                    $('#Derechos').val(numberFormat.format(doc.Derechos));
                    $('#SubTotal').val(numberFormat.format(doc.STotal));
                    $('#IVA').val(numberFormat.format(doc.Impuesto1));
                    $('#PrimaPend').val(PPend);
                    $('#PrimaTotal').val(numberFormat.format(doc.PrimaTotal));
                    $('#Endoso').val(Endoso); //Pendiente por el tipo de formato
                    $('#TipoPago').val(doc.TipoPago);
                    //$('#TipoVenta').val(doc.); //Pendiente

                    //Ejemplo: 93586R01 | 13514K03

                    trtd2 +=  `
                        <tr style="font-size:13px;">
                            <td class="align-table-left">Total del documento</td>
                            <td class="align-money">${numberFormat.format(doc.PrimaNeta)}</td>
                            <td class="align-money">${numberFormat.format(doc.PrimaTotal)}</td>
                        </tr>
                        <tr style="font-size:13px;">
                            <td class="align-table-left">Número de pagos</td>
                            <td class="align-money" id="NumPagos"></td>
                            <td class="align-money"></td>
                        </tr>
                        <tr style="font-size:13px;">
                            <td class="align-table-left">Total pagado</td>
                            <td class="align-money" id="SumaRecibos"></td> <!-- Suma de las PrimaNeta de los recibos -->
                            <td class="align-money">${numberFormat.format(PPag)}</td>
                        </tr>
                        <tr style="font-size:13px;">
                            <td class="align-table-left">Total pendiente</td>
                            <td class="align-money" id="TotalNetaPendiente"></td> <!-- id="TotalNetaPendiente" -->
                            <td class="align-money">${numberFormat.format(PPend)}</td>
                        </tr>`;

                    trtd3 += `
                        <tr name="ListaOpcionesPago" data-id="" style="font-size:13px;">
                            <td></td> <!-- Opcion de pago -->
                            <td></td> <!-- Tarjeta -->
                            <td></td> <!-- Campo a solicitar -->
                            <td></td> <!-- Identificador de descuento -->
                            <td></td> <!-- Descripción -->
                        </tr>`;
                }
                else if (tipo == 4) {
                    $('#VentPolizas').addClass('hidden');
                    $('#VentClientes').removeClass('hidden');
                    $('#SegBitacoras').removeClass('hidden');
                    $('#TituloDetalles').text("Clientes");

                    PanelBitacoras(bit);

                    //Cambio de valor
                    const TipoEnt_TXT = valor(doc.TipoEnt_TXT);
                    const Idioma_TXT = valor(doc.Idioma_TXT);
                    const Clasifica_TXT = valor(doc.Clasifica_TXT);
                    const Email1 = valor(doc.Email1);
                    const ClaveTKM = valor(doc.ClaveTKM);
                    const TIngreso_TXT = valor(doc.TIngreso_TXT);
                    const FEntero_TXT = valor(doc.FEntero_TXT);
                    const GAfinidad_TXT = valor(doc.GAfinidad_TXT);
                    const Telefono1 = valor(doc.Telefono1);

                    $('#TipoEntidad').val(TipoEnt_TXT);
                    $('#nIdioma').val(Idioma_TXT);
                    $('#nEstatus').val(Status_TXT);
                    $('#nCliente').val(NombreCompleto);
                    //$('#nNumeroEmpleado').val(); //Pendiente
                    //$('#nRFC').val(); //Pendiente
                    //$('#nAlias').val(); //Pendiente
                    $('#nClasificacion').val(Clasifica_TXT);
                    //$('#nExpediente').val(); //Pendiente
                    $('#nGrupo').val(Grupo);
                    //$('#nSubGrupo').val(); //Pendiente
                    //$('#nSSGrupo').val(); //Pendiente
                    //$('#nCalidadCliente').val(); //Pendiente
                    $('#nEjecutivoCuenta').val(EjecutNombre);
                    //$('#nEjecutivoCobranza').val(); //Pendiente
                    //$('#nEjecutivoReclamacion').val(); //Pendiente
                    $('#nCorreo1').val(Email1);
                    //$('#nCorreo2').val(); //Pendiente
                    //$('#nLigaInternet').val(); //Pendiente
                    $('#nClaveTeleMark').val(ClaveTKM);
                    $('#nModoIngreso').val(TIngreso_TXT);
                    $('#nComoSeEntero').val(FEntero_TXT);
                    $('#nGrupoAfinidad').val(GAfinidad_TXT);
                    //$('#nCentroCosto').val(); //Pendiente
                    $('#nCelular').val(Telefono1);
                    //$('#nTelefono2').val();
                    //$('#nTelefono3').val();
                    //$('#nTelefono4').val();
                    //$('#nCobroEmpresa').val();
                    //$('#nCobroContacto').val();
                    //$('#nCobroHorario').val();
                    //$('#nCobroObservacion').val();
                }
                else if (tipo == 12) {
                    $('#VentPolizas').removeClass('hidden');
                    $('#VentClientes').addClass('hidden');
                    $('#SegBitacoras').removeClass('hidden');
                    $('#TituloDetalles').text("Serie en vehículos");
                    $('#Parte1-Series').removeClass('hidden');
                    $('#Campo1-Cambio').text("Oficina");
                    $('#Parte3-Series').removeClass('hidden');
                    $('#Parte4-Series').removeClass('hidden');
                    $('#Parte1-Polizas').addClass('hidden');
                    $('#Parte2-Polizas').addClass('hidden');

                    TablaRecibos(doc.PrimaNeta);
                    PanelBitacoras(doc.ClaveBit);

                    //Debe llamar los datos de la serie, del documento, de la bitácora
                    //Cambio de valor
                    const Oficina = valor(doc.OfnaNombre);

                    $('#TipoDocumento').val(TipoDocto_TXT);
                    //$('#sPoliza').val(doc.); //Pendiente
                    $('#Estatus').val(Status_TXT);
                    //$('#sFolio').val(doc.FolioNo); //Pendiente FolioDocto solo en Recibos
                    $('#Documento').val(Documento);
                    $('#Inciso').val(Inciso); //Pendiente
                    $('#Anterior').val(DAnterior);
                    $('#Posterior').val(DPosterior);
                    $('#Cliente').val(NombreCompleto);
                    $('#RFC').val(RFC);
                    $('#Grupo').val(Grupo);
                    $('#SubGrupo').val(SubGrupo);
                    $('#SSubGrupo').val(SSGrupo);
                    //$('#sExpediente').val(doc.); //Pendiente
                    $('#Direccion').val(Calle + Colonia + Poblacion + Ciudad + Pais);
                    $('#SubRamo').val(SRamoNombre);
                    $('#Agente').val(CAgente + AgenteNombre);
                    $('#Compania').val(AgenteNombre);
                    $('#Ejecutivo').val(EjecutNombre);
                    $('#Pago').val(FPago);
                    $('#Vendedor').val(VendNombre);
                    $('#Moneda').val(Moneda);
                    $('#Desde').val(FDesde);
                    $('#Hasta').val(FHasta);
                    $('#Renovacion').val(Renovacion);
                    $('#Antiguedad').val(FAntig);
                    $('#Captura').val(FCaptr);
                    //$('#sEnvio').val(doc.); //Pendiente
                    //$('#sRecepcion').val(doc.); //Pendiente
                    $('#sEmision').val(FEmisn);
                    $('#sConcepto').val(Concepto);
                    $('#sMarca').val(sre.Marca);
                    $('#sTipo').val(sre.Tipo);
                    $('#sTransmision').val(sre.Transmision);
                    $('#sPuertas').val(sre.Pertas);
                    $('#sModelo').val(sre.Modelo);
                    $('#sClave').val(sre.Clave);
                    $('#sPlacas').val();
                    $('#sSerie').val(sre.Serie);
                    $('#sMotor').val(sre.Motor);
                    $('#sRepuve').val();
                    $('#sCiaLocal').val();
                    $('#sSerieLocal').val();
                    $('#sPlan').val();
                    $('#sAseguradoPC').val();
                    $('#Referencia1').val(Referencia1); //Pendiente
                    //$('#sCobro').val(doc.); //Pendiente
                    $('#Referencia2').val(Referencia2); //Pendiente
                    $('#EstatusUsuario').val(StatusUser_TXT);
                    $('#Referencia3').val(Referencia3); //Pendiente
                    //$('#sClasDoc').val(doc.); //Pendiente
                    $('#Referencia4').val(Oficina); //Pendiente
                    $('#Gerencia').val(GerenciaNombre);
                    $('#Despacho').val(DespNombre);
                    //$('#sLineaNegocio').val(doc.); //Pendiente
                    $('#CondCobro').val(CCobro_TXT);
                    //$('#TsipoCondCobro').val(doc.); //Pendiente
                    $('#PrimeraNeta').val(numberFormat.format(doc.PrimaNeta));
                    $('#Descuento').val(numberFormat.format(doc.Descuento));
                    $('#Recargos').val(numberFormat.format(doc.Recargos));
                    $('#Derechos').val(numberFormat.format(doc.Derechos));
                    $('#SubTotal').val(numberFormat.format(doc.STotal));
                    $('#IVA').val(numberFormat.format(doc.Impuesto1));
                    $('#sAjuste').val(numberFormat.format(doc.ExtraPrima));
                    $('#PrimaTotal').val(numberFormat.format(doc.PrimaTotal));
                    $('#Endoso').val(Endoso); //Pendiente por el tipo de formato
                    //$('#sTipoPago').val(doc.); //Pendiente
                    //$('#sTipoVenta').val(doc.); //Pendiente

                }

                $(".list-table-totales-body").html(trtd2);
                $(".list-table-pago-body").html(trtd3); 
            },
            error: (error) => {
                console.log("Hay problemas al buscar la información.");
            }
        })
    }

    function TablaRecibos(cantidad,pago) {
        const id = document.getElementsByClassName('seleccionResult')[0].dataset.id;
        const PrimaNetaTotal = cantidad;
        const PrimaPendiente = pago;
        const baseUrl = $("#base_url").data("base-url");
        console.log(id);

        $.ajax({
            type: "GET",
            url: `${baseUrl}directorio/TableRecibos`,
            data: {
                id: id
            },
            beforeSend: (load) => {
                $('.list-table-recibos-body').html(`
                    <div class="container-spinner-content-table-recibos">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);

                $('#TablaTotales').addClass('opaco');
            },
            success: (data) => {
                const rcb = JSON.parse(data);
                console.log(rcb);
                //console.log(doc,btc,rcb);
                $('#TablaTotales').removeClass('opaco');
                $(".list-table-recibos-body").html("");
                var PrimaNetaRecibo = 0;
                var trtd1 = ``;
                var NumPagos = rcb.length;
                $('#NumPagos').text(NumPagos);
                console.log(PrimaNetaTotal);
                //Cambio de formato monetario
                const options = { style: 'currency', currency: 'USD' };
                const numberFormat = new Intl.NumberFormat('en-US', options);
           
                for (var b in rcb) {
                    //Cambio de valor
                    const bInciso = valor(rcb[b].Inciso);
                    const bEndoso = valor(rcb[b].Endoso);

                    //Formato Fechas
                    const bDesde = fecha(rcb[b].FDesde);
                    const bHasta = fecha(rcb[b].FHasta);
                    const bLimite = fecha(rcb[b].FLimPago);
                    const bEstatus = fecha(rcb[b].FStatus);
                    const bPago = fecha(rcb[b].FDoctoPago);
                    //Problema con 13514K03 2023-08-01T00:00:00-05:00 
                    //Zona horaria hace confilcto
                    //Cambiar zona horaria: GMT-0600 (hora estándar central)
                    //Debe mantener la zona horaria original
                    //Todas las fecha se cambian al estándar según detecte en la maquina

                    var Honorario = "";
                    var Comision = "";
                    var PrimaTotalPendiente = 0;
                    const Com00 = rcb[b].Comision0;
                    const Com01 = rcb[b].Comision1;
                    const Com02 = rcb[b].Comision2;
                    const Com03 = rcb[b].Comision3;
                    const Com04 = rcb[b].Comision4;
                    const Com05 = rcb[b].Comision5;
                    const Com06 = rcb[b].Comision6;
                    const Com07 = rcb[b].Comision7;
                    const Com08 = rcb[b].Comision8;
                    const Com09 = rcb[b].Comision9;
                    const Com10 = rcb[b].Comision10;
                    const Com11 = rcb[b].Comision11;
                    const Com12 = rcb[b].Comision12;
                    const Com13 = rcb[b].Comision13;
                    const Com14 = rcb[b].Comision14;
                    const Com15 = rcb[b].Comision15;
                    const Com16 = rcb[b].Comision16;
                    const Importe = Number(Com00)+Number(Com01)+Number(Com02)+Number(Com03)+Number(Com04)+Number(Com05)+Number(Com06)+Number(Com07)+Number(Com08)+Number(Com09)+Number(Com10)+Number(Com11)+Number(Com12)+Number(Com13)+Number(Com14)+Number(Com15)+Number(Com16);

                    if (rcb[b].Status_TXT == "Liquidado" || rcb[b].Status_TXT == "Pagado") {
                        Honorario = "Pagado";
                        Comision = "Conciliada"; //Pendiente

                        PrimaNetaRecibo += parseFloat(rcb[b].PrimaNeta);

                        if (PrimaPendiente == 0) {
                            PrimaTotalPendiente = 0;
                            $('#TotalNetaPendiente').text(numberFormat.format(PrimaTotalPendiente));
                        }
                        else {
                            PrimaTotalPendiente = PrimaNetaTotal - PrimaNetaRecibo;
                            $('#TotalNetaPendiente').text(numberFormat.format(PrimaTotalPendiente));
                        }

                        $('#SumaRecibos').text(numberFormat.format(PrimaNetaRecibo));
                    }
                    else if (rcb[b].Status_TXT == "Pendiente" || rcb[b].Status_TXT == "Cancelado") {
                        Honorario = "No Pagado";
                        Comision = "No Conciliada"; //Pendiente
                    }
                    else {
                        Comision = "";
                    }

                    trtd1 += `
                        <tr name="ListaRecibos" data-id="${rcb[b].IDRecibo}" style="font-size:13px;">
                            <td>${rcb[b].Status_TXT}</td>
                            <td>${Comision}</td>
                            <td>${rcb[b].Documento}</td>
                            <td>${bInciso}</td>
                            <td>${bEndoso}</td>
                            <td>${rcb[b].Periodo}</td>
                            <td>${rcb[b].Serie}</td>
                            <td>${bDesde}</td>
                            <td>${bHasta}</td>
                            <td>${bLimite}</td>
                            <td>${bEstatus}</td>
                            <td>${numberFormat.format(rcb[b].PrimaNeta)}</td>
                            <td>${numberFormat.format(rcb[b].PrimaTotal)}</td>
                            <td>${numberFormat.format(rcb[b].PrimaEnviada)}</td>
                            <td>${numberFormat.format(rcb[b].PrimaPend)}</td>
                            <td>${numberFormat.format(rcb[b].PrimaPag)}</td>
                            <td>${Honorario}</td>
                            <td>Folio Liquidación</td>
                            <td>${numberFormat.format(Importe)}</td>
                            <td>${bPago}</td>
                        </tr>`;
                }
                $(".list-table-recibos-body").html(trtd1);
            },
            error: (error) => {
                console.log("Hay problemas al buscar la información.");
            }
        })
    }

    function PanelBitacoras(dato) {
        const clave = dato;
        const baseUrl = $("#base_url").data("base-url");

        $.ajax({
            type: "GET",
            url: `${baseUrl}directorio/InformacionBitacoras`,
            data: {
                cl: dato
            },
            success: (data) => {
                const btc = JSON.parse(data);
                console.log(btc);
                //console.log(doc,btc,rcb);
                $('#Bitacoras').html("");
                var bt = ``;
                var dias = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");

                if (btc != 0) {
                    for (c in btc) {
                        //Valor
                        const UserGen = valor(btc[c].UserGen);
                        const Procedencia = valor(btc[c].Procedencia);
                        const Comentario = valor(btc[c].Comentario);

                        //Fecha
                        var FchBit = new Date(btc[c].FechaHora);
                        var FBitac = dias[FchBit.getDay()] + " " + fecha(btc[c].FechaHora) + " " + FchBit.toLocaleTimeString('en-US');

                        bt += `
                            <div class="col-md-12 btc-client">
                                <div class="col-md-3 sub-dr" style="flex-direction:column;">
                                    <div class="img-profile">
                                        <i class="fa fa-user icon-profile" style="font-size:90px
                                        ;"></i>
                                    </div>
                                    <span class="badge" id="TagUser" style="background:#9a9240;">${UserGen}</span>
                                </div>
                                <div class="col-md-9 sub-dr font-table" style="flex-direction:column;">
                                    <div class="col-md-12 sub-dr" style="padding-top:5px;">
                                        <div class="col-md-7">
                                            <h5 class="title-item-consult">
                                                <strong id="FechaOperacion">${FBitac}</strong>
                                            </h5>
                                        </div>
                                        <div class="col-md-7">
                                            <h5 class="title-item-consult" style="margin-left:6px;">
                                                <strong id="Procedencia">${Procedencia}</strong>
                                            </h5>
                                        </div>
                                        <div class="col-md-2 hidden">
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
            }
        })
    }

    function valor(dato) {
        if (dato == undefined) {
            dato = "";
        }
        else if (dato == "[object Object]") {
            dato = "";
        }
        else {
            dato = dato;
        }
        return dato;
    }

    function fecha(dato) {
        var meses = new Array ("Enero","Feb","Mar","Abr","May","Jun","Jul","Ago","Sept","Oct","Nov","Dic");
        var dias = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
        var fecha = "";

        if (dato == undefined) {
            fecha = "";
        }
        else {
            date = new Date(dato);
            fecha = date.getDate() + "/" + meses[date.getMonth()] + "/" + date.getFullYear();
        }
        return fecha;
    }

    function direccionClient(dato) {
        if (dato == undefined) {
            dato = "";
        }
        else if (dato == "[object Object]") {
            dato = "";
        }
        else {
            dato = ", " + dato;
        }
        return dato;
    }

</script>