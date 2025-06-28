
var direccion=window.location.href;

$(function(){
    console.log("carga de js");
});

function consultaContactoDelCliente(ElementHTML){

    var cliente_id=ElementHTML.getAttribute("id_cliente");
  
//**    console.log(direccion);
	
//**	console.log(cliente_id);

    //var seccion_notas=document.getElementById("notas_up");
    //seccion_notas.style.display="none";
    
    //Petición AJAX: GET
    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var res=JSON.parse(this.responseText);
//**            console.log(res);

            var heading_modal	= document.getElementById("cliente_m_h");
            var body_modal		= document.getElementById("cliente_m_b");

            body_modal.innerHTML=``;
            body_modal.style.display=`block`;
            heading_modal.innerHTML=``;

            if(res.mensaje!=""){
                body_modal.innerHTML+=`<h4>`+res.mensaje+`</h4>`;
                return false;
            }else{

                if(document.getElementById("tipoPersona").value==1){
                    body_modal.innerHTML+=`
                    <div class="text-right">
                        <a href="javascript: void(0);" onclick="editar_informacionDeContacto(this.parentNode.parentNode)"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
                    </div>
                    <input type="hidden" value="`+cliente_id+`" id="cliente_up">`
                }
                
                for(var i in res.contactos){

                    var obj_contacto=res.contactos[i];

                    heading_modal.innerHTML=`
                        Información de contacto del cliente `+obj_contacto.NombreCompleto+`
                    `;

                    body_modal.innerHTML+=`
                            <div class="form-group">
                                <label class="" for="input_telefono">Telefonox</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-mobile" aria-hidden="true"></i></div>
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_telefono" value="`+(res.contactos[i].Telefono1!="" ? res.contactos[i].Telefono1 : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="" for="input_email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                                        <!--<i class="fa fa-envelope-o" aria-hidden="true"></i>-->
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_email" value="`+(res.contactos[i].EMail1!="" ? res.contactos[i].EMail1 : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="" for="input_preferencia">Preferencia de comunicación</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-comments" aria-hidden="true"></i></div>
                                        <!--<i class="fa fa-comments" aria-hidden="true"></i>-->
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_preferencia" value="`+(res.contactos[i].preferenciaComunicacion!=null ? res.contactos[i].preferenciaComunicacion : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="" for="input_horario_preferente">Horario de comunicación</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_horario_preferente" value="`+(res.contactos[i].horarioComunicacion!=null ? res.contactos[i].horarioComunicacion : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="" for="input_horario_calendar">Día para comunicarse</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_horario_calendar" value="`+(res.contactos[i].diaComunicacion!=null ? res.contactos[i].diaComunicacion : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="" for="input_horario_rfc">RFC</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">RFC</div>
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_rfc" value="`+(res.contactos[i].RFC!=null ? res.contactos[i].RFC : "Sin contacto")+`" disabled>
                                </div>
                            </div>
							
                            <div class="form-group">
                                <label class="" for="input_Lp"><strong>Polizas por Ramo</strong></label>
                                <table class="table">
									<thead>
										<tr style="text-align:center; alignment-baseline:central;">
											<th scope="col">Lineas<br />Personales</th>
											<th scope="col">Vida</th>
											<th scope="col">Daños</th>
											<th scope="col">Vehiculos</th>
											<th scope="col">Fianzas</th>
										</tr>
									</thead>
									<tbody>
										<tr style="text-align:center;">
											<th>`+res.polizas_ramo.Lp+`</th>
											<th>`+res.polizas_ramo.Vi+`</th>
											<th>`+res.polizas_ramo.Da+`</th>
											<th>`+res.polizas_ramo.Ve+`</th>
											<th>`+res.polizas_ramo.Fi+`</th>
										</tr>
									</tbody>
                                </table>
                            </div>
                        `;
                }
            }
        }
    }
    xmlhttp.open("GET", direccion+"/devuelveInformacionDeContacto?q="+cliente_id,true);
    xmlhttp.send();
}

//---------------------------------------
function editar_informacionDeContacto(padre_objeto){
    //console.log(padre_objeto);
    var entradas_contac=document.getElementsByClassName("entrada_contacto");

    for(var i=0; i<entradas_contac.length; i++){
        entradas_contac[i].disabled=false;
    }

    document.getElementById("up_contacto").style.display="block";

}
//--------------------------------------
document.getElementById("up_contacto").addEventListener("click", function(e){
    e.preventDefault();

    var entradas_contac=document.getElementsByClassName("entrada_contacto");
    var cli=document.getElementById("cliente_up").value;

    var update_info={};

    for(var i=0; i<entradas_contac.length; i++){
        //entradas_contac[i].disabled=false;

        update_info[entradas_contac[i].id.replace("input_","")]=entradas_contac[i].value;

    }

    var ajax_object={};
    ajax_object["cliente"]=cli;
    ajax_object["infomacion_contacto"]=update_info;
    //------------------------------
    //Petición AJAX: POST

    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            resp=JSON.parse(this.responseText);
            console.log(resp);

            alert(resp.mensaje);
            if(resp.bool){
                window.location.reload();
            }

        }
    }
    xmlhttp.open("POST", direccion+"/actualizaInformacionDeContacto", true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("data="+JSON.stringify(ajax_object));
    //-----------------------------

    //console.log(update_info);
});
//-------------------------------------
function muestra_parte_notas(elementoHTML){

    var bandera=elementoHTML.getAttribute("id-click");

    if(bandera==1){

        document.getElementById("notas_asignadas").classList.remove("show","in");
        //document.getElementById("notas_asignadas").classList.remove("show");
    } else{
        document.getElementById("asignar_notas").classList.remove("show","in");
        //document.getElementById("asignar_notas").classList.remove("show");
    }
}
//-------------------------------------
function anexaALista(li_element){

    var contenedor_lista=document.getElementById("formulario_agentes"); //contenedor_agentes_para_notas

    var validador=valida_en_lista(li_element.getAttribute("id_persona"));

    if(validador!=""){
        alert(validador);
        return false;
    }

    var entrada=document.createElement("input");
    entrada.type="text";
    
    var id_persona=document.createAttribute("id_persona");
    id_persona.value=li_element.getAttribute("id_persona");

    entrada.setAttributeNode(id_persona);

    entrada.setAttribute("value",li_element.innerHTML);
    entrada.setAttribute("class", "form-control");
    entrada.classList.add("input-sm");

    var div_row=document.createElement("div");
    div_row.setAttribute("class", "input-group");
    //div_row.style.marginTop = "10px";
    div_row.style.paddingTop = "5px";
    //div_row.style.paddingBottom = "5px";

    var div_close=document.createElement("div");
    div_close.setAttribute("class","input-group-prepend");
    div_close.classList.add("quita_elemento");
    //div_close.innerHTML="x";

    var div_group_text=document.createElement("div");
    div_group_text.setAttribute("class","input-group-text");
    div_group_text.innerHTML="x";

    div_close.onclick=function(){

        var padre=this.parentNode;
        var padre_2=padre.parentNode;
        padre_2.removeChild(padre);
        //console.log(padre_2);

    }

    div_row.appendChild(entrada);
    div_row.appendChild(div_close);
    div_close.appendChild(div_group_text);

    contenedor_lista.appendChild(div_row); //

    //console.log(entrada);

}
//-------------------------------------
/*document.getElementsByClassName("quita_elemento").addEventListener("click", function(){

    var padre=this.parentNode;

    padre.removeChild(this);

});*/
//-------------------------------------
function valida_en_lista(idPersona){

    var formulario=document.getElementById("formulario_agentes");
    var mensaje="";


    for(var a=0; a<formulario.elements.length; a++){

        if(formulario.elements[a].getAttribute("id_persona")==idPersona){

            mensaje+="El agente "+formulario.elements[a].value+" se encuentra en la lista de seleccionados";

        }
    }

    return mensaje;
}
//-------------------------------------
//document.getElementById("boton_asigna_notas").addEventListener("click", function(e){

function agregaNotaCliente(elementoHTML,band){

    //elementoHTML.preventDefault();

    var formulario=document.getElementById("formulario_agentes");
    var comentario=document.getElementById("comentario_asigna");
    var nombre_cliente=document.getElementById("nombreCliente").innerHTML;
    var id_cliente=elementoHTML;//.getAttribute("") //document.getElementById("cliente_up");
    var objeto_send={};
    var array_agentes_signado=[];

    for(var i=0; i<formulario.elements.length; i++){

        var id_agente_persona=formulario.elements[i].getAttribute("id_persona");
        array_agentes_signado.push(id_agente_persona);

        //console.log(formulario.elements[i]);
    }
    
    objeto_send["agentes_asignados"]=array_agentes_signado;
    objeto_send["cliente"]=id_cliente; //.value;
    objeto_send["nombre_cliente"]=nombre_cliente;
    objeto_send["comentario"]=comentario.value;
    //objeto_send["bandera"]=band;

    console.log(nombre_cliente);

    //Petición AJAX: POST

    var xmlhhtp= new XMLHttpRequest();

    xmlhhtp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var res=JSON.parse(this.responseText);
            console.log(res);
            //console.log("222");
            
            document.getElementById("modal_info_contacto").classList.remove("show","in");
            $('.modal-backdrop').removeClass("show","in");
            //superior_backdrop.removeChild(document.getElementsByClassName("modal-backdrop")[1]);
            //$('#modal_info_contacto').modal('hide');
        }
    }

    url=(band==1) ? direccion+"/generaNotaDelCliente" :  direccion+"/modificaNotaDelCliente";

    xmlhhtp.open("POST",url,true); //direccion+"/generaNotaDelCliente"
    xmlhhtp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhhtp.send("asyn_data="+JSON.stringify(objeto_send));

    //console.log(id_cliente);

    //Se requiere obtener el idCliente, comentario y idPersona
}
//});
//--------------------------------------
function consultarNotasDelCliente(elemento_html){

    var contenedor_modal=document.getElementById("cliente_m_b");
    var idCliente= elemento_html.getAttribute("id_cliente");
    var nombreCliente= elemento_html.getAttribute("cliente_nombre");
    //cliente_nombre
    //var notas_opciones=document.getElementById("notas_up");
    document.getElementById("up_contacto").style.display="none";

    //document.getElementById("cliente_up").value=idCliente;

    //notas_opciones.style.display="block";
    //contenedor_notas.innerHTML=""
    contenedor_modal.innerHTML=""; //style.display="none";

    var notas_consultadas="";

    //Dibujar en el modal la parte de asignar notas en general
    contenedor_modal.innerHTML+=`
            <div id="notas_up" class="col-md-12">
                <div class="">
                    <ul class="breadcrumb">
                        <li><a data-toggle="collapse" href="#asignar_notas" aria-expanded="true" aria-controls="asignar_notas" id-click="1" onclick="muestra_parte_notas(this)"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Agregar nota</a></li>
                        <li><a data-toggle="collapse" href="#notas_asignadas" aria-expanded="false" aria-controls="notas_asignadas" id-click="2" onclick="muestra_parte_notas(this)"><i class="fa fa-tag" aria-hidden="true"></i> Notas asignadas</a></li>
                    </ul>

                    <!--Parte que dibuja crear notas-->
                    <div class="collapse" id="asignar_notas">
                        <div class="form-group">
                            <label for="comentario_asigna" class="text-left">Agrega comentario de <span id="nombreCliente">`+nombreCliente+`</span></label>
                            <textarea class="form-control" rows="3" id="comentario_asigna"></textarea>
                        </div>
                        <div>

                            <!--<div class="dropdown col-md-2 text-center">
                                <button id="lista_agentes_" type="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" class="btn btn-xs">
                                    AGENTES <span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" role="menu" aria-labelledby="lista_agentes_" id="lista_agentes_list" style="overflow-y: scroll; height: 300px"></ul>

                            </div>-->
                            
                            <div id="contenedor_agentes_para_notas" style="border: 1px black solid; border-radius: 5px">
                                <form action="" id="formulario_agentes"></form>
                            </div>
                            <br>
                            <div class ="nav">
                                <div class="nav flex-column nav-pills" id="pills-tab-personal" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active text-center" id="pills-agente-tab" data-toggle="pill" href="#pills-agente" role="tab" aria-controls="pills-agente" aria-selected="true">AGENTES</a>
                                    <a class="nav-link" id="pills-colaborador-tab" data-toggle="pill" href="#pills-colaborador" role="tab" aria-controls="pills-colaborador" aria-selected="true">COLABORADOR</a>
                                    <!--<a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">COLABORADORES</a>-->
                                </div>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-agente" role="tabpanel" aria-labelledby="pills-agente-tab" style="width: 350px; height: 350px; overflow-y: scroll">AGENTES</div>
                                    <div class="tab-pane fade" id="pills-colaborador" role="tabpanel" aria-labelledby="pills-colaborador-tab" style="width: 350px; height: 350px; overflow-y: scroll">COLABORADORES</div>
                                    <!--<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>-->
                                </div>
                            </div>


                            <button class="btn btn-link" id="boton_asigna_notas" onclick="agregaNotaCliente(`+idCliente+`,1)"><i class="fa fa-upload" aria-hidden="true"></i> Crear asignación</button>
                        </div>
                    </div>
                    <!--Fin de crear notas-->

                    <!--Parte que dibuja las notas creadas-->
                    <div class="collapse" id="notas_asignadas"></div>
                    <!--Fin de notas creadas-->

                </div>
            </div>
        
    `;

    var xmlhhtp= new XMLHttpRequest();

    xmlhhtp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var res=JSON.parse(this.responseText);
            console.log(res);
            
            var contenedor_notas=document.getElementById("notas_asignadas");
            contenedor_notas.innerHTML=""

            var div_content_agentes = document.getElementById("pills-agente");
            div_content_agentes.innerHTML=``;

            var div_content_colaboradores = document.getElementById("pills-colaborador");
            div_content_colaboradores.innerHTML=``;
            //var li_agentes=document.getElementById("lista_agentes_list");
            //li_agentes.innerHTML+=``;

            //--------------------------------------------------------------------
            for(var i in res.personas){ //Imprime en el nav pill solo los vendedoes y colaboradores.

                for(var b in res.personas[i].Data){

                    if(res.personas[i].tipoPersona=="Vendedor"){
                        div_content_agentes.innerHTML+=`
                            <a class="btn btn-link" href="javascript:void(0)" onclick="anexaALista(this)" id_persona="`+res.personas[i].Data[b].idPersona+`">`+res.personas[i].Data[b].nombres+` (`+res.personas[i].Data[b].email+`)</a>
                        `;

                        document.getElementById("pills-agente-tab").innerHTML=`
                            <img src="`+res.img_agentes+`" alt="Clientes" style="width: 65px; height: 65px">
                        `;

                    } else if(res.personas[i].tipoPersona=="Colaborador"){
                        div_content_colaboradores.innerHTML+=`
                            <a class="btn btn-link" href="javascript:void(0)" onclick="anexaALista(this)" id_persona="`+res.personas[i].Data[b].idPersona+`">`+res.personas[i].Data[b].nombres+` (`+res.personas[i].Data[b].email+`)</a>
                        `;

                        document.getElementById("pills-colaborador-tab").innerHTML=`
                            <img src="`+res.img_colaborador+`" alt="Colaborador" style="width: 65px; height: 65px">
                        `;
                    }

                }

                /*if(res.personas[i].tipoPersona=="Vendedor" || res.personas[i].tipoPersona=="Colaborador"){
                    for(var b in res.personas[i].Data){

                        //li_agentes.innerHTML+=`
                        
                        //    <li role="presentation"><a href="javascript:void(0)" onclick="anexaALista(this)" id_persona="`+res.personas[i].Data[b].idPersona+`">`+res.personas[i].Data[b].nombres+` (`+res.personas[i].Data[b].email+`) - `+res.personas[i].tipoPersona+`</a></li>
                        //`;

                    }
                }*/

            }

            //----------------------------------------------------------------
            var doble=/"/g;

            var muestra_comentario="";

            var cuerpo_tabla=`<table class="table"><tbody>`; //</table>

            if(res.mensaje!=""){
                contenedor_notas.innerHTML+=`<h4>`+res.mensaje+`</h4>`;
            } else{

                for(var a in res.datos){

                    var cadena_trunca="";
                    //muestra_comentario=res.datos[a].comentario;
                    //document.getElementById("comentarioNota_area").innerHTML="";
                    //document.getElementById("comentarioNota_area").innerHTML=res.datos[a].comentario;

                    if(res.datos[a].comentario.length>30){
                        cadena_trunca+=(res.datos[a].comentario).substring(0, 30)+"...";
                    } else {
                        cadena_trunca+=res.datos[a].comentario;
                    }

                    notas_consultadas=`
                        <div class="btn-group"  id="dropdown_`+res.datos[a].idNota+`">
                            <!--<button type="button" class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#comentarioNota_" aria-expanded="false" aria-controls="comentarioNota_" onclick="concatenaComentario('`+res.datos[a].comentario+`')">`+cadena_trunca+`</button>-->

                            <button type="button" class="btn btn-primary dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>

                            <!--<button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>-->
                            <ul class="dropdown-menu" role="menu" aria-labelledby="drop_`+res.datos[a].cliente+`">
                                <li role="presentation" class="dropdown-header">AGENTES ASIGNADOS</li>
                               
                    `;

                            var age=res.datos[a].agentes;
                            var contenedor_agentes={};
                            for(var c in age){

                                if(c != ""){

                                    notas_consultadas+=`<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0);">`+age[c]+`</a></li>`
                                    //contenedor_agentes.push(c);
                                }
                                
                            }

                            notas_consultadas+=`
                                <li role="presentation" class="divider"></li>
                                <li role="presentation" class="dropdown-header">OPCIONES</li>
                                <li role="presentation"><a class="text-danger" role="menuitem" tabindex="-1" href="javascript: void(0);" onclick="removerNotaDelCliente(`+res.datos[a].idNota+`,`+res.datos[a].idProyectoSeguimiento+`)">Eliminar nota</a></li>
                                <li role="presentation"><a class="text-info" role="menuitem" tabindex="-1" href="javascript: void(0);" onclick="actualizarNotaDelCliente(`+res.datos[a].idNota+`,`+JSON.stringify(age).replace(doble,"'")+`,'`+res.datos[a].comentario+`',2)">Editar nota</a></li>
                            </ul>
                        </div>

                        <!--<div class="collapse" id="comentarioNota_`+res.datos[a].idNota+`">
                            <textarea class="form-control disabled" rows="3">`+res.datos[a].comentario+`</textarea>
                        </div>-->
                    `;

                    cuerpo_tabla+=`<tr>
                        <td data-toggle="collapse" data-target="#comentarioNota_" aria-expanded="false" aria-controls="comentarioNota_" onclick="concatenaComentario('`+res.datos[a].comentario+`')">`+cadena_trunca+`</td>
                        <td class="text-right">`+notas_consultadas+`</td> <!--<i class="fa fa-ellipsis-v" aria-hidden="true"></i>-->
                    </tr>`;
                    /*notas_consultadas+=`
                        <div class="dropdown" style="display:inline-block" id="dropdown_`+res.datos[a].idNota+`">
                            <button class="btn btn-default dropdown-toggle btn-xs" type="button" id="drop_`+res.datos[a].cliente+`" data-toggle="dropdown" aria-expanded="true" data-toggle-second="tooltip" data-placement="top" title="`+res.datos[a].comentario+`">
                                `+cadena_trunca+`
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="drop_`+res.datos[a].cliente+`">
                               
                            `;

                            var age=res.datos[a].agentes;
                            var contenedor_agentes={};
                            for(var c in age){
                                notas_consultadas+=`<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0);">`+age[c]+`</a></li>`
                                //contenedor_agentes.push(c);
                                
                            }

                            notas_consultadas+=`
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a class="text-danger" role="menuitem" tabindex="-1" href="javascript: void(0);" onclick="removerNotaDelCliente(`+res.datos[a].idNota+`)">Eliminar nota</a></li>
                                <li role="presentation"><a class="text-info" role="menuitem" tabindex="-1" href="javascript: void(0);" onclick="actualizarNotaDelCliente(`+res.datos[a].idNota+`,`+JSON.stringify(age).replace(doble,"'")+`,'`+res.datos[a].comentario+`',2)">Editar nota</a></li>
                            </ul>
                        </div>
                    `;*/
                }

                contenedor_notas.innerHTML+=cuerpo_tabla+`</tbody></table><div class="collapse" id="comentarioNota_"><br>
                                    <textarea class="form-control disabled" id="comentarioNota_area" rows="3"></textarea>
                                 </div>`; //notas_consultadas

            }

        }
    }

    xmlhhtp.open("GET", direccion+"/consultarNotaDelCliente?q="+idCliente,true);
    xmlhhtp.send();

}
//--------------------------------------
function concatenaComentario(comentario){
    document.getElementById("comentarioNota_area").innerHTML=comentario;
}
//-------------------------------------
function removerNotaDelCliente(idNota,idProyecto){

    var drop_hijo=document.getElementById("dropdown_"+idNota);
    var padre=drop_hijo.parentNode.parentNode.parentNode;

    console.log(padre);
    padre.removeChild(drop_hijo.parentNode.parentNode);
    document.getElementById("comentarioNota_").classList.remove("show","in");

    var xmlhhtp= new XMLHttpRequest();

    xmlhhtp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var res=JSON.parse(this.responseText);
            console.log(res);
            
        }
    }

    xmlhhtp.open("GET", direccion+"/removerNotaDelCliente?q="+idNota,true);
    xmlhhtp.send();
}
//-------------------------------------
function actualizarNotaDelCliente(idNota, array_agentes,comentario){

    //console.log(array_agentes);
    var agg=JSON.parse(JSON.stringify(array_agentes));

    var contenedor_lista=document.getElementById("formulario_agentes"); //.innerHTML=""; //contenedor_agentes_para_notas
    document.getElementById("comentario_asigna").innerHTML=comentario;
    document.getElementById("asignar_notas").classList.add("in");
    document.getElementById("notas_asignadas").classList.remove("show","in");
    document.getElementById("comentarioNota_").classList.remove("show","in");

    document.getElementById("boton_asigna_notas").removeAttribute("onclick");
    document.getElementById("boton_asigna_notas").innerHTML=`<i class="fa fa-upload" aria-hidden="true"></i>&nbspActualiza asignación`;
    contenedor_lista.innerHTML="";
    
    for(var a in agg){
        //anexaALista
        
        if(a!=""){

        //}

            var entrada=document.createElement("input");
            entrada.type="text";
            
            var id_persona=document.createAttribute("id_persona");
            id_persona.value=a;

            entrada.setAttributeNode(id_persona);

            entrada.setAttribute("value",agg[a]);
            entrada.setAttribute("class", "form-control");
            entrada.classList.add("input-sm");

            var div_row=document.createElement("div");
            div_row.setAttribute("class", "input-group");

            var div_close=document.createElement("div");
            div_close.setAttribute("class","input-group-addon");
            div_close.classList.add("quita_elemento");
            div_close.innerHTML="x";

            div_close.onclick=function(){

                var padre=this.parentNode;
                var padre_2=padre.parentNode;
                var xmlhhtp= new XMLHttpRequest();

                xmlhhtp.onreadystatechange=function(){
                    if(this.readyState==4 && this.status==200){

                        var res=JSON.parse(this.responseText);
                        console.log(res);

                        padre_2.removeChild(padre);
                        
                    }
                }

                xmlhhtp.open("GET", direccion+"/removerAgenteDeLaNota?q="+a+"&r="+idNota,true);
                xmlhhtp.send();

            }

            div_row.appendChild(entrada);
            div_row.appendChild(div_close);

            contenedor_lista.appendChild(div_row);
        }
        //contenedor_lista.appendChild(entrada);
    }

    document.getElementById("boton_asigna_notas").setAttribute("onclick","agregaNotaCliente("+idNota+",2)");

}
//------------------------------------
//JQuery al nav pill vertical
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    e.target // newly activated tab
    e.relatedTarget // previous active tab

    e.relatedTarget.removeClass("show in");
    //console.log(e.relatedTarget);
});

//------------------------------------
//JQuery al modal activo
    
/*$('#modal_info_contacto').on("show.bs.modal", function(e){

    //console.log($('.modal-backdrop'));
    var modal_backdrop = $('.modal-backdrop');
    //$('.modal-backdrop').removeClass("show");
    //$('.modal-backdrop').removeClass("in");
     console.log("show_modal");

    $(this).css("z-index","1050");

});*/
//------------------------------------