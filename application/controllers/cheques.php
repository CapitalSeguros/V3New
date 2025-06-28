<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';

class cheques extends CI_Controller{

var $datos	= array(); //"";
        function __construct(){
        parent::__construct();     
        $this->CI =& get_instance();
        $this->load->model('chequesmodel');
        $this->load->model('catalogos_model');
        $this->load->model('contabilidadmodelo');        
        define('FORMAT_CURRENCY_PLN_1', '_-* #,##0.00\ [$zł-415]_-'); 

    }
//-----------------------------------------------------------
function index()
{
        if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
    $data['movimientos'] =  $this->capsysdre->TipoMovimiento();
    $data['bancos'] =  $this->capsysdre->ListaBancos();
    $data['concepto'] = $this->capsysdre->ListaConceptos();
    $data['Cheque'] = $this->capsysdre->ListaCheques();
    //$data['companias']= $this->catalogos_model->devolverCompanias();
    $data['companias']= $this->catalogos_model->devolverCompaniasPresupuesto();
    $this->load->view('cheques/cheques',$data);
      
}
//----------------------------------------------------------
  function VistaCheques(){
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
          $data['movimientos'] =  $this->capsysdre->TipoMovimiento();
          $data['bancos'] =  $this->capsysdre->ListaBancos();
          $data['concepto'] = $this->capsysdre->ListaConceptos();
          $data['Cheque'] = $this->capsysdre->ListaCheques();
          $data['companias']= $this->catalogos_model->devolverCompanias();
           $this->load->view('cheques/cheques',$data);
        }
    }
 //-----------------------------------------------------------
   function ReporteCheques()
   {
        
        if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
       $data['Cheque'] = $this->capsysdre->ListaCheques();
          $fecha =$this->input->post('fecha');
          $data['fec']= $fecha;  
          $data['consultaCheque'] = $this->chequesmodel->ConsulCheque($fecha);
           
          $this->load->view('cheques/ReporteCheques',$data);
      
    }  
//-----------------------------------------------------------    
    function eliminacheque(){

        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {

           // if($this->input->get('IDcheq',TRUE))
           // {
    
                $idche  = $this->input->post('elimina');
                 $sqlInsert_Referencia = "delete from `cheques` where `IDCHEQUE`='".$idche."'";

                         
            $this->db->query($sqlInsert_Referencia);
            $referencia = $this->db->insert_id();
               $data['movimientos'] =  $this->capsysdre->TipoMovimiento();
                $data['bancos'] =  $this->capsysdre->ListaBancos();
                $data['concepto'] = $this->capsysdre->ListaConceptos();
                $data['Cheque'] = $this->capsysdre->ListaCheques();
                $data['companias']= $this->catalogos_model->devolverCompanias();
                 redirect('cheques/VistaCheques');
            //}
        }
    } /*! editPros */
  //-----------------------------------------------------------
    function editcheque(){

        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {


    
                $idche  = $this->input->post('IDCheq');

                $data['detalleCheque'] = $this->capsysdre->EnviaCheque($idche); 
                $data['movimientos'] =  $this->capsysdre->TipoMovimiento();
                $data['bancos'] =  $this->capsysdre->ListaBancos();
                $data['concepto'] = $this->capsysdre->ListaConceptos();
                $data['Cheque'] = $this->capsysdre->ListaCheques();
                $data['companias']= $this->catalogos_model->devolverCompanias();            
                $this->load->view('cheques/EditaCheque', $data);
            //}
        }
    } 
    //-----------------------------------------------------------
    /*! editPros */
      function VistaConsultaCheques(){
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
         
           $this->load->view('cheques/ReporteCheques',$data);
        }
    }
    //-----------------------------------------------------------
    function ConsultaCheques(){

        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
                $fecha= $this->input->get('fecha');
                 $data['consultaCheque'] = $this->chequesmodel->ConsulCheque($fecha); 
                 $this->load->view('cheques/ReporteCheques',$data);       
        }
    } 
//-----------------------------------------------------------
function GuardaEditaCheque(){

        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
            $movimiento  = $this->input->post('tipo');
            $bancos  = $this->input->post('bancos');
            $idche  = $this->input->post('IDCheq');
            $fecha =$this->input->post('fecha');
            $concep   = strtoupper ($this->input->post('Concepto'));
            $tot  =strtoupper ($this->input->post('total'));
            $sqlInsert_Referencia = "
                        Update
                            `cheques` set
                                        `movimiento` = '".$movimiento."',
                                        `bancos` ='".$bancos."',
                                        `FECHA` ='".$fecha."',
                                        `concepto` ='".$concep."',
                                        `total` ='".$tot."'
                                    where
                                        `IDCHEQUE`='".$idche."'

                                            ";

                         
            $this->db->query($sqlInsert_Referencia);
            $referencia = $this->db->insert_id();
               $data['movimientos'] =  $this->capsysdre->TipoMovimiento();
                $data['bancos'] =  $this->capsysdre->ListaBancos();
                $data['concepto'] = $this->capsysdre->ListaConceptos();
                $data['Cheque'] = $this->capsysdre->ListaCheques();
                $data['companias']= $this->catalogos_model->devolverCompanias();
                 redirect('cheques/VistaCheques');
        }
    }
