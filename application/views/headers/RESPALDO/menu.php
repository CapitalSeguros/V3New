<style type="text/css">
body {overflow-x: hidden;}
ul#menuSub {
 float:center;
 padding: 5px;
  position: relative;
  top:10px;
    color: #fff;
    font-size: 14px;
}
ul#menuSub2 {
  border-style:solid; 
  height: 80px; 
  width: 80px;
   border-style: groove;
   font-size: 14px;
   top: 15px;
   position:  absolute;

}
  
ul#menuSub li {
 color: white;
 float: left;
 list-style: none;
 margin: 0% 0%; 

}
  
ul#menuSub li:hover{
 color: blue;
 cursor:pointer;
 background: #9D8EBF;

}
  
ul#menuSub ul {
 display: none;
 position: absolute;
 top: 18px;
 color: green;
 padding: 2px 0px 2px 2px;
 margin-top: 3px ;
 left: 5PX;
 height: auto;
 width: 140px;
 background: #59497A;

 
 }
  
ul#menuSub ul li{
 float: left;
 color: blue;
 width:130px;
 margin:2% 0%;
}
 ul#menuSub ul li a{
 color: white;

}
  
ul#menuSub ul li a:hover{
 color: yellow;
 cursor:pointer;

}
  
ul#menuSub li:hover ul ul,ul#menuSub li:hover ul ul ul,ul#menuSub li.iehover ul ul,ul#menuSub li.iehover ul ul ul {
 display: none;
 cursor:pointer;
}
  
ul#menuSub li:hover ul,ul#menuSub ul li:hover ul,ul#menuSub ul ul li:hover ul,ul#menuSub li.iehover ul,ul#menuSub ul li.iehover ul,ul#menuSub ul ul li.iehover ul {
 display: block;
 cursor:pointer;
}
</style>

<style type="text/css">
  .fondoCabeceraMenu{
    background-image: url("<?php echo base_url(); ?>assets/images/CABECERA.jpg");
    height: 130px;
      
   visibility: visible;
   background-repeat: no-repeat;
margin-bottom: 0px;

    

  }

</style>
<meta name="viewport" content="width=900px"/>
<script type="text/javascript">


         function cambiaVariableSecion (){

            document.getElementById("ventana-flotanteBL").className = "oculto";
              $.ajax({
              method: "POST",
              dataType: "html",
              url: "<?php echo base_url();?>cambiaVariableSecion/cierraBox",              
              data: {gato:'perro'},
              async: true,
           success: function(result){
                
             // El codigo que vas a hacer funcionar cuando tenga exito el ajax
             
            },
            error: function() {
                     // El codigo que vas a hacer cuando falle el ajax
                      
       
            }
            })
        }
</script>
<?php
	$configModulos = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
	foreach($configModulos as $modulos){ }
?>
<?php
	$activa = $this->uri->segment(1);
	$path_foto = "assets/img/miInfo/userPhotos/";
    $foto = "";
	$usermail = $this->tank_auth->get_usermail();
    if(file_exists( $path_foto . $this->tank_auth->get_usermail().".jpg")){ 
        $foto = $path_foto . $this->tank_auth->get_usermail().".jpg"; 
    } else {
        $foto = $path_foto . "noPhoto.png";
    }
?>

<?  
session_start(); 

if(isset($_SESSION['BOXLIGHT']))
{ if($_SESSION['BOXLIGHT']){
  ?>  <div id='ventana-flotanteBL'>
  
        <a class='cerrar' href='javascript:void(0);' onclick='cambiaVariableSecion ()'>x</a>
        <img style="height: 100%;width: 100%" src="<?php echo base_url(); ?>assets/imgBanner/nuestrosagentes.png">
      </div>
  <?//$_SESSION['BOXLIGHT']=FALSE;
}
}
?>

 <header   > 



