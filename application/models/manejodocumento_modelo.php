<?php
class manejodocumento_modelo extends CI_Model{

	
	public function __Construct(){
		parent::__Construct();
			//$this->load->library('localfileuploader');
	}

//-----------------------------------------------------------------------------

function guardarImagenPersona(){
	$extension=$this->devolverExtension($_FILES['imgPersonal']['name']);
	 $directorio=$this->obtenerDirectorio('U');
	 $directorio=$directorio."archivosPersona/".$_POST['idPersona'].'/';
	 $this->crearDirectorio($directorio);
	  $directorio=$directorio.'miFoto/';
	  $this->crearDirectorio($directorio);
 if($this->verificaExtensionImagen($extension)){
	$consulta="select idPersonaImagen,extensionPersonaImagen from personaimagen where IdPersona=".$_POST['idPersona'].' and tipoPersonaImagen=0';
	$datos=$this->db->query($consulta)->result();
	if(count($datos)>0){
    unlink($directorio.$datos[0]->idPersonaImagen.$datos[0]->extensionPersonaImagen);
    $this->db->where('idPersonaImagen',$datos[0]->idPersonaImagen);
    $this->db->delete('personaimagen');       
	}
	 $insert['idPersona']=$_POST['idPersona'];
	 $insert['tipoPersonaImagen']=0;
	 $insert['extensionPersonaImagen']=".".$extension;
	 $this->db->insert('personaimagen',$insert);
	 $id=$this->db->insert_id();	
	 $this->guardarArchivo($directorio,$_FILES,$id,$extension);
  return 'alert("La imagen se subio correctamente")';
 }
 else{return 'alert("extension no valido")';}
}


//-----------------------------------------------------------------------------
public function guardarImagenPersonaCursos($operacion){
	$extension=$this->devolverExtension($_FILES['imgGeneral']['name']);
		 $directorio=$this->obtenerDirectorio('U');
    if($this->verificaExtensionImagen($extension)){
     if($operacion=='I'){
     $insert['idPersona']=$_POST['idPersona'];
	 $insert['tipoPersonaImagen']=1;
	 $insert['extensionPersonaImagen']='.'.$extension;
	 $this->db->insert('personaimagen',$insert);
	 $id=$this->db->insert_id();
	 $this->crearDirectorio($directorio."archivosPersona/".$_POST['idPersona'].'/');
	 $directorio=$directorio."archivosPersona/".$_POST['idPersona'].'/misCursos/';
	 $this->guardarArchivo($directorio,$_FILES,$id,$extension);
      }
     }
     else{
  	return 'alert("extension no valido")';
   }
}
//-----------------------------------------------------------------------------

public function guardarDocumentoPersona($objeto,$documento){

	$idPersona=$objeto['idPersona'];
 $idPersonaDocumento=$objeto['idPersonaDocumento'];
 $layoutPD=$objeto['layoutPD'];

 $consulta="select descripcionPD,layoutPD from personadocumento where idPersonaDocumento=".$idPersonaDocumento;
 $personaDocumento=$this->db->query($consulta)->result()[0];
	

	/*DIRECCION PARA HACER CUANDO SE EJECUTE LOCALMENTE*/
  //$directorio=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/archivosPersona/".$idPersona."";//base_url().'ArchivosPresupuesto/'.$_POST['id']."/"; 
  /*DIRECTORIO CUANDO SE SUBE AL SERVIDOR  */
  $directorio=$_SERVER["DOCUMENT_ROOT"]."/V3/archivosPersona/".$idPersona."";
  $extension=explode(".",$documento['documento']['name'] );
 	
   $extension[1]=strtoupper($extension[1]);
   $bandExtension=$this->verificaExtensionArchivo($extension[1]);
   $largo=count($extension);

  if($bandExtension==1){
    $bandSubida= $this->subeArchivo($directorio,$documento,$personaDocumento->descripcionPD,$extension[1])  ;
    if($bandSubida){
       $consulta='select * from personadocumentoguardado where idPersona='.$idPersona.' and idPersonaDocumento='.$idPersonaDocumento.' and idLayout='.$layoutPD.' limit 1';
       $datos=$this->db->query($consulta)->result();

          if(count($datos)==0){
          	$insert['idPersona']=$idPersona;
          	$insert['idPersonaDocumento']=$idPersonaDocumento;
          	$insert['idLayout']=$layoutPD;
          	$insert['extensionPDG']=$extension[1];

            $this->db->insert("personadocumentoguardado",$insert);
          }
          else{

            if($datos[0]->extensionPDG!=$extension[1]){
              $update['extensionPDG']=$extension[1];
              $this->db->where('idPersona',$idPersona);
              $this->db->where('idPersonaDocumento',$idPersonaDocumento);
              $this->db->where('idLayout',$layoutPD);
              $this->db->update('personadocumentoguardado',$update);
              $this->eliminarArchivo($directorio."/".$personaDocumento->descripcionPD.".".$datos[0]->extensionPDG);

            }

          }

     

    }
  }
  else{return "Formato no valido";}
}
//---------------------------------------------------------------------------------------------------------------------------------------

public function verificaExtensionImagen($extension){
 	$extension=strtoupper($extension);
  if($extension=="JPG" ||  $extension=="BMP" || $extension=="PNG" || $extension=="JPEG" ){return 1;}
  else{return 0;}
 }

//----------------------------------------------------------------------------------------------------------------------------------------


public function verificaExtensionArchivo($extension){
	$extension=strtoupper($extension);

  if($extension=="JPG" || $extension=="PDF" || $extension=="BMP" || $extension=="DOCX" || $extension=="DOC" || $extension=="XLS" ||  $extension=="XLSX" || $extension=="PNG" || $extension=="JPEG" ){return 1;}
  else{return 0;}
 }

//---------------------------------------------------------------------------------------------------------------------------------------
public function guardaDocumentoCRMproyecto(){

}
//--------------------------------------------------------------------------------------------------------------------------------------
public function subeArchivo($directorio,$documento,$nombre,$extension)
 {
 	 
  if(!file_exists($directorio))
  {@mkdir($directorio, 0700);}
        $mi_archivo = 'documento';
        $config['upload_path'] = $directorio;
        $config['file_name'] =$nombre.".".$extension;
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";
        $config['max_width'] = "2000";
        $config['overwrite'] = "TRUE";
        $config['max_height'] = "2000"; 
       $this->load->library('upload', $config);   
      if($this->upload->do_upload($mi_archivo)){return 1;}
 }
//----------------------------------------------------------------------------------
public function obtenerArchivosDelDirectorio($carpeta){
	$archivos="";$i=0;
   //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($carpeta,TRUE));fclose($fp); 
 if(is_dir($carpeta)){
        if($dir = opendir($carpeta)){
            while(($archivo = readdir($dir)) !== false){
                if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
                   // echo '<li><a target="_blank" href="'.$carpeta.'/'.$archivo.'">'.$archivo.'</a></li>';
                   $archivos[$i]=$archivo;
                   $i++;
                }
            }
            closedir($dir);
        }
    }
 
