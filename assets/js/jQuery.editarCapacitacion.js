var base_url = $(`#base_url`).data("url");

$("#capacitacion").change(function(){

    //console.log($(this).val());
    $.ajax({
        method: "GET",
        url: `${base_url}capacita/gestionCapacitacion`,
        data: {
            a: "sub_capacitacion",
            b: $(this).val()
        }
    }).done(function(data){
        //console.log(data);
        var resp = JSON.parse(data);

        var options = "";

        options += `<option value="0">Seleccione</option>`;

        for(var a in resp){

            options += `
                <option value="${resp[a].id_certificado}">${resp[a].nombreCertificado}</option>
            `;
        }

        $(`#sub-capacitacion`).html(options);
    })
});
//------------------------------
$(`#form-edit`).submit(function(e){

    e.preventDefault();

    var type = $(this).data("form");
    var dataForm = $(this).serializeArray();
    var form_ = new FormData();
    var objSend = {};
    

    if(type == "externo"){
        var fireBase = new Firebase();
        form_.append("archivo", $(`#archivo`)[0].files[0].name);

        for(var a in dataForm){
            form_.append(dataForm[a].name, dataForm[a].value);
        }

        //Para dar de baja en el storage.
        var bajaCapacitacion = $(`#base_url`).data("capacitacion");
        var bajaSubCapacitacion = $(`#base_url`).data("subcapacitacion");
        var bajaRamo = $(`#base_url`).data("ramo");
        var bajaArchivo = $(`#base_url`).data("archivo");
        var bajaPersona = $(`#base_url`).data("idpersona");

        fireBase.archivo = bajaArchivo;
        fireBase.ruta = `/${bajaCapacitacion}/${bajaSubCapacitacion}/${bajaPersona}/${bajaRamo.toLowerCase()}/`;
        fireBase.raiz = `registroCapacitacionesExternas`;
        fireBase.eliminaArchivo;

        //Para subir al storage.
        var capacitacion_ = $("#capacitacion option:selected").text(); 
        var subCapacitacion_ = $("#sub-capacitacion option:selected").text();
        var ramo_ = $("#ramo option:selected").text();
        var idPersona_ = $("#base_url").data("idpersona");
        //var archivo_ = $(`#archivo`)[0].files[0].name;

        fireBase.archivo = $(`#archivo`)[0].files[0].name;
        fireBase.ruta = `/${capacitacion_}/${subCapacitacion_}/${idPersona_}/${ramo_.replace("DAñOS", "danios").toLowerCase()}/`;
        fireBase.raiz = `registroCapacitacionesExternas`;
        fireBase.datoArchivo = $(`#archivo`)[0].files[0];
        fireBase.subirArchivo;

    } else if(type == "interno"){

        var formSerialize = $(this).serializeArray();
        
        for(var a in formSerialize){
            objSend[formSerialize[a].name] = formSerialize[a].value;
        }

        var res_ = [];
        //$(`${this} input:checked`)
       $("#form-edit input:checked").each(function(){
            if($(this).data("responsable") == "nuevo"){
                res_.push($(this).val());
            }
       });
       objSend["responsables"] = res_;
       //console.log(objSend);
    }
    //console.log($(`#archivo`)[0].files[0]);
    //console.log(fireBase.muestraEnConsola);

    $.ajax({
        method: "POST",
        url: `${base_url}capacita/${type == "externo" ? `actualizaRegistro` : `actualizaRegistroInterno`}`,
        data: type == "externo" ? form_ : { dataSend: JSON.stringify(objSend)},
        processData: type == "externo" ? false : true,
        contentType: type == "externo" ? false : "application/x-www-form-urlencoded; charset=UTF-8",
        beforeSend: function(){

            if(type == "externo"){
                $(`.actualizaInformacion`).html(`
                    <p class="text-info">Actualizando información de capacitación...</p>
                `);
            }
        }
    }).done(function(data){

        var res = JSON.parse(data);
        console.log(res);
        if(res.update){

            if(type == "externo"){
                $(`.actualizaInformacion`).html(`
                    <p class="text-success">Registro actualizado correctamente <i class="fa fa-check" aria-hidden="true"></i></p>
                `);
                $(`.completado`).html(`
                    <p class="text-success">Proceso completado <i class="fa fa-check" aria-hidden="true"></i></p>
                `);
            } else{
                window.location.href =`${base_url}capacita/reporteDeCapacitacionManual`;
            }
        }

    })
});
//-------------------------------
$(document).on("click", ".add", function(e){

    e.preventDefault();
    //console.log("agree");
    var value = $("#responsable_ option:selected").val();
    var text = $("#responsable_ option:selected").text();

    if(value == 0){
        alert("seleccionó una opción invalida");
        return false;
    }
    var nameExplode = text.split(" (");
    var tr = $(`<tr class="${value}">
        <td class="text-center"><input type="checkbox" value="${value}" data-responsable="nuevo" name="responsable[]" id="resposable-${value}" checked disabled></td>
        <td>${nameExplode[0]}</td><td>${nameExplode[1].replace(")", "")}</td>
        <td class="text-center"><a class="text-danger delete" data-id="${value}" href="javascript: void(0)">Eliminar</a></td>
    </tr>`);
    var idExists = [];

    $("#form-edit input:checked").each(function(){

        idExists.push($(this).val());
    });

    //console.log(idExists);
    if(!idExists.includes(value)){
        $("#table-responsable tbody").append(tr);
    } else{
        alert("El responsable seleccionado ya se encuentra en la tabla");
        return false;
    }
});

