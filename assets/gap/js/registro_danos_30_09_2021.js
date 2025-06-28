$(document).ready(function(){
    $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
    var data2;
    var init=0;
    const $path = $("#base_url").attr("data-base-url");

    //opciones del select 
    window.Riesgos=function(tipo,selected){
        var opt='<option value="">Seleccione uno</option>';
        const newData = _Coberturas.filter((item, index) => item.tipo_c === tipo);
        newData.forEach((element,key)=>{
            opt+=`<option value="${element.id}" ${selected==element.id?'selected':''}>${element.nombre}</option>`;
        });
        $("#cobertura_id").html('');
        $("#cobertura_id").html(opt);
    }


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
            numero_reporte:{
                required:true,
            },
            estado:{
                required:true,
            },
            persona_reporta:{
                required:true,
            },
            numero_reporta:{
                required:true,
            },
            descripcion_afectado:{
                required:true,
            },
            cobertura_id:{
                required:true,
            },
            concepto:{
                required:true,
            },
            direccion:{
                required:true,
            },
            inciso_a:{
                required:true,
            }
        },
        messages: {
            fecha_aviso:{
                required:"Ingrese una fecha",
            },
            numero_siniestro:{
                required:"Ingrese un número de siniestro.",
            },
            numero_reporte:{
                required:"Ingrese un número de reporte.",
            },
            estado:{
                required:"Seleccione un estado.",
            },
            persona_reporta:{
                required:"Ingrese la persona que reporta",
            },
            numero_reporta:{
                required:"Ingrese el numero de la persona que lo reporta",
            },
            descripcion_afectado:{
                required:"Ingrese la descripción.",
            },
            cobertura_id:{
                required:"Seleccione un riesgo.",
            },
            concepto:{
                required:"Ingrese un concepto.",
            },
            direccion:{
                required:"Ingrese una dirección.",
            },
            inciso_a:{
                required:"Ingrese un inciso.",
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
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.code==200){
                        toastr.success("Se guardo con éxito.");
                        window.location.replace($path+'Danos');
                      }else{
                        toastr.error(response.message);
                      }
                    /* toastr.success("Se guardo con éxito.");
                    window.location.replace($path+'Danos'); */
                }            
            });
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
    }

    //carga de la tabla
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
                    $("#modal_tipos").modal('show');
                    document.getElementById("over").style.display = "none"; 
                    document.getElementById("upProgressModal").style.display = "none";
                    return datainfo.data.TableInfo;
                }
                else{
                    var arry=[];
                    if(datainfo.data.TableInfo.IDDocto){
                        arry.push(datainfo.data.TableInfo);
                    }
                    document.getElementById("over").style.display = "none"; 
                    document.getElementById("upProgressModal").style.display = "none";
                    $("#modal_tipos").modal('show');
                    return arry;
                }
            }
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
                                <div style="cursor:pointer;">
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
  
  //evento cuandos se selecciona un registro de la tabla
$.fn.dataTable.ext.errMode = 'none';
  $('#example').on( 'error.dt', function ( e, settings, techNote, message ) {
          document.getElementById("over").style.display = "none"; 
          document.getElementById("upProgressModal").style.display = "none";
    toastr.error("Servicio no disponible, intentelo de nuevo");
    //console.log( 'An error has been reported by DataTables: ', message );
}) ;

  //marcar una fila de la tabla //dblclick
  $('#example tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
          $(this).removeClass('selected');
      }
      else {
          data2.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
          var selected=data2.row('.selected').data();
          resetPoliza();
              console.log("json",JSON.stringify(selected))
              $("#json_poliza").val(JSON.stringify(selected));
              $("#idsicascliente").val(selected.IDCli);
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
              $("#inciso_p").val(selected.Inciso.toString()=='[object Object]'?'':selected.Inciso);
              $("#sub_ramo").val(selected.SRamoNombre);
              $("#telefono_asegurado").val(selected.Telefono1);
              $("#correo_asegurado").val(selected.EMail1.toString()=='[object Object]'?'':selected.EMail1);
              var agente='['+selected.CAgente+'] '+selected.AgenteNombre;
              $("#agente").val(agente);
      }
  });

  window.resetPoliza=function (){
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

  $(document).on("input", "#tipo_c", function(e) {
      var tipo=e.currentTarget.value;
      Riesgos(tipo,'');
  });

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
