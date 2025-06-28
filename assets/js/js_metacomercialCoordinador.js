var selectMonto=document.getElementById("mesMonto");
    var direccion=window.location.href;
    var idMeta=document.getElementById("metacomer").value;
    var selectOperacion=document.getElementById("operacion");
    var botonSubmit=document.getElementById("submitOperation");
    var form=document.getElementById("formularioAsigna");

    console.log(direccion);

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
    
    var monto=0;

//-------------------------------------------------------------------------------
/*function eligeOperacion(){

    var tab_agente=document.getElementById("panel_agentes");
    var tab_agente_asignado=document.getElementById("panel_agentes_asignados");
    var contButton=document.getElementById("ejecutaOperacion");

    if(selectOperacion.value==1){

        tab_agente.style.display="block";
        tab_agente_asignado.style.display="none";
        contButton.style.display="block";
        document.getElementById("panel_agentes_asignados_ramos").style.display="none";
        //form.reset();
    } else if(selectOperacion.value==2){

        tab_agente.style.display="none";
        //tab_agente_asignado.style.display="block";
        contButton.style.display="none";

    } else{
        tab_agente.style.display="none";
        tab_agente_asignado.style.display="none";
        contButton.style.display="none";

    }
}

selectOperacion.addEventListener("change",eligeOperacion);*/

//-------------------------------------------------------------------------------
//operacion_tipo
function eligeTipoAsignacion(){
    
    //Habilitar los check al realizar cambios en el select
    var class_check=document.getElementsByClassName("on_check");

    for(var qq=0; qq<class_check.length; qq++){
        
        class_check[qq].style.display="table-cell";
    }

    if(this.value==1){
        console.log("muestra campo comision");
        //document.getElementsByClassName("in_comision").style.display="inline-block";

        var elem_class_com=document.getElementsByClassName("in_comision");
        var elem_class_pol=document.getElementsByClassName("in_ramoPoliza");
        var elem_class_prim=document.getElementsByClassName("in_ramoPrima");
        document.getElementById("cantidad_polizas").style.display="none";
        document.getElementById("cantidad_primas").style.display="none";
        document.getElementById("cantidad_comision").style.display="table-cell";
        document.getElementById("mesMonto").style.display="block";
        document.getElementById("mesRamoA").style.display="none";
        document.getElementById("submitOperationRamo").style.display="none";
        document.getElementById("ramosRes").style.display="none";
        document.getElementById("btn_buscar").style.display="block";
        document.getElementById("btn_buscar_por_ramo").style.display="none";
        botonSubmit.style.display="block";
        document.getElementById("panel_agentes_asignados").style.display="block";
        document.getElementById("panel_agentes_asignados_ramos").style.display="none";
        /*if(selectOperacion.value==2){
            document.getElementById("panel_agentes_asignados").style.display="block";
            document.getElementById("panel_agentes_asignados_ramos").style.display="none";
        }*/

        for(var i=0; i<elem_class_com.length; i++){
            elem_class_com[i].style.display="table-cell";

        }

        for(var i=0; i<elem_class_pol.length; i++){
            elem_class_pol[i].style.display="none";

        }

        for(var i=0; i<elem_class_prim.length; i++){
            elem_class_prim[i].style.display="none";

        }

        //document.getElementsByClassName("in_ramoPoliza").style.display="none";
        //document.getElementsByClassName("in_ramoPrima").style.display="none";

    } else if(this.value==2){
        var elem_class_com=document.getElementsByClassName("in_comision");
        var elem_class_pol=document.getElementsByClassName("in_ramoPoliza");
        var elem_class_prim=document.getElementsByClassName("in_ramoPrima");
        document.getElementById("cantidad_polizas").style.display="table-cell";
        document.getElementById("cantidad_primas").style.display="table-cell";
        document.getElementById("cantidad_comision").style.display="none";
        document.getElementById("mesMonto").style.display="none";
        document.getElementById("mesRamoA").style.display="block";
        document.getElementById("submitOperationRamo").style.display="block";
        document.getElementById("ramosRes").style.display="block";
        document.getElementById("btn_buscar").style.display="none";
        document.getElementById("btn_buscar_por_ramo").style.display="block";
        botonSubmit.style.display="none";
        document.getElementById("panel_agentes_asignados").style.display="none";
        document.getElementById("panel_agentes_asignados_ramos").style.display="inline-block";
        /*if(selectOperacion.value==2){
            document.getElementById("panel_agentes_asignados").style.display="none";
            document.getElementById("panel_agentes_asignados_ramos").style.display="block";
        }*/

        for(var i=0; i<elem_class_com.length; i++){
            elem_class_com[i].style.display="none";

        }

        for(var i=0; i<elem_class_pol.length; i++){
            elem_class_pol[i].style.display="table-cell";

        }

        for(var i=0; i<elem_class_prim.length; i++){
            elem_class_prim[i].style.display="table-cell";

        }
    }
    
}

document.getElementById("operacion_tipo").addEventListener("change",eligeTipoAsignacion);
//-------------------------------------------------------------------------------

var montoTotalAsignado=0;
var asignados={};

