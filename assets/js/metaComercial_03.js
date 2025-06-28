//console.log("Hola");

var selectMCA=document.getElementById("listaActividades");
var selectCoordinacion=document.getElementById("coordinacionId");
var contenedorMA=document.getElementById("contenidoMF");
var entradaMonto=document.getElementById("cantidadAnual");
var botonSubmit=document.getElementById("btnSubmit");
var botonSubmitMensual=document.getElementById("submitMontoMensual");
var contenedorAsignados=document.getElementById("contAsignados");
var contenedorAsignadosRamos=document.getElementById("contAsignadosRamos");
var idMetaC=document.getElementById("idMetaC");
var ultimoId=0;
var contenedorPrima=document.getElementById("contenedor_asignacion_prima"); //metaPC

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

selectMCA.addEventListener("change",function(){

    if(selectMCA.value=="metaCA"){

        contenedorMA.style.display="inline-block";
        contenedorAsignados.style.display="none";
        contenedorPrima.style.display="none";
        contenedorAsignadosRamos.style.display="none";
        selectCoordinacion.value=0;
        entradaMonto.value="";
        idMetaC.value=0;
    } else if(selectMCA.value=="listAsigna"){

        //console.log("aqui");

        contenedorAsignados.style.display="inline-block";
        contenedorMA.style.display="none";
        contenedorPrima.style.display="none";
        contenedorAsignadosRamos.style.display="none";
    }
    else if(selectMCA.value=="metaPC"){

        //console.log("aqui");

        contenedorPrima.style.display="inline-block";
        contenedorMA.style.display="none";
        contenedorAsignados.style.display="none";
        contenedorAsignadosRamos.style.display="none";

    } else if(selectMCA.value=="listAsignaRamos"){
        contenedorAsignadosRamos.style.display="inline-block";
        contenedorMA.style.display="none";
        contenedorAsignados.style.display="none";
        contenedorPrima.style.display="none";
    }
});

console.log(window.location.href);
var direccion=window.location.href;
//--------------------------------------------------------------------------------
//ID: cantidadAnual

