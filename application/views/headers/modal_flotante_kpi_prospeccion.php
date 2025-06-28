
<style type='text/css'>
         #divEjecutivosOperativos{
            position:fixed;
            left: 0%;
            width:350px;
            height: auto;
            border-radius: 8px;
            background-color:#fff;
            top: 15%;
            z-index: 3000;
         }
        .actividades{
            border-radius: 4px;
            width: 100%;
            background-color: #85C1E9;
            color: #fff;
        }
</style>
<?php
$user=$this->tank_auth->get_usermail();
$ci =& get_instance();
$ci->load->model('cuadromando_model');
$mes=date('m');
$year=date('Y');
$ctSinVenta=$this->cuadromando_model->getProspectosKPI($mes,$year,'DIMENSION',0);
$ctPerfilados=$this->cuadromando_model->getProspectosKPI($mes,$year,'PERFILADO',0);
$ctContactados=$this->cuadromando_model->getProspectosKPI($mes,$year,'CONTACTADO',0);
$ctCotizados=$this->cuadromando_model->getProspectosKPI($mes,$year,'COTIZADO',0);
$ctEmitidos=$this->cuadromando_model->getProspectosKPI($mes,$year,'COTIZADO',1);
$ctCerrados=$this->cuadromando_model->getProspectosKPI($mes,$year,'CERRADO',0);

$flotante_nuevo.="
<div class='card' style='margin-top: 5px'>
    <div class='card-header text-center'>
        <a data-toggle='collapse' href='#muestra_avance_prospeccion' aria-expanded='true' aria-controls='muestra_avance_prospeccion'><i class='fa fa-cogs'></i>&nbsp;KPI Prospección<span class='caret'></span></a>
    </div>
    <div class='card-body collapse' id='muestra_avance_prospeccion'>
    <div class='actividades text-left' style='margin-top: 10px;>
        <label for='polizaEfectuada' style='margin-top:5px;'>&nbsp;&nbsp;<i class='fa fa-users' aria-hidden='true'></i>
        &nbsp;Prospección".$meses[date('n')].", ".date('Y')."
        </label>
    </div>
        <br>
        <table style='text-align: center;font-size: 11px;width: 100%;'>
            <tr>
                <td>
                <div style='background-color: #E6E6E6;color: #000;padding: 1px;'>Sin venta</div>
                </td>
                <td>
                <div style='background-color: #347ab7;color: #fff;padding: 1px;'>Perfilads</div>
                </td>
                <td style='text-align: center;'>
                <div style='background-color: #E6E6E6;color: #000;padding: 1px;'>Contactads</div>
                </td>
                <td>
                <div style='background-color: #347ab7;color: #fff;padding: 2px;'>Cotizads</div></td>
                <td style='text-align: center;'>
                <div style='background-color: #E6E6E6;color: #000;padding: 1px;'>Emitids</div>
                </td>
                <td>
                <div style='background-color: #347ab7;color: #fff;padding: 1px;'>Cerrads</div></td>
            </tr>
           <tr style='opacity: 0.8;'>
                <td style='background-color: #E6E6E6;color: #000;font-weight: bold;font-size: 12px;'>". $ctSinVenta."</b></td>
                <td style='background-color: #347ab7;color: #fff;background-color:#347ab7;color: #fff;font-weight: bold;font-size: 12px;'>".$ctPerfilados."</td>
                <td style='background-color: #E6E6E6;color: #000;font-weight: bold;font-size: 12px;'>". $ctContactados."</b></td>
                <td style='background-color: #347ab7;color: #fff;background-color:#347ab7;color: #fff;font-weight: bold;font-size: 12px;'>".$ctCotizados."</td>
                <td style='background-color: #E6E6E6;color: #000;font-weight: bold;font-size: 12px;'>".$ctEmitidos."</b></td>
                <td style='background-color: #347ab7;color: #fff;background-color:#347ab7;color: #fff;font-weight: bold;font-size: 12px;'>". $ctCerrados."</td>
            </tr>
        </table>
        <br>
    </div>
</div>";
