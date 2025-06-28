   <? $CI =& get_instance();
    $CI->load->model('catalogos_model');
    $meses=$CI->libreriav3->devolverMeses();
    if(isset($tipoDocumentoDPCAGenerales)){$tipoImg['tipoDocumento']=$tipoDocumentoDPCAGenerales;}
    else{$tipoImg['tipoDocumento']='';}
    ?>
  <?php $this->load->view('generales/modalGenericoV3');?>
<div class="modalGenericoContenidoV3" id="divAgregarDocumentosGenerales">
     <div class="row">
     	<div class="col-sm-3 col-md-4"></div>
     	<div class="col-sm-6 col-md-4"><h2>AGREGAR DOCUMENTOS</h2></div>
     	<div class="col-sm-3 col-md-4"></div>
     </div>
    <div class="row">
    	        <div class="col-sm-2 col-md-2" align="right"><label class="labelResponsivo"> SELECCIONAR TIPO DE DOCUMENTO:</label></div>
        <div class="col-sm-3 col-md-3"><?= imprimirTipoDocumentosDCPAGenerales($CI->catalogos_model->catalog_tipoimg($tipoImg));?></div>
         <div class="col-sm-1 col-md-1"><button name="" onclick ="crearArchivoEnvioDCPAGenerales(this)" class="btn btn-primary" style="font-size:14px" title="AÑADIR DOCUMENTO AL AREA DE ENVIO">-></button></div>

<div class="col-sm-5 col-md-5">
    	<form method="post" id="archivosFormDCPAGenerales" action="<?=base_url()?>clientes/subirDocumentos">
    		<input type="hidden" name="IDCli" id="IDCliDPCAGenerales">
         <div id="divContenedorArchivosDPCAGenerales"  style=" background-color:;border: solid;color:#e5e5e5;min-height: 100px;padding-top: 30px;display: block;overflow-y:  auto;max-height: 100px;overflow-x: hidden;"></div>
        
        </form>
        </div>
         <div class="col-sm-1 col-md-1"><button class="btn btn-success"  style="font-size:14px" title="GUARDAR LOS ARCHIVOS" onclick="enviarFormularioMGGenerales('archivosFormDCPAGenerales','mostrarDespuesDeGuardarDPCAGenerales','clientes/subirDocumentos')">&#128190</button></div>    
    </div>

     <div class="row" id="archivosDCPAGenerales">

     </div>
    </div>
  <script type="text/javascript">
  	var tipoBusquedaDCPAGenerales="<?=$tipoImg['tipoDocumento'];?>"
  function  traerDigitalDPCAGenerales(datos='',idCliente='')
   {
     if(datos=='')
     {
       if(idCliente!='')
       {
       	document.getElementById('IDCliDPCAGenerales').value=idCliente;
       let params=`IDCli=${idCliente}&tipoBusqueda=${tipoBusquedaDCPAGenerales}`;
       controlador="clientes/obtenerCentroDigital/?";
       peticionAJAXLib(controlador,params,'traerDigitalDPCAGenerales','divAgregarDocumentosGenerales');
      }
      else
      	{
      		alert('NO HAY CLIENTE')
      	}
    }
    else
    {
           
          clasificarArchivoExtensionDPCAGenerales(datos.documentosCliente);
          document.getElementById('divContenedorArchivosDPCAGenerales').innerHTML='';
     }
   }

function crearArchivoEnvioDCPAGenerales()
{
	if(tipoImgDPCAGenerales.value==''){alert('Necesita escoger un tipo de archivo')}
	else
	{
	 var combo = document.getElementById("tipoImgDPCAGenerales");
     var selected = combo.options[combo.selectedIndex].text;
     var valueSelect=combo.options[combo.selectedIndex].value;
     let objeto='file'+selected;
     let nombreObjeto=valueSelect;
      if(!document.getElementById(objeto))
      {
      	let divPadre=document.createElement('div');
      	let divFile=document.createElement('div');
      	let divLabel=document.createElement('div');      	
      	let divBoton=document.createElement('div')
      	divPadre.classList.add('row');
      	divLabel.classList.add('col-md-3');
      	divLabel.classList.add('col-sm-3');
      	divFile.classList.add('col-md-7')
      	divFile.classList.add('col-sm-7')
	   	divBoton.classList.add('col-md-2');
      	divBoton.classList.add('col-sm-2');
      	let boton=document.createElement('button');
      	boton.innerHTML='&#10060;';
        boton.setAttribute('style','background-color:white')
        boton.setAttribute('class','btn')
        boton.setAttribute('class','btn-primary')
        boton.setAttribute('onclick','borrarArchivoDPCAGenerales(this)');
	    let input=document.createElement('input');
	    input.type='file';
	    input.name=nombreObjeto;
	    input.id=objeto;
	    input.classList.add('form-control');
	    let label=document.createElement('label');
	    label.innerHTML=selected+':';
	    label.classList.add('label-info');
	    label.setAttribute('for',objeto)
	    divFile.append(input);
	    divLabel.append(label);	    
	    divBoton.append(boton);	   
	    divPadre.append(divLabel);
	    divPadre.append(divFile);
        divPadre.append(divBoton);
	    divContenedorArchivosDPCAGenerales.append(divPadre);
	  }
	  else{alert('Ya existe un componente para cargar este archivo')}
     }

}

