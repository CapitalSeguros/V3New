<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//require_once(dirname(__FILE__) . '\dompdf\autoload.inc');

class tareasEnEjecucion extends CI_Controller
{
  		function __construct()
  	{
        parent::__construct();     
		$this->CI =& get_instance();
		$this->load->model('PersonaModelo');
   $this->load->model('notificacionmodel');
		$this->load->library('libreriav3');
      $this->load->library('Ws_sicas');
	}


function escalarCapacitacionPersona()
{
	/*========ESTA FUNCION SE DEBE EJECUTAR TODOS LOS DIAS A LAS 5 MAÑANA=======*/
	/*========BUSCA LAS PERSONAS QUE ESTAN CONSIDERADAS COMO NUEVAS Y VERIFICA SI: 
	    ---- PASO UNA SEMANA LE DEBE LLEGAR UNA NOTIFIACACION AL DIRECTORCOMERCIAL@AGENTECAPITAL.COM
        ---- PASO TRES SEMANAS LE DEBE LLEGAR UNA NOTIFICACION A DIRECTORGENERAL@AGENTECAPITAL.COM
	 */
	//$consulta='select (cast(p.fecAltaSistemPersona as date)) as fec,p.* from persona p left join users u on u.idPersona=p.idPersona where p.esAgenteNuevo=1 and u.banned=0 and u.activated=1';
  $consulta='select (cast(p.fecAltaSistemPersona as date)) as fec,p.* from persona p left join users u on u.idPersona=p.idPersona inner join prospective_to_user c on a.idPersona = c.idPersona where p.esAgenteNuevo=1 and u.banned=0 and u.activated=1 and c.avance = "induccion"';
	$agentesEnProceso=$this->db->query($consulta)->result();
	foreach ($agentesEnProceso as $key => $value) 
	{
		$fecha['fechaInicial']=$value->fec;
		$diferencia=$this->libreriav3->diferenciaEntreDias($fecha);
		if($diferencia->days>5)
		{
      if($value->tipoPersona==3)
      {
		      $verificaCoordinador=$this->db->query('select * from notificacion where tabla="personas" and referencia="CAPACITACION_NUEVO_INGRESO" and email="DIRECTORCOMERCIAL@AGENTECAPITAL.COM"  and idTabla='.$value->idPersona)->result();
                 if(count($verificaCoordinador)==0)
                 { 
                    $notificacion['tabla']='personas';
                    $notificacion['idTabla']=$value->idPersona;
                    $notificacion['persona_id']=808;
                    $notificacion['email']=  'DIRECTORCOMERCIAL@AGENTECAPITAL.COM';
                    $notificacion['tipo_id']='email';
                    $notificacion['referencia']='CAPACITACION_NUEVO_INGRESO';
                    $notificacion['referencia_id']='1000';
                    $notificacion['check']=0;
                    $notificacion['comentarioAdicional']='Capacitacion para '.$value->nombres.' '.$value->apellidoPaterno.' tiene mas de 5 dias';
                    $notificacion['id']=-1;
                    $notificacion['tipo']='OTRO';
                    $notificacion['controlador']='persona/agentesEnProceso';
                    $this->notificacionmodel->notificacion($notificacion);

                 }
           }
		    
		}
                if($diferencia->days>10)
		{
                 $verificaDirector=$this->db->query('select * from notificacion where tabla="personas" and referencia="CAPACITACION_NUEVO_INGRESO" and email="DIRECTORGENERAL@AGENTECAPITAL.COM"  and idTabla='.$value->idPersona)->result();                   
                 if(count($verificaDirector)==0)
                 {
                    $notificacion['tabla']='personas';
                    $notificacion['idTabla']=$value->idPersona;
                    $notificacion['persona_id']=6;
                    $notificacion['email']=  'DIRECTORGENERAL@AGENTECAPITAL.COM';
                    $notificacion['tipo_id']='email';
                    $notificacion['referencia']='CAPACITACION_NUEVO_INGRESO';
                    $notificacion['referencia_id']='1000';
                    $notificacion['check']=0;
                    $notificacion['comentarioAdicional']='Capacitacion para '.$value->nombres.' '.$value->apellidoPaterno.' tiene mas de 10 dias';
                    $notificacion['id']=-1;
                    $notificacion['tipo']='OTRO';
                    $notificacion['controlador']='persona/agentesEnProceso';
                    $this->notificacionmodel->notificacion($notificacion);    
                 }
                }
	 
	}
	
	
}
//---------------------------------------------------------------------------------------
function semaforoActividades()
{

  $respuesta=$this->verificarHorarioLaboral();
  
  if($respuesta['ejecutaRobot'])
  {
   
   $consulta='select * from actividades a where a.`Status`=5';
   $actividades=$this->db->query($consulta)->result();   
   foreach ($actividades as $value) 
   {
    $actualizar="update actividades set incrementoSemaforo=ADDDATE(incrementoSemaforo, INTERVAL '0 0 5' DAY_MINUTE),semaforoIncremento=ADDTIME(semaforoIncremento,'00:05:00') where idInterno=".$value->idInterno;
    $this->db->query($actualizar);
   }
  }
  else
  {
    
  }

}
//---------------------------------------------------------------------------------------
function verificarHorarioLaboral()
{
  $respuesta=array();
  $respuesta['ejecutaRobot']=true;
   $consulta='select now(),(DAYOFWEEK(cast(now() as date))) as diaSemana,DATE_FORMAT(NOW( ), "%H:%i:%S" ), (if(DATE_FORMAT(NOW( ), "%H:%i:%S" )>"18:00:00",true,false)) as mayor18horas, (if(DATE_FORMAT(NOW( ), "%H:%i:%S" )<"09:00:00",true,false)) as menor09horas, (select dr.estaFuncionando from tareasrobot dr where dr.tipoRobot="semaforoActividad") as estadoRobot,(select count(d.diaNoLaboral) from dianolaboral d where d.diaNoLaboral=cast(now() as date)) as diaNoLaboral';
   $info=$this->db->query($consulta)->result()[0];
   if($info->mayor18horas)
    {$respuesta['ejecutaRobot']=false;
      if(!$info->estadoRobot)
      {
       $actualizar['estaFuncionando']=1;
       $this->db->where('tipoRobot','semaforoActividad');
       $this->db->update('tareasrobot',$actualizar);
      }
    }
   if($info->menor09horas){$respuesta['ejecutaRobot']=false;}
   if(!$info->estadoRobot){$respuesta['ejecutaRobot']=false;}
   if($info->diaNoLaboral>0){$respuesta['ejecutaRobot']=false;}
   if($info->diaSemana==1 || $info->diaSemana==7 ){$respuesta['ejecutaRobot']=false;}
   
  return $respuesta;

}
//-------------------------------------------------
function actualizarDatosDeClientes()
{ 
  set_time_limit(0);
  $tableInfo=array();
  $clientes=$this->ws_sicas->obtenerClientesParaActualizar(1);
  $totalPaginas=$clientes->TableControl->Pages;  
  foreach ($clientes->TableInfo as  $value) {array_push($tableInfo, $value);}  
  for($i=1;$i<=$totalPaginas;$i++)
  {  set_time_limit(0);
    $clientes=$this->ws_sicas->obtenerClientesParaActualizar($i);
    //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($i.';', TRUE));fclose($fp);
    foreach ($clientes->TableInfo as  $value) 
    {
          $info="";
    $consulta='select (count(clp.IDCli)) as total from clientelealtadpuntos clp where clp.IDCli='.$value->IDCli;
       $info=$this->db->query($consulta)->result();        
       /*$update=array();      
       $update['NombreCompleto']=(string)$value->NombreCompleto;
       $update['nombreCliente']=(string)$value->NombreCompleto;
       $update['Telefono1']=(string)$value->Telefono1;
       $update['idContacto']=(int)$value->IDCont;
       $update['EMail1']=(string)$value->EMail1;
       $update['ApellidoP']=(string)$value->ApellidoP;
       $update['ApellidoM']=(string)$value->ApellidoM;
       $update['Nombre']=(string)$value->Nombre;
        $update['RFC']=(string)$value->RFC;
       $update['Sexo']=(int)$value->Sexo;
       $update['tipoEntidad']=(string)$value->TipoEnt_TXT;*/
       $fecha='null';
    if($info[0]->total==0)
    {
      ;
      if(isset($value->FechaNac))
      {
        #$update['fecha_nacimiento']=Strstr($value->FechaNac,"T",true);
        
        $fecha='"'.Strstr($value->FechaNac,"T",true).'"';
      }
      $insert='insert into clientelealtadpuntos (IDCli,NombreCompleto, nombreCliente,Telefono1, idContacto, EMail1, ApellidoP, ApellidoM, Nombre, RFC, Sexo, tipoEntidad, fecha_nacimiento) values ('.$value->IDCli.',"'.(string)$value->NombreCompleto.'","'.(string)$value->NombreCompleto.'","'.(string)$value->Telefono1.'",'.(int)$value->IDCont.',"'.(string)$value->EMail1.'","'.(string)$value->ApellidoP.'","'.(string)$value->ApellidoM.'","'.(string)$value->Nombre.'","'.(string)$value->RFC.'",'.(int)$value->Sexo.',"'.(string)$value->TipoEnt_TXT.'",'.$fecha.')';
      $this->db->query($insert);
      //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($insert.';', TRUE));fclose($fp);
      #$update['IDCli']=(int)$value->IDCli;     
      #$this->db->insert('clientelealtadpuntos',$update);

    }
   else
    {
      if(isset($value->FechaNac))
      {
        #$update['fecha_nacimiento']=Strstr($value->FechaNac,"T",true);
        $fecha=',fecha_nacimiento="'.Strstr($value->FechaNac,"T",true).'"';
      }
      else{$fecha=',fecha_nacimiento=null';}

      $update='update clientelealtadpuntos set nombreCompleto="'.(string)$value->NombreCompleto.'",nombreCliente="'.(string)$value->NombreCompleto.'",Telefono1="'.(string)$value->Telefono1.'",idContacto='.(int)$value->IDCont.',EMail1="'.(string)$value->EMail1.'",ApellidoP="'.(string)$value->ApellidoP.'",ApellidoM="'.(string)$value->ApellidoM.'",Nombre="'.(string)$value->Nombre.'",RFC="'.(string)$value->RFC.'",Sexo='.(int)$value->Sexo.',tipoEntidad="'.(string)$value->TipoEnt_TXT.'"'.$fecha.' where IDCli='.$value->IDCli;
      $this->db->query($update);
      
      #$this->db->where('IDCli',$value->IDCli);
      #$this->db->update('clientelealtadpuntos',$update);
    }
   }
   
  }
  

}
//-------------------------------------------------
function actualizarActividadesCapturaEmision($array='')
{
  /*ROBOT PARA ACTUALIZAR LAS ACTIVIDADES DE CAPTURAEMISION YA QUE LA PARTE DE CAPTURA LO REALIZA DIRECTAMENTE DESDE SICAS Y POR LO TANTO NO SE REFLEJA EN EL CAPSYS*/
  $consulta='select a.idInterno,a.idSicas,a.Status,a.folioActividad from actividades a where a.Status=5 and a.tipoActividad="CapturaEmision"';
  $datos=$this->db->query($consulta)->result(); 
  foreach ($datos as  $value) 
  {
     $sicas=$this->ws_sicas->buscarDocumentoPorIDSicas($value->idSicas);
     if(isset($sicas->TableInfo))
    {
      if($value->idSicas!='')
      {   $update='';
         switch ((string)$sicas->TableInfo->StatusUser_TXT) 
         {
           case 'FINALIZADA':$update='update actividades set Status=6,Status_Txt="FINALIZADA" where idInterno='.$value->idInterno.' and idSicas='.$value->idSicas;break;
           case 'AGENTE GAP':$update='update actividades set Status=1,Status_Txt="AGENTE GAP" where idInterno='.$value->idInterno.' and idSicas='.$value->idSicas;break;
            default: break;
          }          
         if($update!=''){$this->db->query($update);}
      }
    }
//$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($sicas[], TRUE));fclose($fp);   
     
  }  
  
}
//-------------------------------------------------
function compruebaProspectosEnEmision()
{
  $consulta='select * from clientes_actualiza c where c.folioActividad is not null and c.estaEmitido=0 and c.EstadoActual="COTIZADO" ';
  $cotizados=$this->db->query($consulta)->result();
  $arr=array();
  $arry=array();
  foreach ($cotizados as $key => $value) 
  {
    $consulta='select a.folioActividad from actividades a where  a.tipoActividad in ("Emision","CambiodeConducto","CapturaEmision") and a.folioActividad="'.$value->folioActividad.'" ';
    $actividadesEmision=$this->db->query($consulta)->result();
    if(count($actividadesEmision)>0){$update='update clientes_actualiza set estaEmitido=1 where IDCli='.$value->IDCli;$this->db->query($update);}   
  }

}
//-------------------------------------------------
function compruebaProspectoPagado()
{
  //144329
  //$recibos=$this->ws_sicas->obtenerRecibosPorDocumento('GMT1105136');
  //  
  $consulta='select * from clientes_actualiza c where c.folioActividad is not null and c.estaEmitido=1 and c.EstadoActual="COTIZADO" ';
  $cotizados=$this->db->query($consulta)->result();
  
  foreach ($cotizados as $key => $value) 
   {set_time_limit(0);
    $consulta='select * from actividades a where a.tipoActividad in ("Emision","CambiodeConducto","CapturaEmision") and a.folioActividad="'.$value->folioActividad.'" limit 1';
   $datosActividades=$this->db->query($consulta)->result();
   if(count($datosActividades)>0)
   {
     $idDocto=$datosActividades[0]->idSicas;
     if($idDocto!='')
     {
      $recibos=$this->ws_sicas->obtenerRecibosPorDocumento('',$idDocto);
      if(isset($recibos->TableInfo))
       {

        $bandPagado=0;
        foreach ($recibos->TableInfo as  $valueAct) {if($valueAct->Status==4){$bandPagado=1;}}
       if($bandPagado==1)
       {
        
        
         $update='update clientes_actualiza set EstadoActual="PAGADO" where IDCli='.$value->IDCli;
         $this->db->query($update);
       }
      }
     }
   }
  }
}
//-----------------------------------------------------------    
function getSelectedReportEmail()
{
    $this->load->model("metacomercial_modelo");
   $this->load->model("personamodelo");
   $correos=$this->metacomercial_modelo->metaComercialCoordinadores();//quitar el limit de la funcion en el modelo
   $anio=date('Y');
   $mes=date('m');
   $sumPolizas=true;
   $devolverPolizas=false;
   $tipoFecha='';
   $mensaje='';+
   $table='';
   
   foreach ($correos as $key => $value) 
   {
     $info=$this->metacomercial_modelo->comisionEstadoFinanciero($value->canal,$tipoFecha,$mes,$anio,$sumPolizas,$devolverPolizas);
     $table='<table border="1"><thead><tr><th style="max-widh:300px" colspan="7">'.$value->canal.' '.$value->name_complete.' ['.$value->correo.']</th>'.'<th></th></tr></thead>';
     $hijos=$this->personamodelo->vendedoresActivosPorCoordinador($value->correo);
     $table.='<tbody>';
     $trRamo='';
     $trVentaRmos='';
     $trVentaNueva='';
     $trVentaTotal='';
     $sumTotalVN=1;
     $sumTotalVT=0;
     foreach ($info['ramos'] as  $ramosValue) 
     { 

       $trRamo.='<th>'.$ramosValue->nombreMetaComercial.'</th>';
       $ventaN=$this->formatMoney($info[$ramosValue->nombreMetaComercial.'_ventaNueva']);
       $ventaT=$this->formatMoney($info[$ramosValue->nombreMetaComercial.'_ventaTotal']);
       $sumTotalVN=(double)$sumTotalVN+(double)$info[$ramosValue->nombreMetaComercial.'_ventaNueva'];
       $sumTotalVT=$sumTotalVT+(double)$info[$ramosValue->nombreMetaComercial.'_ventaTotal'];
       $trVentaNueva.='<th align="right">'.$ventaN.'</th>';
       $trVentaTotal.='<th align="right">'.$ventaT.'</th>';
     }
     $trRamo.='<th>Total</th>';
     $metaNueva= $this->metacomercial_modelo->getGoalsForMonthAndYear($value->idPersona,1,$mes,$anio);    
     $metaTotal= $this->metacomercial_modelo->getGoalsForMonthAndYear($value->idPersona,2,$mes,$anio);

      $porcientoVN=($sumTotalVN*100)/$metaNueva->monto_al_mes;
      $porcientoVT=($sumTotalVT*100)/$metaTotal->monto_al_mes;

     $table.='<tr><th>Tipo de Venta</th>'.$trRamo.'<th>Meta comercial</th></tr>'.'<tr><th>Venta Nueva</th>'.$trVentaNueva.'<th>'.$this->formatMoney($sumTotalVN).'</th><th><div>'.$this->formatMoney($metaNueva->monto_al_mes).'</div><div>'.$this->formatMoney($porcientoVN,'').'%<progress  max="100" value="'.$porcientoVN.'"></progress></div></th></tr>'.'<tr><th>Venta Total</th>'.$trVentaTotal.'<th>'.$this->formatMoney($sumTotalVT).'</th><th><div>'.$this->formatMoney($metaTotal->monto_al_mes).'</div><div>'.$this->formatMoney($porcientoVT,'').'%<progress  max="100" value="'.$porcientoVT.'"></progress></div></th></tr>'.'</tbody>';
     $table.='<tr ><th colspan="5" align="center">COMO VAN TUS VENDEDORES</th></tr>';
     $table.='<tr><th>NOMBRE DEL VENDEDOR</th><th>Tipo Venta</th>'.$trRamo.'</tr>';
     $table.='<tr>';

    $table.='</tr>';
     foreach ($hijos as  $hijosVal) 
     {
        $meta = $this->metacomercial_modelo->getGoalsForMonthAndYear($hijosVal->idPersona,1,$mes,$anio);
        
      $array['IDVend']=$hijosVal->IDVend;
       $hijoInfo=$this->metacomercial_modelo->comisionEstadoFinanciero('',$tipoFecha,$mes,$anio,$sumPolizas,$devolverPolizas,$array);
       $nombre=$hijosVal->apellidoPaterno.' '.$hijosVal->apellidoMaterno.' '.$hijosVal->nombres;
      

        $table.='<tr style="background-color:#b8ddb8;max-widh:50px"><td align="left"  rowspan="2" style="background-color:#c4c4f0">'.$nombre.'</td>';
        $table.='<td>Venta Nueva</td>';
        $sumNueva=0;
        foreach ($info['ramos'] as  $ramosValue)
         {
          $nueva=0;
          $nueva=$hijoInfo[$ramosValue->nombreMetaComercial.'_ventaNueva'];
          $table.='<td align="right">'.$this->formatMoney($nueva).'</td>';
          $sumNueva=$sumNueva+$nueva;          
        }
        $table.='<th>'.$this->formatMoney($sumNueva).'</th>';
        $table.='</tr>';
        $table.='<tr style="background-color:#b1c1ce"><td>Venta Total</td>';
        $sumTotoal=0;
        foreach ($info['ramos'] as  $ramosValue) 
          {
            $total=$hijoInfo[$ramosValue->nombreMetaComercial.'_ventaTotal'];
            $table.='<td align="right">'.$this->formatMoney($total).'</td>';
            $sumTotal=$sumTotal+$total;
          }
          $table.='<th>'.$this->formatMoney($sumTotal).'</th>';
        $table.='</tr>';
                   
     }

  
   $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($table, false));fclose($fp);

   }

