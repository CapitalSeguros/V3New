<?php
class cuadromando_model extends CI_Model{
    
    function getProspectos($mes,$year,$EstadoActual,$estaEmitido){
        
        $sql="SELECT idCli from clientes_actualiza where EstadoActual='$EstadoActual' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND estaEmitido='$estaEmitido'";
      return $this->db->query($sql)->result();
    }
    
    function getProspectosKPI($mes,$year,$EstadoActual,$emitido){
        if($emitido==1){
            $sql="SELECT count(idCli) as total from clientes_actualiza where  EstadoActual='$EstadoActual' AND estaEmitido=1 AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'";
        }else{
            $sql="SELECT count(idCli) as total from clientes_actualiza where EstadoActual='$EstadoActual' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'";
        }
          $rs=$this->db->query($sql)->result();
          return $rs[0]->total;
    }
	
	function getCoordinadores(){
	  //Coordinadores con metas comerciales
	   $mes=date('m');$year=date('Y');
	   $sql="SELECT idPersona from registro_meta_mensual_ramo_coordinador_generico where mes_asignado='$mes' AND anio='$year' GROUP BY idPersona";
	   return $this->db->query($sql)->result();
	}

	function getEjecutivoAutos(){
		$sql="SELECT name_complete from users where email='AUTOS@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		return $rs[0]->name_complete;
	}

	function getEjecutivoDanios(){
		$sql="SELECT name_complete from users where email='BIENES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		return $rs[0]->name_complete;
	}

	function getEjecutivoVidas(){
		$sql="SELECT name_complete from users where email='LINEASPERSONALES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		return $rs[0]->name_complete;
	}

	function getAllActividades(){
		$mes=date('m');
	    $year=date('Y');$ct=0;
		$sql="SELECT * from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year'";
		$rs=$this->db->query($sql)->result();
		foreach ($rs as $row) {$ct++;}
		return $ct;
	}

	function getActividadesAutos(){
        $mes=date('m');
        $year=date('Y');$ct=0;

        $sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VEHICULOS' AND tipoActividad='Cotizacion'";
        $rs=$this->db->query($sql)->result();
        $cotizacion=$rs[0]->total;

        $sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VEHICULOS' AND tipoActividad='Cancelacion'";
        $rs=$this->db->query($sql)->result();
        $cancelacion=$rs[0]->total;

        $sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VEHICULOS' AND tipoActividad='Endoso'";
        $rs=$this->db->query($sql)->result();
        $endoso=$rs[0]->total;

        $sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VEHICULOS' AND tipoActividad='Emision'";
        $rs=$this->db->query($sql)->result();
        $emision=$rs[0]->total;

        $ct=$cotizacion+$cancelacion+$endoso+$emision;
        return $ct;
    }

	function getActividadesDanios(){
		$mes=date('m');
	    $year=date('Y');$ct=0;

		$sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='DANOS' AND tipoActividad='Cotizacion' AND usuarioResponsable='BIENES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		$cotizacion=$rs[0]->total;

		$sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='DANOS' AND tipoActividad='Cancelacion' AND usuarioResponsable='BIENES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		$cancelacion=$rs[0]->total;

		$sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='DANOS' AND tipoActividad='Endoso' AND usuarioResponsable='BIENES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		$endoso=$rs[0]->total;

		$sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='DANOS' AND tipoActividad='Emision' AND usuarioResponsable='BIENES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		$emision=$rs[0]->total;
		
		$ct=$cotizacion+$cancelacion+$endoso+$emision;
		return $ct;
	}

	function getActividadesVida(){
		$mes=date('m');
	    $year=date('Y');$ct=0;

		$sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VIDA' AND tipoActividad='Cotizacion' AND usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		$cotizacion=$rs[0]->total;

		$sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VIDA' AND tipoActividad='Cancelacion' AND usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		$cancelacion=$rs[0]->total;

		$sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VIDA' AND tipoActividad='Endoso' AND usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		$endoso=$rs[0]->total;

		$sql="SELECT COUNT(*) as total from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VIDA' AND tipoActividad='Emision' AND usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM'";
		$rs=$this->db->query($sql)->result();
		$emision=$rs[0]->total;
		
		$ct=$cotizacion+$cancelacion+$endoso+$emision;
		return $ct;
	}

	function getAllActividadesAutos($mes,$year){
		$ct=0;
		$sql="SELECT * from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VEHICULOS'";
		return $this->db->query($sql)->result();
	}

	function getAllActividadesDanios($mes,$year){
		$ct=0;
		$sql="SELECT * from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='DANOS' AND usuarioResponsable ='BIENES@ASESORESCAPITAL.COM'";
		return $this->db->query($sql)->result();
	}

	function getAllActividadesVidas($mes,$year){
		$ct=0;
		$sql="SELECT * from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='VIDA' AND usuarioResponsable ='LINEASPERSONALES@ASESORESCAPITAL.COM'";
		return $this->db->query($sql)->result();
	}

	