function cargaListaAsignados(e){

        e.preventDefault()

        var xmlhttp=new XMLHttpRequest();

        if(selectMonto.value==0){
            alert("No se selecciono un mes");
            return false;
        }

        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
               console.log(JSON.parse(this.responseText));

                respuesta=JSON.parse(this.responseText);

                var pieFila="";

                var total=0;

                for(var indice in respuesta){

                    document.getElementById("montoM").innerHTML="";
                    document.getElementById("montoM").innerHTML+="Monto del mes: $ "+new Intl.NumberFormat().format(respuesta[indice].metaMensual-respuesta[indice].metaYaAsignados)+" MXN";
                    document.getElementById("cantidadMes").value=(respuesta[indice].metaMensual); //-respuesta[indice].metaYaAsignados
                    monto=respuesta[indice].metaMensual;

                    var registrosRows=document.getElementById("cuerpoRegistro");
                    registrosRows.innerHTML=``;

                    var persoalAgentes=respuesta[indice].agentesAsignados;

                    var montoUpdate=0;

                    for(var clave in persoalAgentes){
                        asignados[persoalAgentes[clave].idPersona]={
                            "monto_agente_mensual":parseFloat(persoalAgentes[clave].montoMes),
                            "asignacion_agente":persoalAgentes[clave].asignacion,
                        };
                    }

                    var doble=/"/g;
                    var json=JSON.stringify(asignados).replace(doble,"'");

                    for(var index in persoalAgentes){
                        
                        montoUpdate=monto-montoTotalAsignado;

                        //registrosRows.innerHTML+=` //new Intl.NumberFormat().format((persoalAgentes[index].ingresoTotalesEAB).toFixed(2))
                        registrosRows.innerHTML+=`
                            <tr id="fila_`+persoalAgentes[index].idPersona+`">
                                <td>`+persoalAgentes[index].nombres+` `+persoalAgentes[index].apellidoPaterno+` `+persoalAgentes[index].apellidoMaterno+`</td>
                                <td>`+persoalAgentes[index].emailUsers+`</td>
                                <td class="text-center">$ `+parseFloat(persoalAgentes[index].montoMes).toFixed(2)+` MXN</td>
                                <td class="text-center">$ `+parseFloat(persoalAgentes[index].ingresoTotalesEAB).toFixed(2)+` MXN</td>
                                <td class="text-center"><h4><span class="badge badge-`+(persoalAgentes[index].asignacion=="dinamico" ? "success" : "info")+`">`+(persoalAgentes[index].asignacion).toUpperCase()+`</span></h4></td>
                                <td class="text-center">
                                    <button id="updateRegistro_`+persoalAgentes[index].idPersona+`" class="btn btn-warning btn-sm" onclick="actualizaRegistro(`+json+`,'`+persoalAgentes[index].idPersona+`',`+parseInt(persoalAgentes[index].montoMes)+`,'`+persoalAgentes[index].asignacion+`'); return false;">Actualizar</button>
                                    <button id="deleteRegistro_`+persoalAgentes[index].idPersona+`" class="btn btn-danger btn-sm" onclick="eliminarRegistro(`+persoalAgentes[index].idPersona+`,`+persoalAgentes[index].montoMes+`,'`+persoalAgentes[index].asignacion+`'); return false;">Eliminar</button>
                                </td>
                            </tr>
                        `;
                    }
                }

                var cuerpoTabla=document.getElementById("cuerpoRegistro");
                var sumatoria=0;

                for(var i=0; i<cuerpoTabla.rows.length;i++){

                    fila=cuerpoTabla.rows[i];

                    for(var j=0; j<fila.cells.length;j++){
                        sumatoria=parseFloat(fila.cells[2].innerHTML.replace("$","").replace("MXN","").replace(",",""));
                    
                    }
                    total+=sumatoria;
                }
                pieFila+=`<tr><td colspan="3" class="text-right" id="montoTotalA">TOTAL ASIGNADO: <p id="mta"> $ `+total.toFixed(2)+` MXN </p>&nbsp&nbsp</td></tr>`;
                document.getElementById("pieRegistro").innerHTML=pieFila;
            }
        }

        xmlhttp.open("GET",direccion+"/devuelveMontos?q="+selectMonto.value+"&r="+idMeta,true);
        xmlhttp.send();
    }

    //selectMonto.addEventListener("change", cargaListaAsignados );
    document.getElementById("btn_buscar").addEventListener("click",cargaListaAsignados);
    //--------------------------------------------------------------------------------------------------
    function enviaAsignados(e){

    //Tomar los valores del mes, monto del mes,agentes,coordinador y idVendedor
    e.preventDefault();

    var agentes=[]
    var datosEnvio={};
    var cont=0;
    var agente_monto={};
    var _sumTotal_monto=0;
    var tipoUpdate={};
    var tipoNuevo={};
    var sumatoria_agentes_asignacion_manual_act=0;
    var sumatoria_agentes_asignacion_manual_nuevo=0;


    var monto_del_mes=document.getElementById("cantidadMes").value;
    var contador_vacios=0;

    for(var i=0; i<form.elements.length;i++){ //Para asignar la meta a agentes seleccionados
        if(form.elements[i].type=="checkbox"){ //Crear un objeto idPersona:monto
            if(form.elements[i].value!="on" && form.elements[i].checked){

                var valorMonto=document.getElementById("montoAsignado_"+form.elements[i].value).value;
                var tipoAsignado=document.getElementById("tipoAsigna_"+form.elements[i].value).value;
                var tipoGeneracion=document.getElementById("generacion_"+form.elements[i].value).value;

                if(valorMonto=="" || valorMonto==0){
                    valorMonto=0;
                    agente_monto[form.elements[i].value]=0;
                    contador_vacios++;

                } else{
                    //agente_monto[form.elements[i].value]=valorMonto;
                    if(tipoAsignado=="actualizacion"){ //Si es actualización de montos

                        tipoUpdate[form.elements[i].value]={
                            "meta_agente_asignado":parseFloat(valorMonto),
                            "tipo_asignacion": tipoGeneracion
                        };//parseFloat(valorMonto);

                        if(tipoGeneracion=="dinamico"){ //Si es dinamico cuenta los campos con valor dinamico.
                            contador_vacios++; 

                        } else{ //Si en actualización es manual, suma los montos.
                            sumatoria_agentes_asignacion_manual_act+=parseFloat(valorMonto); 
                        }
                       
                    } else{ //Si es asignación de montos
                        tipoNuevo[form.elements[i].value]={
                            "meta_agente_asignado":parseFloat(valorMonto),
                            "tipo_asignacion": "manual"
                        };
                        sumatoria_agentes_asignacion_manual_nuevo+=parseFloat(valorMonto); //Si es nueva asignación suma los montos (manuales).
                        //_sumTotal_monto+=parseFloat(valorMonto);
                    }
                }

                _sumTotal_monto+=parseFloat(valorMonto);
                cont++;

            } else if(form.elements[i].value!="on" && !form.elements[i].checked){
                var tipoAsignado__=document.getElementById("tipoAsigna_"+form.elements[i].value).value;

                if(tipoAsignado__=="actualizacion"){
                    tipoUpdate[form.elements[i].value]=0;
                       
                } else{
                    tipoNuevo[form.elements[i].value]=0;
                }

                contador_vacios++;
            }

           
            /*if(form.elements[i].checked){

                agentes.push(form.elements[i].value);
                cont++;
            } */
        }
    }
    //Proceso de asignación de un monto fijo a el resto de los agentes.

    var diferencia_para_no_asignados= 0; //(monto_del_mes > _sumTotal_monto) ? monto_del_mes - _sumTotal_monto: _sumTotal_monto; //(monto_del_mes - _sumTotal_monto)/contador_vacios;

    if(sumatoria_agentes_asignacion_manual_nuevo>0){
        diferencia_para_no_asignados=(monto_del_mes - sumatoria_agentes_asignacion_manual_nuevo);
    } else{
        diferencia_para_no_asignados=(monto_del_mes - sumatoria_agentes_asignacion_manual_act);
    }

    var segmentos_de_meta_para_no_asignados=(diferencia_para_no_asignados/contador_vacios);

    if(Object.keys(tipoNuevo).length>0){
        for(var aa in tipoNuevo){
            if(tipoNuevo[aa]==0){
                tipoNuevo[aa]={ 
                    "meta_agente_asignado":segmentos_de_meta_para_no_asignados,
                    "tipo_asignacion": "dinamico"
                };
            }
        }
    }
    
    if(Object.keys(tipoUpdate).length>0){
        console.log("Hola mundooo");
        for(var bb in tipoUpdate){
            if(tipoUpdate[bb].tipo_asignacion=="dinamico"){
                tipoUpdate[bb].meta_agente_asignado=segmentos_de_meta_para_no_asignados;
                //tipoUpdate[bb].tipo_asignacion="Hola";//{ 
                    //"meta_agente_asignado":segmentos_de_meta_para_no_asignados,
                    //"tipo_asignacion": "dinamico"
                //};
            }
        }
    }
    
    console.log(segmentos_de_meta_para_no_asignados);
    //console.log("suma campos "+_sumTotal_monto);
    //console.log("suma restante de meta "+monto_del_mes);
    console.log("campos vacios "+contador_vacios);
    console.log("suma manual "+sumatoria_agentes_asignacion_manual_nuevo);
    console.log("suma manual actualizado "+sumatoria_agentes_asignacion_manual_act);
    console.log("diferencia "+diferencia_para_no_asignados);
    console.log(cont);

    agente_monto={
        "renovacion":tipoUpdate,
        "nuevo":tipoNuevo
    };

    agentes.push(agente_monto);
    console.log(agente_monto);
    //console.log(agentes,_sumTotal_monto, cont);

    var coordinador=document.getElementById("coordinador");
    var metaMes=document.getElementById("metaMes");

    datosEnvio["mes"]=selectMonto.value;
    datosEnvio["metaMensual"]=document.getElementById("cantidadMes").value;
    datosEnvio["coordinador"]=coordinador.value;
    datosEnvio["agentes"]=agentes;

    //console.log(JSON.stringify(datosEnvio));
    jsonObject=JSON.stringify(datosEnvio);

    if(cont>0){ // && _sumTotal_monto>=document.getElementById("cantidadMes").value

        console.log("procede");
        var xmlhttp=new XMLHttpRequest();

        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                //console.log(this.responseText);

                if(this.responseText){
                    for(var j=0; j<form.elements.length;j++){
                        if(form.elements[j].type=="checkbox"){
                            if(form.elements[j].checked){

                                var parentHijo=form.elements[j].parentNode
                                var parentFila=parentHijo.parentNode;
                                //console.log(parentFila);
                                parentFila.classList.add("success");
                                form.elements[j].checked=false;

                                document.getElementById("montoAsignado_"+form.elements[j].value).disabled=true;
                                document.getElementById("montoAsignado_"+form.elements[j].value).value="";
                            }
                        }
                    }
                    if(confirm("Para guardar los cambios la página se recargará en cinco segundos.")){
                        setTimeout(function(){
                            document.location.reload();
                        },5000);
                    }
                    //setTimeout('document.location.reload()',5000);
                } else{
                    alert("Ocurrió un problema al asignar la meta. Intente más tarde");
                }
            }
        }
        xmlhttp.open("POST",direccion+"/almacenaMetaMensualAsignadasAgente",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("asycData="+jsonObject);

    } else if(selectMonto.value==0){
        alert("No seleccionó un mes");

    } /*else if( _sumTotal_monto>document.getElementById("cantidadMes").value){
        alert("La sumatoria de los montos asignados a los agentes superó el monto mensual");

    }*/ else if(cont==0){ // validar en cuanto se seleccione a un agente y envíe un campo vacío;
        alert("Debe seleccionar a un agente");
        
    } else if(_sumTotal_monto==0){
        alert("Debe asignar un monto minímo a un agente");
    }
    
    } 

    botonSubmit.addEventListener("click",enviaAsignados);
