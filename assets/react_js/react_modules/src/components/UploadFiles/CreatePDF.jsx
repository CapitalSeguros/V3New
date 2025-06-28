import React, {useState, useEffect} from "react";
import ReactDOMServer, { renderToString } from 'react-dom/server';
import { ReactDOM } from "react";
import axios from "axios";
import $ from "jquery";
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import dompurify from 'dompurify';

const CreatePDF = (props) => {

    const baseUrl = $("#base_url").data("base-url");
    const [allDivs, setAllDivs] = useState({});
    const [showInfo, setShowInfo] = useState([]);
    const [employeeName, setEmployeeName] = useState("");
    const [area, setArea] = useState("");
    //console.log(props.employee);
    useEffect(() => {

        getEmployeeInfo(props.employee);
        $(".upload-modal-title").html(props.title);
    }, []);

    //----------------------------
    const getEmployeeInfo = async (id) => {

        const axios_ = await axios.get(`${baseUrl}capitalHumano/getAllEmployeeInfo`, {
            params: { dni: id }
        });
        //console.log(axios_);

        const divsObjects = axios_.data.reduce((acc, curr) => {

            return { ...acc, [curr.idDivContenedor]: curr.contenido }
        }, {});

        const showInfo_ = axios_.data.map(arr => {
            return { 
                div: arr.idDivContenedor,
                label: arr.descriptionName,
                show: false
            }
        });

        setAllDivs(divsObjects);
        setShowInfo(showInfo_);
        setEmployeeName(axios_.data[0].personaPuesto);
        setArea(axios_.data[0].colaboradorArea);
        //console.log(showInfo_);
        //console.log(divsObjects);

    }

    //----------------------------
    const changeShow = (event) => {

        const value = event.target.value;
        const checked = event.target.checked;
        const newArray = showInfo.map(arr => {

            if(arr.div == value){
                arr.show = checked;
            }

            return arr;
        });

        setShowInfo(newArray);
    }

    //----------------------------
    const generatePDFFIle = (event) => {

        var HTML_Width = $("#pdf-content").width();
		var HTML_Height = $("#pdf-content").height();
		var top_left_margin = 15;
		var PDF_Width = HTML_Width+(top_left_margin*2);
		var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
		var canvas_image_width = HTML_Width;
		var canvas_image_height = HTML_Height;

        const pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]); // [PDF_Width, PDF_Height]
        pdf.html(document.getElementById("pdf-content"), {
            //html2canvas: {width: 5},            
            callback: (doc) => {
                doc.save("perfil_del_puesto.pdf");
            },
            margin: [5, 0, 50, 0],
            autoPaging: "text",
            dompurify: dompurify,
        })

        /*var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;
        html2canvas(document.getElementById("pdf-content")).then(function(canvas) {
			canvas.getContext('2d');
			
			console.log(canvas.height+"  "+canvas.width);
			
			
			var imgData = canvas.toDataURL("image/jpeg", 1.0);
			var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
		    pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
			
			
			for (var i = 1; i <= totalPDFPages; i++) { 
				pdf.addPage(PDF_Width, PDF_Height);
				pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
			}
			
		    pdf.save("HTML-Document.pdf");
        })*/

    }
    /*const generatePDFFIle = (event) => {
        
        console.log("CREATE_PDF");

        const HTMLWIDTH = $("#pdf-content").width();
        const HTMLHEIGHT = $("#pdf-content").height();
        const topLeft = 15;
        const pdfWidth = HTMLWIDTH + (topLeft * 2);
        const pdfHeight = (HTMLWIDTH * 1.5) + (topLeft * 2);
        const canvasImageWidth = HTMLWIDTH;
        const canvasImageHeight = HTMLHEIGHT;
        const totalPdfImages = Math.ceil(HTMLHEIGHT / pdfHeight) - 1;

        html2canvas($(".pdf-content"), {allowTaint:true}).then((canvas) => {

            //canvas.getContext("2d");
            console.log(canvas.height+"  "+canvas.width);

            const imgData = canvas.toDataURL("image/png");
            var pdf = new jsPDF('p', 'pt',  [pdfWidth, pdfHeight]);
            pdf.addImage(imgData, 'JPG', topLeft, topLeft, canvasImageWidth, canvasImageHeight);

            for(var i = 1; i <= totalPdfImages; i++){
                pdf.addPage(pdfWidth, pdfHeight);
                pdf.addImage(imgData, 'JPG', topLeft, -(pdfHeight * i) + (topLeft * 4), canvasImageWidth, canvasImageHeight);
            }

            pdf.save("HTML-Document.pdf");
        });
    }*/
    //----------------------------
    return (
        <React.Fragment>
            <div className="col-md-12">
                <div className="panel panel-body">
                    <div className="row">
                        <div className="col-md-7"><h5>Seleccione una o varias opciones para pre-visualizar el PDF</h5></div>
                        <div className="col-md-4">
                            <div className="dropdown">
                                <button className="btn btn-primary dropdown-toggle" type="button" id="dpd-pdf" data-toggle="dropdown" aria-expanded="true">
                                    Descriptivos del puesto
                                </button>
                                <ul className="dropdown-menu" role="menu" aria-labelledby="dpd-pdf">
                                    {
                                        showInfo.map(arr => 
                                            <li role="presentation">
                                                <a href="javascript: void(0)" role="menuitem" tabIndex="-1">
                                                    <div className="row">
                                                        <div><input type="checkbox" onChange={changeShow.bind(this)} checked={arr.show} name="checkshow[]" id={`check-${arr.div}`} value={arr.div} /></div>
                                                        <div className="col-md-10">{arr.label.toUpperCase()}</div>
                                                    </div>
                                                </a>
                                            </li>
                                        )
                                    }
                                </ul>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
            <div className="col-md-12">
                {
                    showInfo.filter(arr => arr.show == true).length > 0 &&
                    <React.Fragment>
                        <div style={{width: "100%", height: "450px", overflowY: "auto", marginBottom: "15px"}}>
                            <div id="pdf-content" className="col-md-12">
                                <div style={{width: "100%"}}>
                                    <div style={{width: "40%", verticalAlign: "top", display:"inline-block"}}>
                                        <img src={`${baseUrl}assets/img/logo/logocapital.png`} alt="Capital Seguros Y Fianzas" style={{height: 100}}/>
                                    </div>
                                    <div style={{width: "60%", verticalAlign: "top", display:"inline-block"}}><p className="float-right" style={{marginTop: 45}}><b>PERFILES DEL PUESTO AREA {area.toUpperCase()}</b></p></div>
                                </div>
                                <div className="text-center mb-4"><h3 style={{color: "black"}}>{employeeName.toUpperCase()}</h3></div>
                                {
                                    showInfo.filter(arr => arr.show == true).map(arr => 
                                        <div className="container-pdf">
                                            <div className="panel panel-default mb-4" style={{border: "1px black solid"}}>
                                                <div className="panel-heading" style={{backgroundColor: "black", color: "white"}}><h5>{arr.label.toUpperCase()}</h5></div>
                                                <div className="panel-body" style={{color: "black"}} dangerouslySetInnerHTML={{__html: allDivs[arr.div]}}></div>
                                            </div>
                                        </div>
                                    )
                                }
                            </div>
                        </div>
                    </React.Fragment>
                }
                {
                    showInfo.filter(arr => arr.show == true).length > 0 &&
                    <div className="col-md-12 text-center">
                        <button className="btn btn-primary" onClick={generatePDFFIle.bind(this)}>Descargar como fichero PDF</button>
                    </div>
                }
            </div>
        </React.Fragment>
    );

}

export default CreatePDF;