	function getSemaforo($ramo,$mes,$year){
		$rs="";
		switch ($ramo) {
			case 'AUTOS':
				$rs=$this->getAllActividadesAutos($mes,$year);
				break;
			case 'DANIOS':
				$rs=$this->getAllActividadesDanios($mes,$year);
				break;
			case 'VIDA':
				$rs=$this->getAllActividadesVidas($mes,$year);
				break;
		}
		$ctCotizacionVerde=0;
		$ctCotizacionAmarillo=0;
		$ctCotizacionRojo=0;
		$ctCancelacionVerde=0;
		$ctCancelacionAmarillo=0;
		$ctCancelacionRojo=0;
		$ctEndosoVerde=0;
		$ctEndosoAmarillo=0;
		$ctEndosoRojo=0;
		$ctEmisionVerde=0;
		$ctEmisionAmarillo=0;
		$ctEmisionRojo=0;
		foreach ($rs as $row) {
			if($row->tipoActividad=='Cotizacion'){
				if($row->semaforo=='verde'){
					$ctCotizacionVerde++;
				}
				if($row->semaforo=='amarillo'){
					$ctCotizacionAmarillo++;
				}
				if($row->semaforo=='rojo'){
					$ctCotizacionRojo++;
				}
			}
			if($row->tipoActividad=='Cancelacion'){
				if($row->semaforo=='verde'){
					$ctCancelacionVerde++;
				}
				if($row->semaforo=='amarillo'){
					$ctCancelacionAmarillo++;
				}
				if($row->semaforo=='rojo'){
					$ctCancelacionRojo++;
				}
			}
			if($row->tipoActividad=='Endoso'){
				if($row->semaforo=='verde'){
					$ctEndosoVerde++;
				}
				if($row->semaforo=='amarillo'){
					$ctEndosoAmarillo++;
				}
				if($row->semaforo=='rojo'){
					$ctEndosoRojo++;
				}
			}
			if($row->tipoActividad=='Emision'){
				if($row->semaforo=='verde'){
					$ctEmisionVerde++;
				}
				if($row->semaforo=='amarillo'){
					$ctEmisionAmarillo++;
				}
				if($row->semaforo=='rojo'){
					$ctEmisionRojo++;
				}
			}
			
		}
		$semaforo[0]=$ctCotizacionVerde;
		$semaforo[1]=$ctCotizacionAmarillo;
		$semaforo[2]=$ctCotizacionRojo;

		$semaforo[3]=$ctCancelacionVerde;
		$semaforo[4]=$ctCancelacionAmarillo;
		$semaforo[5]=$ctCancelacionRojo;

		$semaforo[6]=$ctEndosoVerde;
		$semaforo[7]=$ctEndosoAmarillo;
		$semaforo[8]=$ctEndosoRojo;

		$semaforo[9]=$ctEmisionVerde;
		$semaforo[10]=$ctEmisionAmarillo;
		$semaforo[11]=$ctEmisionRojo;

		return $semaforo;
	}


	function getDesgloceActividadesAutos($mes,$year){
		$ctCotizacion=0;$ctCancelacion=0;$cteEndoso=0;$ctEmision=0;$ctSustitucion=0;$ctAppPago=0;$ctAclComision=0;
		$rs=$this->getAllActividadesAutos($mes,$year);
		foreach ($rs as $row) {
			if($row->tipoActividad=='Cotizacion'){
				$ctCotizacion++;
			}
			if($row->tipoActividad=='Cancelacion'){
				$ctCancelacion++;
			}
			if($row->tipoActividad=='Endoso'){
				$cteEndoso++;
			}
			if($row->tipoActividad=='Emision'){
				$ctEmision++;
			}
		}
		$actividades[0]=$ctCotizacion;
		$actividades[1]=$ctCancelacion;
		$actividades[2]=$cteEndoso;
		$actividades[3]=$ctEmision;
		return $actividades;
	}

	function getDesgloceActividadesDanios($mes,$year){
		$ctCotizacion=0;$ctCancelacion=0;$cteEndoso=0;$ctEmision=0;$ctSustitucion=0;$ctAppPago=0;$ctAclComision=0;
		$rs=$this->getAllActividadesDanios($mes,$year);
		foreach ($rs as $row) {
			if($row->tipoActividad=='Cotizacion'){
				$ctCotizacion++;
			}
			if($row->tipoActividad=='Cancelacion'){
				$ctCancelacion++;
			}
			if($row->tipoActividad=='Endoso'){
				$cteEndoso++;
			}
			if($row->tipoActividad=='Emision'){
				$ctEmision++;
			}
			
		}
		$actividades[0]=$ctCotizacion;
		$actividades[1]=$ctCancelacion;
		$actividades[2]=$cteEndoso;
		$actividades[3]=$ctEmision;
		return $actividades;
	}

	function getDesgloceActividadesVidas($mes,$year){
		$ctCotizacion=0;$ctCancelacion=0;$cteEndoso=0;$ctEmision=0;$ctSustitucion=0;$ctAppPago=0;$ctAclComision=0;
		$rs=$this->getAllActividadesVidas($mes,$year);
		foreach ($rs as $row) {
			if($row->tipoActividad=='Cotizacion'){
				$ctCotizacion++;
			}
			if($row->tipoActividad=='Cancelacion'){
				$ctCancelacion++;
			}
			if($row->tipoActividad=='Endoso'){
				$cteEndoso++;
			}
			if($row->tipoActividad=='Emision'){
				$ctEmision++;
			}
			
		}
		$actividades[0]=$ctCotizacion;
		$actividades[1]=$ctCancelacion;
		$actividades[2]=$cteEndoso;
		$actividades[3]=$ctEmision;
		return $actividades;
	}


	function getAllActividadesDetallesSubramo($ramo,$tipo){
		$mes=date('m');
	    $year=date('Y');
		$sql="SELECT * from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='$ramo' AND tipoActividad='$tipo'";
		return $this->db->query($sql)->result();
	}

	function getAllActividadesAnioPasado($ramo,$tipo){
		$mes=1;
	    $year=date('Y')-1;
		$sql="SELECT * from actividades where MONTH(fechaActualizacion)='$mes' AND  YEAR(fechaActualizacion)='$year' AND ramoActividad='$ramo' AND tipoActividad='$tipo'";
		return $this->db->query($sql)->result();
	}
	
	function getAllMetasComerciales($id){
		 $this->load->model("personamodelo");
		 $this->load->model("metacomercial_modelo");
		 $meta_comercial_anual=$this->personamodelo->obtenerMetaComercialAnual($id);//Id del coordinador;
		 $meta_comercial_mensual=$this->metacomercial_modelo->obtenerMetaMensualCoor($meta_comercial_anual->idMetaComercial,date('m'));
		 return $meta_comercial_mensual;
	}

