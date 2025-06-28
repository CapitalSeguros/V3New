<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class procesamientoNC extends CI_Controller{
  var  $datos=array();
	function __construct(){
		parent::__construct();
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');
		}

			$this->load->library('webservice_sicas_soap');
			$this->load->library('libreriav3');
			$this->load->helper('ckeditor');
			$this->load->model('procesamientoncmodel');
			$this->load->model('PersonaModelo');
			$this->load->model('modeloproyecto');

    }
//-------------------------------------------------------------
function index(){

        $this->datos['causaRaiz'] = $this->procesamientoncmodel->causaraiz(null);
        $this->datos['accionCorrectiva'] = $this->procesamientoncmodel->accionCorrectiva(null);
        $this->datos['statusNoConformidad'] = $this->procesamientoncmodel->statusNoConformidad(null);
        $this->datos['tipoInconformidad'] = $this->procesamientoncmodel->tipoInconformidad();
        $this->datos['inconformidad'] = $this->procesamientoncmodel->inconformidad();
        $this->datos['area'] = $this->procesamientoncmodel->areaInconformidad();
        $array['idResponsable'] = $this->tank_auth->get_idPersona();
        $this->datos['tiposNC'] = $this->procesamientoncmodel->tablaNC($array);
        $this->datos['anios'] = $this->libreriav3->devolverAnioActualConAnteriores();
        $this->datos['meses'] = $this->libreriav3->devolverMeses();
		$this->datos['proyectosSeguimiento'] = $this->procesamientoncmodel->obtenerProyectosSeguimiento($this->tank_auth->get_idPersona());
        $this->load->view('procesamientoNC/principalNC', $this->datos);

}
//-------------------------------------------------------------
function seguimientoNC(){
	$this->datos['causaRaiz']=$this->procesamientoncmodel->causaraiz(null);
	$this->datos['accionCorrectiva']=$this->procesamientoncmodel->accionCorrectiva(null);
	$array['idPersona']=$this->tank_auth->get_idPersona();
	$this->datos['tiposNC']=$this->procesamientoncmodel->tablaNC($array);

    $this->load->view('procesamientoNC/seguimientoNC',$this->datos);

}
//-------------------------------------------------------------
function compara_fecha($a, $b){
    return strtotime(trim($a['fecha'])) > strtotime(trim($b['fecha']));
 }
