var algo=1;
$(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");
console.log($path);
    const incidencia = new Incidencias({
        classRender: '.js-incidencias',
        actionOpen: '.openModal',
        reference: 'INCIDENCIAS',
        callbackSuccess: function (response) {
            //location.reload();
            //console.log($path+"miInfo/#incidencias");
            window.location.replace($path+"miInfo/#incidencias");
        }
    });
    incidencia.init();

    const ModuloBonos = new Bonos({
        selector: '#bonos-container',
        selectorAction: '.bn-sol-bono',
        callBack:function(respose){
            //location.reload();
            window.location.href = $path+"miInfo/#otros";
        }
    });
    ModuloBonos.init();

    window.getDataHistorial = function (id) {
        $.ajax({
            url: `${$path}Bonos/getSeguimiento/${id}`,
            method: 'GET',
            dateType: 'json',
            success: function (response) {
                window.modalModalSeguimiento.show("Seguimiento de bonos", response.data)
            }
        });

    }

    window.getIncidenciaHistorial = function (event, id) {
        event.preventDefault();
        $.ajax({
            url: `${$path}seguimiento/get/`,
            data: {
                id: id,
                referencia: 'INCIDENCIA'
            },
            method: 'GET',
            dateType: 'json',
            success: function (response) {
                window.modalModalSeguimiento.show("Seguimiento de incidencias", response.data)
            }
        });

    }
});