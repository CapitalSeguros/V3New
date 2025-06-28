<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas Url</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,400" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<style>
    .contenido{
        display:flex;
        justify-content: center;
        font-family: 'Raleway', sans-serif;
        font-weight: 300;
        font-size: 20px;
        background:blue;
        color:white;
        font-weight: bold;
    }
    .tituloencuesta{
        display:flex;
        justify-content: center;
        font-family: 'Raleway', sans-serif;
        font-weight: 600;
        text-transform:uppercase;
        text-decoration: underline;
    }
    .correo{
        font-family: 'Raleway', sans-serif;
        font-weight: 600;
        display: flex;
        flex-direction: row;
        
    }
    .correo div{
        margin-left: 10px;
    }
    #nombre{
        width: 250px;
    }
    @media(max-width:550px )
    {
        .correo{
        
        flex-direction: column;
        
      } 
      .correo div{
        margin-top: 15px;
    }
    }
    .pregunta{
        display:flex;
        justify-content: left;
        font-family: 'Raleway', sans-serif;
        font-weight: 600;
        padding: 0px 10px;
    }
    .respuesta{
        font-family: 'Raleway', sans-serif;
        font-weight: 600;
        color:red;
        font-size: 15px;
    }
    .grabar
    {
        display:flex;
        justify-content: center;
         margin-top:15px; 
         margin-bottom:15px; 
    }
    .btn_new{
        padding: 5px 10px;
        background:rgb(243, 8, 33);
        color:white;

    }
    .btn_new:hover{
      cursor:pointer;
      background:rgb(112, 236, 66);
    }
</style>
<body>
          <div class="contenido">
             <p>Capital SF te da las gracias por aportar en la mejora continua, tu opinion es muy valiosa para nosotros</p>
          </div>
          <div class="modal-body">
              <!--?php var_dump($pregunta.);
              ?-->
      <form  
            id="formencuestas" name="formencuestas"
            method="post" 
            action="" > 
         <!--input type="hidden" name="idenc" id="idenc"  value="<?php echo $ide?>" /-->
           <ul id="respuestasUrl">

           </ul>
           <div class="tituloencuesta">
              <p><?echo $encuesta->descripcion ?></p>
            </div>
            <div class= "correo">
              <div>   
                <label for="">Apoyanos con tu Correo </label>
                <input type="email" id="correo" name="correo" >
               </div> 
               <div>            
                <label for="">Nombre </label>
                 <input type="text" id="nombre" name="nombre" >
                </div> 
             </div> 
             
            <div class="seleccion">
            <?php
        
                 $contador =1;
                foreach ($pregunta as $row){
                   // var_dump($row->nps);
                    ?>
                    <p id="p<?echo $row->idpregunta ?>"  class="pregunta"><?echo $contador.".- ".$row->pregunta ?></p>                   
                    <input type="hidden" id="r<?echo $row->idpregunta ?>" value="<?echo $row->respuesta ?>">
                    <input type="hidden" id="t<?echo $row->idpregunta ?>" value="<?echo $row->tipo ?>">
                    <input type="hidden" id="n<?echo $row->idpregunta ?>" value="<?echo $row->nps ?>">
                   <?
                   // var_dump(intval($row->tipo));
                    if(intval($row->tipo) == 1)
                    {
                        ?>
                         <div class="selecciona">                      
                        <label class="respuesta">&nbsp;&nbsp;RESPUESTA &nbsp;</label>
                         <select  class="respuesta" name="<?php echo $row->idpregunta?>" 
                          id="<?php echo $row->idpregunta?>" 
                           class="form-control-width-small input-sm" >
                           <option  disabled selected value="">--Selecione</option>
                         <option value="1">1</option>
                         <option value="2">2</option>                                 
                         <option value="3">3</option>                                 
                         <option value="4">4</option>                                 
                         <option value="5">5</option>                                 
                         <option value="6">6</option>                                 
                         <option value="7">7</option>                                 
                         <option value="8">8</option>                                 
                         <option value="9">9</option>                                 
                         <option value="10">10</option>                                 
                        </select>
                        </div> 
                        <?
                      }
                      else
                         {
                          ?>
                          <div class="selecciona">
                            <label class="respuesta">&nbsp;&nbsp;&nbsp;RESPUESTA &nbsp;</label>
                            <select class="respuesta" name="<?php echo $row->idpregunta?>" 
                             id="<?php echo $row->idpregunta?>" 
                             class="form-control-width-small input-sm" >
                             <option  disabled selected value="">--Selecione</option>
                            <option value="V">V(SI)</option>
                            <option value="F">F(NO)</option>
                            </select>
                            </div> 
                           <?
                         }      
                       // <?
                   // }
                   $contador ++;
                }
            ?>
             </div>
          <div class="grabar">
            <button type = "submit" id="grabar" class = "btn_new"><i class="fas fa-plus"> </i>GRABAR</button>        
          </div>
      </form> 
    
    </div>
