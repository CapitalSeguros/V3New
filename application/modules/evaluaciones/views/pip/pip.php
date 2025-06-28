
<style>
h5{
    color: #2e125a !important;
}
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Performance Improvement Plan</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>


<section class="container">
    <div style="float: left; width: 100%;">
    <div id="PIP">
    </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        const $path = $("#base_url").attr("data-base-url");
        var Update, id;
        var queryString = decodeURIComponent(window.location.search);
        queryString = queryString.substring(1);
        var queries = queryString.split("&");
        //console.log(queries);
        var lol = queries[0].split("=");
        const ModuloPip = new PIP({
            selector: '#PIP',
            postUpdate: queries
        });
        ModuloPip.init();

    });
</script>