
$(document).ready(function(){
    //console.log("RELOAD")
    getLinkList();
});

$(".create-link").click(function(){

    console.log("CREATE-LINK");
    const showActiveOptions = $(this).data("show-active");
    const showDiv = showActiveOptions ? "block" : "none";
    $(".link-active-cont").css("display", showDiv);

    $("#form-link").modal({
        show: true,
        backdrop: false,
        keyboard: false,
    });
});

//-------------------------------
const getLinkList = () => {

    const baseUrl = $(".base-url").data("url");

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}persona/getLinkList`,
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            
            const response = JSON.parse(data);

            if(response.bool){

                const tr = response.data.reduce((acc, curr) => {

                    const label = curr.active == 1 ? `Activo` : "Inactivo";
                    const colorText = curr.active == 0 ? "text-danger" : ``;
                    const options = [0, 1].reduce((acc_, curr_) => {

                        const label = curr_ == 1 ? `Activo` : "Inactivo";
                        const colorText = curr_ == 0 ? "text-danger" : ``;
                        acc_ += `<li role="presentation"><a role="menuitem" class="change-status-link ${colorText}" data-id="${curr.id}" data-value="${curr_}" tabindex="-1" href="javascript: void(0)">${label}</a></li>`;
                        
                        return acc_;
                    }, ``);

                    acc += `<tr>
                        <td>${curr.label}</td>
                        <td>${curr.link}</td>
                        <td>${curr.creator}</td>
                        <td>${curr.createDate}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle dpd-${curr.id} ${colorText}" type="button" id="dpd-${curr.id}" data-toggle="dropdown" aria-expanded="true">
                                ${label}
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dpd-${curr.id}">${options}</ul>
                            </div>
                        </td>
                        <td>
                            <div class="dropdown text-center">
                                <button class="btn btn-link dropdown-toggle" type="button" id="link-option" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="link-option">
                                    <li role="presentation"><a role="menuitem" class="edit-link" tabindex="-1" href="javascript: void(0)" data-id="${curr.id}" data-show-active="false" >Editar</a></li>
                                    <li role="presentation"><a role="menuitem" class="text-danger delete-link" tabindex="-1" href="javascript: void(0)" data-id="${curr.id}">Eliminar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>`;
                    return acc;
                }, ``);

                $(".tbody-link-list").html(tr);
            } else{
                $(".link-list").html(`<h3 class="text-center">Sin enlaces creados por hoy</h3>`);
            }

            $('.table-link-list').DataTable();
        }
    });

}
//-------------------------------
$(".submit-link-data").click(function(){

    const baseUrl = $(".base-url").data("url");
    const formArray =  $("#form-links").serializeArray().reduce((acc, curr) => {

        const indx = curr.name.split("-");
        acc[indx[1]] = curr.value;
        return acc;
    } , {});
    console.log(formArray);

    const ajax = $.ajax({
        type: "POST",
        url: `${baseUrl}persona/createLink`,
        data: {
            link: JSON.stringify(formArray) 
        },
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            
            const response = JSON.parse(data);

            alert(response.message);
            if(response.bool){
                
                $("#form-link").modal("hide");
                window.location.reload();
            }
        }
    });
});
//------------------------------
$(document).on("click", ".edit-link", function(){

    const showActiveOptions = $(this).data("show-active");
    const showDiv = showActiveOptions ? "block" : "none";
    const baseUrl = $(".base-url").data("url");
    const id = $(this).data("id");
    $(".link-active-cont").css("display", showDiv);

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}persona/getOnlyLink`,
        data: {
            id: id
        },
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            
            const response = JSON.parse(data);
            console.log(response);

            for(const a in response.data){
                $(`#link-${a}`).val(response.data[a]);
            }
        }
    });


    $("#form-link").modal({
        show: true,
        backdrop: false,
        keyboard: false,
    });
});
//------------------------------
$(document).on("click", ".delete-link", function(){

    const baseUrl = $(".base-url").data("url");
    const id = $(this).data("id");

    const ajax = $.ajax({
        type: "POST",
        url: `${baseUrl}persona/deleteLink`,
        data: {id: id},
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            
            const response = JSON.parse(data);

            alert(response.message);
            if(response.bool){

                getLinkList();
            }
        }
    });
});
//------------------------------
$(document).on("click", ".change-status-link", function(){

    const baseUrl = $(".base-url").data("url");
    const id = $(this).data("id");
    const value = $(this).data("value");

    const ajax = $.ajax({
        type: "POST",
        url: `${baseUrl}persona/changeLinkStatus`,
        data: {
            id: id,
            value: value
        },
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            
            const response = JSON.parse(data);
            if(response.code == 200){

                $(`.dpd-${id}`).html($(this).text());
                if(value == 0){
                    $(`.dpd-${id}`).addClass("text-danger");
                } else{
                    $(`.dpd-${id}`).removeClass("text-danger");
                }
            }
        }
    });
});
//-----------------------------
$('#form-link').on('hidden.bs.modal', function (e) {
    $("#form-links").trigger("reset");
});
//-----------------------------