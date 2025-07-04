 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class fastFile extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('PersonaModelo');
        $this->load->model("capitalhumano_model", "capitalhumano");
        $this->load->model("incidenciasmodel", "incidencias");
        $this->load->model("documentsmodel", "documentos");
        $this->load->model("manejodocumento_modelo", "directorio");
        $this->load->model("PermisoOperativo");
        $this->load->model("superestrella_model"); //Agregado [Suemy][2024-07-09]
        $this->load->library("libreriav3");
        $this->load->library("webservice_sicas_soap");
        
     }

     
    // <---ingeniero Roberto Alvarez 04-marzo-2025----***4476307>
    // Nueva función para acceder desde el navegador
    public function obtenerCliente($nombreCliente = "") {
      
        if (empty($nombreCliente)) {
            echo json_encode(["error" => "Debe proporcionar un nombre de cliente"]);
            return;
     }

        // Crear el array de búsqueda 
        $data_search = [
            'busquedaCliente' => urldecode($nombreCliente),
            'page' => 0
        ];

        // Llamar al servicio SOAP
        $data_result = $this->webservice_sicas_soap->GetDataClienteProspecto($data_search);

        // Mostrar la respuesta en formato JSON
        //header('Content-Type: application/json');
        echo json_encode($data_result);
        // link de ejemplo para obtener los datos
        //http://localhost/Capsys/www/V3/fastFile/obtenerCliente/carlos
    }
    //<---999 ingeniero Roberto Alvarez 04-03-2025---->






    //***Funcion Determinar Dias Feriados por Mes***
    function diasferiadosMex($mes){
        $year=date('Y');
         switch ($mes) {
            case 1:return [$year."-01-01"];break;
            case 2:return [$year."-02-07"];break;
            case 3:return [$year."-03-21"];break;
            case 4:return [$year."-04-15"];break;
            case 5:return [$year."-05-01"];break;
            case 9:return [$year."-09-16"];break;
            case 11:return [$year."-11-21"];break;
            case 12:return [$year."-12-25"];break;
            default:return [$year.""];break;
        } 
    }

    //***Funcion Determinar de Dias Habiles***
    function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
            $fechainicio = strtotime($fechainicio);
            $fechafin = strtotime($fechafin);
            $diainc = 24*60*60;
            $diashabiles = array();
           for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                if (!in_array(date('N', $midia), array(6,7))) { 
                    if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                        array_push($diashabiles, date('Y-m-d', $midia));
                    }
                }
            }
        return $diashabiles;
    }

    //Funcion para determinar fecha de retorno de vacaciones considerando dias habiles y feriados
    function getFechaRetorno($dias,$fechaInicio){
        
        //$dias_ = (Int)$dias + 1;
        $diasVacaciones="+ ".$dias." days";

        $fechaRetorno=date("d-m-Y",strtotime($fechaInicio.$diasVacaciones));
        $diasHabiles=count($this->getDiasHabiles($fechaInicio,$fechaRetorno,$this->diasferiadosMex(date('m'))));
        
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r(array($fechaInicio, $fechaRetorno, $diasHabiles), TRUE));fclose($fp);
        $totalDias=$dias+($dias-$diasHabiles); // 1+(-1) = 1 - 1 = 0
        $diasVacaciones="+ ".($totalDias)." days";
        $fechaRetorno=date("d-m-Y",strtotime($fechaInicio.$diasVacaciones));
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r(array($dias,$diasHabiles, $totalDias), TRUE));fclose($fp);
        return $fechaRetorno;
    } 

    //--------------------------------
    //Dennis [2021-09-08]
    //Función mejorada para el regreso de vacaciones.
    function getDateReturn($days,$initialDate){

        $dayWithReturn = $days + 1;
        $finalDate = date("Y-m-d", strtotime($initialDate."+ ".$days." days")); //Viernes 17 (día de descanso)
        $initialDate_ = strtotime($initialDate);
        $endDate = strtotime($finalDate);
        $addDays = 0;
        $addDays_ = 0;
        $hollyDay = 0;
        $weekend = 0;
        $dateArray = array();

        for($i = $initialDate_; $i <= $endDate; $i += 86400){

            $validateDate = $this->validateHolidayDate(date("Y-m-d", $i));
            $numberDay_ = date("N", $i);

            if($validateDate){
                $hollyDay++;
            }

            if(in_array($numberDay_, array(6, 7))){
                $weekend++;
            }

            if($i != $endDate){
                array_push($dateArray, date("Y-m-d", $i));
            }
        }
        
        $daysFromWeekend = $weekend > 0 ? 2 : 0;
        $addDays = $daysFromWeekend + $hollyDay;
        $finalDate_ =  date("Y-m-d", strtotime(end($dateArray)."+ ".($addDays + 1)." days"));
        $numberDay = date("N", strtotime($finalDate_));
        $addDays_ = $this->returnMoreDays($numberDay);
        $newReturnDate = date("d-m-Y", strtotime($finalDate_."+ ".$addDays_." days"));

        return $newReturnDate;
        /*$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r(array(
            "count" => $addDays, 
            "dates" => $dateArray,
            "hollydays" => $hollyDay,
            "weekend" => $weekend,
            "final" => $finalDate_, 
            "trueFinalDate" => $newReturnDate,
            //"returnWeekend" => $addDays_
        ), TRUE));fclose($fp);*/
    }
    //-------------------------------------------
    //Dennis [2021-09-08]
    function validateHolidayDate($date){

        $year = date("Y");
        $noBusinessDate = array($year."-01-01", $year."-02-01", $year."-03-15", $year."-05-01", $year."-09-16", $year."-11-15", $year."-12-25");

        return in_array($date, $noBusinessDate);
    }
    //------------------------------------------
    //Dennis [2021-09-08]
    function returnMoreDays($day){

        switch($day){
            case 6: return 2;
            break;
            case 7: return 2;
            break;
            default: return 0;
        }
    }
    //-----------------------------------
     function setAprobar(){
        $id=$_REQUEST['id'];
        $tabla=$_REQUEST['tabla'];
        $sql="UPDATE ".$tabla." set aprobado=0 WHERE id='$id'";
        $this->db->query($sql);
        if(($tabla=='prestamos') || ($tabla=='ahorros')){
            $this->setNotifications(4,$id);
            $this->prestamosReload();
        }
        if($tabla=='vacaciones'){
            $this->envioCorreoDirectivos($id);
            $this->setNotifications(1,$id);
            $this->vacaciones();
        }
     }

      function setNegar(){
        $id=$_REQUEST['id'];
        $tabla=$_REQUEST['tabla'];
        $sql="UPDATE ".$tabla." set aprobado=-1 WHERE id='$id'";
        $this->db->query($sql);
        if( ($tabla=='prestamos') || ($tabla=='ahorros')){
            $this->prestamosReload();
        }
        if($tabla=='vacaciones'){
            $this->setNotifications(2,$id);
            $this->vacaciones();
        }
     }

     function setNotifications($op,$id){
        $sw=0;
        $idPersona='';
        $sql="SELECT * FROM vacaciones WHERE id='$id'";
        $rs=$this->db->query($sql)->result();
        if($rs){
            $idPersona=$rs[0]->idPersona;
        }
        
        $sql="SELECT (SELECT P.idPersona    FROM personapuesto as P WHERE PR.padrePuesto=P.idPuesto) as idPadre from personapuesto AS PR where PR.idPersona='$idPersona'";
        $rs=$this->db->query($sql)->result();
        
        $emailPadre='';
        if($rs){
            $idPadre=$rs[0]->idPadre;
            $rsPadre=$this->PersonaModelo->obtenerDatosUsuarios($idPadre,'email');
            if($rsPadre){
                $emailPadre=$rsPadre->email;
            }
        }


        $rsPersona=$this->PersonaModelo->obtenerDatosUsuarios($idPersona,'*');
       
        $email=$rsPersona->email;
        $name_complete=$rsPersona->name_complete;
        $tipo_id="email";
        $tipo="OTRO";
        $referencia="VACACIONES";
        $referencia_id=10;
        $controlador="miInfo#vacaciones";
        if($op==1){
         $comentarioAdicional="La solicitud de sus vacaciones ha sido aprobada";
         $sql="INSERT INTO notificacion(persona_id,email,tipo_id,tipo,referencia,referencia_id,comentarioAdicional,controlador)values('$idPersona','$email','$tipo_id','$tipo','$referencia','$referencia_id','$comentarioAdicional','$controlador')";
         $sw=1;
        }
        if($op==2){
         $comentarioAdicional="La solicitud de sus vacaciones ha sido negada";
         $sql="INSERT INTO notificacion(persona_id,email,tipo_id,tipo,referencia,referencia_id,comentarioAdicional,controlador)values('$idPersona','$email','$tipo_id','$tipo','$referencia','$referencia_id','$comentarioAdicional','$controlador')";
        }
        if($op==3){
         $controlador="fastFile/vacaciones";
         $comentarioAdicional="Usted tiene una solicitud de vacaciones pendiente por confirmar de: ".$name_complete;
          $sql="INSERT INTO notificacion(persona_id,email,tipo_id,tipo,referencia,referencia_id,comentarioAdicional,controlador)values('$idPadre','$emailPadre','$tipo_id','$tipo','$referencia','$referencia_id','$comentarioAdicional','$controlador')";
        }

        if($op==4){
            $referencia="PRESTAMOS";
            $controlador="fastFile/prestamos";
            $idPersona=219;
            $comentarioAdicional="Recientemente se aprobo un prestamo a: ".$name_complete;
            $sql="INSERT INTO notificacion(persona_id,email,tipo_id,tipo,referencia,referencia_id,comentarioAdicional,controlador)values('$idPersona','$emailPadre','$tipo_id','$tipo','$referencia','$referencia_id','$comentarioAdicional','$controlador')";
        }
         $this->db->query($sql);
       
       
        if($sw==1){
             //Notificacion para Contador
             $comentarioAdicionalCont="Se han aprobado las vacaciones de un colaborador, recientemente";
             $idPersona=219;
             $sql="INSERT INTO notificacion(persona_id,email,tipo_id,tipo,referencia,referencia_id,comentarioAdicional,controlador)values('$idPersona','$email','$tipo_id','$tipo','$referencia','$referencia_id','$comentarioAdicionalCont','$controlador')";
             //Fin de notificacion contador
              $this->db->query($sql);
        }

     }
     
//-------------------- //Dennis Castillo [2022-06-28]
function vacaciones($person = null){

    $condition = !empty($person) ? array("a.idPersona" => $person) : array();

    $getPersons = $this->capitalhumano->getWhoRequestedVacations($condition);
    $dataRequester = array();
    $vacationPermission = array_filter($this->PersonaModelo->getMyPermissions($this->tank_auth->get_idPersona()), function($arr){
        return $arr->idLlavePermiso == "listaVacaciones";
    });

    //var_dump($vacationPermission);

    foreach($getPersons as $dp){

        $getYear = $this->PersonaModelo->getWorkStartPeriod($dp->idPersona);

        $dataRequester[$dp->idPersona]["requester"] = $dp->nombre;
        $dataRequester[$dp->idPersona]["period"] = $getYear->anio;
        $dataRequester[$dp->idPersona]["person"] = $dp->idPersona;
        $dataRequester[$dp->idPersona]["area"] = $dp->colaboradorArea;
        $dataRequester[$dp->idPersona]["job"] = $dp->personaPuesto;
        $dataRequester[$dp->idPersona]["initialJobDate"] = date("Y/m/d", strtotime($dp->fecAltaSistemPersona)); //Original "d/m/Y"
        $dataRequester[$dp->idPersona]["request"][] = array("status" => $dp->aprobado);
        $dataRequester[$dp->idPersona]["vacacionessolicitadas"]=$this->getDiasVacacionesSolicitadas($dp->idPersona);
        
        /*$dataRequester[] = array(
            "requester" => $dp->nombre,
            "person" => $dp->idPersona,
            "area" => $dp->colaboradorArea,
            "job" => $dp->personaPuesto,
            "initialJobDate" => date("d/m/Y", strtotime($dp->fecAltaSistemPersona)),
            "period" => $getYear->anio,
        );*/
    }

    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($getPersons, TRUE));fclose($fp);
    $data["requesters"] = $dataRequester;
    $data["allRequest"] = $getPersons;
    $data["downloadList"] = !empty($vacationPermission);
    $data['nuevasVacaciones']=$this->db->query('SELECT * FROM tabla_vacaciones_nueva')->result();
    $data["vacacionessolicitadas"]=$this->getDiasVacacionesSolicitadas($this->tank_auth->get_idPersona());
    $data["reporteAniversario"]= $this->PersonaModelo->getReporteAniversario($this->tank_auth->get_username());
    $data["reporteSolicitadas"]=$this->PersonaModelo->getReporteSolicitados($this->tank_auth->get_username());
    $this->load->view('persona/vacaciones', $data);
}
//--------------------
    function getDiasVacacionesSolicitadas($idPersona){
      //determinar los dias solicitados en por año por Usuario
        $period = $this->PersonaModelo->getWorkStartPeriod($idPersona);
        $vacacionxanio = [];
      $i=1;
      if(isset($period->anio)){
        $cont=intval($period->anio);
        while($cont>0){
             $sqlX="SELECT SUM(cantidad_dias) as dias FROM vacaciones WHERE  antiguedad = ".$cont." AND estado='aprobado' and idPersona = $idPersona"; //aprobado<>-1
             $dias= $this->db->query($sqlX)->result()[0];
             $vacacionxanio["anio".$i."v"]=$dias->dias;
             $cont--;
             $i++;
        }
      }
      
       
        return $vacacionxanio;
    }
