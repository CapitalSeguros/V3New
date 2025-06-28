</section>
<!--:::::::::: INICIO FOOTER ::::::::::-->
<footer id="base_url" class="container-fluid" data-base-url="<?= base_url() ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="footer">
                <p class="h6 text-right">Capsys Web Versión 3.0.1 </p>
            </div>
        </div>
    </div>
</footer>
<!--:::::::::: FIN FOOTER ::::::::::-->
<!--:::::::::: JS ::::::::::-->
<script src="<?= base_url(DIR_ASSETS . 'js/bootstrap.min.js" type="text/javascript') ?>"></script>
<script src="<?= base_url(DIR_ASSETS . 'js/lodash.min.js') ?>"></script>
<script src="<?= base_url(DIR_ASSETS . 'js/ticc.js') ?>"></script>
<script src="<?= base_url(DIR_ASSETS . 'js/menu.js') ?>"></script>
<script src="<?= base_url(DIR_ASSETS . 'js/moment.min.js') ?>"></script>


<script src="<?= base_url(DIR_ASSETS . 'js/jquery.dataTables.js') ?>"></script>

<script src="<?= base_url(DIR_ASSETS . 'js/nprogress.js') ?>"></script>

<?php
if (isset($_scripts)) {
    foreach ($_scripts as $value) {
        echo $value;
    }
}
?>