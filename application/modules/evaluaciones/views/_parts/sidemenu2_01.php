<style>
    .divmiULocultar > a {
        color: white;
        margin-left: 30px !important;
    }
    .divmiULocultar > label {
        color: white;
        margin-left: 30px !important;
    }
    .panel_botones {
        background-color: #fff;
        width: 9%;
        border-radius: 8px;
        float: left;
       /*  margin-left: -40px; */
        margin-left: -10px;
        padding: 5px;
        margin-right: 15px;
        height: auto;
        margin-top: 2px;
    }

    .boton {
        border-style: solid;
        border-radius: 8px;
        border-width: 1px;
        margin-top: -5%;
        margin-bottom: 10%;
        text-align: center;
    }

    .lbboton {
        font-size: 12px;
        font-family: verdana;
    }

    .btn-primary {
        color: #fff;
        background-color: #67439f;
        border-color: #57348c;
    }

    li .item :hover {
        color: #7955b2;
    }

    li .item {
        padding-left: unset !important;
    }
</style>
<div style="position: relative; padding-top: 1px;">
<!-- style="overflow:auto; height: 80vh; width: 100px;" -->
    <div class="panel_botones" >
        <table>
            <?php foreach ($this->menu as $key => $value) : ?>
                <?php if (isset($value["child"])) : ?>
                    <?php foreach ($value['child'] as $ky => $vl) : ?>
                        <?php if (isset($vl["child"])) : ?>
                            <?php if ($vl["type"] == $tipo) : ?>
                                <?php foreach ($vl['child'] as $ky2 => $vl2) : ?>
                                    <tr>
                                        <td>
                                            <a href="<?= $vl2['href'] ?>">
                                                <div class="boton">
                                                    <i class="<?= $vl2['icon'] ?> fa-4x"></i><br>
                                                    <span class="lbboton"><?= $vl2['title'] ?></span>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach;  ?>
                <?php endif ?>
            <?php endforeach;  ?>
        </table>
    </div>
    </div>