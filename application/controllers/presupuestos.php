<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class presupuestos extends CI_Controller{

	function __construct(){
		parent::__construct();
	
			$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
			$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
			$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
			$this->load->library('Ws_sicasdre',$params);
			$this->load->library('webservice_sicas_soap');
			$this->load->library('localfileuploader');
		    $this->load->library('libreriav3');
			$this->load->helper('ckeditor');
			$this->load->model('capsysdre_actividades');
			$this->load->model('contabilidadmodelo');
		    $this->load->model('catalogos_model');
	}
//--------------------------------------------------------------------
   function index(){
		
		if (!$this->tank_auth->isloggedin()) {redirect('/auth/login/');} 
		else 
		{
             $data['ListaProveedores']= $this->capsysdre->ListaProveedores();
             $data['giros']=$this->catalogos_model->catalogo_giros(null);
			 $this->load->view('presupuestos/ReporteProveedores',$data);
		}
	}

//--------------------------------------------------------------------
function buscarProveedores()
{
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
          $data['ListaProveedores']= $this->capsysdre->buscaProveedores($_GET['busquedaUsuario']);
          $data['giros']=$this->catalogos_model->catalogo_giros(null);
		  $this->load->view('presupuestos/ReporteProveedores',$data);
		}

}
//--------------------------------------------------------------------
function reporteProveedores(){
		$fecha = date("d-m-Y");
$fechaInicial=$this->libreriav3->convierteFecha($_POST['fechaInicial']);
$fechaFinal=$this->libreriav3->convierteFecha($_POST['fechaFinal']);
 $consulta='select f.idProveedor,p.NombreProveedor,f.fecha_factura,f.fecha_captura,f.folio_factura,f.concepto,f.montofianzas,f.montoinstitucional,f.gestion,f.promomid,f.promocun,f.corporativo,f.totalfactura,f.Usuario,f.totalconiva,f.sucursal,f.idAperturaContable from proveedores p left join facturas f on f.idProveedor=p.id where f.fecha_factura BETWEEN "'.$fechaInicial.'" and "'.$fechaFinal.'"';
 $datos=$this->db->query($consulta)->result_array();



 header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Listado_$fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo "<table border=1> ";
	echo "<tr> ";
	echo    "<th>idProveedor</th> ";
	echo 	"<th>fecha_captura</th> ";
	echo    "<th>fecha_factura</th> ";
	echo    "<th>folio_factura</th> ";
	echo 	"<th>concepto</th> ";
	echo 	"<th>montofianzas</th> ";
	echo 	"<th>montoinstitucional</th> ";
	echo 	"<th>gestion</th> ";
	echo 	"<th>promomid</th> ";
	echo 	"<th>promocun</th> ";
	echo 	"<th>corporativo</th> ";
	echo 	"<th>totalfactura</th> ";
	echo 	"<th>totalconiva</th> ";		
	echo 	"<th>NombreProveedor</th> ";	
	echo 	"<th>sucursal</th> ";
echo 	"<th>idAperturaContable</th> ";

	echo "</tr> ";

	foreach($datos as $row){	

	$id = $row['idProveedor'];
	$fecha_captura = $row['fecha_captura'];
	$fecha_factura = $row['fecha_factura'];
	$folio_factura = $row['folio_factura'];
	$concepto = $row['concepto'];
	$montofianzas = $row['montofianzas'];
    $montoinstitucional = $row['montoinstitucional'];
	$gestion = $row['gestion'];
	$promomid = $row['promomid'];
	$promocun = $row['promocun'];

    $corporativo = $row['corporativo'];
	$totalfactura = $row['totalfactura'];
    $totalconiva = $row['totalconiva'];


	$NombreProveedor = $row['NombreProveedor'];

	$sucursal = $row['sucursal'];
$idAperturaContable= $row['idAperturaContable'];
	
	echo    "<tr> ";
	echo 	"<td HEIGHT=20>".$id."</td> "; 
	echo 	"<td HEIGHT=20>".$fecha_captura."</td> ";
	echo 	"<td HEIGHT=20>".$fecha_factura."</td> "; 
	echo 	"<td HEIGHT=20>".$folio_factura."</td> "; 
	echo 	"<td HEIGHT=20>".$concepto."</td> "; 
	echo 	"<td HEIGHT=20>".$montofianzas."</td> "; 
	echo 	"<td HEIGHT=20>".$montoinstitucional."</td> "; 
	echo 	"<td HEIGHT=20>".$gestion."</td> "; 
	echo 	"<td HEIGHT=20>".$promomid."</td> "; 
	echo 	"<td HEIGHT=20>".$promocun."</td> "; 

	echo 	"<td HEIGHT=20>".$corporativo."</td> "; 
	echo 	"<td HEIGHT=20>".$totalfactura."</td> "; 

	echo 	"<td HEIGHT=20>".$totalconiva."</td> "; 



	echo 	"<td HEIGHT=20>".$NombreProveedor."</td> "; 

	echo 	"<td HEIGHT=20>".$sucursal."</td> "; 
	echo 	"<td HEIGHT=20>".$idAperturaContable."</td> "; 

	

	echo    "</tr> ";

	}
	echo "</table> ";



}
//-------------------------------------------------------------------
   function Guardar(){		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{

			$nombre	= strtoupper ($this->input->post('nombre'));
			$nombrecon	= strtoupper ($this->input->post('nombrecon'));
			$telefono	= strtoupper ($this->input->post('telefono'));
			$ext	= strtoupper ($this->input->post('ext'));
			$cel	= strtoupper ($this->input->post('cel'));
			$email	= strtoupper ($this->input->post('email'));
			$direccion	= strtoupper ($this->input->post('direccion'));
			$banco	= strtoupper ($this->input->post('banco'));
			$cuenta	= strtoupper ($this->input->post('cuenta'));
			$clave	= strtoupper ($this->input->post('clave'));
			$dias	= strtoupper ($this->input->post('dias'));
			$selectGiro['idGiro']=$this->input->post('giroCliente');
			$giro=$this->catalogos_model->catalogo_giros($selectGiro)[0]->giro;
            //$giro=  ;


			if($nombre!="")
			{	

				$sqlInsert_Referencia = "
						Insert Ignore Into
							`proveedores` 
									(
                                      
										`NombreProveedor`, 
										`Nombre_contacto`, 
										`telefono1`, 
										`extension`, 
										`telefono_movil`, 
										`email`, 
										`direccion`, 
										`banco`, 
										`cuenta`, 
										`clabe`,
										`DiasCredito`,
										`giroProveedor`
										
									) 
									Values
									(

										'".$nombre."',
										'".$nombrecon."',
										'".$telefono."',
										'".$ext."',
										'".$cel."',
										'".$email."',
										'".$direccion."',
										'".$banco."',
										'".$cuenta."',
										'".$clave."',
										'".$dias."',
										'".$giro."'

									);
											";

                         
				$this->db->query($sqlInsert_Referencia);
				$referencia = $this->db->insert_id();

			} 

             $data['ListaProveedores']= $this->capsysdre->ListaProveedores();
			 redirect('presupuestos');
			 
		}
	}
