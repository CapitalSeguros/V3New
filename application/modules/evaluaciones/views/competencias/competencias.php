<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones" id="seccion">Competencias</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>


<section class="container">
    <?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>
    <div style="float: left; width: 90%;">
        <div id="competencias">
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        
        const $path = $("#base_url").attr("data-base-url");
        window.validacion = function(id) {
            if(id==""){
                $('#listCompetencia').addClass('textNew');
                $('#listCompetencia').html('No se ha agregado ninguna pregunta');
            }
        }
        var Update, id;
        var queryString = decodeURIComponent(window.location.search);
        
        queryString = queryString.substring(1);
        var queries = queryString.split("&");
        var lol = queries[0].split("=");
        //console.log(lol[1]);
        if (lol[1] === undefined) {
            Update = "";
            id = "";
            $('#seccion').html("Nueva competencia");
        } else {
            Update = $path + "Competencias/getDataUpdate?id=" + lol[1];
            id = lol[1];
            $('#seccion').html("Editar competencia");
        }

        const competencia = new Competencias({
            selector: '#competencias',
            getData: $path + 'Competencias/getDataPreguntas',
            postData: $path + 'Competencias/postDataPreguntas',
            getUpdate: Update,
            id: id,
            returnUrl: $path + 'Competencias',
            callbackSuccess: function(response) {}
        });
        competencia.init();
        validacion(id);
        //$('#listCompetencia').addClass('textNew');
        //$('#listCompetencia').html('No se ha agregado ninguna pregunta');

       
        $('[data-toggle="tooltip"]').tooltip();

    });
</script>