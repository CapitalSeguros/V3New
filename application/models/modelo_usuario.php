<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Modelo_usuario extends CI_Model
{
  //var $funcionLlamar;
  var $datos;
  //-----------------------------------------------------------------
  function __construct()
  {
    parent::__construct();
  }
  public function Tlogueo($usu, $contra)
  {
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($usu, TRUE));fclose($fp);
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($contra, TRUE));fclose($fp)
    $consulta = "select * from usuarios where LOGIN ='" . $usu . "' and PASWORD ='" . $contra . "'";
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp);
    $datos = $this->db->query($consulta);
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos->num_rows(), TRUE));fclose($fp); 
    //console($datos->num_rows());
    if ($datos->num_rows() > 0) {
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("entro", TRUE));fclose($fp);
      return true;
    } else {
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("no entro", TRUE));fclose($fp);
      return false;
    }
  }
  public function devempresa()
  {
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($usu, TRUE));fclose($fp);
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($contra, TRUE));fclose($fp)
    $consulta = "select * from empresas where USO ='T'";
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp);
    $datos = $this->db->query($consulta);

    return $datos;
  }

  public function devProyectos($usuario)
  {
    //  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($usuario, TRUE));fclose($fp);
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($contra, TRUE));fclose($fp)
    // $consulta="select * from proyectos where usuario = '".$usuario."'";
    $consulta = "select p.* from proyectos p where p.usuario = " . $usuario . "
           union select p.* from proyectos p,pproyectos pp where
             p.idproyecto=pp.idproyecto and pp.idpersona=" . $usuario;
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp);
    $datos = $this->db->query($consulta);

    return $datos;
  }
  /************************************************/
  public function  devProyectosExt($usuario)
  {
    $consulta = "Select p.* from proyectos p,pproyectos pp where p.idproyecto=pp.idproyecto and pp.correo ='" . $usuario . "'";
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp);
    $datos = $this->db->query($consulta);

    return $datos;
  }
  /********************************************************/
  public function devProyectoActual($idpro)
  {
    $consulta = "select * from proyectos where idproyecto = '" . $idpro . "'";
    $datos = $this->db->query($consulta);
    return $datos;
  }
  //-----------------------
  public function getUsers($area, $pagination)
  {
    $areaCondition = "";

    if (!empty($area)) {
      $areaCondition = "department = '" . str_replace("-", " ", $area) . "' AND ";
    }

    $this->db->query("SET @rowPosition = 0;");
    $this->db->query("SET @department_ = NULL;");
    $query = "SELECT POSITION, idPersona AS p, nombres, email, apellidoPaterno, apellidoMaterno, fotoUser, IF(department = '', 'Sin area', department) AS department
      FROM (
        SELECT idPersona, nombres, email, apellidoPaterno, apellidoMaterno, fotoUser, department,
          @rowPosition := IF(@department_ = department, @rowPosition + 1, 1) AS POSITION,
          @department_ := department
        FROM userstmp_
        ORDER BY department ASC
      ) AS Employees_
      WHERE " . $areaCondition . "POSITION BETWEEN " . $pagination["r1"] . " AND " . $pagination["r2"] . "
      ORDER BY department, POSITION;";

    return $this->db->query($query)->result_array();
  }
  //------------------------------
  public function getAreaPagination()
  {
    return $this->db->get("department_pagination")->result_array();
  }
  //------------------------------
  public function usersTmpTable()
  {

    $drop = "DROP TEMPORARY TABLE IF EXISTS userstmp_;";
    $create = "CREATE TEMPORARY TABLE userstmp_ AS
      SELECT pe.idPersona, pe.nombres, us.email, pe.apellidoPaterno, pe.apellidoMaterno, ui.fotoUser,
        IF(
          pe.tipoPersona = 1 OR pe.esAgenteColaborador = 1, 
            (SELECT colaboradorarea FROM colaboradorarea WHERE idColaboradorArea = pe.idColaboradorArea),
            idpersonarankingagente
        ) AS department
      FROM users us
      LEFT JOIN persona pe ON us.idPersona = pe.idPersona
      LEFT JOIN user_miInfo ui ON pe.idPersona = ui.idPersona
      WHERE pe.bajaPersona = 0 AND us.banned = 0 AND us.activated = 1
    ";

    $this->db->query($drop);
    $this->db->query($create);
  }
  //------------------------------
  public function areaTmpPagination()
  {

    $drop = "DROP TEMPORARY TABLE IF EXISTS department_pagination;";
    $create = "CREATE TEMPORARY TABLE department_pagination AS 
      SELECT IF(department = '', 'Sin area', department) AS AREA, LOWER(REPLACE(IF(department = '', 'Sin area', department), ' ', '-')) AS getParam,
        COUNT(idPersona) AS totalItems,
        IF(MOD(COUNT(idPersona), 10) > 0, FLOOR((COUNT(idPersona) / 10) + 1), FLOOR(COUNT(idPersona) / 10 )) AS pages
      FROM userstmp_ GROUP BY department;
    ";

    $this->db->query($drop);
    $this->db->query($create);
  }
  //------------------------------
}
