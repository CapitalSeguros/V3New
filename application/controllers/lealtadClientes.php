<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//require_once(dirname(__FILE__) . '\dompdf\autoload.inc');
class LealtadClientes extends CI_Controller{
var $datos	= array(); //"";
	function __construct(){
		parent::__construct();
			if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}
		$this->load->model('personamodelo');
		$this->load->model('clientelealtadmodelo');
	    $this->load->model('puntos_model');
      $this->load->model("preguntamodel");
	    $this->load->library('Ws_sicas'); 
	    $this->load->library('libreriav3'); 
		//$this->load->model('manejodocumento_modelo');
		//$this->load->library('serviciowebsicas');
        //$this->load->library('webservice_sicasdre'); 
       //$this->load->library('Ws_sicas');
       //$prueba;
    }

    
//------------------------------------------------------------------
function index(){

  $this->datos['idFormEnvio']=$this->libreriav3->numeroAleatorioHexadecimal(); 
   $this->datos['tablaAgentes']=$this->armaTablaAgentes($this->personamodelo->obtenerVendActivos(),'');                 	
   $this->datos['agentesClub']=$this->buscaAgentePromocion();
   $this->datos['ver'] = $this->puntos_model->ver();
    $this->datos['idPersona']=254;
   if(!isset($this->datos['puntosDeLosClientes'])){
     //$this->datos['puntosDeLosClientes']=$this->puntos_model->obtenerPuntosDeLosClientes(null);
     $this->datos['puntosDeLosClientes']=$this->puntos_model->obtenerPuntosDeLosClientes(254);
   }
   $this->datos['rankingCliente']=	$this->puntos_model->obtenerListaRanking();

$this->datos['primerDiaMes']=$this->libreriav3->convierteFecha($this->libreriav3->devolverPrimerDiaMesActual('/',''));
$this->datos['diaActual']=$this->libreriav3->convierteFecha($this->libreriav3->devolverFechaActual('/'));
//------------------------------------
	//Dennis Castillo [2021-08-03]
	$guiones = $this->preguntamodel->obtenerGuionTelefonico("club cap");
	$array_guion = array();

	if(!empty($guiones)){
		foreach($guiones as $d_g){

			$array_guion[$d_g->idNombre]["nombre"] = $d_g->nombre;
			$array_guion[$d_g->idNombre]["mensaje"][] = array("etiqueta" => $d_g->etiqueta, "texto" => $d_g->mensaje);
		}
	}
  //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($array_guion, TRUE));fclose($fp);
	$this->datos["guionTelefonico"] = $array_guion;
  //----------------------------------

   $this->load->view('lealtadClientes/lealtadClientes',$this->datos);
    	
}
 //----------------------------------------------------------------
 private function armaTablaAgentes($datos,$id){
    $personaTipoAgente=$this->personamodelo->obtenerTipoAgente();
    $ranking=$this->personamodelo->obtenerRankingAgente();
    $comboPTA="";
    $comboR="";
    $tabla='';
    $tabla=$tabla.'<thead><tr><th>id</th><th>Vendedor</th><th>Tipo Agente<br>'.$comboPTA.'</th><th>Ranking<br>'.$comboR.'</th><th>Asignado</th></tr></thead><tbody>';
    	foreach ($datos as  $value) {
    	  $tabla=$tabla.'<tr>';
          $tabla=$tabla.'<td>'.$value->idPersona.'</td>'; 
          $tabla=$tabla.'<td>'.$value->nombre.'</td>'; 
          $tabla=$tabla.'<td>'.$value->personaTipoAgente.'</td>'; 
          $tabla=$tabla.'<td>'.$value->idpersonarankingagente.'</td>';
          $tabla=$tabla.'<td><input type="checkbox" class="cbActivaPromo " id="'.$value->idPersona.'" onclick="activaPromocion(this)"></td>';
          

    	  $tabla=$tabla.'</tr>';
    	}
    	$tabla=$tabla.'</tbody>';
    	return $tabla;
}

