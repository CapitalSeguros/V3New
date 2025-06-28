<?php 
    //cabecera
    $this->load->view('headers/header');
    //lista de opciones
    $this->load->view('headers/menu');
?>

<div class="container-fluid">
    <h3>Lista de asistencia a capacitaciones</h3>
    <hr>
    <div class="container text-center" >
        <h4 class="text-center">Referencias:</h4>
        <p class="text-center">Validación de asistencia de agentes a una capacitación por colores.</p>
        <ul class="list-group">
            <li class="list-group-item list-group-item-success">El organizador confirmó asistencia presencial (clic al botón confirmar en asistencia)</li>
            <li class="list-group-item list-group-item-info">Aun queda pendiente la asistencia del agente</li>
            <li class="list-group-item list-group-item-danger">El agente no asistió a la reunión de capacitación (clic al botón confirmar en ausencia)</li>
        </ul>
    </div>
    <hr style="width: 95%">
    <div class="container">
    <h4 class="text-center">Lista de eventos activos</h4>
    <?php foreach($eventosActivos as $eventos) {
            foreach($eventos["clasificacion"] as $tipo) {
                if($tipo=="capacitacion") {?>
        <div class="panel panel-info" id="panel_<?=$eventos['idEvento']?>">
           <div class="panel-heading" onclick="muestraLista('<?=$eventos['idEvento']?>');" id="head_show_<?=$eventos['idEvento']?>">
                <h5><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp&nbsp&nbsp<?=$eventos["nombreEvento"]?>      (Clic aqui para ver la lista de asistencia)</h5>
           </div>
           <div class="panel-heading" onclick="ocultaLista('<?=$eventos['idEvento']?>')" id="head_hide_<?=$eventos['idEvento']?>" style="display:none">
                <h5><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp&nbsp&nbsp<?=$eventos["nombreEvento"]?>      (Clic aqui para ocultar la lista de asistencia)</h5>
           </div>
           <div class="panel-body" style="display:none" id="cuerpo_<?=$eventos['idEvento']?>">

                <?php foreach($eventos["invitados"] as $datos){
                    if($datos->estado=="aceptado") {?>
                    <div class="col-lg-4 col-sm-4 col-md-4 panel panel-info" id="panel_<?=$datos->id_invitado?>">
                        <div class="panel-heading">
                            <p class="text-center"><i class="fa fa-user" aria-hidden="true"></i>&nbsp&nbsp<?=ucwords($datos->nombres)." ".ucwords($datos->apellido_paterno)." ".ucwords($datos->apellido_materno)?></p>
                        </div>
                        <div class="panel-body text-center">
                            <form id="form_asistencia_<?=$datos->id_invitado?>">
                                <input type="radio" value="asistencia" id="radioAsitencia_<?=$datos->id_invitado?>" name="asistencia_<?=$datos->id_invitado?>" >&nbsp&nbsp<label for="radioAsitencia" class="text-primary"><i class="fa fa-check" aria-hidden="true"></i>&nbspAsistencia</label>
                                &nbsp&nbsp&nbsp
                                <input type="radio" value="ausencia" id="radioAsitencia_<?=$datos->id_invitado?>" name="asistencia_<?=$datos->id_invitado?>" >&nbsp&nbsp<label for="radioAusencia" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i>&nbspAusencia</label>
                                <br><br>
                                <input type="hidden" value="<?=$datos->id_invitado?>" id="invitado_id_<?=$datos->id_invitado?>">
                                <input type="hidden" value="<?=$datos->id_evento?>" id="evento_id_<?=$datos->id_evento?>">

                <?php if($datos->idCertificacion>0) {?> 
                
                    <input type="hidden" value="<?=$datos->idCertificacion?>" id="valorReporte_<?=$datos->id_invitado?>">
                <?php } else{?> 
                    <input type="hidden" value="0" id="valorReporte_<?=$datos->id_invitado?>">
                <?php }?>
                                <button class="btn btn-default text-default" onclick="actualizaAsistencia(document.getElementById('invitado_id_<?=$datos->id_invitado?>').value,document.getElementById('evento_id_<?=$datos->id_evento?>').value,document.getElementById('valorReporte_<?=$datos->id_invitado?>').value,<?=$datos->id_persona?>); return false;">Confirmar</button>
                            </form>
                        </div>
                    </div>
                <?php } else{ ?> 
                    <div class="col-lg-4 col-sm-4 col-md-4 panel panel-danger" id="panel_<?=$datos->id_invitado?>">
                        <div class="panel-heading">
                            <p class="text-center"><i class="fa fa-user" aria-hidden="true"></i>&nbsp&nbsp<?=ucwords($datos->nombres)." ".ucwords($datos->apellido_paterno)." ".ucwords($datos->apellido_materno)?></p>
                        </div>
                        <div class="panel-body text-center">
                            <form id="form_asistencia_<?=$datos->id_invitado?>">
                                <input type="radio" value="asistencia" id="radioAsitencia_<?=$datos->id_invitado?>" name="asistencia_<?=$datos->id_invitado?>" disabled>&nbsp&nbsp<label for="radioAsitencia" class="text-primary"><i class="fa fa-check" aria-hidden="true"></i>&nbspAsistencia</label>
                                &nbsp&nbsp&nbsp
                                <input type="radio" value="ausencia" id="radioAsitencia_<?=$datos->id_invitado?>" name="asistencia_<?=$datos->id_invitado?>" disabled>&nbsp&nbsp<label for="radioAusencia" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i>&nbspAusencia</label>
                                <br><br>
                                <input type="hidden" value="<?=$datos->id_invitado?>" id="invitado_id_<?=$datos->id_invitado?>">
                                <input type="hidden" value="<?=$datos->id_evento?>" id="evento_id_<?=$datos->id_evento?>">
                                <input type="hidden" value="0" id="valorReporte_<?=$datos->id_invitado?>">
           
                                <button class="btn btn-default text-default" onclick="actualizaAsistencia(document.getElementById('invitado_id_<?=$datos->id_invitado?>').value,document.getElementById('evento_id_<?=$datos->id_evento?>').value,document.getElementById('valorReporte_<?=$datos->id_invitado?>').value,<?=$datos->id_persona?>); return false;" disabled>Confirmar</button>
                            </form>
                        </div>
                    </div>
                <?php }
            
            }?>
           </div>
        </div>
    <?php } } }?>
    </div>
