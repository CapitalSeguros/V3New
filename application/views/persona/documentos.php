
<style type="text/css">
  table tr td{
    font-size: 11px;
  }
   table tr th{
    font-size: 12px;
  }
  #UrlDocument {
    font-size: 12px;
  }
  #NameDocument {
    font-weight: 600;
  }
  .textSizeLabel {
    font-size: 13px;
  }
  .container-well {
    height: 500px;
    overflow: auto;
    border-radius: 4px;
    position: relative;
  }
  .col-well {
    background-color: #fff;
    /*max-height: 600px;
    overflow: auto;*/
    margin-bottom: 0px;
    padding: 0px 19px;
  }
  .column-flex {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 5px 15px;
  }
  .col-spinner-upload {
    width: 100%;
    height: 100%;
    position: absolute;
  }
  .col-spinner-load-general {
    width: 100%;
    height: 100%;
  }
  .container-spinner-load-general {
    margin: 0px;
    color: #266093;
    width: 100%;
    height: 540px;
    align-items: center;
    display: flex;
    justify-content: center;
    flex-direction: column;
    position: relative;
    background-color: rgb(255 255 255 / 75%);
    z-index: 1001;
  }
  .container-xml {
    width: 100%;
    height: -webkit-fill-available;
    border: 1px solid #c1c1c1;
    border-radius: 3px;
    padding: 10px;
  }
  .th-table {
    color: #fff;
    font-weight: 400;
    padding: 8px 15px;
    line-height: 1.42857143;
    vertical-align: top;
  }
  .swal-modal {
    width: 28%; /* 68% height: 40%*/
  }
  .swal-button--confirm{
    background-color:#337ab7!important;
  }
  .swal-text{
    /*color:#472380 !important;*/
    font-size: 17px;
    text-align: center;
  }
</style>
<!-- Documento agignados por puesto en general-->
<?php $email  = $this->tank_auth->get_usermail();
  if($permission["uploadFile"]){?>
    <button data-toggle="modal" data-target="#subir_documento" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Nuevo</button>
<?php } ?>
<!-- Documentos Generales-->
<div class="col-md-12 pd-top pd-left pd-right">
    <table style="width:100%;">
    <thead>
       <tr style="background-color:#7598bf;color: #fff;height: 25px;">
         <td colspan="3" style="text-align:center;font-weight: 600;font-size: 12px;">
            DOCUMENTOS GENERALES
         </td>
       </tr>
       <tr style="background-color:#1e4c82;color: #fff;height: 25px;">
         <th class="th-table"><i class="fa fa-file"></i>&nbsp;Nombre del Documento</th>
         <th class="th-table"><i class="fa fa-file-pdf-o"></i>&nbsp;Opciones del documento</th>
         <?php $permisoEliminar=0;  if($permisoAgregar==1){
           $permisoEliminar=1;?>
         <?php }?>
       </tr>
    </thead>
  </table>
  <div class="col-spinner-documentacion" id="SpinnerDocGenerales"></div>
  <div class="container-well">
  <div class="well col-well">
    <div class="col-spinner-load-general"></div>
      <table class="table table-hover">
      <tbody id="body-table-doc-general"></tbody>
   </table>
 </div>
 </div>
</div>


<!-- Modal Subir Documento -->
<div id="subir_documento" class="modal fade" role="dialog">
  <form id="frmdocumento" enctype="multipart/form-data" method="post" action="">
  <div class="modal-dialog" style="width: 60%">
   <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-file-text"></i>&nbsp;Guardar Documento</h4>
      </div>
      <div class="col-spinner-upload" id="SpinnerUpload"></div>
      <div class="modal-body">
          <table border="0" width="100%">
          <tr>
            <td><label class="textSizeLabel">Nombre del propietario:</label></td>
            <td><input type="text" name="propietario" value="<?php echo $this->tank_auth->get_usernamecomplete();?>" class="form-control" style="margin-bottom: 3px;"></td>
          </tr>
          <tr>
            <td><label class="textSizeLabel">Nombre del Documento:</label></td>
            <td><input type="text" id="nombre" name="nombre" class="form-control" style="margin-bottom: 3px;"></td>
          </tr>
          <tr>
            <td><label class="textSizeLabel">Depósito del archivo:</label></td>
            <td><select name="rutaArchivo" id="rutaArchivo" class="form-control" style="margin-bottom: 6px;">
              <option value="materialDidactico">Carpeta de archivos didácticos</option>
              <option value="1">Carpeta de archivos principales</option>
            </select></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="file" id="documento" name="documento" class="textSizeLabel" style="margin-bottom: 15px;"></td>
          </tr>

          <tr>
            <td colspan="2"><hr style="border-top: 1px solid #d7d7d7;"></td>
          </tr>

           <tr>
            <td colspan="2"><b class="textSizeLabel">OPCIONES DE ASIGNACIONES</b></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;&nbsp;<input type="radio" name="chkasignar" onclick="mostrarPuestos(0)" checked="true" value="general">&nbsp;<label class="textSizeLabel">General</label></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;&nbsp;<input type="radio" name="chkasignar" onclick="mostrarPuestos(1)" value="especifico">&nbsp;<label class="textSizeLabel">Asignar a un Puesto</label></td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="divpuestos" style="display:none;">
               <select id="puesto_documento" name="puesto_documento" class="form-control">
                 <?=imprimirPuestosHomonimos($puestosTodos)?>
               </select>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer" style="position: relative;">
         <button id="bnt_submit" type="submit" class="btn btn-primary">Guardar&nbsp;<i class="fa fa-check"></i></button>
         <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar&nbsp;<i class="fa fa-times"></i></button>
      </div>
  </div>
  </div>