  echo $mensaje; 


}
//-----------------------------------------------------------
     function getSelectedReportEmail_() 
        {
            $this->load->model("permisooperativo"); //Creado [Suemy][2024-03-21]

            $data['result'] = array();

            $data['emails'] = $this->permisooperativo->getEmployeesOfReport();
             $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r('pasp', TRUE));fclose($fp);
            $con = $this->db->query('select us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona where pp.statusPuesto=1 and pp.idPersona != 0 and c.colaboradorArea = "Directivo"')->result();

            $data['consult'] = $con;

            foreach ($data['emails'] as $val) 
            {
                $add['email'] = $val->correo;
                $add['reporte'] = $val->tipo;
                $method = 0;
                $coord = 0;
                foreach ($con as $row) {
                    if ($row->email == $val->correo) { $method = 1; }
                }
                if ($val->correo == "COORDINADOR@CAPCAPITAL.COM.MX" || $val->correo == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || $val->correo == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" || $val->correo == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM") { $coord = 1; }
                switch ($val->tipo) 
                {
                    case '1':
                        # code...
                        break;        
                    case '2':
                        $sql = ' AND a.correo = "'.$val->correo.'"';
                        $agent = "";

                        if ($method == 1) { $sql = ""; }
                        if ($coord == 1) {
                            #$agent = $this->CommercialAgentGoalReport($val->correo);
                        }
                        $message = $this->CommercialGoalReport($val->correo,$sql);
                        break;
                }
            }
        }

