<div class="panel panel-default" style="margin-bottom: 80px;">
  <div class="panel-body">
    <div class="col-md-12 column-flex-center-start" style="margin-bottom: 10px;">
      <div class="col-md-6 column-flex-center-start pd-left">
        <label class="subtitleSection">Selecione la clase:</label> 
        <select class="form-control width-ajust" id="sleectEmployeeMissing" style="margin-right: 8px;">
          <option value="COLABORADORES">COLABORADORES</option>
          <option value="AGENTES">AGENTES</option>
          <option value="CLIENTES">CLIENTES</option>
        </select>
        <button class="btn btn-primary" id="btnMissing" onclick="getTableMissing()" style="margin-right:5px;" disabled>Generar</button>
        <a class="btn btn-export-report" href="<?=base_url()?>VerEncuesta/excel?valor=COLABORADORES" target="_blank" id="btnExportMissing" title="Usuarios Faltantes" style="margin-right:10px;" disabled>
          <i class="fas fa-file-excel"></i> Reporte EXCEL</a>
      </div>
      <div class="col-md-6 column-flex-end pd-right" style="margin-right:5px;">
        <button class="btn btn-primary" id="btnOpenModalMessages" disabled>Mensajes Enviados</button>
      </div>
    </div>
    <div class="col-md-12" style="height: 450px;overflow: auto;">
      <table class="table table-striped" id='tableMissing' style="height: 100%;margin: 0px;">
        <thead class="table-thead">
         <tr class="tr-style">
            <th>Encuesta</th>
            <th>Asignadas</th>
            <th>Contestaron</th>
            <th>Faltan</th>
            <th>Enviar SMS</th>
            <th class="th-active">Enviar Correo</th>
         </tr>
        </thead>
        <tbody id="bodyTableMissing"></tbody>
      </table>
    </div>
  </div>
</div>

<!-- --------------------- Modals ------------------------ -->
<!--Modal para mostrar Alerta  de Entrega de tareas-->
<div class="modal fade messages-send-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Se puede usar el modal para otra información pero solo si se desocupa este espacio -->
      <div class="modal-header column-select">
        <h4 class="title-result">Mensajes enviados</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body" style="background: #f9f9f9;">
        <h4 class="titleSection" style="text-align: center;">
          Mensajes enviados el día de hoy (<?=date('d/m/Y');?>)</h4>
        <h5 class="subtitleSection" style="text-align: center;margin-bottom: 20px;">
        </h5>
        <div class="col-md-12" style="height: 350px;overflow: auto;">
          <table class="table table-striped" id="tableMessagesSend">
            <thead class="table-thead">
              <tr style="background: #286090;">
                <th>Enviado a</th>
                <th>Tipo</th>
                <?php //if($permission==1){?>
                <th style="display: none;">Estatus de Envío</th>
                <? //} ?>
              </tr>
            </thead>
            <tbody id="bodyTableMessagesSend"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default close-list" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Modal listas de no enviados-->
<div class="modalEncuestas" id='modalNoEnviados'>      
   <div class="bodymodal">   
     <div class="contenedor-modalNoEnviados">       
        <div class="btncierra">
         <button class ="cierra-modaltarea" onclick="cierraNoEnviados()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div class= "textoEntregaTareas">
            <h2 align="center">Mensajes No Enviados </h2>
           <p class ="textoenvio" id="textoenvio" ></p> 
            <div class = "tareas" id="tareas">
                  <ul id="noEnviados">
                
                  </ul>
             </div>       
        </div>        
      </div>    
   </div>
