<?php 
    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class ControlMetaComercial extends CI_Controller{

    function __construct(){
        parent::__construct();

        $this->load->model(array("personamodelo","metacomercial_modelo","crmproyecto_model","permisooperativo","email_model"));
        $this->load->library("FiltrosDeReportesSicas");
        $this->load->library("WS_Sicas");
        if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}
    }

    function index()
    {
        //$this->cargaInformacion();
        $this->load->view("controlMetaComercial/monitorMetaComercial");
        
    }
//-----------------------------------------------------------
    function cargaInformacion()
    {
                $persona = array("idPersona" => $this->tank_auth->get_idPersona(), "correo" => $this->tank_auth->get_usermail());
        $registro_canal = $this->metacomercial_modelo->devuelveCanalConsultaComercial();

        $data_to_view = array();               

        foreach($registro_canal as $d_r)
        {
       
            $idPersona = $this->personamodelo->obtenerIdPersonaPorEmail($d_r->correo);
            if(count($idPersona)>0)
           {
             $nombre_completo = $this->personamodelo->obtenerNombrePersona($idPersona->idPersona);
             $referencia = $d_r->tipo == "nuevo" ? "venta_nueva" : "ingreso_total";
            //$metas = $this->metacomercial_modelo->obtenerMetaAnualPorId($idPersona,$$d_r->idTipoComision);
             

             
             $data_to_view[$idPersona->idPersona]["correo"] = $d_r->correo;
             $data_to_view[$idPersona->idPersona]["nombre_completo"] = $nombre_completo;
             $data_to_view[$idPersona->idPersona]["metas_mensuales"][$referencia] = $this->devuelveMetaYComisionMensual($d_r->idUsuarioCanal, $idPersona->idPersona,$d_r->idTipoComision);
           }
        }

        $data["datosGeneral"]=$data_to_view;
        
       
        $this->load->view("controlMetaComercial/monitorMetaComercial", $data);
        

    }
//-----------------------------------------------------------

function devolverMetasComerciales()
{

        $persona = array("idPersona" => $this->tank_auth->get_idPersona(), "correo" => $this->tank_auth->get_usermail());
        $registro_canal = $this->metacomercial_modelo->devuelveCanalConsultaComercial();
   
        $data_to_view = array();               
        $canalesArray=array();
        $respuesta=array();
        $respuesta['canales']=array();
        $anio=date('Y');
       foreach($registro_canal as $val)
        {
           
          if($val->tipo=='total')
          {
            $canalesArray=array();
            $idPersona = $this->personamodelo->obtenerIdPersonaPorEmail($val->correo);
            $nombre_completo = $this->personamodelo->obtenerNombrePersona($idPersona->idPersona);
            $comisionesNewOld=$this->devuelveMetaYComisionMensualPorCanalDelEstadoFinanciero($val->idUsuarioCanal, $idPersona->idPersona,$val->idTipoComision,$val->canal,$anio);
             $canalesArray['correo']=$val->correo;
             $canalesArray['nombre_completo'] = $nombre_completo;
             $canalesArray['metas']=array();       
             $canalesArray['metas']=$comisionesNewOld;
             $canalesArray['canal']=$val->canal;
             array_push($respuesta['canales'],$canalesArray);
           
         
          }

        }
$respuesta['success']=true;
$respuesta['mesActual']=(integer)date('m');
$respuesta['anio']=$anio;

        echo json_encode($respuesta);
   
}

