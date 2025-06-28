(function ($){

    $("#todos").on("click",function(){

        //Panel de ramos.
        if($("#todos").is(":checked")){
            $(".ramoS").prop("checked",true);
        } else{
            $(".ramoS").prop("checked",false);
        }
    });
    
    $("#despacho_todos").on("click",function(){
    
         //Panel de sucursales (despachos).
         if($("#despacho_todos").is(":checked")){
            $(".despachoS").prop("checked",true);
        } else{
            $(".despachoS").prop("checked",false);
        }
    });
    
    $("#todosGrupos").on("click",function(){
         //Panel de grupos.
         if($("#todosGrupos").is(":checked")){
            $(".gruposS").prop("checked",true);
        } else{
            $(".gruposS").prop("checked",false);
        }
    
    });
    
    $("#todos_canal").on("click",function(){
        //Panel de canales (gerencias).
        if($("#todos_canal").is(":checked")){
            $(".canalS").prop("checked",true);
        } else{
            $(".canalS").prop("checked",false);
        }
    });
    
    $("#todos_vendedores").on("click",function(){
        //Panel de vendedores.
        if($("#todos_vendedores").is(":checked")){
            $(".vendS").prop("checked",true);
        } else{
            $(".vendS").prop("checked",false);
        }
    });
    
    
    var meses_obj={};
    
    meses_obj[1]="ENERO";
    meses_obj[2]="FEBRERO";
    meses_obj[3]="MARZO";
    meses_obj[4]="ABRIL";
    meses_obj[5]="MAYO";
    meses_obj[6]="JUNIO";
    meses_obj[7]="JULIO";
    meses_obj[8]="AGOSTO";
    meses_obj[9]="SEPTIEMBRE";
    meses_obj[10]="OCTUBRE";
    meses_obj[11]="NOVIEMBRE";
    meses_obj[12]="DICIEMBRE";
    
    function consultaPolizas(e){
    
        e.preventDefault();
        
        var msj=validaCampos();

        if(msj!=""){
            alert(msj);

            return false;
        }

        $("#gif_carga").show();

        console.log("llego aqui5");
        var direccion=window.location.href.replace("rendicionDeCuentas","");
    
        //Envió de consulta por metodo GET.
    
        $.get(direccion+"consultaPolizas",$("#form_polizas").serialize()) //"q":fechaI.val(),"r":fechaF.val(),"p":tipoReporte.val()
            
            .fail(function(){
    
                alert("Datos no recibidos");
    
            })
            .done(function(data){

                $("#gif_carga").hide();
    
                var jsonObject=JSON.parse(data);
                console.log(jsonObject);
                
                var opciones_li=``;
                var reportes_li=``;
                var info_reporte=``;
                info_reporte+=`<div  id="myTabContent" style="width: 100%">`;
    
                $.each(jsonObject, function(mes,datos){
    
                    opciones_li+=`
                        <li >
                            <!--<a href="#mes_`+mes+`" aria-controls="mes_`+mes+`" role="tab" data-toggle="tab">`+meses_obj[mes]+`</a>-->
                            <a href="javascript: void(0)" onclick="muestra_contenido(`+mes+`)"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbsp`+meses_obj[mes]+`</a>
                        </li>
                    `;
    
                    if(Object.keys(mes).length>0){
                    
                        if($("#idPersona_reporte").val()!=805){
                            info_reporte+=`<div id="mes_`+mes+`" style="display: none">
                                <div>`;
                            
                            var acumulado_prima=0;
                            var acumulado_comision=0;
                            var acumulado_polizas=0;

                            $.each(datos.recibosSemanales, function(r,datosr){
                                info_reporte+=`
                                   
                                    <div class="dropdown" id="recibos_mes_`+mes+`" style="display:inline-block">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="semanas_`+mes+`_`+r+`" data-toggle="dropdown" aria-expanded="true">
                                            `+r.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="semanas_`+mes+`_`+r+`">
                                            <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',1)">Semana 1 <span class="badge">`+datosr.sem_1.Polizas+`</span></a></li>
                                            <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',2)">Semana 2 <span class="badge">`+datosr.sem_2.Polizas+`</span></a></li>
                                            <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',3)">Semana 3 <span class="badge">`+datosr.sem_3.Polizas+`</span></a></li>
                                            <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',4)">Semana 4 <span class="badge">`+datosr.sem_4.Polizas+`</span></a></li>
                                        </ul>
                                    </div>                                    
                                `;
                            });

                               info_reporte+=`</div>
                               <br>
                               <div>`;

                               $.each(datos.recibosSemanales, function(r,datosr){

                                    $.each(datosr, function(s, registros){

                                        info_reporte+=`
                                            <div class="contenedor_info_`+mes+`_`+r+`_`+s.slice(4)+`" style="display: none">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><h5><i class="fa fa-check-circle" aria-hidden="true"></i>&nbspConteo de pólizas por vendedor Semana `+s.slice(4)+` (`+r.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`)</h5></div>
                                                    <div class="panel-body">
                                                    <table class="table table-striped" id="tabla_personal_`+mes+`_`+r+`_`+s.slice(4)+`">
                                                    <thead>
                                                        <tr class="active">
                                                            <td class="text-center text-danger">Colaborador</td>
                                                            <td class="text-center text-success">AUTOS</td>
                                                            <td class="text-center text-danger">VIDA</td>
                                                            <td class="text-center text-warning">DAÑOS</td>
                                                            <td class="text-center text-info">GMM</td>
                                                            <td class="text-center text-default">AP</td>
                                                            <td class="text-center text-warning">TOTAL POLIZAS</td>
                                                            <td class="text-center text-warning">TOTAL PRIMA ACUMULADA</td>
                                                            <td class="text-center text-warning">TOTAL COMISIÓN ACUMULADA</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabla_cuerpo_colaborador">`;
                                                    
                                                    $.each(registros.Vendedores, function(id, datosv){
                                                        info_reporte+=`<tr>
                                                            <td class="text-left">`+datosv.Nombre+`</td>`;

                                                            $.each(datosv.PolizasEnRamos, function(p,cp){

                                                                if(p!="Fianzas"){
                                                                    info_reporte+=`<td>`+cp+`</td>`;
                                                                }
                                                            });

                                                            info_reporte+=`
                                                                <td class="text-center">`+datosv.TotalPolizas+`</td>
                                                                <td class="text-center">$ `+new Intl.NumberFormat().format(datosv.PrimaNeta)+`</td>
                                                                <td class="text-center">$`+new Intl.NumberFormat().format(datosv.Comision)+`</td>
                                                            </tr>`
                                                    });

                                                    info_reporte+=`</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>`;
                                    
                                    });
                                });

                                $.each(datos.recibosSemanales, function(a,datosa){
                                    $.each(datosa, function(s, registros){

                                        /*info_reporte+=`
                                            <div class="contenedor_info_`+mes+`_`+a+`_`+s.slice(4)+`" style="display: none">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><h5><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbspPrimas y comisiones por vendedor Semana `+s.slice(4)+` (`+a.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`)</h5></div>
                                                    <div class="panel-body">
                                                    <table class="table table-striped" id="tabla_personal_d_`+mes+`">
                                                    <thead>
                                                        <tr class="active">
                                                            <td class="text-center text-danger">Vendedor</td>
                                                            <td>Semana `+s.slice(4)+`</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>`;
                                                    
                                                    $.each(registros.Vendedores, function(id, datosv){
                                                        info_reporte+=`<tr>
                                                            <td class="text-left">`+datosv.Nombre+`</td>
                                                            <td class="text-left">
                                                                <a href="#" class="text-default">Polizas: <span class="badge"> `+datosv.TotalPolizas+`</span></a><br><br>
                                                                <a href="#" class="text-warning">Primas: <span class="badge">$ `+new Intl.NumberFormat().format(datosv.PrimaNeta.toFixed(2))+`</span></a><br><br>
                                                                <a href="#" class="text-success">Comisión: <span class="badge">$ `+new Intl.NumberFormat().format(datosv.Comision.toFixed(2))+`</span></a>
                                                            </td>
                                                            </tr>
                                                        `;
                                                    });

                                                    info_reporte+=`
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>`; */
                                    
                                    });
                                });

                                
                                $.each(datos.recibosSemanales, function(b,datosa){
                                    $.each(datosa, function(s, registros){

                                        //acumulado_polizas+=registros.Polizas;

                                        acumulado_comision+=datos.recibosSemanales.RecibosEmitidos.sem_1.Comision+datos.recibosSemanales.RecibosEmitidos.sem_2.Comision+datos.recibosSemanales.RecibosEmitidos.sem_3.Comision+datos.recibosSemanales.RecibosEmitidos.sem_4.Comision; //registros.Comision;

                                        info_reporte+=`
                                            <div class="contenedor_info_`+mes+`_`+b+`_`+s.slice(4)+`" style="display: none">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><h5><h5><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbspReporte de primas y comisiones Semana `+s.slice(4)+` (`+b.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`)</h5></div>
                                                    <div class="panel-body">
                                                        <table class="table table-bordered" id="tabla_info_`+mes+`_`+b+`_`+s.slice(4)+`">
                                                            <tbody>`;


                                                            if(b!="RecibosEmitidos"){

                                                                var acumulado_polizas=0;
                                                                acumulado_polizas+=registros.Polizas;
                                                                var acumulado_primas=0;
                                                                var acumulado_comisionu=0;

                                                                /*$.each(datosa, function(q,qr){

                                                                    acumulado_polizas+=qr.Polizas;
                                                                    acumulado_primas+=qr.Prima;
                                                                    acumulado_comisionu+=qr.Prima;

                                                                });*/


                                                                info_reporte+=`
                                                                    <tr>
                                                                        <td>`+registros.PolizaAcumulada+`</td>
                                                                        <td class="text-left">Pólizas (`+b.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`)</td>
                                                                        <td>Meta comercial</td>
                                                                        <td>Fecha inicio</td>
                                                                        <td>Semana 1</td>
                                                                        <td>Semana 2</td>
                                                                        <td>Semana 3</td>
                                                                        <td>Semana 4</td>
                                                                        <td>Avance</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>$ `+new Intl.NumberFormat().format(registros.PrimaAcumulada)+` </td>`
                                                                    
                                                                        info_reporte+=`<td class="text-left">Prima (`+b.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`)</td>
                                                                        <td>$ `+new Intl.NumberFormat().format(datos.metaComercial)+`</td>
                                                                        <td>`+datos.fechaInicio+`</td>
                                                                        <td>20%</td>
                                                                        <td>40%</td>
                                                                        <td>60%</td>
                                                                        <td>80%</td>
                                                                        <td>100%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>$ `+new Intl.NumberFormat().format(registros.ComisionAcumulada)+`</td>
                                                                        <td class="text-left">Comisión (`+b.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`)</td>
                                                                        <td class="text-center"><h5><span class="label label-warning">Recibos<span></h5></td> 
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center" rowspan="3" colspan="2"><br>Acumulado de comisión semanal</td>
                                                                        <td colspan="2">IDEAL</td>`;

                                                                    $.each(datosa, function(std,infotd){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(infotd.MetaIdeal)+`</td>`; 
                                                                    });

                                                                    info_reporte+=`
                                                                        <td>80%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">REAL</td>`;
                                                                    
                                                                    var comisionA=0;

                                                                    $.each(datosa, function(std,infotd){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(infotd.ComisionAcumulada)+`</td>`; 
                                                                        comisionA=infotd.ComisionAcumulada;
                                                                    });

                                                                    info_reporte+=`
                                                                        <td>`+(comisionA/datos.metaComercial)+`%</td>
                                                                    </tr>
                                                                    <!--<tr>
                                                                        <td class="text-center" colspan="2">Comisión promedio de la semana</td>
                                                                        <td colspan="2"></td>`;   
                                                                        
                                                                        $.each(datosa, function(stda,infotda){
                                                                            info_reporte+=`<td>$ `+new Intl.NumberFormat().format(infotda.Comision/infotda.Polizas)+`</td>`; 
                                                                        });

                                                                    info_reporte+=`</tr>-->
                                                                `;  
                                                            } else{

                                                                info_reporte+=`<tr>
                                                                    <td>`+registros.PolizaAcumulada+`</td>
                                                                    <td class="text-left">Pólizas emitidas</td>
                                                                    <td>Meta comercial</td>
                                                                    <td>Fecha inicio</td>
                                                                    <td>Semana 1</td>
                                                                    <td>Semana 2</td>
                                                                    <td>Semana 3</td>
                                                                    <td>Semana 4</td>
                                                                    <td>Avance</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>$ `+new Intl.NumberFormat().format(registros.PrimaAcumulada)+` </td>`
                                                                
                                                                    info_reporte+=`<td class="text-left">Prima Emitida</td>
                                                                    <td>$ `+new Intl.NumberFormat().format(datos.metaComercial)+`</td>
                                                                    <td>`+datos.fechaInicio+`</td>
                                                                    <td>20%</td>
                                                                    <td>40%</td>
                                                                    <td>60%</td>
                                                                    <td>80%</td>
                                                                    <td>100%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>$ `+new Intl.NumberFormat().format(registros.PrimaCobradaAcumulada)+`</td>
                                                                    <td class="text-left">Prima Cobrada</td>
                                                                    <td class="text-center"><h5><span class="label label-warning">Recibos<span></h5></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>$ `+new Intl.NumberFormat().format(registros.PrimaPendienteAcumulada)+`</td>
                                                                    <td class="text-left">Prima por cobrar</td>
                                                                    <td colspan="2">IDEAL</td>`;

                                                                    $.each(datosa, function(std,infotd){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(infotd.MetaIdeal)+`</td>`; 
                                                                    });

                                                                    info_reporte+=`
                                                                    <td>80%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>$ `+new Intl.NumberFormat().format(registros.ComisionAcumulada)+`</td>
                                                                    <td class="text-left">Comisión generada</td>
                                                                    <td colspan="2">REAL</td>`;
                                                                    
                                                                    var comisionA=0;

                                                                    $.each(datosa, function(std,infotd){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(infotd.ComisionCobradaAcumulada)+`</td>`; 
                                                                        comisionA=infotd.ComisionAcumulada;
                                                                    });

                                                                info_reporte+=`
                                                                    <td>`+(comisionA/datos.metaComercial)+`%</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>$ `+new Intl.NumberFormat().format(registros.ComisionCobradaAcumulada)+`</td>
                                                                    <td class="text-left">Comisión cobrada</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>$ `+new Intl.NumberFormat().format(registros.ComisionPendienteAcumulada)+`</td>
                                                                    <td class="text-left">Comisión pendiente</td>  
                                                                </tr>
                                                                <tr>
                                                                    <td>$ `+new Intl.NumberFormat().format(registros.ComisionAcumulada/registros.PolizaAcumulada)+`</td>
                                                                    <td class="text-left">Comisión promedio del mes</td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td class="text-left">Comisión promedio de la semana</td>
                                                                    <td colspan="2"></td>`;   
                                                                    
                                                                    $.each(datosa, function(stda,infotda){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(infotda.Comision/infotda.Polizas)+`</td>`; 
                                                                    });

                                                                info_reporte+=`</tr>
                                                                `;
                                                            }
                                                    info_reporte+=`
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div id="link_descarga`+mes+`">
                                                        <button class="btn btn-primary" onclick="exportarAExcel(`+mes+`,'`+b+`',`+s.slice(4)+`)">Exportar resultado a fichero Excel</button>
                                                    </div>
                                                </div>
                                            </div>`;
                                    });
                                });
                                
                             
                                


                               info_reporte+=`</div>
                                
                                <!--Tabla completa de seguimiento de vendedores-->
                                <table id="tabla_excel_`+mes+`" style="display:none">
                                    <thead>
                                        <tr>
                                            <th>VENDEDOR</th>
                                            <th>SEMANA 1</th>
                                            <th>PRIMA EMITIDA</th>
                                            <th>COMISION </th>
                                            <th>SEMANA 2</th>
                                            <th>PRIMA EMITIDA</th>
                                            <th>COMISION </th>
                                            <th>SEMANA 3</th>
                                            <th>PRIMA EMITIDA</th>
                                            <th>COMISION </th>
                                            <th>SEMANA 4</th>
                                            <th>PRIMA EMITIDA</th>
                                            <th>COMISION </th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                                    
                                    $.each(datos.vendedores, function(idvend,datosv){
                                        info_reporte+=`
                                        <tr>
                                            <td>`+datosv.nombre+`</td>`;
                                            
                                            $.each(datosv.semanas, function(_sem,data_sem){
    
                                                info_reporte+=`
                                                    <td>`+data_sem.poliza_semanal+`</td>
                                                    <td>`+data_sem.prima_semanal+`</td>
                                                    <td>`+data_sem.comision_semanal+`</td>
                                                `;
                                            });
                                        
                                        info_reporte+=`</tr>`; 
                                    });
                            
                                    info_reporte+=`
                                    </tbody>
                                </table>
                            </div>`;
                        } 
                        if($("#idPersona_reporte").val()==805){
                            info_reporte+=`<div id="mes_`+mes+`" style="display: none">
                                <div>`;

                            $.each(datos.recibosSemanales, function(r,datosr){
                                
                                if(r=="RecibosEmitidos"){
                                    info_reporte+=`
                                
                                        <div class="dropdown" id="recibos_mes_`+mes+`" style="display:inline-block">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="semanas_`+mes+`_`+r+`" data-toggle="dropdown" aria-expanded="true">
                                                `+r.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Generados")+`
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="semanas_`+mes+`_`+r+`">
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',1)">Semana 1 <span class="badge">`+datosr.sem_1.Polizas+`</span></a></li>
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',2)">Semana 2 <span class="badge">`+datosr.sem_2.Polizas+`</span></a></li>
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',3)">Semana 3 <span class="badge">`+datosr.sem_3.Polizas+`</span></a></li>
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',4)">Semana 4 <span class="badge">`+datosr.sem_4.Polizas+`</span></a></li>
                                            </ul>
                                        </div>                                    
                                    `;
                                }
                                
                            });
                            
                               info_reporte+=`
                               </div>
                               <br>
                               <div>`;

                               $.each(datos.recibosSemanales, function(r,datosr){
                                   
                                    $.each(datosr, function(s, registros){

                                        info_reporte+=`
                                            <div class="contenedor_info_`+mes+`_`+r+`_`+s.slice(4)+`" style="display: none">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><h5><i class="fa fa-check-circle" aria-hidden="true"></i>&nbspConteo de pólizas por vendedor Semana `+s.slice(4)+` (`+r.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`)</h5></div>
                                                    <div class="panel-body">
                                                    <table class="table table-striped" id="tabla_personal_`+mes+`_`+r+`_`+s.slice(4)+`">
                                                    <thead>
                                                        <tr class="active">
                                                            <td class="text-center text-danger">Colaborador</td>
                                                            <td class="text-center text-success">Fianzas</td>
                                                            <td class="text-center text-warning">TOTAL POLIZAS</td>
                                                            <td class="text-center text-warning">TOTAL PRIMA ACUMULADA</td>
                                                            <td class="text-center text-warning">TOTAL COMISIÓN ACUMULADA</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabla_cuerpo_colaborador">`;
                                                    
                                                    $.each(registros.Vendedores, function(id, datosv){
                                                        info_reporte+=`<tr>
                                                            <td class="text-left">`+datosv.Nombre+`</td>`;

                                                            $.each(datosv.PolizasEnRamos, function(p,cp){

                                                                if(p=="Fianzas"){
                                                                    info_reporte+=`<td>`+cp+`</td>`;
                                                                }
                                                            });

                                                            info_reporte+=`
                                                                <td class="text-center">`+datosv.TotalPolizas+`</td>
                                                                <td class="text-center">$ `+new Intl.NumberFormat().format(datosv.PrimaNeta)+`</td>
                                                                <td class="text-center">$`+new Intl.NumberFormat().format(datosv.Comision)+`</td>
                                                            </tr>`
                                                    });

                                                    info_reporte+=`</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>`;
                                    
                                    });

                                    
                                });

                                /*$.each(datos.recibosSemanales, function(a,datosa){
                                    $.each(datosa, function(s, registros){

                                        info_reporte+=`
                                            <div class="contenedor_info_`+mes+`_`+a+`_`+s.slice(4)+`" style="display: none">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><h5><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbspPrimas y comisiones por vendedor Semana `+s.slice(4)+` (`+a.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`)</h5></div>
                                                    <div class="panel-body">
                                                    <table class="table table-striped" id="tabla_personal_d_`+mes+`">
                                                    <thead>
                                                        <tr class="active">
                                                            <td class="text-center text-danger">Vendedor</td>
                                                            <td>Semana `+s.slice(4)+`</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>`;
                                                    
                                                    $.each(registros.Vendedores, function(id, datosv){
                                                        info_reporte+=`<tr>
                                                            <td class="text-left">`+datosv.Nombre+`</td>
                                                            <td class="text-left">
                                                                <a href="#" class="text-default">Polizas: <span class="badge"> `+datosv.TotalPolizas+`</span></a><br><br>
                                                                <a href="#" class="text-warning">Primas: <span class="badge">$ `+new Intl.NumberFormat().format(datosv.PrimaNeta.toFixed(2))+`</span></a><br><br>
                                                                <a href="#" class="text-success">Comisión: <span class="badge">$ `+new Intl.NumberFormat().format(datosv.Comision.toFixed(2))+`</span></a>
                                                            </td>
                                                            </tr>
                                                        `;
                                                    });

                                                    info_reporte+=`
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>`;
                                    
                                    });
                                }); */

                               

                                $.each(datos.recibosSemanales, function(b,datosb){
                                    $.each(datosb, function(s, registros){

                                        info_reporte+=`
                                        <div class="contenedor_info_`+mes+`_`+b+`_`+s.slice(4)+`" style="display: none">
                                            <div class="panel panel-info">
                                                <div class="panel-heading"><h5><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbspReporte de primas y comisiones Semana `+s.slice(4)+` (`+b.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`</h5></div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered" id="tabla_info_`+mes+`_`+b+`_`+s.slice(4)+`">
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td>fecha 1</td>
                                                                <td>fecha 2</td>
                                                                <td>fecha 3</td>
                                                                <td>fecha 4</td>
                                                                <td>Total mensual</td>
                                                                <td>F.Inicio</td>
                                                                <td>Sem 1</td>
                                                                <td>Sem 2</td>
                                                                <td>Sem 3</td>
                                                                <td>Sem 4</td>
                                                                <td>Avance</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Pólizas emitidas</td>`;
                                                                
                                                                var sumatoriaPolizas=0;

                                                                $.each(datosb, function(sp, registrosp){

                                                                    sumatoriaPolizas+=registrosp.Polizas;

                                                                    info_reporte+=`<td>`+registrosp.Polizas+`</td>`;
                                                                });

                                                                info_reporte+=`
                                                                <td>`+sumatoriaPolizas+`</td>
                                                                <td>`+datos.fechaInicio+`</td>
                                                                <td>20%</td>
                                                                <td>40%</td>
                                                                <td>60%</td>
                                                                <td>80%</td>
                                                                <td>100%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Prima emitida</td>`;

                                                                var sumatoriaPrimasNetas=0;

                                                                $.each(datosb, function(sp, registrosp){

                                                                    sumatoriaPrimasNetas+=registrosp.Prima;

                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.Prima)+`</td>`;
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(sumatoriaPrimasNetas.toFixed(2))+`</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Prima cobrada</td>`;
                                                                
                                                                var sumatoriaPrimasNetasCobradas=0;

                                                                $.each(datosb, function(sp, registrosp){

                                                                    sumatoriaPrimasNetasCobradas+=registrosp.PrimaCobrada;

                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.PrimaCobrada)+`</td>`;
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(sumatoriaPrimasNetasCobradas.toFixed(2))+`</td>
                                                                <td class="text-center">IDEAL</td>`;

                                                                $.each(datosb, function(sp, registrosp){

                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.MetaIdeal)+`</td>`;
                                                                });

                                                            info_reporte+=`
                                                                <td>100%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Prima por cobrar</td>`;

                                                                var sumatoriaPrimasNetasPendientes=0;

                                                                $.each(datosb, function(sp, registrosp){

                                                                    if(registrosp.PrimaPendiente>0){
                                                                        sumatoriaPrimasNetasPendientes+=registrosp.PrimaPendiente;
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(sumatoriaPrimasNetasPendientes+datos.primaPendienteFianzas)+`</td>`;
                                                                    } else{
                                                                        info_reporte+=`<td>$ 0</td>`;
                                                                    }
                                                                    
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(sumatoriaPrimasNetasPendientes+datos.primaPendienteFianzas)+`</td>
                                                                <td class="text-center">REAL</td>`;
                                                                
                                                                var comisionAcu=0;

                                                                $.each(datosb, function(sp, registrosp){

                                                                    comisionAcu+=registrosp.ComisionAcumulada;
                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.ComisionAcumulada)+`</td>`;
                                                                });

                                                            info_reporte+=`
                                                                <td>`+(comisionAcu/datos.metaComercial).toFixed(2)+`%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Comisión generada</td>`;

                                                                var comisionsum=0;

                                                                $.each(datosb, function(sp, registrosp){

                                                                    comisionsum+=registrosp.Comision;
                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.Comision)+`</td>`;
                                                                });

                                                        info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(comisionsum)+`</td>
                                                                <td class="text-center" colspan="4">Proyección</td>
                                                                <td>`+new Intl.NumberFormat().format(datos.metaComercial*(comisionAcu/datos.metaComercial).toFixed(2))+`</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Comisión cobrada</td>`;
                                                                
                                                                var comisionpagadasum=0;

                                                                $.each(datosb, function(sp, registrosp){

                                                                    comisionpagadasum+=registrosp.ComisionCobrada;
                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.ComisionCobrada)+`</td>`;
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(comisionpagadasum)+`</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Comisión pendiente</td>`;

                                                                var comisionpendientesum=0;

                                                                $.each(datosb, function(sp, registrosp){

                                                                    //comisionpendientesum+=registrosp.ComisionPendiente;
                                                                    //info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.ComisionPendiente)+`</td>`;

                                                                    if(registrosp.ComisionPendiente>0){
                                                                        comisionpendientesum+=registrosp.ComisionPendiente;
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(comisionpendientesum+datos.comisionPendienteFianzas)+`</td>`;
                                                                    } else{
                                                                        info_reporte+=`<td>$ 0</td>`;
                                                                    }
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(comisionpendientesum+datos.comisionPendienteFianzas)+`</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Comisión promedio</td>`;
                                                                
                                                                $.each(datosb, function(sp, registrosp){

                                                                    comisionpendientesum+=registrosp.ComisionPendiente;
                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.Comision/registrosp.Polizas)+`</td>`;
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(comisionsum/sumatoriaPolizas)+`</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="link_descarga`+mes+`">
                                                    <button class="btn btn-primary" onclick="exportarAExcel(`+mes+`,'`+b+`',`+s.slice(4)+`)">Exportar resultado a fichero Excel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                                    });
                                });
                        }
                        
                        //console.log(datos.semanas);
                    } else{
                        info_reporte+=`<div id="mes_`+mes+`" style="display: none"><h4>No hay datos para este mes</h4></div>`;
                    }
                });
    
                info_reporte+=`</div>`;
    
                $("#tab_panel").html(`
                    <ul class="nav nav-tabs" role="tablist" id="reporte_mensual">`+opciones_li+`</ul>
                    <br>
                    `+info_reporte+`
                `);

                $("#contenedor_resultado").show();

            });
    }
    //------------------------------------------------------------
    function validaCampos(){
    
        var mensaje="";
    
        var fecha_i=$("#fechaI").val();
        var fecha_f=$("#fechaF").val();
    
        var reporte=$("#tipoReporte").val();
        var f_doc=$("#tipoFechaDoc").val();
    
        if(fecha_i==""){
            mensaje="El campo de fecha inicio esta vacío, favor de asignar una fecha.";
    
            return mensaje;
        }
    
        if(fecha_f==""){
            mensaje="El campo de fecha final esta vacío, favor de asignar una fecha.";
            return mensaje;
        }
    
        if(reporte=="inicio"){
            mensaje="El primer elemento del combo de tipo de reporte esta seleccionado, favor de seleccionar una opción valida.";
            return mensaje;
        }
    
        if(f_doc=="inicio"){
            mensaje="El primer elemento del combo de tipo de fecha esta seleccionado, favor de seleccionar una opción valida.";
            return mensaje;
        }
    
        return mensaje;
    }
    //------------------------------------------------------------

    /*$("#panel_opciones").click(function(){



    });*/

    //------------------------------------------------------------
    $("#btn_consulta").on("click", consultaPolizas); //consultaPolizas
    
})(jQuery);

//----------------------------------------------------------

var meses_obj={};
    
    meses_obj[1]="ENERO";
    meses_obj[2]="FEBRERO";
    meses_obj[3]="MARZO";
    meses_obj[4]="ABRIL";
    meses_obj[5]="MAYO";
    meses_obj[6]="JUNIO";
    meses_obj[7]="JULIO";
    meses_obj[8]="AGOSTO";
    meses_obj[9]="SEPTIEMBRE";
    meses_obj[10]="OCTUBRE";
    meses_obj[11]="NOVIEMBRE";
    meses_obj[12]="DICIEMBRE";

function muestra_contenido(mes){
    
    var meses_anio=[1,2,3,4,5,6,7,8,9,10,11,12];

    console.log("funcion click");

    $.each(meses_anio, function(i,v){
        if(mes==v){
            $("#mes_"+v).show();
        } else{
            $("#mes_"+v).hide();
        }
    });

    if($("#contenedor_lista_ramos_"+mes).innerHeight()>300){
        $("#contenedor_lista_ramos"+mes).css("overflowY","scroll");
        //console.log("entro en condición");
    }

    console.log($("#contenedor_lista_ramos_"+mes).innerHeight());

    //console.log("js funcionando");
    //$("#mes_"+mes).show();
}

//---------------------------------------------------------
function muestra_contenido_semanal(m,r,s){

    console.log("muestra div_"+m+r+s);

    var meses_anio=[1,2,3,4,5,6,7,8,9,10,11,12];
    var semanas=[1,2,3,4];
    var recibos=["RecibosNuevos", "RecibosYSubsecuentes","RecibosTotales", "RecibosEmitidos"];

    //contenedor_info_`+mes+`_`+r+`_`+s.slice(4)+`

    $.each(meses_anio, function(i,ma){
        $.each(semanas, function(j,sa){
            $.each(recibos, function(k,ra){
                if(m==ma && s==sa && r==ra){
                    $(".contenedor_info_"+ma+"_"+ra+"_"+sa).show(); //contenedor_vendedor_semanal_ , contenedor_cuentas
                    $("#contenedor_vendedor_semanal_"+ma+"_"+ra+"_"+sa).show();
                    $("#contenedor_cuentas_"+ma+"_"+ra+"_"+sa).show();
                } else{
                    $(".contenedor_info_"+ma+"_"+ra+"_"+sa).hide();
                    $("#contenedor_vendedor_semanal_"+ma+"_"+ra+"_"+sa).show();
                    $("#contenedor_cuentas_"+ma+"_"+ra+"_"+sa).show();
                }
            })
        })
    })



}
//---------------------------------------------------------
function exportarAExcel(mes,recibo,semana,filename=""){

    var downloadLink;
    var tipoDato = 'application/vnd.ms-excel';
    var tablainfo = document.getElementById("tabla_info_"+mes+`_`+recibo+`_`+semana);
    var tablaregP = document.getElementById("tabla_excel_"+mes);
    var tablaPersona=document.getElementById("tabla_personal_"+mes+`_`+recibo+`_`+semana);
    //var tablainfo=$("#tabla_info_"+mes);
    var tablaHTML2=tablainfo.outerHTML.replace(/ /g, '%20');
    //var tablaHTML3=tablaregP.outerHTML.replace(/ /g, '%20');
    var tablaHTML1=tablaPersona.outerHTML.replace(/ /g, '%20');

    var tablaHTML=tablaHTML1+tablaHTML2; //+tablaHTML3

    filename = filename?filename+'.xls':''+meses_obj[mes]+'.xls';

    downloadLink = document.createElement("a");
    //downloadLink.textContent="descargar fichero excel";
    $("#link_descarga"+mes).append(downloadLink);
    //document.getElementById("link_descarga"+mes).appendChild(downloadLink);

    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tablaHTML], {
            type: tipoDato
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    } else{
 
        downloadLink.href = 'data:' + tipoDato + ', ' + tablaHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
}

//---------------------------------------------------------
//$('#myTab a[href="#profile"]').tab('show')
