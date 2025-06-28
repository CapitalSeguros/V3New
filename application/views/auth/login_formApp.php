<!DOCTYPE html>
<html lang="es">
<? $this->load->view("headers/app/main_header") ?>	
<?
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Usuario (E-Mail)';
} else if ($login_by_username) {
	$login_label = 'Usuario';
} else {
	$login_label = 'E-Mail';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
?>
<body class="login-page">

<div class="login-container">
	<div class="login-branding">
		<a href="<?=base_url()?>"><img src="<?=base_url("assetsApp/")?>/images/logo.png" alt="FLH SiCAd" title="Capsys - Gap"></a>
	</div>
	<div class="login-content">
		<h2><strong>Bienvenido</strong>, Inicia sesi&oacute;n</h2>
		<div id="infoMessage" style="color:#F00;">
        	<strong>
				<? //= $message;?>
			</strong>
        </div>
		<?= form_open($this->uri->uri_string()); ?>
			<div class="form-group">
				<input type="text" id="login" name="login" class="form-control form-control-lg" required placeholder="Usuario (E-Mail)" >
				<div style="color:#DD4B39; ">
					<?= form_error($login['name']); ?>
					<?= isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
				</div>
		  </div>                        
			<div class="form-group">
				<input type="password" id="password" name="password" class="form-control form-control-lg" required placeholder="Contrase&ntilde;a" >
				<div style="color:#DD4B39; ">
					<?= form_error($password['name']); ?>
					<?= isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
				</div>
			</div>
			<!--
            <div class="form-group">
				 <div class="checkbox checkbox-replace">
					<input name="remember" type="checkbox" id="remeber" value="1">
					<label for="remeber">No cerrar sesi&oacute;n</label>
				  </div>
			 </div>
             -->
			<div class="form-group">
						<input type="hidden" name="view" id="view" value="<?= $view?>" />
				<button class="btn btn-primary btn-block">INICIAR SESI&Oacute;N</button>
			</div>
			<!--
            <p class="text-center"><a href="forgot_password">Forgot your password?</a></p>
            -->
		<!-- </form> -->
		<?= form_close(); ?>
	</div>
</div>

<? $this->load->view("footers/app/main_footer") ?>
</body>
</html>