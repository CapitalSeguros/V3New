<?php 
if(!defined("BASEPATH")) exit('No direct script access allowed');

class Metacomercial_modelo extends CI_Model{
    
    function devuelveInfoMC($band){

        $resultado=array();

        $this->db->where("anio",date("Y"));

        /*switch($band){
            case 1: $query=$this->db->get("metacomercial");
            case 2: $query=$this->db->get("metacomercial_ingreso_total");
        }*/

        if($band == 1){
            $query=$this->db->get("metacomercial");
        } else{
            $query=$this->db->get("metacomercial_ingreso_total");
        }

        //$query=$this->db->get("metacomercial");
        /*$this->db->from("metacomercial")
                ->join("metapormes","metacomercial.idMetaComercial=metapormes.idMetaComercial","inner");
        $query=$this->db->get(); */

        if($query->num_rows()>0){
            $resultado=$query->result();
        }

        return $resultado;
    }
    //------------------------------------------------------------ Dennis 2021-05-07
    function obtenerMensualidadesDeMeta($meta,$idPersona, $band){

        $resultado=array();

       $this->db->where("idMetaComercial",$meta);
       $this->db->where("anio",date("Y"));
       //$query=$this->db->get("metapormes");

        if($band == 1){
            $query=$this->db->get("metapormes");
        } else{
            $query=$this->db->get("metapormes_por_ingreso_total");
        }

        if($query->num_rows()>0){
            $resultado=$query->result();
        }

        return $resultado;
    }

//------------------------------------------------------------------------------------
function insertaMontosMensualesxAgente($array){

    $this->db->insert("metasmensualesagentes",$array);
    $respuesta=false;

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $respuesta=true;
    }

    return $respuesta;
}
//------------------------------------------------------------------------------------
function devuelveAgentesAsignados($mes,$correo){

    $resultado=array();

    $this->db->select("metasmensualesagentes.mes,persona.emailUsers,montoMes,persona.idPersona,nombres,apellidoPaterno,apellidoMaterno,metasmensualesagentes.idVend,ingresoTotalesEAB,metasmensualesagentes.asignacion") //ingresoTotalesEAB
            ->from("metasmensualesagentes")
            ->join("persona", "persona.idPersona=metasmensualesagentes.idPersona","left") //inner
            ->join("envioagentesbitacora","envioagentesbitacora.IDVendEAB=metasmensualesagentes.idVend","left") //inner
            ->where("metasmensualesagentes.mes",$mes)
            //->where("envioagentesbitacora.mesEAB",$mes)
            //->where("envioagentesbitacora.anioEAB",date("Y"))
            ->where("persona.userEmailCreacion",$correo)
            ->group_by("persona.idPersona");
    $query=$this->db->get();

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r("aqui",TRUE));fclose($fp);

    return $resultado;

}
//------------------------------------------------------------------------------------
function devuelveInfoAsignados($mes, $anio, $correo){

    $respuesta=array();

    $this->db->where("mes",$mes)
            ->where("anio",$anio)
            ->where("email",$correo);
    $query=$this->db->get("metasmensualesagentes");

    if($query->num_rows()>0){
        $respuesta=$query->result();
    }

    return $respuesta;
}
//------------------------------------------------------------------------------------
function devolverInfoGeneralMeta($correo){

    $resultado=array();

    $consulta="SELECT mes,montoMes,persona.idPersona,meta.idVend,SUM(ingresoTotalesEAB),bita.mesEAB
                FROM metasmensualesagentes meta
                INNER JOIN users persona ON meta.idPersona=persona.idPersona
                INNER JOIN envioagentesbitacora bita ON meta.idVend=bita.IDVendEAB
                WHERE bita.anioEAB=Year(NOW()) AND persona.email='".$correo."' AND meta.mes=bita.mesEAB
                GROUP BY meta.mes;";
    $query=$this->db->query($consulta);

    /*$this->db->select("metasmensualesagentes.mes,montoMes,users.idPersona,metasmensualesagentes.idVend") //ingresoTotalesEAB
            ->from("metasmensualesagentes")
            ->join("users","users.idPersona=metasmensualesagentes.idPersona","inner")
            ->join("envioagentesbitacora","envioagentesbitacora.IDVendEAB=metasmensualesagentes.idVend","inner")
            //->where("metasmensualesagentes.mes",$mes)
            ->where("envioagentesbitacora.mesEAB","metasmensualesagentes.mes")
            ->where("envioagentesbitacora.anioEAB",date("Y"))
            ->where("users.email",$correo)
            ->group_by("metasmensualesagentes.mes");
    $query=$this->db->get(); */

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;

}
//------------------------------------------------------------------------------------
function devuelveMetasMensuales($idPersona){

    //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($idPersona, TRUE));fclose($fp);

    $resultado=array();

    $this->db->where("idPersona",$idPersona)
            ->where("anio", date("Y"));
    $query=$this->db->get("metasmensualesagentes");

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;
}
//--------------------------------------------------------- Dennis 2021-05-07
function eliminarRegistroDeMeta($idMeta, $anio, $band){

    $tablas=array();
    $columna="";

    switch($band){
        case 1: $tablas=array("metacomercial","metapormes"); 
        break;
        case 2: $tablas=array("metacomercial_ingreso_total","metapormes_por_ingreso_total");
    }

    //$tablas=array("metacomercial","metapormes");

    $resultado=false;

    $this->db->where("idMetaComercial",$idMeta)
            ->where("anio",$anio)
            ->delete($tablas);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $resultado=true;
    }

    return $resultado;
}
//------------------------------------------------------------------------------------
function eliminaAsignacionMensual($idpersona,$mes){

    $resultado=false;

    $this->db->where("idPersona",$idpersona)
            ->where("mes",$mes)
            ->where("email",$this->tank_auth->get_usermail())
            ->delete("metasmensualesagentes");
    
    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $resultado=true;
    }

    return $resultado;
}
//------------------------------------------------------------------------------------
function actualizaMontosMensualesxAgente($idPersona,$mes,$coordinador,$arreglo){

    $resultado=array();

    $this->db->where("mes",$mes)
            ->where("email",$coordinador)
            ->where("idPersona",$idPersona)
            ->where("anio",date("Y"))
            ->update("metasmensualesagentes",$arreglo);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $resultado=true;
    }

    return $resultado;
    
}
//------------------------------------------------------------------------------------
/*function contadorAgentesDinamicos(){

    //$this->db->count("montoMes");
    $this->db->where("mes",$mes);
    $this->db->where("email",$coordinador);

}*/
//------------------------------------------------------------------------------------
function inserta_metas($array){

    $resultado=false;

    $this->db->insert("registro_meta_mensual_ramo_coordinador_generico",$array);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $respuesta=true;
    }

    return $respuesta;

}