//-------------------- //Edwin Marin [2025-04-23]
function busquedaVacaciones(){
    $tipo=$_POST['tipo'];
    $idColaborador=$_POST['colaborador'];
    $fecha=$_POST['fecha'];
    $data=[];
    switch ($tipo){
        case 1: //busqueda por colaborador
            $data["reporteAniversario"]= $this->PersonaModelo->searchReporteAniversario($tipo, $this->tank_auth->get_username(), $idColaborador);
            $data["reporteSolicitadas"]=$this->PersonaModelo->searchReporteSolicitados($tipo, $idColaborador);
            break;
        case 2: //busqueda por fecha
            $data["reporteAniversario"]= $this->PersonaModelo->searchReporteAniversario($tipo, $this->tank_auth->get_username(), $fecha);
            $data["reporteSolicitadas"]=$this->PersonaModelo->searchReporteSolicitados($tipo, $fecha);
            break;
        case 3: //busqueda por ambos
            $data["reporteAniversario"]= $this->PersonaModelo->searchReporteAniversario($tipo, $this->tank_auth->get_username(), $idColaborador, $fecha);
            $data["reporteSolicitadas"]=$this->PersonaModelo->searchReporteSolicitados($tipo, $idColaborador, $fecha);
            break;
        }
        echo json_encode($data);
}
function vacaciones_(){ //Obsoleto Dennis Castillo [2022-06-26]

    if(isset($_REQUEST['id'])){
        $id=$_REQUEST['id'];
        $sqlHijos="SELECT * from vacaciones WHERE  YEAR(fecha) >= 2022 AND idPersona='$id' ORDER BY fecha DESC";
    }else{
        $sqlHijos="SELECT * from vacaciones WHERE YEAR(fecha) >= 2022 ORDER BY fecha DESC"; 
    }
    $permiso= $this->PersonaModelo->permisosPersona('VerTodosLosPuestos');
    if(isset($permiso['value'])){
        $this->datos['puestos'] = $this->capitalhumano->devolverPuestos(1);
    }else {
        $this->datos['puestos'] = $this->capitalhumano->devolverPuestos(null);
    }
    $idPersona=$this->tank_auth->get_idPersona();
    $email=$this->tank_auth->get_usermail();
    $this->datos['vacaciones']=$this->db->query($sqlHijos)->result();
    //llenar select con suboordinados de coordinadores
    $email=$this->tank_auth->get_usermail();
    $this->datos['personal']=$this->PersonaModelo->devuelveHijos($email);
    //Correo de Director, coordinador y gerentes
    $this->datos['correosCoordinadores']=array('GERENTEOPERATIVO@AGENTECAPITAL.COM','DIRECTORCOMERCIAL@AGENTECAPITAL.COM','AUDITORINTERNO@AGENTECAPITAL.COM','CAPITALHUMANO@AGENTECAPITAL.COM','GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX','DIRECTORGENERAL@AGENTECAPITAL.COM','MARKETING@AGENTECAPITAL.COM','COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM','COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX','COORDINADOR@CAPCAPITAL.COM.MX','COORDINADORCOMERCIAL@FIANZASCAPITAL.COM','COORDINADORCARIBE@AGENTECAPITAL.COM','COORDINADOROPERATIVO@ASESORESCAPITAL.COM','CAPITALHUMANO@AGENTECAPITAL.COM','COORDINADOR@FIANZASCAPITAL.COM');
    $this->load->view('persona/vacaciones',$this->datos);
}


     

    //*************************

     function prestamos(){
        $idPersona=$this->tank_auth->get_idPersona();
        $email=$this->tank_auth->get_usermail();       

        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($per, TRUE));fclose($fp);
        if(isset($_REQUEST['id']))
        {
            $id=$_REQUEST['id'];
            $sqlHijos="SELECT * FROM prestamos WHERE idPersona='$id' ORDER BY fecha DESC"; 
            $this->datos['prestamos']=$this->db->query($sqlHijos)->result();
            $sqlHijos="SELECT * FROM ahorros WHERE idPersona='$id' ORDER BY fecha DESC"; 
            $this->datos['ahorros']=$this->db->query($sqlHijos)->result();
        }
        else
        {
            $per=$this->PersonaModelo->obtenerPermisosPersona($idPersona,52);
            if(count($per)==0)
            {
             $sqlHijos="SELECT * FROM prestamos ORDER BY id DESC";
             $this->datos['prestamos']=$this->db->query($sqlHijos)->result();
            $sqlHijos="SELECT * FROM ahorros WHERE idPersona='$idPersona' ORDER BY fecha DESC"; 
            $this->datos['ahorros']=$this->db->query($sqlHijos)->result();
            }
            else
            {
            $sqlHijos="SELECT * FROM prestamos ORDER BY id DESC";
            $this->datos['prestamos']=$this->db->query($sqlHijos)->result();
            $sqlHijos="SELECT * FROM ahorros ORDER BY id DESC";
            $this->datos['ahorros']=$this->db->query($sqlHijos)->result();
        }
        }
        

        $permiso= $this->PersonaModelo->permisosPersona('VerTodosLosPuestos');
        if(isset($permiso['value'])){
            
            $this->datos['puestos'] = $this->capitalhumano->devolverPuestos(1);
        }else {
            $this->datos['puestos'] = $this->capitalhumano->devolverPuestos(null);
        }
        //llenar select con suboordinados de coordinadores

        $this->datos['personal']=$this->PersonaModelo->devuelveHijos($email);
        //Correo de Director, coordinador y gerentes
        $this->datos['correosCoordinadores']=array('GERENTEOPERATIVO@AGENTECAPITAL.COM','DIRECTORCOMERCIAL@AGENTECAPITAL.COM','AUDITORINTERNO@AGENTECAPITAL.COM','CAPITALHUMANO@AGENTECAPITAL.COM','GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX','DIRECTORGENERAL@AGENTECAPITAL.COM','MARKETING@AGENTECAPITAL.COM','COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM','COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX','COORDINADOR@CAPCAPITAL.COM.MX','COORDINADORCOMERCIAL@FIANZASCAPITAL.COM','COORDINADORCARIBE@AGENTECAPITAL.COM','COORDINADOROPERATIVO@ASESORESCAPITAL.COM','CAPITALHUMANO@AGENTECAPITAL.COM','COORDINADOR@FIANZASCAPITAL.COM');

        $this->load->view('persona/prestamos',$this->datos);

     }
    

     function prestamosReload(){

         $this->load->model('PersonaModelo');
        $this->load->model('capitalhumano_model');
      
        $sqlHijos="SELECT * FROM prestamos ORDER BY id DESC";
        $this->datos['prestamos']=$this->db->query($sqlHijos)->result();
        $sqlHijos="SELECT * FROM ahorros ORDER BY id DESC";
        $this->datos['ahorros']=$this->db->query($sqlHijos)->result();
        
        

        $permiso= $this->PersonaModelo->permisosPersona('VerTodosLosPuestos');
        if(isset($permiso['value'])){
            $this->datos['puestos'] = $this->capitalhumano_model->devolverPuestos(1);
        }else {
            $this->datos['puestos'] = $this->capitalhumano_model->devolverPuestos(null);
        }
        $idPersona=$this->tank_auth->get_idPersona();
        $email=$this->tank_auth->get_usermail();
        //llenar select con suboordinados de coordinadores
        $email=$this->tank_auth->get_usermail();
        $this->datos['personal']=$this->PersonaModelo->devuelveHijos($email);
        //Correo de Director, coordinador y gerentes
        $this->datos['correosCoordinadores']=array('GERENTEOPERATIVO@AGENTECAPITAL.COM','DIRECTORCOMERCIAL@AGENTECAPITAL.COM','AUDITORINTERNO@AGENTECAPITAL.COM','CAPITALHUMANO@AGENTECAPITAL.COM','GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX','DIRECTORGENERAL@AGENTECAPITAL.COM','MARKETING@AGENTECAPITAL.COM','COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM','COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX','COORDINADOR@CAPCAPITAL.COM.MX','COORDINADORCOMERCIAL@FIANZASCAPITAL.COM','COORDINADORCARIBE@AGENTECAPITAL.COM','COORDINADOROPERATIVO@ASESORESCAPITAL.COM','CAPITALHUMANO@AGENTECAPITAL.COM','COORDINADOR@FIANZASCAPITAL.COM');

        $this->load->view('persona/prestamos',$this->datos);

     }

     function guardar_solicitud_vacaciones(){
        $idPersona=$_REQUEST['idPersona'];
        $fecha_salida=$_REQUEST['fecha_salida'];
        $cantidad_dias =$_REQUEST['cantidad_dias'];
        $fecha_retorno=$this->getDateReturn($cantidad_dias,$fecha_salida); //Dennis [2021-09-08]  //getFechaRetorno($cantidad_dias,$fecha_salida); //Comentado por Dennis [2021-09-08]
        $antiguedad=$_REQUEST['antiguedad'];
        $rsPersona=$this->PersonaModelo->devuelveInfoUser($idPersona);
        $rsCargo=$this->PersonaModelo->puestoDePersona($idPersona);
        $nombre=$rsPersona[0]->name_complete;
        if($rsCargo){
            $puesto=$rsCargo[0]->personapuesto;
        }
        $sql="INSERT INTO vacaciones(idPersona,nombre,puesto,antiguedad,fecha_salida,fecha_retorno,cantidad_dias) values('$idPersona','$nombre','$puesto','$antiguedad','$fecha_salida','$fecha_retorno','$cantidad_dias')";
        $this->db->query($sql);
        $sqlX="SELECT id from vacaciones ORDER BY id DESC";
        $rsX=$this->db->query($sqlX)->result();
        
        if(!empty($rsX)){ //!empty por Dennis Castillo [2022-03-27]

            $directoy = array("root1" => "VACACIONES","root2" => "REF_".$rsX[0]->id);
            $this->uploadFileToServer($directoy, $_FILES, $rsX[0]->id);
            $this->setNotifications(3,$rsX[0]->id);
        }

        redirect('/miInfo/index/');
     }

     function guardar_solicitud_prestamo(){
        $monto=$_REQUEST['monto'];
        $idPersona=$_REQUEST['idPersona'];
        $rsPersona=$this->PersonaModelo->devuelveInfoUser($idPersona);
        $rsCargo=$this->PersonaModelo->puestoDePersona($idPersona);
        $nombre=$rsPersona[0]->name_complete;
        $puesto=$rsCargo[0]->personapuesto;
        $sql="INSERT INTO prestamos(idPersona,nombre,puesto,monto) values('$idPersona','$nombre','$puesto','$monto')";
        $this->db->query($sql);
        redirect('/miInfo/index/');
     }

     function guardar_solicitud_ahorro(){
        $monto=$_REQUEST['montoAhorro'];
        $idPersona=$_REQUEST['idPersona'];
        $rsPersona=$this->PersonaModelo->devuelveInfoUser($idPersona);
        $rsCargo=$this->PersonaModelo->puestoDePersona($idPersona);
        $nombre=$rsPersona[0]->name_complete;
        $puesto=$rsCargo[0]->personapuesto;
        $sql="INSERT INTO ahorros(idPersona,nombre,puesto,monto) values('$idPersona','$nombre','$puesto','$monto')";
        $this->db->query($sql);
        redirect('/miInfo/index/');
     }
     
     function inasistencias(){
        $hoy=date('Y-m-d H:m:s');
        $sql="SELECT * from users WHERE DAY(last_login)<>DAY('$hoy') AND  MONTH(last_login)<>MONTH('$hoy') AND  YEAR(last_login)<>YEAR('$hoy')";
        $rs=$this->db->query($sql)->result();
        foreach ($rs as $row) {
            $idPersona=$row->idPersona;
            //Determinar Cargo actual******
            $puestoActual='';
            $rs=$this->PersonaModelo->puestoDePersona($idPersona);
            if($rs){
                $puestoActual=$rs[0]->personaPuesto;
            }
            $sql="INSERT INTO fastfile(idPersona,fecha,puntualidad,puestoActual)values('$idPersona',NOW(),'8','$puestoActual')";
            $this->db->query($sql);
        }
     }
     
    function hora($fecha){
        $fecha=explode(' ', $fecha);
        $fecha=explode(':',$fecha[1]);
        return $fecha[0];
    }

    

    function cambioPuesto($idPersona,$year,$puestoActual){
        $this->cambioPuesto=array();
        $sql="SELECT * FROM fastfile WHERE idPersona='$idPersona' AND YEAR(fecha)='$year'";
        $rs=$this->db->query($sql)->result();
        if($rs){
            $fecha=explode(' ',$rs[0]->fecha);
            $fecha=explode('-',$fecha[0]);
            $dia=$fecha[2];
            $mes=$fecha[1];
            if($rs[0]->puestoAnterior!=''){
                $this->cambioPuesto[0]=$rs[0]->puestoAnterior;
                $this->cambioPuesto[1]=(int)$dia;
                $this->cambioPuesto[2]=(int)$mes;
                $this->cambioPuesto[3]=$puestoActual;
            }else{
                $this->cambioPuesto[0]="";
                $this->cambioPuesto[1]=(int)$dia;
                $this->cambioPuesto[2]=(int)$mes;
                $this->cambioPuesto[3]="";
            }
        }
        return $this->cambioPuesto; 

    }

    function getVacaciones($idPersona,$year){
        $this->data=null;
        $sql="SELECT * FROM vacaciones WHERE idPersona='$idPersona' AND  YEAR(fecha)='$year' AND aprobado=0";
        $rs=$this->db->query($sql)->result();
        foreach($rs as $row){
            $fecha=explode(' ',$row->fecha);
            $fecha=explode('-',$fecha[0]);
            $mes=(int)$fecha[1];
            $dia=(int)$fecha[2];
            $this->data[$mes][$dia][0]=$row->fecha_salida;
            $this->data[$mes][$dia][1]=$row->fecha_retorno;
            $this->data[$mes][$dia][2]=$row->cantidad_dias;
        }
        return $this->data; 
    }

    function getFastFile($idPersona,$year,$dato){
        $this->data=null;
        $sql="SELECT * FROM fastfile WHERE idPersona='$idPersona'  AND YEAR(fecha)='$year'";
        $rs=$this->db->query($sql)->result();
        foreach($rs as $row){
            $fecha=explode(' ',$row->fecha);
            $fecha=explode('-',$fecha[0]);
            $mes=(int)$fecha[1];
            $dia=(int)$fecha[2];
            $this->data[$mes][$dia]=$row->$dato;
        }
        return $this->data; 
    }


    //Funcion para enviar la notificacion de vacaciones a todos los Gerentes
    function envioCorreoDirectivos($idVacaciones){
        $jefeDirecto='';
        $emailJefeDirecto='';
        $emailEmp='';
        $sql="SELECT * FROM vacaciones WHERE id='$idVacaciones'";
        $rs=$this->db->query($sql)->result();
        if($rs){
            $idPersona=$rs[0]->idPersona;
            $rsUser=$this->PersonaModelo->devuelveInfoUser($idPersona);
            if($rsUser){
                $emailEmp=$rsUser[0]->email;
            }
            $rsJefe=$this->PersonaModelo->obtenerJefe($idPersona);
            if($rsJefe){
                $jefeDirecto=$rsJefe->name_complete;
                $idPersonaJefeDirecto=$rsJefe->idPersona;
                $rsUserJefe=$this->PersonaModelo->devuelveInfoUser($idPersonaJefeDirecto);
                if($rsUserJefe){
                    $emailJefeDirecto=$rsUserJefe[0]->email;
                }
            }
            $nombreEmp=$rs[0]->nombre;
            $puestoEmp=$rs[0]->puesto;
            $fecha_salida=date("d-m-Y",strtotime($rs[0]->fecha_salida));
            $fecha_retorno=date("d-m-Y",strtotime($rs[0]->fecha_retorno));
            $mensaje='<DOCTYPE html><html><body><table width="75%" align="center" style="border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;font-family: arial;"><tr><td align="left" colspan="2"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" width="30%" style="margin-top: -8%;"></td></tr><tr><td>Saludos Cordiales estimados,<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Por este medio hago de su conocimiento que saldré de vacaciones en dia '.$fecha_salida.', retomando mis actividades el día '.$fecha_retorno.', el apoyo por favor para hacer extensivo este comunicado.Si se requiere algún tema a tratar durante mi ausencia se pueden comunicar con: Jefe directo: '.$jefeDirecto.': '.$emailJefeDirecto.'<br><br>Atentamente.<br><br>'.$puestoEmp.':'.$nombreEmp.': '.$emailEmp.'  Gracias por su atención !!</td></tr></table></body></html>';
             //Envio de correos
            $asunto="Notificación de Vacaciones - Capital Seguros y Fianzas";
            $desde="Avisos GAP<avisos@agentecapital.com>";
            $fechaEnvio=date('Y-m-d h:m:s');
            
            $rsCorreos=$this->PersonaModelo->devuelveCorreosSuperiores();
            foreach($rsCorreos as $rsCorreo){
                if(isset($rsCorreo->emailHijo)){
                    $para=trim($rsCorreo->emailHijo);
                    $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$para','$asunto','$fechaEnvio','$mensaje',0,'Vacaciones')";
                    $rs=$this->db->query($sql);
                }
            }
        }
    }


    function getAllVacaciones(){
      $sql="SELECT * FROM vacaciones WHERE aprobado=0 order by fecha DESC";
      $this->data['vacaciones']=$this->db->query($sql)->result();
      $this->load->view('persona/vacaciones_todos',$this->data);
    }

     function registrarSalida(){
    $mDate=new DateTime();
      $fecha1=$mDate->format('Y-m-d H:i:s');
      $insert['idPersona']=$_POST['idPersona'];
      $insert['fecha']=$fecha1;
      $insert['descripcion']='Salida';
      $insert['valor']=1;
      $insert['comentario']="v3";
      //Verifica si ya existe un registro de ese día
      $fechaConsulta=$mDate->format('Y-m-d');
      $fecha=$this->db->query('select (CURRENT_TIMESTAMP()) as fecha,(year(CURRENT_TIMESTAMP())) as anio,(month(CURRENT_TIMESTAMP())) as mes,
(day(CURRENT_TIMESTAMP())) as dia ,(hour(CURRENT_TIMESTAMP())) as hora , (minute(CURRENT_TIMESTAMP())) as minuto,(time(CURRENT_TIMESTAMP())) as horaCompleta,ELT(WEEKDAY(date(CURRENT_TIMESTAMP())) + 1, "entradaLunes", "entradaMartes", "entradaMiercoles", "entradaJueves", "entradaViernes", "entradaSabado", "entradaDomingo") AS diaSemana')->result()[0];
      $sql_encontrado='select id from fastfile where descripcion="Salida" and year(fecha)='.$fecha->anio.' and month(fecha)='.$fecha->mes.' and day(fecha)='.$fecha->dia.' and idPersona='.$_POST['idPersona'];
      //$sql_encontrado='select * from fastfile where fecha like "'.$fechaConsulta.' %" and descripcion="Salida"';
            $encontrado = $this->db->query($sql_encontrado)->result();

            if(count($encontrado)!=0){
                $response = array('success'=> false);
            echo json_encode($response);
            }else{
                $this->db->insert('fastfile',$insert);
               $response = array('success'=> true);
            echo json_encode($response);
                
            }
            
 }

    
    function actualizarCambioPuesto($idPersona,$puesto,$year){
        $sql="SELECT * FROM fastfile WHERE descripcion='cambio puesto' AND YEAR(fecha)='$year' AND idPersona='$idPersona'";
        $rs=$this->db->query($sql)->result();
        if(!$rs){
            $valor=$puesto;
            $fecha=date('Y-m-d h:m:i');
            $sqlInsert="INSERT INTO fastfile(idPersona,descripcion,fecha,valor)VALUES('$idPersona','cambio puesto','$fecha','$valor')";
                $this->db->query($sqlInsert);
        }else{
            $sql="SELECT * FROM fastfile WHERE valor<>'$puesto' AND descripcion='cambio puesto' AND idPersona='$idPersona'";
            $rs=$this->db->query($sql)->result();
            if($rs){
                $puestoAnterior=$rs[0]->valor;
                $upt="UPDATE fastfile set valor='$puesto', valor_ant='$puestoAnterior' WHERE idPersona='$idPersona' AND descripcion='cambio puesto'";
                $this->db->query($upt);
            }
        }
     }


     function verificarPrestamos($idPersona,$year){
        $sql="SELECT * FROM prestamos WHERE idPersona='$idPersona' AND aprobado=1 AND YEAR(fecha)='$year'";
        $rs=$this->db->query($sql)->result();
         foreach($rs as $r){
            $fecha=$r->fecha;
            $sql_encontrado="SELECT * from fastfile WHERE descripcion='prestamo' AND idPersona='$idPersona' AND referencia_id = ".$r->id."";
            $encontrado = $this->db->query($sql_encontrado)->result();
            if(!$encontrado){
                $valor=$r->monto;
                $sqlInsert="INSERT INTO fastfile(idPersona,descripcion,fecha,valor, referencia_id)VALUES('$idPersona','prestamo','$fecha','$valor', ".$r->id.")";
                $this->db->query($sqlInsert);
            }
        }
    }

     function verificarVacaciones($idPersona,$year){
        $sql="SELECT * FROM vacaciones WHERE idPersona='$idPersona' AND aprobado=0 AND YEAR(fecha)='$year'";
        $rs=$this->db->query($sql)->result();
        foreach($rs as $r){
            $fecha=$r->fecha_salida;
            $day=date('d',strtotime($r->fecha_salida));
            $month=date('m',strtotime($r->fecha_salida));
            $year=date('Y',strtotime($r->fecha_salida));
            $sql_encontrado="SELECT * from fastfile WHERE descripcion='vacacion' AND idPersona='$idPersona' AND referencia_id = ".$r->id."";
            $encontrado=$this->db->query($sql_encontrado)->result();
            if(!$encontrado){
                $fecha=$r->fecha_salida;
                $valor=$r->cantidad_dias;
                $sqlInsert="INSERT INTO fastfile(idPersona,descripcion,fecha,valor, referencia_id)VALUES('$idPersona','vacacion','$fecha','$valor', ".$r->id.")";
                $this->db->query($sqlInsert);
            }
        }
    }

    function verificarPermiso($idPersona,$year){
        $sql="SELECT * FROM incidencias WHERE empleado_id='$idPersona' AND estatus='AUTORIZADO' AND tipo_incidencias_id='10' AND YEAR(fecha_alta)='$year'";
        $rs=$this->db->query($sql)->result();
         foreach($rs as $r){
            //$fecha=$r->fecha_alta;
            $sql_encontrado="SELECT * from fastfile WHERE descripcion='permiso' AND idPersona='$idPersona' AND referencia_id = ".$r->idincidencias."";
            $encontrado=$this->db->query($sql_encontrado)->result();
            if(!$encontrado){
                $valor=$r->dias;
                $sqlInsert="INSERT INTO fastfile(idPersona,descripcion,fecha,valor, referencia_id, comentario, respuesta)VALUES('$idPersona','permiso','".$r->fecha_inicio."','$valor',".$r->idincidencias.", '".$r->comentario."', '".$r->comentario_rechazo."')";
                $this->db->query($sqlInsert);
            }
        }
    }

     function verificarIncapacidad($idPersona,$year){
        $sql="SELECT * FROM incidencias WHERE empleado_id='$idPersona' AND estatus='AUTORIZADO' AND tipo_incidencias_id='9' AND YEAR(fecha_alta)='$year'";
        $rs=$this->db->query($sql)->result();
         foreach($rs as $r){
            //$fecha=$r->fecha_alta;
            $sql_encontrado="SELECT * from fastfile WHERE descripcion='incapacidad' AND idPersona='$idPersona' AND referencia_id = ".$r->idincidencias."";
            $encontrado=$this->db->query($sql_encontrado)->result();
            if(!$encontrado){
                $valor=$r->dias;
                $sqlInsert="INSERT INTO fastfile(idPersona,descripcion,fecha,valor, referencia_id, comentario, respuesta)VALUES('$idPersona','incapacidad','".$r->fecha_inicio."','$valor',".$r->idincidencias.", '".$r->comentario."', '".$r->comentario_rechazo."')";
                $this->db->query($sqlInsert);
            }
        }
    }


    function verificarCapacitaciones($idPersona,$year){
        $this->load->model('personamodelo');
        $rs=$this->personamodelo->resumenGeneral();
        $sql_encontrado="SELECT * from fastfile WHERE descripcion='capacitacion' AND idPersona='$idPersona' AND YEAR(fecha)='$year'";
        $encontrado=$this->db->query($sql_encontrado)->result();
        if(!$encontrado){
            foreach ($rs as $row){
                if($row->idPersona==$idPersona){
                    $fecha=$row->anio."-".$row->mes."-15";
                    $valor=($row->certificacion+$row->certificacionAutos+$row->certificacionGmm+$row->certificacionVida+$row->certificacionDanos+$row->certificacionFianzas);
                    $valor_ant="<table><tr><td>Profesional</td><td>Autos</td><td>GMM</td><td>Vida</td><td>Daños</td><td>Fianzas</td><tr>";
                    $valor_ant.="<tr><td>".$row->certificacion."</td>";
                    $valor_ant.="<td>".$row->certificacionAutos."</td>";
                    $valor_ant.="<td>".$row->certificacionGmm."</td>";
                    $valor_ant.="<td>".$row->certificacionVida."</td>";
                    $valor_ant.="<td>".$row->certificacionDanos."</td>";
                    $valor_ant.="<td>".$row->certificacionFianzas."</td></tr></table>";
                    $sqlInsert="INSERT INTO fastfile(idPersona,descripcion,fecha,valor,valor_ant)VALUES('$idPersona','capacitacion','$fecha','$valor','$valor_ant')";
                    $this->db->query($sqlInsert);
                }
            }
        }
    }


   function verificarCalificaciones($idPersona,$year){
        $sql_encontrado="SELECT * from fastfile WHERE descripcion='calificacion' AND idPersona=".$idPersona." AND YEAR(fecha)=".$year."";
        $encontrado=$this->db->query($sql_encontrado)->result();
        if(empty($encontrado)){
            //$sql="SELECT E.fecha_aplicacion,E.calificacion, (SELECT EP.titulo FROM evaluacion_periodos AS EP WHERE EP.id=E.evaluacion_id ) AS titulo FROM evaluacion_periodo_empleado AS E WHERE E.empleado_id='$idPersona' AND YEAR(E.fecha_aplicacion) = ".$year."";
            $sql = "SELECT * FROM evaluacion_periodo_empleado a INNER JOIN (SELECT * FROM evaluacion_periodos) AS b ON a.evaluacion_id = b.id WHERE YEAR(fecha_aplicacion) = ".$year." AND a.empleado_id = ".$idPersona."";
            $rs=$this->db->query($sql)->result();
            foreach($rs as $row){
                $fecha=$row->fecha_aplicacion;
                $valor=$row->calificacion;
                $valor_ant=$row->titulo;
                $sqlInsert="INSERT INTO fastfile(idPersona,descripcion,fecha,valor,valor_ant)VALUES('$idPersona','calificacion','$fecha','$valor','$valor_ant')";
                $this->db->query($sqlInsert);
            }
        }
    }

    function verificarSueldos($idPersona,$year){
        $sql="SELECT * FROM solicitud_sueldo WHERE empleado_id='$idPersona' AND estatus='AUTORIZADO' AND YEAR(fecha)='$year'";
        $rs=$this->db->query($sql)->result();
        if($rs){
            $fecha=$rs[0]->fecha;
            $sql_encontrado="SELECT * from fastfile WHERE descripcion='sueldo' AND idPersona='$idPersona' AND referencia_id = ".$rs[0]->id."";
            $encontrado=$this->db->query($sql_encontrado)->result();
            if(!$encontrado){
                $valor=$rs[0]->importe;
                $valor_ant=$rs[0]->importe_final;
                $sqlInsert="INSERT INTO fastfile(idPersona,descripcion,fecha,valor,valor_ant, referencia_id)VALUES('$idPersona','sueldo','$fecha','$valor','$valor_ant', ".$rs[0]->id.")";
                $this->db->query($sqlInsert);
            }
        }
    }


    
    
    function getByMonth(){  //Modificado [Suemy][2024-07-24]
        $render='';
        $descripcion=$_REQUEST['descripcion'];
        $idPersona=$_REQUEST['idPersona'];
        $anio=$_REQUEST['anio'];
        $mes=$_REQUEST['mes'];
        $sql="SELECT * from fastfile WHERE idPersona='$idPersona' AND month(fecha)='$mes' AND year(fecha) = ".$anio." AND descripcion='$descripcion' ORDER BY fecha DESC";
        $rs=$this->db->query($sql)->result();
         $sqlcalificacion="select e.descripcion, p.calificacion, p.fecha_aplicacion as fecha FROM  fastfile f left join evaluacion_periodo_empleado p on f.idPersona=p.empleado_id left join evaluaciones e on p.evaluacion_id=e.id where f.idPersona='$idPersona' and f.descripcion='$descripcion' and p.fecha_aplicacion IS NOT NULL and month(p.fecha_aplicacion)='$mes' AND year(p.fecha_aplicacion) = ".$anio." GROUP by p.fecha_aplicacion ORDER BY p.fecha_aplicacion DESC";
         $cal=$this->db->query($sqlcalificacion)->result();

        $labelMessage = empty($rs) ? "<div class='col-md-12'><p class='text-danger'>No se encontraron resultados</p></div>" : "";
        if($descripcion=='puntualidad'){
        $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;border: 1px'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='4'><i class='fa fa-clock-o'></i> PUNTUALIDAD</th></tr><tr style='background: #396da1;'><th>FECHA</th><th>HORA</th><th>PUNTOS</th></tr></thead><tbody>"; 
            $ct=0;
            foreach ($rs as $row) {
                $str=explode(" ",$row->fecha);
                $fecha=$str[0];
                $hora=$str[1];
                $valor=0;
                if($row->valor_ant==1){
                    $valor+=1;
                }
                $render.="<tr><td>".date('d-m-Y',strtotime($fecha))."</td><td>".$hora."</td>";
                $render.="<td style='text-align: center'>".$valor."</td></tr>";
                $ct+=$valor;
            }
            $render.="<tr style='background-color: #f2f2f2;'><td colspan='2' style='text-align: right;'>Total del Puntos:</td><td style='text-align: center'>".$ct."</td></tr>";
        }

        if($descripcion=='prestamo'){
            $acum=0;
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='2'><i class='fa fa-money'></i> PRESTAMOS</th></tr><tr style='background: #396da1;'><th>FECHA</th><th>MONTO SOLICITADO</th></tr></thead><tbody>"; 
                foreach ($rs as $row) {
                    $render.="<tr><td>".date('d-m-Y',strtotime($row->fecha))."</td>";
                    $render.="<td style='text-align: right'>".number_format($row->valor,2)." MXN</td></tr>";
                    $acum+=$row->valor;
                }
                $render.="<tr style='background-color: #f2f2f2;'><td style='text-align: right;'>Total del Solicitado:</td><td style='text-align: right'>".number_format($acum,2)."</td></tr>";
            }

        if($descripcion=='vacacion'){
            $acum=0;
            $result = 0;
            $days=$this->getDiasVacaciones($idPersona, $anio);
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'><div class='col-md-12' style='padding: 0px;color: #3d3d3d;display: flex;justify-content: space-between;'><label>Total Días Correspondientes: <b>".$days[0]."</b></label><label>Total Días Aprobados: <b>".$days[2]."</b></label><label>Total Días Disponibles: <b>".$days[3]."</b></label></div><table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='5'><i class='fa fa-plane'></i> VACACIONES DE ESTE MES</th></tr><tr style='background: #396da1;'><th>FECHA SALIDA</th><th>DÍAS SOLICITADOS</th><th>DÍAS RESTANTES</th></tr></thead><tbody>";
            if (empty($rs)) { $render .= '<tr><td colspan="3"><center><strong>Sin resultados</strong><center></td></tr>'; }
            foreach ($rs as $row) {
                $result = $days[3] != 0 ? $days[3]-$row->valor : 0;
                $render.="<tr><td>".date('d-m-Y',strtotime($row->fecha))."</td>";
                $render.="<td style='text-align: center'>".$row->valor."</td>";
                $render.="<td style='text-align: center'>".($result)."</td></tr>";
            }
        }

        if($descripcion=='cambio puesto'){
            $acum=0;
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='3'><i class='fa fa-user'></i> CAMBIO PUESTO</th></tr><tr style='background: #396da1;'><th>FECHA</th><th>PUESTO NUEVO</th><th>PUESTO ANTERIOR</th></tr></thead><tbody>"; 
            foreach ($rs as $row) {
                $render.="<tr><td>".date('d-m-Y',strtotime($row->fecha))."</td>";
                $render.="<td style='text-align: center'>".$row->valor."</td>";
                $render.="<td style='text-align: center'>".$row->valor_ant."</td></tr>";
            }
        }

        /*if($descripcion=='capacitacion'){
            $acum=0;
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='3'><i class='fa fa-user'></i> CAPACITACIONES</th></tr><tr style='background: #396da1;'><th>FECHA</th><th>NÚMERO DE HORAS</th></th></tr></thead><tbody>"; 
            foreach ($rs as $row) {}
                $render.="<tr><td>".date('d-m-Y',strtotime($row->fecha))."</td>";
                $render.="<td style='text-align: center'>".$row->valor."</td></tr>";
            
            $render.="<tr><td colspan='2'>".$row->valor_ant."</td></tr>";
        }*/

        if($descripcion=='calificacion'){
            $acum=0;
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='3'><i class='fa fa-user'></i> CALIFICACIONES</th></tr><tr style='background: #396da1;'><th style='width: 20%'>FECHA</th><th>CALIFICACIÓN</th><th>EVALUACIÓN</th></tr></thead><tbody>"; 
            foreach ($cal as $row) {
                $render.="<tr><td>".date('d-m-Y',strtotime($row->fecha))."</td>";
                $render.="<td style='text-align: center'>".$row->calificacion."</td>";
                $render.="<td style='text-align: center'>".$row->descripcion."</td></tr>";
            }
        }

         if($descripcion=='permiso'){
            $acum=0;
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='3'><i class='fa fa-flag-checkered'></i> PERMISOS</th></tr><tr style='background: #396da1;'><th style='width: 30%'>FECHA</th><th style='text-align: center'>NÚMERO DE DÍAS</th></tr></thead><tbody>"; 
            foreach ($rs as $row) {
                $render.="<tr><td>".date('d-m-Y',strtotime($row->fecha))."</td>";
                $render.="<td style='text-align: center'>".$row->valor."</td></tr>";
            }
        }

         if($descripcion=='incapacidad'){
            $acum=0;
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='3'><i class='fa fa-flag-checkered'></i> INCAPACIDADES</th></tr><tr style='background: #396da1;'><th style='width: 30%'>FECHA</th><th style='text-align: center'>NÚMERO DE DÍAS</th></tr></thead><tbody>"; 
            foreach ($rs as $row) {
                $render.="<tr><td>".date('d-m-Y',strtotime($row->fecha))."</td>";
                $render.="<td style='text-align: center'>".$row->valor."</td></tr>";
            }
        }

        if($descripcion=='sueldo'){
            $acum=0;
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='3'><i class='fa fa-flag-checkered'></i> AJUSTE DE SUELDO</th></tr><tr style='background: #396da1;'><th style='width: 30%'>FECHA</th><th style='text-align: right'>IMPORTE SOLICITADO</th><th style='text-align: right'>IMPORTE AUTORIZADO</th></tr></thead><tbody>"; 
            foreach ($rs as $row) {
                $render.="<tr><td>".date('d-m-Y',strtotime($row->fecha))."</td>";
                $render.="<td style='text-align: right'>".number_format($row->valor,2)."</td>";
                $render.="<td style='text-align: right'>".number_format($row->valor_ant,2)."</td></tr>";
            }
        }

        if($descripcion=='asistencia'){
            $acum=0;
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='3'><i class='fa fa-flag-checkered'></i> ASISTENCIA</th></tr><tr style='background: #396da1;'><th style='width: 30%'>FECHA</th><th style='text-align: right'>ESTADO</th></tr></thead><tbody>"; 
            foreach ($rs as $row) {
                $render.="<tr><td>".date('d-m-Y',strtotime($row->fecha))."</td>";
                $render.="<td style='text-align: right'><i class='fa fa-check-circle' style='font-size: 18px;color:blue;'></i></td></tr>";
            }
        }

  if ($descripcion == "auditoria") {
            $query = $this->PersonaModelo->getMonthAudit($idPersona,$mes,$anio);
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'><table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='3'><i class='fas fa-list-alt'></i> AUDITORÍA</th></tr><tr style='background: #396da1;'><th style='width: 20%'>FECHA</th><th>CALIFICACIÓN</th><th>PERIODO</th></tr></thead><tbody>";
            if (empty($query)) { $render .= '<tr><td colspan="3"><center><strong>Sin resultados</strong><center></td></tr>'; }
            foreach ($query as $row) {
                $trimestre = $row->trimestre;
                if ($trimestre == "Primero") { $trimestre = "Primer"; }
                $render.='<tr><td>'.date('d-m-Y',strtotime($row->fecha)).'</td><td>'.$row->calificacion.'</td><td>'.$trimestre.' Trimestre del '.date('Y',strtotime($row->fecha)).'</td></tr>';
            }
        }

                if($descripcion=='salida'){
        $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'>".$labelMessage."<table class='table table-hover' style='font-size: 14px;width: 100%;border: 1px'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='4'><i class='fa fa-clock-o'></i> CONTROL DE SALIDA</th></tr><tr style='background: #396da1;'><th>FECHA</th><th>HORA</th><th style='text-align: right'>ESTADO</th></tr></thead><tbody>"; 
            foreach ($rs as $row) {
                $str=explode(" ",$row->fecha);
                $fecha=$str[0];
                $hora=$str[1];
                $render.="<tr><td>".date('d-m-Y',strtotime($fecha))."</td><td>".$hora."</td>";
                $render.="<td style='text-align: right'><i class='fa fa-check-circle' style='font-size: 18px;color:blue;'></i></td></tr>"; 
            }
        }

       if ($descripcion == "capacitacion") {
            //Version 2
            $query = $this->PersonaModelo->getAsistEvent($idPersona,$mes,$anio);
            $render="<div class='col-md-12' style='max-height: 400px;overflow: auto;'><table class='table table-hover' style='font-size: 14px;width: 100%;'><thead style='position:sticky;top:0;'><tr style='background: #396da1;'><th colspan='4'><i class='fas fa-list-alt'></i> CAPACITACIONES</th></tr><tr style='background: #396da1;'><th style='width: 20%'>FECHA</th><th>TÍTULO</th><th>CAPACITACIÓN</th><th>ASISTENCIA</th></tr></thead><tbody>";
            if (empty($query)) { $render .= '<tr><td colspan="3"><center><strong>Sin resultados</strong><center></td></tr>'; }
            foreach ($query as $key => $row) {
                $status = '<i class="fa fa-times-circle" style="color: red;font-size: 18px;"></i>';
                if ($row->estado == "activo") { $status = "<i class='fa fa-check-circle' style='font-size: 18px;color:blue;'></i>"; }
                $render.='<tr><td>'.date('d-m-Y',strtotime($row->fecha)).'</td><td>'.$row->titulo.'</td><td>'.$row->tipo.'</td><td>'.$status.'</td></tr>';
            }
        }

        $render.="</tbody></table></div>";
        echo $render;
    }


    
    function getDescripcion($idPersona,$descripcion){
        $sql="";
        if($descripcion!="calificacion"){
        $sql="SELECT * from fastfile WHERE idPersona='$idPersona' AND descripcion='$descripcion' ORDER BY fecha DESC";
        }else{
            //$sql="SELECT * from fastfile WHERE idPersona='$idPersona' AND descripcion='$descripcion' ORDER BY fecha DESC";
            $sql="select e.descripcion, p.calificacion, p.fecha_aplicacion as fecha FROM  fastfile f left join evaluacion_periodo_empleado p on f.idPersona=p.empleado_id left join evaluaciones e on p.evaluacion_id=e.id where f.idPersona='$idPersona' and f.descripcion='$descripcion' and p.fecha_aplicacion IS NOT NULL GROUP by p.fecha_aplicacion ORDER BY p.fecha_aplicacion DESC";
        }
       
        return $this->db->query($sql)->result();
    }


    function getTablero(){
      $idPersona=$_GET['idPersona'];
     
      if(isset($_GET['year'])){
         $year=$_GET['year'];
      }else{
        $year=date('Y');
      }
      $this->datos['persona']=$this->PersonaModelo->devuelveInfoUser($idPersona);
      $this->datos['fechaIngreso']=$this->PersonaModelo->getFechaIngreso($idPersona);
      
      $path_foto= base_url()."assets/img/miInfo/userPhotos/";
      $foto=$path_foto."noPhoto.png";
      $sql="SELECT fotoUser FROM user_miInfo WHERE idPersona='$idPersona'";
      $rs=$this->db->query($sql)->result();
      if($rs){
        $imagenPersona=$rs[0]->fotoUser;
        if(isset($imagenPersona)){ 
          $foto=$path_foto.$imagenPersona;
        }
      }
      $this->datos['fotoUser']=$foto;
      $this->datos['anio']=$year;
      $this->datos['cargo']=$this->PersonaModelo->puestoDePersona($idPersona);
      //Puntualidad
      $this->datos['puntualidad']=$this->getDescripcion($idPersona,'puntualidad');
       //Asistencia
      $this->datos['asistencia']=$this->getDescripcion($idPersona,'asistencia');
      //Prestamos
      $this->verificarPrestamos($idPersona,$year);
      $this->datos['prestamos']=$this->getDescripcion($idPersona,'prestamo');
      
      //Vacaciones
      $this->verificarVacaciones($idPersona,$year);
      $this->datos['vacaciones']=$this->getDescripcion($idPersona,'vacacion');
      
      //Cambio de Puesto
      $puesto=$this->PersonaModelo->puestoDePersona($idPersona);
      if(isset($puesto[0]->personaPuesto)){
        $puesto=$puesto[0]->personaPuesto;
        $this->actualizarCambioPuesto($idPersona,$puesto,$year);
      }

      $this->datos['cambio']=$this->getDescripcion($idPersona,'cambio puesto');
       //Capacitacion
      $this->verificarCapacitaciones($idPersona,$year);
      $this->datos['capacitacion']=$this->getDescripcion($idPersona,'capacitacion');
      
       //Calificaciones
      $this->verificarCalificaciones($idPersona,$year);
      $this->datos['calificacion']=$this->getDescripcion($idPersona,'calificacion');

      //Dias de vacaciones
       $this->datos["dias_vacaciones"] = $this->PersonaModelo->getVacaciones($idPersona);

       //Permisos 
       $this->verificarPermiso($idPersona,$year);
       $this->datos['permisos']=$this->getDescripcion($idPersona,'permiso');
       
        //Incapacidad
        $this->verificarIncapacidad($idPersona,$year);
        $this->datos['incapacidad']=$this->getDescripcion($idPersona,'incapacidad');

      
       //Sueldos
       $this->verificarSueldos($idPersona,$year);
       $this->datos['sueldos']=$this->getDescripcion($idPersona,'sueldo');
      
      
      $this->load->view('persona/fastFile',$this->datos);
     
    }

    //determinar cantidad de dias de vacaciones correspondientes segun tabla de ley
    function getDiasVacaciones($idPersona, $year){ //Modificado [Suemy][2024-07-09]
        //Determinar dias de antiguedad
        $sql="SELECT * FROM persona WHERE idPersona='$idPersona'";
        $rs=$this->db->query($sql)->result();
        $fecha_ingreso = new DateTime($rs[0]->fecAltaSistemPersona);
        $date = new DateTime("now");
        $mes = $date->format('m');
        $dia = $date->format('d');
        $hora = $date->format('H');
        $minutos = $date->format('i');
        $segundos = $date->format('s');
        $fecha=$year."-".$mes."-".$dia." ".$hora.":".$minutos.":".$segundos;
        $hoy = new DateTime($fecha);
        $yearAntiguedad = $hoy->diff($fecha_ingreso);
        $yearAntiguedad=$yearAntiguedad->y;
                //determinar cantidad de dias de vacaciones correspondientes

        ;
        $anio=explode('-', $this->getDateDataFromMyRecord($idPersona)['currentDatePeriod']);
        // Encontrar rango de fechas para solicitar vacaciones
        $start = date('Y-m-d',strtotime($rs[0]->fecAltaSistemPersona.' + '.$yearAntiguedad.' years'));
        $finish = $this->superestrella_model->getAnniversaryDate($rs[0]->fecAltaSistemPersona);
        $ap = $this->db->query('SELECT SUM(cantidad_dias) AS aprobados FROM vacaciones WHERE estado = "aprobado" AND idPersona = '.$idPersona.' AND fecha_salida BETWEEN "'.$start.'" AND "'.$finish.'"')->row();
        //
        if($year>2022) { $sqlX="SELECT * FROM tabla_vacaciones_nueva WHERE anio='$yearAntiguedad'"; }
        else { $sqlX="SELECT * FROM tabla_vacaciones WHERE anio='$yearAntiguedad'"; }
        //$period = $this->PersonaModelo->getWorkStartPeriod($idPersona);
                $rsDias=$this->db->query($sqlX)->result();
                if($rsDias){
            $datos[0] = $rsDias[0]->dias;
            $datos[1] = $yearAntiguedad;
            $datos[2] = !is_null($ap) ? $ap->aprobados : 0;
            $datos[3] = ($datos[2] != 0) ? ($datos[0] - $datos[2]) : 0;
            }else{
            $datos[0] = '';
            $datos[1] = '';
            $datos[2] = '';
            $datos[3] = '';
            }
            return $datos;
        }

  function getDateDataFromMyRecord($idPersona){

    $test = array();
    $response = array();
    $countFromLimit = 0;
    $getInitialDate = $this->PersonaModelo->getFechaIngreso($idPersona);

    if(!empty($getInitialDate)){

      $now = new DateTime("now");
      $limitDate = new DateTime(date("Y-m-d", strtotime($getInitialDate))); //date("Y-m-d", strtotime($getInitialDate))
      $diff = $limitDate->diff($now);
      $limitDate = $limitDate->modify("".$diff->format("%R%y")." year"); //Limite de cambio de periodo;

      $response = array(
        "haveVacations" => $diff->format("%y") > 0,
        "initialJobDate" => date("Y-m-d", strtotime($getInitialDate)),
        "currentDatePeriod" => $limitDate->format("Y-m-d"), //date("Y-m-d", strtotime($getInitialDate)),
        "nextDatePeriod" => $limitDate->modify("+ 1 year")->format("Y-m-d"),
        "periodNumber" => $diff->format("%y"),
        "dayAndMonthLimit" => [$limitDate->format("n-j")]
        //"intervalDates" => $test,
      );
    }

  ;
    ;
    return $response;
  }
  //---------------------------------------- 
      function getDiasSolicitados($idPersona,$year){
      //determinar los dias solicitados en el año por Usuario
    $dias=$this->getDiasVacaciones($idPersona,$year);
    $period = $dias[1];
    $year=date('Y');

    $data=$this->getDateDataFromMyRecord($idPersona);
           $fechaEntera = strtotime($data['currentDatePeriod']);
      $year=date('Y',$fechaEntera);
      if($period){
        $antiguedad=$period;
      }else{
        $antiguedad=0;
      }
      
    
    $sqlX="SELECT SUM(cantidad_dias) as dias FROM vacaciones WHERE  antiguedad = ".$antiguedad." AND aprobado IN (0, 1) and idPersona = $idPersona"; //aprobado<>-1
    return $this->db->query($sqlX)->result();
      }

//--------------------------------------
    function viewSearchOtherFastFile(){
        //consulta de todo el personal activo
         $rs=$this->PersonaModelo->clasificacionUsuariosParaEnvios();
         $render="<div id='tablaFastFile' style='height: 400px;overflow-y: scroll;'><table class='table table-responsive table-hover' style='width: 100%;margin-top: 2%;font-size: 7px;'><tbody>";
        foreach($rs as $i => $item){
            $render.="<tr style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;'><td colspan='2'>".strtoupper($item['Name'])."</td></tr>";
                foreach($item["Data"] as $items){
                    if(isset($items['idPersona'])){
                        $idPersona=$items['idPersona'];
                    }
                    $render.="<tr><td><b>".$items['username']."</b>&nbsp;(".$items['email'].")</td><td><button class='btn btn-primary btn-md' onclick='selectFastFile(".$idPersona.",".date('Y').")'><i class='fa fa-check-circle'></i></button></td></tr>";
                }
        }
        $render.="</div></tbody></table>";
        echo $render;
    }

    function getEscolaridad($op){
        if($op=="NO"||$op==""){
            $op=0;
        }
        $escolaridad[0]= "INDISTINTO";
        $escolaridad[1]= "PRIMARIA";
        $escolaridad[2]= "SECUNDARIA";
        $escolaridad[3]= "PREPARATORIA";
        $escolaridad[4]= "LICENCIATURA";
        $escolaridad[5]= "MAESTRIA";
        $escolaridad[6]= "DOCTORADO";
        return $escolaridad[$op];
    }

    function getEstadoCivil($op){
         if($op=="NO"||$op==""){
            $op=0;
        }
        $escolaridad[0]= "INDISTINTO";
        $escolaridad[1]= "SOLTERO";
        $escolaridad[2]= "CASADO";
        $escolaridad[3]= "DIVORCIADO";
        $escolaridad[4]= "VIUDO";
        $escolaridad[5]= "UNION LIBRE";
        return $escolaridad[$op];
    }

    function getNivelIngles($op){
        if($op=="NO"||$op==""){
            $op=0;
        }
        $ingles[0]= "NO";
        $ingles[1]= "BASICO";
        $ingles[2]= "INTERMEDIO";
        $ingles[3]= "AVANZADO";
        return $op;
    }

    function getEval($op1,$op2){
        if(($op1==$op2)||($op1=="INDISTINTO")){
            return 1;
        }else{
            return 0;
        }
    }

    function getEvalPercent($op){
        $op=$op*0.1;
        return $op;
    }

    function viewPerfilApego(){ //Modificado - Puestos 28/09/2023
        $idPersona=$_REQUEST['idPersona'];
        $puesto=$_REQUEST['puesto'];
        //Verificar Perfil de apego

        $sqlX="SELECT * FROM persona a LEFT JOIN requerimientos_y_perfil_del_puesto b ON a.idPersona = b.idPersona WHERE a.idPersona='$idPersona'";
        $rsPersona=$this->db->query($sqlX)->result();
        $id_puesto=$rsPersona[0]->idPersonaPuesto;
        //$sexoPersona=$rsPersona[0]->sexo;
        $edadPersona=(DATE('Y'))-(DATE('Y',strtotime($rsPersona[0]->fechaNacimiento)));
        //$estadoCivilPersona=$rsPersona[0]->estadoCivil;
        //$escolaridadPersona=$rsPersona[0]->escolaridad;
        //$carroPersona=$rsPersona[0]->vehiculoPersona;
        //$viajarPersona=$rsPersona[0]->viajar;
        //$inglesPersona=$rsPersona[0]->ingles;
        //$postgradoPersona=$rsPersona[0]->postgrado;
        //$herramientas_officePersona=$rsPersona[0]->herramientas_office;
        $experienciaPersona=$rsPersona[0]->experiencia;
        $habilidadesPersona=$rsPersona[0]->habilidades;
        $competenciasPersona=$rsPersona[0]->competencias;
        $psicometria=$rsPersona[0]->psicometria;
        $valorOrganizacional=$rsPersona[0]->valorOrganizacional;
        $experienciaLaboral=$rsPersona[0]->experienciaLaboral;
       
        $sql="SELECT * FROM perfil_puesto WHERE id_puesto='$id_puesto'";
        $rs=$this->db->query($sql)->result();
        if($rs){
            $id_puesto=$rs[0]->id_puesto;
            $sexo=$rs[0]->sexo;
            $edad=$rs[0]->edad;
            $estadoCivil=$rs[0]->edocivil;
            $escolaridad=$rs[0]->escolaridad;
            $carro=$rs[0]->carro;
            $viajar=$rs[0]->viajar;
            $ingles=$rs[0]->ingles;
            $postgrado=$rs[0]->postgrado;
            $herramientas_office=$rs[0]->herramientas;
        }else{
            $id_puesto='';
            $sexo='';
            $edad='';
            $estadoCivil='';
            $escolaridad='';
            $carro='';
            $viajar='';
            $ingles='';
            $postgrado='';
            $herramientas_office='';
        }
       

         $render="<div id='tablaFastFile'><h5 style='text-align:center;'><i class='fa fa-user'></i>&nbsp;Puesto: ".$puesto."</h5><div style='max-height: 370px;overflow: auto;'><table class='table table-responsive table-hover' style='margin-top: 1%;'>";
        $render.="<tr style='background-color: #7996bc;color: #fff;font-weight: bold;'><th colspan='4' style='text-align: center;'>PERFIL DE APEGO</th></tr>";
        $render.="<tr style='background-color: #f2f2f2;font-weight: bold'><td style='background-color: #f6f8fb;'>Requerimiento</td><td style='background-color: #f6f8fb;'>Valor Requerido</td><td style='background-color: #adcaf0;text-align:center;'><b>Valor Colaborador Actual</td><td style='background-color: #7996bc;color: #fff;'>Total</td></tr>";
        //$render.="<tr><td><i class='fa fa-dot-circle-o'></i> Sexo:</td><td style='background-color: #f6f8fb;text-align: center;'>".$sexo."</td><td style='background-color: #adcaf0;text-align:center;'>".$sexoPersona."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEval($sexo,$sexoPersona)."</td></tr>";
        //$render.="<tr><td><i class='fa fa-dot-circle-o'></i> Escolaridad:</td><td style='background-color: #f6f8fb;text-align: center;'>".$this->getEscolaridad($escolaridad)."</td><td style='background-color: #adcaf0;text-align:center;'>".$this->getEscolaridad($escolaridadPersona)."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEval($this->getEscolaridad($escolaridad),$this->getEscolaridad($escolaridadPersona))."</td></tr>";
        //$render.="<tr><td><i class='fa fa-dot-circle-o'></i> Estado Civil:</td><td style='background-color: #f6f8fb;text-align: center;'>".$this->getEstadoCivil($estadoCivil)."</td><td style='background-color: #adcaf0;text-align:center;'>".$this->getEstadoCivil($estadoCivilPersona)."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEval($this->getEstadoCivil($estadoCivil),$this->getEstadoCivil($estadoCivilPersona))."</td></tr>";
        //$render.="<tr><td><i class='fa fa-dot-circle-o'></i> Disponibilidad de Carro:</td><td style='background-color: #f6f8fb;text-align: center;'>".$carro."</td><td style='background-color: #adcaf0;text-align:center;'>".$carroPersona."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEval($carro,$carroPersona)."</td></tr>";
        //$render.="<tr><td><i class='fa fa-dot-circle-o'></i> Nivel de Ingles:</td><td style='background-color: #f6f8fb;text-align: center;'>".$this->getNivelIngles($ingles)."</td><td style='background-color: #adcaf0;text-align:center;'>".$this->getNivelIngles($inglesPersona)."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEval($this->getNivelIngles($ingles),$this->getNivelIngles($inglesPersona))."</td></tr>";
        //$render.="<tr><td><i class='fa fa-dot-circle-o'></i> Postgrado:</td><td style='background-color: #f6f8fb;text-align: center;'>".$postgrado."</td><td style='background-color: #adcaf0;text-align:center;'>".$postgradoPersona."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEval($postgrado,$postgradoPersona)."</td></tr>";
        //$render.="<tr><td><i class='fa fa-dot-circle-o'></i> Herramientas de Paqueteria(office):</td><td style='background-color: #f6f8fb;text-align: center;'>".$herramientas_office."</td><td style='background-color: #adcaf0;text-align:center;'>".$herramientas_officePersona."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEval($herramientas_office,$herramientas_officePersona)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Entrevista General:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$experienciaPersona."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($experienciaPersona)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Lenguaje Corporal & Puntualidad:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$habilidadesPersona."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($habilidadesPersona)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Competencias:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$competenciasPersona."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($competenciasPersona)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Escolar:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$rsPersona[0]->escolar."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($rsPersona[0]->escolar)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Psicometría:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$rsPersona[0]->psicometria."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($rsPersona[0]->psicometria)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Valor organizacional:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$rsPersona[0]->valorOrganizacional."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($rsPersona[0]->valorOrganizacional)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Experiencia laboral:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$rsPersona[0]->experienciaLaboral."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($rsPersona[0]->experienciaLaboral)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Habilidad de decisión:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$rsPersona[0]->habilidadDecision."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($rsPersona[0]->habilidadDecision)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Habilidad personal:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$rsPersona[0]->habilidadPersonal."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($rsPersona[0]->habilidadPersonal)."</td></tr>";
        $render.="<tr><td><i class='fa fa-dot-circle-o'></i> Habilidad administrativa:</td><td style='background-color: #f6f8fb;text-align: center;'>100</td><td style='background-color: #adcaf0;text-align:center;'>".$rsPersona[0]->habilidadAdministrativa."</td><td style='background-color: #7996bc;color: #fff;text-align: center;font-weight: bold;font-size: 12px;'>".$this->getEvalPercent($rsPersona[0]->habilidadAdministrativa)."</td></tr>";
        //$totalPuntos=($this->getEval($sexo,$sexoPersona))+($this->getEval($this->getEscolaridad($escolaridad),$this->getEscolaridad($escolaridadPersona)))+($this->getEval($this->getEstadoCivil($estadoCivil),$this->getEstadoCivil($estadoCivilPersona)))+($this->getEval($this->getNivelIngles($ingles),$this->getNivelIngles($inglesPersona)))+($this->getEval($postgrado,$postgradoPersona))+($this->getEval($herramientas_office,$herramientas_officePersona))+($this->getEvalPercent($experienciaPersona))+($this->getEvalPercent($habilidadesPersona))+($this->getEvalPercent($competenciasPersona));
        $totalPuntos = $this->getEvalPercent($habilidadesPersona) + $this->getEvalPercent($competenciasPersona) + $this->getEvalPercent($experienciaPersona) + $this->getEvalPercent($rsPersona[0]->escolar) + $this->getEvalPercent($rsPersona[0]->psicometria) + $this->getEvalPercent($rsPersona[0]->valorOrganizacional) + $this->getEvalPercent($rsPersona[0]->experienciaLaboral) + $this->getEvalPercent($rsPersona[0]->habilidadDecision) + $this->getEvalPercent($rsPersona[0]->habilidadPersonal) + $this->getEvalPercent($rsPersona[0]->habilidadAdministrativa);
        $render.="<tr style='background-color: #7996bc;color: #fff;font-weight: bold;'><th style='text-align: right;' colspan='3'>Total:</th><th style='text-align: right'>".$totalPuntos."</th></tr>";
        $render.="<tr style='background-color: #f2f2f2;text-align: right;font-weight: bold;'><th colspan='3' style='text-align: right;'>Total de Apego:</th><th style='text-align: right;width: 15%;'>".(($totalPuntos * 100)/10)." %</th></tr>";
        $render.="</table></div></div>";
        echo $render;
    }

function setPuntualityUser(){
    $idPersona=$_REQUEST['id'];
    $day=date('d');
    $month=date('m');
    $year=date('Y');
    $sql_encontrado="SELECT * from fastfile WHERE idPersona='$idPersona' AND DAY(fecha)='$day' AND MONTH(fecha)='$month' AND YEAR(fecha)='$year' AND descripcion='puntualidad'";
    $encontrado=$this->db->query($sql_encontrado)->result();
    if($encontrado){
        if(($encontrado[0]->valor_ant=='')&&($encontrado[0]->valor==1)){
            $sql="UPDATE fastfile set valor_ant=1 WHERE idPersona='$idPersona' AND DAY(fecha)='$day' AND MONTH(fecha)='$month' AND YEAR(fecha)='$year' AND descripcion='puntualidad'";
            $rs=$this->db->query($sql);
        }
    }
}

//***Modificacion 09-12-2021 Asistencia y puntualidad

function asistenciaAnual($year){
    $sql="SELECT * from fastfile WHERE YEAR(fecha)='$year' AND descripcion='asistencia'";
    return $this->db->query($sql)->result();
}

function asistenciaMensual($mes,$year){
    $sql="SELECT * from fastfile WHERE MONTH(fecha)='$mes'  AND YEAR(fecha)='$year' AND descripcion='asistencia'";
    return $this->db->query($sql)->result();
}

function asistencia(){ //Modificado [Suemy][2024-05-13]
    if(isset($_REQUEST['tab'])){
        $tab=$_REQUEST['tab'];
        switch($tab){
            case 1:
                $fecha=date('d-m-Y',strtotime($_REQUEST['fecha']));
            break;
            case 2:
                $fecha="01-".$_REQUEST['fecha']."-2021";
            break;
            case 3:
                 $fecha="01-01-".$_REQUEST['fecha'];
            break;
        }
    }else{
        $tab=1; 
        $fecha=date('d-m-Y');
    }
    $fecha=explode('-',$fecha);
    if($this->tank_auth->get_usermail()=='CONTABILIDAD@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='CAPITALHUMANO@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM')
    {
    $sql="SELECT user_miInfo.* from user_miInfo,persona,users where persona.idPersona=user_miInfo.idPersona AND persona.idPersona = users.idPersona AND persona.bajaPersona=0 AND users.activated=1 AND users.banned=0 AND persona.tipoPersona=1";
    
    }
    else
    {
    $sql="SELECT user_miInfo.* from user_miInfo,persona,users where persona.idPersona=user_miInfo.idPersona AND persona.idPersona = users.idPersona AND persona.bajaPersona=0 AND users.activated=1 AND users.banned=0 AND persona.tipoPersona=1 AND users.email='".$this->tank_auth->get_usermail()."'";
        
    }

    //Encontrar subordinados
    $email = $this->tank_auth->get_usermail();
    if ($email == "DATACENTER@AGENTECAPITAL.COM" || $email == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM") {
        $this->datos['empleados'] = $this->getEmployeeByBoss($this->tank_auth->get_idPersona());
    }
    //Encontrar años
    $option = '';
    $count = date('Y') - 2016;
    $yearI = date('Y');
    for ($i=0;$i<=$count;$i++) {
        $selected = "";
        if ($yearI == date('Y')) { $selected = "selected"; }
        $option .= '<option value="'.$yearI.'" '.$selected.'>'.$yearI.'</option>';
        $yearI--;
    }
    $this->datos['option'] = $option;
    $this->datos['personal']=$this->db->query($sql)->result();
    $this->datos['dia']=$fecha[0];
    $this->datos['mes']=$fecha[1];
    $this->datos['year']=$fecha[2];
    $this->datos['tab']=$tab;
    $this->datos['personalMensual']=$this->asistenciaMensual($fecha[1],$fecha[2]);
    $this->datos['personalAnual']=$this->asistenciaAnual($fecha[2]);
    $this->load->view('persona/asistencia',$this->datos);
}
//***Fin de control asistencia y puntualidad
//-----------------------------------------------------------
function getIdPersonaByPuesto(){
    $id_puesto=$_REQUEST['puesto'];
    $sql="SELECT idPersona FROM persona WHERE idPersonaPuesto='$id_puesto'";
    $rs=$this->db->query($sql)->result();
    echo $rs[0]->idPersona; 
}

//------------------------------ //Dennis Castillo [2022-03-22]
function getAllRepositories(){ //Modificado [Suemy][2024-05-13]

    $job = $_GET["job"];
    $response = array();
    //Comprobar empleados
    $searchHistory = array("idPersona" => $this->tank_auth->get_idPersona());
    $employees = $this->getEmployeeByBoss($this->tank_auth->get_idPersona());
    if ($this->tank_auth->get_usermail() == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || 
        $this->tank_auth->get_usermail() == 'CAPITALHUMANO@AGENTECAPITAL.COM' || 
        $this->tank_auth->get_usermail() == 'DIRECTORGENERAL@AGENTECAPITAL.COM' || !empty($employees)) {
        $searchHistory = array("idPersonaPuesto" => $job);
    }
    //Buscar
    $dataInRepositories = $this->getGeneralRepositories($job);
    $personHistorical = $this->getPersonalHistorical($searchHistory); //$job
    $response[] = array("label" => "Repositorios del puesto", "id" => "repositorio" , "active" => "active", "content" => $dataInRepositories);
    $response[] = array("label" => "Historial de ocupación del puesto", "id" => "historial", "active" => "", "content" => $personHistorical);
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($response[1]["content"], TRUE));fclose($fp); 
    echo json_encode($response);
}
//------------------------------ //Dennis Castillo [2022-03-22]
function getPersonalHistorical($job){ //Modificado [Suemy][2024-05-13]

    $persons = $this->PersonaModelo->getAllPersonByJob($job);
    $repositories = $this->capitalhumano->getRepositories("persona");
    $personRepositories = array();
    $merge = array();
       
    foreach($persons as $arr){

        $name = !empty($arr->nombres) ? $arr->nombres : "";
        $firstName = !empty($arr->apellidoPaterno) ? $arr->apellidoPaterno : "";
        $lastName = !empty($arr->apellidoMaterno) ? $arr->apellidoMaterno : "";
        $nameComplete = $name." ".$firstName." ".$lastName;
        //$getLayout = $this->PersonaModelo->obtenerLayout($arr->idPersona);
        //$uploadedLayout = array_map(function($arr){
            //return $arr->idPersonaDocumento;
        //}, $this->PersonaModelo->obtenerDocumentosSubidosLaoyut($arr->idPersona));

        array_push($personRepositories, array(
            "id" => "person-".$arr->idPersona, 
            "parent" => "#", 
            "text" => $nameComplete." ".($arr->bajaPersona ? "(inactivo)" : ""), 
            "type" => "#",
            "a_attr" => array(
                "class" => ($arr->bajaPersona ? "text-danger" : "text-dark"),
                "data-idpersona" => $arr->idPersona,
            ),
        ));

        foreach($repositories as $dr){

            array_push($personRepositories, array(
                "id" => "folder-".$arr->idPersona."-".$dr->repositorio,
                "parent" => "person-".$arr->idPersona, 
                "text" => $dr->etiqueta, 
                "type" => "root",
                "a_attr" => array(
                    "class" => ($arr->bajaPersona ? "text-danger" : "text-dark"),
                    "data-idpersona" => $arr->idPersona,
                ),
            ));

            $childFiles = $this->returnFilesFromRepositories($dr->repositorio, $arr->idPersona, $arr->bajaPersona);

            if(!empty($childFiles)){

                foreach($childFiles as $cd){
                    array_push($personRepositories, $cd);
                }
            }
        }
    }
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($personRepositories, TRUE));fclose($fp);
    return $personRepositories;
}
//------------------------------ //Dennis Castillo [2022-03-22]
function returnFilesFromRepositories($repository, $person, $able){

    $response = array();

    switch($repository){
        case "incapacidad": $response = $this->getIncident($repository, $person, $able);
        break;
        case "permiso": $response = $this->getIncident($repository, $person, $able);
        break;
        case "documentos": $response = $this->getPersonalDocuments($person, $able);
        break;
        case "vacaciones": $response = $this->getVacations($person, $able);
        break;
        default: array();
        break;
    }

    return $response;
}
//----------------------------- //Dennis Castillo [2022-03-22]
function getVacations($person, $able){

    $getVacations_ = $this->capitalhumano->getVacationsInfo($person);
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($getVacations_, TRUE));fclose($fp);
    $vacationsDocuments = array();

    if(!empty($getVacations_)){

        foreach($getVacations_ as $dv){
            array_push($vacationsDocuments, array(
                "id" => "file-".$dv->id, 
                "parent" => "folder-".$person."-vacaciones",
                "text" => "Solicitud: ".date("d-m-Y", strtotime($dv->fecha_salida))." - ".date("d-m-Y", strtotime($dv->fecha_retorno))." (".$dv->label.")",
                "type" => "file",
                "a_attr" => array(
                    "href" => base_url()."uploads/VACACIONES/REF_".$dv->reference_id."/".$dv->name,
                    "class" => ($able ? "text-danger" : "text-dark"),
                    "docName" => !empty($dv->name) ? $dv->name : "Uknwon",
                    "idDoc" => !empty($dv->reference_id) ? $dv->reference_id : "Uknwon",
                    "dateCreate" => $dv->fecha,
                    "pathfile" => base_url()."uploads/VACACIONES/REF_".$dv->reference_id."/".$dv->name,
                    "showContent" => !empty($dv->name) ? true : false,
                )
            ));
        }
    }

    return $vacationsDocuments;
}
//----------------------------- //Dennis Castillo [2022-03-22]
function getPersonalDocuments($person, $able){

    $documentRepository = array();
    $subCount = 0;
    $getLayout = $this->PersonaModelo->geteEmployeLayout();
    $getMyLayout = $this->PersonaModelo->getEmployeFileUpload($person, null, 8);
    $uploadedLayout = array_map(function($arr){
        return $arr->idPersonaDocumento;
    }, $getMyLayout);

    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($getMyLayout, TRUE));fclose($fp);

    foreach($getLayout as $ldata){
                        
        if(in_array($ldata->idPersonaDocumento, $uploadedLayout)){

            $layout = $ldata->descripcionPD;
            $getFormat = array_values(array_filter($getMyLayout, function($arr) use($layout){ return $arr->descripcionPD == $layout; }));
            //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($getFormat, TRUE));fclose($fp);

            array_push($documentRepository, array(
                "id" => "file-".$subCount, 
                "parent" => "folder-".$person."-documentos",
                "text" => $ldata->textoPD, 
                "type" => "file",
                "a_attr" => array(
                    "href" => base_url()."archivosPersona/".$person."/".$ldata->descripcionPD.".".$getFormat[0]->extensionPDG,
                    "class" => ($able ? "text-danger" : "text-dark"),
                    "docName" => $ldata->descripcionPD,
                    "idDoc" => $ldata->idPersonaDocumento,
                    "dateCreate" => "Sin fecha registrada",
                    "pathfile" => base_url()."archivosPersona/".$person."/".$ldata->descripcionPD.".".$getFormat[0]->extensionPDG,
                    "showContent" => true,
                )
            ));
        }
        $subCount++;
    }

    return $documentRepository;
}
//----------------------------- //Dennis Castillo [2022-03-22]
function getIncident($typeIncident, $person, $able){

    $incidents = $this->incidencias->getUserIncidenciasByUsuarioAlterno($person);
    $getMyIncidents = array_reduce($incidents, function($acc, $curr) use($typeIncident, $person, $able){

        if($curr["empleado_id"] == $person && strtolower($curr["nombre"]) == $typeIncident){

            $getDocumentData = $this->documentos->getDocument("INCIDENCIAS", $curr["idincidencias"]);
            $path = !empty($getDocumentData) ? str_replace("./uploads/", base_url()."uploads/", $getDocumentData->ruta) : "#";

            array_push($acc, array(
                "id" => "file-".$typeIncident."-".$curr["idincidencias"], 
                "parent" => "folder-".$person."-".$typeIncident,
                "text" => $curr["comentario"]." - Fecha de inicio: ".date("d-m-Y H:i:s a", strtotime($curr["fecha_inicio"])),
                "type" => "file",
                "a_attr" => array(
                    "href" => !empty($getDocumentData) ? $path.$getDocumentData->nombre_completo : "#",
                    "class" => ($able ? "text-danger" : "text-dark"),
                    "docName" => !empty($getDocumentData) ? $getDocumentData->nombre_completo : "Sin nombre del documento",
                    "idDoc" => !empty($getDocumentData) ? $getDocumentData->id : null,
                    "dateCreate" => date("Y-m-d H:i:s a", strtotime($curr["fecha_alta"])),
                    "pathfile" => !empty($getDocumentData) ? $path.$getDocumentData->nombre_completo : "#",
                    "showContent" => !empty($getDocumentData) ? true : false,
                )
            ));
        }

        return $acc;
    }, array());

    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($getMyIncidents, TRUE));fclose($fp);
    return $getMyIncidents;
}
//------------------------------ //Dennis Castillo [2022-03-22]
function getGeneralRepositories($job){ //Modificado [Suemy][2024-10-30]
    $getRepositories =  $this->capitalhumano->getAllDocumentsofJob($job);
    $repositories = $this->capitalhumano->getRepositories();
    $employees = $this->getEmployeeByBoss($this->tank_auth->get_idPersona());
    $filter = array("vacaciones", "permiso", "documentos", "incapacidad", "formatos", "solicitudes", "psicosometrico", "otros","cambiopuesto"); //Colaborador normal
    if ($this->tank_auth->get_usermail() == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || 
        $this->tank_auth->get_usermail() == 'CAPITALHUMANO@AGENTECAPITAL.COM' || 
        $this->tank_auth->get_usermail() == 'DIRECTORGENERAL@AGENTECAPITAL.COM') { //Todos los repositorios
        $filter = array("vacaciones", "permisos", "documentos", "incapacidad");
    }
    else if (!empty($employees)) { //Si tiene subordinado
        $filter = array("vacaciones", "permiso", "documentos", "incapacidad", "solicitudes", "psicosometrico", "otros","cambiopuesto");
    }
    $repositoriesFiltered = array_filter($repositories, function($arr) use($filter){ return !in_array($arr->repositorio, $filter); });
    $subDirs = array();
    $count = 0;

    $repositories =  array_map(function($arr){
        return array("id" => $arr->repositorio, "parent" => "#", "text" => $arr->etiqueta, "type" => "#", "a_attr" => array("class" => "text-dark",));
    }, array_values($repositoriesFiltered)); //$this->capitalhumano->getRepositories()
        
    foreach($getRepositories as $data){

        if(!in_array($data->folder, $filter)){

            $path = !empty($data->subDirectory) ? explode("/", $data->subDirectory) : array();
            array_push($path, $data->tag." (".$data->document.")");

            foreach($path as $k => $v){

                $parent = $k == 0 ? $data->folder : "folder-".$data->folder."-".($count - 1);
                array_push($subDirs, array(
                    "id" => "folder-".$data->folder."-".($count),
                    "parent" => $parent,
                    "text" => $v,
                    "type" => $v === end($path) ? "file" : "root",
                    "a_attr" => array(
                        "href" => ($v === end($path) ? $data->downloadURL : "#"),
                        "docName" => ($v === end($path) ? $data->document : ""),
                        "idDoc" => ($v === end($path) ? $data->id : ""),
                        "dateCreate" => ($v === end($path) ? date("d-m-Y H:i:s a", strtotime($data->dateInsert)) : ""),
                        "pathfile" => ($v === end($path) ? $data->etiqueta."/".$data->subDirectory : ""),
                        "class" => "text-dark",
                        "showContent" => ($v === end($path) ? true : false),
                    )
                ));
    
                $count ++; 
            }
        }
    }

    $response = array_merge($repositories, $subDirs);
    return $response;
}
//------------------------------ //Dennis Castillo [2022-03-22]
function deleteFileFromRepository(){

    $idDoc = $_POST["idDoc"];
    $array = array();
    array_push($array, $idDoc);

    $delete = $this->capitalhumano->deleteDocsAndFormat($array);
    $message = $delete ? "Archivo eliminado con exito" : "Ocurrío un detalle. Favor de contactar al departamento de sistemas";
    echo json_encode(array("bool" => $delete, "message" => $message));
}
//------------------------------
function validateIncidences($typeIncident = "incapacidad", $person = 892, $able = 0){
    $incidents = $this->incidencias->getUserIncidenciasByUsuarioAlterno($person);
    $getMyIncidents = array_reduce($incidents, function($acc, $curr) use($typeIncident, $person, $able){

        if($curr["empleado_id"] == $person && strtolower($curr["nombre"]) == $typeIncident){

            $getDocumentData = $this->documentos->getDocument("INCIDENCIAS", $curr["idincidencias"]);
            $path = str_replace("./uploads/", base_url()."uploads/", $getDocumentData->ruta);

            array_push($acc, array(
                "id" => "file-".$typeIncident."-".$curr["idincidencias"], 
                "parent" => "folder-".$person."-".$typeIncident,
                "text" => $curr["comentario"]." - Fecha de inicio: ".date("d-m-Y H:i:s a", strtotime($curr["fecha_inicio"])),
                "type" => "file",
                "a_attr" => array(
                    "href" => $path.$getDocumentData->nombre_completo,
                    "class" => ($able ? "text-danger" : "text-dark"),
                    "docName" => $getDocumentData->nombre_completo,
                    "idDoc" => $getDocumentData->id,
                    "dateCreate" => date("Y-m-d H:i:s a", strtotime($curr["fecha_alta"])),
                    "pathfile" => $path.$getDocumentData->nombre_completo,
                )
            ));
        }

        return $acc;
    }, array());

    var_dump($getMyIncidents);
}
//-----------------------------
function uploadFileToServer($directory, $file, $id){

    $response = false;
    $directory["root0"] = $this->directorio->obtenerDirectorio("U")."uploads";
    ksort($directory);
    $path = implode("/", $directory);
    
    $extension = $this->directorio->devolverExtension($file["uploadFormatVacation"]["name"]);
    //$name = $this->directorio->obtenerNombreArchivo($file["uploadFormatVacation"]["name"]);
    $uploadFile = $this->directorio->guardarArchivo($path, $file, "solicitud_".$id, $extension);

    //if($uploadFile){

        //$response = $this->capitalhumano->insertVacationRecord(array("name" => $file["uploadFormatVacation"]["name"], "mime" => $file["uploadFormatVacation"]["type"], "reference_id" => $id));
    //}
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(array($name, $extension), TRUE));fclose($fp);

    return array("success" => $uploadFile, "name" => "solicitud_".$id, "extension" => $extension);
}
//-----------------------------
function getDashboard(){ //Modificado [Suemy][2024-03-01]

    try{

        $jobId = $_GET["id"];
        $month = isset($_GET["month"]) ? $_GET["month"] : date("n");
        $year = isset($_GET["year"]) ? $_GET["year"] : date("Y");
        $day = isset($_GET["month"]) && $_GET["month"] !== date("n") ? date("d", mktime(0, 0, 0, $month + 1, 0, $year)) : date("d"); //isset($_GET["month"]) && $_GET["month"] !== date("n") ? 0 : date("d") + 1;
        $lastDayOfMonth = date("Y-m-d", mktime(0, 0, 0, $month + 1, 0, $year));
        $path_picture = base_url()."assets/img/miInfo/userPhotos/";
        $getMonths = $this->libreriav3->devolverMeses();
        $response = array();
        $response['empty'] = true;
        $dataJob = $this->capitalhumano->getEmployeeData($jobId); //getEmployeeData
        $dataPicture = $this->PersonaModelo->getPersonalPicture($dataJob->idPersona);
        $picture = !empty($dataPicture) ? $dataPicture->fotoUser : "noPhoto.png";

        if(!empty($dataJob->idPersona)){

            $response['persona'] = $this->PersonaModelo->devuelveInfoUser($dataJob->idPersona);
            $response['idPersona'] = $dataJob->idPersona;
            $response['fechaIngreso'] = $this->PersonaModelo->getFechaIngreso($dataJob->idPersona);
            $response['cargo'] = $this->PersonaModelo->puestoDePersona($dataJob->idPersona); //getPersonalPicture
            $response['fotoUser'] =  $path_picture.$picture; //$picture
            $response['empty'] = false;
            $response['month'] = $month;
            $response['monthName'] = $getMonths[$month];
            $response['year'] = $year;
            $response['vacaciones']=$this->buscarFechaVacas($dataJob->idPersona);
            $response['nolaborales']=$this->buscarDiasNoLaborales();

            //Puntualidad
            $param['puntualidad'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'puntualidad'), $year, $month);  //$this->getDescripcion($dataJob->idPersona,'puntualidad');

            //Asistencia
            $param['asistencia'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'asistencia'), $year, $month); //$this->getDescripcion($dataJob->idPersona,'asistencia');

            //Salidas
            $param['salida'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'salida'), $year, $month); //$this->getDescripcion($dataJob->idPersona,'asistencia');

            //Prestamos
            /*$this->verificarPrestamos($dataJob->idPersona, $year);
            $param['prestamos'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'prestamo'), $year, $month);*/ 
            //$this->getDescripcion($dataJob->idPersona,'prestamo');
            
            //Vacaciones
            $this->verificarVacaciones($dataJob->idPersona, $year);
            $param['vacaciones'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'vacacion'), $year, $month); //$this->getDescripcion($dataJob->idPersona,'vacacion');

            //$this->verificarCapacitaciones($dataJob->idPersona, $year);
            //$this->datos['capacitacion'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'capacitacion'), $year, $month); //$this->getDescripcion($dataJob->idPersona,'capacitacion');
            
             //Calificaciones
            $this->verificarCalificaciones($dataJob->idPersona, $year);
            $param['calificacion'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'calificacion'), $year, $month); //$this->getDescripcion($dataJob->idPersona,'calificacion');
      
            //Dias de vacaciones
            $param["dias_vacaciones"] = $this->PersonaModelo->getVacaciones($dataJob->idPersona);
      
            //Permisos 
            $this->verificarPermiso($dataJob->idPersona, $year);
            $param['permisos'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'permiso'), $year, $month); //$this->getDescripcion($dataJob->idPersona,'permiso');
             
            //Incapacidad
            $this->verificarIncapacidad($dataJob->idPersona, $year);
            $param['incapacidad'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'incapacidad'), $year, $month); //$this->getDescripcion($dataJob->idPersona,'incapacidad');
            
            //Sueldos
            /*$this->verificarSueldos($dataJob->idPersona, $year);
            $param['sueldos'] = $this->filterDates($this->getDescripcion($dataJob->idPersona,'sueldo'), $year, $month);*/
            //$this->getDescripcion($dataJob->idPersona,'sueldo');

            $puesto=$this->PersonaModelo->puestoDePersona($dataJob->idPersona);
            if(isset($puesto[0]->personaPuesto)){
                $puesto=$puesto[0]->personaPuesto;
                $this->actualizarCambioPuesto($dataJob->idPersona,$puesto,$year);
            }

            //Cambio de Puesto
            //$param['cambio_puesto']=$this->getDescripcion($dataJob->idPersona,'cambio puesto');

            //Auditoría
            $param['auditoria'] = $this->filterDates($this->PersonaModelo->getMonthAudit($dataJob->idPersona,$month,$year), $year, $month);

            //Capacitación
            //$param['capacitacion'] = $this->filterDates($this->PersonaModelo->getMonthTraining($dataJob->idPersona,$month,$year), $year, $month);
            $param['capacitacion'] = $this->filterDates($this->PersonaModelo->getAsistEvent($dataJob->idPersona,$month,$year,'AND cr.estado = "activo"'), $year, $month);
            //$response['capacitacion'] = $this->filterDates($this->PersonaModelo->getAsistEvent($dataJob->idPersona,$month,$year), $year, $month);


            $response["monthData"] = $this->getMonthComplete($param, $lastDayOfMonth, $day, $_GET["param"]);
        }

      echo json_encode(array("status" => "success", "code" => 200, "data" => $response));
    } catch(Exception $e){
        echo "Excepción capturada". $e->getMessage()."\n";
    }
}
//-----------------------------
    function buscarFechaVacas($idPersona){
        //Determinar dias de antiguedad
        $sql="SELECT fecha_salida,fecha_retorno FROM vacaciones WHERE idPersona='$idPersona' and estado='Aprobado'";
        $datos=$this->db->query($sql)->result();
        return $datos;
      }
    function buscarDiasNoLaborales(){
        $sql="SELECT diaNoLaboral FROM dianolaboral";
        $datos=$this->db->query($sql)->result();
        return $datos;
    }
      //---------------------------------
    function buscarFechaVacasPendientes($idPersona){
        //Determinar dias de antiguedad
        $sql="SELECT fecha_salida,fecha_retorno FROM vacaciones WHERE idPersona='$idPersona' and estado='Pendiente'";
        $datos=$this->db->query($sql)->result();
        return $datos;
      }
