import axios from "axios";

export const CallApiPost = async (Urlpart, params, token) => {
    
    //await IsLoging(token);
    var data = JSON.stringify(params);

    var config = {
        method: 'POST',
        url: `${Urlpart}`,
        headers: {
            //'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        },
        data: data
    };

    const res = await axios(config)
        .then(function (response) {
            return { success: response.data, status: response.status }
        })
        .catch(function (error) {
            return { error: error.response.data, status: error.response.status }
        });
    return res;
}


export const CallApiGet = async (Urlpart, params, token) => {
    //await IsLoging(token);

    var Qparams = new URLSearchParams(params);
    var config = {
        method: 'GET',
        url: `${Urlpart}?${Qparams}`,
        headers: {
            'Authorization': `Bearer ${token}`,
        }
    };

    const res = await axios(config)
        .then(function (response) {
            return { success: response.data, status: response.status }
        })
        .catch(function (error) {
            return { error: error.response.data,  status: error.response.status }
        });
    return res;
}

async function IsLoging(token) {
    var config = {
        method: 'POST',
        url: `${Url}me`,
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        }
    };

    const res = await axios(config)
        .then(function (response) {
            return { success: response.data, status: response.status }
        })
        .catch(function (error) {
            return { error: error.response.data, status: error.response.status }
        });
    
    //let sesion={error: "Error prr", status: 401}

    if(res.status!=200){
        /* $("#backdrop").hide();
        await window.Swal.fire({
            icon: 'warning',
            title: 'La sesion ha finalizado',
            text: "Inicie sesion de nuevo.",
        }); */
        window.localStorage.clear();
        return window.location= `${process.env.URIURL}/`
        //return window.location="/";
    }
    //return res;
}


