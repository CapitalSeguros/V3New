<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class actividades_model extends CI_Model
{
  function devolverCorreoResponsableActividad($ramo,$autosParaRenovacion=false)
  {
  	/*
  	$ramo = es el nombre del ramo
    $autosParaRenovacion= como responsable del ramo de autos esta AUTOS@ASESORESCAPITAL.COM 
                          pero en renovaciones se necesita pasarselo a AUTOSRENOVACIONES@ASESORESCAPITAL.COM
                          por lo que si la variable viene en true y el $ramo=VEHICULOS entonces regresamos el correo de AUTOSRENOVACIONES@ASESORESCAPITAL.COM, en caso contrario regresamoes el de AUTOS@ASESORESCAPITAL.COM
  	 */
  	$respuesta=new \stdClass;
  	$respuesta->encontrado=false;
  	$respuesta->email='';
  	$respuesta->idPersona=0;
    if($ramo=='DANOS' || $ramo=='DAÑOS' || $ramo=='DANIOS'){$ramo='DAÑOS';}
    else
    {           
      if($ramo=='Accidentes y Enfermedades' || $ramo=='Accidentes_y_Enfermedades'){$ramo='ACCIDENTES Y ENFERMEDADES';}
      else{$ramo=strtoupper($ramo);}
    }
    $consulta='select emailResponsable from catalog_ramos where Nombre="'.$ramo.'"';

    $datos=$this->db->query($consulta)->result();
    if(count($datos)>0)
    {
    	$respuesta->encontrado=true;
    	
    	$respuesta->email=(string)$datos[0]->emailResponsable;

    	if($autosParaRenovacion){$respuesta->email='AUTOSRENOVACIONES@ASESORESCAPITAL.COM';}
    	$consulta='select idPersona from users u where u.banned=0 and u.activated=1 and u.email="'.$respuesta->email.'"';    	
    	$idPersona=$this->db->query($consulta)->result();    	
        if(count($idPersona)>0){$respuesta->idPersona=$idPersona[0]->idPersona;}    	
    }

    return $respuesta;
  }
 //-----------------------------------------------------------
 function devolverRamosDelResponsable($email)
 {
   /*
     $email es le email del usuario responsable
     bienes debe ver daños,lineas personales vide y accidentes     
    */
   $condicion='where ';
   $respuesta=new \stdClass;   
   if($email=='SISTEMAS@ASESORESCAPITAL.COM'){$condicion='';    }
   else
   {
     if($email=='AUTOSRENOVACIONES@ASESORESCAPITAL.COM'){$condicion.='emailResponsable in ("AUTOS@ASESORESCAPITAL.COM")';}
     else
     {
   	   if($email=='BIENES@ASESORESCAPITAL.COM'){$condicion.='emailResponsable in ("BIENES@ASESORESCAPITAL.COM","LINEASPERSONALES@ASESORESCAPITAL.COM")';}
   	   else
   	   {
   		$condicion.='emailResponsable in ("'.$email.'")';
   	  }
     }
   }
   $consulta="select Nombre,IDRamo,emailResponsable from catalog_ramos  ".$condicion;
   $respuesta=$this->db->query($consulta)->result();
   return $respuesta;
 }
 //-----------------------------------------------------------
// Tablas Permisos Actividades por Operativos
  function TablaActividades(){    
    $sql = "select * from catalog_actividades";
    $query = $this->db->query($sql);
    return $query->num_rows() > 0 ? $query->result() : array();
  }

  // function TablaRamos(){    
  //   $sql = "select * from catalog_ramos";
  //   $query = $this->db->query($sql);
  //   return $query->num_rows() > 0 ? $query->result() : array();
  // }

  // function TablaSubRamos(){    
  //   $sql = "select * from catalog_subramos";
  //   $query = $this->db->query($sql);
  //   return $query->num_rows() > 0 ? $query->result() : array();
  // }

  function TablaRamo($id) {
    if ($id == "1") {
      $query = $this->db->query("SELECT * FROM catalog_ramos WHERE IDRamo='1' OR IDRamo='2' OR IDRamo='3' OR IDRamo='4' OR IDRamo='5' OR IDRamo='6'");
    }
    else if($id == "2" || $id == "4" || $id == "5" || $id == "6" || $id == "9" || $id == "12" || $id == "14"){
      $query = $this->db->query("SELECT * FROM catalog_ramos");
    }
    else if($id == "15"){
      /*VINCULARA SUSTITUCION CON TODOS LOS RAMOS CAMBIO REALIZADO POR LOCM 20/09/2024 */
      //$query = $this->db->query("SELECT * FROM catalog_ramos WHERE IDRamo='2'");
      $query = $this->db->query("SELECT * FROM catalog_ramos ");
    }
    else if($id == "16"){
      $query = $this->db->query("SELECT * FROM catalog_ramos WHERE IDRamo='7' OR IDRamo='8' OR IDRamo='9' OR IDRamo='10'");
    }
    return $query->num_rows() > 0 ? $query->result() : array();
  }

  function TablaSubRamo($id) {
    $this->db->select('s.IDRamo, IDSRamo, s.Nombre');
    $this->db->join('catalog_ramos r','r.IDRamo=s.IDRamo','inner');
    if(!empty($id)){
     $this->db->where("s.IDRamo", $id);
    }
    $query = $this->db->order_by("IDSRamo", "asc")->get("catalog_subRamos s");
    return $query->num_rows() > 0 ? $query->result() : array();
  }

  function PermisosOp($email,$ramo='',$actividad='') {

    $this->db->select('a.subRamo, actividad, ramo, email, area');
    $this->db->join('catalog_subRamos s', 's.IDSRamo=a.subRamo', 'left');
    if(!empty($email)){$this->db->where("email", $email);}
    if($ramo!=''){$this->db->where("ramo",$ramo); }
    if($actividad!=''){$this->db->where("actividad",$actividad); }

    $query = $this->db->get("actividadespermisos a");

    return $query->num_rows() > 0 ? $query->result() : array();
  }
//--------------------------------------------
  function TablaPermisosGeneral($email)
  {    
    $this->db->select('c.idActividad, c.nombre, c.activo, r.IDRamo, r.Nombre, s.IDSRamo, s.IDRamo, s.Nombre, a.actividad, a.ramo, a.subRamo, a.email, a.area');
    $this->db->join('catalog_actividades c', 'c.nombre=a.actividad', 'full');
    $this->db->join('catalog_ramos r', 'r.Nombre=a.ramo', 'r.IDRamo=s.IDRamo', 'full');
    $this->db->join('catalog_subRamos s', 's.IDSRamo=a.subRamo','full');
    if (!empty($email)) {
      $this->db->where('a.email', $email);
    }

    //$this->db->where('c.activo', $active);
    $query = $this->db->order_by("c.nombre", "asc")->get('actividadespermisos a');
    
    return $query->num_rows() > 0 ? $query->result() : array();
  }
//--------------------------------------------
  /*function PermisosDeOperativo() {
    $data = array (
      'actividad'=>$this->input->post('ac'),
      'ramo'=>$this->input->post('rm'),
      'subRamo'=>$this->input->post('sr'),
      'email'=>$this->input->post('cr'),
    );
    return $this->db->insert('actividadespermisos',$data);
  }*/

  /*function CambioDePermiso($correo,$actividad,$ramo,$subramo) {
    $this->db->where('email',$correo);
    $this->db->where('actividad',$actividad);
    $this->db->where('ramo',$ramo);
    $this->db->set('subRamo',$subramo);
    return $this->db->update('actividadespermisos');
  }*/

  function BorrarPermisoActual($correo,$actividad,$ramo,$subramo) {
    $this->db->delete('actividadespermisos', array(
      'email' => $correo,
      'actividad' => $actividad,
      'ramo' => $ramo,
      'subRamo' => $subramo
    ));
  }

  function EliminarPermisos($correo) {
    $this->db->delete('actividadespermisos', array('email' => $correo));
  }

  function InsertPermisos($array){
    
    //foreach ($array as  $value) {
      $consulta='select * from actividadespermisos where subRamo='.$array['subRamo'].' and ramo="'.$array['ramo'].'" and actividad="'.$array['actividad'].'"';

      $datos=$this->db->query($consulta)->result();
      if(count($datos)>0)
      { if($datos->area ==null){
        $this->db->where('ramo',$array['ramo']);
        $this->db->where('actividad',$array['actividad']);
        $this->db->where('subRamo',$array['subRamo']);
        $this->db->where('area',null);
        $this->db->delete('actividadespermisos');
      }
        
      }
       $consulta2='select * from actividadespermisos where area="'.$array['area'].'" and subRamo='.$array['subRamo'].' and ramo="'.$array['ramo'].'" and actividad="'.$array['actividad'].'"';

      $datos2=$this->db->query($consulta2)->result();
    //}
    if(count($datos2)>0)
      { $this->db->where('ramo',$array['ramo']);
        $this->db->where('actividad',$array['actividad']);
        $this->db->where('subRamo',$array['subRamo']);
        $this->db->where('area',$array['area']);
        $this->db->delete('actividadespermisos'); 
      }
      
    $this->db->insert('actividadespermisos',$array);
  }

  function DeletePermisos($array){
    $this->db->delete('actividadespermisos',$array);
  }
//-----------------------------------------------------------

  function TablaPermisosOP(){    
    $this->db->select('c.idActividad, c.nombre, c.activo, r.IDRamo, r.Nombre, s.IDSRamo, s.IDRamo, s.Nombre, a.actividad, a.ramo, a.subRamo, a.email, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
    $this->db->join('catalog_actividades c', 'c.nombre=a.actividad', 'full');
    $this->db->join('catalog_ramos r', 'r.Nombre=a.ramo', 'r.IDRamo=s.IDRamo', 'full');
    $this->db->join('catalog_subramos s', 's.IDSRamo=a.subRamo','full');
    $this->db->join('persona p', 'p.emailUsers=a.email', 'full');
    $query = $this->db->get('actividadespermisos a');
    return $query->num_rows() > 0 ? $query->result() : array();
  }
//-------------------------------------------
function actividadPorIdObtener($idInterno)
{
  $respuesta=array();

  $consulta='select motivoCambio,Status,Status_Txt from actividades where idInterno='.$idInterno;
  $datos=$this->db->query($consulta)->result();
   
  count($datos)>0 ? $respuesta['actividad']=$datos[0] : $respuesta['actividad']=array();
  return $respuesta;
}
//-------------------------------------------
function idCatalogActividadesPorNombreObtener($nombre='')
{

  $select='select * from catalog_actividades where nombre="'.$nombre.'"';

  $respuesta=$this->db->query($select)->result();
  return $respuesta;
}
//-----------------------------------------------------------
}