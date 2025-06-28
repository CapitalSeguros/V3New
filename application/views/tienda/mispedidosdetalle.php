<?php
	$corte = 0;
	$columnas = 3;
    $totalPedido = 0;
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
                    <li><a href="<?php echo base_url(); ?>tienda/mispedidos">Pedidos</a></li>
                    <li class="active">Pedidos detalle</li>
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
                            <td><strong>Articulo</strong></td>
                            <td><strong>Surtido</strong></td>
                            <td><strong>Talla</strong></td>
                            <td><strong>Cantidad</strong></td>
                            <td><strong>Precio</strong></td>
                            <td align="right"><strong>Total</strong></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($misPedidos as $value) { ?>
                        <?php $totalPedido = $totalPedido + ($value['precio'] * $value['cantidad']); ?>
                            <tr>
                                <td><?php echo urldecode($value['nombre']); ?></td>
                                <td align="right">
                                	<?
										if($this->tank_auth->get_usermail()=="MARKETING@AGENTECAPITAL.COM" && urldecode($value['nombre']) == "SALDO SMS" ){
											if($value['cargado'] == "No"){
												$Return	= "tienda";
												$link	= base_url('saldo/cargar')."/".$value['idPedido']."/".$value['idProducto']."/".$Return;
									?>
	                                	<button onclick="window.open('<?= $link; ?>', '_self')">Cargar Saldo</button>
                                    <?
											}
										}
									?>
                                </td>
                                <td><?php echo $value['talla']; ?></td>
                                <td><?php echo $value['cantidad']; ?></td>
                                <td><?php echo '$'.number_format($value['precio'],2,'.',','); ?></td>
                                <td class="text-right"><?php echo '$'.number_format(($value['precio'] * $value['cantidad']),2,'.',','); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="6">
                               Importe Total:  <?php echo '$'.number_format($totalPedido,2,'.',',');?>
                            </td>
                        </tr>
                    </tfoot>
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