</div>	
 	<div class="fondoCabeceraMenu" >
            <div  style="visibility: hidden;height: 1px">
                <a href="./" class="navbar-brand" title="Capsys Web - Inicio">
                    <img src="<?php echo base_url(); ?>assets/images/logo-Capsys.png" alt="CAPSYS">
                </a>
            </div>
            <ul class="user-perfil pull-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> 
                        <span class="usuario-nombre"><?php echo $this->tank_auth->get_usermail(); ?></span>
                        <i class="caret"></i>
                        <div class="user-perfil-extra hidden-xs">
                        <p>
							<?php echo $this->tank_auth->get_usernamecomplete(); ?> 
                            <!-- <span class="badge"><?php echo $this->tank_auth->get_userprofile(); ?></span> -->
                            <span class="badge">
								<?php
									if($this->capsysdre->RankingUsuarioEmail($this->tank_auth->get_usermail()) != ""){
									echo $this->capsysdre->RankingUsuarioEmaildeMiinfo($this->tank_auth->get_usermail());
									} else {
									echo $this->capsysdre->NombrePerfilUsuario($this->tank_auth->get_userprofile());
									}
								?>
							</span>
                            <?php //print("<b>".$this->capsysdre->RankingUsuarioEmail($this->tank_auth->get_usernamecomplete())."</b>"); ?>
                            <?php  ?>
							<?php //echo $this->tank_auth->get_usernamecomplete(); ?>
							<?php //echo $this->tank_auth->get_usernamecomplete(); ?>                            
                        </p>
                        </div>
                        <img src="<?php echo base_url().$foto; ?>" width="55;" alt="<?php echo $this->tank_auth->get_usernamecomplete(); ?>" class="img-circle">
                    </a> 
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-perfil">
                        <li><a href="<?=base_url()?>miInfo" title="Mi Info"><i class="fa fa-user"></i> Mi Info</a></li>
						<?
                        	if(in_array('configuraciones',$modulos)){
						?>
                        <li><a href="<?=base_url()?>configuraciones" title="Configuración"><i class="fa fa-cogs"></i> Configuración</a></li>

						<?
							}
						?>


                        <?
                            if(in_array('credenciales',$modulos)){
                        ?>
                         <li><a href="<?=base_url()?>validaciones" title="credenciales"><i class="fa fa-cogs"></i> Credenciales</a></li>
						<?
							}
						?>



                        <li><a  href="<?=base_url()?>index.php/auth/logout" title="Salir"><i class="fa fa-sign-out"></i> Salir</a></li>
                    </ul>
                </li>
            </ul>

 
        </div>
                  <div   id="bannerGira" name="bannerGira" class="bannerG">
           </div>
      </div>


<?/*===========================VALIDAMOS SI ES USUARIO CARCAPITAL PARA SOLO ACTIVAR DOS OPCIONES==================================*/?>  
 <!-- <div>
 	<div>

<div id="contieneMenu" style=" background-color:#361866; z-index: 1000">
<ul class="miUL"><a href="https://www.google.com.mx">Agentes</a>
</ul>
<ul class="miUL"><a href="#">Directorios</a></ul>

<ul class="miUL"><a href="#">Monitores</a></ul></ul>
<ul class="miUL"><label class="labelMenu">Actividades▼</label>
<li><a href="https://www.google.com.mx" >Consultar</a></li>
<li><a href="https://www.google.com.mx">Crear </a></li>
</ul>
<ul class="miUL"><label class="labelMenu">Accesorios▼</label>
<li><a href="https://www.google.com.mx" >Tienda</a></li>
<li><a href="https://www.google.com.mx">Capacita </a></li>
<li><a href="https://www.google.com.mx" >Mail </a></li>
<li><a href="https://www.google.com.mx" >Calendario </a></li>
</ul>
<ul class="miUL"><a href="#">Buson de inconformidad</a></ul>
<ul class="miUL"><a href="#">Calendario</a></ul>
<ul class="miUL"><label class="labelMenu">Catalogo tienda▼</label>
<li><a href="https://www.google.com.mx" >Agregar articulos</a></li>
<li><a href="https://www.google.com.mx">Modificar articulos </a></li>
</ul>
<ul class="miUL"><label class="labelMenu">Proyecto 100▼</label>
<li><a href="https://www.google.com.mx" >Proceso Prospeccion</a></li>
<li><a href="https://www.google.com.mx">Concentrado </a></li>
<li><a href="https://www.google.com.mx" >Reportes </a></li>
<li><a href="https://www.google.com.mx" >Funnel </a></li>
</ul>

<ul class="miUL"><a href="https://www.google.com.mx">Cotizador</a></ul>

<ul class="miUL"><label class="labelMenu">Reportes▼</label>
	<li><a href="https://www.google.com.mx" >Renovacion</a></li>
	<li><a href="https://www.google.com.mx" >Cartera </a></li>
	<li><a href="https://www.google.com.mx" >Cobranza pendiente </a></li>
	<li><a href="https://www.google.com.mx" >Cobranza efectuada</a></li>
	<li><form action="http://192.168.0.100/Capsys/www/V3/buscaXfolio" method="POST" class="form">
								 <input type="text" id="TbuscarXfolio" name="TbuscarXfolio" style="width: 95%" onclick="detienePropagacion(event)">
								<input type="submit" name="Consulta" id="Consulta" value="Buscar Poliza">
					  </form></li>
	<li><a href="https://www.google.com.mx" >Siniestros</a></li>
	<li><a href="https://www.google.com.mx" >Honorarios</a></li>
	<li><a href="https://www.google.com.mx" >Reportes ejecutivos</a></li>
	<li><a href="https://www.google.com.mx" >Reportes Ejecutivos Global</a></li>                  
	</ul>

