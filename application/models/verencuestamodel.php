
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class VerEncuestaModel extends CI_Model {
	var $funcionLlamar;
	var $datos;
//-----------------------------------------------------------------
	function __construct(){
		parent::__construct();     

	}
/********************************************* */
public function encuestasActivas($valor) //Modificado [2024-01-09]
{
  if($valor == "CLIENTES")
    {
  $consulta = "select ce.idcabencuesta,ce.descripcion,
  count(cal.idencuesta) as asignadas,(select count(cal1.idencuesta) from calificaencuesta cal1 where cal1.idencuesta = ce.idcabencuesta and cal1.activa =1  and cal1.cliente =1 and cal1.cliente =1) as contesto,

  coalesce( (select sum(if(p.Telefono1 is not null  and p.Telefono1 <> '',1,0))   
 from calificaencuesta cf
 left join clientelealtadpuntos p on cf.idusuario=p.IDCli 
  where cf.idencuesta = ce.idcabencuesta and cf.activa=0),0) as Telefono,

    coalesce( (select sum(if(p.Telefono1 is not null  and  p.Telefono1 != '' and p.Telefono1 != 0,1,0))   
 from calificaencuesta cf
 left join clientelealtadpuntos p on cf.idusuario=p.IDCli 
  where cf.idencuesta = ce.idcabencuesta and cf.activa=0 and cf.cliente =1),0) as Celular,

  coalesce( (select sum(if(p.EMail1 is not null  and  p.EMail1 <> '',1,0))   
 from calificaencuesta cf
 left join clientelealtadpuntos p on cf.idusuario=p.IDCli 
  where cf.idencuesta = ce.idcabencuesta and cf.activa=0 and cf.cliente =1),0) as Correo

   from cabencuesta ce 
   left join calificaencuesta cal on cal.idencuesta= ce.idcabencuesta
   where ce.activa=0 and cal.cliente = 1 
   group by 1,2";
    }
    else
    {
     if($valor == "AGENTES")
     {
      $consulta ="select ce.idcabencuesta,ce.descripcion,
      count(cal.idencuesta) as asignadas,
    (select count(cal1.idencuesta) from calificaencuesta cal1,persona p where cal1.idencuesta = ce.idcabencuesta 
    and  cal1.idusuario = p.idPersona  and p.tipoPersona=3 and cal1.cliente = 0
      and cal1.activa =1) as contesto,
      
      coalesce( (select sum(if(p.celOficina is not null  and p.celOficina <> '',1,0))   
     from calificaencuesta cf
    join persona p on cf.idusuario=p.idPersona 
     where cf.idencuesta = ce.idcabencuesta and cf.activa=0 and cf.cliente = 0 and p.tipoPersona=3),0) as Telefono,
     
     coalesce( (select sum(if(p.celpersonal is not null  and  p.celpersonal != '' and p.celpersonal != 0,1,0))   
     from calificaencuesta cf
     left join persona p on cf.idusuario=p.idPersona 
     where cf.idencuesta = ce.idcabencuesta and cf.activa=0 and cf.cliente = 0 and p.tipoPersona=3),0) as Celular,

     coalesce((select sum(if(us.email is not  null  and  us.email <> '',1,0))   
     from calificaencuesta cf
     left join persona p on cf.idusuario=p.idPersona inner join users us on p.idPersona = us.idPersona
     where cf.idencuesta = ce.idcabencuesta and cf.activa=0 and cf.cliente = 0 and p.tipoPersona=3),0) as Correo
     
     from cabencuesta ce ,calificaencuesta cal,persona p      
     where ce.activa=0 and cal.cliente = 0 and  cal.idencuesta= ce.idcabencuesta and  
    cal.idusuario = p.idPersona and p.tipoPersona=3 
     group by 1,2";
     }
     else
     {
      if($valor == "COLABORADORES")
      {
      $consulta = "  select ce.idcabencuesta,ce.descripcion, count(cal.idencuesta) as asignadas,
      (select count(cal1.idencuesta) from calificaencuesta cal1,persona p where cal1.idencuesta = ce.idcabencuesta and  cal1.idusuario = p.idPersona  and p.tipoPersona=1 and cal1.cliente = 0 and cal1.activa =1) as contesto,
      
      coalesce( (select sum(if(p.celOficina is not null  and p.celOficina <> '',1,0))   
     from calificaencuesta cf
    join persona p on cf.idusuario=p.idPersona 
     where cf.idencuesta = ce.idcabencuesta and cf.activa=0 and cf.cliente = 0 and p.tipoPersona=1),0) as Telefono,
     
     coalesce( (select sum(if(p.celpersonal is not null  and  p.celpersonal != '' and p.celpersonal != 0,1,0))   
     from calificaencuesta cf
     left join persona p on cf.idusuario=p.idPersona 
     where cf.idencuesta = ce.idcabencuesta and cf.activa=0 and cf.cliente = 0 and p.tipoPersona=1),0) as Celular,

     coalesce((select sum(if(us.email is not  null  and  us.email <> '',1,0))   
     from calificaencuesta cf
     left join persona p on cf.idusuario=p.idPersona inner join users us on p.idPersona = us.idPersona
     where cf.idencuesta = ce.idcabencuesta and cf.activa=0 and cf.cliente = 0 and p.tipoPersona=1),0) as Correo

     from cabencuesta ce ,calificaencuesta cal,persona p      
     where ce.activa=0 and cal.cliente = 0 and  cal.idencuesta= ce.idcabencuesta and  
    cal.idusuario = p.idPersona and p.tipoPersona=1 
     group by 1,2";
      }
      else{
        $consulta ="select ce.idcabencuesta,ce.descripcion,
        count(cal.idencuesta) as asignadas,(select count(cal1.idencuesta) from calificaencuesta cal1 where cal1.idencuesta = ce.idcabencuesta and cal1.activa =1) as contesto,

        coalesce( (select sum(if(p.celpersonal is not null  and p.celpersonal <> '',1,0))   
       from calificaencuesta cf
       left join persona p on cf.idusuario=p.idPersona 
        where cf.idencuesta = ce.idcabencuesta and cf.activa=0),0) as Telefono,

        coalesce( (select sum(if(p.celpersonal is  null  and  p.celpersonal <> '',1,0))   
       from calificaencuesta cf
       left join persona p on cf.idusuario=p.idPersona 
        where cf.idencuesta = ce.idcabencuesta and cf.activa=0),0) as Celular,

        coalesce( (select sum(if(us.email is not  null  and  us.email <> '',1,0))   
       from calificaencuesta cf
       left join persona p on cf.idusuario=p.idPersona inner join users us on p.idPersona = us.idPersona
        where cf.idencuesta = ce.idcabencuesta and cf.activa=0),0) as Correo

         from cabencuesta ce
         left join calificaencuesta cal on cal.idencuesta= ce.idcabencuesta
         where ce.activa=0
         group by 1,2";

     } 
    }
  }
    $datos=$this->db->query($consulta)->result();
    return $datos;

}
/**************************************/
public function encuestasinResponder($valor)
 {
  if($valor == "CLIENTES")
  {

    $consulta="select ca.idcalificaencuesta,ca.usuario,'Cliente' as colaboradorArea ,ce.descripcion
    from calificaencuesta ca
    left join cabencuesta ce on ce.idcabencuesta=ca.idencuesta
    where ca.activa = '0' and ca.cliente =1";            
  }
  else
  {
   if($valor == "COLABORADORES")
   {

    $consulta="select cf.idcalificaencuesta,cf.usuario,'Cliente' as colaboradorArea, cb.descripcion
    from calificaencuesta cf , cabencuesta cb,persona p
   where cf.activa = 0 and cb.idcabencuesta = cf.idencuesta and cb.activa=0
   AND p.idPersona = cf.idusuario and p.tipoPersona= 1
   and cf.cliente=0";            
   }
   else{
    
     $consulta="select cf.idcalificaencuesta,cf.usuario,'Cliente' as colaboradorArea, cb.descripcion
     from calificaencuesta cf , cabencuesta cb,persona p
    where cf.activa = 0 and cb.idcabencuesta = cf.idencuesta and cb.activa=0
    AND p.idPersona = cf.idusuario and p.tipoPersona= 3
    and cf.cliente=0";            
 
   }
  } 
  $datos=$this->db->query($consulta)->result();
    return $datos;
 }
/********************************************* */
 public function DevulveClientes($valor,$tipo=null)
 {
    if($valor == "CLIENTES")
    {

      $consulta="select ca.idcalificaencuesta,ca.usuario,'Cliente' as colaboradorArea ,ce.descripcion
from calificaencuesta ca
left join cabencuesta ce on ce.idcabencuesta=ca.idencuesta
where ca.activa = '0' and ca.cliente =1";            
    }
    else
    { 
     if($valor == "COLABORADORES")
     {
      $consulta="select idcalificaencuesta,usuario from calificaencuesta where activa = '0' and cliente =0";
     if($tipo=='BRONCE' || $tipo=='ORO' || $tipo=='PLATINO VIP')
      {
               $consulta='select ce.idcalificaencuesta,ce.usuario,ce.idusuario,p.nombres,p.idPersona,ca.colaboradorArea,cab.descripcion,p.idpersonarankingagente,p.tipoPersona,cab.descripcion from calificaencuesta ce left join persona p on p.idPersona=ce.idusuario
left join colaboradorarea ca on ca.idColaboradorArea=p.idColaboradorArea
left join cabencuesta cab on cab.idcabencuesta=ce.idencuesta
left join users u on u.idPersona=p.idPersona
where ce.activa = "0" and ce.cliente =0 and u.activated=1 and p.tipoPersona=3 and p.idpersonarankingagente="'.$tipo.'"';
      }
      else
      {
               $consulta='select ce.idcalificaencuesta,ce.usuario,ce.idusuario,p.nombres,p.idPersona,ca.colaboradorArea,cab.descripcion,p.idpersonarankingagente,p.tipoPersona,cab.descripcion from calificaencuesta ce left join persona p on p.idPersona=ce.idusuario
left join colaboradorarea ca on ca.idColaboradorArea=p.idColaboradorArea
left join cabencuesta cab on cab.idcabencuesta=ce.idencuesta
left join users u on u.idPersona=p.idPersona
where ce.activa = "0" and ce.cliente =0 and u.activated=1 and p.tipoPersona=1 and ca.colaboradorArea="'.$tipo.'"';        
      }

     }
     else
     {
      $consulta="select idcalificaencuesta,usuario from calificaencuesta where activa = '0' and cliente =-1";
     }
    }  	
   
	  $datos=$this->db->query($consulta)->result();
    return $datos;
 }

//---------------------------------------------------------------------
 public function DevulvePersonasClasificadas($valor)
 {
    if($valor['tipoPersona'] == "Clientes")
    {

      $consulta="select idcalificaencuesta,usuario from calificaencuesta where activa = '0' and cliente =1";            
    }
    else
    { 
     if($valor['tipoPersona']=='Colaborador')
     {
      //$consulta="select idcalificaencuesta,usuario from calificaencuesta where activa = '0' and cliente =0";
      $consulta="select ce.idcalificaencuesta,ce.idusuario,p.nombres,p.idPersona,ca.colaboradorArea,cab.descripcion
from calificaencuesta ce
left join persona p on p.idPersona=ce.idusuario
left join colaboradorarea ca on ca.idColaboradorArea=p.idColaboradorArea
left join cabencuesta cab on cab.idcabencuesta=ce.idencuesta
where ce.activa = '0' and ce.cliente =0";
     }
     else
     {
      $consulta="select idcalificaencuesta,usuario from calificaencuesta where activa = '0' and cliente =-1";
     }
    }  	
	  $datos=$this->db->query($consulta)->result();
    return $datos;
 }
//-------------------------------------------------------------------
public function DevulveDtractores($valor)
 {
    
    $consulta="select * 
                         from calificaencuesta where  activa =1
                        and   calificacion <  70 and  idencuesta = '".$valor."'";
    
    $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevulvePasivos($valor)
 {
    
    $consulta="select * 
                         from calificaencuesta where  activa =1
                        and   calificacion >=  70 and calificacion <  90 and idencuesta = '".$valor."'";
    
    $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevulvePromotores($valor)
 {
    
    $consulta="select * 
                         from calificaencuesta where  activa =1
                        and   calificacion >=  90 and  idencuesta = '".$valor."'";
    
    $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 //---------------------------------------------------
function devolverEncuestasActivas()
 {
   $consulta='select * from cabencuesta where activa=0';
   return $this->db->query($consulta)->result();
 }
 //---------------------------------------------------
 function devolverPersonasFaltanesPorResponderEncuesta($idcabencuesta)
 {
   $consulta='select ce.*,p.celPersonal from calificaencuesta ce left join persona p on p.idPersona=ce.idusuario where ce.activa=0 and idencuesta='.$idcabencuesta;
   return $this->db->query($consulta)->result();

 }
 //--------------------------------------------
 function devolverPreguntasDeEncuesta($idcabencuesta)
 {
  $consulta='select * from pregunta p where p.idcabencuesta='.$idcabencuesta;
  return $this->db->query($consulta)->result();
 }

//---------------------------------------------
 function devolverPreguntasDeEncuestaDeUsuario($idencuesta,$idusuario)
 {
  $consulta='select e.*,c.idcalificaencuesta from calificaencuesta c left join encuesta e on e.idcabencuesta=c.idcalificaencuesta
where c.idencuesta='.$idencuesta.' and c.idusuario='.$idusuario;
  $consulta2='select distinct(c.idcalificaencuesta) from calificaencuesta c left join encuesta e on e.idcabencuesta=c.idcalificaencuesta where c.idencuesta='.$idencuesta.' and c.idusuario='.$idusuario;

  $datos['preguntas']= $this->db->query($consulta)->result();
  $datos['idcalificaencuesta']=$this->db->query($consulta2)->result()[0]->idcalificaencuesta;
  
  return $datos;
 }
 public function DevulveEncuestas()
 {
  $consulta = "select ce.idcabencuesta,ce.descripcion,
  count(cal.idencuesta) as asignadas,(select count(cal1.idencuesta) from calificaencuesta cal1 where cal1.idencuesta = ce.idcabencuesta
  and cal1.activa =1) as contesto,
  coalesce( (select sum(if(p.celpersonal is not null  and p.celpersonal <> '',1,0))   
 from calificaencuesta cf
 left join persona p on cf.idusuario=p.idPersona 
  where cf.idencuesta = ce.idcabencuesta and cf.activa=0),0) as Telefono,
    coalesce( (select sum(if(p.celpersonal is  null  or  p.celpersonal = '',1,0))   
 from calificaencuesta cf
 left join persona p on cf.idusuario=p.idPersona 
  where cf.idencuesta = ce.idcabencuesta and cf.activa=0),0) as Celular
   from cabencuesta ce 
   left join calificaencuesta cal on cal.idencuesta= ce.idcabencuesta
   where ce.activa=0
   group by 1,2";
   $datos=$this->db->query($consulta)->result();
   return $datos;
 }
//--------------------------------------------------------------------------------------------------------------------
  function getDataEmployeeTest($id,$employee) {
    $query = $this->db->query("select us.email, us.name_complete, us.idPersona, p.celPersonal, cb.* from users us inner join calificaencuesta ce on ce.idusuario = us.idPersona inner join cabencuesta cb on cb.idcabencuesta = ce.idencuesta inner join persona p on p.idPersona = us.idPersona where ce.idencuesta = '".$id."' and ce.activa=0 and ce.cliente = 0 and p.tipoPersona=".$employee." and cb.activa != 1");
    return $query->num_rows() > 0 ? $query->result() : array();
  }

  public function getDataClientTest($id) {
    $query = $this->db->query("select p.EMail1 as email, p.NombreCompleto as name_complete, ce.idusuario as idPersona, p.Telefono1 as celPersonal, cb.* from calificaencuesta ce inner join cabencuesta cb on cb.idcabencuesta = ce.idencuesta inner join clientelealtadpuntos p on ce.idusuario = p.IDCli where ce.idencuesta = '".$id."' and ce.activa=0 and ce.cliente=1 and cb.activa != 1 and ce.idusuario != 0");
    return $query->num_rows() > 0 ? $query->result() : array();
  }

  public function getMessagesEmailTest() {
    $date = date('Y-m-d');
    $query = $this->db->query("select ec.*, us.idPersona, us.name_complete from envio_correos ec inner join users us on us.email = ec.para where CAST(ec.fechaCreacion as DATE) = '".$date."' and ec.asunto = 'Recordatorio'")->result();
    $data = $this->getArrayMessageTest($query);
    return $data;
  }

  public function getMessagesEmailTestClient() {
    $date = date('Y-m-d');
    $query = $this->db->query("select ec.*, us.IDCli as idPersona, us.NombreCompleto as name_complete from envio_correos ec inner join clientelealtadpuntos us on us.EMail1 = ec.para where CAST(ec.fechaCreacion as DATE) = '".$date."' and ec.asunto = 'Recordatorio'")->result();
    $data = $this->getArrayMessageTest($query);
    return $data;
  }

  public function getMessagesMsgTest() {
    $date = date('Y-m-d');
    $query = $this->db->query("select es.fechaCreacion, es.fechaEnvio, es.numbers as para, es.status, us.idPersona, us.name_complete from envio_sms es inner join users us on us.idPersona = es.idUser inner join persona p on p.idPersona = es.idUser where CAST(es.fechaCreacion as DATE) = '".$date."' and es.numbers = p.celPersonal")->result();
    $data = $this->getArrayMessageTest($query);
      return $data;
  }

  public function getMessagesMsgTestClient() {
    $date = date('Y-m-d');
    $query = $this->db->query("select es.fechaCreacion, es.fechaEnvio, es.numbers as para, es.status, us.IDCli as idPersona, us.NombreCompleto as name_complete from envio_sms es inner join clientelealtadpuntos us on us.IDCli = es.idUser where CAST(es.fechaCreacion as DATE) = '".$date."' and es.numbers = us.Telefono1")->result();
    $data = $this->getArrayMessageTest($query);
    return $data;
  }

  function getArrayMessageTest($query) {
    $data = array();
    if (!empty($query)) {
      foreach ($query as $val) {//2672
        $con = $this->db->query("select ce.*, cb.descripcion from calificaencuesta ce inner join cabencuesta cb on cb.idcabencuesta = ce.idencuesta where ce.idusuario = '".$val->idPersona."' and ce.activa != 1")->result();
        
        $add['fechaCreacion'] = $val->fechaCreacion;
        $add['fechaEnvio'] = $val->fechaEnvio;
        $add['nombre'] = $val->name_complete;
        $add['para'] = $val->para;
        $add['status'] = $val->status;
        $add['tipo'] = "Correo electrónico";
        $add['encuesta'] = $con;

        if (!empty($con)) {
          array_push($data, $add);
        }
      }
    }
    return $data;
  }

  function getQuestionsTest($sql) {
    $data = array();
    $query = $this->db->query('SELECT * FROM calificaencuesta WHERE '.$sql)->result();
    foreach ($query as $val) {
      $con = $this->db->query('SELECT * FROM encuesta WHERE idcabencuesta = '.$val->idcalificaencuesta)->result();
      $add['idcalificaencuesta'] = $val->idcalificaencuesta;
      $add['idencuesta'] = $val->idencuesta;
      $add['calificacion'] = $val->calificacion;
      $add['idusuario'] = $val->idusuario;
      $add['fechacontesta'] = $val->fechacontesta;
      $add['preguntas'] = $con;
      array_push($data, $add);
    }
    return $data;
  }

  function getTest($info = null, $date = null) { //Modificado [Suemy][2024-06-10]
    $data = array();
    $con_c = isset($info['con_c']) ? $info['con_c'] : "";
    $con_d = isset($info['con_d']) ? $info['con_d'] : "";
    $query = $this->db->query('SELECT * FROM cabencuesta WHERE activa != 1'.$con_c)->result();
    foreach ($query as $val) {
      $consult = array();
      $con = $this->db->query('SELECT * FROM calificaencuesta WHERE idencuesta = '.$val->idcabencuesta.$con_d)->result();
      $sql = $this->db->query('SELECT * FROM pregunta WHERE idcabencuesta = '.$val->idcabencuesta)->result();
      foreach ($con as $row) {
        $user = "Cliente";
        if ($row->cliente == "0") {
          $user = $this->db->query('SELECT if(tipoPersona = 1, "Colaborador", "Agente") as tipo FROM persona WHERE idPersona = '.$row->idusuario)->row()->tipo;
        }
        $res = $this->db->query('SELECT * FROM encuesta WHERE idcabencuesta = '.$row->idcalificaencuesta)->result();
        $register = !empty($row->registro) ? $row->registro : (!empty($res) ? $res[0]->fecha : "");
        $date_r = strtotime($register);
        $date_c = ($row->fechacontesta != null) ? strtotime($row->fechacontesta) : 0;
        $insert['idencuesta'] = $row->idencuesta;
        $insert['idcalificaencuesta'] = $row->idcalificaencuesta;
        $insert['activa'] = $row->activa;
        $insert['idusuario'] = $row->idusuario;
        $insert['usuario'] = $row->usuario;
        $insert['cliente'] = $row->cliente;
        $insert['calificacion'] = $row->calificacion;
        $insert['fechacontesta'] = $row->fechacontesta;
        $insert['fechaRegistro'] = $register;
        $insert['tipoPersona'] = $user;
        $insert['preguntas'] = $res;
        $insert['asignado'] = 1;
        /*$insert['date_d'] = $date;
        $insert['date_r'] = $date_r;*/
        if ($date != null && $date_r >= $date['dateI'] && $date_r <= $date['dateF'] || $date == null) {
          array_push($consult, $insert);
        }
        else if (
          $date != null && $date_c >= $date['dateI'] && $date_c <= $date['dateF'] && $date_r < $date['dateI'] ||
          $date != null && $date_c >= $date['dateI'] && $date_c <= $date['dateF'] && $register == ""
        ) {
          $insert['asignado'] = 0;
          array_push($consult, $insert);
        }
      }
      $add['idcabencuesta'] = $val->idcabencuesta;
      $add['titulo'] = $val->descripcion;
      $add['preguntas'] = $val->preguntas;
      $add['tiprespuesta'] = $val->tiprespuesta;
      $add['tipoencuesta'] = $val->tipoencuesta;
      $add['fecha'] = $val->fecha;
      $add['asignados'] = $consult;
      $add['preguntas'] = $sql;
      array_push($data, $add);
    }
    return $data;
  }

  function getActiveTest() { //Creado [Suemy][2024-05-27]
    $query = $this->db->query('SELECT * FROM cabencuesta WHERE activa != 1')->result();
    return $query;
  }

  function getTestAnswered($month,$year,$person,$sql = NULL) { //Creado [Suemy][2024-05-27]
    switch ($person) {
      case 1:
        $consult = 'SELECT ca.idcalificaencuesta, ca.idencuesta, ca.usuario, ca.calificacion, en.descripcion, ca.fechacontesta AS fecha FROM calificaencuesta ca INNER JOIN cabencuesta en ON ca.idencuesta = en.idcabencuesta WHERE en.activa = 0 AND ca.activa = 1 AND YEAR(ca.fechacontesta) = '.$year.' AND MONTH(ca.fechacontesta) = '.$month.' '.$sql;
        break;
      case 2:
        $consult = 'SELECT ca.idcalificaencuesta, ca.idencuesta, ca.usuario, ca.calificacion, en.descripcion, ca.fechacontesta AS fecha, "COLABORADOR" AS tipo FROM calificaencuesta ca INNER JOIN cabencuesta en ON ca.idencuesta = en.idcabencuesta INNER JOIN persona p ON p.idPersona = ca.idusuario WHERE p.tipoPersona = 1 AND en.activa = 0 AND ca.activa = 1 AND YEAR(ca.fechacontesta) = '.$year.' AND MONTH(ca.fechacontesta) = '.$month.' '.$sql;
        break;
      case 3:
        $consult = 'SELECT ca.idcalificaencuesta, ca.idencuesta, ca.usuario, ca.calificacion, en.descripcion, ca.fechacontesta AS fecha, "AGENTE" AS tipo FROM calificaencuesta ca INNER JOIN cabencuesta en ON ca.idencuesta = en.idcabencuesta INNER JOIN persona p ON p.idPersona = ca.idusuario WHERE p.tipoPersona = 3 AND ca.cliente = 0 AND en.activa = 0 AND ca.activa = 1 AND YEAR(ca.fechacontesta) = '.$year.' AND MONTH(ca.fechacontesta) = '.$month.' '.$sql;
        break;
      case 4:
        $consult = 'SELECT ca.idcalificaencuesta, ca.idencuesta, ca.usuario, ca.calificacion, en.descripcion, ca.fechacontesta AS fecha, "CLIENTE" AS tipo FROM calificaencuesta ca INNER JOIN cabencuesta en ON ca.idencuesta = en.idcabencuesta WHERE ca.activa = 1 AND cliente = 1 AND en.activa = 0 AND ca.activa = 1 AND YEAR(ca.fechacontesta) = '.$year.' AND MONTH(ca.fechacontesta) = '.$month.' '.$sql;
        break;
    }
    $query = $this->db->query($consult);
    return $query->num_rows() > 0 ? $query->result() : array();
  }
//--------------------------------------------------------------------------------------------------------------------
}	

?>