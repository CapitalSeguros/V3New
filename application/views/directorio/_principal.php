<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
	
?>




<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Directorio de Clientes</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li class="active">Directorio de Clientes</li>
            </ol>
        </div>
    </div>
        <hr /> 
</section>

<section class="container-fluid">

    					<form  id="myForm" method="POST" action="<?=base_url()?>directorio" >                	
	                        <label for="FechaInicio">Buscar Clientes</label>
	                        <div class="input-group">
	                            <input type="text" class="form-control input-lg" id="BusquedaCliente" name="busquedaDirectorio" value="<?php if(isset($busquedaDirectorio) ){ echo $busquedaDirectorio; } ?>" placeholder="Buscar">
	                            <span class="input-group-btn"><button class="btn btn-primary btn-lg search-trigger"><i class="fa fa-search fa-lg"></i>&nbsp;</button></span>                        
	                            <input type="hidden" value="<?php if(isset($busquedaDirectorio) ){ echo $busquedaDirectorio; } ?>" class="name_search"/>
				  				<input type="hidden"  name="page" class="name_page" value="<?php if(isset($page) ){ echo $page; } ?>"/>
	                        </div>
</form>


<div id="DivRoot" align="left">
    <div style="overflow: hidden;" id="DivHeaderRow">
    </div>

    <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent">
        <!--Place Your Table Heare-->
         <table id="tabla" class="table">
   			<thead>
        			<tr>
           				 <!--<th>ID</th>-->
            			<th style="width:7px">IdCLiente</th>
            			<th style="width:180px">Nombre Completo</th>
            			<th style="width:40px">Ejecutivo</th>
            			<th style="width:10px">Persona</th>
            			<th style="width:5px">Sexo</th>
            			<th style="width:20px">RFC</th>
            			<th style="width:5px">Ranking</th>
            			<th style="width:50px">Club Cap</th>
             			<th style="width:50px">Tipo</th>
            			<th style="width:50px">Documentos</th>
            			<th style="width:50px">Datos Personales</th>
            
        			</tr>
    		</thead>

   			<tbody>
       			<?php if(isset($data_result) && $data_result != ""){  ?>
        			<?php
                    	foreach ($data_result["cliente"] as $Cliente) { ?>
                      		<tr>
                       
                        		<td><p style="cursor: pointer; cursor: hand;" >
                            		<?php echo $Cliente->IDCli; ?>
                            
                         		</td>

                        		<td><?php echo $Cliente->NombreCompleto; ?></td>
                        		<td><?php echo $Cliente->EjecutNombre; ?></td>
                        		<td><?php echo $Cliente->TipoEnt_TXT; ?></td>
                        		<td><?php echo $Cliente->Sexo_TXT; ?></td>
                        		<td><?php echo $Cliente->RFC; ?></td>
                        		<td><?php echo $Cliente->Calidad; ?></td>
                        		<td><?php echo $Cliente->Expediente; ?></td>

                        		<?php if($Cliente->FieldInt2=="0" ){ ?>
                        		<td><?php  echo 'Cliente'; ?> </td> 
                       			<?php  }else{  ?>
                        		<td><?php  echo 'Prospecto'; ?> </td> <?php  } ?>
                       
                       			 <td>
                        	|		<a href="<?php echo base_url(); ?>directorio/GetPoliza?IDCli=<?php echo $Cliente->IDCli; ?>&page=<?php echo $page; ?>" class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-eye-open" ></span>Ver Polizas</a>
                      
                       			</td>
								<td>
                          			<a  href="<?php echo base_url(); ?>directorio/registroDetalle?IDCli=<?php echo $Cliente->IDCli; ?>&page=<?php echo $page; ?>" 



                          			class='btn btn-primary btn-xs contact-item' data-toggle="modal" data-original-title>
						 			 <span class="glyphicon glyphicon-eye-open" ></span> 
						   				Ver Datos</a>
								</td>   

                      		</tr>     
                    	<?php       
                         }
                     	?>

        		<?php       
            	 	}
       		 	?>             					
    		</tbody>
        </table> 
    </div>

    <div id="DivFooterRow" style="overflow:hidden">
    </div>
</div>

</section>  

