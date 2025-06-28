<?php $this->load->view('actividades/actividadesComentariosOperativos');?>
<?php
$userResponsable=$this->tank_auth->get_usermail();
$permisoCambioResponsable=0;
$panelParaActivdadesEnRojo=false;
if($userResponsable=='SISTEMAS@ASESORESCAPITAL.COM' || $userResponsable=='COORDINADOROPERATIVO@ASESORESCAPITAL.COM' ){$permisoCambioResponsable=1;}
if($userResponsable=='SISTEMAS@ASESORESCAPITAL.COM' || $userResponsable=='COORDINADOROPERATIVO@ASESORESCAPITAL.COM' || $userResponsable=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $userResponsable=='GERENTEOPERATIVO@AGENTECAPITAL.COM'){$panelParaActivdadesEnRojo=true;}
?>

<style>
    #dragable { width: 200px; height: auto; padding: 0.5em;opacity: 0.9 }

</style>



<script type="text/javascript">
    var ct=0;
    function persiana(){
        /*if(ct==0){
            document.getElementById('dragable').style.height='30px';
            $('#flecha').toggleClass('fa-arrow-circle-o-up');
            ct=1;
       }else{
             document.getElementById('dragable').style.height='auto';
             $('#flecha').toggleClass('fa-arrow-circle-o-down');
             ct=0;
       } */
       if(document.getElementsByClassName('vertical-menu')[0].style.display=='none'){document.getElementsByClassName('vertical-menu')[0].style.display='block'}
        else{document.getElementsByClassName('vertical-menu')[0].style.display='none'}
    }
</script>
<?php $this->load->view('headers/header'); ?><?php $this->load->view('headers/menu');?>
<section class="container-fluid breadcrumb-formularios">
	<div class="row"><div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Actividades</h3></div><div class="col-md-6 col-sm-7 col-xs-7"><ol class="breadcrumb text-right"><li><a href="./">Inicio</a></li><li class="active">Actividades</li></ol></div></div><hr /> 

</section>
<style type="text/css">
    .opcionesVerActividades{display: flex; justify-content: space-between;}
    .verObjeto{display: block}
    .ocultarObjeto{display: none}
    .opcionesVerActividades>div:nth-child(n+2)>input,form{width: 100%}
    .actividadesEnCursoDiv{display: flex}
    .actividadesEnCursoDiv>div>div{display: flex}