//----------------------------- //Dennis Castillo [2022-06-02]
function getAccumulated(){

    $jobId = $_GET["id"];
    $year = $_GET["year"];
    $path_picture = base_url()."assets/img/miInfo/userPhotos/";
    $getMonths = $this->libreriav3->devolverMeses();
    $response = array();
    $response['empty'] = true;
    $dataJob = $this->capitalhumano->getEmployeeData($jobId);
    $dataPicture = $this->PersonaModelo->getPersonalPicture($dataJob->idPersona);
    $picture = !empty($dataPicture) ? $dataPicture->fotoUser : "noPhoto.png";
    $getYear = $this->PersonaModelo->getWorkStartPeriod($dataJob->idPersona);
    $dias=$this->getDiasVacaciones($dataJob->idPersona, $year);
    if($dias[0]==NULL){
        $dias[0]=0;
    }
    $diasSolicitados=$this->getDiasSolicitados($dataJob->idPersona,$year);
    $diasSolicitados=$diasSolicitados[0]->dias;
        if($diasSolicitados==NULL){
        $diasSolicitados=0;
    }
    $diasRest=intval($dias[0])-intval($diasSolicitados);
    $per=$this->getDateDataFromMyRecord($dataJob->idPersona);
    $periodoActual=date('Y',strtotime($per['currentDatePeriod']));


    if(!empty($dataJob->idPersona)){
        $response['persona'] = $this->PersonaModelo->devuelveInfoUser($dataJob->idPersona);
        $response['idPersona'] = $dataJob->idPersona;
        $response['fechaIngreso'] = $this->PersonaModelo->getFechaIngreso($dataJob->idPersona);
        $response['cargo'] = $this->PersonaModelo->puestoDePersona($dataJob->idPersona);
        $response['fotoUser'] =  $path_picture.$picture;
        $response['empty'] = false;
        $response['year'] = $year;
        $response['vacaciones']=$this->buscarFechaVacas($dataJob->idPersona);
        $response['VacationsPendientes']=$this->buscarFechaVacasPendientes($dataJob->idPersona);
        $response['period'] = $dias[1];
        $response['diasVacaciones'] = $dias[0];
        $response['diasSolicitados'] = $diasSolicitados;
        $response['diasRest'] = $diasRest;
        $response['periodoActual'] = $year;
        $response['months'] = $getMonths;

        $params = array("puntualidad" => true, "asistencia" => true, "prestamo" => true, "vacacion" => true, "calificacion" => true, "dias_vacaciones" => false, "permiso" => true, "incapacidad" => true, "sueldo" => true, "cambio_puesto" => false);

        foreach($params as $dp => $show){
            $this->verificarDetalle($dp, $dataJob->idPersona, $year);
            foreach($getMonths as $num => $name){

                $holydays = array_map(function($arr){ return $arr->diaNoLaboral;},$this->capitalhumano->getHolydays(array("YEAR(diaNoLaboral)" => $year, "MONTH(diaNoLaboral)" => $num)));
                $data = $this->filterDates($this->getDescripcion($dataJob->idPersona, $dp), $year, $num);
                $date1 = date("Y-m-d", mktime(0, 0, 0, $num, 1, $year));
                $date2 = date("Y-m-d", mktime(0, 0, 0, $num + 1, 0, $year));
                $filter = array();
                $lastDate = date("Y-m-d", mktime(0, 0, 0, $num + 1, 0, $year));
                $assistance = 0;
                $fouls = 0;
                $weekends = 0;

                if($year == date("Y")){
                    if($num == date("n")){
                        $lastDate = date("Y-m-d");

                    } elseif($num > date("n")){
                        $lastDate = 0;
                    }
                }

                foreach($data as $dd){

                    if(!in_array(date("l", strtotime($dd->fecha)), array("Sunday", "Saturday"))){
                        array_push($filter, $dd);
                    }
                }

                $onlyDates = array_map(function($arr){ return date("Y-m-d", strtotime($arr->fecha)); }, $filter);
                for($a = strtotime($date1); $a <= strtotime($date2); $a += 86400){
                    
                    if(!empty($lastDate) && $a <= strtotime($lastDate)){

                        if(in_array(date("Y-m-d", $a), $onlyDates) && !in_array(date("l", $a), array("Saturday", "Sunday"))){
                            $assistance ++;
                        } else{
                            if(!in_array(date("l", $a), array("Saturday", "Sunday")) && !in_array(date("Y-m-d", $a), $holydays)){
                                $fouls ++;
                            }
                        }
                    }

                    if(in_array(date("Y-m-d", $a), $holydays) && !in_array(date("l", $a), array("Saturday", "Sunday"))){
                        $weekends ++; 
                    }

                    if(in_array(date("l", $a), array("Saturday", "Sunday"))){
                        $weekends ++; 
                    }
                }

                $response["monthData"][$dp][$num]["data"] = $filter; //$this->filterDates($this->getDescripcion($dataJob->idPersona, $dp), $year, $num);
                $response["monthData"][$dp][$num]["weekends"] = $weekends;
                $response["monthData"][$dp][$num]["showCard"] = $show;
                //$response["monthData"][$dp][$num]["holydays"] = $holydays;
                $response["monthData"][$dp][$num]["assits"]["assistance"] = $assistance;
                $response["monthData"][$dp][$num]["assits"]["fouls"] = $fouls;
            }
        }

        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($_POST, TRUE));fclose($fp);
    }

    echo json_encode(array("status" => "success", "code" => 200, "data" => $response));
}
//----------------------------- //Dennis Castillo [2022-06-02]
function verificarDetalle($tipo, $person, $year){

    switch($tipo){
        case "prestamo": $this->verificarPrestamos($person, $year);
            break;
        case "vacacion": $this->verificarVacaciones($person, $year);
            break;
        case "calificacion": $this->verificarCalificaciones($person, $year);
            break;
        case "permisos": $this->verificarPermiso($person, $year);
            break;
        case "incapacidad": $this->verificarIncapacidad($person, $year);
            break;
        case "sueldo": $this->verificarSueldos($person, $year);
            break;
        case "cambio_puesto": 
            $puesto=$this->PersonaModelo->puestoDePersona($person);
            if(isset($puesto[0]->personaPuesto)){
                $puesto=$puesto[0]->personaPuesto;
                $this->actualizarCambioPuesto($person,$puesto,$year);
            }
            break;
    }
}
//-----------------------------
function getMonthComplete($params, $endDate, $day_, $param){

    $newParams = array();
    $monthComplete = array();
    $monthToIterate = explode("-", $endDate);
    $firstDay = date("Y-m-d", mktime(0, 0, 0, $monthToIterate[1], 1, $monthToIterate[0]));
    $fi = new DateTime($firstDay);
    $ff = new DateTime($endDate);
    $ff1 = $param ? $ff->modify("0 day") : $ff->modify("1 day");

    foreach($params as $k => $v){

        if(is_array($v) && !in_array($k, array("persona", "cargo"))){

            $newParams[$k] = !empty($v) 
            ? array_reduce($v, function($acc, $curr){
                    
                $date = explode(" ", $curr->fecha);
                array_push($acc, $date[0]);

                return $acc;
            }, array()) //, "hours" => array() 
            : array();
        }
    }

    foreach($newParams as $k => $v){

        $monthComplete[$k] = array();

        for($i = strtotime($fi->format("Y-m-d")); $i <= strtotime($ff1->format("Y-m-d")); $i += 86400){

            $day = array();
            $day["dia"] = date("d", $i);
            $day["show"] = date("d", $i) <= $day_ ? true : false;
            $day["finsemana"] = in_array(date("l", $i), array("Sunday", "Saturday")) ? true : false;
            $day["check"] = in_array(date("Y-m-d", $i), $v) ? true : false;

            array_push($monthComplete[$k], $day);
        }
    }

    return $monthComplete;
}
//-----------------------------
function filterDates($array, $year, $month){

    $response = array_filter($array, function($arr) use($month, $year){ 
        return date("n", strtotime($arr->fecha)) == $month && date("Y", strtotime($arr->fecha)) == $year;
    });

    return array_values($response);
}
//------------------------------- //Dennis Castillo [2022-04-16]
function takeMyAsistence(){
    
    //$dateArray = json_decode($_POST);
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($_POST, TRUE));fclose($fp);
    $toInsert = array();
    $params = array("asistencia", "puntualidad");

    if(!$_POST["punctuality"]){unset($params[1]);}

    foreach($params as $value){

        $childArray = array(
            "idPersona" => $this->tank_auth->get_idPersona(), 
            "fecha" => date("Y-m-d H:i:s", $_POST["timeNumber"]),
            "descripcion" => $value,
            "valor" => 1,
            "valor_ant" => null
        );

        array_push($toInsert, $childArray);
    }
    
    $insert = $this->PersonaModelo->insertAsistence($toInsert);

    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($toInsert, TRUE));fclose($fp);
    echo json_encode(array("bool" => $insert));
}
//------------------------------- //Dennis Castillo [2022-04-16]
function showModalAsistence(){

    $data = $this->filterDates($this->getDescripcion($this->tank_auth->get_idPersona(),'asistencia'), date("Y"), date("n"));
    $dateNow = array_filter($data, function($arr){ return date("d", strtotime($arr->fecha)) == date("d"); });
    $typePerson = $this->PersonaModelo->obtenerTipoPersona($this->tank_auth->get_idPersona());

    echo json_encode(array("records" => count($dateNow), "typePerson" => $typePerson));
}
//-------------------------------
function getAsistenceForInsertPunctuality(){

    $batch = array();
    $select1 = 'SELECT * FROM fastfile WHERE descripcion = "asistencia" AND DATE(fecha) = DATE(NOW()) AND HOUR(fecha) IN (8) AND MINUTE(fecha) BETWEEN 30 AND 59;';
    $query1 = $this->db->query($select1)->result_array();

    $select2 = 'SELECT * FROM fastfile WHERE descripcion = "asistencia" AND DATE(fecha) = DATE(NOW()) AND HOUR(fecha) IN (9) AND MINUTE(fecha) BETWEEN 0 AND 4;';
    $query2 = $this->db->query($select2)->result_array();

    $newArray = array_merge($query1,$query2);
    //var_dump($newArray);

    foreach($newArray as $rna){

        array_push($batch, array(
            "idPersona" => $rna["idPersona"], 
            "fecha" => date("Y-m-d H:i:s", strtotime($rna["fecha"])), 
            "descripcion" => "puntualidad", 
            "valor" => 1, 
            "valor_ant" => null
        ));
    }

    $this->db->trans_begin();
    $this->db->insert_batch("fastfile", $batch);

    if($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        echo "puntualidad registrado con éxito";
    }
    //var_dump($batch);
}
//------------------------------- //Dennis Castillo [2022-06-28]
function vacations(){

    switch($_SERVER["REQUEST_METHOD"]){
        case "POST": echo json_encode($this->genereateVacationRequest($_REQUEST)) ;
    }

    //echo json_encode();
}
//------------------------------- //Dennis Castillo [2022-06-28]
function createVacationRequest(){
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($_POST, TRUE));fclose($fp);
    echo json_encode($this->genereateVacationRequest($_POST, $_FILES));
}
//------------------------------- //Dennis Castillo [2022-06-28]
function genereateVacationRequest($data, $file){

    try{

        $dates = array();
        $additionalDays = 0;
        $daysPostEndDate = 0;
        $response = array();
        $countDays = $data["countDays"];
        $applyPastPeriod = filter_var($_POST["applyPastPeriods"], FILTER_VALIDATE_BOOLEAN);
        $firstDay = explode("/", $data["firstVacationDay"]);
        $initDate = strtotime(str_replace("/", "-", $data["firstVacationDay"]));
        $changeDate = strtotime(str_replace("/", "-", $data["periodchangeDate"]));
        $validRequest = !$applyPastPeriod ? $initDate >= $changeDate : false;
        $getUserData = $this->PersonaModelo->obtenerDatosUsers($this->tank_auth->get_idPersona()); //$this->tank_auth->get_idPersona()
        $boss = $this->PersonaModelo->obtenerJefe($this->tank_auth->get_idPersona());
        $holydays = array_reduce($this->capitalhumano->getHolydays(array("YEAR(diaNoLaboral) >=" => date("Y"))), function($acc, $curr){

            if(!in_array(date("n-j", strtotime($curr->diaNoLaboral)), $acc)){
                array_push($acc, date("n-j", strtotime($curr->diaNoLaboral)));
            }
    
            return $acc;
        }, array());
            
        $i_date = new DateTime(date("Y-m-d", mktime(0, 0, 0, $firstDay[1], $firstDay[0],$firstDay[2])));
        $e_date = new DateTime(date("Y-m-d", mktime(0, 0, 0, $firstDay[1], $firstDay[0],$firstDay[2])));
        $e_date = $e_date->modify("+".$countDays." day");
        
        //----------------------- //Second Alternative
        $secondAlternative = $this->getReturnVacationDate($countDays, $i_date->format("Y-m-d"), $e_date->format("Y-m-d"), $holydays);
        $returnDate = new DateTime($secondAlternative["returnDate"]);
        //-----------------------
        $toInsert = array(
            "idPersona" => $this->tank_auth->get_idPersona(), //$this->tank_auth->get_idPersona(),
            "nombre" => $getUserData->name_complete,
            "antiguedad" => $data["antiguedad"],
            "fecha_salida" => $i_date->format("Y-m-d"),
            "fecha_retorno" => $returnDate->modify("+".$daysPostEndDate." day")->format("Y-m-d"),
            "cantidad_dias" => $countDays,
            "fecha" => date("Y-m-d H:i:s"),
            "correoJefeDirecto" => $boss->email
        );

        //$validRequest2 = $this->validVacationRequest($toInsert["fecha_salida"], $toInsert["fecha_retorno"]); //Valida si la solicitud no interfiere con la siguiente en un lapso de 15 dias apartir de la fecha de retorno.
        //Insert processing
        if(!$validRequest){ //&& $validRequest2["success"]
            
            $insert = $this->capitalhumano->insertVacationRequest($toInsert); //Insert request
            $response["success"] = $insert["success"];
            $response["message"][] = $insert["success"] ? "Solicitud de vacación creado exitosamente" : "Ocurrió un detalle al momento de crear la solicitud.\nFavor de contactar al deparamento de sistemas.";

            if($insert["success"] === TRUE){ //Insert file in server.

                if($applyPastPeriod){
                    $response["message"][] = "Esta solicitud es de un periodo anterior. Por lo tanto, no se verá afectado en las solicitudes del periodo actual";
                }

                $validUpload = array();
                $directoy = array("root1" => "VACACIONES","root2" => "REF_".$insert["lastId"]);
                $upload = $this->uploadFileToServer($directoy, $file, $insert["lastId"]);
                array_push($validUpload, $upload);

                if($upload["success"]){

                    $insertRecord = $this->capitalhumano->insertVacationRecord(array( //Insert file record.
                        "name" => $upload["name"].".".$upload["extension"], //"solicitud_".$insert["lastId"],
                        "mime" => $file["uploadFormatVacation"]["type"],
                        "reference_id" => $insert["lastId"]
                    ));
                    array_push($validUpload, $insertRecord);

                    //Envío de notificación
                    $notification = $this->sendNotification(
                        array(array("idPersona" => $boss->idPersona, "email" => $boss->email)),  
                        $insert["lastId"],
                        "SOLICITUD_VACACION",
                        "SOLICITUD_VACACION"
                    );
                }

                //$response["message"][] = !in_array(false, $validUpload) ? "Archivo cargado correctamente" : "Ocurrió un problema con la carga de archivo. Favor de contactar al depto de sistemas.";
            }
        
        } else{
            $response["success"] = false;
            $response["message"][] = $validRequest ? "La fecha solicitada es igual o supera la fecha de cambio de periodo.\nPor favor solicite de nuevo pero con una fecha disponible antes del cambio de periodo" : $validRequest2["message"];
        }

        return $response;

    } catch(Exception $e){
        echo "Excepción capturada: ".$e->getMessage();
    }
}
//-------------------------------
function getReturnVacationDate($count, $iDate, $fDate, $holydays){

    $validDay = 0;
    $response["intervalDates"] = array();
    $f_date = new DateTime($fDate);
    $f_date = $f_date->modify("+ ".$count." day");

    for($a = strtotime($iDate); $a <= strtotime($f_date->modify("+ 1 month")->format("Y-m-d")); $a += 86400){

        if(in_array(date("N", $a), array(6,7))) continue;
        if(in_array(date("n-j", $a), $holydays)) continue;

        if($validDay < $count){
            $validDay ++;

        } elseif($validDay == $count){
            array_push($response["intervalDates"], date("Y-m-d", $a)); //Requerido para validación entre solicitudes.
            $response["returnDate"] = date("Y-m-d", $a);
            break;
        }
    }

    return $response; //array("returnDate" => $date_);
}
//-------------------------------
function validVacationRequest($initDate, $returnDate){

    $count = 0;
    $intervalDates = array();
    $r_date = new DateTime($returnDate);
    $r_date = $r_date->modify("+1 month");
    $getNextRequest = $this->capitalhumano->getVacationsRecords(array(
        "idPersona" => $this->tank_auth->get_idPersona(),
        "aprobado" => 0,
        "aprobado" => 1,
        "DATE(fecha_salida) >= " => $initDate,
    ));
    $validate = !empty($getNextRequest) ? $getNextRequest[0]->fecha_salida : null;
    $holydays = array_reduce($this->capitalhumano->getHolydays(array("YEAR(diaNoLaboral) >=" => date("Y"))), function($acc, $curr){

        if(!in_array(date("n-j", strtotime($curr->diaNoLaboral)), $acc)){
            array_push($acc, date("n-j", strtotime($curr->diaNoLaboral)));
        }

        return $acc;
    }, array());

    for($a = strtotime($initDate); $a < strtotime($returnDate); $a += 86400){ //Intervalo de día de vacaciones.

        if(!in_array(date("N", $a), array(6,7)) && !in_array(date("n-j", $a), $holydays)){
            array_push($intervalDates, date("Y-m-d", $a));
        }
    }

    for($a = strtotime($returnDate); $a <= strtotime($r_date->format("Y-m-d")); $a += 86400){ //Intervalo de días posterior al de vacaciones.

        if(!in_array(date("N", $a), array(6,7)) && !in_array(date("n-j", $a), $holydays) && $count < 15){
            array_push($intervalDates, date("Y-m-d", $a));
            $count ++;
        }
    }

    $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(array($intervalDates, $getNextRequest), TRUE));fclose($fp);
    return array(
        "success" => !in_array($validate, $intervalDates),
        "message" => !in_array($validate, $intervalDates) ? "" : "No es posible crear la solicitud por interferencia con otra.\nTiene que haber un intervalo de 15 dias entre solicitudes.\nSolicitud más próxima con fecha: ".date("d/m/Y", strtotime($getNextRequest[0]->fecha))."\nPrimer día de descanso: ".date("d/m/Y", strtotime($getNextRequest[0]->fecha_salida))."."
    );
}
//------------------------------- //Dennis Castillo [2022-06-28]
function updateVacation($id){

    $response = array();
    $arr = json_decode(file_get_contents("php://input"), true);
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($sendEmailMessage, TRUE));fclose($fp);

    $update = $this->capitalhumano->updateVacationRecord(array("id" => $id), $arr["condition"]);

    $response["success"] = $update["success"];
    $response["message"][] = $update["success"] ? "Registro actualizado con éxito." : "Ocurrió un error al actualizar un registro. Favor de contactar al depto de sistemas";

    if($update && $arr["options"]["mail"]){
        $sendMsg = $this->sendMailNotification($id); //Envía notificación de resultado.

        if($arr["condition"]["aprobado"] == 0){

            $preMail = $this->sendMailPreVacation($id, "mail"); //Si es aprobado, almacena la fecha de dos dias antes de salir de vacaciones.
        }

        array_push($response["message"], $sendMsg["message"]);
    }

    //if($arr["options"]["notification"] && $arr["condition"]["aprobado"] == 0){
        //$preMail = $this->sendMailPreVacation($id, "notification");
    //}

    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($arr, TRUE));fclose($fp);
    echo json_encode($response);
}
//------------------------------- //Dennis Castillo [2022-06-28]
function getVacationRequests($person = null, $showAll){

    $params = array();
    
    if(!empty($person)){
        $params["a.idPersona"] = $person;
    }

    if(!filter_var($showAll, FILTER_VALIDATE_BOOLEAN) == true){
        $fecha_actual = date("d-m-Y");
        $year= date("d-m-Y",strtotime($fecha_actual."- 2 year"));
        $params["YEAR(a.fecha_retorno) >="] = $year;
    }
    
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($params, TRUE));fclose($fp);
    $getList = $this->capitalhumano->getVacationList($params);
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($getList, TRUE));fclose($fp);

    echo json_encode($getList);
}
//------------------------------- //Dennis Castillo [2022-06-28]
function viewtest(){ //Función de prueba de vista

    $request = $this->capitalhumano->getVacationList(array("a.id" => 76));

    $this->load->view("persona/vacationResponse/vacationAlert", array("typeNotification" => "alert", "data" => $request[0]));
}
//------------------------------- //Dennis Castillo [2022-06-28]
function sendMailNotification($id){

    $request = $this->capitalhumano->getVacationList(array("a.id" => $id));
    $email = $this->PersonaModelo->obtenerEmail($request[0]->idPersona);
    $admins = array("CONTABILIDAD@AGENTECAPITAL.COM");
    //$isAdmin = in_array($this->tank_auth->get_usermail(), $admins);

    if($request[0]->aprobado == 0){

        foreach($admins as $valad){

            $toInsert = array(
                "desde" => "Avisos de GAP <sistemas@asesorescapital.com>",
                "para" => $valad,
                "asunto" => "Notificación de vacaciones",
                "mensaje" => $this->load->view("persona/vacationResponse/emailVacationResponse", array("data" => $request[0], "isAdmin" => true), true),
            );
        
            $insert = $this->capitalhumano->insertRegister("envio_correos", $toInsert);
        }
    }

    $toInsert = array(
        "desde" => "Avisos de GAP <sistemas@asesorescapital.com>",
        "para" => $email->email,
        "asunto" => "Notificación de vacaciones",
        "mensaje" => $this->load->view("persona/vacationResponse/emailVacationResponse", array("data" => $request[0], "isAdmin" => false), true),
    );

    $insert = $this->capitalhumano->insertRegister("envio_correos", $toInsert);

    return array(
        "success" => $insert,
        "message" => $insert ? "Correo de notificación enviado con éxito" : "Ocurrio un error con el envio del correo.\nError con folio: ".$id.".\nFavor de notificar a sistemas este folio a sistemas",
    );
}
//------------------------------- //Dennis Castillo [2022-06-28]
function sendMailPreVacation($id, $way){

    //Calcular dos dias laborales de anticiación  antes de salir de vacaciones.
    $request = $this->capitalhumano->getVacationList(array("a.id" => $id));
    $i_date = new DateTime(str_replace("/", "-", $request[0]->fecha_salida));
    $f_date = new DateTime(str_replace("/", "-", $request[0]->fecha_salida));
    $f_date = $f_date->modify("- 15 days");
    $countDays = 0;
    $valid = array();
    $holydays = $this->capitalhumano->getHolydays(array("YEAR(diaNoLaboral) >=" => date("Y")));
    $map = array_map(function($arr){ return date("n-j", strtotime($arr->diaNoLaboral));}, $holydays);

    for($a = strtotime($i_date->modify("- 1 day")->format("Y-m-d")); $a >= strtotime($f_date->format("Y-m-d")); $a -= 86400){

        if(!in_array(date("N", $a), array(6,7)) && !in_array( date("n-j", $a), $map) && $countDays < 2){
            array_push($valid, date("Y-m-d", $a));
            $countDays ++;
        }
    }

    $toInsert = array(
        "reference_id" => $id,
        "preSendDate" => end($valid),
        "dateInsert" => date("Y-m-d H:i:s"),
        "way" => $way
    );

    //$insert = $this->capitalhumano->insertRegister("pre_vacation_notification", $toInsert);
    $this->db->trans_begin();
    $this->db->where(array("reference_id" => $id, "way" => $way));
    $this->db->delete("pre_vacation_notification");
    $this->db->insert("pre_vacation_notification", $toInsert);

    if($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
    }
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(array("i" => $i_date->format("Y-m-d"), "f" => $f_date->format("Y-m-d"), "data" => $valid), TRUE));fclose($fp);

}
//----------------------------- //Dennis Castillo [2022-06-28]
function sendNotification($array, $newUser, $typeNotification, $reference){

    $us=array();
  
    foreach($array as $k => $v){
  
      $data_= new stdClass;
      $data_->idPersona = $v["idPersona"];
      $data_->email = $v["email"];
  
      array_push($us, $data_);
    }
    //$us[0]=$data_;
    //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($personName, TRUE));fclose($fp);
    $this->notificacionmodel->add($us, "email", "ENVIADO", $typeNotification, $reference, array("evaluacion_id" => $newUser));
  
    return 1;
}
//------------------------------- //Dennis Castillo [2022-07-20]
function getAvailableDaysOfPeriod(){

    $year = $_GET["year"];
    $pendingApply = filter_var($_GET["countPending"], FILTER_VALIDATE_BOOLEAN);
    $pendingApply_ = $pendingApply ? array(0,1) : array(0) ;
    $othersParams = array("antiguedad" => $year, "idPersona" => $this->tank_auth->get_idPersona());
    //$allParams = array_merge($othersParams, $pendingApply_);

    $getRequest = $this->capitalhumano->getPeriodRequest(array("antiguedad" => $year, "idPersona" => $this->tank_auth->get_idPersona()), $pendingApply_);
    $daysUsed = array_reduce($getRequest, function($acc, $curr){

        $acc += $curr->cantidad_dias;
        return $acc;
    }, 0);

    $getActualPeriod = $this->capitalhumano->getVacationsDays(array("anio" => $year));
    $diff = $getActualPeriod->dias - $daysUsed;

    //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($allParams, TRUE));fclose($fp);
    echo json_encode(array("availableDays" => $diff));
}
//-------------------------------

