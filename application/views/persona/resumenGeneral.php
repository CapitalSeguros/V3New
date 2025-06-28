<?php 
    //cabecera
    //$this->load->view('headers/header');
    //lista de opciones
    $this->load->view('capacita/menu_capacita');
?>
<style>
    th{text-align:center;}
    .hrsMes{text-align:center;}
    .cert{text-align:center;}
    #contBarra{display: inline-block;text-align:center; height:50%;margin-top:0px;margin-top:5px; vertical-align: top;margin-right: 15px}
    #contPastel{display: inline-block;text-align:center; height:50%;margin-top:0px;margin-top:5px; vertical-align: top;margin-right: 15px}
    #contGrafEsado{display: inline-block;text-align:center; height:50%;margin-top:0px;margin-top:5px; vertical-align: top;margin-right: 15px}
    .barraEstado{display: inline-block; margin-right:5px}
    #contenedorGrafos{margin-top:5px; vertical-align: top; align-items: center;justify-content: center;}
</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<div id="contenedor" style="width:82%;" class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-12 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Resumen general de capacitación</h3>
        </div>
        <!--<div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="<?=base_url()?>">Inicio</a></li>
                <li><a href="./persona/agente">Capital Humano</a></li>
                <li class="active"><a>Reporte Capacitación</a></li>
            </ol>
        </div>-->
    </div>
    <hr />
    <div>
        <?php
            $conjunto=array();
            $prueba=array();
            foreach($agentesActivos as $sucursal=>$agente){
                foreach ($agente as $nombres => $mensualidad) {
                    foreach ($mensualidad as $mes => $valor) {
                        for($i=0;$i<count($mesActivo);$i++){
                            if(!array_key_exists($mesActivo[$i],$mensualidad) && isset($mesActivo[$i])){
                                $conjunto[$sucursal][$nombres][$mesActivo[$i]]=0;
                            }
                            else{
                                $conjunto[$sucursal][$nombres][$mes]=$valor;
                                
                            }
                        } 
                    } 
                } 
            }
            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($agentesActivos, TRUE));fclose($fp);
        ?>
        <table class="table">
            <thead>
                    <tr id="mesEnCurso">
                        <th>AGENTES CUN</th>
                        <?php for($i=0;$i<count($mesActivo);$i++){
                            if($mesActivo[$i]!=null){ ?>
                            <th><?=$meses[$mesActivo[$i]] ?></th>
                        <?php }}?>
                    </tr>
            </thead>
            <tbody id="cuerpo1">
                <?php foreach($conjunto as $sucursal=>$agente){ 
                    if($sucursal=="cancun"){
                        foreach($agente as $nombres=>$mensualidad){
                            ksort($mensualidad);?>
                        <tr>
                            <td><?=$nombres?></td>
                            <?php foreach($mensualidad as $mes=>$valor){
                                if($mes!=""){?>
                                <td class="hrsMes"><?=$valor." hrs"?></td>
                            <?php }}?>
                        </tr>
                <?php }}}?> 
            </tbody>
            <thead>
                <tr>
                    <th>AGENTES MID</th>
                </tr>
            </thead>
            <tbody id="cuerpo2">
            <?php foreach($conjunto as $sucursal=>$agente){ 
                    if($sucursal=="merida"){
                        foreach($agente as $nombres=>$mensualidad){
                            ksort($mensualidad);?>
                        <tr>
                            <td><?=$nombres?></td>
                            <?php foreach($mensualidad as $mes=>$valor){
                                if($mes!=""){?>
                                <td class="hrsMes"><?=$valor." hrs"?></td>
                            <?php }}?>
                        </tr>
                <?php }}} ?>
            </tbody>
            <thead>
                <tr>
                    <th>AGENTES CAP CAPITAL</th>
                </tr>
            </thead>
            <tbody id="cuerpo3">
            <?php foreach($conjunto as $sucursal=>$agente){ 
                    if($sucursal=="cap"){
                        foreach($agente as $nombres=>$mensualidad){
                            ksort($mensualidad);?>
                        <tr>
                            <td><?=$nombres?></td>
                            <?php foreach($mensualidad as $mes=>$valor){
                                if($mes!=""){?>
                                <td class="hrsMes"><?=$valor." hrs"?></td>
                            <?php }}?>
                        </tr>
                <?php }}}?>
            </tbody>
            <thead>
                <tr>
                    <th>COLABORADORES</th>
                </tr>
            </thead>
            <tbody id="cuerpo4">
            <?php foreach($conjunto as $sucursal=>$agente){ 
                    if($sucursal=="colaborador"){
                        foreach($agente as $nombres=>$mensualidad){
                            ksort($mensualidad);?>
                        <tr>
                            <td><?=$nombres?></td>
                            <?php foreach($mensualidad as $mes=>$valor){
                                if($mes!=""){?>
                                <td class="hrsMes"><?=$valor." hrs"?></td>
                            <?php }}?>
                        </tr>
                <?php }}} ?>
            </tbody> 
        </table>
    </div>
    <hr>
        <div id="contenedorGrafos">
        <h4 style="text-align: center">Para ver las gráficas seleccione una opción</h4>
        <select id="selectCapacitacion" class="form-control" required>
            <option value="0">Seleccione una capacitación</option>
            <?php foreach($tipoCapacitacion as $valor){?>
                <option value="<?=$valor->id_capacitacion?>"><?=$valor->tipoCapacitacion?></option>
            <?php }?>
        </select>
        <br>
        <select id="selectSubCapacitacion" style="display:none" class="form-control" required></select>
        <br>
        <br>
        <select id="selectMesEnRegistro" style="display:none" class="form-control" name="selectMesName" required></select>
        <br>
        <br>
        <div id="contenedorGrafos2" style="display:none">
            
        <table class="table">
            <thead>
                <tr>
                    <th>Conteo de hrs por ramo</th>
                </tr>
            </thead>
            <tbody>
                <tr id="contGrafPastel"></tr>
            </tbody>
            <thead>
                <th>Cantidad de agentes por ramo</th>
            </thead>
            <tbody>
                <tr id="cuerpoCantAgente"></tr>
            </tbody>
            <thead>
                <tr>
                    <th>Sumatoria de hrs por mes</th>
                </tr>
            </thead>
            <tbody>
                <tr id="contGrafBarra"></tr>
            </tbody>
        </table>
    </div>
    </div>
