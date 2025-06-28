<div class="text-right">
    <?php if(isset($tiendaestatus)){ ?>
        <?php if($tiendaestatus['pedidos']): ?>
            <a href="<?php echo base_url().'tienda/mispedidos'; ?>" class="systemTex" title="Checa Tus Pedidos">Mis Pedidos</a>
        <?php endif; ?>
        
        <?php if(isset($tiendaestatus['carrito']) && $tiendaestatus['carrito']): ?>
            <a href="<?php echo base_url().'tienda/misproductos'; ?>" class="systemTex" title="Checa Tu Carrito"> | Productos: <strong><?php echo count($tiendaestatus['carrito']); ?></strong> <span class="glyphicon glyphicon-shopping-cart" /> </a>    
        <?php endif; ?>
    <?php } ?>   
</div>


