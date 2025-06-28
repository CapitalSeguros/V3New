  <?php $this->load->view('generales/modalGenericoV3');?>
  <? $anio=date('Y');
     $mes=date('m');
    $CI =& get_instance();
    $CI->load->library('libreriav3');
    $meses=$CI->libreriav3->devolverMeses();
?>
<script type="text/javascript"></script>
<div class="classEnvioHGeneralDiv" style="top:90%;width: 10%">
	<div ><button class="btn btn-warning" style="width: 5%;min-width: 5%" id="btnEHCerrarGenerales" data-char="128071">&#128071</button></div>    
    <div class="ocultarObjeto" style="overflow: auto;height: auto;width:100%;height: 400px;background-color: white" id="divHistorialDeCorreos">
    	<div style="display: flex; width: 100%;flex-direction: column;">
    		<div style="display: flex; flex-direction: row;width: 100%">
    			<div style="flex:1"><input type="number" id="anioEnvioSelect" min="2020" value="<?=$anio?>" placeholder="Escribir el año" class="controlHistorial form-control" style="height: 5px;width: 100%" ></div>
    			<div style="flex:1"><select id="meseEnvioSelect" class="controlHistorial form-control" ><?=imprimirMesesEHGeneral($meses)?></select></div>
    			<div style="flex:1"><button class="controlHistorial form-control" onclick="envioHistorialGeneralesFuncion('')">Buscar</button></div>
                <div style="flex:4"></div>
    		</div>
    		<div id="envioHistorialGeneralDivTabla" style="width: 100%;height: 300px;overflow: scroll;"></div>
    	</div>
    </div> 
</div>

<style type="text/css">    
    .classEnvioHGeneralDiv{position: fixed;z-index: 200;left: 2%;width: 90%;display: flex;flex-direction: column;}
    .ocultarObjeto{display: none;}
    .controlHistorial{width: 100%;height: 25px;max-height: 25px}
        .nombreClass{display: none}
    .envioClass{display: none}
    .fechaClass{display: none}
    .comentarioClass{display: none}
    .envioDocumento{display: none}
    .documentoClass{display: none}

    #envioHistorialGeneralTable > thead {position: sticky;top: 0px}
</style>

<script type="text/javascript">
        document.getElementById('btnEHCerrarGenerales').addEventListener("click", function(){            
        document.getElementById('divHistorialDeCorreos').classList.toggle('ocultarObjeto');
        if(this.dataset.char==128071){this.dataset.char='128070';this.innerHTML='&#128070';
        btnEHCerrarGenerales.parentNode.parentNode.style.top="20%";
        btnEHCerrarGenerales.parentNode.parentNode.style.width="90%";
        envioHistorialGeneralesFuncion();
    }
        else{this.dataset.char=128071;this.innerHTML='&#128071';btnEHCerrarGenerales.parentNode.parentNode.style.top="90%";btnEHCerrarGenerales.parentNode.parentNode.style.width="10%";}
    })
    let actRojo=document.querySelectorAll('button[name=btnEHCerrarGenerales]');
    actRojo.forEach(b=>{b.addEventListener("click",function(){
                
    })})    