	function detalle_reporte_prospectos_anual($mes,$year,$estado,$tipo){
	    $sql="SELECT  COUNT(*) as total from clientes_actualiza where EstadoActual='$estado' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto='$tipo'";
	    $rs=$this->db->query($sql)->result();
	    return $rs[0]->total;
	}

	function promedio_atencion_actividades($ramo){
	 	$rs='';
	 	$mes=date('m');$year=date('Y');
	 	$Pdiario=0;
	 	$Psemanal=0;
	 	switch ($ramo) {
	 		case 'AUTOS':
	 			$rs=$this->getActividadesAutos();
	 			$Pdiario=round($rs/8);
	 			$Psemanal=round($rs/5);
	 			break;
	 		case 'DANIOS':
	 			$rs=$this->getActividadesDanios();
	 			$Pdiario=round($rs/8);
	 			$Psemanal=round($rs/5);
	 			break;
	 		case 'VIDA':
	 			$rs=$this->getActividadesVida();
	 			$Pdiario=round($rs/8);
	 			$Psemanal=round($rs/5);
	 			break;
	 	}
	 	$promedios[0]=$Pdiario;
	 	$promedios[1]=$Psemanal;
	 	return $promedios;
	}

	function getRenovaciones(){
		 $mes=date('m');$year=date('Y');
		 $dias=0;
		 $ctmasunoAutos=0;$ctmasveinteAutos=0;$ctmenosunoAutos=0;
		 $ctmasunoVida=0;$ctmasveinteVida=0;$ctmenosunoVida=0;
		 $ctmasunoDanio=0;$ctmasveinteDanio=0;$ctmenosunoDanio=0;
		 $autos_rojos = array();
		 //Autos
		 $sqlAutos="SELECT * from renovacion where  MONTH(fechaInsersion)='$mes' AND YEAR(fechaInsersion)='$year' AND EjecutNombre='AUTOS INDIVIDUALES'";
	     $renovacionesAutos=$this->db->query($sqlAutos)->result();
	     foreach ($renovacionesAutos as $row) {
	    	$fechaInsersion=strtotime($row->fechaInsersion);
	    	$FHasta=strtotime($row->FHasta);
	    	$dias=floor(($FHasta-$fechaInsersion)/86400);
	    	//verde
	    	if($dias>=20){
	    		$ctmasveinteAutos++;

	    	}
	    	//amarillo
	    	if(($dias>=0)&&($dias<20)){
	    		$ctmasunoAutos++;
	    	}
	    	//rojo
	    	if($dias<0){
	    		$ctmenosunoAutos++;
	    		array_push($autos_rojos,$row->IDDocto);
	    	}
	    }

	    //Lineas Pesonales(Vida)
		 $sqlVida="SELECT * from renovacion where  MONTH(fechaInsersion)='$mes' AND YEAR(fechaInsersion)='$year' AND EjecutNombre='LINEAS PERSONALES'";
	     $renovacionesVida=$this->db->query($sqlVida)->result();
	     foreach ($renovacionesVida as $row) {
	    	$fechaInsersion=strtotime($row->fechaInsersion);
	    	$FHasta=strtotime($row->FHasta);
	    	$dias=floor(($FHasta-$fechaInsersion)/86400);
	    	//verde
	    	if($dias>=20){
	    		$ctmasveinteVida++;
	    	}
	    	//amarillo
	    	if(($dias>=0)&&($dias<20)){
	    		$ctmasunoVida++;
	    	}
	    	//rojo
	    	if($dias<0){
	    		$ctmenosunoVida++;
	    	}
	    }

	    //Daños
		 $sqlDanio="SELECT * from renovacion where  MONTH(fechaInsersion)='$mes' AND YEAR(fechaInsersion)='$year' AND EjecutNombre='DAÑOS'";
	     $renovacionesDanio=$this->db->query($sqlDanio)->result();
	     foreach ($renovacionesDanio as $row) {
	    	/* $fechaInsersion=date("d-m-Y",strtotime($row->fechaInsersion));
	    	$FHasta=date("d-m-Y",strtotime($row->FHasta));
	    	$dias=floor(($FHasta-$fechaInsersion)/86400); */
			$timestampInsersion = strtotime($fechaInsersion);
			$timestampHasta = strtotime($FHasta);
	    	$dias=floor(($timestampHasta-$timestampInsersion)/86400);
	    	//verde
	    	if($dias>=20){
	    		$ctmasveinteDanio++;
	    	}
	    	//amarillo
	    	if(($dias>=0)&&($dias<20)){
	    		$ctmasunoDanio++;
	    	}
	    	//rojo
	    	if($dias<0){
	    		$ctmenosunoDanio++;
	    	}
	    }

	    $renovaciones[0]=$ctmasveinteAutos;
	 	$renovaciones[1]=$ctmasunoAutos;
	 	$renovaciones[2]=$ctmenosunoAutos;

	 	$renovaciones[3]=$ctmasveinteVida;
	 	$renovaciones[4]=$ctmasunoVida;
	 	$renovaciones[5]=$ctmenosunoVida;

		$renovaciones[6]=$ctmasveinteDanio;
	 	$renovaciones[7]=$ctmasunoDanio;
	 	$renovaciones[8]=$ctmenosunoDanio;

	 	return $renovaciones;
	}

	
    
    //[Ultima modificacion]
    //Semaforo de renovaciones Pendientes por renovar


        function verificarYaRenovada($IDDocto){
            $mes=date('m');$year=date('Y');
            $sql="SELECT * from renovacion where  MONTH(fechaInsersion)='$mes' AND YEAR(fechaInsersion)='$year' AND IDDocto='IDDocto'";
            $rs=$this->db->query($sql)->result();
            return $rs;
        }
    
