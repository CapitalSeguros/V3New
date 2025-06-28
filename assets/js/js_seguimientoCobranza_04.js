//console.log("Hola mundo");
var ct=0;

$( function(){

	//$( "#flotante_contenedor" ).draggable();

	var vista_indice=window.location.href.split("/").pop();
	console.log(vista_indice);
	var vistas_sin_flotante=["directorio","capacita","ver","actividades","validardatos"];

	var flotante__=document.getElementById("flotante_contenedor");
	//var padre=flotante__.parentNode;

	if(vistas_sin_flotante.includes(vista_indice)){

		//padre.removeChild(flotante__);
		flotante__.style.display="none";

	} //else{
		//var valida_elemento=document.getElementById("flotante_contenedor");
		if(document.body.contains(flotante__)){ //Object.keys(sessionStorage).length>0 // && flotante__.style.display=="block"
			console.log(sessionStorage.bandera_bt);
	
			var liga=document.getElementsByClassName("link_collapse")[0];
			var cont_comercial=document.getElementById("av_comercial");
	
			liga.setAttribute("ban",sessionStorage.bandera_bt);
	
		   if(sessionStorage.bandera_bt==1){
			   //liga.setAttribute("aria-expanded",false);
			   cont_comercial.classList.add("in");
			   cont_comercial.classList.add("show");
			   //cont_comercial.style.display="block";
		   } else{
			//liga.setAttribute("aria-expanded",true);
			cont_comercial.classList.remove("in");
			cont_comercial.classList.remove("show");
			//cont_comercial.classList.remove("show");
			//cont_comercial.style.display="none";
		   }
			
		} else{
			console.log("sesion destruida");
		}
		
		var cuentas_cobranza=["ATENCIONAGENTESMID@ASESORESCAPITAL.COM","ATENCIONCLIENTES@ASESORESCAPITAL.COM","COBRANZA@ASESORESCAPITAL.COM","SOPORTEOPERATIVO@ASESORESCAPITAL.COM"];
		var cuenta_activa=(document.getElementById("usuario")!=undefined) ? document.getElementById("usuario").value : undefined;
		console.log(cuenta_activa);
	
		if(cuentas_cobranza.includes(cuenta_activa) && cuenta_activa!=undefined){
			document.getElementById("titulo_comercial").innerHTML=`
				KPI Cobranza<span class="caret"></span>
			`;
		}

	//}
});

//--------------------
var pivote=0;
function guardarenSesion(obj){

	if(obj.getAttribute("ban")==0){
		obj.setAttribute("ban",1);
		sessionStorage.setItem("bandera_bt",1);
		//document.getElementById("av_comercial").style.display="block";
	} else{
		obj.setAttribute("ban",0);
		sessionStorage.setItem("bandera_bt",0);
		//document.getElementById("av_comercial").style.display="none";
	}

}
//-------------------

//Minimizar y maximizar ventana flotante.
/*function maximina_minimiza_ventana(DomElement){

    var contenedor_info_avance_cobranza=document.getElementsByClassName("contenedor_avance_cobranza")[0];
    var band=DomElement.getAttribute("id_band");
    var _caret=document.getElementsByClassName("dd_caret")[0];

    if(band==0){
        contenedor_info_avance_cobranza.style.display="none";
        _caret.classList.replace("fa-sort-desc","fa-sort-asc");
        DomElement.setAttribute("id_band",1);
    } else{
        contenedor_info_avance_cobranza.style.display="block";
        _caret.classList.replace("fa-sort-asc","fa-sort-desc");
        DomElement.setAttribute("id_band",0);
    }
    //console.log(band);
}*/

/*function despliega_informacion(DomElement){

    var band=DomElement.getAttribute("id_band_son");
    var hijos_element=DomElement.childNodes;

    for(var i=0; i<hijos_element.length; i++){

        //console.log(hijos_element[i]);
        if(band==0 && hijos_element[i]!=DomElement.firstChild){
            hijos_element[i].style.display="block";
            DomElement.setAttribute("id_band_son",1);

        } else if(band==1 && hijos_element[i]!=DomElement.firstChild){
            hijos_element[i].style.display="none";
            DomElement.setAttribute("id_band_son",0);
        }
    }
}*/

