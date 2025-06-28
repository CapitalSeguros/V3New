<?php
session_start();
extract($_REQUEST);
	if(!isset($_SESSION['WebDreTacticaWeb'])){ header("Location: index.php"); }
include('../includes/funcionesDre.php');
require('../fdpf/fpdf.php');
$conexion = DreConectarDB();

$sqlSemaforoActividades = 	"
	Select 
		`usuarios`.`NOMBRE` As `usuario`
		,`actividades`.`recId` As `idActividad`
		,`actividades`.`actividadInterno`
		,`actividades`.`actividad`
		,`semactividad`.`semaforo`
	From 
		`usuarios` Inner Join `semactividad` 
		On
		`usuarios`.`VALOR` = `semactividad`.`usuario`  Inner Join `actividades`
		On 
		`semactividad`.`idActividad` = `actividades`.`idInterno`
	Where
		`usuarios`.`TIPO` Like '%$TIPO%'
		And
		`semactividad`.`usuario` Like '%$usuario%'
		And
		`semactividad`.`semaforo` Like '%$semaforo%'
		And
		`actividades`.`actividadInterno` Like '%$actividad%'
					";
$resSemaforoActividades = DreQueryDB($sqlSemaforoActividades);

class PDF extends FPDF
{
//Cabecera de página
function Header()
{
    //Logo
    $this->Image('../img/capsys.jpg',130,5,50);
	//Título
    $this->SetFont('Arial','B',22);
    $this->Cell(110,25,'Reporte Semaforo Actividades',0,0,0);
	
	//Salto de línea	
	


$this->Ln();
    $this->SetFont('Arial','B',8);
	$this->SetTextColor(255,255,255);
			
	$this->Cell(90,5,'Usuario',1,0,1,1);
	$this->Cell(30,5,'Actividad',1,0,1,1);
	$this->Cell(40,5,'Tipo Tarea',1,0,1,1);
	$this->Cell(20,5,'Semaforo',1,0,1,1);
	$this->Cell(10,5,'',1,0,1,1);

	
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
$pdf->SetFont('Arial','',4);
while($rowSemaforoActividades = mysql_fetch_assoc($resSemaforoActividades)){
$y = $pdf->GetY();
$pdf->MultiCell(90,3,strtoupper($rowSemaforoActividades['usuario']),0,'L',0);
$pdf->SetXY(99,$y);
$pdf->MultiCell(30,3,strtoupper($rowSemaforoActividades['idActividad']),0,'L',0);
$pdf->SetXY(115,$y);
$pdf->MultiCell(40,3,strtoupper(urldecode($rowSemaforoActividades['actividad'])),0,'L',0);
$pdf->SetXY(165,$y);
$pdf->MultiCell(20,3,strtoupper($rowSemaforoActividades['semaforo']),0,'C',0);
$pdf->Ln();
$pdf->MultiCell(190,0,'',0,'J','1');
} // Fin while

// Imprecion y Cierre de Pie de Pagina 
$pdf->AliasNbPages();
$pdf->SetFont('Times','',12);
$pdf->Output();

DreDesconectarDB($conexion);
?>