<div class="panel panel-default" style="margin-bottom: 80px;">
  <div class="panel-body column-flex-center-center">
    <div class="col-md-2 pd-left pd-right" style="max-width: 143px;height: 560px;overflow: auto;">
      <div class="col-md-12 column-grid-center pd-left pd-right" id="btnEmployeeDepartment" style="background: #f7f7f7;height: 100%;">
      </div>
    </div>
    <div class="col-md-10 pd-left pd-right">
      <div class="col-md-12">
        <label class="subtitleSection">Encuesta:</label>  
        <select class="form-control width-ajust" id="selectTest"></select>
      </div>
      <div class="col-md-6 column-flex-center-start" style="padding: 5px 15px;margin-top: 10px;">
        <button class="btn btn-primary" id="btnAddTestEmployee" onclick="saveTestToEmployee()" disabled>
          Grabar Encuesta</button>
      </div>
      <div class="col-md-6 column-flex-center-end" style="padding: 5px 15px;margin-top: 10px;">
        <input type="text" class="form-control" placeholder="Filtrar" id="filterTableEmployee" style="width: 60%;">
      </div>
      <div class="col-md-12 pd-left pd-right" style="height: 450px;overflow: auto;margin-left: 15px;max-width: 98%;">
        <table class="table table-striped" id='tableAssign' style="height: 100%;margin: 0px;">
          <thead class="table-thead">
           <tr class="tr-style">
              <th>IDEMPLEADO</th>
              <th>EMPLEADO</th>
              <th>TIPO</th>
              <th>EMAIL</th>
              <th>DEPARTAMENTO</th>
              <th><input type="checkbox" class="form-check-input" id="selectAllEmployee" disabled></th>
           </tr>
          </thead>
          <tbody id="bodyTableAssign" style="font-size: 12px;"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  //------ Seccion 3: Asignar Encuestas ------
  $(document).ready(function() {
    getTestSelect();
    getBtnEmployee();

    $('#filterTableEmployee').keyup(function() {
      const val = $(this).val().toUpperCase();
      const body = "bodyTableAssign";
      const clase = "mostrar-employee";
      filterTable(val,body,clase);
    })

    $('#selectAllEmployee').click(function() {
      let check = document.getElementsByClassName('providerCheckbox');
      if (this.checked) {
        $('.providerCheckbox').prop('checked',true);
      }
      else {
        for (let i=0;i<check.length;i++) {
        if (check[i].checked && !check[i].disabled) {
          $('.providerCheckbox[value="'+check[i].value+'"]').prop('checked',false);
        }
      }
      }
      verifyBtnSave();
    })

    $('#selectTest').change(function() {
      const clase = $('.btnBotoneraActiva');
      if (clase.length != 0) {
        const val = document.getElementsByClassName('btnBotoneraActiva')[0].value;
        getTableAssign(val);
      }
    })
  })

  function getTestSelect() {
    $.ajax({
      url: `<?=base_url()?>encuesta/encuestasActivas`,
      beforeSend: (load) => {
        $('#btnTestView').html(`
          <div class="container-spinner-content-loading">
              <div class="cr-spinner spinner-border" role="status">
                  <span class="visually-hidden"></span>
              </div>
          </div>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        var trtd = ``;
        var button = ``;
        if (r != 0) {
          for (a in r) {
            trtd += `<option value="${r[a].idcabencuesta}">${r[a].descripcion}</option>`;
            button += `
              <button class="btn btnTest" value="${r[a].idcabencuesta}" onclick="selectedTest(this)">
                ${r[a].descripcion}
              </button>
            `;
          }
        }
        else {
          trtd = `<option value="0">NINGUNO</option>`;
        }
        $('#selectTest').html(trtd);
        $('#btnTestView').html(button);
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function getBtnEmployee() {
    $.ajax({
      url: `<?=base_url()?>asigna/getEmployeeDepartment`,
      beforeSend: (load) => {
        $('#btnEmployeeDepartment').html(`
          <div class="container-spinner-content-loading">
              <div class="cr-spinner spinner-border" role="status">
                  <span class="visually-hidden"></span>
              </div>
          </div>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        var trtd = ``;
          for (a in r) {
            trtd += `<button class="btnBotonera column-grid-center" value="${r[a].Name}" data-tipopersona="PERSONAL" onclick="devolverPersonas(this)"><i class="fas fa-user-tie fa-2x"></i>${r[a].Name}</button>`;
          }
          trtd += `
            <button class="btnBotonera column-grid-center" value="Clientes" data-tipopersona="CLIENTES" onclick="devolverPersonas(this)"><i class="fas fa-users fa-2x"></i>Clientes</button>
            <button class="btnBotonera column-grid-center" value="Clientes" data-tipopersona="CLIENTESBUSCADOS" id="btnEncuestasAlternas" onclick="insertaEncuestasAlternas(this)"><i class="fas fa-pen-square fa-2x"></i>Encuestas Alternas</button>`;
        $('#btnEmployeeDepartment').css('height','');
        $('#btnEmployeeDepartment').html(trtd);
        $('button[data-tipopersona="PERSONAL"][value="BRONCE"]').trigger('click');
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function getTableAssign(val) {
    const test = document.getElementById('selectTest').value;
    //console.log(val, test);
    $.ajax({
      type: "POST",
      url: `<?=base_url()?>asigna/GetPersonas`,
      data: { 
        strvalor: val,
        test: test
      },
      beforeSend: (load) => {
        $('#bodyTableAssign').html(`
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
        var trtd = ``;
        var check = "";
        if (r != 0) {
          for (a in r) {
            if (r[a].test != 0) {
              check = "checked disabled";
            }
            else {
              check = "";
            }
            trtd += `
              <tr class="mostrar-employee">
                <td>${r[a].idPersona}</td>
                <td>${r[a].nombres}</td>
                <td>${r[a].TIPO}</td>
                <td>${r[a].EMail1}</td>
                <td>${r[a].clasificacion}</td>
                <td>
                  <input type='checkbox' class='form-check-input providerCheckbox' value="${r[a].idPersona}" onclick="verifyBtnSave(this)" ${check}>
                </td>
              </tr>
            `;
          }
          $('#selectAllEmployee').prop('disabled',false);
        }
        else {
          trtd = `<tr><td colspan="6"><center><strong>Sin resultados</strong><center></td></tr>`;
          $('#selectAllEmployee').prop('disabled',true);
        }
        $('#bodyTableAssign').html(trtd);
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function saveTestToEmployee() {
    const check = document.getElementsByClassName('providerCheckbox');
    const active = document.getElementsByClassName('btnBotoneraActiva')[0].value;
    const test = document.getElementById('selectTest').value;
    var user = 0;
    let checkbox = [];
    for (let i=0;i<check.length;i++) {
      if (check[i].checked && !check[i].disabled) {
        checkbox.push(check[i].value);
      }
    }
    if (active == "Clientes") {
      user = 4;
    }
    //console.log(active, test, checkbox);
    $.ajax({
      type: "POST",
      url: `<?=base_url()?>asigna/GrabaCabEncuesta`,
      data: {
        array: JSON.stringify(checkbox),
        usuario: user,
        cabEncuesta: test
      },
      beforeSend: (load) => {
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        if (r['status'] == "success") {
          swal("¡Guardado!", "Encuesta asignadas a empleados.", "success");
          getTableAssign(active);
          <?php //if($permission==1){?>
          getInfoTestComplete();
          <? //} ?>
        }
      },
      error: (error) => {
        console.log(error);
        swal("¡Uups!", "Se encontró conflicto al intentar guardar.", "error");
      }
    })
  }

  function verifyBtnSave() {
    let check = document.getElementsByClassName('providerCheckbox');
      var j = 0;
      for (let i=0;i<check.length;i++) {
        if (check[i].checked && !check[i].disabled) {
          j++;
        }
      }
      if (j >= 1) {
        $('#btnAddTestEmployee').prop('disabled',false);
      }
      else {
        $('#btnAddTestEmployee').prop('disabled',true);
      }
  }

  function devolverPersonas(objeto){
    $('#btnAddTestEmployee').prop('disabled',true);
    if(document.getElementsByClassName('btnBotoneraActiva')[0]){
      document.getElementsByClassName('btnBotoneraActiva')[0].classList.remove('btnBotoneraActiva');
    }
    objeto.classList.add('btnBotoneraActiva');
    cod = objeto.value;
    getTableAssign(cod);
    //combo = document.getElementById("empleados");
    //if(objeto.getAttribute('data-tipopersona')=='CLIENTES'){document.getElementById('hiddenUsuario').value=4;}
    //else{document.getElementById('hiddenUsuario').value=0;}          
    //selected = combo.options[combo.selectedIndex].text;
  }
</script>