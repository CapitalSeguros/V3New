<?php
    $busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
	$this->load->view('headers/header'); 
	$this->load->view('headers/menu');
?>

<?  foreach ($detallefactura->result() as $dato) { ?>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Editar Factura</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7"></div>
    </div>
    <hr /> 
</section>
<section class="container-fluid breadcrumb-formularios">
    <div class="col-md-12 hidden" style="display: flex;justify-content: center;align-items: center">
        <div class="col-md-8" style="margin-bottom: 30px;">
            <div class="alert alert-primary" role="alert" style="margin: 15px;text-align: center;">
                <i class="fa fa-info-circle" aria-hidden="true" style="font-size: 15px;"></i>
                <span style="font-size: 15px;">INFORMACIÓN</span>
                <p style="text-align: left;font-size: 14px;padding: 10px;">
                    - Debes ingresar el número de factura con su fecha correspondiente para guardar la información.<br>
                    - Una vez terminado de guardar la información se redireccionará a ALTA DE FACTURAS Y PAGOS CON TARJETAS.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-12" style="margin-bottom: 50px;text-align: left;">
        <div class="col-md-12" style="text-align: center; margin-top: 10px; margin-bottom: 10px;">
            <h4 style="margin-top: 0px;">MODIFICACIÓN DE LA FACTURA CON EL ID <strong><?=$dato->id?></strong></h4>
        </div>
        <form  class="form-style" role="formreferidos" id="actualizarFactura" name="actualizarFactura" method="post" action="<?=base_url()?>presupuestos/GuardaFacturaEditada/">
            <input type="text"  name="IDFact" id="IDFact" value="<?echo $dato->id?>" hidden="" > 
            <div class="col-md-12">
                <div class="col-sm-1 col-md-1"> 
                    <label class="titulo-form">Apertura</label>
                    <input type="text" class="form-control"  name="AperturaConta" id="AperturaConta" placeholder="Folio de Apertura"  required=""  disabled ="disable" value ="<?= $Apertura ?>">               
                </div> 
                    <div class="col-md-3">
                        <label for="SUCUR" class="titulo-form">Sucursal:</label>
                        <select name="sucursal" id="sucursal" size="1" class="form-control color-text" required="">
                            <optgroup class="subtitle" label="Dato guardado anteriormente">
                            <? if ($dato->sucursal == "MERIDA") { ?>
                                <option value="MERIDA">MERIDA</option>
                            <? } 
                                else if ($dato->sucursal == "NORTE") { ?>
                                <option value="NORTE">NORTE</option>
                            <? }
                                else if ($dato->sucursal == "CANCUN") {?>
                                <option value="CANCUN">CANCUN</option>
                            <? } ?></optgroup>
                            <optgroup class="subtitle" label="Todas las opciones">
                                <option value="MERIDA">MERIDA</option>
                                <option value="NORTE">NORTE</option>
                                <option value="CANCUN">CANCUN</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <label class="titulo-form">Tarjeta:</label>
                        <select class="form-control color-text"  name="tarjetaCredito" placeholder="Tarjeta">
                            <optgroup class="subtitle" label="Dato guardado anteriormente">
                            <? if ($dato->idTarjetas == "0") { ?>
                                <option value="0">SIN TARJETA ASIGNADA</option>
                            <? }
                                else { ?>
                                <option value="<?=$dato->idTarjetas?>"><? echo $this->capsysdre->GetTarjetas($dato->idTarjetas) ?></option>
                            <? } ?>
                            </optgroup>
                            <optgroup class="subtitle" label="Todas las opciones" id="TarjetasCredito"></optgroup>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label  for="provee" class="titulo-form">Proveedor:</label>
                        <select name="proveedor" id="provee" class="form-control color-text" required="">
                            <optgroup class="subtitle" label="Dato guardado anteriormente">
                                <option value="<?=$dato->idProveedor?>"><? echo $this->capsysdre->GetNombreProveedor($dato->idProveedor) ?></option>
                            </optgroup>
                            <optgroup class="subtitle" label="Todas las opciones">
                            <? if(!empty($ListaProveedores)) { 
                                foreach ($ListaProveedores->result() as $Registro) {  ?> 
                                <option value="<?=$Registro->id?>"  ><? print $Registro->NombreProveedor?> </option>
                                <? 
                                }
                              } 
                              else { ?>
                                <option value="false">Vendedor no encontrado</option>
                            <? } ?>
                            </optgroup>
                        </select>
                    </div>
                </div>    
                <div class="col-md-12 container-elements">
                    <div class="col-sm-6 col-md-6">
                        <label class="titulo-form">Cuentas contables:</label>
                        <select name="idCuentaContable" id="idCuentaContable" class="form-control color-text" onchange="calculaPagoDeCanal()" required>
                            <optgroup class="subtitle" label="Dato guardado anteriormente">
                                <option value="<?=$dato->idCuentaContable?>"><? echo $this->capsysdre->GetCuentaContable($dato->idCuentaContable) ?></option>
                            </optgroup>
                        <?  if(isset($cuentasPorDepartamento)){
                            echo(imprimirCuentasPorDepartamentos($cuentasPorDepartamento));
                            } ?>
                        </select>
                    </div>
                    <div class="col-sm-5 col-md-6">
                        <label class="titulo-form">Forma de pago</label>
                        <select id="selectMetodoDePago" name="formaPago" class="form-control color-text"  required="">
                            <optgroup class="subtitle" label="Dato guardado anteriormente">
                            <? if ($dato->idFormaPago == "0") { ?>
                                <option value="0">FACTURA POSTERIOR A PAGO</option>
                            <? }
                                else if ($dato->idFormaPago == "1") { ?>
                                <option value="1">FACTURA NORMAL</option>
                            <? }
                                else if ($dato->idFormaPago == "2") { ?>
                                <option value="2">GASTO CAJA CHICA</option>
                            <? }
                                else if ($dato->idFormaPago == "3") { ?>
                                <option value="3">TARJETA TOKA</option>
                            <? }
                                else if ($dato->idFormaPago == "4") { ?>
                                <option value="4">TARJETA AMEX</option>
                            <? }
                                else if ($dato->idFormaPago == "5") { ?>
                                <option value="5">NOMINA Y OTROS (Este no requiere autorizacion y se registra como pago REALIZADO)</option>
                            <? }
                                else if ($dato->idFormaPago == "9") { ?>
                                <option value="9">DINNERCAP</option>
                            <? } ?>
                            </optgroup>
                            <optgroup class="subtitle" label="Todas las opciones">
                                <?=imprimirPermisosFormaPago($permisosFormaPago);?>
                            </optgroup>
                        </select>
                    </div>
                </div>   
                <div class="col-md-12 container-elements">
                    <div class="col-md-4">
                        <label class="titulo-form">Folio de Factura:</label>
                        <input type="text" class="form-control color-text"  name="folio" id="folio" value="<?=$dato->folio_factura?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-form">Fecha de Factura:</label>
                        <input type="text" class="form-control color-text"  name="1fNacimiento" id="1fNacimiento" value="<?=$dato->fecha_factura?>" autocomplete="off" required>
                    </div>
                    <div class="col-md-5">          
                        <label class="titulo-form">Concepto:</label>
                        <input type="text"  name="concepto" id="concepto" size="150" value="<?=$dato->concepto?>" required="" class="form-control color-text">
                    </div>
                </div>   
                <div class="col-md-12 container-elements">
                    <div class="col-md-3">
                        <label for="CargoFianzas" class="titulo-form">Subtotal:</label>
                        <input type="text" name="CargoTotal" id="CargoTotal" class="form-control color-text" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  onchange="calculaPagoDeCanal()" value="<?=$dato->totalfactura?>" required="">
                    </div>
                    <div class="col-md-3">
                        <label for="CargoFianzas" class="titulo-form">
                            <span class="badge pull-right" id="spanCargoFianzas"></span>
                            Cargos Fianzas:
                        </label>
                        <input type="text" name="CargoFianzas" id="CargoFianzas" class="form-control color-text" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?=$dato->montofianzas?>" onchange="Suma()">
                    </div>
                    <div class="col-md-3">
                        <label for="CargoFianzas" class="titulo-form">
                            <span class="badge pull-right" id="spanCargoSeguros"></span>
                            Cargo Seguros:
                        </label>
                        <input type="text" name="CargoInst" id="CargoInst" class="form-control color-text" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?=$dato->montoinstitucional?>" onchange="Suma()">
                    </div>
                    <div class="col-md-3">
                        <label for="CargoFianzas" class="titulo-form">
                            <span class="badge pull-right" id="spanCargoCoorporativo"></span>
                            Cargos Corporativos:
                        </label>
                        <input type="text" name="Corporativos" id="Corporativos" class="form-control color-text" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?=$dato->corporativo?>" onchange="Suma()">
                    </div>
                </div>
                <div class="col-md-12 container-elements">
                    <div class="col-md-3">
                        <label class="titulo-form">
                            <span class="badge pull-right" id="spanCargoEspeciales"></span>
                            Cargos Especiales:
                        </label>
                        <div class="agregasto">
                            <input type="text" name="CargoGes" id="CargoGes" class="form-control color-text" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?=$dato->gestion?>" onchange="Suma()" readonly required><i class="fa fa-plus-circle icon-mas fa-2x" aria-hidden="true" id="mostrarCS" title="Panel de Gastos Especiales"></i>
                            <input type="hidden" id="ccc" name="ccc">
                            <input type="hidden" id="cco" name="cco">
                            <input type="hidden" id="inversion" name="inversion">
                            <input type="hidden" id="estrategia" name="estrategia">
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <label for="selectTipoGasto" class="titulo-form">Tipo gasto:</label>
                        <select name='selectTipoGasto' class="form-control color-text">
                            <optgroup class="subtitle" label="Dato guardado anteriormente">
                            <? if ($dato->tipoGasto == "1") { ?>
                                <option value='1'>Operacional</option>
                            <? } 
                                else if ($dato->tipoGasto == "2") { ?>
                                <option value='2'>Nomina</option>
                            <? }
                                else if ($dato->tipoGasto == "3") {?>
                                <option value='3'>Fijo</option>
                            <? } ?></optgroup>
                            <optgroup class="subtitle" label="Todas las opciones">
                                <option value='1'>Operacional</option>
                                <option value='2'>Nomina</option>
                                <option value='3'>Fijo</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-3" >
                        <label for="CargoFianzas" class="titulo-form">Total a Pagar:</label>
                        <input type="text" name="CargoTotalconIVA" id="CargoTotalconIVA" class="form-control color-text "  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  value="<?=$dato->totalconiva?>" required="" >
                    </div>
                </div>
                <div class="col-md-12 container-gs" id="PanelGastosEspeciales" style="margin-top: 15px; margin-bottom: 10px;display: none;">
                    <h4 style="text-align:center; font-size:15px; margin-bottom:15px;">GASTOS ESPECIALES</h4>
                    <div class="col-md-11" style="display:flex; align-items:flex-end;">
                        <div class="col-md-3">
                            <label class="titulo-form">GASTOS CCC </label>
                            <input class="form-control" type="text" id="gastosCcc" name = "gastosCcc" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?=$dato->ccc?>" onchange="Suma()">
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-form">GASTOS CCO</label>
                            <input class="form-control" type="text" id="gastosCco" name = "gastosCco" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?=$dato->cco?>" onchange="Suma()">
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-form">INVERSIONES</label>
                            <input class="form-control" type="text" id="gastosInst" name = "gastosInst" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?=$dato->inversion?>" onchange="Suma()">
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-form">ESTRATEGIA</label>
                            <input class="form-control" type="text" id="gastosEstrategia" name = "gastosEstrategia" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?=$dato->estrategia?>" onchange="Suma()">
                        </div>
                        <div class="col-md-2">
                            <div class= "grabaGastos">
                                <a  class ="btnGrabagastos btn btn-light">Sumar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="display: flex;align-items: center;justify-content: center;">
                    <div class="col-md-11 container-btn">
                        <button type="submit" class="btn btn-primary text-font" name="button" id="button" title="Actualizar Factura">Guardar Información</button>
                    </div>
                </div>
            </div>
        </form >
    </div>
 </section>
<?  }  ?>

