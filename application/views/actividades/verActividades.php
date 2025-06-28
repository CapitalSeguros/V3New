<?php $this->load->view('actividades/actividadesComentariosOperativos');?>
<?php
$userResponsable=$this->tank_auth->get_usermail();
$permisoCambioResponsable=0;
$panelParaActivdadesEnRojo=false;
if($userResponsable=='SISTEMAS@ASESORESCAPITAL.COM' || $userResponsable=='COORDINADOROPERATIVO@ASESORESCAPITAL.COM' || $userResponsable=='GERENTECOMERCIAL@AGENTECAPITAL.COM'){$permisoCambioResponsable=1;}
if($userResponsable=='SISTEMAS@ASESORESCAPITAL.COM' || $userResponsable=='COORDINADOROPERATIVO@ASESORESCAPITAL.COM' || $userResponsable=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $userResponsable=='GERENTEOPERATIVO@AGENTECAPITAL.COM' || $userResponsable=='GERENTECOMERCIAL@AGENTECAPITAL.COM'){$panelParaActivdadesEnRojo=true;}
?>

<l?
    var_dump($datos);
?>
<style>
    #dragable { width: 200px; height: auto; padding: 0.5em;opacity: 0.9 }
    .fila-seleccionada {
    background-color: #4a90e2; /* Azul claro */
    font-weight: bold;
}
 /* ing-Roberto-Alvarez 22-abril-2025 */
.vertical-menu a h5 {
  margin: 0;
  white-space: nowrap;/* Evita que se haga multilínea */
  overflow: hidden;/* Oculta el contenido que se desborda */
  text-overflow: ellipsis; /* Aplica los "..." */
  max-width: 180px; /* o el ancho que tú necesites para mostrar unas 10 letras */
  /* display: inline-block;* */
}
.vertical-menu a {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 180px;
  display: inline-block;
}
/* ing-Roberto-Alvarez 22-abril-2025 */



</style>
<script type="text/javascript">
    var ct=0;
    function persiana(){
        if(ct==0){
            document.getElementById('dragable').style.height='30px';
            $('#flecha').toggleClass('fa-arrow-circle-o-up');
            ct=1;
       }else{
             document.getElementById('dragable').style.height='auto';
             $('#flecha').toggleClass('fa-arrow-circle-o-down');
             ct=0;
       } 
    }
</script>

<!-- Cargar Bootstrap y jQuery UI -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

<!-- Cargar jQuery antes de jQuery UI -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<!-- Cargar SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php $this->load->view('headers/header'); ?><?php $this->load->view('headers/menu');?>






<section class="container-fluid breadcrumb-formularios">
	<div class="row"><div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Actividades</h3></div><div class="col-md-6 col-sm-7 col-xs-7"><ol class="breadcrumb text-right"><li><a href="./">Inicio</a></li><li class="active">Actividades</li></ol></div></div><hr /> 
        <a href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABSWpAhQXuqTpiPfv_rDvGxa/COTIZADORES?dl=0" title="Clic Aqui - Descargar Cotizadores"  charset="" target="_blank"><b>Cotizadores</b></a>
</section>
<section class="container-fluid">

<!--Modificacion--><!--ES LA TARJETA QUE DICE-->
<!-- <div id="dragable" class="contMenuFlotante">
    <div style="text-align: right;">
        <a href="#" onclick="persiana()">
            <i id="flecha" class="fa fa-times-circle fa-2x">
            </i>
        </a>
    </div>
    <div class="vertical-menu"><?php echo(imprimirBotonesRamos($ramos,$totalesPorRamo,$personaTrabajaActividad)); ?>

    </div><!--este div nomas se va a modificar--