        function diaFinalMes($mes){
            switch ($mes) {
                case '01':return '31';break;
                case '02':return '28';break;
                case '03':return '31';break;
                case '04':return '30';break;
                case '05':return '31';break;
                case '06':return '30';break;
                case '07':return '30';break;
                case '08':return '31';break;
                case '09':return '30';break;
                case '10':return '29';break;
                case '11':return '30';break;
                case '12':return '31';break;
            }
        }
        function renovacionesPendientes($mes){
            $this->mes=$mes;
            $diaFinalMes=$this->diaFinalMes($this->mes);
            $year=date('Y');
            $fechaI='01/'.$this->mes.'/'.$year;
            $fechaF=$diaFinalMes.'/'.$this->mes.'/'.$year;
            $vendedor=$this->tank_auth->get_IDVend();
            $this->load->library('ws_sicas');
            return $this->ws_sicas->obtenerRenovacionesFecha($vendedor,$fechaI,$fechaF,null,'0');
        }
            

        function getRenovacionesPendientes($mes){
             $FActual=date('d/m/Y');
             $dias=0;
             $ctmasunoAutos=0;$ctmasveinteAutos=0;$ctmenosunoAutos=0;
             $ctmasunoVida=0;$ctmasveinteVida=0;$ctmenosunoVida=0;
             $ctmasunoDanio=0;$ctmasveinteDanio=0;$ctmenosunoDanio=0;
			 $ctmasunoAYE=0;$ctmasveinteAYE=0;$ctmenosunoAYE=0;
             $Renovaciones=$this->renovacionesPendientes($mes);
             //autos
             foreach ($Renovaciones as $row) {
                if(!$this->verificarYaRenovada($row->IDDocto)){
                    if($row->RamosNombre=="Vehiculos"){
						//---------------------
						$date1 = new DateTime(date("Y-m-d", strtotime($row->FHasta)));
						$date2 = new DateTime(date("Y-m-d"));
						$interval = $date2->diff($date1);
						$dias = (Int)$interval->format("%R%a");
						//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(array("aa" =>$row->Documento, "bb" => $interval), TRUE));fclose($fp);
						//---------------------
                        $FActual=strtotime($FActual);
                        $FHasta=strtotime($row->FHasta);
                        $dias_=floor(($FActual-$FHasta)/86400);
                        //verde
                        if($dias>=20){
                            $ctmasveinteAutos++;
                        }
                        //amarillo
                        if(($dias>=0)&&($dias<20)){
                            $ctmasunoAutos++;
                        }
                        //rojo
                        if($dias<0){
                            $ctmenosunoAutos++;
                        }
                    }
                }
            }

            //Lineas Pesonales(Vida)
            foreach ($Renovaciones as $row) {
                if(!$this->verificarYaRenovada($row->IDDocto)){
                    if($row->RamosNombre=="Vida"){
						//---------------------
						$date1 = new DateTime(date("Y-m-d", strtotime($row->FHasta)));
						$date2 = new DateTime(date("Y-m-d"));
						$interval = $date2->diff($date1);
						$dias = (Int)$interval->format("%R%a");
						//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(array("aa" =>$row->Documento, "bb" => $interval), TRUE));fclose($fp);
						//---------------------
                        $FActual=strtotime($FActual);
                        $FHasta=strtotime($row->FHasta);
                        $dias_=floor(($FActual-$FHasta)/86400);
                        //verde
                        if($dias>=20){
                            $ctmasveinteVida++;
                        }
                        //amarillo
                        if(($dias>=0)&&($dias<20)){
                            $ctmasunoVida++;
                        }
                        //rojo
                        if($dias<0){
                            $ctmenosunoVida++;
                            
                        }
                    }
                }
            }
 			//Lineas Pesonales(Accidentes y enfermedades)
			foreach ($Renovaciones as $row) {
                if(!$this->verificarYaRenovada($row->IDDocto)){
                    if($row->RamosNombre=="Accidentes y Enfermedades"){
						//---------------------
						$date1 = new DateTime(date("Y-m-d", strtotime($row->FHasta)));
						$date2 = new DateTime(date("Y-m-d"));
						$interval = $date2->diff($date1);
						$dias = (Int)$interval->format("%R%a");
						//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(array("aa" =>$row->Documento, "bb" => $interval), TRUE));fclose($fp);
						//---------------------
                        $FActual=strtotime($FActual);
                        $FHasta=strtotime($row->FHasta);
                        $dias_=floor(($FActual-$FHasta)/86400);
                        //verde
                        if($dias>=20){
                            $ctmasveinteAYE++;
                        }
                        //amarillo
                        if(($dias>=0)&&($dias<20)){
                            $ctmasunoAYE++;
                        }
                        //rojo
                        if($dias<0){
                            $ctmenosunoAYE++;
                            
                        }
                    }
                }
            }

            //Daños
             foreach ($Renovaciones as $row) {
                if(!$this->verificarYaRenovada($row->IDDocto)){
                    if($row->RamosNombre=="Daños"){
						//---------------------
						$date1 = new DateTime(date("Y-m-d", strtotime($row->FHasta)));
						$date2 = new DateTime(date("Y-m-d"));
						$interval = $date2->diff($date1);
						$dias = (Int)$interval->format("%R%a");
						//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(array("aa" =>$row->Documento, "bb" => $interval), TRUE));fclose($fp);
						//---------------------
                        $FActual=strtotime($FActual);
                        $FHasta=strtotime($row->FHasta);
                        $dias_=floor(($FActual-$FHasta)/86400);
                        //verde
                        if($dias>=20){
                            $ctmasveinteDanio++;
                        }
                        //amarillo
                        if(($dias>=0)&&($dias<20)){
                            $ctmasunoDanio++;
                        }
                        //rojo
                        if($dias<0){
                            $ctmenosunoDanio++;
                            
                        }
                    }
                }
            }

            $renovacionesPendientes[0]=$ctmasveinteAutos;
            $renovacionesPendientes[1]=$ctmasunoAutos;
            $renovacionesPendientes[2]=$ctmenosunoAutos;

            $renovacionesPendientes[3]=$ctmasveinteVida;
            $renovacionesPendientes[4]=$ctmasunoVida;
            $renovacionesPendientes[5]=$ctmenosunoVida;

            $renovacionesPendientes[6]=$ctmasveinteDanio;
            $renovacionesPendientes[7]=$ctmasunoDanio;
            $renovacionesPendientes[8]=$ctmenosunoDanio;

			$renovacionesPendientes[9]=$ctmasveinteAYE;
            $renovacionesPendientes[10]=$ctmasunoAYE;
            $renovacionesPendientes[11]=$ctmenosunoAYE;

            return $renovacionesPendientes;
        }
    