//-------------------------------------------------------------
function causaRaiz(){
	$array['idCausaRaiz']=-1;
	$array['causaRaiz']=$_POST['nombreCausaRaiz'];
	$array['descripcionCausaRaiz']=$_POST['descripcionCausaRaiz'];
	$respuesta['causaRaiz']=$this->procesamientoncmodel->causaraiz($array);
	echo json_encode($respuesta);
}
//-------------------------------------------------------------
function accionCorrectiva(){
	$array['idAccionCorrectiva']=-1;
	$array['accionCorrectiva']=$_POST['nombreAccionCorrectiva'];
	$array['descripcionAccionCorrectiva']=$_POST['descripcionAccionCorrectiva'];
    $respuesta['accionCorrectiva']=$this->procesamientoncmodel->accioncorrectiva($array);
	echo json_encode($respuesta);

}
//-------------------------------------------------------------
function cerrarNoConformidad(){

	$update['idCausaRaiz']=$_POST['idCausaRaiz'];
	$update['idAccionCorrectiva']=$_POST['idAccionCorrectiva'];
	$update['comentarioTNC']=$_POST['comentario'];
	$update['aFavor']=$_POST['veredicto'];
	$update['idTablaNoConformidad']=$_POST['idTablaNoConformidad'];
	$update['nombreNoConformidad']=$_POST['nombreNoConformidad'];
	$update['noConformidadRevisada']=1;
	$update['update']=true;
    $this->procesamientoncmodel->tablanoconformidad($update);
    /*$segmento=explode(';', $_POST['idPersona']);
    foreach ($segmento as $value) 
    {
    	if($value!=''){
           $partes=explode('-', $value);
    		$insertar['idPersona']=$partes[0];
    		$insertar['conformidadMala']=$partes[1];
    		$insertar['idTablaNoConformidad']=$_POST['idTablaNoConformidad'];
    		$this->procesamientoncmodel->tablanoconformidadresponsables($insertar);
    	}
    }*/
    $respuesta['idTablaNoConformidad']=$_POST['idTablaNoConformidad'];
    $respuesta['mensaje']='No conformidad cerrada';
    echo json_encode($respuesta);
}
//-------------------------------------------------------------
function buscarReporte(){

	$respuesta="";
if(isset($_POST['fechaInicialGraf']))
	{
		$_POST['fechaInicial']=$_POST['fechaInicialGraf'];
		$_POST['fechaFinal']=$_POST['fechaFinalGraf'];
	}
else
{
	$_POST['fechaInicial']=$this->libreriav3->convierteFecha($_POST['fechaInicial']);
	$_POST['fechaFinal']=$this->libreriav3->convierteFecha($_POST['fechaFinal']);

}
	$tipoPersona=0;
	$idPersona=0;
	
if(isset($_POST['Persona']))
{
	if(isset($_POST['idPersona']))
	{
      $respuesta=$this->procesamientoncmodel->tablaNCFechas($_POST);      
	  $idPersona=$_POST['idPersona'];
	  $tipoPersona=$_POST['Persona'];
	   foreach ($respuesta['personaRevisada'] as $key => $value) {
	    	   
		   foreach ($respuesta['personaRevisada'] as $key => $value) {if($value['tipoPersona']!=$tipoPersona){unset($value[$key]);}}
		   }
		  // 
       $respuesta['mensaje']='';
	}
	else
	{$tipoPersona=$_POST['Persona'];
     if($_POST['Persona']==1)
     {
       $datos=$this->PersonaModelo->obtenerEmpleadosActivos();
       $where='in (';
      foreach ($datos as  $value)
      { 
        if($value === end($datos)){$where.=$value->idPersona.')';}
        else{$where.=$value->idPersona.',';}
      }

      $_POST['where']=$where;
      $respuesta=$this->procesamientoncmodel->tablaNCFechas($_POST);  	   
      $respuesta['mensaje']='';
     }
     else
     {      
      $respuesta=$this->procesamientoncmodel->tablaNCFechas($_POST);      	   
       $respuesta['mensaje']='';
     }
	}
}
else
 {
	if($_POST['fechaFinal']!='' && $_POST['fechaInicial']!='')
	{
		$respuesta=$this->procesamientoncmodel->tablaNCFechas($_POST);
		
        $respuesta['mensaje']='';
	}
	else{$respuesta['mensaje']='Tiene que poner un rango de fechas';}
 }
   $respuesta['tipoPersona']=$tipoPersona;
   $respuesta['idPersona']=$idPersona;
   if(isset($_POST['mostrarTodos']))
   {unset($respuesta['personaRevisada']);
   	$index=array();
   	if($_POST['mostrarTodos']==0){foreach ($respuesta['calificaAgente'] as $key => $value) {if($value->noConformidadRevisada==0){array_push($index, $key);}}}   	
   	foreach ($index as $value) {unset($respuesta['calificaAgente'][$value]);}
   	$respuesta['calificaAgente']=array_values($respuesta['calificaAgente']);
unset($index);
$index=array();
   	if($_POST['mostrarTodos']==0){foreach ($respuesta['calificaCliente'] as $key => $value) {if($value->noConformidadRevisada==0){array_push($index, $key);}}}   	
   	foreach ($index as $value) {unset($respuesta['calificaCliente'][$value]);}
$respuesta['calificaCliente']=array_values($respuesta['calificaCliente']);
unset($index);
$index=array();
   	if($_POST['mostrarTodos']==0){foreach ($respuesta['calificaOperativo'] as $key => $value) {if($value->noConformidadRevisada==0){array_push($index, $key);}}}   	
   	foreach ($index as $value) {unset($respuesta['calificaOperativo'][$value]);}
 $respuesta['calificaOperativo']=array_values($respuesta['calificaOperativo']);
unset($index);
$index=array();
   	if($_POST['mostrarTodos']==0){foreach ($respuesta['calificaUsuario'] as $key => $value) {if($value->noConformidadRevisada==0){array_push($index, $key);}}}   	
   	foreach ($index as $value) {unset($respuesta['calificaUsuario'][$value]);}
  $respuesta['calificaUsuario']=array_values($respuesta['calificaUsuario']);
   
   }
	echo json_encode($respuesta);
}
//-------------------------------------------------------------
function calificacionporPersona(){
	if($_POST['todos']){
		$datos['todos']=$_POST['todos'];
			$datos['fechaInicial']= $this->libreriav3->convierteFecha($_POST['fechaInicialCal']);
			$datos['fechaFinal']= $this->libreriav3->convierteFecha($_POST['fechaFinalCal']);
	
	$respuesta["buena"]=$this->procesamientoncmodel->buscarcalfbuenasporpersona($datos);
	$respuesta["mala"]=$this->procesamientoncmodel->buscarcalfmalasporpersona($datos);
	$calificaciones=$this->procesamientoncmodel->buscarcalificacionesactividad($datos);
	$bueno=0;
	$malo=0;
	foreach ($calificaciones as  $value){
		if($value->calificacionActividad==1){
			$bueno=$bueno+1;
			} else{$malo=$malo+1;}
	}
	//$respuesta=array('bueno' => $bueno, 'malo' => $malo);
	$respuesta["totalbueno"]=$bueno;
	$respuesta["totalmalo"]=$malo;
	echo json_encode($respuesta);
	}

	

}
//-------------------------------------------------------------
function calificacionesactividad(){
	$datos['fechaInicial']= $this->libreriav3->convierteFecha($_POST['fechaInicialCal']);
	$datos['fechaFinal']= $this->libreriav3->convierteFecha($_POST['fechaFinalCal']);
	$datos['todos']=$_POST['todos'];
	$idPersona=$this->tank_auth->get_idPersona();
	$datos['idpersona']=$idPersona;
	$calificaciones=$this->procesamientoncmodel->buscarcalificacionesactividad($datos);
	$bueno=0;
	$malo=0;
	foreach ($calificaciones as  $value){
		if($value->calificacionActividad==1){
			$bueno=$bueno+1;
			} else{$malo=$malo+1;}
	}
	$respuesta=array('bueno' => $bueno, 'malo' => $malo);
	 echo json_encode($respuesta);
}


