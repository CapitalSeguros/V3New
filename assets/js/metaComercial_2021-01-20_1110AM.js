//console.log("Hola");

var selectMCA=document.getElementById("listaActividades");
var selectCoordinacion=document.getElementById("coordinacionId");
var contenedorMA=document.getElementById("contenidoMF");
var entradaMonto=document.getElementById("cantidadAnual");
var botonSubmit=document.getElementById("btnSubmit");
var botonSubmitMensual=document.getElementById("submitMontoMensual");
var contenedorAsignados=document.getElementById("contAsignados");
var idMetaC=document.getElementById("idMetaC");
var ultimoId=0;

selectMCA.addEventListener("change",function(){

    if(selectMCA.value=="metaCA"){

        contenedorMA.style.display="inline-block";
        contenedorAsignados.style.display="none";
        selectCoordinacion.value=0;
        entradaMonto.value="";
        idMetaC.value=0;
    } else if(selectMCA.value=="listAsigna"){

        //console.log("aqui");

        contenedorAsignados.style.display="inline-block";
        contenedorMA.style.display="none";
    }
});

console.log(window.location.href);
var direccion=window.location.href;
//--------------------------------------------------------------------------------
function enviaMetaComercial() {
    
    var xmlhhtp=new XMLHttpRequest();

    var mensual={};
    mensual[1]="ENERO";
    mensual[2]="FEBRERO";
    mensual[3]="MARZO";
    mensual[4]="ABRIL";
    mensual[5]="MAYO";
    mensual[6]="JUNIO";
    mensual[7]="JULIO";
    mensual[8]="AGOSTO";
    mensual[9]="SEPTIEMBRE";
    mensual[10]="OCTUBRE";
    mensual[11]="NOVIEMBRE";
    mensual[12]="DICIEMBRE";
    
    var mes=[1,2,3,4,5,6,7,8,9,10,11,12];

    if(selectCoordinacion.value==0 || entradaMonto.value==0){
        alert("No se seleccionó a un coordinador o no se asignó una cantidad");
    } else{
        //console.log("aqui");
        xmlhhtp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                console.log(JSON.parse(this.responseText));
                console.log(JSON.parse(this.responseText).length);
                //console.log(this.responseText);

                resp=JSON.parse(this.responseText);

                if(resp.length>0 && idMetaC.value==0){

                    ultimoId=resp[0];

                    document.getElementById("conttablaMensual").style.display="inline-block";
                    document.getElementById("metaAsig").innerHTML="Meta anual asignado: $"+new Intl.NumberFormat().format(entradaMonto.value)+" MXN";
        
                    var contenedorTabla=document.getElementById("cuerpoMM");
    
                    contenedorTabla.innerHTML="";
    
                    for(var i=0; i<mes.length; i++){
                        contenedorTabla.innerHTML+=`
                            <tr>
                                <td>`+mensual[mes[i]]+`</td>
                                <td class="text-left"><input type="number" name="`+mes[i]+`" class="form-control" id="mes_`+mes[i]+`" required></td>
                                <td id="MontoRestante_`+i+`"></td>
                            </tr>
                        `;
                    }
                } else if(resp.length>0 && idMetaC.value>0){

                    ultimoId=idMetaC.value

                    document.getElementById("conttablaMensual").style.display="inline-block";
                    document.getElementById("metaAsig").innerHTML="Meta anual asignado: $"+new Intl.NumberFormat().format(entradaMonto.value)+" MXN";
        
                    var contenedorTabla=document.getElementById("cuerpoMM");
    
                    contenedorTabla.innerHTML="";

                    var respuesta=JSON.parse(this.responseText);

                    var valida=[];

                    for(var i=0; i<mes.length; i++){
                        for(var index in respuesta){
                            if(mes[i]==respuesta[index].mes_num){
                                contenedorTabla.innerHTML+=`
                                    <tr>
                                        <td>`+mensual[mes[i]]+`</td>
                                        <td class="text-left"><input type="number" name="`+mes[i]+`" class="form-control" id="mes_`+mes[i]+`" value="`+respuesta[index].monto_al_mes+`" required></td>
                                    </tr>
                                `;
                                //valida.push(respuesta[index].mes_num);
                            }
                        }
                    }
                } else if(resp.length==0){
                    alert("La asignación al coordinador ya esta registrado, si desea cambiar el monto del coordinador por favor seleccione la opcion: Ver lista de asignados");
                }
            }
        }
    
        //xmlhhtp.open("POST",direccion+"almacenaMetaComercial",true);
        //xmlhhtp.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' ); 
        xmlhhtp.open("GET",direccion+"/almacenaMetaComercial?q="+selectCoordinacion.value+"&r="+entradaMonto.value+"&p="+idMetaC.value, true);
        xmlhhtp.send();
    }    
}
//-------------------------------------------------------------------------------------------------
function enviaMontosMensuales(e){

    e.preventDefault();

    var formulario=document.getElementById("formMensualM");

    var datos={};

    var conteo=0;
    var camposllenos=0;

    for(var i=0;i<formulario.elements.length;i++){
       //console.log(formulario.elements[i]);
       if(formulario.elements[i].type=="number"){
            datos[formulario.elements[i].name]=formulario.elements[i].value;
        
            if(formulario.elements[i].value!=""){
                conteo+=parseFloat(formulario.elements[i].value);
                camposllenos++;
            }
        }
    }

    console.log(conteo);

    if(conteo>entradaMonto.value){
        alert("Se rebasó la cantidad anual");
        formulario.reset();
        selectCoordinacion.value=0;
        //entradaMonto.value="";
        conteo=0;
    } else if(camposllenos<12){
        alert("Dejó un campo vacío, revise de nuevo");
        //formulario.reset();
        selectCoordinacion.value=0;
    } else{
        
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                console.log(this.responseText);

                if(this.responseText==true){

                    alert("Datos enviados");

                    formulario.reset();
                    selectCoordinacion.value=0;
                    entradaMonto.value="";
                    //idMetaC.value=0;
                    document.location.reload();
                }
            }
        }

        xmlhttp.open("GET",direccion+"almacenaMontosMensuales?q="+ultimoId+"&r="+JSON.stringify(datos)+"&p="+idMetaC.value,true);
        xmlhttp.send();
    }
    
}
//-------------------------------------------------------------------------------------------------------------
function eliminaMeta(idMeta){

    var xmlhttp=new XMLHttpRequest();

    if(idMeta<0){
        alert("Ocurrió un error al eliminar, por favor contacte al departamento de sistemas");
    } else{

        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                console.log(JSON.parse(this.responseText));

                var respuesta=JSON.parse(this.responseText);

                for(var indice in respuesta){
                    
                    alert(respuesta[indice].mensaje);

                    if(respuesta[indice].proceso){
                        var fila=document.getElementById("fila_"+idMeta);
                        fila.style.display="none"
                    }

                }
            }
        }

        xmlhttp.open("GET", direccion+"eliminaMetaAsignado?q="+idMeta,true);
        xmlhttp.send();
    }

}
//-----------------------------------------------------------------------------------
function actualizaMeta(idPersona,montoAnual,idMeta){
    
    contenedorMA.style.display="block";
    contenedorAsignados.style.display="none";

    selectCoordinacion.value=idPersona;
    entradaMonto.value=montoAnual;
    idMetaC.value=idMeta;

    botonSubmit.innerHTML="Actualizar meta comercial";

}
//-----------------------------------------------------------------------------------
botonSubmit.addEventListener("click",enviaMetaComercial);
botonSubmitMensual.addEventListener("click",enviaMontosMensuales);

/*if(selectCoordinacion.value==0){
    console.log(selectCoordinacion.value);
}*/