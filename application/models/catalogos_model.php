<?php
class catalogos_model extends CI_Model{

	var $Invitados;
	public $CI;
//--------------------------------------------------------------------------	
	public function __Construct(){
		parent::__Construct();
		$this->CI =& get_instance();
	}
//--------------------------------------------------------------------------
	public function get_Ramos(){
		$insert_value = false;
		//try{
			$this->db->select("idRamo,nombre,alias,descripcion,orden,emailResponsable,idSicas","activo");			
			$this->Invitados = $this->db->get("catalog_ramos");
			
			if ($this->Invitados->num_rows() > 0){
				$result = $this->Invitados->result_array();
			}else{
				$result = array();
			}
		//}catch(Exception $e){ }
		return $result;
	}
//--------------------------------------------------------------------------	
	public function get_SubRamos($idRamo = 0){
		
		$insert_value = false;
		
		//try{
			
			$this->db->select("IDSRamo,idRamo,nombre,Abreviacion,orden,activo","activo");	
			if($idRamo > 0)
				$this->db->where('IDRamo',$idRamo);
			$this->Invitados = $this->db->get("catalog_subRamos");
			
			if ($this->Invitados->num_rows() > 0){

				$result = $this->Invitados->result_array();
			}else{
				$result = array();
			}

		//}catch(Exception $e){
			
	//	}
		
		return $result;
	}
//--------------------------------------------------------------------------
	public function get_NameSubRamo($idSubRamo){
		$result = array();
		try {
			$this->db->select("IDSRamo,nombre,orden","activo");	
			if($idSubRamo > 0)
				$this->db->where('IDSRamo',$idSubRamo);

			$this->Name = $this->db->get("catalog_subRamos");
			
			if ($this->Name->num_rows() > 0){

				$result = $this->Name->result_array();
			}
		} catch (Exception $e) {
			
		}

		return $result;
	}

	// public function get_Vendedor($idVendedor, $superior){
		// $this->db->from("catalog_vendedores");
		// $this->db->where('catalog_vendedores.Status', '0');
		// if($superior != 0){
			// $this->db->where("(catalog_vendedores.IDVend = '".$superior."' Or catalog_vendedores.IDVendNS='".$superior."')");
		// }
		// $this->db->order_by("catalog_vendedores.NombreCompleto", "asc");
		// $query = $this->db->get();
		
		// return $query->result();
	// }
	
	// public function get_Vendedor($idVendedor, $superior){
		
		// $data_role_ = array(
						// "IdTipoUser" => $this->tank_auth->get_user_id(),
						// "Profile" =>  $this->tank_auth->get_userprofile()
					 // );
		
		// if($this->CI->role->Is_Mater($data_role_) || $this->CI->role->Is_Operativo($data_role_)){
			// $query = $this->db->query('select * from catalog_vendedores where catalog_vendedores.Status = 0');
		// }
		
		// if($this->CI->role->Is_Promotor($data_role_)){
			// $query = $this->db->query("select * from catalog_vendedores where catalog_vendedores.IDVendNS='". $this->CI->role->getIDNS() ."' or catalog_vendedores.IDVend = '".$this->CI->role->getID() ."' order by catalog_vendedores.NombreCompleto asc");
		// }
		
		// if($this->CI->role->Is_Vendedor($data_role_)){
			// $query = $this->db->query("select * from catalog_vendedores where catalog_vendedores.IDVend = '".$this->CI->role->getID() ."' order by catalog_vendedores.NombreCompleto asc" );
		// }
				
