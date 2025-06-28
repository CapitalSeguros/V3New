



<style type="text/css">
.aside-izquierda
 {
  width: 20%;
  background: #ccc;
  float: left;
  padding: 20px;
  box-sizing: border-box;
  height:100vh;
 }
 .fa, .far, .fas {
    font-family: Font Awesome\ 5 Free;
}
.actividadesTareas
{
  display:flex;
  flex-direction: column;
  font-size: 20px;
}
.actividadesTareas i
{
	font-size: 15px;
}
.terminado1 {
    cursor: pointer;
}
.terminado1 {
    color: #00B762;
    padding: 7px;
}
.estrella {
    color: yellow;
    padding: 7px;
}
.icono {
    padding: 7px;
    color: #5B33FF;
}
.proyectosV3
{
	width: auto;
	display: flex;	
	justify-content: center;
	background-color: rgba(255 255 255 /70%);
	padding: 5px;
}
.panel {
    padding: .5rem;
    margin: 0rem;
}
.lista-proyectos .detaProyecto {
    display: flex;
    padding: 5px;
    margin-left: 0;
    margin-right: 0;
    justify-content: space-between;
}
input
{
	height: 3rem;
}

input:focus {
    background-color: lemonchiffon;
}
.detaProyecto input{
	width: 100%;
}
a.nuevoboton{
    
    margin-left: auto;
    margin-right: auto;
    background-color: #008CBA;
    text-align: center;
    text-transform: uppercase;
    padding: .5rem;
    color:white;
    border: none;
    text-decoration: none;
    height: 20px;
    font-size: 12px;
 }
 .panel .crear-proyecto{
    margin-top: 10px;
}
.seccion-principal
 {
 margin: auto;
 width: 80%;
 float: right;
 height:100vh;
}
.contenedor-app
{
    margin: 0 auto;  
    min-width: 285px;
    border:1px solid #e1e1e1;
    height:100px;
}
.contenedor-tareas
{
   display: flex;
   margin:0 auto;
   width: 95%;
}
.agrega_Tareas
{
  margin-top: 20px;  
  margin-left: 10px;
  display: flex;
  justify-content: space-between;
}

.tittarea
{
    width: auto;
    height: auto;
    margin-right: 30px: 
}
.tittarea span
{
    width: 15%;
    min-width: 10px;
}
.tittarea1
{
    width: 83%;    
}
#nuevo-tarea
{
   padding: 0px;
   width: 100%;
 
}
.lista-proyectos ul{
    list-style: none;
    padding: 1rem 0 0 0;
    margin: 0;
    text-decoration:none;
}
.lista-proyectos ul li {
    padding: .5rem 0 0 0;
    list-style: none;  
    
}
.lista-proyectos ul li a
{
    list-style: none;  
    text-decoration:none;
    color: black; 
}
.lista-proyectos ul li a:hover {
    color: #35fd71;
}
.barra_tareas
{
    display: inline-block; 
    margin-left: 10px;
}
.texto_derecha
{
  
    margin-left: auto;
}
button[type="button"] {
    color: #0099CC;
    border: 2px solid #0099CC;
    border-radius: 6px;
    padding: 10px;
    background: transparent;
    cursor: pointer;
}
.modalTareas
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalcomite
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.comite{
  color: rgb(186, 0, 138);
}

.modalsubTareas
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalFecha
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalAlerta
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s;
     top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalVisualiza
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 300px;
    width: 700px;
    margin-left: 300px;
    margin-top: 100px;
    transition: all .5s;
     top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalInicio
{
    background-color: rgba(0,0,0,.9);
    position:fixed;
    display:none;
    height: 100%;
    width: 100%;
   transition: all .5s;
     top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalmuestraTareacom
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s; 
      top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalmuestraTareaimp
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s; 
        top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}

.modalEntregatareas
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s; 
          top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalEntregaalertas
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s; 
          top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalMuestraFechaPos
{
  background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s; 
          top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}

.modalposFecha
{
  background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s; 
          top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.contenedor-modalMuestraFechaPos
{
  background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 50px;
    height:550px;
    overflow: scroll;
}
.contenedor-modalmuestraTareaimp
{
    background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 200px;
    height:400px;
    overflow: scroll;
    padding:10px;
    color:black;
}
.contenedor-modalInicio
{

    background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 200px; 
}
.contenedor-modalFecha
{
    background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 200px;
    height:350px;
    overflow: scroll;
}
.contenedor-modalAlerta
{
    background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 200px;
}
.contenedor-titProyecto
{
    margin-top:0px;
    float: right;
    width: 50%; 
    height: 100vh; 
    padding: 5px;
    flex: 1;
    
}
.contenedor-modalposFecha
{
  background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 200px;
}

.modal
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s;
}

.contenedor-modal
{
    background-color: white;    
    align-items: center;
    display: flex;

   
}
.contenedor-modalTexto
{
   padding:10px;
    background-color:black;    
    align-items: center;
    display: flex;      
    flex-direction: row;
}
.contenedor-logueo
{
    display:flex;  
    flex-direction: column;
    align-items: center;
}
.contenedor-subtareas
{
  background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 200px;
}
.logueo
{
  padding:5px; 
}
.logueo input
{
  height: 30px;
}
#textoMostrar
{
    color: white;
}
.btncierra
{
    display: flex;
    justify-content: flex-end;   
    padding:5px;
    margin-right: 20px; 
}
#textoFechamostrar
{
  margin-left: 5px; 
  overflow: hidden; 
}
.textoFecha
{
 display: flex;
 justify-content: center; 
 padding: 1rem;
 margin-left: 1rem;
 flex-direction: row;
}
#textoAlerta
{
    overflow: hidden; 
    margin-left: 10px;
}
.grabaFecha
{
    display: flex;
    align-items: center; 
    justify-content: center;
    height: 60px;

}
.btnGrabafecha
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
.permiso
{
  display: flex;
    align-items: center; 
    justify-content: center;
    height: 60px;
    

}
.btnpermiso
{
 margin-left: auto;
margin-right: auto;
background-color: #008CBA; 
padding: .5rem;
text-align: center;
color:white;
border: none;
text-decoration: none;
}
.btnGrabaAlerta
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

.aside-modal-izquierda
{
    width: 13%;
    height:100vh;
    background: #ccc;
    box-sizing: border-box;
    margin:0;
    padding: 5px;
  /*  background: #ccc;
    float: left;
    padding: 20px;
    box-sizing: border-box;
    */
}
.btnBotonera{
    width: 100%; 
    height: 20px;
    min-height: 80px;
    max-height: 60px; 
    margin-bottom: 2px; 
    background-color: white
}
.btnBotonera:hover{background-color: #9c73de}
.contenedor-titProyecto
{
    margin-top:0px;
    float: right;
    width: 50%; 
    height: 100vh; 
    padding: 5px;
    flex: 1;
    
}

.titProyecto
{
   display:flex;
   justify-content: space-between; 
   margin-right: 20px;
   border-bottom: 1px solid #ccc; 
}
.titProyecto h2,.ocultarObjeto h2,
.invitadoProyecto ,.listaInvitado h2,.invitadoProyecto h2,.textoFechamostrar h2,.textoFec h2
{
   font-size: 1.5rem;
}
.titulo-modal
{
    padding-left: 36px;
}
.cierra-modal
{
   /* margin-left: auto;*/
   height: 20px;
   margin-right:36px ;
}
.ocultarObjeto
{
     width: 100%;
    padding: 10px;
    margin-right:40px ;
    font-size: 1.5rem;
}
.buscador
{
    width: 100%;
    height: 2rem;
    padding: 3px;
    border:1px solid #e1e1e1;
}
.sombra {
    -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,.5);
    -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,.5);
    box-shadow: 0px 2px 5px 0px rgba(0,0,0,.5);
    border-radius: 10px;
}
.contenedor-tabla{
    margin-top: 20px;
    width: 97%;
    height: 250px;
    overflow: scroll;
    overflow-y: scroll;
}
.listado-contactos{
    width: 100%;
    margin-top: 1rem;
    border-collapse: collapse;
    height: 250px;
}
.listado-contactos thead {
    background-color: slateblue;
    color: white;
}
.listado-contactos thead th {
    padding: 0.7rem 0;
}
.listado-contactos thead th {
    padding: 0.7rem 0;
}
.listado-contactos tbody td {
    padding: 0.5rem;
}
.listado-contactos tbody td:nth-child(1) {
    text-align: center;
}
.listado-contactos tbody td:nth-child(2) {
    text-align: left;
}

.listado-contactos tbody td:nth-child(3) {
    text-align: center;
}
.tabla-contactos{
    width: 100%;
    height: 250px;
}

.invitadoProyecto
{
    display:flex;
    justify-content: space-between; 
    margin-right: 20px;
    border-bottom: 1px solid #ccc;     
}
.invitadoExterno
{
    padding: 5px;
    margin-right: 10px;
    margin-top: 5px;
}
.completo {
    color: #00B762; 
       
}
.listaInvitado
{
    width: 97%;
    height: 200px;
    overflow: scroll;
    overflow-y: scroll;
}
#ullistaInvitado
{
  margin-top: 10px;
}
#ullistaInvitado li
{
display: flex;  
 text-decoration: none;
 list-style:none;
 justify-content:space-between;
}
.tittarea
{
    width: auto;

    height: auto;
}
.tittarea span
{
    width: 15%;
    min-width: 10px;
}
.tittarea1
{
    width: 83%;
    
}
#nuevo-tarea
{
   padding: 0px;
   width: 100%;
 /*   justify-content: center;*/
}
.icono{
    padding: 7px;
    color: #5B33FF;
  
}
.icono:hover{
    cursor: pointer;
}
#tareaAgregadas{
    margin-left: 0px;
    padding-left: 10px;
}
#tareaAgregadas li{
    display: flex;  
    text-decoration: none;
    list-style:none;
    justify-content:space-between;   
    height: 50px;
    border-bottom: 1px solid #ccc;  
    overflow: hidden;
    padding-top: 10px;
    
}
#tareaAgregadas li p{
     flex: 1 1 0px;  
      width:800px;
      min-height: 52px;
      line-height: 2rem;
      overflow: hidden;
      margin: 0px;
    }
.listaInvitado
{
    width: 97%;
    height: 200px;
    overflow: scroll;
    overflow-y: scroll;
}

#ullistaInvitado li
{
display: flex;  
 text-decoration: none;
 list-style:none;
 justify-content:space-between;
    padding: 2px;

}
#ullistaEmpleados li {
    display: flex;
    text-decoration: none;
    list-style: none;
    justify-content: space-between;
    padding: 2px;
}
.completo {
    color: #00B762; 
       
}
.estrella
{
   color:yellow; 
   padding: 7px;
}
.estrella:hover
{
 cursor: pointer;
}
.terminado{
    color: #00B762; 
    padding: 7px;   
}
.terminado1{
    color: #00B762; 
    padding: 7px;   
}
.terminado1{
    cursor: pointer;  
}
.basura {
    color: red;
    display: inline;
}
.barra-avance
{
    height: 30px;
   
    width: 100%;
    margin: 0 auto;
    max-width : 800px;
    background-color: #e9ecef;
}

.subbarra-avance
{
    height: 30px;   
    width: 100%;
    margin: 0 auto;
    max-width : 800px;
    background-color: #e9ecef;
}
.porcentaje
{
    width: 0%;
    height: 100%;
    background-color: seagreen;    
    background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
    background-size: 1rem 1rem;
}
.subporcentaje
{
    width: 0%;
    height: 100%;
    background-color: #2cbdbe;    
    background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
    background-size: 1rem 1rem;
}
   #tareaImportantes   
    {
        margin-left: 0px;
        padding-left: 5px;   
    }
    #tareaImportantes li{
        display: flex;  
        text-decoration: none;
        list-style:none;
        justify-content:space-between;   
        height: 52px;
        border-bottom: 1px solid #ccc;  
        overflow: hidden;
        
    }
    #tareaImportantes li p{
      margin: 0 0 10px;
        
    }
    .tipocolor{
  color:red;
}
.pospuesta
{
  color: rgb(186, 74, 0);
}
#textoposFecha{
      text-align:center;
      color:black;
      text-transform:uppercase;
    }
    .menu-fecha{
  display :flex;
  justify-content: space-between;
  align-items:center;
  margin : 0 150px;
  border-bottom: 1px solid black;
}
.btnmuestra
{
   margin: 10px auto;  
     text-align: center;
    text-transform: uppercase;
    padding: .5rem;
    color:white;
    border: none;
    text-decoration: none;
    height: 30px; 
}
.btnmuestra a{
  background-color: #008CBA;
  padding: 10px 5px;
  color:white;
}
.btnmuestra a:hover{
  cursor: pointer;
}

.muestra-proyectos
{
  text-align:center;
  text-transform:uppercase;
background-color:orange;

}
.muestra_proyectos
{
  height: 100px;
    overflow: scroll;
    overflow-y: scroll;
}

#nuevo-hora{
  display: none;
}
.listaProyectos
    {
      display: flex;  
      justify-content:space-between; 
     align-items:center;  
    }
    
.grabaposFecha
{
    display: flex;
    align-items: center; 
    justify-content: center;
    height: 60px;

}

.btnGrabaposFecha
{
  margin-left: auto;
margin-right: auto;
background-color: #008CBA;
text-align: center;
align-items:center;
text-transform: uppercase;
padding: .6rem;
color:white;
border: none;
text-decoration: none;

border-radius:5px;
}
.btnGrabaposFecha a{
  text-align: center;
  align-items:center;
}
.subtareas
{
  color:black;
}
.ocultar
    {
      display: none;
    }
    .tittarea2
{
  display:block;
  margin:0;  
  padding:5px 10px;
}
.tittarea2 textarea
{
  width: 100%;  
 
}
.boton-subtarea
{
  display:flex;
  justify-content: flex-end;
  text-align:center;
  padding:10px 20px;
  
}
.boton-subtarea input
{
  text-align:center;
  width: 100px;
  padding:0 20px;
  background-color:green;
  color:white;
  border-radius:5px;  
}
.boton-subtarea input:hover
{
  cursor: pointer;
  background-color:tomato;
}
.ventana
{
  height:auto;
  width:150px;
  background-color:white;
  position: absolute;
  right:10px;
  
  align-items:center;
}
.ventana ul{
  margin-left:0;
  padding:0px;
  
}
#subventana li{
 
  margin:0px;
  height:35px;
  padding: 10px;
  align-items: left;
}
#subventana li i{
  align-items: left;
}

