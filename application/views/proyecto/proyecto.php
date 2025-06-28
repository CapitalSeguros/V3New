
<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>



<style type="text/css">
.rowEscogido{background-color:#D7CCC8 }
.tareas{height: 552px;width: 100%;overflow: scroll;margin-bottom: 20px;border: 1px solid #ddd;
    border-top: solid 2px;}
.ocultarHijoModal{display: none}
.verHijoModal{position: absolute;top:20%;left:30%;z-index:200000;background: #bfbac5;width: 600px;height: auto;transition: all 1s;top:50%;}
.aside-izquierda{width: 20%;background: #ccc;float: left;padding: 20px;box-sizing: border-box;height:100vh; }
 .fa, .far, .fas {font-family: Font Awesome\ 5 Free;}
.actividadesTareas{display:flex;flex-direction: column;}
#nuevo-hora{display: none;}
.icono {padding: 7px;color: #5B33FF;height: auto;transition: 0.3s;cursor: pointer;}
.icono2 {padding: 7px;color: #5B33FF;border: solid 1px;height: auto;border-radius: 4px;transition: 0.3s;background: white;}
.icono2:hover {background: #5b33ff;color: white;cursor: pointer;}
.cafe {color: #BA4A00;padding: 7px;}
.rojo{color: rgb(250, 16, 5);font-family: 'Raleway', sans-serif !important;}
.proyectosV3{width: auto;display: flex;	justify-content: center;background-color: rgba(255 255 255 /70%);padding: 5px;}
.panel {padding: .5rem;margin: 0rem;}
.lista-proyectos .detaProyecto {display: flex;padding: 5px;margin-left: 0;margin-right: 0;justify-content: space-between;}
input{height: 3rem;}
input:focus {background-color: lemonchiffon;}
.detaProyecto input{width: 100%;}
a.nuevoboton{/*margin-left: auto;margin-right: auto;*/background-color: #008CBA;/*text-align: center;*/text-transform: uppercase;padding: .5rem;color:white;border: none;text-decoration: none;height: 20px;border-radius: 3px;}
 .panel .crear-proyecto{margin-top: 10px;text-align: center;}
.seccion-principal{margin: auto;width: 80%;float: right;height:100vh;}
.contenedor-app{/*margin: 0 auto;min-width: 285px;height:100px;*/box-shadow: 0px 0px 3px 3px rgb(0 0 0 / 11%);}
.contenedor-tareas{display: flex;/*margin:0 auto;*/width: 100%;flex-direction: column;}
.agrega_Tareas
{
  padding-top:5px;
  /*margin-left: 10px;*/
  display: flex;
  justify-content: space-between;
  display: flex;
  flex-direction: column;
}

.tittarea
{
    width: 100%;
    height: auto;
    margin-right: 30px: 
    margin-bottom:10px;
    padding-bottom: 10px;
    display: flex;
    margin-top: 13px
}
.tittarea span{width: 15%;min-width: 10px;}
.tittarea1{width: 83%; display: flex;   }
.lista-proyectos ul{list-style: none;padding: 1rem 0 0 0;margin: 0;text-decoration:none;max-height: 200px;overflow: auto;background: aliceblue;}
.lista-proyectos ul li {
    padding: .5rem 0 0 0;
    list-style: none;  
    
}
.lista-proyectos ul li a
{
    list-style: none;  
    text-decoration:none;
    color: black; 
    width: 100%;
}
.lista-proyectos ul li a:hover {
    color: #1c893c /*#35fd71*/;
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
/*button[type="button"] {
    color: #0099CC;
    border: 2px solid #0099CC;
    border-radius: 6px;
    padding: 10px;
    background: transparent;
    cursor: pointer;
}*/
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
.modalusuariosubTareas
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
.modalAgregaComite
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
    z-index: 2 /*1040*/;
    overflow: hidden;
    outline: 0;
}
.modalsubFecha
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
.modalsubAlerta
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
    /*margin-left: 300px;
    margin-top: 100px;*/
    transition: all .5s;
     top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
       overflow: auto;
    height: auto;
    outline: 0;
    margin: 2% auto;
    border-radius: 8px;
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
.modalDocumentos
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
.titComite{
  display:flex;
  justify-content: center;
  
  align-items:center;
  padding: 10px;
}
.titComite label{
  margin:0px 5px;
  font-size: 14px;
}
.modalmuestraPosFecha
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
.contenedor-modalmuestraPosFecha
{
  background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 50px;
    height: 580px;
}
.contenedor-modalDocumentos
{
  background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 50px;
    height: 580px;
    border-radius: 8px;
}
.contenedor-modalposFecha
{
  background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 100px;
    border-radius: 8px;
}


.contenedor-modalFecha
{
    background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 100px;
    height:350px;
    overflow: auto;
    border-radius: 8px;
}
.contenedor-modalsubFecha
{
    background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 100px;
    height:350px;
    overflow: auto;
    border-radius: 8px;
}
.contenedor-modalsubAlerta
{
  background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 100px;
    height:350px;
    overflow: auto;
    border-radius: 8px;
}
.contenedor-modalAlerta
{
    background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 100px;
    height:350px;
    overflow: auto;
    border-radius: 8px;
}
.contenedor-titProyecto
{
    /*margin-top:0px;
    float: right;
    width: 50%;*/ 
    height: 400px; 
    /*padding: 5px;
    flex: 1;*/
    overflow: auto;
    
}
.contenedor-subtareas
{
  background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 5%;
    border-radius: 5px;
}
.contenedor-modalAgregaComite{background-color: rgb(221, 241, 241);align-items: center;width: 700px;margin-left: auto;margin-right:auto;margin-top: 34px;height: 350px/*95%*/;color:black;border-radius: 8px;overflow: auto;}


.contenedor-modalmuestraTareaimp{background-color: rgb(221, 241, 241);align-items: center;width: 90%;margin-left: auto;margin-right:auto;margin-top: 30px;height:95%;color:black;border-radius: 8px;}
.tipocolor{color:red;}
.modal{background-color: rgba(0,0,0,40%);position:fixed;display:none;height: 100vh;width: 100vw;transition: all .5s;}
.contenedor-modal{background-color: #f3f3f3;align-items: center;display: flex;border-radius: 8px;width: 90%;height: 90%;margin: auto;
    margin-top: 34px;padding: 10px;}
.contenedor-modalTexto{padding:10px;background-color:black;align-items: center;display: flex;flex-direction: row;overflow: auto;height: 350px;border-radius: 5px;}
#textoMostrar{color: white;}
.btncierra{display: flex;justify-content: flex-end;padding:10px 15px 5px;/*margin-right: 20px;*/}
#textoFechamostrar{/*margin-left: 5px; overflow: hidden;*/padding: 5px 15px;margin: 0px;}
.subtareas{color:black;background-color: #addfaf}
.subTareaInfo:hover{cursor: pointer;background-color: #8cca8e}
.textoFecha{display: flex;justify-content: center; padding: 1rem;margin-left: 1rem;flex-direction: row;align-items: center;}
.textoFecha label{margin-left:8px;}
.textoFecComite{padding: 10px;}
#textoAlerta, #comiteTarea{/*overflow: hidden; margin-left: 10px;*/padding: 5px 15px;margin: 0px;}
.grabaFecha{display: flex;align-items: center; justify-content: center;height: 60px;}

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
background-color: #017095;
text-align: center;
text-transform: uppercase;
padding: .5rem;
color:white;
border: none;
text-decoration: none;
height: 30px;
border-radius:5px;
}
.btnGrabaposFecha:hover {background-color: #00536e;color: white;}
.btneliminaFecha {
   /* margin-left: 8px;
    /* margin-right: auto; */
    background-color: #c71010;
    text-align: center;
    text-transform: uppercase;
    padding: 0.5rem;
    color: white;
    border: none;
    text-decoration: none;
    /* height: 30px; */
}
.btneliminaFecha:hover {background-color: #fa1c1c;color: white;}
.btnGrabafecha
{
/*margin-left: auto;
margin-right: auto;*/
margin-right: 40px;
background-color: #017095;
text-align: center;
text-transform: uppercase;
padding: .5rem;
color:white;
border: none;
text-decoration: none;
height: 30px;
}
.btnGrabafecha:hover {background-color: #00536e;color: white;}
/*.btnGrabasubfecha
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
}*/
.btnGrabasubfecha
{
/*margin-left: auto;
//margin-right: auto;*/
background-color: #017095;
text-align: center;
text-transform: uppercase;
padding: 10px 10px;
color:white;
border: none;
text-decoration: none;
/*height: 30px;*/
}
.btnGrabasubfecha:hover {background-color: #00536e;color: white;}
.btneliminasubfecha 
{
    margin-left: 8px;
    /*margin-right: auto;*/
    background-color: #c71010;
    text-align: center;
    text-transform: uppercase;
    padding:10px 10px;
    color:white;
    border: none;
    text-decoration: none;
   /* height: 30px;*/
    
}
.btneliminasubfecha:hover {background-color: #fa1c1c;color: white;}
.btnGrabaAlerta
{
    /*margin-left: auto;
    margin-right: auto;*/
    background-color: #017095;
    text-align: center;
    text-transform: uppercase;
    padding: .5rem;
    color:white;
    border: none;
    text-decoration: none;
    height: 30px;
    
}
.btnGrabaAlerta:hover {background-color: #00536e;color: white;}
.btnGrabasubAlerta
{
 /* margin-left: auto;
    margin-right: auto;*/
    background-color: #008CBA;
    text-align: center;
    text-transform: uppercase;
    padding: .5rem;
    color:white;
    border: none;
    text-decoration: none;
    height: 30px;
}
.btneliminasubAlerta 
{
    margin-left: 10px;
    /*margin-right: auto;*/
    background-color: #FA1C1C;
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
    /*width: 13%;
    height:100vh;*/
    background: #f7f7f7;
    /*box-sizing: border-box;
    margin:0;*/
    padding: 5px;
  /*  background: #ccc;
    float: left;
    padding: 20px;
    box-sizing: border-box;
    */
    max-width: 143px;
    height: 400px;
    overflow: auto;
}
.btnBotonera{width: 100px;height: 80px;border: 1px solid #bacaff;border-radius: 5px;margin-bottom: 5px;padding: 5px;background: #f2f5ff;transition: all 0.3s;font-size: 12px;}
.btnBotonera > i {font-size: 24px;}
.btnBotonera:hover{background: #dfe4f3;border-color: #dfe4f3;color: #472380;}

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
   font-size: 2rem;
   font-weight: 600;
}
.titulo-modal
{
    padding-left: 36px;
}
.cierra-modal
{
   /* margin-left: auto;*/
   height: 30px;
  /* margin-right:36px ;*/
}
.ocultarObjeto
{
     /*width: 100%;*/
    padding: 10px;
    /*margin-right:40px ;*/
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
    border-radius: 6px;
    outline: none;
    color: black;
}
.contenedor-tabla{
    /*margin-top: 20px;
    width: 97%;*/
    height: 350px; /*350px*/
    overflow: scroll;
    overflow-y: scroll;
    background: white;
    border: 1px solid #cbcbcb;
    border-radius: 5px;
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
    width: 100%;
    height: 200px;
    overflow: auto;
}
#ullistaInvitado, #ullistaEmpleados
{
  margin-top: 10px;
  background: aliceblue;
    padding: 10px;
    border: 1px solid #ddd;
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
    

    height: auto;
}
.tittarea span
{
    width: 15%;
    min-width: 10px;
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
  padding:0 15px;
  background-color:#017095;
  color:white;
  border-radius:5px;  
  transition: 0.3s;
}
.boton-subtarea input:hover
{
  cursor: pointer;
  background-color:#366aca;
}

#nuevo-tarea
{
   /*padding: 0px;*/
   width: 100%;
 /*   justify-content: center;*/
    height: 34px;
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
#tareaAgregadas{
    margin-left: 0px;
    padding-left: 10px;
}
#tareaAgregadas div > li{
  display: flex;
    text-decoration: none;
    list-style: none;
    justify-content: space-between;
    height: 50px;
    /*border-bottom: 1px solid #ccc;*/
    overflow: hidden;
    padding-top: 10px;
    align-items: center;
}
#tareaAgregadas li p{
  /*flex: 1 1 0px;
    width: 800px;
    min-height: 52px;*/
    line-height: 1.8rem;
    overflow: hidden;
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    margin-left: 5px;
    padding-top: 5px;
    height: 50px;
    /*margin-top: 10px;*/
    width: 84%;
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
#ullistasubEmpleados li  {
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
     border-bottom: 1px solid #38496E /*rgb(231, 42, 42)*/;
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
    padding: 7px;
    cursor: pointer;    
    /*color: #00B762*/;
    padding: 7px;
    border-bottom: 1px solid #38496E /*rgb(231, 42, 42)*/;
}
.terminado1.fa-check-circle {
    color: #00ff89;
}
.terminado1.fa-file {
    color: #19ddff;
}
.basura {
    color: red;
    display: inline;
}
.barra-avance
{
    height: 30px;   
    width: 100%;
    /*margin: 0 auto;
    max-width : 800px;*/
    background-color: #dfdfdf /*#e9ecef*/;
    border-radius: 5px;
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
    border-radius: 5px;
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
        height: 40px;
        border-bottom: 1px solid #ccc;  
        overflow: hidden;
        
    }
    #tareaImportantes li p{
      margin: 0 0 10px;
        
    }
    .ocultar
    {
      display: none;
    }
    .listaProyectos
    {
      display: flex;  
      justify-content:space-between; 
     align-items:center;  
    }
    #textoposFecha{
      text-align:center;
      color:black;
      text-transform:uppercase;
    }
    .pospuesta
    {      
        border: none;
        font-size: 16px;
        width: 100%;
        color: #ff6500 /*rgb(186, 74, 0)*/;
    }
    .comite{
      color: rgb(186, 0, 138);
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
    .btnmuestraComite
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
    .btnmuestraComite a{
      background-color: #008CBA;
      padding: 10px 5px;
      color:white;
    }
    .btnmuestraComite a:hover{
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
    .ventana
    {
      height:auto;
      width:260px;
      background-color:rgb(225,219,224);
      position: relative;
      left: 75%;
      overflow-y: scroll;   
      height: 200px;
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
      width:250px;
      height: 30px;
    }
    .letras{
      font-family: 'Raleway', sans-serif;
      /*padding-left: 8px;*/
      size:6px;
      color:white;
      font-weight: 300;
    }
    .linea
    {
      border-bottom: 1px solid #38496E /*rgb(231, 42, 42)*/;
    }
    .linea.fa-calendar-alt {
        color: #ed6bb8;
    }
    .linea.fa-stopwatch {
        color: #ffc376;
    }
    .linea.fa-calendar-check {
        color: #76cbff;
    }
    .buscador
    {
        width: 100%;
        height: 3rem;
        padding: 3px;
        border:1px solid #e1e1e1;
    }
    .listado-historico
    {
      width: 100%;
      border-collapse: collapse;
    }
    .listado-historico thead{
      background-color: slateblue;
      color: white;
    }
    .listado-historico tbody td{
      padding: 5px ;
      text-align: center;
      border: black 2px solid;;
    }
    .spinner {
      margin: 10px auto;
      /*width: 50px;*/
      height: 100px;
      text-align: center;
      font-size: 10px;
    }
    .spinner > div {
      background-color: white /*#26C6DA*/;
      height: 100%;
      width: 10px;
      display: inline-block;
      
      -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
      animation: sk-stretchdelay 1.2s infinite ease-in-out;
    }
    .spinner .rect2 {
      -webkit-animation-delay: -1.1s;
      animation-delay: -1.1s;
    }
    .spinner .rect3 {
      -webkit-animation-delay: -1.0s;
      animation-delay: -1.0s;
    }
    .spinner .rect4 {
      -webkit-animation-delay: -0.9s;
      animation-delay: -0.9s;
    }
    .spinner .rect5 {
      -webkit-animation-delay: -0.8s;
      animation-delay: -0.8s;
    }
    @-webkit-keyframes sk-stretchdelay {
      0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
      20% { -webkit-transform: scaleY(1.0) }
    }
    @keyframes sk-stretchdelay {
      0%, 40%, 100% { 
        transform: scaleY(0.4);
        -webkit-transform: scaleY(0.4);
      }  20% { 
        transform: scaleY(1.0);
        -webkit-transform: scaleY(1.0);
      }
    }
    .desabilitar{
      background: gray !important;
    }
    .hidden{
      display: none;
    }
    .listaProyectos{display: flex;  justify-content:space-between; align-items:center;}
    .Exportar{display: flex;justify-content:space-between; }
    /*#momento-comite{position: fixed;text-align: center;margin-left: auto;margin-right:auto;height: 100vh;width: 75vw;  }
    #momento-comitea img {display: block;margin: 0 auto;}
    #momento-comite p{color :#FF0000;font-size: 14px;font-weight: bold;}*/
    #momento {position: fixed;text-align: center;margin-left: auto;margin-right:auto;height: 100vh;width: 100vw;margin-top: 80px;}
    #momento img {display: block;margin: 0 auto;}
    #momento p{color :RGB(16, 5, 250 );font-size: 14px;font-weight: bold;}
    .btnmodificaAlerta {margin-left: 8px;background-color: #048300;text-align: center;text-transform: uppercase;padding: .5rem;color:white;border: none;text-decoration: none;}
    .btnmodificaAlerta:hover {background-color: #035600;color: white;}
    .btneliminaAlerta {margin-left: 8px;background-color: #c71010;text-align: center;text-transform: uppercase;padding: .5rem;color:white;border: none;text-decoration: none;}
    .btneliminaAlerta:hover {background-color: #fa1c1c;color: white;}
    .colorGris{color: #cccccc}
    #momento-usuarioSubtarea{
      position: fixed;
      text-align: center;
      margin-left: auto;
      margin-right:auto;
      height: 100vh;
      width: 75vw;
      /*margin-top: 30px;*/
    }#momento-usuarioSubtarea img {
      display: block;
      margin: 0 auto;
    }
    #momento-usuarioSubtarea p{
      color :#FF0000;
      font-size: 14px;
      font-weight: bold;
    }
    #momento-subfecha{
      position: fixed;
      text-align: center;
      margin-left: auto;
      margin-right:auto;
      height: 100vh;
      width: 75vw;
      /*margin-top: 30px;*/
    }#momento-subfecha img {
      display: block;
      margin: 0 auto;
    }
    #momento-subfecha p{
      color :#FF0000;
      font-size: 14px;
      font-weight: bold;
    }
    .sub li p{height : auto;}
    #agregarArchivoDicContent{display:flex;align-items:center}
    #escogerArchivosAD{width:40px}
    #escogerArchivosAD::before {content: url(<?=base_url().'assets/img/'?>iconosGenerales/subirArchivo.png);position: relative; top:-5px}
    #escogerArchivosAD:hover:before{border:solid 1px black}
    #contieneNombreDocumentosAD{border-left:none;border-right:none;border-top:none}
    #guardarDocumentoAD{border:none;  background-color: white;}
    #guardarDocumentoAD::before{content: url(<?=base_url().'assets/img/iconosGenerales/guardar.png'?>)}
    #guardarDocumentoAD:hover:before{color:blue;cursor:pointer;border:solid}
    #documentosFormDAD{display:flex}
    .ocultarObjetoInvitados{display:none;}
    .sub{border-left: solid 2px;border-right: solid 2px;border-bottom: solid 2px;/*border-color: black*/;background-color: white;    border-radius: 0px 0px 5px 5px;}

    #tareaAgregadas>div[class="sub"]{border:solid 1px;}  
    .responDivCabTareas{border-top:solid 1px;border-left:solid 1px;border-right:solid 1px;border-bottom: 1px dashed;width: 100%;height: 50px;margin-top: 20px;display: flex;background-color: #b3b3d6}
    /*.responDivCabTareas>div[data-tipo="responsables"]{display: flex;overflow: auto;height: 100%;flex:5;}
    .responDivCabTareas>div[data-tipo="fecha"]{flex:2;}
    .responDivCabTareas>div[data-tipo="produccion"]{flex:1}*/
    .rowTarea:hover{background-color: #8bbdfe;text-decoration: underline;cursor: pointer}
    .verScrooll{overflow: scroll;}
    .subTareaInfoEscogido{height: 100px;overflow-y: scroll;background-color: #78a57a}
    /*div[data-tipo="fechacreacion"]{margin-right: 13px}*/
    .estrellasSpan{border: 2px solid #bf9f25;background: #fcd53f;border-radius: 10px;/*margin-top: 13px;*/padding: 5px;/*10px;*/}
    .estrellasLabel{color: black;background-color: white;border:1px solid #d58a00;border-radius: 20px;padding: 5px;margin: 0px;}
    .ocultarObjetoFiltrados{display: none}
/* //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// */

    /*Styles Tarea Proyecto Seguimiento - STPS*/
    /*ID*/
        #listado-historico {height: 100%;margin: 0px;}
        #tabla-historico > tr > td:nth-child(4) {min-width: 200px;}
        #tabla-historico > tr > td:nth-child(9) {min-width: 200px;}
        #tabla-historico > tr > td:nth-child(10) {min-width: 180px;}
        #tabla-historico > tr > td:nth-child(11) {min-width: 200px;}
        #BtnMenuSeguimiento.active {margin-left: -250px;}
        #momento-modalFecha, #momento-comite {position: absolute;width: inherit;height: 350px;display: flex;justify-content: center;align-items: center;flex-direction: column;background: #0000006b;}
    /*Conatiners*/
        .contenido{display: flex;/*margin-left: 40px;*/width: 100%;align-items: stretch;}
        .contenidoPrincipal{display: flex;flex-direction: column;padding: 15px 25px;width: 100%;transition: all 0.3s;}
        .panel_botones{background-color: #2b3d6c;min-width: 260px;max-width: 260px;float: left;padding: 5px;height: auto;border-right: 1px solid #e1e1e1;transition: all 0.3s;}
        .container-spinner {width: -webkit-fill-available;height: -webkit-fill-available;position: absolute;z-index: 2;}
        .container-spinner-bar {width: -webkit-fill-available;height: 100%;position: absolute;z-index: 2;}
        .container-badge {position: relative;}
        .container-img-user {padding: 5px;}
        .container-img-user > img {width: 35px;height: 35px;min-width: 35px;min-height: 35px;border-radius: 20%;box-shadow: 0 0 2px 0.25rem #32468f85;}
        .container-info-task {/*height: 80px;*/padding: 3px 15px;background: #b0bad7;border: 1px solid;border-style: dotted;border-top: none;/*max-height: 100px;overflow: auto;*/}
        .bodymodal {/*border: 1px solid #ddd;*/border-radius: 5px;margin: auto;width: 90%;height: 90%;}
        .icono-tarea {padding: 0px 5px;}
        .container-time-pause {background: #f6f6f6;padding: 0px 50px;border: 1px solid #ddd;}
        div[data-tipo="produccion"] > img {width: 48px;height: -webkit-fill-available;}
        /*.container-img-user > img:nth-child(1) {padding-left: 10px;}*/
        .collapse.show {visibility: visible;}
        .avance {display: flex;align-items: center;justify-content: flex-start;padding: 5px 15px;border: 1px solid #ddd;}
        .lista-proyectos {border-radius: 4px;}
    /*Spinners*/
        .container-spinner-content-loading {
            margin: 0px;
            color: #266093;
            width: 100%;
            height: 100%;
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            background-color: rgb(255 255 255 / 95%);
            /*z-index: 1;*/
            transition: all 0.3s;
        }
        .container-spinner-bar-content-loading {
            margin: 0px;
            color: #266093;
            width: 100%;
            height: 100%;
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            background-color: rgb(0 0 0 / 45%);
            /*z-index: 1;*/
            transition: all 0.3s;
        }
    /*Columns*/
        .col-flex-center-center {display: flex;justify-content: center;align-items: center;}
        .col-flex-center-start {display: flex;justify-content: flex-start;align-items: center;}
        .col-flex-center-end {display: flex;justify-content: flex-end;align-items: center;}
        .col-flex-content-center {display: flex;justify-content: center;}
        .col-flex-start {display: flex;justify-content: flex-start;}
        .col-flex-end {display: flex;justify-content: flex-end;}
        .col-flex-items-center {display: flex;align-items: center;}
        .col-flex-bottom {display: flex;align-items: flex-end;}
        .col-grid-start {display: flex;flex-direction: column;align-items: flex-start;}
        .col-grid-center {display: flex;flex-direction: column;align-items: center;justify-content: center;}
        .col-grid-center-start {display: flex;flex-direction: column;align-items: flex-start;justify-content: center;}
        .col-flex-space-evenly {display: flex;justify-content: space-evenly;}
        .width-ajust {width: 100%;max-width: max-content;}
        .col-panel-btn {display: flex;flex-direction: column;/*justify-content: space-between;*/}
    /*Buttons*/
        button:active, button.btn:active {
          outline: 0;
        }
        button:focus, button.btn:focus {
          outline: 0;
        }
        .btn-primary-two {color: #fff;background-color: #286090;border-color: #286090;font-size: 13px;}
        .btn-success {color: black;}
        .btn-danger {color: white;}
        .btn-wine {color: white;background-color: #732C60;}
        .btn-option-proyect {color: #170c66;border: 1px solid #a8a5d1;background: #a8a5d1;padding: 6px;border-radius: 4px;transition: 0.3s;}
        .cierra-modalmuestraTareaimp {color: white;border-radius: 5px;}
        .btn-panel {border: none;font-size: 16px;width: 100%;color: #b585ff;}
        .btn-task-disabled {color: #ababab;background: #34497e;cursor: default;}   
        .btn-activity-task {font-size: 1.45rem;transition: all 0.3s;background: transparent;border: none;color: white;border-bottom: 1px solid #38496E;text-align: start;padding: 3px 8px;text-decoration: none;}
        .btn-primary-two:hover {background: #3e45a1;border-color: transparent;color: white;}
        .btn-wine:hover {background: #a5508e;border-color: #a5508e;color: white;}
        .btn-option-proyect:hover {color: #1b4d83;background: #a5b4d1;border-color: #8c9fc5;}
        .btn-activity-task:hover {background: #31558f;border-radius: 5px;-webkit-transform: scale(1.01);}
        .btn-task-disabled, .btn-task-disabled > span, .btn-task-disabled:hover {color: #ababab;cursor: default;background: #475987;border-radius: 0px;-webkit-transform: scale(1.0);} 
        .btn-option-proyect:active, .btn-option-proyect:focus {outline: 0;}
    /*Dropdowns*/
        ul.dropdown-menu > li {height: auto;padding: 0px;/*3px 0px*/}
        .dropdown-item {transition: 0.3s;}
        .dropTarea .dropdown-item:hover {color: white;background-color: #9a9240;}
        .dropTarea .dropdown-item:hover > i {color: white;}
    /*Tables*/
        /*tbody > tr > td > button, tbody > tr > td > a {font-size: 13px;}*/
        /*td > span.label { font-size: 13px;font-weight: 600; }*/
        table {margin: 0px;}
        .table > thead >.tr-style {background: #1e4c82;/*#5d418b*/z-index: 1;color: white;}
        .table > thead >.table-tr {background: #5d418b;z-index: 1;color: white;}
        .table-thead {position: sticky;top: 0;z-index: 1;}
        .table-tfoot {position: sticky;bottom: 0px; background-color:#e3e3e3;}
    /*Texts*/
        .badge-title-proyect {position: absolute;top: -8px;background: #337ab7;height: fit-content;}
        .textLabel {margin: 0px;color: black;font-size: 12px;}
        .text-form {color: #3d3d3d;font-size: 14px;margin-bottom: 0px;margin-right: 5px;}
        .agrega_usuario {font-size: 24px;padding-top: 10px;}
        .p-loading {color:white;font-size: 24px;text-align: center;font-weight: 600;}
        .container-time-pause > h5 > strong > span {color: #28116c;}
    /*Icons*/
        .icon-pause {font-size: 30px;color: #160089;}
        .btn-activity-task > i {width: 16px;text-align: center;}
        .btn-activity-task > i.fa-file {color: #19ddff;} /*muestratareasImportantes*/
        .btn-activity-task > i.fa-check-circle {color: #00ff89;}
        .btn-activity-task > i.fa-star {color: #ffff00;}
        .btn-activity-task > i.fa-calendar-alt {color: #ed6bb8;}
        .btn-activity-task > i.fa-stopwatch {color: #ffc376;}
        .btn-activity-task > i.fa-calendar-times {color: #76cbff;}
        .btn-activity-task > i.fa-calendar-check {color: #b585ff;}
        .btn-activity-task > i.fa-thumbtack {color: #ff6500;}
        .btn-task-disabled > i.fa-file, .btn-task-disabled > i.fa-check-circle, .btn-task-disabled > i.fa-star, .btn-task-disabled > i.fa-calendar-alt, .btn-task-disabled > i.fa-stopwatch, .btn-task-disabled > i.fa-calendar-times, .btn-task-disabled > i.fa-calendar-check, .btn-task-disabled > i.fa-thumbtack {color: #ababab;}
        .listaProyectos > i.icono, .listaProyectos > form > i.icono {padding: 7px 4px;}
    /*Others*/
        .ocultarObj{display: none}
        .verObj{display: block;}
        .pd-left {padding-left: 0px;}
        .pd-right {padding-right: 0px;}
        .pd-top {padding-top: 15px;}
        .pd-bottom {padding-bottom: 15px;}
        .pd-items-table {padding-bottom: 5px;}
        .title-hr {margin: 10px 0px;border-top: 1px solid #deceeb;}
        .subtitle-hr {margin: 20px 0px;border-top: 1px solid #dbdbdb;}
        .segment-hr {border-color: #526B2B;margin: 20px 0px;}
        .indicador-hr {border-color: #7176ab;margin: 10px 0px;}
        .brd-right {border-right: 1px solid #dbdbdb;}
        .brd-left-p {border-left: 1px solid #7176ab;}
        .mg-right {margin-right: 5px;}
        .mg-bottom {margin-bottom: 5px;}
        .mg-cero {margin: 0px;}
        .mg-top-cero {margin-top: 0px;}
        .pd-side {padding-left: 5px;padding-right: 5px;}
    /*Swal*/
        .swal-modal, .swal2-modal {width: 28%; /* 68% height: 40%*/}
        .swal-button--confirm{background-color:#337ab7!important;}
        .swal-text, .swal2-html-container{/*color:#472380 !important;*/font-size: 15px;text-align: center;}
        .swal2-title {font-size: 22px;}
        .swal2-icon {font-size: 15px;}
        .swal2-styled.swal2-confirm, .swal2-styled.swal2-cancel {font-size: 13px;}
    /*Badges - Bootstrap v5.1*/
        .rounded-pill {border-radius: 50rem!important;}
        .rounded-circle {border-radius: 50%!important;}
        .p-2 {padding: .5rem!important;}
        .border-light {border-color: #f8f9fa!important;}
        .border {border: 1px solid #dee2e6!important;}
        .btn-primary .badge {color: white;}
        .translate-middle {transform: translate(-50%,-50%)!important;}
        .start-100 {left: 100%!important;}
        .top-0 {top: 0!important;}
        .position-absolute {position: absolute!important;}
        .badge {display: inline-block;padding: .35em .65em;font-size: .75em;font-weight: 700;line-height: 1;color: #fff;text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: .25rem;}

</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<?php $this->load->view('scripts/jsFuncionesGenerales');?>
<!--?
var_dump($devuelveComites);
?-->

    <!--Modal para documentos -->
    <div class="modalDocumentos" id='modalDocumentos'>      
     <div class="bodymodal">   
       
       <div class="contenedor-modalDocumentos"> 
       <div class="btncierra">
         <button class ="btn btn-wine cierra-modalmuestraTareaimp cierra-modalTarea" onclick="cierraModalDocumentos()"><i class="fas fa-times"></i></button>             
        </div>  
          <div class="col-md-12" id="agregarArchivoDicContent"> 
             <form id="documentosFormDAD">
                 <div class="col-md-3"><select class="form-control" id="tipoDocumentoSelectADoc" name="tipoDocumentoSelectADoc"><option value="0">--Seleccione--</option></select></div>
                 <div class="col-md-3"><input type="file" id="escogerArchivosAD" name="escogerArchivosAD" class=" form-control file-select"title="SELECCIONAR ARCHIVO"></div>
                 <div class="col-md-3"><input type="text" class="form-control" id="contieneNombreDocumentosAD" name="contieneNombreDocumentosAD" readonly="false"></div>
                 <div class="col-md-3"><button class="btn btn-primary-two" id="guardarDocumentoAD" onclick="guardarDocumentoClienteADoc('',this,event)" title="GUARDAR ARCHIVO"></button></div>
            
            </form>
          </div>   
          <div>
    <hr>

   <div id="archivosClienteDocumentosAD" style="overflow:scroll">Archivos</div>
  </div>
       </div> 
     </div>       
    </div>
    <!--Modal para documentos -->
     <!--Modal para agregar empleados  tareas-->
         <!--Modal para comite -->
  <div class="modalcomite" id='modalcomite'>      
   <div class="bodymodal">   
     <div class="contenedor-modalmuestraPosFecha">       
        <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierraModalComite()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div class= "textoComite">
            <h2 align="center"> Lista de Tareas Completadas</h2>                
        </div>
          <hr>
          <div class="muestra-proyectos">
                    <p>Tareas</p>
           </div>  
          <div class="muestra_proyectos">
           <ul id="muestratareasComite">
                 
           </ul>  
          </div>
          <div class="muestra-proyectos">
                    <p>SubTareas</p>
                  </div>  
          <div class="muestra_proyectos">
            <ul id="muestrasubtareasComite">
                 
            </ul> 
          </div> 
      </div>
   </div>
  </div>     
 <!--Termina Modal comite-->  
     
     <!--Modal para mostrar posFecha -->
     <div class="modalmuestraPosFecha" id='modalmuestraPosFecha'>      
       <div class="bodymodal">   
        <div class="contenedor-modalmuestraPosFecha">       
           <div class="btncierra">
             <button class ="cierra-modalTarea" onclick="cierramuestraPosFecha()"><i class="fas fa-times"></i></button>             
           </div>
           <div class= "textomuestraPosFecha">
            <h2 align="center"> Fechas Compromiso Vencidas</h2>
           <p id="textoposFecha"></p>        
          </div>

          <div class="btnmuestra">
            <!--a >Muestra</a-->
          </div> 
        <div class = "fecha_pospuestas" id="fecha_pospuestas">
                  <div class="muestra-proyectos">
                    <p>Proyecto</p>
                  </div>  
                  <div class="muestra_proyectos">
                   <ul id="muestraproyectos">
                 
                   </ul>                  
                 
                 </div> 
        </div>      
      <input type="hidden" id="idTareaposFecha" name = "idTareaposFecha" >
      </div>
   </div>
  </div>     
     <!--termina posFecha -->
      <!--Modal para posFecha -->
 <div class="modalposFecha" id='modalposFecha'>      
   <div class="bodymodal">   
     <div class="contenedor-modalposFecha">       
        <div class="btncierra">
         <button class ="btn btn-wine cierra-modalmuestraTareaimp cierra-modalTarea" onclick="cierraModalPosfecha()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
           <div id="momento-posfecha" class= "hidden">
               <p class="p-loading">Un momento....</p>
                     <div class= "spinner">
                    
                        <div class="rect1"></div>
                          <div class="rect2"></div>
                          <div class="rect3"></div>
                          <div class="rect4"></div>
                          <div class="rect5"></div>
                       </div>                            
          </div> 
        <div class= "textoposFecha">
            <h3 align="center"> Posponer Fecha de Entrega del Proyecto</h3>
           <p id="textoposFecha"></p>        
        </div>
        <div class= "textoFecha">
           <label>Nueva Fecha de Entrega:  <input id="posFecha" type="date" class="form-control" required></label> 
        </div>
        <hr>
        <div class= "grabaposFecha">
          <a href="#" class ="btnGrabaposFecha">Guardar</a>
        </div>
        <input type="hidden" class="form-control" id="idTareaposFecha" name = "idTareaposFecha" >
      </div>
   </div>
  </div>     
 <!--Termina Modal pstfecha-->  
   
     <!--Modal para Fecha de Entrega de  tareas-->
     <div class="modalFecha" id='modalFecha'>      
   <div class="bodymodal">   
     <div class="contenedor-modalFecha">       
        <div id="momento-modalFecha" class= "hidden">
               <p class="p-loading">Un momento....</p>
                     <div class= "spinner">
                    
                        <div class="rect1"></div>
                          <div class="rect2"></div>
                          <div class="rect3"></div>
                          <div class="rect4"></div>
                          <div class="rect5"></div>
                       </div>                            
                   </div>
        <div class="btncierra">
         <button class ="btn btn-wine cierra-modalmuestraTareaimp cierra-modalTarea" onclick="cierraModalfecha()"><i class="fas fa-times"></i></button>             
        </div>
        <hr> 
        <div class= "textoFechamostrar">
            <h2 align="center"> Tarea</h2>
           <p id="textoFechamostrar"></p>        
        </div>
        <div class= "textoFecha">
           <label>Fecha de Entrega <input class="form-control" id="fechaTarea" type="date"  required></label> 
           <label>Periodicidad del Compromiso
                <select class="form-control" name="periodoFecha" id="periodoFecha" required="">
                <option disableb select value=""> --Selecione</option>
                <option value="1">Diario</option>
                <option value="2">Dos veces por Semana</option>
                <option value="3">Semanal</option>
                <option value="3">Mensual</option>
                <option value="4">Bimestral</option>
                <option value="5">Anual</option>
              </select>
            </label> 
        </div>
        <hr>
        <div class= "grabaFecha">
          <a href="#" class ="btn btnGrabafecha">Guardar</a>
          <a href="#" class ="btn btneliminaFecha">Eliminar</a>
        </div>
        <input type="hidden" id="idTareaFecha" name = "idTareaFecha" >
      </div>
   </div>
  </div>
 
     <!--Modal para subFecha de Entrega de  tareas-->
   <div class="modalsubFecha" id='modalsubFecha'>      
   <div class="bodymodal">   
     <div class="contenedor-modalsubFecha">       
        <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierraModalsubfecha()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div id="momento-subfecha" class= "hidden">
               <p class="p-loading">Un momento....</p>
                     <div class= "spinner">
                    
                        <div class="rect1"></div>
                          <div class="rect2"></div>
                          <div class="rect3"></div>
                          <div class="rect4"></div>
                          <div class="rect5"></div>
                       </div>                            
                   </div> 
        <div class= "textoFechamostrar">
            <h2 align="center"> Tarea</h2>
           <p id="textosubFechamostrar"></p>        
        </div>
        <div class= "textoFecha">
           <label>Fecha de Entrega <input id="subfechaTarea" type="date"  required></label> 
           <label>Periodicidad Fecha Compromiso 
                <select name="periodosubFecha" id="periodosubFecha" required="">
                <option disableb select value=""> --Selecione</option>
                <option value="1">Diario</option>
                <option value="2">Dos veces por Semana</option>
                <option value="3">Semanal</option>
                <option value="3">Mensual</option>
                <option value="4">Bimestral</option>
                <option value="5">Anual</option>
              </select>
            </label>   
        </div>
        <!--div class= "textoFecha">
           <label>Fecha de Entrega <input id="subfechaTarea" type="date"  required></label> 
        </div-->
        <hr>
        <div class= "grabaFecha">
          <a href="#" class ="btnGrabasubfecha">Guardar</a>
          <a href="#" class ="btneliminasubfecha">Eliminar</a>
        </div>
        <input type="hidden" id="idTareasubFecha" name = "idTareasubFecha" >
      </div>
   </div>
  </div>     
  <!--Termina Modal para subFecha de entregas de  tareas-->  
<!-- Modal usuarios subtareas-->  
<div class="modalusuariosubTareas" id='modalusuariosubTareas'>      
    <div class="bodymodal">   
      <div class="contenedor-modal">
        <aside class="aside-modal-izquierda">
          <div style="width: 120px; display: list-item;height: 600px;overflow: scroll;margin-left: 2%"><?=imprimirBotonera4($clasificacionUsuarios)?>
          </div>
        </aside>
       <div class = "contenedor-titProyecto">
          <div class ="titProyecto">
                  <h2 id = "tituloTarea" class="titulo-modal">Agrega Usuarios</h2> 
                   <button class ="cierra-modal" onclick="cierrausuariosubtareas()"><i class="fas fa-times"></i></button>             
           </div> 
           <div class="col-md-4 col-sm-4 col-xs-4 ocultarObjeto" id="divBuscarEmpleado">
             <h2 style="text-align:center">Buscador</h2>
             <input type="text" id="buscadorEmpleado" class="buscador sombra" placeholder="Buscar Invitados..."></button>
           </div>
           <div class="contenedor-tabla">
               <table id="listado-subempleados" class="listado-contactos">                  
                <thead>
                         <tr>
                              <th>id</th>
                              <th>Nombre</th>
                              <th>Email</th>
                              <th>Clasificacion</th>
                              <th>Agregar</th> 
                         </tr>
                    <tbody id="tabla-subempleado" class= "tabla-contactos">
                         
                    </tbody>     
                 </thead>
                </table>
            </div>
            <div class="invitadoProyecto">
               <h2>Invitados Agregados</h2> 
               <div class="tareasubExterno">
                 <spam>Agrega Invitado <input type="text" class="UpperCase" id="tareasubExterno" name="tareasubExterno" placeholder="ejemplo@dominio.com"  autocomplete="off" ><i class="fas fa-user-plus fa-x icono"></i></spam>
             </div>
           </div>
           <div id="momento-usuarioSubtarea" class= "hidden">
               <p class="p-loading">Un momento....</p>
                     <div class= "spinner">
                    
                        <div class="rect1"></div>
                          <div class="rect2"></div>
                          <div class="rect3"></div>
                          <div class="rect4"></div>
                          <div class="rect5"></div>
                       </div>                            
                   </div> 
            <div class="listaInvitado">
            <h2>Lista de Empleado Agregados</h2>
              <ul id="ullistasubEmpleados">
                 
              </ul>
            </div>
         </div>         
     </div>
   </div> 
   <input type="hidden" id="nombresubTarea" name = "nombresubTarea" >
   <input type="hidden" id="idTar" name = "idTar" >
   <input type="hidden" id="idsubTar" name = "iddubTar" >
 </div>  
  
 <!--Termina Modal para agregar empleados  tareas-->  
 <div class="modalAlerta" id='modalAlerta'>      
   <div class="bodymodal">   
     <div class="contenedor-modalAlerta">       
        <div class="btncierra">
         <button class ="btn btn-wine cierra-modalmuestraTareaimp cierra-modalAlerta" onclick="cierraModalalerta()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div id="momento-alerta" class= "hidden">
               <p class="p-loading">Un momento....</p>
                     <div class= "spinner">
                    
                        <div class="rect1"></div>
                          <div class="rect2"></div>
                          <div class="rect3"></div>
                          <div class="rect4"></div>
                          <div class="rect5"></div>
                       </div>                            
                   </div> 
          <div class= "textoFec">
            <h2 align="center">Recordatorio de la Tarea</h2>
           <p id="textoAlerta"></p>        
        </div>
        <div class= "textoFecha">
           <label>Inicio de Alerta <input class="form-control" id="fechaAlerta" type="date"  required></label> 
           <!--Agregamos periodiciddad -->
           <label>Periodicidad del Compromiso 
                <select class="form-control" name="periodoAlerta" id="periodoAlerta" required="">
                <option disableb select value=""> --Selecione-- </option>
                <option value="1">Diario</option>
                <option value="2">Dos veces por Semana</option>
                <option value="3">Semanal</option>
                <option value="3">Mensual</option>
                <option value="4">Bimestral</option>
                <option value="5">Anual</option>
              </select>
            </label> 
        </div>
        <hr>
        <div class= "grabaFecha">
          <a href="#" class ="btn btnGrabaAlerta">Guardar</a>
          <a href="#" class ="btn btnmodificaAlerta">Modificar</a>
          <a href="#" class ="btn btneliminaAlerta">Eliminar</a>
        </div>
        <input type="hidden" id="idTareaAlerta" name = "idTareaAlerta" >
       </div>
   </div>
  </div>     

 
 <!--Modal para Alerta de  subtareas-->
 <div class="modalsubAlerta" id='modalsubAlerta'>      
   <div class="bodymodal">   
     <div class="contenedor-modalsubAlerta">       
        <div class="btncierra">
         <button class ="cierra-modalAlerta" onclick="cierraModalsubalerta()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div id="momento-subalerta" class= "hidden">
               <p class="p-loading">Un momento....</p>
                     <div class= "spinner">
                    
                        <div class="rect1"></div>
                          <div class="rect2"></div>
                          <div class="rect3"></div>
                          <div class="rect4"></div>
                          <div class="rect5"></div>
                       </div>                            
                   </div> 
          <div class= "textoFec">
            <h2 align="center">Recordatorio SubTarea</h2>
           <p id="textosubAlerta"></p>      
         
        </div>
        <div class= "textoFecha">
           <label>Fecha de SubAlerta <input id="fechasubAlerta" type="date"  required></label> 
           <label>Periodicidad de la SubAlerta 
                <select name="periodosubAlerta" id="periodosubAlerta" required="">
                <option disableb select value=""> --Selecione</option>
                <option value="1">Diario</option>
                <option value="2">Dos veces por Semana</option>
                <option value="3">Semanal</option>
                <option value="3">Mensual</option>
                <option value="4">Bimestral</option>
                <option value="5">Anual</option>
              </select>
            </label>  
        </div>
        <hr>
        <div class= "grabaFecha">
          <a href="#" class ="btnGrabasubAlerta">Guardar</a>
          <!--a href="#" class ="btnmodificasubAlerta">Modificar</a-->
          <a href="#" class ="btneliminasubAlerta">Eliminar</a>
        </div>
        <input type="hidden" id="idTareasubAlerta" name = "idTareasubAlerta" >
      </div>
   </div>
  </div>     
<!--Termina Modal para Alerta de  subtareas--> 

<!--Modal para visualizar tetxo de tareas  tareas-->
 <div class="modalVisualiza" id='modalVisualiza'>      
   <div class="bodymodal">   
   <div class="btncierra">
       <button class ="btn btn-wine cierra-modalmuestraTareaimp cierra-modalTarea" onclick="cierraModalvisualiza()"><i class="fas fa-times"></i></button>             
       </div>
     <div class="contenedor-modalTexto" style="display: flex; flex-direction: column;">       
       <div>
         <p id="textoMostrar"></p>
         </div>
         <div class="col-md-12">
           <table class="table" style="background-color: white"><thead><tr><th>Comentarios</th><th>Fecha</th></tr></thead><tbody id="tbodyComentarios"></tbody><tfoot id="tfootArchivos"></tfoot></table>
         </div>

      </div>
   </div>
  </div>     
 <!--Termina Modal para visualizar   tareas-->  
<!--Modal para mostar  tareas Terminada-->  
 <div class="modalmuestraTareacom" id='modalmuestraTareacom'>      
   <div class="bodymodal" style="height: 90%">   
     <div class="contenedor-modalmuestraTareaimp">       
        <div class="btncierra" style="display: flex">
         <div class="col-md-11"><h3 align="center">Historicos Acumulados</h3></div>
         <div class="col-md-1 col-flex-end width-ajust pd-right"><div class="col-md-12 width-ajust pd-left pd-right"><button class="btn btn-wine cierra-modalmuestraTareaimp"  onclick="cierramodalmuestraTareacom()"><i class="fas fa-times"></i></button></div></div>

        </div>
       
          <div class= "textoFecComite">             
             <hr style="margin-bottom: 5px;"><!--input type="text" id="buscadorHistorico" class="buscador sombra" placeholder="Buscar Proyectos..."-->              
            </div>  
            <div class="col-md-12" style="padding: 0px 35px;">
                <div class="col-flex-end pd-right" style="padding-bottom: 5px;">
                    <input type="text" class="form-control" placeholder="Filtrar" id="filterTableHistory" style="width: 30%;">
                </div>
                <div class="contenedor-tabla">
              <table class="table table-striped" id="listado-historico">                  
                <thead class="table-thead">
                        <tr class="table-tr">
                            <th>Seguimiento</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Responsables</th>
                            <th>Fecha Creación</th>
                            <th>Fecha Tarea Terminada</th>
                            <th>Fecha de Produccion</th>
                            <th>Fecha Finalización Actividad</th>
                            <th>Tiempo de Elaboración</th>
                            <th>Tiempo de Espera para Producción</th>
                            <th>Tiempo Total de la Actividad <br> (Desde la creación hasta la producción)</th>
                        </tr>
                    <tbody id="tabla-historico" class= "tabla-historico">
                    </tbody>     
                 </thead>
                </table> 
                </div></div>  

   
        <div class="btnmuestraComite">
          <!--a >Muestra</a-->
        </div>
              <!--div class = "tareas" id="tareas">
                  <ul id="tareaImportantes">
                 
                  </ul>
             </div-->       
        </div>        
      </div>
   </div>
  </div>     
 <!--Termina Modal tareras Terminadas-->  
<!--Modal para mostar  tareas importantes-->
<div class="modalmuestraTareaimp" id='modalmuestraTareaimp'>      
   <div class="bodymodal">   
     <div class="contenedor-modalmuestraTareaimp">       
        <div class="btncierra">
         <button class ="btn btn-wine cierra-modalmuestraTareaimp cierra-modalTarea" onclick="cierramodalmuestraTareaimp()"><i class="fas fa-times"></i></button>             
        </div>
       
          <div class= "textoFec">
            <h2 align="center">Lista de Tareas Importantes</h2>
           
               <div class = "tareas" id="tareas">
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
         <button class ="btn btn-wine cierra-modalmuestraTareaimp cierra-modalTarea" onclick="cierraModalentregatareas()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div class= "textoEntregaTareas">
            <h2 align="center">Fecha de Entrega de Tareas</h2>
            <div class = "tareas" id="tareas">
                  <ul id="tareaFechaImportantes">
                 
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
         <button class ="btn btn-wine cierra-modalmuestraTareaimp cierra-modalTarea" onclick="cierraModalentregaalertas()"><i class="fas fa-times"></i></button>             
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
 <!--Termina Modal mostrar Alerta de Entregas-->   
<!--Modal de Subtareas-->
  <div class="modalsubTareas" id='modalsubTareas'>      
   <div class="bodymodal">   
    <div class="contenedor-subtareas">
        <div class="btncierra">
         <button class ="btn btn-wine cierra-modalmuestraTareaimp" onclick="cierraModalsubtareas()"><i class="fas fa-times"></i></button>             
        </div>
         <h2 align="center">Subatreas</h2>
         <div class="tittarea2">
           <textarea class="form-control" name="nuevaSubtarea" id="nuevaSubtarea" cols="30" rows="2"></textarea>
         </div>
         <div class="boton-subtarea">
           <input class="btn" name="grabaSubtarea" id="grabaSubtarea" value="Grabar">
           <input type="hidden" id="inpsubtarea" name = "inpsubtarea" value="">
         </div>
    </div>       
    </div>
    </div>
<!--Termina Modal de Subtareas-->
<!--Modal de Agrega Comite-->
<div class="modalAgregaComite" id='modalAgregaComite'>      
   <div class="bodymodal">   
    <div class="contenedor-modalAgregaComite">
        <div id="momento-comite" class= "hidden">
            <p class="p-loading">Un momento....</p>
            <div class= "spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>                            
        </div> 
        <div class="btncierra">
         <button class ="btn btn-wine cierra-modalmuestraTareaimp" onclick="cierraModalAgregaComite()"><i class="fas fa-times"></i></button>             
        </div>
        <hr>
        <div class= "textoFec">
         <h2 align="center">Historico Almacenado</h2></div>
         <p id="comiteTarea" name="comiteTarea" style="color: #331563;"></p>
         <div class="titComite">
          <label for="">Agrega Tarea al Histórico: </label>  
          <select class="form-control width-ajust" name="idagregaComite" id="idagregaComite">
            <!--? foreach($devuelveComites as $row){ Agregamo para los q estan regsitrador en comites-->
              <? foreach($devuelveCom as $row){
              
            ?> <option value="<? echo $row->comite?>"><? echo $row->comite?></option>
             <?
              }
            ?>
          </select>
         </div>         
         <div class="boton-subtarea">
           <input class="btn btnGrabafecha" name="grabacomiteTarea" id="grabacomiteTarea" value="Guardar">
           <input type="hidden" id="inpcomiteTarea" name = "inpcomiteTarea" value="">
         </div>
    </div>       
    </div>
    </div>
<!--Termina Modal de Comite-->

<!-- Spinner Bar -->
<div id="cargando" class="container-spinner-bar hidden">
    <div class="container-spinner-bar-content-loading">
        <div class= "spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>       
</div>

<!-- Empieza contenido -->
<div class="contenido" id="ContentSeguimiento">
    <div class="panel_botones col-panel-btn" id="BtnMenuSeguimiento">
        <div class="">
            <div class="actividadesTareas"><!-- muestratareasImportantes -->
                <button class="btn-activity-task btn-task-disabled" title="Desactivado" onclick="openModalMenu(1)">
                    <i class="fas fa-file"></i> Documento Personales
                </button>
                <button class="btn-activity-task" onclick="openModalMenu(2)">
                    <i class="fas fa-check-circle"></i> Histórico Acumulado
                </button>
                <button class="btn-activity-task" onclick="openModalMenu(3)">
                    <i class="fas fa-star"></i> Tareas Importantes
                </button>
                <button class="btn-activity-task" onclick="openModalMenu(4)">
                    <i class="fas fa-calendar-alt"></i> Compromiso
                </button>
                <button class="btn-activity-task" onclick="openModalMenu(5)">
                    <i class="fas fa-stopwatch"></i> Recordatorios
                </button>
                <button class="btn-activity-task btn-task-disabled" title="Desactivado" onclick="openModalMenu(6)">
                    <i class="fas fa-calendar-times"></i> Fechas Compromisos Vencidas
                </button>           
                <!--i class="fas fa-thumbtack icono pospuesta">Muestra Tareas </i-->
                <!--i class="fas fa fa-book icono comite">  Comite</i-->
                <a href="<?=base_url()?>calendario?proyectos=1" target="_blank" class="btn-activity-task">
                    <i class="fas fa-calendar-check"></i> <span class= "letras">Convocar Reunión</span>
                </a>
                <a href="<?=base_url()?>cproyecto/tareasAsignadas" class="btn-activity-task">
                    <i class="fas fa-thumbtack"></i> <span class= "letras">Muestra Tareas</span>
                </a>
            </div>
        </div>
        <div class=""><hr class="segment-hr"></div>
        <div class="">
            <div class = "panel lista-proyectos">        
                <div class="proyectosV3"> 
                    <span>V3 Proyectos</span>
                </div>           
                <div class="detaProyecto">               
                   <input type="text" class="form-control" id='nuevo-proyecto' placeholder="Nuevo Proyecto...">
                </div> 
                  <!--div class="detaProyecto">
                  <label>Fecha
                  <input type="date" id='nuevo-fecha'></label>
                  </div-->
                <div class="detaProyecto"> 
                     <input type="text" class="form-control" id='nuevo-hora' placeholder="Hora de la Reunion...">
                </div>
                <div class="crear-proyecto">              
                   <a href="#" class ="nuevoboton">Agrega Proyecto <i class="fas fa-plus"></i></a>
                </div>
                <div class="crear-proyecto">
                  <a href="#" id="btn_cronograma" class ="nuevoboton">Cronograma <i class="fas fa-calendar"></i></a>
                </div>
                <div class="conte-proyecto" id= "conte-proyecto" style="margin-top: 10px;">
                    <ul id="proyectos" style="padding: 0px;">
                        <?php if($proyectos != FALSE) {
                            foreach($proyectos->result() as $proyecto) { ?> 
                        <li >
                            <div class="listaProyectos" >
                                <a href = "<?=base_url()?>cproyecto/muestraProyectos?idproyecto=<?php echo $proyecto->idproyecto?>" id="<?php echo $proyecto->idproyecto?>">
                                    <i class="fas fa-list-ul"></i> <?php echo $proyecto->nombre?>                    
                                </a>
                                <?  if($proyecto->agregafecha) { ?>
                                <form class="Exportar" id = "<?php echo $proyecto->idproyecto?>" method="post" action="<?=base_url()?>cproyecto/exporExcel/"  >
                                    <i id ="ex<?php echo $proyecto->idproyecto?>"  class="fas fa-file-excel icono" title="Exporta Excel..." style="font-size: 15px;"></i>
                                    <i id ="id<?php echo $proyecto->idproyecto?>"  class="fas fa-calendar-check icono estrella" title="Posfecha Proyectos..." style="font-size: 15px;"></i> 
                                    <input type="hidden" id="idexportar" name = "idexportar" value = "<?php echo $proyecto->idproyecto?>">
                                </form>
                                <?  } else { ?>
                                <form class="Exportar" id = "<?php echo $proyecto->idproyecto?>" method="post" action="<?=base_url()?>cproyecto/exporExcel/"  >
                                    <i id ="ex<?php echo $proyecto->idproyecto?>"  class="fas fa-file-excel icono" title="Exporta Excel..." style="font-size: 15px;"></i>
                                    <i id ="id<?php echo $proyecto->idproyecto?>"  class="fas fa-calendar-check icono" title="Posfecha Proyectos..." style="font-size: 15px;"></i> 
                                    <input type="hidden" id="idexportar" name = "idexportar" value = "<?php echo $proyecto->idproyecto?>">  
                                </form>
                                <form id = "<?php echo $proyecto->idproyecto?>" method="post" action="<?=base_url()?>cproyecto/infoExportTask/">
                                    <i id ="down<?php echo $proyecto->idproyecto?>"  class="fas fa-download icono" name="download-schedule" title="Descargar Cronograma" style="font-size: 15px;"></i>
                                    <input type="hidden" id="id" name="id" value = "<?php echo $proyecto->idproyecto?>">
                                </form>
                                <? } ?>
                            </div>    
                       </li> 
                      <? } } ?> 
                    </ul>
                </div>
            </div>  
        </div>        
    </div>
    <div class="contenidoPrincipal" id="ContainerContent">
               <div class="panel contenedor-app">
                  <div class="contenedor-tareas">
                    <?php if($id_proyecto){ 
                        foreach($proyectosActual->result() as $proyectoAct){?>
                    
                    <div class="col-md-12 col-flex-center-start" style="margin-top: 15px;margin-bottom: 10px;">
                        <div class="col-md-6 width-ajust">
                        <label class="label label-info" style="font-size: large;background-color: #489ab3;display: inline-block;margin: 0px;">Nombre del Proyecto: <?php echo $proyectoAct->nombre?></label></div>
                       <div class="col-md-2 width-ajust"><label style="border: solid 1px;border-bottom-left-radius: 10px;border-top-left-radius: 10px;padding: 4px;font-size: medium;color: white;background: #1999bf;margin: 0px;">Total</label><label id="totalTareasLabel" style="border: solid 1px;border-bottom-right-radius: 10px;border-top-right-radius: 10px;font-size: medium;padding: 4px;color: white;background: #1999bf;margin: 0px;font-weight: 700;"></label></div>
                       <div class="col-md-2 width-ajust"><label style="border: solid 1px;border-bottom-left-radius: 10px;border-top-left-radius: 10px;padding: 4px;font-size: medium;color: white;background: #1999bf;margin: 0px;">Filtrados</label><label id="filtradosTareasLabel" style="border: solid 1px;border-bottom-right-radius: 10px;border-top-right-radius: 10px;font-size: medium;padding: 4px;color: white;background: #1999bf;margin: 0px;font-weight: 700;"></label></div>
                    </div>
                    <div class="col-md-12 col-flex-center-start">
                        <div class="col-md-2 width-ajust"><button class="btn btn-primary-two" onclick="verOcultarInvitados(this)">
                            <i class="fas fa-user-tie"></i> Ver Invitados</button></div>
                        <div class="col-md-2 width-ajust"><button  class="btn btn-primary-two agregaInvitados" onclick="abrirModalProyecto()"><i class="fas fa-user-plus"></i> Agregar Invitados</button> </div>
                    <?if($proyectoAct->usuario==$idPersona){?>
                        <div class="col-md-2 width-ajust">
                       <form method="POST" action="<?=base_url()?>cproyecto/borrarProyecto" ><input  type="hidden" name="idProyecto" value="<?=$proyectoAct->idproyecto?>"><button class="btn btn-danger" onclick="alertaBorrado(event,this)"><i class="fas fa-trash-alt"></i> Eliminar Proyecto</button></form></div>
                     <?}?> 
                     </div> 
                           <div class="col-md-12 ocultarObjetoInvitados" id="containerGuest" style="height: 300px;max-height: 300px;overflow: scroll;margin-top: 15px;"><?= invitadosImprimir($invitados)?></div>

                    <div class = "barra_tareas">
 
                     </div> 
                     <div class="texto_derecha">
                     
                     </div>
                     <div class="col-md-12">
                        <hr class="subtitle-hr">  </div>                                   
                     <?
                      } 
                     }
                     else
                     {?>
                      <div class = "col-md-12 agrega_usuario">
                       <span>Seleccione Proyecto...</span>
                     </div>   
                     <?
                      }
                      ?> 
                    </div>
                  <div class="agrega_Tareas">
                            <div class="tittarea1" style="display: flex;width: 100%">
                              <div class="col-md-3"><input type="textarea" name="" id="tituloTareaInput" class="form-control" placeholder="AGREGUE TITULO DE LA TAREA"></div>
                              <div class="col-md-8 col-flex-start pd-left"><textarea id='nuevo-tarea' name="nuevo-tarea" rows="2" cols="50" class="form-control" placeholder="AGREGUE DESCRIPCION DE LA TAREA" style="margin-right: 5px;"></textarea><span><i class="fas fa-user-plus fa-x icono2" title="AGREGAR TAREAS"></i></span></div>
                            </div>
                            <div class="tittarea">

                                      <div class="col-md-3 col-flex-center-start width-ajust" id="estrellasParaTareas"><label class="text-form">Asignar:</label><select id="selectEstrellasParaTareas" class="form-control" style="margin-right: 5px;"></select><button class="btn btn-primary" style="height: 34px" title="AGREGAR ESTRELLAS" id="agregarEstrellaBTN">&#128190</button></div>       
                                      <div class="col-md-5 col-flex-center-start pd-left"><label class="text-form">Filtrar:</label><select id="filtrosTareas" class="form-control"></select></div>
                              
                                      <div class="col-md-3"><button id="ponerEnProduccionBTN" class="btn btn-primary" title="PONER EN PRODUCCION" style="margin-right: 5px;"><img style="width:35px;min-width:35px;border-radius:20%;min-height:35px;height:34px" src="<?=base_url()?>assets/img/seguimiento/ponerEnProduccion.png"></button><button id="agregarEnHistoricoBTN" class="btn btn-primary" title="PONER EN HISTORICO" style="margin-right: 5px;"><img style="width:35px;min-width:35px;border-radius:20%;min-height:35px;height:34px" src="<?=base_url()?>assets/img/seguimiento/agregarEnHistorico.png"></button><button id="eliminarTareaBTN" class="btn btn-primary" title="ELIMINAR TAREA"><img style="width:35px;min-width:35px;border-radius:20%;min-height:35px;height:34px" src="<?=base_url()?>assets/img/seguimiento/eliminarTarea.png"></button></div>
                            </div>                 
                   </div>
                      <!--16-05-2023 Agregamos spin de espera -->
                      <div id="momento" class= "hidden">
                       <p class="p-loading">Un momento....</p>
                     <div class= "spinner">
                    
                        <div class="rect1"></div>
                          <div class="rect2"></div>
                          <div class="rect3"></div>
                          <div class="rect4"></div>
                          <div class="rect5"></div>
                       </div>                            
                   </div>
          <!--Agregamos spin de espera -->
                <div class = "tareas" id="tareas">
                  <ul id="tareaAgregadas">
                
                  <?php
                  
                  // if($id_proyecto)
                  //  { 
                     $enProduccion=array();
                     $fechaEntrega=array();
                     $responsables=array();
                     $fechaEntrega=array();
                     $fechaCreacion=array();
                     $estrellasCantidad=array();
                     $enPausa = array();
                     $responsablesTareas = "";
                     //var_dump($devuelveTareas->result());
                     foreach($devuelveTareas->result() as $tareasAct){
                        $idTarea=$tareasAct->idtarea;
                        $responsablesString='';
                        //----------------------------
                        $timeTaskEmployee = "";
                        $label = "Tiempo Tarea Terminada por Asignación";
                      foreach ($tareasAct->responsables as $respon) 
                      {
                            //$responTarea =$responTarea.'--'.$respon->correo;
                            $responsablesTareas.='<div class="container-img-user"><img src="'.base_url().'assets/img/miInfo/userPhotos/'.$respon->fotoUser.'" title="NOMBRE:'.$respon->nombre.' EMAIL:'.$respon->correo.'"></div>';
                            $responsablesString.=$respon->correo.';';
                            array_push($responsables, '"'.$respon->correo.'"');

                            //-- Modificado [Suemy][2024-04-05]
                            $timeTask = "";
                            if (!empty($respon->registro)) {
                                $timeTask = getTimeElapsed($respon->registro,$tareasAct->fechaCompletada,2);
                                if (empty($tareasAct->fechaCompletada)) {
                                    $label = "Tiempo Tarea Transcurrida por Asignación";
                                }
                            }
                            $timeTaskEmployee .= '<p class="textLabel"><strong>'.$respon->nombre.':</strong> '.$timeTask.'</p>';
                            //-------------------------
                      }
                            $statusTarea='SIN RESPONSABLES';     
                        if($responsablesString==''){$responsablesString="SIN RESPONSABLE";/*array_push($responsables, '"SIN RESPONSABLE"');*/}     
                        else{$statusTarea='CON RESPONSABLES';}     
                        $fecha_entrega=explode('-', $tareasAct->fechaentrega);
                        $fecha_creacion=explode('-', $tareasAct->fechaCreacion);

                        $fechaEnt='';
                        $fechaCrea='';
                        if(count($fecha_entrega)>1){$fechaEnt=$fecha_entrega[2].'/'.$fecha_entrega[1].'/'.$fecha_entrega[0];}
                        if(count($fecha_creacion)>1){$fechaCrea=(explode(' ',$fecha_creacion[2])[0]).'/'.$fecha_creacion[1].'/'.$fecha_creacion[0];}
                      array_push($fechaCreacion,'"'.$fechaCrea.'"');
                      array_push($fechaEntrega,'"'.$fechaEnt.'"' );
                      array_push($estrellasCantidad,$tareasAct->cantidadEstrellas);
                      

                      if($tareasAct->completado==1){$statusTarea='COMPLETO';}
                      if($tareasAct->estaProduccion==1){$statusTarea='PRODUCCION';array_push($enProduccion, $idTarea);}
                      if($tareasAct->pausado==1){$statusTarea='PAUSADO';array_push($enPausa, $idTarea);}

                        //Título
                        $title = "Sin título";
                        if ($tareasAct->tituloTarea != "0") { $title = $tareasAct->tituloTarea; }
                        //Pausar Actividad
                        $pause = $tareasAct->pausado;
                        $statusPause = "";
                        if ($tareasAct->completado == 1 || $tareasAct->estaProduccion == 1 || $tareasAct->terminado == 1) { $statusPause = "ocultarObj"; }
                        //Fecha Información Adicional
                        $dateTaskComplete = !empty($tareasAct->fechaCompletada) ? date('d/m/Y',strtotime($tareasAct->fechaCompletada)) : "";
                        $dateTaskProduction = !empty($tareasAct->fechaEnProduccion) ? date('d/m/Y',strtotime($tareasAct->fechaEnProduccion)) : "";
                        //Obtener tiempo por dia, con hora y minutos
                        //getTimeElapsed
                        $timeComplete = getTimeElapsed($tareasAct->fechaCompletada,"",1);
                        $timeProduction = getTimeElapsed($tareasAct->fechaEnProduccion,"",1);
                        $durationTask = !empty($tareasAct->fechaCompletada) ? getTimeElapsed($tareasAct->fechaCreacion,$tareasAct->fechaCompletada,0) : "";
                        $durationProduction = !empty($tareasAct->fechaEnProduccion) ? getTimeElapsed($tareasAct->fechaCompletada,$tareasAct->fechaEnProduccion,0) : "";
                        $durationActivity = !empty($tareasAct->fechaEnProduccion) ? getTimeElapsed($tareasAct->fechaCreacion,$tareasAct->fechaEnProduccion,0) : "";
                      ?>
                      <div class="divTarea" data-statustarea="<?=$statusTarea;?>" data-responsables="<?=$responsablesString?>" data-estrellas="<?=$tareasAct->cantidadEstrellas?>" data-fechaentrega="<?=$fechaEnt?>">
                      <!-- STPS -->
                    <div  id="<?= $idTarea?>DivRespon" class="responDivCabTareas container-badge" data-responsables="<?=$responsablesString?>" data-fechaentrega="<?=$fechaEnt?>" data-estrellas="<?=$tareasAct->cantidadEstrellas?>" data-fechacreacion="<?=$fechaCrea?>" data-statustarea="<?=$statusTarea;?>">
                        <div class="col-md-3 col-flex-center-start" data-tipo="responsables" id="<?= $idTarea?>DivFotosRespon"><?=$responsablesTareas;?></div>
                        <div class="col-md-1 pd-left pd-right col-flex-center-center">
                            <span class="estrellasSpan">
                                <label class="estrellasLabel" id="estrellasLabel<?=$idTarea?>" data-estrellas="<?=$tareasAct->cantidadEstrellas?>"><?=$tareasAct->cantidadEstrellas?>&#11088</label>
                            </span>
                        </div>
                        <div class="col-md-2 pd-left pd-right col-grid-center-start" data-tipo="fechacreacion" id="<?= $idTarea?>DivFechaCreacion" style="min-width: 160px;">
                            <div class="col-flex-center-start">
                                <label class="l textLabel mg-right">Fecha Creación:</label>
                                <label class="textLabel" id="<?=$idTarea?>FechaCreacionLabel" class="">
                                    <strong><?=$fechaCrea;?></strong>
                                </label>
                            </div>
                            <div class="col-flex-center-start">
                                <label class="l textLabel mg-right">Fecha Entrega:</label>
                                <label class="textLabel" id="<?=$idTarea?>FechaEntregaLabel">
                                    <strong><?=$fechaEnt;?></strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 pd-left pd-right col-grid-center-start" data-tipo="fecha" id="<?= $idTarea?>DivFechaEntrega" >
                            <div class="col-flex-center-start">
                                <label class="l textLabel mg-right">Completada:</label>
                                <label class="textLabel" id="<?=$idTarea?>FechaCompletadaLabel">
                                    <strong><?=$timeComplete;?></strong>
                                </label>
                            </div>
                            <div class="col-flex-center-start">
                                <label class="l textLabel mg-right">En producción:</label>
                                <label class="textLabel" id="<?=$idTarea?>FechaProduccionLabel">
                                    <strong><?=$timeProduction;?></strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-1 pd-left pd-right col-flex-center-center" data-tipo="produccion"  id="<?= $idTarea?>DivProduccion" ></div>
                        <div class="col-md-1 pd-left pd-right col-flex-center-center" id='V<?php echo $tareasAct->idtarea?>'>
                            <button class="btn-option-proyect open-details" href="#seg<?=$idTarea?>" data-toggle="collapse" aria-expanded="true" onclick="openContainer(this)" style="margin-right: 5px;">
                                <i class="fas fa-plus" data-class="fas fa-plus" title="Ver"></i>
                            </button>
                            <span>
                            <div class="dropdown">
                                <button class="btn-option-proyect" type="button" id="dp<?=$idTarea?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropTarea" aria-labelledby="dp<?=$idTarea?>" style="height: 250px;overflow: auto;">
                                    <li id="pausar-tarea">                                        
                                        <button class="dropdown-item <?=$statusPause?>" id="statusTask<?=$idTarea?>" data-title="<?=$title?>" data-status="<?=$pause?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')">
                                            <i class="fas fa-pause fa-x icono" title="Pausar Tarea"></i>Pausar Tarea
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider <?=$statusPause?>" id="divider<?=$idTarea?>"></li>
                                    <li id="agrega-Usario">                                        
                                        <button class="dropdown-item">
                                            <i class="fas fa-user-plus fa-x icono" title="Agrega Usuarios"></i>Agregar Responsable
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                      <button class="dropdown-item" onclick="mostrarViewAgregarEvaluador(<?= $tareasAct->idtarea ?>)">
                                        <i class="fas fa-users fa-x icono" title="Agrega Evaluadores"></i>Agregar Evaluador
                                      </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li id="agendaTareas">
                                        <button class="dropdown-item">
                                            <i class="far fa-calendar-alt icono" title="Agenda Tareas"></i> Agendar Fecha por Compromiso
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li id="importanteTareas">
                                        <button class="dropdown-item">
                                            <i class="far fa-star icono" title="Tareas Importantes"></i> Importante
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li id="completados">
                                        <button class="dropdown-item">
                                            <i class="far fa-check-circle icono" title="Tareas Completadas"></i> Completada
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li id="opcionComentarios">
                                        <button class="dropdown-item" data-title="<?=$title?>" onclick="abrirModalComentario(this,<?php echo $tareasAct->idtarea?>)">
                                            <i class="far fa-comment icono" title="Agregar Comentarios"></i> Comentarios
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li id="opcionDocumentos">
                                        <button class="dropdown-item" data-title="<?=$title?>" onclick="abrirModalSubirArchivos(this,<?php echo $tareasAct->idtarea?>)">
                                            <i class="fas fa-file icono" title="Agregar Documentos"></i> Documentos
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                      <button class="dropdown-item" onclick="mostrarViewArchivosIncidencia(<?= $tareasAct->idtarea ?>)">
                                        <i class="fas fa-file-text fa-x icono" title="Archivos Incidencia"></i>Archivos Incidencia
                                      </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li id="alertaTareas">
                                        <button class="dropdown-item">
                                            <i class="fas fa-stopwatch icono" title="Alerta de Tareas"></i> Alerta por Recordatorio
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li id="comite"> <!-- idmenu.includes("comite") -->
                                        <button class="dropdown-item">
                                            <i class="fas fa-copyright icono" title="comite"></i> Guardar Historico
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li id="elimina-Tareas">
                                        <button class="dropdown-item">
                                            <i class="fas fa-trash-alt icono"title="Eliimina Tareas"></i> Eliminar
                                        </button>
                                    </li>
                                </ul>
                            </div></span>
                        </div>
                        <span class="badge badge-title-proyect"><?=$title?></span>
                    </div>
                    <div class="container-info-task collapse" id="seg<?=$idTarea?>" style="margin: 0px">
                        <div class="col-flex-center-start">
                            <div class="col-md-3 column-grid-center-start pd-left width-ajust">
                                <div class="col-flex-center-start">
                                    <label class="textLabel mg-right">Fecha Tarea Completada:</label>
                                    <label class="textLabel">
                                        <strong><?=$dateTaskComplete;?></strong>
                                    </label>
                                </div>
                                <div class="col-flex-center-start">
                                    <label class="l textLabel mg-right">Fecha Producción:</label>
                                    <label class="textLabel">
                                        <strong><?=$dateTaskProduction;?></strong>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 column-grid-center-start brd-left-p">
                                <div class="col-flex-center-center"><label class="textLabel mg-right"><?=$label?></label></div>
                                <div class="col-flex-grid-start"><?=$timeTaskEmployee?></div>
                            </div>
                            <div class="col-md-6 column-grid-center-start brd-left-p pd-right width-ajust">
                                <div class="col-flex-center-start">
                                    <label class="textLabel mg-right" title="(Desde la creación hasta completar)">
                                        Tiempo Tarea Completada:
                                    </label>
                                    <label class="textLabel">
                                        <strong><?=$durationTask;?></strong>
                                    </label>
                                </div>
                                <div class="col-flex-center-start">
                                    <label class="textLabel mg-right" title="(Desde completar hasta la producción)">
                                        Tiempo para Producción:
                                    </label>
                                    <label class="textLabel">
                                        <strong><?=$durationProduction;?></strong>
                                    </label>
                                </div>
                                <!-- <div class="col-flex-center-start">
                                    <label class="l textLabel mg-right">Tiempo Total de Actividad<br>(Desde la creación hasta la producción):</label>
                                    <label class="textLabel">
                                        <strong><?=$durationActivity;?></strong>
                                    </label>
                                </div> -->
                            </div>
                        </div>
                        <!-- <div class="col-flex-center-start">
                            <div class="col-md-12">
                                <hr class="indicador-hr">
                            </div>
                        </div>
                        <div class="col-grid-center">
                            <label class="textLabel mg-right">Tarea Pausada</label>
                            <div class="col-flex-center-start">
                                
                            </div>
                        </div> -->
                    </div>
                    <?
                      (isset($tareasAct->fechaentrega))? $pintar =   "far fa-calendar-alt  cafe" : $pintar =   "";                      
                      ($tareasAct->completado == 1)? $terminado = "far fa-check-circle icono terminado" : $terminado = "";                      
                      ($tareasAct->estrella == 1)? $estrella ="far fa-star estrella" : $estrella ="";                      
                      ($tareasAct->alerta == 1)? $alerta ="fas fa-clock icono" : $alerta ="";
                      
                      $tieneArchivo='';

                      ($tareasAct->pausado == 1)? $iconClock ="fas fa-stopwatch" : $iconClock = "";
                      
                      if($tareasAct->tieneArchivo=='1'){$tieneArchivo='fas fa-file';}
                      $tieneComentario='';
                      //$responsables='<label data-responsables="">';
                      $classUsuario=''; $responTarea= ""; $responTarea= "-".$tareasAct->ftarea; $responsablesTareas='';   

                     
                      if($tareasAct->tieneComentario=='1'){$tieneComentario='far fa-comment';}
                      $usuarios ="fas fa-user-plus fa-x icono";
                      $basura ="fas fa-trash-alt icono" ;                     
                       if($tareasAct->completado == 0)
                       {
                        if($tareasAct->estrella == 0)// if($tareasAct->idaccion == 0)
                        { 
                         ?>

                         <div class="sub" <?=$classUsuario;?> id="<?=$idTarea?>DivSub">
                         <li id= "<?php echo $tareasAct->idtarea ?>"><i class="fas fa-angle-double-down icono" ></i><p data-parraforesponsable onclick="traerComentarios_Archivos('',this)"> <?php echo $tareasAct->nombre ?> <label style="width: 70%;height:30px;overflow:auto;z-index: 10 "></label>  </p><div class="icono-tarea">  <i class="<?echo $terminado?>" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i> <i class="<?echo $estrella?>" title="Tareas Importantes"></i><i class="<?echo $pintar?>"  title="Entrega de Tareas"></i><i class="<?echo $alerta?>" title="Alerta de Tareas"></i><i class="fas fa-tasks icono"  title="Agrega SubTareas"></i> <!-- <i class="fas fa-align-justify icono"></i> --><i class="<?echo($tieneComentario)?>" title="Agregar Comentario" data-title="<?=$title?>" onclick="abrirModalComentario(this)"></i>
           <i class="<?echo($tieneArchivo)?>" title="Agregar Documento" data-title="<?=$title?>" onclick="abrirModalSubirArchivos(this)"></i>
                    </div> </li>                  
                          
                            <div class = "subtareas ocultar" id="subtareas<?php echo $tareasAct->idtarea?>" >
                            <ul id="subtareaAgregadas<?php echo $tareasAct->idtarea ?>">
                           <? 
                           foreach($devuelvesubTareas->result() as $subtareas)
                           {
                            if(isset($subtareas->agregafecha)) 
                            {                             
                              if($subtareas->agregafecha ==1) {$subpintar =   "far fa-calendar-check cafe";}
                              else{$subpintar =   "far fa-calendar-check icono";}
                            }  
                            else{$subpintar =   "far fa-calendar-check icono";}

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
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                    </div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>"title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                    </div></li>                   
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
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i class="<?echo $subpintar?>"title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                        </div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                </div></li>                   
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
                          <?php
                            if(!empty($tareasAct->evaluadores)){
                              echo '<div class="responDivCabTareas container-badge" style="margin-top: 0; background-color: darkseagreen; border-radius: 5px;">';
                              foreach ($tareasAct->evaluadores as $evaluador){
                                echo '<div class="container-img-user"><img src="'.base_url().'assets/img/miInfo/userPhotos/'.$evaluador->fotoUser.'" title="NOMBRE:'.$evaluador->nombre_persona.' EMAIL:'.$evaluador->email_persona.'"></div>';
                              }
                              echo '</div>';
                            }
                          ?>
                           <?
                        }
                        if($tareasAct->estrella == 1)// if($tareasAct->idaccion == 1)
                        {
                          ?>
                          <div class="sub" id="<?=$idTarea?>DivSub">
                         <li id= "<?php echo $tareasAct->idtarea ?>"><i class="fas fa-angle-double-down subicono"></i><p> <?php echo $tareasAct->nombre ?> </p> <div class="icono-tarea"><i class="<?echo $terminado?>"  title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="<?echo $estrella?>" title="Tareas Importantes"></i><i class="<?echo $pintar?>" title="Entrega de Tareas"></i><i class="<?echo $alerta?>"  title="Alerta de Tareas"></i><i class="fas fa-tasks icono"  title="Agrega SubTareas"></i><!-- <i class="fas fa-align-justify icono"></i> --><i class="<?echo($tieneComentario)?>" title="Agregar Comentario" data-title="<?=$title?>" onclick="abrirModalComentario(this)"></i>
           <i class="<?echo($tieneArchivo)?>" title="Agregar Documento" data-title="<?=$title?>" onclick="abrirModalSubirArchivos(this)"></i></div></li>                   
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
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                </div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>"title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas">
                                </i></div></li>                   
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
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                </div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas">
                                </i></div></li>                   
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
                         // var_dump( $tareasAct->nombre);
                         ?>
                         
                          <div class="sub" id="<?=$idTarea?>DivSub">
                         <li id= "<?php echo $tareasAct->idtarea ?>"><i class="fas fa-angle-double-down subicono"></i><p><?php echo $tareasAct->nombre ?> </p> <div class="icono-tarea">  <i class="<?echo $terminado?>" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i> <i class="<?echo $estrella?>" title="Tareas Importantes"></i><i class="<?echo $pintar?>" title="Entrega de Tareas"></i><i class="<?echo $alerta?>"  title="Alerta de Tareas"></i><i class="fas fa-tasks icono"  title="Agrega SubTareas"></i><!-- <i class="fas fa-align-justify icono"></i> --><i class="<?echo($tieneComentario)?>" title="Agregar Comentario" data-title="<?=$title?>" onclick="abrirModalComentario(this)"></i>
                          <i class="<?echo($tieneArchivo)?>" title="Agregar Documento" data-title="<?=$title?>" onclick="abrirModalSubirArchivos(this)"></i></div></li>                   
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
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                </div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas">
                                </i></div></li>                   
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
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                </div></li>                   
                                   <?
                                  }
                                  else{
                                    ?>   
                                   <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun estrella icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                </div></li>                   
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
                          <div class="sub" id="<?=$idTarea?>DivSub">
                         <li id= "<?php echo $tareasAct->idtarea ?>"><i class="fas fa-angle-double-down subicono"></i><p> <?php echo $tareasAct->nombre ?> </p> <div class="icono-tarea"> <i class="<?echo $terminado?>" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i> <i class="<?echo $estrella?>"title="Tareas Importantes"></i><i class="<?echo $pintar?>" title="Entrega de Tareas"></i><i class="<?echo $alerta?>"  title="Alerta de Tareas"></i><i class="fas fa-tasks icono"  title="Agrega SubTareas"></i><!-- <i class="fas fa-align-justify icono"></i> --><i class="<?echo($tieneComentario)?>" title="Agregar Comentario" data-title="<?=$title?>" onclick="abrirModalComentario(this)"></i>
           <i class="<?echo($tieneArchivo)?>" title="Agregar Documento" data-title="<?=$title?>" onclick="abrirModalSubirArchivos(this)"></i></div></li>                   
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
                                <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                            </div></li>                   
                                <?
                               }
                              }
                              //subtarea acompletada 
                              if($subtareas->completado == 1)
                               { 
                               if($tareasAct->idtarea == $subtareas->idtarea)
                                {
                                 ?>   
                                 <li id= "<?php echo $subtareas->idsubtarea ?>"><p> <?php echo $subtareas->nombre ?> </p> <div class="icono-tarea"> <i class="fas fa-user-check fa-x icono"  title="Agrega Usuarios"></i> <i class="far fa-check-square terminado icono" title="Tareas Completadas"></i> <i class="<?echo $iconClock?>" title="Tarea Pausada" id="iconStatusTask<?=$idTarea?>" data-status="<?=$pause?>" data-title="<?=$title?>" onclick="abrirModalPausar(this,'<?=$idTarea?>')"></i>  <i class="fas fa-trash icono"title="Elimina Tareas"></i><i class="far fa-sun icono"title="Tareas Importantes"></i><i  class="<?echo $subpintar?>" title="Entrega de Tareas"></i><i class="far fa-clock icono" title="Alerta de Tareas"></i>
                                </div></li>                   
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
                       </div><!-- Fin divTarea -->
                        <?
                     // }
                     
                    }                    
                   ?>
                   
                </ul>
            </div>
                <div class="panel avance">
                    <spam class="mg-right"><b>Avance:</b></spam>
                    <div class="barra-avance" id="barra-avance">
                       <div class="porcentaje" id="porcentaje"></div>
                    </div>
                </div>
        </div>        
    </div>
</div>
<!-- Fin del contenido -->

<!-- STPS -->
<div class="modal fade" id="ModalComentarios" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleModalComment"></h4>
            </div>
            <div class="modal-body" style="background: #fcfcfc;">
                <input type="hidden" id="idSeguimiento">
                <input type="hidden" id="textTipoComentarioPN">
                <label id="labelNombrePersonaComentario"></label>
                <div class="col-md-12 col-flex-center-start pd-items-table">
                    <input type="text" name="" id="comentarioParaSeguimiento" class="form-control mg-right" placeholder="Agregar Comentario" style="width: 85%;">
                    <button class="btn btn-success" onclick="grabaComentarioSeguimiento('')">Guardar</button>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12 pd-left pd-right" style="height: 160px;overflow: auto;border: 1px solid #ddd;">
                        <table class="table table-striped"><thead class="table-thead"><tr class="table-tr"><td>Comentario</td><td>Fecha</td><td>Eliminar</td></tr></thead><tbody id="tablaBodyContieneComentarios"></tbody></table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalSubirArchivos" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleModalDocument"></h4><!-- fas fa-file -->
            </div>
            <div class="modal-body" style="background: #fcfcfc;">
                <label id="labelNombrePersonaArchivo"></label>
                <div class="col-md-12 col-flex-center-start pd-items-table">
                    <form id="formArchivoSeguimiento">
                        <input type="file" id="subirArchivoAgenteNuevo" name="Archivo" style="" onchange="agregaArchivoSeguimiento('',this);">
                        <input type="hidden" name="idSeguimientoDocumento" id="idSeguimientoDocumento">
                    </form>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12 pd-left pd-right" style="height: 160px;overflow: auto;border: 1px solid #ddd;">
                        <table class="table table-striped"><thead class="table-thead"><tr class="table-tr"><td>Documento</td><td>Eliminar</td></tr></thead><tbody id="tablaBodyContieneDocumentos"></tbody></table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalSeguimientoTarea" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Seguimiento</h4>
            </div>
            <div class="modal-body" style="background: #fcfcfc;">
                <div class="col-md-12">
                    <div class="col-md-12 pd-left pd-right" style="height: 350px;overflow: auto;border: 1px solid #ddd;">
                        <table class="table table-striped"><thead class="table-thead"><tr class="table-tr"><td>Etiqueta</td><td>Descripción</td><td>Fecha</td></tr></thead><tbody id="bodyTableStatus"></tbody></table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAgregarInvitados" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;"> <!-- agrega-usario -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleModalGuest"></h4>
            </div>
            <div class="modal-body" style="background: #fcfcfc;">
                <div class="col-md-2 aside-modal-izquierda">
                    <div class="col-md-12 col-grid-center pd-left pd-right">
                        <?=imprimirBotonera($clasificacionUsuarios)?>
                    </div>
                </div>
                <div class = "col-md-10 contenedor-titProyecto">
                    <div class ="titProyecto">
                        <?php if($id_proyecto) { 
                            foreach($proyectosActual->result() as $proyectoAct){ ?>
                        <h2 id = "tituloProyecto" class="mg-top-cero">Compartir Proyecto: <?php echo $proyectoAct->nombre ?></h2>
                        <input type="hidden" id="nombreProyecto" name = "nombreProyecto" value="<?php echo $proyectoAct->nombre?>">
                        <input type="hidden" id="fechaProyecto" name = "fechaProyecto" value="<?php echo $proyectoAct->fecha?>">
                        <input type="hidden" id="horaProyecto" name = "horaProyecto" value="<?php echo $proyectoAct->hora?>">      
                        <?  } } else{ } ?>     
                    </div> 
                    <!--Buscamos Cliente en la tabla-->
                    <div class="col-md-12 pd-left pd-right">
                        <div class="col-md-12 pd-left pd-right ocultarObjeto" id="divBuscarCliente">
                            <input type="text" id="buscador" class="buscador sombra" placeholder="Buscar Invitados..."></button>
                        </div> 
                        <div class="col-md-12 pd-left pd-right contenedor-tabla">
                            <table id="listado-contactos" class="listado-contactos table tble-striped" style="margin:0px;">                  
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Clasificacion</th>
                                        <th>Agregar</th> 
                                    </tr>
                                </thead>
                                <tbody id="tabla-contactos" class= "tabla-contactos"></tbody>
                            </table>
                        </div>
                    </div>
                    <!--Agregamos Titulo para Agrega Invitado al Proyecto-->
                    <div class="col-md-12 pd-left pd-right" style="margin-top: 80px;">
                        <div class="invitadoProyecto invitadoExterno">
                            <h2 class="mg-top-cero pd-items-table">Invitados Agregados</h2> 
                            <label class="textLabel col-flex-center-center">
                                <span class="mg-right" style="text-wrap: nowrap;">Agrega Inivitado:</span>
                                <input type="text" class="form-control mg-right UpperCase" id="invitadoExterno" name="invitadoExterno" placeholder="ejemplo@dominio.com"  autocomplete="off" >
                                <i class="fas fa-user-plus fa-x icono2"></i>
                            </label>
                        </div>
                    </div>
                    <div class="listaInvitado">
                        <ul id="ullistaInvitado"></ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAgregarResponsable" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;"> <!-- agrega-usario -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleModalGuest">Asignar Responsable</h4>
            </div>
            <div class="modal-body" style="background: #fcfcfc;">
                <div class="col-md-2 aside-modal-izquierda">
                    <div class="col-md-12 col-grid-center pd-left pd-right">
                        <?=imprimirBotonera2($clasificacionUsuarios)?>
                    </div>
                </div>
                <div class = "col-md-10 contenedor-titProyecto">
                    <div class ="">
                        <h2 id = "titulo-Tarea" class="mg-top-cero" style="font: message-box;"></h2>   
                    </div> 
                    <!--Buscamos Empleado en la tabla-->
                    <div class="col-md-12 pd-left pd-right">
                        <div class="col-md-12 col-flex-end pd-left pd-right ocultarObjeto" id="divBuscarEmpleado">
                            <input type="text" id="buscadorEmpleado" class="buscador sombra mg-right" placeholder="Buscar Empleado..."></button>
                            <div style="display: flex">
                                <button class="btn btn-primary" onclick="verInvitadosAgregados()">Invitados<span id="invitatosTotalSup" style="margin-left: 10px;color: black;background-color: white;padding: 4px;border-radius: 50%">0</span></button>
                            </div>
                        </div> 
                        <div class="col-md-12 pd-left pd-right contenedor-tabla">
                            <table id="listado-empleados" class="listado-contactos table tble-striped" style="margin:0px;">                  
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Clasificacion</th>
                                        <th>Agregar</th> 
                                    </tr>
                                </thead>
                                <tbody id="tabla-empleados" class= "tabla-contactos"></tbody>
                            </table>
                        </div>
                    </div>
                    <!--Agregamos Titulo para Agrega Invitado al Proyecto-->
                    <div class="col-md-12 pd-left pd-right" style="margin-top: 80px;">
                        <div class="tareaExterno invitadoProyecto">
                            <h2 class="mg-top-cero pd-items-table">Responsables Agregados</h2> 
                            <label class="textLabel col-flex-center-center">
                                <span class="mg-right" style="text-wrap: nowrap;">Agregar:</span>
                                <input type="text" class="form-control mg-right UpperCase" id="tareaExterno" name="tareaExterno" placeholder="ejemplo@dominio.com"  autocomplete="off" >
                                <i class="fas fa-user-plus fa-x icono2"></i>
                            </label>
                        </div>
                    </div>
                    <div class="listaInvitado">
                        <ul id="ullistaEmpleados"></ul>
                    </div>
                </div>
                <input type="hidden" id="nombreTarea" name = "nombreTarea" >
                <input type="hidden" id="idTarea" name = "idTarea" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modalsubTareas fade" id='ModalPausarTarea'>      
    <div class="bodymodal">   
        <div class="contenedor-subtareas">
            <div class="btncierra">
                <button class ="btn btn-wine cierra-modalmuestraTareaimp" data-dismiss="modal"><i class="fas fa-times"></i></button>             
            </div>
            <hr>
            <h2 align="center" style="font-size: 2rem;font-weight: 600;">Pausar Actividad</h2>
            <h3 align="center" id="titleModalPause" title="Titulo Tarea" style="margin: 0px 0px 15px;"></h3>
            <div class="col-flex-center-center" style="padding: 0px 15px 15px;">
                <div class="alert alert-primary" role="alert" style="margin: 0px;">
                    <p class="p-list-alert"><i class="fas fa-info-circle"></i> Cambia el estatus de la tarea entre <strong>pausar</strong> o <strong>reanudar</strong> para detener el cronómetro de elaboración.</p>
                </div>
            </div>
            <div class="col-grid-center container-time-pause ocultarObj" id="segTimePause">
                <h5 style="color: black;"><strong id="timePause"></strong></h5>
                <h5 class="mg-top-cero" style="color: black;"><strong id="datePause"></strong></h5>
                <h5 class="mg-top-cero" style="color: black;"><strong id="casePause"></strong></h5>
            </div>
            <div class="col-flex-center-center" style="padding: 25px;">
                <input type="hidden" id="idTareaEstatus">
                <select class="form-control width-ajust mg-right" id="tareaEstatus">
                    <option value="Pausar">Pausar</option>
                    <option value="Reanudar">Reanudar</option>
                </select>
                <textarea id="motivoEstatus" class="form-control mg-right" placeholder="Agregar Motivo" style="width: 75%;height: 34px;"></textarea>
                <button class="btn btn-primary-two" onclick="pauseTask()">Guardar</button>
            </div>
        </div>       
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url();?>css/sweetalert2.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/docsearch.js/2/docsearch.min.js"></script>
<script type="text/javascript">
    let invitadosVarGlobal='';
 function peticionAJAX(controlador,parametros,funcion){
  

  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";  
    var url=direccionAJAX+controlador;
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
         console.log(respuesta);
         window[funcion](respuesta);                                                          
      }     
   }
  };
 req.send(parametros);
}

function enviarArchivoAJAX(formulario,funcion,funcionJS){ 

       
      var Data = new FormData(document.getElementById(formulario));  
    if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
    else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}  
    var direccion= <?php echo('"'.base_url().'cproyecto/"');?>+funcion;
    Req.open("POST",direccion, true);     
    Req.onload = function(Event) {    
    var respuesta = JSON.parse(Req.responseText);   
    if (Req.status == 200 && Req.readyState == 4) 
    {     
                       
     window[funcionJS](respuesta);
    } 

  };   
  Req.send(Data);


}

function eliminarArchivo(datos,archivo)
{
  if(datos=="")
  {      
      let params='';
      let param=new Object();      
      params=params+'idSeguimiento='+document.getElementById('idSeguimientoDocumento').value;      
      params=params+'&nombreArchivo='+`${archivo}`;
      controlador="cproyecto/eliminarArchivo/?";
      peticionAJAX(controlador,params,'eliminarArchivo');    

  }
  else
  {
   bodyArchivosSeguimiento(datos);
  }
}



function bodyArchivosSeguimiento(datos)
{
   let cant=datos.archivos.length;
   let row='';
   for(let i=0;i<cant;i++)
   {
    row=row+'<tr><td>'+datos.archivos[i].url+'</td><td><button class="btn btn-danger" onclick="eliminarArchivo(\'\',\''+datos.archivos[i].nombreArchivo+'\')"><i class="fas fa-trash-alt"></i></button></td></tr>';
   }
   document.getElementById('tablaBodyContieneDocumentos').innerHTML=row;
}



function agregaArchivoSeguimiento(datos)
{
  if(datos=='')
  {
    
            enviarArchivoAJAX('formArchivoSeguimiento','subirArchivoSeguimiento','agregaArchivoSeguimiento');
    
  }
  else
    {
      bodyArchivosSeguimiento(datos); 
    }
}

 function abrirModalSubirArchivos(objeto,id=''){
    
    let cant=document.getElementsByClassName('verHijoModal').length;    
    if(cant==0)
     { 
      
      document.getElementById('idSeguimientoDocumento').value=objeto.parentNode.parentNode.getAttribute('id');
      if(id!='')
        {
            document.getElementById('idSeguimientoDocumento').value=id;
                    var idventana = document.getElementById('V'+id);
                    idventana.classList.add('ocultar');
        }
     /*document.getElementById('divModalGenericoSubirDocumentos').classList.toggle('ocultarHijoModal');
     document.getElementById('divModalGenericoSubirDocumentos').classList.toggle('verHijoModal'); */  
               let params='';
      params=params+'idSeguimiento='+document.getElementById('idSeguimientoDocumento').value;
      controlador="cproyecto/devolverArchivosSeguimiento/?";
      peticionAJAX(controlador,params,'bodyArchivosSeguimiento');
        const title = $(objeto).data('title');
        $('#titleModalDocument').html('Archivos (<span style="font-size:16px;">'+title+'</span>)');
        $("#ModalSubirArchivos").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });  

     }
     else{alert('Ya tiene abierto un modal');}      

}



 function modficarComentarioSeguimiento(datos,id)
{
 if(datos=='')
 {
   let params='';
   params=params+'&idTareasComentario='+id;   
   params=params+'&idSeguimiento='+document.getElementById('idSeguimiento').value;    
   params=params+'&delete=1';

   controlador="cproyecto/grabaComentarioSeguimiento/?";
   peticionAJAX(controlador,params,'modficarComentarioSeguimiento');    
 }
 else{bodyComentariosSeguimiento(datos); }
}

    function grabaComentarioSeguimiento(datos)
  { 
   if(datos=='')
   {
    let params='';
   params=params+'comentario='+document.getElementById('comentarioParaSeguimiento').value;
   params=params+'&idSeguimiento='+document.getElementById('idSeguimiento').value;   
   controlador="cproyecto/grabaComentarioSeguimiento/?";

      peticionAJAX(controlador,params,'grabaComentarioSeguimiento');    
    }
    else{ 
        location.reload();
    }
  }

function abrirModalComentario(objeto,id='')
{  
  let params='';
    document.getElementById('comentarioParaSeguimiento').value='';
   document.getElementById('idSeguimiento').value=objeto.parentNode.parentNode.getAttribute('id');   
   if(id!='')
{document.getElementById('idSeguimiento').value=id   
          var idventana = document.getElementById('V'+id);
                    idventana.classList.add('ocultar');
}
   params=params+'&idSeguimiento='+document.getElementById('idSeguimiento').value;   
   controlador="cproyecto/grabaComentarioSeguimiento/?";
   peticionAJAX(controlador,params,'bodyComentariosSeguimiento');    
  //document.getElementById('divModalGenericoComentarios').classList.toggle('ocultarHijoModal');
  //document.getElementById('divModalGenericoComentarios').classList.toggle('verHijoModal');
    const title = $(objeto).data('title');
    $('#titleModalComment').html('Documentos (<span style="font-size:16px;">'+title+'</span>)');
    $("#ModalComentarios").modal({
        show: true,
        keyboard: false,
        backdrop: false,
    });


  return 0;
}


function bodyComentariosSeguimiento(datos)
{
      let cant=datos.comentarios.length;
      let row=""; 
      for(let i=0;i<cant;i++)
      {let idComentario=datos.comentarios[i].idTareasComentario;
        row=row+'<tr><td contenteditable="true" id="ComentarioTD'+idComentario+'">'+datos.comentarios[i].comentario+'<br>Usuario:'+datos.comentarios[i].email+'</td><td>'+datos.comentarios[i].fechaInsercion+'</td>';
        row=row+'<td><button class="btn btn-danger" onclick="modficarComentarioSeguimiento(\'\','+idComentario+',1)"><i class="fas fa-trash-alt"></i></button></td></tr>';

      }
      document.getElementById('tablaBodyContieneComentarios').innerHTML=row;
      return 0;
}
 



function traerComentarios_Archivos(datos='',objeto)
{  
  if(datos=='')
  {
  let params='';    
    document.getElementById('idSeguimiento').value=objeto.parentNode.getAttribute('id');
    params=params+'&idSeguimiento='+document.getElementById('idSeguimiento').value;   
   controlador="cproyecto/grabaComentarioSeguimiento/?";
   peticionAJAX(controlador,params,'traerComentarios_Archivos');
   controlador="cproyecto/devolverArchivosSeguimiento/?";
   peticionAJAX(controlador,params,'traerComentarios_Archivos');      
   }
   else
   {
    if(datos.archivos)
    {
         let cant=datos.archivos.length;
         let row='<tr><td colspan="2"><h2 style="text-align:center;"><span class="label label-info">ZONA DE ARCHIVOS</span></h2></td></tr>';
        for(let i=0;i<cant;i++)
        {
         row=row+'<tr><td colspan="2">'+datos.archivos[i].url+'</td></tr>';
        }
        
        document.getElementById('tfootArchivos').innerHTML=row;
    }
    else{
          let cant=datos.comentarios.length;
      let row=""; 
      for(let i=0;i<cant;i++)
      {let idComentario=datos.comentarios[i].idTareasComentario;
        row+=`<tr><td>${datos.comentarios[i].comentario}<br>Por:${datos.comentarios[i].email}</td><td>${datos.comentarios[i].fechaInsercion}</td></tr>`

      }
      
      document.getElementById('tbodyComentarios').innerHTML=row;
    }
   }  
}

 function cerrarModalHijo(hijo)
  {
     document.getElementById(hijo).classList.toggle('ocultarHijoModal');
     document.getElementById(hijo).classList.toggle('verHijoModal');    
}
</script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<?php
function imprimirFecha()
{ $option="";

  for($i=date("Y");$i>=2018;$i--){ $option.="<option value='".$i."'>".$i."</option>";}
    return $option;
}
?>
<script>
var vidsubventa =0;
let idTareaGlobal=0;
 document.addEventListener("DOMContentLoaded", function() {
    actualizaBarra();
    actualizasubBarra();
    verificaSubTareasExistencia();

  });
eventListeners();
//agregacolorFecha();
function escogerRow(){
if(document.getElementsByClassName('rowEscogido')[0])
 {
    document.getElementsByClassName('rowEscogido')[0].style.backgroundColor='white';
    document.getElementsByClassName('rowEscogido')[0].children[0].style.height='50px';
    document.getElementsByClassName('rowEscogido')[0].children[0].children[1].style.overflow='hidden';
    document.getElementsByClassName('rowEscogido')[0].children[0].children[1].style.height='50px';
    document.getElementsByClassName('rowEscogido')[0].classList.remove('rowEscogido');    
 }
     idTareaGlobal=this.children[0].id;
    this.classList.add('rowEscogido');
    this.style.backgroundColor='#5ac084';
    this.children[0].style.height='100px';
    this.children[0].children[1].style.overflow='scroll';
    this.children[0].children[1].style.height='100px';
    //this.children[0].classList.add('verScrooll');
}
function eventListeners(){
 if(document.querySelector('#subventana'))
 { document.querySelector('#subventana').addEventListener('click',entromenu);}
  document.querySelector('.btnmuestra').addEventListener('click',muestraposFecha);
  document.querySelector('.btnmuestraComite').addEventListener('click',muestraComite);
  document.querySelector('.grabaposFecha').addEventListener('click',grabaposFecha);
  document.querySelector('.btnGrabafecha').addEventListener('click',grabaFecha);
  document.querySelector('.btnGrabasubfecha').addEventListener('click',grabasubFecha);
  document.querySelector('.btneliminasubfecha').addEventListener('click',eliminasubFecha);
  document.querySelector('#listado-empleados tbody').addEventListener('click',agregaEmpleado);
  document.querySelector('#tabla-subempleado').addEventListener('click',agregasubEmpleado);
  document.querySelector('#tareaAgregadas').addEventListener('click',agregaPersona);
  document.querySelector('#tareaAgregadas ').addEventListener('dblclick',muestraParrafo);
 // document.querySelector('.tareas').addEventListener('click',despliegaSubtarea);
  document.querySelector('.contenedor-app .agrega_Tareas').addEventListener('click',agregaTarea);
  document.querySelector('.crear-proyecto a').addEventListener('click',nuevoProyecto);
  document.querySelector('#listado-contactos tbody').addEventListener('click',agregaInvitado);
  //document.querySelector('#listado-contactos tbody').addEventListener('click',agregasubInvitado);
  document.querySelector('.btnmodificaAlerta').addEventListener('click',modificaAlerta);
  document.querySelector('.btneliminaAlerta').addEventListener('click',eliminaAlerta);
  document.querySelector('#buscador').addEventListener('input',buscaContacto);
  document.querySelector('#ullistaInvitado').addEventListener('click',eliminaInv);
  //document.querySelector('#ullistasubEmpleados').addEventListener('click',eliminasubInv);
  document.querySelector('.invitadoExterno').addEventListener('click',agregaExterno);
  document.querySelector('.tareaExterno').addEventListener('click',tareaExterno);
  document.querySelector('.tareasubExterno').addEventListener('click',subtareaExterno);
  document.querySelector('#ullistaEmpleados').addEventListener('click',eliminaEmpleado);  
  document.querySelector('#ullistasubEmpleados').addEventListener('click',eliminasubEmpleado);  
  document.querySelector('.btnGrabaAlerta').addEventListener('click',grabaAlerta);
  document.querySelector('.btnGrabasubAlerta').addEventListener('click',grabasubAlerta);
  document.querySelector('.btneliminasubAlerta').addEventListener('click',eliminasubAlerta);
  //document.querySelector('.actividadesTareas').addEventListener('click',muestratareasImportantes); //Desactivado [Suemy][2024-04-05]
  document.querySelector('#grabaSubtarea').addEventListener('click',agregaSubtarea);    
  document.querySelector("#proyectos").addEventListener('click',posponeFecha); 
  document.querySelector("#comite").addEventListener('click',entraComite);  
  document.querySelector("#grabacomiteTarea").addEventListener('click',grabaagregaComite);
 if(document.querySelector('ul li .subicono')) {document.querySelector('ul li .subicono').addEventListener('click',despliegaSubtarea);}
  let sub=Array.from(document.getElementsByClassName('sub'));
  sub.forEach(s=>{s.addEventListener('click',escogerRow);s.classList.add('rowTarea')})
 // document.getElementById('escogerArchivosAD').addEventListener('change',function(){document.getElementById("contieneNombreDocumentosAD").value=this.files[0].name;})
}
agregarTipoDocumentoAD();
obtenerDirectorioAD();
/**************************************************** */

function agregarTipoDocumentoAD(d='')
 {
  //console.log('entro');
  if(d=='')
    {
        let params='Ajax';
        peticionAJAXLibSloan('catalogos/documentosPersonales',params,'agregarTipoDocumentoAD')
    }
    else
    {   
        let input='<option>ESCOGER TIPO ARCHIVO</option>';
        d.catalogos.forEach(i=>{input+=`<option value="${i.idCTD}">${i.catalogoTipoDocumento}</option>`})
        document.getElementById('tipoDocumentoSelectADoc').innerHTML=input;
    }
    return;
 }  
/**************************************************** */
function guardarDocumentoClienteADoc(dat='',objeto='',e) //Desactivado [Suemy][2024-04-05]
 {    
   
    if(dat=='')
    {
      e.preventDefault();
      if(document.getElementById('tipoDocumentoSelectADoc').value>0)
      {
       
        if(document.getElementById('escogerArchivosAD').value=='')
        {
            Swal.fire({
                title: '¡Espera!',
                text: 'Debes escoger un archivo',
                icon: 'warning'
            }) 
          return 0;
        }
        
       enviarFormularioLibSloan('documentosFormDAD','administrador/guardarDocumento','guardarDocumentoClienteADoc')
      }
      else{
            Swal.fire({
                title: '¡Espera!',
                text: 'Debes escoger un tipo de archivo',
                icon: 'warning'
            })
        }
    }
    else
    {
      obtenerDirectorioAD();
    }
    return;
 }
 
 /***************************************************************** */
 function obtenerDirectorioAD(datos='')
 {
   
    if(datos=='')
    {
        let params='Ajax';
        peticionAJAXLibSloan('administrador/devolverArchivos',params,'obtenerDirectorioAD')
    }
    else
    {   //console.log(datos)
       let div="";
        datos.forEach(d=>{
         div+=`<div class="documentosContenedorDiv"><div data-tipo="${d.nombreArchivo}"></div><div>${d.url}</div><div><button onclick="eliminarArchivo('','${d.nombreArchivo}')">X</button></div></div>`
        })
        document.getElementById('archivosClienteDocumentosAD').innerHTML=div;
    }
    return;
 }
/********************************************************************************* */
function eliminasubAlerta(e)
{
  e.preventDefault();
  var fechaTarea=document.querySelector('#fechasubAlerta'); 
  var alertaTarea=document.querySelector('#idTareasubAlerta');
  var idtarea = document.getElementById(alertaTarea.value);
  let idproyecto = getParameterByName('idproyecto'); 
  var listaTareas = document.querySelector("#periodosubAlerta");
  var tarea = e.target.parentElement.parentElement.children[3].children[1].textContent; 
  if(fechaTarea.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita una fecha',
        type: 'success'
      })  
      return;            
  }
  if(listaTareas.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita un periodo',
        type: 'success'
      })  
      return;            
  }
  muestraspinerF("#momento-subalerta");
  var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('idtarea',alertaTarea.value);
  datos.append('idproyecto',idproyecto);
  datos.append('tarea',tarea);
  datos.append('fecha',fechaTarea);
  xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminaAlertasubTarea",true);
  xhr.onload=function()
  {
    borraspinerF("#momento-subalerta");
    if(this.status === 200)
    {
      var respuesta = JSON.parse(xhr.responseText);
      Swal.fire({
        title: 'SubAlerta',
         text: 'Se Eliminado la SubAlerta',
          type: 'success'
        })   
      //console.log(respuesta);
      // var subhijos = idtarea.children[2];
       /*if(!subhijos.children[3].classList.contains('fa-stopwatch'))
       {
         idtarea.children[2].classList.add('fas');
         idtarea.children[2].classList.add('fa-stopwatch');
         idtarea.children[2].classList.add('icono');
       } */ 
    }
  }
  xhr.send(datos);
 return;
}
 /*********************************************************************************** */  
 function verificaSubTareasExistencia()
 {
    let ul=document.getElementsByClassName('subtareas');
    let cant=ul.length;
    for(let i=0;i<cant;i++)
    {
     if(ul[i].getElementsByTagName('li').length==0)
     {
        let id=ul[i].id.replace('subtareas','');
        let li=document.getElementById(id);
        li.firstElementChild.classList.add('colorGris');
     }
     else{        let id=ul[i].id.replace('subtareas','');
        let li=document.getElementById(id);
        li.firstElementChild.classList.remove('colorGris');
  }
    }
    

 }   
/********************************************************* */
function quitaVentana(ventana){
  var idventana = document.getElementById(ventana);
  idventana.classList.add('ocultar'); 
}
/********************************************************* */
function entromenu(e)
{
  e.preventDefault();
  
  return ;
}
/***********************************************+******+*** */
function eliminaAlerta(e) //Modificado [Suemy][2024-03-13]
{
  e.preventDefault();
  var fechaTarea=document.querySelector('#fechaAlerta'); 
  var alertaTarea=document.querySelector('#idTareaAlerta');
  var idtarea = document.getElementById(alertaTarea.value);
  let idproyecto = getParameterByName('idproyecto'); 
  var listaTareas = document.querySelector("#periodoAlerta");
 // console.log(fechaTarea.value);
  if(fechaTarea.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita una fecha',
        icon: 'success'
      })  
      return;            
  }
  if(listaTareas.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita un periodo',
        icon: 'success'
      })  
      return;            
  }
 
var hijos =  idtarea.children[2] ;
  muestraspinerF("#momento-alerta");
        var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',alertaTarea.value);
            datos.append('idproyecto',idproyecto);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminaAlertaTarea",true);
            xhr.onload=function()
            {
              borraspinerF("#momento-alerta");
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                 var subhijos = idtarea.children[2];
                 console.log(subhijos.children)
                 if(!subhijos.children[3].classList.contains('fa-clock'))
                 {
                  /* idtarea.children[2].classList.add('fas');
                   idtarea.children[2].classList.add('fa-stopwatch');
                   idtarea.children[2].classList.add('icono');*/
                 } 
                 else{
                  subhijos.children[3].classList.remove('fas');
                  subhijos.children[3].classList.remove('fa-clock');
                  subhijos.children[3].classList.remove('icono');
                 } 
              }
            }
            xhr.send(datos);
            Swal.fire({
                  title: 'Alerta',
                   text: 'Se ha eliminado la Alerta',
                    icon: 'success'
                  })                    
                  $(".modalAlerta").fadeOut();  
                               
   return;               
 
}

/********************************************************************** */
function modificaAlerta(e) //Modificado [Suemy][2024-03-13]
{
  e.preventDefault();
  var fechaTarea=document.querySelector('#fechaAlerta'); 
  var alertaTarea=document.querySelector('#idTareaAlerta');
  var idtarea = document.getElementById(alertaTarea.value);
  let idproyecto = getParameterByName('idproyecto'); 
  var listaTareas = document.querySelector("#periodoAlerta");
 console.log(alertaTarea.value, fechaTarea.value, idproyecto, listaTareas.value);
  if(fechaTarea.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita una fecha',
        icon: 'warning'
      })  
      return;            
  }
  if(listaTareas.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita un periodo',
        icon: 'warning'
      })  
      return;            
  }
  if(idproyecto =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'Debes seleccionar un proyecto',
        icon: 'warning'
      })  
      return;            
  }
 
var hijos =  idtarea.children[2] ;
  muestraspinerF("#momento-alerta");
        var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',alertaTarea.value);
            datos.append('fecha',fechaTarea.value);
            datos.append('idproyecto',idproyecto);
            datos.append('tipo',listaTareas.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaAlertaTarea",true);
            xhr.onload=function()
            {
              borraspinerF("#momento-alerta");
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                 var subhijos = idtarea.children[2];
               //  console.log(subhijos);
                 if(!subhijos.children[3].classList.contains('fa-clock'))
                 {
                   subhijos.children[4].classList.add('fas');
                  subhijos.children[4].classList.add('fa-clock');
                  subhijos.children[4].classList.add('icono');
                 }  
              }
            }
            xhr.send(datos);
            Swal.fire({
                  title: 'Alerta',
                   text: 'Se modificado la Alerta',
                    icon: 'success'
                  })                    
                  $(".modalAlerta").fadeOut();  
                               
   return;               
 
}

/********************************************************* */

function muestraParrafo(e){
  var nombreNodo =e.target; 
  if(nombreNodo.parentElement.parentElement.children[0].children[1].nodeName=="P")
   {
     //console.log(e.target.textContent);
      $(".modalVisualiza").fadeIn();
       document.getElementById("textoMostrar").textContent  = e.target.textContent;
     return;
   }
}
/********************************************************* */
function muestraComite(e){
  e.preventDefault();
  //console.log('entro');
  var xhr = new XMLHttpRequest();
            var datos = new FormData();
            //datos.append('idtarea',terminado.id);
            datos.append('comite',document.getElementById("idagregaComite1").value);
            datos.append('ano',document.getElementById("anocomite").value);   
            datos.append('mes',document.getElementById("mescomite").value); 
            datos.append('dia',document.getElementById("diacomite").value);   
            //console.log(document.getElementById("mescomite").value);            
           xhr.open('POST',"<?php echo base_url();?>cproyecto/buscaComision",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta);
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
              }
            }
          xhr.send(datos);  
  return ;
}
/************************************************** */
function grabaagregaComite(e) //Modificado [Suemy][2024-05-10]
{
  e.preventDefault();
  //console.log('entro');
  var tarea =document.getElementById('inpcomiteTarea').value;
  // var terminado = document.getElementById(tarea);
  let idproyecto = getParameterByName('idproyecto');
    let header = document.getElementById(tarea+'DivRespon');
    let segment = document.getElementById('seg'+tarea);
    let container = document.getElementById(tarea+'DivSub');
    $("#momento-comite").removeClass('hidden');
   
        var xhr = new XMLHttpRequest();
         var datos = new FormData();
         datos.append('idtarea',tarea);
         datos.append('comite',document.getElementById("idagregaComite").value);    
         datos.append('idproyecto',idproyecto);        
         xhr.open('POST',"<?php echo base_url();?>cproyecto/updateComision",true);
         xhr.onload=function()
         {
           $("#momento-comite").addClass('hidden'); 
           if(this.status === 200)
           {
             var respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);
              // $(".modalAgregaComite").fadeOut(); 
             // terminado.remove(); 
                header.remove();
                segment.remove();
                container.remove();
             Swal.fire({
                title:  '¡Hecho!',
               text: 'La Tarea se ha agregado al Historico',
               icon: 'success'
                }).then(function () {
                   //location.reload(true);
                    })  
                      
               
           }
         }
       xhr.send(datos);        
    
  return ;
 /* e.preventDefault();
     var tarea =document.getElementById('inpcomiteTarea').value;
       var terminado = document.getElementById(tarea);
      // console.log(terminado);
           var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',terminado.id);
            datos.append('comite',document.getElementById("idagregaComite").value);            
            xhr.open('POST',"<?php echo base_url();?>cproyecto/updateComision",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                
                terminado.remove(); 
                Swal.fire(
                  'Comision!',
                   'La Tarea se ha Agregado a Comision',
                  'success',
                   )               
                   $(".modalAgregaComite").fadeOut(); 
              }
            }
          xhr.send(datos);        
  return ;*/
}
/********************************************************* */
function entraComite(e)
{
  e.preventDefault();
 // console.log('entro')
  return ;
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
 
}
/********************************************************* */
function grabaposFecha(e){
  
  var botps = document.querySelector('.grabaposFecha a');
  botps.classList.add('inhabilitado');
  var idposfecha = document.querySelector('#idTareaposFecha').value;
  var porfecha = document.querySelector('#posFecha').value;
  //console.log(idposfecha)
  var pintar = document.getElementById('id'+idposfecha);
  console.log(pintar);
  var idpro = pintar.id.split("id");
  idpro = idpro[1];
  let idproyecto = getParameterByName('idproyecto'); 
 // console.log(idpro);
 var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('idposfecha',idposfecha);
  datos.append('idproyecto',idproyecto);
  //console.log(idposfecha);
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
 muestraspinerF("#momento-posfecha");
  xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaposFecha",true);
  xhr.onload = function(){
    borraspinerF("#momento-posfecha");
    if(this.status===200){
      var respuesta =JSON.parse(xhr.responseText);
      botps.classList.remove('inhabilitado');
      console.log(respuesta);
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
function posponeFecha(e){ //Modificado [Suemy][2024-05-10]
    //console.log(e.target.parentElement);
  var posfecha = e.target;
  var nombre = e.target.parentElement;
   
  if(posfecha.classList.contains('fa-file-excel') || posfecha.classList.contains('fa-download'))
  {
    e.preventDefault();
    
    //console.log(e.target.parentElement);
    var enviaExcel = e.target.parentElement;
    enviaExcel.submit()
    return;
  }
 // console.log(posfecha.classList);
  if(posfecha.classList.contains('fa-calendar-check'))
  {
  
  //  var idposfecha =nombre.children[0].id;
    var idposfecha =nombre.id;
  // console.log(nombre.parentElement);

   var nosmbrepos =nombre.parentElement.children[0].textContent;
  //var nosmbrepos =nombre.textContent;
   //console.log(nosmbrepos);
   $('#textoposFecha').text(nosmbrepos);
   //textoFecha
   $('#idTareaposFecha').val(idposfecha);
   $(".modalposFecha").fadeIn();
   
  }
  return;
}
/********************************************************* */
function despliegaSubtarea(){
 //console.log('hola');
  /* if(e.target.classList.contains('fa-angle-double-down'))
   {
    //let subtare =  "#subtareas"+idtarea.id;
    //val subtarea =$(subtatre);
    //console.log(idtarea.id);
   }*/
}
/********************************************************* */
function agregaSubtarea(){
 //console.log('llego');
 var subtarea = document.querySelector("#nuevaSubtarea").value;
 var idproyecto = getParameterByName('idproyecto');
 var idtarea = document.querySelector("#inpsubtarea").value;
 var idtar = document.querySelector("#inpsubtarea").value;
 //var idtarea = e.target.parentElement.parentElement; 
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
      $("#modalsubTareas").fadeOut();  
     actualizasubBarra();
     verificaSubTareasExistencia();
    }
  }
   xhr.send(datos);
 
 
 //Termina subtarea

}
/********************************************************* */
function actualizasubBarra(){
  if(vidsubventa ==0)
  return;
 var numero = vidsubventa.id.split("subtareas");
 var idbarra = document.querySelectorAll("#subtareaAgregadas"+numero[1]+ " li");
 var hijabarra = vidsubventa.childNodes;
  var barra =0,avance=0;
  for(i=0;i < idbarra.length;i++){
    //console.log(idbarra[i].childNodes[2].childNodes[3].classList.contains('terminado'));
    //var bolfa= (idbarra[i].childNodes[2].childNodes[3].classList.contains('terminado'));
    if((idbarra[i].childNodes[2].childNodes[3].classList.contains('terminado')))
    {
    //  console.log('hola')
      avance++;
    }
    
  }
  var total = Math.round((avance/idbarra.length)*100);
          //console.log('#subporcentaje'+valor); 
          var porcentaje = document.querySelector('#subporcentaje'+numero[1]);
         // console.log(porcentaje); 
            porcentaje.style.width = total+'%';
 
 return;
  }
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
 } 
/***************************** */
function eliminasubInv(e){
  //e.preventDefault();
  //console.log(e.target.classList);
  //nom = e.target.parentElement;
 // console.log(nom.id);
 /*if(e.target.classList.value=='fas fa-trash-alt')
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
   
  } */
}

/************************************* */

function eliminaInv(e){
  e.preventDefault();
  //console.log(e.target.classList);
  nom = e.target.parentElement;
    //console.log(nom.id);
 if(e.target.classList.value=='fas fa-trash-alt')
  {
   Swal.fire({
     title: '¿Deseas borrar el registro?',
     text:'Se borrará el invitado del Proyecto',
     icon: 'warning',
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
                /*OMAR*/
                devolverInvitados();
                //console.log(respuesta);                
              }
            }
      xhr.send(datos);
       Swal.fire(
         'Borrado!',
         'El invitado ha sido borrado',
         'success'
       )
     }
   })
   
  } 
}
/************************************* */
function grabasubFecha(e)
{
  e.preventDefault();

var idtarea=document.querySelector('#idTareasubFecha'); 
 var fechaTarea=document.querySelector('#subfechaTarea'); 
 var id = document.getElementById(idtarea.value);
 var responsables = id.parentElement.parentElement.parentElement.children[0].children[1].textContent;
 //console.log(idtarea);
 var hijos = id.children[1];
 var iconos = id.children[1];
 //console.log(iconos.children[4]);
 //Es el verdadero valo de la tarea
 var idresponsable = id.parentElement.parentElement.parentElement.children[0];
 var subProy = hijos.parentElement.children[0].textContent;
 var subhijos =hijos.children[4];
// var iconos = hijos.children[2];
var nombreProy = document.querySelector("#nombreProyecto").value;
var listaTareas = document.querySelector("#periodosubFecha");
if(fechaTarea.value =="")
{
  Swal.fire({
    title: 'FechaEntrega',
     text: 'Nnecesita una fecha de Entrega',
      type: 'success'
    })  
    return;            
}
if(listaTareas.value =="")
 {
   Swal.fire({
     title: 'FechaEntrega',
      text: 'Necesita una fecha Entrega',
       type: 'success'
     })  
     return;            
 }


 
 var xhr = new XMLHttpRequest();
           var datos = new FormData();
           //el identificador de la subtarea
           datos.append('idtarea',idtarea.value);
           datos.append('fecha',fechaTarea.value);
           datos.append('nombreProy',nombreProy);
           datos.append('subProy',subProy);
           datos.append('responsables',responsables);
           datos.append('idresponsable',idresponsable.id);
           let idproyecto = getParameterByName('idproyecto');
           datos.append('idproyecto',idproyecto);
           datos.append('tipo',listaTareas.value);
           muestraspinerF("#momento-subfecha");
           xhr.open('POST',"<?php echo base_url();?>cproyecto/grabasubFechaTarea",true);
           xhr.onload=function()
           {
             if(this.status === 200)
             {
               borraspinerF("#momento-subfecha");
               var respuesta = JSON.parse(xhr.responseText);
                 //console.log(respuesta);
                 Swal.fire({
                  title: 'Fecha Agregado',
                  text: 'Se agrego La Fecha correctamente',
                   type: 'success'
                 })
                //console.log(iconos);
                 if(!iconos.children[4].classList.contains('cafe'))
                 {
                   iconos.children[4].classList.remove('icono');
                   iconos.children[4].classList.add('cafe');
                 }
                 $('.modalsubFecha').fadeOut();
             }
           }
           xhr.send(datos);
   return;   
 /* e.preventDefault();
  //console.log("Graba Fecha");
  var idtarea=document.querySelector('#idTareasubFecha'); 
  var fechaTarea=document.querySelector('#subfechaTarea'); 

  var id = document.getElementById(idtarea.value);
  //var divid =document.getElementById('subtareaAgregadas6'); 
  var hijos = id.children[1];
  var subhijos =hijos.children[4];
  //console.log(idtarea.value);
  //console.log(subhijos.classList);
   //console.log(fechaTarea.value);
  var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.value);
            datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/grabasubFechaTarea",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                // console.log(respuesta);
                  Swal.fire({
                   title: 'Fecha Agregado',
                   text: 'Se agrego La Fecha correctamente',
                    type: 'success'
                  })
                  if(!subhijos.classList.contains('cafe'))
                  {
                    subhijos.classList.remove('icono');
                    subhijos.classList.add('cafe');
                  }
                  $('.modalsubFecha').fadeOut();
              }
            }
            xhr.send(datos);*/
}

/************************************* */
function grabaFecha(e) //Modificado [Suemy][2024-05-10]
{
  e.preventDefault();
  var id = document.getElementById('idTareaFecha');
  var divid =document.getElementById('V'+id.value); 
  let idproyecto = getParameterByName('idproyecto'); 
  /*divid = divid.previousSibling.previousElementSibling.children[0];
  var hijos = divid.childNodes[3];*/
  //var subhijos =hijos.parentElement.children[2];
  var idtarea=document.querySelector('#idTareaFecha'); 
  var fechaTarea=document.querySelector('#fechaTarea');
  var listaTareas = document.querySelector("#periodoFecha");
  let h = document.getElementById(idtarea.value);
  var subhijos = h.children[2]; //h.getElementsByTagName("div");
  //console.log(subhijos);
 //console.log(listaTareas.value);
  $("#momento-modalFecha").removeClass('hidden');
  var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.value);
            datos.append('fecha',fechaTarea.value);
            datos.append('idproyecto',idproyecto);
            datos.append('tipo',listaTareas.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaFechaTarea",true);
            xhr.onload=function()
            {
              $("#momento-modalFecha").addClass('hidden');
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                let dat=[];
                let fec=fechaTarea.value.split('-');
                dat['idTarea']=idtarea.value;
                dat['fecha'] = getDateFormat(fechaTarea.value);
                //console.log(dat);
               refrescarDatos(dat,'fechaEntrega')
                 Swal.fire({
                   title: 'Fecha Agregado',
                   text: 'Se agrego La Fecha correctamente',
                    icon: 'success'
                  })
                if(!subhijos.children[3].classList.contains('far'))
                        subhijos.children[3].classList.add('far');
                  if(!subhijos.children[3].classList.contains('fa-calendar-alt'))
                    subhijos.children[3].classList.add('fa-calendar-alt');
                 if(!subhijos.children[3].classList.contains('cafe'))   
                    subhijos.children[3].classList.add('cafe');
                  
                  $('.modalFecha').fadeOut();
              }
            }
            xhr.send(datos);

   return;         
}
/********************************************************** */
function agregasubInvitado(e){
  //console.log(e);
}
/********************************************************** */
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
                  $("#ullistaInvitado").append("<li> "+nombre.id +"---"+correo+" <button class ='btn btn-danger eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                  /*OMAR*/
                   devolverInvitados('');
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
                  $("#ullistaInvitado").append("<li> "+nombre.id +"---"+correo+" <button class ='btn btn-danger eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                   Swal.fire('Mensaje de Confirmacion',"Se Invitó A : "+nombre.id,"success");
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
    //console.log('No hiciste clic en le icono');
   } 
}
/******************************************************************* */
function agregasubEmpleado(e){
  e.preventDefault();
  //console.log('llego');
  const nom = e.target.parentElement;
   const nombre=e.target.parentElement.parentElement;
   const nodos = e.target.parentElement.parentElement.parentElement;
   var correo = nodos.childNodes[2].textContent;
   var tipo = nodos.childNodes[3].textContent;
   var tip="" 
   const tarea = e.target.parentElement.parentElement;
   
   //console.log(tarea);
   if(tipo == "CLIENTES")
   {
     tip = "CLIENTES";
   }
   else
   {
     tip = "OPERATIVO";
   }
   var idsubtarea =  document.querySelector("#idsubTar").value;
   var subtarea =  document.querySelector("#nombresubTarea").value;
   var idtarea =  document.querySelector("#idTar").value;  
   if(e.target.classList.contains('fa-check-circle'))
   {
    
     if(e.target.classList.contains('completo'))
       {
        
        //console.log('aqui');
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
            datos.append('idsubtarea',idsubtarea);
            //datos.append('idtarea',idtarea);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/agregasubEmpleados",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta);
                var accion = respuesta.respuesta;
                var tiporespuesta =respuesta.tipoerror;
                 //console.log(accion);
                if(accion == 'error')
                {
                  Swal.fire('Mensaje de Advertencia',tiporespuesta ,"warning");
                }
                else{
                   
                  // $("#ullistasubEmpleados").append("<li> "+nombre.id +"---"+correo+" <button class ='eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                  $("#ullistasubEmpleados").append("<li> "+nombre.id +"---"+correo+" <div><button id=p"+idsubtarea+" style =' margin-right:5px; cursor:pointer;'><i class='fas fa-check '></i></button><button id ="+idsubtarea+"  style =' margin-right:5px; cursor:pointer;color: red;' onclick=''><i class='fas fa-trash-alt'></i></button></div></li>"); 
                  Swal.fire('Mensaje de Confirmacion',"Se Invito A : "+nombre.id,"success");
                }
               }
             }
             xhr.send(datos);
           }           
         }
         else{
              //console.log('aqui');
              e.target.classList.add('completo');
            } 
    }
  return;
}
/******************************************************************* */
function agregaEmpleado(e){
    console.log(e);
  e.preventDefault();
   const nom = e.target.parentElement;
   const nombre=e.target.parentElement.parentElement;
   const nodos = e.target.parentElement.parentElement.parentElement;
   var correo = nodos.childNodes[2].textContent;
   var tipo = nodos.childNodes[3].textContent;
   var tip="" 
  
  if(tipo == "CLIENTES")
   {
     tip = "CLIENTES";
   }
   else
   {
     tip = "OPERATIVO";
   }
   var idtarea =  document.querySelector("#idTarea").value;//getParameterByName('idTarea');
   //console.log(idtarea);
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
                console.log(respuesta);
                var accion = respuesta.respuesta;
                var tiporespuesta =respuesta.tipoerror;
                let dat=[];
                dat['idTarea']=respuesta.idTarea;
                dat['responsables']=respuesta.responsables;

                 refrescarDatos(dat,'fotos');
                if(accion == 'error')
                {
                  Swal.fire('Mensaje de Advertencia',tiporespuesta ,"warning");
                }
                else{
                   
                  $("#ullistaEmpleados").append("<li> "+respuesta.nombre_proyecto +"---"+correo+" <div><button class='btn btn-primary-two' id=p"+respuesta.idproyecto+" style =' margin-right:3px;'><i class='fas fa-check '></i></button><button class='btn btn-danger' id ="+respuesta.idproyecto+" onclick=''><i class='fas fa-trash-alt'></i></button></div></li>");
                    Swal.fire('Mensaje de Confirmacion',"Se Invito A : "+respuesta.nombre_proyecto,"success");
                   /*$("#ullistaEmpleados").append("<li> "+nombre.id +"---"+correo+" <button class ='eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                   Swal.fire('Mensaje de Confirmacion',"Se Invito A : "+nombre.id,"success");*/
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
  return;
}

/********************************************************** */
function openModalMenu(type) { //Creado [Suemy][2024-04-05]
    switch(type) {
        case 1:
            //Desactivado porque la función no trabaja correctamente
            //$(".modalDocumentos").fadeIn();
        break;
        case 2:
            $('#tabla-historico').html(`
                <tr>
                    <td colspan="11">
                        <div class="container-spinner-content-loading">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                        </div>
                    </td>
                </tr>
            `);
            params=`idProyecto=${getParameterByName('idproyecto')};`;
            controlador="cproyecto/obtenerHistoricoAcumulado/?";
            peticionAJAX(controlador,params,'mostrarHistoricoAcumulado');  
            modalmuestraTareacom.style.display='block';
        break;
        case 3:
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>Cproyecto/devuelveEstrellas",false);
            xhr.onload=function(){
              if(this.status === 200)
              {
                //console.log('entro');
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
        break;
        case 4:
            //Trae el fechas de tarea
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelveFechaEntrega",true);
            xhr.onload=function(){
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var lis = document.querySelectorAll('#tareaFechaImportantes li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                for(let i = 0; i < respuesta.length; i++) {
                 var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta[i].nombre +"--<spam class= 'tipocolor'>"+respuesta[i].tarea+"</spam></p>";
                         var listaTareas = document.querySelector("#tareaFechaImportantes");
                       listaTareas.appendChild(nuevoTarea);
                } 
                $(".modalEntregatareas").fadeIn();               
               }
            }
            xhr.send(datos); 
        break;
        case 5:
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>cproyecto/retornaFechaAlerta",true);
            xhr.onload=function(){
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
        break;
        case 6:
            //Desactivado por no existir la función "retornaVencidos"
            /*var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>cproyecto/retornaVencidos",true);
            xhr.onload=function(){
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var lis = document.querySelectorAll('#muestraproyectos li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li);
                 } 
                 for( i =0; i < respuesta.length ; i++)
                 {
                var nuevoTarea = document.createElement('Li'); 
                nuevoTarea.innerHTML="<p>"+respuesta[i].tarea +"---<spam class= 'tipocolor'>"+ respuesta[i].fechaentrega+"</spam>---<spam class= 'tipocolor'>"+ respuesta[i].tipo+"</spam></p>";
                       var listaTareas = document.querySelector("#muestraproyectos");
                       console.log(listaTareas);
                     listaTareas.appendChild(nuevoTarea);
                 }
                $(".modalmuestraPosFecha").fadeIn(); 
              }
            }
            xhr.send(datos);*/
        break;
    }
}

/*function muestratareasImportantes(e) //Desactivado [Suemy][2024-04-05]
{
 console.log(e); 
 e.preventDefault(); 
 console.log(e.target); 
 if(e.target.classList.contains('fa-file'))
  {
    $(".modalDocumentos").fadeIn(); 
    return;  
  }
 
  if(e.target.classList.contains('fa-thumbtack'))
  {
   
    //console.log('entro');
       // var lis = document.querySelectorAll('#tareaAgregadas li'); 
       //           for(var i=0; li=lis[i]; i++) { 
       //          li.parentNode.removeChild(li); 
       //          } 
       //      var xhr = new XMLHttpRequest();
       //      var datos = new FormData();
       //      xhr.open('POST',"<?php echo base_url();?>cproyecto/muestraProyectos",true);
       //      xhr.onload=function()
       //      {
       //        if(this.status === 200)
       //        {
       //          //var respuesta = JSON.parse(xhr.responseText);
       //          //console.log(respuesta);
       //          var lis = document.querySelectorAll('#tareaAlerta li'); 
       //           for(var i=0; li=lis[i]; i++) { 
       //          li.parentNode.removeChild(li); 
       //          } 
       //          for(let i = 0; i < respuesta.length; i++) {
       //           var nuevoTarea = document.createElement('Li'); 
       //            nuevoTarea.innerHTML="<p>"+respuesta[i].nombre +"--<spam class= 'tipocolor'>"+respuesta[i].tarea+"</spam></p>";
       //                   var listaTareas = document.querySelector("#tareaAlerta");
       //                //   console.log(listaTareas);
       //                 listaTareas.appendChild(nuevoTarea);
       //          } 
       //       // $(".modalEntregaalertas").fadeIn();            
       //       }
       //      // }
       //       xhr.send(datos);  
    return;
   }
  
  if(e.target.classList.contains('fa-star'))
  {
     
    var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>Cproyecto/devuelveEstrellas",false);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                //console.log('entro');
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
                return;
               }
             }
             xhr.send(datos);       
             return;
   
  }
 // console.log('aqui');
  if(e.target.classList.contains('fa-check-circle'))
  {
    console.log('Hciste clic en actividades');
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
       
    //  console.log('aqui');
    $(".modalmuestraTareacom").fadeIn(); 
    return;
  }
  if(e.target.classList.contains('fa-calendar-alt'))
  {
            //Trae el fechas de tarea
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelveFechaEntrega",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var lis = document.querySelectorAll('#tareaFechaImportantes li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                for(let i = 0; i < respuesta.length; i++) {
                 var nuevoTarea = document.createElement('Li'); 
                  nuevoTarea.innerHTML="<p>"+respuesta[i].nombre +"--<spam class= 'tipocolor'>"+respuesta[i].tarea+"</spam></p>";
                         var listaTareas = document.querySelector("#tareaFechaImportantes");
                       listaTareas.appendChild(nuevoTarea);
                } 
                $(".modalEntregatareas").fadeIn();               
               }
             }
             xhr.send(datos);       

  
  }
  if(e.target.classList.contains('fa-stopwatch'))
  {
  
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
   //console.log('llego');
   $(".modalmuestraPosFecha").fadeIn();
   var xhr = new XMLHttpRequest();
      var datos = new FormData();
      xhr.open('POST',base_url+"cproyecto/retornaVencidos",true);
        xhr.onload=function()
             {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var lis = document.querySelectorAll('#muestraproyectos li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li);
                 } 
                 for( i =0; i < respuesta.length ; i++)
                 {
                var nuevoTarea = document.createElement('Li'); 
                nuevoTarea.innerHTML="<p>"+respuesta[i].tarea +"---<spam class= 'tipocolor'>"+ respuesta[i].fechaentrega+"</spam>---<spam class= 'tipocolor'>"+ respuesta[i].tipo+"</spam></p>";
                       var listaTareas = document.querySelector("#muestraproyectos");
                       console.log(listaTareas);
                     listaTareas.appendChild(nuevoTarea);
                 } 
              }
            }
          xhr.send(datos);
      return;
  }
  if(e.target.classList.contains('fa-book'))
  {
   console.log('llego');
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
  //modalmuestraPosFecha
}*/
/********************************************************** */
function agregaTarea(e) //Modificado [Suemy][2024-04-05]
{
 e.preventDefault();
 var nuevatarea = document.querySelector('#nuevo-tarea').value;
  var idproyecto = getParameterByName('idproyecto');
  var tituloTarea= document.getElementById('tituloTareaInput').value;
  
 if(e.target.classList.value=='fas fa-user-plus fa-x icono2')
 {
  if(idproyecto === undefined){
    Swal.fire(
      'Proyecto!',
      'Necesita seleccionar el Proyecto',
      'warning'
   );
   return;
  }
  if(idproyecto <= 0)
  {
    Swal.fire(
         'Proyecto!',
         'Necesita seleccionar el Proyecto',
         'warning'
      );
   $('#nuevo-tarea').val('');
    return; 
  } 
  if(nuevatarea == '')
  {
    Swal.fire(
         'Tarea!',
         'La Tarea no puede estar vacia',
         'warning'
      );
    return;
  }
  if(tituloTarea == '')
  {
    Swal.fire(
         'Tarea!',
         'La Tarea debe tener un titulo',
         'warning'
      );
    return;
  }

  var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('nombre',nuevatarea);
  datos.append('idproyecto',idproyecto);
  datos.append('tituloTarea',tituloTarea);
  xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaTarea",true);
  xhr.onload = function(){
    if(this.status===200){
      var respuesta =JSON.parse(xhr.responseText);
      //console.log(respuesta);
      var tarea = respuesta.tarea,
          idtarea = respuesta.idtarea;
      //var nuevoTarea = document.createElement('Li'); 
      var fecha =  respuesta.fecha; 
      /*var nuevoTarea = document.createElement('div'); 
      nuevoTarea.setAttribute("class", "sub");
      nuevoTarea.setAttribute("id","subtareas"+idtarea);
      nuevoTarea.addEventListener('click',escogerRow);
      nuevoTarea.classList.add('rowTarea')*/
      //nuevoTarea.id = idtarea;   
        var nuevoTarea=`
            <div id="${idtarea}DivRespon" class="responDivCabTareas container-badge" data-responsables="SIN RESPONSABLE" data-fechaentrega="" data-estrellas="0" data-fechacreacion="${respuesta.fecha}" data-statustarea="SIN RESPONSABLES">
                <div class="col-md-3 col-flex-center-start" data-tipo="responsables" id="${idtarea}DivFotosRespon"></div>
                <div class="col-md-1 pd-left pd-right col-flex-center-center">
                    <span class="estrellasSpan">
                        <label class="estrellasLabel" id="estrellasLabel${idtarea}" data-estrellas="0">0⭐</label>
                    </span>
                </div>
                <div class="col-md-2 pd-left pd-right col-grid-center-start" data-tipo="fechacreacion" id="${idtarea}DivFechaCreacion">
                    <div class="col-flex-center-start">
                        <label class="l textLabel mg-right">Fecha Creación:</label>
                        <label class="textLabel" id="${idtarea}FechaCreacionLabel">
                            <strong>01/04/2024</strong>
                        </label>
                    </div>
                    <div class="col-flex-center-start">
                        <label class="l textLabel mg-right">Fecha Entrega:</label>
                        <label class="textLabel" id="${idtarea}FechaEntregaLabel">
                            <strong></strong>
                        </label>
                    </div>
                </div>
                <div class="col-md-4 pd-left pd-right col-grid-center-start" data-tipo="fecha" id="${idtarea}DivFechaEntrega">
                    <div class="col-flex-center-start">
                        <label class="l textLabel mg-right">Completada:</label>
                        <label class="textLabel" id="${idtarea}FechaCompletadaLabel">
                            <strong></strong>
                        </label>
                    </div>
                    <div class="col-flex-center-start">
                        <label class="l textLabel mg-right">En producción:</label>
                        <label class="textLabel" id="${idtarea}FechaProduccionLabel">
                            <strong></strong>
                        </label>
                    </div>
                </div>
                <div class="col-md-1 pd-left pd-right col-flex-center-center" data-tipo="produccion" id="${idtarea}DivProduccion"></div>
                <div class="col-md-1 pd-left pd-right col-flex-center-center" id="V${idtarea}">
                    <button class="btn-option-proyect open-details" href="#seg${idtarea}" data-toggle="collapse" aria-expanded="true" onclick="openContainer(this)" style="margin-right: 5px;">
                        <i class="fas fa-plus" data-class="fas fa-plus" title="Ver"></i>
                    </button>
                    <span>
                    <div class="dropdown">
                        <button class="btn-option-proyect" type="button" id="dp${idtarea}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropTarea" aria-labelledby="dp${idtarea}" style="height: 250px;overflow: auto;">
                            <li id="pausar-tarea">                                        
                                <button class="dropdown-item " id="statusTask${idtarea}" data-title="gbnnytj" data-status="0" onclick="abrirModalPausar(this,'${idtarea}')">
                                    <i class="fas fa-pause fa-x icono" title="Pausar Tarea"></i>Pausar Tarea
                                </button>
                            </li>
                            <li><hr class="dropdown-divider " id="divider${idtarea}"></li>
                            <li id="agrega-Usario">                                        
                                <button class="dropdown-item">
                                    <i class="fas fa-user-plus fa-x icono" title="Agrega Usuarios"></i>Agregar Responsable
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li id="agendaTareas">
                                <button class="dropdown-item">
                                    <i class="far fa-calendar-alt icono" title="Agenda Tareas"></i> Agendar Fecha por Compromiso
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li id="importanteTareas">
                                <button class="dropdown-item">
                                    <i class="far fa-star icono" title="Tareas Importantes"></i> Importante
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li id="completados">
                                <button class="dropdown-item">
                                    <i class="far fa-check-circle icono" title="Tareas Completadas"></i> Completada
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li id="opcionComentarios">
                                <button class="dropdown-item" data-title="${respuesta.titulo}" onclick="abrirModalComentario(this,${idtarea})">
                                    <i class="far fa-comment icono" title="Agregar Comentarios"></i> Comentarios
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li id="opcionDocumentos">
                                <button class="dropdown-item" data-title="${respuesta.titulo}" onclick="abrirModalSubirArchivos(this,${idtarea})">
                                    <i class="fas fa-file icono" title="Agregar Documentos"></i> Documentos
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li id="alertaTareas">
                                <button class="dropdown-item">
                                    <i class="fas fa-stopwatch icono" title="Alerta de Tareas"></i> Alerta por Recordatorio
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li id="comite"> <!-- idmenu.includes("comite") -->
                                <button class="dropdown-item">
                                    <i class="fas fa-copyright icono" title="comite"></i> Guardar Historico
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li id="elimina-Tareas">
                                <button class="dropdown-item">
                                    <i class="fas fa-trash-alt icono" title="Eliimina Tareas"></i> Eliminar
                                </button>
                            </li>
                        </ul>
                    </div></span>
                </div>
                <span class="badge badge-title-proyect">${respuesta.titulo}</span>
            </div>
            <div class="container-info-task collapse" id="seg${idtarea}" style="margin: 0px">
                <div class="col-flex-center-start">
                    <div class="col-md-3 column-grid-center-start pd-left width-ajust">
                        <div class="col-flex-center-start">
                            <label class="textLabel mg-right">Fecha Tarea Completada:</label>
                            <label class="textLabel">
                                <strong></strong>
                            </label>
                        </div>
                        <div class="col-flex-center-start">
                            <label class="l textLabel mg-right">Fecha Producción:</label>
                            <label class="textLabel">
                                <strong></strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 column-grid-center-start brd-left-p">
                        <div class="col-flex-center-center"><label class="textLabel mg-right">Tiempo Tarea Terminada por Asignación</label></div>
                        <div class="col-flex-grid-start"></div>
                    </div>
                    <div class="col-md-6 column-grid-center-start brd-left-p pd-right width-ajust">
                        <div class="col-flex-center-start">
                            <label class="textLabel mg-right" title="(Desde la creación hasta completar)">
                                Tiempo Tarea Completada:
                            </label>
                            <label class="textLabel">
                                <strong></strong>
                            </label>
                        </div>
                        <div class="col-flex-center-start">
                            <label class="textLabel mg-right" title="(Desde completar hasta la producción)">
                                Tiempo para Producción:
                            </label>
                            <label class="textLabel">
                                <strong></strong>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sub rowTarea" id="${idtarea}DivSub">
                <li id="${idtarea}"><i class="fas fa-angle-double-down subicono" ></i>
                <p onclick="traerComentarios_Archivos('',this)">${tarea}</p>
                <div  class="icono-tarea" > <i  title="Tareas Completadas"></i> <i title="Tareas Importantes"></i><i  title="Entrega de Tareas"></i><i  title="Aleta de Tareas"></i>
                <i class="fas fa-tasks icono" title="Agrega SubTareas"></i><!-- <i class="fas fa-align-justify icono"></i> -->
                </div></li>
                <div class = 'subtareas ocultar' id= "subtareas${idtarea}">
                    <ul id = "subtareaAgregadas${idtarea}">
                        <div class='subavance'>
                            <spam>SubAvance:</spam>
                            <div class="subbarra-avance" id="subbarra-avance${idtarea}">
                              <div class="subporcentaje" id="subporcentaje${idtarea}">
                               </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        `;
        /*var listaTareas = document.querySelector("#tareaAgregadas"); 
        console.log(listaTareas);     
        var theFirstChild = listaTareas.firstChild;
        console.log(theFirstChild);
        listaTareas.insertBefore(nuevoTarea,theFirstChild);*/
        var tareasAgr = $('#tareaAgregadas').html();
        $('#tareaAgregadas').html(nuevoTarea + tareasAgr);
      Swal.fire({
        title: 'Tarea Agregada',
        text: 'La Tarea se creó correctamente',
        icon: 'success'
      })
      $('#nuevo-tarea').val('');
      document.getElementById('inpcomiteTarea').value = idtarea;
      //location.reload(); //Desactivar en caso de que surja conflicto. Sin recargar se bloquea la selección del fondo verde
     //actualizaBarra();
     //$(".modalAgregaComite").fadeIn(); 
    }
  }
  //Enviar el request
  xhr.send(datos);
  }
  
}
/************************************************* */
function muestraspiner(){
  const spiner = document.querySelector('#momento');
  spiner.style.display = 'block';
  spiner.classList.remove("hidden");
  return;
 }
 /********************************************************** */
 function muestraspiner2(){
  const spiner = document.querySelector('#momento2');
  spiner.style.display = 'block';
  return;
 }
 function muestraspiner3(){
  const spiner = document.querySelector('#momento3');
  spiner.style.display = 'block';
  return;
 }
 /******************************************************* */
 function muestraspinerF($muestra){
  //console.log('muestra');
  const spiner = document.querySelector($muestra);
  //console.log(spiner);
  spiner.style.display = 'block';
  spiner.classList.remove("hidden");
  return;
 }
 /********************************************************** */
 function borraspinerF($muestra){
  const spiner = document.querySelector($muestra);
  spiner.style.display ='none';
  spiner.classList.add("hidden");
  return;
 }
  /********************************************************** */
  function borraspiner(){
    const spiner = document.querySelector('#momento');
    spiner.style.display ='none';
    return;
   }
   /********************************************************** */
  function borraspiner2(){
    const spiner = document.querySelector('#momento2');
    spiner.style.display ='none';
    return;
   }
    /********************************************************** */
  function borraspiner3(){
    const spiner = document.querySelector('#momento3');
    spiner.style.display ='none';
    return;
   }

/********************************************************** */
function verInvitadosAgregados()
{document.getElementById('tabla-empleados').innerHTML='';
                      for(let j of invitadosVarGlobal)
                  {
                    var fila="<tr><td>"+j.idPersona+"</td><td>"+j.nombres+"</td><td>"+j.EMail1+"</td><td>"+j.clasificacion+"</td><td id ='"+j.nombres+"'><a class='btn-agregar btn' id='"+j.idPersona+"' name='"+j.clasificacion+"'><i  class='far fa-check-circle completo'></i> </a></td></tr>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tabla-empleados").appendChild(btn);
                  }
                  console.log(invitadosVarGlobal);
}

function agregaPersona(e)
{
  e.preventDefault();
  //console.log(e);
  vidsubventa=e.target.parentElement.parentElement.parentElement.parentElement;
  var idtarea = e.target.parentElement.parentElement; 
  var nombretarea = idtarea.childNodes[0].textContent;
  var hast = e.target.classList.contains('fa-check-circle');
  var nombreNodo =e.target; 
  $("#idTarea").val(idtarea.id);
  $("#nombreTarea").val(nombretarea);
  $("#inpsubtarea").val(idtarea.id);
  var idmenu = nombreNodo.parentElement.id;
    //console.log(nombreNodo);
  //agregaAlerta
 //Agrega Comite
 if(idmenu.includes("comite"))
  {
   
    nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var idventana = document.getElementById('V'+divhijo);
    idventana.classList.add('ocultar');
    var terminado = document.getElementById(divhijo);
    console.log(terminado.children[2]);
      if(terminado.children[2].childNodes[1].classList.contains('fa-check-circle') )
      {
        $(".modalAgregaComite").fadeIn(); 
        document.getElementById('comiteTarea').innerHTML = terminado.childNodes[1].textContent;
        document.getElementById('inpcomiteTarea').value = terminado.id;
      }
     else{
      Swal.fire('¡Espera!','La tarea no esta completada','warning')
     }
    return;
  }   
 if(idmenu.includes("opcionComentarios"))
  {
   // console.log('entro')
    nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);  
   var divalerta = document.getElementById(divhijo);
   divcolor= divcolor.children[2]; 
   divcolor= divcolor.children[3];
  
   
   return;
  }
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
    var idventana = document.getElementById('V'+divhijo);
      idventana.classList.add('ocultar');
    $(".modalAlerta").fadeIn();
    document.getElementById("textoAlerta").textContent  =  divalerta.children[1].textContent;;
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
                //console.log(respuesta);
                 if(respuesta=== null)
                 {
                //  console.log(respuesta);
                  var fecha = new Date();
                  var mes = fecha.getMonth()+1; //obteniendo mes
                   var dia = fecha.getDate(); //obteniendo dia
                  var ano = fecha.getFullYear(); //obteniendo año
                  var fechatarea = new Date();
                  $('#fechaAlerta').val(ano+"-"+mes+"-"+dia);
                 }
                 else{
                 $('#fechaAlerta').val(respuesta['fechaalerta']);
                  $('#periodoAlerta').val(respuesta['tipoalerta']);
                 }
              }
            }
            xhr.send(datos);

                 
   return;
  }
 
 //Agrega usuarios
 if(idmenu.includes("agrega-Usario")) //Modificado [Suemy][2024-03-13]
  {
    nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);
   //console.log(divhijo);  
     //$(".modalTareas").fadeIn();
        $("#ModalAgregarResponsable").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    document.getElementById("titulo-Tarea").innerHTML  = divcolor.children[1].innerHTML;
    //var idtar = divhijo;//getParameterByName('idTarea');
    document.querySelector("#idTarea").value = divhijo;
     if(divhijo > 0)
     {
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',divhijo);
            datos.append('idproyecto',getParameterByName('idproyecto'));
            xhr.open('POST',"<?php echo base_url();?>cproyecto/devuelveEmpleados",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta);
                var responsable ="";
                var lis = document.querySelectorAll('#ullistaEmpleados li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
                //console.log(respuesta);
                for(let i = 0; i < respuesta.tareas.length; i++) {
                    if(respuesta.tareas[i].tipo == 'CLIENTE')
                    {
                      if(respuesta.tareas[i].responsable == 1)
                      {                                     
                       $("#ullistaEmpleados").append("<li> "+respuesta.tareas[i].correo +"---"+respuesta.tareas[i].correo+"<div><button class='btn btn-primary-two' id=p"+respuesta.tareas[i].idptarea+"><i class='fas fa-check completo'></i></button> <button id='"+respuesta.tareas[i].idptarea+ "' class ='btn btn-danger eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></div></li>");
                       responsable = responsable+respuesta.tareas[i].correo+" ";
                      }
                      else{
                        $("#ullistaEmpleados").append("<li> "+respuesta.tareas[i].correo +"---"+respuesta.tareas[i].correo+"<div><button class='btn btn-primary-two' id=p"+respuesta.tareas[i].idptarea+"><i class='fas fa-check '></i></button> <button id='"+respuesta.tareas[i].idptarea+ "' class ='btn btn-danger eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></div></li>"); 
                      }
                    }
                    else{
                      if(respuesta.tareas[i].responsable == 1){
                          $("#ullistaEmpleados").append("<li> "+respuesta.tareas[i].nombre +"---"+respuesta.tareas[i].correo+"<div><button class='btn btn-primary-two' id=p"+respuesta.tareas[i].idptarea+"><i class='fas fa-check completo'></i></button>  <button id='"+respuesta.tareas[i].idptarea+ "' class ='btn btn-danger eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></div></li>");
                          responsable = responsable+respuesta.tareas[i].correo+" "; 
                       }
                      else
                      $("#ullistaEmpleados").append("<li> "+respuesta.tareas[i].nombre +"---"+respuesta.tareas[i].correo+"<div><button class='btn btn-primary-two' id=p"+respuesta.tareas[i].idptarea+"><i class='fas fa-check'></i></button>  <button id='"+respuesta.tareas[i].idptarea+ "' class ='btn btn-danger eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></div></li>");    
                    }
                  }
                  let invitados=respuesta.invitados;
                  let invitadosTotal=respuesta.invitados.length;
                  document.getElementById('invitatosTotalSup').innerHTML=invitadosTotal;
                  (invitadosTotal>0)? invitadosVarGlobal=respuesta.invitados : invitadosVarGlobal='';
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
 if(idmenu.includes("elimina-Tareas")) //Modificado [Suemy][2024-03-13]
  {
   // console.log('entro');
   nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);  
   var nuev =  'subbarra-avance'+ divhijo;
    var subelimina = document.getElementById(nuev).parentElement;
    console.log(divhijo);
    Swal.fire({
     title: '¿Deseas borrar el registro?',
     text:'Se eliminará la Tarea del Proyecto',
     icon: 'warning',
     showCancelButton:true, 
     confirmButtonColor:'#3085d6',
     cancelButtonColor:'#d33',
     confirmButtonText:'Eliminar',
     cancelButtonText:'Cancelar'
   }).then((result)=>{
     if(result.value){
      var xhr = new XMLHttpRequest();
      var datos = new FormData();
      datos.append('idTarea',divhijo);
      xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminaTarea",true);
      xhr.onload=function()
       {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
               // console.log(respuesta);
                if(respuesta =="ELIMINADO")
                {
                /*var eliminar = document.getElementById(divhijo);  
                 //console.log(eliminar);
                 var idventana = document.getElementById('V'+divhijo);
                 idventana.classList.add('ocultar');
                 eliminar.remove();
                 subelimina.remove();*/
                 var t = document.getElementById(divhijo+'DivRespon');
                 var a = document.getElementById('seg'+divhijo);
                 var s = document.getElementById(divhijo+'DivSub');
                 t.remove();
                 a.remove();
                 s.remove();
                 actualizaBarra();
                 Swal.fire(
                  '¡Eliminado!',
                   'La Tarea ha sido eliminada.',
                  'success',
                   )
                }
                else{
                  Swal.fire(
                       '¡Incorrecto!',
                       'El usuario no puede eliminar tareas',
                     'warning'
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
  if(idmenu.includes("importanteTareas")) //Modificado [Suemy][2024-03-13]
  {
   nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);   
    divcolor= divcolor.children[2];  
    divcolor= divcolor.children[2];
    divcolor.classList.add('far');
    divcolor.classList.add('fa-star');
    divcolor.classList.add('estrella');
    var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',divhijo);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/tareaEstrella",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                if(respuesta == 1)
                {
                  
                  divcolor.classList.add('far');
                  divcolor.classList.add('fa-star');
                  divcolor.classList.add('estrella');
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se agregó Estrella a la Tarea',
                   icon: 'success'
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
                   text: 'Se agregó Estrella a la Tarea',
                   icon: 'success'
                  })

                }
                if(respuesta == 2)
                {
                  e.target.classList.remove('estrella');
                  e.target.classList.add('icono');
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se quitó la Estrella a la Tarea',
                   icon: 'success'
                  })
                }
                var idventana = document.getElementById('V'+divhijo);
                    idventana.classList.add('ocultar');
              
              }
            }
            xhr.send(datos);
            var idventana = document.getElementById('V'+divhijo);
                    idventana.classList.add('ocultar');
            return;
  }

  if(e.target.classList.contains('fa-star')) //Modificado [Suemy][2024-03-13]
  {
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',idtarea.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/tareaEstrella",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                if(respuesta == 1)
                {
                  e.target.classList.remove('icono');
                  e.target.classList.add('estrella');
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se agregó Estrella a la Tarea',
                    icon: 'success'
                  })

                }
                if(respuesta == 3)
                {
                  e.target.classList.remove('icono');
                  e.target.classList.add('estrella');
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se agregó Estrella a la Tarea',
                    type: 'success'
                  })

                }
                if(respuesta == 2)
                {
                  e.target.classList.remove('far');
                  e.target.classList.remove('fa-star');
                  e.target.classList.remove('estrella');
                  Swal.fire({
                  title: 'Tarea Estrella',
                   text: 'Se quitó la Estrella a la Tarea',
                    icon: 'success'
                  })                  
                }
              }
            }
            xhr.send(datos);
     return;
  }
  //termina tarea importantes
 

 //AgendaTareas
 if(idmenu.includes("agendaTareas"))
 {
  nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
  nombrehijo =nombreIconos.id; 
  var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);   
   divcolor= divcolor.children[2];  
   divcolor= divcolor.children[0];
   $("#idTareaFecha").val(divhijo);
   $(".modalFecha").fadeIn();
   var tareaMenu =  document.getElementById(divhijo);   
   //console.log(tareaMenu.children[1]);
   document.getElementById("textoFechamostrar").textContent  =tareaMenu.children[1].textContent;
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

 if(idmenu.includes("completados")) //Modificado [Suemy][2024-03-13]
 {
   nombreIconos = nombreNodo.parentElement.parentElement.parentElement.parentElement.parentElement;
   nombrehijo =nombreIconos.id; 
   var strcadena = nombrehijo.split("V");
   var divhijo = strcadena[1];
   var divcolor = document.getElementById(divhijo);   
   divcolor= divcolor.children[2];  
   var idventana = document.getElementById('V'+divhijo);    
  // console.log('entro');
   var xhr = new XMLHttpRequest();
            var datos = new FormData();
            tareaCompleta = divcolor.children[0];
            var idproyecto = getParameterByName('idproyecto');
            datos.append('idproyecto',idproyecto);
            datos.append('idtarea',divhijo);
            muestraspiner();
            xhr.open('POST',"<?php echo base_url();?>cproyecto/tareaCompletada",true);
            xhr.onload=function()
            {
            
              if(this.status === 200)
              {
                borraspiner();
                var respuesta = JSON.parse(xhr.responseText)
                if(respuesta == 0)
                {
                  tareaCompleta.classList.remove('terminado');
                  tareaCompleta.classList.remove('far');
                  tareaCompleta.classList.remove('fa-check-circle');
                  tareaCompleta.classList.remove('icono');
                  Swal.fire({
                  title: 'Tarea Activada',
                   text: 'Se Ha Activado Nuevamente La Tarea',
                    icon: 'success'
                  })
                  valuePause(divhijo,0);
                }
                if(respuesta == 1)
                {
                  
                  tareaCompleta.classList.add('terminado');
                  tareaCompleta.classList.add('far');
                  tareaCompleta.classList.add('fa-check-circle');
                  tareaCompleta.classList.add('icono');
                  Swal.fire({
                  title: 'Tarea Completada',
                   text: 'Se Ha Completado La Tarea',
                    icon: 'success'
                  })
                  valuePause(divhijo,1);
                                        
                }
                actualizaBarra();
             
                  var idventana = document.getElementById('V'+divhijo);
                    idventana.classList.add('ocultar');           
              }
            }
            quitaVentana('V'+divhijo) ;
            xhr.send(datos);
               
  return;
 }
//Agregamos que la tarea esta acompletada
if(e.target.classList.contains('fa-check-circle')) //Modificado [Suemy][2024-03-13]
  {
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
                 // console.log(e.target.classList);
                  Swal.fire({
                  title: 'Tarea Activada',
                   text: 'Se Ha Activado Nuevamente La Tarea',
                   icon: 'success'
                  })
                  valuePause(idtarea.id,0);
                }
                if(respuesta == 1)
                {
                  
                  e.target.classList.add('terminado');
                  Swal.fire({
                  title: 'Tarea Completada',
                   text: 'Se Ha Completado La Tarea',
                   icon: 'success'
                  })

                    valuePause(idtarea.id,1);
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
  //console.log(idventana);
  var sventana = document.querySelectorAll('.ventana');
   var band =false;
   //console.log(sventana);
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
                 // console.log(respuesta);
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
                // console.log( $('#subfechaTarea').val());
                 // console.log( ano+"-"+mes+"-"+dia);

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
               // console.log(respuesta);
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
    //console.log(idtarea.id);
    var idtar = e.target.parentElement.parentElement.parentElement.parentElement.parentElement;
    var tareapapa=idtar.childNodes[1].id;
    var idsub =  e.target.parentElement.parentElement;
    $("#nombresubTarea").val(idsub.textContent);
    $("#idTar").val(tareapapa);
    $("#idsubTar").val(idsub.id);
    $('.modalusuariosubTareas').fadeIn();
   // console.log(idsub.id);
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
                  //console.log(respuesta);
                var lis = document.querySelectorAll('#ullistasubEmpleados li'); 
                 for(var i=0; li=lis[i]; i++) { 
                li.parentNode.removeChild(li); 
                } 
               // console.log(respuesta);
                //console.log(respuesta.externos.length);
                  for(let i = 0; i < respuesta.externos.length; i++) {
                    if(respuesta.externos[i].tipo == 'CLIENTE')
                    {
                      
                      if(respuesta.externos[i].responsable == 1)
                        $("#ullistasubEmpleados").append("<li> "+respuesta.externos[i].correo +"---"+respuesta.externos[i].correo+"<div><button id='r"+respuesta.externos[i].idpsubtareas+ "'<i class='fas fa-check completo'></i></button> <button id='"+respuesta.externos[i].idpsubtareas+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></div></li>");
                      else  
                      $("#ullistasubEmpleados").append("<li> "+respuesta.externos[i].correo +"---"+respuesta.externos[i].correo+"<div><button id='r"+respuesta.externos[i].idpsubtareas+ "'<i class='fas fa-check'></i></button> <button id='"+respuesta.externos[i].idpsubtareas+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></div></li>");
                    }
                    else{
                     
                      if(respuesta.externos[i].responsable == 1)
                      $("#ullistasubEmpleados").append("<li> "+respuesta.externos[i].nombre +"---"+respuesta.externos[i].correo+" <div><button id='r"+respuesta.externos[i].idpsubtareas+ "'<i class='fas fa-check completo'></i></button> <button id='"+respuesta.externos[i].idpsubtareas+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></div></li>");
                      else    
                      $("#ullistasubEmpleados").append("<li> "+respuesta.externos[i].nombre +"---"+respuesta.externos[i].correo+" <div><button id='r"+respuesta.externos[i].idpsubtareas+ "'<i class='fas fa-check '></i></button> <button id='"+respuesta.externos[i].idpsubtareas+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></div></li>");
                    }
                    /* if(respuesta[i].tipo == 'CLIENTE')
                    {
                      $("#ullistasubEmpleados").append("<li> "+respuesta[i].correo +"---"+respuesta[i].correo+" <button id='"+respuesta[i].idpsubtareas+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                    }
                    else{
                    $("#ullistasubEmpleados").append("<li> "+respuesta[i].nombre +"---"+respuesta[i].correo+" <button id='"+respuesta[i].idpsubtareas+ "' class ='eliminaInvitado basura'  onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                    }*/
                  }
              }
            }
            xhr.send(datos);
      }
      return;
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
    //console.log(idtarea);
   
      $("#modalsubTareas").fadeIn();
   var sventana = document.querySelectorAll('.ventana');

   for (var i=0; i < sventana.length;i++) 
    {
      if(!sventana[i].classList.contains('ocultar'))
     {
       sventana[i].classList.add('ocultar'); 
     }
    } 
    
  }
  if(e.target.classList.contains('fa-clock'))
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
   /*if(nombreNodo.parentElement.parentElement.children[0].children[1].nodeName=="P")
  {
    //console.log(e.target.textContent);
    $(".modalVisualiza").fadeIn();
    document.getElementById("textoMostrar").textContent  = e.target.textContent;
    return;
  }*/
}
/********************************************************** */
function grabasubAlerta(e)
{
  e.preventDefault();
  //console.log("Graba Fecha");
  //var idtarea=document.querySelector('#idTareaFecha'); 
  var fechaTarea=document.querySelector('#fechasubAlerta'); 
  var alertaTarea=document.querySelector('#idTareasubAlerta'); 
  var listaTareas = document.querySelector("#periodosubAlerta");
  var tarea = e.target.parentElement.parentElement.children[3].children[1].textContent;
 //  console.log(fechaTarea.value);
  // console.log(e.target.parentElement.parentElement.children[3].children[1].textContent);
  var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',alertaTarea.value);
            datos.append('fecha',fechaTarea.value);
            datos.append('tipo',listaTareas.value);
            datos.append('tarea',tarea);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/grabasubAlertaTarea",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                // console.log(respuesta);
                   
              }
            }
            xhr.send(datos);
            Swal.fire({
                  title: 'Alerta',
                   text: 'Se Grabado la Alerta',
                    type: 'success'
                  })  
                  $(".modalsubAlerta").fadeOut();    
                  
                 return;    
}
/********************************************************** */
function grabaAlerta(e)
{
  e.preventDefault();
  var fechaTarea=document.querySelector('#fechaAlerta'); 
  var alertaTarea=document.querySelector('#idTareaAlerta');
  var idtarea = document.getElementById(alertaTarea.value);
  let idproyecto = getParameterByName('idproyecto'); 
  var listaTareas = document.querySelector("#periodoAlerta");
    console.log(alertaTarea.value, fechaTarea.value, idproyecto, listaTareas.value);
  if(fechaTarea.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita una fecha',
        icon: 'warning'
      })  
      return;            
  }
  if(listaTareas.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita un periodo',
        icon: 'warning'
      })  
      return;            
  }
  if(idproyecto =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'Debes seleccionar un proyecto',
        icon: 'warning'
      })  
      return;            
  }
 
var hijos =  idtarea.children[2] ;
  muestraspinerF("#momento-alerta");
        var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',alertaTarea.value);
            datos.append('fecha',fechaTarea.value);
            datos.append('idproyecto',idproyecto);
            datos.append('tipo',listaTareas.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaAlertaTarea",true);
            xhr.onload=function()
            {
              borraspinerF("#momento-alerta");
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta) 
                var subhijos = idtarea.children[2];
                console.log(subhijos.children);
                 if(!subhijos.children[4].classList.contains('fa-clock'))
                 {
                  subhijos.children[4].classList.add('fas');
                  subhijos.children[4].classList.add('fa-clock');
                  subhijos.children[4].classList.add('icono');
                  //idtarea.children[2].classList.add('fas');
                   //idtarea.children[2].classList.add('fa-stopwatch');
                   //idtarea.children[2].classList.add('icono');
                 }  
              }
            }
            xhr.send(datos);
            Swal.fire({
                  title: 'Alerta',
                   text: 'Se modificado la Alerta',
                    icon: 'success'
                  })                    
                  $(".modalAlerta").fadeOut();  
                               
   return;
 // console.log("Graba Fecha");
  //var idtarea=document.querySelector('#idTareaFecha'); 
 /*var fechaTarea=document.querySelector('#fechaAlerta'); 
  var alertaTarea=document.querySelector('#idTareaAlerta');
  var idtarea = document.getElementById(alertaTarea.value);
var hijos =  idtarea.children[2] ;
 //  console.log(hijos.children[3]);
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
                 var subhijos = idtarea.children[2];
                 //console.log(subhijos.children[3]);
                 if(!subhijos.children[3].classList.contains('fa-stopwatch'))
                 {
                   idtarea.children[2].classList.add('fas');
                   idtarea.children[2].classList.add('fa-stopwatch');
                   idtarea.children[2].classList.add('icono');
                 }  
              }
            }
            xhr.send(datos);
            Swal.fire({
                  title: 'Alerta',
                   text: 'Se Grabado la Alerta',
                    type: 'success'
                  })  
                  $(".modalAlerta").fadeOut();    
   return;  
   */             
}
/********************************************************** */
function eliminasubFecha(e)
{
  e.preventDefault(e);
 
  var fechaTarea=document.querySelector('#subfechaTarea'); 
  var alertaTarea=document.querySelector('#idTareasubFecha');
  var idtarea = document.getElementById(alertaTarea.value);
  let idproyecto = getParameterByName('idproyecto'); 
  var listaTareas = document.querySelector("#periodosubFecha");
  var subtarea = idtarea.textContent;
 // console.log(subtarea);
  if(fechaTarea.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita una fecha',
        type: 'success'
      })  
      return;            
  }
  if(listaTareas.value =="")
  {
    Swal.fire({
      title: 'Alerta',
       text: 'La Alerta necesita un periodo',
        type: 'success'
      })  
      return;            
  }
  muestraspinerF("#momento-subfecha");
  var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('idtarea',alertaTarea.value);
  datos.append('idproyecto',idproyecto);
  datos.append('fecha',fechaTarea.value);
  datos.append('subtarea',subtarea);
  xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminasubFecha",true);
  xhr.onload=function()
  {
    borraspinerF("#momento-subfecha");
    if(this.status === 200)
    {
      var respuesta = JSON.parse(xhr.responseText);
      //console.log(respuesta);
       Swal.fire({
        title: 'FechaEntrega',
         text: 'Se Eliminado la Fecha de Entrega',
          type: 'success'
        })   
      //console.log(respuesta);
       var subhijos = idtarea.children[1];
      // console.log(subhijos.children[4]);
       if(subhijos.children[4].classList.contains('fa-calendar-check'))
       {
         //idtarea.children[4].classList.remove('far');
         //idtarea.children[4].classList.remove('fa-calendar-check');
         subhijos.children[4].classList.remove('cafe');
         subhijos.children[4].classList.add('icono');
       } 
       $('.modalsubFecha').fadeOut(); 
    }
  }
  xhr.send(datos);
 return;

}
/********************************************************** */
function eliminasubEmpleado(e)
{
  e.preventDefault(); 
  var idtarea = e.target.parentElement;
 // console.log( e.target);

  if(e.target.classList.contains('fa-check'))
  {
    var responsable =e.target.id;
    //console.log(responsable);
    var strcadena = responsable.split("r");
    var core = e.target.parentElement.parentElement.childNodes[0];
    var strres = core.textContent.split("-");
    console.log(strcadena[1]);
    muestraspinerF("#momento-usuarioSubtarea"); 
    var xhr = new XMLHttpRequest();
        var datos = new FormData();
            datos.append('idsubtarea',strcadena[1]);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/responsablesubEmpleado",true);
            xhr.onload=function()
            {
              borraspinerF("#momento-usuarioSubtarea"); 
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                // console.log(respuesta);
                //borraspinerF("#momento-usuarioSubtarea"); 
                Swal.fire({
                  title: 'Responsable SubTarea',
                  text: 'Se le  ha agregado Responsable a'+strres[0],
                  type: 'success'
                })
               //  console.log(respuesta);                
                var lis = document.querySelectorAll('#ullistasubEmpleados li'); 
                        for(var i=0; li=lis[i]; i++) { 
                          //console.log(li.children[0].children[0].id);   
                          if(responsable === li.children[0].children[0].id)
                          {
                            if(!li.children[0].children[0].classList.contains('completo'))
                               li.children[0].children[0].classList.add('completo');
                               else
                               li.children[0].children[0].classList.remove('completo');
                            //console.log('clci aqui');
                            //enviaCorreo();
                          }
                          /*else
                          {
                            li.children[0].children[0].classList.remove('completo');
                          }*/
                         }
              }
            }
      xhr.send(datos);        
    //console.log(responsable);
    //console.log(strcadena);
    //console.log(core);
    //console.log(strres);
   // xhr.send(datos);
      return;
  }    
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
        //console.log(idtarea.id);
        eliminar.remove();
       var xhr = new XMLHttpRequest();
        var datos = new FormData();
            datos.append('idEmpleado',idtarea.id);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminasubEmpleado",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                 //console.log(respuesta);                
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
  return;
}
/********************************************************** */

function eliminaEmpleado(e) //Modificado [Suemy][2024-03-13]
{
  e.preventDefault(); 
  var idtarea = e.target.parentElement;
    var tarea = document.getElementById('idTarea').value;

  if(e.target.classList.contains('fa-check'))
   {
     //console.log(e.target);
     var nombre =document.getElementById("titulo-Tarea").innerHTML;
     var idproyecto =  document.querySelector("#idTarea").value;
     var representante = e.target.parentElement.id;
     var strcadena = representante.split("p");
     var tareaPro =  document.querySelector("[id='"+idproyecto+"']");
     console.log(strcadena[1]);
     var core = e.target.parentElement.parentElement.parentElement.childNodes[0];
     var strres = core.textContent.split("-");
    // console.log(strres)
    let ban=0;
    if(e.target.classList.contains('completo'))
    {
      ban=1;
    }
    else
    {
      ban=0;
    }
    var xhr = new XMLHttpRequest();
    var datos = new FormData();
    datos.append('responsable',strcadena[1]);
    datos.append('actualiza',ban);
    datos.append('nombre',nombre);
    datos.append('correo',+strres[0]);
    datos.append('idproyecto',idproyecto);
    datos.append('idtarea',tarea);
    xhr.open('POST',"<?php echo base_url();?>cproyecto/responsableTarea",true);
    xhr.onload=function()
    {
      if(this.status === 200)
      {
        var respuesta = JSON.parse(xhr.responseText);
        console.log(respuesta);
        var enunciado ="";
        for(var j =0; j < respuesta.length; j++){
          enunciado =enunciado+" "+ respuesta[j].correo;
        }
        if(respuesta.length == 0)
        document.querySelector("#titulo-Tarea").innerHTML ="Proyecto:"+nombre+"- Responsables:"+enunciado; 
        else
        document.querySelector("#titulo-Tarea").innerHTML ="Proyecto:"+respuesta[0].tareas+"- Responsables:"+enunciado; 
        tareaPro.childNodes[1].innerHTML ="";
        if(respuesta.length == 0)
        tareaPro.childNodes[1].innerHTML = "Proyecto:"+nombre+"- Responsables:"+enunciado; 
        else
        tareaPro.childNodes[1].innerHTML = "Proyecto:"+respuesta[0].tareas+"- Responsables:"+enunciado; 
        //document.querySelector("#barraTarea").innerHTML ="Proyecto:"+nombre+"- Responsables:"+enunciado; 
        if(ban == 0)
        {
        Swal.fire({
          title: 'Responsable Proyecto',
          text: 'Se ha agregado al Responsable '+strres[0],
          icon: 'success'
        })
        }
        else{
          Swal.fire({
            title: 'Responsable Proyecto',
            text: 'Se ha quitado al Responsable '+strres[0],
            icon: 'success'
          })
        }
        var lis = document.querySelectorAll('#ullistaEmpleados li'); 
        for(var i=0; li=lis[i]; i++) { 
         // console.log(li.children[0].children[0].children[0]);
         if(representante === li.children[0].children[0].id)
          {
            if(ban == 0)
            {
            li.children[0].children[0].children[0].classList.add('completo');
            }
            else{
              li.children[0].children[0].children[0].classList.remove('completo');
            }
          }         
         }
        }
      }
     xhr.send(datos);
     return;



   }  
  if(e.target.classList.value=='fas fa-trash-alt')
  {
    //console.log('Hiciste clic en eliminar');
    Swal.fire({
     title: '¿Deseas borrar el registro?',
     text:'Se borrará el empleado de la Tarea',
     icon: 'warning',
     showCancelButton:true, 
     confirmButtonColor:'#3085d6',
     cancelButtonColor:'#d33',
     confirmButtonText:'Eliminar',
     cancelButtonText:'Cancelar'
   }).then((result)=>{
     if(result.value){
        var eliminar = e.target.parentElement.parentElement.parentElement;
        //console.log(eliminar);
        var xhr = new XMLHttpRequest();
        var datos = new FormData();
            datos.append('idEmpleado',idtarea.id);
            datos.append('idtarea',tarea);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/eliminaEmpleado",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                console.log(respuesta);     
                eliminar.remove();           
              }
            }
      xhr.send(datos);
       Swal.fire(
         '¡Borrado!',
         'El Invitado ha sido borrado',
         'success'
       )
     }
   })

  }
  return;
}
/********************************************************** */

/********************************************************** */
  function agregaExterno(e){
  e.preventDefault();
  console.log(e);
  var idproyecto = getParameterByName('idproyecto');
  var tarea = document.getElementById('idTarea').value;
  var nomurl ="<?php echo base_url();?>"+ "cproyecto/muestraProyectosExternos?idproyecto=" + idproyecto;
  if(e.target.classList.value=='fas fa-user-plus fa-x icono2')
  {

    var invitado =document.querySelector('#invitadoExterno').value;
    if(invitado == '')
    {
      document.getElementById('invitadoExterno').focus();
      Swal.fire(
         'Correo!',
         'El correo está vacío',
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
            datos.append('idproyecto',idproyecto);
            datos.append('idtarea',tarea);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/agregaInvitadoextra",true);
            xhr.onload=function()
            {
             
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                var accion = respuesta.respuesta;
                var tiporespuesta =respuesta.tipoerror;
                console.log(respuesta);
                if(accion == 'error'){Swal.fire('Mensaje de Advertencia',tiporespuesta ,"warning");}
                else{
                  $("#ullistaInvitado").append("<li> "+invitado +"---"+invitado+" <div><button class='btn btn-primary-two' id='p"+respuesta['idproyecto']+"' style =' margin-right:3px;'><i class='fas fa-check '></i></button><button class ='btn btn-danger eliminaInvitado' id='"+respuesta['idproyecto']+"' onclick=''><i class='fas fa-trash-alt'></i></button></div></li>");
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
         'El correo está incorrecto',
         'warning'
      ); 
      }
    } 
   }
  else{
    //console.log('no al icono');
   }

}
/*********************************************************************** */
function subtareaExterno(e){
  e.preventDefault();
 // console.log(e.target.classList);
  var idproyecto = getParameterByName('idproyecto');
  //console.log(idproyecto);
  var nomurl ="<?php echo base_url();?>"+ "cproyecto/muestraProyectosExternos?idproyecto=" + idproyecto;
  if(e.target.classList.value=='fas fa-user-plus fa-x icono')
  {
    //console.log('Hiciste Clic al icono');
    var invitado =document.querySelector('#tareasubExterno').value;
   // console.log(invitado);
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
     // console.log(valida);
    
      if(valida == 'T')
      {
         //Agregamos el Cliente Extra
         $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $password = "";
            for($i=0;$i<6;$i++) {
                 $password =$password+ $str.substr(Math.random()*63,1);
              }
            var nombreTarea = document.querySelector("#nombreTarea").value;
            var idtarea = document.querySelector("#idTar").value;
            var idsubtar = document.querySelector("#idsubTar").value;
           // var idsubtar = document.querySelector("#idsubTar").value;
            /*$("#nombresubTarea").val(idsub.textContent);
    $("#idTar").val(tareapapa);
    $("#idsubTar").val(idsub.id);*/
            //var horaProy = document.querySelector("#horaProyecto").value;
           // console.log(nombreTarea);
            var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('correo',invitado);
            datos.append('contrasena',$password); 
            datos.append('nomurl',nomurl); 
            datos.append('nombreTarea',nombreTarea); 
            datos.append('id',idtarea); 
            datos.append('idsub',idsubtar); 

            xhr.open('POST',"<?php echo base_url();?>cproyecto/agregasubTareaextra",true);
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
                  $("#ullistasubEmpleados").append("<li> "+invitado +"---"+invitado+" <button class ='eliminaInvitado basura' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                   Swal.fire('Mensaje de Confirmacion',"Se Invito A : "+invitado,"success");
                }
              }
            }
            xhr.send(datos);
           
      }
      else{

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
function tareaExterno(e){ //Modificado [Suemy][2024-03-13]
  e.preventDefault();
  //console.log(e.target.classList);
  var idproyecto = getParameterByName('idproyecto');
  var nomurl ="<?php echo base_url();?>"+ "cproyecto/muestraProyectosExternos?idproyecto=" + idproyecto;
  if(e.target.classList.value=='fas fa-user-plus fa-x icono2')
  {
    //console.log('Hiciste Clic al icono');
    var invitado =document.querySelector('#tareaExterno').value;
    if(invitado == '')
    {
      document.getElementById('invitadoExterno').focus();
      Swal.fire(
         '¡Espera!',
         'El correo está vacío',
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
                  $("#ullistaEmpleados").append("<li> "+invitado +"---"+invitado+" <button class ='btn btn-danger eliminaInvitado basura' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                   Swal.fire('Mensaje de Confirmacion',"Se Invitó A : "+invitado,"success");
                }
              }
            }
            xhr.send(datos);
            
      }
      else{
       //  var nombreProy = document.querySelector("#nombreProyecto").value;
       //console.log(nombreProy);
        Swal.fire(
         '¡Espera!',
         'El correo está incorrecto',
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


function getParameterByName(name) {
     name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
     var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
     results = regex.exec(location.search);
     return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
 /************************************************************* */  
function nuevoProyecto(e){
    e.preventDefault();
    var valor = ("#nuevo-proyecto").length;
    var contenido = $("#nuevo-proyecto").val();
    e.target.classList.add("desabilitar");
    const spiner = document.querySelector('#cargando');
    //console.log(contenido);
    if (contenido != "") 
    {    
     spiner.style.display = 'block';
     //console.log(spiner.classList);
     spiner.classList.remove("hidden");
     guardaProyecto(); 
     e.target.classList.remove("desabilitar");
     spiner.style.display ='none';
    }
    /*if (contenido != "") {  
   
  guardaProyecto(); 
  }*/

 }
 /**************************************************************** */
 function guardaProyecto() //Modificado [Suemy][2024-04-05]
{
  //console.log('hlas');
  var nombre = $("#nuevo-proyecto").val();
  //var fecha = $("#nuevo-fecha").val();
  //var hora = $("#nuevo-hora").val();
  //console.log(hora);
  var fecha = new Date();
  var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('nombre',nombre);
  datos.append('fecha',fecha);
  //datos.append('hora',hora);
  xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaProyecto",true);
  xhr.onload = function(){
    if(this.status===200){
      var respuesta =JSON.parse(xhr.responseText);
      // console.log("");
      var proyecto = respuesta.nombre_proyecto,
          idproyecto = respuesta.idproyecto;
      var nuevoProyecto = document.createElement('Li');    
        nuevoProyecto.innerHTML=`
        <div class="listaProyectos">
        <a href = "<?php echo base_url();?>cproyecto/muestraProyectos?idproyecto=${idproyecto}" id="${idproyecto}"> <i class="fas fa-list-ul"></i>
         ${proyecto}         
          </a>
          <i id = id${idproyecto} class="fas fa-calendar-check icono" title="Posfecha Proyectos..."></i>
        </div>
        `
        console.log(nuevoProyecto);
       var listaProyectos = document.querySelector("ul#proyectos");  
       listaProyectos.appendChild(nuevoProyecto);
      Swal.fire({
        title: '¡Proyecto Creado!',
        text: 'El Proyecto "'+proyecto+'" se creó correctamente',
        icon: 'success'
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
  //$(".modal").fadeIn();
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
                document.getElementById('ullistaInvitado').innerHTML='';
                  for(let i = 0; i < respuesta.length; i++) {
                    $("#ullistaInvitado").append("<li> "+respuesta[i].nombre +"---"+respuesta[i].correo+"<button id='" +respuesta[i].id +"' class ='btn btn-danger eliminaInvitado' onclick=''><i class='fas fa-trash-alt'></i></button></li>");
                  }                
              }
            }
            xhr.send(datos);
    } $("#ModalAgregarInvitados").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
  //cargamos lista de Invitado si exiten 

 }
 function cierraModalAgregaComite()
 {
  $(".modalAgregaComite").fadeOut();   
 }
 /********************************************************* */
 function cierrausuariosubtareas()
 {
  $(".modalusuariosubTareas").fadeOut(); 
 }
 /********************************************************* */
 function cierraModalComite()
 {
  $(".modalcomite").fadeOut(); 
 }
 /********************************************************* */
  function cierraModalDocumentos()
 {
  $(".modalDocumentos").fadeOut(); 
 }
 /********************************************************* */
 
 function cierraModalsubtareas()
 {
  $("#modalsubTareas").fadeOut();  
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
 function cierraModalsubalerta()
 {
  $(".modalsubAlerta").fadeOut();
 }
 /********************************************************* */
 function cierraModal()
 {
  $(".modal").fadeOut();
 }
 /********************************************************* */
 function cierraModaltareas()
 {
   let ul=Array.from(document.getElementById('ullistaEmpleados').childNodes);
   let nombreResponsable="";
   
   ul.forEach(u=>{
    if(u.nodeName=="LI"){
    let lista=Array.from(u.childNodes)
       //console.log(lista[0])
       nombreResponsable+=lista[0].data+',';
      }
   }) 
   let row=Array.from(document.getElementsByClassName('rowEscogido'));
   
   row.forEach(r=>{
    let obj=Array.from(r.childNodes[1].childNodes);

      obj.forEach(o=>{
        if(o.nodeName!="#text")
        {
          if(o.hasAttribute('data-parraforesponsable'))
            {
                let label=Array.from(o.childNodes);
   
                label.forEach(l=>{if(l.nodeName!="#text"){if(l.hasAttribute('data-responsables')){l.innerHTML=nombreResponsable}}})
            }
        }
    })
   })
   
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
  function cierraModalsubfecha()
 {
  $(".modalsubFecha").fadeOut();
 }
 /********************************************************* */
 function cierraModalPosfecha()
 {
  $(".modalposFecha").fadeOut();
 }
 /********************************************************* */
 function cierramuestraPosFecha()
 {
  $(".modalmuestraPosFecha").fadeOut();
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
   //objeto.preventDefault();
   var tipo = objeto.value;
   var xhr = new XMLHttpRequest();
   var datos = new FormData();
   //console.log(tipo);
   datos.append('strvalor',tipo);
   xhr.open('POST',"<?php echo base_url();?>asigna/GetPersonas",true);
    xhr.onload = function()
    {
      if(this.status===200)
     {       
      var respuesta =JSON.parse(xhr.responseText);
      //console.log(respuesta);
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
/********************************************************* */
function devolverPersonas3(objeto){
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
       var borratabla = document.getElementById('listado-subempleados');
       var rowCount = borratabla.rows.length; 
       for (var x=rowCount-1; x>0; x--) { 
        borratabla.deleteRow(x); 
         } 
      for(let i = 0; i < respuesta.length; i++) {
        var fila="<tr><td>"+respuesta[i]['idPersona']+"</td><td>"+respuesta[i]['nombres']+"</td><td>"+respuesta[i]['EMail1']+"</td><td>"+respuesta[i]['clasificacion']+"</td><td id ='"+respuesta[i]['nombres']+"'><a class='btn-agregar btn' id='"+respuesta[i]['idPersona']+"' name='"+respuesta[i]['clasificacion']+"'><i  class='far fa-check-circle completo'></i> </a></td></tr>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tabla-subempleado").appendChild(btn);
       }
     }   
    }
    xhr.send(datos);  
 }
 function alertaBorrado(e,objeto)
 {
  e.preventDefault();
  var confirmacion = confirm("Deseas eliminar el proyecto");
if(confirmacion){objeto.parentNode.submit()} 
 }

function devolverInvitados(datos='')
{
    if(datos=='')
    {
           params='idproyecto='+getParameterByName('idproyecto');
      controlador="cproyecto/devolverInvitados/?";
      peticionAJAX(controlador,params,'devolverInvitados');    
    }
    else
    {

      let div=''
          for (let value of datos.invitados) 
    {
       div+=`<tr><td>${value.nombre}</td><td>${value.correo}</td><td><img src="<?=base_url()?>assets/img/miInfo/userPhotos/${value.fotoUser}" style="width:50px;min-width:50px;border-radius:20%;min-height:50px;height:50px"></td></tr>`;
    }
    document.getElementById('invitadosTbody').innerHTML=div
    document.getElementById('invitadosTotalTD').innerHTML=`<label class="label label-info">TOTAL DE INVITADOS: ${datos.invitados.length}</label>`


    }
}
function verOcultarInvitados(objeto) //Modificado [Suemy][2024-03-13]
{
    //objeto.parentElement.nextElementSibling.classList.toggle('ocultarObjetoInvitados')
    $('#containerGuest').toggleClass('ocultarObjetoInvitados');
}
</script>
<?php
 function imprimirBotonera($array)
{
 $option='';
  foreach ($array as $key => $value) {$option.='<button class="btnBotonera col-grid-center" value="'.$value['Name'].'" data-tipopersona="PERSONAL" onclick="devolverPersonas(this)"><i class="fas fa-user-plus fa-2x"></i>'.$value['Name'].'</button>';}  
  $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTES" onclick="devolverPersonas(this)">Clientes</button>';
 // $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTESBUSCADOS" id="btnEncuestasAlternas" onclick="insertaEncuestasAlternas(this)">Encuestas Alternas</button>';
  return $option; 
}
function imprimirBotonera2($array)
{
 $option='';
  foreach ($array as $key => $value) {$option.='<button class="btnBotonera col-grid-center" value="'.$value['Name'].'" data-tipopersona="PERSONAL" onclick="devolverPersonas2(this)"><i class="fas fa-user-plus fa-2x"></i>'.$value['Name'].'</button>';}  
  $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTES" onclick="devolverPersonas2(this)">Clientes</button>';
 // $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTESBUSCADOS" id="btnEncuestasAlternas" onclick="insertaEncuestasAlternas(this)">Encuestas Alternas</button>';
  return $option; 
}
function imprimirBotonera3($array)
{
 $option='';
  foreach ($array as $key => $value) {$option.='<button class="btnBotonera col-grid-center" value="'.$value['Name'].'" data-tipopersona="PERSONAL" onclick="devolverPersonas2(this)"><i class="fas fa-user-plus fa-2x"></i>'.$value['Name'].'</button>';}  
  $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTES" onclick="devolverPersonas3(this)">Clientes</button>';
 // $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTESBUSCADOS" id="btnEncuestasAlternas" onclick="insertaEncuestasAlternas(this)">Encuestas Alternas</button>';
  return $option; 
}
function imprimirBotonera4($array)
{
 $option='';
  foreach ($array as $key => $value) {$option.='<button class="btnBotonera col-grid-center" value="'.$value['Name'].'" data-tipopersona="PERSONAL" onclick="devolverPersonas3(this)"><i class="fas fa-user-plus fa-2x"></i>'.$value['Name'].'</button>';}  
  $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTES" onclick="devolverPersonas3(this)">Clientes</button>';
 // $option.='<button class="btnBotonera" value="Clientes" data-tipopersona="CLIENTESBUSCADOS" id="btnEncuestasAlternas" onclick="insertaEncuestasAlternas(this)">Encuestas Alternas</button>';
  return $option; 
}

function invitadosImprimir($invitados) //Modificado [Suemy][2024-03-13]
{
    $total=count($invitados);
    $div='<table class="table table-striped" style="margin: 0px;border: 1px solid #ddd;"><thead style="position:sticky;top:0px"><tr><th>NOMBRE</th><th>CORREO</th><th>FOTO</th></tr><tr><td colspan="3" id="invitadosTotalTD"><label class="label label-info" style="background-color: #2f96b5;font-size: 11px;">TOTAL DE INVITADOS: '.$total.'</label></td></tr></thead><tbody id="invitadosTbody">';
    
    foreach ($invitados as $key => $value) 
    {
       $div.='<tr><td>'.$value->nombre.'</td><td>'.$value->correo.'</td><td><img src="'.base_url().'assets/img/miInfo/userPhotos/'.$value->fotoUser.'" style="width:50px;min-width:50px;border-radius:20%;min-height:50px;height:50px"></td></tr>';
    }
    $div.='</tbody>';
    $div.='</table>';
    return $div;

}
?>

<script type="text/javascript">

document.getElementById('filtrosTareas').addEventListener('change',obj=>{ //Modificado [Suemy][2024-03-13]

let tareas=document.getElementsByClassName('responDivCabTareas');

let contador=0;
if(obj.target.value==   'ESCOGER FILTRO'){
for(let val of tareas)
  {
    let container = val.nextElementSibling;
    //console.log(container);
    val.classList.remove('ocultarObjetoFiltrados');
    //val.nextElementSibling.classList.remove('ocultarObjetoFiltrados');
    //container.nextElementSibling.classList.remove('ocultarObjetoFiltrados');
     contador++;
   }
    //document.getElementById('filtradosTareasLabel').innerHTML=contador;
    //$('#filtradosTareasLabel').html(contador);
   return 0;
}

let filtro=obj.target.value;

let tipoFiltro=obj.target.options[obj.target.options.selectedIndex].parentElement.dataset.filtro;

//console.log(tareas);
/*for(let val of tareas)
 {  
    let container = val.nextElementSibling;
    //console.log(container);
    valor=val.getAttribute(`data-${tipoFiltro}`)
    valorArray=valor.split(';');    
    val.classList.remove('ocultarObjetoFiltrados');
    val.nextElementSibling.classList.remove('ocultarObjetoFiltrados');
    container.nextElementSibling.classList.remove('ocultarObjetoFiltrados');
    contador++;
    if(!valorArray.includes(filtro)){
        val.classList.add('ocultarObjetoFiltrados');
        val.nextElementSibling.classList.add('ocultarObjetoFiltrados');
        container.nextElementSibling.classList.add('ocultarObjetoFiltrados');
        contador--;
    }
 }*/
    //document.getElementById('filtradosTareasLabel').innerHTML=contador;
    //$('#filtradosTareasLabel').html(contador);
})
    
document.getElementById('ponerEnProduccionBTN').addEventListener('click',btn=>{
    let row=document.getElementsByClassName('rowEscogido');
   if(row.length==1)
   {
    let id=row[0].children[0].id;
          params=`idTarea=${id}&estaProduccion=1`;    
      controlador="cproyecto/ponerEnProduccion/?";
      peticionAJAX(controlador,params,'ponerEnProduccion');  
   }
   else{alert('ESCOGER UNA TAREA PARA PASAR A PRODUCCION')}
})

document.getElementById('agregarEnHistoricoBTN').addEventListener('click',btn=>{
    let row=document.getElementsByClassName('rowEscogido');
   if(row.length==1)
   {
    let id=row[0].children[0].id;
    params=`idTarea=${id}&comision=1`;    
    controlador="cproyecto/modificarHistorico/?";
    peticionAJAX(controlador,params,'modificarHistorico');  
   }
   else{alert('ESCOGER UNA TAREA PARA AGREGARLO AL HISTORICO')}
})

document.getElementById('agregarEstrellaBTN').addEventListener('click',btn=>{
    let row=document.getElementsByClassName('rowEscogido');
   if(row.length==1)
   {
    let id=row[0].children[0].id;
    let cantidadEstrellas=document.getElementById('selectEstrellasParaTareas').value;
    params=`idTarea=${id}&cantidadEstrellas=${cantidadEstrellas}`;
    controlador="cproyecto/agregarEstrellas/?";
    peticionAJAX(controlador,params,'agregarEstrellas');  
    location.reload();
   }
   else{alert('ESCOGER UNA TAREA PARA PARA AGREGAR ESTRELLAS')}
})

document.getElementById('eliminarTareaBTN').addEventListener('click',btn=>{
    let row=document.getElementsByClassName('rowEscogido');
   if(row.length==1)
   {
    let id=row[0].children[0].id;
    let cantidadEstrellas=document.getElementById('selectEstrellasParaTareas').value;
    params=`idTarea=${id}`;
    controlador="cproyecto/eliminaTarea/?";
    peticionAJAX(controlador,params,'eliminarTarea');  
   }
   else{alert('ESCOGER UNA TAREA PARA PARA AGREGAR ESTRELLAS')}
})

/*document.getElementById('historicoAcumuladoSpam').addEventListener('click',btn=>{ //Desactivado [Suemy][2024-04-05]
    $('#tabla-historico').html(`
        <tr>
            <td colspan="11">
                <div class="container-spinner-content-loading">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                    <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                </div>
            </td>
        </tr>
    `);
    params=`idProyecto=${getParameterByName('idproyecto')};`;
    controlador="cproyecto/obtenerHistoricoAcumulado/?";
    peticionAJAX(controlador,params,'mostrarHistoricoAcumulado');  
    modalmuestraTareacom.style.display='block'  
   
})*/
function mostrarHistoricoAcumulado(datos){ //Modificado [Suemy][2024-03-13]
    //console.log(datos);
    let rows='';
    if (datos != 0) {
        for(v of datos){
            let as = v.asignados;
            var title = getTextValue(v.titulo);
            var td = ``;
            var div = ``;
            for (const e in as) {
                var date = "";
                if (as[e].registro != 0) {
                    date = `<span title="Fecha Asignación">(${as[e].registro})</span>`;
                }
                td += `
                    <p><strong>${as[e].nombre_completo}</strong> ${date}</p>
                `;
                div += `
                    <p><strong>${as[e].nombres}:</strong> ${as[e].duracion_responsable}</p>
                `;
            }
            if (v.titulo == 0) { title = ""; }
            rows += `
                <tr data-id="${v.idtarea}">
                    <td>
                        <button class="btn btn-primary-two" data-tarea="${v.idtarea}" data-proyecto="${v.idproyecto}" id="btnTracking${v.idtarea}" onclick="getTableStatus(${v.idtarea})"><i class="far fa-eye"></i> Ver</button>
                    </td>
                    <td>${title}</td>
                    <td>${getTextValue(v.descripcion)}</td>
                    <td>${td}</td>
                    <td>${getTextValue(v.fecha_creacion)}</td>
                    <td>${getTextValue(v.fecha_completado)}</td>
                    <td>${getTextValue(v.fecha_produccion)}</td>
                    <td>${getTextValue(v.fecha_tareaFinalizada)}</td>
                    <td>${div}</td>
                    <td>${getTextValue(v.duracion_produccion)}</td>
                    <td>${getTextValue(v.duracion_tarea)}</td>
                </tr>
            `;
        
            // rows+=`<tr><td>${title}</td><td>${getTextValue(val.nombre)}</td><td>${getTextValue(val.tareaFechaCreacion)}</td><td>${getTextValue(val.tareaCompletada)}</td><td>${getTextValue(val.fechaDeProduccion)}</td><td>${getTextValue(val.tareaFinalizadaTiempo)}</td><td></td></tr>`;
        }
    }
    else {
        rows = `<tr><td colspan="10"><center><strong>Sin resultados</strong><center></td></tr>`;
    }
    $('#tabla-historico').html(rows);
//document.getElementById('tabla-historico').innerHTML=rows;
}

function ponerEnProduccion(datos){refrescarDatos(datos,'produccion');}
function agregarEstrellas(datos){refrescarDatos(datos,'estrellas')}
function modificarHistorico(datos){refrescarDatos(datos,'historico');alert("LA MODIFICACION SE LLEVO A CABO CORRECTAMENTE");}
function eliminarTarea(datos){refrescarDatos(datos,'eliminar');alert("LA ELIMINACION SE LLEVO A CABO CORRECTAMENTE");}

function refrescarDatos(datos='',tipoRefrescado) //Modificado [Suemy][2024-03-13]
{ 
    //console.log(tipoRefrescado, datos);
   switch(tipoRefrescado)
   {
    case 'produccion':
      if(datos.estaProduccion==1)
     {
      let img=`<img src=<?=base_url()?>assets/img/seguimiento/estaProduccion.png>`;
      document.getElementById(datos.idTarea+'DivProduccion').innerHTML=img;
      //$('#'+datos['idTarea']+'FechaProduccionLabel').html(`<strong>Hace unos momentos</strong>`);
     }
    break;
    case 'fechaEntrega':
    document.getElementById(`${datos['idTarea']}FechaEntregaLabel`).innerHTML="<strong>"+datos['fecha']+"</strong>";
    break;
    case 'fotos': 
       let insertar='';
       for(let val of datos['responsables'])
       {
         insertar+=`<div style="margin-top:10px;margin-left:10px"><img style="width:35px;min-width:35px;border-radius:20%;min-height:35px;height:35px" src="<?=base_url()?>assets/img/miInfo/userPhotos/${val.fotoUser}" title="NOMBRE:${val.nombre} EMAIL: ${val.correo}"></div>`;
       }
       document.getElementById(`${datos.idTarea}DivFotosRespon`).innerHTML=insertar;
    break;
    case 'estrellas':
    if(datos.success=='0'){alert('SOLO PUEDE DAR VALORES DE 0 A 10'); return 0;}
    document.getElementById('estrellasLabel'+datos.idTarea).innerHTML=datos.cantidadEstrellas+'&#11088';
    document.getElementById('estrellasLabel'+datos.idTarea).dataset.estrellas=datos.cantidadEstrellas;
    document.getElementById(datos.idTarea+'DivRespon').dataset.estrellas=datos.cantidadEstrellas;

    let nuevasEstrellas=document.getElementsByClassName('estrellasLabel'); //[...new Set(estrellasCantidad)];
    let estrellasArray=[];
    for(let obj of nuevasEstrellas){ estrellasArray.push(obj.dataset.estrellas)}
    estrellasArray.sort((a, b) => a - b);
    let estrellasFinal=[];
    estrellasFinal=[...new Set(estrellasArray)];
    realizaFiltrosBusqueda('grupo',estrellasFinal,'ESTRELLAS','estrellas');
    break;
    case 'historico':
     let tareaCab=document.getElementById(`${datos.idTarea}DivRespon`);
     let hermanoCab=tareaCab.nextElementSibling;
     hermanoCab.parentElement.removeChild(hermanoCab);
     tareaCab.parentElement.removeChild(tareaCab);
     refrescarDatos('','cantidad');
    break;
   case 'eliminar':   
     let tareaCabE=document.getElementById(`${datos.idTarea}DivRespon`);
     let hermanoCabE=tareaCabE.nextElementSibling;
     hermanoCabE.parentElement.removeChild(hermanoCabE);
     tareaCabE.parentElement.removeChild(tareaCabE);
     refrescarDatos('','cantidad');
    break;
    case 'cantidad':
     let cantidadTareasProyecto=document.getElementsByClassName('responDivCabTareas');
     document.getElementById('totalTareasLabel').innerHTML=cantidadTareasProyecto.length;
     let filtrados=0;
     for(let val of cantidadTareasProyecto){if(!val.classList.contains('ocultarObjeto')){filtrados++}}
     document.getElementById('filtradosTareasLabel').innerHTML=filtrados;    
    break;
        case 'pausar':
            if (datos.pausado == 1) {
                $('#'+datos.idTarea+'DivProduccion').html(`<i class="far fa-pause-circle icon-pause"></i>`);
                $('#statusTask'+datos.idTarea).html(`<i class="fas fa-play fa-x icono" title="Reanudar Tarea"></i>Reanudar Tarea`);
            }
        break;
   }

}
let enProduccion=[<?=implode(',',$enProduccion);?>];
for(let id of enProduccion)
{  
    let datosParam=[];
    datosParam['estaProduccion']=1;
    datosParam['idTarea']=id; 
   refrescarDatos(datosParam,'produccion'); 
}


    let enPausa=[<?=implode(',',$enPausa);?>]; //Creado [Suemy][2024-03-13]
        for(let id of enPausa){  
        let datosParam=[];
        datosParam['pausado']=1;
        datosParam['idTarea']=id; 
        refrescarDatos(datosParam,'pausar'); 
    }
let subTareas=document.getElementsByClassName('subtareas');
for(let val of subTareas)
{    
    let hijos=val.children[0].children
    for(let valHijos of hijos)
    {
     valHijos.classList.add('subTareaInfo');    
     valHijos.addEventListener('click',obj=>{
        let sub=document.getElementsByClassName('subTareaInfoEscogido');
        if(sub[0])
            {
                sub[0].removeAttribute('style')
                sub[0].classList.remove('subTareaInfoEscogido');
                
            }
            obj.target.setAttribute('style','overflow-y: scroll;background-color: #78a57a')
            obj.target.classList.add('subTareaInfoEscogido')
     })
    }
}

let optionEstrellas='<option value="0">Estrellas</option>';
for(let i=1;i<11;i++){optionEstrellas+=`<option class="fa" value="${i}">${i} &#11088</option>`;}
document.getElementById('selectEstrellasParaTareas').innerHTML=optionEstrellas;

let responsablesTareas=[<?=implode(',', array_unique($responsables,SORT_STRING))?>]
let fechaCreacion=[<?=implode(',',array_unique($fechaCreacion,SORT_STRING))?>]
let fechaEntrega=[<?=implode(',',array_unique($fechaEntrega,SORT_STRING))?>]
let estrellasCantidad=[<?=implode(',', array_unique($estrellasCantidad,SORT_NUMERIC))?>]
let estatusProyectosTareas=['SIN RESPONSABLES','CON RESPONSABLES','COMPLETO','PRODUCCION']

//Modificado [Suemy][2024-04-05]
estrellasCantidad.sort((a, b) => a - b);
fechaEntrega = orderDates(fechaEntrega);
//------------------------------

function realizaFiltrosBusqueda(tipoFiltro='',valores,name,nameFiltro='')
{
switch (tipoFiltro)
{
 case 'grupo':
 if(document.getElementById(nameFiltro+'optgroup')){document.getElementById(nameFiltro+'optgroup').parentElement.removeChild(document.getElementById(nameFiltro+'optgroup'))}
 let optionGrupo='';
 let optionGroup=document.createElement('optgroup')
 optionGroup.dataset.filtro=nameFiltro;
 optionGroup.id=nameFiltro+'optgroup';
for(let val of valores){optionGrupo+=`<option>${val}</option>`;}
optionGroup.innerHTML=optionGrupo;
optionGroup.label=name;
document.getElementById('filtrosTareas').appendChild(optionGroup);
 break;
 case 'individual':
  let individual=document.createElement('option');
  individual.innerHTML=name;
  document.getElementById('filtrosTareas').appendChild(individual);
 break;


}

}
 realizaFiltrosBusqueda('individual','','ESCOGER FILTRO');
 /*realizaFiltrosBusqueda('individual','','SIN RESPONSABLES');
  realizaFiltrosBusqueda('individual','','CON RESPONSABLES');
  realizaFiltrosBusqueda('individual','','COMPLETAS');
 realizaFiltrosBusqueda('individual','','EN PRODUCCION');  */
 realizaFiltrosBusqueda('grupo',estatusProyectosTareas,'ESTATUS','statustarea');
 realizaFiltrosBusqueda('grupo',responsablesTareas,'RESPONSABLES','responsables');
 realizaFiltrosBusqueda('grupo',estrellasCantidad,'ESTRELLAS','estrellas');
 realizaFiltrosBusqueda('grupo',fechaEntrega,'FECHA DE ENTREGA','fechaentrega');
 
 refrescarDatos('','cantidad');

    function abrirModalPausar(obj,id) { //Creado [Suemy][2024-03-13]
        $('#tareaEstatus option').prop('disabled',false);
        getTaskStatus(id);
        const title = $(obj).data('title');
        const status = $(obj).data('status');
        //console.log(status);
        if (status == "1") {
            $('#tareaEstatus option[value="Pausar"]').prop('disabled',true);
            $('#tareaEstatus option[value="Reanudar"]').prop('selected',true);
            $('#segTimePause').removeClass('ocultarObj');
        }
        else {
            $('#tareaEstatus option[value="Reanudar"]').prop('disabled',true);
            $('#tareaEstatus option[value="Pausar"]').prop('selected',true);
            $('#segTimePause').addClass('ocultarObj');
        }
        $('#titleModalPause').html('(<span style="font-size:13px;">'+title+'</span>)');
        $('#idTareaEstatus').val(id);
        $("#ModalPausarTarea").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    }

    function getTaskStatus(id) { //Creado [Suemy][2024-03-13]
        console.log(id);
        $.ajax({
            type: "GET",
            url: `<?=base_url()?>cproyecto/getTaskStatus`,
            data: {
                id: id
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                var trtd = ``;
                var time = 0;
                if (r != 0) {
                    let s = r[0];
                    if (s['pausado'] == 1) {
                        var pause = s['fechaPausa'];
                        var hour = new Date(pause);
                        var date = getDateFormat(pause) + " " + hour.toLocaleTimeString('en-US');
                        time = getTimeElapsedJS(pause);
                    }
                    $('#timePause').html(`Tiempo Pausado: <span>${time}</span>`);
                    $('#datePause').html(`Desde: <span>${date}</span>`);
                    $('#casePause').html(`Asunto: <span>${s['comentario']}</span>`);
                }
                //console.log(time);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }

    function getTableStatus(id) { //Creado [Suemy][2024-03-13]
        console.log(id);
        $.ajax({
            type: "GET",
            url: `<?=base_url()?>cproyecto/getTableStatus`,
            data: {
                id: id
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                var trtd = ``;
                var time = 0;
                if (r != 0) {
                    for (const a in r) {
                        trtd += `
                            <tr data-id="${r[a].id}">
                                <td>${r[a].accion}</td>
                                <td>${getTextValue(r[a].comentario)}</td>
                                <td>${getTextValue(r[a].registro)}</td>
                            </tr>
                        `;
                    }
                }
                else {
                    trtd = `<tr><td colspan="3"><center><strong>Sin resultados</strong><center></td></tr>`;
                }
                $('#bodyTableStatus').html(trtd);
                $("#ModalSeguimientoTarea").modal({
                    show: true,
                    keyboard: false,
                    backdrop: false,
                });
            },
            error: (error) => {
                console.log(error);
                $('#bodyTableStatus').html(`<tr><td colspan="3"><center><strong>Sin resultados</strong><center></td></tr>`);
            }
        })
    }

    function pauseTask() { //Creado [Suemy][2024-03-13]
        const id = document.getElementById('idTareaEstatus').value;
        const status = document.getElementById('tareaEstatus').value;
        const comment = document.getElementById('motivoEstatus').value;
        //console.log("idTarea: "+id+", Estatus: "+status+", Motivo: "+comment);
        if ($('#tareaEstatus option[value="Pausar"').prop('disabled') != true) {
            if (comment != 0) {
                savePauseStatus(id,status,comment);
            }
            else { Swal.fire('¡Espera!','Aún no escribes el motivo.','warning'); }
        }
        else {
            savePauseStatus(id,status,comment);
        }
    }

    function savePauseStatus(id,status,comment) { //Creado [Suemy][2024-03-13]
        $.ajax({
            type: "POST",
            url: `<?=base_url()?>cproyecto/saveTracking`,
            data: {
                id: id,
                st: status,
                cm: comment
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                let res = r['insert'];
                let cam = r['data'];
                var on = 0;
                var img = ``;
                var li = `<i class="fas fa-pause fa-x icono" title="Pausar Tarea"></i>Pausar Tarea`;
                if (!isNaN(res)) {
                    //swal("¡Hecho!", "Cambios realizados.", "success");
                    Swal.fire({
                        title: '¡Hecho!',
                        text: 'Cambios realizados.',
                        icon: 'success'
                    })
                    getTaskStatus(id);
                }
                if (cam['Estatus'] == "Pausar") {
                    img = `<i class="far fa-pause-circle icon-pause"></i>`;
                    li =  `<i class="fas fa-play fa-x icono" title="Reanudar Tarea"></i>Reanudar Tarea`;
                    on = 1;
                    $('#iconStatusTask'+id).addClass('fas');
                    $('#iconStatusTask'+id).addClass('fa-stopwatch');
                }
                else {                    
                    $('#iconStatusTask'+id).removeClass('fas');
                    $('#iconStatusTask'+id).removeClass('fa-stopwatch');
                }
                $('#'+id+'DivProduccion').html(img);
                $('#statusTask'+id).html(li);
                $('#statusTask'+id).attr('data-status',on);
                $('#iconStatusTask'+id).attr('data-status',on);
            },
            error: (error) => {
                console.log(error);
                Swal.fire({
                    title: '¡Vaya!',
                    text: 'Ha ocurrido un conflicto al intentar guardar.',
                    icon: 'error'
                })
            }
        })
    }

    function valuePause(id,type) { //Creado [Suemy][2024-03-13]
        //tareaCompletada
        const pause = document.getElementById('statusTask'+id);
        const val = $('#statusTask'+id).attr('data-status');
        //console.log(val, pause);
        if (val == 1) {
            const status = "Pausa Cancelada";
            const comment = "La pausa fue cancelada porque la Tarea fue completada";
            savePauseStatus(id,status,comment);
            $(pause).addClass('ocultarObj');
            $('#divider'+id).addClass('ocultarObj');
        }
        else {
            if (type == 0) {
                $(pause).removeClass('ocultarObj');
                $('#divider'+id).removeClass('ocultarObj'); 
            }
            else {                
                $(pause).addClass('ocultarObj');
                $('#divider'+id).addClass('ocultarObj');
            }
        }

    }

    function getTimeElapsedJS(date) { //Creado [Suemy][2024-03-13]
        var data = "";
        var years, days, hours, hour, minutes;
        var a = new Date(date);
        var b = new Date();
        var time = (b - a) / 1000;
        //console.log(a, b, time);
        //Tiempo
        time = time / 3600;
        //Días
        days = (time / 24).toFixed(2);
        days = days.split('.');
        //Años
        years = (days[0] / 365).toFixed(4);
        years = years.split('.');
        if (years[0] > 0) {
            data += years[0] + ` año`;
            data += `<?=addLetter('${years[0]}');?>`;
            data += ', ';
        }
        if (days[0] > 0) {
            data += days[0] + ` dia`;
            data += `<?=addLetter('${days[0]}');?>`;
            data += ' con ';
        }
        //Horas
        hours = ((days[1] * 24) / 100).toFixed(2);
        hours = hours.split('.');
        if (hours[0] > 0) {
            data += hours[0] + ` hora`;
            data += `<?=addLetter('${hours[0]}');?>`;
            data += ' y ';
        }
        //Minutos
        hour = time.toFixed(2);
        hour = hour.split('.');
        minutes = (60 * hour[1]) / 100;
        minutes = minutes.toFixed(0);
        data += minutes + ` minuto`;
        data += `<?=addLetter('${minuto}');?>`;
        return data;
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function() { //Creado [Suemy][2024-04-05]
        $('#filterTableHistory').keyup(function() {
            const val = $(this).val().toUpperCase();
            const body = "tabla-historico";
            const clase = "task-history";
            filterTable(val,body,clase);
        })

        $('#BtnMenuBurguer').click(function() {
            $('#BtnMenuSeguimiento').toggleClass('active');
        })
    })

    function filterTable(value,body,clase) { //Creado [Suemy][2024-04-05]
        var filter, panel, d, td, i, j, k, visible;
        var tr = "";
        filter = value;
        panel = document.getElementById(body);
        d = panel.getElementsByTagName("tr");
        let Fila = document.getElementsByClassName(clase);
        //
        for (i = 0; i < d.length; i++) {
            visible = false;
            td = d[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    visible = true;
                }
            }
            if (visible === true) {
                d[i].style.display = "";
                $(d[i]).addClass(clase);
            }
            else {
                d[i].style.display = "none";
                $(d[i]).removeClass(clase);
            }
        }
        result = Fila.length;
    }

    function orderDates(array) {//Creado [Suemy][2024-04-05]
        let data = [];
        let dates = [];
        for (let i=0;i<array.length;i++) {
            if (array[i] != 0) {
                let add = {};
                var date = array[i].split('/');
                add['fecha'] = array[i];
                add['format'] = date[2] + date[1] + date[0];
                dates.push(add);
            }
        }
        dates.sort((a, b) => a.format - b.format);
        for (let i=0;i<dates.length;i++) {
            data.push(dates[i].fecha);
        }
        return data;
    }

    function openContainer(event) { //Creado [Suemy][2024-03-13]
        const icon = $(event).children('i');
        icon.attr('class', icon.hasClass('fas fa-plus') ? 'fas fa-minus' : icon.attr('data-class'));
        icon.attr('title', icon.hasClass('fas fa-plus') ? 'Ver' : 'Ocultar');
    }

    function getDateFormat(data) { //Creado [Suemy][2024-03-13]
        let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
        let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        var dateF = "";

        if (data == undefined || data == null || data == "") {
            dateF = "";
        }
        else {
            date = new Date(data);
            dateF = numberday[date.getDate()] + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
        }
        return dateF;
    }

    function getTextValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "") {
            data = "";
        }
        return data;
    }

    <?
        function getTimeElapsed($dateI,$dateF,$type) { //Creado [Suemy][2024-03-13] | Modificado [Suemy][2024-04-05]
            $time = "";
            $dateB = date('Y-m-d H:i:s',strtotime($dateF));
            if ($type == 1 || $type == 2 && empty($dateF)) { $dateB = date('Y-m-d H:i:s'); }
            if (!empty($dateI)) {
                $dateA = date('Y-m-d H:i:s',strtotime($dateI));
                $hoursD = (strtotime($dateB) - strtotime($dateA)) / 3600; //36400
                $seconds = (strtotime($dateB) - strtotime($dateA));
                //Obtener Días y Años
                $days = number_format(($hoursD / 24),2);
                $days = explode('.',$days);
                $year = number_format(($days[0] / 365),4);
                $year = explode('.', $year);
                if ($year[0] > 0) {
                    $time .= $year[0].' año';
                    $time .= addLetter($year[0]);
                    $time .= ', ';
                }
                if ($days[0] > 0) {
                    $dd = ($year[1] * 365) / 10000;
                    $time .= round($dd).' día';
                    $time .= addLetter($days[0]);
                    $time .= ' con ';
                }

                //Obtener Horas
                $hours = ($days[1] * 24) / 100;
                $hours = explode('.', $hours);
                if ($hours[0] > 0) {
                    $time .= $hours[0]. ' hora';
                    $time .= addLetter($hours[0]);
                    $time .= ' y ';
                }

                //Obtener Minutos
                $hour = number_format($hoursD,2);
                $hour = explode('.',$hour);
                $minutes = (60 * $hour[1]) / 100;
                $second = $minutes;
                $minutes = number_format($minutes,0);
                $time .= $minutes.' minuto';
                $time .= addLetter($minutes);
                if ($year[0] == 0 && $days[0] == 0 && $hours[0] == 0 && $second == 0) {
                    $time = "Hace unos momentos";
                }
                /*if (empty($dateF)) {
                    echo ("Hoy: ".date('Y-m-d H:i:s').", ".$dateA.", Horas Totales: ".$seconds.", Segundos Totales: ".$hoursD.", Porcentaje Días Transcurridos: ".$year[1].", Porcentaje Hora Trancurrida : ".$days[1].", Horas Trancurridas: ".$hours[0].", Segundos Actuales: ".$second." | ");
                }*/
            }

            return $time;
        }

        function addLetter($text) { //Creado [Suemy][2024-03-13]
            $data = "";
            if ($text == 0 || $text > 1) { $data .= 's'; }
            return $data;
        }
    ?>
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<!--
Consta de las siguientes tablas:
    * proyectos
    * psubtareas
    * ptareas
    * subtareas
    * tareas
    * tareascomentario
    * tareas_seguimiento
-->

<!-- INICIO: JavaScript para manejar la view <agregar_evaluador_tarea> | Angel Leon -->
<script>
  $(document).ready(function () {

    $('.agrega_evaluador').click(function () {
      let id_tarea = $(this).data('id-tarea');
      mostrarViewAgregarEvaluador(id_tarea);
    });

    $('.archivos_incidencia').click(function () {
      let id_tarea = $(this).data('id-tarea');
      mostrarViewArchivosIncidencia(id_tarea);
    });

    $('#btn_cronograma').on('click', function(event) {
      event.preventDefault();      
      mostrarCronogramaPersonal();
    });
  });

  /**
  * Calcula la posicion centrada de una ventana en la pantalla del usuario
  *
  * @param {number} width - El ancho de la ventana
  * @param {number} height - La altura de la ventana
  * @returns {{ top: number, left: number }} - Un objeto que contiene las propiedades `top` y `left`
  */
  function calcularPosicionCentrada(width, height) {
    let screenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
    let screenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

    let screenWidth = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    let screenHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    let left = (screenWidth / 2) - (width / 2) + screenLeft;
    let top = (screenHeight / 2) - (height / 2) + screenTop;

    return { top, left };
  }

  /**
   * Abre una nueva ventana para mostrar el formulario Agregar Evaluador
   * 
   * @param {string} id_tarea - El ID de la tarea a la cual queremos asignar o remover un evaluador
   */
  function mostrarViewAgregarEvaluador(id_tarea) {
    // Construimos la url de la view
    let url_controller = '<?php echo site_url('seguimiento/EvaluadorTarea/mostrarAgregarEvaluador'); ?>';
    let full_url = url_controller + '?id_tarea=' + encodeURIComponent(id_tarea);

    // Definimos las dimensiones de la nueva ventana
    let width = 1200;
    let height = 651;

    let posicionCentrada = calcularPosicionCentrada(width, height);

    // Definimos las propiedas de la ventana
    let windowFeatures = "width=" + width + ",height=" + height + ",top=" + posicionCentrada.top + ",left=" + posicionCentrada.left + ",scrollbars=yes,resizable=no";

    // Abrimos una nueva ventana con la vista de nuestra view centrada
    let newWindow = window.open(full_url, 'ViewAgregarEvaluador', windowFeatures);

    // Verificamos que la ventana no sea bloqueada por el navegador, caso contrario mostramos un alert informando la situacion
    if (newWindow) {
      newWindow.focus();
    } else {
      alert('Por favor, permite las ventanas emergentes en tu navegador.');
    }

    // Monitoreamos si la ventana se ha cerrado para recarga la vista padre
    let timer = setInterval(function() {
        if (newWindow.closed) {
          clearInterval(timer);
          location.reload();
        }
    }, 1000);
  }

  /**
   * Abre una nueva ventana para mostrar el formulario Archivos Incidencia
   * 
   * @param {string} id_tarea - El ID de la tarea a la cual queremos visualizar los archivos adjuntos asociados a su incidencia origen
   */
  function mostrarViewArchivosIncidencia(id_tarea){
    // Construimos la url de la view
    let url_controller = '<?php echo site_url('seguimiento/ArchivosIncidencia/mostrarArchivosIncidencia'); ?>';
    let full_url = url_controller + '?id_tarea=' + encodeURIComponent(id_tarea);

    // Definimos las dimensiones de la nueva ventana
    let width = 600;
    let height = 451;

    let posicionCentrada = calcularPosicionCentrada(width, height);

    // Definimos las propiedas de la ventana
    let windowFeatures = "width=" + width + ",height=" + height + ",top=" + posicionCentrada.top + ",left=" + posicionCentrada.left + ",scrollbars=yes,resizable=no";

    // Abrimos una nueva ventana con la vista de nuestra view centrada
    let newWindow = window.open(full_url, 'ViewArchivosIncidencia', windowFeatures);

    // Verificamos que la ventana no sea bloqueada por el navegador, caso contrario mostramos un alert informando la situacion
    if (newWindow) {
      newWindow.focus();
    } else {
      alert('Por favor, permite las ventanas emergentes en tu navegador.');
    }
  }

  /**
   * Abre una nueva ventana para mostrar la view del cronograma personal
   */
  function mostrarCronogramaPersonal(){
    // Construimos la url de la view
    let url_controller = '<?php echo site_url('seguimiento/Cronograma/mostrarCrono'); ?>';

    const params = new URLSearchParams(window.location.search);
    if (params.has('idproyecto')) {
      const idproyecto = params.get('idproyecto');
      url_controller += `?idproyecto=${idproyecto}`;
    }

    let newTab = window.open(url_controller, '_blank');

    // Verificamos que la pestaña no sea bloqueada por el navegador, caso contrario mostramos un alert informando la situacion
    if (newTab) {
      newTab.focus();
    } else {
      alert('Por favor, permite las ventanas emergentes en tu navegador.');
    }
  }
</script>
<!-- FIN: JavaScript para manejar la view <agregar_evaluador_tarea> | Angel Leon -->
<!-- INICIO: Nuevo flujo para el filtro de tareas | Angel Leon -->
<script>
  $(document).ready(function () {
    $('#filtrosTareas').on('change', function () {
      let contador = 0;
      let val_filtro = $(this).val().trim();

      // Filtramos por estatus
      if(!val_filtro.includes('@') && !val_filtro.includes('/') && isNaN(val_filtro)){
        $('.divTarea').each(function () {
          let estatus = $(this).data('statustarea');

          if (estatus.includes(val_filtro)) {
            $(this).show();
            contador++;
          } else {
            $(this).hide();
          }
        });
      }

      // Filtramos por responsables
      if(val_filtro.includes('@')){
        $('.divTarea').each(function () {
          let responsables = $(this).data('responsables');

          if (responsables.includes(val_filtro)) {
            $(this).show();
            contador++;
          } else {
            $(this).hide();
          }
        });
      }

      // Filtramos por estrellas
      if(!isNaN(val_filtro)){
        $('.divTarea').each(function () {
          let estrellas = $(this).data('estrellas');

          if (estrellas == val_filtro) {
            $(this).show();
            contador++;
          } else {
            $(this).hide();
          }
        });
      }

      // Filtramos por fecha de entrega
      if(val_filtro.includes('/')){
        $('.divTarea').each(function () {
          let fecha_entrega = $(this).data('fechaentrega');

          if (fecha_entrega === val_filtro) {
            $(this).show();
            contador++;
          } else {
            $(this).hide();
          }
        });
      }

      // Mostramos todas las tareas
      if(val_filtro === 'ESCOGER FILTRO'){
        $('.divTarea').each(function () {
          $(this).show();
          contador++;
        });
      }

      $('#filtradosTareasLabel').html(contador);

    });
  });
</script>
<!-- FIN: Nuevo flujo para el filtro de tareas | Angel Leon -->