//--------------------------------------------------------------------------------------------------
 function eliminarRegistro(idPersona,montoAsignado,asignacion){

    var xmlhttp=new XMLHttpRequest();

    var espaceMonto=document.getElementById("mta");
    espaceMonto.innerHTML="";
    var total=0;
    var sumatoria=0;
    var contador_dinamicos=asignacion == "manual" ? 1 : 0; //0; //Descomentar en caso de que si se tome en cuenta el agente asignado (convertirlo a dinamico).
    //var contador_dinamicos=asignacion=0; //Descomentar en caso de que no se tome en cuenta al agente asignado (quitarlo de la lista).
    var comision_para_dinamicos=asignacion == "manual" ? montoAsignado : 0;

    var fila=document.getElementById("fila_"+idPersona);

    tablaCuerpo=document.getElementById("cuerpoRegistro");

    for(var i=0; i<tablaCuerpo.rows.length; i++){

        var fila=tablaCuerpo.rows[i];

        if((fila.cells[4].firstChild.firstChild.innerHTML).toLowerCase()=="dinamico"){
         
            comision_para_dinamicos+=parseFloat(fila.cells[2].innerHTML.replace("$","").replace("MXN","").replace(",","")); //Sumar todos los montos de los dinámicos.
            contador_dinamicos++;
        }
    }

    console.log(contador_dinamicos);
    console.log(comision_para_dinamicos);

    xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var respuesta=JSON.parse(this.responseText);

            for(var indice in respuesta){

                alert(respuesta[indice].mensaje);

                if(respuesta[indice].estado){
                    
                    //delete asignados[idPersona];
                   
                    //Descomentar en caso de que no se tome en cuenta al agente asignado (quitarlo de la lista).
                    /*var padre=fila.parentNode;
                    padre.removeChild(fila);*/
                    
                    for(var i=0; i<tablaCuerpo.rows.length; i++){

                        var fila=tablaCuerpo.rows[i];

                        for(var j=1; j<fila.cells.length; j++){
                            sumatoria=parseFloat(fila.cells[2].innerHTML.replace("$","").replace("MXN","").replace(",",""));
                        }
                        
                        total+=sumatoria;                       
                    }
                }
            }
            espaceMonto.innerHTML+=`$ `+total+` MXN`;

            setTimeout(function(){
                if(confirm("Para realizar los cambios es necesario recargar la página. ¿Desea recargar?")){
                    window.location.reload();
                }
            },3000);
        }
    }

    xmlhttp.open("GET",direccion+"/eliminaAsignacion?q="+idPersona+"&r="+selectMonto.value+"&p="+parseFloat(comision_para_dinamicos/contador_dinamicos),true);
    xmlhttp.send();

 }

//--------------------------------------------------------------------------------------------------
function seleccionarTodos(){

    var form=document.getElementById("formularioAsigna");
    var todos=document.querySelector("input[name='todos']:checked");

    for(var i=0; i<form.elements.length; i++){
        if(form.elements[i].type=="checkbox"){
            if(todos){
                form.elements[i].checked=true;
               
                if (form.elements[i].value!="on"){
 
                    document.getElementById("montoAsignado_"+form.elements[i].value).disabled=false;
                    document.getElementById("montoAsignado_polizas_"+form.elements[i].value).disabled=false;
                    document.getElementById("montoAsignado_prima_"+form.elements[i].value).disabled=false;
                }
            }
            else{
                
                var campoNum=document.getElementById("montoAsignado_"+form.elements[i].value);

                if(form.elements[i].value!="on" && campoNum.value==""){
                    //console.log(campoNum.value);
                    campoNum.disabled=true;
                    document.getElementById("montoAsignado_polizas_"+form.elements[i].value).disabled=true;
                    document.getElementById("montoAsignado_prima_"+form.elements[i].value).disabled=true;
                    form.elements[i].checked=false;
                }
            }
        }
    }
}

var todosCheck=document.getElementById("allCheck");

todosCheck.addEventListener("change",seleccionarTodos);

