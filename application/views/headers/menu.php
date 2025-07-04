<?

$ci = &get_instance();
$ci->load->model("menu_model");
$ci->load->model("personamodelo");
$ci->load->model("crmproyecto_model", "crmproyecto");
/* Inicio Tic Consultores */
$ci->load->model('evaluacion_periodos_model', 'periodo');
$ci->load->model('notificacionmodel', 'notificacion');

$email    = $this->tank_auth->get_usermail();
$persona = $this->db->query('select p.tipoPersona,p.esCoordinador,p.esAgenteColaborador from persona p left join users u on u.idPersona=p.idPersona where u.email="' . $email . '"')->result()[0];
$permisosCH = 0;
$permisosCoordinador = 0;
if ($persona->tipoPersona == 1 || $persona->esAgenteColaborador == 1) {
    $permisosCH = 1;
}
if ($persona->esCoordinador == 1) {
    $permisosCoordinador = 1;
}
if ($email == "SISTEMAS@ASESORESCAPITAL.COM" || $email == "AUDITORINTERNO@AGENTECAPITAL.COM" || $email == "CAPITALHUMANO@AGENTECAPITAL.COM" || $email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "PROYECTO@AGENTECAPITAL.COM.MX") {
}
//**************************
//--- Creado [Suemy][2024-04-26]
$permissionSE = 0;
if ($email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "ASISTENTEDIRECCION@AGENTECAPITAL.COM") {
    $permissionSE = 1;
}
?>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<style type="text/css">
    body {
        overflow-x: hidden;
    }

    ul#menuSub {
        float: center;
        padding: 5px;
        position: relative;
        top: 10px;
        color: #fff;
        font-size: 14px;
    }

    ul#menuSub2 {
        border-style: solid;
        height: 80px;
        width: 80px;
        border-style: groove;
        font-size: 14px;
        top: 15px;
        position: absolute;
    }

    ul#menuSub li {
        color: white;
        float: left;
        list-style: none;
        margin: 0% 0%;
    }

    ul#menuSub li:hover {
        color: blue;
        cursor: pointer;
        background: #9D8EBF;
    }

    ul#menuSub ul {
        display: none;
        position: absolute;
        top: 18px;
        color: green;
        padding: 2px 0px 2px 2px;
        margin-top: 3px;
        left: 5PX;
        height: auto;
        width: 140px;
        background: #59497A;
    }

    ul#menuSub ul li {
        float: left;
        color: blue;
        width: 130px;
        margin: 2% 0%;
    }

    ul#menuSub ul li a {
        color: white;
    }

    ul#menuSub ul li a:hover {
        color: yellow;
        cursor: pointer;
    }

    ul#menuSub li:hover ul ul,
    ul#menuSub li:hover ul ul ul,
    ul#menuSub li.iehover ul ul,
    ul#menuSub li.iehover ul ul ul {
        display: none;
        cursor: pointer;
    }

    ul#menuSub li:hover ul,
    ul#menuSub ul li:hover ul,
    ul#menuSub ul ul li:hover ul,
    ul#menuSub li.iehover ul,
    ul#menuSub ul li.iehover ul,
    ul#menuSub ul ul li.iehover ul {
        display: block;
        cursor: pointer;
    }

    .fondoCabeceraMenuGeneral {
        height: 130px;
        visibility: visible;
        background-repeat: no-repeat;
        margin-bottom: 0px;
        background-color: white
    }

    .stiloLogo1 {
        background-image: url("<?php echo base_url(); ?>assets/images/logo/B1366x100.png");
    }

    .stiloLogo2 {
        background-image: url("<?php echo base_url(); ?>assets/images/logo/B960X115.png");
    }

    .stiloLogo3 {
        background-image: url("<?php echo base_url(); ?>assets/images/logo/B900x100.png");
    }

    .stiloLogo4 {
        background-image: url("<?php echo base_url(); ?>assets/images/logo/B720x120.png");
    }

    .stiloLogo5 {
        background-image: url("<?php echo base_url(); ?>assets/images/logo/B320x120.png");
    }

    .fondoNegro {
        color: black
    }

    .popover-content {
        color: black;
        width: 200px;
        left: 410px;
    }

    .popover-title {
        background-color: #361866;
        color: white;
    }

    .popover .fade .bottom .in {
        left: 410px !important;
    }

    #test:focus {
        background-color: green;
    }

    .test {
        top: 12vh;
        right: 3vw;
        width: 400px;
        max-height: 200px;
        background-color: white;
        position: absolute;
        z-index: 1;
        display: none;
        overflow: auto;
        overflow-x: hidden;
        border-radius: 5px;
        -webkit-box-shadow: -9px 9px 11px -5px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: -9px 9px 11px -5px rgba(0, 0, 0, 0.75);
        box-shadow: -9px 9px 11px -5px rgba(0, 0, 0, 0.75);
        /* recordar poner  en  fondoCabeceraMenu style="position: relative;" */
    }

    #campana {
        position: absolute;
        margin-left: -20px;
        margin-top: 40px;
    }

    /* INICIO: CSS para evitar que el dropdown de los datos del usuario sea obstruidos por otros elementos de la interfaz */

    /* Asegura que el elemento con esta clase se muestre por encima de otros elementos */
    .alwaysOnTop {
        position: relative;
        z-index: 1000;
        /* Valor alto para asegurarse de que esté por encima */
        /*outline: 2px solid red;*/
    }

    /* Define el estilo para el elemento de dropdown con un ancho fijo y centrado */
    #dropdown_usuario {
        width: 350px;
        /* Ancho fijo */
        max-width: 100%;
        /* Ancho máximo relativo al contenedor */
        margin: 0 auto;
        /* Centra el elemento si es de ancho fijo */
        padding: 10px;
        /* Ajusta el relleno interno si es necesario */
        box-sizing: border-box;
        /* Incluye el padding y el borde en el ancho total */
    }

    #modalTareas {
        position: fixed;
        z-index: 1001;
    }

    /* FIN: CSS para evitar que el dropdown de los datos del usuario sea obstruidos por otros elementos de la interfaz */
</style>
<style type="text/css">
    #menu_encuestas {
        float: left;
        margin-left: -40%;
        width: 100%;
        height: 120px;
        background-color: #361666;
    }

    #menu_encuestas ul li a span {
        color: #fff;
    }

    #menu {
        z-index: 2;
    }
</style>
<script type="text/javascript">
    function cambiaVariableSecion() {
        document.getElementById("ventana-flotanteBL").className = "oculto";
        $.ajax({
            method: "POST",
            dataType: "html",
            url: "<?= base_url() ?>cambiaVariableSecion/cierraBox",
            data: {
                gato: 'perro'
            },
            async: true,
            success: function(result) {
                /*El codigo que vas a hacer funcionar cuando tenga exito el ajax*/
            },
            error: function() {
                /*El codigo que vas a hacer cuando falle el ajax*/
            }
        })
    }
</script>


<?php

//data de las notificaciones de las evaluaciones
$evalPendientes = $this->periodo->ntMyInfo($this->tank_auth->get_idPersonaPuesto(), $this->tank_auth->get_idPersona());
//lista de las notificaciones del sistema
$notificaciones = $this->notificacion->getAllNotificaciones($this->tank_auth->get_idPersona());
$NotiPendientes = $this->notificacion->NuevasN($this->tank_auth->get_idPersona());

/* fin Tic Consultores */

//$menuprincipal= $ci->menu_model->llama();
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($ci->menu_model->llama(), TRUE));fclose($fp);

$configModulos = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
foreach ($configModulos as $modulos) {
}

$sqlConsultaBanners = "Select `directorio`,`img` From `banners` Where 1 Order By `id` Asc";
$queryConsultaBanners    = $this->db->query($sqlConsultaBanners)->result();
//echo "<pre>";
//print_r($queryConsultaBanners);
//echo "</pre>";

$imgBanner_BoxLight    = base_url() . $queryConsultaBanners[0]->directorio . "/" . $queryConsultaBanners[0]->img;
//"assets/imgBanner/nuestrosagentes1.png";
$imgBanner_Marq_0    = base_url() . $queryConsultaBanners[1]->directorio . "/" . $queryConsultaBanners[1]->img;
//"assets/imgBanner/B1/F-1366x100.png";
$imgBanner_Marq_1    = base_url() . $queryConsultaBanners[2]->directorio . "/" . $queryConsultaBanners[2]->img;
//"assets/imgBanner/B2/F-1366x100.png";
$imgBanner_Marq_2    = base_url() . $queryConsultaBanners[3]->directorio . "/" . $queryConsultaBanners[3]->img;
//"assets/imgBanner/B3/F-1366x100.png";
$imgBanner_Marq_3    = base_url() . $queryConsultaBanners[4]->directorio . "/" . $queryConsultaBanners[4]->img;
//"assets/imgBanner/B4/F-1366x100.png";
$imgBanner_CicVenta = base_url() . "assets/imgBanner/B_CICLO_VENTA/BANNER_CICLO_1366x100.png";

?>
<?php
$activa            = $this->uri->segment(1);
$path_foto        = "assets/img/miInfo/userPhotos/";
$foto            = "";
$usermail        = $this->tank_auth->get_usermail();
$idPersona        = $this->tank_auth->get_idPersona();
$imagenPersona    = $ci->menu_model->buscaFotoPersonal($this->tank_auth->get_idPersona());

if (isset($imagenPersona)) { // count($imagenPersona) > 0

    //$foto="archivosPersona/".$imagenPersona[0]->idPersona."/miFoto/".$imagenPersona[0]->idPersonaImagen.$imagenPersona[0]->extensionPersonaImagen;

    //Miguel Jaime 16/10/2020

    $foto = $path_foto . $imagenPersona;
} else {
    $foto = $path_foto . "noPhoto.png";
}
?>

<?php
session_start();
if (isset($_SESSION['BOXLIGHT'])) {
    if ($_SESSION['BOXLIGHT']) {
?>
        <div id='ventana-flotanteBL'>
            <a class='cerrar' href='javascript:void(0);' onclick='cambiaVariableSecion ()'>x</a>
            <img style="height: 100%;width: 100%" src="<?= $imgBanner_BoxLight ?>">
        </div>
<?php
        //$_SESSION['BOXLIGHT']=FALSE;
    }
}

$usuarios_servicios_sicas = array(
    "DATACENTER@AGENTECAPITAL.COM",
    "CAPTURA@ASESORESCAPITAL.COM",
    "CAPTURA2@ASESORESCAPITAL.COM",
    "CAPTURA3@ASESORESCAPITAL.COM",
    "ANALISTADEINGRESOS@AGENTECAPITAL.COM",
    "GESTIONOPERATIVA2@ASESORESCAPITAL.COM",
    "COORDINADOROPERATIVO@ASESORESCAPITAL.COM",
    "SISTEMAS@ASESORESCAPITAL.COM"
);
?>

