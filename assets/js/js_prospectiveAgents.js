
//jQuery.

$(document).on("click", ".agreeAssing", function(e){

    e.preventDefault();
    console.log(`execute assign button`);
    var baseURL = $(`#base_url`).data(`url`);
    var form_ = new FormData();
    form_.append("account", $(`#newAssign`).val());

    if($(`#newAssign`).val() == ""){
        alert("Es requerido una cuenta para asignar al prospecto");
        return false;
    }

    axios({
        method: `POST`,
        url: `${baseURL}crmproyecto/assignAccount`,
        headers: { 
            "Content-Type": "multipart/form-data" 
        },
        data: form_,
    }).then(function(response){
        console.log(response.data);

        var resp = response.data;

        if(resp.message !== ""){
            alert(resp.message);
            return false;
        } else{
            $(`#asignado`).html();

            var option = resp.accounts.reduce((acc, curr) => acc += `<option value="${curr}">${curr}</option>`, ``);
            $(`#asignado`).html(`<option value="">SELECCIONE</option>` + option);
        }

    }).catch(function(error){
        console.log(error);
    });
});