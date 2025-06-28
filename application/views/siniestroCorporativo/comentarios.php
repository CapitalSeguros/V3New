<?php if (count($comentario) == 0) : ?>
    <div class="col-12 comment-boder">
        <div class="d-flex text-center py-1 pt-2">
            <span class="text2">No hay comentarios disponibles.</span>
        </div>
    </div>
<?php endif; ?>
<?php foreach ($comentario as $value) : ?>
    <div class="col-12 comment-boder"> <span class="text1"><?= $value["comentario"] ?></span>
        <div class="d-flex justify-content-between py-1 pt-2">
            <div><i class="fa fa-user"></i><span class="text2"><?= $value["usuario"] ?></span></div>
            <div><span class="thumbup"><i class="fa fa-clock-o" aria-hidden="true"></i></span><span class="text4"><?= $value["fecha_add"] ?></span></div>
        </div>
    </div>
<?php endforeach; ?>