<?php
setlocale(LC_ALL,"es_ES");
$string = "24/11/2014";
$date = DateTime::createFromFormat("d/m/Y", date("d/m/Y"));
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="menu-panel">
            <?= $action ?>
            <h5 id='title_<?= $name ?>'><?= $title ?><?=$mes==1?'-'.strtoupper(strftime("%b",$date->getTimestamp())):''?><?=$año==1?'-'.date('Y'):''?>
            </h5>
        </div>
    </div>
    <div class="panel-body">
        <div id="<?= "graficos_$name" ?>">
        </div>
    </div>
</div>