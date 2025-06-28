<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class siniestros_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function tablaSiniestros($clientes){//añadir cliente y aseguradora
        $SQL ="SELECT sr.*,se.nombre estatus,sc.nombre causa_nombre,st.nombre tipo_nombre, sa.nombre autoridad_nombre,sga.nombre segunAutoridad, sgj.nombre segunAjustador, ce.estado Estado,i.dias parametro,TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()) progreso,
        tramite.id id_tramite,sta.nombre nombre_tramite, sta.id tipo_tramite, tramite.estatus tram_estatus, tramite.fecha_inicio tram_ini, setr.nombre tram_est_nom,setr.color tram_est_col, setr.valores tram_close,(select nt.color from siniestro_estatus_tramites nt where sr.siniestro_estatus=nt.nombre) siniestro_color,
        tramite.valores json_tram, YEAR(sr.inicio_ajuste) ano_filtro,tramite.fecha_fin tram_fin,if(tramite.fecha_inicio IS NULL, sr.inicio_ajuste,tramite.fecha_inicio) fecha_filtro
        FROM siniestro_reportes sr
        left join siniestro_estatus se on sr.status_id=se.id
        left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
        left join siniestro_causa sc on sr.causa_siniestro_id=sc.id
        left join siniestro_tipoautoridad sa on sr.autoridad_id=sa.id
        left join siniestro_segun_autoridad sga on sr.responsable_autoridad=sga.id
        left join siniestro_segun_ajustador sgj on sr.responsable_autoridad=sgj.id
        left join (select * from indicadores i where cliente_id=0) as i on sr.tipo_siniestro_id=i.causa_id
        left join catalog_estados ce on sr.estado_id=ce.clave
        left join siniestro_tramite tramite on sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)
        left join siniestro_tramite_autos sta on tramite.tipo_tramite=sta.id
        left join siniestro_estatus_tramites setr on tramite.estatus=setr.id
        where sr.cliente_id in ".$clientes."  
        group by sr.id
        order by sr.fecha_ocurrencia desc";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        foreach ($row as $key => $value) {
            $Sestatus=json_decode($value["json_tram"],true);
            $row[$key]["Estatus_Reparacion"]= isset($Sestatus["Estatus_Reparacion"])? $Sestatus["Estatus_Reparacion"]: "N/A";
        }
        //AND sr.fecha_ocurrencia > '2022-01-01'
        //var_dump($row);
        return $row;
    }

    function get_single_siniestro_all($id){
        $SQL ="SELECT sr.*,se.nombre estatus,sc.nombre causa_nombre,st.nombre tipo_nombre, sa.nombre autoridad_nombre,sga.nombre segunAutoridad, sgj.nombre segunAjustador
        FROM siniestro_reportes sr
        left join siniestro_estatus se on sr.status_id=se.id
        left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
        left join siniestro_causa sc on sr.causa_siniestro_id=sc.id
        left join siniestro_tipoautoridad sa on sr.autoridad_id=sa.id
        left join siniestro_segun_autoridad sga on sr.responsable_autoridad=sga.id
        left join siniestro_segun_ajustador sgj on sr.responsable_autoridad=sgj.id
        where sr.cabina_id=".$id."
        order by sr.fecha_ocurrencia desc;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    }

    function getSingleSiniestro($id){
        $tipos = $this->db
        ->where("cabina_id", $id)
        ->get('siniestro_reportes');
        return $tipos->result_array();
    }

    function getAllestatus(){
        $tipos = $this->db->get('siniestro_estatus');
        return $tipos->result_array();
    }

    function insertSiniestro($data)
    {
        $this->db->insert('siniestro_reportes', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function insertUpdate($data)
    {
        $this->db->insert('siniestro_update', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function updateSiniestro($id,$data){
        $this->db->where('id', $id);
        $res = $this->db->update('siniestro_reportes', $data);
        return $res;
    }
    function updateSiniestroWS($id,$data){
        $this->db->where('cabina_id', $id);
        $res = $this->db->update('siniestro_reportes', $data);
        return $res;
    }

    function find_id_siniestro($id){
        $tipos = $this->db
        ->where("cabina_id", $id)
        ->get('siniestro_reportes');
        if (!empty($tipos->result_array())){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function find_id_Notificacion($id){
        $tipos = $this->db
        ->where("id", $id)
        ->get('siniestro_reportes');
        $row=[];
        if (!empty($tipos->result_array())){
            $row=$tipos->result_array();
        }
        return $row;
    }

    function getAll_siniestros_Update(){
        $SQL ="SELECT * FROM siniestro_reportes sr where sr.status_id IN (1,2) and sr.tipo_actualizacion='SERVICIO';";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    }

    function getlastUpdate($clientes){
        $SQL ="SELECT * FROM siniestro_update sr where sr.aseguradora_id IN ".$clientes." order by fecha DESC;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0]["fecha"];
        }
        else{
            return "No existe ninguna actualizacion";
        }
    }

    function get_siniestros_bitacora($id){
        $tipos = $this->db
        ->order_by('modificado', 'DESC')
        ->where("siniestro_id", $id)
        ->get('siniestro_bitacora');
        return $tipos->result_array();
    }
    /// llamadas del formulario de siniestros
    function tiposiniestro(){
        //$tipos = $this->db->get('siniestro_tipo');
        $this->db->select('st.nombre,st.id');
        $this->db->where('sr.tipo_actualizacion','SERVICIO');
        $this->db->join("siniestro_tipo st","sr.tipo_siniestro_id=st.id","inner");
        $this->db->group_by("st.id")->order_by('st.nombre','ASC');
        $tipos = $this->db->get('siniestro_reportes sr');
        return $tipos->result_array();
    }

    function causasiniestro(){
        $tipos = $this->db->get('siniestro_causa');
        return $tipos->result_array();
    }
    function autoridadPresente(){
        $tipos = $this->db->get('siniestro_tipoautoridad');
        return $tipos->result_array();
    }
    function siniestros_estatus(){
        $tipos = $this->db->get('siniestro_estatus');
        return $tipos->result_array();
    }

    function segunAjyAs(){
        $tipos = $this->db->get('siniestro_segun_ajustador');
        return $tipos->result_array();
    }
    ///Fin//

    function insert_siniestro_bitacora($data){
        $this->db->insert('siniestro_bitacora', $data);
        $insert_id = $this->db->insert_id();
    }

    /* function grafica_siniestro_estatus(){
        $SQL ="SELECT se.id as tipo_incidencias_id, count(sr.status_id) total, se.nombre
        from siniestro_estatus se
        left join siniestro_reportes sr  on se.id=sr.status_id
        GROUP BY sr.status_id";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    } */

    function grafica_siniestro_estatus($clientes,$mes,$año){
        $alldata=array();
        $estados=array(array("id"=>1,"nombre"=>"EN TRAMITE"),array("id"=>2,"nombre"=>"AVISADO"),array("id"=>3,"nombre"=>"CONDICIONADO"),array("id"=>4,"nombre"=>"LIQUIDADO"),array("id"=>5,"nombre"=>"SIN ESTATUS"),array("id"=>6,"nombre"=>"PENDIENTE"),array("id"=>7,"nombre"=>"FINALIZADO"));
        foreach ($estados as $key => $value) {
            if($value["id"]!=5){
                $SQL ="select ".$value["id"]." tipo_incidencias_id, IFNULL(SUM(sr.complemento_json REGEXP 'EstatusSiniestro\":\"".$value['nombre']."'),0) total, '".$value["nombre"]."' nombre 
                from siniestro_reportes sr where sr.status_id!=5 and sr.cliente_id in ".$clientes." and YEAR(sr.fecha_repote) =".$año." and month(sr.fecha_repote) =".$mes;
            }else{
                $SQL ="select ".$value["id"]." tipo_incidencias_id, IFNULL(SUM(sr.complemento_json='' or sr.complemento_json is null),0) total, '".$value["nombre"]."' nombre 
                from siniestro_reportes sr where sr.status_id!=5 and sr.cliente_id in ".$clientes." and YEAR(sr.fecha_repote) =".$año." and month(sr.fecha_repote) =".$mes;
            }
            $query = $this->db->query($SQL);
            if ($query->num_rows() > 0) {
                $row = $query->result_array();
                
            }
            array_push($alldata,$row[0]);
        }
        return $alldata;
    }

    function grafica_siniestro_estados($mes,$año,$clientes){
        $arrayE=array();
        $SQL ="SELECT count(sr.cabina_id) as total,ce.estado as nombre,sr.estado_id as estado
        FROM siniestro_reportes sr,catalog_estados ce WHERE YEAR(sr.fecha_repote) =".$año." and month(sr.fecha_repote) =".$mes."
        and sr.estado_id=ce.clave and sr.status_id!=5 and sr.cliente_id in ".$clientes." GROUP BY sr.estado_id order by total desc limit 5";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        if($row!=[]){
            foreach ($row as $key => $value) {
                array_push($arrayE,intval($value["estado"]));
            }
            $otros=$this->get_all_estados_OtroRango($arrayE,$año,$mes);
            $row[]=array("total"=>$otros[0]["total"],"nombre"=>"Otros estados","estado"=>"");
        }
        
        //var_dump($$SQL);
        return $row;
    }

    function get_all_estados_OtroRango($rango,$año,$mes){
        $dt="";
        foreach ($rango as $key => $value) {
            $dt==""?$dt=$value:$dt=$dt.",".$value;
        }
        $SQL ="SELECT count(sr.cabina_id) as total
        FROM siniestro_reportes sr WHERE YEAR(sr.fecha_repote)=".$año." and month(sr.fecha_repote)=".$mes."
        and sr.estado_id NOT IN (".$dt.")";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    }

    function get_siniestros_per_Year($año,$clientes){
        $SQL ="SELECT count(month(sr.fecha_repote)) as total, month(sr.fecha_repote) as mes,MONTHNAME(sr.fecha_repote) name
        FROM siniestro_reportes sr WHERE YEAR(sr.fecha_repote) = ".$año." and sr.status_id!=5 and sr.cliente_id in ".$clientes."
        GROUP BY month(sr.fecha_repote)";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    }

    function get_siniestros_Liquidados($año, $clientes){
        $SQL ="SELECT IFNULL(SUM(sr.complemento_json REGEXP '\"EstatusSiniestro\":\"LIQUIDADO\"|\"EstatusSiniestro\":\"FINALIZADO\"'),0) as total, month(sr.fecha_repote) as mes,MONTHNAME(sr.fecha_repote) name
        FROM siniestro_reportes sr WHERE YEAR(sr.fecha_repote) = ".$año." and sr.status_id!=5 and sr.cliente_id in ".$clientes."
        GROUP BY month(sr.fecha_repote)";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function get_siniestros_per_MontAndYear($año,$mes,$clientes){
        $SQL ="SELECT count(month(sr.fecha_repote)) as total, month(sr.fecha_repote) as mes,MONTHNAME(sr.fecha_repote) name
        from siniestro_reportes sr WHERE month(sr.fecha_repote)=".$mes." and YEAR(sr.fecha_repote) = ".$año." and sr.status_id!=5 and sr.cliente_id in ".$clientes."
        GROUP BY month(sr.fecha_repote)";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    }
/* 
    function allsiniestros(){
        $SQL ="select count(sr.cabina_id) as total, SUM(sr.status_id = 3||sr.status_id =4) Cerrado,SUM(sr.status_id = 1) Activos,SUM(sr.status_id = 5) Cancelados,SUM(sr.status_id = 2) Edicion   from siniestro_reportes sr";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    } */
    function allsiniestros($clientes){
        $SQL="select count(sr.cabina_id) as total,";
        $allEstatus=$this->get_estatusSiniestros();
        $cantidad=count($allEstatus);
        $contador=0;
        foreach ($allEstatus as $valor) {
            $contador++;
            if($contador<$cantidad){
                $SQL=$SQL."IFNULL(SUM(sr.siniestro_estatus='".$valor["nombre"]."'),0)'".$valor["nombre"]."',";
            }else{
                $SQL=$SQL."IFNULL(SUM(sr.siniestro_estatus='".$valor["nombre"]."'),0)'".$valor["nombre"]."' ";
            }
       }
       $SQL=$SQL.",IFNULL(SUM(sr.siniestro_estatus is null),0)'N/A' ";
       $SQL=$SQL." from siniestro_reportes sr where sr.cliente_id IN ".$clientes;
       $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function get_all_Causas(){
        $SQL ="SELECT st.nombre Tipo,sc.nombre causa,sc.id FROM siniestro_causa sc
        left join siniestro_tipo st on sc.tipo_siniestro_id=st.id";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function get_all_estatus(){
        $SQL ="select * from siniestro_estatus";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function get_all_count_estatus($year,$clientes){
        $allCausas=$this->get_all_Causas();
        //$allEstatus=$this->get_all_estatus();
        $allEstatus=$this->get_estatusSiniestros();
        $rowFull=array();
        foreach ($allCausas as $value) {
            $SQL="select CONCAT_WS('-',st.nombre,sc.nombre) CAUSA";
            //$last_key = end(array_keys($allEstatus));
           foreach ($allEstatus as $valor) {
                $SQL=$SQL.",IFNULL(SUM(sr.siniestro_estatus='".$valor["nombre"]."'),0)"."\"".$valor["nombre"]."\"";
                /* if ($key == $last_key) {
                    $SQL=$SQL.",IFNULL(SUM(sr.siniestro_estatus is NULL),0)";
                } */
           }
           $SQL=$SQL.",IFNULL(SUM(sr.siniestro_estatus is null),0) 'N/A' ";
           $SQL=$SQL.",count(sr.cabina_id) as TOTAL from siniestro_reportes sr
            left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
            left join siniestro_causa sc on sr.causa_siniestro_id=sc.id
            where sr.causa_siniestro_id=".$value["id"]." and YEAR(sr.fecha_repote) =".$year." and sr.cliente_id in ".$clientes; 
           $row = [];
           $query = $this->db->query($SQL);
           if ($query->num_rows() > 0) {
               $row = $query->result_array();
           }
           if($row[0]["TOTAL"]!=0){
            array_push($rowFull,$row[0]);
           }
        }
        return $rowFull;
    }


    function get_rango(){
        $tipos = $this->db->get('siniestro_rango');
        if(empty($tipos->result_array())){
             return array(array("id"=>"0","rango"=>"Ningún rango ha sido agregado","aseguradora_id"=>"0"));
         }else{
             return $tipos->result_array();
         }
    }

    /* function get_rango_table($year){
        $arrayRango=$this->get_rango();
        $lastkey=end($arrayRango);
        $row=[];
        $returnArray=array();
        $porcentajes=array();
        $SQL="SELECT ";
        foreach ($arrayRango as $key => $value) {
            if($key==0){
            $SQL=$SQL."SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, sr.fin_ajuste)>=0 and TIMESTAMPDIFF(DAY, sr.fecha_repote, sr.fin_ajuste)<=".$value["rango"].")"."\""."0-".$value["rango"]."\",";
            }elseif($lastkey["id"]==$value["id"]){
                $SQL=$SQL."SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, sr.fin_ajuste)>=".($arrayRango[$key-1]["rango"]+1)." and TIMESTAMPDIFF(DAY, sr.fecha_repote, sr.fin_ajuste)<=".$value["rango"].")"."\"".($arrayRango[$key-1]["rango"]+1)."-".$value["rango"]."\",";
                $SQL=$SQL."SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, sr.fin_ajuste)>".$value["rango"].")\""."Mas de ".$value["rango"]."\"".",count(sr.status_id) Total ";
            }else{
                $SQL=$SQL."SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, sr.fin_ajuste)>=".($arrayRango[$key-1]["rango"]+1)." and TIMESTAMPDIFF(DAY, sr.fecha_repote, sr.fin_ajuste)<=".$value["rango"].")"."\"".($arrayRango[$key-1]["rango"]+1)."-".$value["rango"]."\",";
            }
        }
        $SQL=$SQL."FROM siniestro_reportes sr where sr.status_id!=5 and YEAR(sr.fecha_repote) =".$year;
        $query = $this->db->query($SQL);
           if ($query->num_rows() > 0) {
               $row = $query->result_array();
        }
        $total=$row[0]["Total"];
        foreach ($row[0] as $keys => $valor) {
            $porcentajes[$keys]=round(($valor*100)/$total,3)."%";
        }
        $returnArray[]=$row[0];
        $returnArray[]=$porcentajes;
        return $returnArray;
    } */
    function get_rango_table($year,$clientes){
        date_default_timezone_set('UTC');
        $arrayRango=$this->get_rango();
        $lastkey=end($arrayRango);
        $row=[];
        $returnArray=array();
        $porcentajes=array();
        $today=date("Y-m-d");
        if(!empty($arrayRango)&& count($arrayRango)>1){
            $SQL="SELECT ";
            foreach ($arrayRango as $key => $value) {
                if($key==0){
                $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=0 and TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=".$value["rango"]."),0)"."\""."0-".$value["rango"]."\",";
                }elseif($lastkey["id"]==$value["id"]){
                    $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=".($arrayRango[$key-1]["rango"]+1)." and TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=".$value["rango"]."),0)"."\"".($arrayRango[$key-1]["rango"]+1)."-".$value["rango"]."\",";
                    $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>".$value["rango"]."),0)\""."Mas de ".$value["rango"]."\"".",count(sr.status_id) Total ";
                }else{
                    $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=".($arrayRango[$key-1]["rango"]+1)." and TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=".$value["rango"]."),0)"."\"".($arrayRango[$key-1]["rango"]+1)."-".$value["rango"]."\",";
                }
            }
            //esto se quito and sr.complemento_json REGEXP 'AVISADO|CONDICIONADO|EN TRAMITE|LIQUIDADO|PENDIENTE'
            $SQL=$SQL."FROM siniestro_reportes sr where YEAR(sr.fecha_repote) =".$year." and sr.cliente_id in ".$clientes." ;";
        }elseif(count($arrayRango)==1){
            if($arrayRango[0]["rango"]=="Ningún rango ha sido agregado"){
                //esto se quito and sr.complemento_json REGEXP 'AVISADO|CONDICIONADO|EN TRAMITE|LIQUIDADO|PENDIENTE'
                $SQL="SELECT IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>1),0) 'Ningún rango ha sido agregado',count(sr.status_id) Total FROM siniestro_reportes sr where YEAR(sr.fecha_repote) =".$year." and sr.cliente_id in ".$clientes." ;";
            }else{
                $SQL=" SELECT IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=".($arrayRango[0]["rango"]+1)." and TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=".$arrayRango[0]["rango"]."),0)"."\"".(0)."-".$arrayRango[0]["rango"]."\",";
                $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>".$arrayRango[0]["rango"]."),0)\""."Mas de ".$arrayRango[0]["rango"]."\"".",count(sr.status_id) Total ";
                //esto se quito and sr.complemento_json REGEXP 'AVISADO|CONDICIONADO|EN TRAMITE|LIQUIDADO|PENDIENTE'
                $SQL=$SQL."FROM siniestro_reportes sr where YEAR(sr.fecha_repote) =".$year." and sr.cliente_id in ".$clientes." ;";
            }
            
        }
            $query = $this->db->query($SQL);
            if ($query->num_rows() > 0) {
                $row = $query->result_array();
            }
            $total=$row[0]["Total"];
            foreach ($row[0] as $keys => $valor) {
                if($valor!=0){
                    $porcentajes[$keys]=round(($valor*100)/$total,3)."%";
                }else{
                    $porcentajes[$keys]="0"."%";
                }
            }
            $returnArray[]=$row[0];
            $returnArray[]=$porcentajes;
        
        return $returnArray;
    }

    function table_estatus_meses($año,$clientes){
        //$estatus=$this->siniestros_estatus();
        //$estatus=array("AVISADO","CONDICIONADO", "EN TRAMITE", "LIQUIDADO","FINALIZADO");
        $estatus=$this->get_estatusSiniestros();
        $tabla=array();
        foreach ($estatus as $key => $value) {
            $result=$this->get_meses_estatus($año,$value["nombre"],$clientes);
            array_push($tabla,$result[0]);
        }
        $result=$this->get_meses_estatus($año,"N/A",$clientes);
        array_push($tabla,$result[0]);
        return $tabla;
    }

    function get_meses_estatus($año,$estatus,$clientes){
        $SQL ="SELECT ('".$estatus."') Estatus,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 1 THEN 1 ELSE 0 END),0) AS Ene,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 2 THEN 1 ELSE 0 END),0) AS Feb,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 3 THEN 1 ELSE 0 END),0) AS Mar,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 4 THEN 1 ELSE 0 END),0) AS Abr,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 5 THEN 1 ELSE 0 END),0) AS May,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 6 THEN 1 ELSE 0 END),0) AS Jun,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 7 THEN 1 ELSE 0 END),0) AS Jul,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 8 THEN 1 ELSE 0 END),0) AS Ago,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 9 THEN 1 ELSE 0 END),0) AS Sep, 
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 10 THEN 1 ELSE 0 END),0) AS Oct,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 11 THEN 1 ELSE 0 END),0) AS Nov,
        IFNULL(SUM(CASE WHEN MONTH(sr.fecha_repote) = 12 THEN 1 ELSE 0 END),0) AS Dic,
        count(sr.cabina_id) as Total
        FROM siniestro_reportes sr WHERE YEAR(sr.fecha_repote) =".$año." and sr.cliente_id in ".$clientes;

        if($estatus!='N/A'){
            $SQL=$SQL."and sr.siniestro_estatus='".$estatus."';";
        }else{
            $SQL=$SQL."and sr.siniestro_estatus is NULL;";
        }
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    ///consultas de siniestros rangos
    function rango_add($data){
        $this->db->insert('siniestro_rango', $data);
        $insert_id = $this->db->insert_id();
    }
    function rango_delete($id){
        $this->db->where('id', $id);
        $this->db->delete('siniestro_rango');
    }
    function rango_getLastRow($id){
        $SQL ="select sr.id, max(sr.rango) rango from siniestro_rango sr where sr.aseguradora_id=".$id;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row[0];
    }

    function getAseguradoras(){
        $SQL ="select DISTINCT sa.aseguradora_id id,cp.Promotoria nombre
        from siniestro_servicio_aseguradoras sa 
        left join catalog_promotorias cp on sa.aseguradora_id=cp.idPromotoria";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getClientes(){
        $SQL ="select DISTINCT sa.cliente_id id,sc.nombre nombre
        from siniestro_servicio_aseguradoras sa 
        left join siniestro_clientes sc on sa.cliente_id=sc.id";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getEstados(){
        $SQL ="select convert(ce.clave,UNSIGNED INTEGER)id, ce.estado nombre from catalog_estados ce;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getidManual(){
        $SQL="SELECT sr.cabina_id id FROM siniestro_reportes sr where sr.tipo_actualizacion='MANUAL' order by sr.id;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = intval($query->result_array()[0]["id"])+1;
        }else{
            $row=1;
        }
        return $row;
    }

    function validateServicio($Aseguradora,$cliente,$metodo,$tipo_actualizacion){
        if($metodo!=null && $tipo_actualizacion!=null){
            $SQL ="select * from siniestro_servicio_aseguradoras sa where sa.tipo_actualizacion='".$tipo_actualizacion."' and sa.tipo_metodo='".$metodo."' and sa.aseguradora_id=".$Aseguradora." and sa.cliente_id=".$cliente.";";
        }else{
            $SQL ="select * from siniestro_servicio_aseguradoras sa where sa.cliente_id='".$cliente."' and sa.aseguradora_id=".$Aseguradora." and sa.tipo_actualizacion='".$tipo_actualizacion."'";
        }
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    ///carga de excel
    function updateSiniestro_complement($id,$data){
        $this->db->where('cabina_id', $id);
        $res = $this->db->update('siniestro_reportes', $data);
        return $res;
    }

    function estatusValidacion($id){
        $SQL ="SELECT * from siniestro_reportes sr where sr.cabina_id=".$id." and sr.complemento_json REGEXP 'LIQUIDADO'; ";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }


    //seguimiento de los siniestros

    function insertSeguimiento($data){
        $this->db->insert('seguimiento', $data);
        return $insert_id = $this->db->insert_id();
    }

    function getSeguimiento($id){
        /* $this->db->select("u.name_complete,s.fecha,('COMENTARIO') estatus, s.comentario motivo");
        $this->db->where('referencia_id', $id);
        $this->db->where('referencia', "SINIESTRO");
        $this->db->join("users u", "s.usuario_id=u.idPersona", "inner");
        $tipos = $this->db->get('seguimiento s'); */
        $SQL="select s.comentario,s.fecha_alta fecha_add,setr.nombre,u.name_complete,setr.color,IF(s.causa_id=0, 'SINIESTRO FINIQUITADO', (select sst.nombre from siniestro_tramite_autos sst where sst.id=s.causa_id)) tram_nombre
        from seguimiento s
		left join siniestro_reportes sr on s.referencia_id=sr.id 
		left join siniestro_estatus_tramites setr on s.estatus_id=setr.id
		left join users u on s.usuario_id=u.idPersona
        where s.referencia_id=".$id." and s.referencia='AUTOS_C' order by s.id DESC;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
        //return $tipos->result_array();
    }

    ///actualizacion de las nuevas funcuionalidades 
    function getExcel($clientes,$data){
        /* $SQL ="SELECT sr.cabina_id,sr.ajustador_id,sr.ajustador_nombre,sr.asegurado_nombre,sr.siniestro_id,sr.poliza,sr.certificado,sr.declara_conductor,sr.evento,sr.sub_evento,sr.atencion_lugar,sr.fecha_repote,sr.fecha_ocurrencia,sr.fecha_fin,
        se.nombre estatus,sc.nombre causa_nombre,st.nombre tipo_nombre, sa.nombre autoridad_nombre,sga.nombre segunAutoridad, sgj.nombre segunAjustador, ce.estado Estado,i.dias parametro,TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()) progreso,
        tramite.id id_tramite,sta.nombre nombre_tramite, tramite.estatus tram_estatus, tramite.fecha_inicio tram_ini, setr.nombre tram_est_nom, setr.valores tram_close,
        tramite.valores json_tram
        FROM siniestro_reportes sr
        left join siniestro_estatus se on sr.status_id=se.id
        left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
        left join siniestro_causa sc on sr.causa_siniestro_id=sc.id
        left join siniestro_tipoautoridad sa on sr.autoridad_id=sa.id
        left join siniestro_segun_autoridad sga on sr.responsable_autoridad=sga.id
        left join siniestro_segun_ajustador sgj on sr.responsable_autoridad=sgj.id
        left join indicadores i on st.id=i.causa_id
        left join catalog_estados ce on sr.estado_id=ce.clave
        where sr.cliente_id in ".$clientes." and sr.status_id!=5 and sr.id in (".$data.") group by sr.id order by sr.fecha_ocurrencia desc"; */
        $SQL="SELECT sr.cabina_id,sr.ajustador_id,sr.ajustador_nombre,sr.asegurado_nombre,sr.siniestro_id,sr.poliza,sr.certificado,sr.declara_conductor,sr.evento,sr.sub_evento,sr.atencion_lugar,sr.fecha_repote,sr.fecha_ocurrencia,sr.fecha_fin,
        se.nombre estatus,sc.nombre causa_nombre,st.nombre tipo_nombre, sa.nombre autoridad_nombre,sga.nombre segunAutoridad, sgj.nombre segunAjustador, ce.estado Estado,i.dias parametro,TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()) progreso,sta.nombre nombre_tramite, tramite.fecha_inicio tram_ini, setr.nombre tram_est_nom, setr.valores tram_close,
        tramite.valores json_tram
        FROM siniestro_reportes sr
        left join siniestro_estatus se on sr.status_id=se.id
        left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
        left join siniestro_causa sc on sr.causa_siniestro_id=sc.id
        left join siniestro_tipoautoridad sa on sr.autoridad_id=sa.id
        left join siniestro_segun_autoridad sga on sr.responsable_autoridad=sga.id
        left join siniestro_segun_ajustador sgj on sr.responsable_autoridad=sgj.id
        left join (select * from indicadores i where cliente_id=0) as i on sr.tipo_siniestro_id=i.causa_id
        left join catalog_estados ce on sr.estado_id=ce.clave
        left join siniestro_tramite tramite on sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)
        left join siniestro_tramite_autos sta on tramite.tipo_tramite=sta.id
        left join siniestro_estatus_tramites setr on tramite.estatus=setr.id
        where sr.cliente_id in ".$clientes." and sr.id in (".$data.")  group by sr.id 
        order by sr.fecha_ocurrencia desc ";
        //echo $SQL;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        /* foreach ($row as $key => $value) {
            $Sestatus=json_decode($value["complemento_json"]);
            $row[$key]["estatusSiniesto"]= !empty($Sestatus)? $Sestatus->Siniestro->EstatusSiniestro: "Sin estatus";
        } */
        //var_dump($row);
        return $row;
    }


    //nuevo mestodos de la actualizacion
    function addSeguimiento($data)
    {
        $this->db->insert('seguimiento', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function findStatus($id){
		$tipos = $this->db->where('id',$id)->get('siniestro_reportes');
		$res=$tipos->result_array();
		return empty($res)?'':$res[0]['complemento_json'];
    }
    
    function findStatusNombre($id){
		$tipos = $this->db->where('id',$id)->get('siniestro_estatus_tramites');
		$res=$tipos->result_array();
		return empty($res)?'':$res[0]['nombre'];
    }
    
    function updateAutos($id,$data){
		$this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('siniestro_reportes');
    }
    
    //nuevos metodos para las graficas
    function getReporteTableAutosC($clientes,$ano=null,$mes=null){
        $this->db
        ->select("count(sr.id) Total, 
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))>indicador.dias and setr.valores=1,1,0 )),0)ter_no_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))<=indicador.dias and setr.valores=1,1,0 )),0)ter_en_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))<=indicador.dias and setr.valores is NULL,1,0)),0)pend_en_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))>indicador.dias and setr.valores is NULL,1,0)),0)pend_no_tiempo",false)
        ->join("(select * from indicadores i where cliente_id=0) indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
        ->join("siniestro_estatus setr", "sr.siniestro_estatus=setr.nombre", "left");
        $this->db->where( "sr.tipo_actualizacion", 'SERVICIO');
        $this->db->where("sr.status_id !=",'5');
        $this->db->where_in("sr.cliente_id",$clientes);
        //$this->db->where("sr.tipo_r", 'A');
        if($ano!=null){
            $this->db->where("YEAR(sr.fecha_repote)", $ano);
        }
        if($mes!=null){
            $this->db->where("month(sr.fecha_repote)", $mes);
        }
        $obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
    }

    //metodo para determinar si permite cerrar el siniestro
    function opcionCerrarSiniestro($id){
        $this->db->select("*")->where("id",$id)->where("valores","1");
        $obj=$this->db->get('siniestro_estatus_tramites sr');
        $row=$obj->result_array();

        if(!isset($row[0])){
            return false;
        }else{
            return true;
        }
    }

    function returnLastidNoty(){
        $this->db->select("*")->where("tipo","SINIESTROS")->order_by("id","DESC")->limit(1);
        $obj=$this->db->get('notificacion');
        $row=$obj->result_array();
        if(!isset($row[0])){
            return '0';
        }else{
            return $row[0]['id'];
        }
    }
    function insertLogNotificacion($data){
        $this->db->insert('siniestro_notificacion_log', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getLogIdsiniestros($id){
        $this->db->select("*")->where("id_notificacion",$id);
        $obj=$this->db->get('siniestro_notificacion_log');
        return $obj->result_array();
    }

    //nuevos metodos de la actualizacion de los siniestros

    function getAllestatusT(){
        $this->db->where('activo','1');
        $tipos = $this->db->get('siniestro_estatus_tramites');
        return $tipos->result_array();
    }

    function getTramitesAutos(){
        $obj=$this->db->get('siniestro_tramite_autos');
        return $obj->result_array();
    }

    function insertTramite($data){
        $this->db->insert('siniestro_tramite', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getTramite($id,$siniestro){
        if($id){
            $this->db->select("st.*,(select fecha_ocurrencia from siniestro_reportes where id='".$siniestro."') as fecha_ocurrencia, sr.* ");
            $this->db->where('st.id',$id);
            $this->db->join('siniestro_reportes sr', 'st.id_siniestro=sr.id');
            $obj=$this->db->get('siniestro_tramite st');
        }else{
            $this->db->select("sr.* ");
            $this->db->where('sr.id',$siniestro);
            $obj=$this->db->get('siniestro_reportes sr');
        }
        return $obj->result_array();
    }

    function updateTramite($id,$data){
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('siniestro_tramite');
    }

    function getLlenadoSelect($Tipo){
        $this->db->where('tipo',$Tipo);
        $obj=$this->db->get('siniestros_autos_catalagos');
        return $obj->result_array();
    }
    function insertLogDormido($data){
        $this->db->insert('siniestros_tramite_logs', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function updateTramitelog($idtramite,$data){
        $this->db->set($data);
        $this->db->where('id_registro', $idtramite);
        $this->db->where('estatus',6);
        return $this->db->update('siniestros_tramite_logs');
    }

    function getTramites($id){
		$sql="select st.*, indicador.dias, TIMESTAMPDIFF(DAY, st.fecha_inicio, CURDATE()) progreso,sett.nombre,sett.color,stg.nombre tram_nom
		from siniestro_tramite st 
		left join (select * from indicadores i where cliente_id=0) as indicador on st.tipo_tramite=indicador.causa_id
		left join siniestro_estatus_tramites sett on st.estatus=sett.id
		left join siniestro_tramite_autos stg on st.tipo_tramite=stg.id
		left join tipo_coberturas_gmm tcg on st.cobertura_id=tcg.id
		where id_siniestro=".$id." group BY st.id order by st.id DESC";
		$data=$this->db->query($sql);
        return $data->result_array();
	}

    function getSiniestro($id){
        $SQL ="SELECT sr.*,sp.*,se.nombre estatus,sc.nombre causa_nombre,st.nombre tipo_nombre, sa.nombre autoridad_nombre,sga.nombre segunAutoridad, sgj.nombre segunAjustador,tramite.tipo_tramite
        FROM siniestro_reportes sr
        left join siniestro_estatus se on sr.status_id=se.id
        left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
        left join siniestro_causa sc on sr.causa_siniestro_id=sc.id
        left join siniestro_tipoautoridad sa on sr.autoridad_id=sa.id
        left join siniestro_segun_autoridad sga on sr.responsable_autoridad=sga.id
        left join siniestro_segun_ajustador sgj on sr.responsable_autoridad=sgj.id
        left join siniestro_poliza sp on  sr.poliza=sp.poliza
        left join siniestro_tramite tramite on sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)
        where sr.id=".$id."
        order by sr.fecha_ocurrencia desc;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    }

    function getAllEstados(){
		$tipos = $this->db->get('catalog_estados');
        return $tipos->result_array();
	}

    function updateSiniestroN($id,$data){
        $this->db->where('id', $id);
        $res = $this->db->update('siniestro_reportes', $data);
        return $res;
    }

    function get_estatusSiniestros(){
        $SQL='select id,nombre from siniestro_estatus_tramites where activo="1";';
        $query = $this->db->query($SQL);
        $row = $query->result_array();
        return $row;
    }

    function getConfigGrafica(){
        $config=[];
        $estatus=$this->get_estatusSiniestros();
        foreach ($estatus as $key => $value) {
            $config[$value["nombre"]]=array(
                "titulo" => $value["nombre"],
                "subtitulo" => "",
                "valor" => array(intval($value["id"])),
                "clave" => $value["nombre"]
            );
        }
        return $config;
    }

    
	function getDocuments(){
		$sql="select std.*,stip.nombre documento_nom from siniestro_tramite_documento std
		inner join siniestro_tipo_documento stip on std.id_tipo_documento=stip.id
		where std.modulo=2";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

    	
	function getAllDocumentTramites($id){
		$sql="select * from documentos d where d.referencia_id=".$id;
		$data=$this->db->query($sql);
		return $data->result_array();
	}

    function delete_doc_drive($id){
		$this->db->where('file_id', $id);
		$this->db->delete('documentos');
	}

    function getYearsDocs(){
		$sql="select year(sr.inicio_ajuste) opcion from siniestro_reportes sr where sr.tipo_r='S'
		group by year(sr.inicio_ajuste);";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

     //Nuevos metodos para nuevo registro manual
     function getEstadosN(){
		$tipos = $this->db->get('catalog_estados');
        return $tipos->result_array();
	}

    function getAllData($tabla){
		$tipos = $this->db->get($tabla);
        return $tipos->result_array();
	}
	
	function getAllDataWith($option,$tabla){
		$tipos = $this->db->where('opcion',$option)->get($tabla);
		return $tipos->result_array();
	}

    function getClienteManual(){
        $sql="SELECT cp.Promotoria,sa.*,sc.nombre cliente
        from siniestro_servicio_aseguradoras sa
        left join catalog_promotorias cp on sa.aseguradora_id=cp.idPromotoria
        left join siniestro_clientes sc on sa.cliente_id=sc.id
        WHERE sa.tipo_actualizacion='MANUAL';";
        $data=$this->db->query($sql);
		return $data->result_array();
    }

    function getClienteAseguradoraC($id){
        $sql="select * from siniestro_servicio_aseguradoras sa where id=".$id;
        $data=$this->db->query($sql);
		return $data->result_array();
    }

    function getNameTipoCausaSiniestro($id,$tabla){
        $tipo= $this->db->where('id',$id)->get($tabla);
        return $tipo->row_array();

    }

    function existPoliza($id){
		$tipos = $this->db->where('poliza',$id)
		->get('siniestro_poliza');
		$res=empty($tipos->result_array())?false:true;
        return $res;
	}

    function insert_poliza($data){
		$this->db->insert('siniestro_poliza', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

    function getTipoTramite($id){
        $tipo= $this->db->where('id',$id)->get('siniestro_tramite');
        return $tipo->row_array();
    }

    function validateid($tipo,$id){
        $tabla="";
        if($tipo=="1"){
            $tabla="siniestro_reportes";
            $this->db->where("cabina_id",$id);
        }else{
            $tabla="siniestro_tramite";
            $this->db->where("folio_cia",$id);
        }
        $tipo= $this->db->get($tabla);
        return $tipo->row_array();
    }

	//----------------------------- //Dennis Castillo [2022-01-18]
	function insertRecordSafely($table, $data){

		$response["lastId"] = 0;
		$response["bool"] = false;

		$this->db->trans_begin();
		$this->db->insert($table, $data);
		$response["lastId"] = $this->db->insert_id();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$response["bool"] = true;
		}

		return $response;
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function insertMultipleRecordSafely($table, $data){

		//$response["lastId"] = 0;
		$response["bool"] = false;

		$this->db->trans_begin();
		$this->db->insert_batch($table, $data);
		//$response["lastId"] = $this->db->insert_id();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$response["bool"] = true;
		}

		return $response;
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function updateRecordSafely($table, $condition, $data){

		$response["bool"] = false;
		$this->db->trans_begin();
		$this->db->update($table, $data, $condition);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$response["bool"] = true;
		}

		return $response;
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function getNotes($id){

		$query = $this->db->where("idSinister", $id)
							->get("sininisterNotes");
		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function getAllDataNote($id = null){
		$this->db->select("a.id, f.nombre tipo_siniestro_nombre,  e.email,  note, dateCreate, idSinister, dateCreate, creator, b.idPersona, nombres, apellidoPaterno, apellidoMaterno, poliza, siniestro_id, asegurado_nombre, tipo_r")
			->join("sinisterNotesAssigned b", "b.idNote = a.id", "inner")
			->join("persona c", "c.idPersona = b.idPersona", "left")
			->join("siniestro_reportes d", "d.id = a.idSinister", "inner")
			->join("users e", "c.idPersona = e.idPersona", "left")
			->join("siniestro_tipo f", "d.tipo_siniestro_id = f.id", "left");
			
			if(!empty($id)){
				$this->db->where("a.idSinister", $id);
			}
		$query = $this->db->order_by("dateCreate", "desc")->get("sininisterNotes a");

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function deleteNoteSafely($table, $where){

		$response = false;
		$this->db->trans_begin();
		$this->db->where($where);
		$this->db->delete($table);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$response = true;
		}

		return $response;
	}
	//--------------------------- //Dennis Castillo [2022-01-18]
	function getAssigned($id){

		$query = $this->db->where("idNote", $id)
				->get("sinisterNotesAssigned");

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//--------------------------- //Dennis Castillo [2022-01-18]
	function getNote($id){

		$query = $this->db->where("id", $id)
				->get("sininisterNotes");

		return $query->num_rows() > 0 ? $query->row() : array();
	}
	//---------------------------

    function getTramiteNuevo($siniestro){
        $sql = "SELECT ultimo_tramite(".$siniestro.") tramite";
        $data = $this->db->query($sql);
        return $data->row_array();
    }

    function updateNewCampo($id,$data){
        $this->db->where('id', $id);
        $res = $this->db->update('siniestro_reportes', $data);
        return $res;
    }

    function getTablaSiniestrosNew($Filtros,$clientes)
    {

        $sql = "SELECT count(id) total FROM siniestro_reportes sr WHERE sr.tipo_r='S' and YEAR(sr.fecha_ocurrencia)='2022'; ";
        $data = $this->db->query($sql);
        $total = $data->row_array();
        $isfiltered = false;

        $this->db->select("sr.*,se.nombre estatus,sc.nombre causa_nombre,st.nombre tipo_nombre, sa.nombre autoridad_nombre,sga.nombre segunAutoridad, sgj.nombre segunAjustador, ce.estado Estado,i.dias parametro,TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()) progreso,
        tramite.id id_tramite,sta.nombre nombre_tramite, sta.id tipo_tramite, tramite.estatus tram_estatus, tramite.fecha_inicio tram_ini, setr.nombre tram_est_nom,setr.color tram_est_col, setr.valores tram_close,(select nt.color from siniestro_estatus_tramites nt where sr.siniestro_estatus=nt.nombre) siniestro_color,
        tramite.valores json_tram, YEAR(sr.inicio_ajuste) ano_filtro,tramite.fecha_fin tram_fin, if(tramite.fecha_inicio IS NULL, sr.inicio_ajuste,tramite.fecha_inicio) fecha_filtro", false);
        $this->db->join("siniestro_estatus se", "sr.status_id=se.id", "left");
        $this->db->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left");
        $this->db->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left");
        $this->db->join("siniestro_tipoautoridad sa", "sr.autoridad_id=sa.id", "left");
        $this->db->join("siniestro_segun_autoridad sga", "sr.responsable_autoridad=sga.id", "left");
        $this->db->join("siniestro_segun_ajustador sgj", "sr.responsable_autoridad=sgj.id", "left");
        $this->db->join("(select * from indicadores i where cliente_id=0) as i", "sr.tipo_siniestro_id=i.causa_id", "left");
        $this->db->join("catalog_estados ce", "sr.estado_id=ce.clave", "left");
        //$this->db->join("siniestro_tramite tramite", "tramite.id=ultimo_tramite(sr.id)", "left");
        $this->db->join("siniestro_tramite tramite", "tramite.id=sr.ultimo_tramite", "left");
        $this->db->join("siniestro_tramite_autos sta", "tramite.tipo_tramite=sta.id", "left");
        $this->db->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");

        //Filtros de la vista
        if ($Filtros["search"] != '') {
            $this->db->like("sr.cabina_id", $Filtros["search"])
                ->or_like("tramite.estatus", $Filtros["search"])
                ->or_like("sr.sub_evento", $Filtros["search"])
                ->or_like("sta.nombre", $Filtros["search"])
                ->or_like("sr.complemento_json", '"economico":"'.$Filtros["search"])
                ->or_like("sr.siniestro_id", $Filtros["search"]);
            $isfiltered = true;
        }
        if ($Filtros["finicio"] != '') {
            $this->db->where('sr.fecha_ocurrencia >=', $Filtros["finicio"]);
            $isfiltered = true;
        }
        if ($Filtros["ffin"] != '') {
            $this->db->where('sr.fecha_ocurrencia <=', $Filtros["ffin"]);
            $isfiltered = true;
        }
        if (isset($Filtros["evento"])) {
            $this->db->where_in('sr.tipo_siniestro_id', $Filtros["evento"]);
            $isfiltered = true;
        }
        if ($Filtros["tipo_tramite"] != '') {
            $this->db->where('tramite.tipo_tramite', $Filtros["tipo_tramite"]);
            $isfiltered = true;
        }
        if ($Filtros["estatus_siniestro"] != '') {
            $this->db->where('sr.siniestro_estatus', $Filtros["estatus_siniestro"]);
            $isfiltered = true;
        }
        if ($Filtros["estatus_tramite"] != '') {
            $this->db->where('setr.nombre', $Filtros["estatus_tramite"]);
            $isfiltered = true;
        }
        if ($Filtros["year"] != '') {
            $this->db->where('YEAR(sr.fecha_ocurrencia)', $Filtros["year"]);
            $isfiltered = true;
        }

        $this->db->where_in("sr.cliente_id",$clientes);
        //$this->db->where_in("sr.cliente_id",array(4,6));
        //$this->db->where('YEAR(sr.fecha_ocurrencia)','2022');
        $this->db->group_by("sr.id");
        $this->db->order_by('sr.fecha_ocurrencia', 'DESC');
        $tipo = $this->db->get("siniestro_reportes sr");




        $offset = $Filtros["start"];
        //$offset=0;
        $dta = $tipo->result_array();


        $test = $this->db->last_query();
        //var_dump($test);
        //log_message('error', $test);

        $dataQ = $this->db->query($test . " LIMIT {$offset}, 10");
        $Rq = $dataQ->result_array();

        foreach ($Rq as $key => $value) {
            $Sestatus = json_decode($value["json_tram"], true);
            $info = json_decode($value["complemento_json"], true);
            $Rq[$key]["certificado"]=isset($info['general']['inciso']) ? $info['general']['inciso'] : 'N/A';
            $Rq[$key]["Estatus_Reparacion"] = isset($Sestatus["Estatus_Reparacion"]) ? $Sestatus["Estatus_Reparacion"] : "N/A";
            $Rq[$key]["Estatus_P"]=isset($Sestatus["Estatus"])? $Sestatus["Estatus"] : "N/A";
            $Rq[$key]["Estatus_D"]=isset($Sestatus["Estatus_Tramite"])? $Sestatus["Estatus_Tramite"] : "N/A";
        }

        $result = array(
            "draw"            => $Filtros["draw"],
            "recordsTotal"    => $total["total"],
            "recordsFiltered" => $isfiltered ? count($dta) : $total["total"],
            "data"            => $Rq,
            "prueba" => $test
        );

        return $result;
    }


}
