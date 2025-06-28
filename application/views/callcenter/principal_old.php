<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $ListaClientes->num_rows();
?>
<?php
	$this->load->view('headers/header');
?>
<!-- Navbar -->
<?php
	//$this->load->view('headers/menu');
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
?>

<meta name="viewport" content="width=900px"/>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
	$(function(){
		$("#dpCita").datepicker({
			changeMonth: 	true,
			changeYear: 	true,
			showWeek: 		true,
			firstDay: 		1,
			regional:		'mx',
			closeText: 		'Cerrar',
			prevText: 		'Anterior',
			nextText: 		'Siguiente',
			dateFormat: 	'dd/mm/yy',
			dayNamesMin:	['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		});
	});
</script>

<script language="javascript" type="text/javascript">
	<? 
		if(isset($mensaje)){
			echo('alert("'.$mensaje.'")');
		}
	?>
/*
    function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) {
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
    }

    function OnScrollDiv(Scrollablediv){
	    document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
    	document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
    }

    window.onload = function() {
	//	MakeStaticHeader('Mitabla', 450, 1750, 40, false)
	}
*/
 </script>

<section class="container-fluid breadcrumb">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">TeleMarketing </h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li class="active">TeleMarketing</li>
                <li class="active"><a href="./callcenter"><strong>Proceso TeleMarketing</strong></a></li>
            </ol>
        </div>
    </div>
	<hr />
</section>

<!--/////////////////////////REGISTRA DIMENSION/////////////////////-->
<section class="container-fluid breadcrumb-formularios">
	<form
		action="<?=base_url()?>callcenter/InsertaDimension/"
		method="post" 
        name="formdimension" id="formdimension"
    	class="form-horizontal" role="formdimension" 
	>
	<div class="row">
		<div class="col-md-10" align="right">
        </div>
		<div class="col-md-2" align="left">
			<div class="selector-tipoNewCliente">
			<div class="input-group">
				<select name="tipo_cliente" id="tipo_cliente" class="form-control input-sm" title="Nuevo Cliente" required>
            		<option value="">Nuevo Cliente</option>
                	<option value="Moral">Persona Moral</option>
            		<option value="Fisica">Persona Fisica</option>
				</select>
				<span class="input-group-btn"><button class="btn btn-primary btn-sm" title="Agregar"><i class="fa fa-user-plus"></i>&nbsp;</button></span>
			</div>
			</div>
		</div>
	</div>
    
	<div id="uno" class="row form-group" style="display:none">
		<div class="col-md-12">
			<!--
            <input type="radio" name="tipo" id="tipo" value="Moral">Persona Moral
			-->
            <label>Razon:</label>
            <input type="text"  name="razon" id="razon" placeholder="Razon Social" class="form-control input-sm"  > 
		</div>
	</div>
    
	<div id="dos" class="row form-group" style="display:none">
		<div class="col-md-4">
        	<!--
            <input type="radio" name="tipo" id="tipo2" value="Fisica">Persona Fisica<br>
            -->
            <label>Nombres:</label>
            <input type="text"  name="nombre" id="nombre" placeholder="Nombre" class="form-control input-sm"  > 
		</div>
		<div class="col-md-4">
            <label>A. Paterno:</label>
            <input type="text" name="apellidop" id="apellidop" placeholder="Apellido Paterno" class="form-control input-sm"  > 
		</div>
		<div class="col-md-4">
            <label>A. Materno:</label>
            <input type="text"  name="apellidom" id="apellidom" placeholder="Apellido Materno" class="form-control input-sm"  > 
        </div>
    </div>
    
	<div id="tres" class="row form-group" style="display:none">
		<div class="col-md-3">
            <label>RFC:</label>
            <input type="text"  name="rfc" id="rfc" placeholder="RFC" class="form-control input-sm"> 
		</div>
		<div class="col-md-3">
			<label>Email</label>
			<input 
            	type="text" name="email" id="email" type="email" placeholder="Email xx@yy.com" class="form-control input-sm"
            	pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
            >
		</div>
		<div class="col-md-3">
			<label>Tel Cel.</label>
			<input 
            	type="text"  name="celular" id="celular" placeholder="10 Digitos" maxlength="10" class="form-control input-sm"
                onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
            >
        </div>
		<div class="col-md-3" align="right">
        	<br />
	        <input 
    		    type="button" name="button" id="button" value="Agregar Prospecto" class="btn btn-primary btn-sm form-control" style="color:#FFF;"
            	onclick="this.validarFormulario();"
			>
        </div>
    </div>
	
    <div id="cuatro" class="row form-group" style="display:none">
		<div class="col-md-12">
        	<hr />
        </div>
	</div>
	</form>
</section>  <!--////////////TERMINA LA SECCION DE ARRIBA//////////////////-->

<br />

<section class="container-fluid breadcrumb-busqueda">      
	<div class="row">
        
        <div class="col-md-3">
			<button class="btn btn-primary btn-sm" onclick="abrirCalendario()">Muestra Calendario</button> 
		</div>
        
		<div class="col-md-5">
		</div>
        
		<div class="col-md-3" align="right">
			<form id="form" method="GET" action="<?=base_url()?>callcenter">
				<div class="input-group">
					<input type="text" name="busquedaUsuario" id="busquedaUsuario" class="form-control input-sm" placeholder="Buscar entre la lista de Prospectos">
					<span class="input-group-btn"><button class="btn btn-primary btn-sm" title="Buscar"><i class="fa fa-search"></i>&nbsp;</button></span>
				</div>
			</form>
		</div>

		<div class="col-md-1" align="right">
			<form id="ExportaClientes" method="GET" action="<?=base_url()?>callcenter/ExportaClientes">
            	<button class="btn btn-primary btn-sm" name="ExportaAgentes" id="ExportaAgentes">
					Exporta Clientes
				</button>
            </form>  
		</div>

	</div>
</section>
<br />
<?
//echo "<pre>";

if($this->tank_auth->get_usermail() == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $this->tank_auth->get_usermail() == "MARKETING@AGENTECAPITAL.COM" || $this->tank_auth->get_usermail() == "AUXILIARMKT@AGENTECAPITAL.COM"){
?>
<section class="container-fluid breadcrumb-busqueda">      
	<div class="row">
        
        <div class="col-md-3">

		</div>
        
		<div class="col-md-3">
		</div>
        
		<div class="col-md-3" align="right">
		</div>

		<div class="col-md-3" align="right">
			<form id="Mailing" method="post" action="<?=base_url()?>mailing">
            	<button class="btn btn-primary btn-sm">
					<i class="fa fa-envelope"></i> Administracion Mailing
				</button>
            </form>  
		</div>

	</div>
</section>
<br />
<?
}
?>

<section class="container-fluid breadcrumb-tabla">

	<div id="DivRoot" align="left">
    	<div style="overflow: hidden;" id="DivHeaderRow">
		</div>

		<div style="overflow:scroll;" id="DivMainContent"><!-- onscroll="OnScrollDiv(this)" -->
        <!--Place Your Table Heare-->
			<div class="table-responsive">
				<table class="table" id='Mitabla'>
					<thead>
						<tr>
                        <!--
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
							<th>Agregar documento</th>
							<th>Documentos</th>
                  			<th>TipoSeguro</th>
							<th>Contactado</th>
							<th>Cotizado</th>
                  			<th>Pagado</th>		
						-->
                        	<th>Origen</th>
                        	<th>Nombre</th>
                        	<th>Datos</th>
                            <th>Mailing</th>
                        	<th>Asignado a</th>
                            <th>Historial</th>
                        	<th>Calificacion</th>
                        	<th>Estado</th>
						</tr>
					</thead>
					<tbody>   
				<?
					if($ListaClientes != FALSE){
						foreach ($ListaClientes->result() as $row){
						//	echo "<pre>";
						//	print_r($row);
						switch($row->leads){
							default:
								$clasificaLeads	= "";
							break;
							
							case "http://www.fianzascapital.com.mx":
								$clasificaLeads	= "Fianzas";
							break;
							
							case "http://www.capitalsegurosgmm.com":
								$clasificaLeads	= "GMM";
							break;
							
							case "http://capsys.com.mx/client":
								$clasificaLeads	= "Client Crox";
							break;
						}
				?>
						<tr>
                  			<td title="<?= $row->IDCli; ?>">
                            	<?
									echo $row->actualiza;
									echo "<br />";
									echo $row->FuenteProspecto;
									echo "<br />";
									echo $clasificaLeads;
								?>
								<form action="<?=base_url();?>callcenter/eliminaCliente"  method="post" id="formEliminaCliente">
								  <button class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>
									<input type="hidden" id="IDCli" name="IDCli" value="<?= $row->IDCli?>" />
								</form>
                            </td>
                  			<td>
								<?= $row->Nombre." ".$row->ApellidoP." ".$row->ApellidoM." ".$row->RazonSocial?>
							</td>
                  			<td>
                            	<?
									if($row->fechaCreacionCA!=null){echo(date("Y/m/d H:i", strtotime($row->fechaCreacionCA)));} 
									echo "<br />";
									echo $row->EMail1;
									echo "<br />";
									echo $row->Telefono1;
								?>
                            </td>
                            <!--
                            <td>
                            	<button onclick="direccionAJAX(<?=$row->IDCli?>,'muestraVentana')" class="btn btn-primary btn-xs contact-item">Comentarios</button>
                                
                                <button onclick="direccionAJAX(<?=$row->IDCli?>,'ventanaCCC')" class="btn btn-primary btn-xs contact-item">Contacto y Cita</button>
                                
								<button class="btn btn-primary btn-xs contact-item" style="z-index: 0; height: 20px" >Agregar archivo</button>
                                <input class="agregarArchivo" <?php echo('name="Archivo'.$row->IDCli.'"'); ?>  type="file" onchange="if(!this.value.length)return false; guardaArchivo(this);">
                                
                                <button class="btn btn-primary btn-xs contact-item" onclick="abrir(<?php echo($row->IDCli) ?>)">Ver documentos</button>
                                
								<a href="<?=base_url()?>callcenter/InsertaContactado?IDCL=<?php echo $row->IDCli?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Contactar</a>
                      
								<a href="<?=base_url()?>callcenter/LlamaCotizacion?IDCL=<?php echo $row->IDCli?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Cotizar</a>
                      
								<a href="<?=base_url()?>callcenter/VerificarPago?IDSIK=<?php echo $row->IDCliSikas?>&IDCL=<?php echo $row->IDCli?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Verificar Pago</a>
                            </td>
                      		-->
                            <td>
								<form action="<?=base_url();?>callcenter/asignaMailing"  method="post" id="formSeleccionarMailing">                          
		                            <?= selectMailing($mailings, $row->idMailing); ?>
									<input type="hidden" id="IDCli" name="IDCli" value="<?= $row->IDCli?>" />
								</form>
							</td>
                            <td>
                            	<input type="text" class="form-control" style="text-align: left;" value="<?= $row->Usuario; ?>" disabled="disabled"/>
								<form action="<?=base_url();?>callcenter/asignaUsuario"  method="post" id="formAsignarUsuario">
									<!-- <input type="text" onchange="filtrarBusqueda()" id="txtBuscarFiltro" class="form-control" style="text-align: left;"> -->
                                    
									<select class="form-control"  name="emailUsuario" id="emailUsuario" style="text-align: left;">
                                    	<option>-- Cambiar --</option>
										<?=imprimirSelecPersonas($personas);?>
									</select>
									<input type="hidden" id="IDCli" name="IDCli" value="<?= $row->IDCli?>" />
									<div align="right"><button class="btn btn-primary"><i class="fa fa-check"></i> Asignar</button></div>
								</form>
                            </td>
                            <td>
								<!-- <textarea name="historialCliente" readonly="readonly" id="historialCliente" class="form-control form-control-sm"> -->
	                            	<?= verHistorialCliente($historialClientes, $row->IDCli); ?>
									<div align="right">
										<button class="btn btn-primary btn-sm" onclick="nuevaNota()"><i class="fa fa-plus"></i> Nueva Nota</button> 
                                    </div>
								<!-- </textarea> -->
                            </td>
                            <td>
                            	<a href="callcenter/calificacionCliente/<?= $row->IDCli; ?>/1">
									<span class="glyphicon glyphicon-star"></span>
								</a>
                                
                            	<a href="callcenter/calificacionCliente/<?= $row->IDCli; ?>/2">
									<span class="glyphicon glyphicon-star"></span>
								</a>
                                
                            	<a href="callcenter/calificacionCliente/<?= $row->IDCli; ?>/3">
									<span class="glyphicon glyphicon-star"></span>
								</a>
                                
                            	<a href="callcenter/calificacionCliente/<?= $row->IDCli; ?>/4">
									<span class="glyphicon glyphicon-star"></span>
								</a>
                                
                            	<a href="callcenter/calificacionCliente/<?= $row->IDCli; ?>/5">
									<span class="glyphicon glyphicon-star"></span>
								</a>
                            </td>
                            <td>
                            
                            
                            
							  <form action="<?=base_url();?>callcenter/asignaStatus"  method="post" id="formSeleccionarStatus">                          
		                            <?= selectStatus($row->EstadoActual); ?>
									<input type="hidden" id="IDCli" name="IDCli" value="<?= $row->IDCli?>" />
								</form>
                                
                            <?
                            	$sqlEstaContactado= "
                                             select count(IDCliente) as numero from puntaje pj where pj.EdoActual='CONTACTADO' and pj.IDCliente ='".$row->IDCli."'
                                             ";

                                            $queryEstaContactado=$this->db->query($sqlEstaContactado);

                                            if(!empty($queryEstaContactado))
                                            { 
                                                  foreach ($queryEstaContactado->result() as $Registro) {   
                                                   $estacontactado=$Registro->numero;     
                                                   } 
                                            } 

                                             if($estacontactado>0)
                                             { 
                                              echo "Contactado"; 
                                             } 
											 
                                            $sqlEstaCotizado= "
                                             select count(IDCliente) as numero from puntaje pj where pj.EdoActual='COTIZADO' and pj.IDCliente ='".$row->IDCli."'
                                             ";

                                            $queryEstaCotizado=$this->db->query($sqlEstaCotizado);

                                            if(!empty($queryEstaCotizado))
                                            { 
                                                  foreach ($queryEstaCotizado->result() as $Registro) {   
                                                   $estacotizado=$Registro->numero;     
                                                   } 
                                            } 

                                             if($estacotizado>0)
                                             { 
                                                echo "Cotizado"; 
                                             }
                                            $sqlEstaPagado= "
                                             select count(IDCliente) as numero from puntaje pj where pj.EdoActual='PAGADO' and pj.IDCliente ='".$row->IDCli."'
                                             ";

                                            $queryPagado=$this->db->query($sqlEstaPagado);

                                            if(!empty($queryPagado))
                                            { 
                                                  foreach ($queryPagado->result() as $Registro) {   
                                                   $estapagado=$Registro->numero;     
                                                   } 
                                            } 

                                             if($estapagado>0)
                                             { 
                                                echo "Pagado"; 
                                             } 
							?>
                            </td>
                        <!--
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
                                            <td>
                                            <button class="btn btn-primary btn-xs contact-item" style="z-index: 0; height: 20px" >Agregar archivo</button>
                                              <input class="agregarArchivo" <?php echo('name="Archivo'.$row->IDCli.'"'); ?>  type="file" onchange="if(!this.value.length)return false; guardaArchivo(this);">
                                         
                                            </td>
                                            <td><button class="btn btn-primary btn-xs contact-item" onclick="abrir(<?php echo($row->IDCli) ?>)">Ver documentos</button></td>
                                            <td><?=$row->tipoSeguroSVS?></td>



                                           <td>
                                            <?php
                                            $sqlEstaContactado= "
                                             select count(IDCliente) as numero from puntaje pj where pj.EdoActual='CONTACTADO' and pj.IDCliente ='".$row->IDCli."'
                                             ";

                                            $queryEstaContactado=$this->db->query($sqlEstaContactado);

                                            if(!empty($queryEstaContactado))
                                            { 
                                                  foreach ($queryEstaContactado->result() as $Registro) {   
                                                   $estacontactado=$Registro->numero;     
                                                   } 
                                            } 

                                             if($estacontactado>0)
                                             { 
                                              echo "Contactado"; 
                                             } 
                                             else{ 
                                            ?>


                      <a href="<?=base_url()?>callcenter/InsertaContactado?IDCL=<?php echo $row->IDCli?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Contactar</a>
                                         </td>
                                         <?php  }  ?>
                                       <td>
                                         <?php
                                            $sqlEstaCotizado= "
                                             select count(IDCliente) as numero from puntaje pj where pj.EdoActual='COTIZADO' and pj.IDCliente ='".$row->IDCli."'
                                             ";

                                            $queryEstaCotizado=$this->db->query($sqlEstaCotizado);

                                            if(!empty($queryEstaCotizado))
                                            { 
                                                  foreach ($queryEstaCotizado->result() as $Registro) {   
                                                   $estacotizado=$Registro->numero;     
                                                   } 
                                            } 

                                             if($estacotizado>0)
                                             { 
                                                echo "Cotizado"; 
                                             } 
                                             else{ 
                                            ?>



                      <a href="<?=base_url()?>callcenter/LlamaCotizacion?IDCL=<?php echo $row->IDCli?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Cotizar</a>
                                          </td>
                                           <?php  }  ?>   


                                       <td>

                                        <?php
                                            $sqlEstaPagado= "
                                             select count(IDCliente) as numero from puntaje pj where pj.EdoActual='PAGADO' and pj.IDCliente ='".$row->IDCli."'
                                             ";

                                            $queryPagado=$this->db->query($sqlEstaPagado);

                                            if(!empty($queryPagado))
                                            { 
                                                  foreach ($queryPagado->result() as $Registro) {   
                                                   $estapagado=$Registro->numero;     
                                                   } 
                                            } 

                                             if($estapagado>0)
                                             { 
                                                echo "Pagado"; 
                                             } 
                                             else{ 
                                            ?>


                      <a href="<?=base_url()?>callcenter/VerificarPago?IDSIK=<?php echo $row->IDCliSikas?>&IDCL=<?php echo $row->IDCli?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Verificar Pago</a>
                                      </td> 
                        -->
                                       <?php  }  ?>  

										</tr>
							<?php
									}
								}
							?>

							</tbody>
                            <?
								if($totalResultados == 0){
							?>
                            <tfoot>
                            	<tr>
                                	<td colspan="4"><center><b>No se encontraron registros.</b></center></td>
                                </tr>
                            </tfoot>
                            <?
								}
							?>
						</table>
               		</div>

    <div id="DivFooterRow" style="overflow:hidden">
    </div>
</div>

 <div class="row">
             <div class="col-md-12"><medium><i>Total de resultados: <b><?=$totalResultados?></b></i></medium></div>
 </div>
</section>
  

  <div style="display: none;">
    <form name="formEnviarArchivo" enctype="multipart/form-data"
              method="post" id="formEnviarArchivo"
              action="<?=base_url()?>callcenter/guardarArchivo/">
    </form>
  </div>

<div id="miModalNota" >
    <div id="ModalcontenidoNota" class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Notas</h5>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<!-- <label for="notaTextarea1">Escriba la nota</label> -->
						<textarea class="form-control" id="notaTextarea1" rows="3"></textarea>
					</div>
                </form>
			</div>
			<div class="modal-footer">
        		<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarNota()">Cerrar</button>
        		<button type="button" class="btn btn-primary">Guardar</button>
			</div>
		</div>
    </div>
</div>


<div id="miModal" >
vfrewgfre
  <div id="Modalcontenido" class="modal-contenido"  >
  <table style="border:5px double #361866; width:360px; float:left; position:relative; top:-60px; left:-130px">
  <tr><td style="background-color:white">
    <button onclick="cerrar()" style="color: white;float:right;background-color:red; border:double; position:relative; top:0px">Cerrar</button>  
   </td>
  </tr>
  <tr>
  <td style="background-color:white">  
    <div id="muestraArchivosProspecto"></div>

   </td>

   </tr>
    </table> 
  </div> 

</div>



<div id="miModalCalendario" >
    <div id="ModalcontenidoCalendario" class="modal-contenidoCalendario"  >
      <table border="2"  style="position:relative; top:10px; left:0px">

      <tr><td>
          <button onclick="cerrarCalendario()" style="color: white;float:right;background-color:red; border:double;  ">Cerrar</button>  
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


<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.css' rel="stylesheet">
<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.print.min.css' rel="stylesheet" media='print'>
<script src='<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url();?>assets/fullcalendar/fullcalendar.min.js'></script>

<?php $this->load->view('footers/footer'); ?>

<script type="text/javascript">

function abrir(idProspecto){
	var params = "parametro=valor&otro_parametro=otro_valor";
	var req = new XMLHttpRequest();
	req.open('GET', '<?=base_url()?>callcenter/devuelveDocumentos/?idProspecto='+idProspecto, true);
	req.onreadystatechange = function(aEvt){
		if (req.readyState == 4) {
			if(req.status == 200){
			var j=JSON.parse(this.responseText);                                               
			document.getElementById('muestraArchivosProspecto').innerHTML=j;
			document.getElementById("miModal").classList.remove("modalCierra");
			document.getElementById("miModal").classList.add("modalAbre");
			document.getElementById("Modalcontenido").style.display="block";   
			}
		}
	};

	req.send();

}

function cerrar(){
	document.getElementById("miModal").classList.add("modalCierra");
	document.getElementById("miModal").classList.remove("modalAbre");
	document.getElementById("Modalcontenido").style.display="none";  
}

function guardaArchivo(objeto){  
	document.getElementById("formEnviarArchivo").appendChild(objeto);
	document.getElementById("formEnviarArchivo").submit();
}

function abrirCalendario(){
	document.getElementById("miModalCalendario").classList.remove("modalCierra");
	document.getElementById("miModalCalendario").classList.add("modalAbre");
	document.getElementById("ModalcontenidoCalendario").style.display="block";        
}

function cerrarCalendario(){
	document.getElementById("miModalCalendario").classList.add("modalCierra");
	document.getElementById("miModalCalendario").classList.remove("modalAbre");
	document.getElementById("ModalcontenidoCalendario").style.display="none";
}


function nuevaNota(){
	document.getElementById("miModalNota").classList.remove("modalCierra");
	document.getElementById("miModalNota").classList.add("modalAbre");
	document.getElementById("ModalcontenidoNota").style.display="block";        
}

function cerrarNota(){
	document.getElementById("miModalNota").classList.add("modalCierra");
	document.getElementById("miModalNota").classList.remove("modalAbre");
	document.getElementById("ModalcontenidoNota").style.display="none";
}
 //cerrar();
 //cerrarCalendario();
 //abrirCalendario(); 

</script>
<style>
	.modal-contenido{
		background-color:none;
		width:100px;
		height:100%;
		padding: 5% 10%;
		margin: 10% auto;
		position:relative;
		z-index:1000 
	}
	.modalCierra{
		background-color: rgba(0,0,0,.8);
		position:fixed;
		top:0px;
		right:0px;
		bottom:0px;
		left:0px;
		opacity:0;
		transition: all 1s;
		display:none;relative;z-index: 1000
	}
	.modalAbre{
		background-color: rgba(0,0,0,.8);
		position:fixed;
		top:0px;
		right:0px;
		bottom:0px;
		left:0px;
		transition: all 1s;
		width:100%;
		height:100%;
		display:block;
		relative;z-index:1000
	}
	
.agregarArchivo{opacity: 0; z-index: 100 ;width: 100px; position:  relative; top:-20px; }
.agregarArchivo:hover {cursor: move;}

.modal-contenidoCalendario{background-color:white;width:500px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modalCierraCalendario{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbreCalendario{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}

	.modal-contenidoNota{
		background-color:white;
		width:500px;
		height:50%;
		padding: 5% 5%;
		margin: 5% auto;
		position: relative;
		z-index: 1000 
	}
.modalCierraNota{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbreNota{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
</style>

<script type="text/javascript">

function filtrarBusqueda(){
	var busqueda	=document.getElementById('idPersonas');
	var filtro		=document.getElementById('txtBuscarFiltro').value.toUpperCase();
	var contador	=busqueda.length;
	var text		="";
	
	for(var j=2;j<contador;j++){
		text=busqueda[j].innerHTML;
		if(text.indexOf(filtro)>=0){
			busqueda[j].classList.add('verElemento');busqueda[j].classList.remove('ocultarElemento');
		} else { 
			busqueda[j].classList.add('ocultarElemento'); busqueda[j].classList.remove('verElemento');
		}
	}
}


$(document).ready(function(){

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


</script>

<script type="text/javascript">
  
function guardaCita(){
	var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=<?php echo('"'.base_url().'callcenter/guardaCita"'); ?>;
	var inputFI=document.createElement('input'); inputFI.setAttribute('type','text');inputFI.setAttribute('name','fecIniCita'); inputFI.value=document.getElementById('selFecIniCita').value;
	var inputFF=document.createElement('input'); inputFF.setAttribute('type','text');inputFF.setAttribute('name','fecFinCita'); inputFF.value=document.getElementById('selFecFinCita').value;
	var inputF=document.createElement('input'); inputF.setAttribute('type','text');inputF.setAttribute('name','fecCita'); inputF.value=document.getElementById('dpCita').value;
	var inputT=document.createElement('input'); inputT.setAttribute('type','text');inputT.setAttribute('name','tituloCita'); inputT.value=document.getElementById('tituloCita').value;


formulario.appendChild(inputFI);
formulario.appendChild(inputFF);
formulario.appendChild(inputF);
formulario.appendChild(inputT);

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
     if (document.getElementById("divVentanaComentarios")){document.body.removeChild(document.getElementById('divVentanaComentarios'));}
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

function validarFormulario(){
	var nom	= document.getElementById('nombre').value;
    var ap	= document.getElementById('apellidop').value;
    var am	= document.getElementById('apellidom').value;
	var raz = document.getElementById('razon').value;
    var rfc = document.getElementById('rfc').value;
	var ema = document.getElementById('email').value;
	var cel = document.getElementById('celular').value;

	if(document.getElementById('tipo').checked ){
		if(raz !='' && rfc!=''  && ema!='' && cel!=''){
			this.form.submit();                  
		} else {
			alert('No capturaste Razon y RFC y Es Obligatorio Email y Telefono');
		} 
                 
	}

	if(document.getElementById('tipo2').checked ){
		if(nom !='' && ap!=''  && ema!='' && cel!=''){
			this.form.submit();
                 
		} else {
			alert('No capturaste Nombre o Apellidos, Es Obligatorio Email y Telefono');
		} 
	}
}
		<!-- -->
		$(".selector-tipoNewCliente select").change(function(){
			var tipo_documento = document.getElementById('tipo_cliente');
			var uno		= document.getElementById('uno');
			var dos		= document.getElementById('dos');
			var tres	= document.getElementById('tres');
			var cuatro	= document.getElementById('cuatro');
			
			if(tipo_cliente.value == "Moral"){
				// alert("Factura");
				uno.style.display		= 'block';
				dos.style.display		= 'none';
				tres.style.display		= 'block';
				cuatro.style.display	= 'block';
			} else if(tipo_cliente.value == "Fisica"){
				// alert("Nota");
				uno.style.display		= 'none';
				dos.style.display		= 'block';
				tres.style.display		= 'block';
				cuatro.style.display	= 'block';
			} else {
				// Esta Vacio el Valor
				uno.style.display		= 'none';
				dos.style.display		= 'none';
				tres.style.display		= 'none';
				cuatro.style.display	= 'none';
			}

		});
	function usuarioClient(emailUsuarioNew, id, mensaje){

	}
	
	function estadoCient(idClient, estado){

	}
	
	function mailingClient(idClient, mailing){
	}
	
	
</script>
<?
function imprimirSelecPersonas($datos){
  
  $option='';
  foreach ($datos as $key1 => $value1) 
  {
  
    $option.='<optgroup label="'.$key1.'">';
    foreach ($value1 as $key => $value) 
    {
     $nombres=$value->apellidoPaterno.' '.$value->apellidoMaterno.' '.$value->nombres;
   $option.='<option value="'.$value->email.'">'.$nombres.' <label>     ('.$value->email.')</label></option>';  
    }
    $option.='</optgroup>';
  
  }
  return $option;

}

function verHistorialCliente($datos, $IDCli){
	
	$infoHistorial	= "";
	foreach($datos as $row){
		if($row->IDCli == $IDCli){
			$infoHistorial.= ' '.$row->fecha.'<br />';			
			$infoHistorial.= '&bull; '.$row->informacion.'<br />';
			$infoHistorial.= '&macr;&macr;&macr;&macr;&macr;&macr;&macr;&macr;&macr;&macr;&macr;&macr;&macr;&macr;&macr;&macr;<br />';
		}
	}
	
	return
		$infoHistorial;
}

function selectMailing($mailings, $idMailing){
	
	$return	= "";
	
	$return.= '<select class="form-control"  name="campaignEmail" id="campaignEmail" style="text-align: left;" onchange="this.form.submit()">';
	$return.= '<option value="0">-- Seleccionar --</option>';	
	foreach($mailings as $mailing){
		if($idMailing == $mailing->idMailing){ 
			$selected = "selected";
		} else {
			$selected = "";
		}
		$return.= '<option value="'.$mailing->idMailing.'" '.$selected.'>'.$mailing->nombre.'</option>';
	}
	$return.= '</select>';
			
	return
		$return;	  
}

function selectStatus($status){
	$return = "";
	
	$options['NUEVO']		= "DIMENSION";
	$options['ENPROGRESO']	= "EN PROGRESO";
	$options['COTIZACION']	= "EN COTIZACION";
	$options['SINVENTA']	= "SIN VENTA";
	$options['CONVENTA']	= "CON VENTA";
	
	$return.= '<select class="form-control"  name="statusCliente" id="statusCliente" style="text-align: left;" onchange="this.form.submit()">';
	
	foreach($options as $option){
		
		if($status == $option){ 
			$selected = "selected";
		} else {
			$selected = "";
		}
		
		$return.= '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
		
	}	
	$return.= '</select>';
			
	return
		$return;	  
	
}
?>
