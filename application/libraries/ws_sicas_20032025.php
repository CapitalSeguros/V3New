<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require('KLogger/vendor/autoload.php');

class Ws_sicas
{
    var $urlSite = URL_TICC_SICAS . 'sicas/addData';
    var     $DeleteXml = array('<?xml version="1.0" encoding="utf-8"?>', '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">', '<DATAINFO> ', '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>', '<ProcesarWSResponse xmlns="http://tempuri.org/">', '<ProcesarWSResult>', '</ProcesarWSResult>', '</ProcesarWSResponse>', '</soap:Envelope>', '</DATAINFO> ', '</soap:Body>', '</DATAINFO> ',);
    var $ClearXml = array('', '', '', '', '', '', '', '', '', '', '', '',);

    ///delete
    var $auth = "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";
    var $user = "GAP#aCap%2015";
    var $pass = "CAP15gap20Ag";
    var $numeroPagina = 1;
    //end detele

    function getDatosSICAS($body, $header = null, $url = "", $format = "XML")
    {

        $xml = '<ProcesarWS><oDataWS>';
        foreach ($body as $key => $value) {
            $xml = $xml . '<' . $key . '>' . $value . '</' . $key . '>';
        }
        $xml = $xml . '</oDataWS></ProcesarWS>';



        $urlSite = URL_TICC_SICAS . 'sicas/addData';
        //$urlSite = 'http://tic.sicasapi.capsys.site/sicas/addData';
        $Fiedls = array("data" => $xml);
        $httpHeader = array();
        $headers = array("Content-Type: application/json; charset=utf-8");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlSite,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($Fiedls),
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $obj["code"] = 400;
            $obj["error"] = $err;
            return json_encode($obj);
        } else {
            //echo $response;
            $decoded_response = json_decode($response);
            if ($format === "JSON") {
                return $decoded_response;
            }
            $decoded_response2 = json_decode($response, true);
            $returnedResponse = $this->convertResponse($decoded_response2);
            return $returnedResponse;
        }
    }

    function getDatosSICASBody($body, $format = "XML")
    {
        $urlSite = URL_TICC_SICAS . 'sicas/addData';
        //$urlSite = 'http://tic.sicasapi.capsys.site/sicas/addData';
        $Fiedls = array("data" => $body);
        $httpHeader = array();
        $headers = array("Content-Type: application/json; charset=utf-8");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlSite,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($Fiedls),
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $obj["code"] = 400;
            $obj["error"] = $err;
            return json_encode($obj);
        } else {
            //echo $response;
            $decoded_response = json_decode($response, true);
            if ($format === "JSON") {
                return $decoded_response;
            }
            $decoded_response2 = json_decode($response, true);
            $returnedResponse = $this->convertResponse($decoded_response2);
            return $returnedResponse;
        }
    }

    function getDatosDocumentos($body, $format = "XML")
    {
        $urlSite = URL_TICC_SICAS . 'sicas/accionesDocumentos';
        //$urlSite = 'http://tic.sicasapi.capsys.site/sicas/addData';
        $Fiedls = array("data" => $body);
        $httpHeader = array();
        $headers = array("Content-Type: application/json; charset=utf-8");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlSite,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($Fiedls),
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $obj["code"] = 400;
            $obj["error"] = $err;
            return json_encode($obj);
        } else {
            //echo $response;
            $decoded_response = json_decode($response, true);
            //$obj = new stdObject;
            (object)$returbed = new \stdClass();
            $returbed->PROCESSDATA = new \stdClass();
            $returbed->PROCESSDATA->DATA = $decoded_response["PROCESSDATA"]["DATA"];
            return (object)$returbed;
            /* if ($format === "JSON") {
                return $decoded_response;
            }
            $decoded_response2 = json_decode($response, true);
            $returnedResponse = $this->convertResponse($decoded_response2);
            return $returnedResponse; */
        }
    }

    private function consumowssicas($body, $wsNodoExtrae = null)
    {
        $urlSite = URL_TICC_SICAS . 'sicas/addData';
        //$urlSite = 'http://tic.sicasapi.capsys.site/sicas/addData';
        $Fiedls = array("data" => $body);
        $format = "JSON";
        $test = json_encode($Fiedls);
        $httpHeader = array();
        $headers = array("Content-Type: application/json; charset=utf-8");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlSite,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($Fiedls),
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $obj["code"] = 400;
            $obj["error"] = $err;
            return json_encode($obj);
        } else {
            //echo $response;
            $decoded_response = json_decode($response);
            if ($format === "JSON") {
                if ($wsNodoExtrae != null) {
                    return $decoded_response->TableInfo->$wsNodoExtrae;
                } else {
                    return $decoded_response;
                }
            }
            $decoded_response2 = json_decode($response, true);
            $returnedResponse = $this->convertResponse($decoded_response2);
            return $returnedResponse;
        }
    }/*! consumowssicas */


    function convertResponse($respuesta)
    {
        if (isset($respuesta["TableInfo"])) {
            $xml = "<DATAINFO>";
            $Type = gettype($respuesta["TableInfo"]);
            if (is_array($respuesta["TableInfo"])) {
                foreach ($respuesta["TableInfo"] as $key => $value) {
                    $arraykeys = array_keys($value);
                    $test = count($arraykeys);
                    if ($arraykeys == 0 || isset($respuesta["TableInfo"]["DATAINFO"])) {
                        $arraykeys = array_keys($value[0]);
                        $value = $value[0];
                    }
                    $xml .= "<TableInfo>";
                    foreach ($arraykeys as $k => $val) {
                        $xml .= "<{$val}>" . $value[$val] . "</{$val}>";
                    }
                    $xml .= "</TableInfo>";
                }
                if (count($respuesta["TableInfo"]) == 0) {
                    $xml .= "<TableInfo>";
                    $xml .= "</TableInfo>";
                }
            } else {
                $arraykeys = array_keys((array)$respuesta["TableInfo"]);
                $xml .= "<TableInfo>";
                foreach ($arraykeys as $k => $val) {
                    $xml .= "<{$val}>" . $respuesta["TableInfo"][$val] . "</{$val}>";
                }
                $xml .= "</TableInfo>";
            }

            //Ponemos los datos del table control
            //$text = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $text);
            $arraykeys = array_keys((array)$respuesta["TableControl"]);
            $xml .= "<TableControl>";
            foreach ($arraykeys as $k => $val) {
                $xml .= "<{$val}>" . $respuesta["TableControl"][$val] . "</{$val}>";
            }
            $xml .= "</TableControl>";
            //$xml .= "<Sucess>True</Sucess>";
            $xml .= "</DATAINFO>";
            $text = preg_replace('/&(?!#?[a-z0-9]+;)/', '', $xml);
            //$text=preg_replace('/&(?!#?[a-z0-9]+;)/', '', $text);
            //$text= preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $text);
            $text = str_replace(' & ', '', html_entity_decode((htmlspecialchars_decode($text))));
            //echo $text;
            //$resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $xml);
            $resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $text);
            $convert = htmlspecialchars_decode($resXmlConsumo);
            $Responde = simplexml_load_string($convert);
        } else {
            $Responde = $respuesta;
        }


        return $Responde;
    }

    public function subirArchivoSicas($array)
    {
        /*ENVIO DE ARCHIVOS A SICAS*/
        $xmlSend  = '
              <ProcesarWS>
                <oDataWS>
                  <TypeFormat>XML</TypeFormat>
                  <KeyProcess>CDIGITAL</KeyProcess>
                  <TypeDestinoCDigital>' . $array['TypeDestinoCDigital'] . '</TypeDestinoCDigital>
                  <IDValuePK>' . $array['IDValuePK'] . '</IDValuePK>
                  <ActionCDigital>' . $array['wsAction'] . '</ActionCDigital>
                  <ListFilesURL>' . $array['ListFilesURL'] . '</ListFilesURL>
                  <FolderDestino>' . $array['FolderDestino'] . '</FolderDestino>
                </oDataWS>
              </ProcesarWS>';

        return $this->consumowssicas($xmlSend);
    }


    public function GetCDDigital($data, $recursivo = 1)
    {
        if (is_array($data)) {
            if (isset($data['RECEIPT'])) {
                $IDDocto  = $data["IDDocto"];
                $data_body = array(
                    "ConditionsAdd" => "",
                    "InfoSort" => "",
                    "KeyCode" => "",
                    "KeyProcess" => "CDIGITAL",
                    "TypeDestinoCDigital" => "DOCUMENT",
                    "ActionCDigital" => "GETFiles"
                );
                //$datos['TipoEntidad']='0';
                $datos['TypeDestinoCDigital'] = 'RECEIPT';
                $datos['IDValuePK'] = $IDDocto;
                $datos['ActionCDigital'] = 'GETFiles';
                $datos['TypeFormat'] = 'XML';
                $datos['KeyProcess'] = 'CDIGITAL';
                $datos['ReadRecursive'] = $recursivo;
            } else {
                $IDDocto     = $data["IDDocto"];
                $data_body = array(
                    "ConditionsAdd" => "",
                    "InfoSort" => "",
                    "KeyCode" => "",
                    "KeyProcess" => "CDIGITAL",
                    "TypeDestinoCDigital" => "DOCUMENT",
                    "ActionCDigital" => "GETFiles"
                );
                $datos['TipoEntidad'] = '0';
                $datos['TypeDestinoCDigital'] = 'DOCUMENT';
                $datos['IDValuePK'] = $IDDocto;
                if (isset($data["IDDocto"])) {
                    //$datos['IDCli'] = $data["IDCli"];
                }
                $datos['ActionCDigital'] = 'GETFiles';
                $datos['TypeFormat'] = 'XML';
                $datos['TProct'] = 'Read_Data';
                $datos['KeyProcess'] = 'CDIGITAL';
                $datos['Page'] = '1';
                $datos['ItemForPage'] = '10000000';
                $datos['ReadRecursive'] = $recursivo;
            }
            $result = $this->getDatosSICAS($datos, null, "", "JSON");
            //return $result;
            if (isset($result->Datos)) {
                $result_c = array();
                if ($result->Datos != "" && count($result->Datos)>0) {
                    $Level = 0;
                    foreach ($result->Datos as $value) {
                        array_push($result_c, $value);
                    }
                    $test = $this->CrearArbol($result_c, 0);
                }else{
                    return array('text' => 'No cuenta con documentos');
                }
                return $test;
            } else {
                return array('text' => 'No cuenta con documentos');
            }
        }
    }

    public function GetCDDigitalCliente($data, $recursivo = 0)
    {

        if (is_array($data)) {
            $id = $data["IDValuePK"];
            $data_body = array(
                "ConditionsAdd" => "",
                "InfoSort" => "",
                "KeyCode" => "",
                "KeyProcess" => "CDIGITAL",
                "TypeDestinoCDigital" => "CLIENT",
                "ActionCDigital" => "GETFiles"
            );
            $datos['TipoEntidad'] = '0';
            $datos['TypeDestinoCDigital'] = 'CLIENT';
            $datos['IDValuePK'] = $id;
            $datos['ActionCDigital'] = 'GETFiles';
            $datos['TypeFormat'] = 'XML';
            $datos['TProct'] = 'Read_Data';
            $datos['KeyProcess'] = 'CDIGITAL';
            $datos['Page'] = '1';

            $datos['ItemForPage'] = '10000000';
            $datos['ReadRecursive'] = $recursivo;
            //$datos['RECEIPT']=1; 
            //$result = $this->getDatosSICAS2($datos);
            //echo json_encode($result);
            (array)$result = $this->getDatosSICAS($datos);
            //return $result;
            /* if (isset($result[0]->Datos)) {
                $result_c = array();
                if ($result->Datos != "") {
                    $Level = 0;
                    foreach ($result->Datos as $value) {
                        array_push($result_c, $value);
                    }
                    $test = $this->CrearArbol($result_c, 0);
                }
                return $test;
            } else {
                return array('text' => 'No cuenta con documentos');
            } */
            if (isset($result['Datos']) && count($result['Datos']) > 0) {
                $result_c = array();
                if ($result['Datos']) {
                    $Level = 0;
                    foreach ($result['Datos'] as $value) {
                        array_push($result_c, $value);
                    }
                    $test = $this->CrearArbol($result_c, 0);
                }
                return $test;
            } else {
                return array('text' => 'No cuenta con documentos');
            }
        }
    }

    public  function obtenerPolzasActividades($idCli, $sDate)
    {
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '1000';
        $datos['ConditionsAdd'] = 'Cliente Id;0;0;' . $idCli . ';' . $idCli . ';0;-1;DatDocumentos.IDCli ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ! Id Cliente;5;0;' . $sDate . ';0;DatDocumentos.FHasta ! Cliente Id;0;0;0;0;0;-1;DatDocumentos.Status ';
        $datos['InfoSort'] = 'CatClientes.IDCli';
        $datos['KeyCode'] = 'HWS_DOCTOS';
        $datos['KeyProcess'] = 'REPORT';
        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }

    public function obtenerCarteraFecha($vendedor, $fechaI, $fechaF)
    {
        /*ESTE WEBSERVER SE EMPLEA PARA OBTENER LAS PRODUCCION(CARTERA)*/
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HWS_DOCTOS';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '10000000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';

        // $vendedor=$this->tank_auth->get_IDVend();
        if ($vendedor > 0) {
            $datos['ConditionsAdd'] = '       
                  Desde|Hasta;3;0;' . $fechaI . '|' . $fechaF . ';0;-1;VDatDocumentos.FDesde ! Documento;0;0;0;1;DatDocumentos.Status ! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
        } else {
            $datos['ConditionsAdd'] = '       
                  Desde|Hasta;3;0;' . $fechaI . '|' . $fechaF . ';0;-1;VDatDocumentos.FDesde ! Documento;0;0;0;1;DatDocumentos.Status ';
        }

        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }


    ///Viejos metodos para cambiar xddddd

    public function obtenerRecibosPorFecha($fechaInicial, $fechaFinal, $array)
    {
        /*OBTIENE LOS RECIBOS POR FECHADOCTO=VDatPagosRec.FDocto POR RANGO DE FECHA
        $fechaInicial=ES UN STRING CON FORMATO DIA-MES-AÑO
        $fechaFinal=ES UN STRING CON FORMATO DIA-MES-AÑO
        $array=ES UN ARRAY PARA CUALQUIER OTRA INFORMACION QUE SE DESEA PROCESAR
        */

        $D_Cred = new stdClass();
        $datoCredenciales['username'] = "nombre";
        $datoCredenciales['Password'] = "passwor";
        $datoCredenciales['CodeAuth'] = "codigo";
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        // $datos['TypeFormat']='JSON';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'H03430_001';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '1000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';
        //Status;3;0;3|4;0;-1;VDatRecibos.Status
        //$datos['ConditionsAdd']='IDDocto;0;0;'.$recibo.';'.$recibo.';VDatRecibos.IDRecibo';

        // $datos['ConditionsAdd']='IDDocto;2;0;161518|2190|246|2510;0;-1;VDatRecibos.IDRecibo';

        $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $fechaInicial . '|' . $fechaFinal . ';0;-1;VDatPagosRec.FDocto';
        /*$datos['ConditionsAdd']='Desde|Hasta;2;0;'.$fechaInicial.';0;-1;VDatPagosRec.FDocto';

     
$respuesta=$this->getDatosSICAS($datos);
return $respuesta;*/

        do {
            $datos['Page'] = $this->numeroPagina;
            //$respuesta=$this->obtenerDatos($datos);
            $respuesta = $this->getDatosSICAS($datos);

            $this->numeroPagina = $this->numeroPagina + 1;
            foreach ($respuesta->TableInfo as $value) {
                array_push($this->tableInfo, $value);
            }
        } while ((int)$respuesta->TableControl->Pages[0] > (int)$respuesta->TableControl->Page[0]);


        return $this->tableInfo;
    }

    public function obtenerClientesPorVendedor($idVendedor, $nombre)
    {
        /*======SE BUSCA A CLIENTES DEL VENDEDOR QUE TENGAN UNA COINICIDENCIA CON  EL NOMBRE =====*/
        /*
        $idVendedor=ID DE VENDEDOR EN SICAS DEBE SER UN ENTERO(1,2,3)
        $nombre=ES EL STRING QUE VAMOS A BUSCAR EN LOS NOMBRE DEL CLIENTE(PEDRO,PEREZ)
         */
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HDS00002';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '2000';
        $datos['InfoSort'] = 'CatClientes.NombreCompleto';
        $datos['IDRelation'] = '0';
        $datos['ConditionsAdd'] = 'VendedorID;2;0;' . $idVendedor . ';' . $idVendedor . ';CatClientes.FieldInt1 ! Nombre Completo;0;0;*' . $nombre . '*;*' . $nombre . '*;0;-1;CatClientes.NombreCompleto ';

        // $respuesta=$this->obtenerDatos($datos);
        $respuesta = $this->getDatosSICAS($datos);

        return $respuesta;
    }

    public function buscaDocumento($documento)
    {
        /*EJEMPLO POLVA VERDE prueba30*/
        //$documento="prueba30";
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HWS_DOCTOS';
        $datos['Page'] = $this->numeroPagina;
        $datos['ItemForPage'] = '1000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';
        $datos['ConditionsAdd'] = 'IDDocto;0;0;' . $documento . ';' . $documento . ';DatDocumentos.Documento';
        // $datos['ConditionsAdd']='IDDocto;0;0;'.$documento.';'.$documento.';DatDocumentos.IDDocto';
        // $respuesta=$this->obtenerDatos($datos);
        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }

    public function  obtenerClienteInfo($IDCont)
    {
        /*======BUSCAR AL CLIENTE EN SICAS NOS PROPORCIONA OTROS DATOS QUE LA FUNCION HDS00002 COMO EL TELEFONO======*/
        /*
        $IDClI=ES EL ID DEL CLIENTE EN SICAS EL CUAL DEBE SER UN ENTERO(1,2,3,5..)
         */
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HWS_CLI';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '2000';
        $datos['InfoSort'] = 'CatClientes.IDCli';
        $datos['IDRelation'] = '0';
        $datos['ConditionsAdd'] = 'IDCli;2;0;' . $IDCont . ';' . $IDCont . ';CatClientes.IDCli';

        // $respuesta=$this->obtenerDatos($datos);
        $respuesta = $this->getDatosSICAS($datos);

        return $respuesta;
    }

    public function actualizarContactoVendedorSicas($arrayContacto)
    {

        if (isset($arrayContacto['IDCont'])) {
            $encriptado = '<InfoData><CatContactos>';
            foreach ($arrayContacto as $key => $value) {
                $encriptado = $encriptado . '<' . $key . '>' . $value . '</' . $key . '>';
            }
            $encriptado = $encriptado . '</CatContactos></InfoData>';

            //$encriptado = $this->encripta($encriptado);
            $respuesta = $this->grabarActualizasDatos('HCONTACT', $encriptado);

            //$respuesta = $this->decodificaXML($respuesta);
            return $respuesta;
        }
    }

    //----------------------------------------------------------------------------------------------------
    function consultaAvanceSicas($coor, $idVend, $fecha_i, $fecha_f, $ramo_s)
    {

        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'H02930_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '1000';
        $datos['InfoSort'] = 'DatHonRecibos.Status_TXT';
        $datos['IDRelation'] = '0';
        $filtroCoor = "";

        //------------
        $condicion_ramo = "";

        if ($ramo_s != null) {
            $condicion_ramo = "Ramo;0;0;" . $ramo_s . ";0;DatDocumentos.IDRamo !";
        }

        $str_conditionAdd = 'Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! FPago;3;0;' . $fecha_i . '|' . $fecha_f . ';0;-1;DatHonRecibos.FPago ! ' . $condicion_ramo . ' VendedorID;2;0;'; //'.$idVend.';0;DatHonRecibos.IDVE';

        $busquedaAgentes = "";

        for ($i = 0; $i < count($idVend); $i++) {

            $busquedaAgentes .= $idVend[$i] . "|";
        }

        $conditionAdd = $str_conditionAdd . trim($busquedaAgentes, "|") . ";" . trim($busquedaAgentes, "|") . ";DatHonRecibos.IDVE";
        //$conditionAdd.='|';
        //$datos['ConditionsAdd']='Desde|Hasta|Fecha de Pago;2;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;
        //$respuestaSicas=$this->obtenerDatos($datos);
        $datos['ConditionsAdd'] = $conditionAdd;

        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($conditionAdd,TRUE));fclose($fp);

        //$respuesta = $this->getDatosSICAS2($datos);
        $respuesta = $this->getDatosSICAS($datos);

        return $respuesta;
    }

    public function obtenerRenovacionesFecha($vendedor = null, $fechaI, $fechaF, $IDDocto = null, $status = null, $canal = '')
    {
        /*ESTE WEBSERVER SE EMPLEA PARA OBTENER LAS RENOVACIONES*/
        $respuesta = array();
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HWS_DOCTOS';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '10000000';
        $datos['InfoSort'] = 'VDatDocumentos.FHasta';
        $datos['IDRelation'] = '0';
        $datos['ConditionsAdd'] = '';
        //$vendedor=$this->tank_auth->get_IDVend();
        $condicionStatus = "";
        if ($IDDocto != null) {
            $datos['ConditionsAdd'] = 'IDDocto;0;0;' . $IDDocto . ';' . $IDDocto . ';DatDocumentos.IDDocto';
        } else {
            $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $fechaI . '|' . $fechaF . ';0;-1;DatDocumentos.FHasta ';
            if ($status != null) {
                $condicionStatus = ' ! Status;0;0;0;0;DatDocumentos.Status';
            }

            if ($vendedor > 0) {
                $datos['ConditionsAdd'] .= ' ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
            } else {
                if (empty($canal)) {

                    $datos['ConditionsAdd'] .= ' ! TipoDocumento;0;0;1;1;DatDocumentos.TipoDocto ';
                } else {

                    $datos['ConditionsAdd'] .= ' ! ' . $this->filtroParaCanales($canal);
                }
            }
            $datos['ConditionsAdd'] .= $condicionStatus;
        }

        //$respuesta = $this->getDatosSICAS2($datos);
        $respuesta = $this->getDatosSICAS($datos);


        return $respuesta;
    }

    public function obtenerReporteCobranza($vendedor, $fechaI, $fechaF, $tipoCobranza)
    {
        /*ESTOS SON REPORTES DE cobranza
        $tipoCobranza= 	ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA)
        */
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'H03430_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '10000000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';
        switch ($tipoCobranza) {
            case 0:
                if ($vendedor > 0) {
                    if ($fechaI != null) {
                        $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $fechaI . '|' . $fechaF . ';0;-1;VDatRecibos.FLimPago ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status   ! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
                    } else {
                        $datos['ConditionsAdd'] = ' Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status   ! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
                    }
                } else {
                    if ($fechaI != null) {
                        $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $fechaI . '|' . $fechaF . ';0;-1;VDatRecibos.FLimPago ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status  ';
                    } else {
                        $datos['ConditionsAdd'] = ' Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ';
                    }
                }

                break;

            case 1:
                if ($vendedor > 0) {
                    $datos['ConditionsAdd'] = '       
               Desde|Hasta;3;0;' . $fechaI . '|' . $fechaF . ';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;1;1;0;VDatRecibos.Status ! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
                } else {
                    $datos['ConditionsAdd'] = '       
               Desde|Hasta;3;0;' . $fechaI . '|' . $fechaF . ';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;1;1;0;VDatRecibos.Status  ';
                }
                break;

            case 3:
                if ($vendedor > 0) {
                    $datos['ConditionsAdd'] = '       
               Desde|Hasta;3;0;' . $fechaI . '|' . $fechaF . ';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;3;3;0;VDatRecibos.Status ! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
                } else {
                    $datos['ConditionsAdd'] = '       
               Desde|Hasta;3;0;' . $fechaI . '|' . $fechaF . ';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;3;3;0;VDatRecibos.Status  ';
                }

                break;
        }

        $respuesta = $this->getDatosSICAS($datos);


        return $respuesta;
    }

    public function obtenerHonorariosFecha($vendedor, $fechaI, $fechaF, $tipo)
    {
        /*ES PARA OBTENER LOS HONORARIOS 
        $tipo= ES ENTERO =1 ES PAGADO Y !=1 PARA NO PAGADOS 
        */
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'H02930_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '600';
        $datos['InfoSort'] = 'DatHonRecibos.Status_TXT';
        $datos['IDRelation'] = '0';



        if ($tipo == 1) {
            $datos['ConditionsAdd'] = 'Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado !
            Desde|Hasta|Fecha de Pago;3;0;' . $fechaI . '|' . $fechaF . ';' . $fechaI . '|' . $fechaF . ';0;-1;DatHonDocto.FPago ! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';51;DatHonRecibos.IDVE';
        } else {
            $datos['ConditionsAdd'] = 'Honorarios;0;0;0;Pendientes;DatHonRecibos.Pagado !
        Comisiones;7;1;Conciliado;Conciliado;VDPagoComRec.ComPagada ! 
        recibos;0;0;4;-1;DatRecibos.Status ! VendedorID;0;0;' . $vendedor . ';0;-1;DatHonRecibos.IDVE';
        }

        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }


    public function obtenerCobranzaEfectuadaPorFolio($folio, $vendedor, $nombreCLiente = null, $statusRecibo = null)
    {
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'H03430_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '10000000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';
        $datos2 = '<TipoEntidad>0</TipoEntidad><TypeDestinoCDigital>CONTACT</TypeDestinoCDigital><IDValuePK>0</IDValuePK><ActionCDigital>GETFiles</ActionCDigital><TypeFormat>XML</TypeFormat><TProct>Read_Data</TProct><KeyProcess>REPORT</KeyProcess><KeyCode>H03430_003</KeyCode><Page>1</Page><ItemForPage>100</ItemForPage><InfoSort>VDatDocumentos.IDDocto</InfoSort><IDRelation>0</IDRelation><ConditionsAdd>Documento;0;0;*4051900005833*;4051900005833;DatDocumentos.Documento</ConditionsAdd>';

        if ($nombreCLiente != null) {
            if ($statusRecibo == null) {
                //$statusRecibo = '3';
                $statusRecibo = 0;
            }
            if ($vendedor > 0) {
                //$datos['ConditionsAdd']='Documento;0;0;*'.$nombreCLiente.'*;'.$nombreCLiente.';DatDocumentos.Documento ! VendedorID;0;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
                $datos['ConditionsAdd'] = 'Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto !  Status;0;' . $statusRecibo . ';' . $statusRecibo . ';0;VDatRecibos.Status !  Nombre Completo;0;0;*' . $nombreCLiente . '*;*' . $nombreCLiente . '*;0;-1;CatClientes.NombreCompleto ! VendedorID;0;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
            } else {
                $datos['ConditionsAdd'] = 'Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto !  Nombre Completo;0;0;*' . $nombreCLiente . '*;*' . $nombreCLiente . '*;0;0;CatClientes.NombreCompleto';
                //  $datos['ConditionsAdd'] = 'Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto !  Status;0;' . $statusRecibo . ';' . $statusRecibo . ';0;VDatRecibos.Status !  Nombre Completo;0;0;*' . $nombreCLiente . '*;*' . $nombreCLiente . '*;0;-1;CatClientes.NombreCompleto';
                // $datos['ConditionsAdd']='Documento;0;0;*'.$folio.'*;'.$folio.';DatDocumentos.Documento  ';
                //$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! Despacho;0;3;3;1;DatDocumentos.IDDespacho';
            }
        } else {
            if ($statusRecibo == null) {
                $statusRecibo = '';
                //$statusRecibo = '3';
            } else {
                $val = $statusRecibo;
                $statusRecibo = ' ! Status;0;' . $val . ';' . $val . ';0;VDatRecibos.Status';
            }

            if ($vendedor > 0) {
                $datos['ConditionsAdd'] = 'Documento;0;0;*' . $folio . '*;*' . $folio . '*;DatDocumentos.Documento ! VendedorID;0;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend ' . $statusRecibo;
            } else {
                $datos['ConditionsAdd'] = 'Documento;0;0;*' . $folio . '*;*' . $folio . '*;DatDocumentos.Documento  ' . $statusRecibo;
            }
        }

        //$respuesta = $this->obtenerDatos2($datos);getDatosSICAS
        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }

    //-----------------------------------------------
    function filtroParaCanales($tipoReporte)
    {
        $condicion = '';
        switch ($tipoReporte) {
            case 'cancun':
                $condicion = ' Documento;0;1;1;1;DatDocumentos.TipoDocto  ! Despacho;0;3;3;1;DatDocumentos.IDDespacho';
                break;
            case 'fianzas':
                $condicion = ' Documento;0;2;2;1;DatDocumentos.TipoDocto ';
                break;
            case 'institucional':
                $condicion = ' Documento;0;1;1;1;DatDocumentos.TipoDocto  ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! subramo;1;0;20;0;0;DatDocumentos.IDSRamo';
                break;
            case 'merida':
                $condicion = ' Documento;0;1;1;1;DatDocumentos.TipoDocto  ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;1;0;9;0;1;DatDocumentos.IDGerencia ';
                break;
            case 'grupocer':
                $condicion = 'Documento;0;1;1;1;DatDocumentos.TipoDocto  ! grupo;0;0;12;0;1;DatDocumentos.IDGrupo ! VendedorID;0;0;7;0;0;CatVendedores.IdVend';
                break;
            case 'grupoflotillas':
                $condicion = 'Documento;0;1;1;1;DatDocumentos.TipoDocto  ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! VendedorID;0;0;7;0;0;CatVendedores.IdVend ! subramo;0;0;20;0;0;DatDocumentos.IDSRamo';
                break;
            case 'gmmVida':
                #'IDDocto;0;0;'.$documento.';'.$documento.';DatDocumentos.Documento';
                #1==DAÑOS;2==Vehiculos;3==Accidentes y Enfermedades;4==Vida;5==Fianzas
                $condicion = ' Documento;2;0;3|4;3|4;DatDocumentos.IDRamo';
                break;
            case 'danios':
                $condicion = ' Documento;2;0;1;1;DatDocumentos.IDRamo';
                break;
            case 'vehiculos':
                $condicion = ' Documento;2;0;2;2;DatDocumentos.IDRamo';
                break;

            case 'todos':
                $condicion = ' Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ';
                break;

            default:
                $vendedor = $this->CI->tank_auth->get_IDVend();
                $condicion = ' Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto  ! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
                break;
        }
        return $condicion;
    }


    public function  PruebaPolizas_old($data)
    { //PruebaPolizas
        $datos['TypeFormat'] = 'XML';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HWS_DOCTOS';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '2000';
        $datos['InfoSort'] = 'DatDocumentos.IDDocto';
        $fecha_actual = date("d-m-Y");
        $fechaFiltro = date("d/m/Y", strtotime($fecha_actual . "- 2 year"));
        $filtro = array();
        if ($data["num_poliza_m"] != '') {
            $filtro[] = 'num_poliza;0;0;*' . $data["num_poliza_m"] . '*;*' . $data["num_poliza_m"] . '*;VDatDocumentos.Documento';
        }
        if ($data["moral"] == "true") {
            $filtro[] = 'Nombre_completo;0;0;*' . $data["nombres"] . '*;*' . $data["nombres"] . '*;VCatClientes.NombreCompleto';
            $filtro[] = 'Entidad;0;0;1;1;VCatClientes.TipoEnt';
        } else {
            if ($data["nombres"] != '') {
                $filtro[] = 'Nombre;0;0;*' . $data["nombres"] . '*;0;VCatClientes.Nombre';
            }
            if ($data["apellido_p"] != '') {
                $filtro[] = 'NoapellidoP;0;0;*' . $data["apellido_p"] . '*;0;VCatClientes.ApellidoP';
            }
            if ($data["apellido_m"] != '') {
                $filtro[] = 'apellidoM;0;0;*' . $data["apellido_m"] . '*;0;VCatClientes.ApellidoM';
            }
        }
        $filtro[] = 'Fecha;5;1;' . $fechaFiltro . ';' . $fechaFiltro . ';VDatDocumentos.FHasta';
        //$filtro[]='Estatus;2;1;1|3;1|3;-1;-1;VDatDocumentos.Status';
        $datos['ConditionsAdd'] = implode("!", $filtro);
        //$datos['ConditionsAdd']='Nombre C;0;1;polanco;0;VCatClientes.ApellidoP!Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status';

        $respuesta = $this->getDatosSICAS($datos);
        //$respuesta = $this->getDatosSICAS2($datos);
        //$respuesta=$datos;
        return $respuesta;
    }

    public function  PruebaPolizas($data)
    { //PruebaPolizas
        $datos['TypeFormat'] = 'XML';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HWS_DOCTOS';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '2000';
        #$datos['InfoSort'] = 'DatDocumentos.IDDocto';
        $datos['InfoSort'] = 'DatDocumentos.FHasta DESC';
        $fecha_actual = date("Ymd");
        $fechaFiltro = date("Ymd", strtotime($fecha_actual . "- 2 year"));
        $filtro = array();
        if ($data["num_poliza_m"] != '') {
            $filtro[] = 'Documento;0;0;*' . $data["num_poliza_m"] . '*;*' . $data["num_poliza_m"] . '*;VDatDocumentos.Documento';
        }
        if ($data["moral"] == "true") {
            #$filtro[] = 'Nombre_completo;0;0;*' . $data["nombres"] . '*;*' . $data["nombres"] . '*;VCatClientes.NombreCompleto';
            $filtro[] = 'NombreCompleto;0;0;*' . $data["nombres"] . '*;*' . $data["nombres"] . '*;VCatClientes.NombreCompleto';
            //$filtro[] = 'Entidad;0;0;1;1;VCatClientes.TipoEnt';
        } else {
            $FindCliente = "";
            if ($data["nombres"] != '') {
                $FindCliente =  $data["nombres"];
            }
            if ($data["apellido_p"] != '') {
                $FindCliente =  $FindCliente . (empty($FindCliente) ? '' : ' ') . $data["apellido_p"];
            }
            if ($data["apellido_m"] != '') {
                $FindCliente =  $FindCliente . (empty($FindCliente) ? '' : ' ') . $data["apellido_m"];
            }
            $filtro[] = 'NombreCompleto;0;0;*' . $FindCliente . '*;0;VCatClientes.NombreCompleto';
            /*  if ($data["nombres"] != '') {
                $filtro[] = 'Nombre;0;0;*' . $data["nombres"] . '*;0;VCatClientes.Nombre';
            }
            if ($data["apellido_p"] != '') {
                $filtro[] = 'NoapellidoP;0;0;*' . $data["apellido_p"] . '*;0;VCatClientes.ApellidoP';
            }
            if ($data["apellido_m"] != '') {
                $filtro[] = 'apellidoM;0;0;*' . $data["apellido_m"] . '*;0;VCatClientes.ApellidoM';
            } */
        }
        $filtro[] = 'Fecha;5;1;' . $fechaFiltro . ';' . $fechaFiltro . ';VDatDocumentos.FHasta';
        //$filtro[]='Estatus;2;1;1|3;1|3;-1;-1;VDatDocumentos.Status';
        $datos['ConditionsAdd'] = implode("!", $filtro);
        //$datos['ConditionsAdd']='Nombre C;0;1;polanco;0;VCatClientes.ApellidoP!Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status';

        $respuesta = $this->getDatosSICAS($datos);
        //$respuesta = $this->getDatosSICAS2($datos);
        //$respuesta=$datos;
        return $respuesta;
    }

    public function crearContactoSicas()
    {
        /*=====CREA UN CONTACTO EN EL SICAS QUE SE DEBE RELACIONAR CON UN VENDEDOR EL CUAL ALMACENARA DATOS COMO TELEFONO,EMAIL ======*/
        $TextEncript = '<InfoData><CatContactos><IDCont>-1</IDCont></CatContactos></InfoData>';

        //$encriptado = $this->encripta($TextEncript);
        $respuesta = $this->grabarActualizasDatos('HCONTACT', $TextEncript);
        //$respuesta = $this->decodificaXML($respuesta);
        return $respuesta;
    }

    public function actualizarVendedorSicas($arrayVendedor)
    {
        if (isset($arrayVendedor['IDVend'])) {
            $encriptado = '<InfoData><CatVendedores>';
            foreach ($arrayVendedor as $key => $value) {
                $encriptado = $encriptado . '<' . $key . '>' . $value . '</' . $key . '>';
            }
            $encriptado = $encriptado . '</CatVendedores></InfoData>';

            //$encriptado=$this->encripta($encriptado);
            $respuesta = $this->grabarActualizasDatos('H01110', $encriptado);


            //$respuesta=$this->decodificaXML($respuesta);
            return $respuesta;
        }
    }

    public function bitacora($array)
    {
        /*VALORES QUE SE PUEDEN MODIFICAR IDBit,ClaveBit,Prioridad,Procedencia,Comentario*/
        if (isset($array['ClaveBit'])) {
            $encriptado = '<InfoData><DatBitacora>';
            foreach ($array as $key => $value) {
                $encriptado = $encriptado . '<' . $key . '>' . $value . '</' . $key . '>';
            }
            $encriptado = $encriptado . '</DatBitacora></InfoData>';

            //$encriptado=$this->encripta($encriptado);
            $respuesta = $this->grabarActualizasDatos('H04270', $encriptado);

            return $respuesta;
            //$respuesta=$this->decodificaXML($respuesta);  

        }
    }

    //Renovaciones
    function renovacionPoliza($array)
    {
        //$array["KeyCode"]="RENOVACION";
        $encriptado = '<InfoData><DatRenovaciones>';
        foreach ($array as $key => $value) {
            $encriptado = $encriptado . '<' . $key . '>' . $value . '</' . $key . '>';
        }
        $encriptado = $encriptado . '</DatRenovaciones></InfoData>';
        $respuesta = $this->grabarDatosDocumentos('RENOVACION', $encriptado);

        return $respuesta;
    }

    function cancelacionRenovacion($array)
    {
        $encriptado = '<InfoData><DatRenovaciones>';
        foreach ($array as $key => $value) {
            $encriptado = $encriptado . '<' . $key . '>' . $value . '</' . $key . '>';
        }
        $encriptado = $encriptado . '</DatRenovaciones></InfoData>';
        $respuesta = $this->grabarDatosDocumentos('CANCELAR', $encriptado);
        return $respuesta;
    }

    public function crearVendedorSicas($idContacto)
    {
        /*====CREA VENDEDOR EN EL SICAS EL VENDEDOR TIENE QUE TENER UNA RELACION CON CONTACTO PARA VISUALIZARLO EN EL SICAS */
        /*
     $idContacto= ES EL ID DE CONTACTA CON EL QUE SE VA A RELACIONAR EL VENDEDOR DEBE SER UN ENTERO(1,2,3)
      */
        $TextEncript = '<InfoData><CatVendedores><IDVend>-1</IDVend><IDDespacho>1</IDDespacho><IDCont>' . $idContacto . '</IDCont><Status>0</Status><GenComision>1</GenComision></CatVendedores></InfoData>';
        //$encriptado=$this->encripta($TextEncript);
        $respuesta = $this->grabarActualizasDatos('H01110', $TextEncript);
        //$respuesta=$this->decodificaXML($respuesta);
        return $respuesta;
    }

    public  function  envioMensualAgentes($IDVend, $fechaInicial, $fechaFinal)
    {
        /*====FORMATO DEL MANEJO DE LA FECHA 10/9/2018=========*/

        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'H02930_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '1000';
        $datos['InfoSort'] = 'DatHonRecibos.Status_TXT';
        $datos['IDRelation'] = '0';
        // $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! Desde|Hasta|Fecha de Pago;3;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;
        $datos['ConditionsAdd'] = 'Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! FPago;3;0;' . $fechaInicial . '|' . $fechaFinal . ';0;-1;DatHonRecibos.FPago ! VendedorID;2;0;' . $IDVend . ';0;DatHonRecibos.IDVE';

        //$datos['ConditionsAdd']='Desde|Hasta|Fecha de Pago;2;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;
        //$respuestaSicas=$this->obtenerDatos($datos);
        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }

    function informacionDeBitacora($claveBit)
    {
        $respuesta = array();
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HWS_BITACORA';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '3000';
        $datos['InfoSort'] = 'DatBitacora.FechaHora Desc';
        $datos['IDRelation'] = '0';
        $datos['ConditionsAdd'] = "Bitacora;0;0;" . $claveBit . ";Tarea;DatBitacora.ClaveBit";
        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }

    function recibosClientes($array)
    { //Check
        /*ESTOS SON REPORTES DE cobranza
        $tipoCobranza=  ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA/PAGADO),4(LIQUIDADO)
        */

        $keyCode = "H03430_003";
        $fechaTipoRecibo = "VDatRecibos";
        if ($array['tipoFecha'] == 'FDocto') {
            $keyCode = 'H03430_001';
            $fechaTipoRecibo = 'VDatPagosRec';
        } elseif ($array['tipoFecha'] == 'FEmision') { //FEmision
            $keyCode = 'H03400'; //: H03400|H03400_005
            $fechaTipoRecibo = 'DatDocumentos'; //

        }

        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = $keyCode; //'H03430_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '1000000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';

        $filtroGrupoValores = "";
        $filtroGrupo = "";
        $filtroSubGrupoValores = "";
        $filtroSubGrupo = "";
        $filtroDespachoValores = "";
        $filtroDespacho = "";
        $filtroGerenciaValores = "";
        $filtroGerencia = "";
        $filtroRamoValores = "";
        $filtroRamo = "";
        $filtroVendedor = "";
        $filtroTipoFechaValores = "";
        $filtroTipoFecha = "";
        $filtroStatus = "";
        $filtroStatusValores = "";
        $filtroVendedoresValores = "";

        //Filtro de grupos
        if (isset($array['filtroGrupo'])) {
            foreach ($array['filtroGrupo'] as  $value) {
                if ($value === end($array['filtroGrupo'])) {
                    $filtroGrupoValores .= $value;
                } else {
                    $filtroGrupoValores .= $value . '|';
                }
            }

            $filtroExcepcionGrupo = "grupo;2;0;";

            if ($array["excepcionGrupo"] == 1) {
                $filtroExcepcionGrupo = "grupo;2;1;";
            }

            if ($filtroGrupoValores != "") {
                $filtroGrupo = $filtroExcepcionGrupo . $filtroGrupoValores . ';' . $filtroGrupoValores . ';DatDocumentos.IDGrupo ! ';
            }
        }

        //Filtro de SubGrupos
        if (isset($array['filtroSubGrupo'])) {
            foreach ($array['filtroSubGrupo'] as  $value) {
                if ($value === end($array['filtroSubGrupo'])) {
                    $filtroSubGrupoValores .= $value;
                } else {
                    $filtroSubGrupoValores .= $value . '|';
                }
            }
            $filtroExcepcionSubGrupo = "subgrupo;2;0;";
            if ($array["excepcionSubGrupo"] == 1) {
                $filtroExcepcionSubGrupo = "subgrupo;2;1;";
            }
            if ($filtroSubGrupoValores != "") {
                $filtroSubGrupo = $filtroExcepcionSubGrupo . $filtroSubGrupoValores . ';' . $filtroSubGrupoValores . ';DatDocumentos.SubGrupo ! ';
            }
        }

        //Filtro de despacho
        if (isset($array['filtroDespacho'])) {
            foreach ($array['filtroDespacho'] as  $value) {
                if ($value === end($array['filtroDespacho'])) {
                    $filtroDespachoValores .= $value;
                } else {
                    $filtroDespachoValores .= $value . '|';
                }
            }

            $filtroExcepcionDespacho = "Despacho;2;0;";

            if ($array["excepcionDespacho"] == 1) {

                $filtroExcepcionDespacho = "Despacho;2;1;";
            }

            if ($filtroDespachoValores != "") {
                $filtroDespacho = $filtroExcepcionDespacho . $filtroDespachoValores . ';' . $filtroDespachoValores . ';DatDocumentos.IDDespacho ! ';
            }
        }

        //Filtro de gerencia
        if (isset($array['filtroGerencia'])) {
            foreach ($array['filtroGerencia'] as  $value) {
                if ($value === end($array['filtroGerencia'])) {
                    $filtroGerenciaValores .= $value;
                } else {
                    $filtroGerenciaValores .= $value . '|';
                }
            }

            $filtroExcepcionGerencia = "gerencia;2;0;";

            if ($array["excepcionCanales"] == 1) {

                $filtroExcepcionGerencia = "gerencia;2;1;";
            }

            if ($filtroGerenciaValores != "") {
                $filtroGerencia = $filtroExcepcionGerencia . $filtroGerenciaValores . ';' . $filtroGerenciaValores . ';DatDocumentos.IDGerencia ! ';
            }
        }

        //Filtro de ramo
        if (isset($array['filtroRamo'])) {
            foreach ($array['filtroRamo'] as  $value) {
                if ($value === end($array['filtroRamo'])) {
                    $filtroRamoValores .= $value;
                } else {
                    $filtroRamoValores .= $value . '|';
                }
            }
            $filtroExcepcionRamo = "Ramo;2;0;";

            if ($array["excepcionRamos"] == 1) {

                $filtroExcepcionRamo = "Ramo;2;1;";
            }

            if ($filtroRamoValores != "") {
                $filtroRamo = $filtroExcepcionRamo . $filtroRamoValores . ';' . $filtroRamoValores . ';DatDocumentos.IDRamo ! ';
            }
        }
        //Filtro de vendedor.
        if (isset($array['filtroVendedor'])) {
            foreach ($array['filtroVendedor'] as  $value) {
                if ($value === end($array['filtroVendedor'])) {
                    $filtroVendedoresValores .= $value;
                } else {
                    $filtroVendedoresValores .= $value . '|';
                }
            }

            $filtroExcepcionVendedor = "VendedorID;2;0;";

            if ($array["excepcionVendedor"] == 1) {

                $filtroExcepcionVendedor = "VendedorID;2;1;";
            }

            if ($filtroVendedoresValores != "") {
                $filtroVendedor = $filtroExcepcionVendedor . $filtroVendedoresValores . ';' . $filtroVendedoresValores . ';VDATDOCUMENTOS.IDVEND ! ';
            }
        }
        //Filtro de estatus.
        if (isset($array['filtroStatus']) && $array['tipoFecha'] != 'FEmision') {
            foreach ($array['filtroStatus'] as  $value) {
                if ($value != -1) {
                    if ($value === end($array['filtroStatus'])) {
                        $filtroStatusValores .= $value;
                    } else {
                        $filtroStatusValores .= $value . '|';
                    }
                }
            }
            if ($filtroStatusValores != "") {
                $filtroStatus = 'Ramo;2;0;' . $filtroStatusValores . ';' . $filtroStatusValores . ';VDatRecibos.Status ! '; //DatVendedor.IDVend !
            }
        }

        $filtrosGenerales = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;' . $fechaTipoRecibo . '.' . $array['tipoFecha'] . ' ! '; //VDatRecibos
        $condicion = $filtrosGenerales . $filtroGrupo . $filtroSubGrupo . $filtroDespacho . $filtroGerencia . $filtroRamo . $filtroVendedor . $filtroStatus; //."GerenciaD;2;1;null;VCATGERENCIA.NOMBRE"
        $datos['ConditionsAdd'] = trim($condicion, '! ');

        $respuesta = $this->getDatosSICAS($datos);
        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta,TRUE));fclose($fp); 
        return $respuesta;
    }

    //-------------------------------------------
    function cobranzaReportePorRecibo($recibo)
    {
        $respuesta = array();
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'H03430_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '3000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';
        $datos['ConditionsAdd'] = 'IDDocto;2;0;' . $recibo . ';0;-1;VDatRecibos.IDRecibo';

        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }

    //-------------------------------------------

    public function cobranzareporte_old($array, $paginacion = 0, $pagina = 0)
    {
        /*ESTOS SON REPORTES DE COBRANZA
    $tipoCobranza=  ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA)
    $array['tipoFecha'] FDesde,FHasta,FLimPago,fDoctoPago*/
        $respuesta = array();
        $tableInfo = array();
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'H03430_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '5000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';

        switch ($array['tipoReporte']) { //Status;0;0;0;0;
            case 'cancun':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;5;0;VDatRecibos.Status ! Despacho;0;3;3;1;DatDocumentos.IDDespacho';
                break;
            case 'fianzas':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;2;2;1;DatDocumentos.TipoDocto ! Status;0;0;5;0;VDatRecibos.Status';
                break;
            case 'institucional':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;5;0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! subramo;1;0;20;0;0;DatDocumentos.IDSRamo';
                break;
            case 'merida':
                //$datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;5;0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;1;0;9;0;1;DatDocumentos.IDGerencia ';
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;5;0;VDatRecibos.Status ! despacho;2;0;2|8;2|8;DatDocumentos.IDDespacho ! gerencia;1;0;9;0;1;DatDocumentos.IDGerencia ';
                break;
            case 'grupocer':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;5;0;VDatRecibos.Status ! grupo;0;0;12;0;1;DatDocumentos.IDGrupo ! VendedorID;0;0;7;0;0;CatVendedores.IdVend';
                break;
            case 'grupoflotillas':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;5;0;VDatRecibos.Status ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! VendedorID;0;0;7;0;0;CatVendedores.IdVend ! subramo;0;0;20;0;0;DatDocumentos.IDSRamo';
                break;
            case 'todos':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ! Status;0;0;5;0;VDatRecibos.Status';
                break;

            default:
                //$vendedor = $this->CI->tank_auth->get_IDVend();
                $vendedor = 23;
                //$datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status ! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status ';
                break;
        }
        if ($paginacion) {
            $numeroPagina = 1;
            $datos['ItemForPage'] = 100;
            do {

                $datos['Page'] = $numeroPagina;
                $respuesta = $this->getDatosSICAS($datos);

                if (count($respuesta->TableInfo) > 0) {
                    foreach ($respuesta->TableInfo as $value) {
                        if (!empty($value)) {
                            array_push($tableInfo, $value);
                        }
                    }
                }
                $numeroPagina = $numeroPagina + 1;
            } while ((int)$respuesta->TableControl->Pages[0] > (int)$respuesta->TableControl->Page[0]);
            return $tableInfo;
        } else {
            $respuesta = $this->getDatosSICAS($datos);
            return $respuesta;
        }
    }
    public function cobranzareporte($array, $paginacion = 0, $pagina = 0)
    {
        /*ESTOS SON REPORTES DE COBRANZA
    $tipoCobranza=  ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA)
    $array['tipoFecha'] FDesde,FHasta,FLimPago,fDoctoPago*/
        $respuesta = array();
        $tableInfo = array();
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'H03430_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '5000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';

        switch ($array['tipoReporte']) { //Status;0;0;0;0;
            case 'cancun':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status ! Despacho;0;3;3;1;DatDocumentos.IDDespacho';
                break;
            case 'fianzas':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;2;2;1;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status';
                break;
            case 'institucional':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! subramo;1;0;20;0;0;DatDocumentos.IDSRamo';
                break;
            case 'merida':
                //$datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;5;0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;1;0;9;0;1;DatDocumentos.IDGerencia ';
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status';
                break;
            case 'grupocer':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status ! VendedorID;0;0;7;0;0;CatVendedores.IdVend';
                break;
            case 'grupoflotillas':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status ! VendedorID;0;0;7;0;0;CatVendedores.IdVend ! subramo;0;0;20;0;0;DatDocumentos.IDSRamo';
                break;
            case 'todos':
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status';
                break;

            default:
                //$vendedor = $this->CI->tank_auth->get_IDVend();
                $vendedor = 23;
                //$datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status ! VendedorID;2;0;' . $vendedor . ';' . $vendedor . ';CatVendedores.IdVend';
                $datos['ConditionsAdd'] = 'Desde|Hasta;3;0;' . $array['fechaInicial'] . '|' . $array['fechaFinal'] . ';0;-1;VDatRecibos.' . $array['tipoFecha'] . ' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ! Status;0;0;3;0;VDatRecibos.Status ';
                break;
        }
        if ($paginacion) {
            $numeroPagina = 1;
            $datos['ItemForPage'] = 100;
            do {

                $datos['Page'] = $numeroPagina;
                $respuesta = $this->getDatosSICAS($datos);

                if (count($respuesta->TableInfo) > 0) {
                    foreach ($respuesta->TableInfo as $value) {
                        if (!empty($value)) {
                            array_push($tableInfo, $value);
                        }
                    }
                }
                $numeroPagina = $numeroPagina + 1;
            } while ((int)$respuesta->TableControl->Pages[0] > (int)$respuesta->TableControl->Page[0]);
            return $tableInfo;
        } else {
            $respuesta = $this->getDatosSICAS($datos);
            return $respuesta;
        }
    }

    //-------------------------------------------------------------------------------------------------
    function obtenerDocumentoPorId($id)
    {
        /*ESTE WEBSERVER SE EMPLEA PARA OBTENER LAS PRODUCCION(CARTERA)*/
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HWS_DOCTOS';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '10000000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';

        // $vendedor=$this->tank_auth->get_IDVend();

        $datos['ConditionsAdd'] = 'Docto;0;0;' . $id . ';0;-1;DatDocumentos.IDDocto';


        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }

    function buscarReciboPorID($IDRecibo)
    {
        $keyCode = "H03430_003";
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = $keyCode; //'H03430_003';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '10000';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';
        $datos['ConditionsAdd'] = 'IDDocto;0;0;' . $IDRecibo . ';' . $IDRecibo . ';VDatRecibos.IDRecibo';
        $respuesta = $this->getDatosSICAS($datos);
        return $respuesta;
    }

    function aplicarPagoRecibo($array)
    {
        /*=====APLICA EL PAGO DE RECIBO Y ENDOSO ======*/
        /*

        $pago['IDPagoRec']=-1;
        $pago['IDRecibo']=id de recibo;
        $pago['FPago']= es la fecha de pago;
        $pago['FolioCh']= es el folio del cheque;
        $pago['TipoDocto']= por ejemplo si es un baucher;
        $pago['Banco']= el nombre del banco;
        $pago['FolioDocto']= es el folio del documento;
        $pago['FDocto']= es la fecha del documento;
        $pago['TPago']= el tipo de pago puede ser directo o tarjeta poner por default 0;
        $pago['ImporteP']=es el importe a pagar;
        $pago['IDMonPago']=es el tipo de moneda 1 pesos 2  en dollar;
        $pago['TCPago']=es el tipo de cambio si es IDMonPago=1 por defaul 1;
        $pago['Importe']=es el importe a pagar y suele ser igual ImporteP;
        $pago['TCDocto']=es el tipo de cambio del documento que suele ser igual a IDMonPago;
        $pago['IDTarjeta']=-1;
        */

        if (isset($array['IDRecibo'])) {
            //$encriptado = '<InfoData><DatPagosRec>';
            $encriptado = '<DatPagosRec>';
            foreach ($array as $key => $value) {
                $encriptado = $encriptado . '<' . $key . '>' . $value . '</' . $key . '>';
            }

            //$encriptado = $encriptado . '</DatPagosRec></InfoData>';
            $encriptado = $encriptado . '</DatPagosRec>';

            //$encriptado = $this->encripta($encriptado);

            $respuesta = $this->grabarActualizasDatos('HWPAGOREC', $encriptado);
            //$res = $this->decodificaXML($respuesta);
            //return $res;
            return $respuesta;
        }
    }



    public function obtenerClientePorID($IDCli)
    {
        /*======BUSCAR AL CLIENTE EN SICAS=======*/
        /*
        $IDClI=ES EL ID DEL CLIENTE EN SICAS EL CUAL DEBE SER UN ENTERO(1,2,3,5..)
         */
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HDS00002';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '2000';
        $datos['InfoSort'] = 'CatClientes.IDCli';
        $datos['IDRelation'] = '0';
        if ($IDCli == null) {
            //$datos['ConditionsAdd']='IDCli;2;0;'.$IDCli.';'.$IDCli.';CatClientes.IDCli';
        } else {
            $datos['ConditionsAdd'] = 'IDCli;2;0;' . $IDCli . ';' . $IDCli . ';CatClientes.IDCli';
        }

        $respuesta = $this->getDatosSICAS($datos);
        //$respuesta = $this->getDatosSICAS2($datos);

        return $respuesta;
    }


    public function actualizarContactoSicas($arrayOT)
    {
        $respuesta = array();

        if (isset($arrayOT['IDCont'])) {
            $encriptado = '<InfoData><CatContactos>';
            foreach ($arrayOT as $key => $value) {
                $encriptado = $encriptado . '<' . $key . '>' . $value . '</' . $key . '>';
            }
            $encriptado = $encriptado . '</CatContactos></InfoData>';



            //$encriptado = $this->encripta($encriptado);
            $respuesta = $this->grabarActualizasDatos('HDATACONTACT', $encriptado);


            //$respuesta = $this->decodificaXML($respuesta);
            $fp = fopen('resultadoJason.txt', 'a');
            fwrite($fp, print_r($respuesta, TRUE));
            fclose($fp);
        }
        return $respuesta;
    }

    function buscarDocumentoPorIDSicas($IdSikas)
    {
        /*========SE BUSCA DE ACUERDO AL idSicas QUE SE OBTIENEN AL CREAR ACTIVIDADES TAMBIEN ES UN VINCULO PARA VER LA OT EN SICAS========*/
        /*======== SI EN EL CAMPO Documento DEVUELTO POR LA CONSULTA YA NO TIENE OT SIGNIFICA QUE YA SE CONVIRTIO EN POLIZA=========*/
        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        //$datos['KeyCode']='H03430_003';
        $datos['KeyCode'] = 'HWS_DOCTOS';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '10';
        $datos['InfoSort'] = 'VDatDocumentos.IDDocto';
        $datos['IDRelation'] = '0';
        $datos['ConditionsAdd'] = 'IDDocto;0;0;' . $IdSikas . ';' . $IdSikas . ';DatDocumentos.IDDocto';
        $respuesta = $this->getDatosSICAS($datos);

        return $respuesta;
    }

    public function rfcClienteObtener($rfc)
    {
        /*======BUSCAR AL CLIENTE EN SICAS=======*/
        /*$IDClI=ES EL ID DEL CLIENTE EN SICAS EL CUAL DEBE SER UN ENTERO(1,2,3,5..)*/

        $datos['TipoEntidad'] = '0';
        $datos['TypeDestinoCDigital'] = 'CONTACT';
        $datos['IDValuePK'] = '0';
        $datos['ActionCDigital'] = 'GETFiles';
        $datos['TypeFormat'] = 'XML';
        $datos['TProct'] = 'Read_Data';
        $datos['KeyProcess'] = 'REPORT';
        $datos['KeyCode'] = 'HDS00002';
        $datos['Page'] = '1';
        $datos['ItemForPage'] = '2000';
        $datos['InfoSort'] = 'CatClientes.IDCli';
        $datos['IDRelation'] = '0';
        $datos['ConditionsAdd'] = 'IDCli;2;0;' . $rfc . ';' . $rfc . ';CatClientes.rfc';

        // $respuesta=$this->obtenerDatos($datos);
        $respuesta = $this->getDatosSICAS($datos);

        return $respuesta;
    }



    //-------------------------------------------------------------------------------------------------

    private function grabarActualizasDatos($keyCode, $valores)
    {
        $xml = '<ProcesarWS><oDataWS>';
        $xml = $xml . '<TypeFormat>JSON</TypeFormat>';
        $xml = $xml . '<KeyProcess>DATA</KeyProcess>';
        $xml = $xml . '<KeyCode>' . $keyCode . '</KeyCode>';
        $xml = $xml . '<TProc>Save_Data</TProc>';
        $xml = $xml . '<DataXML>' . $valores . '</DataXML>';
        $xml = $xml . '</oDataWS></ProcesarWS>';

        $response = $this->getDatosSICASBody($xml, "JSON");

        return $response;
    }

    private function grabarDatosDocumentos($keyCode, $valores)
    {
        $xml = '<ProcesarWS><oDataWS>';
        $xml = $xml . '<TypeFormat>JSON</TypeFormat>';
        $xml = $xml . '<KeyProcess>DATA</KeyProcess>';
        $xml = $xml . '<KeyCode>' . $keyCode . '</KeyCode>';
        $xml = $xml . '<TProc>Save_Data</TProc>';
        $xml = $xml . '<DataXML>' . $valores . '</DataXML>';
        $xml = $xml . '</oDataWS></ProcesarWS>';

        $response = $this->getDatosDocumentos($xml, "JSON");

        return $response;
    }


    public function getDatosSICAS2($wsdata)
    {
        //

        $xml = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials>';
        $xml = $xml . '<UserName>' . $this->user . '</UserName>';
        $xml = $xml . '<Password>' . $this->pass . '</Password>';
        $xml = $xml . '<CodeAuth>' . $this->auth . '</CodeAuth></Credentials>';
        $xml = $xml . '<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
        $xml = $xml . '<Password>ACHAN2019</Password></CredentialsUserSICAS>';

        foreach ($wsdata as $key => $value) {
            $xml = $xml . '<' . $key . '>' . $value . '</' . $key . '>';
        }

        $xml = $xml . '</oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';



        $headers = array(
            "POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
            "Content-Type: text/xml; charset=utf-8",
            "Accept: text/xml",
            "Host: www.sicasonline.info",
            "Pragma: no-cache",
            "SOAPAction: http://tempuri.org/ProcesarWS",
            "Content-length: " . strlen($xml),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POST, true);
        // converting

        $response = curl_exec($ch);

        $resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $response);
        $xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);

        $xmlRespuesta = <<<XML