//--------------------------------------------------

/*function cerrarAlerta_p(){
    //sessionStorage.setItem("bandera",0);

    var direccion= window.location.href.replace("miInfo","");
    console.log(direccion);
	var contenedores=document.getElementsByClassName("polizaEfectuada");
	//for(var aa=0; aa<contenedores.length; aa++){

	if(ct==0){ //&& sessionStorage.getItem("bandera")==0
		//contenedores[aa].style.display="none";
		document.getElementById('contenedor_info').style.display="none";
		document.getElementById('seguimientoSicas').style.height="5%";
		document.getElementsByClassName("fa-caret-down")[0].classList.replace("fa-caret-down","fa-caret-up");
		//console.log(document.getElementsByClassName("fa-caret-down")[0]);
		ct=1;
	} else{
		//document.getElementById('seguimientoSicas').style.display="block";
		document.getElementById('contenedor_info').style.display="block";
		//console.log(document.getElementById('contenedor_info').clientHeight);
		document.getElementById('seguimientoSicas').style.height=(document.getElementById('contenedor_info').clientHeight+40)+"px";
		document.getElementsByClassName("fa-caret-up")[0].classList.replace("fa-caret-up","fa-caret-down");
		ct=0;
	}
    //$.ajax({
	//	method:		"POST",
	//	dataType:	"html",
	//	url:		direccion+"cambiaVariableSecion/minimizaFlotante",
	//	data:		{gato:'perro'},
	//	async: 		true,
	//	success:	function(result),
	//	error:		function()
	//console.log("Hola");
	//}
	sessionStorage.setItem("bandera",ct);
	//localStorage.setItem("bandera",ct);
}*/
//--------------------------------------------------
function muestraContenido_(objectHTML){
	//console.log(objectHTML);

	//objectHTML.lastChild()
	var nueva_dimension=0;
	var nueva_dimension_padre=0;
	var band=1;
	var dim_sub=0;

	if(objectHTML){

		var hijos=objectHTML.childNodes;
		var padre_contenedor=objectHTML.parentNode;
		var padre_del_padre=padre_contenedor.parentNode;
		//var height_cont=padre_contenedor.clientHeight;
		//var alto_padre=padre_del_padre.clientHeight;
		
		for(var i=0; i<hijos.length; i++){
			
			if(objectHTML.getAttribute("id_m")==1 && hijos[i]!=objectHTML.firstChild){

				hijos[i].style.display="block";
				//nueva_dimension=height_cont+80;
				//dim_sub+=hijos[i].clientHeight;
				//nueva_dimension_padre=alto_padre+dim_sub; //alto_padre+40;
				//padre_contenedor.style.height="auto";//nueva_dimension+"px";
				//padre_del_padre.style.height=nueva_dimension_padre+"px"; //nueva_dimension_padre+"px";
				//console.log("hh: "+ hijos[i].parentNode.innerHTML);
				//console.log("hh: "+ dim_sub);
				//console.log("h2: "+ alto_padre);
				band=2;

			} else if(objectHTML.getAttribute("id_m")!=1 && hijos[i]!=objectHTML.firstChild){
				
				//nueva_dimension=height_cont-80;
				//dim_sub+=hijos[i].clientHeight;
				//nueva_dimension_padre=alto_padre-dim_sub;
				hijos[i].style.display="none";
				/*if(alto_padre>=217){ //height_cont>=217 && 
					console.log("aplica: "+ height_cont);
					padre_contenedor.style.height="auto"; //nueva_dimension+"px";
					padre_del_padre.style.height=nueva_dimension_padre+"px";
				} */
				//padre_contenedor.style.height=((height_cont>=217) ? nueva_dimension : 217)+"px";
			}
		}
		objectHTML.setAttribute("id_m",band);
	}
}

//-------------------------------------------------

function sesion_start_js(){ //document.getElementById("salida_dd").addEventListener("click", 

    //e.preventDefault();

    console.log("salida");
    sessionStorage.removeItem("bandera_bt");
}