//--------------------------------------------------------------------
function GuardarFactura(){		
		if (!$this->tank_auth->isloggedin()) {redirect('/auth/login/');} 
		else 
		{
            
            $this->Vistafacturas();           
                  
			$fechacaptura	= (string)date('Y-m-d H:i:s');
			$fechafactura  = $this->input->post('1fNacimiento');
			$foliofac  = $this->input->post('folio');
			$concepto  = $this->input->post('concepto');
			$cargofianzas = $this->input->post('CargoFianzas');
			$cargoinst = $this->input->post('CargoInst');
			$cargogest = $this->input->post('CargoGes');
			$cargopromer = $this->input->post('CargoPromMer');
			$cargopromcan = $this->input->post('CargoPromCan');
			$cargocorpora = $this->input->post('Corporativos');
			$cargoAsesores=$this->input->post('Asesores');
			$cargototal = $this->input->post('CargoTotal');
			$Usuario = $this->tank_auth->get_usermail();
			$provee	= $this->input->post('provee');
			$iva = $this->input->post('iva');
			$cargototalconiva = $this->input->post('CargoTotalconIVA');
			$sucursal = $this->input->post('SUCUR');
            $idCuentaContable=$this->input->post('idCuentaContable');
            $idapertura = $this->capsysdre->AperturaContable();
			$pregunta = $this->input->post('hayfactura');
			$tipoGasto = $this->input->post('selectTipoGasto');           
			$ccc=  $this->input->post('ccc');
			$cco=  $this->input->post('cco');
			$inversion=  $this->input->post('inversion');
			$estrategia=  $this->input->post('estrategia');
            $cargogest = $ccc + $cco +$inversion+$estrategia;
            $idFormaPago=$this->input->post('tarjetaCredito');
            

			$cargofianzasDefault = $this->input->post('fianzasDefault');
			$cargoinstDefault = $this->input->post('institucionalDefault');
			$cargogestDefault = $this->input->post('gestionDefault');							
			$cargocorporaDefault = $this->input->post('coorporativoDefault');
			$cargoAsesoresDefault=$this->input->post('asesoresDefault');
			$motivoCambioPorcentaje=$this->input->post('motivoCambioPorcentajeInput');




            if($pregunta=='1')
            {	

            	$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`,
                                      `montoasesores`, 
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									  `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									  `idAperturaContable`,
									  `tipoGasto`,
									  `ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'1',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'
									);
											";

            
            }
            if($pregunta=='0'){

				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                       
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`, 
                                      `montoasesores`,
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									  `validada`,
									`idCuentaContable`,
									`idAperturaContable`,
									`tipoGasto`,
									`ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
									) 
									Values
									(

										'".$fechacaptura."',
										
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'0',
										'".$sucursal."',
										'0',
										'".$idCuentaContable."',
									    '".$idapertura."',
									    '".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

								

            }
            if($pregunta=='2'){


				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`, 
                                      `montoasesores`,
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									`idCuentaContable`,
									`idAperturaContable`,
									`tipoGasto`,
									`ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`	
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'2',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

								

            }

             if($pregunta=='3'){


				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`,  
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`,
                                      `montoasesores`, 
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									  `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									  `idAperturaContable`,
									  `tipoGasto`,
									  `ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
										
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'3',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

								

            }
            if($pregunta=='4'){


				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`, 
                                      `montoasesores`,
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									`idAperturaContable`,
									`tipoGasto`,
									`ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'4',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

								

            }
            if($pregunta=='5'){


$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                       `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`, 
                                      `montoasesores`,
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
									  `fecha_pago`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									  `idAperturaContable`,
									  `tipoGasto`,
									  `ccc`,
									  `cco`,
									  `inversion`,
									  `validada`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
										
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'1',
										'0',
										'".$fechafactura."',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'5',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'0',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

            }

            if($pregunta=='9'){
				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                       `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`,
                                      `montoasesores`, 
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									  `idAperturaContable`,
									  `tipoGasto`,
									  `ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
          
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'9',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

            }

			
			$this->db->query($sqlInsert_Referencia);			
			$referencia = $this->db->insert_id();
			
			if($_POST['textContieneNotasParaFacturar']!='')
			{
				$notas=explode(',', $_POST['textContieneNotasParaFacturar']);
				foreach ($notas as  $value) 
				{
				  if($value!='')
				  {
				  	$update['idFactura']=$referencia;
				  	$update['estaFacturado']=1;
				  	$update['idNotasCompra']=$value;
				  	$this->contabilidadmodelo->notasparacompras($update);
				  }
				}
			}


            //  redirect('presupuestos/Vistafacturas'); 

		}
	}
//--------------------------------------------------------------------
   function Vistafacturas(){	
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
			 $Usuario = $this->tank_auth->get_usermail();
			 $data['ListaProveedores']= $this->capsysdre->ListaProveedores();
             $data['Listafacturas']= $this->capsysdre->Listafacturasxuser($Usuario);
             $data['Apertura'] =  $this->capsysdre->AperturaContable(); 
            	$cuentasContable=$this->contabilidadmodelo->relCuentaContableDepartamentoPermiso(null);
            $data['catalogogiro'] = $this->catalogos_model->catalogosGiro();
            $data['permisosFormaPago']=$this->db->query('select rfp.*,cf.formaPago from relformapagousers rfp left join catalog_formapago cf on cf.idFormaPago=rfp.idFormaPago where rfp.email="'.$Usuario.'"')->result();
	$cuentasPorDepartamento=array();$cont=0;
	foreach ($cuentasContable as $value) {$cuentasPorDepartamento[$value->personaDepartamento][$cont]=$value;$cont++;}
	$data['cuentasPorDepartamento']=$cuentasPorDepartamento;
			 $this->load->view('presupuestos/listafacturas',$data);
			 
		}
	}
//--------------------------------------------------------------------
   function VistafacturasTodas(){	
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
               
            $fecha=getdate() ;   
            
			$Usuario = $this->tank_auth->get_usermail();
			$consulta['fechaInicial']=$fecha['year'].'-'.$fecha['mon'].'-'.'01';
			$consulta['fechaFinal']=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'];
			$data['fechaInicial']='01/'.$fecha['mon'].'/'.$fecha['year'];
			$data['fechaFinal']=$fecha['mday'].'/'.$fecha['mon'].'/'.$fecha['year'];
			$consulta['Usuario']=$Usuario;
			$data['permisoFiltroFacturas']=0;
			$data['usuario']=$Usuario;
			
			if($Usuario=='SISTEMAS@ASESORESCAPITAL.COM' || $Usuario=='CONTABILIDAD@AGENTECAPITAL.COM' || $Usuario=='DIRECTORGENERAL@AGENTECAPITAL.COM'|| $Usuario=='GERENTEOPERATIVO@AGENTECAPITAL.COM'){$consulta['Usuario']='';$data['permisoFiltroFacturas']=1;}
            if(isset($_POST['textFecInicial']) and isset($_POST['textFecFinal']))
            {
            	$consulta['fechaInicial']=$_POST['textFecInicial'];//$this->libreriav3->convierteFecha($_POST['textFecInicial']);
            	$consulta['fechaFinal']=$_POST['textFecFinal'];//$this->libreriav3->convierteFecha($_POST['textFecFinal']);
            	$data['fechaInicial']=$_POST['textFecInicial'];
			$data['fechaFinal']=$_POST['textFecFinal'];
            }    
            else
            {
            	$data['fechaInicial']=date('Y').'-'.date('m').'-01';
            	$data['fechaFinal']=date('Y').'-'.date('m').'-'.date('d');
            	
            }   
             $data['usuariosQueFacturan']=$this->db->query('select distinct(f.Usuario) from facturas f right join users u on u.email=f.Usuario where  u.activated=1 and u.banned=0 and f.Usuario is not null')->result() ;
             $data['Listafacturas']= $this->capsysdre->ListafacturasxuserTodas($consulta);
			 $this->load->view('presupuestos/listafacturasTodas',$data);
			 
		}
	}
//--------------------------------------------------------------------	

	function Validaf(){		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
         $data['Listafacturas']= $this->capsysdre->Listafacturasparavalidar();            
		 $this->load->view('presupuestos/listafacturasvalida',$data);			 
		}
	}
//--------------------------------------------------------------------
	 function ListaPagosAutorizar(){
		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
			 $Usuario = $this->tank_auth->get_usermail();
			// $data['ListaProveedores']= $this->capsysdre->ListaProveedores();
             $data['Listafacturas']= $this->capsysdre->ListaPagos();
             $anio=date('Y');$mes=date('m');$dia=date('d');
             if((int)$dia<10){$dia='0'.date('d');}
             $data['fec_inicio']=$anio.'-'.$mes.'-01';
             $data['fec_final']=$anio.'-'.$mes.'-'.$dia;

			 $this->load->view('presupuestos/listafacturaspago',$data);			 
		}
	}
//--------------------------------------------------------------------
	 function AutorizaPago(){		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
			 $Usuario = $this->tank_auth->get_usermail();
			// $data['ListaProveedores']= $this->capsysdre->ListaProveedores();
             $data['Listafacturas']= $this->capsysdre->ListafacturasParaAutorizar();
             $data['usuariosPresupuestos']= $this->capsysdre->usuariosDePresupuestos();
             $data['presuma']= $this->capsysdre->SumaPresupuestos();
             $data['tipoVista']="";


			 $this->load->view('presupuestos/listafacturasautoriza',$data);
			 
		}
	}
//--------------------------------------------------------------------
	function AutorizaFactura(){		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
			$idfac  = $this->input->get('IDFact');

			$sqlInsert_Referencia = "Update `facturas` set `autorizadireccion` = '1' where `id`='".$idfac."'";

									
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();

			// $data['ListaProveedores']= $this->capsysdre->ListaProveedores();
             $data['Listafacturas']= $this->capsysdre->ListafacturasParaAutorizar();
             $data['usuariosPresupuestos']= $this->capsysdre->usuariosDePresupuestos();
             $data['presuma']= $this->capsysdre->SumaPresupuestos();
               $data['tipoVista']="";
			 $this->load->view('presupuestos/listafacturasautoriza',$data);
			 
		}
	}
//--------------------------------------------------------------------
	function ValidaFactura() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
			return;
		}

			$idfac  = $this->input->get('IDFact');
		if (!$idfac) {
			// Si no hay ID, responde error
			if ($this->input->is_ajax_request()) {
				echo json_encode(['success' => false, 'mensaje' => 'ID de factura no proporcionado.']);
				return;
			} else {
				show_error('ID de factura no proporcionado.');
				return;
			}
		}
		// Validar factura
		$sqlInsert_Referencia = "UPDATE `facturas` SET `validada` = '1' WHERE `id` = '" . $idfac . "'";
			$this->db->query($sqlInsert_Referencia);

		if ($this->input->is_ajax_request()) {
			// Si es una petición AJAX, responde solo JSON
			echo json_encode(['success' => true, 'mensaje' => 'Factura validada correctamente.']);
			return;
		} else {
			// Si no es AJAX, carga vista como siempre
			$data['Listafacturas'] = $this->capsysdre->Listafacturasparavalidar();
			$this->load->view('presupuestos/listafacturasvalida', $data);
		}
	}
//--------------------------------------------------------------------
	function PagarFactura(){
    if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
    else {
			if($this->input->get('IDFact',TRUE))
			{
				$idfac  = $this->input->get('IDFact');
				$data['detallefactpag']	= $this->capsysdre->GetFact($idfac); 		
				$this->load->view('presupuestos/editpago', $data);
			}
		}		
	}
//--------------------------------------------------------------------
	function PagarReembolso() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			if ($this->input->get('IDUser', TRUE)) {
				$iduser = $this->input->get('IDUser');
				$frem   = $this->input->get('unofNacimiento'); // Asegúrate de que el nombre del parámetro esté bien escrito

				$sqlInsert_Referencia = "UPDATE `facturas` 
										SET `pagado` = '1', `fecha_pago` = '".$frem."' 
										WHERE `Usuario` = '".$iduser."' 
										AND `posteriorapago` = '2' 
										AND `pagado` = '0' 
										AND `autorizadireccion` = 1";

            $this->db->query($sqlInsert_Referencia);

				// Prepara la respuesta JSON
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status' => 'success',
						'message' => 'Reembolso registrado correctamente',
						'usuario' => $iduser,
						'fecha_pago' => $frem
					]));
			} else {
				// Si no se recibió IDUser, responde con error
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status' => 'error',
						'message' => 'ID de usuario no proporcionado'
					]));
			}
		}
	}
//--------------------------------------------------------------------
	function AplicaPago(){
    if (!$this->tank_auth->is_logged_in()) {
        redirect('/auth/login/');
    } else {
			$idfac  = $this->input->get('IDFact');
        $fpag   = $this->input->get('unofNacimiento');

        $sqlInsert_Referencia = "UPDATE `facturas` 
                                 SET `pagado` = '1', `fecha_pago` = '".$fpag."' 
                                 WHERE `id` = '".$idfac."'";
        
			$this->db->query($sqlInsert_Referencia);
        // Respuesta JSON
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode([
                 'status' => 'success',
                 'message' => 'Fecha de pago guardada correctamente',
                 'factura_id' => $idfac,
                 'fecha_pago' => $fpag
             ]));
		}
}

//--------------------------------------------------------------------
	function GuardaFacturaEditada(){

  	if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 
		else 
		{
			$folio  = $this->input->post('folio');
			$ffac  = $this->input->post('unofNacimiento');
			$idfac  = $this->input->post('IDFact');
			

			$sqlInsert_Referencia = "
						Update
							`facturas` set
							            `folio_factura` = '".$folio."',
										`fecha_factura` ='".$ffac."',
										`posteriorapago` ='1'
									where
									    `id`='".$idfac."'

											";

                         
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();


 			$Usuario = $this->tank_auth->get_usermail();
			$data['ListaProveedores']= $this->capsysdre->ListaProveedores();
            $data['Listafacturas']= $this->capsysdre->Listafacturasxuser($Usuario);
			$this->load->view('presupuestos/listafacturas',$data);
		}

	}



	function editProvee(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			if($this->input->get('idprovee',TRUE))
			{
				$idInterno = $this->input->get('idprovee',TRUE);


				$data['detalleproveedor']	= $this->capsysdre->GetProveedor($idInterno); 
                $data['giros']=$this->catalogos_model->catalogo_giros(null);
			
				$this->load->view('presupuestos/editproveedor', $data);
			}
		}
	} /*! editPros */

//-----------------------------------------------------------
	function editFactura(){

		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{

			if($this->input->get('IDFact',TRUE)) 
			{
				$Usuario = $this->tank_auth->get_usermail();
				$data['ListaProveedores']= $this->capsysdre->ListaProveedores();
            	$data['Apertura'] =  $this->capsysdre->AperturaContable(); 
           		$cuentasContable=$this->contabilidadmodelo->relCuentaContableDepartamentoPermiso(null);
            	$data['catalogogiro'] = $this->catalogos_model->catalogosGiro();
            	$data['permisosFormaPago']=$this->db->query('select rfp.*,cf.formaPago from relformapagousers rfp left join catalog_formapago cf on cf.idFormaPago=rfp.idFormaPago where rfp.email="'.$Usuario.'"')->result();
				$cuentasPorDepartamento=array();$cont=0;
				foreach ($cuentasContable as $value) {$cuentasPorDepartamento[$value->personaDepartamento][$cont]=$value;$cont++;}
				$data['cuentasPorDepartamento']=$cuentasPorDepartamento;	
				$idfac  = $this->input->get('IDFact');
				$data['detallefactura']	= $this->capsysdre->GetFact($idfac); 
				if(isset($_GET['peticionAJAX'])){echo json_encode($data);}
				else{$this->load->view('presupuestos/editarFacturaGeneral', $data);}
			}
		}
	} /*! editPros */
//-----------------------------------------------------------
function datosParaFacturar()
{  $Usuario = $this->tank_auth->get_usermail();
   $data['proveedores']= $this->capsysdre->ListaProveedores()->result();
   $data['Apertura'] =  $this->capsysdre->AperturaContable();
    $data['tarjetas']=$this->contabilidadmodelo->devolverTarjetasPersonales(); 
   $cuentasContable=$this->contabilidadmodelo->relCuentaContableDepartamentoPermiso(null);
               	$data['permisosFormaPago']=$this->db->query('select rfp.*,cf.formaPago from relformapagousers rfp left join catalog_formapago cf on cf.idFormaPago=rfp.idFormaPago where rfp.email="'.$Usuario.'"')->result();
     				$cuentasPorDepartamento=array();$cont=0;
				foreach ($cuentasContable as $value) {$cuentasPorDepartamento[$value->personaDepartamento][$cont]=$value;$cont++;}
				$data['cuentasPorDepartamento']=$cuentasPorDepartamento;
   echo json_encode($data);	
}

//-----------------------------------------------------------
	function actualizaproveedor(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {  

           
            $idInterno = $this->input->post('idprovee',TRUE);

          
			$nombre	= strtoupper ($this->input->post('nombre'));
			$nombrecon	= strtoupper ($this->input->post('nombrecon'));
			$telefono	= strtoupper ($this->input->post('telefono'));
			$ext	= strtoupper ($this->input->post('ext'));
			$cel	= strtoupper ($this->input->post('cel'));
			$email	= strtoupper ($this->input->post('email'));
			$direccion	= strtoupper ($this->input->post('direccion'));
			$banco	= strtoupper ($this->input->post('banco'));
			$cuenta	= strtoupper ($this->input->post('cuenta'));
			$clave	= strtoupper ($this->input->post('clave'));
			$dias	= strtoupper ($this->input->post('dias'));
			$buscar['idGiro']=$this->input->post('giroCliente');
			$giroCliente=$this->catalogos_model->catalogo_giros($buscar)[0]->giro;  


           if($idInterno>'0')
	 		{ 	

				$sqlUpdateUser = "
				Update
					`proveedores`
				Set
				`NombreProveedor` = '".$nombre."',
				`Nombre_contacto` = '".$nombrecon."',
				`telefono1` 	  = '".$telefono."',
				`extension`       = '".$ext."',
				`telefono_movil`  = '".$cel."',
				`email`           = '".$email."',
				`direccion`       = '".$direccion."', 
				`banco`           = '".$banco."',
				`cuenta`          = '".$cuenta."',
				`clabe`           = '".$clave."',
				`DiasCredito`     = '".$dias."',
				`giroProveedor`     = '".$giroCliente."'
				
				Where
				`id` = '".$idInterno."'
						 ";

				$this->db->query($sqlUpdateUser);

			}    

			$data['ListaProveedores']= $this->capsysdre->ListaProveedores();
			$data['giros']=$this->catalogos_model->catalogo_giros(null);
			redirect('presupuestos');

		}
	} /*! actualizaProveedor */


	//-------------------------------------------------------------------------

    function ExportaFacturas(){	
	//$mysqli = new mysqli('localhost','root','','capsysv3');
	//$mysqli = new mysqli('www.capsys.com.mx','root','viki52','capsysV3');
    $correoProcedente=$this->tank_auth->get_usermail();
	$fecha = date("d-m-Y");
	$filtro='';
	if(isset($_POST['fec_inicial']) and isset($_POST['fec_final'])){$filtro=' where DATE(f.fecha_captura) BETWEEN "'.$_POST['fec_inicial'].'" and "'.$_POST['fec_final'].'" order by f.fecha_captura';}
   	$consulta= 'select  f.id,f.fecha_captura,f.fecha_factura,f.folio_factura,f.concepto,f.montofianzas,f.montoinstitucional,f.gestion,f.promomid,f.promocun,f.corporativo,f.totalfactura,f.iva,f.totalconiva,f.autorizadireccion,f.pagado,f.fecha_pago,us.name_complete,pv.NombreProveedor,f.posteriorapago,f.sucursal from facturas f left join proveedores pv on pv.id=f.idProveedor left join users us on us.email=f.Usuario '.$filtro;
   	//$resultado= $mysqli->query($consulta);
   	$resultado= $this->db->query($consulta)->result_array();
	//Inicio de la instancia para la exportación en Excel
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Listado_$fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo "<table border=1> ";
	echo "<tr> ";
	echo    "<th>id</th> ";
	echo 	"<th>fecha_captura</th> ";
	echo    "<th>fecha_factura</th> ";
	echo    "<th>folio_factura</th> ";
	echo 	"<th>concepto</th> ";
	echo 	"<th>montofianzas</th> ";
	echo 	"<th>montoinstitucional</th> ";
	echo 	"<th>gestion</th> ";
	echo 	"<th>promomid</th> ";
	echo 	"<th>promocun</th> ";

	echo 	"<th>corporativo</th> ";
	echo 	"<th>totalfactura</th> ";
	echo 	"<th>iva</th> ";
	echo 	"<th>totalconiva</th> ";
	echo 	"<th>autorizadireccion</th> ";
	echo 	"<th>pagado</th> ";

	echo 	"<th>fecha_pago</th> ";
	echo 	"<th>name_complete</th> ";
	echo 	"<th>NombreProveedor</th> ";
	echo 	"<th>posteriorapago</th> ";
	echo 	"<th>sucursal</th> ";


	echo "</tr> ";

	foreach($resultado as $row)
	{	
	$id = $row['id'];
	$fecha_captura = $row['fecha_captura'];
	$fecha_factura = $row['fecha_factura'];
	$folio_factura = $row['folio_factura'];
	$concepto = $row['concepto'];
	$montofianzas = $row['montofianzas'];
    $montoinstitucional = $row['montoinstitucional'];
	$gestion = $row['gestion'];
	$promomid = $row['promomid'];
	$promocun = $row['promocun'];
    $corporativo = $row['corporativo'];
	$totalfactura = $row['totalfactura'];
	$iva = $row['iva'];
    $totalconiva = $row['totalconiva'];
	$autorizadireccion = $row['autorizadireccion'];
	$pagado = $row['pagado'];
	$fecha_pago = $row['fecha_pago'];
	$name_complete = $row['name_complete'];
	$NombreProveedor = $row['NombreProveedor'];
	$posteriorapago = $row['posteriorapago'];
	$sucursal = $row['sucursal'];
	
	echo    "<tr> ";
	echo 	"<td HEIGHT=20>".$id."</td> "; 
	echo 	"<td HEIGHT=20>".$fecha_captura."</td> ";
	echo 	"<td HEIGHT=20>".$fecha_factura."</td> "; 
	echo 	"<td HEIGHT=20>".$folio_factura."</td> "; 
	echo 	"<td HEIGHT=20>".$concepto."</td> "; 
	echo 	"<td HEIGHT=20>".$montofianzas."</td> "; 
	echo 	"<td HEIGHT=20>".$montoinstitucional."</td> "; 
	echo 	"<td HEIGHT=20>".$gestion."</td> "; 
	echo 	"<td HEIGHT=20>".$promomid."</td> "; 
	echo 	"<td HEIGHT=20>".$promocun."</td> "; 
	echo 	"<td HEIGHT=20>".$corporativo."</td> "; 
	echo 	"<td HEIGHT=20>".$totalfactura."</td> "; 
	echo 	"<td HEIGHT=20>".$iva."</td> "; 
	echo 	"<td HEIGHT=20>".$totalconiva."</td> "; 
	echo 	"<td HEIGHT=20>".$autorizadireccion."</td> "; 
	echo 	"<td HEIGHT=20>".$pagado."</td> "; 
	echo 	"<td HEIGHT=20>".$fecha_pago."</td> "; 
	echo 	"<td HEIGHT=20>".$name_complete."</td> "; 
	echo 	"<td HEIGHT=20>".$NombreProveedor."</td> "; 
	echo 	"<td HEIGHT=20>".$posteriorapago."</td> ";
	echo 	"<td HEIGHT=20>".$sucursal."</td> "; 
	echo    "</tr> ";

	}
	echo "</table> ";
   }

  //-------------------------------------------------------------------
	function GuardarArchivo(){ //Modificado [Suemy][2024-10-17]

		/*DIRECCION PARA HACER CUANDO SE EJECUTE LOCALMENTE*/
		//$directorio=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/ArchivosPresupuesto/".$_POST['id']."";
		//base_url().'ArchivosPresupuesto/'.$_POST['id']."/"; 
		/*DIRECTORIO CUANDO SE SUBE AL SERVIDOR  */
		$directorio=$_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosPresupuesto/".$_POST['id']."";
		if(!file_exists($directorio))
		{@mkdir($directorio, 0700);}

     $extension=explode(".",$_FILES['Archivo']['name'] );
     $largo=count($extension);

   $extensionCadena=strtoupper($extension[$largo-1]);
		if($extensionCadena=='PDF' ||  $extensionCadena=='XML'){
      // $nuevoNombre=$_POST['anio']."-".$_POST['mes'];
      	$date = str_replace(array(" ",":"),"_",date("Y-m-d H:i:s"));
			$file_name = $_POST['id']."_".$date.".".$extension[$largo-1];
        $mi_archivo = 'Archivo';
        $config['upload_path'] = $directorio;
        	$config['file_name'] = $file_name;
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";
        $config['max_width'] = "2000";
        $config['overwrite'] = "TRUE";
        $config['max_height'] = "2000";  
        $this->load->library('upload', $config);        
        	if ($this->upload->do_upload($mi_archivo)) {
          if($extensionCadena=='PDF' ){
          		$updateFactura='update facturas set archivoNombrePDF="'.$file_name.'",	';
          $updateFactura=$updateFactura.'archivoDescripcionPDF="'.$_FILES['Archivo']['name'].'"';
          $updateFactura=$updateFactura." where id=".$_POST['id'];
           }
           if($extensionCadena=='XML' ){
          		$updateFactura='update facturas set archivoNombreXML="'.$file_name.'",	';
          $updateFactura=$updateFactura.'archivoDescripcionXML="'.$_FILES['Archivo']['name'].'"';
          $updateFactura=$updateFactura." where id=".$_POST['id'];
           }

         $this->db->query($updateFactura);
         	$cadena['ruta']=base_url()."ArchivosPresupuesto/".$_POST['id']."/".$file_name;
         	$cadena['archivo']=$file_name;
           	$archivoRespuesta="ARCHIVO GUARDADO";
         	//
         	$upload['uploadSuccess'] = $this->upload->data();
    		  	$status_type = 1;
         	$status = "success";
        }
        else{
        		$cadena = $_SERVER["DOCUMENT_ROOT"];
         $archivoRespuesta="PROBLEMAS AL PROCESAR EL ARCHIVO";	
         	//
         	$upload['uploadError'] = $this->upload->display_errors();
    	  		$status_type = 3;
    	    	$status = "error";
        }
        	$data['register_upload'] = array("config" => $config, "upload" => $upload);
     }
		else{
			$cadena = "";
	     	$archivoRespuesta="FORMATO NO VALIDO";
	     	$status_type = 2;
    	   $status = "error";
             }
		
      //if(isset($_POST['vistaProcedente'])) {
      	$data['file'] = $cadena;
      	$data['format'] = $extensionCadena;
      	$data['status'] = $status;
      	$data['status_type'] = $status_type;
      	echo json_encode($data);
         //redirect('/presupuestos/VistafacturasTodas/');
      /*}
      else {
      	redirect('/presupuestos/Vistafacturas');
      }*/
  }

//------------------------------------------------------------------------------------------------------------------------
	function modificaArchivo(){ //Modificado [Suemy][2024-10-17]
  		$s=explode(".",$_POST['file']);
    $p=count($s);
		//$url = $_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/ArchivosPresupuesto/".$_POST['id']."/".$_POST['file'];
		$url = $_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosPresupuesto/".$_POST['id']."/".$_POST['file'];

      if($s[$p-1]=="pdf" || $s[$p-1]=="PDF"){
         $updateFactura='update facturas set archivoNombrePDF="", archivoDescripcionPDF="" where id='.$_POST['id'];
       }
       if($s[$p-1]=="xml" || $s[$p-1]=="XML"){
         $updateFactura='update facturas set archivoNombreXML="", archivoDescripcionXML="" where id='.$_POST['id'];
      }

      $data['status'] = false;
      $data['delete'] = unlink($url);
      if ($data['delete'] !=  false) {
      	$data['status'] = $this->db->query($updateFactura);
      }

		$data['tipo']=$s[$p-1];
		$data['id']=$_POST['id'];
		echo json_encode($data);
  }

//------------------------------------------------------------------------------------------------------------------------
  function devuelveFacturasUsuario(){

 $mes=['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
$totalFacturas=$this->capsysdre->devuelveFacturas($_POST['id']); 
$totalPresupuesto=$this->capsysdre->devuelvePresupuesto($_POST['id']); 
$totalPresupuestoAutorizado=$this->capsysdre->devuelvePresupuestoAutorizado($_POST['id']); 
$totalPresupuestoPagado=$this->capsysdre->devuelvePresupuestoPagado($_POST['id']); 

for($i=0;$i<12;$i++){$datos['tabla'][$i]=[$mes[$i]]; }

  $contador=count($totalPresupuesto);

for($i=0;$i<12;$i++){
 $sum=$i+1;
 $T='T'.$sum;
 /*COLUMNA DE PRESUPUESTO*/
 $datos['tabla'][$i][1]=$totalPresupuesto[0]->$T; 
 /*COLUMNA DE TOTAL FACTURAS*/
 $datos['tabla'][$i][2]=0;
  $datos['tabla'][$i][3]=0;
    $datos['tabla'][$i][4]=0;
}
/*COLUMNA GASTOS TOTALES*/
  $contador=count($totalFacturas);
for($i=0;$i<$contador;$i++){
 $sum=$totalFacturas[$i]->mes-1;
 $datos['tabla'][$sum][2]=$totalFacturas[$i]->suma; 
}
  $contador=count($totalPresupuestoAutorizado);
for($i=0;$i<$contador;$i++){
 $sum=$totalPresupuestoAutorizado[$i]->mes-1;
 $datos['tabla'][$sum][3]=$totalPresupuestoAutorizado[$i]->suma; 
}
  $contador=count($totalPresupuestoPagado);
for($i=0;$i<$contador;$i++){
 $sum=$totalPresupuestoPagado[$i]->mes-1;
 $datos['tabla'][$sum][4]=$totalPresupuestoPagado[$i]->suma; 
}


if($_POST['id']=="TODOS"){
$micont=0;
$resultado=$this->capsysdre->usuariosDePresupuestos()->result();

//$totalUsuarios=count($resultado);
foreach ($resultado as  $value) {


$totalFacturas=$this->capsysdre->devuelveFacturas($value->usuario); 
$totalPresupuesto=$this->capsysdre->devuelvePresupuesto($value->usuario); 
$totalPresupuestoAutorizado=$this->capsysdre->devuelvePresupuestoAutorizado($value->usuario); 
$totalPresupuestoPagado=$this->capsysdre->devuelvePresupuestoPagado($value->usuario); 

  $contador=count($totalPresupuesto);

  /*for($i=0;$i<12;$i++){
  $datos['detalle'][$i]=[$mes[$i]];
  //$datos['presupuestoTotal'][$i]=$totalPresupuesto[$i];
   }*/

  //$datos['tabla'][5]=[$mes[$i]];
  //$datos['presupuestoTotal'][$i]=$totalPresupuesto[$i];


for($i=0;$i<12;$i++){
 $sum=$i+1;
 $T='T'.$sum;
 /*COLUMNA DE PRESUPUESTO*/
 $mesNom=$mes[$i];
 $datos['detalle'][$value->usuario][$mesNom][0]=$totalPresupuesto[0]->$T; 
 /*COLUMNA DE TOTAL FACTURAS*/
 $datos['detalle'][$value->usuario][$mesNom][1]=0;
  $datos['detalle'][$value->usuario][$mesNom][2]=0;
    //$datos['detalle'][$value->usuario][$mesNom][4]=0;
}

  $contador=count($totalPresupuestoAutorizado);$micont=$contador;
for($i=0;$i<$contador;$i++){
	 $mesNom=$mes[$totalPresupuestoAutorizado[$i]->mes-1];
 $sum=$totalPresupuestoAutorizado[$i]->mes-1;
 $datos['detalle'][$value->usuario][$mesNom][1]=$totalPresupuestoAutorizado[$i]->suma; 
}
  $contador=count($totalPresupuestoPagado);
for($i=0;$i<$contador;$i++){
	// $mesNom=$mes[$i];
	 $mesNom=$mes[$totalPresupuestoAutorizado[$i]->mes-1];
 $sum=$totalPresupuestoPagado[$i]->mes-1;
 $datos['detalle'][$value->usuario][$mesNom][2]=$totalPresupuestoPagado[$i]->suma; 
}	
}

}
echo json_encode($datos);

  }
//-------------------------------------------------------------------------------
  function devuelveFacturasUsuarioAC()
  {
   $meses=$this->libreriav3->devolverMeses();
 $mes=array();
 $mes=['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
 //$datos="";
 $datos=array();
 $datosCuentas=array();

 if($_POST['idPersonaDepartamento']==0){$departamentos=$this->catalogos_model->obtenerCatAbtDpto(null);}
 else{$buscar['idPersonaDepartamento']=$_POST['idPersonaDepartamento'];
	 $departamentos=$this->catalogos_model->obtenerCatAbtDpto($buscar);}
 $relDptoApertura=$this->contabilidadmodelo->devolverDepartamentosPorApertura($_POST['aperturaContable']);
 $numMes=1;
 $nomina=array();
 $nominaCanal=array();
 foreach ($meses as $key => $value) {
 	$arrayNomina['mes']=$key;
 	$arrayNomina['anio']=date("Y");
 	$arrayNomina['suma']=1;
 	$nomina[$key]=$this->contabilidadmodelo->gastosTipoNomina($arrayNomina);
 	$nominaCanal[$key]=$this->contabilidadmodelo->gastosTipoNominaPorCanal($arrayNomina);
 	$llave=$key;
 	foreach ($departamentos as $valueDpto) 
 	{ 		
 		$datos[$value][$valueDpto->idPersonaDepartamento]['personaDepartamento']=$valueDpto->personaDepartamento; 		
 		foreach ($relDptoApertura as  $valueDptoApertura) 
 		   {
 			 if($valueDptoApertura->idPersonaDepartamento==$valueDpto->idPersonaDepartamento)
 			 {
 				$datos[$value][$valueDpto->idPersonaDepartamento]['idPersonaDepartamento']=$valueDpto->idPersonaDepartamento;
 				//$datos[$value][$valueDpto->idPersonaDepartamento]['presupuesto']=$valueDptoApertura->montoDAC/12;
 				$montoMes['idAperturaContable']=$_POST['aperturaContable'];
 				$montoMes['idPersonaDepartamento']=$valueDpto->idPersonaDepartamento;
 				$montoMes['idMes']=$numMes;
 				//$presu=$this->db->get('aperturacontablemontomes')->result_array()[0]['montoMes'];
 				$presu=$this->contabilidadmodelo->devolverAperturaContableMontoMes($montoMes);
 				
 				$datos[$value][$valueDpto->idPersonaDepartamento]['presupuesto']=$presu[0]['montoMes'];
 				$datos[$value][$valueDpto->idPersonaDepartamento]['numMes']=$numMes;
 				$datos[$value][$valueDpto->idPersonaDepartamento]['presupuestoAutorizado']=0;
 				$consulta['mes']=$numMes;
 				$consulta['idAperturaContable']=$_POST['aperturaContable'];
 				$consulta['idPersonaDepartamento']=$valueDpto->idPersonaDepartamento; 		
 				$datos[$value][$valueDpto->idPersonaDepartamento]['presupuestoAutorizado']=$this->contabilidadmodelo->devolverPresupuestoAutorizado($consulta);
 				$datos[$value][$valueDpto->idPersonaDepartamento]['presupuestoPagado']=$this->contabilidadmodelo->devolverPresupuestoPagado($consulta); 
                $consulta['tipoGastoEspecial']='ccc';
                $datos[$value][$valueDpto->idPersonaDepartamento]['gastoCCC']=$this->contabilidadmodelo->devolverGastosEspecialesPagados($consulta);
                $consulta['tipoGastoEspecial']='cco';
                $datos[$value][$valueDpto->idPersonaDepartamento]['gastoCCO']=$this->contabilidadmodelo->devolverGastosEspecialesPagados($consulta);

                $consulta['tipoGastoEspecial']='inversion';
                $datos[$value][$valueDpto->idPersonaDepartamento]['gastoInversion']=$this->contabilidadmodelo->devolverGastosEspecialesPagados($consulta);

 				$datos[$value][$valueDpto->idPersonaDepartamento]['saldoMes']=$datos[$value][$valueDpto->idPersonaDepartamento]['presupuesto']-$datos[$value][$valueDpto->idPersonaDepartamento]['presupuestoAutorizado'];
 				
 				$datosCuentas[$value]['pagado']=$this->contabilidadmodelo->devolverPresupuestoPagadoPorCuenta($consulta);
 				$datosCuentas[$value]['autorizado']=$this->contabilidadmodelo->devolverPresupuestoAutorizadoPorCuenta($consulta);
 			}
 		}
 	}
 	$numMes++;
 }

	$data['usuariosPresupuestos']= $this->capsysdre->usuariosDePresupuestos();
	 $data['tipoVista']="controlPresupuesto";
  $data['Listafacturas']= $this->capsysdre->ListafacturasParaAutorizar();
  $data['presuma']= 0;
  $data['aperturaContable']=$this->contabilidadmodelo->aperturaContable(null);
  $data['departamentos']=$this->catalogos_model->obtenerCatAbtDpto(null);
  $data['reporte']=$datos;
  $data['reporteCuentas']=$datosCuentas;
  $data['nomina']=$nomina;
  $data['nominaCanal']=$nominaCanal;
  $data['idAperturaContable']=$_POST['aperturaContable'];

$this->load->view('presupuestos/controlpresupuestos',$data);


//echo json_encode($respuesta);

  }
//-----------------------------------------------------------------------------------------------------
function devuelveFacturasUsuarioAC2(){
$meses=$this->libreriav3->devolverMeses();
 $mes=['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
 //$datos="";

 $departamentos=$this->catalogos_model->obtenerCatAbtDpto(null);
 $relDptoApertura=$this->contabilidadmodelo->devolverDepartamentosPorApertura($_GET['aperturaContable']);
 $numMes=1;
 foreach ($meses as $key => $value) {
 	//$datos[$key]['meses']=$value; 	
 	/*$datos[$value]['presupuesto']=0;
 	$datos[$value]['autorizado']=0;
 	$datos[$value]['pagado']=0;
 	$datos[$value]['saldo']=0;*/
 	//$datos[$value]['numAnio']->
 	
 	foreach ($departamentos as $valueDpto) {
 		//$datos[$value][$valueDpto->idPersonaDepartamento]->personaDepartamento="";
// 		$pDepartamento="prueb";
 		$pDepartamento=$valueDpto->idPersonaDepartamento;
 		$datos[$key][$pDepartamento]->personaDepartamento=$valueDpto->personaDepartamento;
 		foreach ($relDptoApertura as  $valueDptoApertura) {
 			if($valueDptoApertura->idPersonaDepartamento==$valueDpto->idPersonaDepartamento){;
 				$datos[$key][$valueDpto->idPersonaDepartamento]->idPersonaDepartamento=$valueDpto->idPersonaDepartamento;
 				$datos[$key][$valueDpto->idPersonaDepartamento]->presupuesto=$valueDptoApertura->montoDAC/12;
 				$datos[$key][$valueDpto->idPersonaDepartamento]->numMes=$numMes;
 				$datos[$key][$valueDpto->idPersonaDepartamento]->presupuestoAutorizado=0;
 				$consulta['mes']=$numMes;
 				$consulta['idAperturaContable']=$_GET['aperturaContable'];
 				$consulta['idPersonaDepartamento']=$valueDpto->idPersonaDepartamento; 		
 				$datos[$key][$valueDpto->idPersonaDepartamento]->presupuestoAutorizado=$this->capsysdre->devolverPresupuestoAutorizado($consulta);
 				$datos[$key][$valueDpto->idPersonaDepartamento]->presupuestoPagado=$this->capsysdre->devolverPresupuestoPagado($consulta);
 				$datos[$value][$valueDpto->idPersonaDepartamento]->saldoMes=$datos[$value][$valueDpto->idPersonaDepartamento]->presupuesto-$datos[$value][$valueDpto->idPersonaDepartamento]->presupuestoAutorizado;
 			}
 		}
 	}
 	$numMes++;
 }
$respuesta['respuesta']=$datos;


echo json_encode($respuesta);

  }
//-----------------------------------------------------------------------------------------------------
function nuevoGiro(){
	$nombreGiro=ucfirst($_POST['giro']); 
	$idGiro=0; 
	$respuesta=$this->catalogos_model->comprobarExistenciaCatalogoGiros($nombreGiro);	
	if(isset($respuesta))//if(count($respuesta)==0)
	{
		$insert['idGiro']=-1;
		$insert['giro']=$nombreGiro;
		$idGiro=$this->catalogos_model->catalogo_giros($insert);    
		
	}
	else
	{
       $idGiro=$respuesta[0]->idGiro;
	}
  $catalogoGiro=$this->catalogos_model->catalogo_giros(null);
  $total=count($catalogoGiro);
  $datos['catalogo']=$catalogoGiro;
  $datos['activo']=$idGiro;
 echo json_encode($datos);   
}
//-----------------------------------------------------------------------------------------------------
function controlPresupuesto(){
#$data['usuariosPresupuestos']= $this->capsysdre->usuariosDePresupuestos();
#$data['tipoVista']="controlPresupuesto";
#$data['Listafacturas']= $this->capsysdre->ListafacturasParaAutorizar();
#$data['presuma']= 0;//$this->capsysdre->SumaPresupuestos();
$data['aperturaContable']=$this->contabilidadmodelo->aperturaContable(null);
#$data['departamentos']=$this->catalogos_model->obtenerCatAbtDpto(null);
$r=$this->contabilidadmodelo->aperturaContable(null);
$_POST['aperturaContable']=$data['aperturaContable'][0]->idAperturaContable;
$_POST['idPersonaDepartamento']=0;
//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data['aperturaContable'][0]->idAperturaContable, TRUE));fclose($fp);
$this->devuelveFacturasUsuarioAC();
//$this->crearSelect($this->contabilidadmodelo->aperturaContable(null));
//$this->load->view('presupuestos/listafacturasautoriza',$data);
#$this->load->view('presupuestos/controlpresupuestos',$data);
			 
}
//------------------------------------------------------------------------
//huricm 12-03-2021
function verificaProveedor()
{
	
	$proveedor = $_POST['id'];
	$apertura = $_POST['apertura'];
	$consulta = "Select * from proveedores where id =".$proveedor;	
	$registo['provedores'] = $this->db->query($consulta)->result();	
	$consulta = "Select anioAC from aperturacontable where idAperturaContable =".$apertura;
    $registo['anodeapertura']=$this->db->query($consulta)->result();
	echo json_encode($registo);

}
//-------------------------------------------------
function actualizadatosProveedor()
{
	$proveedor = $_POST['id'];
	$nombreprovedor = $_POST['nombreprovedor'];
	$contacto = $_POST['contacto'];
	$telefono = $_POST['telefono'];
	$extencion = $_POST['extencion'];
	$celular = $_POST['celular'];
	$direccion = $_POST['direccion'];
	$banco = $_POST['banco'];
	$dias = $_POST['dias'];
	$clave = $_POST['clave'];
	$cuenta = $_POST['cuenta'];
	$correo = $_POST['correo'];
	$giro = $_POST['giro'];
	$consulta = "update proveedores set NombreProveedor ='".$nombreprovedor."', Nombre_contacto = '".$contacto."',telefono1 ='".$telefono."', extension = '".$extencion."', telefono_movil = '".$celular."', email= '".$correo."', direccion = '".$direccion."',banco ='".$banco."', cuenta='".$cuenta."', clabe='".$clave."', DiasCredito = '".$dias."', giroProveedor='".$giro."'   where id =".$proveedor;
	$this->db->query($consulta);
	echo json_encode('Acualizado');
	

}
//-------------------------------------------------
function eliminarFactura()
{
	$respuesta['mensaje']='LA factura no se elimino';
	$respuesta['status']=false;
	$respuesta['id']=$_POST['id'];
    $datosFactura=$this->db->query('select * from facturas where id='.$_POST['id'])->result_array();  
        
       
    


    //$fp = fopen('resultadoJason.txt','a');fwrite($fp,print_r($insert,TRUE));fclose($fp);
    $band=0;
    if($this->tank_auth->get_usermail()=='CONTABILIDAD@AGENTECAPITAL.COM'){$band=1;}
    else{if($this->tank_auth->get_usermail()==$datosFactura[0]['Usuario']){$band=1;}}
    if($band)
    {
    	$respuesta['mensaje']="FACTURA ELIMINADA";
    	$respuesta['status']=true;
    	$this->db->query('delete from facturas where id='.$_POST['id']);
    	$this->db->query('update notasparacompras set idFactura=null,estaFacturado=0 where idFactura='.$_POST['id']); 
    	    $insert['tabla']='facturas';
       $insert['idTabla']=$_POST['id'];
       $insert['email']=$this->tank_auth->get_usermail();
       $insert['idPersona']=$this->tank_auth->get_idPersona();
       $insert['datos']=json_encode($datosFactura[0]);  
       $this->db->insert('papelera',$insert); 
    }
    else
    {
      $respuesta['mensaje']="ESTA FACTURA NO CORRESPONDE A TU SESION";	
    }
	echo  json_encode($respuesta);
}
//-------------------------------------------------
	function VerFacturas() {
		$Usuario = $this->tank_auth->get_usermail();
		$consulta['Usuario'] = $Usuario;
		if($Usuario=='SISTEMAS@ASESORESCAPITAL.COM' || $Usuario=='CONTABILIDAD@AGENTECAPITAL.COM' || $Usuario=='DIRECTORGENERAL@AGENTECAPITAL.COM'|| $Usuario=='GERENTEOPERATIVO@AGENTECAPITAL.COM'){
			$consulta['Usuario']='';
		}
		if(isset($_POST['textFecInicial']) and isset($_POST['textFecFinal'])) {
        	$consulta['fechaInicial'] = $this->input->post('textFecInicial');
        	$consulta['fechaFinal'] = $this->input->post('textFecFinal');
        }
        $userfact = $this->db->query('select distinct(f.Usuario) from facturas f right join users u on u.email=f.Usuario where u.activated=1 and u.banned=0 and f.Usuario is not null ')->result_array();
        $data = $this->capsysdre->ListafacturasxuserTodas($consulta);
        $datos = $data->num_rows() > 0 ? $data->result() : array();

        $info['user'] = $userfact;
        $info['fact'] = $datos;
        $info['userEmail']=$this->tank_auth->get_usermail().'';
        echo json_encode($info);
        //$this->load->view('presupuestos/listafacturasTodas',$data);
	}

	function GetProveedor() {
		$idProveedor = $this->input->get('id');
		$data = $this->capsysdre->GetNombreProveedor($idProveedor);
		echo json_encode($data);
	}

	function GuardarArchivoFacturas(){
		/*DIRECCION PARA HACER CUANDO SE EJECUTE LOCALMENTE*/
		//$directorio="C:/wamp64/www/Capsys/www/V3/ArchivosPresupuesto/".$_POST['id']."";
		//base_url().'ArchivosPresupuesto/'.$_POST['id']."/"; 
		/*DIRECTORIO CUANDO SE SUBE AL SERVIDOR  */

		$directorio=$_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosPresupuesto/".$_POST['id']."";
		if(!file_exists($directorio)){
			@mkdir($directorio, 0700);
		}
     	$extension=explode(".",$_FILES['Archivo']['name'] );
     	$largo=count($extension);
   		$extensionCadena=strtoupper($extension[$largo-1]);
		if($extensionCadena=='PDF' ||  $extensionCadena=='XML'){
      		// $nuevoNombre=$_POST['anio']."-".$_POST['mes'];
        	$mi_archivo = 'Archivo';
        	$config['upload_path'] = $directorio;
        	$config['file_name'] =$_POST['id'].".".$extension[$largo-1];
        	$config['allowed_types'] = "*";
        	$config['max_size'] = "50000";
        	$config['max_width'] = "2000";
        	$config['overwrite'] = "TRUE";
        	$config['max_height'] = "2000";  
        	$this->load->library('upload', $config);        
        	if ($this->upload->do_upload($mi_archivo)) {
        		$data['uploadSuccess'] = $this->upload->data();
          		if($extensionCadena=='PDF' ){
          			$updateFactura='update facturas set archivoNombrePDF="'.$_POST['id'].'.'.$extension[$largo-1].'",	';
          			$updateFactura=$updateFactura.'archivoDescripcionPDF="'.$_FILES['Archivo']['name'].'"';
          			$updateFactura=$updateFactura." where id=".$_POST['id'];
          		}
          		if($extensionCadena=='XML' ){
          			$updateFactura='update facturas set archivoNombreXML="'.$_POST['id'].'.'.$extension[$largo-1].'",	';
          			$updateFactura=$updateFactura.'archivoDescripcionXML="'.$_FILES['Archivo']['name'].'"';
          			$updateFactura=$updateFactura." where id=".$_POST['id'];
          		}
         		$this->db->query($updateFactura);
         		$cadena['ruta']=base_url()."ArchivosPresupuesto/".$_POST['id']."/".$_POST['id'].".".$extension[$largo-1];
         		$cadena['archivo']=$_POST['id'].".".$extension[$largo-1];
         		$cadena['status']="0";
               	$archivoRespuesta['message']="GUARDADO";	
        	}
        	else{
        		$data['uploadError'] = $this->upload->display_errors();
         		$data['message']="PROBLEMAS AL PROCESAR EL ARCHIVO";	
        	}
		}
		else{
	     	$data['message']="FORMATO NO VALIDO";	
     	}
     	//Recarga p�gina de Facturas (No vista Agregar Facturas)
     	redirect('/presupuestos/VistafacturasTodas/');
		//echo json_encode($data);
  	}
 //-----------------------------------------------------------
function actualizarDatosFactura()
{
 $respuesta['success']=1;
 $consulta='select * from facturas where id='.$_POST['idFactura'];
 $factura=json_encode($this->db->query($consulta)->result()[0]);
 

 $idFactura=$_POST['idFactura'];
 unset($_POST['idFactura']);
 $this->db->where('id',$idFactura);
 $this->db->update('facturas',$_POST); 
 $insert['tabla']='facturas';
 $insert['idTabla']=$idFactura;
 $insert['datos']=$factura;
 $insert['email']=$this->tank_auth->get_usermail();
 $insert['idPersona']=$this->tank_auth->get_idPersona();
 $this->db->insert('actualizaciones_tablas',$insert);
  $consulta='select f.*,p.NombreProveedor,c.formaPago from facturas f left join proveedores p on p.id=f.idProveedor left join catalog_formapago c on c.idFormaPago=f.posteriorapago where f.id='.$idFactura;

 $respuesta['factura']=$this->db->query($consulta)->result()[0];
 $respuesta['idFactura']=$idFactura;
 echo json_encode($respuesta);
}
//-----------------------------------------------------------
function datosDeFactura()
{
  $respuesta['success']=1;
  $consulta='select * from facturas f where f.id='.$_POST['idFactura'];
  $respuesta['factura']=$this->db->query($consulta)->result()[0];
  $respuesta['user']=$this->tank_auth->get_usermail();
  echo json_encode($respuesta);	
}
 
//-----------------------------------------------------------INGrOBERTO-ALVAREZ------------------------------------------------------------------------------
	function DescargarZip($id = null) {
		if ($id === null) {
			show_error('ID no proporcionado', 400);
		}

		// Ruta de la carpeta a comprimir
		// $folderPath = 'C:/wamp64/www/Capsys/www/V3/ArchivosPresupuesto/' . $id;//localHOst
		// // $repository = $_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosPresupuesto/'.$id; //server
			// Detectar si estamos en localhost o en servidor

//$folderPath=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/ArchivosPresupuesto/".$id;
$folderPath=$_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosPresupuesto/".$id;
	/*	$isLocalhost = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);

		// Determinar la ruta de la carpeta según el entorno
		if ($isLocalhost) {
			// Ruta para entorno local (WAMP o XAMPP)
			$folderPath = 'C:/wamp64/www/Capsys/www/V3/ArchivosPresupuesto/' . $id;
		} else {
			// Ruta en el servidor (usando DOCUMENT_ROOT para que sea dinámico)
			$folderPath = rtrim($_SERVER["DOCUMENT_ROOT"], '/') . '/V3/ArchivosPresupuesto/' . $id;
		}*/

		// Verifica si la carpeta existe
		if (!is_dir($folderPath)) {
			show_error('La carpeta no existe', 404);
		}

		// Nombre temporal del ZIP
		$zipFileName = 'archivos_' . $id . '.zip';
		$zipFilePath = sys_get_temp_dir() . '/' . $zipFileName;

		$zip = new ZipArchive();
		if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
			show_error('No se pudo crear el archivo ZIP', 500);
		}

		// Añadir archivos al ZIP
		$files = scandir($folderPath);
		foreach ($files as $file) {
			if ($file !== '.' && $file !== '..') {
				$filePath = $folderPath . '/' . $file;
				$zip->addFile($filePath, $file); // El segundo parámetro es el nombre dentro del ZIP
			}
		}

		$zip->close();

		// Forzar descarga del ZIP
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
		header('Content-Length: ' . filesize($zipFilePath));
		readfile($zipFilePath);

		// Elimina el archivo temporal después de la descarga
		unlink($zipFilePath);
		exit;
	}

	public function ArchivosEncontrados($id = null) {
		header('Content-Type: application/json');

		if ($id === null) {
			echo json_encode(['mensaje' => 'ID no proporcionado']);
			return;
		}

		// Detectar si estamos en localhost
		$isLocalhost = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);

		// Determinar la ruta a usar
		if ($isLocalhost) {
			$repository = 'C:/wamp64/www/Capsys/www/V3/ArchivosPresupuesto/' . $id;
		} else {
			$repository = rtrim($_SERVER["DOCUMENT_ROOT"], '/') . '/V3/ArchivosPresupuesto/' . $id;
		}

		$url = base_url() . 'V3/ArchivosPresupuesto/' . $id;

		$data['repository'] = 'No existe';
		$data['files'] = [];

		if (file_exists($repository)) {
			$data['repository'] = $repository;
			$data['status'] = scandir($repository);

			foreach ($data['status'] as $val) {
				if ($val != '.' && $val != '..') {
					$data['files'][] = $val;
				}
			}
		}

		echo json_encode($data);
	}



	function ValidafJSN() {
		// Verifica si el usuario está logueado
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			// Obtiene las facturas desde el modelo
			$data['Listafacturas'] = $this->capsysdre->Listafacturasparavalidar();    

			// Establece la cabecera correcta para JSON
			header('Content-Type: application/json');

			// Convierte a array si es un resultado de base de datos
			$resultados = $data['Listafacturas']->result_array(); 

			// Devuelve la respuesta como JSON
			echo json_encode($resultados);
		}
	}

	function VistafacturasPrueba(){	
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
			$Usuario = $this->tank_auth->get_usermail();
			$data['ListaProveedores']= $this->capsysdre->ListaProveedores();
			$data['Listafacturas']= $this->capsysdre->Listafacturasxuser($Usuario);
			$data['Apertura'] =  $this->capsysdre->AperturaContable(); 
				$cuentasContable=$this->contabilidadmodelo->relCuentaContableDepartamentoPermiso(null);
			$data['catalogogiro'] = $this->catalogos_model->catalogosGiro();
			$data['permisosFormaPago']=$this->db->query('select rfp.*,cf.formaPago from relformapagousers rfp left join catalog_formapago cf on cf.idFormaPago=rfp.idFormaPago where rfp.email="'.$Usuario.'"')->result();
	$cuentasPorDepartamento=array();$cont=0;
	foreach ($cuentasContable as $value) {$cuentasPorDepartamento[$value->personaDepartamento][$cont]=$value;$cont++;}
	$data['cuentasPorDepartamento']=$cuentasPorDepartamento;
			$this->load->view('presupuestos/listafacturasPrueba',$data);
			
		}
	}
function obtenerFacturasJson() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$Usuario = $this->tank_auth->get_usermail();

        // Obtener facturas del usuario
			$Listafacturas = $this->capsysdre->Listafacturasxuser($Usuario);
			$facturas = $Listafacturas->result_array();

			foreach ($facturas as &$factura) {
            // Estatus de autorización
				$factura['estatus_autorizacion'] = ($factura['autorizadireccion'] > 0) ? 'AUTORIZADO' : 'PENDIENTE';

            // Estatus de pago
				$factura['estatus_pago'] = ($factura['pagado'] > 0) ? 'PAGADO' : 'PENDIENTE';

            // Tipo de factura
            switch ($factura['posteriorapago']) {
                case '0': $factura['tipo_factura'] = 'Factura Pospuesta'; break;
                case '1': $factura['tipo_factura'] = 'Factura Normal'; break;
                case '2': $factura['tipo_factura'] = 'Caja Chica'; break;
                case '3': $factura['tipo_factura'] = 'Toka'; break;
                case '4': $factura['tipo_factura'] = 'Amex'; break;
                case '5': $factura['tipo_factura'] = 'Nomina y Otros'; break;
                case '9': $factura['tipo_factura'] = 'DINNERCAP'; break;
                default:  $factura['tipo_factura'] = 'Desconocido'; break;
			}

            // Si tiene tarjeta asociada
            if (!empty($factura['idTarjetas'])) {
                // Obtener número de tarjeta y forma de pago
                $queryTarjeta = $this->db->query("
                    SELECT numeroTarjeta, idFormaPago
                    FROM tarjetas 
                    WHERE idTarjetas = " . intval($factura['idTarjetas']) . "
                    LIMIT 1
                ");
                $tarjeta = $queryTarjeta->row();

                if ($tarjeta) {
                    $factura['numeroTarjeta'] = $tarjeta->numeroTarjeta;

                    // Buscar descripción de la forma de pago
                    $queryForma = $this->db->query("
                        SELECT formaPago 
                        FROM catalog_formapago 
                        WHERE idFormaPago = " . intval($tarjeta->idFormaPago) . " 
                        LIMIT 1
                    ");
                    $forma = $queryForma->row();
                    $factura['formaPago'] = $forma ? $forma->formaPago : null;
                } else {
                    $factura['numeroTarjeta'] = null;
                    $factura['formaPago'] = null;
                }
            } else {
                $factura['numeroTarjeta'] = null;
                $factura['formaPago'] = null;
            }
			}

			header('Content-Type: application/json');
			echo json_encode($facturas);
		}
	}

	function obtenerFacturasAjax() { 
		// Verificar si el usuario está logueado
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
			if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
			$Usuario = $this->tank_auth->get_usermail();
			$data['ListaProveedores']= $this->capsysdre->ListaProveedores();
			$data['Listafacturas']= $this->capsysdre->Listafacturasxuser($Usuario);
			$data['Apertura'] =  $this->capsysdre->AperturaContable(); 
				$cuentasContable=$this->contabilidadmodelo->relCuentaContableDepartamentoPermiso(null);
			$data['catalogogiro'] = $this->catalogos_model->catalogosGiro();
			$data['permisosFormaPago']=$this->db->query('select rfp.*,cf.formaPago from relformapagousers rfp left join catalog_formapago cf on cf.idFormaPago=rfp.idFormaPago where rfp.email="'.$Usuario.'"')->result();
			$cuentasPorDepartamento=array();$cont=0;
			foreach ($cuentasContable as $value) {$cuentasPorDepartamento[$value->personaDepartamento][$cont]=$value;$cont++;}
			$data['cuentasPorDepartamento']=$cuentasPorDepartamento;
			$this->load->view('presupuestos/vistaFactura',$data);
			
		}
			
		}
	}
	public function eliminarComprobantePagoVue() {
		$data = json_decode(file_get_contents("php://input"), true);
		$id = isset($data['id']) ? $data['id'] : null;

		if (!$id) {
			echo "ID NO ENVIADO";
			exit;
		}

		$consulta = $this->db->query("SELECT Comprobante_pago FROM facturas WHERE id = $id")->row();
		if (!$consulta || empty($consulta->Comprobante_pago)) {
			echo "NO EXISTE ARCHIVO";
			exit;
		}

		$archivo = $consulta->Comprobante_pago;
		// $ruta = $_SERVER["DOCUMENT_ROOT"] . "/Capsys/www/V3/ArchivosPresupuesto/$id/$archivo";
		/*DIRECTORIO CUANDO SE SUBE AL SERVIDOR  */
		$ruta = $_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosPresupuesto/$id/$archivo";

		if (file_exists($ruta)) {
			unlink($ruta);
		}

		$this->db->query("UPDATE facturas SET Comprobante_pago = '' WHERE id = $id");
		echo "COMPROBANTE ELIMINADO";
		exit;
	}
	public function subirComprobantePagoVue() {
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if (!$id || !isset($_FILES['Archivo'])) {
        echo "DATOS INCOMPLETOS";
        exit;
    }

    // $directorio = $_SERVER["DOCUMENT_ROOT"] . "/Capsys/www/V3/ArchivosPresupuesto/" . $id;//localhost
	$directorio = $_SERVER["DOCUMENT_ROOT"] . "/V3/ArchivosPresupuesto/" . $id; //SERVIDOR SERVIDOR
	
    if (!file_exists($directorio)) {
        @mkdir($directorio, 0700);
    }

    $extension = pathinfo($_FILES['Archivo']['name'], PATHINFO_EXTENSION);
    $extensionCadena = strtoupper($extension);

    $permitidas = ['PDF', 'JPG', 'JPEG', 'BMP', 'TIFF', 'WEBP'];
    $noPermitidas = ['PNG', 'GIF'];

    if (!in_array($extensionCadena, $permitidas) || in_array($extensionCadena, $noPermitidas)) {
        echo "FORMATO NO VALIDO";
        exit;
    }

    $fecha = str_replace([" ", ":"], "_", date("Y-m-d H:i:s"));
    $file_name = $id . "_comprobante_" . $fecha . "." . strtolower($extension);
    $mi_archivo = 'Archivo';

    $config['upload_path'] = $directorio;
    $config['file_name'] = $file_name;
    $config['allowed_types'] = '*';
    $config['max_size'] = "50000";
    $config['overwrite'] = TRUE;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload($mi_archivo)) {
        $this->db->query("UPDATE facturas SET Comprobante_pago = '$file_name' WHERE id = $id");
        echo "ARCHIVO GUARDADO";
    } else {
        echo "PROBLEMAS AL PROCESAR EL ARCHIVO";
    }
    exit;
}

	function GuardarArchivoALV(){ //Modificado ROBERTO-ALVAREZ-26-MAYO-2025

		/*DIRECCION PARA HACER CUANDO SE EJECUTE LOCALMENTE*/
		//$directorio=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/ArchivosPresupuesto/".$_POST['id']."";
		//base_url().'ArchivosPresupuesto/'.$_POST['id']."/"; 
		/*DIRECTORIO CUANDO SE SUBE AL SERVIDOR  */
		 $directorio=$_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosPresupuesto/".$_POST['id']."";
		if(!file_exists($directorio))
		{@mkdir($directorio, 0700);}

		$extension=explode(".",$_FILES['Archivo']['name'] );
		$largo=count($extension);

   		$extensionCadena=strtoupper($extension[$largo-1]);
		if($extensionCadena=='PDF' ||  $extensionCadena=='XML'){
      // $nuevoNombre=$_POST['anio']."-".$_POST['mes'];
      	$date = str_replace(array(" ",":"),"_",date("Y-m-d H:i:s"));
			$file_name = $_POST['id']."_".$date.".".$extension[$largo-1];
        $mi_archivo = 'Archivo';
        $config['upload_path'] = $directorio;
        	$config['file_name'] = $file_name;
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";
        $config['max_width'] = "2000";
        $config['overwrite'] = "TRUE";
        $config['max_height'] = "2000";  
        $this->load->library('upload', $config);        
        	if ($this->upload->do_upload($mi_archivo)) {
          if($extensionCadena=='PDF' ){
          		$updateFactura='update facturas set archivoNombrePDF="'.$file_name.'",	';
          $updateFactura=$updateFactura.'archivoDescripcionPDF="'.$_FILES['Archivo']['name'].'"';
          $updateFactura=$updateFactura." where id=".$_POST['id'];
           }
           if($extensionCadena=='XML' ){
          		$updateFactura='update facturas set archivoNombreXML="'.$file_name.'",	';
          $updateFactura=$updateFactura.'archivoDescripcionXML="'.$_FILES['Archivo']['name'].'"';
          $updateFactura=$updateFactura." where id=".$_POST['id'];
           }

         $this->db->query($updateFactura);
         	$cadena['ruta']=base_url()."ArchivosPresupuesto/".$_POST['id']."/".$file_name;
         	$cadena['archivo']=$file_name;
           	$archivoRespuesta="ARCHIVO GUARDADO";
         	//
         	$upload['uploadSuccess'] = $this->upload->data();
    		  	$status_type = 1;
         	$status = "success";
        }
        else{
        		$cadena = $_SERVER["DOCUMENT_ROOT"];
         $archivoRespuesta="PROBLEMAS AL PROCESAR EL ARCHIVO";	
         	//
         	$upload['uploadError'] = $this->upload->display_errors();
    	  		$status_type = 3;
    	    	$status = "error";
        }
        	//$data['register_upload'] = array("config" => $config, "upload" => $upload);
     }
		else{
			$cadena = "";
	     	$archivoRespuesta="FORMATO NO VALIDO";
	     	$status_type = 2;
    	   $status = "error";
             }
		
      //if(isset($_POST['vistaProcedente'])) {
      	$data['file'] = $cadena;
      	$data['format'] = $extensionCadena;
      	$data['status'] = $status;
      	$data['status_type'] = $status_type;
      	//echo json_encode($data);
        //  redirect('/presupuestos/Vistafacturas');
		echo $archivoRespuesta;
		exit;
  }
  function GuardarFacturaALV(){		
		if (!$this->tank_auth->isloggedin()) {redirect('/auth/login/');} 
		else 
		{
            
            

            $this->Vistafacturas();           
                  
			$fechacaptura	= (string)date('Y-m-d H:i:s');
			$fechafactura  = $this->input->post('1fNacimiento');
			$foliofac  = $this->input->post('folio');
			$concepto  = $this->input->post('concepto');
			$cargofianzas = $this->input->post('CargoFianzas');
			$cargoinst = $this->input->post('CargoInst');
			$cargogest = $this->input->post('CargoGes');
			$cargopromer = $this->input->post('CargoPromMer');
			$cargopromcan = $this->input->post('CargoPromCan');
			$cargocorpora = $this->input->post('Corporativos');
			$cargoAsesores=$this->input->post('Asesores');
			$cargototal = $this->input->post('CargoTotal');
			$Usuario = $this->tank_auth->get_usermail();
			$provee	= $this->input->post('provee');
			$iva = $this->input->post('iva');
			$cargototalconiva = $this->input->post('CargoTotalconIVA');
			$sucursal = $this->input->post('SUCUR');
            $idCuentaContable=$this->input->post('idCuentaContable');
            $idapertura = $this->capsysdre->AperturaContable();
			$pregunta = $this->input->post('hayfactura');
			$tipoGasto = $this->input->post('selectTipoGasto');           
			$ccc=  $this->input->post('ccc');
			$cco=  $this->input->post('cco');
			$inversion=  $this->input->post('inversion');
			$estrategia=  $this->input->post('estrategia');
            $cargogest = $ccc + $cco +$inversion+$estrategia;
            $idFormaPago=$this->input->post('tarjetaCredito');
            

			$cargofianzasDefault = $this->input->post('fianzasDefault');
			$cargoinstDefault = $this->input->post('institucionalDefault');
			$cargogestDefault = $this->input->post('gestionDefault');							
			$cargocorporaDefault = $this->input->post('coorporativoDefault');
			$cargoAsesoresDefault=$this->input->post('asesoresDefault');
			$motivoCambioPorcentaje=$this->input->post('motivoCambioPorcentajeInput');




            if($pregunta=='1')
            {	

            	$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`,
                                      `montoasesores`, 
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									  `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									  `idAperturaContable`,
									  `tipoGasto`,
									  `ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'1',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'
									);
											";

            
            }
            if($pregunta=='0'){

				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                       
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`, 
                                      `montoasesores`,
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									  `validada`,
									`idCuentaContable`,
									`idAperturaContable`,
									`tipoGasto`,
									`ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
									) 
									Values
									(

										'".$fechacaptura."',
										
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'0',
										'".$sucursal."',
										'0',
										'".$idCuentaContable."',
									    '".$idapertura."',
									    '".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

								

            }
            if($pregunta=='2'){


				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`, 
                                      `montoasesores`,
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									`idCuentaContable`,
									`idAperturaContable`,
									`tipoGasto`,
									`ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`	
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'2',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

								

            }

             if($pregunta=='3'){


				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`,  
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`,
                                      `montoasesores`, 
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									  `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									  `idAperturaContable`,
									  `tipoGasto`,
									  `ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
										
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'3',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

								

            }
            if($pregunta=='4'){


				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                      `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`, 
                                      `montoasesores`,
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									`idAperturaContable`,
									`tipoGasto`,
									`ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'4',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

								

            }
            if($pregunta=='5'){


$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                       `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`, 
                                      `montoasesores`,
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
									  `fecha_pago`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									  `idAperturaContable`,
									  `tipoGasto`,
									  `ccc`,
									  `cco`,
									  `inversion`,
									  `validada`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
										
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'1',
										'0',
										'".$fechafactura."',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'5',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'0',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

            }

            if($pregunta=='9'){
				$sqlInsert_Referencia = "
						Insert Ignore Into
							`facturas` 
									(
                                       `fecha_captura`, 
                                      `fecha_factura`, 
                                      `folio_factura`, 
                                      `concepto`, 
                                      `montofianzas`, 
                                      `montoinstitucional`, 
                                      `gestion`,
                                      `montoasesores`, 
                                      `promomid`, 
                                      `promocun`, 
                                      `corporativo`, 
                                      `otromonto1`, 
                                      `otromonto2`, 
                                      `totalfactura`, 
                                      `autorizadireccion`,
                                      `pagado`,
                                      `Usuario`,
									  `idProveedor`, 
									  `iva`, 
									  `totalconiva`, 
									   `posteriorapago`,
									  `sucursal`,
									  `idCuentaContable`,
									  `idAperturaContable`,
									  `tipoGasto`,
									  `ccc`,
									  `cco`,
									  `inversion`,
									  `estrategia`,
									  `idTarjetas`,
									  `montofianzasDefault`,
									  `montoinstitucionalDefault`,
									  `gestionDefault`,
									  `corporativoDefault`,
									  `montoasesoresDefault`,
									  `motivoCambioPorcentaje`
          
									) 
									Values
									(

										'".$fechacaptura."',
										'".$fechafactura."',
										'".$foliofac."',
										'".$concepto."',
										'".$cargofianzas."',
										'".$cargoinst."',
										'".$cargogest."',
										'".$cargoAsesores."',
										'".$cargopromer."',
										'".$cargopromcan."',
										'".$cargocorpora."',
										'0',
										'0',
										'".$cargototal."',
										'0',
										'0',
										'".$Usuario."',
										'".$provee."' ,
										'".$iva."',
										'".$cargototalconiva."',
										'9',
										'".$sucursal."',
										'".$idCuentaContable."',
										'".$idapertura."',
										'".$tipoGasto."',
										'".$ccc."',
										'".$cco."',
										'".$inversion."',
										'".$estrategia."',
										'".$idFormaPago."',
										'".$cargofianzasDefault."',
										'".$cargoinstDefault."',
										'".$cargogestDefault."',
										'".$cargocorporaDefault."',
										'".$cargoAsesoresDefault."',
										'".$motivoCambioPorcentaje."'

									);
											";

            }

			
			$this->db->query($sqlInsert_Referencia);			
			$referencia = $this->db->insert_id();
			
			if($_POST['textContieneNotasParaFacturar']!='')
			{
				$notas=explode(',', $_POST['textContieneNotasParaFacturar']);
				foreach ($notas as  $value) 
				{
				  if($value!='')
				  {
				  	$update['idFactura']=$referencia;
				  	$update['estaFacturado']=1;
				  	$update['idNotasCompra']=$value;
				  	$this->contabilidadmodelo->notasparacompras($update);
				  }
				}
			}


            //  redirect('presupuestos/Vistafacturas');

		}
	}


		function ValidaFacturaJson(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idfac  = $this->input->get('IDFact');
			$sqlInsert_Referencia = "UPDATE `facturas` SET `validada` = '1' WHERE `id`='".$idfac."'";	
			$this->db->query($sqlInsert_Referencia);

			$facturas = $this->capsysdre->Listafacturasparavalidar()->result_array();

			foreach ($facturas as &$factura) {
				// Nombre de usuario
				$factura['nombreUsuario'] = !empty($factura['Usuario']) 
					? $this->capsysdre->NombreUsuarioEmail($factura['Usuario']) 
					: null;

				// Nombre del proveedor
				$factura['nombreProveedor'] = !empty($factura['idProveedor']) 
					? $this->capsysdre->GetNombreProveedor($factura['idProveedor']) 
					: null;

				// Estatus de autorización
				$factura['estatus_autorizacion'] = ($factura['autorizadireccion'] > 0) ? 'AUTORIZADO' : 'PENDIENTE';

				// Estatus de pago
				$factura['estatus_pago'] = ($factura['pagado'] > 0) ? 'PAGADO' : 'PENDIENTE';

				// Tipo de factura
				switch ($factura['posteriorapago']) {
					case '0': $factura['tipo_factura'] = 'Factura Pospuesta'; break;
					case '1': $factura['tipo_factura'] = 'Factura Normal'; break;
					case '2': $factura['tipo_factura'] = 'Caja Chica'; break;
					case '3': $factura['tipo_factura'] = 'Toka'; break;
					case '4': $factura['tipo_factura'] = 'Amex'; break;
					case '5': $factura['tipo_factura'] = 'Nomina y Otros'; break;
					case '9': $factura['tipo_factura'] = 'DINNERCAP'; break;
					default:  $factura['tipo_factura'] = 'Desconocido'; break;
				}

				// Si tiene tarjeta asociada
				if (!empty($factura['idTarjetas'])) {
					$queryTarjeta = $this->db->query("
						SELECT numeroTarjeta, idFormaPago
						FROM tarjetas 
						WHERE idTarjetas = " . intval($factura['idTarjetas']) . "
						LIMIT 1
					");
					$tarjeta = $queryTarjeta->row();

					if ($tarjeta) {
						$factura['numeroTarjeta'] = $tarjeta->numeroTarjeta;

						$queryForma = $this->db->query("
							SELECT formaPago 
							FROM catalog_formapago 
							WHERE idFormaPago = " . intval($tarjeta->idFormaPago) . " 
							LIMIT 1
						");
						$forma = $queryForma->row();
						$factura['formaPago'] = $forma ? $forma->formaPago : null;
					} else {
						$factura['numeroTarjeta'] = null;
						$factura['formaPago'] = null;
					}
				} else {
					$factura['numeroTarjeta'] = null;
					$factura['formaPago'] = null;
				}
			}

			header('Content-Type: application/json');
			echo json_encode($facturas);
		}
	}
	//--------------------------------------------------------------------

	function VistafacturasTodasVue($fechaInicial = null, $fechaFinal = null) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}

		$Usuario = $this->tank_auth->get_usermail();

		if (!$fechaInicial || !$fechaFinal) {
			$fecha = getdate();
			$fechaInicial = $fecha['year'] . '-' . str_pad($fecha['mon'], 2, '0', STR_PAD_LEFT) . '-01';
			$fechaFinal = $fecha['year'] . '-' . str_pad($fecha['mon'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($fecha['mday'], 2, '0', STR_PAD_LEFT);
		}

		$consulta = [
			'fechaInicial' => $fechaInicial,
			'fechaFinal' => $fechaFinal,
			'Usuario' => $Usuario
		];

		if (in_array($Usuario, [
			'SISTEMAS@ASESORESCAPITAL.COM',
			'CONTABILIDAD@AGENTECAPITAL.COM',
			'DIRECTORGENERAL@AGENTECAPITAL.COM',
			'GERENTEOPERATIVO@AGENTECAPITAL.COM'
		])) {
			$consulta['Usuario'] = '';
		}

		$facturas = $this->capsysdre->ListafacturasxuserTodas($consulta);
		$facturas = is_object($facturas) ? $facturas->result_array() : $facturas;

		foreach ($facturas as &$factura) {
			// Nombre de usuario
			$factura['nombreUsuario'] = !empty($factura['Usuario']) 
				? $this->capsysdre->NombreUsuarioEmail($factura['Usuario']) 
				: null;

			// Nombre del proveedor
			$factura['nombreProveedor'] = !empty($factura['idProveedor']) 
				? $this->capsysdre->GetNombreProveedor($factura['idProveedor']) 
				: null;

			// Estatus de autorización
			$factura['estatus_autorizacion'] = ($factura['autorizadireccion'] > 0) ? 'AUTORIZADO' : 'PENDIENTE';

			// Estatus de pago
			$factura['estatus_pago'] = ($factura['pagado'] > 0) ? 'PAGADO' : 'PENDIENTE';

			// Tipo de factura
			switch ($factura['posteriorapago']) {
				case '0': $factura['tipo_factura'] = 'Factura Pospuesta'; break;
				case '1': $factura['tipo_factura'] = 'Factura Normal'; break;
				case '2': $factura['tipo_factura'] = 'Caja Chica'; break;
				case '3': $factura['tipo_factura'] = 'Toka'; break;
				case '4': $factura['tipo_factura'] = 'Amex'; break;
				case '5': $factura['tipo_factura'] = 'Nomina y Otros'; break;
				case '9': $factura['tipo_factura'] = 'DINNERCAP'; break;
				default:  $factura['tipo_factura'] = 'Desconocido'; break;
			}

			// Información de tarjeta y forma de pago
			if (!empty($factura['idTarjetas'])) {
				$queryTarjeta = $this->db->query("
					SELECT numeroTarjeta, idFormaPago
					FROM tarjetas 
					WHERE idTarjetas = " . intval($factura['idTarjetas']) . "
					LIMIT 1
				");
				$tarjeta = $queryTarjeta->row();

				if ($tarjeta) {
					$factura['numeroTarjeta'] = $tarjeta->numeroTarjeta;

					$queryForma = $this->db->query("
						SELECT formaPago 
						FROM catalog_formapago 
						WHERE idFormaPago = " . intval($tarjeta->idFormaPago) . " 
						LIMIT 1
					");
					$forma = $queryForma->row();
					$factura['formaPago'] = $forma ? $forma->formaPago : null;
				} else {
					$factura['numeroTarjeta'] = null;
					$factura['formaPago'] = null;
				}
			} else {
				$factura['numeroTarjeta'] = null;
				$factura['formaPago'] = null;
			}
		}

		header('Content-Type: application/json');
		echo json_encode($facturas);
		// header('Content-Type: application/json');//esto se queda va a servir mas adelante
				// echo json_encode([//esto se queda va a servir mas adelante
				// 	'facturas' => is_object($facturas) ? $facturas->result() : $facturas,//esto se queda va a servir mas adelante
				// 	'usuarios' => $usuarios//esto se queda va a servir mas adelante
				// ]);//esto se queda va a servir mas adelante
	}
	//--------------------------------------------------------------------
	function ListaPagosAutorizarVue() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$Usuario = $this->tank_auth->get_usermail();

			// Obtener facturas como array plano
			$facturas = $this->capsysdre->ListaPagos();
			$facturas = is_object($facturas) ? $facturas->result_array() : $facturas;
			foreach ($facturas as &$factura) {
				$factura['nombreUsuario'] = !empty($factura['Usuario']) 
					? $this->capsysdre->NombreUsuarioEmail($factura['Usuario']) 
					: null;

				$factura['nombreProveedor'] = !empty($factura['idProveedor']) 
					? $this->capsysdre->GetNombreProveedor($factura['idProveedor']) 
					: null;

				$factura['estatus_autorizacion'] = ($factura['autorizadireccion'] > 0) ? 'AUTORIZADO' : 'PENDIENTE';
				$factura['estatus_pago'] = ($factura['pagado'] > 0) ? 'PAGADO' : 'PENDIENTE';

				switch ($factura['posteriorapago']) {
					case '0': $factura['tipo_factura'] = 'Factura Pospuesta'; break;
					case '1': $factura['tipo_factura'] = 'Factura Normal'; break;
					case '2': $factura['tipo_factura'] = 'Caja Chica'; break;
					case '3': $factura['tipo_factura'] = 'Toka'; break;
					case '4': $factura['tipo_factura'] = 'Amex'; break;
					case '5': $factura['tipo_factura'] = 'Nomina y Otros'; break;
					case '9': $factura['tipo_factura'] = 'DINNERCAP'; break;
					default:  $factura['tipo_factura'] = 'Desconocido'; break;
				}

				if (!empty($factura['idTarjetas'])) {
					$queryTarjeta = $this->db->query("
						SELECT numeroTarjeta, idFormaPago
						FROM tarjetas 
						WHERE idTarjetas = " . intval($factura['idTarjetas']) . "
						LIMIT 1
					");
					$tarjeta = $queryTarjeta->row();

					if ($tarjeta) {
						$factura['numeroTarjeta'] = $tarjeta->numeroTarjeta;

						$queryForma = $this->db->query("
							SELECT formaPago 
							FROM catalog_formapago 
							WHERE idFormaPago = " . intval($tarjeta->idFormaPago) . " 
							LIMIT 1
						");
						$forma = $queryForma->row();
						$factura['formaPago'] = $forma ? $forma->formaPago : null;
					} else {
						$factura['numeroTarjeta'] = null;
						$factura['formaPago'] = null;
					}
				} else {
					$factura['numeroTarjeta'] = null;
					$factura['formaPago'] = null;
				}
			}

			// ⬇️ Devuelve el JSON limpio
			header('Content-Type: application/json');
			echo json_encode($facturas);
		}
	}
	

//--------------------------------------------------------------------
	function AutorizaFacVue($id){
		$sqlUpdate = "UPDATE `facturas` SET `autorizadireccion` = '1' WHERE `id` = ?";
		$this->db->query($sqlUpdate, array($id)); // Usar $id directamente
		$data = array('success' => true);

		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function AutorizaFacturaVue() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idfac = $this->input->get('IDFact');



			// Consultas principales
			$listafacturas = $this->capsysdre->ListafacturasParaAutorizar()->result_array();
			$usuarios = $this->capsysdre->usuariosDePresupuestos()->result_array();
			$presuma = $this->capsysdre->SumaPresupuestos();

			// Agrupación por tipo y sucursal
			$agrupacion = [
				'facturas' => [
					'facturas_posterior_a_pago' => [],
					'facturas_normales' => [],
					'facturas_toka' => [],
					'facturas_amex' => [],
					'facturas_nomina' => [],
					'facturas_dinnercap' => [],
					'facturas_otras' => []
				],
				'cajaChicaMerida' => [],
				'cajaChicaNorte' => [],
				'cajaChicaCancun' => []
			];

			foreach ($listafacturas as &$factura) {
				// Nombre de usuario
				$factura['nombreUsuario'] = !empty($factura['Usuario']) 
					? $this->capsysdre->NombreUsuarioEmail($factura['Usuario']) 
					: null;
				$factura['nombreProveedor'] = !empty($factura['idProveedor']) 
					? $this->capsysdre->GetNombreProveedor($factura['idProveedor']) 
					: null;

				// Tipo de factura
				switch ($factura['posteriorapago']) {
					case '0': $factura['tipo_factura'] = 'Factura Posterior a Pago'; break;
					case '1': $factura['tipo_factura'] = 'Factura Normal'; break;
					case '2': $factura['tipo_factura'] = 'Caja Chica'; break;
					case '3': $factura['tipo_factura'] = 'Toka'; break;
					case '4': $factura['tipo_factura'] = 'Amex'; break;
					case '5': $factura['tipo_factura'] = 'Nomina y Otros'; break;
					case '9': $factura['tipo_factura'] = 'DINNERCAP'; break;
					default:  $factura['tipo_factura'] = 'Desconocido'; break;
				}

				// Datos extra presupuestales
				$mes = substr($factura['fecha_factura'] ?: $factura['fecha_captura'], 5, 2);

				// acumuladoMensual
				$acumuladoMes = [
					'idAperturaContable' => $factura['idAperturaContable'],
					'idPersonaDepartamento' => $factura['idPersonaDepartamento'],
					'mes' => $mes
				];
				$acumuladoMensual = $this->contabilidadmodelo->facturasQueAfectanPresupuesto($acumuladoMes);
				$factura['acumuladoMensual'] = (float)$acumuladoMensual;

				// montoMensual
				$montoMes = [
					'idAperturaContable' => $factura['idAperturaContable'],
					'idPersonaDepartamento' => $factura['idPersonaDepartamento'],
					'idMes' => $mes
				];
				$resultadoMontoMes = $this->contabilidadmodelo->devolverAperturaContableMontoMes($montoMes);
				$factura['montoMensual'] = isset($resultadoMontoMes[0]['montoMes']) ? (float)$resultadoMontoMes[0]['montoMes'] : 0;

				// presupuestoAutorizadoAnual
				$totalAnual = [
					'idAperturaContable' => $factura['idAperturaContable'],
					'idPersonaDepartamento' => $factura['idPersonaDepartamento']
				];
				$factura['presupuestoAutorizadoAnual'] = (float)$this->capsysdre->devolverPresupuestoAutorizado($totalAnual);

				// presupuestoAutorizado (versión "actual")
				$resLimite = $this->contabilidadmodelo->devolverAperturaContableMontoMes($totalAnual);
				$factura['presupuestoAutorizado'] = isset($resLimite[0]['montoMes']) ? (float)$resLimite[0]['montoMes'] : 0;

				// Clasificación por tipo y sucursal
				if ($factura['tipo_factura'] === 'Caja Chica') {
					switch (strtoupper($factura['sucursal'])) {
						case 'CANCUN':
							$agrupacion['cajaChicaCancun'][] = $factura;
							break;
						case 'NORTE':
							$agrupacion['cajaChicaNorte'][] = $factura;
							break;
						case 'MERIDA':
							$agrupacion['cajaChicaMerida'][] = $factura;
							break;
						default:
							$agrupacion['facturas']['facturas_otras'][] = $factura;
							break;
					}
				} else {
					switch ($factura['tipo_factura']) {
						case 'Factura Posterior a Pago':
							$agrupacion['facturas']['facturas_posterior_a_pago'][] = $factura;
							break;
						case 'Factura Normal':
							$agrupacion['facturas']['facturas_normales'][] = $factura;
							break;
						case 'Toka':
							$agrupacion['facturas']['facturas_toka'][] = $factura;
							break;
						case 'Amex':
							$agrupacion['facturas']['facturas_amex'][] = $factura;
							break;
						case 'Nomina y Otros':
							$agrupacion['facturas']['facturas_nomina'][] = $factura;
							break;
						case 'DINNERCAP':
							$agrupacion['facturas']['facturas_dinnercap'][] = $factura;
							break;
						default:
							$agrupacion['facturas']['facturas_otras'][] = $factura;
							break;
					}
				}
			}
			unset($factura);

			// Devolver en JSON
			$data = array(
				'success' => true,
				'Listafacturas' => $agrupacion,
				// 'usuariosPresupuestos' => $usuarios,
				// 'presuma' => $presuma,
				// 'tipoVista' => ''
			);

			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}


	
}