<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class calificacionAgente extends CI_Controller{
  
    function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $this->load->library("libreriav3");
        $this->load->library("excel");
        $this->load->model('califica_agente_model');
        $this->load->model('superestrella_model');
        $this->load->model('email_model');
        $this->load->model('PersonaModelo');
    }
    //---------------------------------------------------------------
    function index(){
        $this->load->view('calificacion_agente/alerta');
    }
//--> Module --------------------------------------------------------------------------------------------------------
    function valoracion() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            //Usuario
            $data['username'] = $this->tank_auth->get_username();
            $data['email']  = $this->tank_auth->get_usermail();
            $data['idPersona'] = $this->tank_auth->get_idPersona();
            $data['idPersonaPuesto'] = $this->tank_auth->get_idPersonaPuesto();
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
            //Empleados
            $data['empleados'] = $this->getEmailsEmployees();
            //Agentes
            $data['agentes'] = $this->getEmailsAgents();
            $this->load->view('headers/header');
            $this->load->view('headers/menu');
            $this->load->view('calificacion_agente/principal',$data);
        }
    }

    function getEmailsEmployees() {
        $data = $this->PersonaModelo->devolverColaboradoresActivos(array("grupos" => 1));
        $option = '';
        foreach ($data as $key1 => $value1) {
            $option.='<optgroup data-filter="'.$value1['Name'].'" label="'.$value1['Name'].'">';
            foreach ($value1['Data'] as $key => $value) {
                $nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
                $option.='<option value="'.$value['email'].'" data-id="'.$value['idPersona'].'" data-name="'.$nombres.'" data-area="'.$value1['Name'].'" data-coord="'.$value['esCoordinador'].'" data-coordcom="3" data-agente="0">'.$nombres.' <label>('.$value['email'].')</label></option>';
            }
            $option.='</optgroup>';
        }
        return $option;
    }

    function getEmailsAgents() {
        $clasificacion = $this->PersonaModelo->clasificacionUsuariosParaEnvios(null);
        $personaTipoEnvio = array();
        foreach ($clasificacion as $key => $value) {
            if($value['Name']!='Marketing proyecto 100'){
                foreach ($value['Data'] as  $valueData) {
                    $valueData['Name']=$value['Name'];
                    array_push($personaTipoEnvio, (object)$valueData);
                }
            }
        }
        $agents = $this->libreriav3->agrupaPersonasParaSelect($personaTipoEnvio,array("tipoPersona" => "Agente"));

        $option = "";
        foreach ($agents as $key => $value) {
            $option .= '<optgroup label="'.$key.'">';
            foreach ($value as $row) {
                $name = $row->apellidoPaterno.' '.$row->apellidoMaterno.' '.$row->nombres;
                $option .= '<option class="dropdown-item" data-person="agente" data-agente="4" data-department="'.$key.'" value="'.$row->email.'">'.$name.' (<label style="color:black;">'.$row->email.'</label>)</option>';
            }
            $option.='</optgroup>';
        }
        return $option;
    }

    function evaluacion_vista_ejemplo() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else {
            $id = $this->input->get('id');
            $idPersona = $this->tank_auth->get_idPersona();
            $photo = $this->califica_agente_model->getPictureUser($idPersona);
            $data['id'] = "0";
            $data['mode'] = "example";
            $data['ag'] = $this->superestrella_model->getEmployeePosition(2,$idPersona)[0];
            $data['photo'] = base_url().'/assets/img/miInfo/userPhotos/'.$photo;
            $data['questions'] = $this->createQuestionForEvaluation($id);
            $data['client_name'] = "";
            $data['client_desc'] = "";
            $data['subsidiary'] = "";
            $this->load->view('calificacion_agente/calificar',$data);
        }
    }

    function createQuestionForEvaluation($id) {
        $data = '';
        $questions = $this->califica_agente_model->getQuestionEvaluation($id);
        if (!empty($questions)) {
            foreach ($questions as $key => $val) {
                $num = $key + 1;
                $options = $this->classifyQuestionsByType($val->id_pregunta,$num,$val->tipo_respuesta);
                $instructions = '';
                $option_other = '';
                $class_column = 'column-flex-space-evenly';
                if ($val->tipo_respuesta == 2 || $val->tipo_respuesta == 3) {
                    $class_column = 'col-grid-4';
                    $option_other = '
                        <div class="column-flex-space-evenly container-other-opinion">
                            <hr>
                            <div class="content-opinion pd-items-table collapse" id="otherOp'.$val->id_pregunta.'">
                                <label class="form-check-label">Escribe:</label>
                                <textarea type="text" class="form-control" id="other-'.$val->id_pregunta.'" name="'.$id.'"></textarea>
                            </div>
                        </div>
                    ';
                }
                $data .= '
                    <div class="container-question" id="q-'.$num.'">
                        <p class="textForm"><span id="q'.$num.'-text">'.$num.'.- '.$val->pregunta.' '.$instructions.'</span></p>
                        <div class="'.$class_column.' items-quiz">'.$options.'</div>'.$option_other.'
                    </div>
                ';
            }
        }
        else {
            $data = '<center>Aún no se agregan preguntas a esta encuesta.</center>';
        }
        return $data;
    }

    function classifyQuestionsByType($id,$num,$type) {
        $options = '';
        switch ($type) {
            case '1':
                $options .= '
                    <div class="form-check column-flex-center-center pd-items-table">
                        <input type="radio" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-other="0" name="'.$id.'" value="Y">
                        <label class="form-check-label">Sí</label>
                    </div>
                    <div class="form-check column-flex-center-center pd-items-table">
                        <input type="radio" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-other="0" name="'.$id.'" value="N">
                        <label class="form-check-label">No</label>
                    </div>
                ';
                break;
            case '2':
                $sql = $id.' AND tipo = 0';
                $option_type = $this->califica_agente_model->getQuestionOptions($sql);
                foreach ($option_type as $key => $val) {
                    $other = 0;
                    $collapse = '';
                    if ($val->respuesta == 1) {
                        $other = 1;
                        $collapse = 'data-bs-toggle="collapse" href="#otherOp'.$id.'" aria-expanded="true"';
                    }
                    $options .= '
                        <label class="column-flex-start form-check-label check-btn pd-items-table" for="q'.$id.'-op'.$val->id_opcion.'" '.$collapse.'>
                            <input type="radio" class="form-check-input answer-quiz check-select" id="q'.$id.'-op'.$val->id_opcion.'" data-num="'.$num.'" data-type="'.$type.'" data-other="'.$other.'" name="'.$id.'" value="'.$val->id_opcion.'">
                            '.$val->titulo.'
                        </label>
                    ';
                }
                break;
            case '3':
                $sql = $id.' AND tipo = 1';
                $option_type = $this->califica_agente_model->getQuestionOptions($sql);
                foreach ($option_type as $key => $val) {
                    $other = 0;
                    $collapse = '';
                    if ($val->respuesta == 1) {
                        $other = 1;
                        $collapse = 'data-bs-toggle="collapse" href="#otherOp'.$id.'" aria-expanded="true"';
                    }
                    $options .= '
                        <label class="column-flex-start form-check-label check-btn pd-items-table" for="q'.$id.'-op'.$val->id_opcion.'" '.$collapse.'>
                            <input type="checkbox" class="form-check-input answer-quiz check-select" id="q'.$id.'-op'.$val->id_opcion.'" data-num="'.$num.'" data-type="'.$type.'" data-other="'.$other.'" name="'.$id.'" value="'.$val->id_opcion.'">
                            '.$val->titulo.'
                        </label>
                    ';
                }
                break;
            case '4':
                $p = '';
                for ($i=0;$i<5;$i++) {
                    $id_star = $i + 1;
                    $value = 5 - $i;
                    $p .= '
                        <input class="answer-quiz" type="radio" id="star'.$id_star.'-'.$id.'" data-num="'.$num.'" data-type="'.$type.'" data-other="0" name="'.$id.'" value="'.$value.'">
                        <label for="star'.$id_star.'-'.$id.'"><i class="fas fa-star icon-star"></i></label>
                    ';
                }
                
                $options .= '
                    <div class="column-flex-center-center content-stars pd-items-table">
                        <p class="container-stars">'.$p.'</p>
                    </div>
                ';
                break;
            case '5':
                $options .= '
                    <div class="column-flex-center-center content-opinion pd-items-table">
                        <textarea type="text" class="form-control answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-other="0" name="'.$id.'"></textarea>
                    </div>
                ';
                break;
        }
        return $options;
    }

    function getCompleteInformationEvaluation() {
        $email = $this->input->get('em');
        $month = $this->input->get('mt');
        $year = $this->input->get('yr');
        $type = $this->input->get('tp');
        //Parámetros Consultas
        $sql['sql_e'] = '';
        $sql['sql_r'] = 'AND YEAR(cr.fecha_creacion) = '.$year;        
        if ($month != "todos") {
            $sql['sql_r'] .= ' AND MONTH(cr.fecha_creacion) = '.$month;
        }
        if ($email != "todos") {
            $sql_a = 'AND us.email = "'.$email.'"';
            $agent = $this->califica_agente_model->getActiveAgent($sql_a);
            $agent = !empty($agent) ? $agent[0] : $this->califica_agente_model->getActiveEmployee($sql_a)[0];
            $sql['sql_r'] .= ' AND cr.agente = '.$agent->idPersona;
        }
        $sql['sql_r'] .= ' ORDER BY cr.fecha_creacion DESC';
        $data['result'] = $this->califica_agente_model->getInformationCompleteEvaluation($sql);
        $data['sql'] = $sql;
        if ($type == 1) {
            echo json_encode($data);
        }
        else {
            $title = "Evaluaciones ".date("Y-m-d H:i:s");
            $header = array("0" => "N°", "1" => "Nombre", "2" => "Lugar", "3" => "Motivo", "4" => "Agente", "5" => "Fecha");
            $body = array();
            $generate = $data['result'][0]->generadas;
            $question = $data['result'][0]->preguntas;
            foreach ($question as $val) {
                array_push($header,$val->pregunta);
            }
            foreach ($generate as $key => $val) {
                $num = $key + 1;
                $field = 6;
                $answers = $val->respuestas;
                $subsidiary = "";
                switch ($val->lugar) {
                    case '1': $subsidiary = "Merida Buenavista"; break;
                    case '2': $subsidiary = "Merida Norte"; break;
                    case '3': $subsidiary = "Cancún"; break;
                }
                $add[0] = $num;
                $add[1] = $val->nombre;
                $add[2] = $subsidiary;
                $add[3] = $val->motivo;
                $add[4] = $val->agente_nombre;
                $add[5] = date('d/m/Y',strtotime($val->fecha_creacion));
                if (!empty($answers)) {
                    foreach ($question as $value) {
                        $anw = "";
                        foreach ($answers as $row) {
                            if ($row->id_pregunta == $value->id_pregunta) {
                                switch ($row->tipo_respuesta) {
                                    case '1': $anw = $row->respuesta == "Y" ? "Si" : "No"; break;
                                    case '2': 
                                        if (!empty($anw)) { $anw .= ', '; }
                                        $anw .= $row->opcion[0]->respuesta != 1 ? $row->opcion[0]->titulo : ($row->opcion[0]->titulo.': '.$row->otros); 
                                        break;
                                    case '3': 
                                        if (!empty($anw)) { $anw .= ', '; }
                                        $anw .= $row->opcion[0]->respuesta != 1 ? $row->opcion[0]->titulo : ($row->opcion[0]->titulo.': '.$row->otros); 
                                        break;
                                    case '4': $anw = $row->respuesta .= ' Estrellas'; break;
                                    default: $anw = $row->respuesta; break;
                                }
                            }
                      }
                        $add[$field] = $anw;
                        $field++;
                    }
                }
                else {
                    $qt = count($question);
                    $anw = "";
                    for ($i=0;$i<$qt;$i++) {
                        $add[$field] = $anw;
                        $field++;
                    }
                }
                array_push($body, $add);
            }
            /*$data['title'] = $title;
            $data['header'] = $header;
            $data['body'] = $body;
            echo json_encode($data);*/
            $this->exportQueryData("Respuestas",$title,$header,$body);
        }
    }

    function getCreatedQuestionsOfEvaluation() {
        $data = $this->califica_agente_model->getQuestionEvaluation($this->input->get('id'));
        echo json_encode($data);
    }

    function getOptionsByQuestion() {
        $sql = $this->input->get('id');
        if (!empty($this->input->get('tp'))) {
            $sql .= ' AND tipo = '.$this->input->get('tp');
        }
        $data = $this->califica_agente_model->getQuestionOptions($sql);
        echo json_encode($data);
    }

    function getInformationAgent() {
        $email = $this->input->get('em');
        $sql = 'AND us.email = "'.$email.'"';
        $data = $this->califica_agente_model->getActiveAgent($sql);
        $data = !empty($data) ? $data : $this->califica_agente_model->getActiveEmployee($sql);
        //$data['data'] = array("email" => $email, "sql" => $sql);
        echo json_encode($data);
    }

    function insertDataForCreateQuestion() {
        $action = $this->input->post('ac');
        $dd = $this->input->post('in');
        $insert = array(
            "id_valoracion" => $dd[0],
            "pregunta" => $dd[1],
            "tipo_respuesta" => $dd[2]
        );
        if ($action == 1) {
            $insert['creado_por'] = $this->tank_auth->get_idPersona();
            $insert['fecha_creacion'] = date("Y-m-d H:i:s");
            $data['status'] = $this->califica_agente_model->insertQuestionEvaluation($insert);
        }
        else {
            $id = $dd[3];
            $insert['modificado_por'] = $this->tank_auth->get_idPersona();
            $data['status'] = $this->califica_agente_model->updateQuestionEvaluation($id,$insert);
        }
        $data['insert'] = $insert;
        echo json_encode($data);
    }

    function insertOptionsByQuestion() {
        $insert = array(
            "id_pregunta" => $this->input->post('id'),
            "titulo" => $this->input->post('tx'),
            "tipo" => $this->input->post('tp'),
            "respuesta" => $this->input->post('ck'),
            "creado_por" => $this->tank_auth->get_idPersona(),
            "registro" => date("Y-m-d H:i:s")
        );
        $data['status'] = $this->califica_agente_model->insertQuestionOptions($insert);
        $data['insert'] = $insert;
        echo json_encode($data);
    }

    function deleteQuestion() {
        $id = $this->input->post('id');
        $data['status'] = $this->califica_agente_model->deleteQuestionEvaluation($id);
        $data['data'] = $id;
        echo json_encode($data);
    }

