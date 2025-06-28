<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class produccion extends CI_Controller
{
 private $quitarSicas = array('<p>', '</p>', '<br />', ',');
 private $ponerSicas = array('', '', '\n\r', '');	
 function __construct()
  {
	parent::__construct();		
	$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
	$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
	$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
	$this->load->library('Ws_sicasdre',$params);

	$this->load->helper('ckeditor');
	$this->load->model('capsysdre_actividades');
	$this->load->library(array("webservice_sicas_soap","role"));	
    $this->load->library('Ws_sicas');
 
  }


    function index()
   {	

	if (!$this->tank_auth->is_logged_in()) 
	{
		redirect('/auth/login/');
	} 
	else 
	{
     $this->load->view('reportes/produccion');	
	}
    }
    function traeDatos(){
 		if (!$this->tank_auth->is_logged_in()) 
	{
		redirect('/auth/login/');
	} 
	else 		
	{    /*$D_Cred=new stdClass();
       	 $datoCredenciales['username']="nombre";
       	 $datoCredenciales['Password']="passwor";
       	 $datoCredenciales['CodeAuth']="codigo";
          
         $datos['TipoEntidad']='0';
         $datos['TypeDestinoCDigital']='CONTACT';
         $datos['IDValuePK']='0';
         $datos['ActionCDigital']='GETFiles';
         $datos['TypeFormat']='XML';
         $datos['TProct']='Read_Data';
         $datos['KeyProcess']='REPORT';
         $datos['KeyCode']='HWS_DOCTOS';
         $datos['Page']='1';
         $datos['ItemForPage']='10000000';
         $datos['InfoSort']='VDatDocumentos.IDDocto';
         $datos['IDRelation']='0';*/

 
		if($this->input->post('fIni')=='' or $this->input->post('fFin')=='' )	
       {
      
 	     $datos["mensaje"]="requiere fecha para la consulta";//$this->input->post('f_Ini');
 	    $this->load->view('reportes/produccion',$datos);	
	   }
       else
       { 
         $fecha=$this->input->post('fIni');  		
       	 $fec= explode("/",$fecha);
         list($dia,$mes,$anio)=$fec;     
         $fechaCon1=$dia."-".$mes."-".$anio;
	     $fechaI= date("d-m-y", strtotime($fechaCon1));     
	     
         $fecha=$this->input->post('fFin');     
         $fec= explode("/",$fecha);
         list($dia,$mes,$anio)=$fec;     
         $fechaCon2=$dia."-".$mes."-".$anio;
         $fechaF=date("d-m-y",strtotime($fechaCon2));

          $vendedor=$this->tank_auth->get_IDVend();
    if($vendedor>0)
    {
      $datos['ConditionsAdd']='       
          Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatDocumentos.FDesde ! Documento;0;0;0;1;DatDocumentos.Status ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
    else{
           $datos['ConditionsAdd']='       
          Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatDocumentos.FDesde ! Documento;0;0;0;1;DatDocumentos.Status ';
    }
	  

         //$xml=$this->webservice_sicas_soap->datos($datos);
              $xml=$this->ws_sicas->obtenerCarteraFecha($vendedor,$fechaI,$fechaF);
$contador=0;
                 $contador=$xml->TableControl->MaxRecords;
                 if($contador>1){
                             $xml->addChild('fecFin', $this->input->post('fFin'));
                       $xml->addChild('fecIni', $this->input->post('fIni'));
                	 $this->load->view('reportes/produccion',$xml);
                 }
                 else
                 { 
                    $x['fecFin']= $this->input->post('fFin');
                      $x['fecIni']= $this->input->post('fIni');
                     $x['TableInfo']= $xml->TableInfo; 
                     $x['TableControl'] =$xml->TableControl;               
                     
                  	 $this->load->view('reportes/produccion',$x);
                 }

       
       }  
      		
	}
 }

 function traeArchivos(){
 			try{		
			$idDocto = $_REQUEST["IDDocto"];
	
		$data = array("IDDocto" => $idDocto
			);
			$this->load->library("webservice_sicas_soap");
      $this->load->library("Ws_sicas");
			//$data_result = $this->webservice_sicas_soap->GetCDDigital($data);
     $data_result = $this->ws_sicas->GetCDDigital($data);
			echo json_encode($data_result);
		}catch(Exception $e){
		
		}

   }


function traeArchivosAnteriores(){
 			try{		
			$idDocto = $_REQUEST["IDDocto"];
	
			$data = array(
				"IDDocto" => $idDocto
			);
			$this->load->library("webservice_sicas_soap");

                $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']='H03430_003';
        $datos['Page']='1';
        $datos['ItemForPage']='10000000';
        $datos['InfoSort']='VDatDocumentos.IDDocto';
        $datos['IDRelation']='0';
        $datos['ConditionsAdd']='Documento;0;0;'.$idDocto.';'.$idDocto.';DatDocumentos.Documento';

 $xml=$this->webservice_sicas_soap->datos($datos); 
                

 $d=array();
 $d['IDDocto']=(string)$xml->TableInfo->IDDocto;

  $data_result = $this->webservice_sicas_soap->GetCDDigital($d);
  
 foreach ($xml->TableInfo as $info) {    
     $data_result['VendNombre']=$info->VendNombre;
     $data_result['PrimaTotal']=$info->PrimaTotal;
     $data_result['PrimaNeta']=$info->PrimaNeta;
     $data_result['SRamoAbreviacion']=$info->SRamoAbreviacion;
     $data_result['CiaNombre']=$info->CiaNombre;
     $data_result['CAgente']=$info->CAgente;
     $data_result['Moneda']=$info->Moneda;
     $data_result['Concepto']=$info->Concepto;
     $data_result['NombreCompleto']=$info->NombreCompleto;
     $data_result['Status_TXT']=$info->Status_TXT;
      $data_result['FHasta']=$info->FHasta;
     $data_result['FDesde']=$info->FDesde;
     $data_result['DAnterior']=$info->DAnterior;
     $data_result['Documento']=$info->Documento;
      $data_result['TipoDocto_TXT']=$info->TipoDocto_TXT;
  }

			echo json_encode($data_result);
		}catch(Exception $e){
		
		}

}

   
    function traeArchivosBit(){
		$claveBit = "";
		if($_REQUEST["claveBit"] != null){
			$claveBit = $_REQUEST["claveBit"];
			//$sPage = $_REQUEST["start"];
			$sPage=0;
			if($sPage > 0){
				$sPage = ($sPage / 10) + 1;	
			}else{
				$sPage = 1;
			}
			$data_body = array('claveBit' => $claveBit, 'page'=>$sPage );

			$data= $this->webservice_sicas_soap->GetInfoBit($data_body);
					
                          if($data != null){
                    $json = json_encode($data);
                  $array = json_decode($json, TRUE);
                  echo json_encode($array);
  					

                          }
                          else
                          {
                          	echo json_encode(array(
					        'data'=>$tb_infoBit,
				            'recordsTotal'=>'0',
				            'recordsFiltered'=> 0));
                          }

	
		}

 }
  }