//-------------------------------------------------------------
function calificacionesactividadEjecutivo(){
	$datos['fechaInicial']= $this->libreriav3->convierteFecha($_POST['fechaInicialEjec']);
	$datos['fechaFinal']= $this->libreriav3->convierteFecha($_POST['fechaFinalEjec']);
	$datos['todos']=$_POST['todosEjec'];
	$calificacionestotales=$this->procesamientoncmodel->buscarcalificacionesactividadEjecutivo($datos);
	$calificacionesmalas=$this->procesamientoncmodel->buscarcalificacionesactividadEjecutivoMalas($datos);
	$calificacionesbuenas=intval($calificacionestotales[0]->bueno)-intval($calificacionesmalas[0]->malo);
	$respuesta["bueno"]=$calificacionesbuenas;
	$respuesta["malo"]=$calificacionesmalas[0]->malo;
	 echo json_encode($respuesta);
}

//-------------------------------------------------------------
function guardadoForm(){

$datos['valores']="otro valor";
$datos['respuesta']="Cuestionario guardado";
echo json_encode($datos);

}
//-------------------------------------------------------------
function eliminaCausaRaiz()
{
	$update['idCausaRaiz']=$_POST['idCausaRaiz'];
	$update['estaHabilitado']=0;
	$update['update']=1;
	$this->procesamientoncmodel->causaraiz($update);
	$datos['idCausaRaiz']=$_POST['idCausaRaiz'];
	$datos['mensaje']='Eliminacion Exitosa';
	echo json_encode($datos);

}
//-------------------------------------------------------------
function eliminaAccionCorrectiva()
{
	$update['idAccionCorrectiva']=$_POST['idAccionCorrectiva'];
	$update['estaHabilitado']=0;
	$update['update']=1;
	$this->procesamientoncmodel->accioncorrectiva($update);
	$datos['idAccionCorrectiva']=$_POST['idAccionCorrectiva'];
	$datos['mensaje']='Eliminacion Exitosa';
	echo json_encode($datos);
}
//----------------------------------------------------
function reporteEstrellasAgente()
{
  $respuesta=array();

  if(isset($_GET['fechaInicial']))
  {
	$_GET['fechaInicial']=$this->libreriav3->convierteFecha($_GET['fechaInicial']);
	$_GET['fechaFinal']=$this->libreriav3->convierteFecha($_GET['fechaFinal']);
	$respuesta['datos']=$this->procesamientoncmodel->reporteEstrellasAgente($_GET);
  }
  else
  {
	$respuesta['datos']=$this->procesamientoncmodel->reporteEstrellasAgente(); 
  }

  $respuesta['mensaje']="bien";
  
  echo json_encode($respuesta);
}//----------------------------------------------------
 function devolverAgentes(){

 $array['grupos']=1;
 $respuesta=$this->PersonaModelo->obtenerVendActivos($array);
 
 echo json_encode($respuesta);
 }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
 function devolverOperativos(){


 $array['grupos']=1;
 $respuesta=$this->PersonaModelo->devolverColaboradoresActivos($array);



 echo json_encode($respuesta);	
 }