#subventana li:hover{
 cursor: pointer;
 background-color:green;
 color : white;
}
.completados
{
  display:flex;
  justify-content:center;
  width:140px;
}

.subicono
{
  padding: 7px; 
  color: #5B33FF;
  align-items:center;
}
.subicono:hover{
    cursor: pointer;
}

</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
 <aside class="aside-izquierda">

           <div class="actividadesTareas">
           <i class="far fa-check-circle terminado1"> Comite</i> 
           <i class="far fa-star estrella"> Tareas Importantes </i>
           <i class="far fa-calendar-alt icono">  Entrega de Tareas</i>
           <i class="fas fa-stopwatch icono">  Alertas de Tareas</i>
           <i class="fas fa-calendar-check icono pospuesta">  Fechas Pospuestas</i>
           </div> 
          
          <div class="proyectosV3"> 
           <span>V3 Proyectos</span>
          </div> 
            <div class = "panel lista-proyectos">            
             <div class="detaProyecto">               
               <input type="text"  id='nuevo-proyecto' placeholder="Nuevo Proyecto...">
             </div> 
              <div class="detaProyecto">
              <label>Fecha
              <input type="date" id='nuevo-fecha'></label>
              </div>
              <div class="detaProyecto"> 
                 
                 <input type="text"  id='nuevo-hora' placeholder="Hora de la Reunion...">
              </div>
 
              <div class="panel crear-proyecto">              
               <a href="#" class ="nuevoboton">Agrega Proyecto <i class="fas fa-plus"></i></a>
              </div>   
             <ul id="proyectos">
              <?php
               if($proyectos != FALSE)
               {
                 foreach($proyectos->result() as $proyecto)
                 {
                   ?> 
                   <li>
                   <div class="listaProyectos" >
                    <a href = "<?=base_url()?>cproyecto/muestraProyectosExternos2?idproyecto=<?php echo $proyecto->idproyecto?>&usuario=<?php echo $usuario ?>" id="<?php echo $proyecto->idproyecto?>">
                    <i class="fas fa-align-justify"></i> <?php echo $proyecto->nombre?>
                    </a>  
                    <?
                       if($proyecto->agregafecha)
                       {
                        ?>
                        <i id ="id<?php echo $proyecto->idproyecto?>"  class="far fa-calendar-check icono estrella" title="Posfecha Proyectos..."></i> 
                        <?  
                       }
                       else
                       { ?>
                        <i id ="id<?php echo $proyecto->idproyecto?>"  class="far fa-calendar-check icono" title="Posfecha Proyectos..."></i> 
                        <?
                        }
                        ?>
                        </div>  

                   </li> 
                  <?
                 }
               }
               ?> 
             </ul> 
           </div>        
           <input type="hidden" id="idusuarioGlobal" name = "idusuarioGlobal" >
    </aside>
     <!--termina posFecha --> 
    <!--Modal para posFecha -->
    <div class="modalposFecha" id='modalposFecha'>      
   <div class="bodymodal">   
     <div class="contenedor-modalposFecha">       
        <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierraModalPosfecha()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div class= "textoposFecha">
            <h2 align="center"> Posponer Fecha de Entrega del Proyecto</h2>
           <p id="textoposFecha"></p>        
        </div>
        <div class= "textoFecha">
           <label>Nueva Fecha de Entrega <input id="posFecha" type="date"  required></label> 
        </div>
        <hr>
        <div class= "grabaposFecha">
          <a href="#" class ="btnGrabaposFecha">Guardar</a>
        </div>
        <input type="hidden" id="idTareaposFecha" name = "idTareaposFecha" >
      </div>
   </div>
  </div>     
 <!--Termina Modal pstfecha-->  
  <!--Modal de Subtareas-->
  <div class="modalsubTareas" id='modalsubTareas'>      
   <div class="bodymodal">   
    <div class="contenedor-subtareas">
        <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierraModalsubtareas()"><i class="fas fa-times"></i></button>             
        </div>
         <h2 align="center">Subatreas</h2>
         <div class="tittarea2">
           <textarea name="nuevaSubtarea" id="nuevaSubtarea" cols="30" rows="2"></textarea>
         </div>
         <div class="boton-subtarea">
           <input name="grabaSubtarea" id="grabaSubtarea" value="Grabar">
           <input type="hidden" id="inpsubtarea" name = "inpsubtarea" value="">
         </div>
    </div>
       
    </div>
    </div>
<!--Termina Modal de Subtareas--> 

 <div class="modalFecha" id='modalFecha'>      
   <div class="bodymodal">   
     <div class="contenedor-modalFecha">       
        <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierraModalfecha()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div class= "textoFechamostrar">
            <h2 align="center"> Tarea</h2>
           <p id="textoFechamostrar"></p>        
        </div>
        <div class= "textoFecha">
           <label>Fecha de Entrega <input id="fechaTarea" type="date"  required></label> 
        </div>
        <hr>
        <div class= "grabaFecha">
          <a href="#" class ="btnGrabafecha">Guardar</a>
        </div>
        <input type="hidden" id="idTareaFecha" name = "idTareaFecha" >
      </div>
   </div>
  </div>     
 <!--Termina Modal para Fecha de entregas de  tareas--> 
   <!--Modal para mostrar posFecha -->
 

 <div class="modalTareas" id='modalTareas'>      
    <div class="bodymodal">   
      <div class="contenedor-modal">
        <aside class="aside-modal-izquierda">
          <div style="width: 120px; display: list-item;height: 600px;overflow: scroll;margin-left: 2%"><?=imprimirBotonera2($clasificacionUsuarios)?>
          </div>
        </aside>
       <div class = "contenedor-titProyecto">
          <div class ="titProyecto">
                  <h2 id = "tituloTarea" class="titulo-modal">Asignar Tareas</h2> 
                   <button class ="cierra-modal" onclick="cierraModaltareas()"><i class="fas fa-times"></i></button>             
           </div> 
           <div class="col-md-4 col-sm-4 col-xs-4 ocultarObjeto" id="divBuscarEmpleado">
             <h2 style="text-align:center">Buscador</h2>
             <input type="text" id="buscadorEmpleado" class="buscador sombra" placeholder="Buscar Invitados..."></button>
           </div>
           <div class="contenedor-tabla">
               <table id="listado-empleados" class="listado-contactos">                  
                <thead>
                         <tr>
                              <th>id</th>
                              <th>Nombre</th>
                              <th>Email</th>
                              <th>Clasificacion</th>
                              <th>Agregar</th> 
                         </tr>
                    <tbody id="tabla-empleados" class= "tabla-contactos">
                         
                    </tbody>     
                 </thead>
                </table>
            </div>
            <div class="invitadoProyecto">
               <h2>Invitados Agregados</h2> 
               <div class="tareaExterno">
                 <spam>Agrega Invitado <input type="text" class="UpperCase" id="tareaExterno" name="tareaExterno" placeholder="ejemplo@dominio.com"  autocomplete="off" ><i class="fas fa-user-plus fa-x icono"></i></spam>
             </div>
           </div>
            <div class="listaInvitado">
            <h2>Lista de Empleado Agregados</h2>
              <ul id="ullistaEmpleados">
                 
              </ul>
            </div>
         </div>         
     </div>
   </div> 
   <input type="hidden" id="nombreTarea" name = "nombreTarea" >
   <input type="hidden" id="idTarea" name = "idTarea" >
 </div>  
 <!--Termina Modal para agregar empleados  tareas-->  
<!--Modal para Alerta de  tareas-->
<div class="modalAlerta" id='modalAlerta'>      
   <div class="bodymodal">   
     <div class="contenedor-modalAlerta">       
        <div class="btncierra">
         <button class ="cierra-modalAlerta" onclick="cierraModalalerta()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
          <div class= "textoFec">
            <h2 align="center">Alerta de la Tarea</h2>
           <p id="textoAlerta"></p>        
        </div>
        <div class= "textoFecha">
           <label>Fecha de Alerta <input id="fechaAlerta" type="date"  required></label> 
        </div>
        <hr>
        <div class= "grabaFecha">
          <a href="#" class ="btnGrabaAlerta">Guardar</a>
        </div>
        <input type="hidden" id="idTareaAlerta" name = "idTareaAlerta" >
      </div>
   </div>
  </div>     
 <!--Termina Modal Alertas de tareas-->  
<!--Modal para visualizar tetxo de tareas  tareas-->
 <div class="modalVisualiza" id='modalVisualiza'>      
   <div class="bodymodal">   
   <div class="btncierra">
       <button class =".cierra-modalTarea" onclick="cierraModalvisualiza()"><i class="fas fa-times"></i></button>             
       </div>
     <div class="contenedor-modalTexto">       
       <div>
         <p id="textoMostrar"></p>
         </div>
      </div>
   </div>
  </div>     
 <!--Termina Modal para visualizar   tareas-->  
<!--Modal para mostar  tareas Terminada-->  
 <div class="modalmuestraTareacom" id='modalmuestraTareacom'>      
   <div class="bodymodal">   
     <div class="contenedor-modalmuestraTareaimp">       
        <div class="btncierra">
         <button class ="cierra-modalmuestraTareaimp" onclick="cierramodalmuestraTareacom()"><i class="fas fa-times"></i></button>             
        </div>
       
          <div class= "textoFec">
            <h2 align="center">Lista de Tareas Completadas</h2>
           
           <div class = "tareas" id="tareas">
                <ul id="tareaImportantes">
                 
                 </ul>
             </div>       
        </div>
        <hr>        
      </div>
   </div>
  </div>     
 <!--Termina Modal tareras Terminadas-->  
<!--Modal para mostar  tareas importantes-->
<div class="modalmuestraTareaimp" id='modalmuestraTareaimp'>      
   <div class="bodymodal">   
     <div class="contenedor-modalmuestraTareaimp">       
        <div class="btncierra">
         <button class ="cierra-modalmuestraTareaimp" onclick="cierramodalmuestraTareaimp()"><i class="fas fa-times"></i></button>             
        </div>
       
          <div class= "textoFec">
            <h2 align="center">Lista de Tareas Importantes</h2>
           
               <div class = "tareas" id="tareas">
                  <!--ul id="tareaImportantes">
                  <?php
                  /*if($devuelveEstrellas)
                    { 
                     foreach($devuelveEstrellas as $estrellas)
                     {
                       ?>
                      <li id= "<?php echo $estrellas->idtarea ?>"><p> <?php echo $estrellas->nombre ?> </p> <div class="icono-estrella"><i class="far fa-star estrella"></i></div></li>                   
                       <?                      
                      }
                    }*/
                  ?>

                                    
                  </ul-->
                  <ul id="listatareaImportante">
                  
                                    
                  </ul>
             </div>       
        </div>
        <hr>        
      </div>
   </div>
  </div>     
 <!--Modal para mostar  tareas Terminada-->  
<!--Modal para mostrar fecha  de Entrega de tareas-->
<div class="modalEntregatareas" id='modalEntregatareas'>      
   <div class="bodymodal">   
     <div class="contenedor-modalFecha">       
        <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierraModalentregatareas()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div class= "textoEntregaTareas">
            <h2 align="center">Fecha de Entrega de Tareas</h2>
            <div class = "tareas" id="tareas">
                 <ul id="tareaFechaImportantes">
                 
                 </ul>
                  </ul>
             </div>       
        </div>
        <hr>
      </div>
   </div>
  </div>     
 <!--Termina Modal mostrar fecha de Entregas-->   
