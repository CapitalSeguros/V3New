 <style type="text/css">
form
{
display:flex;  
    flex-direction: column;
    align-items: center;
    justify-content: center;
     margin-left: auto;
    margin-right:auto;
    margin-top: 170px;
    margin-bottom: 170px;
    padding-left: 20px;
    padding-right: 20px;
    
}
.contenedor
{
    display:flex;  
    flex-direction: column;
    align-items: center;
    justify-content: center;
     margin-left: auto;
    margin-right:auto;
  
    margin-bottom: 170px;
    padding-left: 20px;
    padding-right: 20px;
    background: rgba(235,233,249,1);
}
.sombra
{
	-webkit-box-shadow: 4px 10px 22px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 4px 10px 22px 0px rgba(0,0,0,0.75);
box-shadow: 4px 10px 22px 0px rgba(0,0,0,0.75);
}
.logueo1
{
  padding:5px; 
  padding-top: 30px
}
#idusuario
{
   margin-left: 20px;
}
.logueo
{
  margin-right:30px; 
  padding-top: 30px
}
.logueo input
{
  height: 30px;
   margin-left: 5px;
}
.permiso
{
margin-top: 15px;
margin-bottom: 15px;
}
.btnpermiso
{
   margin-left: auto;
    margin-right: auto;
    background-color: #008CBA;
    text-align: center;
    text-transform: uppercase;
    padding: .5rem;
    color:white;
    border: none;
    text-decoration: none;
    height: 30px;
    
}
#button
{
	padding: 10px;
	padding-left: 15px;
	padding-right: 15px;
}
 </style>
 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Credenciales</title>
   <link rel="stylesheet" href="<?php echo base_url();?>css/proyectocss.css">  
   <link rel="stylesheet" href="<?php echo base_url();?>css/iconos.css">  
   <!--Modal de Proyecto Con susuarios-->

  
</head>
<body>
<form   role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>cproyecto/verificaUsuario" > 
 <div class = "contenedor sombra">

            <div class="logueo1">
           <spam>Usuario </spam><input type="text" id="idusuario" name = "idusuario" >
           </div> 
           <div class="logueo">
           <spam>Contraseña </spam><input type="password" id="idpassword" name = "idpassword" >
           </div> 
            <hr>
           <div class= "permiso">
            <input type="submit" name="Generar"  id="button" value="Enviar" align="center"   style="background:#43BD55;color: #FFFFFF;"
             target="_blank"     onclick="">      

           </div>
 </div> 	
</form>
</body>	