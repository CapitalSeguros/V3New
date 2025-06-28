<? $this->load->view('headers/header'); ?>
<!-- Navbar -->
<? $this->load->view('headers/menu'); 
$this->load->model('PersonaModelo');
?>


<style type="text/css">
   .panel_botones{
    background-color: #fff;
    width: 9%;
    border-radius: 8px;
    float: left;
    margin-left: -40px;
    padding: 5px;
    padding-top: 20px;
    margin-right: 15px;
    height:auto;
    margin-top: 2px;
  }
  .boton{
    border-style: solid;
    border-radius: 8px;
    border-width: 1px;
    margin-top: -5%;
    margin-bottom: 10%;
    text-align: center;
  }
  .lbboton{
    font-size: 12px;font-family: verdana;
  }
   .btn-primary {
    color: #fff;
    background-color: #67439f;
    border-color: #57348c;
  }
  .btn-primary:hover{
    background-color: #DBA901;
    border-color: #DBA901;
  }
  .principal{
  	float: left;
  	width: 90%;
  	margin-top: 2%;
  }
  #table_id{
  	font-size: 11px;
  }
#editar{
   background-color: rgba(0, 0, 0, 0.7);
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   z-index: 1050;
}
</style>
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<div class="container">
<div class="panel_botones">
  <table>
     <tr>
      <td>
        <a href="<?=base_url()?>capitalHumano">
        <div class="boton"><br>
        &nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-arrow-left fa-4x"></i>&nbsp;&nbsp;&nbsp;&nbsp;<br>
         <span class="lbboton">Volver</span>
         <br><br>
        </div>
         </a>
      </td>
    </tr>
  </table>
</div>
<div class="principal" class="well" style="padding: 1%;background-color: #F2F2F2;border-radius: 8px;">
	<h4>Activar Asesor Capital en Pagina Web</h4>
	<br>
	<input type="hidden" name="activo" value="1">
	<table  id="table_id" class="display" width="100%">
		<thead>
			<tr style="background-color: #361666;color: #fff;">
        <th></th>
				<th>Foto</th>
				<th>Cedula</th>
				<th>Nombre y Apellido</th>
				<th>Email</th>
				<th>Telefono</th>
				<th>Estado</th>
				<th style="text-align: center"><i class="fa fa-cogs"></i></th>
			</tr>
		</thead>
		<tbody>

    <?php 
		$ruta="https://www.capsys.com.mx/V3/assets/img/miInfo/userPhotos/";
foreach ($asesores as $row) {
      $detalles=$this->PersonaModelo->devuelveInfoUserAcerdaDe($row->idPersona);
      $acerca_de="";
      $formacion="";
      $experiencia="";
      $espanol="";
      $ingles="";
      $frances="";
      $autos="";
      $gmm="";
      $vidas="";
      $danos="";
      $fianzas="";
      foreach ($detalles as $detalle) {
        $acerca_de=$detalle->acerca_de;
        $formacion=$detalle->formacion;
        $experiencia=$detalle->experiencia;
        $espanol=$detalle->espanol;
        $ingles=$detalle->ingles;
        $frances=$detalle->frances;
        $autos=$detalle->autos;
        $gmm=$detalle->gmm;
        $vidas=$detalle->vidas;
        $danos=$detalle->danos;
        $fianzas=$detalle->fianzas;
      }

      $nombre=$row->nombre.' '.$row->apellidop;
      $email=$row->emailUser;

    ?>
			<tr>
        <td>
          <a href="#" data-toggle="modal" data-target="#editar" onclick="editar('<?php echo $row->idPersona;?>','<?php echo $ruta.$row->fotoUser;?>','<?php echo $acerca_de;?>','<?php echo $nombre;?>','<?php echo $email?>','<?php echo $formacion?>','<?php echo $experiencia?>','<?php echo $autos?>','<?php echo $gmm?>','<?php echo $vidas?>','<?php echo $danos?>','<?php echo $fianzas?>','<?php echo $espanol?>','<?php echo $ingles?>','<?php echo $frances?>')"><i class="fa fa-edit fa-2x"></i></a>
        </td>
				<td width="10%"><img src="<?php echo $ruta.$row->fotoUser;?>" width="80%" class="img-fluid rounded-circle b-shadow-a"></td>
				<td><?php echo $row->cedula_cnsf;?></td>
				<td><?php echo strtoupper($row->nombre)." ".strtoupper($row->apellidop);?></td>
				<td><?php echo $row->emailUser;?></td>
				<td><?php echo $row->telefono_celular;?></td>

       

      <?php 
        if ($this->PersonaModelo->devuelveInfoUserActivo($row->idPersona)==1){?>
        <td><span class="badge badge-default" style="background-color: #0066cc;color: #fff;font-size: 12px;">Activo</span></td>
        <td style="text-align: center;">
          <button type="button" class="btn btn-default btn-md" style="border-radius: 8px;border-style: solid;border-color: silver;" onclick="activarAsesor('<?php echo $row->idPersona;?>','<?php echo $row->cedula_cnsf;?>','<?php echo $row->fotoUser;?>','<?php echo $autos?>','<?php echo $gmm?>','<?php echo $vidas?>','<?php echo $danos?>','<?php echo $fianzas?>')"><i class="fa fa-check-circle"></i> Desactivar</button>
        </td>
      <?php }else{?>
        <td><span class="badge badge-default" style="background-color: silver;color: #000;font-size: 12px;">Inactivo</span></td>
         <td style="text-align: center;">
          <button type="button" class="btn btn-default btn-md" style="border-radius: 8px;border-style: solid;border-color: silver;" onclick="activarAsesor('<?php echo $row->idPersona;?>','<?php echo $row->cedula_cnsf;?>','<?php echo $row->fotoUser;?>','<?php echo $autos?>','<?php echo $gmm?>','<?php echo $vidas?>','<?php echo $danos?>','<?php echo $fianzas?>')"><i class="fa fa-check-circle"></i> Activar</button>
          
        </td>
      <?php }?>

			</tr>
		<?php }?>
		</tbody>
	</table>	