//*** Miguel Jaime 13-01-2023 ***

function getAllConfigurationAsesoresOnline(){
    $mes=date('m');
    $year=date('Y');
    $sql= $query="SELECT user_miInfo.* from user_miInfo,persona where  user_miInfo.idPersona=persona.idPersona AND persona.bajaPersona=0 order by user_miInfo.apellidoP ASC";
    $result=$this->db->query($sql)->result();
    $fechaEnvio=date('Y-m-d h:m:s');
    $asunto="Notificación de Configuracion y Disponibilidad de Horario para la Atencion de Citas - Capital Seguros y Fianzas";
    $desde="Avisos GAP<avisos@agentecapital.com>";
   
    foreach($result as $row){
        $sw=0;
        $mesesConfigurados=0;
        $meses=0;
        $idPersona=$row->idPersona;
        $query="SELECT calendario_conf_capital.* FROM calendario_conf_capital WHERE idPersona='$idPersona'";
        $resultX=$this->db->query($query)->result();
        foreach($resultX as $rowX){
                $mesesConfigurados=$rowX->duracion;
                $mesConf=$rowX->mes;
                $yearConf=$rowX->year;
                $fechaConf=new DateTime($yearConf."-".$mesConf."-01 00:00:00");
                $fechaActual=new DateTime($fechaEnvio);
                $meses=$fechaConf->diff($fechaActual);
                $meses=$meses->m;
                if($meses<=$mesesConfigurados){
                    $sw=1;    
                }
        }
       
        if($sw==0){
            if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $row->emailUser)) {
                $para=$row->emailUser;
                $nombre=$row->nombre." ".$row->apellidop;
                $mensaje='<DOCTYPE html><html><body><table width="75%" align="center" style="border-width: 1px;padding: 3%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;font-family: arial;"><tr><td align="left" colspan="2"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" width="30%" style="margin-top: -8%;"></td></tr><tr><td>Saludos Cordiales estimado colaborador, '.$nombre.'<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Te recordamos realizar la respectiva configuración a traves de nuestro sistema V3 plus, de disponibilidad de horario en tu agenda para las citas de tus clientes por medio de la tarjeta digital.</td></tr></table></body></html>';
                     //Envio de correos
                    if($para!=""){
                        $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$para','$asunto','$fechaEnvio','$mensaje',0,'Notificacion')";
                        $rs=$this->db->query($sql);
                    }
            }        
        }
    }
}


