<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class encuesta extends CI_Controller{
   public  $bandera =0;
    function __construct(){
        parent::__construct();     
        $this->CI =& get_instance();
        $this->load->library("libreriav3"); //Agregado [Suemy][2024-06-10]
        $this->load->model('preguntamodel');
        $this->load->model('verencuestamodel');
        $this->load->model('superestrella_model'); //Agregado [Suemy][2024-06-10]
    }

    function index(){ //Modificado [Suemy][2024-06-10]
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {$email  = $this->tank_auth->get_usermail(); 
        //$idPersona= $this->tank_auth->get_idPersona();
        //$permission=0;
        //if($email=="SISTEMAS@ASESORESCAPITAL.COM" || $email=="AUDITORINTERNO@AGENTECAPITAL.COM"|| $email=="CAPITALHUMANO@AGENTECAPITAL.COM" || $email=="DIRECTORGENERAL@AGENTECAPITAL.COM" || $email=="PROYECTO@AGENTECAPITAL.COM.MX" || $email=="ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $email == "GERENTEOPERATIVO@AGENTECAPITAL.COM" || $email == "MARKETING@AGENTECAPITAL.COM"){$permission=1;}
        $data['Pre'] = $this->preguntamodel->TCalificacion('0',1970,1);  
        $data['usu'] = $this->preguntamodel->EnviaPregunta('1');  
        $data['ban'] = '0';
        //$data['permission'] = $permission;
        //redirect('encuesta/VistaEncuesta');

        //Mostrar Encuestas
        $optionTest = '<option value="todos">Todos</option>';
        $test = $this->verencuestamodel->getActiveTest();
        foreach ($test as $val) {
          $optionTest .= '<option value="'.$val->idcabencuesta.'">'.$val->descripcion.'</option>';
        }
        $data['optionT'] = $optionTest;
        //Encontrar meses
        $months = '';
        $m = $this->libreriav3->devolverMeses();
        foreach ($m as $key => $val) {
            /*$selected = ($key == date('m')) ? "selected" : "";*/
            $months .= "<option value=".$key.">".$val."</option>";
        }
        $data['optionM'] = $months;
        //Encontrar años
        $years = '';
        $count = date('Y') - 2020;
        $yearI = date('Y');
        for ($i=0;$i<=$count;$i++) {
            $selected = ($yearI == date('Y')) ? "selected" : "";
            $years .= '<option value="'.$yearI.'" '.$selected.'>'.$yearI.'</option>';
            $yearI--;
        }
        $data['optionY'] = $years;
        $this->load->view('encuesta/encuesta',$data);
//$this->load->view('encuesta');
        }
    }/*! index */

   function EncuestaAplicadas()
   { // Modificado [2024-01-02]
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
             
             $idusu  =$this->input->get('em'); 
             $data['ban'] = $this->session->flashdata('bandera');
             $data['Pre']=array();
             $fecha =  $this->input->get('mt'); 
             $fecha= $fecha."-01";
             $ano= strtotime($fecha);
            $devano = date("Y", $ano);
            $devmes = date("m", $ano);
             $data['fecha']=$devmes;
           // $data['fecha']= $fecha;
             if($idusu == "COLABORADORES")
             {
                $data['Pre'] = $this->preguntamodel->TCalificacion('1',$devano,$devmes);         

                $data['usu'] = $this->preguntamodel->EnviaPregunta('1');               
             }
            if($idusu == "AGENTES")
             {
                $data['Pre'] = $this->preguntamodel->TCalificacion('3',$devano,$devmes);         
                $data['usu'] = $this->preguntamodel->EnviaPregunta('3');               
             }
             if($idusu == "CLIENTES")
             {
              $data['Pre'] = $this->preguntamodel->TCalificacion('2',$devano,$devmes);         
              $data['usu'] = $this->preguntamodel->EnviaPregunta('2');  
             } 
             $data['empleado'] = $idusu;
             $data['fecha'] = $fecha;
             $data['año'] = $devano;
             $data['mes'] = $devmes;   
           echo json_encode($data);
        }
    }   
   /*************************************************/
   function encuestasActivas()
   {
     $consulta = "select * from cabencuesta where activa = 0";
    // $consulta = "select * from cabencuesta ";
    $datos = $this->db->query($consulta)->result();   
    echo json_encode($datos);
   }
   /************************************************ */
    function VistaEncuesta(){
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
            $data['Pre'] = $this->preguntamodel->TPreguntas();         
             $idusu  = $this->input->get('departamento');    
             /*if($bande > 0)
             /{
                $data['ban'] = 1;  
             } 
             else
            {*/
                 $data['ban'] = $this->session->flashdata('bandera');
             //}
             if($idusu = "COLABORADORES")
             {

                $data['usu'] = $this->preguntamodel->EnviaPregunta('1');               
             }
             if($idusu = "AGENTES")
             {
              $data['usu'] = $this->preguntamodel->EnviaPregunta('3,4');  
             }    
           $this->load->view('encuesta/encuesta',$data);
        }
    }   

    function GuardaEncuesta(){

           $bandera =0;    
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
          
           $idusuario =$this->tank_auth->get_idPersona();//$this->tank_auth->get_IDUserSICAS();
           $result = $this->preguntamodel->CompruebaAsigna($this->tank_auth->get_idPersona());  
           if($result->num_rows() > 0)
           {          
           $bandera =1;
           $this->session->set_flashdata('bandera', '1');
           $repues = $this->preguntamodel->TPreguntas();
           $Fechadia =  date('Y-m-d');
           foreach($repues as $each)
            {
              $pregu = $each->pregunta;
              $idpre = $each->idpregunta;
              $res = strtoupper ($this->input->post($idpre));
              
              $sqlInsert_Referencia = "              
                        Insert Ignore Into
                            `encuesta` 
                                    (
                                       `pregunta`,
                                        `respuesta`,
                                        `fecha`,
                                        `idusuario`
                                        ) 
                                    Values
                                    (

                                        '".$pregu."',
                                        '".$res."',
                                        '".$Fechadia."',
                                        '".$idusuario."'                                 
                                    );
                                            ";                         
                $this->db->query($sqlInsert_Referencia);
                $referencia = $this->db->insert_id();
                $sqlInsert_Referencia = "Update
                            `asignaempleado` set
                                        contesto = '1'                                     
                                    where
                                        contesto = '0' and `idempleado`='".$idusuario."'
                                            ";

                         
            $this->db->query($sqlInsert_Referencia);
            $referencia = $this->db->insert_id();       
                            
            
            }            
           }
           else
           {
            $this->session->set_flashdata('bandera', '0');
           }
           //}
               if($bandera =='1')
               { 
               echo "<script>alert('Se Ha Grabado');</script>"; 
               
               }
               else
               {
                echo "<script>alert('No Tiene Encuesta');</script>";               
               }
                redirect('encuesta/VistaEncuesta', 'refresh');


            //$data['ListaProveedores']= $this->capsysdre->ListaProveedores();
            // redirect('cheques');
             
        }
    }
