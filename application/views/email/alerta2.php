<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <title>
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style type="text/css">
        /* Remove space around the email design. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important
        }

        /* Stop Outlook resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
        }

        /* Stop Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* Use a better rendering method when resizing images in Outlook IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* Prevent Windows 10 Mail from underlining links. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        @media only screen and (max-width:480px) {
            @-ms-viewport {
                width: 320px;
            }

            @viewport {
                width: 320px;
            }
        }
    </style>
    <![endif]-->
    <style type="text/css">
      @media only screen and (min-width:480px) {
      .dys-column-per-100 {
      	width: 100.000000% !important;
      	max-width: 100.000000%;
      }
      }
      @media only screen and (min-width:480px) {
      .dys-column-per-90 {
      	width: 90% !important;
      	max-width: 90%;
      }
      }
      @media only screen and (min-width:480px) {
      .dys-column-per-100 {
      	width: 100.000000% !important;
      	max-width: 100.000000%;
      }
      }
    </style>
  </head>
  <body>
    <div>
      <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#f7f7f7;background-color:#f7f7f7;width:100%;'>
        <tbody>
          <tr>
            <td>
              <div style='margin:0px auto;max-width:80vw;'>
                <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='width:100%;'>
                  <tbody>
                    <tr>
                      <td style='direction:ltr;font-size:0px;padding:20px;text-align:center;vertical-align:top;'>
                        <div class='dys-column-per-90 outlook-group-fix' style='direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;'>
                          <table border='0' cellpadding='0' cellspacing='0' role='presentation' width='100%'>
                            <tbody id="contenido">
                                <tr>
                                    <td align='center' style='background-color:#ffffff;border-top:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;padding:20px 15px;vertical-align:top;'>
                                        <div style='color:#000000;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;line-height:21px;text-align:center;'>
                                            <span>
                                                    <img align='left' alt='Logo' style="height: 35px;margin-left: 30vw;" padding='5px' src='https://dl.dropboxusercontent.com/s/6y61rxw4tzlxwdg/Logo.png?dl=0'/>
                                            </span>
                                            <br>
                                            <br>
                                            <span style='font-weight:700; color: #472380; font-size: 18px;'>
                                                        <?=$Titulo?> <br>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                              <tr>
                                <td style='background-color:#472380;color:#ffffff !important;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;padding:20px 15px;vertical-align:top;'>
                                  <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='' width='100%'>
                                    <tr>
                                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;color:#ffffff !important;'>
                                        <div style='color:#ffffff !important;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;line-height:21px;text-align:center;'>
                                          
                                          <p style="color:#ffffff !important"><?=$Contenido?>
                                          </p>
                                          <br/><br/>
                                          <div align='center'>
                                            <table style="width: 100%;">
                                                <?php 
                                                 $tipo = "";
                                                 $modulo="";
                                                foreach ($Tabla as $key => $value) {
                                                    $valor=$value["transcurrido"]/$value["dias"]; 
                                                ?>

                                                    <?php if ($tipo != $value["tipo"] ): 
                                                        $tipo = $value["tipo"];
                                                        $modulo=isset($value["modulo"])?' - '.$value["modulo"]:'';
                                                    ?>
                                                    <tr style='background-color:#ffffff;color: #472380;'><th colspan='6'><?=$value["tipo"].$modulo?></th></tr>
                                                    <tr style='background-color: #ccc;color: #472380;'>
                                                        <th>SINIESTRO</th>
                                                        <th>FECHA INICIO</th>
                                                        <th>TIPO</th>
                                                        <th>PARAMETRO</th>
                                                        <th>DÍAS TRANSCURRIDOS</th>
                                                        <th>SEMAFORO</th>
                                                    </tr>
                                                    <?php endif; ?>
                                                    <tr style='background-color: #f7f5fa;color: #472380;'>
                                                        <th><?=$value["siniestro_id"]?></th>
                                                        <th><?=date('d-m-y',strtotime($value["ocurrencia"]))?></th>
                                                        <th><?=strtoupper($value["nombre"])?></th>
                                                        <th><?=$value["dias"]?></th>
                                                        <th><?=$value["transcurrido"]?></th>
                                                        <th style='background-color:<?=$Funcion->semaforo($value["transcurrido"]/$value["dias"])?>;'></th>
                                                    </tr>
                                                <?php }?>
                                                <tr style='background-color:#ffffff;color: #ffffff;'>
                                                    <th style='height: 10px;' colspan='6'></th>
                                                </tr>
                                            </table>
                                          </div>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    <tr>
                                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;' vertical-align='middle'>
                                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:separate;line-height:100%;'>
                                          <tr>
                                            
                                            <td align='center' bgcolor='#ff6f6f' role='presentation' style='background-color:#ffffff;border:none;border-radius:5px;cursor:auto;padding:10px 25px;' valign='middle'>
                                              <a href='<?=base_url()?>' style='background:#ffffff;color:#361866;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;font-weight:400;line-height:21px;margin:0;text-decoration:none;text-transform:none;' target='_blank'>
                                                Ir al sitio
                                              </a>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                    <td align='center' style='font-size:0px;padding:50px 25px;word-break:break-word;'>
                                      <div style='color:#646161;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;line-height:21px;text-align:center;'>
                                        <small>© <?=date('Y')?> Capsys v3 - Todos los derechos reservados</small>
                                      </div>
                                    </td>
                                  </tr>
                            </tbody>
                          </table>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </body>
</html>