//-------------------------
$(document).on("click", ".delete", function(e){

    e.preventDefault();
    var id = $(this).data("id");
    var check = $(`#resposable-${id}`).val();
    var band = $(`#resposable-${id}`).data("responsable");
    var record = $(this).data("register");
    //var record = $(`#idRegistro`).val();

    if(band == "nuevo"){
        $(`#table-responsable tbody`).find(`tr`).remove(`.${check}`);
    } else if(band == "noNuevo"){

        $.ajax({
            method: "POST",
            url: `${base_url}capacita/deleteResponsableRecord`,
            data: {
                q: record
            },
            error: function(error){
                alert(error);
            },
            success: function(data){
                console.log(data);
                var res = JSON.parse(data);

                if(res.delete){
                    $(`#table-responsable tbody`).find(`tr`).remove(`.${check}`);
                }
            }
        })
    }

    console.log(check, band);

});
//----------- Uso de clase por que si-------------------
class Firebase {

    constructor(archivo = "", ruta = "", raiz = "", datoArchivo = {}){
        this._archivo = archivo;
        this._ruta = ruta;
        this._datoArchivo = datoArchivo;
        //this.rutaPadre = rutaPadre;
        this._raiz = raiz;
        this.configuracion = {
            apiKey: "AIzaSyBa6S-7_FtZE_cMxNz33e1Tvil3PGnON_4",
            authDomain: "v3plus-279402.firebaseapp.com",
            databaseURL: "https://v3plus-279402.firebaseio.com",
            projectId: "v3plus-279402",
            storageBucket: "v3plus-279402.appspot.com",
            messagingSenderId: "4568272251",
            appId: "1:4568272251:web:483a7b036920897138c1de",
            measurementId: "G-8EJP31SQZ7"
        };

        firebase.initializeApp(this.configuracion);
        this.storage = firebase.storage();
        this.auth = firebase.auth();
    }

    autentica(){
        this.auth.signInAnonymously().then(() => {

        }).catch((error) =>{

           console.log(error.code);
           console.log(error.message);
        
        });
    }

    set archivo(val){
        this._archivo = val;
    }

    set ruta(val){
        this._ruta = val;
    }

    set raiz(val){
        this._raiz = val;
    }

    set datoArchivo(val){
        this._datoArchivo = val;
    }

    get eliminaArchivo(){

        var archivoRef = this.storage.ref();
        var rutaRaiz = archivoRef.child(this._raiz);
        var subRuta = rutaRaiz.child(this._ruta);
        var file = subRuta.child(this._archivo);

        var success = false;
        var message = ""

        file.delete().then(() => {
            
            $(`.bajaArchivo`).html(`<p class="text-success">Archivo anterior ha sido dado de baja. <i class="fa fa-check" aria-hidden="true"></i></p>`);

        }).catch((error) => {

            //alert(`Se generó un error al eliminar el archivo:\nError: ${error.code}\nMensaje: ${error.message}`);
            $(`.bajaArchivo`).html(`<p class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Se generó un error al eliminar el archivo:\nError: ${error.code}\nMensaje: ${error.message}</p>`);
        });

        return false;
    }

    get subirArchivo(){

        var archivoRef = this.storage.ref();
        var rutaRaiz = archivoRef.child(this._raiz);
        var subRuta = rutaRaiz.child(this._ruta);
        var file = subRuta.child(this._datoArchivo.name); //this._archivo

        var uploadTask = file.put(this._datoArchivo);
        uploadTask.on(`state_changed`,
            function(snapshot){
                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                $(`.subidaArchivo`).html(
                    `<p class="text-info">Subiendo archivo a la nube: </p>
                    <div class="progress col-md-4">
                        <div class="progress-bar" role="progressbar" style="width: ${progress}%;" aria-valuenow="${Math.round(progress).toLocaleString("es-US")}" aria-valuemin="0" aria-valuemax="100">${progress}%</div>
                    <div>
                    `
                );
            },
            function(error){
                $(`.subidaArchivo`).html(
                    `<p class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Se generó un error al subir el archivo:\nError: ${error.code}\nMensaje: ${error.message}</p>`
                );
            },
            function(){
                //uploadTask.snapshot.ref.getDownloadURL
                $(`.subidaArchivo`).html(`<p class="text-success">El archivo nuevo se ha subido con éxito. <i class="fa fa-check" aria-hidden="true"></i></p>`);

                var confirm = window.confirm("Proceso de actualización completado. Se recargará la página");
                if(confirm){
                    setTimeout(function(){
                        window.location.href =`${base_url}capacita/reporteDeCapacitacionManual`;
                    }, 2000);
                }
            }
        );

        return false;
    }

    get muestraEnConsola(){
        return `parametro1: ${this._archivo}, parametro2: ${this._ruta}, parametro3: ${this._raiz}`;
    }
}