//---------------------------------------------------------
function obtenerComentarios()
{   $consultar=array();   
	$consultar['idTablaNoConformidad']=$_POST['id'];
	  $datos['comentarios']=$this->procesamientoncmodel->tablanoconformidadcomentarios($consultar);  
	      $datos['responsables']=$this->procesamientoncmodel->tablanoconformidadresponsablesSeleccionar($_POST['id']);
	 $datos['idtablanoconformidad']=$_POST['id'];
    
  echo json_encode($datos);
}
//---------------------------------------------------------
function guardarComentarios()
{

 $insert['idTablaNoConformidad']=$_POST['id'];
 $insert['comentarios']=$_POST['comentario'];
 $insert['idTNCComentarios']=$_POST['idTNCComentarios'];
 $insert['tipoComentario']=$_POST['tipoComentario'];
 $this->procesamientoncmodel->tablanoconformidadcomentarios($insert);
 unset($insert['idTNCComentarios']);
  $datos['comentarios']=$this->procesamientoncmodel->tablanoconformidadcomentarios($insert);  
  $dato['idTablaNoConformidad']=$_POST['id'];
  echo json_encode($datos);
}

//---------------------------------------------------------
function eliminarComentario()
{
	 $update['estaEliminado']=1;
	 $update['idTNCComentarios']=$_POST['idTNCComentarios'];
	 
	 $update['update']='';
	 $this->procesamientoncmodel->tablanoconformidadcomentarios($update);
	 $consulta['idTablaNoConformidad']=$_POST['id'];
	 $datos['comentarios']=$this->procesamientoncmodel->tablanoconformidadcomentarios($consulta);  

  echo json_encode($datos);
	 
}
//---------------------------------------------------------
function actualizarComentario()
{
	 
	 $update['idTNCComentarios']=$_POST['idTNCComentarios'];
	 $update['comentarios']=$_POST['comentario'];	 
	 $update['update']='';
	 $this->procesamientoncmodel->tablanoconformidadcomentarios($update);
	 $consulta['idTablaNoConformidad']=$_POST['id'];
	 $datos['comentarios']=$this->procesamientoncmodel->tablanoconformidadcomentarios($consulta); 	 
   echo json_encode($datos);

}
//---------------------------------------------------------
function eliminarNoConformidadResuelta()
{
	$datos=array();
	$datos['success']=true;
	$datos['idtablanoconformidad']=array();
	$parametros=json_decode($_POST['params']);
	$borrar=explode(',', $parametros->value);
	foreach ($borrar as  $value) 
	{
		if($value!='')
		{

                 $actualizar['noConformidadRevisada']=1;
			      $actualizar['update']=true;
			    $actualizar['idTablaNoConformidad']=$value;
	        $this->procesamientoncmodel->tablanoconformidad($actualizar);
			array_push($datos['idtablanoconformidad'], $value);
		}
	}
	
	echo json_encode($datos);
}
//---------------------------------------------------------
function guardarCambiosNC()
{
	/// Obtenemos el json enviado
$parametros=json_decode($_POST['params']);

$datos['success']=true;	  
$bitacoraArray=array();
	  $actualizar=array();
	  
	  $email=$this->tank_auth->get_usermail();
	  
	  if(isset($parametros->comentarioInconforme)){$actualizar['comentarioInconforme']=$parametros->comentarioInconforme;}
	  if(isset($parametros->comentarioResponsable)){$actualizar['comentarioResponsable']=$parametros->comentarioResponsable;}	   
	  if(isset($parametros->causaRaiz))
	  {
	  	$actualizar['idCausaRaiz']=$parametros->causaRaiz;
	  	$dat=$this->db->query('select t.idTablaNoConformidad,t.idCausaRaiz,t.idAccionCorrectiva,t.aFavor,c.causaRaiz,(select causaraiz from causaraiz where idCausaRaiz='.$parametros->causaRaiz.') as nuevoCausaRaiz from tablanoconformidad t left join causaraiz c on c.idCausaRaiz=t.idCausaRaiz where t.idTablaNoConformidad='.$parametros->value)->result()[0];
	  	$insert='insert into inconformidades_bitacora  (inconformidad,movimiento,campoDeTabla,newValue,oldValue,email) values ("'.$parametros->value.'","SE ASIGNO O SE MODIFICO LA CAUSA RAIZ EN:'.$dat->nuevoCausaRaiz.'","causaRaiz","'.$parametros->causaRaiz.'","'.$dat->idCausaRaiz.'","'.$email.'")';
	  	array_push($bitacoraArray, $insert);
	  	

	  }
	  if(isset($parametros->accionCorrectiva))
	  {
	  	$actualizar['idAccionCorrectiva']=$parametros->accionCorrectiva;
	  	$dat=$this->db->query('select t.idTablaNoConformidad,t.idCausaRaiz,t.idAccionCorrectiva,t.aFavor,c.accionCorrectiva,(select accioncorrectiva from accioncorrectiva where idAccionCorrectiva='.$parametros->accionCorrectiva.') as nuevoAccionCorrectiva from tablanoconformidad t left join accioncorrectiva c on c.idAccionCorrectiva=t.idAccionCorrectiva where t.idTablaNoConformidad='.$parametros->value)->result()[0];
       	  	$insert='insert into inconformidades_bitacora  (inconformidad,movimiento,campoDeTabla,newValue,oldValue,email) values ("'.$parametros->value.'","SE ASIGNO O SE MODIFICO LA ACCION CORRENTIVA EN:'.$dat->nuevoAccionCorrectiva.'","accionCorrectiva","'.$parametros->accionCorrectiva.'","'.$dat->idAccionCorrectiva.'","'.$email.'")';
	  	array_push($bitacoraArray, $insert);

	  }
	  if(isset($parametros->veredicto))
	  {
	  	$actualizar['aFavor']=$parametros->veredicto;
	  	$dat=$this->db->query('select t.idTablaNoConformidad,t.idCausaRaiz,t.idAccionCorrectiva,t.aFavor,c.status,(select status from tablanoconformidadstatus where idTNCStatus='.$parametros->veredicto.') as nuevoAFavor from tablanoconformidad t left join tablanoconformidadstatus c on c.idTNCStatus=t.aFavor where t.idTablaNoConformidad='.$parametros->value)->result()[0];

       	  	$insert='insert into inconformidades_bitacora  (inconformidad,movimiento,campoDeTabla,newValue,oldValue,email) values ("'.$parametros->value.'","SE ASIGNO O SE MODIFICO EL STATUS:'.$dat->nuevoAFavor.'","aFavor","'.$parametros->veredicto.'","'.$dat->aFavor.'","'.$email.'")';
	  	array_push($bitacoraArray, $insert);
	  }
	  if(isset($parametros->value)){$actualizar['idTablaNoConformidad']=$parametros->value;}
      if(isset($parametros->delete)){$actualizar['noConformidadRevisada']=1;}
      if(isset($parametros->personaResponsable))
      {
      	$segmento=explode(',', $parametros->personaResponsable); 
        $this->procesamientoncmodel->tablanoconformidadresponsablesBorrar($parametros->value);
        foreach ($segmento as $value) 
        {
    	 if($value!='')
    	 {
    	   $insertar['idPersona']=$value;    		
    	   $insertar['idTablaNoConformidad']=$parametros->value;
    		$this->procesamientoncmodel->tablanoconformidadresponsables($insertar);
    	}
      }     

      }
      $actualizar['update']=true;
	  $datos=$this->procesamientoncmodel->tablanoconformidad($actualizar);
      $datos['value']=$parametros->value;
      if(isset($parametros->causaRaiz))
     {

	  		$array['nombre']=$parametros->extra;
	  		$array['idTablaParaTarea']=$parametros->value;
	  		$array['tablaParaTarea']="tablanoconformidad";
	  		$array['usuario']=910;
	  		 
	  		if($parametros->causaRaiz==15 || $parametros->causaRaiz==19){$array['identificaProyectoAutomatico']  ='inconformidadesDeSistemas';}
	  		else{$array['identificaProyectoAutomatico']  ='seguimientoDeInconformidades';}
	  		      
	$responsableNC=$this->db->query('select (if(idPersonaResponsable is null,0,idPersonaResponsable)) as idPersona from tablanoconformidad where idTablaNoConformidad='.$parametros->value.' union select tr.idPersona from tablanoconformidadresponsables tr where tr.idTablaNoConformidad='.$parametros->value)->result();


          	           	$array['personasResponsables']=array();
      	           	foreach ($responsableNC as  $value) 
      	           	{   
                        if((int)$value->idPersona>0)
                        {
      	           		$agregar=array();      	           		 
      	           		$datosPersona=$this->PersonaModelo->buscaPersona($value->idPersona,'','');  
                        $agregar['correo']=$datosPersona->emailUsers;
                        $agregar['nombre']=$datosPersona->nombres.' '.$datosPersona->apellidoPaterno.' '.$datosPersona->apellidoMaterno;
                        $agregar['id']=$datosPersona->idPersona;
                        $agregar['tipo']='OPERATIVO';
                        array_push($array['personasResponsables'],$agregar);
      	               }
      	           	}        	       
	  		$this->modeloproyecto->crearProyectoAutomatico($array);
       }
       foreach ($bitacoraArray as $key => $valBit) {$this->db->query($valBit);}
            $datos['comentarioBitacora']=$this->db->query('select * from inconformidades_bitacora where inconformidad='.$parametros->value.' order by fechaMovimiento desc')->result();
     $datos['idtablanoconformidad']=$parametros->value;
       //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp,print_r($bitacoraArray,TRUE));fclose($fp); 
	  echo json_encode($datos);
}
//-------------------------------------------------
function guardarCambiosNoConformidad()
{


	$update['idCausaRaiz']=null;//$_POST['causaRaiz'];
    $update['idAccionCorrectiva']=null;//$_POST['accionCorrectiva'];
	$update['idTablaNoConformidad']=$_POST['id'];	
	$update['aFavor']=null;//$_POST['veredicto'];
          
	if(isset($_POST['comentario'])){$update['comentarioCierre']=$_POST['comentario'];}
	if(isset($_POST['status'])){$update['statusNoconformidad']=$_POST['status'];}
	if(isset($_POST['nombre'])){$update['nombreNoConformidad']=$_POST['nombre'];}	
	if(isset($_POST['comentarioCausaRaiz'])){$update['comentarioCausaRaiz']=$_POST['comentarioCausaRaiz'];}
	if(isset($_POST['comentarioAccionCorrectiva'])){$update['comentarioAccionCorrectiva']=$_POST['comentarioAccionCorrectiva'];}
    $update['update']=true;
	$datos=$this->procesamientoncmodel->tablanoconformidad($update);

	$consulta['idTablaNoConformidad']=$_POST['id'];
	$datos['datosNoConformidad']=$this->procesamientoncmodel->tablanoconformidadDatos($consulta);
	$consulta['idTablaNoConformidad']=$_POST['id'];
	echo json_encode($datos);

}
//---------------------------------------------------------
function guardarResponsables()
{

    $segmento=explode(';', $_POST['idPersona']);
    $datos=array();
    $this->procesamientoncmodel->tablanoconformidadresponsablesBorrar($_POST['id']);
    foreach ($segmento as $value) 
    {
    	if($value!=''){
           $partes=explode('-', $value);
    		$insertar['idPersona']=$partes[0];
    		$insertar['conformidadMala']=$partes[1];
    		$insertar['idTablaNoConformidad']=$_POST['id'];
    		$this->procesamientoncmodel->tablanoconformidadresponsables($insertar);
    	}
    }

    $datos['responsables']=$this->procesamientoncmodel->tablanoconformidadresponsablesSeleccionar($_POST['id']);
    
    echo json_encode($datos);
}
//---------------------------------------------------------
function eliminarResponsable()
{

    $idPersona=($_POST['idPersona']);
    $idtablanoconformidad=($_POST['idtablanoconformidad']);
    $datos=$this->procesamientoncmodel->tablanoconformidadeliminarResponsable($idtablanoconformidad,$idPersona);
    echo json_encode($datos);
}
//---------------------------------------------------------
function buscarReporteGraficas(){

	$respuesta="";
    $ultimoDiaDeMes="";
    $anios=array();

if(isset($_POST['fechaInicialGraf']))
	{
		//$_POST['fechaInicial']=$_POST['fechaInicialGraf'];
		//$_POST['fechaFinal']=$_POST['fechaFinalGraf'];
		

	 switch ($_POST['tipoBusqueda']) {
	 	case 'Dia':
	 		$_POST['fechaInicial']=$_POST['anioBusqueda'].'-'.$_POST['mesBusqueda'].'-01';
	 		$ultimoDia=$this->libreriav3->devolverUltimoDiaDeMes('-',$_POST['mesBusqueda'],$_POST['anioBusqueda']);
	 		$_POST['fechaFinal']=$this->libreriav3->convierteFecha($ultimoDia);
	 		$ultimoDia=explode('-', $ultimoDia);
	 		$ultimoDiaDeMes=$ultimoDia[0];

	 		break;
	 	case 'Mes':
	 		$_POST['fechaInicial']=$_POST['anioBusqueda'].'-01'.'-01';
	 		$_POST['fechaFinal']=$_POST['anioBusqueda'].'-12'.'-31';
	 		
	 		
	 		break;
    	case 'Anio':
	 		$_POST['fechaInicial']=$_POST['anioBusqueda'].'-01'.'-01';
	 		$fechaActual=$this->libreriav3->devolverFechaActual('-');
            $anioActual=explode('-',$fechaActual);
            $_POST['fechaFinal']=$anioActual[2].'-12'.'-31';
            $inter=$anioActual[2]-$_POST['anioBusqueda'];
            $anioBusqueda=$_POST['anioBusqueda'];
            for($i=0;$i<=$inter;$i++)
            {   
            	array_push($anios, $anioBusqueda);
            	$anioBusqueda++;
            }
	 		break;	 		
	 }
	}
else
{
	$_POST['fechaInicial']=$this->libreriav3->convierteFecha($_POST['fechaInicial']);
	$_POST['fechaFinal']=$this->libreriav3->convierteFecha($_POST['fechaFinal']);

}
	$tipoPersona=0;
	$idPersona=0;
	
	
if(isset($_POST['Persona']))
{
	if(isset($_POST['idPersona']))
	{
      $respuesta=$this->procesamientoncmodel->tablaNCFechas($_POST);      
	  $idPersona=$_POST['idPersona'];
	  $tipoPersona=$_POST['Persona'];
	   foreach ($respuesta['personaRevisada'] as $key => $value) {
	    	   
		   foreach ($respuesta['personaRevisada'] as $key => $value) {if($value['tipoPersona']!=$tipoPersona){unset($value[$key]);}}
		   }
		  // 
       $respuesta['mensaje']='';
	}
	else
	{$tipoPersona=$_POST['Persona'];
     if($_POST['Persona']==1)
     {
       $datos=$this->PersonaModelo->obtenerEmpleadosActivos();
       $where='in (';
      foreach ($datos as  $value)
      { 
        if($value === end($datos)){$where.=$value->idPersona.')';}
        else{$where.=$value->idPersona.',';}
      }

      $_POST['where']=$where;
      $respuesta=$this->procesamientoncmodel->tablaNCFechas($_POST);  	   
      $respuesta['mensaje']='';
     }
     else
     {      
      $respuesta=$this->procesamientoncmodel->tablaNCFechas($_POST);      	   
       $respuesta['mensaje']='';
     }
	}
}
else
 {
	if($_POST['fechaFinal']!='' && $_POST['fechaInicial']!='')
	{
		$respuesta=$this->procesamientoncmodel->tablaNCFechas($_POST);
		
        $respuesta['mensaje']='';
	}
	else{$respuesta['mensaje']='Tiene que poner un rango de fechas';}
 }
   $respuesta['tipoPersona']=$tipoPersona;
   $respuesta['idPersona']=$idPersona;
   if(isset($_POST['mostrarTodos']))
   {unset($respuesta['personaRevisada']);
   	$index=array();
   	if($_POST['mostrarTodos']==0){foreach ($respuesta['calificaAgente'] as $key => $value) {if($value->noConformidadRevisada==0){array_push($index, $key);}}}   	
   	foreach ($index as $value) {unset($respuesta['calificaAgente'][$value]);}
   	$respuesta['calificaAgente']=array_values($respuesta['calificaAgente']);
unset($index);
$index=array();
   	if($_POST['mostrarTodos']==0){foreach ($respuesta['calificaCliente'] as $key => $value) {if($value->noConformidadRevisada==0){array_push($index, $key);}}}   	
   	foreach ($index as $value) {unset($respuesta['calificaCliente'][$value]);}
$respuesta['calificaCliente']=array_values($respuesta['calificaCliente']);
unset($index);
$index=array();
   	if($_POST['mostrarTodos']==0){foreach ($respuesta['calificaOperativo'] as $key => $value) {if($value->noConformidadRevisada==0){array_push($index, $key);}}}   	
   	foreach ($index as $value) {unset($respuesta['calificaOperativo'][$value]);}
 $respuesta['calificaOperativo']=array_values($respuesta['calificaOperativo']);
unset($index);
$index=array();

   	if($_POST['mostrarTodos']==0){foreach ($respuesta['calificaUsuario'] as $key => $value) {if($value->noConformidadRevisada==0){array_push($index, $key);}}}   	
   	foreach ($index as $value) {unset($respuesta['calificaUsuario'][$value]);}
  $respuesta['calificaUsuario']=array_values($respuesta['calificaUsuario']);
   //
   }

  if(isset($_GET['fechaInicial'])){$respuesta['estrellas']=$this->procesamientoncmodel->reporteEstrellasAgente($_POST);}
  else{$respuesta['estrellas']=$this->procesamientoncmodel->reporteEstrellasAgente(); }

  
 if(isset($_POST['tipoBusqueda'])){$respuesta['tipoBusqueda']=$_POST['tipoBusqueda'];}
  $respuesta['ultimoDiaDeMes']=$ultimoDiaDeMes;
  $respuesta['tipoBusqueda']=$_POST['tipoBusqueda'];
  $respuesta['meses']=$this->libreriav3->devolverMeses(); 
  $respuesta['anios']=$anios;
  $respuesta['causaRaizGrafica']=$this->db->query('select distinct(causaRaiz) from causaraiz')->result(); 

	echo json_encode($respuesta);
}

