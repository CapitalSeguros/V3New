<?php
class reportes_model extends CI_Model{

	var $Invitados;
	public $CI;
	
	public function __Construct(){
		parent::__Construct();
		$this->CI =& get_instance();
	}


	public function clearDoc($ID,$TipoRep){
		$this->db->where('IDUserLocal',$ID);
		$this->db->where('TipoReporte',$TipoRep);
		$this->db->delete('documento');
	}

	public function clearCli($ID,$TipoRep){
		$this->db->where('IDUserLocal',$ID);
		$this->db->where('TipoReporte',$TipoRep);
		$this->db->delete('cliente');
	}

	public function clearBit($ID,$TipoRep){
		
		$this->db->where('IDUserLocal',$ID);
		$this->db->where('TipoReporte',$TipoRep);
		$this->db->delete('bitacora');

	}

	public function existBit($IDBit,$ClaveBit,$Serie,$RowNumber,$IDUserLocal,$TipoReporte){

		$this->db->where('IDBit',$IDBit);
		$this->db->where('ClaveBit',$ClaveBit);
		$this->db->where('Serie',$Serie);
		$this->db->where('RowNumber',$RowNumber);
		$this->db->where('IDUserLocal',$IDUserLocal);
		$this->db->where('TipoReporte',$TipoReporte);
	    $query = $this->db->get('bitacora');

	    if ($query->num_rows() > 0){
	        return true;
	    }
	    else{
	        return false;
	    }

	}

	public function existBitVal($IDUserLocal,$TipoReporte){

		$this->db->where('IDUserLocal',$IDUserLocal);
		$this->db->where('TipoReporte',$TipoReporte);
	    $query = $this->db->get('bitacora_actualizacion');

	    if ($query->num_rows() > 0){
	        return true;
	    }
	    else{
	        return false;
	    }

	}

	public function clearDocBot($ID,$TipoRep){
		
		$this->db->where('IDUserLocal',$ID);
		$this->db->where('TipoReporte',$TipoRep);
		$this->db->delete('documento_botones');

	}

	public function addReportes($documento,$bitacoras,$ID,$TipoRep){
		$state = false;

		$this->db->trans_begin();

		$this->db->insert_batch('documento', $documento);

		// $doc_bot = array(
		// 	'IDDocto' => $documento['IDDocto'],
		// 	'IDSRamo' => $documento['IDSRamo'],
		// 	'IDCli' => $documento['IDCli'],
		// 	'Documento' => $documento['Documento'],
		// 	'ClaveBit' => $documento['ClaveBit'],
		// 	'IDUserLocal' => $ID,
		// 	'TipoReporte' => $TipoRep,
		// 	'RowNumber'=> $documento['RowNumber']);

		// $this->db->insert('documento_botones', $doc_bot);

		// foreach ($bitacoras as $key => $value) {
		// 	$Serie = "";
		// 	if(isset($documento['Serie']))
		// 	{
		// 		$Serie = $documento['Serie'];
		// 		$value['Serie'] = $documento['Serie'];
		// 	}

		// 	if(!$this->existBit($value['IDBit'],$value['ClaveBit'],$Serie,$value['RowNumber'],$ID,$TipoRep)){
		// 		$this->db->insert('bitacora', $value);
		// 	}
		// }
		
		if ($this->db->trans_status() === FALSE)
		{
			$state = false;
	        $this->db->trans_rollback();
		}
		else
		{
			$state = true;
        	$this->db->trans_commit();
		}

		return $state;
	}

	public function addClientes($documento,$polizas,$ID,$TipoRep){
		$result = false;
		$this->db->trans_begin();

		$this->db->insert('cliente', $documento);

		foreach ($polizas as $value) {
			$this->db->insert('documento',$value);
		}

		if ($this->db->trans_status() === FALSE) {
			$result = false;
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$result = true;
		}
		return $result;
	}

	public function addBitReg($data){
		$result = false;
		$this->db->trans_begin();

			if($this->existBitVal($data['IDUserLocal'],$data['TipoReporte'])){
				$this->db->where('IDUserLocal',$data['IDUserLocal']);
				$this->db->where('TipoReporte',$data['TipoReporte']);
				$this->db->update('bitacora_actualizacion',$data);
			}else{
				$this->db->insert('bitacora_actualizacion',$data);
			}

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        $result = false;
		}
		else
		{
        	$this->db->trans_commit();
        	$result = true;
		}
		return $result;
	}


	public function addBitDocumento($data,$ID,$TipoRep){
		$this->db->trans_begin();

		foreach ($data as $key => $value) {
			
		}
		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
		}
		else
		{
        	$this->db->trans_commit();
		}	
	}

	public function addBitReporte($data,$ID,$TipoRep,$MaxPage){
		$result = false;
		$this->db->trans_begin();

		$save_data = array(
			'parametros'=>$data,
			'idUserLocal'=>$ID,
			'tipoReporte'=> $TipoRep,
			'totalPaginas'=>$MaxPage);

		$this->db->insert('bitacora_reportes',$save_data);

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
		}
		else
		{
			$result = true;
        	$this->db->trans_commit();
		}	
	}
	public function updateBitReporte($idReporte,$status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
		$this->db->where('id',$idReporte);
		$this->db->update('bitacora_reportes');

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
		}
		else
		{
        	$this->db->trans_commit();
		}	
	}

	public function updateReporteStatus($idReporte,$percentage){
		$this->db->trans_begin();

		$this->db->set('porcentaje', $percentage);
		$this->db->where('id', $idReporte);
		$this->db->update('bitacora_reportes');

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
		}
		else
		{
        	$this->db->trans_commit();
		}	
	}

	public function updateReportDownload($idUserLocal,$TipoRep){
		$this->db->trans_begin();

		$this->db->set('isDescarga', 1);
		$this->db->where('idUserLocal', $idUserLocal);
		$this->db->where('tipoReporte', $TipoRep);
		$this->db->update('bitacora_reportes');

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
		}
		else
		{
        	$this->db->trans_commit();
		}	
	}

	

	public function deleteBitReporte($idUserLocal,$TipoRep){
		$this->db->trans_begin();

		$this->db->where('idUserLocal',$idUserLocal);
		$this->db->where('tipoReporte',$TipoRep);
		$this->db->delete('bitacora_reportes');

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
		}
		else
		{
        	$this->db->trans_commit();
		}	
	}



	public function getBitReporte(){
		$result = array();

		$query = $this->db->query('SELECT * FROM bitacora_reportes WHERE bitacora_reportes.`status` IN (0,1) LIMIT 1');

		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		return $result;
	}

	public function getBitReporteDetalle($idReporte){
		$result = array();
		if($idReporte == null || $idReporte == 0)
			return $result;

		$this->db->where('idReporte',$idReporte);
		$query = $this->db->get('bitacora_reportes_detalle');

		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		return $result;
	}


	public function existBitReporteDetalle($idReporte,$page){
		$result = false;
		if($idReporte == null || $idReporte == 0)
			return $result;

		$this->db->where('idReporte',$idReporte);
		$this->db->where('paginaActual',$page);
		$query = $this->db->get('bitacora_reportes_detalle');
		// var_dump($query);

		if($query->num_rows() > 0){
			$result = true;
		}
		return $result;
	}

	public function addReporteDetalle($IDRep,$Current,$data){
		$this->db->trans_begin();

		if(false == $this->existBitReporteDetalle($IDRep,$Current)){

			$save_data = array(
				'idReporte'=>$IDRep,
				'paginaActual'=>$Current,
				'valor'=> $data);

			$this->db->insert('bitacora_reportes_detalle',$save_data);
		}

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
		}
		else
		{
        	$this->db->trans_commit();
		}	
	}

	public function existReportActive($idUserLocal,$TipoRep){
		$result = array();
		if($idUserLocal == null || $idUserLocal == 0 )
			return $result;

		$query = $this->db->query("SELECT * FROM bitacora_reportes WHERE bitacora_reportes.`idUserLocal` = ".$idUserLocal." AND bitacora_reportes.`tipoReporte` = ".$TipoRep." AND bitacora_reportes.`status` IN (0,1,2) AND bitacora_reportes.`isDescarga` = 0 LIMIT 1");
		// var_dump($query);

		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		return $result;
	}

	public function reportActive($idUserLocal,$TipoRep){
		$result = array();
		if($idUserLocal == null || $idUserLocal == 0 )
			return $result;

		$this->db->where('idUserLocal',$idUserLocal);
		$this->db->where('tipoReporte',$TipoRep);
		$query = $this->db->get('bitacora_reportes');
		// var_dump($query);

		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		return $result;
	}
