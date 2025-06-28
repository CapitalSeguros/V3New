<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class libreriaV3{
   protected $ci;
 function __construct(){
  $this->ci =& get_instance();
 }

 function imprimir($imprimir,$tipoImpresion){
      //$fp = fopen('resultadoJason.txt', $tipoImpresion);fwrite($fp, print_r($imprimir, TRUE));fclose($fp);
     // return "j";
   }

 //-------------------------------------------------------------------------------------------------------------
 
 function convierteFecha($fecha){
 	
	$result="";	
	if($fecha!="")
	{
      if(strpos($fecha,'/')){$fecha=explode('/',$fecha);    $result=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];}
      else{$fecha=explode('-',$fecha);    $result=$fecha[2].'/'.$fecha[1].'/'.$fecha[0];} 
	}else{$result=NULL;}
    return $result;
}
//-------------------------------------------------------------------------------------------------------------
public function numeroAleatorioHexadecimal(){
    $caracteresPosibles = "0123456789abcdef";
    $azar = '';
    for($i=0; $i<=13; $i++){$azar .= $caracteresPosibles[rand(0,strlen($caracteresPosibles)-1)];
    }
    return $azar;
}
//--------------------------------------------------------------------------------
 public function verificarExistenciaLlave($idForm){
  $consulta="select (count(idFormulario)) as total from idformulario where idFormulario='".$idForm."'";
  
  $resultado=$this->ci->db->query($consulta)->result();
  if($resultado[0]->total==0){
    $insert['idFormulario']=$idForm;
    $this->ci->db->insert('idformulario',$insert);
    return 0;
  }
  else{return 1;}

 }
//-------------------------------------------------------------------------------------------------------------