function envioHistorialGeneralesFuncion(datos='')   
{
  if(datos=='')
  {
     //let params='IDCli='+documentoSolicitudIDCli.value; 
     let params=`anio=${document.getElementById('anioEnvioSelect').value}&mes=${document.getElementById('meseEnvioSelect').value}`;
     controlador="cobranza/historialEnviosPorUsuario/?";
    //peticionAJAXSinBloqueo(controlador,params,'historialEnviosPorUsuario');
    peticionAJAXLib(controlador,params,'envioHistorialGeneralesFuncion');
  }
  else
  {
    if(datos.mensajeAnio){alert(datos.mensajeAnio);}
    let tablaBody='';
    let tabla='<table id="envioHistorialGeneralTable" class="table" ><thead><tr><th>CLIENTE</th><th>PARA</th><th>DOCUMENTO</th><th>RECIBO</th><th>LINK</th><th>FECHA</th><th>ENVIO</th></tr>';    
    
    let arrayEnvio=[];
    let arrayNombre=[];
    let arrayFecha=[];
    let arrayComentario=[];
    let arrayDocumento=[];
    datos.envios.forEach(e=>{
        let link='';
        let img='';
        if(e.hRefCH!=''){link=`href="${e.hRefCH}"`;img=`<button class="btn btn-success">&#128195</button>`;}
     tablaBody+=`<tr data-filtropara="${e.envioDestinoCH}" data-filtrofecha="${e.fechaCreacion}" data-filtronombre="${e.NombreCompleto}" data-filtrocomentario="${e.comentarioDelEnvio}" data-filtrodocumento="${e.documento}"><td>${e.NombreCompleto}</td><td>${e.envioDestinoCH}</td><td>${e.documento}</td><td>${e.idSerie}</td><td><a ${link} target="_blank">${img}</a></td><td>${e.fechaCreacionHora}</td><td>${e.comentarioDelEnvio}</td>`;
     bandEnvio=true;
     bandNombre=true;
     bandFecha=true;
     bandComentario=true;
     bandDocumento=true;
     if(e.envioDestinoCH===null || e.envioDestinoCH==''){e.envioDestinoCH='SIN DATO';}
     arrayEnvio.forEach(en=>{if(en==e.envioDestinoCH){bandEnvio=false;}})
     if(bandEnvio){arrayEnvio.push([e.envioDestinoCH]);}
     
     if(e.NombreCompleto===null || e.NombreCompleto==''){e.NombreCompleto='SIN DATO';}
     arrayNombre.forEach(en=>{if(en==e.NombreCompleto){bandNombre=false;}})
     if(bandNombre){arrayNombre.push([e.NombreCompleto]);}
     
     if(e.fechaCreacion===null || e.fechaCreacion==''){e.fechaCreacion='SIN DATO';}
     arrayFecha.forEach(en=>{if(en==e.fechaCreacion){bandFecha=false;}})
     if(bandFecha){arrayFecha.push([e.fechaCreacion]);}     
     
     if(e.comentarioDelEnvio===null || e.comentarioDelEnvio==''){e.comentarioDelEnvio='-';}
     arrayComentario.forEach(en=>{if(en==e.comentarioDelEnvio){bandComentario=false;}})     
     if(bandComentario){arrayComentario.push([e.comentarioDelEnvio]);}
     
     if(e.documento===null || e.documento==''){e.documento='-';}
     arrayDocumento.forEach(en=>{if(en==e.documento){bandDocumento=false;}})     
     if(bandDocumento){arrayDocumento.push([e.documento]);}
    })    
    let optionEnvio="<option></option>";
    let optionNombre="<option></option>";
    let optionFecha="<option></option>";
    let optionComentario="<option></option>";
    let optionDocumento="<option></option>";
    arrayEnvio.forEach(a=>{optionEnvio+=`<option>${a}</option>`})
    arrayNombre.forEach(a=>{optionNombre+=`<option>${a}</option>`})
    arrayFecha.forEach(a=>{optionFecha+=`<option>${a}</option>`})
    arrayComentario.forEach(a=>{optionComentario+=`<option>${a}</option>`})
    arrayDocumento.forEach(a=>{optionDocumento+=`<option>${a}</option>`})
    tabla+=`<tr><th><select class="form-control" onchange="filtroHistorial(this)" data-classfiltro="nombreClass">${optionNombre}</select></th><th><select class="form-control" onchange="filtroHistorial(this)" data-classfiltro="envioClass">${optionEnvio}</select></th><th><select class="form-control" onchange="filtroHistorial(this)" data-classfiltro="documentoClass">${optionDocumento}</select></th><th></th><th></th><th><select class="form-control" onchange="filtroHistorial(this)" data-classfiltro="fechaClass">${optionFecha}</select></th><th><select class="form-control" onchange="filtroHistorial(this)" data-classfiltro="comentarioClass">${optionComentario}</select></th></tr>`;
    tabla+=`</thead>`
    tabla+=`<tbody>${tablaBody}</tbody><table>`;
    if(datos.envios.length==0){tabla=`${tablaBody}<tr><th colspan="4">SIN RESULTADOS</th></tr></thead></table>`}
    document.getElementById('envioHistorialGeneralDivTabla').innerHTML=tabla;
  }

}


function filtroHistorial(objeto)
{
   let clase=objeto.dataset.classfiltro;
   let valComparacion="";
   switch(clase)
   {
    case 'nombreClass':valComparacion='data-filtronombre'; break;
    case 'envioClass':valComparacion='data-filtropara'; break;
    case 'fechaClass':valComparacion='data-filtrofecha'; break;
    case 'comentarioClass':valComparacion='data-filtrocomentario'; break;
    case 'documentoClass':valComparacion='data-filtrodocumento'; break;
   }   
   let index=objeto.parentNode.cellIndex;
   let tbody=objeto.parentNode.parentNode.parentNode.nextSibling;
   
   let valor=objeto.value;
   let cadBody=Array.from(tbody.rows); 
   if(valor==''){cadBody.forEach(c=>{c.classList.remove(clase)})}
   else
   {
    cadBody.forEach(c=>{ 
        if(valor.indexOf(c.getAttribute(valComparacion))>=0){c.classList.remove(clase)}
        else{c.classList.add(clase)}
    })
   }
}

</script>
<?
function imprimirMesesEHGeneral($array)
 {
   $option='<option value="">-</option>';
   $mesActual=date('m');
   foreach ($array as $key => $value) 
   {
    if($key==$mesActual){$option.='<option value="'.$key.'" selected>'.$value.'</option>';}
    else{$option.='<option value="'.$key.'">'.$value.'</option>';}
   }
   return $option;
 }
?>