<?php 
    //cabecera
    //$this->load->view('headers/header');
    //lista de opciones
    //$this->load->view('headers/menu');
    $this->load->view('capacita/menu_capacita');
?>
<style>
    th{text-align:center;}
    .cert{text-align:center;}
    .graficas{border: 1px red solid; width:100%; height:100%; display:block; vertical-align:top;}
    .colGraf{margin-right:10px;}
    img{align-items: center;}
</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<div id="contenedor" style="width:80%;" class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-12 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Resumen de agentes en capacitación</h3></div>
            <!--<div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li><a href="<?=base_url()?>">Inicio</a></li>
                    <li><a href="./persona/agente">Capital Humano</a></li>
                    <li class="active"><a>Reporte Capacitaci&oacute;n</a></li>
                </ol>
            </div>-->
    </div>
    <hr /> 
    <!--[Contenido de la página]-->
    <div id="divContAgente" style="width:100%;">
            <select id="selectCapa" class="form-control">
                <option value="0">Seleccione un tipo de capacitación</option>
            
            <?php
                foreach($controlCapa as $objeto){ ?>
                <option value=<?=$objeto->id_capacitacion?>><?=$objeto->tipoCapacitacion?></option>
            <?php }?>

            </select>
            <br>
            <select id="selectCerti" class="form-control form-control-sm"></select>
            <br>
    </div>

    <div id="contTablas" style="width:100%;"></div>

    <div id="contGraficas" style="width:100%;">
        <table class="table" id="tablaGraficas">
            <tbody >
            <tr id="contenidoGraficas"></tr>
            </tbody>
        </table>
    
    </div>
</div>

<script>
var selectCapa=document.getElementById("selectCapa");
    
function ajaxVanillaJS(){

        var xmltHttp= new XMLHttpRequest();

        var direccion="<?=base_url()."persona/consultaCertificadoXCapacitacion"?>";
        var selectName=document.createAttribute("name");
        selectName.value="selectCapacitacionName";
        selectCapa.setAttributeNode(selectName);
        var selectRepuesta=document.getElementById("selectCerti");
        selectRepuesta.innerHTML="";

        xmltHttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            //console.log(this.responseText);
            var tipoCerti=JSON.parse(this.responseText);
            
            selectRepuesta.innerHTML+="<option value='0'>Seleccione un ramo</option>";
            for(var indice in tipoCerti){
            selectRepuesta.innerHTML+="<option value="+tipoCerti[indice].id_certificado+">"+tipoCerti[indice].nombreCertificado+"</option>";
            }
        }
        }
        xmltHttp.open("GET",direccion+"?"+selectName.value+"="+selectCapa.value, true);
        xmltHttp.send();
}
selectCapa.addEventListener("change", ajaxVanillaJS);


var selectCertificado=document.getElementById("selectCerti");