<ul class="miUL"><label class="labelMenu">Presupuestos▼</label>
<li><a href="https://www.google.com.mx" >Proveedores</a></li>
<li><a href="https://www.google.com.mx">Agregar facturas </a></li>
<li><a href="https://www.google.com.mx" >Autoriza Pagos </a></li>
<li><a href="https://www.google.com.mx" >Aplicar pagos </a></li>
</ul>

<ul class="miUL"><a href="https://www.google.com.mx">Asistencias</a></ul>

</div>

<div id="agrupa22" class="miULDiv divhover" onclick="muestraContenido()"> 
<div class="divOculto" id="miCapaCont2">

</div>

</div> -->
<?php
  $correoProcedente=$this->tank_auth->get_usermail();
  $carcapital = $this->capsysdre->GetCarcapitalxEmail($correoProcedente);
  if($carcapital=='1')
  {
?>
    
<ul class="miUL"><label class="labelMenu">Reportes▼</label>                          
              <li><a  href="<?=base_url()?>renovaciones"  class="glyphicon glyphicon-usd">Renovaciones</a></li>
              <li><a  href="<?=base_url()?>produccion"  class="glyphicon glyphicon-usd">Cartera</a></li>            
              <li ><a href="<?=base_url()?>cobranzaPendiente" class="glyphicon glyphicon-usd">Cob. Pendiente</a></li>
              <li><a href="<?=base_url()?>cobranzaEfectuada" class="glyphicon glyphicon-usd">Cob. Efectuada</a></li>
              <li><a href="<?=base_url()?>cobranzaCancelada" class="glyphicon glyphicon-usd">Cob. Cancelada</a></li>
              <li>
              	<form action="<?=base_url();?>buscaXfolio" method="POST" class="form">
                      <input type="text" id="TbuscarXfolio" name="TbuscarXfolio" style="width: 95%" onclick="detienePropagacion(event)">
                      <input type="submit" name="Consulta" id="Consulta" value="Buscar Poliza"></button>
                 </form>
              </li>
              <li><a href="<?=base_url()?>siniestros" class="glyphicon glyphicon-usd">Siniestros</a></li>
              <li><a href="<?=base_url()?>honorarios" class="glyphicon glyphicon-usd">Honorarios</a></li>
 </ul >    
     
      <?/*======================================MENU proyecto 100==================================*/?>

      <!--   <li><a><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Proyecto100 ▼</a>-->
                       <ul class="miUL"><label class="labelMenu">Proyecto 100▼</label>
                          <li><a href="<?=base_url()?>crmproyecto" title="ProcesoProspecccion"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png""></span> Proceso Prospeccion</a></li>

                          <?
                          if(
                          $this->tank_auth->get_userprofile() == "3"
                          ||
                          $this->tank_auth->get_userprofile() == "4"
    
                          ){
                          ?>     

                           <li><a href="<?=base_url()?>crmproyecto/Estadistica" title="Concentrado"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Concentrado</a></li>

                          <?
                              }
                          ?>

                           <!--  <li><a href="<?=base_url()?>crmproyecto/estadistiscasGer" title="EstadisticasGerenciales"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Estadistica Gerencial</a></li>-->

                            <li><a href="<?=base_url()?>crmproyecto/Reportes" title="EstadisticasGerenciales"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Reportes Prospectos</a></li>
                                     
                            <li><a href="<?=base_url()?>funnel" title="EstadisticasGerenciales"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Funnel</a></li>      </ul>   
          

<?/*======================================MENU COTIZADOR==================================*/?>          


          <ul class="miUL">
                            <a  href="<?=base_url()?>cotizador" title="Car Capital"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuMail.png"></span>Car Capital</a>
          </ul>


<?/*======================================MENU PRESUPUESTOS==================================*/?> 


<?

}
else
{  

?>  


<ul class="menuPrincipal">
 
<?
  if(
    $this->tank_auth->get_userprofile() == "2"
    ||
    $this->tank_auth->get_userprofile() == "3"
    ||
    $this->tank_auth->get_userprofile() == "4"
     ||
    $this->tank_auth->get_userprofile() == "5"
    
  ){
?>    
     <ul class="miUL">
                            <a href="<?=base_url()?>configuraciones/listVend2" title="Agentes"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuDirectorio.png"></span> Agentes</a>
     </ul>
<?
  }
?>
      <ul class="miUL">
                            <a href="<?=base_url()?>directorio" title="Directorio"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuDirectorio.png"></span> Directorio</a>
      </ul>

      <!-- <li ><a ><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Reportes ▼</a>-->
                    <ul class="miUL"><label class="labelMenu">Reportes▼</label>                  
              <li><a  href="<?=base_url()?>renovaciones"  class="glyphicon glyphicon-usd">Renovaciones</a></li>
              <li><a  href="<?=base_url()?>produccion"  class="glyphicon glyphicon-usd">Cartera</a></li>            
              <li ><a href="<?=base_url()?>cobranzaPendiente" class="glyphicon glyphicon-usd">Cob. Pendiente</a></li>
              <li><a href="<?=base_url()?>cobranzaEfectuada" class="glyphicon glyphicon-usd">Cob. Efectuada</a></li>
              <li><a href="<?=base_url()?>cobranzaCancelada" class="glyphicon glyphicon-usd">Cob. Cancelada</a></li>
              <li><form action="<?=base_url();?>buscaXfolio" method="POST" class="form" onclick="detienePropagacion(event)">
                             <input type="text" id="TbuscarXfolio" name="TbuscarXfolio" style="width: 95%">
                            <input type="submit" name="Consulta" id="Consulta" value="Buscar Poliza"></button>
                  </form></li>

              <li><a href="<?=base_url()?>siniestros" class="glyphicon glyphicon-usd">Siniestros</a></li>
              <li><a href="<?=base_url()?>honorarios" class="glyphicon glyphicon-usd">Honorarios</a></li>

<?
if(
    $this->tank_auth->get_userprofile() == "2"
    ||
    $this->tank_auth->get_userprofile() == "3"
    ||
    $this->tank_auth->get_userprofile() == "4"
    
  ){
?>    
              <li><a href="<?=base_url()?>ejecutivos" class="glyphicon glyphicon-usd">Reportes Ejecutivos</a></li>
<?
  }
?>    

<?
if(
    $this->tank_auth->get_userprofile() == "2"
    ||
    $this->tank_auth->get_userprofile() == "3"
    ||
    $this->tank_auth->get_userprofile() == "4"
    
  ){
?>    
              <li><a href="<?=base_url()?>ejecutivos/ConsultaGlobal" class="glyphicon glyphicon-usd">Reportes Ejecutivos Global</a></li>
<?
  }
?>  


          </ul>
                          
       <!--</li>-->

<?
  if(
    $this->tank_auth->get_userprofile() == "2"
    ||
    $this->tank_auth->get_userprofile() == "3"
    ||
    $this->tank_auth->get_userprofile() == "4"
    
  ){
?>                        
                        <ul class="miUL">
                            <a href="<?=base_url()?>monitores" title="Monitores"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuReportes.png"></span> Monitores</a>
                        </ul><!-- glyphicon-scale -->
<?
  }
?> 


                   <!--<li><a><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Actividades ▼</a>-->
                       <ul class="miUL"><label class="labelMenu">Actividades▼</label> 
                            <li><a  href="<?=base_url()?>actividades" class="glyphicon glyphicon-eye-open"><span></span>Consultar</a></li>
                                       
                             <li <?php if ($activa == 'tienda'){ echo "class='active'"; } ?>>
                                 <a href="<?=base_url()?>actividades/agregar" class="glyphicon glyphicon-download-alt"><span></span>Crear</a>
                               </li>                                                            
                          
                        </ul>   
                    <!--</li>--> 


                    <!--<li><a><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Accesorios ▼</a>-->
                       <ul class="miUL" ><label class="labelMenu">Accesorios▼</label> 
                       <li><a href="<?=base_url()?>tienda" title="Tienda"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuTienda.png"></span> Tienda</a></li>
                        <li><a href="<?=base_url()?>capacita" title="Cap.A.Cita"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span> Cap.A.Cita</a></li>
                       <li><a href="<?=base_url()?>mailMasivo" title="Mail"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuMail.png"></span> Mail</a></li>
                       <li ><a  href="<?=base_url()?>calendario/index" title="Calendario"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCalendario.png"></span> Calendario</a></li>

                        </ul>   
                    <!--</li>-->

                <ul class="miUL">
                            <a  href="<?=base_url()?>binconformidad" title="Buzon"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuMail.png"></span>Buzon Inconformidad</a>
                        </ul>

                   
                    
                       <!-- <li >
                            <a  href="<?=base_url()?>videotutoriales" title="Videos"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>VideoTutoriales V3 Plus</a>
                        </li>-->




<?/*======================================MENU SMS==================================*/?>

<?
    if(
        $usermail == "DESARROLLO@AGENTECAPITAL.COM"
        ||
        $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
        ||
        $usermail == "SISTEMAS@ASESORESCAPITAL.COM"
    ){
?>                          
                    
                    <ul class="miUL" >
                              <a  href="<?=base_url()?>smsMasivo" title="Sms"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuSms.png"></span> SMS</a>
                    </ul>
                 
<?
    }
?>

<?/*======================================MENU CATALOGO TIENDA==================================*/?>

<?
    if(
        $usermail == "DESARROLLO@AGENTECAPITAL.COM"
        ||
        $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
        ||
        $usermail == "SISTEMAS@ASESORESCAPITAL.COM"
        ||
        $usermail == "MARKETING@AGENTECAPITAL.COM"
    ){
?>                          
                    
                   <!-- <li><a><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Catalogo Tienda ▼</a>-->
                       <ul class="miUL"><label class="labelMenu">Catalogo Tienda▼</label> 
                       <li><a href="<?=base_url()?>tienda/articulosAgregar" title="Agregar Articulos"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuTienda.png"></span> Agregar Articulos</a></li>
                        <li><a href="<?=base_url()?>tienda/articulosModificar" title="Modificar Articulos"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span> Modificar Articulos</a></li>
                      
                        </ul>   
                    <!--</li>-->

         
<?
    }
?>

<?/*======================================MENU proyecto 100==================================*/?>

        <!-- <li><a><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Proyecto100 ▼</a>-->
                       <ul  class="miUL" ><label class="labelMenu">Proyecto 100▼</label> 
                          <li><a href="<?=base_url()?>crmproyecto" title="ProcesoProspecccion"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png""></span> Proceso Prospeccion</a></li>



                          <?

                          if(
                          $this->tank_auth->get_userprofile() == "3"
                          ||
                          $this->tank_auth->get_userprofile() == "4"
    
                          ){
                          ?>     

                           <li><a href="<?=base_url()?>crmproyecto/Estadistica" title="Concentrado"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Concentrado</a></li>

                          <?
                              }
                          ?>

                           <!--  <li><a href="<?=base_url()?>crmproyecto/estadistiscasGer" title="EstadisticasGerenciales"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Estadistica Gerencial</a></li>-->

                            <li><a href="<?=base_url()?>crmproyecto/Reportes" title="EstadisticasGerenciales"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Reportes Prospectos</a></li>
                                     
                            <li><a href="<?=base_url()?>funnel" title="EstadisticasGerenciales"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Funnel</a></li>


                      
                        </ul>   
          <!--</li>-->

<?/*======================================MENU COTIZADOR==================================*/?>          


          <ul class="miUL">
                            <a  href="<?=base_url()?>cotizador" title="Car Capital"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuMail.png"></span>Car Capital</a>
          </ul>


<?/*======================================MENU PRESUPUESTOS==================================*/?> 

<? 

     $sqlConsultapermiso = "
        select count(up.usuario) as resul from usuariospresupuesto up 
        where up.usuario='".$usermail."'
                   ";
      $queryConsultapermiso = $this->db->query($sqlConsultapermiso);


      if($queryConsultapermiso != FALSE){
                  foreach ($queryConsultapermiso->result() as $row){
                    $totalResultados=$row->resul;
                  }
      }            

if($totalResultados>'0') 
{
?>    

<!--<li><a><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Presupuestos ▼</a>-->
                       <ul class="miUL"  ><label class="labelMenu">Proyecto 100▼</label> 




                            <li><a href="<?=base_url()?>presupuestos" title="Proveedores"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png""></span>Proveedores</a></li>


                            <li><a href="<?=base_url()?>presupuestos/Vistafacturas" title="Facturas"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png""></span> Agregar Factura</a></li>                           


                            <?
                            if(

                                $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
                                ||
                                $usermail == "SISTEMAS@ASESORESCAPITAL.COM"
                                ||
                                $usermail == "CONTABILIDAD@AGENTECAPITAL.COM"
                            ){
                            ?>        
                  

                           <li><a href="<?=base_url()?>presupuestos/Validaf" title="Validar Factura"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Validar Factura</a></li>
                            <?
                                }
                            ?>    



                            <?
                            if(

                                $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
                                ||
                                $usermail == "SISTEMAS@ASESORESCAPITAL.COM"
                                ||
                                $usermail == "ASISTENTEGENERAL@AGENTECAPITAL.COM"
                            ){
                            ?>        
                  

                           <li><a href="<?=base_url()?>presupuestos/AutorizaPago" title="Autorizar Pagos"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Autorizar Pago</a></li>
                            <?
                                }
                            ?>   




                            <?
                            if(

                                $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
                                ||
                                $usermail == "SISTEMAS@ASESORESCAPITAL.COM"
                                ||
                                $usermail == "ASISTENTEGENERAL@AGENTECAPITAL.COM"
                            ){
                            ?>    


                            <li><a href="<?=base_url()?>presupuestos/ListaPagosAutorizar" title="Aplicar Pagos"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Aplicar Pago</a></li>
                            <?
                                }
                            ?>   
                      </ul>            

<?
    }   //CIERRA EL MENU PRESUPUESTOS
?>                        
                      
                       


<?/*======================================MENU ASISTENCIAS==================================*/?> 

<?
  if(
    $this->tank_auth->get_userprofile() == "3"
    ||
    $this->tank_auth->get_userprofile() == "4"
    ||
    $this->tank_auth->get_userprofile() == "5"
    
  ){
?>                      
 
                        <ul class="miUL" >
                            <a href="<?=base_url()?>asistencias" title="Monitores"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuReportes.png"></span> Asistencias</a>
                        </ul><!-- glyphicon-scale -->

<?
  }
?> 


<?/*======================================MENU ACALL CENTER==================================*/?> 

<?
  if(
    $this->tank_auth->get_userprofile() == "3"
    ||
    $this->tank_auth->get_userprofile() == "4"
    ||
    $this->tank_auth->get_userprofile() == "5"
    
  ){
?>                        
    <!-- <li><a><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Telemarketing ▼</a>-->
                       <ul class="miUL"  ><label class="labelMenu">Telemarketing▼</label> 
                          <li><a href="<?=base_url()?>callcenter" title="Prospeccion"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png""></span>Proceso Telemarketing</a></li>

                           <li><a href="<?=base_url()?>callcenter/Reportes" title="Prospectos Telemarketing"><span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-menuCapacita.png"></span>Edicion Prospectos Telemarketing</a></li>
                       </ul  >      

                      
      <!--</li>-->
<?
  }
?> 










<?
}
?>

      
      
