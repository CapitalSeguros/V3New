<?php
session_start();
//include('../config/config.php');
include('../includes/funcionesDre.php');
require('../fdpf/fpdf.php');

extract($_REQUEST);

$conexion = DreConectarDB();

function vendedorNombre($idVendedor){
	$sqlVendedor = "
		Select * From `usuarios` Where `CLAVE` = '$idVendedor'
						  ";
	$resVendedor = DreQueryDB($sqlVendedor);
	$rowVendedor = mysql_fetch_assoc($resVendedor);
	
	return
		
		$rowVendedor['NOMBRE'];
}

$sqlClientes = 	"
		Select 
			*
			,`empresas`.`RAZON_SOCIAL` As `prospecto`
			,`empresas`.`VENDEDOR` As `vendedor`
		From 
				`empresas` 
			Inner Join 
				`contactos` 
					On 
						`empresas`.`CLAVE` 
							=
						`contactos`.`CLAVE` 
		Where
				`empresas`.`TIPO_REGISTRO` = 'PR'
			And
				`empresas`.`VENDEDOR` Like '%$vendedor%'

		Group By 
			`empresas`.`CLAVE`
					";
$resClientes = DreQueryDB($sqlClientes);

class PDF extends FPDF
{
//Cabecera de página
function Header()
{
    //Logo
    $this->Image('../img/capsys.jpg',130,5,50);
	//Título
    $this->SetFont('Arial','B',22);
    $this->Cell(110,25,'Reporte de Prospectos',0,0,0);
	
	//Salto de línea	
	


$this->Ln();
    $this->SetFont('Arial','B',8);
	$this->SetTextColor(255,255,255);
			
	$this->Cell(50,5,'PROSPECTO',1,0,1,1);
	$this->Cell(35,5,'VENDEDOR',1,0,1,1);
	$this->Cell(25,5,'FECHA A.',1,0,1,1);
	$this->Cell(30,5,'TELEFONO',1,0,1,1);
	$this->Cell(30,5,'EMAIL',1,0,1,1);
	$this->Cell(25,5,'PROSPECTO?',1,0,1,1);

	
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
while($rowClientes = mysql_fetch_assoc($resClientes)){
	
$pdf->SetFont('Arial','',5);
$y = $pdf->GetY();
$pdf->MultiCell(50,3,strtoupper($rowClientes['prospecto']),0,'L',0);
$pdf->SetXY(55,$y);
$pdf->MultiCell(35,3,strtoupper(vendedorNombre($rowClientes['vendedor'])),0,'L',0);
$pdf->SetXY(90,$y);
$pdf->MultiCell(25,3,strtoupper($rowClientes['fechaCreacion']),0,'L',0);
$pdf->SetXY(115,$y);
$pdf->MultiCell(30,3,strtoupper($rowClientes['TELEFONO_PARTICULAR']),0,'L',0);
$pdf->SetXY(145,$y);
$pdf->MultiCell(30,3,strtoupper($rowClientes['EMAIL']),0,'L',0);
$pdf->SetXY(175,$y);
$pdf->MultiCell(35,3,($rowClientes['TIPO_REGISTRO'] == "PR")? "PROSPECTO" : "CLIENTE",0,'L',0);
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