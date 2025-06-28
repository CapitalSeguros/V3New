<?php

$codigo=$_REQUEST['codigo'];
$sql="SELECT * FROM calendario_citas_asesores WHERE token='$codigo'";
include('../cx/cx.php');
$rs=$link->query($sql);
$row=$rs->fetch_row();
if($row){

$dia=$_REQUEST['dia'];
$hora=$_REQUEST['hora'];
$nombre=$_REQUEST['nombre'];
$email=$_REQUEST['email'];
$telefono=$_REQUEST['telefono'];
$detalle=$_REQUEST['detalle'];
$id_user=$_REQUEST['id_user'];
$id=$row[0];
$fechaCita=$row[3];
$horaCita=$row[4];

$fecha=$dia.'T'.$hora.':00';
$password='';

for($i=0;$i<6;$i++){
	$password.=rand(0, 9);
}

//******Nombre del Agente******
$sqlX="SELECT nombres FROM persona WHERE idPersona='$id_user'";
$rsX=$link->query($sqlX);
$rowX=$rsX->fetch_row();
$agente=$rowX[0];


//************* Api Zoom********************
require_once 'config.php';
$client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
$db = new DB();
$arr_token = $db->get_access_token();
$accessToken = $arr_token->access_token;
    try {
        $response = $client->request('POST', '/v2/users/me/meetings', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ],
            'json' => [
                "topic" => 'Cita de Asesoria Online',
                "type" => 2,
                //"start_time" => "2020-05-05T20:30:00",
                "start_time" => $fecha,
                "duration" => "30", // 30 mins
                "password" => $password
            ],
        ]);
 
        $data = json_decode($response->getBody());
        $liga_zoom= $data->join_url;
        $password_liga=$data->password;
 
    } catch(Exception $e) {
        if( 401 == $e->getCode() ) {
            $refresh_token = $db->get_refersh_token();
 
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "refresh_token",
                    "refresh_token" => $refresh_token
                ],
            ]);
            $db->update_access_token($response->getBody());
 
            create_meeting();
        } else {
            echo $e->getMessage();
        }
    }

//**************** Final Api zoom******************




$sql="UPDATE calendario_citas_asesores SET cliente='$nombre', correo='$email',telefono='$telefono',detalle='$detalle',activo=0, liga_zoom='$liga_zoom', password_liga='$password_liga' WHERE dia='$dia' AND hora='$hora' AND id_userInfo='$id_user'";
$rs=$link->query($sql);

//***Agregar cita a calendario General**********
$sqlX="SELECT email from users where idPersona='$id_user'";
$rsX=$link->query($sqlX);
$rowX=$rsX->fetch_row();
$emailUser=$rowX[0];

$fechaActual=date('Y-m-d h:m:s');
$insert="INSERT INTO citascalendar(fechaGuardado,emailUsuario,titulo,fechaInicial,fechaFinal,emailEstado,tabla) VALUES ('$fechaActual','$emailUser','Cita Online Asesores Capital','$fechaCita','$fechaCita','A','citascalendar')";
$ins=$link->query($insert);

//*********************************************
//Envio de Correo con Liga de Zoom 

$mensaje="<DOCTYPE html>
<html>
<head>
    <title></title>
    <style type='text/css'>
        body{
            font-family: arial;
            background-color: #E6E6E6;
            font-size: 12px;
        }
    </style>
</head>
<body>
<table width='75%' align='center' style='border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;'>
    <tr>
        <td align='left' colspan='2'>
            <img src='https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png' width='30%' style='margin-top: -8%;'>
        </td>
    </tr>
    <tr align='left'><td colspan='2'><h4 style='color: blue;'>DETALLES DE SU CITA ONLINE </h4></td></tr>
    <tr>
        <td>
           Conexion via Zoom es:
        </td>
        <td><a href=".$liga_zoom.">". $liga_zoom."</td>
    </tr>
    <tr>
        <td>Password de reunion Zoom es:</td>
        <td><a href='<?php echo $password_liga;?>'>".$password_liga."</td>
    </tr>
    <tr><td colspan='2'><br><br></td></tr>
 
    <tr>
        <td><b>Nombre y Apellido:</b></td>
        <td>".strtoupper($nombre)."</td>
    </tr>
    <tr>
        <td width='50%'><b>E-mail:</b></td>
        <td>".$email."</td>
    </tr>
    <tr>
        <td><b>Detalles de su Cita:</b></td>
        <td>".$detalle."</td>
    </tr>    
    <tr><td colspan='2'><br></td></tr>
    <tr align='left'><td colspan='2'>
        <h4 style='color: blue;'>
        AGENTE ASESOR CAPITAL</h4>
        </td>
    </tr>
    <tr>
        <td><b>Nombre:</b></td>
        <td>".strtoupper($agente)."</td>
    </tr>
    <tr><td colspan='2'><br><br></td></tr>
     <tr align='left'><td colspan='2'><h4 style='color: blue;'>AGENDA</h4></td>
    </tr>
    <tr>
        <td><b>Dia:</b></td>
        <td>".strtoupper($dia)." , ".$fechaCita."</td>
    </tr>
     <tr>
        <td><b>Hora de reunion:</b></td>
        <td>".$horaCita."</td>
    </tr>
</table>
</body>
</html>";


/*************Config 1 ***********/
$para=trim($email);
$titulo    = "Cita Online - Asesores Capital Seguros y Fianzas";
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabeceras .= 'From: info@agentecapital.com' . "\r\n" .'Reply-To:info@agentecapital.com' . "\r\n" .'X-Mailer: PHP/';
mail($para, $titulo, $mensaje, $cabeceras);


//***************************************
?>
<script type="text/javascript">
	document.location.href="../exito.php?id=<?php echo $id;?>";
</script>
<?php }else{?>
<script type="text/javascript">
	alert("Codigo Ingresado Invalido!");
	window.history.back(-2);
</script>
<?php }?>

