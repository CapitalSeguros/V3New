<?php  $this->load->view('headers/header'); ?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
	$CI =& get_instance();
	$data_tab = $CI->is_role_show_tab($this->tank_auth->get_userprofile());
?>
<style>

div.bhoechie-tab-menu{padding-right: 0;padding-left: 0;padding-bottom: 0;}
div.bhoechie-tab-menu div.list-group{margin-bottom: 0;}
div.bhoechie-tab-menu div.list-group>a{margin-bottom: 0;}
div.bhoechie-tab-menu div.list-group>a .glyphicon,div.bhoechie-tab-menu div.list-group>a .fa {color: #5A55A3;}
div.bhoechie-tab-menu div.list-group>a:first-child{border-top-right-radius: 0;-moz-border-top-right-radius: 0;}
div.bhoechie-tab-menu div.list-group>a:last-child{border-bottom-right-radius: 0;-moz-border-bottom-right-radius: 0;}
div.bhoechie-tab-menu div.list-group>a.active,div.bhoechie-tab-menu div.list-group>a.active .glyphicon,div.bhoechie-tab-menu div.list-group>a.active .fa{background-color: #5A55A3;background-image: #5A55A3;color: #ffffff;}
div.bhoechie-tab-menu div.list-group>a.active:after{content: '';position: absolute;left: 100%;top: 50%;margin-top: -13px;border-left: 0;border-bottom: 13px solid transparent;border-top: 13px solid transparent;border-left: 10px solid #5A55A3;}
div.bhoechie-tab-content{background-color: #ffffff;  padding-left: 20px;padding-top: 10px;}
div.bhoechie-tab div.bhoechie-tab-content:not(.active){display: none;}
/*Forms setup*/
.form-control {border-radius:0;box-shadow:none;height:auto;}
.table>tbody>tr>td.pleft{padding-left: 20px;}
.float-label{font-size:10px;}
input[type="text"].form-control,input[type="search"].form-control{border:none;border-bottom:1px dotted #CFCFCF;}
textarea {border:1px dotted #CFCFCF!important;height:130px!important;}
/*Content Container*/
.content-container {background-color:#fff;padding:35px 20px;margin-bottom:20px;}
h1.content-title{font-size:32px;font-weight:300;text-align:center;margin-top:0;margin-bottom:20px;font-family: 'Open Sans', sans-serif!important;}
/*Compose*/
.btn-send{text-align:center;margin-top:20px;}
/*mail list*/
.mail-search{border-bottom-color:#7FBCC9!important; }
#dvReport {font-size: 12px !important;}
.cargando {display:none;position:fixed;z-index:1000;top:0;left:0;height:100%;width:100%;background: rgba( 255, 255, 255, .8 ) url('http://i.stack.imgur.com/FhHRx.gif') 50% 50% no-repeat;}
/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {overflow: hidden; }
/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .cargando {display: block;z-index: 999999999;}
</style>
<section class="main-page main-page-close">
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5">
			<!--<a href="#" id="submenu-secciones" class="submenu-secciones">
				<div class="submenu-secciones-front"><i class="fa fa-angle-right"></i></div>
				<div class="submenu-secciones-back"><i class="fa fa-angle-left"></i></div>
			</a>-->
			<div class="col-md-6 col-sm-5 col-xs-5">
				<h3 class="titulo-secciones">Mailing</h3>
			</div>
			<div class="col-md-6 col-sm-5 col-xs-5">
			</div>			
		</div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
				<li><a href="./">Inicio</a></li>
				<li class="active">Mailing</li>
			</ol>
		</div>
	</div>
	<hr /> 
</section>
<section class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-12 col-sm-12">
					<div class="bhoechie-tab-menu menu-sidebar menu-sidebar-close" id="menuCorreos" style="height:550px">
						<a href="#" id="submenu-secciones" class="submenu-secciones" style="margin-top:80px; margin-left:80px;">
							<div class="submenu-secciones-front"><i class="fa fa-angle-right"></i></div>
							<div class="submenu-secciones-back"><i class="fa fa-angle-left"></i></div>
						</a>
						
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-9 bhoechie-tab-container">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab">

						<div class="bhoechie-tab-content active">
                        	<div class="row">
								<div class="col-sm-12 col-md-12" align="right">
											<a 
                                            	href="<?= base_url('mailing/addCampaigns/');?>"
												class="btn btn-primary btn-sm contact-item"
											>
												<i class="fa fa-plus"></i> Agregar Mailing
											</a>
                                    <br /><br />
        	                    </div>
                            </div>
                            
                        	<div class="row">
							<div class="col-sm-12 col-md-12" align="">
                            <table class="table">
                            	<thead>
                                	<tr>
                                    	<th width="180px"></th>
	                                	<th width="200px">Nombre</th>
    	                            	<th>Correos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
									foreach($infoCampaigns as $campaigns){
										
								?>
                                	<tr>
                                    	<td>
											<a 
                                            	href="<?= base_url('mailing/editCampaigns/'.$campaigns->idMailing);?>"
												class="btn btn-primary btn-xs contact-item"
											>
												<span class="glyphicon glyphicon-pencil" ></span> Editar
											</a>
                                            
											<a
                                            	href="<?= base_url('mailing/deleteCampaigns/'.$campaigns->idMailing);?>"
												class="btn btn-primary btn-xs contact-item"
											>
                        		                <span class="glyphicon glyphicon-remove" ></span> Eliminar
											</a>
                                        </td>
	                                	<td><?= $campaigns->nombre; ?></td>
    	                            	<td>
											<?= $campaigns->correos; ?>
                                            <br /><br />
				                            <table class="table">
                                            	<thead>
                                                	<tr>
                                                    	<th colspan="3"></th>
                                                    </tr>
                                                </thead>
                                				<tbody>
                                                <?

													$sql = "
														Select * From
															`mailing`
														Where
															`padre` = ".$campaigns->idMailing."
														Order By
															`idMailing`
														;
														   ";
													$result	= $this->db->query($sql)->result();
													
													$contHijos	= 0;
													foreach($result as $hijo){
														$contHijos++;
												?>
                                                	<tr>
                                                    	<td width="10px">
                                                        	<strong><?= $contHijos; ?></strong>
                                                        </td>
                                                    	<td width="180px">
															<a 
                				                            	href="<?= base_url('mailing/editCampaigns/'.$hijo->idMailing);?>"
																class="btn btn-primary btn-xs contact-item"
															>
																<span class="glyphicon glyphicon-pencil" ></span> Editar
															</a>
                                            
															<a
                				                            	href="<?= base_url('mailing/deleteCampaigns/'.$hijo->idMailing);?>"
																class="btn btn-primary btn-xs contact-item"
															>
                				        		                <span class="glyphicon glyphicon-remove" ></span> Eliminar
															</a>
                                                        </td>
                                                    	<td><?= $hijo->correos; ?></td>
                                                        
                                                    </tr>
                                                <?
													}
												?>
                                                </tbody>
											</table>
                                        </td>
                                    </tr>
								<?
									}
								?>
                                </tbody>
                            </table>
                            </div>
                            </div>
						</div>
                        
           			</div>
            	</div>
        	</div>
		</div>
	</div>
</section>
</section>
<!--
<div class="container-fluid">
	<div class="row"></div>
</div>-->
<div class="modal cargando"><!-- Place at bottom of page --></div>
<?
	function hijos($idPadre){
		$sql = "
			Select * From
				`mailing`
			Where
				`padre` = ".$idPadre."
			;
			   ";
		$result	= $this->db->query($sql)->result();
		return
			$result;
	}
?>
<script src="<?php echo site_url('assets/js/jquery.generic.cenis.js'); ?>"></script>    
<script type="text/javascript">

		$body = $("body");
		$(document).on({
		    ajaxStart: function() { $body.addClass("loading");    },
		    ajaxStop: function()  { $body.removeClass("loading"); },
		    ajaxError: function() { $body.removeClass("loading"); }    
		});

	</script>
<?php $this->load->view('footers/footer'); ?>