//--------------------------------------------------------------
function guardaPromocionAgentes(){
    	$idPersona=explode(';',$_POST['idPersona']);    	
    	$this->clientelealtadmodelo->borrarPromocionAgente($_POST['idPunto']);
    
    	foreach ($idPersona as  $value) {
    		if($value!=""){
    		$datos['idPersonaP']=$value;
    		$datos['idPunto']=$_POST['idPunto'];
              $this->clientelealtadmodelo->guardarPromocionAgente($datos);
             }
    	}
    	$this->index();
    	//echo json_encode("Cambios con exito");     
}
//-------------------------------------------------------------
function buscaAgentePromocion(){   	
      $datos=$this->clientelealtadmodelo->buscaPromocionAgente(null);
       return $datos;
}
//---------------------------------------------
function obtenerClientesDeSicas(){
	$idVen=$this->personamodelo->obtenerIdVendedor($_POST['selectAgentesClub']);
	$respuesta=$this->ws_sicas->obtenerClientesPorVendedor($idVen[0]->IDVend,$_POST['nombreCliente']);
   $clientesPorAgente=array();
  // $respuesta=$this->ws_sicas->obtenerClientePorID(20810);
    
   $i=0;
  if(isset($respuesta->TableInfo)){
   foreach ($respuesta->TableInfo as $key => $value) {
    $clientesPorAgente[$i]['IDCli']=(string)$value->IDCli[0];
    $clientesPorAgente[$i]['NombreCompleto']=(string)$value->NombreCompleto[0];
    $i++;
   }
   
      $this->datos['clientesPorAgente']=$clientesPorAgente;

  }
   else
   {
   	$this->datos['mensaje']="No se encontraron coincidencias";
   }
  $this->datos['idPersona']=$_POST['selectAgentesClub'];
  $this->datos['pestania']="divAsignarPuntos";

   $this->index();
}
//--------------------------------------------------
function otorgarPuntos(){

	$verificaForm=$this->libreriav3->verificarExistenciaLlave($_POST['idFormEnvio']);
		//$fp=fopen('resultadoJason.txt','w');fwrite($fp,print_r($verificaForm,true));fclose($fp);
	if($verificaForm==0){
	$IDCli=explode(";",$_POST['IDCli']);
	foreach ($IDCli as  $value) {
	if($value!="")
	  {
         $datosCliente=explode('|', $value);
	  	$band=$this->puntos_model->verificaExistenciaClientPunto($datosCliente[0]);

	  	if($band)
	  	{
	  		$this->puntos_model->sumaPuntos($datosCliente[0],(float)$_POST['PUNTOS'],$_POST['idPersona']);
	  	}
	  	else{
	  		$this->puntos_model->insertaClienteEnPunto($datosCliente[0],(float)$_POST['PUNTOS'],$_POST['idPersona']);
	  	}
	  	$datos['PUNTOS']=$_POST['PUNTOS'];
	  	$datos['IDCli']=$datosCliente[0];
	  	$datos['idPersona']=$_POST['idPersona'];
	  	$datos['idPromocionPunto']=$_POST['IDPUNTOS'];
	  	$this->puntos_model->guardarEnBitacora($datos);
        $this->puntos_model->actualizarNombreCliente($datosCliente[0],$datosCliente[1]);
		
	  }
	}
    $this->datos['mensaje']="Los puntos se otorgaron con exito";
   }
    $this->datos['pestania']="divConsultarPuntos";
    $this->buscarPuntosPorAgente();
}
//---------------------------------------------------
function puntos(){
	   //$this->datos['ver'] = $this->puntos_model->ver();
		

}
//--------------------------------------------------
public function add(){
 if($this->input->post("submit")){			
	$dato1 = $this->input->post("tipo");
    $dato2= $this->input->post("punto");
	}			
	$add=$this->puntos_model->add($dato1,$dato2);		  
	$this->datos['pestania']="divCrear";
    $this->index();
 }
 //------------------------------------------------
 public function eliminar($idpunto){
     if(is_numeric($idpunto))
     {        
        $eliminar = $this->puntos_model->eliminar($idpunto); 
            $this->datos['pestania']="divCrear";
       $this->index();        
      }  
   
    
   }
 //---------------------------------------------------
 	public function mod($idpunto){
     if(is_numeric($idpunto))
     {
        $this->datos["mod"] = $this->puntos_model->mod($idpunto);
        $this->index();
      }

     }
 //----------------------------------------------------------
 function guardarMod(){
 	$dato1 = $_POST['TIPO'];
	$dato2= $_POST['PUNTO'];
	$idpunto= $_POST['IDPUNTO'];
    $mod=$this->puntos_model->mod($idpunto,$dato1,$dato2,'hola');
    $this->datos['mensaje']="Se guardaron los cambios";
    $this->datos['pestania']="divCrear";
    $this->index();
 }
 //----------------------------------------------------------
 public function cancelarMod(){
 	$this->datos['pestania']="divCrear";
 	$this->index();
 }
 //----------------------------------------------------------
 function buscarPuntosPorAgente()
 {
 	if($_POST['idPersona']!=-1){
          $this->datos['puntosDeLosClientes']=$this->puntos_model->obtenerPuntosDeLosClientes($_POST['idPersona']);
           	$this->datos['idPersona']=$_POST['idPersona'];
 	}
 	// $fp=fopen('resultadoJason.txt','w');fwrite($fp,print_r( $this->datos['puntosDeLosClientes'],true));fclose($fp);
 	$this->datos['pestania']="divConsultarPuntos";
 	$this->index();
  
 }