</form>
	
</div>

<!-- Modal Editar acerca de mi-->
<div id="editar" class="modal" role="dialog">
  <form  enctype="multipart/form-data" name="frmeditar" id="frmeditar" method="post" action="<?php echo base_url()?>persona/modificar_acerca_de_mi">
  <input type="hidden" name="id_editar" id="id_editar" value="<?php echo $row->idPersona;?>">
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;Editar Acerca de Mi</h4>
        <div style="text-align: right;">
           <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="modal-body">
        <table border="0">
          <tr>
            <td><output id="list1" style="width: 40%"></output></td>
            <td style="text-align: left;width: 60%">
              <b>Nombre y Apellido: </b><span id="nombre"></span><br>
              <b>Email: </b><span id="email"></span>
            </td>
          </tr>
          <tr>
           <td><label style="font-weight: bold;">&nbsp;Seleccione Foto:</label></td>
           <td></td>
          </tr>
           <tr>
            <td colspan="2">
              <input type="file" id="imagen1" name="imagen1" />
            </td>
          </tr>
          <tr>
            <td colspan="2"><hr></td>
          </tr>
          <tr>
            <td colspan="2" style="font-size: 14px;font-weight: bold;">&nbsp;<i class="fa fa-edit"></i>&nbsp;Detalles de acerca de Mi</td>
          </tr>
          <tr>
            <td colspan="2">
              <textarea id="txtdetalle" name="txtdetalle" rows="6" cols="68" style="font-size: 12px;"></textarea>
            </td>
          </tr>
           <tr>
            <td colspan="2"><hr></td>
          </tr>
          <tr>
            <td colspan="2">
              <table>
                <tr>
                  <td colspan="2" style="font-size: 14px;font-weight: bold;text-align: center;">&nbsp;<i class="fa fa-edit"></i>&nbsp;Activar Especialidades</td>
                </tr>
                <tr>
                  <td><input type="checkbox" id="chkautos" name="chkautos" value="1"></td><td>AUTOS</td>
                </tr>
                <tr>
                  <td><input type="checkbox" id="chkgmm" name="chkgmm" value="1"></td><td>GMM</td>
                </tr>
                <tr>
                  <td><input type="checkbox" id="chkvidas" name="chkvidas" value="1"></td><td>VIDA</td>
                </tr>
                <tr>
                  <td><input type="checkbox" id="chkdanos" name="chkdanos" value="1"></td><td>DAÑOS</td>
                </tr>
                <tr>
                  <td><input type="checkbox" id="chkfianzas" name="chkfianzas" value="1"></td><td>FIANZAS</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2"><hr></td>
          </tr>
          <tr>
            <td colspan="2"  style="font-size: 14px;font-weight: bold;">&nbsp;<i class="fa fa-edit"></i>&nbsp;Formación Academica</td>
          </tr>
           <tr>
            <td colspan="2">
              <textarea id="txtformacion" name="txtformacion" rows="6" cols="68" style="font-size: 12px;"></textarea>
            </td>
          </tr>
           <tr>
            <td colspan="2"><hr></td>
          </tr>
           <tr>
            <td colspan="2" style="font-size: 14px;font-weight: bold;">&nbsp;<i class="fa fa-edit"></i>&nbsp;Experiencia Profesional</td>
          </tr>
           <tr>
            <td colspan="2">
              <textarea id="txtexperiencia" name="txtexperiencia" rows="6" cols="68" style="font-size: 12px;"></textarea>
            </td>
          </tr>
           <tr>
            <td colspan="2"><hr></td>
          </tr>
         
           <tr>
            <td colspan="2">
              <table>
                <tr>
                  <td colspan="2" style="font-size: 14px;font-weight: bold;text-align: center;"><i class="fa fa-edit"></i>&nbsp;Seleccione Idiomas</td>
                </tr>
                <tr>
                  <td><input type="checkbox" id="chkespanol" name="chkespanol" value="1"></td><td>&nbsp;ESPAÑOL</td>
                </tr>
                <tr>
                  <td><input type="checkbox" id="chkingles" name="chkingles" value="1"></td><td>&nbsp;INGLES</td>
                </tr>
                <tr>
                  <td><input type="checkbox" id="chkfrances" name="chkfrances" value="1"></td><td>&nbsp;FRANCES</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2"><hr></td>
          </tr>
           <tr>
                <td colspan="2" style="text-align: center;"> 
                  <button type="submit" class="btn btn-primary" ><i class="fa fa-check"></i>&nbsp;Guardar las Modificaciones</button>
                </td>
            </tr>
          </table>
          </div>
      </div>
    </div>
  </form>
