     <? $CI =& get_instance();
    if(isset($tipoDocumentoDPCAGenerales)){$tipoImg['tipoDocumento']=$tipoDocumentoDPCAGenerales;}
    else{$tipoImg['tipoDocumento']='';}
     ?>
<style type="text/css">
	#nombreArchivosGeneralesGD{display: flex;flex-direction: column;border: dotted 1px black;background-color: white;overflow: scroll;}
	#nombreArchivosGeneralesGD>div{width: 100%}
	#nombreArchivosGeneralesGD>div>div:nth-child(1){flex:5;}
	#nombreArchivosGeneralesGD>div>div:nth-child(2){flex:2;}
	#nombreArchivosGeneralesGD>div>div:nth-child(3){flex:1;}
	#nombreArchivosGeneralesGD>div:nth-child(even){background-color:#e0def7;}
	#nombreArchivosGeneralesGD>div:nth-child(odd){background-color:#e0eeff;}
	#contenedorArchivosGeneralesGDInput{width: 30px}
	#contenedorArchivosGeneralesGDInput::before{content:url(<?=base_url()?>assets/images/agregarArchivoIcono.png);color:red;}
	#nombreArchivosGeneralesGD>div>div>select{position: relative;top:8px;}
	#guardarArchivosGeneralesGD::before{content:url(<?=base_url()?>assets/images/guardarArchivo.png);}
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

<?php $this->load->view('generales/modalGenericoV3');?>

<div style="display: none"><?= imprimirTipoDocumentosDCPAGenerales($CI->catalogos_model->catalog_tipoimg($tipoImg));?></div>	
      
 <div style="display: none;flex-direction: column;" id="ventanaDocumentosGeneralesGD">
<div id="esperaParaSubirDocumentosGeneralesAD" class=""></div>
<div style="background-color: #a3aefb;display: flex;flex-direction: row-reverse;background-color: #b7b2ac"><button class="btn btn-danger" onclick="cerrarVentanaGeneralesGD()" >X</button></div>
<div style="display: flex;flex-direction: row-reverse">
	
  <div><button id="guardarArchivosGeneralesGD" class=""  style="font-size:14px;background-color: white;border:none" title="GUARDAR LOS ARCHIVOS" onclick="guardarArchivosGeneralesGD('',event)"></button></div>
  <div><button id="borrarArchivosGeneralesGD" class=""  style="font-size:14px;background-color: white;border:none" title="VACIAR EL CONTENEDOR DE ARCHIVOS" onclick="vaciarElContenedorArchivos()"></button></div>
  <div><input type="file" id="contenedorArchivosGeneralesGDInput" name="myfiles[]" multiple onchange="cargarArchivos(this)" title="CLICK PARA AGREGAR ARCHIVOS"></div>
  <progress value="0" max="100" style="width: 300px;display: none" id="barraProgresoGeneralesGD">
</div>
<div id="nombreArchivosGeneralesGD"></div>


</div>
<script type="text/javascript">

	let indexFormData=0;
	let formData = new FormData();
	let IDDoctoGeneralesGD='';
	document.getElementById('contenedorArchivosGeneralesGDInput').addEventListener('change',cargarArchivos);
	document.getElementById('nombreArchivosGeneralesGD').addEventListener('drop',cargarArchivos);
	document.getElementById('nombreArchivosGeneralesGD').addEventListener('dragover',cargarArchivos);
	function abrirVentanaGeneralesGD()
	{

		if(IDDoctoGeneralesGD!='')
		{
		document.getElementById('ventanaDocumentosGeneralesGD').style.display='flex';
	    }
	    else{alert('Necesita pasar un documento')}

	}
	function cerrarVentanaGeneralesGD()
	{
		document.getElementById('ventanaDocumentosGeneralesGD').style.display='none';
	}

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
      		if(propiedades!='length'){
        formData.append('files'+indexFormData,objeto[propiedades]);
		formData.append('files'+indexFormData+'tipo','18');
		indexFormData++;
	     }
	    }
      }		this.value='';
		repintarElContenedorArchivos();
	 }
	}

	function repintarElContenedorArchivos()
	{
		let div='';
		for(let [name, value] of formData) 
		{
          
          if(typeof(value)=='object')
          {
          	
          	div+=`<div style="display:flex;"><div><label>${value.name}</label></div><div><select  id="${value.name}" onchange="cambiaTipoArchivoGeneralesGD(this)" data-valor="${name}tipo" style="display:none">${document.getElementById('tipoImgDPCAGenerales').innerHTML}</select></div><div><button onclick="eliminarArchivoGuardar(this,event)" data-valor="${name}" class="borraFileContenedor"></button></div></div>`
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
	{  e.preventDefault();		
		formData.delete(objeto.dataset.valor)
		formData.delete(objeto.dataset.valor+'tipo');
		repintarElContenedorArchivos()

	}
	function cambiaTipoArchivoGeneralesGD(objeto)
	{
         let select = objeto;
         
       // var selected = combo.options[combo.selectedIndex].dataset.namearchivos;
        let array=Array.from(document.getElementById('contenedorArchivosGeneralesGDInput').files);
              array.forEach(a=>{
       	if(a.name==select.dataset.namearchivos)
       	{
       		a.tipoArchivo=select.value;
       		a.value=select.value;
       	}
       })
	}
	


	function guardarArchivosGeneralesGD(datos='',e)
	{

				/*fetch('<?=base_url()?>clientes/agregarDocumentos',{method:'POST',body:formData}).then(rta=>rta.json()).then(json=>{console.log(json)}).catch(e=>{console.error(e)})*/
				if(IDDoctoGeneralesGD==''){alert('NECESITAS UN IDDocto'); return 0}
       document.getElementById('barraProgresoGeneralesGD').value=0;
       document.getElementById('esperaParaSubirDocumentosGeneralesAD').classList.toggle('esperaGuardarArchivos');
	  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
      else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}
      var direccion= <?php echo('"'.base_url().'"');?>+'clientes/agregarDocumentos';
     formData.append('IDDocto',IDDoctoGeneralesGD)
      Req.upload.addEventListener('progress',function(e){
      	let porcentaje=(e.loaded/e.total)*100;
      	document.getElementById('barraProgresoGeneralesGD').value=Math.round(porcentaje);
      })
   Req.onreadystatechange = function (aEvt) 
  {                                                                              
    if (Req.readyState == 4) {    	
      if(Req.status == 200)    
        {   

         var respuesta=JSON.parse(this.responseText);             
          alert('LOS ARCHIVOS YA SE CARGARON')
               document.getElementById('esperaParaSubirDocumentosGeneralesAD').classList.toggle('esperaGuardarArchivos');
               vaciarElContenedorArchivos();
      }     
      
   }

  };
	  Req.open("POST",direccion, true);
	  Req.send(formData);
	}
</script>

  <?
function imprimirTipoDocumentosDCPAGenerales($array)
{$select='<select name="tipoImg_0" id="tipoImgDPCAGenerales" class="form-control input-sm" onclick="cambiaTipoDocGeneralesGD(this)">';
    foreach ($array as  $value) 
    	{   $check='';
    		if($value->idTipoImg==18){$check='selected';}
    		$select.='<option  value="'.$value->idTipoImg.'" '.$check.'>'.$value->nombre.'</option>';
    	}
	$select.='</select>';
	return $select;}


  ?>