//-----------------------------------------------------------
      function CommercialGoalReport($email,$sql) {
            $this->load->model("metacomercial_modelo"); //Creado [Suemy][2024-03-21]
            $table = "";
            $businessClousure = $this->metacomercial_modelo->devuelveActivacionComercial()[0];
            $con = $this->db->query('SELECT * FROM `consulta_comercial_tipo_comision`')->result();
            foreach ($con as $val) {
                $search = $val->idTipoComision.$sql;
                $report = $this->metacomercial_modelo->getReportType($search);
                if ($val->tipo == "nuevo") { $title = "VENTA NUEVA"; } else { $title = "INGRESO TOTAL"; }
                if (!empty($report)) {
                    $table .= '<br><div style="font-family:Oxygen, Helvetica neue, sans-serif;font-size: 13px;"><table border="1" style="background: #472380;text-align: center;border: 1px solid #472380;width: 100%;"><thead><tr style="background: #472380;"><th colspan="5" style="color:white;padding:8px;text-align:center;background: #543b7c;">'.$title.'</th></tr><tr style="background: #efefef;"><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">NOMBRE</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">EMAIL</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">META  IMPUESTA</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">COMISION</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">COMISION FALTANTE</th></tr></thead><tbody>';
                    foreach ($report as $row) {
                        $comision = $this->metacomercial_modelo->devuelveComisionComercial($row->idUsuarioCanal,$row->idTipoComision,$businessClousure->mes_activado,$businessClousure->anio);
                        $meta = $this->metacomercial_modelo->getGoalsForMonthAndYear($row->idPersona,$row->idTipoComision,$businessClousure->mes_activado,$businessClousure->anio);
                        $comission = !empty($comision) ? $comision->comision : 0;
                        $goal = !empty($meta) ? $meta->monto_al_mes: 0;
                        $missing = 0;
                        $color = "white";
                        if ($goal > $comission) { $missing = $goal - $comission; }
                        if ($goal <= $comission && $goal != 0) { $color = "#95cd95"; }
                        $table .= '<tr style="background: '.$color.';"><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$row->name_complete.'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$row->correo.'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($goal).'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($comission).'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($missing).'</td></tr>';
                    }
                    $table .= '</tbody></table><div style="display:flex;align-items: center;background: #ebebeb;color: #3d3d3d;"><div style="background: #95cd95;width: 13px;height: 13px;margin-left: 10px;border-radius: 3px;border: 1px solid green;"></div><p style="margin-bottom:0px;margin-left: 5px;">Meta Lograda</p></div><br>';
                }
            }
            $info['title'] = "Avance Meta Comercial";
            $info['message'] = $table;
            $message = !empty($table) ? $this->load->view('email/alert',$info,TRUE) : "";
            if (!empty($message)) {
                $this->sendEmailData("DESARROLLO@AGENTECAPITAL.COM",$info['title'],$message);
              #$this->sendEmailData($email,$info['title'],$message);
            }
        }