<header>
    <!-- INICIO: Fila de nuestra cabecera -->
    <div id="fondoCabeceraMenu" class="row fondoCabeceraMenuGeneral">
        <?php
        $Evaluado = 0;
        $Evaluador = 0;
        foreach ($evalPendientes as $key => $value) {
            if ($value["tipo"] == "EVALUADO") {
                $Evaluado++;
            } else {
                $Evaluador++;
            }
        }
        ?>
        <!-- Columna del logo V3 -->
        <div class="col-md-2 col-sm-2">
            <!-- Vacio para no ocultar la parte del logo V3Plus -->
        </div>
        <!-- Columna del banner -->
        <div class="col-md-8 col-sm-8 hidden-xs">
            <div id="test" class="test" style="z-index: 1000">
                <div class="row">
                    <div>
                        <div class="col-md-12" style="background-color: #361866;color: white; height: 30px;">
                            <h5 style="color: white; padding-left: 10px;">Notificaciones</h5>
                        </div>
                    </div>
                    <div>
                        <div class="col-md-12">
                            <ul style="list-style: none;padding-inline-start: 10px !important;">
                                <?php if (!empty($evalPendientes)) : ?>
                                    <li style="border-bottom: 1px solid #e3e3e3;">
                                        <div class="media" style="margin: 10px;">
                                            <a href="<?= base_url() ?>miInfo">
                                                <div class="media-body">
                                                    <?php if ($Evaluado > 0) : ?>
                                                        <p>Siendo evaluado en <?= $Evaluado ?> periodos.</p>
                                                    <?php endif; ?>
                                                    <?php if ($Evaluador > 0) : ?>
                                                        <p>Evaluaciones pendientes: <?= $Evaluador ?></p>
                                                    <?php endif; ?>
                                                    <p>ir a miInfo para más información.</p>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                <?php endif; ?>
                                <?php foreach ($notificaciones as $key => $value) : ?>
                                    <li style="border-bottom: 1px solid #e3e3e3;">
                                        <?php
                                        if ($value->tipo == 'OTRO') {
                                            $texto[0] = $value->comentarioAdicional;
                                            $texto[1] = '';
                                        } elseif ($value->tipo == 'SOLICITUD_BAJA') {

                                            $personName = $ci->personamodelo->getPersonalDataForDelete($value->referencia_id);
                                            $nameComplete = !empty($personName) ? "(" . $personName->nombres . " " . $personName->apellidoPaterno . " " . $personName->apellidoMaterno . ")" : "";
                                            $contenido = explode(",", $value->Contenido);
                                            $texto[0] = $contenido[0];
                                            $texto[1] = $contenido[1] . " " . $nameComplete . "";
                                        } else {
                                            $texto = explode(",", $value->Contenido);
                                        }
                                        //$texto = explode(",", $value->Contenido) 
                                        ?>
                                        <div class="media" style="margin: 10px;">
                                            <?php if ($value->tipo == 'OTRO') { ?><a href="<?= base_url() . $value->controlador ?>">
                                                    <?php    } else {
                                                    if ($value->referencia != "CUMPLEANIO") { //Anexo Dennis [2021-04-22]
                                                    ?>
                                                        <a href="<?= base_url() ?>Notificaciones/<?= $value->referencia_id ?>/<?= $value->referencia ?>/<?= $value->id ?>">
                                                        <?php } else { //Anexo Dennis [2021-04-22]
                                                        ?>
                                                            <a href="#modal_cumpleanio" class="hbd_modal" data-toggle="modal" data-target="#modal_cumpleanio" data-backdrop="false" id="ref_fecha_cumple" data-idCumple="<?= $value->referencia_id ?>" data-notification="<?= $value->id ?>">
                                                        <?php }
                                                } ?>
                                                        <div class="media-body">
                                                            <small class="text-muted" style="float:right">
                                                                <span class="glyphicon glyphicon-calendar alertNotificacao"></span>
                                                                <?= date("d-m-Y, g:i a", strtotime($value->fecha_alta)) ?>
                                                            </small>
                                                            <h5 class="media-heading"><?php echo $texto[0] ?></h5>
                                                            <p><?php echo $texto[1] ?></p>
                                                        </div>
                                                            </a>
                                                            <a href="javascript: void(0)" class="text-danger remove-notification" data-id="<?= $value->id ?>" title="Eliminar notificación de la lista">
                                                                <div class="ml-2"><i class="fa fa-times fa-lg" aria-hidden="true"></i></div>
                                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                                <?php if (empty($notificaciones)) : ?>
                                    <li style="border-bottom: 1px solid #e3e3e3;">
                                        <div class="media" style="margin: 10px;">
                                            <a>
                                                <div class="media-body">
                                                    <h5 class="media-heading"></h5>
                                                    <p>No tiene notificaciones pendientes</p>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div style="visibility: hidden;height: 1px">
                <a href="./" class="navbar-brand" title="Capsys Web - Inicio"></a>
            </div>
            <div style="height: 100%;" id="marquesinaBanner" class="marquesinaGeneral"></div>
        </div>
        <!-- Columna del menu explandible de usuario -->
        <div class="col-md-2 col-sm-2">
            <ul id="dropdown_usuario" class="user-perfil pull-right alwaysOnTop">
                <li class="dropdown" style="float: right;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="usuario-nombre fondoNegro" style="color: black;font-family: arial;font-size: 11px;font-weight: bold;"><?= $this->tank_auth->get_usermail(); ?></span>
                        <i class="caret"></i>
                        <div class="user-perfil-extra hidden-xs" style="font-size: 11px;font-family: arial;">
                            <p style="background-color: white; width: fit-content; float: right;" class="fondoNegro">
                                <?= $this->tank_auth->get_usernamecomplete(); ?>
                                <span class="badge">
                                    <?
                                    if ($this->capsysdre->RankingUsuarioEmail($this->tank_auth->get_usermail()) != "") {
                                        $ranking = $ci->personamodelo->buscaPersonaPorCampo($idPersona, 'idpersonarankingagente');
                                        echo $ranking->idpersonarankingagente;
                                    } else {
                                        echo $this->capsysdre->NombrePerfilUsuario($this->tank_auth->get_userprofile());
                                    }
                                    ?>
                                </span>
                                <?php //print("<b>".$this->capsysdre->RankingUsuarioEmail($this->tank_auth->get_usernamecomplete())."</b>"); 
                                ?>
                                <?php  ?>
                                <?php //echo $this->tank_auth->get_usernamecomplete(); 
                                ?>
                                <?php //echo $this->tank_auth->get_usernamecomplete(); 
                                ?>
                            </p>
                        </div>
                        <img src="<?= base_url() . $foto; ?>" width="55;" alt="<?= $this->tank_auth->get_usernamecomplete() ?>" class="img-circle">

                        <!-- evalPendientes -->

                        <i id="campana" style="color:<?= $NotiPendientes[0]["result"] != '0' ? 'red' : 'blue' ?>" class="fa fa-bell" aria-hidden="true" onclick="display()"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-perfil">
                        <!-- <li><a href="<?= base_url() ?>miInfo" title="Mi Info"><i class="fa fa-user"></i> Mi Info</a></li> -->
                        <? if (in_array('configuraciones', $modulos)) { ?>
                            <!--<li><a href="configuraciones" title="Configuración"><i class="fa fa-cogs"></i> Configuración</a></li>-->
                        <? } ?>

                        <? if (in_array('credenciales', $modulos)) { ?>
                            <!--<li><a href="validaciones" title="credenciales"><i class="fa fa-cogs"></i> Credenciales</a></li>-->
                        <? } ?>
                        <li id="salir"><a href="<?= base_url() ?>auth/logout" title="Salir"><i class="fa fa-sign-out"></i> Salir</a>
                        </li>


                        <? $tipoTrabajo = $this->db->query('select tipoTrabajo from persona where idPersona=' . $idPersona)->result()[0];
                        if ($tipoTrabajo->tipoTrabajo === "Home Office" || $tipoTrabajo->tipoTrabajo === "Híbrido") {
                            echo ('<li id="salida" ><a title="Registrar salida" style="cursor: pointer;"><button onclick="registrarSalida(' . $idPersona . ')" style="all: unset;"}><i class="fa fa-clock-o"></i> Registrar salida</button></a>
                    </li>');
                        }

                        ?>
                                    
                        <!--div id="salir2" class="row" style="height: 300px; width: 500px;display: block;overflow: scroll;position: relative;left:-180%; color: white;background-color: #251047">
                            <?
                            /*$array['grupos']=1;
                            $infoPersoana=$ci->personamodelo->clasificacionUsuariosParaEnvios($array);*/
                            ?>
                            <?
                            /*=imprimirColaboradoresCabecera( $infoPersoana);*/
                            ?>
                                
                        </div-->
                
                </li>
            </ul>
            </li>
            </ul>
        </div>
    </div>

    <!-- <div id="marquesinaBanner" class="marquesinaGeneral"></div> -->
    <!--------->
    <!--Modal para felicitaciones de cumpleaños: Dennis [2021-04-22]-->
    <div class="modal fade" id="modal_cumpleanio" tabindex="-1" role="dialog" aria-labelledby="modal_cumplaniero" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_cumplaniero"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="cuerpo_cumpleanio modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!---Fin de modal de cumpleaños------>

    <!------Muestra a todas las personas que cumplen años y muestra en modal-------->
    <script>
        $(document).on("click", ".remove-notification", function() { //Dennis Castillo [2022-03-02]

            const id = $(this).data("id");
            const direccion_ = "<?= base_url() ?>";
            const ajax = $.ajax({
                type: "POST",
                url: `${direccion_}Notificaciones/updateSingle`,
                data: {
                    id: id
                },
                error: (error) => {
                    console.log(error)
                },
                success: (data) => {
                    const response = JSON.parse(data);
                    if (!response.bool) {
                        alert(response.message);
                        return false;
                    }

                    const parent = $(this).parent().parent();
                    parent.remove();
                }
            });
        });

        $(document).on("click", ".hbd_modal", function(e) { //show.bs.modal //#modal_cumpleanio //Dennis Castillo

            //e.preventDefault();
            var otro = $(this).data("idcumple");
            console.log(otro);
            var meses = {};
            meses[1] = "ENERO";
            meses[2] = "FEBRERO";
            meses[3] = "MARZO";
            meses[4] = "ABRIL";
            meses[5] = "MAYO";
            meses[6] = "JUNIO";
            meses[7] = "JULIO";
            meses[8] = "AGOSTO";
            meses[9] = "SEPTIEMBRE";
            meses[10] = "OCTUBRE";
            meses[11] = "NOVIEMBRE";
            meses[12] = "DICIEMBRE";

            $("#modal_cumplaniero").html("Compañeron que cumplen un año más de vida");
            var id_cumpleanio = otro; //$("#ref_fecha_cumple").attr("data-idcumple");
            var id_notifiacion = $(this).attr("data-notification"); //"#ref_fecha_cumple"
            var direccion = "<?= base_url() . "persona/devuelveInfoCumpleanios" ?>";
            var direccion_ = "<?= base_url() ?>";
            //console.log(id_cumpleanio);

            //Solicitud AJAX: GET
            $.ajax({
                method: "GET",
                url: direccion,
                data: {
                    "q": id_cumpleanio,
                    "r": id_notifiacion
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {

                //$(this).hide();
                alert("Ocurrio un error. Favor de contactar al departamento de sistemas\nError: " + jqXHR);

            }).done(function(resp) {

                var json_resp = JSON.parse(resp);
                var imprimeContenido = "";
                $("#modal_cumplaniero").html();

                if (json_resp.mensaje != "") {
                    $(".cuerpo_cumpleanio").html(mensaje);
                } else {

                    imprimeContenido += `
                <p>Hoy es un gran día para nuestros compañeros de trabajo: </p>
                <div class="card-deck text-center">
            `; //json_resp.comentario;

                    var li = ``;

                    for (var a in json_resp.personas_hb) {

                        var fechaN = json_resp.personas_hb[a].fechaNacimiento.split("-");
                        imprimeContenido += `
                    <div class="card border-info mb-3">
                        <img class="card-img-top" src="` + json_resp.personas_hb[a].fotoPersonal + `" alt="Hoy es su cumpleaños">
                        <div class="card-body">
                            <h5 class="card-title">` + json_resp.personas_hb[a].nombre_completo + `</h5>
                            <a href="#" class="badge badge-primary"><i class="fa fa-calendar" aria-hidden="true"></i> ` + fechaN[2] + ` de ` + meses[parseInt(fechaN[1])] + `</a>
                            <h5>Area: ` + (json_resp.personas_hb[a].area == null ? "Sin area" : json_resp.personas_hb[a].area) + `</h5>
                            <h5>Puesto: ` + (json_resp.personas_hb[a].puesto == null ? "Sin puesto" : json_resp.personas_hb[a].puesto) + `</h5>
                        </div>
                    </div>
                `;

                        li += `<a href="${direccion_}directorio?hb=${json_resp.personas_hb[a].idPersona_cumpleanio}" target="_blank" class="list-group-item"><i class="fa fa-gift" aria-hidden="true"></i>&nbsp ${json_resp.personas_hb[a].nombre_completo}</a>`;
                    }

                    imprimeContenido += `
                </div>
                <h3 class="text-center">¡FELICIDADES!</h3>
                <blockquote class="blockquote"><i class="fa fa-gift" aria-hidden="true"></i>&nbsp` + json_resp.comentario + `</blockquote>
                <div class="col-md-6"><p><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbspVisita su tarjeta de contacto.</p><div class="list-group">${li}</div></div>
            `;

                    $(".cuerpo_cumpleanio").html(imprimeContenido);
                }
            });
        });
    </script>

    <!--Muestra la parte de notificaciones en caso de que exita una evalaucion-->

    <script>
        function display() {
            if ($("#test:hidden").length) {
                $("#test").focus();
                $("#test").show();
                $("#salir").css("display", "none");
                $("#salir2").css("display", "none");
                $("#agrupa2").css("display", "none");
                updateNotificaciones();
            } else if ($("#test:visible").length) {
                $("#test").hide();
                $("#salir").css("display", "block");
                $("#salir2").css("display", "block");
                $("#agrupa2").css("display", "block");
            }
            //***Modificacion Miguel Jaime 02-12-2021**//
            setPuntualityUser('<?php echo $this->tank_auth->get_idPersona() ?>');
            //*****//
        }
        $(document).click(function() {
            $(".test").hide();
            $("#salir").css("display", "block");
            $("#salir2").css("display", "block");
            $("#agrupa2").css("display", "block");
        });

        function updateNotificaciones() {
            var id = <?= $this->tank_auth->get_idPersona() ?>;
            $.ajax('<?= base_url() ?>Notificaciones/UpdateAll', {
                type: 'POST', // http method
                data: {
                    id: id
                }, // data to submit
                success: function(data, status, xhr) {
                    $("#campana").css('color', 'blue')
                },
                error: function(jqXhr, textStatus, errorMessage) {

                }
            });
        }
    </script>


    <!--Modificacion Menu [17-03-2021]-->

    <style type="text/css">
        .collapse ul li a:hover {
            background-color: #9a9240;
        }

        #boton_desplegable {
            background-color: #fff;
            opacity: 0.8;
        }

        #boton_desplegable:hover {
            background-color: #9a9240;
            opacity: 1;
        }
    </style>



    <!--Menu Reportes Carcapital-->
    <?php
    $correoProcedente   = $this->tank_auth->get_usermail();
    $carcapital         = $this->capsysdre->GetCarcapitalxEmail($correoProcedente);
    $inducctionProgress = $ci->crmproyecto->getProspectiveAgentProgressByIdPerson($this->tank_auth->get_idPersona()); // if is prospective person
    $inducctionProgressForEmployee = $ci->personamodelo->getEmployeeById($this->tank_auth->get_idPersona()); // if is employe person
    if ((!empty($inducctionProgress) &&  $inducctionProgress->avance == "induccion") || (!empty($inducctionProgressForEmployee) && $inducctionProgressForEmployee->avance == "induccion")) { ?>
        <nav class="navbar navbar-expand-md navbar-light" style="background-color: #361666;font-size: 11px;padding-right: 0px;padding-left: 10px;padding-top: 0;padding-bottom: 0;">
            <button id="boton_desplegable" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= base_url() ?>miInfo" style="color: #fff;"><i class="glyphicon glyphicon-user"></i> MiInfo</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="<?= base_url() ?>capacita" style="color: #fff;"><i class="glyphicon glyphicon-education"></i> Cap.A.Cita </a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="<?= base_url() ?>capitalHumano" style="color: #fff;"><i class="fa fa-users"></i>Puestos</a>
                    </li>
                </ul>
        </nav>
        <?php } elseif (empty($inducctionProgress) || $inducctionProgress->avance == "liberado" || $inducctionProgress->avance == "induccion_libre") {
        if ($carcapital == '1') { ?>
            <nav class="navbar navbar-expand-md navbar-light" style="background-color: #361666;font-size: 11px;padding-right: 0px;padding-left: 10px;padding-top: 0;padding-bottom: 0;">
                <button id="boton_desplegable" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <!--Menu Reportes Carcapital-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                <i class="glyphicon glyphicon-list-alt"></i> Reportes
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">

                                <a class="dropdown-item" href="<?= base_url() ?>cobranzaEfectuada" style="color: #fff;"><i class="fa fa-usd"></i> Cobro Efectuada</a>

                                <a class="dropdown-item" href="#" style="color: #fff;">
                                    <form action="<?= base_url(); ?>buscaXfolio" method="POST" id="buscarDocumentoForm" class="form" onclick="detienePropagacion(event)">
                                        <select>
                                            <option>DOCUMENTO</option>
                                            <option>SERIE</option>
                                            <option>PLACA</option>
                                        </select>
                                        <input type="text" id="TbuscarXfolio" name="TbuscarXfolio" class="text" style="color: #000;">
                                        <button class="btn btn-primary btn-sm" name="Consulta" id="Consulta" type="submit" name="Consulta" id="Consulta" value="Buscar Poliza">Buscar Poliza</button>
                                    </form>
                                </a>
                                <a class="dropdown-item" href="<?= base_url() ?>honorarios" style="color: #fff;"><i class="fa fa-usd"></i> Honorarios</a>
                        </li>
                        <!--Car Capital-->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>cotizador" style="color: #fff;"><i class="fa fa-car"></i> CarCapital</a>
                        </li>
                    </ul>
                </div>
            </nav>
        <?php } elseif ($this->tank_auth->get_userprofile() == "6") { ?>
            <nav class="navbar navbar-expand-md navbar-light" style="background-color: #361666;font-size: 11px;padding-right: 0px;padding-left: 10px;padding-top: 0;padding-bottom: 0;">
                <button id="boton_desplegable" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                <i class="glyphicon glyphicon-list-alt"></i> Reportes
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                <a class="dropdown-item" href="#" style="color: #fff;">
                                    <form action="http://localhost/Capsys/www/V3/buscaXfolio" method="POST" class="form" id="buscarDocumentoForm" target="_blank" onclick="detienePropagacion(event)">
                                        <label class="label label-info">BUSQUEDA DE DOCUMENTO</label>
                                        <select class="form-control" name="opcionBusqueda" onchange="opcionBusquedaDocMenu(this)">
                                            <option>DOCUMENTO</option>
                                            <option>SERIE</option>
                                            <option>PLACA</option>
                                            <option>CLIENTE</option>
                                        </select>
                                        <input type="text" id="TbuscarXfolio" name="TbuscarXfolio" class="form-control" style="color: #000;">
                                        <button class="btn btn-primary btn-sm" name="Consulta" id="Consulta" type="submit" value="Buscar Poliza">Buscar Poliza</button>
                                    </form>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;" data-movil="1">
                                <i class="fa fa-cogs"></i> Actividades
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                <a class="dropdown-item" href="<?= base_url() ?>actividades" style="color: #fff;"><i class="fa fa-eye"></i> Consultar</a>
                                <?php if ($usermail != "CESCAMILLA@ASESORESCAPITAL.COM") { ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>actividades/agregar" style="color: #fff;"><i class="fa fa-plus-circle"></i> Crear</a><?php } ?>
                        </li>
                        <li><a class="dropdown-item nav-drop-item-letter" href="<?= base_url() ?>polizas/busquedas" style="color: #fff;" target="_blank"><i class="fa fa-search" aria-hidden="true" style="padding-right: 3px;"></i>Poliza</a>
                        </li>
                    </ul>
            </nav>
        <?php } else { ?>

            <!--Reportes Normal-->
            <nav id="menu" class="navbar navbar-expand-md  navbar-light" style="background-color: #361666;font-size: 11px;padding-right: 0px;padding-left: 10px;padding-top: 0;padding-bottom: 0;">
                <button id="boton_desplegable" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">



                        <!--Mi Info-->
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= base_url() ?>miInfo" style="color: #fff;"><i class="glyphicon glyphicon-user"></i> MiInfo</a>
                        </li>

                        <!--Directorio-->
                        <? if ($this->tank_auth->get_IDVend() == 0) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url() ?>directorio" style="color: #fff;"><i class="glyphicon glyphicon-indent-right"></i> Directorio</a>
                            </li>
                        <? } ?>
                        <? if ($usermail == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || $usermail == "SISTEMAS@ASESORESCAPITAL.COM" || $usermail == "CAPTURA@ASESORESCAPITAL.COM") { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url() ?>clientes/clientesModificar" style="color: #fff;">Mesa de Control</a>
                            </li>
                        <? } ?>


                        <!--Acceso especial a cuadro de mando a usuario COBRANZA@ASESORESCAPITAL.COM-->
                        <?php
                        if ($usermail == "COBRANZA@ASESORESCAPITAL.COM") { ?>
                            <li class="nav-item">
                                <a class="dropdown-item" href="<?= base_url() ?>reportes/cuadroMando" style="color: #fff;"><i class="fa fa-desktop"></i> Cuadro de Mando</a>
                            </li>
                        <?php }
                        ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                <i class="glyphicon glyphicon-list-alt"></i> Reportes
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                <a class="dropdown-item" href="<?= base_url() ?>renovaciones" style="color: #fff;"><i class="fa fa-refresh"></i> Renovaciones</a>
                                <a class="dropdown-item" href="<?= base_url() ?>produccion" style="color: #fff;"><i class="glyphicon glyphicon-briefcase"></i> Cartera</a>
                                <a class="dropdown-item" href="<?= base_url() ?>cobranzaEfectuada" style="color: #fff;"><i class="fa fa-usd"></i> Cobro Efectuada</a>
                                <a class="dropdown-item" href="<?= base_url() ?>cobranzaCancelada" style="color: #fff;"><i class="fa fa-usd"></i> Cobro Cancelada</a>

                                <?php if (
                                    $usermail == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" ||
                                    $usermail == "COORDINADORCARIBE@AGENTECAPITAL.COM" ||
                                    $usermail == "COORDINADOR@FIANZASCAPITAL.COM" ||
                                    $usermail == "COORDINADOR@CAPCAPITAL.COM.MX" ||
                                    $usermail == "COORDINADOR@ASESORESCAPITAL.COM" ||
                                    $usermail == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" ||
                                    $usermail == "COORDINADORCORPORATIVO@AGENTECAPITAL.COM" ||
                                    $usermail == "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM" ||
                                    $usermail == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" ||
                                    $usermail == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM" ||
                                    $usermail == "COORDINADOR_BAJA@CAPCAPITAL.COM.MX" ||
                                    $usermail == "DIRECTORCOMERCIAL@AGENTECAPITAL.COM" ||
                                    $usermail == "DATACENTER@AGENTECAPITAL.COM" ||
                                    $usermail == "SISTEMAS@ASESORESCAPITAL.COM" ||
                                    $usermail == "DIRECTORCOMERCIAL@AGENTECAPITAL.COM" ||
                                    $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
                                ) { ?> <!-- [2024-03-19] -->
                                    <a class="dropdown-item" href="<?= base_url() ?>reportes/rendicionDeCuentas" style="color: #fff;"><i class="glyphicon glyphicon-ok"></i> Rendicion de Cuentas</a>
                                <?php } ?>
                                <?php if ($usermail == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" || $usermail == "EJECUTIVOCOMERCIAL@FIANZASCAPITAL.COM" || $usermail == "AUXILIARCOMERCIAL@FIANZASCAPITAL.COM") { ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>reportes/reportePendienteFianzas" style="color: #fff;"><i class="fa fa-cube" aria-hidden="true"></i> Recibos Pendientes de Fianzas</a>
                                <?php } ?>

                                <a class="dropdown-item" href="#" style="color: #fff;">
                                    <form action="<?= base_url(); ?>buscaXfolio" method="POST" class="form" id="buscarDocumentoForm" target="_blank" onclick="detienePropagacion(event)">
                                        <label class="label label-info">BUSQUEDA DE DOCUMENTO</label>
                                        <select class="form-control" name="opcionBusqueda" onchange="opcionBusquedaDocMenu(this)">
                                            <option>DOCUMENTO</option>
                                            <option>SERIE</option>
                                            <option>PLACA</option>
                                            <option>CLIENTE</option>
                                        </select>
                                        <input type="text" id="TbuscarXfolio" name="TbuscarXfolio" class="form-control" class="text" style="color: #000;">
                                        <button class="btn btn-primary btn-sm" name="Consulta" id="Consulta" type="submit" name="Consulta" id="Consulta" value="Buscar Poliza">Buscar Poliza</button>
                                    </form>
                                </a>
                                <a class="dropdown-item" href="<?= base_url() ?>honorarios" style="color: #fff;"><i class="fa fa-usd"></i> Honorarios</a>
                                <?php
                                if ($this->tank_auth->get_userprofile() == "2" || $this->tank_auth->get_userprofile() == "3" || $this->tank_auth->get_userprofile() == "4") {
                                ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>flujoActividades" style="color: #fff;"><i class="fa fa-exchange"></i> Flujo de Actividades</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>reportes/reporteCitasOnline" style="color: #fff;"><i class="fa fa-users"></i> Asesores Online</a>

                                <?php }
                                if ($usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $usermail == "SERVICIOSESPECIALES@AGENTECAPITAL.COM" || $usermail == "CONTABILIDAD@AGENTECAPITAL.COM") { //ASISTENTEDIRECCION@AGENTECAPITAL.COM
                                ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>persona/inducctionProgress" style="color: #fff;"><i class="fa fa-tasks" aria-hidden="true"></i> Progreso de inducción</a>
                                <?php } ?>
                            </div>
                        </li>

                        <!--Car Capital-->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>cotizador" style="color: #fff;"><i class="fa fa-car"></i> CarCapital</a>
                        </li>
                        <?php
                        if (
                            $this->tank_auth->get_userprofile() == "2"
                            ||
                            $this->tank_auth->get_userprofile() == "3"
                            ||
                            $this->tank_auth->get_userprofile() == "4"
                        ) {
                        ?>


                            <?
                            $monitor = array('DESARROLLO@AGENTECAPITAL.COM', "DATACENTER@AGENTECAPITAL.COM", "DIRECTORGENERAL@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "CONSULTOR@CAPITALRISK.COM.MX", "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX", "COORDINADOROPERATIVO@ASESORESCAPITAL.COM", "CONTABILIDAD@AGENTECAPITAL.COM", "GERENTECOMERCIAL@AGENTECAPITAL.COM", "CAPTURA@ASESORESCAPITAL.COM");
                            $monitorComercial = array("DESARROLLO@AGENTECAPITAL.COM", "DATACENTER@AGENTECAPITAL.COM", "DIRECTORGENERAL@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX", "CONTABILIDAD@AGENTECAPITAL.COM");
                            $monitorCuadroMando = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX", "COORDINADOROPERATIVO@ASESORESCAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM");
                            $monitoPagoComTableCob = array("DESARROLLO@AGENTECAPITAL.COM", "AUDITORINTERNO@AGENTECAPITAL.COM", "DIRECTORGENERAL@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "CONSULTOR@CAPITALRISK.COM.MX", "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX", "CONTABILIDAD@AGENTECAPITAL.COM");
                            ?>

                            <?php
                            if (in_array($usermail, $monitor)) {
                            ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                        <i class="fa fa-desktop"></i> Monitor
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                        <a class="dropdown-item" href="#" onclick="mandaSemaforoActividades(event,'SemaforoActividades')" style="color: #fff;"><i class="fa fa-desktop"></i> Monitor Operativo</a>
                                        <? if ($usermail != "CAPTURA@ASESORESCAPITAL.COM") { ?>
                                            <a class="dropdown-item" href="<?= base_url() ?>ejecutivos" style="color: #fff;"><i class="fa fa-line-chart"></i> Estado Operativo</a>
                                            <a class="dropdown-item" href="<?= base_url() ?>reportes/EstadoFinanciero" style="color: #fff;"><i class="fa fa-university"></i> Estado Financiero</a>
                                            <a class="dropdown-item" href="<?= base_url() ?>presupuestos/controlPresupuesto" style="color: #fff;"><i class="fa fa-calculator"></i> Control de Presupuesto</a>
                                            <!--<a class="dropdown-item" href="<?= base_url() ?>controlAsistenciaEvento" style="color: #fff;"><i class="glyphicon glyphicon-education"></i> Monitor de Asistencia a Capaitación</a>-->
                                        <? } ?>
                                        <?php if (in_array($this->tank_auth->get_usermail(), $monitorComercial)) { ?><a class="dropdown-item" href="<?= base_url() ?>controlMetaComercial" style="color: #fff;"><i class="fa fa-flag-checkered"></i> Monitor de Metas Comerciales</a><?php } ?>

                                        <?php
                                        if (in_array($usermail, $monitoPagoComTableCob)) { ?>

                                            <a class="dropdown-item" href="<?= base_url() ?>reportes/pagoCompania" style="color: #fff;"><i class="fa fa-usd"></i> Pago de Compañias</a>
                                            <a class="dropdown-item" href="<?= base_url() ?>cobranzakpi" style="color: #fff;"><i class="fa fa-usd"></i> Tablero de Cobranza</a>
                                        <?php }
                                        if (in_array($usermail, $monitorCuadroMando)) { ?><a class="dropdown-item" href="<?= base_url() ?>reportes/cuadroMando" style="color: #fff;"><i class="fa fa-desktop"></i> Cuadro de Mando</a>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                            <form method="post" action="<?= base_url() ?>monitores/verMonitor" id="enviarFormMonitor">
                                <input type="hidden" name="monitorear" id="monitorearMenu">
                            </form>
                            <script>
                                function mandaSemaforoActividades(objeto, vista) {
                                    objeto.preventDefault();
                                    document.getElementById('monitorearMenu').value = vista;
                                    document.getElementById('enviarFormMonitor').submit();
                                }
                            </script>
                        <?php
                        }
                        ?>

                        <!--Actividades-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;" data-movil="1">
                                <i class="fa fa-cogs"></i> Actividades
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                <a class="dropdown-item" href="<?= base_url() ?>actividades" style="color: #fff;"><i class="fa fa-eye"></i> Consultar</a>
                                <?php if ($usermail != "CESCAMILLA@ASESORESCAPITAL.COM") { ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>actividades/agregar" style="color: #fff;"><i class="fa fa-plus-circle"></i> Crear</a>
                                <?php }

                                if ($usermail == "DESARROLLO@AGENTECAPITAL.COM" || $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $usermail == "SISTEMAS@ASESORESCAPITAL.COM" || $usermail == "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX" || $usermail == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM" || $usermail == "AUDITORINTERNO@AGENTECAPITAL.COM" || $usermail == "CONSULTOR@CAPITALRISK.COM.MX" || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $usermail == "SERVICIOSESPECIALES@AGENTECAPITAL.COM") {
                                ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>actividades/importante" style="color: #fff;"><i class="fa fa-exclamation-triangle"></i> Importantes</a>
                                <?php
                                }
                                if ($usermail == "DESARROLLO@AGENTECAPITAL.COM" || $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $usermail == "SISTEMAS@ASESORESCAPITAL.COM" || $usermail == "CONSULTOR@CAPITALRISK.COM.MX" || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM") {
                                }
                                ?>
                                <?php
                                if ($usermail == "DESARROLLO@AGENTECAPITAL.COM" || $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $usermail == "SISTEMAS@ASESORESCAPITAL.COM" || $usermail == "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX" || $usermail == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM" || $usermail == "CONSULTOR@CAPITALRISK.COM.MX" || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $usermail == "SERVICIOSESPECIALES@AGENTECAPITAL.COM" || $usermail == "GERENTECOMERCIAL@AGENTECAPITAL.COM" || $usermail == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM") {
                                ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>actividades/correosImportantes" style="color: #fff;"><i class="fa fa-envelope"></i> Correos importantes</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>actividades/consultaActividades" style="color: #fff;"><i class="fa fa-search"></i> Consulta de actividades</a>
                                <?php
                                }
                                ?>
                                <a class="dropdown-item" href="<?= base_url() ?>cobranza" style="color: #fff;" target="_blank"><i class="fa fa-usd"></i> Cobranza</a>
                                <a class="dropdown-item" href="<?= base_url() ?>cobranza/renovacion" style="color: #fff;"><i class="fa fa-usd"></i> Renovaciones</a>
                            </div>
                        </li>

                        <!--Accesorios-->
                      <??>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                <i class="fa fa-wrench"></i> Accesorios
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                <a class="dropdown-item" href="<?= base_url() ?>tienda" style="color: #fff;"><i class="fa fa-shopping-basket"></i> Tienda</a>
                                <?php if (in_array($this->tank_auth->get_usermail(), ["DIRECTORGENERAL@AGENTECAPITAL.COM", "DESARROLLO@AGENTECAPITAL.COM"])) { ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>calendario/diary" style="color: #fff;"><i class="fa fa-calendar"></i> Agenda (prototipo)</a>
                                <?php } ?>
                                <a class="dropdown-item" href="<?= base_url() ?>capacita" style="color: #fff;"><i class="glyphicon glyphicon-education"></i> Cap.A.Cita </a>
                                <?
                                      $usuariosPermitidosEmailMasivo=array('DIRECTORGENERAL@AGENTECAPITAL.COM','GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX','DIRECTORCOMERCIAL@AGENTECAPITAL.COM','MARKETING@AGENTECAPITAL.COM','ASISTENTEDIRECCION@AGENTECAPITAL.COM','GERENTECOMERCIAL@AGENTECAPITAL.COM');
                                      if(in_array($usermail,$usuariosPermitidosEmailMasivo))
                                      {
                                ?>
                                <a class="dropdown-item" href="<?= base_url() ?>mailMasivo" style="color: #fff;"><i class="fa fa-envelope"></i> Mail</a>
                                <? } ?>
                                <!--<a class="dropdown-item" href="<?= base_url() ?>ListaAsistencia" style="color: #fff;"><i class="fa fa-edit"></i> Lista de Asistencia</a>-->
                                <a class="dropdown-item" href="<?= base_url() ?>cproyecto" style="color: #fff;"><i class="fa fa-calendar-check-o"></i> Seguimiento</a>
                                <a class="dropdown-item" href="<?= base_url() ?>calendario/index" style="color: #fff;"><i class="fa fa-calendar"></i> Ver Agenda</a>
                                <a class="dropdown-item" href="<?= base_url() ?>imagenesMkt" style="color: #fff;"><i class="fa fa-picture-o"></i> Imagenes marketing</a>
                                <a class="dropdown-item" href="<?= base_url() ?>prospectoAgente" style="color: #fff;"><i class="fa fa-cogs"></i> Prospectos agentes</a>
                                <? if ($this->tank_auth->get_IDVend() == 0) { ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>procesamientoNC" style="color: #fff;"><i class="fa fa-heartbeat"></i>Modulo de Calidad</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>calificacionAgente/valoracion"
                                        style="color: #fff;"><i class="fa fa-edit"></i> Evaluaciones Agentes</a>
                                <? } ?>
                                <?php
                                $email    = $this->tank_auth->get_usermail();
                                if ($email == "SISTEMAS@ASESORESCAPITAL.COM" || $email == "AUDITORINTERNO@AGENTECAPITAL.COM" || $email == "CAPITALHUMANO@AGENTECAPITAL.COM" || $email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "PROYECTO@AGENTECAPITAL.COM.MX" || $usermail == "CONSULTOR@CAPITALRISK.COM.MX" || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $usermail == "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX" || $email == "DATACENTER@AGENTECAPITAL.COM" || $email == 'COORDINADOROPERATIVO@ASESORESCAPITAL.COM' || $email == 'MARKETING@AGENTECAPITAL.COM' || $email == 'GERENTECOMERCIAL@AGENTECAPITAL.COM' || $email == "DIRECTORCOMERCIAL@AGENTECAPITAL.COM" || $email == "COORDINADOR@CAPCAPITAL.COM.MX" || $email == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || $email == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" || $email == "MARKETING@AGENTECAPITAL.COM" || $email == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" || $email == "COORDINADORCORPORATIVO@AGENTECAPITAL.COM") {
                                ?>


                                    <a class="dropdown-item" href="<?= base_url() ?>permisosOperativos" style="color: #fff;"><i class="fa fa-cogs"></i> Configuraciónes </a>
                                    <? if ($usermail != "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX" && $usermail != 'MARKETING@AGENTECAPITAL.COM') {
                                        if ($email == "SISTEMAS@ASESORESCAPITAL.COM" || $email == "AUDITORINTERNO@AGENTECAPITAL.COM" || $email == "CAPITALHUMANO@AGENTECAPITAL.COM" || $email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "PROYECTO@AGENTECAPITAL.COM.MX" || $usermail == "CONSULTOR@CAPITALRISK.COM.MX" || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $usermail == 'COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM') { ?>
                                            <!--a class="dropdown-item" href="<?= base_url() ?>procesamientoNC" style="color: #fff;"><i class="fa fa-heartbeat"></i>Modulo de Calidad</a-->
                                            <a class="dropdown-item" href="<?= base_url() ?>encuesta/" style="color: #fff;"><i class="fa fa-edit"></i> Encuestas</a>
                                            <a class="dropdown-item" href="<?= base_url() ?>encuesta/encuestaExtra" style="color: #fff;"><i class="fa fa-edit"></i> Encuesta Extra</a>
                                        <?php } ?>

                                        <a class="dropdown-item" href="<?= base_url() ?>clientes" style="color: #fff;"><i class="fa fa-users"></i> Clientes</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>clientes/manageClients" style="color: #fff;"><i class="fa fa-users"></i> Unificar clientes</a>
                                    <?php } ?>
                                    <? if ($email == "MARKETING@AGENTECAPITAL.COM") { ?>
                                        <a class="dropdown-item" href="<?= base_url() ?>siniestros/encuestas" style="color: #fff;"><i class="fa fa-edit"></i> Encuestas Siniestros</a>
                                    <? } ?>
                                <?php } ?>

                                <a class="dropdown-item" href="<?= base_url() ?>controlAsistenciaEvento" style="color: #fff;"><i class="glyphicon glyphicon-education"></i> Monitor de Asistencia a Capaitación</a>

                                <?php if (in_array($usermail, array("CONTABILIDAD@AGENTECAPITAL.COM", "ASISTENTEDIRECCION@AGENTECAPITAL.COM"))) { ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>persona/manageSupportLinks" style="color: #fff;"><i class="fa fa-tasks" aria-hidden="true"></i> Gestión de ligas de apoyo en documentación</a>
                                <?php } ?>

                                <!--Submenu-->
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                    <i class="fa fa-calendar"></i> Convocar Reuniones
                                </a>
                                <? if ($this->tank_auth->get_IDVend() > 0) { ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>Danos" style="color: #fff;"><i class="fa fa-wrench"></i> Daños</a>
                                <? } ?>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #2a4e83;font-size: 12px;opacity: 0.8">
                                    <a class="dropdown-item" href="<?= base_url() ?>calendario/index" style="color: #fff;"><i class="fa fa-cogs"></i> Crear reunion</a>
                                    <!--<a class="dropdown-item" href="<?= base_url() ?>crearLiga/crear_liga_reunion_enviados" style="color: #fff;"><i class="fa fa-list"></i> Consultar reuniones </a>-->
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>binconformidad" style="color: #fff;"><i class="fa fa-envelope-o"></i> Inconformidades</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>crmproyecto/proyecto100" style="color: #fff;"><i class="fa fa-user-plus"></i>Prospección</a>
                        </li>


                        <? if ($this->tank_auth->get_IDVend() > 0) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                    <i class="fa fa-calculator"></i>Siniestro
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                    <a class="dropdown-item" href="<?= base_url() ?>Danos" style="color: #fff;"><i class="fa fa-wrench"></i> Daños</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>GMM" style="color: #fff;"><i class="fa fa-heartbeat"></i> GMM</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>Autos" style="color: #fff;"><i class="fa fa-car"></i> Autos individual</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>siniestros/archivos" style="color: #fff;"><i class="fas fa-cloud-upload-alt"></i> Archivos</a><!-- [Suemy][2024-05-21] -->
                                </div>
                            </li>

                        <? } ?>

                        <li class="nav-item dropdown n-Polizas">
                            <a class="dropdown-item nav-drop-item-letter" href="<?= base_url() ?>polizas/busquedas" style="color: #fff;" target="_blank"><i class="fa fa-search" aria-hidden="true" style="padding-right: 3px;"></i>Poliza</a>

                        </li>

                        <? if ($usermail == "SISTEMAS@ASESORESCAPITAL.COM" || $usermail == "CONTABILIDAD@AGENTECAPITAL.COM" || $usermail == "DATACENTER@AGENTECAPITAL.COM") { ?>
                            <li class="nav-item">
                                <a class="dropdown-item" href="<?= base_url() ?>ReportePresupuesto/reporteDetalleBancos" style="color: #fff;"><i class="fa fa-money"></i>REPORTE GENERAL</a>
                            </li>

                        <? } ?>

                        <?php
                        if (
                            $usermail == "DESARROLLO@AGENTECAPITAL.COM" || $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $usermail == "SISTEMAS@ASESORESCAPITAL.COM" ||
                            $usermail == "MARKETING@AGENTECAPITAL.COM" || $usermail == "CONSULTOR@CAPITALRISK.COM.MX" ||  $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $usermail == "SERVICIOSESPECIALES@AGENTECAPITAL.COM" || $usermail == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || $usermail == "EJECUTIVOMKT@AGENTECAPITAL.COM" || $usermail == "COMMUNITY@AGENTECAPITAL.COM"
                        ) {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                    <i class="fa fa-picture-o"></i> Marketing
                                </a>
                                <ul class="dropdown-menu" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                    <li> <a class="dropdown-item" href="<?= base_url() ?>persona/activarTarjetaDigital" style="color: #fff;"><i class="fa fa-mobile"></i> Tarjetas Digitales</a></li>
                                    <li> <a class="dropdown-item" href="<?= base_url() ?>crearLiga/crear_liga_asesores" style="color: #fff;"><i class="fa fa-exchange"></i> Liga Asesores </a></li>
                                    <li> <a class="dropdown-item" href="<?= base_url() ?>lealtadClientes" style="color: #fff;"><i class="glyphicon glyphicon-book"></i> Lealtad Clientes</a></li>
                                    <li> <a class="dropdown-item" href="<?= base_url() ?>lealtadClientes" style="color: #fff;"><i class="fa fa-mobile"></i> SMS</a></li>

                                    <!--MODIFICACION MJ 12/2021-->
                                    <li> <a class="dropdown-item" href="<?= base_url() ?>estadisticas_marketing/init" style="color: #fff;"><i class="fa fa-bar-chart"></i> Estadisticas Marketing</a></li>

                                    <div class="dropdown-divider"></div>
                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #fff;"> <span class="nav-label"><i class="fa fa-picture-o"></i> TeleMarketing</span></a>

                                        <ul>
                                            <li style="margin-left:-25px;margin-top: 5px;margin-bottom: 5px;"><a href="<?= base_url() ?>callcenter" style="color: #fff;"><i class="fa fa-cogs"></i> Proceso TeleMarketing</a></li>
                                            <li style="margin-left:-25px;margin-top: 5px;margin-bottom: 8px;"><a href="#"><a href="<?= base_url() ?>callcenter/Reportes" style="color: #fff;"><i class="fa fa-edit"></i> Edición Prospectos </a></a></li>
                                            <li style="margin-left:-25px;margin-top: 5px;margin-bottom: 8px;"><a href="#"><a href="<?= base_url() ?>prospectoAgente" style="color: #fff;"><i class="fa fa-cogs"></i> Prospectos Agentes </a></a></li>
                                        </ul>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li class="dropdown-submenu" style="width: 115%;">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #fff;"> <span class="nav-label"><i class="fa fa-shopping-basket"></i> Catalago Tienda</span></a>
                                        <ul>
                                            <li style="margin-top: 5px;margin-bottom: 5px;"><a href="<?= base_url() ?>tienda/articulosAgregar" style="color: #fff;"><i class="fa fa-plus-square"></i> Agregar Articulo</a></li>
                                            <li style="margin-top: 5px;margin-bottom: 8px;"><a href="#"><a href="<?= base_url() ?>tienda/articulosModificar" style="color: #fff;"><i class="fa fa-edit"></i> Modificar Articulo </a></li>
                                        </ul>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li class="dropdown-submenu" style="width: 115%;">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #fff;"> <span class="nav-label"> <i class="fa fa-picture-o"></i> Banners</span></a>
                                        <ul>
                                            <li style="margin-top: 5px;margin-bottom: 5px;"><a href="<?= base_url() ?>banners/slideInicio" style="color: #fff;"><i class="fa fa-plus-square"></i> Slide de Inicio</a></li>
                                            <li style="margin-top: 5px;margin-bottom: 8px;"><a href="<?= base_url() ?>banners/fijos" style="color: #fff;"><i class="fa fa-plus-square"></i> Fijos</a></li>
                                            <li style="margin-top: 5px;margin-bottom: 8px;"><a href="<?= base_url() ?>banners/micrositios" style="color: #fff;"><i class="fa fa-plus-square"></i> Micrositios</a></li>
                                        </ul>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li class="dropdown-submenu" style="width: 115%;">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #fff;"> <span class="nav-label"> <i class="fa fa-picture-o"></i> Imagenes</span></a>
                                        <ul>
                                            <li style="margin-top: 5px;margin-bottom: 8px;"><a href="<?= base_url() ?>imagenesMkt" style="color: #fff;"><i class="fa fa-plus-square"></i> Repositorio imagen</a></li>
                                            <li style="margin-top: 5px;margin-bottom: 5px;"><a href="<?= base_url() ?>imagenesMkt/imagenesAgregar" style="color: #fff;"><i class="fa fa-plus-square"></i> Agregar imagen</a></li>
                                            <li style="margin-top: 5px;margin-bottom: 8px;"><a href="<?= base_url() ?>imagenesMkt/imagenesModificar" style="color: #fff;"><i class="fa fa-plus-square"></i> Modificar imagen</a></li>


                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>
                        <!--Presupuesto-->
                        <?php
                        $sqlConsultapermiso        = "select count(up.usuario) as resul from usuariospresupuesto up where up.usuario='" . $usermail . "'";
                        $queryConsultapermiso    = $this->db->query($sqlConsultapermiso);
                        if ($queryConsultapermiso != FALSE) {
                            foreach ($queryConsultapermiso->result() as $row) {
                                $totalResultados = $row->resul;
                            }
                        }
                        if ($totalResultados > '0') {
                        ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                    <i class="fa fa-calculator"></i>Presupuesto
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                    <a class="dropdown-item" href="<?= base_url() ?>presupuestos" style="color: #fff;"><i class="fa fa-user"></i> Proveedores </a>
                                    <a class="dropdown-item" href="<?= base_url() ?>presupuestos/Vistafacturas" style="color: #fff;"><i class="fa fa-plus-square"></i> Agregar Facturas</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>presupuestos/VistafacturasTodas" style="color: #fff;"><i class="fa fa-file-text"></i> Facturas</a>
                                    <?php
                                    if (
                                        $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
                                        ||
                                        $usermail == "SISTEMAS@ASESORESCAPITAL.COM"
                                        ||
                                        $usermail == "CONTABILIDAD@AGENTECAPITAL.COM"
                                        ||
                                        $usermail == "CONSULTOR@CAPITALRISK.COM.MX"
                                        || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"
                                        || $usermail == "ASISTENTEGENERAL@AGENTECAPITAL.COM"
                                        || $usermail == "AUDITORINTERNO@AGENTECAPITAL.COM"
                                        || $usermail == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"
                                        || $usermail == "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX"
                                        || $usermail == "SERVICIOSESPECIALES@AGENTECAPITAL.COM"
                                    ) {
                                    ?>
                                        <a class="dropdown-item" href="<?= base_url() ?>presupuestos/Validaf" style="color: #fff;"><i class="fa fa-check-square-o"></i> Validar Factura</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>contabilidad" style="color: #fff;"><i class="fa fa-bar-chart"></i> Contabilidad</a>
                                    <? } ?>
                                    <?
                                    if (
                                        $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
                                        ||
                                        $usermail == "SISTEMAS@ASESORESCAPITAL.COM"
                                        ||
                                        $usermail == "ASISTENTEGENERAL@AGENTECAPITAL.COM"
                                        ||
                                        $usermail == "CONSULTOR@CAPITALRISK.COM.MX"
                                        || $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"
                                        || $usermail == "SERVICIOSESPECIALES@AGENTECAPITAL.COM"
                                        || $usermail == "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX"
                                        || $usermail == "CONTABILIDAD@AGENTECAPITAL.COM"
                                    ) {
                                    ?>
                                        <a class="dropdown-item" href="<?= base_url() ?>cheques" style="color: #fff;"><i class="glyphicon glyphicon-save-file"></i> Depositos</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>presupuestos/AutorizaPago" style="color: #fff;"><i class="fa fa-check-square-o"></i> Autorizar Pago</a>
                                    <? }
                                    if (
                                        $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM"
                                        ||
                                        $usermail == "SISTEMAS@ASESORESCAPITAL.COM"
                                        ||
                                        $usermail == "ASISTENTEGENERAL@AGENTECAPITAL.COM"
                                        ||
                                        $usermail == "CONSULTOR@CAPITALRISK.COM.MX"
                                        ||
                                        $usermail == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"
                                        || $usermail == "SERVICIOSESPECIALES@AGENTECAPITAL.COM"
                                        ||
                                        $usermail == "CONTABILIDAD@AGENTECAPITAL.COM"
                                        || $usermail == "AUDITORINTERNO@AGENTECAPITAL.COM"
                                        || $usermail == "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX"
                                    ) {
                                    ?>
                                        <a class="dropdown-item" href="<?= base_url() ?>presupuestos/ListaPagosAutorizar" style="color: #fff;"><i class="fa fa-money"></i> Aplicar Pago</a>

                                        <a class="dropdown-item" href="<?= base_url() ?>ReportePresupuesto" style="color: #fff;"><i class="fa fa-pie-chart"></i> Reportes</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>cheques/promotoria" style="color: #fff;"><i class="fa fa-money"></i>Promotoria</a>
                                    <? } ?>


                                <? }
                            if (
                                $usermail == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $usermail == "ASISTENTEGENERAL@AGENTECAPITAL.COM" || $usermail == "CCO@AGENTECAPITAL.COM"  || $usermail == "CONTABILIDAD@AGENTECAPITAL.COM" || $usermail == "GERENTEOPERATIVO@AGENTECAPITAL.COM"
                            ) {
                                ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>cheques/bancosDepositos" style="color: #fff;"><i class="fa fa-money"></i>Depositos de Bancos</a>



                                </div>
                            </li>
                        <?php
                            }

                            if ($permisosCH) {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                    <i class="fa fa-calculator"></i>Capital Humano
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">

                                    <a class="dropdown-item" href="<?= base_url() ?>capitalHumano" style="color: #fff;"><i class="fa fa-users"></i> Puestos</a>
                                    <? if ($permisosCoordinador) { ?>
                                        <a class="dropdown-item" href="<?= base_url() ?>persona/agente" style="color: #fff;"><i class="fa fa-users"></i> Alta usuarios</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>persona/asesores" style="color: #fff;"><i class="fa fa-users"></i> Alta Asesores Capital</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>periodo" style="color: #fff;"><i class="fa fa-users"></i> Evaluaciones</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>PIP/0" style="color: #fff;"><i class="fa fa-users"></i> PIP</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>Bonos" style="color: #fff;"><i class="fa fa-users"></i> Bonos</a>
                                    <? } ?>
                                    <a class="dropdown-item" href="<?= base_url() ?>incidencias" style="color: #fff;"><i class="fa fa-users"></i> Incidencias</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>fastFile/prestamos" style="color: #fff;"><i class="fa fa-money"></i> Prestamos</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>fastFile/vacaciones" style="color: #fff;"><i class="fa fa-plane"></i> Vacaciones</a>
                                    <a class="dropdown-item" href="<?= base_url() ?>fastFile/asistencia" style="color: #fff;"><i class="fa fa-clock-o"></i> Asistencias</a>
                                </div>
                            </li>



                            <?php if (
                                    $usermail == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" ||
                                    $usermail == "COORDINADORCARIBE@AGENTECAPITAL.COM" ||
                                    $usermail == "COORDINADOR@FIANZASCAPITAL.COM" ||
                                    $usermail == "COORDINADOR@CAPCAPITAL.COM.MX" ||
                                    $usermail == "COORDINADOR@ASESORESCAPITAL.COM" ||
                                    $usermail == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" ||
                                    $usermail == "COORDINADORCORPORATIVO@AGENTECAPITAL.COM" ||
                                    $usermail == "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM" ||
                                    $usermail == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" ||
                                    $usermail == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM" ||
                                    $usermail == "COORDINADOR_BAJA@CAPCAPITAL.COM.MX"
                                ) { ?>

                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url() ?>metacomercial" style="color: #fff;"><i class="fa fa-flag-checkered"></i>Asigna mensualidad MC</a>
                                </li>
                            <?php }
                                $email    = $this->tank_auth->get_usermail();
                                if (
                                    $email == "BorrarSISTEMAS@ASESORESCAPITAL.COM" || $email == "BorrarAUDITORINTERNO@AGENTECAPITAL.COM" || $email == "BorrarCAPITALHUMANO@AGENTECAPITAL.COM" || $email == "BorrarDIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "BorrarPROYECTO@AGENTECAPITAL.COM.MX" || $usermail == "BorrarCONSULTOR@CAPITALRISK.COM.MX" || $usermail == "BorrarASISTENTEDIRECCION@AGENTECAPITAL.COM" || $usermail == "BorrarGERENTEFINANCIERO@CAPITALSEGUROS.COM.MX"
                                    || $email == "BorrarDATACENTER@AGENTECAPITAL.COM"
                                ) {
                            ?>
                                <!-- SE DEBE ELIMINAR ESTE MENU DE CAPITAL HUMANO YA QUE PASO EN ACCESORIOS POR EL MOMENTO NO BORRO EL CODIGO -->
                                <!--Auditoria-->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                        <i class="fa fa-edit"></i>Auditoria
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                        <a class="dropdown-item" href="<?= base_url() ?>permisosOperativos" style="color: #fff;"><i class="fa fa-cogs"></i> Configuraciónes </a>
                                        <? if ($usermail != "GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX") { ?>
                                            <a class="dropdown-item" href="<?= base_url() ?>clientes" style="color: #fff;"><i class="fa fa-users"></i> Clientes</a>
                                            <a class="dropdown-item" href="<?= base_url() ?>clientes/manageClients" style="color: #fff;"><i class="fa fa-users"></i> Unificar clientes</a>
                                            <!--Submenu-->
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                                <i class="fa fa-picture-o"></i> Modulo de Calidad
                                            </a><!--Pendiente-->
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #2a4e83;font-size: 12px;">
                                                <a class="dropdown-item" href="<?= base_url() ?>procesamientoNC" style="color: #fff;"><i class="fa fa-heartbeat"></i> Incidencias</a>
                                                <a class="dropdown-item" href="<?= base_url() ?>encuesta/" style="color: #fff;"><i class="fa fa-edit"></i> Encuestas</a>
                                                <a class="dropdown-item" href="<?= base_url() ?>encuesta/encuestaExtra" style="color: #fff;"><i class="fa fa-edit"></i> Encuesta Extra</a>
                                            </div>
                                        <? } ?>
                                    </div>
                                </li>
                            <?php } ?>


                            <?
                                if ($email == "SISTEMAS@ASESORESCAPITAL.COM" || $email == 'COORDINADOROPERATIVO@ASESORESCAPITAL.COM') {
                                    //$this->load->view('directorio/ventanaConsulta');
                                    // get_IDVend() 
                                }

                            ?>


                            <!------------------ INICIO cambios TIC CONSULTORES / 26-04-2021 ------------------------->
                            <?php
                                $email    = $this->tank_auth->get_usermail();
                                if ($email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX" || $email == "COORDINADORCORPORATIVO@AGENTECAPITAL.COM" || $email == "SINIESTROSBIENES@AGENTECAPITAL.COM" || $email == "SINIESTROSPERSONAS@AGENTECAPITAL.COM" || $email == "SINIESTROS2@AGENTECAPITAL.COM" || $email == "SINIESTROSAUTOS@AGENTECAPITAL.COM" || $email == "EJECUTIVOCORPORATIVO@AGENTECAPITAL.COM" || $email == "EJECUTIVOADMI@AGENTECAPITAL.COM" || $email == "MESADECONTROL@CAPITALSEGUROS.COM.MX" || $email == "SINIESTROS3@AGENTECAPITAL.COM" || $email == "SINIESTROSLEGAL@AGENTECAPITAL.COM" || $email == 'COORDINADOROPERATIVO@ASESORESCAPITAL.COM' || $email == 'SOPORTEOPERATIVO@ASESORESCAPITAL.COM' || $email == 'SOPORTEGMM@AGENTECAPITAL.COM' )
{
                            ?>
                            
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                                        <i class="fa fa-bolt"></i> Siniestros
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #361666;font-size: 12px;opacity: 0.9">
                                        <?php
                                        if ($email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX" || $email == "SINIESTROSBIENES@AGENTECAPITAL.COM" || $email == "SINIESTROSPERSONAS@AGENTECAPITAL.COM" || $email == "MESADECONTROL@CAPITALSEGUROS.COM.MX" || $email == "SINIESTROS3@AGENTECAPITAL.COM" || $email == 'COORDINADOROPERATIVO@ASESORESCAPITAL.COM' || $email == 'SOPORTEOPERATIVO@ASESORESCAPITAL.COM' || $email == 'SOPORTEGMM@AGENTECAPITAL.COM' || $email == "EJECUTIVOCORPORATIVO@AGENTECAPITAL.COM")  {
                                        ?>
                                            <a class="dropdown-item" href="<?= base_url() ?>Danos" style="color: #fff;"><i class="fa fa-wrench"></i> Daños</a>
                                            <a class="dropdown-item" href="<?= base_url() ?>GMM" style="color: #fff;"><i class="fa fa-heartbeat"></i> GMM</a>
                                            <a class="dropdown-item" href="<?= base_url() ?>Autos" style="color: #fff;"><i class="fa fa-car"></i> Autos individual</a>
                                        <?php } ?>
                                        <a class="dropdown-item" href="<?= base_url() ?>siniestroCorporativo" style="color: #fff;"><i class="fa fa-car"></i> Autos corporativo</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>tableros_siniestros" style="color: #fff;"><i class="fa fa-bar-chart"></i> Tableros</a>
                                        <!--  <a class="dropdown-item" href="<?= base_url() ?>GMM/siniestro_estatus" style="color: #fff;"><i class="glyphicon glyphicon-list-alt"></i> Catálogos</a> -->
                                        <a class="dropdown-item" href="<?= base_url() ?>siniestros/archivos" style="color: #fff;"><i class="fas fa-cloud-upload-alt"></i> Archivos</a><!-- [Suemy][2024-05-21] -->
                                    </div>
                               
                            </li>
                
            <?php } ?>
            <?php if(in_array($usermail,$usuarios_servicios_sicas) ){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url()?>servicioSistema" style="color: #fff;"><i class="fa fa-wrench"></i> Servicio</a>
                </li>
            <?php } ?>
            <!-------------------------------------------------------- FIN cambios TIC CONSULTORES / 26-04-2021 ------------------------------------>
        <?php } ?>
                          <li class="nav-item">
                    <a class="nav-link" href="https://v3consultas.capsys.com.mx/V3/auth/login" style="color: #fff;" target="_blank"><i class="fa"></i> Consulta</a>
                </li>  
        </ul>
        </div>
            </nav>
    <?php }
    }
    ?>
    <!--FIn Modificacion Menu [17-03-2021]-->


</header>

<?php
if ($this->uri->segment(1) == "crmproyecto" || $this->uri->segment(1) == "funnel") {
    $bannerCicloV = TRUE;
?>
    <div id="marquesinaCiclo" class="marquesinaGeneral"></div>
<?php
} else {
    $bannerCicloV = "0";
}
?>

<style type="text/css">
    #ventana-flotanteBL {
        width: 90%;
        height: 90%;
        background: white;
        position: absolute;
        top: 10px;
        left: 5%;
        box-shadow: 0 5px 25px rgba(0, 0, 0, .1);
        /* Sombra */
        z-index: 999999;
        overflow: scroll;
        padding-bottom: 50px;
        padding-top: 50px;
        bottom: 200px;
    }

    .ver {
        visibility: visible;
    }

    #ventana-flotanteBL .cerrar {
        float: right;
        border-bottom: 1px solid #bbb;
        border-left: 1px solid #bbb;
        color: #999;
        background: red;
        line-height: 17px;
        text-decoration: none;
        padding: 0px 14px;
        font-family: Arial;
        border-radius: 0 0 0 5px;
        box-shadow: -1px 1px white;
        font-size: 18px;
        -webkit-transition: .3s;
        -moz-transition: .3s;
        -o-transition: .3s;
        -ms-transition: .3s;
    }

    #ventana-flotanteBL .cerrar:hover {
        background: #ff6868;
        color: white;
        text-decoration: none;
        text-shadow: -1px -1px red;
        border-bottom: 1px solid red;
        border-left: 1px solid red;
    }

    .ocultoInicio {
        visibility: hidden;
    }

    .oculto {
        -webkit-transition: 1s;
        -moz-transition: 1s;
        -o-transition: 1s;
        -ms-transition: 1s;
        opacity: 0;
        -ms-opacity: 0;
        -moz-opacity: 0;
        visibility: hidden;
    }

    .marquesinaGeneral {
        width: 100%;
        height: 100px;
        background-color: #361866;
        background-size: 100% 90%;
        background-repeat: no-repeat;
    }
</style>


<script>
    var bannerCicloV = <?= $bannerCicloV ?>;
    var globalMarquesina = 0;
    setTimeout(marquesinaJS, 30000);
    if (document.getElementById('marquesinaBanner')) {
        document.getElementById('marquesinaBanner').style.backgroundImage = "url('<?= base_url() ?>assets/imgBanner/B1/F-1366x100.png')";
    }
    if (bannerCicloV) {
        document.getElementById('marquesinaCiclo').style.backgroundImage = "url('<?= base_url() ?>assets/imgBanner/B_CICLO_VENTA/BANNER_CICLO_1366x100.png')";
    }

    globalMarquesina = 1;

    function marquesinaJS() {
        var w = window.outerWidth;
        var h = window.outerHeight;
        switch (globalMarquesina) {
            case 0:
                document.getElementById('marquesinaBanner').style.backgroundImage = "url('<?= $imgBanner_Marq_0 ?>')";
                if (bannerCicloV) {
                    document.getElementById('marquesinaCiclo').style.backgroundImage = "url('<?= $imgBanner_CicVenta ?>')";
                }
                globalMarquesina++;
                break;

            case 1:
                document.getElementById('marquesinaBanner').style.backgroundImage = "url('<?= $imgBanner_Marq_1 ?>')";
                if (bannerCicloV) {
                    document.getElementById('marquesinaCiclo').style.backgroundImage = "url('<?= $imgBanner_CicVenta ?>')";
                }
                globalMarquesina++;
                break;

            case 2:
                document.getElementById('marquesinaBanner').style.backgroundImage = "url('<?= $imgBanner_Marq_2 ?>')";
                if (bannerCicloV) {
                    document.getElementById('marquesinaCiclo').style.backgroundImage = "url('<?= $imgBanner_CicVenta ?>')";
                }
                globalMarquesina++;
                break;

            case 3:
                document.getElementById('marquesinaBanner').style.backgroundImage = "url('<?= $imgBanner_Marq_3 ?>')";
                if (bannerCicloV) {
                    document.getElementById('marquesinaCiclo').style.backgroundImage = "url('<?= $imgBanner_CicVenta ?>')";
                }
                globalMarquesina = 0;
                break;
        }
        setTimeout(marquesinaJS, 30000);
    }


    var globalAnchoPantalla = 0;
    //window.addEventListener("resize", redimensionarMenu, true)
    //window.addEventListener("load", redimensionarMenu, true)

    function redimensionarMenu() {
        var anchoPantalla = (window.innerWidth);
        if (globalAnchoPantalla != anchoPantalla) {
            var menu = document.getElementsByClassName('miUL');
            var cantBtn = menu.length;
            var anchoBtn = 200;
            var flecha = "";
            var band0 = 0;
            var stringDiv = "";
            menu[cantBtn - 1].classList.add("miULVisible");

            if (screen.width >= 1000) {
                if (anchoPantalla >= 600) {
                    for (var i = 0; i < cantBtn; i++) {
                        flecha = "";
                        menu[i].classList.remove("miULOculta");
                        menu[i].classList.add("miULVisible");
                        if (band0 == 0) {
                            if ((anchoBtn + menu[i].clientWidth) < anchoPantalla) {
                                anchoBtn = anchoBtn + menu[i].clientWidth + 10;
                            } else {
                                menu[i].classList.remove("miULVisible");
                                menu[i].classList.add("miULOculta");
                                stringDiv = stringDiv + '<ul class="divmiULocultar" onclick="muestraContenidSubMenu(this,event)">' + menu[i].innerHTML + flecha + '</ul>';
                                band0 = 1;
                            }
                        } else {
                            menu[i].classList.remove("miULVisible");
                            menu[i].classList.add("miULOculta");
                            stringDiv = stringDiv + '<ul class="divmiULocultar" onclick="muestraContenidSubMenu(this,event)">' + menu[i].innerHTML + flecha + '</ul>';
                        }

                    }
                    document.getElementById('miCapaCont').innerHTML = stringDiv;
                    var classLabel = document.getElementsByClassName('labelMenu');
                    var cant = classLabel.length;
                    for (var j = 0; j < cant; j++) {
                        classLabel[j].classList.remove("labelMenuMinimizar");
                    }
                    document.getElementById('miCapaCont').classList.remove('divVisible');
                    document.getElementById('miCapaCont').classList.add('divOculto');
                    var miULDiv = document.getElementsByClassName('miULDiv');
                    miULDiv[0].style.width = "150px";


                } else {

                    for (var i = 0; i < cantBtn; i++) {
                        menu[i].classList.add("miULOculta");
                        stringDiv = stringDiv + '<ul class="divmiULocultarMovil" onclick="muestraContenidSubMenu(this,event)">' + menu[i].innerHTML + flecha + '</ul>';

                    }

                    document.getElementById('miCapaCont').innerHTML = stringDiv;
                    var classLabel = document.getElementsByClassName('labelMenu');
                    var cant = classLabel.length;
                    for (var j = 0; j < cant; j++) {
                        classLabel[j].classList.add("labelMenuMinimizar");
                    }
                    document.getElementById('miCapaCont').classList.remove('divVisible');
                    document.getElementById('miCapaCont').classList.add('divOculto');

                    var miULDiv = document.getElementsByClassName('miULDiv');
                    miULDiv[0].style.width = "100px";

                }
            } else {

                if (menu[0].classList.contains("miULOculta") == false) {
                    for (var i = 0; i < cantBtn; i++) {
                        menu[i].classList.add("miULOculta");
                        stringDiv = stringDiv + '<ul class="divmiULocultarMovil" style="width:1000px"  onclick="muestraContenidSubMenu(this,event)">' + menu[i].innerHTML + flecha + '</ul>';
                    }
                    document.getElementById('miCapaCont').innerHTML = stringDiv;
                    var classLabel = document.getElementsByClassName('labelMenu');
                    var cant = classLabel.length;
                    for (var j = 0; j < cant; j++) {
                        classLabel[j].classList.add("labelMenuMinimizar");
                    }
                    document.getElementById('miCapaCont').classList.remove('divVisible');
                    document.getElementById('miCapaCont').classList.add('divOculto');
                    var miULDiv = document.getElementsByClassName('miULDiv');
                    miULDiv[0].style.width = "400px";
                    miULDiv[0].style.height = "100px";
                    miULDiv[0].style.fontSize = "36px";



                }
            }
            globalAnchoPantalla = anchoPantalla;
        }
    }
    /*-------------MUESTRA LOS CONTENIDOS DE LOS SUBMENUS-----------------*/
    function muestraContenidSubMenu(objeto, evento) {
        if (screen.width >= 1000) {
            var estadoClase = objeto.classList[0];
            if ((estadoClase == "divmiULocultar")) {
                objeto.classList.remove('divmiULocultar');
                objeto.classList.add('divmiULmostrar');
            } else {
                if (estadoClase == "divmiULmostrar") {
                    objeto.classList.remove('divmiULmostrar');
                    objeto.classList.add('divmiULocultar');
                } else {
                    if (estadoClase == "divmiULocultarMovil") {
                        if (objeto.childNodes.length > 4) {
                            objeto.classList.remove('divmiULocultarMovil');
                            objeto.classList.add('divmiULmostrarMovil')
                        } else {
                            for (var i = 0; i < objeto.childNodes.length; i++) {
                                if (objeto.childNodes[i].nodeName == "A") {
                                    location.href = objeto.childNodes[i].href
                                }
                            }
                        };

                    } else {
                        objeto.classList.remove('divmiULmostrarMovil');
                        objeto.classList.add('divmiULocultarMovil');
                    }
                }
            }
        } else {
            var estadoClase = objeto.classList[0];
            if ((estadoClase == "divmiULocultarMovil")) {
                if (objeto.childNodes.length > 4) {
                    objeto.classList.remove('divmiULocultarMovil');
                    objeto.classList.add('divmiULmostrarMovil')
                } else {
                    for (var i = 0; i < objeto.childNodes.length; i++) {
                        if (objeto.childNodes[i].nodeName == "A") {
                            location.href = objeto.childNodes[i].href
                        }
                    }
                };
            } else {
                objeto.classList.remove('divmiULmostrarMovil');
                objeto.classList.add('divmiULocultarMovil');
            }
        }
        //}

    }
    /*---------------------------------------------------------------------------------*/
    /*---------------MUESTRA EL CONTENIDO DEL MENU AL ESTAR MINIMIZADO-----------------*/
    function muestraContenido(object) {
        //alert(object.nodeName);//event.srcElement.nodeName
        if (event.srcElement.nodeName == "DIV") {
            var estadoClase = document.getElementById('miCapaCont').classList[0];
            if ((estadoClase == "divOculto")) {
                document.getElementById('miCapaCont').classList.remove('divOculto');
                document.getElementById('miCapaCont').classList.add('divVisible');
            } else {
                document.getElementById('miCapaCont').classList.remove('divVisible');
                document.getElementById('miCapaCont').classList.add('divOculto');
            }

        }

    }

    function detienePropagacion(e) {
        e.stopPropagation();
    }
    /*-------------------------------------------------------------------------------*/
</script>

<style>
    label {
        font-size: 12px
    }

    .divOculto {
        display: none;
    }

    .divOculto:hover {
        background-color: green;
        cursor: progress
    }

    .divVisible {
        display: block;
        height: 50px;
    }

    .divVisible>ul {
        position: relative;
        left: -40px;
        top: 40px;
        margin: 0px;
        border: outset;
        width: 500px;
        background-color: #361866;
    }

    .miULDiv {
        float: left;
        height: 50px;
        border: solid;
        position: relative;
        top: 0px;
        background-color: #361866;
        background-size: 50px;
        background-repeat: no-repeat;
        z-index: 50;
        ;
        color: white;
        padding-left: 40px
    }

    .miULDiv:hover {
        background-color: #9d8ebf
    }

    .miULResponsivo {
        float: left;
        height: 40px;
        width: 1000px;
        border: solid;
        position: relative;
        top: 16px;
        background-color: #361866;
        background-size: 40px;
        background-repeat: no-repeat
    }

    .miUL:hover>a {
        background-color: #9d8ebf
    }

    .miUL:hover>label {
        background-color: #9d8ebf
    }

    .divmiUL {
        background-color: #361866;
        z-index: 120;
        position: relative;
        left: -10px
    }

    .divmiULocultar {
        position: relative;
        top: 200px;
        margin: 0px;
        width: 50px;
        background: #361866
    }

    .divmiULocultar>li {
        display: none;
        position: relative;
        top: 20px;
        width: 50px;
        height: 20px
    }

    .divmiULocultar>a {
        color: white
    }

    .divmiULocultar>label {
        color: white
    }

    .divmiULocultar:hover {
        background-color: #9d8ebf
    }

    .divmiULocultar:hover>a {
        background-color: #9d8ebf;
        color: white
    }

    .divmiULocultar:hover>label {
        background-color: #9d8ebf;
        color: white
    }

    .divmiULocultarMovil {
        position: relative;
        top: 200px;
        margin: 0px;
        width: 100px;
        height: 100px;
        background: #361866,
    }

    .divmiULocultarMovil>li {
        display: none;
        position: relative;
        top: 20px;
    }

    .divmiULocultarMovil>a {
        color: white;
        font-size: 36px;
        width: 300px;
        height: 100px;
        text-decoration: underline;
    }

    .divmiULocultarMovil>label {
        color: white;
        font-size: 36px;
        padding: 10px;
        text-decoration: underline;
    }

    /*.divmiULocultarMovil:hover{background-color:#9d8ebf; }
    .divmiULocultarMovil:hover > a,label { background-color:#9d8ebf; color:white}*/

    .divmiULmostrar {
        width: 150px;
        padding-left: 0px;
    }

    .divmiULmostrar>li {
        display: block;
        width: 150px;
        background-color: #6218da;
        color: white;
        margin-left: 15px;
    }

    .divmiULmostrar>li>a {
        background-color: #6218da;
        color: white;
        width: 100px;
    }

    .divmiULmostrar>li>a:hover {
        background-color: #9d8ebf;
        width: 100px
    }

    .divmiULmostrarMovil {
        background-color: #361866;
        color: white;
        width: 1000px
    }

    .divmiULmostrarMovil>li {
        display: block;
        width: 300px;
        height: 120px;
        margin-left: 15px;
        background-color: #361866;
        color: white
    }

    .divmiULmostrarMovil>li>a {
        background-color: #361866;
        color: white;
        font-size: 36px;
        text-decoration: underline;
        border: solid
    }

    .divmiULmostrarMovil>li:hover {
        background-color: #9d8ebf;
        font-size: 36px
    }

    .divmiULmostrarMovil>li>a:hover {
        background-color: #9d8ebf
    }

    .labelMenu {
        background-color: #361866;
        color: white;
        font-size: 14px;
    }

    .labelMenu:hover {
        background-color: #9d8ebf;
        color: white
    }

    .labelMenuMinimizar {
        font-size: 36px;
        width: 1000px
    }


    .miUL {
        float: left;
        height: 40px;
        width: 100px;
        border: solid;
        display: block;
        background-color: #361866;
        color: #361866;
        border: double
    }

    .muUL:hover {
        background-color: #9d8ebf
    }

    .miUL>a {
        background-color: #361866;
        color: white;
        width: 250px
    }

    .miUL>li {
        display: none;
        position: relative;
        ;
        top: -2px;
        width: 150px
    }

    .miUL>li:hover {
        background-color: #9d8ebf;
        border: groove
    }

    .miUL:hover li {
        display: block;
        z-index: 100;
    }

    .miULVisible {
        display: block;
        background-color: #361866;
        height: 40px;
        width: auto;
        padding: 10px
    }

    .miULVisible>li {
        background-color: #361866;
        width: 150px
    }

    .miULVisible>li>a {
        color: white;
        width: 150px;
        border: outset
    }

    .miULVisible:hover {
        background-color: #9d8ebf;
    }

    .miULOculta {
        display: none
    }

    .labelSubMenu {
        border: solid;
        width: 100%;
        text-decoration: underline;
        height: 40px
    }

    .labelSubMenu>div {
        display: none;
        position: relative;
        left: 140px;
        top: -25px;
    }

    .labelSubMenu:hover>div {
        display: block;
    }
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.min.js"></script>

<script type="text/javascript">
    window.addEventListener("resize", redimensionarCabecera);
    redimensionarCabecera();

    function redimensionarCabecera() {
        var w = window.outerWidth;
        var h = window.outerHeight;
        for (var i = 1; i <= 5; i++) {
            document.getElementById('fondoCabeceraMenu').classList.remove('stiloLogo' + i);
        }
        if (w >= 1360) {
            document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo1');
        } else {
            if (w < 1359 && w > 959) {
                document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo2');
            } else {
                if (w < 960 && w > 900) {
                    document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo3');
                } else {
                    if (w < 901 && w > 320) {
                        document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo4');
                    } else {
                        document.getElementById('fondoCabeceraMenu').classList.add('stiloLogo5');
                    }
                }
            }

        }
    }
</script>
<style type="text/css">
    .ocultarRowsDeColaboradores {
        display: none;
    }
</style>
<script type="text/javascript">
    function verRowsDeColaboradores(objeto, event, nombreClase) {

        event.preventDefault();
        event.stopPropagation()
        if (objeto.innerHTML == '+') {
            objeto.innerHTML = '-';
            let cant = document.getElementsByName(nombreClase).length;
            for (let i = 0; i < cant; i++) {
                document.getElementsByName(nombreClase)[i].classList.remove('ocultarRowsDeColaboradores');
            }
        } else {
            objeto.innerHTML = '+';
            let cant = document.getElementsByName(nombreClase).length;
            for (let i = 0; i < cant; i++) {
                document.getElementsByName(nombreClase)[i].classList.add('ocultarRowsDeColaboradores');
            }
        }
    }

    //***Modificacion Miguel Jaime 02-12-2021** Funcion que permite verificar la revision de la campana a diario por usuario//
    function setPuntualityUser(idPersona) {
        $.ajax({
            type: "POST",
            url: <?php echo ('"' . base_url() . 'fastFile/setPuntualityUser"'); ?>,
            data: {
                "id": idPersona
            },
            error: function() {},
            success: function(data) {}
        });
    }
</script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.min.js"></script>
<!--Mofificacion-->
<style type="text/css">
    #tabla_contacto {
        font-size: 11px;
        font-family: arial;
    }

    .bg-primary td {
        background-color: #4b678c;
        color: #fff;
        font-size: 11px;
        font-family: verdana;
    }

    .bg-primary td label {
        font-size: 11px;
        font-family: verdana;
    }

    #boton_contacto {
        background-color: #4b678c;
    }

    #boton_contacto:hover {
        background-color: #9a9240;
        opacity: 1;
    }
