<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');

class monitores extends CI_Controller{
	
	var $meses;
	function __construct(){
		parent::__construct();
		$this->meses = 
		array(
			'Enero',
			'Febrero',
			'Marzo',
			'Abril',
			'Mayo',
			'Junio',
			'Julio',
			'Agosto',
			'Septiembre',
			'Octubre',
			'Noviembre',
			'Diciembre',
		);
		$this->load->library(array("webservice_sicas_soap","role","excel"));	
		$this->load->model(
			array(
				"catalogos_model",
				"capsysdre_actividades",
				"reportes_model","personamodelo",
				"superestrella_model" //Agregado [Suemy][2024-08-12]
			)
		);	
	}

		
	function index(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['Ramo']		= $this->catalogos_model->get_Ramos();	
			$data['Grupo']		= $this->catalogos_model->get_Grupos();
			$data['vendedor']	= $this->catalogos_model->get_Vendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());
			$data['promotor']	= $this->catalogos_model->get_Promotor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());

				$this->load->view('monitores/principal', $data);
		}
	}/*! index */
	
//--------------------------------------------------------------------------------------------
	function Exporta(){	//Modificado [Suemy][20205-04-07]

	//$mysqli = new mysqli('localhost','root','','capsysv3');

	$mysqli = new mysqli('www.capsys.com.mx','root','M1D0$2023G4p','capsysV3');

	$fechaStart		= $this->input->post('fechaStart',true);
	$fechaEnd			= $this->input->post('fechaEnd',true);

   	$fecha = date("d-m-Y");
   	$consulta= "select (if(act.nombreUsuarioVendedor is null,act.nombreUsuarioCreacion,act.nombreUsuarioVendedor)) as nombreVendedor,act.*,us.* from `actividades` act
	left join users us on act.usuarioVendedor =us.email
	where CAST(`act`.`fechaCreacion` as date) Between '".$fechaStart."' And '".$fechaEnd."'
   	";

 


   	$resultado= $mysqli->query($consulta);

  

	//Inicio de la instancia para la exportación en Excel
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Listado_$fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo "<table border=1> ";
	echo "<tr> ";
	echo     "<th>IdInterno</th> ";
	echo 	"<th>folioActividad</th> ";
	echo 	"<th>idSicas</th> ";
	echo 	"<th>NumSolicitud</th> ";
	echo 	"<th>Documento</th> ";
	echo 	"<th>idSicas</th> ";
	echo 	"<th>Status</th> ";
	echo 	"<th>Status_Txt</th> ";
	echo 	"<th>tipoActividadSicas</th> ";
	echo 	"<th>idCliente</th> ";
	echo 	"<th>nombreCliente</th> ";
	echo 	"<th>Refernciado</th>";
	echo 	"<th>tipoActividad</th> ";
	echo 	"<th>Cruce de Cartera</th>";
	echo 	"<th>ramoActividad</th> ";
	echo 	"<th>subRamoActividad</th> ";
	echo 	"<th>actividadUrgente_Txt</th> ";
	echo 	"<th>usuarioCreacion</th> ";
	echo 	"<th>usuarioVendedor</th> ";
	echo 	"<th>usuarioResponsable</th> ";
	echo 	"<th>usuarioBolita</th> ";
	echo 	"<th>usuarioBloqueo</th> ";
	echo 	"<th>usuarioCotizador</th> ";

	echo 	"<th>nombreUsuarioCreacion</th> ";
	echo 	"<th>nombreUsuarioVendedor</th> ";
	echo 	"<th>nombreUsuarioResponsable</th> ";
	echo 	"<th>nombreUsuarioCotizador</th> ";

	echo 	"<th>fechaCreacion</th> ";
	echo 	"<th>Satisfaccion Cotizacion</th> ";
	echo 	"<th>Satisfaccion Emision</th> ";
	echo 	"<th>name_complete</th> ";

    echo 	"<th>satisfaccion</th> ";
    echo 	"<th>dato express</th> ";
	echo "</tr> ";

	while($row = mysqli_fetch_array($resultado)){	
		$query = $this->db->query('SELECT `referido` FROM `clientes_actualiza` WHERE `folioActividad` = "'.$row['folioActividad'].'"')->row();
		$referred = !empty($query) ? $query->referido : 'No';

	$idInterno = $row['idInterno'];
	$folioActividad = $row['folioActividad'];
	$idSicas = $row['idSicas'];
	$NumSolicitud = $row['NumSolicitud'];
	$Documento = $row['Documento'];
    $idSicas = $row['idSicas'];
	$Status = $row['Status'];
	$Status_Txt = $row['Status_Txt'];
	$tipoActividadSicas = $row['tipoActividadSicas'];
	$idCliente = $row['idCliente'];
	$nombreCliente = $row['nombreCliente'];


	$tipoActividad = $row['tipoActividad'];
	$ramoActividad = $row['ramoActividad'];
	$subRamoActividad = $row['subRamoActividad'];
	$actividadUrgente_Txt = $row['actividadUrgente_Txt'];
	$usuarioCreacion = $row['usuarioCreacion'];
	$usuarioVendedor = $row['usuarioVendedor'];
	$usuarioResponsable = $row['usuarioResponsable'];
	$usuarioBolita = $row['usuarioBolita'];
	$usuarioBloqueo = $row['usuarioBloqueo'];
	$usuarioCotizador = $row['usuarioCotizador'];

	$nombreUsuarioCreacion = $row['nombreUsuarioCreacion'];
	$nombreUsuarioVendedor = $row['nombreVendedor'];//$row['nombreUsuarioVendedor'];
	$nombreUsuarioResponsable = $row['nombreUsuarioResponsable'];
	$nombreUsuarioCotizador = $row['nombreUsuarioCotizador'];

	$fechaCreacion = $row['fechaCreacion'];
	$satisfaccion = $row['satisfaccion'];
	$satisfaccionEmision = $row['satisfaccionEmision'];
	$name_complete = $row['name_complete'];
	$datosExpres=$row['datosExpres'];
     $datosExpres=str_replace('<p>',' ',$datosExpres);
     $datosExpres=str_replace('</p>',' ',$datosExpres);


	echo    "<tr> ";
	echo 	"<td HEIGHT=20>".$idInterno."</td> "; 
	echo 	"<td HEIGHT=20>".$folioActividad."</td> "; 
	echo 	"<td HEIGHT=20>".$idSicas."</td> "; 
	echo 	"<td HEIGHT=20>".$NumSolicitud."</td> "; 
	echo 	"<td HEIGHT=20>".$Documento."</td> "; 
	echo 	"<td HEIGHT=20>".$idSicas."</td> "; 
	echo 	"<td HEIGHT=20>".$Status."</td> "; 
	echo 	"<td HEIGHT=20>".$Status_Txt."</td> "; 
	echo 	"<td HEIGHT=20>".$tipoActividadSicas."</td> ";  
	echo 	"<td HEIGHT=20>".$idCliente."</td> "; 
	echo 	"<td HEIGHT=20>".$nombreCliente."</td> "; 
	echo 	"<td>".$referred."</td>";
	echo 	"<td HEIGHT=20>".$tipoActividad."</td> "; 
	echo 	"<td>".$row['cruce_cartera']."</td>";
	echo 	"<td HEIGHT=20>".$ramoActividad."</td> "; 
	echo 	"<td HEIGHT=20>".$subRamoActividad."</td> "; 
	echo 	"<td HEIGHT=20>".$actividadUrgente_Txt."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioCreacion."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioVendedor."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioResponsable."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioBolita."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioBloqueo."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioCotizador."</td> "; 

	echo 	"<td HEIGHT=20>".$nombreUsuarioCreacion."</td> "; 
	echo 	"<td HEIGHT=20>".$nombreUsuarioVendedor."</td> "; 
	echo 	"<td HEIGHT=20>".$nombreUsuarioResponsable."</td> "; 
	echo 	"<td HEIGHT=20>".$nombreUsuarioCotizador."</td> "; 

	echo 	"<td HEIGHT=20>".$fechaCreacion."</td> "; 
	echo 	"<td HEIGHT=20>".$satisfaccion."</td> ";
	echo 	"<td HEIGHT=20>".$satisfaccionEmision."</td> ";
	echo 	"<td HEIGHT=20>".$name_complete."</td> "; 
    echo 	"<td HEIGHT=20>".$row['satisfaccion']."</td> "; 
    echo 	"<td HEIGHT='5px'>".$datosExpres."</td> "; 
	echo    "</tr> ";

	}
	echo "</table> ";

	 

 	}
	
