<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ws_sicasdre
{
    var $UserName    = "GAP#aCap%2015";
    var $Password    = "CAP15gap20Ag";
    var $CodeAuth    = "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";
    var $key        = "%SOnlineBOGO2001-2015WS#";
    var $ivPass        = "GAP#aCap";
    var $urlSite = URL_TICC_SICAS.'sicas/addData';
    //var $urlProceso = 'https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL';

    var $DeleteXml = array(
        '<?xml version="1.0" encoding="utf-8"?>',
        '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">',
        '<ProcesarWSResponse xmlns="http://tempuri.org/">',
        '<ProcesarWSResult>',
        '</ProcesarWSResult>',
        '</ProcesarWSResponse>',
        '</soap:Envelope>',
    );
    var $ClearXml = array(
        '',
        '',
        '',
        '',
        '',
        '',
        '',
    );

    //----------------------------------------------------------------------------------------------------------------------------------------
    public function wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae)
    {
        $xmlSend    = '<ProcesarWS>
                        <oDataWS>
                            <TypeFormat>XML</TypeFormat>
                            <KeyProcess>DATA</KeyProcess>
                            <KeyCode>' . $wsKeycode . '</KeyCode>
                            <TProc>' . $wsTipo . '</TProc>
                            <DataXML>' . $wsTextoPlano . '</DataXML>
                        </oDataWS>
                       </ProcesarWS>';
        $return = $this->consumowssicas($xmlSend, $wsNodoExtrae);
        return $return;
    }/*! wsdata */
    //-------------------------------------------------------------------------------------------------

    private function consumowssicas($body, $wsNodoExtrae = null)
    {
        $urlSite = URL_TICC_SICAS.'sicas/addData';
        $Fiedls = array("data" => $body);
        $format = "JSON";
        $test = json_encode($Fiedls);
        $httpHeader = array();
        $headers = array("Content-Type: application/json; charset=utf-8");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlSite,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($Fiedls),
            CURLOPT_HTTPHEADER => $headers,
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
                    if ($wsNodoExtrae == "TableInfo") {
                        return $decoded_response->$wsNodoExtrae;
                    } else {
                        return $decoded_response->TableInfo->$wsNodoExtrae;
                    }
                } else {
                    return $decoded_response;
                    //return $decoded_response->TableInfo->$wsNodoExtrae;
                }
            }
            $decoded_response2 = json_decode($response, true);
            $returnedResponse = $this->convertResponse($decoded_response2);
            return $returnedResponse;
        }
    }/*! consumowssicas */


    private function consumowssicasPruebas($xmlData)
    {
        $Fiedls = array("data" => $xmlData);
        $format = "XML";
        $urlSite = URL_TICC_SICAS.'sicas/addData';
        $test = json_encode($Fiedls);
        $httpHeader = array();
        $headers = array("Content-Type: application/json; charset=utf-8");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlSite,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
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

    public function wsdataPruebas($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae)
    {
        $xmlSend    = '<ProcesarWS>
                        <oDataWS>
                            <TypeFormat>XML</TypeFormat>
                            <KeyProcess>DATA</KeyProcess>
                            <KeyCode>' . $wsKeycode . '</KeyCode>
                            <TProc>' . $wsTipo . '</TProc>
                            <DataXML>' . $wsTextoPlano . '</DataXML>
                        </oDataWS>
                    </ProcesarWS>';

        $return = $this->consumowssicas($xmlSend, $wsNodoExtrae);
        return $return;
    }

    public function wsreport($wsKeycode, $wsBody, $wsConditionsAdd, $wsNodoExtrae)
    {
        $xmlSend = '<ProcesarWS>
                        <oDataWS>
                            <TypeFormat>XML</TypeFormat>
                            <KeyProcess>REPORT</KeyProcess>
                            <KeyCode>' . $wsKeycode . '</KeyCode>
                            <Page>' . $wsBody['Page'] . '</Page>
                            <ItemForPage>' . $wsBody['ItemForPage'] . '</ItemForPage>
                            <InfoSort>' . $wsBody['InfoSort'] . '</InfoSort>
                            <ConditionsAdd>' . $wsConditionsAdd . '</ConditionsAdd>
                        </oDataWS>
                    </ProcesarWS>';
        $return = $this->consumowssicas($xmlSend, $wsNodoExtrae);
        return $return;
    }

    public function wscdigital($wsBody, $wsAction, $wsNodoExtrae)
    {
        $xmlSend    = '<ProcesarWS>
                        <oDataWS>
                            <TypeFormat>XML</TypeFormat>
                            <KeyProcess>CDIGITAL</KeyProcess>
                            <TypeDestinoCDigital>' . $wsBody['TypeDestinoCDigital'] . '</TypeDestinoCDigital>
                            <IDValuePK>' . $wsBody['IDValuePK'] . '</IDValuePK>
                            <ActionCDigital>' . $wsAction . '</ActionCDigital>
                            <ListFilesURL>' . $wsBody['ListFilesURL'] . '</ListFilesURL>
                            <FolderDestino>' . $wsBody['FolderDestino'] . '</FolderDestino>
                            <IDCli>' . (isset($wsBody['IDCli']) ? $wsBody['IDCli'] : 0) . '</IDCli>
                        </oDataWS>
                    </ProcesarWS>';
        $return = $this->consumowssicas($xmlSend);
        return $return;
    }

    function convertResponse($respuesta)
    {
        $xml = "<DATAINFO>";
        $Type = gettype($respuesta["TableInfo"]);
        if (is_array($respuesta["TableInfo"])) {
            foreach ($respuesta["TableInfo"] as $key => $value) {
                $arraykeys = array_keys($value);
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
            $arraykeys = array_keys($respuesta["TableInfo"]);
            $xml .= "<TableInfo>";
            foreach ($arraykeys as $k => $val) {
                $xml .= "<{$val}>" . $respuesta["TableInfo"][$val] . "</{$val}>";
            }
            $xml .= "</TableInfo>";
        }

        //Ponemos los datos del table control
        $arraykeys = array_keys($respuesta["TableControl"]);
        $xml .= "<TableControl>";
        foreach ($arraykeys as $k => $val) {
            $xml .= "<{$val}>" . $respuesta["TableControl"][$val] . "</{$val}>";
        }
        $xml .= "</TableControl>";

        $xml .= "</DATAINFO>";

        $resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $xml);
        $convert = htmlspecialchars_decode($resXmlConsumo);
        $Responde = simplexml_load_string($convert);

        return $Responde;
    }
}
