<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';

class VerEncuesta extends CI_Controller{


        function __construct(){
        parent::__construct();     
        $this->CI =& get_instance();
        $this->load->model('VerEncuestaModel');
        $this->load->model('personamodelo');
        $this->load->model('email_model');
        $this->load->library("WhatsSMS");
        $this->load->library('excel');
        //$this->load->model('catalogos_model');        
        // $this->load->model('preguntamodel'); 
    }
    function index(){
   // $data['movimientos'] =  $this->capsysdre->TipoMovimiento();
    //$data['bancos'] =  $this->capsysdre->ListaBancos();
    //$data['concepto'] = $this->capsysdre->ListaConceptos();
    //$data['Cheque'] = $this->capsysdre->ListaCheques();
    //$data['companias']= $this->catalogos_model->devolverCompanias();
    //$this->load->view('EncuestaCliente/EncuestaCliente',$data);
    $data['cliente']=  $this->VerEncuestaModel->DevulveClientes('0');
        $data['clasificacionUsuarios']=$this->personamodelo->clasificacionUsuariosParaEnvios(1);
    $data['cliente']=  $this->VerEncuestaModel->DevulveClientes('0');
    $data['Activas']=  $this->VerEncuestaModel->DevulveEncuestas();
      $data['tipoPersona']='';  
    $this->load->view('encuesta/VerEncuesta_00',$data);
    
      
  }
/**************************************** */ 
function enviaCorreo()
{
  $idencuesta = $_POST['idencuesta'];
  $consulta = "select p.nombres,p.celPersonal as celOficina from calificaencuesta ca
  ,persona p where p.idPersona=ca.idusuario and ca.idencuesta = ".$idencuesta." and ca.activa=0 and p.celPersonal = ''";
 $datos = $this->db->query($consulta)->result();
  foreach($datos as $row)
  {
  
  $sqlenviaCorreo = "Insert Ignore Into
  `envio_correos`
     ( `fechaCreacion`, 
     `desde`,
     `para`, 
     `asunto`,
     `mensaje`, 
     `status`
      )
     Values
     (
      current_timestamp,
      'Avisos de GAP<avisosgap@aserorescapital.com>',
       'SISTEMAS@ASESORESCAPITAL.COM',  
       'Proyecto: ".$row->nombres."',
       'El Personal: ".$row->nombres." <br> No tiene Dado de Alta su numero de telefono ',
       '0'
     );
    ";
     $this->db->query($sqlenviaCorreo);
    }
  echo json_encode($idencuesta); 
 // echo json_encode($consulta); 
 // echo json_encode($idencuesta); 
}
/**************************************** */ 
function Excel1()
{
  
  

  $this->excel->setActiveSheetIndex(0);         
  $this->excel->getActiveSheet()->setTitle('test worksheet');         
  $this->excel->getActiveSheet()->setCellValue('A1', 'Un poco de texto');         
  $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);         
  $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);         
  $this->excel->getActiveSheet()->mergeCells('A1:D1');           

  header('Content-Type: application/vnd.ms-excel');         
  //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="nombredelfichero.xls"');
  header('Cache-Control: max-age=0'); //no cache         
  $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');       
  file_put_contents('depuracion.txt', ob_get_contents());
/* Limpiamos el búfer */
  ob_end_clean();  
// $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
  // Forzamos a la descarga         
  $objWriter->save('php://output');
}
/****** */
function devuelveEncuesta()
{
  $idencuesta = $_POST['idencuesta'];
  /*$valor = strtoupper ($this->input->post('empleados'));
                    # code...
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($valor, TRUE));fclose($fp); 
    $data['cliente']=  $this->VerEncuestaModel->DevulveClientes($valor);
 
  $this->load->view('encuesta/VerEncuesta',$data);
     */
    $consulta = "select * from calificaencuesta where activa =0 and idencuesta =".$idencuesta ;
    echo json_encode($this->db->query($consulta)->result());
}

