<?
    $email  = $this->tank_auth->get_usermail(); 
    $idPersona = $this->tank_auth->get_idPersona();
    //print_r($puestos);
    //var_dump($quarterly);
    //var_dump($events);
    //gettype(); //Detectar tipo
    //strval(); //Cambiar a string
    //intval(); //Cambiar a int
    /*setlocale(LC_TIME,"es_ES");    
    echo strftime("Hoy es %A y son las %H:%M");
    echo strftime("El año es %Y y el mes es %B");
    echo "la fecha actual es " . date("d") . " del " . date("m") . " de " . date("Y");*/
?>
<!-- <meta name="viewport" content="width=900px"/> -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">
<style type="text/css">
  	body {
    	font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  	}
  	/*ID*/
        #BtnMenuSuperE.active {margin-left: -125px;}
        #PanelBotonesSuperE td {padding: 5px 10px;}
  		#contTableExport {height: 350px;overflow: auto;border-bottom: 1px solid #dbdbdb;background: #f7f7f7;padding: 0px;}
        #tableOpAudit, #tableOpEvent, #tableRsEvent, #tableOpVacations {
            height: 100%; margin: 0px;
        }
        #tableTraining > tbody > tr > th, #tableTraining > tfoot > tr > th, #tableTraining > tbody > tr > td, #tableTraining > tfoot > tr > td {
            border-top: 1px solid #c8e4e3; color: black;
        }
  	/*Spinners*/
    	.container-spinner-content-loading {
    	    margin: 0px;
    	    color: #266093;
    	    width: 100%;
    	    height: 100%;
    	    align-items: center;
    	    display: flex;
    	    flex-direction: column;
    	    justify-content: center;
    	    position: relative;
    	    background-color: rgb(255 255 255 / 95%);
    	    /*z-index: 1;*/
    	    transition: all 0.3s;
    	}
    	.container-spinner-btn-loading {
    	    margin: 0px;
    	    color: white;
    	    width: 100%;
    	    height: 100%;
    	    align-items: center;
    	    display: flex;
    	    flex-direction: column;
    	    justify-content: center;
    	    position: relative;
    	    /*z-index: 1;*/
            padding: 0px 13px;
    	    transition: all 0.3s;
    	}
    /*Nav*/
        .nav-tabs.tab_capa {font-size: 13px;width: 100%;}
        .nav-tabs.tab_capa > li, .nav-tabs.nav-light > li {margin-bottom: -1px;}
        .nav-tabs.tab_capa>li>a.active, .nav-tabs.tab_capa>li>a.active:focus, .nav-tabs.tab_capa>li>a.active:hover {background-color: #5f3c97;border: 1px solid transparent;color: white;}
        .nav-tabs.tab_capa>li>a {line-height: 1.42857143;border: 1px solid transparent;color: white; /*#555*/}
        .nav-tabs.tab_capa>li>a:hover {background:#472380;color: white;border: 1px solid transparent;}
        .nav-tabs.nav-light {border-bottom: 1px solid #ddd;background: transparent;width: 100%;}
        .nav-tabs.nav-light>li>a {margin-right: 2px;line-height: 1.42857143;border: 1px solid transparent;border-radius: 4px 4px 0 0;color: #555;}
        .nav-tabs.nav-light>li>a.active, .nav-tabs>li>a.active:focus, .nav-tabs>li>a.active:hover {color: #8370A1;cursor: default;background-color: #fff;border: 1px solid #ddd;border-radius: 4px 4px 0px 0px;border-bottom-color: transparent;}
        .nav-tabs.nav-light>li>a:hover {background: #8370A1;color: white;}
  	/*Containers*/
    	.contenido{display: flex;/*margin-left: 40px;*/width: 100%;align-items: stretch;}
    	.contenidoPrincipal{display: flex;flex-direction: column;padding: 15px 25px;width: 100%;transition: all 0.3s;}
    	.panel_botones{background-color: #fff;min-width: 125px;max-width: 125px;float: left;padding: 5px;height: auto;border-right: 1px solid #e1e1e1;transition: all 0.3s;}
    	.container-spinner {width: -webkit-fill-available;height: -webkit-fill-available;position: absolute;z-index: 1;}
    	.panel {box-shadow: 0px 1px 5px 0px rgb(0 0 0 / 31%);}
    	.container-table {height: 400px;overflow: auto;border: 1px solid #dbdbdb;padding: 0px;max-width: 1160px/*1190px*/;/*padding: 10px;border-radius: 4px;*/}
        .container-table-bootstrap {width: 100%;border: 1px solid #ddd;border-radius: 8px;padding: 0px 10px 10px;}
    	.input-group {display: flex;}
    	.input-group > select {border-radius: 0px .25rem .25rem 0px;}
    	.input-group > input.form-control {border-radius: 0px .25rem .25rem 0px;width: auto;}
        .segment-search-filter {padding: 5px 10px;border: 1px solid #dbdbdb;border-radius: 5px;}
        .tab-content.contenedor_capa {font-size: 13px;border: 1px solid #dee2e6;border-top: transparent;position: relative;box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.10);}
        /*.panel.panel-default {background-color: #f7f7f7;}*/
        .segment-options { max-width: 60%; }
        .segment-event {padding: 15px;border: 1px solid #aecdd6;border-radius: 5px;background: #f6fdff;width: 100%;float: left;}
        .alert-wine {color: #97154b;background: #ffe4ef;}
        .bg-tab-content-poliza {padding-left: 10px;padding-right: 10px;background: white;padding-top: 10px;display: grid;margin-bottom: 20px;border: 1px solid #ddd;border-top: none;}
  	/*Modals*/
    	.modal {background-color: rgb(0 0 0 / 17%);}
    	/*.modal-dialog.modal-lg {margin: 5% auto;}*/
  	/*Columns*/
    	.column-flex-center-center {display: flex;justify-content: center;align-items: center;}
    	.column-flex-center-start {display: flex;justify-content: flex-start;align-items: center;}
    	.column-flex-center-end {display: flex;justify-content: flex-end;align-items: center;}
    	.column-flex-content-center {display: flex;justify-content: center;}
    	.column-flex-start {display: flex;justify-content: flex-start;}
    	.column-flex-end {display: flex;justify-content: flex-end;}
    	.column-flex-items-center {display: flex;align-items: center;}
    	.column-flex-bottom {display: flex;align-items: flex-end;}
    	.column-grid-start {display: flex;flex-direction: column;align-items: flex-start;}
    	.column-grid-center {display: flex;flex-direction: column;align-items: center;justify-content: center;}
    	.column-flex-space-evenly {display: flex;justify-content: space-evenly;}
    	.width-ajust {width: 100%;max-width: max-content;}
  	/*Botons*/
  		/*.btn {font-size: 13px;}*/
    	.btn-primary.active, .btn-primary.focus, .btn-primary:active, .btn-primary:focus, .btn-primary:hover, 
    	.open>.dropdown-toggle.btn-primary {color: #fff;background-color: #286090;border-color: #286090;}
    	.btn-primary {color: #fff;background-color: #286090;border-color: #286090;font-size: 13px;}
    	.btn-primary.btn-sm {font-size: 12px;}
        .btn-success {color: black;}
    	.btn-danger {color: white;}
    	.boton{border: 1px solid #a892cb;border-radius: 8px;border-width: 1px;text-align: center;max-height: 110px;max-width: 110px;cursor: pointer;transition: 0.3s;background: #fcfbff;padding: 3px;color: #2f1d5a;font-size: 12px;font-family: verdana;display: flex;flex-direction: column;align-items: center;}
        .boton > i {font-size: 32px;padding: 8px;}
    	.btn-burguer {outline: none;background: transparent;border: none;color: #472380;padding: 3px;cursor: pointer;font-size: 18px;}
    	.btn-export-report {background: #449d44;border-color: #449d44;color: #FFFFFF;}
        .btn-view-cont {color: #26418f;font-size: 20px;outline: none;border: 1px solid #dbdbdb;border-radius: 5px;background: #e9e9e9;padding: 2px 6px;transition: 0.3s;}
        .btn-view-menu {color: #26418f;padding: 0px;font-size: 28px;position: absolute;border: none;}
    	.btn-primary:hover {background: #3e45a1;border-color: transparent;}
        .boton:hover {background: #f0f2ff;border-color: #bec3e1;transition: 0.3s;color: #1d325a;}
        .boton:hover > i {color: #1d325a;}
    	.btn-export-report:hover {background: #43BD55;border-color: #43BD55;}
        .btn-view-cont:hover {background: #d1d1d1;}
        .btn-success.active, .btn-success.focus, .btn-success:active, .btn-success:focus, .btn-success:hover, .open>.dropdown-toggle.btn-success {background-color: #398439;} /*#398439 #449d44*/
    	button:active, button.btn:active, .btn-burguer:active, .btn-view-cont:active {
    	  outline: 0;
    	}
    	button:focus, button.btn:focus, .btn-burguer:focus, .btn-view-cont:focus {
    	  outline: 0;
    	}
    /*Dropdown*/
  		.li-filter > li {font-size: 12px;padding: 0px 8px 0px 3px;}
		.drop-content {display: none;position: absolute;background-color: #f9f9f9;min-width: auto;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);transform: translate3d(-90px, 0px, 0px);top: 0px;left: 0px;will-change: transform;}
  	/*Tables*/
  		/*table {height: 100%;margin: 0px;font-size: 12px;}*/
  		/*table > tbody {font-size: 12px;}*/
        /*table.table {height: 100%; margin: 0px;}*/
        tbody > tr > td > button, tbody > tr > td > a {font-size: 13px;}
        td > span.label { font-size: 13px;font-weight: 600; }
    	.table > thead >.tr-style {background: #1e4c82;/*#5d418b*/z-index: 1;}
        .table > thead >.table-tr {background: #5d418b;z-index: 1;}
    	.table-thead {position: sticky;top: 0;z-index: 1;}
    	.table-tfoot {position: sticky;bottom: 0px; background-color:#e3e3e3;}
        /*#bodyTableOpAudit > tr > td:nth-child(2) {min-width: 180px;}*/
        /*#bodyTableOpAudit > tr > td:nth-child(7) {min-width: 140px;}*/
  	/*Texts*/
  		label {font-weight: 600;}
    	.titleSection {font-size: 18px;color: #362380;margin-bottom: 0px;}
    	.subTitleSection {font-size: 14px;color: #3d3d3d;margin-right: 5px;margin-bottom: 0px;}
        .titleSeg {color: #3d3d3d;text-align: center;}
        .subtitleSeg {font-size: 13px;color: #3d3d3d;}
        .title-table {text-align: center;}
        .textSizeLabel {font-size: 13px;}
    	.textCheck {font-size: 16px;font-weight: 600;color: green;margin: 0px 5px;}
    	.textError {font-size: 16px;font-weight: 600;color: red;margin: 0px 5px;}
    	.textAssign {font-size: 16px;font-weight: 600;color: #286090;margin: 0px 5px;}
    	.title-result {margin-top: 0px;margin-bottom: 0px;color:white;font-size: 16px;}
    	.subtitleModal {text-align: center;color: black;font-size: 16px;}
    	.form-check-label {font-size: 13px;color: #3d3d3d;margin-left: 3px;}
    	.input-group-text {border-radius: .25rem 0px 0px .25rem;border-right: 0px;width: 35px;justify-content: center;}
    	.input-group-text > i {font-size: 14px;}
    	.form-check > label {margin-right: 5px;}
        .label-primary {padding: .2em .6em .4em;background-color: #3f5f8f;}
        .label-success {padding: .2em .6em .4em;background-color: #3f8f50;/*#3f8f66*/}
        .label-warning {padding: .2em .6em .4em;color: black;}
        .label-danger {padding: .2em .6em .4em;background-color: #d80600;}
        .label-wine {padding: .2em .6em .4em;background-color: #97154b;}
        .p-list-alert {font-size: 13.5px;margin: 0px;}
  	/*Icons*/
    	.icon-circle-check {font-size: 25px;color: green;}
    	.icon-circle-close {font-size: 25px;color: red;}
    	.icon-circle-send {font-size: 15px;color: green;}
    	.icon-circle-no-send {font-size: 15px;color: orange;}
    	.icon-circle-assign {font-size: 25px;color: #286090;}
    	.icon-star {font-size: 16px;}
    	p.store {position: relative;overflow: hidden;display: inline-block;}		
		p.store input {position: absolute;top: -100px;}		
		p.store label {float: right;color: #286090;cursor: pointer;transition: 0.3s;}		
		p.store label:hover,
		p.store label:hover ~ label,
		p.store input:checked ~ label {color: #ddca27;}
    	/*.icon-delete {float: right;color: white;border: 1px solid #b50404;width: 12px;height: 12px;position: relative;top: -15px;background-color: #b50404;border-radius: 5px;display: flex;align-items: center;justify-content: center;padding: 1px;}*/
    	.container-message > i.fa-comments {padding: 2px 5px;font-size: 15px;}
        .seg-icon-asist {font-size: 20px;color: green;border-radius: 70px;}
        .seg-icon-noasist {font-size: 20px;color: red;border-radius: 70px;}
        .seg-icon-vac {font-size: 20px;color: #2258b7;border-radius: 70px;}
  	/*Others*/
        .ocultarObjeto{display: none}
        .verObjeto{display: block;}
        .active-seg {background-color: #dee8ff;color: #132c5c;border-color: #c6d4ed;}
        .active-seg > i {color: #132c5c;}
    	.pd-left {padding-left: 0px;}
    	.pd-right {padding-right: 0px;}
    	.pd-top {padding-top: 15px;}
    	.pd-bottom {padding-bottom: 15px;}
        .pd-items-table {padding-bottom: 5px;}
    	.title-hr {margin: 10px 0px;border-top: 1px solid #deceeb;}
    	.subtitle-hr {margin: 10px 0px;border-top: 1px solid #dbdbdb;}
        .history-hr {border-color: #c3beaf;margin: 10px 0px;}
        .training-hr {border-color: #c8e4e3;margin: 5px 0px;}
        .table-hr {margin: 10px 0px;border-color: #e1e1e1;}
    	.infoModal{position: relative; left: 0%;top: 30%}
    	.labelModal{color: red;background-color: white; font-size: 18px;}
    	.brd-right {border-right: 1px solid #dbdbdb;}
    	.mg-right {margin-right: 5px;}
    	.mg-bottom {margin-bottom: 5px;}
        .mg-cero {margin: 0px;}
        .mg-top-cero {margin-top: 0px;}
    	.pd-side {padding-left: 5px;padding-right: 5px;}
    	/*.segment-search-filter > .pd-side:nth-child(3) {padding-right: 10px;}*/
    	/*.segment-search-filter > .pd-side:nth-child(4) > .form-check:nth-child(1) {padding-left: 5px;}*/
    	.datos-hr {margin: 10px 0px;border-top: 1px solid #78609f;}
        .segment-disabled {background-color: #ddd;}
  	/*Swal*/
    	.swal-modal {width: 28%; /* 68% height: 40%*/}
    	.swal-button--confirm{background-color:#337ab7!important;}
    	.swal-text{/*color:#472380 !important;*/font-size: 17px;text-align: center;}
  	/*Checkbox | Radio*/
    	.form-check-input {
    	  	width: 23px;
    	  	height: 23px;
    	  	margin-top: .25em;
    	  	vertical-align: top;
    	  	background-color: #fff;
    	  	background-repeat: no-repeat;
    	  	background-position: center;
    	  	background-size: contain;
    	  	border: 1px solid rgba(0,0,0,.25);
    	  	-webkit-appearance: none;
    	  	-moz-appearance: none;
    	  	appearance: none;
    	  	-webkit-print-color-adjust: exact;
    	  	color-adjust: exact;
    	  	print-color-adjust: exact;
    	  	position: inherit;
    	}
    	input.form-check-input[type=checkbox] {
    	    border-radius: .5em;
    	    cursor: pointer;
    	    margin: 0px 5px;
    	    outline: 0;
    	}
    	input.form-check-input[type=radio] {
    	  	border-radius: 50%;
    	  	cursor: pointer;
    	  	margin: 0px 0 0;
    	  	margin-top: 1px \9;
    	  	line-height: normal;
    	  	outline: 0;
    	}
    	.form-check .form-check-input {
    	    float: left;
    	}
    	.form-check-input:active{
    	  	filter:brightness(90%);
    	}
    	.form-check-input:focus{
    	  	border-color:#86b7fe;
    	  	outline:0;
    	  	box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
    	}
    	.form-check-input:disabled {
    	  	pointer-events: none;
    	  	filter: none;
    	  	opacity: .5;
    	}
    	.form-check-input:checked{
    	  	background-color:#0d6efd;
    	  	border-color:#0d6efd;
    	}
    	.form-check-input:checked[type=checkbox]{
    	  	background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
    	}
    	.form-check-input:checked[type=radio] {
    	  	background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='2' fill='%23fff'/%3e%3c/svg%3e");
    	}
        .form-check-input:disabled~.form-check-label, .form-check-input[disabled]~.form-check-label {
            color: #3d3d3d; /*#6c757d*/
        }
    /*DataTable*/
		/*.dataTables_wrapper {height: 470px;overflow: auto;}*/
		.dataTables_wrapper .dataTables_length, 
		.dataTables_wrapper .dataTables_filter, 
		.dataTables_wrapper .dataTables_info, 
		.dataTables_wrapper .dataTables_processing, 
		.dataTables_wrapper .dataTables_paginate {
		    width: 100%;
		    align-items: center;
		    display: flex;
		    justify-content: center;
		    left: 0px;
		    position: sticky;
		}
		.dataTables_wrapper .dataTables_info {bottom: 35px;background: white;border-top: 1px solid darkgray;}
		.dataTables_wrapper .dataTables_paginate {bottom: 0;background: white;}
    /*Media Query*/
        @media (min-width: 1281px) {
            .container-table-bootstrap { max-width: 1162px; }
        }
        @media (max-width: 1280px) {
            .segment-options { max-width: 55%; }
            .container-table { max-width: 1000px;/*1030*/ }
            .container-table-bootstrap { max-width: 1000px; } /*1031*/
        }
        @media (max-width: 1024px) {
            .segment-options { max-width: 40%; }
            .container-table { max-width: 745px;/*770*/ }
        }
        @media (max-width: 800px) {
            .segment-options { max-width: 30%; }
            .container-table { max-width: 550px; }
        }
    /*BootstrapTable*/
        /*-->Table Style*/
        .bootstrap-table.bootstrap4 .table-bordered>tbody>tr>td, .bootstrap-table.bootstrap4 .table-bordered>tbody>tr>th, .bootstrap-table.bootstrap4 .table-bordered>tfoot>tr>td, .bootstrap-table.bootstrap4 .table-bordered>tfoot>tr>th, .bootstrap-table.bootstrap4 .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {border: none;border-top: 1px solid #ddd;}
        .bootstrap-table .fixed-table-toolbar .columns label {display: flex;align-items: center;padding: 3px 15px;transition: 0.3s;}
        /*.bootstrap-table.bootstrap4 > .fixed-table-container {max-height: 450px;}*/
        .dropdown-item.dropdown-item-marker > input[type='checkbox'] {width: 16px;height: 16px;vertical-align: top;background-color: #fff;background-repeat: no-repeat;background-position: center;background-size: contain;
            border: 1px solid rgba(0,0,0,.25);-webkit-appearance: none;-moz-appearance: none;appearance: none;-webkit-print-color-adjust: exact;color-adjust: exact;print-color-adjust: exact;position: inherit;border-radius: .3em;cursor: pointer;margin: 0px 5px 0px 0px;outline: 0;}
        .dropdown-item.dropdown-item-marker > input[type='checkbox']:active {filter:brightness(90%);}
        .dropdown-item.dropdown-item-marker > input[type='checkbox']:focus {border-color:#86b7fe;outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);}
        .dropdown-item.dropdown-item-marker > input[type='checkbox']:disabled {pointer-events: none;filter: none;opacity: .5;}
        .dropdown-item.dropdown-item-marker > input[type='checkbox']:checked {background-color: #0d6efd;border-color: #0d6efd;background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");}
        .dropdown-item.dropdown-item-marker:focus, .dropdown-item.dropdown-item-marker:hover {background-color: #b1cafd;color: black;}
        /*-->Botones superiores*/
            /* Export -> data-show-export="true" | Select Column -> data-show-columns="true" | Hide/Show Pagination -> data-show-pagination-switch="true" | Refresh -> data-show-refresh="true" | Show Card View -> data-show-toggle="true" | Search Select Column -> data-show-columns-search="true" */
        .keep-open.btn-group > .dropdown-menu > .dropdown-item,
        .export.btn-group > .dropdown-menu > .dropdown-item {font-size: 13px;}
        .columns.columns-right.btn-group.float-right > .btn.btn-secondary,
        .keep-open.btn-group > .btn.btn-secondary,
        .export.btn-group > .btn.btn-secondary,
        .btn-group.dropdown.dropup > .btn.btn-secondary,
        .input-group-append > .btn.btn-secondary {background: #286090;border-color: #286090;color: white;height: 34px;display: flex;align-items: center}
        .keep-open.btn-group > .btn.btn-secondary > i,
        .export.btn-group > .btn.btn-secondary > i,
        .btn-group.dropdown.dropup > .btn.btn-secondary > span:nth-child(1) {margin-right: 3px;}
        .columns.columns-right.btn-group.float-right > .btn.btn-secondary:focus,
        .columns.columns-right.btn-group.float-right > .btn.btn-secondary:active,
        .keep-open.btn-group > .btn.btn-secondary:focus,
        .keep-open.btn-group > .btn.btn-secondary:active,
        .export.btn-group > .btn.btn-secondary:focus,
        .export.btn-group > .btn.btn-secondary:active,
        .btn-group.dropdown.dropup > .btn.btn-secondary:focus,
        .btn-group.dropdown.dropup > .btn.btn-secondary:active,
        .input-group-append > .btn.btn-secondary:focus,
        .input-group-append > .btn.btn-secondary:active {color: #fff;background-color: #284790;border-color: #284790;outline: 0;box-shadow: 0 0 0 0.2rem rgb(0 78 146 / 50%);}
        .columns.columns-right.btn-group.float-right > .btn.btn-secondary:hover, .keep-open.btn-group > .btn.btn-secondary:hover,
        .export.btn-group > .btn.btn-secondary:hover, .input-group-append > .btn.btn-secondary:hover {color: #fff;background-color: #287F8F;border-color: #287F8F;}
        .btn-group.open .btn.btn-secondary {}
        .btn-secondary:not(:disabled):not(.disabled).active:focus, .btn-secondary:not(:disabled):not(.disabled):active:focus, .show>.btn-secondary.btn.btn-secondary:focus {box-shadow: 0 0 0 0.2rem rgb(0 105 213 / 50%);}
        .dropdown-toggle::after, .dropup .dropdown-toggle::after {content: none;}
        .btn-group>.btn-group:not(:last-child)>.btn, .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {border-radius: 6px 0px 0px 6px;}
        .btn-group>.btn-group:not(:first-child)>.btn, .btn-group>.btn:not(:first-child) {border-radius: 0px 6px 6px 0px;}
        /*-->Search*/ /*data-search="true"*/
        .float-right.search.btn-group > .form-control.search-input, label.dropdown-item.dropdown-item-marker 
        > input {border-radius: 6px;}
        .float-right.search.btn-group > .input-group > .form-control.search-input {height: 34px;border-radius: 6px 0px 0px 6px;}
        .input-group .form-control:first-child, .input-group-addon:first-child, .input-group-btn:first-child>.btn, .input-group-btn:first-child>.btn-group>.btn, .input-group-btn:first-child>.dropdown-toggle, .input-group-btn:last-child>.btn-group:not(:last-child)>.btn, .input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle) {border-radius: 6px 0px 0px 6px;}
        .input-group>.input-group-append > .btn, .input-group > .input-group-append > .input-group-text, .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child), .input-group > .input-group-prepend:not(:first-child) > .btn, .input-group>.input-group-prepend:not(:first-child) > .input-group-text {border-radius: 0px 6px 6px 0px;}
        /*-->Fullscreen*/ /*data-show-fullscreen="true"*/
        .bootstrap-table.bootstrap4.fullscreen {padding: 15px;}
        /*-->Pagination*/ /*data-pagination="true"*/
        .btn-group.dropdown.dropup.show > .dropup.dropdown-menu.show, .btn-group.dropdown.dropup.show > .dropdown.dropdown-menu.show {bottom: auto;}
        .dropup .dropdown-menu, .navbar-fixed-bottom .dropdown .dropdown-menu {bottom: auto;}
        .show {display: inline-block !important;}
        .fixed-table-pagination {border: 1px solid #dddddd6b;border-top: none;border-radius: 0px 0px 5px 5px;padding: 0px 15px;background: white;color: #3d3d3d;font-size: 13px;}
        .pagination > li.page-item.page-pre > a.page-link {background: white;color: black;font: icon;border: 1px solid #ddd;border-radius: 4px 0px 0px 4px;}
        .pagination > li.page-item.page-next > a.page-link {background: white;color: black;font: icon;border: 1px solid #ddd;border-radius: 0px 4px 4px 0px;}
        .pagination > li.page-item > a.page-link {background: white;color: #286090;border: 1px solid #ddd;height: 34px;}
        .pagination > li.page-item > a.page-link:hover {background: #e3f2ff;color: #3d3d3d;border-color: #C7E5FF;}
        .pagination > li.page-item.active > a.page-link {background-color: #286090;border-color: #286090;color: white;}
</style>
<div class="contenido" id="ContentEncuesta">
    <div class="panel_botones" id="BtnMenuSuperE">
        <table class="tablaMenu table" id="PanelBotonesSuperE" style="position: sticky;top:0;">
            <tr>
                <td style="border-top: none;">
                    <div class="boton active-seg" onclick="verContenido('divAuditoria','Auditoría')" data-div="divAuditoria">
                        <i class="fas fa-list-alt"></i>
                        <span >Auditoría</span>
                    </div>
                </td>
            </tr>
            <tr class="ocultarObjeto">
                <td>
                    <div class="boton" onclick="verContenido('divCompetencias','Competencias')" data-div="divCompetencias">
                        <i class="fas fa-clipboard-check"></i>
                        <span >Competencias</span>
                    </div>
                </td>
            </tr>
            <tr class="ocultarObjeto">
                <td>
                    <div class="boton" onclick="verContenido('divPIP','PIP')" data-div="divPIP">
                        <i class="fas fa-user-check"></i>
                        <span >PIP</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="boton" onclick="verContenido('divPuntualidad','Puntualidad')" data-div="divPuntualidad">
                        <i class="fas fa-user-clock"></i>
                        <span >Puntualidad</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="boton" onclick="verContenido('divCapacitacion','Capacitación')" data-div="divCapacitacion">
                        <i class="fas fa-user-graduate"></i>
                        <span >Capacitación</span>
                    </div>
                </td>
            </tr>
            <tr class="ocultarObjeto">
                <td>
                    <div class="boton" onclick="verContenido('divSeguimiento','Seguimiento')" data-div="divSeguimiento">
                        <i class="fas fa-clipboard-list"></i>
                        <span >Seguimiento</span>
                    </div>
                </td>
            </tr>
            <tr class="ocultarObjeto">
                <td>
                    <div class="boton" onclick="verContenido('divProductividad','Productividad')" data-div="divProductividad">
                        <i class="fas fa-user-cog"></i>
                        <span >Productividad</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="boton" onclick="verContenido('divPuntosExtras','Puntos Extras')" data-div="divPuntosExtras">
                        <i class="fas fa-star"></i>
                        <span >Puntos Extras</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="boton" onclick="verContenido('divIndicadoresDeProductividad','INDICADORES DE PRODUCTIVIDAD')" data-div="divIndicadoresDeProductividad">
                        <i class="fas fa-line-chart"></i>
                        <span >Indicadores de Productividad</span>
                    </div>
                </td>
            </tr>            
            <!-- <tr>
                <td>
                    <div class="boton" onclick="verContenido('divGeneral','Información Global')" data-div="divGeneral">
                        <i class="fas fa-newspaper"></i>
                        <span >General</span>
                    </div>
                </td>
            </tr> -->
        </table>
    </div>
    <? //$this->load->view('superEstrella/opcionesEncuesta'); ?>
    <div class="" style="display: none;">
        <button class="btn-view-menu" id="btnSeeMenu" data-icon="1">
            <i class="fas fa-arrow-circle-left" data-class="fas fa-arrow-circle-left" title="Ocultar Menú"></i>
        </button>
    </div>
  	<div class="contenidoPrincipal" id="ContainerContent">
        <section class="container-fluid breadcrumb-formularios">
            <div class="row">
                <div class="col-md-6 column-flex-center-start">
                    <h3 class="title-section-module">
                        <button class="btn-burguer" id="BtnMenuBurguer" title="Menú">
                            <i class="fa fa-bars" aria-hidden="true"></i></button>
                        <span id="TitleSectionTest">Programa Super Estrella</span>
                    </h3>
                </div>
                <div class="col-md-6 column-flex-center-end">
                    <a class="btn btn-primary" href="<?=base_url()?>capitalHumano">
                        <i class="fas fa-users"></i> Ir a Puestos
                    </a>
                </div>
            </div>
            <hr/>
        </section>
        <!-- <section style="display: none;">
            <div class="panel panel-default" style="margin-bottom: 20px;">
                <div class="panel-body">
                    <div class="col-md-12 segment-search-filter mg-bottom">
                        <div class="col-md-12 column-flex-center-start pd-left pd-right mg-bottom">
                            <label class="subTitleSection mg-right">Buscar por:</label>
                            <div class="form-check column-flex-center-center" style="padding-right: 1.25rem;">
                                <input type="checkbox" class="form-check-input" name="check-search" value="1" disabled>
                                <label class="form-check-label">Mes</label>
                                <input type="checkbox" class="form-check-input" name="check-search" value="2" checked>
                                <label class="form-check-label">Año</label>
                                <input type="checkbox" class="form-check-input" name="check-search" value="3" checked>
                                <label class="form-check-label">Trimestre</label>
                                <input type="checkbox" class="form-check-input" name="check-search" value="4" checked>
                                <label class="form-check-label">Área</label>
                                <input type="checkbox" class="form-check-input" name="check-search" value="5">
                                <label class="form-check-label">Colaborador</label>
                            </div>
                            <button class="btn btn-primary" id="btnSearch" onclick="verifyField(1)">
                                <i class="fas fa-search"></i> Buscar</button>
                        </div>                              
                        <div class="col-md-12 column-flex-center-start segment-search-filter pd-left pd-right">
                            <div class="pd-side">
                                <label class="form-check-label">Mes:</label>
                                <select class="form-control width-ajust input-sm" id="searchMonth" disabled>
                                    <?=$months?>
                                </select>
                            </div>
                            <div class="pd-side">
                                <label class="form-check-label">Año:</label>
                                <select class="form-control width-ajust input-sm" id="searchYear">
                                    <?=$years?>
                                </select>
                            </div>
                            <div class="pd-side">
                                <label class="form-check-label">Trimestre:</label>
                                <select class="form-control width-ajust input-sm" id="searchQuarterly">
                                    <?=$quarterly?>
                                </select>
                            </div>
                            <div class="pd-side">
                                <label class="form-check-label">Área:</label>
                                <select class="form-control width-ajust input-sm" id="searchArea">
                                    <?= printArea($puestos);?>
                                </select>
                            </div>
                            <div class="pd-side segment-options">
                                <label class="form-check-label">Colaborador:</label>
                                <select class="form-control input-sm" id="searchEmployee" disabled>
                                    <?= printEmployees($puestos,$idPersona);?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    	<div class="divContenidoSuperE verObjeto" id="divAuditoria">
            <? $this->load->view('superEstrella/auditoria'); ?>
		</div>
        <div class="divContenidoSuperE ocultarObjeto" id="divCompetencias">
            <div class="panel panel-default" style="margin-bottom: 80px;">
                <div class="panel-body"></div>
            </div>
        </div>
        <div class="divContenidoSuperE ocultarObjeto" id="divPIP">
            <div class="panel panel-default" style="margin-bottom: 80px;">
                <div class="panel-body"></div>
            </div>
        </div>
        <div class="divContenidoSuperE ocultarObjeto" id="divPuntualidad">
            <? $this->load->view('superEstrella/puntualidad'); ?>
        </div>
        <div class="divContenidoSuperE ocultarObjeto" id="divCapacitacion">
            <? $this->load->view('superEstrella/capacitacion'); ?>
        </div>
        <div class="divContenidoSuperE ocultarObjeto" id="divSeguimiento">
            <div class="panel panel-default" style="margin-bottom: 80px;">
                <div class="panel-body"></div>
            </div>
        </div>
        <div class="divContenidoSuperE ocultarObjeto" id="divProductividad">
            <div class="panel panel-default" style="margin-bottom: 80px;">
                <div class="panel-body"></div>
            </div>
        </div>
        <div class="divContenidoSuperE ocultarObjeto" id="divPuntosExtras">
            <? $this->load->view('superEstrella/puntosExtras'); ?>
        </div>
               <div class="divContenidoSuperE ocultarObjeto" id="divIndicadoresDeProductividad">
            <? $this->load->view('persona/indicadoresDeProductividad'); ?>
        </div>
        <!-- <div class="divContenidoSuperE ocultarObjeto" id="divGeneral">
            <div class="panel panel-default" style="margin-bottom: 80px;">
                <div class="panel-body"></div>
            </div>
        </div> -->
  	</div>
</div>

<div class="modal fade training-employee-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header column-select">
        <h4 class="title-result">Detalles de Asistencias</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body" style="background: #f9f9f9;">
        <div class="col-md-12 pd-left pd-right" id="nav-Puntuality"></div>
        <div class="tab-content bg-tab-content-poliza" id="cont-nav-Puntuality" style="margin:0px;"></div>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/libs/jsPDF/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        searchEmployee();
        $('#BtnMenuBurguer').click(function() {
            $('#BtnMenuSuperE').toggleClass('active');
        })

        /*$('#btnSeeMenu').click(function() {
            $('#BtnMenuSuperE').toggleClass('active');
            const val = $(this).data('icon');
            iconFunction(this,val);
        })*/

        $('.icon-function').click(function() {
            const val = $(this).data('icon');
            iconFunction(this,val);
        })

        $('#filterTableOpAudit').keyup(function() {
            const val = $(this).val().toUpperCase();
            const body = "bodyTableOpAudit";
            const clase = "show-audit";
            filterTable(val,body,clase);
        })

        $('#filterTableOpEvent').keyup(function() {
            const val = $(this).val().toUpperCase();
            const body = "bodyTableOpEvent";
            const clase = "show-event";
            filterTable(val,body,clase);
        })

        $('#filterTableRsEvent').keyup(function() {
            const val = $(this).val().toUpperCase();
            const body = "bodyTableRsEvent";
            const clase = "event-training";
            filterTable(val,body,clase);
        })

        $('input[name="check-search"]').click(function() {
            let checkbox = document.getElementsByName('check-search');
            const val = this.value;
            var check = 0;
            //Valor
            switch (val) {
                case "1":
                    if (this.checked) { $('#searchMonth').prop('disabled',false); }
                    else { $('#searchMonth').prop('disabled',true); }
                break;
                case "2":
                    if (this.checked) { $('#searchYear').prop('disabled',false);}
                    else { $('#searchYear').prop('disabled',true); }
                break;
                case "3":
                    if (this.checked) { 
                        $('#searchQuarterly').prop('disabled',false);
                        $('#searchMonth').prop('disabled',true);
                        $('input[name="check-search"][value="1"]').prop('disabled',true);
                    }
                    else { 
                        $('#searchQuarterly').prop('disabled',true);
                        $('input[name="check-search"][value="1"]').prop('disabled',false);
                        for (let i=0;i<checkbox.length;i++) {
                            if (checkbox[i].value == 1) {
                                if (checkbox[i].checked) { $('#searchMonth').prop('disabled',false); }
                                else { $('#searchMonth').prop('disabled',true); }
                            }
                        }
                    }
                break;
                case "4":
                    if (this.checked) { $('#searchArea').prop('disabled',false);}
                    else { $('#searchArea').prop('disabled',true); }
                break;
                case "5":
                    if (this.checked) {
                        $('#searchEmployee').prop('disabled',false);
                        $('#searchArea').prop('disabled',true);
                        $('input[name="check-search"][value="4"]').prop('disabled',true);
                    }
                    else {
                        $('#searchEmployee').prop('disabled',true);
                        $('input[name="check-search"][value="4"]').prop('disabled',false);
                        for (let i=0;i<checkbox.length;i++) {
                            if (checkbox[i].value == 4) {
                                if (checkbox[i].checked) { $('#searchArea').prop('disabled',false); }
                                else { $('#searchArea').prop('disabled',true); }
                            }
                        }
                    }
                break;
            }
            //Verificar checked
            for (let i=0;i<checkbox.length;i++) {
                if (checkbox[i].checked) {
                    check++;
                }
            }
            //Boton Buscar
            if (check > 0) { $('#btnSearch').prop('disabled',false); }
            else { $('#btnSearch').prop('disabled',true); }
        })

        //$('#searchQuarterlyTraining').html(getQuarterly() + `<option value="todos" selected>Todos</option>`)
	})

    const baseUrl = '<?=base_url()?>superEstrella';

    function searchEmployee() {
        //Auditoría
        getTableAudit();
        getTableRsAudit();
        //Puntualidad
        getTableCheck();
        //Capacitaciones
        getTableEvent();
        getTableRsTraining();
        //Puntos Extras
        getTableTraining();
        getTableVacations();
    }

    function getTable(month,year,quarterly,area,employee) {
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getEmployeeSearch`,
            data: {
                mt: month,
                yr: year,
                qr: quarterly,
                ar: area,
                em: employee
            },
            beforeSend: (load) => {
                $('#bodyTableOpAudit').html(`
                    <tr>
                        <td colspan="9">
                            <div class="container-spinner-content-loading">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                                <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                            </div>
                        </td>
                    </tr>
                `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                let mp = r['empleados'];
                let au = r['auditoria'];
                var trtd = ``;
                var trtdR = ``;
                //$('#btnSaveNote').html("Guardar");
                //swal("¡Guardado!", "Nota guardada con éxito.", "success");
                if (mp != 0) {
                    for (const e in mp) {
                        const idPersona = mp[e].idPersona;
                        const name = getTextValue(mp[e].apellidoPaterno) + " " + getTextValue(mp[e].apellidoMaterno) + " " + getTextValue(mp[e].nombres);
                        var auditoria = 0;
                        var status = "Sin resolver";
                        var textStatus = "label-primary";
                        var score = "Sin resultados";
                        var procedure = getOptionYesNo("");
                        var tracking = getOptionYesNo("");
                        var update = "no";
                        var textBtn = "Guardar";
                        var classBtn = "btn-primary";
                        var employees = `<td><a class="btn btn-primary" href="#SectionEmployeeAud" data-name="${name}" data-employee="${idPersona}" data-employment="${mp[e].idPuesto}" onclick="seeEmployeesAud(this,'${year}','${quarterly}')"><i class="far fa-eye"></i> Ver</a></td>`;
                        if (au != 0) {
                            for (const a in au) {
                                if (idPersona == au[a].idPersona && quarterly == au[a].trimestre) {
                                    auditoria = au[a].id;
                                    status = "Hecho";
                                    textStatus = "label-success";
                                    score = au[a].calificacion;
                                    procedure = getOptionYesNo(au[a].procedimiento);
                                    tracking = getOptionYesNo(au[a].seguimiento);
                                    update = "si";
                                    textBtn = "Actualizar";
                                    classBtn = "btn-success";
                                }
                            }
                        }

                        trtd += `
                            <tr class="" data-puesto="${mp[e].idPuesto}">
                                <td>${Number(e) + 1}</td>
                                <td>${name}</td>
                                <td>${getTextValue(mp[e].colaboradorArea)}</td>
                                <td>${mp[e].email}</td>
                                <td><span class="label ${textStatus}" id="estatus${idPersona}">${status}</span></td>
                                <td><strong id="puntaje${idPersona}">${score}</strong></td>
                                <td>
                                    <select class="form-control width-ajust" id="trimestre${idPersona}" disabled>
                                        <?=$quarterly?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control width-ajust" id="procedimientos${idPersona}">${procedure}</select>
                                </td>
                                <td>
                                    <select class="form-control width-ajust" id="seguimiento${idPersona}">${tracking}</select>
                                </td>
                                <td>
                                    <button class="btn ${classBtn}" data-auditoria="${auditoria}" data-employee="${idPersona}" data-update="${update}" id="btnAud${idPersona}" onclick="saveAudit(this)">${textBtn}</button>
                                </td>
                            </tr>
                        `;
                    }
                }
                else {
                    trtd = `<tr><td colspan="9"><center><strong>Sin resultados</strong><center></td></tr>`;
                }
                $('#bodyTableOpAudit').html(trtd);
            },
            error: (error) => {
                console.log(error);
                //$('#btnSaveNote').html("Guardar");
                //swal("¡Vaya!", "Ha ocurrido un conflicto al intentar guardar.", "error");
            }
        })
    }

    function getAreas() {
            $.ajax({
                type: "GET",
                url: `${baseUrl}/getAreas`,
                beforeSend: (load) => {
                    /*$('#btnSaveNote').html(`
                        <div class="container-spinner-btn-loading">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    `);*/
                },
                success: (data) => {
                    const r = JSON.parse(data);
                    console.log(r);
                    //$('#btnSaveNote').html("Guardar");
                    //swal("¡Guardado!", "Nota guardada con éxito.", "success");
                },
                error: (error) => {
                    console.log(error);
                    //$('#btnSaveNote').html("Guardar");
                    //swal("¡Vaya!", "Ha ocurrido un conflicto al intentar guardar.", "error");
                }
            })
    }

    function getTableBootstrap(container,table,thead,jsonData,file) { //Paginación, Exportación, Filtro, Búsqueda, Selección de Bootstrap
        $('#'+container).css('height','');
        $('#'+container).html(`<table class="table table-striped" id="${table}" data-show-columns="true" data-show-pagination-switch="true" data-show-search-clear-button="true" data-page-list="[5, 10, 25, 50, 100, all]"><thead>${thead}</thead></table>`);
        //console.log(jsonData);

        $('#'+table).bootstrapTable({
            data: jsonData,
            height: 450,
            pagination: true,
            pageSize: 5,
            //pageList: [5, 10, 20, 50, 100,],
            search: true,
            cache: false,
            locale: 'es-MX',
            showExport: true,
            exportTypes: ['doc', 'pdf', 'excel'], //['json', 'xml', 'png', 'csv', 'txt', 'sql', 'doc', 'excel', 'xlsx', 'pdf']
            exportOptions: {
                fileName: function () {
                    return file
                }
            }
        });
    }

	//------------------------------- OPERACIONES -----------------------------------

    function filterTable(value,body,clase) {
        var filter, panel, d, td, i, j, k, visible;
        var tr = "";
        filter = value;
        panel = document.getElementById(body);
        d = panel.getElementsByTagName("tr");
        let Fila = document.getElementsByClassName(clase);
        //
        for (i = 0; i < d.length; i++) {
            visible = false;
            td = d[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    visible = true;
                }
            }
            if (visible === true) {
                d[i].style.display = "";
                $(d[i]).addClass(clase);
            }
            else {
                d[i].style.display = "none";
                $(d[i]).removeClass(clase);
            }
        }
        result = Fila.length;
    }

    function getQuarterly(select = "") {
        let quarterly = ["Primero", "Segundo", "Tercero", "Cuarto"];
        var option = "";
        for (let i=0;i<quarterly.length;i++) {
            var selected = "";
            if (select != 0 && quarterly[i] == select) { selected = "selected"; }
            option += `<option value="${quarterly[i]}" ${selected}>${quarterly[i]}</option>`;
        }
        return option;
    }

    function getOptionYesNo(data) {
        let array = [{name:"SI", value:"si"}, {name:"NO", value:"no"}];
        var option = "<option></option>";
        for (let i=0;i<array.length;i++) {
            var selected = "";
            if (array[i].value == data) { selected = "selected"; }
            option += `<option value="${array[i].value}" ${selected}>${array[i].name}</option>`;
        }
        return option;
    }

    function getTimeByHour(time) {
        var hour = 0;
        var minutes = time.split('.');
        hour = minutes[0] + " hora";
        if (minutes[0] == 0 || minutes[0] > 1) { hour += "s"; }
        if (minutes[1] > 0) {
            minutes = (60 * Number(minutes[1])) / 100;
            hour += ` con ${minutes} minutos`;
        }
        return hour;
    }

    function getPointsByHour(time) {
        var points = 0;
        if (time >= 6) { points = 18; }
        else if (time >= 5 && time < 6) { points = 3; }
        return points;
    }

    function verContenido(div,title){
        let clas=document.getElementsByClassName('divContenidoSuperE');
        let select = document.getElementsByClassName('boton');
        let cant=clas.length;
        for(let i=0;i<cant;i++){clas[i].classList.remove('verObjeto');clas[i].classList.add('ocultarObjeto');}
        if(document.getElementById(div)){document.getElementById(div).classList.remove('ocultarObjeto');}
        if(document.getElementById(div)){
            document.getElementById(div).classList.add('verObjeto');
            $('#TitleSectionTest').html(title);
        };
        for(var i=0;i<select.length;i++){
            select[i].classList.remove('active-seg');
            if(select[i].getAttribute('data-div')==div){select[i].classList.add('active-seg');}
        }
    }

    function iconFunction(event,type) {
        const icon = $(event).children('i');
        if (type == 1) {
            icon.attr('class', icon.hasClass('fas fa-arrow-circle-left') ? 'fas fa-arrow-circle-right' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fas fa-arrow-circle-left') ? 'Mostrar Menú' : 'Ocultar Menú');
        }
        else if (type == 2) {
            icon.attr('class', icon.hasClass('fa fa-eye') ? 'fa fa-eye-slash' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fa fa-eye') ? 'Ver' : 'Ocultar');
        }
        else if (type == 3) {
            icon.attr('class', icon.hasClass('fa fa-info-circle') ? 'fas fa-info' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fa fa-info-circle') ? 'Ver Info' : 'Ocultar Info');
        }
    }

	function orderArray(array) {
        let compare;
        compare = function(a,b) {
            return (b.comision - a.comision);
        };
        array.sort(compare);
        return array;
    }

    function getNumberValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "" || data == 0) {
            data = 0;
        }
        return data;
    }

    function getTextValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "") {
            data = "";
        }
        return data;
    }

	function getDateFormat(data,format) { //Formato definitivo -> Checar el modelo de este módulo para que funcione
        let nameM = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
        let nameD = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
        let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        let monthname = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        let dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

        var dateF = "";

        if (data == undefined || data == null || data == "") {
            dateF = "";
        }
        else {
            if (!data.includes(':')) { data = data + " 00:00:00";}
            date = new Date(data);
            if (format == 1) {
            	dateF = date.getDate() + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 2) {
            	dateF = date.getDate() + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 3) {
                //fecha.replace(/[-]/g, "/"); //Reemplaza todas "-" por "/"
            	dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + date.getDate();
            }
            else if (format == 4) {
            	dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
            }
            else if (format == 5) {
                dateF = dayname[date.getDay()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
            }
            else if (format == 6) {
                dateF = monthname[date.getMonth()];
            }
        }
        return dateF;
    }

    <?
        function printArea($data){
            $option = '<option value="todos">Todos</option>';
            //Con $puestos
            foreach ($data as $key => $val) {
                $selected = "";
                if ($key == "Administrativo") { $selected = "selected"; }
                $option.='<option value="'.$key.'" '.$selected.'>'.$key.'</option>';
            }
            return $option;
        }

        function printEmployees($data,$idPersona){
            $option = '<option value="todos">TODOS</option>';
            //Con $empleados
            /*foreach ($data as $key1 => $value1) {
                $option.='<optgroup label="'.$value1['Name'].'" style="font-size: 12.5px">';
                foreach ($value1['Data'] as $key => $value) {
                  $nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
                  $option.='<option class="dropdown-item" data-name="'.$nombres.'" data-email="'.$value['email'].'" onclick="SelectEmailR(this)">'.$nombres.' <label>     ('.$value['email'].')</label></option>';  
                }
                $option.='</optgroup>';
            }*/

            //Con $puestos
            foreach ($data as $key => $val) {
                $option.='<optgroup label="'.$key.'">';
                foreach ($val as  $value) {
                    $selected = "";
                    if ($idPersona == $value->idPersona) { $selected = "selected"; }
                    $text = $value->apellidoPaterno.' '.$value->apellidoMaterno.' ';
                    $text.=$value->nombres.' (<label style="color:black;">'.$value->personaPuesto.'</label>,'.$value->email.')';
                    $option.='<option value="'.$value->idPersona.'" '.$selected.'>'.$text.'</option>';
                }
                $option.='</optgroup>';
            }
            return $option;
        }

        function printEvents($data) {
            $option = "";
            foreach ($data as $val) {
                $option .= '<option value="'.$val->id_cal.'">'.$val->titulo.'</option>';
            }
            return $option;
        }
    ?>
</script>
<!-- -->