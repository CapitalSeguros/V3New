<?php 
$diaActual=date('d');
$mesActual=date('m');
$anioActual=date('Y');

function get_nombre_dia($fecha){
   $fechats = strtotime($fecha); 
	switch (date('w', $fechats)){
	    case 0: return "Dom"; break;
	    case 1: return "Lun"; break;
	    case 2: return "Mar"; break;
	    case 3: return "Mie"; break;
	    case 4: return "Jue"; break;
	    case 5: return "Vie"; break;
	    case 6: return "Sab"; break;
	}
}
$meses=array('','ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
for($mes=1;$mes<13;$mes++){
	$acumPuntualidad=0;
	$acumCambio=0;
	$acumPrestamo=0;
	$acumVacaciones=0;
	$acumCapacitacion=0;
	$acumCalificacion=0;
	$acumPermisos=0;
	$acumIncapacidad=0;
	$acumSueldos=0;
	$acumAsistencia=0;
	$limite=32;
	switch($mes){
		case 2:
			$limite=29;
		break;
		case 4:
			$limite=31;
		break;
		case 6:
			$limite=31;
		break;
		case 9:
			$limite=31;
		break;
		case 11:
			$limite=31;
		break;
	}
?>
<div style="padding: 1%;width: 100%;margin-left: -10%;">
<table class="table table-bordered table-hover table-condensed">
	<!--Puntualidad-->
	<tr>
		<td colspan="<?php echo $limite+4?>" style="background-color: #361666;color: #fff;text-align: center;font-size: 12px;font-weight: bold;">
			<?php echo $anio;?>
		</td>
	</tr>
	<tr style="background-color: #f2f2f2;text-align: center;">
		<td></td>
		<?php 
		for($dia=1;$dia<$limite;$dia++){?>
			<td><div class="diax"><?php echo get_nombre_dia($anio.'/'.$mes.'/'.$dia)?></div><?php echo $dia;?></td>
		<?php }?>
		<td style="text-align: center;background-color: #361666;color: #fff;" colspan="2"><b>Totales</b></td>
		<td style="text-align: center;background-color: #361666;color: #fff;"><i class="fa fa-cogs"></i></td>
	</tr>
	<tr style="text-align: center;">
		<td rowspan="10" style="background-color: #f2f2f2;text-align: center;"><?php echo $meses[$mes];?></td>
		<?php 
		$idPersona='';
		for($dia=1;$dia<$limite;$dia++){
			$fechats=$anio."/".$mes."/".$dia;
			if((get_nombre_dia($fechats)=='Sab')||(get_nombre_dia($fechats)=='Dom')){
				echo "<td style='width: 30px;background-color: #f2f2f2;color:silver'><i class='fa fa-minus-square-o' style='font-size: 16px;'></i></td>";
			}else{
				echo "<td>";
				$sw=0;
				foreach($puntualidad as $row){
					$idPersona=$row->idPersona;
					$fecha=explode(' ',$row->fecha);
					$fecha=explode('-',$fecha[0]);
					$anioPuntual=(int)$fecha[0];
					$mesPuntual=(int)$fecha[1];
					$diaPuntual=(int)$fecha[2];
					if( ($mesPuntual==$mes) && ($diaPuntual==$dia) && ($anioPuntual==$anio) && ($row->valor==1)){
						$sw=1;
						echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
						$acumPuntualidad++;
					}
				}
				if( (($mes==$mesActual) && ($dia<=$diaActual) && ($sw==0)) || (($mes<$mesActual) && ($sw==0)) || (($anioActual!=$anio) && ($sw==0))){
					echo "<i class='fa fa-times-circle' style='color: red;font-size: 16px;'></i>";
				}
				echo "</td>";
			}
		}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumPuntualidad;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Puntualidad</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','puntualidad')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>

	<!--asistencia-->
	<tr style="text-align: center;">
		<?php 
		$idPersona='';
		for($dia=1;$dia<$limite;$dia++){
			$fechats=$anio."/".$mes."/".$dia;
			if((get_nombre_dia($fechats)=='Sab')||(get_nombre_dia($fechats)=='Dom')){
				echo "<td style='width: 30px;background-color: #f2f2f2;color:silver'><i class='fa fa-minus-square-o' style='font-size: 16px;'></i></td>";
			}else{
				$sw=0;
				echo "<td>";
				foreach($asistencia as $row){
					$idPersona=$row->idPersona;
					$fecha=explode(' ',$row->fecha);
					$fecha=explode('-',$fecha[0]);
					$anioPuntual=(int)$fecha[0];
					$mesPuntual=(int)$fecha[1];
					$diaPuntual=(int)$fecha[2];
					if( ($mesPuntual==$mes) && ($diaPuntual==$dia) && ($anioPuntual==$anio) && ($row->valor==1)){
						$sw=1;
						echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
						$acumAsistencia++;
					}
				}
				if( (($mes==$mesActual) && ($dia<=$diaActual) && ($sw==0)) || (($mes<$mesActual) && ($sw==0)) || (($anioActual!=$anio) && ($sw==0))){
					echo "<i class='fa fa-times-circle' style='color: red;font-size: 16px;'></i>";
				}
				echo "</td>";
			}
		}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumAsistencia;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Asistencia</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','asistencia')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>

	<!--Prestamos-->
	<tr style="text-align: center;">
		<?php 
		$idPersona='';
		for($dia=1;$dia<$limite;$dia++){
					echo "<td style='width: 30px;'>";
					foreach($prestamos as $row){
						$idPersona=$row->idPersona;
						$fecha=explode(' ',$row->fecha);
						$fecha=explode('-',$fecha[0]);
						$anioPuntual=(int)$fecha[0];
						$mesPuntual=(int)$fecha[1];
						$diaPuntual=(int)$fecha[2];
						if(  ($anioPuntual==$anio) && ($mesPuntual==$mes) && ($diaPuntual==$dia)){
							echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
							$acumPrestamo++;
						}
					}
					echo "</td>";
			}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumPrestamo;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Prestamos</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','prestamo')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>

	<!--Cambio de Puesto -->
	<tr style="text-align: center;">
		<?php 
		$idPersona='';
		$sw=0;
		for($dia=1;$dia<$limite;$dia++){
					echo "<td style='width: 30px;'>";
					foreach($cambio as $row){
						$idPersona=$row->idPersona;
						$puestoAnterior=$row->valor_ant;
						$fecha=explode(' ',$row->fecha);
						$fecha=explode('-',$fecha[0]);
						$anioPuntual=(int)$fecha[0];
						$mesPuntual=(int)$fecha[1];
						$diaPuntual=(int)$fecha[2];
						if(  ($anioPuntual==$anio) && ($mesPuntual==$mes) && ($diaPuntual==$dia) && ($puestoAnterior!='')){
							if($sw==0){
								$sw=1;
								echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
								$acumCambio++;
							}
						}
					}
					echo "</td>";
			}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumCambio;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Cambio P.</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','cambio puesto')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>
	
	
	
	<!--Vacaciones -->
	<tr style="text-align: center;">
		<?php 
		$idPersona='';
		for($dia=1;$dia<$limite;$dia++){
					echo "<td style='width: 30px;'>";
					foreach($vacaciones as $row){
						$idPersona=$row->idPersona;
						$fecha=explode(' ',$row->fecha);
						$fecha=explode('-',$fecha[0]);
						$anioPuntual=(int)$fecha[0];
						$mesPuntual=(int)$fecha[1];
						$diaPuntual=(int)$fecha[2];
						if(  ($anioPuntual==$anio) && ($mesPuntual==$mes) && ($diaPuntual==$dia)){
							echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
							$acumVacaciones++;
						}
					}
					echo "</td>";
			}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumVacaciones;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Vacaciones</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','vacacion')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>



<!--Capacitaciones -->
	<tr style="text-align: center;">
		<?php 
		$idPersona='';
		$sw=0;
		for($dia=1;$dia<$limite;$dia++){
					echo "<td style='width: 30px;'>";
					foreach($capacitacion as $row){
						$idPersona=$row->idPersona;
						$fecha=explode(' ',$row->fecha);
						$fecha=explode('-',$fecha[0]);
						$anioPuntual=(int)$fecha[0];
						$mesPuntual=(int)$fecha[1];
						$diaPuntual=(int)$fecha[2];
						if(  ($anioPuntual==$anio) && ($mesPuntual==$mes) && ($diaPuntual==$dia)){
							if($sw==0){
								$sw=1;
								echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
								$acumCapacitacion++;
							}
						}
					}
					echo "</td>";
			}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumCapacitacion;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Capacitación</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','capacitacion')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>

	<!--Calificacion -->
	<tr style="text-align: center;">
		<?php 
		$idPersona='';
		$sw=0;
		for($dia=1;$dia<$limite;$dia++){
					echo "<td style='width: 30px;'>";
					foreach($calificacion as $row){
						$idPersona=$row->idPersona;
						$fecha=explode(' ',$row->fecha);
						$fecha=explode('-',$fecha[0]);
						$anioPuntual=(int)$fecha[0];
						$mesPuntual=(int)$fecha[1];
						$diaPuntual=(int)$fecha[2];
						if(  ($anioPuntual==$anio) && ($mesPuntual==$mes) && ($diaPuntual==$dia)){
							if($sw==0){
								$sw=1;
								echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
								$acumCalificacion++;
							}
						}
					}
					echo "</td>";
			}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumCalificacion;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Calificación</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','calificacion')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>

	<!--Permisos -->
	<tr style="text-align: center;">
		<?php 
		$idPersona='';
		for($dia=1;$dia<$limite;$dia++){
					echo "<td style='width: 30px;'>";
					foreach($permisos as $row){
						$idPersona=$row->idPersona;
						$fecha=explode(' ',$row->fecha);
						$fecha=explode('-',$fecha[0]);
						$anioPuntual=(int)$fecha[0];
						$mesPuntual=(int)$fecha[1];
						$diaPuntual=(int)$fecha[2];
						if(  ($anioPuntual==$anio) && ($mesPuntual==$mes) && ($diaPuntual==$dia)){
							echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
							$acumPermisos++;
						}
					}
					echo "</td>";
			}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumPermisos;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Permisos</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','permiso')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>

	<!--Incapacidad -->
	<tr style="text-align: center;">
		<?php 
		$idPersona='';
		for($dia=1;$dia<$limite;$dia++){
					echo "<td style='width: 30px;'>";
					foreach($incapacidad as $row){
						$idPersona=$row->idPersona;
						$fecha=explode(' ',$row->fecha);
						$fecha=explode('-',$fecha[0]);
						$anioPuntual=(int)$fecha[0];
						$mesPuntual=(int)$fecha[1];
						$diaPuntual=(int)$fecha[2];
						if(  ($anioPuntual==$anio) && ($mesPuntual==$mes) && ($diaPuntual==$dia)){
							echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
							$acumIncapacidad++;
						}
					}
					echo "</td>";
			}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumIncapacidad;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Incapacidades</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','incapacidad')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>

	<!--Sueldos -->
	<tr style="text-align: center;">
		<?php 
		$idPersona='';
		for($dia=1;$dia<$limite;$dia++){
					echo "<td style='width: 30px;'>";
					foreach($sueldos as $row){
						$idPersona=$row->idPersona;
						$fecha=explode(' ',$row->fecha);
						$fecha=explode('-',$fecha[0]);
						$anioPuntual=(int)$fecha[0];
						$mesPuntual=(int)$fecha[1];
						$diaPuntual=(int)$fecha[2];
						if(  ($anioPuntual==$anio) && ($mesPuntual==$mes) && ($diaPuntual==$dia)){
							echo "<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>";
							$acumSueldos++;
						}
					}
					echo "</td>";
			}?>
		<td style="text-align: center;background-color: #f2f2f2;font-weight: bold;font-size: 11px;"><?php echo $acumSueldos;?></td>
		<td style="text-align: center;background-color: #f2f2f2;">Ajust. Sueldo</td>
		<td><a href="#" onclick="getByMonth('<?php echo $idPersona?>','<?php echo $mes?>','sueldo')" data-toggle="modal" data-target="#modal" ><i class="fa fa-edit"></i>Detalles</a></td>
	</tr>
	</table>
</div>
<?php }?>