<?=link_tag('assets/css/editarfactura.css');?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="<?= site_url('assets/js/listafacturas.min.js'); ?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?=base_url()?>/assets/gap/js/jquery.validate.js"></script>
<script>

     $(document).ready(function () {
        $('#mostrarCS').click(function() {
            $('#PanelGastosEspeciales').toggle(600, "easeInOutQuad");
        })
 });

    $('#formreferidos').on('submit',function() {
        swal("¡Guardado!", "La información se guardó.", "success");
    });

    $("#actualizarFactura").validate({
        rules:{
            tarjetaCredito:{
                required: false,
            },
            idCuentaContable:{
                required: true,
            },
            folio:{
                required: true,
            },
            fechaFolio:{
                required: true,
            },
            concepto:{
                required: true,
            },
        },
        messages: {
            tarjetaCredito:{
                required: "Seleccione una Tarjeta de Crédito",
            },
            idCuentaContable:{
                required: "Seleccione una Cuenta Contable",
            },
            folio:{
                required: "Escriba el Folio de la Factura",
            },
            fechaFolio:{
                required: "Seleccione la Fecha de la Factura",
            },
            concepto:{
                required: "Escriba una referencia",
            },
        },
        // errorPlacement: function(error, element) {
        //     if (error) {
        //         $(`#e_${element[0].id}`).append(error);
        //     } else {
        //         error.insertAfter(element);
        //     }
        // },
        submitHandler: function(form) {
            swal({
                title: "¿Desea guadarlo?",
                text: "La información de la Factura se actualizará.",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                    swal(`Espere un momento...`);
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: (data) => {
                            //toastr.success("Se guardo con éxito.");
                            swal("¡Guardado!", "La información se guardó.", "success");
                            window.location.href = "<?=base_url()?>presupuestos/Vistafacturas";
                        },
                        error: (error) => {
                            swal("¡Uups!", "Ocurrió un error al actualizar la información.", "error");
                        }
                    })
                }
            })
        }
    });

    function peticionAJAX(controlador,parametros,funcion){
        var req = new XMLHttpRequest();
        var direccionAJAX="<?= base_url();?>";
        var url=direccionAJAX+controlador;
        req.open('POST', url, true);
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.onreadystatechange = function (aEvt) {
            if (req.readyState == 4) {
                if(req.status == 200) {           
                  var respuesta=JSON.parse(this.responseText); 
                  window[funcion](respuesta);                                                          
                }     
            }
        };
        req.send(parametros);
    }

  //Ejecución de acualizarProveedores, llamagastoEspecial, enviaCargos
    eventListeners();
    function eventListeners(){
        document.querySelector('.agregasto').addEventListener('click',llamagastoEspecial);
        document.querySelector('.grabaGastos a').addEventListener('click',enviaCargos);
    }

  //Función Tarjetas
    function traerTarjetas(datos) {
      if(datos=='') {
        let params=''; 
        controlador="contabilidad/traerFormasPagos/?";
        peticionAJAX(controlador,params,'traerTarjetas');
      }
      else {
        let cant=datos.tarjetas.length;
        let option='<option value="0">SIN TARJETA ASIGNADA</option>';
        for(let i=0;i<cant;i++) {
          if(datos.tarjetas[i].esTarjetaEspecial==1) {
            option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'" data-especial="'+datos.tarjetas[i].esTarjetaEspecial+'">'+datos.tarjetas[i].numeroTarjeta+'</option>';
          }
          else{
              option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'" data-especial="'+datos.tarjetas[i].esTarjetaEspecial+'">'+datos.tarjetas[i].numeroTarjeta+'('+datos.tarjetas[i].formaPago+')</option>';
            }
        }
        document.getElementById('TarjetasCredito').innerHTML=option;
      }
    }

  //Ejecución de las funciones
    traerTarjetas('');

