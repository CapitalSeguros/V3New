<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Asistencias extends CI_Controller{
	private $quitarSicas = array('<p>', '</p>', '<br />', ',');
	private $ponerSicas = array('', '', '\n\r', '');
	
	function __construct(){
		parent::__construct();
			
			$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
			$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
			$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
			$this->load->library('Ws_sicasdre',$params);
            $this->load->library('PHPExcel-1.8/Classes/PHPExcel');
			$this->load->helper('ckeditor');
				//$this->load->library;
			//$this->load->model('capsysdre_actividades');
	}

//----------------------------------------------------------------------------------------------------
		
	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			/*$fp = fopen('resultadoJason.txt', 'w');
                  fwrite($fp, print_r($_POST['file_upload'], TRUE));
                   fclose($fp);

     unset($_POST);*/
	/*	if(isset($_POST	['file_upload'])==""){
$fp = fopen('resultadoJason.txt', 'w');
                  fwrite($fp, print_r("b", TRUE));
                   fclose($fp);

		}  
		else
		{
			                  
                  $fp = fopen('resultadoJason.txt', 'w');
                  fwrite($fp, print_r("h", TRUE));
                   fclose($fp);

		}*/
$this->load->view('asistencia/asistencia');
		}

}

//---------------------------------------------------------------------------------------------------------

 function cargar_archivo() {
	

	//if($_POST['anio'])
if($_POST['password']=="agentecapital"){
	if($_POST['anio']>2000){
	
 	$data;
     $extension=explode(".", $_FILES['mi_archivo']['name']);
     $largo=count($extension);

if($extension[$largo-1]=='XLS' || $extension[$largo-1]=='xls' || $extension[$largo-1]=='xlsx' || $extension[$largo-1]=='xlsm' || $extension[$largo-1]=='xls' || $extension[$largo-1]=='XLSM' || $extension[$largo-1]=='XLSM'){
       $nuevoNombre=$_POST['anio']."-".$_POST['mes'];
        $mi_archivo = 'mi_archivo';
        $config['upload_path'] = "guarda/";
        $config['file_name'] = $nuevoNombre;
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";
        $config['max_width'] = "2000";
           $config['overwrite'] = "TRUE";
       // $config['allowed_types'] = "xlsx|xlsm|xls|XLS|XLSM|XLSX";
        $config['max_height'] = "2000";  
        $this->load->library('upload', $config);        
        if (!$this->upload->do_upload($mi_archivo)) 
        {
            $data['uploadError'] = $this->upload->display_errors();
            echo $this->upload->display_errors();
            return;
        }
        //$data['uploadSuccess'] = $this->upload->data();
	$data['mensaje']="Archivo procesado con exito";
}
else{
	$data['mensaje']="El formato no es valido";
}

}
else
{
	$data['mensaje']="El año es incorrecto";
}
}
else{$data['mensaje']="Contraseña no valida";}

        /*$mi_archivo = 'mi_archivo';
        $config['upload_path'] = "guarda/";
        $config['file_name'] = "nombre_archivo";
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";
        $config['max_width'] = "2000";
       // $config['allowed_types'] = "xlsx|xlsm|xls|XLS|XLSM|XLSX";
        $config['max_height'] = "2000";

  

        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
            echo $this->upload->display_errors();
            return;
        }

        $data['uploadSuccess'] = $this->upload->data();*/
        $this->load->view('asistencia/asistencia',$data);
	}
	
//-----------------------------------------------------------------------------------------------------------------

function guardaExcel(){


foreach ($_FILES as $key)
{

			$fileName = $key['name'];
			$fileTmp = $key['tmp_name'];
			$fileSize = $key["size"];	
			$fileType = $key["type"]; 


  }
  move_uploaded_file($fileTmp, "../guarda/");
$this->load->view('asistencia/asistencia');
}

//------------------------------------------------------------------------------------------------------------

