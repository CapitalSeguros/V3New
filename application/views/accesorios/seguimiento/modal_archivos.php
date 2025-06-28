<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal fade" id="modal_archivos_eval_tarea">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Archivos adjuntos</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Inconforme:</b></div>
                    <ul class="list-group" id="lista_inconforme">
                        <!-- <li class="list-group-item"><a href="ruta/al/archivo.ext" download>Test.ext</a></li> -->
                    </ul>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Resuelto:</b></div>
                    <ul class="list-group" id="lista_resuelto"></ul>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Responsable:</b></div>
                    <ul class="list-group" id="lista_responsable"></ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->