		// return $query->result();
	// }
//--------------------------------------------------------------------------	 
	 public function get_Vendedor($idVendedor = 0, $superior = 0){

	 	$result = array();
		$data_role_ = array(
		"IdTipoUser" => $this->tank_auth->get_user_id(),
		"Profile" =>  $this->tank_auth->get_userprofile()
		);


		if($this->CI->role->Is_Mater($data_role_) || $this->CI->role->Is_Operativo($data_role_) || $this->CI->role->Is_Nube($data_role_)){
			
			if($idVendedor > 0 && $superior > 0)
				$query = $this->db->query("select * from catalog_vendedores where catalog_vendedores.Status = 0 and catalog_vendedores.IDVendNS='". $superior ."' Order By catalog_vendedores.NombreCompleto asc" );
			else
				$query = $this->db->query('select * from catalog_vendedores  Order By catalog_vendedores.NombreCompleto asc');
			//para operativos trae todos los agentes para no omitir ningun cliente y hacer cambios para busquedas

			$result = $query->result();
		}

		if($this->CI->role->Is_Promotor($data_role_)){
	
	
			if($idVendedor > 0 && $superior > 0)
				$query = $this->db->query("select * from catalog_vendedores where catalog_vendedores.Status = 0 and catalog_vendedores.IDVendNS='". $superior ."' or catalog_vendedores.IDVend = '".$this->CI->role->getID() ."' " );
			else
				$query = $this->db->query("select * from catalog_vendedores where catalog_vendedores.Status = 0 and catalog_vendedores.IDVendNS='". $this->CI->role->getIDNS() ."' or catalog_vendedores.IDVend = '".$this->CI->role->getID() ."'  order by catalog_vendedores.NombreCompleto asc");

			$result = $query->result();
		}

		if($this->CI->role->Is_Vendedor($data_role_)){

			// if($idVendedor > 0 && $superior > 0)
			// 	$query = $this->db->query("select * from catalog_vendedores where catalog_vendedores.Status = 0 and catalog_vendedores.IDVendNS='". $superior ."'" );
			// else
			$query = $this->db->query("select * from catalog_vendedores where catalog_vendedores.Status = 0 and catalog_vendedores.IDVend = '".$this->CI->role->getID() ."' order by catalog_vendedores.NombreCompleto asc" );

			$result = $query->result();
		}

		return $result;
	}
//--------------------------------------------------------------------------	
	public function get_Promotor($idVendedor, $superior){
		$data_role_ = array(
			"IdTipoUser" => $this->tank_auth->get_user_id(),
			"Profile" =>  $this->tank_auth->get_userprofile()
		);
		$result = array();
		if($this->CI->role->Is_Mater($data_role_) || $this->CI->role->Is_Operativo($data_role_)){
			$query = $this->db->query("select * from users where users.profile ='2' order by users.name_complete asc");
			$result = $query->result();
		}
		if($this->CI->role->Is_Promotor($data_role_)){
			$query = $this->db->query("select * from users where users.profile ='2' and users.IdVend ='". $idVendedor ."' order by users.name_complete asc");
			$result = $query->result();
		}
		if($this->CI->role->Is_Vendedor($data_role_)){
			$result = array();
		}

		return $result;
	}

//--------------------------------------------------------------------------	
	public function get_Grupos(){
		
		$insert_value = false;
		try{
			
			$this->db->select("IdGrupo,Grupo");			
			$this->db->where("IDGrupoNS","0");
			$this->Invitados = $this->db->get("catalog_grupos");
			
			if ($this->Invitados->num_rows() > 0){

				$result = $this->Invitados->result_array();
			}else{
				$result = array();
			}

		}catch(Exception $e){
			
		}
		
		return $result;
	}
//--------------------------------------------------------------------------
	public function GuardarBusqueda($data){
		$this->db->insert('bitacora_validacion', $data);
	}	
//--------------------------------------------------------------------------
	public function validAgente($name){
		try{



			$sqlValidaAgente = "
			Select 
				Concat(`nombre`, ' ', `apellidop`, ' ', `apellidom`) As `nombreCompleto`, 
				`fotoUser`, 
				`emailUser`, 
				`Expediente`, 
				`Giro`, 
				`Ranking`,
				`certificacion`, 
				`certificacionAutos`, 
				`certificacionGmm`, 
				`certificacionVida`, 
				`certificacionDanos`,
				`certificacionFianzas`
				`idPersona`
			From 
				`user_miInfo`
			Where
				(
					`IDVend` Is Not Null 
					And
					`IDVend` != '0'
				)
				And
				(
					`Expediente` LIKE '%".$name."%'
					Or
					Concat(`nombre`, ' ', `apellidop`, ' ', `apellidom`) Like '%".$name."%'
					-- Or
					-- `emailUser` Like '%".$name."%'
				)
			Order By
				`certificacion`, `Giro`, Concat(`nombre`, ' ', `apellidop`, ' ', `apellidom`) Asc
							   ";
			$query = $this->db->query($sqlValidaAgente);
			if($query->num_rows() > 0){

				$result = $query->result_array();
			} else {
				$result = array();
			}
							   
			/*
			if($this->startsWith($name,'GAFET') && strlen($name) <= 7)
				return array();
			$this->db->select("CONCAT(nombre,' ',apellidop, ' ', apellidom) AS `nombre`,fotoUser,emailUser,Giro,Actividad",FALSE);			
			
			$this->db->like('Expediente',$name);

			$this->Invitados = $this->db->get("user_miInfo");

			if ($this->Invitados->num_rows() > 0){

				$result = $this->Invitados->result_array();
			}else{
				$result = array();
			}
			*/
		}catch(Exception $e){
		
		}
		return 
			$result;
	}
//--------------------------------------------------------------------------
	public function validClave($name){
		try{
			$sqlValidaAgente = "
			Select 
				Concat(`nombre`, ' ', `apellidop`, ' ', `apellidom`) As `nombreCompleto`, 
				`fotoUser`, 
				`emailUser`, 
				`Expediente`, 
				`Giro`, 
				`Ranking`,
				`cedula_cnsf`,
				`tipo_cedula_cnsf`,
				`vigencia_cnsf`,
				`IDValida`,
				`certificacion`, 
				`certificacionAutos`, 
				`certificacionGmm`, 
				`certificacionVida`, 
				`certificacionDanos`,
				`certificacionFianzas`,
				`fotoconcurso1`,
				`fotoconcurso2`,
				`fotoconcurso3`,
				`fotoconcurso4`,
				`fotoconcurso5`,
				`fotoconcurso6`,
				`polrescivil`,
				`sumaaseg`,
				`vigenciapolrescivil`,
				`porcentajesa`, 
                `idPersona`
			From 
				`user_miInfo`  
			Where
				(
					`IDValida` LIKE '%".$name."%'
				)
			Order By
				`certificacion`, `Giro`, Concat(`nombre`, ' ', `apellidop`, ' ', `apellidom`) Asc
							   ";
			
			$query = $this->db->query($sqlValidaAgente);			
			if($query->num_rows() > 0){
					
                  $consulta="select p.personaTipoAgente from persona p where p.idPersona=".$query->result_array()[0]['idPersona'];
                  $tipoAgente=$this->db->query($consulta)->result();
        
                  if($tipoAgente[0]->personaTipoAgente!=3 && $tipoAgente[0]->personaTipoAgente!=4){

                  }

				$result = $query->result_array();
			} 
			else {$result = array();}
							   

		}catch(Exception $e){
		
		}
		return 
			$result;
	}