//*** Miguel Jaime 07-02-2023 ***

function getNameUser($emailUser){
    $sql="SELECT * FROM user_miInfo WHERE emailUser='$emailUser'";
    $rs=$this->db->query($sql)->result();
    $name="";
    if($rs){
        $name=$rs[0]->nombre." ".$rs[0]->apellidop;
    }    
    return $name;
}

function getAvisosProspeccionCitas(){
    $ct_prospectos=0;
    $lbpropecto="prospecto";
    $lbpendiente="pendiente";
    $sql="SELECT * FROM clientes_actualiza WHERE EstadoActual!='DIMENSION' AND Nombre!='' AND apellidoP!='' AND  EMail1!='' AND  Telefono1!='' AND EstadoActual='PERFILADO' GROUP BY Usuario";
    $rs=$this->db->query($sql)->result();
    $ct=0;
    foreach($rs as $row){
        if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $row->Usuario)) {
            $ct++;
            $usuario=$row->Usuario;
            $query="SELECT * FROM clientes_actualiza WHERE EstadoActual!='DIMENSION' AND Nombre!='' AND apellidoP!='' AND  EMail1!='' AND  Telefono1!='' AND EstadoActual='PERFILADO' AND Usuario='$usuario'";

            $rs1=$this->db->query($query)->result();
            $table='<table border=0 style="width: 70%;font-size: 12px;font-family: arial;" cellpadding="2" cellspacing="0"><thead><tr style="text-align: left;"><td colspan="3"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" style="width: 20%"></td></tr><thead>';
            $table.='<tr style="background-color:#C0C0C0;text-align: left;"><th>Nombre y Apellido</th><th>Email</th><th>Ultima Fecha de Actualizacion</th></tr></thead><tbody>';
            foreach($rs1 as $row1){
                $table.='<tr><td>'.$row1->Nombre." ".$row1->ApellidoP.'</td><td>'.$row1->EMail1.'</td><td style="text-align: left">'.date("d-m-Y",strtotime($row1->fechaActualizacion)).'</td></tr>';
                $ct_prospectos++;
            }
            if($ct_prospectos>1){
                $lbpropecto="prospectos";
                 $lbpendiente="pendientes";
            }
            $table.='<tr><td colspan="3"><b>Nota: </b>Actualmente tienes <b>'.$ct_prospectos.' '.$lbpropecto.'</b> '.$lbpendiente.' por contactar y agendar una cita</td></tr>';
            $table.='</tbody></table>';

            //Envio de correo
            $fechaEnvio=date('Y-m-d h:m:s');
            $asunto="Notificación de Segumiento en Prospección - Capital Seguros y Fianzas";
            $desde="Avisos GAP<avisos@agentecapital.com>";
            $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$usuario','$asunto','$fechaEnvio','$table',0,'Notificacion')";
            //$rs=$this->db->query($sql);
            $ct_prospectos=0;
        }
    }
}

function getAvisosProspeccion(){
    $sql="SELECT Nombre, ApellidoP, Usuario FROM clientes_actualiza GROUP BY Usuario";
    $rs=$this->db->query($sql)->result();
    $ctSuspectos=0; $ctProspectos=0; $ctPerfilados=0; $ctContactado=0; $ctCerrados=0;
    foreach($rs as $row){
        if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $row->Usuario)) {
            $tabla='<table border=0 style="width: 60%;font-size: 12px;font-family: arial;" cellpadding="2" cellspacing="0"><thead><tr style="text-align: left;"><td colspan="2"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" style="width: 30%"></td></tr><thead>';
            $tabla.='<tr style="background-color:#C0C0C0;"><th colspan="2">RESUMEN SEMANAL DE MOVIMIENTOS EN SEGUIMIENTO DE PROSPECCIÓN</th></tr></thead><tbody>';
            $ctSuspectos=$this->getCountProspeccion($row->Usuario,'DIMENSION');
            $ctSuspectos+=$this->getCountProspeccion($row->Usuario,'SIN VENTA');
            $ctProspectos=$this->getCountProspeccion($row->Usuario,'PERFILADO');
            $ctPerfilados=$this->getCountProspeccion($row->Usuario,'PERFILADO');
            $ctContactado=$this->getCountProspeccion($row->Usuario,'CONTACTADO');
            $ctCotizados=$this->getCountProspeccion($row->Usuario,'COTIZADO');
            $ctCerrados=$this->getCountProspeccion($row->Usuario,'PAGADO');   
            $tabla.='<tr><td colspan="2"><b>USUARIO:  </b>'.$this->getNameUser($row->Usuario).' ('.$row->Usuario.')'.'</td></tr>';
            $tabla.='<tr><td style="width: 40%">SUSPECTOS: </td><td style="width: 60%"><b>'.$ctSuspectos.'</b></td></tr>';
            $tabla.='<tr><td>PROSPECTOS: </td><td><b>'.$ctProspectos.'</b></td></tr>';
            $tabla.='<tr><td>PERFILADOS: </td><td><b>'.$ctPerfilados.'</b></td></tr>';
            $tabla.='<tr><td>CONTACTADOS: </td><td><b>'.$ctContactado.'</b></td></tr>';
            $tabla.='<tr><td>COTIZADOS: </td><td><b>'.$ctCotizados.'</b></td></tr>';
            $tabla.='<tr><td>CERRADOS: </td><td><b>'.$ctCerrados.'</b></td></tr>';
            $tabla.='</tbody></table>'.'<br>';
            //Envio de correo
            $fechaEnvio=date('d-m-Y');
            $asunto="Resumen Semanal de Movimientos en Segumiento de Prospección - Capital Seguros y Fianzas";
            $desde="Avisos GAP<avisos@agentecapital.com>";
            $usuario=$row->Usuario;
            $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$usuario','$asunto','$fechaEnvio','$tabla',0,'Notificacion')";
            //$rs=$this->db->query($sql);
        }
    } 
}

