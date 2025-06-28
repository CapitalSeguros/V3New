<?php
class capitalhumano_model extends CI_Model{

	
public function __Construct(){
	parent::__Construct();
		//$this->load->library('localfileuploader');
}
public function guardar_organigrama($data){
    $this->db->set('url_imagen',$data['url_imagen']);
    $this->db->where('id',0);
    $this->db->update('organigrama');
    //$this->db->insert("organigrama",$data);
    return;
}
public function get_organigrama(){
    $query = $this->db->query("SELECT url_imagen FROM organigrama WHERE id=0");
    $result = $query->result();
    return $result;
}
//------------------------------------------------------------------
public function devolverPuestos($devolucion=NULL){
  //$consulta="select * from personapuesto where statusPuesto=1 order by personaPuesto";
  
  if($devolucion==null)
 {/*   
  $consulta='select pp.*,c.idColaboradorArea,c.colaboradorArea,p.nombres,p.apellidoPaterno,p.apellidoMaterno  from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPersona='.$this->tank_auth->get_idPersona();
  
  $datos=$this->db->query($consulta)->result();
  $info=array();
  $idPadre='';  
  array_push($info, $datos[0]);
   if((count($datos))>0)
  {
    $consulta='select pp.*,c.idColaboradorArea,c.colaboradorArea,p.nombres,p.apellidoPaterno,p.apellidoMaterno  from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona  where pp.statusPuesto=1 and pp.padrePuesto in (';
    $idPadre='';
    foreach ($datos as $key => $value) 
    {
       if ($value === end($datos)) {$idPadre.=$value->idPuesto;}
       else{$idPadre.=$value->idPuesto.',';}      
    }    
    $consulta.=$idPadre.')';        
    $datos=$this->db->query($consulta)->result();    
    foreach ($datos as $key => $value) {array_push($info, $value);}
    
  }*/

  $sql='select pp.*,c.idColaboradorArea,c.colaboradorArea,p.nombres,p.apellidoPaterno,p.apellidoMaterno  from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPersona='.$this->tank_auth->get_idPersona();
    		  $datos=$this->db->query($sql)->result();
    		  $info=array();
			  $idPadre='';  
			  array_push($info, $datos[0]);
			  if((count($datos))>0){
			    $consulta='select pp.*,c.idColaboradorArea,c.colaboradorArea,p.nombres,p.apellidoPaterno,p.apellidoMaterno  from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona  where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$datos[0]->idPuesto.' ORDER BY `p`.`idPersona`';			       
			    $datos=$this->db->query($consulta)->result();    
			    foreach($datos as $key => $value) {
					array_push($info, $value);
					$consulta2='select pp.*,c.idColaboradorArea,c.colaboradorArea,p.nombres,p.apellidoPaterno,p.apellidoMaterno  from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona  where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$value->idPuesto.' ORDER BY `p`.`idPersona`';			       
					$datos2=$this->db->query($consulta2)->result();
					if(count($datos2)>0){    
					foreach($datos2 as $key2 => $value2) {
						array_push($info, $value2);
						$consulta3='select pp.*,c.idColaboradorArea,c.colaboradorArea,p.nombres,p.apellidoPaterno,p.apellidoMaterno  from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona  where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$value2->idPuesto.' ORDER BY `p`.`idPersona`';			       
						$datos3=$this->db->query($consulta3)->result();
						if(count($datos3)>0){    
						foreach($datos3 as $key3 => $value3) {
							array_push($info, $value3);
						}
						}
					}
					}
				}
			    
  }
 }
 else
 {
    $consulta='select pp.*,c.idColaboradorArea,c.colaboradorArea ,p.nombres,p.apellidoPaterno,p.apellidoMaterno from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98';
  $info=$this->db->query($consulta)->result();
 }

  $respuesta=array();  
   foreach ($info as $key => $value) 
   {
        $nombre=$value->colaboradorArea;        
        if(!isset($respuesta[$nombre])){$respuesta[$nombre]=array();}
        array_push($respuesta[$nombre], $value);      
   }
        
  return $respuesta;
 }
 //----------------------------------------------------------------
 public function guardarPuesto(){
/*NOS GUARDA EL NUEVO PUESTO CREADO*/
  $insert['personaPuesto']=$_POST['personaPuesto'];	
  $insert['padrePuesto']=$_POST['padrePuesto'];
  $insert['idPersonaPuestoGrupo']=$_POST['selectPuestos'];
  $insert['nivelPuesto']=$this->buscarNivelPuesto($_POST['padrePuesto'])+1;
  $this->db->insert('personapuesto',$insert);
  $last=$this->db->insert_id();
  $update='update personapuestogrupo set cantidadOcupada=cantidadOcupada+1 where idPersonaPuestoGrupo='.$_POST['selectPuestos'].' limit 1;';
  $this->db->query($update);
  return  $last;
 
 }
//----------------------------------------------------------------
public function buscarNivelPuesto($idPuesto){
  $consulta="select nivelPuesto from personapuesto where idPuesto=".$idPuesto;
  $datos=$this->db->query($consulta)->result();
  return $datos[0]->nivelPuesto;
}
//----------------------------------------------------------------
public function buscarPuesto($idPuesto){
	$consulta="select * from personapuesto where idPuesto=".$idPuesto;
	$datos=$this->db->query($consulta)->result()[0];
	return $datos;
}
//----------------------------------------------------------------
public function actualizarPuestosHijos($idPuesto,$nuevoNivel){
 $bandHijos=1;
 $idPuestoHijos=' padrePuesto='.$idPuesto;
 $n=0;
 while($bandHijos) { $n++;
    $consulta="select idPuesto from personapuesto where ".$idPuestoHijos;
    
    $datos=$this->db->query($consulta)->result();
    $idPuestoHijos="";

    $countDatos=count($datos); 
          
    if($countDatos>0){   
    	$nuevoNivel=$nuevoNivel+1;
       for($i=0;$i<$countDatos;$i++){
         $idPuestoHijos=$idPuestoHijos.'padrePuesto='.$datos[$i]->idPuesto;
         if($countDatos!=($i+1)){
           $idPuestoHijos=$idPuestoHijos.' or ';
         }
         $actualiza['nivelPuesto']=$nuevoNivel;
         $this->db->where('idPuesto',$datos[$i]->idPuesto);
         $this->db->update('personapuesto',$actualiza);
         
       }

       	//$bandHijos=0;
    }
    else{
    	$bandHijos=0;
    }
 
}


}

//----------------------------------------------------------------
public function actualizarPuesto($idPuesto,$actualizar){
	if(isset($actualizar['padrePuesto'])){
	 $nivelPuesto=$this->buscarNivelPuesto($actualizar['padrePuesto']); 
	 $nivelPuesto=$nivelPuesto+1;
	 $actualizar['nivelPuesto']=$nivelPuesto;
	 $this->actualizarPuestosHijos($idPuesto,$nivelPuesto);	
	}
	$this->db->where('idPuesto',$idPuesto);
	$this->db->update('personapuesto',$actualizar);
}
//----------------------------------------------------------------
private function  devolverEmpleadosDePuesto($idPuesto){
	  $consultaEmpleados="select (concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno)) as nombre from persona where tipoPersona=1 and idPersonaPuesto=".$idPuesto;
  $empleados=$this->db->query($consultaEmpleados)->result();
  $cadena="";
  foreach ($empleados as $key => $value) {
  	$cadena=$cadena.'<label>'.$value->nombre.'</label><br>';
  }
           
     return $cadena;
}

//----------------------------------------------------------------
public function crearOrganigrama(){
	$datos=$this->db->query("select (max(nivelPuesto)) as niveles from personapuesto")->result()[0]->niveles;
 $ultimoNodo=$this->db->query("select * from personapuesto where nivelPuesto=".$datos)->result();

 /*$hijoNodo="";
 $hijoNodo="";
 for($i=0;$i<count($ultimoNodo);$i++){
  $empleados=$this->devolverEmpleadosDePuesto($ultimoNodo[$i]->idPuesto);
  $hijoNodo[$ultimoNodo[$i]->idPuesto]['padrePuesto']=$ultimoNodo[$i]->padrePuesto;
  $hijoNodo[$ultimoNodo[$i]->idPuesto]['personaPuesto']=$ultimoNodo[$i]->personaPuesto;
  $hijoNodo[$ultimoNodo[$i]->idPuesto]['listaPuesto']='<div><label onclick=\'devuelveFuncionesAJAX(1,'.$ultimoNodo[$i]->idPuesto.',this)\'>'.$empleados.$ultimoNodo[$i]->personaPuesto."</label></div>";
 } 
  $clase="display:block";
 for($i=($datos-1);$i>-1;$i--){
  $anteriorNodo=$this->db->query("select * from personapuesto where nivelPuesto=".$i)->result();
  $countAnteriorNodo=count($anteriorNodo);
  for($j=0;$j<$countAnteriorNodo;$j++){
    $tieneHijos="";
    $band=0;
   
   foreach ($hijoNodo as $key => $value) {
        if($value['padrePuesto']==$anteriorNodo[$j]->idPuesto){
          $band=1;
            $tieneHijos=$tieneHijos.$value['listaPuesto'];
        }
     } 
     if($anteriorNodo[$j]->idPuesto==(1)){ $clase='verObjeto inicialClass';}else{ $clase="ocultarObjeto";}
     if($band)
      { $hijoNodo[$anteriorNodo[$j]->idPuesto]['padrePuesto']=$anteriorNodo[$j]->padrePuesto;
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['personaPuesto']=$anteriorNodo[$j]->personaPuesto;
           $empleados=$this->devolverEmpleadosDePuesto($anteriorNodo[$j]->idPuesto);
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['listaPuesto']='<div class=\''.$clase.'\'><label class=\'verObjeto\' onclick=\'devuelveFuncionesAJAX(1,'.$anteriorNodo[$j]->idPuesto.',this)\'>'.$empleados.$anteriorNodo[$j]->personaPuesto.'</label>'.$tieneHijos.'</div>';
      }
      else{
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['padrePuesto']=$anteriorNodo[$j]->padrePuesto;
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['personaPuesto']=$anteriorNodo[$j]->personaPuesto;
         $empleados=$this->devolverEmpleadosDePuesto($anteriorNodo[$j]->idPuesto);
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['listaPuesto']='<div class=\''.$clase.'\'><label class=\'verObjeto\' onclick=\'devuelveFuncionesAJAX(1,'.$anteriorNodo[$j]->idPuesto.',this)\'>'.$empleados.$anteriorNodo[$j]->personaPuesto.'</label></div>';
      }
      
   }

 }*/
  
 for($i=0;$i<count($ultimoNodo);$i++){
  $empleados=$this->devolverEmpleadosDePuesto($ultimoNodo[$i]->idPuesto);
  $hijoNodo[$ultimoNodo[$i]->idPuesto]['padrePuesto']=$ultimoNodo[$i]->padrePuesto;
  $hijoNodo[$ultimoNodo[$i]->idPuesto]['personaPuesto']=$ultimoNodo[$i]->personaPuesto;
  $hijoNodo[$ultimoNodo[$i]->idPuesto]['listaPuesto']='<li><label onclick=\'devuelveFuncionesAJAX(1,'.$ultimoNodo[$i]->idPuesto.')\'>'.$empleados.$ultimoNodo[$i]->personaPuesto."</label></li>";
 } 
 
 for($i=($datos-1);$i>-1;$i--){
  $anteriorNodo=$this->db->query("select * from personapuesto where nivelPuesto=".$i)->result();
  $countAnteriorNodo=count($anteriorNodo);
  for($j=0;$j<$countAnteriorNodo;$j++){
    $tieneHijos="";
    $band=0;
   foreach ($hijoNodo as $key => $value) {
        if($value['padrePuesto']==$anteriorNodo[$j]->idPuesto){
          $band=1;
            $tieneHijos=$tieneHijos.$value['listaPuesto'];
        }
     } 
     if($band)
      { $hijoNodo[$anteriorNodo[$j]->idPuesto]['padrePuesto']=$anteriorNodo[$j]->padrePuesto;
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['personaPuesto']=$anteriorNodo[$j]->personaPuesto;
           $empleados=$this->devolverEmpleadosDePuesto($anteriorNodo[$j]->idPuesto);
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['listaPuesto']='<li><label onclick=\'devuelveFuncionesAJAX(1,'.$anteriorNodo[$j]->idPuesto.')\'>'.$empleados.$anteriorNodo[$j]->personaPuesto.'</label><ul>'.$tieneHijos.'</ul></li>';
      }
      else{
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['padrePuesto']=$anteriorNodo[$j]->padrePuesto;
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['personaPuesto']=$anteriorNodo[$j]->personaPuesto;
         $empleados=$this->devolverEmpleadosDePuesto($anteriorNodo[$j]->idPuesto);
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['listaPuesto']='<li><label onclick=\'devuelveFuncionesAJAX(1,'.$anteriorNodo[$j]->idPuesto.')\'>'.$empleados.$anteriorNodo[$j]->personaPuesto.'</label></li>';
      }
   }
 }
  
 return $hijoNodo[1]['listaPuesto'];

}
//----------------------------------------------------------------
function crearFuncionProceso($insertar)
{
  $insert['descripcionFP']=$_POST['descripcionFP'];
  $insert['tipoFP']=$_POST['tipoFP'];
  $insert['clasificacionFP']=$_POST['clasificacionFP'];
  $this->db->insert('funcionproceso',$insert);
  return $this->db->insert_id();
}
//----------------------------------------------------------------
function devolverFuncionProceso($idFuncionProceso){
	$consulta="select * from funcionproceso where statusFP=1 and idFuncionProceso=".$idFuncionProceso;

	return $this->db->query($consulta)->result()[0]; 
}
//----------------------------------------------------------------
function devolverFuncionesProcesos($tipo){
	/*statusFP=1 ES QUE EL PROCESO O FUNCION ESTAN ACTIVOS
      tipoFP=0   ES UNA FUNCION
      tipoFP=1   ES UN PROCESO
	*/
	switch ($tipo) {
		case 0:$consulta="select * from funcionproceso where statusFP=1 and tipoFP=0";break;
		case 1:$consulta="select * from funcionproceso where statusFP=1 and tipoFP=1";break;
		case 2:$consulta="select * from funcionproceso where statusFP=1";break;
	}
	
	return $this->db->query($consulta)->result(); 
}
//----------------------------------------------------------------
function devolverTipoFP($idFuncionProceso)
{
 return $this->db->query("select tipoFP from funcionproceso where idFuncionProceso=".$idFuncionProceso)->result()[0]->tipoFP;
}
//----------------------------------------------------------------
function actualizarFuncionProceso($idFuncionProceso,$datos){
 /* $update['descripcionFP']=$datos['descripcionFP'];
  $update['statusFP']=$datos['statusFP'];
  $update['tipoFP']=$datos['tipoFP'];
  $update['clasificacionFP']=$datos['clasificacionFP'];*/

  $this->db->where('idFuncionProceso',$idFuncionProceso);
  if($this->db->update('funcionproceso',$datos)){return 1;}
  else{return 0;}
}

//----------------------------------------------------------------
function funcionesAsignadasProcesos($idFuncionProceso,$tipo)
{
    if($tipo==1){
    /*DEVUELVE FUNCIONES  ASIGNADAS A LOS PROCESOS*/
     $consulta="select * from funcionprocesounion left join funcionproceso on funcionproceso.idFuncionProceso=funcionprocesounion.idFuncionFP where funcionprocesounion.idProcesoFP=".$idFuncionProceso.' order by funcionprocesounion.ordenFPU';
    }else
   {/*DEVUELVE FUNCIONES */
    $consulta='select * from funcionproceso  where tipoFP=0  ';
   }

    return $this->db->query($consulta)->result(); 
}
//----------------------------------------------------------------
function  devolverProcedimientosAsignadasMP($idFuncionProceso){
	$consulta="select idFuncionFP,descripcionFP,idPuestoFP,personapuesto.personaPuesto,'0' as funcion from funcionprocesounion 
left join funcionproceso on funcionproceso.idFuncionProceso=funcionprocesounion.idFuncionFP 
left join funcionpuesto  on idFuncionProcesoFP=padreFP
left join personapuesto on personapuesto.idPuesto=funcionpuesto.idPuestoFP
where funcionprocesounion.idProcesoFP=".$idFuncionProceso." and statusFP=1 order by funcionprocesounion.ordenFPU";

    return $this->db->query($consulta)->result(); 
}
//----------------------------------------------------------------
function manejaCambiosFPU($idFuncion,$idProceso,$tipo){
   if($tipo==1){
     /*ASIGNA FUNCION AL PROCESO*/
     $consulta="select (count(idProcesoFP)) as total from funcionprocesounion where idProcesoFP=".$idProceso." and  idFuncionFP=".$idFuncion;
     if($this->db->query($consulta)->result()[0]->total==0){
      $consulta="select if(max(idProcesoFP) is null,0,max(ordenFPU)) as total from funcionprocesounion where idProcesoFP=".$idProceso;
     $insert['ordenFPU']= ($this->db->query($consulta)->result()[0]->total)+1;
     $insert['idProcesoFP']=$idProceso ;
     $insert['idFuncionFP']=$idFuncion ;
     $this->db->insert('funcionprocesounion',$insert);}
   }
   else{
     /*QUITA FUNCION DEL PROCESO*/
     $this->db->where('idProcesoFP',$idProceso);
     $this->db->where('idFuncionFP',$idFuncion);
     $this->db->delete('funcionprocesounion');
   }
}
//----------------------------------------------------------------
function cambiarOrdenFPU($idProcesoFP,$idFuncionFP,$direccion){
	if($direccion==0){
		/*EL PROCEDIMIETO SUBE (SE MUEVE PARA ARRIBA)*/
		$consulta='select ordenFPU from funcionprocesounion where idProcesoFP='.$idProcesoFP.' and idFuncionFP='.$idFuncionFP;
					
		$ordenFPU=$this->db->query($consulta)->result()[0]->ordenFPU;
		$consulta='select * from funcionprocesounion where idProcesoFP='.$idProcesoFP.' and ordenFPU<'.$ordenFPU.'  order by  ordenFPU desc limit 1 ';
		$funcionCambio=$this->db->query($consulta)->result();
		if(count($funcionCambio)>0){
	
	    $update['ordenFPU']=$ordenFPU;
		$this->db->where('idProcesoFP',$funcionCambio[0]->idProcesoFP);
		$this->db->where('idFuncionFP',$funcionCambio[0]->idFuncionFP);
		$this->db->update('funcionprocesounion',$update);
		$update['ordenFPU']=$funcionCambio[0]->ordenFPU;
		$this->db->where('idProcesoFP',$idProcesoFP);
		$this->db->where('idFuncionFP',$idFuncionFP);
		$this->db->update('funcionprocesounion',$update);
	  }
	}
	else{
		/*EL PROCEDIMIENTO CAMBIA PARA ABAJO DE ORDEN(SE MUEVE PARA ABAJO)*/
				$consulta='select ordenFPU from funcionprocesounion where idProcesoFP='.$idProcesoFP.' and idFuncionFP='.$idFuncionFP;
		$ordenFPU=$this->db->query($consulta)->result()[0]->ordenFPU;
		$consulta='select * from funcionprocesounion where idProcesoFP='.$idProcesoFP.' and ordenFPU>'.$ordenFPU.'  order by  ordenFPU  limit 1 ';
		$funcionCambio=$this->db->query($consulta)->result();
		if(count($funcionCambio)>0){
	 	
	    $update['ordenFPU']=$ordenFPU;
		$this->db->where('idProcesoFP',$funcionCambio[0]->idProcesoFP);
		$this->db->where('idFuncionFP',$funcionCambio[0]->idFuncionFP);
		$this->db->update('funcionprocesounion',$update);
		$update['ordenFPU']=$funcionCambio[0]->ordenFPU;
		$this->db->where('idProcesoFP',$idProcesoFP);
		$this->db->where('idFuncionFP',$idFuncionFP);
		$this->db->update('funcionprocesounion',$update);
       }
	}
}
//----------------------------------------------------------------
function devolverFuncionesDePuesto($idPuestoFP){
 $consulta="select * from funcionpuesto where idPuestoFP=".$idPuestoFP;

 return $this->db->query($consulta)->result();

}
//----------------------------------------------------------------
function borrarTodasFuncionesPuesto($idPuestoFP){
 $this->db->where('idPuestoFP',$idPuestoFP);
 $this->db->delete('funcionpuesto');

}
//----------------------------------------------------------------
function asignarFuncionesPuesto($idPuesto,$idFuncionProceso){
  $count=count($idFuncionProceso);
  foreach ($idFuncionProceso as $key => $value) {
  	$insert['idPuestoFP']=$idPuesto;
  	$insert['idFuncionProcesoFP']=$value;
  	$this->db->insert('funcionpuesto',$insert);
  }

}

//----------------------------------------------------------------
function devolverFuncionesAsignadasPuesto($idPuesto){ //Modificado [2024-02-09]
  $data = array();
	$con = $this->db->query("select funcionpuesto.idFuncionProcesoFP,funcionproceso.descripcionFP from funcionpuesto left join funcionproceso on funcionproceso.idFuncionProceso=funcionpuesto.idFuncionProcesoFP where funcionproceso.statusFP=1 and funcionproceso.clasificacionFP=0 and funcionpuesto.idPuestoFP=".$idPuesto)->result();

  foreach ($con as $val) {
    $procedure = array();
    $pro = $this->getFunctionEmployee($val->idFuncionProcesoFP);
    foreach ($pro as $row) {
      $insert['idFuncionProceso'] = $row->idFuncionProceso;
      $insert['descripcionFP'] = $row->descripcionFP;
      $insert['pasos'] = $this->getFunctionEmployee($row->idFuncionProceso);
      array_push($procedure, $insert);
    }
    $add['idFuncionProcesoFP'] = $val->idFuncionProcesoFP;
    $add['descripcionFP'] = $val->descripcionFP;
    $add['procedimientos'] = $procedure;
    array_push($data, $add);
  }
 
  return  $data;
}

function getFunctionEmployee($id) { //Creado [2024-02-09]
  $data = $this->db->query('select idFuncionProceso, descripcionFP from funcionproceso where padreFP = "'.$id.'"')->result();
  return $data;
}
//----------------------------------------------------------------
function devolverMatrizAsignadaPuesto($idPuesto){
	$consulta="select funcionpuesto.idFuncionProcesoFP,funcionproceso.descripcionFP from funcionpuesto left join funcionproceso on funcionproceso.idFuncionProceso=funcionpuesto.idFuncionProcesoFP where funcionproceso.statusFP=1 and funcionproceso.clasificacionFP=4 and funcionpuesto.idPuestoFP=".$idPuesto;

  return  $this->db->query($consulta)->result();
}
//----------------------------------------------------------------
function borrarManualUsuario($idPuesto){

	$this->db->where('idPuesto',$idPuesto);
	//$this->db->where('idDivContenedor',$idDivContenedor);
	$this->db->delete('manualusuario');
}
//------------------------------------------------------------
function grabarManualUsuario($idPuesto,$idDivContenedor,$contenido){
	$this->load->library("libreriav3");
	//if($idDivContenedor=="divContenidoPRP"){
	$contenido=$this->libreriav3->sustituyeCaracteres($contenido);
  //}
	 
	$insert['idPuesto']=$idPuesto ;
	$insert['idDivContenedor']=$idDivContenedor ;
	$insert['contenido']=$contenido ;
	$this->db->insert('manualusuario',$insert);
}
//----------------------------------------------------------------
function grabarManualProcedimiento($idFuncionProceso,$idDivContenedor,$contenido){
	$insert['idFuncionProceso']=$idFuncionProceso;
	$insert['idDivContenedor']=$idDivContenedor;
	$insert['contenido']=$contenido ;
	$this->db->insert('manualusuario',$insert);	
}
//----------------------------------------------------------------
function borrarManualProcedimiento($idFuncionProceso){
	$this->db->where('idFuncionProceso',$idFuncionProceso);
	$this->db->delete('manualusuario');	
}
//----------------------------------------------------------------
function devolverManualUsuario($idPuesto){
 $consulta="select * from manualusuario where idPuesto=".$idPuesto;
 $datos=$this->db->query($consulta);
 return $datos->result();
}

//----------------------------------------------------------------
function agregarProcedimientos($datos){
   $this->db->insert('funcionproceso',$datos);
    return $this->db->insert_id();
  }
 //----------------------------------------------------------------
 function devolverProcedimientosFuncion($idFuncionProceso){
 /*==OBTIENE LOS PROCEDIMIENTOS PERTENECIENTES A LA FUNCION==*/
 	$consulta="select idFuncionProceso,descripcionFP from funcionproceso where statusFP=1 and padreFP=".$idFuncionProceso." order by idFuncionProceso";

 	return $this->db->query($consulta)->result();
 }
 //----------------------------------------------------------------
 function devolverDescripPF($idFuncionProceso){
 	/*==OBTIENE LOS PASOS DEL PROCEDIMIENTO Y LA DESCRIPCION DEL MANUAL DE ESTE PROCESO==*/
 	 	//$consulta="select * from manualusuario where idFuncionProceso=".$idFuncionProceso;
 	/*$consulta="select idFuncionProceso,descripcionFP,'0' as funcion
from funcionproceso where statusFP=1 and padreFP=".$idFuncionProceso." 
union 
select  idDivContenedor,contenido,'1' as funcion
from manualusuario where manualusuario.idFuncionProceso=".$idFuncionProceso."
order by idFuncionProceso";$datos=$this->db->query($consulta)->result();*/
	$consulta="select idFuncionProceso,descripcionFP,'0' as funcion
from funcionproceso where statusFP=1 and padreFP=".$idFuncionProceso;
$datos=$this->db->query($consulta)->result();
$datosDivConsulta="select  (idDivContenedor) as idFuncionProceso,(contenido) as descripcionFP,'1' as funcion
from manualusuario where manualusuario.idFuncionProceso=".$idFuncionProceso."
order by idDivContenedor;";
$datosDiv=$this->db->query($datosDivConsulta)->result();
 if(count($datosDiv)>0){
array_push($datos,$datosDiv[0]);array_push($datos,$datosDiv[1]);array_push($datos,$datosDiv[2]);array_push($datos,$datosDiv[3]);array_push($datos,$datosDiv[4]);}
  
 	return $datos;

 }
//----------------------------------------------------------------
 function devolverDescripPFU($idFuncionProceso){
$consulta="select  idDivContenedor,contenido,'1' as funcion
from manualusuario where manualusuario.idFuncionProceso=".$idFuncionProceso."
order by idFuncionProceso";

 	return $this->db->query($consulta)->result();
}
//----------------------------------------------------------------
function devolverPartesManualUsuario($idPuesto){
	$consulta='select * from manualusuariopartes mup
left join manualusuario mu on mu.idDivContenedor=mup.idDivMUP
where mup.tipoMUP="M" and mu.idPuesto='.$idPuesto.' order by mup.ordenMUP';
return $this->db->query($consulta)->result();
}

//----------------------------------------------------------------
function devolverManualPocedimientos($idFuncionProceso)
{
	$consulta='select * from manualusuariopartes mup
left join manualusuario mu on mu.idDivContenedor=mup.idDivMUP
where mup.tipoMUP="P" and mu.idFuncionProceso='.$idFuncionProceso.' order by mup.ordenMUP';

return $this->db->query($consulta)->result();
}
//----------------------------------------------------------------
function devolverPasosDelProcedimiento($padreFP){
	$consulta='select * from funcionproceso fp where fp.padreFP='.$padreFP.' and fp.statusFP=1 order by fp.idFuncionProceso';

return $this->db->query($consulta)->result();
}
//----------------------------------------------------------------
function moverProcedimientoModelo($array){
    $this->db->where('idFuncionProceso',$array['posicionMover1']);
    $update['idFuncionProceso']=-$array['posicionMover1'];
    $this->db->update('funcionproceso',$update);
    $this->db->where('idFuncionProceso',$array['posicionMover2']);
    $update['idFuncionProceso']=-$array['posicionMover2'];
    $this->db->update('funcionproceso',$update);

    $this->db->where('idFuncionProceso',-$array['posicionMover1']);
    $update['idFuncionProceso']=$array['posicionMover2'];
    $this->db->update('funcionproceso',$update);
        $this->db->where('idFuncionProceso',-$array['posicionMover2']);
    $update['idFuncionProceso']=$array['posicionMover1'];
    $this->db->update('funcionproceso',$update);

}
//----------------------------------------------------------------
function cambiarHijos($array){
    $this->db->where('padreFP',$array['posicionMover1']);
    $update['padreFP']=-$array['posicionMover1'];
    $this->db->update('funcionproceso',$update);
        $this->db->where('padreFP',$array['posicionMover2']);
    $update['padreFP']=-$array['posicionMover2'];
    $this->db->update('funcionproceso',$update);

        $this->db->where('padreFP',-$array['posicionMover1']);
    $update['padreFP']=$array['posicionMover2'];
    $this->db->update('funcionproceso',$update);

        $this->db->where('padreFP',-$array['posicionMover2']);
    $update['padreFP']=$array['posicionMover1'];
    $this->db->update('funcionproceso',$update);
}

//-------------------------------- //Dennis Castillo [2022-03-22]
function getEmployeeData($id){

  $this->db->where("idPuesto", $id);
  $query = $this->db->get("personapuesto");

  return $query->num_rows() > 0 ? $query->row() : array();
}
//-------------------------------- //Dennis Castillo [2022-03-22]
function insertRegister($table, $data){

  $response = false;
  $this->db->trans_begin();
  $this->db->insert($table, $data);

  if($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
  } else{
    $this->db->trans_commit();
    $response = true;
  }

  return $response;
}
//-------------------------------- //Dennis Castillo [2022-03-22]
function getAllDocsAndFormats($id){

  $this->db->where("idEmployee", $id);
  $this->db->order_by("id", "desc");
  $query = $this->db->get("capital_humano_documentos_de_puestos");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------- //Dennis Castillo [2022-03-22]
function deleteDocsAndFormat($ids){

  $response = false;
  $datosTabla=$this->db->query('select * from capital_humano_documentos_de_puestos where id='.$ids[0])->result_array();  
  $this->db->trans_begin();
  $this->db->where_in("id", $ids);
  $this->db->delete("capital_humano_documentos_de_puestos");

  if($this->db->trans_status() == FALSE){
    $this->db->trans_rollback();
  } else{
    $this->db->trans_commit();
    $response = true;
    
          $insert['tabla']='capital_humano_documentos_de_puestos';
       $insert['idTabla']=$ids[0];
       $insert['email']=$this->tank_auth->get_usermail();
       $insert['idPersona']=$this->tank_auth->get_idPersona();
       $insert['datos']=json_encode($datosTabla[0]);  
       $this->db->insert('papelera',$insert); 
 

  }

  return $response;
}
//-------------------------------- //Dennis Castillo [2022-03-22]
function getEmployeeInfo($id){

  $this->db->join("manualusuario b", "a.divContent = b.idDivContenedor", "inner");
  $this->db->join("personapuesto c", "b.idPuesto = c.idPuesto", "left");
  $this->db->join("colaboradorarea d", "c.idColaboradorArea = d.idColaboradorArea", "left");
  $this->db->where("b.idPuesto", $id);
  $this->db->order_by("order", "ASC");
  $query = $this->db->get("manualusuario_modulos a");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------- //Dennis Castillo [2022-03-22]
function getRepositories($group = null){

  if(!empty($group)){

    $this->db->where("grupo", $group);
  }

  $query = $this->db->get("repositorios_de_archivos_de_puestos");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------- //Dennis Castillo [2022-03-22]
function getRepositoryDocuments($condition){

  $this->db->where($condition);
  $query = $this->db->get("capital_humano_documentos_de_puestos");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------- //Dennis Castillo [2022-03-22]
function getAllDocumentsofJob($job){

  $this->db->join("capital_humano_documentos_de_puestos b", "a.repositorio = b.folder", "left");
  $this->db->where("b.idEmployee", $job);
  $query = $this->db->get("repositorios_de_archivos_de_puestos a");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------- //Dennis Castillo [2022-03-27]
function getVacationsInfo($person){

  $this->db->select("a.idPersona, a.id, a.fecha_salida, a.fecha_retorno, a.cantidad_dias, b.name, b.mime, b.reference_id, a.fecha,
    CASE
      WHEN a.aprobado = 0 THEN 'aceptado'
      WHEN a.aprobado = -1 THEN 'rechazado'
      ELSE 'pendiente'
    END AS label
  ", false);
  $this->db->join("documentos_de_vacaciones b", "a.id = b.reference_id", "left");
  $this->db->where("idPersona", $person);
  $query = $this->db->get("vacaciones a");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------- //Dennis Castillo [2022-03-27]
function insertVacationRecord($data){

  $response = false;
  $this->db->trans_begin();
  $this->db->insert("documentos_de_vacaciones", $data);

  if($this->db->trans_status() === FALSE){

    $this->db->trans_rollback();
  } else{
    $this->db->trans_commit();
    $response = true;
  }

  return $response;
}
//------------------------------ //Dennis Castillo [2022-06-02]
function getJobsAvailable($condition){

  $this->db->where($condition);
  return $this->db->get("list_of_users_to_delete")->result();
}
//------------------------------ //Dennis Castillo [2022-06-02]
function getHolydays($condition){

  $this->db->where($condition);
  $query = $this->db->get("dianolaboral");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------------ //Dennis Castillo [2022-06-28]
function insertVacationRequest($data){

  $response = array();
  $this->db->trans_begin();
  $this->db->insert("vacaciones", $data);

  $response["lastId"] = $this->db->insert_id();
  $response["success"] = $this->db->trans_status();

  if($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
  } else{
    $this->db->trans_commit();
  }

  return $response;
}
//------------------------------ //Dennis Castillo [2022-06-28]
function updateVacationRecord($condition, $data){

  $this->db->trans_begin();
  $this->db->where($condition);
  $this->db->update("vacaciones", $data);
  $response["success"] = $this->db->trans_status();

  if($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
  } else{
    $this->db->trans_commit();
  }

  return $response;
}
//------------------------------ //Dennis Castillo [2022-06-28]
function getVacationsRecords($condition){

  $this->db->where($condition);
  return $this->db->get("vacaciones")->result();
}
//------------------------------ //Dennis Castillo [2022-06-28]
function getVacationList($condition){

  $this->db->select("a.id, a.idPersona, a.nombre, a.antiguedad, a.aprobado, a.estado,  a.cantidad_dias, DATE_FORMAT(a.fecha, '%Y/%m/%d') AS fecha, DATE_FORMAT(a.fecha_salida, '%Y/%m/%d') AS fecha_salida, DATE_FORMAT(a.fecha_retorno, '%Y/%m/%d') AS fecha_retorno, b.name, b.mime, IF(b.name IS NULL, 'Sin documento anexado', b.name) as documento, CASE WHEN a.aprobado = 1 THEN 'default' WHEN a.aprobado = 0 THEN 'success' ELSE 'danger' END as cssClass", false);
  $this->db->join("documentos_de_vacaciones b", "b.reference_id = a.id", "left");

  if(!empty($condition)){
    $this->db->where($condition);
  }

  return $this->db->get("vacaciones a")->result();
}
//------------------------------ //Dennis Castillo [2022-06-28]
function getWhoRequestedVacations($condition){
  
  $this->db->select("a.*, b.fecAltaSistemPersona, c.colaboradorArea, d.personaPuesto");
  $this->db->from("vacaciones a ");
  $this->db->join("persona b", "b.idPersona = a.idPersona", "inner");
  $this->db->join("colaboradorarea c", "c.idColaboradorArea = b.idColaboradorArea", "left");
  $this->db->join("personapuesto d", "d.idPuesto = b.idPersonaPuesto", "left");
  $this->db->join("users e", "e.idpersona = b.idpersona", "left");
  $this->db->where("YEAR(fecha_retorno) >=", date("Y"));
  $this->db->where("e.banned", 0);
  $this->db->where("e.activated", 1);
  $this->db->where("b.bajaPersona", 0);
  
  if(!empty($condition)){
    $this->db->where($condition);
  }

  $this->db->order_by("a.nombre", "asc");

  return $this->db->get()->result();
}
//------------------------------ //Dennis Castillo [2022-07-20]
function getPeriodRequest($condition, $typeRequest){

  $query = $this->db->where($condition)
    ->where_in("aprobado", $typeRequest)
    ->get("vacaciones")
    ->result();
  
  return $query;
}
//------------------------------ //Dennis Castillo [2022-07-20]
function getVacationsDays($condition){

  $query = $this->db->where($condition)
    ->get("tabla_vacaciones")
    ->row();
  
  return $query;
}
//-----------------------------------------------------------------------------------------------
  //Puestos
  function getAllVacations() {
    $query = $this->db->select("a.*, b.fecAltaSistemPersona, c.colaboradorArea, d.personaPuesto, e.email")
      ->join("persona b", "b.idPersona = a.idPersona", "inner")
      ->join("colaboradorarea c", "c.idColaboradorArea = b.idColaboradorArea", "left")
      ->join("personapuesto d", "d.idPuesto = b.idPersonaPuesto", "left")
      ->join("users e", "e.idpersona = b.idpersona", "left")
      ->where(array("YEAR(fecha) >=" => date("Y"), "e.banned" => 0, "e.activated" => 1, "b.bajaPersona" => 0))
      ->order_by("a.fecha", "desc")
      ->get("vacaciones a ");
    return $query->num_rows() > 0 ? $query->result() : array();
  }

  function getAllAsistencias() {
    $query = $this->db->select("f.*, c.colaboradorArea, d.personaPuesto, e.email, CONCAT(b.apellidoPaterno, ' ', b.apellidoMaterno, ' ', b.nombres) AS empleado", false)
      ->join("persona b", "b.idPersona = f.idPersona", "inner")
      ->join("colaboradorarea c", "c.idColaboradorArea = b.idColaboradorArea", "left")
      ->join("personapuesto d", "d.idPuesto = b.idPersonaPuesto", "left")
      ->join("users e", "e.idpersona = b.idpersona", "left")
      ->where(array("YEAR(fecha) >=" => date("Y"), "e.banned" => 0, "e.activated" => 1, "b.bajaPersona" => 0, "f.descripcion" => "asistencia"))
      ->order_by("f.fecha", "desc")
      ->get("fastfile f");
    return $query->num_rows() > 0 ? $query->result() : array();
  }

  function getAllPuntualidad() {
    $query = $this->db->select("f.*, c.colaboradorArea, d.personaPuesto, e.email, CONCAT(b.apellidoPaterno, ' ', b.apellidoMaterno, ' ', b.nombres) AS empleado", false)
      ->join("persona b", "b.idPersona = f.idPersona", "inner")
      ->join("colaboradorarea c", "c.idColaboradorArea = b.idColaboradorArea", "left")
      ->join("personapuesto d", "d.idPuesto = b.idPersonaPuesto", "left")
      ->join("users e", "e.idpersona = b.idpersona", "left")
      ->where(array("YEAR(fecha) >=" => date("Y"), "e.banned" => 0, "e.activated" => 1, "b.bajaPersona" => 0, "f.descripcion" => "puntualidad"))
      ->order_by("f.fecha", "desc")
      ->get("fastfile f");
    return $query->num_rows() > 0 ? $query->result() : array();
  }
//-----------------------------------------------------------------------------------------------
  //::::::::::::::::::::::::::::::::::::: Permisos ::::::::::::::::::::::::::::::::::::::::::
  function getEmailsPermissionPosition() { //Creado [Suemy][2024-09-23]
    $data = array();
    $query = $this->db->query('SELECT email FROM `personapermisorelacion` WHERE idPersonaPermiso = 58')->result();
    foreach ($query as $val) {
      array_push($data, $val->email);
    }
    return $data;
  }
}
