
<script type="text/javascript">
    function cargarDocumentoFin(objeto='')
  {
            if( document.getElementById('cargaArchivosDiv'))
        {
       document.getElementById('cargaArchivosDiv').classList.remove('verVisorArchivos');
            document.getElementById('cargaArchivosDiv').classList.add('ocultarVisorArchivos')
        }
  }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php $this->load->view('generales/modalGenericoV3');?>
<div id="visorDocumentosGenerales">
	<div id="contenedorBotonesBarraDiv">
		<div><button id='btnVisorDocumentosBarraRecibo' class="btn btn-info btnVisorDocumentosBarra">Recibo</button></div>
    <div><button id="btnVisorDocumentosBarraDocumento" class="btn btn-info btnVisorDocumentosBarra">Documento</button></div>
    <div><button id="btnVisorDocumentosBarraCliente" class="btn btn-info btnVisorDocumentosBarra">Cliente</button></div>		
	</div>
	<div>
		<div id="soloCarpetasDivVD">
			
		</div>
		<div id="visorDeArchivosVD">
			
		</div>
	</div>
	<div>   <div id="cargaArchivosDiv" class="ocultarVisorArchivos" style=""><img src="<?=base_url()?>assets/images/loading.gif"></div>
		                          <iframe class="ocultarVisorArchivos" id="visorGeneral" onload='cargarDocumentoFin(this)' src="" frameborder="0"></iframe>
                          <iframe class="ocultarVisorArchivos" id="visorTXT" onload='cargarDocumentoFin(this)' src="" frameborder="0"></iframe>

                          <iframe class="ocultarVisorArchivos" id="visorXMLDOC" onload='cargarDocumentoFin(this)' src=""></iframe>
                            <div id="visorJPGDiv" class="ocultarVisorArchivos" style="height: auto;overflow: scroll;"><img  id="visorJPG"  onload='cargarDocumentoFin(this)'> </div>
                            <div class="ocultarVisorArchivos" id="visorSinProcesarArchivo"><h1>ESTE VISOR NO PUEDE PROCESAR ESTE TIPO DE ARCHIVO, DALE DOBLE CLICK PARA DESCARGARLO O VERLO EN EL NAVEGADOR</h1></div>
                         
	</div>

</div>
  
<style type="text/css">	
#contenedorBotonesBarraDiv{border-bottom: solid 1px;display: flex;width: 100%}
#visorDocumentosGenerales{height: 100%;width: 100%;display: flex;flex-direction: column;}
#visorDocumentosGenerales>div:nth-child(1){background-color: white;height: 5%;display: flex}
#visorDocumentosGenerales>div input,button{height: 100%}
#visorDocumentosGenerales>div:nth-child(2){background-color: white;height: 45%;display: flex;border-bottom: solid 1px}
#visorDocumentosGenerales>div>div:nth-child(2){background-color: white;height: 100%;}
#visorDocumentosGenerales>div>div:nth-child(3){background-color: white;height: 100%}
#visorDocumentosGenerales>div:nth-child(3){background-color: white;height: 0%}
#soloCarpetasDivVD{height: 300px;width: 30%;overflow-y: scroll;overflow-x: auto;}