/**************************************** */
function vEncuesta()
{
  $data['cliente']=  $this->VerEncuestaModel->DevulveClientes('0');
  $data['Activas']=  $this->VerEncuestaModel->DevulveEncuestas();
  $this->load->view('encuesta/VerEncuesta',$data);
}
/**************************************** */
function enviaMsg()
{
  $encuesta = $_POST['idmensaje'];
    $consulta = "select p.nombres,p.celPersonal as celOficina from calificaencuesta ca, persona p where p.idPersona=ca.idusuario and ca.idencuesta = ".$encuesta." and ca.activa=0 and p.celPersonal <> ''";
    $datos = $this->db->query($consulta)->result();
  $respuesta=[];
  $i=0;
  foreach($datos as $row)
  {
   $envio = array(
      'numbers' =>$row->celOficina,
      'message' =>'Tienes una encuesta pendiente por contestar'
     );
  $valor =  $this->whatssms->enviarSMS($envio);
  if($valor == 0)
  {
    $repuesta[$i]=$row->nombres;
    $i++;
   }
  }
  $data['test'] = $encuesta;
  $data['result'] = $datos;
  $data['send'] = $envio;
  $data['status'] = $valor;
  $data['response'] = $respuesta;
  //echo json_encode($consulta );
  echo json_encode($respuesta);
  /*$encuesta = $this->input->post('idencuesta');
  $data['cliente']=  $this->VerEncuestaModel->DevulveClientes('0');
  $data['Activas']=  $this->VerEncuestaModel->DevulveEncuestas();
  $data['encu']=  $encuesta ;
  $this->load->view('encuesta/vEncuesta',$data);
 // redirect('/reportes/muestraEncuesta/');*/
 //echo json_encode($encuesta);
}

/**************************************** */ 
  
  function MuestraEncuesta() //Modificado [2024-01-04]
  {
      $value = strtoupper ($this->input->post('empleados'));
                      # code...
     //   $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($valor, TRUE));fclose($fp); 
     // $data['cliente']=  $this->VerEncuestaModel->encuestasActivas($valor);
      $data['consult'] =  $this->VerEncuestaModel->encuestasActivas($value);
      //$data['consult'] = $this->VerEncuestaModel->DevulveEncuestas(); //Muestra todos los datos juntos
    //$this->load->view('encuesta/VerEncuesta_00',$data);
      echo json_encode($data);
             
  }
