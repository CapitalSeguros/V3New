//Parte 1
  //Calendario del FORM
    $( function(){
      $( "#1fNacimiento" ).datepicker({          
            dateFormat: 'yy-mm-dd',});
      } 
    );

    $(function () {
      $(".fecha").datepicker({
          closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
          monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
          dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
          dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
          dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
          dateFormat: 'dd/mm/yy',
          firstDay: 1,       
      });
    });

  //Comentado debido a la ya no se encuentra en ninguna clase del archivo listafacturas.php
    /*function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) {
        var tbl = document.getElementById(gridId);
        if (tbl) {
            var DivHR = document.getElementById('DivHeaderRow');
            var DivMC = document.getElementById('DivMainContent');
            var DivFR = document.getElementById('DivFooterRow');
            //*** Set divheaderRow Properties ****
            DivHR.style.height = headerHeight + 'px';
            DivHR.style.width = (parseInt(width) - 16) + 'px';
            DivHR.style.position = 'relative';
            DivHR.style.top = '0px';
            DivHR.style.zIndex = '10';
            DivHR.style.verticalAlign = 'top';
            //*** Set divMainContent Properties ****
            DivMC.style.width = width + 'px';
            DivMC.style.height = height + 'px';
            DivMC.style.position = 'relative';
            DivMC.style.top = -headerHeight + 'px';
            DivMC.style.zIndex = '1';
            //*** Set divFooterRow Properties ****
            DivFR.style.width = (parseInt(width) - 16) + 'px';
            DivFR.style.position = 'relative';
            DivFR.style.top = -headerHeight + 'px';
            DivFR.style.verticalAlign = 'top';
            DivFR.style.paddingtop = '2px';

            if (isFooter) {
            var tblfr = tbl.cloneNode(true);
                tblfr.removeChild(tblfr.getElementsByTagName('tbody')[0]);
                var tblBody = document.createElement('tbody');
                tblfr.style.width = '100%';
                tblfr.cellSpacing = "0";
                //*****In the case of Footer Row *******
                tblBody.appendChild(tbl.rows[tbl.rows.length - 1]);
                tblfr.appendChild(tblBody);
                DivFR.appendChild(tblfr);
            }
            //****Copy Header in divHeaderRow****
            DivHR.appendChild(tbl.cloneNode(true));
        }
    }*/

    //function OnScrollDiv(Scrollablediv) {
    //    document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
    //    document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
    //}

    /*window.onload = function() {
        MakeStaticHeader('Mitabla', 350, 1750, 40, false);
    }*/

  //Función Tarjetas
    function traerFormasPagos(datos) {
      if(datos=='') {
        let params='';
        //params=params+'comentario='+document.getElementById('comentarioParaAN').value;   
        controlador="contabilidad/traerFormasPagos/?";
        peticionAJAX(controlador,params,'traerFormasPagos');   
        //cerrarModal('divModalGenerico');
      }
      else {
        let cant=datos.tarjetas.length;
        let option='<option value="0">TARJETAS ASIGNADAS</option>';
        for(let i=0;i<cant;i++) {
          if(datos.tarjetas[i].esTarjetaEspecial==1) {
            option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'" data-especial="'+datos.tarjetas[i].esTarjetaEspecial+'">'+datos.tarjetas[i].numeroTarjeta+'</option>';
          }
          else{
              option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'" data-especial="'+datos.tarjetas[i].esTarjetaEspecial+'">'+datos.tarjetas[i].numeroTarjeta+'('+datos.tarjetas[i].formaPago+')</option>';
            }
        }
        //document.getElementById('selectFormasPago').innerHTML=option;
        document.getElementById('selectTarjetasCredito').innerHTML=option;
        //inicializaNotas();
        //document.getElementById('notasCargoFianzas').setAttribute('disabled','true');
        //document.getElementById('notasCargoSeguros').setAttribute('disabled','true');
        //document.getElementById('notasCargoCoorporativos').setAttribute('disabled','true');
        //document.getElementById('notasCargoEspeciales').setAttribute('disabled','true');
        //pintarTablaNotas(datos.notas,'tbodyNotas',0);
      }
    }

  //Cálculos de los montos del FORM
    function Suma(){
        var sumita;
        var CargoFianzas= document.getElementById("CargoFianzas").value 
        var CargoInst= document.getElementById("CargoInst").value 
        var CargoGes= document.getElementById("CargoGes").value 
        //var CargoPromMer= document.getElementById("CargoPromMer").value 
        //var CargoPromCan= document.getElementById("CargoPromCan").value 
        var Corporativos= document.getElementById("Corporativos").value
        //sumita=Number(CargoFianzas)+Number(CargoInst)+Number(CargoGes)+Number(CargoPromMer)+Number(CargoPromCan)+Number(Corporativos);
        sumita=Number(CargoFianzas)+Number(CargoInst)+Number(Corporativos)+Number(CargoGes);
        document.getElementById("CargoTotal").value = sumita;
        document.getElementById("CargoTotalconIVA").value = sumita;
    }

    /*function CalculaIVA(){
        var sumita2;
        var iva;
        var Cargototal= document.getElementById("CargoTotal").value 
        sumita2=Number(Cargototal)*(1.16);
        iva=Number(Cargototal)*(0.16);
        document.getElementById("iva").value = iva;
        document.getElementById("CargoTotalconIVA").value = sumita2;
    }*/

    function quitarListaParaFacturar(objeto) {
    	let row=objeto.parentNode.parentNode;
    	let index=row.rowIndex;
    	let fianzas=row.getAttribute('data-fianzas');
    	let seguros=row.getAttribute('data-seguros');
    	let coorporativo=row.getAttribute('data-coorporativo');
    	let especial=row.getAttribute('data-especial');
    	let monto=row.getAttribute('data-monto');

  		document.getElementById('CargoFianzas').value=parseFloat(document.getElementById('CargoFianzas').value)-parseFloat(fianzas);
  		document.getElementById('CargoInst').value=parseFloat(document.getElementById('CargoInst').value)-parseFloat(seguros);
  		document.getElementById('Corporativos').value=parseFloat(document.getElementById('Corporativos').value)-parseFloat(coorporativo);
		  document.getElementById('CargoGes').value=parseFloat(document.getElementById('CargoGes').value)-parseFloat(especial);
		  document.getElementById('CargoTotal').value=parseFloat(document.getElementById('CargoTotal').value)-parseFloat(monto);
  		document.getElementById('tableConNotasParaFacturar').deleteRow(index);
    }

  //Notas
    function cambiarFormPago(objeto) {
  		let index=objeto.selectedIndex;
  		let especial=objeto.options[index].getAttribute('data-especial');
  		if(especial==0) {
    		document.getElementById('notasCargoFianzas').removeAttribute('disabled');
    		document.getElementById('notasCargoSeguros').removeAttribute('disabled');
    		document.getElementById('notasCargoCoorporativos').removeAttribute('disabled');
    		document.getElementById('notasCargoEspeciales').setAttribute('disabled','true');
  		}
  		else {
    		document.getElementById('notasCargoFianzas').setAttribute('disabled','true');
    		document.getElementById('notasCargoSeguros').setAttribute('disabled','true');
    		document.getElementById('notasCargoCoorporativos').setAttribute('disabled','true');
    		document.getElementById('notasCargoEspeciales').removeAttribute('disabled');
  		}
  		inicializaNotas();
    }

  //Modals del FORM
    function cierraModalfecha() {
  		$(".modalProveedoor").fadeOut();
    }

    function cierraModalgasto() {
  		$(".modalGastos").fadeOut();
    }

  //Ejecución modal Gastos Especiales
    function llamagastoEspecial(e){
        //console.log(e.target);
        if(e.target.classList.value=='fas fa-plus-circle'){
          //console.log('hiciste clic');
          $(".modalGastos").fadeIn();
        }
    }

  //Modal Gastos Especiales
    function enviaCargos(e){
        e.preventDefault();
        let gastoCCC= document.querySelector("#gastosCcc").value;
        let gastoCCo=document.querySelector("#gastosCco").value;
        let gastoCCInst=document.querySelector("#gastosInst").value;
        let gastoEstrategia=document.querySelector("#gastosEstrategia").value;
     
        $('#ccc').val(gastoCCC);
        $('#cco').val(gastoCCo);
        $('#inversion').val(gastoCCInst);
        $('#estrategia').val(gastoEstrategia);
        if(gastoCCC==""){
          gastoCCC=0.0;
        }
        if(gastoCCo==""){
          gastoCCC=0.0;
        }
        if(gastoCCInst==""){
          gastoCCC=0.0;
        }
        if(gastoEstrategia==""){
          gastoEstrategia=0.0;
        }
  
        $(".modalGastos").fadeOut();
        let total = parseFloat(gastoCCC)+ parseFloat(gastoCCo) + parseFloat(gastoCCInst)+parseFloat(gastoEstrategia);
        $('#CargoGes').val(total);
        Suma();
    }

  //Panel Cargos Especiales
    /*$("#formreferidos").submit(function(e){
      e.preventDefault();
      //buscamos resultados del proveedor
      let proveedor = document.querySelector('provee').value;
      console.log(proveedor);
    }*/

  //Calculos matemáticos
    function calcularMontoDisponible() {
        var combo = document.getElementById("idCuentaContable");
        var selected = combo.options[combo.selectedIndex];    
        document.getElementById('montoMesLabel').innerHTML='$'+selected.getAttribute('data-montomes');
        document.getElementById('montoMesAutorizadoLabel').innerHTML='$'+selected.getAttribute('data-autorizadomes');
        document.getElementById('montoDisponibleLabel').innerHTML='$'+(parseFloat(selected.getAttribute('data-montomes'))-parseFloat(selected.getAttribute('data-autorizadomes'))).toFixed(2); 
    }

    function calculaPagoDeCanal() {
        let subtotal=document.getElementById('CargoTotal');
        let select=document.getElementById('idCuentaContable');
        let option= select.options[select.selectedIndex];
        if(subtotal.value>0) {
          let fianzas=option.getAttribute('data-fianzasporcentaje');
          let institucional=option.getAttribute('data-institucionalPorcentaje');
          let coorporativo=option.getAttribute('data-coorporativoPorcentaje');
          let gestion=option.getAttribute('data-gestionPorcentaje');
          document.getElementById('spanCargoFianzas').innerHTML=fianzas+'%';
          document.getElementById('spanCargoSeguros').innerHTML=institucional+'%';
          document.getElementById('spanCargoCoorporativo').innerHTML=coorporativo+'%';
          document.getElementById('spanCargoEspeciales').innerHTML=gestion+'%';
          if(fianzas>0){
            document.getElementById('CargoFianzas').value=(fianzas*subtotal.value)/100;
          }
          else{
            document.getElementById('CargoFianzas').value='0.00';
          }
          if(institucional>0){
            document.getElementById('CargoInst').value=(institucional*subtotal.value)/100;
          }
          else{
            document.getElementById('CargoInst').value='0.00';
          }
          if(coorporativo>0){
            document.getElementById('Corporativos').value=(coorporativo*subtotal.value)/100;
          }
          else{
            document.getElementById('Corporativos').value='0.00';
          }
          if(gestion>0){
            document.getElementById('CargoGes').value=(gestion*subtotal.value)/100;
          }
          else{
            document.getElementById('CargoGes').value='0.00';
          }
          document.getElementById('CargoTotalconIVA').value=subtotal.value;
        }
        calcularMontoDisponible()
    }

  //Selección de una fila de la Tabla
  	function escogerRow(objeto) {
   		if(document.getElementsByClassName('rowSeleccionado')[0]){
   			document.getElementsByClassName('rowSeleccionado')[0].classList.remove('rowSeleccionado');
   		}
      // else {
      //   objeto.classList.add('rowSeleccionado');
      // }
      objeto.classList.add('rowSeleccionado');
    }


  /*	$(document).on('click','tr',function(){
  		if($(this).hasClass('rowSeleccionado')) {
         	$(this).removeClass('rowSeleccionado');
      	}
      	else {
      	    $(this).addClass('rowSeleccionado');
      	}
  	});*/

    // $(document).ready(function(){
    //   const seleccionada = document.getElementsByName('FilaSelect');
    //   if ($(seleccionada).hasClass('rowSeleccionado')) {
    //     $('#LimpiarFila').prop('disabled', false);
    //   }
    //   else {
    //     $('#LimpiarFila').prop('disabled', true);
    //   }
    // });

  //Quitar color de selección de la fila de la Tabla Facturas
    /*$('#LimpiarFila').click(function() {
      const filaSelect = document.getElementsByClassName('rowSeleccionado');
      if($(filaSelect).hasClass('rowSeleccionado')) {
        $(filaSelect).removeClass('rowSeleccionado');
      }
    });*/

  //Borrar los datos de los campos del formulario
    // $('#LimpiarCampos').click(function() {
    //   var sucursal = document.getElementById('IngMen');
    //   var tarjeta = document.getElementById('selectTarjetasCredito');
    //   var proveedor = document.getElementById('provee');
    //   var cuentaCont = document.getElementById('idCuentaContable');
    //   var formaPago = document.getElementById('selectMetodoDePago');
    //   var folio = document.getElementById('folio');
    //   var fecha = document.getElementById('1fNacimiento');
    //   var concepto = document.getElementById('concepto');
    //   var subtotal = document.getElementById('CargoTotal');
    //   var carFianzas = document.getElementById('CargoFianzas');
    //   var carSeguros = document.getElementById('CargoInst');
    //   var carCorp = document.getElementById('Corporativos');
    //   var carEsp = document.getElementById('CargoGes');
    //   var gasto = document.getElementById('tipoGasto');
    //   var total = document.getElementById('CargoTotalconIVA');

    //   $(sucursal).val('');
    //   $(tarjeta).val('0');
    //   $(proveedor).val('');
    //   $(cuentaCont).val('');
    //   $(formaPago).val('');
    //   $(folio).val('');
    //   $(fecha).val('');
    //   $(concepto).val('');
    //   $(subtotal).val('0.00');
    //   $(carFianzas).val('0.00');
    //   $(carSeguros).val('0.00');
    //   $(carCorp).val('0.00');
    //   $(carEsp).val('0.00');
    //   $(gasto).val('1');
    //   $(total).val('');

    // });


  //Mostrar Paneles ocultos | Acciones Adicionales, Panel de Información
    // $(document).ready(function(){
    //   var FilaAcciones = document.getElementsByName('AccionesTabla');
    //   var ConPanelInfo = document.getElementsByName('PanelInfo');
    //   var AlertPanInfo = document.getElementById('AlertaInfo');
    //   var SecPanelInfo = document.getElementById('SeccionIconInfo');
    //   $('#AccionesAdicionales').click(function() {
    //     $(FilaAcciones).toggle(500, "easeInOutQuint");
    //   });

    //   $('#icon-CloseInfo').click(function() {
    //     $(AlertPanInfo).toggle(500, "easeInOutCubic");
    //   });

    //   $('#MostrarPanelInfo').click(function() {
    //     $(AlertPanInfo).toggle(500, "easeInCubic");
    //   });
    // });

  //Abrir nueva pestaña del navegador
    function nuevaVentana(e,objeto){
      e.preventDefault();
      window.open(objeto.getAttribute('href'));
    }

