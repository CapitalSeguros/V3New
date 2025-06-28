<?php
session_start();
//include('../config/config.php');
include('../includes/funcionesDre.php');
require('../fdpf/fpdf.php');

extract($_REQUEST);


function Paquete($idActividad){
	$sqlConsultaPaquete = "
		Select * From `actividades_formularios` Where `idActividad` = '$idActividad'
						  ";
	$resConsultaPaquete = DreQueryDB($sqlConsultaPaquete);
	$rowConsultaPaquete = mysql_fetch_assoc($resConsultaPaquete);
	
	return
		
		$rowConsultaPaquete['cobertura_auto'];
}

$conexion = DreConectarDB();
$sqlCotizaciones = 	"
		Select 
			*
			,`actividades`.`recId` As `idActividad`
			,`usuarios`.`NOMBRE` As `vendedor`
			,DATEDIFF(`fechaTermino`,`fechaProgramada`) As `calculoDias`
			,`empresas`.`RAZON_SOCIAL` As `nombreCliente`
		From 
				`usuarios` 
			Inner Join 
				`actividades` 
					On 
						`usuarios`.`CLAVE` 
							=
						`actividades`.`usuario` 
			Inner Join 
				`empresas` 
					On 
						`actividades`.`idRef` 
							= 
						`empresas`.`CLAVE` 
			Inner Join 
				`contactos` 
					On 
						`empresas`.`CLAVE` 
							= 
						`contactos`.`CLAVE`
		Where
				`actividades`.`actividadInterno` = 'Cotizaci%F3n'
			And			
				`actividades`.`idRef` Like '%$cliente%'
			And
				`actividades`.`usuario` Like '%$responsable%'
			And 
				`actividades`.`ramoInterno` Like '%$ramo%'
			And 
				`actividades`.`cotizacionEmision` Like '%$emitidas%'
			And 
				`actividades`.`aseguradoraUno` Like '%$aseguradora%'
			And 
				`actividades`.`fechaProgramada` Like '%$fechaProgramadaCotizaciones%'
			And 
				`actividades`.`fechaTermino` Like '%$fechaTerminoCotizaciones%'
		Group By 
			`recId`
					";
$resCotizaciones = DreQueryDB($sqlCotizaciones);

class PDF extends FPDF
{
//Cabecera de página
function Header()
{
    //Logo
    $this->Image('../img/capsys.jpg',130,5,50);
	//Título
    $this->SetFont('Arial','B',22);
    $this->Cell(110,25,'Reporte de Cotizaciones',0,0,0);
	
	//Salto de línea	
	


$this->Ln();
    $this->SetFont('Arial','B',8);
	$this->SetTextColor(255,255,255);
			
	$this->Cell(32,5,'CLIENTE',1,0,1,1);
	$this->Cell(23,5,'VENDEDOR',1,0,1,1);
	$this->Cell(25,5,'RAMO',1,0,1,1);
	$this->Cell(15,5,'EMITIDA',1,0,1,1);
	$this->Cell(20,5,'PAQUETE',1,0,1,1);
	$this->Cell(15,5,'FECHA S.',1,0,1,1);
	$this->Cell(15,5,'FECHA T.',1,0,1,1);
	$this->Cell(25,5,'C'.utf8_decode('Á').'LCULO D'.utf8_decode('Í').'AS',1,0,1,1);
	$this->Cell(25,5,'ASEGURADORA',1,0,1,1);
	
$this->Ln();
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-19);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	$this->Ln();
	$this->MultiCell(0,5,'Fecha de Impresi'.utf8_decode('ó').'n: '.date('d-m-Y'),0,'J',0);
}
}
#Creamos el objeto pdf (con medidas en milímetros): 
$pdf=new PDF('P', 'mm', 'A4');

#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(5, 5 , 5); 

#Establecemos el margen inferior: 
//$pdf->SetAutoPageBreak(true,25);  

$pdf->AddPage();

// Inico Impresion Tabla de Cuerpo
while($rowCotizaciones = mysql_fetch_assoc($resCotizaciones)){
	
$pdf->SetFont('Arial','',4);
$y = $pdf->GetY();
$pdf->MultiCell(32,3,strtoupper($rowCotizaciones['nombreCliente']),0,'L',0);
$pdf->SetXY(37,$y);
$pdf->MultiCell(23,3,strtoupper($rowCotizaciones['vendedor']),0,'L',0);
$pdf->SetXY(60,$y);
$pdf->MultiCell(25,3,strtoupper(urldecode($rowCotizaciones['ramoInterno'])),0,'L',0);
$pdf->SetXY(85,$y);
$pdf->MultiCell(15,3,($rowCotizaciones['cotizacionEmision'] == "0")? "SI" : "NO",0,'C',0);
$pdf->SetXY(100,$y);
$pdf->MultiCell(20,3,strtoupper(Paquete($rowCotizaciones['idActividad'])),0,'C',0);
$pdf->SetXY(120,$y);
$pdf->MultiCell(15,3,strtoupper($rowCotizaciones['fechaProgramada']),0,'C',0);
$pdf->SetXY(135,$y);
$pdf->MultiCell(15,3,strtoupper($rowCotizaciones['fechaTermino']),0,'C',0);
$pdf->SetXY(150,$y);
$pdf->MultiCell(25,3,strtoupper($rowCotizaciones['calculoDias']),0,'C',0);
$pdf->SetXY(175,$y);
$pdf->MultiCell(25,3,strtoupper($rowCotizaciones['aseguradoraUno']),0,'J',0);
$y = $pdf->GetY();
$pdf->Ln();
$pdf->MultiCell(195,0,'',0,'J','1');
$pdf->Ln();
} // Fin while


// Imprecion y Cierre de Pie de Pagina 
$pdf->AliasNbPages();
$pdf->SetFont('Times','',12);
$pdf->Output();

DreDesconectarDB($conexion);
?>