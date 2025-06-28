$(function(){
    console.log("carga de js");
});

function consultaContactoDelCliente(ElementHTML){

    var cliente_id=ElementHTML.getAttribute("id_cliente");
    var direccion=window.location.href;
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
                                    <input class="form-control" type="text" id="input_telefono" value="`+(res.contactos[i].Telefono1!="" ? res.contactos[i].Telefono1 : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control" type="text" id="input_email" value="`+(res.contactos[i].EMail1!="" ? res.contactos[i].EMail1 : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_preferencia">Preferencia de comunicación</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-comments" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control" type="text" id="input_preferencia" value="`+(res.contactos[i].preferenciaComunicacion!=null ? res.contactos[i].preferenciaComunicacion : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_horario_preferente">Horario de comunicación</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control" type="text" id="input_horario_preferente" value="`+(res.contactos[i].horarioComunicacion!=null ? res.contactos[i].horarioComunicacion : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_horario_calendar">Día para comunicarse</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control" type="text" id="input_horario_calendar" value="`+(res.contactos[i].diaComunicacion!=null ? res.contactos[i].diaComunicacion : "Sin contacto")+`" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="" for="input_horario_rfc">RFC</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        RFC
                                    </div>
                                    <input class="form-control" type="text" id="input_horario_rfc" value="`+(res.contactos[i].RFC!=null ? res.contactos[i].RFC : "Sin contacto")+`" disabled>
                                </div>
                            </div>
                        `;

                    //console.log(res.contactos[i].EMail1);
                    /*for(var a in obj_contacto){
                        heading_modal.innerHTML=`
                           Información de contacto del cliente `+obj_contacto.NombreCompleto+`
                        `;

                        body_modal.innerHTML+=`
                            <div class="form-group col-md-6">
                                <label class="sr-only" for="input_telefono">Telefono</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-mobile" aria-hidden="true"></i>
                                    </div>
                                    <input class="form-control" type="text" id="input_telefono" value="`+(obj_contacto.Telefono1!="" ? obj_contacto.Telefono1 : "Sin contacto")+`" disabled>
                                </div>
                            </div>
                        `;
                    }*/
                }
            }
        }
    }
    xmlhttp.open("GET", direccion+"/devuelveInformacionDeContacto?q="+cliente_id,true);
    xmlhttp.send();
}