//-----------------------------------------------------------
 function CommercialAgentGoalReport($coord) {
            $this->load->model("metacomercial_modelo"); //Creado [Suemy][2024-03-21]
            $data = array();
            $businessClousure = $this->metacomercial_modelo->devuelveActivacionComercial()[0];
            $agent = $this->db->query('select * from persona p left join users u on u.idPersona=p.idPersona where p.userEmailCreacion="'.$coord.'" and u.activated=1 and u.banned=0 and p.tipoPersona = 3')->result();
            if (!empty($agent)) {
                foreach ($agent as $val) {
                    $table = '<br><div style="font-family:Oxygen, Helvetica neue, sans-serif;font-size: 13px;"><table border="1" style="background: #472380;text-align: center;border: 1px solid #472380;width: 100%;"><thead><tr style="background: #472380;"><th colspan="5" style="color:white;padding:8px;text-align:center;background: #543b7c;">META COMERCIAL</th></tr><tr style="background: #efefef;"><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">NOMBRE</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">EMAIL</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">META</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">INGRESO</th><th class="text-center" style="color:black;padding:5px;font-family:Oxygen, Helvetica neue, sans-serif;">PORCENTAJE</th></tr></thead><tbody>';
                    $result = $this->ManageAgentsGoal(array("correo" => $val->email, "idPersona" => $val->idPersona),$businessClousure->mes_activado)[0];
                    $goal = 0;
                    $comission = 0;
                    $percentege = 0;
                    $color = "white";
                    if (!empty($result)) {
                        $goal = $result['monto_mes'];
                        $comission = $result['comision_venta_nueva'];
                        $percentege = $result['monto_mes'] > 0 && $result['comision_venta_nueva'] > 0 ? (100 * $result['comision_venta_nueva']) / $result['monto_mes'] : 0;
                        if ($result['monto_mes'] <= $result['comision_venta_nueva']) { $color = "#95cd95"; }
                    }
                    $table .= '<tr style="background: '.$color.';"><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$val->name_complete.'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$val->email.'</td><td style="padding: 5px; font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($goal).'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.$this->formatMoney($comission).'</td><td style="padding: 5px;font-family:Oxygen, Helvetica neue, sans-serif;color:black;">'.number_format($percentege).'%</td></tr></tbody></table><div style="display:flex;align-items: center;background: #ebebeb;color: #3d3d3d;"><div style="background: #95cd95;width: 13px;height: 13px;margin-left: 10px;border-radius: 3px;border: 1px solid green;"></div><p style="margin-bottom:0px;margin-left: 5px;">Meta Lograda</p></div><br>';

                    $info['title'] = "Avance Meta Comercial";
                    $info['message'] = $table;
                    $message = !empty($table) ? $this->load->view('email/alert',$info,TRUE) : "";
                    if (strstr($val->email,'@')) {
                        $this->sendEmailData("DESARROLLO@AGENTECAPITAL.COM",$info['title'],$message);
                        #$this->sendEmailData($val->email,$info['title'],$message);
                    }
                }
            }
        }

