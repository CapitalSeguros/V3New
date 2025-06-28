<?php

   $this->load->view('headers/header');
   $this->load->view('headers/menu');
?>

<style>
    #contenedor_principal{
        //border: 1px red solid;
        width: 100%;
        height: 100%;
    }
    #contenedor_opciones{
        //border: 1px blue solid;
        width: 100%;
        height: 40%;
    }
    h4{
        text-align:center;
    }
    #cont{
       // border: 1px red solid;
        width: 100%;
        height: 100%;
    }
</style>
<body>
    <div id="contenedor_principal" class="container">
        <h3>Lista de asistencia y eventos</h3>
        <hr>
        <div id="contenedor_opciones">
            <h4>Listado de eventos activos</h4>
            <select name="evento" id="idEvento" class="form-control">
                <option value="0">Seleccione un evento del calendario</option>
                <?php 
                foreach($evento as $valor){ ?>
                        <option value="<?=$valor["id_evento"]?>"><?=$valor["nombreEvento"]." (Fecha programada: ".$valor["inicio"]." hrs)"?></option>
                    <?php } ?>
            </select>
            <!--<br>
            <select name="tipo" id="tipo" class="form-control" >
                <option value="0">Seleccione un tipo de invitado</option>
                <option value="interno">Interno</option>
                <option value="externo">Externo</option>
            </select>-->
        </div><br>
        <div>
        <table class="table" id="cont">
            <thead style="text-align: center">
                <tr >
                    <th>Nombres</th>
                    <th>Correo electrónico</th>
                    <th>Organización</th>
                    <th>Puesto</th>
                    <th>Invitado tipo</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody id="registros">
            </tbody>
        </table>
        </div>
    </div>
</body>
<script>

    var url=window.location.href.replace("ListaAsistencia","");
    var lista=document.getElementById("idEvento");
    //var lista=document.getElementById("tipo");

    lista.addEventListener("change", function(){

        var valor=lista.value;
        var base_url="<?=base_url()."ListaAsistencia/obtenerInvitados"?>";

        //habilitar select hijo.

        //var selectTipo=document.getElementById("idEvento");
        //var valortipo=selectTipo.value;
        //selectTipo.disabled=false;

        var xmlHttp= new XMLHttpRequest();

        xmlHttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                //console.log(JSON.parse(this.responseText));
                
                var datos=JSON.parse(this.responseText);
                console.log(this.responseText);
                //var datos=this.responseText;
                var contenedorLista=document.getElementById("registros");
                contenedorLista.innerHTML="";

                for(var indice in datos){
                    //contenedorLista.innerHTML+=`
                    fila=`
                        <tr>
                            <td>`+datos[indice].nombres.toUpperCase() +` `+datos[indice].apellido_paterno.toUpperCase()+` `+datos[indice].apellido_materno.toUpperCase()+`</td>
                            <td>`+datos[indice].correo_lectronico+`</td>
                            <td>`+datos[indice].organizacion.toUpperCase()+`</td>
                            <td>`+datos[indice].puesto.toUpperCase()+`</td>
                            <td>`+datos[indice].tipo_invitado.toUpperCase()+`</td>
                           
                    `;

                    if(datos[indice].tipo_invitado=="externo"){
                        if(datos[indice].estado=="pendiente"){
                            fila+=`<td id="tipo-`+datos[indice].tipo_invitado+`-`+datos[indice].id_invitado+`">
                                <label style="align-content: center">
                                    <button class="btn btn-success btn-sm" id="btnAceptar" onclick="permiso(`+datos[indice].id_invitado+`,'aceptado');">Permitir</button>
                                    <button class="btn btn-danger btn-sm" id="btnRechazar" onclick="permiso(`+datos[indice].id_invitado+`,'rechazado')">Rechazar</button>
                                </label></td>
                            `;
                        } else if(datos[indice].estado=="aceptado"){
                            fila+="<td><label style='color: #138D75'><b>ACEPTADO</b></label></td>";
                        } else if(datos[indice].estado=="rechazado"){
                            fila+="<td><label style='color: #C0392B'><b>RECHAZADO</b></label></td>";
                        }

                    } else if(datos[indice].tipo_invitado=="interno"){
                        if(datos[indice].estado=="pendiente"){

                            fila+=`<td><label style="color: #D35400"><b>`+datos[indice].estado.toUpperCase()+`</b></label></td>`;
                        } else if(datos[indice].estado=="aceptado"){
                            fila+="<td><label style='color: #138D75'><b>"+datos[indice].estado.toUpperCase()+"</b></label></td>";
                        } else if(datos[indice].estado=="rechazado"){
                            fila+="<td><label style='color: #C0392B'><b>"+datos[indice].estado.toUpperCase()+"</b></label></td>";
                        }
                    } 
                    fila+=`</tr>`;
                    //console.log(fila);
                    contenedorLista.innerHTML+=fila;
                }
            }
        }
        xmlHttp.open("GET", base_url+"?q="+valor, true);
        xmlHttp.send();
    });

    //------------------------------------------------------------------------------------------------------------------------------
    //Anexamos una funcion clásica en el boton Permitir ya que no es posible crear un evento addEventListener a un elemento nulo
    //por respuesta del AJAX.

    function permiso(idInvitado, estatus){
        console.log(idInvitado, estatus);
        //Creamos una petición ajax VJS para enviar una actualización a la db.
        var xmlHttp= new XMLHttpRequest();
        var celda=document.getElementById("tipo-externo-"+idInvitado);
        celda.innerHTML="";

        xmlHttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                console.log(this.responseText);

                if(this.responseText=="aceptado"){
                    celda.innerHTML+="<label style='color: #138D75'><b>ACEPTADO</b></label>";
                } else if(this.responseText=="rechazado"){
                    celda.innerHTML+="<label style='color: #C0392B'><b>RECHAZADO</b></label>";
                } else{
                    alert(this.responseText);
                }
            }
        }
        xmlHttp.open("GET",url+"ListaAsistencia/prueba?q="+idInvitado+"&r="+estatus, true); 
        xmlHttp.send();
    }

    //---------------------------------------------------------------------------------------------------------------------------
    //console.log(window.location.href);
    
    //console.log(urlDes);

</script>