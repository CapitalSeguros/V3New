window.modalDetail = function (id) {
    $.ajax({
        url: `evaluacion/resultado/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
        },
        error: function(jqXHR, textStatus,  errorThrown){
            console.error(jqXHR);
        },
        always: function () {
            $("#mdDetail").modal('show');
        }
    })


}