<!--Modal para mostrar Alerta  de Entrega de tareas-->
<div class="modalEntregaalertas" id='modalEntregaalerta'>      
   <div class="bodymodal">   
     <div class="contenedor-modalFecha">       
        <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierraModalentregaalertas()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div class= "textoEntregaTareas">
            <h2 align="center">Alerta  de Tareas</h2>
            <div class = "tareas" id="tareas">
            <ul id="tareaAlerta">
                
                </ul>
           </div>       
        </div>
        <hr>
      </div>
   </div>
  </div>     
  <!--Fechas Pospuestas -->
  <div class="modalMuestraFechaPos" id='modalMuestraFechaPos'>      
   <div class="bodymodal">   
     <div class="contenedor-modalMuestraFechaPos">       
       <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierramuestraPosFecha()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div class= "textomuestraPosFecha">
            <h2 align="center"> Fechas Pospuestas</h2>
           <p id="textoposFecha"></p>        
        </div>
        <hr>
        <div class ="menu-fecha">
          <label for="">Año  <select name="ano" id="ano" required=""><?=  imprimirFecha()  ?></select>
          </label>
          <label for="">Mes
          <select name="mes" id="mes" disableb select>
           <option disableb select value=""> --Selecione</option>
           <option value="1">Enero</option>
           <option value="2">Febrero</option>
           <option value="3">Marzo</option>
           <option value="4">Abril</option>
           <option value="5">Mayo</option>
           <option value="6">Junio</option>
           <option value="7">Julio</option>
           <option value="8">Agosto</option>
           <option value="9">Septiembre</option>
           <option value="10">Octubre</option>
           <option value="11">Noviembre</option>
           <option value="12">Diciembre</option>        
           </select>
          </label>
          <label for="">Dia
          <select name="dia" id="dia" disableb select>
           <option disableb select value=""> --Selecione</option>
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
           <option value="11">11</option>
           <option value="12">12</option>        
           <option value="13">13</option>        
           <option value="14">14</option>        
           <option value="15">15</option>        
           <option value="16">16</option>        
           <option value="17">17</option>        
           <option value="18">18</option>        
           <option value="19">19</option>        
           <option value="20">20</option>        
           <option value="21">21</option>        
           <option value="22">22</option>        
           <option value="23">23</option>        
           <option value="24">24</option>        
           <option value="25">25</option>        
           <option value="26">26</option>        
           <option value="27">27</option>        
           <option value="28">28</option>        
           <option value="29">29</option>        
           <option value="30">30</option>        
           <option value="31">31</option>        
           </select>
          </label>
          </label>
        </div>
        <div class="btnmuestra">
          <a >Muestra</a>
        </div>
        <div class = "fecha_pospuestas" id="fecha_pospuestas">
                  <div class="muestra-proyectos">
                    <p>Proyecto</p>
                  </div>  
                  <div class="muestra_proyectos">
                   <ul id="muestraproyectos">
                 
                   </ul>                  
                  </div>
                  <div class="muestra-proyectos">
                    <p>Tareas</p>
                  </div>  
                  <div class="muestra_proyectos">
                  <ul id="muestratareas">
                 
                  </ul>
                  </div>  
                  <div class="muestra-proyectos">
                    <p>Sub-Tareas</p>
                  </div> 
                  <div class="muestra_proyectos">
                  <ul id="muestrasubtareas">
                 
                 </ul>
                 </div> 
        </div>    
      <input type="hidden" id="idTareaposFecha" name = "idTareaposFecha" >
      </div>
   </div>
  </div>     

 <!--Termina MuestraFecha Pospuestas>   



   <!--Empieza Modal-->  
  <div class="modal" id='modalProyecto'>      
   <div class="bodymodal">   
    <div class="contenedor-modal">
      <aside class="aside-modal-izquierda">
        <div style="width: 120px; display: list-item;height: 600px;overflow: scroll;margin-left: 2%"><?=imprimirBotonera($clasificacionUsuarios)?></div>
      </aside>
      <div class = "contenedor-titProyecto">
         <div class ="titProyecto">
             <?php
                if($id_proyecto)
                { 
                 foreach($proyectosActual->result() as $proyectoAct){
                 ?>
                    <h2 id = "tituloProyecto" class="titulo-modal">Compartir Proyecto: <?php echo $proyectoAct->nombre ?></h2> 
                    <button class ="cierra-modal" onclick="cierraModal()"><i class="fas fa-times"></i></button>
                    <input type="hidden" id="nombreProyecto" name = "nombreProyecto" value="<?php echo $proyectoAct->nombre?>">
                    <input type="hidden" id="fechaProyecto" name = "fechaProyecto" value="<?php echo $proyectoAct->fecha?>">
                    <input type="hidden" id="horaProyecto" name = "horaProyecto" value="<?php echo $proyectoAct->hora?>">      
                <?}
                }
             ?>     
         </div> 
          <!--Buscamos Cliente en la tabla-->
           <div class="col-md-4 col-sm-4 col-xs-4 ocultarObjeto" id="divBuscarCliente">
             <h2 style="text-align:center">Buscador</h2>
             <input type="text" id="buscador" class="buscador sombra" placeholder="Buscar Invitados..."></button>
           </div> 
           <div class="contenedor-tabla">
               <table id="listado-contactos" class="listado-contactos">                  
                <thead>
                         <tr>
                              <th>id</th>
                              <th>Nombre</th>
                              <th>Email</th>
                              <th>Clasificacion</th>
                              <th>Agregar</th> 
                         </tr>
                    <tbody id="tabla-contactos" class= "tabla-contactos">
                         <!--td> 125  </td>
                         <td> hugo ceja mendoza  </td>
                         <td> <a class="btn-agregar btn" ><i class="far fa-check-circle completo"></i> </a> </td-->
                    </tbody>     
                 </thead>
                </table>
            </div>
          <!--Agregamos Titulo para Agrega Invitado al Proyecto-->
          <div class="invitadoProyecto">
               <h2>Invitados Agregados</h2> 
               <div class="invitadoExterno">
                 <label>Agrega Inivitado <input type="text" class="UpperCase" id="invitadoExterno" name="invitadoExterno" placeholder="ejemplo@dominio.com"  autocomplete="off" ><i class="fas fa-user-plus fa-x icono"></i></label>
               </div>
          </div>
          <div class="listaInvitado">
              <ul id="ullistaInvitado">
                 
              </ul>
          </div>
          <!--Termina Invitados-->  
       </div>
   </div>
  </div>  