function borrarArchivoDPCAGenerales(objeto)
{
	let padre=objeto.parentNode.parentNode.parentNode;
	padre.removeChild(objeto.parentNode.parentNode);
}

function mostrarDespuesDeGuardarDPCAGenerales(datos)
{
	 clasificarArchivoExtensionDPCAGenerales(datos.documentosCliente);
    document.getElementById('divContenedorArchivosDPCAGenerales').innerHTML='';
}

function clasificarArchivoExtensionDPCAGenerales(children)
{
	               let leng=children.length;
	              let cadena='NO TIENE ARCHIVOS PERSONALES ESTE CLIENTE';


         if(leng>0){
         	cadena='<div><ul><li><label class="label label-info label-xs">DOCUMENTOS DEL CLIENTE</label>';
                for(let i=0;i<leng;i++)
             {
    	           	let extension=children[i].href.split('.').pop();                 	
    	           	let clase='';
                 	extension=extension.toUpperCase();                 	
                 	switch(extension)
                 	{
                 		case 'PDF':clase='iconopdf';break;
                 		case 'MSG':clase='iconomsg';break;
                 		case 'JPG':clase='iconojpg';break;
                 		case 'JPEG':clase='iconojpg';break;
                 		case 'WORD':clase='iconoword';break;
                 		case 'XLS':clase='iconoxls';break;
                 		case 'XLSX':clase='iconoxls';break;
                 		case 'XML':clase='iconoxml';break;
                 		case 'DOCX':clase='iconoword';break;
                 		case 'PNG':clase='iconopdf';break;
                        default: clase='iconoblanco';break;
                 	}
                  cadena=cadena+'<li class="liArchivos"><div class="'+clase+' iconogenerico"><a href="'+children[i].href+'" target="_blank" >'+children[i].text+'</a></div></li>';
               }
               cadena+='</ul></div>';
           }

            document.getElementById('archivosDCPAGenerales').innerHTML=cadena;

}

  </script>
  <style type="text/css">
  	.iconocarpeta{ height:40px;background: url(<?echo(base_url().'assets/images/iconocarpeta.png') ;?>) no-repeat;}
.iconocarpeta > label{display: flex;align-items: center;position: relative;left: 35px;top:-20px;}
.iconocarpetasub{ height:40px;background: url(<?echo(base_url().'assets/images/iconocarpeta.png') ;?>) no-repeat;}
.iconocarpetasub > label{display: flex;align-items: center;position: relative;left: 35px;top:-5px;}
.iconojpg{ height:40px;background: url(<?echo(base_url().'assets/images/iconojpj.png') ;?>) no-repeat;}
.iconopdf{height:40px;background: url(<?echo(base_url().'assets/images/iconopdf.png') ;?>) no-repeat;}
.iconoword{ height:40px;background: url(<?echo(base_url().'assets/images/iconoword.png') ;?>) no-repeat;}
.iconoxls{ height:40px;background: url(<?echo(base_url().'assets/images/iconoxls.png') ;?>) no-repeat;}
.iconoxml{ height:40px;background: url(<?echo(base_url().'assets/images/iconoxml.png') ;?>) no-repeat;}
.iconomsg{ height:40px;background: url(<?echo(base_url().'assets/images/iconomsg.png') ;?>) no-repeat;}
.iconoblanco{ height:40px;background: url(<?echo(base_url().'assets/images/iconoblanco.png') ;?>) no-repeat;}
.iconoemail{ height:25px;background: url(<?echo(base_url().'assets/images/iconoEmail.png') ;?>) no-repeat;}
.iconogenerico > a{position: relative;left: 35px;  display: flex;align-items: center; text-decoration: underline;}
.liArchivos{font-size: 12px;list-style:none;border: solid:; white; color: black;display: flex;}


  </style>
  <?
function imprimirTipoDocumentosDCPAGenerales($array)
{$select='<select name="tipoImg_0" id="tipoImgDPCAGenerales" class="form-control input-sm"><option value="">-- Seleccione --</option>';
    foreach ($array as  $value) {$select.='<option value="'.$value->idTipoImg.'">'.$value->nombre.'</option>';}
	$select.='</select>';
	return $select;}


  ?>