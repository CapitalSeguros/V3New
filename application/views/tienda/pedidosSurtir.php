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
<section class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-md-10">
	    		<font class="tituloSeccione">
                	Tienda
                	<blockquote>&bull; Pedidos a Surtir</blockquote>
                </font>
			</div>
            <div class="col-sm-2 col-md-2" style="vertical-align:baseline;">
            	<blockquote>
            	<input 
                	type="button" value="Regresar"
                    title="Clic"
                    onclick="window.open('<?=base_url()?>tienda','_self');"
                />
                </blockquote>
            </div>
		</div>
        <?php // $this->load->view('tienda/tiendaestatus',$tiendaestatus); ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
							<td><strong>N&deg; de pedido</strong></td>
							<td><strong>Pendiente</strong></td>
							<td><strong>Usuario</strong></td>
							<td><strong>Fecha</strong></td>
							<td align="right"><strong>Total</strong></td>
							<td width="50">&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidosSurtir as $pedido) { ?>
                            <tr>
                                <td><?php echo $pedido['idPedido']; ?></td>
                                <td><?php echo $this->capsysdre_tienda->DreCalculaPedidoPendiente($pedido['idPedido']); ?></td>
                                <td><?php echo $pedido['name_complete']; ?></td>
                                <td><?php echo date_format(date_create($pedido['fecha']),'d-M-y') ; ?></td>
                                <td class="text-right"><?php echo '$'.number_format($pedido['totalPedido'],2,'.',','); ?></td>
                                <td class="text-right">
                                    <a 
                                    	href="<?="pedidodetalle/".$pedido['idPedido']?>" 
										title="Detalle Pedido"
                                    >
                                    	+ Info
                                    </a>
                                    <?php if($this->capsysdre_tienda->getSurtido($pedido['idPedido'])){ ?>
                                    &nbsp;
			                        <a href="<?php echo "cancelarpedido/".$pedido['idPedido']; ?>" class="glyphicon glyphicon-remove" title="Cancelar Pedido" onClick="return validar('&iquest;Esta seguro que desea eliminar el pedido?')"></a>
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