/**** */

   function Excel()
    {
      //$valor = strtoupper ($this->input->post('empleados'));
      // if($this->input->get('IDcheq',TRUE))
        //    {
    
      $idche  = $this->input->get('valor');
            
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($idche, TRUE));fclose($fp); 
      //$datos=  $this->VerEncuestaModel->DevulveClientes($idche);
      $datos=  $this->VerEncuestaModel->encuestasinResponder($idche);
      $nombre ="Reporte De Personas Faltantes".date("Y-m-d H:i:s");
      $this->load->library('excel');
     // $this->excel->setActiveSheetIndex(0);
      $this->excel->getActiveSheet()->setTitle('Enctas Pendientes');
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
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'Clientes');
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("C{$contador}",'Encuesta');
        foreach($datos as $che){
           //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
            // $bancos = $che->descripcionbancos;
            // $fechas = $che->FECHA;           
           $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->idcalificaencuesta);
           
           //$this->excel->getActiveSheet()->setCellValue("B".$contador,$che->descripcion);
           $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("B".$contador, $che->usuario);
           $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("C".$contador, $che->descripcion);
           //$this->excel->getActiveSheet()->setCellValue("D".$contador, $che->calificacion);
        }
        $contador++;
        header("Content-Type: aplication/vnd.ms-excel ");
        $nombre ="Reporte".date("Y-m-d H:i:s");
        header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
        header("Cache-Control: max-age=0")        ;
        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        file_put_contents('depuracion.txt', ob_get_contents());
        /* Limpiamos el b�fer */
        ob_end_clean();
        $writer->save("php://output");

    }
 function ExcelDetractores()
    {
      //$valor = strtoupper ($this->input->post('empleados'));
      // if($this->input->get('IDcheq',TRUE))
        //    {
    
      $idche  = $this->input->get('valor');
    
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($idche, TRUE));fclose($fp); 
      $datos=  $this->VerEncuestaModel->DevulveDtractores($idche);
      $nombre ="NPS Detractores".date("Y-m-d H:i:s");
      $this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
      $this->excel->getActiveSheet()->setTitle('Detractores');
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
         array('rgb' => '2E64FE')
         )
         ) 
         );  
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("A{$contador}",'IDENCUESTA');
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'Clientes');
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("C{$contador}",'Calificacion');
        
        foreach($datos as $che){
           //Incrementamos una fila m�s, para ir a la siguiente.
             $contador++;
            // $bancos = $che->descripcionbancos;
            // $fechas = $che->FECHA;           
           $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->idcalificaencuesta);
           
           //$this->excel->getActiveSheet()->setCellValue("B".$contador,$che->descripcion);
           $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("B".$contador, $che->usuario);
           //$this->excel->getActiveSheet()->setCellValue("D".$contador, $che->calificacion);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("C".$contador, $che->calificacion);
          
    }
        $contador++;
        header("Content-Type: aplication/vnd.ms-excel ");
        $nombre ="Reporte".date("Y-m-d H:i:s");
        header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
        header("Cache-Control: max-age=0")        ;
        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        $writer->save("php://output");

    }
    function ExcelPasivos()
    {
      //$valor = strtoupper ($this->input->post('empleados'));
      // if($this->input->get('IDcheq',TRUE))
        //    {
    
      $idche  = $this->input->get('valor');
            
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($idche, TRUE));fclose($fp); 
      $datos=  $this->VerEncuestaModel->DevulvePasivos($idche);
      $nombre ="NPS Detractores".date("Y-m-d H:i:s");
      $this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
      $this->excel->getActiveSheet()->setTitle('Detractores');
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
         array('rgb' => 'FF4000')
         )
         ) 
         );  
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("A{$contador}",'IDENCUESTA');
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'Clientes');
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("C{$contador}",'Calificacion');
        
        foreach($datos as $che){
           //Incrementamos una fila m�s, para ir a la siguiente.
             $contador++;
            // $bancos = $che->descripcionbancos;
            // $fechas = $che->FECHA;           
           $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->idcalificaencuesta);
           
           //$this->excel->getActiveSheet()->setCellValue("B".$contador,$che->descripcion);
           $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("B".$contador, $che->usuario);
           //$this->excel->getActiveSheet()->setCellValue("D".$contador, $che->calificacion);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("C".$contador, $che->calificacion);
          
    }
        $contador++;
        header("Content-Type: aplication/vnd.ms-excel ");
        $nombre ="Reporte".date("Y-m-d H:i:s");
        header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
        header("Cache-Control: max-age=0")        ;
        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        $writer->save("php://output");

    }
   function ExcelPromotores()
  {
      //$valor = strtoupper ($this->input->post('empleados'));
      // if($this->input->get('IDcheq',TRUE))
        //    {
     
      $idche  = $this->input->get('valor');
      
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($idche, TRUE));fclose($fp); 
      $datos=  $this->VerEncuestaModel->DevulvePromotores($idche);
      $nombre ="NPS Detractores".date("Y-m-d H:i:s");
      $this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
      $this->excel->getActiveSheet()->setTitle('Detractores');
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
         array('rgb' => 'FFBF00')
         )
         ) 
         );  
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("A{$contador}",'IDENCUESTA');
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'Clientes');
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("C{$contador}",'Calificacion');
  
        foreach($datos as $che){
           //Incrementamos una fila m�s, para ir a la siguiente.
             $contador++;
            // $bancos = $che->descripcionbancos;
            // $fechas = $che->FECHA;           
           $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->idcalificaencuesta);
           
           //$this->excel->getActiveSheet()->setCellValue("B".$contador,$che->descripcion);
           $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("B".$contador, $che->usuario);
           //$this->excel->getActiveSheet()->setCellValue("D".$contador, $che->calificacion);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("C".$contador, $che->calificacion);
   
      }
        $contador++;
        header("Content-Type: aplication/vnd.ms-excel ");
        $nombre ="Reporte".date("Y-m-d H:i:s");
        header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
        header("Cache-Control: max-age=0")        ;
        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        $writer->save("php://output");

      }