    function promedio_atencion_despacho($desapacho){
        return 0;
    }

    //Modified April 20 2021
    function getRenovacionesPendientesDespacho(){
             $FActual=date('d/m/Y');
             $dias=0;
             $ctmasveinteMerida=0;$ctmasunoMerida=0;$ctmenosunoMerida=0;
             $ctmasveinteCancun=0;$ctmasunoCancun=0;$ctmenosunoCancun=0;
             $ctmasveinteInstitucional=0;$ctmasunoInstitucional=0;$ctmenosunoInstitucional=0;
             $mes=date('m');
             $Renovaciones=$this->renovacionesPendientes($mes);
             //MERIDA
             foreach ($Renovaciones as $row) {
                if($row->DespNombre=="MERIDA"){
                    $FActual=strtotime($FActual);
                    $FHasta=strtotime($row->FHasta);
                    $dias=floor(($FActual-$FHasta)/86400);
                    //verde
                    if($dias>=20){
                        $ctmasveinteMerida++;
                    }
                    //amarillo
                    if(($dias>=0)&&($dias<20)){
                        $ctmasunoMerida++;
                    }
                    //rojo
                    if($dias<0){
                        $ctmenosunoMerida++;
                    }
                }
            }

           //CANCUN
             foreach ($Renovaciones as $row) {
                if($row->DespNombre=="CANCUN"){
                    $FActual=strtotime($FActual);
                    $FHasta=strtotime($row->FHasta);
                    $dias=floor(($FActual-$FHasta)/86400);
                    //verde
                    if($dias>=20){
                        $ctmasveinteCancun++;
                    }
                    //amarillo
                    if(($dias>=0)&&($dias<20)){
                        $ctmasveinteCancun++;
                    }
                    //rojo
                    if($dias<0){
                        $ctmenosunoCancun++;
                    }
                }
            }

            //INSTITUCIONAL
             foreach ($Renovaciones as $row) {
                if($row->GerenciaNombre=="INSTITUCIONAL"){
                    $FActual=strtotime($FActual);
                    $FHasta=strtotime($row->FHasta);
                    $dias=floor(($FActual-$FHasta)/86400);
                    //verde
                    if($dias>=20){
                        $ctmasveinteInstitucional++;
                    }
                    //amarillo
                    if(($dias>=0)&&($dias<20)){
                        $ctmasunoInstitucional++;
                    }
                    //rojo
                    if($dias<0){
                        $ctmenosunoInstitucional++;
                    }
                }
            }

            $renovacionesPendientesDespacho[0]=$ctmasveinteMerida;
            $renovacionesPendientesDespacho[1]=$ctmasunoMerida;
            $renovacionesPendientesDespacho[2]=$ctmenosunoMerida;

            $renovacionesPendientesDespacho[3]=$ctmasveinteCancun;
            $renovacionesPendientesDespacho[4]=$ctmasunoCancun;
            $renovacionesPendientesDespacho[5]=$ctmenosunoCancun;

            $renovacionesPendientesDespacho[6]=$ctmasveinteInstitucional;
            $renovacionesPendientesDespacho[7]=$ctmasunoInstitucional;
            $renovacionesPendientesDespacho[8]=$ctmenosunoInstitucional;

            return $renovacionesPendientesDespacho;
        }

        function getCobranza_kpi(){
            $sql="SELECT * from avance_cobranza_kpi ORDER BY id_avance_cobranza ASC ";
            return $this->db->query($sql)->result();
        }

        function getCobranza_sucursal($reporte){
            $sql="SELECT * from avance_cobranza_kpi_por_reporte WHERE reporte='$reporte'";
            $rs=$this->db->query($sql)->result();
            return $rs[0];
        }

        //Modificacion 28-abril
        //setRenovacionesRojos, getRenovacionesRojo OJO
        function setRenovacionesRenovadas($ramo,$mes){
             $year=date('Y');
             $dias=0;
             $verdes = array();
             $amarillos = array();
             $rojos = array();
             $data=array();
             $sql="SELECT * from renovacion where MONTH(fechaInsersion)='$mes' AND YEAR(fechaInsersion)='$year' AND EjecutNombre='$ramo' ORDER BY FDesde DESC";
             $renovaciones=$this->db->query($sql)->result();
             
             foreach ($renovaciones as $row) {
                $fechaInsersion=strtotime($row->fechaInsersion);
                $FHasta=strtotime($row->FHasta);
                $dias=floor(($FHasta-$fechaInsersion)/86400);
                if($dias<0){
                    array_push($rojos,$row->IDDocto);
                }
                if(($dias>-1)&&($dias<20)){
                    array_push($amarillos,$row->IDDocto);
                }
                if($dias>=20){
                    array_push($verdes,$row->IDDocto);
                }
            }
            $data[0]=$verdes;
            $data[1]=$amarillos;
            $data[2]=$rojos;

            return $data;
        }