function devolverAnios(){

 //$anios=array('2023'=>'2023','2023'=>'2023','2023'=>'2023','2022'=>'2022','2021'=>'2021','2020'=>'2020','2019'=>'2019','2018'=>'2018','2017'=>'2017','2016'=>'2016');
 $anioActual=date('Y');
 for($i=$anioActual;$i>=2016;$i--)
 {
  $anios[$i]=$i;
 }
  return $anios;

}
 //-------------------------------------------------------------------------------------------------------------
 
 
 function devolverMeses(){
  $meses=array('1'=>'ENERO','2'=>'FEBRERO','3'=>'MARZO','4'=>'ABRIL','5'=>'MAYO','6'=>'JUNIO','7'=>'JULIO','8'=>'AGOSTO','9'=>'SEPTIEMBRE','10'=>'OCTUBRE','11'=>'NOVIEMBRE','12'=>'DICIEMBRE');
  return $meses;

 }
 //-------------------------------------------------------------------------------------------------------------
 function devolverDiasSemana(){
    $meses=array('0'=>'DOMINGO','1'=>'LUNES','2'=>'MARTES','3'=>'MIERCOLES','4'=>'JUEVES','5'=>'VIERNES','6'=>'SABADO');
  return $meses;
 }
 //-------------------------------------------------------------------------------------------------------------
  function devolverUltimoDiaMesActual($formato,$mes){
   $month = date('m');$year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
    if($formato=="/"){return date('d/m/Y', mktime(0,0,0, $month, $day, $year));}
    else{return date('d-m-Y', mktime(0,0,0, $month, $day, $year));}

 }
 //-------------------------------------------------------------------------------------------------------------
  function devolverFechaActual($formato){
        $month = date('m');$year = date('Y');$dia=date('d');
      if($formato=="/"){return $dia.'/'.$month.'/'.$year;}
      else{return  $dia.'-'.$month.'-'.$year;}
 }
 //-------------------------------------------------------------------------------------------------------------
 
 //-------------------------------------------------------------------------------------------------------------
   /*NOS DEVUELVE EL PRIMER DIA DEL MES ACTUAL 
     $formato=ES UN STRING, EL FORMATO EN QUE NOS DEVOLVERA DEPENDIENTO SI LE MANDAMOS - O / Y SIEMPRE DEVUELVE DIA-MES-ANIO
     $mes= ES UN ENTERO, CORRESPONDE AL DIA DE MES EMPEZANDO 1 PARA ENERO Y ASI SUCESIVAMENTE
   */
 function devolverPrimerDiaMesActual($formato,$mes){
        $month = date('m');$year = date('Y');
      if($formato=="/"){return date('d/m/Y', mktime(0,0,0, $month, 1, $year));}
      else{return date('d-m-Y', mktime(0,0,0, $month, 1, $year));}
 }
 //-------------------------------------------------------------------------------------------------------------
 function devolverUltimoDiaDeMes($formato,$mes,$anio){
      $day = date("d", mktime(0,0,0, $mes+1, 0, $anio));
    if($formato=="/"){return date('d/m/Y', mktime(0,0,0, $mes, $day, $anio));}
    else{return date('d-m-Y', mktime(0,0,0, $mes, $day, $anio));}

 }
 //-------------------------------------------------------------------------------------------------------------
 function sustituyeCaracteres($texto){
  $texto = str_replace("'","\'",$texto);
  $texto = str_replace("\"","\'",$texto);
$texto  = str_replace(array("\r", "\n"), '', $texto );
  return $texto;
 }
 
 //-------------------------------------------------------------------------------------------------------------
 //funcion creada por Dennis Castillo
  function obtenerDiaDiezDeCadaMes(){
    $obtenerFechaLimite=date("Y-m-d",mktime(0,0,0,date("m")+1,10,date("Y"))); //mktime(hour, minute, second, month, day, year, is_dst)
    #2020-03-10
    return $obtenerFechaLimite;
}
 //-------------------------------------------------------------------------------------------------------------
 function diaDeMesFinal($array)
 {
  /**/
  $respueta='';
  if((isset($array['mes'])) && (isset($array['anio'])))
  {
    $mes=date('m');
    $anio=date('Y');
    $dia = date("d", mktime(0,0,0, $array['mes']+1, 0, $array['anio']));
    $respuesta['dia']=$dia;
    $respuesta['mes']=$array['mes'];
    $respuesta['anio']=$array['anio'];

  }
  else
  { 
    $mes=date('m');
    $anio=date('Y');
    $dia = date("d", mktime(0,0,0, $mes+1, 0, $anio));
    $respuesta['dia']=$dia;
    $respuesta['mes']=$mes;
    $respuesta['anio']=$anio;
  }
  return $respuesta;
 }
 //-----------------------------------------------------------------------
 function diferenciaEntreDias($array)
 {

  $diff="";
  
  if(isset($array['fechaInicial']) && isset($array['fechaFinal']))
  {
    $date1 = new DateTime($array['fechaInicial']);
    $date2 = new DateTime($array['fechaFinal']);
    $diff = $date1->diff($date2);   
    return $diff;
  }
  else
  {
   if(isset($array['fechaInicial']))
   {

    $date1 = new DateTime($array['fechaInicial']);
    $date2 = new DateTime(date('Y').'/'.date('m').'/'.date('d'));
    $diff = $date2->diff($date1);   


    return $diff;     
   } 
   else
   {
    if(isset($array['fechaFinal']))
    {
      $date1 = new DateTime($array['fechaFinal']);
      $date2 = new DateTime(date('Y').'/'.date('m').'/'.date('d'));
      $diff = $date2->diff($date1);

      return $diff;     
    } 
   }
  }
 }

 //-----------------------------------------------
 function agrupaPersonasParaSelect($array,$config=null)
 {
  /*
  $config es un arreglo que debe contener tipoPersona, 
  tipoPersona==Agente entonces devolvera solo los agentes
  tipoPersona==Colaborador devolvera  Colaboradores, 
  si tipoPersona  existe y es diferente a los valores que debe recibir o tipoPersona es null entonces devolvera ambos
   */
  $infoVendedor=array();
  $infoColaborador=array();

  foreach ($array as $key => $value) 
  {
    $nombre=$value->Name;
     if(!isset($info[$nombre])){$info[$nombre]=array();}
     if($value->tipoPersona==1)
     {
     $infoColaborador[$nombre]['tipoPersona']=$value->tipoPersona;
     $infoColaborador[$nombre]['Name']=$value->Name;
     }
     else
     {
     $infoVendedor[$nombre]['tipoPersona']=$value->tipoPersona;
     $infoVendedor[$nombre]['Name']=$value->Name;
     }
    // array_push($info[$nombre], $value);
  }
  asort($infoVendedor);
  asort($infoColaborador);

   foreach ($infoColaborador as $key => $value) 
   {
  unset($infoColaborador[$key]['tipoPersona']);
  unset($infoColaborador[$key]['Name']);
   }

   foreach ($infoVendedor as $key => $value) 
   {
  unset($infoVendedor[$key]['tipoPersona']);
  unset($infoVendedor[$key]['Name']);
   }

  foreach ($array as $key => $value) 
  {
   if($value->tipoPersona==1){array_push($infoColaborador[$value->Name], $value);}
   else{array_push($infoVendedor[$value->Name], $value);} 
   }
     
   $info=array();
   if(is_null($config)){$info=array_merge($infoVendedor, $infoColaborador);}
   else
   {
    if(isset($config['tipoPersona']))
    {
     switch ($config['tipoPersona']) {
       case 'Colaborador':
         $info=$infoColaborador;
         break;
       
       case 'Agente':$info=$infoVendedor;break;

       default:$info=array_merge($infoVendedor, $infoColaborador); break;
     }
    }
    else{$info=array_merge($infoVendedor, $infoColaborador);}
   }
  return $info ;
    
 }
 
 //-------------------------------------------------------------------------------------------------------------
  function devolverAnioActualConAnteriores($arrya=null)
 {
   $option=array();

  for($i=date("Y");$i>=2018;$i--){array_push($option, $i);}
  return $option;  
 }
 //-------------------------------------------------------------------------------------------------------------
 function comprobarRFC($rfc,$tipoPersona='')
 {
    
      if($tipoPersona=='0')
        { $tipoPersona='FISICA';} 
      else{ 
            if($tipoPersona=='1'){ $tipoPersona='MORAL' ;}
            else{$tipoPersona=strtoupper($tipoPersona);}
          }
      

   $bandComprobacion=0;
   $respuesta['mensaje']='';
   $respuesta['esRFC']=0;
   
   $rfc = str_replace("-","",$rfc);
   $cantidad=strlen($rfc);
   switch ($tipoPersona) {
     case 'FISICA':
       if($cantidad==13)
        {
          
          if(ctype_alpha($rfc[0]) && ctype_alpha($rfc[1]) && ctype_alpha($rfc[2]) && ctype_alpha($rfc[3]))
          {
            if(ctype_digit($rfc[4]) && ctype_digit($rfc[5]) && ctype_digit($rfc[6]) && ctype_digit($rfc[7]) && ctype_digit($rfc[8]) && ctype_digit($rfc[9]) )
            {
              $respuesta['esRFC']=1;
            }
            else{$respuesta['mensaje']='El RFC no tiene la estructura para el de una persona fisica';}
          }
          else{$respuesta['mensaje']='El RFC no tiene la estructura para el de una persona fisica';}
        }
       else{$respuesta['mensaje']='El numero de caracteres no corresponde al de un RFC de un persona Fisica';}
       break;
       case 'MORAL':
       if($cantidad==12)
        {
            if(ctype_alpha($rfc[0]) && ctype_alpha($rfc[1]) && ctype_alpha($rfc[2]) )
          {
            if(ctype_digit($rfc[3]) && ctype_digit($rfc[4]) && ctype_digit($rfc[5]) && ctype_digit($rfc[6]) && ctype_digit($rfc[7]) && ctype_digit($rfc[8] ))
            {
              $respuesta['esRFC']=1;
            }
            else{$respuesta['mensaje']='El RFC no tiene la estructura para el de una persona Moral';}
          }
          else{$respuesta['mensaje']='El RFC no tiene la estructura para el de una persona Moral';}
        }
       else{$respuesta['mensaje']='El numero de caracteres no corresponde al de un RFC de un persona Moral';}
       break;
     default:
      if($cantidad==13 || $cantidad==12)
        {
          if(ctype_alpha($rfc[0]) && ctype_alpha($rfc[1]) && ctype_alpha($rfc[2]) )
          {
            if( ctype_digit($rfc[4]) && ctype_digit($rfc[5]) && ctype_digit($rfc[6]) && ctype_digit($rfc[7]) && ctype_digit($rfc[8]) )
            {
              $respuesta['esRFC']=1;
            }
            else{$respuesta['mensaje']='El RFC no tiene la estructura requerida';}
          }
          else{$respuesta['mensaje']='El RFC no tiene la estructura requerida';}
        }
       else{$respuesta['mensaje']='El numero de caracteres no corresponde al de un RFC de un persona Fisica o Moral';}
       break;
   }
 
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp,print_r($rfc,TRUE));fclose($fp); 


   return $respuesta;
 }
 //-----------------------------------------------
 function comprobarNumeroTelefonoSicas($telefono)
{
  $numero=explode(':',$telefono);
 
    if((count($numero))>1)
      {
        if(ctype_digit($numero[1])){return $numero[1];}
        else{return  0; }
      }
    else
      { 
        if(ctype_digit($numero[0])){return $numero[0];}
        else{return 0;}
      }
}
 //-----------------------------------------------
 
 

}