//-----------------------------------------------------------
    function devuelveMetaYComisionMensualPorCanalDelEstadoFinanciero($idCanal,$persona,$bandera,$canal,$anio='')
    {
        if($anio==''){$anio=date('Y');}
        $return_data = array();
        $metas = $this->metacomercial_modelo->obtenerMetaAnualPorId($persona,2);
        $metasVentaNueva = $this->metacomercial_modelo->obtenerMetaAnualPorId($persona,1); 

        if(!empty($metas))
        {
            $return_data["metaAnualVentaTotal"] = $metas->montoDeMetaComercial;
            $return_data["metaAnualVentaNueva"] = $metasVentaNueva->montoDeMetaComercial;
            $registros_mensuales = $this->metacomercial_modelo->obtenerMensualidadesDeMeta($metas->idMetaComercial,$persona,2);
            $registros_mensualesVentaNueva = $this->metacomercial_modelo->obtenerMensualidadesDeMeta($metasVentaNueva->idMetaComercial,$persona,1);
            $businessClousure = $this->metacomercial_modelo->devuelveActivacionComercial();   
            if(!empty($registros_mensuales))
            {
                foreach($registros_mensuales as $d_rm)
                {
                    
                     $return_data["mensualidales"][$d_rm->mes_num]["metaVentaTotalMes"] =$d_rm->monto_al_mes;
                     $return_data["mensualidales"][$d_rm->mes_num]["metaVentaNuevalMes"] =$registros_mensualesVentaNueva[$d_rm->mes_num-1]->monto_al_mes;

                    $return_data["mensualidales"][$d_rm->mes_num]["badge"] = $businessClousure[0]->mes_activado == $d_rm->mes_num ? true : false;
                    $comisiones=$this->metacomercial_modelo->comisionEstadoFinanciero($canal,'FechaDocto',$d_rm->mes_num,$anio,true,false);
                    $return_data["mensualidales"][$d_rm->mes_num]["comision"]=0;
                    $return_data["mensualidales"][$d_rm->mes_num]["comisionVentaNueva"]=$comisiones['ventaNueva'];
                    $return_data["mensualidales"][$d_rm->mes_num]["comisionVentaTotal"]=$comisiones['ventaTotal'];
                                        
                }
            }
        }
           
        return $return_data;
    }
    //---------------------------------------------------------------------------------
function devolverPolizas()
{
    $respuesta['success']=true;
     $respuesta['polizas']=$comisiones=$this->metacomercial_modelo->comisionEstadoFinanciero($_POST['canal'],'FechaDocto',$_POST['mes'],$_POST['anio'],false,true);
     echo json_encode($respuesta);
}