        function setRenovacionesRenovadasVida($ramo,$mes){
             $year=date('Y');
             $dias=0;
             $verdesVida = array();
             $amarillosVida = array();
             $rojosVida = array();
             $verdesAccEnf = array();
             $amarillosAccEnf = array();
             $rojosAccEnf = array();
             $data=array();
             $sql="SELECT renovacion.*,renovacionlineaspersonales.RamosNombre from renovacion,renovacionlineaspersonales where  MONTH(renovacion.fechaInsersion)='$mes' AND YEAR(renovacion.fechaInsersion)='$year' AND renovacion.EjecutNombre='$ramo' AND renovacionlineaspersonales.IDDocto=renovacion.IDDocto ORDER BY renovacion.FDesde DESC";
             $renovaciones=$this->db->query($sql)->result();
             foreach ($renovaciones as $row) {
                $fechaInsersion=strtotime($row->fechaInsersion);
                $FHasta=strtotime($row->FHasta);
                $dias=floor(($FHasta-$fechaInsersion)/86400);
                if($row->RamosNombre=="Vida"){
                    if($dias<0){
                        array_push($rojosVida,$row->IDDocto);
                    }
                    if(($dias>-1)&&($dias<20)){
                        array_push($amarillosVida,$row->IDDocto);
                    }
                    if($dias>=20){
                        array_push($verdesVida,$row->IDDocto);
                    }
                }else{
                    if($dias<0){
                        array_push($rojosAccEnf,$row->IDDocto);
                    }
                    if(($dias>-1)&&($dias<20)){
                        array_push($amarillosAccEnf,$row->IDDocto);
                    }
                    if($dias>=20){
                        array_push($verdesAccEnf,$row->IDDocto);
                    }
                }
             }
            
            $data[0]=$verdesVida;
            $data[1]=$amarillosVida;
            $data[2]=$rojosVida;

            $data[3]=$verdesAccEnf;
            $data[4]=$amarillosAccEnf;
            $data[5]=$rojosAccEnf;

            return $data;
        }

       function getRenovacionesRenovadasTotal($ramo,$mes){
             $year=date('Y');
             $sql="SELECT COUNT(*) as total from renovacion where MONTH(fechaInsersion)='$mes' AND YEAR(fechaInsersion)='$year' AND EjecutNombre='$ramo' ORDER BY FDesde DESC";
             $rs=$this->db->query($sql)->result();
             return $rs[0]->total;
        }

        function getRenovacionesRenovadasTotalLineasPersonales($op,$mes){
            $year=date('Y');
            $sql="SELECT COUNT(*) as total from renovacion,renovacionlineaspersonales where MONTH(renovacion.fechaInsersion)='$mes' AND YEAR(renovacion.fechaInsersion)='$year' AND renovacion.EjecutNombre='LINEAS PERSONALES' AND renovacionlineaspersonales.RamosNombre='$op' AND renovacionlineaspersonales.IDDocto=renovacion.IDDocto ORDER BY renovacion.FDesde DESC";
             $rs=$this->db->query($sql)->result();
             return $rs[0]->total;
        }


        function getRenovacionRenovada($IDDocto){
             $sqlAutos="SELECT renovacion.*,catalog_vendedores.NombreCompleto from renovacion,catalog_vendedores where catalog_vendedores.IDVend=renovacion.IDVend AND renovacion.IDDocto='$IDDocto'";
             $rs=$this->db->query($sqlAutos)->result();
             return $rs[0];
        }

        //Modificaciones MJ 06/12/2021 con referente a valor de fastfile

	function getAllFastFile($tabla,$mes,$year){
		$rs="";
		if($tabla=='vacaciones'){
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE  MONTH(fecha_salida)='$mes' AND YEAR(fecha_salida)='$year' AND aprobado='1' ORDER BY fecha_salida";
		 	$rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='prestamos'){
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE  MONTH(fecha)='$mes' AND YEAR(fecha)='$year' AND aprobado='1' ORDER BY fecha";
		 	$rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='permiso'){
	    	$tabla='incidencias';
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE  MONTH(fecha_alta)='$mes' AND YEAR(fecha_alta)='$year' AND estatus='AUTORIZADO' AND tipo_incidencias_id='10' ORDER BY fecha_alta";
			 $rs=$this->db->query($sql)->result();
	    }

	     if($tabla=='incapacidad'){
	     	$tabla='incidencias';
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE  MONTH(fecha_alta)='$mes' AND YEAR(fecha_alta)='$year' AND estatus='AUTORIZADO' AND tipo_incidencias_id='9' ORDER BY fecha_alta";
			 $rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='fastfile'){
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE  MONTH(fecha)='$mes' AND YEAR(fecha)='$year' AND descripcion='puntualidad' AND valor_ant=1 ORDER BY fecha";
			 $rs=$this->db->query($sql)->result();
	    }
	     if($tabla=='fastfile_cambio_puesto'){
			$sql="SELECT COUNT(*) AS TOTAL FROM fastfile WHERE  MONTH(fecha)='$mes' AND YEAR(fecha)='$year' AND descripcion='cambio puesto' AND valor_ant!='' ORDER BY fecha";
			 $rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='solicitud_sueldo'){
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE  MONTH(fecha)='$mes' AND YEAR(fecha)='$year' AND estatus='AUTORIZADO' ORDER BY fecha";
			 $rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='calificacion'){
	    	 $sql="SELECT COUNT(*) AS TOTAL FROM evaluacion_periodo_empleado AS E WHERE MONTH(E.fecha_aplicacion)='$mes' AND YEAR(E.fecha_aplicacion)='$year'";
            $rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='capacitacion'){
	    	 $this->load->model('personamodelo');
        	 $rs=$this->personamodelo->resumenGeneral();
	    }
	    return $rs;
	}

