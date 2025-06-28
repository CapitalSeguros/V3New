<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Webservice
{
    protected $webservice;

    function __construct()
    {
        $this->CI = &get_instance();
        //$this->CI->load->model('siniestros_model', 'siniestros');
    }


    ///Metodo de consulta para obtner cualquier WS
    function consumoWS($datos,$aseguradora){
        $completeArray=array();
        $ch = curl_init($datos["url"]);
        $data = $datos["conexion"];
        $payload=json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $jsonFormat=json_decode($result,true);
        //var_dump($jsonFormat);
        $getKeyArray=$this->getKeyArray($jsonFormat);
        //se consulta por los datos obtenidos
        if($getKeyArray!=''){
            if(is_array($jsonFormat[$getKeyArray]) && isset($jsonFormat[$getKeyArray][0])){
                foreach ($jsonFormat[$getKeyArray] as $key => $value) {
                    $formated=$this->dataArrayServicio($value,$aseguradora);
                    array_push($completeArray,$formated);
                }
            }else{
                $formated=$this->dataArrayServicio($jsonFormat[$getKeyArray],$aseguradora);
                array_push($completeArray,$formated);
            }
        }
        //Estas opciones pueden cambiar dependiendo del ws que se consulte
        return array("codigo"=>isset($jsonFormat["Codigo"])?$jsonFormat["Codigo"]:'',"Mensaje"=>isset($jsonFormat["Mensaje"])?$jsonFormat["Mensaje"]:'',"Data"=>$completeArray);
    }

    //Se obtiene el campo de tipo ARRAY en donde estan todos los datos
    function getKeyArray($dataDecoded){
        $keyR='';
        foreach ($dataDecoded as $key => $value) {
            if(is_array($value)){
                $keyR=$key;
            }
        }
        return $keyR;
    }

    //metodo que relaciona el array explicito del cliente con los datos de la DB
    function dataArrayServicio($array,$aseguradora){
        $arrayR=[];
        $arrayCliente=$this->getArrayCliente($aseguradora);
        foreach ($array as $key => $value) {
            if(array_key_exists($key, $arrayCliente)||is_array($value)){
                if(is_array($value)){
                    foreach ($value as $key2 => $val) {
                        //$arrayR[$arrayCliente[$key2]]=$this->formatDatos($val);
                        $arrayR[$arrayCliente[$key2]]=$this->formatDatos($val,$key2);
                    }
                }else{
                    //$arrayR[$arrayCliente[$key]]=$this->formatDatos($value);
                    $arrayR[$arrayCliente[$key]]=$this->formatDatos($value,$key);
                }
            }
            
        }
         //añadimos los campos de ingreso
         $arrayR["tipo_actualizacion"]="SERVICIO";
         $arrayR["tipo_r"]="S";
         $arrayR["status_id"]="1";
         $arrayR["siniestro_estatus"]="ACTIVO";
        return $arrayR;
    }


    //metodo que retorna el array donde va a tomar los datos de la db -> con los del servicio
    function getArrayCliente($cliente){
        $ArrayCliente=[];
        switch ($cliente) {
            case '1':
                $ArrayCliente=array(
                    "NoReporte"=> "cabina_id",
                    "AjustadorClave"=> "ajustador_id",
                    "AjustadorNombre"=> "ajustador_nombre",
                    "Siniestro"=> "siniestro_id",
                    "Poliza"=> "poliza",
                    "Certificado"=> "certificado",
                    "nombreAsegurado"=> "asegurado_nombre",
                    "EstadoID"=> "estado_id",
                    "MunicipioID"=> "municipio_id",
                    "Evento"=> "evento",
                    "SubEvento"=> "sub_evento",
                    "DeclaroConductor"=> "declara_conductor",
                    "AtendioEnLugarDeHechos"=> "atencion_lugar",
                    "TipoSiniestro"=> "tipo_siniestro_id",
                    "CausaSiniestro"=> "causa_siniestro_id",
                    "IdTipoSiniestro"=> "tipo_siniestro_id",
                    "AutoridadPresenteID"=> "autoridad_id",
                    "ResponsablePorAutoridadID"=> "responsable_autoridad",
                    "ResponsablePorAjustadorID"=> "responsable_ajustador",
                    "Reporte"=> "fecha_repote",
                    "Ocurrencia"=> "fecha_ocurrencia",
                    "Cita"=> "cita",
                    "InicioDelAjuste"=> "inicio_ajuste",
                    "FinDelAjuste"=> "fin_ajuste",
                    "ID"=> "paquete_poliza_id",
                    "Descripcion"=> "paquete_descripcion"
                );
                break;
            
        }
        return $ArrayCliente;
    }

    //metodo para darle fromato a las fechas
    function formatDatos($val,$key){
        $datevalidation=date('Y-m-d',strtotime("1900-01-01"));
        $valR;
        if(strtotime($val) && $key!="Siniestro"){
            $valR=date('Y-m-d',strtotime($val))==$datevalidation?NULL:date('Y-m-d',strtotime($val));
        }else if($val=="1900-01-01T12:00:00.0000000"){
            $valR=NULL;
        }
        else{
            $valR=$val;
        }
        return $valR;
    }

    //metodo que arma la parte de la conexion que se necesita para la consulta del WS
    function datos_WS($data,$tipo,$relacion=NULL)
    {
        $datosSQL = json_decode($data[0]["datos"],true);
        $dta=[];
        switch ($tipo) {
            case 'NORMAL':
                //$dta=$datosSQL["objetojson"];
                $dta=$this->relacionDatos($datosSQL["objetojson"],$relacion);
                break;
            case 'RANGO':
                $dta=$this->relacionDatos($datosSQL["objetojson"],$relacion);
                break;    
        }
        return array("url" => $datosSQL["url"], "conexion" => $dta);
    }

    //metodo que permite la relacion de los datoss de un array con otros
    function relacionDatos($relacion,$data){
        $relacionR=$relacion;
        foreach ($relacionR as $key => $value) {
            if(array_key_exists($key, $data)){
                $relacionR[$key]=$data[$key];

            }
        }
        
        return $relacionR;
    }



}