	function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}

	function endsWith($haystack, $needle) {
	    // search forward starting from end minus needle length characters
	    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}
//--------------------------------------------------------------------------

	public function getVendedorID($idUser){

		try{
			
			$this->db->select("idVendedor","activo");			
			
			$this->db->where('id',$idUser);

			$this->Invitados = $this->db->get("users");
			
			if ($this->Invitados->num_rows() > 0){

				$result = $this->Invitados->result_array();
			}else{
				$result = array();
			}

		}catch(Exception $e){
			
		}
		
		return $result;
		

	}
//--------------------------------------------------------------------------
	public function get_SubGrupos($idGrupo){
		
		$insert_value = false;
		
		try{
			
			$this->db->select("IDGrupo AS `IdSGrupo`,Grupo,");			
			
			$this->db->where('IDGrupoNS',$idGrupo);

			$this->Invitados = $this->db->get("catalog_grupos");
			
			if ($this->Invitados->num_rows() > 0){

				$result = $this->Invitados->result_array();
			}else{
				$result = array();
			}

		}catch(Exception $e){
			
		}
		
		return $result;
	}	
//--------------------------------------------------------------------------	
	public function get_Profile($ID)
	{
		try
		{
			$this->db->select("Nombre AS `Perfil`");	
			$this->db->where('idProfile',$ID);
			$perfil = $this->db->get("catalog_profiles");

			if ($perfil->num_rows() > 0)
			{
				$result = @$perfil->result_array()[0]["Perfil"];
			}
			else
			{
				$result = array();
			}

		}
		catch(Exception $e){

		}

		return $result;
	}
//--------------------------------------------------------------------------
	public function get_ProfileID($Name)
	{
		try
		{
			$this->db->select("idProfile AS `ID`");			
			$this->db->where('Nombre',$Name);
			$perfil = $this->db->get("catalog_profiles");

			if ($perfil->num_rows() > 0)
			{
				$result = @$perfil->result_array()[0]["ID"];
			}
			else
			{
				$result = array();
			}

		}
		catch(Exception $e){
			
		}

		return $result;
	}

	public function get_IDVendNS($IDUser)
	{
		try
		{
			$this->db->select("IDVendNS AS `ID`");			
			$this->db->where('id',$IDUser);
			$perfil = $this->db->get("users");

			if ($perfil->num_rows() > 0)
			{
				$result = @$perfil->result_array()[0]["ID"];
			}
			else
			{
				$result = array();
			}

		}
		catch(Exception $e){
			
		}

		return $result;
	}
//--------------------------------------------------------------------------	
 public function devolverCompanias(){
 	$consulta="select * from catalog_promotorias where statusCompania=1 and (idPromotoria!=51 and idPromotoria!=52) order by Promotoria ";
 	return $this->db->query($consulta)->result();
 }