  return $archivos;
}
//----------------------------------------------------------------------------------
public function eliminarContenidoDeDirectorio($carpeta){
/*ELIMINA EL CONTENIDO DE UNA CARPETA NO ES RECURSIVA Y SOLO ELIMANA ARCHIVOS DENTRO DE LA CARPETA
 NO ELIMINA DIRECTORIOS DENTRO DE LA CARPETA
$carpeta = ES UN STRING CON LA DIRECCION DE LA CARPETA(Capsys/www/V3/ArchivosProcedimientos/272/Diagrama)

*/

	  foreach(glob($carpeta . "/*") as $archivos_carpeta){             
        if (!is_dir($archivos_carpeta)){
       unlink($archivos_carpeta);
        } 
      }
}

//----------------------------------------------------------------------------------
public function eliminarArchivo($file)
 {
        //if ($this->exists($file)){@unlink($file); return true;}else{return false;}	
       unlink ($file);
 }
//---------------------------------------------------------------------------------------------------------------------------------------
public function eliminaCaracteres($s)
 {
   $s = str_replace("á","a",$s);
   $s = str_replace("é","e",$s);
   $s = str_replace("í","i",$s);
   $s = str_replace("ó","o",$s);
   $s = str_replace("ú","u",$s);
   $s = str_replace("Á","A",$s);
   $s = str_replace("É","E",$s);
   $s = str_replace("Í","I",$s);
   $s = str_replace("Ó","O",$s);
   $s = str_replace("Ú","U",$s);
   $s = str_replace("ñ","n",$s);
   $s = str_replace("Ñ","N",$s);
   return $s;
 }
