<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?= meta('charset', 'utf-8'); ?>
	<?= meta('viewport', 'width=device-width, initial-scale=1.0, user-scalable=no'); ?>
	<meta name="viewport" content="width=900px" />
	<?= meta('X-UA-Compatible', 'IE=edge,chrome=1', 'equiv'); ?>	
	<?= link_tag('assets/img/icon.png', 'apple-touch-icon-precomposed'); ?>
	<?= link_tag('assets/img/icon.png', 'shortcut icon'); ?>
	<title>Capsys &bull; Web - Bienvenido</title>
	<?= link_tag('assets/css/bootstrap.min.css'); ?>
	<?= link_tag('assets/css/font-awesome.min.css'); ?>
	<?= link_tag('assets/css/bootstrap-datepicker3.min.css'); ?>
	<?= link_tag('assets/css/cap.css'); ?>
	<?= link_tag('assets/css/subMenu.css'); ?>
	<?= link_tag('assets/css/menu.css'); ?>
	<?= link_tag('assets/css/win8/ui.easytree.css'); ?>
	<?= link_tag('assets/css/capMoi.css'); ?>
	<?= link_tag('assets/css/estiloscapsys.css'); ?>
	<?= meta("Expires", "0", "equiv"); ?>
	<?= meta("Last-Modified", "0", "equiv"); ?>
	<?= meta("Cache-Control", "no-cache, mustrevalidate", "equiv"); ?>
	<?= meta("Pragma", "no-cache", "equiv"); ?>	
	<?php if (!isset($ticc)) { ?>
		<link href="<?= base_url('assets/gap/css/toastr.min.css') ?>" rel="stylesheet" />
		<script src="<?= site_url('assets/js/jquery-1.12.3.min.js'); ?>"></script>
		<script src="<?= site_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
		<script src="<?= site_url('assets/js/locales/bootstrap-datepicker.es.min.js'); ?>"></script>
		<script src="<?= site_url('assets/js/jquery.easytree.min.js'); ?>"></script>
		<script src="<?= base_url('assets/gap/js/moment.min.js') ?>"></script>
		<script src="<?= base_url('assets/gap/js/lodash.min.js') ?>"></script>
		<script src="<?= base_url('assets/gap/js/sweetalert.min.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/gap/js/toastr.min.js') ?>" type="text/javascript"></script>
	<?php  } ?>
	<?php if (isset($ticc)) { ?>		
		<link href="<?= base_url(DIR_ASSETS . 'css/bootstrap.min.css') ?>" rel="stylesheet" />
		<link href="<?= base_url(DIR_ASSETS . 'css/font-awesome.min.css') ?>" rel="stylesheet">
		<link href="<?= base_url(DIR_ASSETS . 'css/cap.css') ?>" rel="stylesheet" />
		<link href="<?= base_url(DIR_ASSETS . 'css/menu.css') ?>" rel="stylesheet" />
		<link href="<?= base_url(DIR_ASSETS . 'css/jquery-ui.min.css') ?>" rel="stylesheet">
		<link href="<?= base_url(DIR_ASSETS . 'css/toastr.min.css') ?>" rel="stylesheet" />
		<link href="<?= base_url(DIR_ASSETS . 'css/nprogress.css') ?>" rel="stylesheet" />		
		<script src="<?= base_url(DIR_ASSETS . 'js/jquery-3.4.1.min.js') ?>" type="text/javascript"></script>
		<script src="<?= site_url(DIR_ASSETS . 'js/jquery-ui.min.js'); ?>"></script>
		<script src="<?= base_url(DIR_ASSETS . 'js/toastr.min.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url(DIR_ASSETS . 'js/sweetalert.min.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url(DIR_ASSETS . 'js/pace.min.js') ?>" type="text/javascript"></script>
	<?php  } ?>

	<?php if (isset($_scripts)) {foreach ($_scripts as $value) {echo $value;}
	}
	?>
	<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
	<script src="https://unpkg.com/vuex@4.0.0/dist/vuex.global.js"></script>
	<script src="https://unpkg.com/rxjs@^7/dist/bundles/rxjs.umd.min.js"></script>
	<script crossorigin src="https://unpkg.com/universal-cookie@7/umd/universalCookie.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue-demi"></script>
	<script src="https://cdn.jsdelivr.net/npm/@vuelidate/core"></script>
	<script src="https://cdn.jsdelivr.net/npm/@vuelidate/validators"></script>
	<script src="https://cdn.jsdelivr.net/npm/vuetify@3.5.3/dist/vuetify.min.js"></script>

</head>
<style>
	.seguimientoSicas {position: fixed;left: 70%;width: 25%;height: 85%;border-radius: 8px;background-color: #fff;bottom: 5%;z-index: 1;}
	.notificacion_seguimiento {text-align: center;height: 30px;background-color: #E2E2E2;}
	.polizaAtrasada {border-radius: 4px;width: 100%;background-color: red;color: white;}
	.polizaAtrasada:hover {background-color: #CD6155;}
	.polizaPendiente {border-radius: 4px;width: 100%;background-color: yellow;}
	.polizaPendiente:hover {background-color: #F4D03F;}
	.polizaEfectuada {border-radius: 4px;width: 100%;background-color: #85C1E9;color: #fff;}
	.polizaEfectuada:hover {background-color: #58D68D;cursor: pointer;}
	.cerrar_xx {text-align: right;}
	#verde {background-color: #04B404;}
	#amarillo {background-color: #FFBF00;}
	#rojo {background-color: #FA5858;}
</style>