</div>


          <div class = "seccion-principal">
             <main>
               <div class="contenedor-app">
                  <div class="contenedor-tareas">
                    <?php  
                     if($id_proyecto)
                     { 
                     foreach($proyectosActual->result() as $proyectoAct){
                     ?>
                     <div class = "barra_tareas">
                       <span><?php echo $proyectoAct->nombre?>...</span>
                     </div> 
                     <div class="texto_derecha">
                     <button type="button"class ="agregaInvitados" onclick="abrirModalProyecto()">AgregaInvitados </button> 
                     </div>                                       
                     <?
                      } 
                     }
                     else
                     {?>
                      <div class = "agrega_usuario">
                       <span>Seleccione Proyecto...</span>
                     </div>   
                     <?
                      }
                      ?> 
                    </div>
                  <div class="agrega_Tareas">
                            <div class="tittarea1">
                              <input type="text" id='nuevo-tarea'>
                            
                            </div>
                            <div class="tittarea">
                              <span>Agrega tareas <i class="fas fa-user-plus fa-x icono"></i></span> </input>
                            </div>                 
                   </div> 
                <div class = "tareas" id="tareas">
                  <ul id="tareaAgregadas">
                 
                  <?php
                  // if($id_proyecto)
                  //  { 
                     foreach($devuelveTareas->result() as $tareasAct){
                      if(isset($tareasAct->fechaentrega)) 
                      {
                        $pintar =   "far fa-calendar-alt  cafe";
                      }
                      else{
                      $pintar =   "";
                      }
                      if($tareasAct->completado == 1){
                         $terminado = "far fa-check-circle icono terminado";
                      }
                      else{
                        $terminado = "";
                      }
                      if($tareasAct->estrella == 1)
                      {
                        $estrella ="far fa-star estrella";
                      }
                      else{
                        $estrella ="";
                      }
                      if($tareasAct->alerta == 1)
                      {
                        $alerta ="fas fa-stopwatch icono";
                      }
                      else{
                        $alerta ="";
                      }

                      $usuarios ="fas fa-user-plus fa-x icono";
                      $basura ="fas fa-trash-alt icono" ;
                       if($tareasAct->completado == 0)
                       {
                        if($tareasAct->estrella == 0)// if($tareasAct->idaccion == 0)
                        { 
                         ?>
                         <div class="sub">
                         <li id= "<?php echo $tareasAct->idtarea ?>"><i class="fas fa-angle-double-down icono"></i><p> <?php echo $tareasAct->nombre ?> </p> <div class="icono-tarea">  <i class="<?echo $terminado?>" title="Tareas Completadas"></i> <i class="<?echo $estrella?>" title="Tareas Importantes"></i><i class="<?echo $pintar?>"  title="Entrega de Tareas"></i><i class="<?echo $alerta?>" title="Alerta de Tareas"></i><i class="fas fa-tasks icono"  title="Agrega SubTareas"></i> <i class="fas fa-align-justify icono"></i></div> </li>                  
                          
                            <div class = "subtareas ocultar" id="subtareas<?php echo $tareasAct->idtarea?>" >
                            <ul id="subtareaAgregadas<?php echo $tareasAct->idtarea ?>">
                           <? 
                           // var_dump($devuelvesubTareas);
                           foreach($devuelvesubTareas->result() as $subtareas)
                           {
                            //var_dump($subtareas->agregafecha);
                            if(isset($subtareas->agregafecha)) 
                            {
                             
                              if($subtareas->agregafecha ==1) 
                              {
                               $subpintar =   "far fa-calendar-check cafe";
                              }
                              else{
                                $subpintar =   "far fa-calendar-check icono";
                              }
                            }  
                            else{
                            $subpintar =   "far fa-calendar-check icono";
                            }

                            if($tareasAct->idtarea == $subtareas->idtarea)
                            {
                               //subtarea no acompletada
                              if($subtareas->completado == 0)
                              { 
                               if($tareasAct->idtarea == $subtareas->idtarea)
                                {
                                  if($subtareas->estrella == 0)
                                  {
                                  ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>"title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  } 
                                }
                               }
                               //subtarea acompletada 
                               if($subtareas->completado == 1)
                                { 
                                if($tareasAct->idtarea == $subtareas->idtarea)
                                 {
                                  if($subtareas->estrella == 0)
                                  {
                                  ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i class="<?echo $subpintar?>"title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  } 
                                 }
                                }   
                             }
                           }   
                           ?>  
                             </ul>
                              <div class="subavance">
                                 <spam>SubAvance:</spam>
                                  <div class="subbarra-avance" id="subbarra-avance<?php echo $tareasAct->idtarea?>">
                                   <div class="subporcentaje" id="subporcentaje<?php echo $tareasAct->idtarea?>">
                                   </div>
                                 </div>
                               </div>                     
                            
                           
                           
                           </div>   
                           </div> 
                           <?
                        }
                        if($tareasAct->estrella == 1)// if($tareasAct->idaccion == 1)
                        {
                          ?>
                          <div class="sub">
                         <li id= "<?php echo $tareasAct->idtarea ?>"><i class="fas fa-angle-double-down subicono"></i><p> <?php echo $tareasAct->nombre ?> </p> <div class="icono-tarea"><i class="<?echo $terminado?>"  title="Tareas Completadas"></i> <i class="<?echo $estrella?>" title="Tareas Importantes"></i><i class="<?echo $pintar?>" title="Entrega de Tareas"></i><i class="<?echo $alerta?>"  title="Alerta de Tareas"></i><i class="fas fa-tasks icono"  title="Agrega SubTareas"></i><i class="fas fa-align-justify icono"></i></div></li>                   
                         <div class = "subtareas ocultar"id="subtareas<?php echo $tareasAct->idtarea?>" >
                         <ul id="subtareaAgregadas<?php echo $tareasAct->idtarea ?>">
                           <? 
                           foreach($devuelvesubTareas->result() as $subtareas)
                           {
                            if(isset($subtareas->agregafecha)) 
                            {
                             
                              if($subtareas->agregafecha ==1) 
                              {
                               $subpintar =   "far fa-calendar-check cafe";
                              }
                              else{
                                $subpintar =   "far fa-calendar-check icono";
                              }
                            }  
                            else{
                            $subpintar =   "far fa-check-alt icono";
                            }
                            if($tareasAct->idtarea == $subtareas->idtarea)
                            {
                               //subtarea no acompletada
                              if($subtareas->completado == 0)
                              { 
                               if($tareasAct->idtarea == $subtareas->idtarea)
                                {
                                  if($subtareas->estrella == 0)
                                  {
                                  ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>"title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  } 
                                }
                               }
                               //subtarea acompletada 
                               if($subtareas->completado == 1)
                                { 
                                if($tareasAct->idtarea == $subtareas->idtarea)
                                 {
                                  if($subtareas->estrella == 0)
                                  {
                                  ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  } 
                                 }
                                }   
                             }
                            }   
                           ?>    
                             </ul>
                               <div class="subavance">
                                 <spam>SubAvance:</spam>
                                  <div class="subbarra-avance" id="subbarra-avance<?php echo $tareasAct->idtarea?>">
                                   <div class="subporcentaje" id="subporcentaje<?php echo $tareasAct->idtarea?>">
                                   </div>
                                 </div>
                               </div>                                        
                            
                           </div> 
                           </div>   
                           <?
                        }
                       
                      }
                       else
                       {
                        if($tareasAct->estrella == 0)// if($tareasAct->idaccion == 0)
                        {
                         ?>
                          <div class="sub">
                         <li id= "<?php echo $tareasAct->idtarea ?>"><i class="fas fa-angle-double-down subicono"></i><p> <?php echo $tareasAct->nombre ?> </p> <div class="icono-tarea">  <i class="<?echo $terminado?>" title="Tareas Completadas"></i><i class="<?echo $estrella?>" title="Tareas Importantes"></i><i class="<?echo $pintar?>" title="Entrega de Tareas"></i><i class="<?echo $alerta?>"  title="Alerta de Tareas"></i><i class="fas fa-tasks icono"  title="Agrega SubTareas"></i><i class="fas fa-align-justify icono"></i></div></li>                   
                         <div class = "subtareas ocultar" id="subtareas<?php echo $tareasAct->idtarea?>" >
                          <ul id="subtareaAgregadas<?php echo $tareasAct->idtarea ?>">
                           <? 
                           foreach($devuelvesubTareas->result() as $subtareas)
                           {
                            if(isset($subtareas->agregafecha)) 
                            {
                             
                              if($subtareas->agregafecha ==1) 
                              {
                               $subpintar =   "far fa-calendar-check cafe";
                              }
                              else{
                                $subpintar =   "far fa-calendar-check icono";
                              }
                            }  
                            else{
                            $subpintar =   "far fa-calendar-alt icono";
                            }
                             if($tareasAct->idtarea == $subtareas->idtarea)
                             {
                              //subtarea no acompletada
                               if($subtareas->completado == 0)
                               { 
                                if($tareasAct->idtarea == $subtareas->idtarea)
                                 {
                                  if($subtareas->estrella == 0)
                                  {
                                  ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  } 
                                 }
                                }
                                //subtarea acompletada 
                                if($subtareas->completado == 1)
                                 { 
                                 if($tareasAct->idtarea == $subtareas->idtarea)
                                  {
                                    if($subtareas->estrella == 0)
                                  {
                                  ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                   <?
                                  } 
                                  }
                                 }  
                               }
                               
                             }   
                           ?>     
                             </ul>
                               <div class="subavance">
                                 <spam>SubAvance:</spam>
                                  <div class="subbarra-avance" id="subbarra-avance<?php echo $tareasAct->idtarea?>">
                                   <div class="subporcentaje" id="subporcentaje<?php echo $tareasAct->idtarea?>">
                                   </div>
                                 </div>
                               </div>                                       
                            
                           </div>   
                           </div>
                           <?
                        }
                        if($tareasAct->estrella == 1)//if($tareasAct->idaccion == 1)
                        {
                          ?>
                          <div class="sub">
                         <li id= "<?php echo $tareasAct->idtarea ?>"><i class="fas fa-angle-double-down subicono"></i><p> <?php echo $tareasAct->nombre ?> </p> <div class="icono-tarea"> <i class="<?echo $terminado?>" title="Tareas Completadas"></i><i class="<?echo $estrella?>"title="Tareas Importantes"></i><i class="<?echo $pintar?>" title="Entrega de Tareas"></i><i class="<?echo $alerta?>"  title="Alerta de Tareas"></i><i class="fas fa-tasks icono"  title="Agrega SubTareas"></i><i class="fas fa-align-justify icono"></i></div></li>                   
                         <div class = "subtareas ocultar" id="subtareas<?php echo $tareasAct->idtarea?>"  >
                             <ul id="subtareaAgregadas<?php echo $tareasAct->idtarea ?>">
                           <? 
                           foreach($devuelvesubTareas->result() as $subtareas)
                           {
                            if(isset($subtareas->agregafecha)) 
                            {
                             
                              if($subtareas->agregafecha ==1) 
                              {
                               $subpintar =   "far fa-calendar-check cafe";
                              }
                              else{
                                $subpintar =   "far fa-calendar-check icono";
                              }
                              }  
                              else{
                              $subpintar =   "far fa-calendar-check icono";
                              }
                             if($tareasAct->idtarea == $subtareas->idtarea)
                             {
                             //subtarea no acompletada
                             if($subtareas->completado == 0)
                             { 
                              if($tareasAct->idtarea == $subtareas->idtarea)
                               {
                               ?>   
                                <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                <?
                               }
                              }
                              //subtarea acompletada 
                              if($subtareas->completado == 1)
                               { 
                               if($tareasAct->idtarea == $subtareas->idtarea)
                                {
                                 ?>   
                                 <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i></div></li>                   
                                  <?
                                }
                               }
                             }
                           }   
                           ?>      
                             </ul> 
                               <div class="subavance">
                                 <spam>SubAvance:</spam>
                                  <div class="subbarra-avance" id="subbarra-avance<?php echo $tareasAct->idtarea?>">
                                   <div class="subporcentaje" id="subporcentaje<?php echo $tareasAct->idtarea?>">
                                   </div>
                                 </div>
                               </div>                                      
                                                      
                           </div> 
                          </div> 
                         
                         <?
                        }
                      
                       }
                       
                       ?>

                       <!--barra de subvances >
                       <div class="subavance">
                        <spam>SubAvance:</spam>
                        <div class="subbarra-avance" id="subbarra-avance<?php echo $tareasAct->idtarea?>">
                          <div class="subporcentaje" id="subporcentaje<?php echo $tareasAct->idtarea?>">
                          </div>
                         </div>
                        </div>
                        <Termina barra-->
                      <!--Si idproyecto no existe-->   

                   <!-- Ventana de icono-->
                     <div class="ventana ocultar" id ='V<?php echo $tareasAct->idtarea?>'>
                            <ul>
                            <div class="subventana" id="subventana">
                              
                                 
                                <li>
                                  <div class="completados" id ="agrega-Usario">
                                  <p>Agregar</p> <i class="fas fa-user-plus fa-x icono" title="Agrega Usuarios"> </i>
                                  </div>  
                                </li>
                                
                                
                                <li>                             
                                <div class="completados" id ="completados">
                                 <p>Completadas</p> <i class="far fa-check-circle icono"title="Tareas Completadas"> </i>
                                 </div>
                              </li>
                              
                              
                               <li>
                                <div class="completados" id ="elimina-Tareas">
                                 <p>Elimnar</p><i class="fas fa-trash-alt icono"title="Eliimina Tareas"> </i>
                                </div>
                               </li>
                             
                              <li>
                               <div class="completados" id ="importanteTareas">
                                <p>Importante</p><i class="far fa-star icono" title="Tareas Importantes"></i>
                               </div>
                               </li>

                              <li>
                                <div class="completados" id ="agendaTareas">
                                 <p>Agendar</p><i class="far fa-calendar-alt icono"  title="Agenda Tareas"></i>
                                 </div>
                              </li>
                              
                              <li>
                               <div class="completados" id ="alertaTareas">
                                  <p>Alerta</p><i class="fas fa-stopwatch icono" title="Alerta de Tareas"></i>
                                </div>
                               </li>
                              
                            </div>
                            </ul>
                        </div>  
                        <?
                     // }
                     
                    }                    
                   ?>
                   

                  </ul>
                  <div class="avance">
                    <spam>Avance:</spam>
                    <div class="barra-avance" id="barra-avance">
                       <div class="porcentaje" id="porcentaje">
                       </div>
                    </div>
                  </div>
             
              </div>                
             </main>         
      </div>

  </div> 


  <?php
function imprimirFecha()
{ $option="";

  for($i=date("Y");$i>=2018;$i--){ $option.="<option value='".$i."'>".$i."</option>";}
    return $option;
}
?>



 <link rel="stylesheet" href="<?php echo base_url();?>css/sweetalert2.min.css">  
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
 document.addEventListener("DOMContentLoaded", function() {
    actualizaBarra();
    actualizasubBarra();
   // InicioUsuario();
  });
eventListeners();
function eventListeners(){
  document.querySelector('.btnGrabafecha').addEventListener('click',grabaFecha);
  document.querySelector('#listado-empleados tbody').addEventListener('click',agregaEmpleado);
  document.querySelector('#tareaAgregadas').addEventListener('click',agregaPersona);
  document.querySelector('.contenedor-app .agrega_Tareas').addEventListener('click',agregaTarea);
  document.querySelector('.crear-proyecto a').addEventListener('click',nuevoProyecto);
  document.querySelector('#listado-contactos tbody').addEventListener('click',agregaInvitado);
  document.querySelector('#buscador').addEventListener('input',buscaContacto);
  document.querySelector('.listaInvitado ul').addEventListener('click',eliminaInv);
  document.querySelector('.invitadoExterno').addEventListener('click',agregaExterno);
  document.querySelector('.tareaExterno').addEventListener('click',tareaExterno);
  document.querySelector('#ullistaEmpleados').addEventListener('click',eliminaEmpleado);  
  document.querySelector('.btnGrabaAlerta').addEventListener('click',grabaAlerta);
  document.querySelector('.actividadesTareas').addEventListener('click',muestratareasImportantes); 
  document.querySelector('.btnmuestra').addEventListener('click',muestraposFecha); 
  document.querySelector("#proyectos").addEventListener('click',posponeFecha);
  document.querySelector('.grabaposFecha').addEventListener('click',grabaposFecha);
  document.querySelector('#grabaSubtarea').addEventListener('click',agregaSubtarea); 
   
}
/********************************************************* */



  /********************************************************* */
 function actualizaBarra(){

//var tareas = document.querySelectorAll('#tareaAgregadas li');
  var tareas = document.querySelectorAll('.sub');
// console.log(tareas);
 var tareasCompletas = document.querySelectorAll('.sub');
 let sumatareas=0;
 for(var i=0; i < tareasCompletas.length; i++)
 {
  var hijo = tareasCompletas[i];
  if(hijo.children[0].children[2].children[0].classList.contains('terminado'))
  {
   sumatareas ++;
  }
 
 }
  
 //console.log(tareasCompletas);
// const avance = Math.round((tareasCompletas.length/tareas.length)*100);
const avance = Math.round((sumatareas/tareas.length)*100);
 const porcentaje = document.querySelector('#porcentaje');
 porcentaje.style.width = avance+'%';
 //console.log(tareas.length);
 //console.log(tareasCompletas.length);
 return;
} 

 /********************************************************* */ 
 /********************************************************* */
function agregaSubtarea(){
 //console.log('llego');
 var subtarea = document.querySelector("#nuevaSubtarea").value;
 var idproyecto = getParameterByName('idproyecto');
 var idtarea = document.querySelector("#inpsubtarea").value;
 var idtar = document.querySelector("#inpsubtarea").value;
 //var idtarea = e.target.parentElement.parentElement; 
 //console.log(subtarea);
 if(subtarea =="")
 {
  Swal.fire(
         'Error!',
         'Necesita agregar datos a la tarea',
         'success'
       )
   return;
 }
 //Agregamos subtarea
 var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('nombre',subtarea);
  datos.append('idproyecto',idproyecto);
  datos.append('idtaera',idtarea);
  xhr.open('POST',"<?php echo base_url();?>cproyecto/grabasubTarea",true);
  xhr.onload = function(){
    if(this.status===200){
      var respuesta =JSON.parse(xhr.responseText);
     // console.log(respuesta);
      var tarea = respuesta.tarea,
          idtarea = respuesta.idtarea;
      var nuevoTarea = document.createElement('Li'); 
      nuevoTarea.id = idtarea;   
             nuevoTarea.innerHTML=`
         <p>${tarea}</p> <div  class="icono-tarea" > <i class="fas fa-user-check fa-x icono" title="Agrega Usuarios"></i><i class="far fa-check-square icono" title="Tareas Completadas"></i><i class="fas fa-trash  icono"  title="Elimina Tareas"></i> <i class="far fa-sun  icono" title="Tareas Importantes"></i><i class="far fa-calendar-check icono" title="Entrega de Tareas"></i><i class="far fa-clock  icono"  title="Alerta de Tareas"></i>
         </div>         
        `;
      
       var listaTareas = document.querySelector("#subtareaAgregadas"+idtar);
       listaTareas.appendChild(nuevoTarea);
       var barrasubtarea = document.querySelector("#subbarra-avance"+idtar); 
      
      Swal.fire({
        title: 'SubTarea Agregado',
        text: 'La SubTarea se creo correctamente',
        type: 'success'
      })
      $('#nuevaSubtarea').val('');
      $(".modalsubTareas").fadeOut();  
     actualizasubBarra();
    }
  }
   xhr.send(datos);
 
 return;
 //Termina subtarea

}
/********************************************************* */
 /********************************************************* */
function actualizasubBarra(){
 // console.log(vidsubventa);
 
 var numero = vidsubventa.id.split("subtareas");
 var idbarra = document.querySelectorAll("#subtareaAgregadas"+numero[1]+ " li");
 var hijabarra = vidsubventa.childNodes;
 //console.log(hijabarra[1].childNodes[3].childNodes[2].childNodes[3]);
 
  var barra =0,avance=0;
  for(i=0;i < idbarra.length;i++){
   if((idbarra[i].childNodes[2].childNodes[3].classList.contains('terminado')))
    {
    
      avance++;
    }
    
  }
  var total = Math.round((avance/idbarra.length)*100);
          //console.log('#subporcentaje'+valor); 
          var porcentaje = document.querySelector('#subporcentaje'+numero[1]);
         // console.log(porcentaje); 
            porcentaje.style.width = total+'%';
 // console.log(avance);
 /* for(i=0;i<tareas.length;i++){
   // console.log( tareas[i].parentNode.classList.value =="sub");
   if(tareas[i].parentNode.classList.value =="sub")
   {
     var valor = tareas[i].id;
     var cadena = '#subtareaAgregadas'+valor+ ' li';
     //console.log(valor);
     barra =0;
     avance=0;
     var subtareas = document.querySelectorAll('#subtareaAgregadas'+valor+ ' li');
     //console.log(subtareas);
      //var subtareasCompletas = document.querySelectorAll(cadena+' i.terminado');
      //console.log(subtareasCompletas.length);
       for(j=0;j<subtareas.length;j++){
              if(subtareas[j].lastChild.getElementsByTagName('i')[1].classList.contains('terminado'))
              {
               // console.log('subtareas');
               barra++;
              }
               //var hijos = subtareas[j].lastChild;
             avance++;
       }
      // console.log(avance); 
      // console.log(barra); 
      if (avance >0)
      {
        if (barra >0)
        {
          var total = Math.round((barra/avance)*100);
          //console.log('#subporcentaje'+valor); 
          var porcentaje = document.querySelector('#subporcentaje'+valor);
          //console.log(porcentaje); 
            porcentaje.style.width = total+'%';
        }
       
      }
      else{
          porcentaje.style.width = 0+'%';
        }
     // if (avance ==0)
     // {
            //}
      //j++;
   }
  }
 // console.log(j);*/
 return;
  }

/********************************************************* */
function grabaFecha(e)
{
  e.preventDefault();
  //console.log("Graba Fecha");
  var idtarea=document.querySelector('#idTareaFecha'); 
  var fechaTarea=document.querySelector('#fechaTarea'); 
  // console.log(fechaTarea.value);
  var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.value);
            datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaFechaTarea",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                 //console.log(respuesta);
                 Swal.fire({
                   title: 'Fecha Agregado',
                   text: 'Se agrego La Fecha correctamente',
                    type: 'success'
                  })
              }
            }
            xhr.send(datos);
}
/********************************************************** */
/********************************************************* */
function grabaposFecha(e){
  var idposfecha = document.querySelector('#idTareaposFecha').value;
  var porfecha = document.querySelector('#posFecha').value;
  var pintar = document.getElementById('id'+idposfecha);
  var idpro = pintar.id.split("id");
  idpro = idpro[1];
  //console.log(idpro);
  //console.log(pintar.hasAttribute('estrella'));
  //console.log(e.target.parentElement.parentElement.parentElement.parentElement);
  //console.log(porfecha);
 var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('idposfecha',idposfecha);
  datos.append('posfecha',porfecha);
  if(porfecha =="")
  {
    //$('#posFecha')
    document.getElementById('posFecha').focus();
    Swal.fire({
        title: 'FECHA',
        text: 'Necesita la Fecha ',
        type: 'success'
      })
      return;
  }
 // datos.append('idtaera',idtarea);
  xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaposFecha",true);
  xhr.onload = function(){
    if(this.status===200){
      var respuesta =JSON.parse(xhr.responseText);
      //console.log(respuesta);
     if(respuesta == 1)
     {
      Swal.fire({
        title: 'PosFecha',
        text: 'Se agrego nueva fecha creo correctamente',
        type: 'success'
      })
      if(!pintar.classList.contains('estrella'))
      {
        pintar.classList.add('estrella');
      }
      $(".modalposFecha").fadeOut(); 
     } 
     
    }
  }
  //Enviar el request
  xhr.send(datos);
 return;
}
/********************************************************* */
/********************************************************* */
function posponeFecha(e){
  var posfecha = e.target;
  var nombre = e.target.parentElement;
  // console.log(posfecha);
  if(posfecha.classList.contains('fa-calendar-check'))
  {
   //console.log(nombre.children[0]);
   //console.log(nombre.val);
   var idposfecha =nombre.children[0].id;
   var nosmbrepos =nombre.children[0].textContent;
   $('#textoposFecha').text(nosmbrepos);
   //textoFecha
   $('#idTareaposFecha').val(idposfecha);
   $(".modalposFecha").fadeIn();
  // console.log(idposfecha);
  // console.log(nosmbrepos);
   
  }
  return;
}
/********************************************************* */
function muestraposFecha()
{ 
  //console.log('llego');
  var mes = document.getElementById('mes').value;
  var ano = document.getElementById('ano').value;
  var dia = document.getElementById('dia').value;
  //console.log(dia);
  var xhr = new XMLHttpRequest();
  var datos = new FormData();
  if(mes == '')
  {
    
    datos.append('ano',ano);
   datos.append('mes','0');
    datos.append('dia','0');
    datos.append('tipo','1');
  
  } 
  else
   {
    if((mes != '') && (dia ==''))
    {
     // console.log('mes');
     datos.append('ano',ano);
     datos.append('mes',mes);
     datos.append('dia',0);
     datos.append('tipo',2);  
    } 
    else{
      //console.log('dia');
    datos.append('ano',ano);
    datos.append('mes',mes);
    datos.append('dia',dia);
    datos.append('tipo',3);
   }
  }
 // datos.append('ano',ano);
  xhr.open('POST',"<?php echo base_url();?>cproyecto/muestraposFecha",true);
  xhr.onload = function(){
    if(this.status===200){
      var respuesta =JSON.parse(xhr.responseText);
      console.log(respuesta.tarea);
      var lis = document.querySelectorAll('#muestraproyectos li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
     for( i =0; i < respuesta.proyecto.length ; i++)
     {
      //console.log(respuesta.proyecto[i].nombre);
      var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta.proyecto[i].nombre +"---<spam class= 'tipocolor'>"+ respuesta.proyecto[i].fecha+"</spam></p>";
                         var listaTareas = document.querySelector("#muestraproyectos");
                         //console.log(listaTareas);
                       listaTareas.appendChild(nuevoTarea);
                   //    $("#ullistasubEmpleados").append("<li> "+respuesta[i].nombre +"<i class='far fa-star estrella'></i></li>");      
     }
     var lis = document.querySelectorAll('#muestratareas li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
               
      //console.log(respuesta.proyecto[i].nombre);
      for( i =0; i < respuesta.tarea.length ; i++)
     {
      var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta.tarea[i].nombre +"---<spam class= 'tipocolor'>"+ respuesta.tarea[i].fechaentrega+"</spam></p>";
                         var listaTareas = document.querySelector("#muestratareas");
                         //console.log(listaTareas);
                       listaTareas.appendChild(nuevoTarea);
                   //    $("#ullistasubEmpleados").append("<li> "+respuesta[i].nombre +"<i class='far fa-star estrella'></i></li>");      
     }
       var lis = document.querySelectorAll('#muestrasubtareas li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
     for( i =0; i < respuesta.subtarea.length ; i++)
     {
      var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta.subtarea[i].nombre +"---<spam class= 'tipocolor'>"+ respuesta.subtarea[i].fechaentrega+"</spam></p>";
                         var listaTareas = document.querySelector("#muestrasubtareas");
                         //console.log(listaTareas);
                       listaTareas.appendChild(nuevoTarea);
                   //    $("#ullistasubEmpleados").append("<li> "+respuesta[i].nombre +"<i class='far fa-star estrella'></i></li>");      
     }           
   
      /*Swal.fire({
        title: 'PosFecha',
        text: 'Se agrego nueva fecha creo correctamente',
        type: 'success'
      })
      if(!pintar.classList.contains('estrella'))
      {
        pintar.classList.add('estrella');
      }*/     
    }
  }
  
  xhr.send(datos);
  return;
 
}
/********************************************************* */


function agregaInvitado(e){
  e.preventDefault();
   const nom = e.target.parentElement;
   const nombre=e.target.parentElement.parentElement;
   const nodos = e.target.parentElement.parentElement.parentElement;
   var correo = nodos.childNodes[2].textContent;
   var tipo = nodos.childNodes[3].textContent;
   var tip="" 
   //console.log(nodos.childNodes[2].textContent);
  if(tipo == "CLIENTES")
   {
     tip = "CLIENTES";
   }
   else
   {
     tip = "OPERATIVO";
   }
   if(tipo =="")
   {
     tip = "EXTERNO";
   }
   var idproyecto = getParameterByName('idproyecto');
   var nomurl = "<?php echo base_url();?>"+"cproyecto/muestraProyectosExternos?idproyecto=" + idproyecto;
  // console.log(idproyecto);
  
   //var idproyecto = document.querySelector('#titulo-modal');
    //var idproyecto = $_GET['idproyecto']; 
     //comconsole.log(e.target.classList);
  if(e.target.classList.contains('fa-check-circle'))
   {

     if(e.target.classList.contains('completo'))
       {
         e.target.classList.remove('completo');
        
               
         if(nom.name != 'CLIENTES')
         {
          //Grabamos invitado  k
         // console.log(nom.name);
        //  console.log("entros3");  
           var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('correo',correo);
            datos.append('nombre',nombre.id);
            datos.append('id',nom.id);
            datos.append('tipo',tip);
            datos.append('idproyecto',idproyecto);
            
            xhr.open('POST',"<?php echo base_url();?>cproyecto/agregaInvitado",true);
            //xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaProyecto",true);
            xhr.onload=function()
            {
             
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta);
                var accion = respuesta.respuesta;
                var tiporespuesta =respuesta.tipoerror;
                // console.log(accion);
                if(accion == 'error')
                {
                  Swal.fire('Mensaje de Advertencia',tiporespuesta ,"warning");
                }
                else{
                  $("#ullistaInvitado").append("<li> "+nombre.id +"---"+correo+" <button class ='eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                   Swal.fire('Mensaje de Confirmacion',"Se Invito A : "+nombre.id,"success");
                }
              }
            }
            xhr.send(datos);
         }
         //Vienen Clientes
         else
         {
          if(nom.name == 'CLIENTES')   
          {
            //console.log(nom.name);
            $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $password = "";
            for($i=0;$i<6;$i++) {
                 $password =$password+ $str.substr(Math.random()*63,1);
              }
             var nombreProy = document.querySelector("#nombreProyecto").value;
             var fechaProy = document.querySelector("#fechaProyecto").value;
             var horaProy = document.querySelector("#horaProyecto").value;
   
              var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('correo',correo);
            datos.append('nombre',nombre.id);
            datos.append('id',nom.id);
            datos.append('tipo',tip);
            datos.append('idproyecto',idproyecto);
            datos.append('contrasena',$password); 
            datos.append('nomurl',nomurl);
            datos.append('nombreProy',nombreProy); 
            datos.append('fechaProy',fechaProy); 
            datos.append('horaProy',horaProy); 
            
            xhr.open('POST',"<?php echo base_url();?>cproyecto/agregaCliente",true);
            //xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaProyecto",true);
             xhr.onload=function()
             {
             
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var accion = respuesta.respuesta;
                var tiporespuesta =respuesta.tipoerror;
                // console.log(accion);
                if(accion == 'error')
                {
                  Swal.fire('Mensaje de Advertencia',tiporespuesta ,"warning");
                }
                else{
                  $("#ullistaInvitado").append("<li> "+nombre.id +"---"+correo+" <button class ='eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                   Swal.fire('Mensaje de Confirmacion',"Se Invito A : "+nombre.id,"success");
                }
               }
              }
             xhr.send(datos);

          }
         }
         
       }
      else{
        e.target.classList.add('completo');
      } 
   }
   else{
    console.log('No hiciste clic en le icono');
   }  
}
/******************************************************************* */
function agregaEmpleado(e){
  e.preventDefault();
   const nom = e.target.parentElement;
   const nombre=e.target.parentElement.parentElement;
   const nodos = e.target.parentElement.parentElement.parentElement;
   var correo = nodos.childNodes[2].textContent;
   var tipo = nodos.childNodes[3].textContent;
   var tip="" 
   console.log(nom);
  if(tipo == "CLIENTES")
   {
     tip = "CLIENTES";
   }
   else
   {
     tip = "OPERATIVO";
   }
   var idtarea =  document.querySelector("#idTarea").value;//getParameterByName('idTarea');
   //console.log(idtareas);
   //var nomurl = "<?php echo base_url();?>"+"Cproyecto/muestraProyectosExternos?idproyecto=" + idproyecto;
  if(e.target.classList.contains('fa-check-circle'))
   {
     if(e.target.classList.contains('completo'))
       {
         e.target.classList.remove('completo');
        if(nom.name != 'CLIENTES')
         {
           var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('correo',correo);
            datos.append('nombre',nombre.id);
            datos.append('id',nom.id);
            datos.append('tipo',tip);
            datos.append('idtarea',idtarea);
            //datos.append('idtarea',idtarea);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/agregaEmpleados",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var accion = respuesta.respuesta;
                var tiporespuesta =respuesta.tipoerror;
                 console.log(accion);
                if(accion == 'error')
                {
                  Swal.fire('Mensaje de Advertencia',tiporespuesta ,"warning");
                }
                else{
                  $("#ullistaEmpleados").append("<li> "+nombre.id +"---"+correo+" <button class ='eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                   Swal.fire('Mensaje de Confirmacion',"Se Invito A : "+nombre.id,"success");
                }
               }
             }
             xhr.send(datos);
           }
          }
        }
      else{
        e.target.classList.add('completo');
      } 
   /*}
   else{
    console.log('No hiciste clic en le icono');
   } */ 
   
}

/********************************************************** */
function muestratareasImportantes(e)
{
  /*e.preventDefault();
  //console.log(e.target);
  if(e.target.classList.contains('fa-star'))
  {
   // console.log('Hciste clic en actividades');
   $(".modalmuestraTareaimp").fadeIn(); 
  }
  if(e.target.classList.contains('fa-check-circle'))
  {
    console.log('Hciste clic en actividades');
   $(".modalmuestraTareacom").fadeIn(); 
  }
  if(e.target.classList.contains('fa-calendar-alt'))
  {
   //console.log('Hciste clic en actividades');
   $(".modalEntregatareas").fadeIn(); 
  }
  if(e.target.classList.contains('fa-stopwatch'))
  {
   //console.log('Hciste clic en actividades');
   $(".modalEntregaalertas").fadeIn(); 
  }*/
  e.preventDefault();
 // console.log(e.target);
  if(e.target.classList.contains('fa-star'))
  {
    var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelveEstrellas",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
               // console.log(respuesta)
                var lis = document.querySelectorAll('#listatareaImportante li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                for(let i = 0; i < respuesta.length; i++) {
                 var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta[i].nombre +"---<spam class= 'tipocolor'>"+ respuesta[i].tarea+"</spam></p>";
                         var listaTareas = document.querySelector("#listatareaImportante");
                         //console.log(listaTareas);
                       listaTareas.appendChild(nuevoTarea);
                   //    $("#ullistasubEmpleados").append("<li> "+respuesta[i].nombre +"<i class='far fa-star estrella'></i></li>");      
                } 
                $(".modalmuestraTareaimp").fadeIn(); 
               }
             }
             xhr.send(datos);       

   
  }
  if(e.target.classList.contains('fa-check-circle'))
  {
    //console.log('Hciste clic en actividades');
    var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelveTareascompletas",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);
                var lis = document.querySelectorAll('#tareaImportantes li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                 for(let i = 0; i < respuesta.length; i++) {
                 var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta[i].nombre +"---<spam class= 'tipocolor'>"+respuesta[i].tarea +"</spam></p>";
                         var listaTareas = document.querySelector("#tareaImportantes");
                      //   console.log(listaTareas);
                       listaTareas.appendChild(nuevoTarea);
                } 
                $(".modalmuestraTareacom").fadeIn();               
               }
             }
             xhr.send(datos);       

   //$(".modalmuestraTareacom").fadeIn(); 
  }
  if(e.target.classList.contains('fa-calendar-alt'))
  {
            //Trae el fechas de tarea
           // console.log('llego');
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelveFechaEntrega",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
               // console.log(respuesta);
                var lis = document.querySelectorAll('#tareaFechaImportantes li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                for(let i = 0; i < respuesta.length; i++) {
                 var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta[i].nombre +"--<spam class= 'tipocolor'>"+respuesta[i].tarea+"</spam></p>";
                         var listaTareas = document.querySelector("#tareaFechaImportantes");
                      //   console.log(listaTareas);
                       listaTareas.appendChild(nuevoTarea);
                } 
                $(".modalEntregatareas").fadeIn();               
               }
             }
             xhr.send(datos);       

  
  }
  if(e.target.classList.contains('fa-stopwatch'))
  {
    //var idproyecto = getParameterByName('idproyecto'); 
  // console.log('Hciste clic en actividades');
  
     var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>cproyecto/retornaFechaAlerta",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta);
                var lis = document.querySelectorAll('#tareaAlerta li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                for(let i = 0; i < respuesta.length; i++) {
                 var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta[i].nombre +"--<spam class= 'tipocolor'>"+respuesta[i].tarea+"</spam></p>";
                         var listaTareas = document.querySelector("#tareaAlerta");
                      //   console.log(listaTareas);
                       listaTareas.appendChild(nuevoTarea);
                } 
                $(".modalEntregaalertas").fadeIn();            
               }
             }
             xhr.send(datos);  
  }
  if(e.target.classList.contains('fa-calendar-check'))
  {
   console.log('llego');
   $(".modalMuestraFechaPos").fadeIn();
   return;
  }
  if(e.target.classList.contains('fa-book'))
  {
   //console.log('llego');
    $(".modalcomite").fadeIn();
     var xhr = new XMLHttpRequest();
     var datos = new FormData();
     xhr.open('POST',"<?php echo base_url();?>cproyecto/retornatareasCompletas",true);
       xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta);
                var lis = document.querySelectorAll('#tareaAlerta li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                for(let i = 0; i < respuesta.length; i++) {
                 var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta[i].nombre +"--<spam class= 'tipocolor'>"+respuesta[i].tarea+"</spam></p>";
                         var listaTareas = document.querySelector("#tareaAlerta");
                      //   console.log(listaTareas);
                       listaTareas.appendChild(nuevoTarea);
                } 
                $(".modalEntregaalertas").fadeIn();            
               }
             }
             xhr.send(datos);
             return;  
  }

}
/********************************************************** */
function agregaTarea(e)
{
  e.preventDefault();
  //console.log(e.target.classList.value);
 // console.log('hola');
 //console.log(e.target);
 var nuevatarea = document.querySelector('#nuevo-tarea').value;
  var idproyecto = getParameterByName('idproyecto');
  console.log(nuevatarea);  
   
 if(e.target.classList.value=='fas fa-user-plus fa-x icono')
 {
  if(idproyecto <= 0)
  {
    Swal.fire(
         'Proyecto!',
         'Necesita Seleccionar el Proyecto',
         'warning'
      );
    return; 
  } 
  if(nuevatarea == '')
  {
    Swal.fire(
         'Tarea!',
         'La Tarea no Puede Estar Vacia',
         'warning'
      );
    return;
  }
  var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('nombre',nuevatarea);
  datos.append('idproyecto',idproyecto);
  xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaTarea",true);
  xhr.onload = function(){
    if(this.status===200){
      var respuesta =JSON.parse(xhr.responseText);
      //console.log(respuesta);
      var tarea = respuesta.tarea,
          idtarea = respuesta.idtarea;
      var nuevoTarea = document.createElement('Li'); 
      nuevoTarea.id = idtarea;   
             nuevoTarea.innerHTML=`
         <p>${tarea}</p> <div  class="icono-tarea" > <i class="fas fa-user-plus fa-x icono" title="Agrega Usuarios"></i><i class="far fa-check-circle icono" title="Tareas Completadas"></i><i class="fas fa-trash-alt icono"  title="Elimina Tareas"></i> <i class="far fa-star icono" title="Tareas Importantes"></i><i class="far fa-calendar-alt icono" title="Entrega de Tareas"></i><i class="fas fa-stopwatch icono"  title="Alerta de Tareas"></i>
         </div>         
        `;
       //var listaTareas = document.querySelector(".tareas ul");  

     var listaTareas = document.querySelector("#tareaAgregadas");
       listaTareas.appendChild(nuevoTarea);
      Swal.fire({
        title: 'Tarea Agregado',
        text: 'La Tarea se creo correctamente',
        type: 'success'
      })
     actualizaBarra();
    }
  }
  //Enviar el request
  xhr.send(datos);
  }
}

