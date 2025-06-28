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
        
        //var jsonObject_global={};

        $.get(direccion+"consultaPolizas",$("#form_polizas").serialize()) //"q":fechaI.val(),"r":fechaF.val(),"p":tipoReporte.val()
            
            .fail(function(){
    
                alert("Datos no recibidos");
    
            })
            .done(function(data){

                $("#gif_carga").hide();
    
                var jsonObject=JSON.parse(data);
                //jsonObject_global=JSON.parse(data);
                //console.log(jsonObject);
                
                var opciones_li=``;
                var reportes_li=``;
                var info_reporte=``;
                info_reporte+=`<div  id="myTabContent" style="width: 100%">`;
                
                var object_container={};
                var object_recibos={};
                //var vend_info_s1=[];
                //var prueba_pn_s1={};

                //---------------------------Armado del objeto---------------------------------

                console.log(jsonObject)
                $.each(jsonObject.datosMensuales, function(mes, r_t){

                    var mes_reg=[];
                    //object_container[mes]=5; // inicializa en mes.
                    
                    //console.log(r_t.segmentacionDeFechas[1]);

                    //Recorrido de cada tipo de recibo generado.
                    //------------------------------------------------------
                    //Recorrido de pólizas nuevas.
                    var pn_semana={};
                    var prima_s1_polizaNueva=0;
                    var prima_s2_polizaNueva=0;
                    var prima_s3_polizaNueva=0;
                    var prima_s4_polizaNueva=0;

                    var comision_s1_polizaNueva=0;
                    var comision_s2_polizaNueva=0;
                    var comision_s3_polizaNueva=0;
                    var comision_s4_polizaNueva=0;

                    var cont_pn_s1=0;
                    var cont_pn_s2=0;
                    var cont_pn_s3=0;
                    var cont_pn_s4=0;

                    var prueba_pn_s1={};
                    var prueba_pn_s2={};
                    var prueba_pn_s3={};
                    var prueba_pn_s4={};
                    //var info_prueba={};

                    var vend_pn_s1=[];
                    var vend_total={};
                    var vend_pn_sem={};
                    var vend_info_s1=[];
                    var vend_info_s2=[];
                    var vend_info_s3=[];
                    var vend_info_s4=[];
                    

                    var index_poliza={};

                    $.each(r_t.PolizasNuevas, function(r_s,r_n){

                        $.each(r_n, function(f_pn, info_pn){ //for(i);
                            
                            if(info_pn.Ramo=="GASTOS MEDICOS FAMILIAR"){
                                info_pn.Ramo="GMM";
                            } 
                            if(info_pn.Ramo=="Viaje"){
                                info_pn.Ramo="AP";
                            }

                            if(f_pn >= r_t.segmentacionDeFechas[0][0] && f_pn <= r_t.segmentacionDeFechas[0][1]){

                                prima_s1_polizaNueva+=info_pn.PrimaPolizaNueva;
                                comision_s1_polizaNueva+=info_pn.ComisionPolizaNueva;
                                cont_pn_s1++;

                                //vend_pn_s1.push(info_pn.idVendedor);
                                
                                prueba_pn_s1={
                                    "idVendedor": info_pn.idVendedor,
                                    "Nombre": info_pn.Nombre,
                                    "Prima": info_pn.PrimaPolizaNueva,
                                    "Comision": info_pn.ComisionPolizaNueva,
                                    "Ramo": info_pn.Ramo
                                }

                                vend_info_s1.push(prueba_pn_s1);

                                vend_pn_sem["sem_1"]=vend_info_s1;
                                
                            }
                            if(f_pn >= r_t.segmentacionDeFechas[1][0] && f_pn <= r_t.segmentacionDeFechas[1][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s2_polizaNueva+=info_pn.PrimaPolizaNueva;
                                comision_s2_polizaNueva+=info_pn.ComisionPolizaNueva;
                                cont_pn_s2++;
                                
                                prueba_pn_s2={
                                    "idVendedor": info_pn.idVendedor,
                                    "Nombre": info_pn.Nombre,
                                    "Prima": info_pn.PrimaPolizaNueva,
                                    "Comision": info_pn.ComisionPolizaNueva,
                                    "Ramo": info_pn.Ramo
                                }

                                vend_info_s2.push(prueba_pn_s2);

                                vend_pn_sem["sem_2"]=vend_info_s2;

                            }
                            if(f_pn >= r_t.segmentacionDeFechas[2][0] && f_pn <= r_t.segmentacionDeFechas[2][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s3_polizaNueva+=info_pn.PrimaPolizaNueva;
                                comision_s3_polizaNueva+=info_pn.ComisionPolizaNueva;
                                cont_pn_s3++;

                                prueba_pn_s3={
                                    "idVendedor": info_pn.idVendedor,
                                    "Nombre": info_pn.Nombre,
                                    "Prima": info_pn.PrimaPolizaNueva,
                                    "Comision": info_pn.ComisionPolizaNueva,
                                    "Ramo": info_pn.Ramo
                                }

                                vend_info_s3.push(prueba_pn_s3);

                                vend_pn_sem["sem_3"]=vend_info_s3;
                                
                            }
                            if(f_pn >= r_t.segmentacionDeFechas[3][0] && f_pn <= r_t.segmentacionDeFechas[3][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s4_polizaNueva+=info_pn.PrimaPolizaNueva;
                                comision_s4_polizaNueva+=info_pn.ComisionPolizaNueva;
                                cont_pn_s4++;
                                
                                prueba_pn_s4={
                                    "idVendedor": info_pn.idVendedor,
                                    "Nombre": info_pn.Nombre,
                                    "Prima": info_pn.PrimaPolizaNueva,
                                    "Comision": info_pn.ComisionPolizaNueva,
                                    "Ramo": info_pn.Ramo
                                }

                                vend_info_s4.push(prueba_pn_s4);

                                vend_pn_sem["sem_4"]=vend_info_s4;
                            }
                        });

                        var seg_s1_pn={};
                        var seg_s2_pn={};
                        var seg_s3_pn={};
                        var seg_s4_pn={};

                        seg_s1_pn["PrimaAcumulada"]=prima_s1_polizaNueva;
                        seg_s1_pn["ComisionAcumulada"]=comision_s1_polizaNueva;
                        seg_s1_pn["PolizaAcumulada"]=cont_pn_s1;
                        seg_s1_pn["Poliza"]=cont_pn_s1;
                        //seg_s1_pn["Vendedores"]=vend_s1;
                        seg_s1_pn["MetaIdeal"]=r_t.MetaIdeal*1;
                        pn_semana["sem_1"]=seg_s1_pn;

                        seg_s2_pn["PrimaAcumulada"]=seg_s1_pn["PrimaAcumulada"]+prima_s2_polizaNueva;
                        seg_s2_pn["ComisionAcumulada"]=seg_s1_pn["ComisionAcumulada"]+comision_s2_polizaNueva;
                        seg_s2_pn["PolizaAcumulada"]=seg_s1_pn["PolizaAcumulada"]+cont_pn_s2;
                        seg_s2_pn["Poliza"]=cont_pn_s2;
                        seg_s2_pn["MetaIdeal"]=r_t.MetaIdeal*2;
                        pn_semana["sem_2"]=seg_s2_pn;

                        seg_s3_pn["PrimaAcumulada"]=seg_s2_pn["PrimaAcumulada"]+prima_s3_polizaNueva;
                        seg_s3_pn["ComisionAcumulada"]=seg_s2_pn["ComisionAcumulada"]+comision_s3_polizaNueva;
                        seg_s3_pn["PolizaAcumulada"]=seg_s2_pn["PolizaAcumulada"]+cont_pn_s3;
                        seg_s3_pn["Poliza"]=cont_pn_s3;
                        seg_s3_pn["MetaIdeal"]=r_t.MetaIdeal*3;
                        pn_semana["sem_3"]=seg_s3_pn;

                        seg_s4_pn["PrimaAcumulada"]=seg_s3_pn["PrimaAcumulada"]+prima_s4_polizaNueva;
                        seg_s4_pn["ComisionAcumulada"]=seg_s3_pn["ComisionAcumulada"]+comision_s4_polizaNueva;
                        seg_s4_pn["PolizaAcumulada"]=seg_s3_pn["PolizaAcumulada"]+cont_pn_s4;
                        seg_s4_pn["Poliza"]=cont_pn_s4;
                        seg_s4_pn["MetaIdeal"]=r_t.MetaIdeal*4;
                        pn_semana["sem_4"]=seg_s4_pn;

                        index_poliza["RecibosNuevos"]=pn_semana;
                        
                        //console.log(res);    

                    });
                    
                    vend_total["RecibosNuevos"]=vend_pn_sem;
                    //console.log(vend_total);

                    //if(vend_pn_sem.length>0){

                    var pn_v={};

                        //$.each(vend_pn_sem, function(s, info_vend){

                            //console.log(info_vend);
                           /* pn_v[s]=info_vend.reduce((acc, curr, index) => {
                          
                                if(curr.idVendedor in acc) {
                                  return {
                                    ...acc,
                                    [curr.idVendedor]: {
                                      Nombre: curr.Nombre,
                                      Prima: acc[curr.idVendedor].Prima + curr.Prima,
                                      Comision: acc[curr.idVendedor].Comision + curr.Comision,
                                      Ramo: {
                                          ...acc[curr.idVendedor].Ramo,
                                          [curr.Ramo]: (acc[curr.idVendedor].Ramo[curr.Ramo]) ? acc[curr.idVendedor].Ramo[curr.Ramo] + 1 : 1
                                      }
                                    }
                                  };
                                } else {
                                  return {
                                      ...acc,
                                    [curr.idVendedor]: {
                                      Nombre: curr.Nombre,
                                      Prima: curr.Prima,
                                      Comision: curr.Comision,
                                      Ramo:{
                                          [curr.Ramo]:1
                                      }
                                    }
                                  };
                                }
                              }, {});*/
                            
                        //}); 

                        //console.log(pn_v);

                    //------------------------------------------------------------------------
                    //Recorrido de pólizas subsecuentes.
                    var ps_semana={};
                    var prima_s1_polizaSubsecuente=0;
                    var prima_s2_polizaSubsecuente=0;
                    var prima_s3_polizaSubsecuente=0;
                    var prima_s4_polizaSubsecuente=0;

                    var comision_s1_polizaSubsecuente=0;
                    var comision_s2_polizaSubsecuente=0;
                    var comision_s3_polizaSubsecuente=0;
                    var comision_s4_polizaSubsecuente=0;

                    var cont_ps_s1=0;
                    var cont_ps_s2=0;
                    var cont_ps_s3=0;
                    var cont_ps_s4=0;

                    var prueba_ps_s1={};
                    var prueba_ps_s2={};
                    var prueba_ps_s3={};
                    var prueba_ps_s4={};
                    //var info_prueba={};

                    var vend_pn_s1=[];
                    //var vend_total={};
                    var vend_ps_sem={};
                    var vend_info_s_s1=[];
                    var vend_info_s_s2=[];
                    var vend_info_s_s3=[];
                    var vend_info_s_s4=[];

                    //var index_poliza_subsecuente={};

                    $.each(r_t.PolizasYSubsecuentes, function(rs_s,r_s){

                        //console.log(r_n); //->array

                        $.each(r_s, function(f_ps, info_ps){

                            if(info_ps.Ramo=="GASTOS MEDICOS FAMILIAR"){
                                info_ps.Ramo="GMM";
                            } 
                            if(info_ps.Ramo=="Viaje"){
                                info_ps.Ramo="AP";
                            }
                            
                            if(f_ps >= r_t.segmentacionDeFechas[0][0] && f_ps <= r_t.segmentacionDeFechas[0][1]){

                                prima_s1_polizaSubsecuente+=info_ps.PrimaPolizaSubsecuente;
                                comision_s1_polizaSubsecuente+=info_ps.ComisionPolizaSubsecuente;
                                cont_ps_s1++;

                                prueba_ps_s1={
                                    "idVendedor": info_ps.idVendedor,
                                    "Nombre": info_ps.Nombre,
                                    "Prima": info_ps.PrimaPolizaSubsecuente,
                                    "Comision": info_ps.ComisionPolizaSubsecuente,
                                    "Ramo": info_ps.Ramo
                                }

                                vend_info_s_s1.push(prueba_ps_s1);

                                vend_ps_sem["sem_1"]=vend_info_s_s1;

                            }
                            if(f_ps >= r_t.segmentacionDeFechas[1][0] && f_ps <= r_t.segmentacionDeFechas[1][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s2_polizaSubsecuente+=info_ps.PrimaPolizaSubsecuente;
                                comision_s2_polizaSubsecuente+=info_ps.ComisionPolizaSubsecuente;
                                cont_ps_s2++;
                                
                                prueba_ps_s2={
                                    "idVendedor": info_ps.idVendedor,
                                    "Nombre": info_ps.Nombre,
                                    "Prima": info_ps.PrimaPolizaSubsecuente,
                                    "Comision": info_ps.ComisionPolizaSubsecuente,
                                    "Ramo": info_ps.Ramo
                                }

                                vend_info_s_s2.push(prueba_ps_s2);

                                vend_ps_sem["sem_2"]=vend_info_s_s2;

                            }
                            if(f_ps >= r_t.segmentacionDeFechas[2][0] && f_ps <= r_t.segmentacionDeFechas[2][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s3_polizaSubsecuente+=info_ps.PrimaPolizaSubsecuente;
                                comision_s3_polizaSubsecuente+=info_ps.ComisionPolizaSubsecuente;
                                cont_ps_s3++;

                                prueba_ps_s3={
                                    "idVendedor": info_ps.idVendedor,
                                    "Nombre": info_ps.Nombre,
                                    "Prima": info_ps.PrimaPolizaSubsecuente,
                                    "Comision": info_ps.ComisionPolizaSubsecuente,
                                    "Ramo": info_ps.Ramo
                                }

                                vend_info_s_s3.push(prueba_ps_s3);

                                vend_ps_sem["sem_3"]=vend_info_s_s3;
                                
                            }
                            if(f_ps >= r_t.segmentacionDeFechas[3][0] && f_ps <= r_t.segmentacionDeFechas[3][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s4_polizaSubsecuente+=info_ps.PrimaPolizaSubsecuente;
                                comision_s4_polizaSubsecuente+=info_ps.ComisionPolizaSubsecuente;
                                cont_ps_s4++;
                                
                                prueba_ps_s4={
                                    "idVendedor": info_ps.idVendedor,
                                    "Nombre": info_ps.Nombre,
                                    "Prima": info_ps.PrimaPolizaSubsecuente,
                                    "Comision": info_ps.ComisionPolizaSubsecuente,
                                    "Ramo": info_ps.Ramo
                                }

                                vend_info_s_s4.push(prueba_ps_s4);

                                vend_ps_sem["sem_4"]=vend_info_s_s4;
                            }
                        })

                        var seg_s1_ps={};
                        var seg_s2_ps={};
                        var seg_s3_ps={};
                        var seg_s4_ps={};

                        seg_s1_ps["PrimaAcumulada"]=prima_s1_polizaSubsecuente;
                        seg_s1_ps["ComisionAcumulada"]=comision_s1_polizaSubsecuente;
                        seg_s1_ps["PolizaAcumulada"]=cont_ps_s1;
                        seg_s1_ps["Poliza"]=cont_ps_s1;
                        seg_s1_ps["MetaIdeal"]=r_t.MetaIdeal*1;
                        //seg_s1_ps["Vendedores"]=vend_s1;
                        ps_semana["sem_1"]=seg_s1_ps;

                        seg_s2_ps["PrimaAcumulada"]=seg_s1_ps["PrimaAcumulada"]+prima_s2_polizaSubsecuente;
                        seg_s2_ps["ComisionAcumulada"]=seg_s1_ps["ComisionAcumulada"]+comision_s2_polizaSubsecuente;
                        seg_s2_ps["PolizaAcumulada"]=seg_s1_ps["PolizaAcumulada"]+cont_ps_s2;
                        seg_s2_ps["Poliza"]=cont_ps_s2;
                        seg_s2_ps["MetaIdeal"]=r_t.MetaIdeal*2;
                        ps_semana["sem_2"]=seg_s2_ps;

                        seg_s3_ps["PrimaAcumulada"]=seg_s2_ps["PrimaAcumulada"]+prima_s3_polizaSubsecuente;
                        seg_s3_ps["ComisionAcumulada"]=seg_s2_ps["ComisionAcumulada"]+comision_s3_polizaSubsecuente;
                        seg_s3_ps["PolizaAcumulada"]=seg_s2_ps["PolizaAcumulada"]+cont_ps_s3;
                        seg_s3_ps["Poliza"]=cont_ps_s3;
                        seg_s3_ps["MetaIdeal"]=r_t.MetaIdeal*3;
                        ps_semana["sem_3"]=seg_s3_ps;

                        seg_s4_ps["PrimaAcumulada"]=seg_s3_ps["PrimaAcumulada"]+prima_s4_polizaSubsecuente;
                        seg_s4_ps["ComisionAcumulada"]=seg_s3_ps["ComisionAcumulada"]+comision_s4_polizaSubsecuente;
                        seg_s4_ps["PolizaAcumulada"]=seg_s3_ps["PolizaAcumulada"]+cont_ps_s4;
                        seg_s4_ps["Poliza"]=cont_ps_s4;
                        seg_s4_ps["MetaIdeal"]=r_t.MetaIdeal*4;
                        ps_semana["sem_4"]=seg_s4_ps;

                        index_poliza["RecibosYSubsecuentes"]=ps_semana;
                        
                    })

                    vend_total["RecibosYSubsecuentes"]=vend_ps_sem;

                    //console.log(vend_total);
                    //------------------------------------------------------------------------
                    //Recorrido de pólizas pagadas.
                    var pt_semana={};
                    var prima_s1_polizaPagada=0;
                    var prima_s2_polizaPagada=0;
                    var prima_s3_polizaPagada=0;
                    var prima_s4_polizaPagada=0;

                    var comision_s1_polizaPagada=0;
                    var comision_s2_polizaPagada=0;
                    var comision_s3_polizaPagada=0;
                    var comision_s4_polizaPagada=0;

                    var cont_pt_s1=0;
                    var cont_pt_s2=0;
                    var cont_pt_s3=0;
                    var cont_pt_s4=0;

                    var prueba_pc_s1={};
                    var prueba_pc_s2={};
                    var prueba_pc_s3={};
                    var prueba_pc_s4={};
                    //var info_prueba={};

                    var vend_pn_s1=[];
                    //var vend_total={};
                    var vend_pc_sem={};
                    var vend_info_c_s1=[];
                    var vend_info_c_s2=[];
                    var vend_info_c_s3=[];
                    var vend_info_c_s4=[];
                    //var index_poliza_subsecuente={};

                    $.each(r_t.PolizasCobradas, function(rc_s,r_c){

                        //console.log(r_n); //->array

                        $.each(r_c, function(f_pc, info_pc){

                            if(info_pc.Ramo=="GASTOS MEDICOS FAMILIAR"){
                                info_pc.Ramo="GMM";
                            }
                            if(info_pc.Ramo=="Viaje"){
                                info_pc.Ramo="AP";
                            }
                            
                            if(f_pc >= r_t.segmentacionDeFechas[0][0] && f_pc <= r_t.segmentacionDeFechas[0][1]){

                                prima_s1_polizaPagada+=info_pc.PrimaPolizaTotal;
                                comision_s1_polizaPagada+=info_pc.ComisionPolizaTotal;
                                cont_pt_s1++;

                                if(info_pc.Ramo=="GASTOS MEDICOS FAMILIAR"){
                                    info_pc.Ramo="GMM";
                                } else if(info_pc.Ramo=="GASTOS MEDICOS FAMILIAR"){
                                    info_pc.Ramo="AP";
                                }

                                prueba_pc_s1={
                                    "idVendedor": info_pc.idVendedor,
                                    "Nombre": info_pc.Nombre,
                                    "Prima": info_pc.PrimaPolizaTotal,
                                    "Comision": info_pc.ComisionPolizaTotal,
                                    "Ramo": info_pc.Ramo
                                }

                                vend_info_c_s1.push(prueba_pc_s1);

                                vend_pc_sem["sem_1"]=vend_info_c_s1;
                            }
                            if(f_pc >= r_t.segmentacionDeFechas[1][0] && f_pc <= r_t.segmentacionDeFechas[1][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s2_polizaPagada+=info_pc.PrimaPolizaTotal;
                                comision_s2_polizaPagada+=info_pc.ComisionPolizaTotal;
                                cont_pt_s2++;
                                
                                prueba_pc_s2={
                                    "idVendedor": info_pc.idVendedor,
                                    "Nombre": info_pc.Nombre,
                                    "Prima": info_pc.PrimaPolizaTotal,
                                    "Comision": info_pc.ComisionPolizaTotal,
                                    "Ramo": info_pc.Ramo
                                }

                                vend_info_c_s2.push(prueba_pc_s2);

                                vend_pc_sem["sem_2"]=vend_info_c_s2;
                            }
                            if(f_pc >= r_t.segmentacionDeFechas[2][0] && f_pc <= r_t.segmentacionDeFechas[2][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s3_polizaPagada+=info_pc.PrimaPolizaTotal;
                                comision_s3_polizaPagada+=info_pc.ComisionPolizaTotal;
                                cont_pt_s3++;
                                
                                prueba_pc_s3={
                                    "idVendedor": info_pc.idVendedor,
                                    "Nombre": info_pc.Nombre,
                                    "Prima": info_pc.PrimaPolizaTotal,
                                    "Comision": info_pc.ComisionPolizaTotal,
                                    "Ramo": info_pc.Ramo
                                }

                                vend_info_c_s3.push(prueba_pc_s3);

                                vend_pc_sem["sem_3"]=vend_info_c_s3;
                            }
                            if(f_pc >= r_t.segmentacionDeFechas[3][0] && f_pc <= r_t.segmentacionDeFechas[3][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s4_polizaPagada+=info_pc.PrimaPolizaTotal;
                                comision_s4_polizaPagada+=info_pc.ComisionPolizaTotal;
                                cont_pt_s4++;
                                
                                prueba_pc_s4={
                                    "idVendedor": info_pc.idVendedor,
                                    "Nombre": info_pc.Nombre,
                                    "Prima": info_pc.PrimaPolizaTotal,
                                    "Comision": info_pc.ComisionPolizaTotal,
                                    "Ramo": info_pc.Ramo
                                }

                                vend_info_c_s4.push(prueba_pc_s4);

                                vend_pc_sem["sem_4"]=vend_info_c_s4;
                            }
                        })

                        var seg_s1_pc={};
                        var seg_s2_pc={};
                        var seg_s3_pc={};
                        var seg_s4_pc={};

                        seg_s1_pc["Prima"]=prima_s1_polizaPagada;
                        seg_s1_pc["Comision"]=comision_s1_polizaPagada;
                        seg_s1_pc["PrimaAcumulada"]=prima_s1_polizaPagada;
                        seg_s1_pc["ComisionAcumulada"]=comision_s1_polizaPagada;
                        seg_s1_pc["PolizaAcumulada"]=cont_pt_s1;
                        seg_s1_pc["Poliza"]=cont_pt_s1;
                        seg_s1_pc["MetaIdeal"]=r_t.MetaIdeal*1;
                        //seg_s1_ps["Vendedores"]=vend_s1;
                        pt_semana["sem_1"]=seg_s1_pc;

                        seg_s2_pc["Prima"]=prima_s2_polizaPagada;
                        seg_s2_pc["Comision"]=comision_s2_polizaPagada;
                        seg_s2_pc["PrimaAcumulada"]=seg_s1_pc["PrimaAcumulada"]+prima_s2_polizaPagada;
                        seg_s2_pc["ComisionAcumulada"]=seg_s1_pc["ComisionAcumulada"]+comision_s2_polizaPagada;
                        seg_s2_pc["PolizaAcumulada"]=seg_s1_pc["PolizaAcumulada"]+cont_pt_s2;
                        seg_s2_pc["Poliza"]=cont_pt_s2;
                        seg_s2_pc["MetaIdeal"]=r_t.MetaIdeal*2;
                        pt_semana["sem_2"]=seg_s2_pc;

                        seg_s3_pc["Prima"]=prima_s3_polizaPagada;
                        seg_s3_pc["Comision"]=comision_s3_polizaPagada;
                        seg_s3_pc["PrimaAcumulada"]=seg_s2_pc["PrimaAcumulada"]+prima_s3_polizaPagada;
                        seg_s3_pc["ComisionAcumulada"]=seg_s2_pc["ComisionAcumulada"]+comision_s3_polizaPagada;
                        seg_s3_pc["PolizaAcumulada"]=seg_s2_pc["PolizaAcumulada"]+cont_pt_s3;
                        seg_s3_pc["Poliza"]=cont_pt_s3;
                        seg_s3_pc["MetaIdeal"]=r_t.MetaIdeal*3;
                        pt_semana["sem_3"]=seg_s3_pc;

                        seg_s4_pc["Prima"]=prima_s4_polizaPagada;
                        seg_s4_pc["Comision"]=comision_s4_polizaPagada;
                        seg_s4_pc["PrimaAcumulada"]=seg_s3_pc["PrimaAcumulada"]+prima_s4_polizaPagada;
                        seg_s4_pc["ComisionAcumulada"]=seg_s3_pc["ComisionAcumulada"]+comision_s4_polizaPagada;
                        seg_s4_pc["PolizaAcumulada"]=seg_s3_pc["PolizaAcumulada"]+cont_pt_s4;
                        seg_s4_pc["Poliza"]=cont_pt_s4;
                        seg_s4_pc["MetaIdeal"]=r_t.MetaIdeal*4;
                        pt_semana["sem_4"]=seg_s4_pc;

                        index_poliza["RecibosTotales"]=pt_semana;
                        
                    })

                    vend_total["RecibosTotales"]=vend_pc_sem;
                    //console.log(vend_total);
                    //------------------------------------------------------------------------
                    //Recorrido de pólizas emitidas y pendientes.
                    //var cont_emitidos={};
                    var pe_semana={};
                    var pp_semana={};
                    var prima_s1_polizaEmitida=0;
                    var prima_s2_polizaEmitida=0;
                    var prima_s3_polizaEmitida=0;
                    var prima_s4_polizaEmitida=0;

                    var comision_s1_polizaEmitida=0;
                    var comision_s2_polizaEmitida=0;
                    var comision_s3_polizaEmitida=0;
                    var comision_s4_polizaEmitida=0;

                    var prima_s1_polizaEmitidaPendiente=0;
                    var prima_s2_polizaEmitidaPendiente=0;
                    var prima_s3_polizaEmitidaPendiente=0;
                    var prima_s4_polizaEmitidaPendiente=0;

                    var comision_s1_polizaEmitidaPendiente=0;
                    var comision_s2_polizaEmitidaPendiente=0;
                    var comision_s3_polizaEmitidaPendiente=0;
                    var comision_s4_polizaEmitidaPendiente=0;

                    var cont_pe_s1=0;
                    var cont_pe_s2=0;
                    var cont_pe_s3=0;
                    var cont_pe_s4=0;

                    var prueba_pe_s1={};
                    var prueba_pe_s2={};
                    var prueba_pe_s3={};
                    var prueba_pe_s4={};
                    //var info_prueba={};

                    var vend_pn_s1=[];
                    //var vend_total={};
                    var vend_pe_sem={};
                    var vend_info_e_s1=[];
                    var vend_info_e_s2=[];
                    var vend_info_e_s3=[];
                    var vend_info_e_s4=[];
                   
                    var pol_e_s1=[];

                    var estatus_pol_p={};
                    var estatus_pol_e={};
                    
                    //var cont_emitidos=[];
                    //var index_poliza_subsecuente={};

                    $.each(r_t.PolizasEmitidas, function(re_s,r_e){

                        //console.log(r_n); //->array

                        $.each(r_e, function(f_pe, info_pe){

                            if(info_pe.Ramo=="GASTOS MEDICOS FAMILIAR"){
                                info_pe.Ramo="GMM";
                            }
                            if(info_pe.Ramo=="Viaje"){
                                info_pe.Ramo="AP";
                            }

                            if(f_pe >= r_t.segmentacionDeFechas[0][0] && f_pe <= r_t.segmentacionDeFechas[0][1]){

                                prima_s1_polizaEmitida+=info_pe.PrimaPolizaEmitida;
                                comision_s1_polizaEmitida+=info_pe.ComisionPolizaEmitida;
                                cont_pe_s1++;

                                prueba_pe_s1={
                                    "idVendedor": info_pe.idVendedor,
                                    "Nombre": info_pe.Nombre,
                                    "Prima": info_pe.PrimaPolizaEmitida,
                                    "Comision": info_pe.ComisionPolizaEmitida,
                                    "Ramo": info_pe.Ramo
                                }

                                vend_info_e_s1.push(prueba_pe_s1);

                                vend_pe_sem["sem_1"]=vend_info_e_s1;
                            }
                            if(f_pe >= r_t.segmentacionDeFechas[1][0] && f_pe <= r_t.segmentacionDeFechas[1][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s2_polizaEmitida+=info_pe.PrimaPolizaEmitida;
                                comision_s2_polizaEmitida+=info_pe.ComisionPolizaEmitida;
                                cont_pe_s2++;
                                
                                prueba_pe_s2={
                                    "idVendedor": info_pe.idVendedor,
                                    "Nombre": info_pe.Nombre,
                                    "Prima": info_pe.PrimaPolizaEmitida,
                                    "Comision": info_pe.ComisionPolizaEmitida,
                                    "Ramo": info_pe.Ramo
                                }

                                vend_info_e_s2.push(prueba_pe_s2);

                                vend_pe_sem["sem_2"]=vend_info_e_s2;
                            }
                            if(f_pe >= r_t.segmentacionDeFechas[2][0] && f_pe <= r_t.segmentacionDeFechas[2][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s3_polizaEmitida+=info_pe.PrimaPolizaEmitida;
                                comision_s3_polizaEmitida+=info_pe.ComisionPolizaEmitida;
                                cont_pe_s3++;
                                
                                prueba_pe_s3={
                                    "idVendedor": info_pe.idVendedor,
                                    "Nombre": info_pe.Nombre,
                                    "Prima": info_pe.PrimaPolizaEmitida,
                                    "Comision": info_pe.ComisionPolizaEmitida,
                                    "Ramo": info_pe.Ramo
                                }

                                vend_info_e_s3.push(prueba_pe_s3);

                                vend_pe_sem["sem_3"]=vend_info_e_s3;
                            }
                            if(f_pe >= r_t.segmentacionDeFechas[3][0] && f_pe <= r_t.segmentacionDeFechas[3][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s4_polizaEmitida+=info_pe.PrimaPolizaEmitida;
                                comision_s4_polizaEmitida+=info_pe.ComisionPolizaEmitida;
                                cont_pe_s4++;
                                
                                prueba_pe_s4={
                                    "idVendedor": info_pe.idVendedor,
                                    "Nombre": info_pe.Nombre,
                                    "Prima": info_pe.PrimaPolizaEmitida,
                                    "Comision": info_pe.ComisionPolizaEmitida,
                                    "Ramo": info_pe.Ramo
                                }

                                vend_info_e_s4.push(prueba_pe_s4);

                                vend_pe_sem["sem_4"]=vend_info_e_s4;
                            }
                        })

                        var seg_s1_pe={};
                        var seg_s2_pe={};
                        var seg_s3_pe={};
                        var seg_s4_pe={};

                        seg_s1_pe["Prima"]=prima_s1_polizaEmitida;
                        //seg_s1_pe["PrimaCobradaAcumulada"]=pt_semana.sem_1.Prima;
                        //seg_s1_pe["PrimaCobradaAcumulada"]=seg_s1_pe["PrimaCobrada"]; 
                        seg_s1_pe["Comision"]=comision_s1_polizaEmitida;
                        seg_s1_pe["Poliza"]=cont_pe_s1;
                        seg_s1_pe["PrimaAcumulada"]=prima_s1_polizaEmitida;
                        seg_s1_pe["ComisionAcumulada"]=comision_s1_polizaEmitida;
                        seg_s1_pe["PolizaAcumulada"]=cont_pe_s1;
                        seg_s1_pe["MetaIdeal"]=r_t.MetaIdeal*1;
                        //seg_s1_ps["Vendedores"]=vend_s1;
                        pe_semana["sem_1"]=seg_s1_pe;

                        seg_s2_pe["Prima"]=prima_s2_polizaEmitida;
                        //seg_s2_pe["PrimaCobradaAcumulada"]=pt_semana.sem_2.Prima;
                        //seg_s1_pe["PrimaCobradaAcumulada"]=typeof(prima_s2_polizaPagada); 
                        //seg_s1_pe["PrimaCobradaAcumulada"]=seg_s1_pe["PrimaCobradaAcumulada"]+prima_s2_polizaPagada; 
                        seg_s2_pe["Comision"]=comision_s2_polizaEmitida;
                        seg_s2_pe["Poliza"]=cont_pe_s2;
                        seg_s2_pe["PrimaAcumulada"]=seg_s1_pe["PrimaAcumulada"]+prima_s2_polizaEmitida;
                        seg_s2_pe["ComisionAcumulada"]=seg_s1_pe["ComisionAcumulada"]+comision_s2_polizaEmitida;
                        seg_s2_pe["PolizaAcumulada"]=seg_s1_pe["PolizaAcumulada"]+cont_pe_s2;
                        seg_s2_pe["MetaIdeal"]=r_t.MetaIdeal*2;
                        pe_semana["sem_2"]=seg_s2_pe;

                        seg_s3_pe["Prima"]=prima_s3_polizaEmitida;
                        //seg_s2_pe["PrimaCobradaAcumulada"]=pt_semana.sem_3.Prima;
                        seg_s3_pe["Comision"]=comision_s3_polizaEmitida;
                        seg_s3_pe["Poliza"]=cont_pe_s3;
                        seg_s3_pe["PrimaAcumulada"]=seg_s2_pe["PrimaAcumulada"]+prima_s3_polizaEmitida;
                        seg_s3_pe["ComisionAcumulada"]=seg_s2_pe["ComisionAcumulada"]+comision_s3_polizaEmitida;
                        seg_s3_pe["PolizaAcumulada"]=seg_s2_pe["PolizaAcumulada"]+cont_pe_s3;
                        seg_s3_pe["MetaIdeal"]=r_t.MetaIdeal*3;
                        pe_semana["sem_3"]=seg_s3_pe;

                        seg_s4_pe["Prima"]=prima_s4_polizaEmitida;
                        seg_s4_pe["Comision"]=comision_s4_polizaEmitida;
                        seg_s4_pe["Poliza"]=cont_pe_s4;
                        seg_s4_pe["PrimaAcumulada"]=seg_s3_pe["PrimaAcumulada"]+prima_s4_polizaEmitida;
                        seg_s4_pe["ComisionAcumulada"]=seg_s3_pe["ComisionAcumulada"]+comision_s4_polizaEmitida;
                        seg_s4_pe["PolizaAcumulada"]=seg_s3_pe["PolizaAcumulada"]+cont_pe_s4;
                        seg_s4_pe["MetaIdeal"]=r_t.MetaIdeal*4;
                        pe_semana["sem_4"]=seg_s4_pe;
                        
                        index_poliza["RecibosEmitidos"]=pe_semana;
                        //estatus_pol_e["Emitidos"]=pe_semana; 
                        //pol_e_s1.push(seg_s1_pe);
                        
                    })
                    vend_total["RecibosEmitidos"]=vend_pe_sem;
                    //PolizasPendientesEmitidas
                    var cc=0;
                    $.each(r_t.PolizasPendientesEmitidas, function(rp_s,r_p){

                        //console.log(r_n); //->array

                        $.each(r_p, function(f_pp, info_pp){

                            
                            if(f_pp >= r_t.segmentacionDeFechas[0][0] && f_pp <= r_t.segmentacionDeFechas[0][1]){

                                prima_s1_polizaEmitidaPendiente+=info_pp.PrimaPolizaPendienteEmitida;
                                comision_s1_polizaEmitidaPendiente+=info_pp.ComisionPolizaPendienteEmitida;
                                cc++;

                            }
                            if(f_pp >= r_t.segmentacionDeFechas[1][0] && f_pp <= r_t.segmentacionDeFechas[1][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s2_polizaEmitidaPendiente+=info_pp.PrimaPolizaPendienteEmitida;
                                comision_s2_polizaEmitidaPendiente+=info_pp.ComisionPolizaPendienteEmitida;
                                
                            }
                            if(f_pp >= r_t.segmentacionDeFechas[2][0] && f_pp <= r_t.segmentacionDeFechas[2][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s3_polizaEmitidaPendiente+=info_pp.PrimaPolizaPendienteEmitida;
                                comision_s3_polizaEmitidaPendiente+=info_pp.ComisionPolizaPendienteEmitida;
                                
                            }
                            if(f_pp >= r_t.segmentacionDeFechas[3][0] && f_pp <= r_t.segmentacionDeFechas[3][1]){ //(f_pn <= r_t.segmentacionDeFechas[0][1] || f_pn <= r_t.segmentacionDeFechas[1][1])

                                prima_s4_polizaEmitidaPendiente+=info_pp.PrimaPolizaPendienteEmitida;
                                comision_s4_polizaEmitidaPendiente+=info_pp.ComisionPolizaPendienteEmitida;
                                
                            }
                        })

                        var seg_s1_pp={};
                        var seg_s2_pp={};
                        var seg_s3_pp={};
                        var seg_s4_pp={};

                        seg_s1_pp["PrimaPendiente"]=prima_s1_polizaEmitidaPendiente;
                        seg_s1_pp["ComisionPendiente"]=comision_s1_polizaEmitidaPendiente;
                        seg_s1_pp["PrimaPendienteAcumulada"]=prima_s1_polizaEmitidaPendiente;
                        seg_s1_pp["ComisionPendienteAcumulada"]=comision_s1_polizaEmitidaPendiente;
                        seg_s1_pp["Poliza"]=0;//comision_s1_polizaEmitidaPendiente;
                        //seg_s1_ps["Vendedores"]=vend_s1;
                        pp_semana["sem_1"]=seg_s1_pp;

                        seg_s2_pp["PrimaPendiente"]=prima_s2_polizaEmitidaPendiente;
                        seg_s2_pp["ComisionPendiente"]=comision_s2_polizaEmitidaPendiente;
                        seg_s2_pp["PrimaPendienteAcumulada"]=seg_s1_pp["PrimaPendienteAcumulada"]+prima_s2_polizaEmitidaPendiente;
                        seg_s2_pp["ComisionPendienteAcumulada"]=seg_s1_pp["ComisionPendienteAcumulada"]+comision_s2_polizaEmitidaPendiente;
                        seg_s2_pp["Poliza"]=0;
                        pp_semana["sem_2"]=seg_s2_pp;

                        seg_s3_pp["PrimaPendiente"]=prima_s3_polizaEmitidaPendiente;
                        seg_s3_pp["ComisionPendiente"]=comision_s3_polizaEmitidaPendiente;
                        seg_s3_pp["PrimaPendienteAcumulada"]=seg_s2_pp["PrimaPendienteAcumulada"]+prima_s3_polizaEmitidaPendiente;
                        seg_s3_pp["ComisionPendienteAcumulada"]=seg_s2_pp["ComisionPendienteAcumulada"]+comision_s3_polizaEmitidaPendiente;
                        seg_s3_pp["Poliza"]=0;
                        pp_semana["sem_3"]=seg_s3_pp;

                        seg_s4_pp["PrimaPendiente"]=prima_s4_polizaEmitidaPendiente;
                        seg_s4_pp["ComisionPendiente"]=comision_s4_polizaEmitidaPendiente;
                        seg_s4_pp["PrimaPendienteAcumulada"]=seg_s3_pp["PrimaPendienteAcumulada"]+prima_s4_polizaEmitidaPendiente;
                        seg_s4_pp["ComisionPendienteAcumulada"]=seg_s3_pp["ComisionPendienteAcumulada"]+comision_s4_polizaEmitidaPendiente;
                        seg_s4_pp["Poliza"]=0;
                        pp_semana["sem_4"]=seg_s4_pp;

                        index_poliza["RecibosPendientes"]=pp_semana;
                        
                    })
                    //------------------------------------------------------------------------
                    var object_vend_general={};

                    $.each(vend_total, function(tr, data_r){

                        //console.log(data_r);

                        var p_v={};

                        $.each(data_r, function(sem, data_s){

                            p_v[sem]=data_s.reduce((acc, curr, index) => {
                          
                                if(curr.idVendedor in acc) {

                                  return {
                                    ...acc,
                                    [curr.idVendedor]: {
                                      Nombre: curr.Nombre,
                                      Prima: acc[curr.idVendedor].Prima + curr.Prima,
                                      Comision: acc[curr.idVendedor].Comision + curr.Comision,
                                      Ramo: {
                                          ...acc[curr.idVendedor].Ramo,
                                          [curr.Ramo]: (acc[curr.idVendedor].Ramo[curr.Ramo]) ? acc[curr.idVendedor].Ramo[curr.Ramo] + 1 : 1
                                      }
                                    }
                                  };
                                } else {
                                  return {
                                      ...acc,
                                    [curr.idVendedor]: {
                                      Nombre: curr.Nombre,
                                      Prima: curr.Prima,
                                      Comision: curr.Comision,
                                      Ramo:{
                                          [curr.Ramo]:1
                                      }
                                    }
                                  };
                                }
                              }, {}); //Termino del reduce.

                        });
                        object_vend_general[tr]=p_v;
                    }) ;

                    console.log(cc);
                    //console.log(object_vend_general);
                    //------------------------------------------------------------------------
                    //Asignación de variable de todas las pólizas de Sicas.
                    //var info_tt=jsonObject.infoTotal.TableInfo;
                    /*$.each(jsonObject.infoTotal.TableInfo, function(d, data){
                        info_tt=data;
                    })*/
                    //------------------------------------------------------------------------

                    var infoCobranza={};
                    infoCobranza["recibosSemanales"]=index_poliza;
                    infoCobranza["vendedores"]=object_vend_general;
                    infoCobranza["metaComercial"]=r_t.metaComercial;
                    infoCobranza["fechaInicio"]=r_t.fechaInicio;
                    infoCobranza["cantidadPolizas"]=r_t.cantidadPolizas;
                    infoCobranza["comisionPendienteFianzas"]=r_t.comisionPendienteFianzas;
                    infoCobranza["primaPendienteFianzas"]=r_t.primaPendienteFianzas;
                    //infoCobranza["polizasTotales"]=r_t.RespuestaPolizas;
                    
                    var info_recibos={};
                    info_recibos["PolizasSicas"]=jsonObject.infoTotal;
                    //info_recibos["ColumnaDocumento"]=jsonObject.infoTotal.nombresColumnas;

                    object_container[mes]=infoCobranza;
                    object_recibos["Recibos"]=info_recibos;
                });

                console.log(object_container);
                
                //-------------------------------Impresión en vista------------------------------
                $.each(object_container, function(mes,datos){
    
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

                                if(r!="RecibosPendientes"){

                                    info_reporte+=`
                                    
                                        <div class="dropdown" id="recibos_mes_`+mes+`" style="display:inline-block">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="semanas_`+mes+`_`+r+`" data-toggle="dropdown" aria-expanded="true">
                                                `+r.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="semanas_`+mes+`_`+r+`">
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',1)">Semana 1 <span class="badge">`+datosr.sem_1.Poliza+`</span></a></li>
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',2)">Semana 2 <span class="badge">`+datosr.sem_2.Poliza+`</span></a></li>
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',3)">Semana 3 <span class="badge">`+datosr.sem_3.Poliza+`</span></a></li>
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',4)">Semana 4 <span class="badge">`+datosr.sem_4.Poliza+`</span></a></li>
                                            </ul>
                                        </div>                                    
                                    `;
                                }
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
                                                    
                                                    $.each(datos.vendedores, function(rt, datosrt){

                                                        //console.log(datosrt);
                                                        $.each(datosrt, function(sr,datos_sr){

                                                            if(r==rt && s==sr){

                                                                //console.log(datos_sr);
                                                                $.each(datos_sr, function(id_v, datos_vnd){

                                                                    var autos=0;
                                                                    var vida=0;
                                                                    var danio=0;
                                                                    var gmm=0;
                                                                    var ap=0;

                                                                    if(typeof(datos_vnd.Ramo.Vehiculos)!="undefined"){

                                                                        autos=datos_vnd.Ramo.Vehiculos;
                                                                    }
                                                                    if(typeof(datos_vnd.Ramo.Vida)!="undefined"){

                                                                        vida=datos_vnd.Ramo.Vida;
                                                                    }
                                                                    if(typeof(datos_vnd.Ramo.Daños)!="undefined"){

                                                                        danio=datos_vnd.Ramo.Daños;
                                                                    }
                                                                    if(typeof(datos_vnd.Ramo.GMM)!="undefined"){

                                                                        gmm=datos_vnd.Ramo.GMM;
                                                                    }
                                                                    if(typeof(datos_vnd.Ramo.AP)!="undefined"){

                                                                        ap=datos_vnd.Ramo.AP;
                                                                    }

                                                                    info_reporte+=`<tr>
                                                                        <td class="text-left">`+datos_vnd.Nombre+`</td>
                                                                        <td>`+autos+`</td>
                                                                        <td>`+vida+`</td>
                                                                        <td>`+danio+`</td>
                                                                        <td>`+gmm+`</td>
                                                                        <td>`+ap+`</td>
                                                                        <td>`+(autos+vida+danio+gmm+ap)+`</td>
                                                                        <td>`+datos_vnd.Prima+`</td>
                                                                        <td>`+datos_vnd.Comision+`</td>
                                                                        </tr>`;
                                                                });
                                                                

                                                            }
                                                        });
                                                    });

                                                    info_reporte+=`</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>`;
                                    
                                    });
                                });

                                /* $.each(datos.recibosSemanales, function(a,datosa){
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
                                });*/

                                
                                $.each(datos.recibosSemanales, function(b,datosa){
                                    $.each(datosa, function(s, registros){

                                        //acumulado_polizas+=registros.Polizas;

                                        //acumulado_comision+=datos.recibosSemanales.RecibosEmitidos[0].Emitidos.sem_1.Comision+datos.recibosSemanales[0].RecibosEmitidos.Emitidos.sem_2.Comision+datos.recibosSemanales[0].RecibosEmitidos.Emitidos.sem_3.Comision+datos.recibosSemanales[0].RecibosEmitidos.Emitidos.sem_4.Comision; //registros.Comision;

                                        info_reporte+=`
                                            <div class="contenedor_info_`+mes+`_`+b+`_`+s.slice(4)+`" style="display: none">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><h5><h5><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbspReporte de primas y comisiones Semana `+s.slice(4)+` (`+b.replace("RecibosNuevos","Recibos Nuevos").replace("RecibosYSubsecuentes","Recibos Y Subsecuentes").replace("RecibosTotales", "Recibos Pagados").replace("RecibosEmitidos", "Recibos Emitidos")+`)</h5></div>
                                                    <div class="panel-body">
                                                        <table class="table table-bordered" id="tabla_info_`+mes+`_`+b+`_`+s.slice(4)+`">
                                                            <tbody>`;


                                                            if(b!="RecibosEmitidos"){

                                                                /*var acumulado_polizas=0;
                                                                acumulado_polizas+=registros.Polizas;
                                                                var acumulado_primas=0;
                                                                var acumulado_comisionu=0;*/

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
                                                                <tr>`;

                                                                $.each(datos.recibosSemanales.RecibosTotales, function(b,datosa){

                                                                    if(b==s){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(datosa.PrimaAcumulada)+`</td>
                                                                            <!--<td class="text-left">Prima Cobrada</td>-->
                                                                        `;
                                                                    }
                                                                });

                                                                info_reporte+=`<!--<td>$ `+new Intl.NumberFormat().format(registros.PrimaCobradaAcumulada)+`</td>-->
                                                                    <td class="text-left">Prima Cobrada</td>
                                                                    <td class="text-center"><h5><span class="label label-warning">Recibos<span></h5></td>
                                                                </tr>
                                                                <tr>`;
                                                                    $.each(datos.recibosSemanales.RecibosPendientes, function(b,datosa){

                                                                        if(b==s){
                                                                            info_reporte+=`<td>$ `+new Intl.NumberFormat().format(datosa.PrimaPendienteAcumulada)+`</td>
                                                                            `;
                                                                        }
                                                                    });
                                                                    info_reporte+=`<!--<td>$ `+new Intl.NumberFormat().format(registros.PrimaPendienteAcumulada)+`</td>-->
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

                                                                    $.each(datos.recibosSemanales.RecibosTotales, function(std,infotd){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(infotd.ComisionAcumulada)+`</td>`; 
                                                                        comisionA=infotd.ComisionAcumulada;
                                                                    });

                                                                info_reporte+=`
                                                                    <td>`+(comisionA/datos.metaComercial)+`%</td>
                                                                </tr>

                                                                <tr>`;

                                                                $.each(datos.recibosSemanales.RecibosTotales, function(b,datosa){

                                                                    if(b==s){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(datosa.ComisionAcumulada)+`</td>
                                                                            <!--<td class="text-left">Prima Cobrada</td>-->
                                                                        `;
                                                                    }
                                                                });

                                                                    info_reporte+=`<!--<td>$ `+new Intl.NumberFormat().format(registros.ComisionCobradaAcumulada)+`</td>-->
                                                                    <td class="text-left">Comisión cobrada</td>
                                                                </tr>
                                                                <tr>`;

                                                                    $.each(datos.recibosSemanales.RecibosPendientes, function(b,datosa){

                                                                        if(b==s){
                                                                            info_reporte+=`<td>$ `+new Intl.NumberFormat().format(datosa.ComisionPendienteAcumulada)+`</td>
                                                                            `;
                                                                        }
                                                                    });

                                                                    info_reporte+=`<!--<td>$ `+new Intl.NumberFormat().format(registros.ComisionPendienteAcumulada)+`</td>-->
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
                                                                    
                                                                    $.each(datos.recibosSemanales.RecibosTotales, function(std,infotd){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(infotd.ComisionAcumulada/registros.Poliza)+`</td>`; 
                                                                        //comisionA=infotd.ComisionAcumulada;
                                                                        
                                                                    });

                                                                    /*$.each(datosa, function(stda,infotda){
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(infotda.Comision/infotda.Polizas)+`</td>`; 
                                                                    });*/

                                                                info_reporte+=`</tr>
                                                                `;
                                                            }
                                                    info_reporte+=`
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div id="link_descarga`+mes+`">
                                                        <!--<button class="btn btn-primary" onclick="exportarAExcel(`+mes+`,'`+b+`',`+s.slice(4)+`)">Exportar resultado a fichero Excel</button>-->
                                                        <button class="btn btn-primary" onclick="exportarAExcel(`+mes+`,'general')">Exportar resultado total</button>
                                                    </div>
                                                </div>
                                            </div>`;
                                    });
                                });

                               info_reporte+=`</div>
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
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',1)">Semana 1 <span class="badge">`+datosr.sem_1.Poliza+`</span></a></li>
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',2)">Semana 2 <span class="badge">`+datosr.sem_2.Poliza+`</span></a></li>
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',3)">Semana 3 <span class="badge">`+datosr.sem_3.Poliza+`</span></a></li>
                                                <li role="presentation"><a role="item" tabindex="-1" href="javascript: void(0)" onclick="muestra_contenido_semanal(`+mes+`,'`+r+`',4)">Semana 4 <span class="badge">`+datosr.sem_4.Poliza+`</span></a></li>
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
                                                    
                                                    $.each(datos.vendedores, function(rt, datosrt){

                                                        //console.log(datosrt);
                                                        $.each(datosrt, function(sr,datos_sr){

                                                            if(r==rt && s==sr){

                                                                //console.log(datos_sr);
                                                                $.each(datos_sr, function(id_v, datos_vnd){

                                                                    var fianzas=0;
                                                                    
                                                                    if(typeof(datos_vnd.Ramo.Fianzas)!="undefined"){

                                                                        fianzas=datos_vnd.Ramo.Fianzas;
                                                                    }

                                                                    info_reporte+=`<tr>
                                                                        <td class="text-left">`+datos_vnd.Nombre+`</td>
                                                                        <td>`+fianzas+`</td>
                                                                        <td>`+fianzas+`</td>
                                                                        <td>`+datos_vnd.Prima+`</td>
                                                                        <td>`+datos_vnd.Comision+`</td>
                                                                        </tr>`;
                                                                });
                                                            }
                                                        });
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

                                                                    sumatoriaPolizas+=registrosp.Poliza;

                                                                    info_reporte+=`<td>`+registrosp.Poliza+`</td>`;
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

                                                                $.each(datos.recibosSemanales.RecibosTotales, function(sp, registrosp){

                                                                    sumatoriaPrimasNetasCobradas+=registrosp.Prima;

                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.Prima)+`</td>`;
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

                                                                $.each(datos.recibosSemanales.RecibosPendientes, function(sp, registrosp){

                                                                    if(registrosp.PrimaPendiente>0){
                                                                        sumatoriaPrimasNetasPendientes+=registrosp.PrimaPendiente; //+datos.comisionPendienteFianzas;
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.PrimaPendiente)+`</td>`; //+datos.primaPendienteFianzas
                                                                    } else{
                                                                        info_reporte+=`<td>$ 0</td>`;
                                                                    }
                                                                    
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(datos.primaPendienteFianzas)+`</td>
                                                                <td class="text-center">REAL</td>`; //+datos.primaPendienteFianzas
                                                                
                                                                var comisionAcu=0;

                                                                $.each(datos.recibosSemanales.RecibosTotales, function(sp, registrosp){

                                                                    comisionAcu+=registrosp.Comision;
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

                                                                $.each(datos.recibosSemanales.RecibosTotales, function(sp, registrosp){

                                                                    comisionpagadasum+=registrosp.Comision;
                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.Comision)+`</td>`;
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(comisionpagadasum)+`</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Comisión pendiente</td>`;

                                                                var comisionpendientesum=0;

                                                                $.each(datos.recibosSemanales.RecibosPendientes, function(sp, registrosp){

                                                                    //comisionpendientesum+=registrosp.ComisionPendiente;
                                                                    //info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.ComisionPendiente)+`</td>`;

                                                                    if(registrosp.ComisionPendiente>0){
                                                                        comisionpendientesum+=registrosp.ComisionPendiente;
                                                                        info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.ComisionPendiente)+`</td>`;
                                                                    } else{
                                                                        info_reporte+=`<td>$ 0</td>`;
                                                                    }
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(datos.comisionPendienteFianzas)+`</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">Comisión promedio</td>`;
                                                                
                                                                $.each(datosb, function(sp, registrosp){

                                                                    comisionsum+=registrosp.Comision;
                                                                    info_reporte+=`<td>$ `+new Intl.NumberFormat().format(registrosp.Comision/registrosp.Poliza)+`</td>`;
                                                                });

                                                            info_reporte+=`
                                                                <td>$ `+new Intl.NumberFormat().format(comisionsum/sumatoriaPolizas)+`</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="link_descarga`+mes+`">
                                                    <!--<button class="btn btn-primary" onclick="exportarAExcel(`+mes+`,'`+b+`',`+s.slice(4)+`)">Exportar resultado a fichero Excel</button>-->
                                                    <button class="btn btn-primary" onclick="exportarAExcel(`+mes+`, 'general')">Exportar resultado total</button>
                                                    <button class="btn btn-warning" onclick="exportarAExcel(`+mes+`,'emitido')">Exportar resultado emitido</button>
                                                    <button class="btn btn-danger" onclick="exportarAExcel(`+mes+`,'pendiente')">Exportar resultado pendiente</button>
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
                //----------------------------------------------------------------------
                info_reporte+=`</div>`;
                
                var tabla_info_general_body="";

                $.each(object_recibos.Recibos.PolizasSicas.RespuestaPolizas.TableInfo, function(a,b){
                    tabla_info_general_body+=`<tr>
                        <td>`+(typeof(b.Documento)=='undefined' || typeof(b.Documento)=='object' ? b.Documento=0 : b.Documento)+`</td>
                        <td>`+(typeof(b.Inciso)=='undefined' || typeof(b.Inciso)=='object' ? b.Inciso=0 : b.Inciso)+`</td>
                        <td>`+(typeof(b.Periodo)=='undefined' || typeof(b.Periodo)=='object' ? b.Periodo=0 : b.Periodo)+`</td>
                        <td>`+(typeof(b.Serie)=='undefined' || typeof(b.Serie)=='object' ? b.Serie=0 : b.Serie)+`</td>
                        <td>`+(typeof(b.Renovacion)=='undefined' || typeof(b.Renovacion)=='object' ? b.Renovacion=0 : b.Renovacion)+`</td>
                        <td>`+(typeof(b.FechaDocto)=='undefined' || typeof(b.FechaDocto)=='object' ? b.FechaDocto=0 : b.FechaDocto)+`</td>
                        <td>`+(typeof(b.Fdesde)=='undefined' || typeof(b.Fdesde)=='object' ? b.Fdesde=0 : b.Fdesde)+`</td>
                        <td>`+(typeof(b.Fhasta)=='undefined' || typeof(b.Fhasta)=='object' ? b.Fhasta=0 : b.Fhasta)+`</td>
                        <td>`+(typeof(b.FLimPago)=='undefined' || typeof(b.FLimPago)=='object' ? b.FLimPago=0 : b.FLimPago)+`</td>
                        <td>`+(typeof(b.Fstatus)=='undefined' || typeof(b.Fstatus)=='object' ? b.Fstatus=0 : b.Fstatus)+`</td>
                        <td>`+(typeof(b.Status_TXT)=='undefined' || typeof(b.Status_TXT)=='object' ? b.Status_TXT=0 : b.Status_TXT)+`</td>
                        <td>`+(typeof(b.PrimaNeta)=='undefined' || typeof(b.PrimaNeta)=='object' ? b.PrimaNeta=0 : b.PrimaNeta)+`</td>
                        <td>`+(typeof(b.Recargos)=='undefined' || typeof(b.Recargos)=='object' ? b.Recargos=0 : b.Recargos)+`</td>
                        <td>`+(typeof(b.Derechos)=='undefined' || typeof(b.Derechos)=='object' ? b.Derechos=0 : b.Derechos)+`</td>
                        <td>`+(typeof(b.Impuesto1)=='undefined' || typeof(b.Impuesto1)=='object' ? b.Impuesto1=0 : b.Impuesto1)+`</td>
                        <td>`+(typeof(b.PrimaTotal)=='undefined' || typeof(b.PrimaTotal)=='object' ? b.PrimaTotal=0 : b.PrimaTotal)+`</td>
                        <td>`+(typeof(b.Comision0)=='undefined' || typeof(b.Comision0)=='object' ? b.Comision0=0 : b.Comision0)+`</td>
                        <td>`+(typeof(b.Comision1)=='undefined' || typeof(b.Comision1)=='object' ? b.Comision1=0 : b.Comision1)+`</td>
                        <td>`+(typeof(b.Comision2)=='undefined' || typeof(b.Comision2)=='object' ? b.Comision2=0 : b.Comision2)+`</td>
                        <td>`+(typeof(b.Comision3)=='undefined' || typeof(b.Comision3)=='object' ? b.Comision3=0 : b.Comision3)+`</td>
                        <td>`+(typeof(b.Comision4)=='undefined' || typeof(b.Comision4)=='object' ? b.Comision4=0 : b.Comision4)+`</td>
                        <td>`+(typeof(b.Comision5)=='undefined' || typeof(b.Comision5)=='object' ? b.Comision5=0 : b.Comision5)+`</td>
                        <td>`+(typeof(b.Comision6)=='undefined' || typeof(b.Comision6)=='object' ? b.Comision6=0 : b.Comision6)+`</td>
                        <td>`+(typeof(b.Comision7)=='undefined' || typeof(b.Comision7)=='object' ? b.Comision7=0 : b.Comision7)+`</td>
                        <td>`+(typeof(b.Comision8)=='undefined' || typeof(b.Comision8)=='object' ? b.Comision8=0 : b.Comision8)+`</td>
                        <td>`+(typeof(b.Comision9)=='undefined' || typeof(b.Comision9)=='object' ? b.Comision9=0 : b.Comision9)+`</td>
                        <td>`+(typeof(b.Grupo)=='undefined' || typeof(b.Grupo)=='object' ? b.Grupo=0 : b.Grupo)+`</td>
                        <td>`+(typeof(b.SubGrupo)=='undefined' || typeof(b.SubGrupo)=='object' ? b.SubGrupo=0 : b.SubGrupo)+`</td>
                        <td>`+(typeof(b.CCobro_TXT)=='undefined' || typeof(b.CCobro_TXT)=='object' ? b.CCobro_TXT=0 : b.CCobro_TXT)+`</td>
                        <td>`+(typeof(b.StatusDoc_Txt)=='undefined' || typeof(b.StatusDoc_Txt)=='object' ? b.StatusDoc_Txt=0 : b.StatusDoc_Txt)+`</td>
                        <td>`+(typeof(b.Concepto)=='undefined' || typeof(b.Concepto)=='object' ? b.Concepto=0 : b.Concepto)+`</td>
                        <td>`+(typeof(b.NombreCompleto)=='undefined' || typeof(b.NombreCompleto)=='object' ? b.NombreCompleto=0 : b.NombreCompleto)+`</td>
                        <td>`+(typeof(b.VendNombre)=='undefined' || typeof(b.VendNombre)=='object' ? b.VendNombre=0 : b.VendNombre)+`</td>
                        <td>`+(typeof(b.VendAbreviacion)=='undefined' || typeof(b.VendAbreviacion)=='object' ? b.VendAbreviacion=0 : b.VendAbreviacion)+`</td>
                        <td>`+(typeof(b.Fpago)=='undefined' || typeof(b.Fpago)=='object' ? b.Fpago=0 : b.Fpago)+`</td>
                        <td>`+(typeof(b.Moneda)=='undefined' || typeof(b.Moneda)=='object' ? b.Moneda=0 : b.Moneda)+`</td>
                        <td>`+(typeof(b.SRamoNombre)=='undefined' || typeof(b.SRamoNombre)=='object' ? b.SRamoNombre=0 : b.SRamoNombre)+`</td>
                        <td>`+(typeof(b.RamosNombre)=='undefined' || typeof(b.RamosNombre)=='object' ? b.RamosNombre=0 : b.RamosNombre)+`</td>
                        <td>`+(typeof(b.IDVend)=='undefined' || typeof(b.IDVend)=='object' ? b.IDVend=0 : b.IDVend)+`</td>
                        <td>`+(typeof(b.TipoDocto_TXT)=='undefined' || typeof(b.TipoDocto_TXT)=='object' ? b.TipoDocto_TXT=0 : b.TipoDocto_TXT)+`</td>
                        <td>`+(typeof(b.TCPago)=='undefined' || typeof(b.TCPago)=='object' ? b.TCPago=1 : b.TCPago)+`</td>
                        <td>`+(typeof(b.RenovacionDocto)=='undefined' || typeof(b.RenovacionDocto)=='object' ? b.RenovacionDocto=0 : b.RenovacionDocto)+`</td>
                        <td>`+(typeof(b.FDoctoPago)=='undefined' || typeof(b.FDoctoPago)=='object' ? b.FDoctoPago=0 : b.FDoctoPago)+`</td>
                        <td>`+(typeof(b.Femision)=='undefined' || typeof(b.Femision)=='object' ? b.Femision=0 : b.Femision)+`</td>
                                     
                    </tr>`;
                });

                var tabla_info_emitido_body="";

                $.each(object_recibos.Recibos.PolizasSicas.RespuestaPolizasEmitidosFianzas.TableInfo, function(a,b){
                    tabla_info_emitido_body+=`<tr>
                        <td>`+(typeof(b.Documento)=='undefined' || typeof(b.Documento)=='object' ? b.Documento=0 : b.Documento)+`</td>
                        <td>`+(typeof(b.Inciso)=='undefined' || typeof(b.Inciso)=='object' ? b.Inciso=0 : b.Inciso)+`</td>
                        <td>`+(typeof(b.Periodo)=='undefined' || typeof(b.Periodo)=='object' ? b.Periodo=0 : b.Periodo)+`</td>
                        <td>`+(typeof(b.Serie)=='undefined' || typeof(b.Serie)=='object' ? b.Serie=0 : b.Serie)+`</td>
                        <td>`+(typeof(b.Renovacion)=='undefined' || typeof(b.Renovacion)=='object' ? b.Renovacion=0 : b.Renovacion)+`</td>
                        <td>`+(typeof(b.FechaDocto)=='undefined' || typeof(b.FechaDocto)=='object' ? b.FechaDocto=0 : b.FechaDocto)+`</td>
                        <td>`+(typeof(b.Fdesde)=='undefined' || typeof(b.Fdesde)=='object' ? b.Fdesde=0 : b.Fdesde)+`</td>
                        <td>`+(typeof(b.Fhasta)=='undefined' || typeof(b.Fhasta)=='object' ? b.Fhasta=0 : b.Fhasta)+`</td>
                        <td>`+(typeof(b.FLimPago)=='undefined' || typeof(b.FLimPago)=='object' ? b.FLimPago=0 : b.FLimPago)+`</td>
                        <td>`+(typeof(b.Fstatus)=='undefined' || typeof(b.Fstatus)=='object' ? b.Fstatus=0 : b.Fstatus)+`</td>
                        <td>`+(typeof(b.Status_TXT)=='undefined' || typeof(b.Status_TXT)=='object' ? b.Status_TXT=0 : b.Status_TXT)+`</td>
                        <td>`+(typeof(b.PrimaNeta)=='undefined' || typeof(b.PrimaNeta)=='object' ? b.PrimaNeta=0 : b.PrimaNeta)+`</td>
                        <td>`+(typeof(b.Recargos)=='undefined' || typeof(b.Recargos)=='object' ? b.Recargos=0 : b.Recargos)+`</td>
                        <td>`+(typeof(b.Derechos)=='undefined' || typeof(b.Derechos)=='object' ? b.Derechos=0 : b.Derechos)+`</td>
                        <td>`+(typeof(b.Impuesto1)=='undefined' || typeof(b.Impuesto1)=='object' ? b.Impuesto1=0 : b.Impuesto1)+`</td>
                        <td>`+(typeof(b.PrimaTotal)=='undefined' || typeof(b.PrimaTotal)=='object' ? b.PrimaTotal=0 : b.PrimaTotal)+`</td>
                        <td>`+(typeof(b.Comision0)=='undefined' || typeof(b.Comision0)=='object' ? b.Comision0=0 : b.Comision0)+`</td>
                        <td>`+(typeof(b.Comision1)=='undefined' || typeof(b.Comision1)=='object' ? b.Comision1=0 : b.Comision1)+`</td>
                        <td>`+(typeof(b.Comision2)=='undefined' || typeof(b.Comision2)=='object' ? b.Comision2=0 : b.Comision2)+`</td>
                        <td>`+(typeof(b.Comision3)=='undefined' || typeof(b.Comision3)=='object' ? b.Comision3=0 : b.Comision3)+`</td>
                        <td>`+(typeof(b.Comision4)=='undefined' || typeof(b.Comision4)=='object' ? b.Comision4=0 : b.Comision4)+`</td>
                        <td>`+(typeof(b.Comision5)=='undefined' || typeof(b.Comision5)=='object' ? b.Comision5=0 : b.Comision5)+`</td>
                        <td>`+(typeof(b.Comision6)=='undefined' || typeof(b.Comision6)=='object' ? b.Comision6=0 : b.Comision6)+`</td>
                        <td>`+(typeof(b.Comision7)=='undefined' || typeof(b.Comision7)=='object' ? b.Comision7=0 : b.Comision7)+`</td>
                        <td>`+(typeof(b.Comision8)=='undefined' || typeof(b.Comision8)=='object' ? b.Comision8=0 : b.Comision8)+`</td>
                        <td>`+(typeof(b.Comision9)=='undefined' || typeof(b.Comision9)=='object' ? b.Comision9=0 : b.Comision9)+`</td>
                        <td>`+(typeof(b.Grupo)=='undefined' || typeof(b.Grupo)=='object' ? b.Grupo=0 : b.Grupo)+`</td>
                        <td>`+(typeof(b.SubGrupo)=='undefined' || typeof(b.SubGrupo)=='object' ? b.SubGrupo=0 : b.SubGrupo)+`</td>
                        <td>`+(typeof(b.CCobro_TXT)=='undefined' || typeof(b.CCobro_TXT)=='object' ? b.CCobro_TXT=0 : b.CCobro_TXT)+`</td>
                        <td>`+(typeof(b.StatusDoc_Txt)=='undefined' || typeof(b.StatusDoc_Txt)=='object' ? b.StatusDoc_Txt=0 : b.StatusDoc_Txt)+`</td>
                        <td>`+(typeof(b.Concepto)=='undefined' || typeof(b.Concepto)=='object' ? b.Concepto=0 : b.Concepto)+`</td>
                        <td>`+(typeof(b.NombreCompleto)=='undefined' || typeof(b.NombreCompleto)=='object' ? b.NombreCompleto=0 : b.NombreCompleto)+`</td>
                        <td>`+(typeof(b.VendNombre)=='undefined' || typeof(b.VendNombre)=='object' ? b.VendNombre=0 : b.VendNombre)+`</td>
                        <td>`+(typeof(b.VendAbreviacion)=='undefined' || typeof(b.VendAbreviacion)=='object' ? b.VendAbreviacion=0 : b.VendAbreviacion)+`</td>
                        <td>`+(typeof(b.Fpago)=='undefined' || typeof(b.Fpago)=='object' ? b.Fpago=0 : b.Fpago)+`</td>
                        <td>`+(typeof(b.Moneda)=='undefined' || typeof(b.Moneda)=='object' ? b.Moneda=0 : b.Moneda)+`</td>
                        <td>`+(typeof(b.SRamoNombre)=='undefined' || typeof(b.SRamoNombre)=='object' ? b.SRamoNombre=0 : b.SRamoNombre)+`</td>
                        <td>`+(typeof(b.RamosNombre)=='undefined' || typeof(b.RamosNombre)=='object' ? b.RamosNombre=0 : b.RamosNombre)+`</td>
                        <td>`+(typeof(b.IDVend)=='undefined' || typeof(b.IDVend)=='object' ? b.IDVend=0 : b.IDVend)+`</td>
                        <td>`+(typeof(b.TipoDocto_TXT)=='undefined' || typeof(b.TipoDocto_TXT)=='object' ? b.TipoDocto_TXT=0 : b.TipoDocto_TXT)+`</td>
                        <td>`+(typeof(b.TCPago)=='undefined' || typeof(b.TCPago)=='object' ? b.TCPago=1 : b.TCPago)+`</td>
                        <td>`+(typeof(b.RenovacionDocto)=='undefined' || typeof(b.RenovacionDocto)=='object' ? b.RenovacionDocto=0 : b.RenovacionDocto)+`</td>
                        <td>`+(typeof(b.FDoctoPago)=='undefined' || typeof(b.FDoctoPago)=='object' ? b.FDoctoPago=0 : b.FDoctoPago)+`</td>
                        <td>`+(typeof(b.FEmision)=='undefined' || typeof(b.FEmision)=='object' ? b.FEmision=0 : b.FEmision)+`</td>
                                     
                    </tr>`;
                });

                var tabla_info_pendiente_body="";

                $.each(object_recibos.Recibos.PolizasSicas.RespuestaPolizasPendientesFianzas.TableInfo, function(a,b){
                    tabla_info_pendiente_body+=`<tr>
                        <td>`+(typeof(b.Documento)=='undefined' || typeof(b.Documento)=='object' ? b.Documento=0 : b.Documento)+`</td>
                        <td>`+(typeof(b.Inciso)=='undefined' || typeof(b.Inciso)=='object' ? b.Inciso=0 : b.Inciso)+`</td>
                        <td>`+(typeof(b.Periodo)=='undefined' || typeof(b.Periodo)=='object' ? b.Periodo=0 : b.Periodo)+`</td>
                        <td>`+(typeof(b.Serie)=='undefined' || typeof(b.Serie)=='object' ? b.Serie=0 : b.Serie)+`</td>
                        <td>`+(typeof(b.Renovacion)=='undefined' || typeof(b.Renovacion)=='object' ? b.Renovacion=0 : b.Renovacion)+`</td>
                        <td>`+(typeof(b.FechaDocto)=='undefined' || typeof(b.FechaDocto)=='object' ? b.FechaDocto=0 : b.FechaDocto)+`</td>
                        <td>`+(typeof(b.Fdesde)=='undefined' || typeof(b.Fdesde)=='object' ? b.Fdesde=0 : b.Fdesde)+`</td>
                        <td>`+(typeof(b.Fhasta)=='undefined' || typeof(b.Fhasta)=='object' ? b.Fhasta=0 : b.Fhasta)+`</td>
                        <td>`+(typeof(b.FLimPago)=='undefined' || typeof(b.FLimPago)=='object' ? b.FLimPago=0 : b.FLimPago)+`</td>
                        <td>`+(typeof(b.Fstatus)=='undefined' || typeof(b.Fstatus)=='object' ? b.Fstatus=0 : b.Fstatus)+`</td>
                        <td>`+(typeof(b.Status_TXT)=='undefined' || typeof(b.Status_TXT)=='object' ? b.Status_TXT=0 : b.Status_TXT)+`</td>
                        <td>`+(typeof(b.PrimaNeta)=='undefined' || typeof(b.PrimaNeta)=='object' ? b.PrimaNeta=0 : b.PrimaNeta)+`</td>
                        <td>`+(typeof(b.Recargos)=='undefined' || typeof(b.Recargos)=='object' ? b.Recargos=0 : b.Recargos)+`</td>
                        <td>`+(typeof(b.Derechos)=='undefined' || typeof(b.Derechos)=='object' ? b.Derechos=0 : b.Derechos)+`</td>
                        <td>`+(typeof(b.Impuesto1)=='undefined' || typeof(b.Impuesto1)=='object' ? b.Impuesto1=0 : b.Impuesto1)+`</td>
                        <td>`+(typeof(b.PrimaTotal)=='undefined' || typeof(b.PrimaTotal)=='object' ? b.PrimaTotal=0 : b.PrimaTotal)+`</td>
                        <td>`+(typeof(b.Comision0)=='undefined' || typeof(b.Comision0)=='object' ? b.Comision0=0 : b.Comision0)+`</td>
                        <td>`+(typeof(b.Comision1)=='undefined' || typeof(b.Comision1)=='object' ? b.Comision1=0 : b.Comision1)+`</td>
                        <td>`+(typeof(b.Comision2)=='undefined' || typeof(b.Comision2)=='object' ? b.Comision2=0 : b.Comision2)+`</td>
                        <td>`+(typeof(b.Comision3)=='undefined' || typeof(b.Comision3)=='object' ? b.Comision3=0 : b.Comision3)+`</td>
                        <td>`+(typeof(b.Comision4)=='undefined' || typeof(b.Comision4)=='object' ? b.Comision4=0 : b.Comision4)+`</td>
                        <td>`+(typeof(b.Comision5)=='undefined' || typeof(b.Comision5)=='object' ? b.Comision5=0 : b.Comision5)+`</td>
                        <td>`+(typeof(b.Comision6)=='undefined' || typeof(b.Comision6)=='object' ? b.Comision6=0 : b.Comision6)+`</td>
                        <td>`+(typeof(b.Comision7)=='undefined' || typeof(b.Comision7)=='object' ? b.Comision7=0 : b.Comision7)+`</td>
                        <td>`+(typeof(b.Comision8)=='undefined' || typeof(b.Comision8)=='object' ? b.Comision8=0 : b.Comision8)+`</td>
                        <td>`+(typeof(b.Comision9)=='undefined' || typeof(b.Comision9)=='object' ? b.Comision9=0 : b.Comision9)+`</td>
                        <td>`+(typeof(b.Grupo)=='undefined' || typeof(b.Grupo)=='object' ? b.Grupo=0 : b.Grupo)+`</td>
                        <td>`+(typeof(b.SubGrupo)=='undefined' || typeof(b.SubGrupo)=='object' ? b.SubGrupo=0 : b.SubGrupo)+`</td>
                        <td>`+(typeof(b.CCobro_TXT)=='undefined' || typeof(b.CCobro_TXT)=='object' ? b.CCobro_TXT=0 : b.CCobro_TXT)+`</td>
                        <td>`+(typeof(b.StatusDoc_Txt)=='undefined' || typeof(b.StatusDoc_Txt)=='object' ? b.StatusDoc_Txt=0 : b.StatusDoc_Txt)+`</td>
                        <td>`+(typeof(b.Concepto)=='undefined' || typeof(b.Concepto)=='object' ? b.Concepto=0 : b.Concepto)+`</td>
                        <td>`+(typeof(b.NombreCompleto)=='undefined' || typeof(b.NombreCompleto)=='object' ? b.NombreCompleto=0 : b.NombreCompleto)+`</td>
                        <td>`+(typeof(b.VendNombre)=='undefined' || typeof(b.VendNombre)=='object' ? b.VendNombre=0 : b.VendNombre)+`</td>
                        <td>`+(typeof(b.VendAbreviacion)=='undefined' || typeof(b.VendAbreviacion)=='object' ? b.VendAbreviacion=0 : b.VendAbreviacion)+`</td>
                        <td>`+(typeof(b.Fpago)=='undefined' || typeof(b.Fpago)=='object' ? b.Fpago=0 : b.Fpago)+`</td>
                        <td>`+(typeof(b.Moneda)=='undefined' || typeof(b.Moneda)=='object' ? b.Moneda=0 : b.Moneda)+`</td>
                        <td>`+(typeof(b.SRamoNombre)=='undefined' || typeof(b.SRamoNombre)=='object' ? b.SRamoNombre=0 : b.SRamoNombre)+`</td>
                        <td>`+(typeof(b.RamosNombre)=='undefined' || typeof(b.RamosNombre)=='object' ? b.RamosNombre=0 : b.RamosNombre)+`</td>
                        <td>`+(typeof(b.IDVend)=='undefined' || typeof(b.IDVend)=='object' ? b.IDVend=0 : b.IDVend)+`</td>
                        <td>`+(typeof(b.TipoDocto_TXT)=='undefined' || typeof(b.TipoDocto_TXT)=='object' ? b.TipoDocto_TXT=0 : b.TipoDocto_TXT)+`</td>
                        <td>`+(typeof(b.TCPago)=='undefined' || typeof(b.TCPago)=='object' ? b.TCPago=1 : b.TCPago)+`</td>
                        <td>`+(typeof(b.RenovacionDocto)=='undefined' || typeof(b.RenovacionDocto)=='object' ? b.RenovacionDocto=0 : b.RenovacionDocto)+`</td>
                        <td>`+(typeof(b.FDoctoPago)=='undefined' || typeof(b.FDoctoPago)=='object' ? b.FDoctoPago=0 : b.FDoctoPago)+`</td>
                        <td>`+(typeof(b.FEmision)=='undefined' || typeof(b.FEmision)=='object' ? b.FEmision=0 : b.FEmision)+`</td>
                                     
                    </tr>`;
                });

                $("#row_doc").html(tabla_info_general_body); 
                $("#row_doc_emitidos_fianzas").html(tabla_info_emitido_body); 
                $("#row_doc_pendiente_fianzas").html(tabla_info_pendiente_body); 

                $("#tab_panel").html(`
                    <ul class="nav nav-tabs" role="tablist" id="reporte_mensual">`+opciones_li+`</ul>
                    <br>
                    `+info_reporte+`
                `);

                $("#contenedor_resultado").show();

                /**/

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
function exportarAExcel(mes,reporte,filename=""){
   
    switch(reporte){
        case "general": var tablaregP = document.getElementById("tabla_excel");
        break;
        case "emitido": var tablaregP = document.getElementById("tabla_excel_e_fianzas");
        break;
        case "pendiente": var tablaregP = document.getElementById("tabla_excel_p_fianzas");
        break;
    }


    var downloadLink;
    var tipoDato = 'application/vnd.ms-excel';
    //var tablainfo = document.getElementById("tabla_info_"+mes+`_`+recibo+`_`+semana);
    //var tablaregP = document.getElementById("tabla_excel");
    //var tablaPersona=document.getElementById("tabla_personal_"+mes+`_`+recibo+`_`+semana);
    //var tablainfo=$("#tabla_info_"+mes);
    //var tablaHTML2=tablainfo.outerHTML.replace(/ /g, '%20');
    var tablaHTML3=tablaregP.outerHTML.replace(/ /g, '%20');
    //var tablaHTML1=tablaPersona.outerHTML.replace(/ /g, '%20');

    var tablaHTML=tablaHTML3; //tablaHTML1+tablaHTML2; //+tablaHTML3

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
