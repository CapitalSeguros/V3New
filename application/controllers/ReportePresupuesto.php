<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';

class ReportePresupuesto extends CI_Controller{

var $datos	= array(); //"";
        function __construct(){
        parent::__construct();     
        $this->CI =& get_instance();
        $this->load->model('chequesmodel');
        $this->load->model('catalogos_model');
        $this->load->model('ReportePresupuestoModel');
        $this->load->library('libreriav3'); 

    }
//-----------------------------------------------------------------------------------
function index(){    
    $data['ListaProveedores']= $this->capsysdre->ListaProveedores();
    $this->load->view('presupuestos/ReportePresupuesto',$data);

      
}
//-------------------------------------------------------
function reporteProveedor()
{
   $idgasto = $_POST['action'];
  // $fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($idgasto));fclose($fp);
    $sqlInsert_Referencia = "select pr.NombreProveedor,fa.folio_factura,fa.totalfactura,fa.fecha_factura ,if(fa.pagado=1,'PAGADO','PENDIENTE') AS PAGO     from facturas fa, proveedores pr     
 where pr.id ='".$idgasto."'";
      $datos=$this->db->query($sqlInsert_Referencia)->result(); 
      echo json_encode($datos,JSON_UNESCAPED_UNICODE);
     exit;
}
//-------------------------------------------------------
function reporteDiariaBco()
{
  $idgasto = $_POST['action'];//strtoupper ($this->input->post('Idtipodegasto'));
   $sqlInsert_Referencia = "select sum(if(ch.tipo ='XCOMISION',ch.total,0.00)) as deposito,
   sum(if(ch.tipo ='DEPOSITO',ch.total,0.00)) AS cheques
  from cheques ch ,catalog_promotorias B where
  ch.idpromotoria = B.idPromotoria and
 ch.FECHA ='".$idgasto."' and B.idPromotoria NOT IN(51,52)
 union
 select sum(if(ch.tipo ='CARGO',ch.total,0.00)) as deposito,
   sum(if(ch.tipo ='DEPOSITO',ch.total,0.00)) AS cheques
  from cheques ch ,catalog_promotorias B where
  ch.idpromotoria = B.idPromotoria and
 ch.FECHA ='".$idgasto."' and B.idPromotoria  IN(51,52)";
     $datos=$this->db->query($sqlInsert_Referencia)->result();                   
      // $data =mysqli_fetch_assoc($datos);
      //$data = mysqli_fetch_array($datos);      
     //$data = $datos;

     //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datos));fclose($fp);
     echo json_encode($datos,JSON_UNESCAPED_UNICODE);
     exit;
 
}
//-------------------------------------------------------
function reportebarras()
{
 $ano = $this->input->post('anodepo');
 $data['Asig']  = $this->ReportePresupuestoModel->DevuelveDeposito($ano);  
 if(isset($_POST['ajax'])){echo json_encode($data);}
 else{$this->load->view('presupuestos/reportebarras',$data);}

}
//-------------------------------------------------------
function reportecanal()
{
 $ano = $this->input->post('anocanal');
 $data['Asig']  = $this->ReportePresupuestoModel->DevuelveCanales($ano);
 if(isset($_POST['ajax'])){echo json_encode($data);}
 else{$this->load->view('presupuestos/reportecanal',$data);}
}
//-------------------------------------------------------
function reportexdeposito()
{
 
 $ano = $this->input->post('anodeposito');
 $mes = $this->input->post('mesdeposito');
 $tipo = $this->input->post('tipodeposito');
 $data['Asig']  = $this->ReportePresupuestoModel->DevuelveRepDepositosxmes($ano,$mes,$tipo);
 //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data['Asig'], TRUE));fclose($fp); 
  if(isset($_POST['ajax'])){echo json_encode($data);}
 else{$this->load->view('presupuestos/reportecanal',$data);}
 
}
//-------------------------------------------------------------
function reportelinealuno()
{

 $anouno = $this->input->post('anodepuno');
 $anodos = $this->input->post('anodepdos');
   
 $aDias = array();
 $valores =array();
 //$j=0;$k=0;
 for ($i = $anouno; $i <= $anodos; ++$i){
   array_push( $aDias, $i );  
    $gastos=  $this->ReportePresupuestoModel->DevuelveGstosLineal($i);
    foreach($gastos as $che)
        {
         
              $valores[$i][$che->ano]= $che->total;
           
          
        } 
  }
  $data['ano']=$aDias;
  $data['valor']=$valores;
 
  if(isset($_POST['ajax'])){echo json_encode($data);}
 else{$this->load->view('presupuestos/reportelinealuno',$data);}

 
}
//--------------------------------------------------
function reportelinealdos()
{
  
 $anouno = $this->input->post('anogasuno');
 $anodos = $this->input->post('anogasdos');  
 $aDias = array();
 $valores =array();
 
 for ($i = $anouno; $i <= $anodos; ++$i)
 {
   array_push( $aDias, $i );  
    $gastos=  $this->ReportePresupuestoModel->DevuelveDepoLineal($i);
    foreach($gastos as $che){$valores[$i][$che->ano]= $che->total;} 
  }
  $data['ano']=$aDias;
  $data['valor']=$valores;
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($_POST, TRUE));fclose($fp); 
  if(isset($_POST['ajax'])){echo json_encode($data);}
 else{$this->load->view('presupuestos/reportelinealdos',$data);}

 
 
}
function devuelveAnoContable()
{
 $ano = $_POST['ano'];
 $consulta ="select idAperturaContable from aperturacontable where anioAC=".$ano;
 $apertura = $this->db->query($consulta)->result();
 echo json_encode($apertura[0]->idAperturaContable);
}
/********************************* */
function devuelveCuentasContables()
{
  $ano = $_POST['ano'];
  $mes = $_POST['mes'];
  $id = $_POST['apertura'];
  $consulta ="select sum(f.montofianzas) as fianzas,sum(f.montoinstitucional) as intitucional,sum(f.gestion) as gestion,
  sum(f.corporativo) as coorporativo,sum(f.totalfactura) as total,
  pd.personaDepartamento as contabilidad,coalesce((select montoMes from aperturacontablemontomes acm where acm.idAperturaContable= '".$id."' and
  acm.idMes =1 and acm.idPersonaDepartamento= rcc.idPersonaDepartamento )) as monto,pd.idPersonaDepartamento as id
  from facturas f,relcuentacontabledepartamento rcc , personadepartamento pd where
  cast(f.fecha_pago as date) between '".$ano."-".$mes."-01' and '".$ano."-".$mes."-31' and  rcc.idCuentaContable = f.idCuentaContable and rcc.idPersonaDepartamento = pd.idPersonaDepartamento
  group by pd.personaDepartamento"; 
  $envia = $this->db->query($consulta)->result();
  echo json_encode($envia);
  
}
/******************************** */
function devuelvedetalleContables()
{
  $ano = $_POST['ano'];
  $mes = $_POST['mes'];
  $apertura = $_POST['apertura'];
  $id = $_POST['id'];
  $consulta ="select  f.folio_factura,(f.montofianzas) as fianzas,(f.montoinstitucional) as intitucional,(f.gestion) as gestion,
  (f.corporativo) as coorporativo,(f.totalfactura) as total,
  pd.personaDepartamento as contabilidad,coalesce((select montoMes from aperturacontablemontomes acm where acm.idAperturaContable= '".$id."' and
  acm.idMes =1 and acm.idPersonaDepartamento= rcc.idPersonaDepartamento )) as monto,pd.idPersonaDepartamento as id,rccd.cuentaContable
  from facturas f,relcuentacontabledepartamento rcc , personadepartamento pd, relcuentacontabledepartamento rccd  where  rccd.idCuentaContable = f.idCuentaContable and
  cast(f.fecha_pago as date) between '".$ano."-".$mes."-01' and '".$ano."-".$mes."-31' and  rcc.idCuentaContable = f.idCuentaContable and rcc.idPersonaDepartamento = pd.idPersonaDepartamento
  and pd.idPersonaDepartamento =".$id; 
  $envia = $this->db->query($consulta)->result();
  echo json_encode($envia);
}
/******************************** */
function exportaGastos()
{
  //echo json_encode($_POST);
  $fecha1 = $this->input->post('fechagastos1');
  $fecha2 = $this->input->post('fechagastos2');
  $nombre ="Reporte De Gastos".$fecha1;
  
      $this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
      $this->excel->getActiveSheet()->setTitle('Gastos'.$fecha1.' al '.$fecha2);
      $contador = 1;
      $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth(25);
      //$this->excel->getActiveSheet()->getStyle("A".$contador)->applyFromArray($styleArray);
      $this->excel->getActiveSheet()->setCellValue("A".$contador,"Gastos Especiales del ".$fecha1.' al '.$fecha2 );
      $contador=$contador+2;
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
          'color' => ['rgb' => '2E549F']
        ]   
    ];
    $this->excel->getActiveSheet()->getStyle('A'.$contador.':F'.$contador)->applyFromArray($styleArray);   
    $this->excel->getActiveSheet()->setCellValue("A".$contador,"Fecha");
    $this->excel->getActiveSheet()->setCellValue("B".$contador,"Concepto");
    $this->excel->getActiveSheet()->setCellValue("C".$contador,"CCC");
    $this->excel->getActiveSheet()->setCellValue("D".$contador,"CCO");  
    $this->excel->getActiveSheet()->setCellValue("E".$contador,"INVERSION"); 
    $this->excel->getActiveSheet()->getColumnDimension("F")->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth(40);
    $this->excel->getActiveSheet()->setCellValue("F".$contador,"TOTAL"); 
    $facturas = $this->ReportePresupuestoModel->DevulvegastosEspeciales($fecha1,$fecha2);
   //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r('hola'));fclose($fp);
   $styleArray = [
    
    'alignment' => [
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    ]    
];
  $totalccc=0;$totalcco=0;$totalinversion=0;$totalgestion=0;
    foreach($facturas as $row)
    {
     $contador++;
    
     $this->excel->getActiveSheet()->setCellValue("A".$contador,$row->fecha_pago);
     $this->excel->getActiveSheet()->setCellValue("B".$contador,$row->concepto);
     $this->excel->getActiveSheet()->getStyle("C".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
     $this->excel->getActiveSheet()->setCellValue("C".$contador,$row->ccc);
     $totalccc= $totalccc + $row->ccc;
     $this->excel->getActiveSheet()->getStyle("D".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
     $this->excel->getActiveSheet()->setCellValue("D".$contador,$row->cco);
     $totalcco= $totalcco + $row->cco;
     $this->excel->getActiveSheet()->getStyle("E".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
     $this->excel->getActiveSheet()->setCellValue("E".$contador,$row->inversion);
     $totalinversion= $totalinversion + $row->inversion;
     $this->excel->getActiveSheet()->getStyle("F".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
     $this->excel->getActiveSheet()->setCellValue("F".$contador,$row->gestion);
     $totalgestion=$totalgestion+$row->gestion;
     $this->excel->getActiveSheet()->getStyle('A'.$contador,':D'.$contador)->applyFromArray($styleArray); 
    }
    $contador++;
    $border_style= array('borders' => array('top' => array('style' => 
    PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
    $this->excel->getActiveSheet()->getStyle("C".$contador.":F".$contador)->applyFromArray($border_style);
    $this->excel->getActiveSheet()->getStyle("C".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
    $this->excel->getActiveSheet()->setCellValue("C".$contador,$totalccc);
    $this->excel->getActiveSheet()->getStyle("D".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
    $this->excel->getActiveSheet()->setCellValue("D".$contador,$totalcco);
    $this->excel->getActiveSheet()->getStyle("E".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
    $this->excel->getActiveSheet()->setCellValue("E".$contador,$totalinversion);
    $this->excel->getActiveSheet()->getStyle("F".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
    $this->excel->getActiveSheet()->setCellValue("F".$contador,$totalgestion);
    $styleArray = [
      'font' => [
          'bold'  =>  TRUE,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => '000000'),
      ]
    ];
    $this->excel->getActiveSheet()->getStyle("F".$contador)->applyFromArray($styleArray);
      header("Content-Type: aplication/vnd.ms-excel ");
      $nombre ="GastosEspeciales".date("Y-m-d H:i:s");
      header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
      header("Cache-Control: max-age=0")        ;
      $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
      $writer->save("php://output");    

     // echo json_encode('lISTO');     
}
/******************************** */
function ReporteExcelPresupuesto()
    {
        $ano = $this->input->post('ano');
            
      $nombre ="Reporte De Presupuesto".$ano;
      $this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
      $this->excel->getActiveSheet()->setTitle('Presupuesto'.$ano);
        //ancho de las columnas
       // $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
       $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false); 
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        //valor de la celda
        $contador = 1;

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
      $this->excel->getActiveSheet()->getStyle('B1:M1')->applyFromArray($styleArray);
        /*$this->excel->getActiveSheet()->getStyle('B1:M1')->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' =>'#FFFFDF']
         array('rgb' => '497E2D')

         )
         ) 
         );*/  
        //$this->excel->getActiveSheet()->getColumnDimension('B2')->setWidth(10);
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("A{$contador}",'');
        //$this->excel->getActiveSheet()->getColumnDimension("B{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimension("B{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'ENERO');
       // $this->excel->getActiveSheet()->getColumnDimension("B{$contador}")->setAutoSize(false);
       // $this->excel->getActiveSheet()->getColumnDimension("B{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("C{$contador}",'FEBRERO');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("C{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("C{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("D{$contador}",'MARZO');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("D{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("D{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("E{$contador}",'ABRIL');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("E{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("E{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("F{$contador}",'MAYO');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("F{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("F{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("G{$contador}",'JUNIO');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("G{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("G{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("H{$contador}",'JULIO');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("H{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("H{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("I{$contador}",'AGOSTO');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("I{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("I{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("J{$contador}",'SEPTIEMBRE');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("J{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("J{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("K{$contador}",'OCTUBRE');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("K{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("K{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("L{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("L{$contador}",'NOVIEMBRE');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("L{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("L{$contador}")->setWidth('10');
        $this->excel->getActiveSheet()->getStyle("M{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("M{$contador}",'DICIEMBRE');
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("M{$contador}")->setAutoSize(false);
        //$this->excel->getActiveSheet()->getColumnDimensionByColumn("M{$contador}")->setWidth('10');
        
       
       
        //Enero Capilta
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'1');
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);        
        $styleArray = [
          'font' => [
              'bold'  =>  true,
              'size'  =>  10,
              'name'  =>  'Franklin Gothic Book',
              'color' => array('rgb' => '#7CA5FF'),
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
         /* 'fill' =>[
            'type'=>PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => 'C8FFFF']
          ]*/   
      ];
      
      //$this->excel->getActiveSheet()->getColumnDimension("A".$contador)->setAutoSize(true);
      $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth(25);
      $this->excel->getActiveSheet()->getStyle("A".$contador)->applyFromArray($styleArray);
      $this->excel->getActiveSheet()->setCellValue("A".$contador,"Canal Seguros ".$ano );
        //$this->excel->getActiveSheet()->getStyle("A".$contador) ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor() ->setRGB('FF0000');
        //$this->excel->getActiveSheet()->getStyle("A".$contador)->getFill()->getStartColor()->setRGB('FF0000');
        //enero
        $ingresos =0;
        $porcentaje = 0;
      
        foreach($datos as $che)
        {
         $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->Sucursal);
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        //$this->excel->getActiveSheet()->setCellValue("B".$contador, number_format($che->comision,2));
        if($che->comision=="")
        {
          $this->excel->getActiveSheet()->setCellValue("B".$contador, 0.0);
        }
        else{
        $this->excel->getActiveSheet()->setCellValue("B".$contador, $che->comision);
      }
        $ingresos = $ingresos + $che->comision;
         if($che->Sucursal=='AsesoresMerida')
          {
            $porcentaje = $porcentaje + $che->comision;
          }
          if($che->Sucursal=='AsesoresCancun')
          {
            $porcentaje = $porcentaje + $che->comision;
          }
        }
     
     
        //Devuelve bono 2019
         $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'1');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->sucursal);
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        //$this->excel->getActiveSheet()->setCellValue("B".$contador, number_format($che->total,2));
        $this->excel->getActiveSheet()->setCellValue("B".$contador, $che->total);
        $ingresos = $ingresos + $che->total;
        $porcentaje = $porcentaje + $che->total;
          
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("A".$contador,"Bono ".$ano);
         //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue("B".$contador, '0.00');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'1');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->sucursal);
          //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          //$this->excel->getActiveSheet()->setCellValue("B".$contador, number_format($che->total,2));
          $this->excel->getActiveSheet()->setCellValue("B".$contador,$che->total,2);
          $ingresos = $ingresos + $che->total;
          $porcentaje = $porcentaje + $che->total;
         }
        } 
        else
        {
          $contador++; 
          $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("A".$contador,"Bono ".($ano-1));  
          //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue("B".$contador, '0.00');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'1');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->sucursal);
          //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          //$this->excel->getActiveSheet()->setCellValue("B".$contador, number_format($che->total,2));
          $this->excel->getActiveSheet()->setCellValue("B".$contador, $che->total);
          $ingresos = $ingresos + $che->total;
          $porcentaje = $porcentaje + $che->total;
         }
        }
        else
        {
          $contador++; 
          //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("A".$contador,"PROMO");  
          //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue("B".$contador, '0.00');   
        } 
        $border_style= array('borders' => array('bottom' => array('style' => 
          PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
          $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);

        $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Ingresos Totales");
        $this->excel->getActiveSheet()->getStyle("A".$contador)->getFont()->setBold(true); 
       /* $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("L{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("M{$contador}")->getFont()->setBold(true);
         $this->excel->getActiveSheet()->getStyle("A".$contador.":M".$contador)->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'EAE8EC')
         )
         ) 
         );  */
        //$this->excel->getActiveSheet()->getStyle("A".$contador) ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor() ->setRGB('EAE8EC');
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        //$this->excel->getActiveSheet()->setCellValue("B".$contador,number_format( $ingresos,2));
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$ingresos);
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'1');
        $contador++;
        //$margina =0;
        $sumacosto =0;
        foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         //$sucursal = $che->Sucursal;  
         //$comision = $che->comision;  
             
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //$this->excel->getActiveSheet()->setCellValue("A".$contador,$reg->sucursal);
        $this->excel->getActiveSheet()->getStyle("A".$contador)->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->setCellValue("A".$contador,'Costo de Venta');
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00'); 
        //$this->excel->getActiveSheet()->setCellValue("B".$contador, number_format($reg->total,2));
        if( $reg->total=="")
        {
          $this->excel->getActiveSheet()->setCellValue("B".$contador,0.00);
        }
        else{
        $this->excel->getActiveSheet()->setCellValue("B".$contador, $reg->total);
        }
        $ingresos = $ingresos - $reg->total;    
        $sumacosto =$reg->total;                
        }


          $border_style= array('borders' => array('bottom' => array('style' => 
          PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
          $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
          $border_style= array('borders' => array('top' => array('style' => 
          PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
          $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
          if($porcentaje ==0)
          {
          $resulpor =0;
          }
          else{
          $resulpor = number_format(($sumacosto/$porcentaje)*100);
          }
          //$resulpor = $resulpor +"%";
          $contador++;
          $this->excel->getActiveSheet()->setCellValue("B".$contador, $resulpor.'%');
             $styleArray = [
          'font' => [
              'bold'  =>  false,
              'size'  =>  8,
              'name'  =>  'Franklin Gothic Book',
              'color' => array('rgb' => '#000000'),
          ],
          'alignment' => [
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
          ],
                
      ];
      $this->excel->getActiveSheet()->getStyle("B".$contador)->applyFromArray($styleArray);
          //$this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        //$this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $contador++;

       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Contribucion Marginal");
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$ingresos);
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'1');
        $gastototal =0;
        $contador++;
        if($gasto != FALSE)
        {
          foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
       
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$reg->sucursal);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');  
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$reg->total);
        $gastototal = $gastototal + $reg->total;
        }
        }
        else{
          $contador++;
          $this->excel->getActiveSheet()->setCellValue("A".$contador,'Gastos de Operacion');
          //$this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');  
          $this->excel->getActiveSheet()->setCellValue("B".$contador,'$0.00'); 
          }    
        
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'1');
        if($gasto != FALSE)
        {
        foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$reg->sucursal);
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       if($reg->total > 0)
       {
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');  
        $this->excel->getActiveSheet()->setCellValue("B".$contador, $reg->total);
        $gastototal = $gastototal + $reg->total;
       }    
       else{
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');  
        $this->excel->getActiveSheet()->setCellValue("B".$contador,'0.00'); 
       }
        }
      }
        else{
          $contador++;
          $this->excel->getActiveSheet()->setCellValue("A".$contador,'Nomina');
          $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');  
          $this->excel->getActiveSheet()->setCellValue("B".$contador,'$0.00'); 
          }  
        $contador++;

        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Gastos Totales");
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        /*$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("L{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("M{$contador}")->getFont()->setBold(true);
        //$this->excel->getActiveSheet()->getStyle("A".$contador) ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor() ->setRGB('EAE8EC');
         $this->excel->getActiveSheet()->getStyle("A".$contador.":M".$contador)->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'EAE8EC')
         )
         ) 
         );  */
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00'); 
        $this->excel->getActiveSheet()->setCellValue("B".$contador, $gastototal);
        $border_style= array('borders' => array('top' => array('style' => 
          PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
          $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);

        $contador++;
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Utilidad/Perdida");
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00'); 
        $this->excel->getActiveSheet()->setCellValue("B".$contador,($ingresos- $gastototal));
        $border_style= array('borders' => array('top' => array('style' => 
          PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
          $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
          $border_style= array('borders' => array('bottom' => array('style' => 
          PHPExcel_Style_Border::BORDER_DOUBLE ,'color' => array('rgb' => '766f6e'),)));
          $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
        if(($ingresos - $gastototal) < 0)
        {
          $styleArray = [
            'font' => [
                'bold'  =>  false,
                'size'  =>  10,
                'name'  =>  'Franklin Gothic Book',
                'color' => array('rgb' => 'FF2506'),
            ],
            ];
          $this->excel->getActiveSheet()->getStyle("B".$contador)->applyFromArray($styleArray);
        }
       
       
       // $this->excel->getActiveSheet()->getStyle("A".$contador) ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor() ->setRGB('EAE8EC');
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        //canal Fianzas
        $contador++;
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Canal Fianzas ".$ano);
        $styleArray = [
          'font' => [
              'bold'  =>  true,
              'size'  =>  10,
              'name'  =>  'Franklin Gothic Book',
              'color' => array('rgb' => '#7CA5FF'),
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
         /* 'fill' =>[
            'type'=>PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => 'C8FFFF']
          ]*/   
      ];
      $this->excel->getActiveSheet()->getStyle("A".$contador)->applyFromArray($styleArray);
      $porcentaje =0;
        // $this->excel->getActiveSheet()->getStyle("A".$contador) ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor() ->setRGB('33FF39');
         $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'1');       
        //Termina Enero
         $ingresos = 0;
        foreach($datos as $che){
             $contador++;
             
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->Institucional);
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00'); 
       if($che->Fianzas =="")
       {
        $this->excel->getActiveSheet()->setCellValue("B".$contador,0.00);
       }
       else{
       $this->excel->getActiveSheet()->setCellValue("B".$contador,$che->Fianzas);
       }
        $ingresos = $ingresos + $che->Fianzas;   
          if($che->Institucional == 'Coporativa')
          {
            $porcentaje = $porcentaje +$che->Fianzas;
          }    
          if($che->Institucional == 'Asesores')
          {
            $porcentaje = $porcentaje +$che->Fianzas;
          }     
        }
        //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'1');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->sucursal);
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador, $che->total);
        $ingresos = $ingresos + $che->total;
        $porcentaje = $porcentaje +$che->total;
        }
       }        
        else
        {
         $contador++;   
         //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("A".$contador,'Bono '.($ano));
         $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue("B".$contador, '0.00');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'1');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->sucursal);
          //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue("B".$contador,$che->total);
          $ingresos = $ingresos + $che->total;
          $porcentaje = $porcentaje +$che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->setCellValue("A".$contador,'Bono '.($ano-1));
          //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue("B".$contador, '0');   
        } 
        //Devuelve promo
        /*$datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'1');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
         // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->sucursal);
         // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue("B".$contador, $che->total);
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("A".$contador,'');
          $this->excel->getActiveSheet()->setCellValue("B".$contador, '0');   
        } */
       

        $contador++;
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Ingresos Totales");
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$ingresos);
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $border_style= array('borders' => array('top' => array('style' => 
        PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
        $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);

        $contador++;
        //$costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano);
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'1');
        $sumacosto=0;
        if($costo)
        {
        foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
            
         $this->excel->getActiveSheet()->setCellValue("A".$contador,'Costo de Venta');
         $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        //$this->excel->getActiveSheet()->setCellValue("B".$contador,$reg->total);
         if( $reg->total=="")
          {
           $this->excel->getActiveSheet()->setCellValue("B".$contador,0.00);
          }
          else{
          $this->excel->getActiveSheet()->setCellValue("B".$contador, $reg->total);
          }
           $ingresos = $ingresos - $reg->total;
           $sumacosto = $reg->total;
          }
        }
        else{
          $contador++;
          $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue("B".$contador,0.00);
        } 
        $border_style= array('borders' => array('bottom' => array('style' => 
        PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
        $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
        $border_style= array('borders' => array('top' => array('style' => 
        PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
        $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
       if($porcentaje ==0){
        $resulpor =0.00;
       }
       else{
        $resulpor = number_format(($sumacosto/$porcentaje)*100);
       }
        $contador++;
        $this->excel->getActiveSheet()->setCellValue("B".$contador, $resulpor.'%');
           $styleArray = [
        'font' => [
            'bold'  =>  false,
            'size'  =>  8,
            'name'  =>  'Franklin Gothic Book',
            'color' => array('rgb' => '#000000'),
        ],
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        ],
              
    ];
    $this->excel->getActiveSheet()->getStyle("B".$contador)->applyFromArray($styleArray);
        $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Contribucion Marginal");
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$ingresos);
       //gasto de oprecion de fianzas 
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'1');
        $gastototal =0;
        $contador++;
        foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,'Gasto de Operacion');
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$reg->total);
        $gastototal = $gastototal + $reg->total;
            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'1');
        
        
        foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$reg->sucursal);
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       if($reg->total >0)
       {
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$reg->total);
        $gastototal = $gastototal + $reg->total;
       }     
       else{
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,'0.00');
       }
       }
       $contador++;

        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Gastos Totales");
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$gastototal);
        $border_style= array('borders' => array('top' => array('style' => 
        PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
        $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
        $contador++;
        $contador++;

       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Utilidad/Perdida");
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,($ingresos- $gastototal));
        $border_style= array('borders' => array('top' => array('style' => 
        PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
        $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
        $border_style= array('borders' => array('bottom' => array('style' => 
        PHPExcel_Style_Border::BORDER_DOUBLE ,'color' => array('rgb' => '766f6e'),)));
        $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
      if(($ingresos - $gastototal) < 0)
      {
        $styleArray = [
          'font' => [
              'bold'  =>  false,
              'size'  =>  10,
              'name'  =>  'Franklin Gothic Book',
              'color' => array('rgb' => 'FF2506'),
          ],
          ];
        $this->excel->getActiveSheet()->getStyle("B".$contador)->applyFromArray($styleArray);
      }
    
     
        $contador++;
        //Corporativo
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Canal Coorporativo ".$ano);
        $styleArray = [
          'font' => [
              'bold'  =>  true,
              'size'  =>  10,
              'name'  =>  'Franklin Gothic Book',
              'color' => array('rgb' => '#7CA5FF'),
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
         /* 'fill' =>[
            'type'=>PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => 'C8FFFF']
          ]*/   
      ];
      $this->excel->getActiveSheet()->getStyle("A".$contador)->applyFromArray($styleArray);
        //$this->excel->getActiveSheet()->getStyle("A".$contador) ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor() ->setRGB('339CFF');
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'1');
        $gastototal =0;
        if($gasto)
        {  
        foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$reg->sucursal);
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$reg->total,2);
        $gastototal = $gastototal + $reg->total;
            
        }        
       }
       else
       {
             $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,'Comision');
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,'0.00');
       }

       $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'1');
       if($gasto)
        {  
        foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
         $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$reg->sucursal);
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$reg->total);
        $gastototal = $gastototal + $reg->total;            
        } 
       } 
       else
       {
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,'Bono');
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,'0.00');
       }
        $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Ingresos Totales");
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$gastototal);
        $border_style= array('borders' => array('top' => array('style' => 
        PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
        $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'1');
        $contador++;
        if($costo)
        {
        foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;        
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$reg->sucursal);
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$reg->total);
        $gastototal = $gastototal - $reg->total;
            
        }
        }
        else
       {
        $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,'Costo');
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,'0.00');        
       } 
       $border_style= array('borders' => array('bottom' => array('style' => 
       PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
       $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
       $border_style= array('borders' => array('top' => array('style' => 
       PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
       $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
       $contador++;
       $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Contribucion Marginal");
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$gastototal);
       
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'1');
       $gastototal1=0;
       $contador++;
        foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$reg->sucursal);
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$reg->total);
        $gastototal1 = $gastototal1 + $reg->total;
            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'1');
       
        foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,$reg->sucursal);
        //$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        if($reg->total > 0)
        {
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$reg->total);
        }else{
          $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,'0.00');
        }
        $gastototal1 = $gastototal1 + $reg->total;
            
        }
        $contador++;

       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Gastos Totales");
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
       // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,$gastototal1);
       
        $contador++;
        $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("A".$contador,"Utilidad/Perdida");
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue("B".$contador,($gastototal- $gastototal1));
        $border_style= array('borders' => array('top' => array('style' => 
        PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));
        $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
        $border_style= array('borders' => array('bottom' => array('style' => 
        PHPExcel_Style_Border::BORDER_DOUBLE ,'color' => array('rgb' => '766f6e'),)));
        $this->excel->getActiveSheet()->getStyle("B".$contador.":M".$contador)->applyFromArray($border_style);
        if(($ingresos - $gastototal) < 0)
        {
          $styleArray = [
            'font' => [
                'bold'  =>  false,
                'size'  =>  10,
                'name'  =>  'Franklin Gothic Book',
                'color' => array('rgb' => 'FF2506'),
            ],
            ];
          $this->excel->getActiveSheet()->getStyle("B".$contador)->applyFromArray($styleArray);
        }
        
      //***********************************************
      //***********************************************
      //**********************************************  
      //empieza febrero
      $j=2;
      $letra ="";
       while($j < 13) 
       {
        if($j ==2)
        {
          $letra ='C';    
        }
        if($j ==3)
        {
          $letra ='D';    
        }
        if($j ==4)
        {
          $letra ='E';    
        }
        if($j ==5)
        {
          $letra ='F';    
        }
        if($j ==6)
        {
          $letra ='G';    
        }
        if($j ==7)
        {
          $letra ='H';    
        }
        if($j ==8)
        {
          $letra ='i';    
        }
        if($j ==9)
        {
          $letra ='j';    
        }
        if($j ==10)
        {
          $letra ='K';    
        }
        if($j ==11)
        {
          $letra ='L';    
        } 
        if($j ==12)
        {
          $letra ='M';    
        }
        $contador=1;
        $contador++;
        //$datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'2');
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,$j);
        $ingresos =0;
        $porcentaje =0;
        foreach($datos as $che)
        {
         $contador++;
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         if($che->comision >0)
         {
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue($letra.$contador,$che->comision);
         $ingresos = $ingresos + $che->comision;
         }
         else{
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,'0.00');
         }
         if($che->Sucursal=='AsesoresMerida')
         {
           $porcentaje = $porcentaje + $che->comision;
         }
         if($che->Sucursal=='AsesoresCancun')
         {
           $porcentaje = $porcentaje + $che->comision;
         }
          
        }
      //Devuelve bono 2019
         $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,$j);
       if($datos != FALSE)
       { 
        foreach($datos as $che)
        {
         $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$che->total);
        $ingresos = $ingresos + $che->total;
        $porcentaje = $porcentaje + $che->total;
        }
        }        
        else
        {
         $contador++;   
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue($letra.$contador, '0.00');  
        }
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,$j);
       if($datos != FALSE)
       {
        foreach($datos as $che)
        {
         $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$che->total,2);
        $ingresos = $ingresos + $che->total;
        $porcentaje = $porcentaje + $che->total;
        }
       } 
       else
        {
         $contador++;   
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue($letra.$contador, '0.00');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,$j);
       if($datos != FALSE)
       {
        foreach($datos as $che)
        {
         $contador++;
        // $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue($letra.$contador,$che->total);
         $ingresos = $ingresos + $che->total;
         $porcentaje = $porcentaje + $che->total;
        }
       } 
       else
        {
         $contador++;   
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue($letra.$contador, '0.00');  
        } 
       $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$ingresos);
        //Costos
       $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,$j);
       $contador++;
       //$contador++;
       $sumacosto=0;
        foreach($costo as $reg)
        {
         $contador++;
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         if($reg->total=="")
         {
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);
         }
         else{
         $this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
        }
         $ingresos = $ingresos - $reg->total;
         $sumacosto =$reg->total; 
        }
        if($porcentaje ==0)
        {
        $resulpor = 0;
        }
        else{
          $resulpor = number_format(($sumacosto/$porcentaje)*100);
        }
          //$resulpor = $resulpor +"%";
          $contador++;
          $this->excel->getActiveSheet()->setCellValue($letra.$contador, $resulpor.'%');
             $styleArray = [
          'font' => [
              'bold'  =>  false,
              'size'  =>  8,
              'name'  =>  'Franklin Gothic Book',
              'color' => array('rgb' => '#000000'),
          ],
          'alignment' => [
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
          ],
                
      ];
      $this->excel->getActiveSheet()->getStyle($letra.$contador)->applyFromArray($styleArray);
     
      $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$ingresos);
        //Terminacosto
        //gasto de operacion
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,$j);
        $gastototal =0;
        if($gasto)
        {
        foreach($gasto as $reg)
        {
         $contador++;
        // $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         if($reg->total =="")
         {
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);
         }
         else{
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
          } 
         $gastototal = $gastototal + $reg->total;            
        }
        }
        else{
          $contador++;
          // $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
           $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);
        }
        //termina gasto operacion
        //Nomina
       $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,$j);
       if($gasto!=false)
       {
       foreach($gasto as $reg)
       {
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        if($reg->total =="")
        {
         $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);
        }
        else{
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
        }
        $gastototal = $gastototal + $reg->total;
       }
      }
      else{
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,'0.00');
      }
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$gastototal);
        
        $contador++;
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,($ingresos- $gastototal));
        if(($ingresos - $gastototal) < 0)
      {
        $styleArray = [
          'font' => [
              'bold'  =>  false,
              'size'  =>  10,
              'name'  =>  'Franklin Gothic Book',
              'color' => array('rgb' => 'FF2506'),
          ],
          ];
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->applyFromArray($styleArray);
      }
        //Canal Fialnzas
        $contador++;
        $contador++;
        $sumacosto=0;$porcentaje=0;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,$j);       
        $ingresos = 0;
        if($gasto!=false)
        {
        foreach($datos as $che)
        {
         $contador++;
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         if($che->Fianzas=="")
         {
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);  
         }
         else{
         $this->excel->getActiveSheet()->setCellValue($letra.$contador,$che->Fianzas);
         }
         $ingresos = $ingresos + $che->Fianzas;   
         if($che->Institucional == 'Coporativa')
         {
           $porcentaje = $porcentaje +$che->Fianzas;
         }    
         if($che->Institucional == 'Asesores')
         {
           $porcentaje = $porcentaje +$che->Fianzas;
         }   
                  
        }
        }
        else{
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,'0.00');
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoFianzas($ano,$j);
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$che->total);
        $ingresos = $ingresos + $che->total;
        $porcentaje = $porcentaje +$che->total;
        }
       }        
        else
        {
         $contador++;   
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue($letra.$contador, '0.00');  
        } 
        //Devuelve bono
       $datos=  $this->ReportePresupuestoModel->DevuelveBonoFianzas($ano-1,$j);
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,$che->total);
          $ingresos = $ingresos + $che->total;
          $porcentaje = $porcentaje +$che->total;
         }
        } 
        else
        {
          $contador++;   
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador, '0.00');   
        } 
        //Devuelve promo
       /* $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'2');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle("C".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue("C".$contador, $che->total);
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle("C".$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue("C".$contador, '0.00');   
        }*/ 
        $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$ingresos);
       //cOSTO-fIANZAS
        //$ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,$j);
        $contador++;
        foreach($costo as $reg)
        {
         $contador++;
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         if($reg->total =="")
         {
         $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);
         }
         else{
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
         }
         $ingresos = $ingresos - $reg->total;       
         $sumacosto = $reg->total;     
        }
        //$resulpor = number_format(($sumacosto/$porcentaje)*100);
        if($porcentaje ==0)
        {
        $resulpor = 0;
        }
        else{
          $resulpor = number_format(($sumacosto/$porcentaje)*100);
        }
        $contador++;
        $this->excel->getActiveSheet()->setCellValue($letra.$contador, $resulpor.'%');
           $styleArray = [
        'font' => [
            'bold'  =>  false,
            'size'  =>  8,
            'name'  =>  'Franklin Gothic Book',
            'color' => array('rgb' => '#000000'),
        ],
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        ],
              
    ];
    $this->excel->getActiveSheet()->getStyle($letra.$contador)->applyFromArray($styleArray);
      
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$ingresos);
          
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,$j);
        $gastototal=0;
        $contador++;
        foreach($gasto as $reg)
        {
         $contador++;
         //$this->excel->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         //$this->excel->getActiveSheet()->setCellValue($letra.$contador, $reg->total);
         if($reg->total =="")
         {
         $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);
         }
         else{
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
         }
         $gastototal = $gastototal + $reg->total;            
        }
          
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,$j);
        foreach($gasto as $reg)
        {
         $contador++;
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         //$this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
         if($reg->total =="")
         {
         $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);
         }
         else{
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
         }
         $gastototal = $gastototal + $reg->total;
        }
       
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$gastototal);
        $contador++;
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,($ingresos- $gastototal));
        if(($ingresos - $gastototal) < 0)
        {
          $styleArray = [
            'font' => [
                'bold'  =>  false,
                'size'  =>  10,
                'name'  =>  'Franklin Gothic Book',
                'color' => array('rgb' => 'FF2506'),
            ],
            ];
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->applyFromArray($styleArray);
        }
        //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,$j);
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador, $reg->total);
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,'0.00');   
        }
             
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,$j);
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,'0.00');   
        }
        
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$gastototal,2);
       
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,$j);
        $contador++;
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
         $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
         $this->excel->getActiveSheet()->setCellValue($letra.$contador, $reg->total);
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,'0.00');   
        }    
        
        $contador++;
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$gastototal);
       
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,$j);
       $gastototal1=0;
       $contador++;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          //$this->excel->getActiveSheet()->setCellValue($letra.$contador, $reg->total);
          if($reg->total =="")
          {
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);
          }
          else{
           $this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
          }
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,'0.00');     
        }    
       
       $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,$j);
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          //$this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
          if($reg->total =="")
          {
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,0.00);
          }
          else{
           $this->excel->getActiveSheet()->setCellValue($letra.$contador,$reg->total);
          }
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
          $this->excel->getActiveSheet()->setCellValue($letra.$contador,'0.00');       
        }    
        $contador++;
       // $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
       $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,$gastototal1);
        $contador++;
        //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $contador++;
        $this->excel->getActiveSheet()->getStyle($letra.$contador)->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->excel->getActiveSheet()->setCellValue($letra.$contador,($gastototal- $gastototal1));
        if(($gastototal- $gastototal1) < 0)
        {
          $styleArray = [
            'font' => [
                'bold'  =>  false,
                'size'  =>  10,
                'name'  =>  'Franklin Gothic Book',
                'color' => array('rgb' => 'FF2506'),
            ],
            ];
          $this->excel->getActiveSheet()->getStyle($letra.$contador)->applyFromArray($styleArray);
        }
        $j++;
      }
      /*
       //***********************************************
      //***********************************************
      //********************************************** 
      //mARZO 
       $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'3');
        $ingresos =0;
        
         foreach($datos as $che)
         {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
         } 
         
      //Devuelve bono 2019
         $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'3');
       if($datos != FALSE)
        {  
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, '0');  
        }  
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'3');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'3');
        if($datos != FALSE)
        { 
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, '0');  
        } 
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'3');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format( $ingresos,2));     
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'3');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'3');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format($ingresos- $gastototal,2));
        //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'3');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'3');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'3');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'3');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, '0');   
        }
       $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format( $ingresos,2));
       //cOSTO-fIANZAS
        //$ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'3');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'3');
        $gastototal=0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'3');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format($ingresos- $gastototal,2)); 
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'3');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'3');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador,'0.00');   
        }
        
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'3');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'3');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'3');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("D".$contador,number_format($gastototal- $gastototal1,2));
       
      //***********************************************
      //***********************************************
      //********************************************** 
      //aBRIL 
        $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'4');
        $ingresos =0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
        }
        //Devuelve bono 2019
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'4');
        if($datos != FALSE)
        {         
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
        }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, '0');  
        }
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'4');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'4');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, '0');  
        } 
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'4');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format( $ingresos,2));      
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'4');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
         //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'4');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format($ingresos- $gastototal,2));
       //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'4');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'4');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'4');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'4');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador, '0');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format( $ingresos,2));
        //cOSTO-fIANZAS
       // $ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'4');
        $gastototal=0;
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'4');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'4');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format($ingresos- $gastototal,2));      
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'4');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'4');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador,'0.00');   
        }
        
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'4');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'4');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'4');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("E".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("E".$contador,number_format($gastototal- $gastototal1,2));
      //***********************************************
      //***********************************************
      //********************************************** 
      //MAYO
        $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'5');
        $ingresos =0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
        } 
        //Devuelve bono 2019
         $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'5');
        if($datos != FALSE)
        {  
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, '0');  
        }
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'5');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'5');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, '0');  
        } 
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'5');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format( $ingresos,2));
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'5');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'5');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format($ingresos- $gastototal,2));
       //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'5');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        } 
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'5');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'5');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'5');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, '0');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format( $ingresos,2));
        //cOSTO-fIANZAS
       // $ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'5');
        $gastototal=0;
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'5');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'5');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format($ingresos- $gastototal,2));
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'5');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'5');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador,'0.00');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'5');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'5');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'5');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("F".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("F".$contador,number_format($gastototal- $gastototal1,2));
         //***********************************************
      //***********************************************
      //********************************************** 
      //JUN IO
        $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'6');
        $ingresos =0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
        }
        //Devuelve bono 2019
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'6');
        if($datos != FALSE)
        {  
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'6');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'6');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, '0');  
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'6');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format( $ingresos,2));
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'6');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'6');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format($ingresos- $gastototal,2));
        //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'6');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'6');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'6');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'6');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, '0');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format( $ingresos,2));
        //cOSTO-fIANZAS
        //$ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'6');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'6');
        $gastototal=0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'6');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format($ingresos- $gastototal,2));
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'6');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'6');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador,'0.00');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'6');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'6');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'6');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("G".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("G".$contador,number_format($gastototal- $gastototal1,2));
      //***********************************************
      //***********************************************
      //********************************************** 
      //JULIO 
        $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'7');
        $ingresos =0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
        }
        //Devuelve bono 2019
         $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'7');
        if($datos != FALSE)
        {  
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'7');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'7');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, '0');  
        } 
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'7');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format( $ingresos,2));
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'7');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'7');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format($ingresos- $gastototal,2));
        //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'7');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'7');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'7');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'7');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, '0');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format( $ingresos,2));
        //cOSTO-fIANZAS
        //$ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'7');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'7');
        $gastototal=0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'7');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format($ingresos- $gastototal,2));
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'7');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'7');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador,'0.00');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'7');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'7');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'7');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("H".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("H".$contador,number_format($gastototal- $gastototal1,2));
         //***********************************************
      //***********************************************
      //********************************************** 
      //AGOSTO
        $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'8');
        $ingresos =0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
        } 
        //Devuelve bono 2019
         $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'8');
        if($datos != FALSE)
        {        
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'8');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'8');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, '0');  
        } 
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'8');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format( $ingresos,2));      
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'8');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'8');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format($ingresos- $gastototal,2));
        //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'8');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'8');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'8');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'8');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, '0');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format( $ingresos,2));
        //cOSTO-fIANZAS
        //$ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'8');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'8');
        $gastototal=0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'8');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format($ingresos- $gastototal,2));
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'8');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'8');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador,'0.00');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'8');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'8');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'8');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("I".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("I".$contador,number_format($gastototal- $gastototal1,2));
         //***********************************************
      //***********************************************
      //********************************************** 
      //SEPTIEMBRE 
        $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'9');
        $ingresos =0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
        }
        //Devuelve bono 2019
         $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'9');
         if($datos != FALSE)
         { 
          foreach($datos as $che)
          {
           $contador++;
           $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($che->total,2));
           $ingresos = $ingresos + $che->total;
          }
         }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'9');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'9');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, '0');  
        } 
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'9');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format( $ingresos,2)); 
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'9');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'9');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format($ingresos- $gastototal,2));
        //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'9');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'9');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'9');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'9');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador, '0');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format( $ingresos,2));
        //cOSTO-fIANZAS
        //$ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'9');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'9');
        $gastototal=0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'9');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format($ingresos- $gastototal,2));
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'9');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'9');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador,'0.00');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'9');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'9');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'9');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("J".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("J".$contador,number_format($gastototal- $gastototal1,2));
         //***********************************************
      //***********************************************
      //**RE******************************************** 
      //OCTUB RE
       $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'10');
        $ingresos =0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
        }
        //Devuelve bono 2019
          $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'10');
       if($datos != FALSE)
       {
         foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($che->total,2));
         $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'10');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'10');
        if($datos != FALSE)
        { 
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, '0');  
        } 
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'10');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format( $ingresos,2));
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'10');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'10');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format($ingresos- $gastototal,2));
        //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'10');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'10');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'10');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'10');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador, '0');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format( $ingresos,2));
        //cOSTO-fIANZAS
        //$ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'10');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'10');
        $gastototal=0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'10');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format($ingresos- $gastototal,2));
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'10');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'10');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador,'0.00');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'10');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'10');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'10');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("K".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("K".$contador,number_format($gastototal- $gastototal1,2));
         //***********************************************
      //***********************************************
      //********************************************** 
      //mARVIEMBREZO 
        $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'11');
        $ingresos =0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
        }
        //Devuelve bono 2019
         $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'11');
       if($datos != FALSE)
       {
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($che->total,2));
         $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'11');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'11');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, '0');  
        } 
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'11');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format( $ingresos,2));
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'11');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'11');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format($ingresos- $gastototal,2));
        //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'11');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'11');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'11');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'11');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador, '0');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format( $ingresos,2));
        //cOSTO-fIANZAS
        //$ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'11');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'11');
        $gastototal=0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'11');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format($ingresos- $gastototal,2));
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'11');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'11');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador,'0.00');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'11');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'11');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'11');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("L".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("L".$contador,number_format($gastototal- $gastototal1,2));
         //***********************************************
      //***********************************************
      //********************************************** 
      //DICIEMBRE
       $contador=1;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevulvePresupuesto($ano,'12');
        $ingresos =0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($che->comision,2));
         $ingresos = $ingresos + $che->comision;
        } 
        //Devuelve bono 2019
         $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'12');
       if($datos != FALSE)
       {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, '0');  
        }  
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'12');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, '0');  
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'12');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, '0');  
        } 
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format( $ingresos,2));
         //Costos
        $costo=  $this->ReportePresupuestoModel->DevulveCostoVenta($ano,'12');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format( $ingresos,2));
        //gasto de operacion
        $gasto=  $this->ReportePresupuestoModel->DevulveGasto($ano,'12');
        $gastototal =0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        //termina gasto operacion
          //Nomina
        $gasto=  $this->ReportePresupuestoModel->DevulveNomina($ano,'12');
       foreach($gasto as $reg)
       {
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
        $gastototal = $gastototal + $reg->total;
       }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format($ingresos- $gastototal,2));
        //Canal Fialnzas
        $contador++;
        $contador++;
        $datos=  $this->ReportePresupuestoModel->DevuelveFianzas($ano,'12');       
        $ingresos = 0;
        foreach($datos as $che)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($che->Fianzas,2));
         $ingresos = $ingresos + $che->Fianzas;            
        }
         //Devuelve Bonos
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,'12');
       if($datos != FALSE)
       { 
         foreach($datos as $che)
        {
         $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($che->total,2));
        $ingresos = $ingresos + $che->total;
        }
       }        
        else
        {
         $contador++;   
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, '0');  
        } 
        //Devuelve bono
        $datos=  $this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,'12');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        } 
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador, '0');   
        } 
        //Devuelve promo
        $datos=  $this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,'12');
        if($datos != FALSE)
        {
         foreach($datos as $che)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($che->total,2));
          $ingresos = $ingresos + $che->total;
         }
        }
        else
        {
          $contador++;   
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador, '0');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format( $ingresos,2));
        //cOSTO-fIANZAS
        //$ingresos=0;
        $costo=  $this->ReportePresupuestoModel->DevulveCostoFianza($ano,'12');
        foreach($costo as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
         $ingresos = $ingresos - $reg->total;            
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format( $ingresos,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoFianza($ano,'12');
        $gastototal=0;
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;            
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaFianza($ano,'12');
        foreach($gasto as $reg)
        {
         $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format( $gastototal,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format($ingresos- $gastototal,2));
         //Corporativo
        $contador++;
        $contador++;
        $gasto=  $this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,'12');
        $gastototal =0;
        if($gasto != FALSE)
        {
         foreach($gasto as $reg)
         {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
          $gastototal = $gastototal + $reg->total;
         }
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador,'0.00');   
        }
        $gasto=  $this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,'12');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
         $gastototal = $gastototal + $reg->total;
         } 
        }
        else
        {
         $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador,'0.00');   
        }
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format( $gastototal,2));
        $costo=  $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,'12');
        if($costo != FALSE)
        {
         foreach($costo as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
         $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
         $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
         $gastototal = $gastototal - $reg->total;            
        }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador,'0.00');   
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format( $gastototal,2));
        $gasto=  $this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,'12');
       $gastototal1=0;
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;            
         }
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador,'0.00');     
        }    
        $gasto=  $this->ReportePresupuestoModel->DevulveNominaCorpo($ano,'12');
       if($gasto != FALSE)
        {
         foreach($gasto as $reg){
            //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("D".$contador, number_format($reg->total,2));
          $gastototal1 = $gastototal1 + $reg->total;
         }   
        }
        else
        {
          $contador++;
          $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
          $this->excel->getActiveSheet()->setCellValue("M".$contador,'0.00');       
        }    
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format( $gastototal1,2));
        $contador++;
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->setCellValue("M".$contador,number_format($gastototal- $gastototal1,2));
        */
