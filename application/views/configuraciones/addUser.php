<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
		'class' => 'form-control input-sm', 
		'placeholder'=>'Nombre de usuario'
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control input-sm', 
	'placeholder'=>'Correo Electronico'
);
$idVendedor = array(
	'name' 	=> 'idVendedor',
	'id' 	=> 'idVendedor',
	'options' => $this->capsysdre->ArrayVendedor(),
	'selected' => set_value('idVendedor'),
	'class' => 'form-control input-sm', 
);
$IDGrupo = array(
	'name' 	=> 'IDGrupo',
	'id' 	=> 'IDGrupo',
	'options' => $this->capsysdre->ArrayGrupos(),
	'selected' => set_value('IDGrupo'),
	'class' => 'form-control input-sm', 
);
$IDSGrupo = array(
	'name' 	=> 'IDSGrupo',
	'id' 	=> 'IDSGrupo',
	'options' => array('uno'=>'1',), //$this->capsysdre->ArraySubGrupos(),
	'selected' => set_value('IDGrupo'),
	'class' => 'form-control input-sm', 
);
$profile = array(
	'name' 	=> 'profile',
	'id' 	=> 'profile',
	'options' => array(''=>'-- Seleccione --', '3'=>'OPERATIVO', '4' => 'MASTER',),
	'selected' => set_value('profile'),
	
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'form-control input-sm', 
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'form-control input-sm', 
);
$sucursal = array(
    'name'  => 'sucursal',
    'id'    => 'sucursal',
    'options' => array(''=>'-- Seleccione --','1'=>'MERIDA BUENAVISTA','2'=>'CANCUN',),
    'selected' => set_value('sucursal'),
    
);
$canal = array(
    'name'  => 'canal',
    'id'    => 'canal',
    'options' => array(''=>'-- Seleccione --','1'=>'GESTION CARTERA','2'=>'GESTION INSTITUCIONAL','3'=>'GESTION FIANZAS','4'=>'GESTION PROMOTORIA','5'=>'SINIESTROS','9'=>'MASTER',),
    'selected' => set_value('canal'),
    
);
$tipoUser = array(
    'name'  => 'tipoUser',
    'id'    => 'tipoUser',
    'options' => array(''=>'-- Seleccione --','1'=>'GESTION',),
    'selected' => set_value('tipoUser'),
    
);


?>

<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>

<?php echo form_open($this->uri->uri_string()); ?>
	<section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Agregar usuario</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li><a href="./" title="Inicio">Inicio</a></li>
                    <li><a href="<?php echo base_url().'configuraciones'; ?>" title="Configuración">Configuración</a></li>
                    <li class="active">Agregar usuario</li>
                </ol>
            </div>
        </div>
            <hr /> 
    </section>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-12 text-right">
                        <a class="btn btn-default btn-sm" onclick="java:window.open('<?=base_url()?>configuraciones','_self');">CANCELAR<!-- <i class="fa fa-check"></i> --></a>
                        <?php echo form_submit('addUser', 'GUARDAR','class="btn btn-primary btn-sm"'); ?>
                        
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="NombreUsuario">Nombre de usuario</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <?php echo form_input($username); ?>
                                    
                                </div>
                                <?php echo form_error($username['name']); ?>
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="CorreoElectronico">Correo electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                   <?php echo form_input($email); ?>
                                   
                                </div>
                                <?php echo form_error($email['name']); ?>
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="Password">Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <?php echo form_input($password); ?>
                                    
                                </div>
                                <?php echo form_error($password['name']); ?>
                            </div>
                            <div class="form-group col-md-3 col-sm-3">
                                <label for="ConfirmarPassword">Confirmar password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <?php echo form_input($confirm_password); ?>
                                    
                                </div>
                                <?php echo form_error($confirm_password['name']); ?>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-3 col-sm-3">
                                <label for="Perfil">Perfil</label>
                                <? echo form_dropdown($profile['name'], $profile['options'], $profile['selected'],'class="form-control input-sm"' );?>
                            </div>
                            <?php echo isset($errors[$profile['name']])?$errors[$profile['name']]:''; ?>

                            <div class="form-group col-md-3 col-sm-3">
                                 <label for="TipoUser">Tipo de Usuario</label>
                                <? echo form_dropdown($tipoUser['name'], $tipoUser['options'], $tipoUser['selected'],'class="form-control input-sm"' );?>
                            </div>
                            <?php echo isset($errors[$tipoUser['name']])?$errors[$tipoUser['name']]:''; ?>

                            <div class="form-group col-md-3 col-sm-3">

                             <label for="sucursal">sucursal</label>
                                <? echo form_dropdown($sucursal['name'], $sucursal['options'], $sucursal['selected'],'class="form-control input-sm"' );?>

                            </div>    
                            <?php echo isset($errors[$sucursal['name']])?$errors[$sucursal['name']]:''; ?>

                             <div class="form-group col-md-3 col-sm-3">
                                <label for="canal">canal</label>
                                <? echo form_dropdown($canal['name'], $canal['options'], $canal['selected'],'class="form-control input-sm"' );?>

                            </div> 
                            <?php echo isset($errors[$canal['name']])?$errors[$canal['name']]:''; ?>   

                        </div>
                        
            
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php echo form_close(); ?>
	</div>            
</section>


<!--:::::::::: INICIO CONTENIDO ::::::::::-->
    
    <!--:::::::::: FIN CONTENIDO ::::::::::-->
<?php $this->load->view('footers/footer'); ?>