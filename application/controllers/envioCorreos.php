<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

  require_once	'vendor/autoload.php';
  use \Mailjet\Resources;

class envioCorreos extends CI_Controller{

	function __construct(){
		parent::__construct();     
		$this->CI =& get_instance();
		
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		$this->load->library('email',$config);
		
		$this->load->model('capsysdre_envioCorreos');
		

	}

	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			echo "<pre>";
				echo "Seleccione el tipo de Envio";
			echo "</pre>";
		}
	}/*! index */

    function envioMasivo(){
		// ** MailJet ** //
		$mj = new \Mailjet\Client('47fedff9be502f8e331e135dbc9d23fb','87ef76370b90a9b2a50afb8332586118',true,['version' => 'v3.1']);
		
		$config	= Array(
					'protocol'	=> 'smtp',
					'smtp_host'	=> 'mail.agentecapital.com',
					'smtp_port'	=> 587,
					'smtp_user'	=> 'desarrollo@agentecapital.com', 
					'smtp_pass' => 'Desarrollo2023#$', 
					'mailtype'	=> 'html',
					'charset'	=> 'iso-8859-1',
					'wordwrap'	=> TRUE
					   );
		$this->load->library('email', $config);		
			$correosPendientesEnviar = $this->capsysdre_envioCorreos->correosPendientesEnviar();
			if($correosPendientesEnviar != FALSE){
			foreach($correosPendientesEnviar as $correoPendienteEnviar){
				$data['idCorreo'][] = $correoPendienteEnviar['idCorreo'];
				$correoPendienteEnviar['asunto'];
				$fromNombre	= strstr($correoPendienteEnviar['desde'], '<', true);
				$fromEmail	= trim(substr(strstr($correoPendienteEnviar['desde'], "<"), 1),'>');
				
				
			
				$body = [
					'Messages' => [
						[
							'From' => [
							'Email' => "sistemas@asesorescapital.com",
							'Name' => $fromNombre
						],
					'To' => [
						[
							'Email' => $correoPendienteEnviar['para'],
							'Name' => ""
						]
					],					
					'Subject' => $correoPendienteEnviar['asunto'],
					'TextPart' => "",
					'HTMLPart' => $correoPendienteEnviar['mensaje'],
			        'CustomID' => $correoPendienteEnviar['idCorreo']
						]
					]
				];
				
				$mj->post(Resources::$Email, ['body' => $body]);

				$this->capsysdre_envioCorreos->correoEnviadoUpdate($correoPendienteEnviar['idCorreo']);
			}
			} else {
				$data['idCorreo'] = FALSE;
			}
				$data["script"] = "<script type='text/javascript'>window.onfocus=function(){ window.close();} </script>";
			$this->load->view('envioCorreos/principal', $data);
    }/*! envioCorreos */
	
	function semaforoRojo()
	{
		$sqlActividades = "
				Select
					`actividades`.`folioActividad`,
					`actividades`.`tipoActividad`,
					`actividades`.`Status`,
					`actividades`.`subRamoActividad`,
					`actividades`.`nombreCliente`,
					`actividades`.`nombreUsuarioVendedor`,
					((TIMESTAMPDIFF(MINUTE,	`actividades`.`fechaActualizacionStatus`,NOW()))/60) AS `tiempoSemaforo`,
					`catalog_promotorias`.`horasOficinaCP`,
					`catalog_promotorias`.`horasPortalCP`,
					`catalog_promotorias`.`Promotoria`
				From
					`actividades` INNER JOIN `relactividadpromotoria`
					on
					`actividades`.`folioActividad` = `relactividadpromotoria`.`folioActividad` INNER JOIN `catalog_promotorias`
					on
					`relactividadpromotoria`.`idPromotoria` = `catalog_promotorias`.`idPromotoria`
				Where
					YEAR(`fechaCreacion`) = YEAR(NOW())
					And
					MONTH(`fechaCreacion`) = MONTH(NOW())
					And
					DAY(`fechaCreacion`) = DAY(NOW())
					And
					`actividades`.`emailSemaforoRojo` != '1'
				;
						  ";
			$queryActividades = $this->db->query($sqlActividades);	

           
				$folios=array();
			foreach($queryActividades->result() as $actividades){
                 
				$message		= "";
				$colorSemaforo	= $this->controlaSemaforos($actividades->tiempoSemaforo, $actividades->Status, $actividades->horasOficinaCP, $actividades->horasPortalCP, $actividades->tipoActividad);
				
				if($colorSemaforo == "tiempoExcedido")
				{
					$message .= "Folio:	".$actividades->folioActividad."<br />";
					$message .= "Actividad: ".$actividades->tipoActividad."<br />";;
					$message .= "SubRamo: ".$actividades->subRamoActividad."<br />";;
					$message .= "Cliente: ".$actividades->nombreCliente."<br />";;
					$message .= "Vendedor: ".$actividades->nombreUsuarioVendedor."<br />";
					$message .= "Aseguradora: ".$actividades->Promotoria."<br />";
					
					$this->CI->email->from("desarrollo@agentecapital.com", "Desarrollo");
					$this->CI->email->to("gerenteoperativo@agentecapital.com");
					$this->CI->email->bcc("juanjose@dre-learning.com");
	        		$this->CI->email->subject("Semaforos Rojos");
    	    		$this->CI->email->message($message);					
					if(!in_array($actividades->folioActividad, $folios))
				     {
						array_push($folios, $actividades->folioActividad);
					   $this->CI->email->send();
						$sqlUpdate = "Update `actividades` Set `emailSemaforoRojo` = '1' Where `folioActividad` = '".$actividades->folioActividad."';
								 ";
					}
		
					
					$this->db->query($sqlUpdate);
				}				
			}
			


				
    	
	}/*! semaforoRojo */
	
	function  controlaSemaforos($tiempoSemaforo,$Status,$horasOficinaCP,$horasPortalCP,$tipoActividad){
		$tiempo	= 'tiempoNormal';
		if($tipoActividad=="Emision" || $tipoActividad=="Cotizacion"){
			if($Status==5){
				if($tiempoSemaforo!=NULL){
					if($tiempoSemaforo>$horasPortalCP){
						$tiempo="tiempoExcedido";
					} else { 
						if((($tiempoSemaforo*100)/$horasPortalCP)>=70){
							$tiempo="tiempoAcabando";
						}
					}
				} else {
					$tiempo="sinTiempo";
				}
			} else {
				if($Status==2){
					if($tiempoSemaforo!=NULL){
						if($tiempoSemaforo>$horasOficinaCP){
							$tiempo="tiempoExcedido";
						} else {
							if((($tiempoSemaforo*100)/$horasOficinaCP)>=70){
								$tiempo="tiempoAcabando";
							}
						}
					} else { 
						$tiempo="sinTiempo";
					}
				}
			}
		}
	return $tiempo;
	} /* controlaSemaforos */
	
	function mailjet(){

  $mj = new \Mailjet\Client('47fedff9be502f8e331e135dbc9d23fb','87ef76370b90a9b2a50afb8332586118',true,['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "sistemas@asesorescapital.com",
          'Name' => "Sistemas"
        ],
        'To' => [
          [
            'Email' => "juanjose@dre-learning.com",
            'Name' => "Juan J Herrera"
          ]
        ],
        'Subject' => "Greetings from Mailjet.",
        'TextPart' => "My first Mailjet email",
        'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you! Version Limpia Gap",
        'CustomID' => "AppGettingStartedTest"
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success() && var_dump($response->getData());

	}
//-----------------------------------------------------------

function envioCorreosMerketing(){
	// ** MailJet ** //
	$mj = new \Mailjet\Client('47fedff9be502f8e331e135dbc9d23fb','87ef76370b90a9b2a50afb8332586118',true,['version' => 'v3.1']);
		
		$config	= Array('protocol'	=> 'smtp','smtp_host'	=> 'mail.agentecapital.com','smtp_port'	=> 587,'smtp_user'	=> 'desarrollo@agentecapital.com', 'smtp_pass' => 'Desarrollo2023#$', 'mailtype'	=> 'html','charset'	=> 'iso-8859-1','wordwrap'	=> TRUE);
	$this->load->library('email', $config);		
		//$correosPendientesEnviar = $this->capsysdre_envioCorreos->correosPendientesEnviar();
		$correosPendientesEnviar=$this->db->query("select * from envio_correosmarketing e where e.status=0 order by e.idCorreo  desc limit 4")->result_array();  
		if($correosPendientesEnviar != FALSE){
		foreach($correosPendientesEnviar as $correoPendienteEnviar)
		{
			$data['idCorreo'][] = $correoPendienteEnviar['idCorreo'];
			$correoPendienteEnviar['asunto'];
			$fromNombre	= strstr($correoPendienteEnviar['desde'], '<', true);
			$fromEmail	= trim(substr(strstr($correoPendienteEnviar['desde'], "<"), 1),'>');
			
			

			$body = ['Messages' => [['From' => ['Email' => "sistemas@asesorescapital.com",'Name' => $fromNombre],
				'To' => [['Email' => $correoPendienteEnviar['para'],'Name' => ""]],					
				'Subject' => $correoPendienteEnviar['asunto'],
				'TextPart' => "",
				'HTMLPart' => $correoPendienteEnviar['mensaje'],
				'CustomID' => $correoPendienteEnviar['idCorreo']
					]
				]
			];
			
			$response=$mj->post(Resources::$Email, ['body' => $body]);
			
			  #$response->success() && var_dump($response->getData());
			  if(!$response->success()) 
			  {
				  $insert['idCorreo']=$correoPendienteEnviar['idCorreo'];
				  $insert['error']=json_encode($response->getData());
				  $this->db->insert('envio_correos_error',$insert);
			  } 
				  
			$this->db->where('idCorreo',$correoPendienteEnviar['idCorreo']);  
			$arrayEM['status']=1;
			$this->db->update('envio_correosmarketing',$arrayEM);
			#$this->capsysdre_envioCorreos->correoEnviadoUpdate($correoPendienteEnviar['idCorreo']);
		}
		} 
}
//-----------------------------------------------------------		
}

/* End of file envioCorreos.php */
/* Location: ./application/controllers/envioCorreos.php */