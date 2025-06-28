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

        console.log("llego aqui5");
        var direccion=window.location.href.replace("rendicionDeCuentas","");
    
        //Envió de consulta por metodo GET.
    
        $.get(direccion+"consultaPolizas",$("#form_polizas").serialize()) //"q":fechaI.val(),"r":fechaF.val(),"p":tipoReporte.val()
            .fail(function(){
    
                alert("Datos no recibidos");
    
            })
            .done(function(data){
    
                var jsonObject=JSON.parse(data);
                console.log(jsonObject);
                
                var opciones_li=``;
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
                    
                        if($("#idPersona_reporte").val()==224 || $("#idPersona_reporte").val()==667){
                            info_reporte+=`<div id="mes_`+mes+`" style="display: none">
    
                                <div class="panel panel-info"> <!--class="contenedor_personal"-->
                                    <div class="panel-heading"><h5><i class="fa fa-check-circle" aria-hidden="true"></i>&nbspConteo de pólizas por vendedor</h5></div>
                                    <div class="panel-body">
                                        <div id="contenedor_lista_ramos_`+mes+`">
                                            <table class="table table-striped" id="tabla_personal_`+mes+`">
                                                <thead>
                                                    <tr class="active">
                                                        <td class="text-center text-danger">Colaborador</td>
                                                        <td class="text-center text-success">GMM</td>
                                                        <td class="text-center text-danger">VIDA</td>
                                                        <td class="text-center text-warning">DAÑOS</td>
                                                        <td class="text-center text-info">AUTOS</td>
                                                        <td class="text-center text-default">AP</td>
                                                        <td class="text-center text-warning">TOTAL POLIZAS</td>
                                                        <td class="text-center text-warning">TOTAL PRIMA ACUMULADA</td>
                                                        <td class="text-center text-warning">TOTAL COMISIÓN ACUMULADA</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabla_cuerpo_colaborador">`;
        
                                                $.each(datos.vendedores, function(ven, info){
                                                    info_reporte+=`
                                                        <tr>
                                                            <td class="text-left">`+info.nombre+`</td>`;
        
                                                            $.each(info.ramos_unitario, function(r,cant_polizas){
        
                                                                if(r!="Fianzas"){
                                                                    info_reporte+=`
                                                                        <td>`+cant_polizas+`</td>
                                                                    `;
                                                                }
                                                            });
        
                                                        info_reporte+=`
                                                            <td>`+info.conte_total_polizas+`</td>
                                                            <td>$ `+new Intl.NumberFormat().format(info.prima_unitaria)+`</td>
                                                            <td>$ `+new Intl.NumberFormat().format(info.comision_unitaria)+`</td>
                                                        </tr>
                                                    `;
                                                });
        
                                                info_reporte+=`</tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="panel panel-info" style="overflow: auto;">
                                    <div class="panel-heading"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbspPrimas y comisiones por vendedor</div>
                                    <div class="panel-body">
                                        <div style="overflow-y: scroll; height: 400px;">
                                            <table class="table table-striped" id="tabla_personal_d_`+mes+`">
                                                <thead>
                                                    <tr class="active">
                                                        <td class="text-center text-danger">Vendedor</td>
                                                        <td>Semana 1</td>
                                                        <td>Semana 2</td>
                                                        <td>Semana 3</td>
                                                        <td>Semana 4</td>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                                            
                                        $.each(datos.vendedores, function(v,datos){
                                            info_reporte+=`
                                                <tr>
                                                    <td class="text-left">`+datos.nombre+`</td>`;
                                                    $.each(datos.semanas, function(s,data_g){
                                                        info_reporte+=`
                                                            <td class="text-left">
                                                                <a href="#" class="text-default">Polizas: <span class="badge"> `+data_g.poliza_semanal+`</span></a><br><br>
                                                                <a href="#" class="text-warning">Primas: <span class="badge">$ `+new Intl.NumberFormat().format(data_g.prima_semanal.toFixed(2))+`</span></a><br><br>
                                                                <a href="#" class="text-success">Comisión: <span class="badge">$ `+new Intl.NumberFormat().format(data_g.comision_semanal.toFixed(2))+`</span></a>
                                                            </td>
                                                        `;
                                                    });
                                                info_reporte+=`</tr>
                                            `;
                                        });
                                        
                                    info_reporte+=`
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
    
                                <div id="contenedor_informacion" class="panel panel-info">
                                    <div class="panel-heading"><h5><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbspReporte de primas y comisiones</h5></div>
                                    <div class="panel-body">
                                        <table class="table table-bordered" id="tabla_info_`+mes+`">
                                            <tbody>
                                                <tr>
                                                    <td>`+datos.cantidadPolizas+`</td>
                                                    <td class="text-left">Pólizas emitidas</td>
                                                    <td>Meta comercial</td>
                                                    <td>Fecha inicio</td>
                                                    <!--<td>Semana 1</td>
                                                    <td>Semana 2</td>
                                                    <td>Semana 3</td>
                                                    <td>Semana 4</td>
                                                    <td>Semana 5</td>-->`;

                                                    var cont_fecha=0;

                                                    $.each(datos.semanas, function(sem,fechas){

                                                        cont_fecha++;

                                                        if(fechas.rangoFecha!="0 - 0"){

                                                            info_reporte+=`<td>`+fechas.rangoFecha+`</td>`

                                                        } else{

                                                            info_reporte+=`<td> Semana `+cont_fecha+`</td>`

                                                        }
                                                       
                                                    });

                                                    info_reporte+=`<td>Avance</td>
                                                </tr>
                                                <tr>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.primaEmitidas)+`</td>
                                                    <td class="text-left">Prima Emitida</td>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.metaComercial)+`</td>
                                                    <td>`+datos.fechaInicio+`</td>
                                                    <td>20%</td>
                                                    <td>40%</td>
                                                    <td>60%</td>
                                                    <td>80%</td>
                                                    <td>100%</td>
                                                </tr>
                                                <tr>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.primasCobradas)+`</td>
                                                    <td class="text-left">Prima Cobrada</td>
                                                    <td class="text-center"><h5><span class="label label-warning">Recibos<span></h5></td>
                                                </tr>
                                                <tr>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.primasPendientes)+`</td>
                                                    <td class="text-left">Prima por cobrar</td>
                                                    <td colspan="2">IDEAL</td>`; 
                                                    
                                                    $.each(datos.semanas, function(num_sem_com,datos_sem_comision){
                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(datos_sem_comision.ideal)+`</td>`;
                                                    });
                                                   
                                                    info_reporte+=`</tr>
                                                <tr>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.comisionEmitida)+`</td>
                                                    <td class="text-left">Comisión generada</td>
                                                    <td colspan="2">REAL</td>`;

                                                    $.each(datos.semanas, function(num_sem,datosSemanal){
                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(datosSemanal.comisionPagada)+`</td>`;
                                                    });

                                                    info_reporte+=`</tr>
                                                <tr>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.comisionCobrada)+`</td>
                                                    <td class="text-left">Comisión cobrada</td>
                                                    <td class="text-center"><h5><span class="label label-warning">Recibo y subsecuentes<span></h5></td>
                                                </tr>
                                                <tr>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.comisionPendiente)+`</td>
                                                    <td class="text-left">Comisión pendiente</td>
                                                    <td colspan="2">IDEAL</td>`;

                                                    $.each(datos.semanas, function(num_sem,datosSemanal){
                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(datosSemanal.ideal)+`</td>`;
                                                    });

                                                    info_reporte+=`</tr>
                                                <tr>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.comisionEmitida/datos.cantidadPolizas)+`</td>
                                                    <td class="text-left">Comisión promedio del mes</td>
                                                    <td colspan="2">REAL</td>`;

                                                    $.each(datos.semanas, function(num_sem,subsecuenteSemanal){
                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(subsecuenteSemanal.comisionSubsecuente)+`</td>`;
                                                    });

                                                info_reporte+=`</tr>
                                                <tr>
                                                    <td></td>
                                                    <td class="text-left">Comisión promedio de la semana</td>
                                                    <td colspan="2"></td>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.semanas.sem_1.comisionPagada/datos.semanas.sem_1.polizas)+`</td>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.semanas.sem_2.comisionPagada/datos.semanas.sem_2.polizas)+`</td>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.semanas.sem_3.comisionPagada/datos.semanas.sem_3.polizas)+`</td>
                                                    <td>$ `+new Intl.NumberFormat().format(datos.semanas.sem_4.comisionPagada/datos.semanas.sem_4.polizas)+`</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

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

                                <div id="link_descarga`+mes+`">
                                    <button class="btn btn-primary" onclick="exportarAExcel(`+mes+`)">Exportar resultado a fichero Excel</button>
                                </div>
                            </div>`;
                        } 
                        if($("#idPersona_reporte").val()==805){
                            info_reporte+=`<div id="mes_`+mes+`" style="display: none">
    
                            <div id="contenedor_personal" class="panel panel-info">
                                <div class="panel-heading"><h5><i class="fa fa-check-circle" aria-hidden="true"></i>&nbspConteo de pólizas por vendedor</h5></div>
                                <div class="panel-body">
                                    <table class="table table-striped" id="tabla_personal_`+mes+`">
                                        <thead>
                                            <tr class="active">
                                                <td class="text-center text-danger">Colaborador</td>
                                                <td class="text-center text-success">FIANZAS</td>
                                                <td class="text-center text-warning">TOTAL POLIZAS</td>
                                                <td class="text-center text-warning">TOTAL PRIMA ACUMULADA</td>
                                                <td class="text-center text-warning">TOTAL COMISIÓN ACUMULADA</td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabla_cuerpo_colaborador">`;
    
                                        $.each(datos.vendedores, function(ven, info){
                                            info_reporte+=`
                                                <tr>
                                                    <td>`+info.nombre+`</td>`;
    
                                            $.each(info.ramos_unitario, function(r,cantida_poliza){
                                                
                                                if(r=="Fianzas"){
                                                    info_reporte+=`<td>`+cantida_poliza+`</td>`;
                                                }
                                            })
    
                                            info_reporte+=`
                                                <td>`+info.conte_total_polizas+`</td>
                                                <td>`+info.prima_unitaria+`</td>
                                                <td>`+info.comision_unitaria+`</td>
                                            </tr>
                                            `;
                                        });
    
                                        info_reporte+=`</tbody>
                                    </table>
                                </div>
                            </div>
    
                            <div class="panel panel-info" style="overflow: auto;">
                                <div class="panel-heading"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbspPrimas y comisiones por vendedor</div>
                                <div class="panel-body">
                                    <table class="table table-striped" id="tabla_personal_d_`+mes+`">
                                        <thead>
                                            <tr class="active">
                                                <td class="text-center text-danger">Vendedor</td>
                                                <td>Semana 1</td>
                                                <td>Semana 2</td>
                                                <td>Semana 3</td>
                                                <td>Semana 4</td>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                                        
                                    $.each(datos.vendedores, function(v,datos){
                                        info_reporte+=`
                                            <tr>
                                                <td class="text-left">`+datos.nombre+`</td>`;
                                                $.each(datos.semanas, function(s,data_g){
                                                    info_reporte+=`
                                                        <td class="text-left">
                                                            <a href="#" class="text-default">Polizas: <span class="badge"> `+data_g.poliza_semanal+`</span></a><br><br>
                                                            <a href="#" class="text-warning">Primas: <span class="badge">$ `+new Intl.NumberFormat().format(data_g.prima_semanal.toFixed(2))+`</span></a><br><br>
                                                            <a href="#" class="text-success">Comisión: <span class="badge">$ `+new Intl.NumberFormat().format(data_g.comision_semanal.toFixed(2))+`</span></a>
                                                        </td>
                                                    `;
                                                });
                                            info_reporte+=`</tr>
                                        `;
                                    });
                                    
                                info_reporte+=`
                                        </tbody>
                                    </table>
                                </div>
                            </div>
    
                            <div id="contenedor_informacion_fianzas" class="panel panel-info">
                                <div class="panel-heading"><h5><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbspReporte de primas y comisiones</h5></div>
                                <div class="panel-body">
                                    <table class="table table-bordered" id="tabla_info_`+mes+`">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <!--<td>fecha 1</td>
                                                <td>fecha 2</td>
                                                <td>fecha 3</td>
                                                <td>fecha 4</td>
                                                <td>fecha 5</td>-->`;
                                                
                                                var cont_sem=0;
                                                $.each(datos.semanas, function(num_sem,fecha_semana){
                                                    
                                                    cont_sem++;

                                                    if(fecha_semana.rangoFecha!="0 - 0"){

                                                        info_reporte+=`<td>`+fecha_semana.rangoFecha+`</td>`
                                                    }else{

                                                        info_reporte+=`<td> Semana `+cont_sem+`</td>`;
                                                    }
                                                    
                                                });

                                                info_reporte+=`<td>Total mensual</td>
                                                <td>F.Inicio</td>
                                                <td>Sem 1</td>
                                                <td>Sem 2</td>
                                                <td>Sem 3</td>
                                                <td>Sem 4</td>
                                                <td>Avance</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Pólizas emitidas</td>`;

                                                var sum_polizas=0;
                                                $.each(datos.semanas, function(sem_num,sem_polizas){

                                                    sum_polizas+=sem_polizas.polizas;

                                                    info_reporte+=`<td>`+sem_polizas.polizas+`</td>`;
                                                });

                                                info_reporte+=`<td>`+sum_polizas+`</td>
                                                <td>`+datos.fechaInicio+`</td>
                                                <td>20%</td>
                                                <td>40%</td>
                                                <td>60%</td>
                                                <td>80%</td>
                                                <td>100%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Prima emitida</td>`;

                                                var s_p_e=0;

                                                $.each(datos.semanas, function(num_sem,sem_prima){
                                                    
                                                    s_p_e+=sem_prima.primaEmitida
                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(sem_prima.primaEmitida.toFixed(2))+`</td>`;
                                                });

                                            info_reporte+=`
                                                <td>$ `+new Intl.NumberFormat().format(s_p_e.toFixed(2))+`</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Prima cobrada</td>`;

                                                var s_p_c=0;

                                                $.each(datos.semanas, function(sem_num,sem_pp){

                                                    s_p_c+=sem_pp.primaPagada;

                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(sem_pp.primaPagada.toFixed(2))+`</td>`;

                                                });

                                                info_reporte+=`<td>$ `+new Intl.NumberFormat().format(s_p_c.toFixed(2))+`</td>
                                                <td class="text-right">IDEAL</td>`;

                                                $.each(datos.semanas, function(sem_num,sem_i){

                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(sem_i.ideal.toFixed(2))+`</td>`;

                                                });

                                                info_reporte+=`
                                                <td>100%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Prima por cobrar</td>`;

                                                var s_p_pe=0;

                                                $.each(datos.semanas, function(num_sem,sem_ppe){

                                                    s_p_pe+=sem_ppe.primaPendiente;

                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(sem_ppe.primaPendiente)+`</td>`;

                                                });

                                                var real_sem1=datos.semanas.sem_1.real; //(datos.semanas.sem_1.real>0) ? datos.semanas.sem_1.real : 0;
                                                var real_sem2=real_sem1+datos.semanas.sem_2.real; //(datos.semanas.sem_2.real>0) ? real_sem1+datos.semanas.sem_2.real : 0;
                                                var real_sem3=real_sem2+datos.semanas.sem_3.real; //(datos.semanas.sem_3.real>0) ? real_sem2+datos.semanas.sem_3.real : 0; //real_sem2+datos.semanas.sem_3.real;
                                                var real_sem4=real_sem3+datos.semanas.sem_4.real; //(datos.semanas.sem_4.real>0) ? real_sem3+datos.semanas.sem_4.real : 0; //real_sem3+datos.semanas.sem_4.real;

                                                var avance_real=real_sem4/datos.semanas.sem_4.ideal;

                                                info_reporte+=`<td>$ `+new Intl.NumberFormat().format(s_p_pe.toFixed(2))+`</td>
                                                <td class="text-right">REAL</td>
                                                <td>$ `+new Intl.NumberFormat().format(real_sem1.toFixed(2))+`</td>
                                                <td>$ `+new Intl.NumberFormat().format(real_sem2.toFixed(2))+`</td>
                                                <td>$ `+new Intl.NumberFormat().format(real_sem3.toFixed(2))+`</td>
                                                <td>$ `+new Intl.NumberFormat().format(real_sem4.toFixed(2))+`</td>
                                                <td>`+avance_real.toFixed(2)+`%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Comisión generada</td>`;

                                                var s_c_e=0;

                                                $.each(datos.semanas, function(num_sem,sem_c_p){

                                                    s_c_e+=sem_c_p.comisionPagada;
                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(sem_c_p.comisionPagada.toFixed(2))+`</td>`;

                                                });

                                                info_reporte+=`
                                                <td>$ `+new Intl.NumberFormat().format(s_c_e.toFixed(2))+`</td>
                                                <td id="comisionEmitida"></td>
                                                <td class="text-center" colspan="4">Proyección</td>
                                                <td>`+new Intl.NumberFormat().format((datos.metaComercial*avance_real).toFixed(2))+`</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Comisión cobrada</td>`;

                                                var s_c_c=0;

                                                $.each(datos.semanas, function(num_sem,sem_c_c){

                                                    s_c_c+=sem_c_c.real;

                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(sem_c_c.real)+`</td>`;

                                                });

                                                info_reporte+=`
                                                <td>$ `+new Intl.NumberFormat().format(s_c_c.toFixed(2))+`</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Comisión pendiente</td>`;

                                                var s_c_pe=0;

                                                $.each(datos.semanas, function(sem_num,sem_comp){

                                                    s_c_pe+=sem_comp.comisionPendiente;

                                                    info_reporte+=`<td>`+new Intl.NumberFormat().format(sem_comp.comisionPendiente.toFixed(2))+`</td>`

                                                });

                                                info_reporte+=`<td>$ `+new Intl.NumberFormat().format(s_c_pe.toFixed(2))+`</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Comisión promedio</td>
                                                <td>$ `+new Intl.NumberFormat().format(datos.semanas.sem_1.comisionPagada/datos.semanas.sem_1.polizas)+`</td>
                                                <td>$ `+new Intl.NumberFormat().format(datos.semanas.sem_2.comisionPagada/datos.semanas.sem_2.polizas)+`</td>
                                                <td>$ `+new Intl.NumberFormat().format(datos.semanas.sem_3.comisionPagada/datos.semanas.sem_3.polizas)+`</td>
                                                <td>$ `+new Intl.NumberFormat().format(datos.semanas.sem_4.comisionPagada/datos.semanas.sem_4.polizas)+`</td>
                                                <td>$ `+new Intl.NumberFormat().format((datos.semanas.sem_1.comisionPagada/datos.semanas.sem_1.polizas)+(datos.semanas.sem_2.comisionPagada/datos.semanas.sem_2.polizas)+(datos.semanas.sem_3.comisionPagada/datos.semanas.sem_3.polizas)+(datos.semanas.sem_4.comisionPagada/datos.semanas.sem_4.polizas))+`</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                                <div id="link_descarga`+mes+`">
                                    <button class="btn btn-primary" onclick="exportarAExcel(`+mes+`)">Exportar resultado a fichero Excel</button>
                                </div>
                            </div>
                            
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
                            `;
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
function exportarAExcel(mes,filename=""){

    var downloadLink;
    var tipoDato = 'application/vnd.ms-excel';
    var tablainfo = document.getElementById("tabla_info_"+mes);
    var tablaregP = document.getElementById("tabla_excel_"+mes);
    var tablaPersona=document.getElementById("tabla_personal_"+mes);
    //var tablainfo=$("#tabla_info_"+mes);
    var tablaHTML2=tablainfo.outerHTML.replace(/ /g, '%20');
    var tablaHTML3=tablaregP.outerHTML.replace(/ /g, '%20');
    var tablaHTML1=tablaPersona.outerHTML.replace(/ /g, '%20');

    var tablaHTML=tablaHTML1+tablaHTML3+tablaHTML2;

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