//---------------------------------------------------------------------------------------------------------------------------------------
public function reemplazarNombreArchivo($nombre,$cadReemplazo,$reemplazo)
 {
   return (str_replace($cadReemplazo,$reemplazo,$nombre));
 }
//---------------------------------------------------------------------------------------------------------------------------------------
public function devolverExtension($nombre)
 {/*DEVUELVE LA EXTENSION DEL ARCHIVO*/
    $extension=explode(".",$nombre );
    $largo=count($extension);
    return ($extension[$largo-1]);
    
 }

//---------------------------------------------------------------------------------------------------------------------------------------
public function renombrarCarpetaMoverProcedimiento($array){

  $directorio=$this->obtenerDirectorio('U');
  $directorio.='ArchivosProcedimientos/';
  $badExisteC1=0;
  $badExisteC2=0;
     
    if(file_exists($directorio.$array['posicionMover1'])){
      rename($directorio.$array['posicionMover1'], $directorio.'-'.$array['posicionMover1']);
      $badExisteC1=1;
    }    
    if(file_exists($directorio.$array['posicionMover2'])){
      rename($directorio.$array['posicionMover2'], $directorio.'-'.$array['posicionMover2']);
      $badExisteC2=1;
    }
        if($badExisteC1){ 
      rename($directorio.'-'.$array['posicionMover1'],$directorio.$array['posicionMover2']);
    }
    if($badExisteC2)
    {
       rename($directorio.'-'.$array['posicionMover2'],$directorio.$array['posicionMover1']);
    }
}                                                                                                                    



//-------------------------------------------------------------------------------------
public function obtenerDirectorio($tipo){		
  if($tipo!="U")//RUTA_ARCHIVOS_CARGA_LOCAL
   {//$directorio=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/";
    $directorio=RUTA_ARCHIVOS_CARGA_LOCAL."/V3/";
    }
  else{
     /*DIRECTORIO CUANDO SE SUBE AL SERVIDOR  */
    $directorio=RUTA_ARCHIVOS_CARGA_LOCAL."/V3/";
   }

   return $directorio;

}

//---------------------------------------------------------------------------------------------------------------------------------------
private function crearDirectorio($directorio){
  /*CREA UN DIRECOTRIO SI NO EXISTE*/
  if(!file_exists($directorio))
  {@mkdir($directorio, 0700);}
}
//----------------------------------------------------------------------------------------------
public function guardarArchivo($directorio,$documento,$nombre,$extension)
 {
/*GUARDA UN DOCUMENTO EN EL DIRECTORIO ESPECIFICADO $directorio=EL DIRECTORIO DONDE SE GUARDARA,$documento=EL DOCUMENTO A GUARDAR,$nombre=NOMBRE DEL ARCHIVO,$extension=LA EXTENSION DEL ARCHIVO*/
	
  if(!file_exists($directorio))
  {
     
  	@mkdir($directorio, 0700, true);}
        $mi_archivo = key($documento);
        $config['upload_path'] = $directorio;
        $config['file_name'] =$nombre.".".$extension;
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";
        $config['max_width'] = "2000";
        $config['overwrite'] = "TRUE";
        $config['max_height'] = "2000"; 
       $this->load->library('upload', $config);   
      if($this->upload->do_upload($mi_archivo)){return 1;}else{return 0;}
 }