<?/*===============================================================================================================*/?>                      


                </div>
            </div>
        </nav>
<div>
    
</div>
<div id="agrupa2" class="miULDiv divhover" onclick="muestraContenido()"> 
	....
<div class="divOculto" id="miCapaCont">

</div>

</div>
<div style="clear: both;"></div>
 </header>


<style type="text/css">
#ventana-flotanteBL 
{
 width: 90%;  /* Ancho de la ventana */
 height:90%;  /* Alto de la ventana */
 background: white;/* Color de fondo */
 position: absolute;
 top: 10px;
 left: 5%;

 /* Borde de la ventana */
 box-shadow: 0 5px 25px rgba(0,0,0,.1);  /* Sombra */
 z-index:999999;
 overflow:scroll;
 padding-bottom:50px;
 padding-top: 50px;
 bottom: 200px;

}
.ver{visibility:visible;}
#ventana-flotanteBL .cerrar {
float: right;
border-bottom: 1px solid #bbb;
border-left: 1px solid #bbb;
color: #999;
background: red;
line-height: 17px;
text-decoration: none;
padding: 0px 14px;
font-family: Arial;
border-radius: 0 0 0 5px;
box-shadow: -1px 1px white;
font-size: 18px;
-webkit-transition: .3s;
-moz-transition: .3s;
-o-transition: .3s;
-ms-transition: .3s;
}
#ventana-flotanteBL .cerrar:hover {
background: #ff6868;
color: white;
text-decoration: none;
text-shadow: -1px -1px red;
border-bottom: 1px solid red;
border-left: 1px solid red;
}

