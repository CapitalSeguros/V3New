<?php
date_default_timezone_set('America/Merida');

function DreConectarDB(){

    $host = "localhost";
	
    $usuariodb = "capsysWeb";
    $pwddb = "viki$52";
    $db = "capsysV3";

    $enlace = mysql_connect($host,$usuariodb,$pwddb) or die("No pudo conectarse : " . mysql_error());
    if (!$enlace) {
        die('No conectado : ' . mysql_error());
    }
    $seldb = mysql_select_db($db,$enlace);
    if (!$seldb) {
        die ('No se puede usar la base de datos' . mysql_error());
    }
    return $enlace;
}

function DreDesconectarDB($conexion){
	if(isset($conexion)){
    mysql_close($conexion);
	}
}

function DreQueryDB($sql){
    $res = mysql_query($sql) or die (mysql_error());
    return 
		$res;
}

function encripta($key,$ivPass,$TextPlain){
	if(strlen($key)!=24){
		echo "La longitud de la key ha de ser de 24 dígitos.<br>"; return -1; 
	} if((strlen($ivPass) % 8 )!=0){ 
		echo "La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>"; return -2; 
	} 
	
	return @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass)); 
} 

function desencripta($key,$ivPass,$TextEncrip){ 
	if (strlen($key)!=24){ 
		echo "La longitud de la key ha de ser de 24 dígitos.<br>"; return -1; 
	} if ((strlen($ivPass) % 8 )!=0){ 
		echo "La longitud del vector iv Password ha de ser múltiple de 8 dígitos.<br>"; return -2; 
	} 
	
	$TextEncrip=@mcrypt_decrypt(MCRYPT_3DES, $key, base64_decode($TextEncrip), MCRYPT_MODE_CBC, $ivPass); 
	
	return $TextEncrip; 
}

function ConsumoWsSICAS($XMLData){            
           $headers = array(
                        "POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
                        "Content-Type: text/xml; charset=utf-8",
                        "Accept: text/xml",                        
                        "Host: www.sicasonline.info",
                        "Pragma: no-cache",
                        "SOAPAction: http://tempuri.org/ProcesarWS", 
                        "Content-length: ".strlen($XMLData),
                    );
            // PHP cURL  for https connection with auth
            $urlProceso = "https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?op=ProcesarWS";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $urlProceso);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $XMLData); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch); 
            curl_close($ch);        

            // converting
            $response1 = str_replace("<soap:Body>","",$response);            
            $response1 = str_replace("</soap:Body>","",$response1);
            return  (string)$response1;
}
?>