//---------------------------------------------------------------------------------------------------------------------------------------
public function obtenerNombreArchivo($nombre){
/*ESTA FUNCION DEVUELVE EL NOMBRE DEL ARCHIVO SIN LA EXTENSION $nombre=ARCHIVO CON EXTENSION*/
	$nombre= rtrim(strrev(strstr(strrev($nombre), '.', false)),'.');                                                                    
	return $nombre ;                                                              
}

//---------------------------------------------------------------------------------------------------------------------------------------
public function devolverDocumentos($directorio,$estilo){

/*$directorio=LA CARPETA A DONDE BUSCAR EJEMPLO (archivosCRM/43/)*/
/*$estilo= MANEJAR ESTILOS EN UN FUTURO*/
/*====PARA EL FUNCIONAMIENTO DE ESTE CODIGO EN EL LADO DEL CLIENTE DEBE IR DENTRO DE UN FUNCION EL CODIGO SIGUIENTE======*/
/*
function verDocumentos(idProspecto){
  var req = new XMLHttpRequest();
  req.open('GET', '<?=base_url()?>crmproyecto/devuelveDocumentos/?idProspecto='+idProspecto, true);
  req.onreadystatechange = function (aEvt) 
  {
     if	(document.getElementById("divVentanaDocumentos"))
     	{document.head.removeChild(document.getElementById('divVentanaDocumentosEstilo'));
         document.body.removeChild(document.getElementById('divVentanaDocumentos'));
       }
     if (req.readyState == 4) {if(req.status == 200)
       {var j=JSON.parse(this.responseText);   
        if(j==0){alert("Este usuario no tiene documento");}
        else
        {var div=document.createElement('div');div.id="divVentanaDocumentos";
        div.innerHTML=j["datos"];var hoja = document.createElement('style');
        hoja.id="divVentanaDocumentosEstilo";hoja.type="text/css";hoja.innerHTML=j['estilo'];
        document.head.appendChild(hoja);document.body.appendChild(div);
        document.getElementById("divVentanaDocumentos").classList.add('ventanaDocumentosEstilo');
       }                                                 
      }     
   }
};
req.send();
}

 */

$comprueba='./'.$directorio;
if(file_exists($comprueba))
{
 $ficheros  = scandir($directorio);
  $cantArchivos=count($ficheros);
  $dato="";
  $ventana="";
    $dato='<button class="btn btn-primary btn-xs contact-item" onclick="document.head.removeChild(document.getElementById(\'divVentanaDocumentosEstilo\'));document.body.removeChild(document.getElementById(\'divVentanaDocumentos\'))">cerrar</button><br><br>';
  for($i=2;$i<$cantArchivos;$i++)
  {
	$dato=$dato.'->:<a  href="'.base_url().$directorio.$ficheros[$i].'">'.$ficheros[$i].'(Descargar)</a><br>';
  }
  $dato=$dato.'<br><br>';
    $ventana['estilo']='.ventanaDocumentosEstilo {border: 4px solid #472380; background-color: white;color:black;position:fixed;top:50%;left:40%;font-size:20px;z-index:100};.linkDocumento{color:black}';
    $ventana['datos']=$dato;

  return $ventana;
  }
  else
  {return 0;}

}

