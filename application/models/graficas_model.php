<?php
class graficas_model extends CI_Model{
	
	public function __Construct(){
		parent::__Construct();
    }


    ///Evaluaciones
    function getgraficaEvaluacion($periodo)
    {
        if ($periodo == null)
            $periodo = 0;
        $SQL = "SELECT eprs.empleado_id AS empleado,
                AVG(eprs.porcentaje) calificacion,u.name_complete AS nombre
            FROM 
                evaluacion_periodo_respuestas eprs
            INNER JOIN evaluacion_periodo_empleado epe ON eprs.evaluacion_p_e_id = epe.id
            INNER JOIN evaluaciones e ON e.id = epe.evaluacion_id 
            INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id
            inner JOIN persona p ON(p.idpersona =  eprs.empleado_id) inner JOIN users u ON(p.idpersona = u.idpersona)
            WHERE 
                eprs.evaluacion_periodo_id = $periodo
            GROUP BY eprs.empleado_id";
        $query = $this->db->query($SQL);

        return $query->result();
    }

    function getEvaluacionByCompetencia($filtro)
    {

        $empleado = "";
        $puesto = "";
        if (!empty($filtro["puesto"])) {
            $puesto = $filtro["puesto"]["value"];
            $this->db->where("epp.puesto_id = $puesto");
        }
        if (!empty($filtro["colaborador"])) {
            $empleado = $filtro["colaborador"]["value"];
            $this->db->where("epr.empleado_id = $empleado");
        }

        $this->db->select_avg("epr.porcentaje");
        $this->db->select("epr.empleado_id, epp.puesto_id,c.titulo");
        $this->db->join("competencias c", "epr.competencia_id = c.id", "inner");
        $this->db->join("evaluacion_periodos_puesto epp", "epp.evaluacion_periodo_id = epr.evaluacion_periodo_id", "inner");
        $this->db->join("evaluacion_competencias ec", "ec.evaluacion_id = epp.evaluacion_id", "inner");
        $this->db->group_by("c.id");

        $query = $this->db->get("evaluacion_periodo_respuestas epr");

        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result();
        }
        return $row;
    }

    
    function getEvaluacionDesempenio($periodo)
    {
        if ($periodo == null)
            $periodo = 0;
        $SQL = "SELECT
        SUM(case when tmp.calificacion > 85 then 1 else 0 end) mayores,
        SUM(case when tmp.calificacion = 85 then 1 else 0 end) iguales,
        SUM(case when tmp.calificacion < 85 then 1 else 0 end) menores
        FROM (SELECT eprs.empleado_id AS empleado,
                           AVG(eprs.porcentaje) calificacion
                       FROM
                           evaluacion_periodo_respuestas eprs
                       INNER JOIN evaluacion_periodo_empleado epe ON eprs.evaluacion_p_e_id = epe.id
                       INNER JOIN evaluaciones e ON e.id = epe.evaluacion_id
                       INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id
                       inner JOIN persona p ON(p.idpersona =  epe.empleado_id) inner JOIN users u ON(p.idpersona = u.idpersona)
                       WHERE
                           eprs.evaluacion_periodo_id = $periodo
                       GROUP BY eprs.empleado_id) tmp";

        $query = $this->db->query($SQL);

        return $query->result();
    }

    ///Siniestro servicio web
    function grafica_siniestro_estatus($clientes,$mes,$año){
        $alldata=array();
        //$estados=array(array("id"=>1,"nombre"=>"EN TRAMITE"),array("id"=>2,"nombre"=>"AVISADO"),array("id"=>3,"nombre"=>"CONDICIONADO"),array("id"=>4,"nombre"=>"LIQUIDADO"),array("id"=>5,"nombre"=>"SIN ESTATUS"),array("id"=>6,"nombre"=>"PENDIENTE"),array("id"=>7,"nombre"=>"FINALIZADO"));
        $estados=$this->get_estatusSiniestros();
       /*  foreach ($estados as $key => $value) {
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
        } */
        foreach ($estados as $key => $value) {
            $SQL ="select ".$value["id"]." tipo_incidencias_id, IFNULL(SUM(sr.siniestro_estatus='".$value["nombre"]."'),0) total, '".$value["nombre"]."' nombre 
            from siniestro_reportes sr where sr.tipo_actualizacion='SERVICIO' and sr.cliente_id in ".$clientes."  and month(sr.fecha_repote)='".$mes."' and year(sr.fecha_repote)='".$año."';";
            $query = $this->db->query($SQL);
            if ($query->num_rows() > 0) {
                $row = $query->result_array();
                
            }
            array_push($alldata,$row[0]);
        }
        return $alldata;
        //return $alldata;
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
        $SQL ="select count(sr.cabina_id) as total, 
        IFNULL(SUM(sr.complemento_json REGEXP '\"EstatusSiniestro\":\"EN TRAMITE\"'),0)'EN TRAMITE',
        IFNULL(SUM(sr.complemento_json REGEXP '\"EstatusSiniestro\":\"AVISADO\"'),0)'AVISADO',
        IFNULL(SUM(sr.complemento_json REGEXP '\"EstatusSiniestro\":\"CONDICIONADO\"|\"EstatusSiniestro\":\"PENDIENTE\"'),0)'CONDICIONADO',
        IFNULL(SUM(sr.complemento_json REGEXP '\"EstatusSiniestro\":\"LIQUIDADO\"|\"EstatusSiniestro\":\"FINALIZADO\"'),0)'LIQUIDADO',
        IFNULL(SUM(sr.complemento_json is null||sr.complemento_json =''),0)'VACIOS'
        from siniestro_reportes sr where sr.status_id!=5 and sr.cliente_id IN ".$clientes;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
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
        //$allEstatus=array("AVISADO","CONDICIONADO", "EN TRAMITE", "LIQUIDADO");
        $allEstatus=
        $rowFull=array();
        foreach ($allCausas as $value) {
            $SQL="select CONCAT_WS('-',st.nombre,sc.nombre) CAUSA";
           foreach ($allEstatus as $valor) {
                $SQL=$SQL.",IFNULL(SUM(sr.complemento_json LIKE '%".$valor."%'),0)"."\"".$valor."\"";
           }
           $SQL=$SQL.",count(sr.cabina_id) as TOTAL from siniestro_reportes sr
            left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
            left join siniestro_causa sc on sr.causa_siniestro_id=sc.id
            where sr.causa_siniestro_id=".$value["id"]." and sr.status_id!=5 and YEAR(sr.fecha_repote) =".$year." and sr.cliente_id in ".$clientes; 
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
                $SQL="SELECT IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>1),0) 'Ningún rango ha sido agregado',count(sr.status_id) Total FROM siniestro_reportes sr where  YEAR(sr.fecha_repote) =".$year."  and sr.cliente_id in ".$clientes." ;";
            }else{
                $SQL=" SELECT IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=".($arrayRango[0]["rango"]+1)." and TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=".$arrayRango[0]["rango"]."),0)"."\"".(0)."-".$arrayRango[0]["rango"]."\",";
                $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>".$arrayRango[0]["rango"]."),0)\""."Mas de ".$arrayRango[0]["rango"]."\"".",count(sr.status_id) Total ";
                //esto se quito and sr.complemento_json REGEXP 'AVISADO|CONDICIONADO|EN TRAMITE|LIQUIDADO|PENDIENTE'
                $SQL=$SQL."FROM siniestro_reportes sr where YEAR(sr.fecha_repote) =".$year."  and sr.cliente_id in ".$clientes." ;";
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
        $estatus=array("AVISADO","CONDICIONADO", "EN TRAMITE", "LIQUIDADO","FINALIZADO");
        $tabla=array();
        foreach ($estatus as $key => $value) {
            $result=$this->get_meses_estatus($año,$value,$clientes);
            array_push($tabla,$result[0]);
        }
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
        FROM siniestro_reportes sr WHERE YEAR(sr.fecha_repote) =".$año." and  sr.complemento_json like '%".$estatus."%' and sr.cliente_id in ".$clientes;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    ///Ffunciones generales de los siniestros de GMM, AUTOS y Daños

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
    ///Funcion Autos

    //grafica de estatus
    function getAllestatusAutos($year,$moth,$tipo){
        $alldata=array();
        $estatus=$this->get_estatusSiniestros();
        foreach ($estatus as $key => $value) {
            $SQL ="select ".$value["id"]." tipo_incidencias_id, IFNULL(SUM(sr.status_id='".$value["id"]."'),0) total, '".$value["nombre"]."' nombre 
            from siniestro_reportes sr where sr.tipo_r='".$tipo."' and month(sr.inicio_ajuste)='".$moth."' and year(sr.inicio_ajuste)='".$year."';";
            $query = $this->db->query($SQL);
            if ($query->num_rows() > 0) {
                $row = $query->result_array();
                
            }
            array_push($alldata,$row[0]);
        }
        return $alldata;
    }

    //Sniestros por mes de año
    function get_siniestros_per_Year_2($año,$tipo, $liquidado=null){
        if($liquidado==null){
            $SQL ="SELECT count(month(sr.inicio_ajuste)) as total, month(sr.inicio_ajuste) as mes,MONTHNAME(sr.inicio_ajuste) name
            FROM siniestro_reportes sr WHERE YEAR(sr.inicio_ajuste) = ".$año." and sr.tipo_r='".$tipo."' GROUP BY month(sr.inicio_ajuste)";
        }else{
            $SQL ="SELECT count(month(sr.inicio_ajuste)) as total, month(sr.inicio_ajuste) as mes,MONTHNAME(sr.inicio_ajuste) name
            FROM siniestro_reportes sr WHERE YEAR(sr.inicio_ajuste) = ".$año." and sr.tipo_r='".$tipo."' and sr.fecha_fin IS NOT NULL GROUP BY month(sr.inicio_ajuste)";
        }
        //var_dump($SQL);
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function get_siniestros_per_MontAndYear_2($año,$mes,$tipo){
        $SQL ="SELECT count(month(sr.inicio_ajuste)) as total, month(sr.inicio_ajuste) as mes,MONTHNAME(sr.inicio_ajuste) name
        from siniestro_reportes sr WHERE month(sr.inicio_ajuste)=".$mes." and YEAR(sr.inicio_ajuste) = ".$año." and sr.tipo_r='".$tipo."'
        GROUP BY month(sr.inicio_ajuste)";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    }

    function grafica_siniestro_estados_2($mes,$año,$tipo){
        $arrayE=array();
        /* $SQL ="SELECT count(sr.id) as total,ce.estado as nombre,sr.estado_id as estado
        FROM siniestro_reportes sr,catalog_estados ce WHERE YEAR(sr.inicio_ajuste) =".$año." and month(sr.inicio_ajuste) =".$mes."
        and sr.estado_id=ce.clave and sr.tipo_r='".$tipo."' GROUP BY sr.estado_id order by total desc limit 5"; */
        $SQL=" select sr.estado_id estado , count(sr.estado_id) total, (select ce.estado from catalog_estados ce where ce.clave=sr.estado_id limit 1) nombre
        from siniestro_reportes sr where sr.tipo_r='".$tipo."' and YEAR(sr.inicio_ajuste) ='".$año."' and month(sr.inicio_ajuste)='".$mes."' group by sr.estado_id limit 5";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        if($row!=[]){
            foreach ($row as $key => $value) {
                array_push($arrayE,intval($value["estado"]));
            }
            $otros=$this->get_all_estados_OtroRango_2($arrayE,$año,$mes,$tipo);
            $row[]=array("total"=>$otros[0]["total"],"nombre"=>"Otros estados","estado"=>"");
        }
        
        //var_dump($$SQL);
        return $row;
    }

    function get_all_estados_OtroRango_2($rango,$año,$mes,$tipo){
        $dt="";
        foreach ($rango as $key => $value) {
            $dt==""?$dt=$value:$dt=$dt.",".$value;
        }
        $SQL ="SELECT count(sr.id) as total
        FROM siniestro_reportes sr WHERE YEAR(sr.inicio_ajuste)=".$año." and month(sr.inicio_ajuste)=".$mes."
        and sr.estado_id NOT IN (".$dt.") and sr.tipo_r='".$tipo."' ; ";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    }

    //rango de dias de respuesta
    function get_rango_table_2($year, $tipos){
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
                $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=0 and TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),'".$today."'))<=".$value["rango"]."),0)"."\""."0-".$value["rango"]."\",";
                }elseif($lastkey["id"]==$value["id"]){
                    $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=".($arrayRango[$key-1]["rango"]+1)." and TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=".$value["rango"]."),0)"."\"".($arrayRango[$key-1]["rango"]+1)."-".$value["rango"]."\",";
                    $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>".$value["rango"]."),0)\""."Mas de ".$value["rango"]."\"".",count(sr.siniestro_id) Total ";
                }else{
                    $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=".($arrayRango[$key-1]["rango"]+1)." and TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=".$value["rango"]."),0)"."\"".($arrayRango[$key-1]["rango"]+1)."-".$value["rango"]."\",";
                }
            }
            $SQL=$SQL."FROM siniestro_reportes sr where YEAR(sr.inicio_ajuste) =".$year." and sr.tipo_r='".$tipos."';";
        }elseif(count($arrayRango)==1){
            if($arrayRango[0]["rango"]=="Ningún rango ha sido agregado"){
                $SQL="SELECT IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>1),0) 'Ningún rango ha sido agregado',count(sr.siniestro_id) Total FROM siniestro_reportes sr where  YEAR(sr.inicio_ajuste) =".$year." and sr.tipo_r='".$tipos."';";
            }else{
                $SQL=" SELECT IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=".($arrayRango[0]["rango"]+1)." and TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=".$arrayRango[0]["rango"]."),0)"."\"".(0)."-".$arrayRango[0]["rango"]."\",";
                $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>".$arrayRango[0]["rango"]."),0)\""."Mas de ".$arrayRango[0]["rango"]."\"".",count(sr.siniestro_id) Total ";
                $SQL=$SQL."FROM siniestro_reportes sr where YEAR(sr.inicio_ajuste) =".$year." and sr.tipo_r='".$tipos."';";
            }
            
        }
        //var_dump($SQL);
            $query = $this->db->query($SQL);
            if ($query->num_rows() > 0) {
                $row = $query->result_array();
            }
            $total=$row[0]["Total"];
            foreach ($row[0] as $keys => $valor) {
                //echo $valor .'<-val, '.$total.'<-Total'; echo '<br>';
                if($valor!=0 && $total!=0){
                    $porcentajes[$keys]=round(($valor*100)/$total,3)."%";
                }else{
                    $porcentajes[$keys]="0"."%";
                }
            }
            $returnArray[]=$row[0];
            $returnArray[]=$porcentajes;
        
        return $returnArray;
    }

   //Incidencias 

   function tipoincidenciaByFecha($start, $end, $filtro = null)
    {
        $puesto = "";
        $this->db->where("fecha_inicio BETWEEN '$start' AND '$end'");
        if (!empty($filtro["puesto"])) {
            if ($filtro["puesto"] == "-1") {
                $puesto = "";
            } else {
                if ($filtro["puesto"]["value"] >= 0) {
                    $puesto = $filtro["puesto"]["value"];
                }
            }
            if ($puesto != "") {
                $this->db->where("p.idPersonaPuesto", $puesto);
                $this->db->join("persona p", "i.empleado_id = p.idPersona", "inner");
            }
        }

        if (!empty($filtro["colaborador"])) {
            $this->db->where("i.empleado_id", $filtro["colaborador"]["value"]);
        }

        $this->db->select("i.tipo_incidencias_id, COUNT(i.idincidencias) total,ti.nombre");
        $this->db->join("tipo_incidencias ti", "ti.id = i.tipo_incidencias_id", "inner");
        $this->db->group_by("i.tipo_incidencias_id");
        $query = $this->db->get("incidencias i");
        
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }

        return $row;
    }

    function tipoincidenciaByFechaColaborador($start, $end, $filtro = null)
    {
        $colaborador = "";
        $implode = array();
        $array_colaboradores = array();

        $this->db->where("fecha_inicio BETWEEN '$start' AND '$end'");

        if (is_array($filtro["colaborador"])) {
            array_values($filtro["colaborador"]);
            $colaboradores = $filtro["colaborador"];

            foreach ($colaboradores as $value) {
                if (!empty($value["value"])) {
                    array_push($array_colaboradores, $value["value"]);
                } else {
                    $colaborador = $colaboradores["value"];
                    // print_r($colaborador);
                }
            }
        } else {
            $colaborador = $filtro["colaborador"];
            $this->db->where("i.empleado_id", $colaborador);
        }

        if (count($array_colaboradores) > 0) {
            $implode = array_values($array_colaboradores);
            $this->db->where_in("i.empleado_id", $implode);
            $this->db->group_by("i.empleado_id");
        }

        $this->db->select("COUNT(i.idincidencias) total, MONTH(i.fecha_inicio) as fecha, i.empleado_id as empleado,u.name_complete AS nombre");
        $this->db->join("persona p ", "p.idpersona = i.empleado_id", "LEFT");
        $this->db->join("users u ", "p.idpersona = u.idpersona", "LEFT");
        $this->db->group_by("MONTH(i.fecha_inicio)");
        $query = $this->db->get("incidencias i");
        $row = [];
        if ($query->num_rows() > 0) {
            if (count($colaborador) == $query->result()) {
                $row = $query->result();
            } else {
                if (count($array_colaboradores) == $query->result()) {
                    $row = $query->result();
                } else {
                    $row = $query->result();
                }
            }
        }

        return $row;
    }

    function count_bajapersonal($fechaini, $fechafin, $filtro = null)
    {
        if ($filtro != null) {
            if (!empty($filtro["puesto"])) {
                $puesto = $filtro["puesto"]["value"];
                $this->db->where("p.idPersonaPuesto", $puesto);
            }
        }
        $this->db->where("p.tipoPersona = 1 AND p.bajaPersona = 1 AND p.fecha_baja BETWEEN '$fechaini' AND '$fechafin'");
        //$this->db->where("p.fecha_baja BETWEEN '$fechaini' AND '$fechafin' AND p.tipoPersona = 1 ");
        $this->db->select("SUM(CASE WHEN p.bajaPersona = 1 THEN 1 END) AS baja,YEAR(p.fecha_baja) AS anio,DATE_FORMAT(p.fecha_baja,'%Y-%m-%d') as fecha, (SELECT COUNT(p.idpersona) FROM persona p
        WHERE p.tipoPersona = 1) AS total", false);
        $this->db->join("users u ", "u.idpersona = p.idpersona AND u.activated = 1", "inner");
        $this->db->group_by("YEAR(p.fecha_baja)");
        $query = $this->db->get("persona p");
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function group_by($key, $data)
    {
        $result = array();

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }

        return $result;
    }

    //Evaluaciones 

    function activo()
    {
        $obj = $this->db
            ->where("estatus", "CERRADO")
            ->order_by("id DESC")
            ->get('evaluacion_periodos');

        return $obj->row();
    }

    ///funciones para las graficas de GMM
    function getAllStatusGMM($año,$mes,$tipo){
        $alldata=array();
        $estatus=$this->get_estatusSiniestros();
        foreach ($estatus as $key => $value) {
            $SQL ="select ".$value["id"]." tipo_incidencias_id, IFNULL(SUM(st.estatus='".$value["id"]."'),0) total, '".$value["nombre"]."' nombre 
            from siniestro_tramite st
            left join siniestro_reportes sr on st.id_siniestro=sr.id
            where sr.tipo_r='".$tipo."' and YEAR(st.fecha_inicio) ='".$año."' and month(st.fecha_inicio)='".$mes."' ;";
            $query = $this->db->query($SQL);
            if ($query->num_rows() > 0) {
                $row = $query->result_array();
                
            }
            array_push($alldata,$row[0]);
        }
        return $alldata;
    }

    function get_siniestros_per_Year_GMM($año,$tipo, $liquidado=null){
        if($liquidado==null){
            $SQL ="SELECT count(month(st.fecha_inicio)) as total, month(st.fecha_inicio) as mes,MONTHNAME(st.fecha_inicio) name
            FROM siniestro_tramite st  left join siniestro_reportes sr on st.id_siniestro=sr.id WHERE YEAR(st.fecha_inicio) =".$año." and sr.tipo_r='".$tipo."' GROUP BY month(st.fecha_inicio);";
        }else{
            $SQL ="SELECT count(month(st.fecha_inicio)) as total, month(st.fecha_inicio) as mes,MONTHNAME(st.fecha_inicio) name
            FROM siniestro_tramite st  left join siniestro_reportes sr on st.id_siniestro=sr.id left join siniestro_estatus_tramites setr on st.estatus=setr.id
            WHERE YEAR(st.fecha_inicio) =".$año." and sr.tipo_r='".$tipo."' and setr.valores=1 GROUP BY month(st.fecha_inicio);";
        }
        //var_dump($SQL);
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function get_siniestros_per_MontAndYear_Gmm($año,$mes,$tipo){
        $SQL ="SELECT count(month(st.fecha_inicio)) as total, month(st.fecha_inicio) as mes,MONTHNAME(st.fecha_inicio) name
        from siniestro_tramite st left join siniestro_reportes sr on st.id_siniestro=sr.id WHERE month(st.fecha_inicio)=".$mes." and YEAR(st.fecha_inicio) = ".$año." and sr.tipo_r='".$tipo."'
        GROUP BY month(st.fecha_inicio)";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }else{
            $SQL="select 0 as total, month(curdate()) mes, monthname(curdate()) name;";
            $query = $this->db->query($SQL);
            $row = $query->result_array();
        }
        //var_dump($row);
        return $row;
    }

    function grafica_siniestro_estados_GMM($mes,$año,$tipo){
        $arrayE=array();
        $SQL="select sr.estado_id estado , count(sr.estado_id) total, (select ce.estado from catalog_estados ce where ce.clave=sr.estado_id limit 1) nombre
        from siniestro_tramite st left join siniestro_reportes sr on st.id_siniestro=sr.id where sr.tipo_r='".$tipo."' and YEAR(st.fecha_inicio) ='".$año."' and month(st.fecha_inicio)='".$mes."' group by sr.estado_id limit 5";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        if($row!=[]){
            foreach ($row as $key => $value) {
                array_push($arrayE,intval($value["estado"]));
            }
            $otros=$this->get_all_estados_OtroRango_2($arrayE,$año,$mes,$tipo);
            $row[]=array("total"=>$otros[0]["total"],"nombre"=>"Otros estados","estado"=>"");
        }
        
        //var_dump($$SQL);
        return $row;
    }

    function get_rango_table_GMM($year, $tipos){
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
                $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is null,CURDATE()+1,st.fecha_fin))>=0 and TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is null,CURDATE()+1,st.fecha_fin))<=".$value["rango"]."),0)"."\""."0-".$value["rango"]."\",";
                }elseif($lastkey["id"]==$value["id"]){
                    $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is null,CURDATE()+1,st.fecha_fin))>=".($arrayRango[$key-1]["rango"]+1)." and TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is null,CURDATE()+1,st.fecha_fin))<=".$value["rango"]."),0)"."\"".($arrayRango[$key-1]["rango"]+1)."-".$value["rango"]."\",";
                    $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is null,CURDATE()+1,st.fecha_fin))>".$value["rango"]."),0)\""."Mas de ".$value["rango"]."\"".",count(st.id) Total ";
                }else{
                    $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is null,CURDATE()+1,st.fecha_fin))>=".($arrayRango[$key-1]["rango"]+1)." and TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is null,CURDATE()+1,st.fecha_fin))<=".$value["rango"]."),0)"."\"".($arrayRango[$key-1]["rango"]+1)."-".$value["rango"]."\",";
                }
            }
            $SQL=$SQL."from siniestro_tramite st left join siniestro_reportes sr on st.id_siniestro=sr.id where YEAR(st.fecha_inicio) =".$year." and sr.tipo_r='".$tipos."';";
        }elseif(count($arrayRango)==1){
            if($arrayRango[0]["rango"]=="Ningún rango ha sido agregado"){
                $SQL="SELECT IFNULL(SUM(TIMESTAMPDIFF(DAY, st.fecha_inicio, if(sr.fecha_fin is null,CURDATE()+1,sr.fecha_fin))>1),0) 'Ningún rango ha sido agregado',count(st.id) Total from siniestro_tramite st left join siniestro_reportes sr on st.id_siniestro=sr.id where  YEAR(st.fecha_inicio) =".$year." and sr.tipo_r='".$tipos."';";
            }else{
                $SQL=" SELECT IFNULL(SUM(TIMESTAMPDIFF(DAY, st.fecha_inicio, if(sr.fecha_fin is null,CURDATE()+1,sr.fecha_fin))>=".($arrayRango[0]["rango"]+1)." and TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is null,CURDATE()+1,st.fecha_fin))<=".$arrayRango[0]["rango"]."),0)"."\"".(0)."-".$arrayRango[0]["rango"]."\",";
                $SQL=$SQL."IFNULL(SUM(TIMESTAMPDIFF(DAY, st.fecha_inicio, if(sr.fecha_fin is null,CURDATE()+1,sr.fecha_fin))>".$arrayRango[0]["rango"]."),0)\""."Mas de ".$arrayRango[0]["rango"]."\"".",count(st.id) Total ";
                $SQL=$SQL."from siniestro_tramite st left join siniestro_reportes sr on st.id_siniestro=sr.id where YEAR(st.fecha_inicio) =".$year." and sr.tipo_r='".$tipos."';";
            }
            
        }
        //var_dump($SQL);
            $query = $this->db->query($SQL);
            if ($query->num_rows() > 0) {
                $row = $query->result_array();
            }
            $total=$row[0]["Total"];
            foreach ($row[0] as $keys => $valor) {
                //echo $valor .'<-val, '.$total.'<-Total'; echo '<br>';
                if($valor!=0 && $total!=0){
                    $porcentajes[$keys]=round(($valor*100)/$total,3)."%";
                }else{
                    $porcentajes[$keys]="0"."%";
                }
            }
            $returnArray[]=$row[0];
            $returnArray[]=$porcentajes;
        
        return $returnArray;
    }





    ///Reposrtes de los siniestros
    function getReporteTableAutos($ano=null,$mes=null){
        $this->db
        ->select("count(sr.id) Total, 
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))>indicador.dias and setr.valores=1,1,0 )),0)ter_no_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))<=indicador.dias and setr.valores=1,1,0 )),0)ter_en_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))<=indicador.dias and setr.valores is NULL,1,0)),0)pend_en_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))>indicador.dias and setr.valores is NULL,1,0)),0)pend_no_tiempo",false)
        ->join("(select * from indicadores i where cliente_id=0) indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
        ->join("siniestro_estatus_tramites setr", "sr.status_id=setr.id", "left");
        $this->db->where("sr.tipo_r", 'A');
        if($ano!=null){
            $this->db->where("YEAR(sr.inicio_ajuste)", $ano);
        }
        if($mes!=null){
            $this->db->where("month(sr.inicio_ajuste)", $mes);
        }
        $obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
    }

    function getReporteTableDanos($ano=null,$mes=null){
        $this->db
        ->select("count(sr.id) Total, 
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.inicio_ajuste,  if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))>indicador.dias and setr.valores=1,1,0 )),0)ter_no_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.inicio_ajuste,  if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))<=indicador.dias and setr.valores=1,1,0 )),0)ter_en_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.inicio_ajuste,  if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))<=indicador.dias and setr.valores is NULL,1,0 )),0)pend_en_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, sr.inicio_ajuste,  if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))>indicador.dias and setr.valores is NULL,1,0 )),0)pend_no_tiempo",false)
        ->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
        ->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
        ->join("siniestro_tramite_danos stg", "tramite.tipo_tramite=stg.id", "left")
        ->join("(select * from indicadores i where cliente_id=0 and sub_tipo_id=1) indicador", "sr.id_tipo_d=indicador.causa_id", "left")
        ->join("siniestro_estatus_tramites setr", "sr.status_id=setr.id", "left");
        $this->db->where("sr.tipo_r", 'D');
        if($ano!=null){
            $this->db->where("YEAR(sr.inicio_ajuste)", $ano);
        }
        if($mes!=null){
            $this->db->where("month(sr.inicio_ajuste)", $mes);
        }
        $obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
    }

    function getReporteTableGmm($ano=null,$mes=null){
        $this->db
        ->select("count(st.id) Total, 
        coalesce(sum(if( TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is NULL,CURDATE(),st.fecha_fin))>indicador.dias and setr.valores=1,1,0 )),0)ter_no_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is NULL,CURDATE(),st.fecha_fin))<=indicador.dias and setr.valores=1,1,0 )),0)ter_en_tiempo,
        coalesce(sum(if( TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is NULL,CURDATE(),st.fecha_fin))<=indicador.dias and setr.valores is NULL,1,0)),0)pend_en_tiempo,
         coalesce(sum(if( TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is NULL,CURDATE(),st.fecha_fin))>indicador.dias and setr.valores is NULL,1,0)),0)pend_no_tiempo",false)
        ->join("tipo_coberturas_gmm tcg", "st.cobertura_id=tcg.id", "left")
        ->join("siniestro_tramite_gmm stg", "st.tipo_tramite=stg.id", "left")
        ->join("(select * from indicadores i where cliente_id=0 AND i.sub_tipo_id='3') as indicador", "st.tipo_tramite=indicador.causa_id", "left")
        ->join("siniestro_estatus_tramites setr", "st.estatus=setr.id", "left")
        ->join("siniestro_reportes sr", "st.id_siniestro=sr.id", "left");
        $this->db->where("sr.tipo_r", 'G');
        if($ano!=null){
            $this->db->where("YEAR(st.fecha_inicio)", $ano);
        }
        if($mes!=null){
            $this->db->where("month(st.fecha_inicio)", $mes);
        }
        $obj=$this->db->get('siniestro_tramite st');
		return $obj->result_array();
    }

    function getIdestatus($nombre){
        $this->db->where('nombre',$nombre);
        $obj=$this->db->get("siniestro_estatus_tramites");
        $value=$obj->result_array();
        if(!empty($value)){
            return $value[0]["id"];
        }else{
            return 0;
        }
    }

    //metodos para los autos corporativo
	function getClientesEjecutivo($id){
        $SQL ="SELECT distinct sc.id,sc.nombre,sa.aseguradora_id aseguradora
        from siniestro_cliente_ejecutivo se
        inner join siniestro_clientes sc on se.cliente_id=sc.id
        inner join siniestro_servicio_aseguradoras sa on se.cliente_id=sa.cliente_id
        where se.ejecutivo_id=".$id;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getAllCoorporativo($clientes,$id_estatus,$year,$month=null){
		$obj=array();	
		$this->db
		->select("sr.*, st.nombre tipo_siniestro_nombre, sc.nombre causa_nombre,sta.nombre autoridad_nombre,indicador.dias,TIMESTAMPDIFF(DAY, sr.inicio_ajuste, CURDATE()) progreso, setr.color,setr.nombre estatus")
        ->where( "sr.tipo_actualizacion", 'SERVICIO')
        ->where("sr.status_id !=",'5')
        ->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
		->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
		->join("siniestro_tipoautoridad sta", "sr.autoridad_id=sta.id", "left")
		->join("(select * from indicadores i where cliente_id=0) as indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
		->join("siniestro_estatus setr", "sr.siniestro_estatus=setr.nombre", "left");
		if($year!='0'){
			$this->db->where("year(sr.fecha_repote)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.fecha_repote)", $month);
		}
		if($id_estatus!="SIN ESTATUS"){
			$this->db->where("sr.siniestro_estatus", $id_estatus);
        }else{
            $this->db->where("sr.siniestro_estatus");
        }
        $this->db->where_in("sr.cliente_id", $clientes);
        $this->db->where("sr.tipo_actualizacion", "SERVICIO");
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
    }
    
    function getDataExcelAutosCorporativo($id_estatus,$year,$month=null,$rango1=null,$rango2=null){
		$obj=array();	
		$this->db
		->select("sr.siniestro_id siniestro, sr.asegurado_nombre, sr.poliza,sr.certificado,sr.siniestro_estatus,st.nombre tipo_siniestro_nombre,sc.nombre causa_nombre,sr.complemento_json")
        ->where( "sr.tipo_actualizacion", 'SERVICIO')
        ->where("sr.status_id !=",'5')
        ->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
		->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
		->join("siniestro_tipoautoridad sta", "sr.autoridad_id=sta.id", "left")
		->join("(select * from indicadores i where cliente_id=0) as indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
		->join("siniestro_estatus setr", "sr.siniestro_estatus=setr.nombre", "left");
		if($year!='0'){
			$this->db->where("year(sr.fecha_repote)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.fecha_repote)", $month);
		}
		if($id_estatus!="SIN ESTATUS"){
			$this->db->where("sr.siniestro_estatus", $id_estatus);
        }else{
            $this->db->where("sr.siniestro_estatus");
        }
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
    }

    function getDataExcelAutosCorporativoR($id_estatus,$year,$month=null,$rango1=null,$rango2=null){
		$obj=array();	
		$this->db
		->select("sr.siniestro_id siniestro, sr.asegurado_nombre, sr.poliza,sr.certificado,sr.siniestro_estatus,st.nombre tipo_siniestro_nombre,sc.nombre causa_nombre,sr.complemento_json")
        ->where( "sr.tipo_actualizacion", 'SERVICIO')
        ->where("sr.status_id !=",'5')
        ->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
		->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
		->join("siniestro_tipoautoridad sta", "sr.autoridad_id=sta.id", "left")
		->join("(select * from indicadores i where cliente_id=0) as indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
		->join("siniestro_estatus setr", "sr.siniestro_estatus=setr.nombre", "left");
		if($year!='0'){
			$this->db->where("year(sr.fecha_repote)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.fecha_repote)", $month);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
    }
    
    function getAllAutosCorporativotablaRango($id_estatus,$year,$month=null,$rango1=null,$rango2=null){
		$obj=array();	
		$this->db
		->select("sr.*, st.nombre tipo_siniestro_nombre, sc.nombre causa_nombre,sta.nombre autoridad_nombre,indicador.dias,TIMESTAMPDIFF(DAY, sr.inicio_ajuste, CURDATE()) progreso, setr.color,setr.nombre estatus")
        ->where( "sr.tipo_actualizacion", 'SERVICIO')
        ->where("sr.status_id !=",'5')
        ->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
		->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
		->join("siniestro_tipoautoridad sta", "sr.autoridad_id=sta.id", "left")
		->join("(select * from indicadores i where cliente_id=0) as indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
		->join("siniestro_estatus setr", "sr.siniestro_estatus=setr.nombre", "left");
		if($year!='0'){
			$this->db->where("year(sr.fecha_repote)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.fecha_repote)", $month);
		}
		/* if($id_estatus!='0'){
			$this->db->where("setr.id", $id_estatus);
		} */
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
    }
    
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

    function getAllAutosCtabla($id_estatus,$year,$month=null,$rango1=null,$rango2=null,$clientes=null){
		$obj=array();	
		$this->db
		->select("sr.*,se.nombre estatus,sc.nombre causa_nombre,st.nombre tipo_nombre, sa.nombre autoridad_nombre,sga.nombre segunAutoridad, sgj.nombre segunAjustador, ce.estado Estado,i.dias parametro,TIMESTAMPDIFF(DAY, sr.fecha_repote, CURDATE()+1) progreso,
        tramite.id id_tramite,sta.nombre nombre_tramite, sta.id tipo_tramite, tramite.estatus tram_estatus, tramite.fecha_inicio tram_ini, setr.nombre tram_est_nom,setr.color tram_est_col, setr.valores tram_close")
		->where( "sr.tipo_actualizacion", 'SERVICIO')
        ->where_in("sr.cliente_id",$clientes)
		->join("siniestro_estatus se", "sr.status_id=se.id", "left")
        ->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
        ->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
        ->join("siniestro_tipoautoridad sa", "sr.autoridad_id=sa.id", "left")
        ->join("siniestro_segun_autoridad sga", "sr.responsable_autoridad=sga.id", "left")
        ->join("siniestro_segun_ajustador sgj", "sr.responsable_autoridad=sgj.id", "left")
        ->join("(select * from indicadores i where cliente_id=0) as i", "sr.tipo_siniestro_id=i.causa_id", "left")
        ->join("catalog_estados ce", "sr.estado_id=ce.clave", "left")
        ->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
        ->join("siniestro_tramite_autos sta", "tramite.tipo_tramite=sta.id", "left")
        ->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
        $this->db->group_by("sr.id");
		
		if($year!='0'){
			$this->db->where("year(sr.fecha_repote)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.fecha_repote)", $month);
		}
		if($id_estatus!='0'){
			$this->db->where("sr.siniestro_estatus", $id_estatus);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
	}

    function getDataExcelAutosC($id_estatus,$year,$month=null,$rango1=null,$rango2=null,$clientes=null){
		$obj=array();	
		$this->db
		->select("sr.*,se.nombre estatus,sc.nombre causa_nombre,st.nombre tipo_nombre, sa.nombre autoridad_nombre,sga.nombre segunAutoridad, sgj.nombre segunAjustador, ce.estado Estado,i.dias parametro,TIMESTAMPDIFF(DAY, sr.fecha_repote, CURDATE()+1) progreso,
        tramite.id id_tramite,sta.nombre nombre_tramite, sta.id tipo_tramite, tramite.estatus tram_estatus, tramite.fecha_inicio tram_ini, setr.nombre tram_est_nom,setr.color tram_est_col, setr.valores tram_close")
		->where( "sr.tipo_actualizacion", 'SERVICIO')
        ->where_in("sr.cliente_id",$clientes)
		->join("siniestro_estatus se", "sr.status_id=se.id", "left")
        ->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
        ->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
        ->join("siniestro_tipoautoridad sa", "sr.autoridad_id=sa.id", "left")
        ->join("siniestro_segun_autoridad sga", "sr.responsable_autoridad=sga.id", "left")
        ->join("siniestro_segun_ajustador sgj", "sr.responsable_autoridad=sgj.id", "left")
        ->join("(select * from indicadores i where cliente_id=0) as i", "sr.tipo_siniestro_id=i.causa_id", "left")
        ->join("catalog_estados ce", "sr.estado_id=ce.clave", "left")
        ->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
        ->join("siniestro_tramite_autos sta", "tramite.tipo_tramite=sta.id", "left")
        ->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
        $this->db->group_by("sr.id");
		
		if($year!='0'){
			$this->db->where("year(sr.fecha_repote)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.fecha_repote)", $month);
		}
		if($id_estatus!='0'){
			$this->db->where("sr.siniestro_estatus", $id_estatus);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
	}

    function getAllAutostablaRangoC($id_estatus,$year,$month=null,$rango1=null,$rango2=null,$clientes){
        $obj=array();	
		$this->db
		->select("sr.*,se.nombre estatus,sc.nombre causa_nombre,st.nombre tipo_nombre, sa.nombre autoridad_nombre,sga.nombre segunAutoridad, sgj.nombre segunAjustador, ce.estado Estado,i.dias parametro,TIMESTAMPDIFF(DAY, sr.fecha_repote, CURDATE()+1) progreso,
        tramite.id id_tramite,sta.nombre nombre_tramite, sta.id tipo_tramite, tramite.estatus tram_estatus, tramite.fecha_inicio tram_ini, setr.nombre tram_est_nom,setr.color tram_est_col, setr.valores tram_close")
		->where( "sr.tipo_actualizacion", 'SERVICIO')
        ->where_in("sr.cliente_id",$clientes)
		->join("siniestro_estatus se", "sr.status_id=se.id", "left")
        ->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
        ->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
        ->join("siniestro_tipoautoridad sa", "sr.autoridad_id=sa.id", "left")
        ->join("siniestro_segun_autoridad sga", "sr.responsable_autoridad=sga.id", "left")
        ->join("siniestro_segun_ajustador sgj", "sr.responsable_autoridad=sgj.id", "left")
        ->join("(select * from indicadores i where cliente_id=0) as i", "sr.tipo_siniestro_id=i.causa_id", "left")
        ->join("catalog_estados ce", "sr.estado_id=ce.clave", "left")
        ->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
        ->join("siniestro_tramite_autos sta", "tramite.tipo_tramite=sta.id", "left")
        ->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
        $this->db->group_by("sr.id");
		
		if($year!='0'){
			$this->db->where("year(sr.fecha_repote)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.fecha_repote)", $month);
		}
		if($id_estatus!='0'){
			$this->db->where("sr.siniestro_estatus", $id_estatus);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.fecha_repote, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
    }


    ///metodos de los KPI'S para los modulos de Siniestros

    function getArrayClientes($array){
        $rReturn=[];
        foreach ($array as $key => $value) {
            $rReturn[]=$value["id"];
        }
        return $rReturn;
    }
    function map_clientes($array)
    {
        $clientes = "(";
        $num = count($array);
        foreach ($array as $key => $value) {
            if ($num - 1 == $key) {
                $clientes = $clientes . $value["id"];
            } else {
                $clientes = $clientes . $value["id"] . ",";
            }
        }
        $clientes = $clientes . ")";
        return empty($array) ? "(0)" : $clientes;
    }

    public function kpi_autosIndividual($mes,$ano,$finalizado){
        $this->db
        ->select("
        coalesce(sum(if((TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)<=0.5,1,0)),0) verde,
        coalesce(sum(if((TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)>0.5 and (TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)<=1,1,0)),0) ambar,
        coalesce(sum(if((TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)>1,1,0)),0) rojo,
        count(sr.id) Total",false)
        ->join("(select * from indicadores i where cliente_id=0) indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
        ->join("siniestro_estatus_tramites setr", "sr.status_id=setr.id", "left");
        $this->db->where("sr.tipo_r", 'A');
        $this->db->where("indicador.id is not null");
        if($ano!=null){
            $this->db->where("YEAR(sr.inicio_ajuste)", $ano);
        }
        if($mes!=null){
            $this->db->where("month(sr.inicio_ajuste)", $mes);
        }
        if($finalizado!="NO"){
            $this->db->where("sr.fecha_fin is not NULL");
        }else{
            $this->db->where("sr.fecha_fin",NULL);
        }
        $obj=$this->db->get('siniestro_reportes sr');
		//return $obj->result_array();
        $res=$obj->result_array();
		return $res[0];
    }

    public function kpi_Danos($mes,$ano,$finalizado){
        $this->db->
        select("
        coalesce(sum(if((TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)<=0.5,1,0)),0) verde,
        coalesce(sum(if((TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)>0.5 and (TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)<=1,1,0)),0) ambar,
        coalesce(sum(if((TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)>1,1,0)),0) rojo,
        count(sr.id) Total,",false)
        ->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
        ->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
        ->join("siniestro_tramite_danos stg", "tramite.tipo_tramite=stg.id", "left")
        ->join("(select * from indicadores i where cliente_id=0 and sub_tipo_id=1) indicador", "sr.id_tipo_d=indicador.causa_id", "left")
        ->join("siniestro_estatus_tramites setr", "sr.status_id=setr.id", "left");
        $this->db->where("sr.tipo_r", 'D');
        $this->db->where("indicador.id is not null");
        if($ano!=null){
            $this->db->where("YEAR(sr.inicio_ajuste)", $ano);
        }
        if($mes!=null){
            $this->db->where("month(sr.inicio_ajuste)", $mes);
        }
        if($finalizado!="NO"){
            $this->db->where("sr.fecha_fin is not NULL");
        }else{
            $this->db->where("sr.fecha_fin",NULL);
        }
        $obj=$this->db->get('siniestro_reportes sr');
		//return $obj->result_array();
        $res=$obj->result_array();
		return $res[0];
    }

    public function kpi_GMM($mes,$ano,$finalizado){
        $this->db->
        select("
        coalesce(sum(if((TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is NULL,CURDATE(),st.fecha_fin))/indicador.dias)<=0.5,1,0)),0) verde,
        coalesce(sum(if((TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is NULL,CURDATE(),st.fecha_fin))/indicador.dias)>0.5 and (TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is NULL,CURDATE(),st.fecha_fin))/indicador.dias)<=1,1,0)),0) ambar,
        coalesce(sum(if((TIMESTAMPDIFF(DAY, st.fecha_inicio, if(st.fecha_fin is NULL,CURDATE(),st.fecha_fin))/indicador.dias)>1,1,0)),0) rojo,
        count(st.id) Total",false)
        ->join("tipo_coberturas_gmm tcg", "st.cobertura_id=tcg.id", "left")
        ->join("siniestro_tramite_gmm stg", "st.tipo_tramite=stg.id", "left")
        ->join("(select * from indicadores i where cliente_id=0 AND i.sub_tipo_id='3') as indicador", "st.tipo_tramite=indicador.causa_id", "left")
        ->join("siniestro_estatus_tramites setr", "st.estatus=setr.id", "left")
        ->join("siniestro_reportes sr", "st.id_siniestro=sr.id", "left");
        $this->db->where("sr.tipo_r", 'G');
        $this->db->where("indicador.id is not null");
        if($ano!=null){
            $this->db->where("YEAR(st.fecha_inicio)", $ano);
        }
        if($mes!=null){
            $this->db->where("month(st.fecha_inicio)", $mes);
        }
        if($finalizado!="NO"){
            $this->db->where("st.fecha_fin is not NULL");
        }else{
            $this->db->where("st.fecha_fin",NULL);
        }
        $obj=$this->db->get('siniestro_tramite st');
		/* return $obj->result_array(); */
        $res=$obj->result_array();
		return $res[0];
    }

    public function kpi_AutosC($mes,$ano,$finalizado,$id_usuario){
        //obtenemos los clientes
        $clientess = $this->getClientesEjecutivo($id_usuario);
        //$clientesDB = $this->map_clientes($clientes);
        $clientes=$this->getArrayClientes($clientess);
        //Se cambio la fecha_reporte por fecha_ocurrencia
        $this->db
        ->select("
        coalesce(sum(if((TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)<=0.5,1,0)),0) verde,
        coalesce(sum(if((TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)>0.5 and (TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)<=1,1,0)),0) ambar,
        coalesce(sum(if((TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, if(sr.fecha_fin is NULL,CURDATE(),sr.fecha_fin))/indicador.dias)>1,1,0)),0) rojo,
        count(sr.id) Total,",false)
        ->join("(select * from indicadores i where cliente_id=0) indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
        ->join("siniestro_estatus setr", "sr.siniestro_estatus=setr.nombre", "left");
        $this->db->where( "sr.tipo_r", 'S');
        $this->db->where("indicador.id is not null");
        //$this->db->where("sr.status_id !=",'5');
        $this->db->where_in("sr.cliente_id",$clientes);
        //$this->db->where("sr.tipo_r", 'A');
        if($ano!=null){
            $this->db->where("YEAR(sr.fecha_ocurrencia)", $ano);
        }
        if($mes!=null){
            $this->db->where("month(sr.fecha_ocurrencia)", $mes);
        }
        if($finalizado!="NO"){
            $this->db->where("sr.fecha_fin is not NULL");
        }else{
            $this->db->where("sr.fecha_fin",NULL);
        }
        $obj=$this->db->get('siniestro_reportes sr');
        $res=$obj->result_array();
		return $res[0];
    }
    //armado
    public function getKPI_Siniestros($tipo,$mes=null,$ano=null,$id_usuario=null){
        $data=[];
        switch ($tipo) {
            case 'AUTOSI':
                //$data["No_Finalizado"]=$this->kpi_autosIndividual($mes,$ano,"NO");
                //$data["Finalizado"]=$this->kpi_autosIndividual($mes,$ano,"SI");
                $data["Finalizado"]=$this->kpi_autosIndividual($mes,$ano,"NO");
                $data["No_Finalizado"]=$this->kpi_autosIndividual($mes,$ano,"SI");
                break;
            case 'GMM':
                //$data["No_Finalizado"]=$this->kpi_GMM($mes,$ano,"NO");
                //$data["Finalizado"]=$this->kpi_GMM($mes,$ano,"SI");
                $data["Finalizado"]=$this->kpi_GMM($mes,$ano,"NO");
                $data["No_Finalizado"]=$this->kpi_GMM($mes,$ano,"SI");
                break;
            case 'DANOS':
                //$data["No_Finalizado"]=$this->kpi_Danos($mes,$ano,"NO");
                //$data["Finalizado"]=$this->kpi_Danos($mes,$ano,"SI");
                $data["Finalizado"]=$this->kpi_Danos($mes,$ano,"NO");
                $data["No_Finalizado"]=$this->kpi_Danos($mes,$ano,"SI");
                break;
            case 'AUTOSC':
                //$data["No_Finalizado"]=$this->kpi_AutosC($mes,$ano,"NO",$id_usuario);
                //$data["Finalizado"]=$this->kpi_AutosC($mes,$ano,"SI",$id_usuario);
                $data["Finalizado"]=$this->kpi_AutosC($mes,$ano,"NO",$id_usuario);
                $data["No_Finalizado"]=$this->kpi_AutosC($mes,$ano,"SI",$id_usuario);
                break;
        }
        $data["Totales"]=array(
            "Total_verde"=>$data["No_Finalizado"]["verde"]+$data["Finalizado"]["verde"],
            "Total_ambar"=>$data["No_Finalizado"]["ambar"]+$data["Finalizado"]["ambar"],
            "Total_rojo"=>$data["No_Finalizado"]["rojo"]+$data["Finalizado"]["rojo"],
            "Total"=>$data["No_Finalizado"]["Total"]+$data["Finalizado"]["Total"],
        );
        return $data;
    }


}
