$(document).ready(function(){
  $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
  var data2;
  var init=0;
  const $path = $("#base_url").attr("data-base-url");

  //valida los formatos de los numeros
  $(document).on("input", ".numeric", function() {
      this.value = this.value.replace(/\D/g,'');
  });


  $("#form_gmm").validate({
      rules:{
          fecha_aviso:{
              required:true,
          },
          numero_siniestro:{
              required:true,
          },
          estado:{
              required:true,
          },
          folio_cia:{
              required:true,
          },
          titular:{
              required:true,
          },
          parentesco:{
              required:true,
          },
          afectado:{
              required:true,
          },
          json_poliza:{
              required:true,
          },
          inciso_u:{
              required:true,
          }
      },
      messages: {
          fecha_aviso:{
              required:"ingrese una fecha.",
          },
          numero_siniestro:{
              required:"ingrese un numero de siniestro.",
          },
          estado:{
              required:"Seleccione un estado.",
          },
          folio_cia:{
              required:"ingrese un folio.",
          },
          titular:{
              required:"ingrese un titular.",
          },
          parentesco:{
              required:"Seleccione un parentesco.",
          },
          afectado:{
              required:"Ingrese un afectado.",
          },
          json_poliza:{
              required:"Realice la busqueda de una póliza.",
          },
          inciso_u:{
              required:"ingrese un inciso.",
          }
      },
      errorPlacement: function(error, element) {
          if (error) {
              $(`#e_${element[0].id}`).append(error);
          } else {
              error.insertAfter(element);
          }
      },
      submitHandler: function(form) {
        var today=moment().format("YYYY-MM-DD");
        var f_fin=$("#fecha_fin").val();
        var conmpare=moment(f_fin).format("YYYY-MM-DD");
        if(today>conmpare){
            toastr.error("La Póliza no tiene vigencia valida");
        }else{
            if($(`#json_poliza`).val()!=''){
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if(response.code==200){
                          toastr.success("Se guardo con éxito.");
                          window.location.replace($path+'GMM');
                        }else{
                          toastr.error(response.message);
                        }
                        //$('#answers').html(response);
                    }            
                });
            }else{
                toastr.error("Realice la busqueda de una póliza.");
            }
        }

      }
  });

  //buscar registros de polizas
  window.seachPoliza= async function (){
  
  if(init==0){
    //console.log('inint');
    init++;
    await loadTable();
    //$("#modal_tipos").modal('show');
  }else{
    //console.log('destroy');
    data2.destroy();
    await loadTable();
    //$("#modal_tipos").modal('show');
  }
  $('#modal_tipos').modal('handleUpdate'); 
}

window.loadTable= function(){
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
  var dta={
          'nombres':$('#nombres_m').val(),
          'apellido_p':$('#apellido_p_m').val(),
          'apellido_m':$('#apellido_m_m').val(),
          'num_poliza_m':$('#num_poliza_m').val(),
          'moral':$('#moral').is(":checked")
  };
    const datatable = $('#example').DataTable({
      language: {
        url: `${$path}assets/js/espanol.json`
      },
      ajax: {
        url: `${$path}GMM/getPolizas`,
        type: 'POST',
        data:dta,
        dataSrc: function (datainfo) {
          //console.log('dta',datainfo.data.TableInfo);
          var dt=datainfo.data.TableInfo;
          if(dt.length){
                          //console.log('arreglo');
                          $("#modal_tipos").modal('show');
                          document.getElementById("over").style.display = "none"; 
                          document.getElementById("upProgressModal").style.display = "none";
            return datainfo.data.TableInfo;
            //console.log('arreglo');
                      }
                      else{
                          console.log('no arreglo',datainfo.data.TableInfo);
            var arry=[];
                          if(datainfo.data.TableInfo.IDDocto){
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
      drawCallback:function(){
        $('#modal_tipos').modal('handleUpdate'); 
      },
      pageLength:5,
      searching:false,
      info:false,
      columns: [
        {
          data: 'Documento',
          visible:false,
        },
        {
          data: 'CiaNombre',
          visible:false,
        },
        {
          data: 'Status_TXT',
          visible:false,
        },
        {
          data:null,
          render: function(data, type, row) {
              var date=new Date(row.FDesde);
              var dateF=new Date(row.FHasta);
                      return `
                  <div class="row">
                      <div class="col-md-12">
                          <div  style="cursor:pointer;">
                              <div class="media-body">
                                  <h5 class="media-heading"><strong>Asegurado: ${row.NombreCompleto}</strong></h5>
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
    data2= datatable;
    return true;
}
  $.fn.dataTable.ext.errMode = 'none';
  $('#example').on( 'error.dt', function ( e, settings, techNote, message ) {
          document.getElementById("over").style.display = "none"; 
          document.getElementById("upProgressModal").style.display = "none";
    toastr.error("Servicio no disponible, intentelo de nuevo");
    //console.log( 'An error has been reported by DataTables: ', message );
  } ) ;

  //marcar una fila de la tabla //dblclick
  $('#example tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
          $(this).removeClass('selected');
      }
      else {
          data2.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
          var selected=data2.row('.selected').data();
          $("#json_poliza").val(JSON.stringify(selected));
          $("#idsicascliente").val(selected.IDCli);
          $("#idsicasvendedor").val(selected.IDVend);
          $("#fecha_fin").val(selected.FHasta);
          $("#aseguradora_id").val(selected.IDCia);
          resetPoliza();
          $("#numero_poliza").val(selected.Documento);
          $("#compania_seguros").val(selected.CiaNombre);
          $("#estatus_poliza").val(selected.Status_TXT);
          $("#inciso").val(selected.certificado);
          $("#nombres").val(selected.NombreCompleto);
          $("#tipo_poliza").val(selected.GerenciaNombre);
          $("#ejecutivo").val(selected.EjecutNombre);
          $("#grupo").val(selected.Grupo);
          $("#sub_grupo").val(selected.SubGrupo);
          if(selected.Inciso){
              $("#inciso_p").val(selected.Inciso.toString()=='[object Object]'?'':selected.Inciso);
          }
          $("#sub_ramo").val(selected.SRamoNombre);
          $("#telefono_asegurado").val(selected.Telefono1);
          $("#correo_asegurado").val(selected.EMail1.toString()=='[object Object]'?'':selected.EMail1);
          var agente='['+selected.CAgente+'] '+selected.AgenteNombre;
          $("#agente").val(agente);
    //$("#modal_tipos").modal('hide');
      }
  });

  window.resetPoliza=function (){
          //console.log('Reset de los campos');
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

  $(document).on('click', '#open', function(e) {
    console.log('click modal');
    $('#modal_tipos').appendTo("body").modal('show');
});

  ///opcion para la parte de la persona moral

  $(document).on('click', '#moral', function(e) {
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