<?php


  //Cuentas Contables
    function imprimirCuentasPorDepartamentos($informacion){
        $select='';
        foreach ($informacion as $key => $value) {
            $select.='<optgroup class="subtitle" label="'.$key.'">';
            foreach ($informacion[$key] as  $valueDepartamento) {
                $select.='<option value="'.$valueDepartamento->idCuentaContable.'" data-fianzasPorcentaje="'.$valueDepartamento->fianzasPorcentaje.'" data-institucionalPorcentaje="'.$valueDepartamento->institucionalPorcentaje.'" data-coorporativoPorcentaje="'.$valueDepartamento->coorporativoPorcentaje.'" data-gestionPorcentaje="'.$valueDepartamento->gestionPorcentaje.'" data-montomes="'.$valueDepartamento->montoMes.'" data-autorizadomes="'.$valueDepartamento->autorizadoMes.'">'.$valueDepartamento->cuentaContable.'</option>';
            }
            $select.='</optgroup>';
        }
        return $select;
    }

  //Opciones Forma de Pago
    function imprimirPermisosFormaPago($array) {
      //$option='<option></option>';
      foreach ($array as  $value) {
        $option.='<option value="'.$value->idFormaPago.'">'.$value->formaPago.'</option>';
      }
      return $option;
    }


?>

</script>

<?php $this->load->view('footers/footer'); ?>