$(function(){

    /*$(`.birth-day-collapse`).each(function(){

        var type = $(this).attr("aria-controls");

        if(type == "actual"){
            $(`#${type}`).collapse("show");
            //$(`#${type}`).removeClass("in");
        }
    });*/
});

$(".filterDates").click(function(){

    var month = $("#birthMonth option:selected").val();
    //var day = $("#birthday option:selected").val();
    var baseUrl = $("#base-url").data("url");

    if(month == ""){ // || day == ""
        alert("Seleccione una opción del mes correcto");
        return false;
    }

    $.ajax({
        type: "GET",
        url: `${baseUrl}directorio/getFilterBirthdays`,
        data: {
            a: month,
            //b: day
        },
        beforeSend: function(){

        },
        error: function(error){
            alert(error);
        }, 
        success: function(response){
            var resp = JSON.parse(response);
            //console.log(resp);
            
            var days = resp.days;
            var persons = resp.persons;
            var dayOptions = `<option value="00">SELECCIONE</option>`;
            var cardPersons = ``;
            var months = {
                01: "ENERO",
                02: "FEBRERO",
                03: "MARZO",
                04: "ABRIL",
                05: "MAYO",
                06: "JUNIO",
                07: "JULIO",
                08: "AGOSTO",
                09: "SEPTIEMBRE",
                10: "OCTUBRE",
                11: "NOVIEMBRE",
                12: "DICIEMBRE",
            };

            for(var a in days){

                dayOptions += `<option value="${days[a]}">${days[a]}</option>`;
            }

            for(var b in persons){

                var day_ = persons[b].fechaNacimiento.split("-");
                //console.log(day_);
                cardPersons += `
                    <div class="col-md-3 card-hbd" id="bd-${day_[2]}">
                        <div class="card">
                            <img class="card-img-top" src="${baseUrl}assets/img/miInfo/userPhotos/${persons[b].fotoUser}" alt="Card image cap" >
                            <div class="card-body">
                                <h5 class="card-title">${persons[b].name_complete}</h5>
                                <div class="row">
                                    <div class="col-md-5"><p>${day_[2]} / ${months[parseInt(day_[1])]}</p></div>
                                    <div class="col-md-7"><p></p></div>
                                    <div class="col-md-12"><button class="btn btn-info btn-xs" type="button" data-toggle="collapse" data-target="#${persons[b].idPersona}" aria-expanded="false" aria-controls="${persons[b].idPersona}">Ver datos de contacto</button></div>
                                </div>
                                <div class="collapse table-responsive" id="${persons[b].idPersona}">
                                <br>
                                    <table class="table">
                                        <tbody>
                                            <tr><td>Celular</td><td>${persons[b].celPersonal}</td></tr>
                                            <tr><td>E-mail</td><td>${persons[b].email}</td></tr>
                                            <tr><td>E-mail personal</td><td>${persons[b].emailPersonal}</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            $("#birthday_").html(dayOptions);
            $(".birthdays-container").html(`<div class="card mt-4"><div class="card-header"><h4><a class="btn btn-link birth-day-collapse" data-toggle="collapse" href="#filtered" role="button" aria-expanded="false" aria-controls="filtered">Resultado del filtro<span class="caret"></span> </a></h4></div><div class="card-body collapse show in" id="filtered"><div class="card-group"> <!--hola-->${cardPersons}</div></div></div>`);
        }
    });

    //console.log(month, day);
    console.log("FILTLER_ACTIVATED");
});

//--------------------
$(document).on("change", "#birthday_",function(){

    var value = $(this).val();

    $(".card-hbd").each(function(){

        var id = $(this).attr("id").split("-");

        if(value == id[1] || value == "00"){
            $(this).removeClass("hidden").addClass("show");
        } else{
            $(this).removeClass("show").addClass("hidden");
        }
        //console.log(id);
    });

});
//-------------------
function showModalCongratulations(idPersona){

    console.log(idPersona);
    var baseUrl = $("#base-url").data("url");
    var months = {
        01: "ENERO",
        02: "FEBRERO",
        03: "MARZO",
        04: "ABRIL",
        05: "MAYO",
        06: "JUNIO",
        07: "JULIO",
        08: "AGOSTO",
        09: "SEPTIEMBRE",
        10: "OCTUBRE",
        11: "NOVIEMBRE",
        12: "DICIEMBRE",
    };

    $.ajax({
        type: "GET",
        url: `${baseUrl}directorio/getMyPersonalData`,
        data: {
            a: idPersona
            //b: day
        },
        beforeSend: function(){

        },
        error: function(error){
            alert(error);
        }, 
        success: function(response){
            var resp = JSON.parse(response);
            console.log(resp);
            var happyBirthday = resp.birthday.split("-");
            var employmentLabel = resp.typePerson == 1 ? "Puesto" : "Ranking";

            $(".show-modal-congratulation").html(`<button class="btn btn-info show-congratulation" type="button" data-toggle="modal" data-target=".congratulations">Ver tarjeta de contacto de ${resp.name}</button>`);

            $(".hbd-content").html(`<div class="row">
                <div class="col-md-12"><h4>Felicitemos a nuestro compañero</h4></div>
                <div class="col-md-4 text-center"><img src="${baseUrl}assets/img/miInfo/userPhotos/${resp.photo}" style="width: 100%; height: 100%"></div>
                <div class="col-md-8">
                    <table class="table">
                        <tbody>
                            <tr><td>Nombre</td><td>${resp.name}</td></tr>
                            <tr><td>Fecha de cumpleaños</td><td>${happyBirthday[2]} de ${months[parseInt(happyBirthday[1])]}</td></tr>
                            <tr><td>Email</td><td>${resp.email}</td></tr>
                            <tr><td>Telefono</td><td>${resp.phone}</td></tr>
                            <tr><td>Email personal</td><td>${resp.personalEmail}</td></tr>
                            <tr><td>Área / ${employmentLabel}</td><td>${resp.area} / ${resp.employment}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>`);

            $(".show-congratulation").click();
        }
    })
}
//-------------------