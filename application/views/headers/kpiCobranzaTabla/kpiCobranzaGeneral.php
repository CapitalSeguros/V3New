<?php 
    $CI=& get_instance();
    $CI->load->model("crmproyecto_model");

    $cobranzaGeneral=$CI->crmproyecto_model->devuelveTodosLosRegistrosPorRegion();
    //var_dump($cobranzaGeneral);
    $tr = array_reduce($cobranzaGeneral, function($acc, $curr){

        if($curr->reporte !== "fianzas"){
            $acc .= '<tr>
                <td>'.ucwords($curr->reporte).'</td>
                <td class="text-center">'.number_format($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer).'</td>
				<td class="text-center">'.number_format($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer).'</td>
				<td class="text-center">'.number_format($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer).'</td>
				<td class="text-center">'.number_format($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer).'</td>
            </tr>';
        }

        return $acc;
    }, "");

    $fiances = array_reduce($cobranzaGeneral, function($acc, $curr){

        if($curr->reporte == "fianzas"){

            $acc["effected"] += ($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer);
            $acc["ontime"] += ($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer);
            $acc["pending"] += ($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer);
            $acc["late"] += ($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer);
        }

        return $acc;
    }, array("effected" => 0, "ontime" => 0, "pending" => 0, "late" => 0));

    $insurance = array_reduce($cobranzaGeneral, function($acc, $curr){

        if($curr->reporte !== "fianzas"){

            $acc["effected"] += ($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer);
            $acc["ontime"] += ($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer);
            $acc["pending"] += ($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer);
            $acc["late"] += ($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer);
        }

        return $acc;
    }, array("effected" => 0, "ontime" => 0, "pending" => 0, "late" => 0));

    $total = array_reduce($cobranzaGeneral, function($acc, $curr){       

        $acc["effected"] += ($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer);
        $acc["ontime"] += ($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer);
        $acc["pending"] += ($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer);
        $acc["late"] += ($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer);

        return $acc;
    }, array("effected" => 0, "ontime" => 0, "pending" => 0, "late" => 0));
    //var_dump($fiances);
?>

<table class="table-sm">
    <thead>
        <tr>
		    <td></td>
			<td><span class="label label-info">EFECTUADA</span></td>
			<td><span class="label label-success">A TIEMPO</span></td>
		    <td><span class="label label-warning">PENDIENTE</span></td>
			<td><span class="label label-danger">ATRASADA</span></td>
	    </tr>
	</thead>
	<tbody>
        <?= $tr; ?>
        <tr><td colspan="5" style="border-top: solid"></td></tr>
		<tr><td>Seguros</td><td class="text-center"> <?=$insurance["effected"]?> </td><td class="text-center"> <?=$insurance["ontime"]?> </td><td class="text-center"> <?=$insurance["pending"]?> </td><td class="text-center"> <?=$insurance["late"]?> </td></tr>
		<tr><td>Fianzas</td><td class="text-center"> <?=$fiances["effected"]?> </td><td class="text-center"> <?=$fiances["ontime"]?> </td><td class="text-center"> <?=$fiances["pending"]?> </td><td class="text-center">  <?=$fiances["late"]?></td></tr>
		<tr><td>Total</td><td class="text-center"> <?=$total["effected"]?> </td><td class="text-center"> <?=$total["ontime"]?> </td><td class="text-center"> <?=$total["pending"]?> </td><td class="text-center"> <?=$total["late"]?> </td></tr>
    </tbody>
</table>