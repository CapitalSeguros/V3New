<?php 
    if (!defined('BASEPATH')) exit('No direct script access allowed');

class metacomercial_tareaprogramada extends CI_Controller{
    function __construct(){
        parent::__construct();

        $this->load->model(array("personamodelo","metacomercial_modelo","crmproyecto_model"));
    }
    //----------------------------------------------------
    // La función se ejecuta cada 10 minutos. Los cambios se efectuan si la persona tiene una meta tanto por comisión por venta nueva o ingreso total
    // Procede si tiene un tipo de reporte asignado (institucional, cancun, ...) en todos los en cantidad, comision o prima.
    function consultaComisionTareaProgramada(){ //fecha de entrada año-mes-dia fecha final año-mes-dia mes = 1,2,3,... No 01,02,03...

        date_default_timezone_set('America/Mexico_City');

        try{
            //echo json_encode($_GET["q"]);
            $this->load->library("ws_sicas");
            //$coor_venta_nueva=$this->personamodelo->devuelveCoorMetaComercial();
            //$ver=$this->personamodelo->devuelveCoorMetaComercialTotal();

            $reg_meta = $this->metacomercial_modelo->devuelveRelacionPersonaTipoDeMeta();

            $hoy= !empty($_GET["fi"]) ? $_GET["fi"] : date("Y-m-d");
            $ultimo_dia_mes= !empty($_GET["ff"]) ? $_GET["ff"] : date("Y-m-d", mktime(0,0,0,(date("m"))+1,0,date("Y"))); 
            $fecha_explode=explode("-",$hoy);

            $cont=0;
            $contador_dias_habiles_a=$this->diasHabiles($hoy,$ultimo_dia_mes,$this->fechasFeriadas($fecha_explode[1])); //date("m")
            
            if(!empty($contador_dias_habiles_a)){
                for($ii=0; $ii<count($contador_dias_habiles_a); $ii++){
                    $cont++;
                }
            }

            //var_dump($reg_meta);
            $array_persona_meta=array();

            if(!empty($reg_meta)){
                foreach($reg_meta as $d){ //Hacer el arreglo para mejor gestión de los datos

                    $array_persona_meta[$d->idPersona][$d->referencia]["id_referencia"]=$d->id_referencia;
                    $array_persona_meta[$d->idPersona][$d->referencia]["bandera"]= $d->referencia == "venta_nueva" ? 1 : 2; //$d->id_referencia;
                }
            }

            //Asignar a cada usuario su meta mensual actual y avance de comision.
            if(!empty($array_persona_meta)){

                foreach($array_persona_meta as $persona => $metas){
                    foreach($metas as $tipo => $parametros){

                        //$meta_anual = $this->metacomercial_modelo->obtenerMetaAnualPorId($persona,$parametros["bandera"]);
                        $meta_mensual = $this->metacomercial_modelo->devuelveMensualidadDeMeta($fecha_explode[1],$parametros["id_referencia"],$parametros["bandera"]);
                        $recibos = $this->crmproyecto_model->avance_cobranza_agente_region($persona);
                        $comision = $this->crmproyecto_model->devuelveDatosCobranzaPorComision($persona,1);
                        //var_dump($comision);
                        if(!empty($meta_mensual) && !empty($recibos) && !empty($comision)){
                            //var_dump($meta_mensual);
                            $tipo_comision = $tipo == "venta_nueva" ? $comision->comision_efectuada_venta_nueva : $comision->comision_efectuada;
                            $tipo_recibo = $tipo == "venta_nueva" ? $recibos->recibos_efectuados_venta_nueva : $recibos->recibos_efectuados;
                            $tipo_comision_subsecuente = $tipo == "venta_nueva" ? $comision->comision_efectuada_subsecuente : 0;

                            $diferencia_para_acarreo = $meta_mensual->monto_al_mes - $tipo_comision;

                            if($diferencia_para_acarreo > 0 && $cont <= 0){ //Guarda en el siguiente mes si no superó la meta.

                                $acarreo = $this->metacomercial_modelo->actualizaAvancesMensualesDeMeta($fecha_explode[1] + 1, $parametros["id_referencia"], array("meta_acarreo" => $diferencia_para_acarreo), $parametros["bandera"]);
                                echo "Registro del idPersona ".$persona." en ".$tipo." para acarreo: ".($acarreo == true ? "actualizado" : "no actualizado")."\n";
                            }

                            //Actualiza el registro del mes actual
                            $array_avance=array();

                            if($parametros["bandera"] == 1){
                                
                                $array_avance["comision_subsecuente"] = $persona != 805 ? $tipo_comision_subsecuente : $tipo_comision;
                            }

                            //$array_avance["mes"] = $meta_mensual->mes_num;
                            $array_avance["comision_actual"] = $tipo_comision;
                            $array_avance["cantidad_polizas"] = $tipo_recibo;
                            $array_avance["fecha_ejecucion_tarea"]=date("Y-m-d H:i:s");
                            
                            $update = $this->metacomercial_modelo->actualizaAvancesMensualesDeMeta($fecha_explode[1], $parametros["id_referencia"], $array_avance, $parametros["bandera"]);

                            echo "Registro del idPersona ".$persona." en ".$tipo.": ".($update == true ? "actualizado" : "no actualizado")."\n";

                            var_dump($cont);
                        }
                    }
                }
            }
                    
        } catch(Exception $e){
            echo "Excepción capturada", $e->getMessage(), "\n";
            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($e->getMessage(), TRUE));fclose($fp);
        }
    }

    //-------------------------------------------------
    function tareaProgramadaConsultaComisionSicas_respaldo2(){

        date_default_timezone_set('America/Mexico_City');

        try{
            //echo json_encode($_GET["q"]);
            $this->load->library("ws_sicas");
            $coor=$this->personamodelo->devuelveCoorMetaComercial();
            $ver=$this->personamodelo->devuelveCoorMetaComercialTotal();
            //$coor=$this->personamodelo->obtenerMetaComercialAnual(667);
            //$agentes_coor=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($_GET["q"]);
            $hoy= !empty($_GET["fi"]) ? $_GET["fi"] : date("Y-m-d");//"2021-04-01"; //date("Y-m-d"); //
            $ultimo_dia_mes= !empty($_GET["ff"]) ? $_GET["ff"] : date("Y-m-d", mktime(0,0,0,(date("m"))+1,0,date("Y"))); //"2021-04-30"; //date("Y-m-d", mktime(0,0,0,(date("m"))+1,0,date("Y")));

            $fecha_explode=explode("-",$hoy);
            //$fi=date("d-m-Y", mktime(0,0,0,date("m"),1,date("Y"))); //"01-02-2021";//
            //$ff=date("d-m-Y"); //"27-02-2021";//

            $cont=0;
            $contador_dias_habiles_a=$this->diasHabiles($hoy,$ultimo_dia_mes,$this->fechasFeriadas($fecha_explode[1])); //date("m")
            
            var_dump($ver);

            if(!empty($contador_dias_habiles_a)){
                for($ii=0; $ii<count($contador_dias_habiles_a); $ii++){
                    $cont++;
                }
            }
            var_dump($cont);
            if(!empty($coor)){
                foreach($coor as $aa){

                    $contenedor_agentes=array();
                    $array_update=array();
                    //--------------------------------------------------------
                    //Nueva implementación.
                    $comision=$this->crmproyecto_model->devuelveDatosCobranzaPorComision($aa->idPersona,1);
                    
                    $recibos=$this->crmproyecto_model->avance_cobranza_agente_region($aa->idPersona);

                    $meta_comercial_mensual=$this->metacomercial_modelo->obtenerMetaMensualCoor($aa->idMetaComercial,$fecha_explode[1]); //Meta mensual del coordinador //date("n")
                    //$meta_comercial_mensual=$this->metacomercial_modelo->obtenerMetaMensualCoor_ingreso_total($aa->idMetaComercial,$fecha_explode[1]);

                    $cantidad_efectuados=0;
                    $cantidad_efectuados_v_n=0;

                    if(!empty($meta_comercial_mensual)){
                        foreach($meta_comercial_mensual as $dd){

                            $diferencia_comision=$dd->monto_al_mes - $comision->comision_efectuada_venta_nueva;
                            //$diferencia_comision=$dd->monto_al_mes - $comision->comision_efectuada;
                            //var_dump($comision->reporte);
                            //var_dump($aa->idMetaComercial);
                            //var_dump($diferencia_comision);
                            if($diferencia_comision>0 && $cont==0){ //$diferencia_comision>0 && 
                                //$array_update[$aa->idPersona]["meta_acarreo"]=$diferencia_comision;
                                //$this->personamodelo->actualizaMontosMensuales(array("meta_acarreo"=>$diferencia_comision),$aa->idMetaComercial,($fecha_explode[1])+1);
                            }
                        }
                    }

                    //$array_update["comision_actual"]=$comision->comision_efectuada_venta_nueva;
                    //$array_update["cantidad_polizas"]=$recibos->recibos_efectuados;
                    //$array_update["cantidad_polizas"]=$recibos->recibos_efectuados_venta_nueva;
                    //$array_update["meta_acarreo"]=($diferencia_comision>0) ? $diferencia_comision : 0; //$diferencia_comision;
                    $array_update["fecha_ejecucion_tarea"]=date("Y-m-d H:i:s");

                    //actualiza el registro actual del mes.
                    //$this->personamodelo->actualizaMontosMensuales($array_update,$aa->idMetaComercial,($fecha_explode[1])); //date("m")
                    //-------------------------------------------------------
                                       
                    //var_dump($recibos);
                    //var_dump($meta_comercial_mensual);
                }
            }
        } catch(Exception $e){
            echo "Excepción capturada", $e->getMessage(), "\n";
            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($e->getMessage(), TRUE));fclose($fp);
        }
    }
    //--------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------
    function tareaProgramadaConsultaComisionSicas_respaldo(){

        try{
            //echo json_encode($_GET["q"]);
            $this->load->library("ws_sicas");
            $coor=$this->personamodelo->devuelveCoorMetaComercial();
            //$coor=$this->personamodelo->obtenerMetaComercialAnual(667);
            //$agentes_coor=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($_GET["q"]);
            $hoy=date("Y-m-d"); //"2021-02-27"; //
            $ultimo_dia_mes=date("Y-m-d", mktime(0,0,0,(date("m"))+1,0,date("Y")));

            $fi=date("d-m-Y", mktime(0,0,0,date("m"),1,date("Y"))); //"01-02-2021";//
            $ff=date("d-m-Y"); //"27-02-2021";//

            $cont=0;
            $contador_dias_habiles_a=$this->diasHabiles($hoy,$ultimo_dia_mes,$this->fechasFeriadas(date("m")));
            

            if(!empty($contador_dias_habiles_a)){
                for($ii=0; $ii<count($contador_dias_habiles_a); $ii++){
                    $cont++;
                }
            }
            //var_dump($contador_dias_habiles_a);
            if(!empty($coor)){
                foreach($coor as $aa){

                    $contenedor_agentes=array();
                    $array_update=array();

                    $agentes_coor=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($aa->idPersona);

                    //--------------------------------------------------------
                    //Nueva implementación.
                    $comision=$this->crmproyecto_model->devuelveDatosCobranzaPorComision($aa->idPersona);
                    //-------------------------------------------------------

                    if(!empty($agentes_coor)){
                        foreach($agentes_coor as $bb){
                            array_push($contenedor_agentes, $bb->IDVend);
                        }
                    }

                    //var_dump($contenedor_agentes);
                    $peticion_sicas=$this->ws_sicas->consultaAvanceSicas($aa->idPersona,array_values(array_unique($contenedor_agentes)),$fi,$ff,null); //Resultado de Sicas de los vendedores del coordinador
                    $meta_comercial_mensual=$this->metacomercial_modelo->obtenerMetaMensualCoor($aa->idMetaComercial,date("n")); //Meta mensual del coordinador
                    $comision_venta_nueva=0;
                    $contador_polizas=0;
                    //var_dump($meta_comercial_mensual);
                    if(array_key_exists("TableInfo",$peticion_sicas)){ //obtener la comisión de cada cordinador con meta asignada.
                        foreach($peticion_sicas->TableInfo as $cc){
                            if((Int)$cc->Renovacion==0 && (Int)$cc->Periodo==1){

                                $contador_polizas++;

                                $comision_venta_nueva+=(Float)$cc->ImporteP*(Float)$cc->TCPago;
                                //$array_update[$aa->idPersona]["comision_actual"]=$comision_venta_nueva;
                                //$comision_venta_nueva+=((Float)$val->comision0+(Float)$val->comision1+(Float)$val->comision2+(Float)$val->comision3+(Float)$val->comision4+(Float)$val->comision5+(Float)$val->comision6+(Float)$val->comision7+(Float)$val->comision8+(Float)$val->comision8)*(Float)$val->TCPago;
                            }
                        }
                    }
                    //var_dump($peticion_sicas);
                    $diferencia_comision=0;
                    if(!empty($meta_comercial_mensual)){
                        foreach($meta_comercial_mensual as $dd){

                            $diferencia_comision=$dd->monto_al_mes - $comision_venta_nueva;
                            if($diferencia_comision>0 && $cont==0){ //$diferencia_comision>0 && 
                                //$array_update[$aa->idPersona]["meta_acarreo"]=$diferencia_comision;
                                $this->personamodelo->actualizaMontosMensuales(array("meta_acarreo"=>$diferencia_comision),$aa->idMetaComercial,(date("m"))+1);
                            }
                        }
                    }

                    $array_update["comision_actual"]=$comision_venta_nueva;
                    $array_update["cantidad_polizas"]=$contador_polizas;
                    //$array_update["meta_acarreo"]=($diferencia_comision>0) ? $diferencia_comision : 0; //$diferencia_comision;
                    $array_update["fecha_ejecucion_tarea"]=date("Y-m-d H:i:s");

                    //actualiza el registro actual del mes.
                    $this->personamodelo->actualizaMontosMensuales($array_update,$aa->idMetaComercial,(date("m")));

                    //var_dump($array_update);
                }
            }
        } catch(Exception $e){
            echo "Excepción capturada", $e->getMessage(), "\n";
            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($e->getMessage(), TRUE));fclose($fp);
        }
    }
    //---------------------------------------------------------------------------------
    function fechasFeriadas($mes){
			
        $anio=date("Y");
        switch($mes){
            case 1:return [$anio."-01-01"];break;
            case 2:return [$anio."-02-01"];break;
            case 3:return [$anio."-03-15"];break;
            case 5:return [$anio."-05-01"];break;
            case 9:return [$anio."-09-16"];break;
            case 11:return [$anio."-11-15"];break;
            case 12:return [$anio."-12-25"];break;
        }
    }
    //----------------------------------------------------
    function diasHabiles($fi, $ff, $fih){

        if(empty($fih)){
            $fih=array();
        }

        $int_i=strtotime($fi); //date("j", strtotime($fi));
        $int_f=strtotime($ff); //date("j", strtotime($ff));
        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($int_f,TRUE));fclose($fp);

        $d_h=array();

        for($it=$int_i; $it<=$int_f; $it+=86400){
            if(!in_array(date("N",$it), array(6,7)) && !in_array(date("Y-m-d", $it),$fih)){

                array_push($d_h, date("Y-m-d", $it));
            }
        }

        return $d_h;
    }
    //----------------------------------------------------
    //------------------------------------------------------
}
?>