<div class="container">
    <div class="row app-ticc">
        <div class="col-12">
            <div class="card mt-5  mb-5">
                <!-- Header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <form class="mb-2 mb-md-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="search" class="form-control form-control-sm" placeholder="Buscar" aria-label="Buscar">
                                </div>
                            </form>
                        </div>
                        <div class="col-4">
                            <!-- Dropdown -->
                            <div class="dropdown float-right">
                                <button type="button" class="btn btn-info btn-shadow btn-sm dropdown-toggle w-100" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi-download me-2"></i> Acciones
                                </button>
                                <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="dropdownMenuButton">
                                    <a class="nav-link">
                                        <i class="nav-link-icon fa fa-save"></i>
                                        <span> Guardar</span>
                                    </a>
                                    <a class="nav-link">
                                        <i class="nav-link-icon fa fa-plus"></i>
                                        <span> Nuevo</span>
                                    </a>
                                    <a class="nav-link">
                                        <i class="nav-link-icon fa fa-edit"></i>
                                        <span> Editar</span>
                                    </a>
                                    <?php if ($siniestro_form["tipo_siniestro_id"] === 0) : ?>
                                        <i class="nav-link-icon fa fa-edit"></i>
                                        <span> Inicial</span>
                                    <?php else : ?>
                                        <i class="nav-link-icon fa fa-edit"></i>
                                        <span> No inicial</span>
                                    <?php endif; ?>
                                    <?php $this->load->view("pruebaView/legalT1"); ?>
                                </div>
                            </div>
                            <!-- End Dropdown -->
                        </div>
                    </div>
                </div>
                <!-- End Header -->
                <form id="form-body" name="form-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs nav-justified" id="general" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#datos-generales" role="tab" aria-controls="datos-generales" aria-selected="true">Datos Generales</a>
                                    </li>
                                    <?php if ($siniestro_form["tipo_siniestro_id"] != 0) : ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#datos-legal" role="tab" aria-controls="datos-legal" aria-selected="false">Legal</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#datos-reparacion" role="tab" aria-controls="datos-reparacion" aria-selected="false">Reparación</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#datos-perdida-total" role="tab" aria-controls="datos-perdida-total" aria-selected="false">Perdida Total</a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                                <div class="tab-content" id="generalTabContent">
                                    <div class="tab-pane fade active show in" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                                        <form class="mt-3">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="no-show">Cliente</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm siniestro-p" id="cliente" name="cliente" placeholder="Cliente">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="fa fa-search"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="no-show">Vendedor</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm siniestro-p" placeholder="Vendedor" id="vendedor" name="vendedor">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="fa fa-search"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label class="no-show">Póliza</label>
                                                        <input type="text" class="form-control form-control-sm siniestro-p" placeholder="Póliza" id="poliza" name="poliza">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label class="no-show">Inciso</label>
                                                        <input type="text" class="form-control form-control-sm siniestro-p" placeholder="Inciso" id="inciso" name="inciso">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="no-show">Compañia</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm siniestro-p" placeholder="Compañia" id="compania" name="compania">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="fa fa-search"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <div class="custom-date no-show">
                                                            <label>Desde</label>
                                                            <input type="date" class="form-control form-control-sm siniestro-p" id="f_inicio" name="f_inicio">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <div class="custom-date no-show">
                                                            <label>Hasta</label>
                                                            <input type="date" class="form-control form-control-sm siniestro-p" id="f_fin" name="f_fin">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="no-show">Clave</label>
                                                        <input type="password" class="form-control form-control-sm siniestro-p" placeholder="Clave" id="clave" name="clave">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-12 mb-2 mb-sm-0">
                                                            <nav aria-label="breadcrumb">
                                                                <ol class="breadcrumb breadcrumb-no-gutter">
                                                                    <li class="breadcrumb-item active" aria-current="page">Detalle del siniestro</li>
                                                                </ol>
                                                            </nav>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label class="no-show">Número de reporte</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Número de reporte" id="num_reporte" name="num_reporte">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label class="no-show">Número de siniestro</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Número de siniestro" id="num_siniestro" name="num_siniestro">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label class="no-show">Estatus</label>
                                                                <select class="custom-select custom-select-sm siniestro-f" id="estatus" name="estatus">
                                                                    <option>Selecciona el estatus</option>
                                                                    <option>Activo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label class="no-show">Estado</label>
                                                                <select class="custom-select custom-select-sm siniestro-f" id="estado" name="estado">
                                                                    <option>Seleccione el estado</option>
                                                                    <option value="tipo1">Seleccione 1</option>
                                                                    <option value="tipo2">Seleccione 2</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label class="no-show">Ciudad</label>
                                                                <select class="custom-select custom-select-sm siniestro-f" id="ciudad" name="ciudad">
                                                                    <option>Seleccione la ciudad</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label class="no-show">Estatus</label>
                                                                <select class="custom-select custom-select-sm siniestro-f" id="estatus_t" name="estatus_t">
                                                                    <option value="">Seleccione el estatus</option>
                                                                    <option>Activo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label class="no-show">Económico</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Económico" id="economico" name="economico">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label class="no-show">Marca</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Marca" id="marca" name="marca">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label class="no-show">Modelo</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Modelo" id="modelo" name="modelo">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label class="no-show">Versión</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Versión" id="version" name="version">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label class="no-show">Año</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Año" id="ano" name="ano">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label class="no-show">Serie</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Serie" id="serie" name="serie">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label class="no-show">Uso</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Uso" id="uso" name="uso">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label class="no-show">Tipo siniestro</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Tipo siniestro" id="tipo_siniestro_id" name="tipo_siniestro_id">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label class="no-show">Causa siniestro</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Causa siniestro" id="causa_siniestro_id" name="causa_siniestro_id">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label class="no-show">Responsabilidad</label>
                                                                <input type="text" class="form-control form-control-sm siniestro-f" placeholder="Responsabilidad" id="responsabilidad" name="responsabilidad">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label class="no-show">Recuperación</label>
                                                                <input type="password" class="form-control form-control-sm siniestro-f" placeholder="Recuperación" id="recuperacion" name="recuperacion">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-12 mb-2 mb-sm-0">
                                                                    <nav aria-label="breadcrumb">
                                                                        <ol class="breadcrumb breadcrumb-no-gutter">
                                                                            <li class="breadcrumb-item active" aria-current="page">Reservas</li>
                                                                        </ol>
                                                                    </nav>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="no-show">Daño Mat</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-dollar"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" class="form-control form-control-sm siniestro-r" placeholder="Daño material" id="dano_material" name="dano_material">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="no-show">Robo</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-dollar"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" class="form-control form-control-sm siniestro-r" placeholder="Robo" id="robo" name="robo">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="no-show">Resp. civil</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-dollar"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" class="form-control form-control-sm siniestro-r" placeholder="Resp. civil" id="resp_civil" name="resp_civil">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="no-show">Gtos. Med.</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-dollar"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" class="form-control form-control-sm siniestro-r" placeholder="Gtos. Med" id="gastos_medicos" name="gastos_medicos">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-12 mb-2 mb-sm-0">
                                                                    <nav aria-label="breadcrumb">
                                                                        <ol class="breadcrumb breadcrumb-no-gutter">
                                                                            <li class="breadcrumb-item active" aria-current="page">Registro de fechas</li>
                                                                        </ol>
                                                                    </nav>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <div class="custom-date-2 no-show">
                                                                            <label>Fecha reporte</label>
                                                                            <input type="date" class="form-control form-control-sm siniestro-f" id="fecha_reporte" name="fecha_reporte">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <div class="custom-date-2 no-show">
                                                                            <label>Fecha siniestro</label>
                                                                            <input type="date" class="form-control form-control-sm siniestro-f" id="fecha_siniestro" name="fecha_siniestro">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <div class="custom-date-2 no-show">
                                                                            <label>Fecha traslado</label>
                                                                            <input type="date" class="form-control form-control-sm siniestro-f" id="fecha_traslado" name="fecha_traslado">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <div class="custom-date-2 no-show">
                                                                            <label>Fecha de valuación</label>
                                                                            <input type="date" class="form-control form-control-sm siniestro-f" id="fecha_valuacion" name="fecha_valuacion">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <div class="custom-date-2 no-show">
                                                                            <label>Fecha de Terminacion</label>
                                                                            <input type="date" class="form-control form-control-sm siniestro-f" id="fecha_terminacion" name="fecha_terminacion">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <ul class="nav mb-3" id="pills-tab" role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Registro de valores</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Estatus deducible</a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content" id="pills-tabContent">
                                                                <div class="tab-pane fade active show in" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-md-8">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label class="no-show">Suma asegurada</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" class="form-control form-control-sm siniestro-r" placeholder="Suma asegurada" id="suma_asegurada" name="suma_asegurada">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label class="no-show">Reclamado</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" class="form-control form-control-sm siniestro-r" placeholder="Reclamado" id="reclamo" name="reclamo">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label class="no-show">Deducible</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" class="form-control form-control-sm siniestro-r" placeholder="Deducible" id="deducible" name="deducible">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label class="no-show">Prima pendiente</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" class="form-control form-control-sm siniestro-r" placeholder="Prima pendiente" id="prima_pendiente" name="prima_pendiente">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label class="no-show">Pagado</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" class="form-control form-control-sm siniestro-r" placeholder="Pagado" id="pagado" name="pagado">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-4">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input siniestro-r" type="checkbox" id="factura" name="factura" required>
                                                                                            <label class="form-check-label" for="invalidCheck2">
                                                                                                Factura
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input siniestro-r" type="checkbox" id="venta_comercial" name="venta_comercial" required>
                                                                                            <label class="form-check-label" for="invalidCheck2">
                                                                                                V. Comercial
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label class="no-show">Deducible administrativo</label>
                                                                                        <input type="text" class="form-control form-control-sm siniestro-d" placeholder="Deducible administrativo" id="deducible_administrativo" name="deducible_administrativo">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <div class="custom-date no-show">
                                                                                            <label>Fecha solicitud</label>
                                                                                            <input type="date" class="form-control form-control-sm siniestro-d" id="fecha_solicitud" name="fecha_solicitud">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label class="no-show">Demérito</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" class="form-control form-control-sm siniestro-d" placeholder="Demérito" id="demerito" name="demerito">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label class="no-show">Concepto demérito</label>
                                                                                        <input type="text" class="form-control form-control-sm siniestro-d" placeholder="Concepto demérito" id="concepto_demerito" name="concepto_demerito">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <div class="custom-date no-show">
                                                                                            <label>Fecha de pago</label>
                                                                                            <input type="date" class="form-control form-control-sm siniestro-d" id="fecha_pago_deducible" name="fecha_pago_deducible">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <?php if ($siniestro_form["tipo_siniestro_id"] != 0) : ?>
                                        <div class="tab-pane fade" id="datos-legal" role="tabpanel" aria-labelledby="datos-legal-tab">
                                            <form class="mt-3">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <fieldset class="border p-2">
                                                            <legend class="float-none w-auto p-2">Datos del abogado</legend>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="no-show">Nombre del Abogado</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Nombre del Abogado" id="nombre_abogado" name="nombre_abogado">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-search"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="no-show">Correo del abogado</label>
                                                                    <input type="email" class="form-control form-control-sm siniestro-l" placeholder="Correo del abogado" id="correo_abogado" name="correo_abogado">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="no-show">Teléfono del abogado</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Teléfono del abogado" id="telefono_abogado" name="telefono_abogado">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-search"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <fieldset class="border p-2">
                                                            <legend class="float-none w-auto p-2">Datos del apoderado</legend>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="no-show">Nombre del apoderado</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Nombre del apoderado" id="nombre_apoderado" name="nombre_apoderado">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-search"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="no-show">Correo del apoderado</label>
                                                                    <input type="email" class="form-control form-control-sm siniestro-l" placeholder="Correo del apoderado" id="correo_apoderado" name="correo_apoderado">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="no-show">Teléfono del apoderado</label>
                                                                    <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Teléfono del apoderado" id="telefono_apoderado" name="telefono_apoderado">
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-12 mb-2 mb-sm-0">
                                                                <nav aria-label="breadcrumb">
                                                                    <ol class="breadcrumb breadcrumb-no-gutter">
                                                                        <li class="breadcrumb-item active" aria-current="page">Detalle</li>
                                                                    </ol>
                                                                </nav>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label class="no-show">Ubicación fisica de la unidad</label>
                                                                    <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Ubicación fisica de la unidad" id="ubicacion_unidad" name="ubicacion_unidad">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label class="no-show">Autoridad</label>
                                                                    <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Autoridad" id="autoridad" name="autoridad">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="control-group" id="fields">
                                                                    <label class="control-label" for="field1">
                                                                        Documento
                                                                    </label>
                                                                    <div class="controls">
                                                                        <div class="entry input-group upload-input-group">
                                                                            <input class="form-control" name="fields[]" type="file">
                                                                            <div class="input-group-append">
                                                                                <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" type="button">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </button>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-sm btn-shadow btn-primary mt-3">
                                                                        <i class="fa fa-upload"> </i>
                                                                        Subir
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mt-5">
                                                                <div class="form-group">
                                                                    <label class="no-show">Seguimiento</label>
                                                                    <textarea rows="5" class="form-control form-control-sm" placeholder="Seguimiento"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-12 mb-2 mb-sm-0">
                                                                        <nav aria-label="breadcrumb">
                                                                            <ol class="breadcrumb breadcrumb-no-gutter">
                                                                                <li class="breadcrumb-item active" aria-current="page">Registro de fechas</li>
                                                                            </ol>
                                                                        </nav>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha reporte</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_reporte_legal" name="fecha_reporte_legal">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha siniestro</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_siniestro_legal" name="fecha_siniestro_legal">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha traslado</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_traslado_legal" name="fecha_traslado_legal">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha de valuación</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_valuacion_legal" name="fecha_valuacion_legal">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha de Terminación</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_terminacion_legal" name="fecha_terminacion_legal">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="no-show">Estatus</label>
                                                                            <label class="p-1 mb-1 bg-primary text-white">RECUPERADO</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="datos-reparacion" role="tabpanel" aria-labelledby="datos-reparacion-tab">
                                            <form class="mt-3">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <fieldset class="border p-2">
                                                            <legend class="float-none w-auto p-2">Datos del taller</legend>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="no-show">Nombre</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Nombre" id="nombre_taller" name="nombre_taller">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-search"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-5">
                                                                <div class="form-group">
                                                                    <label class="no-show">Ciudad de reparación</label>
                                                                    <input type="email" class="form-control form-control-sm siniestro-l" placeholder="Ciudad de reparación" id="ciudad_reparacion" name="ciudad_reparacion">
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <fieldset class="border p-2">
                                                            <legend class="float-none w-auto p-2">Complemento</legend>
                                                            <div class="col-sm-12">
                                                                <div class="form-check mt-2">
                                                                    <input class="form-check-input siniestro-l" type="radio" value="taller" id="taller_check" name="taller_check">
                                                                    <label class="form-check-label">
                                                                        Taller
                                                                    </label>
                                                                </div>
                                                                <div class="form-check mt-2">
                                                                    <input class="form-check-input siniestro-l" type="radio" value="agencia" id="agencia_check" name="agencia_check">
                                                                    <label class="form-check-label">
                                                                        Agencia
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mt-3">
                                                                <div class="form-group">
                                                                    <label class="no-show">Marca</label>
                                                                    <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Marca" id="marca_reparacion" name="marca_reparacion">
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <ul class="nav mb-3" id="pills-tab" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" id="pills-valuacion-tab" data-toggle="pill" href="#pills-valuacion" role="tab" aria-controls="pills-valuacion" aria-selected="true">Valuación</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" id="pills-refacciones-tab" data-toggle="pill" href="#pills-refacciones" role="tab" aria-controls="pills-refacciones" aria-selected="false">Refacciones en BO</a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content" id="pills-tabContent">
                                                                    <div class="tab-pane fade active show in" id="pills-valuacion" role="tabpanel" aria-labelledby="pills-valuacion-tab">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="no-show">Monto de valuación</label>
                                                                                    <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Monto de valuación" id="monto_valuacion" name="monto_valuacion">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="no-show">Porcentaje de daño</label>
                                                                                    <input type="text" class="form-control form-control-sm siniestro-l" placeholder="Porcentaje de daño" id="porcentaje_dano" name="porcentaje_dano">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 mt-5">
                                                                                <div class="form-group">
                                                                                    <label class="no-show">Resultado de la valuación</label>
                                                                                    <textarea rows="5" class="form-control form-control-sm siniestro-l" placeholder="Resultado de la valuación" id="resultado_valuacion" name="resultado_valuacion"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="pills-refacciones" role="tabpanel" aria-labelledby="pills-refacciones-tab">
                                                                        <div class="row">
                                                                            <div class="col-12 mb-3">
                                                                                <a href="" class="btn btn-sm btn-shadow btn-primary ">
                                                                                    <i class="fa fa-plus"></i> Nuevo
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Num de refaccion</th>
                                                                                            <th>Pieza</th>
                                                                                            <th>Fecha recibida</th>
                                                                                            <th>Opciones</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <input type="text" class="form-control form-control-sm">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" class="form-control form-control-sm">
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="date" class="form-control form-control-sm">
                                                                                            </td>
                                                                                            <td>
                                                                                                <div class="dropdown float-right">
                                                                                                    <button type="button" class="btn btn-shadow btn-white btn-sm dropdown-toggle w-100" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                        <i class="bi-download me-2"></i> Acciones
                                                                                                    </button>
                                                                                                    <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="dropdownMenuButton">
                                                                                                        <a class="dropdown-item" href="#">Guardar</a>
                                                                                                        <a class="dropdown-item" href="#">Editar</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="control-group" id="fields">
                                                                    <label class="control-label" for="field1">
                                                                        Documento
                                                                    </label>
                                                                    <div class="controls">
                                                                        <div class="entry input-group upload-input-group">
                                                                            <input class="form-control" name="fields[]" type="file">
                                                                            <div class="input-group-append">
                                                                                <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" type="button">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </button>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-sm btn-shadow btn-primary mt-3">
                                                                        <i class="fa fa-upload"> </i>
                                                                        Subir
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mt-5">
                                                                <div class="form-group">
                                                                    <label class="no-show">Seguimiento</label>
                                                                    <textarea rows="5" class="form-control form-control-sm siniestro-l" placeholder="Seguimiento"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-12 mb-2 mb-sm-0">
                                                                        <nav aria-label="breadcrumb">
                                                                            <ol class="breadcrumb breadcrumb-no-gutter">
                                                                                <li class="breadcrumb-item active" aria-current="page">Registro de fechas</li>
                                                                            </ol>
                                                                        </nav>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label class="">Fecha ingreso</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_ingreso" name="fecha_ingreso">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha de refacciones</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_refacciones" name="fecha_refacciones">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha de refacciones en BO</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_refacciones_bo" name="fecha_refacciones_bo">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha de termino de la reparación</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_termino_reparacion" name="fecha_termino_reparacion">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha de entrega de la unidad</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_entrega_unidad" name="fecha_entrega_unidad">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="no-show">Estatus</label>
                                                                            <label class="p-1 mb-1 bg-primary text-white">SURTIDO DE REFACCIONES CON</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="datos-perdida-total" role="tabpanel" aria-labelledby="datos-perdida-total-tab">
                                            <form class="mt-3">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <fieldset class="border p-2">
                                                            <legend class="float-none w-auto p-2">Seguimiento</legend>
                                                            <div class="col-sm-12">
                                                                <div class="control-group" id="fields">
                                                                    <label class="control-label" for="field1">
                                                                        Documento
                                                                    </label>
                                                                    <div class="controls">
                                                                        <div class="entry input-group upload-input-group">
                                                                            <input class="form-control" name="fields[]" type="file">
                                                                            <div class="input-group-append">
                                                                                <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" type="button">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </button>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-sm btn-shadow btn-primary mt-3">
                                                                        <i class="fa fa-upload"> </i>
                                                                        Subir
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mt-5">
                                                                <div class="form-group">
                                                                    <label class="no-show">Seguimiento</label>
                                                                    <textarea rows="5" class="form-control form-control-sm siniestro-l" placeholder="Seguimiento" id="seguimiento" name="seguimiento"></textarea>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-12 mb-2 mb-sm-0">
                                                                        <nav aria-label="breadcrumb">
                                                                            <ol class="breadcrumb breadcrumb-no-gutter">
                                                                                <li class="breadcrumb-item active" aria-current="page">Registro de fechas</li>
                                                                            </ol>
                                                                        </nav>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label class="">Fecha de notificación</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_notificacion" name="fecha_notificacion">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha de documentación</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_documentacion" name="fecha_documentacion">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha de pago</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_pago" name="fecha_pago">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <div class="custom-date-2 no-show">
                                                                                <label>Fecha de entrega de BP</label>
                                                                                <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_entrega_bp" name="fecha_entrega_bp">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="no-show">Estatus</label>
                                                                            <label class="p-1 mb-1 bg-primary text-white">PAGADO</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-12 mb-2 mb-sm-0">
                                                                <nav aria-label="breadcrumb">
                                                                    <ol class="breadcrumb breadcrumb-no-gutter">
                                                                        <li class="breadcrumb-item active" aria-current="page">Penalización</li>
                                                                    </ol>
                                                                </nav>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label class="no-show">Días por penalización</label>
                                                                    <input type="number" class="form-control form-control-sm siniestro-l" placeholder="Días por penalización" id="dias_penalizacion" name="dias_penalizacion">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label class="no-show">Monto por día</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-dollar"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="number" class="form-control form-control-sm siniestro-l" placeholder="Monto por día" id="monto_dia" name="monto_dia">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label class="no-show">Total de la penalización</label>
                                                                    <input type="number" class="form-control form-control-sm siniestro-l" placeholder="Total de la penalización" id="total_penalizacion" name="total_penalizacion">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <div class="custom-date no-show">
                                                                        <label>Fecha de pago</label>
                                                                        <input type="date" class="form-control form-control-sm siniestro-l" id="fecha_pago_penalizacion" name="fecha_pago_penalizacion">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>