</style>
<?
function imprimirColaboradoresCabecera($datos)
{
    $div = '<table class="table" id="tabla_contacto">';
    foreach ($datos as $key1 => $value1) {
        $className = str_replace(' ', '', $value1['Name']);
        $div .= '<tr><td><button id="boton_contacto" class="btn btn-primary" onclick="verRowsDeColaboradores(this,event,\'' . $className . '\')">+</button></td><td><span style="color:#fff;">' . $value1['Name'] . '</span></td></tr>';
        foreach ($value1['Data'] as $key => $value) {
            $nombres = $value['apellidoPaterno'] . ' ' . $value['apellidoMaterno'] . ' ' . $value['nombres'];

            $div .= '<tr class="bg-primary ocultarRowsDeColaboradores" name="' . $className . '"><td><i class="fa fa-user"></i> ' . $nombres . '</td><td><div class="row"><label class="glyphicon glyphicon-send">    ' . $value['email'] . '</label></div><div class="row"><label class="glyphicon glyphicon-earphone"> ' . $value['telOficina'] . '</label></div><div class="row"><label>Ext: ' . $value['telOficinaExtension'] . '</label></div><div class="row"><label class="glyphicon glyphicon-phone"> ' . $value['celOficina'] . '</label></div></td></tr>';
        }
    }
    $div .= '</table>';
    return $div;
}


