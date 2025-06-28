<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $ListaUsuarios->num_rows();
?>
<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>

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
   MakeStaticHeader('Mitabla', 250, 1350, 40, false)
}
 </script>


<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Lista de usuarios</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
                <li><a href="<?=base_url()?>" title="Inicio">Inicio</a></li>
                <li><a href="<?=base_url()."configuraciones"?>" title="Configuración">Configuración</a></li>
				<li class="active">Lista de usuarios</li>
                </ol>
            </div>
        </div>
            <hr /> 
</section>



                
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-md-offset-8 col-sm-offset-8">
                            	<form id="form" method="GET" action="<?=base_url()?>configuraciones/listUser">
	                            	<div class="input-group">
	                                    <input type="text" name="busquedaUsuario" id="busquedaUsuario" class="form-control input-sm" placeholder="Buscar">
	                                    <span class="input-group-btn"><button class="btn btn-primary btn-sm" title="Buscar"><i class="fa fa-search"></i>&nbsp;</button></span>
	                                </div>
								</form>
                                
                            </div>
                        </div>
                        <div class="row">
                        	<?php if (isset($busquedaUsuario) && $busquedaUsuario != ""): ?>
                        		<div class="col-md-12"><br /><p><i>Buscando resultados de: <b><? echo $busquedaUsuario; ?></b>
                        	<?php endif ?>
                        </div>
                    </div>
                </div>


<div id="DivRoot" align="left">
    <div style="overflow: hidden;" id="DivHeaderRow">
    </div>

    <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent">
        <!--Place Your Table Heare-->
                    <div class="table-responsive">
						<table class="table" id='Mitabla'>
							<thead>
		                        <tr>
		                        	<th>Sucursal</th>
		                            <th>Canal</th>
									<th>Perfil</th>
									<th>Nombre</th>
									<th>Email</th>
		                            <!-- <th>Consultor</th> -->
									<th width="50">Acciones</th>
								</tr>
							</thead>
							<tbody>   
							<?php
								if($ListaUsuarios != FALSE){
									foreach ($ListaUsuarios->result() as $row){
							?>
										<tr>
										    <td><?=$this->capsysdre->GetSucursal($row->IdSucursal)?></td>
		                                	<td><?=$this->capsysdre->GetCanal($row->IdCanal)?></td>

		                                	<td><?=$this->capsysdre->NombrePerfilUsuario($row->profile)?></td>
											<td title="<?="[".$row->IDUser."] (".$row->username.") TipoUser: ".$row->idTipoUser?>">
												<?=$row->name_complete?>
                                            </td>
											<td><?=$row->email?></td>
											<!-- <td><?=$this->capsysdre->NombreVendedor($row->IDVendNS)?></td> -->
											<td>
		                                    	<a href='<?=base_url()."configuraciones/editUser?idInterno=".$row->id?>'>
		                                        	<span class='glyphicon glyphicon-pencil'></span>
		                                        </a>
		                                        <!--
		                                        <a href='".base_url()."index.php/bookmarks/eliminar/".$row->id."'>
													<span class='glyphicon glyphicon-trash'></span>
		                                    	</a>
		                                        -->
										</tr>
							<?php
									}
								}
							?>
							</tbody>
                            <?
								if($totalResultados == 0){
							?>
                            <tfoot>
                            	<tr>
                                	<td colspan="4"><center><b>No se encontraron registros.</b></center></td>
                                </tr>
                            </tfoot>
                            <?
								}
							?>
						</table>
               		</div>
               		
   <div id="DivFooterRow" style="overflow:hidden">
                </div>
    </div>


            
                <div class="row">
                    <div class="col-md-12"><small><i>Total de resultados: <b><?=$totalResultados?></b></i></small></div>
                </div>


<?php $this->load->view('footers/footer'); ?>