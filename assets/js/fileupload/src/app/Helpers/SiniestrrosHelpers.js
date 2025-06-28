const color = function (data) {
    var color = "";
    switch (data) {
        case "ACTIVO":
            color = "#149EF7";
            break;
        case "PENDIENTE":
            color = "#FFA301";
            break;
        case "RECHAZADO":
            color = "#f44343";
            break;
        case "FINIQUITADO":
            color = "#2cb922";
            break;
        case "DESISTIMIENTO":
            color = "#eccf0e";
            break;
        case "DORMIDO":
            color = "#8c8787";
            break;
        default:
            color = "#B0AEA9";
            break;
    }
    return color;
};

const Colores = function (total) {
    var color = '';
    if (total >= 0 && total <= 0.40) {
        color = "#6dca6d";
    }
    if (total > 0.40 && total <= 0.60) {
        color = "#e8f051";
    }
    if (total > 0.60 && total < 1) {
        color = "#e68d10";
    }
    if (total >= 1) {
        color = "#db311a";
    }
    return color;
}

const Colorbarra = function (parametro, progreso, fechaI, fechaF, estado) {
    var FI = moment(fechaI, "YYYY-MM-DD");
    var FF = fechaF == null ? moment() : moment(fechaF, "YYYY-MM-DD");
    var days = FF.diff(FI, 'days');
    //console.log("days",days);
    var color = {};
    var total = parseFloat(parseInt(days) / parseInt(parametro));
    if (estado == "LIQUIDADO" || estado == "FINALIZADO" || estado == "FINIQUITADO") {
        color = {
            color: Colores(total),
            porcentaje: "100%",
            mensaje: `Se ha liquidado el trámite en ${days} dias`,
            dias: days
        };
    }
    else if (estado == 'RECHAZADO') {
        color = {
            color: "#472380",
            porcentaje: "100%",
            mensaje: 'Se ha rechazado el trámite',
            dias: days
        };
    }
    else if (parametro == null) {
        color = {
            color: "#472380",
            porcentaje: "0%",
            mensaje: 'No se tiene ningún indicador relacionado.',
            dias: isNaN(days) ? 0 : days

        };
    } else {
        if (total >= 0 && total <= 0.40) {
            color = {
                color: Colores(total),
                porcentaje: "30%",
                mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
                dias: days
            };
        }
        if (total > 0.40 && total <= 0.60) {
            color = {
                color: Colores(total),
                porcentaje: "60%",
                mensaje: `han transcurrido ${days} dias de los${parametro} del indicador`,
                dias: days
            };
        }
        if (total > 0.60 && total < 1) {
            color = {
                color: Colores(total),
                porcentaje: "85%",
                mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
                dias: days
            };
        }
        if (total >= 1) {
            color = {
                color: Colores(total),
                porcentaje: "100%",
                mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
                dias: days
            };
        }
    }
    return color;

}

export { color, Colorbarra };