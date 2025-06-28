<div class="panel panel-default" style="margin-bottom: 80px;">        
    <div class="panel-body">
        <div class="col-md-12" style="margin-bottom: 50px;">
            <h5 class="titleSection">Puntualidad
                <button class="btn-view-cont" data-toggle="collapse" href="#segPuntCond" aria-expanded="true"><i class="fa fa-info-circle" title="Ver Información"></i>
                </button>
            </h5>
            <hr class="title-hr">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12 collapse pd-top pd-bottom" id="segPuntCond">
                    <div class="alert alert-primary" role="alert" style="margin: 0px;">
                        <h4><i class="fas fa-exclamation-circle"></i> Condiciones</h4>
                        <p>Para que se tome encuenta estos puntos se debe considerar lo siguiente:</p>
                        <ul>
                            <li>
                                <p class="p-list-alert">Se otorga solamente cuando el colaborador logre una constante diaria de llegar en su horario puntual asi como también registrar su salida al retirarse y asi logrará los "10" puntos</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Cada día que el colaborador llegue impuntual o no registre su salida, se le descontará 1 punto.</p>
                            </li>
                            <li>
                                <p class="p-list-alert">Cualquier falta deberá de estar debidamente justificada y en el sistema (my info) incluyendo los permisos, de no ser así se descontarán los puntos.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12 column-flex-bottom pd-items-table">
                <div class="pd-side">
                    <label class="form-check-label">Año:</label>
                    <select class="form-control width-ajust" id="searchYearCheck">
                        <?=$years?>
                    </select>
                </div>
                <div class="pd-side">
                    <label class="form-check-label">Trimestre:</label>
                    <select class="form-control width-ajust" id="searchQuarterlyCheck">
                        <?=$quarterly?>
                    </select>
                </div>
                <div class="pd-side">
                    <label class="form-check-label">Área:</label>
                    <select class="form-control width-ajust" id="searchAreaCheck">
                        <?= printArea($puestos);?>
                    </select>
                </div>
                <div class="pd-side">
                    <button class="btn btn-primary" id="btnSearchAttendance" onclick="getTableCheck()">Generar</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 container-table-bootstrap" id="contTableAttendance"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getTableCheck() {        
        const year = document.getElementById('searchYearCheck').value;
        const quarterly = document.getElementById('searchQuarterlyCheck').value;
        const area = document.getElementById('searchAreaCheck').value;
        $('#btnSearchAttendance').prop('disabled',true);

        $.ajax({
            type: "GET",
            url: `${baseUrl}/getSearchEmployeeAttendance`,
            data: {
                yr: year,
                qr: quarterly,
                ar: area
            },
            beforeSend: (load) => {
                $('#contTableAttendance').css('height','450px');
                $('#contTableAttendance').html(`
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
                let mp = r['employees'];
                let ch = r['attendance'];
                let dt = r['dates'];
                let json = [];
                var dias = 0;
                var thead = `
                    <tr class="table-tr"><th colspan="10" class="title-table">Asistencias</th></tr>
                    <tr class="table-tr">
                        <th>N°</th>
                        <th>Nombre Completo</th>
                        <th>Puesto</th>
                        <th>Área</th>
                        <th>Correo</th>
                        <th>Asistencia</th>
                        <th>Puntualidad</th>
                        <th>Registro de Salida</th>
                        <th>Puntos</th>
                        <th>Detalles</th>
                    </tr>
                `;
                for (const d in dt) {
                    dias = dias + dt[d].dates.length;
                }
                for (const p in ch) {
                    let add = {};
                    let m1 = getResultAttendance(ch[p].asistencias[0],dt[0]['dates'],1);
                    let m2 = getResultAttendance(ch[p].asistencias[1],dt[1]['dates'],1);
                    let m3 = getResultAttendance(ch[p].asistencias[2],dt[2]['dates'],1);
                    var asistencia = m1[0] + m2[0] + m3[0];
                    var puntualidad = m1[1] + m2[1] + m3[1];
                    var salida = m1[2] + m2[2] + m3[2];
                    var validar = m1[3] + m2[3] + m3[3];
                    var puntos = 0;
                    var porcentaje = (dias * 90) / 100;
                    if (porcentaje <= validar) { puntos = 15; }
                    //console.log("Dias: " + dias + ", Validados: " + validar + ", Porcentaje: " + porcentaje + ", Puntos: " + puntos);
                    add[0] = Number(p) + 1;
                    add[1] = ch[p].nombre;
                    add[2] = getTextValue(ch[p].puesto);
                    add[3] = getTextValue(ch[p].area);
                    add[4] = getTextValue(ch[p].email);
                    add[5] = asistencia;
                    add[6] = puntualidad;
                    add[7] = salida;
                    add[8] = `<strong>${puntos}</strong>`;
                    add[9] = `<button class='btn btn-primary employee-attendance' data-employee='${ch[p].idPersona}' onclick="getAttendanceByEmployee('${ch[p].idPersona}','${quarterly}','${year}')"><i class='fas fa-edit'></i> Detalles</button>`;
                    json.push(add);
                }
                getTableBootstrap("contTableAttendance","tableAttendance",thead,json,`Asistencias <?=date('Y-m-d H:i:s')?>`);
                $('#btnSearchAttendance').prop('disabled',false);
            },
            error: (error) => {
                console.log(error);
                $('#btnSearchAttendance').prop('disabled',false);
            }
        })
    }

    function getAttendanceByEmployee(idPersona,quarter,year) {
        $(".training-employee-modal").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        })
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getSearchAttendance`,
            data: {
                id: idPersona,
                qr: quarter,
                yr: year
            },
            beforeSend: (load) => {
                $('#cont-nav-Puntuality').css('height','450px');
                $('#cont-nav-Puntuality').html(`
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
                console.log(r);
                let ch = r['attendance'];
                let dt = r['dates'];
                var li = ``;
                var div = ``;
                //console.log("idPersona: " + idPersona);
                for (const a in ch) {
                    let att = ch[a].asistencias;
                    let m1 = getResultAttendance(ch[a].asistencias[0],dt[0]['dates'],2)[0];
                    let m2 = getResultAttendance(ch[a].asistencias[1],dt[1]['dates'],2)[0];
                    let m3 = getResultAttendance(ch[a].asistencias[2],dt[2]['dates'],2)[0];
                    li += `<div class="col-md-12 pd-items-table"><h5 class="titleSeg">Nombre: <strong>${ch[a].nombre}</strong></h5></div><ul class="nav nav-tabs nav-light">`;
                    for (const b in dt) {
                        let date = dt[b].dates;
                        const month = getDateFormat(dt[b].dateS,6);
                        var active = "";
                        var result = 0;
                        if (b == 0) { active = "active"; }
                        li += `
                            <li class="nav-item">
                                <a class="nav-tab-link ${active}" aria-current="page" href="#PnMes${month}" role="tab" data-toggle="tab">${month}</a>
                            </li>
                        `;
                        div += `<div class="col-md-12 tab-pane ${active}" id="PnMes${month}"><div class="col-md-12"><label class="subtitleSeg">Total de días: <strong>${date.length}</strong></label></div><div class="col-md-12 container-table" style="height:350px;"><table class="table table-striped" style="margin:0px;"><thead class="table-thead"><tr class="table-tr"><th>Fecha</th><th>Asistencia</th><th>Puntualidad</th><th>Salida</th></tr></thead><tbody>`;

                        switch(b) {
                            case "0": result = getIconAttendance(m1,date);
                            break;
                            case "1": result = getIconAttendance(m2,date);
                            break;
                            case "2": result = getIconAttendance(m3,date);
                            break;
                        }
                        //console.log(result);
                        div += `${result[3]}</tbody><tfoot class="table-tfoot"><tr><td><strong>Total:</strong></td><td>${result[0]}</td><td>${result[1]}</td><td>${result[2]}</td></tr></tfoot></table></div></div>`;
                    }
                    li += `</ul>`;
                }
                $('#cont-nav-Puntuality').css('height','');
                $('#nav-Puntuality').html(li);
                $('#cont-nav-Puntuality').html(div);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }

    function getResultAttendance(m,dt,type) {
        let as = m['asistencia'];
        let pn = m['puntualidad'];
        let sl = m['salida'];
        let vc = m['vacaciones'];
        let check = [];
        let data = [];
        var asistencia = as.length;
        var puntualidad = pn.length;
        var salida = sl.length;
        var validar = 0;
        for (const d in dt) {
            const fecha = dt[d];
            var checkA = '<span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span>';
            var checkP = '<span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span>';
            var checkS = '<span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span>';
            var checkV = 'no';
            var resultA = 0;
            var resultP = 0;
            var resultS = 0;
            for (const a in as) {
                const fechaA = getDateFormat(as[a].fecha,4);
                if (fecha == fechaA) {
                    checkA = '<span class="seg-icon-asist"><i class="fa fa-check-circle"></i></span>';
                    resultA = 1;
                }
            }
            for (const b in pn) {
                const fechaP = getDateFormat(pn[b].fecha,4);
                if (fecha == fechaP) {
                    checkP = '<span class="seg-icon-asist"><i class="fa fa-check-circle"></i></span>';
                    resultP = 1;
                }
            }
            for (const c in sl) {
                const fechaS = getDateFormat(sl[c].fecha,4);
                if (fecha == fechaS) {
                    checkS = '<span class="seg-icon-asist"><i class="fa fa-check-circle"></i></span>';
                    resultS = 1;
                }
            }
            for (const d in vc) {
                const fechaV = getDateFormat(vc[d].fecha,4);
                if (fecha == fechaV) {
                    checkA = '<span class="seg-icon-vac"><i class="fa fa-plane"></i></span>';
                    checkP = '<span class="seg-icon-vac"><i class="fa fa-plane"></i></span>';
                    checkS = '<span class="seg-icon-vac"><i class="fa fa-plane"></i></span>';
                    checkV = 'si';
                    resultP = 1;
                    resultS = 1;
                }
            }
            if (resultA == 1 && resultP == 1 && resultS == 1) { validar++; }
            check.push({fecha:fecha, asistencia:checkA, puntualidad:checkP, salida:checkS, vacaciones:checkV});
        }

        if (type == 1) {
            data = [asistencia, puntualidad, salida, validar];
        }
        else {
            data = [check];
        }
        return data;
    }

    function getIconAttendance(m,date) {
        const today = `<?=date('Y-m-d')?>`;
        var as = 0;
        var pn = 0;
        var sl = 0;
        var tr = ``;
        for (const d in date) {
            tr += `<tr><td>${date[d]}</td>`;
            var td = `<td><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td>`;
            if (date[d] <= today) {
                for (const a in m) {
                    //td = `<td></td><td></td><td></td>`;
                    //console.log(m[a]);
                    if (m[a].fecha == date[d]) {
                        td = `
                            <td>${m[a].asistencia}</td>
                            <td>${m[a].puntualidad}</td>
                            <td>${m[a].salida}</td>
                        `;
                        if (m[a].asistencia.includes('fa-check-circle')) { as++; }
                        if (m[a].puntualidad.includes('fa-check-circle')) { pn++; }
                        if (m[a].salida.includes('fa-check-circle')) { sl++; }
                    }
                }
                // if (m[a].fecha > `<?date('Y-m-d')?>`) {
                //     td = `<td></td><td></td><td></td>`;
                // }
            }
            else {
                td = `<td></td><td></td><td></td>`;
            }
            tr += `${td}</tr>`;
        }
        let data = [as, pn, sl, tr]
        return data;
    }
</script>