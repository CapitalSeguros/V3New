<?php
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
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);

?>

<?php $this->load->view('headers/header'); ?>
<meta name="viewport" content="width=device-width, user-scalable=no">
<style type="text/css">
	.login{
		-webkit-box-shadow: 0px 2px 10px 0px rgba(0,0,0,1);
		-moz-box-shadow: 0px 2px 10px 0px rgba(0,0,0,1);
		box-shadow: 0px 2px 10px 0px rgba(0,0,0,1);
		border-radius: 8px;
		width: 50%;
		text-align: center;
		padding: 2%;
		font-family: verdana;
	}
	#password{
		border-radius: 10px;
		font-family: verdana;
		font-size: 14px;
	}
	#login{
		border-radius: 10px;
		font-family: verdana;
		font-size: 14px;
	}	
	.btn{
		border-radius: 10px;
		font-family: verdana;
		font-size: 14px;
	}
	.btn:hover{
		background-color: #DBA901;
		border-color: #DBA901;
	}
	.sello{
		font-family: verdana;
		font-size: 14px;
		margin-left: 1%;
		color: #ffffff;
		background: #FFF;
		text-shadow: -1px -1px 1px rgba(255,255,255,.1), 1px 1px 1px rgba(0,0,0,.8);
	}
	.header-cap{
		background: rgba(255,255,255,1);
		background: -moz-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 8%, rgba(36,78,122,1) 49%, rgba(36,78,122,1) 100%);
		background: -webkit-gradient(left top, right top, color-stop(0%, rgba(255,255,255,1)), color-stop(8%, rgba(255,255,255,1)), color-stop(49%, rgba(36,78,122,1)), color-stop(100%, rgba(36,78,122,1)));
		background: -webkit-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 8%, rgba(36,78,122,1) 49%, rgba(36,78,122,1) 100%);
		background: -o-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 8%, rgba(36,78,122,1) 49%, rgba(36,78,122,1) 100%);
		background: -ms-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 8%, rgba(36,78,122,1) 49%, rgba(36,78,122,1) 100%);
		background: linear-gradient(to right, rgba(255,255,255,1) 0%, 
</style>
<div class="page-container">
<?
if($view == "Pc"){
?>
<header class="header-cap"></header>
	<section id="loginIndex">
<?php echo form_open($this->uri->uri_string()); ?>
		<header class="header-Login	">
        	<span class="sello">Capsys Web V3.0 PLUS TICC VERSION</span>
		</header>
		<div class="container">
			<center>
			<div class="login">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<a class="logoIndex" href="">
                    	<img src="<?=base_url()?>assets/img/logoCapsys_Login1.png" alt="logo_CapSys_Web" style="width: 25%;height: 100px;">
                    	</a>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<input type="text" id="login" name="login" class="form-control" required placeholder="Usuario (E-Mail)" >
							<div style="color:#DD4B39; ">
                            	<?php echo form_error($login['name']); ?>
								<?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
                            </div>
						</div>	
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group">
								<input type="password" id="password" name="password" class="form-control" required placeholder="Contrase&ntilde;a" >
								<div style="color:#DD4B39; ">
									<?php echo form_error($password['name']); ?>
									<?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
	                            </div>
	                            <input type="hidden" name="view" id="view" value="<?= $view?>" />
							</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
							<?php
	if($show_captcha){
		if($use_recaptcha){
?>
				<div class="row">
                	<div class="col-lg-12 col-md-12 col-sm-12">
                    	<div class="form-group">
                        	<center>
                            	<div id="recaptcha_image"></div>
                                <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
                                <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
                                <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
								<div class="recaptcha_only_if_image">Enter the words above</div>
								<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
                                <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                                <font style="color:red"/><?php echo form_error('recaptcha_response_field'); ?>
								<?php echo $recaptcha_html; ?>
<?php 
		} else {
?>
                                <p>Enter the code exactly as it appears:</p>
                                <?php echo $captcha_html; ?>
								<?php echo form_label('Confirmation Code', $captcha['id']); ?>
                                <?php echo form_input($captcha); ?>
                                <?php echo form_error($captcha['name']); ?>
                            </center>
                        </div>
                    </div>
                </div>
<?php 
		}
	}
?>
					</div>
				</div>


				<div class="row">
					<div class="col-lg-12 col-md-6 col-sm-12" style="text-align: left;">
						<div class="form-group">
							<?php echo form_checkbox($remember); ?>
							No cerrar sesi&oacute;n
						</div>
                    </div>
                	<div class="col-lg-12 col-md-6 col-sm-12">
						<div class="form-group" align="right">
							<?php // echo anchor('/auth/forgot_password/', '&iquest;Has olvidado la contrase&ntilde;a?'); ?>
							<?php //if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Registro'); ?>
						</div>
                    </div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12" style="text-align: right;">
						<div class="form-group">
							<input type="submit" value="Accesar" class="btn btn-primary btn-block" /><br>
									<a  href="<?=base_url()?>recuperaPassword">   ¿Problemas para iniciar tu sesion?</a>
						</div>
					</div>
				</div>



			</div><!-- Fin de login div-->

		<?php echo form_close(); ?>
			</center>

</section>


<!--		

			<div class="col-sm-6 wow fadeInDown" data-wow-duration="3s" data-wow-delay="0s">
            	<center>
					<a class="logoIndex" href="">
                    	<img src="<?=base_url()?>assets/img/logoCapsys_Login1.png" alt="logo_CapSys_Web" height="199" >
                    </a>
				</center>
            </div>
        	<div class="col-sm-6">
		<?php echo form_open($this->uri->uri_string()); ?>
				<h2>Acceso al Sistema</h2>
				<hr />
				<div class="row">
					<div class="col-6">
						<img src="<?=base_url()?>assets/img/logoCapsys_Login1.png" alt="logo_CapSys_Web" height="199" >
					</div>
				</div>
				<div class="row">
                	<div class="col-sm-6">
						<div class="form-group">
							<input type="text" id="login" name="login" class="form-control" required placeholder="Usuario (E-Mail)" >
							<div style="color:#DD4B39; ">
                            	<?php echo form_error($login['name']); ?>
								<?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
                            </div>
						</div>
                    </div>
                	<div class="col-sm-6">
						<div class="form-group">
							<input type="password" id="password" name="password" class="form-control" required placeholder="Contrase&ntilde;a" >
							<div style="color:#DD4B39; ">
								<?php echo form_error($password['name']); ?>
								<?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
                            </div>
                            <input type="hidden" name="view" id="view" value="<?= $view?>" />
						</div>
                    </div>
                </div>
<?php
	if($show_captcha){
		if($use_recaptcha){
?>
				<div class="row">
                	<div class="col-sm-12">
                    	<div class="form-group">
                        	<center>
                            	<div id="recaptcha_image"></div>
                                <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
                                <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
                                <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
								<div class="recaptcha_only_if_image">Enter the words above</div>
								<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
                                <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                                <font style="color:red"/><?php echo form_error('recaptcha_response_field'); ?>
								<?php echo $recaptcha_html; ?>
<?php 
		} else {
?>
                                <p>Enter the code exactly as it appears:</p>
                                <?php echo $captcha_html; ?>
								<?php echo form_label('Confirmation Code', $captcha['id']); ?>
                                <?php echo form_input($captcha); ?>
                                <?php echo form_error($captcha['name']); ?>
                            </center>
                        </div>
                    </div>
                </div>
<?php 
		}
	}
?>
				<div class="row">
                	<div class="col-sm-6">
						<div class="form-group" align="right">
							<?php echo form_checkbox($remember); ?>
							No cerrar sesi&oacute;n
						</div>
                    </div>
                	<div class="col-sm-6">
						<div class="form-group" align="right">
			<?php // echo anchor('/auth/forgot_password/', '&iquest;Has olvidado la contrase&ntilde;a?'); ?>
			<?php //if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Registro'); ?>
						</div>
                    </div>
                </div>
				<div class="row">
                	<div class="col-sm-12">
						<div class="form-group">
							<input type="submit" value="Accesar" class="form-control" />
									<a style="padding-left: 130px"  href="<?=base_url()?>recuperaPassword">   ¿Problemas para iniciar tu sesion?</a>
						</div>
                    </div>
				</div>
			</div>
		<?php echo form_close(); ?>

</div>

		</div>
	</section>
	<section align="right">
	</section>-->
<?
} else if($view == "App"){
?>
	<header class="header-capapp">
    	<div align="right">
			Capsys Web V3.0 PLUS
			&nbsp;&nbsp;&nbsp;
		</div>
	</header>
	<div class="container"><!-- container-fluid -->
		<!-- -->
	<section id="loginIndex">
		<div class="row">
			<div class="col-12 wow fadeInDown" data-wow-duration="3s" data-wow-delay="0s">
            	<center>
					<a class="logoIndex" href="">
                    	<img src="<?=base_url()?>assets/img/logoCapsys_Login1.png" alt="logo_CapSys_Web" width="180">
                    </a>
			  </center>
			</div><!-- !col-12 -->
		</div><!-- !row -->

		<?= form_open($this->uri->uri_string()); ?>

			<div class="row">
				<div class="col-12">
					<h2>Acceso al Sistema</h2>
					<hr />
				</div>
            </div>
            
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<input type="text" id="login" name="login" class="form-control form-control-lg" required placeholder="Usuario (E-Mail)" >
						<div style="color:#DD4B39; ">
							<?= form_error($login['name']); ?>
							<?= isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
						</div>
					</div>
				</div>
			</div>
				
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<input type="password" id="password" name="password" class="form-control form-control-lg" required placeholder="Contrase&ntilde;a" >
							<div style="color:#DD4B39; ">
								<?= form_error($password['name']); ?>
								<?= isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
                            </div>
						<input type="hidden" name="view" id="view" value="<?= $view?>" />
					</div>
				</div>
			</div>
                
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<button type="submit" class="form-control btn btn-primary" style="color:#FFF">Accesar</button>
					</div>
				</div>
			</div>

		<?= form_close(); ?>

	</section>
	
    </div><!-- !container-fluid -->
<?
}
?>

<?php /*$this->load->view('footers/footer');*/ ?>

<style type="text/css">
	body{background-color: white}

.header-capapp {
	width: 100%;
	/*height: 120px;*/
	min-height: 60px;
	height: auto;
	background: #472380;
	color:#FFF;
}
</style>