?>
<!--fin Modificacion-->
<!--Colocar los estilos anteriores-->
<!-- Viculamos los Estilos CSS -->
<?= link_tag('assets/css/bootstrap.min.css'); ?>
<?= link_tag('assets/css/font-awesome.min.css'); ?>
<?= link_tag('assets/css/bootstrap-datepicker3.min.css'); ?>
<?= link_tag('assets/css/cap.css'); ?>
<?= link_tag('assets/css/subMenu.css'); ?>
<?= link_tag('assets/css/menu.css'); ?>
<?= link_tag('assets/css/win8/ui.easytree.css'); ?>
<?= link_tag('assets/css/capMoi.css'); ?>
<?= link_tag('assets/css/estiloscapsys.css'); ?>


<!--Nueva configuracion para los módulos de tic Consultores-->
<?php if (!isset($ticc)) { ?>

    <link href="<?= base_url('assets/gap/css/toastr.min.css') ?>" rel="stylesheet" />


    <script src="<?= site_url('assets/js/jquery-1.12.3.min.js'); ?>"></script>
    <script src="<?= site_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
    <script src="<?= site_url('assets/js/locales/bootstrap-datepicker.es.min.js'); ?>"></script>
    <script src="<?= site_url('assets/js/jquery.easytree.min.js'); ?>"></script>
    <script src="<?= base_url('assets/gap/js/moment.min.js') ?>"></script>
    <script src="<?= base_url('assets/gap/js/lodash.min.js') ?>"></script>
    <script src="<?= base_url('assets/gap/js/sweetalert.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/gap/js/toastr.min.js') ?>" type="text/javascript"></script>
<?php  } ?>

