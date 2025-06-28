<?php
    /*function status($estado){
        switch($estado){
           case 1:
                return "<span class='badge badge-default'>Pendiente</span>";
                break;
            case 0:
                return "<span class='badge badge-primary' style='background-color: #39bc6d;color:#fff;'>Aprobada</span>";
                break;
            case -1:
                return "<span class='badge badge-danger' style='background-color: #ee563e;color:#fff;'>Negada</span>";
                break;
        }
    }*/
?>


<table class="table table-stripped" style="width:100%;font-size: 11px;">
    <thead>
        <tr class="text-center">
            <!--<th>Nombre del solitante</th>-->
            <!--<th>Puesto</th>-->
            <th>Antiguedad</th>
            <th>Cantidad de dias</th>
            <th>Fecha solicitud</th>
            <th>Primer día de descanso</th>
            <th>Fecha retorno</th>
            <th>Estado actual</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $total=0;
        foreach($vacaciones as $vacacion){
            if($vacacion->aprobado!=-1){
                $total=$total+$vacacion->cantidad_dias;
            }
    ?>
        <tr class="text-center">
           <!--<td><?php echo $vacacion->nombre;?></td>-->
           <!--<td><?php echo $vacacion->puesto;?></td>-->
           <td><?php echo $vacacion->antiguedad." Año(s)";?></td>
           <td><?php echo $vacacion->cantidad_dias;?></td>
           <td><?php echo date('d-m-Y', strtotime($vacacion->fecha));?></td>
           <td><?php echo date('d-m-Y', strtotime($vacacion->fecha_salida));?></td>
           <td><?php echo date('d-m-Y', strtotime($vacacion->fecha_retorno));?></td>
           <td><p><span class="label label-<?= $vacacion->classLabel ?>"><?= ucwords($vacacion->estado) ?></span></p></td>
           <!--<td><?php //echo status($vacacion->aprobado);?></td>-->
           <td>
            <?php if(!in_array($vacacion->estado, array("aprobado", "rechazado"))){?>
                <div class="dropdown">
                    <button class="btn btn-link btn-sm dropdown-toggle " type="button" id="rv-dpd" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0);" class="delete-vacation-request" data-id="<?=$vacacion->id?>">Cancelar solicitud</a></li>
                    </ul>
                </div>
            <?php }?>
           </td>
       </tr>
    <?php }?>
       <tr>
            <td colspan="3" style="font-size:12px;text-align:right;"><b>Total de dias aprobados ó pendientes del periodo actual:</b></td>
            <td style="text-align:center;font-size:12px;"><b><?php echo $dayRequest;?></b></td>
            <td colspan="3"></td>
        </tr>
    </tbody>
</table>
