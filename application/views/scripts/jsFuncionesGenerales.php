<script>

function peticionAJAXLibSloan(controlador,parametros,funcion){
    /*
       ---controlador
       es el controlador al que se va a dirigir. 
       Adicionalmente si va a un funcion debe estar el nombre funcion al del controlador
       separado por un /. ejemplo controlador/funcion.
      ---- parametros 
           es una cadena tipo requeste get IDCli=val1&preferenciaComunicacion=val2 ....
       --- funcion es hacia la funcion javascritp donde quieres que se envien los datos de respuesta
    */
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  //console.log($this->tank_auth->get_idPersona());
  var url=direccionAJAX+controlador;//+parametros;
  //console.log(url)
  //console.log(funcion); 
 req.open('POST', url, true);
 //var datos = new FormData();
 //datos.append('fecha',fechaTarea);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 //console.log(funcion); 
   req.onreadystatechange = function (aEvt) 
  {   
    if (req.readyState == 4) {    	
      if(req.status == 200)    
     {   
         var respuesta=JSON.parse(this.responseText); 
         //console.log(respuesta);            
         if(respuesta != "")
          window[funcion](respuesta);     
      }     
      
   }

  };
 req.send(parametros);
 return;
}

function enviarFormularioLibSloan(formulario,controlador,funcion)
{
  if(document.getElementById(formulario)){
    var Data = new FormData(document.getElementById(formulario));  
  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
  else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}
  //console.log('baseurl');
  //console.log( <?php echo base_url()?>);
  //var direccion= <?php echo base_url()?>+controlador;
  console.log(controlador);
  var direccion= <?php echo('"'.base_url().'"');?>+controlador;
  Req.open("POST",direccion, true);  
  Req.onload = function(Event) {  
    if (Req.status == 200) 
    {
      var respuesta = JSON.parse(Req.responseText); 
      window[funcion](respuesta);          
      //window.location.reload();
    } 
    else 
    { 
      if(Req.status==500)
      { 

                                         
      }
      
    }
  };    
  Req.send(Data);
 }
 else{alert('EL FORMULARIO PARA ENVIAR NO SE LOCALIZA')}
return;
}


</script>