//--------------------------------------------------------------------------------------------	
	function verMonitor(){ //Modificado [Suemy][2024-08-12]
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$meses["01"]	= "Enero";
			$meses["02"]	= "Febrero";
			$meses["03"]	= "Marzo";
			$meses["04"]	= "Abril";
			$meses["05"]	= "Mayo";
			$meses["06"]	= "Junio";
			$meses["07"]	= "Julio";
			$meses["08"]	= "Agosto";
			$meses["09"]	= "Septiembre";
			$meses["10"]	= "Octubre";
			$meses["11"]	= "Noviembre";
			$meses["12"]	= "Diciembre";
			$data['meses']	= $meses;
	 

	 $data['coordinadores']=$this->personamodelo->devuelveCoordinadoresVentas();

     $idPersona=$data['coordinadores'][0]->idPersona;

	 if(isset($_POST['selectCoordinadores'])){
	 if($_POST['selectCoordinadores']!=''){
       $idPersona=$_POST['selectCoordinadores'];
       $data['idPersonaCoordinador']=$idPersona;
      }
	 }
	 $agentesCoordinador=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($idPersona);
	

			$sqlConsultaVendedores = "Select `NombreCompleto`, `Status_TXT`, `EMail1`, `Giro`, `Clasifica_TXT` From `catalog_vendedores` Where `EMail1` Is Not Null And `EMail1` != '' Order By `Status_TXT`, `NombreCompleto` Asc";
			$quesyConsultaVendedores	= $this->db->query($sqlConsultaVendedores);
		
			$monitorear			= $this->input->post('monitorear',true);
			$mesActividades		= $this->input->post('mesActividades',true);
			$tipoActividad		= $this->input->post('tipoActividad',true);
			$subRamoActividad	= $this->input->post('subRamoActividad',true);
			
			$data['usuVend_Array']	= $agentesCoordinador;//$quesyConsultaVendedores->result_array();
			//var_dump($data);
			$data['anoActual']		= $anoActual	= date('Y');
			$data['mesActivo']		= $mesActivo	= date('m');
			
			$data['usuarioVendedor']= $usuarioVendedor	= $this->input->post('usuarioVendedor',true);
			$data['filtroFechas']	= $filtroFechas		= $this->input->post('filtroFechas',true);
			$data['fechaStart']		= $fechaStart		= $this->input->post('fechaStart',true);
			$data['fechaEnd']		= $fechaEnd			= $this->input->post('fechaEnd',true);

		

		
		if($this->input->post('selectCoordinadores')!="" && $this->input->post('usuarioVendedor')==""){
			if($this->input->post('selectCoordinadores')>0){
            $consultaEmail=$this->db->query("select email from users where idPersona=".$this->input->post('selectCoordinadores'))->result();
             $urgentes='select (count(actividades.actividadUrgente)) as cantidad from actividades  left join users u on u.email=actividades.usuarioVendedor left join persona p on p.idPersona=u.idPersona where actividades.actividadUrgente=1 and p.userEmailCreacion="'.$consultaEmail[0]->email.'"';
              $satisfaccionMala='select (count(actividades.satisfaccion)) as mala from actividades  left join users u on u.email=actividades.usuarioVendedor left join persona p on p.idPersona=u.idPersona where actividades.satisfaccion="malo" and p.userEmailCreacion="'.$consultaEmail[0]->email.'"';
                         $satisfaccionBuena='select (count(actividades.satisfaccion)) as buena from actividades  left join users u on u.email=actividades.usuarioVendedor left join persona p on p.idPersona=u.idPersona where actividades.satisfaccion="bueno" and p.userEmailCreacion="'.$consultaEmail[0]->email.'"';
           $satisfaccionRegular='select (count(actividades.satisfaccion)) as regular from actividades  left join users u on u.email=actividades.usuarioVendedor left join persona p on p.idPersona=u.idPersona where actividades.satisfaccion="regular" and p.userEmailCreacion="'.$consultaEmail[0]->email.'"';
           $satisfaccionSinCalificar='select (count(actividades.idinterno)) as sinCalificar from actividades  left join users u on u.email=actividades.usuarioVendedor left join persona p on p.idPersona=u.idPersona where actividades.satisfaccion is null and p.userEmailCreacion="'.$consultaEmail[0]->email.'"';}
           else{
           	    $urgentes="select (count(actividades.actividadUrgente)) as cantidad from actividades where actividadUrgente=1 ";
           $satisfaccionMala='select (count(satisfaccion)) as mala from actividades where actividades.satisfaccion="malo"';
                      $satisfaccionBuena='select (count(satisfaccion)) as buena from actividades where actividades.satisfaccion="bueno"';
           $satisfaccionRegular='select (count(satisfaccion)) as regular from actividades where actividades.satisfaccion="regular"';
           $satisfaccionSinCalificar='select (count(idinterno)) as sinCalificar from actividades where actividades.satisfaccion is null';
           }
		
			}
	else{
/*======================================== TRAIGO INFORMACION DE CALIFICACION ==============================================*/
           $urgentes="select (count(actividades.actividadUrgente)) as cantidad from actividades where actividadUrgente=1 ";
           $satisfaccionMala='select (count(satisfaccion)) as mala from actividades where actividades.satisfaccion="malo"';
                      $satisfaccionBuena='select (count(satisfaccion)) as buena from actividades where actividades.satisfaccion="bueno"';
           $satisfaccionRegular='select (count(satisfaccion)) as regular from actividades where actividades.satisfaccion="regular"';
           $satisfaccionSinCalificar='select (count(idinterno)) as sinCalificar from actividades where actividades.satisfaccion is null';
          }
     

    if($usuarioVendedor!=""){$urgentes=$urgentes.' and usuarioVendedor="'.$usuarioVendedor.'"';$satisfaccionMala=$satisfaccionMala.' and usuarioVendedor="'.$usuarioVendedor.'"';$satisfaccionBuena=$satisfaccionBuena.' and usuarioVendedor="'.$usuarioVendedor.'"';$satisfaccionRegular=$satisfaccionRegular.' and usuarioVendedor="'.$usuarioVendedor.'"';$satisfaccionSinCalificar=$satisfaccionSinCalificar.' and usuarioVendedor="'.$usuarioVendedor.'"';}

     if($filtroFechas!=""){ $urgentes=$urgentes.' and cast(actividades.fechaCreacion as date) BETWEEN "'.$fechaStart.'" and "'.$fechaEnd.'"';$satisfaccionMala=$satisfaccionMala.' and cast(actividades.fechaCreacion as date) BETWEEN "'.$fechaStart.'" and "'.$fechaEnd.'"';$satisfaccionBuena=$satisfaccionBuena.' and cast(actividades.fechaCreacion as date) BETWEEN "'.$fechaStart.'" and "'.$fechaEnd.'"';$satisfaccionRegular=$satisfaccionRegular.' and cast(actividades.fechaCreacion as date) BETWEEN "'.$fechaStart.'" and "'.$fechaEnd.'"';$satisfaccionSinCalificar=$satisfaccionSinCalificar.' and cast(actividades.fechaCreacion as date) BETWEEN "'.$fechaStart.'" and "'.$fechaEnd.'"';}
     else{
         if($mesActividades==""){
         	   $urgentes=$urgentes.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActivo;$satisfaccionMala=$satisfaccionMala.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActivo;$satisfaccionBuena=$satisfaccionBuena.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActivo;$satisfaccionRegular=$satisfaccionRegular.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActivo;$satisfaccionSinCalificar=$satisfaccionSinCalificar.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActivo;
         }else{
     	$urgentes=$urgentes.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActividades;$satisfaccionMala=$satisfaccionMala.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActividades;$satisfaccionBuena=$satisfaccionBuena.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActividades;$satisfaccionRegular=$satisfaccionRegular.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActividades;$satisfaccionSinCalificar=$satisfaccionSinCalificar.' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)='.$mesActividades;
     	  }
       }
    
     
	

   $cantUrgentes= $this->db->query($urgentes);
   $cantMalas=$this->db->query($satisfaccionMala);
   $cantBuenas=$this->db->query($satisfaccionBuena);
   $cantRegular=$this->db->query($satisfaccionRegular);
   $cantSinCalificar=$this->db->query($satisfaccionSinCalificar);
   if(isset($_POST['tipoActividad']	))
   	{		
    /* $cantMalasPorTipo=$satisfaccionMala." and tipoActividad='".$_POST['tipoActividad']."'";
     $cantBuenasPorTipo=$satisfaccionBuena." and tipoActividad='".$_POST['tipoActividad']."'";
     $cantRegularPorTipo=$satisfaccionRegular." and tipoActividad='".$_POST['tipoActividad']."'";
      $cantSinCalificarPorTipo=$satisfaccionSinCalificar." and tipoActividad='".$_POST['tipoActividad']."'";
      $cantMalasPorTipoResult=$this->db->query($cantMalasPorTipo);
      $cantBuenasPorTipoResult=$this->db->query($cantBuenasPorTipo);
      $cantRegularResult=$this->db->query($cantRegularPorTipo);
      $cantSinCalificarResult=$this->db->query($cantSinCalificarPorTipo);*/
//$cantMalasPorTipoResult->result()[0]->mala=0;$cantBuenasPorTipoResult->result()[0]->buena=20 , $cantRegularResult->result()[0]->regular=2;$cantSinCalificarResult->result()[0]->sinCalificar
    // $fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r(""	, TRUE));fclose($fp);
    }


   /*===========================================================================================================================*/
//=======================================LOCM====================================//
          $filtroCoordinadoresLeft="";
          $filtroCoordinadoresCondicion="";

      	if($this->input->post('selectCoordinadores')!="" && $this->input->post('usuarioVendedor')==""){
               if($this->input->post('selectCoordinadores')>0){
               $filtroCoordinadoresLeft='left join users u on u.email=actividades.usuarioVendedor left join persona p on p.idPersona=u.idPersona ';
              $filtroCoordinadoresCondicion='p.userEmailCreacion="'.$consultaEmail[0]->email.'" and ';
			}
		}
			
			if($mesActividades){$data['mesActivo']		= $mesActivo	= $mesActividades;} 
			else {$data['mesActivo']		= $mesActivo;}
          
			if($filtroFechas == "si"){$filtrandoFechas	= "(`fechaCreacion` Between '".$fechaStart."' And '".$fechaEnd."'Or `fechaCreacion` Like '%".$fechaEnd."%')";} 
			else {$filtrandoFechas	= "(`fechaCreacion` Like '".$anoActual."-".$mesActivo."%')";}
			
			if($usuarioVendedor != ""){$filtrandoUsuarioVendedor	= "if(`usuarioVendedor`='',`usuarioCreacion`,`usuarioVendedor`) = upper('".$usuarioVendedor."') And";}
			else {$filtrandoUsuarioVendedor	= "";}
//////////////////////////////////////////////////////////////////////////////
				//=> Consulta Seccion Uno de Monitor
					$sqlConsultaActividades	= "Select Count(*) As `noTipoActividad`, `tipoActividad` From `actividades` $filtroCoordinadoresLeft Where   $filtroCoordinadoresCondicion $filtrandoUsuarioVendedor $filtrandoFechas Group By `tipoActividad` Order By `tipoActividad` Asc";
	
					$data['ConsultaActivi']	= $queConsultaActividades	= $this->db->query($sqlConsultaActividades);
					$resConsultaActividades = $queConsultaActividades->result_array();
					
				//=> Consulta Seccion Dos de Monitor
			
				if($tipoActividad){
					$data['tipoActividad']	= $tipoActividad; //			= $resConsultaActividades[0]['tipoActividad'];
				} else if(isset($resConsultaActividades[0]['tipoActividad'])){
					$data['tipoActividad']	= $tipoActividad			= $resConsultaActividades[0]['tipoActividad'];
				} else {
					//--> $data['tipoActividad']	= $tipoActividad			= "Cotizacion";
				}

    $cantMalasPorTipo=$satisfaccionMala." and tipoActividad='".$tipoActividad."'";
     $cantBuenasPorTipo=$satisfaccionBuena." and tipoActividad='".$tipoActividad."'";
     $cantRegularPorTipo=$satisfaccionRegular." and tipoActividad='".$tipoActividad."'";
      $cantSinCalificarPorTipo=$satisfaccionSinCalificar." and tipoActividad='".$tipoActividad."'";
      $cantMalasPorTipoResult=$this->db->query($cantMalasPorTipo);
      $cantBuenasPorTipoResult=$this->db->query($cantBuenasPorTipo);
      $cantRegularResult=$this->db->query($cantRegularPorTipo);
      $cantSinCalificarResult=$this->db->query($cantSinCalificarPorTipo);


				
					$sqlConsultaTiposActividad	= "
						Select Count(*) As `noActividadTipo`,`tipoActividad`,`ramoActividad`,`subRamoActividad`
						From `actividades` $filtroCoordinadoresLeft
						Where  $filtroCoordinadoresCondicion $filtrandoUsuarioVendedor $filtrandoFechas And `tipoActividad` Like '".$tipoActividad."%'
						Group By `ramoActividad`, `subRamoActividad`
						Order By`ramoActividad`, `subRamoActividad` Asc
												 ";
					$data['ConsultaTipoAct']	= $queConsultaTiposActividad	= $this->db->query($sqlConsultaTiposActividad);
					$resConsultaTiposActividad	= $queConsultaTiposActividad->result_array();
					
				//=> Consulta Seccion Tres de Monitor
				if($subRamoActividad){
					$data['subRamoActividad']		= $subRamoActividad; //		= $resConsultaTiposActividad[0]['subRamoActividad']; 
				} else if(isset($resConsultaTiposActividad[0]['subRamoActividad'])){
					$data['subRamoActividad']		= $subRamoActividad = $resConsultaTiposActividad[0]['subRamoActividad']; 
				} else {
					$data['subRamoActividad']		= $subRamoActividad = "AUTOMOVILES INDIVIDUALES";
				}
				if($monitorear=="SemaforoEnCurso"){
                
                	 	$usermail = $this->tank_auth->get_usermail();
                 		if($usermail == "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM") //MONICA
                 		{
                 			
						}	
						if($usermail == "COORDINADORDIVISIONPERSONAS@ASESORESCAPITAL.COM")//karent
                 		{
                 			
					    }
					    if($usermail != "COORDINADORDIVISIONPERSONAS@ASESORESCAPITAL.COM" && $usermail != "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM")
					    {	
							
					    }	//fin de todos

					    
					 $queConsultaRamoGrupoActividad	= $this->db->query($sqlConsultaRamoGrupoActividad);
$data['ConsultaSubRamosAct']	=$queConsultaRamoGrupoActividad->result_array();
				}
				else{
					$sqlConsultaRamoGrupoActividad	="";
					$sqlConsultaRamoGrupoActividad	= "Select `folioActividad`,`tipoActividad`,`ramoActividad`,`subRamoActividad`,`datosExpres`,`nombreUsuarioCreacion`,`nombreUsuarioVendedor`,`nombreUsuarioResponsable`,`nombreUsuarioCotizador`,
							`fechaCreacion`,`fechaActualizacion`,`Status_Txt`
						From `actividades`
						Where $filtrandoUsuarioVendedor $filtrandoFechas And `tipoActividad`		Like '".$tipoActividad."%' And `subRamoActividad`	= '".$subRamoActividad."'
						Order By `fechaCreacion`, `ramoActividad`, `subRamoActividad` Asc
													  ";
					$data['ConsultaSubRamosAct']	= $queConsultaRamoGrupoActividad	= $this->db->query($sqlConsultaRamoGrupoActividad);
				}

////////////////////////////////////////////////////////////////////////////// SEMAFORO A 30 DIAS


				if($monitorear=="SemaforoEnCursoMes"){


				 	 $usermail = $this->tank_auth->get_usermail();
                 	if($usermail == "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM") //MONICA
                 	{	
                

							$sqlConsultaRamoGrupoActividad	= "	
select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=120,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`, 
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=120,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS')
 and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
 and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS')
and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS')
 and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
 and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS')
and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'


union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='ASEGURADORA')
 and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='ASEGURADORA')
and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='ASEGURADORA')
 and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='ASEGURADORA')
and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
";
} //fin del if de monica

if($usermail == "COORDINADORDIVISIONPERSONAS@ASESORESCAPITAL.COM")//karent
{


							$sqlConsultaRamoGrupoActividad	= "	

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='VIDA')
 and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
 and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='VIDA')
and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
				
union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=10080,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='VIDA')
 and (`act`.tipoActividad='Cotizacion')
 and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=10080,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='VIDA')
and (`act`.tipoActividad='Cotizacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'		


union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
 and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
 and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'	

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=180,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
 and (`act`.tipoActividad='Cotizacion')
 and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=180,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
and (`act`.tipoActividad='Cotizacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'						




	
						";

} //fin del if de karent

 if($usermail != "COORDINADORDIVISIONPERSONAS@ASESORESCAPITAL.COM" && $usermail != "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM")
					    {	


					    								$sqlConsultaRamoGrupoActividad	= "	
select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=120,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`, 
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=120,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS')
 and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
 and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS')
and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS')
 and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
 and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS')
and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'


union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='ASEGURADORA')
 and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='ASEGURADORA')
and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='ASEGURADORA')
 and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='ASEGURADORA')