//Funciones del FORM

//Funciones de la Tabla Facturas
  const baseUrl = $("#base_url").data("base-url");
  //Almacenar documento PDF de la factura | PENDIENTE: mensaje de guardado
    // function enviaArchivo(){
    //   $(function(){
    //     $("#formuploadajax").on("submit", function(e){
    //       e.preventDefault();
    //       var f = $(this);
    //       var formData = new FormData(document.getElementById("formuploadajax"));
    //       console.log("Leyendo la información");
    //       $.ajax({
    //           url:`${baseUrl}presupuestos/GuardarArchivo`,
    //           type: "post",
    //           dataType: "html",
    //           data: formData,
    //           cache: false,
    //           contentType: false,
    //           processData: false,
    //           success: function(response) {
    //             if(response.code==200){
    //               //toastr.success("Se guardo con éxito.");
    //               swal("¡Guardado!", "El documento se subió correctamente.", "success");
    //               window.location.reload();
    //             }
    //             else {
    //               swal("¡Error!", "Ha ocurrido un problema al tratar de guardar el documento.", "error");
    //             }
    //           },
    //           error: function() { 
    //             swal("¡Error!", "Ha ocurrido un problema al tratar de guardar el documento.", "error");
    //           }
    //       })
    //       //.done(function(res){
    //       //swal("Good job!", "You clicked the button!", "success");
    //       //  $("#mensaje").html("Respuesta: " + res);
    //       //})
    //     })
    //   })
    // }

    // $('#formArchivo').on('submit', function() {
    //     swal("¡Guardado!", "La informaciónse guardó.", "success");
    // });

  //Cambio de aspecto del botón "Agregar (PDF o XML)" a "Descargar"
    function cambiaForm(objeto){
        //document.getElementById("miModal").classList.remove("modalCierra");
        //document.getElementById("miModal").classList.add("modalAbre");
        //document.getElementById("Modalcontenido").style.display="block";
        var formData = new FormData(objeto);
        $.ajax({
            url:`${baseUrl}presupuestos/GuardarArchivo`,
            type: "post",dataType: "html",data: formData,cache: false,
            contentType: false,processData: false,
            success : function(datat) {
                console.log(datat);
                var j=JSON.parse(datat);   
                if(j.status==0){             
                    var cadena='<select><option value="'+j.ruta+'"">';
                    cadena=cadena+'Descargar</option><option value="'+j.archivo+'"">';
                    cadena=cadena+'Eliminar</option></select><button onclick="opcionesArchivo(this)">OK</button>';  
                    objeto.parentNode.innerHTML=cadena;
                }
                else {
                    alert(j.mensaje);        
                    for(var i=0; i<objeto.childNodes.length;i++){
                        if(objeto.childNodes[i].nodeName=="INPUT"){
                            if(objeto.childNodes[i].type=="file"){
                                objeto.childNodes[i].value="";
                            }
                        }
                    }
                }
                document.getElementById("miModal").classList.add("modalCierra");
                document.getElementById("miModal").classList.remove("modalAbre");
                document.getElementById("Modalcontenido").style.display="none";
            }
        })
    }

  //Alerta Eliminar fila de Tabla Facturas
    /*window.alertEliminar = function(id) {
      var fila = id;
      console.log(fila);
      swal({
          title: "¿Desea eliminarlo?",
          text: "La información del Id "+fila+" se borrará por completo.",
          icon: "warning",
          buttons: ["Cancelar", "Aceptar"],
      }).then((value) => {
          if (value) {
              $.ajax({
                  type: 'POST',
                  url: `${baseUrl}/presupuestos/borrar_factura`,
                  data: {
                      id: id,
                  },
                  success: function (data) {
                      console.log(data);
                      //toastr.success("Accion realizada con éxito.");
                      swal("¡Eliminado!", "Se eliminó correctamente. La página se recargará en breve.", "success");
                      window.location.reload();
                  },
                  error: function (data) {
                      swal("¡No eliminado!", "Ocurrió un error al borrar la información.", "error");
                  }
              });
          }
      });
    }*/

  //Eliminar Factura de la Tabla
    function eliminarFactura(datos='') {
      if(datos=='') {
        if(document.getElementsByClassName('rowSeleccionado')[0]) {
          var fila = document.getElementsByClassName('rowSeleccionado')[0].dataset.idfactura;
          swal({
              title: "¿Desea borrarlo?",
              text: "Los datos de "+fila+" se eliminarán.",
              icon: "warning",
              buttons: ["Cancelar", "Aceptar"],
          }).then((value) => {
            if (value) {    
              params="id="+fila;        
              controlador="presupuestos/eliminarFactura/?";     
              peticionAJAX(controlador,params,'eliminarFactura');
            }
          });
        }
        else{
          swal({
            title: "¡Por favor!",
            text: "Seleccione factura para eliminar.",
            icon: "warning",
            button: "OK",
          });
          //alert('SELECCIONE UNA FACTURA PARA ELIMINAR')
        }
      }
      else {
        if(!datos.status){
          alert(datos.mensaje)
        }
        else {
          //let direccion='<?=base_url()?>presupuestos/Vistafacturas';
          //window.location.replace(direccion);
          //toastr.success("Se eliminó con éxito.");
          swal("¡Eliminado!", "La fila se borró correctamente. La página se recargará en breve.", "success");
          window.location.reload();
        }
      }
    }