.ocultoInicio {
visibility:hidden;}
.oculto {
  -webkit-transition:1s;-moz-transition:1s;-o-transition:1s;-ms-transition:1s;opacity:0;-ms-opacity:0;-moz-opacity:0;visibility:hidden;}

</style>
<style type="text/css">
.menuPrincipal {
font-family:sans-serif;
list-style:none;
text-decoration:none;
margin:0;
padding:0;
height: 100px;
z-index: 1200;background:#361866;
}
.menuPrincipal form{
  background-color: #361866;
  border-style: none;
  padding:0;
}
.menuPrincipal li{
  list-style:none;
  padding:0;
  z-index: 1200;
  }
 
.menuPrincipal > li {
float:left;
list-style:none;
padding:0;
z-index: 1200;
}
 
.menuPrincipal li a {
background:#361866;
color:#FFF;
display:block;
border:0px solid;
padding:10px 12px;
list-style:none;

}
 
.menuPrincipal li a:hover {
background: #9D8EBF;
list-style:none;

}

.menuPrincipal li ul {
display:none;
position:absolute;
min-width:140px;
list-style:none;
padding:0;
z-index: 1200;
border-style: outset;
border-color: #9D8EBF;
}

.menuPrincipal li:hover > ul {
display:block;
list-style:none;
}

