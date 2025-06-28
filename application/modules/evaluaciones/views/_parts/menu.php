<style>
.pull-right > .dropdown-menu {
    right: 0;
    left: auto;
}

.dropup .caret,
.navbar-fixed-bottom .dropdown .caret {
    border-top: 0;
    border-bottom: 4px solid #000000;
    content: "";
}

.dropup .dropdown-menu,
.navbar-fixed-bottom .dropdown .dropdown-menu {
    top: auto;
    bottom: 100%;
    margin-bottom: 1px;
}


.dropdown-submenu > .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover > .dropdown-menu {
    display: block;
}

.dropup .dropdown-submenu > .dropdown-menu {
    top: auto;
    bottom: 0;
    margin-top: 0;
    margin-bottom: -2px;
    -webkit-border-radius: 5px 5px 5px 0;
    -moz-border-radius: 5px 5px 5px 0;
    border-radius: 5px 5px 5px 0;
}

.dropdown-submenu > a:after {
    display: block;
    float: right;
    width: 0;
    height: 0;
    margin-top: 5px;
    margin-right: -10px;
    border-color: transparent;
    border-left-color: #cccccc;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    content: " ";
}

.dropdown-submenu:hover > a:after {
    border-left-color: #ffffff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left > .dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}


.navbar .nav li.dropdown > a:hover .caret,
.navbar .nav li.dropdown > a:focus .caret {
    border-top-color: #333333;
    border-bottom-color: #333333;
}

.navbar .nav li.dropdown.open > .dropdown-toggle,
.navbar .nav li.dropdown.active > .dropdown-toggle,
.navbar .nav li.dropdown.open.active > .dropdown-toggle {
    color: #555555;
    background-color: #e5e5e5;
}

/* .navbar .nav li.dropdown > .dropdown-toggle .caret {
    border-top-color: #777777;
    border-bottom-color: #777777;
}
 */
.navbar .nav li.dropdown.open > .dropdown-toggle .caret,
.navbar .nav li.dropdown.active > .dropdown-toggle .caret,
.navbar .nav li.dropdown.open.active > .dropdown-toggle .caret {
    border-top-color: #555555;
    border-bottom-color: #555555;
}

.navbar .pull-right > li > .dropdown-menu,
.navbar .nav > li > .dropdown-menu.pull-right {
    right: 0;
    left: auto;
}

.navbar .pull-right > li > .dropdown-menu:before,
.navbar .nav > li > .dropdown-menu.pull-right:before {
    right: 12px;
    left: auto;
}

.navbar .pull-right > li > .dropdown-menu:after,
.navbar .nav > li > .dropdown-menu.pull-right:after {
    right: 13px;
    left: auto;
}

.navbar .pull-right > li > .dropdown-menu .dropdown-menu,
.navbar .nav > li > .dropdown-menu.pull-right .dropdown-menu {
    right: 100%;
    left: auto;
    margin-right: -1px;
    margin-left: 0;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}

</style>
<ul class="nav navbar-nav">
    <?php foreach ($this->menu as $key => $value) : ?>
        <li class="<?= @$value['active'] ?><?= isset($value["child"]) ? 'dropdown' : '' ?>">
            <?php if (isset($value["child"])) : ?>
                <a href="<?= $value['href'] ?>" title="<?= $value['title'] ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span>
                        <image src="<?= DIR_IMAGES ?>images/icons-menu/icon-menuDirectorio.png">
                    </span> <?= $value['title'] ?><span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php foreach ($value['child'] as $ky => $vl) : ?>
                        <?php if (isset($vl["child"])) : ?>  
                            <li class="dropdown-submenu">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="nav-label"><?=$vl["title"]?></span></a>
                            <ul class="dropdown-menu">
                                <?php foreach ($vl['child'] as $ky2 => $vl2) : ?>
                                    <li><a href="<?= $vl2['href'] ?>"><?= $vl2['title'] ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php else : ?>
                            <li>
                                <a href="<?= $vl['href'] ?>" title="<?= $vl['title'] ?>">
                                    <?= $vl['title'] ?>
                                </a>
                            </li>
                        <?php endif ?>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <a href="<?= $value['href'] ?>" title="<?= $value['title'] ?>"><span>
                        <image src="<?= DIR_IMAGES ?>images/icons-menu/icon-menuDirectorio.png">
                    </span> <?= $value['title'] ?>
                </a>
            <?php endif ?>

        </li>
    <?php endforeach;  ?>
    <li class="dropdown">
        <a style="cursor:pointer;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-bell alertNotificacao"></span>
            <span class='badgeAlert'><?php echo (empty($this->dataNotificacion) ? count($this->dataNotificacion) : '0'); ?></span>
            <span class="caret"></span></a>
        <ul class="list-notificacao dropdown-menu">
            <?php if (count($this->dataNotificacion) > 0) : ?>
                <?php foreach ($this->dataNotificacion as $key => $value) : ?>
                    <?php $texto = explode(",", $value->Contenido) ?>
                    <li style="width:350px; padding:8px; border-bottom:1px solid #e3e3e3">
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