//Notas | Funciones no trabajando en el apartado de Facturas
//Botones ocultos sobre Notas
  function traerNotasDePersonas(datos) {
      if(datos=='') {
        let params=''; {
            let facturar=document.getElementsByName('checkParaFacturar');
            let cant=facturar.length;
        }
        params=params+'idPersona='+document.getElementById('selectPersonasConNotas').value;
        controlador="contabilidad/traerNotasDePersonas/?";
        peticionAJAX(controlador,params,'traerNotasDePersonas');   
      }
      else {
        pintarTablaNotas(datos.notas,'tbodyNotasPersona',1);
        console.log(datos)
      }
  }

  function buscarPersonasConNotas(datos) {
      if(datos=="") {
        let params='';
        controlador="contabilidad/buscarPersonasConNotas/";
        document.getElementById('tbodyNotasPersona').innerHTML='';
        peticionAJAX(controlador,params,'buscarPersonasConNotas');   
        cerrarModal('divModalParaFacturar');
      }
      else{
        dibujaSelectPersonasConNotas(datos.personasConNotas);
      }
  }

  function dibujaSelectPersonasConNotas(datos) {
    let option='';
    let cant=datos.length;
    for(let i=0;i<cant;i++) {
        option=option+'<option value="'+datos[i].idPersona+'">'+datos[i].apellidoPaterno+' '+datos[i].apellidoMaterno+' '+datos[i].nombres+'</option>';
    }
    document.getElementById('selectPersonasConNotas').innerHTML=option;
  }

  function borrarNotas(datos,idNota=null) {
      if(datos=='') {
        let params='';
        params=params+'idNotasCompra='+idNota;
        controlador="contabilidad/borrarNotas/?";
        peticionAJAX(controlador,params,'borrarNotas');
      }
      else {
        alert(datos.mensaje);
        pintarTablaNotas(datos.notas,'tbodyNotas',0);
      }
  }

  function guardarNota(datos) {
    if(datos=='') {
        let params='';
        params=params+'idFormaPago='+document.getElementById('selectFormasPago').value;
        params=params+'&notasDescripcion='+document.getElementById('notasDescripcio').value;
        params=params+'&notasCargoFianzas='+document.getElementById('notasCargoFianzas').value;
        params=params+'&notasCargoEspeciales='+document.getElementById('notasCargoEspeciales').value;
        params=params+'&notasTotal='+document.getElementById('notasTotal').value;
        params=params+'&notasCargoCoorporativos='+document.getElementById('notasCargoCoorporativos').value;
        params=params+'&fechaNota='+document.getElementById('fechaNota').value;
        params=params+'&notasCargoSeguros='+document.getElementById('notasCargoSeguros').value;
        controlador="contabilidad/guardarNota/?";
        peticionAJAX(controlador,params,'guardarNota');   
    }
    else {
        alert(datos.mensaje);
        pintarTablaNotas(datos.notas,'tbodyNotas',0); 
        inicializaNotas();
    }
  }

  function pintarTablaNotas(notas,tabla,paraFacturar=null) {
    let cant=notas.length;
    let row='';
      let cargoFianzas=0;
      let cargoSeguros=0;
      let cargoCoorporativo=0;
      let cargoEspecial=0;
      let monto=0;
    for(let i=0;i<cant;i++) {
        cargoFianzas=parseFloat(cargoFianzas)+parseFloat(notas[i].cargoFianzas);
        cargoSeguros=parseFloat(cargoSeguros)+parseFloat(notas[i].cargoSeguros);
        cargoCoorporativo=parseFloat(cargoCoorporativo)+parseFloat(notas[i].cargoCoorporativo);
        cargoEspecial=parseFloat(cargoEspecial)+parseFloat(notas[i].cargoEspecial);
        monto=parseFloat(monto)+parseFloat(notas[i].montoCompra);
        row=row+'<tr data-fianzas="'+notas[i].cargoFianzas+'" data-seguros="'+notas[i].cargoSeguros+'" data-coorporativo="'+notas[i].cargoCoorporativo+'" data-especial="'+notas[i].cargoEspecial+'" data-monto="'+notas[i].montoCompra+'" data-idnotascompra="'+notas[i].idNotasCompra+'">';
        row=row+'<td>'+notas[i].formaPago+'</td>';
        row=row+'<td>'+notas[i].numeroTarjeta+'</td>';
        row=row+'<td>'+notas[i].descripcionCompras+'</td>';
        row=row+'<td>'+notas[i].soloFecha+'</td>';  
        row=row+'<td>'+notas[i].cargoFianzas+'</td>';
        row=row+'<td>'+notas[i].cargoSeguros+'</td>';
        row=row+'<td>'+notas[i].cargoCoorporativo+'</td>';
        row=row+'<td>'+notas[i].cargoEspecial+'</td>';
        row=row+'<td>'+notas[i].montoCompra+'</td>';
        if(paraFacturar==1){row=row+'<td><input type="checkbox" value="'+notas[i].idNotasCompra+'" name="checkParaFacturar" checked></td>';}    
        else{row=row+'<td><button onclick="borrarNotas(\'\','+notas[i].idNotasCompra+')" class="btn btn-danger">X</button></td>';}
        row=row+'</tr>'
    }
      row=row+'<tr>';
      row=row+'<td>Totales</td>';
      row=row+'<td></td>';
      row=row+'<td></td>';
      row=row+'<td></td>';  
      row=row+'<td>'+cargoFianzas+'</td>';
      row=row+'<td>'+cargoSeguros+'</td>';
      row=row+'<td>'+cargoCoorporativo+'</td>';
      row=row+'<td>'+cargoEspecial+'</td>';
      row=row+'<td>'+monto+'</td>';
      row=row+'<td></td>';
      row=row+'</tr>'

    document.getElementById(tabla).innerHTML=row;
  }

  function inicializaNotas() {
      document.getElementById('notasCargoFianzas').value=0;
      document.getElementById('notasCargoEspeciales').value=0;
      document.getElementById('notasTotal').value=0;
      document.getElementById('notasCargoSeguros').value=0;
      document.getElementById('notasCargoCoorporativos').value=0;
  }

  function cerrarModal(modal) {
      document.getElementById(modal).classList.toggle('modalCierra');
      document.getElementById(modal).classList.toggle('modalAbre');   
  }
