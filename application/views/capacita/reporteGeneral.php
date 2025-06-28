
<?php 
    $this->load->view('capacita/menu_capacita');
?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.3/fc-4.0.1/datatables.min.css"/>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->

<?php 
    //$tabs = array_keys($trainings["persons"]);
?>
<style type="text/css">
    #myTab.nav-tabs {
        font-size: 14px;
        border-bottom: 1px solid #dee2e6;
        background: transparent;
        width: 100%;
    }
    #myTab.nav-tabs > li {
        margin-bottom: -1px;
    }
    #myTab.nav-tabs>li>a.active, .nav-tabs>li>a.active:focus, .nav-tabs>li>a.active:hover {
        color: #8370A1;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    #myTab.nav-tabs>li>a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
        color: #555;
    }
    #myTab.nav-tabs>li>a:hover {
        background: #8370A1;
        color: white;
    }
    #myTab.nav-tabs>li {
        float: left;
        margin-bottom: -1px;
    }
    #myTabContent.tab-content {
        font-size: 13px;
        box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.10);
    }
    #pills-tabContent.tab-content {
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
    .well {
        background-color: white;

    }
</style>
<div style="vertical-align: top; display: inline-block; width: 90%">
    <input type="hidden" data-url="<?=base_url()?>" id="base-url">
    <div class="col-md-12">
        <h2 class="mt-4 title-capacita">Reporte general de capacitación</h2>
        <hr>
        <div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">Tablero</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="training-tab" data-toggle="tab" href="#training" role="tab" aria-controls="training" aria-selected="false">Capacitaciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#reportAgente" role="tab" aria-controls="reportAgente" aria-selected="false">Agentes</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <?php $this->load->view("capacita/dashboard");?>
            </div>
            <div class="tab-pane" id="training" role="tabpanel" aria-labelledby="training-tab">
                <?php $this->load->view("capacita/reports");?>
            </div>
            <div class="tab-pane" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
            <div class="tab-pane" id="reportAgente" role="tabpanel" aria-labelledby="reportAgente-tab">
                <?php $this->load->view("capacita/reporteAgentes");?>
            </div>
        </div>
            <!--<div class="col-md-12" id="general-data"></div> --> <!-- No borrar. Alojamiento en construcción-->
        </div>
    </div>
</div>
<input type="hidden" name="" id="base-url" data-url="<?=base_url()?>">
<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.3/fc-4.0.1/datatables.min.js"></script>

<script src="<?=base_url()."/assets/js/jquery.trainingsreports.js"?>"></script>
<script>
    $(document).ready(function() {
        $('.all-persons').DataTable({
            fixedColumns: true,
            language:{
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Sin resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Sin resultados",
                "infoFiltered": "(filtrado desde un total de _MAX_ registros)"
            }
        });  
    } );
</script>
<!--<script src="<?=base_url()."assets/react_js/react_modules/bundle_js/bundle-traininDataReport.js"?>"></script>-->