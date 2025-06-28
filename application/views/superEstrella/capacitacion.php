<div class="panel panel-default" style="margin-bottom: 80px;">        
    <div class="panel-body">
        <div class="col-md-12" style="margin-bottom: 50px;">
            <h5 class="titleSection">Capacitaciones
                <button class="btn-view-cont" data-toggle="collapse" href="#segCapCond" aria-expanded="true"><i class="fa fa-info-circle" title="Ver Información"></i>
                </button>
            </h5>
            <hr class="title-hr">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12 collapse pd-top pd-bottom" id="segCapCond">
                    <div class="alert alert-primary" role="alert" style="margin: 0px;">
                        <h4><i class="fas fa-exclamation-circle"></i> Condiciones</h4>
                        <ul>
                            <li>
                                <p class="p-list-alert">Si cumple las 6 horas por trimestre registradas en el sistema (ESTO IMPLICA LA CONFIRMACIÓN DE ASISTENCIA DESDE LA CONVOCATORIA) se dan los "18" puntos.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Si se toman 5 horas se otorgarán "3" puntos.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Si toma menos de 5 no se otorgará ningún punto.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Se les recuerda que si por motivos de agenda choca la capacitación se podrá recurrir a la grabación pero requiere de un pequeño quizz para otorgar los puntos.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12 column-flex-bottom pd-items-table">
                <div class="pd-side">
                    <label class="form-check-label">Evento:</label>
                    <select class="form-control width-ajust" id="searchEvent">
                        <?= printEvents($events)?>
                    </select>
                </div>
                <div class="pd-side">
                    <button class="btn btn-primary" id="btnSearchAudit" onclick="getTableEvent()">Generar</button>
                </div>
            </div>
            <div class="col-md-12 pd-items-table">
                <div class="container-spinner" id="spinnerEvent"></div>
                <div class="segment-event">
                    <div class="col-md-6 pd-left">
                        <h5 class="form-check-label mg-top-cero">Título: <strong id="titleEvent"></strong></h5>
                        <h5 class="form-check-label">Fecha: <strong id="dateEvent"></strong></h5>
                        <h5 class="form-check-label">Hora de inicio: <strong id="hourSEvent"></strong></h5>
                        <h5 class="form-check-label">
                            Hora aproximada de finalización: <strong id="hourFEvent"></strong>
                        </h5>
                        <h5 class="form-check-label">Tiempo estimado: <strong id="timeEvent"></strong></h5>
                    </div>
                    <div class="col-md-6 pd-right">
                        <h5 class="form-check-label mg-top-cero">Lugar: <strong id="placeEvent"></strong></h5>
                        <h5 class="form-check-label">Categoría: <strong id="categoryEvent"></strong></h5>
                        <h5 class="form-check-label">Ramo: <strong id="ramoEvent"></strong></h5>
                        <h5 class="form-check-label" title="Solicitudes Aceptadas">
                            Invitados Confirmados: <strong id="requestEvent"></strong>
                        </h5>
                        <h5 class="form-check-label" title="Asistencia de Invitados">
                            Invitados Presentados: <strong id="presentEvent"></strong>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-12 pd-items-table">
                <div class="col-md-12 column-flex-end pd-right">
                    <input type="text" class="form-control" placeholder="Filtrar" id="filterTableOpEvent" style="width: 30%;">
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 container-table">
                    <table class="table table-striped" id="tableOpEvent">
                        <thead class="table-thead">
                            <tr class="table-tr">
                                <th>N°</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>N° de Registro</th>
                                <th>Tipo Invitado</th>
                                <th>Estatus Invitacion</th>
                                <th>Estatus Asistencia</th>
                                <th colspan="2">Asistió</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="bodyTableOpEvent"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 50px;">
            <h5 class="titleSection">Resultados por Colaborador</h5>
            <hr class="title-hr">
            <div class="col-md-12 column-flex-bottom pd-items-table">
                <div class="pd-side">
                    <label class="form-check-label">Año:</label>
                    <select class="form-control width-ajust" id="searchYearTraining">
                        <?=$years?>
                    </select>
                </div>
                <div class="pd-side">
                    <label class="form-check-label">Trimestre:</label>
                    <select class="form-control width-ajust" id="searchQuarterTraining">
                        <?=$quarterly?>
                    </select>
                </div>
                <div class="pd-side">
                    <button class="btn btn-primary" id="btnSearchTraining" onclick="getTableRsTraining()">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
            <div class="col-md-12 pd-items-table">
                <div class="container-spinner" id="spinnerTraining"></div>
                <div class="segment-event" id="containerTraining">
                    <table class="table" id="tableTraining">
                        <thead>
                            <tr style="background: transparent;">
                                <th style="color: black;"><strong>Capacitación</strong></th>
                                <th style="color: black;"><strong>Tiempo Impartido</strong></th>
                            </tr>
                        </thead>
                        <tbody id="bodyTraining"></tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 container-table-bootstrap" id="contTableRsTraining"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getTableEvent() {//Modificado [2024-04-22]
        const event  = document.getElementById('searchEvent').value;
        $('#btnSearchEvent').prop('disabled',true);

        $.ajax({
            type: "GET",
            url: `${baseUrl}/getSearchEmployeeEvent`, //controlAsistenciaEvento/listEvents
            data: {
                ev: event
            },
            beforeSend: (load) => {
                $('#spinnerEvent').html(`
                    <div class="container-spinner-content-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);
                $('#bodyTableOpEvent').html(`
                    <tr>
                        <td colspan="8">
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
                let cap = r['events'];
                const date = getDateFormat(cap['fecha'],5);
                var time = ""; 
                var option = ``;
                var trtd = ``;
                var guest = 0;
                var active = 0;
                //Tiempo estimado
                if (cap['tiempo'].includes('.')) {
                    time = getTimeByHour(cap['tiempo']);
                }
                //Invitados
                if (cap != 0) {
                    let cl = cap['invitados'];
                    //const disabledUpdate = cap['actualizar'];
                    const disabledSave = cap['guardar'];
                    guest = cl.length;
                    if (cl != 0) {
                        for (const c in cl) {
                            let rg = cl[c].registro;
                            const idPersona = cl[c].idPersona;
                            const idGuest = cl[c].idInvitado;
                            var status = "label-primary";
                            var present = "label-wine";
                            var textPresent = "No registrado";
                            var checkA = "";
                            var checkI = "checked";
                            var register = 0;
                            var update = "no";
                            //var textBtn = "Guardar";
                            //var classBtn = "btn-primary";
                            var disabled = ""; //disabledSave
                            if (cl[c].estado == "pendiente") { status = "label-warning"; }
                            if (rg != 0) {
                                update = "si";
                                //textBtn = "Actualizar";
                                //classBtn = "btn-success";
                                /*if (disabledUpdate != 0) { disabled = disabledUpdate; }
                                else { disabled = ""; }*/
                                for(const g in rg) {
                                    register = rg[g].idRegistro;
                                    if (rg[g].estado == "activo") {
                                        present = "label-success";
                                        textPresent = "Confirmado";
                                        checkA = "checked";
                                        checkI = "";
                                        active++;
                                    }
                                    else {
                                        present = "label-danger";
                                        textPresent = "Falta";
                                        checkA = "";
                                        checkI = "checked";
                                    }
                                }
                            }
                            //console.log(idGuest, cl[c].idEvento, update, textBtn, classBtn, checkA, checkI);
                            trtd += `
                                <tr class="show-event">
                                    <td>${Number(c) + 1}</td>
                                    <td>${cl[c].nombre.toUpperCase()}</td>
                                    <td>${cl[c].email}</td>
                                    <td>${idGuest}</td>
                                    <td>${cl[c].tipo_invitado.toUpperCase()}</td>
                                    <td><strong>${cl[c].estado.toUpperCase()}</strong></td>
                                    <td id="statusEvent${idGuest}"><span class="label ${present}">${textPresent}</span></td>
                                    <td>
                                        <input type="radio" class="form-check-input" name="check-save${idGuest}" value="1" ${checkA} ${disabled}>
                                        <label class="form-check-label">Sí</label>
                                    </td>
                                    <td>
                                        <input type="radio" class="form-check-input" name="check-save${idGuest}" value="2" ${checkI} ${disabled}>
                                        <label class="form-check-label">No</label>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" data-hour="${cap['duracion']}" data-capacitacion="${cl[c].idEvento}" data-register="${register}" data-guest="${idGuest}" data-update="${update}" id="btnCap${idGuest}" onclick="saveEvent(this)" ${disabled}>Guardar</button>
                                    </td>
                                </tr>
                            `;
                        }
                    }
                    else {
                        trtd = `<tr><td colspan="8"><center><strong>Sin resultados</strong><center></td></tr>`;
                    }
                }
                else {
                    trtd = `<tr><td colspan="8"><center><strong>Sin resultados</strong><center></td></tr>`;
                }
                $('#titleEvent').text(cap['titulo']);
                $('#dateEvent').text(date);
                $('#hourSEvent').text(cap['horaI']);
                $('#hourFEvent').text(cap['horaF']);
                $('#timeEvent').text(time);
                $('#placeEvent').text(cap['lugar']);
                $('#categoryEvent').text(cap['categoria']);
                $('#ramoEvent').text(cap['ramo']);
                $('#requestEvent').text(guest);
                $('#presentEvent').text(active);
                $('#bodyTableOpEvent').html(trtd);
                $('#spinnerEvent').html("");
                $('#btnSearchEvent').prop('disabled',false);
            },
            error: (error) => {
                console.log(error);
                $('#spinnerEvent').html("");
                $('#bodyTableOpEvent').html(`<tr><td colspan="8"><center><strong>Sin resultados</strong><center></td></tr>`);
                $('#btnSearchEvent').prop('disabled',false);
            }
        })
    }

    function getTableRsTraining() {//Modificado [2024-04-22]
        const year = document.getElementById('searchYearTraining').value;
        const quarter = document.getElementById('searchQuarterTraining').value;
        //console.log("Año: " + year + ", Trimestre: " + quarter);
        $('#btnSearchTraining').prop('disabled',true);

        $.ajax({
            type: "GET",
            url: `${baseUrl}/getResultTraining`,
            data: {
                qr: quarter,
                yr: year
            },
            beforeSend: (load) => {
                $('#spinnerTraining').html(`
                    <div class="container-spinner-content-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);
                $('#contTableRsTraining').css('height','450px');
                $('#contTableRsTraining').html(`
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
                let ev = r['events'];
                let em = r['employees'];
                let json = [];
                var hours = 0;
                var h5 = ``;
                var trtd = ``;
                var thead = `
                    <tr class="table-tr"><th colspan="9" class="title-table">Asistencias de Capacitaciones</th></tr>
                    <tr class="table-tr">
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Área</th>
                        <th>Puesto</th>
                        <th>Email</th>
                        <th>Solicitudes Aceptadas</th>
                        <th>Asistencias</th>
                        <th>Horas Acumuladas</th>
                        <th>Puntos</th>
                    </tr>
                `;
                //Capacitaciones
                if (ev != 0) {
                    for (const c in ev) {
                        const time = getTimeByHour(ev[c].tiempo);
                        hours = hours + ev[c].duracion;
                        h5 += `                        
                            <tr>
                                <td>${ev[c].titulo}</td>
                                <td>${time}</td>
                            </tr>
                        `;
                    }
                    //console.log(hours);
                    hours = getTimeByHour(String(hours.toFixed(2)));
                    h5 += `
                        <tr>
                            <td>
                                <h5 class="form-check-label" style="text-align: center;">Total de Capacitaciones: <strong>${ev.length}</strong></h5>
                            </td>
                            <td>
                                <h5 class="form-check-label" style="text-align: center;">Total de horas: <strong>${hours}</strong></h5>
                            </td>
                        </tr>
                    `;
                }
                else {
                    h5 = `<tr><td colspan="2"><h5 class="form-check-label" style="text-align: center;">No se encontró ninguna capacitación</h5></td></tr>`;
                }
                //Empleados
                if (em != 0) {
                    for (const e in em) {
                        let tr = em[e].eventos;
                        const position = Number(e) + 1;
                        const nombre = em[e].nombre;
                        const area = getTextValue(em[e].area);
                        const puesto = em[e].puesto;
                        const email = getTextValue(em[e].email);
                        var aceptados = 0;
                        var asistencia = 0;
                        var horas = 0;
                        var puntos = 0;
                        for (const t in tr) {
                            if (tr[t].solicitud == "aceptado") {
                                aceptados++;
                                if (tr[t].asistencia == "activo") {
                                    asistencia++;
                                    horas = horas + Number(tr[t].tiempo);
                                }
                            }
                        }
                        if (horas >= 6 || horas == hours) { puntos = 18; }
                        else if (horas >= 5 && horas < 6) { puntos = 3; }
                        horas = getTimeByHour(String(horas.toFixed(2)));
                        //console.log("Horas acumuladas: "+horas+", Horas Capacitaciones: "+hours+", Puntos: "+puntos);
                        json.push({[0]:position, [1]:nombre, [2]:area, [3]:puesto, [4]:email, [5]:aceptados, [6]:asistencia, [7]:horas, [8]:`<strong>${puntos}</strong>`});
                    }
                }
                else {
                    trtd = `<tr><td colspan="9"><center><strong>Sin resultados</strong><center></td></tr>`;
                }
                getTableBootstrap("contTableRsTraining","tableRsTraining",thead,json,`Capacitacion <?=date('Y-m-d H:i:s')?>`);
                $('#bodyTraining').html(h5);
                $('#spinnerTraining').html("");
                $('#btnSearchTraining').prop('disabled',false);
            },
            error: (error) => {
                console.log(error);
                $('#spinnerTraining').html("");
                $('#btnSearchTraining').prop('disabled',false);
            }
        })
    }

    function saveEvent(obj) {
        const cap = $(obj).data('capacitacion');
        const guest = $(obj).data('guest');
        const register = $(obj).data('register');
        const hour = $(obj).data('hour');
        const update = $(obj).data('update');
        const radio = document.getElementsByName('check-save'+guest);
        var check = "";
        for (let i=0;i<radio.length;i++) {
            if (radio[i].checked) { check = radio[i].value; }
        }
        console.log("ID: "+cap+", Actualizar: "+update+", Invitado: "+guest+", IdRegistro: "+register+", Radio: "+check);
        $.ajax({
            type: "POST",
            url: `${baseUrl}/saveEmployeeEvent`,
            data: {
                ev: cap,
                gt: guest,
                rg: register,
                hr: hour,
                ck: check,
                up: update
            },
            beforeSend: (load) => {
                $('#btnCap'+guest).html(`
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
                let st = r['status'];
                for (const e in st) {
                    var present = "No registrado";
                    if (st[e].estado == "activo") {
                        present = `<span class="label label-success">Confirmado</span>`;
                    }
                    else {
                        present = `<span class="label label-danger">Falta</span>`;
                    }
                    $('#statusEvent'+guest).html(present);
                    $(obj).attr('data-register',st[e].idRegistro);
                    $(obj).attr('data-update','si');
                }
                $('#btnCap'+guest).html("Guardar");
                getTableRsTraining();
            },
            error: (error) => {
                console.log(error);
                $('#btnCap'+guest).html("Guardar");
            }
        })
    }
</script>