//----------------------------------------------------------
	public function devolverEstadoFinanciero($anio,$mes,$coordinador){
		$consulta="select distinct(eab.IDVendEAB),eab.mesEAB,eab.anioEAB,eab.metaComercialEAB,eab.comisionVentaEAB,eab.contribucionEAB,
			eab.ingresoTotalesEAB,eab.costoVentaEAB,eab.gastoOperacionEAB,eab.utilidadPerdidaEAB,eab.contribucionMarginalEAB,
			persona.apellidoPaterno,persona.nombres,persona.idPersona,personatipoagente.personaTipoAgente,persona.idpersonarankingagente,
			cc.nombreTitulo,cs.NombreSucursal,
			eab.ingresoTotalesEAB_seguros,
			eab.ingresoTotalesEAB_fianzas,
			eab.costoVentaEAB_seguros,
			eab.costoVentaEAB_fianzas,
			eab.comisionVentaEAB_seguros,
			eab.comisionVentaEAB_fianzas,
			eab.contribucionEAB_seguros,
			eab.contribucionEAB_fianzas,
			eab.costoVentaEAB_seguros,
			eab.costoVentaEAB_fianzas
			from envioagentesbitacora  eab left join persona on persona.IDVend=eab.IDVendEAB
			left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente
			left join catalog_canales cc on cc.IdCanal=persona.id_catalog_canales
			left join catalog_sucursales cs on cs.IdSucursal=persona.id_catalog_sucursales
			where (mesEAB=".$mes. ") and (anioEAB=".$anio.") and (persona.userEmailCreacion='".$coordinador."')  and (IDVendEAB!=0) order by idPersona";

		return $this->db->query($consulta)->result();
	}
