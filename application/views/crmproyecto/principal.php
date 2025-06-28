<?
	$this->load->view('headers/header'); 
?>
<?
	$this->load->view('headers/menu');
?>

<?  
    $colorRef[0] = "5";
    $colorRef[1] = "8";
    $colorRef[2] = "11";
    $colorRef[3] = "14";
    $colorRef[4] = "17";
    $colorRef[5] = "20";
    $colorRef[6] = "23";
    $colorRef[7] = "26";
    $colorRef[8] = "29";
    $colorRef[9] = "32";
    $colorRef[10] = "33"; //solo llegan a 34 los colores de la libreira
    $colorRef[11] = "34";
    $colorRef[12] = "";
    $colorRef[13] = "";
    $colorRef[14] = "";

    $graficaRef     = base_url().'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=';
    $graficaBarras  = base_url()."assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=";
    $graficaPastel  = base_url()."assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=";
    $graficaPorcen  = base_url()."assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=";

	$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
	$totalResultados = $ListaClientes->num_rows();
?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
 $( function() {
    $( "#dpCita" ).datepicker({
      changeMonth: true,
      changeYear: true,
            showWeek: true,
      firstDay: 1,
      regional:"fr",
      closeText: 'Cerrar',
      prevText: 'Anterior',
  nextText: 'Siguiente',
  dateFormat: 'dd/mm/yy',
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],

    });
  } );


  </script>