//----------------------------------------------------------
public function consultarPuntosCanjeados(){
	$datos=$this->puntos_model->obtenerPuntosCanjeados($_POST['IDCli']);
	$nombre=$this->puntos_model->nombreCliente($_POST['IDCli']);
	$tabla="<table class='tableGenerico' border='2'><thead><tr><td colspan='5'>".$nombre[0]->nombreCliente."</td><td align='right'><button onclick='cerrarModal()' class='botonCierre'>X</button></td></tr><tr>";
	$tabla=$tabla.'<td>Articulo </td>';
    $tabla=$tabla.'<td>Puntos del articulo</td>';
    $tabla=$tabla.'<td>Cantidad de articulos</td>';
    $tabla=$tabla.'<td>Total</td>';
    $tabla=$tabla.'<td>Folio del ticket</td>';
    $tabla=$tabla.'<td>Fecha</td>';
	$tabla=$tabla."</tr></thead><tbody>";
	$sumPuntos=0;
	foreach ($datos as $value) {
		$sumPuntos=$sumPuntos+$value->PUNTOS;
	   $tabla=$tabla."<tr>";
       $tabla=$tabla.'<td>'.$value->nombre.'</td>';
       $tabla=$tabla.'<td>'.$value->cantPuntos.'</td>';
       $tabla=$tabla.'<td>'.$value->cantArticulos.'</td>';
       $tabla=$tabla.'<td align=\'right\'>'.$value->PUNTOS.'</td>';
       $tabla=$tabla.'<td align=\'center\'><label class=\'label\'>'.$value->folioTicket.'</label><button class=\'btn\' onclick=\'generaPDFRecibo('.$value->folioTicket.','.$_POST['IDCli'].')\'>Imprimir</button></td>';
       $tabla=$tabla.'<td align=\'center\'>'.$value->fecha.'</td>';
       $tabla=$tabla."<tr>";      
	}
		$tabla=$tabla.'<tfoot>';
		$tabla=$tabla."<tr>";
       $tabla=$tabla.'<td></td>';
       $tabla=$tabla.'<td></td>';
       $tabla=$tabla.'<td></td>';
       $tabla=$tabla.'<td align=\'right\'>'.$sumPuntos.'</td>';
       $tabla=$tabla.'<td></td>';
       $tabla=$tabla.'<td></td>';       
       $tabla=$tabla."<tr>";
     $tabla=$tabla.'</tfoot>';
	$tabla=$tabla."</tbody></table>";
	//$fp=fopen('resultadoJason.txt','w');fwrite($fp,print_r($datos,true));fclose($fp);
	$this->datos['tablaCanjePuntos']=$tabla;
	$this->datos['pestania']="divConsultarPuntos";
  if(isset($_POST['AJAX'])){echo json_encode($tabla);}
  else{$this->index();}
}
//----------------------------------------------------------
public function consultarPuntosOtorgados(){
	//
	$datos=$this->puntos_model->obtenerPuntosOtorgados($_POST['IDCli']);

$nombre=$this->puntos_model->nombreCliente($_POST['IDCli']);
	$tabla="<table class='tableGenerico' border='2'><thead><tr><td colspan='6'>".$nombre[0]->nombreCliente."</td><td align='right'><button onclick='cerrarModal()' class='botonCierre'>X</button></td></tr><tr>";
    $tabla=$tabla.'<td>Nombre de la Promocion</td>';
    $tabla=$tabla.'<td>Puntos Otorgados</td>';
    $tabla=$tabla.'<td>Fecha</td>';  
    $tabla=$tabla.'<td>Fecha Pago</td>';  
    $tabla=$tabla.'<td>Fecha Limite</td>';  
    $tabla=$tabla.'<td>Prima neta</td>';  
    $tabla=$tabla.'<td>Renovacion</td>';   
	$tabla=$tabla."</tr></thead><tbody>";
	$sumPuntos=0;
	foreach ($datos as $value) {
		$sumPuntos=$sumPuntos+$value->PUNTOS;
	   $tabla=$tabla."<tr>";
       $tabla=$tabla.'<td>'.$value->TIPO.'</td>';
       $tabla=$tabla.'<td align=\'right\'>'.$value->PUNTOS.'</td>';
       $tabla=$tabla.'<td align=\'center\'>'.$value->fecha.'</td>';       
       $tabla=$tabla.'<td align=\'center\'>'.$value->FechaDocto.'</td>';       
       $tabla=$tabla.'<td align=\'center\'>'.$value->FLimPago.'</td>';       
       $tabla=$tabla.'<td align=\'center\'>'.$value->PrimaNeta.'</td>';       
       $tabla=$tabla.'<td align=\'center\'>'.$value->Renovacion.'</td>';       
       $tabla=$tabla."<tr>";      
	}
	$tabla=$tabla.'<tfoot>';
		$tabla=$tabla."<tr>";
       $tabla=$tabla.'<td></td>';
       $tabla=$tabla.'<td align=\'right\'>'.$sumPuntos.'</td>';
       $tabla=$tabla.'<td></td>';       
       $tabla=$tabla."<tr>";
     $tabla=$tabla.'</tfoot>';
	$tabla=$tabla."</tbody></table>";	
	$this->datos['tablaCanjePuntos']=$tabla;
	$this->datos['pestania']="divConsultarPuntos";
	if(isset($_POST['AJAX'])){echo json_encode($tabla);}
  else{$this->index();}

}
//----------------------------------------------------------
function productos()
{

$nombre=$this->puntos_model->nombreCliente($_POST['IDCli']);
$productos=$this->puntos_model->productos();
//$fp = fopen("resultadoJason.txt", 'a');fwrite($fp, print_r($nombre,TRUE));fclose($fp);
$tabla="<table class='tableGenerico' border='2'><thead><tr><td>".$nombre[0]->nombreCliente."</td><td>Tienes ".$nombre[0]->PUNTOS." Puntos disponibles para canjear</td><td align='right'><button onclick='cerrarModal()' class='botonCierre'>X</button></td></tr><tr>";
$tabla=$tabla."</tr></thead><tbody>";
foreach ($productos as $value) {
		$tabla=$tabla."<tr>";
          $tabla=$tabla.'<td>Producto:'.$value->nombre.'</td>';          
           $tabla=$tabla.'<td colspan=\'3\' align=\'right\'>'.$value->puntos.' Puntos</td>';
        $tabla=$tabla."</tr>";
}
$tabla=$tabla."</tbody>";
	$tabla=$tabla.'<tfoot>';
	  $tabla=$tabla.'<td colspan=\'3\'><button class=\'btn-primary\' onclick=\'exportarSeleccionProductos('.$_POST['IDCli'].')\'>Generar PDF</button></td>';
       $tabla=$tabla."</tr>";
     $tabla=$tabla.'</tfoot>';
$tabla=$tabla."</table>";
	$this->datos['pestania']="divConsultarPuntos";
 $this->datos['productosDeCanje']=$tabla;    
 if(isset($_POST['AJAX'])){echo json_encode($tabla);}
 else{$this->index();}
}
//----------------------------------------------------------
public function exportarSeleccionProductos(){
//		header('Content-type: application/vnd.ms-excel');
//	header("Content-Disposition: attachment; filename=Listado_fecha.xls");
//	header("Pragma: no-cache");
//	header("Expires: 0");

$nombre=$this->puntos_model->nombreCliente($_POST['IDCli']);
$productos=$this->puntos_model->productos();
//$fp = fopen("resultadoJason.txt", 'a');fwrite($fp, print_r($nombre,TRUE));fclose($fp);
$tabla="<table border='1'><tr><td>ID</td><td>".$nombre[0]->nombreCliente."</td><td>Tienes ".$nombre[0]->PUNTOS." Puntos disponibles para canjear</td>";
$tabla=$tabla."</tr>";
foreach ($productos as $value) {
		$tabla=$tabla."<tr>";
          $tabla=$tabla.'<td>'.$value->idArticulo.'</td>';              
          $tabla=$tabla.'<td>'.$value->nombre.'</td>';          
           $tabla=$tabla.'<td>'.$value->puntos.' Puntos</td>';
        $tabla=$tabla."</tr>";
}


$tabla=$tabla."</table>";
  $this->load->library('mydompdf');
  $this->mydompdf->load_html($tabla);
  $this->mydompdf->set_paper('A4','portrait');
  $this->mydompdf->render();
  $this->mydompdf->stream("lealtadClientes.pdf", array("Attachment" => false));

	//echo($tabla);


}
//----------------------------------------------------------
function consultarHistorial()
{
	$datos=$this->puntos_model->obtenerPuntosHistorial($_POST['IDCli']);
$nombre=$this->puntos_model->nombreCliente($_POST['IDCli']);
	$tabla="<table class='tableGenerico' border='2'><thead><tr><td colspan='3'>".$nombre[0]->nombreCliente."</td><td align='right'><button onclick='cerrarModal()' class='botonCierre'>X</button></td></tr><tr>";
    $tabla=$tabla.'<td>Nombre Promocion o Folio Canje</td>';
    $tabla=$tabla.'<td>Nombre del Articulo Canjeado</td>';
    $tabla=$tabla.'<td>Puntos</td>';
    $tabla=$tabla.'<td>Fecha</td>';   
	$tabla=$tabla."</tr></thead><tbody>";
	$sumPuntos=0;
	foreach ($datos as $value) {
		$tabla=$tabla."<tr>";
		if($value->operacion==1){
          $tabla=$tabla.'<td>'.$value->TIPO.'</td>';
          $tabla=$tabla.'<td></td>';
           $tabla=$tabla.'<td align=\'right\'>'.$value->PUNTOS.'</td>';
           $sumPuntos=$sumPuntos+(double)$value->PUNTOS;
		}
		else{
           $tabla=$tabla.'<td>Ticket #:'.$value->folioTicket.'</td>';
            $tabla=$tabla.'<td>'.$value->nombre.'</td>';
             $tabla=$tabla.'<td align=\'right\'>-'.$value->PUNTOS.'</td>';
             $sumPuntos=$sumPuntos-(double)$value->PUNTOS;
		}
		 $tabla=$tabla.'<td align=\'center\'>'.$value->fecha.'</td>';
		$tabla=$tabla."</tr>";
	}
	$tabla=$tabla.'<tfoot>';
		$tabla=$tabla."<tr>";
       $tabla=$tabla.'<td></td>';       
       $tabla=$tabla.'<td></td>';
       $tabla=$tabla.'<td align=\'right\'>'.$sumPuntos.'</td>';       
       $tabla=$tabla.'<td></td>';
       $tabla=$tabla."</tr>";
       $tabla=$tabla."<tr>";
       $tabla=$tabla.'<td colspan=\'4\'><button class=\'btn-primary\' onclick=\'exportarHistorial('.$_POST['IDCli'].')\'>Generar PDF</button></td>';
       $tabla=$tabla."</tr>";
     $tabla=$tabla.'</tfoot>';

	$tabla=$tabla."</tbody></table>";
	//$fp=fopen('resultadoJason.txt','w');fwrite($fp,print_r($_POST,true));fclose($fp);	


	$this->datos['tablaCanjePuntos']=$tabla;
	$this->datos['pestania']="divConsultarPuntos";
	if(isset($_POST['AJAX'])){echo json_encode($tabla);}
  else{$this->index();}
}
//-------------------------------------------------------------
public function exportarHistorial(){

		header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Listado_fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
		$datos=$this->puntos_model->obtenerPuntosHistorial($_POST['IDCli']);
$nombre=$this->puntos_model->nombreCliente($_POST['IDCli']);
	$tabla="<table class='tableGenerico' border='2'><thead><tr><td colspan='3'>".$nombre[0]->nombreCliente."</td><td align='right'><button onclick='cerrarModal()' class='botonCierre'>X</button></td></tr><tr>";
    $tabla=$tabla.'<td>Nombre Promocion o Folio Canje</td>';
    $tabla=$tabla.'<td>Nombre del Articulo Canjeado</td>';
    $tabla=$tabla.'<td>Puntos</td>';
    $tabla=$tabla.'<td>Fecha</td>';   
	$tabla=$tabla."</tr></thead><tbody>";
	$sumPuntos=0;
	foreach ($datos as $value) {
		$tabla=$tabla."<tr>";
		if($value->operacion==1){
          $tabla=$tabla.'<td>'.$value->TIPO.'</td>';
          $tabla=$tabla.'<td></td>';
           $tabla=$tabla.'<td align=\'right\'>'.$value->PUNTOS.'</td>';
           $sumPuntos=$sumPuntos+(double)$value->PUNTOS;
		}
		else{
           $tabla=$tabla.'<td>Ticket #:'.$value->folioTicket.'</td>';
            $tabla=$tabla.'<td>'.$value->nombre.'</td>';
             $tabla=$tabla.'<td align=\'right\'>-'.$value->PUNTOS.'</td>';
             $sumPuntos=$sumPuntos-(double)$value->PUNTOS;
		}
		 $tabla=$tabla.'<td align=\'center\'>'.$value->fecha.'</td>';
		$tabla=$tabla."</tr>";
	}
	$tabla=$tabla.'<tfoot>';
		$tabla=$tabla."<tr>";
       $tabla=$tabla.'<td></td>';       
       $tabla=$tabla.'<td></td>';
       $tabla=$tabla.'<td align=\'right\'>'.$sumPuntos.'</td>';       
       $tabla=$tabla.'<td></td>';
       $tabla=$tabla."</tr>";
       $tabla=$tabla."<tr>";
       $tabla=$tabla.'<td colspan=\'4\'><button class=\'btn-primary\' onclick=\'exportarHistorial('.$_POST['IDCli'].')\'>Exportar</button></td>';
       $tabla=$tabla."</tr>";
     $tabla=$tabla.'</tfoot>';
	$tabla=$tabla."</tbody></table>";
	echo($tabla);
	//$this->index();
}
//-------------------------------------------------------------
public function generaPDFRecibo(){
  $html="";
  $cliente=$this->puntos_model->nombreCliente($_POST['IDCli']);
  $articulosCanjeados=$this->puntos_model->obtenerCanjePorTicket($_POST['IDTicket']);
  $sumaPuntos=0;
  $html='<div>Programa de lealtad clientes Capital Seguros</div>';
  $html=$html.'<div>Nombre del cliente:'.$cliente[0]->nombreCliente.'</div>';
  $html=$html.'<div><table border="1"><tr><td>Articulo</td><td>Cantidad</td><td>Valor en Puntos</td><td>Total</td>';
foreach ($articulosCanjeados as  $value) {
$html=$html.'<tr>';
$html=$html.'<td>'.$value->nombre.'</td>';
$html=$html.'<td align="right">'.$value->cantArticulos.'</td>';
$html=$html.'<td align="right">'.$value->cantPuntos.'</td>';
$html=$html.'<td align="right">'.$value->PUNTOS.'</td>';
$html=$html.'</tr>';	
$sumaPuntos=$sumaPuntos+$value->PUNTOS;
}
$html=$html.'<tr>';
$html=$html.'<td></td>';
$html=$html.'<td></td>';
$html=$html.'<td></td>';
$html=$html.'<td align="right">'.$sumaPuntos.'</td>';
$html=$html.'</tr>';
$html=$html.'</table></div>';
$html=$html.'<br><br><br><br><br><br>';
$html=$html.'<div>________________________________</div>';
$html=$html.'<br><br>';
$html=$html.'<div>Firma de recibido</div>';
  $this->load->library('mydompdf');
  $this->mydompdf->load_html($html);
  $this->mydompdf->set_paper('A4','portrait');
  $this->mydompdf->render();
  $this->mydompdf->stream("lealtadClientes.pdf", array("Attachment" => false));

}
//-------------------------------------------------------------
public function exportarBitacora(){
  set_time_limit(0);
	$tabla="";
  header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=BitacoraLealtadClientes.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
  $bitacora=array();
$bitacora=$this->puntos_model->exportarBitacora();

$tabla='<table border="1"><tr><td>Tipo</td><td>Nombre</td><td>Articulo</td><td>IDCli</td><td>Puntos</td><td>IDArticulo</td><td>cantPuntos</td><td>cantArticulos</td><td>Ticket</td><td>idPersona</td><td>operacion</td><td>fecha</td><td>idPromocion</td><td>Documento</td><td>Fecha de pago</td><td>Fecha limite</td><td>Total Polza</td><td>Renovacion</td><td>Comision</td></tr>';
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($bitacora,TRUE));fclose($fp); 
foreach ($bitacora as  $value) {
set_time_limit(0);
$tabla=$tabla.'<tr>';	
$tabla=$tabla.'<td>'.$value->TIPO.'</td>';
$tabla=$tabla.'<td>'.$value->nombreCliente.'</td>';
$tabla=$tabla.'<td>'.$value->nombre.'</td>';
$tabla=$tabla.'<td>'.$value->IDCli.'</td>';
$tabla=$tabla.'<td>'.$value->PUNTOS.'</td>';
$tabla=$tabla.'<td>'.$value->idArticulo.'</td>';
$tabla=$tabla.'<td>'.$value->cantPuntos.'</td>';
$tabla=$tabla.'<td>'.$value->cantArticulos.'</td>';
$tabla=$tabla.'<td>'.$value->folioTicket.'</td>';
$tabla=$tabla.'<td>'.$value->idPersona.'</td>';
$tabla=$tabla.'<td>'.$value->operacion.'</td>';
$tabla=$tabla.'<td>'.$value->fecha.'</td>';
$tabla=$tabla.'<td>'.$value->idPromocionPunto.'</td>';
$tabla=$tabla.'<td>'.$value->IDDocto.'</td>';
$tabla=$tabla.'<td>'.$value->FechaDocto.'</td>';       
$tabla=$tabla.'<td>'.$value->FLimPago.'</td>';       
$tabla=$tabla.'<td>'.$value->totalPolza.'</td>';       
$tabla=$tabla.'<td>'.$value->Renovacion.'</td>';  
$tabla=$tabla.'<td>'.$value->comisionTotal.'</td>';      
$tabla=$tabla.'</tr>';
}
$tabla=$tabla.'</table>';
echo($tabla);
}
//-------------------------------------------------------------
public function agregarRanking(){
$verificaForm=$this->libreriav3->verificarExistenciaLlave($_POST['idFormEnvio']);
	if($verificaForm==0){
	$insert['clienteranking']=$_POST['clienteRanking'];
	$this->puntos_model->agregarRanking($insert);
 }
	
	$this->datos['pestania']="divRanking";
	$this->index();	

}
//------------------------------------------------------------
function modificarRanking(){
	//
	$update['rango1']=$_POST['rango1'];
	$update['rango2']=$_POST['rango2'];
	$this->puntos_model->modificarRanking($_POST['idClienteRanking'],$update);
		$this->datos['pestania']="divRanking";
	$this->index();	
}
//-------------------------------------------------------------
function eliminarRanking(){
$this->puntos_model->eliminarRanking($_POST['idClienteRanking']);
$this->datos['pestania']="divRanking";
	$this->index();		
}
//-------------------------------------------------------------
function calcularRanking(){
	$bitacora=$this->puntos_model->traeBitacoraPuntos();
	$ranking= $this->puntos_model->obtenerListaRanking();
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($ranking, TRUE));fclose($fp);
    $this->puntos_model->inicializaRanking();
     (double)$rangoMaximo=$ranking[0]->rango2;$idRangoMaximo=$ranking[0]->idClienteRanking;
     (double)$rangoMinimo=$ranking[0]->rango2;$idRangoMinimo=$ranking[0]->idClienteRanking;
     foreach ($ranking as $valRanking) {
     	if($valRanking->rango2>$rangoMaximo){$rangoMaximo=$valRanking->rango2;$idRangoMaximo=$valRanking->idClienteRanking;}
        	if($valRanking->rango1<$rangoMinimo){$rangoMinimo=$valRanking->rango1;$idRangoMinimo=$valRanking->idClienteRanking;}
     }
   foreach ($bitacora as $valBitacora) {
   	if(round($valBitacora->sumaPuntos)>$rangoMaximo){
   			$update['idClienteRanking']=$idRangoMaximo;
        	$this->puntos_model->actualizarClientes($valBitacora->IDCli,$update);
   	}
   	else{
   	foreach ($ranking as $valRanking) {
        if(round($valBitacora->sumaPuntos)>=$valRanking->rango1 && round($valBitacora->sumaPuntos)<=$valRanking->rango2){
        	$update['idClienteRanking']=$valRanking->idClienteRanking;
        	$this->puntos_model->actualizarClientes($valBitacora->IDCli,$update);
        break;              
        }  		
   	}
   	}
   }
   $this->puntos_model->asignaRankingFaltante($idRangoMinimo); 
   $this->datos['pestania']="divRanking";
	$this->index();	
}
//-------------------------------------------------------------
function GetClientes(){
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
          // $TipoRespuesta  =$this->input->post('strvalor');
          //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($TipoRespuesta, TRUE));fclose($fp); 
            $data['tres'] = $this->clientelealtadmodelo->antiguedadclientes('1');   
            $data['cinco'] = $this->clientelealtadmodelo->antiguedadclientes('2');   
            $data['diez'] = $this->clientelealtadmodelo->antiguedadclientes('3');   
            $data['quince'] = $this->clientelealtadmodelo->antiguedadclientes('4');   
            $data['mayquince'] = $this->clientelealtadmodelo->antiguedadclientes('5');        
            //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data, TRUE));fclose($fp); 
           // $data['Asig']  = $this->preguntamodel->EnviaPersona2($TipoRespuesta);  
           // $data['contiene']  = 0;
           // $data['cabEncuesta']  = $this->preguntamodel->cabEncuesta();
          //$this->load->view('asigna/asigna',$data);*/
         // redirect('asigna/VistaAsigna','refresh');
          //$this->load->view('asigna/asigna',$data);
            echo json_encode($data);
        }
    }
