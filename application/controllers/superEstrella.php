<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class superEstrella extends CI_Controller{
  
    function __construct(){
        parent::__construct();
        $this->load->library("libreriav3");
        $this->load->model('superestrella_model');
        $this->load->model('capitalhumano_model');
        $this->load->model('email_model');
        $this->load->model('personamodelo');
        $this->load->model("calendar_model");
        $this->load->model('capacita_modelo');
        $this->load->model('crmproyecto_model'); //Agregado [2024-02-13]
        if (!$this->tank_auth->is_logged_in()){redirect('/auth/login/');}
    }
    //---------------------------------------------------------------
    function index(){
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else {
            //Nombres y Correos Empleados
            $data['puestos'] = $this->capitalhumano_model->devolverPuestos(1);
            $array['grupos'] = 1;
            $data['empleados'] = $this->personamodelo->devolverColaboradoresActivos($array);
            //Encontrar trimestre
            $quarter = "";
            $array = array("Primero","Segundo","Tercero","Cuarto");
            foreach ($array as $key => $val) {
                $value = $key + 1;
                $selected = $this->getOptionQuarterly($val);
                $quarter .= "<option value=".$val." ".$selected.">".$val."</option>";
            }
            $data['quarterly'] = $quarter;
            //Encontrar meses
            $months = '';
            $m = $this->libreriav3->devolverMeses();
            foreach ($m as $key => $val) {
                $selected = "";
                if ($key == date('m')) { $selected = "selected"; }
                $months .= "<option value=".$key." ".$selected.">".$val."</option>";
            }
            $data['months'] = $months;
            //Encontrar años
            $years = '';
            $count = date('Y') - 2024;
            $yearI = date('Y');
            for ($i=0;$i<=$count;$i++) {
                $selected = "";
                if ($yearI == date('Y')) { $selected = "selected"; }
                $years .= '<option value="'.$yearI.'" '.$selected.'>'.$yearI.'</option>';
                $yearI--;
            }
            $data['years'] = $years;
            //Decodificar carácteres extraños: utf8_decode("SoluciÃ³n Ãºtil y apaÃ±ada a UTF-8");
            //Obtener Capacitaciones
            $data['events'] = $this->superestrella_model->getEventsSelect();
            $this->load->view('headers/header');
            $this->load->view('headers/menu');
            $this->load->view('superEstrella/principal',$data);
            $this->load->view('footers/footer');
        }
    }

    function getOptionQuarterly($val) {
        $selected = "";
        if (date('m') >= 1 && date('m') <= 3 && $val == "Primero") {
            $selected = "selected";
        }
        else if (date('m') >= 4 && date('m') <= 6 && $val == "Segundo") {
            $selected = "selected";
        }
        else if (date('m') >= 7 && date('m') <= 9 && $val == "Tercero") {
            $selected = "selected";
        }
        else if (date('m') >= 10 && date('m') <= 12 && $val == "Cuarto") {
            $selected = "selected";
        }
        return $selected;
    }

    function getAreas() {
        $data['puestos'] = $this->capitalhumano_model->devolverPuestos(1);
        $array['grupos'] = 1;
        $data['empleados'] = $this->personamodelo->devolverColaboradoresActivos($array);
        echo json_encode($data);
    }

    function getSQLSearch($section,$month,$year,$quarter) {
        //Condiciones Mes - Trimestre
        if (!empty($month)) {
            $sql = 'SELECT * FROM '.$section.' WHERE MONTH(registro) = '.$month;
        }
        else if (!empty($quarter)) {
            $sql = 'SELECT * FROM '.$section.' WHERE trimestre = "'.$quarter.'"';
        }
        else if (empty($month) && empty($quarter)) {
            $sql = 'SELECT * FROM '.$section.' WHERE ';
        }
        //Agregar año
        if (!empty($year)) {
            if (!empty($month) || !empty($quarter)) { $sql .= ' AND '; }
            $sql .= 'periodo = '.$year;
        }
        return $sql;
    }

    function getEmployeeSearch() {
        $month = $this->input->get('mt');
        $year = $this->input->get('yr');
        $quarter = $this->input->get('qr');
        $area = $this->input->get('ar');
        $employee = $this->input->get('em');
        $sql = $this->getSQLSearch("calificacion_auditoria",$month,$year,$quarter);
        //Condiciones Área - Colaborador
        if (!empty($area)) {
            $search = 1;
            $query = $area;
        }
        else if (!empty($employee)) {
            $search = 2;
            $query = $employee;
        }
        $data['auditoria'] = $this->superestrella_model->getAudit($sql);
        $data['empleados'] = $this->superestrella_model->getEmployeePosition($search,$query);
        $data['datos'] = array("mes" => $month, "año" => $year, "semestre" => $quarter, "area" => $area, "idPersona" => $employee);
        echo json_encode($data);
    }

    function getSearchTypeEmployee($value) {
        $data = 1;
        if ($value == "todos") { $data = 4; }
        return $data;
    }

    // Auditoría [2024-02-21] ------------------------------------------------------------------------------
    function getSearchEmployeeAudit() {
        $year = $this->input->get('yr');
        $quarter = $this->input->get('qr');
        $area = $this->input->get('ar');
        $sql = $this->getSQLSearch("calificacion_auditoria","",$year,$quarter);
        if ($area != "todos") {
            $data['employees'] = $this->superestrella_model->getEmployeePosition(1,$area);
        }
        else {
            $data['employees'] = $this->superestrella_model->getEmployeePosition(4,"");
        }
        $data['audit'] = $this->superestrella_model->getAudit($sql);
        
        $data['data'] = array("año" => $year, "semestre" => $quarter, "area" => $area);
        echo json_encode($data);
    }
    function saveEmployeeAudit() {
        $id = $this->input->post('id');
        $employee = $this->input->post('em');
        $quarter = $this->input->post('qr');
        $procedure = $this->input->post('pr');
        $tracking = $this->input->post('sg');
        $action = $this->input->post('up');
        if ($action == "no") {
            $insert = array(
                "idPersona" => $employee,
                "trimestre" => $quarter,
                "procedimiento" => $procedure,
                "seguimiento" => $tracking,
                "calificacion" => $this->getScoreAudit($procedure,$tracking),
                "periodo" => date('Y'),
                "registro" => date("Y-m-d H:i:s")
            );
            $data['action'] = "insert";
            $data['result'] = $this->superestrella_model->insertAudit($insert); //id
            $sql = "select * from calificacion_auditoria where id = ".$data['result'];
        }
        else {
            $update = array(
                "trimestre" => $quarter,
                "procedimiento" => $procedure,
                "seguimiento" => $tracking,
                "calificacion" => $this->getScoreAudit($procedure,$tracking),
                "actualizacion" => date("Y-m-d H:i:s")
            );
            $data['action'] = "update";
            $data['result'] = $this->superestrella_model->updateAudit($update,$id);
            $sql = "select * from calificacion_auditoria where id = ".$id;
        }
        $data['audit'] = $this->superestrella_model->getAudit($sql);
        $data['data'] = array("idAuditoria" => $id, "idPersona" => $employee, "trimestre" => $quarter, "procedimiento" => $procedure, "seguimiento" => $tracking);
        echo json_encode($data);
    }

    function getBossEmployeesAudit() {
        $boss = $this->input->get('id');
        $year = $this->input->get('yr');
        $data['empleados'] = $this->superestrella_model->getEmployeePosition(3,$boss);
        $data['auditoria'] = $this->superestrella_model->getEmployeesAudit($boss,$year);
        echo json_encode($data);
    }

    function getResultAudit() {//Modificado [2024-04-22]
        $year = $this->input->get('yr');
        $quarter = $this->input->get('qr');
        $data = $this->superestrella_model->getResultCompleteAudit($year,$quarter);
        echo json_encode($data);
    }

    function getScoreAudit($procedure,$tracking) {
        if ($procedure != "no" && $tracking != "no") {
            $data = 15;
        }
        else {
            $data = 0;
        }
        return $data;
    }
    //Puntualidad [2024-04-26] --------------------------------------------------------------------------------------
    function getSearchEmployeeAttendance() {        
        $year = $this->input->get('yr');
        $quarter = $this->input->get('qr');
        $area = $this->input->get('ar');
        $search = $this->getSearchTypeEmployee($area);
        $data['attendance'] = $this->superestrella_model->getEmployeesAttendance($quarter,$year,$area,$search);
        $data['dates'] = $this->superestrella_model->getAvaibleDatesByQuarter($quarter,$year);
        $data['data'] = array("año" => $year, "semestre" => $quarter, "area" => $area);
        echo json_encode($data);
    }

    function getSearchAttendance() { //Creado [Suemy][2024-05-10]
        $idPersona = $this->input->get('id');
        $quarter = $this->input->get('qr');
        $year = $this->input->get('yr');
        $data['attendance'] = $this->superestrella_model->getEmployeesAttendance($quarter,$year,$idPersona,2);
        $data['dates'] = $this->superestrella_model->getAvaibleDatesByQuarter($quarter,$year);
        $data['data'] = array("idPersona" => $idPersona, "año" => $year, "semestre" => $quarter);
        echo json_encode($data);
    }
    //Capacitación [2024-02-23] -------------------------------------------------------------------------------
    function getSearchEmployeeEvent() {
        $event = $this->input->get('ev');
        $data['events'] = $this->superestrella_model->getEventsTraining($event);
        //$data['registros'] = $this->superestrella_model->getEventsRegister($event);
        $data['data'] = array("id_event" => $event);
        echo json_encode($data);
    }

    function saveEmployeeEvent() {//Modificado [2024-04-22]
        $event = $this->input->post('ev');
        $guest = $this->input->post('gt');
        $register = $this->input->post('rg');
        $hour = $this->input->post('hr');
        $value = $this->input->post('ck');
        $action = $this->input->post('up');

        if ($value == 1) { $status = "activo"; }
        else { $status = "inactivo"; }

        if ($action == "no") {
            $dataEvent = $this->crmproyecto_model->getConvocatoriaReunionJson($event);
            $dataGuest = $this->calendar_model->obtenerInvitado($guest, "interno");
            $subCategory =$this->capacita_modelo->getTrainingSubCategoryByName($dataEvent->sub_categoria_capacitacion);
            $category = $this->capacita_modelo->getTrainingCategoryById($subCategory->id_capacitacion);
            $typeLastCategory = $dataEvent->ramo_capacitacion;
            if ($dataEvent->ramo_capacitacion == "Ninguno" || $dataEvent->ramo_capacitacion == "Seleccione un ramo"|| $dataEvent->ramo_capacitacion == "" || $dataEvent->ramo_capacitacion == NULL) {
                $typeLastCategory = "profesional";
            }
            $ramo = $this->capacita_modelo->devuelveRamo(($typeLastCategory != "GMM" ? strtolower($typeLastCategory) : $typeLastCategory));
            $user = $this->personamodelo->obtenerIdPersonaPorEmail($dataGuest->correo_lectronico);
            $responsible = $this->personamodelo->obtenerIdPersonaPorEmail($dataEvent->correo);

            //----------> capacita_registros_horas
            $insertHour = $this->capacita_modelo->insertaRegistro(array(
                "fecha" => $dataEvent->fecha_inicio,
                "horas" => $hour,
                "idSubCapacitacion" => $subCategory->id_certificado,
            ), "capacita_registros_horas");
            //----------> capacita_relacion_hora_ramo
            $insertHourRamo = $this->capacita_modelo->insertaRegistro(array(
                "idRegistroHora" => $insertHour['lastId'],
                "idR" => $ramo->idR
            ), "capacita_relacion_hora_ramo");
            //----------> capacita_usuario_creador
            $insertCreator = $this->capacita_modelo->insertaRegistro(array(
                "idRegistroHora" => $insertHour['lastId'],
                "creadorAlta" => $dataEvent->correo,
            ),"capacita_usuario_creador");
            //----------> capacita_registros
            $insertRegistration = $this->capacita_modelo->insertaRegistro(array(
                "idPersona" => $user->idPersona,
                "idRegistroHora" => $insertHour['lastId'],
                "tipoRegistro" => "interno",
                "estado" => $status,
            ), "capacita_registros");
            //----------> capacita_responsable
            $insertResponsibleReference = $this->capacita_modelo->insertaRegistro(array(
                "responsable" => $responsible->idPersona,
                "fechaCompromiso" => $dataEvent->fecha_inicio,
                "idRegistro" => $insertRegistration['lastId']
            ), "capacita_responsable");
            //----------> capacita_relacion_invitado_registro
            $insertGuestAndRecordRelationship = $this->capacita_modelo->insertaRegistro(array(
                "id_invitado" => $guest,
                "idRegistro" => $insertRegistration['lastId']
            ), "capacita_relacion_invitado_registro");

            $data['information'] = array("dataEvent" => $dataEvent, "dataGuest" => $dataGuest, "category" => $category, "ramo" => $ramo, "responsible" => $responsible, "subCategory" => $subCategory, "typeLastCategory" => $typeLastCategory, "user" => $user);
            //$data['registration'] = array("capacita_registros_horas" => $insertHour, "capacita_relacion_hora_ramo" => $insertHourRamo, "capacita_usuario_creador" => $insertCreator, "capacita_registros" => $insertRegistration, "capacita_responsable" => $insertResponsibleReference, "capacita_relacion_invitado_registro" => $insertGuestAndRecordRelationship);
        }
        else {
            $data['update'] = $this->superestrella_model->updateEventRegister($register,$status);
        }
        $data['status'] = $this->superestrella_model->getEventGuest($guest);
        $data['data'] = array("idInvitado" => $guest, "capacitacion" => $event, "valor" => $value, "update" => $action, "estado" => $status);
        echo json_encode($data);
    }

    function getResultEvents() {//Desactivado
        $data = $this->superestrella_model->getTrainingEvent();
        echo json_encode($data);
    }

    function getResultTraining() {
        $quarter = $this->input->get('qr');
        $year = $this->input->get('yr');
        $data['events'] = $this->superestrella_model->getEventsByQuarter($quarter,$year);
        $data['employees'] = $this->superestrella_model->getEmployeeTraining($quarter,$year);
        echo json_encode($data);
    }
    //[Extras] Vacaciones [2024-03-20] -------------------------------------------------------------------------------
    function getSearchEmployeeVacations() {
        $year = $this->input->get('yr');
        $area = $this->input->get('ar');
        $search = $this->getSearchTypeEmployee($area);
        $data['vacations'] = $this->superestrella_model->getVacations($area,$year,$search);
        $data['data'] = array("año" => $year, "area" => $area);
        echo json_encode($data);
    }
    //[Extras] Capacitaciones [2024-04-26] ----------------------------------------------------------------------------
    function getSearchEmployeeTraining() {
        $year = $this->input->get('yr');
        $area = $this->input->get('ar');
        $search = $this->getSearchTypeEmployee($area);
        $data['training'] = $this->superestrella_model->getTraining($area,$year,$search);
        $data['data'] = array("año" => $year, "area" => $area);
        echo json_encode($data);
    }

    function getTrainingByEmployee() { //Desactivado
        $idPersona = $this->input->get('id');
        $year = $this->input->get('yr');
        $data['events'] = $this->superestrella_model->getTrainingByEmployee($idPersona,$year);
        $data['data'] = $idPersona;
        echo json_encode($data);
    }
    //----------------------------------------------------------------------------
}