//-----------------------------------------------------------
    function devuelveMetaYComisionMensual($canal,$persona,$bandera)
    {

        $return_data = array();
        $metas = $this->metacomercial_modelo->obtenerMetaAnualPorId($persona,$bandera);
         
        if(!empty($metas))
        {
            $return_data["meta_asignada"] = $metas->montoDeMetaComercial;
            $registros_mensuales = $this->metacomercial_modelo->obtenerMensualidadesDeMeta($metas->idMetaComercial,$persona,$bandera);
            $businessClousure = $this->metacomercial_modelo->devuelveActivacionComercial();
            $closingGoal = $this->metacomercial_modelo->getGoalsForMonthAndYear($persona, $bandera, $businessClousure[0]->mes_activado, $businessClousure[0]->anio);
            $goal_ = !empty($closingGoal) ? $closingGoal->monto_al_mes : 0;
            //var_dump($closingGoal);
            if(!empty($registros_mensuales))
            {

                foreach($registros_mensuales as $d_rm)
                {

                    $comision = $businessClousure[0]->mes_activado == $d_rm->mes_num 
                        ? $this->metacomercial_modelo->devuelveComisionComercial($canal, $bandera, $businessClousure[0]->mes_activado, $businessClousure[0]->anio)
                        : $this->metacomercial_modelo->devuelveComisionComercial($canal, $bandera, $d_rm->mes_num, date("Y"));
                    //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($comision, TRUE));fclose($fp);
                    $return_data["mensualidales"][$d_rm->mes_num]["meta"] = $businessClousure[0]->mes_activado == $d_rm->mes_num ? $goal_ : $d_rm->monto_al_mes;
                    /* $return_data["mensualidales"][$d_rm->mes_num]["comision"] = !empty($comision) ? $comision->comision : 0; //$d_rm->monto_al_mes;
                    $return_data["mensualidales"][$d_rm->mes_num]["badge"] = $businessClousure[0]->mes_activado == $d_rm->mes_num ? true : false;
                    $return_data["mensualidales"][$d_rm->mes_num]["year"] = $businessClousure[0]->mes_activado == $d_rm->mes_num ? $businessClousure[0]->anio : date("Y");*/

                }
            }
        }
        
        return $return_data;
    }
    //---------------------------------------------------------------------------------
    function devuelveCantidadesMensuales($idMeta,$persona,$bandera){

        $datos_retorno = array();
        $metas = $this->metacomercial_modelo->obtenerMetaAnualPorId($persona,$bandera);
        $registros_mensuales = $this->metacomercial_modelo->obtenerMensualidadesDeMeta($idMeta,$persona,$bandera);

        $datos_retorno["meta_asignada"] = $metas->montoDeMetaComercial;

        if(!empty($registros_mensuales)){
            foreach($registros_mensuales as $datos){
                
                $datos_retorno["mensualidales"][$datos->mes_num]["comision"] = $bandera == 1 ? $datos->comision_subsecuente : $datos->comision_actual;
                $datos_retorno["mensualidales"][$datos->mes_num]["meta"] = $datos->monto_al_mes;
                $datos_retorno["mensualidales"][$datos->mes_num]["polizas"] = $datos->cantidad_polizas;
            }
        }

        return $datos_retorno;
    }
    //---------------------------------------------------------------------------------
    function consultaAvanceDeSicas(){

        $fecha_inicial = date("d-m-Y", mktime(0,0,0,$_GET["mes"],1,date("Y")));
        $fecha_final = date("d-m-Y", mktime(0,0,0,$_GET["mes"] + 1,0,date("Y")));

        $filtro_fechas["fechaInicial"] = $fecha_inicial;
        $filtro_fechas["fechaFinal"] = $fecha_final;

        $_reporte = $this->crmproyecto_model->devuelveDatosCobranzaPorComision($_GET["id"],1);
        $filtros = $this->filtrosdereportessicas->obtenerFiltro($_reporte->reporte,$_GET["reporte"],3);
        
        $filtro_completo = array_merge($filtro_fechas, $filtros);

        $concentrado_sicas = $this->ws_sicas->recibosClientes($filtro_completo);

        $comision_venta_nueva = 0;
        $comision_ingreso_total = 0;

        $prima_venta_nueva = 0;
        $prima_ingreso_total = 0;

        $recibos_venta_nueva = 0;
        $recibos_ingreso_total = 0;

        if(array_key_exists("TableInfo", $concentrado_sicas)){

            foreach($concentrado_sicas->TableInfo as $res){

                $comisionUnitaria = ((float)$res->Comision0+(float)$res->Comision1+(float)$res->Comision2+(float)$res->Comision3+(float)$res->Comision4+(float)$res->Comision5+(float)$res->Comision6+(float)$res->Comision7+(float)$res->Comision8+(float)$res->Comision9)*(Float)$res->TCPago;

                $comision_ingreso_total += $comisionUnitaria;
                $prima_ingreso_total += (Float)$res->PrimaNeta*(Float)$res->TCPago;
                $recibos_ingreso_total++;

                if((Int)$res->RenovacionDocto == 0 ){ //&& (Int)$res->Periodo == 1

                    $recibos_venta_nueva++;
                    $prima_venta_nueva += (Float)$res->PrimaNeta*(Float)$res->TCPago;
                    $comision_venta_nueva += $comisionUnitaria;
                }
            }
        }

        $array_response = array();
        $array_response["venta_nueva"]["comision"] = $comision_venta_nueva;
        $array_response["venta_nueva"]["prima"] = $prima_venta_nueva;
        $array_response["venta_nueva"]["recibos"] = $recibos_venta_nueva;

        $array_response["ingreso_total"]["comision"] = $comision_ingreso_total;
        $array_response["ingreso_total"]["prima"] = $prima_ingreso_total;
        $array_response["ingreso_total"]["recibos"] = $recibos_ingreso_total;
        
        $array_response['reporte'] = $_reporte;
        $array_response['filtros'] = $filtros;
        $array_response['filtro_completo'] = $filtro_completo;
        $array_response['concentrado_sicas'] = $concentrado_sicas;
        echo json_encode($array_response);
    }
    //---------------------------------------------------------------------------------
    /*function devuelveCantidadesMensuales_respaldo($meta,$idPersona,$email){

        $infoMensual=$this->metacomercial_modelo->obtenerMensualidadesDeMeta($meta,$idPersona);

        $ingresos=$this->personamodelo->obtenerIngresosTotalAgente($email);

        $resultado=array();
        $mensualidad=array();
        $cumulo=array();

        if(isset($infoMensual)){
            foreach($infoMensual as $mensualidades){
                foreach($ingresos as $datos){
                    if($datos->mesEAB==$mensualidades->mes_num){
                        //$mensualidad[$mensualidades->monto_al_mes]=$datos->ingresoTotal;
                        $b["monto"]=$mensualidades->monto_al_mes;
                        $b["ingresos"]=$datos->ingresoTotal;

                        $mensualidad[$mensualidades->mes_num]=$b;
                        array_push($cumulo,$datos->mesEAB);
                    }
                }
                if(!in_array($mensualidades->mes_num,$cumulo)){
                    $b["monto"]=$mensualidades->monto_al_mes;
                    $b["ingresos"]=0;

                    $mensualidad[$mensualidades->mes_num]=$b;
                }
            }
        }
        return $mensualidad;
    }*/

    //-------------------------------------------------------------------------------------------------
    //::::::::::::::::::::::::::::::: Envío de Reportes | Creado [Suemy][2024-03-21] :::::::::::::::::::::::::::::::
        //Inicio de la operación
        function getSelectedReportEmail() {
            //$this->load->model("permisooperativo", "PermisoOperativo"); //Creado [Suemy][2024-03-21]
            $data['result'] = array();
            $data['emails'] = $this->permisooperativo->getEmployeesOfReport();
            $con = $this->db->query('select us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona where pp.statusPuesto=1 and pp.idPersona != 0 and c.colaboradorArea = "Directivo"')->result();
            $data['consult'] = $con;
            foreach ($data['emails'] as $val) {
                $add['email'] = $val->correo;
                $add['reporte'] = $val->tipo;
                $method = 0;
                $coord = 0;
                foreach ($con as $row) {
                    if ($row->email == $val->correo) { $method = 1; }
                }
                if ($val->correo == "COORDINADOR@CAPCAPITAL.COM.MX" || $val->correo == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || $val->correo == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" || $val->correo == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM") { $coord = 1; }
                switch ($val->tipo) {
                    case '1':
                        # code...
                        break;        
                    case '2':
                        $sql = ' AND a.correo = "'.$val->correo.'"';
                        $agent = "";
                        if ($method == 1) { $sql = ""; }
                        if ($coord == 1) {
                            $agent = $this->CommercialAgentGoalReport($val->correo);
                        }
                        $message = $this->CommercialGoalReport($val->correo,$sql);
                        break;
                }
            }
        }
