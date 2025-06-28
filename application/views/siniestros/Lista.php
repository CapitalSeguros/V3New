<?php 
	$this->load->view('headers/header'); 
  $this->load->view('headers/headerReportes'); 
?>
<?php
	$this->load->view('headers/menu');	
?>
<style>
.caja2 {
position: relative;
width: 200px;
margin: 10px auto;
background-color:
}
.caja2 img {
background-color:#036;
position: relative;
z-index:2; /*Imagen apilada en segunda posición*/
border: 1px solid #333;
box-shadow: 1px 1px 4px #333;
width:0px;
height:0px;
opacity:0px;
visibility:hidden
}
.disco {
position: absolute;
top:0;
left:0px;
z-index:1;
display:block;
width: 100px;
height:100px;
background:url("") no-repeat scroll center center transparent;
-moz-transition:all linear 0.5s 0s;
-webkit-transition:all linear 0.5s 0s;
transition:all ease 0.5s 0s;
opacity:0px

}

.caja2:hover .disco {
    visibility:visible
left:100px; /*Para hacer "salir" parcialmente el disco*/
-moz-transform:rotate(0deg); /*Y además lo hace girando*/
-webkit-transform:rotate(0deg);
transform:rotate(0deg);
width:1000px;
height:150px;
visibility:visible
}

/*
html,body { 
 overflow-x: hidden;
  overflow-y: hidden;
}
*/
.mostar{display:block; visibility:visible;}
.ocultar{display:none;visibility:hidden}

</style>
	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Reportes</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
	                <li><a href="./">Inicio</a></li>
                    <li class="active"><a>Consulta de siniestros</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>
    
	<section class="container-fluid"><!-- container-fluid -->
		<div class="row">      
		</div><!-- /row -->
        
		<div class="panel panel-default">
			<div class="panel-body">