</div>



<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(document).ready( function () {
     $('#table_id').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por Pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrar Pagina por Pagina",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "search":"Buscar",
            "paginate": {
      			"previous": "Anterior",
      			"next": "Siguiente"
    		}
        }
    } );
} );
 
  function editar(id,foto,detalle,nombre,email,formacion,experiencia,autos,gmm,vidas,danos,fianzas,espanol,ingles,frances){
    document.getElementById('id_editar').value=id;
    document.getElementById('txtdetalle').value=detalle;
    document.getElementById('list1').innerHTML="<img src="+foto+" width='100%'>";
    document.getElementById('nombre').innerHTML=nombre;
    document.getElementById('email').innerHTML=email;
    document.getElementById('txtformacion').innerHTML=formacion;
    document.getElementById('txtexperiencia').innerHTML=experiencia;
    if(espanol==1){
      document.getElementById('chkespanol').checked = true;
    }
    if(ingles==1){
      document.getElementById('chkingles').checked = true;
    }
    if(frances==1){
      document.getElementById('chkfrances').checked = true;
    }
    if(autos==1){
      document.getElementById('chkautos').checked = true;
    }
    if(gmm==1){
      document.getElementById('chkgmm').checked = true;
    }
    if(vidas==1){
      document.getElementById('chkvidas').checked = true;
    } 
    if(danos==1){
      document.getElementById('chkdanos').checked = true;
    }
    if(fianzas==1){
      document.getElementById('chkfianzas').checked = true;
    }

  }

  function archivo1(evt) {
          var files = evt.target.files; 
          for (var i = 0, f; f = files[i]; i++) {
            var reader = new FileReader();
            reader.onload = (function(theFile) {
            return function(e) {
            document.getElementById("list1").innerHTML = ['<img class="thumb" width="60%" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
          };
        })(f);
          reader.readAsDataURL(f);
          }
        }
        document.getElementById('imagen1').addEventListener('change', archivo1, false);



function activarAsesor(id,cedula,foto,autos,gmm,vidas,danos,fianzas){
 if((autos!=0)||(gmm!=0)||(vidas!=0)||(danos!=0)||(fianzas!=0)){
   if((cedula=='')||(foto=='noPhoto.png')){
      alert("Para activar al asesor, Es requerido: cedula y foto");
    }else{
     document.location.href="<?php echo base_url()?>persona/activarAsesor?id="+id;
    }
  }else{
       alert("Para activar al asesor, Es requerido: cedula, foto y al  menos una especialidad");
  }
}

</script>



 