#visorDeArchivosVD{display: flex;flex-wrap: wrap;justify-content: left;overflow: auto;align-content: flex-start;width: 70%}
#visorDeArchivosVD>li{list-style: none;width: 20%}
#visorDeArchivosVD>li>label{display: flex;flex-direction: column;font-size: 13px;margin-left: 13px;margin-top: 13px;text-align: center;}
#visorDeArchivosVD>li>label[data-href$=".pdf" i]::before{content:url(<?=base_url()?>assets/images/iconopdf.png);}  
#visorDeArchivosVD>li>label[data-href$=".xlsx" i]::before{content:url(<?=base_url()?>assets/images/iconoxls.png);} 
#visorDeArchivosVD>li>label[data-href$=".xls" i]::before{content:url(<?=base_url()?>assets/images/iconoxls.png);} 
#visorDeArchivosVD>li>label[data-href$=".xml" i]::before{content:url(<?=base_url()?>assets/images/iconoxml.png);} 
#visorDeArchivosVD>li>label[data-href$=".jpg" i]::before{content:url(<?=base_url()?>assets/images/iconojpg.png);}
#visorDeArchivosVD>li>label[data-href$=".jpeg" i]::before{content:url(<?=base_url()?>assets/images/iconojpg.png);}  
#visorDeArchivosVD>li>label[data-href$=".docx" i]::before{content:url(<?=base_url()?>assets/images/iconoword.png);} 
#visorDeArchivosVD>li>label[data-href$=".doc" i]::before{content:url(<?=base_url()?>assets/images/iconoword.png);} 
#visorDeArchivosVD>li>label[data-href$=".zip" i]::before{content:url(<?=base_url()?>assets/images/iconoZip.png);} 
#visorDeArchivosVD>li>label[data-href$=".msg" i]::before{content:url(<?=base_url()?>assets/images/iconomsg.png);} 
#visorDeArchivosVD>li>label[data-href$=".msg" i]::before{content:url(<?=base_url()?>assets/images/iconoRar.png);} 
#visorDeArchivosVD>li>label[data-href$=".txt" i]::before{content:url(<?=base_url()?>assets/images/iconotxt.png);} 
#visorDeArchivosVD>li>label[data-href$=".png" i]::before{content:url(<?=base_url()?>assets/images/iconoPng.png);} 
</style>
<script type="text/javascript">
let idReciboVisorDocumento=0;
let idDocumentoVisorDocumento=0;
let idClienteVisorDocumento=0;
let tipoBusquedaVisorDocumento;
function obtenerArchivosClientesVD(val,tipoBusqueda)
{
  let  params=`idCliente=${idClienteVisorDocumento}&idDocumento=${idDocumentoVisorDocumento}&idRecibo=${idReciboVisorDocumento}&tipoBusqueda=${tipoBusqueda}`;
 
controlador='archivos/peticionArchivoSicas/?';

  /* let params='IDValuePK=6936'//+documentoSolicitudIDCli.value;
   controlador="actividades/digitalAct/?";
      */
   
   peticionAJAXLib(controlador,params,'pintarCarpetasVD','');
   
}

