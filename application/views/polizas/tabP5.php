<div class="col-md-12 bt-table tab-pane" id="PanelP5" style="padding: 0px; margin-bottom: 0px;"> 
    <div class="gifParaCapa" style="display: none" id="cargaDocumentoRecibosTable"></div>               
    <div class="divComentarioPolizas"><table class="table" id="comentarioPolizaTable"><thead><tr><th colspan="4"><div style="display: flex"><input id="comentarioPolizaInput" type="text" class="form-control" placeholder="AGREGAR COMENTARIO" name=""><button class="btn btn-primary" onclick="guardarComentarioSobrePoliza()">GUARDAR</button></div></th></tr><tr><th>TIPO</th><th>DOCUMENTO</th><th>SERIE</th><th></th></tr></thead><tbody id="comentarioPolizaBody"></tbody><tfoot><tr><td colspan="3">BITACORA DE COMENTARIOS</td><td></td></tr><tr><td colspan="4"><div id="comentarioBitacoraTfoot"></div></td></tr></tfoot></table>

    <div>
    <div class="gifParaCapa" style="display: none" id="cargaComentariosBitacora"></div>  
    <div id="bitacoraDeComentariosDiv"></div>
    </div>
    </div>
        <div>
            <div></div>
           
        </div>
</div>
<style type="text/css">
    .divComentarioPolizas{overflow: scroll;width: 100%;height: 100%}
    #comentarioPolizaBody>tr:hover{background: #bcaad8}
    #comentarioPolizaBody>tr[data-tipo="recibo"]{color:blue;}
    .rowDocumentoSeleccionadoComentario{background-color: #699d81}

    .divComentarioPolizas>table>thead{position: sticky;top: 0px}
</style>
<script type="text/javascript">
    function seleccionarRowComentario(objeto)
    {
       let rowSel= document.getElementsByClassName('rowDocumentoSeleccionadoComentario');
       if(rowSel[0]){rowSel[0].classList.remove('rowDocumentoSeleccionadoComentario')}
        objeto.classList.add('rowDocumentoSeleccionadoComentario');
        refrescarComentariosBitacora();

        
    }
    function guardarComentarioSobrePoliza()
    {
      let rowSel= document.getElementsByClassName('rowDocumentoSeleccionadoComentario');
      if(rowSel.length>0)
      {
          let comentario=''
          if(rowSel[0].dataset.tipo=='recibo'){comentario=
          `¿ Deseas agregar un comentario al ${rowSel[0].dataset.tipo} del documento ${rowSel[0].dataset.documento} serie ${rowSel[0].dataset.idserie} del cliente ${rowSel[0].dataset.nombrecliente}?`}
          else
          {
            comentario=
          `¿ Deseas agregar un comentario al  documento ${rowSel[0].dataset.documento} s del cliente ${rowSel[0].dataset.nombrecliente}?`
          }
          let confirmacion = confirm(comentario);
          if(confirmacion)
          {let comentarioDocumento=document.getElementById('comentarioPolizaInput').value.trim();
           if(comentarioDocumento=='')
           {
            alert('Agregar un comentario para guardar')
           }
           else
           {
            if(rowSel[0].dataset.tipo=='documento')
            {
                let params=`Documento=${rowSel[0].dataset.documento}&comentario=${comentarioDocumento}&IDDocto=${rowSel[0].dataset.iddocto}&IDVend=${rowSel[0].dataset.idvend}`;

               peticionAJAX_VER('cobranza/comentariosRenovacion',params,'handlerGuardarComentarios',capa='cargaDocumentoRecibosTable');
            }
            else
            {
                let endoso='';
                if(rowSel[0].dataset.endoso!="undefined"){endoso=rowSel[0].dataset.endoso;}
                       let params=`IDRecibo=${rowSel[0].dataset.idrecibo}&comentario=${comentarioDocumento}&idDocto=${rowSel[0].dataset.iddocto}&serie=${rowSel[0].dataset.idserie}&IDCli=${rowSel[0].dataset.idcli}&endoso=${endoso}&IDVend=${rowSel[0].dataset.idvend}`;
                       peticionAJAX_VER('cobranza/comentarios',params,'handlerGuardarComentarios',capa='cargaDocumentoRecibosTable')
            }
            refrescarComentariosBitacora();
            document.getElementById('comentarioPolizaInput').value='';
           }
         } 

      }
      else
      {
        alert('ESCOGER UNA POLIZA O UN RECIBO');
      }
    }

function refrescarComentariosBitacora(datos='')
{
   
  if(datos=='')
  {
    if(document.getElementsByClassName('rowDocumentoSeleccionadoComentario').length>0){
   let rowSel= document.getElementsByClassName('rowDocumentoSeleccionadoComentario')[0];
   let params='';
    params=`tipo=${rowSel.dataset.tipo}&idRecibo=${rowSel.dataset.idrecibo}&idDocto=${rowSel.dataset.iddocto}`;
    peticionAJAX_VER('cobranza/buscarComentariosCobranzaRenovacion',params,'refrescarComentariosBitacora',capa='cargaComentariosBitacora'); 
     }
  }
  else
  {

   let inner='';
    datos.bitacora.forEach(b=>{
     inner+=`<div style="display:flex;flex-direction:column"><div style="display:flex;justify-content: space-between;"><div><h3>FECHA:${b.fec}</h3></div><div></div><div><h3>HORA:${b.hora}</h3></div></div><div>${b.comentario}[${b.emailUsers}]</div></div><hr>`
    })
   
    document.getElementById('bitacoraDeComentariosDiv').innerHTML=inner;
  }
}

</script><script type="text/javascript">
    
    //document.getElementById('comentarioPolizaBody').addEventListener("DOMSubtreeModified", handler, true);
    //document.getElementById('comentarioPolizaBody').addEventListener("DOMNodeInserted", handler, true);
    //document.getElementById('comentarioPolizaBody').addEventListener("DOMNodeInsertedIntoDocument", handler, true);
    //document.getElementById('comentarioPolizaBody').addEventListener("load", handler, true);
function handler(){if(this.innerHTML!=''){verificaDocumentosConComentarios(datos='',this)}}
function handlerGuardarComentarios(){if(this.innerHTML!=''){verificaDocumentosConComentarios(datos='',document.getElementById('comentarioPolizaBody'));}}

function verificaDocumentosConComentarios(datos='',tabla)
{

 if(datos=='')
 {
          let rows=tabla.rows;
      let documento='';
      let recibosID='';
      let params=`peticionAjax=true&IDDocto=${rows[0].dataset.iddocto}`;
      peticionAJAX_VER('cobranza/verificaDocumentosConComentarios',params,'verificaDocumentosConComentarios','cargaDocumentoRecibosTable');
 }
 else
 {

  let tabla=document.getElementById('comentarioPolizaBody').rows;
   for(let i of tabla){if(i.dataset.tipo=='documento'){if(datos.renovacionComentario[0].total!=0){i.cells[3].innerHTML=`<div class="divImagen"></div>`;}}}

   for(let i of datos.cobranzaComentario){for(let j of tabla){if(j.dataset.tipo=='recibo'){if(i.idRecibo==j.dataset.idrecibo){j.cells[3].innerHTML=`<div class="divImagen"></div>`;}}}}
    refrescarComentariosBitacora();
 }
}
function peticionAJAX_VER(controlador,parametros,funcion,capa='')
{
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
  req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  if(capa!=''){document.getElementById(capa).style.display='block'}
  req.onreadystatechange = function (aEvt) 
  {   
    if (req.readyState == 4) 
    {       
      if(req.status == 200)    
      {   
         var respuesta=JSON.parse(this.responseText);             
         if(capa!=''){document.getElementById(capa).style.display='none';}
         window[funcion](respuesta,capa);                                                    
      }           
    }
  };
 req.send(parametros);
}
</script>
<style type="text/css">

    .gifParaCapa{position: absolute;z-index: 2;width: 100%;height: 100%;background-color: white;opacity: .5;background-image: url(<?=base_url().'assets/img/esperaBlue.gif' ?>);background-size: 40px;background-repeat: no-repeat;background-position-x:center;background-position-y:center;}
    .divImagen{
  background-image:url(<?=base_url()?>assets/images/comentario.png);
  background-repeat:no-repeat;
  height:20px;
  width:20px;
  background-position:center;
}
</style>