//--> Evaluation Settings -------------------------------------------------------------------------------------------

    function puntuacion() {
        $idPersona = $this->input->get('ag');
        $photo = $this->califica_agente_model->getPictureUser($idPersona);
        $evaluation = $this->califica_agente_model->getActiveEvaluation()[0];
        $sql = 'AND p.idPersona = '.$idPersona;
        $consult = $this->califica_agente_model->getActiveAgent($sql);
        $consult = !empty($consult) ? $consult : $this->superestrella_model->getEmployeePosition(2,$idPersona);
        $data['id'] = $evaluation->id_valoracion;
        $data['mode'] = "client";
        $data['ag'] = !empty($consult) ? $consult[0] : "";
        $data['photo'] = base_url().'/assets/img/miInfo/userPhotos/'.$photo;
        $data['questions'] = $this->createQuestionForEvaluation($evaluation->id_valoracion);
        $data['client_name'] = "";
        $data['client_desc'] = "";
        $data['subsidiary'] = "";
        $this->load->view('calificacion_agente/calificar',$data);
    }

    function insertDataEvaluation() {
        $ins = $this->input->post('in');
        $ans = $this->input->post('rp');
        $evaluation = $this->califica_agente_model->getActiveEvaluation()[0];
        $insert_register = array(
            "id_valoracion" => $evaluation->id_valoracion,
            "nombre" => $ins[0],
            "lugar" => $ins[1],
            "motivo" => $ins[2],
            "agente" => $ins[3],
            "fecha_creacion" => date("Y-m-d H:i:s")
        );
        $data['status'] = $this->califica_agente_model->insertEvaluationResponse($insert_register);
        if ($data['status'] > 0) {
            foreach ($ans as $key => $val) {
                $insert_answer = array(
                    "id_resuelta" => $data['status'],
                    "id_pregunta" => $val['question'],
                    "respuesta" => $val['value'],
                    "otros" => $val['other'],
                    "fecha" => date("Y-m-d H:i:s")
                );
                if ($val['question'] == 2) {
                    $specialty = "";
                    switch($val['value']) {
                        case 1: $specialty = 5; break; //Comunicación
                        case 2: $specialty = 4; break; //Presentación
                        case 3: $specialty = 2; break; //Conocimiento
                        case 4: $specialty = 3; break; //Puntualidad
                        case 5: $specialty = 1; break; //Aptitud
                    }
                    $insert_specialty = array(
                        "id_user" => $ins[3],
                        "id_punto" => $specialty
                    );
                    $status_specialty = $this->califica_agente_model->insertSpecialtyEvaluation($insert_specialty);
                }
                $data['status_answer'] = $this->califica_agente_model->insertAnswerQuestionEvaluation($insert_answer);
            }
            //Enviar correo ?
            /*$person = $this->superestrella_model->getEmployeePosition(2,$ins[3])[0];
            $name_p = $person->nombres.' '.$person->apellidoPaterno.' '.$person->apellidoMaterno;
            $info['title'] = "Evaluación Agente Hecha";
            $info['message'] = 'Se ha realizado una Evaluación hacia <strong>'.$name_p.'</strong>. Para más información ingrese al V3 Plus.';
            $message = $this->load->view('email/alert',$info,TRUE);
            $data_send = array(
                "addressee" => 'Avisos de GAP <avisosgap@aserorescapital.com>',
                "mailer" => "?",
                "subject" => 'Evaluación Agente',
                "message" => $message,
            );
            $send['send_vend'] = $data_send;
            $send['status_send_vend'] = !empty($result->email) ? $this->send_email($data_send) : "Error";*/
        }
        $data['actions'] = array("register" => $insert_register, "response" => $insert_answer);
        //$data['send'] = $send;
        $data['data'] = array("insert" => $ins, "answers" => $ans);
        echo json_encode($data);
    }

    function send_email($data) {
        $insert = array(
            "desde" => $data['addressee'],
            "para" => $data['mailer'],
            "asunto" => $data['subject'],
            "mensaje" => $data['message'],
            "status" => 0,
            "identificaModulo" => "ValoracionAgente",
            "fechaEnvio" => date("Y-m-d H:i:s")
        );
        return $this->email_model->SendEmail($insert);
    }

    function exportQueryData($sheet,$title,$header,$body) {
        $cells = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
        //Styles
        $header_s = [
            'font' => [
                'bold'  =>  true,
                'color' => array('rgb' => 'FFFFFF'),
            ],
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ],
            'fill' =>[
              'type'=>PHPExcel_Style_Fill::FILL_SOLID,
              'color' => ['rgb' => '1e4c82']
            ],
            'borders' => [
                'top' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '7C7C7C']
                ]
            ],
        ];
        $body_s = [
            'font' => [
                'bold'  =>  false,
                'color' => array('rgb' => '000000'),
            ],
            'borders' => [
                'outline' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '7C7C7C']
                ]
            ],
        ];
        $cellI = 1;
        $row = 2;
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($sheet);
        foreach ($header as $key => $val) {
            $letter = strval($cells[$key]);
            $cell = strval($cells[$key].'1');
            $name = strval($val);
            $this->excel->getActiveSheet()->getColumnDimension($letter)->setWidth(25);
            $this->excel->getActiveSheet()->setCellValue($cell,$name)->getStyle($cell)->applyFromArray($header_s);  
        }
        foreach ($body as $key => $value) {
            $length = count($body);
            $length = $length != 0 ? $length - 1 : 0;
            $value_c = count($value);
            $value_c = $value_c != 0 ? $value_c - 1 : 0;
            foreach ($value as $k => $val) {
                $cell = strval($cells[$k].$row);
                $text = strval($val);
                $this->excel->getActiveSheet()->setCellValue($cell,$text)->getStyle($cell)->applyFromArray($body_s);
            }
            $row++;
        }
        $row = $row + 3;

        header("Content-Type: aplication/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$title.xls\"");
        header("Cache-Control: max-age=0");

        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        file_put_contents('depuracion.txt', ob_get_contents());
        ob_end_clean();
        $writer->save("php://output");
    }

//--> Digital Card --------------------------------------------------------------------------------------------------
    function getEvaluationsByAgent() {
        $agent = $this->input->get('ag');
        //$data['comments'] = $this->califica_agente_model->getCommentsByAgent($agent);
        $data['agent'] = $this->califica_agente_model->getScoresByAgent($agent)[0];
        echo json_encode($data);
    }
}
