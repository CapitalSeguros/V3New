<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
$idVendedor = array(
	'name' 	=> 'idVendedor',
	'id' 	=> 'idVendedor',
	'options' => $this->capsysdre->ArrayVendedor(),
	'selected' => set_value('idVendedor'),
);
$IDGrupo = array(
	'name' 	=> 'IDGrupo',
	'id' 	=> 'IDGrupo',
	'options' => $this->capsysdre->ArrayGrupos(),
	'selected' => set_value('IDGrupo'),
);
$IDSGrupo = array(
	'name' 	=> 'IDSGrupo',
	'id' 	=> 'IDSGrupo',
	'options' => $this->capsysdre->ArraySubGrupos(),
	'selected' => set_value('IDGrupo'),
);

$profile = array(
	'name' 	=> 'profile',
	'id' 	=> 'profile',
	'options' => array(''=>'-- Seleccione --','MASTER'=>'MASTER', 'OPERATIVO'=>'OPERATIVO', 'SUPERIOR'=>'SUPERIOR', 'VENDEDOR' => 'VENDEDOR',),
	'selected' => set_value('profile'),
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
<table>
	<?php if ($use_username) { ?>
	<tr>
		<td><?php echo form_label('Username', $username['id']); ?></td>
		<td><?php echo form_input($username); ?></td>
		<td style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></td>
	</tr>
	<?php } ?>

    <tr>
		<td><?php echo form_label('Email Address', $email['id']); ?></td>
		<td><?php echo form_input($email); ?></td>
		<td style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></td>
	</tr>
    
<!-- -->
    <tr>
		<td><?php echo form_label('Profiel', $profile['id']); ?></td>
		<td><?php echo form_dropdown($profile['name'], $profile['options'], $profile['selected']); ?></td>
		<td style="color: red;"><?php echo form_error($profile['name']); ?><?php echo isset($errors[$profile['name']])?$errors[$profile['name']]:''; ?></td>
	</tr>
    <tr>
		<td><?php echo form_label('Vendedor', $idVendedor['id']); ?></td>
		<td><?php echo form_dropdown($idVendedor['name'], $idVendedor['options'], $idVendedor['selected']); ?></td>
		<td style="color: red;"><?php echo form_error($idVendedor['name']); ?><?php echo isset($errors[$idVendedor['name']])?$errors[$idVendedor['name']]:''; ?></td>
	</tr>
    <tr>
		<td><?php echo form_label('Grupo', $IDGrupo['id']); ?></td>
		<td><?php echo form_dropdown($IDGrupo['name'], $IDGrupo['options'], $IDGrupo['selected']); ?></td>
		<td style="color: red;"><?php echo form_error($IDGrupo['name']); ?><?php echo isset($errors[$IDGrupo['name']])?$errors[$IDGrupo['name']]:''; ?></td>
	</tr>
<!-- -->

	<tr>
		<td><?php echo form_label('Password', $password['id']); ?></td>
		<td><?php echo form_password($password); ?></td>
		<td style="color: red;"><?php echo form_error($password['name']); ?></td>
	</tr>


	<tr>
		<td><?php echo form_label('Confirm Password', $confirm_password['id']); ?></td>
		<td><?php echo form_password($confirm_password); ?></td>
		<td style="color: red;"><?php echo form_error($confirm_password['name']); ?></td>
	</tr>


	<?php if ($captcha_registration) {
		if ($use_recaptcha) { ?>
	<tr>
		<td colspan="2">
			<div id="recaptcha_image"></div>
		</td>
		<td>
			<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="recaptcha_only_if_image">Enter the words above</div>
			<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
		</td>
		<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
		<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
		<?php echo $recaptcha_html; ?>
	</tr>
	<?php } else { ?>
	<tr>
		<td colspan="3">
			<p>Enter the code exactly as it appears:</p>
			<?php echo $captcha_html; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
		<td><?php echo form_input($captcha); ?></td>
		<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
	</tr>
	<?php }
	} ?>
</table>
<?php echo form_submit('register', 'Register'); ?>
<?php echo form_close(); ?>