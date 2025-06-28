<?php 

    $this->load->view("headers/header");
    $this->load->view("headers/menu");
?>
<div class="container-fluid bg-white">
    <h3>Agenda</h3>
    <hr>
    <div id="diary-container"></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?=base_url()."assets/react-bundles/bundle-diary.js"?>"></script>