<?php

 $i=0;
    foreach ($prospectosFianzas as $key => $value) {
        $nombre[$i]=$key;
        $valor[$i]=count($value);
        $i++;
    }
?>


<style type="text/css">
.funnel{width: 100%;background-color: #fff;height: auto;padding: 2%;font-family: arial;color: #fff;font-weight: bold;font-size: 14px;text-align: center;}
.suspecto, .perfilado, .contactado, .contactado, .cotizado, .emitido, .pagado{margin-bottom:4px;height: 40px;border-radius: 0px 0px 7px 7px;padding-top: 5px;color:#fff;}
.suspecto{width: 90%;background-color: #2e5082;}
.perfilado{width: 80%;background-color: #3c5e90;margin-left: 5%;}
.contactado{width: 70%;background-color: #48699a;margin-left: 10%;}
.cotizado{width: 60%;background-color: #5777a6;margin-left: 15%;}
.emitido{width: 50%;background-color: #6280ad;margin-left: 20%;}
.pagado{width: 40%;background-color: #718ebb;margin-left: 25%;}
.badge{background-color: #fff;color:#000;font-size:14px;}


.suspecto:hover{height: 54px;background-color: silver;}
.perfilado:hover{height: 53px;background-color: silver;}
.contactado:hover{height: 52px;background-color: silver;}
.cotizado:hover{height: 51px;background-color: silver;}
.emitido:hover{height: 50px;background-color: silver;}
.pagado:hover{height: 49px;background-color: silver;}
</style>
<div class="funnel" style="width:100%;">
    <a href="#" data-toggle="modal" data-target="#generar" onclick="verDetalleX('<?php echo str_replace("_"," ",$nombre[0]);?>','fianzas')">
        <div class="suspecto">
            <div class="badge badge-success"><?php echo $valor[0]?></div> 
            <?php echo str_replace("_"," ",$nombre[0]);?>
        </div>
    </a>

    <a href="#" data-toggle="modal" data-target="#generar" onclick="verDetalleX('<?php echo str_replace("_"," ",$nombre[1]);?>','fianzas')">
        <div class="perfilado">
            <div class="badge badge-success"><?php echo $valor[1];?></div>
            <?php echo str_replace("_"," ",$nombre[1]);?>
        </div>
    </a>

     <a href="#" data-toggle="modal" data-target="#generar" onclick="verDetalleX('<?php echo str_replace("_"," ",$nombre[2]);?>','fianzas')">
        <div class="contactado">
            <div class="badge badge-success"><?php echo $valor[2];?></div> 
            <?php echo str_replace("_"," ",$nombre[2]);?>
        </div>
    </a>

    <a href="#" data-toggle="modal" data-target="#generar" onclick="verDetalleX('<?php echo str_replace("_"," ",$nombre[3]);?>','fianzas')">
        <div class="cotizado">
            <div class="badge badge-success"><?php echo $valor[3];?></div>
            <?php echo str_replace("_"," ",$nombre[3]);?>
        </div>
    </a>

    <a href="#" data-toggle="modal" data-target="#generar" onclick="verDetalleX('<?php echo str_replace("_"," ",$nombre[4]);?>','fianzas')">
        <div class="emitido">
            <div class="badge badge-success"><?php echo $valor[4];?></div>
            <?php echo str_replace("_"," ",$nombre[4]);?>
        </div>
    </a>

     <a href="#" data-toggle="modal" data-target="#generar" onclick="verDetalleX('<?php echo str_replace("_"," ",$nombre[5]);?>','fianzas')">
        <div class="pagado">
            <div class="badge badge-success"><?php echo $valor[5];?></div>
            <?php echo str_replace("_"," ",$nombre[5]);?>
        </div>
    </a>
</div>