if(isset($_POST['ajax'])){$respuesta['excel']=$this->excel->getActiveSheet();echo json_encode($respuesta);}
else{
        header("Content-Type: aplication/vnd.ms-excel ");
        $nombre ="Reporte".date("Y-m-d H:i:s");
        header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
        header("Cache-Control: max-age=0")        ;
        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        $writer->save("php://output");
     }
    }
//--------------------------------------
function reporteDetalleBancos()
{
  $data=array();
  $anioInicial['anio']=2022;
  $data['meses']=$this->libreriav3->devolverMeses();
  $param['anio']=date('Y');  
  $anioActual=date('Y');  
  $anioAnterior=date('Y')-1;
  $canales=$this->catalogos_model->canalesCatalogos($anioInicial);
  $grupoCerCatalogo=$this->db->query('select * from catalog_grupo_cer')->result();
  $costoVentaCatalogo=$this->db->query('select * from catalog_costo_venta')->result();
  $gastosOperacion=$this->db->query('select distinct(f.idCuentaContableInicial),r.cuentaContable,f.idCuentaContable from facturas f left join relcuentacontabledepartamento r on r.idCuentaContable=f.idCuentaContable where f.posteriorapago!=5 and r.cuentaContable is not null and  year(f.fecha_pago) in ('.$anioAnterior.','.$anioActual.')')->result();
  $gastosOperacionAlterno=$this->db->query('select * from cuentacontablegrupos c where c.tipoGrupo="gastosOperacion" order by c.ordenamiento')->result();
  $gastosVariablesAlterno=$this->db->query('select * from cuentacontablegrupos c where c.tipoGrupo="gastosVariables" order by c.ordenamiento')->result();
  $gastosFinancieros=$this->db->query('select * from cuentacontablegrupos c where c.tipoGrupo="gastosFinancieros" order by c.ordenamiento')->result();
  $gastosImpuestos=$this->db->query('select * from cuentacontablegrupos c where c.tipoGrupo="gastosImpuestos" order by c.ordenamiento')->result();
    //$gastosVariables=$this->db->query('select * from cuentacontablegrupos c where c.tipoGrupo="gastosVariables"')->result();
  
  $data['canales']=array();
  $data['grupoCer']=array();
  foreach ($canales as $key => $value) 
  {
      
      if(!isset($data['canales'][$value->email])){$data['canales'][$value->email]=new \stdclass;}
            $consulta='select (UPPER(canal)) as canal from consulta_comercial_usuario_canal where correo="'.$value->email.'"';
      $canal=$this->db->query($consulta)->result()[0]->canal;
      $data['canales'][$value->email]->canal=$canal;
      $subRamos=$this->db->query('select distinct(a.SRamoNombre)  from avance_primas_pagadas_canal a where a.canal="'.$canal.'" and a.anio in ('.$anioActual.','.$anioAnterior.')')->result();
      

      $tablaId='metacomercial_ingreso_total';
      $tablaMeta='metapormes_por_ingreso_total';
      if($value->email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){$tablaId='metacomercial';$tablaMeta='metapormes';}
      $consulta='select idMetaComercial from '.$tablaId.' where email="'.$value->email.'" and anio='.$anioActual;       
      $idMetaComercial=$this->db->query($consulta)->result();
      $consulta='select idMetaComercial from '.$tablaId.' where email="'.$value->email.'" and anio='.$anioAnterior;       
      $idMetaComercialAnterior=$this->db->query($consulta)->result();
       //
      foreach ($data['meses'] as $keyMeses => $meses) 
      {
        $data['canales'][$value->email]->anioActualMonto[$keyMeses]=new \stdclass;      
      if(count($idMetaComercial)>0)
      {
        $id=(string)$idMetaComercial[0]->idMetaComercial;
          $consulta='select monto_al_mes,mes_num,anio,comision_actual from '.$tablaMeta.' where idMetaComercial='.$id.' and mes_num='.$keyMeses;        
          $resultActual=$this->db->query($consulta)->result()[0];
          
        $data['canales'][$value->email]->anioActualMonto[$keyMeses]->monto_al_mes=$resultActual->monto_al_mes;
          $data['canales'][$value->email]->anioActualMonto[$keyMeses]->mes_num=$keyMeses;
        $data['canales'][$value->email]->anioActualMonto[$keyMeses]->anio=$anioActual;
        $data['canales'][$value->email]->anioActualMonto[$keyMeses]->comision_actual=$resultActual->comision_actual;;

        
      }
      else
      {
          $data['canales'][$value->email]->anioActualMonto[$keyMeses]->monto_al_mes=0;
          $data['canales'][$value->email]->anioActualMonto[$keyMeses]->mes_num=$keyMeses;
        $data['canales'][$value->email]->anioActualMonto[$keyMeses]->anio=$anioActual;
        $data['canales'][$value->email]->anioActualMonto[$keyMeses]->comision_actual=0;


      }
        $data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]=new \stdclass;

      if(count($idMetaComercialAnterior)>0)
      {
        $id=(string)$idMetaComercialAnterior[0]->idMetaComercial;
          $consulta='select monto_al_mes,mes_num,anio,comision_actual from '.$tablaMeta.' where idMetaComercial='.$idMetaComercialAnterior[0]->idMetaComercial.' and mes_num='.$keyMeses;        
          $resultAnterior=$this->db->query($consulta)->result()[0];

        $data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]->monto_al_mes=$resultAnterior->monto_al_mes;
          $data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]->mes_num=$keyMeses;
        $data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]->anio=$anioAnterior;
        $data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]->comision_actual=$resultAnterior->comision_actual;

        //$data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]=$this->db->query($consulta)->result()[0];

      }
      else
      {
        $data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]->monto_al_mes=0;
        $data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]->mes_num=$keyMeses;
        $data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]->anio=$anioAnterior;
        $data['canales'][$value->email]->anioAnteriorMonto[$keyMeses]->comision_actual=0;
      }

        foreach ($subRamos as $keySubRamos => $valueSubRamos) 
        {
        $nameRamo=$valueSubRamos->SRamoNombre;
        $subRamosActualComision=$this->db->query('select comision from avance_primas_pagadas_canal where anio='.$anioActual.' and mes='.$keyMeses.' and SRamoNombre="'.$valueSubRamos->SRamoNombre.'"')->result();
        $subRamosAnteriorComision=$this->db->query('select comision from avance_primas_pagadas_canal where anio='.$anioAnterior.' and mes='.$keyMeses.' and SRamoNombre="'.$valueSubRamos->SRamoNombre.'"')->result();


         $data['canales'][$value->email]->subRamosActualComision[$nameRamo][$keyMeses]=0;
         $data['canales'][$value->email]->subRamosAnteriorComision[$nameRamo][$keyMeses]=0;
        
        if(count($subRamosActualComision)>0){$data['canales'][$value->email]->subRamosActualComision[$nameRamo][$keyMeses]= $subRamosActualComision[0]->comision;}
        if(count($subRamosAnteriorComision)>0){$data['canales'][$value->email]->subRamosAnteriorComision[$nameRamo][$keyMeses]= $subRamosAnteriorComision[0]->comision;}

      
       }
       if($value->email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM')
        {
         $data['canales'][$value->email]->subRamosActualComision['BONOS'][$keyMeses]=0;
         $data['canales'][$value->email]->subRamosAnteriorComision['BONOS'][$keyMeses]=0;
                 $subRamosActualComision=$this->db->query('select (sum(cantidad)) as comision from promobono where anio='.$anioActual.' and mes='.$keyMeses.' and canal="fianzas"')->result();
        $subRamosAnteriorComision=$this->db->query('select (sum(cantidad)) as comision from promobono where anio='.$anioAnterior.' and mes='.$keyMeses.' and canal="fianzas"')->result();
          
         $data['canales'][$value->email]->subRamosActualComision['BONOS'][$keyMeses]=0;
         $data['canales'][$value->email]->subRamosAnteriorComision['BONOS'][$keyMeses]=0;
                 if(count($subRamosActualComision)>0){$data['canales'][$value->email]->subRamosActualComision['BONOS'][$keyMeses]= $subRamosActualComision[0]->comision;}
        if(count($subRamosAnteriorComision)>0){$data['canales'][$value->email]->subRamosAnteriorComision['BONOS'][$keyMeses]= $subRamosAnteriorComision[0]->comision;}

        }
        if($value->email=='COORDINADOR@CAPCAPITAL.COM.MX')
        {
        $subRamosActualComision=$this->db->query('select (sum(cantidad)) as comision from promobono where anio='.$anioActual.' and mes='.$keyMeses.' and canal="institucional"')->result();
        $subRamosAnteriorComision=$this->db->query('select (sum(cantidad)) as comision from promobono where anio='.$anioAnterior.' and mes='.$keyMeses.' and canal="institucional"')->result();
          //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r('select (sum(cantidad)) as comision from promobono where anio='.$anioAnterior.' and mes='.$keyMeses.' and canal="institucional";',true));fclose($fp);
         $data['canales'][$value->email]->subRamosActualComision['BONOS'][$keyMeses]=0;
         $data['canales'][$value->email]->subRamosAnteriorComision['BONOS'][$keyMeses]=0;
                 if(count($subRamosActualComision)>0){$data['canales'][$value->email]->subRamosActualComision['BONOS'][$keyMeses]= $subRamosActualComision[0]->comision;}
        if(count($subRamosAnteriorComision)>0){$data['canales'][$value->email]->subRamosAnteriorComision['BONOS'][$keyMeses]= $subRamosAnteriorComision[0]->comision;}

        }
     }
       //$data['canales'][$value->email]->anioActual=$this->db->query()
  }
  
  
  //===========================  PARA GRUPO CER=============================================
  foreach ($grupoCerCatalogo as $key => $value) 
  {
    if(!isset($data['grupoCer'][$value->etiquetaNombreGrupo])){$data['grupoCer'][$value->etiquetaNombreGrupo]=new \stdclass;}      
          foreach ($data['meses'] as $keyMeses => $meses) 
      {
          $select='select * from avance_primas_pagadas_cer where anio='.$anioActual.' and mes='.$keyMeses.' and idGrupoCer='.$value->idGrupoCer;
          $datos=$this->db->query($select)->result();
          if(count($datos)==0)
          {
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioActual[$keyMeses]=new \stdclass;
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioActual[$keyMeses]->anio=$anioActual;
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioActual[$keyMeses]->monto=0;
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioActual[$keyMeses]->mes=$keyMeses;
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioActual[$keyMeses]->idGrupoCer=$value->idGrupoCer;
          }
          else{$data['grupoCer'][$value->etiquetaNombreGrupo]->anioActual[$keyMeses]=$datos[0];}

          $select='select * from avance_primas_pagadas_cer where anio='.$anioAnterior.' and mes='.$keyMeses.' and idGrupoCer='.$value->idGrupoCer;
          $datos=$this->db->query($select)->result();


          if(count($datos)==0)
          {
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioAnterior[$keyMeses]=new \stdclass;
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioAnterior[$keyMeses]->monto=0;
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['grupoCer'][$value->etiquetaNombreGrupo]->anioAnterior[$keyMeses]->idGrupoCer=$value->idGrupoCer;
          }
          else{$data['grupoCer'][$value->etiquetaNombreGrupo]->anioAnterior[$keyMeses]=$datos[0];}

          //$data['grupoCer'][$value->etiquetaNombreGrupo]->anioActual[$keyMeses]=$datos;
      }
    
    //$data['grupoCer'][$value->etiquetaNombreGrupo]->anioAnterior;
  }
  foreach ($data['meses'] as $keyMeses => $meses) 
      {
       if(!isset($data['grupoCer']['BONOCER'])){$data['grupoCer']['BONOCER']=new \stdclass;}
                 $select='select (sum(cantidad)) as monto from promobono where anio='.$anioActual.' and mes='.$keyMeses.' and canal="coorporativo"';
          $datos=$this->db->query($select)->result();
          if(count($datos)==0)
          {
            $data['grupoCer']['BONOCER']->anioActual[$keyMeses]=new \stdclass;
            $data['grupoCer']['BONOCER']->anioActual[$keyMeses]->anio=$anioActual;
            $data['grupoCer']['BONOCER']->anioActual[$keyMeses]->monto=0;
            $data['grupoCer']['BONOCER']->anioActual[$keyMeses]->mes=$keyMeses;
            $data['grupoCer']['BONOCER']->anioActual[$keyMeses]->idGrupoCer=100;
          }
          else{$data['grupoCer']['BONOCER']->anioActual[$keyMeses]=$datos[0];}

          $select='select (sum(cantidad)) as monto from promobono where anio='.$anioAnterior.' and mes='.$keyMeses.' and canal="coorporativo"';
          $datos=$this->db->query($select)->result();


          if(count($datos)==0)
          {
            $data['grupoCer']['BONOCER']->anioAnterior[$keyMeses]=new \stdclass;
            $data['grupoCer']['BONOCER']->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['grupoCer']['BONOCER']->anioAnterior[$keyMeses]->monto=0;
            $data['grupoCer']['BONOCER']->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['grupoCer']['BONOCER']->anioAnterior[$keyMeses]->idGrupoCer=100;
          }
          else{$data['grupoCer']['BONOCER']->anioAnterior[$keyMeses]=$datos[0];}
      }
  
  //======================================================================================
  //===========================  PARA EL COSTO DE VENTA ==================================
    foreach ($costoVentaCatalogo as $key => $value) 
  {
    if(!isset($data['costoVenta'][$value->etiquetaNombre])){$data['costoVenta'][$value->etiquetaNombre]=new \stdclass;}
    
          foreach ($data['meses'] as $keyMeses => $meses) 
      {
          switch ($value->idAvanceCostoVenta) 
          {
            case 1:
          $select='select * from avaces_primas_pagadas_costoventa where anio='.$anioActual.' and mes='.$keyMeses.' and idAvanceCostoVenta='.$value->idAvanceCostoVenta;
          $datos=$this->db->query($select)->result();
          $select='select * from avaces_primas_pagadas_costoventa where anio='.$anioAnterior.' and mes='.$keyMeses.' and idAvanceCostoVenta='.$value->idAvanceCostoVenta;
          $datosAnterior=$this->db->query($select)->result();

              break;
            case 4:
          $select='select (if(sum(totalfactura) is null,0,sum(totalfactura))) as monto from facturas f where f.idCuentaContableInicial=1151 and year(f.fecha_pago)='.$anioActual.' and month(f.fecha_pago)='.$keyMeses;
          $datos=$this->db->query($select)->result();
          $datos[0]->anio=$anioActual;
          $datos[0]->mes=$keyMeses;
          $datos[0]->idAvanceCostoVenta=1151;
          $select='select (if(sum(totalfactura) is null,0,sum(totalfactura))) as monto from facturas f where f.idCuentaContableInicial=1151 and year(f.fecha_pago)='.$anioAnterior.' and month(f.fecha_pago)='.$keyMeses;
          $datosAnterior=$this->db->query($select)->result();
          $datosAnterior[0]->anio=$anioAnterior;
          $datosAnterior[0]->mes=$keyMeses;
          $datosAnterior[0]->idAvanceCostoVenta=1151;
            break; 
            default:
              $datos=array();
              $datosAnterior=array();
              break;
          }
          
          if(count($datos)==0)          
          {
            $data['costoVenta'][$value->etiquetaNombre]->anioActual[$keyMeses]=new \stdclass;
            $data['costoVenta'][$value->etiquetaNombre]->anioActual[$keyMeses]->anio=$anioActual;
            $data['costoVenta'][$value->etiquetaNombre]->anioActual[$keyMeses]->monto=0;
            $data['costoVenta'][$value->etiquetaNombre]->anioActual[$keyMeses]->mes=$keyMeses;
            $data['costoVenta'][$value->etiquetaNombre]->anioActual[$keyMeses]->idAvanceCostoVenta=$value->idAvanceCostoVenta;
          }
          else{$data['costoVenta'][$value->etiquetaNombre]->anioActual[$keyMeses]=$datos[0];}

          #$select='select * from avance_primas_pagadas_cer where anio='.$anioAnterior.' and mes='.$keyMeses.' and idGrupoCer='.$value->idGrupoCer;
          #$datos=$this->db->query($select)->result();


          if(count($datosAnterior)==0)
          {
            $data['costoVenta'][$value->etiquetaNombre]->anioAnterior[$keyMeses]=new \stdclass;
            $data['costoVenta'][$value->etiquetaNombre]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['costoVenta'][$value->etiquetaNombre]->anioAnterior[$keyMeses]->monto=0;
            $data['costoVenta'][$value->etiquetaNombre]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['costoVenta'][$value->etiquetaNombre]->anioAnterior[$keyMeses]->idGrupoCer=$value->idAvanceCostoVenta;
          }
          else{$data['costoVenta'][$value->etiquetaNombre]->anioAnterior[$keyMeses]=$datosAnterior[0];}

           
          //$data['grupoCer'][$value->etiquetaNombreGrupo]->anioActual[$keyMeses]=$datos;
      }
    
    //$data['grupoCer'][$value->etiquetaNombreGrupo]->anioAnterior;
  }
  //======================================================================================
  //==========================  PARA GASTOS DE OPERACION ================================
  
  

  foreach ($gastosOperacionAlterno as $key => $value) 
  {       
        $idCCAgrupadas='';$filtroCC=''; $labelCC='';
     $cuentas=$this->db->query('select c.*,r.cuentaContable from cuentascontablesgruporelacion c left join relcuentacontabledepartamento r on r.idCuentaContable=c.idCuentaContable where c.idCuentaContableGrupo='.$value->idCuentaContableGrupos)->result();
        foreach ($cuentas as $cuentasVal) {$idCCAgrupadas.=$cuentasVal->idCuentaContableInicial.',';$labelCC.=$cuentasVal->cuentaContable.',';}
        if($idCCAgrupadas!='')
        {
          $filtroCC = substr($idCCAgrupadas, 0, -1);
          $labelCC = substr($labelCC, 0, -1);
          
        }
          //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($filtroCC.',',true));fclose($fp);
        
       if(!isset($data['gastosOperacion'][$value->cuentaContableGrupos])){$data['gastosOperacion'][$value->cuentaContableGrupos]=new \stdclass;}
$data['gastosOperacion'][$value->cuentaContableGrupos]->cuentasContableName=$labelCC;
       foreach ($data['meses'] as $keyMeses => $meses)  
       {
        $label='';
        
        $montoPresupuestoReal=$this->db->query('select (if(if(count(monto=0),0,monto) is null,0,monto)) as monto from cuentacontablegrupospresupuesto where mes='.$keyMeses.' and anio='.$anioActual.' and idCuentaContableGrupos='.$value->idCuentaContableGrupos)->result()[0]->monto;

        if($filtroCC!='')
          {
            $select='select (if(sum(f.totalconiva) is null,0,sum(f.totalconiva))) as monto from facturas f where  f.idCuentaContableInicial in ('.$filtroCC.') and year(f.fecha_pago)='.$anioActual.' and month(f.fecha_pago)='.$keyMeses;
            $datosActual=$this->db->query($select)->result()[0]->monto;

            $select='select (if(sum(f.totalconiva) is null,0,sum(f.totalfactura))) as monto from facturas f where f.idCuentaContableInicial  in ('.$filtroCC.') and year(f.fecha_pago)='.$anioAnterior.' and month(f.fecha_pago)='.$keyMeses;

        


            $datosAnterior=$this->db->query($select)->result()[0]->monto;

            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]=new \stdclass;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->anio=$anioActual;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->monto=$datosActual;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->mes=$keyMeses;  
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->idCuentaContable=$value->idCuentaContable;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->montoPresupuestoReal=$montoPresupuestoReal;

            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]=new \stdclass;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->monto=$datosAnterior;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->idGrupoCer=$value->idCuentaContable;
          }
          else
          {
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]=new \stdclass;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->anio=$anioActual;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->monto=0;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->mes=$keyMeses;  
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->idCuentaContable=$value->idCuentaContable;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->montoPresupuestoReal=0;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]=new \stdclass;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->monto=0;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['gastosOperacion'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->idGrupoCer=$value->idCuentaContable;

          }
       }                                                                                                                }
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data['gastosOperacion'],true));fclose($fp);
//=====================================================================================
//===========================================  GASTOS VARIABLES========================
  foreach ($gastosVariablesAlterno as $key => $value) 
  {
        $idCCAgrupadas='';$filtroCC=''; $labelCC='';
     $cuentas=$this->db->query('select c.*,r.cuentaContable from cuentascontablesgruporelacion c left join relcuentacontabledepartamento r on r.idCuentaContable=c.idCuentaContable where c.idCuentaContableGrupo='.$value->idCuentaContableGrupos)->result();
        foreach ($cuentas as $cuentasVal) {$idCCAgrupadas.=$cuentasVal->idCuentaContableInicial.',';$labelCC.=$cuentasVal->cuentaContable.',';}
        if($idCCAgrupadas!='')
        {
          $filtroCC = substr($idCCAgrupadas, 0, -1);
          $labelCC = substr($labelCC, 0, -1);
          
        }
          //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($filtroCC.',',true));fclose($fp);
        
       if(!isset($data['gastosVariables'][$value->cuentaContableGrupos])){$data['gastosVariables'][$value->cuentaContableGrupos]=new \stdclass;}
$data['gastosVariables'][$value->cuentaContableGrupos]->cuentasContableName=$labelCC;
       foreach ($data['meses'] as $keyMeses => $meses)  
       {
        $label='';
        
        $montoPresupuestoReal=$this->db->query('select (if(if(count(monto=0),0,monto) is null,0,monto)) as monto from cuentacontablegrupospresupuesto where mes='.$keyMeses.' and anio='.$anioActual.' and idCuentaContableGrupos='.$value->idCuentaContableGrupos)->result()[0]->monto;

        if($filtroCC!='')
          {
            $select='select (if(sum(f.totalfactura) is null,0,sum(f.totalfactura))) as monto from facturas f where  f.idCuentaContableInicial in ('.$filtroCC.') and year(f.fecha_pago)='.$anioActual.' and month(f.fecha_pago)='.$keyMeses;
            $datosActual=$this->db->query($select)->result()[0]->monto;

            $select='select (if(sum(f.totalfactura) is null,0,sum(f.totalfactura))) as monto from facturas f where f.idCuentaContableInicial  in ('.$filtroCC.') and year(f.fecha_pago)='.$anioAnterior.' and month(f.fecha_pago)='.$keyMeses;

        


            $datosAnterior=$this->db->query($select)->result()[0]->monto;

            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]=new \stdclass;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->anio=$anioActual;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->monto=$datosActual;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->mes=$keyMeses;  
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->idCuentaContable=$value->idCuentaContable;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->montoPresupuestoReal=$montoPresupuestoReal;

            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]=new \stdclass;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->monto=$datosAnterior;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->idGrupoCer=$value->idCuentaContable;
          }
          else
          {
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]=new \stdclass;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->anio=$anioActual;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->monto=0;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->mes=$keyMeses;  
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->idCuentaContable=$value->idCuentaContable;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->montoPresupuestoReal=0;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]=new \stdclass;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->monto=0;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['gastosVariables'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->idGrupoCer=$value->idCuentaContable;

          }
       }  }

