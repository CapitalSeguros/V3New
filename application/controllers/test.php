<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class test extends CI_Controller{

	function __construct(){
			parent::__construct();
			$this->load->library('ws_sicas');
			$this->load->library("mailjet_api");

			$this->load->model('test_model','testm');
			$this->load->library('webservice');
	 		$this->load->model('personamodelo');
			$this->load->model('graficas_model');
	}	
	function index(){
		/*$sql="SELECT * FROM persona WHERE idPersona='563'";
        $rs=$this->db->query($sql)->result();
        if($rs){
            if($rs[0]->fecAltaSistemPersona!=''){  
            	$fecha_ingreso = date('Y-m-d',strtotime($rs[0]->fecAltaSistemPersona));
            	$fecha_ingreso = time() - strtotime($fecha_ingreso);
            	$yearAntiguedad=floor($fecha_ingreso/31556926);
                //determinar cantidad de dias de vacaciones correspondientes
                $sqlX="SELECT * FROM tabla_vacaciones WHERE anio='$yearAntiguedad'";
                $rsDias=$this->db->query($sqlX)->result();
                if($rsDias){
                    $datos[0]=$rsDias[0]->dias;
                    $datos[1]=$yearAntiguedad;
                }
            }else{
                $datos[0]='';
                $datos[1]='';
            }
            var_dump($datos);
        }*/
       $date = new DateTime("now", new DateTimeZone('America/Merida') );
	   echo $date->format('Y-m-d H:i:s');

    }

	
	function renovaciones(){
		$data=array();
		$vendedor=$this->tank_auth->get_IDVend();
		$fechaI='01/03/2021';
		$fechaF='08/03/2021';
		$data=$this->ws_sicas->obtenerRenovacionesFecha($vendedor,$fechaI,$fechaF,null,'0');
		return json_encode($data);
	}


	function dif(){
		$FHasta='02-03-2021';
		$fechaInsersion='03-03-2021';
		$dias = (strtotime($FHasta)-strtotime($fechaInsersion))/86400;
		$dias = floor($dias);
		echo $dias;
	}

	function correo(){
        $this->load->library('mailjet_api');
        $data['to']="migueload@gmail.com";
        $data['titulo']="test";
        $data['mensaje']="<html><h1>Test de mailjet</h1></html>";
        $result=$this->mailjet_api->envio_correos_convocatoria_reunion($data);
        echo json($result);
    }

	function php(){
		echo phpinfo();
	}

	/* function UpdateSiniestros(){
        $obj=$this->testm->getSiniestrosmal();
		//var_dump($obj);
        $consulta=$this->testm->validateServicio(1, 4, "INDIVIDUAL", "SERVICIO");
        
        foreach ($obj as $key => $value) {
            $DatosWS=$this->webservice->datos_WS($consulta,"NORMAL",array("solicitud"=>$value["cabina_id"]));
            $object=$this->webservice->consumoWS($DatosWS,1);
            //var_dump($object);
            //echo $object["Data"][0]["siniestro_id"].'test <br/>';
            //var_dump($object["Data"][0]["siniestro_id"]);
            $this->testm->updateSiniestro($value["id"],array("siniestro_id"=>$object["Data"][0]["siniestro_id"]));
            echo $object["Data"][0]["siniestro_id"]."<br/>";
            //
        }
        //var_dump($object);
        //var_dump($obj);
    } */


	/* function updatePoliza(){
        $data=$this->testm->getAllSiniestros();
        foreach ($data as $key => $value) {
            
            $poliza_data=$this->testm->getPoliza($value['poliza']);
            $jsonP=json_decode($poliza_data[0]['data_poliza'],true);
            $data_u=array(
                'aseguradora_id'=>$jsonP['IDCia']
            );
            $this->testm->updateSiniestro($value['id'],$data_u);
            echo $value['poliza'].' # de aseguradora-> '.$jsonP['IDCia']. '<br/>';
        }
        //header('Content-Type: application/json');
       // echo json_encode($data);
    } */

	function test_graficas(){
		//$gmm=$this->graficas_model->getKPI_Siniestros("AUTOSI",null,date("Y"),6);
		echo 'Danos <br>';
		$danos=$this->graficas_model->getKPI_Siniestros("DANOS",null,date("Y"),6);
		echo json_encode($danos);

		echo ' <br>AutosI <br>';
		$autos=$this->graficas_model->getKPI_Siniestros("AUTOSI",null,date("Y"),6);
		echo json_encode($autos);
		//var_dump($gmm);
	}


}
