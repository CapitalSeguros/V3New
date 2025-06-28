<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';

class asigna extends CI_Controller{

var $datos	= array(); //"";
        function __construct(){
        parent::__construct();     
        $this->CI =& get_instance();
         $this->load->model('preguntamodel');
         $this->load->model('PersonaModelo');
 
    }
    function index(){
    $data['Persona'] = $this->preguntamodel->EnviaPersona();  
    $data['Asig'] = $this->preguntamodel->EnviaPersona2('3');
    $data['contiene']  = 0;
    $data['cabEncuesta']  = $this->preguntamodel->CabEncuesta();
     $data['clasificacionUsuarios']=$this->PersonaModelo->clasificacionUsuariosParaEnvios(1);
    $this->load->view('asigna/asigna_00',$data);
      
}
 
   function VistaFiltro()
   {        
        if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
        else 
        {

          $TipoRespuesta  = $this->input->get('valor'); 
            $data['Persona'] = $this->preguntamodel->EnviaPersona2($TipoRespuesta);        
            $data['Asig']  = $this->preguntamodel->EnviaPersona2($TipoRespuesta);  
            $data['contiene']  = 0;
            $data['cabEncuesta']  = $this->preguntamodel->cabEncuesta();
          $this->load->view('asigna/asigna',$data);
        }
    }

//-----------------------------------------------------------
function GetPersonas() //Modificado [2024-01-17]
{
         $persona=array();  
         $array=array();          
         $TipoRespuesta  = $_POST['strvalor'];
         $test='';

         if(isset($_POST['test'])){$test = ' AND idencuesta = '.$_POST['test'];}
     if($_POST['strvalor']=='Clientes')
     {
      
       $persona1 = $this->preguntamodel->EnviaPersona2('4'); 
             foreach ($persona1 as $key => $value) 
          {  
            $query = $this->db->query("SELECT activa FROM calificaencuesta WHERE  idusuario = '".$value->idPersona."' AND cliente = 1 ".$test)->result();  

            $dat=array();     
                $dat['idPersona']=$value->idPersona;
                $dat['nombres']=$value->nombres;
                $dat['TIPO']=$value->TIPO;
                $dat['clasificacion']=$value->clasificacion;
                $dat['EMail1']=$value->EMail1;
                $dat['test'] = $query;


              array_push($persona, $dat) ;
              
            
          }
          //array_push($persona, $persona1) ;
     }
     else
     {
      if($_POST['strvalor']=='ORO' || $_POST['strvalor']=='BRONCE' || $_POST['strvalor']=='PLATINO VIP')
      {
        $array['grupos']=1;                      

        $persona1=$this->PersonaModelo->obtenerVendActivos($array);                       
        foreach ($persona1 as $key => $value) 
          {          
           foreach ($value['Data'] as $val) 
            { 
              $consulta="SELECT activa FROM calificaencuesta WHERE   idusuario = '".$val['idPersona']."'".$test;
              
              $query = $this->db->query($consulta)->result();
                    

              if($value['Name']==$_POST['strvalor'])
              {
               $val['clasificacion']=$value['Name'];
               $val['test'] = $query;
               array_push($persona, $val) ;
              }
            }
          }
          
      }
      else
      {
             $array['grupos']=1;           
             $persona1=$this->PersonaModelo->devolverColaboradoresActivos($array);
             
             foreach ($persona1 as $key => $value) 
             {          
               foreach ($value['Data'] as $val) 
               {
                $query = $this->db->query("SELECT activa FROM calificaencuesta WHERE   idusuario = '".$val['idPersona']."'".$test)->result();
                      
                if($value['Name']==$_POST['strvalor'])
              {
                $val['clasificacion']=$value['Name'];
                $val['test'] = $query;
                array_push($persona, $val) ;
               }
             }
             }
             
      }
     }

     echo json_encode($persona);
}
//-----------------------------------------------------------
   function GetUsuarios(){
        
        if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
        else 
        {
      
         $persona=array();  
         $array=array();                 
         $TipoRespuesta  = $_POST['strvalor']; 
          switch ($TipoRespuesta) {
            case '1':
             $array['grupos']=1;           
             $persona1=$this->PersonaModelo->devolverColaboradoresActivos($array);
             
             foreach ($persona1 as $key => $value) 
             {          
               foreach ($value['Data'] as $val) 
               {
                $val['clasificacion']=$value['Name'];
                array_push($persona, $val) ;
               }
             }
             
              
              break;
            case '2':
             $array['grupos']=1;

                      
             $persona1=$this->PersonaModelo->obtenerVendActivos($array);
                          
             foreach ($persona1 as $key => $value) 
             {          
               foreach ($value['Data'] as $val) 
               {
                $val['clasificacion']=$value['Name'];
                array_push($persona, $val) ;
               }
             }
              break;
            case '4':
             $persona = $this->preguntamodel->EnviaPersona2('4'); break;                          
            default:
              $agentes=array();
              $persona1=array();
              $persona2=array();
              $array['grupos']=1;
              $agentes=$this->PersonaModelo->obtenerVendActivos($array);
              foreach ($agentes as $key => $value) 
               {          
                 foreach ($value['Data'] as $val) 
                 {
                  $val['clasificacion']=$value['Name'];
                  array_push($persona1, $val) ;
                 }
               }
               $colaboradores=array();
               $array['grupos']=1;
               $colaboradores=$this->PersonaModelo->devolverColaboradoresActivos($array);
                foreach ($colaboradores as $key => $value) 
               {          
                 foreach ($value['Data'] as $val) 
                 {
                  $val['clasificacion']=$value['Name'];
                  array_push($persona2, $val) ;
                 }
               }
              $persona=array_merge($persona1,$persona2); 
              
              break;
          }
            echo json_encode($persona);
        }
    }
   