//--------------------------------------------------------------------------------------------------
function habilitaCampo(idPersona,objHTML){
    
    var campoNum=document.getElementById("montoAsignado_"+idPersona);
    var campoNum_pol=document.getElementById("montoAsignado_polizas_"+idPersona);
    var campoNum_prim=document.getElementById("montoAsignado_prima_"+idPersona);

    if(objHTML.checked){
        //console.log("seleccionado");
        campoNum.disabled=false;
        campoNum_pol.disabled=false;
        campoNum_prim.disabled=false;

    } else{
        campoNum.disabled=true;
        campoNum.value="";

        campoNum_pol.disabled=true;
        campoNum_pol.value="";

        campoNum_prim.disabled=true;
        campoNum_prim.value="";
    }
}
//--------------------------------------------------------------------------------------------------
function actualizaRegistro(asignados,idPersona,montoAsignado,modo){
    
    var panel_agentes=document.getElementById("panel_agentes");
    var panel_asignados=document.getElementById("panel_agentes_asignados");
    var cuerpoTabla=document.getElementById("cuerpoRegistro");
    var button=document.getElementById("ejecutaOperacion");

    var sumatoria=0;
    var total=0;

    panel_agentes.style.display="block";
    panel_asignados.style.display="none";
    button.style.display="block";

    document.getElementById("contenedor_panel_agentes-tab").setAttribute("aria-selected", "true");
    document.getElementById("contenedor_panel_agentes-tab").classList.add("active");
    document.getElementById("contenedor_panel_agentes-tab").classList.add("show");

    document.getElementById("contenedor_panel_agentes").classList.add("fade");
    document.getElementById("contenedor_panel_agentes").classList.add("active");
    document.getElementById("contenedor_panel_agentes").classList.add("show");

    document.getElementById("contenedor_panel_asignados-tab").setAttribute("aria-selected", "false");
    document.getElementById("contenedor_panel_asignados-tab").classList.remove("active");
    document.getElementById("contenedor_panel_asignados-tab").classList.remove("show");

    for(var i=0; i<cuerpoTabla.rows.length;i++){

        fila=cuerpoTabla.rows[i];

        for(var j=0;j<fila.cells.length;j++){
            sumatoria=parseFloat(fila.cells[2].innerHTML.replace("$","").replace("MXN","").replace(",",""));
        }
        total+=sumatoria;
    }

    var restante=0;
    //console.log(total);
    restante=parseFloat(monto).toFixed(2)-total.toFixed(2);

    document.getElementById("montoM").innerHTML=`Monto del mes: $ `+new Intl.NumberFormat().format(monto)+` MXN - Monto restante: $ `+new Intl.NumberFormat().format(restante.toFixed(2))+` MXN`;
    //document.getElementById("cantidadMes").value=restante;

    var _objeto_json=JSON.parse(JSON.stringify(asignados));

    for(var i in _objeto_json){
        if(i==idPersona){
            delete _objeto_json[i];
        }

        if(i!=idPersona){
            //console.log(_objeto_json[i].monto_agente_mensual);
            document.getElementById("check_"+i).checked=true;
            document.getElementById("check_"+i).disabled=true;
            document.getElementById("montoAsignado_"+i).disabled=true;
            document.getElementById("montoAsignado_"+i).value=parseFloat(_objeto_json[i].monto_agente_mensual).toFixed(2);
            document.getElementById("tipoAsigna_"+i).value="actualizacion"; //generacion_
            document.getElementById("generacion_"+i).value=_objeto_json[i].asignacion_agente; //asignacion_agente
        } else{
            document.getElementById("check_"+idPersona).checked=true;
            document.getElementById("check_"+i).disabled=false;
            document.getElementById("montoAsignado_"+idPersona).disabled=false;
            document.getElementById("montoAsignado_"+idPersona).value=parseFloat(montoAsignado).toFixed(2);
            document.getElementById("tipoAsigna_"+idPersona).value="actualizacion";
            document.getElementById("generacion_"+idPersona).value="manual";//modo;
        }
    }

}
//------------------------------------------------------------
//Dennis [2021-01-27]

/*function peticionAJAXRamos(tipoRequest,url,crud,ob){

    var xmlhttp=new XMLHttpRequest();
    //var respuesta={};
    //var respuesta_obj=new Object();

    xmlhttp.onreadystatechange=function(){

        var respuesta_obj=new Object();

        if(this.readyState==4 && this.status==200){

            respuesta=JSON.parse(this.responseText);

        }

        //return respuesta_obj;
    }

    xmlhttp.open(tipoRequest,url, true);

    if(tipoRequest=="POST"){
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("send="+JSON.stringify(ob));
    } else{
        xmlhttp.send();
    }

    //console.log(xmlhttp);

    //return respuesta_obj;//JSON.stringify(respuesta);
} */
//------------------------------------------------------------
function obtenerDatos(e){

    e.preventDefault();

    var mes=document.getElementById("mesRamoA").value;//selectedIndex;
    var idCoordinador=document.getElementById("idCoordinador").value;
    var u_ere_ele=direccion+"/obtenerInfoEnRamosCoor?q="+mes+"&r="+idCoordinador;

    document.getElementById("montoMRest").innerHTML=``;

    //var resultadoAjax=peticionAJAXRamos("GET",u_ere_ele,"r",{});
    if(mes==0 || document.getElementById("ramosRes").value==0){
        alert("No se seleccionó un mes o un ramo");
        return false;
    }
    //-------------------------
    //Petición AJAX: GET.
    var xmlhh= new XMLHttpRequest();

    xmlhh.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var res=JSON.parse(this.responseText);
            console.log(res);

            if(res.mensaje!=""){
                alert(res.mensaje);
                document.getElementById("btn_consulta_Sicas").style.display="none";
            }

            var monto_visor=document.getElementById("montoM");
            monto_visor.innerHTML=``;

            for(var e in res.montos){

                if(res.mensaje==""){

                    if(document.getElementById("ramosRes").value == e){

                        monto_visor.innerHTML+=`Cantidad de Pólizas: `+(res.montos[e].polizas)+` - Prima: $`+new Intl.NumberFormat().format(res.montos[e].prima);
                        document.getElementById("cantidadMes_poliza").value=res.montos[e].polizas;
                        document.getElementById("cantidadMes_prima").value=res.montos[e].prima;
                    }
                   
                }
            }

            //console.log(res.montosYaAsignados.autos.polizas); // - res.montosYaAsignados.e.polizas

            var cuerpoRegRamos=document.getElementById("cuerpoRegistroRamo");
            cuerpoRegRamos.innerHTML=``;

            var sobrante_polizas=0;
            var sobrante_prima=0;

            //--------------------------------
            for(var w in res.personalAsignado){
                
                if(res.mensaje==""){

                    var ramos_reg=res.personalAsignado[w].ramo;

                    for(var q in ramos_reg){

                        if(document.getElementById("ramosRes").value == q){ 
                            sobrante_polizas+=parseInt(ramos_reg[q].polizas);
                            sobrante_prima+=parseFloat(ramos_reg[q].prima.replace(",",""));
                        }
                    }
                }
            }
            //--------------------------------

           //console.log(Object.keys(res.personalAsignado).length === 0);

           var doble=/"/g;

            if(Object.keys(res.personalAsignado).length > 0){
                for(var i in res.personalAsignado){
                
                    if(res.mensaje==""){

                        var ramos_reg=res.personalAsignado[i].ramo;

                        for(var a in ramos_reg){
                            if(document.getElementById("ramosRes").value == a){

                                document.getElementById("btn_consulta_Sicas").style.display="block";

                                var info_agente_unitario={};
                                info_agente_unitario["idPersona"]=i;
                                info_agente_unitario["idCoordinador"]=idCoordinador;
                                info_agente_unitario["prima_agente"]=ramos_reg[a].prima.replace(",","");
                                info_agente_unitario["polizas_agente"]=ramos_reg[a].polizas;
                                
                                //console.log(a);
                                cuerpoRegRamos.innerHTML+=`
                                    <tr id="fila_ramo_`+i+`" id_vend="`+res.personalAsignado[i].idVend+`">
                                        <td class="text-center">`+res.personalAsignado[i].nombre+`</td>
                                        <td class="text-center">`+res.personalAsignado[i].correo+`</td>
                                        <td class="text-center">`+a.toUpperCase()+`</td>
                                        <td class="text-center">`+ramos_reg[a].polizas+`</td>
                                        <td class="text-center">`+parseFloat(ramos_reg[a].prima).toFixed(2)+`</td>
                                        <td class="text-center" id="`+res.personalAsignado[i].idVend+`_cantidad_polizas">0</td>
                                        <td class="text-center" id="`+res.personalAsignado[i].idVend+`_cantidad_prima">$ 0</td>
                                        <td class="text-center"><h4><span class="badge badge-`+(res.personalAsignado[i].asignacion=="dinamico" ? "success" : "info")+`">`+(res.personalAsignado[i].asignacion).toUpperCase()+`</span></h4>`+(res.personalAsignado[i].es_nuevo==1 ? `&nbsp<label class="text-danger">¡Nueva asignación!</label>` : ``)+`</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-outline-info dropdown-toggle" type="button" id="options_polizas_primas_`+i+`" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="options_polizas_primas">
                                                    <!--<a class="dropdown-item text-primary" href="javascript: void(0);">Consulta a Sicas</a>-->
                                                    <a class="dropdown-item text-info" href="javascript: void(0);" onclick="act_datos_ramo(`+i+`,`+JSON.stringify(res.personalAsignado).replace(doble,"'")+`,`+mes+`,'`+a+`',`+sobrante_polizas+`,`+sobrante_prima+`); return false;">Editar asignación</a>
                                                    <!--<div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="javascript: void(0);" onclick="del_datos_ramo(`+i+`,`+idCoordinador+`,`+mes+`,'`+a+`',1); return false;">Eliminar asignación</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-warning" href="javascript: void(0);" onclick="del_datos_ramo(`+i+`,`+idCoordinador+`,`+mes+`,'`+a+`',2); return false;">Eliminar y reasignar</a>-->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                `; //`+i+`,`+idCoordinador+`,,`+ramos_reg[a].polizas+`,`+ramos_reg[a].prima.replace(",","")+`
                            } else{
                                //alert("No Hay registros para este ramo");
                                //document.getElementById("btn_consulta_Sicas").style.display="none";
                            }
                        }
                        //if(document.getElementById("ramosRes").value == e){ }

                    }
                }
            } else{

                cuerpoRegRamos.innerHTML+=`
                    <tr>
                        <td colspan="7" class="text-center"><h3>No se encontraron datos</h3></td>
                    </tr>
                `
            }
        }
    }

    xmlhh.open("GET",u_ere_ele,true);
    xmlhh.send();
    //-------------------------
}

