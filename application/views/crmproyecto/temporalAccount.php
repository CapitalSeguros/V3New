<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario temporal de GAP</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
</head>
<body style="background-color: rgba(171, 178, 185); margin: 0 auto;">
    <div class="container-fluid">
        <div class="col-md-5" style="margin: 0 auto; margin-top: 70px; vertical-align: top; border: 1px #ABB2B9 solid; background-color: rgba(251, 252, 252)">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <img src="https://www.capitalseguros.com.mx/wp-content/uploads/2018/02/logo.png" alt="Capital Seguros y Fianzas" width="250" height="77" style="margin-left: 30px;">
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center" style="border-bottom: 2px #3498DB solid;  margin-top: 20px;"><h4>Obtención de usuario y contraseña temporal</h4></div>
            <div class="col-md-12" style="margin-top: 10px">
                <p>¡En hora buena! Sr(a) <?=$name?></p>
                <p>Usted ha sido seleccionado para cursar una induccion que le permitirá crecer como agente dentro de GAP.</p>
                <p>Aqui abajo podra encontrar la cuenta para su acceso temporal.</p>
                <p>Cuenta temporal:</p>
                <table class="table">
                    <tbody>
                        <tr>
                            <td><b> Usuario temporal: </b></td>
                            <td><?=$account->email?></td>
                        </tr>
                        <tr>
                            <td><b> Contraseña: </b></td>
                            <td><?=$account->passwordVisible?></td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <p>Intente accesar a su cuenta dando click a este enlace de abajo.</p>
                <p class="text-center">
                    <a role="button" class="btn btn-primary" href="<?=base_url()?>">Acceso a la plataforma</a>
                </p>
                <p>La visualización de esta vista caducará en la fecha: <span class="text-danger"><b><?=date("d-m-Y", mktime(0,0,0,date("n"), date("d") + 10, date("Y")))?></b></span></p>
            </div>
            <div class="col-md-12"></div>
        </div>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>