$xmlTexto_resXmlConsumo
XML;
        $return = array();
        $carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);

        curl_close($ch);
        //
        return $carga_xmlRespuesta;
    }



    //Metodos de cobranza
    public function actualizaOT($arrayOT)
    {
        /*ACTUALIZA UNA ORDEN DE TRABAJO(OT) */
        $respuesta = array();
        if (isset($arrayOT['IDDocto'])) {

            $encriptado = '<InfoData><DatDocumentos>';
            foreach ($arrayOT as $key => $value) {
                $encriptado = $encriptado . '<' . $key . '>' . $value . '</' . $key . '>';
            }
            $encriptado = $encriptado . '</DatDocumentos></InfoData>';

            $respuesta = $this->grabarActualizasDatos('HWCAPTURE', $encriptado);
            return $respuesta;
        }
    }


    ///metodos para convertir
    private function CrearArbol($Arbol, $Nodo = 0)
    {

        $isFolder     = false;
        $text        = "";
        $level        = "";
        $href        = "";
        $hreftarget    = "";
        $level_int         = 0;
        $tipo = '';
        foreach ($Arbol as $key => $value) {
            $value = (object)$value;
            if ((string)$value->Level == 0) {
                unset($Arbol[$key]);
                if ($value->Tipo == 0) {
                    $isFolder = true;
                    $text = (string)$value->NameShow;
                    $level = (string)$value->Level;
                    $tipo = (int)$value->Tipo;
                } else {

                    $isFolder = false;
                    $text = (string)$value->NameShow;
                    $href = (string)$value->PathWWW;
                    $hrefTarget = "_blank";
                    $level = (string)$value->Level;
                    $tipo = (int)$value->Tipo;
                }

                $recursive = $this->Hijos($Arbol);

                $return["isFolder"] = $isFolder;
                $return["text"] = $text;
                if (!empty($href)) $return["href"] = $href;
                if (!empty($hrefTarget)) $return["hrefTarget"] = $hrefTarget;
                if (!empty($level)) $return["level"] = $level;
                if (!empty($tipo)) $return["Tipo"] = $tipo;

                if ($recursive != NULL)
                    $return["children"] = $recursive;
            }
        }

        return empty($return) ? null : $return;
    }
    //------------------------------------------------------------------------------------------------------------------------------	
    private function Hijos($Arbol)
    {
        $isFolder     = false;
        $text        = "";
        $level        = "";
        $href        = "";
        $hreftarget    = "";
        $level = 0;
        $hijos = array();
        foreach ($Arbol as $key => $value) {
            unset($Arbol[$key]);
            $value = (object)$value;
            if ($value->Tipo == 0) {
                $return  =
                    array("isFolder" => true, "text" => (string)$value->NameShow, "level" => (string)$value->Level, "Tipo" => (int)$value->Tipo);
            } else {
                $return  = array("isFolder" => false, "text" => (string)$value->NameShow, "href" => (string)$value->PathWWW, "hrefTarget" => "_blank", "level" => (string)$value->Level, "Tipo" => (int)$value->Tipo);
            }
            array_push($hijos, $return);
        }
        return empty($hijos) ? null : $hijos;
    }
}
