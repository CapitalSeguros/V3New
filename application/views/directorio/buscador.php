<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="page-section">
    <style>
        tr.tbheader
        {
            cursor:pointer;
        }
    </style>
	<div class="container" style="margin-top:2%;">
        <form action="#" method="POST" id="frmBuscador">
    		<div class="row">
    	           <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="tipodoc">Tipo Documento</label>
                                <select name="tipodoc" id="tipodoc" class="form-control2 input-sm">
                                    <option value="">Selecione una opci&oacute;n</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="solicitud">Solicitud</label>
                                <input type="text" name="solicitd" id="solicitud" class="form-control input-sm" placeholder="Solicitud"/>
                            </div>
                            <div class="col-md-4">
                                <label for="anterior">Anterior</label>
                                <input type="text" name="anterior" id="anterior" class="form-control input-sm" placeholder="Anterior"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="polizamaestra"><?php echo htmlentities("P&oacute;liza Maestra");?></label>                       
                                <input type="text" name="polizamaestra" id="polizamaestra" class="form-control input-sm" placeholder="<?php echo htmlentities("P&oacute;liza Maestra");?>"/>
                            </div>
                            <div class="col-md-4">
                                <label for="documento">Documento</label>
                                <input type="text" name="documento" id="documento" class="form-control input-sm" placeholder="Documento"/>
                            </div>
                            <div class="col-md-4">
                                <label for="posterior">Posterior</label>
                                <input type="text" name="posterior" id="posterior" class="form-control input-sm" placeholder="Posterior"/>
                            </div>
                        </div>
                   </div>
    		</div>
            <div class="row row-individual">
                <div class="col-md-12">
                    <div id="wizard">
                        <h3>General</h3>
                        <section>
                            <div class="row row-tabs">
                                <div class="col-md-9">
                                    <div class="row row-tabs">
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="cliente">Cliente</label>
                                                    <input type="text" name="cliente" id="cliente" class="form-control input-sm" placeholder="Cliente"/>
                                                </div>
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="direccion"><?php echo htmlentities("Direcci&oacute;n");?></label>
                                                    <input type="text" name="direccion" id="direccion" class="form-control input-sm" placeholder="<?php echo htmlentities("Direcci&oacute;n");?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="agente">Agente</label>
                                                    <input type="text" name="agente" id="agente" class="form-control input-sm" placeholder="Agente"/>
                                                </div>
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="ejecutivo"><?php echo htmlentities("Ejecutivo de Compa&ntilde;ia");?></label>
                                                    <input type="text" name="ejecutivo" id="ejecutivo" class="form-control input-sm" placeholder="<?php echo htmlentities("Ejecutivo de Compa&ntilde;ia");?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-tabs">
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="form-group col-md-6">
                                                    <label for="fechaini">Desde</label>
                                                    <div class="input-group">
                                                        <input type="text" name="fechaini" id="fechaini" class="form-control input-sm fecha" placeholder="01/01/1900"/>
                                                        <div class="input-group-btn"><button class="btn btn-default btn-sm" type="button"><i class="glyphicon glyphicon-calendar"></i>&nbsp;</button></div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fechafin">Hasta</label>
                                                    <div class="input-group">
                                                        <input type="text" name="fechafin" id="fechafin" class="form-control input-sm fecha" placeholder="01/01/1900"/>
                                                        <div class="input-group-btn"><button class="btn btn-default btn-sm" type="button"><i class="glyphicon glyphicon-calendar"></i>&nbsp;</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="row row-tabs">
                                                <div class="form-group col-md-6">
                                                    <label for="fechaantiguedad">Fecha de antiguedad</label>
                                                    <div class="input-group">
                                                        <input type="text" name="fechaantiguedad" id="fechaantiguedad" class="form-control input-sm fecha" placeholder="01/01/1900"/>
                                                        <div class="input-group-btn"><button class="btn btn-default btn-sm" type="button"><i class="glyphicon glyphicon-calendar"></i>&nbsp;</button></div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="renovacion"><?php echo htmlentities("Renovaci&oacute;n");?></label>
                                                    <input type="text" name="fechafin" id="fechafin" class="form-control input-sm" placeholder="<?php echo htmlentities("Renovaci&oacute;n");?>"/>
                                                </div>
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="pagos">Celendario de Pagos</label>
                                                    <input type="text" name="pagos" id="pagos" class="form-control input-sm" palceholder="Calendario de Pagos"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="col-md-8">
                                                    <label for="moneda">Moneda</label>
                                                    <input type="text" name="moneda" id="moneda" class="form-control input-sm" placeholder="Moneda"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="tipocambio">Tipo de Cambio</label>
                                                    <input type="text" name="tipocambio" id="tipocambio" class="form-control input-sm" placeholder="Tipo de Cambio"/>
                                                </div>
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="formapago">Forma de pago</label>
                                                    <select name="formapago" id="formapago" class="form-control2 input-sm">
                                                        <option value="">Seleccione una forma de pago</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="cvendedor">Vendedor</label>
                                            <select name="cvendedor" id="cvendedor" class="form-control2 input-sm">
                                                <option value=""><?php echo htmlentities("Seleccione una opci&oacute;n");?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="cejecutivo">Ejecutivo</label>
                                            <select name="cejecutivo" id="cejecutivo" class="form-control2 input-sm">
                                                <option value=""><?php echo htmlentities("Seleccione una opci&oacute;n");?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="grupo">Grupo</label>
                                            <select name="grupo" id="grupo" class="form-control2 input-sm">
                                                <option value=""><?php echo htmlentities("Seleccione una opci&oacute;n");?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="subgrupo">Sub Grupo</label>
                                            <select name="subgrupo" id="subgrupo" class="form-control2 input-sm">
                                                <option value=""><?php echo htmlentities("Seleccione una opci&oacute;n");?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="subsubgrupo">Sub Sub Grupo</label>
                                            <select name="subsubgrupo" id="subsubgrupo" class="form-control2 input-sm">
                                                <option value=""><?php echo htmlentities("Seleccione una opci&oacute;n");?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="ecobranza">Ejecutivo Cobranza</label>
                                            <select name="ecobranza" id="cobranza" class="form-control2 input-sm">
                                                <option value=""><?php echo htmlentities("Seleccione una opci&oacute;n");?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="ereclamo">Ejecutivo Reclamo</label>
                                            <select name="ereclamo" id="ereclamo" class="form-control2 input-sm">
                                                <option value=""><?php echo htmlentities("Seleccione una opci&oacute;n");?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-tabs">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="referencia1">Referencia 1</label>
                                            <input type="text" name="referencia1" id="referencia1" class="form-control input-sm" placeholder="Refencia 1"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="referencia3">Referencia 3</label>
                                            <input type="text" name="referencia3" id="referencia3" class="form-control input-sm" placeholder="Refencia 3"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="referencia2">Referencia 2</label>
                                            <input type="text" name="referencia2" id="referencia2" class="form-control input-sm" placeholder="Refencia 2"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="referencia4">Refencia 4</label>
                                            <input type="text" name="referencia1" id="referencia1" class="form-control input-sm" placeholder="Refencia 4"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-tabs">
                                <div class="col-md-12">
                                    <label for="concepto">Concepto</label>
                                    <textarea name="concepto" id="concepto" rows="2" class="form-control input-sm"></textarea>
                                </div>
                            </div>
                        </section>
                        <!--h3>Detalle</h3>
                        <section>
                        </section>
                        <h3>Endosos Asegurables</h3>
                        <section>
                        </section-->
                    </div>
                </div>
            </div>
        </form>
        <!--div class="row">
			<div class="col-sm-4 col-md-4" align="right">
            </div>
			<div class="col-sm-4 col-md-4" align="right">
            </div>
			<div class="col-sm-4 col-md-4" align="right">
            </div>
			<div class="col-sm-4 col-md-4" align="right">
            </div>
        </div-->
	</div>            
</section>
<?php $this->load->view('footers/footer'); ?>