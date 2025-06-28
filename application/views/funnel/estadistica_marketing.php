
<div style="text-align: center;">
    <h3>
    <i class="fa fa-bar-chart"></i>
    Estadisticas de Campañas por Landing Pages</h3>
</div>


<style type="text/css">
.funnel{width: 100%;background-color: #fff;height: auto;padding: 2%;font-family: arial;color: #fff;font-weight: bold;font-size: 14px;text-align: center;}
.visitantes, .alcanzados, .efectivos{margin-bottom:4px;height: 40px;border-radius: 0px 0px 7px 7px;padding-top: 5px;color:#fff;}
.visitantes{width: 60%;background-color: #5777a6;margin-left: 15%;}
.alcanzados{width: 50%;background-color: #6280ad;margin-left: 20%;}
.efectivos{width: 40%;background-color: #718ebb;margin-left: 25%;}
.badge{background-color: #fff;color:#000;font-size:14px;}


.visitantes:hover{height: 51px;background-color: silver;}
.alcanzados:hover{height: 50px;background-color: silver;}
.efectivos:hover{height: 49px;background-color: silver;}
</style>
<?php

function label_fecha_prospeccionX($mes){
        $label='';
        $year=date('Y');
        switch($mes){
            case '01';
                $label='ENERO, '.$year;
                break;
            case '02';
                $label='FEBRERO, '.$year;
                break;
            case '03';
                $label='MARZO, '.$year;
                break;
            case '04';
                $label='ABRIL, '.$year;
                break;
            case '05';
                $label='MAYO, '.$year;
                break;
            case '06';
                $label='JUNIO, '.$year;
                break;
            case '07';
                $label='JULIO, '.$year;
                break;
            case '08';
                $label='AGOSTO, '.$year;
                break;
            case '09';
                $label='SEPTIEMBRE, '.$year;
                break;
            case '10';
                $label='OCTUBRE, '.$year;
                break;
            case '11';
                $label='NOVIEMBRE, '.$year;
                break;
            case '12';
                $label='DICIEMBRE, '.$year;
                break;
        }
        return $label;
    }

?>

<div class="row">
<!-- Funnel de Fianzas-->
    <div class="col-md-6">
        <div style="text-align: center;"><h4>Fianzas</h4></div>
        <div class="funnel" style="width:100%;">
            <a href="#" data-toggle="modal" data-target="#generar">
                <div class="visitantes">
                    <div class="badge badge-success"><?php echo $visitasFianzas?></div>&nbsp;Visitantes
                </div>
            </a>

            <a href="#" data-toggle="modal" data-target="#generar">
                <div class="alcanzados">
                    <div class="badge badge-success"><?php echo $alcanzadosFianzas?></div>&nbsp;Alcanzados
                </div>
            </a>

             <a href="#" data-toggle="modal" data-target="#generar">
                <div class="efectivos">
                    <div class="badge badge-success"><?php echo $efectivosFianzas?></div>&nbsp;Efectivos
                </div>
            </a>
        </div>
    </div>

    <!-- Funnel de GMM-->
    <div class="col-md-6">
        <div style="text-align: center;"><h4>Gastos Medicos Mayores (GMM)</h4></div>
        <div class="funnel" style="width:100%;">
            <a href="#" data-toggle="modal" data-target="#generar">
                <div class="visitantes">
                    <div class="badge badge-success"><?php echo $visitasGmm?></div>&nbsp;Visitantes
                </div>
            </a>

            <a href="#" data-toggle="modal" data-target="#generar">
                <div class="alcanzados">
                    <div class="badge badge-success"><?php echo $alcanzadosGmm?></div>&nbsp;Alcanzados
                </div>
            </a>

             <a href="#" data-toggle="modal" data-target="#generar">
                <div class="efectivos">
                    <div class="badge badge-success"><?php echo $efectivosGmm?></div>&nbsp;Efectivos
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-lg-6">
    <div id="estadisticasfianzas" style="width:100%;text-align: left;">
    <table class="table table-responsive table-striped" style="width:100%;text-align: left;">
    <thead>
        <tr style="color:#fff;">
            <td style="width:60%;">Prospectos por Campaña de Fianzas del Mes: <?php echo label_fecha_prospeccionX($mes);?></td>
            <td style="text-align:right">Leads Efectivos</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>FIANZAS</td>
            <td style="text-align:right"><?php echo $efectivosFianzas?></td>
             <input type="hidden" id="fianzas" value="<?php echo $efectivosFianzas?>">
        </tr>
        <tr>
            <td style="width: 20%;">Ingrese el monto de la inversion por Campaña:</td>
            <td>
                <input type="text" class="form-control" style="text-align:right;" onkeyup="calcular_costo_leads(this,1)">
            </td>
        </tr>
         <tr>
            <td style="width: 20%;">Costo por Leads:</td>
            <td>
                <input type="text" name="totalFianzas" id="totalFianzas" class="form-control" disabled='true' style="text-align:right;">
            </td>
        </tr>
    </tbody>
    </table>
    </div>
    </div>

    <div class="col-md-6 col-lg-6">
        <div id="estadisticasgmm" style="width:100%;text-align: left;">
        <table class="table table-responsive table-striped" style="width:100%;text-align: left;">
        <thead>
        <tr style="color:#fff;">
            <td style="width:60%;">Prospectos por Campaña de Gmm del Mes: <?php echo label_fecha_prospeccionX($mes);?></td>
            <td style="text-align:right">Leads Efectivos</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>GASTOS MEDICOS</td>
            <td style="text-align:right">
            <input type="hidden" id="gmm" value="<?php echo $efectivosGmm?>">
            <?php echo $efectivosGmm?></td>
        </tr>
        <tr>
            <td style="width: 20%;">Ingrese el monto de la inversion por Campaña:</td>
            <td>
                <input type="text"  class="form-control" style="text-align:right;" onkeyup="calcular_costo_leads(this,0)">
            </td>
        </tr>
         <tr>
            <td style="width: 20%;">Costo por Leads:</td>
            <td>
                <input type="text" name="totalGmm" id="totalGmm" class="form-control" disabled='true' style="text-align:right;">
            </td>
        </tr>
    </tbody>
        </table>
        </div>
    </div>
</div>
