<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tableros_siniestros extends TIC_Controller{

	function __construct(){
		parent::__construct();
		//$this->load->library('smartyTemplate');
		//$this->load->library('graficos2');
        //$this->load->model(array('graficas_model','graficas'));
        $this->load->library('graficos');
        $this->load->library('session');
        $this->load->model(array('graficas_model','graficas'));
        $this->load->model('autos_model', 'autos');
        $this->load->model('danos_model', 'danos');
        $this->load->model('gmm_model', 'gmm');
    }


    public function index(){
        $filtro = array(
            "fecha" => date('Y-m-d'),
            "periodo" => 0,
            "puesto" => 0,
            "empresa" => 0,
            "colaborador" => 0,
            "periodos" => 0,
            "fechaInicio" => date('Y-m-d'),
            "fechaFin" => date('Y-m-d'),
        );

        $head = array('title' => 'Capsys - Siniestros Reportes');
        $data = array();
        $footer = array();
       

        //opcion para mostar el menu lateral
        $data["tipo"] = "Siniestros";


        $this->breadcrumbs->push('', '');
        $this->breadcrumbs->unshift('Registro de siniestros', '/Siniestros/registros');
        $this->breadcrumbs->unshift('Tablero', '/Siniestros');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        //graficas de autos
        $year=date('Y');
        $month=date('m');
        $hearders = $this->get_head_rango();
        $data["grafico1"]=$this->graficos->render("SINIESTROS_AUTOS_TOTAL",$filtro,'A');
        $data["grafico2"]=$this->graficos->render("SINIESTROS_AUTOS_ANO_ACTUAL",$filtro,'A');
        $data["grafico3"]=$this->graficos->render("SINIESTROS_AUTOS_COMPARACION",$filtro,'A');
        $data["grafico4"]=$this->graficos->render("SINIESTROS_TOP_ESTADOS_AUTOS",$filtro,'A');
        $data["grafico5"]=$this->graficos->render("SINIESTROS_RANGO_AUTOS",$filtro,'A');
        $data["tablaAutosmes"]=$this->graficas->getReporteTableAutos($year,$month);
        $data["tablaAutos"]=$this->graficas->getReporteTableAutos($year);

        //graficas de DAÑOS
        $data["grafico6"]=$this->graficos->render("SINIESTROS_DANOS_TOTAL",$filtro,'D');//SINIESTROS_DANOS_ANO_ACTUAL
        $data["grafico7"]=$this->graficos->render("SINIESTROS_DANOS_ANO_ACTUAL",$filtro,'D');
        $data["grafico8"]=$this->graficos->render("SINIESTROS_DANOS_COMPARACION",$filtro,'D');
        $data["grafico9"]=$this->graficos->render("SINIESTROS_TOP_ESTADOS_DANOS",$filtro,'D');
        $data["grafico10"]=$this->graficos->render("SINIESTROS_RANGO_DANOS",$filtro,'D');
        $data["tablaDanos"]=$this->graficas->getReporteTableDanos($year);
        $data["tablaDanosmes"]=$this->graficas->getReporteTableDanos($year,$month);

        //graficas de GMM
        $data["grafico11"]=$this->graficos->render("SINIESTROS_GMM",$filtro,'G');
        $data["grafico12"]=$this->graficos->render("SINIESTROS_GMM_ANO_ACTUAL",$filtro,'G');
        $data["grafico13"]=$this->graficos->render("SINIESTROS_GMM_COMPARACION",$filtro,'G');
        $data["grafico14"]=$this->graficos->render("SINIESTROS_TOP_ESTADOS_GMM",$filtro,'G');
        $data["grafico15"]=$this->graficos->render("SINIESTROS_RANGO_GMM",$filtro,'G');

        $data["tablaGmm"]=$this->graficas->getReporteTableGmm($year);
        $data["tablaGmmmes"]=$this->graficas->getReporteTableGmm($year,$month);
        $tipos_tramites=$this->danos->getTramitesDanos();
        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'css/apexcharts.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )
        ));

        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/plugins/apexcharts/apexcharts.js'
            ),
            array(
                'type' => 'JSHTML',
                'data' =>  "const _headers = " . json_encode($hearders) . ";"."const _Tram = " . json_encode($tipos_tramites) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modal-filtro.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/tablero_siniestros.js'
            ),
            array(
                'type' => 'JSON',
                'path' => 'Apex.chart = {
                        locales: 
                            [
                                {
                                    "name": "es",
                                    "options": {
                                        "months": 
                                        [
                                            "Enero",
                                            "Febrero",
                                            "Marzo",
                                            "Abril",
                                            "Mayo",
                                            "Junio",
                                            "Julio",
                                            "Agosto",
                                            "Septiembre",
                                            "Octubre",
                                            "Noviembre",
                                            "Diciembre"
                                        ],
                                        "shortMonths": [
                                            "Ene",
                                            "Feb",
                                            "Mar",
                                            "Abr",
                                            "May",
                                            "Jun",
                                            "Jul",
                                            "Ago",
                                            "Sep",
                                            "Oct",
                                            "Nov",
                                            "Dic"
                                        ],
                                        "days": [
                                            "Domingo",
                                            "Lunes",
                                            "Martes",
                                            "Miércoles",
                                            "Jueves",
                                            "Viernes",
                                            "Sábado"
                                        ],
                                        "shortDays": ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                                        "toolbar": {
                                            "exportToSVG": "Descargar SVG",
                                            "exportToPNG": "Descargar PNG",
                                            "exportToCSV": "Descargar CSV",
                                            "menu": "Menu",
                                            "selection": "Seleccionar",
                                            "selectionZoom": "Seleccionar Zoom",
                                            "zoomIn": "Aumentar",
                                            "zoomOut": "Disminuir",
                                            "pan": "Navegación",
                                            "reset": "Reiniciar Zoom"
                                        }
                                    }
                                }
                            ],
                            defaultLocale: "es"
                    };
                  '
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico1"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico2"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico3"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico4"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico5"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico6"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico7"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico8"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico9"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico10"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico11"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico12"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico13"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico14"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico15"]["JS"]
            ),
           
            
        ));
        $this->render('tableros/tablero_autos', $head, $data, $footer);
    }

    //Llamadas de las tablas de los reportes
    function getTable($tipo){
        //$today = date("Y");
        $date=$this->input->post('fecha')?date('Y',strtotime($this->input->post('fecha'))):date('Y');
        $today=$date;
		$tabla=[];
		switch ($tipo) {
			case 'A':
				$tabla["data"] = $this->graficas->get_rango_table_2($today,$tipo);
                break;
            case 'D':
                $tabla["data"] = $this->graficas->get_rango_table_2($today,$tipo);
            break;
            case 'G':
                $tabla["data"] = $this->graficas->get_rango_table_GMM($today,$tipo);
            break;
            
			default:
				break;
		}
		$this->responseJSON("200", "Exíto", $tabla);
    }
    
    function get_head_rango()
	{
		$arrayRango = $this->graficas->get_rango();
		$lastkey = end($arrayRango);
		$arrayreturn = array();
		$count = 0;
		foreach ($arrayRango as $key => $value) {
			if ($key == 0) {
				$count == 0 ? array_push($arrayreturn, array("title" => "DÍAS RESPUESTA", "data" => NULL, "defaultContent" => "TOTALES")) : array_push($arrayreturn, array("title" => "DÍAS RESPUESTA", "data" => NULL, "defaultContent" => "DIAS RESPUESTA"));
				array_push($arrayreturn, array("title" => "0-" . $value["rango"], "data" => "0-" . $value["rango"], "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
			} elseif ($lastkey["id"] == $value["id"]) {
				array_push($arrayreturn, array("title" => ($arrayRango[$key - 1]["rango"] + 1) . "-" . $value["rango"], "data" => ($arrayRango[$key - 1]["rango"] + 1) . "-" . $value["rango"], "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
				array_push($arrayreturn, array("title" => "Mas de " . $value["rango"], "data" => "Mas de " . $value["rango"], "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
				array_push($arrayreturn, array("title" => "Total", "data" => "Total", "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
			} else {
				array_push($arrayreturn, array("title" => ($arrayRango[$key - 1]["rango"] + 1) . "-" . $value["rango"], "data" => ($arrayRango[$key - 1]["rango"] + 1) . "-" . $value["rango"], "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
			}
			$count++;
		}
		return $arrayreturn;
    }
    

    ///metodo para actualziar las tablas
    public function updateChart()
    {
        $filtros = array();
        $djason = json_decode(file_get_contents("php://input"), true);
        if($djason["clientes"]=="0"||$djason["clientes"]==""){
            $clientesDB=$this->graficas->getClientesEjecutivo($this->tank_auth->get_idPersona());
            $clientes=$this->map_clientes($clientesDB);
        }else{
            $clientes="(".$djason["clientes"].")";
        }
        //echo $clientes;
        $djason["clientes"]=$clientes;
        //var_dump($djason);
        switch ($djason["charName"]) {
            case 'INCIDENCIAS_MENSUALES':
                $filtros = $this->graficos->getDatos($djason);
                break;
            case 'INCIDENCIAS_TRIMESTRAL':
                $filtros = $this->graficos->getDatos($djason);
                break;
            case 'COMPARATIVO_COLABORADORES':
                $filtros = $this->graficos->getDatosLine($djason);
                break;
            case 'ROTACION_PERSONAL':
                $filtros = $this->graficos->getRotacion($djason);
                break;
            case 'CRECIMIENTO_PERIODO':
                $filtros = $this->graficos->getCrecimiento($djason);
                break;
            case 'EVALUACIONES_COMPETENCIAS':
                $filtros = $this->graficos->getEvalByCompetencia($djason);
                break;
            case "EVALUACIONES_DESEMPENIO":
                $filtros = $this->graficos->getEvaluacionDesempenio($djason);
                break;
            case "REPORTE_BONO":
                $filtros = $this->bonos->getbonosreporte($djason["periodos"]["value"]);
                break;
            case "REPORTE_EVALUACIONES":
                $filtros = $this->evaluaciones->getReporteEvaluaciones($djason["periodos"]["value"], $djason);
                break;
            case "SINIESTROS_TODOS_LOS_MESES":
                $filtros = $this->graficos->get_data_siniestros($djason,"","");
                break;
            case "SINIESTROS_COMPARACION_MESES":
                $filtros = $this->graficos->get_data_siniestros_comparacion($djason,"","SINIESTROS_MESES");
                break;
            case "SINIESTROS_TOP_ESTADOS":
                $filtros = $this->graficos->getDatosTop($djason,"SINIESTROS_TOP");
                break;
            case "TABLA_MES_AUTOS":
                $year=date('Y', strtotime($djason['fecha']));
                $month=date('m', strtotime($djason['fecha']));
                $filtros = $this->graficas->getReporteTableAutos($year,$month);
                break;
            case "TABLA_ANO_AUTOS":
                $year=date('Y', strtotime($djason['fecha']));
                $filtros = $this->graficas->getReporteTableAutos($year);
                break;
            case "TABLA_MES_DANOS":
                $year=date('Y', strtotime($djason['fecha']));
                $month=date('m', strtotime($djason['fecha']));
                $filtros = $this->graficas->getReporteTableDanos($year,$month);
                break;
            case "TABLA_ANO_DANOS":
                $year=date('Y', strtotime($djason['fecha']));
                $filtros = $this->graficas->getReporteTableDanos($year);
                break;
            case "TABLA_MES_GMM":
                $year=date('Y', strtotime($djason['fecha']));
                $month=date('m', strtotime($djason['fecha']));
                $filtros = $this->graficas->getReporteTableGmm($year,$month);
                break;
            case "TABLA_ANO_GMM":
                $year=date('Y', strtotime($djason['fecha']));
                $filtros = $this->graficas->getReporteTableGmm($year);
                break;
            //AUTO-INDICUAL
            case "SINIESTROS_AUTOS_ANO_ACTUAL":
                //$year=date('Y', strtotime($djason['fecha']));
                $filtros = $this->graficos->getSiniestrosAutosAnos($djason,"A");
                break;
            case "SINIESTROS_AUTOS_ANO_ACTUAL":
                    //$year=date('Y', strtotime($djason['fecha']));
                $filtros = $this->graficos->getSiniestrosAutosAnos($djason,"A");
                break;
            case "SINIESTROS_AUTOS_COMPARACION":
                $filtros = $this->graficos->get_data_siniestros_comparacion_2($djason,"A");
                break;
            case "SINIESTROS_TOP_ESTADOS_AUTOS":
                $filtros = $this->graficos->getDatosTop_2($djason,"A");
                break;
            //DAÑOS
            case "SINIESTROS_DANOS_ANO_ACTUAL":
                $filtros = $this->graficos->getSiniestrosAutosAnos($djason,"D");
                break;
            case "SINIESTROS_DANOS_COMPARACION":
                $filtros = $this->graficos->get_data_siniestros_comparacion_2($djason,"D");
                break;
            case "SINIESTROS_TOP_ESTADOS_DANOS":
                $filtros = $this->graficos->getDatosTop_2($djason,"D");
                break;
            //GMM
            case "SINIESTROS_GMM_ANO_ACTUAL":
                $filtros = $this->graficos->getSiniestrosGMMAnos($djason,"G");
                break;
            case "SINIESTROS_GMM_COMPARACION":
                $filtros = $this->graficos->get_data_siniestros_comparacion_GMM($djason,"G");
                break;
            case "SINIESTROS_TOP_ESTADOS_GMM":
                $filtros = $this->graficos->getDatosTop_GMM($djason,"G");
                break;
            case "SINIESTROS_AUTOS_TOTAL":
                $filtros=$this->graficos->getstatusAutosSiniestros($djason,"A");
                break;
            case "SINIESTROS_DANOS_TOTAL":
                $filtros=$this->graficos->getstatusAutosSiniestros($djason,"D");
                break;
            case "SINIESTROS_GMM":
                $filtros=$this->graficos->getstatusGMM($djason,"G");
                 break;
             //tablas de rango
            case "SINIESTROS_RANGO_AUTOS":
                $filtros=$this->graficos->getDatosRango($djason,"A");
                break;
            case "SINIESTROS_RANGO_DANOS":
                $filtros=$this->graficos->getDatosRango($djason,"D");
                break;
            case "SINIESTROS_RANGO_GMM":
                $filtros=$this->graficos->getDatosRangoGMM($djason,"G");
                break;
            //graficas de los autos corporativos
            case "TEST":
                //$year=date('Y', strtotime($djason['fecha']));
                //$month=date('m', strtotime($djason['fecha']));
                $filtros=$this->graficos->getDatos($djason);
                break;
        }

        $this->responseJSON("200", "Exíto", $filtros);
    }

    function map_clientes($array){
        $clientes="(";
        $num=count($array);
        foreach ($array as $key => $value) {
            if($num-1==$key){
                $clientes=$clientes.$value["id"];
            }else{
                $clientes=$clientes.$value["id"].",";
            }
        }
        $clientes=$clientes.")";
        return empty($array)?"(0)":$clientes;
    }

    function map_clientes_array($array){
        $clientes=[];
        foreach ($array as $key => $value) {
            $clientes[]=$value["id"];
        }
        //$clientes=$clientes.")";
        return $clientes;
    }
    

    function getTablasEstatus(){
        $id=$this->input->post('id');
        $estatus=$this->input->post('estatus');
        /* $year=date('Y');
        $mes=date('m'); */
        $year=$this->input->post('ano')!=''?$this->input->post('ano'):date('Y');
        $mes=$this->input->post('mes')!=''?$this->input->post('mes'):date('m');
        $id_estatus=$this->graficas->getIdestatus($estatus);
        $arraydata = array(
            'id_tabla'=>$id,
            'estatus'  => $id_estatus,
            'year'     => $year,
            'mes' => $mes,
            'nombre_estatus'=>$estatus
        );
        $this->session->set_userdata($arraydata);
        //$id_estatus=1;
        $data=array();
       
        switch ($id) {
            case "SINIESTROS_AUTOS_TOTAL":
                $data=$this->autos->getAllAutos($id_estatus, $year,$mes);
                break;
            case "SINIESTROS_DANOS_TOTAL":
                $data=$this->danos->getAllDanos2($id_estatus, $year,$mes);
                break;
            case "SINIESTROS_GMM":
                $data=$this->gmm->getAllTramitesTable($id_estatus, $year,$mes);
                break;
            case "TEST":
               $clientesDB=$this->graficas->getClientesEjecutivo($this->tank_auth->get_idPersona());
               $clientes=$this->map_clientes_array($clientesDB);
               $data=$this->graficas->getAllAutosCtabla($estatus, $year,$mes,null,null,$clientes);
                break;
            
            default:
                $data=[];
                break;
        }
        $this->responseJSON("200", "Exíto", $data);
    }

    function getTablasRangosclikc(){
        $id=$this->input->post('id');
        //$estatus=$this->input->post('estatus');
        $year=date('Y');
        $rango1=$this->input->post('rango1');
        $rango2=$this->input->post('rango2');
        $arraydata = array(
            'id_tabla'=>$id,
            'estatus'  => '',
            'year'=> $year,
            'rango1'=>$rango1,
            'rango2'=>$rango2,
            'mes' => '',
        );
        $this->session->set_userdata($arraydata);
        switch ($id) {
            case "SINIESTROS_RANGO_AUTOS":
                $data=$this->autos->getAllAutostablaRango("0", $year,null,$rango1,$rango2);
                break;
            case "SINIESTROS_RANGO_DANOS":
                $data=$this->danos->getAllDanosTablaRangos("0", $year,null,$rango1,$rango2);
                break;
            case "SINIESTROS_RANGO_GMM":
                $data=$this->gmm->getAllTramitesTableRangos("0", $year,null,$rango1,$rango2);
                break;
            case "CORTE_SINIESTROS":
                $clientesDB=$this->graficas->getClientesEjecutivo($this->tank_auth->get_idPersona());
                $clientes=$this->map_clientes_array($clientesDB);
                $data=$this->graficas->getAllAutostablaRangoC("0",$year,null,$rango1,$rango2,$clientes);
                break;
            default:
                $data=[];
                break;
        }
        $this->responseJSON("200", "Exíto", $data);
    }


    function printExcelRegistros(){
        //$dataIDS=$this->session->flashdata('filtros');
        $dataIDS="test";
        if($dataIDS!=''){
            date_default_timezone_set('America/Merida');
            //$tabla=$this->autos->getAllAutos($this->session->flashdata('estatus'), $this->session->flashdata('year'), $this->session->flashdata('mes'));
            $tabla=$this->getDataExcel($this->session->userdata('id_tabla'));
            $contador = 2;
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);         
            $this->excel->getActiveSheet()->setTitle('test worksheet');         
            $this->excel->getActiveSheet()->setCellValue('A1', 'Reporte de siniestros '.date('Y-m-d H:s'));         
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20)->setBold(true);
            $this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
            

            ///Headers de la tabla
            //$headers=$tabla[0];
            $headers=max($tabla);
            $HC=0;
            foreach ($headers as $key => $H) {
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC,$contador,$key);
                $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                $celda=$column.$contador;
                $this->excel->getActiveSheet()->getStyle($celda)->getFont()->setSize(10)->setBold(true);
                $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'C8ACE8')
                        )
                    )
                );
                //$this->excle->getActiveSheet()->
                $HC++;
            }
            $HC=0;
            $contador=3;
            foreach($tabla as $key => $ls){
                $keysH=array_keys($ls);
                foreach ($keysH as $keys => $value) {
                    $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                    $celda=$column.$contador;
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC,$contador,$ls[$value]==''?'NA':$ls[$value]);
                    $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'EDE6F5')
                            )
                        )
                    );
                    $HC++;
                }
                $HC=0;
                $contador++;
            }
            //$this->excel->getActiveSheet()->mergeCells('A1:D1');           
            $filename='Siniestro_Registros'.date('Y-m-d').'.xls';
            header('Content-Type: application/vnd.ms-excel');         
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); //no cache 
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');         
            
            // Forzamos a la descarga         
            $objWriter->save('php://output');
            //echo 'phpExcel/nombredelfichero.xls';
        }else{
            $this->responseJSON(400, "No hay información de los siniestros", []);
        }
    }

    function getDataExcel($id_tabla){
        $data=[];
        switch ($id_tabla) {
            case 'SINIESTROS_AUTOS_TOTAL':
                $dat=$this->autos->getDataExcelAutos($this->session->userdata('estatus'), $this->session->userdata('year'),$this->session->userdata('mes'));
                $data=$this->complementoRow($dat);
                break;
            case 'SINIESTROS_RANGO_AUTOS':
                $dat=$this->autos->getDataExcelAutos('0', $this->session->userdata('year'),null,$this->session->userdata('rango1'),$this->session->userdata('rango2'));
                $data=$this->complementoRow($dat);
                break;
            case 'SINIESTROS_DANOS_TOTAL':
                $dat=$this->danos->DataExcelDanos($this->session->userdata('estatus'), $this->session->userdata('year'),$this->session->userdata('mes'));
                $data=$this->complementoRow($dat);
                break;
            case 'SINIESTROS_RANGO_DANOS':
                $dat=$this->danos->DataExcelDanos('0', $this->session->userdata('year'),null,$this->session->userdata('rango1'),$this->session->userdata('rango2'));
                $data=$this->complementoRow($dat);
                break;
            case 'SINIESTROS_GMM':
                $dat=$this->gmm->getAllTramitesExcel($this->session->userdata('estatus'), $this->session->userdata('year'),$this->session->userdata('mes'));
                $data=$this->complementoRow($dat);
                break;
             case 'SINIESTROS_RANGO_GMM':
                $dat=$this->gmm->getAllTramitesExcel('0', $this->session->userdata('year'),null,$this->session->userdata('rango1'),$this->session->userdata('rango2'));
                $data=$this->complementoRow($dat);
                break;
            case 'TEST':
                $clientesDB=$this->graficas->getClientesEjecutivo($this->tank_auth->get_idPersona());
                $clientes=$this->map_clientes_array($clientesDB);
                $dat=$this->graficas->getDataExcelAutosC($this->session->userdata('nombre_estatus'), $this->session->userdata('year'),$this->session->userdata('mes'),null,null,$clientes);
                $data=$this->complementoRow($dat);
                break;
            case 'CORTE_SINIESTROS':
                $clientesDB=$this->graficas->getClientesEjecutivo($this->tank_auth->get_idPersona());
                $clientes=$this->map_clientes_array($clientesDB);
                $dat=$this->graficas->getDataExcelAutosC(0, $this->session->userdata('year'),null,$this->session->userdata('rango1'),$this->session->userdata('rango2'),$clientes);
                $data=$this->complementoRow($dat);
                break;
        }
        return $data;
    }

    function complementoRow($data){
        $newDta=[];
        foreach ($data as $key => $value) {
            $row=$value;
            
            if(isset($value["complemento_json"])){
                $parse_complemento=json_decode($value["complemento_json"],true);
                $corrdinador=$parse_complemento["cordinador"];
                foreach ($corrdinador as $C_key => $C_value) {
                    $row[$C_key]=$C_value;
                }
            }
            
            
            if(isset($parse_complemento["general"])){
                $general=$parse_complemento["general"];
                foreach ($general as $G_key => $G_value) {
                    $row[$G_key]=$G_value;
                }
            }

            if(isset($value["valores"])){
                $valores=json_decode($value["valores"],true);
                foreach ($valores as $V_key => $V_value) {
                    $row[$V_key]=$V_value;
                }
                unset($row["valores"]);
            }
            unset($row["complemento_json"]);
            $newDta[]=$row;

        }
        return $newDta;
    }

    function testCom(){
        /* $date=$this->input->post('fecha')?date('Y',strtotime($this->input->post('fecha'))):date('Y');
        $tipo='A';
        $sql=$this->graficas->get_rango_table_3($date,$tipo);
        $this->responseJSON(200, "Todas", $sql); */
        $data=[];
        /* $data["NO_Finalizado"]=$this->graficas->kpi_autosIndividual(null,"2021","NO");
        $data["Finalizado"]=$this->graficas->kpi_autosIndividual(null,"2021","SI"); */
        /* $data["NO_Finalizado"]=$this->graficas->kpi_Danos(null,"2021","NO");
        $data["Finalizado"]=$this->graficas->kpi_Danos(null,"2021","SI"); */
        /* $data["NO_Finalizado"]=$this->graficas->kpi_GMM(null,"2021","NO");
        $data["Finalizado"]=$this->graficas->kpi_GMM(null,"2021","SI"); */
        $data=$this->graficas->getKPI_Siniestros('AUTOSC',null,"2021",$this->tank_auth->get_idPersona());
        var_dump($data);
    }

}