function pintarCarpetasVD(datos)
{
 
 
                    let doc='';let abierto=false;let level='';let c=[];let total=0;let arrayDoc=[];let bandEntrada=true;let nivelAnt=0;let idAnterior=0;idPadre=0;
                    idAnterior=0;nivelAnt=0;bandEntrada=false;doc='';let archivosCarpetaPrincipal=''
                       let nivelMaximo=0;
              if(datos.children){c=datos.children;total=datos.children.length}
/*===================================CLASIFICA CARPETAS Y HEREDA IL IDPADRE============*/
                        for(let i=0;i<total;i++)
                        	{  
                        	 if(c[i].isFolder)
                        		{    if(c[i].level>nivelMaximo){nivelMaximo=c[i].level;}

                        				if(c[i].level>nivelAnt){idPadre=idAnterior;}
                        				 else
                        				 {
                        				 if(c[i].level<=nivelAnt){                        				  
                        				   let cantRevers=arrayDoc.length-1;
                        				   for(let j=cantRevers;j>0;j--)
                        				   {
                        				   	if(c[i].level==arrayDoc[j][1])
                        				   	{                        				   		
                        				   		idPadre=arrayDoc[j][3];
                        				   		j=-1;
                        				   	}
                        				   }

                        				   }
                        				 
                        				 }
                        				let a=[i,c[i].level,c[i].text,idPadre];
                        				arrayDoc.push(a);
                        				nivelAnt=c[i].level;
                        				idAnterior=i;
                        			}
                              else
                              {
                                if(c[i].level==1){archivosCarpetaPrincipal+=`<li class="digitalSicas ocultarHijos"><label  data-href="${c[i].href}" onclick="detectarDobleClickVD(event,this)" target="_blank" title="${c[i].text}">${c[i].text}</label></li>`}
                              }
                        	}

/*=================================================================================================*/  
/*========================LE AGREGA LOS RESPECTIVOS DOCUMENTOS A CADA CARPETA=======================*/  
         // c=ES TODO EL ARREGLO DE SICAS
          // arrayDoc= SON LAS CARPETAS QUE TIENE c                    	
                        cant=arrayDoc.length;
                        let liA='';
                        for(let i=0;i<cant;i++)
                        {
                        	
                        	let incrementador=arrayDoc[i][0]+1;
                        
                        
                             try
                             {   
                                
                             	let li='';
                                 let salida=0;
                                 let bandFolder=false;
                                  liA='';

                                  let nivelIgual=(arrayDoc[i][1]);
                                    nivelIgual++;
                                   
                                   	let salidaWhile=0;
                                   while((c[incrementador].level)==nivelIgual)
                                   {
                                    
                                   	if(!c[incrementador].isFolder)
                                   	{	bandFolder=true;

                                       li+=`<li class="digitalSicas ocultarHijos"><label  data-href="${c[incrementador].href}" onclick="detectarDobleClickVD(event,this)" target="_blank">${c[incrementador].text}</label></li>`;
                                   	}
                                    if(incrementador==(total-1)){break;}
                                   	 incrementador++;
                                    
                                  }
                               
                                  (li=='')? arrayDoc[i][4]='':arrayDoc[i][4]=`<ul data="${li.length}">${li}</ul>`;
                              
                             }
                             catch(error){console.log(error)}
                         
                        }
                            
/*=============================================================================================*/
/*================CONCATENA SUBCARPETAS CON LA CARPETA DE NIVEL 1=============================*/

                        while(nivelMaximo>1)
                        {
                        	 for(let i=0;i<cant;i++)
                        	 {
                               if(arrayDoc[i][1]==nivelMaximo)
                               {
                                let subFolder='';
                               	for(let j=0;j<total;j++)
                        	     {
                                   if(arrayDoc[i][3]==arrayDoc[j][0])
                                   {
                                    let nombre;
                                    (arrayDoc[i][4]=='')? nombre='' : nombre=arrayDoc[i][4];
                                   	//arrayDoc[j][4]+=`<ul><ul><li class="digitalSicas" href=".carpeta">${arrayDoc[i][2]}</li></ul>${arrayDoc[i][4]}</ul>`;
                                   	arrayDoc[j][4]+='<div class="divContenedorCarpeta"><div class="divContenedorBotonTitulo"><button class="btn-despliegue btn-carpeta" onclick="ocultarHijosFolder(event,this)" >-</button><div class="tituloCarpetaPanelVD" onclick="verDocumentoEnPanel(event,this)">'+arrayDoc[i][2]+'</div></div><ul>'+nombre+'</ul></div>';
                                   	j=total;
                                   }
                        	     }
                               }
                        	 }
                        	nivelMaximo--;
                        }
/*=================================================================*/   
                        cant=arrayDoc.length;
                 
/*=========================IMPRIME ARBOL=======================*/
                        for(let i=0;i<cant;i++)
                        {
                           if(arrayDoc[i][3]=="0")
                           {
                           	if(arrayDoc[i][4]==''){doc+='<div class="divContenedorCarpeta"><div class="divContenedorBotonTitulo"><button class="btn-despliegue btn-carpeta" onclick="ocultarHijosFolder(event,this)"><label>-</label></button><div class="tituloCarpetaPanelVD" onclick="verDocumentoEnPanel(event,this)">'+arrayDoc[i][2]+'</div></div></div>';}
                           	else
                           	{
                                  let nombre;
                                    (arrayDoc[i][2]=='')? nombre='(S/N)' : nombre=arrayDoc[i][2];
                           	 doc+='<div class="divContenedorCarpeta"><div class="divContenedorBotonTitulo"><button class="btn-despliegue btn-carpeta" onclick="ocultarHijosFolder(event,this)"><label>-</label></button><div class="tituloCarpetaPanelVD" onclick="verDocumentoEnPanel(event,this)">'+nombre+'</div></div><ul>'+arrayDoc[i][4]+'</ul></div>';
                           	}
                        
                           }   
                        }
/*=============================================================*/



   if(arrayDoc.length==0 && total>0)
   {
   /* let li="";
     for(let val of c){li+=`<li class="digitalSicas ocultarHijos"><label  data-href="${val.href}" onclick="detectarDobleClickVD(event,this)" target="_blank" title="${val.text}">${val.text}</label></li>`;}     
     doc='<div class="divContenedorCarpeta"><div class="divContenedorBotonTitulo"><button class="btn-despliegue btn-carpeta" onclick="ocultarHijosFolder(event,this)"><label>-</label></button><div class="tituloCarpetaPanelVD" onclick="verDocumentoEnPanel(event,this)">FOLDER</div></div><ul><ul>'+li+'</ul></ul></div>'   */  
   }
 
                                        
                        document.getElementById('soloCarpetasDivVD').innerHTML='<div class="divContenedorCarpeta"><div class="divContenedorBotonTitulo"><button class="btn-despliegue btn-carpeta" onclick="ocultarHijosFolder(event,this)"><label>-</label></button><div class="tituloCarpetaPanelVD" onclick="verDocumentoEnPanel(event,this)">FOLDER</div></div><ul><ul>'+archivosCarpetaPrincipal+'</ul>'+doc+'</ul></div>' ;
                  
                  if(document.getElementById('soloCarpetasDivVD').childNodes[0].childNodes[0].childNodes[1])
                  {let event = new Event("click");
                    verDocumentoEnPanel(event,document.getElementById('soloCarpetasDivVD').childNodes[0].childNodes[0].childNodes[1])
                  }

              
 
}
function verDocumentoEnPanel(e='',objeto)
{

  //e.preventDefault(); 
  document.getElementById('visorDeArchivosVD').innerHTML='';
  if(objeto.parentElement.nextElementSibling)
  { 
         if(objeto.parentElement.nextElementSibling.tagName=='UL')
    {
      
     if(objeto.parentElement.nextElementSibling)
     {
      if(objeto.parentElement.nextElementSibling.childNodes[0]){
      if(objeto.parentElement.nextElementSibling.childNodes[0].tagName=='UL')
      {
       document.getElementById('visorDeArchivosVD').innerHTML=objeto.parentElement.nextElementSibling.childNodes[0].innerHTML;
       let hijos=document.getElementById('visorDeArchivosVD').children;
       for(let val of hijos)
       {
        val.classList.remove('ocultarHijos')
        //val.classList.add('archivosMostradosDeCarpeta')
        val.children[0].classList.add('archivosMostradosDeCarpeta');
        val.children[0].addEventListener('click',obj=>{
          let contenidoMostradoArchivoVD=document.getElementsByClassName('contenidoMostradoArchivoClass');
          for(let c of contenidoMostradoArchivoVD)
          {
            c.classList.remove('contenidoMostradoArchivoClass');
          }
          obj.target.classList.add('contenidoMostradoArchivoClass');
        })
  

       }
      

      }
      }
     } 
    }

  }
  let carpetaSeleccionadaVD=document.getElementsByClassName('carpetaSeleccionadaVD');
             for(let val of carpetaSeleccionadaVD){val.classList.remove('carpetaSeleccionadaVD');}
       objeto.classList.add('carpetaSeleccionadaVD')
}
   clicks = 0,
    timer = null;
    let DELAY =600;