.menuPrincipal li ul li {
position:relative;
list-style:none;
}
 
.menuPrincipal li ul li ul {
  list-style:none;
right:-140px;
top:0;
}
</style>
<style type="text/css">
   .bannerG{
    width: 100%;
    height: 70px;    
    visibility: visible;
    -webkit-animation: bannerG 60s infinite; 
    background-size: 100% 100%;
   
      background-image: url("<?php echo base_url(); ?>assets/imgBanner/OFICINA.png");
  }
  @keyframes bannerG{
  20%{      
      background-image: url("<?php echo base_url(); ?>assets/imgBanner/OFICINA.png");
    }
  35%{
      background-image: url("<?php echo base_url(); ?>assets/imgBanner/TALLER.png");
    }
  70%{
      background-image:url("<?php echo base_url(); ?>assets/imgBanner/MANUAL.png");
    }
  }
</style>
<script>

var globalAnchoPantalla=0;
window.addEventListener("resize", redimensionarMenu, true)
window.addEventListener("load", redimensionarMenu, true)

function redimensionarMenu(){	
var anchoPantalla=(window.innerWidth);
if(globalAnchoPantalla!=anchoPantalla){
	var menu=document.getElementsByClassName('miUL');var cantBtn=menu.length;
	var anchoBtn=200;var flecha="";var band0=0;	var stringDiv="";
	menu[cantBtn-1].classList.add("miULVisible");

	if(screen.width>=1000){		
	if(anchoPantalla>=600){	
	for(var i=0;i<cantBtn;i++)
	{   	
	   flecha="";
		menu[i].classList.remove("miULOculta");menu[i].classList.add("miULVisible");
		if(band0==0)
		{ 
		  if((anchoBtn+menu[i].clientWidth)<anchoPantalla){anchoBtn=anchoBtn+menu[i].clientWidth+10;}
		  else
		  {
			menu[i].classList.remove("miULVisible");
			menu[i].classList.add("miULOculta");
            stringDiv=stringDiv+'<ul class="divmiULocultar" onclick="muestraContenidSubMenu(this,event)">'+ menu[i].innerHTML+flecha+'</ul>';
			band0=1;
		  }
		}
		else
		{	menu[i].classList.remove("miULVisible");
			menu[i].classList.add("miULOculta");
            stringDiv=stringDiv+'<ul class="divmiULocultar" onclick="muestraContenidSubMenu(this,event)">'+ menu[i].innerHTML+flecha+'</ul>';		
		}

	}
	document.getElementById('miCapaCont').innerHTML=stringDiv;
	var classLabel=document.getElementsByClassName('labelMenu');var cant=classLabel.length;for(var j=0;j<cant;j++){classLabel[j].classList.remove("labelMenuMinimizar");}	
	document.getElementById('miCapaCont').classList.remove('divVisible');
  document.getElementById('miCapaCont').classList.add('divOculto');
  var miULDiv=document.getElementsByClassName('miULDiv');
	 miULDiv[0].style.width="100px";


	}
	else{  
		 		
		for(var i=0;i<cantBtn;i++)
	{    
			menu[i].classList.add("miULOculta");	
            stringDiv=stringDiv+'<ul class="divmiULocultarMovil" onclick="muestraContenidSubMenu(this,event)">'+ menu[i].innerHTML+flecha+'</ul>';
		
	}
	
	document.getElementById('miCapaCont').innerHTML=stringDiv;
	var classLabel=document.getElementsByClassName('labelMenu');var cant=classLabel.length;for(var j=0;j<cant;j++){classLabel[j].classList.add("labelMenuMinimizar");}	
	document.getElementById('miCapaCont').classList.remove('divVisible');
  document.getElementById('miCapaCont').classList.add('divOculto');

	 var miULDiv=document.getElementsByClassName('miULDiv');
	 miULDiv[0].style.width="1000px";

}
	}
	else{

	if(menu[0].classList.contains("miULOculta")==false) {
   for(var i=0;i<cantBtn;i++)
	{   
		menu[i].classList.add("miULOculta");	
        stringDiv=stringDiv+'<ul class="divmiULocultarMovil" onclick="muestraContenidSubMenu(this,event)">'+ menu[i].innerHTML+flecha+'</ul>';		
	}
	document.getElementById('miCapaCont').innerHTML=stringDiv;
	var classLabel=document.getElementsByClassName('labelMenu');var cant=classLabel.length;for(var j=0;j<cant;j++){classLabel[j].classList.add("labelMenuMinimizar");}	
	document.getElementById('miCapaCont').classList.remove('divVisible');
     document.getElementById('miCapaCont').classList.add('divOculto');
	 var miULDiv=document.getElementsByClassName('miULDiv');
	 miULDiv[0].style.width="1000px";



	}
	}

  globalAnchoPantalla=anchoPantalla;

 }
}

