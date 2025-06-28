    <!--:::::::::: INICIO FOOTER ::::::::::-->
    <footer class="container-fluid">
        <div class="row">
            <div class="col-md-12">
               <?
                   if (isset($numerodeurgentes)) {

                   echo "<font class='labelResponsivo' color='red'>Actividades !Urgentes Permitidas al MES Restantes =</font>\r ";
                   //echo "Actividades !Urgentes Permitidas al MES ";
                    foreach($numerodeurgentes as $numurg){
                    $diti = $numurg->valor;
                    echo "<font class='labelResponsivo' color='red'>$diti</font>"; 

                    $cadena = "\r\n <font class='labelResponsivo'>Tabla de Urgentes por Ranking\r\nPROVISIONAL=2 Urgentes/Mes\n\rESTANDAR=4 Urgentes/Mes\n\rBRONCE=6 Urgentes/Mes\n\rPLATA=8 Urgentes/Mes\n\rORO=10 Urgentes/Mes\n\rPLATINO VIP=15 Urgentes/Mes\n\r </font>";
                    echo nl2br($cadena);


                  }

                    }
               ?>
            
            </div>
		</div>
    </footer>
    
</div>
<div id="base_url" data-base-url="<?=base_url()?>"></div>

<?php if (!isset($ticc)) { ?>

    <!--script src="https://widget.soldai.com/v2/e3e32264333567d7470f787fb8cb9f36a1ad257a"></script>
<hermes-chat         _key="e3e32264333567d7470f787fb8cb9f36a1ad257a"         namebot="Agentes V3 plus"         title-image-url="https://capsys.com.mx/V3/assets/images/segurin/LOGOSEGURIN.png"         header-background="#3e2578"         header-text-color="#ffffff"         welcomemessage="¡Hola!"         user-response-backgrond="#258ef8"         user-response-text-color="#ffffff"         input-background="#ffffff"         background-color-imagotipo="#ffffff"         launcher-icon-url="https://capsys.com.mx/V3/assets/images/segurin/LOGOSEGURIN.png"         float-icon-background="#ffffff"         launcher-open-background-color="#6239bc"         globe-text-color="#000000"        ></hermes-chat-->
    <mercury-chat _key="62bdebbef329c0001a4cfc2a"></mercury-chat>
<script src="https://widget.neuraan.com/static/js/app.js"></script>


    <script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/superfish/js/superfish.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/placeholdem.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/wow/js/wow.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/theme.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/ticScripts.js'); ?>"></script>
    <script src="https://comportia.soldai.com/widget/v1/hermes.plugin.js"></script>
    <script type="text/javascript">

    </script> 
    <?php  }?>

    <?php if (isset($ticc)) { ?>
    <script src="<?= base_url(DIR_ASSETS . 'js/bootstrap.min.js" type="text/javascript') ?>"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/lodash.min.js') ?>"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/ticc.js') ?>"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/menu.js') ?>"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/moment.min.js') ?>"></script>


    <script src="<?= base_url(DIR_ASSETS . 'js/jquery.dataTables.js') ?>"></script>

    <script src="<?= base_url(DIR_ASSETS . 'js/nprogress.js') ?>"></script>
    <?php  }?>

    <?php
    if (isset($_scripts)) {
        foreach ($_scripts as $value) {
            echo $value;
        }
    }
    ?>
</body>
</html>
<style type="text/css">
 .soldai-bot{color: transparent;background: url(<?echo(base_url().'assets/images/smallSegurin1.png') ;?>);position: relative;top:0px;height: 200px;width: 200px; background-size: 100% 100%;background-repeat: no-repeat; z-index: 10000}
 .messageContainer_btn{width: 100px}
 .hermes-opener{width: 60px;height: 60px}
</style>
<script type="text/javascript">


/*
$(document).ready(function () {
  document.getElementsByClassName('hermes-title')[0].innerText="Segurin Capital";
});
*/
</script>