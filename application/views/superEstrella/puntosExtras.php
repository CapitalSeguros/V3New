<div class="panel panel-default" style="margin-bottom: 80px;">        
    <div class="panel-body">
        <div class="col-md-12 pd-top pd-bottom">
            <div class="alert alert-wine" role="alert" style="margin: 0px;">
                <h4><i class="fas fa-exclamation-circle"></i> Reglas</h4>
                    <p class="p-list-alert">Estos puntos juegan como adicionales a la puntuación ordinaria esperada. No servirán para alcanzar el <strong>Bono Trimestral</strong> ni el <strong>Colaborador del Trimestre</strong> si no tiene la puntuacion base adecuada de los 100 puntos, es decir, no servirán para compensar alguna falla en los puntos base, si no para rebasar el 100%. El que alcance la mayoría de puntos será nombrado <strong>Colaborador del Trimestre</strong> y/o al <strong>Colaborador del Año</strong>.</p>
            </div>
        </div>
        <div class="col-md-12"><hr class="history-hr"></div>
        <!-- <div class="col-md-12" style="margin-bottom: 25px;">
            <h5 class="titleSection">AFH
                <button class="btn-view-cont" data-toggle="collapse" href="#alertPEAFH" aria-expanded="true"><i class="fa fa-info-circle" title="Ver Información"></i>
                </button>
            </h5>
            <hr class="title-hr">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12 collapse pd-top pd-bottom" id="alertPEAFH">
                    <div class="alert alert-primary" role="alert" style="margin: 0px;">
                        <h4><i class="fas fa-exclamation-circle"></i> Condiciones</h4>
                        <p>El apoyo fuera de horario laboral te otorga puntos:</p>
                        <ul>
                            <li>
                                <p class="p-list-alert">Si el apoyo se realizó durante el trimestre por lo menos con una actividad por mes (osea 3 al trimestre) se otorgarán 5 puntos.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Si son más de 3 en el trimestre se otorgarán los puntos totales de 25.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Si se realizan 1 o 2 actividades no se otorgarán puntos.</p>
                            </li>
                        </ul>
                        <p>Los ejecutivos con factultades de cotizar y emitir en sus funciones cotidianas son los únicos puestos que podrán realizar este tipo de actividades, el resto de los puestos podrán realizar actividades extra de endosos, cobranza o captura.</p>
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
                    <input type="text" class="form-control" placeholder="Filtrar" id="filterTableOpAFH" style="width: 30%;">
                </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 25px;">
                <div class="col-md-12 container-table">
                    <table class="table table-striped" id="tableOpAFH">
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
                        <tbody id="bodyTableOpAFH"></tbody>
                    </table>
                </div>
            </div>
        </div> -->
        <div class="col-md-12" style="margin-bottom: 25px;">
            <h5 class="titleSection">Capacitaciones
                <button class="btn-view-cont" data-toggle="collapse" href="#alertTraining" aria-expanded="true"><i class="fa fa-info-circle" title="Ver Información"></i>
                </button>
            </h5>
            <hr class="table-hr">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12 collapse pd-top pd-bottom" id="alertTraining">
                    <div class="alert alert-primary" role="alert" style="margin: 0px;">
                        <h4><i class="fas fa-exclamation-circle"></i> Condiciones</h4>
                        <p>Estos puntos se dan solo si el colaborador toma por su cuenta capacitaciones adicionales a las que la empresa otorga, puede ser de desarrollo personal o profesional. Se otorgará 1 punto extra por cada hora de capacitación, con evidencias (Fotos, la invitación o convocatoria o ficha de registro) y esté debidamente registrado en el sistema.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 column-flex-bottom pd-items-table">
                <div class="pd-side">
                    <label class="form-check-label">Año:</label>
                    <select class="form-control width-ajust" id="searchYearTraining">
                        <?=$years?>
                    </select>
                </div>
                <div class="pd-side">
                    <label class="form-check-label">Área:</label>
                    <select class="form-control width-ajust" id="searchAreaTraining">
                        <?= printArea($puestos); ?>
                    </select>
                </div>
                <div class="pd-side">
                    <button class="btn btn-primary" id="btnSearchOpTraining" onclick="getTableTraining()">Generar</button>
                </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 25px;">
                <div class="col-md-12 container-table-bootstrap" id="contTableOpTraining"></div>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 25px;">
            <h5 class="titleSection">Vacaciones
                <button class="btn-view-cont" data-toggle="collapse" href="#alertVacations" aria-expanded="true"><i class="fa fa-info-circle" title="Ver Información"></i>
                </button>
            </h5>
            <hr class="table-hr">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12 collapse pd-top pd-bottom" id="alertVacations">
                    <div class="alert alert-primary" role="alert" style="margin: 0px;">
                        <h4><i class="fas fa-exclamation-circle"></i> Condiciones</h4>
                        <p>Estos puntos se otorgan una vez al año y al cumplir aniversario laboral, por lo que se requiere que se cumpla con lo siguiente:</p>
                        <ul>
                            <li>
                                <p class="p-list-alert">Si el colaborador programa y solicita de manera anticipada el 50% de sus vacaciones se otorgan 6 puntos.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Si logra organizar y registrar el  50% + 1 día, se otorgarán los 8 puntos.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Cualquier otro día adicional registrado genarará 1 punto adicional al máximo de los 8 que otorga este parámetro.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Si las vacaciones son en semana santa o en la semana entre el 24 de diciembre y el 31 de diciembre se le otorgarán 5 puntos adicionales.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12 column-flex-bottom">
                <div class="pd-side">
                    <label class="form-check-label">Año:</label>
                    <select class="form-control width-ajust" id="searchYearVacations">
                        <?=$years?>
                    </select>
                </div>
                <div class="pd-side">
                    <label class="form-check-label">Área:</label>
                    <select class="form-control width-ajust" id="searchAreaVacations">
                        <?= printArea($puestos); ?>
                    </select>
                </div>
                <div class="pd-side">
                    <button class="btn btn-primary" id="btnSearchVacations" onclick="getTableVacations()">Generar</button>
                </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12 collapse pd-top pd-bottom" id="pendiente_vac">
                    <div class="alert alert-warning" role="alert" style="margin: 0px;">
                        <h4><i class="fas fa-exclamation-circle"></i> Pendientes</h4>
                        <p>Por el momento el puntaje final de vacaciones está incompleto, aún no se puede calcular al 100% debido a las fechas de la semana santa. Se necesita un registro que indiquen las fechas de la semana santa para poder inplementarlo en el cálculo de los puntos.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 pd-items-table">
                <div class="col-md-12 column-flex-end pd-right">                    
                    <button class="btn-view-cont mg-right" data-toggle="collapse" href="#pendiente_vac" aria-expanded="true">
                        <i class="fas fa-exclamation-circle"></i>
                    </button>
                    <input type="text" class="form-control" placeholder="Filtrar" id="filterTableOpVacations" style="width: 30%;">
                </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 25px;">
                <div class="col-md-12 container-table">
                    <table class="table table-striped" id="tableOpVacations">
                        <thead class="table-thead">
                            <tr class="table-tr">
                                <th>N°</th>
                                <th>Nombre Completo</th>
                                <th>Puesto</th>
                                <th>Área</th>
                                <th>Correo</th>
                                <th>Aniversario</th>
                                <th>Estatus Reinicio</th>
                                <th>Solicitudes</th>
                                <th>Pendientes</th>
                                <th>Aceptadas</th>
                                <th>Rechazadas</th>
                                <th>Puntos</th>
                                <th>Puntos por Anticipación</th>
                                <th>Puntos por Semana Santa</th>
                                <th>Puntos por Diciembre</th>
                                <th>Puntaje Final</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTableOpVacations"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getTableTraining() {
        const year = document.getElementById('searchYearTraining').value;
        const area = document.getElementById('searchAreaTraining').value;
        $('#btnSearchOpTraining').prop('disabled',true);

        $.ajax({
            type: "GET",
            url: `${baseUrl}/getSearchEmployeeTraining`,
            data: {
                yr: year,
                ar: area
            },
            beforeSend: (load) => {
                $('#contTableOpTraining').css('height','450px');
                $('#contTableOpTraining').html(`
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
                let dt = r['data'];
                let em = r['training'];
                let json = [];
                var thead = `
                    <tr class="table-tr"><th colspan="12" class="title-table">Puntos Acumulados (Capacitación)</th></tr>
                    <tr class="table-tr">
                        <th>N°</th>
                        <th>Nombre Completo</th>
                        <th>Puesto</th>
                        <th>Área</th>
                        <th>Correo</th>
                        <th>Primer Trimestre</th>
                        <th>Segundo Trimestre</th>
                        <th>Tercer Trimestre</th>
                        <th>Cuarto Trimestre</th>
                        <th>Puntos Totales por Capacitaciones</th>
                        <th>Puntos por Capacitaciones Externas</th>
                        <th>Puntaje Final</th>
                    </tr>
                `;
                for (const e in em) {                    
                    let tr = em[e].eventos;
                    let ex = em[e].externos;
                    let add = {};
                    var cap = 0;
                    var capEx = 0;
                    var horas = 0;
                    var horasEx = 0;
                    var horas1 = 0;
                    var horas2 = 0;
                    var horas3 = 0;
                    var horas4 = 0;
                    for (const t in tr) {
                        if (tr[t].asistencia == "activo") {
                            cap++;
                            horas = horas + Number(tr[t].tiempo);
                            switch (tr[t].trimestre) {
                                case "Primero": horas1 = horas1 + Number(tr[t].tiempo);
                                break;
                                case "Segundo": horas2 = horas2 + Number(tr[t].tiempo);
                                break;
                                case "Tercero": horas3 = horas3 + Number(tr[t].tiempo);
                                break;
                                case "Cuarto": horas4 = horas4 + Number(tr[t].tiempo);
                                break;
                            }
                        }
                    }
                    for (const x in ex) {
                        capEx++;
                        horasEx = horasEx + Number(ex[x].duration);
                    }
                    const puntos1 = getPointsByHour(horas1);
                    const puntos2 = getPointsByHour(horas2);
                    const puntos3 = getPointsByHour(horas3);
                    const puntos4 = getPointsByHour(horas4);
                    const puntos = puntos1 + puntos2 + puntos3 + puntos4;
                    const puntosEx = getPointsByHour(horasEx);
                    const puntaje = puntos + puntosEx;

                    add[0] = Number(e) + 1;
                    add[1] = em[e].nombre;
                    add[2] = getTextValue(em[e].area);
                    add[3] = em[e].puesto;
                    add[4] = getTextValue(em[e].email);
                    add[5] = puntos1;
                    add[6] = puntos2;
                    add[7] = puntos3;
                    add[8] = puntos4;
                    add[9] = puntos;
                    add[10] = puntosEx;
                    add[11] = `<strong>${puntaje}</strong>`;
                    //add[12] = `<button class='btn btn-primary' onclick='modalTrainingDetails(${em[e].idPersona},${dt['año']})'><i class='fas fa-edit'></i> Detalles</button>`;
                    json.push(add);
                }
                getTableBootstrap("contTableOpTraining","tableOpTraining",thead,json,`PuntosExtras_Cap <?=date('Y-m-d H:i:s')?>`);
                $('#btnSearchOpTraining').prop('disabled',false);
            },
            error: (error) => {
                console.log(error);
                $('#btnSearchOpTraining').prop('disabled',false);
            }
        })
    }

    function getTableVacations() {
        const year = document.getElementById('searchYearVacations').value;
        const area = document.getElementById('searchAreaVacations').value;
        $('#btnSearchVacations').prop('disabled',true);

        $.ajax({
            type: "GET",
            url: `${baseUrl}/getSearchEmployeeVacations`,
            data: {
                yr: year,
                ar: area
            },
            beforeSend: (load) => {
                $('#bodyTableOpVacations').html(`
                    <tr>
                        <td colspan="14">
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
                console.log(r);
                let vc = r['vacations'];
                var trtd = ``;
                var date = new Date();
                var month = date.getMonth() + 1;
                if (vc != 0) {
                    for (const a in vc) {
                        let vac = vc[a].vacaciones;
                        var status = "";
                        var aceptadas = 0;
                        var rechazadas = 0;
                        var pendientes = 0;
                        var middle = (vac.length / 2).toFixed(0);
                        var v1 = 0; //Solicitud Anticipada (15 días)
                        var v2 = 0; //Solicitud Anticipada (Mayor de 15 días)
                        var p1 = 0; //Solicitud normal
                        var p2 = 0; //Solicitud en Semana Santa
                        var p3 = 0; //Solicitud en Diciembre
                        for (const b in vac) {
                            switch (vac[b].estatus) {
                                case "pendiente":
                                    pendientes++;
                                    break;
                                case "aprobado":
                                    aceptadas++;
                                    if (vac[b].solicitud_acticipada == 15) {
                                        v1++;
                                    }
                                    else if (vac[b].solicitud_acticipada > 15) {
                                        v2++;
                                    }
                                    else {
                                        p1++;
                                    }
                                    if (vac[b].vacacion_diciembre == "yes") {
                                        p3 = p3 + 5;
                                    }
                                    break;
                                case "rechazado":
                                    rechazadas++;
                                    break;
                            }
                        }
                        if (v1 == middle && middle != 0) {
                            p1 = p1 + 6;
                        }
                        else if (v2 == middle && middle != 0) {
                            p1 = p1 + 8;
                        }
                        var puntaje = p1 + p2 + p3;
                        if (vc[a].estatus_aniversario_laboral == "red") {
                            status = `<span class="label label-danger">Hoy</span>`
                        }
                        else if (vc[a].estatus_aniversario_laboral == "orange") {
                            status = `<span class="label label-warning">En ${vc[a].dias_restantes} días</span>`;
                        }
                        else if (vc[a].estatus_aniversario_laboral == "wine") {
                            status = `<span class="label label-warning">En ${vc[a].dias_restantes} días</span>`;
                        }
                        else if (vc[a].estatus_aniversario_laboral == "blue") {
                            status = `<span class="label label-primary">Este mes</span>`;
                        }
                        trtd += `
                            <tr class="show-vacations" data-puesto="${vc[a].idPuesto}">
                                <td>${Number(a) + 1}</td>
                                <td>${vc[a].nombre}</td>
                                <td>${getTextValue(vc[a].puesto)}</td>
                                <td>${getTextValue(vc[a].area)}</td>
                                <td>${getTextValue(vc[a].email)}</td>
                                <td>${getDateFormat(vc[a].fecha_final,5)}</td>
                                <td>${status}</td>
                                <td>${vac.length}</td>
                                <td>${pendientes}</td>
                                <td>${aceptadas}</td>
                                <td>${rechazadas}</td>
                                <td>${middle}</td>
                                <td>${p1}</td>
                                <td>${p2}</td>
                                <td>${p3}</td>
                                <td><strong>${puntaje}</strong></td>
                            </tr>
                        `;
                    }
                }
                else {
                    trtd = `<tr><td colspan="14"><center><strong>Sin resultados</strong><center></td></tr>`;
                }

                $('#bodyTableOpVacations').html(trtd);
                $('#btnSearchVacations').prop('disabled',false);
            },
            error: (error) => {
                console.log(error);
                $('#bodyTableOpVacations').html(`<tr><td colspan="14"><center><strong>Sin resultados</strong><center></td></tr>`);
                $('#btnSearchVacations').prop('disabled',false);
            }
        })
    }

    /*function btnTrainingDetails(value, row, index) {
        //Para que funcione se necesita poner esto en el th: <th data-field="operate" data-formatter="btnTrainingDetails">Detalles</th>
        return [`<button class="btn btn-primary" onclick="modalTrainingDetails('${row[1]}')"><i class="fas fa-edit"></i> Detalles</button>`
        ].join('')
    }*/

    function modalTrainingDetails(id,year) {
        console.log(id, year);
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getTrainingByEmployee`,
            data: {
                id: id,
                yr: year
            },
            beforeSend: (load) => {
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
            },
            error: (error) => {
                console.log(error);
            }
        })
        $(".training-employee-modal").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    }

</script>