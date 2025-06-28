<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
    
?>

<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Reportes</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li class="active">Reportes</li>
            </ol>
        </div>
    </div>
        <hr /> 
</section>
<section class="container-fluid">
    <form name="frmReporte" action="<?php echo base_url();?>reportes/verReporte" method="GET" id="frmFiltro">
        <input type="hidden" name="consultar" value="">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-12 text-right">
						<input type="button" onclick="document.frmReporte.consultar.value = 'Renovacin'; document.frmReporte.submit();" value="RENOVACIÓN" class="btn btn-primary btn-sm" />
                        <input type="button" onclick="document.frmReporte.consultar.value = 'Produccin'; document.frmReporte.submit();" id="btnConsultar" value="PRODUCCIÓN" class="btn btn-primary btn-sm" />
                        <input type="submit"onclick="document.frmReporte.consultar.value = 'Cobranza Pendiente'; document.frmReporte.submit();"id="btnConsultar" value="COBRANZA PENDIENTE" class="btn btn-primary btn-sm" />

                        <input type="submit" onclick="document.frmReporte.consultar.value = 'Cobranza Efectuada'; document.frmReporte.submit();" id="btnConsultar" value="COBRANZA EFECTUADA" class="btn btn-primary btn-sm" />

                        <input type="submit" onclick="document.frmReporte.consultar.value = 'Cobranza Cancelada'; document.frmReporte.submit();" id="btnConsultar" value="COBRANZA CANCELADA" class="btn btn-primary btn-sm" />

                        <input type="submit" onclick="document.frmReporte.consultar.value = 'Buscador Clientes'; document.frmReporte.submit();" id="btnConsultar" value="BUSCADOR CLIENTES" class="btn btn-primary btn-sm" />
                        
                        <input type="button" onclick="document.frmReporte.consultar.value = 'Actividades'; document.frmReporte.submit();" value="ACTIVIDADES" class="btn btn-primary btn-sm" />

						<input type="button" onclick="document.frmReporte.consultar.value = 'Vendedores'; document.frmReporte.submit();" value="VENDEDORES" class="btn btn-primary btn-sm" />
                    
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="NombreCliente">Nombre Cliente</label>
                                <input type="text" name="cliente" id="cliente" class="form-control input-sm" placeholder="Nombre Cliente"/>
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="Estatus">Estatus</label>
                                <select name="estatus" id="estatus" class="form-control input-sm">
                                    <option value="">Seleccione un Estatus</option>
                                    <option value="1">Activos</option>
                                    <option value="2">Inactivos</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="Ramo">Ramo</label>
                                <select name="ramo" id="ramo" class="form-control input-sm">
                                    <option value="">Selecccione un Ramo</option>
                                    <?php if (isset($Ramo)): ?>
                                        <?php foreach ($Ramo as $_Ramo): ?>
                                            <option value="<?php echo $_Ramo["idRamo"]?>"><?php echo $_Ramo["nombre"]?></option>
                                        <?php endforeach ?>    
                                    <?php endif ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="SubRamo">Sub ramo</label>
                                <select name="subramo" id="subramo" class="form-control input-sm"> 
                                <option value="">Selecccione un Sub Ramo</option>
                                    <?php if (isset($SubRamo)): ?>
                                        <?php foreach ($SubRamo as $SRamo): ?>
                                            <option value="<?php echo $SRamo["IDSRamo"]?>"><?php echo $SRamo["nombre"]?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                            </select>
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="Promotor">Promotor</label>
                                <select name="promotor" id="promotor" class="form-control input-sm">
                                    <option value="">Selecccione un Promotor</option>
                                    <?php if(isset($promotor)){ 
                                      foreach ($promotor as $value) {
                                          echo '<option value = "'.$value->IDVend.'">'.$value->name_complete.'</option>';
                                      }
                                    }?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="Agente">Agente</label>
                                <select name="vendedor" id="vendedor" class="form-control input-sm">
                                    <option value="">Seleccione un Agente</option>
                                    <?php if(isset($vendedor)){ 
                                      foreach ($vendedor as $value) {                                     
                                          echo '<option value = "'.$value->IDVend.'" data-ids="'. $value->IDVendNS . '">'.$value->NombreCompleto.'</option>';
                                      }
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="Grupo">Grupo</label>
                                <select name="grupo" id="grupo" class="form-control input-sm"> 
                                    <option value="">Selecccione un Grupo</option>
                                    <?php if (isset($Grupo)): ?>
                                        <?php foreach ($Grupo as $value): ?>
                                            <option value = "<?php echo $value['IdGrupo']; ?>"><?php echo $value['Grupo']; ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="SubGrupo">Sub grupo</label>
                                <select name="subgrupo" id="subgrupo" class="form-control input-sm"> 
                                    <option value="">Selecccione un Grupo</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="Poliza">P&oacute;liza</label>
                                <input type="text" name="poliza" id="poliza" class="form-control input-sm" placeholder="P&oacute;liza" />
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <div class="row">
                                    <div class="col-md-12"><label><input type="checkbox" name="habilitarf" id="habilitarf" class="" /> Filtrar con fechas</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" name="fechaini" id="fechaini" class="form-control input-sm fecha fechaini" placeholder="01/01/1900"  />
                                            <span class="input-group-btn"><a href="#" class="btn btn-primary btn-sm"><i class="fa fa-calendar fa-lg"></i>&nbsp;</a></span>                        
                                        </div>
                                        <small>Desde</small>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" name="fechafin" id="fechafin" class="form-control input-sm fecha fechafin" placeholder="01/01/1900"  />                                            <span class="input-group-btn"><a href="#" class="btn btn-primary btn-sm fecha"><i class="fa fa-calendar fa-lg"></i>&nbsp;</a></span>                        
                                        </div>
                                        <small>Hasta</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>  


<!--..::::::::::::::::::::================ INICIO MODAL PRELOAD AJAX ================::::::::::::::::::::..-->
    <!-- <div id="modalPreload" class="modal fade" data-keyboard="false" data-backdrop="static"> -->
    <div id="modalPreload" class="modal fade">
        <div class="modal-preload">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="<?php echo base_url() ?>assets/img/loading.gif" class="icon" />
                            <small>PROCESANDO...</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--..::::::::::::::::::::================ FIN MODAL PRELOAD AJAX ================::::::::::::::::::::..-->



<script>
	$(document).ready(function(){	
	
        $('#frmFiltro').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
        });

        if ($('#habilitarf').is(':checked')) {
            $('.fecha').prop('disabled',false);
        }else{
            $('.fecha').prop('disabled',true);
        }
		
		$('#habilitarf').change(function(){
            if($(this).is(":checked")) {
                $('.fecha').prop('disabled',false);
            }else{
                $('.fecha').prop('disabled',true);
            }
            
        });


               
		
		$('#promotor').change(function(){

            $('#modalPreload').modal({
                show: true,
                backdrop: "static"
            });

             var IDV = $(this).val();
			 if(IDV == "")
				 IDV = 0;
			 
			 // console.log(IDV);

            $.ajax({
              method: "POST",
              url: "<?php echo base_url(); ?>" + "reportes/getVendedor",        
              //dataType: 'json',
              data: { IDVend : IDV },
                success: function(json){
					// console.log(json);
                    if(json != ""){
                     $('#vendedor').find('option')
                                            .remove()
                                            .end();

                    $('#vendedor').append($('<option>',{
                                value : "",
                                text : "Selecccione un agente",
                            }));
                        var oJson = JSON.parse(json);
                        $.each(oJson,function(k,v){
                            $('#vendedor').append($('<option>',{
                                value : v.IDVend,
                                text : v.NombreCompleto,
                            }));
                        });
                    }
                     $('#modalPreload').modal('hide');
                },
                error: function(jqXHR,textStatus,errorThrown ){
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown );
                        alert('Error while request..');
                         $('#modalPreload').modal('hide');
                }
            });
        });

         $('#ramo').on('change',function(event){
            $('#modalPreload').modal({
                show: true,
                backdrop: "static"
            });
            var IDR = $(this).val();

            if(IDR == "" || IDR == "0"){

                $('#subramo').find('option')
                    .remove()
                    .end();
                $('#subramo').append($('<option>',{
                        value : "",
                        text : "Selecccione un Sub Ramo",
                    }));

                $('#modalPreload').modal('hide');
            }else{
                $.ajax({
                  method: "POST",
                  url: "<?php echo base_url(); ?>" + "reportes/getSubRamo",        
                  //dataType: 'json',
                  data: { IDRamo : IDR },
                    success: function(json){
                        if(json != ""){
                         $('#subramo').find('option')
                                                .remove()
                                                .end();

                        $('#subramo').append($('<option>',{
                                    value : "",
                                    text : "Selecccione un Sub Ramo",
                                }));
                            var oJson = JSON.parse(json);
                            $.each(oJson,function(k,v){
                                $('#subramo').append($('<option>',{
                                    value : v.IDSRamo,
                                    text : v.nombre,
                                }));
                            });
                        }
                         $('#modalPreload').modal('hide');
                    },
                    error: function(jqXHR,textStatus,errorThrown ){
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown );
                            alert('Error while request..');
                             $('#modalPreload').modal('hide');
                    }
                });
            }
        });
         $('#grupo').on('change',function(event){
            $('#modalPreload').modal({
                show: true,
                backdrop: "static"
            });
            var IDR = $(this).val();
            if(IDR == "" || IDR == "0"){
                $('#subgrupo').find('option')
                    .remove()
                    .end();

                $('#subgrupo').append($('<option>',{
                    value : "",
                    text : "Selecccione un Sub Grupo",
                }));
                $('#modalPreload').modal('hide');
            }else{
                $.ajax({
                  method: "POST",
                  url: "<?php echo base_url(); ?>" + "reportes/getSubGrupos",        
                  //dataType: 'json',
                  data: { IDGrupo : IDR },
                    success: function(json){
                        if(json != ""){
                         $('#subgrupo').find('option')
                                                .remove()
                                                .end();

                        $('#subgrupo').append($('<option>',{
                                    value : "",
                                    text : "Selecccione un Sub Grupo",
                                }));
                            var oJson = JSON.parse(json);
                            $.each(oJson,function(k,v){
                                $('#subgrupo').append($('<option>',{
                                    value : v.IDSGrupo,
                                    text : v.Grupo,
                                }));
                            });
                        }
                         $('#modalPreload').modal('hide');
                    },
                    error: function(jqXHR,textStatus,errorThrown ){
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown );
                            alert('Error while request..');
                             $('#modalPreload').modal('hide');
                    }
                });
            }

            
        });

        Date.prototype.ddmmyyyy = function() {         
                                
            var yyyy = this.getFullYear().toString();                                    
            var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based         
            var dd  = this.getDate().toString();             
                                
            return  (dd[1]?dd:"0"+dd[0]) + '/' + (mm[1]?mm:"0"+mm[0]) + '/' + yyyy;
       }; 

        function IniciarFechas(fechaIni, fechaFin){
            var date = new Date();
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);

            $(fechaIni).val(firstDay.ddmmyyyy());
            $(fechaFin).val(date.ddmmyyyy());

        }

        var fechaIni = $('.fechaini').datepicker({
            format: "dd/mm/yyyy",
            startDate: "01/01/1900",
            language: "es",
            autoclose: true
        });



        // fehcaIni.on('changeDate',function(ev){
        //     console.log(ev);
        //     var todayTime = new Date(ev.date);

        //     $('.fechaini').val(todayTime.yyyymmdd());
        // });

		var fechaFin = $('.fechafin').datepicker({
					//startDate: '2016-01-27',
        	    format: "dd/mm/yyyy",
                startDate: "01/01/1900",
                language: "es",
                autoclose: true
			});

        IniciarFechas(fechaIni,fechaFin);
	});
</script>
<?php $this->load->view('footers/footer'); ?>