<?php
	$corte = 0;
	$columnas = 4;
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
                    <li class="active">Categoria</li>
                </ol>
            </div>
        </div>
            <hr /> 
        <?php $this->load->view('tienda/tiendaestatus',$tiendaestatus); ?>
</section>
<section class="page-section">
	<div class="container">
        <div class="row">
        	<div class="col-sm-12 col-md-12" style="text-align:justify;">
            	* En la liquidaci&oacute;n semanal del vendedor se descontar&aacute; un m&aacute;ximo de $65 con un cr&eacute;dito total en la tienda por hasta $1,000.00 
            </div>
        </div>
        <div class="row">
        	<?php
				foreach ($ListaArticulosTienda->result() as $row){
					if ($corte < $columnas) {
        	?>
		  	<div class="col-sm-3 col-md-3">
                <div align="center" style="border:dotted #472380 1px;">
                <table width="200" align="center" cellpadding="1" cellspacing="1">
                	<tr>
                    	<td colspan="2">
							<img src="<?php echo base_url()."assets/img/tienda/articulos/".$row->img_link?>" width="200" height="240" />
                        </td>
                    </tr>
    	            <tr>
        				<td rowspan="2" align="justify" style="padding:5px; text-align:justify; font-size:12px;">
							<?php echo urldecode($row->nombre)?>
                        </td>
        				<td align="right"><strong><?="$".number_format($row->precio,2,'.',',')?></strong></td>
	                </tr>
    	            <tr>
						<td align="right"><strong>MXN</strong></td>
					</tr>
                    <td align="justify"  style="padding:5px  text-align:justify; font-size:12px;"><strong>Puntos</strong></td>
                    <td align="right"><strong>
                            <?php echo urldecode($row->puntos)?>
                        </td>
                    </tr>
                    <?php if($row->controlaTallas == 1){ ?>
                    <tr>
                    	<td colspan="2" align="right">
							<select name="talla" id="talla" style="width:140px;">
								<option value="">Seleccione Talla</option>
								<option value="Ch">Ch</option>
								<option value="M" selected="selected">M</option>
								<option value="G">G</option>
							</select>
                        </td>
                    </tr>
                    <?php } ?>
    	            <tr align="right">
						<td width="140">Cantidad <input type="text" style="width:35px; text-align:center;" value="1" /></td>
						<td width="60"><input class="addProduc " type="button" data-precio="<?php echo $row->precio?>" data-idarticulo="<?php echo $row->idArticulo; ?>" data-categoria="<?php echo $row->idCategoria; ?>" data-puntos="<? echo($row->puntos); ?>" value="Agregar" /></td>
					</tr>
				</table>
                </div>
                <br />
			</div>
			<?php
				$corte = $corte+1; 
					} else {
					$corte = 0; 
			?>
		</div>
        <div class="row">
        	<div class="col-sm-3 col-md-3">
                <div align="center" style="border:dotted #472380 1px;">
                <table width="200" align="center" cellpadding="1" cellspacing="1">
                	<tr>
                    	<td colspan="2">
							<img src="<?=base_url()."assets/img/tienda/articulos/".$row->img_link?>" width="200" height="240" />
                        </td>
                    </tr>
    	            <tr>
        				<td rowspan="2" align="justify" style="padding:5px; text-align:justify; font-size:12px;">
							<?=urldecode($row->nombre)?>
                        </td>
        				<td align="right"><strong><?="$".number_format($row->precio,2,'.',',')?></strong></td>

	                </tr>
    	            <tr>
						<td align="right"><strong>MXN</strong></td>
					</tr>
                    <td align="justify"  style="padding:5px  text-align:justify; font-size:12px;"><strong>Puntos</strong></td>
                    <td align="right"><strong>
                            <?php echo urldecode($row->puntos)?>
                        </td>
                    <?php if($row->controlaTallas == 1){ ?>
                    <tr>
                    	<td colspan="2" align="right">
							<select name="talla" id="talla" style="width:140px;">
								<option value="">Seleccione Talla</option>
								<option value="Ch">Ch</option>
								<option value="M" selected="selected">M</option>
								<option value="G">G</option>
							</select>
                        </td>
                    </tr>
                    <?php } ?>
    	             
                    <tr align="right">
						<td width="140">Cantidad <input type="text" style="width:35px; text-align:center;" value="1" /></td>
						<td width="60"><input class="addProduc" type="button" data-precio="<?php echo $row->precio?>" data-idarticulo="<?php echo $row->idArticulo; ?>" data-categoria="<?php echo $row->idCategoria; ?>" data-puntos="<? echo($row->puntos); ?>" value="Agregar" /></td>-
					   
                    </tr>
                    
				</table>
                </div>
                <br />
			</div>
			<?php
				$corte = $corte+1; 
					} /*! if */
				} /*! foreach */
			?>
        </div>
        
	</div>            
</section>

<script type="text/javascript">
    $(document).ready(function(){
       
       $('.addProduc').click(function(){
          var idArticulo = $(this).attr('data-idarticulo');
          var precio = $(this).attr('data-precio');
          var categoria = $(this).attr('data-categoria');
          var puntos = $(this).attr('data-puntos');
          var parent = $(this).closest('table');
          var cantidad = $(parent).find('input').val();
          var talla = $(parent).find('select').val();
          
          var sUrl = "<?php echo base_url().'tienda/agregarCarrito/';?>"+idArticulo+"/"+cantidad+"/"+precio+"/"+categoria+"/"+talla+"/"+puntos;
          
          $.ajax({
			url: sUrl,
			type: 'GET',
			success: function (data) {
				if(data)
                    location.reload();
			}
		  });
          
       });
        
    });
    
</script>
<?php $this->load->view('footers/footer'); ?>