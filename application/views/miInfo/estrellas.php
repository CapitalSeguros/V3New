<?php
    $ci = &get_instance();
    $ci->load->model("valoracion_model");
?>
 <div class="col-12">
    <div class="card">
    <div class="card-body d-flex flex-column">
       
        <h5 class="card-title mb-0" style="padding-bottom: 5%;"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Valoraciones en Calidad de Servicio</h5>
    <p>
    <?php
         $ct=0; 
     foreach ($puntos as $punto) {$ct++?>
                <input type="hidden" id="color<?php echo $ct?>" value=0>
                <div class="row" style="padding-bottom: 2%">
                    <div class="col-md-1 col-sm-1 col-lg-1">
                        <a style="cursor: pointer;"><i class="fa fa-star" style="font-size: 18px;color: #1976d2;"></i></a>
                    </div>
                     <div class="col-md-4 col-sm-4 col-lg-4" style="font-size: 12px;text-align: left;">
                        <?php echo $punto->descripcion;?>
                    </div>
                    <div class="col-md-5 col-sm-5 col-lg-5">
                        <progress max="100" value='' style="width: 80%;" />
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2" style="text-align: left;">
                        <span style="font-size: 11px"><?php echo $ci->valoracion_model->total_estrellas($punto->id,$idPersona)."%";?></span>
                    </div>
                </div>
                <?php 
                }?>
    </p>
      <span style="font-size: 12px;"><i class="fa fa-users"></i> Cantidad de personas que han calificado: <?php echo $totalCuantos;?></span>
    </div>
</div>
</div>