function detectarDobleClickVD(e,objeto)
{

        clicks++;  //count clicks

        if(clicks === 1) {

            timer = setTimeout(function() {         
             
                clicks = 0;  
                       let href=objeto.dataset.href;
      let ref=href.slice((href.lastIndexOf(".") - 1 >>> 0) + 2);
      ref=ref.toUpperCase();
      document.getElementById('visorGeneral').classList.add('ocultarVisorArchivos');
      document.getElementById('visorTXT').classList.add('ocultarVisorArchivos');
      document.getElementById('visorXMLDOC').classList.add('ocultarVisorArchivos');
      document.getElementById('visorGeneral').classList.remove('verVisorArchivos');
      document.getElementById('visorTXT').classList.remove('verVisorArchivos');
      document.getElementById('visorXMLDOC').classList.remove('verVisorArchivos');
      document.getElementById('visorJPGDiv').classList.add('ocultarVisorArchivos');
      document.getElementById('visorJPGDiv').classList.remove('verVisorArchivos');
      document.getElementById('visorSinProcesarArchivo').classList.add('ocultarVisorArchivos');
      document.getElementById('visorSinProcesarArchivo').classList.remove('verVisorArchivos');
      document.getElementById('cargaArchivosDiv').classList.add('verVisorArchivos');
      document.getElementById('cargaArchivosDiv').classList.remove('ocultarVisorArchivos')
    //  document.getElementById('nombreDocumentoH4').innerHTML=`<label class="label label-info">${objeto.innerHTML}</label>`;

      if(ref=='XLS' || ref=='XLSX' || ref=='DOC' || ref=='DOCX' || ref=='XLSM' )
      {


        document.getElementById('visorXMLDOC').classList.remove('ocultarVisorArchivos');
        document.getElementById('visorXMLDOC').classList.add('verVisorArchivos');       
          document.getElementById('visorXMLDOC').setAttribute('src','//view.officeapps.live.com/op/embed.aspx?src='+href);
                
      }
      else
      {
        if(ref=='XML' || ref=='PDF' ){
        document.getElementById('visorGeneral').classList.remove('ocultarVisorArchivos');
        document.getElementById('visorGeneral').classList.add('verVisorArchivos');  
        document.getElementById('visorGeneral').setAttribute('src','https://docs.google.com/gview?url='+href+'&id=explorer&efh=false&a=v&chrome=false&embedded=true');
        }
        else
        {//https://www.sicasonline.info/SICASData/SICAS1325/Storage/CONT000013028/Cliente/IFE--202101111842.jpg
          if(ref=='JPG' || ref=='PNG' || ref=='JPEG')
          {
        document.getElementById('visorJPGDiv').classList.remove('ocultarVisorArchivos');
        document.getElementById('visorJPGDiv').classList.add('verVisorArchivos'); 
        //document.getElementById('visorJPG').setAttribute('src',href);
        //document.getElementById('visorJPG').setAttribute('type',"image/jpg");
                //document.getElementById('visorGeneral').setAttribute('src','https://docs.google.com/gview?url='+href+'&id=explorer&efh=false&a=v&chrome=false&embedded=true');
            document.getElementById('visorJPG').setAttribute('src',href);

          }
          else
          {
                   if(ref=='TXT')
                   {
                              document.getElementById('visorTXT').classList.remove('ocultarVisorArchivos');
        document.getElementById('visorTXT').classList.add('verVisorArchivos');  
      
            document.getElementById('visorTXT').setAttribute('src',href);
                   }
                   else{
                  document.getElementById('visorSinProcesarArchivo').classList.remove('ocultarVisorArchivos');
          document.getElementById('visorSinProcesarArchivo').classList.add('verVisorArchivos');
          cargarDocumentoFin();
        }

          }
        }
      }


            }, DELAY);

        } else {

            clearTimeout(timer);  //prevent single-click action

           window.open(objeto.dataset.href)
            clicks = 0;  //after action performed, reset counter
        }
}



