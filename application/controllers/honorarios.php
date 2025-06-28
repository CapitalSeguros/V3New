<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class honorarios extends CI_Controller
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
  $this->load->model('personamodelo');
   $this->load->library('Ws_sicas');
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

     $vendedor=$this->tank_auth->get_IDVend();
    if($vendedor>0)
    {
	$this->load->view('honorarios/honorarios');
    }
    else{
       //$consulta="select name_complete,IDVend from users where users.idTipoUser=6 or users.idTipoUser=8 order by users.name_complete";
			 //$datos=$this->db->query($consulta);
         $datosWeb['vendedorCombo']=$this->personamodelo->obtenerVendActivos();//$datos->result();
         	$this->load->view('honorarios/honorarios',$datosWeb);
    }	
 }


}
function buscaHonorarios(){

	//KEY CODE VIA REPORT
		//KeyReport=H02930_003
		/*
Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado
Desde|Hasta|Fecha de Pago;3;0;01/12/2016|12/12/2016;01/Dic/2016|12/Dic/2016;0;-1;DatHonDocto.FPago
		*/
/*$D_Cred=new stdClass();
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
         $datos['KeyCode']='H02930_003';
         $datos['Page']='1';
         $datos['ItemForPage']='600';
         $datos['InfoSort']='DatHonRecibos.Status_TXT';
         $datos['IDRelation']='0';	 */
     

      $vendedor=$this->tank_auth->get_IDVend();
 if($vendedor>0) {
 	if($this->input->post('opcionHonorario')=="2"){
/*$datos['ConditionsAdd']='Honorarios;0;0;0;Pendientes;DatHonRecibos.Pagado !
Comisiones;7;1;Conciliado;Conciliado;VDPagoComRec.ComPagada ! 
recibos;0;0;4;-1;DatRecibos.Status ! VendedorID;0;0;'.$vendedor.';0;-1;DatHonRecibos.IDVE' ;*/
//$respuestaSicas=$this->webservice_sicas_soap->datosComisiones($datos);
  $respuestaSicas=$this->ws_sicas->obtenerHonorariosFecha($vendedor,null,null,2);
         $xml['TableInfo']=$respuestaSicas->TableInfo;
		 $xml['TableControl']=$respuestaSicas->TableControl;
		 $xml['idVendedor']=$vendedor;
		 $xml['opcionHonorario']="2";
		  $xml['fechaInicial']=$this->input->post('fIni');
          $xml['fechaFinal']=$this->input->post('fFin');

  }
  else{

   /* $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado !
    Desde|Hasta|Fecha de Pago;3;0;'.$this->input->post('fIni').'|'.$this->input->post('fFin').';'.$this->input->post('fIni').'|'.$this->input->post('fFin').';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';51;DatHonRecibos.IDVE' ;*/

 //$datosWeb['vendedorCombo']=$traeConsulta->result();
        // $respuestaSicas=$this->webservice_sicas_soap->datosComisiones($datos);
  $respuestaSicas=$this->ws_sicas->obtenerHonorariosFecha($vendedor,$this->input->post('fIni'),$this->input->post('fFin'),1);

         $xml['TableInfo']=$respuestaSicas->TableInfo;
		 $xml['TableControl']=$respuestaSicas->TableControl;
		 $xml['idVendedor']=$vendedor;
		  $xml['opcionHonorario']=$this->input->post('opcionHonorario');
          $xml['fechaInicial']=$this->input->post('fIni');
          $xml['fechaFinal']=$this->input->post('fFin');
      

  }

 }
else{
if($this->input->post('opcionHonorario')=="2"){
/*$datos['ConditionsAdd']='Honorarios;0;0;0;Pendientes;DatHonRecibos.Pagado !
Comisiones;7;1;Conciliado;Conciliado;VDPagoComRec.ComPagada ! 
recibos;0;0;4;-1;DatRecibos.Status ! VendedorID;0;0;'.$this->input->post('vendedor').';0;-1;DatHonRecibos.IDVE' ;*/
//$consulta="select name_complete,IDVend from users where users.idTipoUser=6 or users.idTipoUser=8 order by users.name_complete";
//$traeConsulta=$this->db->query($consulta);
$traeConsulta=$datosWeb['vendedorCombo']=$this->personamodelo->obtenerVendActivos();
//$respuestaSicas=$this->webservice_sicas_soap->datosComisiones($datos);
  $respuestaSicas=$this->ws_sicas->obtenerHonorariosFecha($this->input->post('vendedor'),null,null,2);
         $xml['TableInfo']=$respuestaSicas->TableInfo;
         $xml['vendedorCombo']=$traeConsulta->result();
		 $xml['TableControl']=$respuestaSicas->TableControl;
		 $xml['idVendedor']=$this->input->post('vendedor');
		 $xml['opcionHonorario']=$this->input->post('opcionHonorario');
		           $xml['fechaInicial']=$this->input->post('fIni');
          $xml['fechaFinal']=$this->input->post('fFin');
  }
  else{

    $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado !
    Desde|Hasta|Fecha de Pago;3;0;'.$this->input->post('fIni').'|'.$this->input->post('fFin').';'.$this->input->post('fIni').'|'.$this->input->post('fFin').';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$this->input->post('vendedor').';'.$this->input->post('vendedor').';51;DatHonRecibos.IDVE' ;
//$consulta="select name_complete,IDVend from users where users.idTipoUser=6 or users.idTipoUser=8 order by users.name_complete";
			 //$traeConsulta=$this->db->query($consulta);
     $traeConsulta=$datosWeb['vendedorCombo']=$this->personamodelo->obtenerVendActivos();
 //$datosWeb['vendedorCombo']=$traeConsulta->result();
        // $respuestaSicas=$this->webservice_sicas_soap->datosComisiones($datos);
          $respuestaSicas=$this->ws_sicas->obtenerHonorariosFecha($this->input->post('vendedor'),$this->input->post('fIni'),$this->input->post('fFin'),1);


         $xml['TableInfo']=$respuestaSicas->TableInfo;
         $xml['vendedorCombo']=$traeConsulta;
		 $xml['TableControl']=$respuestaSicas->TableControl;
		 $xml['idVendedor']=$this->input->post('vendedor');
		  $xml['opcionHonorario']=$this->input->post('opcionHonorario');
          $xml['fechaInicial']=$this->input->post('fIni');
          $xml['fechaFinal']=$this->input->post('fFin');
  }
}


		 $this->load->view('honorarios/honorarios',$xml);	
		              	
 }
 function restringirAgentes(){
 		if (!$this->tank_auth->is_logged_in()) 
	{
		redirect('/auth/login/');
	} 
	else 
	{

     $this->load->view('configuraciones/restringirAgentes');

 	
    }
  }

  function obtenerAgentesParaRestringir(){
	if (!$this->tank_auth->is_logged_in()) 
	{
		redirect('/auth/login/');
	} 
	else 
	{



		$D_Cred=new stdClass();
       	 $datoCredenciales['username']="nombre";
       	 $datoCredenciales['Password']="passwor";
       	 $datoCredenciales['CodeAuth']="codigo";
         $datos['TipoEntidad']='0';
         $datos['TypeDestinoCDigital']='CONTACT';
         $datos['IDValuePK']='0';
         $datos['ActionCDigital']='GETFiles';
         $datos['TypeFormat']='JSON';
         $datos['TProct']='Read_Data';
         $datos['KeyProcess']='REPORT';
         $datos['KeyCode']='H02930_003';
         $datos['Page']='1';
         $datos['ItemForPage']='1000';
         $datos['InfoSort']='DatHonRecibos.Status_TXT';
         $datos['IDRelation']='0';
		$datosConsulta=$this->db->query("select distinct(u.IDVend),u.name_complete,um.Ranking from users u 
left join user_miInfo um on um.IDVend=u.IDVend 
where u.banned=0  and u.idTipoUser=6  order by u.name_complete
");

		$datosConsultaBaneados=$this->db->query("select distinct(u.IDVend),u.name_complete,um.Ranking from users u 
left join user_miInfo um on um.IDVend=u.IDVend 
where u.banned=1 and  u.IdCanal=1 and um.Ranking='PROVISIONAL' and u.idTipoUser=12  order by u.name_complete");

		$totalRows=$datosConsulta->num_rows();
		$vendedor="";
		$i=0;
		$monto=0;
		$datosRestrinccion=array();
		$Importe="";$sumaImporte=0;
    /*FORMATO DE FECHA 01/9/2018|1*/
  foreach ($datosConsulta->result() as $value) 
  {
  	$vendedor=$value->IDVend;	
  	    $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado !
    Desde|Hasta|Fecha de Pago;3;0;'.$this->input->post('fIni').'|'.$this->input->post('fFin').';'.$this->input->post('fIni').'|'.$this->input->post('fFin').';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';51;DatHonRecibos.IDVE' ;

         $respuestaSicas=$this->webservice_sicas_soap->datosComisiones($datos);
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);//resultadoJasonac

      foreach ($respuestaSicas as $dato ) {
        
            $sumaImporte=$sumaImporte+floatval($dato->ImporteP);

         }

    $datosR[$i]['idVend']=$vendedor;
    $datosR[$i]['monto']=$sumaImporte;
       $datosR[$i]['name_complete']=$value->name_complete;
         $datosR[$i]['Ranking']=$value->Ranking;
    $sumaImporte=0;
    $i++;
  }
$d['TableInfo']=$datosR;
$d['baneados']=$datosConsultaBaneados->result();
          $d['fechaInicial']=$this->input->post('fIni');
          $d['fechaFinal']=$this->input->post('fFin');
    $this->load->view('configuraciones/restringirAgentes',$d);
/*
$vendedor=2;
$datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado !
    Desde|Hasta|Fecha de Pago;3;0;'.$this->input->post('fIni').'|'.$this->input->post('fFin').';'.$this->input->post('fIni').'|'.$this->input->post('fFin').';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';51;DatHonRecibos.IDVE' ;

         $respuestaSicas=$this->webservice_sicas_soap->datosComisiones($datos);



        foreach ($respuestaSicas as $dato ) {
         	$Importe=$Importe.$dato->ImporteP."+";
            $sumaImporte=$sumaImporte+floatval($dato->ImporteP);

         } 
        $Importe=$Importe."=".$sumaImporte;
        $a=array();
        /*$a[0]['b']="hola";
        $a[0]['c']="oye";
        $a[0]['d']="mira";
        //array_push($a[,'mal','BIEN');
        $a[1]['b']="hola";
        $a[1]['c']="oye";
        $a[1]['d']="mira";*/

       /* for($i=0;$i<5;$i++){
        	  $a[$i]['b']="hola";
        $a[$i]['c']="oye";
        $a[$i]['d']="mira";
        }*/

   

 
 	
    }

  }
  function bannea(){
  	$tipoOperacion= $_REQUEST["parametros"];

  	        echo json_encode($array);
   if($tipoOperacion['idVend']!=0){
       if($tipoOperacion['tipoOper']==0){
   
                    /*$data['banned']="1";
                    $this->db->where('IDVend',$tipoOperacion['idVend']);
                    $this->db->update('users',$data);*/
                    $campo="banned";
                    $valor=1;
                    $campoCondicion="IDVend";
                    $valorCondicion=$tipoOperacion['idVend'];
                    $tabla="users";

                           $actualizar[$campo]=$valor;
                           $actualizar['idTipoUser']='12';
                           $actualizar['idTipoUserSMSmail']='12';
     $this->db->where($campoCondicion,$valorCondicion);
     $this->db->update($tabla,$actualizar);

                                                      /*$fp = fopen('resultadoJason.txt', 'w');
                         fwrite($fp, print_r("qu paso", TRUE));
                         fclose($fp);*/


  	        echo json_encode($array);
       }
       else
       {
               $campo="banned";
                    $valor=0;
                    $campoCondicion="IDVend";
                    $valorCondicion=$tipoOperacion['idVend'];
                    
                    $tabla="users";

                           $actualizar[$campo]=$valor;
                           $actualizar['idTipoUser']='6';
                    $actualizar['idTipoUserSMSmail']='13';                    
     $this->db->where($campoCondicion,$valorCondicion);
     $this->db->update($tabla,$actualizar);

       }
     }
  /*	$fp = fope
  n('resultadoJason.txt', 'w');
                         fwrite($fp, print_r($array, TRUE));
                         fclose($fp);
  	 echo json_encode($array);*/
  }

}