function devuelveExcel(){

	/*$fp = fopen('resultadoJason.txt', 'w');
	fwrite($fp, print_r($_REQUEST['folio'], TRUE));        
	fclose($fp);*/

//$archivo = "guarda/".$_REQUEST['parametros']['folio'];
$archivo = "guarda/".$_REQUEST['folio'];
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
$cadena="";
$cadena2="";

		
		$nombres[]="  TODOS";
$t=0;
for ($row = 10; $row <= $highestRow; $row++){ 
	//if($row<10){$clase="tdCabecera";}else{$clase="tdHijo";}
	$clase="tdHijo";
	$v=$sheet->getCell("C".$row)->getValue();
	if($v!=''){
		$t=$t+1;
$nombres[]=$v;}
         
  $cadena=$cadena.'<tr valign="top" class="'.($clase).'">';
		$cadena=$cadena."<td>".$sheet->getCell("A".$row)->getValue()."</td>";
		$cadena=$cadena."<td>".$sheet->getCell("B".$row)->getValue()."</td>";
		//$cadena=$cadena."<td>".$sheet->getCell("C".$row)->getValue()."</td>";
		$cadena=$cadena."<td>".$nombres[$t]."</td>";
		/*--------------------------------------------------------*/

		if($row>9){
						$timestamp = PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("D".$row)->getValue());
		$fecha_php = date("d-m-Y",$timestamp);

        $date_future = strtotime('+1 day', strtotime($fecha_php));

$date_future = date('d-m-Y ', $date_future);

		$cadena=$cadena."<td>". $date_future."</td>";		
		$timestamp = $sheet->getCell("E".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		$cadena=$cadena."<td>".$fecha_php."</td>";


$timestamp = $sheet->getCell("F".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		$cadena=$cadena."<td>".$fecha_php."</td>";
		


		$timestamp = $sheet->getCell("G".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		$cadena=$cadena."<td>".$fecha_php."</td>";



		$timestamp = $sheet->getCell("H".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		$cadena=$cadena."<td>".$fecha_php."</td>";

	    }
	  else{
	    	$cadena=$cadena. "<td>".$sheet->getCell("D".$row)->getValue()."</td>";        
	       $cadena=$cadena."<td>".$sheet->getCell("E".$row)->getValue()."</td>";
	    }

		$cadena=$cadena. "<td>".$sheet->getCell("I".$row)->getValue()."</td>";
		$cadena=$cadena."<td>".$sheet->getCell("J".$row)->getValue()."</td>";
		$cadena=$cadena."<td>".$sheet->getCell("K".$row)->getValue()."</td>";
		$cadena=$cadena."<td>".$sheet->getCell("L".$row)->getValue()."</td>";
		$cadena=$cadena."<td>".$sheet->getCell("M".$row)->getValue()."</td>";
		$cadena=$cadena."<td>".$sheet->getCell("N".$row)->getValue()."</td>";
		if(is_null($sheet->getCell("O".$row)->getValue())){
		$cadena=$cadena."<td>-</td>";			
		}
		else
		{$cadena=$cadena."<td>".$sheet->getCell("O".$row)->getValue()."</td>";}
		$cadena=$cadena."<td>".$sheet->getCell("P".$row)->getValue()."</td>";

 $cadena=$cadena."</tr>";
}
sort($nombres);
$lista="";
$lista="<button onclick='cerrarFiltrado(this)'>X</button><ul>";
for($i=0;$i<count($nombres);$i++)
{
  	$lista=$lista.'<li class="filtroNombre" onclick="filtraPorNombre(this.innerHTML)">'.$nombres[$i].'</li>';
}
$lista=$lista."</ul>";

		

$cadena=$cadena."</table>";


$cadena2=$cadena2.'<table border="2" id="tablaExcel" class="formatoTabla"><tr class="tdCabecera">';
		$cadena2=$cadena2."<td>".$sheet->getCell("A"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("B"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td><pre>".$sheet->getCell("C"."9")->getValue()."<button onclick='filtradoName(event)'>▼</button><div id='capaFiltradoName3' style='display:none; height:10px'>".$lista ."</div></pre></td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("D"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("E"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("F"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("G"."9")->getValue()."</td>";  
		$cadena2=$cadena2."<td>".$sheet->getCell("H"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("I"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("J"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("K"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("L"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("M"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("N"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("O"."9")->getValue()."</td>";
		$cadena2=$cadena2."<td>".$sheet->getCell("P"."9")->getValue()."</td></tr>";


$resultado['tabla']=$cadena2.$cadena;
//$resultado['nombres']=$nombres;
$resultado['nombres']=$lista;
//echo json_encode($cadena);
/*$fp = fopen('resultadoJason.txt', 'w');
	fwrite($fp, print_r($resultado['tabla'], TRUE));        
	fclose($fp);*/
echo json_encode($resultado);

    
}

//---------------------------------------------------------------------------------------------------------

 private function transforma(){
$archivo = "OCTUBRE COMPLETO.XLS";
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
echo('<table border="2">');
		echo "<td>".$sheet->getCell("A"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("B"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("C"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("D"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("E"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("F"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("G"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("H"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("I"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("J"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("K"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("L"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("M"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("N"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("O"."9")->getValue()."</td>";
		echo "<td>".$sheet->getCell("P"."9")->getValue()."</td>";
for ($row = 10; $row <= $highestRow; $row++){ 
  echo("<tr>");
		echo "<td>".$sheet->getCell("A".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("B".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("C".$row)->getValue()."</td>";
		/*--------------------------------------------------------*/

		if($row>11){
						$timestamp = PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("D".$row)->getValue());
		$fecha_php = date("d-m-Y",$timestamp);

        $date_future = strtotime('+1 day', strtotime($fecha_php));
//$date_now = date('d-m-Y');
//$date_future = strtotime('+30 day', strtotime($date_now));
$date_future = date('d-m-Y ', $date_future);

		echo"<td>". $date_future."</td>";
		
	//PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("E".$row)->getValue());
		$timestamp = $sheet->getCell("E".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		echo"<td>".$fecha_php."</td>";


$timestamp = $sheet->getCell("F".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		echo"<td>".$fecha_php."</td>";


		$timestamp = $sheet->getCell("G".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		echo"<td>".$fecha_php."</td>";



				$timestamp = $sheet->getCell("H".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		echo"<td>".$fecha_php."</td>";

	    }
	  else{
	    		echo "<td>".$sheet->getCell("D".$row)->getValue()."</td>";
        

		echo "<td>".$sheet->getCell("E".$row)->getValue()."</td>";
	    }

		/*$timestamp = $sheet->getCell("F".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		echo"<td>".$fecha_php."</td>";


		$timestamp = $sheet->getCell("G".$row)->getValue();
		$hora=intval($timestamp*24);
		$minutos=($timestamp*24)-$hora;
		$minutos=intval($minutos*60);
		$segundos=intval((((($timestamp*24)-$hora)*60)-$minutos)*60);
		$fecha_php = $hora.":".$minutos.":".$segundos;
		echo"<td>".$fecha_php."</td>";	*/


		//echo "<td>".$sheet->getCell("F".$row)->getValue()."</td>";
		//echo "<td>".$sheet->getCell("G".$row)->getValue()."</td>";
		//echo "<td>".$sheet->getCell("H".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("I".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("J".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("K".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("L".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("M".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("N".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("O".$row)->getValue()."</td>";
		echo "<td>".$sheet->getCell("P".$row)->getValue()."</td>";

 echo("</tr>");
}
echo("</table>");
}
}
?>