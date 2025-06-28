$(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");

    $(document).on('click', '#btn_anterior_eval', function (e) {
        e.preventDefault();
        let usuario=$(this).attr("data-usuarioE");
        let tipoE=$(this).attr("data-tipoE");
        let seguimientoE=$(this).attr("data-seguimientoE");
        $.ajax({
            type: 'POST',
            url: `${$path}miInfo/getEvalPosteriores`,
            data: {
                "usuario": usuario,
                "tipo_evaluacion":tipoE,
                "seguimiento":seguimientoE
            },
            success: function (data) {
                //console.log("DataEvalpost",data);
                $("#renderContent").html("");
                $("#renderContent").html(data);
                $("#mEvalAnterior").modal('show');
            },
            error: function (data) {

            }
        });
        
    });
});