//-----------------------------------------------------------
      function ManageAgentsGoal($array_cuenta,$mes){
            $this->load->model("metacomercial_modelo"); //Creado [Suemy][2024-03-21]
            $comisiones = $this->capsysdre->obtenerGananciaMensual($array_cuenta["correo"]);
            $_obtenerMetasMensuales=$this->metacomercial_modelo->devuelveMetasMensuales($array_cuenta["idPersona"]);

            $ingresos_mensuales = array();
            $validador_ingresos = array();

            for($a = 1; $a < 13; $a++){
                foreach($comisiones as $dd){
                    if($a == $dd->mesEAB){
                        $ingresos_mensuales[$dd->mesEAB]["comision_venta_nueva"] = $dd->comisionVentaEAB;
                        $ingresos_mensuales[$dd->mesEAB]["ingresos_totales"] = $dd->ingresoTotalesEAB;
                        array_push($validador_ingresos, $dd->mesEAB);
                    }
                }
                if(!in_array($a, $validador_ingresos)){
                    $ingresos_mensuales[$a]["comision_venta_nueva"] = 0;
                    $ingresos_mensuales[$a]["ingresos_totales"] = 0;
                }
            }

            $metaM=array();
            $validador=array();
            $arreglo = array();

            for($i=1; $i<13;$i++){
                foreach($_obtenerMetasMensuales as $meses){
                    if($i == $meses->mes){
                        $arreglo["venta_nueva"][$meses->mes]["monto_mes"]=$meses->montoMes;
                        $arreglo["venta_nueva"][$meses->mes]["comision_venta_nueva"] = $ingresos_mensuales[$meses->mes]["comision_venta_nueva"];
                        $arreglo["venta_nueva"][$meses->mes]["comision_ingreso_total"] = $ingresos_mensuales[$meses->mes]["ingresos_totales"];
                        array_push($validador,$meses->mes);
                    }
                }
                if(!in_array($i,$validador)){
                    if ($i == $mes) {
                        $add["mes"] = $i;
                        $add["monto_mes"] = 2500;
                        $add["comision_venta_nueva"] = $ingresos_mensuales[$i]["comision_venta_nueva"];
                        $add["comision_ingreso_total"] = $ingresos_mensuales[$i]["ingresos_totales"];
                        array_push($arreglo, $add);
                    }
                }
            }
            return $arreglo;
        }

//-----------------------------------------------------------
  function sendEmailData($email,$subject,$message) {
            $this->load->model('email_model'); //Creado [Suemy][2024-03-21]
            $email = array("desde" => "Avisos de GAP <sistemas@asesorescapital.com>","para" => $email,"asunto" => $subject,"mensaje" => $message,"status" => 0,"identificaModulo" => "","fechaEnvio" => date("Y-m-d H:i:s"));
            $send = $this->email_model->SendEmail($email);
            return $send;
    }
//-----------------------------------------------------------
        function formatMoney($num,$signo="$"){return $signo.number_format((Double)$num, 2, '.', ',');}

//-----------------------------------------------------------
function __destruct()
  {


  }
}