/********************************************************** */
function agregaPersona(e)
{
  e.preventDefault();
  //console.log('hola');
  vidsubventa=e.target.parentElement.parentElement.parentElement.parentElement;
  var idtarea = e.target.parentElement.parentElement; 
  var nombretarea = idtarea.childNodes[0].textContent;
  var hast = e.target.classList.contains('fa-check-circle');
  var nombreNodo =e.target; 
  $("#idTarea").val(idtarea.id);
  $("#nombreTarea").val(nombretarea);
  $("#inpsubtarea").val(idtarea.id);
  var idmenu = nombreNodo.parentElement.id;

  //agregaAlerta
  if(idmenu.includes("alertaTareas"))
  {
    nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);  
   var divalerta = document.getElementById(divhijo);
   divcolor= divcolor.children[2]; 
   divcolor= divcolor.children[3];
  
   //  console.log(divalerta.id);
   // divcolor.classList.add('fas');
   // divcolor.classList.add('fa-stopwatch');
   // divcolor.classList.add('icono');
    var idventana = document.getElementById('V'+divhijo);
      idventana.classList.add('ocultar');
    $(".modalAlerta").fadeIn();
    document.getElementById("textoAlerta").textContent  =  divalerta.children[1].innerHTML;;
    $("#idTareaAlerta").val(divalerta.id);
   //Verifiicamo la fecha de alerta
     var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',divalerta.id);
            //datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/retornaFechaAta",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);
                 if(respuesta=== null)
                 {
                  console.log(respuesta);
                  var fecha = new Date();
                  var mes = fecha.getMonth()+1; //obteniendo mes
                   var dia = fecha.getDate(); //obteniendo dia
                  var ano = fecha.getFullYear(); //obteniendo año
                  var fechatarea = new Date();
                  $('#fechaAlerta').val(ano+"-"+mes+"-"+dia);
                 }
                 else{
                 $('#fechaAlerta').val(respuesta);
                 }
              }
            }
            xhr.send(datos);

                 
   return;
  }
 
 //Agrega usuarios
 if(idmenu.includes("agrega-Usario"))
  {
    // console.log('entro');
    nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);  
   //var tareaMenu =  document.getElementById(divhijo);  
   //var nuev =  'subbarra-avance'+ divhijo;
   // var subelimina = document.getElementById(nuev).parentElement;
     $(".modalTareas").fadeIn();
    document.getElementById("titulo-Tarea").innerHTML  = divcolor.children[1].innerHTML;
    var idtar = divhijo;//getParameterByName('idTarea');
    document.querySelector("#idTarea").value = idtar;
    console.log( idtar);
     if(idtar > 0)
     {
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtar);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelveEmpleados",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var lis = document.querySelectorAll('#ullistaEmpleados li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                //console.log(respuesta);
                  for(let i = 0; i < respuesta.length; i++) {
                    if(respuesta[i].tipo == 'CLIENTE')
                    {
                      $("#ullistaEmpleados").append("<li> "+respuesta[i].correo +"---"+respuesta[i].correo+" <button id='"+respuesta[i].idptarea+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                    }
                    else{
                    $("#ullistaEmpleados").append("<li> "+respuesta[i].nombre +"---"+respuesta[i].correo+" <button id='"+respuesta[i].idptarea+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                    }
                  }
              }
            }
            xhr.send(datos);
      }
      var idventana = document.getElementById('V'+divhijo);
                    idventana.classList.add('ocultar');
      return;
  }
    
  //}

   //Elimna tareas
 if(idmenu.includes("elimina-Tareas"))
  {
   // console.log('entro');
   nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);  
   var nuev =  'subbarra-avance'+ divhijo;
    var subelimina = document.getElementById(nuev).parentElement;
  // console.log(divcolor);                         
    Swal.fire({
     title: '¿Deseas Borrar El registro?',
     text:'Se borrara El Invitado del Proyecto',
     type: 'warning',
     showCancelButton:true, 
     confirmButtonColor:'#3085d6',
     cancelButtonColor:'#d33',
     confirmButtonText:'Eliminar',
     cancelButtonText:'Cancelar'
   }).then((result)=>{
     if(result.value){
      var xhr = new XMLHttpRequest();
      var datos = new FormData();
      datos.append('idtarea',divhijo);
      xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminaTarea",true);
      xhr.onload=function()
       {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);
                if(respuesta =="ELIMINADO")
                {
                var eliminar = document.getElementById(divhijo);  
                 //console.log(eliminar);
                 var idventana = document.getElementById('V'+divhijo);
                 idventana.classList.add('ocultar');
                 eliminar.remove();
                 subelimina.remove(); 
                 actualizaBarra();
                 Swal.fire(
                  'Borrado!',
                   'El Invitado ha sido Borrado',
                  'success',
                   )
                }
                else{
                  Swal.fire(
                       'Incorrecto!',
                       'El usuario no puede eliminar tareas',
                     'success'
                     ) 
                   }
             } 
        }
       xhr.send(datos);        
      } 
    }) 
    var idventana = document.getElementById('V'+divhijo);
                    idventana.classList.add('ocultar');
    return;
  }
 //Tareas Importantes
  if(idmenu.includes("importanteTareas"))
  {
 // console.log('entro');
   nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   //console.log(divhijo); 
   var divcolor = document.getElementById(divhijo);   
   //console.log(divcolor.children);
    divcolor= divcolor.children[2];  
    divcolor= divcolor.children[1];
    divcolor.classList.add('far');
    divcolor.classList.add('fa-star');
    divcolor.classList.add('estrella');
   //console.log(divcolor);
    var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',divhijo);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/tareaEstrella",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
               // console.log(respuesta);
                if(respuesta == 1)
                {
                  
                  divcolor.classList.add('far');
                  divcolor.classList.add('fa-star');
                  divcolor.classList.add('estrella');
                  //console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Agrego Estrella a la Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 3)
                {
                  divcolor.classList.add('far');
                  divcolor.classList.add('fa-star');
                  divcolor.classList.add('estrella');
                  //console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Agrego Estrella a la Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 2)
                {
                  e.target.classList.remove('estrella');
                  e.target.classList.add('icono');
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Quito la Estrella a la Tarea',
                    type: 'success'
                  })
                    
                  //console.log(e.target.classList);
                }
                var idventana = document.getElementById('V'+divhijo);
                    idventana.classList.add('ocultar');
                //actualizaBarra();
              
              }
            }
            xhr.send(datos);
            var idventana = document.getElementById('V'+divhijo);
                    idventana.classList.add('ocultar');
            return;
  }

  if(e.target.classList.contains('fa-star'))
  {
    // console.log(idtarea.id);
     //e.target.classList.remove('icono');
     //e.target.classList.add('estrella');
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/tareaEstrella",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
               // console.log(respuesta);
                if(respuesta == 1)
                {
                  
                  e.target.classList.remove('icono');
                  e.target.classList.add('estrella');
                  //console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Agrego Estrella a la Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 3)
                {
                  e.target.classList.remove('icono');
                  e.target.classList.add('estrella');
                  //console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Agrego Estrella a la Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 2)
                {
                  /*e.target.classList.remove('estrella');
                  e.target.classList.add('icono');*/
                  e.target.classList.remove('far');
                  e.target.classList.remove('fa-star');
                  e.target.classList.remove('estrella');
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Quito la Estrella a la Tarea',
                    type: 'success'
                  })
                  
                  //console.log(e.target.classList);
                }
                //actualizaBarra();
              
              }
            }
            xhr.send(datos);
     return;
  }
  //termina tarea importantes
 

 //AgendaTareas
 if(idmenu.includes("agendaTareas"))
 {
  //console.log('entro');
  nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
  nombrehijo =nombreIconos.id; 
  var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);   
   divcolor= divcolor.children[2];  
   divcolor= divcolor.children[0];
  // divcolor.classList.add('far');
  // divcolor.classList.add('fa-calendar-alt');
  // divcolor.classList.add('cafe');
   //console.log(divhijo);
   $("#idTareaFecha").val(divhijo);
   $(".modalFecha").fadeIn();
   var tareaMenu =  document.getElementById(divhijo);   
   //console.log(tareaMenu.children[1].innerHTML);
   document.getElementById("textoFechamostrar").textContent  =tareaMenu.children[1].innerHTML;
    var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',divhijo);
            //datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/retornaFechaTarea",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                 
                 if(respuesta=== null)
                 {
                  //console.log(respuesta);
                  var fecha = new Date();
                  var mes = fecha.getMonth()+1; //obteniendo mes
                   var dia = fecha.getDate(); //obteniendo dia
                  var ano = fecha.getFullYear(); //obteniendo año
                  var fechatarea = new Date();
                  $('#fechaTarea').val(ano+"-"+mes+"-"+dia);
                 }
                 else{
                 $('#fechaTarea').val(respuesta);
                 }
                 var idventana = document.getElementById('V'+divhijo);
                    idventana.classList.add('ocultar');      
              }
            }
            xhr.send(datos);
  return;
 }
 //Termina Agenda Tareas

 if(idmenu.includes("completados"))
 {
   nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   //console.log(nombreIconos);
   
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);   
   divcolor= divcolor.children[2];  
   divcolor= divcolor.children[0];
   divcolor.classList.add('far');
   divcolor.classList.add('fa-check-circle');
   divcolor.classList.add('icono');
   divcolor.classList.add('terminado');
   var idventana = document.getElementById('V'+divhijo);
                   // idventana.classList.remove('ocultar');  
            //        console.log(divhijo);
              //      console.log(idventana);
  var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',divhijo);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/tareaCompletada",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
               
                  Swal.fire({
                  title: 'Tarea Completada',
                   text: 'Se Ha Completado La Tarea',
                    type: 'success'
                  })               
                  actualizaBarra(); 
                  var idventana = document.getElementById('V'+divhijo);
                    idventana.classList.add('ocultar');           
              }
            }
            xhr.send(datos);  
  return;
 }
