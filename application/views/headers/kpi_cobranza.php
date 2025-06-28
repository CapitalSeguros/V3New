<?php 

    $CI =& get_instance();
    $CI->load->model(array("crmproyecto_model"));
    $dataRecipts = $CI->crmproyecto_model->devuelveRelacionKPIPorPersona($this->tank_auth->get_idPersona());
    $onlyRecipts = array_filter($dataRecipts, function($arr){ return $arr->tipo == "recibos"; });
    $accounts = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "GERENTEOPERATIVO@AGENTECAPITAL.COM", "COORDINADOROPERATIVO@ASESORESCAPITAL.COM", "DATACENTER@AGENTECAPITAL.COM","COBRANZA@ASESORESCAPITAL.COM"); //"COBRANZA@ASESORESCAPITAL.COM"
    $unique = !in_array($this->tank_auth->get_usermail(), $accounts) ? true : false;
    
?>

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <a class="text-white" data-toggle="collapse" href="#cuerpo-cobranza" aria-expanded="false" aria-controls="cuerpo-cobranza">KPI de cobranza <span class="caret"></span></a>
    </div>
    <div class="panel-body collapse table-responsive" id="cuerpo-cobranza">
        <?php $unique ? $this->load->view("headers/kpiCobranzaTabla/kpiCobranzaFijo") : $this->load->view("headers/kpiCobranzaTabla/kpiCobranzaGeneral");?>
    </div>
</div>