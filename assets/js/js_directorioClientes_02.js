$(function(){
    console.log("carga de js");
});

var direccion=window.location.href;

function consultaContactoDelCliente(ElementHTML){

    var cliente_id=ElementHTML.getAttribute("id_cliente");
  
    console.log(direccion);
    //Petición AJAX: GET
    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            var res=JSON.parse(this.responseText);
            console.log(res);

            var heading_modal=document.getElementById("cliente_m_h");
            var body_modal=document.getElementById("cliente_m_b");

            body_modal.innerHTML=``;
            heading_modal.innerHTML=``;

            if(res.mensaje!=""){
                body_modal.innerHTML+=`<h4>`+res.mensaje+`</h4>`;
                return false;
            }else{

                if(document.getElementById("tipoPersona").value==4){
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
                            <div class="form-group col-md-6">
                                <label class="" for="input_telefono">Telefono</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-mobile" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_telefono" value="`+(res.contactos[i].Telefono1!="" ? res.contactos[i].Telefono1 : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_email" value="`+(res.contactos[i].EMail1!="" ? res.contactos[i].EMail1 : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_preferencia">Preferencia de comunicación</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-comments" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_preferencia" value="`+(res.contactos[i].preferenciaComunicacion!=null ? res.contactos[i].preferenciaComunicacion : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_horario_preferente">Horario de comunicación</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_horario_preferente" value="`+(res.contactos[i].horarioComunicacion!=null ? res.contactos[i].horarioComunicacion : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_horario_calendar">Día para comunicarse</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_horario_calendar" value="`+(res.contactos[i].diaComunicacion!=null ? res.contactos[i].diaComunicacion : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_horario_rfc">RFC</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        RFC
                                    </div>
                                    <input class="form-control entrada_contacto" type="text" id="input_rfc" value="`+(res.contactos[i].RFC!=null ? res.contactos[i].RFC : "Sin contacto")+`" disabled>
                                </div>
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
})
//-------------------------------------