//----------------------------------------------------------
function obtenerEstadoFinanciero($anio,$mes,$coordinador='')
{
	    /*  $insertar['IDVendEAB']=$datos->IDVend ;// ES EL ID DEL VENDEDOR
      $insertar['mesEAB']=$mes ;//ES EL MES DEL REPORTE
      $insertar['anioEAB']=$anio ;//ES EL ANIO DEL REPORTE
      $insertar['ingresoTotalesEAB']=$ingresosTotales ;//ES EL importePago POR LAS COMISIONES POR EL TIPO DE CAMBIO
      $insertar['costoVentaEAB']=$costoVenta ;//SON LOS INGRESOS TOTALES POR EL .7
      $insertar['contribucionMarginalEAB']=$contribucionMarginal ;//SON LOS INGRESOS TOTALES - EL COSTO DE VENTA
      $insertar['gastoOperacionEAB']=$gastosOperacion ;//ES UN VALOR POR DEFAULT 2500
      $insertar['utilidadPerdidaEAB']=$utilidad ;//ES LA CONTRIBUCION MARGINAL - LOS GASTOS DE OPERACION      
      $insertar['metaComercialEAB']=$montoMeta ;
      $insertar['comisionVentaEAB']=$sumaImporteNuevo ;//ES LA SUMA CUANDO LA RENOVACION ES 0 Y EL PERIODO ES 1
      $insertar['contribucionEAB']=$contribucion ;//IMPORTE NUEVO/MONTO DE META, SI IMPORTE NUEVO ES 0 CONTRIBUCION ES 0*/
      $filtroCoordinador='';
      $filtroUserCreacion='';
      if($coordinador!=''){$filtroCoordinador=' and emailCanal="'.$coordinador.'"';$filtroUserCreacion=' and p.userEmailCreacion="'.$coordinador.'"';}
      $consulta='select f.*,p.apellidoPaterno,p.apellidoMaterno,p.nombres,p.idPersona,personatipoagente.personaTipoAgente,p.idpersonarankingagente,cc.nombreTitulo,cs.NombreSucursal from estadofinanciero f left join persona p on p.IDVend=f.IDVend
	left join personatipoagente on personatipoagente.idPersonaTipoAgente=p.personaTipoAgente
	left join catalog_canales cc on cc.IdCanal=p.id_catalog_canales
	left join catalog_sucursales cs on cs.IdSucursal=p.id_catalog_sucursales  where f.anio='.$anio.' and f.mes='.$mes.$filtroCoordinador;
	
      $datos=$this->db->query($consulta)->result();
    
      $informacion=array();
        $idMetaComercial=$this->obtenerMetaComercial($coordinador,$anio);
        $metaComercial=$this->obtenerMetaComercialMes($idMetaComercial,$mes);
        
      $agentes='select p.idPersona,u.IDVend,p.nombres,p.apellidoPaterno,p.apellidoMaterno,p.idpersonarankingagente,pt.personaTipoAgente,(pt.personaTipoAgente) as nombreTitulo,0 as ingresoTotalesEAB,0 as costoVentaEAB,0 as contribucionMarginalEAB,0 as gastoOperacionEAB,0 as utilidadPerdidaEAB,0 as metaComercialEAB,0 as comisionVentaEAB,0 as contribucionEAB,"" as NombreSucursal from persona p left join users u on u.idPersona=p.idPersona left join personatipoagente pt on  pt.idPersonaTipoAgente=p.personaTipoAgente where u.banned=0 and u.activated=1 '.$filtroUserCreacion;
      $agenteDatos=$this->db->query($agentes)->result();
foreach ($agenteDatos as $key => $value) 
{
    $consulta='select (if(sum(f.ImportePagoTC) is null,0,sum(f.ImportePagoTC))) as ingresosTotales from estadofinanciero f where  year(f.FechaPago)='.$anio.' and month(f.FechaPago)='.$mes.' and f.IDVend='.$value->IDVend;
    $datosMonto=$this->db->query($consulta)->result();
    $value->metaComercialEAB=round($metaComercial[0]->monto_al_mes,2);
    if(count($datosMonto)>0)
    {
         $value->ingresoTotalesEAB=round($datosMonto[0]->ingresosTotales,2);
         $value->costoVentaEAB=round($value->ingresoTotalesEAB*.7,2);
         $value->contribucionMarginalEAB=round($datosMonto[0]->ingresosTotales-$value->costoVentaEAB,2);
         $value->gastoOperacionEAB=2500;
         $value->utilidadPerdidaEAB=round($value->contribucionMarginalEAB-2500,2);
	

    }
     $consulta='select (if(sum(f.ImportePagoTC) is null,0,sum(f.ImportePagoTC))) as ingresosVN from estadofinanciero f where f.Periodo=1 and f.Renovacion=0 and  year(f.FechaPago)='.$anio.' and month(f.FechaPago)='.$mes.' and f.IDVend='.$value->IDVend;
    $datosMonto=$this->db->query($consulta)->result();
    if(count($datosMonto)>0)
    {
         $value->comisionVentaEAB=round($datosMonto[0]->ingresosVN,2);

    }
    $value->contribucionEAB=round(((floatval($value->comisionVentaEAB)/floatval( $value->metaComercialEAB))*100),2);
}
  

      foreach ($datos as $key => $value) 
      {
      	if(!isset($informacion[$value->IDVend])){$informacion[$value->IDVend]=new stdClass();}

      	if(!isset($informacion[$value->IDVend]->mesEAB)){$informacion[$value->IDVend]->mesEAB=$value->mes;}
      	if(!isset($informacion[$value->IDVend]->anioEAB)){$informacion[$value->IDVend]->anioEAB=$value->anio;}
      	if(!isset($informacion[$value->IDVend]->nombreVendedor)){$informacion[$value->IDVend]->nombreVendedor=$value->apellidoPaterno.' '.$value->apellidoMaterno.' '.$value->nombres;}
      	if(!isset($informacion[$value->IDVend]->apellidoPaterno)){$informacion[$value->IDVend]->apellidoPaterno=$value->apellidoPaterno;}
      	if(!isset($informacion[$value->IDVend]->apellidoMaterno)){$informacion[$value->IDVend]->apellidoMaterno=$value->apellidoMaterno;}
      	if(!isset($informacion[$value->IDVend]->idPersona)){$informacion[$value->IDVend]->idPersona=$value->idPersona;}
      	if(!isset($informacion[$value->IDVend]->nombres)){$informacion[$value->IDVend]->nombres=$value->nombres;}
      	if(!isset($informacion[$value->IDVend]->idpersonarankingagente)){$informacion[$value->IDVend]->idpersonarankingagente=$value->idpersonarankingagente;}
   	if(!isset($informacion[$value->IDVend]->personaTipoAgente)){$informacion[$value->IDVend]->personaTipoAgente=$value->personaTipoAgente;}
   	if(!isset($informacion[$value->IDVend]->nombreTitulo)){$informacion[$value->IDVend]->nombreTitulo=$value->nombreTitulo;}
   	if(!isset($informacion[$value->IDVend]->NombreSucursal)){$informacion[$value->IDVend]->NombreSucursal=$value->NombreSucursal;}   	

      	if(!isset($informacion[$value->IDVend]->ingresoTotalesEAB)){$informacion[$value->IDVend]->ingresoTotalesEAB=0;}
      	if(!isset($informacion[$value->IDVend]->costoVentaEAB)){$informacion[$value->IDVend]->costoVentaEAB=0;}
      	if(!isset($informacion[$value->IDVend]->contribucionMarginalEAB)){$informacion[$value->IDVend]->contribucionMarginalEAB=0;}
      	if(!isset($informacion[$value->IDVend]->gastoOperacionEAB)){$informacion[$value->IDVend]->gastoOperacionEAB=2500;}
      	if(!isset($informacion[$value->IDVend]->utilidadPerdidaEAB)){$informacion[$value->IDVend]->utilidadPerdidaEAB=0;}
      	if(!isset($informacion[$value->IDVend]->metaComercialEAB)){$informacion[$value->IDVend]->metaComercialEAB=2000;}
      	 if(!isset($informacion[$value->IDVend]->comisionVentaEAB)){$informacion[$value->IDVend]->comisionVentaEAB=0;}
      	 if(!isset($informacion[$value->IDVend]->contribucionEAB)){$informacion[$value->IDVend]->contribucionEAB=0;}

      	
      	//============== VARIABLES======================
      	$ingresosTotales=0;
      	$costoVenta=0;
      	$contribucionMarginal=0;
        $utilidadPerdida=0;
        $ventaNueva=0;

        //================================================
        
        //============== OPERACIONES======================
      	$ingresosTotales=$value->PrimaTotal*$value->TCPago;
      	$costoVenta=($value->PrimaTotal*$value->TCPago)*.7;
      	$contribucionMarginal=$ingresosTotales-$costoVenta;
      	if($value->Renovacion==0 and $value->Periodo==1){$ventaNueva=$value->PrimaTotal;}
      	//================================================
      	
        //============ ASIGNACIONES =======================
      	$informacion[$value->IDVend]->ingresoTotalesEAB=$informacion[$value->IDVend]->ingresoTotalesEAB+$ingresosTotales;
      	$informacion[$value->IDVend]->costoVentaEAB=$informacion[$value->IDVend]->costoVentaEAB+$costoVenta;
      	$informacion[$value->IDVend]->contribucionMarginalEAB=$informacion[$value->IDVend]->contribucionMarginalEAB+$contribucionMarginal;
      	$informacion[$value->IDVend]->utilidadPerdidaEAB=$informacion[$value->IDVend]->utilidadPerdidaEAB+$contribucionMarginal;
      	$informacion[$value->IDVend]->comisionVentaEAB=$informacion[$value->IDVend]->comisionVentaEAB+$ventaNueva;
        //================================================
	}
      
      foreach ($informacion as $key => $value) 
      {
      	$value->utilidadPerdidaEAB=$value->utilidadPerdidaEAB-$value->gastoOperacionEAB;
      }
      return $agenteDatos;
    
}
//----------------------------------------------------------
function obtenerMetaComercial($coordinacion,$anio)
{
	$tablaId='metacomercial_ingreso_total';
	/*if($coordinacion=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){$tablaId='metacomercial'
		;$tablaMeta='metapormes';}*/
      $consulta='select idMetaComercial from '.$tablaId.' where email="'.$coordinacion.'" and anio='.$anio;       
      $idMetaComercial=$this->db->query($consulta)->result()[0]->idMetaComercial;
     return $idMetaComercial;

}