//------------------------------------------------------------------------------------
function obtenerPolizas($mes,$columna){

    $resultado=array();

    $this->db->select("persona.idPersona,persona.nombres,persona.apellidoPaterno,persona.apellidoMaterno,users.email,ramo,".$columna." as resultado_busqueda,mes_asignado");
    $this->db->join("persona","persona.idPersona=registro_meta_mensual_ramo_coordinador_generico.idPersona","left");
    $this->db->join("users","persona.idPersona=users.idPersona","left");
    $this->db->where("mes_asignado", $mes);
    $this->db->where("registro_meta_mensual_ramo_coordinador_generico.anio", date("Y"));
    //$this->db->select("idPersona,".$columna);
    //$this->db->where("mes_asignado", $mes);
    //$this->db->where("anio", date("Y"));
    $query=$this->db->get("registro_meta_mensual_ramo_coordinador_generico");

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;
}
//------------------------------------------------------------------------------------
function eliminarInformacionRamo($idPersona, $mes){

    $resultado=false;

    $this->db->where("idPersona",$idPersona);
    $this->db->where("mes_asignado", $mes);
    $this->db->where("anio", date("Y"));
    $this->db->delete("registro_meta_mensual_ramo_coordinador_generico");

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $resultado=true;
    }

    return $resultado;

}
//------------------------------------------------------------------------------------
function eliminarRegistrosAgentesAsignados($coor, $mes){

    $resultado=false;

    $this->db->where("idCoor",$coor);
    $this->db->where("mes_asignado", $mes);
    $this->db->where("anio", date("Y"));
    $this->db->delete("registro_meta_mensual_ramo_agente_generico");

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $resultado=true;
    }

    return $resultado;
}
//------------------------------------------------------------------------------------
function actualizarMetaDeRamo($id,$mes_ant,$ramo,$datos){

    $resultado=false;

    $this->db->where("idPersona",$id);
    $this->db->where("mes_asignado",$mes_ant);
    $this->db->where("ramo",$ramo);
    $this->db->where("anio",date("Y"));
    $this->db->update("registro_meta_mensual_ramo_coordinador_generico", $datos);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    }else{
        $this->db->trans_commit();
        $resultado=true;
    }

    return $resultado;
}
//------------------------------------------------------------------------------------
function informacionGeneralMetaRamo($idPersona,$mes,$table){

    $resultado=array();

    //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($mes, TRUE));fclose($fp);

    $this->db->where("idPersona", $idPersona);
    $this->db->where("anio", date("Y"));

    if(!empty($mes)){ //!empty
        $this->db->where("mes_asignado", $mes);
    }
    $this->db->order_by("mes_asignado", "asc");
    $query=$this->db->get($table); //Cambiar nombre a la tabla

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;
}
//-----------------------------------------------
function obtenerAsignadosMetasRamo($idPersona,$mes){

    $resultado=array();
    $this->db->select("users.idVend,users.email,persona.nombres,persona.apellidoPaterno,persona.apellidoMaterno, idCoor,anio,mes_asignado,ramo,registro_meta_mensual_ramo_agente_generico.idPersona, cantidad_polizas, prima_polizas,registro_meta_mensual_ramo_agente_generico.asignacion,registro_meta_mensual_ramo_agente_generico.reciente");
    $this->db->join("users","users.idPersona=registro_meta_mensual_ramo_agente_generico.idPersona","left");
    $this->db->join("persona","users.idPersona=persona.idPersona","left");
    $this->db->where("idCoor", $idPersona);
    $this->db->where("persona.bajaPersona",0);
    $this->db->where("users.activated", 1);
    $this->db->where("users.banned", 0);
    $this->db->where("anio", date("Y"));

    if($mes!=null){
        $this->db->where("mes_asignado", $mes);
    }
    
    $query=$this->db->get("registro_meta_mensual_ramo_agente_generico"); //Cambiar nombre a la tabla

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;

}
//----------------------------------------------
function validaExitenciaRamo($array,$col_select,$table_select){

    $resultado=array();

    $this->db->select($col_select) //"id_meta_ramo_a"
            ->where("idPersona",$array["idPersona"])
            ->where("mes_asignado",$array["mes_asignado"])
            ->where("ramo",$array["ramo"])
            //->where("cantidad_polizas",$array["cantidad_polizas"])
            //->where("prima_polizas",$array["prima_polizas"])
            ->where("anio",date("Y"));
    $query=$this->db->get($table_select); //"registro_meta_mensual_ramo_agente_generico"

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;
}
//-----------------------------------------------
function insertaMetaRamoAgente($array){

    $respuesta=false;

    $this->db->insert("registro_meta_mensual_ramo_agente_generico", $array);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $respuesta=true;
    }

    return $respuesta;

}
//-----------------------------------------------
function actualizaMetaRamoAgente($array_where, $array_update){

    $respuesta=false;

    $this->db->where("idPersona",$array_where["idPersona"]);
    $this->db->where("mes_asignado",$array_where["mes_asignado"]);
    $this->db->where("ramo",$array_where["ramo"]);
    $this->db->where("idCoor",$array_where["idCoor"]);
    $this->db->where("anio", date("Y"));
    $this->db->update("registro_meta_mensual_ramo_agente_generico",$array_update);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $respuesta=true;
    }

    return $respuesta;
}
//----------------------------------------------
function eliminarRegistroDeRamoAgente($agente,$coor,$mes,$ramo){

    $respuesta=array();

    $this->db->where("idPersona", $agente)
            ->where("idCoor",$coor)
            ->where("mes_asignado",$mes)
            ->where("ramo",$ramo)
            ->delete("registro_meta_mensual_ramo_agente_generico");

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $respuesta=true;
    }
        
    return $respuesta;         

}
//----------------------------------------------
function obtenerDatosGeneralesMetasRamos($agente){

    $resultado=array();

    $this->db->where("idPersona",$agente);
    $this->db->where("anio", date("Y"));
    $query=$this->db->get("registro_meta_mensual_ramo_agente_generico");

    if($query->num_rows()>0){
        $resultado=$query->result();
    } 

    return $resultado;
}
//----------------------------------------------
function obtenerDatosGeneralesAsignado($idPersona){

    $resultado=array();

    $this->db->select("users.idVend,users.email,persona.nombres,persona.apellidoPaterno,persona.apellidoMaterno, idCoor,anio,mes_asignado,ramo,registro_meta_mensual_ramo_agente_generico.idPersona, cantidad_polizas, prima_polizas");
    $this->db->join("users","users.idPersona=registro_meta_mensual_ramo_agente_generico.idPersona","left");
    $this->db->join("persona","users.idPersona=persona.idPersona","left");
    $this->db->where("registro_meta_mensual_ramo_agente_generico.idPersona", $idPersona);
    $this->db->where("anio", date("Y"));    
    $query=$this->db->get("registro_meta_mensual_ramo_agente_generico");

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;
}
//----------------------------------------------
function enviar_correo_tabla($correo_reg){

    $resultado=false;

    $this->db->insert("envio_correos",$correo_reg);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $resultado=true;
    }

    return $resultado;
}
//----------------------------------------------
function comisionMensualGenerada($coor,$mes){

    $resultado=array();

    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($coor,TRUE));fclose($fp);

    $this->db->select("envioagentesbitacora.mesEAB,envioagentesbitacora.anioEAB,persona.userEmailCreacion")
            ->select_sum("envioagentesbitacora.comisionVentaEAB")
            ->from("envioagentesbitacora")
            ->join("users","users.IDVend=envioagentesbitacora.IDVendEAB","left")
            ->join("persona","users.idPersona=persona.idPersona","left")
            ->where("envioagentesbitacora.anioEAB",date("Y"))
            ->where("envioagentesbitacora.mesEAB",$mes);
        //if(count($coor)>1){
            $this->db->where_in("persona.userEmailCreacion",$coor);
        //} else{
          //  $this->db->where("persona.userEmailCreacion",$coor[0]);
        //}
    $this->db->group_by("persona.userEmailCreacion");
    $query=$this->db->get();

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($resultado,TRUE));fclose($fp);
    return $resultado; 
}
//----------------------------------------------
function metaMensualXCoor($coor,$mes){

    $resultado=array();

    $this->db->select("metapormes.idMetaComercial,metacomercial.idPersona,email,mes_num,monto_al_mes,meta_acarreo")
                ->from("metacomercial")
                ->join("metapormes","metacomercial.idMetaComercial=metapormes.idMetaComercial","left")
                ->where("mes_num",$mes)
                ->where("metapormes.anio",date("Y"))
                ->where_in("email", $coor);
    $query=$this->db->get();

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;
}
//----------------------------------------------
function setAcarreoDeMetaMensual($idMeta,$mes,$array){

    $resultado=false;

    $this->db->where("idMetaComercial",$idMeta);
    $this->db->where("mes_num",$mes);
    $this->db->update("metapormes",$array);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $resultado=true;
    }

    return $resultado;
}
//----------------------------------------------
function obtenerMetaMensualCoor($meta,$mes){

    $resultado=array();

       $this->db->where("idMetaComercial",$meta);
       $this->db->where("mes_num",$mes);
       $this->db->where("anio",date("Y"));
       $query=$this->db->get("metapormes");

        if($query->num_rows()>0){
            $resultado=$query->result();
        }

        return $resultado;
}
//---------------------------------------------
function retornaMetaComercialAnual($cuenta_email){

    $resultado=array();
    $cuentas_altas=array("SISTEMAS@ASESORESCAPITAL.COM","DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM");

    $this->db->where("anio", date("Y"));
    if(!in_array($cuenta_email,$cuentas_altas)){
        $this->db->where("email",$cuenta_email);
    }
    $query=$this->db->get("metacomercial");

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;
}
//---------------------------------------------

