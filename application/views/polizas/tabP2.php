<div class="col-md-12 bg-table tab-pane" id="PanelP2" style="padding: 0px; margin-bottom: 0px;">
    <!-- Sección de Detalles del Endoso -->
    <div class="col-md-12 content-detalles">
        <div class="segment-p-detalles">
            <div class="modal-header segment-header-detalles" id="Cabecera">
                <h4 class="title-result" id="TituloDetalles">Detalles del Endoso</h4>
                <h5 class="title-sub-result" id="SelectEndoso"></h5>
            </div>
            <!-- <div class="content-solicitudes-y-polizas"></div> -->
            <div class="modal-body segment-body-detalles">
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
                                Vigente
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

    function TablaEndosos(documento) {
        $.ajax({
            type: "GET",
            url: `${baseUrl}/InformacionEndosos`,
            data: {
                dc: documento
            },
            beforeSend: (load) => {
            },
            success: (data) => {
                const end = JSON.parse(data);
                console.log(end);

                //$('#view-table-endosos').html("");
                //$('.list-table-doc-endosos-body').html("");
                var thead = ``;
                var trtd = ``;
                var select1 = ``;
                var select2 = ``;
                var select3 = ``;
                var select4 = ``;
                var select5 = ``;

                thead += `
                    <table class="table" id="TableResultadosEndosos" style="margin-bottom:0px;">
                        <thead style="position:sticky; top:0px;">
                            <tr style="background: #266093;">
                                <th scope="col">Documento</th>
                                <th scope="col">Inciso</th>
                                <th scope="col">Endoso</th>
                                <th scope="col">Tipo Documento</th>
                                <th scope="col">Tipo Endoso</th>
                                <th scope="col">Fecha Desde</th>
                                <th scope="col">Fecha Hasta</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Grupo</th>
                                <th scope="col">Subgrupo</th>
                            </tr>
                        </thead>
                        <tbody class="list-table-doc-endosos-body"></tbody>
                    </table>`;

                for(var e in end) {
                    const Endoso = valor(end[e].Endoso);
                    const FEmision = valor(end[e].FEmision);

                    if (Endoso != 0 && FEmision != 0) {
                        const Documento = valor(end[e].Documento);
                        const Inciso = valor(end[e].Inciso);
                        const Tipo = valor(end[e].Tipo_TXT);
                        const Cliente = valor(end[e].NombreCompleto);
                        const Grupo = valor(end[e].Grupo);
                        const SubGrupo = valor(end[e].SubGrupo);

                        const Desde = fecha(end[e].FDesde);
                        const HastaPoliza = fecha(end[e].FHastaPoliza);

                        trtd += `
                            <tr class="selectEndoso" data-id="${end[e].IDEnd}" data-name="${end[e].Endoso}" data-type="12">
                                <td>${Documento}</td>
                                <td>${Inciso}</td>
                                <td>${Endoso}</td>
                                <td>Endoso</td>
                                <td>${Tipo}</td>
                                <td>${Desde}</td>
                                <td>${HastaPoliza}</td>
                                <td>${Cliente}</td>
                                <td>${Grupo}</td>
                                <td>${SubGrupo}</td>
                            </tr>`;
                    }
                }
                $('#view-table-endosos').html(thead);
                $('.list-table-doc-endosos-body').html(trtd);
                $('#TableResultadosEndosos').DataTable({
                    language: {
                        url: `<?=base_url()?>assets/js/espanol.json`
                    },
                    dom: '<"toolbar toolbar-table-endosos">rtip ',
                    initComplete: function(row) {
                        var tmp = `
                        <div></div>`
                        $('div.toolbar-table-endosos').html(tmp);
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
                        sortable: false,
                        orderable: false,
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
                    },
                    {
                        sortable: true,
                        orderable: true,
                    }],
                    order: [['2', 'asc']],
                });
                $('.selectEndoso').click(function() {
                    const name = $(this).data('name');
                    $('#SelectEndoso').text('(' + name + ')');

                    //Cuentas
                    var PrimaNeta = 0;
                    var Descuento = 0;
                    var ExtraPrima = 0;
                    var Recargos = 0;
                    var Derechos = 0;
                    var SubTotal = 0;
                    var Inversion = 0;
                    var IVA = 0;
                    var Ajuste = 0;
                    var PrimaTotal = 0;
                    var Neta = 0;
                    var cExtraPrima = 0;
                    var cRecargos = 0;
                    var cDerechos = 0;
                    var Especial = 0;

                    for (var f in end) {
                        const Endoso = end[f].Endoso;
                        const Documento = valor(end[f].Documento);
                        const Estatus = valor(end[f].StatusEnd_Txt);
                        const Cliente = valor(end[f].NombreCompleto);
                        const RFC = valor(end[f].RFC);
                        const SubRamo = valor(end[f].SRamoNombre);
                        const FormPago = valor(end[f].FPago);
                        const Grupo = valor(end[f].Grupo);
                        const SubGrupo = valor(end[f].SubGrupo);
                        const Compania = valor(end[f].CiaNombre);
                        const Moneda = valor(end[f].Moneda);
                        const Inciso = valor(end[f].Inciso);
                        const CAgente = "[" + valor(end[f].CAgente) + "] ";
                        const AgenteNombre = valor(end[f].AgenteNombre);
                        const TCambio = valor(end[f].TCPago);
                        const Referencia1 = valor(end[f].Referencia1);
                        const Referencia2 = valor(end[f].Referencia2);
                        const Concepto = valor(end[f].Concepto);
                        const rPrimaNeta = valor(end[f].PrimaNeta);
                        const rDescuento = valor(end[f].Descuento);
                        const rExtraPrima = valor(end[f].ExtraPrima);
                        const rRecargos = valor(end[f].Recargos);
                        const rDerechos = valor(end[f].Derechos);
                        const rSubTotal = valor(end[f].STotal);
                        //const rInversion = valor(end[f].);
                        const Impuesto1 = valor(end[f].Impuesto1);
                        const Impuesto2 = valor(end[f].Impuesto2);
                        const rAjuste = valor(end[f].Ajuste);
                        const rPrimaTotal = valor(end[f].PrimaTotal);
                        const RegUsuario = valor(end[f].UserCreadorEnd);

                        //Option
                        const select1 = optionSelect(end[f].Documento);
                        const select2 = optionSelect(end[f].Endoso);
                        const select3 = "<option>Endoso</option>";
                        const Tipo = optionSelect(end[f].Tipo_TXT);
                        const StatusUser = optionSelect(end[f].StatusUserDoc_Txt);

                        //Fechas
                        const FStatus = fecha(end[f].FStatus);
                        const Desde = fecha(end[f].FDesdePoliza);
                        const Hasta = fecha(end[f].FHastaPoliza);
                        const FDesde = formatDate(end[f].FDesdeDocto);
                        const FHasta = formatDate(end[f].FHastaDocto);
                        const FEmision = formatDate(end[f].FEmision);
                        var FCreate = fecha(end[f].FCapturaDocto);
                        var HCreate = new Date(end[f].FCapturaDocto);
                        if (FCreate != 0) {
                            FCreate = FCreate + " " + HCreate.toLocaleTimeString('en-US');
                        }
                        else {
                            FCreate = "";
                        }

                        //Sumas
                        const rIVA = Number(Impuesto1) + Number(Impuesto2);
                        PrimaNeta += parseFloat(end[f].PrimaNeta);
                        Descuento += parseFloat(end[f].Descuento);
                        ExtraPrima += parseFloat(end[f].ExtraPrima);
                        Recargos += parseFloat(end[f].Recargos);
                        Derechos += parseFloat(end[f].Derechos);
                        SubTotal += parseFloat(end[f].STotal);
                        PrimaTotal += parseFloat(end[f].PrimaTotal);
                        Neta += parseFloat(end[f].Comision0);
                        cExtraPrima += parseFloat(end[f].Comision1); //Por confirmar
                        cRecargos += parseFloat(end[f].Comision2);
                        cDerechos += parseFloat(end[f].Comision3); //Por confirmar
                        Especial += parseFloat(end[f].Comision4); //Por confirmar

                        //Porcentaje
                        var PrctjDescuento = (100 / Number(PrimaNeta)) * Number(Descuento); //end[f].PorDesc
                        var PrctjExtraPrima = (100 / Number(PrimaNeta)) * Number(ExtraPrima); //end[f].PorExtraP
                        var PrctjRecargos = (100 / Number(PrimaNeta)) * Number(Recargos); //end[f].PorRecargos
                        var PrctjIVA = (100 / Number(SubTotal) * Number(IVA)); //Number(end[f].PorImp1)+Number(end[f].Imp2)
                        var PrctjNeta = (100 / Number(PrimaNeta)) * Number(Neta); //end[f].PorCom0
                        var PrctjExtPri = (100 / Number(PrimaNeta)) * Number(cExtraPrima);
                        var PrctjRecrgs = (100 / Number(PrimaNeta)) * Number(cRecargos);
                        var PrctjDerchs = (100 / Number(PrimaNeta)) * Number(cDerechos);
                        var PrctjEspcl = (100 / Number(PrimaNeta)) * Number(Especial);

                        if (name == Endoso) { //CL22955600-0
                            if (FEmision != 0) {
                                $('#EnBuscar').html(select1);
                                $('#EnEndosos').html(select2);
                                $('#EnStatus').text(Estatus);
                                //$('#EnVigente').text(FStatus);
                                $('#EnCliente').val(Cliente);
                                $('#EnRFC').val(RFC);
                                $('#EnSubRamo').val(SubRamo);
                                $('#EnFormaPago').val(FormPago);
                                $('#EnGrupo').val(Grupo);
                                $('#EnSubGrupo').val(SubGrupo);
                                $('#EnSSubGrupo').val(); //Pendiente
                                $('#EnCompania').val(Compania);
                                $('#EnMoneda').val(Moneda);
                                $('#EnDocumento').val(Documento);
                                $('#EnInciso').val(Inciso);
                                $('#EnAgente').val(CAgente + AgenteNombre);
                                $('#EnTCambio').val(Number(TCambio).toFixed(4));
                                $('#EnTipoDoc').html(select3);
                                $('#EnNumberSolic').val(); //Pendiente
                                $('#EnDesde').val(Desde);
                                $('#EnHasta').val(Hasta);
                                $('#EnEndoso').val(Endoso);
                                $('#EnTipoEnd').html(Tipo);
                                $('#EnFDesde').val(FDesde);
                                $('#EnFHasta').val(FHasta);
                                $('#EnEstatusUs').html(StatusUser);
                                $('#EnReferencia1').val(Referencia1);
                                $('#EnReferencia2').val(Referencia2);
                                $('#EnConcepto').val(Concepto);

                                //Primer Recibo
                                $('#EnPriNePR').val(numberFormat.format(rPrimaNeta).split('$')[1]);
                                $('#EnDescPR').val(numberFormat.format(rDescuento).split('$')[1]);
                                $('#EnExPriPR').val(numberFormat.format(rExtraPrima).split('$')[1]);
                                $('#EnRecPR').val(numberFormat.format(rRecargos).split('$')[1]);
                                $('#EnDerPR').val(numberFormat.format(rDerechos).split('$')[1]);
                                $('#EnSubTotPR').val(numberFormat.format(rSubTotal).split('$')[1]);
                                $('#EnInvPR').val();
                                //$('#EnIVAPR').val(); //Pendiente
                                //$('#EnAjustePR').val(); //Pendiente
                                $('#EnPrimTotPR').val(numberFormat.format(rPrimaTotal).split('$')[1]); 
                                //$('#EnDescPrctPR').val(); //Pendiente
                                //$('#EnExPrmPrcPR').val(); //Pendiente
                                //$('#EnRcgsPrcPR').val(); //Pendiente
                                //$('#EnIVAPrcPR').val(); //Pendiente

                                //Registro de Fechas
                                $('#EnFSolicitud').val();
                                $('#EnEnvio').val();
                                $('#EnRecepcion').val();
                                $('#EnFConversion').val();
                                $('#EnCaptura').val(FCreate);
                                $('#EnFolioNumber').val();
                                $('#EnEmision').val(FEmision);
                                $('#EnEntrega').val();
                                $('#EnRegistroUs').text(RegUsuario);
                            }

                            //Detalle de Primas
                            $('#EnPrimaNeta').val(numberFormat.format(PrimaNeta).split('$')[1]);
                            $('#EnDescuento').val(numberFormat.format(Descuento).split('$')[1]);
                            $('#EnExtraPrima').val(numberFormat.format(ExtraPrima).split('$')[1]);
                            $('#EnRecargos').val(numberFormat.format(Recargos).split('$')[1]);
                            $('#EnDerechos').val(numberFormat.format(Derechos).split('$')[1]);
                            $('#EnSubTotal').val(numberFormat.format(SubTotal).split('$')[1]);
                            $('#EnInversion').val(); //Pendiente
                            $('#EnIVA').val(numberFormat.format(IVA).split('$')[1]);
                            $('#EnAjuste').val(numberFormat.format(Ajuste).split('$')[1]);
                            $('#EnPrimaTotal').val(numberFormat.format(PrimaTotal).split('$')[1]);
                            $('#EnDescPrctj').val(PrctjDescuento.toFixed(2));
                            $('#EnExPrmPrctj').val(PrctjExtraPrima.toFixed(2));
                            $('#EnRcgsPrctj').val(PrctjRecargos.toFixed(2));
                            $('#EnIVAPrctj').val(PrctjIVA.toFixed(2));

                            //Detalle de Comisiones
                            $('#EnNeta').val(numberFormat.format(Neta).split('$')[1]);
                            $('#EnExtraPrimaC').val(numberFormat.format(cExtraPrima).split('$')[1]);
                            $('#EnRecargosC').val(numberFormat.format(cRecargos).split('$')[1]);
                            $('#EnDerechosC').val(numberFormat.format(cDerechos).split('$')[1]);
                            $('#EnEspecialC').val(numberFormat.format(Especial).split('$')[1]);
                            $('#EnNetaC').val(PrctjNeta.toFixed(2));
                            $('#EnExtPrmC').val(PrctjExtPri.toFixed(2));
                            $('#EnRcgsC').val(PrctjRecrgs.toFixed(2));
                            $('#EnDrchsC').val(PrctjDerchs.toFixed(2));
                            $('#EnEspC').val(PrctjEspcl.toFixed(2));
                        }
                    }
                });
            },
            error: (error) => {
                console.log("Hay problemas al buscar los endosos.");
            }
        })
    }
    
</script>