//--------------------------------------------------------------------------
public function buscarCompaniaPorID($idPromotoria){
	$consulta="select * from catalog_promotorias where idPromotoria=".$idPromotoria;
 	return $this->db->query($consulta)->result();
}
//--------------------------------------------------------------------------
public function insertarRelacionRP($array){
 $this->db->insert('relacionramopromotoria',$array);
}
//--------------------------------------------------------------------------
public function borrarRelacionRP($idSubRamo){
	$this->db->where('idSubRamo',$idSubRamo);
	$this->db->delete('relacionramopromotoria');
}
//--------------------------------------------------------------------------
public function devolverCompaniasAsignadas($idSubRamo){
	$consulta="select idPromotoria from relacionramopromotoria where idSubRamo=".$idSubRamo;
	return $this->db ->query($consulta)->result();
}
//--------------------------------------------------------------------------
public function actualizarCantidadCompaniasRanking($ranking,$cantidad){

	$update='update personarankingagente set companiasPermitidasPRA='.$cantidad.' where personaRankingAgente="'.$ranking.'"';
	$this->db->query($update);
}
//--------------------------------------------------------------------------
//Cambios Edwin Marin
public function actualizarPuntosProspeccion($prospeccion,$cantidad){

	$update='update puntosprospeccion set puntosOtorgados='.$cantidad.' where prospeccion="'.$prospeccion.'"';
	$this->db->query($update);
}
//--------------------------------------------------------------------------
public function relActividadPromotoria($array){
 $datos['default']='No existe idRelActividadPromotoria insertar -1, consulta o actualizacion con el idRelActividadPromotoria correspondiente, si es consulta enviar en el array ["operacion"]=0 y si es actualizacion ["operacion"]=1 si no se toma por default consulta';
	if(isset($array['idRelActividadPromotoria'])){
		$datos=null;
	if($array['idRelActividadPromotoria']>0){	
        if(isset($array['operacion'])){
             if($array['operacion']==0){
          $consulta="select * from relactividadpromotoria where idRelActividadPromotoria=".$array['idRelActividadPromotoria'];
          $datos=$this->db->query($consulta)->result();

             }
             else{  
                $consulta="select fechaRAP,idPromotoria from relactividadpromotoria where idRelActividadPromotoria=".$array['idRelActividadPromotoria'];
                $fecha=$this->db->query($consulta)->result();
                if($fecha[0]->fechaRAP==""){
                 $update="update relactividadpromotoria set numArchivos=numArchivos+1,fechaRAP=now(),usuariosAgregaronRAP=concat(usuariosAgregaronRAP,' ',".$this->tank_auth->get_idPersona().") where idRelActividadPromotoria=".$array['idRelActividadPromotoria'];                  
                }
                else{
                	 $update="update relactividadpromotoria set numArchivos=numArchivos+1,usuariosAgregaronRAP=concat(usuariosAgregaronRAP,' ',".$this->tank_auth->get_idPersona().") where idRelActividadPromotoria=".$array['idRelActividadPromotoria'];
                }
                $this->db->query($update);
                $datos['respuesta']="La actualizacion fue correcta";
             }
        }
        else{
          $consulta="select * from relactividadpromotoria where idRelActividadPromotoria=".$array['idRelActividadPromotoria'];
          $datos=$this->db->query($consulta)->result();

        }
      }
	else
	{
	unset($array['idRelActividadPromotoria']);
	$this->db->insert('relactividadpromotoria',$array);
	}
  }

  return $datos;
}
//--------------------------------------------------------------------------
public function calificacionAgente(){
	$consulta="select * from calificacionagente";
	$datos=$this->db->query($consulta)->result();
	return $datos;

}
//--------------------------------------------------------------------------
public function guardarCalificacion($calificacionAgente){
	if(isset($calificacionAgente['idCalificacionAgente'])){
		$this->db->where('idCalificacionAgente',$calificacionAgente['idCalificacionAgente']);
		$this->db->update('calificacionagente',$calificacionAgente);
	}else
	{$this->db->insert('calificacionagente',$calificacionAgente);}
}
//--------------------------------------------------------------------------
function guardarCalificacionActividad($calificacion){
	$this->db->insert('calificacionactividad',$calificacion);
}

//--------------------------------------------------------------------------
function obtenerTodoRamoPromotoria(){ //Modificado [Suemy][2024-07-23]
 $consulta='select cp.Promotoria, cs.Nombre AS SubRamo, cr.Nombre AS Ramo, cp.idPromotoria, cr.IDRamo AS idRamo, rrp.* from relacionramopromotoria rrp
 	left join catalog_promotorias cp on cp.idPromotoria=rrp.idPromotoria
	left join catalog_subRamos cs on cs.IDSRamo=rrp.idSubRamo 
	left join catalog_ramos cr on cr.IDRamo = cs.IDRamo';
return $this->db->query($consulta)->result();
}

