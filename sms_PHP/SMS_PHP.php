<html>
    <head>
        <title>Enviando Mensaje </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>

<body> 
<center>
    <form method="post" name="smsmasivos" action="">
       
        <table >
            <tr>
                <td colspan="2" align="center">
                    <b>Redactar Mensaje</b> (1)
                    <br/><br/>
                </td>
            </tr>
            <tr>
                <td>
                    Destinatario: 
                </td>
                <td>
                    <input type="text" name="numero" value="" size="40" />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    Texto del Mensaje: 
                </td>
                <td>
                    <textarea name="messagetext" rows="3" cols="40"></textarea>
                    <script type="text/javascript">
                    </script>
                </td>
            </tr>
            <tr>
                <td colspan="" align="center" style="height: 34px">
                    <input type="submit" name="btnenviar" value="enviar"/>
                </td>
                <td style="height: 34px">
                     <input type="submit" value="Credito" name="btncredito"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                   <?php
                     
                    if(isset ($_REQUEST['btncredito']))
                    {
					
                        curl_setopt_array($ch = curl_init(), array(
                        CURLOPT_URL => "http://www.smsmasivos.com.mx/sms/api.credito.new.php",
                        CURLOPT_POST => TRUE,
                        CURLOPT_RETURNTRANSFER => TRUE,
                        CURLOPT_POSTFIELDS => array(
                        "apikey" => "5541c5feaffb75ab2e0f6c5452418375a1deefe2"
                        )
                        )
                        );
                        $respuesta=curl_exec($ch);
                        curl_close($ch);
                        $respuesta=json_decode($respuesta);
                        if($respuesta->estatus=="ok"){
                            echo $respuesta->credito;
                        }else{
                           echo $respuesta->mensaje;
                        }


                      
                            

                    }else if (isset ($_REQUEST['btnenviar']))
                    {
					
                        $mensaje = $_REQUEST['messagetext'];
                        $mensaje  = str_replace(" ", "%20", $mensaje);
                        $numero  =  $_REQUEST['numero'];
						
                        curl_setopt_array($ch = curl_init(), array(
                            CURLOPT_URL => "https://www.smsmasivos.com.mx/sms/api.envio.new.php",
                            CURLOPT_POST => TRUE,
                            CURLOPT_RETURNTRANSFER => TRUE,
                            CURLOPT_POSTFIELDS => array(
                            "apikey" => "8192f0c5c7cf2df5222c30e115a83917206218da",//"5541c5feaffb75ab2e0f6c5452418375a1deefe2",
                            "mensaje" => $mensaje,
                            "numcelular" => $numero,
                            "numregion" => "52"
                                    )
                                )
                        );
                        $respuesta=curl_exec($ch);
                        curl_close($ch);
                        $respuesta=json_decode($respuesta);
                        echo $respuesta->mensaje;
                                                                            
                    }

                    ?>

                </td>
            </tr>
        </table>
      </form>
    </center>
</body>
</html>