/*-------------MUESTRA LOS CONTENIDOS DE LOS SUBMENUS-----------------*/
function muestraContenidSubMenu(objeto,evento){

if(screen.width>=1000){var estadoClase=objeto.classList[0];	
	
  if((estadoClase=="divmiULocultar"))
  {objeto.classList.remove('divmiULocultar');objeto.classList.add('divmiULmostrar');}
  else
  {
	 if(estadoClase=="divmiULmostrar"){	objeto.classList.remove('divmiULmostrar');objeto.classList.add('divmiULocultar');
	 }else{
		if(estadoClase=="divmiULocultarMovil"){objeto.classList.remove('divmiULocultarMovil');objeto.classList.add('divmiULmostrarMovil');
		}else
		{objeto.classList.remove('divmiULmostrarMovil');objeto.classList.add('divmiULocultarMovil');}
	 }		
	}
}
else{
		var estadoClase=objeto.classList[0];
    if((estadoClase=="divmiULocultarMovil")){objeto.classList.remove('divmiULocultarMovil');objeto.classList.add('divmiULmostrarMovil');
	}else{objeto.classList.remove('divmiULmostrarMovil');objeto.classList.add('divmiULocultarMovil');}	
	}
//}
	}
/*---------------------------------------------------------------------------------*/
/*---------------MUESTRA EL CONTENIDO DEL MENU AL ESTAR MINIMIZADO-----------------*/
function muestraContenido(){
if(event.srcElement.nodeName=="DIV"){var estadoClase=document.getElementById('miCapaCont').classList[0];
    if((estadoClase=="divOculto")){document.getElementById('miCapaCont').classList.remove('divOculto');document.getElementById('miCapaCont').classList.add('divVisible');
	}else{document.getElementById('miCapaCont').classList.remove('divVisible');document.getElementById('miCapaCont').classList.add('divOculto');		
	}
  }
}
function detienePropagacion(e)
{
	e.stopPropagation();
}
/*-------------------------------------------------------------------------------*/