//---------------------------------------------------------------------------------------------------
  function getInfoEmployeeTestActive() {
    $test = $this->input->get('ts');
    $value = $this->input->get('vl');
    if ($value == "COLABORADORES") {
      $data['result'] = $this->VerEncuestaModel->getDataEmployeeTest($test,1);
    }
    else if ($value == "AGENTES") {
      $data['result'] = $this->VerEncuestaModel->getDataEmployeeTest($test,3);
    }
    else if ($value == "CLIENTES") {
      $data['result'] = $this->VerEncuestaModel->getDataClientTest($test);
    }
    $data['test'] = $test;
    $data['employee'] = $value;
    echo json_encode($data);
  }

  function getMessagesEmployeeSendReady() {
    $type = $this->input->get('em');
    $result['email'] = $this->VerEncuestaModel->getMessagesEmailTest();
    $result['msg'] = $this->VerEncuestaModel->getMessagesMsgTest();
    $result['emailC'] = $this->VerEncuestaModel->getMessagesEmailTestClient();
    $result['msgC'] = $this->VerEncuestaModel->getMessagesMsgTestClient();
    $data = array_merge($result['email'],$result['msg'],$result['emailC'],$result['msgC']);
    echo json_encode($data);
  }

  function enviarEncuestaCorreo() {
    $id_test = $this->input->get('id');
    $employee = $this->input->get('em');
    $type = $this->input->get('tp');
    $title = $this->db->query("SELECT descripcion FROM cabencuesta WHERE idcabencuesta = '".$id_test."'")->row()->descripcion;
    $info = array(
      "title" => "RECORDATORIO",
      "message" => "Tu opinion es importante para nosotros, ayudanos a mejorar respondiendo a la encuesta <strong>".$title."</strong>. Puedes realizarlo ingresando al V3Plus.",
      "url" => "https://capsys.com.mx/V3/auth/login"
    );
    $message = $this->load->view('email/alert',$info,TRUE);
    //$messageC = "Ay�danos a mejorar con tu opini�n repondiendo a la encuesta ".$title.". ingresando en el V3Plus. Tu ";
    $result = array();
    //
    foreach ($employee as $val) {
      $send['employee'] = $val;
      if ($type != "CLIENTES") {
        $send['email'] = $this->db->query("SELECT email FROM users WHERE idPersona = '".$val."'")->row()->email;
      }
      else {
        $send['email'] = $this->db->query("SELECT EMail1 FROM clientelealtadpuntos WHERE IDCli = '".$val."'")->row()->EMail1;
      }
      $send['data'] = array(
        "desde" => "Avisos de GAP<avisosgap@aserorescpital.com>",
        "para" => $send['email'],
        "asunto" => "Recordatorio",
        "mensaje" => $message,
        "status" => 0,
        "fechaEnvio" => date("Y-m-d H:i:s")
      );
      $send['result'] = $this->email_model->SendEmail($send['data']);
      array_push($result, $send);
    }
      $data['employees_send'] = $employee;
      $data['test'] = $id_test;
      $data['title'] = $title;
      $data['result'] = $result;
      echo json_encode($data);
  }

  function getInfoTest() {
    $data['colaboradores'] = $this->VerEncuestaModel->encuestasActivas("COLABORADORES");
    $data['agentes'] = $this->VerEncuestaModel->encuestasActivas("AGENTES");
    $data['clientes'] = $this->VerEncuestaModel->encuestasActivas("CLIENTES");
    $data['encuestas'] = $this->db->query('select * from cabencuesta where activa = 0')->result();
    echo json_encode($data);
  }
//---------------------------------------------------------------------------------------------------------
} 