//--------------------------------------------------------------------------
public function ramoPromotoria($array){
	/*MANDAR 0 SI SE VA A CONSULTAR 0 UN 1 SI ES UNA ACTUALIZACION */
	  if($array['idRamoPromotoria']>0){
	if(isset($array['operacion'])){
         if($array['operacion']==1){
            unset($array['operacion']);
            $this->db->where('idRamoPromotoria',$array['idRamoPromotoria']);
            $this->db->update('relacionramopromotoria',$array);
         }           
         else{

         }
 
      }
	}else{
		/*CODIGO PARA INSERTAR*/
	}

}
//--------------------------------------------------------------------------
function catalog_ramos($array){
$respuesta="";
  if(isset($array['IDRamo'])){
	if($array['IDRamo']>0){
		$consulta="select * from catalog_ramos where IDRamo=".$array['IDRamo'];
		if(isset($array['operacion'])){
         if($array['operacion']==1)
          {unset($array['operacion']);
           $this->db->where('IDRamo',$array['IDRamo']);$this->db->update('catalog_ramos',$array);
          }

		}
		$respuesta=$this->db->query($consulta)->result();

	}
   else{/*PARA CREAR UN NUEVO RAMO*/}
  }
 return $respuesta;
}
//--------------------------------------------------------------------------
function devolverRamoConIdSubramo($IDSRamo){
	$consulta='select csr.IDSRamo,csr.Nombre,cr.*,p.nombres,p.apellidoPaterno,p.apellidoMaterno from catalog_subRamos csr left join catalog_ramos cr on cr.IDRamo=csr.IDRamo left join persona p on p.idPersona=cr.idPersona where csr.IDSRamo='.$IDSRamo;
	return $this->db->query($consulta)->result();
}
//--------------------------------------------------------------------------
function buscaCompaniaPorNombre($nombreCompania){
 $consulta='select * from catalog_promotorias cp where cp.Promotoria="'.$nombreCompania.'"';
 return $this->db->query($consulta)->result();
}
//--------------------------------------------------------------------------
function catalog_estados($array){
	$datos="";
	if(isset($array['clave'])){
     $consulta='select * from catalog_estados where clave="'.$array['clave'].'"';     
     $datos =$this->db->query($consulta)->result();
     if(count($datos)==0){
  	   $consulta='SHOW COLUMNS FROM catalog_estados';
       $columnas =$this->db->query($consulta)->result();         
        $cVacio = new stdClass();
       foreach ($columnas as $key => $value) {
       	$nombreColumnas=$value->Field;
       	$cVacio->$nombreColumnas="";
       }
       $datos[0]=$cVacio;
     	 
     }
    
	}else{
	$consulta="select * from catalog_estados";
	 $datos=$this->db->query($consulta)->result();		
	}

	return $datos;
}
//--------------------------------------------------------------------------

	function obtenerCatAbtDpto($array){
		if($array['idPersonaDepartamento']){
         $consulta="select * from personaDepartamento where idPersonaDepartamento=".$array['idPersonaDepartamento'];
		return $this->db->query($consulta)->result();
		}else{
				$consulta="select * from personadepartamento where aperturaContableStatus=1";
		return $this->db->query($consulta)->result();	
		}

	}
//------------------------------------------------------------------------
function comprobarExistenciaCatalogoGiros($string){
 $consulta='select * from catalogo_giros where giro="'.$string.'"';
 return $this->db->query($consulta)->result();
}
//--------------------------------------------------------------------------
function catalogo_giros($array){

	if(isset($array['idGiro']))
	{
    	if($array['idGiro']==-1){
    		unset($array['idGiro']);
    		$array['idPersona']=$this->tank_auth->get_idPersona();
    		$this->db->insert('catalogo_giros',$array);
            $last=$this->db->insert_id();
            return  $last;
    	}
		else{ 
         if(isset($array['update'])){
           /*PARA MODIFICAR*/
         }
         else{
         	   if($array['idGiro']==""){$array['idGiro']=-1;}
          $consulta='select * from catalogo_giros where idGiro='.$array['idGiro'];

              $datos =$this->db->query($consulta)->result();
if(count($datos)==0){
  	   $consulta='SHOW COLUMNS FROM catalogo_giros';
       $columnas =$this->db->query($consulta)->result();         
        $cVacio = new stdClass();
       foreach ($columnas as $key => $value) {$nombreColumnas=$value->Field;$cVacio->$nombreColumnas="";}
       $datos[0]=$cVacio;
     	 
     }
         }

     return $datos;
		}
	}
	else
	{
		$consulta="select * from catalogo_giros";
		$datos=$this->db->query($consulta)->result();
		return $datos;
	}
	
}

//--------------------------------------------------------------------------
function bancos($array){
	$respuesta=array();
	if(isset($array['idBanco'])){

	}
   else{
   	$consulta="select descripcionBancos from bancos";
     $respuesta=$this->db->query($consulta)->result();
   }
   return $respuesta;
}

