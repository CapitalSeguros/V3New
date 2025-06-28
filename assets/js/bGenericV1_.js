
function formatoMoneda(numero)
{numeroFlot=Number(numero).toFixed(2);
 formato=new Intl.NumberFormat(['es-MX'], {style: "currency",currency: "MXN",currencyDisplay: "symbol",maximumFractionDigit: 1}).format(numeroFlot);
 return formato;
}
function limpiaCanvas(){
	 cv=document.getElementById('lienzo');
	 cv.width=cv.width;

}
function cargarGrafica(valor1,valor2)
{	
  var objetos; var montoPosicion=0;var montoPosicion2=0;var valAumento=1000;promedioPresupuesto=0;  mayorPresupuesto=0;
 var arreglo1=valor1.split("-");var arreglo2=valor2.split("-");
	var longitud=arreglo1.length;
 cv=document.getElementById('lienzo');
  cx=cv.getContext('2d');

objetos=[];
/*RECORRE LOS MONTOS, BUSCAR EL MAYOR Y DIVIDE*/
for(var i=0;i<longitud;i++){
	if(parseFloat(arreglo1[i])>parseFloat(mayorPresupuesto)){mayorPresupuesto=parseFloat(arreglo1[i])}
	
}
  promedioPresupuesto=(mayorPresupuesto/5).toFixed();
/*PARAMETROS  VERTICALES*/
objetos.push({x:0, y:0, width:100, height:40,color:'white',posicion:6});
objetos.push({x:0, y:40, width:100, height:40,color:'white',posicion:1});
objetos.push({x:0, y:80, width:100,  height:40,color:'white',posicion:2});
objetos.push({x:0, y:120, width:100, height:40,color:'white',posicion:3});
objetos.push({x:0, y:160, width:100, height:40,color:'white',posicion:4});
objetos.push({x:0, y:200, width:100, height:40,color:'white',posicion:4});
/*PARAMETROS HORIZONTALES*/
objetos.push({x:100, y:200, width:100, height:40,color:'white',posicion:0});
objetos.push({x:200, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:300, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:400, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:500, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:600, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:700, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:800, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:900, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:1000, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:1100, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:1200, y:200, width:100, height:40,color:'white',posicion:5});
objetos.push({x:100, y:242, width:30, height:10,color:'green',posicion:5});
objetos.push({x:300, y:242, width:30, height:10,color:'orange',posicion:5});
objetos.push({x:500, y:242, width:30, height:10,color:'red',posicion:5});
/*TEXTO DE PARAMETROS VERTICALES*/

objetos.push({text:promedioPresupuesto*5, x:35, y:10,color:'black'});
objetos.push({text:promedioPresupuesto*4, x:35, y:50,color:'black'});
objetos.push({text:promedioPresupuesto*3, x:35, y:90,color:'black'});
objetos.push({text:promedioPresupuesto*2, x:35, y:130,color:'black'});
objetos.push({text:promedioPresupuesto, x:35, y:170,color:'black'});

/*TEXTO DE PARAMETROS HORIZONTALES*/
objetos.push({text:"Enero", x:120, y:230,color:'black'});
objetos.push({text:"Febrero", x:220, y:230,color:'black'});
objetos.push({text:"Marzo", x:320, y:230,color:'black'});
objetos.push({text:"Abril", x:420, y:230,color:'black'});
objetos.push({text:"Mayo", x:520, y:230,color:'black'});
objetos.push({text:"Junio", x:620, y:230,color:'black'});
objetos.push({text:"Julio", x:720, y:230,color:'black'});
objetos.push({text:"Agosto", x:820, y:230,color:'black'});
objetos.push({text:"Septiembre", x:920, y:230,color:'black'});
objetos.push({text:"Octubre", x:1020, y:230,color:'black'});
objetos.push({text:"Noviembre", x:1120, y:230,color:'black'});
objetos.push({text:"Diciembre", x:1220, y:230,color:'black'});
objetos.push({text:"Presupuesto", x:150, y:250,color:'green'});
objetos.push({text:"Autorizado", x:350, y:250,color:'orange'});
objetos.push({text:"Presupuesto superado", x:550, y:250,color:'red'});


for(var i=0;i<objetos.length; i++)
{
  if(!objetos[i].text)
  {cx.fillStyle=objetos[i].color;cx.fillRect(objetos[i].x,objetos[i].y,objetos[i].width,objetos[i].height);	}
  else
  {cx.fillStyle=objetos[i].color;cx.lineWidth=2;cx.beginPath();cx.fillText(objetos[i].text,objetos[i].x,objetos[i].y);
   cx.stroke();
  }
}
for(var i=0;i<14;i++)
 {cx.fillStyle="yellow";cx.lineWidth=.1;cx.moveTo(100*i,0);cx.lineTo(100*i,200)	;
 }
for(var i=0;i<6;i++){cx.moveTo(0,40*i);cx.lineTo(1300,40*i)	;}
cx.stroke();

	


  var tamanio=objetos.length;var inicio;var inicioX;var inicioY;var hastaX=100;var hastaY;	  
  for(var y=0;y<longitud;y++)
  {
    hastaX=hastaX+100;var monto=arreglo2[y];var presupuesto=arreglo1[y];
    for(var i=0;i<tamanio;i++)
    { 
	  if(objetos[i].posicion==0 && y==0) 
	  {inicioX=objetos[i].x;inicioY=objetos[i].y;}	
	  if(objetos[i].text)
	  {
		if(parseFloat(objetos[i].text)>=monto)
		{if(objetos[i].text=='0'){inicio=objeto[i];}
		  montoPosicion=objetos[i].text;
		  hastaY=objetos[i].y-8;
		}
		 else
		  { montoPosicion2=objetos[i].text;		     
		    break;
		  }			
	   }
     }
	 inicioX=hastaX;inicioY=hastaY+40-((40/montoPosicion)*monto);
	  cx.fillStyle="green";
	  cx.fillRect(hastaX-80,200,20,-((presupuesto/promedioPresupuesto)*40)); 
	  if(parseFloat(presupuesto)>=parseFloat(monto))
	  {
	   cx.fillStyle="orange";
	   cx.fillRect(hastaX-50,200,20,-((monto/promedioPresupuesto)*40)); 
	  }
	 else
	 {
	  cx.fillStyle="red";
	  cx.fillRect(hastaX-50,200,20,-(((monto)/promedioPresupuesto)*40)); 
	 }
	/*var n=220;
	     cx.beginPath();
     	  cx.lineWidth=1;
	  cx.font = "16px sans-serif";
	                   cx.strokeStyle = "blue";
	                   cx.fillStyle = "blue";
	          var pr=formatoMoneda(presupuesto);

	for(var j=pr.length;j>-1;j-- ){	cx.fillText(pr.charAt(j),hastaX-70,n=n-14);}
	n=220;
	 var pr=formatoMoneda(monto);
		for(var j=pr.length;j>-1;j-- ){

				 	  cx.fillText(pr.charAt(j),hastaX-40,n=n-14);

		}
		 cx.stroke();*/
   }
}	
