<!-- Configuración Agenda -->
<div id="configuracion">
<?php
  $this->load->view('headers/headerReportes');
  //$this->load->view('crmproyecto/notificacion');

  $id_userInfo=$this->tank_auth->get_idPersona();
  $ListaAgenda=$this->crmProyecto_Model->agenda_citas_asesores($id_userInfo);
  $configuracion=$this->crmProyecto_Model->confguracion_agenda($id_userInfo);

  function mesLetra($mes){
    switch ($mes) {
        case 1:return 'ENERO';break;
        case 2:return 'FEBRERO';break;
        case 3:return 'MARZO';break;
        case 4:return 'ABRIL';break;
        case 5:return 'MAYO';break;
        case 6:return 'JUNIO';break;
        case 7:return 'JULIO';break;
        case 8:return 'AGOSTO';break;
        case 9:return 'SEPTIEMBRE';break;
        case 10:return 'OCTUBRE';break;
        case 11:return 'NOVIEMBRE';break;
        case 12:return 'DICIEMBRE';break;
    }
}
?>
<style type="text/css">
  .agendaCitaDiv div{display: flex;flex-direction: column;}
   .agendaCitaDivPrincipal{display: flex;justify-content: space-between;}
   .agendaCitaDivPrincipal div[data-tipo="boton"]{flex: 2}
   .agendaCitaDivPrincipal div[data-tipo="calendario"]{flex: 3}
   .agendaCitaDivPrincipal div[data-tipo="label"]{flex: 1}
    @media only screen and (max-width:768px)
  {
    .agendaCitaDivPrincipal{flex-direction: column;}
  }


</style>
    
      <!--h3 class="titulo-secciones">
    Configuración de Agenda Personal (Mensual)</h3></div></div><hr/--> 
      <?php //echo $this->tank_auth->get_username();?>
    
        <input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
        <input type="hidden" name="id_userInfo" id="id_userInfo" value="<?php echo $id_userInfo?>">
        <input type="hidden" name="mesActual" id="mesActual" value="<?php echo date('m')?>">
        <input type="hidden" name="yearActual"  id="yearActual" value="<?php echo date('Y')?>">
       
<div> <h4>&nbsp;Mes Actual:</b> <?php echo mesLetra(date('m'));?></h4></div>
<div class="agendaCitaDivPrincipal">  
  <div class="agendaCitaDiv" data-tipo="label"><label class=""><h4>Atencion de Lunes a Viernes</h4></label></div>
  <div class="agendaCitaDiv" data-tipo="calendario"><div><b><i class="fa fa-calendar"></i>&nbsp;Hora de inicio</b>
           <select name="hinicio" id="hinicio" class="form-control">
             <option value="7">07:00</option>
             <option value="8">08:00</option>
             <option value="9">09:00</option>
             <option value="10">10:00</option>
             <option value="11">11:00</option>
             <option value="12">12:00</option>
             <option value="13">13:00</option>
             <option value="14">14:00</option>
             <option value="15">15:00</option>
             <option value="16">16:00</option>
             <option value="17">17:00</option>
             <option value="18">18:00</option>
           </select>
         </div>
  </div>
  <div class="agendaCitaDiv" data-tipo="calendario">
    <b><i class="fa fa-calendar"></i>&nbsp;Hora final</b>
           <select name="hfinal" id="hfinal" class="form-control"∫>
             <option value="7">07:30</option>
             <option value="8">08:30</option>
             <option value="9">09:30</option>
             <option value="10">10:30</option>
             <option value="11">11:30</option>
             <option value="12">12:30</option>
             <option value="13">13:30</option>
             <option value="14">14:30</option>
             <option value="15">15:30</option>
             <option value="16">16:30</option>
             <option value="17">17:30</option>
             <option value="18">18:30</option>
             <option value="19">19:30</option>
           </select>
  </div>
  <div class="agendaCitaDiv" data-tipo="boton">
    <br><button type="button" class="btn btn-default" onclick="agregarAgenda();cargarPagina('crmproyecto/agenda_citas_asesores',document.getElementById('agendaCitasAsesoresBTN'))" style="background-color: #E2E2E2;"><i class="fa fa-calendar"></i>&nbsp;Agregar Agenda</button>
  </div>
 </div>