    function VistaAsigna(){
        
        if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
        else 
        {
            $TipoRespuesta  =strtoupper ($this->input->post('empleados')); 
            $data['Persona'] = $this->preguntamodel->EnviaPersona();          
            $data['Asig']  = $this->preguntamodel->DevuelveAsigna($TipoRespuesta); 
            $data['contiene']  = 0;
            $data['cabEncuesta']  = $this->preguntamodel->cabEncuesta();           
           $this->load->view('asigna/asigna',$data);

        }
    }
    function VistaAsigna1(){
        
        if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
        else 
        {
            $data['Persona'] = $this->preguntamodel->EnviaPersona();          
            $data['Asig']  = $this->preguntamodel->DevuelveAsigna(); 
            $data['contiene']  = 1;
            $data['cabEncuesta']  = $this->preguntamodel->cabEncuesta();
           $this->load->view('asigna/asigna',$data);
        }
    }  
   function GrabaCabEncuesta() // Modificado [2024-01-04]
   {               
    if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
        else 
        {
         $tabla = json_decode($_POST['array']);
         
         $usuario = strtoupper ($this->input->post('usuario'));        
         $cabEncuesta =  strtoupper ($this->input->post('cabEncuesta'));
         $clave = $this->preguntamodel->TClaveSecreta();
         $Fechadia =  date('Y-m-d');     
         if( $usuario == 4) {$cliente =1;}   
         else{$cliente =0;}
          
          $employee = array();

         foreach($tabla as $each)
          {
           
            $sqlcad= "select count(*) as total from calificaencuesta where idencuesta ='"
           .$cabEncuesta."' and idusuario = '".$each."' and cliente ='".$cliente."'";
            $query =$this->db->query($sqlcad)->result();
             
            foreach($query as $resultado)
            { 
              $resu = $resultado->total;
              $employee['resu'] = $resu;
            }
            
            if( $cliente == 0)
            {
              $sqlcad= "select coalesce(CONCAT(f.nombres,' ',f.apellidoPaterno,' ',f.apellidoMaterno),' ')as nombres
                   from persona f   where f.idPersona = '".$each."'";
              $query =$this->db->query($sqlcad)->result();
             foreach($query as $resultado){ $nombre = $resultado->nombres; $employee['nombre']=$nombre;}      
            }  
            else
            {
              $sqlcad= "select  nombrecompleto as nombres,EMail1 from clientelealtadpuntos
               where  (EMail1 <> '') and IDCli ='".$each."'";
              $query =$this->db->query($sqlcad)->result();
             foreach($query as $resultado)
             { 
              $nombre = $resultado->nombres;
               $email =   $resultado->EMail1;
                $employee['nombre']=$nombre;
                $employee['email']=$email;
             } 
            } 
            $data['status'] = "success";
            if($resu ==0)
            { 
            $data['status'] = "error";
             $sqlInsert_Referencia = "Insert Ignore Into `calificaencuesta` (`idencuesta`,`calificacion`,`usuario`,`idusuario`,`cliente`) Values('".$cabEncuesta."','0','".$nombre."','".$each."','".$cliente."');";   
                 $this->db->query($sqlInsert_Referencia);
                 $referencia = $this->db->insert_id();
                $sqlInsert_Referencia = "Update `calificaencuesta` set `cifrado` = '".md5($clave->clavesecreta.$referencia)."' where `idcalificaencuesta`='".$referencia."'
                                            ";
             $this->db->query($sqlInsert_Referencia);
             $employee['consulta1'] = $sqlInsert_Referencia;
                if( $usuario == 4)
                {
                   $sqlInsert_Referencia = "Insert Ignore Into `envio_correos` (`desde`,`para`,`copia`,`copiaOculta`,`asunto`,`mensaje`,`status`) Values ('Avisos de GAP<avisosgap@aserorescapital.com>','".$email."','0','0','Encuesta',
'haga click en el siguiente vinculo  https://capsys.com.mx/V3/EncuestaCliente/Encuesta?idenc=".md5($clave->clavesecreta.$referencia)."','0');";                         
                    $this->db->query($sqlInsert_Referencia);
                    $employee['consulta2'] = $sqlInsert_Referencia;
            
                }
                 $cabpersona = $this->preguntamodel->TPreguntas($cabEncuesta); 
                 $employee['cabencuesta'] = $cabEncuesta;
                foreach($cabpersona as $res)
                {
                    $sqlInsert_Referencia = "Insert Ignore Into `encuesta` (`idcabencuesta`,`tipo`,`pregunta`,`fecha`,`idusuario`,`respuestausuario`,`npsencuesta`) Values('".$referencia."','".$res->tipo."','".$res->pregunta."','".$Fechadia."','".$each."', '".$res->respuesta."','".$res->nps."');";  
                      $this->db->query($sqlInsert_Referencia); 
                      $employee['consulta3'] = $sqlInsert_Referencia;
                      $data['status'] = "success";             
                }
            }
            
         }
           // redirect('asigna/VistaAsigna');
         $data['employee'] = $employee;
         echo json_encode($data);
        } 

   }
    function GuardaAsigna(){               
        if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
        else 
        {
        	$res = strtoupper ($this->input->post('empleados'));
        	$idpersona = $this->preguntamodel->DevuelveUsuario($res);
        	$nombre = $idpersona->nombres;
        	$query = $this->preguntamodel->CompruebaAsigna($res);
			    $Fechadia =  date('Y-m-d');
          $conte =0; 
          $sqlInsert_Referencia = "Insert Ignore Into `asignaempleado` (`idempleado`,`empleado`,`contesto`,`fecha`) Values ('".$res."','".$nombre."','".$contes."','".$Fechadia."');";                         
                 $this->db->query($sqlInsert_Referencia);
                 $referencia = $this->db->insert_id();
                redirect('asigna/VistaAsigna');           
        }
    }
