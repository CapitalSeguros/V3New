<?php
    $getSecondGoal_ = $CI->metacomercial_modelo->getSecondGoal($this->tank_auth->get_usermail());
    $getProgressGoal = $CI->metacomercial_modelo->getProgressSecondGoal($this->tank_auth->get_usermail());
    $viewArray = array();

    $mounthFiltered = array_filter($getSecondGoal_, function($obj){
        return $obj->mes_asignado == date("n");
    });

    foreach($mounthFiltered as $data){
        
        $getCategoryProgress_ = $CI->metacomercial_modelo->getCategoryProgress($this->tank_auth->get_usermail(), str_replace("danios", "daños",$data->ramo), $data->mes_asignado);

        if(!empty($getCategoryProgress_)){

            $viewArray["polizas"][$data->ramo]["meta"] = $data->cantidad_polizas;
            $viewArray["polizas"][$data->ramo]["avance"] = $getCategoryProgress_->cantidad;
            $viewArray["primas"][$data->ramo]["meta"] = $data->prima_polizas;
            $viewArray["primas"][$data->ramo]["avance"] = $getCategoryProgress_->prima;
        }
    }

    $tabs = array_keys($viewArray);
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($viewArray,TRUE));fclose($fp);

    if(!empty($viewArray)){
        $flotante_nuevo.='<div class="card mt-2">
            <div class="card-header text-center">
                <a data-toggle="collapse" href="#collapseSecondGoal" aria-expanded="false" aria-controls="collapseSecondGoal">
                Ramos
                </a>
            </div>
            <div class="card-body collapse" id="collapseSecondGoal">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
        ';
            foreach($tabs as $li){
                $flotante_nuevo.= '<li class="nav-item">
                    <a class="nav-link" id="'.$li.'-tab" data-toggle="tab" href="#'.$li.'" role="tab" aria-controls="'.$li.'" aria-selected="true">'.$li.'</a>
                </li>';
            }
        $flotante_nuevo.='</ul><div class="tab-content" id="tabContent">';
            
            foreach($viewArray as $id => $div){
                $flotante_nuevo.='<div class="tab-pane fade table-responsive" id="'.$id.'" role="tabpanel" aria-labelledby="'.$id.'-tab">
                    <table class="table table-sm">
                        <tbody>
                            <tr><td class="text-center"><b>Ramo</b></td><td class="text-center"><b>Meta</b></td><td class="text-center"><b>Avance</b></td></tr>';
                    foreach($div as $ramo => $data){
                        $flotante_nuevo.='<tr>
                            <td><span class="label label-info">'.strtoupper($ramo).'</span></td>
                            <td class="text-center">'.number_format($data["meta"]).'</td>
                            <td class="text-center">'.number_format($data["avance"]).'</td>
                        </tr>';
                    }
                $flotante_nuevo.= '</tbody>
                    </table>
                </div>';
            }

        $flotante_nuevo.= '</div>
        </div>'; 
    }
?>