//===========================================  GASTOS FINANCIEROS========================
//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($gastosFinancieros, TRUE));fclose($fp);
  foreach ($gastosFinancieros as $key => $value) 
  {       
    $idCCAgrupadas='';$filtroCC='';$labelCC='';
     $cuentas=$this->db->query('select c.*,r.cuentaContable from cuentascontablesgruporelacion c left join relcuentacontabledepartamento r on r.idCuentaContable=c.idCuentaContable where c.idCuentaContableGrupo='.$value->idCuentaContableGrupos)->result();
        foreach ($cuentas as $cuentasVal) {$idCCAgrupadas.=$cuentasVal->idCuentaContableInicial.',';$labelCC.=$cuentasVal->cuentaContable.',';}
        if($idCCAgrupadas!='')
        {$filtroCC = substr($idCCAgrupadas, 0, -1);
          $labelCC = substr($labelCC, 0, -1);          
        }
       if(!isset($data['gastosFinancieros'][$value->cuentaContableGrupos])){$data['gastosFinancieros'][$value->cuentaContableGrupos]=new \stdclass;}
$data['gastosFinancieros'][$value->cuentaContableGrupos]->cuentasContableName=$labelCC;
       foreach ($data['meses'] as $keyMeses => $meses)  
       {
        $label='';
        
        $montoPresupuestoReal=$this->db->query('select (if(if(count(monto=0),0,monto) is null,0,monto)) as monto from cuentacontablegrupospresupuesto where mes='.$keyMeses.' and anio='.$anioActual.' and idCuentaContableGrupos='.$value->idCuentaContableGrupos)->result()[0]->monto;

        if($filtroCC!='')
          {
            $select='select (if(sum(f.totalconiva) is null,0,sum(f.totalconiva))) as monto from facturas f where  f.idCuentaContableInicial in ('.$filtroCC.') and year(f.fecha_pago)='.$anioActual.' and month(f.fecha_pago)='.$keyMeses;
            $datosActual=$this->db->query($select)->result()[0]->monto;

            $select='select (if(sum(f.totalconiva) is null,0,sum(f.totalfactura))) as monto from facturas f where f.idCuentaContableInicial  in ('.$filtroCC.') and year(f.fecha_pago)='.$anioAnterior.' and month(f.fecha_pago)='.$keyMeses;

        


            $datosAnterior=$this->db->query($select)->result()[0]->monto;

            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]=new \stdclass;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->anio=$anioActual;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->monto=$datosActual;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->mes=$keyMeses;  
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->idCuentaContable=$value->idCuentaContable;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->montoPresupuestoReal=$montoPresupuestoReal;

            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]=new \stdclass;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->monto=$datosAnterior;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->idGrupoCer=$value->idCuentaContable;
          }
          else
          {
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]=new \stdclass;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->anio=$anioActual;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->monto=0;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->mes=$keyMeses;  
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->idCuentaContable=$value->idCuentaContable;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->montoPresupuestoReal=0;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]=new \stdclass;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->monto=0;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['gastosFinancieros'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->idGrupoCer=$value->idCuentaContable;

          }
    //
  }
}

