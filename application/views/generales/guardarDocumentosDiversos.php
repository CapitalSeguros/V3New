     <? $CI =& get_instance();
    if(isset($tipoDocumentoDPCAGenerales)){$tipoImg['tipoDocumento']=$tipoDocumentoDPCAGenerales;}
    else{$tipoImg['tipoDocumento']='';}
     ?>
<style type="text/css">
	#nombreArchivosGeneralesGD{display: flex;flex-direction: column;border: dotted 1px black;background-color: white;overflow: scroll;min-height: 100px;max-height: 300px}
	#nombreArchivosGeneralesGD>div{width: 100%}
	#nombreArchivosGeneralesGD>div>div:nth-child(1){flex:5;}
	#nombreArchivosGeneralesGD>div>div:nth-child(2){flex:2;}
	#nombreArchivosGeneralesGD>div>div:nth-child(3){flex:1;}
	#nombreArchivosGeneralesGD>div:nth-child(even){background-color:#e0def7;}
	#nombreArchivosGeneralesGD>div:nth-child(odd){background-color:#e0eeff;}
	#contenedorArchivosGeneralesGDInput{width: 30px}
	#contenedorArchivosGeneralesGDInput::before{content:url(<?=base_url()?>assets/images/agregarArchivoIcono.png);color:red;}
	#nombreArchivosGeneralesGD>div>div>select{position: relative;top:8px;}
	#guardarArchivosGeneralesDiversos::before{content:url(<?=base_url()?>assets/images/guardarArchivo.png);}
	#borrarArchivosGeneralesGD::before{content:url(<?=base_url()?>assets/images/borrarArchivos.png);}
	.borraFileContenedor{background-color: white;border:none;}
	.borraFileContenedor::before{content:url(<?=base_url()?>assets/images/borrarArchivos.png);}
	.borraFileContenedor:nth-child(odd){background-color:#e0eeff;}
	.borraFileContenedor:nth-child(even){background-color:#e0def7;}
#nombreArchivosGeneralesGD::before{content: 'ARRASTRAR LOS ARCHIVOS QUE DESEAS AGREGAR O DARLE CLICK AL BOTON DE AGREGAR';position: sticky;left: 20%;top:0px;opacity: .5;border:solid 1px black;width:50%}	
.esperaGuardarArchivos{position: absolute;width: 100%;height: 100%;background-color: #c0e3e0;top:350px;opacity: .8;top: 0px;}
.esperaGuardarArchivos::before{content: url(<?=base_url()?>assets/images/loading.gif);left:50%;position: relative;top:30%;};
.esperaGuardarArchivos img{left: 40%;position: relative;top:30%;;display: none}
#nombreArchivosGeneralesGD{height: 100%}

</style>

<?php $this->load->view('generales/modalGenericoV3');
$tipoImagenes=$CI->catalogos_model->catalog_tipoimg($tipoImg);
?>

<div style="display: none"><?= imprimirTipoDocumentosDCPAGenerales($tipoImagenes);?></div>	
      
 <div style="display: none;flex-direction: column;" id="ventanaDocumentosGeneralesGD">
<div id="esperaParaSubirDocumentosGeneralesAD"  style="position: relative;" class=""></div>
<div style="position: absolute;display: none" class="iconoEsperaGDD" id="iconoEsperaGDD"></div>
<div style="background-color: #a3aefb;display: flex;flex-direction: row-reverse;background-color: #b7b2ac" id="barraDeCerradoGDD"><button class="btn btn-danger" onclick="cerrarVentanaGeneralesGD()" >X</button></div>
<div style="display: flex;flex-direction: row-reverse">
  
  <div><button id="guardarArchivosGeneralesDiversos" class=""  style="font-size:14px;background-color: white;border:none" title="GUARDAR LOS ARCHIVOS" onclick="guardarArchivosGeneralesDiversos('',event)"></button></div>
  <div><button id="borrarArchivosGeneralesGD" class=""  style="font-size:14px;background-color: white;border:none" title="VACIAR EL CONTENEDOR DE ARCHIVOS" onclick="vaciarElContenedorArchivos()"></button></div>
  <div><input type="file" id="contenedorArchivosGeneralesGDInput" name="myfiles[]" multiple onchange="cargarArchivos(this)" title="CLICK PARA AGREGAR ARCHIVOS"></div>
  <progress value="0" max="100" style="width: 300px;display: none" id="barraProgresoGeneralesGD">
</div>
<div id="nombreArchivosGeneralesGD"></div>
<div style="display: flex;flex-direction: row-reverse;" id="pasarActividadDivGDD"><input style="width: 21px;height: 21px" type="checkbox" name="pasarActividadCBGDD" id="pasarActividadCBGDD"><label style="font-size: large;">PASAR EN CURSO</label></div>

</div>
<script type="text/javascript">
/*$FolderDestino			= "Target_".$infoFolioActividad->tipoActividad;
						if($infoFolioActividad->poliza!=""){
						$FolderDestino			.= "\\".
						}*/
	let indexFormData=0;
	let formData = new FormData();
	let IDDoctoGeneralesGD='';
	let IDClienteGDD='';
	let tipoActividadGDD='';
	let polizaGDD='';
	let folioActividadGDD='';
	let TypeDestinoCDigitalGDD='';
	let IDValuePKGDD='';
	let ListFilesURLGDD='';
	let FolderDestinoGDD='';
	let moduloOrigen='';
	let moduloOrigenGDD='';
	let periodoGDD='';
	let documentoGDD='';
	let endosoGDD='';
	let endosoIdGDD='';
	let IDDoctoGGD='';
	let idReciboGDD='';
	let serieGDD='';
	let enviarCorreoGDD='';
	document.getElementById('contenedorArchivosGeneralesGDInput').addEventListener('change',cargarArchivos);
	document.getElementById('nombreArchivosGeneralesGD').addEventListener('drop',cargarArchivos);
	document.getElementById('nombreArchivosGeneralesGD').addEventListener('dragover',cargarArchivos);
	function abrirVentanaGeneralesGD()
	{document.getElementById('ventanaDocumentosGeneralesGD').style.display='flex';}
	function cerrarVentanaGeneralesGD(){document.getElementById('ventanaDocumentosGeneralesGD').style.display='none';}

	function cargarArchivos()
	{   event.preventDefault()
		
        let objeto='';
       if(this.id=='contenedorArchivosGeneralesGDInput'){objeto=this.files;}
       else{objeto=event.dataTransfer.files;}
       if(objeto.length>0){
       
       for (const propiedades in objeto) 
      {    
      	if(typeof(objeto[propiedades])!='function')
      	{
      		if(propiedades!='length')
      	 {

           formData.append('files'+indexFormData,objeto[propiedades]);
		   formData.append('files'+indexFormData+'tipo','0');
		   formData.append('files'+indexFormData+'descripcion','');
		   indexFormData++;
	     }
	    }
      }		       
        this.value='';
		repintarElContenedorArchivos();
	 }
	}

	function repintarElContenedorArchivos()
	{
		let div='';
		let opciones=document.getElementById('tipoImgDPCAGenerales').childNodes

		for(let [name, value] of formData) 
		{   
			
			
			
          if(typeof(value)=='object')
          {  let opcionesInner=''
          	
          	         let tipo=formData.get(name+"tipo");
          	         let descripcion=formData.get(name+"descripcion");          	       
          	         let classTipo='selectOpcionElegidaGDD';
          	         let classDescripcion='selectOpcionElegidaGDD';
                 for(let op of opciones)
                 {   
                 	if(op.value==tipo){opcionesInner+=`<option value="${op.value}" selected>${op.innerHTML}</option>`}
                 		else{opcionesInner+=`<option value="${op.value}" >${op.innerHTML}</option>`}
                 }
                  if(tipo=='0'){classTipo='selectSinEscogerArchivoGDD';};
                  if(descripcion==''){classDescripcion='selectSinEscogerArchivoGDD';};

          	div+=`<div style="display:flex;"><div style="flex:5"><label>${value.name}</label></div><div style="flex:13"><input type="text" style="width:90%" class="form-control ${classDescripcion}" onchange="cambiaTipoArchivoGeneralesGD(this)"  data-valor="${name}descripcion" maxlength="20" minlegth="10" value="${descripcion}"><div></div></div><div style="flex:3;"><select style="position:relative;top:0px;width:85%" id="${value.name}" value="${tipo}"  class="form-control selectElegirTipoArchivoGDD ${classTipo}" onchange="cambiaTipoArchivoGeneralesGD(this)" data-valor="${name}tipo" data-opcionescoger="0">${opcionesInner}</select><div></div></div><div style="flex:1;z-index:1"><button style="flex:1" onclick="eliminarArchivoGuardar(this,event)" data-valor="${name}" class="borraFileContenedor"></button></div></div>`
          }
        }
        document.getElementById('nombreArchivosGeneralesGD').innerHTML=div;
	}
	function vaciarElContenedorArchivos()
	{
		
		let array=[];
		for(let [nombre,valor] of formData)
			{    array.push(nombre);
				
				//formData.delete(nombre)
			}
			array.forEach(a=>{
              formData.delete(a);
			})
		
		repintarElContenedorArchivos();
	}
	function eliminarArchivoGuardar(objeto,e)
	{  
		e.preventDefault();		
		formData.delete(objeto.dataset.valor)
		formData.delete(objeto.dataset.valor+'tipo');
		formData.delete(objeto.dataset.valor+'descripcion');
		repintarElContenedorArchivos()

	}
	function cambiaTipoArchivoGeneralesGD(objeto)
	{
		formData.set([objeto.dataset.valor],objeto.value);
		if(objeto.nodeName=='SELECT')
		{

			if(objeto.value=='0'){objeto.classList.add('selectSinEscogerArchivoGDD');objeto.classList.remove('selectOpcionElegidaGDD');}
            else{objeto.classList.remove('selectSinEscogerArchivoGDD');objeto.classList.add('selectOpcionElegidaGDD');}
		}
		else
		{
				if(objeto.nodeName=='INPUT')
		 {
		 if(objeto.value.trim()==''){objeto.classList.add('inputSinEscogerArchivoGDD');objeto.classList.remove('selectOpcionElegidaGDD');}
            else{objeto.classList.remove('inputSinEscogerArchivoGDD');objeto.classList.add('selectOpcionElegidaGDD');}
          }
		}
	}
//-----------------------------------------------------------	
	function guardarArchivosGeneralesDiversos(datos='',e)
	{

				/*fetch('<?=base_url()?>clientes/agregarDocumentos',{method:'POST',body:formData}).then(rta=>rta.json()).then(json=>{console.log(json)}).catch(e=>{console.error(e)})*/

	if(!verificarCamposObligatoriosArchivos()){alert('LOS CAMPOS DESCRIPCION ES NECESARIO Y NECESITA SELECCIONAR UN TIPO DE ARCHIVO');return false;}
	 
	 //if(IDDoctoGeneralesGD=='' || IDClienteGDD ==''){alert('NECESITAS UN DOCUMENTO Y UN CLIENTE'); return 0}
     
       document.getElementById('barraProgresoGeneralesGD').value=0;
       document.getElementById('esperaParaSubirDocumentosGeneralesAD').classList.toggle('esperaGuardarArchivos');
	  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
      else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}
      var direccion= <?php echo('"'.base_url().'"');?>+'actividades/agregarDocumentos';
     formData.append('IDDocto',IDDoctoGeneralesGD);
     formData.append('IDCli',IDClienteGDD);
     formData.append('tipoActividad',tipoActividadGDD);
     formData.append('poliza',polizaGDD);
      formData.append('folioActividad',folioActividadGDD);
       formData.append('TypeDestinoCDigital',TypeDestinoCDigitalGDD);
       formData.append('IDValuePK',IDValuePKGDD);
       formData.append('FolderDestino',FolderDestinoGDD);
        formData.append('idCliente',IDClienteGDD);
     formData.append('pasarActividadEnCurso',document.getElementById('pasarActividadCBGDD').checked);
     formData.append('moduloOrigen',moduloOrigenGDD);
     formData.append('documentoGDD',documentoGDD);
     formData.append('periodoGDD',periodoGDD);
     formData.append('endosoGDD',endosoGDD);
     formData.append('endosoIdGDD',endosoIdGDD);
     formData.append('IDDoctoGGD',IDDoctoGeneralesGD);
     formData.append('idReciboGDD',idReciboGDD);
     formData.append('serieGDD',serieGDD);
      formData.append('enviarCorreoGDD',enviarCorreoGDD);
      document.getElementById('iconoEsperaGDD').style.display='block';
      /*Req.upload.addEventListener('progress',function(e){
      	let porcentaje=(e.loaded/e.total)*100;
      	document.getElementById('barraProgresoGeneralesGD').value=Math.round(porcentaje);
      })*/
   Req.onreadystatechange = function (aEvt) 
  {                                                                              
    if (Req.readyState == 4) {    	
      if(Req.status == 200)    
        {   

         var respuesta=JSON.parse(this.responseText);             
          alert('LOS ARCHIVOS YA SE CARGARON')
               document.getElementById('esperaParaSubirDocumentosGeneralesAD').classList.toggle('esperaGuardarArchivos');
               vaciarElContenedorArchivos();
               document.getElementById('iconoEsperaGDD').style.display='none';
               	if(window.funcionDefaultGDD){if(typeof(window.funcionDefaultGDD)=='function'){funcionDefaultGDD()} } 
      }     
      
   }

  };
	  Req.open("POST",direccion, true);
	  Req.send(formData);
	}
//-----------------------------------------------------------
function verificarCamposObligatoriosArchivos()
{
  let band=true;	
  for(let [name, value] of formData) 
		{
          if(name.includes('tipo'))
          	{
          		if(value=='0'){band=false}
          	}
          if(name.includes('descripcion'))
          {
          	if(value==''){band=false}
          }
        }
     return band;
}
</script>

  <?
function imprimirTipoDocumentosDCPAGenerales($array)
{$select='<select name="tipoImg_0" id="tipoImgDPCAGenerales" class="form-control input-sm" onclick="cambiaTipoDocGeneralesGD(this)"><option  data-opcionescoger="" value="0">ESCOGER EL TIPO DE DOCUMENTO</option>';
    foreach ($array as  $value) 
    	{   $check='';
    		/*if($value->idTipoImg==18){$check='selected';}*/
    		$select.='<option  value="'.$value->idTipoImg.'" '.$check.'>'.$value->nombre.'</option>';
    	}
	$select.='</select>';
	return $select;}


  ?>

<style type="text/css">
	
	.selectSinEscogerArchivoGDD{color: #99a1a9}
	.selectSinEscogerArchivoGDD+div{position: relative;top: -34px;left: 90%;z-index: 0}
	.selectSinEscogerArchivoGDD+div::after{content: "?";font-size: 21px;background-color: #8b8585;color: white;border-radius: 40%}
	.selectOpcionElegidaGDD{color: #4482b9}
	.selectOpcionElegidaGDD+div{position: relative;top: -34px;left: 90%}
	.selectOpcionElegidaGDD+div::after{content: "✔";font-size: 21px;background-color: #5bfd94;color: white;border-radius: 40%}

	.inputSinEscogerArchivoGDD+div{position: relative;top: -34px;left: 90%}
		.inputSinEscogerArchivoGDD+div::after{content: "✍";font-size: 21px;background-color: #8b8585;color: white;border-radius: 40%}
	.selectElegirTipoArchivoGDD>option{color: #4482b9;}
	.selectElegirTipoArchivoGDD>option:nth-child(1){color:  #99a1a9}
	.iconoEsperaGDD{position: absolute;z-index: 2;width: 100%;height: 100%;background-color: white;opacity: .5;background-image: url(<?=base_url().'assets/img/esperaBlue.gif' ?>);background-size: 40px;background-repeat: no-repeat;background-position-x:center;background-position-y:center;}
  

</style>