function getCountProspeccion($EmailUser, $status){
    $query="SELECT COUNT(IDCli) as prospectos FROM clientes_actualiza WHERE  Nombre!='' AND  EMail1!='' AND  Telefono1!='' AND EstadoActual='$status' AND Usuario='$EmailUser'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->prospectos;
    }
    return $ct; 
}

//****** Miguel Jaime 28-02-2023

function nombreMes(){
    $monthNum=date('m');
    setlocale(LC_ALL, 'es_ES');
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $monthName = strftime('%B', $dateObj->getTimestamp());
    return strtoupper($monthName);
}

function getEfectuadaPrimaNeta($tipo,$fecha){
    $total=0;
    if($fecha==NULL){
        if($tipo==1){
            $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
            $rs=$this->db->query($sql)->result();
        $total=$rs[0]->total;
        }else{
            $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND  MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
            $rs=$this->db->query($sql)->result();
            $total=$rs[0]->total;
        }
    }else{
        $m=date('m',strtotime($fecha));
        $y=date('Y',strtotime($fecha));
        $d=date('d',strtotime($fecha));
        if($tipo==1){
            $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FDoctoPago)='$m'  AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";
            $rs=$this->db->query($sql)->result();
            $total=$rs[0]->total;
        }else{
            $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FDoctoPago)='$m'  AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";
            $rs=$this->db->query($sql)->result();
            $total=$rs[0]->total;
        }
    }
  return $total;
}

function getEfectuadaCountRecibos($tipo,$fecha){
  if($fecha==NULL){
      if($tipo==1){
        $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
      }else{
        $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
    }
  }else{
    $m=date('m',strtotime($fecha));
    $y=date('Y',strtotime($fecha));
    $d=date('d',strtotime($fecha));
    if($tipo==1){
        $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";
      }else{
        $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";
    }
  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}



function getTodaCobranzaPrimaNeta($tipo){
  if($tipo==1){
      $sql="SELECT (SUM(PrimaNeta)+ (SELECT if(SUM(PrimaNeta) is null,0,SUM(PrimaNeta)) FROM cobranza_efectuada WHERE RamosNombre='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado')";
  }else{
        $sql="SELECT (SUM(PrimaNeta)+ (SELECT if(SUM(PrimaNeta) is null,0,SUM(PrimaNeta)) FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado')";

  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}

function getDiaTodaCobranzaPrimaNeta($tipo,$fecha){
 $m=date('m',strtotime($fecha));
 $y=date('Y',strtotime($fecha));
 $d=date('d',strtotime($fecha));
  if($tipo==1){
      $sql="SELECT (SUM(PrimaNeta)+ (SELECT if(SUM(PrimaNeta) is null,0,SUM(PrimaNeta)) FROM cobranza_efectuada WHERE RamosNombre='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado') AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";
  }else{
        $sql="SELECT (SUM(PrimaNeta)+ (SELECT if(SUM(PrimaNeta) is null,0,SUM(PrimaNeta)) FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado') AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";

  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}


function getTodaCobranzaCountRecibos($tipo){
  if($tipo==1){
    $sql="SELECT (COUNT(*)+ (SELECT COUNT(*) FROM cobranza_efectuada WHERE RamosNombre='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado')";
  }else{
    $sql="SELECT (COUNT(*)+ (SELECT COUNT(*) FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado')";
  } 
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}

function getEfectuadaAnticipadaCobranzaPrimaNeta($tipo){
  $mes=date('m');
  $total=0;
  if($tipo==1){
    $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago)";
    $rs=$this->db->query($sql)->result();
    $total=$rs[0]->total;
  }else{
     $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago)";
     $rs=$this->db->query($sql)->result();
     $total=$rs[0]->total;
  }
  return $total;
}

function getDiaEfectuadaAnticipadaCobranzaPrimaNeta($tipo,$fecha){
 $m=date('m',strtotime($fecha));
 $y=date('Y',strtotime($fecha));
 $d=date('d',strtotime($fecha));
  if($tipo==1){
    $sql="SELECT sum(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";
    $rs=$this->db->query($sql)->result();
    $total=$rs[0]->total;
  }else{
     $sql="SELECT sum(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";
     $rs=$this->db->query($sql)->result();
     $total=$rs[0]->total;
  }
  return $total;
}

function getCanceladaCobranzaPrimaNeta($tipo){
  $total=0;
  if($tipo==1){
    $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Cancelado'";
    $rs=$this->db->query($sql)->result();
    $total=$rs[0]->total;
  }else{
     $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Cancelado'";
     $rs=$this->db->query($sql)->result();
     $total=$rs[0]->total;
  }
  return $total;
}

function getDiaCanceladaCobranzaPrimaNeta($tipo,$fecha){
 $m=date('m',strtotime($fecha));
 $y=date('Y',strtotime($fecha));
 $d=date('d',strtotime($fecha));
  $total=0;
  if($tipo==1){
    $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Cancelado' AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";
    $rs=$this->db->query($sql)->result();
    $rs=$this->db->query($sql)->result();
    $total=$rs[0]->total;
  }else{
     $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Cancelado' AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";
    $rs=$this->db->query($sql)->result();
     $rs=$this->db->query($sql)->result();
     $total=$rs[0]->total;
  }
   return $total;
}


function getEfectuadaAnticipadaCobranzaCountRecibos($tipo,$fecha){
    if($fecha==NULL){
      if($tipo==1){
        $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago) ";
      }else{
            $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago) ";
      }
    }else{
       $m=date('m',strtotime($fecha));
       $y=date('Y',strtotime($fecha));
       $d=date('d',strtotime($fecha));
        if($tipo==1){
            $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FechaDocto)='$m' AND YEAR(FechaDocto)='$y' AND DAY(FechaDocto)='$d'";
        }else{
            $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FechaDocto)='$m' AND YEAR(FechaDocto)='$y' AND DAY(FechaDocto)='$d'";
        }
    }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}

function getCanceladaCobranzaCountRecibos($tipo){
  if($tipo==1){
    $sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Cancelado'";
  }else{
     $sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Cancelado'";
  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}


function getReportDaily(){

    $hoy=date('d-m-Y');
    $ayer=strtotime("-1 day", strtotime($hoy));
    $ayer=date("d-m-Y", $ayer);
    $m=date('m');

    $nombreMesActual=$this->nombreMes();
    
    $ctProspectosLeadsGMM=$this->getCountProspectosLeadsDaily("http://www.capitalsegurosgmm.com");
    $ctProspectosLeadsFianzas=$this->getCountProspectosLeadsDaily("http://www.fianzascapital.com.mx");
    $ctProspectosPersona=$this->getCountProspectosDaily(0);
    $ctProspectosFianzas=$this->getCountProspectosDaily(1);
    $ctProspectosAgentes=$this->getCountProspectosAgentesDaily();
    $ctProspectosLeadsAgentes=$this->getCountProspectosLeadsDaily("");
    $ctProspectosLeadsFlotillas=$this->getCountProspectosLeadsDaily("https://flotillascapital.com");
    //Mensual
    $ctProspectosLeadsGMMMensual=$this->getCountProspectosLeadsMonth("http://www.capitalsegurosgmm.com");
    $ctProspectosLeadsFianzasMensual=$this->getCountProspectosLeadsMonth("http://www.fianzascapital.com.mx");
    $ctProspectosPersonaMensual=$this->getCountProspectosMonth(0);
    $ctProspectosFianzasMensual=$this->getCountProspectosMonth(1);
    $ctProspectosAgentesMensual=$this->getCountProspectosAgentesMonth();
    $ctProspectosLeadsAgentesMensual=$this->getCountProspectosLeadsMonth("");
    $ctProspectosLeadsFlotillasMensual=$this->getCountProspectosLeadsMonth("https://flotillascapital.com");



    $ctCotizados=$this->getCountDaily('COTIZADO');
    $ctEmitidos=$this->getCountDaily('EMITIDO');
    $ctCerrados=$this->getCountDaily('PAGADO');
    //Menual
    $ctCotizadosMensual=$this->getCountMonth('COTIZADO');
    $ctEmitidosMensual=$this->getCountMonth('EMITIDO');
    $ctCerradosMensual=$this->getCountMonth('PAGADO');

    $ctCruce=$this->getCountCruce();
    $ctReferido=$this->getCountReferido();
    //Mensual
    $ctCruceMensual=$this->getCountCruceMensual();
    $ctReferidoMensual=$this->getCountReferidoMensual();
   
    $numeroRecibosCobradosAyer=0;
    $numeroRecibosCobradosHoy=0;
    
    $totalPrimaNetaPendienteAyer=$this->getDiaTodaCobranzaPrimaNeta(1,$ayer)-($this->getDiaEfectuadaAnticipadaCobranzaPrimaNeta(1,$ayer)+$this->getDiaCanceladaCobranzaPrimaNeta(1,$ayer));
    $totalPrimaNetaPendienteHoy=$this->getDiaTodaCobranzaPrimaNeta(1,$hoy)-($this->getDiaEfectuadaAnticipadaCobranzaPrimaNeta(1,$hoy)+$this->getDiaCanceladaCobranzaPrimaNeta(1,$hoy));
    
    $numeroRecibosPendientesAyer=0;
    $numeroRecibosPendientesHoy=0;

    $totalAcumuladoFianzasMesPendiente=$this->getTodaCobranzaPrimaNeta(1)-($this->getEfectuadaAnticipadaCobranzaPrimaNeta(1)+$this->getCanceladaCobranzaPrimaNeta(1));
    $totalAcumuladoSegurosMesPendiente=$this->getTodaCobranzaPrimaNeta(0)-($this->getEfectuadaAnticipadaCobranzaPrimaNeta(0)+$this->getCanceladaCobranzaPrimaNeta(0));

    
    $numeroAcumuladoSegurosMesPendiente=$this->getTodaCobranzaCountRecibos(0);
    $numeroAcumuladoFianzasMesPendiente=$this->getTodaCobranzaCountRecibos(1) - $this->getEfectuadaAnticipadaCobranzaCountRecibos(1,NULL)-$this->getCanceladaCobranzaCountRecibos(1);

    $numeroAcumuladoSegurosMesPendienteAyer=0;
    $numeroAcumuladoFianzasMesPendienteAyer=0;

    $numeroAcumuladoSegurosMesPendienteHoy=0;
    $numeroAcumuladoFianzasMesPendienteHoy=0;

    $totalAcumuladoSegurosMesEfectuado=$this->getEfectuadaPrimaNeta(0,NULL);
    $totalAcumuladoFianzasMesEfectuado=$this->getEfectuadaPrimaNeta(1,NULL);
    $totalPrimaNetaSegurosCobradaAyer=$this->getEfectuadaPrimaNeta(0,$ayer);
    $totalPrimaNetaSegurosCobradaHoy=$this->getEfectuadaPrimaNeta(0,$hoy);
    $totalPrimaNetaFiazasCobradaAyer=$this->getEfectuadaPrimaNeta(1,$ayer);
    $totalPrimaNetaFiazasCobradaHoy=$this->getEfectuadaPrimaNeta(1,$hoy);

    $numeroAcumuladoSegurosMesEfectuado=$this->getEfectuadaCountRecibos(0,NULL);
    $numeroAcumuladoSegurosMesEfectuadoAyer=$this->getEfectuadaCountRecibos(0,$ayer);
    $numeroAcumuladoSegurosMesEfectuadoHoy=$this->getEfectuadaCountRecibos(0,$hoy);

    $numeroAcumuladoFianzasMesEfectuado=$this->getEfectuadaCountRecibos(1,NULL);
    $numeroAcumuladoFianzasMesEfectuadoAyer=$this->getEfectuadaCountRecibos(1,$ayer);
    $numeroAcumuladoFianzasMesEfectuadoHoy=$this->getEfectuadaCountRecibos(1,$hoy);

    $totalVentaNuevaSegurosAyer=$this->summarySalesNew($ayer,'Seguros');
    $totalVentaNuevaFianzasAyer=$this->summarySalesNew($ayer,'Fianzas');
    $totalVentaNuevaAgenteAyer=$this->summarySalesNew($ayer,'Agente');

    $totalVentaNuevaSegurosHoy=$this->summarySalesNew($hoy,'Seguros');
    $totalVentaNuevaFianzasHoy=$this->summarySalesNew($hoy,'Fianzas');
    $totalVentaNuevaAgenteHoy=$this->summarySalesNew($hoy,'Agente');


    $totalRenovacionesAyer=$this->sumaryRenovationNew($ayer);
    $totalRenovacionesHoy=$this->sumaryRenovationNew($hoy);


    $totalVentaAcumNuevaSeguros=$this->summaryAcumSalesNew('Seguros');
    $totalVentaAcumNuevaFianzas=$this->summaryAcumSalesNew('Fianzas');
    $totalVentaAcumNuevaAgente=$this->summaryAcumSalesNew('Agente');
    $totalAcumRenovacionNuevas=$this->sumaryAcumRenovationNew();
    
    

    $totalIngresoAyer=0;
    $totalIngresoHoy=0;

    
    //Encabezado de la tabla

    $tabla='<table border=0 style="width: 40%;font-size: 12px;font-family: arial;" cellpadding="2" cellspacing="0"><thead><tr style="text-align: left;"><td colspan="5"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" style="width: 25%"></td></tr><thead>';
    $tabla.='<tr style="background-color:#E6E6E6;"><th colspan="5">RESUMEN DIARIO DE MOVIMIENTOS OPERATIVOS PERIODO: '.$nombreMesActual.' '.$hoy.' </th></tr></thead><tbody>';
    
    //Seccion Prospeccion

    $tabla.='<tr style="background-color: #08298A;color:#fff"><td style="text-align: left"><b>PROSPECCION</b></td><td colspan="2"></td><td style="text-align: right"><b>HOY</b></td><td>ACUMULADO DEL MES</td></tr>';
    
    $tabla.='<tr style="background-color: #E6E6E6"><td colspan="5"><b>LEADS:</b></td></tr>';   
    $tabla.='<tr><td style="text-align: right">- Langing Page (Fianzas): </td><td colspan="2"></td><td style="text-align: right">'.$ctProspectosLeadsFianzas.'</td><td style="text-align: right">'.$ctProspectosLeadsFianzasMensual.'</td></tr>'; 
    $tabla.='<tr><td style="text-align: right">- Langing Page (Gmm): </td><td colspan="2"></td><td style="text-align: right">'.$ctProspectosLeadsGMM.'</td><td style="text-align: right">'.$ctProspectosLeadsGMMMensual.'</td></tr>';
      $tabla.='<tr><td style="text-align: right">- Langing Page (Agentes): </td><td colspan="2"></td><td style="text-align: right">'.$ctProspectosLeadsAgentes.'</td><td style="text-align: right">'.$ctProspectosLeadsAgentesMensual.'</td></tr>';
    $tabla.='<tr><td style="text-align: right">- Langing Page (Flotillas): </td><td colspan="2"></td><td style="text-align: right">'.$ctProspectosLeadsFlotillas.'</td><td style="text-align: right">'.$ctProspectosLeadsFlotillasMensual.'</td></tr>';
   $tabla.='<tr style="background-color: #E6E6E6"><td><b>CRUCE: </b></td><td colspan="2"></td><td style="text-align: right">'.$ctCruce.'</td><td style="text-align: right">'.$ctCruceMensual.'</td></tr>';
   $tabla.='<tr><td colspan="5">&nbsp;</td></tr>';
   $tabla.='<tr style="background-color: #E6E6E6"><td><b>REFERIDOS: </b></td><td colspan="2"></td><td style="text-align: right">'.$ctReferido.'</td><td style="text-align: right">'.$ctReferidoMensual.'</td></tr>';
   $tabla.='<tr><td colspan="5">&nbsp;</td></tr>';  
    $tabla.='<tr style="background-color: #E6E6E6"><td colspan="5"><b>PROSPECTOS:</b></td></tr>';   
    $tabla.='<tr><td style="text-align: right">- Fianzas: </td><td colspan="2"></td><td style="text-align: right">'.$ctProspectosFianzas.'</td><td style="text-align: right">'.$ctProspectosFianzasMensual.'</td></tr>';
    $tabla.='<tr><td style="text-align: right">- Persona: </td><td colspan="2"></td><td style="text-align: right">'.$ctProspectosPersona.'</td><td style="text-align: right">'.$ctProspectosPersonaMensual.'</td></tr>';
    $tabla.='<tr><td style="text-align: right">- Agentes: </td><td colspan="2"></td><td style="text-align: right">'.$ctProspectosAgentes.'</td><td style="text-align: right">'.$ctProspectosAgentesMensual.'</td></tr>';

    $tabla.='<tr><td colspan="5">&nbsp;</td></tr>';
    $tabla.='<tr style="background-color: #E6E6E6"><td><b>COTIZADOS: </b></td><td colspan="2"></td><td style="text-align: right">'.$ctCotizados.'</td><td style="text-align: right">'.$ctCotizadosMensual.'</td></tr>';

    $tabla.='<tr><td colspan="5">&nbsp;</td></tr>';

    $tabla.='<tr style="background-color: #E6E6E6"><td><b>EMITIDOS: </b></td><td colspan="2"></td><td style="text-align: right">'.$ctEmitidos.'</td><td style="text-align: right">'.$ctEmitidosMensual.'</td></tr>';

    $tabla.='<tr><td colspan="5">&nbsp;</td></tr>';
    
    $tabla.='<tr style="background-color: #E6E6E6"><td><b>CERRADOS:</b> </td><td colspan="2"></td><td style="text-align: right">'.$ctCerrados.'</td><td style="text-align: right">'.$ctCerradosMensual.'</td></tr>';
    $tabla.='<tr><td colspan="5"><hr></td></tr>';

    //Seccion Cobranza
 /*   
    $tabla.='<tr style="background-color: #08298A;color:#fff"><td style="text-align: left"><b>COBRANZAS</b></td><td colspan="4" style="text-align: right"></td></tr>';
    $tabla.='<tr style="background-color: #E6E6E6"><td></td><td style="text-align: right"><b>AYER </b></td><td  style="text-align: right"><b>HOY</b></td><td style="text-align:right;" colspan="2"><b>ACUMULADO DEL MES </b></td></tr>';


   
    $tabla.='<tr><td>Numero de recibos al cobro Fianzas: </td><td style="text-align: right">'.$numeroAcumuladoFianzasMesPendienteAyer.'</td><td style="text-align: right">'.$numeroAcumuladoFianzasMesPendienteHoy.'</td><td style="text-align: right;"></td><td style="text-align: right;">'.$numeroAcumuladoFianzasMesPendiente.'</td></tr>';
    
    $tabla.='<tr style="background-color: #E6E6E6"><td>Numero de recibos al cobro Seguros: </td><td style="text-align: right">'.$numeroAcumuladoSegurosMesPendienteAyer.'</td><td style="text-align: right">'.$numeroAcumuladoSegurosMesPendienteHoy.'</td><td style="text-align: right;"></td><td style="text-align: right;">'.$numeroAcumuladoSegurosMesPendiente.'</td></tr>';

    $tabla.='<tr><td>Prima neta por cobrar Fianzas: </td><td style="text-align: right">'.number_format($totalPrimaNetaPendienteAyer,2).'</td><td style="text-align: right">'.number_format($totalPrimaNetaPendienteHoy,2).'</td><td style="text-align: right;"></td><td style="text-align: right;">'.number_format($totalAcumuladoFianzasMesPendiente,2).'</td></tr>';
    
     $tabla.='<tr style="background-color: #E6E6E6"><td>Prima neta por cobrar Seguros: </td><td style="text-align: right">'.number_format($totalPrimaNetaPendienteAyer,2).'</td><td style="text-align: right">'.number_format($totalPrimaNetaPendienteHoy,2).'</td><td style="text-align: right;"></td><td style="text-align: right;">'.number_format($totalAcumuladoSegurosMesPendiente,2).'</td></tr>';

    $tabla.='<tr><td>Numero recibos cobrados Fianzas : </td><td style="text-align: right">'.$numeroAcumuladoFianzasMesEfectuadoAyer.'</td><td style="text-align: right">'.$numeroAcumuladoFianzasMesEfectuadoHoy.'</td><td style="text-align: right;"></td><td style="text-align: right;">'.$numeroAcumuladoFianzasMesEfectuado.'</td></tr>';

    $tabla.='<tr style="background-color: #E6E6E6"><td>Numero recibos cobrados Seguros : </td><td style="text-align: right">'.$numeroAcumuladoSegurosMesEfectuadoAyer.'</td><td style="text-align: right">'.$numeroAcumuladoSegurosMesEfectuadoHoy.'</td><td style="text-align: right;"></td><td style="text-align: right;">'.$numeroAcumuladoSegurosMesEfectuado.'</td></tr>';

    $tabla.='<tr style="background-color: #E6E6E6"><td>Prima neta cobrada Fianzas: </td><td style="text-align: right">'.number_format($totalPrimaNetaFiazasCobradaAyer,2).'</td><td style="text-align: right;">'.number_format($totalPrimaNetaFiazasCobradaHoy,2).'</td><td></td><td style="text-align: right;">'.number_format($totalAcumuladoFianzasMesEfectuado,2).'</td></tr>';

    $tabla.='<tr style="background-color: #E6E6E6"><td>Prima neta cobrada Seguros: </td><td style="text-align: right">'.number_format($totalPrimaNetaSegurosCobradaAyer,2).'</td><td style="text-align: right;">'.number_format($totalPrimaNetaSegurosCobradaHoy,2).'</td><td></td><td style="text-align: right;">'.number_format($totalAcumuladoSegurosMesEfectuado,2).'</td></tr>';

    //Seccion Venta

    $tabla.='<tr><td colspan="5"><hr></td></tr>';
    $tabla.='<tr style="background-color: #08298A;color:#fff"><td colspan="3" style="text-align: left"><b>COMISION VENTA NUEVA</b></td><td colspan="2" style="text-align: right">ACUMULADO DEL MES</td></tr>';
    $tabla.='<tr style="background-color: #E6E6E6"><td></td><td style="text-align: right;"><b>AYER: '.$ayer.' </b></td><td style="text-align: right"><b>HOY: '.$hoy.' </b></td><td style="text-align:center;" colspan="2"></td></tr>';
    $tabla.='<tr><td width="40%">Ingreso Total Seguros: </td><td style="text-align: right">'.number_format($totalVentaNuevaSegurosAyer,2).'</td><td style="text-align: right">'.number_format($totalVentaNuevaSegurosHoy,2).'</td><td></td><td style="text-align: right;">'.number_format($totalVentaAcumNuevaSeguros,2).'</td></tr>';

    $tabla.='<tr><td width="40%">Ingreso Total Fianzas: </td><td style="text-align: right">'.number_format($totalVentaNuevaFianzasAyer,2).'</td><td style="text-align: right">'.number_format($totalVentaNuevaFianzasHoy,2).'</td><td></td><td style="text-align: right;">'.number_format($totalVentaAcumNuevaFianzas,2).'</td></tr>';

    $tabla.='<tr><td width="40%">Ingreso Total Agentes: </td><td style="text-align: right">'.number_format($totalVentaNuevaAgenteAyer,2).'</td><td style="text-align: right">'.number_format($totalVentaNuevaAgenteHoy,2).'</td><td></td><td style="text-align: right;">'.number_format($totalVentaAcumNuevaAgente,2).'</td></tr>';

    $tabla.='<tr><td width="40%">Ingreso Total Renovaciones: </td><td style="text-align: right">'.number_format($totalRenovacionesAyer,2).'</td><td style="text-align: right">'.number_format($totalRenovacionesHoy,2).'</td><td></td><td style="text-align: right">'.number_format($totalAcumRenovacionNuevas,2).'</td></tr>';

    $totalIngresoAyer=$totalVentaNuevaSegurosAyer+$totalVentaNuevaFianzasAyer+$totalVentaNuevaFianzasAyer+$totalRenovacionesAyer;
    $totalIngresoHoy=$totalVentaNuevaSegurosHoy+$totalVentaNuevaFianzasHoy+$totalVentaNuevaAgenteHoy+$totalRenovacionesHoy;
    $totalIngresoAcum=$totalVentaAcumNuevaSeguros+$totalVentaAcumNuevaFianzas+$totalVentaAcumNuevaAgente+$totalAcumRenovacionNuevas;

    $tabla.='<tr><td colspan="5"><hr></td></tr>';
    $tabla.='<tr style="font-weight: bold"><td width="40%">Total Ingresos: </td><td style="text-align: right">'.number_format($totalIngresoAyer,2).'</td><td style="text-align: right">'.number_format($totalIngresoHoy,2).'</td><td></td><td style="text-align: right">'.number_format($totalIngresoAcum,2).'</td></tr>';
*/

    $tabla.='</tbody></table>'.'<br>';
    //Envio de correo
    //echo $tabla;
  
    $asunto="Efectividad de venta - Capital Seguros y Fianzas";
    $desde="Avisos GAP<avisos@agentecapital.com>";
    $fechaEnvio=date('Y-m-d h:m:s');
    
    //Cargar correo de la tabla de configuracion para envio de reporte de movimiento operativo Prospeccion/Cobranza - codigo: 1
    $items=$this->PermisoOperativo->getConfiguracionReportesDiarios(1);
    foreach($items as $item){
        $email=$item->correo;
        $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$email','$asunto','$fechaEnvio','$tabla',0,'Notificacion')";
        $rs=$this->db->query($sql);
    }

    //Test 
    //$sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','directorgeneral@agentecapital.com','$asunto','$fechaEnvio','$tabla',0,'Notificacion')";
    //$rs=$this->db->query($sql);
    //$sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','migueload@gmail.com','$asunto','$fechaEnvio','$tabla',0,'Notificacion')";
    //$rs=$this->db->query($sql);



} 



function getCountProspectosLeadsDaily($tipo){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $dia=date('d',strtotime($fecha));
    $query="SELECT COUNT(IDCli) as prospectos FROM clientes_actualiza WHERE  Nombre!=''  AND  EMail1!='' AND  Telefono1!=''  AND  MONTH(fechaCreacionCA)='$mes' AND YEAR(fechaCreacionCA)='$year' AND Day(fechaCreacionCA)='$dia' AND leads='$tipo'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->prospectos;
    }
    return $ct;
}
function getCountProspectosLeadsMonth($tipo){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $query="SELECT COUNT(IDCli) as prospectos FROM clientes_actualiza WHERE  Nombre!=''  AND  EMail1!='' AND  Telefono1!=''  AND  MONTH(fechaCreacionCA)='$mes' AND YEAR(fechaCreacionCA)='$year' AND leads='$tipo'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->prospectos;
    }
    return $ct;
}