//-----------------------------------------------------------
        function CommercialGoalReport($email,$sql) {
            //$this->load->model("metacomercial_modelo"); //Creado [Suemy][2024-03-21]
            $table = "";
            $businessClousure = $this->metacomercial_modelo->devuelveActivacionComercial()[0];
            $con = $this->db->query('SELECT * FROM `consulta_comercial_tipo_comision`')->result();
            foreach ($con as $val) {
                $search = $val->idTipoComision.$sql;
                $report = $this->metacomercial_modelo->getReportType($search);
                if ($val->tipo == "nuevo") { $title = "VENTA NUEVA"; } else { $title = "INGRESO TOTAL"; }
                if (!empty($report)) {
                    $table .= '<br><div style="font-family:Oxygen, Helvetica neue, sans-serif;font-size: 13px;"><table border="1" style="background: #472380;text-align: center;border: 1px solid #472380;width: 100%;"><thead><tr style="background: #472380;"><th colspan="5" style="color:white;padding:8px;text-align:center;background: #543b7c;">'.$title.'</th></tr><tr style="background: #efefef;"><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">NOMBRE</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">EMAIL</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">META  IMPUESTA</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">COMISION</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">COMISION FALTANTE</th></tr></thead><tbody>';
                    foreach ($report as $row) {
                        $comision = $this->metacomercial_modelo->devuelveComisionComercial($row->idUsuarioCanal,$row->idTipoComision,$businessClousure->mes_activado,$businessClousure->anio);
                        $meta = $this->metacomercial_modelo->getGoalsForMonthAndYear($row->idPersona,$row->idTipoComision,$businessClousure->mes_activado,$businessClousure->anio);
                        $comission = !empty($comision) ? $comision->comision : 0;
                        $goal = !empty($meta) ? $meta->monto_al_mes: 0;
                        $missing = 0;
                        $color = "white";
                        if ($goal > $comission) { $missing = $goal - $comission; }
                        if ($goal <= $comission && $goal != 0) { $color = "#95cd95"; }
                        $table .= '<tr style="background: '.$color.';"><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$row->name_complete.'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$row->correo.'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($goal).'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($comission).'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($missing).'</td></tr>';
                    }
                    $table .= '</tbody></table><div style="display:flex;align-items: center;background: #ebebeb;color: #3d3d3d;"><div style="background: #95cd95;width: 13px;height: 13px;margin-left: 10px;border-radius: 3px;border: 1px solid green;"></div><p style="margin-bottom:0px;margin-left: 5px;">Meta Lograda</p></div><br>';
                }
            }
            $info['title'] = "Avance Meta Comercial";
            $info['message'] = $table;
            $message = !empty($table) ? $this->load->view('email/alert',$info,TRUE) : "";
            if (!empty($message)) {
                $this->sendEmailData("DESARROLLO@AGENTECAPITAL.COM",$info['title'],$message);
              #$this->sendEmailData($email,$info['title'],$message);
            }
        }
