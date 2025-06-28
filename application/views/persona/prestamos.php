<? $this->load->view('headers/header');
    $this->load->view('headers/menu'); ?>
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<br>
<div class="container">
<div class="well" style="background-color: #fff;width: 100%;">
    <div class="row">
        <div class="col-md-6"><h4>Resumen Total</h4></div>
    </div>
     <div class="row">
        <div class="col-md-2"><b><i class="fa fa-money"></i> Total en Prestamos:</b></div>
        <div class="col-md-2" style="text-align: right;"><div id="divTotalPrestamo"></div></div>
    </div>
    <div class="row">
         <div class="col-md-2"><b><i class="fa fa-university"></i> Total en Ahorros:</b></div>
         <div class="col-md-2" style="text-align: right;"><div id="divTotalAhorro"></div></div>
    </div>
</div>
<!--Prestamos-->
<h4><i class="fa fa-money"></i>&nbsp;Prestamos solicitados</h4>
<p>
<div class="well" style="background-color: #fff;">


    <!--Combo de Filtrado por subordinados-->
<?php if(in_array($this->tank_auth->get_usermail(),$correosCoordinadores)){?>
<div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-6">
        <label><i class='fa fa-filter'></i> Filtro Personal a su Cargo</label>
        <select class="form-control" id="filtroDirect" onchange="filtroByCoord(this)">
            <option value="0"></option>
            <?php 
            $opciones="";
           foreach ($puestos as $key => $value) {
            $opciones.='<optgroup label="'.$key.'">';
              foreach ($value as  $valuePP){
                if($this->tank_auth->get_usermail()!=$valuePP->email){
                    $texto='';
                    $texto.=$valuePP->apellidoPaterno.' '.$valuePP->apellidoMaterno.' ';
                    $texto.=$valuePP->nombres.'( <label style="color:blak">'.$valuePP->personaPuesto.'</label>,'.$valuePP->email.')';
                    $opciones.='<option value="'.$valuePP->idPersona.'">'.$texto.'</option>';
                  }
              }
              $opciones.='</optgroup>';
            }
        echo $opciones;
            ?>
        </select>
    </div>
</div>
<div>
<?php }?>
<br>




      <table class="table table-responsive table-hover" id="table_prestamos" style="font-size: 11px;width: 100%">
        <thead>
            <tr>
                <th style="width: 30%;">
                    Nombre del Solicitante
                </th>
                <th style="width: 10%;">
                    Puesto
                </th>
                <th style="width: 10%;">
                    Importe Solicitado
                </th>
                <th style="width: 20%;">
                    Fecha de Solicitud
                </th>
                <th style="width: 10%;">
                    Estado Actual
                </th>
                <th style="width: 10%;">
                    <i class="fa fa-cogs"></i>
                </th>
                <th style="width: 10%;">
                    <i class="fa fa-cogs"></i>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php
        function status($estado){
            switch ($estado) {
                case 1:
                    return "<span style='font-weight:bold;font-size: 12px;'>Pendiente</span>";
                    break;
                case 0:
                    return "<span class='badge badge-primary' style='background-color: #39bc6d;color:#fff;'>Aprobada</span>";
                    break;
                case -1:
                    return "<span class='badge badge-danger' style='background-color: #ee563e;color:#fff;'>Negada</span>";
                    break;
                default:
                    return "<span class='badge badge-default'></span>";
                    break;
            }
        }
        $acumPrestamo=0;
        foreach($prestamos as $prestamo){
            $acumPrestamo+=$prestamo->monto;
        ?>
            <tr>
                <td><?php echo $prestamo->nombre;?></td>
                <td><?php echo $prestamo->puesto;?></td>
                <td style="text-align: right;"><b><?php echo number_format($prestamo->monto,2);?></b></td>
                <td><?php echo $prestamo->fecha?></td>
                <td><?php echo status($prestamo->aprobado)?></td>
                <td style="text-align: center;"><button class="btn btn-primary btn-xs" onclick="setAprobar('<?php echo $prestamo->id;?>','prestamos')"><i class="fa fa-check"></i>&nbsp;Aprobar</button></td>
                <td style="text-align: center;"><button class="btn btn-warning btn-xs" onclick="setNegar('<?php echo $prestamo->id;?>','prestamos')"><i class="fa fa-times-circle"></i>&nbsp;Negar</button></td>
        <?php }?>
            </tr>
        </tbody>
    </table>
