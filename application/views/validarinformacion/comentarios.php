 <?php

    function getIniciales($nombre){
        if($nombre!=''){
            $P=explode(" ",$nombre);
            if(isset($P[1])){
                $n=$P[0];
                $a=$P[1];
                $n=substr($n,0,1);
                $a=substr($a,0,1);
                $nombre=$n.$a;
            }else{
                $nombre=substr($nombre,0,1);
            }
            return strtoupper($nombre);
        }else{
            return 'A';
        }
    }
 ?>
 <div class="">
    <div class="panel panel-default">
    <div class="panel-body d-flex flex-column">
        <div class="col-md-12" hidden>
                <div class="section-title">
                    <h5 class="text-center">Deja tus comentarios</h5>
                </div>
                 <p>
                    <input type="text" name="nombre" id="nombre" type="form-control" placeholder="Escribe tu nombre (opcional)" class="form-control">
                </p>
                <p>
                    <input type="text" name="comentario" id="comentario" type="form-control" placeholder="Escribe tu comentario" class="form-control">
                </p>
                 <p>
                    <a class="btn btn-primary btn-block" onclick="guardarComentarios('<?php echo $idPersona?>')">Guardar</a>
                </p>
            </div>

                <hr class="divider-segment" style="margin: 30px 0;" hidden>
            <div class="col-md-12 pd-left pd-right">
            <div class="container-title-comments"><center><h5 class="mg-cero"><i class="fa fa-comments"></i>&nbsp;&nbsp;Comentarios</h5></center></div>
            <div class="container-comments" id="comentariosDiv">
            <?php 
             if($comentarios){
                 foreach ($comentarios as $comentario) {?>
                  <div class="comentariosDiv">
                    <div class="textUserComment">
                        <div class="column-flex-center-start">
                            <?php if(getIniciales($comentario->nombre)!='A'){?>
                                <div class="dash-user-comment"><?php echo getIniciales($comentario->nombre)?></div>
                            <?php }else{?>
                                 <div class="dash-user-comment"><?php echo getIniciales($comentario->nombre)?></div>
                            <?php }?>
                            <p class="mb-n1 font-weight-semibold mg-bottom-cero"><?php echo $comentario->nombre?></p>
                        </div>
                        <div><small class="text-muted ml-auto"><i class="fas fa-calendar-alt mg-right"></i><?php echo date('d-m-Y h:i:s',strtotime($comentario->date));?></small></div>
                    </div>
                    <div class="textComment">
                        <small><i class="fa fa-comments"></i>&nbsp;<?php echo $comentario->comentario?></small>
                    </div>
                  </div>
                <br>
            <?php }
            }else{ ?>
                <div class="d-flex mt-6 py-2 border-bottom">
                    <div class="alert alert-success" style="width:100%">No hay comentarios </div>
                </div>
           <?php } ?>
            </div>
        </div>
        </div>
    </div>
    </div>