</style>
<style type="text/css" id="estiloParaNoMovilV3">
.cabeceraEstaticaActivdades{width: 100%;/*height: 300px;*/overflow: scroll;border: solid}
.actividadesEnRojoDiv{display: flex;flex-direction: column;width: auto;max-width: 80%;z-index: 200000;height: auto;max-height: 300px}
    @media only screen and (min-width:701px)
    {

         #dragable{width: 200px;height: 20px;left: 1000px;bottom:  10px;display: flex;flex-direction: column-reverse;}
         /*.vertical-menu>a{height: 250px;width: 500px;font-size: 60px}
         #dragable>div:nth-child(1){height: 100;width: 500px;font-size: 60px}
#dragable>div:nth-child(1)>a{height: 100;width: 500px;font-size: 60px}
#flecha{background: white}*/

      .table>tbody>tr>td:nth-child(1)>div:nth-child(n+2){display: none;}
      .table>tbody>tr>td>div:nth-child(1){display: flex;flex-direction: column;} 
      .table>tbody>tr>td>div>a>span{font-size: 25px} 
        .opcionesVerActividades{flex-direction: row}
        .opcionesVerActividades>div:nth-child(1){display: none}
        .opcionesVerActividades>div:nth-child(n+2){display: block;flex-direction: row;flex:1;}

        .opcionesVerActividades>div:nth-child(5){flex:5;}
        .cabeceraEstaticaActivdades::-webkit-scrollbar:vertical {width:15px;border-radius:0px;}

        .actividadesEnCursoDiv>div:nth-child(1){display: none}
        .actividadesEnCursoDiv>div:nth-child(n+2){display: block;flex-direction: row;flex:1;}
        .actividadesEnCursoDiv>div:nth-child(5){flex:2;}
        .actividadesEnCursoDiv>div:nth-child(4){border:solid 1px #d2d2d2}
        body{width: 100%}
         .tituloAgente{height: 35px;width: 100%;font-size: 25px;color: black;background-color:#e68f6f; } 
        
       .table>thead{font-size: 12px}
       .table>tbody{font-size: 12px}

       .table>tbody>tr>td:nth-child(1)>div>label:nth-child(1){text-decoration: underline;}



#divActividadesEnRojo{width: auto;}
#divActividadesEnRojo>div>button{height: 120px;font-size: 100px;width: auto;}
.divActividadesEnRojo>table>thead{font-size: 80px}
.divActividadesEnRojo>table>tbody>tr>td{font-size: 80px}


    }
    @media only screen and (max-width: 700px)
    {





      .table>tbody>tr>td:nth-child(1)>div:nth-child(n+2){display: none;}
      .table>tbody>tr>td>div:nth-child(1){display: flex;flex-direction: column;} 
        .opcionesVerActividades>div:nth-child(n+2){display: none}
        .opcionesVerActividades{flex-direction: column;}

        .opcionesVerActividades>div:nth-child(1){display: flex}
       .cabeceraEstaticaActivdades::-webkit-scrollbar:vertical {width:15px;border-radius:0px;}
        
        .actividadesEnCursoDiv>div:nth-child(1){display: flex}
        .actividadesEnCursoDiv>div:nth-child(n+2){display: none}
        .actividadesEnCursoDiv{flex-direction: column;}
        .table>thead{font-size: 12px}
       .table>tbody{font-size: 12px}

    }
</style>

<style type="text/css" id="estiloParaMovilV3">
 .actividadesEnRojoDiv{display: none;flex-direction: column;width: auto;max-width: 80%;z-index: 200000;height: auto;max-height: 300px;}



@media only screen and (min-device-width: 320px) 
        .opcionesVerActividades>div:nth-child(n+2){display: none}
        .opcionesVerActividades{flex-direction: column;}

        .opcionesVerActividades>div:nth-child(1){display: flex}
        .actividadesEnCursoDiv{flex-direction: column}
        .actividadesEnCursoDiv>div{width: 100%;height: 100px;font-size: 60px}
       .actividadesEnCursoDiv>div>button{width: 100%;height: 100px;font-size: 60px}
       .actividadesEnCursoDiv>div>select,input,label{width: 100%;height: 100px;font-size: 60px}
       .actividadesEnCursoDiv>div>div>select{width: 100%;height: 100px;font-size: 60px}
       .cabeceraEstaticaActivdades::-webkit-scrollbar:vertical {width:100px;border-radius:0px;}

         #dragable{width: 400px;height: 20px;left: 900px;bottom:10px;display: flex;flex-direction: column-reverse}
         .vertical-menu>a{height: 200px;width: 500px;font-size: 60px}
         #dragable>div:nth-child(1){width: 500px;font-size: 60px}
#dragable>div:nth-child(1)>a{height: 20px;width: 500px;font-size: 60px;}
#flecha{background: white}
       .table>thead{font-size: 35px}
       .table>tbody{font-size: 35px;height: 300px}
        .table>tbody>tr>td:nth-child(n+2):nth-child(-n+7){display: none;}
        .table>thead>tr>th:nth-child(n+2):nth-child(-n+7){display: none;}
        .table>tbody>tr>td>div{display: flex;flex-direction: column;} 
        .table>tbody>tr>td>div>label{font-size: 35px} 
        .table>tbody>tr>td>div>a>span{font-size: 75px} 
        .table>tbody>tr>td>input{width: 100px;height: 100px}
        .table>tbody>tr>td:nth-child(1)>div>label:nth-child(1){text-decoration: underline;}
        .table>tbody>tr>td:nth-child(1)>div>a>div,label{font-size:  100px}
        .table>tbody>tr>td:nth-child(1)>div>button{height: 100px;font-size:  60px}
        
        .actividadesEnCursoDiv>div:nth-child(1){display: flex}
        .actividadesEnCursoDiv>div:nth-child(n+2){display: none}
        .actividadesEnCursoDiv{flex-direction: column;}
        .opcionesVerActividades>div>button{height: 150px;width: 100%;font-size: 75px} 
        .opcionesVerActividades>div>input{height: 150px;width: 100%;font-size: 75px}
        .opcionesVerActividades>div>form>div>input{height: 150px;width: 100%;font-size: 75px}
        .opcionesVerActividades>div>form>div>span>button>i{height: 150px;width: 100%;font-size: 75px}
         .tituloEstado{height: 100px;width: 100%;font-size: 75px} 
         .tituloAgente{height: 100px;width: 100%;font-size: 45px;color: black;background-color:#e68f6f; } 
         .tituloAgente>a{height: 100px;width: 100%;font-size: 60px}                  
         .tituloTablaEstadoDiv{flex-direction: column;}
        .tituloTablaEstadoDiv>div>input{height: 100px;width: 100%;font-size: 60px}                
       .cabeceraEstaticaActivdades::-webkit-scrollbar:vertical {width:15px;border-radius:0px;}
       
   .modal-contenido{width: 80%}
   .modal-contenido>div>div>h3{font-size: 100px}
   .modal-contenido>div>div>button{width: 100px;height: 100px;font-size: 80px}
   .modal-contenido>div>div>input{width: 80%;height: 100px;font-size: 80px}
.actividadesEnRojoDiv>div>button{height: 120px;font-size: 100px;width: auto;}
#divActividadesEnRojo{width: 100%;}

#divActividadesEnRojo>table>thead{font-size: 120px}
#divActividadesEnRojo>tbody{font-size: 80px;color: blue;}
.tablaActiviadesEnRojo{font-size: 80px;}

  body{width: 1400px}

}
</style>



<script type="text/javascript">
    var mql = window.matchMedia('(min-width: 750px)');
    

function screenTest(e) 
{
  let array=Array.from(document.getElementsByClassName('opcionesVerActividades')[0].children);  
  if (e.matches) 
  {              
    for(let i=1;i<array.length;i++){array[i].style.display='block';}    
    if(document.getElementById('dragable').style.height=='25px'){document.getElementById('dragable').style.height='auto';}
  } 
  else 
  {
    for(let i=1;i<array.length;i++){array[i].style.display='none';}
    document.getElementById('dragable').style.height='25px'
  }
}
mql.addListener(screenTest)






    function verOpcionesActivdades(menu)
    {
      let array=Array.from(document.getElementsByClassName(menu)[0].children);    
      for(let i=1;i<array.length;i++)
        {
          (array[i].style.display=='block')? array[i].style.display='none':array[i].style.display='block';            
           
        }
    }
</script>
<div class="opcionesVerActividades">
    
    <div><button class="btn btn-info" onclick="verOpcionesActivdades('opcionesVerActividades')">OPCIONES</button></div>
         <div><input type="button" value="Cotizadores" onclick="window.open('https://www.dropbox.com/sh/3txhtwzoketivnz/AABSWpAhQXuqTpiPfv_rDvGxa/COTIZADORES?dl=0','_blank')" class="btn btn-primary btn-sm"></div>
         <div><input type="button" value="Exportar Historial" title="Exportar Historial de Activiades - Clic Aqu&iacute;" onclick="window.open('actividades/ExportaHistorial','_self');" class="btn btn-primary btn-sm"/></div>
         <div><input type="button" value="Actualizar Actividad" title="Actualizar Actividad - Clic Aqu&iacute;" onclick="window.open('actualizaActividades/actualizaactividadesporvendedor','_self');" class="btn btn-primary btn-sm"/></div>
         <div>
                         <form class="form-horizontal" role="form" id="formActividadBuscarFolio" name="formActividadBuscarFolio" method="post" enctype="multipart/form-data" action="<?=base_url()?>actividades/busqueda">
                <div class="input-group" style="width:100%;">
                    <input id="folioBuscado" name="folioBuscado" type="text" class="form-control input-sm" placeholder="Buscar Folio">
                    <span class="input-group-btn"><button class="btn btn-primary btn-sm search-trigger"><i class="fa fa-search fa-sm"></i>&nbsp;</button></span>
                </div>
                <input type="hidden" id="usuarioCreacion" name="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>"/>
            </form>

         </div>
        
</div>
<section class="container-fluid">
 
<div id="dragable" class="contMenuFlotante">
    <div style="text-align: right;"><div onclick="persiana()"><i id="flecha" class="fa fa-bars fa-2x"></i></div></div>
    <div class="vertical-menu"><?php echo(imprimirBotonesRamos($ramos,$totalesPorRamo,$personaTrabajaActividad)); ?>
    </div>
</div>
<!--Fin Modificacion-->
<div class="panel panel-default">
<!--div onscroll="moverScroll()" id="scrollTabla" style="overflow-x:scroll; overflow-y: scroll;" >
		<div class="panel-body">
		<div class="row" style="padding-bottom:5px;">
			<div class="col-sm-12 col-md-12" align="right">           			
			
			
			</div>
		</div>

        <div class="row">
			<div class="col-sm-12 col-md-12" align="right">

            </div>            
        </div>
        
    </div-->
   </div>
   <style type="text/css">
       .tituloTablaEstadoDiv{display: flex;justify-content: space-between;}
       .tituloTablatipoActividadDiv{display: flex;}
       .cabeceraEstaticaActivdades>table>thead{/*position: sticky;top:0px;z-index: 10*/}
       @media only screen and (min-width: 1px)
       {

       }

   </style>
   <script type="text/javascript">
       function abrirOcultar(event,objeto,tbody,div)
       {

          event.preventDefault();
        if(objeto.innerHTML=='-'){objeto.innerHTML='+';document.getElementById(tbody).classList.remove('verObjeto');document.getElementById(tbody).classList.add('ocultarObjeto');document.getElementById(div).style.height='auto'}
        else{objeto.innerHTML='-';document.getElementById(tbody).classList.add('verObjeto');document.getElementById(tbody).classList.remove('ocultarObjeto');document.getElementById(div).style.height='350px'}
       }

   </script>
    <div>
        <form class="form-horizontal" role="form" name="formTrabajandoAgenteCapital" id="formTrabajandoAgenteCapital"  method="post" enctype="multipart/form-data" action="<?=base_url()?>actividades/todas">
            <input type="hidden" name="tipo" id="tipo" />
            <div class="row tituloEstado"><div class="col-sm-12 col-md-12"><label class="tituloAgente"><a name="seccionAgente">ACTIVIDADES EN ESTADO AGENTE </a></label></div></div>
    	<div class="tituloTablaEstadoDiv">
            
            <div><input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" class="btn btn-info" /></div>
            <div><input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" class="btn btn-info" /></div>
            <div><input type="button" onclick="todas(this.form, 'terminarTodas')" value="Cerrar las seleccionadas" class="btn btn-danger"/></div>
        </div>
    				   
                
                                      	<div class="clearfix" style="float:left;"><font class="subTituloSeccione"></font></div>
                            <div><font style="float:right;">&nbsp;</font></div>
             <?php foreach ($actividadesNoTrabajandose as $key => $value) { ?>
                <div class="cabeceraEstaticaActivdades" id="<?= $key ?>ContenedorDiv">
				<table class="table">
					<thead>
						<tr scope="row"><th colspan="9"><div class="tituloTablatipoActividadDiv"><div><button class="btn btn-warning btn-sm ocultarObjeto" onclick='abrirOcultar(event,this,"<?= $key ?>tbody","<?= $key ?>ContenedorDiv")'>-</button></div><div><a class="btn<?= $key; ?>" name="<?= $key; ?>"><?= $key ?></a></div></div>
                            </th>
                        </tr>
						<tr scope="row" bgcolor="#A391C0" valign="top"><th scope="col">Folio</th><th scope="col">Fecha recepcion</th><th scope="col">Estado</th><th scope="col">Fecha</th><th scope="col">Actividad</th><th scope="col">SubRamo</th><th scope="col">Cliente</th>
							<th>Califica</th><th scope="col"></th>
                        </tr>
                	</thead>
					<tbody id="<?= $key ?>tbody">
			    	              		<?  $contCheckbox = 0;
						foreach($actividadesNoTrabajandose[$key] as $row)
                        {
                         $contCheckbox++;$semaforoNew="";	
						 $clase="classParaAgente";						

					?>
            <?
                        $fechaActualizacion=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacionStatus,'');
                  $fechaCreacion=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'');
                  $fechaCreacionTitle=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'title');

              ?>
						<tr scope="row" style="/*font-size:12px;*/">
							<td scope="col" align="center">
                <div>
                  <a onclick="nuevaVentana(event,this)" href="<?=base_url().'actividades/ver/'.$row->folioActividad?>" title="<?=$row->datosExpres?>">
                  <div class="<?=$clase?>"><?=$row->folioActividad."<br />"?>
                    <label style=""> <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?></label>
                   </div>
                  </a>
                </div>
                  <div><label>Actvidad: </label><label><?=$row->tipoActividad?></label></div>
                   <div><label>Recepcion: </label><label><?=$fechaActualizacion?></label></div>
                   <div><label>Creacion: </label><label><?=$fechaCreacion?></label></div> 
                   <div><label>SubRamo: </label><label><?=$row->subRamoActividad?></label></div>  
                   <div><label>Cliente: </label><label><?=$row->nombreCliente?></label></div>                                                  
                   <div><label>Vendedor: </label><label><?=$row->usuarioVendedor?></label></div>                     
               <div></div>
              </td>
              

							<td scope="col"><?=$fechaActualizacion?></td>
              <td scope="col"><?=$row->Status_Txt?></td>
              <td scope="col" data-title="<?='Fecha'.$fechaCreacionTitle?>"><?=$fechaCreacion?>
                            </td>	
							<td scope="col">
								<? if($row->inicio==1){?><font style="color:blue; font-weight:bold;"/>Cotizacion</font><?php } ?>
                            	<? if($row->fechaEmite != ""){ ?><font style="color:#00F;"><strong>Emision</strong></font><? } ?>
                                <br />
								<?=$row->tipoActividad?>
                                <font style="color:red; font-weight:bold;"/><?=($row->actividadUrgente==1)?" &bull; Urgente !!!":""?></font>
								<? if( $row->actividadImportante == "1" ){ ?>
                                <br />
                                <font style="color:red; font-weight:bold;">!!! ACTIVIDAD IMPORTANTE !!!</font>
                                <?php } ?>
                            </td>
							<td scope="col"><?=$row->subRamoActividad?></td>
							<td>
								<?php
									print($row->nombreCliente);
									if($row->usuarioVendedor != Null){
										if($row->usuarioVendedor != $row->usuarioCreacion){
										print('<br /><b>Creador:</br>'.$row->nombreUsuarioCreacion);
											print('&nbsp;['.$row->usuarioCreacion.']&nbsp;');
										}
										print('<br /><b>Vendedor:</br>'.$row->nombreUsuarioVendedor);
										print('&nbsp;['.$row->usuarioVendedor.']&nbsp;');
										$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioVendedor);
										if(count($informacion)>0){
										print('<br />('.$informacion[0]->idpersonarankingagente.')');
										print($informacion[0]->personaTipoAgente);                                            
                                           }
									} else {
										print('<br /><b>Creador:</br>'.$row->usuarioCreacion);
										print('&nbsp;['.$row->usuarioCreacion.']&nbsp;');
										$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioCreacion);
										if(count($informacion)>0){
										print('<br />('.$informacion[0]->idpersonarankingagente.')');
										print($informacion[0]->personaTipoAgente); 
                                       }


									}
								?>
							</td><!--  //$infoCliente[0]->NombreCompleto -->
							<td scope="col" align="center">
                            	<? if($row->satisfaccion == ""){ ?>								
								<div><a href="<?=base_url().'actividades/calificarActividad?folioActividad='.$row->folioActividad.'&satisfaccion=bueno&tipoActividad=Actividad&IDDocto='.$row->idSicas.'&ClaveBit='.$row->ClaveBit.'&idInterno='.$row->idInterno ?>" data-toggle="modal" title="Califica Bien y Finaliza">
                                <span class="glyphicon glyphicon-thumbs-up" style=" color: green; margin-right: 15px;margin-left: 0px" onmouseout="this.style.color='green';" onmouseover="this.style.color='#000000';"></span>
                                </a></div>
                                <div><a href="<?=base_url().'actividades/calificarActividad?folioActividad='.$row->folioActividad.'&satisfaccion=malo&tipoActividad=Actividad&IDDocto='.$row->idSicas.'&ClaveBit='.$row->ClaveBit.'&idInterno='.$row->idInterno ?>" data-toggle="modal" title="Califica Mal y Finaliza" onclick="calificacionMala(event,this)">
                                <span class="glyphicon glyphicon-thumbs-down" style="color: red" onmouseout="this.style.color='red';" onmouseover="this.style.color='#000000';" ></span>
                                </a></div>
								<? } else { ?>
                    			<div><a title="Actividad Calificada"><span class="glyphicon glyphicon glyphicon-ok-sign"> </span></a></div>
								<div><a href="<?=base_url()."actividades/terminar/".$row->folioActividad."?IDDocto=".$row->idSicas."&ClaveBit=".$row->ClaveBit?>" title="Terminar la Actividad del Sistema">
								<span class="glyphicon glyphicon-trash"></span> 
                    			</a></div>
								<? } ?>
							</td>
							<td scope="col" align="center"><input type="checkbox" name="ch[]" value="<?=$row->idSicas."|".$row->ClaveBit."|".$row->folioActividad?>"></td>
						</tr>
					<? } ?>
                     </tbody>
                     </table>
                    </div>
					<?}?>

				
                
				</form>
    </div>

    <div>

       <div class="row"><div class="col-sm-12 col-md-12"><label class="tituloAgente"><a name="seccionEnCurso">ACTIVDADES QUE ESTAN EN CURSO </a></label></div></div>
    	<!--div class="row"><div class="col-sm-3 col-md-3"><select id="selectTipoFiltro" class="form-control" onchange="escogerTipoFiltro(this.value)"><option value="">ESCOGER FILTRO</option><option value="ESTADO">ESTADO</option><option value="TIPO ACTIVIDAD">TIPO ACTIVIDAD</option><option value="SUB RAMO">SUB RAMO</option><option value="RESPONSABLE">RESPONSABLE</option></select></div><div class="col-sm-3 col-md-3"><select id="selectValorFiltro" class="form-control" onchange="escogerFiltroRows(this)"></select></div><div class="col-sm-3 col-md-3">Detener recarga:<input type="checkbox"  id="detenerRecargaChecked" ></div></div>
        <?php if($permisoCambioResponsable){ ?>
        <div class="row">
            <div><select id="nuevoResponsableSelect" class="form-control"><?=imprimirResponsables($ejecutivos)?></select></div>
            <div class="col-sm-1 col-md-1"><button class="btn btn-primary" onclick="cambiarResponsablesNuevos()">Guardar</button></div>
        </div-->

    <?php }?>
    <style type="text/css">

    </style>
    <div class="actividadesEnCursoDiv">
      <div><button class="button btn-info" onclick="verOpcionesActivdades('actividadesEnCursoDiv')">Opciones En Curso</button></div>
      <div>
        <select id="selectTipoFiltro" class="form-control" onchange="escogerTipoFiltro(this.value)"><option value="">ESCOGER FILTRO</option><option value="ESTADO">ESTADO</option><option value="TIPO ACTIVIDAD">TIPO ACTIVIDAD</option><option value="SUB RAMO">SUB RAMO</option><option value="RESPONSABLE">RESPONSABLE</option></select>
      </div>
    <div>
        <select id="selectValorFiltro" class="form-control" onchange="escogerFiltroRows(this)"></select>
    </div>
     <div>
         Detener recarga:<input type="checkbox"  id="detenerRecargaChecked" >
     </div>
     <div>
         <div><select id="nuevoResponsableSelect" class="form-control"><?=imprimirResponsables($ejecutivos)?></select><button class="btn btn-primary" onclick="cambiarResponsablesNuevos()">Guardar</button>
        </div>
     </div>
    </div>
    <?php $filtroEstado=array();
          $filtroTipoActividad=array();
          $filtroSubRamoActividad=array();
          $filtroResponsable=array();
          $filtroVendedor=array();
          $filtroCreador=array();
    foreach ($ActividadesTrabajandose as $key => $value) { ?>
      
        	<div class="cabeceraEstaticaActivdades">
                <input type="hidden" name="tipo" id="tipo" />
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr scope="row">
                            <th colspan="9">
                        	<div class="clearfix" style="float:left;"><font class="subTituloSeccione"><a class="btnRamo<?= $key; ?>" name="<?= $key; ?>"> <?= $key ?></a></font><?php if($key=='VEHICULOS'){echo('<button class="btn btn-success"><a onclick="nuevaVentana(event,this)" href="'.base_url().'cotizador">Ir a Car Capital</a></button>');} ?></div>
                            <div></div>
                          </th>
                        </tr>
						<tr scope="row" bgcolor="#A391C0" valign="top">
							<th scope="col">Folio</th>
							<th scope="col">Fecha recepcion</th>
							<th scope="col">Aseguradoras</th>
							<th scope="col">Estado</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Actividad</th>
                            <th scope="col">SubRamo</th>
                            <th scope="col">Cliente</th>
                        </tr>
                	</thead>
					<tbody>
					<?  if($ActividadesTrabajandose != false){ $contCheckbox = 0;
						foreach($ActividadesTrabajandose[$key] as $row){$contCheckbox++;$semaforoNew="";							
							//$clase=controlaSemaforos($row->tiempoSemaforo,$row->Status,$row->horasOficinaCP,$row->horasPortalCP,$row->tipoActividad);
                            
                            $nuevoSemaforo=controlaSemaforos($row->nuevoSemaforo,$row->Status,$row->horasOficinaCP,$row->horasPortalCP,$row->tipoActividad,$row->usuarioResponsable,$row->idInterno,$row->folioActividad);
                            $clase=$nuevoSemaforo['tiempo'];
                            
                        $filtroEstado[$row->Status_Txt]=0;
                        $filtroTipoActividad[$row->tipoActividad]=0;
                        $filtroSubRamoActividad[$row->subRamoActividad]=0;
                        $filtroResponsable[$row->usuarioResponsable]=0;

					?>

						<tr scope="row" style="/*font-size:12px;*/" data-estado="<?=$row->Status_Txt?>" data-tipoactividad="<?=$row->tipoActividad?>" data-subramo="<?=$row->subRamoActividad?>" data-responsable="<?=$row->usuarioResponsable?>" data-vendedor="" data-creador="" name="trEnCurso" onclick="seleccionarRow(this)" data-idinterno="<?= $row->idInterno?>" id="<?=$row->folioActividad?>link">
							<td scope="col" align="center">
                            	<div class="row">
                            	<a onclick="nuevaVentana(event,this)" href="<?=base_url()."actividades/ver/".$row->folioActividad?>" title="<?=$row->datosExpres?>">
                            	<div class="<?=$clase?>">
								<?=$row->folioActividad."<br />"?>
                                <font style="font-size:9px;"> <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?></font>
                                </div>
                                </a>
                                            <?
                        $fechaActualizacion=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacionStatus,'');
                  $fechaCreacion=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'');
                  $fechaCreacionTitle=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'title');

              ?>
                                <? if($tipoUsuario==5 || $tipoUsuario==4 || $tipoUsuario==1){ ?>
                                
                                	<? if($row->trabajandoseActividad==1){?>
                                	<input type="checkbox" name="cbTrabajarActividad" value="<?= $row->idInterno?>" onclick="trabajarActividad('',this)" checked>
                                	<? } 
                                	else{?>
                                      <input type="checkbox" name="cbTrabajarActividad" value="<?= $row->idInterno?>" onclick="trabajarActividad('',this)">
                                	
                                 	<? } ?>
                                
                                <? } ?>
                                <button class="btn btn-info btnActividadComentariosOperativos" onclick="abrirVentanaComentariosOperativos('',<?=$row->idInterno?>,'<?=$row->folioActividad?>')">&#128172</button>
                                </div>
                              <div style="width: 300px;border-radius: 3px;text-align: center;color: #fff;">  
                                <label style="color: #1a0977"><?php echo $nuevoSemaforo['porcentajeTiempo'];?>%</label> 
                                    <meter min="0" max="100" low="70" high="80" optimum="69" value="<?php echo $nuevoSemaforo['porcentajeTiempo'];?>" style="height: 50px;width: 100%"></meter>
                                    
                                                                                                   
                                <p style="font-size: 11px;display: none">
                                   <? if($row->usuarioResponsable=='COBRANZA@ASESORESCAPITAL.COM'){?>
                                    LAS ACTIVIDADES EN COBRANZA TIENEN UN LIMITE DE 14 DIAS.
                                    <?}else{?><?=$row->promotorias ;?><?}?>
                                  </p>
                                </div>
                                <div><label>Actividad: <?=$row->tipoActividad?></label><div></div></div>
                                <div><label>Recepcion: <?=$fechaActualizacion?></label><div></div></div>
                                <div><label>Creacion: <?=$fechaCreacion?> </label><div></div></div>
                                <div><label>SubRampo: <?=$row->subRamoActividad?></label><div></div></div>

                      </td>
							<td scope="col"><?=$fechaActualizacion?></td>
                            

			<!-- Modificación Miguel Jaime 16/11/2020-->
                            <td scope="col"  class="divPromotoria" align="center">
                                <br>
                                <div style="width: 120px;border-radius: 3px;text-align: center;color: #fff;">  
                                <label style="color: #1a0977"><?php echo $nuevoSemaforo['porcentajeTiempo'];?>%</label> 
                                    <meter min="0" max="100" low="70" high="80" optimum="69" value="<?php echo $nuevoSemaforo['porcentajeTiempo'];?>" style="height: 50px;width: 100%"></meter>
                                    
                                                                                                   
                                <p style="font-size: 11px;">
                                   <? if($row->usuarioResponsable=='COBRANZA@ASESORESCAPITAL.COM'){?>
                                    LAS ACTIVIDADES EN COBRANZA TIENEN UN LIMITE DE 14 DIAS.
                                    <?}else{?><?=$row->promotorias ;?><?}?>
                                </div>


                            </td>
                            <!-- fin-->




                            <td scope="col"><?=$row->Status_Txt?></td>
                            <td scope="col" data-title="<?="Fecha".$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'title')?>"><?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'')?>
                            </td>	
							<td scope="col">
								<? if($row->inicio==1){?><font style="color:blue; font-weight:bold;"/>Cotizacion</font><?php } ?>
                            	<? if($row->fechaEmite != ""){ ?><font style="color:#00F;"><strong>Emision</strong></font><? } ?>
                                <br />
								<?=$row->tipoActividad?>
                                <font style="color:red; font-weight:bold;"/><?=($row->actividadUrgente==1)?" &bull; Urgente !!!":""?></font>
								<? if( $row->actividadImportante == "1" ){ ?>
                                <br />
                                <font style="color:red; font-weight:bold;">!!! ACTIVIDAD IMPORTANTE !!!</font>
                                <?php } ?>
                                <?
									if( $row->actividadImportante == "0" && $clase=="tiempoExcedido"){
										if($row->RamosNombre!='VEHICULOS'){
								?>
                                <br />
                                <font style="color:red; font-weight:bold; font-size:8px;">
								<a 
                                	href="<?=base_url().'actividades/marcarImportante?folioActividad='.$row->folioActividad; ?>"
									data-original-titletitle="Clic - Para convertir la actividad en Importante !!!"
                                    style="color:#FFF"
                                    class="btn btn-danger"
								>!!! ESCALAR !!!</a>
                                </font>
                                <?
									}}
								?>
                            </td>
							<td scope="col"><?=$row->subRamoActividad?></td>
							<td>
								<?
									print($row->nombreCliente);
									if($row->usuarioVendedor != Null){
										if($row->usuarioVendedor != $row->usuarioCreacion){
										print("<br /><b>Creador:</b>".$row->nombreUsuarioCreacion);
											print("&nbsp;[".$row->usuarioCreacion."]&nbsp;");
										}
										print("<br /><b>Vendedor:</b>".$row->nombreUsuarioVendedor);
										print("&nbsp;[".$row->usuarioVendedor."]&nbsp;");
										$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioVendedor);
										if(count($informacion)>0){
										print("<br />(".$informacion[0]->idpersonarankingagente.")");
										print($informacion[0]->personaTipoAgente);                                            
                                           }
									} else {
										print("<br /><b>Creador:</b>".$row->usuarioCreacion);
										print("&nbsp;[".$row->usuarioCreacion."]&nbsp;");
										$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioCreacion);
										if(count($informacion)>0){
										print("<br />(".$informacion[0]->idpersonarankingagente.")");
										print($informacion[0]->personaTipoAgente); 
                                       }
									}
								?>
							</td><!--  //$infoCliente[0]->NombreCompleto -->

						</tr>
					<?}?>
                    </tbody>
                    </table>
					<?}?>

            </div>

     <? } ?>