function devuelveTodasLasMetasAsignadasDelMes(){

    $array_res=array();

    $this->db->select_sum("monto_al_mes");
    $this->db->select("mes_num");
    $this->db->where("anio", date("Y"));
    $this->db->group_by("mes_num");
    $query=$this->db->get("metapormes");

    if($query->num_rows()>0){
        $array_res=$query->result();
    }

    return $array_res;
}
//---------------------------------------------
function devuelveTodoElAvanceDeComisionesDelMes(){

    $array_res=array();

    $this->db->select_sum("comisionVentaEAB"); //comisionVentaEAB //ingresoTotalesEAB
    $this->db->select("mesEAB");
    $this->db->where("anioEAB", date("Y"));
    $this->db->group_by("mesEAB");
    $query=$this->db->get("envioagentesbitacora");

    if($query->num_rows()>0){
        $array_res=$query->result();
    }

    return $array_res;
}
//---------------------------------------------
function obtenerMetaAnualPorId($id, $bandera){

    $resultado = array();
    $tabla = "";

    $this->db->where("idPersona",$id);
    $this->db->where("anio",date("Y"));
    
    switch($bandera){
        case 1: $tabla="metacomercial";
        break;
        case 2: $tabla="metacomercial_ingreso_total";
    }

    $query=$this->db->get($tabla);

    if($query->num_rows()>0){
        $resultado = $query->row();
    }

    return $resultado;
}
//---------------------------------------------