//---------------------------------------------
function encuestaPorTelefono()
{
  $data=array();
  $data['encuestasActivas']=$this->verencuestamodel->devolverEncuestasActivas(null);
  
  $this->load->view('encuesta/encuestaPorTelefono_00',$data);
}
//------------------------------------------------
function devolverPreguntasPersonas()
{
  $datos=array();
  $datos['personasFaltantes']=$this->verencuestamodel->devolverPersonasFaltanesPorResponderEncuesta($_POST['idcabencuesta']);
  $datos['preguntas']=$this->verencuestamodel->devolverPreguntasDeEncuesta($_POST['idcabencuesta']);
  $datos['idencuesta']=$_POST['idcabencuesta'];

  echo json_encode($datos);

}
//-----------------------------------------------
function devolverEncuestaPersona()
{
  $datos=array();
  
  //$consulta='select * from encuesta where idcabencuesta='.$_POST['idcabencuesta'].' and idusuario='.$_POST['idPersona'];
    
  $pregunta= $this->verencuestamodel->devolverPreguntasDeEncuestaDeUsuario($_POST['idcabencuesta'],$_POST['idPersona']);

  $datos['encuesta']=    $pregunta['preguntas'];
  $datos['idencuesta']=$pregunta['idcalificaencuesta'];
  echo json_encode($datos);

}
//-----------------------------------------------    
function encuestaExtra()
    {
      $conuslta = "select idcabencuesta,descripcion from cabencuesta where activa = 0";
      $data['encuestas'] = $this->db->query($conuslta)->result();
      $this->load->view('encuesta/encuestaExtra',$data);
    }