</div>
</p>
<input type="hidden" id="acumPrestamo" value="<?php echo number_format($acumPrestamo,2);?>">
<!--Fin de Prestamos-->

<br>
<!--Ahorros-->
<h4><i class="fa fa-university"></i>&nbsp;Ahorros solicitados</h4>
<p>
<div class="well" style="background-color: #fff;">
      <table class="table table-responsive table-hover" id="table_ahorros" style="font-size: 11px;width: 100%">
        <thead>
            <tr>
                <th style="width: 30%;">
                    Nombre del Solicitante
                </th>
                <th style="width: 10%;">
                    Puesto
                </th>
                <th style="width: 10%;">
                    Importe Solicitado
                </th>
                <th style="width: 20%;">
                    Fecha de Solicitud
                </th>
                <th style="width: 10%;">
                    Estado Actual
                </th>
                <th style="width: 10%;">
                    <i class="fa fa-cogs"></i>
                </th>
                <th style="width: 10%;">
                    <i class="fa fa-cogs"></i>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php
        $acumAhorro=0;
        foreach($ahorros as $ahorro){
            $acumAhorro+=$ahorro->monto;?>
            <tr>
                <td><?php echo $ahorro->nombre;?></td>
                <td><?php echo $ahorro->puesto;?></td>
                <td style="text-align: right;"><b><?php echo number_format($ahorro->monto,2);?></b></td>
                <td><?php echo $ahorro->fecha?></td>
                <td><?php echo status($ahorro->aprobado)?></td>
                <td style="text-align: center;"><button class="btn btn-primary btn-xs" onclick="setAprobar('<?php echo $ahorro->id;?>','ahorros')"><i class="fa fa-check"></i>&nbsp;Aprobar</button></td>
                <td style="text-align: center;"><button class="btn btn-warning btn-xs" onclick="setNegar('<?php echo $ahorro->id;?>','ahorros')"><i class="fa fa-times-circle"></i>&nbsp;Negar</button></td>
        <?php }?>
            </tr>
        </tbody>
    </table>
</div>
</p>
</div>
<!--Fin de Ahorros-->
<input type="hidden" id="acumAhorro" value="<?php echo number_format($acumAhorro,2);?>">
</div><!--Fin container-->


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript">
  $(document).ready( function () {
     $('#table_prestamos').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por Pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrar Pagina por Pagina",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "search":"Buscar",
            "paginate": {
            "previous": "Anterior",
            "next": "Siguiente"
        }
        }
    } );

      $('#table_ahorros').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por Pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrar Pagina por Pagina",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "search":"Buscar",
            "paginate": {
            "previous": "Anterior",
            "next": "Siguiente"
        }
        }
    } );

} );
</script>
<script type="text/javascript">
    var totalPrestamo=document.getElementById('acumPrestamo').value;
    var totalAhorro=document.getElementById('acumAhorro').value;
    document.getElementById('divTotalPrestamo').innerHTML=totalPrestamo+" MXN";
    document.getElementById('divTotalAhorro').innerHTML=totalAhorro+" MXN";

    function setAprobar(id,tabla){
        var op=confirm("¿Es Ud. seguro de aprobar dicha solictud?");
        if(op==1){
            document.location.href='<?php echo base_url()?>fastFile/setAprobar?id='+id+"&tabla="+tabla;
        }
    }
    function setNegar(id,tabla){
        var op=confirm("¿Es Ud. seguro de negar dicha solictud?");
        if(op==1){
            document.location.href='<?php echo base_url()?>fastFile/setNegar?id='+id+"&tabla="+tabla;
        }
    }
     function filtroByCoord(evt){
        document.location.href="<?php echo base_url()?>fastFile/prestamos?id="+evt.value;
    }
</script>