<script language="javascript" type="text/javascript">
	function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) {
		var tbl = document.getElementById(gridId);
        if(tbl){
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

			if(isFooter){
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
	}

	function OnScrollDiv(Scrollablediv){
		document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
		document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
    }

	window.onload = function(){
		MakeStaticHeader('Mitabla', 450, 1750, 40, false)
}
</script>

<!--/////////////////////////REGISTRA DIMENSION/////////////////////-->

	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Proyecto 100</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
	                <li><a href="./">Inicio</a></li>
                    <li class="active"><a>Proceso Prospección</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>

	<section class="container-fluid"><!-- container-fluid -->
		<form 
            method="post" class="form" role="formdimension"
            id="formdimension" name="formdimension"
        	action="<?= base_url()?>crmproyecto/InsertaDimension/"
		>
        
		<div class="row" style="font-size:16px; font-weight:bold;">
        	<div class="col-sm-12 col-md-12">
				<div class="form-group">
		            <input type="radio" name="tipo" id="tipo" value="Moral"> Persona Moral
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->

		<div class="row">
        	<div class="col-sm-8 col-md-8">
				<div class="form-group">
    		        <label for="razon">Razón:</label>
	        	    <input type="text"  name="razon" id="razon" class="form-control" placeholder="Razón Social">
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
           
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
		            <label for="rfc">RFC:</label>
        		    <input type="text"  name="rfc" id="rfc" class="form-control" placeholder="RFC">
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
		<div class="row" style="font-size:16px; font-weight:bold;">
        	<div class="col-sm-12 col-md-12">
				<div class="form-group">
					<input type="radio" name="tipo" id="tipo2" value="Fisica"> Persona Física
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->

		<div class="row">
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
    		        <label for="nombre">Nombres:</label>
	        	    <input type="text"  name="nombre" id="nombre" class="form-control" placeholder="Nombre">
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
           
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
		            <label for="apellidop">A. Paterno:</label>
        		    <input type="text"  name="apellidop" id="apellidop" class="form-control" placeholder="Apellido Paterno">
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
            
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
		            <label for="apellidom">A. Materno:</label>
        		    <input type="text"  name="apellidom" id="apellidom" class="form-control" placeholder="Apellido Materno">
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
		<div class="row">
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
    		        <label for="email">Email:</label>
					<input
						type="email" name="email" id="email"
                        placeholder="Email xx@yy.com" class="form-control"
                        pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
                    />
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
           
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
		            <label for="celular">Tel Cel:</label>
					<input 
                    	type="text"  name="celular" id="celular" 
                        placeholder="10 Digitos" maxlength="10" class="form-control"
                    	onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
					>
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-4 col-md-4" align="right">
				<div class="form-group">
                <br />
                    <input 
                    	type="button" name="button" id="button" 
                        value="Agregar Prospecto" class="btn btn-primary" 
                        onclick="SendForm_JjHe()" 
                    />
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
		</form>

<!-- -->
		<div class="row">
        	<div class="col-sm-12 col-md-12">
				<div class="form-group">
				<form id="form" method="GET" action="<?=base_url()?>crmproyecto">
					<div class="input-group">
						<input
    	                	type="text" name="busquedaUsuario" id="busquedaUsuario" 
        	                class="form-control" 
            	            placeholder="Buscar entre la lista de Prospectos"
                	    >
						<span class="input-group-btn">
                    		<button class="btn btn-primary" title="Buscar"><i class="fa fa-search"></i>&nbsp;</button>
    	                </span>
					</div>
				</form>
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
		<div class="row">
        	<div class="col-sm-4 col-md-4" align="right">
				<form id="ExportaClientes" method="post" action="<?=base_url()?>crmproyecto/reporteComercial">
					<button
						class="btn btn-primary"
					>
						Reporte Comercial
					</button>
                    <input type="hidden" name="year" id="year" value="" />
                    <input type="hidden" name="month" id="month" value="" />
				</form>
            </div>
        	<div class="col-sm-4 col-md-4" align="right">
				<form id="ExportaClientes" method="GET" action="<?=base_url()?>crmproyecto/ExportaClientes">
					<button 
						name="ExportaAgentes" id="ExportaAgentes"
						class="btn btn-primary"
					>
						Exporta Clientes
					</button>
				</form>
            </div>
        	<div class="col-sm-4 col-md-4" align="right">
				<button class="btn btn-primary" onclick="abrir()">Muestra Calendario</button>
            </div>
		</div><!-- /row -->
        <br />
<!-- -->
        
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- <div style="overflow: hidden;" id="DivHeaderRow"></div> -->
				<!-- <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent"> -->
				<div class="table-responsive">
    	        	<table class="table" id='Mitabla'>
        	        	<thead>
							<tr>
    	                    	<th>ID</th>
    	                    	<th>Fecha Creacion</th>
    	                    	<th>Comentarios</th>
    	                    	<th>Contacto y Cita</th>
								<th>ApellidoP</th>				                                
								<th>ApellidoM</th>			                                
								<th>Nombre</th>
								<th>RazonSocial</th>	
								<th>RFC</th>	
								<th>Email1</th>
								<th>Telefono1</th>
								<th>Agregar Archivo</th>
								<th>Ver Archivos</th>
								<th>Perfilado</th>
								<th>Contactado</th>
<!--							<th>Citado</th>		-->
<!--							<th>Cotizado</th>	-->
								<th>Pagado</th>			
							</tr>
            	    	</thead>
                		<tbody>   
							<?
								if($ListaClientes != FALSE){$cont=0;
									foreach ($ListaClientes->result() as $row){
							?>
							<tr>
								<td><?=$row->IDCli?></td> 
								<td><?php if($row->fechaCreacionCA!=null){echo(date("Y/m/d", strtotime($row->fechaCreacionCA)));} ?></td>
								<td><button onclick="direccionAJAX(<?=$row->IDCli?>,'muestraVentana')" class="btn btn-primary btn-xs contact-item">Comentarios</button></td>
								<td><button onclick="direccionAJAX(<?=$row->IDCli?>,'ventanaCCC')" class="btn btn-primary btn-xs contact-item">Contacto y Cita</button></td>
								<td><?=$row->ApellidoP?></td>
								<td><?=$row->ApellidoM?></td>
								<td><?=$row->Nombre?></td>
								<td><?=$row->RazonSocial?></td>
								<td><?=$row->RFC?></td>
								<td><?=$row->EMail1?></td>
								<td><?=$row->Telefono1?></td>
								<td><label for="<?echo('Archivo'.$row->IDCli);?>" class="btn btn-primary btn-xs contact-item">Enviar Archivo</label>
                                <input  id="<?echo('Archivo'.$row->IDCli);?>"  type="file" onchange="if(!this.value.length)return false; enviarArchivo(this);" style="opacity: 0; width: 5px">
                                    
								</td>
								<td><button class="btn btn-primary btn-xs contact-item" onclick="verDocumentos(<? echo($row->IDCli);?>)">Ver Archivos</button></td>
								<td>
    	                        	<?
										$sqlEstaPerfilado = "
											select 
												count(IDCliente) as numero 
											from 
												puntaje pj 
											where pj.EdoActual = 'PERFILADO' and pj.IDCliente = '".$row->IDCli."'
															";
										$queryEstaPerfilado=$this->db->query($sqlEstaPerfilado);
										if(!empty($queryEstaPerfilado)){
											foreach ($queryEstaPerfilado->result() as $Registro) {
												$estaperfilado=$Registro->numero;     
											}
										}
										if($estaperfilado>0){ 
											echo "Perfilado"; 
										} else {
                            		?>         
	                            	<a 
    	                            	href="<?= base_url()?>crmproyecto/InsertaPerfilado?IDCL=<?= $row->IDCli?>"
        	              				class="btn btn-primary btn-xs contact-item" data-toggle="modal"
            	                        data-original-title
									>
                    	                <span class="glyphicon glyphicon-pencil" ></span>Perfilar
									</a>
                            		<? } ?> 
								</td>
<!-- 							<td>
									<?
										$sqlEstaContactado = "
											Select 
												count(IDCliente) as numero 
											From 
												puntaje pj 
											Where 
												pj.EdoActual='CONTACTADO' and pj.IDCliente ='".$row->IDCli."'
															 ";
										$queryEstaContactado = $this->db->query($sqlEstaContactado);
										if(!empty($queryEstaContactado)){
											foreach($queryEstaContactado->result() as $Registro){
												$estacontactado=$Registro->numero;     
											}
										}
										if($estacontactado>0){
											echo "Contactado"; 
										} else { 
									?>
									<a 
										href="<?=base_url()?>crmproyecto/InsertaContactado?IDCL=<? echo $row->IDCli?>"
										class='btn btn-primary btn-xs contact-item' data-toggle="modal"  
                        	            data-original-title
									>
	                                	<span class="glyphicon glyphicon-pencil" ></span>Contactar
									</a>
        	                    	<? } ?> 
								</td> -->
<!--							<td>
									<?
										$sqlEstaRegistrado= "
											Select 
												count(IDCliente) as numero 
											From 
												puntaje pj 
											Where 
												pj.EdoActual='REGISTRADO' and pj.IDCliente ='".$row->IDCli."'
															";
										$queryEstaRegistrado=$this->db->query($sqlEstaRegistrado);
										if(!empty($queryEstaRegistrado)){
											foreach ($queryEstaRegistrado->result() as $Registro){
												$estaregistrado=$Registro->numero;
											}
										}
										if($estaregistrado>0){
											echo "Registrado"; 
										} else {
									?>
									<a 
										href="<?=base_url()?>crmproyecto/InsertaCitaRegistrada?IDCL=<?= $row->IDCli?>"
										class="btn btn-primary btn-xs contact-item" data-toggle="modal"
                	                    data-original-title
									>
										<span class="glyphicon glyphicon-pencil" ></span>Citar
									</a>
	                            	<? } ?> 
								</td> -->
								<td>
    	                        	<?
										$sqlEstaCotizado = "
											Select 
												count(IDCliente) as numero 
											From 
												puntaje pj 
											Where 
												pj.EdoActual='COTIZADO' and pj.IDCliente ='".$row->IDCli."'
														   ";
										$queryEstaCotizado = $this->db->query($sqlEstaCotizado);
										if(!empty($queryEstaCotizado)){
											foreach ($queryEstaCotizado->result() as $Registro){
												$estacotizado=$Registro->numero;     
											}
										}
										if($estacotizado>0){
											echo "Cotizado"; 
										} else { 
	                            	?>
									<a 
										href="<?= base_url()?>crmproyecto/LlamaCotizacion?IDCL=<?= $row->IDCli?>"
            	                        class='btn btn-primary btn-xs contact-item' data-toggle="modal"  
                	                    data-original-title
									>
										<span class="glyphicon glyphicon-pencil" ></span>Cotizar
									</a>
	                            	<? } ?> 
								</td>
								<td>
									<?
										$sqlEstaPagado = "
											Select 
												count(IDCliente) as numero 
											From 
												puntaje pj 
											Where pj.EdoActual='PAGADO' and pj.IDCliente ='".$row->IDCli."'
														 ";
										$queryPagado = $this->db->query($sqlEstaPagado);
										if(!empty($queryPagado)){
											foreach($queryPagado->result() as $Registro){
												$estapagado = $Registro->numero;
											}
										}
										if($estapagado>0){
											echo "Pagado"; 
										} else { 
									?>
									<a 
										href="<?= base_url()?>crmproyecto/VerificarPago?IDSIK=<?= $row->IDCliSikas?>&IDCL=<?= $row->IDCli?>"
										class="btn btn-primary btn-xs contact-item" data-toggle="modal"
										data-original-title
									>
                	      				<span class="glyphicon glyphicon-pencil" ></span>Verificar Pago
									</a>
                        	    	<? } ?> 
								</td>
							</tr>
							<?
									}
								}
							?>
						</tbody>
						<?
							if($totalResultados == 0){
						?>
						<tfoot>
							<tr>
								<td colspan="13"><center><b>No se encontraron registros.</b></center></td>
							</tr>
						</tfoot>
						<?
							}
						?>
					</table>
				</div><!-- /table-responsive -->
				<!-- <div id="DivFooterRow" style="overflow:hidden"></div> -->
				<div class="row">
					<div class="col-md-12"><medium><i>Total de resultados: <b><?=$totalResultados?></b></i></medium></div>
				</div><!-- /row -->
            </div><!-- panel-body -->
		</div><!-- panel-default -->

	</section><!-- /container-fluid -->
<div id="miModal" >
    <div id="Modalcontenido" class="modal-contenido"  >
      <table border="2"  style="position:relative; top:10px; left:0px">

      <tr><td>
          <button onclick="cerrar()" style="color: white;float:right;background-color:red; border:double;  ">Cerrar</button>  
          <td>
      </tr>
        <tr><td><p>Titulo: <input type="text" id="tituloCita"></p></td></tr>
      <tr><td><p>Date: <input type="text" id="dpCita"></p></td></tr>
          <tr><td><p>De: <select id="selFecIniCita">
            <?php 
             $inicio=8;
             for($i=0;$i<12;$i++){
              echo('<option>'.$inicio.':00</option>');
              echo('<option>'.$inicio.':30</option>');
              $inicio++;
             }

            ?>
          </select>
       A:<select id="selFecFinCita">
            <?php 
             $inicio=8;
             for($i=0;$i<12;$i++){
              echo('<option>'.$inicio.':00</option>');
              echo('<option>'.$inicio.':30</option>');
              $inicio++;
             }

      
            ?>
          </select>
                    <button onclick="guardaCita()" class="btn btn-primary">Guardar Cita</button>
           </td>

         </tr>
      <tr><td>
          <div id='calendar'></div>

</td></tr>
</table>
    </div>
</div>
<input type="text"  id="dpCita2dd">
<style>
.modal-contenido{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
</style>

<script type="text/javascript">
 function cerrar(){document.getElementById("miModal").classList.add("modalCierra");document.getElementById("miModal").classList.remove("modalAbre");document.getElementById("Modalcontenido").style.display="none";
 }
 function abrir(){
document.getElementById("miModal").classList.remove("modalCierra");document.getElementById("miModal").classList.add("modalAbre");document.getElementById("Modalcontenido").style.display="block";
 }
 cerrar();
 <?php 
if($muestraCalendario==1){  ?>
abrir();
<?php }?>
</script>

<script>
	function SendForm_JjHe(){
		var bandFalse=0;
		/*POR EL MOMENTO NO VA A VALIDAR DATOS HASTA NUEVO AVISO*/
   if(bandFalse==1){
 		var formulario = document.getElementById('formdimension');
		var nom	= document.getElementById('nombre').value;
		var ap	= document.getElementById('apellidop').value;
		var am	= document.getElementById('apellidom').value;
		var raz	= document.getElementById('razon').value;
		var rfc	= document.getElementById('rfc').value;
		var ema	= document.getElementById('email').value;
		var cel	= document.getElementById('celular').value;
		
		/* Persona Moral */
		if(document.getElementById('tipo').checked ){
			if(raz !='' && rfc!=''  && ema!='' && cel!=''){document.formdimension.submit();}
		    else {alert('No capturaste Razon y RFC y Es Obligatorio Email y Telefono');}                 
		}
		
		/* Persona Fisica */
		if(document.getElementById('tipo2').checked ){
			if(nom !='' && ap!=''  && ema!='' && cel!=''){document.formdimension.submit();} 
			else {alert('No capturaste Nombre o Apellidos, Es Obligatorio Email y Telefono');}
		}
	}
else
{
	document.formdimension.submit();
}
}
</script>
<? $this->load->view('footers/footer'); ?>



<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.css' rel="stylesheet">
<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.print.min.css' rel="stylesheet" media='print'>
<script src='<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url();?>assets/fullcalendar/fullcalendar.min.js'></script>
<script>

  $(document).ready(function() {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek',
        
      },
      defaultDate:new Date(),
      navLinks: false, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
      <?php  
        foreach ($citas as $value) {echo('{ title:"'.$value->title.'",start:"'.$value->start.'",end:"'.$value->end.'",id:"'.$value->id.'"},');        }
      ?>

     
      ],
      eventDrop:function(event,delta,reverFunc)
        {
          var id=event.id;
          var fi=event.start.format();
          var ff=event.end.format();
          $.post(<?php echo('"'.base_url().'crmproyecto/actualizaCita"'); ?>,{
             id:id,fi:fi,ff:ff},
             function(data){
              if(data==1){alert("Cita actualizado correctamente")}
              else{alert("error intenterlo mas tarde")}
          })

        },
      eventResize:function(event)
      {
         var id=event.id;
          var fi=event.start.format();
          var ff=event.end.format();
          $.post(<?php echo('"'.base_url().'crmproyecto/actualizaCita"'); ?>,{
             id:id,fi:fi,ff:ff},
             function(data){ if(data==1){alert("Cita actualizado correctamente")}
              else{alert("error intenterlo mas tarde")}
          })


      },
      eventRender: function(event,element){
        var el=element.html();
        element.html("<div style='width:90%;'>"+el+"</div><div style='float:right;color:red;border:solid; width:10px; height:10px;text-align:right;position:relative; top:-15px; background-color:white' class='eliminaCita'>X</div>");
        element.find('.eliminaCita').click(function(){
          if(!confirm("Estas seguro de eliminar el evento")){
            alert("Eliminacion cancelada");
          }else{var id=event.id;
                   $.post(<?php echo('"'.base_url().'crmproyecto/eliminaCita"');  ?>,{id:id},
             function(data){ if(data==1){
              $('#calendar').fullCalendar('removeEvents',event.id);
              alert("Cita eliminada correctamente")}
              else{alert("error intenterlo mas tarde")}
          })

          }
        })
      }
    });

  });

