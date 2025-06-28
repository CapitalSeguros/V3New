$(function(){
     $("#blocks").DataTable();
});

$(document).on("click", ".find-client", function(){

    const name = $("#find-client").val();
    const baseUrl = $("#base-url").data("url");
    console.log(name);

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}clientes/getClients`,
        data: {
            client: name
        },
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            const response = JSON.parse(data);
            //console.log(response);

            const a_list = response.reduce((acc, curr) => acc +=
                `<a href="javascript: void(0)" class="list-group-item client" id="a-${curr.IDCli}" data-client-id="${curr.IDCli}" data-name="${curr.NombreCompleto}">
                    <div class="col-md-12 mb-2"><p class="list-group-item-text">Cliente: ${curr.IDCli}</p></div>
                    <div class="col-md-12"><h5 class="list-group-item-heading">${curr.NombreCompleto}</h5></div>
                </a>`, 
            ``);

            $("#search-results").html(`
                <div class="list-group">${a_list}</div>
            `);
        }
    });
});

//---------------------------------
$(document).on("click", ".client", function(){

    const id = $(this).data("client-id");
    const name = $(this).data("name");
    const baseUrl = $("#base-url").data("url");

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}clientes/getClientData`,
        data: {
            client: id
        },
        error: (error) => {
            console.log(error);
        },
        beforeSend: () => {
            $(".loading-spinner").addClass("block").removeClass("hidden");
        },
        success: (data) => {
            const response = JSON.parse(data);

            const types = response.reduce((acc, curr) => {

                const style = getBgColor(curr);
                acc += `<div style="text-align: center; color: white; font-family: helvetica; font-weight: bold; padding: 4px 4px 4px 4px; margin-right: 5px; margin-bottom: 5px; ${style}">${curr}</div>`;

                return acc;
            }, ``);

            //------------------- Create element
            var element = $("<div></div>", {style: "border: 1px black solid", class: "col-md-4 mr-4 mb-4 client-target"}).
            append(
                $("<div></div>", {class: "row mt-2"}).append(
                    $("<div></div>", {class: "col-md-8 client-id"}).append(
                        $("<p></p>").
                            text(`Cliente: ${id}`)),
                    $("<div></div>", {class: "col-md-4 text-right"}).html(
                        `<a href="javascript: void(0)" data-cli="${id}" class="remove-item"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>`
                    )), 
                $("<div></div>").append(
                    $("<p></p>").
                        text(name)),
                //$("<hr>"),
                $("<div></div>", {class: "col-md-12"}).append(
                    $("<div></div>", {class: "row mb-4 types-container"}).html(types)
                )
            ); 
            //-------------------
            $(".loading-spinner").addClass("hidden").removeClass("block");
            $("#container-of-selected").append(element);
            $(this).hide();
        }
    });
});
//----------------------------------------
const getBgColor = (type) => {
    //93, 173, 226 
    switch(type){
        case `Vida`: return `background-color: rgba(229, 152, 102)`;
        break;
        case `GMM` : return `background-color: rgba(93, 173, 226)`;
        break;
        case `Vehiculos` : return `background-color: rgba(244, 208, 63)`;
        break;
        case `Daños` : return `background-color: rgba(236, 112, 99)`;
        break;
        case `Fianzas` : return `background-color: rgba(46, 204, 113)`;
        break;
    }
}
//----------------------------------------
$(document).on("click", ".remove-item", function(){

    const id = $(this).data("cli");
    $(`#a-${id}`).show();
    var fater = $(this).parent().parent().parent();
    fater.remove();
});
//--------------------------------------
$(document).on("click", ".unify-clients", function(){

    const types = [];
    const clients = [];
    const baseUrl = $("#base-url").data("url");
    const update = $(this).data("update"); //data-update
    const block = $(this).data("block");

    $(".client-id").each(function(){
        const idClient = $(this).text().split(" ");
        clients.push(idClient[1]);
    });

    $(".types-container div").each(function(){
        types.push($(this).text());
    });

    console.log(types, clients);
    const ajax = $.ajax({
        method: "POST",
        url: `${baseUrl}clientes/unifyClients`,
        data: {
            block: block,
            clients:clients,
            types: types,
            update: update
        },
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);

            alert(response.message);
            if(response.status){
                window.location.reload();
            }
        }
    });

    //console.log(types, clients);
});
//--------------------------------------
$(document).on("click", ".select-option", function(){

    var id = $(this).data("show");

    $(".contents").each(function(){
        $(this).addClass("hidden").removeClass("show");
    });

    $(`#${id}`).addClass("show").removeClass("hidden");
});
//-------------------------------------
$(document).on("click", ".delete", function(){

    const block = $(this).data("id");
    const baseUrl = $("#base-url").data("url");
    
    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}clientes/deleteUnify`,
        data: {
            block: block
        },
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);

            alert(response.message);
            if(response.status){
                window.location.reload();
                //$(`.${block}`).remove();
                //$("#blocks").DataTable();
            }
        }
    });
});
//-------------------------------------
$(document).on("click", ".modify", function(){

    const baseUrl = $("#base-url").data("url");
    const block = $(this).data("id");
    const clients_ = [];

    $(".select-option").eq(0).trigger('click');
    $(".unify-clients").attr("data-update", 1);
    $(".unify-clients").attr("data-block", block);

    $(".show-info").each(function(){
        const attr = $(this).attr("id-block");

        if(attr == block){
            clients_.push({
                name: $(this).parent().text(),
                value: $(this).val(),
            });
        }
    });

    for(const a in clients_){

        const ajax = $.ajax({
            type: "GET",
            url: `${baseUrl}clientes/getClientData`,
            data: {
                client: clients_[a].value
            },
            error: (error) => {
                console.log(error);
            },
            beforeSend: () => {
                $(".loading-spinner").addClass("block").removeClass("hidden");
                $(".client-target").remove();
            },
            success: (data) => {
                //$("#container-of-selected").html(``);
                const response = JSON.parse(data);
                const types = response.reduce((acc, curr) => {
    
                    const style = getBgColor(curr);
                    acc += `<div style="text-align: center; color: white; font-family: helvetica; font-weight: bold; padding: 4px 4px 4px 4px; margin-right: 5px; margin-bottom: 5px; ${style}">${curr}</div>`;
    
                    return acc;
                }, ``);
                //------------------- Create element
                var element = $("<div></div>", {style: "border: 1px black solid", class: "col-md-4 mr-4 mb-4 client-target"}).
                append(
                    $("<div></div>", {class: "row mt-2"}).append(
                        $("<div></div>", {class: "col-md-8 client-id"}).append(
                            $("<p></p>").
                                text(`Cliente: ${clients_[a].value}`)),
                        $("<div></div>", {class: "col-md-4 text-right"}).html(
                            `<a href="javascript: void(0)" data-cli="${clients_[a].value}" class="remove-item"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>`
                        )), 
                    $("<div></div>").append(
                        $("<p></p>").
                            text(clients_[a].name)),
                    //$("<hr>"),
                    $("<div></div>", {class: "col-md-12"}).append(
                        $("<div></div>", {class: "row mb-4 types-container"}).html(types)
                    )
                ); 
                //-------------------
                $(".loading-spinner").addClass("hidden").removeClass("block");
                $("#container-of-selected").append(element);
            }
        });
    }
});
//-------------------------------------
$(document).on("change", ".show-info", function(){

    const block = $(this).attr("id-block");
    const value = $(this).val();
    const baseUrl = $("#base-url").data("url");
    const name = $(this).parent().text();
    const validate = [];
    
    if($(this).prop("checked")){

        console.log("checked");
        const ajax = $.ajax({
            type: "GET",
            url: `${baseUrl}clientes/getOnlyClientData`,
            data: {
                client: value
            },
            error: (error) => {
                console.log(error);
            },
            success: (data) => {
                const response = JSON.parse(data);
                console.log(response);
                var content = ``;
    
                for(var a in response){
    
                    const ramificationName = a == "Accidentes y Enfermedades" ? "GMM" : a;
    
                    content += `
                        <div class="mb-2">
                            <div class="row" style="margin-left: 3px;">
                                <div class="" style="${getBgColor(ramificationName)}; font-weight: bold; color: white; border-radius: 20px; padding: 2px 8px 2px 8px">${ramificationName}</div>
                                <div class="" style="${getBgColor(ramificationName)}; font-weight: bold; color: white; margin-left: 5px; border-radius: 20px; padding: 2px 8px 2px 8px">${response[a].length}</div>
                            </div>
                        </div>
                    `;
                }
    
                $(`.${block}-${value}`).html(`<div class="mb-2">${name}</div>`+content);
                $(`.${block}-${value}`).addClass("show").removeClass("hidden");
                $(`.${block}_`).addClass("hidden").removeClass("show");
            }
        });
     } else{
        console.log("unchecked");
        $(`.${block}-${value}`).addClass("hidden").removeClass("show");
     }

    $(".show-info").each(function(){

        if($(this).attr("id-block") == block &&  $(this).prop("checked")){
            validate.push(true);
        }
    });

    if(validate.length == 0){
        $(`.${block}_`).addClass("show").removeClass("hidden");
    }

    //console.log(validate);
});
//-------------------------------------