//----------------------------------------------
function encuestasUrl()
 {
    $url =  $this->input->get('id');
    $consulta = "select * from cabencuesta where idcabencuesta = ". $url;
    //$this->db->query($consulta)->result();  
    $data['encuesta']=$this->db->query($consulta)->result()[0];
    $consulta = "select * from pregunta  where idcabencuesta = ". $url;
    $data['pregunta']=$this->db->query($consulta)->result();
    $this->load->view('encuesta/vencuestaUrl',$data);
 }
//------------------------------------------------------------------------------------------------
  function getUsersTest() {
    $test = $this->input->get('id');
    $data['idcabencuesta'] = $test;
    $data['personasFaltantes'] = $this->verencuestamodel->devolverPersonasFaltanesPorResponderEncuesta($test);
    $data['preguntas'] = $this->verencuestamodel->devolverPreguntasDeEncuesta($test);
    $data['titulo'] = $this->db->query("SELECT descripcion FROM cabencuesta WHERE idcabencuesta = '".$test."'")->row()->descripcion;
    echo json_encode($data);
  }

  function getQuestionsTest() {
    $data['idcalificaencuesta'] = $this->input->get('id');
    $data['preguntas'] = $this->db->query('SELECT * FROM encuesta WHERE idcabencuesta = '.$data['idcalificaencuesta'])->result();
    echo json_encode($data);
  }

  function getQuestionsTestByUser() {
    $data['idcalificaencuesta'] = $this->input->get('id');
    $sql = "idcalificaencuesta = ".$data['idcalificaencuesta'];
    $data['encuesta'] = $this->verencuestamodel->getQuestionsTest($sql);
    echo json_encode($data);
  }

  /*function getQuestionsForTest() {
    $test = $this->input->get('id');
    $sql = "idencuesta = ".$test;
    $data['encuestas'] = $this->verencuestamodel->getQuestionsTest($sql);
    $data['preguntas'] = $this->db->query('SELECT * FROM pregunta WHERE idcabencuesta = '.$test)->result();
    echo json_encode($data);
  }*/

  function getTestInfoComplete() { //Modificado [Suemy][2024-06-10]
    $month = $this->input->get('mt');
    $year = $this->input->get('yr');
    $typeT = $this->input->get('tp');
    $dateF = date('Y-m-d',strtotime($year.'-'.date('m').'-01'));
    $index = (date('m') < "10") ? explode('0',date('m'))[1] : date('m');
    $index = ($year < date('Y')) ? 12 : $index;
    $data['title'] = "Enero - ".ucfirst(strtolower($this->libreriav3->devolverMeses()[$index])).' ('.$year.')';
    $data['range'] = array("dateI" => $year.'-01-01', "dateF" => $this->superestrella_model->rangeMonth($dateF)['dateF'], "secondI" => strtotime($year.'-01-01'), "secondF" => strtotime($this->superestrella_model->rangeMonth($dateF)['dateF']));
    $info['con_c'] = "";
    if ($month != "todos") {
      $dateI = date('Y-m-d',strtotime($year.'-'.$month.'-01'));
      $data['title'] = ucfirst(strtolower($this->libreriav3->devolverMeses()[$month])).' ('.$year.')';
      $data['range'] = array("dateI" => $dateI, "dateF" => $this->superestrella_model->rangeMonth($dateI)['dateF'], "secondI" => strtotime($dateI), "secondF" => strtotime($this->superestrella_model->rangeMonth($dateI)['dateF']));
    }
    if ($typeT != "todos") {
      $info['con_c'] = ' AND tipo = '.$typeT;
    }
    $date = array("dateI" => $data['range']['secondI'], "dateF" => $data['range']['secondF']);
    $data['test'] = $this->verencuestamodel->getTest($info,$date);
    $data['data'] = array("month" => $month, "year" => $year);
    echo json_encode($data);
  }

  function getEncuestasComplete(){ // Modificado [2024-01-02]
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
             
             $idusu  =$this->input->get('em'); 
             $data['ban'] = $this->session->flashdata('bandera');
             $data['Pre']=array();
             $fecha =  $this->input->get('mt'); 
             $fecha= $fecha."-01";
             $ano= strtotime($fecha);
            $devano = date("Y", $ano);
            $devmes = date("m", $ano);
             $data['fecha']=$devmes;
           // $data['fecha']= $fecha;
             if($idusu == "COLABORADORES")
             {
                $data['Pre'] = $this->preguntamodel->TCalificacion('1',$devano,$devmes);         

                $data['usu'] = $this->preguntamodel->EnviaPregunta('1');               
             }
            if($idusu == "AGENTES")
             {
                $data['Pre'] = $this->preguntamodel->TCalificacion('3',$devano,$devmes);         
                $data['usu'] = $this->preguntamodel->EnviaPregunta('3');               
             }
             if($idusu == "CLIENTES")
             {
              $data['Pre'] = $this->preguntamodel->TCalificacion('2',$devano,$devmes);         
              $data['usu'] = $this->preguntamodel->EnviaPregunta('2');  
             } 
             $data['empleado'] = $idusu;
             $data['fecha'] = $fecha;
             $data['año'] = $devano;
             $data['mes'] = $devmes;


             //$data['quizes'] = $this->verencuestamodel->getTest($devano,$devmes); //Desactivado [Suemy][2024-06-10]



           echo json_encode($data);
        }
    }   