function guardaCita(){

var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=<?php echo('"'.base_url().'crmproyecto/guardaCita"'); ?>;
var inputFI=document.createElement('input'); inputFI.setAttribute('type','text');inputFI.setAttribute('name','fecIniCita'); inputFI.value=document.getElementById('selFecIniCita').value;
var inputFF=document.createElement('input'); inputFF.setAttribute('type','text');inputFF.setAttribute('name','fecFinCita'); inputFF.value=document.getElementById('selFecFinCita').value;
var inputF=document.createElement('input'); inputF.setAttribute('type','text');inputF.setAttribute('name','fecCita'); inputF.value=document.getElementById('dpCita').value;
var inputT=document.createElement('input'); inputT.setAttribute('type','text');inputT.setAttribute('name','tituloCita'); inputT.value=document.getElementById('tituloCita').value;
var inputC=document.createElement('input'); inputC.setAttribute('type','hidden');inputC.setAttribute('name','idClienteCita'); inputC.value="<?php echo($idCliente); ?>";

formulario.appendChild(inputFI);
formulario.appendChild(inputFF);
formulario.appendChild(inputF);
formulario.appendChild(inputT);
formulario.appendChild(inputC);
document.body.appendChild(formulario);
if(inputT.value=="" || inputF.value==""){
alert("Debe llevar titulo y fecha");
}else
{
  
  var fechaInicial=inputFI.value;
  fechaInicial=fechaInicial.replace(":","");
  
  var fechaFinal=inputFF.value;
  fechaFinal=fechaFinal.replace(":","");
  if(parseInt(fechaFinal)>parseInt(fechaInicial)){
   formulario.submit();
  }
  else{alert("la fecha final debe ser mayor a la inicial")}
  }
}
function enviarArchivo(objeto){
	objeto.setAttribute('name',objeto.id);
	var formulario=document.createElement('form'); 
	formulario.setAttribute('method','post'); 
	formulario.enctype='multipart/form-data';
	formulario.action=<?php echo('"'.base_url().'crmproyecto/guardaArchivo"'); ?>;
    formulario.appendChild(objeto);
	document.body.appendChild(formulario);
	formulario.submit();

}
function verDocumentos(idProspecto){
  var req = new XMLHttpRequest();
  req.open('GET', '<?=base_url()?>crmproyecto/devuelveDocumentos/?idProspecto='+idProspecto, true);
  req.onreadystatechange = function (aEvt) 
  {
     if	(document.getElementById("divVentanaDocumentos")){document.head.removeChild(document.getElementById('divVentanaDocumentosEstilo'));}
     if(document.getElementById('divVentanaDocumentos')){document.body.removeChild(document.getElementById('divVentanaDocumentos'));}
     if (req.readyState == 4) {if(req.status == 200)
       {var j=JSON.parse(this.responseText);   
        if(j==0){alert("Este usuario no tiene documento");}
        else
        {
        	var hoja = document.createElement('style');var div=document.createElement('div');div.id="divVentanaDocumentos";
        div.innerHTML=j["datos"];
        hoja.id="divVentanaDocumentosEstilo";hoja.type="text/css";hoja.innerHTML=j['estilo'];
        document.head.appendChild(hoja);document.body.appendChild(div);
        document.getElementById("divVentanaDocumentos").classList.add('ventanaDocumentosEstilo');
       }                                                 
      }     
   }
  };
 req.send();
}


