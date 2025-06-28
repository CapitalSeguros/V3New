import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import GetTimeNow from "../src/components/Asistencia/Asistencia.jsx";

window.onload = () => {

    const baseUrl = window.jQuery(".url").data("url");
    var showModal_ = true;
    //----------- //Get asistence Data
    axios.get(`${baseUrl}fastFile/showModalAsistence`)
    .then((result) => {
        //console.log(result.data);
        showModal_ = result.data.records > 0 ? false : true;

        if(result.data.records == 0){
            showAsistenceModal(null, null);
        }

        //showAsistenceModal(null, showModal_);
    }).catch((err) => {
        console.log(err);
        showAsistenceModal(null, showModal_);
        //return false;
    });
    //-----------
}

const showAsistenceModal = (a, sM) => {

    ReactDOM.render(

        <GetTimeNow 
            asistence = {a}
            showModal = {sM}
    
        ></GetTimeNow>,
        document.querySelector(".modal-asistence-time")
    
    );
}

