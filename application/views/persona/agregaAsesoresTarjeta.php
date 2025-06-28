<? $this->load->view('headers/header'); 
   $this->load->view('headers/menu'); 
   $this->load->model('personamodelo');
?>

<style type="text/css">
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
    width: 100%;
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
<div class="principal" class="well" style="background-color: #F2F2F2;border-radius: 8px;">
  <h4>Activar Tarjeta Digital</h4>
  <br>
  <div id="pantalla"></div>
  <input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
  <table  id="table_id" class="display" width="100%">
    <thead>
      <tr style="background-color: #361666;color: #fff;">
        <th></th>
        <th>Foto</th>
        <th>ID</th>
        <th>Nombre y Apellido</th>
        <th>Ciudad</th>
        <th>E-mail</th>
        <th>Telefono</th>
        <th style="text-align: center"><i class="fa fa-cogs"></i></th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $ruta="https://www.capsys.com.mx/V3/assets/img/miInfo/userPhotos/";
      foreach ($asesores as $row) {
        $nombre=$row->nombre.' '.$row->apellidop?>
        <tr>
        <td><a href="#" data-toggle="modal" data-target="#editar" onclick="editar('<?php echo $row->idPersona;?>','<?php echo $row->IDValida;?>','<?php echo $ruta.$row->fotoUser;?>','<?php echo $row->nombre;?>','<?php echo $row->apellidop;?>','<?php echo $row->emailUser;?>','<?php echo $row->ciudad?>','<?php echo $row->telefono_celular?>')"><i class="fa fa-edit fa-2x"></i></a></td>
        <td><img src="<?php echo $ruta.$row->fotoUser;?>" width="60%" class="img-fluid rounded-circle b-shadow-a"></td>
        <td><?php echo $row->IDValida;?></td>
        <td><?php echo $row->nombre.' '.$row->apellidop;?></td>
        <td><?php echo $row->ciudad;?></td>
        <td><?php echo $row->emailUser;?></td>
        <td><?php echo $row->telefono_celular;?></td>
       <td style="text-align: center">
          <a href="#" onclick="activar('<?php echo $row->id;?>')"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-qrcode"></i>&nbsp;Generar QR</button></a>
        </td>
      </tr>
     <?php } ?>
    </tbody>
  </table>  
</form>
</div>

<!-- Modal Editar acerca de mi-->
<div id="editar" class="modal" role="dialog">
  <form  enctype="multipart/form-data" name="frmeditar" id="frmeditar" method="post" action="<?php echo base_url()?>persona/modificar_info_tarjetas_digitales">
 <input type="hidden" name="idCanal" id="idCanal">
 <input type="hidden" name="idPersona" id="idPersona">
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-edit"></i>&nbsp;Editar Perfil Obligatorios para la Activación</h5>
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
          <tr><td colspan="2"><input type="file" id="imagen1" name="imagen1" /></td></tr>
          <tr>
            <td>IDValida:</td>
            <td><input type="text" class="form-control" name="IDValida" id="IDValida"></td>
          </tr>
          <tr>
            <td>Nombre:</td>
            <td><input type="text" class="form-control" name="nombre_edit" id="nombre_edit"></td>
          </tr>
          <tr>
            <td>Apellido Paterno:</td>
            <td><input type="text" class="form-control" name="apellido_edit" id="apellido_edit"></td>
          </tr>
          <tr>
            <td>Ciudad:</td>
            <td>
              <input type="text" name="ciudad" id="ciudad" class="form-control" onclick="activarCiudad()">
              <select name="ciudad_edit" id="ciudad_edit" onchange="getCiudad(this)" class="form-control" style="display: none;">
                <option value=""></option>
                <option value="MERIDA">MERIDA</option>
                <option value="CANCUN">CANCUN</option>
              </select>
            </td>
            </tr>
            <tr>
              <td></td>
              <td><div id="div_seleccion" style="display: none;"></div></td>
            </tr>
          </dir>
          </tr>
          <!--
          <tr>
            <td>Canal</td>

            <td>
              <input type="text" class="form-control" name="canal_edit" id="canal_edit" onclick="activarCanalEdit()">
               <select id="canal" name="canal" class="form-control" style="display: none;" onchange="setCanal(this)">
                 <?php
                  $rs=$this->personamodelo->obtenerCatalogCanales();
                  foreach ($rs as $row) {?>
                   <option value="<?php echo $row->IdCanal?>"><?php echo $row->nombreTitulo?></option>
                  <?php }?>
                </select>
              </div>
            </td>
          </tr>
        -->
          <tr>
            <td>Telefono Celular:</td>
            <td><input type="text" class="form-control" name="celular" id="celular"></td>
          </tr>
          <tr><td colspan="2"><br></td></tr>
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