//------------------------------
//Funciones de los Forms ocultos
  function llevarNotasParaFacturar() {
      document.getElementById('divContieneNotasParaFacturar').innerHTML='';

      let facturar=document.getElementsByName('checkParaFacturar');
      let cant=facturar.length;
      let rowTabla='<table class="table" id="tableConNotasParaFacturar">';
      let fianzasTotal=0;
      let segurosTotal=0;
      let coorporativoTotal=0;
      let especialTotal=0;
      let montoTotal=0;
      for(let i=0;i<cant;i++) {
        if(facturar[i].checked) {
            let fianzas=facturar[i].parentNode.parentNode.getAttribute('data-fianzas');
            let seguros=facturar[i].parentNode.parentNode.getAttribute('data-seguros');
            let coorporativo=facturar[i].parentNode.parentNode.getAttribute('data-coorporativo');
            let especial=facturar[i].parentNode.parentNode.getAttribute('data-especial');
            let monto=facturar[i].parentNode.parentNode.getAttribute('data-monto');
            let id=facturar[i].parentNode.parentNode.getAttribute('data-idnotascompra');

            rowTabla=rowTabla+'<tr data-fianzas="'+fianzas+'" data-seguros="'+seguros+'" data-coorporativo="'+coorporativo+'" data-especial="'+especial+'" data-monto="'+monto+'" data-idnotascompra="'+id+'">'+facturar[i].parentNode.parentNode.innerHTML+'</tr>';
            fianzasTotal=parseFloat(fianzasTotal)+parseFloat(fianzas);
            segurosTotal=parseFloat(segurosTotal)+parseFloat(seguros);
            coorporativoTotal=parseFloat(coorporativoTotal)+parseFloat(coorporativo);
            especialTotal=parseFloat(especialTotal)+parseFloat(especial);
            montoTotal=parseFloat(montoTotal)+parseFloat(monto);
        }
      }
      rowTabla=rowTabla+'</table>';

      document.getElementById('divContieneNotasParaFacturar').innerHTML=rowTabla;  
      document.getElementById('CargoFianzas').value=fianzasTotal;
      document.getElementById('CargoInst').value=segurosTotal;
      document.getElementById('Corporativos').value=coorporativoTotal;
      document.getElementById('CargoGes').value=especialTotal;
      document.getElementById('CargoTotal').value=montoTotal;
      console.log(document.getElementById('tableConNotasParaFacturar').rows[0].cells[9].innerHTML);

      let cantNotas=document.getElementById('tableConNotasParaFacturar').rows.length;
      for(let i=0;i<cantNotas;i++) {
        document.getElementById('tableConNotasParaFacturar').rows[i].cells[9].innerHTML='<button class="btn btn-danger" onclick="quitarListaParaFacturar(this)">X</button>';
      }
    cerrarModal('divModalParaFacturar');
  }
//---------------------------------