//--------------------------------------------------------------------------
function comprobarExistenciaCatalogoGirosBORRAR($string){
 $consulta='select * from catalogo_giros where giro="'.$string.'"';
 return $this->db->query($consulta)->result();
}
//--------------------------------------------------------------------------
function relclientegiro($array){
		$this->db->insert('relclientegiro',$array);
}

//--------------------------------------------------------------------------
function obtenerNombreColumnas($stringNombreTabla){
	$consulta='SHOW COLUMNS FROM catalogo_giros';
    $columnas =$this->db->query($consulta)->result();         
    $cVacio = new stdClass();
    foreach ($columnas as $key => $value) {$nombreColumnas=$value->Field;$cVacio->$nombreColumnas="";}
    return $cVacio;
}

//--------------------------------------------------------------------------
function relGiroActividad($array){
	$array['actividad']=ucfirst($array['actividad']);
	$this->db->insert('relgiroactividad',$array);
}
//--------------------------------------------------------------------------
function comprobarExistenciaPromotoria($idPromotoria){
 $consulta='select * from catalog_promotorias where idPromotoria='.$idPromotoria;
 $respuestas=false;
 $datos=$this->db->query($consulta);
if($datos->num_rows>0){$respuesta=true;}
 return $respuesta;

}
//--------------------------------------------------------------------------
function encriptarClave($array)
{ 
  $respuesta='';
  if(isset($array['dato']) && isset($array['llave']))
  {
   $consulta="select AES_ENCRYPT('".$array['dato']."','".$_POST['llave']."CAPITALSEGUROS') as encriptado";
   $respuesta=$this->db->query($consulta)->result();
  }
  else{$respuesta="Se necesita un array con los valores dato y llave";}
  return $respuesta;
}
//--------------------------------------------------------------------------
function catalogpromotoriadocumento($array){


 if(isset($array['idCatalogPromotoriaDocumento'])){
 	if($array['idCatalogPromotoriaDocumento']==-1)
    {
      unset($array['idCatalogPromotoriaDocumento']);
      $this->db->insert('catalogpromotoriadocumento',$array);
      $last=$this->db->insert_id();

    	 $consulta="select * from catalogpromotoriadocumento where idCatalogPromotoriaDocumento=".$last;    	 
    	 return $this->db->query($consulta)->result();
      
    } 
    else{
    	if(isset($array['update'])){
    		unset($array['update']);
          $this->db->where('idCatalogPromotoriaDocumento',$array['idCatalogPromotoriaDocumento']);
          $this->db->update('catalogpromotoriadocumento',$array);
    	}
    	else
    	{ 
    	 $consulta="select * from catalogpromotoriadocumento where idCatalogPromotoriaDocumento=".$array['idCatalogPromotoriaDocumento'];    	 
    	 return $this->db->query($consulta)->result();
    	}
    } 
 }
 else{
    	 $consulta="select * from catalogpromotoriadocumento where activo=1";
    	 return $this->db->query($consulta)->result();


 }
}
//-------------------------------------------------------------------------
function relaciondocumentopromotoria($array)
{
 if(isset($array['insert'])){
 	unset($array['insert']);
 	$this->db->insert('relaciondocumentopromotoria',$array);
 }
 else{
 	$this->db->where('idPromotoria',$array['idPromotoria']);
 	$this->db->where('idCatalogPromotoriaDocumento',$array['idCatalogPromotoriaDocumento']);
 	$this->db->delete('relaciondocumentopromotoria');
 }
}
//-------------------------------------------------------------------------
function seleccionaDocumentPorPromotoria($array)
{
	$consulta='select * from relaciondocumentopromotoria where idPromotoria='.$array['idPromotoria'];

	return $this->db->query($consulta)->result();
}
//-------------------------------------------------------------------------
function devolverDocumentoPorPromotoria($array){
	$consulta='select * from relaciondocumentopromotoria rdp 
left join catalogpromotoriadocumento cpd on cpd.idCatalogPromotoriaDocumento=rdp.idCatalogPromotoriaDocumento
where  cpd.activo=1 and rdp.idPromotoria='.$array['idPromotoria'];
return $this->db->query($consulta)->result();
}
//------------------------------------------------------------------------
function tareasProgramadas($array)
{
	$respuesta;
	
	if(isset($array['update']))
	{
	 $idTareasProgramadas=$array['idTareasProgramadas'];
	 unset($array['idTareasProgramadas']);
	 unset($array['update']);
	 $this->db->where('idTareasProgramadas',$idTareasProgramadas);
	 $this->db->update('tareasprogramadas',$array);
	 $respuesta=1;
    }
    else
    {
      $consulta="select * from tareasprogramadas";
     if(isset($array['idTareasProgramadas']))
     {
      $consulta.=" where idTareasProgramadas=".$array['idTareasProgramadas'];
     }
     $respuesta=$this->db->query($consulta)->result();

    }
    return $respuesta;
	
}
//-----------------------------------------------------------------
function catalog_tipoimg($array=array())
{
	/*
	LA VARIABLE tipoDocumento CONTENIDA EN EL ARRAY SE REFIERE SI ES DOCUMENTO DEL CLIENTE O DE LA POLIZA 
	SI ENVIAS $array['tipoCliente'] CON VALOR cliente DE DEVOLVERA LAS OPCIONES PARA SUBIR DOCUMENTOS DEL CLIENTE EN CASO QUE ENVIES documento TE DEVOLVERA LAS OPCIONES PARA SUBIR ARCHIVOS DEL DOCUMENTO, EN CASO QUE NO ENVIES VALOR TE DEVOLVERA TODOS
	 */
	$filtro='';
	if(isset($array['tipoDocumento']))
	{
      if($array['tipoDocumento']=='cliente'){ $filtro=' and idTipoImg in (5,7,11,12,21,22)';}
      if($array['tipoDocumento']=='documento'){ $filtro=' and idTipoImg not in (5,7,11,12,21,22)';}
      if($array['tipoDocumento']=='fianzas'){ $filtro=' and aplica = "FIANZA"';}
	}
	$consulta='select * from catalog_tipoImg where activo=0'.$filtro;
	return $this->db->query($consulta)->result();
}