	function getAllFastFileAsistencia($mes,$year){
		$sql="SELECT COUNT(*) AS TOTAL FROM fastfile WHERE  MONTH(fecha)='$mes' AND YEAR(fecha)='$year' AND descripcion='asistencia' AND valor=1 ORDER BY fecha";
		return $this->db->query($sql)->result();
	    
	}

	//Modificaciones MJ 06/12/2021 con referente a valor de fastfile

	function getAllFastFileMensual($tabla,$mes,$year){
		$fechaInicio=$year.'-01-01';
		$fechaActual=$year."-".$mes."-".date('d');
		$rs="";
		if($tabla=='vacaciones'){
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE  fecha_salida BETWEEN '$fechaInicio' AND '$fechaActual' AND aprobado='1' ORDER BY fecha_salida";
		 	$rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='prestamos'){
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE fecha BETWEEN '$fechaInicio' AND '$fechaActual' AND aprobado='1' ORDER BY fecha";
		 	$rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='permiso'){
	    	$tabla='incidencias';
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE fecha_alta BETWEEN '$fechaInicio' AND '$fechaActual' AND estatus='AUTORIZADO' AND tipo_incidencias_id='10' ORDER BY fecha_alta";
			 $rs=$this->db->query($sql)->result();
	    }

	    if($tabla=='incapacidad'){
	    	$tabla='incidencias';
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE fecha_alta BETWEEN '$fechaInicio' AND '$fechaActual' AND estatus='AUTORIZADO' AND tipo_incidencias_id='9' ORDER BY fecha_alta";
			 $rs=$this->db->query($sql)->result();
	    }

	    if($tabla=='fastfile'){
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaActual' AND descripcion='puntualidad' AND valor_ant=1 ORDER BY fecha";
			 $rs=$this->db->query($sql)->result();
	    }
	     if($tabla=='fastfile_cambio_puesto'){
			$sql="SELECT COUNT(*) AS TOTAL FROM fastfile WHERE fecha BETWEEN '$fechaInicio' AND '$fechaActual' AND valor_ant!='' ORDER BY fecha";
			 $rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='solicitud_sueldo'){
			$sql="SELECT COUNT(*) AS TOTAL FROM ".$tabla." WHERE fecha BETWEEN '$fechaInicio' AND '$fechaActual' AND estatus='AUTORIZADO' ORDER BY fecha";
			 $rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='calificacion'){
	    	 $sql="SELECT COUNT(*) AS TOTAL FROM evaluacion_periodo_empleado AS E WHERE E.fecha_aplicacion BETWEEN '$fechaInicio' AND '$fechaActual'";
            $rs=$this->db->query($sql)->result();
	    }
	    if($tabla=='capacitacion'){
	    	 $this->load->model('personamodelo');
        	 $rs=$this->personamodelo->resumenGeneral();
	    }
	    return $rs;
	}

	function getBajasGlobal($year,$area){
	   $data=0;	
	   $sqlBaja="SELECT COUNT(*) as totalBaja FROM persona  AS p, list_of_users_to_delete AS l WHERE YEAR(l.deleteDate)='$year' AND p.idColaboradorArea='$area' AND p.idPersona=l.idPersona";
	 	$rsBaja=$this->db->query($sqlBaja)->result();
	    if($rsBaja){
	    	$data=$rsBaja[0]->totalBaja;
	    }
	    return $data;
	}
	
	function getBajas($mes,$year,$area){
	   $data=0;	
	   $sqlBaja="SELECT COUNT(*) as totalBaja FROM persona  AS p, list_of_users_to_delete AS l WHERE MONTH(l.deleteDate)='$mes' AND YEAR(l.deleteDate)='$year' AND p.idColaboradorArea='$area' AND p.idPersona=l.idPersona";
	 	$rsBaja=$this->db->query($sqlBaja)->result();
	    if($rsBaja){
	    	$data=$rsBaja[0]->totalBaja;
	    }
	    return $data;
	}

	function getActivoByArea($area){
	   $data=0;	
	   //$sqlBaja="SELECT COUNT(*) AS totalBaja FROM persona a LEFT JOIN users b on a.idPersona = b.idPersona WHERE MONTH(a.fecha_baja)='$mes' AND YEAR(a.fecha_baja)='$year' AND a.bajapersona = 1 AND b.banned = 1 AND b.activated = 0 AND a.idColaboradorArea='$area'";
	   
	   $sql="SELECT COUNT(*) AS total FROM persona a LEFT JOIN users b on a.idPersona = b.idPersona WHERE  a.bajapersona = 0 AND b.banned = 0 AND b.activated = 1 AND a.idColaboradorArea='$area'";

	 	$rs=$this->db->query($sql)->result();
	    if($rs){
	    	$data=$rs[0]->total;
	    }
	    return $data;
	}




	

	