//-------------------------------------------------------------
function enviarPuntosClientesEmail()
{
  
   $respuesta['mensaje']="Los correos se enviaron con exito";
  $IDCli=explode(';',$_POST['IDCli']);
  

$productos=$this->puntos_model->productos();
//$fp = fopen("resultadoJason.txt", 'a');fwrite($fp, print_r($nombre,TRUE));fclose($fp);
$tablaP="<table  border='1'><thead><tr><td>PRODUCTOS QUE PUEDES CANJEAR</td><td>PUNTOS</td></tr><tr>";
$tablaP=$tablaP."</tr></thead><tbody>";
foreach ($productos as $value) 
{
    $tablaP=$tablaP."<tr>";
          $tablaP=$tablaP.'<td>Producto:'.$value->nombre.'</td>';          
           $tablaP=$tablaP.'<td colspan=\'3\' align=\'right\'>'.$value->puntos.' Puntos</td>';
        $tablaP=$tablaP."</tr>";
}
$tablaP=$tablaP."</tbody>";
$tablaP=$tablaP."</table>";  


  foreach ($IDCli as $key => $value) 
  {
    if($value!='')
    {
     
  $datos=$this->puntos_model->obtenerPuntosOtorgados($value);
  $sumPuntosCab=0;
     foreach ($datos as $key => $valueDatos) 
     {$sumPuntosCab=$sumPuntosCab+(double)$valueDatos->PUNTOS;}
   //$datos=$this->puntos_model->nombreCliente($value);
   $para="";
$nombre=$this->puntos_model->nombreCliente($value);


$tipoBarra='';
    if(isset($_POST['correoPrueba'])){$para=$_POST['correoPrueba'];}
    else{$para=$nombre[0]->EMail1;}
$tabla='<table>';
$tabla.='<tr><td align="center"><img  src="cid:logo_1" /></td><td rowspan="2"><img  src="https://capsys.com.mx/V3/assets/images/envioPuntos/clubCap.png" /></td></tr>';
$tabla.='<tr><td><h2 style="color:#2a2b60">Hola: '.$nombre[0]->nombreCliente.'</h2></td></tr>';
$tabla.='<tr><td colspan="2"><label style="color:#2a2b60">Tienes en tu membresia '.$sumPuntosCab.'</label><label style="color:#e7d24b"> PUNTOS</label></td></tr>';
$tabla.='<tr><td colspan="2"><a href="https://capsys.com.mx/client/auth/login"><h3>VISITAR MICROSITIO</h3></a></td></tr>';
$tabla.='<tr><td colspan="2"><label style="color:#2a2b60">Historial de Puntos</label></td></tr>';
$tabla.='<tr><td colspan="2">';
  $tabla.='<table  border="2" style="width:80%;height:300px;overflow:scroll"><thead><tr>';
    $tabla.='<td>Nombre de la Promocion</td>';
    $tabla.='<td>Puntos Otorgados</td>';
    $tabla.='<td>Fecha</td>';  
    $tabla.='<td>Fecha Pago</td>';  
    $tabla.='<td>Fecha Limite</td>';  
    $tabla.='<td>Prima neta</td>';  
    $tabla.='<td>Renovacion</td>';   
    $tabla.="</tr></thead><tbody>";
  $sumPuntos=0;
  foreach ($datos as $value) {
    $sumPuntos=$sumPuntos+$value->PUNTOS;
     $tabla.='<tr>';
       $tabla.='<td>'.$value->TIPO.'</td>';
       $tabla.='<td align="right">'.$value->PUNTOS.'</td>';
       $tabla.='<td align="center">'.$value->fecha.'</td>';       
       $tabla.='<td align="center">'.$value->FechaDocto.'</td>';       
       $tabla.='<td align="center">'.$value->FLimPago.'</td>';       
       $tabla.='<td align="center">'.$value->PrimaNeta.'</td>';       
       $tabla.='<td align="center">'.$value->Renovacion.'</td>';       
       $tabla.="</tr>";      
  }

  if($value->puntos<=49){$tipoBarra='barraCapBronce.png';}
  else
  {
   if($value->puntos>49 && $value->puntos<=100){$tipoBarra='barraCapPlata.png';}
   else
   {if($value->puntos>100 && $value->puntos<=500){$tipoBarra='barraCapOro.png';}
     else{$tipoBarra='barraCapDiamante.png';}
   }
  }
   
  $tabla.='<tfoot>';
    $tabla.='<tr>';
       $tabla.='<td></td>';
       $tabla.='<td align="right">'.$sumPuntos.'</td>';
       $tabla.='<td></td>';       
       $tabla.='<tr>';
     $tabla.='</tfoot>';
  $tabla.='</tbody></table>';
  $tabla.='</td></tr>';    
  $tabla.='<tr><td colspan="2"><img  src="https://capsys.com.mx/V3/assets/images/envioPuntos/"'.$tipoBarra.' /></td></tr>';
  $tabla.='<tr><td colspan="2"><img  src="https://capsys.com.mx/V3/assets/images/envioPuntos/publicidadCap.png" /></td></tr></table>';

        $guardaMensaje['desde']="JIMENEZ ABURTO CLAUDIA <MARKETING@AGENTECAPITAL.COM>";
        $guardaMensaje['para']=$para;
        $guardaMensaje['asunto']='Puntos Capital Seguros';
        $guardaMensaje['mensaje']=$tabla;
        $guardaMensaje['identificaModulo']='PuntosClientes'; 
        $guardaMensaje['status']=0;     
        $guardaMensaje['fechaEnvio']='1900-01-01 00:00:00';
        $guardaMensaje['puntos']=$sumPuntos;
        $this->db->insert('envio_correosmarketing',$guardaMensaje);
    // $fp=fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($guardaMensaje, TRUE));fclose($fp);   
           
    }
  }
  echo json_encode($respuesta);
  
}
//-----------------------------------------------------------
function consultarBitacoraCorreos()
{
  
  $r='savdasv';
 $consulta='select * from envio_correosmarketing ec 
where ec.status=1 and ec.identificaModulo="PuntosClientes" and cast(ec.fechaCreacion as date) BETWEEN "'.$_POST['fechaInicial'].'" and "'.$_POST['fechaFinal'].'"';
 $fp=fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp);  
 $respuesta['correosEnviados']=$this->db->query($consulta)->result();
 $respuesta['correosPendientes']=array();
 $consulta='select * from envio_correosmarketing ec where ec.status=0 and ec.identificaModulo="PuntosClientes" ';
 $respuesta['correosPendientes']=$this->db->query($consulta)->result();
 
 echo json_encode($respuesta); 

}

//-----------------------------------------------------------
}