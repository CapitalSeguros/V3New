<div style="float: left; width: 10%;"><!-- position: relative; padding-top: 1px; -->
    <div class="panel_botones">
        <ul class="accordion-menu">
            <li>
                <div class="dropdownlink"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                    <div class="text-menu-servicio"> Documentos</div>
                </div>
                <ul class="submenuItems">
                    <li><a href="<?= base_url() ?>servicioSistema/OrdenTrabajo">Pólizas</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Fianza">Fianzas</a></li>
                </ul>
            </li>
            <li>
                <div class="dropdownlink"><i class="fa fa-road" aria-hidden="true"></i>
                    <div class="text-menu-servicio">Catalogos</div>
                </div>
                <ul class="submenuItems">
                    <li><a href="<?= base_url() ?>servicioSistema/Bancos">Bancos</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/ClasificacionDocumento">Clasificación Documento</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/ConductoCobro">Conducto Cobro</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Compania">Compañia</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Departamento">Departamento</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Direcciones">Direcciones</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Departamento">Departamento</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/EstatusCancelacion">Estatus Cancelacion</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/EstatusCobro">Estatus Cobro</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/EstatusDocumento">Estatus Documento</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/EstatusRecuperacion">Estatus Recuperación</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/FormaPago">Forma de Pago</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Gerencias">Gerencias</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Grupo">Grupo</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/SubGrupo">SubGrupo</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/LineaNegocio">Línea Negocio</a></li><!-- LineaCobro -->
                    <li><a href="<?= base_url() ?>servicioSistema/Moneda">Moneda</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/MotivoCancelacion">Motivo Cancelacion</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Oficinas">Oficinas</a></li>
                    <!-- <li><a href="<?= base_url() ?>servicioSistema/Ramo">Ramo</a></li> -->
                    <li><a href="<?= base_url() ?>servicioSistema/TipoDoc">Tipo documento</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/TipoDocumento">Tipo documento Póliza</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/TipoPago">Tipo pago</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/TipoVenta">Tipo venta</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Vendedores">Vendedores</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Despacho">Despachos</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/TipoAgente">Tipo Agente</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/TipoCedula">Tipo Cédula</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/CompaniaClasificacion">Clasificación Compañia</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/EstatusUsuario">Estatus Usuario</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Servicio">Servicio</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/UsoServicio">Uso Servicio</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Marca">Marca</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/SubMarca">SubMarca</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/Color">Color</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/TipoFianza">Tipo Fianza</a></li>
                    <li><a href="<?= base_url() ?>servicioSistema/ProductoFianza">Productos Fianza</a></li>
                </ul>
            </li>
            <!-- <li>
                <div class="dropdownlink"><i class="fa fa-quote-left" aria-hidden="true"></i>
                    <div class="text-menu-servicio">Pólizas</div>
                </div>
                <ul class="submenuItems">
                    <li><a href="<?= base_url() ?>servicioSistema/">Poliza</a></li>
                </ul>
            </li> -->
        </ul>
    </div>
</div>

<script>
    $(function() {
        var Accordion = function(el, multiple) {
            this.el = el || {};
            // more then one submenu open?
            this.multiple = multiple || false;

            var dropdownlink = this.el.find('.dropdownlink');
            dropdownlink.on('click', {
                    el: this.el,
                    multiple: this.multiple
                },
                this.dropdown);
        };

        Accordion.prototype.dropdown = function(e) {
            var $el = e.data.el,
                $this = $(this),
                //this is the ul.submenuItems
                $next = $this.next();

            $next.slideToggle();
            $this.parent().toggleClass('open');

            if (!e.data.multiple) {
                //show only one menu at the same time
                $el.find('.submenuItems').not($next).slideUp().parent().removeClass('open');
            }
        }

        var accordion = new Accordion($('.accordion-menu'), false);
    })
</script>