//Agregamos que la tarea esta acompletada
if(e.target.classList.contains('fa-check-circle'))
  {
    // console.log('hola');         
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/tareaCompletada",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta);
                if(respuesta == 0)
                {
                  e.target.classList.remove('terminado');
                  e.target.classList.remove('far');
                  e.target.classList.remove('fa-check-circle');
                  e.target.classList.remove('icono');
                 // e.target.classList.remove('fa-check-circle terminado');
                 // e.target.classList.add('icono');
                  console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Activada',
                   text: 'Se Ha Activado Nuevamente La Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 1)
                {
                  
                  e.target.classList.add('terminado');
                  Swal.fire({
                  title: 'Tarea Completada',
                   text: 'Se Ha Completado La Tarea',
                    type: 'success'
                  })
                  
                  //console.log(e.target.classList);
                }
                actualizaBarra();
              
              }
            }
            xhr.send(datos);
            return;
  }
  //Terminq tarea esta acompletada
 if(e.target.classList.contains('fa-align-justify'))
 {
  var idventana = document.getElementById('V'+idtarea.id);
  var sventana = document.querySelectorAll('.ventana');
   var band =false;
  if(idventana.classList.contains('ocultar'))
  {
    band = true;
  }
  

  for (var i=0; i < sventana.length;i++) 
  {
     if(!sventana[i].classList.contains('ocultar'))
    {
      sventana[i].classList.add('ocultar'); 
    }
  } 
 if(band)
 {
  idventana.classList.remove('ocultar');
 }
 else{
  idventana.classList.add('ocultar');
 } 

// var idtar = e.target.parentElement;
    var nodo ="#subtareas";
    nodo = nodo+idtarea.id; 
    var sub =  document.querySelector(nodo);//$("#subtareas"+idtar);
    if(!sub.classList.contains('ocultar'))
    {
      sub.classList.add('ocultar');
    }
    return;
 }
 //Alerta Subtareas
  if(e.target.classList.contains('fa-clock'))
  {
   // $(".modalAlerta").fadeIn();
    document.getElementById("textosubAlerta").textContent  = nombretarea;
    $("#idTareasubAlerta").val(idtarea.id);
   //Verifiicamo la fecha de alerta
     var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            //datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/retornasubFechaAlerta",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta);
                 if(respuesta=== null)
                 {
                  console.log(respuesta);
                  var fecha = new Date();
                  var mes = fecha.getMonth()+1; //obteniendo mes
                   var dia = fecha.getDate(); //obteniendo dia
                  var ano = fecha.getFullYear(); //obteniendo año
                  var fechatarea = new Date();
                  $('#fechasubAlerta').val(ano+"-"+mes+"-"+dia);
                 }
                 else{
                 $('#fechasubAlerta').val(respuesta);
                 }
              }
              $(".modalsubAlerta").fadeIn();
            }
            xhr.send(datos);
    return;       
  }
  //importantes Subtareas
  if(e.target.classList.contains('fa-calendar-check'))
  {
    //console.log(idtarea.id);
    $("#idTareasubFecha").val(idtarea.id);
 
    document.getElementById("textosubFechamostrar").textContent  =nombretarea;
           var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            //datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/retornasubFechaTarea",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                 //console.log(respuesta);
                 if(respuesta=== null)
                 {
                 
                  var fecha = new Date();
                  var mes = fecha.getMonth()+1; //obteniendo mes
                   var dia = fecha.getDate(); //obteniendo dia
                  var ano = fecha.getFullYear(); //obteniendo año
                 // var fechatarea = new Date();
                  console.log( $('#subfechaTarea').val());
                  console.log( ano+"-"+mes+"-"+dia);

                  $('#subfechaTarea').val(ano+"-"+mes+"-"+dia);
                 }
                 else{
                 $('#subfechaTarea').val(respuesta);
                 }
              }
              $(".modalsubFecha").fadeIn();
            }
            xhr.send(datos);
     return;       
  }
  if(e.target.classList.contains('fa-sun'))
  {
    //console.log(idtarea.id);
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/subtareaEstrella",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
               // console.log(respuesta);
                if(respuesta == 1)
                {
                  
                  e.target.classList.remove('icono');
                  e.target.classList.add('estrella');
                  //console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Agrego Estrella a la Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 3)
                {
                  e.target.classList.remove('icono');
                  e.target.classList.add('estrella');
                  //console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Agrego Estrella a la Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 2)
                {
                  e.target.classList.remove('estrella');
                  e.target.classList.add('icono');
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Quito la Estrella a la Tarea',
                    type: 'success'
                  })
                  
                  //console.log(e.target.classList);
                }
                actualizasubBarra();
              
              }
            }
            xhr.send(datos);
     return;
  }
   //completa Subtareas
  if(e.target.classList.contains('fa-check-square'))
  {
          //console.log(idtarea.id);
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/subtareaCompletada",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);
                 if(respuesta == 0)
                {
                  e.target.classList.remove('terminado');
                  e.target.classList.add('icono');
                  //console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Activada',
                   text: 'Se Ha Activado Nuevamente La Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 1)
                {
                  e.target.classList.remove('icono');
                  e.target.classList.add('terminado');
                  Swal.fire({
                  title: 'Tarea Completada',
                   text: 'Se Ha Completado La Tarea',
                    type: 'success'
                  })
                  
                  //console.log(e.target.classList);
                }
                
                actualizasubBarra();
              
              }
            }
            xhr.send(datos);
            return;
  } 
  //Elimina Subtareas
  if(e.target.classList.contains('fa-trash'))
  {
    //var eliminar = e.target.parentElement.parentElement;
     //            console.log(eliminar);
    Swal.fire({
     title: '¿Deseas Borrar El registro?',
     text:'Se borrara la subtarea del Proyecto',
     type: 'warning',
     showCancelButton:true, 
     confirmButtonColor:'#3085d6',
     cancelButtonColor:'#d33',
     confirmButtonText:'Eliminar',
     cancelButtonText:'Cancelar'
   }).then((result)=>{
     if(result.value){
      var xhr = new XMLHttpRequest();
      var datos = new FormData();
      datos.append('idtarea',idtarea.id);
      xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminasubTarea",true);
      xhr.onload=function()
       {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                if(respuesta =='ELIMINADO')
                {
                var eliminar = e.target.parentElement.parentElement;
                 //console.log(eliminar);
                 eliminar.remove();
                 actualizasubBarra();
                 Swal.fire(
                 'Borrado!',
                      'El Invitado ha sido Borrado',
                  'success'
                  )
                }
                else
                {
                  Swal.fire(
                 'Error!',
                      'El usuario no puede Borrar Tareas',
                  'success'
                  )
                } 
              }

       }
       xhr.send(datos); 
     
      } 
    }) 
  }
  //Termina Elimina subtarea
  if(e.target.classList.contains('fa-user-check'))
  {
   // console.log(idtarea.id);
    var idtar = e.target.parentElement.parentElement.parentElement.parentElement.parentElement;
    var tareapapa=idtar.childNodes[1].id;
    var idsub =  e.target.parentElement.parentElement;
    $("#nombresubTarea").val(idsub.textContent);
    $("#idTar").val(tareapapa);
    $("#idsubTar").val(idsub.id);
    $('.modalusuariosubTareas').fadeIn();
    console.log(idsub.id);
    document.getElementById('tituloTarea').innerHTML=idsub.textContent; 
    if(idsub.id > 0)
     {
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idsub.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelvesubEmpleados",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);
                var lis = document.querySelectorAll('#ullistasubEmpleados li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                //console.log(respuesta);
                  for(let i = 0; i < respuesta.length; i++) {
                    if(respuesta[i].tipo == 'CLIENTE')
                    {
                      $("#ullistasubEmpleados").append("<li> "+respuesta[i].correo +"---"+respuesta[i].correo+" <button id='"+respuesta[i].idpsubtareas+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                    }
                    else{
                    $("#ullistasubEmpleados").append("<li> "+respuesta[i].nombre +"---"+respuesta[i].correo+" <button id='"+respuesta[i].idpsubtareas+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                    }
                  }
              }
            }
            xhr.send(datos);
      }
  }
  if(e.target.classList.contains('fa-angle-double-down'))
  {
    var idtar = e.target.parentElement;
    //console.log(e.target.parentElement.parentElement.childNodes[3]);
    vidsubventa =e.target.parentElement.parentElement.childNodes[3]; 
    var nodo ="#subtareas";
    nodo = nodo+idtar.id; 
    //console.log(nodo);
    var sub =  document.querySelector(nodo);//$("#subtareas"+idtar);
    //console.log(sub.classList);
    if(sub.classList.contains('ocultar'))
    {
      //console.log('list');
      sub.classList.remove('ocultar');
       
      
    }
    else{
      sub.classList.add('ocultar');
    }
  
    var sventana = document.querySelectorAll('.ventana');
    for (var i=0; i < sventana.length;i++) 
   {
      if(!sventana[i].classList.contains('ocultar'))
     {
       sventana[i].classList.add('ocultar'); 
     }
   } 
   actualizasubBarra();
    return false;
  } 
  if(e.target.classList.contains('fa-tasks'))
  {
    var idtar = e.target.parentElement;
    console.log(idtarea);
   
      $(".modalsubTareas").fadeIn();
   var sventana = document.querySelectorAll('.ventana');

   for (var i=0; i < sventana.length;i++) 
    {
      if(!sventana[i].classList.contains('ocultar'))
     {
       sventana[i].classList.add('ocultar'); 
     }
    } 
   return; 
  }
  if(e.target.classList.contains('fa-stopwatch'))
  {
    //console.log(idtarea.id);
  /*  $(".modalAlerta").fadeIn();
    document.getElementById("textoAlerta").textContent  = nombretarea;
    $("#idTareaAlerta").val(idtarea.id);
   //Verifiicamo la fecha de alerta
     var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            //datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/retornaFechaAta",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);
                 if(respuesta=== null)
                 {
                  console.log(respuesta);
                  var fecha = new Date();
                  var mes = fecha.getMonth()+1; //obteniendo mes
                   var dia = fecha.getDate(); //obteniendo dia
                  var ano = fecha.getFullYear(); //obteniendo año
                  var fechatarea = new Date();
                  $('#fechaAlerta').val(ano+"-"+mes+"-"+dia);
                 }
                 else{
                 $('#fechaAlerta').val(respuesta);
                 }
              }
            }
            xhr.send(datos);*/
       return;


  } 
 
  //Graba fecha de entrega
  if(e.target.classList.contains('fa-calendar-alt'))
  {
    //console.log(nombretarea);
    $("#idTareaFecha").val(idtarea.id);
    $(".modalFecha").fadeIn();
    document.getElementById("textoFechamostrar").textContent  =nombretarea;
    var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            //datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/retornaFechaTarea",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                 
                 if(respuesta=== null)
                 {
                  //console.log(respuesta);
                  var fecha = new Date();
                  var mes = fecha.getMonth()+1; //obteniendo mes
                   var dia = fecha.getDate(); //obteniendo dia
                  var ano = fecha.getFullYear(); //obteniendo año
                  var fechatarea = new Date();
                  $('#fechaTarea').val(ano+"-"+mes+"-"+dia);
                 }
                 else{
                 $('#fechaTarea').val(respuesta);
                 }
              }
            }
            xhr.send(datos);
  }
  if(e.target.classList.contains('fa-star'))
  {
    // console.log(idtarea.id);
     //e.target.classList.remove('icono');
     //e.target.classList.add('estrella');
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/tareaEstrella",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
               // console.log(respuesta);
                if(respuesta == 1)
                {
                  
                  e.target.classList.remove('icono');
                  e.target.classList.add('estrella');
                  //console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Agrego Estrella a la Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 3)
                {
                  e.target.classList.remove('icono');
                  e.target.classList.add('estrella');
                  //console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Agrego Estrella a la Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 2)
                {
                  e.target.classList.remove('estrella');
                  e.target.classList.add('icono');
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se Quito la Estrella a la Tarea',
                    type: 'success'
                  })
                  
                  //console.log(e.target.classList);
                }
                //actualizaBarra();
              
              }
            }
            xhr.send(datos);
     return;
  }
  //termina tarea importantes
  //Eliminamos Tarea 
  if(e.target.classList.contains('fa-trash-alt'))
  {
    var idel = e.target.parentElement.parentElement;
    var nuev =  'subbarra-avance'+ idel.id;
    var subelimina = document.getElementById(nuev).parentElement;
               //  console.log(subelimina);
                            
    Swal.fire({
     title: '¿Deseas Borrar El registro?',
     text:'Se borrara El Invitado del Proyecto',
     type: 'warning',
     showCancelButton:true, 
     confirmButtonColor:'#3085d6',
     cancelButtonColor:'#d33',
     confirmButtonText:'Eliminar',
     cancelButtonText:'Cancelar'
   }).then((result)=>{
     if(result.value){
      var xhr = new XMLHttpRequest();
      var datos = new FormData();
      datos.append('idtarea',idtarea.id);
      xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminaTarea",true);
      xhr.onload=function()
       {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log()
                if(respuesta =="ELIMINADO")
                {
                var eliminar = e.target.parentElement.parentElement;
                 //console.log(eliminar);
                 eliminar.remove();
                 subelimina.remove(); 
                 actualizaBarra();
                 Swal.fire(
                  'Borrado!',
                   'El Invitado ha sido Borrado',
                  'success',
                   )
                }
                else{
                  Swal.fire(
                       'Incorrecto!',
                       'El usuario no puede eliminar tareas',
                     'success'
                     ) 
                   }
             } 
        }
       xhr.send(datos);        
      } 
    }) 
  }
  //Termina Elimina tarea
  
  if(e.target.classList.value =="fas fa-user-plus fa-x icono")
  {
    $(".modalTareas").fadeIn();
    document.getElementById("tituloTarea").textContent  = nombretarea;
    var idtar = idtarea.id;//getParameterByName('idTarea');
   // console.log(idtar);
     if(idtar > 0)
     {
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtar);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelveEmpleados",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var lis = document.querySelectorAll('#ullistaEmpleados li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                //console.log(respuesta);
                  for(let i = 0; i < respuesta.length; i++) {
                    if(respuesta[i].tipo == 'CLIENTE')
                    {
                      $("#ullistaEmpleados").append("<li> "+respuesta[i].correo +"---"+respuesta[i].correo+" <button id='"+respuesta[i].idptarea+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                    }
                    else{
                    $("#ullistaEmpleados").append("<li> "+respuesta[i].nombre +"---"+respuesta[i].correo+" <button id='"+respuesta[i].idptarea+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                    }
                  }
              }
            }
            xhr.send(datos);
      }
      return;
  }
   //Agregamo tareas importantes
   if(nombreNodo.parentElement.parentElement.children[0].children[1].nodeName=="P")
  {
    //console.log(e.target.textContent);
    $(".modalVisualiza").fadeIn();
    document.getElementById("textoMostrar").textContent  = e.target.textContent;
    return;
  }
  return;
}
/********************************************************** */
function grabaAlerta(e)
{
  e.preventDefault();
  //console.log("Graba Fecha");
  //var idtarea=document.querySelector('#idTareaFecha'); 
  var fechaTarea=document.querySelector('#fechaAlerta'); 
  var alertaTarea=document.querySelector('#idTareaAlerta'); 
  // console.log(alertaTarea.value);
  var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',alertaTarea.value);
            datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaAlertaTarea",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                 console.log(respuesta);
              }
            }
            xhr.send(datos);
            Swal.fire({
                  title: 'Alerta',
                   text: 'Se Grabado la Alerta',
                    type: 'success'
                  })  
                  $(".modalAlerta").fadeOut();         
}
/********************************************************** */