//document.getElementById("mesRamoA").addEventListener("change",obtenerDatos); //btn_buscar
document.getElementById("btn_buscar_por_ramo").addEventListener("click",obtenerDatos);
//------------------------------------------------------------
function asignaMetaRamo(e){

    e.preventDefault();

    var updateDatosRamosMetas={};
    var createDatosRamosMetas={};

    var contador_polizas=0;
    var contador_prima=0;
    var sumatoria_polizas_nuevo=0;
    var sumatoria_polizas_act=0;

    var contador_agentes_dinamicos=0;
    var contador_prima_agentes_manual=0;

    var campos_vacios=[];
    var campos_act_=[];

    var ramo_seleccionado=document.getElementById("ramosRes").value;

    for(var i=0; i<form.elements.length; i++){ //Recorrido del formulario general.

        if(form.elements[i].type=="checkbox" && form.elements[i].checked && form.elements[i].value!="on"){
            //console.log(form.elements[i].value);

            var tipo_registro=document.getElementById("tipoAsigna_"+form.elements[i].value);
            var cant_polizas_asignada=document.getElementById("montoAsignado_polizas_"+form.elements[i].value);
            var cant_primas_asignada=document.getElementById("montoAsignado_prima_"+form.elements[i].value);

            var monto_m_pol=document.getElementById("cantidadMes_poliza").value; //Meta del mes en polizas
            var monto_m_prim=document.getElementById("cantidadMes_prima").value; //Meta del mes en primas

            contador_polizas+=parseInt(cant_polizas_asignada.value);
            contador_prima+=parseFloat(cant_primas_asignada.value);

            if(cant_polizas_asignada.value=="" || cant_primas_asignada.value=="" ){
                alert("Se dejó un campo vació en la asignación");
                return false;

            }else if(cant_polizas_asignada.value<1 || cant_primas_asignada.value<1){
                alert("Se asignó cero en pólizas o primas, favor de verificar de nuevo");

              return false;
            } else{
                
                //console.log("chido");
                if(tipo_registro.value=="actualizacion"){

                    if(document.getElementById("generacion_"+form.elements[i].value).value=="dinamico"){
                        
                        contador_agentes_dinamicos++;

                    } else{
                        contador_prima_agentes_manual+=parseFloat(cant_primas_asignada.value);
                    }

                    var agente_para_actualizar={};
                    agente_para_actualizar["agente"]=form.elements[i].value;
                    agente_para_actualizar["tipo_agente"]=tipo_registro.value;
                    agente_para_actualizar["asignacion"]=document.getElementById("generacion_"+form.elements[i].value).value;
                    agente_para_actualizar["polizas"]=cant_polizas_asignada.value;
                    agente_para_actualizar["prima"]=cant_primas_asignada.value;
                    campos_act_.push(agente_para_actualizar);
                    /*updateDatosRamosMetas[form.elements[i].value]={
                        "ramos":{
                            [ramo_seleccionado]:{
                            "polizas": cant_polizas_asignada.value,
                            "prima":cant_primas_asignada.value,
                            "asignacion": document.getElementById("generacion_"+form.elements[i].value).value
                            }
                        },
                        "mes":document.getElementById("mesRamoA").value
                    } */
                } else{
                    createDatosRamosMetas[form.elements[i].value]={
                        "ramos":{
                            [ramo_seleccionado]:{
                            "polizas": cant_polizas_asignada.value,
                            "prima":cant_primas_asignada.value,
                            "asignacion": "manual"
                            }
                        },
                        "mes":document.getElementById("mesRamoA").value
                    }
                }
            } //Cierre de validación de cvampos vacios.
        } else if(form.elements[i].type=="checkbox" && !form.elements[i].checked && form.elements[i].value!="on"){

            var tipo_registro=document.getElementById("tipoAsigna_"+form.elements[i].value);

            var agente_vacio={};
            agente_vacio["agente"]=form.elements[i].value;
            agente_vacio["tipo_agente"]=tipo_registro.value;

            campos_vacios.push(agente_vacio); //form.elements[i].value
        }
    }

    console.log(contador_agentes_dinamicos);
    console.log(contador_prima_agentes_manual);

    //---------------------------------
    //Devuelve las cantidades sobrantes
    var residuos=calculaRestoDeAsignaciones(monto_m_pol,contador_polizas,monto_m_prim,contador_prima);
    console.log(residuos);
    console.log(campos_act_);

    if(residuos.limite_restante>0){

        for(var a in campos_vacios){
            if(a < residuos.limite_restante && campos_vacios[a].tipo_agente=="nuevo"){
                console.log(campos_vacios[a].agente);
                
                createDatosRamosMetas[campos_vacios[a].agente]={
                    "ramos":{
                        [ramo_seleccionado]:{
                        "polizas": 1,
                        "prima":residuos.prima_por_poliza,
                        "asignacion": "dinamico"
                        }
                    },
                    "mes":document.getElementById("mesRamoA").value
                }
            }
        }

        /*for(var b=0; b<campos_vacios.length; b++){

            if(b < residuos.limite_restante){
                console.log(campos_vacios[b]);
                //break;
            }
        }*/
    }
    //----------------------------------
    if(campos_act_.length>0){

        var monto_dinamico_total = (monto_m_prim-contador_prima_agentes_manual); //Diferencia del total de la meta y lo asignado a los manuales.
        var prima_para_agentes_dinamicos=monto_dinamico_total/contador_agentes_dinamicos; //Meta dinámica para cada agente dinamico.

        for(var b in campos_act_){

            //if(campos_act_[b].asignacion == "dinamico"){
                
                updateDatosRamosMetas[campos_act_[b].agente]={
                    "ramos":{
                        [ramo_seleccionado]:{
                            "polizas": (campos_act_[b].asignacion == "dinamico" ? 1 : campos_act_[b].polizas), //1,
                            "prima": (campos_act_[b].asignacion == "dinamico" ? prima_para_agentes_dinamicos : campos_act_[b].prima), //prima_para_agentes_dinamicos,
                            "asignacion": (campos_act_[b].asignacion == "dinamico" ? "dinamico" : campos_act_[b].asignacion) //"dinamico"
                        }
                    },
                    "mes":document.getElementById("mesRamoA").value
                }
            //} else{

                //updateDatosRamosMetas[campos_act_[b].agente]={
                //    "ramos":{
                //        [ramo_seleccionado]:{
                //        "polizas": campos_act_[b].polizas,
                //        "prima":campos_act_[b].prima,
                //        "asignacion": campos_act_[b].asignacion
                //        }
                //    },
                //    "mes":document.getElementById("mesRamoA").value
                //}

            //}

            //console.log(campos_act_[b].agente);
        }
    }
    //----------------------------------

    if(contador_polizas>monto_m_pol){
        console.log(monto_m_pol,contador_prima);
        alert("Se superó la cantidad de asignación de polizas");
        return false;
    } else if(contador_prima>monto_m_prim){
        console.log(contador_polizas,contador_prima);
        alert("Se superó la cantidad de prima en polizas");
        return false;
    }
    //console.log(updateDatosRamosMetas);
    var send_object={
        "asignacion":{
            "nuevo":createDatosRamosMetas,
            "renovacion":updateDatosRamosMetas
        },
        //"mes": document.getElementById("mesRamoA").value,
        //"ramo": ramo_seleccionado,
        //"conteo_polizas": contador_polizas,
        //"conteo_primas": contador_prima
    };

    console.log(monto_m_pol,contador_prima);
    console.log(send_object);
    //-------------------------------------
    var xht=new XMLHttpRequest();

    xht.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var respuesta=JSON.parse(this.responseText);
            console.log(respuesta);

            if(respuesta.mensaje==""){
                alert("Datos asignados");
                window.location.reload();
            } else{
                alert(respuesta.mensaje);
            }
        }
    }

    xht.open("POST", direccion+"/almacenaMetasRamosAgentes", true);
    xht.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xht.send("send="+JSON.stringify(send_object));

    //console.log(contador_polizas,contador_prima);
    //-------------------------------------
}