<div  style=" overflow:scroll;height: 400px" >
	<!-- TABLA INICIA -->
	<table id="tabla" class="table table-striped">
		<thead>
			<tr>
				<!--<th>ID</th>-->
				<th style="width:30px">Fecha Alta</th>
				<!--
				<th style="width:35px">Oficina</th>
				<th style="width:90px">Sucursal</th>
				<th style="width:80px">Canal</th>
				<th style="width:80px">Tipo CRM</th>
				-->
				<th style="width:90px">Tipo Tramite</th>
            <th style="width:80px">Estado Siniestro</th>
            <th style="width:50px">Nombre Completo</th>
            <th style="width:40px">Email</th>
             <th style="width:15px">Telefono</th>
            <th style="width:50px">Referencia</th>
            <th style="width:90px">Usuario</th>
        </tr>
		</thead>
		<tbody>
			<?
            	foreach ($rsiniestros as $value){ 
			?>
			<tr>
				<!-- <td><span class="enlace" title="autos2.png"><?php echo $value->Oficina; ?></span></td>-->
				<!-- <img border="0" src="<?php echo base_url(); ?>assets/img/autos2.png" class="expando" width="100" />-->        
				<td><?php echo $value->FechaAlta; ?></td>
				<!-- <td><?php echo $value->Oficina; ?></td>
                        <td><?php echo $value->Sucursal; ?></td>
                        <td><?php echo $value->Canal; ?></td>
                        <td><?php echo $value->tipoCrm; ?></td>-->
                        <td><?php echo $value->TipoTramite; ?></td>
                        <td><?php 
                            
				if($value->TipoTramite=="AUTOS ASISTENCIA VIAL"){ //1
                            $denominador="3";
                            if($value->orden=='1')
                                $rutaimagen="assets/img/siniestros/autosasistenciavial13.jpg";
                            if($value->orden=='2')
                                $rutaimagen="assets/img/siniestros/autosasistenciavial23.jpg";
                            if($value->orden=='3')
                                $rutaimagen="assets/img/siniestros/autosasistenciavial33.jpg";                             
				}
				
				if($value->TipoTramite=="AUTOS PAGO DE DAÑOS"){ //2
					$denominador="5";
					if($value->orden=='1')
						$rutaimagen="assets/img/siniestros/autospagodaños15.jpg";
                            if($value->orden=='2')
                                $rutaimagen="assets/img/siniestros/autospagodaños25.jpg";
                            if($value->orden=='3')
                                $rutaimagen="assets/img/siniestros/autospagodaños35.jpg";
                            if($value->orden=='4')
                                $rutaimagen="assets/img/siniestros/autospagodaños45.jpg";
                            if($value->orden=='5')
                                $rutaimagen="assets/img/siniestros/autospagodaños55.jpg";
				}   
                        if($value->TipoTramite=="AUTOS PAGO DE TERCEROS")   //3
                        {    
                             $denominador="5";
                            if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/autospagoterceros15.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/autospagoterceros25.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/autospagoterceros35.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/autospagoterceros45.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/autospagoterceros55.jpg";

                        }   
                        if($value->TipoTramite=="AUTOS PERDIDA TOTAL")  //4
                        {    
                            $denominador="5";
                            if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/autosperdidatotal15.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/autosperdidatotal25.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/autosperdidatotal35.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/autosperdidatotal45.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/autosperdidatotal55.jpg";

                        }   
                        if($value->TipoTramite=="AUTOS REPARACION") //5
                        {  
                            $denominador="7";
                            if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/autosreparacion17.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/autosreparacion27.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/autosreparacion37.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/autosreparacion47.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/autosreparacion57.jpg";
                            if($value->orden=='6')
                             $rutaimagen="assets/img/siniestros/autosreparacion67.jpg";
                            if($value->orden=='7')
                             $rutaimagen="assets/img/siniestros/autosreparacion77.jpg";
                        }   
                        if($value->TipoTramite=="AUTOS ROBO TOTAL") //6
                        {   
                            $denominador="5";
                            if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/autosrobototal15.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/autosrobototal25.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/autosrobototal35.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/autosrobototal45.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/autosrobototal55.jpg";

                        }   
                        if($value->TipoTramite=="GMM PRIMER RECLAMACION REEMBOLSO") //7
                        {    
                             $denominador="6";
                            if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/gmmprimerreclamacionreembolso16.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/gmmprimerreclamacionreembolso26.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/gmmprimerreclamacionreembolso36.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/gmmprimerreclamacionreembolso46.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/gmmprimerreclamacionreembolso56.jpg";
                            if($value->orden=='6')
                             $rutaimagen="assets/img/siniestros/gmmprimerreclamacionreembolso66.jpg";
                        }   
                        if($value->TipoTramite=="GMM REEMBOLSO SUBSECUENTE")    //8
                        {    
                            $denominador="6";
                             if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/gmmreembolsosubsecuente16.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/gmmreembolsosubsecuente26.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/gmmreembolsosubsecuente36.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/gmmreembolsosubsecuente46.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/gmmreembolsosubsecuente56.jpg";
                            if($value->orden=='6')
                             $rutaimagen="assets/img/siniestros/gmmreembolsosubsecuente66.jpg";
                             
                        }   
                        if($value->TipoTramite=="GMM PROGRAMACION DE CIRUGIA")  //9
                        {    
                             $denominador="6";
                             if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/gmmprogramaciondecirugia16.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/gmmprogramaciondecirugia26.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/gmmprogramaciondecirugia36.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/gmmprogramaciondecirugia46.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/gmmprogramaciondecirugia56.jpg";
                            if($value->orden=='6')
                             $rutaimagen="assets/img/siniestros/gmmprogramaciondecirugia66.jpg";
                        }   
                        if($value->TipoTramite=="GMM PAGO DIRECTO") //10
                        {    
                             $denominador="3";
                             if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/gmmpagodirecto13.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/gmmpagodirecto23.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/gmmpagodirecto33.jpg";
                            
                        }   
                        if($value->TipoTramite=="DAÑOS EMPRESARIAL REEMBOLSO")  //11
                        {    
                             $denominador="5";
                             if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreembolso15.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreembolso25.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreembolso35.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreembolso45.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreembolso55.jpg";
                        }   
                        if($value->TipoTramite=="DAÑOS EMPRESARIAL REPARACION") //12
                        {     
                            $denominador="7";
                            if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreparacion17.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreparacion27.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreparacion37.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreparacion47.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreparacion57.jpg";
                            if($value->orden=='6')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreparacion67.jpg";
                            if($value->orden=='7')
                             $rutaimagen="assets/img/siniestros/dañosempresarialreparacion77.jpg";
                        }   
                        if($value->TipoTramite=="DAÑOS EMPRESARIAL ROBO")   //13
                        {    
                            $denominador="5";
                            if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/dañosempresarialrobo15.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/dañosempresarialrobo25.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/dañosempresarialrobo35.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/dañosempresarialrobo45.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/dañosempresarialrobo55.jpg";
                        }   
                        if($value->TipoTramite=="DAÑOS CASA HABITACION REEMBOLSO")  //14
                        {    $denominador="5";
                             if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreembolso15.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreembolso25.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreembolso35.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreembolso45.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreembolso55.jpg";
                        }   
                        if($value->TipoTramite=="DAÑOS CASA HABITACION REPARACION") //15
                        {    
                            $denominador="7";
                             if($value->orden=='1')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreparacion17.jpg";
                            if($value->orden=='2')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreparacion27.jpg";
                            if($value->orden=='3')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreparacion37.jpg";
                            if($value->orden=='4')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreparacion47.jpg";
                            if($value->orden=='5')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreparacion57.jpg";
                            if($value->orden=='6')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreparacion67.jpg";
                            if($value->orden=='7')
                             $rutaimagen="assets/img/siniestros/dañoscasahabitacionreparacion77.jpg";
                        }   

                    ?>
					<div class="caja2">
                    	<label  class="caja2" >
                        	<img src="<?= base_url(); echo $rutaimagen; ?>" class="disco">
                        	<?= $value->EstadoSiniestro." ".$value->orden."/".$denominador; ?>
						</label>
					</div>
				</td>
				<td><?= $value->NombreCompleto; ?></td>
				<td><?= $value->email; ?></td>
				<td><?= $value->telefono; ?></td>
				<td><?= $value->referencia; ?></td>
				<td><?= $value->Usuario; ?></td>
			</tr>     
			<?php       
				}
			?>
		</tbody>
	</table> 
	<!-- TABLA finaliza -->
</div>

            </div><!-- panel-body -->
		</div><!-- panel-default -->
	</section><!-- /container-fluid -->

<script>

var textbuscar = document.getElementById("buscar");
textbuscar.onkeyup = function(){
    buscar(this);
}

    var tabla_tr = document.getElementById("tabla").getElementsByTagName("tbody")[0].rows;
    for(var i=0; i<tabla_tr.length; i++){
        var tr = tabla_tr[i];
        var textotr = (tr.innerText).toLowerCase();
       // tr.className ="ocultar";
    }

function buscar(inputbuscar){
    var valorabuscar = (inputbuscar.value).toLowerCase().trim();
    var tabla_tr = document.getElementById("tabla").getElementsByTagName("tbody")[0].rows;
    if(tabla_tr.length>0){
    for(var i=0; i<tabla_tr.length; i++){
        var tr = tabla_tr[i];
        var textotr = (tr.innerText).toLowerCase();
        tr.className = (textotr.indexOf(valorabuscar)>=0)?"mostrar":"ocultar";
    }
    }
}
</script>
<?php 
	$this->load->view('footers/footer'); 
?>