//-----------------------------------------------------------
 function GuardarCheque(){
        
        if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
        else 
        {
            $idpromo = $this->input->post('companias');
            $sqlBusquedaPromotora = "select Promotoria from catalog_promotorias where idPromotoria ='".$idpromo."'";
            $query = $this->db->query($sqlBusquedaPromotora);
            $variable1 = $query->row()->Promotoria;
            if($variable1==""){$variable1 ="nada";}
            $fecha = strtoupper ($this->input->post('fecha'));
            $movimiento  = strtoupper ($this->input->post('tipo'));
            $descripcion   = strtoupper ($this->input->post('bancos'));
            $concep   = strtoupper ($this->input->post('Concepto'));
            $tot  =strtoupper ($this->input->post('total'));
            $tipo =strtoupper ($this->input->post('TipoCargo'));
            $tipoInversion =strtoupper ($this->input->post('TipoCargoInversion'));
            $seguro = ($this->input->post('seguro'));
            $insert['IDCHEQUE']=-1;
            $insert['fecha']=$fecha;
            $insert['movimiento']=$movimiento;
            $insert['bancos']=$descripcion;
            $insert['concepto']=$concep;
            $insert['total']=$tot;
            $insert['tipo']=$tipo;
            $insert['idpromotoria']=$idpromo;
            $insert['idBanco']=$this->input->post('idBancosHidden');
            $insert['promotoria']=$variable1;
            $insert['seguro']=$seguro;
            $insert['idBancoDestino']=$this->input->post('idBancoDestinoHidden');
            $insert['bancoDestino']=$this->input->post('idBancoDestino');
            $insert['tipoInversion']=$tipoInversion;

             $this->chequesmodel->cheques($insert);
                $data['movimientos'] =  $this->capsysdre->TipoMovimiento();
                $data['bancos'] =  $this->capsysdre->ListaBancos();
                $data['concepto'] = $this->capsysdre->ListaConceptos();
                $data['Cheque'] = $this->capsysdre->ListaCheques();
                $data['companias']= $this->catalogos_model->devolverCompanias();
                 redirect('cheques/VistaCheques');
             
        }
    }
    /**************************************************************** */
    function excelDepositos()
    {
      $fecha  = $this->input->get('fecha');  
      $dat = explode("-", $fecha);  
      $fec=  $dat[0]."-".$dat[1]."-".$dat[2];
      $styleArray = array(
        'font' => array(
         'bold' => false, 
         'color' => array('rgb' => '000000'), 
         'size' => 8, 
         'name' => 'Arial' 
        ));
         $styletotal = array(
        'font' => array(
         'bold' => true, 
         'color' => array('rgb' => '000000'), 
         'size' => 8, 
         'name' => 'Arial' 
        )); 
        $this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Rpte Depositos');
        //ancho de las columnas
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $borders = array(
          'borders' => array(
          'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
           'color' => array('argb' => 'FF000000'),
          )
          ),
        ); 
        $this->excel->getActiveSheet()->getStyle('B2:G3')->applyFromArray($borders);    
        $contador = 2;
        $conta = $contador+1;
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'Reporte de Depositos');
        $this->excel->getActiveSheet()->mergeCells("B{$contador}:H{$contador}");
        $this->excel->getActiveSheet()->getStyle('B1:G3')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $contador ++;
        //CABECERAA
        $styleArray = [
          'font' => [
              'bold'  =>  false,
              'size'  =>  10,
              'name'  =>  'Franklin Gothic Book',
              'color' => array('rgb' => 'FFFFDF'),
          ],
          'alignment' => [
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
          ],
          'borders' => [
              'allBorders' => [
                  'borderStyle' => PHPExcel_Style_Border::BORDER_THIN,
                  'color' => ['rgb' => '000000']
              ]
              ],
          'fill' =>[
            'type'=>PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => '497E2D']
          ]   
      ];
      $this->excel->getActiveSheet()->getStyle('B3:G3')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle("B3")->getFont()->setBold(true);       
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'PROVEEDOR'); 
        $this->excel->getActiveSheet()->getStyle("C3")->getFont()->setBold(true);       
        $this->excel->getActiveSheet()->setCellValue("C{$contador}",'FECHA'); 
        $this->excel->getActiveSheet()->getStyle("D3")->getFont()->setBold(true);       
        $this->excel->getActiveSheet()->setCellValue("D{$contador}",'BANCOS'); 
        $this->excel->getActiveSheet()->getStyle("E3")->getFont()->setBold(true);       
        $this->excel->getActiveSheet()->setCellValue("E{$contador}",'TIPO'); 
        $this->excel->getActiveSheet()->getStyle("F3")->getFont()->setBold(true);       
        $this->excel->getActiveSheet()->setCellValue("F{$contador}",'SEGURO');
        $this->excel->getActiveSheet()->getStyle("G3")->getFont()->setBold(true);       
        $this->excel->getActiveSheet()->setCellValue("G{$contador}",'TOTAL');  
         //$this->excel->getActiveSheet()->getStyle("B4")->getFont()->setBold(true);       
        //$this->excel->getActiveSheet()->setCellValue("B4",'CUENTA No. 0154834054     BANCOMER'); 
        //CONUSLTA
        $consulta="select * from cheques where fecha =  '".$fec."'";
         $datos=$this->db->query($consulta)->result();
        //DETALLE
        $suma =0;
         foreach($datos as $row)
         {
          $contador ++;
          //Provedor
          $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);  
          $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);     
          $this->excel->getActiveSheet()->setCellValue("B{$contador}",$row->promotoria); 
          //Fecha
          $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);  
          $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);     
          $this->excel->getActiveSheet()->setCellValue("C{$contador}",$row->FECHA);
           //bANCOS
           $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);  
           $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);     
           $this->excel->getActiveSheet()->setCellValue("D{$contador}",$row->bancos);
           //TIPO
           $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);  
           $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);     
           $this->excel->getActiveSheet()->setCellValue("E{$contador}",$row->tipo);
            //seguro
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);  
            $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);     
            $this->excel->getActiveSheet()->setCellValue("F{$contador}",$row->seguro);
              //total
              $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);  
              $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
              $this->excel->getActiveSheet()->getStyle("G".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');    
              $this->excel->getActiveSheet()->setCellValue("G{$contador}",$row->total);
              $suma = $suma +$row->total;
         }
         $contador ++;
         $borders = array(
          'borders' => array(
          'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
           'color' => array('argb' => 'FF000000'),
          )
          ),
        ); 
        $this->excel->getActiveSheet()->getStyle("F{$contador}:G{$contador}")->applyFromArray($borders); 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);  
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);     
         $this->excel->getActiveSheet()->setCellValue("F{$contador}","TOTAL");
         $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);  
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);    
         $this->excel->getActiveSheet()->getStyle("G".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');     
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $suma);

        header("Content-Type: aplication/vnd.ms-excel ");
        $nombre ="RteDepositos" .$fec;
        header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
        header("Cache-Control: max-age=0")        ;
        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        file_put_contents('depuracion.txt', ob_get_contents());
        /* Limpiamos el búfer */
        ob_end_clean();
        $writer->save("php://output");  

    }
    /**************************************************************** */
