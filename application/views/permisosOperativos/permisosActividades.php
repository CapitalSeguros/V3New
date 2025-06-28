

  <div class="col-md-12 bg-permisos-content">
    <div class="col-md-12" style="padding: 5px 0px;">
    <select class="form-control" id="selectOperativos" onchange="buscarPermisos();" style="width: 100%;color:#212529"><?php echo(imprimirOperativos($empleados));?></select>
    </div>
    <div class="col-md-12" style="display: flex;justify-content: flex-end;padding-right: 0px;margin-top: 20px;"> <!-- width: 285px; -->
      <ul class="nav nav-tabs hidden" id="nav-tab-Permisos">
        <li class="nav-item active">
          <a class="nav-tab-link active" aria-current="page" id="VerPermisosOperativos" href="#PermisosOperativos" role="tab" data-toggle="tab">Asignar Permisos</a>
        </li>
        <li class="nav-item">
          <a class="nav-tab-link" aria-current="page" id="VerTablaTodosLosPermisos" href="#TablaTodosLosPermisos" role="tab" data-toggle="tab">Tabla Permisos</a>
        </li>
      </ul>
    </div>
    <div class="tab-content bg-tab-content hidden" id="nav-panel-Permisos">      
      <div class="col-md-12 bg-table tab-pane active" id="PermisosOperativos">
        <div class= "col-md-4">
          <label>Areas: </label>
            <input class="form-check-input checkbox-Area" name="CheckArea" type="checkbox" style="margin-top: 0px;position: static;" data-value="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM"/> INSTITUCIONAL 
                  
            <input class="form-check-input checkbox-Area" name="CheckArea" type="checkbox" style="margin-top: 0px;position: static;" data-value="COORDINADOR@CAPCAPITAL.COM.MX"> MERIDA 

            <input class="form-check-input checkbox-Area" name="CheckArea" type="checkbox" style="margin-top: 0px;position: static;" data-value="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"> CANCUN 

            <input class="form-check-input checkbox-Area" name="CheckArea" type="checkbox" style="margin-top: 0px;position: static;" data-value="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"> FIANZAS 
                        
          </div>
        <div class="col-md-12 bg-buttons" id="BotonPermiso">
          
          <div class="col-md-4 hidden" id="AlertaInfo">
          <div class="alert alert-primary" role="alert" style="font-size:13px;text-align: center;margin-bottom: 0px;padding: 10px;">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
              <span class="st-info">No se le ha otorgado ningún permiso.</span>
          </div>
        </div>
        <button class="btn btn-Guardar btn-General hidden" id="GuardarPermisos" title="Guardar Permiso" type="button" onclick="GuardarPermisos()" disabled>
          Guardar
        </button>
        <button class="btn btn-danger btn-General hidden" id="EliminarPermisos" title="Eliminar Todos Los Permisos" type="button" onclick="EliminarPermisos()">
          Eliminar
        </button>
      </div>
      <div class="col-md-4 style-table" id="cont-Actividades">
        <table class="table table-hover" id="Actividades">
            <thead style="position: sticky;top: 0px;">
                <tr style="background: #472380">
                    <th scope="col">Actividad</th>
                </tr>
            </thead>
            <tbody class="lista-Actividades">
              <?  foreach ($actividades as $ac): 
                      if ($ac->activo == 0) { ?>
                <tr class="filaActividad" name="actividades" data-value="<?=$ac->idActividad?>" data-name="<?=$ac->nombre?>" onclick="ClickActividad(this)">
                  <td><?=$ac->nombre?></td>
                </tr>
              <?    }
                  endforeach ?>
            </tbody>
        </table>
      </div>
      <div class="col-md-4 style-table" id="cont-Ramos">
        <table class="table table-hover" id="Ramos">
            <thead style="position: sticky;top: 0px;">
                <tr style="background: #5f3c97">
                    <th scope="col">Ramo</th>
                </tr>
            </thead>
            <tbody class="lista-Ramo"></tbody>
        </table>
      </div>
      <div class="col-md-4 style-table">
        <table class="table table-hover" id="SubRamos">
            <thead style="position: sticky;top: 0px;">
                <tr style="background: #74589f">
                    <th scope="col" class="checkbox-thead-center">SubRamo
                      <p class="number-subramos hidden" id="NumberSelect"></p>
                      <div class="checkbox-container hidden" id="check-cont">
                        <label class="container" id="checkbox-style" title="Seleccionar todos" style="width: 18px;height: 18px;padding-top: 2px;padding-left: 2px;margin-top: -5px;">
                          <input class="form-check-input checkbox-All" id="CheckAll" onclick="escogerCheckSubRamo()" type="checkbox" style="margin-top: 0px;">
                          <span class="checkmark" style="width:18px;height:18px;"></span>
                        </label>
                      </div>
                    </th>
                </tr>
            </thead>
            <tbody class="lista-SubRamo" name="lista-SubRamo">
            </tbody>
        </table>
      </div>
    </div>
      <div class="col-md-12 bg-table-permisos tab-pane" id="TablaTodosLosPermisos">
        <div class="col-md-12 style-table-permisos" id="view-table-permisos">
  </div>
            </div>
        </div>
    </div>
 <!-- Cierre de la pestaña divSubRamoCompania -->