/***************************************************************** */
function grabaEncuestaextra()
  {
    $encuesta = $_POST['encuesta'];
    $idencuesta = $_POST['idencuesta'];
    $idusuario = $_POST['idusuario'];
    $clave = $this->preguntamodel->TClaveSecreta();
    $sqlInsert_Referencia = "Insert Ignore Into `calificaencuesta` (`idencuesta`,`calificacion`,`usuario`,`idusuario`,`cliente`) Values('".$idencuesta."','0','".$idusuario."','0','1');";   
    $this->db->query($sqlInsert_Referencia);
    $referencia = $this->db->insert_id();
    $sqlInsert_Referencia = "Update `calificaencuesta` set `cifrado` = '".md5($clave->clavesecreta.$referencia)."' where `idcalificaencuesta`='".$referencia."';                               ";
    $this->db->query($sqlInsert_Referencia);
    $sqlInsert_Referencia = "Insert Ignore Into `envio_correos` (`desde`,`para`,`copia`,`copiaOculta`,`asunto`,`mensaje`,`status`) Values ('Avisos de GAP<avisosgap@aserorescapital.com>','".$idusuario."','0','0','Encuesta ".$encuesta."',
    '<p>Conteste La Encuesta </p><br> <a style=\"background:green; color:white; padding: 5px 10px;\" href= \"https://capsys.com.mx/V3/EncuestaCliente/Encuesta?idenc=".md5($clave->clavesecreta.$referencia)."\">Encuesta</a>','0');";                         
                        $this->db->query($sqlInsert_Referencia);
                        $Fechadia =  date('Y-m-d');
    $cabpersona = $this->preguntamodel->TPreguntas($idencuesta); 
                        foreach($cabpersona as $res)
                        {
                            $sqlInsert_Referencia = "Insert Ignore Into `encuesta` (`idcabencuesta`,`tipo`,`pregunta`,`respuesta`,`fecha`,`idusuario`,`respuestausuario`,`npsencuesta`) Values('".$referencia."','".$res->tipo."','".$res->pregunta."','".$res->respuesta."','".$Fechadia."','0', '".$res->respuesta."','".$res->nps."');";  
                              $this->db->query($sqlInsert_Referencia);                
                        }                   
    echo json_encode($_POST);
  }
  /******************************************************* */
    function GrabaEncu()
    {          
      $datos =$_POST; 
      $keys = array_keys($datos);      
       $cont =0;  
       $califica=0;     
       $valores['id']=$keys;
      foreach (array_keys($_POST) as $row) 
      {
      
       if($row <> "idenc")                  # code...
        {
          $sqlInsert_Referencia = "Update `encuesta` set `respuesta` = '".$datos[$row]."' where `idencuesta`='".$row."'";
          $this->db->query($sqlInsert_Referencia);     
        }
        $cont=$cont+1;
       }
       $cont=$cont-1;
      foreach (array_keys($_POST) as $row) 
      {
         $sqlInsert_Referencia = "select * from encuesta where idencuesta = '".$row."'";
                                        
         $query = $this->db->query($sqlInsert_Referencia);
         $dat = $query->result();
         foreach ($dat as $seg) 
         {
          
          if($seg->respuestausuario == '1'){ $califica = $califica + $datos[$row]*(10/$cont);}
          else
          {            
            if($seg->respuestausuario ==  $datos[$row]){$califica = $califica+ (100/$cont);}              
          } 
         } 

      }               
      
      $sqlInsert_Referencia = "Update `calificaencuesta` set `activa` = 1,fechacontesta= current_date,`calificacion` = '".$califica."' where `idcalificaencuesta` like'".$datos['idenc']."'
                                            ";                  
       $this->db->query($sqlInsert_Referencia);
       $respues ="Se Ha Guardado Correctamente";
       echo json_encode($respues);
    }
