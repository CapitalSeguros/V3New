<?php
    function statusAhorros($estado){
        switch($estado){
           case 1:
                return "<span class='badge badge-default'>Pendiente</span>";
                break;
            case 0:
                return "<span class='badge badge-primary' style='background-color: #39bc6d;color:#fff;'>Aprobado</span>";
                break;
            case -1:
                return "<span class='badge badge-danger' style='background-color: #ee563e;color:#fff;'>Negado</span>";
                break;
        }
    }
?>


<table class="table table-stripped" style="width:100%;font-size: 11px;">
    <thead>
        <tr>
            <td colspan="5" style="text-align: center;color: #fff;">LISTADO DE SOLITUDES DE AHORROS</td>
        </tr>
        <tr>
            <th>Nombre del solitante</th>
            <th>Puesto</th>
            <th>Monto</th>
            <th>Fecha solicitud</th>
            <th>Estado actual</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $total=0;
        foreach($ahorros as $ahorro){
            if($ahorro->aprobado!=-1){
                $total=$total+$ahorro->monto;
            }
    ?>
        <tr>
           <td><?php echo $ahorro->nombre;?></td>
           <td><?php echo $ahorro->puesto;?></td>
           <td style="text-align:right;"><?php echo number_format($ahorro->monto,2);?></td>
           <td><?php echo date('d-m-Y', strtotime($ahorro->fecha));?></td>
           <td><?php echo statusAhorros($ahorro->aprobado);?></td>
       </tr>
    <?php }?>
       <tr>
            <td colspan="2" style="font-size:12px;text-align:right;"><b>Total aprobado ó pendiente:</b></td>
            <td style="text-align:right;font-size:12px;"><b><?php echo number_format($total,2);?></b></td>
            <td colspan="2"></td>
        </tr>
    </tbody>
</table>

