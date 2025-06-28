<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<style>

</style>
<!--pre>

</pre-->
<header class= "header">
 <h3>PROMOTORIA</h3>
</header> 

<div class="row">
  <div class="col-sm-12">
    <table class="table">
     <thead>
     <tr>
      <th>Editar</th>
      <th>Promotoria  <input type="checkbox" class="" id="aplicarFiltro" onclick="ocultarDeshabilitados()"></th>
      <th>Telefono</th>
      <th>Correo</th>
      <th>Tipo</th>
     
     </tr>
     </thead>
     <tbody>
     <?php
          if($companias != FALSE){
            foreach ($companias as $row)
              {$clase="";if($row->activoPresupuestos==0){$clase='class="promotoriaDeBaja"';}
               ?>
                  <tr data-id="<?=$row->idPromotoria?>" data-telefono="<?=$row->Telefono?>" data-correo="<?=$row->Correo?>" data-tipo="<?=$row->Tipo?>" data-status="<?=$row->activoPresupuestos?>" data-nombre="<?=$row->Promotoria?>" <?=$clase?>>
                   <!--form method="post" action ="<?=base_url()?>cheques/editaPromotor/"-->              
                    <td><button  class="btn btn-success" value="<?=$row->idPromotoria?>" name="IDCheq" id="IDCheq" onclick="editarCompania(this)">Editar</td>
                    <!--/form-->
                    <!--td><?=$row->idPromotoria?></td-->                     

                    <td><?=$row->Promotoria?></td>
                    <td><?=$row->Telefono?></td>
                    <td><?=$row->Correo?></td>                                              
                    <td><?=$row->Tipo?></td>                                
                                                       
                 </tr>
              <?php
              }
           }
         ?>
     </tbody>
    </table>
    </div>
  <div>  
<div id="divModalGenerico" class="modalCierra">
    <div id="divModalContenidoGenerico" class="modal-contenido"  >
      <div class="row" >
      <div class="col-md-2 col-sm-2" >
      <button onclick="abrirModalFecha(this)" style="color: white;background-color:red; border:double;">X</button>
      </div>

    </div>  
<hr>

  <form id="grabarFechaForm" method="POST" action="<?=base_url()?>cheques/guardaPromotor/">
      <input type="hidden" name="id" id="idPromotoria">
          <div class="row">   
              <div class="col-md-4 col-sm-4" ><h4> <label class="label label-info">Compañias</label></h4></div>
              <div class="col-md-8 col-sm-8" >  <input type="text" name ="nombre" id="nombrePromotoria"  class="form-control input-sm"></div>
          </div>
          <div class="row">   
              <div class="col-md-4 col-sm-4" ><h4> <label class="label label-info">Telefono</label></h4></div>
              <div class="col-md-8 col-sm-8" >  <input type="text" name ="Telefono" id="telefonoPromotoria" class="form-control input-sm"></div>
          </div>
                    <div class="row">   
              <div class="col-md-4 col-sm-4" ><h4> <label class="label label-info">Correo</label></h4></div>
              <div class="col-md-8 col-sm-8" >  <input type="text" name ="Correo" id="correoPromotoria" class="form-control input-sm"></div>
          </div>
                    <div class="row">   
              <div class="col-md-4 col-sm-4" ><h4> <label class="label label-info">Asegurador/Compania</label></h4></div>
              <div class="col-md-8 col-sm-8" >             
                <select name="Tipo" id="TipoPromotoria" class="form-control input-sm" >
                 <option value=""></option>
                 <option value="SEGURO">SEGURO</option>
                 <option value="AFIANZADORA">AFIANZADORA</option>
                </select> </div>
          </div>
            <div class="row">   
              <div class="col-md-4 col-sm-4" ><h4> <label class="label label-info">Status</label></h4></div>
              <div class="col-md-8 col-sm-8" >  <select name="status" id="statusPromotoria" class="form-control input-sm">
                 <option value=""></option>
                 <option value="0">DESHABILITADO</option>
                 <option value="1">HABILITADO</option>
                </select> </div>
          </div>
          <br>
          <div class="col-md-8 col-sm-8"></div>
  <div class="col-md-4 col-sm-4"><button class="btn btn-success" >Guardar</button></div>

  </form>

</div>

</div>
<script type="text/javascript">
  function ocultarDeshabilitados()
  {let check=document.getElementById('aplicarFiltro').checked;
    let row=Array.from(document.getElementsByClassName('promotoriaDeBaja'));
    if(check){row.forEach(r=>{r.classList.remove('ocultarRow')})}
    else{row.forEach(r=>{r.classList.add('ocultarRow')})}
  }
  function editarCompania(objeto)
{
  let val=objeto.parentNode.parentNode;
  document.getElementById('nombrePromotoria').value=val.dataset.nombre;
  document.getElementById('telefonoPromotoria').value=val.dataset.telefono;
  document.getElementById('correoPromotoria').value=val.dataset.correo;
  document.getElementById('TipoPromotoria').value=val.dataset.tipo;
  document.getElementById('statusPromotoria').value=val.dataset.status;
  document.getElementById('idPromotoria').value=val.dataset.id;

  abrirModalFecha()
}
    function abrirModalFecha(objeto='')

  {
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');
     // let row=objeto.parentNode.parentNode;
     /* document.getElementById('usuarioFacturaID').innerHTML=row.dataset.id;
      document.getElementById('usuarioFacturaFolio').innerHTML=row.dataset.usuario;
      document.getElementById('IDFact').value=row.dataset.id;
      document.getElementById('IDUser').value=row.dataset.usuario;
      document.getElementById('usuarioFacturaEmail').innerHTML=row.dataset.folio;
      document.getElementById('grabarFechaForm').setAttribute('action',objeto.dataset.href)*/
  }

ocultarDeshabilitados();
</script>

<style type="text/css"> body{overflow: scroll;}
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;transition: all 1s;width:100%;height:100%;z-index: 10000}
.modal-contenido{background-color:white;width:40%;height:70%;padding: 0% 0%;margin: 0% auto;position: relative;top: 20%;bottom: -20% }
.promotoriaDeBaja{background-color: #b1abab;font-style:oblique;text-decoration: line-through; }
.ocultarRow{display: none}
</style>
