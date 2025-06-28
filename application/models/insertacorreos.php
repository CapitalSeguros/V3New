<?php
class insertaCorreos extends CI_Model{
	public function __Construct(){
		parent::__Construct();
	}

public function insertaCorreos($data){

	$resultado = mysql_query("SELECT passwordVisible FROM users WHERE email ='".$data."'");
	$fila = mysql_fetch_row($resultado);
  if($fila>0){
  	$insertar="insert into envio_correos 
(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio) value";
  $insertar=$insertar.'(now(),"Avisos de GAP<avisosgap@aserorescpital.com>","'.$data;
  $insertar=$insertar.'",0,0,"RECUPERACION DE CONTRASEÑA",';
  $insertar=$insertar.'"su password es:'.$fila[0].'",';
  $insertar=$insertar.'0,now())'; 	
  if(mysql_query($insertar))
    {
    	return(0);
    }
  }
  else
  {
  
  	 return(-1);
  }
     
}

}
?>