</div>

<style type="text/css">
  .table>thead{position: sticky;;top:0px;}
</style>
<div style="height: 300px;max-height: 300px;overflow: scroll;";>
  <table class="table">
    <thead>
      <tr>
        <th colspan="3"><h4>Configuración actual mes: <?php echo mesLetra(date('m'))?> del <?php echo date('Y')?></h4></th>
      </tr>
      <tr><th><i class="fa fa-calendar"></i>&nbsp;Hora inicial de atención</th><th><i class="fa fa-calendar"></i>&nbsp;Hora final de atención</th><th><i class="fa fa-cogs"></i></th></tr>
    
    </thead>
      
    <tbody>
    <?php foreach ($configuracion as $row) {?>
    <tr>
      <td><?php echo $row->hinicio.":00"?></td><td><?php echo $row->hfinal.":00"?></td><td>
        <a href="#" onclick="eliminarAgenda(<?php echo $row->id?>)"><i class="fa fa-times-circle fa-2x"></i></a>
      </td>
    </tr>
    <?php }?>
    </tbody>
  </table>
</div>
<!--section class="container-fluid breadcrumb-formularios"><div class="row"><div class="col-md-8 col-sm-8 col-xs-8">
       <table width="80%" border="1" style="border-color: #E2E2E2;border-style: solid;">
        <tr>
          <td><b>&nbsp;Mes Actual:</b> <?php echo mesLetra(date('m'));?></td>
          <td colspan="3"></td>
        </tr>
         <tr>
         <td><b>&nbsp;Rango de Atención de Lunes a Viernes:</b></td>
         <td><b><i class="fa fa-calendar"></i>&nbsp;Hora de inicio</b>
           <select name="hinicio" id="hinicio" class="form-control">
             <option value="7">07:00</option>
             <option value="8">08:00</option>
             <option value="9">09:00</option>
             <option value="10">10:00</option>
             <option value="11">11:00</option>
             <option value="12">12:00</option>
             <option value="13">13:00</option>
             <option value="14">14:00</option>
             <option value="15">15:00</option>
             <option value="16">16:00</option>
             <option value="17">17:00</option>
             <option value="18">18:00</option>
           </select>
          </td>
        <td><b><i class="fa fa-calendar"></i>&nbsp;Hora final</b>
           <select name="hfinal" id="hfinal" class="form-control"∫>
             <option value="7">07:30</option>
             <option value="8">08:30</option>
             <option value="9">09:30</option>
             <option value="10">10:30</option>
             <option value="11">11:30</option>
             <option value="12">12:30</option>
             <option value="13">13:30</option>
             <option value="14">14:30</option>
             <option value="15">15:30</option>
             <option value="16">16:30</option>
             <option value="17">17:30</option>
             <option value="18">18:30</option>
             <option value="19">19:30</option>
           </select>
          </td>
          <td style="text-align: center;"><button type="button" class="btn btn-default" onclick="agregarAgenda()" style="background-color: #E2E2E2;"><i class="fa fa-calendar"></i>&nbsp;Agregar Agenda</button></td>
        </tr>
      </table>
  </section-->
<!--section style="margin-left: 5%;">
  <table style="width: 50%">
    <tr>
      <td colspan="3"><h4>Configuración actual mes: <?php echo mesLetra(date('m'))?> del <?php echo date('Y')?></h4></td>
    </tr>
    <tr style="background-color: #E6E6E6"><th><i class="fa fa-calendar"></i>&nbsp;Hora inicial de atención</th><th><i class="fa fa-calendar"></i>&nbsp;Hora final de atención</th><th><i class="fa fa-cogs"></i></th></tr>
    <?php foreach ($configuracion as $row) {?>
    <tr>
      <td><?php echo $row->hinicio.":00"?></td><td><?php echo $row->hfinal.":00"?></td><td>
        <a href="#" onclick="eliminarAgenda(<?php echo $row->id?>)"><i class="fa fa-times-circle fa-2x"></i></a>
      </td>
    </tr>
    <?php }?>
  </table>
</section-->
</div>



















