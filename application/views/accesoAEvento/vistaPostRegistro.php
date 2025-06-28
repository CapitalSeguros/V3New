<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<?php
	$this->load->view('headers/header');
?>

<style>

    body{
        background-color: #EAECEE;
    }
    #contenedor{
        width: 100%;
        height: 100%;
        text-align:center;
        /*align-content: center;*/
        margin: 0 auto;
        z-index: 3;	
        position: relative;

    }
    #contenedorHijo{
        width:45%;
        vertical-align: top;
        border-radius: 10px;
        /*text-align:center;*/
        margin: 0 auto;
        /*margin-top: 50px;*/
        top: 45%;
        z-index: 3;	
        position: absolute;
        left: 25%;
        background-color: white;
    }
    .contenedorLogo{
        width:100%;
        height: 50%;
        margin: 0 auto;
    }
    img{
        width: 45%;
        height: 100%;
        padding: 10px 10px;
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
        /*width: 100%;
        height: 15px;
        //border: 1px blue solid;
        background-color:#0464A0;*/
        width:100%; 
        height:200px; 
        background-color: #2874A6; 
        z-index: 2;	
        position: relative;
    }
    #contenedorForm{
        width:100%;
        height: 100%;
        /*height: 70%;*/
        margin: 0 auto;
        padding: 20px 20px;
    }
    .contenedorInfo{
        width:100%;
        height: 100%;
        /*height: 70%;*/
        margin: 0 auto;
        padding: 20px 20px;
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
        <div class="contenedorLogo">
            <img src="https://www.capitalseguros.com.mx/assets/img/logocapitalseguros.png" alt="Capital Seguros">
        </div>
        <div class="contenedorInfo">
            <h4><b>Bienvenido sea <?=$nombre?></b></h4>
            <small class="text-muted" style="font-size: 15px;">Los datos del evento se muestran a continuación.</small>
            <br>
            <br>
            <hr width="97%">
            <table>
              <?php foreach ($evento as $row) { ?> 
                <tr>
                    <td class="titulos"><b>Tema:</b></td>
                    <td class="infoEvento"><?=$row->title;?></td>
                </tr>
                <tr>
                    <td class="titulos"><b>Categoria:</b></td>
                    <td class="infoEvento"><?=$row->categoria_capacitacion;?></td>
                </tr>
                <tr>
                    <td class="titulos"><b>Sub Categoria:</b></td>
                    <td class="infoEvento"><?=$row->sub_categoria_capacitacion;?></td>
                </tr>
                 <tr>
                    <td class="titulos"><b>Ramo:</b></td>
                    <td class="infoEvento"><?=$row->ramo_capacitacion;?></td>
                </tr>
                <tr>
                    <td class="titulos"><b>Fecha/Hora Inicio:</b></td>
                    <td class="infoEvento"><?=$row->created_on;?></td>
                </tr>
            <?php }?>
            </table>
            <hr width="97%">
        </div>
        <div id="contenedorForm">
            <h5><b>Acceso via Zoom</b></h5>
            <br>
            <div id="contenedorLiga">
                <br>
                <p>Liga del Evento:</p>
                <p>Passoword del evento:</p>
            </div>
           
        </div>
        <div class="contenedorInfo">
            <p>En caso de que usted desee cancelar el evento, favor de dar clic al botón de abajo para comunicarle al organizador.</p>
            <br>
            <input type="hidden" name="idInvitado" value="<?=$invitado?>" id="idInvitado">
            <button class="btn btn-danger" id="cancellButton">Cancelar evento</button>
            <br>
            <br>
            <hr>
        </div>
    </div>
    <!--<footer>
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
    </footer>-->
</div>
<script>

    var botonA=document.getElementById("linkButton");
    var botonC=document.getElementById("cancellButton");

    function muestraLiga(){
        var contLiga=document.getElementById("contenedorLiga");
        contLiga.style.display="block";
        botonA.disabled=true;
    }

    //Actualización de estado de invitado a rechazado, envio por AJAX VJS.

    function cancelaInvitacion(){

        var xmlr= new XMLHttpRequest();
        //var direccion=window.location.href.replace("habilitaEvento","");
        var direccion="<?=base_url()."accesoAEvento/cancelacion"?>";
        var idInvitado=document.getElementById("idInvitado").value;

        //console.log(direccion, idInvitado);

        xmlr.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                console.log(this.responseText);
            }
        }

        xmlr.open("GET",direccion+"?q="+idInvitado,true);
        xmlr.send();
    } 

    botonA.addEventListener("click", muestraLiga);
    botonC.addEventListener("click", cancelaInvitacion);
</script>
