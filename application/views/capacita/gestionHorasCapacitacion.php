<?php

    $this->load->view("capacita/menu_capacita");
    //var_dump($puestos_y_personas);
?>

<style type="text/css">
    #tab_c.nav-tabs {
        font-size: 14px;
        border-bottom: 1px solid #dee2e6;
        background: transparent;
        width: 100%;
    }
    #tab_c.nav-tabs > li {
        margin-bottom: -1px;
    }
    #tab_c.nav-tabs>li>a.active, .nav-tabs>li>a.active:focus, .nav-tabs>li>a.active:hover {
        color: #8370A1;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    #tab_c.nav-tabs>li>a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
        color: #555;
    }
    #tab_c.nav-tabs>li>a:hover {
        background: #8370A1;
        color: white;
    }
    #tab_c.nav-tabs>li {
        float: left;
        margin-bottom: -1px;
    }
    #tab_contenido.tab-content {
        font-size: 13px;
        box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.10);
    }
    .mt-3-mb-3 {
        margin-top: 25px;
        margin-bottom: 25px;
    }
    .border-tab {
        border: 1px solid #dee2e6;
        border-top: transparent;
    }
    .form-check-input {
      width: 18px;
      height: 18px;
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
    }
    .form-check-input[type=checkbox] {
        border-radius: .4em;
        cursor: pointer;
    }
    .form-check .form-check-input {
        float: left;
        margin-left: -1.5em;
    }
    .form-check-input:active{
      filter:brightness(90%);
    }
    .form-check-input:focus{
      border-color:#86b7fe;
      outline:0;
      box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
    }
    .form-check-input:checked{
      background-color:#0d6efd;
      border-color:#0d6efd;
    }
    .form-check-input:checked[type=checkbox]{
      background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
    }
</style>
<div class="container" style="margin-right: 0px;">

    <h2 class="mt-4 title-capacita">Asignación de capacitación manual</h2>
    <hr>
    <div id="contenedor_capacitacion">
        <!--<div class="col-md-3">
            <div class="" id="contenedor_capacitacion"></div>
            <div id="contenedor_subcapacitacion" class="mt-4"></div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-center">AGENTES</div>
                <div class="card-body">
                    <select name="personas" id="personas" class="form-control">
                        <?php foreach($puestos_y_personas as $puestos => $i_personas){?>
                            <option value="0">Seleccione</option>
                            <optgroup label="<?=$puestos?>">
                                <?php foreach($i_personas as $dd){?>
                                    <option value="<?=$dd->idPersona?>"><?=$dd->nombres." ".$dd->apellidoPaterno." ".$dd->apellidoMaterno." (".$dd->email.")"?></option>
                                <?php }?>
                            </optgroup>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div> -->
    </div>
</div>
<input type="hidden" data-url="<?=base_url()?>" id="base_url">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="<?=base_url()."assets/react_js/react_modules/bundle_js/bundle-capacitaciones.js"?>"></script>