</form>
</div>



<!-- Mostrar documento visor PDF -->
<div id="visor_pdf" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog" style="width: 85%;">
  <!-- Modal content-->
     <div class="modal-content"  style="margin-left:-40%;height: auto;width: 180%;">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-file-pdf-o"></i>&nbsp;Vista del documento <span id="NameDocument"></span> <span id="UrlDocument"></span></h5>
        <div style="text-align: right;">
        <button type="button" class="btn btn-warning btn-xs" id="BtnCerrarModal" data-dismiss="modal" style="color: #262626;">Cerrar&nbsp;<i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="modal-body">
       <div id="visor" style="height:450px;"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!-- <link rel="stylesheet" href="<?php echo base_url();?>css/sweetalert2.min.css"> -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#frmdocumento").on('submit', function(e) {
      e.preventDefault();
      var formData = new FormData(document.getElementById("frmdocumento"));
      var nombre=document.getElementById('nombre').value;
      var documento=document.getElementById('documento').value;
      var puesto_documento=document.getElementById('puesto_documento').value;
      if((nombre=="")||(documento=="")){
        var text = "Informacion";
        swal("¡Espera!", "Debes completar todos los datos.", "info");
      }else{
        $.ajax({
            url: `<?=base_url()?>capitalHumano/guardar_documento`,
            type: "POST",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: (load) => {
                $('#SpinnerUpload').html(`
                    <div class="container-spinner-content-upload">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Guardando...</p>
                    </div>
                `);
            },
            success: (data) => {
                const res = JSON.parse(data);
                console.log(res);
                $('#SpinnerUpload').html("");
                if (res['message'] == "GUARDADO") {
                  swal("¡Guardado!", "Documento guardado.", "success");
                  DocumentosCC();
                  //window.location.reload();
                } else {
                  swal("¡Vaya!", "Ocurrió un conflicto al tratar de guardar el documento.", "error");
                }
            },
            error: (error) => {
              $('#SpinnerUpload').html("");
                swal("¡Uups!", "Hay problemas al intentar guardar el documento.", "error");
            }            
        })
      }
    })

    $("#BtnCerrarModal").click(function() {
      $("#visor").html("");
    })

    $('#documento').change(function() {
        files = this.files;
        showFile(files);
    })
  })

  function showFile(files) {
    for (const file of files) {
      const tipo = file.type;
      const reader = new FileReader();
      const id = `file-${Math.random().toString(32).substring(7)}`;
      const s = Number(file.size)/1024;
      const t = s.toFixed(0);
      console.log(file);
    }
  }

  function mostrarPuestos(op){
    if(op==1){
     document.getElementById('divpuestos').style.display="block";
    }else{
      document.getElementById('divpuestos').style.display="none";
    }
  }

  /*function guardar_documento(){
    var nombre=document.getElementById('nombre').value;
    var documento=document.getElementById('documento').value;
    var puesto_documento=document.getElementById('puesto_documento').value;
    if((nombre=="")||(documento=="")){
      var text = "Informacion";
      Swal.fire({
      title: '',
      type: 'info',
      html:
      '<div style="text-align:center;font-size:12px;"><b>Debe completar todos los datos</b></div>'
      })
    }else{
      document.getElementById('frmdocumento').submit(); 
    } 
  }*/

  document.getElementById("rutaArchivo").addEventListener("change", function(){

    console.log("change");
    var disabled_ = this.value == "materialDidactico";
    var elements_ = document.getElementsByName("chkasignar");
    
    if(disabled_){
      elements_[0].checked = true;
      mostrarPuestos(0);

    }

    for(var a in elements_){
      elements_[a].disabled = disabled_;
      
    }
  });

  function FiltrarPorPuesto(dato) {
        var input, filter, table, tr, td, i, j, visible;
        input = document.getElementById('SelectFiltrar');
        filter = input.value.toUpperCase();
        table = document.getElementById("body-table-doc-asignado");
        tr = table.getElementsByTagName("tr");
        let Fila = document.getElementsByClassName('mostrar');

        for (i = 0; i < tr.length; i++) {
            visible = false;
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    visible = true;
                }
            }
            if (visible === true) {
                tr[i].style.display = "";
                $(tr[i]).addClass('mostrar');
            }
            else {
                tr[i].style.display = "none";
                $(tr[i]).removeClass('mostrar');
            }
        }
        result = Fila.length;
    }

</script>