//---------------------------------------------
function generaRelacionUsuarioMeta($relacion){

    $this->db->insert("relacion_persona_ingreso_venta_nueva_ingreso_total",$relacion);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
    }
}
//--------------------------------------------
function devuelveRelacionPersonaTipoDeMeta(){

    $resultado=array();

    $this->db->where("anio",date("Y"));
    $query = $this->db->get("relacion_persona_ingreso_venta_nueva_ingreso_total");

    if($query->num_rows()>0){
        $resultado = $query->result();
    }

    return $resultado;
}
//---------------------------------------------
function devuelveMensualidadDeMeta($mes,$meta,$bandera){

    $resultado = array();
    $tabla = "";

    switch($bandera){
        case 1: $tabla = "metapormes";
        break;
        case 2: $tabla = "metapormes_por_ingreso_total";
        break;
    }

    $this->db->where("anio",date("Y"));
    $this->db->where("idMetaComercial",$meta);
    $this->db->where("mes_num",$mes);
    $query = $this->db->get($tabla);

    if($query->num_rows()>0){

        $resultado = $query->row();
    }

    return $resultado;
}
//---------------------------------------------
function actualizaAvancesMensualesDeMeta($mes, $meta,$array,$tipoMeta){

    $tabla = "";
    $res = false;

    $this->db->where("anio",date("Y"));
    $this->db->where("idMetaComercial", $meta);
    $this->db->where("mes_num", $mes);

    switch($tipoMeta){
        case 1: $tabla = "metapormes";
        break;
        case 2: $tabla = "metapormes_por_ingreso_total";
        break;
    }

    $this->db->update($tabla,$array);

    if($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $res = true;
    }

    return $res;
}
//---------------------------------------------
function devuelveRelacionComisionPersona($array_persona){

    //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($array_persona, TRUE));fclose($fp);

    $resultado = array();
    $cuentas_altas = array("SISTEMAS@ASESORESCAPITAL.COM","DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM","GERENTEOPERATIVO@AGENTECAPITAL.COM", "DATACENTER@AGENTECAPITAL.COM");

    $this->db->where("anio", date("Y"));
    
    if(!in_array($array_persona["correo"],$cuentas_altas)){

        $this->db->where("idPersona", $array_persona["idPersona"]);
    }

    $query = $this->db->get("relacion_persona_ingreso_venta_nueva_ingreso_total");

    if($query->num_rows()>0){

        $resultado = $query->result();
    }

    return $resultado;
}
//---------------------------------------------
function sumatoriaRegistrosDeMetas($mes,$bandera,$tipo_resultado){

    $r = array();

    $tabla = "";

    switch($bandera){
        case 1: $tabla = "metapormes";
        break;
        case 2: $tabla = "metapormes_por_ingreso_total";
        break;
    }

    $this->db->select_sum("monto_al_mes");
    $this->db->select_sum("comision_actual");

    if($bandera == 1){
        $this->db->select_sum("comision_subsecuente");
    }

    $this->db->select_sum("meta_acarreo");
    $this->db->select_sum("cantidad_polizas");
    $this->db->where("anio", date("Y"));
    $this->db->where("mes_num", $mes);
    $query = $this->db->get($tabla);

    if($query->num_rows()>0){

        $r = $tipo_resultado == 1 ? $query->row() : $query->result();
    }

    return $r;
}
//---------------------------------------------
function devuelveCierreComercial(){

    $query = $this->db->get("activacion_consulta_comercial");

    return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------------------------
function activacion_consulta_comercial($insert){

    $this->db->insert("activacion_consulta_comercial", $insert);

    return true;
}
//---------------------------------------------
function devuelveActivacionComercial(){

    $this->db->order_by("fecha_activacion","desc");
    $query = $this->db->get("activacion_consulta_comercial");

    return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------------------------
function actualizaRegistroComision($up){

    /*$this->db->where("canal", $canal);
    $this->db->where("mes", $mes);
    return $this->db->update("consulta_comercial_registro_comisiones", $up);*/

    $update = 'UPDATE capsysV3.consulta_comercial_registro AS a 
        INNER JOIN capsysV3.consulta_comercial_comision AS b ON a.idComision = b.idComision
        SET a.activo = 0
        WHERE a.idUsuarioCanal = '.$up["idUsuarioCanal"].' AND b.mes = '.$up["mes"].'';

    $query = $this->db->query($update);

    return $query;
}
//---------------------------------------------
function insertaRegistro($arr, $table){

    $this->db->insert($table, $arr);

    return  $this->db->insert_id();
}
//---------------------------------------------
function devuelveRegistroDeCanales(){

    $query = $this->db->get("consulta_comercial_usuario_canal");

    return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------------------------
function devuelveTipoComision($canal){

    //$this->db->where("canal", $canal);
    //$query = $this->db->get("consulta_comercial_tipo_comision");
    $this->db->from("consulta_comercial_relacion_canal_tipo_comision a");
    $this->db->join("consulta_comercial_tipo_comision b", "a.idTipoComision=b.idTipoComision", "inner");
    $this->db->where("a.idUsuarioCanal", $canal);
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------------------
function devuelveCanalConsultaComercial(){
    
    $this->db->from("consulta_comercial_relacion_canal_tipo_comision a");
    $this->db->join("consulta_comercial_usuario_canal b", "a.idUsuarioCanal=b.idUsuarioCanal", "inner");
    $this->db->join("consulta_comercial_tipo_comision c", "a.idTipoComision=c.idTipoComision", "inner");
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------------------
function devuelveComisionComercial($c, $b, $m){
   
    $this->db->from("consulta_comercial_registro a");
    $this->db->join("consulta_comercial_comision b", "b.idComision = a.idComision", "inner");
    $this->db->where("a.activo", 1);
    $this->db->where("a.idUsuarioCanal", $c);
    $this->db->where("b.id_tipo", $b);
    $this->db->where("b.mes", $m);
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->row() : array();
}
//-------------------------------------------
function devuelveCanalEspecifico($arr_){

    //$this->db->where("correo", $arr_["correo"]);
    //$query = $this->db->get("consulta_comercial_usuario_canal");
    $this->db->from("consulta_comercial_relacion_canal_tipo_comision a");
    $this->db->join("consulta_comercial_usuario_canal b", "a.idUsuarioCanal=b.idUsuarioCanal", "inner");
    $this->db->join("consulta_comercial_tipo_comision c", "a.idTipoComision=c.idTipoComision", "inner");
    $this->db->where("b.correo", $arr_["correo"]);
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------------------
function devuelveTipoComisionConsultaComercial(){

    $query = $this->db->get("consulta_comercial_tipo_comision");

    return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------------------------
function sumatoriaDeComisionConsultaComercial($m,$t){

    $this->db->select_sum("comision");
    $this->db->from("consulta_comercial_registro a");
    $this->db->join("consulta_comercial_comision b", "a.idComision=b.idComision", "inner");
    $this->db->where("a.activo", 1);
    $this->db->where("b.id_tipo", $t);
    $this->db->where("b.mes", $m);
    $query = $this->db->get();
    //$this->db->;
    return $query->num_rows() > 0 ? $query->row() : array();
}
//-----------------------------------------
function getSecondGoal($email){

    $this->db->from("registro_meta_mensual_ramo_coordinador_generico a");
    $this->db->join("users b", "a.idPersona = b.idPersona", "inner");
    $this->db->where("b.email", strtoupper($email));
    //$this->db->where("a.mes_asignado", 5);
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->result() : array();
}
//-----------------------------------------
function getProgressSecondGoal($email){

    $this->db->from("meta_usuario_canal a");
    $this->db->join("meta_canal_ramo b", "a.canal = b.canal", "inner");
    $this->db->join("meta_registro_avance_cantidad_y_prima c", "c.idCanalRamo = b.idCanalRamo", "inner");
    $this->db->where("a.correo", $email);
    $this->db->order_by("c.idRegistro", "desc");
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->result() : array();
}
function getCategoryProgress($email, $ramo, $mes){

    $this->db->from("meta_usuario_canal a");
    $this->db->join("meta_canal_ramo b", "a.canal = b.canal", "inner");
    $this->db->join("meta_registro_avance_cantidad_y_prima c", "c.idCanalRamo = b.idCanalRamo", "inner");
    $this->db->where("a.correo", $email);
    $this->db->where("b.ramo", $ramo);
    $this->db->where("MONTH(c.fechaRegistro)", $mes);
    $this->db->order_by("c.idRegistro", "desc");
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->row() : array();
}
//-----------------------------------------
/*function devuelveInfoMC_respaldo(){

    $resultado=array();

    $this->db->where("anio",date("Y"));
    $query=$this->db->get("metacomercial");
    //$this->db->from("metacomercial")
      //      ->join("metapormes","metacomercial.idMetaComercial=metapormes.idMetaComercial","inner");
    //$query=$this->db->get(); 

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;
}*/
//---------------------------------------------------------
/*function eliminarRegistroDeMeta_respaldo($idMeta, $anio){

    $tablas=array("metacomercial","metapormes");

    $resultado=false;

    $this->db->where("idMetaComercial",$idMeta)
            ->where("anio",$anio)
            ->delete($tablas);

    if($this->db->trans_status()===FALSE){
        $this->db->trans_rollback();
    } else{
        $this->db->trans_commit();
        $resultado=true;
    }

    return $resultado;
}*/
//------------------------------------------------------------
/*function obtenerMensualidadesDeMeta_respaldo($meta,$idPersona){

    $resultado=array();

   $this->db->where("idMetaComercial",$meta);
   $this->db->where("anio",date("Y"));
   $query=$this->db->get("metapormes");

    if($query->num_rows()>0){
        $resultado=$query->result();
    }

    return $resultado;
}*/
//--------------------------------------------
/*function contador_registros_metas_ramo_agentes($mes,$ramo,$coor){

    $resultado=array();

    $this->db->select_sum("cantidad_polizas");
    $this->db->select_sum("prima_polizas");
    $this->db->where("anio", date("Y"));
    $this->db->where("mes_asignado", $mes);
    $this->db->where("ramo", $ramo);
    $this->db->where("idCoor", $coor);
    $query=$this->db->get("registro_meta_mensual_ramo_agente_generico");

    if($query->num_rows()>0){

        $resultado=$query->row();
    }

    return $resultado;
}*/
//---------------------------------------------
/*function devuelveinfopersona($correo){

    $resultado=array();

    $this->db->from("persona");
    $this->db->join("users","users.idPersona=persona.idPersona","left");
    $this->db->where("persona.bajaPersona",0);
    $this->db->where("users.activated",1);
    $this->db->where("users.banned",0);
    $this->db->where("users.email",$correo);
    $query=$this->db->get();

    if($query->num_rows()>0){
        $resultado=$query->row();
    }

    return $resultado;

}*/
//--------------------------------------------
/*function rellena_campo_cumple($id){

    $this->db->where("idPersona",$id);
    $this->db->set("fechaNacimiento","0000-00-00");
    $this->db->update("persona");

}*/
//--------------------------------------------
/*function actualizaFechaCumpleParcial($correo,$fechas){

    $fecha__=$this->devuelveinfopersona($correo);
    $array_f=explode("-",$fecha__->fechaNacimiento);
    $d_m_act="-".$fechas["mes"]."-".$fechas["dia"];


    $update_query="UPDATE capsysV3.persona
        LEFT JOIN capsysV3.users ON users.idPersona=persona.idPersona
        SET fechaNacimiento=CONCAT(REPLACE('".$array_f[0]."', fechaNacimiento,''),'".$d_m_act."')
        WHERE persona.bajaPersona=0 AND users.activated=1 AND users.banned=0 AND users.email='".$correo."';";

    $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($update_query."\n",TRUE));fclose($fp);

    $this->db->query($update_query);
}*/
//--------------------------------------------
}
?>