//-----------------------------------------------------
function GrabaExtra()
{          
  $datos =$_POST; 
  $keys = array_keys($datos);      
   $cont =0;  
   $califica=0;     
   $valores['id']=$keys;
  foreach (array_keys($_POST) as $row) 
  {
  
   if($row <> "idenc")                  # code...
    {
      $sqlInsert_Referencia = "Update `encuesta` set `respuesta` = '".$datos[$row]."' where `idencuesta`='".$row."'";
      $this->db->query($sqlInsert_Referencia);        
    }
    $cont=$cont+1;
   }
   $cont=$cont-1;
  foreach (array_keys($_POST) as $row) 
  {
     $sqlInsert_Referencia = "select * from encuesta where idencuesta = '".$row."'";
                                    
     $query = $this->db->query($sqlInsert_Referencia);
     $dat = $query->result();
     foreach ($dat as $seg) 
     {
      
      if($seg->respuestausuario == '1'){ $califica = $califica + $datos[$row]*(10/$cont);}
      else
      {            
        if($seg->respuestausuario ==  $datos[$row]){$califica = $califica+ (100/$cont);}              
      } 
     } 

  }               
  
  $sqlInsert_Referencia = "Update `calificaencuesta` set `activa` = 1,fechacontesta= current_date,`calificacion` = '".$califica."' where `cifrado` like'".$datos['idenc']."'
                                        ";                  
   $this->db->query($sqlInsert_Referencia);   
   $respues ="Se Ha Guardado Correctamente";
   echo json_encode($respues);
}
//-----------------------------------------------------
    function Excel()
    {
      $nombre ="Reporte de Encuesta".date("Y-m-d H:i:s");
      $consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion 
               from calificaencuesta ca ,cabencuesta en 
               where ca.idencuesta = en.idcabencuesta and ca.activa = '1'";
      $datos=$this->db->query($consulta)->result();
      $this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Enctas Aplicadas');
        //ancho de las columnas
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        //valor de la celda
        $contador = 1;
      
        $this->excel->getActiveSheet()->getStyle('A1:E1')->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'FFFF00')
         )
         ) 
         );  
        
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("A{$contador}",'IDENCUESTA');
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'ENCUESTA');
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("C{$contador}",'EMPLEADO');
        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("D{$contador}",'CALIFICACION');
         foreach($datos as $che){
          $contador++;
           $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->idcalificaencuesta);           
           $this->excel->getActiveSheet()->setCellValue("B".$contador,$che->descripcion);
           $this->excel->getActiveSheet()->setCellValue("C".$contador, $che->usuario);
           $this->excel->getActiveSheet()->setCellValue("D".$contador, $che->calificacion);
        }
        $contador++;
        header("Content-Type: aplication/vnd.ms-excel ");
        $nombre ="Reporte".date("Y-m-d H:i:s");
        header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
        header("Cache-Control: max-age=0")        ;
        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        $writer->save("php://output");

    }
//------------------------------------
function buscaClienteParecido()
{
  $consulta='select * from clientelealtadpuntos where nombreCliente like "%'.$_POST['cliente'].'%" or NombreCompleto like "%'.$_POST['cliente'].'%"';
  $respuesta['clientes']=$this->db->query($consulta)->result();
  echo json_encode($respuesta);
}

//---------------------------------------------------------------------------------------------
  function getEmployeeDepartment() {
    $data=$this->PersonaModelo->clasificacionUsuariosParaEnvios(1);
    echo json_encode($data);
  }
//-----------------------------------------------------------
  function saveTest() {
    $test = $this->input->post('ts');
    $user = $this->input->post('us');
    $response = $this->input->post('rs');
    if (!empty($response)) {
      foreach ($response as $val) {
        $insert['idEncuesta'] = $test;
        $insert['idPregunta'] = $val->question;
        $insert['fecha'] = date('Y-m-d');
        $insert['idusuario'] = $user;
        $insert['respuestausuario'] = $val->answer;
        $data['result'] = $this->preguntamodel->guardarRespuesta($insert);
        $data['data'] = $insert;
      }
    }
    echo json_encode($data);
  }
//--------------------------------------------------------------------------------------------
}