function getCountProspectosDaily($tipo){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $dia=date('d',strtotime($fecha));
    $query="SELECT COUNT(IDCli) as prospectos FROM clientes_actualiza WHERE  Nombre!=''  AND  EMail1!='' AND  Telefono1!=''  AND  MONTH(fechaCreacionCA)='$mes' AND YEAR(fechaCreacionCA)='$year' AND Day(fechaCreacionCA)='$dia' AND tipo_prospecto='$tipo'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->prospectos;
    }
    return $ct;
}
function getCountProspectosMonth($tipo){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $query="SELECT COUNT(IDCli) as prospectos FROM clientes_actualiza WHERE  Nombre!=''  AND  EMail1!='' AND  Telefono1!=''  AND  MONTH(fechaCreacionCA)='$mes' AND YEAR(fechaCreacionCA)='$year' AND tipo_prospecto='$tipo'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->prospectos;
    }
    return $ct;
}

function getCountProspectosAgentesDaily(){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $dia=date('d',strtotime($fecha));
    $query="SELECT COUNT(id) as prospectos FROM prospectos_agentes WHERE  prospecto!='' AND  MONTH(fecha)='$mes' AND YEAR(fecha)='$year' AND Day(fecha)='$dia'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->prospectos;
    }
    return $ct;
}

function getCountProspectosAgentesMonth(){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $query="SELECT COUNT(id) as prospectos FROM prospectos_agentes WHERE  prospecto!='' AND  MONTH(fecha)='$mes' AND YEAR(fecha)='$year'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->prospectos;
    }
    return $ct;
}

function getCountCruce(){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $dia=date('d',strtotime($fecha));
    $query="SELECT COUNT(idInterno) as cruce FROM actividades WHERE  nombreCliente!=''  AND  MONTH(fechaCreacion)='$mes' AND YEAR(fechaCreacion)='$year' AND Day(fechaCreacion)='$dia' AND cruce_cartera='SI'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->cruce;
    }
    return $ct;
}

function getCountCruceMensual(){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $query="SELECT COUNT(idInterno) as cruce FROM actividades WHERE  nombreCliente!=''  AND  MONTH(fechaCreacion)='$mes' AND YEAR(fechaCreacion)='$year' AND cruce_cartera='SI'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->cruce;
    }
    return $ct;
}


function getCountReferido(){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $dia=date('d',strtotime($fecha));
    $query="SELECT COUNT(IDCli) as referido FROM clientes_actualiza WHERE  Nombre!=''  AND  EMail1!='' AND  Telefono1!=''  AND  MONTH(fechaCreacionCA)='$mes' AND YEAR(fechaCreacionCA)='$year' AND Day(fechaCreacionCA)='$dia' AND referido='SI'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->referido;
    }
    return $ct;
}

function getCountReferidoMensual(){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $query="SELECT COUNT(IDCli) as referido FROM clientes_actualiza WHERE  Nombre!=''  AND  EMail1!='' AND  Telefono1!=''  AND  MONTH(fechaCreacionCA)='$mes' AND YEAR(fechaCreacionCA)='$year' AND referido='SI'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->referido;
    }
    return $ct;
}


function getCountDaily($status){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $dia=date('d',strtotime($fecha));
    $query="SELECT COUNT(IDCli) as prospectos FROM clientes_actualiza WHERE  EstadoActual='$status'  AND  MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'  AND Day(fechaCreacionCA)='$dia'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->prospectos;
    }
    return $ct;
}

function getCountMonth($status){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $query="SELECT COUNT(IDCli) as prospectos FROM clientes_actualiza WHERE  EstadoActual='$status'  AND  MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'";
    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->prospectos;
    }
    return $ct;
}




function getNumerosAcumuladoMensual($status){
    $fecha=date('Y-m-d');
    $fechaInicio=date('Y-m-01');

    if($status=='Pendiente'){
        $query="SELECT COUNT(id) as total FROM cobranza_toda  WHERE FDesde BETWEEN '$fechaInicio' AND '$fecha' AND  Status_TXT='$status'";
    }
    if($status=='Efectuados'){
        $query="SELECT COUNT(id) as total FROM cobranza_efectuada WHERE FDoctoPago BETWEEN '$fechaInicio' AND '$fecha'";
    }

    $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->total;
    }
    return $ct;
}


//**** Venta Nueva****
function  summarySalesNew($fecha,$tipo){
    $m=date('m',strtotime($fecha));
    $y=date('Y',strtotime($fecha));
    $d=date('d',strtotime($fecha));
    
    if($tipo=='Seguros'){
        $query="SELECT SUM(Comision0) AS TOTAL0, SUM(Comision1) AS TOTAL1, SUM(Comision2) AS TOTAL2, SUM(Comision3) AS TOTAL3, SUM(Comision4) AS TOTAL4, SUM(Comision5) AS TOTAL5, SUM(Comision6) AS TOTAL6, SUM(Comision7) AS TOTAL7, SUM(Comision8) AS TOTAL8, SUM(Comision9) AS TOTAL9 FROM cobranza_efectuada WHERE renovacion=0 AND RamosNombre!='Fianzas' AND Moneda='Pesos Mexicanos' AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d'";

    }

    if($tipo=='Fianzas'){
        $query="SELECT SUM(Comision0) AS TOTAL0, SUM(Comision1) AS TOTAL1, SUM(Comision2) AS TOTAL2, SUM(Comision3) AS TOTAL3, SUM(Comision4) AS TOTAL4, SUM(Comision5) AS TOTAL5, SUM(Comision6) AS TOTAL6, SUM(Comision7) AS TOTAL7, SUM(Comision8) AS TOTAL8, SUM(Comision9) AS TOTAL9 FROM cobranza_efectuada WHERE renovacion=0 AND RamosNombre='Fianzas' AND Moneda='Pesos Mexicanos' AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d' ";
    }

    if($tipo=='Agente'){
        $query="SELECT SUM(Comision0) AS TOTAL0, SUM(Comision1) AS TOTAL1, SUM(Comision2) AS TOTAL2, SUM(Comision3) AS TOTAL3, SUM(Comision4) AS TOTAL4, SUM(Comision5) AS TOTAL5, SUM(Comision6) AS TOTAL6, SUM(Comision7) AS TOTAL7, SUM(Comision8) AS TOTAL8, SUM(Comision9) AS TOTAL9 FROM cobranza_efectuada WHERE renovacion=0 AND Moneda='Pesos Mexicanos' AND MONTH(FDoctoPago)='$m' AND YEAR(FDoctoPago)='$y' AND DAY(FDoctoPago)='$d' AND CCobro_TXT='$tipo'";
    }

    $rs=$this->db->query($query)->result();
    $total=0;
    if($rs){
        $total=$rs[0]->TOTAL0 + $rs[0]->TOTAL1 + $rs[0]->TOTAL2 + $rs[0]->TOTAL3 + $rs[0]->TOTAL4 + $rs[0]->TOTAL5 + $rs[0]->TOTAL6 + $rs[0]->TOTAL7 + $rs[0]->TOTAL8 + $rs[0]->TOTAL9;
    }
    return $total; 
}

function summaryAcumSalesNew($tipo){
    $fecha=date('d-m-Y');
    $m=date('m',strtotime($fecha));
    $y=date('Y',strtotime($fecha));
    
    if($tipo=='Seguros'){
        $query="SELECT SUM(Comision0) AS TOTAL0, SUM(Comision1) AS TOTAL1, SUM(Comision2) AS TOTAL2, SUM(Comision3) AS TOTAL3, SUM(Comision4) AS TOTAL4, SUM(Comision5) AS TOTAL5, SUM(Comision6) AS TOTAL6, SUM(Comision7) AS TOTAL7, SUM(Comision8) AS TOTAL8, SUM(Comision9) AS TOTAL9 FROM cobranza_efectuada WHERE renovacion=0 AND RamosNombre!='Fianzas' AND Moneda='Pesos Mexicanos' AND YEAR(FDoctoPago)='$y' AND MONTH(FDoctoPago)='$m'";

    }

    if($tipo=='Fianzas'){
        $query="SELECT SUM(Comision0) AS TOTAL0, SUM(Comision1) AS TOTAL1, SUM(Comision2) AS TOTAL2, SUM(Comision3) AS TOTAL3, SUM(Comision4) AS TOTAL4, SUM(Comision5) AS TOTAL5, SUM(Comision6) AS TOTAL6, SUM(Comision7) AS TOTAL7, SUM(Comision8) AS TOTAL8, SUM(Comision9) AS TOTAL9 FROM cobranza_efectuada WHERE renovacion=0 AND RamosNombre='Fianzas' AND Moneda='Pesos Mexicanos' AND YEAR(FDoctoPago)='$y' AND MONTH(FDoctoPago)='$m'";
    }

    if($tipo=="Agente"){
        $query="SELECT SUM(Comision0) AS TOTAL0, SUM(Comision1) AS TOTAL1, SUM(Comision2) AS TOTAL2, SUM(Comision3) AS TOTAL3, SUM(Comision4) AS TOTAL4, SUM(Comision5) AS TOTAL5, SUM(Comision6) AS TOTAL6, SUM(Comision7) AS TOTAL7, SUM(Comision8) AS TOTAL8, SUM(Comision9) AS TOTAL9 FROM cobranza_efectuada WHERE renovacion=0 AND Moneda='Pesos Mexicanos' AND YEAR(FDoctoPago)='$y' AND MONTH(FDoctoPago)='$m' AND CCobro_TXT='$tipo'";
    }

    $rs=$this->db->query($query)->result();
    $total=0;
    if($rs){
        $total=$rs[0]->TOTAL0 + $rs[0]->TOTAL1 + $rs[0]->TOTAL2 + $rs[0]->TOTAL3 + $rs[0]->TOTAL4 + $rs[0]->TOTAL5 + $rs[0]->TOTAL6 + $rs[0]->TOTAL7 + $rs[0]->TOTAL8 + $rs[0]->TOTAL9;
    }
    return $total; 

}

function sumaryRenovationNew($fecha){
    $fecha=date('d-m-Y',strtotime($fecha));
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $dia=date('d',strtotime($fecha));
    $query="SELECT SUM(PrimaTotal) as total FROM renovacion  WHERE DAY(FCaptura)='$dia' AND MONTH(FCaptura)='$mes' AND YEAR(FCaptura)='$year'";
     $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->total;
    }
    return $ct;
}

function sumaryAcumRenovationNew(){
    $fecha=date('d-m-Y');
    $year=date('Y',strtotime($fecha));
    $mes=date('m',strtotime($fecha));
    $query="SELECT SUM(PrimaTotal) as total FROM renovacion  WHERE MONTH(FCaptura)='$mes' AND YEAR(FCaptura)='$year'";
     $rs=$this->db->query($query)->result();
    $ct=0;
    if($rs){
        $ct=$rs[0]->total;
    }
    return $ct;
}


//Guardar Configuracion reporte Diario

function saveReporteDiario(){
    $correo=$_REQUEST['correo'];
    $reporte=$_REQUEST['reporte'];
    $sql="INSERT INTO config_reportes_diarios(correo,tipo) values('$correo','$reporte')";
    $rs=$this->db->query($sql);
    $this->data['items']=$this->PermisoOperativo->getConfiguracionReportesDiarios(1);
    $this->data['tipo']=$reporte;
    $this->load->view('permisosOperativos/listaReporteDiario',$this->data);
}
function delItemReporteDiario(){
    $id=$_REQUEST['id'];
    $reporte=$_REQUEST['reporte'];
    $sql="DELETE FROM config_reportes_diarios WHERE id='$id'";
    $rs=$this->db->query($sql);
    $this->data['items']=$this->PermisoOperativo->getConfiguracionReportesDiarios(1);
    $this->data['tipo']=$reporte;
    $this->load->view('permisosOperativos/listaReporteDiario',$this->data);
} 

//------------------------------- //Miguel Avila [2023-05-04]
function getviewPIP(){
    $this->load->model('pipmodel', 'pip');
    $puesto=$this->input->get('puesto');
    $persona=$this->pip->getUserByPuesto($puesto);
    $actualYear=date("Y");
    $pastYear=$actualYear-1;
    $years=array();
    $years[]=$actualYear;
    $years[]=$pastYear;
    $data['years']=$years;
    $data["pipsActual"] = $this->pip->getSeguimientoByEmpleadoByDate($persona->idPersona,$puesto,$actualYear);
    $data["pipsPast"] = $this->pip->getSeguimientoByEmpleadoByDate($persona->idPersona,$puesto,$pastYear);
    $this->load->view('evaluaciones/personas/mis_pip_fastFile', $data);
}
//--------------------------------
    //Consultas de asistencias para Data Center
    function ConsultarPorDia() {
        $email = $this->input->get('cr');
        $date = $this->input->get('dt');
        $present = $this->PersonaModelo->getAsistencia($email,$date);
        $puntuality = $this->PersonaModelo->getPuntualidad($email,$date);
        $result = array(
            "asistencia" => $present,
            "puntualidad" => $puntuality
        );
        echo json_encode($result);
    }
    
    //Consultar asistencias para reporte - Edwin Marin
        function ConsultarPorDiaReporte() {
        $date = $this->input->get('dt');
        $present = $this->PersonaModelo->getAsistenciaReporte($date,"asistencia");
        $out = $this->PersonaModelo->getAsistenciaReporte($date,"salida");
        $result = array(
            "asistencia" => $present,
            "salida" => $out,
        );
        echo json_encode($result);
    }
    function ConsultarPorQuincenaReporte() {
        $date1 = $this->input->get('dt1');
        $date2 = $this->input->get('dt2');
        $present = $this->PersonaModelo->getAsistenciaQuincenalReporte($date1,$date2,"asistencia");
        $out = $this->PersonaModelo->getAsistenciaQuincenalReporte($date1,$date2,"salida");
        $result = array(
            "asistencia" => $present,
            "salida" => $out,
        );
        echo json_encode($result);
    }

    function traerFiltroAsistencias(){
        $permiso=$this->input->get('permisos');
        if($permiso==1){
            $arrayColaboradores = $this->PersonaModelo->getNombresColaboradores(null);
        }else{
             $arrayColaboradores = $this->PersonaModelo->getNombresColaboradores($permiso);
        }
       
        $puestos=$this->PersonaModelo->getPuestosColaboradores();
        $areaColaborador=$this->PersonaModelo->getAreaColaboradores();
        $result = array(
            "nombres"=> $arrayColaboradores,
            "puestos"=> $puestos,
            "areaColaborador"=>$areaColaborador,
        );
        echo json_encode($result);
    }

    function ConsultarPorMes() {
        $email = $this->input->get('cr');
        $month = $this->input->get('dt');
        $year = date("Y");
        $present = $this->PersonaModelo->getAsistenciaPorMes($email,$month,$year);
        $puntuality = $this->PersonaModelo->getPuntualidadPorMes($email,$month,$year);
        $result = array(
            "asistencia" => $present,
            "puntualidad" => $puntuality
        );
        echo json_encode($result);
    }

    function ConsultaAnual() {
        $email = $this->input->get('cr');
        $year = $this->input->get('dt');
        $present = $this->PersonaModelo->getAsistenciaAnual($email,$year);
        $puntuality = $this->PersonaModelo->getPuntualidadAnual($email,$year);
        $result = array(
            "asistencia" => $present,
            "puntualidad" => $puntuality
        );
        echo json_encode($result);
    }

    function ConsultarAsistencia() {
        $email = $this->input->get('ml');
        $data = $this->PersonaModelo->ConsultInfoUser($email);
        $present = $this->PersonaModelo->ConsultAsistencia($email);
        $puntuality = $this->PersonaModelo->ConsultPuntualidad($email);
        $result = array(
            "info" => $data,
            "asistencia" => $present,
            "puntualidad" => $puntuality
        );
        echo json_encode($result);
    }
//-----------------------------------------------------------
function getAssistenceReport(){
        $date1 = $this->input->get('dt1');
        $date2 = $this->input->get('dt2');
		$permiso = $this->input->get('permiso');
        $present = $this->PersonaModelo->getAsistenciaQuincenalReporte($date1,$date2,"asistencia");
        $out = $this->PersonaModelo->getAsistenciaQuincenalReporte($date1,$date2,"salida");
        $vacations= $this->PersonaModelo->getVacaionesReporte($date1,$date2,"vacacion");
        $incapacidad= $this->PersonaModelo->getVacaionesReporte($date1,$date2,"incapacidad");
        $nolaborales = $this->buscarDiasNoLaborales();
		if($permiso==1){
            $colaboradores= $this->PersonaModelo->getNombresColaboradores(null);
        }else{
            $colaboradores= $this->PersonaModelo->getNombresColaboradores($permiso);
        }
        //Validar vacaciones e inhabiles
        $result = array(
            "asistencia" => $present,
            "salida" => $out,
            "colaboradores" => $colaboradores,
            "vacations" => $vacations,
            "nolaborales" => $nolaborales,
            "incapacidad" => $incapacidad,
        );
        echo json_encode($result);
}