function bancosDepositos()
{
$data=array();
//$data['companias']= $this->catalogos_model->devolverCompanias(); 
$data['companias']= $this->catalogos_model->devolverCompaniasPresupuesto();
if($this->input->get('fecha')=='')
{
  $userEmail=$this->tank_auth->get_usermail();
  /*============DIRECTORGENERAL@AGENTECAPITAL.COM;CCO@AGENTECAPITAL.COM;CONTABILIDAD@AGENTECAPITAL.COM;GERENTEOPERATIVO@AGENTECAPITAL.COM;ASISTENTEGENERAL@AGENTECAPITAL.COM;(NI SISTEMAS DEBE TENER PERMISO)*/
  if($userEmail=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $userEmail=='CCO@AGENTECAPITAL.COM' || $userEmail=='CONTABILIDAD@AGENTECAPITAL.COM' || $userEmail=='ASISTENTEGENERAL@AGENTECAPITAL.COM' || $userEmail=='GERENTEOPERATIVO@AGENTECAPITAL.COM' )
  {$this->load->view('cheques/reporteDepositos',$data);}
  else{redirect('');}
}
else
 {
  
   $fechaArray=explode('-',$_GET['fecha'] );
   
   $fecha=$_GET['fecha'];//'2021-09-29';
   $diaFecha=$fechaArray[2];//29;
   $mesFecha=$fechaArray[1];//9;
   $anioFecha=$fechaArray[0];//2021;
   $anioPasado=$anioFecha-1;
   //$fechaAnioPasado=$anioPasado.'-'.$
   foreach ($data['companias'] as  $value) 
   {
    $hoy=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum,(if(sum(total) is null,"",tipo)) as tipo  from cheques where idPromotoria='.$value->idPromotoria.' and FECHA="'.$fecha.'"')->result()[0];


    $mes=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum ,"" as tipo from cheques where idPromotoria='.$value->idPromotoria.' and month(FECHA)="'.$mesFecha.'" and year(FECHA)='.$anioFecha.' and day(FECHA)<='.$diaFecha)->result()[0];
    
    $anio=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum,"" as tipo  from cheques where idPromotoria='.$value->idPromotoria.' and FECHA<="'.$fecha.'" and year(FECHA)='.$anioFecha)->result()[0];

    $pasado=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum,"" as tipo  from cheques where idPromotoria='.$value->idPromotoria.' and year(FECHA)="'.$anioPasado.'"')->result()[0];

    $value->hoy=$hoy->sum;
    $value->mes=$mes->sum;
    $value->anio=$anio->sum;
    $value->anioPasado=$pasado->sum;
    $value->tipo=$hoy->tipo;
    //$value->tipo=
   }
    /*$bajaInversionHoy=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria=-2 and FECHA="'.$fecha.'"')->result()[0]->sum;
    
    $bajaInversionMes=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria=-2 and month(FECHA)="'.$mesFecha.'" and year(FECHA)='.$anioFecha.' and day(FECHA)<='.$diaFecha)->result()[0]->sum;


    $bajaInversionAnio=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria=-2 and FECHA<="'.$fecha.'" and year(FECHA)='.$anioFecha)->result()[0]->sum;

    $bajaInversionPasado=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria=-2 and year(FECHA)="'.$anioPasado.'"')->result()[0]->sum;*/
    $inversion=array();
    $inversion['idPromotoria']=52;#-2;
    $inversion['fecha']=$fecha;
    $bajaInversionHoy=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;
    $inversion['idPromotoria']=52;#-2;
    $inversion['mes']=$mesFecha;
    $inversion['anio']=$anioFecha;
    $inversion['dia']=$diaFecha;
    $bajaInversionMes=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;
    $inversion['idPromotoria']=52;#-2;
    $inversion['fecha']=$fecha;
    $inversion['anio']=$anioFecha;
    $bajaInversionAnio=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;    
    $inversion['idPromotoria']=52;#-2;
    $inversion['anio']=$anioPasado;
    $bajaInversionPasado=$this->contabilidadmodelo->inversionBajaAlta($inversion);
  
  

   $data['bajaInversionHoy']=$bajaInversionHoy;
   $data['bajaInversionMes']=$bajaInversionMes;
   $data['bajaInversionAnio']=$bajaInversionAnio;
   $data['bajaInversionPasado']=$bajaInversionPasado;

    /*$altaInversionHoy=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria=-1 and FECHA="'.$fecha.'"')->result()[0]->sum;
    $altaInversionMes=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria=-1 and month(FECHA)="'.$mesFecha.'" and year(FECHA)='.$anioFecha.' and day(FECHA)<='.$diaFecha)->result()[0]->sum;
    $altaInversionAnio=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria=-1 and FECHA<="'.$fecha.'" and year(FECHA)='.$anioFecha)->result()[0]->sum;
    $altaInversionPasado=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria=-1 and year(FECHA)="'.$anioPasado.'"')->result()[0]->sum;*/

    $inversion=null;
    $inversion['idPromotoria']=51;#-1;
    $inversion['fecha']=$fecha;
    $altaInversionHoy=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;
    $inversion['idPromotoria']=51;#-1;
    $inversion['mes']=$mesFecha;
    $inversion['anio']=$anioFecha;
    $inversion['dia']=$diaFecha;
    $altaInversionMes=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;
    $inversion['idPromotoria']=51;#-1;
    $inversion['fecha']=$fecha;
    $inversion['anio']=$anioFecha;
    $altaInversionAnio=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;    
    $inversion['idPromotoria']=51;#-1;
    $inversion['anio']=$anioPasado;
    $altaInversionPasado=$this->contabilidadmodelo->inversionBajaAlta($inversion);
   $data['altaInversionHoy']=$altaInversionHoy;
   $data['altaInversionMes']=$altaInversionMes;
   $data['altaInversionAnio']=$altaInversionAnio;
   $data['altaInversionPasado']=$altaInversionPasado;
 



   $inversion=null;
    $inversion['idPromotoria']=-3;
    $inversion['fecha']=$fecha;
    $interesPagadoHoy=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;
    $inversion['idPromotoria']=-3;
    $inversion['mes']=$mesFecha;
    $inversion['anio']=$anioFecha;
    $inversion['dia']=$diaFecha;
    $interesPagadoMes=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;
    $inversion['idPromotoria']=-3;
    $inversion['fecha']=$fecha;
    $inversion['anio']=$anioFecha;
    $interesPagadoAnio=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;    
    $inversion['idPromotoria']=-3;
    $inversion['anio']=$anioPasado;
    $interesPagadoPasado=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $data['interesPagadoHoy']=$interesPagadoHoy;
    $data['interesPagadoMes']=$interesPagadoMes;
    $data['interesPagadoAnio']=$interesPagadoAnio;
   $data['interesPagadoPasado']=$interesPagadoPasado;
 


    $inversion=null;
    $inversion['idPromotoria']=-4;
    $inversion['fecha']=$fecha;
    $retencionSRHoy=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;
    $inversion['idPromotoria']=-4;
    $inversion['mes']=$mesFecha;
    $inversion['anio']=$anioFecha;
    $inversion['dia']=$diaFecha;
    $retencionSRMes=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;
    $inversion['idPromotoria']=-4;
    $inversion['fecha']=$fecha;
    $inversion['anio']=$anioFecha;
    $retencionSRAnio=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $inversion=null;    
    $inversion['idPromotoria']=-4;
    $inversion['anio']=$anioPasado;
    $retencionSRPasado=$this->contabilidadmodelo->inversionBajaAlta($inversion);
    $data['retencionSRHoy']=$retencionSRHoy;
    $data['retencionSRMes']=$retencionSRMes;
    $data['retencionSRAnio']=$retencionSRAnio;
   $data['retencionSRPasado']=$retencionSRPasado;
 














   $filtroFacturas='';
  # $filtroFacturas=' and f.idCuentaContableInicial not in (1149) and f.posteriorapago!=3 and f.tipoGasto!=2';
    $filtroFacturas=' and f.idCuentaContable != 1149 and f.posteriorapago!=3 and f.tipoGasto!=2';

$consulFacHoy='select f.concepto,f.totalfactura,f.totalconiva,p.NombreProveedor from facturas f left join proveedores p on p.id=f.idProveedor where f.pagado=1 and  f.fecha_pago="'.$fecha.'" '.$filtroFacturas;

  
  $data['facturasHoyDocumentos']=$this->db->query($consulFacHoy)->result();
  
    $data['facturasMes']=$this->db->query('select (if(sum(totalconiva) is null,0,sum(totalconiva))) as sum from facturas f where pagado=1 and year(f.fecha_pago)='.$anioFecha.' and  month(f.fecha_pago)='.$mesFecha.' and day(f.fecha_pago)<='.$diaFecha.$filtroFacturas)->result()[0]->sum;
  
    $data['facturasAnio']=$this->db->query('select (if(sum(totalconiva) is null,0,sum(totalconiva))) as sum from facturas f where pagado=1 and  f.fecha_pago<="'.$fecha.'" and year(f.fecha_pago)='.$anioFecha.$filtroFacturas)->result()[0]->sum;

       
   $consultaMonto=$this->db->query('select (if(count(a.idACMI)=1,monto,0)) as monto from aperturacontablemontoincial a where tipo="I" and a.fecha="'.$_GET['fecha'].'"')->result()[0]->monto;
   
$consultaMontoBX=$this->db->query('select (if(count(a.idACMI)=1,monto,0)) as monto from aperturacontablemontoincial a where tipo="BX" and a.fecha="'.$_GET['fecha'].'"')->result()[0]->monto;
   
   $data['montoInicialAnioBX']=$consultaMontoBX;
   $data['montoInicialAnio']=$consultaMonto;
   $data['fecha']=$fecha;
   $data['dia']=$diaFecha;
   $data['mes']=$mesFecha;
   $data['anio']=$anioFecha;
   $data['anioPasado']=$anioPasado;
   echo json_encode($data);
 }

}
//-----------------------------------------------------------
function traePartidas()
{
  $respuesta['success']=true;
  
  $filtroID='';
  $filtroDia='';
  $filtroMes='';
  $filtroAnio='';
  
  if(isset($_GET['idPromotoria']))
  {   
    
    /*if($_GET['idPromotoria']>0){$filtroID=' and idPromotoria='.$_GET['idPromotoria'];}
    if(isset($_GET['dia'])){$filtroDia=' and day(FECHA)='.$_GET['dia']; }
    if(isset($_GET['mes'])){$filtroMes= ' and month(FECHA)='.$_GET['mes'];}
    if(isset($_GET['anio'])){$filtroAnio='year(FECHA)='.$_GET['anio'];}*/
    if($_GET['idPromotoria']>0){$filtro='idPromotoria='.$_GET['idPromotoria'];}
    if($_GET['busqueda']=='d'){$filtro.=' and FECHA="'.$_GET['anio'].'-'.$_GET['mes'].'-'.$_GET['dia'].'"';}
    if($_GET['busqueda']=='m'){$filtro.=' and year(FECHA)='.$_GET['anio'].' and month(FECHA)='.$_GET['mes'].' and day(FECHA)<='.$_GET['dia'];}
    if($_GET['busqueda']=='a'){$filtro.=' and FECHA<="'.$_GET['anio'].'-'.$_GET['mes'].'-'.$_GET['dia'].'" and year(FECHA)='.$_GET['anio'];}
   if($_GET['busqueda']=='ap'){$filtro.=' and year(FECHA)='.$_GET['anio'];}
    $consulta='select * from cheques where '.$filtro;
   
    $respuesta['datos']=$this->db->query($consulta)->result();
 
  }

  echo json_encode($respuesta);
}
//----------------------------------------------------------
function Excel()
    {
      $fecha2  = $this->input->get('fecha');  
      $nombre ="Reporte".date("Y-m-d H:i:s");
      $dat = explode("-", $fecha2);  
      $fec=  $dat[0]."-".$dat[1]."-01";
      $fec4= $dat[0]."-01-01";
      $fec2 =  (int)$dat[0]-1;
      $fec5 = (string)$fec2;
      $fec2=  $fec5."-01-01";
      $fec3=  $fec5."-12-31"; 
      $styleArray = array(
    'font' => array('bold' => false, 'color' => array('rgb' => '000000'), 'size' => 8, 'name' => 'Arial' ));
     $styletotal = array('font' => array('bold' => true, 'color' => array('rgb' => '000000'), 'size' => 8, 'name' => 'Arial' )); 

     $consulta="select B.promotoria as descripcionbancos,ch.FECHA,ch.movimiento ,ch.concepto,round(COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where ch1.FECHA = '".$fecha2."' AND ch1.idpromotoria = B.idPromotoria and ch.tipo ='DEPOSITO'),0.0),2) as total,COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where (ch1.FECHA >= '".$fec."' AND ch1.FECHA < '".$fecha2."') AND ch1.tipo ='DEPOSITO' AND  ch1.idpromotoria = B.idPromotoria),0.0) as ACUMES,round(COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where (ch1.FECHA >= '".$fec2."' AND ch1.FECHA < '".$fec4."') AND   ch1.idpromotoria = B.idPromotoria),0.0),2) as ACUMANOPASADO,round(COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where (ch1.FECHA >= '".$fec4."' AND ch1.FECHA < '".$fec."') AND   ch1.idpromotoria = B.idPromotoria),0.0),2) as ACUMMESAMES,ch.tipoFROM catalog_promotorias B left join cheques ch on  ch.idpromotoria = B.idPromotoria and ch.FECHA ='".$fecha2."' AND ch.tipo ='DEPOSITO' where B.idPromotoria NOT IN(51,52) group by descripcionbancos";
      $datos=$this->db->query($consulta)->result();
   
    
        $this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Rpte Drio bancos');
        //ancho de las columnas
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        //valor de la celda
        
       $borders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),)),); 
        $this->excel->getActiveSheet()->getStyle('B2:H4')->applyFromArray($borders);    
        $contador = 2;
        $conta = $contador+1;
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'GAP AGENTE DE SEGUROS Y DE FIANZAS');
        $this->excel->getActiveSheet()->mergeCells("B{$contador}:H{$contador}");
        $this->excel->getActiveSheet()->getStyle('B1:H3')->getAlignment()->applyFromArray(
         array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
       $contador ++; 
       $this->excel->getActiveSheet()->mergeCells("B{$contador}:H{$contador}");
       $this->excel->getActiveSheet()->getStyle("B{$contador}:H{$contador}")->getAlignment()->applyFromArray(
       array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
      
        $contador ++; 
       //$this->excel->getActiveSheet()->mergeCells("B{$contador}:H{$contador}");
       $this->excel->getActiveSheet()->mergeCells("B{$contador}:H{$contador}");
       $this->excel->getActiveSheet()->getStyle("B{$contador}:H{$contador}")->getAlignment()->applyFromArray(
       array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $this->excel->getActiveSheet()->mergeCells("B2:H4");
        $this->excel->getActiveSheet()->getStyle("B3")->getFont()->setBold(true);       
       $this->excel->getActiveSheet()->setCellValue("B3",'POSICION DIARIA DE BANCOS'); 
       $this->excel->getActiveSheet()->getStyle("B4")->getFont()->setBold(true);       
       $this->excel->getActiveSheet()->setCellValue("B4",'CUENTA No. 0154834054     BANCOMER'); 

       
       //$this->excel->getActiveSheet()->getStyle('B2:H4')->getAlignment()->applyFromArray(
       //array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $contador = $contador+2;
         $this->excel->getActiveSheet()->getStyle("B{$contador}:H{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'FFE5EB')
         )
         ) 
         );  
        $fec = substr($fecha2, 0, 10);
        $numeroDia = date('d', strtotime($fec));
        $dia = date('l', strtotime($fec));
        $mes = date('F', strtotime($fec));
        $anio = date('Y', strtotime($fec));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
       $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        $this->excel->getActiveSheet()->mergeCells("B{$contador}:H{$contador}");
        $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:H{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:H{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
          $this->excel->getActiveSheet()->setCellValue("B{$contador}",$nombredia.' '.$numeroDia.' de '.$nombreMes.' del '.$anio); 
       $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:H{$contador}")->getFont()->setSize(20);
       //DEPOSITOS
       $contador = $contador+4;
        $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'B8E5EB')
         )
         )
        ); 
       $this->excel->getActiveSheet()->mergeCells("B{$contador}:F{$contador}");
        $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:F{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:F{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
          $this->excel->getActiveSheet()->setCellValue("B{$contador}",'DEPOSITOS:'); 
       $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:F{$contador}")->getFont()->setSize(10);
       $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
       $borders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),)),); 
        $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray($borders);    
        
        //CONCEPTO
       $contador++;
       $this->excel->getActiveSheet()->mergeCells("B{$contador}:E{$contador}");
       $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:E{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
       $this->excel->getActiveSheet()->setCellValue("B{$contador}",'CONCEPTO:'); 
        $borders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),)),); 
        $this->excel->getActiveSheet()->getStyle("B{$contador}:E{$contador}")->applyFromArray($borders);
      
      //HOY  
       //$this->excel->getActiveSheet()->mergeCells("F{$contador}");
       $this->excel->setActiveSheetIndex(0)->getStyle("F{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("F{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
       $this->excel->getActiveSheet()->setCellValue("F{$contador}",'HOY'); 
        $borders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),)),); 
        $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($borders);

      //aCUMULADO DEL MES
        $this->excel->getActiveSheet()->getColumnDimension("G")->setWidth(12);  
        $this->excel->setActiveSheetIndex(0)->getStyle("G{$contador}")->getFont()->setSize(8);
        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getAlignment()->setWrapText(true);
       $this->excel->setActiveSheetIndex(0)->getStyle("G{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("G{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
       $this->excel->getActiveSheet()->setCellValue("G{$contador}",'ACUMULADO DEL MES'); 
        $borders = array(
        'borders' => array(
        'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN,
         'color' => array('argb' => 'FF000000'),
        )
        ),
      ); 
        $this->excel->getActiveSheet()->getStyle("G{$contador}")->applyFromArray($borders);
        $this->excel->getActiveSheet()->getStyle("G{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'C4BD97')
         )
         ) 
         );
        //aCUMULADO DEL MES
        $this->excel->setActiveSheetIndex(0)->getStyle("H{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("H{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
       $this->excel->getActiveSheet()->setCellValue("H{$contador}",'HOY'); 
        $borders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),)),); 
        $this->excel->getActiveSheet()->getStyle("H{$contador}")->applyFromArray($borders);

      //aCUMULADO DEL MES
        $this->excel->getActiveSheet()->getColumnDimension("H")->setWidth(12);  
        $this->excel->setActiveSheetIndex(0)->getStyle("H{$contador}")->getFont()->setSize(8);
        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getAlignment()->setWrapText(true);
       $this->excel->setActiveSheetIndex(0)->getStyle("H{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("H{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
       $this->excel->getActiveSheet()->setCellValue("H{$contador}",'ACUMULADO MES a MES'); 
        $borders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),)),); 
        $this->excel->getActiveSheet()->getStyle("H{$contador}")->applyFromArray($borders);
        $this->excel->getActiveSheet()->getStyle("H{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'E26B0A')
         )
         ) 
         );
       //aCUMULADO DEL ATES AÑO
        $this->excel->getActiveSheet()->getColumnDimension("I")->setWidth(12);  
        $this->excel->setActiveSheetIndex(0)->getStyle("I{$contador}")->getFont()->setSize(8);
        $this->excel->getActiveSheet()->getStyle("I{$contador}")->getAlignment()->setWrapText(true);
       $this->excel->setActiveSheetIndex(0)->getStyle("I{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("I{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
       $this->excel->getActiveSheet()->setCellValue("I{$contador}",'ACUMULADO '.($anio-1)); 
        $borders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),)),); 
        $this->excel->getActiveSheet()->getStyle("I{$contador}")->applyFromArray($borders);
        $this->excel->getActiveSheet()->getStyle("I{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => '92D050')
         )
         ) 
         );
     
        
        $sumtotal=0;$summes=0;$summesames=0;$sumano=0; 
         foreach($datos as $che)
         {
           //Incrementamos una fila más, para ir a la siguiente.
                        
             $contador++;
                $borders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),)),); 
            $this->excel->getActiveSheet()->getStyle("B{$contador}")->applyFromArray($borders);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->applyFromArray($borders);
            $this->excel->getActiveSheet()->getStyle("D{$contador}")->applyFromArray($borders);
            $this->excel->getActiveSheet()->getStyle("E{$contador}")->applyFromArray($borders);
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($borders);
            $this->excel->getActiveSheet()->getStyle("G{$contador}")->applyFromArray($borders);
            $this->excel->getActiveSheet()->getStyle("H{$contador}")->applyFromArray($borders);
            $this->excel->getActiveSheet()->getStyle("I{$contador}")->applyFromArray($borders);


             $bancos = $che->descripcionbancos;
             $fechas = $che->FECHA;           
           $this->excel->getActiveSheet()->setCellValue("B".$contador,$fechas);
           $this->excel->getActiveSheet()->setCellValue("C".$contador,$bancos);
           $this->excel->getActiveSheet()->setCellValue("D".$contador, $che->movimiento);
           $this->excel->getActiveSheet()->setCellValue("E".$contador, $che->concepto);
           $this->excel->getActiveSheet()->setCellValue("F".$contador, $che->total);
           $sumtotal = $sumtotal+$che->total;
           
           $this->excel->getActiveSheet()->setCellValue("G".$contador, $che->ACUMES);
           $summes=$summes +$che->ACUMES; 
           $this->excel->getActiveSheet()->setCellValue("H".$contador, $che->ACUMMESAMES);
           $summesames=$summesames+$che->ACUMMESAMES;
           $this->excel->getActiveSheet()->setCellValue("I".$contador, $che->ACUMANOPASADO);
           $sumano=$sumano+$che->ACUMANOPASADO;
            $this->excel->getActiveSheet()->getStyle("F{$contador}:I{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
            $this->excel->setActiveSheetIndex(0)->getStyle("F{$contador}:I{$contador}")->getFont()->setSize(8);
            $this->excel->getActiveSheet()->getStyle("F{$contador}:I{$contador}")->applyFromArray($styleArray); 
        }
         $contador++;
         
        $this->excel->getActiveSheet()->getStyle("B{$contador}:E{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'BFBFBF')
         )
         )
        ); 
       $this->excel->getActiveSheet()->mergeCells("B{$contador}:E{$contador}");
        $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:F{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:F{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
          $this->excel->getActiveSheet()->setCellValue("B{$contador}",'TOTAL DE INGRESOS X COMISIONES:'); 
       $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:F{$contador}")->getFont()->setSize(12);
       $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
       $borders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),)),); 
        $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray($borders);    
        
        /*$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("D{$contador}",'TOTAL DE INGRESOS X COMISIONES');*/
        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador, $sumtotal);
        $this->excel->getActiveSheet()->getStyle("G{$contador}")->applyFromArray($borders);  
        $this->excel->getActiveSheet()->getStyle("H{$contador}")->applyFromArray($borders);  
        $this->excel->getActiveSheet()->getStyle("I{$contador}")->applyFromArray($borders);  
       // $contador++;
        //aGREGAOS BAJA INVERSIO
         $consulta="select B.promotoria as descripcionbancos,ch.FECHA,ch.movimiento ,ch.concepto,round(COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where ch1.FECHA = '".$fecha2."' AND ch1.idpromotoria = B.idPromotoria),0.0),2) as total FROM catalog_promotorias B left join cheques ch on  ch.idpromotoria = B.idPromotoria and ch.FECHA ='".$fecha2."' where B.idPromotoria in(51,52) AND ch.tipo ='DEPOSITO'";
        $datos2=$this->db->query($consulta)->result();        
        foreach($datos2 as $che2){
           //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
             $bancos = $che2->descripcionbancos;
             $fechas = $che2->FECHA;           
             $this->excel->getActiveSheet()->setCellValue("B".$contador,$fechas);
             $this->excel->getActiveSheet()->setCellValue("C".$contador,$bancos);
             $this->excel->getActiveSheet()->setCellValue("D".$contador, $che2->movimiento);
             $this->excel->getActiveSheet()->setCellValue("E".$contador, $che2->concepto);
             $this->excel->getActiveSheet()->setCellValue("F".$contador, $che2->total);
             $sumtotal = $sumtotal+$che2->total;
             $this->excel->getActiveSheet()->getStyle("B{$contador}:I{$contador}")->applyFromArray($borders); 
        } 
        $contador++;
         $this->excel->getActiveSheet()->setCellValue("B{$contador}",'TOTAL DE DEPOSITOS');
         $this->excel->getActiveSheet()->getStyle("B{$contador}:E{$contador}")->applyFromArray($borders);  
         $this->excel->getActiveSheet()->mergeCells("B{$contador}:E{$contador}");
          $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'B8E5EB')
         )
         )
        );
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($borders); 
        $this->excel->getActiveSheet()->setCellValue("F".$contador,$sumtotal);
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
         $this->excel->getActiveSheet()->getStyle("G{$contador}")->applyFromArray($borders); 
        $this->excel->getActiveSheet()->setCellValue("G".$contador,$summes);
        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
         $this->excel->getActiveSheet()->getStyle("H{$contador}")->applyFromArray($borders); 
        $this->excel->getActiveSheet()->setCellValue("H".$contador,$summesames);
        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
         $this->excel->getActiveSheet()->getStyle("I{$contador}")->applyFromArray($borders); 
        $this->excel->getActiveSheet()->setCellValue("I".$contador,$sumano);
        $this->excel->getActiveSheet()->getStyle("I{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
        $this->excel->getActiveSheet()->getStyle("F{$contador}:I{$contador}")->applyFromArray($styletotal); 
         //TERMINA BAJA DE INVERSION
         //Cehques  y cargos 
        $contador++;
          $contador++;
         $this->excel->getActiveSheet()->setCellValue("B{$contador}",'CHEQUES y/0 CARGOS ');
         $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray($borders);  
         $this->excel->getActiveSheet()->mergeCells("B{$contador}:F{$contador}");
          $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'C4D79B')
         )
         )
        ); 
         $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:F{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:F{$contador}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
      
         $consulta="select B.promotoria as descripcionbancos,ch.FECHA,ch.movimiento ,ch.concepto, round(COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where  ch1.FECHA = '".$fecha2."' AND ch1.idpromotoria = B.idPromotoria),0.0),2) as total,COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where (ch1.FECHA >= '".$fec."' AND ch1.FECHA < '".$fecha2."') AND ch1.tipo ='DEPOSITO' AND ch1.idpromotoria = B.idPromotoria),0.0) as ACUMES,round(COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where (ch1.FECHA >= '".$fec2."' AND ch1.FECHA < '".$fec4."') AND   ch1.idpromotoria = B.idPromotoria),0.0),2) as ACUMANOPASADO,round(COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where (ch1.FECHA >= '".$fec4."' AND ch1.FECHA < '".$fec."') AND   ch1.idpromotoria = B.idPromotoria),0.0),2) as ACUMMESAMES,ch.tipo FROM  catalog_promotorias B join cheques ch on ch.idpromotoria = B.idPromotoria and ch.FECHA ='".$fecha2."' AND ch.tipo ='XCOMISION'   group by descripcionbancos";
         $datos1=$this->db->query($consulta)->result();
           $sumtotal1=0;
           foreach($datos1 as $che){
           //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
             $bancos = $che->descripcionbancos;
             $fechas = $che->FECHA;           
           $this->excel->getActiveSheet()->setCellValue("B".$contador,$fechas);
           $this->excel->getActiveSheet()->setCellValue("C".$contador,$bancos);
           $this->excel->getActiveSheet()->setCellValue("D".$contador, $che->movimiento);
           $this->excel->getActiveSheet()->setCellValue("E".$contador, $che->concepto);
           $this->excel->getActiveSheet()->setCellValue("F".$contador, $che->total);
            $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray($borders); 
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($styletotal); 
           $sumtotal1 = $sumtotal1+$che->total;
          
        } 
        //empieza alta inversion
             $consulta="select B.promotoria as descripcionbancos,ch.FECHA,ch.movimiento ,ch.concepto,round(COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where ch1.FECHA = '".$fecha2."' AND ch1.idpromotoria = B.idPromotoria),0.0),2) as total FROM catalog_promotorias B left join cheques ch on  ch.idpromotoria = B.idPromotoria and ch.FECHA ='".$fecha2."' where B.idPromotoria in(51,52) AND ch.tipo ='CARGO'";
        $datos3=$this->db->query($consulta)->result();
        $sumch=0; 
       foreach($datos3 as $che3){
           //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
             $bancos = $che3->descripcionbancos;
             $fechas = $che3->FECHA;    
                    
             $this->excel->getActiveSheet()->setCellValue("B".$contador,$fechas);
             $this->excel->getActiveSheet()->setCellValue("C".$contador,$bancos);
             $this->excel->getActiveSheet()->setCellValue("D".$contador, $che3->movimiento);
             $this->excel->getActiveSheet()->setCellValue("E".$contador, $che3->concepto);
             $this->excel->getActiveSheet()->setCellValue("F".$contador, $che3->total);
              $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray($borders); 
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($styletotal); 
             //$sumtotal = $sumtotal+$che3->total;
          $sumch = $sumch+$che3->total;
        } 
      //aGREGAMOS LAS FACTURAS DE GASTOS
      $consulta="select f.fecha_pago,f.concepto,p.NombreProveedor,'FACTURANORMAL',f.totalconiva from facturas f,proveedores p where p.id= f.idProveedor and f.posteriorapago = 1 and f.fecha_pago = '".$fecha2."' union select f.fecha_pago,f.concepto,p.NombreProveedor,'CAJA CHICA',f.totalconiva  from facturas f,proveedores p where p.id= f.idProveedor and f.posteriorapago = 2 and f.fecha_pago = '".$fecha2."'
       union
      select f.fecha_pago,'PAGO TARJETA','','TARJETA TOKAN',SUM(f.totalconiva)
      from facturas f
      where  f.posteriorapago = 3 and f.fecha_pago = '".$fecha2."' 
      UNION
      select f.fecha_pago,'PAGO TARJETA','','TARJETA AMEX',SUM(f.totalconiva)
      from facturas f
      where  f.posteriorapago = 4 and f.fecha_pago = '".$fecha2."' 
      UNION
      select f.fecha_pago,'NOMINA OTROS','','NOMINA',SUM(f.totalconiva)
      from facturas f
      where  f.posteriorapago = 5 and f.fecha_pago = '".$fecha2."' 
      UNION
      select f.fecha_pago,'POSTERIOR A PAGO','','FACTURA',SUM(f.totalconiva)
      from facturas f
      where  f.posteriorapago = 0 and f.fecha_pago = '".$fecha2."'";
      
      $datos3=$this->db->query($consulta)->result();
      foreach($datos3 as $che3){
        //Incrementamos una fila más, para ir a la siguiente.
       if($che3->totalconiva > 0)
       { 
          $contador++;
          if($che3->NombreProveedor == "")
            $bancos = $che3->FACTURANORMAL;
          else
          $bancos = $che3->NombreProveedor;
          $fechas = $che3->fecha_pago;    
                 
          $this->excel->getActiveSheet()->setCellValue("B".$contador,$fechas);
          $this->excel->getActiveSheet()->setCellValue("C".$contador,$bancos);
          $this->excel->getActiveSheet()->setCellValue("D".$contador,'transfer');
          $this->excel->getActiveSheet()->setCellValue("E".$contador, $che3->concepto);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, $che3->totalconiva);
           $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray($borders); 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($styletotal); 
          //$sumtotal = $sumtotal+$che3->total;
         $sumch = $sumch+$che3->totalconiva;
       }
     }  
      
      
        $contador++;
        // $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        //$this->excel->getActiveSheet()->setCellValue("C{$contador}",'TOTAL CHEQUES O CARGOS');    

         $this->excel->getActiveSheet()->setCellValue("B{$contador}",'TOTAL CHEQUES O CARGOS');
         $this->excel->getActiveSheet()->getStyle("B{$contador}:E{$contador}")->applyFromArray($borders);  
         $this->excel->getActiveSheet()->mergeCells("B{$contador}:E{$contador}");
          $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'C4D79B')
         )
         )
        ); 

        $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($borders);
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($styletotal); 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00');  
         $this->excel->setActiveSheetIndex(0)->getStyle("B{$contador}:F{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
     
          $this->excel->getActiveSheet()->setCellValue("F".$contador, $sumch+$sumtotal1) ;  
        
        $contador++;
         $contador++;
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'SALDO ACTUAL'); 
         $this->excel->getActiveSheet()->getStyle("B{$contador}:E{$contador}")->applyFromArray($borders);  
         $this->excel->getActiveSheet()->mergeCells("B{$contador}:E{$contador}");
          $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => '00B0F0')
         )
         )
        );  
        
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($styletotal); 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
         $this->excel->getActiveSheet()->setCellValue("F".$contador,$sumtotal- ($sumch+$sumtotal1)) ; 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($borders);
        $contador=$contador+2;
         $this->excel->getActiveSheet()->setCellValue("F".$contador, $summes) ;  
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'TOTAL INGRESO POR COMISIONES'); 
        
         $this->excel->getActiveSheet()->getStyle("B{$contador}:E{$contador}")->applyFromArray($borders);  
         $this->excel->getActiveSheet()->mergeCells("B{$contador}:E{$contador}");
          $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'FFFF00')
         )
         )
        );  
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($styletotal); 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
        // $this->excel->getActiveSheet()->setCellValue("F".$contador,$sumtotal- ($sumch+$sumtotal1)) ; 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($borders);
         $contador=$contador+2;
         $this->excel->getActiveSheet()->setCellValue("F".$contador, $sumch+$sumtotal1) ;  
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'TOTAL PAGO PROVEEDORES'); 
         $this->excel->getActiveSheet()->getStyle("B{$contador}:E{$contador}")->applyFromArray($borders);  
         $this->excel->getActiveSheet()->mergeCells("B{$contador}:E{$contador}");
          $this->excel->getActiveSheet()->getStyle("B{$contador}:F{$contador}")->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'FFC000')
         )
         )
        );  
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($styletotal); 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->getNumberFormat()->setFormatCode('$#,##0.00'); 
        // $this->excel->getActiveSheet()->setCellValue("F".$contador,$sumtotal- ($sumch+$sumtotal1)) ; 
         $this->excel->getActiveSheet()->getStyle("F{$contador}")->applyFromArray($borders); 
      
       
        header("Content-Type: aplication/vnd.ms-excel ");
        $nombre ="Reporte".date("Y-m-d H:i:s");
        header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
        header("Cache-Control: max-age=0")        ;
        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        file_put_contents('depuracion.txt', ob_get_contents());
        /* Limpiamos el búfer */
        ob_end_clean();
        $writer->save("php://output");
    }