//-----------------------------------------------
function obtenerMetaComercialMes($idMetaComercial,$mes='')
{
	$filtroMes='';
	if($mes!=''){ $filtroMes=' and mes_num='.$mes;}
          $consulta='select monto_al_mes,mes_num,anio,comision_actual from metapormes_por_ingreso_total where idMetaComercial='.$idMetaComercial.$filtroMes;
          $datos=$this->db->query($consulta)->result();
     return $datos;

}
//-----------------------------------------------
function getEstadoFinanciero($anio,$mes,$coordinador){
	$respuesta=array();
	//COORDINADORCOMERCIAL@FIANZASCAPITAL.COM
	$consulta="select distinct(eab.IDVendEAB),eab.mesEAB,eab.anioEAB,eab.metaComercialEAB,eab.gastoOperacionEAB,eab.utilidadPerdidaEAB,
	persona.apellidoPaterno,persona.nombres,persona.idPersona,personatipoagente.personaTipoAgente,persona.idpersonarankingagente,
	cc.nombreTitulo,cs.NombreSucursal,";

	if($coordinador=="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" || $coordinador=="COORDINADOR@FIANZASCAPITAL.COM"){
		$consulta.="eab.ingresoTotalesEAB_fianzas as ingresoTotalesEAB,
			eab.costoVentaEAB_fianzas as costoVentaEAB,
			eab.comisionVentaEAB_fianzas as comisionVentaEAB,
			eab.contribucionEAB_fianzas as contribucionEAB,
			eab.costoVentaEAB_fianzas as contribucionMarginalEAB,
			eab.contribucionMarginalEAB_fianzas as contribucionMarginalEAB,
			eab.ingresoTotalesEAB_seguros as ingresoContrario,
			eab.costoVentaEAB_seguros as costoVentaContrario,
			eab.comisionVentaEAB_seguros as comisionVentaContrario,
			eab.contribucionEAB_seguros as contribucion,
			eab.contribucionMarginalEAB_seguros as contribucionMarginalContrario
		";
	} 
	else
	{
		//$consulta.="eab.comisionVentaEAB,eab.contribucionEAB,eab.ingresoTotalesEAB,eab.costoVentaEAB,eab.contribucionMarginalEAB ";
		$consulta.="eab.ingresoTotalesEAB_fianzas as ingresoTotalesEAB,
			eab.costoVentaEAB_seguros as costoVentaEAB,
			eab.comisionVentaEAB_seguros as comisionVentaEAB,
			eab.contribucionEAB_seguros as contribucionEAB,
			eab.costoVentaEAB_seguros as contribucionMarginalEAB,
			eab.contribucionMarginalEAB_seguros as contribucionMarginalEAB,
			eab.ingresoTotalesEAB_fianzas as ingresoContrario,
			eab.costoVentaEAB_fianzas as costoVentaContrario,
			eab.comisionVentaEAB_fianzas as comisionVentaContrario,
			eab.contribucionEAB_fianzas as contribucion,
			eab.contribucionMarginalEAB_fianzas as contribucionMarginalContrario
		";

		/*$consulta.="eab.ingresoTotalesEAB_seguros,
		eab.costoVentaEAB_seguros,
		eab.comisionVentaEAB_seguros,
		eab.contribucionEAB_seguros,
		eab.costoVentaEAB_seguros, */
	}

	$consulta.="from envioagentesbitacora  eab left join persona on persona.IDVend=eab.IDVendEAB
	left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente
	left join catalog_canales cc on cc.IdCanal=persona.id_catalog_canales
	left join catalog_sucursales cs on cs.IdSucursal=persona.id_catalog_sucursales
	where (mesEAB=".$mes. ") and (anioEAB=".$anio.") "; 
	

	/*if($coordinador=="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){
		$consulta.="(persona.userEmailCreacion='GERENTE@FIANZASCAPITAL.COM' || persona.userEmailCreacion='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM')  and (IDVendEAB!=0) order by idPersona";
	} else{
		$consulta.="(persona.userEmailCreacion='".$coordinador."')  and (IDVendEAB!=0) order by idPersona";
	}*/

	$query=$this->db->query($consulta);

	if($query->num_rows()>0){$respuesta=$query->result();}

	return $respuesta;
}

//----------------------------------------------------------
	public function devolverEstadoFinancieroAgente($array){
		$consulta="select distinct(eab.IDVendEAB),eab.mesEAB,eab.anioEAB,eab.metaComercialEAB,eab.comisionVentaEAB,eab.contribucionEAB,
eab.ingresoTotalesEAB,eab.costoVentaEAB,eab.gastoOperacionEAB,eab.utilidadPerdidaEAB,eab.contribucionMarginalEAB,
persona.apellidoPaterno,persona.nombres,persona.idPersona,personatipoagente.personaTipoAgente,persona.idpersonarankingagente,
cc.nombreTitulo,cs.NombreSucursal
from envioagentesbitacora  eab left join persona on persona.IDVend=eab.IDVendEAB 
left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente
left join catalog_canales cc on cc.IdCanal=persona.id_catalog_canales
left join catalog_sucursales cs on cs.IdSucursal=persona.id_catalog_sucursales
 where  anioEAB=".$array['anio'].' and persona.idPersona='.$array['idPersona'];

		return $this->db->query($consulta)->result();
	}
