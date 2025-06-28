<?php $this->load->view('headers/header'); ?>
<!-- Navbar -->
<?php $this->load->view('headers/menu');?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  
<form action="<?=base_url();?>honorarios/obtenerAgentesParaRestringir" method="POST" class="form">
 <p>Fecha inicial:<input type="text" class="datepicker" name="fIni" id="fIni"  >
    Fecha final:<input type="text" class="datepicker" name="fFin" id="fFin">      
    <input type="submit" name="Consulta" id="Consulta" value="Consulta">
</form>
<? $tamTabla=""; for($i=0;$i<=25;$i++){$tamTabla=$tamTabla.$i; }?>
<fieldset><legend>Agentes activos</legend>
 <div style="width:100%;height: 30px;border:double;overflow:hidden;" id="scrollCabecera">
   <table style="width: 100%" id="tab">
     <thead style="width: 100%; background-color:#472380; color:white;" >
      <tr> <th >Nombre</th><th >Ranking</th><th >Honorarios</th><th >Bannear</th></tr>     
        </thead>  
        <tbody style="visibility: hidden">  
         <tr  >
          <td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td>
          <td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td>            
         </tr>
   </tbody></table></div>
 <div   onscroll="moverScroll('scrollTabla','scrollCabecera')" id="scrollTabla" style="width:100%;overflow-x:scroll;overflow-y: scroll;height: 200px;border:double;" >  
   <table id="tabla" class="classTabla" >
    <thead id="cabeceraTabla" style="width: 100%;visibility: hidden;">
     <tr><th >Nombre</th><th >Ranking</th><th >Honorarios</th><th >Bannear</th></tr>
     </thead><tbody id="tbodyReporte" >
     <tr  style="visibility: hidden;text-align: right;">
      <td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td>
      <td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td>            
     </tr>
        <? 
        if (isset($TableInfo)){
          $cont=0;
        foreach($TableInfo as $table){$cont++;?>        
         <tr id="tr<?echo($cont)?>" class="classTR" >
          <td class="tdPartidas" id="tdDato"><a> <?echo $table['name_complete']?></a></td>       
          <td class="tdPartidas" id="tdDato"><a> <?echo $table['Ranking']?></a></td>                  
          <td class="tdPartidas" id="tdDato"><a> <?echo $table['monto']?></a></td>
          <td class="tdPartidas" id="tdDato"><input type="button" name="" value="Bannear" onclick="baneaHabilita( <?echo ($cont.','. $table['idVend']).',0'; ?>)"></td>
         </tr>
        <?;
        }  
        }      
        ?>
       </tbody></table> </div></fieldset>
<? $tamTabla=""; for($i=0;$i<=40;$i++){$tamTabla=$tamTabla.$i; }?>
<fieldset><legend>Agentes baneados</legend>
 <div style="width:100%;height: 30px;border:double;overflow:hidden;" id="scrollCabecera2">
   <table style="width: 100%" id="tab2">
     <thead style="width: 100%; background-color:#472380; color:white;  " >
        <tr>              
  <th >Nombre</th><th >Ranking</th><th >Habilitar</th>
         </tr>     
        </thead>  
        <tbody style="visibility: hidden">  
         <tr  >
          <td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td>           
         </tr>
        </tbody>
   </table> 
</div>
 <div   onscroll="moverScroll('scrollTabla2','scrollCabecera2')" id="scrollTabla2" style="width:100%;overflow-x:scroll;overflow-y: scroll;height: 200px;border:double;">  
 <table id="tablaBaneado" class="classTabla" >
   <thead id="cabeceraTabla" style="width: 100%;visibility: hidden;">
    <tr>   
<th >Nombre</th><th >Ranking</th><th >Habilitar</th>
    </tr>     
   </thead>