</div>
<script>

    //console.log(window.location.href);
    var direccion=window.location.href;

function actualizaAsistencia(idInvitado,evento,valorReporte,idPersona){
    
    var formulario=document.getElementById("form_asistencia_"+idInvitado);
    var contador=0;

    for(var i=0; i<formulario.elements.length; i++){
        if(formulario.elements[i].type=="radio" && formulario.elements[i].checked){
            var valorAsitencia=formulario.elements[i].value;
            //contador++;
            //console.log(idInvitado,valorAsitencia);

        }
    }

    /*if(!document.querySelector("input[name='asistencia_"+idInvitado+"']:checked")){
        console.log(idInvitado,"No se ha seleccionado nada");
    } */

    //Petición AJAX

    var xmlhttp=new XMLHttpRequest();
    var panelInvitado=document.getElementById("panel_"+idInvitado);

    if(valorReporte>0 && valorAsitencia=="asistencia"){
        alert("El agente ya se encuentra registrado");
        panelInvitado.classList.replace("panel-info","panel-success");

    } else if(!document.querySelector("input[name='asistencia_"+idInvitado+"']:checked")){
        alert("No se ha seleccionado una opción");
        //panelInvitado.classList.replace("panel-info","panel-succes");

    } else{

        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                //console.log(JSON.parse(this.responseText));
                resultado=JSON.parse(this.responseText);

                for(var i in resultado){

                    if(i=="asistencia" && resultado[i]>0){
                        //panelInvitado.classList.replace("panel-info","panel-success");

                        if(panelInvitado.classList.contains("panel-info")){
                            panelInvitado.classList.replace("panel-info","panel-success");

                        } else if(panelInvitado.classList.contains("panel-danger")){
                            panelInvitado.classList.replace("panel-danger","panel-success");
                        }
                
                        var valorReporte=document.getElementById("valorReporte_"+idInvitado).value=resultado[i];

                    } else if(i=="ausencia" && resultado[i]==true){
                        
                        var valorReporte=document.getElementById("valorReporte_"+idInvitado).value=0;

                        if(panelInvitado.classList.contains("panel-info")){
                            panelInvitado.classList.replace("panel-info","panel-danger");

                        } else if(panelInvitado.classList.contains("panel-success")){
                            panelInvitado.classList.replace("panel-success","panel-danger");
                        }
                    }
                }
            }
        }

        switch(valorAsitencia){
            case "asistencia": xmlhttp.open("GET",direccion+"/registraEnReporte?q="+idInvitado+"&r="+evento+"&p="+valorReporte, true);
            break;
            case "ausencia": xmlhttp.open("GET",direccion+"/actualizaEstado?q="+idInvitado+"&r="+evento+"&p="+valorReporte+"&s="+idPersona, true);
            break;

        }

    xmlhttp.send();

    }
}

//------------------------------------------------------------------------------------------------------------

function muestraLista(evento){

    var cabeceraS=document.getElementById("head_show_"+evento);
    var cabeceraH=document.getElementById("head_hide_"+evento);
    var panel=document.getElementById("panel_"+evento);
    var cuerpo_panel=document.getElementById("cuerpo_"+evento);

    cabeceraS.style.display="none";
    cabeceraH.style.display="block";
    panel.classList.replace("panel-info","panel-primary");
    cuerpo_panel.style.display="block";

}

//------------------------------------------------------------------------------------------------------------
function ocultaLista(evento){

    var cabeceraS=document.getElementById("head_show_"+evento);
    var cabeceraH=document.getElementById("head_hide_"+evento);
    var panel=document.getElementById("panel_"+evento);
    var cuerpo_panel=document.getElementById("cuerpo_"+evento);

    cabeceraS.style.display="block";
    cabeceraH.style.display="none";
    panel.classList.replace("panel-primary","panel-info");
    cuerpo_panel.style.display="none";
}


</script>