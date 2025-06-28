<!-- Modal Endosos de Documento -->
<div class="modal fade docs-centrodigital-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Se puede usar el modal para otra información pero solo si se desocupa este espacio -->
            <div class="modal-header column-select" style="height:40px;">
                <h4 class="title-result">Centro Digital</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
            </div>
            <!-- <div class="content-solicitudes-y-polizas"></div> -->
            <div class="modal-body modal-body-docs-centrodigital" style="background: #f9f9f9; height: 400px;">
                <div class="col-md-6 content-cd">
                    <div class="segment-p-centrodigital" id="CDDoc" style="height:auto; padding-bottom:0px;"></div>
                    <div class="segment-p-centrodigital" id="CDCli" style="height: auto;"></div>
                </div>
                <div class="col-ms-6 content-cd" style="background: #f9f9f9;">
                    <iframe class="VisorArchivos" id="ViewDocCD" src="" frameborder="0"></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-list" onclick="InsertDocCD()">Insertar</button>
                <button type="button" class="btn btn-default close-list" data-dismiss="modal" onclick="ClearDocDC()">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function ModalDocsCD(IDCliente) {
        var IDValuePK = IDCliente;
        var TypeDestinoCDigital = "CLIENT";
        var ActionCDigital      = "GETFiles";

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>actividades/digitalAct",
            data: {
                "TypeDestinoCDigital"   : TypeDestinoCDigital,
                "IDValuePK"             : IDValuePK,
                "ActionCDigital"        : ActionCDigital,
            },
            success: (data) => {
                let datos=JSON.parse(data);
                let doc='';
                let abierto=false;
                let level='';
                let file = '';
                const info = datos['documentos'];
                $('#CDCli').html("");
                $('#SpinnerDocCD').html("");
                $('#FileCD').prop('disabled',false);
                //console.log(datos);

                if (info.text != "No cuenta con documentos") {
                    let c=datos.documentos.children;
                    let total=c.length;
                    let arrayDoc=[];
                    let docs=[];
                    let bandEntrada=true;
                    let nivelAnt=0;
                    let idAnterior=0;idPadre=0;
                    idAnterior=0;nivelAnt=0;bandEntrada=false;
                    let nivelMaximo=0;

                    // CLASIFICA CARPETAS Y HEREDA EL IDPADRE
                    for(let i=0;i<total;i++) {
                        //Carpetas con sus documentos
                        if(c[i].isFolder) {
                            if(c[i].level>nivelMaximo) {
                                nivelMaximo=c[i].level;
                            }
                            if(c[i].level>nivelAnt) {
                                idPadre=idAnterior;
                            }
                            else {
                                if(c[i].level<=nivelAnt){                                        
                                    let cantRevers=arrayDoc.length-1;
                                    for(let j=cantRevers;j>0;j--) {
                                        if(c[i].level==arrayDoc[j][1]) {                                               
                                            idPadre=arrayDoc[j][3];
                                            j=-1;
                                        }
                                    }
                                }          
                            }
                            let a=[i,c[i].level,c[i].text,idPadre];
                            arrayDoc.push(a);
                            nivelAnt=c[i].level;
                            idAnterior=i;
                        }
                        //Documentación suelta
                        if (c[i].isFolder == false) {
                            if(c[i].level>nivelMaximo) {
                                nivelMaximo=c[i].level;
                            }
                            if(c[i].level>nivelAnt) {
                                idPadre=idAnterior;
                            }
                            else {
                                if(c[i].level<=nivelAnt){                                        
                                    let cantRevers=docs.length-1;
                                    for(let j=cantRevers;j>0;j--) {
                                        if(c[i].level==docs[j][1]) {                                               
                                            idPadre=docs[j][3];
                                            j=-1;
                                        }
                                    }
                                }          
                            }
                            let a=[i,c[i].level,c[i].text,idPadre];
                            docs.push(a);
                            nivelAnt=c[i].level;
                            idAnterior=i;
                        }
                    }

                    //LE AGREGA LOS RESPECTIVOS DOCUMENTOS A CADA CARPETA
                    // c=ES TODO EL ARREGLO DE SICAS
                    // arrayDoc= SON LAS CARPETAS QUE TIENE c                     
                    cant=arrayDoc.length;
                    let liA='';
                    for(let i=0;i<cant;i++) {
                        //doc+=`<ul><li class="digitalSicas" href=".carpeta">${c[arrayDoc[i][0]].text}</li>`;
                        let incrementador=arrayDoc[i][0]+1;
                        //console.log('entre')
                        try {   
                            let li='';
                            let salida=0;
                            let bandFolder=false;
                            liA='';
                            let nivelIgual=(arrayDoc[i][1]);
                            nivelIgual++;
                            //if(incrementador<total){
                            let salidaWhile=0;
                            while((c[incrementador].level)==nivelIgual) {
                                if(!c[incrementador].isFolder) {
                                    bandFolder=true;
                                    li+=`<li class="digitalSicas drophover">
                                            <i class="fa fa-file icon-file-cd" aria-hidden="true"></i>
                                            <span class="item-doc-cd-email dropbtn" href="${c[incrementador].href}" data-name="${c[incrementador].text}" onclick="SelectDocCD(this)" target="_blank" style="cursor: pointer;">${c[incrementador].text}</span>
                                            <div class="dropdown-menu drop-content" aria-labelledby="navbarDropdown">
                                                <span class="dropdown-item dropitem" href="${c[incrementador].href}" onclick="ViewDocuments(this)">Vista previa</span>
                                            </div>
                                        </li>`;
                                }
                                if(incrementador==(total-1)){
                                    break;
                                }
                                incrementador++; 
                            }
                            (li=='')? arrayDoc[i][4]='':arrayDoc[i][4]=`<ul style="list-style-type: decimal;">${li}</ul>`;
                        }
                        catch(error){
                            //console.log(error);
                        }
                    }
                                
                    //CONCATENA SUBCARPETAS CON LA CARPETA DE NIVEL 1
                    while(nivelMaximo>1) {
                        for(let i=0;i<cant;i++) {
                            if(arrayDoc[i][1]==nivelMaximo) {
                                let subFolder='';
                                for(let j=0;j<total;j++) {
                                    if(arrayDoc[i][3]==arrayDoc[j][0]) {
                                        var arrayDoc4 = "";
                                        //arrayDoc[j][4]+=`<ul><ul><li class="digitalSicas" href=".carpeta">${arrayDoc[i][2]}</li></ul>${arrayDoc[i][4]}</ul>`;
                                        if (arrayDoc[i][4] == undefined) {
                                            arrayDoc4 = "";
                                        }
                                        else {
                                            arrayDoc4 = arrayDoc[i][4];
                                        }
                                        arrayDoc[j][4]+=`
                                        <div class="divContenedorCarpeta">
                                            <div class="pop-up-modal divContenedorBotonTitulo">
                                                <button class="btn-despliegue collapsed" data-toggle="collapse" data-target="#${i}" aria-expanded="true" onclick="ocultarHijosFolder(event,this)">▼</button>
                                                <div class="namefolder">
                                                    <i class="fa fa-folder icon-folder-cd" aria-hidden="true"></i>`+arrayDoc[i][2]+`
                                                    <ul class="items-folder collapse collapse-horizontal collapse in" id="${i}" aria-expanded="true">`+arrayDoc4+`</ul>
                                                </div>
                                            </div>
                                        </div>`;
                                        j=total;
                                    }
                                }
                            }
                        }
                        nivelMaximo--;
                    }
                    //=================
                    cant=arrayDoc.length;
                    doc='';

                    //IMPRIME ARBOL
                    for(let i=0;i<cant;i++) {
                        var arrayDoc4 = "";
                        if (arrayDoc[i][4] == undefined) {
                            arrayDoc4 = "";
                        }
                        else {
                            arrayDoc4 = arrayDoc[i][4];
                        }

                        if(arrayDoc[i][1]=="1") { //El cero marca un tipo de documentación if(arrayDoc[i][3]=="0")
                            doc+=`
                                <div class="divContenedorCarpeta">
                                    <div class="divContenedorBotonTitulo">
                                        <button class="btn-despliegue collapsed" data-toggle="collapse" data-target="#${i}" aria-expanded="true" onclick="ocultarHijosFolder(event,this)">▼</button>
                                        <div class="namefolder">
                                            <i class="fa fa-folder icon-folder-cd" aria-hidden="true"></i>`+arrayDoc[i][2]+`
                                        </div>
                                        <ul class="items-folder collapse collapse-horizontal collapse in" id="${i}" aria-expanded="true">`+arrayDoc4+`
                                        </ul>
                                    </div>
                                </div>`;
                        }
                        //console.log("Carpetas: " + arrayDoc[i][1], arrayDoc[i][2], arrayDoc[i][3]);
                    }
                    //console.log(arrayDoc);                        
                    //document.getElementById('CentroDigitalCli').innerHTML=doc;

                    const count = docs.length;
                    file = '';

                    //Documentos sin carpeta
                    for(let i=0;i<count;i++) {
                        let increase = docs[i][0];
                        if(docs[i][1] == "1" && docs[i][1] != 0) {
                            file += `
                                <div class="divContenedorCarpeta">
                                    <div class="divContenedorBotonTitulo">
                                        <div class="items-folder drophover">
                                            <i class="fa fa-file icon-file-cd" aria-hidden="true"></i>
                                            <span class="item-doc-cd-email dropbtn" href="${c[increase].href}" data-name="${c[increase].text}" onclick="SelectDocCD(this)" target="_blank" style="cursor: pointer;" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false">${c[increase].text}</span>
                                            <div class="dropdown-menu drop-content-bottom" aria-labelledby="navbarDropdown">
                                                <span class="dropdown-item dropitem" href="${c[increase].href}" onclick="ViewDocuments(this)">Vista previa</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        }
                        else {
                            file += ``;
                        }
                        //console.log("Documentos: " + docs[i][1], docs[i][2], docs[i][3]);
                    }
                }
                else {
                    doc += `
                        <div class="col-md-12 btc-client-sinR">
                            <h4>${info.text}</h4>
                        </div>`;
                    file += ``;
                }
                $('#CDDoc').html(file);
                $('#CDCli').html(doc);
                
            },
            error: (error) => {
                console.log("Error al tratar de encontrar la información.");
            }
        })
    }

    function SelectDocCD(object) {
        if ($(object).hasClass('selectCD')) {
            $(object).removeClass('selectCD');
        }
        else {
            $(object).addClass('selectCD');
        }
    }

    function ClearDocDC() {
        const select = document.getElementsByClassName('selectCD');
        if ($(select).hasClass('selectCD')) {
            $(select).removeClass('selectCD');
        }
    }

    function ViewDocuments(object) {
        let href = object.getAttribute('href');
        let ref = href.slice((href.lastIndexOf(".") - 1 >>> 0) + 2);
        ref = ref.toUpperCase();

        if(ref=='XLS' || ref=='XLSX' || ref=='DOC' || ref=='DOCX' || ref=='XLSM' ) {               
            document.getElementById('ViewDocCD').setAttribute('src','//view.officeapps.live.com/op/embed.aspx?src='+href);
        }
        else if(ref=='XML' || ref=='PDF' ) {  
            document.getElementById('ViewDocCD').setAttribute('src','https://docs.google.com/gview?url='+href+'&id=explorer&efh=false&a=v&chrome=false&embedded=true');
        }
        else if(ref=='TXT' || ref=='JPG' || ref=='PNG' || ref=='JPEG') {
            document.getElementById('ViewDocCD').setAttribute('src',href);
        }
    }

    function InsertDocCD() {
        const tipo = document.getElementById('TipoCorreo').innerHTML;
        const type = document.getElementById('TipoDocEnvio').innerHTML;
        const body = document.getElementById('TextBodyEmail').innerHTML;
        const select = document.getElementsByClassName('selectCD');
        let link = [];
        /*const segment = `
            <div id="TextDocDownload" style="padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;">
                <h4 id="TextInfoDown" style="font-size:13px;">Archivos descargables:</h4>
            </div>`;

        if (type == 0) {
            if (tipo == 1) {
                const tip1 = document.getElementById('TextBodyEmail').innerHTML;
                document.getElementById('TextBodyEmail').innerHTML = tip1 + segment;
            }
            else if (tipo == 2) {
                const tip2 = document.getElementById('TextBodyEmail').innerHTML;
                document.getElementById('TextBodyEmail').innerHTML = segment + tip2;
            }
        }
        else if (type == 1) {
            const arch = document.getElementById('TextInfoDown').innerHTML;
            console.log(arch);
            if (arch == "<br>") {
                const text = "Archivos descargables:";
                $('#TextInfoDown').text(text);
            }
        }*/
        //console.log(body);

        $(select).each(function(e) {
            var info = {};
            let href = this.getAttribute('href');
            let format = href.slice((href.lastIndexOf("/") - 1 >>> 0) + 2);
            info.url = href;
            info.name = format;
            link.push(info);
        })

        for (const a of link) {
            insertFiles(a);
        }
        //console.log(link);

        $('#TipoDocEnvio').text("1");
    }

    function insertFiles(file) {
        const tipo = document.getElementById('TipoCorreo').innerHTML;
        //const docs = document.getElementById('LinkDocsPR').innerHTML;
        const doc = document.getElementById('TextDocDownload');
        const reader = new FileReader();
        const id = `file-${Math.random().toString(32).substring(7)}`;
        const url = reader.result;
        /*const cont = `
            <div id="${id}" class="container-file">
                <div class="col-md-11 content-tab-r1" draggable="true">
                    <i class="fa fa-link icon-link" aria-hidden="true"></i>
                    <div class="dr">
                        <span class="text-file-exp" title="${file.name}">${file.name}</span>
                        <span class="subtext-file-exp" title="${file.url}">${file.url}</span>
                    </div>
                </div>
                <div class="col-md-1 content-btn-file">
                    <button type="button" data-id="${id}" class="btn-close-file" onclick="DeleteFile(this)">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>`;
        const view = document.getElementById('StatusEmail').innerHTML;
        document.getElementById('StatusEmail').innerHTML = cont + view;
        const seg = document.getElementById('TextDocDownload').innerHTML;
        document.getElementById('TextDocDownload').innerHTML = seg + cont;
        const letter = document.getElementById('TextBodyEmail').innerHTML;
        $('#TextEndEmail').val(letter);*/

        const add = `
            <div id="${id}" style="padding-left:10px;padding-right:10px;">
                <a class="dropbtn" href="${file.url}" style="font-size:13px;">${file.name}</a>
            </div>`;
        //console.log(doc);
        //$('#TextDocDownload').removeClass('hidden');

        if (tipo == 1) {
            const seg = document.getElementById('TextBodyEmail').innerHTML;
            document.getElementById('TextBodyEmail').innerHTML = seg + add;
        }
        else if (tipo == 2) {
            const seg = document.getElementById('TextBodyEmail').innerHTML;
            document.getElementById('TextBodyEmail').innerHTML = add + seg;
        }
        const letter = document.getElementById('TextBodyEmail').innerHTML;
        $('#TextEndEmail').val(letter);
    }

</script>