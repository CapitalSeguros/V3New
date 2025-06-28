<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario final de GAP</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->
</head>
<body style="background-color: rgba(213, 216, 220); margin: 0 auto;">
    <div class="container-fluid">
        <div style="margin: 0 auto;">
            <div class="col-md-5" style="border: 1px #ABB2B9 solid; background-color: rgba(251, 252, 252)"> <!--style="margin: 0 auto; margin-top: 70px; vertical-align: top; border: 1px #ABB2B9 solid; background-color: rgba(251, 252, 252)"-->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="https://www.capitalseguros.com.mx/wp-content/uploads/2018/02/logo.png" alt="Capital Seguros y Fianzas" width="250" height="77" style="margin-left: 30px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center" style="border-bottom: 2px #3498DB solid;  margin-top: 20px;"><h4>Obtención de usuario y contraseña permanente</h4></div>
                <div class="col-md-12" style="margin-top: 10px">
                    <p>¡En hora buena! Sr(a) <?=$nameComplete?></p>
                    <p>Queremos que te sientas bien entre nosotros, que formes parte de nuestras experiencias, que encuentres oportunidades y condiciones para aprender y crecer. Esperamos sinceramente que tu experiencia con nosotros sea excelente y duradera. Siéntete muy bienvenido. Te damos la bienvenida, muchos logros y éxitos en este nuevo esfuerzo. ¡Buena suerte y buen trabajo!</p>
                    <p>Usted ha cumplido satisfactoriamente todos los requerimientos solicitados para pertenecer a esta empresa.</p>
                    <p>Aqui abajo podra encontrar la cuenta para su acceso permanente.</p>
                    <p>Cuenta permanente:</p>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><b> Usuario final: </b></td>
                                <td><?=$user?></td>
                            </tr>
                            <tr>
                                <td><b> Contraseña: </b></td>
                                <td><?=$password?></td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <p>Intente accesar a su cuenta dando click a este enlace de abajo.</p>
                    <p class="text-center">
                        <a role="button" class="btn btn-primary" href="<?=base_url()?>">Acceso a la plataforma</a>
                    </p>
                    <p>La visualización de esta vista caducará en la fecha: <span class="text-danger"><b><?=date("d-m-Y", strtotime($dateCreation." + 7 days"))?></b></span></p>
                </div>
                <div class="col-md-12"></div>
            </div>
        </div>
        <br>
        <br>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>