//-------------------------------------------------------

function obtener_grupos_habilitados(){

	$resultado=array();

	$this->db->where("estaHabilitado",1);
	$query=$this->db->get("catalog_grupos");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}
//-------------------------------------------------------
function obtener_subgrupos(){

	$resultado=array();

	$this->db->where("Habilitado",1);
	$query=$this->db->get("catalog_subgrupos");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}

//------------------------------------------------
function catalogosGiro()
{
	$consulta='select * from catalogo_giros';
return $this->db->query($consulta)->result();
}
//-----------------------------------------------
 public function devolverCompaniasPresupuesto()
 {
 	$consulta="select * from catalog_promotorias where activoPresupuestos=1 and  statusCompania=1 and (idPromotoria!=51 and idPromotoria!=52) order by Promotoria ";
 	return $this->db->query($consulta)->result();
 }
//------------------------------------------------
function canalesCatalogos($array)
{

   $consulta='select m.idMetaComercial,m.email,m.anio,u.name_complete ,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.idPersona from metacomercial_ingreso_total m left join users u on u.email=m.email
left join persona p on p.idPersona=u.idPersona where anio='.$array['anio'];
  /*$consulta.=' union ';
   $consulta.='select m.idMetaComercial,m.email,m.anio,u.name_complete ,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.idPersona from metacomercial m left join users u on u.email=m.email
left join persona p on p.idPersona=u.idPersona where m.email="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" and m.anio='.$array['anio'];*/

   $respuesta=$this->db->query($consulta)->result();

	return $respuesta;
}
//---------------------------
function catalog_contactopuesto($array='')
{
  if(isset($array['contactoPuesto']))
  {
  	$array['contactoPuesto']=strtoupper($array['contactoPuesto']);
   $cantidad=$this->db->query('select (count(c.contactoPuesto)) as cantidad from catalog_contactopuesto c where c.contactoPuesto="'.$array['contactoPuesto'].'"')->result()[0]->cantidad;
   if($cantidad==0)
   {
   	$array['idPersona']=$this->tank_auth->get_idPersona();
   	$this->db->insert('catalog_contactopuesto',$array);
   }
  }

   $datos=$this->db->query('select c.contactoPuesto from catalog_contactopuesto c order by c.contactoPuesto')->result();
  
  return $datos;
}
//---------------------------
function inconformidadCataloBuzonInconformidadPadre()
{
  $consulta='select * from catalog_buzoninconformidad c where c.idPadre=0';
  $datos=$this->db->query($consulta)->result();
  return $datos;
}
//---------------------------
function devolverHijoCatalogoInconformidades($idCBI,$tipoBusqueda)
{
  $consulta='select idCBI,catalogBuzonInconformidad from catalog_buzoninconformidad where';
  $datos=array();
  switch ($tipoBusqueda) 
  {
  	case 'idPadre':$consulta.=' idPadre='.$idCBI ;$datos=$this->db->query($consulta)->result();break;
  	case 'subCatalogo':
  	$traeSubcatalogo=$this->db->query('select subCatalogo from catalog_buzoninconformidad c where idCBI='.$idCBI)->result();

  	if(count($traeSubcatalogo)>0){$consulta.='  idCBI in ('.$traeSubcatalogo[0]->subCatalogo.')';}
  	
  	$datos=$this->db->query($consulta)->result();break;  }
  return $datos;

}
//---------------------------
function cobranzatiposolicitudcobro($id='')
{
    $filtro='';
	if(isset($id))
	{
      if($id!='')
      {
         $filtro=' where idTipoSolicitudCobro='.$id;
      }
	}
	$consulta='select * from cobranzatiposolicitudcobro '.$filtro;
	return $this->db->query($consulta)->result();
	
}

