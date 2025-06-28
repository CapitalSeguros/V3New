<div class="col-md-12 bg-table tab-pane tab-panel3" id="PanelP3" style="margin-bottom: 0px;">
    <div class="col-md-12 column-flex-item-between" style="padding-right: 0px;">
        <h4 class="title-name-client" id="NameClient"></h4>
        <h4 class="title-name-client hidden" id="NameDocument"></h4>
        <input type="text" class="form-control hidden" id="FiltrarCD" placeholder="Filtrar documento" style="width: 30%">
    </div>
    <div class="col-md-12 content-centrodigital">
        <div class="segment-p-centrodigital" id="CentroDigitalDoc" style="height:auto; padding-bottom:0px;"></div>
        <div class="segment-p-centrodigital" id="CentroDigitalCli"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#FiltrarCD').keyup(function() {
            const valor = $(this).val().toUpperCase();
            ConsultCD(valor);
        })

    })

    function ConsultCD(value) {
        var filter, panel1, panel2, d1, d2, td, i, j, k, visible;
        filter = value;
        panel1 = document.getElementById("CentroDigitalDoc");
        panel2 = document.getElementById("CentroDigitalCli");
        d1 = panel1.getElementsByTagName("div");
        d2 = $('#CentroDigitalCli').find('div');
        d3 = $('#CentroDigitalCli').find('div ul ul li');
        let Fila1 = document.getElementsByClassName('mostrar');
        let Fila2 = document.getElementsByClassName('mostrar2');
        let Fila3 = document.getElementsByClassName('mostrar3');
        //
        for (i = 0; i < d1.length; i++) {
            visible = false;
            td = d1[i].getElementsByTagName("a");
            for (j = 0; j < td.length; j++) {
                if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    visible = true;
                }
            }
            if (visible === true) {
                d1[i].style.display = "";
                $(d1[i]).addClass('mostrar');
            }
            else {
                d1[i].style.display = "none";
                $(d1[i]).removeClass('mostrar');
            }
        }

        for (i = 0; i < d2.length; i++) {
            visible = false;
            td = $(d2[i]).find('ul ul li a');
                for (j = 0; j < td.length; j++) {
                    if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        visible = true;
                    }
                }
            if (visible === true) {
                d2[i].style.display = "";
                $(d2[i]).addClass('mostrar2');
            }
            else {
                d2[i].style.display = "none";
                $(d2[i]).removeClass('mostrar2');
            }
        }

        for (i = 0; i < d3.length; i++) {
            visible = false;
            td = $(d3[i]).find('a');
                for (j = 0; j < td.length; j++) {
                    if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        visible = true;
                    }
                }
            if (visible === true) {
                d3[i].style.display = "";
                $(d3[i]).addClass('mostrar3');
            }
            else {
                d3[i].style.display = "none";
                $(d3[i]).removeClass('mostrar3');
            }
        }
        result = Fila1.length;
        result = Fila2.length;
        result = Fila3.length;
    }

    var D1SubFolder1 = "";
    var D1SubFolder2 = "";

    function DocumentsCD(Type,IDCliente,Document) {
        const tipo = Type;
        const nombreDoc = Document;
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
            beforeSend: (load) => {
            },
            success: (data) => {
                let datos=JSON.parse(data);
                let doc='';
                let abierto=false;
                let level='';
                let file = '';
                const info = datos['documentos'];
                $('#CentroDigitalCli').html("");
                console.log("datos",info);

                if (info.text != "No cuenta con documentos") {
                    let c=datos.documentos.children;
                    console.log("Dcumentos",c)
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
                    }

                    //LE AGREGA LOS RESPECTIVOS DOCUMENTOS A CADA CARPETA
                    // c=ES TODO EL ARREGLO DE SICAS
                    // arrayDoc= SON LAS CARPETAS QUE TIENE c                     
                    cant=arrayDoc.length;
                    console.log("catidad",arrayDoc);
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
                                    li+=`<li class="digitalSicas mostrar3">
                                            <i class="fa fa-file icon-file-cd" aria-hidden="true"></i>
                                            <a class="item-doc-cd" href="${c[incrementador].href}" target="_blank">${c[incrementador].text}</a>
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
                                            <div class="pop-up-modal divContenedorBotonTitulo">
                                                <button class="btn-despliegue collapsed" data-toggle="collapse" data-target="#${i}" aria-expanded="true" onclick="ocultarHijosFolder(event,this)">▼</button>
                                                <div class="namefolder">
                                                    <i class="fa fa-folder icon-folder-cd" aria-hidden="true"></i>`+arrayDoc[i][2]+`
                                                    <ul class="items-folder collapse collapse-horizontal collapse in" id="${i}" aria-expanded="true">`+arrayDoc4+`</ul>
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
                    console.log('Array2',cant);
                    for(let i=0;i<cant;i++) {
                        var arrayDoc4 = "";
                        console.log("ARRAY4",arrayDoc[i])
                        console.log("Tipo",tipo)
                        console.log("NOMBREDOC",nombreDoc)
                        if (arrayDoc[i][4] == undefined) {
                            arrayDoc4 = "";
                        }
                        else {
                            arrayDoc4 = arrayDoc[i][4];
                        }
                        if(arrayDoc[i][1]=="1") { //El cero marca un tipo de documentación if(arrayDoc[i][3]=="0")
                            if (tipo == 1 || tipo == 5 || tipo == 6) {
                                $('#CentroDigitalDoc').removeClass('hidden');
                                        doc+=`
                                            <div class="divContenedorBotonTitulo mostrar2">
                                                <label class="namefolder">
                                                <button class="btn-despliegue collapsed" data-toggle="collapse" data-target="#${i}" aria-expanded="true" onclick="ocultarHijosFolder(event,this)">▼</button>
                                                    <i class="fa fa-folder icon-folder-cd" aria-hidden="true"></i>`+arrayDoc[i][2]+`
                                                </label>
                                                <ul class="items-folder collapse collapse-horizontal collapse in" id="${i}" aria-expanded="true">`+arrayDoc4+`
                                                </ul>
                                            </div>`;
                                /* ----Version anterior ---*/
                                /* if (arrayDoc[i][2] == nombreDoc) {
                                    $('#CentroDigitalDoc').removeClass('hidden');
                                        doc+=`
                                            <div class="divContenedorBotonTitulo mostrar2">
                                                <label class="namefolder">
                                                <button class="btn-despliegue collapsed" data-toggle="collapse" data-target="#${i}" aria-expanded="true" onclick="ocultarHijosFolder(event,this)">▼</button>
                                                    <i class="fa fa-folder icon-folder-cd" aria-hidden="true"></i>`+arrayDoc[i][2]+`
                                                </label>
                                                <ul class="items-folder collapse collapse-horizontal collapse in" id="${i}" aria-expanded="true">`+arrayDoc4+`
                                                </ul>
                                            </div>`;
                                } */
                            }
                            else if (tipo == 3) {
                                $('#CentroDigitalDoc').removeClass('hidden');
                                doc+=`
                                    <div class="divContenedorBotonTitulo mostrar2">
                                        <label class="namefolder">
                                        <button class="btn-despliegue collapsed" data-toggle="collapse" data-target="#${i}" aria-expanded="true" onclick="ocultarHijosFolder(event,this)">▼</button>
                                            <i class="fa fa-folder icon-folder-cd" aria-hidden="true"></i>`+arrayDoc[i][2]+`
                                        </label>
                                        <ul class="items-folder collapse collapse-horizontal collapse in" id="${i}" aria-expanded="true">`+arrayDoc4+`
                                        </ul>
                                    </div>`;
                            }
                        }
                        //console.log("Carpetas: " + arrayDoc[i][1], arrayDoc[i][2], arrayDoc[i][3]);
                    }
                    //console.log(arrayDoc);                        
                    //document.getElementById('CentroDigitalCli').innerHTML=doc;

                    //------------------------------------------------------------------------------------
                    for(let i=0;i<total;i++) {
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
                    const count = docs.length;
                    file = '';

                    //Documentos sin carpeta
                    for(let i=0;i<count;i++) {
                        let increase = docs[i][0];
                        if (tipo == 3) {
                            if(docs[i][1] == "1" && docs[i][1] != 0) {
                                file += `
                                    <div class="items-folder mostrar">
                                        <i class="fa fa-file icon-file-cd" aria-hidden="true"></i>
                                        <a class="item-doc-cd-free" href="${c[increase].href}" target="_blank">${c[increase].text}</a>
                                    </div>`;
                            }
                            else {
                                file += ``;
                            }
                        }
                        else {
                            if (docs[i][1] == "1" && docs[i][2] == nombreDoc) {
                                file += `
                                    <div class="items-folder mostrar">
                                        <i class="fa fa-file icon-file-cd" aria-hidden="true"></i>
                                        <a class="item-doc-cd-free" href="${c[increase].href}" target="_blank">${c[increase].text}</a>
                                    </div>`;
                            }
                            else {
                                $('#CentroDigitalDoc').addClass('hidden');
                                file += ``;
                            }
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
                $('#CentroDigitalDoc').html(file);
                $('#CentroDigitalCli').html(doc);
            },
            error: (error) => {
                console.log("Error al tratar de encontrar la información.");
            }
        })
    }

    function ocultarHijosFolder(e,objeto) {
        e.preventDefault();
        if(objeto.parentElement.parentElement.classList.contains('ocultarHijos')) {
            objeto.parentElement.parentElement.classList.remove('ocultarHijos');
            objeto.innerHTML='▼';
        }
        else{objeto.parentElement.parentElement.classList.add('ocultarHijos');objeto.innerHTML='►' }
        //objeto.parentElement.parentElement.classList.toggle('ocultarHijos');
    }
	
</script>