<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
    
?>
<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section >
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Monitores</h3></div>
        
            <ol class="breadcrumb text-right">
                <li><a href="<?=base_url()?>">Inicio</a></li>
                <li class="active">Monitores</li>
            </ol>
        </div>
    </div>
        <hr /> 
</section>

<!--<section>
<form name="formMonitores2" action="<?=base_url();?>monitores/verSeguimiento" method="post" id="formFiltro">
                        <button
                            class="btn btn-primary btn-sm" style="visibility: visible;"
                            onclick="document.formMonitores.monitorear.value = 'SeguimientoActividades'; document.formMonitores.submit();"
                        >
                            Seguimiento de actividades
                        </button>
</form>
</section> -->

<section>
    <form name="formMonitores" action="<?=base_url();?>monitores/verMonitor" method="post" id="formFiltro">
        <input type="hidden" name="monitorear" value="">

                        <div class="col-sm-4 col-md-4">
                                <div class="row">

                                <!--    <button
                            
                                        onclick="document.formMonitores.monitorear.value = 'SemaforoEnCurso'; document.formMonitores.submit();"
                                    >
                                    _Semaforo al Dia
                                        </button>-->
                                </div>
                                <br />
                                <br />

                                <div class="row">

                                      <div class="col-sm-4 col-md-4">
                                       
                                            <label>Inicio</label>
                                            <input
                                            type="text" name="fechaStart" id="fechaStart"
                                            class="form-control input-sm fecha fechaStart"
                                            placeholder="1900-01-01"
                                            value="<?=($this->input->post('fechaStart',TRUE)!="")?$this->input->post('fechaStart',TRUE):date('Y-m-d')?>"
                                            title="Fecha de Inicio"
                                            />
                                        

                                        
                                            <label>Fin</label>
                                            <input
                                                type="text" name="fechaEnd" id="fechaEnd"
                                                class="form-control input-sm fecha fechaEnd"
                                                placeholder="1900-01-01"
                                                value="<?=($this->input->post('fechaEnd',TRUE)!="")?$this->input->post('fechaEnd',TRUE):date('Y-m-d')?>"
                                                title="Fecha de Fin"
                                            />

                                       </div>  
                                </div>
                         <br />
             

                        <button
                            
                            onclick="document.formMonitores.monitorear.value = 'SemaforoEnCursoMes'; document.formMonitores.submit();"
                        >
                            Semaforo a Fecha 
                        </button>

                         </div>

                        <div class="col-sm-4 col-md-4" style="display: none;">
                        <button
                        	
                            onclick="document.formMonitores.monitorear.value = 'SemaforoActividades'; document.formMonitores.submit();"
                        >
                        	Semaforo Actividades
                        </button>
                        </div>

                        <div class="col-sm-4 col-md-4" style="display: none;">
                        <button
                        	
                            onclick="document.formMonitores.monitorear.value = 'Actividades'; document.formMonitores.submit();"
                        >
                        	Actividades
                        </button>
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



        
	});

 var fechaStartn =
    $('.fechaStart').datepicker({
        format:     "yyyy-mm-dd",
        startDate:  "",
        language:   "es",
        autoclose:  true
    });
    
    var fechaEndn =
    $('.fechaEnd').datepicker({
        format:     "yyyy-mm-dd",
        startDate:  "",
        language:   "es",
        autoclose:  true
    });

</script>
<?php $this->load->view('footers/footer'); ?>