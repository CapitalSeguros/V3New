<?php
	$corte = 0;
	$columnas = 3;
?>
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Tienda</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li><a href="./">Inicio</a></li>
                    <li><a href="<?php echo base_url(); ?>tienda">Tienda</a></li>
                    <li class="active">Pedidos</li>
                </ol>
            </div>
        </div>
            <hr /> 
        <?php $this->load->view('tienda/tiendaestatus',$tiendaestatus); ?>
</section>
<br />
<section class="page-section">
	<div class="container">
		
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <td><strong>N&deg; de pedido</strong></td>
                            <td><strong>Fecha</strong></td>
                            <td align="right"><strong>Total</strong></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($misPedidos as $value) { ?>
                            <tr>
                                <td><?php echo $value['idPedido']; ?></td>
                                <td><?php echo date_format(date_create($value['fecha']),'d-M-y') ; ?></td>
                                <td class="text-right"><?php echo '$'.number_format($value['totalPedido'],2,'.',','); ?></td>
                                <td class="text-right">
                                    <a href="<?php echo "pedidodetalle/".$value['idPedido']; ?>" class="systemTex" title="Detalle Pedido">+ Info</a>
                                    <?php if($value['surtido'] == "0"){ ?>
                                    &nbsp;
			                        <a href="<?php echo "cancelarpedido/".$value['idPedido']; ?>" class="glyphicon glyphicon-remove" title="Cancelar Pedido" onClick="return validar('&iquest;Esta seguro que desea eliminar el pedido?')"></a>
		                            <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>		

	</div>            
</section>

<script type="text/javascript">
    function validar (message) {
        var result = confirm(message);
        if(result)
            return true;
        else {
            return false;
        }
    }
</script>
<?php $this->load->view('footers/footer'); ?>