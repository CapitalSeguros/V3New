<style>
    .circle {
        margin-top: 10px;
        width: 20px;
        height: 20px;
        background: #D2D8DE;
        cursor: pointer;
        -moz-border-radius: 50px;
        -webkit-border-radius: 50px;
        border-radius: 50px;
    }

    .correct {
        background: #361866 !important;
    }

    .normal {
        background: #D2D8DE !important;
    }

    .note {
        margin-top: 10px;
    }
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Catálogo de preguntas</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<input type="hidden" id="idRow">
<section class="container">
<?= $this->load->view('_parts/sidemenu2',array("tipo"=>$tipo));?>
    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="form-group col-md-12">
                <div id="jfileupload">
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th scope="col" class="col-md-9">Título</th>
                                    <th scope="col" class="col-md-2">Tipo de pregunta</th>
                                    <th scope="col" class="col-md-1" style='text-align: center;'>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- panel-body -->
        </div><!-- panel-default -->
    </div>
</section>



<div id="mymodal" class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header titulos">
                <h4 class="modal-title" id="exampleModalLabel">Vista previa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="surveyElement"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--final del form modal-->
            <div class="modal-footer">
                <button type="button" style="visibility: hidden;" id="editar35" name="edit45" class="btn btn-primary" onclick=""><i class="fa fa-trash-o" aria-hidden="true"></i> Prueba</button>
                <button type="button" style="visibility: hidden;" id="eliminar" name="eliminar" class="btn btn-primary" onclick="algoReact()"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <div id="padre" class="hidden">
                    <button type="button" style="visibility: hidden;" id="editar" name="editar" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</button>
                </div>
            </div>
        </div>
    </div>
</div><style type="text/css">
    .modal-backdrop{height: 0px}
</style>