function eliminaEmpleado(e)
{
  e.preventDefault(); 
  var idtarea = e.target.parentElement;
  //console.log(idtarea.id);
  if(e.target.classList.value=='fas fa-trash-alt')
  {
    //console.log('Hiciste clic en eliminar');
    Swal.fire({
     title: '¿Deseas Borrar El registro?',
     text:'Se borrara El Empleado de la Tarea',
     type: 'warning',
     showCancelButton:true, 
     confirmButtonColor:'#3085d6',
     cancelButtonColor:'#d33',
     confirmButtonText:'Eliminar',
     cancelButtonText:'Cancelar'
   }).then((result)=>{
     if(result.value){
        var eliminar = e.target.parentElement.parentElement;
        //console.log(eliminar);
        eliminar.remove();
        var xhr = new XMLHttpRequest();
        var datos = new FormData();
            datos.append('idEmpleado',idtarea.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminaEmpleado",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                // console.log(respuesta);                
              }
            }
      xhr.send(datos);
       Swal.fire(
         'Borrado!',
         'El Invitado ha sido Borrado',
         'success'
       )
     }
   })

  }
}
/********************************************************** */

/********************************************************** */
  function agregaExterno(e){
  e.preventDefault();
  //console.log(e.target.classList.value);
  var idproyecto = getParameterByName('idproyecto');
  var nomurl ="<?php echo base_url();?>"+ "cproyecto/muestraProyectosExternos?idproyecto=" + idproyecto;
  if(e.target.classList.value=='fas fa-user-plus fa-x icono')
  {
    //console.log('Hiciste Clic al icono');
    //if(documne)$("#seleccionararchivo").val();
    var invitado =document.querySelector('#invitadoExterno').value;
    if(invitado == '')
    {
      document.getElementById('invitadoExterno').focus();
      Swal.fire(
         'Correo!',
         'El Correo Esta Vacio',
         'warning'
      );      
    }
    else{
      var valida = validaCorreo(invitado);
      //console.log(valida);
      if(valida == 'T')
      {
       
         //Agregamos el Cliente Extra
             $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $password = "";
            for($i=0;$i<6;$i++) {
                 $password =$password+ $str.substr(Math.random()*63,1);
              }
              
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            var nombreProy = document.querySelector("#nombreProyecto").value;
            var fechaProy = document.querySelector("#fechaProyecto").value;
            var horaProy = document.querySelector("#horaProyecto").value;
            
            datos.append('correo',invitado);
            datos.append('contrasena',$password); 
            datos.append('nomurl',nomurl); 
            datos.append('nombreProy',nombreProy); 
            datos.append('fechaProy',fechaProy); 
            datos.append('horaProy',horaProy); 
            //datos.append('nombre',nombre.id);
            //datos.append('id',nom.id);
            //datos.append('tipo',tip);
            datos.append('idproyecto',idproyecto);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/agregaInvitadoextra",true);
            xhr.onload=function()
            {
             
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var accion = respuesta.respuesta;
                var tiporespuesta =respuesta.tipoerror;
                 console.log(accion);
                if(accion == 'error')
                {
                  Swal.fire('Mensaje de Advertencia',tiporespuesta ,"warning");
                }
                else{
                  $("#ullistaInvitado").append("<li> "+invitado +"---"+invitado+" <button class ='eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                   Swal.fire('Mensaje de Confirmacion',"Se Invito A : "+invitado,"success");
                }
              }
            }
            xhr.send(datos);
      }
      else{
       //  var nombreProy = document.querySelector("#nombreProyecto").value;
       //console.log(nombreProy);
        Swal.fire(
         'Correo!',
         'El Correo Esta Incorrecto',
         'warning'
      ); 
      }
    } 
   }
  else{
    console.log('no al icono');
   }
}
/*********************************************************************** */
function tareaExterno(e){
  e.preventDefault();
  //console.log(e.target.classList.value);
  var idproyecto = getParameterByName('idproyecto');
  var nomurl ="<?php echo base_url();?>"+ "cproyecto/muestraProyectosExternos?idproyecto=" + idproyecto;
  if(e.target.classList.value=='fas fa-user-plus fa-x icono')
  {
    //console.log('Hiciste Clic al icono');
    var invitado =document.querySelector('#tareaExterno').value;
    if(invitado == '')
    {
      document.getElementById('invitadoExterno').focus();
      Swal.fire(
         'Correo!',
         'El Correo Esta Vacio',
         'warning'
      );      
    }
    else{
      var valida = validaCorreo(invitado);
      //console.log(valida);
      if(valida == 'T')
      {
         //Agregamos el Cliente Extra
         $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $password = "";
            for($i=0;$i<6;$i++) {
                 $password =$password+ $str.substr(Math.random()*63,1);
              }
            var nombreTarea = document.querySelector("#nombreTarea").value;
            var idtarea = document.querySelector("#idTarea").value;
            //var horaProy = document.querySelector("#horaProyecto").value;
            //console.log(idtarea);
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('correo',invitado);
            datos.append('contrasena',$password); 
            datos.append('nomurl',nomurl); 
            datos.append('nombreTarea',nombreTarea); 
            datos.append('id',idtarea); 
            //datos.append('horaProy',horaProy); 
            //datos.append('nombre',nombre.id);
            //datos.append('id',nom.id);
            //datos.append('tipo',tip);
            //datos.append('idproyecto',idproyecto);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/agregaTareaextra",true);
            xhr.onload=function()
            {
             
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
               // console.log(respuesta);
                var accion = respuesta.respuesta;
                var tiporespuesta =respuesta.tipoerror;
                 
                if(accion == 'error')
                {
                  Swal.fire('Mensaje de Advertencia',tiporespuesta ,"warning");
                }
                else{
                  //$("#ullistaInvitado").append("<li> "+invitado +"---"+invitado+" <button class ='eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                  $("#ullistaEmpleados").append("<li> "+invitado +"---"+invitado+" <button class ='eliminaInvitado basura' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                   Swal.fire('Mensaje de Confirmacion',"Se Invito A : "+invitado,"success");
                }
              }
            }
            xhr.send(datos);
            
      }
      else{
       //  var nombreProy = document.querySelector("#nombreProyecto").value;
       //console.log(nombreProy);
        Swal.fire(
         'Correo!',
         'El Correo Esta Incorrecto',
         'warning'
      ); 
      }
    }
  } 
     
    
}
/*********************************************************************** */
function validaCorreo(valor)
{
  var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
  if (caract.test(valor) == true)
  {
   return 'T';
  } 
  else {
   return 'f';
  }
}
function buscaContacto(e){
  e.preventDefault();
  //console.log(e.target.value);
  const expresion = new RegExp(e.target.value,"i");
  const registros = document.querySelectorAll('.tabla-contactos tr');
  //console.log(registros);
  registros.forEach(registros =>{
     registros.style.display = 'none';
     //console.log(registros.childNodes[1].textContent);
     if(registros.childNodes[1].textContent.replace(/\s/g," ").search(expresion)!= -1)
     {
      registros.style.display = 'table-row';
     }
   })
}
function eliminaInv(e){
  e.preventDefault();
  //console.log(e.target.classList);
  nom = e.target.parentElement;
  //console.log(nom.id);
 if(e.target.classList.value=='fas fa-trash-alt')
  {
   Swal.fire({
     title: '¿Deseas Borrar El registro?',
     text:'Se borrara El Invitado del Proyecto',
     type: 'warning',
     showCancelButton:true, 
     confirmButtonColor:'#3085d6',
     cancelButtonColor:'#d33',
     confirmButtonText:'Eliminar',
     cancelButtonText:'Cancelar'
   }).then((result)=>{
     if(result.value){
        var eliminar = e.target.parentElement.parentElement;
        //console.log(eliminar);
        eliminar.remove();
        var xhr = new XMLHttpRequest();
        var datos = new FormData();
            datos.append('idinvitado',nom.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminaInvitado",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);                
              }
            }
      xhr.send(datos);
       Swal.fire(
         'Borrado!',
         'El Invitado ha sido Borrado',
         'success'
       )
     }
   })
   
  }
 
 
}


