<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>

<div class="container-fluid">
    <h3>Administrador de enlaces de apoyo</h3>
    <div class="row mt-4">
        <div class="ml-4" role="tab-panel">
            <ul class="nav nav-pills nav-stacked" role="tablist">
                <li role="presentation" class="active">
                    <a href="#list" aria-controls="list" role="tab" data-toggle="tab" type="button">
                        <div class="text-center"><i class="fa fa-list fa-3x" aria-hidden="true"></i></div>
                        <div>Lista de enlaces</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 tab-content">
            <div role="tabpanel" class="tab-pane active" id="list">
                <h3>Lista de enlaces creados</h3>
                <div><button class="btn btn-primary create-link" data-show-active="true">Crear enlace</button></div>
                <div class="link-list mt-4 table-responsive">
                    <table class="table table-link-list">
                        <thead>
                            <tr>
                                <th>Etiqueta</th>
                                <th>Enlace</th>
                                <th>Creado por</th>
                                <th>Fecha de creación</th>
                                <th>Activar</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="tbody-link-list"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="form-link" tabindex="-1" role="dialog" aria-labelledby="form-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Crear liga de apoyo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-links">
                    <div class="form-group">
                        <label for="link-label">Número de enlace</label>
                        <input type="text" name="link-id" class="form-control-plaintext" id="link-id" value="0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="link-label">Etiqueta del enlace</label>
                        <input type="text" name="link-label" class="form-control" id="link-label" placeholder="Enlace de apoyo para descarga de documento" required>
                    </div>
                    <div class="form-group">
                        <label for="link-link">Enlace de apoyo</label>
                        <textarea name="link-link" id="link-link" cols="30" rows="3" placeholder="https://ejemplo.com/paginaWeb" class="form-control" required></textarea>
                    </div>
                    <div class="form-group link-active-cont">
                        <label for="link-activate">Mantener enlace</label>
                        <div class="radio">
                            <label><input type="radio" name="link-active" id="link-active" value="1" checked> Activo</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="link-active" id="link-in-active" value="0"> Inactivo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary submit-link-data">Crear enlace</button>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="base-url" data-url="<?=base_url()?>"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
<script src="<?=base_url()."assets/js/jquery.managesupportlinks.js"?>"></script>