</body>
<script>
AddEvenListener();
let encuestaUrl=[];
function AddEvenListener()
{
 // document.querySelector('#tipodePago').addEventListener('change',cambiaRespueta);
  document.querySelector('.seleccion').addEventListener('click',cambiaRespueta);
  document.querySelector("#grabar").addEventListener('click',grabaEncuesta);
}
/***************************** */
function cambiaRespueta(e)
{
    //console.log(e.target.name);
    var idselect= e.target.name;
    var valor = "";
    var valor= document.getElementById(idselect).value;
    //console.log(e.target.parentElement.parentElement);
    var idpregunta = 'p'+idselect;
    var valorRespuesta ='r'+idselect;
    var valortipo ='t'+idselect;
    var valornps ='n'+idselect;
    //console.log(document.getElementById(valornps).value);
    if(valor != "") 
    {
        //console.log('entro');
       // respues= document.getElementById("respuestasUrl");
       // console.log(respues);
        const detalleEncuesta ={
            idpregunta : idselect,
            respuesta : valor,
            pregunta :  document.getElementById(idpregunta).innerText,
            valorRespuesta: document.getElementById(valorRespuesta).value,
            tipo : document.getElementById(valortipo).value,
            nps : document.getElementById(valornps).value
        }
        const existe = encuestaUrl.some(urls => urls.idpregunta === detalleEncuesta.idpregunta);
       // console.log(existe);
       if(existe)
        {
            encuestaUrl.map(url=>{
           if(url.idpregunta == detalleEncuesta.idpregunta)
            {
            /* articulos.cantidad= parseFloat(articulos.cantidad) + parseFloat(detalleArticulo.cantidad);
             articulos.subtotal =parseFloat(articulos.subtotal) + parseFloat(detalleArticulo.subtotal);
             articulos.iva =parseFloat(articulos.iva) + parseFloat(detalleArticulo.iva);
             articulos.total =parseFloat(articulos.total) + parseFloat(detalleArticulo.total);
             return articulos;*/
             url.respuesta = valor; 
            }})
            encuestaUrl = [...url];
        }
       else  
        {
          encuestaUrl = [...encuestaUrl,detalleEncuesta]  ;
        }  
    }
    return;
}
/******************************** */
function grabaEncuesta(e)
{
    e.preventDefault();
    var matches = document.querySelectorAll('select');
   // console.log(matches);
    var numero = matches.length;
    //console.log(numero);
    var bandera =0;
    var correo =document.querySelector('#correo');
    var nombre =document.querySelector('#nombre');
    if(correo.value === '' || correo.value === null)
    {
        
            Swal.fire(
                  'EMAIL!',
                   'Apoyanos con tu Correo',
                  'warning',
                   )               
            return;
      
    }
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
    }
    if(nombre.value === '' || nombre.value === null)
    {
        
            Swal.fire(
                  'EMAIL!',
                   'Apoyanos con tu Nombre',
                  'warning',
                   )               
            return;
      
    }
    for(let i =0; i < numero; i++)
    {
        //console.log(matches[i].id);  
        var valor= document.getElementById(matches[i].id).value; 
        var nue =  document.getElementById(matches[i].id);
       var nuevo = nue.options[nue.selectedIndex].text;
       //console.log(nuevo);   
       if(nuevo === '--Selecione')
       {
        bandera= 1;
        document.getElementById(matches[i].id).focus();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'No ha contestado todas las preguntas' 
         
        })
     
         return;
       }
    }
    var prodId = getParameterByName('id');
    //console.log(encuestaUrl);
    var xhr = new XMLHttpRequest();
     var datos = new FormData();
     let encuesta =JSON.stringify(encuestaUrl);
     datos.append('strvalor',prodId);
     datos.append('encuesta',encuesta);
     datos.append('correo', correo.value);
     datos.append('nombre', nombre.value);
     xhr.open('POST',"<?php echo base_url();?>pregunta/grabaEncuestaurl",true);
     xhr.onload = function()
     {
      if(this.status===200)
      {       
       var respuesta =JSON.parse(xhr.responseText);
       Swal.fire({
            icon: 'success',
            title: 'Se ha Enviado su Encuesta',
            text: 'Capital SF le agradece haber contestado la encuesta' 
         
        })
       console.log(respuesta);
      }
    }
    xhr.send(datos); 
    for(let i =0; i < numero; i++)
    {
        //console.log(matches[i].id);  
       // var valor= document.getElementById(matches[i].id).value; 
       // var nue =  document.getElementById(matches[i].id);
       // nue.options[nue.selectedIndex].text ='';
       document.getElementById(matches[i].id).value =0;
    }
    return;
}
/********************************* */
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
/********************************* */
</script>
</html>