//-----------------------------------------------------------
function getAssistenceReportSemanal($date1,$date2){

        $present = $this->PersonaModelo->getAsistenciaQuincenalReporte($date1,$date2,"asistencia");
        $out = $this->PersonaModelo->getAsistenciaQuincenalReporte($date1,$date2,"salida");
        $vacations= $this->PersonaModelo->getVacaionesReporte($date1,$date2,"vacacion");
        $incapacidad= $this->PersonaModelo->getVacaionesReporte($date1,$date2,"incapacidad");
        $nolaborales = $this->buscarDiasNoLaborales();
        
        //Validar vacaciones e inhabiles
        $result = array(
            "asistencia" => $present,
            "salida" => $out,
            "vacations" => $vacations,
            "nolaborales" => $nolaborales,
            "incapacidad" => $incapacidad,
        );
        return json_encode($result);
}
//-----------------------------------------------------------
function ReporteAsistenciaSemanal(){
    /*===FUNCION QUE SE DEBE EJECUTAR LOS LUNES A LAS 9 HORAS ENVIA REPORTE DE ASISTENCIAS A COORDINADORES Y GETENTES======*/
        $lastmonday = date("Y-m-d", strtotime("last week monday"));
        $lastfriday = date("Y-m-d", strtotime("last week friday"));
        //$lastmonday = "2025-12-23";
        //$lastfriday = "2025-12-27";
        //conultar a los gerentes y coordinadores y despues recorrer el arreglo solicitando la asistencia semanal
        $asistencia = $this->PersonaModelo->getAsistenciaQuincenalReporte($lastmonday,$lastfriday,"asistencia");
        $salida = $this->PersonaModelo->getAsistenciaQuincenalReporte($lastmonday,$lastfriday,"salida");
        $vacations= $this->PersonaModelo->getVacaionesReporte($lastmonday,$lastfriday,"vacacion");
        $incapacidad= $this->PersonaModelo->getVacaionesReporte($lastmonday,$lastfriday,"incapacidad");
        $diasnoLaborales = $this->buscarDiasNoLaborales();
        
         $fechaInicio=$lastmonday;
         $fechafin=$lastfriday;
         $fechaStart= new DateTime($fechaInicio." 00:00:00");
         $fechaEnd= new DateTime($fechafin." 00:00:00");
         $fechaAnteriorImpresa="";
         $fechaCurrent="";
         //print_r($assistence);
         //echo $lastmonday. " ". $lastfriday;
        $colaboradoresCordi = $this->PersonaModelo->getColaboradoresCordi();
        $assistenceSubordinados="noentro";
        //recorrer el arreglo
        foreach ($colaboradoresCordi as $c => $k) {
        $tabla='<h4>Asistencias de la semana del '.$fechaInicio.' al '.$fechafin.'</h4>
        <table id="for-export-day" >
                                        <thead>
                                            <tr id="thFecha-export-day">
                                                <th rowspan="2" class="text-center align-middle">Nombre</th>
                                                <th rowspan="2" class="text-center align-middle">Puesto</th>
                                                <th rowspan="2" class="text-center align-middle">Area</th>
                                            </tr>
                                            <tr id="trHora-export-day">
                                                <th class="text-center align-middle">Hora Entrada</th>
                                                <th class="text-center align-middle">Hora Salida</th>
                                                <th class="text-center align-middle">Hora Entrada</th>
                                                <th class="text-center align-middle">Hora Salida</th>
                                                <th class="text-center align-middle">Hora Entrada</th>
                                                <th class="text-center align-middle">Hora Salida</th>
                                                <th class="text-center align-middle">Hora Entrada</th>
                                                <th class="text-center align-middle">Hora Salida</th>
                                                <th class="text-center align-middle">Hora Entrada</th>
                                                <th class="text-center align-middle">Hora Salida</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-export-day">';
                           
        $assistenceSubordinados= $this->PersonaModelo->getColaboradoresSubordinados($k->idPuesto);
        if(count($assistenceSubordinados)==0){
           continue; 
       }
                foreach ($assistenceSubordinados as $a => $s) {
                     $semaforoColaborador="";
                $dateAnteriorImpresa="";
                $dateimpreso="";
                $fechaConsecuente="";
                $dateafter="";
                $diaconsecuente ="";
                $validFinde="";
                $ultimaFechaMes = date("Y-m-t", strtotime($fechaInicio));
                $ultimoDia = date("d", strtotime($ultimaFechaMes));
                $diaconsecuente = date("d", strtotime($fechaInicio))+1;
                if($diaconsecuente>$ultimoDia){
                    $mesUltFecha = date("m", strtotime($ultimaFechaMes));
                    if($mesUltFecha==12){
                        $dateafter = date("Y", strtotime($fechaInicio."+1 year"))."-01-01";
                $fechaConsecuente = new DateTime($dateafter." 00:00:00");
                    }else{
                        $dateafter = date("Y", strtotime($fechaInicio))."-".(date("m", strtotime($fechaInicio))+1)."-01";
                        $fechaConsecuente = new DateTime($dateafter." 00:00:00");
                    }
                }else{
                    $dateafter = date("Y", strtotime($fechaInicio))."-".(date("m", strtotime($fechaInicio)))."-".$diaconsecuente;
                    $fechaConsecuente = new DateTime($dateafter." 00:00:00");
                }
                
                $tabla .= '<tr><td>'.$s->nombre.'</td>
                                <td>'.$s->personaPuesto.'</td>
                                <td>'.$s->colaboradorArea.'</td>
                                ';
                                foreach ($asistencia as $h => $a) {
                                    if($s->id==$a->idPersona){
                                    $date = new DateTime($a->fecha);
                                    $horaEntrada=$date->format('H:i:s');
                                    if($date->getTimestamp()>=$fechaStart->getTimestamp() && $date->getTimestamp()<=$fechaConsecuente->getTimestamp()){
                                        if($date->getTimestamp()<=$fechaEnd->getTimestamp()){
                                            $fechaEntrada = date("d", strtotime($date->format('Y-m-d H:i:s')))."/".date("m", strtotime($date->format('Y-m-d H:i:s')))."/".date("Y", strtotime($date->format('Y-m-d H:i:s')));
                                            foreach ($salida as $t => $o) {
                                                $dateSalida = new DateTime($o->fecha);
                                                $semaforoSalida="";
                                                $fechaSalida = date("d", strtotime($dateSalida->format('Y-m-d H:i:s')))."/".date("m", strtotime($dateSalida->format('Y-m-d H:i:s')))."/".date("Y", strtotime($dateSalida->format('Y-m-d H:i:s')));
                                                 if($s->id==$o->idPersona){
                                                    if ($fechaEntrada==$fechaSalida) {
                                                        $horaSalida=$dateSalida->format('H:i:s');
                                                        $anteriorFecha= new DateTime($dateAnteriorImpresa);
                                            $fechaAnteriorImpresa=date("Y", strtotime($anteriorFecha->format('Y-m-d H:i:s')))."-".date("m", strtotime($anteriorFecha->format('Y-m-d H:i:s')))."-".date("d", strtotime($anteriorFecha->format('Y-m-d H:i:s')));
                                            $fechaCurrent=date("Y", strtotime($date->format('Y-m-d H:i:s')))."-".date("m", strtotime($date->format('Y-m-d H:i:s')))."-".date("d", strtotime($date->format('Y-m-d H:i:s')));
                                            if($fechaAnteriorImpresa!=$fechaCurrent){
                                                 $tabla.='<td>'.$horaEntrada.'</td><td>'.$horaSalida.'</td>';
                                                $semaforoSalida="entro";
                                                //poner otro semaforo
                                                $dateAnteriorImpresa=$date->format('Y-m-d H:i:s');
                                                $dateimpreso=$date->format('Y-m-d H:i:s');
                                                break;
                                            }
                                                       
                                                    }
                                                    
                                                 }
                                            }
                                            if ($semaforoSalida!="entro") {
                                                if ($dateAnteriorImpresa!="") {
                                                   if($fechaAnteriorImpresa!=$fechaCurrent){
                                                $tabla.='<td>'.$horaEntrada.'</td><td>S/R</td>';
                                                        $semaforoColaborador="entro";
                                                        //poner otro semaforo
                                                        $dateAnteriorImpresa=$date->format('Y-m-d H:i:s');
                                                        $dateimpreso=$date->format('Y-m-d H:i:s');
                                            }
                                                }else{
                                                    $tabla.='<td>'.$horaEntrada.'</td><td>S/R</td>';
                                                        $semaforoColaborador="entro";
                                                        //poner otro semaforo
                                                        $dateAnteriorImpresa=$date->format('Y-m-d H:i:s');
                                                        $dateimpreso=$date->format('Y-m-d H:i:s');
                                                }
                                            }
                                        }
                                        
                                $diaconsecuente = date("d", strtotime($fechaConsecuente->format('Y-m-d H:i:s')))+1;
                                if($diaconsecuente>$ultimoDia){
                                    $mesUltFecha = date("m", strtotime($ultimaFechaMes));
                                    if($mesUltFecha==12){
                                        $dateafter = date("Y", strtotime($fechaConsecuente->format('Y-m-d H:i:s')."+1 year"))."-01-01";
                                $fechaConsecuente = new DateTime($dateafter." 00:00:00");
                                    }else{
                                        $dateafter = date("Y", strtotime($fechaConsecuente->format('Y-m-d H:i:s')))."-".(date("m", strtotime($fechaConsecuente->format('Y-m-d H:i:s')))+1)."-01";
                                        $fechaConsecuente = new DateTime($dateafter." 00:00:00");
                                    }
                                }else{
                                    $dateafter = date("Y", strtotime($fechaConsecuente->format('Y-m-d H:i:s')))."-".date("m", strtotime($fechaConsecuente->format('Y-m-d H:i:s')))."-".$diaconsecuente;
                                    $fechaConsecuente = new DateTime($dateafter." 00:00:00");
                                }


                                    }else{
                                        if($date->getTimestamp()<=$fechaConsecuente->getTimestamp()){
                                            $fechaCurrent=date("d", strtotime($fechaConsecuente->format('Y-m-d H:i:s')))-1;
                                                for($fechaCurrent=0; $fechaCurrent < date("d", strtotime($date->format('Y-m-d H:i:s'))); $fechaCurrent++) { 
                                                    $month=date("m", strtotime($fechaStart->format('Y-m-d H:i:s')));
                                                    $fechaDia=date("Y", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".date("m", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".$fechaCurrent;
                                                    $fechacomplete = date("Y", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".date("m", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".$fechaCurrent." 00:00:00";
                                                    $validFinde = new DateTime($fechacomplete);
                                                    $semaforoVacaciones="";
                                                    $semaforoIncapacidad="";
                                                    if (!(date("w", strtotime($validFinde->format('Y-m-d H:i:s')))==6)||!(date("w", strtotime($validFinde->format('Y-m-d H:i:s')))==0)) {
                                                        foreach ($vacations as $h => $v) {
                                                            if ($s->id==$v->idPersona) {
                                                                $vacationsInicio = new DateTime($v->fecha);
                                                                $diaEnd = date("d", strtotime($vacationsInicio->format('Y-m-d H:i:s')))+intval($v->valor);
                                                                $dateVacasFin = date("Y", strtotime($vacationsInicio->format('Y-m-d H:i:s')))."-".date("m", strtotime($vacationsInicio->format('Y-m-d H:i:s')))."-".$diaEnd;
                                                                $vacationsFin = new DateTime($dateVacasFin);
                                                                if ($validFinde->getTimestamp()>=$vacationsInicio->getTimestamp() && $validFinde->getTimestamp()<$vacationsFin->getTimestamp()) {
                                                                    $tabla.='<td>V</td>
                                                                            <td>V</td>';
                                                                    $semaforoVacaciones="entro";
                                                                }
                                                            }
                                                        }
                                                        foreach ($incapacidad as $d => $i) {
                                                            if ($s->id==$i->idPersona) {
                                                                $incapacidadInicio = new DateTime($i->fecha);
                                                                $diaEnd = date("d", strtotime($incapacidadInicio->format('Y-m-d H:i:s')))+intval($i->valor);
                                                                $dateIncapFin = date("Y", strtotime($incapacidadInicio->format('Y-m-d H:i:s')))."-".date("m", strtotime($incapacidadInicio->format('Y-m-d H:i:s')))."-".$diaEnd;
                                                                $incapacidadFin = new DateTime($dateIncapFin);
                                                                if ($validFinde->getTimestamp()>=$incapacidadInicio->getTimestamp() && $validFinde->getTimestamp()<$incapacidadFin->getTimestamp()) {
                                                                    $tabla.='<td>I</td>
                                                                            <td>I</td>';
                                                                    $semaforoIncapacidad="entro";
                                                                }

                                                            }
                                                        }
                                                        if ($semaforoVacaciones!="entro" && $semaforoIncapacidad!="entro") {
                                                           $semaforoNolaboral="";
                                                           foreach ($diasnoLaborales as $m => $nl) {
                                                               if ($fechaDia==$nl->diaNoLaboral) {
                                                                   $tabla.='<td>DNL</td>
                                                                            <td>DNL</td>';
                                                                    $semaforoNolaboral="entro";
                                                               }
                                                           }
                                                           /*if ($semaforoNolaboral!="entro") {
                                                                $tabla.='<td>S/R</td>
                                                                            <td>S/R</td>';
                                                           }*/
                                                        }
                                                      
                                                    }else{
                                                        $tabla.='<td>S/R</td>
                                                                            <td>S/R</td>';
                                                    }
                                                }
                                        }
                                        $fechaEntrada = date("d", strtotime($date->format('Y-m-d H:i:s')))."/".date("m", strtotime($date->format('Y-m-d H:i:s')))."/".date("Y", strtotime($date->format('Y-m-d H:i:s')));
                                            foreach ($salida as $t => $o) {
                                                $dateSalida = new DateTime($o->fecha);
                                                $semaforoSalida="";
                                                $fechaSalida = date("d", strtotime($dateSalida->format('Y-m-d H:i:s')))."/".date("m", strtotime($dateSalida->format('Y-m-d H:i:s')))."/".date("Y", strtotime($dateSalida->format('Y-m-d H:i:s')));
                                                 if($s->id==$o->idPersona){
                                                    if ($fechaEntrada==$fechaSalida) {
                                                        $horaSalida=$dateSalida->format('H:i:s');
                                                        $anteriorFecha= new DateTime($dateAnteriorImpresa);
                                            $fechaAnteriorImpresa=date("Y", strtotime($anteriorFecha->format('Y-m-d H:i:s')))."-".date("m", strtotime($anteriorFecha->format('Y-m-d H:i:s')))."-".date("d", strtotime($anteriorFecha->format('Y-m-d H:i:s')));
                                            $fechaCurrent=date("Y", strtotime($date->format('Y-m-d H:i:s')))."-".date("m", strtotime($date->format('Y-m-d H:i:s')))."-".date("d", strtotime($date->format('Y-m-d H:i:s')));
                                            if($fechaAnteriorImpresa!=$fechaCurrent){
                                                 $tabla.='<td>'.$horaEntrada.'</td><td>'.$horaSalida.'</td>';
                                                $semaforoSalida="entro";
                                                //poner otro semaforo
                                                $dateAnteriorImpresa=$date->format('Y-m-d H:i:s');
                                                $dateimpreso=$date->format('Y-m-d H:i:s');
                                                break;
                                            }
                                                       
                                                    }
                                                    
                                                 }
                                            }
                                            if ($semaforoSalida!="entro") {
                                                if ($dateAnteriorImpresa!="") {
                                                   if($fechaAnteriorImpresa!=$fechaCurrent){
                                                $tabla.='<td>'.$horaEntrada.'</td><td>S/R</td>';
                                                        $semaforoColaborador="entro";
                                                        //poner otro semaforo
                                                        $dateAnteriorImpresa=$date->format('Y-m-d H:i:s');
                                                        $dateimpreso=$date->format('Y-m-d H:i:s');
                                            }
                                                }else{
                                                    $tabla.='<td>'.$horaEntrada.'</td><td>S/R</td>';
                                                        $semaforoColaborador="entro";
                                                        //poner otro semaforo
                                                        $dateAnteriorImpresa=$date->format('Y-m-d H:i:s');
                                                        $dateimpreso=$date->format('Y-m-d H:i:s');
                                                }
                                            }
                                $diaconsecuente = date("d", strtotime($date->format('Y-m-d H:i:s')))+1;
                                if($diaconsecuente>$ultimoDia){
                                    $mesUltFecha = date("m", strtotime($ultimaFechaMes));
                                    if($mesUltFecha==12){
                                        $dateafter = date("Y", strtotime($date->format('Y-m-d H:i:s')."+1 year"))."-01-01";
                                $fechaConsecuente = new DateTime($dateafter." 00:00:00");
                                    }else{
                                        $dateafter = date("Y", strtotime($date->format('Y-m-d H:i:s')))."-".(date("m", strtotime($date->format('Y-m-d H:i:s')))+1)."-01";
                                        $fechaConsecuente = new DateTime($dateafter." 00:00:00");
                                    }
                                }else{
                                    $dateafter = date("Y", strtotime($date->format('Y-m-d H:i:s')))."-".date("m", strtotime($date->format('Y-m-d H:i:s')))."-".$diaconsecuente;
                                    $fechaConsecuente = new DateTime($dateafter." 00:00:00");
                                }
                                    }
                                    $semaforoColaborador="entro";
                                    }

                                }
                                if ($semaforoColaborador!="entro") {
                                    $fechaCont=date("d", strtotime($fechaStart->format('Y-m-d H:i:s')))-1;
                                                for($fechaCont=0; $fechaCont < date("d", strtotime($fechaEnd->format('Y-m-d H:i:s'))); $fechaCont++) { 
                                                    $month=date("m", strtotime($fechaStart->format('Y-m-d H:i:s')));
                                                    $fechaDia=date("Y", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".date("m", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".$fechaCont;
                                                    $fechacomplete = date("Y", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".date("m", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".$fechaCont." 00:00:00";
                                                    $validFinde = new DateTime($fechacomplete);
                                                    $semaforoVacaciones="";
                                                    $semaforoIncapacidad="";
                                                    if (!(date("w", strtotime($validFinde->format('Y-m-d H:i:s')))==6)||!(date("w", strtotime($validFinde->format('Y-m-d H:i:s')))==0)) {
                                                        foreach ($vacations as $h => $v) {
                                                            if ($s->id==$v->idPersona) {
                                                                $vacationsInicio = new DateTime($v->fecha);
                                                                $diaEnd = date("d", strtotime($vacationsInicio->format('Y-m-d H:i:s')))+intval($v->valor);
                                                                $monthVacasdate=date("Y-m-t", strtotime($v->fecha));
                                                                $ultimoDayVaca = date("d", strtotime($monthVacasdate));
                                                                $vacationsFin ="";
                                                                if($diaEnd>$ultimoDayVaca){
                                                                    $diaEnd=$diaEnd-$ultimoDayVaca;
                                                                    $ultimoMonthVaca = date("m", strtotime($monthVacasdate));
                                                                    if ($ultimoMonthVaca==12) {
                                                                        $dateVacasFin = date("Y", strtotime($v->fecha."+1 year"))."-01-".$diaEnd;
                                                                        $vacationsFin = new DateTime($dateVacasFin." 00:00:00");
                                                                    }else{
                                                                        $dateVacasFin = date("Y", strtotime($v->fecha))."-".(date("m", strtotime($v->fecha))+1)."-".$diaEnd;
                                                                    $vacationsFin = new DateTime($dateVacasFin);
                                                                    }
                                                                }else{
                                                                    $dateVacasFin = date("Y", strtotime($vacationsInicio->format('Y-m-d H:i:s')))."-".date("m", strtotime($vacationsInicio->format('Y-m-d H:i:s')))."-".$diaEnd;
                                                                    
                                                                $vacationsFin = new DateTime($dateVacasFin);
                                                                }
                                                                
                                                                if ($validFinde->getTimestamp()>=$vacationsInicio->getTimestamp() && $validFinde->getTimestamp()<$vacationsFin->getTimestamp()) {
                                                                    $tabla.='<td>V</td>
                                                                            <td>V</td>';
                                                                    $semaforoVacaciones="entro";
                                                                }
                                                            }
                                                        }
                                                        foreach ($incapacidad as $d => $i) {
                                                            if ($s->id==$i->idPersona) {
                                                                $incapacidadInicio = new DateTime($i->fecha);
                                                                $diaEnd = date("d", strtotime($incapacidadInicio->format('Y-m-d H:i:s')))+intval($i->valor);
                                                                $dateIncapFin = date("Y", strtotime($incapacidadInicio->format('Y-m-d H:i:s')))."-".date("m", strtotime($incapacidadInicio->format('Y-m-d H:i:s')))."-".$diaEnd;
                                                                $incapacidadFin = new DateTime($dateIncapFin);
                                                                if ($validFinde->getTimestamp()>=$incapacidadInicio->getTimestamp() && $validFinde->getTimestamp()<$incapacidadFin->getTimestamp()) {
                                                                    $tabla.='<td>I</td>
                                                                            <td>I</td>';
                                                                    $semaforoIncapacidad="entro";
                                                                }

                                                            }
                                                        }
                                                        if ($semaforoVacaciones!="entro" && $semaforoIncapacidad!="entro") {
                                                           $semaforoNolaboral="";
                                                           foreach ($diasnoLaborales as $m => $nl) {
                                                               if ($fechaDia==$nl->diaNoLaboral) {
                                                                   $tabla.='<td>DNL</td>
                                                                            <td>DNL</td>';
                                                                    $semaforoNolaboral="entro";
                                                               }
                                                           }
                                                           /*if ($semaforoNolaboral!="entro") {
                                                                $tabla.='<td>S/R</td>
                                                                            <td>S/RLL</td>';
                                                           }*/
                                                        }
                                                      
                                                    }else{
                                                        $tabla.='<td>S/R</td>
                                                                            <td>S/R</td>';
                                                    }
                                                }
                                }else{
                                    $dtimp= new DateTime($dateimpreso);
                                    $fechaimpresa=date("Y", strtotime($dtimp->format('Y-m-d H:i:s')))."-".date("m", strtotime($dtimp->format('Y-m-d H:i:s')))."-".date("d", strtotime($dtimp->format('Y-m-d H:i:s')));
                                    if ($fechaimpresa!=$lastfriday) {
                                        $diaImp=date("d", strtotime($dtimp->format('Y-m-d H:i:s')))+1;
                                        if(intval($diaImp)>intval($ultimoDia)){
                                        $mesUltFecha = date("m", strtotime($ultimaFechaMes));
                                            if($mesUltFecha==12){
                                                $fechaAfterImpresa = date("Y", strtotime($dtimp->format('Y-m-d H:i:s')."+1 year"))."-01-01";
                                        $dtAftImp = new DateTime($fechaAfterImpresa." 00:00:00");
                                            }else{
                                                $fechaAfterImpresa = date("Y", strtotime($dtimp->format('Y-m-d H:i:s')))."-".(date("m", strtotime($dtimp->format('Y-m-d H:i:s')))+1)."-01";
                                                $dtAftImp = new DateTime($fechaAfterImpresa." 00:00:00");
                                            }
                                        }else{
                                             $fechaAfterImpresa=date("Y", strtotime($dtimp->format('Y-m-d H:i:s')))."-".date("m", strtotime($dtimp->format('Y-m-d H:i:s')))."-".$diaImp;
                                            $dtAftImp= new DateTime($fechaAfterImpresa." 00:00:00");
                                        }
                                        $fechaCont=date("d", strtotime($dtAftImp->format('Y-m-d H:i:s')))-1;
                                                for($fechaCont=0; $fechaCont < date("d", strtotime($fechaEnd->format('Y-m-d H:i:s'))); $fechaCont++) { 
                                                    $month=date("m", strtotime($fechaStart->format('Y-m-d H:i:s')));
                                                    $fechaDia=date("Y", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".date("m", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".$fechaCont;
                                                    $fechacomplete = date("Y", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".date("m", strtotime($fechaStart->format('Y-m-d H:i:s')))."-".$fechaCont." 00:00:00";
                                                    $validFinde = new DateTime($fechacomplete);
                                                    $semaforoVacaciones="";
                                                    $semaforoIncapacidad="";
                                                    if (!(date("w", strtotime($validFinde->format('Y-m-d H:i:s')))==6)||!(date("w", strtotime($validFinde->format('Y-m-d H:i:s')))==0)) {
                                                        foreach ($vacations as $h => $v) {
                                                            if ($s->id==$v->idPersona) {
                                                                $vacationsInicio = new DateTime($v->fecha);
                                                                $diaEnd = date("d", strtotime($vacationsInicio->format('Y-m-d H:i:s')))+intval($v->valor);
                                                                $dateVacasFin = date("Y", strtotime($vacationsInicio->format('Y-m-d H:i:s')))."-".date("m", strtotime($vacationsInicio->format('Y-m-d H:i:s')))."-".$diaEnd;
                                                                $vacationsFin = new DateTime($dateVacasFin);
                                                                if ($validFinde->getTimestamp()>=$vacationsInicio->getTimestamp() && $validFinde->getTimestamp()<$vacationsFin->getTimestamp()) {
                                                                    $tabla.='<td>V</td>
                                                                            <td>V</td>';
                                                                    $semaforoVacaciones="entro";
                                                                }
                                                            }
                                                        }
                                                        foreach ($incapacidad as $d => $i) {
                                                            if ($s->id==$i->idPersona) {
                                                                $incapacidadInicio = new DateTime($i->fecha);
                                                                $diaEnd = date("d", strtotime($incapacidadInicio->format('Y-m-d H:i:s')))+intval($i->valor);
                                                                $dateIncapFin = date("Y", strtotime($incapacidadInicio->format('Y-m-d H:i:s')))."-".date("m", strtotime($incapacidadInicio->format('Y-m-d H:i:s')))."-".$diaEnd;
                                                                $incapacidadFin = new DateTime($dateIncapFin);
                                                                if ($validFinde->getTimestamp()>=$incapacidadInicio->getTimestamp() && $validFinde->getTimestamp()<$incapacidadFin->getTimestamp()) {
                                                                    $tabla.='<td>I</td>
                                                                            <td>I</td>';
                                                                    $semaforoIncapacidad="entro";
                                                                }

                                                            }
                                                        }
                                                        if ($semaforoVacaciones!="entro" && $semaforoIncapacidad!="entro") {
                                                           $semaforoNolaboral="";
                                                           foreach ($diasnoLaborales as $m => $nl) {
                                                               if ($fechaDia==$nl->diaNoLaboral) {
                                                                   $tabla.='<td>DNL</td>
                                                                            <td>DNL</td>';
                                                                    $semaforoNolaboral="entro";
                                                               }
                                                           }
                                                           /*if ($semaforoNolaboral!="entro") {
                                                                $tabla.='<td>S/R</td>
                                                                            <td>S/R</td>';
                                                           }*/
                                                        }
                                                      
                                                    }else{
                                                        $tabla.='<td>S/R</td>
                                                                            <td>S/R</td>';
                                                    }
                                                }
                                    }
                                }

        }
        $tabla.='</tr></tbody></table>';
        //echo $tabla;
        $asunto="Asistencia semanal - Capital Seguros y Fianzas";
        $desde="Avisos GAP<avisos@agentecapital.com>";
        $fechaEnvio=date('Y-m-d h:m:s');
        $email=$k->email;
        if ($email!="") {
           $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$email','$asunto','$fechaEnvio','$tabla',0,'Notificacion')";
            $rs=$this->db->query($sql);
        }
        
    }

}

//-----------------------------------------------------------
function  tomarAsistenciaHuella()
{
 $respuesta=array();
 $respuesta['Mensaje']='';
 $respuesta['Nombre']='';
        if(isset($_POST['idPersona'])){
    $fecha=$this->db->query('select (CURRENT_TIMESTAMP()) as fecha,(year(CURRENT_TIMESTAMP())) as anio,(month(CURRENT_TIMESTAMP())) as mes,(day(CURRENT_TIMESTAMP())) as dia ,(hour(CURRENT_TIMESTAMP())) as hora , (minute(CURRENT_TIMESTAMP())) as minuto,(time(CURRENT_TIMESTAMP())) as horaCompleta,ELT(WEEKDAY(date(CURRENT_TIMESTAMP())) + 1, "entradaLunes", "entradaMartes", "entradaMiercoles", "entradaJueves", "entradaViernes", "entradaSabado", "entradaDomingo") AS diaSemana')->result()[0];
    $consultaAsis='select * from fastfile f where descripcion in ("asistencia","puntualidad") and (year(f.fecha))='.$fecha->anio.' and (month(f.fecha))='.$fecha->mes.' and (day(f.fecha))='.$fecha->dia.' and idPersona='.$_POST['idPersona'];
    $asistencia=$this->db->query($consultaAsis)->result();
    $respuesta['Mensaje']='';
    $nombreConsulta="select p.idPersona,p.nombres,p.apellidoPaterno,p.apellidoMaterno from persona p where p.idPersona=".$_POST['idPersona'];
    $nombre=$this->db->query($nombreConsulta)->result()[0];
    $respuesta['Nombre']=$nombre->nombres.' '.$nombre->apellidoPaterno.' '.$nombre->apellidoMaterno;
    if(count($asistencia)==0)
    {
      $insert['fecha']=$fecha->fecha;
      $insert['idPersona']=$_POST['idPersona'];
      $insert['valor']=1;
      $insert['descripcion']='asistencia';
      $this->db->insert('fastfile',$insert);
      $entradaConsulta="select (DATE_FORMAT(".$fecha->diaSemana.",'%H:%i:%S' )) as entrada from persona where idPersona=".$_POST['idPersona'];

      $entrada=$this->db->query($entradaConsulta)->result()[0];  
    
      if(strtotime($fecha->horaCompleta) < strtotime($entrada->entrada))
      {
       $insert['fecha']=$fecha->fecha;
       $insert['idPersona']=$_POST['idPersona'];
       $insert['valor']=1;
       $insert['descripcion']='puntualidad';
       $this->db->insert('fastfile',$insert);
       $respuesta['Mensaje']='PUNTUALIDAD Y';
      }
      $respuesta['Mensaje'].='ASISTENCIA HORA '.$fecha->fecha;
    }
    else
    {
      $salidaConsulta='select id from fastfile where descripcion="Salida" and year(fecha)='.$fecha->anio.' and month(fecha)='.$fecha->mes.' and day(fecha)='.$fecha->dia.' and idPersona='.$_POST['idPersona'];
      $salida=$this->db->query($salidaConsulta)->result();
      if(count($salida)==0)
      {
       $insert['fecha']=$fecha->fecha;
       $insert['idPersona']=$_POST['idPersona'];
       $insert['valor']=1;
       $insert['descripcion']='Salida';
       $this->db->insert('fastfile',$insert);        
       $respuesta['Mensaje']='SALIDA A LAS '.$fecha->fecha;
      }
      else
      {
         $update['fecha']=$fecha->fecha;
         $this->db->where('id',$salida[0]->id);
         $this->db->update('fastfile',$update);
          $respuesta['Mensaje']='SALIDA MODIFICADA A LAS '.$fecha->fecha;
      }
            }
        }
        echo json_encode($respuesta);
    }

//-----------------------------------------------------------------------------------------------------------
    function sueldos() { //Creado [Suemy][2024-03-01]
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
    }    
        else {
            $email = $this->tank_auth->get_usermail();
            $permission = 0;
            if ($email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "CAPITALHUMANO@AGENTECAPITAL.COM" || $email == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $email == "CONTABILIDAD@AGENTECAPITAL.COM") {
                $permission = 1;
            }
            $data['permission'] = $permission;
            $this->load->view('headers/header');
            $this->load->view('headers/menu');
            $this->load->view('persona/sueldos',$data);
            $this->load->view('footers/footer');
        }
    }

    function getSalaries() { //Creado [Suemy][2024-03-01]
        $idPersona = $this->tank_auth->get_idPersona();
        $email = $this->tank_auth->get_usermail();
        if ($email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "CAPITALHUMANO@AGENTECAPITAL.COM" || $email == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $email == "CONTABILIDAD@AGENTECAPITAL.COM") {
            $sql = "!= 0";
        }
        else {
            $sql = "= ".$idPersona;
        }
        $data = $this->PersonaModelo->consultSalaryRequest($sql);
        echo json_encode($data);
 }

    function getRequestHistory() { //Creado [Suemy][2024-03-01]
        $id = $this->input->get('id');
        $data = $this->PersonaModelo->consultRequestHistory($id);
        echo json_encode($data);
    }

    function saveSalaryRequestStatus() { //Creado [Suemy][2024-03-01]
        $id = $this->input->post('id');
        $user = $this->input->post('us');
        $money = $this->input->post('mn');
        $status = $this->input->post('st');
        $comment = $this->input->post('cm');
        $update = array(
            "importe_final" => $money,
            "motificado_por" => $user,
            "autorizado_por" => $user,
            "authorized" => date("Y-m-d H:i:s"),
            "modified" => date("Y-m-d H:i:s"),
            "estatus" => $status
        );
        $insert = array(
            "solicitud_sueldo_id" => $id,
            "motivo" => $comment,
            "empleado_id" => $user,
            "fecha" => date("Y-m-d H:i:s"),
            "estatus" => $status
        );
        $data['update'] = $this->PersonaModelo->updateStatusRequest($id,$update);
        $data['tracing'] = $this->PersonaModelo->insertTracingRequest($insert);
        echo json_encode($data);
    }

    function getEmployeeByBoss($idPersona) { //Creado [Suemy][2024-05-13]
        //Encontrar subordinados
        $email = $this->tank_auth->get_usermail();
        //$idPersona = $this->tank_auth->get_idPersona();
        $idPuesto = $this->db->query('select idPuesto from personapuesto where idPersona = '.$idPersona)->row()->idPuesto;
        $data = $this->db->query('SELECT idPuesto, idPersona, email FROM personapuesto WHERE statusPuesto = 1 AND padrePuesto = '.$idPuesto)->result();
       return $data;
    }
}
