<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-8 col-sm-8 col-xs-8">
			<h3 class="titulo-secciones">Reporte de Ventas</h3>
		</div>
	</div>
	<hr> 
</section>
<div class="col-md-12 tab-pane">
	<div class="col-md-12 pd-left pd-right" style="margin-bottom: 20px;">
        <!-- <h5 class="titleSection">Reporte Mensual Prospección</h5>
        <hr class="title-hr"> -->
        <div class="col-md-12 column-flex-bottom pd-left pd-right">
        	<div class="pd-side pd-items-table">
        		<label class="textForm">Mes:</label>
        		<select class="form-control" id="monthReportMonthly"><?=$months?></select>
        	</div>
        	<div class="pd-side pd-items-table">
        		<label class="textForm">Año:</label>
        		<select class="form-control" id="yearReportMonthly"><?=$years?></select>
        	</div>
            <div class="pd-side pd-items-table">
                <label class="textForm">Reporte:</label>
                <select class="form-control" id="typeReportMonthly" onchange="emailFilter(this.value)">
                    <?=printFilter($permission_v);?></select>
            </div>
        	<div class="pd-side pd-items-table" style="max-width: 50%;">
                <label class="textForm">Correo:</label>
        		<select class="form-control" id="userReportMonthly">
                    <?=printEmails($empleados,$agentes,$permission_v,$email);?>
                    <!-- <option value="<?=$email?>"><?=$email?></option> -->
                </select>
        	</div>
        	<div class="pd-side pd-items-table">
        		<button class="btn btn-primary" id="searchMonthly" onclick="getReportSalesByUser()">Generar</button>
        	</div>
        </div>
        <div class="col-md-12 pd-left pd-right pd-items-table">
            <div class="col-md-12 pd-left pd-right column-flex-end">
                <div class="pd-side">
                    <button class="btn btn-export-report" id="btnExportReportSales" title="Exportar Tabla" onclick="exportReportSales()" disabled>
                        <i class="fas fa-file-excel"></i> Exportar</button>
                </div>
            </div>
        </div>
        <div class="col-md-12 pd-left pd-right pd-items-table hidden">
            <form method="get" class="form column-flex-center-end" id="formExportReportSales" name="formExportReportSales" action="<?= base_url()?>crmproyecto/exportReportSales">
                <div class="pd-side">
                    <input type="text" class="form-control input-sm" name="mn" id="monthExport" value="<?=date('n')?>">
                </div>
                <div class="pd-side">
                    <input type="text" class="form-control input-sm" name="yr" id="yearExport" value="<?=date('Y')?>">
                </div>
                <div class="pd-side">
                    <input type="text" class="form-control input-sm" name="em" id="emailExport" value="<?=$email?>">
                </div>
                <div class="pd-side">
                    <input type="text" class="form-control input-sm" name="rp" id="reportExport">
                </div>
                <div class="pd-side">
                    <input type="text" class="form-control input-sm" name="tp" id="typeExport" value="2">
                </div>
                <div class="pd-side">
                    <button type="submit" class="btn btn-primary">Exportar</button>
                </div>
            </form>
        </div>
        <div class="col-md-12 pd-left pd-right">
            <div class="col-md-12 container-table">
                <table class="table table-hovered" id="tableReportSold">
                    <thead>
                        <tr class="table-tr">
                            <th colspan="2"></th>
                            <th colspan="4" class="brd-left title-table">Objetivos Cuantitativos</th>
                            <th colspan="1" class="brd-left"></th>
                        </tr>
                        <tr class="table-tr">
                            <th>N°</th>
                            <th>Indicadores y Ratios</th>
                            <th class="brd-left">Semana 1</th>
                            <th>Semana 2</th>
                            <th>Semana 3</th>
                            <th>Semana 4</th>
                            <th class="brd-left">Detalles</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTableReportSales"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?
    //echo "Tipo Permiso: ".$permission_v;
    function printEmails($data,$agent,$permission,$email){
        $option = "<option value='0'>Seleccione un correo</option>";
        //Colaboradores
        foreach ($data as $key1 => $value1) {
            if ($permission == 1 || $permission == 2) {
                if ($value1['Name'] == "Comercial") {
                    $option.='<optgroup data-filter="'.$value1['Name'].'" label="'.$value1['Name'].'">';
                    foreach ($value1['Data'] as $key => $value) {
                        $comercial = "0";
                        if ($value['email'] == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || $value['email'] == "COORDINADOR@CAPCAPITAL.COM.MX" || $value['email'] == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || $value['email'] == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM") {
                            $nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
                            $option.='<option value="'.$value['email'].'" data-id="'.$value['idPersona'].'" data-name="'.$nombres.'" data-area="'.$value1['Name'].'" data-coord="'.$value['esCoordinador'].'" data-coordcom="3">'.$nombres.' <label>('.$value['email'].')</label></option>';
                        }
                    }
                    $option.='</optgroup>';
                }
            }
        }
        //Agentes
        foreach ($agent as $key => $value) {
            $option .= '<optgroup label="'.$key.'">';
            foreach ($value as $row) {
                $selected = ($email == $row->email) ? "selected" : "";
                $name = $row->apellidoPaterno.' '.$row->apellidoMaterno.' '.$row->nombres;
                $option .= '<option class="dropdown-item" data-person="agente" data-agente="4" data-department="'.$key.'" value="'.$row->email.'" '.$selected.'>'.$name.' (<label style="color:black;">'.$row->email.'</label>)</option>';
            }
            $option.='</optgroup>';
        }
        $option = $permission != 0 ? $option : '<option class="dropdown-item" value="'.$email.'">'.$email.'</option>';
        return $option;
    }

    function printFilter($permission){ //Creado [Suemy][2024-06-26]
        $option = '';

        if ($permission == 1) {
            $option .= '<option value="1">Completo</option></option><!-- <option value="2">Coordinador</option> --><option value="3">Coordinador Comercial</option>';
        }
        else if ($permission == 2) {
            $option .= '<option value="3">Coordinador Comercial</option>';
        }
        $option .= '<option value="4">Agente</option>';

        /* //$data es $empleados
        $option .= '<optgroup label="Areas">';
        foreach ($data as $key1 => $value1) {
            $option.='<option value="'.$value1['Name'].'">'.$value1['Name'].'</option>';
        }
        $option .= '</optgroup>';*/
        return $option;
    }
?>