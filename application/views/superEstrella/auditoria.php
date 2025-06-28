<div class="panel panel-default" style="margin-bottom: 80px;">        
    <div class="panel-body">
        <div class="col-md-12" style="margin-bottom: 50px;">
            <h5 class="titleSection">Auditoría
                <button class="btn-view-cont" data-toggle="collapse" href="#segAudCond" aria-expanded="true"><i class="fa fa-info-circle" title="Ver Información"></i>
                </button>
            </h5>
            <hr class="title-hr">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12 collapse pd-top pd-bottom" id="segAudCond">
                    <div class="alert alert-primary" role="alert" style="margin: 0px;">
                        <h4><i class="fas fa-exclamation-circle"></i> Condiciones</h4>
                        <ul>
                            <li>
                                <p class="p-list-alert">Se tiene que auditar un procedimiento completo del puesto en formato ISO, si no coincide aunque sea en un detalle no se otorgan puntos parciales; <strong>todo bien</strong> "15", si <strong>no todo bien</strong> "0".</p>
                            </li>
                            <li>
                                <p class="p-list-alert">El rol de auditoría se hace trimestralmente.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">La auditoría no requiere de ningún aviso previo o de cita, por lo que el colaborador debe de atender con prioridad al auditor.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12 column-flex-bottom">
                <div class="pd-side">
                    <label class="form-check-label">Año:</label>
                    <select class="form-control width-ajust" id="searchYearAudit">
                        <?=$years?>
                    </select>
                </div>
                <div class="pd-side">
                    <label class="form-check-label">Trimestre:</label>
                    <select class="form-control width-ajust" id="searchQuarterlyAudit">
                        <?=$quarterly?>
                    </select>
                </div>
                <div class="pd-side">
                    <label class="form-check-label">Área:</label>
                    <select class="form-control width-ajust" id="searchAreaAudit">
                        <?= printArea($puestos);?>
                    </select>
                </div>
                <div class="pd-side">
                    <button class="btn btn-primary" id="btnSearchAudit" onclick="getTableAudit()">Generar</button>
                </div>
            </div>
            <div class="col-md-12 pd-items-table">
                <div class="col-md-12 column-flex-end pd-right">
                    <input type="text" class="form-control" placeholder="Filtrar" id="filterTableOpAudit" style="width: 30%;">
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 container-table">
                    <table class="table table-striped" id="tableOpAudit">
                        <thead class="table-thead">
                            <tr class="table-tr">
                                <th>N°</th>
                                <th>Nombre Completo</th>
                                <th>Estatus</th>
                                <th>Puntaje</th>
                                <th>Trimestre</th>
                                <th>Procedimientos</th>
                                <th>Seguimiento</th>
                                <th>Guardar</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTableOpAudit"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h5 class="titleSection">Total de Resultados de la Auditoría</h5>
            <hr class="title-hr">
            <div class="col-md-12 column-flex-bottom mg-bottom">
                <div class="pd-side">
                    <label class="form-check-label">Año:</label>
                    <select class="form-control width-ajust" id="searchRsYearAudit">
                        <?=$years?>
                    </select>
                </div>
                <div class="pd-side">
                    <label class="form-check-label">Trimestre:</label>
                    <select class="form-control width-ajust" id="searchRsQuarterlyAudit">
                        <?=$quarterly?>
                    </select>
                </div>
                <div class="pd-side">
                    <button class="btn btn-primary" id="btnSearchRsAudit" onclick="getTableRsAudit()">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 container-table-bootstrap" id="contTableRsAudit"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getTableAudit() {        
        const year = document.getElementById('searchYearAudit').value;
        const quarterly = document.getElementById('searchQuarterlyAudit').value;
        const area = document.getElementById('searchAreaAudit').value;
        $('#btnSearchAudit').prop('disabled',true);

        $.ajax({
            type: "GET",
            url: `${baseUrl}/getSearchEmployeeAudit`,
            data: {
                yr: year,
                qr: quarterly,
                ar: area
            },
            beforeSend: (load) => {
                $('#bodyTableOpAudit').html(`
                    <tr>
                        <td colspan="7">
                            <div class="container-spinner-content-loading">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                                <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                            </div>
                        </td>
                    </tr>
                `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                let mp = r['employees'];
                let au = r['audit'];
                var trtd = ``;
                var trtdR = ``;
                //$('#btnSaveNote').html("Guardar");
                //swal("¡Guardado!", "Nota guardada con éxito.", "success");
                if (mp != 0) {
                    for (const e in mp) {
                        const idPersona = mp[e].idPersona;
                        const name = getTextValue(mp[e].apellidoPaterno) + " " + getTextValue(mp[e].apellidoMaterno) + " " + getTextValue(mp[e].nombres);
                        var auditoria = 0;
                        var status = "Sin resolver";
                        var textStatus = "label-wine";
                        var score = "Sin resultados";
                        var procedure = getOptionYesNo("");
                        var tracking = getOptionYesNo("");
                        var update = "no";
                        var textBtn = "Guardar";
                        var classBtn = "btn-primary";
                        var employees = `<td><a class="btn btn-primary" href="#SectionEmployeeAud" data-name="${name}" data-employee="${idPersona}" data-employment="${mp[e].idPuesto}" onclick="seeEmployeesAud(this,'${year}','${quarterly}')"><i class="far fa-eye"></i> Ver</a></td>`;
                        if (au != 0) {
                            for (const a in au) {
                                if (idPersona == au[a].idPersona && quarterly == au[a].trimestre) {
                                    auditoria = au[a].id;
                                    status = "Hecho";
                                    textStatus = "label-success";
                                    score = au[a].calificacion;
                                    procedure = getOptionYesNo(au[a].procedimiento);
                                    tracking = getOptionYesNo(au[a].seguimiento);
                                    update = "si";
                                    textBtn = "Actualizar";
                                    classBtn = "btn-success";
                                }
                            }
                        }

                        trtd += `
                            <tr class="show-audit" data-puesto="${mp[e].idPuesto}">
                                <td>${Number(e) + 1}</td>
                                <td>${name}</td>
                                <td><span class="label ${textStatus}" id="estatus${idPersona}">${status}</span></td>
                                <td><strong id="puntaje${idPersona}">${score}</strong></td>
                                <td>
                                    <select class="form-control width-ajust" id="trimestre${idPersona}" disabled>
                                        ${getQuarterly(quarterly)}
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control width-ajust" id="procedimientos${idPersona}">${procedure}</select>
                                </td>
                                <td>
                                    <select class="form-control width-ajust" id="seguimiento${idPersona}">${tracking}</select>
                                </td>
                                <td>
                                    <button class="btn ${classBtn}" data-auditoria="${auditoria}" data-employee="${idPersona}" data-update="${update}" id="btnAud${idPersona}" onclick="saveAudit(this)">${textBtn}</button>
                                </td>
                            </tr>
                        `;
                    }
                }
                else {
                    trtd = `<tr><td colspan="7"><center><strong>Sin resultados</strong><center></td></tr>`;
                }
                $('#bodyTableOpAudit').html(trtd);
                $('#btnSearchAudit').prop('disabled',false);
            },
            error: (error) => {
                console.log(error);
                $('#bodyTableOpAudit').html(`<tr><td colspan="7"><center><strong>Sin resultados</strong><center></td></tr>`);
                $('#btnSearchAudit').prop('disabled',false);
            }
        })
    }
    
    function getTableRsAudit() {//Modificado [2024-04-22]
        const year = document.getElementById('searchRsYearAudit').value;
        const quarter = document.getElementById('searchRsQuarterlyAudit').value;
        //console.log("Año: " + year);
        $('#btnSearchRsAudit').prop('disabled',true);

        $.ajax({
            type: "GET",
            url: `${baseUrl}/getResultAudit`,
            data: {
                yr: year,
                qr: quarter
            },
            beforeSend: (load) => {
                $('#contTableRsAudit').css('height','450px');
                $('#contTableRsAudit').html(`
                    <div class="container-spinner-content-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                let json = [];
                var trtd = ``;
                var thead = `
                    <tr class="table-tr"><th colspan="10" class="title-table">Auditoría</th></tr>
                    <tr class="table-tr">
                        <th>N°</th>
                        <th>Nombre Completo</th>
                        <th>Área</th>
                        <th>Puesto</th>
                        <th>Correo</th>
                        <th>Periodo</th>
                        <th>Procedimientos</th>
                        <th>Seguimiento</th>
                        <th>Puntos</th>
                        <th>Hecho el</th>
                    </tr>
                `;
                if (r != 0) {
                    for (const a in r) {
                        let add = {};
                        const idPersona = r[a].idPersona;
                        add[0] = Number(a) + 1;
                        add[1] = getTextValue(r[a].apellidoPaterno) + " " + getTextValue(r[a].apellidoMaterno) + " " + getTextValue(r[a].nombres);
                        add[2] = getTextValue(r[a].colaboradorArea);
                        add[3] = r[a].personaPuesto;
                        add[4] = r[a].email;
                        add[5] = r[a].trimestre;
                        add[6] = r[a].procedimiento.toUpperCase();
                        add[7] = r[a].seguimiento.toUpperCase();
                        add[8] = `<strong>${r[a].calificacion}</strong>`;
                        add[9] = getDateFormat(r[a].registro,2);
                        json.push(add);
                    }
                }
                else {
                    trtd = `<tr><td colspan="9"><center><strong>Sin resultados</strong><center></td></tr>`;
                }
                getTableBootstrap("contTableRsAudit","tableRsAudit",thead,json,`Auditoria <?=date('Y-m-d H:i:s')?>`);
                $('#btnSearchRsAudit').prop('disabled',false);
            },
            error: (error) => {
                console.log(error);
                $('#btnSearchRsAudit').prop('disabled',false);
                $('#contTableRsAudit').html(`<div class="col-md-12"><h5 class="title-table"><strong>Inténtelo nuevamente.</strong></h5></div>`);
            }
        })
    }

    function saveAudit(obj) {
        const aud = $(obj).data('auditoria');
        const id = $(obj).data('employee');
        const update = $(obj).data('update');
        const quarterly = document.getElementById('trimestre'+id).value;
        const procedure = document.getElementById('procedimientos'+id).value;
        const seguimiento = document.getElementById('seguimiento'+id).value;
        console.log("ID: "+aud+", Actualizar: "+update+", Empleado: "+id+", Trimestre: "+quarterly+", Procedimientos: "+procedure+", Seguimiento: "+seguimiento);
        $.ajax({
            type: "POST",
            url: `${baseUrl}/saveEmployeeAudit`,
            data: {
                id: aud,
                em: id,
                qr: quarterly,
                pr: procedure,
                sg: seguimiento,
                up: update
            },
            beforeSend: (load) => {
                $('#btnAud'+id).html(`
                    <div class="container-spinner-btn-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                let au = r['audit'];
                $('#btnAud'+id).html("Actualizar");
                if ($('#btnAud'+id).hasClass('btn-primary')) {
                    $('#btnAud'+id).removeClass('btn-primary');
                    $('#btnAud'+id).addClass('btn-success');
                }
                $('#estatus'+id).html("Hecho");
                if ($('#estatus'+id).hasClass('label-wine')) {
                    $('#estatus'+id).removeClass('label-wine');
                    $('#estatus'+id).addClass('label-success');
                }
                for (const a in au) {
                    $('#puntaje'+id).html(au[a].calificacion);
                    $(obj).attr('data-auditoria',au[a].id);
                    $(obj).attr('data-update','si');
                }
                getTableRsAudit();
                //swal("¡Guardado!", "Nota guardada con éxito.", "success");
            },
            error: (error) => {
                console.log(error);
                $('#btnAud'+id).html("Guardar");
                //swal("¡Vaya!", "Ha ocurrido un conflicto al intentar guardar.", "error");
            }
        })
    }
</script>