function ocultarHijosFolder(e,objeto)
{
	e.preventDefault();
  /**/
  if(objeto.parentElement.nextElementSibling)
  {
    if(objeto.parentElement.nextElementSibling.tagName=='UL')
    {
      if(objeto.parentElement.nextElementSibling.classList.contains('ocultarHijos'))
  {
   objeto.parentElement.nextElementSibling.classList.remove('ocultarHijos')
   objeto.innerHTML='-'; 
  }
  else{objeto.parentElement.nextElementSibling.classList.add('ocultarHijos');objeto.innerHTML='+' }
  //objeto.parentElement.parentElement.classList.toggle('ocultarHijos');
    }

  }
}


function inicio()
{
 let barra=document.getElementsByClassName('btnVisorDocumentosBarra');

 for(let val of barra)
 {
  val.addEventListener('click',ob=>{
    
    let barra=document.getElementsByClassName('btnVisorDocumentosBarra');
    for(let valor of barra)
    {
      valor.classList.remove('botonSeleccionadoBarra');
    }
    ob.target.classList.add('botonSeleccionadoBarra')
  })
 }



  let botones=document.getElementsByClassName('btnVisorDocumentosBarra');
  for(let btn of botones)
  {
    btn.addEventListener('click',obj=>{
      switch(btn.id)
      {
        case 'btnVisorDocumentosBarraRecibo': obtenerArchivosClientesVD(idReciboVisorDocumento,'recibo') ;break;
        case 'btnVisorDocumentosBarraDocumento':  obtenerArchivosClientesVD(idDocumentoVisorDocumento,'documento');break;
        case 'btnVisorDocumentosBarraCliente':  obtenerArchivosClientesVD(idClienteVisorDocumento,'cliente');break;
      }
    })
  }


}
inicio();

</script>
<style type="text/css">
	.btn-carpeta{border:none;  background-image:url(<?=base_url()?>assets/images/iconocarpeta.png);background-repeat:no-repeat;width: 25px;height: 25px}
	.divContenedorCarpeta{display: flex;flex-direction: column;}
	.divContenedorBotonTitulo{display: flex;}
	.ocultarHijos{display: none}
  .ocultarVisorArchivos{display: none}
  .verVisorArchivos{width: 100%;height: 700px}
  .botonSeleccionadoBarra{text-decoration: underline;background-color: #50aeca}
  .tituloCarpetaPanelVD:hover{color:blue;text-decoration: underline;cursor: pointer;}
  .carpetaSeleccionadaVD{border:solid 1px;color:white;background-color: #a1c6f0}
  
  .archivosMostradosDeCarpeta:hover{color:blue;text-decoration: underline;cursor: pointer;}
  .contenidoMostradoArchivoClass{background-color: #b1b1ff}
  .btn-despliegue{background-color: white}
</style>