//--------------------------------------------------------------------------------------------------------------
	//SubMódulo: Horas Compañía | Creado [Suemy][2024-07-23]
	function get_Promotorias() {
		$query = $this->db->query('SELECT * FROM catalog_promotorias')->result();
		return $query;
	}

	function updateHourRamoPromotoria($id,$data) {
		$this->db->where('idRamoPromotoria',$id);
		$query = $this->db->update('relacionramopromotoria',$data);
		return $query;
	}

	function insertTrainingRamoPromotoria($data) {
		$query = $this->db->insert('relacionramopromotoria_seguimiento',$data);
		return $this->db->insert_id();
	}

	function getTrainingHoraRamoPromotoria($sql = NULL) {
		$data = array();
		$today = date('Y-m-d');
		$dateI = (date('N') != 1) ? date('Y-m-d',strtotime('last Monday',strtotime($today))) : date('Y-m-d');
        $dateF = (date('N') != 7) ? date('Y-m-d',strtotime('next Sunday',strtotime($today))) : date('Y-m-d');
		$query = $this->db->query('SELECT srr.*, cp.Promotoria, cs.Nombre AS SubRamo, cr.Nombre AS Ramo, us.name_complete, us.email FROM relacionramopromotoria_seguimiento srr LEFT JOIN relacionramopromotoria rrp ON rrp.idRamoPromotoria = srr.idRamoPromotoria LEFT JOIN catalog_promotorias cp on cp.idPromotoria = rrp.idPromotoria LEFT JOIN catalog_subRamos cs on cs.IDSRamo = rrp.idSubRamo LEFT JOIN catalog_ramos cr on cr.IDRamo = cs.IDRamo LEFT JOIN users us ON us.idPersona = srr.hecho_por '.$sql.' ORDER BY srr.registro DESC')->result();
		foreach ($query as $val) {
			$time = "Hace un tiempo";
			$date = date('Y-m-d',strtotime($val->registro));
			if ($date == $today) {
				$time = "Hoy";
			}
			else if (strtotime($date) == strtotime('-1 days', strtotime($today))) {
				$time = "Ayer";
			}
			else if (strtotime($date) >= strtotime($dateI) && strtotime($date) <= strtotime($dateF)) {
				$time = "Esta semana";
			}
			else if (date('m',strtotime($date)) == date('m')) {
				$time = "Este mes";
			}
			else if (strtotime($date) == strtotime('-1 months', strtotime($today))) {
				$time = "El mes pasado";
			}
			$add['id'] = $val->id;
			$add['idRamoPromotoria'] = $val->idRamoPromotoria;
			$add['promotoria'] = $val->Promotoria;
			$add['ramo'] = $val->Ramo;
			$add['subramo'] = $val->SubRamo;
			$add['accion'] = $val->accion;
			$add['campo'] = $val->campo;
			$add['valor'] = $val->valor;
			$add['tiempo'] = $time;
			$add['us_nombre'] = $val->name_complete;
			$add['us_email'] = $val->email;
			$add['registro'] = $val->registro;
			array_push($data, $add);
		}
		return $data;
	}
//-----------------------------------------------------------
	function getRamosForActivities() { //Creado [Suemy][2024-08-12]
		$query = $this->db->query('SELECT IDRamo, Nombre, Abreviacion FROM catalog_ramos')->result();
		$add['IDRamo'] = '0';
		$add['Nombre'] = "Sin Ramo";
		$add['Abreviacion'] = "SinRamo";
		array_push($query,$add);
		return $query;
	}
//-----------------------------------------------------------
function preferenciaDeContactoCliente()
{
	
	$consulta='select * from catalogopreferenciacomunicacion c order by c.order';
	$preferencia=$this->db->query($consulta)->result();
	#$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($preferencia,TRUE));fclose($fp);
	$datos['preferenciaComunicacion']=array();
	$datos['prefercianHorario']=array();
	$datos['preferenciaDia']=array();
	foreach ($preferencia as  $value) 
	{
		switch ($value->idTipoPreferenciaDescripcion) 
		{
			case '0':	array_push($datos['preferenciaComunicacion'],$value->preferencia);break;
			case '1':  array_push($datos['prefercianHorario'],$value->preferencia);break;							
			case '2':  array_push($datos['preferenciaDia'],$value->preferencia);break;
					
		}
	}
    return $datos;

}

//-----------------------------------------------------------
}
?>