//----------------------------------------------------------
public function verificarPC($array){
  if(isset($array['mesPC']))
   {$consulta="select * from pagocompania where anioPC=".$array['anioPC']." and mesPC=".$array['mesPC'];}
   else
   {$consulta="select * from pagocompania where anioPC=".$array['anioPC'];}
$consulta=$consulta." order by fechaActualizacionPC desc limit 1";
   return $this->db->query($consulta)->result();
}
//-----------------------------------------------------------------------------------
public function obtenerPromotorias(){
	return $this->db->query("select *,0 as primaNetaPC,0 as comisionGeneradaPC from catalog_promotorias where idPromotoria not in(51,52) order by Promotoria")->result();
}
//----------------------------------------------------------------------------------
public function manejarPagosCompania($array,$accion){
 /*GUARDA LOS PAGOS DE COMPANIA MENSUALMENTE
  $array ES UN ARRAY CON LOS CAMPOS QUE SE VAN A INSERTA O
  $array ES UN STRING DE CONSULTA
  $accion ES LO QUE SE VA A REALIZAR (CONSULTA=Q,ELIMINACION=R O ACTUALIZACION=U,I=INSERCION,QR=CONSULTA CON RESPUEST)
 */
$respuesta="";
  $accion=strtoupper($accion);
   switch($accion){
   	case 'Q':return $this->db->query($array);
   	break;
   	case 'QR':return $this->db->query($array)->result();
   	break;
   	case 'R':
   	break;
   	case 'U':
    break;
   	case 'I':if($this->db->insert('pagocompania',$array)){$repuesta="Actualizacion correcta";}
   	break;
   }
 
 
}
//------------------------------------------------------
function ultimaActualizacionReporteCobranzaClientes($array){
	$datos['ultimaActualizacion']=$this->db->query('select (max(a.fechaActualizacion)) as ultimaActualizacion from actualizacionestablas a
where a.nombreTabla="reportecobranzaclientes"')->result();
	return $datos;
}

//-----------------------------------------------------
function reportecobranzaclientes($array){
$consulta="";
switch ($array['idPersona']) {
	case 1:
          $consulta='select * from reportecobranzaclientes rcc where ramosNombre="fianzas"'.$array['where'];         
          $datos=$this->db->query($consulta)->result_array();
		break;	
	case 224:
		$consulta='select * from reportecobranzaclientes rcc where IDVend=7 and ramosNombre!="fianzas"'.$array['where'];
		$datos=$this->db->query($consulta)->result_array() ;
		 
		$consulta='select p.IDVend,p.id_catalog_sucursales from persona p where p.personaTipoAgente=5 and (p.id_catalog_sucursales=1 || p.id_catalog_sucursales=7)';
		$datosCar=$this->db->query($consulta)->result();		
		foreach ($datosCar as  $value) 
		{
			$consulta='select * from reportecobranzaclientes rcc where IDVend='.$value->IDVend.$array['where'];

			$cobranza=$this->db->query($consulta)->result_array();
			foreach ($cobranza as  $valueCobranza) {array_push($datos, $valueCobranza);}
		
		}	

		$consulta='select p.IDVend,p.id_catalog_sucursales from persona p where p.personaTipoAgente=5 and p.id_catalog_sucursales=2 and p.id_catalog_canales=2';
		$datosCar=$this->db->query($consulta)->result();		
		foreach ($datosCar as  $value) 
		{
			$consulta='select * from reportecobranzaclientes rcc where IDVend='.$value->IDVend.$array['where'];
			$cobranza=$this->db->query($consulta)->result_array();
			foreach ($cobranza as  $valueCobranza) {array_push($datos, $valueCobranza);}
		
		}	

		break;
	case 195:
	$datos=array();
	$consulta='select IDVend from persona p where p.id_catalog_sucursales=2 and p.id_catalog_canales!=2';
	     $datosCancun=$this->db->query($consulta)->result();

	    foreach ($datosCancun as  $value) 
		{
			$consulta='select * from reportecobranzaclientes rcc where IDVend='.$value->IDVend.$array['where'];

			$cobranza=$this->db->query($consulta)->result_array();
			foreach ($cobranza as  $valueCobranza) {array_push($datos, $valueCobranza);}		
		}

	break;
	case 667:
	$datos=array();
       $consulta='select p.IDVend,p.id_catalog_sucursales from persona p where  (p.id_catalog_sucursales=1 || p.id_catalog_sucursales=7) and (p.id_catalog_canales=10 || p.id_catalog_canales=11)';
       $datosCancun=$this->db->query($consulta)->result();
       	     		foreach ($datosCancun as  $value) 
		{
			$consulta='select * from reportecobranzaclientes rcc where IDVend='.$value->IDVend.$array['where'];
			$cobranza=$this->db->query($consulta)->result_array();
		
			foreach ($cobranza as  $valueCobranza) {array_push($datos, $valueCobranza);}		
		}

	break;
	case -1:
          $consulta='select * from reportecobranzaclientes rcc';
          $datos=$this->db->query($consulta)->result_array();
	break;
	default:
              $consulta='select * from reportecobranzaclientes rcc where IDVend=-1';
          $datos=$this->db->query($consulta)->result_array();
	break;
}

	/*$consulta="select rcc.* from persona p
left join reportecobranzaclientes rcc on rcc.IDVend=p.IDVend
where  p.userEmailCreacion=(select u.email from users u where u.idPersona=".$array['idPersona'].")order by rcc.IDVend";
  */

return $datos;

}
//--------------------------------------------------------
 function cobranzaHistorial($array)
 {
	$datos=array();

     if(isset($array['idCobranzaHistorial']))
     {
     	if($array['idCobranzaHistorial']==-1)
      {
     	unset($array['idCobranzaHistorial']);
     	$this->db->insert('cobranzahistorial',$array);
        $datos=$this->db->insert_id();
       return $datos;
      }
     }

   else
   {
    if(isset($array['idRecibo']))
    {   
    	if(isset($array['count']))
       {
    	$consulta='select (count(idCobranzaHistorial)) as total from cobranzahistorial where idRecibo='.$array['idRecibo'];
         
    	$datos=$this->db->query($consulta)->result()[0]->total;
    	return $datos;
       }
       else{
       	$consulta='select c.*,(if(c.envioDestinoCH is null,"",c.envioDestinoCH)) as envioDestino from cobranzahistorial c where c.idRecibo='.$array['idRecibo'];
        $datos=$this->db->query($consulta)->result();
    	return $datos;
       }
    }
   }
 }
//--------------------------------------------------------
function cobranzacomentarios($array)
{
	
  if(isset($array['idCobranzaComentarios']))
  {
     if($array['idCobranzaComentarios']==-1)
     {
       unset($array['idCobranzaComentarios']);
       $array['idPersona']=$this->tank_auth->get_idPersona();
	   $array['emailUser']=$this->tank_auth->get_usermail();	
       $this->db->insert('cobranzacomentarios',$array);
       $last=$this->db->insert_id();
           $insert['estaVisto']=1;
           $insert['idPersona']=$this->tank_auth->get_idPersona();
           $insert['idCobranzaComentarios']=$last;
 
         $this->db->insert('cobranzacomentariorelpersona',$insert);
     }
  }
  else
  {
  }
}
//-----------------------------------------------------------------------------
function cobranzacomentariosPorIDRecibo($idRecibo){
	$consulta="select * from cobranzacomentarios c where c.idRecibo=".$idRecibo.' order by c.fechaCreacionCC desc';

	return $this->db->query($consulta)->result();
}
//-----------------------------------------------------------------------------
function renovacioncomentario($array)
{
	$array['idPersona']=$this->tank_auth->get_idPersona();
	$this->db->insert('renovacioncomentario',$array);
	$last=$this->db->insert_id();
    return  $last;
}
//------------------------------------------------------
function buscarComentariosRenovacion($array,$tabla='')
{
  $documento=explode(',', $array['Documento']);
  $idPersona=$this->tank_auth->get_idPersona();
  $informacion=array();$datoInfo=array();
  foreach ($documento as $value) 
  {
  	$select='select * from renovacioncomentario where Documento="'.$value.'"';
  	$datos=$this->db->query($select)->result();
    foreach ($datos as  $value) 
    {
      $verifica=$this->db->query('select (count(idRenovacionComentario)) as total from renovacioncomentariorelpersona where idRenovacionComentario='.$value->idRenovacionComentario.' and idPersona='.$idPersona)->result();
      if($verifica[0]->total==0)
      {
      $insert='insert into renovacioncomentariorelpersona(idRenovacionComentario,idPersona) VALUES ("'.$value->idRenovacionComentario.'","'.$idPersona.'")';
      $this->db->query($insert);
      }
    }
    
  }
    foreach ($documento as $value) 
  {
    $consulta='select (count(rc.idRenovacionComentario)) as cantComentario,if(rcp.estaVisto is null,1,(sum(if(rcp.estaVisto=0,1,0)))) as nuevo from renovacioncomentario rc left join renovacioncomentariorelpersona rcp on rcp.idRenovacionComentario=rc.idRenovacionComentario where rc.Documento="'.$value.'" and rcp.idPersona='.$idPersona.';' ;
     $info=array();
     $info=$this->db->query($consulta)->result();
     if($info[0]->cantComentario>0)
     {
       $informacion['tieneComentario']=true;
       $informacion['Documento']=$value;
       if($info[0]->nuevo>0){$informacion['comentarioNuevo']=true;}
       else{$informacion['comentarioNuevo']=false;}
       array_push($datoInfo, $informacion);
     }

  }
   
  return $datoInfo;
}
//------------------------------------------------------
function buscarComentariosCobranza($array,$tabla='')
{
  $documento=explode(',', $array['Documento']);
  $idPersona=$this->tank_auth->get_idPersona();
  $informacion=array();$datoInfo=array();
  foreach ($documento as $value) 
  {
  	$select='select * from cobranzacomentarios where idRecibo="'.$value.'"';
  	$datos=$this->db->query($select)->result();
    foreach ($datos as  $value) 
    {
      $verifica=$this->db->query('select (count(idCobranzaComentarios)) as total from cobranzacomentariorelpersona where idCobranzaComentarios='.$value->idCobranzaComentarios.' and idPersona='.$idPersona)->result();
      if($verifica[0]->total==0)
      {
      $insert='insert into cobranzacomentariorelpersona(idCobranzaComentarios,idPersona) VALUES ("'.$value->idCobranzaComentarios.'","'.$idPersona.'")';
      $this->db->query($insert);
      }
    }
     
  }
  foreach ($documento as $value) 
  {
    $consulta='select (count(rc.idCobranzaComentarios)) as cantComentario,if(rcp.estaVisto is null,1,(sum(if(rcp.estaVisto=0,1,0)))) as nuevo from cobranzacomentarios rc left join cobranzacomentariorelpersona rcp on rcp.idCobranzaComentarios=rc.idCobranzaComentarios where rc.idRecibo="'.$value.'" and rcp.idPersona='.$idPersona.';' ;
     $info=array();
     $info=$this->db->query($consulta)->result();
     if($info[0]->cantComentario>0)
     {
       $informacion['tieneComentario']=true;
       $informacion['Documento']=$value;
       if($info[0]->nuevo>0){$informacion['comentarioNuevo']=true;}
       else{$informacion['comentarioNuevo']=false;}
       $informacion['cantidadNuevo']=$info[0]->nuevo;
       $status['idRecibo']=$value;
       $informacion['statusSCS']=$this->obtenerCobranzaSolicitudCobroId_CSC_Recibo_Docto($status)['statusGeneral'];
                 $consulta='select estaResuelta from cobranzasolicitudcobro c where c.IDRecibo='.$value.' limit 1';
                
         $informacion['estaResuelta']='';
          $cobranzaSolicitudCobro=$this->db->query($consulta)->result();
          
          if(count($cobranzaSolicitudCobro)>0){	$informacion['estaResuelta']=$cobranzaSolicitudCobro[0]->estaResuelta;}
      

       array_push($datoInfo, $informacion);
       
     }

  }
  return $datoInfo;
}

//-----------------------------------------------------
function mostrarComentariosRenovacion($Documento)
{
	$datos=array();
	$consulta='select c.*,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.email from renovacioncomentario c 
left join persona p on p.idPersona=c.idPersona
left join users u on u.idPersona=p.idPersona
where c.Documento="'.$Documento.'" order by c.fecha desc';

  $datos=$this->db->query($consulta)->result();
  return $datos;
}
//-----------------------------------------------------
function actualizarComentariosRenovacion($Documento)
{
  $idPersona=$this->tank_auth->get_idPersona();
  $consulta="select * from renovacioncomentario r left join renovacioncomentariorelpersona rc on rc.idRenovacionComentario=r.idRenovacionComentario where r.Documento='".$Documento."' and  rc.estaVisto=0 and rc.idPersona=".$idPersona;
  $actualizar=$this->db->query($consulta)->result();
  
  foreach ($actualizar as  $value) 
  {
    $update['estaVisto']=1;
    $this->db->where('idRenovacionComentario',$value->idRenovacionComentario);	
    $this->db->where('idPersona',$idPersona);
    $this->db->update('renovacioncomentariorelpersona',$update);
  }

}
//-------------------------------------
function renovacionpre($array)
{ $respuesta=array();
  if(isset($array['insert']))
  {
  	unset($array['insert']);
  	$this->db->insert('renovacionpre',$array);
  }
  else
  {
    if(isset($array['delete']))
    {

    }	
    else{    	
    	$consulta='select * from renovacionpre where IDDocto="'.$array['IDDocto'].'"';
    	$respuesta=$this->db->query($consulta)->result();
    	return $respuesta;
    }
  }
}
//-------------------------------------,
function renovacionvigente($ramosFiltro=null)
{
   $filtro='';
   /* $ejecutivoFiltro DEBE SER UN ARRAY*/
  $consulta='select * from renovacionvigente where statusTXT in ("Vigente","No Renovada") and estaLista= 0';
   if($this->tank_auth->get_IDVend()>0){$filtro=' and IDVend='.$this->tank_auth->get_IDVend();}
   else
   {
     if(is_array($ramosFiltro))
     {
     	$in='';
         foreach ($ramosFiltro as  $value) 
         {
           if($value===end($ramosFiltro)){$in.='"'.$value.'"';}
           else{$in.='"'.$value.'",';}	
         }
         if($in!=''){$filtro.=' and (RamosNombre in ('.$in.') or usuarioCreador="'.$this->tank_auth->get_usermail().'")';}
         else{$filtro.=' and (RamosNombre="Ninguno" or usuarioCreador="'.$this->tank_auth->get_usermail().'")';}
     }
   }
   
	$consulta='select * from renovacionvigente where statusTXT in ("Vigente","No Renovada") and estaLista= 0'.$filtro;   
	$info=$this->db->query($consulta)->result();
	return $info;
}
//-----------------------------------
function renovacionPendienteMesAnio()
{
	$informacion=array();
	$consulta='select rp.EjecutNombre,(count(rp.EjecutNombre)) as cantidad, 0 totalRenovadas,0 diferencia from renovacionpendiente rp where MONTH(rp.FHasta) = MONTH(NOW()) AND YEAR(rp.FHasta) = year(NOW()) group by rp.EjecutNombre';
	$informacion=$this->db->query($consulta)->result();

	foreach ($informacion as $key => $value) 
	{
		$consulta='select rp.EjecutNombre,(count(rp.EjecutNombre)) as cantidad from renovacion rp where MONTH(rp.FHasta) = MONTH(NOW()) AND YEAR(rp.FHasta) = year(NOW()) and rp.EjecutNombre="'.$value->EjecutNombre.'"';
       
		$datos=$this->db->query($consulta)->result();
	
        $value->totalRenovadas=$datos[0]->cantidad;
        $value->diferencia=$value->cantidad-$datos[0]->cantidad;
	}
	return $informacion;
}
//----------------------------------
function cobranzasolicitudcobro($array)
{
	$array['idPersona']=$this->tank_auth->get_idPersona();
	$array['emailUser']=$this->tank_auth->get_usermail();	
	 $tipoPermiso='cobranza';
     if($array['estatusCSC']==6){$tipoPermiso='factura';}
     $consulta='select userEmail from cobranza_responsable where tipoPermiso="'.$tipoPermiso.'" limit 1';
     
      $responsable=$this->db->query($consulta)->result()[0]->userEmail;
      $array['usuarioResponsable']=$responsable;

	$this->db->insert('cobranzasolicitudcobro',$array);
	$last=$this->db->insert_id();
	return $last;
}
//----------------------------------
function actualizarcobranzasolicitudcobro($array)
{
 $this->db->where('idCobranzaSolicitudCobro',$array['idCobranzaSolicitudCobro']);
 $this->db->update('cobranzasolicitudcobro',$array);
}
//---------------------------------
function obtenerSolicitudCobroPorIdDocto($idDocto,$idRecibo='')
{
	$filtro="";
	if($idRecibo!=''){$filtro=' and idRecibo='.$idRecibo;}
	$consulta='select (c.idCobranzaSolicitudCobro) as id,(c.comentario) as comentario,c.emailUser,ct.SolicitudCobro,(c.fechaInsercion) as fecha,c.estaResuelta,"cobranzasolicitudcobro" as tabla,"0" as idCobranzaSolicitudCobro
from cobranzasolicitudcobro c
left join cobranzatiposolicitudcobro ct on ct.idTipoSolicitudCobro=c.idTipoSolicitudCobro
where c.idDocto='.$idDocto.$filtro;
    $consulta.=' union select (cc.idCobranzaComentarios) as id,(cc.cobranzaComentarios) as comentario,cc.emailUser,""as SolicitudCobro,(cc.fechaCreacionCC) as fecha,"1" as estaResuelta,"cobranzacomentarios" as tabla,idCobranzaSolicitudCobro  from  cobranzacomentarios cc where cc.idDocto='.$idDocto.$filtro;
  $consulta.=' order by 5 desc';
return $this->db->query($consulta)->result();
}
//----------------------------------
function comprobarSoicitudCobro($IDDocto)
{
	$consulta='select "Cobranza con Solicitud" as descripcion,(count(c.idCobranzaSolicitudCobro)) as bandera,(c.estatusCSC) as estado,(ct.SolicitudCobro) as tipoSolicitud from cobranzasolicitudcobro c
	left join cobranzatiposolicitudcobro ct on ct.idTipoSolicitudCobro=c.idTipoSolicitudCobro
where c.estaResuelta=0 and c.idDocto='.$IDDocto;
    $consulta.=' union
select "Cobranza sin Solicitud" as descripcion,(count(cs.idCobranzaSolicitudCobro)) as bandera,"" as estado,"" as tipoSolicitud  from cobranzasolicitudcobro cs
where cs.estaResuelta=1 and cs.idDocto='.$IDDocto;
    $consulta.=' union select "Comentarios" as descripcion,(count(cc.idCobranzaComentarios)) as bandera,"" as estado,"" as tipoSolicitud  from cobranzacomentarios cc where cc.idDocto='.$IDDocto;

  $respuesta=$this->db->query($consulta)->result();

   return $respuesta; 
}
//----------------------------------
function cambiarStatusSolicitudDeCobro($array)
{
	  $consulta='select * from cobranzasolicitudcobro c where c.estaResuelta=0 and c.idRecibo='.$array['idRecibo'];
	  $respuesta=array();
	  $respuesta['mensaje']='Necesita una solicitud de cobro';
	  $respuesta['succes']=false;
  $bandera=$this->db->query($consulta)->result();
   
  
  if(count($bandera)>0)
  {
  
    if($array['estatusCSC']==$bandera[0]->estatusCSC)
    	{
    		if($array['estatusCSC']==5 || $array['estatusCSC']==6){$respuesta['mensaje']='YA SE ENCUENTRA EN EL AREA DEL EJECUTIVO CORRESPONDIENTE';}
    		else{$respuesta['mensaje']='YA SE ENCUENTRA CON EL AGENTE';}
    	}
    else
    {
	 $tipoPermiso='cobranza';
	 if($bandera->emailUser==$this->tank_auth->get_usermail()){$array['estatusCSC']=$bandera->estatusCSC;}  
     if($array['estatusCSC']==6){$tipoPermiso='factura';}
     $consulta='select userEmail from cobranza_responsable where tipoPermiso="'.$tipoPermiso.'" limit 1';
       $responsable=$this->db->query($consulta)->result()[0]->userEmail;
    	$this->db->query('update cobranzasolicitudcobro set estatusCSC='.$array['estatusCSC'].',usuarioResponsable="'.$responsable.'" where idRecibo='.$array['idRecibo']);
    	$respuesta['succes']=true;
    	$comentarioAutomatico='Paso a estado Agente';
    	if($array['estatusCSC']==5 || $array['estatusCSC']==6){$comentarioAutomatico='Paso a estado ejecutivo';}
    	$insertComentario=array();
    	$insertComentario['idCobranzaComentarios']=-1;
    	$insertComentario['cobranzaComentarios']=$comentarioAutomatico;
    	$insertComentario['idRecibo']=(string)$bandera[0]->idRecibo;
    	$insertComentario['idSerie']=(string)$bandera[0]->idSerie;
    	$insertComentario['idDocto']=(string)$bandera[0]->idDocto;
    	$insertComentario['IDCli']=(int)$bandera[0]->IDCli;
    	$insertComentario['endoso']=(string)$bandera[0]->endoso;
    	$insertComentario['esComentarioAutomatico']=1;
        $this->cobranzacomentarios($insertComentario);


      $email='';
      if($this->tank_auth->get_usermail()==$bandera[0]->usuarioResponsable){$email=$bandera[0]->emailUser;}
      else{$email=$bandera[0]->usuarioResponsable;}
         $comentario='';
         if(isset($array['comentario'])){$comentario='<div>Con el siguiente comentario:'.$array['comentario'].'</div>';}    
         $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
         $guardaMensaje['para']=$email;
         $guardaMensaje['mensaje']='<div>Se detecto un cambio en la Solicitud de cobranza '.$bandera[0]->documento.' serie'.$bandera[0]->idSerie.'</div> '.$comentario;
         $guardaMensaje['asunto']='Cambios en solicitud de cobranza';
         $guardaMensaje['identificaModulo']='reportes_model-cambiarResueltaCSC';            
         $guardaMensaje['tabla']='cobranzasolicitudcobro';
         $guardaMensaje['idTabla']=$bandera[0]->idRecibo;
         $guardaMensaje['campoParaActualizar']='fueEnviado';
         $guardaMensaje['campoLlavePrimaria']='IDRecibo';               
         $this->email_model->enviarCorreo($guardaMensaje);





    	$respuesta['mensaje']='Cambios guardados';
    }
    
  }
  
  return $respuesta;
}
//---------------------------------
function obtenerSolicitudCobroActivos($array=null)
{
	$permisosEmail=array('SISTEMAS@ASESORESCAPITAL.COM','COBRANZA@ASESORESCAPITAL.COM','COORDINADOROPERATIVO@ASESORESCAPITAL.COM');
  $datos=array();
   $filtro='';
   $IDVend=$this->tank_auth->get_IDVend();
    $notInIdRecibos='';
    $estaResuelta='estaResuelta=0';
    if(isset($array['notInIdRecibos'])){if($array['notInIdRecibos']!=''){$notInIdRecibos=' and idRecibo not in ('.$array['notInIdRecibos'].')';}}
    	
   if($IDVend>0){$filtro=' and emailUser="'.$this->tank_auth->get_usermail().'" ';$estaResuelta='estaResuelta<2';}
   	else{
   		 if(!in_array($this->tank_auth->get_usermail(), $permisosEmail)){$filtro=' and (emailUser="'.$this->tank_auth->get_usermail().'" || usuarioResponsable="'.$this->tank_auth->get_usermail().'")';$estaResuelta='estaResuelta<2';}
   		 else
   		 {
   		 	$filtro.=' union select * from cobranzasolicitudcobro where  estaResuelta=1 and emailUser="'.$this->tank_auth->get_usermail().'"';
   		 }
   	}

  $consulta='select * from cobranzasolicitudcobro where  '.$estaResuelta.$filtro.$notInIdRecibos;
     
  $datos=$this->db->query($consulta)->result();
  return $datos;
}
//---------------------------------
function actualizarCobranzaComentariosRelPersona($array)
{
	if(isset($array['idPersona']) && isset($array['idCobranzaComentarios']))
	{
		$this->db->where('idPersona',$array['idPersona']);
		$this->db->where('idCobranzaComentarios',$array['idCobranzaComentarios']);
		$this->db->update('cobranzacomentariorelpersona',$array);
	}
}
//--------------------------------
function obtenerCobranzaSolicitudCobroId_CSC_Recibo_Docto($array)
{
	$respuesta['datos']=array();
	$respuesta['statusGeneral']=0;
	if(isset($array['idRecibo']))
	{
		$consulta='select * from cobranzasolicitudcobro c where idRecibo='.$array['idRecibo'];

        $respuesta['datos']=$this->db->query($consulta)->result();
        if(count($respuesta['datos'])>0){$respuesta['statusGeneral']=$respuesta['datos'][0]->estatusCSC;}
	}

	return $respuesta;
}
//-----------------------------------------------------------
function cambiarResueltaCSC($idRecibo,$status='',$rehabilitar=false,$comentario='')
{
		$statusEtiqueta='';
	switch ($status) 
	{
		case 0:$statusEtiqueta='Rehabilitado';$update['estatusCSC']=5;break;
		case 1:$statusEtiqueta='Listo';break;
		case 2:$statusEtiqueta='Cerrado';break;
				
	}

	if($status!=''){$update['estaResuelta']=$status;}
	else{$update['estaResuelta']=1;}
	$this->db->where('idRecibo',$idRecibo);
	$this->db->update('cobranzasolicitudcobro',$update);

  $this->load->model('email_model');
$infoRecibo=$this->db->query('select * from cobranzasolicitudcobro c where c.IDRecibo='.$idRecibo)->result();
if(count($infoRecibo)>0)
{
     $comentarioGuardar=array();
     $comentarioGuardar['idCobranzaComentarios']=(int)-1;
     $comentarioGuardar['idRecibo']=$idRecibo;
     $comentarioGuardar['idDocto']=$infoRecibo[0]->idDocto;
     $comentarioGuardar['idSerie']=$infoRecibo[0]->idSerie;
     $comentarioGuardar['IDCli']=$infoRecibo[0]->IDCli;
     $comentarioGuardar['endoso']=$infoRecibo[0]->endoso;
     $comentarioGuardar['cobranzaComentarios']='La cobranza se puso en modo '.$statusEtiqueta;
     $this->reportes_model->cobranzacomentarios($comentarioGuardar);
      $email='';
      if($this->tank_auth->get_usermail()==$infoRecibo[0]->usuarioResponsable){$email=$infoRecibo[0]->emailUser;}
      else{$email=$infoRecibo[0]->usuarioResponsable;}
         $comentarioEnviar='';
         if($comentario!='')
         {
           $comentarioEnviar='<div> Con el siguiente comentario: '.$comentario.'</div>';
         }
         $guardaMensaje=array();
         $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
         $guardaMensaje['para']=$email;
         $guardaMensaje['mensaje']='<div>Se detecto un cambio en la Solicitud de cobranza '.$infoRecibo[0]->documento.' serie'.$infoRecibo[0]->idSerie.'</div>'.$comentarioEnviar;
         $guardaMensaje['asunto']='Cambios en solicitud de cobranza';
         $guardaMensaje['identificaModulo']='reportes_model-cambiarResueltaCSC';            
         $guardaMensaje['tabla']='cobranzasolicitudcobro';
         $guardaMensaje['idTabla']=$idRecibo;
         $guardaMensaje['campoParaActualizar']='fueEnviado';
         $guardaMensaje['campoLlavePrimaria']='IDRecibo';               
        $this->email_model->enviarCorreo($guardaMensaje);
   }

	return true;
}

//-----------------------------------------------------------
function enviarCorreoComentario($idRecibo,$comentario)
{
$this->load->model('email_model');
	$infoRecibo=$this->db->query('select * from cobranzasolicitudcobro c where c.IDRecibo='.$idRecibo)->result();
if(count($infoRecibo)>0)
{

      $email='';
      
      if($this->tank_auth->get_usermail()==$infoRecibo[0]->usuarioResponsable){$email=$infoRecibo[0]->emailUser;}
      else{$email=$infoRecibo[0]->usuarioResponsable;}
    
         $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
         $guardaMensaje['para']=$email;
         $guardaMensaje['mensaje']='<div>AL documento '.$infoRecibo[0]->documento.' serie'.$infoRecibo[0]->idSerie.' se le agrego el siguiente comentario</div><div>'.$comentario.'</div>';
         $guardaMensaje['asunto']='Cambios en solicitud de cobranza';
         $guardaMensaje['identificaModulo']='reportes_model-cambiarResueltaCSC';            
         $guardaMensaje['tabla']='cobranzasolicitudcobro';
         $guardaMensaje['idTabla']=$idRecibo;
         $guardaMensaje['campoParaActualizar']='fueEnviado';
         $guardaMensaje['campoLlavePrimaria']='IDRecibo';               
        $this->email_model->enviarCorreo($guardaMensaje);
   }
}

//------------------------------------------------------------------------------------------------------
	//Control de Actividades - Módulo Monitor Operativo | [Suemy][2024-08-12]
	function getActivitiesByMonth($sql) {
		$query = $this->db->query('SELECT (if(act.nombreUsuarioVendedor is null,act.nombreUsuarioCreacion,act.nombreUsuarioVendedor)) AS nombreVendedor, act.IdInterno, act.folioActividad, act.idSicas, act.NumSolicitud, act.Documento, act.Status, act.Status_Txt, act.tipoActividadSicas, act.idCliente, act.nombreCliente, act.tipoActividad, act.ramoActividad, act.subRamoActividad, act.actividadUrgente_Txt, act.usuarioCreacion, act.usuarioVendedor, act.usuarioResponsable, act.usuarioBolita, act.usuarioBloqueo, act.usuarioCotizador, act.nombreUsuarioCreacion, act.nombreUsuarioVendedor, act.nombreUsuarioResponsable, act.nombreUsuarioCotizador, act.fechaCreacion, act.satisfaccion, act.satisfaccionEmision, act.datosExpres, act.tipoEndoso, act.poliza, us.email, us.name_complete FROM actividades act LEFT JOIN users us ON act.usuarioVendedor = us.email WHERE '.$sql.' ORDER BY idInterno ASC');
		return $query->num_rows() > 0 ? $query->result() : array();
	}
//------------------------------------------------------------------------------------------------------

function obtenerMetodosPagos(){
	$this->db->select('metodoPago');
	$this->db->from('cobranzametodopagos');
	$query = $this->db->get();

	$resultado = array_column($query->result_array(), 'metodoPago');
	return $resultado;
}

function guardarDestinatarioAdicional($destinatarios){
	$idpersona = $this->tank_auth->get_idPersona();

	foreach($destinatarios as $dt){
		$esAdicional = ($dt['esAdicional'] == 'true');
		$email = $dt['correo'];
		
		if($esAdicional){
			$this->db->where('idPersona', $idpersona);
			$this->db->where('emailAdicional', $email);
			$query = $this->db->get('rechazo_persona_adicional');

			// Si no existe, insertamos el nuevo registro
			if ($query->num_rows() == 0) {
				$data = array(
					'idPersona' => $idpersona,
					'emailAdicional' => $email
				);
				$this->db->insert('rechazo_persona_adicional', $data);
			}
		}
	}
}

function obtenerPagosAplicados($fechaInicial, $fechaFinal){
	$this->db->select('ca.*, users.email, users.name_complete as name_complete_responsable, csc.idTipoSolicitudCobro, csc.emailUser, csc.usuarioResponsable, user2.name_complete as name_complete_user');
    $this->db->from('cobranza_aplicada as ca');
    $this->db->join('users', 'users.idPersona = ca.idPersonaAplica', 'left');
    $this->db->join('cobranzasolicitudcobro as csc', 'csc.idRecibo = ca.idRecibo', 'left');
	$this->db->join('users as user2', 'user2.email = csc.emailUser', 'left');
    $this->db->where('DATE(ca.fecha) >=', $fechaInicial);
    $this->db->where('DATE(ca.fecha) <=', $fechaFinal);
    $query = $this->db->get();
	return $query->result();
}

function obtenerCSC_SC($idrecibos){
	$this->db->select('idRecibo as IDRecibo, fechaInsercion, emailUser, usuarioResponsable, responsable.name_complete as nombre_responsable, user.name_complete as nombre_usuario');
	$this->db->from('cobranzasolicitudcobro');
	$this->db->join('users as user', 'user.email = cobranzasolicitudcobro.emailUser', 'left');
	$this->db->join('users as responsable', 'responsable.email = cobranzasolicitudcobro.usuarioResponsable', 'left');
	$this->db->where_in('idRecibo', $idrecibos);

	$query = $this->db->get();
	return $query->result();
}

}

?>