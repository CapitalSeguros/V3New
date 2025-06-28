<style>
    .sidebarT {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: white;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 15px;
    }

    .sidebarT li #element {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 16px;
        /*   color: #818181; */
        display: block;
        transition: 0.3s;
    }

    /* .sidebarT a:hover {
        color: #f1f1f1;
    } */

    .sidebarT .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    li .item {
        padding-left: 25px;
    }

    li .item :hover {
        color: blue;
    }

    .float {
        position: fixed;
        width: 50px;
        height: 50px;
        top: 20vh;
        left: 10px;
        background-color: #361866;
        color: #FFFFFF;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 3px #999;
        cursor: pointer;
    }

    /* .float a:hover {
        color: #FFF;
    } */

    .my-float {
        margin-top: 22px;
    }
    .divmiULocultar a{
        margin-left: 40px !important;
    }
    .divmiULocultar label{
        margin-left: 40px !important;
    }

    @media screen and (max-height: 450px) {
        .sidebarT {
            padding-top: 15px;
        }

        /*   .sidebarT a {font-size: 18px;} */
    }
</style>
<div id="mySidenav" class="sidebarT">
    <section class="container-fluid">
        <div class="col-md-12">
            <h4> <?= $tipo == "Siniestros" ? $tipo : 'Capital Humano' ?><a onclick="closeNav()"><i class="glyphicon glyphicon-remove pull-right"></i></a></h4>
        </div>
    </section>
    <ul>
        <?php foreach ($this->menu as $key => $value) : ?>
            <?php if (isset($value["child"])) : ?>
                <?php foreach ($value['child'] as $ky => $vl) : ?>
                    <?php if (isset($vl["child"])) : ?>
                        <?php if ($vl["type"] == $tipo) : ?>
                            <?php foreach ($vl['child'] as $ky2 => $vl2) : ?>
                                <li>
                                    <a id="element" href="<?= $vl2['href'] ?>" title="EJEMPLO"><span>
                                            <span class="<?= $vl2['icon'] ?>"></span>
                                        </span> <?= $vl2['title'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach;  ?>
            <?php endif ?>
        <?php endforeach;  ?>
        <li class="dropdown">
            <a id="element" style="cursor:pointer;" class="dropdown-toggle item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-bell alertNotificacao"></span>
                <span class='badgeAlert'><?php echo (empty($this->dataNotificacion) ? count($this->dataNotificacion) : '0'); ?></span>
                <span class="caret"></span></a>
            <ul class="list-notificacao dropdown-menu">
                <?php if (count($this->dataNotificacion) > 0) : ?>
                    <?php foreach ($this->dataNotificacion as $key => $value) : ?>
                        <?php $texto = explode(",", $value->Contenido) ?>
                        <li style="width:270px; padding:8px; border-bottom:1px solid #e3e3e3">
                            <div class="media">
                                <a href="<?= base_url() ?>Notificaciones/<?= $value->referencia_id ?>/<?= $value->referencia ?>">
                                    <div class="media-body">
                                        <small class="text-muted" style="float:right">
                                            <span class="glyphicon glyphicon-calendar alertNotificacao"></span>
                                            <?= date("d-m-Y, g:i a", strtotime($value->fecha_alta)) ?>
                                        </small>
                                        <h5 class="media-heading"><?php echo $texto[0] ?></h5>
                                        <p><?php echo $texto[1] ?></p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li>
                        <div class="media text-center">
                            <p>No hay notificaciones disponibles</p>
                        </div>
                    </li>
                <?php endif ?>
            </ul>
        </li>
    </ul>
    <!-- <a href="#">About</a>
  <a href="#">Services</a>
  <a href="#">Clients</a>
  <a href="#">Contact</a> -->
</div>


<script>
    function openNav() {
        //console.log("lolo")
        document.getElementById("mySidenav").style.width = "280px";
    }

    function closeNav() {
        //console.log("lolC")
        document.getElementById("mySidenav").style.width = "0";
    }
</script>