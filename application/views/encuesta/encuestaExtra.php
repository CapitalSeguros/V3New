<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<script type="text/javascript">
	<?php if(isset($pestania)){ ?> manejoMenu(<?php echo('"'.$pestania.'"'); ?>); <?php } ?>
</script>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script language="javascript">
$(document).ready(function(){
    $("#departamento").on('change', function () {
        $("#departamento option:selected").each(function () {
            elegido=$(this).val();
            $.post("modelos.php", { elegido: elegido }, function(data){
                $("#modelo").html(data);
            });     
        });
   });
});
</script>
<!DOCTYPE html>
<html lang="en">
<style>
    .titulo
    {
        text-align:center;
        border-bottom:1px solid green;
    }
    .encabezado
    {
        display:flex;
        align-items:center;
        justify-content:center;
        padding:10px ;
    }
    .encabezado label
    {
      padding:0px 10px;  
    }
    .encabezado a
    {
      margin:0px 5px;   
      padding:5px 20px; 
      background-color : rgb(255, 87, 51 );
      color:white;
      width:80px;
      height: 30px;
      text-align:center;
      align-items:center;
      
    }
    .encabezado a:hover{
       cursor:pointer;
    }
    .agregaCliente
    {
       margin:0 auto;
        width: 700px;
      height:150px;
      overflow: scroll;
        display: flex;
      justify-content:center;
      list-style: none;
      
    }
    .agregaCliente li{
        list-style: none; 
    }
    .listado{
        display : flex;
        justify-content: space-between;
         width: 500px;
    }
    .listado li{
       
        filter:gray;
        -webkit-transition:all -10s ease-in-out;
    }
    .icono{
      
        filter:gray;
        -webkit-transition:all -10s ease-in-out;
       color:rgb(255, 66, 51)
    }
    .icono:hover{
        cursor: pointer;
      
        -webkit-filter:grayScale(0);
        -webkit-transform:scale(1.2);
    }
    .enviaDatos
    {
        display: flex;
        justify-content: center;
        margin-top:10px;
    }
    .enviaDatos a{
        background: green;
        padding:5px 10px;
        color:white;
    }
    .enviaDatos a:hover{
        cursor:pointer;
        -webkit-transition:all -10s ease-in-out;
        -webkit-filter:grayScale(0);
        -webkit-transform:scale(1.2);
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Externos</title>
</head>

<body>
    <div class="titulo">
    <h1>Clientes Externos</h1>
    </div>
  <div class="encabezado">
   <label for="">Correo</label>
   <input type="email" id="correo" name="correo" >
   <label for="">Encuesta</label>
   <select name="encuesta" id="encuesta">
   <?foreach($encuestas as $row)
   {
   ?>
     <option value="<?echo $row->idcabencuesta?>"><?echo $row->descripcion?></option>
    <?
   }
   ?>
   
   </select>
   <!--?
   var_dump($encuestas);
   ?-->
   <a name ="btnagregar" id= "btnagregar">Agregar</a>
  </div>
<div class="agregaCliente">
              <ul id="ulagregaCliente">
                 
              </ul>
</div>
<div class="enviaDatos" >
            <a>Graba</a>
</div>
</body>

</html>
<link rel="stylesheet" href="<?php echo base_url();?>css/sweetalert2.min.css">  
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script language="javascript">
AddEventListener();
let agregaClientes=[];
function AddEventListener()
{
  document.querySelector('#btnagregar').addEventListener('click',enviaDatos);
  document.querySelector('#ulagregaCliente').addEventListener('click',eliminar);
  document.querySelector('.enviaDatos a').addEventListener('click',grabaDatos);
}
/************************************ */
function grabaDatos(e)
{
    e.preventDefault();
    if(agregaClientes.length > 0)
    {
        //console.log(agregaClientes[0]);
        for(let i=0; i < agregaClientes.length; i++)
        {
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('encuesta',agregaClientes[i].encuesta);
            datos.append('idencuesta',agregaClientes[i].idencuesta);
            datos.append('idusuario',agregaClientes[i].idusuario);
            xhr.open('POST',"<?php echo base_url();?>asigna/grabaEncuestaextra",false);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);              
                agregaClientes=[];
                agregaHTML();
                Swal.fire(
                  'Exito!',
                   'Se ha grabado correctamente',
                  'succes',
                   )  
               }
             }
             xhr.send(datos);
          
        }
       
        return;
    }
    else{
        return;
    }
   
}
/************************************ */
function eliminar(e)
{
    e.preventDefault();
    //console.log(e.target);
    var iden = e.target.parentElement.parentElement;
    //console.log(iden);
    if(e.target.classList.contains('fa-trash-alt'))
    {
        //console.log(iden.id);
        agregaClientes=agregaClientes.filter(correos => correos.id != iden.id);
        agregaHTML();
    }
}
/************************************ */
function enviaDatos(e)
{
    e.preventDefault();
    var correo =document.querySelector('#correo');
    if(correo.type === 'email')
    {
        const resul =  correo.value.indexOf('@');
        if(resul <0)
        {
            Swal.fire(
                  'EMAIL!',
                   'Expresion de Correo Incorrecto',
                  'warning',
                   )               
            return;
        }
        const er =/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(er.test(correo.value))
        {
            //console.log(agregaClientes.length);   
            var ide = agregaClientes.length;
           // console.log(ide);   
            const detalleUsuario = {
                id : ide,
                idusuario : document.getElementById("correo").value,
                idencuesta : document.getElementById("encuesta").value,
                encuesta : $("#encuesta option:selected").text(),
            };
            //verificaCliente();
            const existe = agregaClientes.some(cliente => cliente.idusuario === detalleUsuario.idusuario)
            const existe2 = agregaClientes.some(cliente => cliente.idencuesta === detalleUsuario.idencuesta)
            //console.log(existe);                          
            if( existe && existe2)
            {
                console.log('Ya existe');                         
                return; 
            }
            agregaClientes = [...agregaClientes,detalleUsuario] ;
            agregaHTML();
        }
        else{
            //console.log('email no valido');
        
            Swal.fire(
                  'EMAIL!',
                   'Expresion de Correo Incorrecto',
                  'warning',
                   )       
            return;
        }
    }
    //console.log(correo.type);
}
/******************************** */
function agregaHTML()
{
    limpiarHTML();
    //var iden =1;    
    agregaClientes.forEach(clientes =>{
      const row = document.createElement('Li');
      const valor =document.getElementById('ulagregaCliente');
      row.innerHTML = `<div class="listado" id = "${clientes.id}"><div>${clientes.idencuesta}---${clientes.idusuario}----${clientes.encuesta}</div><div><i class='icono fas fa-trash-alt'></i></div></div>
      `;
      valor.appendChild(row);
      //iden ++;
    }) 
}
/******************************** */
function limpiarHTML()
{
    const valor  =document.getElementById('ulagregaCliente');
    while(valor.firstChild){
        valor.removeChild(valor.firstChild)
    }
}

</script> 