</div> -->
<!--Fin Modificacion-->
<div class="panel panel-default">
<div onscroll="moverScroll()" id="scrollTabla" style="overflow-x:scroll; overflow-y: scroll;" >
		<div class="panel-body">
		<div class="row" style="padding-bottom:5px;">
			<div class="col-sm-12 col-md-12" align="right">
            <div class="col-md-2 text-right">
                <?= $this->load->view("permisosOperativos/tutorialButton");?>
            </div>      			
			<input type="button" value="Exportar Historial" title="Exportar Historial de Activiades - Clic Aqu&iacute;" onclick="window.open('actividades/ExportaHistorial','_self');" class="btn btn-primary btn-sm"/>
			<input type="button" value="Actualizar Actividad" title="Actualizar Actividad - Clic Aqu&iacute;" onclick="window.open('actualizaActividades/actualizaactividadesporvendedor','_self');" class="btn btn-primary btn-sm"/>
			</div>
		</div>

        <div class="row"><!-- Buscador de Folio -->
			<div class="col-sm-12 col-md-12" align="right">
            <form class="form-horizontal" role="form" id="formActividadBuscarFolio" name="formActividadBuscarFolio" method="post" enctype="multipart/form-data" action="<?=base_url()?>actividades/busqueda">
				<div class="input-group" style="width:50%;">
					<input id="folioBuscado" name="folioBuscado" type="text" class="form-control input-sm" placeholder="Buscar Folio">
                    <span class="input-group-btn"><button class="btn btn-primary btn-sm search-trigger"><i class="fa fa-search fa-sm"></i>&nbsp;</button></span>
				</div>
                <input type="hidden" id="usuarioCreacion" name="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>"/>
			</form>
            </div>            
        </div>
        
    </div>
   </div>


    <div>

       <!-- <div class="row"><div class="col-sm-2 col-md-2"><label class="tituloAgente"><a name="seccionEnCurso">En curso </a></label></div></div>
    	<div class="row"><div class="col-sm-2 col-md-2"><label class="tituloAgente">FILTROS:</label></div><div class="col-sm-3 col-md-3"><select id="selectTipoFiltro" class="form-control" onchange="escogerTipoFiltro(this.value)"><option value="">ESCOGER FILTRO</option><option value="ESTADO">ESTADO</option><option value="TIPO ACTIVIDAD">TIPO ACTIVIDAD</option><option value="SUB RAMO">SUB RAMO</option><option value="RESPONSABLE">RESPONSABLE</option></select></div><div class="col-sm-3 col-md-3"><select id="selectValorFiltro" class="form-control" onchange="escogerFiltroRows(this)"></select></div><div class="col-sm-3 col-md-3">Detener recarga:<input type="checkbox"  id="detenerRecargaChecked" ></div></div> -->

        <!--------------Ing.Roberto-Alvarez-formateo visual--------------//08-abril-2025 -->
       
 <!-- 08-abril-2025  -->
        <!-- <div class="row">  
           
            <div class="col-sm-2 col-md-2">
                <label class="tituloAgente">FILTROS:</label>
            </div>

            <div class="col-sm-3 col-md-3">
                <select id="selectTipoFiltro" class="form-control" onchange="escogerTipoFiltro(this.value)">
                    <option value="">ESCOGER FILTRO</option>
                    <option value="ESTADO">ESTADO</option>
                    <option value="TIPO ACTIVIDAD">TIPO ACTIVIDAD</option>
                    <option value="SUB RAMO">SUB RAMO</option>
                    <option value="RESPONSABLE">RESPONSABLE</option>
                </select>
            </div>

            <div class="col-sm-3 col-md-3">
                <select id="selectValorFiltro" class="form-control" onchange="escogerFiltroRows(this)">
                </select>
            </div>
                -->
            <!-- <div class="col-sm-3 col-md-3">
                Detener recarga:
                <input type="checkbox" id="detenerRecargaChecked">
            </div> -->
        <!--</div> -->
         <!-- 08-abril-2025  -->
        <!--------------Ing.Roberto-Alvarez-formateo visual--------------//08-abril-2025 -->
        <div id="verActividadesVue"><!--EMPIEZA RECARGA AJAX -->
            <div id="contenedorActividades"><!--RE-PROGRAMADO-EN-VUE-ING-ROBERTO-ALVAREZ-ABRIL-2025-->





                <!--MENU-FLOTANTE-RE-PROGRAMADO-ING-ROBERTO-ALVAREZ-22-ABRIL-2025-->
                <div id="dragable" class="contMenuFlotante" v-if="mostrarMenu"><!--MENU-FLOTANTE-RE-PROGRAMADO-ING-ROBERTO-ALVAREZ-22-ABRIL-2025-->
                    <div style="text-align: right;">
                        <a href="#" @click.prevent="persiana">
                            <i id="flecha" class="fa fa-times-circle fa-2x"></i>
                        </a>
                    </div>

                    <div class="vertical-menu">
                        <!-- Botones fijos -->
                        <a href="#seccionAgente" class="btnAgente">Agente</a>
                        <!-- <a href="#cotizaciones" class="btncotizaciones">Cotizaciones</a>
                        <a href="#otrasActividades" class="btnotrasActividades">Otras Actividades</a> -->
                        <!-- Actividades trabajándose -->
                        <a
                            v-for="(actividades, tipo) in obtenerActNoTrab"
                            :key="tipo"
                            :href="'#' + tipo"
                            :class="'btn' + tipo"
                            >
                            <h5>
                            {{ getNamActNoJob(tipo) }}<!--EL NOMBRE DE CADA ARRAY ANIDADO-->
                            </h5>
                            
                            <span class="spanTotal">{{ actividades.length }}</span><!--LA CANTIDAD DE OBJETOS QUE TIENE CADA ARRAY-->
                        </a>

                        
                        <a href="#seccionEnCurso" class="btnAgente">En curso</a>
                        <!-- Botones generados por ramo -->
                        <a
                            v-for="(actividades, abreviacion) in ObtenerActividad"
                            :key="abreviacion"
                            :href="'#' + abreviacion"
                            :class="'btnRamo' + abreviacion + ' prueba'"
                            >
                            <span class="spanTotal">{{ actividades.length }}</span><!--LA CANTIDAD DE OBJETOS QUE TIENE CADA ARRAY-->
                        <!--{{ getNamRamojob(actividades, abreviacion) }}<!--EL NOMBRE DE CADA ARRAY ANIDADO -->
                        <h5 :title="getNamRamojob(abreviacion)">
                                {{ getNamRamojob(abreviacion) }}
                            </h5>


                            
                        </a>
                    </div>
                </div><!--MENU-FLOTANTE-RE-PROGRAMADO-ING-ROBERTO-ALVAREZ-22-ABRIL-2025-->
                <!--MENU-FLOTANTE-RE-PROGRAMADO-ING-ROBERTO-ALVAREZ-22-ABRIL-2025-->
                <div><!--empieza la tabla de  -->
                    <div><label class="tituloAgente"><a name="seccionAgente">Agentes</a></label></div>

                    <form class="form-horizontal" role="form" name="formTrabajandoAgenteCapital" id="formTrabajandoAgenteCapital" method="post" enctype="multipart/form-data" action="<?=base_url()?>actividades/todas">
                        <input type="hidden" name="tipo" id="tipo" />

                        <div class="clearfix" style="float:left;"><font class="subTituloSeccione"></font></div>
                        <div>
                            <font style="float:right;">
                            <input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" class="btn btn-info" />
                            &nbsp;
                            <input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" class="btn btn-info" />

                            <!-- <input type="button" onclick="todas(this.form, 'terminarTodas')" value="Cerrar las seleccionadas" class="btn btn-danger" /> -->
                            
                            <!-- EDITADO ING.ROBERTO-ALVAREZ/28/04/2025-->
                            <!-- <input type="button" @click="todasVue(this.form, 'terminarTodas')" value="Cerrar las seleccionadas" class="btn btn-danger" /> -->
                            <input type="button" @click="todasVue($event)"  value="Cerrar las seleccionadas" class="btn btn-danger" />
                            <!-- EDITADO ING.ROBERTO-ALVAREZ/28/04/2025-->
                            </font>
                        </div>
                        <div v-for="(grupo, key) in obtenerActNoTrab" :key="key">
                            <table  class="table table-striped table-bordered table-sm">
                                <thead>
                                <tr scope="row">
                                    <div class="clearfix" style="float:left;">
                                    <font class="subTituloSeccione">
                                        <a class="btn" :name="key">{{ key }}</a>
                                    </font>
                                    </div>
                                    <div></div>
                                </tr>
                                <tr scope="row" bgcolor="#A391C0" valign="top">
                                    <th scope="col">Folio</th>
                                    <th scope="col">Fecha recepcion</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Actividad</th>
                                    <th scope="col">SubRamo</th>
                                    <th scope="col">Cliente</th>
                                    <th>Califica/Finaliza</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="row in grupo" :key="row.idInterno" scope="row" style="font-size:12px;">
                                        <td scope="col" align="center">
                                            <a :href="'<?=base_url()?>actividades/ver/' + row.folioActividad" @click.prevent="nuevaVentana($event, row)">
                                                <div class="classParaAgente">
                                                {{ row.folioActividad }}<br />
                                                <font style="font-size:9px;">{{ row.tipoActividadSicas === 'tarea' ? row.idSicas : row.NumSolicitud }}</font>
                                                </div>
                                            </a>
                                        </td>
                                        <td scope="col">{{ row.fechaActualizacionStatus }}</td>
                                        <td scope="col">{{ row.Status_Txt }}</td>
                                        <td scope="col">{{ row.fechaCreacion }}</td>
                                        <td scope="col">
                                            <template v-if="row.inicio == 1">
                                                <font style="color:blue; font-weight:bold;">Cotizacion</font>
                                            </template>
                                            <template  v-if="row.fechaEmite !== null && row.fechaEmite !== undefined && row.fechaEmite.trim() !== ''">
                                                <font style="color:#00F;"><strong>Emision</strong></font>
                                            </template>
                                            <br />
                                            {{ row.tipoActividad }}
                                            <font style="color:red; font-weight:bold;">{{ row.actividadUrgente == 1 ? ' • Urgente !!!' : '' }}</font>
                                            <br v-if="row.actividadImportante == 1" />
                                            <font v-if="row.actividadImportante == 1" style="color:red; font-weight:bold;">!!! ACTIVIDAD IMPORTANTE !!!</font>
                                        </td>
                                        <td scope="col">{{ row.subRamoActividad }}</td>
                                        <td>
                                            {{ row.nombreCliente }}
                                            <br /><b>Creador:</b> {{ row.usuarioCreacion }} [{{ row.usuarioCreacion }}]
                                            <br v-if="row.usuarioVendedor">
                                            <b>Vendedor:</b> {{ row.nombreUsuarioVendedor }} [{{ row.usuarioVendedor }}]
                                        </td>
 
                                        <td scope="col" align="center">
                                            <template v-if="!row.satisfaccion">

                                                <!-- calificación buena -->
                                                <a
                                                    href="#"
                                                    title="Califica Bien y Finaliza"
                                                    @click.prevent="calificarActividad('bueno', row)"
                                                >
                                                    <span
                                                        class="glyphicon glyphicon-thumbs-up"
                                                        style="font-size: 35px; color: green; margin-right: 15px; margin-left: 0px;"
                                                        onmouseover="this.style.color='#000000';"
                                                        onmouseout="this.style.color='green';"
                                                    ></span>
                                                </a>

                                                <!-- calificación mala -->
                                                <a
                                                    href="#"
                                                    title="Califica Mal y Finaliza"
                                                    @click.prevent="calificarActividad('malo', row)"
                                                >
                                                    <span
                                                        class="glyphicon glyphicon-thumbs-down"
                                                        style="font-size: 35px; color: red;"
                                                        onmouseover="this.style.color='#000000';"
                                                        onmouseout="this.style.color='red';"
                                                    ></span>
                                                </a>
                                            </template>

                                            <template v-else>
                                                            <a title="Actividad Calificada">
                                                                <span class="glyphicon glyphicon-ok-sign"></span>
                                                            </a>
                                                            <a
                                                                :href="'<?=base_url()?>actividades/terminar/' + row.folioActividad + '?IDDocto=' + row.idSicas + '&ClaveBit=' + row.ClaveBit"
                                                                title="Terminar la Actividad del Sistema"
                                                            >
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </a>
                                            </template>
                                        </td>


                                        <td scope="col" align="center">
                                                    <input type="checkbox" name="ch[]" :value="row.idSicas + '|' + row.ClaveBit + '|' + row.folioActividad">
                                        </td>
                                    </tr>
                                            
                                </tbody>
                            </table>
                        </div>
                                
                    </form>
                </div>
                <!-- Filtros -->
                <div class="row">
                    <div class="col-sm-2 col-md-2">
                        <label class="tituloAgente">FILTROS:</label>
                    </div>

                    <div class="col-sm-3 col-md-3">
                        <select v-model="filtroSeleccionado" @change="actualizarOpcionesFiltro" class="form-control">
                        <option value="true">ESCOGER FILTRO</option><!--si esta escogida esta opción no aplica ningun filtro-->
                        <option value="Status_Txt">ESTADO</option><!--se llaman los objetos tal cual esta en el array-->
                        <option value="tipoActividad">TIPO ACTIVIDAD</option><!--se llaman los objetos tal cual esta en el array-->
                        <option value="subRamoActividad">SUB RAMO</option><!--se llaman los objetos tal cual esta en el array-->
                        <option value="usuarioResponsable">RESPONSABLE</option><!--se llaman los objetos tal cual esta en el array-->
                        </select>
                    </div>
                    <div class="col-sm-3 col-md-3"><!--este select depende del select anterior-->
                        <select v-model="valorFiltro" class="form-control">
                            <option value="">SELECCIONAR</option>
                            <option v-for="valor in opcionesFiltro" :key="valor" :value="valor"><!--es equivalente a un foreach -->
                                {{ valor }}
                            </option>
                        </select>
                    </div>
                    <!-- <button @click="limpiarIntervalo()">detenerIntervalo</button>
                    <button @click="comenzarIntervalo()">Comenzar Intervalo</button> -->


                    <!-- <div class="col-sm-3 col-md-3">
                        Detener recarga:
                        <input type="checkbox" v-model="detenerRecargaChecked">
                    </div> -->
                    <!-- <div class="col-sm-3 col-md-3"><!--este puedes omitirlo--
                        Detener recarga:
                        <input type="checkbox" id="detenerRecargaChecked">
                    </div> -->
                </div>
                <!-- <?php //if($permisoCambioResponsable){ ?>
                    <div class="row">
                        <div class="col-sm-1 col-md-1">Escoger</div>
                        <div>
                            <select id="nuevoResponsableSelect" class="form-control"><?=imprimirResponsables($ejecutivos)?></select>
                        </div>
                        <div class="col-sm-1 col-md-1"><button class="btn btn-primary" onclick="cambiarResponsablesNuevos()">Guardar</button></div>
                    </div>
                <?php //}?> -->
                <?php if($permisoCambioResponsable){ ?>
                    <div class="row">
                        <div class="col-sm-1 col-md-1">Escoger</div>
                        <div>
                            <select id="nuevoResponsableSelect" class="form-control">
                                <?= imprimirResponsables($ejecutivos) ?>
                            </select>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <button class="btn btn-primary" @click="cambiarResponsablesNuevosVue()">Guardar</button>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">  <!-- 08-abril-2025  -->
                    <div class="col-sm-2 col-md-2">
                        <label class="tituloAgente">
                            <a name="seccionEnCurso">En curso</a>
                        </label>
                    </div>
                </div>  <!-- 08-abril-2025  -->
            
                <!-- <div v-for="(actividades, key) in ObtenerActividad"  -->
                <div v-for="(actividades, key) in actividadesFiltradas"
                    :key="key" class="row">
                    <div class="col-sm-12 col-md-12">
                        <input type="hidden" name="tipo" id="tipo" />
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr scope="row">
                                    <div class="clearfix" style="float:left;">
                                        <font class="subTituloSeccione">
                                            <a :class="'btnRamo' + key" :name="key">{{ key }}</a>
                                        </font>
                                        <button v-if="key === 'VEHICULOS'" class="btn btn-success">
                                            <a :href="baseUrl + 'cotizador'" onclick="nuevaVentana(event, this)">Ir a Car Capital</a>
                                        </button>
                                    </div>
                                </tr>
                                <tr scope="row" bgcolor="#A391C0" valign="top">
                                    <th scope="col">Folios</th>
                                    <th scope="col">Fecha recepcion</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Actividad</th>
                                    <th scope="col">SubRamo</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Aseguradoras</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in actividades"
                                    :key="index"
                                    scope="row"
                                    style="font-size:12px;"
                                    :data-estado="row.Status_Txt"
                                    :data-tipoactividad="row.tipoActividad"
                                    :data-subramo="row.subRamoActividad"
                                    :data-responsable="row.usuarioResponsable"
                                    data-vendedor=""
                                    data-creador=""
                                    name="trEnCurso"
                                    :data-idinterno="row.idInterno"
                                    :id="row.folioActividad + 'link'"
                                    onclick="seleccionarRow(this)">

                                    <td align="center">
                                        <div class="row">
                                            <a :href="baseUrl + 'actividades/ver/' + row.folioActividad" 
                                            :title="row.datosExpres"
                                            onclick="nuevaVentana(event, this)">
                                                <div :class="row.clase">
                                                    {{ row.folioActividad }}<br />
                                                    <font style="font-size:9px;">{{ row.tipoActividadSicas === 'tarea' ? row.idSicas : row.NumSolicitud }}</font>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="row" v-if="tipoUsuario == 5 || tipoUsuario == 4 || tipoUsuario == 1">
                                            <input type="checkbox" name="cbTrabajarActividad"
                                                :value="row.idInterno"
                                                :checked="row.trabajandoseActividad == 1"
                                                onclick="trabajarActividad('', this)">
                                        </div>
                                        <button class="btn btn-info btnActividadComentariosOperativos"
                                                :onclick="'abrirVentanaComentariosOperativos(\'\', ' + row.idInterno + ', \'' + row.folioActividad + '\')'">
                                            &#128172;
                                        </button>
                                    </td>

                                    <td>{{ row.fechaActualizacion }}</td>

                                    <td class="divPromotoria" align="center">
                                        <br>
                                        <div style="width: 120px;border-radius: 3px;text-align: center;color: #fff;">
                                            <label :id="'label' + row.idInterno" style="color: #1a0977">
                                                {{ row.nuevoSemaforo }}%
                                            </label>
                                            <meter min="0" max="100" low="70" high="80" optimum="69"
                                                :value="row.nuevoSemaforo"
                                                :id="'meter' + row.idInterno"
                                                style="height: 50px;width: 100%">
                                            </meter>
                                            <p style="font-size: 11px;">
                                                <template v-if="row.usuarioResponsable === 'COBRANZA@ASESORESCAPITAL.COM'">
                                                    LAS ACTIVIDADES EN COBRANZA TIENEN UN LIMITE DE 14 DIAS.
                                                </template>
                                                <template v-else>
                                                    {{ row.promotorias }}
                                                </template>
                                            </p>
                                        </div>
                                    </td>

                                    <td><label :id="'labelStatus' + row.idInterno">{{ row.Status_Txt }}</label></td>
                                    <td>{{ row.fechaCreacion }}</td>

                                    <td>
                                        <template v-if="row.inicio == 1">
                                            <font style="color:blue; font-weight:bold;">Cotizacion</font>
                                        </template>
                                        <!-- <template v-if="row.fechaEmite == ''">
                                            <font style="color:#00F;"><strong>Emision</strong></font>
                                        </template> -->
                                        <!-- <template v-if="row.fechaEmite && row.fechaEmite.trim() != ''">
                                            <font style="color:#00F;"><strong>Emision</strong></font>
                                        </template> -->
                                        <template v-if="row.fechaEmite !== null && row.fechaEmite !== undefined && row.fechaEmite.trim() !== ''">
                                            <font style="color:#00F;"><strong>Emision</strong></font>
                                        </template>


                                        <br />
                                    
                                        {{ row.tipoActividad }} 
                                        
                                        <span v-if="row.actividadUrgente == 1" style="color:red; font-weight:bold;">&bull; Urgente !!!</span>
                                        <br v-if="row.actividadImportante == 1" />
                                        <span v-if="row.actividadImportante == 1" style="color:red; font-weight:bold;">!!! ACTIVIDAD IMPORTANTE !!!</span>

                                        <template v-if="row.actividadImportante == 0 && row.clase === 'tiempoExcedido' && row.RamosNombre !== 'VEHICULOS'">
                                            <br />
                                            <font style="color:red; font-weight:bold; font-size:8px;">
                                                <a :href="baseUrl + 'actividades/marcarImportante?folioActividad=' + row.folioActividad"
                                                data-original-title="Clic - Para convertir la actividad en Importante !!!"
                                                style="color:#FFF" class="btn btn-danger">
                                                    !!! ESCALAR !!!
                                                </a>
                                            </font>
                                        </template>
                                    </td>

                                    <td>{{ row.subRamoActividad }}</td>

                                    <td>
                                        {{ row.nombreCliente }}
                                        <div v-html="mostrarInfoUsuario(row)"></div>
                                    </td>



                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!--termina tabla-->
            </div><!--termina instancia vue--><!--RE-PROGRAMADO-EN-VUE-ING-ROBERTO-ALVAREZ-ABRIL-2025-->
        </div>
        
    </div><!--TERMINA RECARGA AJAX -->
</div>
    </div>
</section>
<div id="base_url" data-base-url="<?= base_url(); ?>"></div><!--SE TOMA LA UBICACIÓN DE RAIZ V3 SIRVE PARA LA INSTANCIA DE VUE-->

<?php if($panelParaActivdadesEnRojo){?>
<div style="position: fixed;z-index: 2;top: 2%;left: 10%">
<div class="row">
    <div class="row" >
    <div class="col-md-11 col-sm-11 col-xs-11" style="overflow: scroll;height: auto;width: 100%" id="divActividadesEnRojo"><table class="table" style="background-color: white"><thead><tr><th colspan="4">Folio</th></tr></thead><tbody><?=imprimirActividadesEnRojo()?> </tbody></table></div>

</div>
    <div class="col-md-8 col-sm-8 col-xs-8"><button class="btn btn-danger" style="width: 100%" id="btnActividadesEnRojo" data-char="128071">&#128071</button></div>
</div>
 
</div>
<?}?>
<?php $this->load->view('footers/footer'); ?>


<?php 


function imprimirBotonesRamos($datosRamo,$totales,$personaTrabajaActividad){
    $boton="";
    $boton.='<a href="#seccionAgente" class="btnAgente">Agente</a>';
    $boton.='<a href="#cotizaciones" class="btncotizaciones">Cotizaciones</a>';
    $boton.='<a href="#otrasActividades" class="btnotrasActividades">Otras Actividades</a>';
    $boton.='<a href="#seccionEnCurso" class="btnAgente">En curso</a>';
    foreach ($datosRamo as $key => $value) {
        $abreviacion=$value->Abreviacion;
        $boton.='<a  href="#'.$value->Abreviacion.'" class="btnRamo'.$value->Abreviacion.' prueba">'.$value->Nombre.'<span class="spanTotal">'.$totales->$abreviacion.'</span></a>';
    }
    $boton.='<div id="divActividadTrabajandose">';
    foreach ($personaTrabajaActividad as $key => $value) {
        $boton.='<div class="row actividadesTrabajandose" data-idInterno="'.$value['idInterno'].'">'.$value['usuarioTrabaja'].'->'.$key.' ('.$value['usuarioResponsable'].')</div>';
    }
    $boton.='</div>';
    return $boton;
}
function  controlaSemaforos($tiempoSemaforo,$Status,$horasOficinaCP,$horasPortalCP,$tipoActividad,$responable='',$idInterno='',$folioActividad='')
{
    $imp=array();
    $imp['tiempoSemaforo']=$tiempoSemaforo;
    $imp['Status']=$Status;
    $imp['horasOficinaCP']=$horasOficinaCP;
    $imp['horasPortalCP']=$horasPortalCP;
    $imp['tipoActividad']=$tipoActividad;
    $imp['responable']=$responable;
    $imp['idInterno']=$idInterno;
    $imp['folioActividad']=$folioActividad;
    $ci = &get_instance();    
    $array=array();
    $array['tiempo']='tiempoNormal';
    $array['porcentajeTiempo']=0;
	$tiempo='tiempoNormal';
    $porcentajeTiempo=0;
    if($responable=='COBRANZA@ASESORESCAPITAL.COM')
    {
        $tipoActividad='Cotizacion';
        $horasPortalCP=336;

    }
	if($tipoActividad=="Emision" || $tipoActividad=="Cotizacion")
	{
      if($Status==5){
      	if($tiempoSemaforo!=NULL)
      	{
          if($tiempoSemaforo>$horasPortalCP){$tiempo="tiempoExcedido";$array['tiempo']="tiempoExcedido";}
          else{if((($tiempoSemaforo*100)/$horasPortalCP)>=70){$tiempo="tiempoAcabando";$array['tiempo']="tiempoAcabando";}}

          $array['porcentajeTiempo']=$horasPortalCP==0?100:($tiempoSemaforo*100)/$horasPortalCP;
        }
      else{$tiempo="sinTiempo";}

    }
    else{
      	 if($Status==2)
      	 {
           if($tiempoSemaforo!=NULL)
           { if($tiempoSemaforo>$horasOficinaCP){$tiempo="tiempoExcedido";$array['tiempo']="tiempoExcedido";}
             else{if((($tiempoSemaforo*100)/$horasOficinaCP)>=70){$tiempo="tiempoAcabando";$array['tiempo']="tiempoAcabando";}}
             $array['porcentajeTiempo']=$horasOficinaCP==0?100:(($tiempoSemaforo*100)/$horasOficinaCP);
           }
           else{$tiempo="sinTiempo";}
      	 }
        }
	}
    $ci->load->model("notificacionmodel");
    $notificacion['tabla']='actividadesenrojo';          
    $notificacion['tipo_id']='email';
    $notificacion['referencia']='COMENTARIO_ACTIVIDAD';
    $notificacion['referencia_id']='1002';
    $notificacion['check']=0;
    $notificacion['comentarioAdicional']='La actividad '.$folioActividad.' supero el limite permitido';
    $notificacion['id']=-1;        
    $notificacion['tipo']='OTRO';

    if($array['tiempo']=='tiempoNormal'){$semaforo='verde';}
    if($array['tiempo']=='tiempoAcabando')
    {

        $semaforo='amarillo';
     $consulta='select (count(idInterno)) as total from actividadesenrojo a where a.estaCerrado=0  and statusActividad="AMARILLO" and a.idInterno='.$idInterno;
     $result=$ci->db->query($consulta)->result()[0]->total;
             if($result==0)
        {

          $idPersona='1061';
          $email='GERENTECOMERCIAL@AGENTECAPITAL.COM';
          if($responable=='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM'){$idPersona='552';$email='COORDINADOROPERATIVO@ASESORESCAPITAL.COM';}


     $i['idInterno']=$idInterno;
     $i['folioActividad']=$folioActividad;
         $i['notificacionPara']=$email;
     $i['statusActividad']='AMARILLO';
     $ci->db->insert('actividadesenrojo',$i);
         $last=$ci->db->insert_id();         

         $notificacion['idTabla']=$last;
         $notificacion['persona_id']=$idPersona;//'552';
         $notificacion['comentarioAdicional']='La actividad '.$folioActividad.' se encuentra en semaforo amarillo';
         $notificacion['email']= $email; //'COORDINADOROPERATIVO@ASESORESCAPITAL.COM';
         $ultimoId=$ci->notificacionmodel->notificacion($notificacion);
         $actualizar['id']=$ultimoId;
         $actualizar['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad.'&id='.$ultimoId;
         $ci->notificacionmodel->actualizarNotificacion($actualizar);
       }
    }
    if($array['tiempo']=='tiempoExcedido')
    {
        
        $semaforo='rojo';
        $consulta='select (count(idInterno)) as total from actividadesenrojo a where a.estaCerrado=0 and a.notificacionPara="COORDINADOROPERATIVO@ASESORESCAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $consultaParaNC='select (count(idInterno)) as total from actividadesenrojo a where  a.notificacionPara="DIRECTORGENERAL@AGENTECAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $resultParaNC=$ci->db->query($consultaParaNC)->result()[0]->total;
        if($resultParaNC==0)
        {
          /*$correoProcedente='DIRECTORGENERAL@AGENTECAPITAL.COM';
          $fecharegistro=date('Y').'-'.date('m').'-'.date('d');
          $nombreProcedente='Edgar chan';
          $descripcion="El folio de la actividad ".$folioActividad." quedo en rojo";    
          //$nombreProcedente=$this->capsysdre->NombreUsuarioEmail($correoProcedente);
           $sqlInsert_Referencia = "Insert Ignore Into `inconformidades` (`descripcion`, `correoProcedente`,`nombreProcedente`,`fechaRegistro`) Values('".$descripcion."', '".$correoProcedente."','".$nombreProcedente."','".$fecharegistro."');";
            $ci->db->query($sqlInsert_Referencia);
            $referencia = $ci->db->insert_id();
            $insertar['nombreTabla']='inconformidades';
            $insertar['idRowTabla']=$referencia;
            $insertar['idPersonaInconforme']=6;
            $ci->procesamientoncmodel->insertarNC($insertar);*/
            
        }
        

         $consulta='select (count(idInterno)) as total from actividadesenrojo a where a.estaCerrado=0 and a.notificacionPara="GERENTECOMERCIAL@AGENTECAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $result=$ci->db->query($consulta)->result()[0]->total;        
         if($result==0)
         {
          $i['idInterno']=$idInterno;
          $i['folioActividad']=$folioActividad;
          $i['notificacionPara']='GERENTECOMERCIAL@AGENTECAPITAL.COM';
          $i['statusActividad']='ROJO';
          $ci->db->insert('actividadesenrojo',$i);
          $last=$ci->db->insert_id();
         $notificacion['idTabla']=$last;
         $notificacion['persona_id']=1;
         $notificacion['email']=  'GERENTECOMERCIAL@AGENTECAPITAL.COM';
         $ultimoId=$ci->notificacionmodel->notificacion($notificacion);
         $actualizar['id']=$ultimoId;
         $actualizar['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad.'&id='.$ultimoId;
         $ci->notificacionmodel->actualizarNotificacion($actualizar);
         }

        if($tiempoSemaforo>=72)
        {
         $consulta='select (count(idInterno)) as total from actividadesenrojo a where a.estaCerrado=0 and a.notificacionPara="DIRECTORGENERAL@AGENTECAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $result=$ci->db->query($consulta)->result()[0]->total;        
         if($result==0)
         {
          $i['idInterno']=$idInterno;
          $i['folioActividad']=$folioActividad;
          $i['notificacionPara']='DIRECTORGENERAL@AGENTECAPITAL.COM';
          $i['statusActividad']='ROJO';
          $ci->db->insert('actividadesenrojo',$i);
          $last=$ci->db->insert_id();
          $notificacion['idTabla']=$last;
         $notificacion['persona_id']='6';
         $notificacion['email']=  'DIRECTORGENERAL@AGENTECAPITAL.COM';
         $ultimoId=$ci->notificacionmodel->notificacion($notificacion);
         $actualizar['id']=$ultimoId;
         $actualizar['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad.'&id='.$ultimoId;
         $ci->notificacionmodel->actualizarNotificacion($actualizar);
         }
        }
    }
    
    //$ci->setSemaforo($idInterno,$semaforo);
    $array['porcentajeTiempo']=number_format($array['porcentajeTiempo'],2);
	return $array;
}

function imprimirArreglosGlobales($array,$nombreVariable)
{

$valores="";
$respuesta='let '.$nombreVariable.'=[';
  foreach ($array as $key => $value) 
  {

    $respuesta.='"'.$key.'",';

  }
  $respuesta=trim($respuesta,',');
  $respuesta.=']';

  return $respuesta;
}

function imprimirResponsables($datos)
{
    $respuesta='';
    $respuesta='<option value="">ESCOGER NUEVO RESPONSABLE</option>';
    foreach ($datos as $value) {$respuesta.='<option>'.$value->email.'</option>';}
    return $respuesta;
}

function imprimirActividadesEnRojo()
{
    $ci = &get_instance();
    $ci->load->model("capsysdre_actividades");
    $result=$ci->capsysdre_actividades->actividadesenrojo();  
    $actividadesEnRojo=array();
    foreach ($result as  $value) {$actividadesEnRojo[$value->folioActividad]=array();}
    #$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($actividadesenrojo,TRUE));fclose($fp);

    foreach ($result as  $value) 
    {
       
         
           foreach ($actividadesEnRojo as $key => $val) 
           {
            
              if($key==$value->folioActividad)
              {
                  array_push($actividadesEnRojo[$key], $value);
              }
           }
    }
    
    $tr='';
    foreach ($actividadesEnRojo as $key => $value) 
    {
      $tr.='<tr><td><button class="btn btn-success" name="btnFolioActRojo" data-folio="'.$key.'">+</button></td><td colspan="3"  ><a href="#'.$key.'link">'.$key.'</a></td></tr>';
      foreach ($value as  $val) 
      {
          $tr.='<tr name="'.$key.'CabRojo" class="ocultarObjeto"><td></td><td>Notificacion para:'.$val->notificacionPara.'</td><td>Responsable:'.$val->usuarioResponsable.'</td><td>fecha Aviso:'.$val->fechaInsercion.'</td></tr>';
      }
    }
    return $tr;
     
}

?>
<script type="text/javascript">
    function actualizar(i)
    {   
    let tipoFiltro = document.getElementById('selectTipoFiltro');
    let valorFiltro = document.getElementById('selectValorFiltro');
    let detenerRecarga = document.getElementById('detenerRecargaChecked');

    if (detenerRecarga && !detenerRecarga.checked) {
        if (tipoFiltro && valorFiltro) {
            let val1 = tipoFiltro.value;
            let val2 = valorFiltro.value;
            let datos = 'selectTipoFiltro=' + val1 + '&selectValorFiltro=' + val2;
            let direccion = '<?=base_url()?>actividades?' + datos;
            window.location.replace(direccion);
        } else {
            // const direccion = '<?=base_url()?>actividades?';
            // if (direccion) {
            //     window.location.replace(direccion);
            //     console.warn('RECARGANDO LA PAGINA');
            // }
            console.warn('Filtros no disponibles en el DOM. Se cancela recarga.');
           
        }
    }
    }
    setInterval("actualizar()",300000);
    <?= imprimirArreglosGlobales($filtroEstado,'filtroEstado');?>;
    <?= imprimirArreglosGlobales($filtroTipoActividad,'filtroTipoActividad');?>;
    <?= imprimirArreglosGlobales($filtroSubRamoActividad,'filtroSubRamoActividad');?>;
    <?= imprimirArreglosGlobales($filtroResponsable,'filtroResponsable');?>;
    function escogerFiltroRows(objeto)
    {
        let rows=document.getElementsByName('trEnCurso');
        let cantidad=rows.length;
        for(let i=0;i<cantidad;i++){rows[i].classList.remove('ocultarObjeto')}
        let data=objeto.dataset.tipofiltro;   
        if(objeto.value!='')
        {
        for(let i=0;i<cantidad;i++){if(rows[i].getAttribute('data-'+data)!=objeto.value){rows[i].classList.add('ocultarObjeto')}}
        }
        
    }
    function escogerTipoFiltro(value)
    {
        let rows=document.getElementsByName('trEnCurso');
        let cantidad=rows.length;
        for(let i=0;i<cantidad;i++){rows[i].classList.remove('ocultarObjeto')}
        let opciones='';
        let cant;
        let opcionFiltro="";
        switch(value)
        {
            case 'NINGUNO':          
            
            break;
            case 'ESTADO':
            cant=filtroEstado.length
            opciones='<option value="NINGUNO">SELECCIONAR ESTADO</option>'
            for(let i=0;i<cant;i++){opciones=opciones+'<option value="'+filtroEstado[i]+'">'+filtroEstado[i]+'</option>';}
                opcionFiltro='estado';
            break;
            case 'TIPO ACTIVIDAD':
            cant=filtroTipoActividad.length
            opciones='<option value="NINGUNO">SELECCIONAR TIPO ACTIVIDAD</option>'
            for(let i=0;i<cant;i++){opciones=opciones+'<option value="'+filtroTipoActividad[i]+'">'+filtroTipoActividad[i]+'</option>';}
            opcionFiltro='tipoactividad';
            break;
            case 'SUB RAMO':
            cant=filtroSubRamoActividad.length
            opciones='<option value="NINGUNO">SELECCIONAR SUBRAMO</option>'
            for(let i=0;i<cant;i++){opciones=opciones+'<option value="'+filtroSubRamoActividad[i]+'">'+filtroSubRamoActividad[i]+'</option>';}        
            opcionFiltro="subramo";
            break;
            case 'RESPONSABLE':
            cant=filtroResponsable.length
            opciones='<option value="NINGUNO">SELECCIONAR RESPONSABLE</option>'
            for(let i=0;i<cant;i++){opciones=opciones+'<option value="'+filtroResponsable[i]+'">'+filtroResponsable[i]+'</option>';}        
            opcionFiltro="responsable";
            break;
        }
        selectValorFiltro.innerHTML=opciones;
        selectValorFiltro.dataset.tipofiltro=opcionFiltro;
    }

    function trabajarActividad(datos,objeto){
    if(datos==""){
    var checkbox=document.getElementsByName('cbTrabajarActividad');
    let cant=checkbox.length;
    var params = "idInterno="+objeto.value+"&ajax=1&status="+objeto.checked;
    //for(let i=0;i<cant;i++){checkbox[i].checked=false;}
        
        controlador="actividades/trabajarActividad/?";
    peticionAJAX(controlador,params,'trabajarActividad');

    }else{

        var checkbox=document.getElementsByName('cbTrabajarActividad');
        let cant=checkbox.length;
        for(let i=0;i<cant;i++){if(checkbox[i].value==datos.idInterno){checkbox[i].checked=datos.status;i=cant;}}

        if(datos.status==false){
            let actTrabajar=document.getElementsByClassName('actividadesTrabajandose');
            let cantidad=actTrabajar.length;
            for (var i = 0; i < cantidad; i++) {
                if(actTrabajar[i].getAttribute('data-idInterno')==datos.idInterno){
                    let padre=actTrabajar[i].parentNode;
                    padre.removeChild(actTrabajar[i]);
                    i=cantidad;
                } 	
            }
        }
        else{
            let actTrabajar=document.getElementsByClassName('actividadesTrabajandose');
            let cantidad=actTrabajar.length;
            let bandExistencia=0;
            for (var i = 0; i < cantidad; i++) {
                if(actTrabajar[i].getAttribute('data-idInterno')==datos.idInterno){
                    bandExistencia=1;
                } 	
            }
    
            if(bandExistencia==0){
                var div=document.createElement('div');
            // actividadesTrabajandose
                div.setAttribute('class','row actividadesTrabajandose');
                div.setAttribute('id',datos.idInterno);
                div.innerHTML=datos.usuarioTrabaja+'->'+datos.folioActividad+' ('+datos.usuarioResponsable+')';

                document.getElementById('divActividadTrabajandose').appendChild(div);

            }
        }
        if(datos.mensaje!=''){alert(datos.mensaje);}
    }

    }


    function peticionAJAX(controlador,parametros,funcion){
    var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
    var url=direccionAJAX+controlador;//+parametros;
    //abreCierraEspera();
    req.open('POST', url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function (aEvt) 
    {
        if (req.readyState == 4) {
        if(req.status == 200)
            { 
            
            var respuesta=JSON.parse(this.responseText);    
        
            switch(funcion){
            case 'trabajarActividad':trabajarActividad(respuesta,'');break;
            default:  window[funcion](respuesta);break; 

            }                                                           
        }     
    }
    };
    req.send(parametros);
    }


    function nuevaVentana(e,objeto){
            e.preventDefault();

        window.open(objeto.getAttribute('href'));
    }
    function calificacionMala(e,objeto){
    e.preventDefault();
    var textoEscrito = prompt("Motivo de calificacion mala", "");
    if(textoEscrito != null ){
        if(textoEscrito!=''){direccion=objeto.getAttribute('href')+'&comentario='+textoEscrito;window.location.href=direccion;}
        else{alert("El comentario es obligatorio");}
    }
    


    
    }
    function seleccionar_todo(nombreFormulario)
    { 
        var f = document.forms[nombreFormulario.name];for (i=0;i<f.elements.length;i++) {if(f.elements[i].type == "checkbox"){f.elements[i].checked=1}}
    }
    function deseleccionar_todo(nombreFormulario)
    {var f = document.forms[nombreFormulario.name];for(i=0;i<f.elements.length;i++){if(f.elements[i].type == "checkbox"){f.elements[i].checked=0 }}}
    function todas(nombreFormulario, tipoTodas){var f = document.forms[nombreFormulario.name];f.tipo.value = tipoTodas;f.submit();}

</script>
<!-- <style type="text/css">.tiempoExcedido{background-color: red;color:white}.tiempoAcabando{background-color: orange;color: white}.tiempoNormal{background-color: green;color:white}.sinNormal{background-color: white;color:black}.divPromotoria p {color: white;background-color:#0857b9;display: none}.divPromotoria div {}.divPromotoria:hover {cursor:pointer;}.divPromotoria:hover  p{display: inline-flex;height:50px; width: 150px; overflow: auto;} .btnRam{padding: 2px; border: solid black 1px; color: black; background-color: #b4a5cb}.btnRamoFIANZAS{color: black;background-color:#fdd792;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px	}.btnRamoDANOS{color: black;background-color:#fdd792;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnRamoVEHICULOS{color: black;background-color:#7474c3;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnRamoACCIDENTES_Y_ENFERMEDADES{color: black;background-color:#e26666;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnRamoVIDA{color: black;background-color:#7bdc77;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btncotizaciones{color: black;background-color:#8762c8;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnotrasActividades{color: black;background-color:#afd584;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnAgente{color: black;background-color:#e68f6f;padding: 2px;border: solid black 1px;width: 110px}.btnEnCurso{color: black;background-color:#89cbd3;padding: 2px;border: solid black 1px;width: 110px}.divBotones{display: list-item; width: 300px}.menuFlotante{border: solid;width: 200px}.menuFlotante  a{display: block;}.contMenuFlotante{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 10px;right: 140px;margin-left: -10px;padding: 10px 0 0;position: fixed;text-align: center;width: 20px;z-index: 10000;padding: 0px; margin: 0px;}.vertical-menu {width: 15px;}.vertical-menu a {display: block;padding: 0px;text-decoration: none;}.vertical-menu a:hover {background-color: #ccc;}.vertical-menu a.active { color: red;}.tituloAgente{color: black;background-color:#e68f6f; font-size:1.5em; width: 100%; height: 30px}.tituloAgente > a{color: black;}.tituloEnCurso{color: black;background-color:#89cbd3; font-size:1.5em; width: 100%; height: 30px}
   .prueba:focus {color:pink;}
   a:active {color: blue;}
   .spanTotal{    ; color:white;background-color: black; border: solid .01em black}
   .actividadesTrabajandose{width:300px;border-bottom:solid black; color:white; background-color:green; position:relative;left:-150px}
   .ocultarObjeto{display: none;}
   .seleccionRowCambioResponsable{color: white;background-color: green;}
   .seleccionRowCambioResponsable > td{color: white;background-color: green}
   
</style> -->

<style type="text/css">/*<!--Codigo-formateado-visualmente-Ing.Roberto-Alvarez-22/abril/2025-->*/
  .tiempoExcedido {
    background-color: red;
    color: white;
  }

  .tiempoAcabando {
    background-color: orange;
    color: white;
  }

  .tiempoNormal {
    background-color: green;
    color: white;
  }

  .sinNormal {
    background-color: white;
    color: black;
  }

  .divPromotoria p {
    color: white;
    background-color: #0857b9;
    display: none;
  }

  .divPromotoria div {}

  .divPromotoria:hover {
    cursor: pointer;
  }

  .divPromotoria:hover p {
    display: inline-flex;
    height: 50px;
    width: 150px;
    overflow: auto;
  }

  .btnRam {
    padding: 2px;
    border: solid black 1px;
    color: black;
    background-color: #b4a5cb;
  }

  .btnRamoFIANZAS{
    color: black;
    background-color: #fdd792;
    padding: 2px;
    border: solid black 1px;
    width: 140px;
    margin-left: 5px;
  }
  .btnRamoDANOS {
    color: black;
    background-color: #fdd792;
    padding: 2px;
    border: solid black 1px;
    width: 140px;
    margin-left: 5px;
  }

  .btnRamoVEHICULOS {
    color: black;
    background-color: #7474c3;
    padding: 2px;
    border: solid black 1px;
    width: 140px;
    margin-left: 5px;
  }

  .btnRamoACCIDENTES_Y_ENFERMEDADES {
    color: black;
    background-color: #e26666;
    padding: 2px;
    border: solid black 1px;
    width: 140px;
    margin-left: 5px;
  }

  .btnRamoVIDA {
    color: black;
    background-color: #7bdc77;
    padding: 2px;
    border: solid black 1px;
    width: 140px;
    margin-left: 5px;
  }
  
  .btnRamoCREDITO {/* CLASE AÑADIDA POR ING ROBERTO ALVAREZ 23/ABRIL/2025*/
    color: black;
    background-color: #7474c3;
    padding: 2px;
    border: solid black 1px;
    width: 140px;
    margin-left: 5px;
  } /* CLASE AÑADIDA POR ING ROBERTO ALVAREZ 23/ABRIL/2025 */

  .btncotizaciones {
    color: black;
    background-color: #8762c8;
    padding: 2px;
    border: solid black 1px;
    width: 140px;
    margin-left: 5px;
  }

  .btnotrasActividades {
    color: black;
    background-color: #afd584;
    padding: 2px;
    border: solid black 1px;
    width: 140px;
    margin-left: 5px;
  }

  .btnAgente {
    color: black;
    background-color: #e68f6f;
    padding: 2px;
    border: solid black 1px;
    width: 110px;
  }

  .btnEnCurso {
    color: black;
    background-color: #89cbd3;
    padding: 2px;
    border: solid black 1px;
    width: 110px;
  }

  .divBotones {
    display: list-item;
    width: 300px;
  }

  .menuFlotante {
    border: solid;
    width: 200px;
  }

  .menuFlotante a {
    display: block;
  }

  .contMenuFlotante {
    background: #FFFFFF;
    border: 1px solid #DDDDDD;
    border-radius: 6px;
    bottom: 10px;
    right: 140px;
    margin-left: -10px;
    padding: 0;
    position: fixed;
    text-align: center;
    width: 20px;
    z-index: 10000;
    margin: 0;
  }

  .vertical-menu {
    width: 15px;
  }

  .vertical-menu a {
    display: block;
    padding: 0;
    text-decoration: none;
  }

  .vertical-menu a:hover {
    background-color: #ccc;
  }

  .vertical-menu a.active {
    color: red;
  }

  .tituloAgente {
    color: black;
    background-color: #e68f6f;
    font-size: 1.5em;
    width: 100%;
    height: 30px;
  }

  .tituloAgente > a {
    color: black;
  }

  .tituloEnCurso {
    color: black;
    background-color: #89cbd3;
    font-size: 1.5em;
    width: 100%;
    height: 30px;
  }

  .prueba:focus {
    color: pink;
  }

  a:active {
    color: blue;
  }

  .spanTotal {
    color: white;
    background-color: black;
    border: solid 0.01em black;
  }

  .actividadesTrabajandose {
    width: 300px;
    border-bottom: solid black;
    color: white;
    background-color: green;
    position: relative;
    left: -150px;
  }

  .ocultarObjeto {
    display: none;
  }

  .seleccionRowCambioResponsable {
    color: white;
    background-color: green;
  }

  .seleccionRowCambioResponsable > td {
    color: white;
    background-color: green;
  }
</style><!--Codigo-formateado-visualmente-Ing.Roberto-Alvarez-22/abril/2025-->

<?if(isset($selectTipoFiltro)){?>
<script type="text/javascript">
  document.getElementById('selectTipoFiltro').value="<?=$selectTipoFiltro?>"; 
  escogerTipoFiltro(document.getElementById('selectTipoFiltro').value); 
  document.getElementById('selectValorFiltro').value="<?=$selectValorFiltro?>";
  escogerFiltroRows(document.getElementById('selectValorFiltro'));
</script>

<?}?>
<script type="text/javascript">
function seleccionarRow(objeto){objeto.classList.toggle('seleccionRowCambioResponsable');}    
function cambiarResponsablesNuevos(datos='')
{
    // console.log(datos);// esto me devuelve este valor {success: 1}
    if(datos=='')
  {
    // console.log('entro a la petició ajax');
    let clase=document.getElementsByClassName('seleccionRowCambioResponsable');
    let cant=clase.length;
    let idInterno='';
    for(let i=0;i<cant;i++){idInterno+=clase[i].dataset.idinterno+',';}
    // console.log('idInterno');
    // console.log(idInterno);
    if(idInterno!='')
    {
        // console.log('entro al idInterno');
     let valor=document.getElementById('nuevoResponsableSelect').value;
    //  console.log('valor del valor');
    //  console.log(valor);
     if(valor!='')
     {      
    //   console.log('entro dentro del IF valor');
      var params = "idInterno="+idInterno;    
      params+='&nuevoResponsable='+valor; 
      controlador="actividades/cambiarResponsablesNuevos/?";
      peticionAJAX(controlador,params,'cambiarResponsablesNuevos'); 
      Swal.fire
            ({
                title: "Cambio realizado Correctamente",
                icon: "success",
                draggable: true
            });     
     }
     else{alert('Escoger nuevo responsable')}

    }
    else{alert('Escoger actividad para cambiar de responsable');}



  }
  else
  {
    // console.log('entro en el else de if(datos==)');
    document.getElementById('detenerRecargaChecked').checked=false;
     
    actualizar();//<!--------------------------------------------------------------------------------------------------------------->
    // console.log('entro en el else de if(datos==)');
    // let detenerRecarga = document.getElementById('detenerRecargaChecked');
    // if (detenerRecarga) detenerRecarga.checked = false;

    // // Redirige directamente a la vista principal
    // window.location.href = '<?=base_url()?>actividades';
  }

}
</script>
<style type="text/css">
    progress{height: 30px;color:red;width: 100%;background-color: black;}
    #folioBuscado{z-index: 0}
</style>
<script type="text/javascript">
    document.getElementById('btnActividadesEnRojo').addEventListener("click", function(){
        document.getElementById('divActividadesEnRojo').classList.toggle('ocultarObjeto');
        if(this.dataset.char==128071){this.dataset.char='128070';this.innerHTML='&#128070';}
        else{this.dataset.char=128071;this.innerHTML='&#128071';}
    })
    let actRojo=document.querySelectorAll('button[name=btnFolioActRojo]');
    actRojo.forEach(b=>{b.addEventListener("click",function(){
        
        let hijos=document.querySelectorAll(`tr[name=${b.dataset.folio}CabRojo]`);
        if(this.innerHTML=='+'){this.innerHTML='-';hijos.forEach(h=>{h.classList.remove('ocultarObjeto');})}else{this.innerHTML='+';hijos.forEach(h=>{h.classList.add('ocultarObjeto');})}
        
    })})
    
    document.getElementById('divActividadesEnRojo').classList.toggle('ocultarObjeto');
</script>

<script type="text/javascript">
  
  if(document.getElementById('divEjecutivosOperativos'))

  {
    document.getElementById('divEjecutivosOperativos').parentNode.removeChild(document.getElementById('divEjecutivosOperativos'));
  }
</script>


<!---------------------------------Ing.Roberto-Alvarez-24-Abril-2025--------------------------------->
<!-- Cargar Vue.js -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/js/vue-actividades.min.js"></script> -->
<script type="text/javascript">
        function init() {
        var baseUrlElement = document.getElementById("base_url");
        if (baseUrlElement) {
            var ruta = baseUrlElement.getAttribute('data-base-url');
            var apiObtenerSemaforo = ruta + 'actividades/obtener_semaforo'; // URL de la API de Actividades
            var apiActNoTrab = ruta + 'actividades/verActNoTrab';
        } else {
            console.error('El div "base_url" no se encuentra en el DOM.');
        }
        if (typeof Vue !== 'undefined') {
            // console.log(typeof Vue);
        new Vue({
        el: "#verActividadesVue",
        data: {
            ObtenerActividad:[],//Se almacenan todas las actividades
            obtenerSemaforo: [],//almacena todos los nuevos semaforos
            obtenerActNoTrab:[],
            apiObtenerSemaforo:apiObtenerSemaforo,//se inicializa la variable con el link de la api
            baseUrl: '<?=base_url()?>', // Define la URL base manualmente o pásala desde el backend
            tipoUsuario: 1, // Asegúrate de recibir este valor desde la API o definirlo manualmente
            apiActNoTrab:apiActNoTrab,
            filtroSeleccionado:'true',
            valorFiltro:'',
            opcionesFiltro:[],
            intervaloID: null,
            mostrarMenu: true,

            

        },
        created: function() {//crea funciones al mismo tiempo en la que se crea la pagina
                this.intervaloFunciones();//primera función que se ejecuta al crear la pagina.
                this.obtenerActNoTrabs();//funcion que trae las Actividades No Trabajadas 
                
               
        },
        
        methods: {  
        
            recargarActividades() {
            // $('#contenedorActividades').load('http://localhost/Capsys/www/V3/actividades');
            fetch('<?=base_url()?> V3/actividades')
            .then(response => response.text())
            .then(html => {
            document.getElementById('contenedorActividades').innerHTML = html;
            });
            },
            mostrarInfoUsuario(row) {
                const creador = `<br /><b>Creador:</b> ${row.nombreUsuarioCreacion || row.usuarioCreacion} [${row.usuarioCreacion}]`;
                let vendedor = '';
                if (row.usuarioVendedor && row.usuarioVendedor !== row.usuarioCreacion) {
                    vendedor = `<br /><b>Vendedor:</b> ${row.nombreUsuarioVendedor} [${row.usuarioVendedor}]`;
                }
                let datosAgente = '';
                if (row.datosAgente) {
                    datosAgente = `<br />${row.datosAgente.idpersonarankingagente || ''} ${row.datosAgente.personaTipoAgente || ''}`;
                }
                return creador + vendedor + datosAgente;
            },

            persiana() {
                this.mostrarMenu = !this.mostrarMenu;
            },
            getNamRamojob(abreviacion) {
                // actividades: es un array de objetos que representa un ramo específico
                // abreviacion: es una cadena que representa la clave del ramo (ej. "VIDA", "AUTO")

                // console.log(actividades, 'actividades'); // Muestra en consola el contenido del array de actividades por ramo
                // console.log(abreviacion, 'abreviación'); // Muestra en consola la abreviación o clave del ramo actual

                // Verifica si hay actividades y si el primer objeto tiene el campo 'NombreRamo'
                // if (actividades && actividades.length > 0 && actividades[0].NombreRamo) {
                //     return actividades[0].NombreRamo; // Retorna el nombre del ramo desde el primer objeto del array
                // }

                // // Si no hay nombre de ramo en los datos, se retorna la abreviación como fallback
                // return abreviacion;
                // console.log(abreviacion, 'abreviacion');
                if (!abreviacion) return '';//Si el texto está vacio, nulo  o indefinido, retorna una cadena vacia para evitar errores
                return abreviacion.charAt(0).toUpperCase()+ abreviacion.slice(1);
                //Convierte la primera letra del texto a mayúscula y concatena el resto del texto tal cual
                //Ejemplo "danos" => Danos 
            },

            getNamActNoJob(texto) {
                // console.log(texto, 'texto');// texto: cadena de texto que representa el nombre de una categoría (ej. "cotizaciones", "otrasActividades")
                if (!texto) return ''; // Si el texto está vacío, nulo o indefinido, retorna una cadena vacía para evitar errores
                return texto.charAt(0).toUpperCase() + texto.slice(1);
                // Convierte la primera letra del texto a mayúscula y concatena el resto del texto tal cual
                // Ejemplo: "cotizaciones" => "Cotizaciones"
            },
            calificarActividad(tipo, row) {
                const url = `<?=base_url()?>actividades/calificarActividad?folioActividad=${row.folioActividad}&satisfaccion=${tipo}&tipoActividad=Actividad&IDDocto=${row.idSicas}&ClaveBit=${row.ClaveBit}&idInterno=${row.idInterno}`;

                Swal.fire({
                    title: '¿Está seguro de calificar esta actividad?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, calificar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar alerta de procesamiento
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: '¡Aplicando calificación!',
                        //     text: 'Espere un momento...',
                        //     timer: 2000,
                        //     showConfirmButton: false
                        // });
                        Swal.fire({
                                    icon: 'success',
                                    title: '¡Cambio aplicado!',
                                    text: 'La actividad ha sido calificada correctamente.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });


                        // Primero quitamos la actividad del listado
                        for (const key in this.obtenerActNoTrab) {
                            if (Array.isArray(this.obtenerActNoTrab[key])) {
                                const index = this.obtenerActNoTrab[key].findIndex(act => act.idInterno === row.idInterno);
                                if (index !== -1) {
                                    this.obtenerActNoTrab[key].splice(index, 1);
                                    break;
                                }
                            }
                        }

                        // Ahora hacemos la solicitud fetch
                        fetch(url, { method: 'GET' })
                            .then(response => {
                                if (!response.ok) throw new Error("Error en la solicitud");
                                return response.text();
                            })
                            .then(() => {
                                // Mostrar alerta de éxito
                                // Swal.fire({
                                //     icon: 'success',
                                //     title: '¡Cambio aplicado!',
                                //     text: 'La actividad ha sido calificada correctamente.',
                                //     timer: 2000,
                                //     showConfirmButton: false
                                // });
                                //this.obtenerSemaforos(); // Refrescar semáforos
                            })
                            .catch(error => {
                                console.error("Error al calificar:", error);
                                // Mostrar alerta de error
                                Swal.fire({
                                    icon: 'error',
                                    title: '¡Error!',
                                    text: 'Hubo un problema al calificar la actividad.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // Mostrar alerta si el usuario cancela
                        Swal.fire({
                            icon: 'info',
                            title: 'Acción cancelada',
                            text: 'No se realizó ninguna calificación.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            },



            actualizarSemaforos: function(length) {// INICIA VERSIÓN ESTABLE PARA MODIFICAR CUANDO YA SE TENGA EL ROBOTITO
                        //hay una version diferente que igualmente funciona views/prueba.php actualizarSemaforos: function()
                        //se accede a los objetos dentro de los arrays 
                    const actividadesArray = Object.values(this.ObtenerActividad).flatMap(category => category);// Obtener todas las actividades agrupadas desde this.ObtenerActividad
                    const semaforosActualizados = Object.values(this.obtenerSemaforo).flatMap(category => category);// Obtener todos los datos actualizados del semáforo desde this.obtenerSemaforo
                    actividadesArray.forEach(actividad => {// Recorremos las actividades actuales para actualizar sus valores
                        let nuevaInfo = semaforosActualizados.find(row => row.idInterno === actividad.idInterno); // Buscar el objeto con el mismo idInterno en la lista de semáforos actualizados
                        
                        // console.log(nuevaInfo);
                        if (nuevaInfo) {// Si encontramos una coincidencia, actualizamos los valores reactivamente
                            actividad.nuevoSemaforo = nuevaInfo.nuevoSemaforo;//actualiza los objetos de this.ObtenerActividad
                            actividad.Status_Txt = nuevaInfo.Status_Txt;//actualiza los objetos de this.ObtenerActividad
                            actividad.usuarioResponsable = nuevaInfo.usuarioResponsable;
                            // Puedes agregar más campos aquí si necesitas sincronizar más datos
                        }
                    });
                },//TERMINA VERSIÓN ESTABLE PARA MODIFICAR CUANDO YA SE TENGA EL ROBOTITO
                intervaloFunciones: function(length) {
                    
                    const semaforo = Object.values(this.obtenerSemaforo).flatMap(category => category);

                    if (semaforo.length === 0) {//si semaforo esta vacio quiere decir que es la primera carga 
                        // console.log('primera carga');
                        this.obtenerSemaforos(); // Primera carga que trae todos los datos que se visualizan en las tablas 
                    } else if (length !== 0) {//cualquiera de las 2 condiciones se cumplan, quiere decir que ya se obtuvieron los datos correctamente 
                        // Si ya se cargó y no hay un intervalo corriendo
                        // console.log('va a empezar el intervalo', this.intervaloID);
                        this.intervaloID = setInterval(() => {//empieza el intervalo que mira la base de datos 
                            // console.log("INTERVALO",this.intervaloID);
                            axios.get(this.apiObtenerSemaforo + '/true')
                                .then(response => {
                                    if (response.data) {
                                        const nuevosSemaforos = response.data;//se extraen los datos y se almacenan en una constante 
                                        this.obtenerSemaforo = nuevosSemaforos;//se inicializa la variable
                                        //aplanamos los array para poder mirar sus objetos 
                                        const actividades = Object.values(this.ObtenerActividad).flatMap(category => category);
                                        const semaforos = Object.values(this.obtenerSemaforo).flatMap(category => category);
                                        // console.log('semaforos', semaforos.length);
                                        // console.log('actividad', actividades.length);
                                        if (semaforos.length !== actividades.length) {//se comparan para saber si se elimino o se añado algun array 
                                            // console.log('semaforo != actividad se comparan para saber si se elimino o se añado algun array');
                                            this.obtenerSemaforo = [];//se limpia la variable para evitar duplicados
                                            // this.obtenerSemaforos();//se vuelven a estraer los datos
                                            // this.obtenerActNoTrabs();//se obtienen las actividades no trabajadas para actualizar  
                                            axios.get(this.apiActNoTrab)
                                                .then(json => {
                                                    this.obtenerActNoTrab = json.data || [];
                                                    // console.log('Datos NoTrab:', this.obtenerActNoTrab);
                                                    this.reiniciarSilentemente();
                                                })
                                                .catch(error => {
                                                    console.error("Error al extraer datos :", error);
                                                    // Swal.fire({
                                                    //     title: "Error al extraer datos apiActNoTrab",
                                                    //     text: "SE VA A REINICIAR SILENCIOSAMENTE",
                                                    //     icon: "error"
                                                    // });
                                                    // Intentamos reiniciar silenciosamente
                                                    // Esperamos un momento para ver si el reinicio fue exitoso
                                                });
                                        } else { 
                                            this.actualizarSemaforos();
                                        }
                                    } else {
                                        this.obtenerSemaforo = [];
                                    }
                                })
                                .catch(error => {
                                    console.error("Error al extraer datos:", error);
                                    // Si el error es por sesión expirada o datos vacíos, tratamos como sesión no activa
                                    // Swal.fire({
                                    //     title: "Sesión inactiva o error al obtener datos",
                                    //     text: "Se reiniciará la sesión automáticamente",
                                    //     icon: "warning"
                                    // });
                                    // Reinicio silencioso
                                    this.reiniciarSilentemente();
                                });
                        }, 120000); // cada 2 minutos
                    }
                },
                obtenerSemaforos: function() {
                    if (this.obtenerSemaforo.length === 0) {//
                        axios.get(this.apiObtenerSemaforo + '/false').then(response => {
                            if (response.data) {
                                this.obtenerSemaforo = response.data;
                                this.ObtenerActividad = response.data;

                                const actividadesArray = Object.values(this.obtenerSemaforo).flatMap(c => c);
                                if (actividadesArray.length !== 0) {//verifica que si se hayan traido los datos 
                                        
                                     this.intervaloFunciones(actividadesArray.length);//comienza el intervalo para observar la base de datos 
                                    this.actualizarSemaforos();
                                   }
                            }
                        })
                        .catch(error => {
                            console.error("Error al extraer datos:", error);
                            Swal.fire({
                                title: "Error al extraer datos",
                                text: "SE VA A REINICIAR SILENCIOSAMENTE",
                                icon: "error"
                            });
                            // Intentamos reiniciar silenciosamente
                            this.reiniciarSilentemente()
                            // Esperamos un momento para ver si el reinicio fue exitoso

                        });               
                    }
                },
                reiniciarSilentemente() {
                    console.log("Intentando reinicio silencioso...");
                    this.limpiarIntervalo(); // detenemos el intervalo actual
                    // this.obtenerSemaforo = [];
                    // this.ObtenerActividad = [];
                    // this.obtenerActNoTrab = [];
                    this.valorFiltro = '';
                    this.filtroSeleccionado = 'true';
                    this.obtenerSemaforos(); // vuelve a cargar como si fuera el inicio
                    this.obtenerActNoTrabs(); // también vuelve a cargar actividades no trabajadas
                    this.verific();
                },
                verific(){
                    setTimeout(() => {
                                const datosCargados = Object.values(this.obtenerSemaforo).flatMap(c => c);
                                if (datosCargados.length === 0) {
                                    Swal.fire({
                                        title: "Error",
                                        text: "No se pudieron obtener los datos después de varios intentos.",
                                        icon: "error"
                                    });
                                    window.location.reload();
                                }else{
                                }
                            }, 30000); // dale chance de 4 segundos
                },
                comenzarIntervalo(){
                    console.log('comenzarIntervaloNuevamente')
                    this.intervaloFunciones(); // vuelve a cargar como si fuera el inicio
                    this.obtenerActNoTrabs(); // también vuelve a cargar actividades no trabajadas
                },
                limpiarIntervalo: function() {  //en caso de querer detener el intervalo solo llamar esta función
                        console.log(this.intervaloID);
                        clearInterval(this.intervaloID);
                        console.log(this.intervaloID);
                        this.intervaloID = null;//
                    
                },
                obtenerActNoTrabs(){
                    axios.get(this.apiActNoTrab)
                        .then(json => {
                            if (json) {
                                // console.log('se obtuvieron los datos');
                                this.obtenerActNoTrab = [];//se limpia la variable para evitar duplicados 
                                this.obtenerActNoTrab = json.data;//asignan los datos a la variable 
                                // console.log(this.obtenerActNoTrab);
                            }
                        }).catch(error => {
                            Swal.fire({
                                    title: "Error",
                                    text: "No se pudieron obtener los datos",
                                    icon: "error"
                                });
                        });
                },
                actualizarOpcionesFiltro() {
                    if (this.filtroSeleccionado === "true") {
                    this.opcionesFiltro = []; // Limpiar el segundo select
                    this.valorFiltro = '';    // Reiniciar valor seleccionado
                    return;
                    }else{
                        if (this.filtroSeleccionado != "true") {
                            const valores = new Set();
                            const actividades = Object.values(this.ObtenerActividad).flatMap(category => category);//obtiene todos los objetos de los arrays anidados
                            // console.log(actividades);

                            actividades.forEach(actividad => {
                                if (actividad[this.filtroSeleccionado]) {
                                valores.add(actividad[this.filtroSeleccionado]);
                                }
                            });
                            this.opcionesFiltro = Array.from(valores).sort();//opciones filtros se guarda todas las opciones 
                            // console.log(this.opcionesFiltro);//en consola me sale undefined pero en el select ya me aparece las opciones
                            this.valorFiltro = ''; // Reinicia el valor del segundo select
                        }
                    } 
                },
                cambiarResponsablesNuevosVue: function(){
                    this.obtenerSemaforo=[];
                    
                    this.obtenerSemaforos();
                    cambiarResponsablesNuevos();//HABLA UNA FUNCIÓN GLOBAL DE OTRO SCRIPT GLOBAL 
                },
                // todasVue(nombreFormulario, tipoTodas){
                //     // var f = document.forms[nombreFormulario.name];f.tipo.value = tipoTodas;f.submit();
                // todas(nombreFormulario, tipoTodas)//HABLA UNA FUNCIÓN GLOBAL DE OTRO SCRITP GLOBAL
                // },
                todasVue(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: '¿Está seguro de realizar la siguiente acción?',
                        text: "Esta acción no se puede deshacer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, continuar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {//SI LA RESPUESTA ES CONFIRMADA ENTONCES 
                            Swal.fire({
                                icon: 'success',
                                title: '¡APLICANDO EL CAMBIO!',
                                text: 'ESPERE UN MOMENTO',
                                timer: 5000,
                                showConfirmButton: false
                            });
                            const form = event.target.form;
                            form.tipo.value = 'terminarTodas';
                            const formData = new FormData(form);
                            fetch(form.action, {
                                method: form.method,
                                body: formData
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log('Respuesta recibida:', data);
                                this.obtenerActNoTrabs();
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡CAMBIO APLICADO!',
                                    text: 'ÉXITO',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            })
                            .catch(error => {
                                console.error('Error al enviar:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: '¡ERROR AL REALIZAR EL CAMBIO!',
                                    text: 'ERROR',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {//SI LA RESPUESTA ES CANCELADO ENTONCES 
                            Swal.fire({
                                icon: 'info',
                                title: 'Acción cancelada',
                                text: 'No se realizó ningún cambio',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });
                },

            },
        computed: {
            actividadesFiltradas() {
                    if (this.filtroSeleccionado === "true" || !this.valorFiltro) {
                        return this.ObtenerActividad;
                    }

                    const filtro = this.valorFiltro.toLowerCase().trim();

                    // Agrupamos por la misma key pero solo con actividades que pasen el filtro
                    const resultado = {};

                    for (const [key, actividades] of Object.entries(this.ObtenerActividad)) {
                        const filtradas = actividades.filter(actividad => {
                            const valor = actividad[this.filtroSeleccionado];
                            return valor && valor.toLowerCase().includes(filtro);
                        });

                        if (filtradas.length > 0) {
                            resultado[key] = filtradas;
                        }
                    }
                    return resultado;
                },
            
            },
        
        mounted() {//carga hasta inicie toda la pagina
                // this.realizarBusqueda();
                
        },
        watch: {//mira en tiempo real 
            

        },
        });
    } else {
        console.error("Vue no se ha cargado correctamente.");
    }
    } window.onload = init;
</script>