selectCertificado.addEventListener("change",function(){
    //console.log(selectCertificado.value);

    var xmlhttp=new XMLHttpRequest();

    var direccion="<?=base_url()."persona/resumenCapaAsincrono"?>";
    var direccion_proyecto = window.location.href.replace("persona/resumenCapacitacion","");

    //console.log(direccion_proyecto);

    var selectName=document.createAttribute("name");
    selectName.value="nameSelectCerti";
    selectCertificado.setAttributeNode(selectName);

    var contenedorTabla=document.getElementById("contTablas");
    contenedorTabla.innerHTML="";

    var meses={};
    meses["1"]="ENERO";
    meses["2"]="FEBRERO";
    meses["3"]="MARZO";
    meses["4"]="ABRIL";
    meses["5"]="MAYO";
    meses["6"]="JUNIO";
    meses["7"]="JULIO";
    meses["8"]="AGOSTO";
    meses["9"]="SEPTIEMBRE";
    meses["10"]="OCTUBRE";
    meses["11"]="NOVIEMBRE";
    meses["12"]="DICIEMBRE";

    var fecha= new Date();

    var prueba=new Array();
    
    xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
    
            var objetoRespuesta=JSON.parse(this.responseText);
            var mesActivo=Array.from(new Set(objetoRespuesta.map(function(objeto){
            
                return objeto.mes; //retornamos un array con los meses en registro.
            }))); // quitamos duplicados con el objeto Set y almacenamos el resultado en una instancia del objeto Array.
            //console.log(objetoRespuesta);
            for(var i=0;i<mesActivo.length;i++){

                contenedorTabla.innerHTML+=`
                    <h4>`+meses[mesActivo[i]]+` `+fecha.getFullYear()+`</h4>
                    <table id='tablaMes`+mesActivo[i]+`' class='table'>
                        <thead>
                            <tr>
                                <th>NOMBRES</th>
                                <th>PROFESIONAL</th>
                                <th>AUTOS</th>
                                <th>DAÑOS</th>
                                <th>FIANZAS</th>
                                <th>GMM</th>
                                <th>VIDA</th>
                                <th>TOTAL</th> 
                            </tr>
                        </thead>
                        <tbody id='cuerpoTabla`+mesActivo[i]+`'></tbody>
                    </table>
                    <hr>
                `;
                var sumatoriaProf=0;
                var sumatoriaAutos=0;
                var sumatoriaDanios=0;
                var sumatoriaFianzas=0;
                var sumatoriaGmm=0;
                var sumatoriaVida=0;
                
                for(var indice in objetoRespuesta){

                    var contenedorCuerpo=document.getElementById("cuerpoTabla"+mesActivo[i]+"");
                    if(mesActivo[i]==objetoRespuesta[indice].mes){
                        var mes={};
                        var sumatoria=0;
                        
                        sumatoria=parseInt(objetoRespuesta[indice].certificacion)+parseInt(objetoRespuesta[indice].certificacionAutos)+parseInt(objetoRespuesta[indice].certificacionDanos)+parseInt(objetoRespuesta[indice].certificacionFianzas)+parseInt(objetoRespuesta[indice].certificacionGmm)+parseInt(objetoRespuesta[indice].certificacionVida);
                        contenedorCuerpo.innerHTML+=`
                            <tr>
                                <td>`+objetoRespuesta[indice].nombres+` `+objetoRespuesta[indice].apellidoPaterno+` `+objetoRespuesta[indice].apellidoMaterno+`</td>
                                <td class="cert">`+objetoRespuesta[indice].certificacion+`</td>
                                <td class="cert">`+objetoRespuesta[indice].certificacionAutos+`</td>
                                <td class="cert">`+objetoRespuesta[indice].certificacionDanos+`</td>
                                <td class="cert">`+objetoRespuesta[indice].certificacionFianzas+`</td>
                                <td class="cert">`+objetoRespuesta[indice].certificacionGmm+`</td>
                                <td class="cert">`+objetoRespuesta[indice].certificacionVida+`</td>
                                <td class="cert">`+sumatoria+`</td>
                            </tr>
                        `;
                        
                        sumatoriaProf+=parseInt(objetoRespuesta[indice].certificacion);
                        sumatoriaAutos+=parseInt(objetoRespuesta[indice].certificacionAutos);
                        sumatoriaDanios+=parseInt(objetoRespuesta[indice].certificacionDanos);
                        sumatoriaFianzas+=parseInt(objetoRespuesta[indice].certificacionFianzas);
                        sumatoriaGmm+=parseInt(objetoRespuesta[indice].certificacionGmm);
                        sumatoriaVida+=parseInt(objetoRespuesta[indice].certificacionVida);

                        var ramos={};
                        var persona={};
                        
                        
                        ramos["profesional"]=sumatoriaProf;
                        ramos["autos"]=sumatoriaAutos;
                        ramos["danios"]=sumatoriaDanios;
                        ramos["fianzas"]=sumatoriaFianzas;
                        ramos["Gmm"]=sumatoriaGmm;
                        ramos["vida"]=sumatoriaVida;
                        mes[mesActivo[i]]=ramos;
                        
                    }
                }    
                prueba.push(mes);
           }
       
           var contenedorGrafos=document.getElementById("contenidoGraficas");
           contenedorGrafos.innerHTML="";

           for(var index in prueba){
          
                for(var mes in prueba[index]){
                    if(prueba[index][mes].profesional<1){
                        delete prueba[index][mes].profesional;
                    }
                    if(prueba[index][mes].autos<1){
                        delete prueba[index][mes].autos;
                    }
                    if(prueba[index][mes].danios<1){
                        delete prueba[index][mes].danios;
                    }
                    if(prueba[index][mes].fianzas<1){
                        delete prueba[index][mes].fianzas;
                    }
                    if(prueba[index][mes].Gmm<1){
                        delete prueba[index][mes].Gmm;
                    }
                    if(prueba[index][mes].vida<1){
                        delete prueba[index][mes].vida;
                    }
                    
                    var grafPastel=Object.values(prueba[index][mes]);
                    var totalValores=grafPastel.reduce(function(acumulador,valorActual){
                        return acumulador+valorActual;
                    });
                   
                    contenedorGrafos.innerHTML+=`
                            <td style="display:inline-block">
                                <h5>Grafica del mes `+meses[mes]+`</h5>
                                <!--<img src="http://graphpico.standcomercial.com/graphpico/graphpastel.php?dat=`+grafPastel+`&bkg=FFFFFF" style="text-align:center">-->
                                <img src="`+direccion_proyecto+`assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=`+grafPastel+`&bkg=FFFFFF" style="text-align:center">
                                <div id="columnaRef`+mes+`">
                                    
                                </div>
                            </td>
                    `;

                var columnaParaReferencias=document.getElementById("columnaRef"+mes+"");
                columnaParaReferencias.innerHTML="";
                
                var ref=5;
                
                for(var ramo in prueba[index][mes]){
                    ref+=3;
                   
                    columnaParaReferencias.innerHTML+=`
                    <img src="`+direccion_proyecto+`assets/plugins/GraPHPico_0-0-3/graphref.php?ref=`+(ref-3)+`&typ=1&dim=5&bkg=FFFFFF"><label>`+ramo.toUpperCase()+`: `+((prueba[index][mes][ramo]*100)/totalValores).toFixed(2)+` %</label>
                    <br>
                    `;
                }
               }
           }
        }
    }
    xmlhttp.open("GET",direccion+"?"+selectName.value+"="+selectCertificado.value, true);
    xmlhttp.send();
});

</script>