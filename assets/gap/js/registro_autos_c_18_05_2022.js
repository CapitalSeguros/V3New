$(document).ready(function(){
  $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;opacity:0.4;filter: alpha(opacity = 50)"></div>');
  var data2;
  var init=0;
  const $path = $("#base_url").attr("data-base-url");

  $(document).on("input", ".numeric", function() {
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
  });


  window.fomatValue=function (value){
    var valorI=$("#valor_unidad").val();
    var ValF=isNaN(value)?valorI:value;
    console.log("valoralmc",ValF);
    ValF.indexOf(',')>-1?$("#valor_unidad").val(ValF):$("#valor_unidad").val((+ValF).toLocaleString("es-MX"));
    //$("#valor_unidad").val(ValF);
    var percent=parseFloat(ValF.replace(",",""))*0.20;
    $("#deducible").val(isNaN(percent)?'0':(+percent.toFixed(2)).toLocaleString("es-MX"));
    //return (value).toLocaleString();
  }

  $(document).on("change", "#afectado", function() {
      var res=$("#afectado").val();
      var opt='';
      res=="RESPONSABLE"?opt='NO':opt='';
      $("#tipo_recuperacion").val(opt);
      console.log(res);
  });



$("#form_gmm").validate({
  rules:{
    vehiculo:{
          required:true,
      },
    serie:{
          required:true,
      },
    lugar:{
          required:true,
      },
    economico:{
        required:true,
    },
    modelo:{
        required:true,
    },
    /* valor_unidad:{
        required:true,
    },
    deducible:{
      required:true,
    }, */
    estatus_deducible:{
      required:true,
    },
    tipo_recuperacion:{
      required:true,
    },
    importe_reserva:{
      required:true,
    },
     
  },
  messages: {
    vehiculo:{
        required:"ingrese un valor.",
      },
    serie:{
        required:"ingrese un valor.",
      },
    lugar:{
        required:"ingrese un valor.",
      },
    afectado:{
        required:"ingrese un valor.",
      },
    economico:{
      required:"ingrese un valor.",
    },
    modelo:{
      required:"ingrese un valor.",
    },
   /*  valor_unidad:{
       required:"ingrese un valor.",
    },
    deducible:{
       required:"ingrese un valor.",
    }, */
    estatus_deducible:{
       required:"ingrese un valor.",
    },
    tipo_recuperacion:{
       required:"ingrese un valor.",
    },
    importe_reserva:{
       required:"ingrese un valor.",
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
                window.location.replace($path+'Siniestros/registros');
              }else{
                toastr.error(response.message);
              }

          }            
      });
  }
});

});