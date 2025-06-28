<?php 

class superestrella_model extends CI_Model{
	public function __Construct(){
		parent::__Construct();
	}
    //setlocale(LC_TIME,"es_ES");
	//--------------------------------------------------------------------------------------------
	function getEmployeePosition($search,$data) { //Modificado [Suemy][2024-05-17]
		if ($search == 1) {
			$query = $this->db->query('select pp.idPuesto, pp.personaPuesto, pp.padrePuesto, pp.nivelPuesto, pp.idPersona, pp.idPersonaPuestoGrupo, c.idColaboradorArea, c.colaboradorArea, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.fecAltaSistemPersona, us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona where pp.statusPuesto=1 and pp.idPersona != 0 and c.colaboradorArea = "'.$data.'"');
		}
		else if ($search == 2) {
			$query = $this->db->query('select pp.idPuesto, pp.personaPuesto, pp.padrePuesto, pp.nivelPuesto, pp.idPersona, pp.idPersonaPuestoGrupo, c.idColaboradorArea, c.colaboradorArea, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.fecAltaSistemPersona, us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona where pp.statusPuesto=1 and pp.idPersona != 0 and pp.idPersona='.$data);
		}
		else if ($search == 3) {
			$query = $this->db->query('select pp.idPuesto, pp.personaPuesto, pp.padrePuesto, pp.nivelPuesto, pp.idPersona, pp.idPersonaPuestoGrupo, c.idColaboradorArea, c.colaboradorArea, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.fecAltaSistemPersona, us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona where pp.statusPuesto=1 and pp.idPersona != 0 and pp.padrePuesto='.$data);
		}
		else if ($search == 4) {
			$query = $this->db->query('select pp.idPuesto, pp.personaPuesto, pp.padrePuesto, pp.nivelPuesto, pp.idPersona, pp.idPersonaPuestoGrupo, c.idColaboradorArea, c.colaboradorArea, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.fecAltaSistemPersona, us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona where pp.statusPuesto=1 and pp.idPersona != 0');
		}
		else if ($search == 5) {
			$query = $this->db->query('select pp.idPuesto, pp.personaPuesto as puesto, pp.idPersona, pj.apellidoPaterno as apellidoPJ, pj.apellidoMaterno as apellidoMJ, pj.nombres as nombreJefe, ppj.personaPuesto as jefePuesto, ppj.email as jefeEmail, c.colaboradorArea as area, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.fechaNacimiento, p.telOficina, p.celOficina, p.celPersonal, p.fecAltaSistemPersona as altaSistema, TIMESTAMPDIFF(YEAR, (p.fecAltaSistemPersona), DATE(NOW())) as antiguedad, us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona left join personapuesto ppj on ppj.idPuesto = pp.padrePuesto inner join persona pj on pj.idPersona = ppj.idPersona where pp.statusPuesto=1 and pp.idPersona != 0 and pp.idPersona='.$data);
		}
		return $query->num_rows() > 0 ? $query->result() : array();
	}

	function getConsultBySQL($sql) {
		$query = $this->db->query($sql)->result();
		return $query;
	}

//------------------------------------------------- Auditoría -------------------------------------------------
	function insertAudit($data) {
		$query = $this->db->insert('calificacion_auditoria',$data);
		return $this->db->insert_id();
	}

	function updateAudit($data,$id) {
		$this->db->where('id',$id);
		$query = $this->db->update('calificacion_auditoria',$data);
		return $query;
	}

