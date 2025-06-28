<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Trimatrix Lab">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <title>Capital Seguros y Fianzas</title>
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/logo/iconCapital.png">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Icons -->
    <script defer src="https://use.fontawesome.com/releases/v6.6.0/js/all.js"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Alerts -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Calendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.4/source/jsCalendar.min.css" integrity="sha384-44GnAqZy9yUojzFPjdcUpP822DGm1ebORKY8pe6TkHuqJ038FANyfBYBpRvw8O9w" crossorigin="anonymous">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-table-style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/hover-min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/calificar-agente.min.css">
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="<?=base_url()?>assets/js/calificar-agente.min.js"></script>
</head>
<? //var_dump($ag); ?>
<body>
    <!-- Spinner Bar -->
    <div id="SpinnerBar" class="container-spinner-bar" hidden>
        <div class="container-spinner-bar-content-loading">
            <div class="spinner-bar">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>       
    </div>
    <section>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <center><img src="<?=base_url()?>assets/img/logo/logo_capital.png" width="20%"></center>
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <div class="container column-flex-center-center segment-info-agent">
                            <div class="col-md-6 cont-photo-profile">
                                <img class="shadow-b" src="<?=$photo?>">
                            </div>
                            <div class="col-md-6 cont-text-start">
                                <h5><?=$ag->nombres?> <?=$ag->apellidoPaterno?> <?=$ag->apellidoMaterno?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"><hr></div>
                    <div class="col-md-12">
                        <div class="col-md-12 segment-questions"><?=$questions;?></div>
                    </div>
                    <div class="col-md-12"><hr></div>
                    <div class="col-md-12 container-client-info">
                        <div class="col-md-12 pd-items-table">
                            <label class="textForm"><i class="fa-solid fa-circle-user"></i> Tu nombre:</label>
                            <input type="text" class="form-control" title="Nombre" name="client-info" value="<?=$client_name?>">
                        </div>
                        <div class="col-md-12 column-flex-start">
                            <div class="col-md-6 pd-right-add">
                                <label class="textForm"><i class="fa-solid fa-location-dot"></i> Lugar de la visita (Sucursal):</label>
                                <select class="form-control" id="subsidiary" name="client-info">
                                    <option value="1">Mérida Buenavista</option>
                                    <option value="2">Mérida Norte</option>
                                    <!-- <option value="3">Cancún</option> -->
                                </select>
                                <label class="text-sub-info mg-left mg-top mg-bottom">
                                    Ubicado en: <span id="location"></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="textForm"><i class="fa-solid fa-pencil"></i> Motivo de la visita:</label>
                                <textarea type="text" class="form-control" title="Motivo" name="client-info" value="<?=$client_desc?>"></textarea>
                            </div>
                        </div>
                    </div>
                    <div hidden>
                        <!-- <div class="pd-side">
                            <input type="text" class="form-control" name="client-info" data-field="id" value="<?=$id?>">
                        </div> -->
                        <div class="pd-side">
                            <input type="text" class="form-control" name="client-info" data-field="ag" value="<?=$ag->idPersona?>">
                        </div>
                    </div>
                    <div class="col-md-12"><hr></div>
                    <div class="col-md-12 column-flex-center-center" style="margin-top: 20px;">
                        <button class="btn btn-primary hvr-icon-push" id="btnGuardar" onclick="save_answers('<?=$mode?>')">
                            <i class="fas fa-save hvr-icon"></i>
                            <span class="">Guardar respuestas</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="base_url" data-base-url="<?=base_url()?>"></div>
</body>
</html>