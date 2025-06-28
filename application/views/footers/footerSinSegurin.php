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
    <!--:::::::::: FIN FOOTER ::::::::::-->
    <!--:::::::::: JS ::::::::::-->
    <!-- <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script> -->
    <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script> -->
    <!-- <script src="js/bootstrap.min.js" type="text/javascript"></script> -->
    <!-- <script src="js/ticc.js"></script> -->
    <!-- <script src="js/menu.js"></script> -->
	<script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>	
	<script src="<?php echo site_url('assets/plugins/superfish/js/superfish.js'); ?>"></script>
	<script src="<?php echo site_url('assets/plugins/placeholdem.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/plugins/wow/js/wow.min.js'); ?>"></script>
   	<script src="<?php echo site_url('assets/js/theme.js'); ?>"></script>
   	<script src="<?php echo site_url('assets/js/ticScripts.js'); ?>"></script>    
