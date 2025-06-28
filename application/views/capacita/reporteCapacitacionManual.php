<?php 
    $this->load->view("capacita/menu_capacita");
?>
<style type="text/css">
    #tab_capa.nav-tabs {
        font-size: 14px;
        border-bottom: 1px solid #dee2e6;
        background: transparent;
        width: 100%;
    }
    #tab_capa.nav-tabs > li {
        margin-bottom: -1px;
    }
    #tab_capa.nav-tabs>li>a.active, .nav-tabs>li>a.active:focus, .nav-tabs>li>a.active:hover {
        color: #8370A1;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    #tab_capa.nav-tabs>li>a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
        color: #555;
    }
    #tab_capa.nav-tabs>li>a:hover {
        background: #8370A1;
        color: white;
    }
    #tab_capa.nav-tabs>li {
        float: left;
        margin-bottom: -1px;
    }
    #contenedor_capa.tab-content {
        font-size: 13px;
        border: 1px solid #dee2e6;
        border-top: transparent;
        box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.10);
    }
    .column-flex-center {
        display: flex;
        align-items: center;
    }
    .border-first {
        border-color: #7199bd!important;
        border-radius: 3px;
        box-shadow: 0px 0px 2px 2px rgb(65 94 152 / 31%);
    }
    .border-second {
        border: 1px solid;
        border-color: #5069a533!important;
        border-radius: 3px;
        padding: 5px 0px;
        margin: 10px;
    }
    .border-third {
        border-color: #7199bd!important;
        border-radius: 5px;
    }
</style>
<!------------------------------------------------->
<div class="container" style="margin-right: 0px;">
    <h2 class="mt-4 title-capacita">Mi reporte de capacitación</h2>
    <hr>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Mi capacitación</div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="tab_capa" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" id="mi_reporte_tab" role="tab" aria-controls="mi_reporte" aria-selected="true" href="#mi_reporte">Mi capacitacion actual</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="mi_historial_tab" role="tab" aria-controls="mi_historial" aria-selected="true" href="#mi_historial">Historial capacitación</a>
                    </li>
                    <?php if($valida){?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" id="mi_personal_tab" role="tab" aria-controls="mi_personal" aria-selected="true" href="#mi_personal">Capacitaciones asignadas</a>
                        </li>
                    <?php }?>
                </ul>
                <div class="tab-content" id="contenedor_capa">
                    <div class="tab-pane active" id="mi_reporte" role="tabpanel" aria-labeledby="mi_reporte_tab">
                        <div class="card-body">
                            <h4>Registro de capacitación del mes en curso</h4>
                             <br>
                            <?php if(!empty($Cap_actual)){ $cont = 1;?>
                                <?php foreach($Cap_actual as $cap => $d_c) {
                                        //$cont++;
                                    ?>
                                    <div class="row border-first mt-3 column-flex-center">
                                        <div class="col-md-4 text-center">
                                            <h6 class="text-center">Capacitación</h6>
                                            <span class="badge badge-info capacitacion_<?=$cont++?>" style="font-size: 13px;"><?=$cap?></span>
                                        </div>
                                        <div class="col-md-7" style="padding: 0px;">
                                        <?php foreach($d_c as $subc => $ramos){?>
                                        <div class="col-md-12 border-second column-flex-center">
                                            <div class="col-md-6 text-center">
                                                <!--<label for="<?=$subc?>"><span class="badge badge-secondary">Sub-capacitación</span> <?=$subc?></label>-->
                                                <h6 class="text-center">Sub-capacitación</h6>
                                                <label for="<?=$subc?>" class="sub-capacitacion" style="color:black;"><?=$subc?></label>
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <h6 class="text-center">Ramos</h6>
                                                <div class="col-md-12">
                                                    <?php foreach($ramos as $r => $h){
                                                        if($h > 0){
                                                    ?>
                                                    <div class="col-md-12 border border-third mb-2 ml-2 listar_cap" > <!-- type="button" data-toggle="modal" data-target=".db-modal-cap-modal-lg" data-capacitacion="<?=$cap?>" data-sub_capacitacion="<?=$subc?>" data-ramo="<?=$r?>" -->
                                                        <label for="<?=$r?>"><i class="fa fa-certificate" style="margin-right: 5px;"></i><?=ucwords(str_replace("danio", "daños", $r))?></label>
                                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i> Tiempo: <?=$h?> hrs</p>
                                                    </div>
                                                    <?php }
                                                        }?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                        </div>
                                    </div>
                                <?php }?>
                            <?php } else{?>No se encontraron resultados<?php }?>
                        </div>
                    </div>
                    <div class="tab-pane" id="mi_historial" role="tabpanel" aria-labeledby="mi_historial_tab">
                        <div class="card-body">
                            <h4>Historial de horas</h4>
                            <div class="table-responsive" style="height: 510px;overflow: auto;">
                                <table class="table">
                                    <thead class="table-thead">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Profesional</th>
                                            <th>Autos</th>
                                            <th>Vida</th>
                                            <th>Daños</th>
                                            <th>GMM</th>
                                            <th>Fianzas</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $total_1 = 0;
                                            $total_2 = 0;
                                            $total_3 = 0;
                                            $total_4 = 0;
                                            $total_5 = 0;
                                            $total_6 = 0;

                                            foreach($Cap_historial as $id => $data){
                                                
                                                $total_1 += $data["registros"]["profesional"];
                                                $total_2 += $data["registros"]["autos"];
                                                $total_3 += $data["registros"]["vida"];
                                                $total_4 += $data["registros"]["daños"];
                                                $total_5 += $data["registros"]["GMM"];
                                                $total_6 += $data["registros"]["fianzas"];
                                            ?>
                                            
                                            <tr>
                                                <td><?=$data["nombre"]?></td>
                                                <td><?=$data["registros"]["profesional"]?></td>
                                                <td><?=$data["registros"]["autos"]?></td>
                                                <td><?=$data["registros"]["vida"]?></td>
                                                <td><?=$data["registros"]["daños"]?></td>
                                                <td><?=$data["registros"]["GMM"]?></td>
                                                <td><?=$data["registros"]["fianzas"]?></td>
                                                <td><?=($data["registros"]["fianzas"] + $data["registros"]["GMM"] + $data["registros"]["daños"] + $data["registros"]["vida"] + $data["registros"]["autos"] + $data["registros"]["profesional"])?></td>
                                            </tr>
                                        <?php }?>
                                        <tr>
                                                <td>TOTAL</td>
                                                <td><?=$total_1?></td>
                                                <td><?=$total_2?></td>
                                                <td><?=$total_3?></td>
                                                <td><?=$total_4?></td>
                                                <td><?=$total_5?></td>
                                                <td><?=$total_6?></td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php if($valida){?>
                        <div class="tab-pane" id="mi_personal" role="tabpanel" aria-labeledby="mi_personal_tab" ></div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade db-modal-cap-modal-lg" id="modal-cap" tabindex="-1" role="dialog" aria-labelledby="capacita_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registros</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="m_b">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->
</div>


<input type="hidden" data-url="<?=base_url()?>" id="base_url">
<!------------------------------------------------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="<?=base_url()."assets/js/js_capacitacion.js"?>"></script>
<script src="<?=base_url()."assets/react_js/react_modules/bundle_js/bundle-reporteCapacitacion.js"?>"></script>
<script type="text/javascript">
    // $("#exampleModal").modal({
    //     show: true,
    //     keyboard: false,
    //     backdrop: false,
    // });
</script>