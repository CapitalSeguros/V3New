<?php $this->load->view('headers/header'); ?>
<meta name="viewport" content="width=device-width, user-scalable=no">
<style type="text/css">
  .login{
    -webkit-box-shadow: 0px 2px 10px 0px rgba(0,0,0,1);
    -moz-box-shadow: 0px 2px 10px 0px rgba(0,0,0,1);
    box-shadow: 0px 2px 10px 0px rgba(0,0,0,1);
    border-radius: 8px;
    width: 50%;
    text-align: center;
    padding: 2%;
    font-family: verdana;
    background-color: #fff;
    margin-top: 10%;
  }
  #password{
    border-radius: 10px;
    font-family: verdana;
    font-size: 14px;
  }
  #login{
    border-radius: 10px;
    font-family: verdana;
    font-size: 14px;
  } 
  .btn{
    border-radius: 10px;
    font-family: verdana;
    font-size: 14px;
  }
  .btn:hover{
    background-color: #DBA901;
    border-color: #DBA901;
  }
  .sello{
    font-family: verdana;
    font-size: 14px;
    margin-left: 1%;
    color: #ffffff;
    background: #FFF;
    text-shadow: -1px -1px 1px rgba(255,255,255,.1), 1px 1px 1px rgba(0,0,0,.8);
  }
  .header-cap{
    background: rgba(255,255,255,1);
    background: -moz-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 8%, rgba(36,78,122,1) 49%, rgba(36,78,122,1) 100%);
    background: -webkit-gradient(left top, right top, color-stop(0%, rgba(255,255,255,1)), color-stop(8%, rgba(255,255,255,1)), color-stop(49%, rgba(36,78,122,1)), color-stop(100%, rgba(36,78,122,1)));
    background: -webkit-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 8%, rgba(36,78,122,1) 49%, rgba(36,78,122,1) 100%);
    background: -o-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 8%, rgba(36,78,122,1) 49%, rgba(36,78,122,1) 100%);
    background: -ms-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 8%, rgba(36,78,122,1) 49%, rgba(36,78,122,1) 100%);
    background: linear-gradient(to right, rgba(255,255,255,1) 0%, 
</style>

<html>
<body>
<div class="page-container">
  <center>
  <div class="login">
   <img src="<?=base_url()?>assets/img/logoCapsys_Login1.png" alt="logo_CapSys_Web" style="width: 25%;height: 100px;">
       <div class="alert alert-primary" role="alert" style="width: 90%;">
          Por favor agregue su cuenta de correo registrada en al capsys y en breve momento se le enviara a esa cuenta su contraseña
        </div>
        <form  action="<?=base_url();?>recuperaPassword/guardaCorreoParaEnviar" method="POST">  <div class="form-group">      
          <center>
          <input type="email" name="direccionCorreo" id="direccionCorreo" style="width: 400px" required class="form-control" placeholder="Dirección de Correo Electronico">
        	<input type="submit" value="Enviar" class="btn btn-primary">
          </center>
        </div>
        </form>
          <label name="" style="border: none;width: 350px" ><? if(isset($datos)){echo $datos;} ?></label>

          <br><span style="font-family: verdana;font-size: 14px;font-weight: bold;color:#66449f"><a  href="<?=base_url()?>auth/login">REGRESAR A LA PAGINA PRINCIPAL</a></span>
    </div>
  </center>
  </div>

</body>
</html>