</script>

<style>
label{font-size: 12px}
	.divOculto{display:none;}
	.divOculto:hover { background-color:green; cursor:progress}
	
	.divVisible{ display:block;  height: 40px;margin: 20px;  }
	.divVisible > ul{ position:relative; left:-40px; top:-10px; margin: 0px; border:outset; width: 1000px; background-color: #361866 }
	
	.miULDiv{ float:  left; height: 40px; width:100px; border:solid ; position:relative; top:0px; background-color:#361866; background-size:40px;  background-repeat:no-repeat ;z-index:100; ; color: white;padding-left: 40px}
	.miULDiv:hover{background-color:#9d8ebf}
	.miULResponsivo{ float:  left; height: 40px; width:1000px; border:solid ; position:relative; top:16px; background-color:#361866;background-size:40px;  background-repeat:no-repeat  }
	
	.miUL:hover > a {background-color:#9d8ebf}
	.miUL:hover > label {background-color:#9d8ebf}
	
	.divmiUL {background-color:#361866;  z-index:120;position:relative; left:-10px}
	
	.divmiULocultar {  position:relative; top:200px; margin:0px; width:120px; background:#361866}
	.divmiULocultar > li{ display:none; border:solid; position:relative; top:20px; width: 200px; height: 20px}
	.divmiULocultar > a {  color:white}
	.divmiULocultar > label {  color:white}
	.divmiULocultar:hover{background-color:#9d8ebf}
	.divmiULocultar:hover > a { background-color:#9d8ebf; color:white}
	.divmiULocultar:hover > label { background-color:#9d8ebf; color:white}
	
	.divmiULocultarMovil {  position:relative; top:200px; margin:0px; width:100px;height:100px ; background:#361866, }
	.divmiULocultarMovil > li{ display:none; border:double; position:relative; top:20px; }
	.divmiULocultarMovil > a{  color:white; font-size:36px ;}
	.divmiULocultarMovil > label{  color:white; font-size:36px ;}
	.divmiULocultarMovil:hover{background-color:#9d8ebf; }
	.divmiULocultarMovil:hover > a,label¿ { background-color:#9d8ebf; color:white}
	
	.divmiULmostrar{width:150px;}
	.divmiULmostrar > li{ display:block;  width:150px;background-color:#6218da;color:white; margin-left: 15px ;}
	.divmiULmostrar > li > a{ background-color:#6218da;color:white; width: 100px;}

	.divmiULmostrar > li > a:hover{ background-color:#9d8ebf; width: 100px }
	
	.divmiULmostrarMovil{background-color:#361866;color:white; width:1000px}
	.divmiULmostrarMovil > li{ display:block; border:double; width:200px; margin-left:15px;background-color:#361866;color:white }
	.divmiULmostrarMovil > li > a{ background-color:#361866;color:white;font-size:36px }
	.divmiULmostrarMovil > li:hover { background-color:#9d8ebf;font-size:36px }
	.divmiULmostrarMovil > li > a:hover{ background-color:#9d8ebf }
	
	.labelMenu{background-color:#361866;color:white; font-size: 14px; }
	.labelMenu:hover {background-color:#9d8ebf;color:white}
	.labelMenuMinimizar{font-size: 36px; width:1000px}

	
	.miUL{ float:  left; height: 40px; width:100px; border:solid ;display:block ; background-color:#361866;color:#361866; border:double}
	.muUL:hover{ background-color:#9d8ebf}
	.miUL > a{ background-color:#361866;color:white;width: 250px}
	.miUL > li{ display:none; position:relative;; top:-2px; width: 150px  }
	.miUL > li:hover{background-color:#9d8ebf ;border:groove }
	.miUL:hover li{display:block;   z-index:100;  }
	
	.miULVisible{display:block; background-color:#361866; height: 40px; width: auto;padding: 10px }
	.miULVisible > li{background-color:#361866; width: 150px }
	.miULVisible > li > a{color:white; width: 150px;border: outset}
	.miULVisible:hover{background-color:#9d8ebf; }
	
	.miULOculta{ display:none}
	
	/*li {display:none} #9d8ebf*/
	
	</style>