function activarCanalEdit(){
  //document.getElementById('canal_edit').style.display='none';
  //document.getElementById('canal').style.display='block';
}

function setCanal(canal){
  // document.getElementById('idCanal').value=canal.value;
}


function editar(idPersona,IDValida,foto,nombre,apellidop,email,ciudad,telefono_celular){
  document.getElementById('idPersona').value=idPersona;
  document.getElementById('list1').innerHTML="<img src="+foto+" width='100%'>";
  document.getElementById('IDValida').value=IDValida;
 //document.getElementById('canal_edit').value=nombreTitulo;
  //document.getElementById('idCanal').value=IdCanal;
  document.getElementById('nombre').innerHTML=nombre+' '+apellidop;
  document.getElementById('email').innerHTML=email;
  document.getElementById('ciudad').value=ciudad;
  document.getElementById('celular').value=telefono_celular;
  document.getElementById('nombre_edit').value=nombre;
  document.getElementById('apellido_edit').value=apellidop;
}


function guardar(){
  var idPersona=document.getElementById('idPersona').value;
  var IDValida=document.getElementById('IDValida').value;
  //var canal=document.getElementById('idCanal').value;
  var ciudad=document.getElementById('ciudad').value;
  var celular=document.getElementById('celular').value;
  var nombre=document.getElementById('nombre_edit').value;
  var apellidop=document.getElementById('apellido_edit').value;
  if((IDValida!='')&&(ciudad!='')&&(celular!='')&&(nombre!='')&&(apellidop!='')){
      document.getElementById('frmeditar').submit();
  }else{
    document.getElementById('pantalla').innerHTML="<div class='alert alert-danger'>Todos los datos solicitados son obligatorios, <b>para Generar QR</b>, Favor completar en edicion&nbsp;<i class='fa fa-edit' style='font-weight:bold;font-size:16px;'></i></div>";
  }
}

function activar(id){
    divResultado = document.getElementById('pantalla');  
    ajax=objetoAjax();  
    var base=document.getElementById('base').value;
    var URL=base+"persona/verificarActivo?id="+id;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText
        }
     }
     ajax.send(null)  
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


function activarCiudad(){
  document.getElementById('ciudad_edit').style.display='block';
  document.getElementById('ciudad').style.display="none";
}

function getCiudad(obj){
  var ciudad=obj.value;
  if(ciudad=="MERIDA"){
    document.getElementById('div_seleccion').style.display="block";
    document.getElementById('div_seleccion').innerHTML='<table width="100%;"><tr><td><input type="radio" name="sucursal" value="MERIDA" onchange="seleccionSucursal(this)">&nbsp;Corporativo, (Col. Buena Vista)</option></td></tr><tr><td><input type="radio" name="sucursal" value="MERIDA." onchange="seleccionSucursal(this)">&nbsp;Agencia, (Col. Mexico Norte)</option></td></tr><tr><td><br></td></tr></table>';
  }
  if(ciudad=="MERIDA."){
    document.getElementById('div_seleccion').style.display="block";
    document.getElementById('div_seleccion').innerHTML='<table width="100%;"><tr><td><input type="radio" name="sucursal" value="MERIDA" onchange="seleccionSucursal(this)">&nbsp;Corporativo, (Col. Buena Vista)</option></td></tr><tr><td><input type="radio" name="sucursal" value="MERIDA." onchange="seleccionSucursal(this)">&nbsp;Agencia, (Col. Mexico Norte)</option></td></tr><tr><td><br></td></tr></table>';
  }
  if(ciudad=="CANCUN"){
    document.getElementById('ciudad').value="CANCUN";
    document.getElementById('div_seleccion').style.display="none";
  }
}

function seleccionSucursal(op){
  document.getElementById('ciudad').value=op.value;
  document.getElementById('ciudad').style.display="block";
  document.getElementById('ciudad_edit').style.display='none';
}

/* Ajax*/
function objetoAjax(){
var oHttp=false;
        var asParsers=["Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0",
        "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
        for (var iCont=0; ((!oHttp) && (iCont<asParsers.length)); iCont++){
            try{
                oHttp=new ActiveXObject(asParsers[iCont]);
            }
            catch(e){
                oHttp=false;
            }
        }
        if ((!oHttp) && (typeof XMLHttpRequest!='undefined')){
        oHttp=new XMLHttpRequest();
    }
return oHttp;
}



</script>


