<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class siniestroCorporativo extends TIC_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('siniestros_model', 'siniestro');
        $this->load->library('googledrive');
        $this->load->model("documentsmodel", "documento");
        date_default_timezone_set('America/Guatemala');
    }

    //pagina de inicio de GMMM
    function index()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $estados = $this->siniestro->getAllestatusT();
        $tipoS = $this->siniestro->tiposiniestro();
        $SeguimientoE = $this->siniestro->getAllData('siniestro_estatus_seguimiento');
        $s_etapas= $this->siniestro->getAllData('siniestro_etapa');
        $sguimientoByEtapa=$this->siniestro->getStatusTramitesByEtapa();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode($estados) . "; const _siniestroT= " . json_encode($tipoS) . ";"."const _seguimientoE= " . json_encode($SeguimientoE) . ";"
                ."const _Etapa = " . json_encode($s_etapas) . ";"."const _EstatusTram = " . json_encode($sguimientoByEtapa) . ";"
            ),
        ));
        $this->render('siniestroCorporativo/tablero', $head, $data, $footer);
    }

    public function add()
    {
        $head = [];
        $data = [];
        $footer = [];

        $data["siniestro_form"]["tipo_siniestro_id"] = 0;
        $data['estados'] = $this->siniestro->getEstados();
        $data['estatus'] = $this->siniestro->getAllestatusT();
        //$data["tipos"] = $this->siniestro->getAllData('siniestro_tipo');
        $data["tipos"] = $this->siniestro->getAllTipoSiniestros();
        $data["estatust"] = $this->siniestro->getStatusTramites();
        $data['SeguimientoE'] = $this->siniestro->getAllData('siniestro_estatus_seguimiento');

        //Nuevos cambios
        $data['s_etapas'] = $this->siniestro->getAllData('siniestro_etapa');
        $causa_s = $this->siniestro->getAllData('siniestro_causa');
        $sguimientoByEtapa=$this->siniestro->getStatusTramitesByEtapa();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _Causa = " . json_encode($causa_s) . ";"."const _Seguimiento = " . json_encode($data['SeguimientoE']) 
                . ";"."const _Etapa = " . json_encode($data['s_etapas']) . ";"."const _EstatusTram = " . json_encode($sguimientoByEtapa) . ";"
            ),
        ));
        $this->render('siniestroCorporativo/index', $head, $data, $footer);
    }



    public function getTemplateView()
    {
        $data = $_POST;
        $data["tipos"] = $this->siniestro->getAllTipoSiniestros();;
        $data['estados'] = $this->siniestro->getEstados();
        $data['estatus'] = $this->siniestro->getAllestatusT();
        $siniestro = $this->input->post('id');
        $idSiniestro = $siniestro != "" && $siniestro != null ? $siniestro : 0;
        $data['refacciones'] = $this->siniestro->getRefacciones($idSiniestro);
        $data["estatust"] = $this->siniestro->getStatusTramites();
        $data['SeguimientoE'] = $this->siniestro->getAllData('siniestro_estatus_seguimiento');
        $data['s_etapas'] = $this->siniestro->getAllData('siniestro_etapa');
        $this->load->view('siniestroCorporativo/loadTemplate', $data);
    }

    public function saveSiniestro()
    {
        //Guadado de la informacion
        $data = $_POST;
        $id = isset($data['siniestro_form']['id']) ? $data['siniestro_form']['id'] : 0;

        if($id==0){ //Si es registro nuevo
            if($_POST["siniestro_form"]["num_reporte"]=="" || $_POST["siniestro_form"]["num_siniestro"]==""){
                $this->responseJSON('400', "Ingrese un identificador del siniestro", []);
            }
            if(!$this->siniestro->ExistSiniestro($_POST["siniestro_form"]["num_reporte"],$_POST["siniestro_form"]["num_siniestro"])){ //valida que no existe en la db
                $this->responseJSON('400', "Ya existe un registro con el número de siniestro", []);
            }
        }else{
            if($_POST["siniestro_form"]["num_reporte"]=="" || $_POST["siniestro_form"]["num_siniestro"]==""){
                $this->responseJSON('400', "Ingrese un identificador del siniestro (Num reporte o Num siniestro)", []);
            }
        }

        if($data["siniestro_poliza"]["Id"]==0){ //Si poliza es registro nuevo
            if(!$this->siniestro->ExistPoliza($data["siniestro_poliza"]["Poliza"])){ //valida que no existe en la db
                $this->responseJSON('400', "Ya existe una poliza con la misma informacion", []);
            }
        }
       
        $inserted_id = $this->siniestro->SaveOrUpdate($data);

        //Guardado de los archivos
        if (!empty($_FILES)) {
            $keys = array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('AUTOSC_', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('AUTOSC_' . $inserted_id, $padre);
            $count = 0;
            foreach ($_FILES as $file) {
                $test = $file;
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                $tipo = explode("_", $keys[$count]);
                $this->saveDoc($uploadFile->data, '', $tipo[count($tipo) - 1], $inserted_id, []);
                $count++;
            }
        }
        //respuesta
        $this->responseJSON("200", "Se guardo con Éxito", []);
    }

    public function editSiniestro($id)
    {
        $head = [];
        $data = [];
        $footer = [];

        $data = $this->siniestro->getSiniestro($id);
        $data['estados'] = $this->siniestro->getEstados();
        //$data["tipos"] = $this->siniestro->getAllData('siniestro_tipo');
        $data["tipos"] = $this->siniestro->getAllTipoSiniestros();
        $data['estados'] = $this->siniestro->getEstados();
        $data['estatus'] = $this->siniestro->getAllestatusT();
        $data['refacciones'] = $this->siniestro->getRefacciones($id);
        $data["estatust"] = $this->siniestro->getStatusTramites();
        $data['SeguimientoE'] = $this->siniestro->getAllData('siniestro_estatus_seguimiento');
        $causa_s = $this->siniestro->getAllData('siniestro_causa');
        $data['s_etapas'] = $this->siniestro->getAllData('siniestro_etapa');
        $sguimientoByEtapa=$this->siniestro->getStatusTramitesByEtapa();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _Causa = " . json_encode($causa_s) . ";"."const _Seguimiento = " . json_encode($data['SeguimientoE']) 
                . ";"."const _Etapa = " . json_encode($data['s_etapas']) . ";"."const _EstatusTram = " . json_encode($sguimientoByEtapa) . ";"
            ),
        ));
        $this->render('siniestroCorporativo/index', $head, $data, $footer);
    }

    //Retorna la tabla
    public function SiniestroTabla()
    {
        $dataGet = $this->input->get();
        $data = $this->siniestro->getTablaSiniestrosNew($dataGet, []);
        echo json_encode($data);
    }

    public function GetDocuments()
    {
        $id = $this->input->post('id');
        $tramite = $this->input->post('tramite');
        $data['documentos'] = $this->siniestro->getDocumentsSiniestros($id, $tramite);
        $this->load->view('siniestroCorporativo/tablaDocumentos', $data);
    }

    function getSeguimiento()
    {
        $data = [];
        $id = $this->input->post('id');
        $tramite = $this->input->post('tramite');
        $data["comentario"] = $this->siniestro->getSeguimientoAC($id, $tramite);
        $this->load->view('siniestroCorporativo/comentarios', $data);
        //$this->responseJSON("200", "Se guardo con Éxito", $data);
    }

    function NuevoComentario()
    {
        $data = [];
        $id_siniestro = $this->input->post('id');
        $tramite = $this->input->post('tramite');
        $dataSegumiento = array(
            "referencia" => "AUTOS_C",
            "referencia_id" => $id_siniestro,
            "fecha" => date("Y-m-d H:i:s"),
            "usuario_id" => $this->tank_auth->get_idPersona(),
            "fecha_alta" => date("Y-m-d H:i:s"),
            "comentario" => $this->input->post('comentario'),
            "nombre_tramite" => $tramite
        );
        $this->siniestro->addSeguimiento($dataSegumiento);

        //Obtnermos los comentarios
        $data["comentario"] = $this->siniestro->getSeguimientoAC($id_siniestro, $tramite);
        $this->load->view('siniestroCorporativo/comentarios', $data);
    }

    function AccionesRefacciones()
    {
        $tipo = $this->input->post('tipo');
        $id_siniestro = $this->input->post('id');

        if ($tipo == 1) {
            $pieza = $this->input->post('pieza');
            $num_refaccion = $this->input->post('num_refaccion');
            $fecha = $this->input->post('fecha');
            $save = array(
                "siniestro_id" => $id_siniestro,
                "pieza" => $pieza,
                "num_refaccion" => $num_refaccion,
                "fecha_add" => $fecha,
                "usuario" => $this->tank_auth->get_idPersona()
            );
            $this->siniestro->saveRefaccion($save);
        }

        $data["refacciones"] = $this->siniestro->getRefacciones($id_siniestro);
        $this->load->view('siniestroCorporativo/tablaRefacciones', $data);
    }


    function delete_documento()
    {
        $id_doc = $this->input->post('id_doc');
        $response = $this->googledrive->deleteFile($id_doc);
        $this->siniestro->delete_doc_drive($id_doc);
        $this->responseJSON("200", "Se realizó con Éxito", []);
    }

    ///Subir los archivos al drive
    private function createReferenciaFolder($referencia, $referencia_id)
    {
        $finalReference = null;
        $folReferencia = null;
        $folReferenciaId = null;
        $exist_ref = $this->googledrive->searchfile(array("name" => $referencia));

        if (count($exist_ref->data) == 0) {
            $folReferencia = $this->googledrive->createFolder($referencia);

            if ($folReferencia->exito) {
                //$this->saveDoc($folReferencia->data, false, $referencia);
                $folReferencia = $folReferencia->data;
            } else {
                $this->responseJSON("400", $folReferencia->mensaje, null);
                die;
            }
        } else {
            $folReferencia = $exist_ref->data[0];
        }

        if (!empty($referencia_id)) {
            $exist_ref_id = $this->googledrive->searchfile(array("name" => $referencia_id, "parents" => $folReferencia->getId()));
            if (count($exist_ref_id->data) == 0) {
                $folReferenciaId = $this->googledrive->createFolder($referencia_id, $folReferencia->getId());
                if ($folReferenciaId->exito) {
                    //$this->saveDoc($folReferenciaId->data, false, $referencia, $referencia_id);
                    $folReferenciaId = $folReferenciaId->data;
                }
            } else {
                $folReferenciaId = $exist_ref_id->data[0];
            }
        }

        if ($folReferenciaId != null) {
            $finalReference = $folReferenciaId;
        } else {
            $finalReference = $folReferencia;
        }

        return $finalReference;
    }

    private function saveDoc($file, $privado, $referencia, $referencia_id = 0, $puestos = [])
    {
        $data = array(
            'nombre' => basename($file->getName()), //
            'descripcion' => $file->getDescription(), //
            'ruta' => $file->getWebViewLink(), //
            'ruta_completa' => $file->getWebContentLink(), //
            'tipo' => $file->getMimeType(), //
            'nombre_completo' => $file->getName(), //
            'revision' => '0', //
            'referencia' => $referencia, //
            'referencia_id' => $referencia_id, //
            'usuario_alta_id' => $this->tank_auth->get_idPersona(), //
            'parent_id' => count($file->getParents()) > 0 ? $file->getParents()[0] : "",

            'file_id' => $file->getId(), //
            'tamanio' => $file->getSize(),
            'url_icono' => $file->getIconLink(),
            'url_descargar' => $file->getWebContentLink(),
            'thumbnail_link' => $file->getThumbnailLink(),
            'fecha_alta' => date("Y-m-d H:i:s"), //
            //'privado' => $privado == "true" ? 1 : 0,
            'estado' => 'ACTIVO' //
        );
        $result =  $this->documento->saveDocument($data);
    }

    public function TableroReportes()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["tipo_r"] = "";
        $estados = $this->siniestro->getAllestatusT();
        $tipoS = $this->siniestro->tiposiniestro();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode($estados) . "; const _siniestroT= " . json_encode($tipoS) . ";"
            ),
        ));
        $this->render('siniestroCorporativo/tableroReportes', $head, $data, $footer);
    }

    public function vistaFiltros()
    {
    }

    public function doc()
    {
        $this->load->library('mydompdf');
        $this->mydompdf->load_view('siniestroCorporativo/tablareporte', null);
        //$this->mydompdf->load_view('siniestroCorporativo/reporte_tabla', null);
        /*  $this->mydompdf->render();
        return $this->mydompdf->output(); */
    }

    public function getFitro()
    {
        $data = $this->input->post();
        $this->load->view('siniestroCorporativo/filtros_tablero', $data);
    }

    public function PostFiltros()
    {
        $data = [];
        $dta = $this->input->post();
        $AccionTipo = $this->input->post('tipo');
        if ($AccionTipo == 1) {
            //Filtro normal HTML
            $data['tipo'] = $AccionTipo;
            $data['titulo'] = $dta['tipo_r'];
            $data['tabla'] = $this->siniestro->getDtaFiltrosTablero($dta);
            $data['rango'] = $this->getRangoFechas($data['tabla'], $dta);
            //$this->load->view('siniestroCorporativo/reporte_tabla', $data);
            if ($dta['tipo_r'] == "ESTATUS_T") {
                $num_unidades=$this->input->post('num_unidades');
                $data["full"] = $this->siniestro->getValuesallReporte($num_unidades);
                $dta["tipo_r"] = "REPARACION";
                $data["tabla1"] = $this->siniestro->getDtaFiltrosTablero($dta);
                $dta["tipo_r"] = "CRISTALES";
                $data["tabla2"] = $this->siniestro->getDtaFiltrosTablero($dta);
                $this->load->view('siniestroCorporativo/tablareporte', $data);
            } else {
                $this->load->view('siniestroCorporativo/reporte_tabla', $data);
            }
        } else if ($AccionTipo == 2) {
            //Creacion de PDF
            $data['tipo'] = $AccionTipo;
            $data['titulo'] = $dta['tipo_r'];
            $data['tabla'] = $this->siniestro->getDtaFiltrosTablero($dta);
            $data['rango'] = $this->getRangoFechas($data['tabla'], $dta);
            $this->load->library('mydompdf');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="prueba.pdf');
            header('Cache-Control: max-age=0'); //no cache 
            if ($dta['tipo_r'] == "ESTATUS_T") {
                $data["nombre"]="ESTATUS_T". date('Y-m-d');
                $num_unidades=$this->input->post('num_unidades');
                $data["full"] = $this->siniestro->getValuesallReporte($num_unidades);
                $dta["tipo_r"] = "REPARACION";
                $data["tabla1"] = $this->siniestro->getDtaFiltrosTablero($dta);
                $dta["tipo_r"] = "CRISTALES";
                $data["tabla2"] = $this->siniestro->getDtaFiltrosTablero($dta);
                $this->mydompdf->load_view('siniestroCorporativo/tablareporte', $data);
                //$this->mydompdf->load_view('siniestroCorporativo/tablareporte', $data);
            } else {
                $data["nombre"]=$dta['tipo_r']. date('Y-m-d');
                $this->mydompdf->load_view('siniestroCorporativo/reporte_tabla', $data);
            }
        } else {
            if ($dta['tipo_r'] == "ESTATUS_T") {
                //Hoja de resumen
                $filename= "ESTATUS_T". date('Y-m-d') . '.xls';
                $data['tipo'] = $AccionTipo;
                $data['titulo'] = $dta['tipo_r'];
                //$tabla = $this->siniestro->getDtaFiltrosTablero($dta);
                //$rango = $this->getRangoFechas($tabla, $dta);
                //Creacion de Excel
                $contador = 3;
                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle('Resumen');
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('Logo');
                $objDrawing->setDescription('Logo empresa');
                $pathImage = $_SERVER["DOCUMENT_ROOT"] . "/mavilaV3/assets/img/logo/logoReporte.png";
                $objDrawing->setPath($pathImage);
                $objDrawing->setCoordinates("A1");
                $objDrawing->setWidth(60);
                $objDrawing->setHeight(40);
                $objDrawing->setWorksheet($this->excel->getActiveSheet());
                $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(50);
                //Titulo del reporte
                $this->excel->getActiveSheet()->setCellValue('E1', $dta['tipo_r']);
                $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(15)->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('E1:H1');
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                );
                $styleT=array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '82afd9')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'ffffff'),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                );
                $this->excel->getActiveSheet()->getStyle("E1:H1")->applyFromArray($style);
                //Rangos de fechas
                //desde hasta
                //$this->excel->getActiveSheet()->setCellValue('E2', "Desde: " . $rango['desde'] . " - Hasta: " . $rango['hasta']);
                //Fecha del reporte
                $date = date('d/m/Y H:i:s');
                $resumen = $this->siniestro->getValuesallReporte(1000);
                $this->excel->getActiveSheet()->setCellValue('I1', "Fecha y hora: " . $date);
                $this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(10)->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('I1:L1');
                $this->excel->getActiveSheet()->getStyle("I1:L1")->applyFromArray($style);
                //$this->excel->getRowDimension('1')->setRowHeight(-1);
                
                $this->excel->getActiveSheet()->setCellValue('I1', "Fecha y hora: " . $date);

                $this->excel->getActiveSheet()->setCellValue('A2', "Unidades vigentes");
                $this->excel->getActiveSheet()->mergeCells('A2:B2');
                $this->excel->getActiveSheet()->getStyle("A2:B2")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('A3', $resumen["TotalFlota"]);
                $this->excel->getActiveSheet()->mergeCells('A3:B3');
                $this->excel->getActiveSheet()->getStyle("A3:B3")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('A4', "Reparacion");
                $this->excel->getActiveSheet()->mergeCells('A4:B4');
                $this->excel->getActiveSheet()->getStyle("A4:B4")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('A5', "Cristales");
                $this->excel->getActiveSheet()->mergeCells('A5:B5');
                $this->excel->getActiveSheet()->getStyle("A5:B5")->applyFromArray($styleT);
                

                $this->excel->getActiveSheet()->setCellValue('C2', "Siniestros (Acumulado anual)");
                $this->excel->getActiveSheet()->mergeCells('C2:D2');
                $this->excel->getActiveSheet()->getStyle("C2:D2")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('C3', $resumen["TotalRET"]+$resumen["TotalCRT"]);
                $this->excel->getActiveSheet()->mergeCells('C3:D3');
                $this->excel->getActiveSheet()->getStyle("C3:D3")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('C4', $resumen["TotalRE"]);
                $this->excel->getActiveSheet()->mergeCells('C4:D4');
                $this->excel->getActiveSheet()->getStyle("C4:D4")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('C5', $resumen["TotalC"]);
                $this->excel->getActiveSheet()->mergeCells('C5:D5');
                $this->excel->getActiveSheet()->getStyle("C5:D5")->applyFromArray($style);


                $this->excel->getActiveSheet()->setCellValue('E2', "Estatus T");
                $this->excel->getActiveSheet()->mergeCells('E2:F2');
                $this->excel->getActiveSheet()->getStyle("E2:F2")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('E3', $resumen["TotalRET"]+$resumen["TotalCRT"]);
                $this->excel->getActiveSheet()->mergeCells('E3:F3');
                $this->excel->getActiveSheet()->getStyle("E3:F3")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('E4', $resumen["TotalRET"]);
                $this->excel->getActiveSheet()->mergeCells('E4:F4');
                $this->excel->getActiveSheet()->getStyle("E4:F4")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('E5', $resumen["TotalCRT"]);
                $this->excel->getActiveSheet()->mergeCells('E5:F5');
                $this->excel->getActiveSheet()->getStyle("E5:F5")->applyFromArray($style);


                $this->excel->getActiveSheet()->setCellValue('G2', "% De Estatus t vs Flota Total");
                $this->excel->getActiveSheet()->mergeCells('G2:H2');
                $this->excel->getActiveSheet()->getStyle("G2:H2")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('G3', round(($resumen["TotalRET"]/$resumen["TotalFlota"])*100,2)+round(($resumen["TotalCRT"]/$resumen["TotalFlota"])*100,2).'%');
                $this->excel->getActiveSheet()->mergeCells('G3:H3');
                $this->excel->getActiveSheet()->getStyle("G3:H3")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('G4', round(($resumen["TotalRET"]/$resumen["TotalFlota"])*100,2).'%');
                $this->excel->getActiveSheet()->mergeCells('G4:H4');
                $this->excel->getActiveSheet()->getStyle("G4:H4")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('G5', round(($resumen["TotalCRT"]/$resumen["TotalFlota"])*100,2).'%');
                $this->excel->getActiveSheet()->mergeCells('G5:H5');
                $this->excel->getActiveSheet()->getStyle("G5:H5")->applyFromArray($style);



                $this->excel->getActiveSheet()->setCellValue('I2', "% De Estatus t vs Siniestros acumulado");
                $this->excel->getActiveSheet()->mergeCells('I2:J2');
                $this->excel->getActiveSheet()->getStyle("I2:J2")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('I3', round(($resumen["TotalRET"]/$resumen["TotalS"])*100,2)+round(($resumen["TotalCRT"]/$resumen["TotalS"])*100,2).'%');
                $this->excel->getActiveSheet()->mergeCells('I3:J3');
                $this->excel->getActiveSheet()->getStyle("I3:J3")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('I4', round(($resumen["TotalRET"]/$resumen["TotalS"])*100,2).'%');
                $this->excel->getActiveSheet()->mergeCells('I4:J4');
                $this->excel->getActiveSheet()->getStyle("I4:J4")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('I5', round(($resumen["TotalCRT"]/$resumen["TotalS"])*100,2).'%');
                $this->excel->getActiveSheet()->mergeCells('I5:J5');
                $this->excel->getActiveSheet()->getStyle("I5:J5")->applyFromArray($style);



                $this->excel->getActiveSheet()->setCellValue('K2', "Frecuencia");
                $this->excel->getActiveSheet()->mergeCells('K2:L2');
                $this->excel->getActiveSheet()->getStyle("K2:L2")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('K3', round(($resumen["TotalRE"]/$resumen["TotalFlota"])*100,2)+round(($resumen["TotalC"]/$resumen["TotalFlota"])*100,2).'%');
                $this->excel->getActiveSheet()->mergeCells('K3:L3');
                $this->excel->getActiveSheet()->getStyle("K3:L3")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('K4', round(($resumen["TotalRE"]/$resumen["TotalFlota"])*100,2).'%');
                $this->excel->getActiveSheet()->mergeCells('K4:L4');
                $this->excel->getActiveSheet()->getStyle("K4:L4")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('K5', round(($resumen["TotalC"]/$resumen["TotalFlota"])*100,2).'%');
                $this->excel->getActiveSheet()->mergeCells('K5:L5');
                $this->excel->getActiveSheet()->getStyle("K5:L5")->applyFromArray($style);

                $this->excel->getActiveSheet()->setCellValue('A7', "REPARACIONES");
                $this->excel->getActiveSheet()->getStyle("A7")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('A8', "Surtido de refacciones con fecha");
                $this->excel->getActiveSheet()->mergeCells('A8:B8');
                $this->excel->getActiveSheet()->getStyle("A8:B8")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('A9', $resumen["SurtidoRefConFechaRE"]);
                $this->excel->getActiveSheet()->mergeCells('A9:B9');
                $this->excel->getActiveSheet()->getStyle("A9:B9")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('C8', "Surtido de refacciones sin fecha");
                $this->excel->getActiveSheet()->mergeCells('C8:D8');
                $this->excel->getActiveSheet()->getStyle("C8:D8")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('C9', $resumen["SurtidoRefSinFechaRE"]);
                $this->excel->getActiveSheet()->mergeCells('C9:D9');
                $this->excel->getActiveSheet()->getStyle("C9:D9")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('E8', "Piezas completas con fecha de entrega");
                $this->excel->getActiveSheet()->mergeCells('E8:F8');
                $this->excel->getActiveSheet()->getStyle("E8:F8")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('E9', $resumen["PiezasCompletasConFechaRE"]);
                $this->excel->getActiveSheet()->mergeCells('E9:F9');
                $this->excel->getActiveSheet()->getStyle("E9:F9")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('G8', "Piezas completas sin fecha de entrega");
                $this->excel->getActiveSheet()->mergeCells('G8:H8');
                $this->excel->getActiveSheet()->getStyle("G8:H8")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('G9', $resumen["PiezasCompletasSinFechaRE"]);
                $this->excel->getActiveSheet()->mergeCells('G9:H9');
                $this->excel->getActiveSheet()->getStyle("G9:H9")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('I8', "En proceso de valuacion");
                $this->excel->getActiveSheet()->mergeCells('I8:J8');
                $this->excel->getActiveSheet()->getStyle("I8:J8")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('I9', $resumen["ProcesoValuacionRE"]);
                $this->excel->getActiveSheet()->mergeCells('I9:J9');
                $this->excel->getActiveSheet()->getStyle("I9:J9")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('K8', "Pendientes de Ingresar");
                $this->excel->getActiveSheet()->mergeCells('K8:L8');
                $this->excel->getActiveSheet()->getStyle("K8:L8")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('K9', $resumen["PendienteIngresoRE"]);
                $this->excel->getActiveSheet()->mergeCells('K9:L9');
                $this->excel->getActiveSheet()->getStyle("K9:L9")->applyFromArray($style);

                $this->excel->getActiveSheet()->setCellValue('A10', "CRISTALES");
                $this->excel->getActiveSheet()->getStyle("A10")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('A11', "Surtido de refacciones con fecha");
                $this->excel->getActiveSheet()->mergeCells('A11:B11');
                $this->excel->getActiveSheet()->getStyle("A11:B11")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('A12', $resumen["SurtidoRefConFechaCR"]);
                $this->excel->getActiveSheet()->mergeCells('A12:B12');
                $this->excel->getActiveSheet()->getStyle("A12:B12")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('C11', "Surtido de refacciones sin fecha");
                $this->excel->getActiveSheet()->mergeCells('C11:D11');
                $this->excel->getActiveSheet()->getStyle("C11:D11")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('C12', $resumen["SurtidoRefSinFechaCR"]);
                $this->excel->getActiveSheet()->mergeCells('C12:D12');
                $this->excel->getActiveSheet()->getStyle("C12:D12")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('E11', "Piezas completas con fecha de entrega");
                $this->excel->getActiveSheet()->mergeCells('E11:F11');
                $this->excel->getActiveSheet()->getStyle("E11:F11")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('E12', $resumen["PiezasCompletasConFechaCR"]);
                $this->excel->getActiveSheet()->mergeCells('E12:F12');
                $this->excel->getActiveSheet()->getStyle("E12:F12")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('G11', "Piezas completas sin fecha de entrega");
                $this->excel->getActiveSheet()->mergeCells('G11:H11');
                $this->excel->getActiveSheet()->getStyle("G11:H11")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('G12', $resumen["PiezasCompletasSinFechaCR"]);
                $this->excel->getActiveSheet()->mergeCells('G12:H12');
                $this->excel->getActiveSheet()->getStyle("G12:H12")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('I11', "En proceso de valuacion");
                $this->excel->getActiveSheet()->mergeCells('I11:J11');
                $this->excel->getActiveSheet()->getStyle("I11:J11")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('I12', $resumen["ProcesoValuacionCR"]);
                $this->excel->getActiveSheet()->mergeCells('I12:J12');
                $this->excel->getActiveSheet()->getStyle("I12:J12")->applyFromArray($style);
                $this->excel->getActiveSheet()->setCellValue('K11', "Pendientes de Ingresar");
                $this->excel->getActiveSheet()->mergeCells('K11:L11');
                $this->excel->getActiveSheet()->getStyle("K11:L11")->applyFromArray($styleT);
                $this->excel->getActiveSheet()->setCellValue('K12', $resumen["PendienteIngresoCR"]);
                $this->excel->getActiveSheet()->mergeCells('K12:L12');
                $this->excel->getActiveSheet()->getStyle("K12:L12")->applyFromArray($style);










                //Hoja de reparacion
                $contador = 1;
                $this->excel->createSheet();
                $this->excel->setActiveSheetIndex(1)->setTitle('Reparacion');
                $dta["tipo_r"]="REPARACION";
                $tabla = $this->siniestro->getDtaFiltrosTablero($dta);
                if (count($tabla) > 0) {
                    $headers = $tabla[0];
                    $HC = 0;
                    foreach ($headers as $key => $H) {
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, mb_strtoupper(str_replace("_", " ", $key)));
                        $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                        $celda = $column . $contador;
                        $this->excel->getActiveSheet()->getStyle($celda)->getFont()->setSize(10)->setBold(true);
                        $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '000000')
                                ),
                                'font'  => array(
                                    'bold'  => true,
                                    'color' => array('rgb' => 'ffffff'),
                                )
                            )
                        );
                        $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                        //$this->excle->getActiveSheet()->
                        $HC++;
                    }

                    $HC = 0;
                    $contador = 2;
                    foreach ($tabla as $key => $ls) {
                        $keysH = array_keys($ls);
                        foreach ($keysH as $keys => $value) {
                            $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                            $celda = $column . $contador;
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, $ls[$value] == '' ? 'NA' : $ls[$value]);
                            $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'ffffff')
                                    ),
                                    'font'  => array(
                                        'bold'  => true,
                                        'color' => array('rgb' => '000000'),
                                    )
                                )
                            );
                            $HC++;
                        }
                        $HC = 0;
                        $contador++;
                    }
                }

                //Hoja de Cristales
                $contador = 1;
                $this->excel->createSheet();
                $this->excel->setActiveSheetIndex(2)->setTitle('Cristales');
                $dta["tipo_r"]="CRISTALES";
                $tabla = $this->siniestro->getDtaFiltrosTablero($dta);
                if (count($tabla) > 0) {
                    $headers = $tabla[0];
                    $HC = 0;
                    foreach ($headers as $key => $H) {
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, mb_strtoupper(str_replace("_", " ", $key)));
                        $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                        $celda = $column . $contador;
                        $this->excel->getActiveSheet()->getStyle($celda)->getFont()->setSize(10)->setBold(true);
                        $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '000000')
                                ),
                                'font'  => array(
                                    'bold'  => true,
                                    'color' => array('rgb' => 'ffffff'),
                                )
                            )
                        );
                        $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                        //$this->excle->getActiveSheet()->
                        $HC++;
                    }

                    $HC = 0;
                    $contador = 2;
                    foreach ($tabla as $key => $ls) {
                        $keysH = array_keys($ls);
                        foreach ($keysH as $keys => $value) {
                            $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                            $celda = $column . $contador;
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, $ls[$value] == '' ? 'NA' : $ls[$value]);
                            $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'ffffff')
                                    ),
                                    'font'  => array(
                                        'bold'  => true,
                                        'color' => array('rgb' => '000000'),
                                    )
                                )
                            );
                            $HC++;
                        }
                        $HC = 0;
                        $contador++;
                    }
                }

                
            } else {
                $filename= $dta['tipo_r']. date('Y-m-d') . '.xls';
                $data['tipo'] = $AccionTipo;
                $data['titulo'] = $dta['tipo_r'];
                $tabla = $this->siniestro->getDtaFiltrosTablero($dta);
                $rango = $this->getRangoFechas($tabla, $dta);
                //Creacion de Excel
                $contador = 3;
                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle('Siniestros');

                //añadir la imagen al documento excel
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('Logo');
                $objDrawing->setDescription('Logo empresa');
                $pathImage = $_SERVER["DOCUMENT_ROOT"] . "/mavilaV3/assets/img/logo/logoReporte.png";
                $objDrawing->setPath($pathImage);
                $objDrawing->setCoordinates("A1");
                $objDrawing->setWidth(60);
                $objDrawing->setHeight(40);
                $objDrawing->setWorksheet($this->excel->getActiveSheet());
                $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(50);
                //Titulo del reporte
                $this->excel->getActiveSheet()->setCellValue('E1', $dta['tipo_r']);
                $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(15)->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('E1:H1');
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                );
                
                $this->excel->getActiveSheet()->getStyle("E1:H1")->applyFromArray($style);
                //Rangos de fechas
                //desde hasta
                $this->excel->getActiveSheet()->setCellValue('E2', "Desde: " . $rango['desde'] . " - Hasta: " . $rango['hasta']);
                $this->excel->getActiveSheet()->getStyle('E2')->getFont()->setSize(10)->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('E2:H2');
                $this->excel->getActiveSheet()->getStyle("E2:H2")->applyFromArray($style);
                //Fecha del reporte
                $date = date('d/m/Y H:i:s');
                $this->excel->getActiveSheet()->setCellValue('I1', "Fecha y hora: " . $date);
                $this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(10)->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('I1:L1');
                $this->excel->getActiveSheet()->getStyle("I1:L1")->applyFromArray($style);
                //$this->excel->getRowDimension('1')->setRowHeight(-1);

                if (count($tabla) > 0) {
                    $headers = $tabla[0];
                    $HC = 0;
                    foreach ($headers as $key => $H) {
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, mb_strtoupper(str_replace("_", " ", $key)));
                        $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                        $celda = $column . $contador;
                        $this->excel->getActiveSheet()->getStyle($celda)->getFont()->setSize(10)->setBold(true);
                        $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '000000')
                                ),
                                'font'  => array(
                                    'bold'  => true,
                                    'color' => array('rgb' => 'ffffff'),
                                )
                            )
                        );
                        $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                        //$this->excle->getActiveSheet()->
                        $HC++;
                    }

                    $HC = 0;
                    $contador = 4;
                    foreach ($tabla as $key => $ls) {
                        $keysH = array_keys($ls);
                        foreach ($keysH as $keys => $value) {
                            $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                            $celda = $column . $contador;
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, $ls[$value] == '' ? 'NA' : $ls[$value]);
                            $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'ffffff')
                                    ),
                                    'font'  => array(
                                        'bold'  => true,
                                        'color' => array('rgb' => '000000'),
                                    )
                                )
                            );
                            $HC++;
                        }
                        $HC = 0;
                        $contador++;
                    }
                }
            }
            //$this->excel->getActiveSheet()->mergeCells('A1:D1');           
            //$filename = 'Siniestro_Registros' . date('Y-m-d') . '.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0'); //no cache 
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

            // Forzamos a la descarga         
            $objWriter->save('php://output');
        }
    }

    function getRangoFechas($data, $filtros)
    {

        $return = [];
        usort($data, function ($first, $second) {
            return $first['fecha_siniestro'] > $second['fecha_siniestro'];
        });
        if (count($data) > 0) {
            $return["desde"] = $filtros["f_inicio"] == "" ? $data[0]["fecha_siniestro"] : $filtros["f_inicio"];
            $return["hasta"] = $filtros["f_fin"] == "" ? $data[count($data) - 1]["fecha_siniestro"] : $filtros["f_fin"];
        } else {
            $return["desde"] = date('d/m/Y');
            $return["hasta"] = date('d/m/Y');
        }
        return $return;
    }

    //metodos para el modal de polizas
    function getPolizas(){
        $dataGet = $this->input->get();
        $data = $this->siniestro->getTablePolizas($dataGet);
        echo json_encode($data);
    }

    function testtemplate()
    {
        $this->render('siniestroCorporativo/tablareporte', [], [], []);
    }

    ///Procesos de la vista de poliza
    function Polizas(){
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            )
        ));
        $this->footerScripts(array(
           /*  array(
                'type' => 'JSHTML',
                'data' => "const _Causa = " . json_encode($causa_s) . ";"
            ), */
        ));
        $this->render('siniestroCorporativo/polizas', $head, $data, $footer);
    }

    function AddPoliza($id=0){
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        if($id){
            $data["poliza"]=$this->siniestro->GetExistPoliza($id);
        }

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            )
        ));
        $this->footerScripts(array(
           /*  array(
                'type' => 'JSHTML',
                'data' => "const _Causa = " . json_encode($causa_s) . ";"
            ), */
        ));
        $this->render('siniestroCorporativo/addPoliza', $head, $data, $footer);
    }

    function AccionesPoliza(){
        $data = $this->input->post();
        $res=200;
        $message="Exito";
        switch ($data['siniestro_poliza']['accion']) {
            case '1':
                //Guardar
                $this->siniestro->udpateOrSavePoliza($data['siniestro_poliza']);
                break;
            case '2':
               //Eliminar
                if(!$this->siniestro->getAllSiniestroByPoliza($data['siniestro_poliza']['Id'])){
                    $res=400;
                    $message="No se puede eliminar, ya que tiene vinculado un siniestro.";
                }else{
                    $this->siniestro->deletePoliza($data['siniestro_poliza']['Id']);
                }
                break;
        }
        $this->responseJSON($res, $message, []);
    }
}
