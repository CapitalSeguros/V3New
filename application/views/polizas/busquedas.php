<!-- Sección de Búsqueda de Polizas-->
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="title-Polizas">Pólizas</h3></div>
		<div class="col-md-6 col-sm-7 col-xs-7"></div>
	</div>
	<hr/>
	<div class="col-md-12 column-select">
        <div class="modal-content content-search" id="PanelBusqueda" style="">
            <div class="modal-header header-search" id="seccionSearch" style="">
                <div class="input-group" id="busqueda" style="display:flex;">
                    <select class="input-group-text select-buscar input-width" id="SelectSearch" title="Tipo de búsqueda">
                        <option class="opt-search" value="0">Buscar por</option>
                        <option class="opt-search" value="1">Documento</option>
                        <option class="opt-search hidden" value="2">Documento por grupo</option>
                        <? if($IDVend==0){ ?>
                        <option class="opt-search" value="3">Cliente</option>
                    <? } ?>
                        <option class="opt-search hidden" value="4">Cliente por grupo</option> <!-- Pendiente -->
                        <option class="opt-search" value="5">Serie</option>
                        <option class="opt-search" value="6">Placas</option>
                        <option class="opt-search" value="7">Endoso</option>
                    </select>
                    <input type="text" class="form-control textSearch" id="text-search" placeholder="Buscar" style="width:0%;  z-index:0;"> <!-- 86% -->
                    <button class="input-group-text btn-buscar" id="SearchPoliza" title="Buscar" onclick="BuscarDatos()">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                    <button class="input-group-text btn-limpiar" id="LimpiarBusqueda" title="Limpiar">
                        <i class="fa fa-eraser" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
	<div class="col-md-12 column-info-documents">
        <!-- Sección de Resultados --> 
        <div class="col-md-5 content-result">
            <!-- Resultados búsqueda -->
            <div class="segment-p-search" id="PanelResultadosBusqueda">
        	    <div class="modal-header segment-header-result">
                    <div class="col-md-9 content-tab-r1">
        	           <h4 class="title-result" id="TituloBusquedas">Resultados de búsqueda</h4>
                    </div>
                    <div class="col-md-3 content-tab-r2">
                        <button class="btn btn-Refresh-r hidden" title="Recargar" onclick="BuscarDatos()">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </button>
                    </div>
        	    </div>
        	    <div class="modal-body table-body-result tab-content bg-tab-content" style="padding: 10px;">
        	        <div class="col-md-12 container-table-result tab-pane active" id="view-table-documents"></div>
        	    </div>
        	</div>
        </div>
        <div class="col-md-7 tab-column-two">
        <!-- Pestañas de opciones del tabular -->
            <div class="col-md-12 tab-items"> <!-- width: 285px; -->
                <ul class="nav nav-tabs" id="Nav-Tab-Polizas">
                    <li class="nav-item active" id="Tab-P1">
                    <a class="nav-tab-link active" aria-current="page" id="VerPanelP1" href="#PanelP1" role="tab" data-toggle="tab">
                        Búsqueda
                    </a>
                </li>
                    <li class="nav-item" id="Tab-P3">
                    <a class="nav-tab-link" aria-current="page" id="VerPanelP3" href="#PanelP3" role="tab" data-toggle="tab">
                        Centro Digital
                    </a>
                </li>
                <?php 
                if($this->tank_auth->get_idPersona()!=1102){?>
                    <li class="nav-item" id="Tab-P4">
                    <a class="nav-tab-link" aria-current="page" id="VerPanelP4" href="#PanelP4" role="tab" data-toggle="tab">
                        Enviar Correo
                    </a>
                </li>
                    <li class="nav-item" id="Tab-P5">
                        <a class="nav-tab-link" aria-current="page" id="VerPanelP5" href="#PanelP5" role="tab" data-toggle="tab">
                            Agregar Comentario
                        </a>
                    </li>
                    <li class="nav-item hidden" id="Tab-P6">
                        <a class="nav-tab-link" aria-current="page" id="VerPanelP6" href="#PanelP6" role="tab" data-toggle="tab">
                            Agregar Archivos
                        </a>
                    </li>
                <?php }?>
            </ul>
        </div>
        <!-- Paneles de las pestañas del tabular -->
            <div class="tab-content bg-tab-content-poliza" id="nav-panel-info-recibos">
            <!-- Panel 1: Detalles de los resultados de búsqueda -->
            <? $this->load->view('polizas/tabP1') ?>
                <!-- Panel 3: Centro Digital -->
                <? $this->load->view('polizas/tabP3') ?>
                <!-- Panel 4: Enviar Correo -->
            <? $this->load->view('polizas/tabP4') ?>
                <!-- Panel 5: Agregar Comentario -->
                <? $this->load->view('polizas/tabP5') ?>
                <!-- Panel 6: Subir Archivos -->
                <? $this->load->view('polizas/tabP6') ?>
        </div>
    </div>
    </div>
</section>