	function getResultCompleteAudit($year,$quarter) {//Modificado [2024-04-22]
		$this->db->select('ca.*, pp.idPuesto, pp.personaPuesto, pp.padrePuesto, pp.nivelPuesto, pp.idPersonaPuestoGrupo, pp.idColaboradorArea, c.idColaboradorArea, c.colaboradorArea, p.nombres, p.apellidoPaterno, p.apellidoMaterno, us.email');
        $this->db->join('users us','us.idPersona = ca.idPersona','inner');
        $this->db->join('persona p','p.idPersona = ca.idPersona','inner');
        $this->db->join('personapuesto pp','pp.idPersona = p.idPersona','inner');
        $this->db->join('colaboradorarea c','c.idColaboradorArea = pp.idColaboradorArea','inner');
        //$this->db->where(array('p.emailUsers' => $email, 'YEAR(f.fecha)' => $year, 'f.descripcion' => 'puntualidad'));
        //$this->db->where('ca.periodo',$year);
        $this->db->where(array('ca.periodo' => $year, 'ca.trimestre' => $quarter));
        $this->db->order_by('ca.id', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('calificacion_auditoria ca');
        return $query->num_rows() > 0 ? $query->result() : array();
	}

	function getEmployeesAudit($id,$year) {
		$data = array();
		$query = $this->db->query('select pp.idPuesto, pp.personaPuesto, pp.padrePuesto, pp.nivelPuesto, pp.idPersona, pp.idPersonaPuestoGrupo, pp.idColaboradorArea, c.idColaboradorArea, c.colaboradorArea, p.nombres, p.apellidoPaterno, p.apellidoMaterno, us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona where pp.statusPuesto=1 and pp.idPersona != 0 and pp.padrePuesto='.$id)->result();
		foreach ($query as $val) {
			$sql = $this->db->query('select * from calificacion_auditoria where idPersona = '.$val->idPersona.' and periodo = '.$year)->result();
			$add['nombre'] = $val->apellidoPaterno.' '.$val->apellidoMaterno.' '.$val->nombres;
			$add['area'] = $val->colaboradorArea;
			$add['email'] = $val->email;
			//$add['idColaboradorArea'] = $val->idColaboradorArea;
			$add['idPersona'] = $val->idPersona;
			$add['idPersonaPuestoGrupo'] = $val->idPersonaPuestoGrupo;
			$add['idPuesto'] = $val->idPuesto;
			//$add['nivelPuesto'] = $val->nivelPuesto;
			$add['padrePuesto'] = $val->padrePuesto;
			$add['personaPuesto'] = $val->personaPuesto;
			$add['auditoria'] = $sql;
			array_push($data, $add);
		}
		return $data;
	}

//------------------------------------------------ Puntualidad ------------------------------------------------
	function getEmployeesAttendance($quarter,$year,$area,$search) { //Modificado [2024-05-10]
		$data = array();
		$employees = $this->getEmployeePosition($search,$area);
		foreach ($employees as $val) {
			$present = $this->getAttendanceByQuarter($quarter,$year,$val->idPersona);
			$add['idPersona'] = $val->idPersona;
			$add['nombre'] = $val->apellidoPaterno.' '.$val->apellidoMaterno.' '.$val->nombres;
			$add['email'] = $val->email;
			$add['area'] = $val->colaboradorArea;
			$add['puesto'] = $val->personaPuesto;
			$add['asistencias'] = $present;
			array_push($data, $add);
		}
		return $data;
	}

	function getAttendanceByQuarter($quarter,$year,$idPersona) { //Creado [2024-05-10]
		$data = array();
		$months = $this->getMonthsByQuarter($quarter);
		foreach ($months as $val) {
			$add = $this->getAttendanceByEmployee($idPersona,$val,$year);
			array_push($data, $add);
		}
		return $data;
	}

	function getAttendanceByEmployee($idPersona,$month,$year) {
		$data['asistencia'] = $this->checkDescriptionByVacations($idPersona,"asistencia",$month,$year);
		$data['puntualidad'] = $this->checkDescriptionByVacations($idPersona,"puntualidad",$month,$year);
		$data['salida'] = $this->checkDescriptionByVacations($idPersona,"Salida",$month,$year);
		$data['vacaciones'] = $this->getAttendanceByDescription($idPersona,"vacacion",$month,$year);
		return $data;
	}

	function getAttendanceByDescription($idPersona,$description,$month,$year) {
		$query = $this->db->query('SELECT * FROM fastfile WHERE idPersona = '.$idPersona.' AND descripcion = "'.$description.'" AND MONTH(fecha) = '.$month.' AND YEAR(fecha) = '.$year)->result();
		return $query;
	}

	function checkDescriptionByVacations($idPersona,$description,$month,$year) { //Creado [2024-05-10]
		$data = array();
		$query = $this->getAttendanceByDescription($idPersona,$description,$month,$year);
		if (!empty($query) && $description != "vacacion") {
			foreach ($query as $val) {
				$date = date('Y-m-d',strtotime($val->fecha));
				$vacations = $this->db->query('SELECT * FROM fastfile WHERE descripcion = "vacacion" AND idPersona = '.$val->idPersona.' AND DATE(fecha) = "'.$date.'"')->result();
				if (empty($vacations)) { array_push($data, $val); }
			}
		}
		return $data;
	}

	function getFastFileByDescription($idPersona,$month,$year) { //Creado [2024-05-17]
		$query = $this->db->query('SELECT * FROM fastfile WHERE idPersona = '.$idPersona.' AND descripcion != "asistencia" AND descripcion != "puntualidad" AND descripcion != "Salida" AND descripcion != "vacacion" AND MONTH(fecha) = '.$month.' AND YEAR(fecha) = '.$year)->result();
		return $query;
	}

//------------------------------------------------ Capacitación -----------------------------------------------
	function getEventsSelect() {
		$query = $this->db->select('id_cal, titulo')->where('clasificacion','capacitacion')->order_by('id','desc')->get('cal_events_json');
		return $query->num_rows() > 0 ? $query->result() : array();
	}

	function getEventsTraining($event) {
		//$data = array();
		$query = $this->db->query('SELECT * FROM cal_events_json WHERE clasificacion = "capacitacion" AND id_cal = "'.$event.'" ORDER BY id DESC')->result();
		foreach ($query as $val) {
			$user = array();
			//$sql = $this->db->query('SELECT e.*, us.idPersona, us.name_complete FROM invitados_eventos e INNER JOIN users us ON e.correo_lectronico = us.email WHERE e.id_evento = "'.$val->id_cal.'"')->result();
			$sql = $this->db->query('SELECT * FROM invitados_eventos WHERE estado = "aceptado" AND id_evento = "'.$val->id_cal.'"')->result();
			foreach ($sql as $row) {
				$con = $this->getEventGuest($row->id_invitado);
				$add['idEvento'] = $row->id_evento;
				$add['idInvitado'] = $row->id_invitado;
				$add['idPersona'] = $this->getIdPersonaByEmail($row->correo_lectronico);
				$add['email'] = $row->correo_lectronico;
				$add['estado'] = $row->estado;
				$add['nombre'] = $row->apellido_paterno.' '.$row->apellido_materno.' '.$row->nombres;
				$add['organizacion'] = $row->organizacion;
				$add['puesto'] = $row->puesto;
				$add['telefono'] = $row->telefono;
				$add['tipo_invitado'] = $row->tipo_invitado;
				$add['registro'] = $con;
				array_push($user, $add);
			}
			//----------- Desactivar botón Guardar ---------
			//$disabledUpdate = "";
			$disabledSave = "";
			$dateD = date('Y-m-d',strtotime($val->fecha_inicio."+ 2 days"));
			//if (date('Y-m-d') > $dateD) { $disabledUpdate = "disabled"; }
			if (date('Y-m-d') != $val->fecha_inicio) { $disabledSave = "disabled"; }
			//----------- Fechas ---------
			//$dateI = $val->fecha_inicio.' '.$val->hora_inicio.':00';
			//$dateF = $val->fecha_final.' '.$val->hora_final.':00';
			//----------- Horas ---------
			$hours = $this->getDurationEvent($val->hora_inicio,$val->hora_final);
			//----------- Ramo ---------
			$ramo = $val->ramo_capacitacion;
			if ($val->ramo_capacitacion == "Seleccione un ramo" || $val->ramo_capacitacion == "") { $ramo = "Ninguno"; }

			$data['id'] = $val->id;
			$data['id_cal'] = $val->id_cal;
			$data['titulo'] = $val->titulo;
			$data['categoria'] = $val->sub_categoria_capacitacion;
			$data['duracion'] = $hours;
			$data['invitados'] = $user;
			//$data['fecha_actualizar'] = $dateD;
			//$data['actualizar'] = $disabledUpdate;
			$data['fecha'] = $val->fecha_inicio;
			$data['guardar'] = $disabledSave;
			$data['lugar'] = $val->lugar;
			$data['horaI'] = $val->hora_inicio.' Horas';
			$data['horaF'] = $val->hora_final.' Horas';
			$data['ramo'] = $ramo;
			$data['tiempo'] = strval(number_format($hours,2));
 		}
		return $data;
	}

	function getEventsRegister() {
		$query = $this->db->query('SELECT ci.*, cr.estado FROM capacita_relacion_invitado_registro ci INNER JOIN capacita_registros cr ON ci.idRegistro = cr.idRegistro')->result();
		return $query;
	}

	function getEventGuest($guest) {
		$query = $this->db->query('SELECT ci.*, cr.estado FROM capacita_relacion_invitado_registro ci INNER JOIN capacita_registros cr ON ci.idRegistro = cr.idRegistro WHERE ci.id_invitado = '.$guest)->result();
		return $query;
	}

	function updateEventRegister($id,$data) {
		$this->db->where('idRegistro',$id);
		$this->db->set('estado',$data);
		$query = $this->db->update('capacita_registros');
		return $query;		
	}

	function getTrainingEvent() {
		$data = array();
		$query = $this->db->query('SELECT * FROM cal_events_json ORDER BY id DESC')->result();
		foreach ($query as $val) {
			//----------- Ramo ---------
			$ramo = $val->ramo_capacitacion;
			if ($ramo == "Seleccione un ramo" || $ramo == "" || $ramo == NULL) { $ramo = "Ninguno"; }

			$add['id'] = $val->id;
			$add['idEvent'] = $val->id_cal;
			$add['titulo'] = $val->titulo;
			$add['categoria'] = $val->sub_categoria_capacitacion;
			$add['creado_por'] = $val->correo;
			$add['descripcion'] = $val->descripcion;
			$add['fecha'] = date('d/m/Y',strtotime($val->fecha_inicio)).' De '.$val->hora_inicio.' a '.$val->hora_final;
			//$add['fecha_inicio'] = $val->fecha_inicio;
			//$add['fecha_final'] = $val->fecha_final;
			$add['lugar'] = $val->lugar;
			//$add['hora_inicio'] = $val->hora_inicio;
			//$add['hora_final'] = $val->hora_final;
			$add['ramo'] = $ramo;
			$add['solicitudes'] = $this->getCountEventGuest($val->id_cal,"");
			$add['solicitudes_aceptadas'] = $this->getCountEventGuest($val->id_cal,'AND estado = "aceptado"');
			$add['solicitudes_pendientes'] = $this->getCountEventGuest($val->id_cal,'AND estado = "pendiente"');
			$add['usuarios_asistidos'] = $this->getCountGuestStatus($val->id_cal,"activo");
			$add['usuarios_faltantes'] = $this->getCountGuestStatus($val->id_cal,"inactivo");
			$add['url'] = $val->liga;
			array_push($data, $add);
		}
		return $data;
	}

	function getEmployeeTraining($quarter,$year) {
		$data = array();
		$quarterly = $this->getRangeByQuarter($quarter);
		$employees = $this->getEmployeePosition(4,"");
		foreach ($employees as $val) {
			$sql = $val->email.'" AND YEAR(cj.fecha_inicio) = '.$year.' AND MONTH(cj.fecha_inicio) BETWEEN '.$quarterly['monthI'].' AND '.$quarterly['monthF'];
			$event = $this->getEventByEmployee($sql);
			$add['idPersona'] = $val->idPersona;
			$add['nombre'] = $val->apellidoPaterno.' '.$val->apellidoMaterno.' '.$val->nombres;
			$add['email'] = $val->email;
			$add['area'] = $val->colaboradorArea;
			$add['puesto'] = $val->personaPuesto;
			//$add['busqueda'] = $search;
			$add['eventos'] = $event;
			array_push($data, $add);
		}
		return $data;
	}

	function getEventByEmployee($sql) {
		$data = array();
		$query = $this->db->query('SELECT cj.*, ie.id_invitado, ie.correo_lectronico, ie.tipo_invitado, ie.estado FROM cal_events_json cj INNER JOIN invitados_eventos ie ON ie.id_evento = cj.id_cal WHERE ie.correo_lectronico = "'.$sql)->result();
		foreach ($query as $val) {
			$idRegister = 0;
			$status = "";
			$register = $this->getEventGuest($val->id_invitado);
			foreach ($register as $row) {
				$idRegister = $row->idRegistro;
				$status = $row->estado;
			}
			$add['id'] = $val->id;
			$add['id_event'] = $val->id_cal;
			$add['id_invitado'] = $val->id_invitado;
			$add['id_registro'] = $idRegister;
			$add['asistencia'] = $status;
			$add['email'] = $val->correo_lectronico;
			$add['fecha_evento'] = $val->fecha_inicio;
			$add['hora_evento'] = "De ".$this->getNoonTimeSystem($val->hora_inicio)." A ".$this->getNoonTimeSystem($val->hora_final);
			//$add['hora_inicio'] = date('Y-m-d H:i:s',strtotime($val->fecha_inicio.' '.$val->hora_inicio.':00'));
			$add['duracion'] = $this->getDurationEvent($val->hora_inicio,$val->hora_final);
			//$add['registro'] = $register;
			$add['solicitud'] = $val->estado;
			$add['tipo_invitado'] = $val->tipo_invitado;
			$add['titulo'] = $val->titulo;
			$add['tiempo'] = strval(number_format($this->getDurationEvent($val->hora_inicio,$val->hora_final),2));
			$add['trimestre'] = $this->getQuarterByMonth(date('m',strtotime($val->fecha_inicio)));
			array_push($data, $add);
		}
		return $data;
	}

	function getEventsByQuarter($quarter,$year) {
		$data = array();
		$months = $this->getRangeByQuarter($quarter);
		$query = $this->db->query('SELECT * FROM cal_events_json WHERE YEAR(fecha_inicio) = '.$year.' AND MONTH(fecha_inicio) BETWEEN '.$months['monthI'].' AND '.$months['monthF'])->result();
		foreach ($query as $val) {
			$hours = $this->getDurationEvent($val->hora_inicio,$val->hora_final);
			$add['id'] = $val->id;
			$add['id_cal'] = $val->id_cal;
			$add['titulo'] = $val->titulo;
			$add['duracion'] = $hours;
			$add['fecha'] = $val->fecha_inicio;
			$add['tiempo'] = strval(number_format($hours,2));
			array_push($data, $add);
		}
		return $data;
	}

	function getCountEventGuest($event,$sql) {
		$query = $this->db->query('SELECT COUNT(id_invitado) AS cantidad FROM invitados_eventos WHERE id_evento = "'.$event.'" '.$sql)->row()->cantidad;
		return $query;
	}

	function getCountGuestStatus($event,$status) {//COUNT(cg.idRegistro) AS cantidad
		$query = $this->db->query('SELECT COUNT(cg.idRegistro) AS cantidad FROM capacita_registros cg INNER JOIN capacita_relacion_invitado_registro cr ON cr.idRegistro = cg.idRegistro INNER JOIN invitados_eventos ev ON ev.id_invitado = cr.id_invitado WHERE ev.id_evento = "'.$event.'" AND cg.estado = "'.$status.'"');
		return $query->row()->cantidad;
	}

	function getDurationEvent($hourI,$hourF) {
		$data = (strtotime($hourF) - strtotime($hourI)) / 3600;
		return $data;
	}

//-------------------------------------------- [Extras] Vacaciones --------------------------------------------
	function getVacations($area,$year,$search) {
		$data = array();	
		$employees = $this->getEmployeePosition($search,$area);
		foreach ($employees as $val) {
			$sql = array();
			$antiquity = $this->getDiffTime($val->fecAltaSistemPersona,date('Y-m-d'))->y;
			$start = date('Y-m-d',strtotime($val->fecAltaSistemPersona.' + '.$antiquity.' years'));
			$finish = $this->getAnniversaryDate($val->fecAltaSistemPersona);
			$limit = "green";
			$days_r = (strtotime($finish) - strtotime(date('Y-m-d'))) / 86400;
			if (date('Y-m-d') == date('Y-m-d',strtotime($finish))) {
				$limit = "red";
			}
			else if (date('Y-m-d') > date('Y-m-d',strtotime($finish.' - 2 days'))) {
				$limit = "orange";
			}
			else if (date('Y-m-d') > date('Y-m-d',strtotime($finish.' - 7 days'))) {
				$limit = "wine";
			}
			else if (date('Y-m') == date('Y-m',strtotime($finish))) {
				$limit = "blue";
			}
			$ap = $this->db->query('SELECT SUM(cantidad_dias) AS aprobados FROM vacaciones WHERE estado = "aprobado" AND idPersona = '.$val->idPersona.' AND fecha_salida BETWEEN "'.$start.'" AND "'.$finish.'"')->row();
			$query = $this->db->query('SELECT v.*, p.fecAltaSistemPersona FROM vacaciones v INNER JOIN persona p ON p.idPersona = v.idPersona WHERE v.idPersona = '.$val->idPersona.' AND v.fecha_salida BETWEEN "'.$start.'" AND "'.$finish.'"')->result();
			foreach ($query as $row) {
				//select pp.idPuesto, pp.personaPuesto, pp.padrePuesto, pp.nivelPuesto, pp.idPersona, pp.idPersonaPuestoGrupo, c.idColaboradorArea, c.colaboradorArea, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.fecAltaSistemPersona, us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona where pp.statusPuesto=1 and pp.idPersona != 0 and month(p.fecAltaSistemPersona) = 3
				//$days = ((strtotime($row->fecha_salida) - strtotime($row->fecha)) / 3600) / 24;
				$dicember = "no";
				if (date('m',strtotime($row->fecha_salida)) == 12) {
					$dicember = "yes";
				}
				$insert['id'] = $row->id;
				$insert['idPersona'] = $row->idPersona;
				//$insert['nombre'] = $row->nombre;
				$insert['dias'] = $row->cantidad_dias;
				$insert['estatus'] = $row->estado;
				//$insert['fecha_ingreso'] = $row->fecAltaSistemPersona;
				$insert['fecha_salida'] = $row->fecha_salida;
				$insert['fecha_retorno'] = $row->fecha_retorno;
				$insert['registro'] = $row->fecha;
				$insert['solicitud_anticipada'] = $this->getDiffTime($row->fecha,$row->fecha_salida)->d;
				$insert['vacacion_semana_santa'] = "";
				$insert['vacacion_diciembre'] = $dicember;
				array_push($sql, $insert);
			}

			$add['idPersona'] = $val->idPersona;
			$add['idPuesto'] = $val->idPuesto;
			$add['nombre'] = $val->apellidoPaterno.' '.$val->apellidoMaterno.' '.$val->nombres;
			$add['email'] = $val->email;
			$add['antiguedad'] = $antiquity;
			$add['area'] = $val->colaboradorArea;
			$add['dias_restantes'] = $days_r;
			$add['dias_aprobados'] = !is_null($ap) ? $ap->aprobados : 0;
			$add['estatus_aniversario_laboral'] = $limit;
			$add['fecha_inicio'] = $start;
			$add['fecha_final'] = $finish;
			$add['puesto'] = $val->personaPuesto;
			$add['vacaciones'] = $sql;
			//$add['fechas_vacaciones'] = $this->getDaysWeek(array("dateI" => $start, "dateF" => $finish),"",2);
			array_push($data, $add);
		}
		return $data;
	}

//------------------------------------------ [Extras] Capacitaciones ------------------------------------------
	function getTraining($area,$year,$search) {
		$data = array();
		$employees = $this->getEmployeePosition($search,$area);
		foreach ($employees as $val) {
			$sql = $val->email.'" AND YEAR(cj.fecha_inicio) = '.$year.' AND ie.estado = "aceptado"';
			$event = $this->getEventByEmployee($sql);
			$external = $this->db->query('SELECT * FROM capacita_externo WHERE idPersona = '.$val->idPersona)->result();
			$add['idPersona'] = $val->idPersona;
			$add['nombre'] = $val->apellidoPaterno.' '.$val->apellidoMaterno.' '.$val->nombres;
			$add['email'] = $val->email;
			$add['area'] = $val->colaboradorArea;
			$add['puesto'] = $val->personaPuesto;
			//$add['busqueda'] = $search;
			$add['eventos'] = $event;
			$add['externos'] = $external;
			array_push($data, $add);
		}
		return $data;
	}

	function getTrainingByEmployee($idPersona,$year) { //Desactivado
		$data = array();
		$email = $this->getEmailByIdPersona($idPersona);
		$sql = $email.'" AND YEAR(cj.fecha_inicio) = '.$year;
		$query = $this->getEventByEmployee($sql);
		foreach ($query as $val) {
			$add = $this->getEventsTraining($val['id_event']);
			array_push($data, $add);
		}
		return $data;
	}

	function getExternalTrainingByEmployee($idPersona,$month,$year) {
		$query = $this->db->query('SELECT * FROM capacita_externo WHERE idPersona = '.$idPersona.' AND MONTH(date) = '.$month.' AND YEAR(date) = '.$year)->result();
		return $query;
	}

//-------------------------------------------------- General --------------------------------------------------
	function getNCByEmployee($idPersona,$month,$year) {
		$sql = 'select (select u.name_complete from users u where u.email=i.correoProcedente) as personaInconforme, cast(tnc.fechaCreacion as date) as fCreacion, DATE_FORMAT(tnc.fechaCreacion, "%d/%m/%Y %r") as fechaHoraRegistro, i.correoProcedente, i.nombreProcedente, i.descripcion, tnc.idTablaNoConformidad, tnc.idPersonaInconforme, tnc.idPersonaResponsable, CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="", "", pr.apellidoPaterno), " ", if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable, i.datosAlternos, tnc.estaModificado, tnc.idCausaRaiz, tnc.idAccionCorrectiva, tnc.nombreNoConformidad, tnc.statusNoconformidad, tnc.comentarioCierre, tnc.aFavor, tnc.comentarioAccionCorrectiva, tnc.comentarioCausaRaiz, tnc.comentarioResponsable, tnc.comentarioInconforme, i.folioInconformidad, i.idCBITipo, i.idCBIOpcion, i.idCBIArea, tnc.idRowTabla, tnc.nombreTabla, 
		(select causaRaiz from causaraiz where idCausaRaiz=tnc.idCausaRaiz) as causaRaiz,
		(select accionCorrectiva from accioncorrectiva where idAccionCorrectiva=tnc.idAccionCorrectiva) as accionCorrectiva,
		(select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=i.idCBITipo) as tipoInconformidad,
		(select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=i.idCBIOpcion) as opcionInconformidad,
		(select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=i.idCBIArea) as areaInconformidad,
		CASE
			WHEN tnc.aFavor = 0 THEN "primary"
    		WHEN tnc.aFavor = 1 THEN "success"
    		WHEN tnc.aFavor = 3 THEN "danger"
    		ELSE "oka"
    		END AS label,
    	IF(ts.status IS NULL, "NUEVO", ts.status) AS status from tablanoconformidad tnc  left join inconformidades i on i.id=tnc.idRowTabla left join persona pr on pr.idPersona=tnc.idPersonaResponsable left join tablanoconformidadstatus ts on tnc.aFavor = ts.idTNCStatus left join tablanoconformidadresponsables tr on tnc.idTablaNoConformidad=tr.idTablaNoConformidad where tnc.nombreTabla="inconformidades" and tnc.noConformidadRevisada=0 and i.tipoInconformidad=0 and i.tipoInconformidad=0 and tnc.idPersonaInconforme = '.$idPersona.' and month(tnc.fechaCreacion) = '.$month.' and year(tnc.fechaCreacion) = '.$year.' GROUP by idTablaNoConformidad order by fCreacion desc';
		$query = $this->db->query($sql)->result();
		return $query;
	}

	function getPIPByEmployee($idPersona,$idPuesto,$month,$year) {
		$query = $this->db->query('select pip.id,pip.empleado_id,u.name_complete nombre,ep.titulo,pip.created from project_implementation_plan_manager pipm inner join project_implementation_plan pip on pipm.id_PIP=pip.id inner join users u on pip.empleado_id=u.idPersona left join evaluacion_periodos ep on pip.evaluacion_periodo_id=ep.id where pip.estatus="ACTIVO" and (pipm.id_manager='.$idPuesto.' or pip.empleado_id='.$idPersona.') and month(pip.created) = '.$month.' and year(pip.created)='.$year.' group by pipm.id_PIP order by pip.id desc')->result();

		$consult = $this->db->query('select pip.id,pip.empleado_id,u.name_complete nombre,ep.titulo,pip.created from project_implementation_plan_manager pipm inner join project_implementation_plan pip on pipm.id_PIP=pip.id inner join users u on pip.empleado_id=u.idPersona left join evaluacion_periodos ep on pip.evaluacion_periodo_id=ep.id where pip.estatus="ACTIVO" and (pipm.id_manager='.$idPuesto.' or pip.empleado_id='.$idPersona.') and year(pip.created)='.($year - 1).' group by pipm.id_PIP order by pip.id desc')->result();
		
		$yearActually = $this->getArrayPIP($query);
		$yearPast = !empty($query) ? $this->getArrayPIP($consult) : "";
		$data = array($yearActually, $yearPast);
		return $data;
	}

	function getArrayPIP($query) {
		$data = array();
		foreach ($query as $key => $val) {
			$add['idPIP'] = $val->id;
			$add['idPersona'] = $val->empleado_id;
			$add['name'] = $val->nombre;
			$add['title'] = !empty($val->titulo) ? $val->titulo : "Sin periodo";
			$add['created'] = $val->created;
			$add['comment'] = $this->db->query('SELECT pi.*, p.name_complete AS name_created, p.email AS email_created, u.name_complete AS name_modified, u.email AS email_modified FROM project_implementation_plan pi INNER JOIN users p ON p.idPersona = pi.creado_por INNER JOIN users u ON u.idPersona = pi.modificado_por WHERE pi.id = '. $val->id)->result();
        	$add['task'] = $this->db->query('SELECT * FROM project_implementation_plan_task WHERE project_imp_plan_id = '. $val->id)->result();
        	array_push($data, $add);
		}
		return $data;
	}

	function getVacationsByEmployee($idPersona,$month,$year) {
		$query = $this->db->query('SELECT v.*, p.fecAltaSistemPersona FROM vacaciones v INNER JOIN persona p ON p.idPersona = v.idPersona WHERE v.idPersona = '.$idPersona.' AND MONTH(v.fecha_salida) = '.$month.' AND YEAR(v.fecha_salida) = '.$year)->result();
		return $query;
	}

	function getPeriodExam($idPersona,$sql = NULL) {
		$query = $this->db->query('SELECT epe.*, us.name_complete AS aplicado_nombre, us.email AS aplicado_email, ep.titulo AS periodo, ep.comentario, ep.estatus, ep.fecha_inicio, ep.fecha_final, ep.estatus AS estatus_periodo, e.titulo AS evaluacion, e.descripcion FROM `evaluacion_periodo_empleado` epe INNER JOIN `evaluacion_periodos` ep ON ep.id = epe.periodo_id INNER JOIN `evaluaciones` e ON e.id = epe.evaluacion_id INNER JOIN users us ON us.idPersona = epe.aplica_id WHERE epe.empleado_id = '.$idPersona.' '.$sql)->result();
		return $query;
	}

//-------------------------------------------------------------------------------------------------------------

	function getIdPersonaByEmail($email) {
		$query = $this->db->query('SELECT idPersona FROM users WHERE email = "'.$email.'"')->row();
		if (empty($query)) { $data = 0; }
		else { $data = $query->idPersona; }
		return $data;
	}

	function getEmailByIdPersona($idPersona) {
		$query = $this->db->query('SELECT email FROM users WHERE idPersona = "'.$idPersona.'"')->row();
		if (empty($query)) { $data = 0; }
		else { $data = $query->email; }
		return $data;
	}

  	function getDataTable($info) {
    	$query = $this->db->query('SELECT '.$info['data'].' FROM '.$info['table'].' WHERE '.$info['field'])->row();
    	return $query;
  	}

	function getNoonTimeSystem($hour) {
		$time = "AM";
		if ($hour >= "12:00") {
			$time = "PM";
		}
		return $hour." ".$time;
	}

  	function rangeMonth($date){
    	$date = new DateTime($date);
    	$Date = $date->format('Y-m-d');
    	$first = $date->modify('first day of this month');
    	$day_first = $first->format('Y-m-d');
    	$end = $date->modify("last day of this month");
    	$day_end = $end->format('Y-m-d');
	    return Array("dateI" => $day_first, "dateF" => $day_end);
	}

	function rangeWeek($date,$method) { //Creado [2024-06-21]
		switch($method) {
			case '1':
				$dateI = date('Y-m-d',strtotime('last Monday',strtotime($date)));
        		$dateF = date('Y-m-d',strtotime('next Sunday',strtotime($date)));
				/*Usar en caso de que la fecha seleccionada sea Lunes o Domingo
				$dateI = (date('N') != 1) ? date('Y-m-d',strtotime('last Monday',strtotime($date))) : date('Y-m-d');
				$dateF = (date('N') != 7) ? date('Y-m-d',strtotime('next Sunday',strtotime($date))) : date('Y-m-d');*/
        	break;
        	case '2':
        		$dateI = date('Y-m-d',strtotime($date."+ 1 days"));
        		$dateF = date('Y-m-d',strtotime('next Sunday',strtotime($dateI)));
        	break;
        }
        $week = array("dateI" => $dateI, "dateF" => $dateF);
        return $week;
	}

	function holidaysDates($date,$year) {
		$holidays = array();
		$holiday_ = array($year."-01-01", /*$year."-02-01", $year."-03-15",*/ $year."-05-01", $year."-09-16", $year."-11-2", $year."-12-25");
		$query = $this->db->query('SELECT diaNoLaboral FROM dianolaboral')->result();
		foreach ($query as $val) {
			array_push($holidays, $val->diaNoLaboral);
		}
		$data = in_array($date, $holiday_);
		return in_array($data, $holidays);
	}

	function getDaysWeek($method,$date,$month = NULL) { //Modificado [2024-06-21]
    	$daysWeek = 7;
    	$data = array();
    	switch($method) {
    		case '1':
    			$dayI = date('Y-m-d',strtotime($date."- 1 days"));
    	  		for ($i=0;$i<$daysWeek;$i++) {
    	    		$dayI = date('Y-m-d',strtotime($dayI."+ 1 days"));
    	    		$dMonth = date('m',strtotime(date($dayI)));
    	    		$dDay = date('l',strtotime(date($dayI)));
    	    		$add['date'] = $dayI;
    	    		if ($dMonth == $month) {// Si el mes coincide con el mes actual agregar al array
    	    		  	array_push($data, $add);
    	    		}
    	    		if ($dDay == "Sunday") {// Corta el ciclo al llegar en domingo
    	    		  	break;
    	    		}
    	  		}
    	  	break;
    	  	case '2':
    	  		$dayI = date('Y-m-d',strtotime($date['dateI']."- 1 days"));
    	  		$days = (strtotime($dayI)-strtotime($date['dateF']))/86400;
    	  		$days = abs($days); 
    	  		$days = floor($days);
    	  		for ($i=0;$i<$days;$i++) {
    	  		  	$dayI = date('Y-m-d',strtotime($dayI."+ 1 days"));
    	  		  	$add['date'] = $dayI;
    	  		  	array_push($data, $add);
    	  		}
    	  	break;
    	  	case '3':
    	  		$dayI = date('Y-m-d',strtotime($date['dateI']."- 1 days"));
    	  		$days = (strtotime($date['dateF'])-strtotime($dayI))/86400;
    	  		$days = number_format($days,0); 
    	  		$days = abs($days);
    	  		for ($i=0;$i<$days;$i++) {
    	  		  	$dayI = date('Y-m-d',strtotime($dayI."+ 1 days"));
    	  		  	$dDay = date('N',strtotime(date($dayI)));
    	  		  	$dYear = date('Y',strtotime(date($dayI)));
    	  		  	$dHoliday = $this->holidaysDates($dayI,$dYear);
    	  		  	if ($dDay != "6" && $dDay != "7" && $dHoliday != true) {
    	  		  		array_push($data, $dayI);
    	  		  	}
    	  		}
    	  	break;
    	}
    	return $data;
  	}

  	function getAvaibleDatesByQuarter($quarter,$year) { //Modificado [Suemy][2024-05-10]
  		$data = array();
  		$months = $this->getMonthsByQuarter($quarter);
  		foreach ($months as $val) {
  			$month = $val;
  			if (strlen($val) == 1) { $month = '0'.$val; }
  			$add['dateS'] = $year.'-'.$month.'-01';
  			$add['range'] = $this->rangeMonth($add['dateS']);
  			$add['dates'] = $this->getDaysWeek(3,$add['range']);
  			//$add['prueba'] = $this->holidaysDates($add['dateS'],$year);
  			array_push($data, $add);
  		}
  		return $data;
  	}

	function getRangeByQuarter($quarter) {//Modificado [2024-04-26]
		switch ($quarter) {
			case "Primero":
				$monthI = 01;
				$monthF = 03;
				break;
			case "Segundo":
				$monthI = 04;
				$monthF = 06;
				break;
			case "Tercero":
				$monthI = 07;
				$monthF = 09;
				break;
			case "Cuarto":
				$monthI = 10;
				$monthF = 12;
				break;
		}
		$data = array("monthI" => $monthI, "monthF" => $monthF);
		return $data;
	}

	function getMonthsByQuarter($quarter) {
		$data = array();
		switch ($quarter) {
			case "Primero": $month = 0;
				break;
			case "Segundo": $month = 3;
				break;
			case "Tercero": $month = 6;
				break;
			case "Cuarto": $month = 9;
				break;
		}
		for ($i=0;$i<3;$i++) {
			$month++;
			array_push($data, $month);
		}
		//array_push($data, $add);
		//$data = array("month1" => $month1, "month2" => $month2, "month3" => $month3);
		return $data;
	}

	function getQuarterByMonth($month) {
		$quarter = "";
		if ($month >= 1 && $month <= 3) {
			$quarter = "Primero";
		}
		else if ($month >= 4 && $month <= 6) {
			$quarter = "Segundo";
		}
		else if ($month >= 7 && $month <= 9) {
			$quarter = "Tercero";
		}
		else if ($month >= 10 && $month <= 12) {
			$quarter = "Cuarto";
		}
		return $quarter;
	}

	function getMonthsForQuarterly($month) {
        $data = array();
        if ($month >= 1 && $month <= 3) {
            $count = 0;
        }
        else if ($month >= 4 && $month <= 6) {
            $count = 3;
        }
        else if ($month >= 7 && $month <= 9) {
            $count = 6;
        }
        else if ($month >= 10 && $month <= 12) {
            $count = 9;
        }

        for ($i=0;$i<3;$i++) {
            $count++;
            array_push($data, $count);
        }
        return $data;
    }

    function getDiffTime($dateI,$dateF) {
    	$dI = new DateTime($dateI);
    	$dF = new DateTime($dateF);
    	$data = $dI->diff($dF);
    	return $data;
    }

    function getAnniversaryDate($anniversary) {
    	//setlocale(LC_TIME,"es_MX");
    	$today = new DateTime();
    	$date = new DateTime($anniversary);
    	$diff = $date->diff($today);
    	$format = $date->modify("".$diff->format("%R%y")." year");
    	$dateF = $format->modify("+ 1 year")->format("Y-m-d H:i:s");
    	/*$dateF = explode('-',$dateF);
    	$dateFormat = mktime(0,0,0,$dateF[1],$dateF[2],$dateF[0]);
    	$data = strftime('%A %d de %B del %Y',$dateFormat);*/
    	return date('Y-m-d',strtotime($dateF));
    }

    function getTimeElapsed($date) { //Creado [Suemy][2024-03-08]
        $time = "";
        if (!empty($date)) {
            $dateA = date('Y-m-d H:i:s',strtotime($date));
            $hoursD = (strtotime(date('Y-m-d H:i:s')) - strtotime($dateA)) / 3600; //36400
            $seconds = (strtotime(date('Y-m-d H:i:s')) - strtotime($dateA));
            /*$hoursD = (strtotime(date('2025-03-05 14:27:08')) - strtotime($dateA)) / 3600; //36400
            $seconds = (strtotime(date('2025-03-05 14:27:08')) - strtotime($dateA));*/
            //echo "<script> console.log('Hoy: ".date('Y-m-d H:i:s').", ".$dateA.", Horas Totales: ".$hoursD.", Segundos Totales: ".$seconds."'); </script>";
            //$data['1'] = ("dateA: ".$dateA.", hoursD: ".$hoursD.", seconds: ".$seconds);

            //Obtener Días y Años
            $days = number_format(($hoursD / 24),2);
            $days = explode('.',$days);
            $year = str_replace(",","",$days[0]);
            $year = number_format(($year / 365),4);
            $year = explode('.', $year);
            if ($year[0] > 0) {
                $time .= $year[0].' año';
                $time .= $this->addLetter($year[0]);
                $time .= ', ';
            }
            if ($days[0] > 0) {
                $dd = ($year[1] * 365) / 10000;
                $time .= round($dd).' día';
                $time .= $this->addLetter($days[0]);
                $time .= ' con ';
            }
            //$data['2'] = ("days[0]: ".$days[0].", days[1]: ".$days[1].", year[0]: ".$year[0].", year[1]: ".$year[1]);

            //Obtener Horas
            $hours = ($days[1] * 24) / 100;
            $hours = explode('.', $hours);
            if ($hours[0] > 0) {
                $time .= $hours[0]. ' hora';
                $time .= $this->addLetter($hours[0]);
                $time .= ' y ';
                /*echo "
                    <script>
                        console.log('Porcentaje Hora Trancurrida : ".$days[1].", Horas Trancurridas: ".$hours[0]."');
                        console.log(".$seconds.");
                    </script>
                ";*/
            }
            //$data['3'] = "hours[0]: ".$hours[0].", hours[1]: ".$hours[1];

            //Obtener Minutos
            $hour = number_format($hoursD,2);
            $hour = explode('.',$hour);
            $minutes = (60 * $hour[1]) / 100;
            $second = $minutes;
            $minutes = number_format($minutes,0);
            //$time .= $hour[0].' hora';
            //if ($hour[0] == 0 || $hour[0] > 1) { $time .= "s"; }
            $time .= $minutes.' minuto';
            $time .= $this->addLetter($minutes);
            if ($year[0] == 0 && $days[0] == 0 && $hours[0] == 0 && $second == 0) {
                /*$second = number_format($second,2);
                $second = explode('.', $second);
                $second = ($second[1] * 60) / 100;
                $second = round($second);
                $time .= ' con '.$second.' segundos';*/
                $time = "Hace unos momentos";
            }
            //$data['4'] = ("hour[0]: ".$hour[0].", hour[1]: ".$hour[1].", minutes: ".$minutes.", second: ".$second);

            //$data = ("Hoy: ".date('Y-m-d H:i:s').", ".$dateA.", Horas Totales: ".$seconds.", Segundos Totales: ".$hoursD.", Porcentaje Días Transcurridos: ".$year[1].", Porcentaje Hora Trancurrida : ".$days[1].", Horas Trancurridas: ".$hours[0].", Segundos Actuales: ".$second." | ");
        }
        return $time;
    }

    function addLetter($text) { //Creado [Suemy][2024-03-08]
        $data = "";
        if ($text == 0 || $text > 1 || $text > "1") { $data .= 's'; }
        return $data;
    }

    function getMonthOrDay($value,$type) {
        $month = array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $day = array ("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");

        if ($type == 1) { $data = $month[$value]; }
        else if ($type == 2) { $data = $day[$value]; }

        return $data;
    }

    //Funciones extras: Convierte a formato monetario
  	function formatMoney($num){
  	  	return '$ '.number_format((Double)$num, 2, '.', ',');
  	}
}