<section class="container-fluid">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12">
    					<form  id="myForm" method="POST" action="<?=base_url()?>directorio" >                	
	                     
	                    </form>
                    </div>
                </div>
                <div class="row">
	                <?php
					if(isset($data_result) && $data_result != ""){
					?>
					
                    <div class="clearfix"></div>
					<?php if((count($data_result["prospecto"]) == 0) && (count($data_result["cliente"]) == 0)){
						echo '<div class="text-center"><h4>No se encontraron registros.<h4></div>';
						} ?>
					<div class="form-group col-md-12 " style="<?php echo (count($data_result["prospecto"]) == 0) ? 'display:none':'';  ?>">	
                    	                
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
				
				</div>
            </div>
        </div>
        
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <!-- <p class="h6 visualizar-registros">Registros visualizados: 11-20 de 45 registros</p> -->
        </div>
        <div class="col-md-6 col-sm-6 text-right">
            <nav>
                <ul class="pagination">
                    <?php
								if(isset($data_result["paginacion"]) && isset($data_result["paginacion"]["Pages"])){
										$paginas 		= $data_result["paginacion"]["Pages"];
								$pagina_actual = $data_result["paginacion"]["Page"];
							
								if($paginas >= 1){
									for ($i = 1; $i <= $paginas ; $i++) {
										
										if($i == 1){
											?>
											<li>
											  <a href="#" aria-label="Previous" class="pag_cenis" data-pag="<?php echo $i ?>">
												<span aria-hidden="true">&laquo;</span>
											  </a>
											</li>
											<?php
										}
										
										if ($i == $pagina_actual) {
											?>
											<li><a href="#" class="pag_cenis active" aria-label="<?php echo $i ?>" data-pag="<?php echo $i ?>"><?php echo $i ?></a></li>
											<?php
										}else{
											?>
											<li><a href="#" class="pag_cenis" aria-label="<?php echo $i ?>" data-pag="<?php echo $i ?>" ><?php echo $i ?></a></li>
											<?php
										}
										
										if($i == $paginas){
											?>
											<li>
											  <a href="#" aria-label="Next" data-pag="<?php echo $i ?>" class="pag_cenis">
												<span aria-hidden="true">&raquo;</span>
											  </a>
											</li>
											<?php
										}
										
									}
									
								}
								}								
							?>
                </ul>
            </nav>
            
        </div>
    </div>
</section>

<!--:::::::::: FIN CONTENIDO ::::::::::-->
<script>
//para paginacion
$(document).ready(function(){
	$(".pag_cenis").click(function(e){
		  e.preventDefault();
		
		$data_page = $(this).attr("data-pag");
		$data_search = $(".name_search").val();
		
		$("input[name=page]").val($data_page );
		$("input[name=busquedaDirectorio]").val($data_search);		
		$('#myForm').trigger('submit');	
	});
//	$("select option").select(){ }
	$("#Cliente").change(function(){
		$IDCli = $(this).val();
		/*
		$NameSelect = $(this).attr("name");

		if($NameSelect != "Proveedores"){ //--> JjHe
			DetalleRegistro($IDCli);
		} else {
			DetalleRegistroProveedor($IDCli);
		}
		*/
		DetalleRegistro($IDCli);
	});
	
	$("#Prospecto").change(function(){
		$IDCli = $(this).val();
		/*
		$NameSelect = $(this).attr("name");

		if($NameSelect != "Proveedores"){ //--> JjHe
			DetalleRegistro($IDCli);
		} else {
			DetalleRegistroProveedor($IDCli);
		}
		*/
		DetalleRegistro($IDCli);
	});
	
	$("#Proveedor").change(function(){
		$IDCli = $(this).val();
		/*
		$NameSelect = $(this).attr("name");

		if($NameSelect != "Proveedores"){ //--> JjHe
			DetalleRegistro($IDCli);
		} else {
			DetalleRegistroProveedor($IDCli);
		}
		*/
		DetalleRegistroProveedor($IDCli);
	});
	

	function DetalleRegistro(IDCli){
		window.open('<?php echo base_url(); ?>directorio/registroDetalle?IDCli='+IDCli,'_self');
	}
	/* JjHe */
	function DetalleRegistroProveedor(IdOrganizacion){
		window.open('<?php echo base_url(); ?>directorio/registroDetalleProveedor?IdOrganizacion='+IdOrganizacion,'_self');
	}
});
</script>

<script language="javascript" type="text/javascript">
    function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) {
        var tbl = document.getElementById(gridId);
        if (tbl) {
        var DivHR = document.getElementById('DivHeaderRow');
        var DivMC = document.getElementById('DivMainContent');
        var DivFR = document.getElementById('DivFooterRow');

        //*** Set divheaderRow Properties ****
        DivHR.style.height = headerHeight + 'px';
        DivHR.style.width = (parseInt(width) - 16) + 'px';
        DivHR.style.position = 'relative';
        DivHR.style.top = '0px';
        DivHR.style.zIndex = '10';
        DivHR.style.verticalAlign = 'top';

        //*** Set divMainContent Properties ****
        DivMC.style.width = width + 'px';
        DivMC.style.height = height + 'px';
        DivMC.style.position = 'relative';
        DivMC.style.top = -headerHeight + 'px';
        DivMC.style.zIndex = '1';

        //*** Set divFooterRow Properties ****
        DivFR.style.width = (parseInt(width) - 16) + 'px';
        DivFR.style.position = 'relative';
        DivFR.style.top = -headerHeight + 'px';
        DivFR.style.verticalAlign = 'top';
        DivFR.style.paddingtop = '2px';

        if (isFooter) {
         var tblfr = tbl.cloneNode(true);
      tblfr.removeChild(tblfr.getElementsByTagName('tbody')[0]);
         var tblBody = document.createElement('tbody');
         tblfr.style.width = '100%';
         tblfr.cellSpacing = "0";
         //*****In the case of Footer Row *******
         tblBody.appendChild(tbl.rows[tbl.rows.length - 1]);
         tblfr.appendChild(tblBody);
         DivFR.appendChild(tblfr);
         }
        //****Copy Header in divHeaderRow****
        DivHR.appendChild(tbl.cloneNode(true));
     }
    }


    function OnScrollDiv(Scrollablediv) {
    document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
    document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
    }

     window.onload = function() {
   MakeStaticHeader('tabla', 250, 1350, 40, false)
</script>

<?php $this->load->view('footers/footer'); ?>