<? $this->load->view('polizas/modalRecibos') ?>
<? $this->load->view('polizas/modalCentroDigital') ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<!-- <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script> -->
<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/polizas.css">
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script src="<?=base_url()?>/assets/gap/js/jquery.validate.js"></script>
<script type="text/javascript">
    //Ejemplo documento: 93586R01 | 13514K03 | 05-066-07000117-00000-09 | 0000123305-6 | GS1050184-8 | GMMI-4033-15 | 38214220 | VGPO-000002-87 | SDA059710000
    //Demo: OT-0000064932 | OT-0000061843 | HERRERA1T BUENO1T Alejandro Demo 1T
    //Ejemplo nombre: huchim medina
    //Ejemplo serie: 3N1CK3CS9FL235369 -> 0880271801
    //Ejemplo placa: YZF1235
    //Ejemplo endoso: CL22955600-0
	$(document).ready(function() {
		$('#text-search').keyup(function(e) {
			if (e.keyCode == 13) {
                BuscarDatos();
            }
		})

		$('#LimpiarBusqueda').click(function() {
            $('#text-search').val('');
		})

        $('#SelectSearch').change(function() {
            const valor = document.getElementById('SelectSearch').value;
            if (valor == 1 || valor == 3) {
                $('#Tab-P6').removeClass('hidden');
                $('#PanelP6').removeClass('hidden');
            }
            else {
                $('#Tab-P6').addClass('hidden');
                $('#PanelP6').addClass('hidden');

                if ($('#Tab-P6').hasClass('active')) {
                    $('#Tab-P6').removeClass('active');
                    $('#PanelP6').removeClass('active');
                    $('#VerPanelP6').removeClass('active');
                    $('#Tab-P1').addClass('active');
                    $('#PanelP1').addClass('active');
                    $('#VerPanelP1').addClass('active');
                }
            }
        })
	})

    const baseUrl = '<?=base_url()?>polizas';
    var TypeSearch = "";
    var PrimaNetaTotal = "";
    var PrimaPendiente = "";
    var PrimaTotalPoliza = 0;
    var PrimaVigenciaAnterior = 0;
    var PrimaTotalDocAnterior = 0;
    var P1NombresCliente = "";
    var P1TextRamo = "";
    var P1Documento = "";
    var P1CiaAbreviacion = "";
    var P1Vigencia = "";
    var P1FPago = "";
    var P1PrimaRenovacion = 0;
    var P1Email1 = "";
    var P1Email2 = "";
    var P1PrimaTotalRecibo1 = 0;
    var P1LimitePagoRecibo1 = "";
    var P1PorcjRenv = 0.00;
    var D1IDCli = "";
    var D1IDDocto = "";

    //Formato Fechas
    var nombremeses = new Array ("Enero","Feb","Mar","Abr","May","Jun","Jul","Ago","Sept","Oct","Nov","Dic");
    var numeromeses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
    var nombredias = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
    var numerodias = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");

    //Formato Monetario
    const money = { style: 'currency', currency: 'MXN' };
    const numberFormat = new Intl.NumberFormat('es-MX', money);

    function BuscarDatos() {
        TypeSearch = document.getElementById('SelectSearch').value;
        var dato = document.getElementById('text-search');
        var info = $(dato).val();
        console.log("Datos a buscar: " + info + ", " + TypeSearch);
        const content =  document.getElementById('TextBodyEmail');
        content.style.padding = "15px";
        $('#TipoCorreo').text("1");
        $('#QuitarP').addClass('hidden');
        $(content).html("");
        $('#TextEndEmail').val("");
        $('#BorrarTodo').click();
        $('#CargarArchivo').prop('disabled',true);
        $('#TabP6-Spinner').html("");

        if (TypeSearch != 0 && info != 0) {
            $.ajax({
                type: "GET",
                url: `${baseUrl}/BusquedaPolizas`,
                data: {
                    search: info,
                    type: TypeSearch
                },
                beforeSend: (load) => {
                    $('#view-table-documents').html(`
                        <div class="container-spinner-table-polizas">
                            <div class="bd-spinner spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <p class="bd-cargando" style="font-size:18px;">Cargando...</p>
                        </div>
                    `);
                    document.getElementById('comentarioPolizaBody').innerHTML='';
                    document.getElementById('bitacoraDeComentariosDiv').innerHTML='';
                },
                success: (data) => {
                    const r = JSON.parse(data);
                    //console.log(r);
                    //console.log(data);

                    if (TypeSearch != 1) {
                        $('#PlantillasCorreo').addClass('hidden');
                    }
                    else {
                        $('#PlantillasCorreo').removeClass('hidden');
                    }

                    $('#view-table-documents').html("");
                    $(".list-table-resultados-body").html("");
                    var thead = ``;
                    var trtd = ``;
                    
                    if (TypeSearch == 1 || TypeSearch == 2 || TypeSearch == 9) {
                        $('#TitleAddFile').text('Agregar archivos al documento o al cliente');
                        thead += `
                            <table class="table table-resultados" id="TableResultadosBusqueda" style="margin-bottom:0px;">
                                <thead style="position:sticky; top:0px;">
                                    <tr style="background: #266093;">
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
                            var TipoDoc = "0";

                           /*  if (TipoDocto_TXT == "Póliza" || TipoDocto_TXT == "Solicitud") {
                                TipoDoc = "1";
                            }
                            else if (TipoDocto_TXT == "Fianza") {
                                TipoDoc = "2";
                            } */

                            trtd += `
                                <tr class="filaResultados" data-id="${r[a].IDDocto}" data-clave="${r[a].ClaveBit}" data-name="${r[a].Documento}" data-type="1" data-document="${r[a].TipoDocto}" onclick="ClickResultado(this)">
                                    <td>${TipoDocto_TXT}</td>
                                    <td>${Documento}</td>
                                    <td>${Inciso}</td>
                                    <td>${NombreCompleto}</td>
                                    <td>${Solicitud}</td>
                                </tr>`;
                        }
                    }
                    else if (TypeSearch == 3 || TypeSearch == 4) {
                        $('#TitleAddFile').text('Agregar archivos al cliente');
                        thead += `
                            <table class="table table-resultados" id="TableResultadosBusqueda" style="margin-bottom:0px;">
                                <thead style="position:sticky; top:0px;">
                                    <tr style="background: #266093;">
                                        <th class="hidden" scope="col">Tipo Entidad</th>
                                        <th scope="col">Nombre Completo</th>
                                        <th scope="col">Grupo</th>
                                        <th class="hidden" scope="col"></th>
                                        <th class="hidden" scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="list-table-resultados-body"></tbody>
                            </table>`;

                        for(var b in r) {
                            const NombreCompleto = valor(r[b].NombreCompleto);         
                            const Grupo = valor(r[b].Grupo);

                            trtd += `
                                <tr class="filaResultados" data-id="${r[b].IDCli}" data-clave="${r[b].ClaveBit}" data-name="${r[b].NombreCompleto}" data-type="3" data-document="0" onclick="ClickResultado(this)">
                                    <td class="hidden"></td>
                                    <td>${NombreCompleto}</td>
                                    <td>${Grupo}</td>
                                    <td class="hidden"></td>
                                    <td class="hidden"></td>
                            </tr>`;
                        }
                    }
                    else if (TypeSearch == 5) {

                        thead += `
                            <table class="table table-resultados" id="TableResultadosBusqueda" style="margin-bottom:0px;">
                                <thead style="position:sticky; top:0px;">
                                    <tr style="background: #266093;">
                                        <th class="hidden" scope="col">Placas</th>
                                        <th scope="col">Documento</th>
                                        <th scope="col">Serie</th>
                                        <th scope="col">Inciso</th>
                                        <th scope="col">Estado (Circulación)</th>
                                    </tr>
                                </thead>
                                <tbody class="list-table-resultados-body"></tbody>
                            </table>`;

                        for(var c in r) {
                            const Documento = valor(r[c].Documento);         
                            const Inciso = valor(r[c].Inciso);
                            const Serie = valor(r[c].Serie);         
                            //const Servicio = valor(r[c].Servicio);
                            const Estado = valor(r[c].EstadoCircula);

                            trtd += `
                                <tr class="filaResultados" data-id="${r[c].IDDocto}" data-clave="${Documento}" data-name="${r[c].Serie}" data-type="5" data-document="0" onclick="ClickResultado(this)">
                                    <td class="hidden"></td>
                                    <td>${Documento}</td>
                                    <td>${Serie}</td>
                                    <td>${Inciso}</td>
                                    <td>${Estado}</td>
                            </tr>`;
                        }
                    }
                    else if (TypeSearch == 6) {

                        thead += `
                            <table class="table table-resultados" id="TableResultadosBusqueda" style="margin-bottom:0px;">
                                <thead style="position:sticky; top:0px;">
                                    <tr style="background: #266093;">
                                        <th class="hidden" scope="col">Serie</th>
                                        <th scope="col">Documento</th>
                                        <th scope="col">Placas</th>
                                        <th scope="col">Inciso</th>
                                        <th scope="col">Estado (Circulación)</th>
                                    </tr>
                                </thead>
                                <tbody class="list-table-resultados-body"></tbody>
                            </table>`;

                        for(var c in r) {
                            const Documento = valor(r[c].Documento);         
                            const Inciso = valor(r[c].Inciso);
                            const Serie = valor(r[c].Serie);         
                            //const Servicio = valor(r[c].Servicio);
                            const Estado = valor(r[c].EstadoCircula);
                            const Placas = valor(r[c].Placas);

                            trtd += `
                                <tr class="filaResultados" data-id="${r[c].IDDocto}" data-clave="${Documento}" data-name="${r[c].Serie}" data-type="5" data-document="0" onclick="ClickResultado(this)">
                                    <td class="hidden">${Serie}</td>
                                    <td>${Documento}</td>
                                    <td>${Placas}</td>
                                    <td>${Inciso}</td>
                                    <td>${Estado}</td>
                            </tr>`;
                        }
                    }
                    else if (TypeSearch == 7) {
                        thead += `
                            <table class="table table-resultados" id="TableResultadosEndosos" style="margin-bottom:0px;">
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
                                <tbody class="list-table-resultados-body"></tbody>
                            </table>`;

                        for(var d in r) {
                            const Endoso = valor(r[d].Endoso);
                            const FEmision = valor(r[d].FEmision);

                            if (Endoso != 0 && FEmision != 0) {
                                const Documento = valor(r[d].Documento);
                                const Inciso = valor(r[d].Inciso);
                                const Tipo = valor(r[d].Tipo_TXT);
                                const Cliente = valor(r[d].NombreCompleto);
                                const Grupo = valor(r[d].Grupo);
                                const SubGrupo = valor(r[d].SubGrupo);
                                const Desde = fecha(r[d].FDesde);
                                const HastaPoliza = fecha(r[d].FHastaPoliza);

                                trtd += `
                                    <tr class="selectEndoso" data-id="${r[d].IDEnd}" data-recibo="${r[d].IDRecibo}" data-name="${Endoso}" data-type="7">
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
                    }

                    $('#view-table-documents').html(thead);
                    $(".list-table-resultados-body").html(trtd);
                    $('#TableResultadosBusqueda').DataTable({
                        language: {
                            url: `<?=base_url()?>assets/js/espanol.json`
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
                            sortable: false,
                            orderable: false,
                        },
                        {
                            sortable: false,
                            orderable: false,
                        }],
                        order: [['1', 'asc']],
                    });
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

                        $('#TituloDetalles').text('Detalles del Endoso');
                        $('#SelectDocument').text('(' + name + ')');

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

                        for (var f in r) {
                            const Endoso = r[f].Endoso;
                            const Documento = valor(r[f].Documento);
                            const Estatus = valor(r[f].StatusEnd_Txt);
                            const Cliente = valor(r[f].NombreCompleto);
                            const RFC = valor(r[f].RFC);
                            const SubRamo = valor(r[f].SRamoNombre);
                            const FormPago = valor(r[f].FPago);
                            const Grupo = valor(r[f].Grupo);
                            const SubGrupo = valor(r[f].SubGrupo);
                            const Compania = valor(r[f].CiaNombre);
                            const Moneda = valor(r[f].Moneda);
                            const Inciso = valor(r[f].Inciso);
                            const CAgente = "[" + valor(r[f].CAgente) + "] ";
                            const AgenteNombre = valor(r[f].AgenteNombre);
                            const TCambio = valor(r[f].TCPago);
                            const Referencia1 = valor(r[f].Referencia1);
                            const Referencia2 = valor(r[f].Referencia2);
                            const Concepto = valor(r[f].Concepto);
                            const rPrimaNeta = valor(r[f].PrimaNeta);
                            const rDescuento = valor(r[f].Descuento);
                            const rExtraPrima = valor(r[f].ExtraPrima);
                            const rRecargos = valor(r[f].Recargos);
                            const rDerechos = valor(r[f].Derechos);
                            const rSubTotal = valor(r[f].STotal);
                            //const rInversion = valor(r[f].);
                            const Impuesto1 = valor(r[f].Impuesto1);
                            const Impuesto2 = valor(r[f].Impuesto2);
                            const rAjuste = valor(r[f].Ajuste);
                            const rPrimaTotal = valor(r[f].PrimaTotal);
                            const RegUsuario = valor(r[f].UserCreadorEnd);

                            //Option
                            const select1 = optionSelect(r[f].Documento);
                            const select2 = optionSelect(r[f].Endoso);
                            const select3 = "<option>Endoso</option>";
                            const Tipo = optionSelect(r[f].Tipo_TXT);
                            const StatusUser = optionSelect(r[f].StatusUserDoc_Txt);

                            //Fechas
                            const FStatus = fecha(r[f].FStatus);
                            const Desde = fecha(r[f].FDesdePoliza);
                            const Hasta = fecha(r[f].FHastaPoliza);
                            const FDesde = formatDate(r[f].FDesdeDocto);
                            const FHasta = formatDate(r[f].FHastaDocto);
                            const FEmision = formatDate(r[f].FEmision);
                            var FCreate = fecha(r[f].FCapturaDocto);
                            var HCreate = new Date(r[f].FCapturaDocto);
                            if (FCreate != 0) {
                                FCreate = FCreate + " " + HCreate.toLocaleTimeString('en-US');
                            }
                            else {
                                FCreate = "";
                            }

                            //Sumas
                            const rIVA = Number(Impuesto1) + Number(Impuesto2);
                            PrimaNeta += parseFloat(r[f].PrimaNeta);
                            Descuento += parseFloat(r[f].Descuento);
                            ExtraPrima += parseFloat(r[f].ExtraPrima);
                            Recargos += parseFloat(r[f].Recargos);
                            Derechos += parseFloat(r[f].Derechos);
                            SubTotal += parseFloat(r[f].STotal);
                            PrimaTotal += parseFloat(r[f].PrimaTotal);
                            Neta += parseFloat(r[f].Comision0);
                            cExtraPrima += parseFloat(r[f].Comision1); //Por confirmar
                            cRecargos += parseFloat(r[f].Comision2);
                            cDerechos += parseFloat(r[f].Comision3); //Por confirmar
                            Especial += parseFloat(r[f].Comision4); //Por confirmar

                            //Porcentaje
                            var PrctjDescuento = (100 / Number(PrimaNeta)) * Number(Descuento); //r[f].PorDesc
                            var PrctjExtraPrima = (100 / Number(PrimaNeta)) * Number(ExtraPrima); //r[f].PorExtraP
                            var PrctjRecargos = (100 / Number(PrimaNeta)) * Number(Recargos); //r[f].PorRecargos
                            var PrctjIVA = (100 / Number(SubTotal) * Number(IVA)); //Number(r[f].PorImp1)+Number(r[f].Imp2)
                            var PrctjNeta = (100 / Number(PrimaNeta)) * Number(Neta); //r[f].PorCom0
                            var PrctjExtPri = (100 / Number(PrimaNeta)) * Number(cExtraPrima);
                            var PrctjRecrgs = (100 / Number(PrimaNeta)) * Number(cRecargos);
                            var PrctjDerchs = (100 / Number(PrimaNeta)) * Number(cDerechos);
                            var PrctjEspcl = (100 / Number(PrimaNeta)) * Number(Especial);

                            if (name == Endoso) { //CL22955600-0
                                if (FEmision != 0) {
                                    $('#EnBuscar').html(select1);
                                    $('#EnEndosos').html(select2);
                                    $('#EnStatus').text(Estatus);
                                    $('#EnVigente').text(FStatus);
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
                        $('#Content-Info-Busqueda').addClass('hidden');
                        $('#Content-Endosos').removeClass('hidden');
                    });
                },
                error: (error) => {
                    swal("¡Uups!", "Ha ocurrido un problema.", "error");
                }
            })
        }
        else if (TypeSearch == 0 && info == 0) {
            swal("No hay nada que buscar.");
        }
        else if (TypeSearch == 0) {
        	swal("¡Espera!", "Debes seleccionar el tipo de búsqueda.", "warning");
        }
        else if (info == 0) {
        	swal("¡Espera!", "Debes escribir lo que quieres buscar.", "warning");
        }
    }
    
    function ClickResultado(dato) {
        const id = $(dato).data('id');
        const bit = $(dato).data('clave');
        const doc = $(dato).data('name');
        const tipodoc = $(dato).data('document');

        if(document.getElementsByClassName('seleccionResult')[0]){
            document.getElementsByClassName('seleccionResult')[0].classList.remove('seleccionResult');
        }
        dato.classList.add('seleccionResult');

        $('#TituloDetalles').text('Detalles del documento');
        $('#SelectDocument').text('(' + doc + ')');
        $('#BorrarTodo').click();
        $('#CargarArchivo').prop('disabled',true);
        $('#TabP6-Spinner').html("");

        $.ajax({
            type: "GET",
            url: `${baseUrl}/ResultadoPolizas`,
            data: {
                id: id,
                cb: bit,
                tp: TypeSearch,
                dc: doc,
                td: tipodoc,
            },
            beforeSend: (load) => {
                $('.content-solicitudes-y-polizas').html(`
                    <div class="container-spinner-content-solicitudes-polizas">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);

                $('#CentroDigitalCli').html(`
                    <div class="container-spinner-content-solicitudes-polizas">
                        <div class="tr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="bd-cargando" style="font-size:18px;margin:0px;">Espere por favor.</p>
                        <p class="bd-cargando" style="font-size:18px;">Esto puede tardar unos momentos...</p>
                    </div>
                `);

                $('#CentroDigitalDoc').html(`
                    <div class="segment-p-centrodigital" id="CentroDigitalDoc" style="height:auto; padding-bottom:0px;">
                    </div>
                `);

                $('#SpinnerEmail').html(`
                    <div class="container-spinner-content-plantilla">
                        <div class="spinner-grow" role="status" style="width: 1rem; height: 1rem;">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);

                $('#SpinnerDocCD').html(`
                    <div class="container-spinner-content-plantilla">
                        <div class="spinner-grow" role="status" style="width: 1rem; height: 1rem;">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);

                $('#PlantillaRenovacion').prop('disabled',true);
                $('#FileCD').prop('disabled',true);
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                let doc = r['documentos']; //Una sola fila de dato
                let sre = r['serie'];
                let end = r['endosos'];
                DocumentsCD(TypeSearch,doc.IDCli,doc.Documento);
                ModalDocsCD(doc.IDCli,doc.Documento);
                $('.content-solicitudes-y-polizas').html("");
                $(".list-table-recibos-body").html("");
                $(".list-table-totales-body").html("");
                //$(".list-table-pago-body").html("");
                $('#Endoso').html("");
                $('#CorreoCliente').html("");
                $('#cIDCli').val(doc.IDCli);
                var trtd1 = ``;
                var trtd2 = ``;
                var trtd3 = ``;
                var option = ``;
                var cc = ``;
                var ModalHeader = document.getElementById('Cabecera');
                var ColumnPrimas = document.getElementById('ColumnPrimas');

                //Cambio de formato string
                //var DPosterior = JSON.stringify(doc.DPosterior);

                //Cambio de valor
                const IDCli = valor(doc.IDCli);
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
                const Oficina = valor(doc.OfnaNombre);
                const LineaNegocio = valor(doc.LBussinesNombre);
                const StatusUser_TXT = valor(doc.StatusUser_TXT);
                const GerenciaNombre = valor(doc.GerenciaNombre);
                const DespNombre = valor(doc.DespNombre);
                const CCobro_TXT = valor(doc.CCobro_TXT);
                const Endoso = valor(doc.Endoso);
                const TipoPago = valor(doc.TipoPago);

                //Cambio de costos
                const PrimaNeta = valor(doc.PrimaNeta);
                const Descuento = valor(doc.Descuento);
                const ExtraPrima = valor(doc.ExtraPrima);
                const Recargos = valor(doc.Recargos);
                const Derechos = valor(doc.Derechos);
                const STotal = valor(doc.STotal);
                const Impuesto1 = valor(doc.Impuesto1);
                const Impuesto2 = valor(doc.Impuesto2);
                const IVA = Number(Impuesto1) + Number(Impuesto2);
                const PrimaTotal = valor(doc.PrimaTotal);

                //Cambio de formato fechas
                var Captura = new Date(doc.FCaptura);
                const FDesde = fecha(doc.FDesde);
                const FHasta = fecha(doc.FHasta); //Problema con 13514K03
                const FAntig = fecha(doc.FAntiguedad);
                const FEmisn = fecha(doc.FEmision);
                var FCaptr = fecha(doc.FCaptura);
                if (FCaptr != 0) {
                	FCaptr = fecha(doc.FCaptura) + ", " + Captura.toLocaleTimeString('en-US');
                }
                else {
                	FCaptr = "";
                }

                $('#NameClient').text("Cliente: " + NombreCompleto);
                $('#Content-Info-Busqueda').removeClass('hidden');
                $('#Content-Endosos').addClass('hidden');
                $('#FiltrarCD').removeClass('hidden');
                D1IDCli = IDCli;

                if (TypeSearch == 1) { //Documento
                    $('#Panel3').removeClass('hidden');
                    $('#NameDocument').text("Documento: " + Documento);
                    $('#VentPolizas').removeClass('hidden');
                    $('#VentClientes').addClass('hidden');
                    $('#SegBitacoras').removeClass('hidden');
                    $('#TituloDetalles').text("Solicitudes y pólizas");
                    $('#Parte1-Series').addClass('hidden');
                    $('#Parte4-Series').addClass('hidden');
                    $('#Parte2-Polizas').removeClass('hidden');
                    $('#Parte4-Polizas').removeClass('hidden');
                    $('#Parte8-Polizas').removeClass('hidden');
                    $('#CargarArchivo').prop('disabled',false);
                    //Colocar Endoso
                    if (end != 0) {
                        for (const a in end) {
                            const endosos = valor(end[a].Endoso);
                            option += `<option class="opt-search">${endosos}</option>`;
                        }
                    }
                    else{
                        option += `<option class="opt-search">Ninguno</option>`;
                    }

                    if (tipodoc == 1) {
                        $('#Parte1-Polizas').removeClass('hidden');
                        $('#Parte5-Polizas').addClass('hidden');
                        $('#Parte6-Polizas').addClass('hidden');
                        $('#Parte7-Polizas').addClass('hidden');
                        $('#Campo1').text("Recargos:");
                        $('#Campo2').text("Derechos:");

                        ColumnPrimas.style.height = "400px";
                    }
                    else if (tipodoc == 2) { //2768969
                        const GastAdm = valor(doc.GastosAdm);
                        const Monto = valor(doc.Monto);
                        const MontoTCContrato = valor(doc.MontoTCContrato);

                        $('#Parte1-Polizas').addClass('hidden');
                        $('#Parte5-Polizas').removeClass('hidden');
                        $('#Parte6-Polizas').removeClass('hidden');
                        $('#Parte7-Polizas').removeClass('hidden');
                        $('#Campo1').text("Derechos:");
                        $('#Campo2').text("Gastos maq:");
                        $('#Monto').val(numberFormat.format(Monto));
                        $('#MontoAcum').val(numberFormat.format(MontoTCContrato));
                        $('#GastosAdmin').val(numberFormat.format(GastAdm)); //Pendiente

                        ColumnPrimas.style.height = "auto";
                    }

                    ModalHeader.style.height = "34px"; //116, 43
                    const PPag = valor(doc.PPag);
                    const PPend = valor(doc.PPend);
                    PrimaNetaTotal = PrimaNeta;
                    PrimaPendiente = PPend;

                    TablaRecibos();
                    PanelBitacoras(bit);
                    DocAnterior(DAnterior);

                    //Llenado de información
                    $('#TipoDocumento').val(TipoDocto_TXT);
                    //$('#Poliza').val(doc.); //Pendiente
                    $('#Estatus').val(Status_TXT);
                    //$('#Folio').val(doc.FolioNo); //Pendiente FolioDocto solo en Recibos
                    $('#Documento').val(Documento);
                    const documento = document.querySelector("#Documento")
                    documento.dataset.tipodocto=doc.TipoDocto;
                    documento.dataset.iddocto=doc.IDDocto;
                    $('#Inciso').val(Inciso); //Pendiente
                    $('#Anterior').val(DAnterior);
                    $('#Posterior').val(DPosterior);
                    $('#Cliente').val(NombreCompleto);
                    const cliente = document.querySelector("#Cliente")
                    cliente.dataset.idcli=IDCli;
                    $('#RFC').val(RFC);
                    $('#Grupo').val(Grupo);
                    $('#SubGrupo').val(SubGrupo);
                    $('#Sub-SubGrupo').val(SSGrupo);
                    //$('#Expediente').val(doc.); //Pendiente
                    $('#Direccion').val(Calle + Colonia + Poblacion + Ciudad + Pais);
                    $('#SubRamo').val(SRamoNombre);
                    const subramo = document.querySelector("#SubRamo");
                    subramo.dataset.subramo=SRamoNombre.toUpperCase();
                    subramo.dataset.idsubramo=doc.IDSRamo;
                    $('#Agente').val(CAgente + AgenteNombre);
                    $('#Compania').val(AgenteNombre);
                    $('#Ejecutivo').val(EjecutNombre);
                    const ramo = document.querySelector("#Ejecutivo");
                    ramo.dataset.ramo=EjecutNombre.toUpperCase();
                    ramo.dataset.idejecutivo=doc.IDEjecut;
                    $('#Pago').val(FPago);
                    $('#Vendedor').val(VendNombre);
                    const vendedor = document.querySelector("#Vendedor")
                    vendedor.dataset.idvend=doc.IDVend;
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
                    $('#Oficina').val(Oficina);
                    $('#LineaNegocio').val(LineaNegocio);
                    $('#Despacho').val(DespNombre);
                    //$('#TipoCondCobro').val(doc.); //Pendiente
                    $('#CondCobro').val(CCobro_TXT);
                    $('#PrimaNeta').val(numberFormat.format(PrimaNeta));
                    $('#Descuento').val(numberFormat.format(Descuento));
                    $('#ExtraPrima').val(numberFormat.format(ExtraPrima));
                    $('#Recargos').val(numberFormat.format(Recargos));
                    $('#Derechos').val(numberFormat.format(Derechos));
                    $('#SubTotal').val(numberFormat.format(STotal));
                    $('#IVA').val(numberFormat.format(IVA));
                    $('#PrimaPend').val(PPend);
                    $('#PrimaTotal').val(numberFormat.format(PrimaTotal));
                    //$('#Endoso').val(Endoso); //Pendiente por el tipo de formato
                    $('#TipoPago').val(TipoPago);
                    $('#IDCont').val(doc.IDCont);
                    //$('#TipoVenta').val(doc.); //Pendiente

                    //Ejemplo: 93586R01 | 13514K03

                    trtd2 +=  `
                        <tr class="subtitle-table-body">
                            <td class="align-table-left">Total del documento</td>
                            <td class="align-money">${numberFormat.format(doc.PrimaNeta)}</td>
                            <td class="align-money">${numberFormat.format(doc.PrimaTotal)}</td>
                        </tr>
                        <tr class="subtitle-table-body">
                            <td class="align-table-left">Número de pagos</td>
                            <td class="align-money" id="NumPagos"></td>
                            <td class="align-money"></td>
                        </tr>
                        <tr class="subtitle-table-body">
                            <td class="align-table-left">Total pagado</td>
                            <td class="align-money" id="SumaRecibos"></td> <!-- Suma de las PrimaNeta de los recibos -->
                            <td class="align-money">${numberFormat.format(PPag)}</td>
                        </tr>
                        <tr class="subtitle-table-body">
                            <td class="align-table-left">Total pendiente</td>
                            <td class="align-money" id="TotalNetaPendiente"></td> <!-- PrimaNetaTotal - PrimaPendiente -->
                            <td class="align-money" id="PrimaTotalPendiente"></td>
                        </tr>`;

                    trtd3 += `
                        <tr name="ListaOpcionesPago" data-id="" style="font-size:13px;">
                            <td></td> <!-- Opcion de pago -->
                            <td></td> <!-- Tarjeta -->
                            <td></td> <!-- Campo a solicitar -->
                            <td></td> <!-- Identificador de descuento -->
                            <td></td> <!-- Descripción -->
                        </tr>`;

                    //Información de la Plantilla Renovación
                    const Nombres = valor(doc.Nombre) + " ";
                    const ApellidoP = valor(doc.ApellidoP) + " ";
                    const ApellidoM = valor(doc.ApellidoM);
                    const MarcaA = valor(sre.Marca);
                    const TipoA = valor(sre.Tipo);
                    const ModeloA = valor(sre.Modelo);
                    const PlacasA = valor(sre.Placas);
                    const FDesdePoliza = fecha(doc.FDesdePoliza);
                    const FHastaPoliza = fecha(doc.FHastaPoliza);
                    const P1Automovil = MarcaA + " " + TipoA + " " + ModeloA;
                    const P1Placas = PlacasA;
                    P1Documento = Documento;
                    P1CiaAbreviacion = valor(doc.CiaAbreviacion);
                    P1Vigencia = FDesdePoliza + " a " + FHastaPoliza;
                    P1FPago = FPago;
                    PrimaTotalPoliza = PrimaTotal;
                    P1PrimaRenovacion = numberFormat.format(PrimaTotalPoliza).split('$')[1];
                    P1Email1 = valor(doc.EMail1);
                    P1Email2 = valor(doc.EMail2);
                    D1IDDocto = doc.IDDocto;

                    if (Nombres != 0) {
                        if (doc.TipoEnt_TXT == "Fisica") {
                        P1NombresCliente = Nombres + ApellidoP + ApellidoM;
                    }
                        else if (doc.TipoEnt_TXT == "Moral") {
                            P1NombresCliente = NombreCompleto;
                        }
                    }
                    else {
                        P1NombresCliente = NombreCompleto;
                    }

                    $('#cIDDocto').val(doc.IDDocto);

                    if (P1Email1 != 0) {
                        cc += `<a class="dropdown-item" data-email="${P1Email1}" onclick="SelectEmailD(this)">${P1Email1}</a>`;
                        if (P1Email2 != 0) {
                            cc += `<a class="dropdown-item" data-email="${P1Email2}" onclick="SelectEmailD(this)">${P1Email2}</a>`;
                        }
                    }
                    else {
                        cc += `<a class="dropdown-item" data-email="">Ninguno</a>`;
                    }

                    if (doc.RamosNombre == "Vehiculos") { //Autos
                        P1TextRamo = `Le enviamos un cordial saludo y aprovechamos en notificarle que su póliza para el automóvil <span class="text-edit" contenteditable="true">${P1Automovil}</span> con placas <span class="text-edit"  contenteditable="true">${P1Placas}</span> detallada a continuación, se renovó con las siguientes condiciones:`;
                    }
                    else if (doc.RamosNombre == "Accidentes y Enfermedades") { //GMM
                        P1TextRamo = `Le enviamos un cordial saludo y aprovechamos en notificarle que su póliza de GMM detallada a continuación, se renovó con las siguientes condiciones:`;
                    }
                    else if (doc.RamosNombre == "Daños") { //Daños //P
                        P1TextRamo = `Le enviamos un cordial saludo y aprovechamos en notificarle que su póliza de Daños detallada a continuación, se renovó con las siguientes condiciones:`;
                    }
                }
                else if (TypeSearch == 3) { //Cliente
                    $('#Panel3').addClass('hidden');
                    $('#NameDocument').text("");
                    $('#VentPolizas').addClass('hidden');
                    $('#VentClientes').removeClass('hidden');
                    $('#SegBitacoras').removeClass('hidden');
                    $('#TituloDetalles').text("Clientes");
                    $('#cIDDocto').val('0');
                    $('#CargarArchivo').prop('disabled',false);
                    D1IDDocto = "0";
                    ModalHeader.style.height = "34px"; //70, 43
                    PanelBitacoras(bit);
                    TablaPolizas(IDCli);

                    //Cambio de valor
                    const TipoEnt_TXT = valor(doc.TipoEnt_TXT);
                    const Idioma_TXT = valor(doc.Idioma_TXT);
                    const NumEmpleados = valor(doc.CantEmpleados);
                    const Clasifica_TXT = valor(doc.Clasifica_TXT);
                    const CalidadCliente = valor(doc.Calidad);
                    const Email1 = valor(doc.EMail1);
                    const Email2 = valor(doc.EMail2);
                    const ClaveTKM = valor(doc.ClaveTKM);
                    const TIngreso_TXT = valor(doc.TIngreso_TXT);
                    const FEntero_TXT = valor(doc.FEntero_TXT);
                    const GAfinidad_TXT = valor(doc.GAfinidad_TXT);
                    const Telefono1 = valor(doc.Telefono1).split(':'); //Seperación por medio del caracter ':''
                    const Telefono2 = valor(doc.Telefono2).split(':'); //Si le pongo el match lo pone en un array
                    //var Celular = Telefono1.match(/\d+/g); //Separa letras de números con match
                    //var TelOficina = Telefono2.split('/(\d+)/'); //Separa letras de números con split
                    $('#TipoEntidad').val(TipoEnt_TXT);
                    $('#nIdioma').val(Idioma_TXT);
                    $('#nEstatus').val(Status_TXT);
                    $('#IDCliente').val(IDCli);
                    $('#nCliente').val(NombreCompleto);
                    //$('#nNumeroEmpleado').val(NumEmpleados);
                    $('#nRFC').val(RFC);
                    //$('#nAlias').val(); //Pendiente
                    $('#nClasificacion').val(Clasifica_TXT);
                    //$('#nExpediente').val(); //Pendiente
                    $('#nGrupo').val(Grupo);
                    $('#nSubGrupo').val(SubGrupo);
                    //$('#nSSGrupo').val(); //Pendiente
                    //$('#nCalidadCliente').val(CalidadCliente);
                    $('#nEjecutivoCuenta').val(EjecutNombre);
                    //$('#nEjecutivoCobranza').val(); //Pendiente
                    //$('#nEjecutivoReclamacion').val(); //Pendiente
                    $('#nCorreo1').val(Email1);
                    $('#nCorreo2').val(Email2); //Pendiente
                    //$('#nLigaInternet').val(); //Pendiente
                    $('#nClaveTeleMark').val(ClaveTKM);
                    $('#nModoIngreso').val(TIngreso_TXT);
                    $('#nComoSeEntero').val(FEntero_TXT);
                    $('#nGrupoAfinidad').val(GAfinidad_TXT);
                    //$('#nCentroCosto').val(); //Pendiente
                    $('#nCelular').val(Telefono1[1]);
                    $('#nTelefono2').val(Telefono2[1]);
                    //$('#nTelefono3').val();
                    //$('#nTelefono4').val();
                    //$('#nCobroEmpresa').val();
                    //$('#nCobroContacto').val();
                    //$('#nCobroHorario').val();
                    //$('#nCobroObservacion').val();
                }
                else if (TypeSearch == 5) { //Serie y Placa
                    $('#Panel3').addClass('hidden');
                    $('#NameDocument').text("Documento: " + Documento);
                    $('#VentPolizas').removeClass('hidden');
                    $('#VentClientes').addClass('hidden');
                    $('#SegBitacoras').removeClass('hidden');
                    $('#TituloDetalles').text("Serie en vehículos");
                    $('#Parte1-Series').removeClass('hidden');
                    $('#Parte4-Series').removeClass('hidden');
                    $('#Parte1-Polizas').addClass('hidden');
                    $('#Parte2-Polizas').addClass('hidden');
                    $('#Parte4-Polizas').addClass('hidden');
                    $('#Parte5-Polizas').addClass('hidden');
                    $('#Parte6-Polizas').addClass('hidden');
                    $('#Parte7-Polizas').addClass('hidden');
                    $('#Parte8-Polizas').addClass('hidden');
                    $('#Campo1').text("Recargos:");
                    $('#Campo2').text("Derechos:");
                    $('#cIDDocto').val(doc.IDDocto);

                    ModalHeader.style.height = "34px"; //120,43
                    ColumnPrimas.style.height = "400px";
                    TablaRecibos();
                    PanelBitacoras(doc.ClaveBit);

                    //Cambio de valor
                    const Oficina = valor(doc.OfnaNombre);
                    const Marca = valor(sre.Marca);
                    const Tipo = valor(sre.Tipo);
                    const Transmision = valor(sre.Transmision);
                    const Puertas = valor(sre.Puertas);
                    const Modelo = valor(sre.Modelo);
                    const Clave = valor(sre.Clave);
                    const Placas = valor(sre.Placas);
                    const Serie = valor(sre.Serie);
                    const Motor = valor(sre.Motor);

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
                    $('#sMarca').val(Marca);
                    $('#sTipo').val(Tipo);
                    $('#sTransmision').val(Transmision);
                    $('#sPuertas').val(Puertas);
                    $('#sModelo').val(Modelo);
                    $('#sClave').val(Clave);
                    $('#sPlacas').val(Placas);
                    $('#sSerie').val(Serie);
                    $('#sMotor').val(Motor);
                    //$('#sRepuve').val();
                    //$('#sCiaLocal').val();
                    //$('#sSerieLocal').val();
                    //$('#sPlan').val();
                    //$('#sAseguradoPC').val();
                    $('#Referencia1').val(Referencia1);
                    //$('#sCobro').val(doc.); //Pendiente
                    $('#Referencia2').val(Referencia2);
                    $('#EstatusUsuario').val(StatusUser_TXT);
                    $('#Referencia3').val(Referencia3);
                    //$('#sClasDoc').val(doc.); //Pendiente
                    $('#Oficina').val(Oficina);
                    $('#Gerencia').val(GerenciaNombre);
                    $('#Despacho').val(DespNombre);
                    $('#LineaNegocio').val(LineaNegocio);
                    $('#CondCobro').val(CCobro_TXT);
                    //$('#TsipoCondCobro').val(doc.); //Pendiente
                    $('#PrimaNeta').val(numberFormat.format(PrimaNeta));
                    $('#Descuento').val(numberFormat.format(Descuento));
                    $('#Recargos').val(numberFormat.format(Recargos));
                    $('#Derechos').val(numberFormat.format(Derechos));
                    $('#SubTotal').val(numberFormat.format(STotal));
                    $('#IVA').val(numberFormat.format(IVA));
                    $('#sAjuste').val(numberFormat.format(ExtraPrima));
                    $('#PrimaTotal').val(numberFormat.format(PrimaTotal));
                    //$('#Endoso').val(Endoso); //Pendiente por el tipo de formato
                    $('#sTipoPago').val(TipoPago); //Pendiente
                    //$('#sTipoVenta').val(doc.); //Pendiente
                }

                $(".list-table-totales-body").html(trtd2);
                //$(".list-table-pago-body").html(trtd3);
                $('#Endoso').html(option);
                $('#CorreoCliente').html(cc);
            },
            error: (error) => {
                swal("¡Vaya!", "Parece que hay conflicto al obtener la información", "error");
            }
        })
    }

    function DocAnterior(Anterior) {
        const prev = Anterior;
        const tipo = 1;
        //console.log("DocAnterior: " + prev);

        if (prev != 0) {
            $.ajax({
                type: "GET",
                url: `${baseUrl}/BusquedaPolizas`,
                data: {
                    search: prev,
                    type: tipo
                },
                success: (data) => {
                    const doc = JSON.parse(data);
                    //console.log(doc);
                    
                    if (doc != 0) {
                        for (var d in doc) {
                            const PrimaTotal = valor(doc[d].PrimaTotal);
                            PrimaVigenciaAnterior = PrimaTotal;
                            PrimaTotalDocAnterior = numberFormat.format(PrimaTotal).split('$')[1];
                        }
                    }
                    else {
                        PrimaVigenciaAnterior = "0.00";
                        PrimaTotalDocAnterior = "0.00";
                    }
                    //console.log("PrimaVigenciaAnterior: " + PrimaVigenciaAnterior);        
                }
            })
        }
        else {
            PrimaVigenciaAnterior = "0.00";
            PrimaTotalDocAnterior = "0.00";
        }
    }

    function TablaRecibos() {
        const id = document.getElementsByClassName('seleccionResult')[0].dataset.id;
      document.getElementById('comentarioPolizaBody').addEventListener("DOMSubtreeModified", handler, true);
      document.getElementById('cargaDocumentoRecibosTable').style.display='block';
        $.ajax({
            type: "GET",
            url: `${baseUrl}/TableRecibos`,
            data: {
                id: id
            },
            beforeSend: (load) => {
                $('.list-table-recibos-body').html(`
                    <div class="container-spinner-content-table-recibos">
                        <div class="tr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);

                $('#TablaTotales').addClass('opaco');
                $('#Parte8-Polizas').addClass('opaco');
                
            },
            success: (data) => {
                const rcb = JSON.parse(data);
                //console.log(rcb);
                let comentarioPolizaBody='';
                let documentoComentario='';
                document.getElementById('comentarioPolizaBody').innerHTML=''
                $('#TablaTotales').removeClass('opaco');
                $('#Parte8-Polizas').removeClass('opaco');
                $(".list-table-recibos-body").html("");
                var PrimaNetaRecibo = 0;
                var Neta = 0;
                var Recargos = 0;
                var trtd1 = ``;
                var NumPagos = rcb.length;
                $('#NumPagos').text(NumPagos);
           
                for (var b in rcb) {
                    //Primer Recibo
                    var PorcjRenv = 0.00;
                    if (rcb[b].Periodo == 1) {
                        P1PrimaTotalRecibo1 = valor(rcb[b].PrimaTotal);
                        P1LimitePagoRecibo1 = fecha(rcb[b].FLimPago);
                        if (PrimaVigenciaAnterior == "0.00" || Number(PrimaVigenciaAnterior) >= Number(PrimaTotalPoliza)) {
                            P1PorcjRenv = "0.00";
                        }
                        else {
                            P1PorcjRenv = ((Number(PrimaTotalPoliza) - Number(PrimaVigenciaAnterior)) * 100) / Number(PrimaVigenciaAnterior);
                    }
                        //CargaInfoPlantilla(rcb[b].IDRecibo);
                    }
                    //else if (rcb[b].Periodo != 0) {
                    //    CargaInfoPlantilla(rcb[b].IDRecibo);
                    //}

                    //Cambio de valor
                    const bInciso = valor(rcb[b].Inciso);
                    const bEndoso = valor(rcb[b].Endoso);
                    const bPrimaNeta = valor(rcb[b].PrimaNeta);
                    const bPrimaTotal = valor(rcb[b].PrimaTotal);
                    const bPrimaEnviada = valor(rcb[b].PrimaEnviada);
                    //const bPrimaPag = valor(rcb[b].PrimaPag);
                    var bPrimaPend = valor(rcb[b].PrimaPend);

                    //Comisiones
                    const PrctjNeta = valor(rcb[b].PorCom0);
                    const PrctjRecargos = valor(rcb[b].PorCom2);

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
                    var PrimaPendienteRecibo = 0;
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
                    var Importe = Number(Com00)+Number(Com01)+Number(Com02)+Number(Com03)+Number(Com04)+Number(Com05)+Number(Com06)+Number(Com07)+Number(Com08)+Number(Com09)+Number(Com10)+Number(Com11)+Number(Com12)+Number(Com13)+Number(Com14)+Number(Com15)+Number(Com16);

                    if (rcb[b].Status_TXT == "Liquidado" || rcb[b].Status_TXT == "Pagado") {
                        Honorario = "Pagado";
                        Comision = "Conciliada"; //Pendiente

                        PrimaNetaRecibo += parseFloat(rcb[b].PrimaNeta);
                    }
                    else if (rcb[b].Status_TXT == "Pendiente" || rcb[b].Status_TXT == "Cancelado") {
                        Honorario = "No Pagado";
                        Comision = "No Conciliada"; //Pendiente
                        Importe = 0;
                        PrimaPendienteRecibo += parseFloat(rcb[b].PrimaPend);
                    }
                    else {
                        Comision = "";
                    }

                    //Prima Total Pendiente
                    if (PrimaPendienteRecibo == 0 || rcb[b].Status_TXT == "Cancelado") {
                        PrimaTotalPendiente = 0;
                        $('#TotalNetaPendiente').text(numberFormat.format(PrimaTotalPendiente));
                        $('#PrimaTotalPendiente').text(numberFormat.format(PrimaTotalPendiente));
                        bPrimaPend = 0;
                    }
                    else {
                        PrimaTotalPendiente = PrimaNetaTotal - PrimaNetaRecibo;
                        $('#TotalNetaPendiente').text(numberFormat.format(PrimaTotalPendiente));
                        $('#PrimaTotalPendiente').text(numberFormat.format(PrimaPendienteRecibo));
                    }
					$('#SumaRecibos').text(numberFormat.format(PrimaNetaRecibo));

                    trtd1 += `
                        <tr class="subtitle-table-body" name="ListaRecibos" data-id="${rcb[b].IDRecibo}" data-doc="${rcb[b].Documento}" onclick="DetallesRecibo(this)">
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
                            <td>${numberFormat.format(bPrimaNeta)}</td>
                            <td>${numberFormat.format(bPrimaTotal)}</td>
                            <td>${numberFormat.format(bPrimaEnviada)}</td>
                            <td>${numberFormat.format(bPrimaPend)}</td>
                            <td>${Honorario}</td>
                            <td>Folio Liquidación</td> <!-- Pendiente -->
                            <td>${numberFormat.format(Importe)}</td>
                            <td>${bPago}</td>
                        </tr>`;

                    //Detalle de comsiones 497-2405-1
                    Neta += parseFloat(Com00);
                    Recargos += parseFloat(Com02);
                    //console.log("Neta: "+Neta+", Recagos: "+Recargos+", PorNeta: "+PrctjNeta+", PorRecargos: "+PrctjRecargos);

                    $('#Neta').val(numberFormat.format(Neta).split('$')[1]);
                    $('#RecargosC').val(numberFormat.format(Recargos).split('$')[1]);
                    $('#ExtraPrimaC').val("0.00");
                    $('#DerechosC').val("0.00");
                    $('#EspecialC').val("0.00");
                    $('#NetaC').val(Number(PrctjNeta).toFixed(2));
                    $('#RcgsC').val(Number(PrctjRecargos).toFixed(2));
                    $('#ExtPrmC').val("0.00");
                    $('#DrchsC').val("0.00");
                    $('#EspC').val("0.00");
                    comentarioPolizaBody+=`<tr onclick="seleccionarRowComentario(this)" data-idrecibo="${rcb[b].IDRecibo}" data-tipo="recibo" data-idserie="${rcb[b].Serie}" data-idcli="${rcb[b].IDCli}" data-endoso="${rcb[b].Endoso}" data-nombrecliente="${rcb[b].Nombre} ${rcb[b].ApellidoP}" data-documento="${rcb[b].Documento}" data-iddocto="${rcb[b].IDDocto}" data-idvend="${rcb[b].IDVend}"><td>RECIBO</td><td>${rcb[b].Documento}</td><td>${rcb[b].Serie}</td><td></td></tr>`;
                    documentoComentario=`<tr onclick="seleccionarRowComentario(this)" data-idrecibo="${rcb[b].IDRecibo}" data-idvend="${rcb[b].IDVend}" data-tipo="documento" data-idserie="" data-idcli="${rcb[b].IDCli}" data-endoso="${rcb[b].Endoso}" data-nombrecliente="${rcb[b].Nombre} ${rcb[b].ApellidoP}" data-documento="${rcb[b].Documento}" data-iddocto="${rcb[b].IDDocto}"><td>POLIZA</td><td>${rcb[b].Documento}</td><td></td><td></td></tr>`;
                }
                $(".list-table-recibos-body").html(trtd1);
                $("#comentarioPolizaBody").html(`${documentoComentario}${comentarioPolizaBody}`);
                document.getElementById('cargaDocumentoRecibosTable').style.display='none';
                document.getElementById('comentarioPolizaBody').removeEventListener("DOMSubtreeModified", handler, true);
                $('#SpinnerEmail').html("");
                $('#PlantillaRenovacion').prop('disabled',false);
            },
            error: (error) => {
                console.log("Hay problemas al buscar los recibos.");
                    }
                })
    }

    function CargarPlantilla() {
        const tipo = document.getElementById('TipoCorreo').value;
        const content =  document.getElementById('TextBodyEmail');
        //content.style.padding = "0px";
        $('#TipoCorreo').text("2");
        $('#TipoDocEnvio').text("0");
        $('#QuitarP').removeClass('hidden');
        $(content).html(`<? $this->load->view('polizas/plantillaRenovacion') ?>`);

        $('#eNameClient').text(P1NombresCliente);
        $('#eTextRamo').html(P1TextRamo);
        $('#eNumeroPoliza').text(P1Documento);
        $('#eCompania').text(P1CiaAbreviacion);
        $('#eVigencia').text(P1Vigencia);
        $('#eFormaPago').text(P1FPago);
        $('#ePrimaTotal').text(P1PrimaRenovacion);
        $('#ePrimaRenovacion').text(P1PrimaRenovacion);
        $('#ePrimerRecibo').text(numberFormat.format(P1PrimaTotalRecibo1).split('$')[1]);
        $('#eFechaLimitePago').text(P1LimitePagoRecibo1);
        $('#ePrimaVigenciaAnterior').text(PrimaTotalDocAnterior);
        $('#ePorcIncrRenov').text(numberFormat.format(P1PorcjRenv).split('$')[1] + "%");

        const value = document.getElementById('TextBodyEmail').innerHTML;
        $('#TextEndEmail').val(value);
        //console.log(value);
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
        var fecha = "";

        if (dato == undefined) {
            fecha = "";
        }
        else {
            date = new Date(dato);
            fecha = date.getDate() + "/" + nombremeses[date.getMonth()] + "/" + date.getFullYear();
        }
        return fecha;
    }

    function formatDate(dato) {
        var fecha = "";

        if (dato == undefined) {
            fecha = "";
        }
        else {
            date = new Date(dato);
            fecha = date.getFullYear() + "-" + numeromeses[date.getMonth()] + "-" + numerodias[date.getDate()];
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

    function optionSelect(dato) {
        var info = dato;
        var option = ``;

        if (info == "") {
            option += `<option></option>`;
        }
        else {
            option += `<option class="opt-search">${info}</option>`;
        }
        return option;
    }
</script>
