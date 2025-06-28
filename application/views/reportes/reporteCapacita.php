<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");
?>
<div class="col-md-12 ml-4 mt-4">
    <a href="<?=base_url()?>reportes/cuadroMando" class="btn btn-primary btn-sm">Cuadro de mando</a>
</div>
<div>
    <?php $this->load->view("capacita/dashboard");?>
</div>


<input type="hidden" name="" id="base-url" data-url="<?=base_url()?>">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="<?=base_url()."/assets/js/jquery.trainingsreports.js"?>"></script>