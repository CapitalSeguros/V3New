$(document).ready(function () {
    const id = $("#new_ev").attr('data-id-ev');

    window.ev = new EvaluacionPeriodo({
        classRender: '#new_ev',
        id: id,
        callbackSuccess: function (response) {
            // datatable.ajax.reload();
            // datatable.draw();
        }
    });

    ev.init();
});