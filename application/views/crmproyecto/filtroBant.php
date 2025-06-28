<?
	
    $this->load->model('crmproyecto_model');
	function estado($estado){
		if($estado=="DIMENSION"){$estado="SUSPECTO";}
		if($estado=="REGISTRADO"){$estado="CONTACTADO";}
		return $estado;
	}
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <style type="text/css">
  .tableP100{width: 100%; height: 300px; overflow: scroll;}
  .tableP100 thead {color: white; background-color: #361866 }
  .tableP100 >thead >tr>th {border: solid black;width: 300px}
 .tableP100 >tbody >tr>td {border: solid black 1px; margin:5em; ;width: 300px}
 .divContTabla{/*height: 400px; width: 100%;overflow: scroll;*/}
 #Mitabla{
 	font-size: 10px;
 }
 .wrap{
	width: 100%;
	display: flex;
  color: white;
  background-color: #363636;
  justify-content: space-between;

}
.wrap a,button{color:white;}
.wrap button{border: none;padding: 3px;background-color: #363636;}
.wrap a:hover:hover{background-color: #0984cc}
.wrap button:hover{background-color: #0984cc}
ul.tabs{
	width: 100%;
	background: #363636;
	list-style: none;
	display: flex;
}
ul.tabs li{	width: 20%;}
ul.tabs li a,button{
	color: #fff;
	text-decoration: none;
	font-size: 11px;
	text-align: center;
	display: block;
	padding: 7px 0px;
}
.active{background: #0984CC;}
ul.tabs li a:hover{background: #0984CC;}
ul.tabs li>form> button:hover{background: #0984CC;}
ul.tabs li a .tab-text{margin-left: 0px;}

</style>


<table class="table" id='Mitabla'>
	<thead>
		<tr style="font-size: 11px;">
			<th></th>
        	<th>ID</th>
        	<th style="text-align: center;"><i class="fa fa-calendar"></i></th>
        	<th>RazonSocial</th>	
			<th>ApellidoP</th>                        
			<th>Nombre</th>
			<th>Estado Actual</th>
			<th style="text-align: center;">Authorithy&nbsp;&nbsp;</th>
			<th style="text-align: center;">Need</th>
			<th style="text-align: center;">Timing</th>
			<th style="text-align: center;"><i class="fa fa-comment"></i></th>
			<th style="text-align: center;"><i class="fa fa-cogs"></i></th>
			<th style="text-align: center;">Guardar Cita</th>
			<th style="text-align: center;">Detección necesidades</i></th>
			<th style="text-align: center;"><i class="fa fa-cogs"></i></th>
			<th style="text-align: center;"><i class="fa fa-paperclip"></i>&nbsp;Entrega propuesta</th>
			<th style="text-align: center;"><i class="fa fa-file-text"></i></th>
			<th>Pagado</th>			
		</tr>
	</thead>
	<tbody>   
		<? 
         $prospectoCount=0;$suspectoCount=0;$perfiladosCount=0;$cotizadosCount=0;$emisionCount=0;$pagadosCount=0;
		if($ListaClientes != FALSE){ ?>
		<tr style="background-color:#ebe6e6"><td onclick="abrirCerrar(this,'HOY')">►</td><td colspan="15">HOY</td></tr>
		<? $cont=0;$nombrePestania="";$prospectosEnEmision="";
     $nombrePestania="HOY";
     
     	foreach ($ListaClientes as $row)
     	{

     		$prospectoCount++;
     	if($row->estaEmitido==0){									
		if($nombrePestania!=$row->pestania){?>
			<tr style="background-color:#ebe6e6"><td onclick="abrirCerrar(this,'<?= $row->pestania?>')">►</td><td colspan="15"><?= $row->pestania; ?></td></tr> <?}$nombrePestania=$row->pestania;?>
		<?php if ($row->tipo_prospecto==0){ ?>
		<tr class="<?= $row->pestania;?> ocultarObjeto">
			
			<td style="text-align: center;">
				<?php $fecha=date("Y-m-d", strtotime($row->fechaCreacionCA));?>
				<a href="#" onclick="verDetalle(this,'<?=$row->RFC?>','<?=$row->RazonSocial?>','<?=$row->Nombre?>','<?=$row->ApellidoP?>','<?=$row->ApellidoM?>','<?=$row->EMail1?>','<?=$row->Telefono1?>','<?php echo $fecha;?>','<?=$row->EstadoActual;?>','<?php echo preg_replace('/[\r\n]+/',  '',$row->observacion);?>')"><i class="fa fa-eye"></i></a>
			</td>
			<td style="text-align: center;"><input type="checkbox" class="cbReasignar" value="<?=$row->IDCli?>"></button></td> 
			<td><?php if($row->fechaCreacionCA!=null){echo(date("Y-m-d", strtotime($row->fechaCreacionCA)));} ?></td>								
			<td><?=$row->RazonSocial?></td>
			<td><?=$row->ApellidoP?></td>								
			<td><?=$row->Nombre?></td>																							
			<?
			
               switch ($row->EstadoActual) 
               {
               	case 'DIMENSION':$suspectoCount++;break;
               	case 'PAGADO':$pagadosCount++;break;
               	case 'PERFILADO':$perfiladosCount++;break;
               	case 'COTIZADO':$cotizadosCount++;break;
               }
			?>															
			<td><span class="badge badge-secondary" style="font-size: 11px;font-weight: normal;"><? echo estado($row->EstadoActual);?></span></td>

			<td style="text-align: center;">
				<span class="badge badge-warning" style="font-size: 11px;font-weight: normal;background-color: orange;color: black;">
				<?php echo $row->bant_aut?>
				</span>
			</td>

			<td style="text-align: center;">
				<span class="badge badge-warning" style="font-size: 11px;font-weight: normal;background-color: orange;color: black;">
				<?php echo $row->bant_need?>
				</span>
			</td>

			<td style="text-align: center;">
				<span class="badge badge-warning" style="font-size: 11px;font-weight: normal;background-color: orange;color: black;">
				<?php echo $row->bant_timing?>
				</span>
			</td>


			<td style="text-align: center;"><button onclick="direccionAJAX(<?=$row->IDCli?>,'muestraVentana')" class="btn btn-primary btn-xs ">Comentarios</button></td>
			<td>
            	<?
					$sqlEstaPerfilado = "select count(IDCliente) as numero from puntaje pj where pj.EdoActual = 'PERFILADO' and pj.IDCliente = '".$row->IDCli."'";
					$queryEstaPerfilado=$this->db->query($sqlEstaPerfilado);
					if(!empty($queryEstaPerfilado)){foreach ($queryEstaPerfilado->result() as $Registro) {$estaperfilado=$Registro->numero; }}
					if($estaperfilado>0){ echo "Perfilado"; } 
					else {
        		?>         
				<button class="btn btn-primary btn-xs" onclick="perfilarProspecto(this,<?=$row->IDCli?>)" style="background-color: #01A9DB;">Perfilar</button>
        		<? } ?> 
			</td>

			<td style="text-align: center;"><button onclick="direccionAJAX(<?=$row->IDCli?>,'ventanaCCC')" class="btn btn-primary btn-xs" style="background-color: #01A9DB;">Contacto</button></td>
			<td style="text-align: center;">
				<a href="<?= base_url()?>crmproyecto/deteccion_necesidades?IDCL=<?= $row->IDCli?>" class='btn btn-primary btn-xs contact-item' target="_blank" style="background-color: #01A9DB;">1er Cita
				</a>
            </td>

			<td>
            	<?
					$sqlEstaCotizado = "Select count(IDCliente) as numero From puntaje pj Where pj.EdoActual='COTIZADO' and pj.IDCliente ='".$row->IDCli."'";
					$queryEstaCotizado = $this->db->query($sqlEstaCotizado);
					if(!empty($queryEstaCotizado)){foreach ($queryEstaCotizado->result() as $Registro){$estacotizado=$Registro->numero;}}
					if($estacotizado>0){
						if($row->folioActividad==''){echo "Cotizado"; }
					   else{echo '<a href="'.base_url().'actividades/ver/'.$row->folioActividad.'" target="_blank"><button class="btn btn-success btn-xs contact-item">Emitir</button</a>';
					   } 
					} 
					else { 
            	?>


<!--Modificacion MJ 21-07-2021 -->
	<?php
	$fianzas=$row->leads;
	if($fianzas=="http://www.fianzascapital.com.mx"){?>

            <a href="#" onclick="cargarPagina1('crmproyecto/CotizacionFianzas',<?= $row->IDCli?>)" class='btn btn-primary btn-xs contact-item'  data-original-title  style="background-color: #01A9DB;"><span class="glyphicon glyphicon-pencil"></span>Cotizador Express
			</a>

			<a href="<?= base_url()."actividades/actividadNuevaProspeccion?IDCL=".$row->IDCli."&SelectRamo=FIANZAS&SelectSubRamo=70"?>" target="_blank" class='btn btn-primary btn-xs contact-item' data-original-title  style="background-color:#01A9DB;">
            <span class="glyphicon glyphicon-pencil"></span>Cotizar
                </a>
<?php }else{?>
					<a href="<?= base_url()?>actividades/actividadNuevaProspeccion?IDCL=<?= $row->IDCli?>" target="_blank" class='btn btn-primary btn-xs contact-item' data-original-title  style="background-color: #01A9DB;"><span class="glyphicon glyphicon-pencil"></span>Cotizar
                </a>
            	<? } 
            		} ?> 
<!-- fin Modificaciones-->
			</td>

			<td style="text-align: center;">
				<a href="#"  onclick="direccionAJAX(<?=$row->IDCli?>,'ventanaCCC')">
				<button class="btn btn-primary btn-xs" style="background-color: #01A9DB;">2da Cita</button>
				</a>
			</td>

			<td style="text-align: center;"><button onclick="traerDocumentos('',<?=$row->IDCli?>,'<?=$row->IDCliSikas?>')" class="btn btn-primary btn-xs ">VER COTIZACION</button>
			</td>
			
			<td>

			<td>
				<?
					$sqlEstaPagado = "Select count(IDCliente) as numero From puntaje pj Where pj.EdoActual='PAGADO' and pj.IDCliente ='".$row->IDCli."'";
					$queryPagado = $this->db->query($sqlEstaPagado);
					if(!empty($queryPagado)){foreach($queryPagado->result() as $Registro){$estapagado = $Registro->numero;}}
					if($estapagado>0){echo "Pagado"; } 
					else { 
						if($row->folioActividad!=''){
				?>
              
                	<div class="btn-group" style="overflow: all;width: 200px">
				<?php if($row->Documento==''){?>
				<button class="btn btn-primary btn-xs contact-item" onclick="verificarPago('','<?= $row->folioActividad; ?>',<?= $row->IDCli; ?>,this)">Verificar pago</button>
				<?php }
                   else{ if($row->pagado==1){
                    ?>
                     <a class="btn btn-primary btn-xs contact-item" href="<?= base_url()?>crmproyecto/muestraRecibos?Documento=<?=$row->Documento?>" target="_blank">Recibos<span class="badge">✔</span></a> 
                    <?php
                   	  }
                   	  else{ ?>
<button class="btn btn-primary btn-xs contact-item" onclick="verificarPago('','<?= $row->folioActividad; ?>',<?= $row->IDCli; ?>,this)">Verificar pago</button> 
                     <a class="btn btn-primary btn-xs contact-item" href="<?= base_url()?>crmproyecto/muestraRecibos?Documento=<?=$row->Documento?>" target="_blank">Recibos<span class="badge">X</span></a>
                   	  	<?php
                   	  }
                   }
				?>
    	    	<? }

    	    } ?> 
    	</div>
			</td>
		</tr>
		<?
				}
			}
			}
		}
		?>
		<tr style="background-color:green"><td onclick="abrirCerrar(this,'PROSPECTOSEMISION')"></td><td colspan="15">EN EMISION</td></tr>
	</tbody>
	<?
	     $etiquetaResultados='<center><b>No se encontraron registros.</b></center>';
		if($totalResultados != 0){$etiquetaResultados='<medium><i>Total de resultados: <b>'.$totalResultados.'</b></i></medium>';}
	?>
	<tfoot>
		<tr><td colspan="13"><?=$etiquetaResultados;?></td></tr>
		<tr><td>Filtro para buscar pagados:</td><td>Fecha Inicial:<input type="date" id="fInicialProspectoEmitido" value="<?=$primerDiaMes?>"></td><td>Fecha Final:<input type="date" id="fFinalProspectoEmitido" value="<?=$fechaActual?>"></td><td><button class="btn btn-success"  onclick="buscarProspectosEmitidos('')">&#128270</button></td></tr>
		<tr><td id="tdMuestraPropectosPagados"></td></tr>
    <tr id='trTotalProscpectos'><td><?=$prospectoCount?></td><td><?=$suspectoCount?></td><td><?=$perfiladosCount?></td><td><?=$cotizadosCount?></td><td><?=$pagadosCount?></td></tr>
	</tfoot>

</table>


<?php
function imprimirPuntosMeses($datosActuales,$datosAnteriores)
{
  $cadena='';
  foreach ($datosActuales as $key => $value) 
  {
     $estapagado='';
  	if($value['estaPagado']>0){$estapagado='&#9989';}
  	$cadena.='<div class="contenedorPuntosDiv"><div>'.$value['mes'].'</div><div>'.$value['anio'].'</div><div>'.$value['puntos'].'</div><div style="border-radius:50% solid black">'.$estapagado.'</div></div>';
  }


  foreach ($datosAnteriores as $key => $value) 
  {
     $estapagado='';
  	if($value['estaPagado']>0){$estapagado='&#9989';}
  	$cadena.='<div class="contenedorPuntosDiv"><div>'.$value['mes'].'</div><div>'.$value['anio'].'</div><div>'.$value['puntos'].'</div><div style="border-radius:50% solid black">'.$estapagado.'</div></div>';
  }

  return $cadena;
}
function imprimirSelecPersonas($datos,$email)
{
  
  $option='<optgroup label=""><option data-value="0" value="">Escoger Vendedor</option></optgroup>';
  $selected='';
  foreach ($datos as $key1 => $value1) 
  {
  
    $option.='<optgroup label="'.$key1.'">';
    foreach ($value1 as $key => $value) 
    {
    	if($value->email==$email){$selected='selected="selected"';}
     $nombres=$value->apellidoPaterno.' '.$value->apellidoMaterno.' '.$value->nombres;
   $option.='<option data-value="'.$value->idPersona.'" value="'.$value->email.'" '.$selected.'>'.$nombres.' <label>     ('.$value->email.')</label></option>';  
      $selected='';
    }
    $option.='</optgroup>';
  
  }
  return $option;

}
?>
<style type="text/css">
 .tableMayaMX{display: block;width: 100%;}
 .tableMayaMX > thead{display: block;overflow-x: hidden;/*height: 40px;overflow-y: scroll;*/}
 .tableMayaMX>tbody { display:block	;height: 300px;overflow:scroll}
 .tableMayaMX> tbody,thead{width: 900px;} 
 .tableMayaMX > thead>tr>th{min-width: 150px}
 .tableMayaMX > tbody>tr>td{min-width: 150px}	
.iconojpg{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconojpj.png') ;?>) no-repeat;}
.iconopdf{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconopdf.png') ;?>) no-repeat;}
.iconoword{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoword.png') ;?>) no-repeat;}
.iconoxls{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoxls.png') ;?>) no-repeat;}
.iconoxml{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoxml.png') ;?>) no-repeat;}
.iconomsg{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconomsg.png') ;?>) no-repeat;}
.iconoblanco{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoblanco.png') ;?>) no-repeat;}
.iconoemail{width: 25px; height:25px;background: url(<?echo(base_url().'assets/images/iconoEmail.png') ;?>) no-repeat;}
.iconogenerico > a{position: relative;left: 35px;  display: flex;align-items: center; text-decoration: underline;}
.ulDocumentos{list-style-type: none;width: 100%;height: 300px;overflow: scroll; }

</style>