var input_monto_anual=document.getElementById("cantidadAnual");
input_monto_anual.addEventListener("keyup", function(e){

    //document.getElementById("monto_en_miles").innerHTML=e.target.value.replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ","); //Intl.NumberFormat().format(e.target.value); //e.target.value;
    document.getElementById("monto_en_miles").innerHTML=Intl.NumberFormat().format(e.target.value); //e.target.value;
    //replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");

});
//--------------------------------------------------------------------------------
function enviaMetaComercial() {
    
    var xmlhhtp=new XMLHttpRequest();
    var tipo_meta=document.querySelector("input[name='tipo_meta']:checked").value;
    /*var mensual={};
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
    mensual[12]="DICIEMBRE";*/
    
    var mes=[1,2,3,4,5,6,7,8,9,10,11,12];

    console.log(tipo_meta);

    if(selectCoordinacion.value==0 || entradaMonto.value==0){
        alert("No se seleccionó a un coordinador o no se asignó una cantidad");
    } else{
        //console.log("aqui");
        xmlhhtp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                console.log(JSON.parse(this.responseText));
                console.log(JSON.parse(this.responseText).length);
                //console.log("hola");
                //console.log(this.responseText);

                //alert("Meta global asignado, favor de asignar montos mensuales en la parte de abajo");

                resp=JSON.parse(this.responseText);

                if(resp.length>0 && idMetaC.value==0){

                    alert("Meta global asignado, favor de asignar montos mensuales en la parte de abajo");

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
                } else if((resp.length>0 || resp.length==0) && idMetaC.value>0){

                    alert("Meta global asignado, favor de asignar montos mensuales en la parte de abajo");
                    
                    ultimoId=idMetaC.value

                    document.getElementById("conttablaMensual").style.display="inline-block";
                    document.getElementById("metaAsig").innerHTML="Meta anual asignado: $"+new Intl.NumberFormat().format(entradaMonto.value)+" MXN";
        
                    var contenedorTabla=document.getElementById("cuerpoMM");
    
                    contenedorTabla.innerHTML="";

                    var respuesta=JSON.parse(this.responseText);

                    var valida=[];

                    for(var i=0; i<mes.length; i++){

                        if(respuesta.length>0){

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
                        //
                        } else{
                            contenedorTabla.innerHTML+=`
                                        <tr>
                                            <td>`+mensual[mes[i]]+`</td>
                                            <td class="text-left"><input type="number" name="`+mes[i]+`" class="form-control" id="mes_`+mes[i]+`" required></td>
                                        </tr>
                                    `;
                        }
                    }
                } else if(resp.length==0){
                    alert("La asignación al coordinador ya esta registrado, si desea cambiar el monto del coordinador por favor seleccione la opcion: Ver lista de asignados");
                }
            }
        }
    
        //xmlhhtp.open("POST",direccion+"almacenaMetaComercial",true);
        //xmlhhtp.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' ); 
        xmlhhtp.open("GET",direccion+"/almacenaMetaComercial?q="+selectCoordinacion.value+"&r="+entradaMonto.value+"&p="+idMetaC.value+"&a="+tipo_meta, true);
        xmlhhtp.send();
    }    
}
//-------------------------------------------------------------------------------------------------
function enviaMontosMensuales(e){

    e.preventDefault();

    var tipo_meta=document.querySelector("input[name='tipo_meta']:checked").value;

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

        xmlhttp.open("GET",direccion+"almacenaMontosMensuales?q="+ultimoId+"&r="+JSON.stringify(datos)+"&p="+idMetaC.value+"&a="+tipo_meta,true);
        xmlhttp.send();
    }
    
}
//-------------------------------------------------------------------------------------------------------------
function eliminaMeta(idMeta, band){

    var xmlhttp=new XMLHttpRequest();
    var fila= band == 1 ? document.getElementById("fila_"+idMeta) : document.getElementById("fila_it_"+idMeta);

    console.log(fila);
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

                        //var fila= band == 1 ? document.getElementById("fila_"+idMeta) : document.getElementById("fila_it_"+idMeta);
                        fila.style.display="none";
                        
                    }
                }
            }
        }

        xmlhttp.open("GET", direccion+"eliminaMetaAsignado?q="+idMeta+"&r="+band,true);
        xmlhttp.send();
    }
}
//-----------------------------------------------------------------------------------
function actualizaMeta(idPersona,montoAnual,idMeta, band){
    
    contenedorMA.style.display="block";
    contenedorAsignados.style.display="none";

    selectCoordinacion.value=idPersona;
    entradaMonto.value=montoAnual;
    idMetaC.value=idMeta;

    if(band == 1){
        document.getElementById("r_meta_vn").checked=true;
        document.getElementById("r_meta_it").disabled=true;
    } else{
        document.getElementById("r_meta_it").checked=true;
        document.getElementById("r_meta_vn").disabled=true;
    }

    botonSubmit.innerHTML="Actualizar meta comercial";

}
//-----------------------------------------------------------------------------------
botonSubmit.addEventListener("click",enviaMetaComercial);
botonSubmitMensual.addEventListener("click",enviaMontosMensuales);
//-----------------------------------------------------------------------------------

var contenedor_personal=document.getElementById("contenedor_personal");
var selectCoorPrima=document.getElementById("coor_asigna_prima");

function rellena_contenedor_personal(){

    var idPersona=selectCoorPrima.value;
    var nombreCorreo= selectCoorPrima.options[selectCoorPrima.selectedIndex].text; //selectCoorPrima.text;

    //Crear elementos y adjuntarlos.
    var tbody=document.getElementById("lista_pp");
    var table_contenedor=document.getElementById("tabla_contenedor_p");

    var validador=new Array();

    for(var i=0; i<table_contenedor.rows.length; i++){

        var identificador_fila=table_contenedor.rows[i];
        var id_persona_fila=identificador_fila.getAttribute("id_persona_fila");

        if(i>0){
            validador.push(id_persona_fila);
        }
    }

    console.log(validador);

    if(validador.includes(idPersona)){
        alert("La cuenta se encentra en la lista");
    } else{
        
        var filaT=document.createElement("tr");
        var id_fila=document.createAttribute("id_persona_fila");
        id_fila.value=idPersona;
        filaT.setAttributeNode(id_fila);

        var columnaCheck=document.createElement("td");
        var columnaCorreo=document.createElement("td");
        var columnaEliminar=document.createElement("td");

        var ahref=document.createElement("a");
        ahref.href="javascript: void(0)";
        ahref.textContent="X";

        var id_ahref=document.createAttribute("id");
        id_ahref.value="e_"+idPersona;

        ahref.setAttributeNode(id_ahref);

        ahref.onclick=function(){
            console.log("click ejecutado");
            //console.log(ahref.parentNode);
            var td_coor=ahref.parentNode;
            var row_coor=td_coor.parentNode;
            var table_coor=row_coor.parentNode;

            table_coor.removeChild(row_coor);
        };

        columnaCorreo.textContent=nombreCorreo;
        //columnaEliminar.textContent

        var checkb=document.createElement("input");
        checkb.type="checkbox";
        checkb.name="coor_selected[]";
        checkb.value=idPersona;
        checkb.checked=true;
        checkb.disabled=true;

        columnaCheck.appendChild(checkb);
        columnaEliminar.appendChild(ahref);
                
        filaT.appendChild(columnaCheck); //+columnaCorreo+columnaEliminar
        filaT.appendChild(columnaCorreo);
        filaT.appendChild(columnaEliminar);
        tbody.appendChild(filaT);
    }
}

