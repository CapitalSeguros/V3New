import React, { useEffect, useState } from "react";
import axios from "axios";
import { renderToString } from "react-dom/server";
import { render } from "react-dom";

const GetTimeNow = (props) => {

    const timeDefault = new Date();
    const [timeHourNow, setTimeHourNow] = useState(timeDefault.toLocaleTimeString());
    const [timeDateNow, setTimeDateNow] = useState(timeDefault.toLocaleDateString());
    const [timeNumber, setTimeNumber] = useState(null);
    const [month, setMonth] = useState(timeDefault.getMonth + 1);
    const [checkHour, setCheckHour] = useState(``);
    const [checkTimeNumber, setCheckTimeNumber] = useState(null);
    const [checkPunctuality, setCheckPunctuality] = useState(null);
    const [showMyAsistence, setShowMyAsistence] = useState(false);
    const [showLate, setShowLate] = useState(false);
    const [applyShowModal, setApplyShowModal] = useState(false); //true
    const [showButtonSuccess, setShowButtonSuccess] = useState(true);
    const [loadSuccess, setLoadSuccess] = useState(true);
    const [showSupport, setShowSupport] = useState(false);
    const [stopInterval, setStopInterval] = useState(false);
    const baseUrl = window.jQuery(".url").data("url");
    let intervalid;
    const months = {
        1: "ENERO",
        2: "FEBRERO",
        3: "MARZO",
        4: "ABRIL",
        5: "MAYO",
        6: "JUNIO",
        7: "JULIO",
        8: "AGOSTO",
        9: "SEPTIEMBRE",
        10: "OCTUBRE",
        11: "NOVIEMBRE",
        12: "DICIEMBRE",
    }

    useEffect(() => {
        console.log("RENDER", stopInterval);

        if(!stopInterval){ //Se ejecuta de todas formas.
            intervalid = setInterval(() => {
                getTimeNow();
            }, 1000);
        }
        
        return () => clearInterval(intervalid); //Se ejecuta de todas formas.
        
    }, [stopInterval]);

    const getTimeNow = () => {

        axios.get(`https://worldtimeapi.org/api/timezone/America/Mexico_City`)
        .then((data) => {
    
            const timedata = data.data.datetime;
            const onlyTime = new Date(timedata);
            setTimeDateNow(onlyTime.toLocaleDateString());
            setTimeHourNow(onlyTime.toLocaleTimeString());
            setMonth(onlyTime.getMonth() + 1);
            setTimeNumber(data.data.unixtime);

            console.log(onlyTime);
            const validateHour = onlyTime.toLocaleTimeString().split(":");
            const lateApply = validateHour[0] >= 9 && validateHour[1] >= 1 ? true : false;
            let enableConfirm = false;
            //const enableConfirm = (validateHour[0] >= 17 && validateHour[1] >= 8) || (validateHour[0] <= 18 && validateHour[1] <= 21) ? true : false;

            if(validateHour[0] == 8 && validateHour[1] >= 30){
                enableConfirm = true;
                
            } else if(validateHour[0] == 9 && validateHour[1] < 30){
                enableConfirm = true;
            }
            stoppingAll(validateHour[0], validateHour[1]);
            setShowLate(lateApply);

            if(enableConfirm){
                window.jQuery("#check-asistence").modal({
                    show: true,
                    keyboard: false,
                    backdrop: false
                });
            }
        })
        .catch((error) => {
          console.log(error);
          clearInterval(intervalid);
          setLoadSuccess(false);
          //setApplyConfirm(true);
          window.jQuery("#error-note").html(error);
        });
    }

    const saveMyAsistence = (e) => {

        const formdata_ = new FormData();
        console.log("TIME-HOUR: ", timeHourNow);
        const validateHour = timeHourNow.split(":");
        const myPunctuality = checkMyPuctuality(parseInt(validateHour[0]), parseInt(validateHour[1]));
        setCheckHour(timeHourNow);
        setCheckPunctuality(myPunctuality);

        formdata_.append("timeNumber", timeNumber);
        formdata_.append("punctuality", myPunctuality ? 1 : 0);

        axios.post(`${baseUrl}fastFile/takeMyAsistence`, formdata_)
        .then((response) => {
            console.log(response.data)

            if(response.data.bool){
                setShowMyAsistence(true);
                setShowButtonSuccess(false);
            }
        })
        .catch((error) => {
            console.log(error)
        });
    }

    const stoppingAll = (hour, minute) => {

        if((hour == 9 && minute >= 30) || hour > 9){
            window.jQuery("#check-asistence").modal("hide");
            setStopInterval(true);
        }
    }

    const checkMyPuctuality = (hour, minute) => {

        let response = false;
        const minutesArray1 = [];
        const minutesArray2 = [0];

        for(var a = 30; a <= 59; a++){
            minutesArray1.push(a);
        }

        switch(hour){
            case 8:
                if(minutesArray1.includes(minute)){
                    response = true;
                }
            break;
            case 9:
                if(minutesArray2.includes(minute)){
                    response = true;
                }
            break;
            //case 10:
                //if([36,37,38,39,40].includes(minute)){
                    //response = true;
                //}
            //break;
            default: response;
        }

        return response;
    }

    //console.log(applyConfirm);
    const splitDate = timeDateNow.split("/");
    return (
        <div className="modal fade" id="check-asistence" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div className="modal-dialog">
                <div className="modal-content">
                <div className="modal-header">
                    <h4 className="modal-title" id="myModalLabel">Asistencia</h4>
                    {
                        //<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    }
                </div>
                <div className="modal-body body-time">
                    <div className="alert alert-info" role="alert">
                        <h4>Confirma tu hora de asistencia.</h4>
                        <ul>
                            <li>La asistencia se toma a partir de las 08:30 hrs</li>
                            <li>Es retardo a partir de las 09:01:00 hrs</li>
                            <li>Esta ventana avisa en cuanto ya es retardo.</li>
                            <li>Si la asistencia no se ha confirmado antes de las 9:30 hrs, la ventana se cerrará y lo tomará como falta</li>
                        </ul>
                    </div>
                    {loadSuccess ? 
                    
                        <React.Fragment>
                            <div className="col-md-12 border">
                        
                                <div className="mt-3"><p style={{fontSize: "17px", color: "#808B96"}}>Fecha de hoy: <b>{splitDate[0]} de {months[splitDate[1]]} del {splitDate[2]}</b></p></div>
                                <div><p style={{fontSize: "17px", color: "#808B96"}}>Hora actual: <b>{timeHourNow} hrs</b> {showLate && <span className="label label-danger">Usted tiene retardo</span>} </p></div>
                            </div>
                            {showMyAsistence && 
                                <div className={`col-md-12 mt-4`}>
                                    <p style={{fontSize: "17px", color: "#2C3E50", textAlign: "center"}}>Se ha confirmado su asistencia de hoy: {checkHour} hrs</p>
                                    <p style={{fontSize: "17px", color: "#2C3E50", textAlign: "center"}}>Gracias por su participación</p>
                                </div>
                            }
                            { showSupport && 
                                <div className="col-md-12 mt-2" style={{padding: "0px"}}>
                                    <a className="btn btn-link btn-sm text-dark mb-2" data-toggle="collapse" href="#send-comment" aria-expanded="false" aria-controls="send-comment">
                                        Informar problemas
                                    </a>
                                    <div className="collapse" id="send-comment">
                                        <textarea name="bug-comment" id="bug-comment" cols="30" rows="4" className="form-control input-sm mb-2" placeholder="Describa el problema que tuvo con la asistencia. Ejemplo: El tiempo esta desfasdo"></textarea>
                                        <button className="btn btn-info btn-sm pull-right" onClick={sendComment.bind(this)}>Enviar comentario</button>
                                    </div>
                                </div>
                            }
                        </React.Fragment>

                        : <div className="col-md-12 border"><h3 className="text-danger text-center">Ocurrio un error. Favor de notificar al departamento de sistemas. <span id="error-note"></span> </h3></div>
                    }
                </div>
                    <div class="modal-footer">
                        {showButtonSuccess ? 
                            <button type="button" className="btn btn-primary" onClick={saveMyAsistence.bind(this)}>Confirmar asistencia</button>                            
                            :
                            <button type="button" class="btn btn-default" data-dismiss="modal" onClick={() => {console.log("Entra aquí render"); setStopInterval(true); }}>Cerrar</button>
                        }
                    </div>
                </div>
            </div>
        </div>
    )
}

export default GetTimeNow;