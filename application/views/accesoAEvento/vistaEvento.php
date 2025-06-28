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
</style>
<div id="contenedor">
    <div class="barra"></div>
    <div id=contenedorHijo>
        <div class="contenedorInfo">
            <img src="https://www.capitalseguros.com.mx/assets/img/logocapitalseguros.png" alt="Capital Seguros">
        </div>
        <div class="contenedorInfo">
            <br><br>
            <h4><b>Invitación a <?=$clasificacion?></b></h4>
            <br>
            <hr>
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
            <br>
            <hr>
        </div>

        <?php if($estado=="new") {?>

        <div id="contenedorForm">
            <form method="post" action="<?=base_url()."accesoAEvento/registro_invitado_ext"?>" id="form_invitado">
            <h4 style="color: black; font-family: arial"><b>Formulario de registro</b></h4>
            <p style="color: black; font-family: arial">Es requerido llenar el siguiente formulario para proceder con la aceptación del organizador.</p>
            <p style="color: red; font-family: arial;">Todos los campos son obligatorios.</p>
            <input type="hidden" name="titulo_evento" value="<?=$row->cal_id;?>">
            <table>
                <tr>
                    <td>
                        <label for="nombreExt" >Nombres:</label><br>
                        <input type="text" name="nombreExt" id="nombreExt" class="form-control form-control-sm" required>
                    </td>
                    <td>
                        <label for="apellidoPExt">Apellido Paterno:</label><br>
                        <input type="text" name="apellidoPExt" id="apellidoPExt" class="form-control form-control-sm" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="apellidoMExt">Apellido Materno:</label><br>
                        <input type="text" name="apellidoMExt" id="apellidoMExt" class="form-control form-control-sm" required>
                    </td>
                    <td>
                        <label for="emailExt">Direccion de correo electronico:</label><br>
                        <input type="email" name="emailExt" id="emailExt" class="form-control form-control-sm" placeholder="email@example.com" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="telefonoExt">Teléfono:</label><br>
                        <input type="tel" name="telefonoExt" id="telefonoExt" class="form-control form-control-sm" required>
                    </td>
                    <td>
                        <label for="ciudadExt">Ciudad:</label><br>
                        <input type="text" name="ciudadExt" id="ciudadExt" class="form-control form-control-sm" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="organizacionExt">Organización:</label><br>
                        <input type="text" name="organizacionExt" id="organizacionExt" class="form-control form-control-sm" required>
                    </td>
                    <td>
                        <label for="PuestoOrgExt">Puesto de trabajo:</label><br>
                        <input type="text" name="PuestoOrgExt" id="PuestoOrgExt" class="form-control form-control-sm" required>
                    </td>
                </tr>
            </table>
            <br>
            <button class="btn btn-primary" id="btnRegistro">Registrar</button>
            </form>
            <br>
            <hr>
        </div>
        <?php } elseif($estado=="pendiente") { ?> 
            <div id="contenedorForm">
                <h4>La información requerida ha sido enviado al organizador del evento.</h4>
                <br>
                <small class="text-muted" style="font-size: 15px;">Se enviará la respuesta a su bandeja de entrada en unos momentos.</small>
                <br><br><br><br>
            </div>
        <?php }?>
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
    //--------------------------------------------------------------------------------------
    //Por esta vez usaré JQuery
    //Crear un evento que envie por Asincrono los datos del invitado.

    //funcion que envia los datos por metodo POST.
    function registro_invitado(e){

        e.preventDefault();
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            error: function(jqXHR){
                alert("datos no enviados");
                console.log(jqXHR);

            },
            beforeSend: function(){
                $("#contenedorForm").html(`
                    <h4>Enviando información al organizador del evento...</h4>
                `);
            },
            success: function(res){
                //console.log(res);
                $("#contenedorForm").html(`
                    <h4>La información requerida ha sido enviado al organizador del evento.</h4>
                    <br>
                    <small class="text-muted" style="font-size: 15px;">Se enviará la respuesta a su bandeja de entrada en unos momentos.</small>
                    <br><br><br><br>
                `);
            }
        });
    }

    $("#form_invitado").on("submit", registro_invitado);

    //--------------------------------------------------------------------------------------


</script>