//rellena_contenedor_personal
selectCoorPrima.addEventListener("change",rellena_contenedor_personal);

//----------------------------------------------------------------------
function asigna_meta_por_ramo(e){

    e.preventDefault(); 

    //formulario=document.getElementById("formulario_asigna_meta");
    var ramos=["autos","vida","gmm","danios","fianzas"];
    var coor_asignados=document.getElementsByName("coor_selected[]");
    var mes_dom=document.getElementById("mes_asignado");
    var mes_selecionado=mes_dom.options[mes_dom.selectedIndex].value;

    if(coor_asignados.length==0){
        alert("Debe seleccionar minimo a un coordinador");
        return false;
    } else if(mes_selecionado==0){
        alert("Debe seleccionar un mes");
        return false;
    }

    var agentes=crear_array_envio(coor_asignados);
    var datos_asignados=crear_objeto_envio(ramos);
    var send_data={};

    for(var i=0; i<agentes.length; i++){
        
        send_data[agentes[i]]={
            [mes_selecionado]://{
                datos_asignados
            //}
        }
    }

    console.log(coor_asignados.length);

    //---------------------------------------
    //Envio de solicitud por AJAX

    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            console.log(JSON.parse(this.responseText));
            var resp=JSON.parse(this.responseText);
            alert(resp.mensaje);
            //window.href.reload();
            
            if(confirm("¿Concluyó con la asignación de metas?")){
                document.location.reload();
            }
        }
    };

    xmlhttp.open("POST", direccion+"inserta_meta_por_ramo",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("send="+JSON.stringify(send_data));
    //---------------------------------------
}
//----------------------------------------------------------------------
function crear_array_envio(dom_element){

    var recabado=[];
    //var recabado={};

    for(var i=0; i<dom_element.length; i++){

        //if(dom_element[i].type=="checkbox" && dom_element[i].checked){

            //recabado["coordinador"]=dom_element[i].value;
            recabado.push(dom_element[i].value);
        //} else {

        //}

    }

    return recabado;
}
//-------------------------------------------------------------------
function crear_objeto_envio(array_data){

    var info_contenedor={};

    for(var i=0; i<array_data.length; i++){

        var recabado={};
        recabado["prima"]=document.getElementById(array_data[i]+"_prima").value;
        recabado["cantidad_polizas"]=document.getElementById(array_data[i]+"_polizas").value;

        info_contenedor[array_data[i]]=recabado;
    }

    return info_contenedor;

}
//-------------------------------------------------------------------
var submit_info_ramos=document.getElementById("boton_envia_ramos");

submit_info_ramos.addEventListener("click",asigna_meta_por_ramo);