	//-------------------------- //Dennis Castillo
	function getRenewedRenewals(){

		//$this->db->where("Renovacion >",0);
		$query = $this->db->get("renovaciones_ya_renovadas");

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//-------------------------- //Dennis Castillo [2022-03-24]
	function getPendingRenovation(){
		$query = $this->db->get("renovaciones_pendientes_kpi");

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//-------------------------- //Dennis Castillo [2022-03-24]
	function getPendingRenovationsDays(){

		$this->db->select("TIMESTAMPDIFF(DAY, NOW(), FHasta) as Days, RamosNombre,  GerenciaNombre", false);
		$this->db->from("renovaciones_pendientes_kpi");
		$query = $this->db->get();

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//--------------------------

    //[fin modificacion]
//-------------------------------------------
function getSemaforoActividades($array=null)
{
  $mes=date('m');
  $year=date('Y');
  $ct=0;
  $semaforo='ROJO';
  //$array['responsable']='BIENES@ASESORESCAPITAL.COM';
  $responsableFiltro='';
  $datos=array();
  if(isset($array['mes'])){$mes=$array['mes'];}
  if(isset($array['anio'])){$anio=$array['anio'];}
  if(isset($array['semaforo'])){$semaforo=$array['semaforo'];}
  if(isset($array['responsable'])){$responsableFiltro=' and a.usuarioResponsable="'.$array['responsable'].'"';}

        $sql='select ar.*,a.ramoActividad,a.subRamoActividad,a.usuarioResponsable, a.tipoActividad from actividadesenrojo ar left join actividades a on a.idInterno=ar.idInterno where ar.statusActividad="'.$semaforo.'" and  month(a.fechaActualizacion)='.$mes.' and year(a.fechaActualizacion)='.$year.' '.$responsableFiltro.' group by ar.idInterno ';

        $datos['semaforoActividades']=$this->db->query($sql)->result();
       $datos['promotoriasConSemaforos']=array();
       $totalActividadesSemaforoRojo=0;
       $totalPromotorias=0;
       foreach ($datos['semaforoActividades'] as  $value) 
       {
       	  $sql='select c.Promotoria,ra.* from relactividadpromotoria ra left join catalog_promotorias c on c.idPromotoria=ra.idPromotoria where ra.folioActividad="'.$value->folioActividad.'"';
       	  $promtorias=$this->db->query($sql)->result();
       	  foreach ($promtorias as  $valueProm) 
       	  {
       	    if(!isset($datos['promotoriasConSemaforos'][$valueProm->Promotoria])){$datos['promotoriasConSemaforos'][$valueProm->Promotoria]=0;}    
       	    else{$datos['promotoriasConSemaforos'][$valueProm->Promotoria]++;}
       	    $totalPromotorias++;
       	  }     	
       	  $totalActividadesSemaforoRojo++;

       }
       arsort($datos['promotoriasConSemaforos']);
      // $datos['totalActividades']=$totalActividadesSemaforoRojo;
      // $datos['totalPromooritas']=$totalPromotorias;
        
   return $datos;
}
//-------------------------------
function obtenerSemaforoVerdeDeActividades($array){

	$response = array();
	$this->db->select("a.ramoActividad, a.subRamoActividad, a.usuarioResponsable, a.tipoActividad, a.semaforo as statusActividad");

	if(isset($array["responsable"])){

		$this->db->where("a.usuarioResponsable", $array["responsable"]);
	}

	$this->db->where("MONTH(a.fechaActualizacion)", isset($array["mes"]) ? $array["mes"] : date("n"));
	$this->db->where("YEAR(a.fechaActualizacion)", isset($array["anio"]) ? $array["anio"] : date("Y"));
	$this->db->where("a.semaforo", "verde");
	$query = $this->db->get("actividades a");

	$response["semaforoActividades"] = $query->num_rows() > 0 ? $query->result() : array();

	return $response;
}
//-------------------------------
function getInfoEmisionActividades($array=null)
{
   $month=date('m');
   $year=date('Y');
   $informacion=array();
   $consulta='select a.tarjetaTipoPago,(count(a.tarjetaTipoPago)) as total from actividades a where a.tipoActividad="Emision" and a.tarjetaTipoPago is not null and year(a.fechaActualizacion)='.$year.' and month(a.fechaActualizacion)='.$month.' group by a.tarjetaTipoPago;';
    $informacion['tipoPago']=$this->db->query($consulta)->result();
    $consulta='select a.idPagoConducto,p.pagoConducto,(count(a.idPagoConducto)) as total from actividades a left join pagoconducto p on p.idPagoConducto=a.idPagoConducto where a.tipoActividad="Emision" and a.tarjetaTipoPago is not null and year(a.fechaActualizacion)='.$year.' and month(a.fechaActualizacion)='.$month.' group by a.idPagoConducto;';
      
    $informacion['tipoConducto']=$this->db->query($consulta)->result();
    $consulta='select if((count(a.idInterno))=0,0,count(a.idInterno)) as total from actividades a where a.tipoActividad="Emision" and a.tarjetaTipoPago is not null and aes_decrypt(a.tarjetaNumeroEncriptado,(concat(a.folioActividad,"AC")))!="" and year(a.fechaActualizacion)='.$year.' and month(a.fechaActualizacion)='.$month;
    
$informacion['tarjetas']=$this->db->query($consulta)->result()[0]->total;

   $consulta='select (count(a.idInterno)) as total from actividades a where a.tipoActividad="Emision"  and year(a.fechaActualizacion)='.$year.' and month(a.fechaActualizacion)='.$month;
    $informacion['emisiones']=$this->db->query($consulta)->result()[0]->total;


    
    
    return $informacion;

}

function getAllBajasMensual($mes,$year){
	$fechaInicio=$year.'-01-01';
	$fechaActual=$year."-".$mes."-".date('d');
	$sql="SELECT COUNT(*) AS total FROM persona a LEFT JOIN users b on a.idPersona = b.idPersona WHERE b.modified BETWEEN '$fechaInicio' AND '$fechaActual' AND a.bajapersona = 1 AND b.banned = 1 AND b.activated = 0";
	return $this->db->query($sql)->result();
}

function getAllBajasGlobal($mes,$year){
	$fechaInicio=$year.'-01-01';
	$fechaActual=$year."-".$mes."-".date('d');
	$sql="SELECT COUNT(*) AS total FROM persona a LEFT JOIN users b on a.idPersona = b.idPersona WHERE b.modified BETWEEN '$fechaInicio' AND '$fechaActual' AND a.bajapersona = 1 AND b.banned = 1 AND b.activated = 0";
	return $this->db->query($sql)->result();
}




}
