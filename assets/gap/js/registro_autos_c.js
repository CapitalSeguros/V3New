$(document).ready(function () {
  var isOut=true;
  $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;opacity:0.4;filter: alpha(opacity = 50)"></div>');
  var data2;
  var init = 0;
  const $path = $("#base_url").attr("data-base-url");

  $(document).on("input", ".numeric", function () {
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
  });


  window.fomatValue = function (value) {
    var valorI = $("#valor_unidad").val();
    var ValF = isNaN(value) ? valorI : value;
    console.log("valoralmc", ValF);
    ValF.indexOf(',') > -1 ? $("#valor_unidad").val(ValF) : $("#valor_unidad").val((+ValF).toLocaleString("es-MX"));
    //$("#valor_unidad").val(ValF);
    var percent = parseFloat(ValF.replace(",", "")) * 0.20;
    $("#deducible").val(isNaN(percent) ? '0' : (+percent.toFixed(2)).toLocaleString("es-MX"));
    //return (value).toLocaleString();
  }

  $(document).on("change", "#afectado", function () {
    var res = $("#afectado").val();
    var opt = '';
    res == "RESPONSABLE" ? opt = 'NO' : opt = '';
    $("#tipo_recuperacion").val(opt);
    console.log(res);
  });


  const validate = parseInt($("#validate").val());

  //console.log('validate',validate);
  $("#form_gmm").validate({
    rules: {
      vehiculo: {
        required: true,
      },
      serie: {
        required: true,
      },
      lugar: {
        required: true,
      },
      economico: {
        required: true,
      },
      modelo: {
        required: true,
      },
      estatus_deducible: {
        required: true,
      },
      tipo_recuperacion: {
        required: true,
      },
      importe_reserva: {
        required: true,
      },
      //Nuevos
      cliente_siniestro: {
        required: validate === 1 ? true : false,
      },
      numero_siniestro: {
        //required: validate == 1 ? true : false,
        required: false,
      },
      certificado: {
        required: validate == 1 ? true : false,
      },
      tipo_siniestro: {
        required: validate == 1 ? true : false,
      },
      causa: {
        required: validate == 1 ? true : false,
      },
      estado: {
        required: validate == 1 ? true : false,
      },
      autoridad_presente: {
        required: validate == 1 ? true : false,
      },
      tipo_autoridad: {
        required: validate == 1 ? true : false,
      },
      tipo_ajustador: {
        required: validate == 1 ? true : false,
      },
      numero_poliza: {
        required: validate == 1 ? true : false,
      },
      Certificado: {
        required: validate == 1 ? true : false,
      },
      Paquete: {
        required: validate == 1 ? true : false,
      },
      nombres: {
        required: validate === 1 ? true : false,
      },
      fecha_aviso: {
        required: validate == 1 ? true : false,
      },
      num_cabina: {
        required: validate == 1 ? true : false,
      },
      afectado: {
        required: validate == 1 ? true : false,
      },
      fecha_ocurrencia: {
        required: validate == 1 ? true : false,
      },
      //Nuevos
      ano:{
        required: validate == 1 ? true : false,
      },
      marca:{
        required: validate == 1 ? true : false,
      },
      nuestro_asegurado:{
        required: validate == 1 ? true : false,
      }


    },
    messages: {
      vehiculo: {
        required: "ingrese un valor.",
      },
      serie: {
        required: "ingrese un valor.",
      },
      lugar: {
        required: "ingrese un valor.",
      },
      afectado: {
        required: "ingrese un valor.",
      },
      economico: {
        required: "ingrese un valor.",
      },
      modelo: {
        required: "ingrese un valor.",
      },
      /*  valor_unidad:{
          required:"ingrese un valor.",
       },
       deducible:{
          required:"ingrese un valor.",
       }, */
      estatus_deducible: {
        required: "ingrese un valor.",
      },
      tipo_recuperacion: {
        required: "ingrese un valor.",
      },
      importe_reserva: {
        required: "ingrese un valor.",
      },
      //Nuevos
      cliente_siniestro: {
        required: "ingrese un valor.",
      },
      numero_siniestro: {
        required: "ingrese una número de siniestro.",
      },
      certificado: {
        required: "ingrese un valor.",
      },
      tipo_siniestro: {
        required: "Seleccione un tipo de siniestro.",
      },
      causa: {
        required: "Seleccione una causa.",
      },
      estado: {
        required: "Seleccione un estado.",
      },
      autoridad_presente: {
        required: "Seleccione un valor.",
      },
      tipo_autoridad: {
        required: "Seleccione un tipo de autoridad.",
      },
      tipo_ajustador: {
        required: "Seleccione un tipo de ajustador.",
      },
      numero_poliza: {
        required: "ingrese un valor.",
      },
      Certificado: {
        required: "ingrese un valor.",
      },
      Paquete: {
        required: "ingrese un valor.",
      },
      nombres: {
        required: "ingrese un nombre.",
      },
      fecha_aviso: {
        required: "ingrese una fecha",
      },
      num_cabina: {
        required: "ingrese un número.",
      },
      fecha_ocurrencia: {
        required: "Ingrese una fecha",
      },
      //Nuevos
      ano:{
        required: "Ingrese un Año",
      },
      marca:{
        required: "Ingrese una Marca",
      },
      nuestro_asegurado:{
        required: "Seleccione uno",
      }


    },
    errorPlacement: function (error, element) {
      if (error) {
        $(`#e_${element[0].id}`).append(error);
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      //alert('paso' + validate);
      $.ajax({
        url: form.action,
        type: form.method,
        data: $(form).serialize(),
        success: function (response) {
          if (response.code == 200) {
            isOut=false;
            toastr.success("Se guardo con éxito.");
            window.location.replace($path + 'Siniestros/registros');
          } else {
            toastr.error(response.message);
          }

        }
      });
    }
  });

  //metodo que valida que se haya guardado correctamente sin salir de la pantalla

  window.addEventListener('beforeunload', function (e) {
      if(isOut){
        e.preventDefault();
        e.returnValue = '';
      }
  });


  ///Nuevos metodos que sirven para la parte de la implementacion manual
  window.Causas = function (id, selected) {
    //console.log('text',id+' '+selected)
    var opt = '<option value="">Seleccione uno</option>';
    const newData = _Causa.filter((item, index) => item.tipo_siniestro_id === id);
    newData.forEach((element, key) => {
      opt += `<option value="${element.id}" ${selected == element.id ? 'selected' : ''}>${element.nombre}</option>`;
    });
    $("#causa").html('');
    $("#causa").html(opt);
  }

  $(document).on('change', '#tipo_siniestro', function (e) {
    var id = e.currentTarget.value;
    Causas(id, '');
  });


  //metodos para la busqueda de las polizas
  window.seachPoliza = async function () {

    if (init == 0) {
      //console.log('inint');
      init++;
      await loadTable();
      //$("#modal_tipos").modal('show');
    } else {
      //console.log('destroy');
      data2.destroy();
      await loadTable();
      //$("#modal_tipos").modal('show');
    }

  }

  //carga de la tabla
  window.loadTable = function () {
    $('body').append(`<div id="upProgressModal" style="display:none;" role="status" aria-hidden="true">
        <div id="nprogress" class="nprogress">
            <div class="spinner">
                <div class="spinner-icon"></div>
                <div class="spinner-icon-bg"></div>
            </div>
            <div class="overlay"></div>
        </div>
    </div>`);
    document.getElementById("over").style.display = "block";
    document.getElementById("upProgressModal").style.display = "block";
    var dta = {
      'nombres': $('#nombres_m').val(),
      'apellido_p': $('#apellido_p_m').val(),
      'apellido_m': $('#apellido_m_m').val(),
      'num_poliza_m': $('#num_poliza_m').val(),
      'moral': $('#moral').is(":checked")
    };
    const datatable = $('#example').DataTable({
      language: {
        url: `${$path}assets/js/espanol.json`
      },
      ajax: {
        url: `${$path}Autos/getPolizas`,
        type: 'POST',
        data: dta,
        dataSrc: function (datainfo) {
          //console.log('dta',datainfo.data.TableInfo);
          var dt = datainfo.data.TableInfo;
          if (dt.length) {
            //console.log('arreglo');
            $("#modal_tipos").modal('show');
            document.getElementById("over").style.display = "none";
            document.getElementById("upProgressModal").style.display = "none";
            return datainfo.data.TableInfo;
            //console.log('arreglo');
          }
          else {
            console.log('no arreglo', datainfo.data.TableInfo);
            var arry = [];
            if (datainfo.data.TableInfo.IDDocto) {
              //console.log('solo');
              arry.push(datainfo.data.TableInfo);
            }
            document.getElementById("over").style.display = "none";
            document.getElementById("upProgressModal").style.display = "none";
            $("#modal_tipos").modal('show');
            return arry;
            //return datainfo.data.TableInfo;
            //console.log('no arreglo');
          }
          //return datainfo.data.TableInfo;
          //$("#modal_tipos").modal('show');
        }
      },
      //paging:false,
      //scrollY:"300px",
      //sScrollX:"overflow:hidden",
      //scrollCollapse:true,.
      drawCallback: function () {
        $('#modal_tipos').modal('handleUpdate');
      },
      pageLength: 5,
      searching: false,
      info: false,
      columns: [
        {
          data: 'Documento',
          visible: false,
        },
        {
          data: 'CiaNombre',
          visible: false,
        },
        {
          data: 'Status_TXT',
          visible: false,
        },
        {
          data: null,
          render: function (data, type, row) {
            var date = new Date(row.FDesde);
            var dateF = new Date(row.FHasta);
            return `
                    <div class="row">
                        <div class="col-md-12">
                            <div style="cursor:pointer;">
                                <div>
                                    <h5><strong>Asegurado: ${row.NombreCompleto}</strong></h5>
                                    <div class="Siniestro-body">
                           <div class="box first">Folio: ${row.Documento}</div>
                           <div class="box first" style="padding-left: 15px;"> Aseguradora: ${row.CiaNombre}</div>
                                        <div class="box first" style="padding-left: 15px;"> Vigencia: ${moment(date).format("DD/MM/YYYY")} a ${moment(dateF).format("DD/MM/YYYY")}</div>
                                        <div class="box first" style="padding-left: 15px;"> Estatus: ${row.Status_TXT}</div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>`
          }
        }
      ],
    });
    data2 = datatable;
    $('#modal_tipos').modal('handleUpdate');
    return true;
  }

  //evento cuandos se selecciona un registro de la tabla
  $.fn.dataTable.ext.errMode = 'none';
  $('#example').on('error.dt', function (e, settings, techNote, message) {
    document.getElementById("over").style.display = "none";
    document.getElementById("upProgressModal").style.display = "none";
    toastr.error("Servicio no disponible, intentelo de nuevo");
    //console.log( 'An error has been reported by DataTables: ', message );
  });

  //marcar una fila de la tabla //dblclick
  $('#example tbody').on('click', 'tr', function () {
    if ($(this).hasClass('selected')) {
      $(this).removeClass('selected');
    }
    else {
      data2.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      var selected = data2.row('.selected').data();
      resetPoliza();
      $("#json_poliza").val(JSON.stringify(selected));
      $("#idsicascliente").val(selected.IDCli);
      $("#fecha_fin").val(selected.FHasta);
      $("#aseguradora_id").val(selected.IDCia);
      $("#idsicasvendedor").val(selected.IDVend);
      $("#numero_poliza").val(selected.Documento);
      $("#tipo_poliza").val(selected.GerenciaNombre);
      $("#compania_seguros").val(selected.AgenteNombre);
      $("#estatus_poliza").val(selected.Status_TXT);
      $("#inciso").val(selected.certificado);
      $("#nombres").val(selected.NombreCompleto);
      $("#ejecutivo").val(selected.EjecutNombre);
      $("#grupo").val(selected.Grupo);
      $("#sub_grupo").val(selected.SubGrupo);
      $("#inciso_p").val(selected.Inciso.toString() == '[object Object]' ? '' : selected.Inciso);
      $("#sub_ramo").val(selected.SRamoNombre);
      $("#telefono_asegurado").val(selected.Telefono1);
      $("#correo_asegurado").val(selected.EMail1.toString() == '[object Object]' ? '' : selected.EMail1);
      var agente = '[' + selected.CAgente + '] ' + selected.AgenteNombre;
      $("#agente").val(agente);
    }
  });

  window.resetPoliza = function () {
    console.log('Reset de los campos');
    $("#numero_poliza").val('');
    $("#compania_seguros").val('');
    $("#estatus_poliza").val('');
    $("#inciso").val('');
    $("#nombres").val('');
    $("#tipo_poliza").val('');
    $("#ejecutivo").val('');
    $("#grupo").val('');
    $("#sub_grupo").val('');
    $("#inciso_p").val('');
    $("#sub_ramo").val('');
    $("#telefono_asegurado").val('');
    $("#correo_asegurado").val('');
    $("#agente").val('');
  }

  //evento que permite mostar los tipo de causas por tipo de siniestro
  $(document).on('change', '#tipo_siniestro', function (e) {
    var id = e.currentTarget.value;
    Causas(id, '');
  });

  $(document).on('click', '#open', function (e) {
    console.log('click modal');
    $('#modal_tipos').appendTo("body").modal('show');
  });


  ///opcion para la parte de la persona moral

  $(document).on('click', '#moral', function (e) {
    if ($(this).is(":checked")) {
      //alert('Activo moral');
      $("#apellido_p_m").prop('disabled', true);
      $("#apellido_m_m").prop('disabled', true);
    } else {
      //alert('No Activo moral');
      $("#apellido_p_m").prop('disabled', false);
      $("#apellido_m_m").prop('disabled', false);
    }
  });


});