and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'



union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='VIDA')
 and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
 and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='VIDA')
and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
				
union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=10080,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='VIDA')
 and (`act`.tipoActividad='Cotizacion')
 and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=10080,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='VIDA')
and (`act`.tipoActividad='Cotizacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'		


union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
 and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
 and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'	

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=180,'Purple','Green')) as color,

     										`act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
 and (`act`.tipoActividad='Cotizacion')
 and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=180,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
) as color    ,
                              `act`.`folioActividad`,
                                   `act`.`tipoActividad`,
                                   `act`.`ramoActividad`,
                                   `act`.`subRamoActividad`,
                                   `act`.`datosExpres`,
                                   `act`.`nombreUsuarioCreacion`,
                                   `act`.`nombreUsuarioVendedor`,
                                   `act`.`nombreUsuarioResponsable`,
                                   `act`.`nombreUsuarioCotizador`,
                                   `act`.`fechaCreacion`,
                                   `act`.`fechaActualizacion`,
                                   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
and (`act`.tipoActividad='Cotizacion')
and  cast(`act`.`fechaCreacion` as date) between '".$fechaStart."' And '".$fechaEnd."'	



					";

							

					    }	//fin de todos



	

					    
					 $queConsultaRamoGrupoActividad	= $this->db->query($sqlConsultaRamoGrupoActividad);
$data['ConsultaSubRamosAct']	=$queConsultaRamoGrupoActividad->result_array();
				}
						   		
//////////////////////////////////////////////////////////////////////////////
			switch($monitorear){
				case "Actividades":
					$url					= "";
					$vistaMonitor			= "monitores/monitorActividades";
					$data['consultarView']	= $consultarView	= "Actividades";
				break;
				
				case "SemaforoActividades":
					$url					= "";
					$vistaMonitor			= "monitores/semaforoActividades";
					$data['consultarView']	= $consultarView	= "Actividades";
				break;
				case "SemaforoEnCurso":				
					$url					= "";
					$vistaMonitor			= "monitores/semaforoEnCurso";
					$data['consultarView']	= $consultarView	= "Actividades";
				break;
				case "SemaforoEnCursoMes":				
					$url					= "";
					$vistaMonitor			= "monitores/semaforoEnCursoMes";
					$data['consultarView']	= $consultarView	= "Actividades";
				break;
			}

		/*=========================PASO INFORMACION DE CALIFICACION============================*/
			$data['cantUrgentes']=$cantUrgentes->result()[0]->cantidad;
			$data['cantMalas']=$cantMalas->result()[0]->mala;
			$data['cantBuenas']=$cantBuenas->result()[0]->buena;
			$data['cantRegulares']=$cantRegular->result()[0]->regular;
			$data['cantSinCalificar']=$cantSinCalificar->result()[0]->sinCalificar;
			 
			$data['cantMalasPorTipoResult']=$cantMalasPorTipoResult->result()[0]->mala ;
			$data['cantBuenasPorTipoResult']=$cantBuenasPorTipoResult->result()[0]->buena ;
			$data['cantRegularResult']=$cantRegularResult->result()[0]->regular ;
			$data['cantSinCalificarResult']=$cantSinCalificarResult->result()[0]->sinCalificar ;
	/*====================================================================================================================*/


           	//Agregado [Suemy][2024-08-12]
			//Encontrar trimestre
            $quarter = "";
            $array = array("Primero","Segundo","Tercero","Cuarto");
            foreach ($array as $key => $val) {
                $value = $key + 1;
                $quarter .= "<option value=".$val.">".$val."</option>";
            }
            $data['op_quarterly'] = $quarter;
           	//Encontrar meses
            $op_months = '';
            $m = $this->libreriav3->devolverMeses();
            foreach ($m as $key => $val) {
                $selected = "";
                if ($key == date('m')) { $selected = "selected"; }
                $op_months .= "<option value=".$key." ".$selected.">".$val."</option>";
            }
            $data['op_months'] = $op_months;
            $next_month = date('m',strtotime(date('Y-m-d').' + 1 months'));
            $data['rangeQ'] = array("dateI" => date('Y-m-15'), "dateF" => date('Y').'-'.$next_month.'-15');
            //Encontrar años
            $op_years = '';
            $count = date('Y') - 2024;
            $yearI = date('Y');
            for ($i=0;$i<=$count;$i++) {
                $selected = "";
                if ($yearI == date('Y')) { $selected = "selected"; }
                $op_years .= '<option value="'.$yearI.'" '.$selected.'>'.$yearI.'</option>';
                $yearI--;
            }
            $data['op_years'] = $op_years;
	
			$this->load->view($vistaMonitor,$data);
		}
	}
	
//--------------------------------------------------------------------------------------------	
	function verSeguimiento(){

  	if (isset($_POST['Consulta'])){
  					$sqlConsultaVendedores = "
				Select
					`NombreCompleto`, `Status_TXT`, `EMail1`, `Giro`, `Clasifica_TXT`
				From
					`catalog_vendedores`
				Where
					`EMail1` Is Not Null
					And
					`EMail1` != ''
				Order By
					`Status_TXT`, `NombreCompleto` Asc
									 ";
			$quesyConsultaVendedores	= $this->db->query($sqlConsultaVendedores);
  		//ata=array();
          //ata["dato"]=$_POST['Consulta'];
          $fec1=$_POST['fecha_inicial'];
          $fec2=$_POST['fecha_final'];
          
          $consulta="select `fechaCreacion` from `actividades`";// where `fechaCreacion`>'".$fec1."' and `fechaCreacion`< '".$fec2."'"
        //consulta=	$sqlConsultaVendedores;
           $data['consulta']=$consulta;
          
           $ConsultaActividades	= $this->db->query($consulta);
             //data['consulta2']=$ConsultaActividades->num_rows;
           $data['ConsultaActividades']	=  $onsultaActividades;
           var_dump($quesyConsultaVendedores);
           var_dump($data);

        $this->load->view("monitores/seguimientoActividades",$data);
  	}
  	else
  	{
  		  $this->load->view("monitores/seguimientoActividades");
  	}


  }
  
//---------------------------------------------------------------------------------
	function montosPorCompania(){
		if(isset($_GET['mesActividades'])){
		  	$consulta='select a.folioActividad,a.subRamoActividad,rap.*, cp.Promotoria from actividades a 
  	    		       left join relactividadpromotoria rap on rap.folioActividad=a.folioActividad
		               left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria
		               where  a.tipoActividad="Cotizacion" and YEAR(a.fechaCreacion)=YEAR(NOW()) and rap.tipoActividad="Cotizacion" and MONTH(a.fechaCreacion)='.$_GET['mesActividades'];
                   
				if(isset($_GET['usuarioVendedor'])){
               		$consulta='select a.folioActividad,a.subRamoActividad,rap.*, cp.Promotoria from actividades a 
				  	           left join relactividadpromotoria rap on rap.folioActividad=a.folioActividad
				               left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria
				               where  a.tipoActividad="Cotizacion" and YEAR(a.fechaCreacion)=YEAR(NOW()) and rap.tipoActividad="Cotizacion" and MONTH(a.fechaCreacion)='.$_GET['mesActividades'].' and if(a.usuarioVendedor="",a.usuarioCreacion,a.usuarioVendedor)="'.$_GET['usuarioVendedor'].'"';
         
             	
				} else {

					if($_GET['coordinador']>0){
              			$consultaEmail=$this->db->query("select email from users where idPersona='".$_GET['coordinador']."'")->result();          
	                   	$consulta='select a.folioActividad,a.subRamoActividad,rap.*, cp.Promotoria from actividades a 
					  	           left join relactividadpromotoria rap on rap.folioActividad=a.folioActividad
					               left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria
					               left join users u on u.email=a.usuarioVendedor 
					               left join persona p on p.idPersona=u.idPersona
					               where  a.tipoActividad="Cotizacion" and YEAR(a.fechaCreacion)=YEAR(NOW()) and rap.tipoActividad="Cotizacion" and MONTH(a.fechaCreacion)='.$_GET['mesActividades'].'  and p.userEmailCreacion="'.$consultaEmail[0]->email.'"';
               		

					}
				}
		} else {
		
    		$consulta='select a.folioActividad,a.subRamoActividad,rap.*, cp.Promotoria from actividades a 
  	        	   left join relactividadpromotoria rap on rap.folioActividad=a.folioActividad
	               left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria
    	           where  a.tipoActividad="Cotizacion" and a.fechaCreacion BETWEEN "'.$_GET['fechaStart'].'" and "'.$_GET['fechaEnd'].'" and p.userEmailCreacion="'.$consultaEmail[0]->email.'"';
		}

		$datos=$this->db->query($consulta)->result();
	   $companias=$this->catalogos_model->devolverCompanias();	
	   $cantCompanias=count($companias);
	   $totalMonto=0;
	   foreach ($companias as $key => $value) {$companias[$key]->monto=0.00;}
	   foreach ($datos as  $value) {
	      $totalMonto=$totalMonto+$value->montoRAP;
	      for($i=0;$i<$cantCompanias;$i++){
    	  	if($companias[$i]->idPromotoria==$value->idPromotoria){
      		$companias[$i]->monto=$companias[$i]->monto+$value->montoRAP;
      		$i=$cantCompanias;
			}
		  }
	   }
		$total="";
		if(!is_object($total)){
			$total = new stdClass;
		}

		$total->Promotoria="Total";
		$total->monto=$totalMonto;
		//array_push($companias,$total);
		foreach ($companias as  $value) {$value->monto=number_format($value->monto,2);}
	    $informacion['montoCompanias']=$companias;
	    $total->monto=number_format($totalMonto,2);
	    $informacion['pieTabla']=$total;
 
		echo json_encode($informacion);
	} /* !montosPorCompania */
  
//---------------------------------------------------------------------------------
	function montosEndosos(){
		if(isset($_GET['mesActividades'])){
		  	$consulta='select a.folioActividad,a.subRamoActividad,a.tipoEndoso,rap.*, cp.Promotoria from actividades a 
  	    		       left join relactividadpromotoria rap on rap.folioActividad=a.folioActividad
		               left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria
		               where  a.tipoActividad="Endoso" and YEAR(a.fechaCreacion)=YEAR(NOW()) and rap.tipoActividad="Endoso" and MONTH(a.fechaCreacion)="'.$_GET['mesActividades'].'"';
                   
				if(isset($_GET['usuarioVendedor'])){
               		$consulta='select a.folioActividad,a.subRamoActividad,a.tipoEndoso,rap.*, cp.Promotoria from actividades a 
				  	           left join relactividadpromotoria rap on rap.folioActividad=a.folioActividad
				               left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria
				               where  a.tipoActividad="Endoso" and YEAR(a.fechaCreacion)=YEAR(NOW()) and rap.tipoActividad="Endoso" and MONTH(a.fechaCreacion)='.$_GET['mesActividades'].' and if(a.usuarioVendedor="",a.usuarioCreacion,a.usuarioVendedor)="'.$_GET['usuarioVendedor'].'"';
         
             	
				} else {

					if($_GET['coordinador']>0){
              			$consultaEmail=$this->db->query("select email from users where idPersona='".$_GET['coordinador']."'")->result();          
	                   	$consulta='select a.folioActividad,a.subRamoActividad,a.tipoEndoso,rap.*, cp.Promotoria from actividades a 
					  	           left join relactividadpromotoria rap on rap.folioActividad=a.folioActividad
					               left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria
					               left join users u on u.email=a.usuarioVendedor 
					               left join persona p on p.idPersona=u.idPersona
					               where  a.tipoActividad="Endoso" and YEAR(a.fechaCreacion)=YEAR(NOW()) and rap.tipoActividad="Endoso" and MONTH(a.fechaCreacion)='.$_GET['mesActividades'].'  and p.userEmailCreacion="'.$consultaEmail[0]->email.'"';
               		

					}
				}
		} else {
		
    		$consulta='select a.folioActividad,a.subRamoActividad,a.tipoEndoso,rap.*, cp.Promotoria from actividades a 
  	        	   left join relactividadpromotoria rap on rap.folioActividad=a.folioActividad
	               left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria
    	           where  a.tipoActividad="Endoso" and a.fechaCreacion BETWEEN "'.$_GET['fechaStart'].'" and "'.$_GET['fechaEnd'].'" and p.userEmailCreacion="'.$consultaEmail[0]->email.'"';
		}
		
		$datos			= $this->db->query($consulta)->result();
		$companias		= $this->catalogos_model->devolverCompanias();
		$cantCompanias	= count($companias);
		$totalMonto		= 0;
		$totalCantidad	= 0;
		$totalCantidadA	= 0;
		$totalCantidadB	= 0;
		$totalCantidadD	= 0;
		$totalCantidadS	= 0;
		
		
		foreach ($companias as $key => $value){
			$companias[$key]->monto		= 0.00;
			$companias[$key]->cantidad	= "";
			$companias[$key]->cantidadA	= "";
			$companias[$key]->cantidadB	= "";
			$companias[$key]->cantidadD	= "";
			$companias[$key]->cantidadS	= "";
		}
		
		foreach ($datos as  $value){
			
			$cantidadA		= 0;
			$cantidadB		= 0;
			$cantidadD		= 0;
			$cantidadS		= 0;
		
			$totalMonto		= $totalMonto + $value->montoRAP;


			for($i=0; $i < $cantCompanias; $i++){
				//if($companias[$i]->idPromotoria == $value->idPromotoria){
					
					switch($value->tipoEndoso){
						case "A":
							$cantidadA	= $cantidadA + 1;
						break;
						
						case "B":
							$cantidadB	= $cantidadB + 1;
						break;
						
						case "D":
							$cantidadD	= $cantidadD + 1;
						break;
						
						default:
							$cantidadS	= $cantidadS + 1;
						break;
					}
					
					$companias[$i]->monto		= $companias[$i]->monto + $value->montoRAP;
					$companias[$i]->cantidad	= $companias[$i]->cantidad + 1;
					$companias[$i]->cantidadA	= $companias[$i]->cantidadA + $cantidadA;
					$companias[$i]->cantidadB	= $companias[$i]->cantidadB + $cantidadB;
					$companias[$i]->cantidadD	= $companias[$i]->cantidadD + $cantidadD;
					$companias[$i]->cantidadS	= $companias[$i]->cantidadS + $cantidadS;
					
      				$i	= $cantCompanias;
				/*} else if($value->idPromotoria == "0") {

					$value->idPromotoria = "50";

				}*/
			}
			$totalCantidadA	= $totalCantidadA + $cantidadA;
			$totalCantidadB	= $totalCantidadB + $cantidadB;
			$totalCantidadD	= $totalCantidadD + $cantidadD;
			$totalCantidadS	= $totalCantidadS + $cantidadS;
			
			$totalCantidad	= $totalCantidadA + $totalCantidadB + $totalCantidadD + $totalCantidadS;
		}
		
		$total="";
		if(!is_object($total)){
			$total = new stdClass;
		}

		$total->Promotoria	= "Total";
		$total->monto		= $totalMonto;
		$total->cantidad	= $totalCantidad;
		$total->cantidadA	= $totalCantidadA;
		$total->cantidadB	= $totalCantidadB;
		$total->cantidadD	= $totalCantidadD;
		$total->cantidadS	= $totalCantidadS;
		//array_push($companias,$total);
		
		foreach($companias as $value){
			$value->monto=number_format($value->monto,2);
		}
		
	    $informacion['montoCompanias']	= $companias;
	    $total->monto					= number_format($totalMonto,2);
	    $informacion['pieTabla']		= $total;
		
		echo json_encode($informacion);
	} /* !montosEndosos */

//--------------------------------------------------------------------------------------------------------------
	//Control de Actividades | Creado [Suemy][2024-08-12]
	function getCompleteInformationActivities() {
		$type = $this->input->get('ck');
		$quarter = $this->input->get('qr');
		$month = $this->input->get('mn');
		$dateI = $this->input->get('dI');
		$dateF = $this->input->get('dF');
		$year = $this->input->get('yr');
		$report = $this->input->get('rp');
		//Recoleccion de informacion
		$seccion_act = array("0" => "Total", "1" => "Ramos", "2" => "Actividades", "3" => "Resumen");
		$name_month = $this->libreriav3->devolverMeses()[$month];
		$ramos = $this->catalogos_model->getRamosForActivities();
		//Consulta según el tipo de búsqueda
		$sql = 'MONTH(act.fechaCreacion) = '.$month.' AND YEAR(act.fechaCreacion) = '.$year;
		if ($type == 1) {
			$range = $this->superestrella_model->getMonthsByQuarter($quarter);
			$sql = 'YEAR(act.fechaCreacion) = '.$year.' AND MONTH(act.fechaCreacion) BETWEEN '.$range[0].' AND '.$range[2];
			$name_month = 'Trimestre ('.$this->libreriav3->devolverMeses()[$range[0]].' - '.$this->libreriav3->devolverMeses()[$range[2]].')';
		}
		else if ($type == 3) {
			$sql = 'DATE(act.fechaCreacion) BETWEEN "'.$dateI.'" AND "'.$dateF.'"';
			$name_month = 'Entre Fechas ('.date('d/m/Y',strtotime($dateI)).' - '.date('d/m/Y',strtotime($dateF)).')';
		}
		//Consulta
		$consult = $this->reportes_model->getActivitiesByMonth($sql);
		$collect = $this->getInformationCollectActivities($consult);
		//Tipo de reporte
		if ($report == 1) {
			$data['consult'] = $consult;
			$data['result'] = $collect['result'];
			$data['repeated'] = $collect['repeated'];
			$data['activities'] = array("tabs" => $seccion_act, "folios" => $collect['folios'], "vend" => $collect['vend'], "ramos" => $ramos);
			$data['data'] = array("mes" => $name_month, "checked" => $type, "quarter" => $quarter, "dateI" => $dateI, "dateF" => $dateF, "month" => $month, "year" => $year, "report" => $report);
			echo json_encode($data);
		}
		else if ($report == 2) {
			$tables = $this->separateInformationActivities($collect);
			$this->exportActivitiesPart2($tables);
		}
		else if ($report == 3) {
			$result = $this->getOrderInformationGeneral($collect['result'],"General");
			$repeated = $this->getOrderInformationGeneral($collect['repeated'],"Repetidas");
			$this->exportCompleteReport(array("0" => $result, "1" => $repeated));
		}
	}

	function getOrderInformationGeneral($result,$name) {
		$data = array();
		$headers = $this->getOrderInformationHeader()[0];
		foreach ($result as $val) {
			$add[0] = $val->IdInterno;
			$add[1] = $val->folioActividad;
			$add[2] = $val->idSicas;
        	$add[3] = $val->NumSolicitud;
        	$add[4] = $val->Documento;
        	$add[5] = $val->Status;
        	$add[6] = $val->Status_Txt;
        	$add[7] = $val->tipoActividadSicas;
        	$add[8] = $val->idCliente;
        	$add[9] = $val->nombreCliente;
        	$add[10] = $val->tipoActividad;
        	$add[11] = $val->ramoActividad;
        	$add[12] = $val->subRamoActividad;
        	$add[13] = $val->actividadUrgente_Txt;
        	$add[14] = $val->usuarioCreacion;
        	$add[15] = $val->usuarioVendedor;
        	$add[16] = $val->usuarioResponsable;
        	$add[17] = $val->usuarioBolita;
        	$add[18] = $val->usuarioBloqueo;
        	$add[19] = $val->usuarioCotizador;
        	$add[20] = $val->nombreUsuarioCreacion;
        	$add[21] = $val->nombreVendedor;
        	$add[22] = $val->nombreUsuarioResponsable;
        	$add[23] = $val->nombreUsuarioCotizador;
        	$add[24] = $val->fechaCreacion;
        	$add[25] = $val->satisfaccion;
        	$add[26] = $val->satisfaccionEmision;
        	$add[27] = $val->name_complete;
        	$add[28] = $val->tipoEndoso;
        	$add[29] = $val->poliza;
        	$add[30] = utf8_decode($val->datosExpres);
			array_push($data,$add);
		}
		return array("0" => $headers, "1" => $data, "2" => $name);
	}

	function getOrderInformationHeader() {
		$header = array();
		$add[0] = "IdInterno";
		$add[1] = "folioActividad";
		$add[2] = "idSicas";
        $add[3] = "NumSolicitud";
        $add[4] = "Documento";
        $add[5] = "Status";
        $add[6] = "Status_Txt";
        $add[7] = "tipoActividadSicas";
        $add[8] = "idCliente";
        $add[9] = "nombreCliente";
        $add[10] = "tipoActividad";
        $add[11] = "ramoActividad";
        $add[12] = "subRamoActividad";
        $add[13] = "actividadUrgente_Txt";
        $add[14] = "usuarioCreacion";
        $add[15] = "usuarioVendedor";
        $add[16] = "usuarioResponsable";
        $add[17] = "usuarioBolita";
        $add[18] = "usuarioBloqueo";
        $add[19] = "usuarioCotizador";
        $add[20] = "nombreUsuarioCreacion";
        $add[21] = "nombreVendedor";
        $add[22] = "nombreUsuarioResponsable";
        $add[23] = "nombreUsuarioCotizador";
        $add[24] = "fechaCreacion";
        $add[25] = "satisfaccion";
        $add[26] = "satisfaccionEmision";
        $add[27] = "name_complete";
        $add[28] = "tipoEndoso";
        $add[29] = "poliza";
        $add[30] = "datosExpres";
		array_push($header,$add);
		return $header;
	}

	function getInformationCollectActivities($consult) {
		$folios = array();
		$vend = array();
		$result = array();
		$repeated = array();
		foreach ($consult as $key => $val) {
			$date_v = date('Y-m',strtotime($val->fechaCreacion));
 			$name_v = trim($val->nombreVendedor);
			$value = 0;
			if (!in_array($val->folioActividad,$folios)) {
				array_push($folios, $val->folioActividad);
 			}
 			if (!in_array($name_v,$vend)) {
				array_push($vend, $name_v);
 			}
			foreach ($result as $k => $row) {
				$date_r = date('Y-m',strtotime($row->fechaCreacion));
				if ($val->folioActividad == $row->folioActividad && $val->tipoActividad == $row->tipoActividad && $date_v == $date_r) {
					$value = 0;
					$val->repeated = $value;
					array_push($repeated, $val);
				} else { $value = 1; }
			}
			if (!isset($val->repeated)) {
				array_push($result, $val);
			}
		}
		sort($folios);
		sort($vend);
		return array("folios" => $folios, "vend" => $vend, "result" => $result, "repeated" => $repeated);
	}

	function separateInformationActivities($query) {
		$data = array();
		/*$total = $this->getInformationForTotales($query);
		$vendedores = $this->getInformationForVendedor($query);*/
		$clasificacion = $this->getInformationForClasificacion($query);
		$resumen = $this->getInformationForResumen($query);
		//return array("0" => $total, "1" => $vendedores, "2" => $clasificacion, "3" => $resumen);
		/* Se quitó Total y Vendedores por sobre carga de información */
		return array("0" => $clasificacion, "1" => $resumen);
	}

	function getInformationForTotales($query) {
		$rp = $query['repeated'];
		$result = $query['result'];
		$tags = ["Captura Emision", "Cotizacion", "Cotizacion & Emision", "Emisiones", "Sustitucion"];
		$header = array("0" => "Etiquetas", "1" => "Cantidad de Folios", "2" => "Folios Unicos");
		$body = array();
		$folios = array();
		$capt_t = 0;
       	$cotz_t = 0;
       	$emsn_t = 0;
       	$sust_t = 0;
       	$cotz_emsn = 0;
       	$capt_u = 0;
       	$cotz_u = 0;
       	$emsn_u = 0;
       	$sust_u = 0;
       	$cotz_emsn_u = 0;
       	$value_t = 0;
       	$unique_t = 0;
       	foreach ($result as $key => $val) {
       		switch($val->tipoActividad) {
        		case 'CapturaEmision':
        			$capt_t++;
        			if (in_array($val->folioActividad,$rp)) { $capt_u++; }
        		break;
        		case 'Cotizacion':
        			$cotz_t++;
        			array_push($folios,$val->folioActividad);
        			if (in_array($val->folioActividad,$rp)) { $cotz_u++; }
        		break;
        		case 'Emision':
        			$exist = 0;
           			if (in_array($val->folioActividad,$folios)) {
           				$cotz_emsn++;
        				$cotz_t--;
        				$exist = 1;
           			}
        			if ($exist != 1) { $emsn_t++; }
        			if (in_array($val->folioActividad,$rp) && $exist != 1) { $emsn_u++; }
        			else if (in_array($val->folioActividad,$rp) && $exist == 1) { $cotz_emsn_u++; }
        		break;
        		case 'Sustitucion':
        			$sust_t++;
        			if (in_array($val->folioActividad,$rp)) { $sust_u++; }
        		break;
        	}
       	}
       	for ($i=0;$i<count($tags);$i++) {
        	$value = "";
        	$unique = 0; //Valor único
        	switch($tags[$i]) {
        		case 'Captura Emision': $value = $capt_t; $unique = $capt_t - $capt_u; break;
        		case 'Cotizacion': $value = $cotz_t; $unique = $cotz_t - $cotz_u; break;
        		case 'Cotizacion & Emision': $value = $cotz_emsn; $unique = $cotz_emsn - $cotz_emsn_u; break;
        		case 'Emisiones': $value = $emsn_t; $unique = $emsn_t - $emsn_u; break;
        		case 'Sustitucion': $value = $sust_t; $unique = $sust_t - $sust_u; break;
        	}
        	$value_t = $value_t + $value;
        	$unique_t = $unique_t + $unique;
        	$add[0] = $tags[$i];
        	$add[1] = $value;
        	$add[2] = $unique;
        	array_push($body, $add);
        }
        $insert[0] = "Total General";
        $insert[1] = $value_t;
        $insert[2] = $unique_t;
        array_push($body, $insert);
        return array("0" => $header, "1" => $body, "2" => "Totales");
	}

	function getInformationForVendedor($query) {
		$vn = $query['vend'];
		$result = $query['result'];
		$header = array("0" => "Vendedor", "1" => "Captura Emision", "2" => "Cotizacion", "3" => "Cotizacion & Emision", "4" => "Emisiones", "5" => "Sustitucion", "6" => "Total");
		$body = array();
       	$capt_t = 0;
       	$cotz_t = 0;
       	$cotz_emsn_t = 0;
       	$emsn_t = 0;
       	$sust_t = 0;
       	$total_t = 0;
		$num = 0;
		foreach ($vn as $value) {
       		$folios = [];
       		$capt = 0;
       		$cotz = 0;
       		$cotz_emsn = 0;
       		$emsn = 0;
       		$sust = 0;
       		$total = 0;
       		foreach ($result as $key => $val) {
       			if ($val->nombreVendedor == $value) {
       				switch($val->tipoActividad) {
        				case 'CapturaEmision': $capt++; $capt_t++; break;
        				case 'Cotizacion': $cotz++; $cotz_t++; array_push($folios,$val->folioActividad);  break;
        				case 'Emision':
        					$exist = 0;
        					if (in_array($val->folioActividad,$folios)) {
            					$cotz_emsn++;
            					$cotz_emsn_t++;
        						$cotz--;
        						$cotz_t--;
        						$exist = 1;
          					}
        					if ($exist != 1) { $emsn++; $emsn_t++; }
        				break;
        				case 'Sustitucion': $sust++; $sust_t++; break;
       				}
       			}
       			$total = $capt + $cotz + $emsn + $sust + $cotz_emsn;
       		}
       		$num++;
       		$add[0] = $value;
       		$add[1] = !empty($capt) ? $capt : "";
       		$add[2] = !empty($cotz) ? $cotz : "";
       		$add[3] = !empty($cotz_emsn) ? $cotz_emsn : "";
       		$add[4] = !empty($emsn) ? $emsn : "";
       		$add[5] = !empty($sust) ? $sust : "";
       		$add[6] = $total;
       		array_push($body, $add);
		}
       	$total_t = $capt_t + $cotz_t + $emsn_t + $sust_t + $cotz_emsn_t;
		$insert[0] = "TOTAL";
		$insert[1] = $capt_t;
		$insert[2] = $cotz_t;
		$insert[3] = $cotz_emsn_t;
		$insert[4] = $emsn_t;
		$insert[5] = $sust_t;
		$insert[6] = $total_t;
		array_push($body, $insert);
		return array("0" => $header, "1" => $body, "2" => "Vendedores");
	}

	function getInformationForClasificacion($query) {
		$folios = $query['folios'];
		$result = $query['result'];
		$data = array();
		$header = array("0" => "N°", "1" => "Captura Emision", "2" => "Cotizacion", "3" => "Cotizacion & Emision", "4" => "Emisiones", "5" => "Sustitucion", "6" => "Tipo de Movimiento");
		$body = array();
       	$capt_t = 0;
       	$cotz_t = 0;
       	$cotz_emsn_t = 0;
       	$emsn_t = 0;
       	$sust_t = 0;
       	$total = 0;
       	$num = 0;
		foreach ($folios as $key => $value) {
			$fl = array();
			$emsn_r = array();
       		$capt = "";
       		$cotz = "";
       		$cotz_emsn = "";
       		$emsn = "";
       		$sust = "";
       		$mov = "";
       		foreach ($result as $k => $val) {
       			if ($val->folioActividad == $value) {
       				$mov = $val->tipoActividad;
       				switch($val->tipoActividad) {
        				case 'CapturaEmision': $capt = $val->folioActividad; $capt_t++; break;
        				case 'Cotizacion': $cotz = $val->folioActividad; $cotz_t++; array_push($fl,$val->folioActividad); break;
        				case 'Emision':
        					$exist = 0;
        					if (in_array($val->folioActividad,$fl)) {
            					$cotz_emsn = $val->folioActividad; $cotz_emsn_t++;
        						$cotz = ""; $cotz_t--;
        						$exist = 1;
        						$mov = "Cotizacion & Emision";
          					}
        					if ($exist != 1) {
        						$emsn = $val->folioActividad;
        						if (!in_array($val->folioActividad,$emsn_r)) {
        							array_push($emsn_r,$val->folioActividad);
        							$emsn_t++;
        						}
        					}
        				break;
        				case 'Sustitucion': $sust = $val->folioActividad; $sust_t++; break;
       				}
       			}
       		}
       		if ($mov != "AclaraciondeComision" && $mov != "CambiodeConducto" && $mov != "Cancelacion" && $mov != "Endoso") {
       			$total = $capt_t + $cotz_t + $emsn_t + $sust_t + $cotz_emsn_t;
       			$num++;
       			$add[0] = $num;
       			$add[1] = $capt;
       			$add[2] = $cotz;
       			$add[3] = $cotz_emsn;
       			$add[4] = $emsn;
       			$add[5] = $sust;
       			$add[6] = $mov;
       			array_push($body,$add);
       		}
		}
		$insert[0] = "TOTAL";
		$insert[1] = $capt_t;
		$insert[2] = $cotz_t;
		$insert[3] = $cotz_emsn_t;
		$insert[4] = $emsn_t;
		$insert[5] = $sust_t;
		$insert[6] = $total;
		array_push($body, $insert);
		return array("0" => $header, "1" => $body, "2" => "Movimiento");
	}

	function getInformationForResumen($query) {
		$folios = $query['folios'];
		$result = $query['result'];
		$data = array();
		$header = array("0" => "Folio Actividad", "1" => "Aclaracion de Comision", "2" => "Cambio de Conducto", "3" => "Cancelacion", "4" => "Captura Emision", "5" => "Cotizacion", "6" => "Emision", "7" => "Endoso", "8" => "Sustitucion", "9" => "(En blanco)", "10" => "Total");
		$body = array();
        $comm_t = 0;
        $cond_t = 0;
        $canc_t = 0;
        $capt_t = 0;
        $cotz_t = 0;
        $emsn_t = 0;
        $ends_t = 0;
        $sust_t = 0;
        $empty_t = 0;
        $total_t = 0;
		$num = 0;
		foreach ($folios as $key => $value) {
        	$comm = 0;
        	$cond = 0;
        	$canc = 0;
        	$capt = 0;
        	$cotz = 0;
        	$emsn = 0;
        	$ends = 0;
        	$sust = 0;
        	$empty = 0;
        	$total = 0;
        	foreach ($result as $k => $val) {
        		if ($val->folioActividad == $value) {
        			if (!empty($val->tipoActividad)) {
        				switch($val->tipoActividad) {
        					case 'AclaraciondeComision': $comm++; $comm_t++; break;
        					case 'CambiodeConducto': $cond++; $cond_t++; break;
        					case 'Cancelacion': $canc++; $canc_t++; break;
        					case 'CapturaEmision': $capt++; $capt_t++; break;
        					case 'Cotizacion': $cotz++; $cotz_t++; break;
        					case 'Emision': $emsn++; $emsn_t++; break;
        					case 'Endoso': $ends++; $ends_t++; break;
        					case 'Sustitucion': $sust++; $sust_t++; break;
        				}
        			}
        			else { $empty++; $empty_t++; }
        			$total = $comm + $cond + $canc + $capt + $cotz + $emsn + $ends + $sust + $empty;
        		}
        	}
        	$total_t = $comm_t + $cond_t + $canc_t + $capt_t + $cotz_t + $emsn_t + $ends_t + $sust_t + $empty;
       		$add['0'] = $value;
        	$add['1'] = $comm = ($comm != 0) ? $comm : "";
       		$add['2'] = $cond = ($cond != 0) ? $cond : "";
       		$add['3'] = $canc = ($canc != 0) ? $canc : "";
       		$add['4'] = $capt = ($capt != 0) ? $capt : "";
       		$add['5'] = $cotz = ($cotz != 0) ? $cotz : "";
       		$add['6'] = $emsn = ($emsn != 0) ? $emsn : "";
       		$add['7'] = $ends = ($ends != 0) ? $ends : "";
       		$add['8'] = $sust = ($sust != 0) ? $sust : "";
       		$add['9'] = $empty = ($empty != 0) ? $empty : "";
       		$add['10'] = $total;
       		array_push($body,$add);
		}
		$insert['0'] = "TOTAL";
		$insert['1'] = $comm_t;
		$insert['2'] = $cond_t;
		$insert['3'] = $canc_t;
		$insert['4'] = $capt_t;
		$insert['5'] = $cotz_t;
		$insert['6'] = $emsn_t;
		$insert['7'] = $ends_t;
		$insert['8'] = $sust_t;
		$insert['9'] = $empty_t;
		$insert['10'] = $total_t;
		array_push($body, $insert);
		return array("0" => $header, "1" => $body, "2" => "Resumen");
	}

	function exportActivitiesPart1() { //Método de Exportación Alternativo
		$tables = $this->input->post('t1');
    	$cells = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
    	$title = "Actividades_Parte_1 ".date("Y-m-d H:i:s");
    	//Styles
    	$titleTable = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => 'FFFFFF'),
    	  	],
    	  	'alignment' => [
    	  		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => '6B7C59']
    	  	],
      		'borders' => [
      		    'top' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '7C7C7C']
      		    ]
      		],
    	];
    	$headTotal = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => '000000'),
    	  	],
    	  	'alignment' => [
    	  	    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => '92d050']
    	  	]
    	];
    	$bodyTotal = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => '000000'),
    	  	],
      		'borders' => [
      		    'outline' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '9bc3e6']
      		    ]
      		],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => 'ddebf7']
    	  	]
    	];
    	//------------> Tabla Totales | t1
    	$cellI = 1;
    	$rowI = 1;
    	$this->excel->setActiveSheetIndex(0);
    	$this->excel->getActiveSheet()->setTitle("Totales");
    	$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
    	$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(23);
    	$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(23);
    	$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(23);
    	$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(23);
    	$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(23);
    	$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(23);
    	$this->excel->getActiveSheet()->mergeCells('A9:G9')->setCellValue('A9','Todos los Ramos');
    	$this->excel->getActiveSheet()->getStyle('A9:G9')->applyFromArray($titleTable);
    	//Tabla Total de las Actividades
    	foreach ($tables as $key1 => $value) {
    		foreach ($value[0] as $key => $val) {
    			$cell = strval($cells[$key].$rowI);
    			$name = strval($val);
    			$this->excel->getActiveSheet()->setCellValue($cell,$name)->getStyle($cell)->applyFromArray($headTotal);
    		}
    		$rowI++;
    		foreach ($value[1] as $key => $val) {
    			$length = count($value[1]);
    			$length = $length != 0 ? $length - 1 : 0;
    			$value_c = count($val);
    			$value_c = $value_c != 0 ? $value_c - 1 : 0;
    			foreach ($val as $k => $row) {
    				$cell = strval($cells[$k].$rowI);
    				$text = strval($row);
    				$this->excel->getActiveSheet()->setCellValue($cell,$text)->getStyle($cell);
    				if ($key == $length || $k == $value_c) {
    					$this->excel->getActiveSheet()->setCellValue($cell,$text)->getStyle($cell)->applyFromArray($bodyTotal);
    				}
    			}
    			$rowI++;
    		}
    		$rowI = $rowI + 2;
    	}

    	header("Content-Type: aplication/vnd.ms-excel");
    	header("Content-Disposition: attachment; filename=\"$title.xls\"");
    	header("Cache-Control: max-age=0");

    	$writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
    	ob_start();
		$writer->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();

    	$data = array(
    		'title' => $title.'.xls',
    		'header' => $header,
    		'body' => $body,
        	'status' => 1,
        	'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
     	);
    	echo json_encode($data);
	}

	function exportTableActivities() { //Método de Exportación Alternativo
		$title_sheet = strval($this->input->post('tt'));
		$header = $this->input->post('d_h');
		$body = $this->input->post('d_b');
    	$cells = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
    	$title = $this->input->post('tf')." ".date("Y-m-d H:i:s");
    	//Styles
    	$headTotal = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => '000000'),
    	  	],
    	  	'alignment' => [
    	  	    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => '92d050']
    	  	]
    	];
    	$bodyTotal = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => '000000'),
    	  	],
      		'borders' => [
      		    'outline' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '9bc3e6']
      		    ]
      		],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => 'ddebf7']
    	  	]
    	];
    	//------------> Tabla Totales | t1
    	$cellI = 1;
    	$row = 2;
    	$this->excel->setActiveSheetIndex(0);
    	$this->excel->getActiveSheet()->setTitle($title_sheet);
    	foreach ($header as $key => $val) {
    		$letter = strval($cells[$key]);
    		$cell = strval($cells[$key].'1');
    		$name = strval($val);
    		$this->excel->getActiveSheet()->getColumnDimension($letter)->setWidth(23);
    		$this->excel->getActiveSheet()->setCellValue($cell,$name)->getStyle($cell)->applyFromArray($headTotal);  
    	}
    	foreach ($body as $key => $value) {
    		$length = count($body);
    		$length = $length != 0 ? $length - 1 : 0;
    		$value_c = count($value);
    		$value_c = $value_c != 0 ? $value_c - 1 : 0;
    		foreach ($value as $k => $val) {
    			$cell = strval($cells[$k].$row);
    			$text = strval($val);
    			$this->excel->getActiveSheet()->setCellValue($cell,$text)->getStyle($cell);
    			if ($key == $length || $k == $value_c) {
    				$this->excel->getActiveSheet()->setCellValue($cell,$text)->getStyle($cell)->applyFromArray($bodyTotal);
    			}
    		}
    		$row++;
    	}
    	$row = $row + 3;

    	header("Content-Type: aplication/vnd.ms-excel");
    	header("Content-Disposition: attachment; filename=\"$title.xls\"");
    	header("Cache-Control: max-age=0");

    	$writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
    	ob_start();
		$writer->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();

    	$data = array(
    		'title' => $title.'.xls',
    		'header' => $header,
    		'body' => $body,
        	'status' => 1,
        	'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
     	);
    	echo json_encode($data);
	}

	function exportActivitiesPart2($tables) {
    	$cells = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
    	$title = "Actividades_Parte_2 ".date("Y-m-d H:i:s");
    	//Styles
    	$titleTable = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => 'FFFFFF'),
    	  	],
    	  	'alignment' => [
    	  		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => '6B7C59']
    	  	],
      		'borders' => [
      		    'top' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '7C7C7C']
      		    ]
      		],
    	];
    	$headTotal = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => '000000'),
    	  	],
    	  	'alignment' => [
    	  	    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => '92d050']
    	  	]
    	];
    	$headResumen = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => 'FFFFFF'),
    	  	],
    	  	'alignment' => [
    	  	    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => '1e4c82']
    	  	]
    	];
    	$bodyTotal = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => '000000'),
    	  	],
      		'borders' => [
      		    'outline' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '9bc3e6']
      		    ]
      		],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => 'ddebf7']
    	  	]
    	];
    	//----------------------------- Generar Tablas -----------------------------
    	$cellI = 1;
    	$rowI = 1;
    	foreach ($tables as $key1 => $value) {
    		$style = $headTotal;
    		switch ($value[2]) {
				/* Se quitó Total y Vendedores por sobre carga de información */
    			/*case 'Totales':
    				$this->excel->setActiveSheetIndex(0);
    				$this->excel->getActiveSheet()->setTitle("Totales");
    			break;
    			case 'Vendedores':
    				$rowI = $rowI + 2;
    				$style = $headTotal;
    				$this->excel->getActiveSheet()->mergeCells('A9:G9')->setCellValue('A9','Todos los Ramos');
    				$this->excel->getActiveSheet()->getStyle('A9:G9')->applyFromArray($titleTable);
    			break;*/
    			case 'Movimiento':
    				$rowI = 1;
    				//$this->excel->createSheet(1);
    				$this->excel->setActiveSheetIndex(0);
    				$this->excel->getActiveSheet()->setTitle("Movimiento");
    				$style = $headResumen;
    			break;
    			case 'Resumen':
    				$rowI = 1;
    				$this->excel->createSheet(1);
    				$this->excel->setActiveSheetIndex(1);
    				$this->excel->getActiveSheet()->setTitle("Resumen");
    				$style = $headResumen;
    			break;
    		}
    		foreach ($value[0] as $key => $val) {
    			$letter = strval($cells[$key]);
    			$cell = strval($cells[$key].$rowI);
    			$name = strval($val);
    			$this->excel->getActiveSheet()->getColumnDimension($letter)->setWidth(23);
    			$this->excel->getActiveSheet()->setCellValue($cell,$name)->getStyle($cell)->applyFromArray($style);
    		}
    		$rowI++;
    		foreach ($value[1] as $key => $val) {
    			$length = count($value[1]);
    			$length = $length != 0 ? $length - 1 : 0;
    			$value_c = count($val);
    			$value_c = $value_c != 0 ? $value_c - 1 : 0;
    			foreach ($val as $k => $row) {
    				$cell = strval($cells[$k].$rowI);
    				$text = strval($row);
    				$this->excel->getActiveSheet()->setCellValue($cell,$text)->getStyle($cell);
    				if ($key == $length || $k == $value_c) {
    					$this->excel->getActiveSheet()->setCellValue($cell,$text)->getStyle($cell)->applyFromArray($bodyTotal);
    				}
    			}
    			$rowI++;
    		}
    	}

    	header("Content-Type: aplication/vnd.ms-excel");
    	header("Content-Disposition: attachment; filename=\"$title.xls\"");
    	header("Cache-Control: max-age=0");

    	$writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
    	file_put_contents('depuracion.txt', ob_get_contents());
    	ob_end_clean();
    	$writer->save("php://output");
	}

	function exportCompleteReport($result) {
    	$cells = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
    	$title = "Reporte ".date("Y-m-d H:i:s");
    	//Styles
    	$header = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'color' => array('rgb' => '000000'),
    	  	],
    	  	'alignment' => [
    	  	    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
      		'borders' => [
      		    'outline' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '3d3d3d']
      		    ]
      		],
    	];
    	$body = [
    	  	'font' => [
    	  	    'bold'  =>  false,
    	  	    'color' => array('rgb' => '000000'),
    	  	],
      		'borders' => [
      		    'outline' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '3d3d3d']
      		    ]
      		],
    	];
    	$cellI = 1;
    	foreach ($result as $key1 => $value) {
    		$rowI = 1;
    		switch ($value[2]) {
    			case 'General':
    				$this->excel->setActiveSheetIndex(0);
    				$this->excel->getActiveSheet()->setTitle("General");
    				break;
    			case 'Repetidas':
    				$this->excel->createSheet(1);
    				$this->excel->setActiveSheetIndex(1);
    				$this->excel->getActiveSheet()->setTitle("Repetidas");
    				break;
    		}
    		foreach ($value[0] as $key => $val) {
    			$letter = strval($cells[$key]);
    			$cell = strval($cells[$key].$rowI);
    			$name = strval($val);
    			$this->excel->getActiveSheet()->getColumnDimension($letter)->setWidth(35);
    			$this->excel->getActiveSheet()->setCellValue($cell,$name)->getStyle($cell)->applyFromArray($header);
    			$add['celda'] = $cell;
    			$add['valor'] = $name;
    			$add['row'] = $rowI;
    			array_push($header, $add);
    		}
    		$rowI++;
    		foreach ($value[1] as $key => $val) {
    			foreach ($val as $k => $row) {
    				$cell = strval($cells[$k].$rowI);
    				$text = strip_tags($row);
    				$text = html_entity_decode($text);
    				$this->excel->getActiveSheet()->setCellValue($cell,$text)->getStyle($cell)->applyFromArray($body);
    				$add['celda'] = $cell;
    				$add['valor'] = $name;
    				$add['row'] = $rowI;
    				array_push($header, $add);
    			}
    			$rowI++;
    		}
    	}

    	header("Content-Type: aplication/vnd.ms-excel");
    	header("Content-Disposition: attachment; filename=\"$title.xls\"");
    	header("Cache-Control: max-age=0");

    	$writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
    	file_put_contents('depuracion.txt', ob_get_contents());
    	ob_end_clean();
    	$writer->save("php://output");
	}
//--------------------------------------------------------------------------------------------------------------

}
/* End of file monitores.php */
/* Location: ./application/controllers/monitores.php */
