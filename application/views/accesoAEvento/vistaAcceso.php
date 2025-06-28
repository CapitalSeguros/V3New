<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Acceso al evento</title>
</head>
<body class="bg-light">
    <div class="container">
        <div class="col-md-12 text-center m-auto">
            <div class="card card-body bg-white">
                <div class="text-center"><img class="card-img-top text-center" src="https://www.capitalseguros.com.mx/wp-content/uploads/2018/02/logo.png" alt="Card image cap" style="width:50%; height: 30%"></div>
                <div class="card-body mt-8">
                    <div class="row">
                        <div class="col-md-6 mt-4 border">
                            <!--<div class="card">-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mt-2">Un poco de información...</h6>
                                        <p class="text-left  p-auto">En este mundo cada vez más competitivo se requiere de profesionalismo para destacar y convertirse en el mejor. Los agentes de seguros deben aspirar a ser cada día mejores, y esa es una de las metas de CAP Capital tiene para aquellos que se unen al equipo. Aquí te proporcionamos todas las herramientas necesarias.</p>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <img class="img-fluid" src="https://www.capitalseguros.com.mx/wp-content/uploads/2018/12/4a64033b0329ada346114edccd1dd2f3.jpg" alt="" >
                                        <img class="img-fluid" src="https://www.capitalseguros.com.mx/wp-content/uploads/2018/12/Perfila-tu-venta-erradicando-las-objeciones-1236x865.jpg" alt="">
                                    </div>
                                </div>
                            <!--</div>-->
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="card">
                                <h6 class="mt-2">Datos del evento</h6>
                                <?php if($existe == 1){?>

                                <div class="card-body text-left">
                                    <div class="row">
                                        <div class="col-md-6">Tema:</div>
                                        <div class="col-md-6"><?=$titulo?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">Descripción:</div>
                                        <div class="col-md-6"><?=$descripcion?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">Fecha de inicio:</div>
                                        <div class="col-md-6"><?=$fecha?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">Clasificación:</div>
                                        <div class="col-md-6"><?=$clasificacion?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">Sub-categoría:</div>
                                        <div class="col-md-6"><?=$categoria?></div>
                                    </div>
                                    <hr>
                                    <div class="gestionConexion">
                                        <?php if($registro == "registrado"){
                                            echo $this->load->view("accesoAEvento/vistaPendiente");
                                            } else{
                                                echo $this->load->view("accesoAEvento/vistaRegistro");
                                            }?>
                                    </div>
                                </div>

                                <?php } else{?>

                                    <div class="card-body text-left">
                                        <h5 class="text-center text-danger">El evento ha sido cancelado por el organizador o pasó la fecha solicitada.</h5>
                                    </div>
                                    
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-body bg-dark text-left">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-white">Tel: 01 800 237 8372</div>
                        <div ><a href="https://www.asesoresonline.mx/" class="text-white">Visita asesores online</a></div>
                        <div ><a href="https://www.capitalseguros.com.mx/" class="text-white">Visita Capital Seguros y Fianzas</a></div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-3"><a href="https://www.capitalseguros.com.mx/esr/#ecocap"><img class="img-fluid" src="https://www.capitalseguros.com.mx/wp-content/uploads/2020/04/Ecocap2020-300x71.png" alt=""></a></div>
                            <div class="col-md-3"><a href="http://capacitaonline.com.mx/"><img class="img-fluid" src="https://www.capitalseguros.com.mx/wp-content/uploads/2018/03/CapacitaBN300-300x71.png" alt=""></a></div>
                            <div class="col-md-3"><a href="https://www.capsys.com.mx/"><img class="img-fluid" src="https://www.capitalseguros.com.mx/wp-content/uploads/2020/04/capsys2020.png" alt=""></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" data-url="<?=base_url()?>" id="base_url">
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="<?=base_url()."assets/js/jquery.gestionaEvento.js"?>"></script>
</body>
</html>