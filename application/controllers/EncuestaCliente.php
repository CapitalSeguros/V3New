<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';

class EncuestaCliente extends CI_Controller{


        function __construct(){
        parent::__construct();     
        $this->CI =& get_instance();
        $this->load->model('chequesmodel');
        $this->load->model('catalogos_model');        
         $this->load->model('preguntamodel'); 
    }
    function index(){
   // $data['movimientos'] =  $this->capsysdre->TipoMovimiento();
    //$data['bancos'] =  $this->capsysdre->ListaBancos();
    //$data['concepto'] = $this->capsysdre->ListaConceptos();
    //$data['Cheque'] = $this->capsysdre->ListaCheques();
    //$data['companias']= $this->catalogos_model->devolverCompanias();
    //$this->load->view('EncuestaCliente/EncuestaCliente',$data);
    $this->load->view('EncuestaCliente/EncuestaCliente');
      
  }
  
  function Encuesta()
  {

    //$this->load->view('EncuestaCliente/EncuestaCliente');
           if( $this->input->get('idenc',TRUE))
            {
               $valor = $this->input->get('idenc');
              // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($valor, TRUE));fclose($fp);
               $consulta="select idcalificaencuesta  from calificaencuesta where activa = '0' and cifrado like'".$valor."'";
	               
	           $query=$this->db->query($consulta);
	           $fila=$query->row();
	           //$valor = $query->num_rows();
	          // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($fila, TRUE));fclose($fp);
               if($fila->idcalificaencuesta > 0)
               {
                $data['idenc'] = $this->input->get('idenc');
                $data['enc'] =1;                    	   
			       $data['Pre'] = $this->preguntamodel->TEncuestaEmpleado($fila->idcalificaencuesta);
                $data['ide']= $valor;
                // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data, TRUE));fclose($fp);
             //$data['cabe'] = $query->idcalificaencuesta;
             //$data['usu'] = $this->preguntamodel->EnviaPregunta('1');  
             //$data['ban'] = '0';  
         //redirect('encuesta/VistaEncuesta');                     // $this->load->view('inicio/principal',$data);
            // $this->load->view('encuesta/encuesta',$data);
               // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($fila->idcalificaencuesta, TRUE));fclose($fp);		   

                $this->load->view('EncuestaCliente/EncuestaCliente', $data);
             }   
             else
             {
                 $data['idenc'] =-1;
              	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data, TRUE));fclose($fp);	   
			          $data['enc'] =1;			 
                $data['Pre'] = $this->preguntamodel->TEncuestaEmpleado('-1');
                $data['ide']=-1;
               //redirect('EncuestaCliente/','refresh'); 
               //$this->load->view('EncuestaCliente/', $data);      
             }
         }
  }

}