<!-- Modal Tabla de Información de Recibo -->
<div class="modal fade detalles-recibo-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin-top: 9px; margin-bottom: 9px;">
        <div class="modal-content">
            <!-- Se puede usar el modal para otra información pero solo si se desocupa este espacio -->
            <div class="modal-header column-select" style="height:40px;">
                <h4 class="title-result">Detalles del Rebibo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
            </div>
            <div class="content-info-recibos"></div>
            <div class="modal-body tab-body-info-recibos" style="background: #f1f1f1;">
                <div class="col-md-12" style="display: flex;padding-right: 0px;">
                    <ul class="nav nav-tabs" id="Tab-Recibos">
                        <li class="nav-item active">
                            <a class="nav-tab-link active" aria-current="page" href="#PanelR1" role="tab" data-toggle="tab">
                                General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-tab-link" aria-current="page" href="#PanelR2" role="tab" data-toggle="tab">
                                Registro de pago
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-tab-link" aria-current="page" href="#PanelR3" role="tab" data-toggle="tab">
                                Historial
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-tab-link" aria-current="page" href="#PanelR4" role="tab" data-toggle="tab">
                                Comisiones de agente
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-tab-link" aria-current="page" href="#PanelR5" role="tab" data-toggle="tab">
                                Honorarios de vendedor
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content bg-tab-content-recibo" id="nav-panel-info-recibos">
                    <!-- Panel 1 -->    
                    <div class="col-md-12 bg-table tab-pane active" id="PanelR1">
                        <div class="row container-table">
                            <div class="col-md-6 content-column-two">
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-6 dr">
                                        <label class="title-item-recibo-bold">Documento</label>
                                        <input type="text" id="rDocumento" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr">
                                        <label class="title-item-consult">Inciso</label>
                                        <input type="text" id="rInciso" class="form-control input-sm textSearch">
                                    </div>
                                </div>
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-12 dr">
                                        <label class="title-item-recibo-bold">Cliente</label>
                                        <input type="text" id="rCliente" class="form-control input-sm textAlert">
                                    </div>
                                </div>
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-6 dr">
                                        <label class="title-item-recibo">Ejecutivo</label>
                                        <input type="text" id="rEjecutivo" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr">
                                        <label class="title-item-recibo">Vendedor</label>
                                        <input type="text" id="rVendedor" class="form-control input-sm textAlert">
                                    </div>
                                </div>
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-8 dr">
                                        <label class="title-item-recibo">Referencia de pago</label>
                                        <input type="text" id="rReferenciaPago" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-4 dr">
                                        <label class="title-item-recibo">Intentos de pago</label>
                                        <input type="text" id="rIntentosPago" class="form-control input-sm textAlert">
                                    </div>
                                </div>
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-12 dr">
                                        <label class="title-item-recibo">Ejecutivo de cobranza</label>
                                        <input type="text" id="rEjecutivoCobranza" class="form-control input-sm textSearch">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 content-column-two">
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-4 dr">
                                        <label class="title-item-recibo-bold">Endoso</label>
                                        <input type="text" id="rEndoso" class="form-control input-sm textSearch">
                                    </div>
                                    <div class="pd-input-recibo col-sm-3 dr">
                                        <label class="title-item-recibo">Tipo Endoso</label>
                                        <input type="text" id="rTipoEndoso" class="form-control input-sm textSearch">
                                    </div>
                                    <div class="pd-input-recibo col-sm-3 dr">
                                        <label class="title-item-recibo">Serie</label>
                                        <input type="text" id="rSerie" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-2 dr">
                                        <label class="title-item-recibo">Periodo</label>
                                        <input type="text" id="rPeriodo" class="form-control input-sm textAlert">
                                    </div>
                                </div>
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-12 dr">
                                        <label class="title-item-recibo">Ramo</label>
                                        <input type="text" id="rRamo" class="form-control input-sm textAlert">
                                    </div>
                                </div>
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-12 dr">
                                        <label class="title-item-recibo">Compañía</label>
                                        <input type="text" id="rCompania" class="form-control input-sm textAlert">
                                    </div>
                                </div>
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-12 dr">
                                        <label class="title-item-recibo">Agente</label>
                                        <input type="text" id="rAgente" class="form-control input-sm textAlert">
                                    </div>
                                </div>
                                <div class="col-md-12 space-bottom-r fila-input-series">
                                    <div class="pd-input-recibo col-sm-6 dr">
                                        <label class="title-item-recibo">Moneda</label>
                                        <input type="text" class="rMoneda form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr">
                                        <label class="title-item-recibo">Forma de pago</label>
                                        <input type="text" id="rFormaPago" class="form-control input-sm textAlert">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 columns-table-recibo">
                                <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                                    <div class="title-segment-user title-table" style="text-align: center;">
                                        Detalle de primas
                                    </div>
                                </div>
                                <div class="col-md-12 segment-body-no-table">  
                                    <div class="col-md-7 column-primas">
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Prima neta: </label>
                                            <input type="text" id="rPrimaNeta" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Descuento: </label>
                                            <input type="text" id="rDescuento" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Extra prima: </label>
                                            <input type="text" id="rExtraPrima" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Recargos: </label>
                                            <input type="text" id="rRecargos" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Derechos: </label>
                                            <input type="text" id="rDerechos" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Subtotal: </label>
                                            <input type="text" id="rSubTotal" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">De inversión:</label>
                                            <input type="text" id="rInversion" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">IVA:</label>
                                            <input type="text" id="rIVA" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Ajuste:</label>
                                            <input type="text" id="rAjuste" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Prima Total: </label>
                                            <input type="text" class="rPrimaTotal form-control input-sm textSearch align-money" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-5 column-primas" style="padding-right: 10px;">
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <span class="input-sm title-item-recibo">%</span>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="rDescuentoPrctj" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="rExtPrmPrctj" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="rRcgsPrctj" class="form-control input-sm textSearch align-money"/>
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
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="rIVAPrctj" class="form-control input-sm textSearch align-money"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 columns-table-recibo">
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
                                <div class="col-md-12 segment-body-no-table">
                                    <div class="col-md-7 column-primas">
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Neta: </label>
                                            <input type="text" id="rNeta" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Extra prima: </label>
                                            <input type="text" id="rExtraPrimaC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Recargos: </label>
                                            <input type="text" id="rRecargosC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Derechos: </label>
                                            <input type="text" id="rDerechosC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult" style="padding-right:3px;">Especial: </label>
                                            <input type="text" id="rEspecialC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                    </div>
                                    <div class="col-md-5 column-primas" style="padding-right: 10px;">
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="rNetaC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="rExtPrmC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="rRcgsC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="rDrchsC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                        <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                            <input type="text" id="rEspC" class="form-control input-sm textAlert align-money"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 column-primas" style="display: flex; align-items: flex-start;">
                            <div class="col-md-6 second-column" style="padding-bottom: 10px; margin: 5px; width: 46%;">
                                <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Prima neta original: </label>
                                    <input type="text" id="rPrimaNetaOriginal" class="form-control input-sm textAlert align-money"/>
                                </div>
                                <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Prima enviada: </label>
                                    <input type="text" class="rPrimaEnviada form-control input-sm textAlert align-money"/>
                                </div>
                                <div class="input-width col-sm-12 sub-dr space-bottom-r">
                                    <label class="title-sub-item-consult" style="padding-right:3px;">Prima total original:</label>
                                    <input type="text" id="rPrimaTotalOriginal" class="form-control input-sm textAlert align-money"/>
                                </div>
                                <div class="col-md-12 content-status-recibo">
                                    <h4 class="textAlert" id="EstatusRecibo" style="margin-bottom:5px;color:red"></h4>
                                    <hr style="margin-bottom: 5px; border-style: dotted; border-color: red;"/>
                                    <h5 id="FechaEstatus" style="color: #303030"></h5>
                                </div>
                            </div>
                            <div class="col-md-6 second-column" style="text-align:initial; padding-bottom: 10px; margin: 5px; width: 46%;">
                                <div class="col-md-12" style="display: flex;padding-right: 0px;">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item active">
                                            <a class="nav-tab-link active" aria-current="page" href="#OperativoP1" role="tab" data-toggle="tab">Operativas</a>
                                        </li>
                                        <li class="nav-item hidden">
                                            <a class="nav-tab-link" aria-current="page" href="#ControlP1" role="tab" data-toggle="tab">Control</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content bg-tab-content-recibo" style="height:auto;box-shadow:0px 0px 5px 0px #7086a1;">      
                                    <div class="col-md-12 bg-table tab-pane active" id="OperativoP1">
                                        <div class="input-width col-md-6 space-bottom-r">
                                            <label class="title-item-recibo">Desde</label>
                                            <input type="date" id="rDesde" class="form-control input-sm textSearch">
                                        </div>
                                        <div class="input-width col-md-6 space-bottom-r">
                                            <label class="title-item-recibo">Hasta</label>
                                            <input type="date" id="rHasta" class="form-control input-sm textSearch">
                                        </div>
                                        <div class="input-width col-md-6 space-bottom-r">
                                            <label class="title-item-recibo">Generación</label>
                                            <input type="date" id="rGeneracion" class="form-control input-sm textSearch">
                                        </div>
                                        <div class="input-width col-md-6 space-bottom-r">
                                            <label class="title-item-recibo">Límite de pago</label>
                                            <input type="date" id="rLimitePago" class="form-control input-sm textSearch">
                                        </div>
                                        <div class="input-width col-md-12 space-bottom-r">
                                            <label class="title-item-recibo">Envío</label>
                                            <input type="text" id="rEnvio" class="form-control input-sm textSearch">
                                        </div>
                                        <div class="input-width col-md-12 space-bottom-r">
                                            <label class="title-item-recibo">Estatus de usuario</label>
                                            <select id="rEstatusUsuario" class="form-control input-sm textSearch"></select>
                                        </div>
                                        <div class="input-width col-md-12 space-bottom-r">
                                            <label class="title-item-recibo">Estatus de recuperación</label>
                                            <select id="rEstatusRecuper" class="form-control input-sm textSearch">
                                                <option>Normal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 bg-table tab-pane" id="ControlP1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Panel 2 -->
                    <div class="col-md-12 bg-table tab-pane" id="PanelR2">
                        <div class="row space-bottom-r">
                            <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                                <div class="title-segment-user title-table"></div>
                                <!-- <div class="panel-btn-recibo title-table">
                                    <button type="button" class="btn btn-panel-recibo btn-sup-left">
                                        <i class="fa fa-pencil-square-o" style="padding-right:5px;"></i>
                                        Editar
                                    </button>
                                    <button type="button" class="btn btn-panel-recibo">
                                        <i class="fa fa-ban" style="padding-right:5px;"></i>
                                        Anular pago
                                    </button>
                                    <button type="button" class="btn btn-panel-recibo">
                                        <i class="fa fa-check-square" style="padding-right:5px;"></i>
                                        Liquidar
                                    </button>
                                    <button type="button" class="btn btn-panel-recibo">
                                        <i class="fa fa-minus-square" style="padding-right:5px;"></i>
                                        Desliquidar
                                    </button>
                                    <button type="button" class="btn btn-panel-recibo">
                                        <i class="fa fa-exclamation-triangle" style="padding-right:5px;"></i>
                                        Aplicación cero
                                    </button>
                                </div> -->
                            </div>
                            <div class="col-md-12" style="background:#f9f9f9; overflow:auto; padding:0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <table class="table table-striped" id="TableRegistroPago" style="margin-bottom: 0px;">
                                        <thead style="position: sticky;top: 0px;">
                                            <tr style="background: #266093; font-size: 12px;">
                                                <th scope="col">Fecha de Pago</th>
                                                <th scope="col">Moneda Pago</th>
                                                <th scope="col">Importe del Pago</th>
                                                <th scope="col">Importe Real</th>
                                                <th scope="col">Tipo de Documento</th>
                                                <th scope="col">Confirmación Liquidación</th>
                                                <th scope="col">Tipo de Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list-table-registro-pago-body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row space-bottom-r">
                            <div class="input-width col-md-3 space-bottom-r">
                                <label class="title-item-recibo">Prima enviada</label>
                                <input type="text" class="rPrimaEnviada form-control input-sm textAlert align-money">
                            </div>
                            <div class="input-width col-md-3 space-bottom-r">
                                <label class="title-item-recibo">Prima total</label>
                                <input type="text" class="rPrimaTotal form-control input-sm textAlert align-money">
                            </div>
                            <div class="input-width col-md-3 space-bottom-r">
                                <label class="title-item-recibo">Prima pagada</label>
                                <input type="text" id="rPrimaPagada" class="form-control input-sm textAlert align-money">
                            </div>
                            <div class="input-width col-md-3 space-bottom-r">
                                <label class="title-item-recibo">Prima pendiente</label>
                                <input type="text" id="rPrimaPendiente" class="form-control input-sm textAlert align-money">
                            </div> 
                        </div>
                        <div class="row container-table space-bottom-r">
                            <div class="col-md-12 space-bottom-r">
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Fecha de pago</label>
                                    <input type="text" id="rFechaPago" class="form-control input-sm textAlert">
                                </div>
                                <div class="input-width col-md-3 space-bottom-r">
                                    <label class="title-item-recibo">Tipo de documento</label>
                                    <input type="text" id="rTipoDoc" class="form-control input-sm textAlert">
                                </div>
                                <div class="input-width col-md-3 space-bottom-r">
                                    <label class="title-item-recibo">Banco</label>
                                    <input type="text" id="rBanco" class="form-control input-sm textAlert">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">No. Documento</label>
                                    <input type="text" id="rFolioDoc" class="form-control input-sm textAlert">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Fecha Documento</label>
                                    <input type="text" id="rFechaDoc" class="form-control input-sm textAlert">
                                </div>
                            </div>
                            <div class="col-md-12 space-bottom-r" style="display:flex; align-items:flex-end;">
                                <div class="input-width col-md-3 space-bottom-r">
                                    <label class="title-item-recibo">Folio de cheque</label>
                                    <input type="text" id="rFolioCheque" class="form-control input-sm textAlert">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Tipo de pago</label>
                                    <input type="text" id="rTipoPago" class="form-control input-sm textAlert">
                                </div>
                                <div class="input-width col-md-4 space-bottom-r" style="text-align: center;">
                                    <label id="rUsuarioPago" class="title-item-recibo-bold name-subr"></label>
                                </div>
                                <div class="input-width col-md-3 space-bottom-r">
                                    <label id="rFechaPagoCreada" class="title-item-recibo-bold name-subr"></label>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding-left:3px; padding-right:3px;">
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Moneda de pago</label>
                                    <input type="text" id="rMonedaPago" class="form-control input-sm textAlert">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Tipo de cambio</label>
                                    <input type="text" id="rTipoCambio1" class="form-control input-sm textAlert align-money">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Importe del pago</label>
                                    <input type="text" id="rImportePago" class="form-control input-sm textAlert align-money">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Moneda del docto.</label>
                                    <input type="text" class="rMoneda form-control input-sm textAlert">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Tipo de cambio</label>
                                    <input type="text" id="rTipoCambio2" class="form-control input-sm textAlert align-money">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Importe real</label>
                                    <input type="text" id="rImporteReal" class="form-control input-sm textAlert align-money">
                                </div>
                            </div>
                        </div>
                        <div class="row container-table space-bottom" style="padding-bottom: 0px;">
                            <div class="col-md-12 space-bottom-r">
                                <div class="input-width col-md-3 space-bottom-r">
                                    <label class="title-item-recibo">Número liquidación</label>
                                    <input type="text" id="rNumLiq" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Folio liquidación cía.</label>
                                    <input type="text" id="rFolioLiq" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Fecha liquidación</label>
                                    <input type="text" id="rFechaLiq" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-2 space-bottom-r">
                                    <label class="title-item-recibo">Confirmación liq.</label>
                                    <input type="text" id="rConfLiq" class="form-control input-sm textSearch">
                                </div>
                                <div class="input-width col-md-3 space-bottom-r">
                                    <label class="title-item-recibo">Fecha de confirmación</label>
                                    <input type="text" id="rFechaConf" class="form-control input-sm textSearch">
                                </div>
                            </div>
                            <div class="col-md-12" style="text-align:end; display:flex; align-items:center; justify-content:end;">
                                <div class="input-width col-md-6">
                                    <label id="rUsuarioLiq" class="title-item-recibo-bold name-subr"></label>
                                </div>
                                <div class="input-width col-md-3">
                                    <label id="rFechaPagoLiq" class="title-item-recibo-bold name-subr"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 20px;">
                            <div class="col-md-6">
                                <label class="title-item-recibo">Observaciones</label>
                                <textarea type="text" id="rObervRecibo" class="form-control input-sm textSearch"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="title-item-recibo">Concentrado de cheques</label>
                                <textarea type="text" id="rConcCheques" class="form-control input-sm textSearch"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Panel 3 -->
                    <div class="col-md-12 bg-table tab-pane" id="PanelR3">
                        <div class="row space-bottom-r">
                            <div class="col-md-12" style="background:#f9f9f9; overflow:auto; height:150px; padding:0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <table class="table table-striped" id="TableHistorialRecibo" style="margin-bottom: 0px;">
                                        <thead style="position: sticky;top: 0px;">
                                            <tr style="background: #266093; font-size: 12px;">
                                                <th scope="col">Fecha de Registro</th>
                                                <th scope="col">Concepto</th>
                                                <th scope="col">Acción</th>
                                                <th scope="col">Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list-table-historial-recibo-body" style="font-size:12px;">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Panel 4 -->
                    <!-- Pendiente por manipulación de información -->
                    <div class="col-md-12 bg-table tab-pane" id="PanelR4"> 
                        <div class="row space-bottom-r">
                            <div class="col-md-12" style="background:#f9f9f9; overflow:auto; height:250px; padding:0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <table class="table table-striped" id="TableComisionesAgente" style="margin-bottom: 0px;">
                                        <thead style="position: sticky; top: 0px; z-index: 1">
                                            <tr style="background: #5286b5;">
                                                <th colspan="24">
                                                    <h5 style="margin:0px;">Comisiones de agentes</h5>
                                                </th>
                                            </tr>
                                            <tr style="background: #266093; font-size: 12px;">
                                                <th scope="col">Tipo de Agente</th>
                                                <th scope="col">Tipo de Comisión</th>
                                                <th scope="col">Base de Cálculo</th>
                                                <th scope="col">Participación</th>
                                                <th scope="col">Generada</th>
                                                <th scope="col">Pendiente</th>
                                                <th scope="col">Aplicado</th>
                                                <th scope="col">Fecha de Aplicación</th>
                                                <th scope="col">Fecha de Liquidación</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list-table-comisiones-agente-body" style="font-size:12px;">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 columns-table-recibo">
                                <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                                    <div class="title-segment-user title-table"></div>
                                    <!-- <div class="panel-btn-recibo title-table">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-panel-recibo btn-sup-left" style="">
                                                <i class="fa fa-file-text" style="padding-right:5px;"></i>
                                                Nuevo
                                            </button>
                                            <button type="button" class="btn btn-panel-recibo">
                                                <i class="fa fa-pencil-square-o" style="padding-right:5px;"></i>
                                                Editar
                                            </button>
                                            <button type="button" class="btn btn-panel-recibo">
                                                <i class="fa fa-trash" style="padding-right:5px;"></i>
                                                Eliminar
                                            </button>
                                            <button type="button" class="btn btn-panel-recibo" style="height: 31.14px">
                                                <i class="fa fa-credit-card-alt" style="padding-right:5px;"></i>
                                            </button>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="col-md-12 column-comision">
                                    <div class="pd-input-recibo col-sm-12 dr space-bottom-r">
                                        <label class="title-item-recibo">Agente</label>
                                        <select id="rAgenteComision" class="form-control input-sm textAlert"></select>
                                    </div>
                                    <div class="pd-input-recibo col-sm-12 dr space-bottom-r">
                                        <label class="title-item-consult">Nombre agente</label>
                                        <input type="text" id="rNombreAg" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-12 dr space-bottom">
                                        <label class="title-item-recibo">Tipo de comisión</label>
                                        <select id="rTipoComis" class="form-control input-sm textAlert"></select>
                                    </div>
                                    <div class="col-md-12 column-primas space-bottom">
                                        <div class="pd-input-recibo col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult">Participación:</label>
                                            <input type="text" id="rPartComAg" class="form-control input-sm textAlert align-money">
                                        </div>
                                        <div class="pd-input-recibo col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult">Generada:</label>
                                            <input type="text" id="rGnrd" class="form-control input-sm textAlert align-money">
                                        </div>
                                        <div class="pd-input-recibo col-sm-12 sub-dr">
                                            <label class="title-sub-item-consult">Pendiente:</label>
                                            <input type="text" id="rComPend" class="form-control input-sm textAlert align-money">
                                        </div>
                                    </div>
                                    <div class="pd-input-recibo col-sm-12 dr space-bottom-r">
                                        <label class="title-item-recibo">Fecha de creación</label>
                                        <input type="text" id="rFechaCreacion" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="input-width col-md-12 space-bottom-r" style="text-align:center;">
                                        <label id="rComUsuarioLiq" class="title-item-recibo-bold name-subr">UsuarioLiq</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 columns-table-recibo">
                                <div class="col-md-12 hidden" style="padding-left:0px; padding-right:0px;">
                                    <div class="title-segment-user title-table"></div>
                                    <!-- <div class="panel-btn-recibo title-table">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-panel-recibo btn-sup-left">
                                                <i class="fa fa-file-text" style="padding-right:5px;"></i>
                                                Aplicar comisión
                                            </button>
                                            <button type="button" class="btn btn-panel-recibo">
                                                <i class="fa fa-pencil" style="padding-right:5px;"></i>
                                                Editar
                                            </button>
                                            <button type="button" class="btn btn-panel-recibo">
                                                <i class="fa fa-trash" style="padding-right:5px;"></i>
                                                Eliminar
                                            </button>
                                            <button type="button" class="btn btn-panel-recibo">
                                                Anular
                                            </button>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="col-md-12" style="background:#f9f9f9; overflow:auto; height:400px; padding:0px;">
                                    <div class="col-md-12" style="padding:0px;">
                                        <table class="table table-striped" id="TablePagosComision" style="margin-bottom: 0px;">
                                            <thead style="position: sticky;top: 0px;">
                                                <tr style="background: #5286b5;">
                                                    <th colspan="24">
                                                        <h5 style="margin:0px;font-size:13px;">Detalle pagos de la comisión</h5>
                                                    </th>
                                                </tr>
                                                <tr style="background: #266093; font-size: 12px;">
                                                    <th scope="col">Aplicación</th>
                                                    <th scope="col">Documento de Cobro</th>
                                                    <th scope="col">Folio Liquidación</th>
                                                    <th scope="col">Participación</th>
                                                    <th scope="col">Moneda del Docto</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list-table-pagos-comision-body" style="font-size:12px;">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- GS1050184-8 -->
                    <!-- Panel 5 -->
                    <!-- Pendiente por manipulación de información -->
                    <div class="col-md-12 bg-table tab-pane" id="PanelR5">
                        <div class="row space-bottom-r">
                            <div class="col-md-12" style="background:#f9f9f9; overflow:auto; height:350px; padding:0px;">
                                <div class="col-md-12" style="padding:0px;">
                                    <table class="table table-striped" id="TableHonorarioVendedor" style="margin-bottom: 0px;">
                                        <thead style="position: sticky; top: 0px; z-index: 1">
                                            <tr style="background: #5286b5;">
                                                <th colspan="24">
                                                    <h5 style="margin:0px;">Honorarios de Vendedores</h5>
                                                </th>
                                            </tr>
                                            <tr style="background: #266093; font-size: 12px;">
                                                <th scope="col">Tipo de Honorario</th>
                                                <th scope="col">Tipo de Valor</th>
                                                <th scope="col">Base de Cálculo</th>
                                                <th scope="col">Participación</th>
                                                <th scope="col">Fórmula</th>
                                                <th scope="col">Importe</th>
                                                <th scope="col">Pagado</th>
                                                <th scope="col">Fecha de Pago</th>
                                                <th scope="col">Documento</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list-table-honorario-vendedor-body" style="font-size:12px;">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 columns-table-recibo">
                                <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                                    <div class="title-segment-user title-table"></div>
                                    <!-- <div class="panel-btn-recibo title-table">
                                        <button type="button" class="btn btn-panel-recibo btn-sup-left">
                                            <i class="fa fa-file-text" style="padding-right:5px;"></i>
                                            Nuevo
                                        </button>
                                        <button type="button" class="btn btn-panel-recibo">
                                            <i class="fa fa-pencil-square-o" style="padding-right:5px;"></i>
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-panel-recibo">
                                            <i class="fa fa-trash" style="padding-right:5px;"></i>
                                            Eliminar
                                        </button>
                                        <button type="button" class="btn btn-panel-recibo" style="height: 31.14px">
                                            <i class="fa fa-credit-card-alt" style="padding-right:5px;"></i>
                                        </button>
                                        <button type="button" class="btn btn-panel-recibo">
                                            <i class="fa fa-usd" style="padding-right:5px;"></i>
                                            Pagar Honorario
                                        </button>
                                        <button type="button" class="btn btn-panel-recibo">
                                            <i class="fa fa-ban" style="padding-right:5px;"></i>
                                            Anular pago
                                        </button>
                                    </div> -->
                                </div>
                                <div class="col-md-6 column-comision">
                                    <div class="pd-input-recibo col-sm-12 dr space-bottom-r">
                                        <label class="title-item-recibo">Vendedor</label>
                                        <select id="rVendedorHon" class="form-control input-sm textAlert"></select>
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr space-bottom-r">
                                        <label class="title-item-consult">Tipo de honorario</label>
                                        <select id="rTipoHonorario" class="form-control input-sm textAlert"></select>
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr space-bottom-r">
                                        <label class="title-item-recibo">Tipo</label>
                                        <select id="rTipoValor" class="form-control input-sm textAlert"></select>
                                    </div>
                                    <div class="pd-input-recibo col-sm-12 dr space-bottom-r">
                                        <label class="title-item-recibo">Fórmula</label>
                                        <select id="rFormula" class="form-control input-sm textAlert"></select>
                                    </div>
                                    <div class="col-md-12 column-primas">
                                        <div class="pd-input-recibo col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult">Participación:</label>
                                            <input type="text" id="rPartH" class="form-control input-sm textAlert align-money">
                                        </div>
                                        <div class="pd-input-recibo col-sm-12 sub-dr space-bottom-r">
                                            <label class="title-sub-item-consult">Importe:</label>
                                            <input type="text" id="rImporteH" class="form-control input-sm textAlert align-money">
                                        </div>
                                    </div>
                                    <div class="pd-input-recibo col-sm-12 dr space-bottom-r" style="margin-bottom:7px;">
                                        <label class="title-item-recibo">Creación</label>
                                        <input type="text" id="rFechaCreacionH" class="form-control input-sm textAlert">
                                    </div>
                                </div>
                                <div class="col-md-6 column-comision">
                                    <div class="pd-input-recibo col-sm-12 dr space-bottom-r">
                                        <label class="title-item-recibo">Documento</label>
                                        <input type="text" id="rDocumentoH" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr space-bottom-r">
                                        <label class="title-item-recibo">Folio</label>
                                       <input type="text" id="rFolioH" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr space-bottom-r">
                                        <label class="title-item-recibo">Fecha de pago</label>
                                        <input type="text" id="rFechaPagoH" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr space-bottom-r">
                                        <label class="title-item-recibo">Moneda de pago</label>
                                        <input type="text" id="rMonedaPagoH" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr space-bottom-r">
                                        <label class="title-item-recibo">Moneda del docto.</label>
                                        <input type="text" id="rMonedaDoctoH" class="form-control input-sm textAlert">
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr space-bottom-r">
                                        <label class="title-item-recibo">Tipo de cambio</label>
                                        <input type="text" id="rTipoCambioH1" class="form-control input-sm textAlert align-money">
                                    </div>
                                    <div class="pd-input-recibo col-sm-6 dr space-bottom-r">
                                        <label class="title-item-recibo">Tipo de cambio</label>
                                        <input type="text" id="rTipoCambioH2" class="form-control input-sm textAlert align-money">
                                    </div>
                                    <div class="col-md-12 space-bottom" style="display:flex; align-items:flex-end; padding:0px;">
                                        <div class="input-width col-md-6" style="text-align:center;">
                                            <label id="rUsuarioLiqH" class="title-item-recibo-bold name-subr"></label>
                                        </div>
                                        <div class="pd-input-recibo col-sm-6 dr space-bottom-r">
                                            <label class="title-item-recibo">Importe de pago</label>
                                            <input type="text" id="rImportePagoH" class="form-control input-sm textAlert align-money">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer hidden">
                <button type="button" class="btn btn-default close-list" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function DetallesRecibo(info) {
        const id = $(info).data('id');
        const doc = $(info).data('doc');

        $.ajax({
            type: "GET",
            url: `${baseUrl}/InformacionRecibo`,
            data: {
                id: id
            },
            beforeSend: (load) => { //518.56
                $('.content-info-recibos').html(`
                    <div class="container-spinner-content-solicitudes-polizas">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
            },
            success: (data) => {
                const d = JSON.parse(data);
                console.log(d);

                const rcb = d['recibos'];
                const hnr = d['honorarios'];

                $('.content-info-recibos').html("");
                $('.list-table-registro-pago-body').html("");
                $('.list-table-comisiones-agente-body').html("");
                $('.list-table-honorario-vendedor-body').html("");
                $('#rEstatusUsuario').html("");

                var trtd1 = ``;
                var trtd2 = ``;
                var trtd3 = ``;
                var trtd4 = ``;
                var trtd5 = ``;
                var statusUser = ``;

                //Cambio de formato decimal
                //Opción 1: Formato monetario
                //Opción 2: toFixed(); usado para la cantidad de decimales a mostrar y solo acepta números
                //Opción 3: Mantener el formato monetario pero con 4 cifras decimales
                /*const four = { maximumFractionDigits: 4, };
                const numberFormat2 = new Intl.NumberFormat('es-MX', four);*/
                //Opción 4: Solo muestra decimal cuando lo tenga, el maximumFractionDigits es la cifra de números decimales que se desea y el useGrouping es el separar los numeros con comas
                /*const options = { maximumFractionDigits: 2, useGrouping: true };
                const numberFormat1 = new Intl.NumberFormat('es-MX', options);*/

                for (var r in rcb) {

                    const Documento = valor(rcb[r].Documento);
                    const Inciso = valor(rcb[r].Inciso);
                    const Cliente = valor(rcb[r].NombreCompleto);
                    const Ejecutivo = valor(rcb[r].EjecutNombre);
                    const Vendedor = valor(rcb[r].VendNombre);
                    const RefPago = valor(rcb[r].ReferenciaPago);
                    const IntPago = valor(rcb[r].IntPago);
                    //const EjecutCobrz = valor(rcb[r].);
                    const Endoso = valor(rcb[r].Endoso);
                    const TipoEndoso = valor(rcb[r].TipoEnd);
                    const Serie = valor(rcb[r].Serie);
                    const Periodo = valor(rcb[r].Periodo);
                    const SRamo = valor(rcb[r].SRamoNombre);
                    const CiaNombre = valor(rcb[r].CiaNombre);
                    const CAgente =  "[" + valor(rcb[r].CAgente) + "] ";
                    const AgenteNombre = valor(rcb[r].AgenteNombre);
                    const Moneda = valor(rcb[r].Moneda);
                    const FPago = valor(rcb[r].FPago);
                    const PrimaNeta = valor(rcb[r].PrimaNeta);
                    const Descuento = valor(rcb[r].Descuento);
                    const ExtraPrima = valor(rcb[r].ExtraPrima);
                    const Recargos = valor(rcb[r].Recargos);
                    const Derechos = valor(rcb[r].Derechos);
                    const STotal = valor(rcb[r].STotal);
                    //const inversion = valor(rcb[r].);
                    const Ajuste = valor(rcb[r].Ajuste);
                    const PrimaTotal = valor(rcb[r].PrimaTotal);
                    const PrimaNetaOriginal = valor(rcb[r].PrimaNetaOrg);
                    const PrimaEnviada = valor(rcb[r].PrimaEnviada);
                    const PrimaTotalOriginal = valor(rcb[r].PrimaTotalOrg);
                    const PrimaPagada = valor(rcb[r].PrimaPag);
                    const PrimaPendiente = valor(rcb[r].PrimaPend);
                    const Status = valor(rcb[r].Status_TXT);
                    const MonedaPago = valor(rcb[r].MonedaPago);
                    const ImportePago = valor(rcb[r].ImportePago);
                    const ImporteReal = valor(rcb[r].ImporteReal);
                    const TipoDoc = valor(rcb[r].TipoDocto);
                    const TipoPago = valor(rcb[r].TPago_TXT);
                    const StatusUser = valor(rcb[r].StatusUser_TXT);
                    const Banco = valor(rcb[r].Banco);
                    const FolioDoc = valor(rcb[r].FolioDocto);
                    const UsuarioPago = valor(rcb[r].UsuarioPago);
                    const TipoCambPago = valor(rcb[r].TCPago);
                    const TipoCambDoc = valor(rcb[r].TCDocto);
                    const NumLiq = valor(rcb[r].NLiquidacion);
                    const UsuarioLiq = valor(rcb[r].UsuarioLiquido);
                    const Observaciones = valor(rcb[r].Observaciones);
                    const Impuesto1 = valor(rcb[r].Impuesto1);
                    const Impuesto2 = valor(rcb[r].Impuesto2);

                    //Detalle de Comisiones
                    const Neta = valor(rcb[r].Comision0);
                    const ComExtPri = 0; //valor(rcb[r].Comision1); //Por confirmar
                    const ComRecargos = valor(rcb[r].Comision2);
                    const ComDerechos = 0; //valor(rcb[r].Comision3); //Por confirmar
                    const ComEspecial = 0; //valor(rcb[r].Comision4); //Por confirmar
                    //const PrctjNeta = valor(rcb[r].PorCom0);
                    const PrctjExtraPri = 0; //valor(rcb[r].PorCom1); //Por confirmar
                    const PrctjRecargos = 0; //valor(rcb[r].PorCom2); //Cantidad errónea
                    const PrctjDerechos = 0; //valor(rcb[r].PorCom3); //Por confirmar
                    const PrctjEspecial = 0; //valor(rcb[r].PorCom4); //Por confirmar
                    //Si Comision2 es con PorCom2 entonces, por qué sale un porcentaje de una cantidad con valor 0?

                    //Fechas
                    const FLiquid = fecha(rcb[r].FLiquidacion);
                    const Desde = formatDate(rcb[r].FDesde);
                    const Hasta = formatDate(rcb[r].FHasta);
                    const Generacion = formatDate(rcb[r].FGeneracion);
                    const LimitePago = formatDate(rcb[r].FLimPago);
                    const FechaPago = fecha(rcb[r].FechaPago);
                    const FechaDoc = fecha(rcb[r].FechaDocto);

                    var FechaPagoCredada = fecha(rcb[r].FCreatePag);
                    var HoraPagoCreada = new Date(rcb[r].FCreatePag);

                    if (FechaPagoCredada != 0) {
                        FechaPagoCredada = FechaPagoCredada + " " + HoraPagoCreada.toLocaleTimeString('en-US');
                    }
                    else {
                        FechaPagoCredada = "";
                    }

                    var FechaPagoLiq = fecha(rcb[r].FCreateLiq);
                    var HoraPagoLiq = new Date(rcb[r].FCreateLiq);

                    if (FechaPagoLiq != 0) {
                        FechaPagoLiq = FechaPagoLiq + " " + HoraPagoLiq.toLocaleTimeString('en-US');
                    }
                    else {
                        FechaPagoLiq = "";
                    }

                    var IVA = Number(Impuesto1) + Number(Impuesto2);
                    var PorcentajeDescuento = (100 / Number(PrimaNeta)) * Number(Descuento); //rcb[r].PorDesc
                    var PorcentajeExtraPrima = (100 / Number(PrimaNeta)) * Number(ExtraPrima); //rcb[r].PorExtraP
                    var PorcentajeRecargos = (100 / Number(PrimaNeta)) * Number(Recargos); //rcb[r].PorRecargos
                    var PorcentajeIVA = (100 / Number(STotal) * Number(IVA)); //Number(rcb[r].PorImp1)+Number(rcb[r].Imp2)
                    var PorcentajeNeta = (100 / Number(PrimaNeta)) * Number(Neta); //rcb[r].PorCom0

                //Panel 1: General //497-2405-1
                    $('#rDocumento').val(Documento);
                    $('#rInciso').val(Inciso);
                    $('#rCliente').val(Cliente);
                    $('#rEjecutivo').val(Ejecutivo);
                    $('#rVendedor').val(Vendedor);
                    $('#rReferenciaPago').val(RefPago);
                    $('#rIntentosPago').val(IntPago);
                    //$('#rEjecutivoCobranza').val(); //Pendiente
                    $('#rEndoso').val(Endoso);
                    $('#rTipoEndoso').val(TipoEndoso);
                    $('#rSerie').val(Serie);
                    $('#rPeriodo').val(Periodo);
                    $('#rRamo').val(SRamo);
                    $('#rCompania').val(CiaNombre);
                    $('#rAgente').val(CAgente + AgenteNombre);
                    $('.rMoneda').val(Moneda);
                    $('#rFormaPago').val(FPago);
                    $('#rPrimaNeta').val(numberFormat.format(PrimaNeta).split('$')[1]);
                    $('#rDescuento').val(numberFormat.format(Descuento).split('$')[1]);
                    $('#rExtraPrima').val(numberFormat.format(ExtraPrima).split('$')[1]);
                    $('#rRecargos').val(numberFormat.format(Recargos).split('$')[1]);
                    $('#rDerechos').val(numberFormat.format(Derechos).split('$')[1]);
                    $('#rSubTotal').val(numberFormat.format(STotal).split('$')[1]);
                    //$('#rInversion').val(); //Pendiente
                    $('#rIVA').val(numberFormat.format(IVA).split('$')[1]);
                    $('#rAjuste').val(numberFormat.format(Ajuste).split('$')[1]);
                    $('.rPrimaTotal').val(numberFormat.format(PrimaTotal).split('$')[1]);

                    $('#rDescuentoPrctj').val(PorcentajeDescuento.toFixed(2));
                    $('#rExtPrmPrctj').val(PorcentajeExtraPrima.toFixed(2));
                    $('#rRcgsPrctj').val(PorcentajeRecargos.toFixed(2));
                    $('#rIVAPrctj').val(PorcentajeIVA.toFixed(2));

                    $('#rNeta').val(numberFormat.format(Neta).split('$')[1]);
                    $('#rExtraPrimaC').val(numberFormat.format(ComExtPri).split('$')[1]);
                    $('#rRecargosC').val(numberFormat.format(ComRecargos).split('$')[1]);
                    $('#rDerechosC').val(numberFormat.format(ComDerechos).split('$')[1]);
                    $('#rEspecialC').val(numberFormat.format(ComEspecial).split('$')[1]);
                    $('#rNetaC').val(PorcentajeNeta.toFixed(2));
                    $('#rExtPrmC').val(Number(PrctjExtraPri).toFixed(2));
                    $('#rRcgsC').val(Number(PrctjRecargos).toFixed(2));
                    $('#rDrchsC').val(Number(PrctjDerechos).toFixed(2));
                    $('#rEspC').val(Number(PrctjEspecial).toFixed(2));

                    $('#rPrimaNetaOriginal').val(numberFormat.format(PrimaNetaOriginal).split('$')[1]);
                    $('.rPrimaEnviada').val(numberFormat.format(PrimaEnviada).split('$')[1]);
                    $('#rPrimaTotalOriginal').val(numberFormat.format(PrimaTotalOriginal).split('$')[1]);
                    $('#EstatusRecibo').text(Status);
                    $('#FechaEstatus').text(FLiquid);
                    $('#rDesde').val(Desde);
                    $('#rHasta').val(Hasta);
                    $('#rGeneracion').val(Generacion);
                    $('#rLimitePago').val(LimitePago);
                    $('#rEnvio').val(); //Pendiente

                    var statusUser = optionSelect(StatusUser);
                    $('#rEstatusUsuario').html(statusUser);
                    $('#rEstatusRecuper').val(); //Pendiente

                //Panel 2: Registro de pago
                    const ConfLiq = "Confirmación Liquidación";
                    trtd1 += `
                        <tr data-id="${rcb[r].IDPagoRec}">
                            <td>${FechaPago}</td>
                            <td>${MonedaPago}</td>
                            <td>${numberFormat.format(ImportePago)}</td>
                            <td>${numberFormat.format(ImporteReal)}</td>
                            <td>${TipoDoc}</td>
                            <td>${ConfLiq}</td> <!-- Pendiente -->
                            <td>${TipoPago}</td>
                        </tr>`;

                    $('#rPrimaPagada').val(numberFormat.format(PrimaPagada).split('$')[1]);
                    $('#rPrimaPendiente').val(numberFormat.format(PrimaPendiente).split('$')[1]);
                    $('#rFechaPago').val(FechaPago);
                    $('#rTipoDoc').val(TipoDoc);
                    $('#rBanco').val(Banco);
                    $('#rFolioDoc').val(FolioDoc);
                    $('#rFechaDoc').val(FechaDoc);
                    $('#rFolioCheque').val(); //Pendiente
                    $('#rTipoPago').val(TipoPago);
                    $('#rUsuarioPago').text(UsuarioPago);
                    $('#rFechaPagoCreada').text(FechaPagoCredada);
                    $('#rMonedaPago').val(MonedaPago);
                    $('#rTipoCambio1').val(Number(TipoCambPago).toFixed(4));
                    $('#rImportePago').val(numberFormat.format(ImportePago).split('$')[1]);
                    $('#rTipoCambio2').val(Number(TipoCambDoc).toFixed(4));
                    $('#rImporteReal').val(numberFormat.format(ImporteReal).split('$')[1]);
                    $('#rNumLiq').val(NumLiq);
                    $('#rFolioLiq').val(); //Pendiente
                    $('#rFechaLiq').val(FLiquid);
                    $('#rConfLiq').val(ConfLiq); //Pendiente
                    $('#rFechaConf').val(); //Pendiente
                    $('#rUsuarioLiq').text(UsuarioLiq);
                    $('#rFechaPagoLiq').text(FechaPagoLiq);
                    $('#rObervRecibo').val(Observaciones);

                //Panel 4: Comisiones de agente ----------> El reporte de comisiones es el contiene el folio de liquidación y no el reporte de recibos, solicitar el reporte de comsiones para toda la información de esta sección
                    const TipoAgente = valor(rcb[r].VendAbreviacion);
                    const TipoCom ="Comisión Base o de Neta";
                    const CGenerada = valor(rcb[r].ComisionAge);
                    const Aplicado = valor(rcb[r].Renovable_TXT);
                    const Com00 = valor(rcb[r].Comision0PP);
                    const Com01 = valor(rcb[r].Comision1PP);
                    const Com02 = valor(rcb[r].Comision2PP);
                    const Com03 = valor(rcb[r].Comision3PP);
                    const Com04 = valor(rcb[r].Comision4PP);
                    const Com05 = valor(rcb[r].Comision5PP);
                    const Com06 = valor(rcb[r].Comision6PP);
                    const Com07 = valor(rcb[r].Comision7PP);
                    const Com08 = valor(rcb[r].Comision8PP);
                    const Com09 = valor(rcb[r].Comision9PP);
                    const Com10 = valor(rcb[r].Comision10PP);
                    const Com11 = valor(rcb[r].Comision11PP);
                    const Com12 = valor(rcb[r].Comision12PP);
                    const Com13 = valor(rcb[r].Comision13PP);
                    const Com14 = valor(rcb[r].Comision14PP);
                    const Com15 = valor(rcb[r].Comision15PP);
                    const Com16 = valor(rcb[r].Comision16PP);
                    var ComPend = Number(Com00)+Number(Com01)+Number(Com02)+Number(Com03)+Number(Com04)+Number(Com05)+Number(Com06)+Number(Com07)+Number(Com08)+Number(Com09)+Number(Com10)+Number(Com11)+Number(Com12)+Number(Com13)+Number(Com14)+Number(Com15)+Number(Com16);

                    const FPL1 = fecha(rcb[r].FCreateLiq);
                    var FPL = new Date(rcb[r].FCreateLiq);
                    var FPL2 = FPL.getDate() + "/" + numeromeses[FPL.getMonth()] + "/" + FPL.getFullYear();

                    var CodgAgente = optionSelect(rcb[r].CAgente);
                    var TipComs = optionSelect(TipoCom);

                    trtd3 += `
                        <tr data-id="${rcb[r].IDPagoRec}">
                            <th colspan="24">
                                <a type="button" class="btn-vend-hon" data-agent="${rcb[r].IDAgente}" onclick="ComisionAgente(this)">
                                    <i class="fa fa-minus-square" data-class="fa fa-minus-square" style="font-size:15px"></i>
                                </a>
                                <h5 class="title-vend">Nombre de Agente: ${AgenteNombre} - ${rcb[r].CAgente}</h5>
                            </th>
                        </tr>
                        <tr class="filaCAgente" id="tb-v-${rcb[r].IDAgente}" style="background:white;">
                            <td>${TipoAgente}</td>
                            <td>${TipoCom}</td>
                            <td>${numberFormat.format(PrimaNeta)}</td>
                            <td>${PorcentajeNeta.toFixed(2)}</td>
                            <td>${numberFormat.format(CGenerada)}</td>
                            <td>${numberFormat.format(ComPend)}</td>
                            <td>${Aplicado}</td>
                            <td>${FPL1}</td>
                            <td>${FPL2}</td>
                        </tr>`;

                    $('#rAgenteComision').html(CodgAgente);
                    $('#rNombreAg').val(rcb[r].AgenteNombre);
                    $('#rTipoComis').html(TipComs); //Pendiente
                    $('#rPartComAg').val(PorcentajeNeta.toFixed(2));
                    $('#rGnrd').val(numberFormat.format(CGenerada).split('$')[1]);
                    $('#rComPend').val(numberFormat.format(ComPend).split('$')[1]); //Pendiente
                    $('#rFechaCreacion').val(FechaPagoLiq);
                    $('#rComUsuarioLiq').text(UsuarioLiq);

                    trtd4 += `
                        <tr data-id="${rcb[r].IDPagoRec}">
                            <td>${FPL1}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>${Moneda}</td>
                        </tr>`;
                }

                for (var h in hnr) {
                    //GS1050184-8, 497-2405-1

                    //Parte 5: Honorarios de vendedor
                    const HonBase = valor(hnr[h].TipoComVE);
                    const TipoValor = valor(hnr[h].TipoValor);
                    const BaseCalculo = valor(hnr[h].ComPagada);
                    const PartHonorario = valor(hnr[h].PorPart);
                    //const Formula = valor(hnr[h].);
                    const Importe = valor(hnr[h].Importe);
                    const DocPago = valor(hnr[h].DoctoPago);
                    const VendHon = valor(hnr[h].VendNombre);

                    //Fechas
                    const FechaPago = fecha(hnr[h].FPago);

                    var Pagado = "";
                    if (hnr[h].Pagado == "true") {
                        Pagado = "Sí";
                    }
                    else {
                        Pagado = "No";
                    }

                    var Formula = "";
                    if (HonBase == "Honorario Base") {
                        Formula = "HONORARIOS BASE O NETA";
                    }
                    else if (HonBase == "Honorario Adicional 1") {
                        Formula = "HONORARIOS DERECHO Y RECARGO";
                    }

                    trtd5 += `
                        <tr data-id="${hnr[h].IDVend}">
                            <th colspan="24">
                                <a type="button" class="btn-vend-hon" data-vend="${hnr[h].IDVend}" onclick="HonorarioVend(this)">
                                    <i class="fa fa-minus-square" data-class="fa fa-minus-square" style="font-size:15px"></i>
                                </a>
                                <h5 class="title-vend">Vendedor: ${VendHon}</h5>
                            </th>
                        </tr>
                        <tr class="filaHonorario" id="tb-h-${hnr[h].IDVend}" data-id="${hnr[h].IDHon}" data-vend="${hnr[h].IDVend}" style="background:white;">
                            <td>${HonBase}</td>
                            <td>${TipoValor}</td>
                            <td>${numberFormat.format(BaseCalculo)}</td>
                            <td>${numberFormat.format(PartHonorario)}</td>
                            <td>${Formula}</td>
                            <td>${numberFormat.format(Importe)}</td>
                            <td>${Pagado}</td>
                            <td>${FechaPago}</td>
                            <td>${DocPago}</td>
                        </tr>`;
                    
                }
                $('.list-table-registro-pago-body').html(trtd1);
                $('.list-table-comisiones-agente-body').html(trtd3);
                $('.list-table-pagos-comision-body').html(trtd4);
                $('.list-table-honorario-vendedor-body').html(trtd5);

                $('.filaHonorario').click(function() { //497-2405-1
                    const idHon = $(this).data('id');
                    const idVend = $(this).data('vend');
                    //console.log(idVend);

                    for (var n in hnr) {
                        const Hnon = hnr[n].IDHon;
                        const VendHon = valor(hnr[n].VendNombre);
                        const HonBase = valor(hnr[n].TipoComVE);
                        const TipoValor = valor(hnr[n].TipoValor);
                        const PartHonorario = valor(hnr[n].PorPart);
                        const Importe = valor(hnr[n].Importe);
                        const DocPago = valor(hnr[n].DoctoPago);
                        const FolioLiq = valor(hnr[n].FolioLiq);
                        const MonedaPago = valor(hnr[n].MonedaP);
                        const MonedaDoc = valor(hnr[n].Moneda);
                        const TipoCambPago = valor(hnr[n].TCPago);
                        const TipoCambDoc = valor(hnr[n].TCDocto);
                        const NombreUsuario = valor(hnr[n].NombreUsuario);
                        const ImportePago = valor(hnr[n].ImporteP);

                        const FechaPago = fecha(hnr[n].FPago);
                        var FchCreacion = new Date(hnr[n].FCreacion);
                        var FCreacion = nombredias[FchCreacion.getDay()] + " " + numerodias[FchCreacion.getDate()] + " de " + nombremeses[FchCreacion.getMonth()] + " de " + FchCreacion.getFullYear() + " " + FchCreacion.toLocaleTimeString('en-US');

                        var Formula = "";
                        if (HonBase == "Honorario Base") {
                            Formula = "HONORARIOS BASE O NETA";
                        }
                        else if (HonBase == "Honorario Adicional 1") {
                            Formula = "HONORARIOS DERECHO Y RECARGO";
                        }

                        var nameVend = optionSelect(VendHon);
                        var typeHon = optionSelect(HonBase);
                        var typeValor = optionSelect(TipoValor);
                        var FormulaSelect = optionSelect(Formula);

                        if (idHon == Hnon) {
                            $('#rVendedorHon').html(nameVend);
                            $('#rTipoHonorario').html(typeHon);
                            $('#rTipoValor').html(typeValor);
                            $('#rFormula').html(FormulaSelect);
                            $('#rPartH').val(numberFormat.format(PartHonorario).split('$')[1]);
                            $('#rImporteH').val(numberFormat.format(Importe).split('$')[1]);
                            $('#rFechaCreacionH').val(FCreacion);
                            $('#rDocumentoH').val(DocPago);
                            $('#rFolioH').val(FolioLiq);
                            $('#rFechaPagoH').val(FechaPago);
                            $('#rMonedaPagoH').val(MonedaPago);
                            $('#rMonedaDoctoH').val(MonedaDoc);
                            $('#rTipoCambioH1').val(Number(TipoCambPago).toFixed(6));
                            $('#rTipoCambioH2').val(Number(TipoCambDoc).toFixed(6));
                            $('#rUsuarioLiqH').text(NombreUsuario);
                            $('#rImportePagoH').val(numberFormat.format(ImportePago).split('$')[1]);
                        }
                    }
                })
            },
            error: (error) => {
                console.log("Hay problemas al buscar información del recibo.");
            }
        })

        $(".detalles-recibo-modal").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    }

    function ComisionAgente(event) {
        const agent = $(event).data('agent');
        const icon = $(event).children('i');

        $('#tb-v-'+agent).toggle(300, "easeInOutQuint");

        icon.attr('class', icon.hasClass('fa fa-minus-square') ? 'fa fa-plus-square' : icon.attr('data-class'));
    }

    function HonorarioVend(event) {
        const vend = $(event).data('vend');
        const icon = $(event).children('i');

        $('#tb-h-'+vend).toggle(300, "easeInOutQuint");

        icon.attr('class', icon.hasClass('fa fa-minus-square') ? 'fa fa-plus-square' : icon.attr('data-class'));
    }
    
</script>