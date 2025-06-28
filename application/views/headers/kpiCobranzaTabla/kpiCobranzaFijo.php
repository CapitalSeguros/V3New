<?php 
    $CI =& get_instance();
    $CI->load->model(array("crmproyecto_model"));
    $kpi = $CI->crmproyecto_model->avance_cobranza_agente_region($this->tank_auth->get_idPersona());
    $kpi_ = array();
    array_push($kpi_, $kpi);
    $dxnData = $this->crmproyecto_model->getDxnData();
	$getCountBxN = array_reduce($dxnData, function($acc, $curr){

		if($curr->tipoRecibo == "efectuado"){
			$acc["effected"] += $curr->recibos; 
		} elseif($curr->tipoRecibo == "atrasado"){
			$acc["late"] += $curr->recibos; 
		}

		return $acc;
	}, array("effected" => 0, "late" => 0));
    //var_dump($kpi);
    //$effected = !empty($kpi) ? $kpi->recibos_efectuados + $kpi->recibos_efectuados_grupo_cer : 0;
    ///$onTime = !empty($kpi) ? $kpi->recibos_a_tiempo + $kpi->recibos_a_tiempo_cer : 0;
    //$pending = !empty($kpi) ? $kpi->recibos_pendientes + $kpi->recibos_pendientes_grupo_cer : 0;
    //$late = !empty($kpi) ? $kpi->recibos_atrasados + $kpi->recibos_atrasados_grupo_cer : 0;

    $kpiSemaphore = array_reduce($kpi_, function($acc, $curr){ // $kpi

        $acc["effected"] += ($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer);
        $acc["ontime"] += ($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer);
        $acc["pending"] += ($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer);
        $acc["late"] += ($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer);

        return $acc;
    }, array("effected" => 0, "ontime" => 0, "pending" => 0, "late" => 0));
    //var_dump($kpi);
?>

<div>
    <div class="col-md-12 mb-4">
        <span class="label label-warning">Fecha actual</span>
        <span class="label label-default"><?=date("d-m-Y")?></span>
        <span class="label label-warning">Dias hábiles</span>
        <span class="label label-default"><?=$dias?> dias</span>
        <span class="label label-warning">Promedio sugerido de cobro</span>
        <span class="label label-default"><?= number_format(($kpiSemaphore["pending"] + $kpiSemaphore["late"])/$dias) ?> recibos</span>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4"><h5><span class="label label-primary">EFECTUADA</span></div><div class=""></h5><h5><span class="label label-default"><?= $kpiSemaphore["effected"]; ?> RECIBOS</span></h5></div>
        </div>
        <div class="row">
            <div class="col-md-4"><h5><span class="label label-success">A TIEMPO</span></div><div class=""></h5><h5><span class="label label-default"><?= $kpiSemaphore["ontime"]; ?> RECIBOS</span></h5></div>
        </div>
        <div class="row">
            <div class="col-md-4"><h5><span class="label label-warning">PENDIENTE</span></h5></div><div class=""></h5><h5><span class="label label-default"><?= $kpiSemaphore["pending"]; ?> RECIBOS</span></h5></div>
        </div>
        <div class="row">
            <div class="col-md-4"><h5><span class="label label-danger">ATRASADA</span></h5></div><div class=""></h5><h5><span class="label label-default"><?= $kpiSemaphore["late"]; ?> RECIBOS</span></h5></div>
        </div>
    </div>
    <?php if($dxn){?>
    <div class="col-md-12">
        <hr>
        <h5>RECIBOS DXN</h5>
        <div class="row">
            <div class="col-md-4"><h5><span class="label label-info">EFECTUADO</span></h5></div>
            <div class="col-md-8 row">
                <div class="col-md-6"><h5><span class="label label-default"><?=$getCountBxN["effected"]?> RECIBOS</span></h5></div>
                <div class="col-md-6"><h5><span class="label label-default"><?=$kpiSemaphore["effected"] - $getCountBxN["effected"]?> RECIBOS DT</span></h5></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"><h5><span class="label label-info">ATRASADO</span></h5></div>
            <div class="col-md-8 row">
                <div class="col-md-6"><h5><span class="label label-default"><?=$getCountBxN["late"]?> RECIBOS</span></h5></div>
                <div class="col-md-6"><h5><span class="label label-default"><?=$kpiSemaphore["late"] - $getCountBxN["late"]?> RECIBOS DT</span></h5></div>
            </div>
        </div>
    </div>
    <?php }?>
</div>