<?php if (isset($ticc)) { ?>
    <!-- Archivos de los modulos de siniestros y evaluaciones-->
    <link href="<?= base_url(DIR_ASSETS . 'css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url(DIR_ASSETS . 'css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url(DIR_ASSETS . 'css/cap.css') ?>" rel="stylesheet" />
    <link href="<?= base_url(DIR_ASSETS . 'css/menu.css') ?>" rel="stylesheet" />
    <link href="<?= base_url(DIR_ASSETS . 'css/jquery-ui.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url(DIR_ASSETS . 'css/toastr.min.css') ?>" rel="stylesheet" />

    <link href="<?= base_url(DIR_ASSETS . 'css/nprogress.css') ?>" rel="stylesheet" />
    <!-- JS -->
    <script src="<?= base_url(DIR_ASSETS . 'js/jquery-3.4.1.min.js') ?>" type="text/javascript"></script>
    <script src="<?= site_url(DIR_ASSETS . 'js/jquery-ui.min.js'); ?>"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/toastr.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/sweetalert.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/pace.min.js') ?>" type="text/javascript"></script>
<?php  } ?>

<script type="text/javascript">
    function opcionBusquedaDocMenu(objeto) {
        if (objeto.value == 'CLIENTE') {
            document.getElementById('TbuscarXfolio').setAttribute('name', 'busquedaDirectorio');
            document.getElementById('buscarDocumentoForm').setAttribute('action', '<?= base_url() ?>directorio')
        } else {
            document.getElementById('TbuscarXfolio').setAttribute('name', 'TbuscarXfolio');
            document.getElementById('buscarDocumentoForm').setAttribute('action', '<?= base_url() ?>buscaXfolio');
        }

    }