document.getElementById("submitOperationRamo").addEventListener("click", asignaMetaRamo);
//------------------------------------------------------------
function calculaRestoDeAsignaciones(pa,pt,pra,prt){

    resultado=new Object();
    var result_polizas=0;
    var result_primas=0;
    var prima_x_polizas=0;

    result_polizas=parseFloat(pa)-parseFloat(pt);
    result_primas=parseFloat(pra)-parseFloat(prt);
    prima_x_polizas=(result_primas/result_polizas);

    resultado["polizas_rest"]=result_polizas;
    resultado["prima_rest"]=result_primas;
    resultado["limite_restante"]=result_polizas;
    resultado["prima_por_poliza"]=(result_polizas>0) ? prima_x_polizas : 0;

    return resultado;

}
//-----------------------------------------------------------
function del_datos_ramo(idPersona,coor,mes,ramo,bandera){

    var xmlhhtp= new XMLHttpRequest();
    var contador_polizas=0;
    var contador_primas=0;
    var t_body=document.getElementById("cuerpoRegistroRamo");

    for(var a=0; a<t_body.rows.length; a++){

        var asignacion=t_body.rows[a].cells[7].firstChild.firstChild.innerHTML.toLowerCase();

        if(asignacion=="dinamico"){
            contador_polizas+=parseFloat(t_body.rows[a].cells[3].innerHTML);
            contador_primas+=parseFloat(t_body.rows[a].cells[4].innerHTML);
        }

        //console.log(t_body.rows[a].cells[7].firstChild.firstChild);
    }

    console.log(contador_polizas);

    xmlhhtp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var respuesta=JSON.parse(this.responseText);

            alert(respuesta.mensaje);

            if(respuesta.bool){

                fila_ramo=document.getElementById("fila_ramo_"+idPersona);
                var tabla=fila_ramo.parentNode;
                tabla.removeChild(fila_ramo);

                if(confirm("Para actualizar datos hay que recargar la página")){
                    window.location.reload();
                }
            }
        }
    }

    xmlhhtp.open("GET", direccion+"/eliminaRegistroDeRamo?q="+idPersona+"&r="+coor+"&p="+mes+"&s="+ramo+"&a="+contador_polizas+"&b="+contador_primas+"&band="+bandera, true);
    xmlhhtp.send();

}
//-------------------------------------------------------------
function act_datos_ramo_respaldo(agente,coor,mes,ramo,polizas,prima, rest_pol,rest_prim){

    document.getElementById("panel_agentes_asignados_ramos").style.display="none";
    document.getElementById("panel_agentes").style.display="block";
    //contenedor_panel_agentes-tab
    document.getElementById("contenedor_panel_agentes-tab").setAttribute("aria-selected", "true");
    document.getElementById("contenedor_panel_agentes-tab").classList.add("active");
    document.getElementById("contenedor_panel_agentes-tab").classList.add("show");

    document.getElementById("contenedor_panel_agentes").classList.add("fade");
    document.getElementById("contenedor_panel_agentes").classList.add("active");
    document.getElementById("contenedor_panel_agentes").classList.add("show");

    document.getElementById("contenedor_panel_asignados-tab").setAttribute("aria-selected", "false");
    document.getElementById("contenedor_panel_asignados-tab").classList.remove("active");
    document.getElementById("contenedor_panel_asignados-tab").classList.remove("show");
    //contenedor_panel_asignados-tab
    //document.getElementById("check_"+agente).disabled=false;
    document.getElementById("operacion_tipo").disabled=true;
    document.getElementById("contenedor_panel_asignados-tab").classList.add("disabled"); //contendor_envio_correos-tab
    document.getElementById("contendor_envio_correos-tab").classList.add("disabled");
    document.getElementById("montoMRest").innerHTML=`Total de pólizas asignadas: `+rest_pol+` - Total en prima: $`  +new Intl.NumberFormat().format(rest_prim);

    //cantidadMes_poliza, cantidadMes_prima
    $restante_polizas=parseInt(document.getElementById("cantidadMes_poliza").value)-parseInt(rest_pol);
    $restante_prima=parseFloat(document.getElementById("cantidadMes_prima").value)-parseFloat(rest_prim);

    document.getElementById("cantidadMes_poliza").value=$restante_polizas;
    document.getElementById("cantidadMes_prima").value=$restante_prima;

    console.log(prima);

    var check_list=document.getElementsByName("idPersona[]");

    for(var a=0; a<check_list.length; a++){

        if(check_list[a].value==agente){
            check_list[a].checked=true;
            check_list[a].disabled=false;

            document.getElementById("montoAsignado_polizas_"+check_list[a].value).disabled=false;
            document.getElementById("montoAsignado_prima_"+check_list[a].value).disabled=false;
            document.getElementById("montoAsignado_polizas_"+check_list[a].value).value=polizas;
            document.getElementById("montoAsignado_prima_"+check_list[a].value).value=prima;
            document.getElementById("allCheck").disabled=true;
            document.getElementById("tipoAsigna_"+check_list[a].value).value="actualizacion";
            document.getElementById("submitOperationRamo").style.display="block";
            document.getElementById("ejecutaOperacion").style.display="block"; //ejecutaOperacion
            document.getElementById("generacion_"+check_list[a].value).value="manual";
            
        } else{
            check_list[a].disabled=true;
            document.getElementById("montoAsignado_polizas_"+check_list[a].value).disabled=true;
            document.getElementById("montoAsignado_prima_"+check_list[a].value).disabled=true;
        }

    }

    /*for(var a=0; a<form.elements.length; a++){

        if(form.elements[a].type=="checkbox" && form.elements[a].value==agente){
            document.getElementById("check_"+agente).disabled=false;
            document.getElementById("check_"+agente).checked=true;
            document.getElementById("montoAsignado_polizas_"+agente).disabled=false;
            document.getElementById("montoAsignado_prima_"+agente).disabled=false;
            document.getElementById("montoAsignado_polizas_"+agente).value=polizas;
            document.getElementById("montoAsignado_prima_"+agente).value=prima;

        } else{
            //document.getElementById("check_"+agente).disabled=true;
        }

    }*/

}
//-------------------------------------------------------------
function act_datos_ramo(idPersona,info_restante_object,mes,ramo,rest_pol,rest_prim){

document.getElementById("panel_agentes_asignados_ramos").style.display="none";
document.getElementById("panel_agentes").style.display="block";
//contenedor_panel_agentes-tab
document.getElementById("contenedor_panel_agentes-tab").setAttribute("aria-selected", "true");
document.getElementById("contenedor_panel_agentes-tab").classList.add("active");
document.getElementById("contenedor_panel_agentes-tab").classList.add("show");

document.getElementById("contenedor_panel_agentes").classList.add("fade");
document.getElementById("contenedor_panel_agentes").classList.add("active");
document.getElementById("contenedor_panel_agentes").classList.add("show");

document.getElementById("contenedor_panel_asignados-tab").setAttribute("aria-selected", "false");
document.getElementById("contenedor_panel_asignados-tab").classList.remove("active");
document.getElementById("contenedor_panel_asignados-tab").classList.remove("show");
//contenedor_panel_asignados-tab
//document.getElementById("check_"+agente).disabled=false;
document.getElementById("operacion_tipo").disabled=true;
document.getElementById("contenedor_panel_asignados-tab").classList.add("disabled"); //contendor_envio_correos-tab
document.getElementById("contendor_envio_correos-tab").classList.add("disabled");
document.getElementById("montoMRest").innerHTML=`Total de pólizas asignadas: `+rest_pol+` - Total en prima: $`  +new Intl.NumberFormat().format(rest_prim);

//cantidadMes_poliza, cantidadMes_prima
restante_polizas=parseInt(document.getElementById("cantidadMes_poliza").value); //-parseInt(rest_pol);
restante_prima=parseFloat(document.getElementById("cantidadMes_prima").value); //-parseFloat(rest_prim);

document.getElementById("cantidadMes_poliza").value=restante_polizas;
document.getElementById("cantidadMes_prima").value=restante_prima;
document.getElementById("ejecutaOperacion").style.display="block"; 

var objeto_json=JSON.parse(JSON.stringify(info_restante_object));

console.log(objeto_json);

for(var i in objeto_json){

    for(var a in objeto_json[i].ramo){
        //console.log(objeto_json[i].ramo[a]);

        if(i==idPersona){
            document.getElementById("montoAsignado_polizas_"+i).disabled=false;
            document.getElementById("montoAsignado_prima_"+i).disabled=false;
            document.getElementById("montoAsignado_polizas_"+i).value=objeto_json[i].ramo[a].polizas;
            document.getElementById("montoAsignado_prima_"+i).value=objeto_json[i].ramo[a].prima;
            document.getElementById("tipoAsigna_"+i).value="actualizacion";
            document.getElementById("generacion_"+i).value="manual";
            document.getElementById("check_"+i).disabled=false;
            document.getElementById("check_"+i).checked=true;
        } else{
            document.getElementById("montoAsignado_polizas_"+i).disabled=true;
            document.getElementById("montoAsignado_prima_"+i).disabled=true;
            document.getElementById("montoAsignado_polizas_"+i).value=objeto_json[i].ramo[a].polizas;;
            document.getElementById("montoAsignado_prima_"+i).value=objeto_json[i].ramo[a].prima;
            document.getElementById("generacion_"+i).value=objeto_json[i].asignacion;
            document.getElementById("tipoAsigna_"+i).value="actualizacion";
            document.getElementById("check_"+i).disabled=true;
            document.getElementById("check_"+i).checked=true;
        }
    }
}
//console.log(prima);

//var check_list=document.getElementsByName("idPersona[]");

/*for(var a=0; a<check_list.length; a++){

    if(check_list[a].value==agente){
        check_list[a].checked=true;
        check_list[a].disabled=false;

        document.getElementById("montoAsignado_polizas_"+check_list[a].value).disabled=false;
        document.getElementById("montoAsignado_prima_"+check_list[a].value).disabled=false;
        document.getElementById("montoAsignado_polizas_"+check_list[a].value).value=polizas;
        document.getElementById("montoAsignado_prima_"+check_list[a].value).value=prima;
        document.getElementById("allCheck").disabled=true;
        document.getElementById("tipoAsigna_"+check_list[a].value).value="actualizacion";
        document.getElementById("submitOperationRamo").style.display="block";
        document.getElementById("ejecutaOperacion").style.display="block"; //ejecutaOperacion
        document.getElementById("generacion_"+check_list[a].value).value="manual";
        
    } else{
        check_list[a].disabled=true;
        document.getElementById("montoAsignado_polizas_"+check_list[a].value).disabled=true;
        document.getElementById("montoAsignado_prima_"+check_list[a].value).disabled=true;
    }

}*/

/*for(var a=0; a<form.elements.length; a++){

    if(form.elements[a].type=="checkbox" && form.elements[a].value==agente){
        document.getElementById("check_"+agente).disabled=false;
        document.getElementById("check_"+agente).checked=true;
        document.getElementById("montoAsignado_polizas_"+agente).disabled=false;
        document.getElementById("montoAsignado_prima_"+agente).disabled=false;
        document.getElementById("montoAsignado_polizas_"+agente).value=polizas;
        document.getElementById("montoAsignado_prima_"+agente).value=prima;

    } else{
        //document.getElementById("check_"+agente).disabled=true;
    }

}*/

}
//-------------------------------------------------------------
//Método para consulta a Sicas.
function consulta_sicas(){

    //console.log("Hola");

    var tbodyAsig=document.getElementById("cuerpoRegistroRamo");
    var mes_consulta=document.getElementById("mesRamoA").value;
    var ramo_selected=document.getElementById("ramosRes").value;
    var agentes_consulta=new Array();

    //console.log(tbodyAsig.rows[0]);
    for(var i=0; i<tbodyAsig.rows.length; i++){ //Obtener los id de agentes con asignación de metas.

        //console.log(tbodyAsig.rows[i]);
        var id_a=tbodyAsig.rows[i].getAttribute("id_vend");
        agentes_consulta.push(id_a);
    }

    //console.log(agentes_consulta);
    //Petición a AJAX: GET.
    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){

        if(this.readyState<4){
            document.getElementById("cont_img_carga").style.display="block";
        }

        if(this.readyState==4 && this.status==200){

            var resp=JSON.parse(this.responseText);
            console.log(resp);

            var tbody_recurrido=document.getElementById("cuerpoRegistroRamo");

            //console.log(tbody_recurrido.rows[0]);

            if(resp.mensaje==""){

                alert("Resultado obtenido");

                document.getElementById("cont_img_carga").style.display="none";

                var personal=resp.personal_consultado;

                for(var a in personal){

                    //document.getElementById(a+"_"+)
                    //console.log(personal[a]);

                    for(var b in personal[a]){
                        //console.log(personal[a][b]);

                        if(b!="_cantidad_prima" && b=="cantidad_prima"){
                            document.getElementById(a+"_"+b).innerHTML=`$ `+personal[a][b]; 
                        } else if(b!="_cantidad_prima" && b=="cantidad_polizas"){
                            document.getElementById(a+"_"+b).innerHTML=personal[a][b];
                        }

                        //(b=="cantidad_prima") ? personal[a][b] : personal[a][b]; //personal[a][b];

                        for(var s=0; s<tbody_recurrido.rows.length; s++){

                            //var celda=tbody_recirrido.rows[s].cells;
                            if(tbody_recurrido.rows[s].getAttribute("id_vend")==a){

                                //Validación de cantidad de polizas
                                if(parseInt(tbody_recurrido.rows[s].cells[3].innerHTML) > parseInt(personal[a].cantidad_polizas)){

                                   document.getElementById(a+"_cantidad_polizas").classList.add("text-danger");
                                   console.log("entro1");
                                    //console.log(tbody_recurrido.rows[s][3]);
                                } else{
                                    if(document.getElementById(a+"_cantidad_polizas").classList.contains("text-danger")){
                                        document.getElementById(a+"_cantidad_polizas").classList.replace("text-danger","text-success");
                                    } else{
                                        document.getElementById(a+"_cantidad_polizas").classList.add("text-success");
                                    }
                                }
                                //Validación de primas
                                if(parseFloat(tbody_recurrido.rows[s].cells[4].innerHTML)>parseFloat(personal[a]._cantidad_prima)){

                                    document.getElementById(a+"_cantidad_prima").classList.add("text-danger");
                                    //console.log("entro");
                                    //console.log(tbody_recurrido.rows[s][3]);
                                } else{
                                    if(document.getElementById(a+"_cantidad_prima").classList.contains("text-danger")){
                                        document.getElementById(a+"_cantidad_prima").classList.replace("text-danger","text-success");
                                    } else{
                                        document.getElementById(a+"_cantidad_prima").classList.add("text-success");
                                    }
                                }
                            }
                        }
                    }
                }

            } else{
                alert(resp.mensaje);
                document.getElementById("cont_img_carga").style.display="none";
            }

        }
    }
    xmlhttp.open("GET", direccion+"/consultaSicasVentasNuevas?q="+mes_consulta+"&r="+agentes_consulta+"&p="+ramo_selected, true);
    xmlhttp.send();

}

