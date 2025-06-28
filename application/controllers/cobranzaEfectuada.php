<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cobranzaEfectuada extends CI_Controller
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
  $this->load->library('Ws_sicas');

  $this->load->helper('ckeditor');
  $this->load->model('capsysdre_actividades');
  $this->load->library(array("webservice_sicas_soap","role"));  
 
  }


    function index()
   {  

  if (!$this->tank_auth->is_logged_in()) 
  {
    redirect('/auth/login/');
  } 
  else 
  {
     $this->load->view('reportes/cobranzaEfectuada'); 
  }
    }
    function traeDatos(){
    if (!$this->tank_auth->is_logged_in()) 
  {
    redirect('/auth/login/');
  } 
  else    
  { 
    if($this->input->post('fIni')=='' or $this->input->post('fFin')=='' ) 
       {
      $datos["mensaje"]="requiere fecha para la consulta";//$this->input->post('f_Ini');
      $this->load->view('reportes/cobranzaEfectuada',$datos); 
     }
       else{          
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
    



      /*  $D_Cred=new stdClass();
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
       $datos['KeyCode']='H03430_003';
       $datos['Page']='1';
       $datos['ItemForPage']='10000000';
       $datos['InfoSort']='VDatDocumentos.IDDocto';
       $datos['IDRelation']='0';*/

  $vendedor=$this->tank_auth->get_IDVend();
  /*  if($vendedor>0)
    {
     $datos['ConditionsAdd']='       
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;3;3;0;VDatRecibos.Status ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
    else{
           $datos['ConditionsAdd']='       
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;3;3;0;VDatRecibos.Status  ';
    }*/
  
        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos,TRUE));fclose($fp);         
         

 
              /*$datos['ConditionsAdd']='
       Desde|Hasta;3;0;'.$fecha2I.'|'.$fecha2F.';0;-1;VDatRecibos.FLimPago ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;1;1;0;VDatRecibos.Status  ';*/

//17/02/2017
       // $xml=$this->webservice_sicas_soap->datos($datos);
       $xml=$this->ws_sicas->obtenerReporteCobranza($vendedor,$fechaI,$fechaF,3);
$contador=0;
                 $contador=$xml->TableControl->MaxRecords;
                 if($contador>1){
                             $xml->addChild('fecFin', $this->input->post('fFin'));
                       $xml->addChild('fecIni', $this->input->post('fIni'));
                     $this->load->view('reportes/cobranzaEfectuada',$xml);
                 }
                 else
                 { 
                    $x['fecFin']= $this->input->post('fFin');
                      $x['fecIni']= $this->input->post('fIni');
                     $x['TableInfo']= $xml->TableInfo; 
                     $x['TableControl'] =$xml->TableControl;               
                     
                       $this->load->view('reportes/cobranzaEfectuada',$x );
                 }


          
       }        
  }
 }

 function traeArchivos(){
      try{    
      $idDocto = $_REQUEST["IDDocto"];
  
      $data = array(
        "IDDocto" => $idDocto
      );
      $this->load->library("webservice_sicas_soap");
      $data_result = $this->webservice_sicas_soap->GetCDDigital($data);
           


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
            /*$fp = fopen('resultadoJason.txt', 'w');
                 fwrite($fp, print_r($array, TRUE));
                          fclose($fp);*/

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