</script>

<style type="text/css" id="estiloParaMovilV3Menu">
    @media only screen and (min-device-width: 320px) {
        .nav-item>a {
            display: none;
        }

        .nav-item>a[href="<?= base_url() ?>directorio"] {
            display: block;
            font-size: 35px
        }

        .nav-item>a[href="<?= base_url() ?>crmproyecto/proyecto100"] {
            display: block;
            font-size: 35px
        }

        .nav-item>a[href="<?= base_url() ?>cotizador"] {
            display: block;
            font-size: 35px
        }

        .nav-item>a[data-movil="1"] {
            display: block;
            font-size: 35px
        }

        .dropdown-item:nth-child(n+3) {
            display: none
        }

        .dropdown-item[href="<?= base_url() ?>actividades"] {
            display: block;
            font-size: 35px
        }

        .dropdown-item[href="<?= base_url() ?>actividades/agregar"] {
            display: block;
            font-size: 35px
        }

        .navbar-nav {
            display: flex;
        }
    }
</style>

<script type="text/javascript">
    if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) {

    } else {
        document.getElementById('estiloParaMovilV3Menu').parentNode.removeChild(document.getElementById('estiloParaMovilV3Menu'))
    }
</script>

<script type="text/javascript">
    function registrarSalida(idPersona) {
        console.log(idPersona);
        var direccion = <?php echo ('"' . base_url() . 'fastFile/registrarSalida"'); ?>;
        var parametros = {
            "idPersona": idPersona,
        };
        swal({
            title: "¿Desea registrar su salida?",
            text: "El registro de su salida solo podra realizarse una vez",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                $.ajax({
                    data: parametros, //datos que se envian a traves de ajax
                    url: direccion, //archivo que recibe la peticion
                    type: 'post', //método de envio
                    success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        var respuesta = JSON.parse(response);
                        if (respuesta["success"]) {
                            swal("¡Exitoso!", "Se ha registrado su salida", "success");
                            console.log(respuesta["success"]);
                            $('.swal-button--confirm').click(function() {
                                location.reload();

                            });
                        } else {
                            swal("¡Oops!", "Ya has registrado tu salida con anterioridad", "info");
                            console.log(respuesta["success"]);
                            $('.swal-button--confirm').click(function() {
                                location.reload();
                            });
                        }

                    }

                })
            }
        });



    }
</script>