function getParameterByName(name) {
     name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
     var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
     results = regex.exec(location.search);
     return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
   
function nuevoProyecto(e){
    e.preventDefault();
   var valor = ("#nuevo-proyecto").length;
   var contenido = $("#nuevo-proyecto").val();
   //console.log(contenido);
    if (contenido != "") {    
   
  guardaProyecto(); 
  }

 }
 function guardaProyecto()
{
  //console.log('hlas');
  var nombre = $("#nuevo-proyecto").val();
  var fecha = $("#nuevo-fecha").val();
  var hora = $("#nuevo-hora").val();
  //console.log(hora);
  var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('nombre',nombre);
  datos.append('fecha',fecha);
  datos.append('hora',hora);
  xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaProyecto",true);
  xhr.onload = function(){
    if(this.status===200){
      var respuesta =JSON.parse(xhr.responseText);
       console.log(respuesta);
      var proyecto = respuesta.nombre_proyecto,
          idproyecto = respuesta.idproyecto;
      var nuevoProyecto = document.createElement('Li');    
        nuevoProyecto.innerHTML=`
         <a href = "<?php echo base_url();?>?idproyecto=${idproyecto}" id="${idproyecto}"> <i class="fas fa-align-justify"></i>
         ${proyecto}
         </a>
        `
       var listaProyectos = document.querySelector("ul#proyectos");  
       listaProyectos.appendChild(nuevoProyecto);
      Swal.fire({
        title: 'Proyecto Creado',
        text: 'El Proyecto :'+proyecto+'se creo correctamente',
        type: 'success'
      })
      //agregaProyectos();
    }
  }
  //Enviar el request
  xhr.send(datos);
}
/**************************************************/
function agregaProyectos()
{
  //mandamos a buscar Los proyectos agregado para el usuario
  //El nombre de los procetos del usuario
  var nombre = 5;
} 
function abrirModalProyecto()
 {
  $(".modal").fadeIn();
  var idproyecto = getParameterByName('idproyecto');
  if(idproyecto > 0)
  {
          var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idproyecto',idproyecto);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelveInvitados",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                  for(let i = 0; i < respuesta.length; i++) {
                    $("#ullistaInvitado").append("<li> "+respuesta[i].nombre +"---"+respuesta[i].correo+"<button id='" +respuesta[i].id +"' class ='eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                  }                
              }
            }
            xhr.send(datos);
    } 
  //cargamos lista de Invitado si exiten 

 }
 /********************************************************* */
 function cierraModalentregaalertas()
 {
  $(".modalEntregaalertas").fadeOut();  
 }
 /********************************************************* */
 function cierramodalmuestraTareaimp()
 {
  $(".modalmuestraTareaimp").fadeOut(); 
 }
 /********************************************************* */
 function cierraModalentregatareas()
 {
  $(".modalEntregatareas").fadeOut(); 
 }
 /********************************************************* */
 function cierramodalmuestraTareacom()
 {
  $(".modalmuestraTareacom").fadeOut();  
 }
 /********************************************************* */
 function cierraModalalerta()
 {
  $(".modalAlerta").fadeOut();
 }
 /********************************************************* */
 function cierraModal()
 {
  $(".modal").fadeOut();
 }
 /********************************************************* */
 function cierraModaltareas()
 {
  $(".modalTareas").fadeOut();
 }
 /********************************************************* */
 function cierraModalvisualiza()
 {
  $(".modalVisualiza").fadeOut();
 }
 /********************************************************* */
 function cierraModalfecha()
 {
  $(".modalFecha").fadeOut();
 }
 /********************************************************* */
 function cierramuestraPosFecha()
 {
  $(".modalMuestraFechaPos").fadeOut();
 }
 /********************************************************* */

 function cierraModalPosfecha()
 {
  $(".modalposFecha").fadeOut();
 }
 /********************************************************* */
 function cierraModalsubtareas()
 {
  $(".modalsubTareas").fadeOut();  
 }
  /********************************************************* */
 function devolverPersonas(objeto){
   var tipo = objeto.value;
   var xhr = new XMLHttpRequest();
   var datos = new FormData();
   datos.append('strvalor',tipo);
   xhr.open('POST',"<?php echo base_url();?>asigna/GetPersonas",true);
    xhr.onload = function()
    {
      if(this.status===200)
     {       
      var respuesta =JSON.parse(xhr.responseText);
       var borratabla = document.getElementById('listado-contactos');
       var rowCount = borratabla.rows.length; 
       for (var x=rowCount-1; x>0; x--) { 
        borratabla.deleteRow(x); 
         } 
      for(let i = 0; i < respuesta.length; i++) {
        var fila="<tr><td>"+respuesta[i]['idPersona']+"</td><td>"+respuesta[i]['nombres']+"</td><td>"+respuesta[i]['EMail1']+"</td><td>"+respuesta[i]['clasificacion']+"</td><td id ='"+respuesta[i]['nombres']+"'><a class='btn-agregar btn' id='"+respuesta[i]['idPersona']+"' name='"+respuesta[i]['clasificacion']+"'><i  class='far fa-check-circle completo'></i> </a></td></tr>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tabla-contactos").appendChild(btn);
       }
     }   
    }
    xhr.send(datos);  
 } 
 /********************************************************* */
 function devolverPersonas2(objeto){
   var tipo = objeto.value;
   var xhr = new XMLHttpRequest();
   var datos = new FormData();
   datos.append('strvalor',tipo);
   xhr.open('POST',"<?php echo base_url();?>asigna/GetPersonas",true);
    xhr.onload = function()
    {
      if(this.status===200)
     {       
      var respuesta =JSON.parse(xhr.responseText);
       var borratabla = document.getElementById('listado-empleados');
       var rowCount = borratabla.rows.length; 
       for (var x=rowCount-1; x>0; x--) { 
        borratabla.deleteRow(x); 
         } 
      for(let i = 0; i < respuesta.length; i++) {
        var fila="<tr><td>"+respuesta[i]['idPersona']+"</td><td>"+respuesta[i]['nombres']+"</td><td>"+respuesta[i]['EMail1']+"</td><td>"+respuesta[i]['clasificacion']+"</td><td id ='"+respuesta[i]['nombres']+"'><a class='btn-agregar btn' id='"+respuesta[i]['idPersona']+"' name='"+respuesta[i]['clasificacion']+"'><i  class='far fa-check-circle completo'></i> </a></td></tr>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tabla-empleados").appendChild(btn);
       }
     }   
    }
    xhr.send(datos);  
 } 

</script>
<?php
 function imprimirBotonera($array)
{
 $option='';
  foreach ($array as $key => $value) {$option.='<button class="btnBotonera" value="'.$value['Name'].'" data-tipopersona="PERSONAL" onclick="devolverPersonas(this)"><h5 class="fas fa-user-plus fa-x"></h5><br>'.$value['Name'].'</button>';}  
  $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTES" onclick="devolverPersonas(this)">Clientes</button>';
 // $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTESBUSCADOS" id="btnEncuestasAlternas" onclick="insertaEncuestasAlternas(this)">Encuestas Alternas</button>';
  return $option; 
}
function imprimirBotonera2($array)
{
 $option='';
  foreach ($array as $key => $value) {$option.='<button class="btnBotonera" value="'.$value['Name'].'" data-tipopersona="PERSONAL" onclick="devolverPersonas2(this)"><h5 class="fas fa-user-plus fa-x"></h5><br>'.$value['Name'].'</button>';}  
  $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTES" onclick="devolverPersonas2(this)">Clientes</button>';
 // $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTESBUSCADOS" id="btnEncuestasAlternas" onclick="insertaEncuestasAlternas(this)">Encuestas Alternas</button>';
  return $option; 
}

?>