function direccionAJAX(idProspecto,opcion){
	var direccionAJAX="<?php echo(base_url().'crmproyecto/');?>";
	switch(opcion){
     case 'muestraVentana':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&tipoCCC=0"; break;
  	case 'nuevoComentario':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&nuevoComentario="+document.getElementById('textNuevoComentario').value+"&tipoCCC=0"; break;
  	case 'eliminaComentario':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&eliminaComentario="+document.getElementById('textNuevoComentario').value+"&tipoCCC=0"; break;
  	case 'modificaComentario':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&modificaComentario="+document.getElementById('comentario'+idProspecto).value+"&tipoCCC=0"; break;
	case 'ventanaCCC':direccionAJAX=direccionAJAX+'ventanaCitaContacto/?idProspecto='+idProspecto ;break;
	case 'guardarCCC': direccionAJAX=direccionAJAX+'guardarContactoCita/?idProspecto='+idProspecto+"&citaContacto="+document.getElementById("dpCitaContacto").value+"&tipoCCC="+document.getElementById("tipoCCC").value ;break;
	case 'modificaCCC':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&modificaComentario="+document.getElementById('comentario'+idProspecto).value+"&tipoCCC=1"; break;
	}	
	
  conectaAJAX(direccionAJAX);
}
function conectaAJAX(direccionAJAX){
  var req = new XMLHttpRequest();
  req.open('GET',direccionAJAX, true);
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    {
     if	(document.getElementById("divVentanaComentarios")){document.body.removeChild(document.getElementById('divVentanaComentarios'));}
     if(document.getElementById("divVentanaComentarioEstilo")){document.head.removeChild(document.getElementById('divVentanaComentarioEstilo'));}
    
     var j=JSON.parse(this.responseText);
      var hoja = document.createElement('style');hoja.id="divVentanaComentariosEstilo";
     document.head.appendChild(hoja);                   
     var div=document.createElement('div');div.id="divVentanaComentarios";div.innerHTML=j["datos"];
     hoja.type="text/css";
     hoja.innerHTML=j['estilo'];
     document.body.appendChild(div);
     document.getElementById("divVentanaComentarios").classList.add('estilo');
     asignaCalendario();

                                                     
      }     
   }
  };
 req.send();
}


</script>
<script type="text/javascript">	
function asignaCalendario(){
 $( function() {
    $( "#dpCitaContacto" ).datepicker({
      changeMonth: true,changeYear: true,showWeek: true,firstDay: 1,  dateFormat: 'dd/mm/yy',
      regional:"fr",closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],

    });
    } );
  }

</script>