<?php 
    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class metacomercial extends CI_Controller{
        function __construct(){
            parent::__construct();

            $this->load->model(array("personamodelo","metacomercial_modelo"));
            $this->load->library("libreriaV3");

            if (!$this->tank_auth->is_logged_in()){
                redirect('/auth/login/');
            } 
        }

    function index(){

        $this->muestraInformacion();
    }
    //------------------------------------------------------------------------------------
    function muestraInformacion(){
        $infoDatos=$this->personamodelo->obtenerMetaComercialAnual($this->tank_auth->get_idPersona());
        $datosRamos=$this->metacomercial_modelo->informacionGeneralMetaRamo($this->tank_auth->get_idPersona(),null,"registro_meta_mensual_ramo_coordinador_generico");
        $agentesAsignados=$this->metacomercial_modelo->obtenerAsignadosMetasRamo($this->tank_auth->get_idPersona(),null);

        $datosMonto=array();
        $ramosMensuales=array();
        $agentesinfo=array();

        if(!empty($infoDatos)){
            
            $datosMonto=$this->personamodelo->devuelveMontosMensuales($infoDatos->idMetaComercial);
            
        }

        $personal=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($this->tank_auth->get_idPersona());

        if(!empty($datosRamos)){
            foreach($datosRamos as $val){
                array_push($ramosMensuales, $val->mes_asignado);
            }
        }

        if(!empty($agentesAsignados)){
            foreach($agentesAsignados as $v){
                $agentesinfo[$v->idPersona]["Nombre"]=$v->nombres." ".$v->apellidoPaterno." ".$v->apellidoMaterno;
                $agentesinfo[$v->idPersona]["Correo"]=$v->email;
            }
        }

        $datos["datosMontos"]=$datosMonto;
        $datos["datosEnRamos"]=array_values(array_unique($ramosMensuales)); //(!empty($datosRamos)) ? $datosRamos: array();
        $datos["datosPersonal"]=$personal;
        $datos["datosEnvioCorreo"]=$agentesinfo;

        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datos, TRUE));fclose($fp);

        $this->load->view("metacomercial/vistaMetaComercial",$datos);
    }
    //------------------------------------------------------------------------------------
    function devuelveMontos(){

        //echo $_GET["q"];

        $devuelveMontost=$this->personamodelo->regresaMontodelMes($_GET["q"],$_GET["r"], 1);
        $devuelveAgentesAsignados=$this->metacomercial_modelo->devuelveAgentesAsignados($_GET["q"], $this->tank_auth->get_usermail());

        $arregloMensual=array();

        if(!empty($devuelveMontost)){
            foreach($devuelveMontost as $datosMes){
                $arreglo["metaMensual"]=$datosMes->monto_al_mes;
                $arreglo["agentesAsignados"]=$devuelveAgentesAsignados;
                //$arreglo["asignacion"]=$datosMes->asignacion;
                

                $sumatoria_meta_asignado_agente=0;
                if(!empty($devuelveAgentesAsignados)){
                    foreach($devuelveAgentesAsignados as $aa){
                        $sumatoria_meta_asignado_agente+=$aa->montoMes;
                    }
                }
                $arreglo["metaYaAsignados"]=$sumatoria_meta_asignado_agente;
                array_push($arregloMensual,$arreglo);
            }    
        }
        
        $fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($arregloMensual, TRUE));fclose($fp);
 
        //echo $this->tank_auth->get_usermail();
        if(isset($arregloMensual)){
            echo json_encode($arregloMensual);
        } else{
            echo "No se realizó correctamente";
        }

    }
    //------------------------------------------------------------------------------------
    function insertaEnMensualidadCoor(){
        
        $mensualidad=json_decode($_GET["q"]);

        //echo $mensualidad;
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($mensualidad, TRUE));fclose($fp);

        foreach($mensualidad as $key=>$valor){
            if($valor!=""){
                $montoMES=array(
                    "mes_num"=>$key,
                    "monto_al_mes"=>$valor,
                    "idPersona"=>$_GET["r"]
                );

                $resultado=$this->personamodelo->insertaMontoMensualCoor($montoMES);
            }
        }
        echo $resultado; 
    }
    //-----------------------------------------------------------------------------------
    function almacenaMetaMensualAsignadasAgente(){
        
        //var_dump(json_decode($_REQUEST["asycData"]));

        $objeto=json_decode($_REQUEST["asycData"]);
        $fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($objeto, TRUE));fclose($fp);
        $agenteIterable=$objeto->agentes;

        $prueba=array();
        $resultado=false;

        $compruebaExistencia=$this->metacomercial_modelo->devuelveInfoAsignados($objeto->mes, date("Y"), $this->tank_auth->get_usermail());
       
        $agenteExiste=array();
        $exito=array();

        foreach($compruebaExistencia as $datos){
            array_push($agenteExiste, $datos->idPersona);
        }

        if(isset($agenteIterable)){
            foreach($agenteIterable as $datos){ //acceso al objeto.
                foreach($datos as $tipoAsigna=>$agentes){
                    //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($tipoAsigna, TRUE));fclose($fp);
                    foreach($agentes as $id=>$monto){
                        if($tipoAsigna=="nuevo"){
                            $vendedor=$this->personamodelo->obtenerIdVendedor($id);

                            if($monto->meta_agente_asignado>0 && !in_array($id,$agenteExiste)){
                                foreach($vendedor as $valor){
                                    $insert=array(
                                        "mes"=>$objeto->mes,
                                        "montoMes"=>$monto->meta_agente_asignado,
                                        "idPersona"=>$id,
                                        "idVend"=>$valor->IDVend,
                                        "email"=>$objeto->coordinador,
                                        "anio"=>date("Y"),
                                        "asignacion"=>$monto->tipo_asignacion
                                    );

                                    $inserta=$this->metacomercial_modelo->insertaMontosMensualesxAgente($insert);
                                    array_push($exito,$inserta);
                                }
                            }
                        } elseif($tipoAsigna=="renovacion" && $monto->meta_agente_asignado>0){
                            $update=array(
                                "mes"=>$objeto->mes,
                                "montoMes"=>$monto->meta_agente_asignado,
                                "idPersona"=>$id,
                                //"idVend"=>$valor->IDVend,
                                "email"=>$objeto->coordinador,
                                "anio"=>date("Y"),
                                "asignacion"=>$monto->tipo_asignacion
                            );

                            $update=$this->metacomercial_modelo->actualizaMontosMensualesxAgente($id,$objeto->mes,$objeto->coordinador,$update);
                            array_push($exito,$update);
                        }  
                    }
                }
            }
        }

        if(!in_array(false,$exito)){
            $resultado=true;
        }

        echo $resultado;
        /*if(isset($agenteIterable)){
            foreach($agenteIterable as $datos){
                foreach($datos as $agente=>$monto){
                    //array_push($prueba,$agente);
                    $vendedor=$this->personamodelo->obtenerIdVendedor($agente);

                    if($monto>0 && !in_array($agente,$agenteExiste)){
                        foreach($vendedor as $valor){
                            $insert=array(
                                "mes"=>$objeto->mes,
                                "montoMes"=>$monto,
                                "idPersona"=>$agente,
                                "idVend"=>$valor->IDVend,
                                "email"=>$objeto->coordinador,
                                "anio"=>date("Y")
                            );

                            $inserta=$this->metacomercial_modelo->insertaMontosMensualesxAgente($insert);
                            //array_push($prueba,$insert);
                        }
                    }
                }
            }
            echo $inserta;
        }*/
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($agenteIterable, TRUE));fclose($fp);
    }
    //-----------------------------------------------------------------------------------
    function eliminaAsignacion(){

        $respuesta=array();
        $valida_act=array();

        if(isset($_GET["q"]) || $_GET["r"]>0){

            //-------------
            //Proceso en caso de que se considere a un manual como dinamico (Si se elimina cambia de asignación de manual a dinamico).
            //Reasignación de montos a los agentes dinamicos.
             
            $agentesConMeta=$this->metacomercial_modelo->devuelveAgentesAsignados($_GET["r"], $this->tank_auth->get_usermail());

            if(!empty($agentesConMeta)){
                foreach($agentesConMeta as $aa){

                    $array_update=array();

                    if($aa->asignacion =="dinamico"){

                        $array_update["montoMes"]=$_GET["p"];
                        $array_update["asignacion"]="dinamico";

                        $up=$this->metacomercial_modelo->actualizaMontosMensualesxAgente($aa->idPersona, $_GET["r"], $this->tank_auth->get_usermail(), $array_update);
                        array_push($valida_act,$up);

                    } elseif($aa->idPersona==$_GET["q"] && $aa->asignacion =="manual"){
                      
                        $array_update["montoMes"]=$_GET["p"];
                        $array_update["asignacion"]="dinamico";

                        $up=$this->metacomercial_modelo->actualizaMontosMensualesxAgente($aa->idPersona, $_GET["r"], $this->tank_auth->get_usermail(), $array_update);
                         array_push($valida_act,$up);
                      
                    }
                }

                if(!in_array(false,$valida_act)){
                    $arreglo["mensaje"]="Registro eliminado. Se realizó cambio de asignación de meta a DINAMICO";
                    $arreglo["estado"]=true;
                } else{
                    $arreglo["mensaje"]="Ocurrió un error en la reasignación de metas. Contacte a sistemas.";
                    $arreglo["estado"]=false;
                }
            }
            //-------------
            //Descomentar en caso de eliminación de registro y reasignación de montos solo a dinamicos.

            /*$exito=$this->metacomercial_modelo->eliminaAsignacionMensual($_GET["q"],$_GET["r"]);
            $arreglo["estado"]=$exito;

            if($exito){
                $arreglo["mensaje"]="Registro eliminado correctamente";

                //Reasignación de montos a los agentes dinamicos.
                //--------------------
                    $agentesConMeta=$this->metacomercial_modelo->devuelveAgentesAsignados($_GET["r"], $this->tank_auth->get_usermail());

                    if(!empty($agentesConMeta)){
                        foreach($agentesConMeta as $aa){
                            if($aa->asignacion =="dinamico"){

                                $this->metacomercial_modelo->actualizaMontosMensualesxAgente($aa->idPersona,$_GET["r"],$this->tank_auth->get_usermail(),array("montoMes"=>$_GET["p"]));

                            }
                        }
                    }
                //--------------------

                
            } else{
                $arreglo["mensaje"]="Ocurrió un error al eliminar, intente mas tarde";

            } */



            array_push($respuesta,$arreglo);
        }

        if(empty($_GET["q"])){
            $arreglo["mensaje"]="No se recibieron datos";
            array_push($respuesta,$arreglo);
        }

        echo json_encode($respuesta);

    }
    //-----------------------------------------------------------------------------------
    function obtenerInfoEnRamosCoor(){

        $resultado=array();

        $select=$this->metacomercial_modelo->informacionGeneralMetaRamo($_GET["r"],$_GET["q"],"registro_meta_mensual_ramo_coordinador_generico");
        $asignados=$this->metacomercial_modelo->obtenerAsignadosMetasRamo($_GET["r"],$_GET["q"]);

        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($_GET["r"], TRUE));fclose($fp);

        if(!empty($select)){
            $resultado["mensaje"]="";

            foreach($select as $infoData){

                $resultado["montos"][$infoData->ramo]["polizas"]=$infoData->cantidad_polizas;
                $resultado["montos"][$infoData->ramo]["prima"]=$infoData->prima_polizas;
            }

            $cant_polizas_a=0;
            $cant_primas_a=0;

            if(!empty($asignados)){
                //$resultado["personalAsignado"][]
                foreach($asignados as $infoPersonal){
                    $resultado["personalAsignado"][$infoPersonal->idPersona]["nombre"]=$infoPersonal->nombres." ".$infoPersonal->apellidoPaterno." ".$infoPersonal->apellidoMaterno;
                    $resultado["personalAsignado"][$infoPersonal->idPersona]["correo"]=$infoPersonal->email;
                    $resultado["personalAsignado"][$infoPersonal->idPersona]["idVend"]=$infoPersonal->idVend;
                    $resultado["personalAsignado"][$infoPersonal->idPersona]["asignacion"]=$infoPersonal->asignacion;
                    $resultado["personalAsignado"][$infoPersonal->idPersona]["es_nuevo"]=$infoPersonal->reciente;
                    $resultado["personalAsignado"][$infoPersonal->idPersona]["ramo"][$infoPersonal->ramo]["polizas"]=number_format($infoPersonal->cantidad_polizas);
                    $resultado["personalAsignado"][$infoPersonal->idPersona]["ramo"][$infoPersonal->ramo]["prima"]=$infoPersonal->prima_polizas; //number_format($infoPersonal->prima_polizas);

                    $cant_polizas_a+=$infoPersonal->cantidad_polizas;
                    $cant_primas_a+=$infoPersonal->prima_polizas;

                    $resultado["montosYaAsignados"][$infoPersonal->ramo]["polizas"]=$cant_polizas_a;
                    $resultado["montosYaAsignados"][$infoPersonal->ramo]["prima"]=$cant_primas_a;
                }
            } else{
                $resultado["personalAsignado"]=array();
                //$resultado["mensaje"]="No se encontraron agentes con metas asignadas";
            }
        } else{
            $resultado["mensaje"]="No se encontraron resultados asignados";
        }

        $fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($resultado, TRUE));fclose($fp);

        echo json_encode($resultado);
    }
    //-----------------------------------------------------------------------------------
    function almacenaMetasRamosAgentes(){

        $data_ajax=json_decode($_REQUEST["send"]);

        $resultado=array();
        $validador=array();

        //$obtener_cantidad_asignados=$this->metacomercial_modelo->contador_registros_metas_ramo_agentes($data_ajax->mes, $data_ajax->ramo, $this->tank_auth->get_idPersona());
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($obtener_cantidad_asignados, TRUE));fclose($fp);

        foreach($data_ajax->asignacion as $asig=>$infoAgente){

            if(!empty($infoAgente)){
                foreach($infoAgente as $idPersona=>$infoRamo){

                    $array_insert=array();
                    $array_update=array();

                    foreach($infoRamo->ramos as $ramo=>$infoPolizas){

                        if($asig=="nuevo"){
                            $array_insert["idPersona"]=$idPersona;
                            $array_insert["mes_asignado"]=$infoRamo->mes;
                            $array_insert["ramo"]=$ramo;
                            $array_insert["cantidad_polizas"]=$infoPolizas->polizas;
                            $array_insert["prima_polizas"]=$infoPolizas->prima;
                            $array_insert["idCoor"]=$this->tank_auth->get_idPersona();
                            $array_insert["anio"]=date("Y");
                            $array_insert["asignacion"]=$infoPolizas->asignacion;
                            $array_insert["reciente"]=1;

                            $valida_existencia=$this->metacomercial_modelo->validaExitenciaRamo($array_insert,"id_meta_ramo_a","registro_meta_mensual_ramo_agente_generico");

                            if(empty($valida_existencia)){
                                $insert=$this->metacomercial_modelo->insertaMetaRamoAgente($array_insert);
                                array_push($validador, $insert);
                            }
                        } else{
                            $array_insert["idPersona"]=$idPersona;
                            $array_insert["mes_asignado"]=$infoRamo->mes;
                            $array_insert["ramo"]=$ramo;
                            $array_insert["anio"]=date("Y");
                            $array_insert["idCoor"]=$this->tank_auth->get_idPersona();

                            $array_update["cantidad_polizas"]=$infoPolizas->polizas;
                            $array_update["prima_polizas"]=$infoPolizas->prima;
                            $array_update["asignacion"]=$infoPolizas->asignacion;
                            $array_update["reciente"]=0;
                            
                            $update=$this->metacomercial_modelo->actualizaMetaRamoAgente($array_insert,$array_update);
                            array_push($validador, $update);
                        }
                    }
                }
            }
        }

        
        if(!in_array(false,$validador)){
            $resultado["mensaje"]="";
        } else{
            $resultado["mensaje"]="Hubo un problema en el proceso, favor de contactar al departamento de sistemas.";
        }

        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($resultado, TRUE));fclose($fp);
        echo json_encode($resultado);
    }
    //-----------------------------------------------------------------------------------
    function eliminaRegistroDeRamo(){

        $resultado=array();
        $agenteDatos=array();
        $val=array();
        $agenteDatos["idPersona"]=$_GET["q"];
        $agenteDatos["mes_asignado"]=$_GET["p"];
        $agenteDatos["ramo"]=$_GET["s"];

        $primaNuevaAsignada=0; //empty($_GET["b"]) ? 0 : $_GET["b"];
        $polizas_de_dinamicos=0; //empty($_GET["a"]) ? 0 : $_GET["a"];
        $polizasNuevaAsignada=1;
        $limite=0;
        $contador=0;

        //$delete=true;
        //$delete=$this->metacomercial_modelo->eliminarRegistroDeRamoAgente($_GET["q"],$_GET["r"],$_GET["p"],$_GET["s"]);
        if($_GET["band"] == 2){
            
            $datosAgenteAEliminar=$this->metacomercial_modelo->validaExitenciaRamo($agenteDatos, "*", "registro_meta_mensual_ramo_agente_generico");
            $personal=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($this->tank_auth->get_idPersona());

            if(!empty($datosAgenteAEliminar)){
                foreach($datosAgenteAEliminar as $dd){

                    $limite=$dd->cantidad_polizas; //Limite para asignar a nuevos agentes.
                    $polizas_de_dinamicos+=$dd->cantidad_polizas; //Nueva cantidad de polizas para resignación.
                    $primaNuevaAsignada+=$dd->prima_polizas; //$dd->cantidad_polizas; //Prima para el resto de agentes que no han tenido meta del ramo.

                    if($dd->asignacion == "manual"){
                        $primaNuevaAsignada+=$_GET["b"];
                        $polizas_de_dinamicos+=$_GET["a"];
                    } else{ //En caso de que sea dinamico solo asigna como prima y polizas el acumulado de todos los dinamicos de la tabla de asignaciones en vista.
                        $primaNuevaAsignada=$_GET["b"];
                        $polizas_de_dinamicos=$_GET["a"];
                    }
                }
            }

            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($primaNuevaAsignada, TRUE));fclose($fp);
            //---------------
            //Proceso de asignación a nuevos agentes descartando al agente de este método.
            foreach($personal as $aa){

                //$contador++;
                $agente_iteracion=array();
                $agente_iteracion["idPersona"]=$aa->idPersona;
                $agente_iteracion["mes_asignado"]=$_GET["p"];
                $agente_iteracion["ramo"]=$_GET["s"];

                $valida=$this->metacomercial_modelo->validaExitenciaRamo($agente_iteracion, "asignacion", "registro_meta_mensual_ramo_agente_generico");

                if(empty($valida) && $contador++ < $limite){ //toma a los primeros dos de la lista de agentes y asigna una meta dinamica

                    $array_insert["idPersona"]=$aa->idPersona;
                    $array_insert["mes_asignado"]=$_GET["p"];
                    $array_insert["ramo"]=$_GET["s"];
                    $array_insert["cantidad_polizas"]=1; //$primaNuevaAsignada;
                    $array_insert["prima_polizas"]=($primaNuevaAsignada/$polizas_de_dinamicos);
                    $array_insert["idCoor"]=$this->tank_auth->get_idPersona();
                    $array_insert["anio"]=date("Y");
                    $array_insert["asignacion"]="dinamico";
                    $array_insert["reciente"]=1;

                    $insert=$this->metacomercial_modelo->insertaMetaRamoAgente($array_insert);
                    array_push($val,$insert);

                } elseif(!empty($valida)){ //&& $valida=="dinamico" //Si existe en al lista de asignados.

                    foreach($valida as $asig){

                        $array_insert["idPersona"]=$aa->idPersona;
                        $array_insert["mes_asignado"]=$_GET["p"];
                        $array_insert["ramo"]=$_GET["s"];
                        $array_insert["idCoor"]=$this->tank_auth->get_idPersona();

                        if($asig->asignacion=="dinamico"){ //Valida que la nueva actualización sea solo a los dinamicos.

                            $array_update["cantidad_polizas"]=1;
                            $array_update["prima_polizas"]=($primaNuevaAsignada/$polizas_de_dinamicos);
                            $array_update["reciente"]=0;

                            $update=$this->metacomercial_modelo->actualizaMetaRamoAgente($array_insert,$array_update); //Actualiza los registros
                            array_push($val,$update);

                        } else{ //En caso de que no (sea manual) solo actualiza reciente a 0;

                            $array_update_["reciente"]=0;

                            $update=$this->metacomercial_modelo->actualizaMetaRamoAgente($array_insert,$array_update_); //Actualiza los registros
                            array_push($val,$update);
                        }
                    }
                }
            }

            if(!in_array(false,$val)){ //Cuando concluya la reasignación elimina el registro seleccionado.
                $delete=$this->metacomercial_modelo->eliminarRegistroDeRamoAgente($_GET["q"],$_GET["r"],$_GET["p"],$_GET["s"]);
                //$delete=false;
            } else{
                $delete=false;
            }

            //--------------
        } elseif($_GET["band"] == 1){

            $delete=$this->metacomercial_modelo->eliminarRegistroDeRamoAgente($_GET["q"],$_GET["r"],$_GET["p"],$_GET["s"]);

        }

        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datosAgenteAEliminar, TRUE));fclose($fp);

        $resultado["bool"]=$delete;

        if($delete){
            $resultado["mensaje"]="Registro eliminado con exito";
        } else{
            $resultado["mensaje"]="El registro no se eliminó correctamente, contacte al departamento de sistemas";
        }

        echo json_encode($resultado);
    }
    //----------------------------------------------------------------------------------
    function consultaSicasVentasNuevas(){

        //echo json_encode($_GET["q"]);
        $agentes_consulta=explode(",",$_GET["r"]);
        $a_consulta=array();

        $this->load->library("ws_sicas");
        $array=array();
        $json_resp=array();

        $tipo_ramo=0;

        switch($_GET["p"]){
            case "autos": $tipo_ramo=2;
                break;
            case "vida": $tipo_ramo=4;
                break; 
            case "danios": $tipo_ramo=1;
                break;
            case "gmm": $tipo_ramo=3;
                break;
            case "fianzas": $tipo_ramo=5;
                break;
        }

        $array['fechaInicial']=date("d-m-Y", mktime(0,0,0,($_GET['q']),1,date("Y")));

        if($_GET["q"]<date("m") || $_GET["q"]>date("m")){ // 

            $array['fechaFinal']=date("d-m-Y", mktime(0,0,0,$_GET["q"]+1,0,date("Y")));

        }
        else{
            
            $array['fechaFinal']=date("d-m-Y");
        }

        $resultado=$this->ws_sicas->consultaAvanceSicas(0,$agentes_consulta,$array['fechaInicial'],$array['fechaFinal'],$tipo_ramo);

        $info_vend=array();

        if(array_key_exists("TableInfo", $resultado)){

            $json_resp["mensaje"]="";

            foreach($resultado->TableInfo as $data){

                if(!isset($info_vend[(int)$data->IDVE]["cantidad_polizas"]) && !isset($info_vend[(int)$data->IDVE]["cantidad_prima"])){
                    
                    $info_vend[(int)$data->IDVE]["cantidad_polizas"]=0;
                    $info_vend[(int)$data->IDVE]["_cantidad_prima"]=0;
                    $info_vend[(int)$data->IDVE]["cantidad_prima"]=0;

                }

                if($data->Renovacion==0 && $data->Periodo==1){
    
                    $info_vend[(int)$data->IDVE]["cantidad_polizas"]++;
                    $info_vend[(int)$data->IDVE]["_cantidad_prima"]+=(Float)$data->PrimaNeta;
                    $info_vend[(int)$data->IDVE]["cantidad_prima"]=number_format($info_vend[(int)$data->IDVE]["_cantidad_prima"]);
                }

                $json_resp["personal_consultado"]=$info_vend;
            }

        } else{
            $json_resp["mensaje"]="No se encontraron resultados del mes y ramo seleccionado";
        }
           
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($json_resp, TRUE));fclose($fp);

        echo json_encode($json_resp);

    }
    //----------------------------------------------------------------------------------
    function notificarAsignacionDeMetas(){

        $agentes_para_envio=explode(",", $_GET["q"]);

        //obtenerDatosGeneralesMetasRamos
        $validador=array();
        $prueba=array();
        $array_send=array();

        for($a=0; $a<count($agentes_para_envio); $a++){

            $infoTotal[$agentes_para_envio[$a]]=$this->metacomercial_modelo->obtenerDatosGeneralesAsignado($agentes_para_envio[$a]);

            $m_s=$this->load->library("libreriav3");
            $meses=$this->libreriav3->devolverMeses();

            $correo_to[$agentes_para_envio[$a]]="";

            if(!empty($infoTotal[$agentes_para_envio[$a]])){

                $mensaje[$agentes_para_envio[$a]]="
                <html>
                    <header></header>
                    <body style='font-family: helvetica; width: 500px'>
                        <h2>Asignación de meta en ramos (cantidad de pólizas y primas)</h2>
                        <p>Para ver la asignación completa en meses, favor de visitar su sesión en <span style='color: #2874A6  '>V3/Mi info/Metas Asignadas</span></p>
                        <p>A continuación se presenta sus metas asignadas: </p>
                        <div style='width: 70%;'>
                            ";

                foreach($infoTotal[$agentes_para_envio[$a]] as $TInfo){

                    //$array_send[$agentes_para_envio[$a]][$TInfo->mes_asignado][$TInfo->ramo]["Polizas"]=$TInfo->cantidad_polizas;
                    //$array_send[$agentes_para_envio[$a]][$TInfo->mes_asignado][$TInfo->ramo]["Prima"]=$TInfo->prima_polizas;
                    $correo_to[$agentes_para_envio[$a]]=$TInfo->email;
                    //$mensaje[$agentes_para_envio[$a]]=$this->load->view("metacomercial/correoAsignacionMetas",$array_send[$agentes_para_envio[$a]],true);;
                    $mensaje[$agentes_para_envio[$a]].="
                    <div style='border: 1px solid #808B96; height: 20%; font-family:helvetica; border-top: 5px #3498DB; padding: 10px 10px 10px 10px'>
                        <!--<hr style='border: 20px #3498DB; vertical-align:top; margin:0 auto'>-->
                        <h4'>Asignación de meta para el mes: ".$meses[$TInfo->mes_asignado]." del ".date("Y")."</h4>
                        <table style='margin-top: 20px'>
                            <thead style='border-collapse: separate; border-spacing: 5px;'>
                                <tr style='font-family: helvetica'>
                                    <th>Mes</th>
                                    <th>Ramo</th>
                                    <th>Asignación</th>
                                </tr>
                            </thead>
                            <tbody style='border-collapse: separate; border-spacing: 5px;'>
                            <tr style='font-family: helvetica; text-align: center'>
                                <td>".$TInfo->mes_asignado."</td>
                                <td>".strtoupper($TInfo->ramo)."</td>
                                <td style='text-align: left'>
                                    Meta por cantidad de pólizas: <span style='color: #239B56'>".$TInfo->cantidad_polizas."</span> <br>
                                    Meta por prima generada: <span style='color: #B03A2E'>$ ".number_format($TInfo->prima_polizas)."</span>
                                </td>
                            </tr>          
                            </tbody>
                        </table>
                    </div>
                    <br>";
                    //array_push($validador,$send_email);
                }

                $mensaje[$agentes_para_envio[$a]].="
                        </div>
                    </body>
                </html>
                ";

                //---------Para tabla envio_correos------------
                $correo_reg=array();
                $correo_reg["desde"]="invitacion@asesorescapital.com";
                $correo_reg["para"]=$correo_to[$agentes_para_envio[$a]];
                $correo_reg["asunto"]="Notificación de asignación de metas comerciales";
                $correo_reg["mensaje"]=$mensaje[$agentes_para_envio[$a]];
                $correo_reg["status"]=0;
                $correo_reg["identificaModulo"]="MetaComercialRamoCoordinadorAgente";
                $correo_reg["copia"]=0;
                $correo_reg["copiaOculta"]=0;
                $correo_reg["fechaEnvio"]=date("Y-m-d H:i:s");

                $send_email=$this->metacomercial_modelo->enviar_correo_tabla($correo_reg);
                //---------------------------------------------
                //$send_email=$this->enviar_correo($correo_to[$agentes_para_envio[$a]],$mensaje[$agentes_para_envio[$a]]);
                $array_send[$agentes_para_envio[$a]]=$send_email;
                //$prueba["visor"]= $array_send;
            }

        }
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($array_send, TRUE));fclose($fp);

        echo json_encode($array_send);
    }
    //---------------------------------------------------------------------------------
    function enviar_correo($correo, $mensaje){

        $resultado=true;

        $config=array(
			"protocol"=>"smtp",
			"smtp_host"=>"mail.asesorescapital.com",
			"smtp_port"=>587,
			"smtp_user"=> "invitacion@asesorescapital.com", //"envioinvitacion@agentecapital.com", 
			"smtp_pass"=> "Invitacion2020#", //"PSWAGINV2020!", 
			"mailtype"=>"html",
			"wordwrap"=>TRUE

		); // Creamos la configuracion en caso de que se utilice una configuracion de email SMTP.

        $this->load->library("email", $config); //Cargamos la libreria de email.
        
        $this->email->clear(TRUE);
		$this->email->from("invitacion@asesorescapital.com","AGENTE CAPITAL SEGUROS Y FIANZAS");
		$this->email->to("auxiliardesarrollo@agentecapital.com"); //"auxiliardesarrollo@agentecapital.com";
		$this->email->subject("Notificación de asignación de metas comerciales");
		$this->email->message($mensaje);
        if(!$this->email->send()){
            //echo $CI->email->print_debugger();
           $resultado=false;
        }
        
        return $resultado;
    }
    //----------------------------------------------------
    function manageAllGoalsData(){

        $this->load->view("metacomercial/goalsReports");
    }
    //---------------------------------------------------- //Dennis Castillo [2022-01-27]
    function manageChannelGoal(){ 

        $channel = $_GET["channel"];
        $getEmail = $this->metacomercial_modelo->getChannelData($channel);
        $responseData = array();
        $currentRecord = array();
        $_currentRecord = array();
        $monthProgress = array();
        $test = array();
        $months = $this->libreriav3->devolverMeses();
        $getAllProgress = $this->metacomercial_modelo->getProgressSecondGoal($getEmail[0]->correo);
        $getAllChannelGoals_ = $this->metacomercial_modelo->getSecondGoal($getEmail[0]->correo); //Metas comerciales
        $getCategories = $this->metacomercial_modelo->getGoalCategories($channel);
        //----------------
        foreach($getCategories as $dc){

            $category = $dc->ramo == "daños" ? "danios" : $dc->ramo;
            $goal = array_reduce($getAllChannelGoals_, function($acc, $curr) use($category){

                if($curr->ramo == $category && $curr->mes_asignado == date("n")){
                    $acc["count"] = $curr->cantidad_polizas;
                    $acc["bonus"] = $curr->prima_polizas;
                }

                return $acc;
            }, array("count" => 0, "bonus" => 0));

            $progress = $this->metacomercial_modelo->getCategoryProgress($getEmail[0]->correo, $dc->ramo, date("n"));
            //array_push($test, $progress);

            $_currentRecord["count"][$dc->ramo]["goal"] = $goal["count"];
            $_currentRecord["bonus"][$dc->ramo]["goal"] = $goal["bonus"];
            $_currentRecord["count"][$dc->ramo]["progress"] = !empty($progress) ? $progress->cantidad : 0;
            $_currentRecord["bonus"][$dc->ramo]["progress"] = !empty($progress) ? $progress->prima : 0;
        }
        //--------------
        foreach($months as $number => $name){

            $bonusProgress = array();
            $countProgress = array();
            $progress = array_reduce($getCategories, function($acc, $curr) use($number, $getEmail){

                $progress_ = $this->metacomercial_modelo->getCategoryProgress($getEmail[0]->correo, $curr->ramo, $number);
                $acc["count"] += !empty($progress_->cantidad) ? $progress_->cantidad : 0;
                $acc["bonus"] += !empty($progress_->prima) ? $progress_->prima : 0;

                return $acc;
            }, array("count" => 0, "bonus" => 0));

            $monthProgress["bonus"][] = array("number" => $number, "name" => $name, "progress" => $progress["bonus"]); 
            $monthProgress["count"][] = array("number" => $number, "name" => $name, "progress" => $progress["count"]); 
        }

        $responseData["monthProgress"] = $_currentRecord;
        $responseData["monthsProgress"] = $monthProgress;
        //$getAllChannelGoals = $this->personamodelo->obtenerIdPersonaPorEmail();
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($responseData, TRUE));fclose($fp);
        echo json_encode($responseData);
    }
    //----------------------------------------------------
    }

?>