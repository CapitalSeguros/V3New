<!DOCTYPE html>
<html lang="es">
<? $this->load->view("headers/app/main_header") ?>

<body>
<!-- Page container -->
<div class="page-container">

	<? $this->load->view("headers/app/page_sidebar") ?>
  
	<!-- Main container -->
	<div class="main-container gray-bg">
  
		<!-- Main header -->
		<div class="main-header row">
			<div class="col-sm-6 col-xs-7">
			<? $this->load->view("headers/app/user_info") ?>
			</div>
			
			<div class="col-sm-6 col-xs-5">
			<div class="pull-right">
			<? $this->load->view("headers/app/user_alerts") ?>
			</div>
			</div>
		</div>
		<!-- /main header -->
		
		<!-- Main content -->
		<div class="main-content">
			<h1 class="page-title">Inicio</h1>
			<div class="row">
				<div class="col-lg-12">
					
				</div>
			</div>
            
		<? $this->load->view("footers/app/div_footer-main") ?>
		
	  </div>
	  <!-- /main content -->
	  
  </div>
  <!-- /main container -->
  
</div>
<!-- /page container -->

<? $this->load->view("footers/app/main_footer") ?>
</body>
</html>