/*********************************************** */
function promotoria()
{
	//$this->load->view('presupuestos/vpromotoria',$data);
  $data['companias']= $this->catalogos_model->devolverCompanias();  
	$this->load->view('presupuestos/vpromotoria',$data);
}
/*********************************************** */
function editaPromotor()
{
  $id= $this->input->post('IDCheq');
  $data['companias']= $this->catalogos_model->buscarCompaniaPorID($id);  
  $this->load->view('presupuestos/editaPromotoria',$data);
}
/*********************************************** */
function guardaPromotor()
{
  $id= $this->input->post('id');
  $nombre= $this->input->post('nombre');
  $telefono= $this->input->post('Telefono');
  $correo= $this->input->post('Correo');
  $asegurador= $this->input->post('Tipo');
  $status= $this->input->post('status');
  if($asegurador!='SEGURO' and $asegurador!='AFIANZADORA'){$asegurador='';}
  $consulta = "update catalog_promotorias set Promotoria = '".$nombre."', Telefono = '".$telefono."',Correo= '".$correo."',Tipo ='".$asegurador."',activoPresupuestos=".$status." where idPromotoria = '".$id."'";
  $this->db->query($consulta);
 
  $data['consulta']= $consulta;
  $data['companias']= $this->catalogos_model->devolverCompanias($id);  
  $this->load->view('presupuestos/vpromotoria',$data);
}
//--------------------------
function guardarMontoInicial()
{
  $respuesta['success']=true;
  $respuesta['mensaje']='EL MONTO INICIAL SE GUARDO CORRECTAMENTO';  
  $insert['tipo']='I'; 
  
  if(is_numeric($_GET['montoInicial']))
  {
     $actual = strtotime($_GET['fecha']);
    $siguienteDia = $_GET['fecha'];//;date("Y-m-d", strtotime("0 day", $actual));
    //$SD=explode(',', $siguienteDia);
    $delete='delete from aperturacontablemontoincial where fecha="'.$siguienteDia.'" and tipo="'.$_GET['tipo'].'"';

    $this->db->query($delete);
    $insert['monto']=(double)$_GET['montoInicial'];
    $insert['fecha']=$siguienteDia;
    if(isset($_GET['tipo'])){$insert['tipo']=$_GET['tipo'];$respuesta['mensaje']='EL MONTO INICIAL  SE GUARDO CORRECTAMENTE';}
        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($insert, TRUE));fclose($fp);
    $this->db->insert('aperturacontablemontoincial',$insert);
    $respuesta['fecha']=$siguienteDia;

    
  }
  else{$respuesta['mensaje']='EL MONTO INICIAL NO ES NUMERICO';$respuesta['success']=false;}
  echo json_encode($respuesta);
}



}//---

