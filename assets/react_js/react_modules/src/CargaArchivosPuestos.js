import React from "react";
import  ReactDOM  from "react-dom";
import ButtonUpload from "./components/UploadFiles/ModalUploadFiles.jsx"; //"./components/UploadFiles/UploadFiles.jsx";
var model = {};

window.EmployeeModal = function(content = "", employeeID = 0, permissions = {}){
    this.content = content;
    this.employee = employeeID;
    this.permission = {};
    model = {
        upload: false,
        formats: false,
        requerimentsFile: false,
        jobProfile: false,
    };

    if(typeof permissions === "object"){
        //console.log("is a object");
        this.permission = getAttribute(model, permissions);
    }


    this.setIdEmployee = function(id){
        this.employee = id;
    }
    
    this.setContent = function(container){
        this.content = container;
    }

    this.render = function(){
        console.log("RENDER", this.permission);
        ReactDOM.render(
            <ButtonUpload
                //container = {this.content}
                employee = {this.employee}
                permit = {this.permission}
            ></ButtonUpload>,
            document.querySelector(this.content) //document.getElementById("upload-files-employee")
        );
    }
}

const getAttribute = (newObject, object) => {

    for(var a in object){ // a == list

        if(newObject.hasOwnProperty(a)){

            newObject[a] = object[a];
        }
    }

    return newObject;
}