//---------------------------------------------------------------------------------------------
    function getSearchResultTest() { //Creado [Suemy][2024-05-27]
      $test = $this->input->get('ts');
      $person = $this->input->get('em');
      $month = $this->input->get('mt');
      $year = $this->input->get('yr');
      $sql = "";
      //Consult
      if ($test != "todos") {
        $sql = 'AND en.idcabencuesta = '.$test;
      }
      //Search
      if ($person == 1) {
        $employees = $this->verencuestamodel->getTestAnswered($month,$year,2,$sql);
        $agents = $this->verencuestamodel->getTestAnswered($month,$year,3,$sql);
        $clients = $this->verencuestamodel->getTestAnswered($month,$year,4,$sql);
        $result = array_merge($employees, $agents, $clients);
        //$data['result'] = array_multisort(array_column($result, 'fecha'), SORT_DESC, $result);
        $data['result'] = $result;
      }
      else {
        $data['result'] = $this->verencuestamodel->getTestAnswered($month,$year,$person,$sql);
      }

      $data['data'] = array("idEncuesta" => $test, "persona" => $person, "mes" => $month, "año" => $year, "sql" => $sql);
      echo json_encode($data);
    }

    /*function getInformationTestByMonth() { //Desactivado [Suemy][2024-06-10]
      $month = $this->input->get('mt');
      $year = $this->input->get('yr');
      $survey = array();
      $tests = array();
      $sent = $this->verencuestamodel->getTestAnswered($month,$year,1);
      foreach ($sent as $val) {
        if (in_array($val->idencuesta, $survey) != true) { array_push($survey, $val->idencuesta); }
      }
      foreach ($survey as $key => $val) {
        $info['con_c'] = ' AND idcabencuesta = '.$val;
        $info['con_d'] = ' AND MONTH(fechacontesta) = '.$month.' AND YEAR(fechacontesta) = '.$year;
        $consult = $this->verencuestamodel->getTest($info)[0];
        array_push($tests, $consult);
      }
      $sql = " AND YEAR(fecha)=".$year." AND MONTH(fecha)=".$month;
      $data['test_created'] = $this->verencuestamodel->getTest($sql);
      $data['test_sent'] = $tests;
      $data['data'] = array("mes" => $month, "año" => $year);
      echo json_encode($data);
    }*/
}