//-----------------------------------------------------------------------------
public function devolverImagenes($directorio,$estilo){
	
 $comprueba='./'.$directorio;

 if(file_exists($comprueba))
 {
   $dato="";$ventana="";
   $ventana['botonCerrar']='<button class="btn btn-primary btn-xs contact-item" id="btnCerrarVentana" onclick="document.head.removeChild(document.getElementById(\'divVentanaImagenesEstilo\'));document.body.removeChild(document.getElementById(\'divVentanaImagenes\'))">cerrar</button><br><br>';
   $respuesta=$this->imagenes($directorio,0);;
   $ventana['imagenes']=$respuesta['imagenes'];
   $ventana['idImagenes']=$respuesta['idImagenes'];
   $ventana['estilo']='.divVentanaImagenesEstilo {border: 4px solid #472380; background-color: white;color:black;position:fixed;top:20%;left:30%;font-size:20px;z-index:100;overflow:scroll;height:50%;width:30%};.linkDocumento{color:black}';
   $ventana['datos']=$dato;
   return $ventana;
  
   }
   else
   {return 0;}	
}
//-----------------------------------------------------------------------------
public function imagenes($directorio,$estilo)
{
  /*TE DEVUELVE TODOS LOS ARCHIVOS QUE ESTAN DENTRO DE UN DERECTORIO DETERMINADO*/
  if(file_exists($directorio)){
    $dato="";
    $ficheros  = scandir($directorio);
    $cantArchivos=count($ficheros);
      for($i=2;$i<$cantArchivos;$i++)
    {
      $dato['imagenes'][$i-2]='<img  src="'.base_url().$directorio.$ficheros[$i].'" class="imgMisCursos" id="imgCurso'.$ficheros[$i].'">';
	    $dato['idImagenes'][$i-2]=$ficheros[$i];
    }
  return $dato;
}
}
//-----------------------------------------------------------------------------
public function prueba(){
	return "vvv";
}
//-----------------------------------------------------------------------------
public function eliminaImagen($imagen){
	/*PARA BORRAR LA IMAGEN ES NECESARIO PASAR DIRECCION DE CARPETA DONDE SE LOCALIZA EL ARCHIVO, CON EL ARCHIVO,LA TABLA DONDE SE VA A BORRAR, CAMPO CON EL CUAL SE VA A COMPARAR EL BORRADO Y EL VALOR PARA BORRAR
	[direccion] => 209
    [tabla] => personaimagen
    [campo] => idPersonaImagen
	,*/
	
	$servidor=$this->obtenerDirectorio('U');
	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($servidor.$imagen['direccion'], TRUE));fclose($fp);
	if( unlink ($servidor.$imagen['direccion'])){
	$this->db->where($imagen['campo'],$imagen['valor']);
	$this->db->delete($imagen['tabla']);	
	return "La imagen fue eliminada";
	}
    else{
    	return "Problemas al momento de eliminar la imagen";
    }
    

}
//-----------------------------------------------------------------------------
function devolverDocumentosGenerico($directorio){

$comprueba='./'.$directorio;
if(file_exists($comprueba))
{
 $ficheros  = scandir($directorio);
  $cantArchivos=count($ficheros);
  $dato="";
  $contador=0;
  for($i=2;$i<$cantArchivos;$i++)
  {
	$dato[$contador]=$ficheros[$i];$contador++;
  }
 
  return $dato;
  }
  else
  {return 0;}

}
//-----------------------------------------------------------------------------
//[Dennis 2020-05-22]
function insertaImgsCurso($agentes,$archivo){
  //$directorioActual=$this->obtenerDirectorio("U");
  $pruebaDirec=$_SERVER["DOCUMENT_ROOT"]."/V3/"; //"/Capsys/www/V3/";
  $directorioActual="";
  $oka=array();
  //$extension=$this->devolverExtension($_FILES['archivo']['name']);
  //$this->guardarArchivo($directorio,$_FILES,$id,$extension);
  for($i=0;$i<count($agentes);$i++){

    if(!empty($archivo)){
      //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r("Hola mundo", TRUE));fclose($fp);
    }

    $directorioActual=$pruebaDirec."archivosPersona/".$agentes[$i]."/";
    //$directorioActual.="misCursos/";
    $this->crearDirectorio($directorioActual);

    $directorioActual.="misCursos/";
    $this->crearDirectorio($directorioActual);
    $ruta_absoluta[$i]=$directorioActual;
    //array_push($oka,$ruta_absoluta[$i]);

    for($j=0;$j<count($archivo['archivo']['name']);$j++){
      $_FILES['imgAgente']['name'] = $archivo['archivo']['name'][$j];
      $_FILES['imgAgente']['type'] = $archivo['archivo']['type'][$j];
      $_FILES['imgAgente']['tmp_name'] = $archivo['archivo']['tmp_name'][$j];
      $_FILES['imgAgente']['error'] = $archivo['archivo']['error'][$j];
      $_FILES['imgAgente']['size'] = $archivo['archivo']['size'][$j];


      $config['upload_path']=$ruta_absoluta[$i];//$directorioImg;
      $config['allowed_types']= 'jpg|jpeg|png|gif';

      $this->load->library("upload", $config);
      $this->upload->initialize($config);

      if($this->upload->do_upload("imgAgente")){

        $this->upload->data();
      }

      //$directorioImg.="misCursos/"; //$pruebaDirec."archivosPersona/".$agentes[$i]."/misCursos/";
      //$this->crearDirectorio($directorioImg);
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($_FILES['imgAgente']["name"], TRUE));fclose($fp);
    }
  }
    
  //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($archivo['archivo']['name'], TRUE));fclose($fp);
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------