//--------------------------------------
function guardarBitacoraComentario()
{
	$respuesta['succes']=true;
	$respuesta['comentarioBitacora']=array();
       
     $insert['inconformidad']=$_POST['idtablanoconformidad'];
     $insert['movimiento']=$_POST['comentario'];
     $insert['email']=$this->tank_auth->get_usermail();
     $this->db->insert('inconformidades_bitacora',$insert);     
     //$respuesta['comentarioBitacora']=$this->db->query('select * from inconformidades_bitacora where inconformidad='.$_POST['idtablanoconformidad'].' order by fechaMovimiento desc')->result();
     
     $respuesta['idtablanoconformidad']=$_POST['idtablanoconformidad'];
     $respuesta['comentario']=$_POST['comentario'];
     
     
     $respuesta['fecha']=$this->db->query('select (now()) as fecha')->result()[0]->fecha;
     $respuesta['email']=$this->tank_auth->get_usermail();
	echo json_encode($respuesta);
}
//--------------------------------------
function um()
{
	$responsableNC=$this->db->query('select (if(idPersonaResponsable is null,0,idPersonaResponsable)) as idPersona from tablanoconformidad where idTablaNoConformidad=39 union select tr.idPersona from tablanoconformidadresponsables tr where tr.idTablaNoConformidad=39')->result();


          	           	$array['personasResponsables']=array();
      	           	foreach ($responsableNC as  $value) 
      	           	{   
                        if((int)$value->idPersona>0)
                        {
      	           		$agregar=array();      	           		 
      	           		$datosPersona=$this->PersonaModelo->buscaPersona($value->idPersona,'','');  
                        $agregar['correo']=$datosPersona->emailUsers;
                        $agregar['nombre']=$datosPersona->nombres.' '.$datosPersona->apellidoPaterno.' '.$datosPersona->apellidoMaterno;
                        $agregar['id']=$datosPersona->idPersona;
                        $agregar['tipo']='OPERATIVO';
                        array_push($array['personasResponsables'],$agregar);
      	               }
      	           	}      	           

             	           		 
      	           		    

}
//---------------------------------------------
}
 