<tbody id="tbodyReporte" >
 <tr  style="visibility: hidden;text-align: right;">
  <td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td><td ><?echo ($tamTabla)?></td>           
  </tr>
  <? 
    if (isset($baneados)){
    $cont=0;
    foreach($baneados as $table){$cont++;?>        
    <tr id="Btr<?echo($cont)?>" class="classTR" >
    <td class="tdPartidas" id="tdDato"><a> <?echo $table->name_complete?></a></td>       
    <td class="tdPartidas" id="tdDato"><a> <?echo $table->Ranking?></a></td>                  
    <td class="tdPartidas" id="tdDato"><input type="button" name="" value="Habilitar" onclick="baneaHabilita( <?echo ($cont.','. $table->IDVend).',1'; ?>)"></td>
    </tr>
   <?;
   }  
  }      
 ?>
</tbody></table> </div></fieldset>

<?php $this->load->view('footers/footer'); ?>
<script type="text/javascript">
var cantidadFilBorradas=0,ultimaFilaBorrada;
/*SI tipoOper=0 BANEA, SI tipoOper=1 HABILITA*/    
function baneaHabilita(idFila,idVend,tipoOper){
 var tablaBaneada=document.getElementById('tablaBaneado');
 var tabla=document.getElementById('tabla');
 var numRowBaneado= tablaBaneada.rows.length;
 var parametros = {"idVend" :idVend ,"tipoOper" : tipoOper};
 $.ajax({method: "POST",data: {parametros},url : "<?php echo base_url()?>honorarios/bannea",dataType: "html",
    beforeSend: function () { },
    success : function(data)
    {ultimaFilaBorrada=idFila;cantidadFilBorradas=cantidadFilBorradas+1;}});
 if(tipoOper==0){
    document.getElementById("tr"+idFila).className="classTrOculto";
    var idRow=parseInt(tablaBaneada.rows.length)+1;var row=tablaBaneada.insertRow(2);
    row.id="Btr"+idRow;
    var cell1=row.insertCell(0),cell2=row.insertCell(1),cell3=row.insertCell(2);  
    cell1.innerHTML = document.getElementById("tr"+idFila).cells[0].innerHTML;                    
    cell2.innerHTML = document.getElementById("tr"+idFila).cells[1].innerHTML;
    cell3.innerHTML = '<input type="button"  value="Habilitar" onclick="baneaHabilita('+idRow+','+idVend+',1)" >';       
  }
  else{document.getElementById("Btr"+idFila).className="classTrOculto";
    var idRow=parseInt(tabla.rows.length)+1;
    var row=tabla.insertRow(2);
    row.id="tr"+idRow;
    var cell1=row.insertCell(0),cell2=row.insertCell(1),cell3=row.insertCell(2);cell4=row.insertCell(3);
    cell1.innerHTML = document.getElementById("Btr"+idFila).cells[0].innerHTML;                       
    cell2.innerHTML = document.getElementById("Btr"+idFila).cells[1].innerHTML;
    cell3.innerHTML ="0";
    cell4.innerHTML ='<input type="button" name="" value="Bannear" onclick="baneaHabilita('+idRow+','+idVend+',0)" >';    
  }
}
function moverScroll(scrollTab,scrollCab){
  var elmnt = document.getElementById(scrollTab);var x = elmnt.scrollLeft;
document.getElementById(scrollCab).scrollLeft=x;
}
    var bandera="0";	
  <? if (isset($fechaInicial) ){ ?>
    bandera="1";
    var fechaInicial=<? echo ('"'.$fechaInicial.'";'); ?>
    var fechaFinal=<? echo ('"'.$fechaFinal.'";'); ?>      
  <?}?>
</script>
<script src="<?=base_url();?>assets/js/reportesRestringir.js"></script>
<style type="text/css">
.classTabla{width: 1000px;background: white;}
.classTabla>tbody>tr:nth-child(odd){background: white;background-color:#5999d0 /*#b28bf1*/;}
.classTabla>tbody>tr:nth-child(even){background: white;background-color:#5999d0 /*#5b4284*/;}
.classTabla>tbody>tr:hover{background: white;background-color: green/*#361866*/;}
.classTabla>tbody>tr>td<a{background-color:green;}
.classTrVisible{display: block;}
.classTrOculto{display: none;}
</style>