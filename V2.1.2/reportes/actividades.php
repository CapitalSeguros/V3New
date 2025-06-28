<?php
session_start();
//include('../config/config.php');
include('../includes/funcionesDre.php');
require('../fdpf/fpdf.php');

extract($_REQUEST);

$conexion = DreConectarDB();

$sqlActividades = 	"
		Select 
			*
			,`usuarios`.`NOMBRE` As `responsable`
			,DATEDIFF(`fechaTermino`,`fechaProgramada`) As `calculoDias`
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
				`actividades`.`actividad` Like '%$tipoActividad%'
			And
				`actividades`.`usuario` Like '%$responsable%'
			And 
				`actividades`.`fin` Like '%$status%'
			And 
				`actividades`.`Resultado` Like '%$resultado%'
			And 
				`actividades`.`aseguradoraUno` Like '%$aseguradora%'
			And 
				`actividades`.`fechaProgramada` Like '%$fechaProgramadaActividades%'
			And 
				`actividades`.`fechaTermino` Like '%$fechaTerminoActividades%'
		Group By 
			`recId`
					";
$resActividades = DreQueryDB($sqlActividades);

class PDF extends FPDF
{
//Cabecera de página
function Header()
{
    //Logo
    $this->Image('../img/capsys.jpg',130,5,50);
	//Título
    $this->SetFont('Arial','B',22);
    $this->Cell(110,25,'Reporte de Actividades',0,0,0);
	
	//Salto de línea	
	


$this->Ln();
    $this->SetFont('Arial','B',8);
	$this->SetTextColor(255,255,255);
			
	$this->Cell(25,5,'TIPO ACTIVIDAD',1,0,1,1);
	$this->Cell(23,5,'RESPONSABLE',1,0,1,1);
	$this->Cell(15,5,'FECHA S.',1,0,1,1);
	$this->Cell(15,5,'FECHA T.',1,0,1,1);
	$this->Cell(25,5,'C'.utf8_decode('Á').'LCULO D'.utf8_decode('Í').'AS',1,0,1,1);
	$this->Cell(15,5,'ESTATUS',1,0,1,1);
	$this->Cell(25,5,'ASEGURADORA',1,0,1,1);
	$this->Cell(20,5,'RESULTADO',1,0,1,1);
	$this->Cell(32,5,'COMENTARIO RES.',1,0,1,1);
	
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
while($rowActividades = mysql_fetch_assoc($resActividades)){
	
$pdf->SetFont('Arial','',4);
$y = $pdf->GetY();
$pdf->MultiCell(25,3,strtoupper($rowActividades['actividad']),0,'L',0);
$pdf->SetXY(30,$y);
$pdf->MultiCell(23,3,strtoupper($rowActividades['responsable']),0,'L',0);
$pdf->SetXY(53,$y);
$pdf->MultiCell(15,3,strtoupper($rowActividades['fechaProgramada']),0,'C',0);
$pdf->SetXY(68,$y);
$pdf->MultiCell(15,3,strtoupper($rowActividades['fechaTermino']),0,'C',0);
$pdf->SetXY(83,$y);
$pdf->MultiCell(25,3,strtoupper($rowActividades['calculoDias']),0,'C',0);
$pdf->SetXY(108,$y);
$pdf->MultiCell(15,3,($rowActividades['fin'] == 0)? "PENDIENTE" : "TERMINADA",0,'C',0);
$pdf->SetXY(123,$y);
$pdf->MultiCell(25,3,strtoupper($rowActividades['aseguradoraUno']),0,'C',0);
$pdf->SetXY(148,$y);
$pdf->MultiCell(20,3,$rowActividades['Resultado'],0,'C',0);
$pdf->SetXY(168,$y);
$pdf->MultiCell(32,3,$rowActividades['comenResultado'],0,'J',0);
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