//----------------------------------------------------------------------
function busquedaAgentesRamo(){
    
    //console.log(this.getAttribute("tipo_asig"));
    //var tipo_asig=document.querySelector(".tipo_asignacion"); //document.getElementsByClassName("tipo_asignacion"); //this.getAttribute("tipo_asig");
    var tipo_asig=document.getElementsByClassName("tipo_asignacion");
    var b;
    for(var a=0; a<tipo_asig.length; a++){  

        if(tipo_asig[a].parentNode.classList.contains("active")){
            //b.push(tipo_asig[a].getAttribute("tipo_asig"));
            b=tipo_asig[a].getAttribute("tipo_asig");
        }
    }

    var mes_busqueda=document.getElementById("mes_busqueda").value;

    //-------------------------------------------------
    //Llamada al AJAX: GET

    var xmlhhtp=new XMLHttpRequest();

    xmlhhtp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            console.log(JSON.parse(this.responseText));
            var resultado=JSON.parse(this.responseText);
            if(resultado.mensaje==""){

                var contenedor_info=document.getElementById(b+"_contenedor");

                contenedor_info.innerHTML=``;

                for(r in resultado){

                    if(r!="mensaje"){
                        
                        var obj_json={};

                        for(var rn in resultado[r].Ramos){
                            
                            obj_json[r]=resultado[r].Ramos;
                        }

                        document.getElementById("sicas_consult_"+b).innerHTML=`
                        <p id="nombre_consulta_`+b+`"></p>
                        <label>
                            <button id="btn_modal_`+b+`" type="button" class="boton_modal_sicas btn btn-info btn-xs" data-toggle="modal" data-target="#modal_ramos" id_modal="`+r+`" style="display: none"">
                                Ver resultado Sicas
                            </button>
                        </label><br>`;

                        contenedor_info.innerHTML+=`
                            <tr id="td_ramo_`+r+`" id_coor="`+r+`">
                                <td>`+resultado[r].Nombre+`</td>
                                <td>`+resultado[r].Correo+`</td>
                                <td id="autos">`+resultado[r].Ramos.autos+`</td>
                                <td id="vida">`+resultado[r].Ramos.vida+`</td>
                                <td id="danios">`+resultado[r].Ramos.danios+`</td>
                                <td id="gmm">`+resultado[r].Ramos.gmm+`</td>
                                <td id="fianzas">`+resultado[r].Ramos.fianzas+`</td>
                                <!--<td class="sicas_result" style="display:none">
                                    <button type="button" class="boton_modal_sicas btn btn-info btn-xs" data-toggle="modal" data-target="#modal_ramos" id_modal="`+r+`" style="display:none">
                                    Ver resultado Sicas
                                    </button>
                                </td>-->
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-default btn-xs dropdown-toggle " type="button" id="opciones_`+r+`" data-toggle="dropdown" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            <!--<span class="caret"></span>-->
                                        </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="opciones_`+r+`">
                                                <li role="presentation" class="text-warning"><a role="menuitem"  tabindex="-1" href="javascript: void(0);" onclick="consultaASicas(`+r+`,`+(document.getElementsByClassName("opcion_select")[0].classList.contains("active") ? 1 : 2)+`); return false;")>Consultar a Sicas</a></li>
                                                <li role="presentation" class="text-warning"><a class="meta_automatica" role="menuitem"  tabindex="-1" href="javascript: void(0);" data-toggle="modal" data-backdrop="" data-tipo="`+b+`" data-target="#modal_ramos" data-id="`+r+`" data-mes="`+resultado[r].Mes+`" onclick="creaMetaAgentes(this)">Asignar autómaticamente</a></li>
                                                <li role="presentation" class="divider"></li>
                                                <li role="presentation" class="text-warning"><a role="menuitem"  tabindex="-1" href="javascript: void(0);" onclick=actualizarRegistroEnRamo(`+resultado[r].Mes+`,"`+b+`","`+JSON.stringify(obj_json).replace(/"/g, "'")+`")>Modificar</a></li>
                                                <li role="presentation" class="text-danger"><a role="menuitem"  tabindex="-1" href="javascript: void(0);" onclick=eliminarRegistroEnRamo(`+r+`,`+resultado[r].Mes+`)>Eliminar</a></li>
                                            </ul>
                                    </div>
                                </td>
                                <!--<td>
                                    <button class="btn btn-warning btn-xs" onclick=actualizarRegistroEnRamo(`+resultado[r].Mes+`,"`+b+`","`+JSON.stringify(obj_json).replace(/"/g, "'")+`")>Modificar</button>
                                    <button class="btn btn-danger btn-xs" onclick=eliminarRegistroEnRamo(`+r+`,`+resultado[r].Mes+`)>Eliminar</button>
                                </td>-->
                            </tr>
                        `
                    }
                }

            }else{
                alert(resultado.mensaje);
            }

        }
    }

    xmlhhtp.open("GET", direccion+"obtenerAgentesYRamos?q="+b+"&r="+mes_busqueda,true);
    xmlhhtp.send();

}
//----------------------------------------------------------------------
var a_tipo_polizas=document.getElementById("btn_busqueda");

