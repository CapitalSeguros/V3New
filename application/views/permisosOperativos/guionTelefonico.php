<?php 
    function validateUrl($url){
        $urlHeader = get_headers($url);
        $arrayHeader = explode(" ", $urlHeader[0]);
        //var_dump($arrayHeader);
        return $arrayHeader[1] == "200" ? true : false;
        //return strpos("200", $urlHeader[0]) === false ? false: true;
    }
?>

<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-12">
            <h3 class="title-section-module">Guiones Telefónicos - Tutoriales</h3>
        </div>
    </div>
    <hr/>
</section>
<div class="col-md-12">
            <div class="col-md-12">
                <ul class="nav nav-pills nav-stacked column-flex-center" role="tablist" id="myTab">
                    <li role="presentation" class="dropdown active">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            Crear contenido
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a data-toggle="tab" href="#create" role="tab" aria-controls="create">Crear guión</a></li>
                            <li role="presentation"><a data-toggle="tab" href="#create-tutorial" role="tab" aria-controls="create-tutorial">Crear contenido tutorial</a></li>
                        </ul>
                    </li>
                    <!--<li role="presentation" class="active"><a data-toggle="tab" href="#create" role="tab" aria-controls="create">Crear guión</a></li>-->
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            Contenido creado
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a data-toggle="tab" href="#guion_lista" role="tab" aria-controls="guion_lista">Guiones creados</a></li>
                            <li role="presentation"><a data-toggle="tab" href="#tutorial_lista" role="tab" aria-controls="tutorial_lista" id="tutorial-lista">Tutoriales creados</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane active" id="create" role="tabpanel">
                    <h4>Crea un guion telefónico</h4>
                    <hr style="border-top: 1px solid #9d9d9d;">
                    <div class="row">
                        <div class="col-md-3">
                            <div><button class="btn btn-info btn-sm" id="crear_guion">Crear bloque de conversación</button></div>
                            <div class="mt-3">
                                <div class="form-group row">
                                        <label for="modulo" class="col-sm-8 col-form-label">Módulo del sistema</label>
                                        <div class="col-md-8">
                                            <select name="modulo" id="modulo" class="form-control">
                                                <option value="0">Seleccione</option>
                                                <?php foreach($modulos_guiones as $valor){?>
                                                    <option value="<?=$valor->idModulo?>"><?=strtoupper($valor->modulo)?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div>
                                <div class="form-group row">
                                    <label for="nombreGuion" class="col-sm-8 col-form-label">Nombre del guion</label>
                                    <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="nombreGuion"></div>
                                </div>
                            </div>
                            <div><button class="btn btn-success btn-sm" id="enviaDatos" data-modulo="0" data-guion="0">Crear guion telefónico</button></div>
                        </div>
                        <div class="col-md-9">
                            <form action="#" id="cont_creacion"></form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="create-tutorial" role="tabpanel">
                <h4>Crear contenido tutorial</h4>
                    <hr style="border-top: 1px solid #9d9d9d;">
                    <input type="hidden" name="tutorialid" id="tutorial-id" value="0">
                    <div class="row">
                        <div class="col-md-4">
                            <p>Nombrar tutoría</p>
                            <input type="text" class="form-control" value id="tutorialname">
                        </div>
                        <div class="col-md-5">
                            <p>Cargar contenido multimedia</p>
                            <input type="file" id="tutorialfile">
                            <p class="help-block" style="font-style: italic;">*Solo contenido de video</p>
                        </div>
                        <div class="col-md-3">
                            <p>Alojar tutorial a un módulo</p>
                            <select name="modulo" id="tutorialmodule" class="form-control">
                                <option value="0">Seleccione</option>
                                <?php foreach($tutorial_modules as $valor){?>
                                    <option value="<?=$valor->idModulo?>"><?=strtoupper($valor->modulo)?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <p>Descripción de la tutoría</p>
                            <textarea class="form-control" name="tutorialdescription" id="tutorialdescription" cols="55" rows="7"></textarea>
                        </div>
                        <div class="col-md-3">
                            <p>Generar contenido</p>
                            <button class="btn btn-primary" id="generatetutorial">Guardar contenido</button>
                            <br>
                            <div class="clear-form text-center"></div>
                            <br>
                            <div class="to-tutorial-content text-center"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-12 upload-progress"></div>
                            <div class="col-md-12 mt-4" style="padding: 0px;">
                                <hr style="border-top: 1px solid #e3e3e3;margin-bottom: 0px;">
                            </div>
                            <div class="col-md-12 mt-4 upload-complete hidden">
                                <h4>Tutorial subido al sistema</h4>
                                <hr style="border-top: 1px solid #9d9d9d;">
                                <br>
                                <div class="tutorial-uploaded"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="guion_lista" role="tabpanel">
                    <h4>Lista de guiones creados</h4>
                    <hr style="border-top: 1px solid #9d9d9d;">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <?php if(!empty($lista_guion)){
                                    foreach($lista_guion as $idmodulo => $guion){?> 
                                        <!--<a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-g-<?=$idmodulo?>" role="tab" aria-controls="v-pills-home" aria-selected="true"><?=strtoupper($guion["modulo"])?></a>-->
                                        <li role="presentation" ><a href="#g-<?=$idmodulo?>" aria-controls="g-<?=$idmodulo?>" role="tab" data-toggle="tab"><?=strtoupper($guion["modulo"])?></a></li>
                                <?php }
                            }?>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="home"><h4 class="text-center mt-4">Seleccione cualquier de las opciones de lado de arriba</h4></div>
                            <?php if(!empty($lista_guion)){
                                foreach($lista_guion as $idmodulo => $guion){?>

                                <div role="tabpanel" class="tab-pane" id="g-<?=$idmodulo?>">
                                    <h4>Módulo seleccionado <span style="color: #472380"><?=strtoupper($guion["modulo"])?></span></h4>
                                    <?php if(!empty($guion["guion"])){
                                        foreach($guion["guion"] as $idGuion => $data_mensajes){?>

                                            <div class="panel panel-default">
                                                <div class="panel-heading mt-4 gc-<?=$idGuion?>">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a class="text-white" data-toggle="collapse" href="#collapse-g-<?=$idGuion?>" aria-expanded="false" aria-controls="collapse-g-<?=$idGuion?>"><?=$data_mensajes["nombre"]?> <span class="caret"></span> </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="dropdown">
                                                                <button id="dropdown-g-<?=$idGuion?>" class="btn btn-link btn-sm text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opciones</button>
                                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-g-<?=$idGuion?>">
                                                                    <li role="presentation" class="text-info"><a role="menuitem" tabindex="-1" href="javascript: void(0)" data-modulo="<?=$idmodulo?>" data-guion="<?=$idGuion?>" onclick="editarGuion(this)">Editar</a></li>
                                                                    <li role="presentation" class="divider"></li>
                                                                <li role="presentation" class="text-danger"><a role="menuitem" tabindex="-1" href="javascript: void(0)" data-modulo="<?=$idmodulo?>" data-guion="<?=$idGuion?>" onclick="eliminarGuion(this)">Eliminar</a></li>
                                                            </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body collapse" id="collapse-g-<?=$idGuion?>">
                                                    <?php if(!empty($data_mensajes["mensajes"])){
                                                            foreach($data_mensajes["mensajes"] as $data_texto){?> 
                                                                    <h5><span class="label label-info visible"><?=strtoupper($data_texto["etiqueta"])?></span></h5>
                                                                    <p class="text-left font-italic visible"><?=$data_texto["texto"]?></p>
                                                        <?php } 
                                                    }?>
                                                </div>
                                            </div>

                                        <?php } 
                                    }?>
                                </div>
                                <?php }
                            }?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tutorial_lista" role="tabpanel">
                    <h4>Tutoriales creados</h4>
                    <hr style="border-top: 1px solid #9d9d9d;">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <?php foreach($tutorial_list as $idModule => $d_m){?>
                                <li role="presentation" ><a href="#t-<?=$idModule?>" class="tab-tutorial-modules" aria-controls="#t-<?=$idModule?>" role="tab" data-toggle="tab"><?=strtoupper($d_m["modulo"])?></a></li>
                            <?php }?>
                        </ul>
                        <div class="tab-content">
                            <?php 
                                $fileurl = "https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/modulos_de_tutoria%2F"; //FPROSPECTO%2F29_julio.mp4?alt=media&token="
                                $token = "?alt=media&token=";
                                foreach($tutorial_list as $idModule => $d_m){?>
                                <div role="tabpanel" class="tab-pane table-responsive" id="t-<?=$idModule?>">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h4>Módulo seleccionado <span style="color: #472380"><?=strtoupper($d_m["modulo"])?></span></h4>
                                        </div>
                                        <div class="col-md-4"><!--<button class="btn btn-primary btn-sm refresh-content"><i class="fa fa-refresh" aria-hidden="true"></i> Refrescar contenido</button>--></div>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nombre del tutorial</th>
                                                <th>Descripción</th>
                                                <th>Contenido multimedia</th>
                                                <th>Fecha de creación</th>
                                                <th>Actualización</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($d_m["tutorial"] as $reg_tutorial){
                                                $downloadFile = "";
                                                $downloadUrl = validateUrl($fileurl.strtoupper($d_m["modulo"])."%2F".$reg_tutorial->nameDoc);
                                                if($downloadUrl){
                                                    $getDataFile = json_decode(file_get_contents($fileurl.strtoupper($d_m["modulo"])."%2F".$reg_tutorial->nameDoc), true);
                                                    //var_dump($getDataFile);
                                                    $downloadFile = $fileurl.strtoupper($d_m["modulo"])."%2F".$reg_tutorial->nameDoc.$token.$getDataFile["downloadTokens"];
                                                }
                                                //var_dump($getDataFile);
                                                //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($getDataFile, TRUE));fclose($fp);
                                            ?>
                                                <tr id="<?=$d_m["modulo"]."-".$reg_tutorial->idTutorial?>">
                                                    <td><?=$reg_tutorial->name?></td>
                                                    <td><?=$reg_tutorial->description?></td>
                                                    <td><a href="<?=$downloadFile?>" target="_blank" data-file="<?=$reg_tutorial->nameDoc?>" data-module="<?=$d_m["modulo"]?>"><?=$reg_tutorial->nameDoc?></a></td>
                                                    <td><?=$reg_tutorial->dateCreation?></td>
                                                    <td><?=$reg_tutorial->dateUpdate?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="ddt-<?=$reg_tutorial->idTutorial?>" data-toggle="dropdown" aria-expanded="true">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu" aria-labelledby="ddt-<?=$reg_tutorial->idTutorial?>">
                                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" class="updateRegister" data-id="<?=$reg_tutorial->idTutorial?>" data-doc="<?=$reg_tutorial->nameDoc?>" data-module="<?=$d_m["modulo"]?>">Modificar</a></li>
                                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" class="deleteRegister" data-id="<?=$reg_tutorial->idTutorial?>" data-doc="<?=$reg_tutorial->nameDoc?>" data-module="<?=$d_m["modulo"]?>">Eliminar</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<script src="<?php echo site_url('assets/js/js_guionTelefonico.js');?>"></script>-->