</div>
<!-- Modal Empleados para enviar mensaje -->
<div class="modal fade emails-employees-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Se puede usar el modal para otra información pero solo si se desocupa este espacio -->
      <div class="modal-header column-select">
        <h4 class="title-result">Enviar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body" style="background: #f9f9f9;">
        <h4 class="titleSection" id="nameTestSelect"></h4>
        <h5 class="subtitleSection" style="text-align: center;margin-bottom: 20px;">
          <span id="textTableSES"></span> que aún no responden esta encuesta.
        </h5>
        <div class="col-md-12" style="height: 300px;overflow: auto;">
          <table class="table table-striped" id="tableSelectionEmployeeSend">
            <thead class="table-thead">
              <tr style="background: #286090;">
                <th style="display: none;">ID_Test</th>
                <th>ID <span class="theadTableSES">Empleado</span></th>
                <th>Nombre Completo</th>
                <th>Seleccionar <input type="checkbox" class="form-check-input" data-employee="" id="selectAllSend"></th>
              </tr>
            </thead>
            <tbody id="bodyTableSelectionEmployeeSend"></tbody>
          </table>
          <div class="col-md-12" style="display: none;">
            <input type="text" class="form-control" id="idTestSelect">
            <input type="text" class="form-control" id="typeSend">
            <input type="text" class="form-control" id="typeEmployee">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="saveBtnMissing" onclick="sendAlertEmployees(this)" disabled>Enviar</button>
        <button class="btn btn-default close-list" data-dismiss="modal" id="closeModalMissing">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  //------ Seccion 4: Encuestas Sin Contestar  ------
  $(document).ready(function() {
    getTableMissing();
    getTableMessagesSend();

    $('#sleectEmployeeMissing').change(function() {
      const val = this.value;
      var url = `<?=base_url()?>VerEncuesta/excel?valor=${val}`;
      $('#btnExportMissing').attr('href',url);
      if (this.value != 0) {
        $('#btnMissing').prop('disabled',false);
        $('#btnExportMissing').attr('disabled',false);
      }
      else {
        $('#btnMissing').prop('disabled',true);
        $('#btnExportMissing').attr('disabled',true);
      }
    })

    $('#selectAllSend').click(function() {
      let check = document.getElementsByName('employee-send');
      if (this.checked) {
        for (let i=0;i<check.length;i++) {
          const td = $(check[i]).parent();
          const tr = $(td).parent();
          const display = $(tr).css('display');
          //console.log(display);
          if (display != "none") {
            $(check[i]).prop('checked',true);
          }
          else {
            $(check[i]).prop('checked',false);
          }
        }
      }
      else {
        $(check).prop('checked',false);
      }
      selectCheckbox();
    })

    $('#btnOpenModalMessages').click(function() {
      $(".messages-send-modal").modal({
          show: true,
          keyboard: false,
          backdrop: false,
      });
    })
  })

  function getTableMissing() {
    $('#btnMissing').prop('disabled',true);
    $('#btnExportMissing').prop('disabled',true);
    $('.th-active').css('display','');
    const employee = document.getElementById('sleectEmployeeMissing').value;
    //console.log(employee);
    $.ajax({
      type: "POST",
      url: `<?=base_url()?>VerEncuesta/MuestraEncuesta`,
      data: {
        empleados: employee
      },
      beforeSend: (load) => {
        $('#bodyTableMissing').html(`
            <tr>
                <td colspan="6">
                    <div class="container-spinner-content-loading">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        let t = r['consult'];
        var trtd = ``;
        var ul = ``;
        var disabled = "";
        var subthead = "Empleado";
        if (employee == "CLIENTES") {
          subthead = "Cliente";
          disabled = "disabled";
          $('.th-active').css('display','none');
        }
        if (t != 0) {
          for (const a in t) {
            trtd += `
              <tr class="testON">
                <td>${t[a].descripcion}</td>
                <td>${t[a].asignadas}</td>
                <td>${t[a].contesto}</td>
                <td>${t[a].asignadas - t[a].contesto}</td>
                <td class = "celular">
                  <a class ="nuevo" id = "C${t[a].idcabencuesta}" data-title="${t[a].descripcion}" data-employee="${employee}" onclick="enviaDatos(this)"><i class="fas fa-mobile-alt"></i></a>
                  <span class="textNumberIcon">${t[a].Celular}</span>
                </td>
                <td class = "correo th-active"">
                  <a class ="nuevo" id = "E${t[a].idcabencuesta}" data-title="${t[a].descripcion}" data-employee="${employee}" onclick="enviaDatos(this)" ${disabled}><i class="far fa-envelope"></i></a>
                  <span class="textNumberIcon">${t[a].Correo}</span>
                </td>
              </tr>
            `;
          }
        }
        else {
          trtd = `<tr><td colspan="6"><center><strong>Sin resultados</strong><center></td></tr>`;
        }
          
        $('#bodyTableMissing').html(trtd);
        $('#btnMissing').prop('disabled',false);
        $('#btnExportMissing').attr('disabled',false);
        $('.theadTableSES').text(subthead);
        if (employee == "CLIENTES") {
          $('.th-active').css('display','none');
        }
      },
      error: (error) => {
        console.log(error);
        $('#btnMissing').prop('disabled',false);
      }
    })
  }

  function getSendEmailEmployee(id,title,type,employee) {
    $('#selectAllSend').prop('checked',false);
    $('input[name="employee-send"]').prop('checked',false);
    $('#saveBtnMissing').prop('disabled',true);

    $.ajax({
      type: "GET",
      url: `<?=base_url()?>VerEncuesta/getInfoEmployeeTestActive`,
      data: {
        ts: id,
        vl: employee,
      },
      beforeSend: (load) => {
        $('#bodyTableSelectionEmployeeSend').html(`
            <tr>
                <td colspan="3">
                    <div class="container-spinner-content-loading">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
        `);
      },
      success: (data) => {
        const resp = JSON.parse(data);
        //console.log(resp);
        let r = resp['result'];
        var trtd = ``;
        var text1 = "";
        var text2 = "";
        for (const a in r) {
          var email = r[a].email;
          text2 = "Empleados";
          if (type == "cellphone") {
            text1 = text2 + " que cuentan con teléfono celular";
            var celular = r[a].celPersonal.replace(" ", "");
            celular.replace(".", "");
            if (r[a].celPersonal != "") {
              trtd += `
                <tr class="view-employee" name="tr-test">
                  <td style="display: none;">${r[a].idcabencuesta}</td>
                  <td>${r[a].idPersona}</td>
                  <td>${r[a].name_complete}</td>
                  <td>
                    <input type='checkbox' class='form-check-input' name="employee-send" data-test="${r[a].idcabencuesta}" value="${r[a].idPersona}" onclick="selectCheckbox()" checked disabled>
                  </td>
                </tr>`;
            }
          }
          else if (type == "email") {
            text1 = text2 + " que cuentan con correos electrónicos";
            if (r[a].email != 0) {
              trtd += `
                <tr class="view-employee" name="test${r[a].idcabencuesta}">
                  <td style="display: none;">${r[a].idcabencuesta}</td>
                  <td>${r[a].idPersona}</td>
                  <td>${r[a].name_complete}</td>
                  <td>
                    <input type='checkbox' class='form-check-input' name="employee-send" data-test="${r[a].idcabencuesta}" value="${r[a].idPersona}" onclick="selectCheckbox()">
                  </td>
                </tr>`;
            }
          }
        }

        if (type == "cellphone") {
          $('#selectAllSend').prop('checked',true);
          $('#selectAllSend').prop('disabled',true);
          $('#saveBtnMissing').prop('disabled',false);
        }
        else{
          $('#selectAllSend').prop('checked',false);
          $('#selectAllSend').prop('disabled',false);
        }
        $('#bodyTableSelectionEmployeeSend').html(trtd);
        $('#textTableSES').text(text1);
        $('#nameTestSelect').text(title);
        $('#idTestSelect').val(id);
        $('#typeSend').val(type);
        $('#typeEmployee').val(employee);
        $(".emails-employees-modal").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
      },
      error: (error) => {
        console.log(error);
        $('#btnMissing').prop('disabled',false);
      }
    })
  }

  function getTableMessagesSend() {
    const employee = document.getElementById('sleectEmployeeMissing').value;
    $.ajax({
      type: "GET",
      url: `<?=base_url()?>VerEncuesta/getMessagesEmployeeSendReady`,
      data: {
        em: employee
      },
      beforeSend: (load) => {
        $('#bodyTableMessagesSend').html(`
            <tr>
                <td colspan="4">
                    <div class="container-spinner-content-loading">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        var trtd = ``;
        var ul = ``;
        if (r != 0) {
          for (const a in r) {
            let t = r[a].encuesta;
            var test = "";
            var status = "";
            for (const b in t) {
              test += `<ul>${t[b].descripcion}</ul>`;
            }
            if (r[a].status != 0) {
              status = `<i class="fas fa-circle icon-circle-send"></i><span> Enviado</span>`;
            }
            else {
              status = `<i class="fas fa-circle icon-circle-no-send"></i><span> Aún No Enviado</span>`;
            }
            trtd += `
              <tr class="message-view">
                <td>${r[a].nombre}</td>
                <td>${r[a].tipo}</td>
                <?php //if($permission==1){?>
                <td style="display: none;">${status}</td>
                <? //} ?>
              </tr>
            `;
          }
        }
        else {
          trtd = `<tr><td colspan="4"><center><strong>Sin resultados</strong><center></td></tr>`;
        }
        $('#bodyTableMessagesSend').html(trtd);
        $('#btnOpenModalMessages').prop('disabled',false);
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function sendAlertEmployees() {
    const test = $('#idTestSelect').val();
    const send = $('#typeSend').val();
    const type = $('#typeEmployee').val();
    //console.log(test, type);
    swal({
        title: "¿Desea enviar?",
        text: "Las personas que no han respondido recibirán un mensaje de recordatorio para la encuesta.",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
    }).then((value) => {
      if (value) {
        if (send == "cellphone") {
          if(enviaSms(test,type) == 0){
            swal("¡Mensaje Enviado!", "Se les ha enviado mensaje.", "success");
            getTableMessagesSend();
          }
          else {
            swal("¡Vaya!", "Ocurrió un error al intentar enviar.", "error");
          }
        }
        else if (send == "email") {
          let check = document.getElementsByName('employee-send');
          let employee = [];
          for (let i=0;i<check.length;i++) {
            if (check[i].checked) {
              employee.push(check[i].value);
            }
          }
          //Envío correo
          if (type != "CLIENTES") {
            $.ajax({
              type: "GET",
              url: `<?=base_url()?>VerEncuesta/enviarEncuestaCorreo`,
              data: {
                id: test,
                em: employee,
                tp: type
              },
              beforeSend: (load) => {
              },
              success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                getTableMessagesSend();
                swal("¡Correo Enviado!", "Se les ha enviado un correo.", "success");              
              },
              error: (error) => {
                console.log(error);
                swal("¡Vaya!", "Ocurrió un error al intentar enviar.", "error");
              }
            })
          } else {enviaCorreo(test);}
        }
      }
    })
  }

  function selectCheckbox() {
      let check = document.getElementsByName('employee-send');
      let clase = document.getElementsByClassName('view-employee').length;
      var active = 0;
      var inactive = 0;
      for (let i=0;i<check.length;i++) {
        //var display = $(check[i]).closest('tr');
        if (check[i].checked) {
          active++;
        }
        else if (!check[i].checked) {
          inactive++;
        }
      }
      console.log("Checkbox seleccionados: "+active);
      if (active > 0) {
        $('#saveBtnMissing').prop('disabled',false);
      }
      else {
        $('#saveBtnMissing').prop('disabled',true);
      }
      //
      if (active == clase) {
        $('#selectAllSend').prop('checked',true);
      }
      else {
        $('#selectAllSend').prop('checked',false);
      }
  }

  //------------------------ FUNCIONES ORIGINALES MODIFICADAS -------------------------
  // function AddEventListener()
  // {
  //   //document.querySelector('.testON').addEventListener('click',enviaDatos);
  //   //document.querySelector('.btnMensaje').addEventListener('click',enviaMensaje);
  // }

  function enviaDatos(event){
    const envia = $(event).children('i');
    const parent = event.parentElement;
    const span = $(parent).children('span').text();
    const title = $(event).data('title');
    const employee = $(event).data('employee');
    if($(envia).hasClass('fa-envelope')){
      var id = $(event).attr('id').split("E");
      if(parseInt(span) == 0){
        swal("¡Sin Correo!", "No hay personas que tengan correo.", "warning");
      }
      else{
        getSendEmailEmployee(id[1],title,"email",employee);
        //sendAlertEmployees(id[1]);
      }
    }
    if($(envia).hasClass('fa-mobile-alt')){
      var id = $(event).attr('id').split("C");
      if(parseInt(span) == 0){
        swal("¡Sin Celular!", "No hay personas que tengan número celular.", "warning"); 
      }
      else{
        //sendAlertEmployees(id[1],"cellphone");
        getSendEmailEmployee(id[1],title,"cellphone",employee);
      }
    } 
    //console.log(span);
  }

  function enviaCorreo(id){
    var xhr = new XMLHttpRequest();
    var datos = new FormData();
    datos.append('idencuesta',id);
    xhr.open('POST',"<?php echo base_url();?>VerEncuesta/enviaCorreo",true);
    xhr.onload=function(){
      if(this.status === 200)
      {
        var respuesta = JSON.parse(xhr.responseText);
        console.log(respuesta);
      }
    }
    xhr.send(datos);
    return;
  } 

  function enviaSms(id,number){
    //console.log(id);
    var xhr = new XMLHttpRequest();
    var datos = new FormData();
    datos.append('idmensaje',id);
    datos.append('celular',number);
    $devuelve =0;
    xhr.open('POST',"<?php echo base_url();?>VerEncuesta/enviaMsg",false);
    xhr.onload=function(){
      if(this.status === 200)
      {
        var respuesta = JSON.parse(xhr.responseText);
        console.log(respuesta);
        if(respuesta.length > 0)
        {
          $devuelve =1;
          var lis = document.querySelectorAll('#noEnviados li'); 
          for(var i=0; li=lis[i]; i++) { 
            li.parentNode.removeChild(li); 
          }
          for(let i = 0; i < respuesta.length; i++) {
            // console.log(respuesta[i]);
            $("#noEnviados").append("<li> "+respuesta[i] +"---");
          }
          $(".modalNoEnviados").fadeIn(); 
        }
      }
    }
    xhr.send(datos);
    return $devuelve;
    // generaLinkEnvio('linkSms', '9991691988', '', 'CONTESTA ENCUESTA');
    // console.log(id);
  }
</script>
