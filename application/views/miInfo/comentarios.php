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

 <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
    <div class="card-body d-flex flex-column">
           <h5 class="card-title mb-0"><i class="fa fa-comments"></i>&nbsp;&nbsp;Comentarios</h5>
           
    </div>
            <div style="height: 250px;overflow: auto;">
            <?php 
             if($comentarios){
                 foreach ($comentarios as $comentario) {?>
                  <div class="d-flex mt-6 py-2 border-bottom">
                    <?php if(getIniciales($comentario->nombre)!='A'){?>
                        <span class="img-sm rounded-circle bg-success text-white text-avatar" style="width: 7%;height: 30px;text-align: center;padding-top: 1%;"><?php echo getIniciales($comentario->nombre)?></span>
                    <?php }else{?>
                         <span class="img-sm rounded-circle bg-warning text-white text-avatar" style="width: 7%;height: 30px;text-align: center;padding-top: 1%;"><?php echo getIniciales($comentario->nombre)?></span>
                    <?php }?>
                    
                    <div class="wrapper ml-2">
                      <p class="mb-n1 font-weight-semibold"><?php echo $comentario->nombre?></p>
                      <small><?php echo $comentario->comentario?></small>
                    </div><br>
                    <small class="text-muted ml-auto"><?php echo date('d-m-Y h:i:s',strtotime($comentario->date));?></small>
                  </div>
            <?php }
            }else{ ?>
                <div class="d-flex mt-6 py-2 border-bottom">
                    <div class="alert alert-success" style="width:100%">No hay comentarios </div>
                </div>
           <?php } ?>
            </div>

    </div>
    </div>