//=================================================================================
//===========================================  GASTOS IMPUESTOS========================
//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($gastosFinancieros, TRUE));fclose($fp);
  foreach ($gastosImpuestos as $key => $value) 
  {
    $idCCAgrupadas='';$filtroCC='';$labelCC='';
     $cuentas=$this->db->query('select c.*,r.cuentaContable from cuentascontablesgruporelacion c left join relcuentacontabledepartamento r on r.idCuentaContable=c.idCuentaContable where c.idCuentaContableGrupo='.$value->idCuentaContableGrupos)->result();
        foreach ($cuentas as $cuentasVal) {$idCCAgrupadas.=$cuentasVal->idCuentaContableInicial.',';$labelCC.=$cuentasVal->cuentaContable.',';}
        if($idCCAgrupadas!='')
        {$filtroCC = substr($idCCAgrupadas, 0, -1);
          $labelCC = substr($labelCC, 0, -1);          
        }
       if(!isset($data['gastosImpuestos'][$value->cuentaContableGrupos])){$data['gastosImpuestos'][$value->cuentaContableGrupos]=new \stdclass;}
$data['gastosImpuestos'][$value->cuentaContableGrupos]->cuentasContableName=$labelCC;
       foreach ($data['meses'] as $keyMeses => $meses)  
       {
        $label='';
        
        $montoPresupuestoReal=$this->db->query('select (if(if(count(monto=0),0,monto) is null,0,monto)) as monto from cuentacontablegrupospresupuesto where mes='.$keyMeses.' and anio='.$anioActual.' and idCuentaContableGrupos='.$value->idCuentaContableGrupos)->result()[0]->monto;

        if($filtroCC!='')
          {
            $select='select (if(sum(f.totalconiva) is null,0,sum(f.totalconiva))) as monto from facturas f where  f.idCuentaContableInicial in ('.$filtroCC.') and year(f.fecha_pago)='.$anioActual.' and month(f.fecha_pago)='.$keyMeses;
            $datosActual=$this->db->query($select)->result()[0]->monto;

            $select='select (if(sum(f.totalconiva) is null,0,sum(f.totalfactura))) as monto from facturas f where f.idCuentaContableInicial  in ('.$filtroCC.') and year(f.fecha_pago)='.$anioAnterior.' and month(f.fecha_pago)='.$keyMeses;

            $datosAnterior=$this->db->query($select)->result()[0]->monto;

            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]=new \stdclass;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->anio=$anioActual;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->monto=$datosActual;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->mes=$keyMeses;  
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->idCuentaContable=$value->idCuentaContable;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->montoPresupuestoReal=$montoPresupuestoReal;

            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]=new \stdclass;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->monto=$datosAnterior;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->idGrupoCer=$value->idCuentaContable;
          }
          else
          {
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]=new \stdclass;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->anio=$anioActual;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->monto=0;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->mes=$keyMeses;  
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->idCuentaContable=$value->idCuentaContable;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioActual[$keyMeses]->montoPresupuestoReal=0;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]=new \stdclass;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->anio=$anioActual;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->monto=0;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->mes=$keyMeses;
            $data['gastosImpuestos'][$value->cuentaContableGrupos]->anioAnterior[$keyMeses]->idGrupoCer=$value->idCuentaContable;

          }
    //
  }
  }


//=================================================================================






  $data['anioActual']=$anioActual;
  $data['anioAnterior']=$anioAnterior;
  $this->load->view('presupuestos/reporteDetalleBancos',$data);
}
//------------------------------------------

}