//-----------------------------------------------------------
        function CommercialAgentGoalReport($coord) {
            //$this->load->model("metacomercial_modelo"); //Creado [Suemy][2024-03-21]
            $data = array();
            $businessClousure = $this->metacomercial_modelo->devuelveActivacionComercial()[0];
            $agent = $this->db->query('select * from persona p left join users u on u.idPersona=p.idPersona where p.userEmailCreacion="'.$coord.'" and u.activated=1 and u.banned=0 and p.tipoPersona = 3')->result();
            if (!empty($agent)) {
                foreach ($agent as $val) {
                    $table = '<br><div style="font-family:Oxygen, Helvetica neue, sans-serif;font-size: 13px;"><table border="1" style="background: #472380;text-align: center;border: 1px solid #472380;width: 100%;"><thead><tr style="background: #472380;"><th colspan="5" style="color:white;padding:8px;text-align:center;background: #543b7c;">META COMERCIAL</th></tr><tr style="background: #efefef;"><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">NOMBRE</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">EMAIL</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">META</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">INGRESO</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">PORCENTAJE</th></tr></thead><tbody>';
                    $result = $this->ManageAgentsGoal(array("correo" => $val->email, "idPersona" => $val->idPersona),$businessClousure->mes_activado)[0];
                    $goal = 0;
                    $comission = 0;
                    $percentege = 0;
                    $color = "white";
                    if (!empty($result)) {
                        $goal = $result['monto_mes'];
                        $comission = $result['comision_venta_nueva'];
                        $percentege = $result['monto_mes'] > 0 && $result['comision_venta_nueva'] > 0 ? (100 * $result['comision_venta_nueva']) / $result['monto_mes'] : 0;
                        if ($result['monto_mes'] <= $result['comision_venta_nueva']) { $color = "#95cd95"; }
                    }
                    $table .= '<tr style="background: '.$color.';"><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$val->name_complete.'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$val->email.'</td><td style="padding: 5px; font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($goal).'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($comission).'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.number_format($percentege).'%</td></tr></tbody></table><div style="display:flex;align-items: center;background: #ebebeb;color: #3d3d3d;"><div style="background: #95cd95;width: 13px;height: 13px;margin-left: 10px;border-radius: 3px;border: 1px solid green;"></div><p style="margin-bottom:0px;margin-left: 5px;">Meta Lograda</p></div><br>';

                    $info['title'] = "Avance Meta Comercial";
                    $info['message'] = $table;
                    $message = !empty($table) ? $this->load->view('email/alert',$info,TRUE) : "";
                    if (strstr($val->email,'@')) {
                        $this->sendEmailData("DESARROLLO@AGENTECAPITAL.COM",$info['title'],$message);
                        #$this->sendEmailData($val->email,$info['title'],$message);
                    }
                }
            }
        }

        function ManageAgentsGoal($array_cuenta,$mes){
            //$this->load->model("metacomercial_modelo"); //Creado [Suemy][2024-03-21]
            $comisiones = $this->capsysdre->obtenerGananciaMensual($array_cuenta["correo"]);
            $_obtenerMetasMensuales=$this->metacomercial_modelo->devuelveMetasMensuales($array_cuenta["idPersona"]);

            $ingresos_mensuales = array();
            $validador_ingresos = array();

            for($a = 1; $a < 13; $a++){
                foreach($comisiones as $dd){
                    if($a == $dd->mesEAB){
                        $ingresos_mensuales[$dd->mesEAB]["comision_venta_nueva"] = $dd->comisionVentaEAB;
                        $ingresos_mensuales[$dd->mesEAB]["ingresos_totales"] = $dd->ingresoTotalesEAB;
                        array_push($validador_ingresos, $dd->mesEAB);
                    }
                }
                if(!in_array($a, $validador_ingresos)){
                    $ingresos_mensuales[$a]["comision_venta_nueva"] = 0;
                    $ingresos_mensuales[$a]["ingresos_totales"] = 0;
                }
            }

            $metaM=array();
            $validador=array();
            $arreglo = array();

            for($i=1; $i<13;$i++){
                foreach($_obtenerMetasMensuales as $meses){
                    if($i == $meses->mes){
                        $arreglo["venta_nueva"][$meses->mes]["monto_mes"]=$meses->montoMes;
                        $arreglo["venta_nueva"][$meses->mes]["comision_venta_nueva"] = $ingresos_mensuales[$meses->mes]["comision_venta_nueva"];
                        $arreglo["venta_nueva"][$meses->mes]["comision_ingreso_total"] = $ingresos_mensuales[$meses->mes]["ingresos_totales"];
                        array_push($validador,$meses->mes);
                    }
                }
                if(!in_array($i,$validador)){
                    if ($i == $mes) {
                        $add["mes"] = $i;
                        $add["monto_mes"] = 2500;
                        $add["comision_venta_nueva"] = $ingresos_mensuales[$i]["comision_venta_nueva"];
                        $add["comision_ingreso_total"] = $ingresos_mensuales[$i]["ingresos_totales"];
                        array_push($arreglo, $add);
                    }
                }
            }
            return $arreglo;
        }

        //Funciones extras: Envío por correo electrónico
        function sendEmailData($email,$subject,$message) {
            //$this->load->model('email_model'); //Creado [Suemy][2024-03-21]
            $email = array(
                "desde" => "Avisos de GAP <sistemas@asesorescapital.com>",
                "para" => $email,
                "asunto" => $subject,
                "mensaje" => $message,
                "status" => 0,
                "identificaModulo" => "",
                "fechaEnvio" => date("Y-m-d H:i:s")
            );
            $send = $this->email_model->SendEmail($email);
            return $send;
    }

        //Funciones extras: Convierte a formato monetario
        function formatMoney($num){
            return '$ '.number_format((Double)$num, 2, '.', ',');
        }
    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    //-------------------------------------------------------------------------------------------------

    }
?>