public function modificar_url_documento($id,$nombre){
    $this->db->set('Documento',$nombre);
    $this->db->where('IDCli',$id);
    $this->db->update('clientes_actualiza');
    return;
  }

//------------------------------------------------------------------------------
function eliminar_directorio($directorio){

  if(is_dir($directorio)){

    rmdir($directorio);

  }

}
//-----------------------------------------------------------------------------
function gestiona_directorio_para_adjuntos_de_eventos($directorio,$operacion){

  $respuesta=false;

  if($operacion=="crear"){

    $this->crearDirectorio($directorio);
    $respuesta=true;

  } elseif($operacion=="eliminar"){

    $this->eliminar_directorio($directorio);
    $respuesta=true;
  }


  return $respuesta;
}
//------------------------------------------------------------------------------
public function obtenerRuta()
{
  //$directorio=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/";
  $directorio=RUTA_ARCHIVOS_CARGA_LOCAL."/V3/";
  if($directorio=='C:/wamp64/www/Capsys/www/V3/'){return $directorio;}
  else{return RUTA_ARCHIVOS_CARGA_LOCAL."/V3/";}
}
//------------------------------------------------------------------------
public function devolverArchivos($directorio){

/*$directorio=LA CARPETA A DONDE BUSCAR EJEMPLO (archivosCRM/43/)*/
 /*assets/img/archivosClientesNuevos/*/
 //$comprueba='./'.$directorio;
$comprueba=$directorio;
$dato=array();
if(file_exists($comprueba))
{
 $ficheros  = scandir($directorio);
  
  
  $cantArchivos=count($ficheros);
    
  for($i=2;$i<$cantArchivos;$i++)
  {
    

    $extension=explode(".",$ficheros[$i] );
    $largo=count($extension);
    if($largo>1){

     $archivo['url']='<a  href="'.base_url().$directorio.$ficheros[$i].'" target="_blank">'.$ficheros[$i].'</a>';
     $archivo['nombreArchivo']=$ficheros[$i];
    $archivo['PathWWW']=base_url().$directorio.$ficheros[$i];
    $archivo['nombreArchivo']=$ficheros[$i];
    $archivo['DateModify']=date ("d/m/Y", filemtime($directorio.$ficheros[$i]));
    array_push($dato, $archivo);
    }
  }
  
  
  }
  return $dato;

}

//------------------------------------------------------------------------
}