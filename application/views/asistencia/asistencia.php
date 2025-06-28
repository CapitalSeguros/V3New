<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<?
  if (isset($mensaje)){
  echo "<script>";
  	echo('alert("'.$mensaje.'")');
  echo "</script>";
  }
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<div class="container" style="margin-top: 1%;margin-left: -1%;">
<form action="<?=base_url();?>asistencias/cargar_archivo" method="post" enctype="multipart/form-data">
<div class="row">
  <div class="col-md-4 col-lg-4">
    <select name="mes" id="mes" class="form-control">
      <option>Enero</option>
      <option>Febrero</option>
      <option>Marzo</option>
      <option>Abril</option>
      <option>Mayo</option>
      <option>Junio</option>
      <option>Julio</option>
      <option>Agosto</option>
      <option>Septiembre</option>
      <option>Octubre</option>
      <option>Noviembre</option>
      <option>Diciembre</option>
  </select>
  </div>
  <div class="col-md-4 col-lg-4">
    <input type="text" name="anio"  placeholder="ingresa el año" class="form-control">
  </div>
  <div class="col-md-4 col-lg-4">
   <input type="password" name="password"  placeholder="Ingresa tu contraseña" class="form-control">
  </div>
</div>
<div class="row">
  <div class="col-md-4 col-lg-4">
    <input type="file" name="mi_archivo" class="form-control">    
  </div>
  <div class="col-md-4 col-lg-4">
    <input type="submit" value="Enviar" class="btn btn-primary">
  </div>
</div>

</form>
<div>


<table style="height: 100px">
<tr><td valign="top">
<table border="2" class="formatoTabla" id="tablaCabecera" align="top">

<tr class="tdCabecera">
	<td>Excel</td>
</tr>
<?php
$directorio = 'guarda';
$ficheros1  = scandir($directorio);
$ficheros2  = scandir($directorio, 1);
for($i=2;$i<count($ficheros1);$i++)
{
  if($ficheros1[$i]!=".."){
echo('<tr class="tdHijo"><td onclick="traeExcel(this.innerHTML,this)">');
echo($ficheros1[$i]);
echo('</tr></td>');
  }
}
?>
</table>
</td>
<td>

<div id="miCapa" style="height: 300px; width: 90%; overflow: scroll;" ></div>

</td>
</tr>
</table>

<div id="capaFiltradoName" style="display:none"></div>
</div>

<script type="text/javascript">
//------------------------------------------------------------------------------
function filtradoName(event){
  x=event.clientX;
  y=-event.clientY+20;
  x=x-60;        
  document.getElementById("capaFiltradoName").style.display="table";
  document.getElementById("capaFiltradoName").style.left=x+"px";
  document.getElementById("capaFiltradoName").style.top=y+"px";
  document.getElementById("capaFiltradoName").style.position="relative";  
  document.getElementById("capaFiltradoName").style.height="100px";     
  document.getElementById("capaFiltradoName").style.overflow="scroll";  
}
//------------------------------------------------------------------------------
function traeExcel(valor,objeto){
padre=objeto.parentNode.parentNode;
var cont=padre.rows.length;
for(var i=0;i<cont;i++){if(i>0){padre.rows[i].cells[0].className="rowInactivo";}}
objeto.className="rowActivo";
document.getElementById("miCapa").innerHTML='<marquee direction="down" width="250" height="200" behavior="alternate" style="border:solid">cargando informacion</marquee>';
var parametros = {"folio" :valor };
var direccion= "<?php echo base_url()?>asistencias/devuelveExcel";
$.ajax({method: "POST",data:parametros,url : direccion,dataType: "html",           
success : function(datat){
var j=JSON.parse(datat);                          
//  console.log(j);
  document.getElementById("miCapa").innerHTML=j['tabla'];
  document.getElementById("capaFiltradoName").innerHTML=j['nombres'];
                           }                                           
                    });
  }
  //------------------------------------------------------------------------------
  function cerrarFiltrado(objeto){ objeto.parentNode.style.display="none"; }
  //------------------------------------------------------------------------------
  function filtraPorNombre(text){
    var miTabla=document.getElementById("tablaExcel");
    var contador=miTabla.rows.length;
    if(text=="  TODOS"){
      for(var i=1;i<contador;i++){miTabla.rows[i].style.display="table-row";}
    }
    else{
    for(var i=1;i<contador;i++){
      if(miTabla.rows[i].cells[2].innerHTML!=text){
        miTabla.rows[i].style.display="none";
      }
      else{miTabla.rows[i].style.display="table-row";
       }
    }
    }
    document.getElementById("capaFiltradoName").style.display="none";    
  }
</script>
<?php $this->load->view('footers/footer'); ?>
<style>
#capaFiltradoName{background:#c9c7cc;border:double;cursor:pointer; height: 300px; overflow: scroll;}
 .filtroNombre:hover{background-color: #9d9c9e;}
.formatoTabla{height: 100px;margin: 10px;background:#eaeef3;border-color:black; width: 200px}
.formatoTabla  tr{border-color:black;border-style: none solid solid none;border-width: 0pt 1px 1px 0pt; }
.formatoTabla tr td{border-color:black; }
.rowActivo{background:green}
.rowInactivo{background:#eaeef3}
.rowInactivo:hover{background:#879ab7}
.tdCabecera{background-color: #80aee6; color: black;}
.tdHijo{ color: black;}
.tdHijo:hover{background:#99b7dc}
</style>