</div>
    </div>
</section>
<style type="text/css">
    
    .actividadesEnRojoDiv>div{z-index: 10000}

    @media only screen and (min-width: 700px)
    {
        .actividadesEnRojoDiv{width: auto;max-width: 80%}
    }

        @media only screen and (max-width: 600px)
    {
        .actividadesddEnRojoDiv{width: auto;max-width: 80%}
    }
</style>
<?php if($panelParaActivdadesEnRojo){?>
<div class="actividadesEnRojoDiv" style="position: fixed;background-color: #d9534f;top: 2%;left: 10%">
    <div><button class="btn btn-danger" style="width: 100%" id="btnActividadesEnRojo" data-char="128071">&#128071</button></div>
    <div  style="overflow: scroll;height: auto;width: 100%" id="divActividadesEnRojo"><table class="table tablaActiviadesEnRojo" style="background-color: white"><thead><tr><th colspan="4">Folio</th></tr></thead><tbody><?=imprimirActividadesEnRojo()?> </tbody></table></div>
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
	if($tipoActividad=="Emision" || $tipoActividad=="Cotizacion" || $tipoActividad=="CapturaEmision" || $tipoActividad=="Cancelacion" || $tipoActividad=='Endoso')
	{
        if($tipoActividad=="Endoso")
        {
            if($horasOficinaCP=='')
            { 
                $horasOficinaCP=144;
                $imp['horasOficinaCP']=$horasOficinaCP;
            }
            if($horasPortalCP=='')
            { 
                $horasPortalCP=144;                
                 $imp['horasPortalCP']=$horasPortalCP;
            }

            //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($imp, TRUE));fclose($fp); 
        }

        if($tipoActividad=="Cancelacion")
        {
            if($horasOficinaCP=='')
            { 
                $horasOficinaCP=72;
                $imp['horasOficinaCP']=$horasOficinaCP;
            }
            if($horasPortalCP=='')
            { 
                $horasPortalCP=72;                
                 $imp['horasPortalCP']=$horasPortalCP;
            }

            //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($imp, TRUE));fclose($fp); 
        }

        if($tipoActividad=="CapturaEmision"){$horasPortalCP=24;}


      if($Status==5)
      {
      	if($tiempoSemaforo!=NULL)
      	{
          if($horasPortalCP==NULL)
          {
            $array['tiempo']='tiempoNormal';
            $array['porcentajeTiempo']=0;
          }
          {
          if($tiempoSemaforo>$horasPortalCP){$tiempo="tiempoExcedido";$array['tiempo']="tiempoExcedido";}
          else{if((($tiempoSemaforo*100)/$horasPortalCP)>=70){$tiempo="tiempoAcabando";$array['tiempo']="tiempoAcabando";}}
          $array['porcentajeTiempo']=$horasPortalCP==0?100:($tiempoSemaforo*100)/$horasPortalCP;
          }
        }
       else{$tiempo="sinTiempo";}
      }
    else
    {
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
         $i['idInterno']=$idInterno;
         $i['folioActividad']=$folioActividad;
         $i['notificacionPara']='COORDINADOROPERATIVO@ASESORESCAPITAL.COM';
         $i['statusActividad']='AMARILLO';
         $ci->db->insert('actividadesenrojo',$i);
         $last=$ci->db->insert_id();         
         $notificacion['idTabla']=$last;
         $notificacion['persona_id']='552';
         $notificacion['comentarioAdicional']='La actividad '.$folioActividad.' se encuentra en semaforo amarillo';
         $notificacion['email']=  'COORDINADOROPERATIVO@ASESORESCAPITAL.COM';
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
        $consultaParaNC='select (count(idInterno)) as total from actividadesenrojo a where  a.notificacionPara="GERENTEOPERATIVO@AGENTECAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $resultParaNC=$ci->db->query($consultaParaNC)->result()[0]->total;
        if($resultParaNC==0)
        {
          $correoProcedente='DIRECTORGENERAL@AGENTECAPITAL.COM';
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
            $ci->procesamientoncmodel->insertarNC($insertar);
            
        }
        

         $consulta='select (count(idInterno)) as total from actividadesenrojo a where a.estaCerrado=0 and a.notificacionPara="GERENTEOPERATIVO@AGENTECAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $result=$ci->db->query($consulta)->result()[0]->total;        
         if($result==0)
         {
          $i['idInterno']=$idInterno;
          $i['folioActividad']=$folioActividad;
          $i['notificacionPara']='GERENTEOPERATIVO@AGENTECAPITAL.COM';
          $i['statusActividad']='ROJO';
          $ci->db->insert('actividadesenrojo',$i);
          $last=$ci->db->insert_id();
         $notificacion['idTabla']=$last;
         $notificacion['persona_id']=1;
         $notificacion['email']=  'GERENTEOPERATIVO@AGENTECAPITAL.COM';
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
          $tr.='<tr name="'.$key.'CabRojo" class="ocultarObjeto"><td></td><td><label>Notificacion para: '.$val->notificacionPara.'</label></td><td><label>Responsable: '.$val->usuarioResponsable.'</label></td><td><label>fecha Aviso: '.$val->fechaInsercion.'</label></td></tr>';
      }
    }
    return $tr;
     
}

?>
<script type="text/javascript">
    function actualizar()
    {   
       if(!document.getElementById('detenerRecargaChecked').checked)
      {
       let val1=document.getElementById('selectTipoFiltro').value;
       let val2=document.getElementById('selectValorFiltro').value;
       let datos='selectTipoFiltro='+val1+'&selectValorFiltro='+val2;       
       let direccion='<?=base_url()?>actividades?'+datos;
       window.location.replace(direccion);
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
{ var f = document.forms[nombreFormulario.name];for (i=0;i<f.elements.length;i++) {if(f.elements[i].type == "checkbox"){f.elements[i].checked=1}}}
function deseleccionar_todo(nombreFormulario)
{var f = document.forms[nombreFormulario.name];for(i=0;i<f.elements.length;i++){if(f.elements[i].type == "checkbox"){f.elements[i].checked=0 }}}
function todas(nombreFormulario, tipoTodas){var f = document.forms[nombreFormulario.name];f.tipo.value = tipoTodas;f.submit();}

</script>
<style type="text/css">.tiempoExcedido{background-color: red;color:white}.tiempoAcabando{background-color: orange;color: white}.tiempoNormal{background-color: green;color:white}.sinNormal{background-color: white;color:black}.divPromotoria p {color: white;background-color:#0857b9;display: none}.divPromotoria div {}.divPromotoria:hover {cursor:pointer;}.divPromotoria:hover  p{display: inline-flex;height:50px; width: 150px; overflow: auto;} .btnRam{padding: 2px; border: solid black 1px; color: black; background-color: #b4a5cb}.btnRamoFIANZAS{color: black;background-color:#fdd792;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px	}.btnRamoDANOS{color: black;background-color:#fdd792;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnRamoVEHICULOS{color: black;background-color:#7474c3;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnRamoACCIDENTES_Y_ENFERMEDADES{color: black;background-color:#e26666;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnRamoVIDA{color: black;background-color:#7bdc77;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btncotizaciones{color: black;background-color:#8762c8;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnotrasActividades{color: black;background-color:#afd584;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnAgente{color: black;background-color:#e68f6f;padding: 2px;border: solid black 1px;width: 110px}.btnEnCurso{color: black;background-color:#89cbd3;padding: 2px;border: solid black 1px;width: 110px}.divBotones{display: list-item; width: 300px}.menuFlotante{border: solid;width: 200px}.menuFlotante  a{display: block;}.contMenuFlotante{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;padding: 10px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px;}.vertical-menu {width: 15px;}.vertical-menu a {display: block;padding: 0px;text-decoration: none;}.vertical-menu a:hover {background-color: #ccc;}.vertical-menu a.active { color: red;}.tituloAgente > a{color: black;}.tituloEnCurso{color: black;background-color:#89cbd3; font-size:1.5em; width: 100%; height: 30px}
   .prueba:focus {color:pink;}
   a:active {color: blue;}
   .spanTotal{    ; color:white;background-color: black; border: solid .01em black}
   .actividadesTrabajandose{width:300px;border-bottom:solid black; color:white; background-color:green; position:relative;left:-150px}
   .ocultarObjeto{display: none;}
   .seleccionRowCambioResponsable{color: white;background-color: green;}
   .seleccionRowCambioResponsable > td{color: white;background-color: green}
   
</style>
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
    if(datos=='')
  {
    let clase=document.getElementsByClassName('seleccionRowCambioResponsable');
    let cant=clase.length;
    let idInterno='';
    for(let i=0;i<cant;i++){idInterno+=clase[i].dataset.idinterno+',';}
    if(idInterno!='')
    {
     let valor=document.getElementById('nuevoResponsableSelect').value;
     if(valor!='')
     {      
      
      var params = "idInterno="+idInterno;    
      params+='&nuevoResponsable='+valor; 
      controlador="actividades/cambiarResponsablesNuevos/?";
      peticionAJAX(controlador,params,'cambiarResponsablesNuevos');      
     }
     else{alert('Escoger nuevo responsable')}

    }
    else{alert('Escoger actividad para cambiar de responsable');}



  }
  else
  {
    document.getElementById('detenerRecargaChecked').checked=false;
    actualizar();
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
     
      
        if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) {
          document.getElementById('estiloParaNoMovilV3').parentNode.removeChild(document.getElementById('estiloParaNoMovilV3'));
          persiana();
        }
        else{document.getElementById('estiloParaMovilV3').parentNode.removeChild(document.getElementById('estiloParaMovilV3'));} 
    
</script>