a_tipo_polizas.addEventListener("click", busquedaAgentesRamo);
//----------------------------------------------------------------------
function eliminarRegistroEnRamo(asignado,mes){

    //--------------------
    //Llamada al AJAX

    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var r=JSON.parse(this.responseText);

            alert(r.mensaje);
            window.location.reload();

        }
    }
    xmlhttp.open("GET",direccion+"eliminarRegistroRamo?q="+asignado+"&r="+mes);
    xmlhttp.send();
}
//----------------------------------------------------------------------
function actualizarRegistroEnRamo(mes,tipo_polizas,info){

    //console.log(info);
    //var tipo_asig=document.getElementsByClassName("tipo_asignacion");
    var update_info=JSON.parse(info.replace(/'/g, '"'));

    document.getElementById("mes_asignado").value=mes;

    var ram={};

    for(var i in update_info){

        //console.log(i);
        document.getElementById("lista_pp").innerHTML="";
        document.getElementById("coor_asigna_prima").value=i;
        document.getElementById("coor_asigna_prima").disabled=true;
        document.getElementById("coor_asigna_prima").onclick=rellena_contenedor_personal();
        document.getElementById("e_"+i).style.pointerEvents="none";

        var tipo_asig=document.getElementsByClassName("tipo_asignacion");

        for(var a=0; a<tipo_asig.length; a++){
            if(tipo_asig[a].getAttribute("tipo_asig")==tipo_polizas){
                tipo_asig[a].parentNode.classList.add("active");
                console.log(tipo_asig[a].parentNode);
            }else{
                tipo_asig[a].parentNode.classList.replace("active","disabled");
            }
        }

        for(var b in update_info[i]){

            if(tipo_polizas=="cantidad_polizas"){
                document.getElementById(b+"_polizas").value=update_info[i][b];
                //ram[b]=update_info[i][b]
            } else{
                document.getElementById(b+"_prima").value=update_info[i][b].replace(",","");
            }
        }

        /**/

    }

    document.getElementById("contenedor_asignacion_prima").style.display="inline-block";
    document.getElementById("contAsignadosRamos").style.display="none";
    document.getElementById("boton_envia_ramos").innerHTML=`<i class="fa fa-paper-plane" aria-hidden="true"></i>&nbspReasginar meta comercial`;
    document.getElementById("boton_envia_ramos").removeEventListener("click", asigna_meta_por_ramo);
    document.getElementById("boton_envia_ramos").onclick=function(e){
        
        e.preventDefault();

        if(document.getElementById("mes_asignado").selectedIndex==0){
            alert("No se selecciono un mes");
            return false;
        }

        var idPersona=document.getElementsByName("coor_selected[]")[0].value;
        //Coleccion de datos para envio: update.

        var object_send={};
        object_send[idPersona]={
            "tipo_act": tipo_polizas,
            "mes_ant":mes,
            "mes_act": document.getElementById("mes_asignado").selectedIndex,
            "ramos":{
                "autos": (tipo_polizas=="cantidad_polizas") ? document.getElementById("autos_polizas").value :  document.getElementById("autos_prima").value,
                "danios": (tipo_polizas=="cantidad_polizas") ? document.getElementById("danios_polizas").value :  document.getElementById("danios_prima").value,
                "vida": (tipo_polizas=="cantidad_polizas") ? document.getElementById("vida_polizas").value :  document.getElementById("vida_prima").value,
                "gmm": (tipo_polizas=="cantidad_polizas") ? document.getElementById("gmm_polizas").value :  document.getElementById("gmm_prima").value,
                "fianzas": (tipo_polizas=="cantidad_polizas") ? document.getElementById("fianzas_polizas").value :  document.getElementById("fianzas_prima").value,
            }
        }

        console.log(object_send);

        //-------------------------------------
        //Llamada al AJAX: POST

        var xmlh= new XMLHttpRequest();

        xmlh.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200) {

                var re=JSON.parse(this.responseText);

                console.log(re);
                alert(re.mensaje);
                if(re.bool){
                    window.location.reload();
                }
            }
        }

        xmlh.open("POST", direccion+"/actualizarRegistroRamo", true);
        xmlh.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlh.send("send="+JSON.stringify(object_send));

        //-------------------------------------
    }
    //document.getElementById("coor_asigna_prima").value=
}
//----------------------------------------------------------------------
function consultaASicas(coor,tipo_request){

    var mes_seleccionado=document.getElementById("mes_busqueda").value;

    //Petición AJAX: GET.
    var xml=new XMLHttpRequest();

    xml.onreadystatechange=function(){

        if(this.readyState<4){
            document.getElementById("cont_img_carga").style.display="block";
            document.getElementById("contAsignadosRamos").style.position="absoute";
        }

        if(this.readyState==4 && this.status==200){

            document.getElementById("cont_img_carga").style.display="none";

            var resp=JSON.parse(this.responseText);
            console.log(resp);

            var diferent=new Array();

            var body_modal=document.getElementById("cuerpo_modal_ramos");
            body_modal.innerHTML=``;

            if(resp.mensaje!=""){
                alert(resp.mensaje);
            } else{
                
                var celda_sicas=document.getElementsByClassName("sicas_result")//[0].style.display="table-cell";
                var boton_modal=document.getElementsByClassName("boton_modal_sicas"); //btn_modal
                var fila_coor=document.getElementById("td_ramo_"+coor);

                var hoy=new Date();
                var resultados=``;
                resultados+=`<div style="width: 100%; border: 1px #D5D8DC solid; padding: 10px 10px 0px 10px; border-radius: 10px">
                    <p><small style="color: #ABB2B9" class="text-right"><i class="fa fa-calendar" aria-hidden="true"></i> Fecha de consulta a Sicas: `+hoy.getDate()+`-`+(hoy.getMonth()+1)+`-`+hoy.getFullYear()+` `+hoy.getHours()+`:`+hoy.getMinutes()+`:`+hoy.getSeconds()+`</small></p>
                    <div style="border: 1px #ABB2B9 solid; padding: 10px 10px 10px 10px; border-radius: 5px">
                        <p style="font-family: helvetica;"><i class="fa fa-info" aria-hidden="true"></i>&nbspInformación de avance de metas consultado en Sicas del mes: <spam style="font-weight: bold; color: #2C3E50">`+mensual[mes_seleccionado].toUpperCase()+`</spam>.</p>
                        <p style="font-family: helvetica"><i class="fa fa-info" aria-hidden="true"></i>&nbspConsulta para <spam style="font-weight: bold; color: #2C3E50">`+fila_coor.cells[0].innerHTML+`(`+fila_coor.cells[1].innerHTML+`)</spam>.</p>
                    `;
                    

                //console.log(fila_coor.cells[1]);
                var cont_t_a=0;
                var cont_t_sicas=0;

                var check_t=`<i class="fa fa-check" aria-hidden="true"></i>`;
                var check_f=`<i class="fa fa-times" aria-hidden="true"></i>`;

                var json_resultado=resp.resultado;

                for(var x in json_resultado){

                    var cuerpo_tabla=document.getElementById(x+"_contenedor");

                    resultados+=`<p><i class="fa fa-lightbulb-o text-warning" aria-hidden="true"></i>&nbspResultado Sicas en: <spam style="font-weight: bold; color: #2C3E50">`+x.replace("_"," de ")+`</spam>.</p></div><br>`;

                    for(var n in json_resultado[x]){

                        for(var r=0; r<cuerpo_tabla.rows.length; r++){

                            if(cuerpo_tabla.rows[r].getAttribute("id_coor")==coor){
                                //console.log("entro");

                                var tr_coor=cuerpo_tabla.rows[r];

                                for(p=0; p<tr_coor.cells.length; p++){

                                    document.getElementById("nombre_consulta_"+x).innerHTML=`Resultado de `+tr_coor.cells[0].innerHTML+`&nbsp&nbsp&nbsp`;
                                    document.getElementById("btn_modal_"+x).style.display="block";

                                    if(tr_coor.cells[p].getAttribute("id")==n){
                                        console.log("entro_celda");

                                        cont_t_a+=parseFloat(tr_coor.cells[p].innerHTML.replace(",",""));
                                        cont_t_sicas+=parseFloat(json_resultado[x][n]);

                                        resultados+=`
                                            <div style="width: 100%; border: 1px #ABB2B9 solid; border-top: 5px solid #BB8FCE;">
                                                <div><p style="margin-top: 10px" class="text-center"><i class="fa fa-cube" aria-hidden="true"></i>&nbspRamo en <spam style="color: #3498DB"> `+n.replace("danios", "daños").toUpperCase()+`</spam></p></div>
                                                <table class="table">
                                                    <tbody>
                                                        <tr class="text-center">
                                                            <td><i class="fa fa-certificate" aria-hidden="true"></i>&nbspValor asignado</td>
                                                            <td><i class="fa fa-dot-circle-o" aria-hidden="true"></i>&nbspResultado de Sicas</td>
                                                            <td>¿Superó la meta?</td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <td>`+tr_coor.cells[p].innerHTML+`</td>
                                                            <td>`+new Intl.NumberFormat().format(json_resultado[x][n])+`</td>
                                                            <td>`+(parseFloat(json_resultado[x][n]) >= parseFloat(tr_coor.cells[p].innerHTML) ? "<spam class='text-success'>"+check_t+" Superado</spam>" : "<spam class='text-danger'>"+check_f+" No superado</spam>")+`</td>                                                
                                                        </tr>
                                                     </tbody>
                                                </table>
                                            </div><br>
                                        `;
                                    }
                                }
                            }
                        }
                    }
                    resultados+=`
                        <hr>
                        <table class="table">
                            <tr class="text-center">
                                <td>Total asignado</td>
                                <td>Total generado</td>
                                <td>¿Superó la meta?</td>
                            </tr>
                            <tr class="text-center">
                                <td>`+new Intl.NumberFormat().format(cont_t_a)+`</td>
                                <td>`+new Intl.NumberFormat().format(cont_t_sicas)+`</td>
                                <td>`+(cont_t_sicas >= cont_t_a ? "<spam class='text-success'>"+check_t+" Superado</spam>" : "<spam class='text-danger'>"+check_f+" No superado</spam>")+`</td>
                            </tr>
                        </table>
                    `;
                }

                body_modal.innerHTML+=resultados+`</div>`;
            }
        }
    }

    xml.open("GET", direccion+"consultaAvanceSicasCoor?q="+coor+"&r="+mes_seleccionado+"&p="+tipo_request, true);
    xml.send();
    
    console.log("adios mundo");
}
//------------------------------------------------------------------------------------
//Uso de js de boostrap para los tabs
$('#tabs_metas a').click(function (e) {
    e.preventDefault()
    //$(this).tab('show')
    //$(this).removeClass("show");
    var idd=$(this).attr("aria-controls");

    $("#"+idd).removeClass("show");

    //console.log(idd);
});
//------------------------------------------------------------------------------------
function editaMetaMensual(persona,meta,bandera){

    var xmlhttp = new XMLHttpRequest();

    var cuerpo_modal=document.getElementById("cuerpo_modal_ramos");
    cuerpo_modal.innerHTML="";

    xmlhttp.onreadystatechange=function(){
        if(this.status==200 && this.readyState == 4){

            var res = JSON.parse(this.responseText);
            console.log(res);

            if(res.mensaje !== ""){
                alert(res.mensaje);
            } else{

                cuerpo_modal.innerHTML+=`
                <h4>Resultado de metas</h4>
                <h4>Meta anual: $`+parseInt(res.metaTotal).toLocaleString()+` MXN</h4>
                <input type="hidden" class="meta_total" value="`+res.metaTotal+`">`;

                for(var i in res.mensualidades){

                    cuerpo_modal.innerHTML+=`
                        <!--<div style="border: 1px red solid">-->
                            <div class="panel panel-default col-md-4 p_`+res.idMeta+`_`+i+`">
                                <div class="panel-heading">`+mensual[i]+`</div>
                                <div class="panel-body">
                                    <input type="number" class="form-control input-sm valor_meta_mensual" value="`+parseInt(res.mensualidades[i])+`" id="`+res.idMeta+`_`+i+`"><br>
                                    <button class="btn btn-info btn-xs" onclick="modificaMetaMensual('`+i+`','`+res.idMeta+`','`+bandera+`','`+persona+`')">Reasignar meta</button>
                                </div>
                            </div>
                        <!--</div>-->
                    `;
                }
            }
        }
    }
    xmlhttp.open("GET", direccion+"devuelveMetasMensuales?q="+meta+"&r="+persona+"&a="+bandera,true);
    xmlhttp.send();

}
//-------------------------------------------------------------------------------------
function modificaMetaMensual(mes,meta,bandera,persona){

    var monto = document.getElementById(meta+"_"+mes);
    //var tipo_meta=document.querySelector("input[name='tipo_meta']:checked").value;
    var metaAnual = parseInt(document.getElementsByClassName("meta_total")[0].value);
    var send_data_ = {};

    var panel = document.getElementsByClassName("p_"+meta+"_"+mes)[0];

    send_data_["idMeta"]=meta;
    send_data_["mes"]=mes;
    send_data_["monto"]=monto.value;
    send_data_["bandera"]=bandera;

    var entradas_de_monto = document.getElementsByClassName("valor_meta_mensual");
    var sumatoria=0;

    for(var a = 0; a < entradas_de_monto.length; a++){

        sumatoria+=parseInt(entradas_de_monto[a].value);

    }

    console.log(metaAnual);
    console.log(sumatoria);

    if(sumatoria > metaAnual){
        alert("Se superó la meta anual");
        return false;
    }

    //------------------------
    //AJAX: POST
    var xmlhhtp = new XMLHttpRequest();

    xmlhhtp.onreadystatechange=function(){
        if(this.readyState == 4 && this.status == 200){

            var res = JSON.parse(this.responseText);

            if(res.mensaje != ""){
                alert(res.mensaje);
            } else{
                
                //console.log(panel.firstChild.nextSibling);
                panel.classList.replace("panel-default", "panel-success");
            }
        }
    }
    //xmlhhtp.open("GET", direccion+"actualizaMetaMensual?a="+meta,true);
    xmlhhtp.open("POST", direccion+"actualizaMetaMensual", true);
    xmlhhtp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhhtp.send("send="+JSON.stringify(send_data_));
    //xmlhhtp.send();

    //------------------------
    //console.log(monto);
}
//--------------------------------------------------------
function creaMetaAgentes(e){
    
    //e.preventDefault();
    //e.stopPropagation();

    var xmlhttp = new XMLHttpRequest();

    var send_object = {};

    send_object["id"] = e.getAttribute("data-id");
    send_object["mes"] = e.getAttribute("data-mes");
    send_object["tipo"] = e.getAttribute("data-tipo");
    send_object["ramos"] = [
        {
            ramo: "autos",
            //valor:  e.getAttribute("data-autos")
        },
        {
            ramo: "gmm",
            //valor:  e.getAttribute("data-gmm")
        }
    ];  
    //Petición AJAX: POST.
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            var res = JSON.parse(this.responseText);

            console.log(res);
            document.getElementById("myModalLabel").innerHTML="Resultado de asignación autómatica";

            var modal_response = `<div class="table-response">`;

            for(var a in res){
                modal_response += `
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>EMAIL</th>
                                <th>RANKING</th>
                                <th>RAMO</th>
                                <th>COMPLETADO</th>
                            </tr>
                        </thead>
                        <tbody>`;

                        res[a].map((arr_, i) => {
                            
                            modal_response += `
                                <tr>
                                    <td>`+arr_.nombre_completo+`</td>
                                    <td>`+arr_.correo+`</td>
                                    <td>`+arr_.ranking+`</td>
                                    <td>`+arr_.ramo.toUpperCase()+`</td>
                                    <td>`+(arr_.insert ? "ASIGNADO" : "NO ASIGNADO")+`</td>
                                </tr>
                            `;
                        });

                        modal_response += `</tbody>
                    </table>
                `;
            }

            document.getElementById("cuerpo_modal_ramos").innerHTML = modal_response;
        }
    }

    console.log(send_object);

    xmlhttp.open("POST", direccion+"asignaMetaAgenteAutomatico", true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("sendData="+JSON.stringify(send_object));
}

//--------------------------------------------------------
//document.getElementById("consultar_a_sicas").addEventListener("click",consultaSicas);
//----------------------------------------------------------------------
/*if(selectCoordinacion.value==0){
    console.log(selectCoordinacion.value);
}*/