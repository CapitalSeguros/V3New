
<?php $IDCL=$_GET['IDCL'];?>
<style type="text/css">

    .dnFlex{display: flex;flex-direction: column;margin: 5%}
    .dnFlex>div[image]{display: flex; justify-content: flex-end;width: 100%;border-color: red}
    .dnFlex>div[cabeceraDelcontenido]{text-align: left;background-color: #131360;width: 100%}
    .dnFlex>div[contenidoCabecera]{display: flex;flex-direction: column;}
    .dnFlex>div[contenidoCabecera]>div[lt]{display: flex;margin-bottom: 1%}
    .dnFlex>div[contenidoCabecera]>div[lt]>div[lthijo]{justify-content: space-between;}
       
    .dnFlex>div[contenidoCabecera]>div[lt]>div[lthijo]:first-child{flex: 1}
    .dnFlex>div[contenidoCabecera]>div[lt]>div[lthijo]:nth-child(2){flex: 3}
    .dnFlex>div[contenidoCabecera]>div[lt2colum]{display: flex;}
    .dnFlex>div[contenidoCabecera]>div[lt2colum]{display: flex;margin-bottom: 1%}
    .dnFlex>div[contenidoCabecera]>div[lt2colum]>div[lthijo]:first-child{flex: 1;display: flex}
    .dnFlex>div[contenidoCabecera]>div[lt2colum]>div[lthijo]:nth-child(2){flex: 1;display: flex}
    .dnFlex>div[contenidoCabecera]>div[lt2colum]>div[lthijo] div{display: flex;flex-direction: row}
    .dnFlex>div[contenidoCabecera]>div[lt2colum]>div[lthijo]>div:first-child{flex: 1;}
    .dnFlex>div[contenidoCabecera]>div[lt2colum]>div[lthijo]>div:nth-child(2){flex: 2;}
    .dnFlex>div[contenidoCabecera]>div[lt]>div[ltmatriz]{display: flex;flex-direction: row;flex:2;}
    .dnFlex>div[contenidoCabecera]>div[lt]>div[ltmatriz]>div[ltmatrizcolrow]{display: flex;flex-direction: column;flex: 1}

    .dnFlex>div[contenidoCabecera]>div[lt]>div[lthijoRow]{display: flex;justify-content: space-between;flex: 1;border-bottom: 1px solid #c0c5cd}
    .dnFlex>div[contenidoCabecera]>div[lt]>div[lthijoRow='sr']{display: flex;justify-content: space-between;flex: 1;border-bottom: none}
    .dnFlex>div[contenidoCabecera]>div[lt]>div[lthijoRowCol]{display: flex;justify-content: space-between;flex: 1;border-bottom: 1px solid #c0c5cd} 
    .dnFlex>div[contenidoCabecera]>div[lt]>div[lthijoRow]>div{display: flex;flex: 1;margin-left: 2%} 
    .form-control{max-height: 100px;height: 35px}
    @media only screen and (max-width:1000px)
    {.dnFlex>div[contenidoCabecera]>div[lt]>div[ltmatriz]{display: flex;flex-direction: column;}
        .dnFlex>div[contenidoCabecera]>div[lt]>div[ltmatriz]>div[ltmatrizcolrow]{display: flex;flex-direction: row;justify-content: space-between;}
        .dnFlex>div[contenidoCabecera]>div[lt]>div[ltmatriz]>div[ltmatrizcolrow]>input{flex: 1}
        .dnFlex>div[contenidoCabecera]>div[lt]>div[ltmatriz]>div[ltmatrizcolrow]>div{flex:2;}
        .dnFlex>div[contenidoCabecera]>div[lt]>div[lthijoRowCol]{flex-direction: column; justify-content: space-between;}
        .dnFlex>div[contenidoCabecera]>div[lt]>div[lthijoRowCol]>div{display: flex;justify-content: space-between;}
        .form-control{max-height: 100px;height: 35px}

    }

</style>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
</head>
<body>
<form name="frmGuardar" id="frmGuardar" method="post" action="<?php echo base_url()?>crmproyecto/setDeteccionNecesidades">
    <input type="hidden" name="IDCL" value="<?php echo $IDCL;?>">
    <div class="dnFlex">
        <div  image><img src="https://cdn.shortpixel.ai/client/q_lqip,ret_wait/https://www.capitalseguros.com.mx/wp-content/uploads/2018/02/logo.png" width='20%'></div>
        <div cabeceraDelcontenido><span style="font-weight: bold; color: #fff;margin-left: 3%;">PASO 1: ACUERDO PREVIO</span></div>
        <div contenidoCabecera>
             <p style="font-style: italic;padding: 3%;">
                        "Antes de iniciar, me gustaría hacer un compromiso con usted; durante este tiempo vamos a hablar de algunos conceptos y voy a hacerle algunas preguntas con el objeto de analizar si nuestros servicios pueden serle de utilidad.
Eventualmente voy a preguntarle si los temas de los que estamos hablando le interesan o no; si me contesta que no le interesa, en ese momento le agradezco y me retiro: ahora, si le interesa continuaremos ¿le parece bien?"

        </div>
        <div cabeceraDelcontenido><span style="font-weight: bold; color: #fff;margin-left: 3%;">INFORMACIÓN PERSONAL</span></div>
        <div contenidoCabecera>
           <div lt><div lthijo>Nombre:</div><div lthijo><?php echo $datos[0]->Nombre." ".$datos[0]->ApellidoP;?></div></div>
            <div lt><div lthijo>Fecha de Captación:</div><div lthijo><?php echo date('d-m-Y', strtotime($datos[0]->fechaActualizacion));?></div></div>
                <div lt>
                        <div lthijo>Dirección</div>
                        <div lthijo>
                            <input type="text" name="text1" id="text1" class="form-control" >
                        </div>
                </div>

            <div lt>
                        <div lthijo>Correo electronico:</div>
                        <div lthijo>
                            <input type="text" name="text2" id="text2" class="form-control"  value="<?php echo $datos[0]->EMail1?>">
                        </div>
           </div>
                <div lt>
                    <div lthijorow='sr'>
                        <div>Edad</div>
                        <div><input type="text" name="text3" id="text3" class="form-control"></div>
                        <div>Fecha de nacimiento</div>
                     <div> <input type="date" name="text4" id="text4" class="form-control" placeholder="<?php echo date('d-m-Y', strtotime($datos[0]->fecha_nacimiento));?>"></div>
                     
                    </div>
                </div>

                <div lt>
                    <div lthijo>Estado civil</div>
                    <div lthijo>
                        <select class="form-control" name="text5" id="text5">
                            <option value="<?php echo $datos[0]->EdoCivil;?>"><?php echo $datos[0]->EdoCivil;?></option>
                            <option value="Casado">Casado(a)</option>
                            <option value="Soltero">Soltero(a)</option>
                            <option value="Divorciado">Divorciado(a)</option>
                            <option value="Viudo">Viudo(a)</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>                

                <div lt>
                    <div lthijorow>                    
                     <div>Casa propia<input type="radio" name="text6" id="text6" value="Casa propia"></div>
                     <div>Rentada<input type="radio" name="text6" id="text6" value="Rentada"></div>
                     <div>Renta<input type="radio" name="text6" id="text6" value="Renta"></div>
                     <div>Valor hipoteca<input type="radio" name="text6" id="text6" value="Valor hipoteca"></div>
                    
                </div>
                </div>

        </div>
        <div cabeceraDelContenido>
         <span style="font-weight: bold; color: #fff;margin-left: 3%;">INFORMACIÓN OCUPACIONAL</span>   
        </div>

               <div contenidocabecera>
                    <div lt2colum>
                    <div lthijo><div>Profesión</div><div><input type="text" name="text7" id="text7" class="form-control"></div></div>
                    <div lthijo><div>Ocupación</div><div><input type="text" name="text8" id="text8" class="form-control" <?php echo $datos[0]->Nombre." ".$datos[0]->Ocupacion;?>></div>
                    </div>
                    </div>

                    <div lt2colum>
                    <div lthijo><div>Empresa</div><div><input type="text" name="text9" id="text9" class="form-control"></div></div>
                    <div lthijo><div>Telefono</div><div><input type="text" name="text8" id="text8" class="form-control"></div></div>
                   </div>
                    <div lt>
                    <div lthijo> Dirección de oficina</div>
                    <div lthijo><input type="text" name="text9" id="text9" class="form-control"></div>
                   </div>

                 <div lt>
                  <div lthijorow>
                    <div><h5>Afore</h5></div>
                    <div>Si<input type="radio" name="text10" id="text10" value="si"></div>
                    <div>No<input type="radio" name="text10" id="text10" value="no"></div>  
                    <div><h5>Afore conyugue</h5></div>
                    <div>Si<input type="radio" name="text11" id="text11" value="si"></div>
                    <div>No<input type="radio" name="text11" id="text11" value="no"></div>
                    
                </div>
                </div>

                </div>
        <div cabeceraDelContenido>
         <span style="font-weight: bold; color: #fff;margin-left: 3%;">INFORMACIÓN DEL SEGURO</span>   
        </div>                
         <div contenidocabecera>
             <div lt>
                   <div ltmatriz>
                    <div ltmatrizcolrow><div>Asegurado</div><input type="text" name="text12" id="text12" class="form-control"><input type="text" name="text22" id="text22" class="form-control"><input type="text" name="text32" id="text32" class="form-control"></div>
                    <div ltmatrizcolrow><div>Compañia</div><input type="text" name="text13" id="text13" class="form-control"><input type="text" name="text23" id="text23" class="form-control"><input type="text" name="text33" id="text33" class="form-control"></div>
                    <div ltmatrizcolrow><div>No. de Póliza</div><input type="text" name="text14" id="text14" class="form-control"><input type="text" name="text24" id="text24" class="form-control"><input type="text" name="text34" id="text34" class="form-control"></div>
                    <div ltmatrizcolrow><div>Fec. de Vigen.</div><input type="text" name="text15" id="text15" class="form-control"><input type="text" name="text25" id="text25" class="form-control"><input type="text" name="text35" id="text35" class="form-control"></div>
                    <div ltmatrizcolrow><div>Sum Asegur</div><input type="text" name="text16" id="text16" class="form-control"><input type="text" name="text26" id="text26" class="form-control"><input type="text" name="text36" id="text36" class="form-control"></div>
                    <div ltmatrizcolrow><div>Tipo</div><input type="text" name="text17" id="text17" class="form-control"><input type="text" name="text27" id="text27" class="form-control"><input type="text" name="text37" id="text37" class="form-control"></div>
                    <div ltmatrizcolrow><div>Cobertura</div><input type="text" name="text18" id="text18" class="form-control"><input type="text" name="text28" id="text28" class="form-control"><input type="text" name="text38" id="text38" class="form-control"></div>
                    <div ltmatrizcolrow><div>Prima</div><input type="text" name="text19" id="text19" class="form-control"><input type="text" name="text29" id="text29" class="form-control"><input type="text" name="text39" id="text39" class="form-control"></div>
                    <div ltmatrizcolrow><div>Beneficiario</div><input type="text" name="text20" id="text20" class="form-control"><input type="text" name="text30" id="text30" class="form-control"><input type="text" name="text40" id="text40" class="form-control"></div>
                    <div ltmatrizcolrow><div>Titular</div><input type="text" name="text21" id="text21" class="form-control"><input type="text" name="text31" id="text31" class="form-control"><input type="text" name="text41" id="text41" class="form-control"></div>
                </div>
             </div>
         </div>
         <div cabeceraDelContenido>
             <span style="font-weight: bold; color: #fff;margin-left: 3%;">PASO 2: PREVISIÓN FINACIERA</span>
         </div>
         <div contenidocabecera>
             <div>
                                    <span style="font-weight: bold;color: #6d92c9;font-size: 30px;">¿Qué tan difícil te resulta ahorrar?</span>
                    <p style="padding: 3%;">
                        Nuestra vida productiva inicia cuando empezamos a trabajar y comenzamos a ser productivos y con el tiempo vamos creciendo y pasando por diferentes compromisos, metas o sueños en los que hemos requerido de dinero y/o sabemos que vamos a necesitar para lograrlo: hasta que llega el momento en el que nos estabilizamos y llegamos a una etapa de Retiro en la que, si todo nos salió bien, nuestra productividad se puede detener, o bien, se puede venir abajo.

                    </p> 
             </div>
            <div lt>
                <div ltmatriz>
                <div ltmatrizcolrow><div>ESTABLECER METAS</div><input type="text" name="text42" id="text42" class="form-control"><input type="text" name="text44" id="text44" class="form-control"><input type="text" name="text46" id="text46" class="form-control"></div>
                <div ltmatrizcolrow><div>PRIORIZAR METAS</div><input type="text" name="text43"id="text43" class="form-control"><input type="text" name="text45"id="text45" class="form-control"><input type="text" name="text47" id="text47" class="form-control"></div>
                </div>
            </div>
                    
                


         </div>

        <div cabeceraDelcontenido><div style="text-align: center;font-weight: bold; background-color: #131360; color: #fff;">COMPROMISO MONETARIO</div></div>

         <div contenidocabecera>
          <div lt><div>¿Cuánto puede ahorrar mensualmente para su meta de protección?</div></div>
          <div lt>
            <div lthijoRow>
             <div>$<input type="text" name="text48" id="text48" size="30" class="form-control">X12</div>                           
              <div >Monto Anual $<input type="text" name="text49" id="text49" size="30" class="form-control"></div>
            </div>
          </div>

              <div lt><div>¿Cuánto puede ahorrar mensualmente para su meta de acumulación?</div></div>
              <div lt>
                    <div lthijoRow>
                       <div >$<input type="text" name="text50" id="text50" size="30" class="form-control">X12</div>                            
                       <div>Monto Anual $ <input type="text" name="text51" id="text51" size="30" class="form-control"></div>
                    </div>
                 </div>
               <div lt><div>¿Cuánto puede ahorrar mensualmente para su meta de retiro?</div></div>
                <div lt>
                    <div lthijoRow>
                            <div>$<input type="text" name="text52" id="text52" size="30" class="form-control">X12</div>
                            
                            <div>Monto Anual <input type="text" name="text53" id="text53" size="30" class="form-control"></div>

                    </div>
                </div>

            <div lt>
                <div>
                    <p>
                        <ul style="font-style: italic;">
                            <li>
                                Preguntar si existe alguna otra meta a considerar
                            </li>
                            <li>
                                Priorizar la meta más importante para el prospecto
                            </li>
                            <li>
                                Preguntar qué medidas se están tomando para el cumplimiento de su prioridad
                            </li>
                            <li>
                                Sensibilizar, preguntando, qué representaría emocionalmente el cumplimiento de la meta priorizada
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
   <div lt>
                   
               <div>
                        <ul>
                            <li><b>¿Tendrás algún otro proyecto que sea importante a mediano y largo plazo?</b></li>
                            <li style="list-style: none"><input type="text" name="text54" id="text54" class="form-control" placeholder="RESPUESTA"></li>
                            <li><b>¿Cuál de estas metas es tu prioridad?</b></li>
                            <li style="list-style: none"><input type="text" name="text55" id="text55" class="form-control" placeholder="RESPUESTA"></li>
                            <li><b>¿Qué medidas estás tomando para cumplir este proyecto? ¿Estas ahorrando actualmente para esto?</b></li>
                            <li style="list-style: none"><input type="text" name="text56" id="text56" class="form-control" placeholder="RESPUESTA"></li>
                            <li><b>¿Qué medidas estás tomando para cumplir este proyecto? ¿Estas ahorrando actualmente para esto?</b></li>
                            <li style="list-style: none"><input type="text" name="text57" id="text57" class="form-control" placeholder="RESPUESTA"></li>
                        </ul>
                   </div>

   </div>
</div>
    <div cabeceraDelcontenido>
        <div style="font-weight: bold; background-color: #131360; color: #fff;">PASO 3: PLANEACIÓN PATRIMONIAL</div>
    </div>
         
            <div contenidocabecera>
            <div style="font-weight: bold;color: #6d92c9;font-size: 30px;">¿Qué tan importante es para usted cubrir lo siguiente?</div>
            <div lt>
                <div lthijorow style="background-color: #131360;text-align:center;color: #fff;">
                    <div>Caso</div>
                    <div>Muy importante</div>
                    <div>Importante</div>
                    <div>N/A</div>
                </div>
            </div>
            <div lt>
                <div lthijorow style="text-align:center;">
                    <div style="text-align:left;">Proteger a su familia en caso de llegar a faltar</div>
                            <div ><input type="radio" name="text58" id="text58" value="muyimportante"></div>
                            <div ><input type="radio" name="text58" id="text58" value="importante"></div>
                            <div ><input type="radio" name="text58" id="text58" value="na"></div>
                        </div>
            </div>



                        <div lt>

                         <div lthijorow style="text-align:center;">
                            <div style="text-align:left;">Cubrir sus ingresos en caso de una incapacidad</div>
                            <div><input type="radio" name="text59" id="text59" value="muyimportante"></div>
                            <div><input type="radio" name="text59" id="text59" value="importante"></div>
                            <div><input type="radio" name="text59" id="text59" value="na"></div>
                         </div>
                        </div>

                        <div lt>
                            <div lthijorow style="text-align:center;">
                            <div style="text-align:left;">Prever los fondos necesarios para la educación de sus hijos y/o nietos</div>
                            <div><input type="radio" name="text60" id="text60" value="muyimportante"></div>
                            <div><input type="radio" name="text60" id="text60" value="importante"></div>
                            <div><input type="radio" name="text60" id="text60" value="na"></div>
                        </div>
                        </div>

                        <div lt>
                            <div lthijorow style="text-align:center;">
                            <div style="text-align:left;">Ahorrar para un proyecto personal</div>
                            <div><input type="radio" name="text61" id="text61" value="muyimportante"></div>
                            <div><input type="radio" name="text61" id="text61" value="importante"></div>
                            <div><input type="radio" name="text61" id="text61" value="na"></div>
                        </div>
                        </div>

                        <div lt>
                            <div lthijorow style="text-align:center;">
                            <div style="text-align:left;">Garantizar la continuidad de su empresa en caso de llegar a faltar o incapacitarse</div>
                            <div><input type="radio" name="text62" id="text62" value="muyimportante"></div>
                            <div><input type="radio" name="text62" id="text62" value="importante"></div>
                            <div><input type="radio" name="text62" id="text62" value="na"></div>
                        </div>
                        </div>

                        <div lt>
                            <div lthijorow style="text-align:center;">
                            <div style="text-align:left;">Formar una herencia</div>
                            <div><input type="radio" name="text63" id="text63" value="muyimportante"></div>
                            <div><input type="radio" name="text63" id="text63" value="importante"></div>
                            <div><input type="radio" name="text63" id="text63" value="na"></div>
                        </div>
                        </div >

                        <div lt>
                            <div lthijorow style="text-align:center;">
                            <div style="text-align:left;">Contar con un seguro de gastos médicos mayores</div>
                            <div><input type="radio" name="text64" id="text64" value="muyimportante"></div>
                            <div><input type="radio" name="text64" id="text64" value="importante"></div>
                            <div><input type="radio" name="text64" id="text64" value="na"></div>
                        </div>
                        </div>
                                <td colspan="2">
            <div lt><div style="font-weight: bold;color: #6d92c9;font-size: 30px;">Priorice los 3 más importantes</div></div>
            <div lt style="background-color: #131360;color: #fff;font-weight: bold;">
            <div lthijoRowCol>
                  
                        <div><div>SALUD</div><input type="text" name="text65" id="text65" size="3" placeholder="1" style="text-align: center;"></div>
                        <div><div>EDUCACIÓN</div><input type="text" name="text66" id="text66" size="3" placeholder="2" style="text-align: center;"></div>
                        <div><div>RETIRO</div><input type="text" name="text67" id="text67" size="3" placeholder="3" style="text-align: center;"></div>
                        <div><div>AHORRO</div><input type="text" name="text68" id="text68" size="3" placeholder="4" style="text-align: center;"></div>
                        <div><div>EMPRESA</div><input type="text" name="text69" id="text69" size="3" placeholder="5" style="text-align: center;"></div>
                  
            </div>


            </div>
                <div lt><div style="font-weight: bold;color: white;font-size: 30px;background-color: #6d92c9;width: 100%">SALUD</div></div>
                <div lt>
                    <div lthijorow>
                        <div>¿En qué hospital acostumbra ir o le interesa atenderse?</div>
                        <div><input type="test" name="text70" id="text70" class="form-control"></div>
                    </div>
                </div>
                    
                <div lt><div>¿Cuenta con un doctor en particular con quien su familia se atiende?</div></div>
                <div lt>
                    <div lthijorow>
                        <div>Si<input type="radio" name="text71" id="text71"></div>                        
                        <div>No<input type="radio" name="text71" id="text71"></div>                        
                        <div>Nombre:<input type="text" name="text72" id="text72" class="form-control"></div>
                        
                   </div>
                 </div>
                <div lt>
                    <div lthijorow>
                        <div>¿Costo de consulta?</div>
                        <div>$<input type="text" name="text73" id="text73" class="form-control"></div>
                    </div>
                </div>
                <div lt>
                    <div lthijorow>
                        <div>¿Ha tenido alguna urgencia?</div>
                        <div>Si <input type="radio" name="text74" id="text74"></div>
                        
                        <div>No <input type="radio" name="text74" id="text74"></div>
                        
                    </div>
                </div>

                    <div lt>
                        <div lthijorow>
                        <div>¿Cuánto ha pagado o cree que cueste esa urgencia en ese hospital?</div>
                        <div><input type="test" name="text75" id="text75" class="form-control"></div>
                     </div>
                    </div>

                    <div lt>
                        <div>¿Tiene seguro social?</div>
                    </div>
                    <div lt>
                        <div lthijorow>
                        <div>Si <input type="radio" name="text76" id="text76"></div>                        
                        <div>No <input type="radio" name="text76" id="text76"></div>
                    </div>
                    </div>
                    <div lt>
                        <div>¿Acude a él en caso de emergencia o accidente grave?</div>
                    </div>
                    <div lt>
                        <div lthijorow>
                        <div>Si <input type="radio" name="text77" id="text77"></div>                        
                        <div>No <input type="radio" name="text77" id="text77"></div>
                    </div>
                    </div>    


                    <div lt>
                        <div lthijorow>
                        <div>¿Qué pensaría de una estrategia que se adaptara a sus posibilidades, cubriera sus metas y necesidades de ….?</div>
                        <div><input type="test" name="78" id="78" class="form-control"></div>
                    </div>
                    </div>
                    <div lt>
                        <div>Protección vigente: ¿Cuenta con algún seguro de vida o gastos médicos mayores?</div>
                    </div>
                    <div lt>
                        <div lthijorow>
                        <div>Si <input type="radio" name="text79" id="text79"></div>
                        
                        <div>No <input type="radio" name="text79" id="text79"></div>
                        </div>
                    </div>
                <div lt><div style="font-weight: bold;color: white;font-size: 30px;background-color: #6d92c9;width: 100%">EDUCACIÓN</div></div>


                <div lt>
                    <div lthijorow>
                        <div>¿Qué universidad desearía para sus hijos?</div>
                        <div><input type="test" name="text80" id="text80" class="form-control"></div>
                    </div>
                </div>
                    <div lt>
                        <div>¿Conoce lo que costará la educación profesional de cada hijo?</div>
                    </div>
                    <div lt>
                        <div lthijorow>
                        <div>Si <input type="radio" name="text81" id="text81"></div>                        
                        <div>No <input type="radio" name="text81" id="text81"></div>                        
                        <div>¿Cuánto cada uno en promedio? <input type="text" name="text82" id="text82" class="form-control"></div>
                        </div>
                    </div>

                    <div lt>
                        <div lthijorow>
                        <div>Monto ahorrado para esto $</div>
                        <div><input type="text" name="text87" id="text87" class="form-control"></div>
                     </div>
                    </div>
                    <div lt>
                      <div lthijorow>
                        <div>¿En qué tipo de esquema lo ahorra?</div>
                        <div><input type="text" name="text88" id="text88" class="form-control"></div>
                    </div>
                </div>

                    <div lt>
                        <div>¿Qué consecuencias habría si por alguna razón no contara con los recursos cando llegue el momento?</div>
                    </div>
                    <div lt>
                        <div lthijorow><input type="text" name="text89" id="text89" class="form-control"></div>
                    </div>

                    <div lt>
                        <div>Y si llegara a fallecer o incapacitarse repentinamente, ¿qué le gustaría que sucediera con la educación de su(s) hijo(s)?</div>
                    </div>
                    <div lt>
                        <div lthijorow><input type="text" name="text90" id="text90" class="form-control"></div>
                    </div>

               <div lt><div style="font-weight: bold;color: white;font-size: 30px;background-color: #6d92c9;width: 100%">RETIRO</div></div>
                    <div lt>
                        <div lthijorow><div>¿A qué edad le gustaría “retirarse financieramente”?</div> <div><input type="text" name="text91" id="text91" class="form-control"></div></div>
                        
                    </div>
                    <div lt>
                        <div lthijorow>
                            <div>¿Qué planea hacer en esta etapa?</div>  
                            <div><input type="text" name="text92" id="text92" class="form-control"></div>
                        </div>
                        
                    </div>
                    <div lt>
                        <div lthijorow>
                        <div>En pesos actuales, con cuánto considera que sería suficiente para vivir decorosamente su retiro?</div>
                        <div><input type="test" name="text93" id="text93" class="form-control"></div>
                      </div>
                    </div>

                    <div lt>
                        <div lthijorow>
                        <div>¿Cuánto tiene acumulado exclusivamente para su retiro?</div>
                        <div><input type="text" name="text94" id="text94" class="form-control"></div>
                        <div>¿En cuánto tiempo lo acumulo?</div>
                        <div><input type="text" name="text95" id="text95" class="form-control"></div>
                     </div>
                    </div>
                    <div lt>
                        <div>¿Ya calculó el capital necesario para jubilarse?</div>
                    </div>
                    <div lt>
                        <div lthijorow>
                        <div>Si <input type="radio" name="text96" id="text96"></div>                        
                        <div>No <input type="radio" name="text96" id="text96"></div>                        
                        <div>¿Cómo? <input type="text" name="text97" id="text97" class="form-control"></div>
                    </div>
                    </div>
                    <div lt>
                        <div lthijorow>
                        <div>¿Qué consecuencias habría si en su retiro no contara con estos recursos?</div>
                        <div><input type="text" name="text98" id="text98" class="form-control"></div>
                    </div>
                </div>                
                    <div lt>
                        <div lthijorow>
                        <div>¿De qué vivirían?</div>
                        <div><input type="text" name="text99" id="text99" class="form-control"></div>
                        
                    </div>
                    </div>
               <div lt><div style="font-weight: bold;color: white;font-size: 30px;background-color: #6d92c9;width: 100%">AHORRO</div></div>

                    <div lt>
                        <div>¿Tiene un sistema disciplinado y constante de ahorro a largo plazo?</div>
                    </div>
                    <div lt>
                        <div lthijorow>
                        <div>Si <input type="radio" name="text100" id="text100" value="si"></div>                        
                        <div>No <input type="radio" name="text100" id="text100" value="no"></div>                        
                        <div>¿Cómo? <input type="text" name="text101" id="text101" class="form-control"></div>
                        
                    </div>
                </div>
                    <div lt>
                        <div lthijorow>
                        <div>¿Desde cuándo?</div>
                        <div><input type="text" name="text102" id="text102" class="form-control"></div>
                        <div>¿Promedio al mes?</div>
                        <div>$<input type="text" name="text103" id="text103" class="form-control"></div>
                        
                        </div>
                    </div>
                    <div lt>
                        <div lthijorow>
                    <div>¿Qué tipo de instrumentos utiliza?</div>
                    <div><input type="text" name="text104" id="text104" class="form-control"></div>
                     </div>
                    </div>


                    <div lt>
                        <div lthijorow>
                    <div>¿Cuál es su proyecto personal?</div>
                    <div><input type="text" name="text105" id="text105" class="form-control"></div>
                    </div>
                    </div>

                    <div lt>
                        <div lthijorow>
                        <div>¿Qué debería cambiar para poder ahorrar lo suficiente y alcanzar sus metas?</div>
                        <div><input type="text" name="text106" id="text106" class="form-control"></div>
                    </div>
                    </div>


                    <div lt>
                        <div lthijorow>
                        <div colspan="10">¿Qué consecuencias habría si no contara con ese capital?</div>
                        <div><input type="text" name="text107" id="text107" class="form-control"></div>
                    </div>                                            
                    </div>




               <div lt><div style="font-weight: bold;color: white;font-size: 30px;background-color: #6d92c9;width: 100%">EMPRESA</div></div>
                <div lt><div>¿Cuál es su relación con la empresa?</div></div>
                <div lt>
                    <div lthijorow>
                        
                        
                        <div>Dueño <input type="radio" name="text108" id="text108"></div>
                        
                        <div>Socio <input type="radio" name="text108" id="text108"></div>
                        
                        <div>Empleado <input type="radio" name="text108" id="text108"></div>
                        
                        <div>Auto Empleado <input type="radio" name="text108" id="text108"></div>
                    </div>
                    </div>
                 <div lt><div>¿La empresa puede funcionar igual sin usted?</div></div>
                    <div lt> 
                        <div lthijorow>
                        
                        <div>Si<input type="radio" name="text109" id="text109"></div>
                        
                        <div>No<input type="radio" name="text109" id="text109"></div>
                        
                    </div>
                    </div>
                <div lt>
                    <div lthijorow>
                       <div>¿Tiene socios?</div><div><input type="text" name="text110" id="text110" class="form-control"></div>
                        
                        <div>¿Cuántos?</div><div><input type="text" name="text111" id="text111" class="form-control"></div>
                  </div>
                </div>
                    <div lt><div>¿Cuentan con algún fondo para liquidar a la familia de los socios a falta de alguno?</div></div>
                    <div lt>
                        <div lthijorow>                        
                        <div>Si<input type="radio" name="text112" id="text112" value="si"></div>                        
                        <div>No<input type="radio" name="text112" id="text112" value="no"></div>
                    </div>
                    </div>

                            <div lt>
                             <div lthijorow>
                                <div>¿Cuál sería el valor a cubrir por cada socio?</div>
                                <div><input type="text" name="text113" id="text113" class="form-control"></div>
                            </div>
                          </div>

                    
                    <div lt><div>Nombre de los socios</div></div>
                    <div lt>
                     <div lthijo>    
                        <div><input type="text" name="text114" id="text114" class="form-control"></div>                    
                     </div>
                   </div>
                <div lt>
                     <div lthijo>
                        <div><input type="text" name="text115" id="text115" class="form-control"></div>
                    </div>
                </div>
                                    <div lt>
                     <div lthijo>
                        <div><input type="text" name="text116" id="text116" class="form-control"></div>
                    </div>
                    </div>

                <div lt>
                    <div><input class="btn btn-primary btn-md btn-block" type="submit" style="background-color: #6d92c9;" value="Guardar">
                    </div>
                </div>
         

    </div><!-- FIN DE DNFLEX -->
</form>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</html>
<?php
$var='';
  if(count($datosDN)>0){foreach ($datosDN[0] as $key => $value) {$var.='"'.$key.'":'.'"'.$value.'",';}}
$var = substr($var, 0, -1);
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($var,true));fclose($fp);
?>
<script type="text/javascript">
 var datosDN=<?='{'.$var.'}';?>   
  
for(claveDN in datosDN)
 {
  if(document.getElementById(claveDN))
    {
        
        if(document.getElementById(claveDN).type=='radio')
        {
          let obj=Array.from(document.getElementsByName(claveDN));
            obj.forEach(o=>{if(o.value==datosDN[claveDN]){o.checked=true;}})
        }
        else{document.getElementById(claveDN).value=datosDN[claveDN];}
    }
}
</script>











