<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kpi extends CI_Model {
  public function __Construct(){
  parent::__Construct();
    //$this->load->library('localfileuploader');
   $this->load->model('capitalhumano_model');
}

function kpi_indicadoproductividad($kpi='')
{
 
 
	$respuesta['kpi']=array();
  $respuesta['success']=true;
  $respuesta['mensaje']='';
  
	if(isset($kpi['idKPI']))
	{

       if($kpi['idKPI']==-1)
       {
        if($kpi['kpi']!='')
        {
         $insert['kpi']=$kpi['kpi'];
         $insert['variable1']=$kpi['variable1'];
         $insert['variable2']=$kpi['variable2'];
         $insert['comentarioKPI']=$kpi['comentarioKPI'];
         $insert['referenciaKPI']=$kpi['referenciaKPI'];
         $this->db->insert('kpi_indicadorproductividad',$insert);
        }
        else
        {
          $respuesta['success']=false;
          $respuesta['mensaje']='El nombre no puede estar en blanco';
        }
       }
       else
       {
         if(isset($kpi['update']))
         {
          if(isset($kpi['kpi'])){ $update['kpi']=$kpi['kpi'];}
          if(isset($kpi['variable1'])){$update['variable1']=$kpi['variable1'];}
          if(isset($kpi['variable2'])){$update['variable2']=$kpi['variable2'];}
          if(isset($kpi['comentarioKPI'])){$update['comentarioKPI']=$kpi['comentarioKPI'];}
          if(isset($kpi['referenciaKPI'])){$update['referenciaKPI']=$kpi['referenciaKPI'];}
          if(isset($kpi['estaBorrado'])){$update['estaBorrado']=$kpi['estaBorrado'];}
          $this->db->where('idKPI',$kpi['idKPI']);
          $this->db->update('kpi_indicadorproductividad',$update);
         }
         else
         {
  
          $consulta='select * from kpi_indicadorproductividad where estaBorrado=0  and idKPI='.$kpi['idKPI'].' order by idKPI desc';
          $respuesta['kpi']=$this->db->query($consulta)->result();
         }
       }
	}
	else
	{
    
    /*$puestosParaKpi=$this->puestoDevolver()['idPuestos'];
    $filtro='';
    if(count($puestosParaKpi)>0)
    {
      $filtro=' and in (';
      $filtro.=implode(',',$puestosParaKpi);
      $filtro.=')';
    }
    */
		$consulta='select * from kpi_indicadorproductividad where estaBorrado=0  order by idKPI desc';
		$respuesta['kpi']=$this->db->query($consulta)->result();
	}
	return $respuesta;
}
 
//-----------------------------------------------------------
  function kpi_puesto($array)
  {

  	$respuesta['success']=0;
  	$respuesta['mensaje']='No existe idPuesto o idKPI';

     if(isset($array['idPuesto']) && isset($array['idKPI']))
     {
      if(isset($array['eliminar']))
      {
         $this->db->where('idPuesto',$array['idPuesto']);
         $this->db->where('idKPI',$array['idKPI']);
         $update['estaBorrado']=1;
         $this->db->update('kpi_puesto',$update);
         $respuesta['success']=1;
         $respuesta['mensaje']='Eliminacion realizada con exito';
      }

       else{
       
         $consulta='select (count(idPuesto)) AS contador from kpi_puesto where idPuesto='.$array['idPuesto'].' AND idKPI='.$array['idKPI'];
         $insercion=$this->db->query($consulta)->result()[0]->contador;
         if($insercion==0)
         {
         	$insert['idPuesto']=$array['idPuesto'];
         	$insert['idKPI']=$array['idKPI'];
         	$this->db->insert('kpi_puesto',$insert);
        	$respuesta['success']=1;
  	     $respuesta['mensaje']='La insercion se realizo con exito';
         }
         else
         {
          $respuesta['success']=0;
  	      $respuesta['mensaje']='Ya existe este vinculo';
         }

        } 
     }
     else
     {
      if(isset($array['idKPI']))
      {
        $consulta='select * from kpi_puesto where estaBorrado=0 and idKPI='.$array['idKPI'];
        
        $respuesta['kpiPuesto']=$this->db->query($consulta)->result();
        $respuesta['mensaje']='CONSULTA POR idKPI';
        $respuesta['success']=1;
      }
     }

   return $respuesta;

  }
//----------------------------------------------
function kpiUnionPuesto($array='')
{

        $puestosParaKpi=$this->puestoDevolver();
       $filtro='';
       
       if(count($puestosParaKpi['idPuestos'])>0)
       {
        $filtro=' and k.idPuesto in (';
        $filtro.=implode(',',$puestosParaKpi['idPuestos']);
        $filtro.=')';
       }

   $consulta='select k.*,pp.personaPuesto,pp.email,p.nombres,p.apellidoPaterno,p.apellidoMaterno,kip.kpi,kip.variable1,kip.variable2,kip.comentarioKPI,ca.colaboradorArea,kip.referenciaKPI,kip.idAutomatico from kpi_puesto k
left join personapuesto pp on pp.idPuesto=k.idPuesto
left join persona p on p.idPersona=pp.idPersona 
left join kpi_indicadorproductividad kip on kip.idKPI=k.idKPI
left join colaboradorarea ca on ca.idColaboradorArea=pp.idColaboradorArea
where k.estaBorrado=0'.$filtro;
 
  $respuesta['kpiPuesto']=$this->db->query($consulta)->result();
  $respuesta['tieneOtrosPuestos']=$puestosParaKpi['tieneOtrosPuestos'];
  return $respuesta;
  
}
//----------------------------------------------
function kpi_puesto_mesanio($array='')
{
	$respuesta['success']=true;
  if(isset($array['insert']))
  {
    if(isset($array['mes']) and  isset($array['anio']) and isset($array['idPuesto']) and isset($array['idKPI']))
    {
      ;
    $this->db->where('mes',$array['mes']);
    $this->db->where('anio',$array['anio']);
    $this->db->where('idKPI',$array['idKPI']);
    $this->db->where('idPuesto',$array['idPuesto']);
      $this->db->delete('kpi_puesto_mesanio');
      
    $insert['idKPI']=$array['idKPI'];
    $insert['idPuesto']=$array['idPuesto'];
    $insert['mes']=$array['mes'];
    $insert['anio']=$array['anio'];
    $insert['variable1']=$array['variable1'];
    $insert['variable2']=$array['variable2'];
   $this->db->insert('kpi_puesto_mesanio',$insert);
 
    }
  }
  else{
    if(isset($array['mes']) and isset($array['anio']))
      {

        $consulta='select * from kpi_puesto_mesanio where anio='.$array['anio'].' and mes='.$array['mes'];

      }
  else
   {
    /*if(isset($array['mes']) and isset($array['anio']))
      {
        $consulta='select * from kpi_puesto_mesanio where anio=1'.$array['anio'].' and mes='.$array['mes'];
      }*/
    //else
    //{
      if(isset($array['anio']) and isset($array['idKPI']) and isset($array['idPuesto']))
      {
        $consulta='select * from kpi_puesto_mesanio where anio='.$array['anio'].'  and idKPI='.$array['idKPI'].' and idPuesto='.$array['idPuesto'];
      }
    //  }
       
     }

  $respuesta['kpiPuestosMesAnio']=$this->db->query($consulta)->result();
   }
  return $respuesta;	
}
//-----------------------------------------------------------
  function puestoDevolver()
  {
    
    $verTodos=['GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX','DESARROLLO@AGENTECAPITAL.COM','DIRECTORGENERAL@AGENTECAPITAL.COM','ASISTENTEDIRECCION@AGENTECAPITAL.COM'];
    $emailUsuario=$this->tank_auth->get_usermail();
    $idPuesto=$this->tank_auth->get_idPersonaPuesto();
    $datos['tieneOtrosPuestos']=false;
    $tieneOtrosPuestos=false;
    $filtro=null;
    
     if(in_array($emailUsuario,$verTodos)!=''){$filtro=1;} 
          $datos['usuario']=$this->capitalhumano_model->devolverPuestos($filtro);
          $datos['idPuestos']=array();
          foreach ($datos['usuario'] as $key => $value) 
            {foreach ($value as  $val2) 
             {
               array_push($datos['idPuestos'], $val2->idPuesto);
               if($idPuesto!=$val2->idPuesto){$datos['tieneOtrosPuestos']=true;}
             }
            }
           return $datos;

  }
}