</div>
<script>

    var selectPadre=document.getElementById("selectCapacitacion");
    var contenedorSelect=document.getElementById("selectSubCapacitacion");
    var selectMes=document.getElementById("selectMesEnRegistro");

    var direccion_proyecto = window.location.href.replace("persona/resumenGeneral", "");
    console.log(direccion_proyecto);

    function devuelveSubCapaAsincrono(){
        
        var direccion="<?=base_url()."persona/devuelveCerti"?>";

        var elementoName=document.createAttribute("name");
        elementoName.value="selectCapacitacionName";
        selectPadre.setAttributeNode(elementoName);

        var xmlhttp=new XMLHttpRequest();

        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                
                contenedorSelect.style.display="inline-block";
                contenedorSelect.innerHTML="";
                contenedorSelect.innerHTML="<option value='0'>Seleccione una categoria</option>";

                var respuesta=JSON.parse(this.responseText);

                //console.log(respuesta);
                for(var indice in respuesta){
                    contenedorSelect.innerHTML+=`
                        <option value="`+respuesta[indice].id_certificado+`">`+respuesta[indice].nombreCertificado+`</option>
                    `;
                }
            }
        }
        xmlhttp.open("GET",direccion+"?"+elementoName.value+"="+selectPadre.value, true);
        xmlhttp.send();
    }

    function devuelveMesActivoAsincrono(){
        var direccion="<?=base_url()."persona/obtenerMesXSubCapa"?>";

        var elementoName=document.createAttribute("name");
        elementoName.value="selectSubCapacitacionName";
        contenedorSelect.setAttributeNode(elementoName);

        var meses={};
        meses[1]="ENERO";
        meses[2]="FEBRERO";
        meses[3]="MARZO";
        meses[4]="ABRIL";
        meses[5]="MAYO";
        meses[6]="JUNIO";
        meses[7]="JULIO";
        meses[8]="AGOSTO";
        meses[9]="SEPTIEMBRE";
        meses[10]="OCTUBRE";
        meses[11]="NOVIEMBRE";
        meses[12]="DICIEMBRE";

        var xmlhttp=new XMLHttpRequest();

        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                
                selectMes.style.display="inline-block";
                selectMes.innerHTML="";
                selectMes.innerHTML="<option value='0'>Seleccione una mes en registro</option>";

                var respuestaInfo=JSON.parse(this.responseText);
                //console.log(JSON.parse(this.response));
                var refMensual="";
                var refB=5;
                for(var mes in respuestaInfo){
                    //console.log(respuestaInfo);
                    selectMes.innerHTML+=`
                        <option value='`+mes+`'>`+meses[mes]+`</option>
                    `;
                    var datosBarras=Object.values(respuestaInfo);
                    var contBarra=document.getElementById("contGrafBarra");
                    
                    refB+=3;
                    refMensual+=`
                        <img src="`+direccion_proyecto+`assets/plugins/GraPHPico_0-0-3/graphref.php?ref=`+(refB-3)+`&typ=2&dim=5&bkg=FFFFFF"><label>`+meses[mes]+`: `+respuestaInfo[mes]+` hrs</label><br>
                    `;

                    contBarra.innerHTML="";
                    contBarra.innerHTML+=`
                        <td style="text-align:center">
                            <img src="`+direccion_proyecto+`assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=`+datosBarras+`&bkg=FFFFFF"><br>
                            <div id="columnaRef">`+refMensual+`</div>
                        </td>
                    `;
                }
            }
        }

        xmlhttp.open("GET",direccion+"?"+elementoName.value+"="+contenedorSelect.value, true);
        xmlhttp.send();
    }

    function devuelveInfoAsincrono(){

        var xmlhttp=new XMLHttpRequest();
        var direccion="<?=base_url()."persona/devuelveDatosParaGrafos"?>";

        var ramos={};
        var hrsRamos={};
        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                
                contenedorGraf=document.getElementById("contenedorGrafos2");
                contenedorGraf.style.display="inline-block";
                //console.log(this.responseText);
                var resultado=JSON.parse(this.responseText);

                var userProf=0;
                var userAutos=0;
                var userGmm=0;
                var userVida=0;
                var userDanios=0;
                var userFianzas=0;

                var hrsProf=0;
                var hrsAutos=0;
                var hrsGmm=0;
                var hrsVida=0;
                var hrsDanios=0;
                var hrsFianzas=0;

                var ramoXSucursal={};
                var acumuladorSuc=[]
                var acumulador=[];

                for(var valor in resultado){

                    if(resultado[valor].certificacion>0){
                        userProf++;                         
                    }
                    if(resultado[valor].certificacionAutos>0){
                        userAutos++;                         
                    }
                    if(resultado[valor].certificacionGmm>0){
                        userGmm++;                        
                    }
                    if(resultado[valor].certificacionVida>0){
                        userVida++;                         
                    }
                    if(resultado[valor].certificacionDanos>0){
                        userDanios++; 
                    }
                    if(resultado[valor].certificacionFianzas>0){
                        userFianzas++; 
                    }
                    ramos["profesional"]=userProf;
                    ramos["autos"]=userAutos;
                    ramos["gmm"]=userGmm;
                    ramos["vida"]=userVida;
                    ramos["danios"]=userDanios;
                    ramos["fianzas"]=userFianzas;

                    hrsProf+=parseInt(resultado[valor].certificacion);
                    hrsAutos+=parseInt(resultado[valor].certificacionAutos);
                    hrsGmm+=parseInt(resultado[valor].certificacionGmm);
                    hrsVida+=parseInt(resultado[valor].certificacionVida);
                    hrsDanios+=parseInt(resultado[valor].certificacionDanos);
                    hrsFianzas+=parseInt(resultado[valor].certificacionFianzas);

                    hrsRamos["hrs_profesional"]=hrsProf;
                    hrsRamos["hrs_autos"]=hrsAutos;
                    hrsRamos["hrs_gmm"]=hrsGmm;
                    hrsRamos["hrs_vida"]=hrsVida;
                    hrsRamos["hrs_danios"]=hrsDanios;
                    hrsRamos["hrs_fianzas"]=hrsFianzas
                }
                acumulador.push(hrsRamos);
                //console.log(acumuladorSuc);

                var contGrafAgentes=document.getElementById("cuerpoCantAgente");
                contGrafAgentes.innerHTML="";

                for(var valor in ramos){
                    var nombreRamo=valor.replace("danios", "daños")
                    contGrafAgentes.innerHTML+=`
                        <td class="barraEstado">
                            <p> `+nombreRamo.toUpperCase()+` </p>
                            <img src="`+direccion_proyecto+`assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=`+ramos[valor]+`">
                            <p>Total: `+ramos[valor]+` agentes</p>
                        </td>
                    `;
                }
                
                var contenedorPastel=document.getElementById("contGrafPastel");
                contenedorPastel.innerHTML="";

                var grafPastel=[];
                
                var nuevoArray=[];
                var refImg="";
                var ref=5
                var total=0;
                for(var indice in acumulador){
                    
                    if(acumulador[indice].hrs_profesional<1){
                        delete acumulador[indice].hrs_profesional;
                    }
                    if(acumulador[indice].hrs_autos<1){
                        delete acumulador[indice].hrs_autos;
                    }
                    if(acumulador[indice].hrs_gmm<1){
                        delete acumulador[indice].hrs_gmm;
                    }
                    if(acumulador[indice].hrs_vida<1){
                        delete acumulador[indice].hrs_vida;
                    }
                    if(acumulador[indice].hrs_danios<1){
                        delete acumulador[indice].hrs_danios;
                    }
                    if(acumulador[indice].hrs_fianzas<1){
                        delete acumulador[indice].hrs_fianzas;
                    }

                    grafPastel=Object.values(acumulador[indice]);

                    var totalValores=grafPastel.reduce(function(acumulador,valorActual){
                        return acumulador+valorActual;
                    });

                    refImg+=`<p>Total de horas acumuladas: `+totalValores+` hrs.</p>`;

                    for(var ramo in acumulador[indice]){
                        ref+=3;
                        var nombreRamo=ramo.split("_").pop().replace("danios","daños");
                        refImg+=`
                            <img src="`+direccion_proyecto+`assets/plugins/GraPHPico_0-0-3/graphref.php?ref=`+(ref-3)+`&typ=1&dim=5&bkg=FFFFFF"><label>`+nombreRamo.toUpperCase()+`: `+acumulador[indice][ramo]+` hrs ->`+((acumulador[indice][ramo]*100)/totalValores).toFixed(2)+`%</label><br>
                        `;
                    }
                }
                
                contenedorPastel.innerHTML+=`
                    <td style="text-align:center">
                        <p>Sumatoria de horas por capacitación.</p>
                        <img src="`+direccion_proyecto+`assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=`+grafPastel+`&bkg=FFFFFF"><br><br>
                        <div id="columnaRef">`+refImg+`</div>
                    </td>
                    `;
            }
        }
        xmlhttp.open("GET",direccion+"?selectCapacitacionName="+selectPadre.value+"&selectSubCapacitacionName="+contenedorSelect.value+"&selectMesName="+selectMes.value+"");
        xmlhttp.send();
    }


    selectPadre.addEventListener("change", devuelveSubCapaAsincrono);
    contenedorSelect.addEventListener("change",devuelveMesActivoAsincrono);
    selectMes.addEventListener("change",devuelveInfoAsincrono);

</script>