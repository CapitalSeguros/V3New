<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require('KLogger/vendor/autoload.php');

class Kpi_automaticos{

  function __construct(){	$this->ci=& get_instance();	}
 //-----------------------------------------
  function kpiAutomatico($data='',$tipoKPI)
  {
  	  $puesto='';
      $kpiAutomatico=0;
      $mes=date("m");
      $anio=date("Y");
      $dia=date("d");
      switch ($tipoKPI) {
        case 'actividades': $puesto=$this->devolverPuesto($data['usuarioResponsable']);$kpiAutomatico=1;break;
        case 'renovacion' : 
          $usuarioResponsable=$this->obtenerResponsableRenovacion($data);
          if($usuarioResponsable!='')
          {
           $puesto=$this->devolverPuesto($usuarioResponsable);
           $kpiAutomatico=2;        
           //$fHastaArray=explode('T',$data['FHasta']);
           //var_dump($data);
           $fHastaArray=explode(' ',$data['FHasta']);
           $fHasta = strtotime($fHastaArray[0]);
           $fRenovacion = strtotime($anio.'-'.$mes.'-'.$dia);
          //var_dump($fHastaArray[0]);
           $fHastaSegmentado=explode('-',$fHastaArray[0]);
           if($fRenovacion>$fHasta){$this->actividadesVariable1($data['IDDocto'],2,$usuarioResponsable,$fHastaSegmentado[0],$fHastaSegmentado[1]);}       
          }
        break;
        
        default:
          # code...
          break;
      }
  	  if($puesto!='')
      {
  	    $idKPI=$this->devolverIdKpiDeAutomatico($kpiAutomatico);  	  		
        $consulta='select * from kpi_puesto where idPuesto='.$puesto->idPuesto.' and idKPI='.$idKPI;         
        $existeKPIPuesto=$this->ci->db->query($consulta)->result();
        if(count($existeKPIPuesto)==0)
        {
          $insertKP['idPuesto']=$puesto->idPuesto;
          $insertKP['idKPI']=$idKPI;
          $this->ci->db->insert('kpi_puesto',$insertKP);           	
        }
        $consulta='select * from kpi_puesto_mesanio where idKPI='.$idKPI.' and idPuesto='.$puesto->idPuesto.' and mes='.$mes.' and anio='.$anio;
        $kpiMesAnio=$this->ci->db->query($consulta)->result();
        if(count($kpiMesAnio)==0)
        {              
          $insertKP['idPuesto']=$puesto->idPuesto;
          $insertKP['idKPI']=$idKPI;  
          $insertKP['mes']=$mes;
          $insertKP['anio']=$anio;
          $insertKP['variable1']=0;
          $insertKP['variable2']=1;
          $this->ci->db->insert('kpi_puesto_mesanio',$insertKP);
        }
        else
        {
          $update='update kpi_puesto_mesanio set variable2=variable2+1 where idKPI='.$idKPI.' and idPuesto='.$puesto->idPuesto.' and mes='.$mes.' and anio='.$anio;
             $this->ci->db->query($update);
        }
      }
  	  	
    }
//--------------------------------------------------
 function actividadesVariable1($idInterno=0,$kpiAutomatico=0,$usuarioResponsable='',$anio=0,$mes=0)
 {

switch ($kpiAutomatico) {
  case 1:
    if($idInterno>0)
     {
      $consulta='select (month(fechaCreacion)) as mes,(year(fechaCreacion)) as anio,usuarioResponsable from actividades where idInterno='.$idInterno;
      $mesAnio=$this->ci->db->query($consulta)->result()[0];
      $puesto=$this->devolverPuesto($mesAnio->usuarioResponsable) ;   
      $idKPI=$this->devolverIdKpiDeAutomatico(1);         
      $update='update kpi_puesto_mesanio set variable1=variable1+1 where idKPI='.$idKPI.' and idPuesto='.$puesto->idPuesto.' and mes='.$mesAnio->mes.' and anio='.$mesAnio->anio;
      $this->ci->db->query($update);   
      $insert['id']=$idInterno; 
      $insert['tabla']='actividades'; 
      $insert['mes']=$mesAnio->mes; 
      $insert['anio']=$mesAnio->anio; 
      $insert['usuarioResponsable']=$mesAnio->usuarioResponsable; 
      $this->ci->db->insert('kpisemaforovariable1',$insert);
   }
    break;
  case 2:
      $puesto=$this->devolverPuesto($usuarioResponsable) ;   
      $idKPI=$this->devolverIdKpiDeAutomatico(2);         
      $update='update kpi_puesto_mesanio set variable1=variable1+1 where idKPI='.$idKPI.' and idPuesto='.$puesto->idPuesto.' and mes='.$mes.' and anio='.$anio;      
      $this->ci->db->query($update);   
            $insert['id']=$idInterno; 
      $insert['tabla']='renovacion'; 
            $insert['mes']=$mes; 
      $insert['anio']=$anio; 
      $insert['usuarioResponsable']=$usuarioResponsable; 
      $this->ci->db->insert('kpisemaforovariable1',$insert);
  break;
  default:    break;
}
 }
 //-----------------------------------------------------------
function devolverPuesto($email)
{
 $consulta='select * from personapuesto where email="'.$email.'"';  	 	
  	  	$puesto=$this->ci->db->query($consulta)->result()[0];
  	  	return $puesto;
}
//-----------------------------------------------------------
function devolverIdKpiDeAutomatico($idAutomatico)
{
  	$consulta='select idKPI from kpi_indicadorproductividad where idAutomatico='.$idAutomatico;
  	$idKPI=$this->ci->db->query($consulta)->result()[0]->idKPI;  

  	return $idKPI;
}
//-----------------------------------------------------------    
  
function obtenerResponsableRenovacion($data)
{
  $responsable='';
      switch ($data['RamosNombre']) 
      {
        case 'Daños':
          $responsable='BIENES@ASESORESCAPITAL.COM';
          break;
        case 'Danos':
          $responsable='BIENES@ASESORESCAPITAL.COM';
          break;
        case 'Accidentes y Enfermedades':
          if($data['GerenciaNombre']=='ASESORES'){$responsable='ASISTENTE@ASESORESCAPITAL.COM';}
          else
           {
            if($data['GerenciaNombre']=='INSTITUCIONAL'){$responsable='LINEASPERSONALES@ASESORESCAPITAL.COM';}
           }
          break;
          case 'Vehiculos':
          if($data['Grupo']!='GRUPO CER')
          {
            if($data['SubGrupo']!='DINERCAP')
            {
              if($data['IDVend']!=723)
              {
               if($data['IDVend']!=718)
                {
                 $responsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM';        
                }
              }
            }
          }
          
          break;      
        default:
          # code...
          break;
      }


   return $responsable;  
}
//-----------------------------------------------------------

} 
/*
  1. actividadesVariable1()
      *views->actividades->verActividades (controlaSemaforos(...));

  2. kpiAutomatico()
      *models->capsysdre_actividades      (actividades_agregarGuardar(..))
      *controllers->cobranza              (aplicarRenovacion())

*/