document.getElementById("btn_consulta_Sicas").addEventListener("click", consulta_sicas);
//-------------------------------------------------------------
function muestra_contenido(tipo){

    console.log(tipo)

    if(tipo=="ver"){
        document.getElementById("contenedor_panel_agentes").style.display="none";
        document.getElementById("contenedor_panel_asignados").style.display="block";
        document.getElementById("ejecutaOperacion").style.display="none";
        document.getElementById("contendor_envio_correos").style.display="none";
        document.getElementById("contMes").style.display="block";
    } else if(tipo=="correo"){
        document.getElementById("contenedor_panel_agentes").style.display="none";
        document.getElementById("contenedor_panel_asignados").style.display="none";
        document.getElementById("contendor_envio_correos").style.display="block";
        document.getElementById("contMes").style.display="none";

    } else{
        document.getElementById("contenedor_panel_agentes").style.display="block";
        document.getElementById("contenedor_panel_asignados").style.display="none";
        document.getElementById("contendor_envio_correos").style.display="none";
        document.getElementById("contMes").style.display="block";
        //ejecutaOperacion
        document.getElementById("ejecutaOperacion").style.display="block";
    }
}
//-------------------------------------------------------------
function enviaNotificaciones(e){

    e.preventDefault();

    var tbody=document.getElementById("contenedor_correos_para_envio");
    var send1=new Array();

    for(var i=0; i<tbody.rows.length; i++){

        send1.push(tbody.rows[i].getAttribute("id_persona"));

    }

    console.log(send1);
    //-----------------------------
    //Petición AJAX: GET
    var xmla=new XMLHttpRequest();

    xmla.onreadystatechange=function(){

        if(this.readyState<4){
            document.getElementById("cont_img_carga").style.display="block";
        }

        if(this.readyState==4 && this.status==200){
            
            document.getElementById("cont_img_carga").style.display="none";

            alert("Se ha realizado los envíos");

            var resp=JSON.parse(this.responseText)
            console.log(resp);

            for(var id in resp){
                var col_result=document.getElementById("td_confirma_envio_"+id);
                col_result.innerHTML=``;

                if(resp){
                    col_result.innerHTML+=`<i class="fa fa-check" aria-hidden="true"></i>&nbspEnviado`;
                    col_result.classList.add("text-success");
                } else{
                    col_result.innerHTML+=`<i class="fa fa-times" aria-hidden="true"></i>&nbspNo enviado`;
                    col_result.classList.add("text-danger");
                }
            }
        }
    }
    
    xmla.open("GET",direccion+"/notificarAsignacionDeMetas?q="+send1,true);
    xmla.send();
    //-----------------------------


}

document.getElementById("btn_send_mails").addEventListener("click",enviaNotificaciones);
//-------------------------------------------------------------
//-------------------------------------------------------------