<style type="text/css">
/* Estilos generales */
  .bg-permisos-content {
    overflow: auto;
    height: auto;
    /*margin-top: 10px;*/
    padding-bottom: 10px;
  }
  .bg-table {
    background: white;
    margin-bottom: 10px;
  }
  .bg-table-permisos {
    padding-left: 10px;
    padding-right: 10px;
    background: white;
    padding-top: 10px;
    display: flex;
    justify-content: center;
    margin-bottom: 0px;
    overflow: overlay;
  }
  .bg-tab-content {
    padding-left: 10px;
    padding-right: 10px;
    background: white;
    padding-top: 10px;
    display: flex;
    justify-content: center;
    margin-bottom: 0px;
    height: auto;
    box-shadow: 0px 2px 5px 1px #8370a1;
  }
  .bg-buttons {
    display: flex;
    justify-content: flex-end;
    margin-top: 0px;
    margin-bottom: 10px;
  }
  .style-table {
    padding-left: 0px;
    padding-right: 0px;
    overflow: auto;
    height: 250px;
  }
  .style-table-permisos {
    padding-left: 0px;
    padding-right: 0px;
    overflow: auto;
  }
  .linear {
    border-right: 1px solid #d9d8d8;
  }
  .seleccion1 {
    background: #f5efd0;
  }
  .seleccion2 {
    background: #a2d4d9;
  }
  .container-spinner-table-situacion {
    text-align: center;
    margin: 10px;
    color: #266093;height: 220px;
    align-items: center;
    display: flex;
    justify-content: center;
    flex-direction: column;
  }
  .border-light {
    border-right: 1px solid #e9e9e9;
  }
  .border-table {
    border-right: 1px solid darkgray;
  }
  .checkbox-center {
    display: flex;
    align-items: center;
  }
  .checkbox-item {
    width: 20px;
    height: 20px;
    position: inherit;
  }
  .title-checkbox {
    padding-left: 5px;
    width: 153px;
  }
  .checkbox-All {
    width: 15px;
    height: 15px;
    position: inherit;
  }
  .checkbox-thead-center {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .checkbox-container{
    width: 20px;
    height: 20px;
    background: #9b7ccb;
    border-radius: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .btn-General {
    border-radius: 5px;
    padding: 10px;
    color: white;
    margin-left: 10px;
  }
  .btn-Guardar {
    background-color: #266093;
    border-color: #266093;
  }
  .btn-Guardar.disabled,
  .btn-Guardar[disabled],
  fieldset[disabled] .btn-Guardar,
  .btn-Guardar.disabled:hover,
  .btn-Guardar[disabled]:hover,
  fieldset[disabled] .btn-Guardar:hover,
  .btn-Guardar.disabled:focus,
  .btn-Guardar[disabled]:focus,
  fieldset[disabled] .btn-Guardar:focus,
  .btn-Guardar.disabled.focus,
  .btn-Guardar[disabled].focus,
  fieldset[disabled] .btn-Guardar.focus,
  .btn-Guardar.disabled:active,
  .btn-Guardar[disabled]:active,
  fieldset[disabled] .btn-Guardar:active,
  .btn-Guardar.disabled.active,
  .btn-Guardar[disabled].active,
  fieldset[disabled] .btn-Guardar.active {
    background-color: #266093;
    border-color: #266093;
  }
  .btn-Guardar:hover {
    background-color: #337ab7;
    border-color: #337ab7;
    color: white;
  }
  .btn-Quitar {
    background-color: #dfe4e9;
  }
  .btn-Quitar:hover {
    background-color: #ced4db;
  }
  .swal-modal {
    width: 28%;
  }
  .swal-button--confirm{
    background-color:#337ab7!important;
  }
  .swal-text{
    /*color:#472380 !important;*/
    font-size: 17px;
    text-align: center;
  }
  .title-modal {
    font-weight: 100;
    font-size: 15px;
  }
  .ActividadesActive {
    margin-bottom: 80px;
    height: 460px;
  }
  .ActividadesDisabled {
    margin-left: -60px;
    left: 10%;
    height: 400px;
  }
  .number-subramos {
    margin-bottom: 0px;
    margin-right: -230px;
  }

/* Checkbox Seleccionar Todos*/
  #checkbox-style input:checked ~ .checkmark {
  background-color: #9a9240; /*#337ab7, #0d6efd*/
  border-color: #9a9240;
  }
  .container {
    display: block;
    position: relative;
    cursor: pointer;
    width: 20px;
    height: 20px;
    margin-bottom: 0px;
    padding-top: 1px;
    padding-left: 1px;
    margin-top: -3px;
    margin-left: -1px;
  }
  /* Checkbox original oculto */
  .container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }
  /* Checkbox nuevo */
  .checkmark {
    display: flex;
    /* position: absolute; */
    /* top: 0px; */
    /* left: 0; */
    height: 20px;
    width: 20px;
    border-radius: 5px;
    border: 1px solid darkgray;
    background-color: #eee;
    margin-top: 0px;
  }
  .container:hover input ~ .checkmark {
    background-color: #efedd9;
  }
  /* Antes de seleccionar */
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }
  /* Después de seleccionar */
  .container input:checked ~ .checkmark:after {
    display: block;
  }
  
  /* Marcador del checkbox */
  .container .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }

/* Checkbox Bootstrap*/
  .form-check-input {
    width: 23px;
    height: 23px;
    margin-top: .25em;
    vertical-align: top;
    background-color: #fff;
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border: 1px solid rgba(0,0,0,.25);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-print-color-adjust: exact;
    color-adjust: exact;
    print-color-adjust: exact;
  }
  .form-check-input[type=checkbox] {
      border-radius: .5em;
      cursor: pointer;
  }
  .form-check .form-check-input {
      float: left;
      margin-left: -1.5em;
  }
  .form-check-input:active{
    filter:brightness(90%);
  }
  .form-check-input:focus{
    border-color:#86b7fe;
    outline:0;
    box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
  }
  .form-check-input:checked{
    background-color:#0d6efd;
    border-color:#0d6efd;
  }
  .form-check-input:checked[type=checkbox]{
    background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
  }
/* Tabular */
  #nav-tab-Permisos .nav-tabs > li > a:hover {
    background-color: #9a9240; /* #8370A1 */

  }
  #nav-tab-Permisos .nav-tab-link {
    cursor: pointer;
  }
  .nav-tabs > li.active > a,  .nav-tabs > li.active > a:focus {
    background-color: #5f3c97;
    color: white;
  }
</style>
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script type="text/javascript">
let ramoVarGlobal='';
let actividadVarGlobal='';
let operativosPermisosTodosVarGlobal='';
    document.getElementById('CheckAll').addEventListener('click',function(){
      let check=document.getElementsByName('CheckSubRamo');
      if(this.checked)
      {
        for(let i of check)
        {
          i.checked=true;
        }
      }
      else
      {
                  for(let i of check)
        {
          i.checked=false;
        }

      }
    })

    $(document).ready(function() {
      const btn = document.getElementsByName('btn-Pestania');
      const radio = document.getElementsByName('CheckSubRamo');
      const active = document.getElementsByClassName('Active');
      const tab = document.getElementsByClassName('nav-tab-link')[0];
      const baseUrl = $("#base_url").data("base-url");
      var srAll = document.getElementById('CheckAll');
      var cc = document.getElementById('check-cont');

    //Cambio del estilo del divContiene para la adaptación de ventana
      $('#btn-SubRamoCompania').click(function() {
        $('.divContiene').addClass('ActividadesActive');
        $('.divContiene').removeClass('ActividadesDisabled');
      })

      $(btn).click(function() {
        $('.divContiene').addClass('ActividadesDisabled');
        $('.divContiene').removeClass('ActividadesActive');
      })

    // Checkbox Seleccionar Todos
      srAll.addEventListener('click',function() {
        if (srAll.checked) {
          $(radio).prop('checked',true);
          $(radio).addClass('save');
          $(active).addClass('ON');
          $(active).removeClass('OFF');
          $(active).removeClass('save');
          cc.style.background = "#512e87"; //#9b7ccb
          const count = $(radio).filter(':checked');
          let number = count.length;
          $('#NumberSelect').removeClass('hidden');
          $('#NumberSelect').text("("+number+")");
          console.log("Todas las casillas seleccionadas");
        }
        else {
          $(radio).prop('checked',false);
          $(active).removeClass('ON');
          $(active).addClass('OFF');
          cc.style.background = "#9b7ccb"; //#512e87
          $('#NumberSelect').addClass('hidden');
          console.log("Ninguna seleccionada");
        }
      })    
    })

  //Carga de Permisos por Operativo
    function buscarPermisos() {
      $('#PermisosOperativos').removeClass('hidden');
      $('#nav-tab-Permisos').removeClass('hidden');
      $('#nav-panel-Permisos').removeClass('hidden');
      VerPermisosConcedidos();
      var operativo = document.getElementById('selectOperativos').value;
      let lect = document.getElementById('SubRamos');
      let tag = lect.getElementsByTagName('input');
      const radio = document.getElementsByName('CheckSubRamo');
      const areaCheck = document.getElementsByName('CheckArea');
      const active = document.getElementsByClassName('Active');
      const baseUrl = $("#base_url").data("base-url");

      $('#BotonPermiso').removeClass('hidden');
      $('#CheckAll').prop('checked',false);
      $('#NumberSelect').addClass('hidden');
      $(radio).prop('checked',false);
      $(radio).removeClass('Active');
      $(radio).removeClass('ON');
      $(radio).removeClass('OFF');
      $(radio).addClass('save');
      $(areaCheck).prop('checked',false);
      $(areaCheck).removeClass('Active');

      const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}permisosOperativos/GetPermisoOperativo`,
        data: { 
          //si: activo,
          cr: operativo,
          ramo:ramoVarGlobal,
          actividad:actividadVarGlobal,
        },
        error: (error) => {
            console.log(error.resText);
        },
        success: (data) => {
            const res = JSON.parse(data);
            console.log(res);

            if (res != 0) {
              $('#AlertaInfo').addClass('hidden');
              $('#GuardarPermisos').removeClass('hidden');
              $('#EliminarPermisos').removeClass('hidden');
              //$(radio).prop('checked',false);
              for(var a in res) {

                if (document.getElementsByClassName('seleccion1')[0]) {
                  var actividad = document.getElementsByClassName('seleccion1')[0].dataset.name;
                  //console.log(actividad);
                  if (res[a].OpActividad == actividad) {
                    if (document.getElementsByClassName('seleccion2')[0]) {
                      var ramo = document.getElementsByClassName('seleccion2')[0].dataset.name;
                      //console.log(ramo);
                      if (res[a].OpRamo == ramo) {
                        if (res[a].correo == operativo) {   
                          $('input[name="CheckSubRamo"][data-value="'+res[a].OpSubRamo+'"]').removeClass('save');
                          $('input[name="CheckSubRamo"][data-value="'+res[a].OpSubRamo+'"]').addClass('Active');
                           $('input[name="CheckArea"][data-value="'+res[a].area+'"]').addClass('Active');

                        }
                        else {

                        }
                      }
                      else {
                      }
                    }
                  }
                  else {
                  }
                }
              }
            }
            else {
              $('#AlertaInfo').removeClass('hidden');
              $('#GuardarPermisos').removeClass('hidden');
              $('#EliminarPermisos').addClass('hidden');
              $(radio).prop('checked',false);
              $(radio).removeClass('Active');
              $(radio).addClass('save');
              $(areaCheck).prop('checked',false);
              $(areaCheck).removeClass('Active');
            }
            $(active).prop('checked',true);
            //console.log(active);
            if ($(radio).hasClass('Active')) {
              $(active).click(function() {
                var nombre = $(this).data('name');
                if (this.checked) {
                  $(this).prop('checked',true);
                  $(this).addClass('ON');
                  $(this).removeClass('OFF');
                  //console.log("Check Marcado - "+nombre+".");
                }
                else {
                  $(this).prop('checked',false);
                  $(this).addClass('OFF');
                  $(this).removeClass('ON');
                  //console.log("Check Sin Marcar - "+nombre+".");
                }
              })
            }
        }
      })
      $(radio).click(function() {
        const count = $(radio).filter(':checked');
        let number = count.length;
        let select = radio.length;
        //console.log(radio,count,number);
        if (number == 0) {
          $('#NumberSelect').addClass('hidden');
          $('#NumberSelect').text("("+number+")");
        }
        else {
          $('#NumberSelect').removeClass('hidden');
          $('#NumberSelect').text("("+number+")");
        }

        if (this.checked) {
          var title = this.dataset.name;
          //console.log("SubRamo "+title+" seleccionado");
        }
        else {
          $('#CheckAll').prop('checked',false);
          //console.log("No seleccionado");
        }

        if (number == select) {
          $('#CheckAll').prop('checked',true);
        }
      })
      
    }

  //Tabla Ramo
    function ClickActividad(activity) {
      actividadVarGlobal=activity.dataset.name;
      const id = $(activity).data('value');
      const actividad = $(activity).data('name');
      const baseUrl = $("#base_url").data("base-url");
       document.getElementsByName('lista-SubRamo')[0].innerHTML='';
      if(document.getElementsByClassName('seleccion1')[0]){
        document.getElementsByClassName('seleccion1')[0].classList.remove('seleccion1');
      }
      activity.classList.add('seleccion1');
      $('#cont-Actividades').addClass('linear');

      const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}permisosOperativos/GetRamos`,
        data: { 
          id: id
        },
        beforeSend: (load) => {
            $('.lista-Ramo').html(`
                <div class="container-spinner-table-situacion" id="loading-table-situacion">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
            `);
        },
        error: (error) => {
            console.log(error.resText);
        },
        success: (data) => {
            const res = JSON.parse(data);
            //console.log(res);
            $(".lista-Ramo").html("");
            var trtd = ``;

            for(var a in res) {
                trtd += `
                    <tr class="filaRamo" name="ramos" data-value="${res[a].idRamo}" data-name="${res[a].Nombre}" data-activity="${actividad}" onclick="ClickRamo(this)">
                        <td>${res[a].Nombre}</td>
                    </tr>`;
            }
            $(".lista-Ramo").html(trtd);
        }
      })
    }

  //Tabla SubRamo
    function ClickRamo(ramo) {
      ramoVarGlobal=ramo.dataset.name;
      var operativo = document.getElementById('selectOperativos').value;
      const id = $(ramo).data('value');
      const actividad = $(ramo).data('activity');
      const ramos = $(ramo).data('name');
      const baseUrl = $("#base_url").data("base-url");

      if(document.getElementsByClassName('seleccion2')[0]){
        document.getElementsByClassName('seleccion2')[0].classList.remove('seleccion2');
      }
      ramo.classList.add('seleccion2');
      $('#GuardarPermisos').prop('disabled',false);
      $('#cont-Ramos').addClass('linear');
      $('#check-cont').removeClass('hidden');
      $('#CheckAll').prop('checked',false);
      $('#NumberSelect').addClass('hidden');

      const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}permisosOperativos/GetSubRamos`,
        data: { 
          id: id,
          cr: operativo
        },
        beforeSend: (load) => {
            $('.lista-SubRamo').html(`
                <div class="container-spinner-table-situacion" id="loading-table-situacion">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
            `);
        },
        error: (error) => {
            console.log(error.resText);
        },
        success: (data) => {
            const res = JSON.parse(data);
            //console.log(res);
            $(".lista-SubRamo").html("");
            var trtd = ``;

            for(var a in res) {
                trtd += `
                    <tr class="filaSubRamo" name="subramos" data-id="${res[a].idSubRamo}">
                        <td>
                          <div class="checkbox-center" id="">
                              <input class="form-check-input checkbox-item save" name="CheckSubRamo" data-value="${res[a].idSubRamo}" data-name="${res[a].SNombre}" data-activity="${actividad}" data-ramo="${ramos}" type="checkbox" style="margin-top: -3px;">
                            <h6 class="title-checkbox">${res[a].SNombre}</h6>
                          </div>
                        </td>
                    </tr>`;
            }
            $(".lista-SubRamo").html(trtd);
            buscarPermisos();
        }
      })
    }

  //Guarda la información del radio seleccionado
    function GuardarPermisos() {
      var operativo = document.getElementById('selectOperativos').value;
      var actividad = document.getElementsByClassName('seleccion1')[0].dataset.name;
      var ramo = document.getElementsByClassName('seleccion2')[0].dataset.name;
      //var subramo = $(radio).filter(':checked')[0].dataset.value; //Value del radio seleccionado
      var Activo = document.getElementsByClassName('ON');
      var NoActivo = document.getElementsByClassName('OFF');
      const radio = document.getElementsByName('CheckSubRamo');
      const nuevo = document.getElementsByClassName('save');
      const check = $(nuevo).filter(':checked');
      const baseUrl = $("#base_url").data("base-url");
      const areaSelect = document.getElementsByName('CheckArea');

      //Encuentra los valores de los checkbox seleccionados
      var insertar = new Array();
      /*$(check).each(function(element) {
        let select = {};
        select = this.dataset.value;
        insertar.push(select);
      })*/
      //console.log(insertar);
      //var valores = JSON.stringify(array);
      var eliminar = new Array();
      /*$(NoActivo).each(function(element) {
        let off = {};
        off = this.dataset.value;
        eliminar.push(off);
      })*/
       for(let r of radio)
       {
        if(r.checked){insertar.push(r.dataset.value)}
        else{eliminar.push(r.dataset.value)}
        }

        var area = new Array();
        var eliminarArea = new Array();
        for(let a of areaSelect)
       {

        if(a.checked){area.push(a.dataset.value)}
        else{eliminarArea.push(a.dataset.value)}
        }

      //console.log(eliminar);
      /*console.log("Correo: "+operativo+", Actividad: "+actividad+", Ramo: "+ramo+", SubRamo: (Poner permiso: "+insertar+"), (Quitar permiso: "+eliminar+").");*/

      //if (insertar != 0 || eliminar != 0) {
      swal({
            title: "¿Desea guardar?",
            text: "Los cambios se guardarán.",
          icon: "warning",
          buttons: ["Cancelar", "Aceptar"],
      }).then((value) => {
        if (value) {
          $.ajax({
              type: "POST",
                url: `${baseUrl}permisosOperativos/OperacionesPermisos`,
              data: {
                cr: operativo,
                ac: actividad,
                rm: ramo,
                  in: insertar,
                  dl: eliminar,
                  area: area,
                  dlarea: eliminarArea 
              },
              success: (data) => {
                    swal("¡Guardado!", "Cambios realizados con éxito.", "success");
                    //window.location.reload();
                    buscarPermisos();
                    VerPermisosConcedidos();
              },
              error: (error) => {
                    swal("¡Uups!", "Ocurrió un error al realizar la acción.", "error");
              }
            })
        }
      })
    /*}
      else {
        swal("¡Espera!", "No se ha realizado ningún cambio.", "warning");
      }*/
    }

  //Elimina todos los Permisos que se encuentren relacionados con el Operativo
    function EliminarPermisos() {
      var operativo = document.getElementById('selectOperativos').value;
      const baseUrl = $("#base_url").data("base-url");

      swal({
          title: "¿Desea eliminar todos los permisos?",
          text: "Todos los permisos activados se eliminarán.",
          icon: "warning",
          buttons: ["Cancelar", "Aceptar"],
      }).then((value) => {
        if (value) {
          $.ajax({
              type: "POST",
              url: `${baseUrl}permisosOperativos/EliminarPermisosOperativo`,
              data: {
                cr: operativo
              },
              success: (data) => {
                  swal("¡Eliminados!", "Todos los permisos fueron eliminados.", "success");
                  //window.location.reload();
                  buscarPermisos();
                  VerPermisosConcedidos();
              },
              error: (error) => {
                  swal("¡Vaya!", "Ocurrió un problema al eliminar los permisos.", "error");
              }
          }) 
        }
      })
    }

  //Muestra todos los Permisos relacionados con el Operativo en el modal
    function VerPermisosConcedidos() {
      const baseUrl = $("#base_url").data("base-url");
       
      const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}permisosOperativos/ConsultarPermisos`,
        beforeSend: (load) => {
            $('#view-table-permisos').html(`
                <div class="container-spinner-table-situacion" id="loading-table-situacion">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                    <p style="font-size:18px;">Cargando...</p>
                </div>
            `);
        },
        error: (error) => {
            console.log(error.resText);
        },
        success: (data) => {
            const r = JSON.parse(data);
            operativosPermisosTodosVarGlobal=r;
            $(".list-table-permisos-body").html("");
            var trtd = ``;

            if (r != 0) {
            $('#view-table-permisos').html(`
                  <div class="col-md-12 column-flex-center" style="padding: 0px 15px 5px 15px;"><input type="text" class="form-control" id="filtroTodosInput" placeholder="AGREGUE TEXTO PARA FILTRAR" style="width:25%;"><label id="cantidadRegistrosFiltrados" class="label label-info"></label></div>
                <table class="table table-striped table-permisos-s" id="table-permisos-operativos">
                    <thead style="opacity:.9;">
                        <tr>
                            <th scope="col">Actividad</th>
                            <th scope="col">Ramo</th>
                              <th scope="col" style="width: 100px;">SubRamo</th>                              
                              <th scope="col">Correo</th>
                              <th scope="col">&Aacute;rea</th>
                        </tr>
                    </thead>
                    <tbody class="list-table-permisos-body">
                    </tbody>
                </table>
            `);
              
              document.getElementById('filtroTodosInput').addEventListener('change',function(){
                let r=operativosPermisosTodosVarGlobal;
                let text=document.getElementById('filtroTodosInput').value;
                text=text.toUpperCase();
                  let tr='';
                  let cantidad=0;
                  for(var a in r) {
                    let cad=r[a].actividad+r[a].ramo+r[a].Nombre+r[a].area+' '+r[a].email;
                  
                    cad=cad.toUpperCase();
                    if(cad.includes(text))
                    {cantidad++;
                    tr += `
                    <tr>
                        <td>${r[a].actividad}</td>
                        <td>${r[a].ramo}</td>
                        <td>${r[a].Nombre}</td>                        
                        <td>${r[a].area}</td>
                    </tr>`;
                      
                    }
                  }
                              $(".list-table-permisos-body").html("");
                              $(".list-table-permisos-body").html(tr);
                              document.getElementById('cantidadRegistrosFiltrados').innerHTML=cantidad+' CONCIDENCIAS';

              })
            }
            else {
                $('#view-table-permisos').html(`
                    <div class="col-md-12" id="info-table-none" style="justify-content: center;margin-top: 20px;display: flex;
    margin-bottom: 20px;">
                        <h4 class="titulo-secciones">Sin ningún permiso registrado.</h4>
                    </div>
                `);
            }
            let cant=0;
            for(var a in r) {
              var area="";
              if(r[a].area==null){
                          area="No tiene área asignada";
                        }else{
                          if(r[a].area=="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM"){
                            //area=r[a].area;
                            area="INSTITUCIONAL"
                          }
                          if(r[a].area=="COORDINADOR@CAPCAPITAL.COM.MX"){
                            //area=r[a].area;
                            area="M&Eacute;RIDA"
                          }
                          if(r[a].area=="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"){
                            //area=r[a].area;
                            area="CANCUN"
                          }
                          if(r[a].area=="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){
                            //area=r[a].area;
                            area="FIANZAS"
                          }
                          
                        }
              cant++;
                trtd += `
                    <tr>
                        <td>${r[a].actividad}</td>
                        <td>${r[a].ramo}</td>
                        <td>${r[a].Nombre}</td>                        
                        <td>${r[a].email}</td>
                        <td>${area}</td>
                    </tr>`;
            }
             document.getElementById('cantidadRegistrosFiltrados').innerHTML=cant+' CONCIDENCIAS';
            $(".list-table-permisos-body").html(trtd);

            /*$('#table-permisos-operativos').DataTable({
                language: {
                    url: `${baseUrl}assets/js/espanol.json`
                },
                columns:[
                {
                    sortable: true,
                    orderable: true,
                },
                {
                    sortable: true,
                    orderable: true,
                },
                {
                    sortable: true,
                    orderable: true,
                },
                {
                    sortable: true,
                    orderable: true,
                },
                {
                    sortable: false,
                    orderable: false,
                }],
                order: [['0', 'desc']],
            });*/
        }
      })
    }

  //Elimina cada fila de la tabla del modal
    function EliminarPermisoFila(fila) {
      var operativo = document.getElementById('selectOperativos').value;
      var actividad = $(fila).data('activity');
      var ramo = $(fila).data('ramo');
      var subramo = $(fila).data('subramo');
      console.log(actividad,ramo,subramo);
      const baseUrl = $("#base_url").data("base-url");
      swal({
          title: "¿Desea eliminarlo?",
          text: "La información de la fila se borrará por completo.",
          icon: "warning",
          buttons: ["Cancelar", "Aceptar"],
      }).then((value) => {
        if (value) {
          $.ajax({
              type: 'POST',
              url: `${baseUrl}permisosOperativos/BorrarPermisoOperativo`,
              data: {
                  cr: operativo,
                  ac: actividad,
                  rm: ramo,
                  sr: subramo
              },
              success: (data) => {
                swal("¡Permiso Eliminado!", "El permiso fue borrado.", "success");
                //window.location.reload();
                buscarPermisos();
                VerPermisosConcedidos();
              },
              error: (error) => {
                  swal("¡Uups!", "Ha ocurrido un problema al tratar de eliminar.", "error");
              }
          })
        }
      })
    }

  //Carga los Operativos en el Select
    <?
      function imprimirOperativos($datos){
        $option="<option>SELECCIONAR</option>";  
        foreach ($datos as $key1 => $value1) {
          if ($value1['Name'] == "Operativo") {
            $option.='<optgroup label="'.$value1['Name'].'">';
            foreach ($value1['Data'] as $key => $value) {
              $nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
              $option.='<option value="'.$value['email'].'" data-id="'.$value['idPersona'].'" data-name="'.$nombres.'" data-type="permisosOperativos">'.$nombres.' <label>     ('.$value['email'].')</label></option>';  
            }
            $option.='</optgroup>';
          }
        }
        return $option;
      }
    ?>
  </script>