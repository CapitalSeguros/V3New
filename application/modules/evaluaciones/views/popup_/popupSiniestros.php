<style>
    .pop-up-modal{
        top:58%;
        border: 1px black solid;
        width: 400px;
        /*height: 350px;*/
        right: 10px;
        position: fixed;
        z-index: 2;
        background-color: #FDFEFE;
        /*bottom: 20px;*/
    }
</style>
<?php 
    $CI=&get_instance();
    $CI->load->model("graficas_model","siniestros");
    $getClaimsKpi = $this->siniestros->getKPI_Siniestros($typeController,null,null,$this->tank_auth->get_idPersona());
    $title = getTitle($typeController);
    //var_dump($getClaimsKpi);

    //-----------------
    function getTitle($label){
        switch($label){
            case "DANOS": return "DAÑOS";
            break;
            case "AUTOSI": return "AUTOS INDIVIDUALES";
            break;
            case "GMM": return "GMM";
            break;
            case "AUTOSC": return "CORPORATIVO";
            break;
        }
    }
    //-----------------
    function getLabel($label){
        switch($label){
            case "No_Finalizado": return "Terminados";
            break;
            case "Finalizado": return "Pendientes";
            break;
            default: return $label;
        }
    }
?>
<div class="pop-up-modal">
    <div class="col-md-12 text-center" style="border-bottom: 1px black solid">
        <h5><a data-toggle="collapse" href="#popup-causally" aria-expanded="false" aria-controls="popup-causally">KPI'S SINIESTROS <span class="caret"></span></a></h5>
    </div>
    <div class="col-md-12 register-content" id="popup-causally">
        <div class="row">
            <div class="col-md-6 text-center"><h5><?=$title?></h5></div>
            <!--<div class="col-md-6 mt-2 text-right">
                <button class="btn btn-primary btn-xs">Consultar más kpis</button>
            </div>-->
        </div>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td></td>
                        <td><h5><span class="label label-success">Verde</span></h5></td>
                        <td><h5><span class="label label-warning">Ambar</span></h5></td>
                        <td><h5><span class="label label-danger">Rojo</span></h5></td>
                        <td><h5><span class="label label-info">Total</span></h5></td>
                    </tr>
                    <?php foreach($getClaimsKpi as $type => $data){?>
                        <tr>
                            <td><?=getLabel($type)?></td>
                            <?= array_reduce($data, function($acc, $curr){
                                $acc .= "<td class='text-center'>".$curr."</td>";
                                return $acc;
                            }, "")?>                            
                        </tr>    
                        <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>