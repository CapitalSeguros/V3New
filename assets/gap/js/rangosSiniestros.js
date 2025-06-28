$(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");
    var draw=0;
    const datatable = $('#example').DataTable({
        language: {
            url: `${$path}assets/js/espanol.json`
        },
        ajax: {
            url: `${$path}Siniestros/rangos/getDataRangos/1`,
            type: 'GET',
            dataSrc: 'data'
        },
        drawCallback:function(){
            if(draw==0){
                 draw++;
            }else{
             //document.getElementById("over").style.display = "none";
             //document.getElementById("upProgressModal").style.display = "none";
             //console.log("callback");
            }
            //console.log('back')
            Getpermisos();
         },
        columns: [
            {
                data:'id',
                visible: false
            },
            {
                data: 'rango'
            },
            {
                data: null,
                "sClass": "control",
                "sDefaultContent": '',
                width: '120px',
                "orderable": false,
                render: function (data, type, row) {
                    return `
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.id}">
                            <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="eliminar(${row.id})" data-permiso="permiso" data-accion-permiso="Eliminar">Eliminar</a></li>
                        </ul>
                    </div>`;
                }
            }
        ],
        ordering: false,
        "order": [
            [0, 'asc']
        ]
    });

    $(document).on('click', '.bnNuevo', function (e) {
        e.preventDefault();
        $('#txRango').val('');
        $('#id').val('');
        $('#mdBaja').modal('show');
    });

    window.editar = function (id) {
        const _data = datatable.rows().data();
        const model = _.find(_data, function (it) {
            return it.id == id;
        });
        $('#txNombre').val(model.nombre);
        $('#id').val(model.id);
        $('#mdBaja').modal('show');
    };

    window.eliminar = function (id) {
        swal({
            title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
            text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
            icon: "warning",
            buttons: ["Cancelar", "Eliminar"],
            dangerMode: true,
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: 'POST',
                    url: `${$path}Siniestros/rangos/getDataRangos/3`,
                    data: {
                        "id": id
                    },
                    success: function (data) {
                        datatable.ajax.reload();
                    },
                    error: function (data) {

                    }
                });
            }
        });
    }

    $("#addSaveBaja").submit(function (event) {
        event.preventDefault(); //prevent default action 
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission

        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data
        }).done(function (response) {
            if (response.code == "200") {
                toastr.success("Se guardo con éxito.");
                datatable.ajax.reload();
            } else {
                toastr.error(response.message);
            }
            $('#mdBaja').modal('hide');

        });
    });

    $(document).on('keydown', '#txRango', function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58) 
        || e.keyCode == 8)) {
            return false;
        }
    });


})