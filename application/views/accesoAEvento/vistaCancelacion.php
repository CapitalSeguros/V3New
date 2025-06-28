<?php
	$this->load->view('headers/header');
?>

<style>

    body{
        background-color: white;
    }
    #contenedor{
        width: 100%;
        height: 100%;
        text-align:center;
        /*align-content: center;*/
        margin: 0 auto;
    }
    #contenedorHijo{
        /*border: 1px blue solid;*/
        width:65%;
        height: 100%;
        vertical-align: top;
        /*text-align:center;*/
        margin: 0 auto;
        margin-top: 50px;
        
    }
    .contenedorInfo{
        width:100%;
        height: 70%;
        margin: 0 auto;
    }
    img{
        width: 40%;
        height: 30%;
    }
    table, tr{
        width: 100%;
        text-align: justify;
        border-collapse: separate;
        border-spacing: 10px;
    }
    .titulos{
        width: 20%;
    }
    .infoEvento{
        color:black;
    }
    footer{
        //border: 1px blue solid;
        width: 100%;
        height: 100%;
        //background-color:#264152;
    }
    .logo{
        //border: 1px red solid;
        width: 20%;
        height: 100%;
        margin-top: 10px;
        display: inline-block;
    }
    .barra{
        width: 100%;
        height: 15px;
        //border: 1px blue solid;
        background-color:#0464A0;
    }
    #contenedorForm{
        width:100%;
        height: 70%;
        margin: 0 auto;
    }
    #contenedorLiga{
        width:100%;
        height: 70%;
        margin: 0 auto;
    }
</style>
<div id="contenedor">
    <div class="barra"></div>
    <div id=contenedorHijo>
        <div class="contenedorInfo">
            <img src="https://www.capitalseguros.com.mx/assets/img/logocapitalseguros.png" alt="Capital Seguros">
        </div>
        <div class="contenedorInfo">
            <br><br>
            <h4><b>Estimado(@) <?=$nombre?></b></h4>
            <br>
            <h4><b>¿Esta seguro que desea cancelar la invitación del siguiente evento?</b></h4>
            <br>
         
            <hr>
            <table>
                <tr>
                    <td class="titulos"><b>Tema:</b></td>
                    <td class="infoEvento"><?=$titulo?></td>
                </tr>
                <tr>
                    <td class="titulos"><b>Lugar:</b></td>
                    <td class="infoEvento"><?=$lugar?></td>
                </tr>
                <tr>
                    <td class="titulos"><b>Fecha:</b></td>
                    <td class="infoEvento"><?=$fechaI?> Hrs a <?=$fechaF?> Hrs</td>
                </tr>
            </table>
            <br>
            <hr>
        </div>
        <div id="contenedorForm">
            <h4>En caso de que si, favor de dar clic al botón de abajo para informar al organizador.</h4>
            <br>
            <input type="hidden" name="idInvitado" value="<?=$invitado?>" id="idInvitado">
            <input type="hidden" name="idEvento" value="<?=$id_evento?>" id="idEvento">
            <button class="btn btn-danger" id="cancellButton">Cancelar evento</button>
            <br>
            <br>
            <hr>
        </div>
    </div>
    <footer>
        <div class="logo">
            <img src="https://www.capitalseguros.com.mx/wp-content/uploads/2018/02/LogoCapi-300x108.png" alt="">
        </div>
        <div class="logo">
            <img src="https://www.capitalseguros.com.mx/wp-content/uploads/2018/02/LogoAsesores.png" alt="">
        </div>
        <div class="logo">
            <img src="https://fianzascapital.com/wp-content/uploads/2018/02/LogoFianzasFinal.png" alt="">
        </div>
        <div class="logo">
            <img src="https://www.capitalseguros.com.mx/assets/img/logocapitalseguros.png" alt="">
        </div>
        <br>
        <div class="barra"></div>
    </footer>
</div>
<script>

    var botonC=document.getElementById("cancellButton");

    //Actualización de estado de invitado a rechazado, envio por AJAX VJS.

    function cancelaInvitacion(){

        var xmlr= new XMLHttpRequest();
        //var direccion=window.location.href.replace("habilitaEvento","");
        var direccion="<?=base_url()."accesoAEvento/cancelacion"?>";
        var idInvitado=document.getElementById("idInvitado").value;
        var idEvento=document.getElementById("idEvento").value

        //console.log(direccion, idInvitado);
        var contenedor=document.getElementById("contenedorForm");
        contenedor.innerHTML="";

        xmlr.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                //console.log(this.responseText);
                if(this.responseText){
                   
                    contenedor.innerHTML+=`
                        <h4>Muchas gracias por su cooperación.</h4>
                        <br>
                        <h4>Buen día<h4>
                        <br>
                        <br>
                        <hr>
                    `;
                }
            }
        }

        xmlr.open("GET",direccion+"?q="+idInvitado+"&r="+idEvento,true);
        xmlr.send();
    } 

    botonC.addEventListener("click", cancelaInvitacion);

</script>