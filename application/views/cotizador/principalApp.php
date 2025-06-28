<!DOCTYPE html>
<html lang="es">
<? $this->load->view("headers/app/main_header") ?>
<style>
/*
.frame-container{
overflow:hidden;
padding-bottom:1%;
position:relative;
height:0;
}
.frame-container iframe{
left:0;
top:0;
## height:100%;
width:100%;
## position:absolute;
}
*/
</style>
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
			<h1 class="page-title">Car Capital</h1>
			<div class="row">
				<div class="col-lg-12">
				<!--SicasUsuario -->
					<div id="frame-container" class="frame-container" style=" width:100%; height:500px; ">
						<!-- <iframe id="frameSicasUsuario" src="" frameborder="0" style="border:0" allowfullscreen width="100%"></iframe> -->
						<iframe width="950px" height="700px" id="frameSicasUsuario" src=""></iframe>
					</div>
				<!-- -->
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
<script type="text/javascript">
	document.getElementById("frameSicasUsuario").setAttribute('src',<?php echo('"'.$codeSicas.'"') ?>);
</script>
</body>
</html>