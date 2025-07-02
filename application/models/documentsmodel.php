<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Documentsmodel extends CI_Model
{

   function __construct()
   {
      parent::__construct();
   }

   function saveDocument($data)
   {
      $res = $this->db->insert('documentos', $data);
      $insert_id = $this->db->insert_id();
      $result = new \stdClass;
      $result->status = true;
      $result->message = array();
      $result->id = $insert_id;
      //$this->_recuperarDocumentos($data,$result->data);
      if ($result->id > 0) {
         $result->status = true;
         $result->message[] = 'Se agrego correctamente';
      } else {
         $result->status = false;
         $result->message[] = 'No se encontra información en el sistema.';
      }
      return $result;
   }

   function getFileId($id)
   {
      $query = $this->db->where("file_id", $id)
         ->get("documentos");

      $documento = $query->row();
      if (!empty($documento)) {
         if ($documento->privado == 1) {
            $Qey = $this->db->where("documento_id", $documento->id)
               ->join("personapuesto pp", "pp.idPuesto = dp.puesto_id", "inner")
               ->select("dp.puesto_id,pp.personaPuesto puesto")
               ->get("documentos_puestos dp");
            $puestos = array();
            foreach ($Qey->result() as $key => $value) {
               array_push($puestos, array(
                  "label" => $value->puesto,
                  "value" => $value->puesto_id
               ));
            }

            $documento->puestos = $puestos;
         }
      }
      return $documento;
   }

   function baja($file_id)
   {
      return $this->db->where("file_id", $file_id)
         ->update('documentos', array("estado" => "BAJA"));
   }
   function eliminar($file_id)
   {
      return $this->db->where("file_id", $file_id)
         ->update('documentos', array("estado" => "ELIMINADO"));
   }

   function clearDocumentoPuesto($id)
   {
      $this->db->where("documento_id", $id)
         ->delete("documentos_puestos");
   }
   function saveDocumentoPuesto($id, $puestos)
   {
      $data = array();
      foreach ($puestos as $key => $value) {
         array_push($data, array("documento_id" => $id, "puesto_id" => $value));
      }
      if (count($puestos) > 0)
         return $this->db->insert_batch('documentos_puestos', $data);
   }

   function restaurar($file_id)
   {
      return $this->db->where("file_id", $file_id)
         ->update('documentos', array("estado" => "ACTIVO"));
   }

   function getFileByPuesto($puesto, $filtro = array(), $referencia = null, $referenciaId = null, $parentId = null)
   {

      $rows = array();
      $documento_id = 0;
      $SQLP = null;
      $SQLR = null;
      $SQLRID = null;
      $usuario = -1;
      if (!empty($filtro)) {
         if (!empty($filtro["tipo"])) {
            $SQLP = " AND d.tipo = '" . $filtro["tipo"] . "' ";
         }

         if (!empty($filtro["usuario"])) {
            $usuario = $filtro["usuario"];
         }
      }

      if (!empty($parentId)) {
         $SQLP = " AND d.parent_id = '$parentId' ";
      }

      if (!empty($referencia)) {
         //$SQLR = " AND d.referencia = '$referencia' ";
      }

      if (!empty($referenciaId)) {
         $SQLRID = " AND d.referencia_id = '$referenciaId' ";
      }

      $SQLT = "SELECT 
                  d.* ,
                  u.name_complete empleado
               FROM documentos d 
               INNER JOIN users u ON u.idPersona = d.usuario_alta_id
               LEFT JOIN documentos_puestos dp ON dp.documento_id = d.id AND CASE WHEN d.usuario_alta_id = $usuario THEN TRUE ELSE  dp.puesto_id IN($puesto) END  
               WHERE d.estado = 'ACTIVO' AND nombre_completo NOT IN ('Polizas','Fianzas') AND d.privado = 1 $SQLP $SQLR $SQLRID 
               GROUP BY d.id";
      $SQLT2 = "SELECT 
                  d.*,
                  #u.name_complete empleado
                  '' empleado
               FROM documentos d 
               #INNER JOIN users u ON u.idPersona = d.usuario_alta_id
               WHERE d.estado = 'ACTIVO' AND nombre_completo NOT IN ('Polizas','Fianzas') AND (d.privado IS NULL OR d.privado = 0) $SQLP $SQLR $SQLRID";
      $SQL_RESULT = "$SQLT UNION ALL $SQLT2 ORDER BY id";

      $query = $this->db->query($SQL_RESULT);

      if ($query->num_rows()  > 0) {
         $rows = $query->result();
      }

      return $rows;
   }

   function getDocumentByParent($id)
   {
      $this->db->select('*');
      $this->db->from('documentos');
      $array = array('parent_id' => $id);
      $this->db->where($array);
      $query = $this->db->get();
      return $query->result();
   }

   function getDocument($ref, $ref_id)
   {
      /*  $this->db->select('*');
      $this->db->from('documentos');
      $array = array('referencia_id' => $ref_id, 'referencia' => $ref, 'parent_id IS NOT NULL');
      $this->db->where($array);
      $query = $this->db->get(); */
      $sql = "SELECT * from documentos WHERE referencia_id='" . $ref_id . "' AND referencia='" . $ref . "' AND parent_id IS NOT NULL AND tipo <> 'document' ; ";
      $data = $this->db->query($sql);
      return $data->row();
   }

   function getDocumentV2($ref, $ref_id)
   {
      /*  $this->db->select('*');
      $this->db->from('documentos');
      $array = array('referencia_id' => $ref_id, 'referencia' => $ref, 'parent_id IS NOT NULL');
      $this->db->where($array);
      $query = $this->db->get(); */
      $sql = "SELECT * from documentos WHERE nombre_completo='" . $ref_id . "' ; ";
      $data = $this->db->query($sql);
      return $data->row();
   }

   function getDocumentParentLoad($ref, $ref_id)
   {
      /*  $this->db->select('*');
      $this->db->from('documentos');
      $array = array('referencia_id' => $ref_id, 'referencia' => $ref, 'parent_id IS NOT NULL');
      $this->db->where($array);
      $query = $this->db->get(); */
      $sql = "SELECT * from documentos WHERE referencia_id='" . $ref_id . "' AND nombre not in('Polizas','Fianzas','Endosos') and nombre='". $ref_id ."' order by id desc; ";
      $data = $this->db->query($sql);
      return $data->row();
   }

   function FindByName($Name, $ref_id)
   {
      $sql = "SELECT * from documentos WHERE nombre_completo='" . $Name . "' and referencia_id='" . $ref_id . "'; ";
      $data = $this->db->query($sql);
      return $data->row();
   }

   function getDocumentsByUsuario($ref, $ref_id, $usr_id)
   {
      $this->db->select('*');
      $this->db->from('documentos');
      $array = array('referencia_id' => $ref_id, 'referencia' => $ref, 'usuario_alta_id' => $usr_id);
      $this->db->where($array);
      $tabla = $this->db->get();
      return $tabla;
   }

   function RecuperarDocumentos($data)
   {

      $this->db->select("tipo as Tipo,nombre_completo as NombreCompleto,descripcion as Descripcion,fecha_alta as Fecha, ruta_completa as RutaCompleta, ruta_completa as Download");
      $this->db->from('documentos');
      $this->db->where($data);
      $res = $this->db->get();
      $result = new \stdClass;
      $result->status = true;
      $result->message = array();
      $result->data = $res->result_array();
      //$this->_recuperarDocumentos($data,$result->data);
      if ($result->data > 0) {
         $result->status = true;
         $result->rows = count($result->data);
      } else {
         $result->status = false;
         $result->message[] = 'No se encontra información en el sistema.';
      }
      return $result;
   }

   function getPuestosFile($idFile)
   {
      $res = $this->db->query("select pp.personaPuesto label,pp.idPuesto value from documentos d 
      inner join documentos_puestos dp on d.id=dp.documento_id
      inner join personapuesto pp on dp.puesto_id=pp.idPuesto
      where d.file_id='" . $idFile . "'");
      return $res->result_array();
   }

   function getLastIndexTable($nameTable)
   {
      $res = $this->db->get($nameTable);
      return $res->num_rows() + 1;
   }

   function getPuestosDocument($idDocumentoTabla)
   {
      $obj = $this->db->query('select puesto_id from documentos_puestos where documento_id=' . $idDocumentoTabla);
      $result = $obj->result_array();
      $return = array();
      foreach ($result as $key => $value) {
         $return[] = $value["puesto_id"];
      }

      if (empty($return)) {
         return [];
      } else {
         return $return;
      }
   }

   function getFileByID($id)
   {
      $query = $this->db->where("file_id", $id)
         ->get("documentos");
      return $query->result();
   }

   function UpdateFileDB($Id, $dta)
   {
      return $this->db->where("file_id", $Id)
         ->update('documentos', $dta);
   }

   function getAllDoc($ref, $ref_id, $nombre)
   {
      $this->db->select('*');
      $this->db->from('documentos');
      $array = array('referencia_id' => $ref_id, 'referencia' => $ref, 'nombre' => $nombre, "revision" => 1);
      $this->db->where($array);
      $query = $this->db->get();
      return $query->row();
   }

   function UpdateAllDocs($ref, $ref_id, $nombre, $Irevision, $revision)
   {
      $action = $this->db->where("referencia", $ref)->where("referencia_id", $ref_id)->where("revision", $Irevision);
      if ($nombre != null) {
         $action->where("nombre", $nombre);
      }
      return $action->update('documentos', array(
         "revision" => $revision
      ));
   }

   function GetUpdateAllDocs($ref, $ref_id, $nombre, $revision)
   {
      $action = $this->db->where("referencia", $ref)->where("referencia_id", $ref_id)->where("revision", $revision);
      if ($nombre != null) {
         $action->where("nombre", $nombre);
      }
      $action->get();
      return $action->result_array();
   }

   function getDocumentsByParent($id)
   {
      $this->db->select('*');
      $this->db->from('documentos');
      $array = array('parent_id' => $id);
      $this->db->where($array);
      $query = $this->db->get();
      return $query->result_array();
   }

   function deleteAllById($id)
   {
      return $this->db
         ->where("file_id", $id)
         ->or_where("parent_id", $id)
         ->delete('evaluacion_periodo_competencias');
   }

   function deleteAllRecibosByIDparent($Id)
   {
      $query = "DELETE FROM documentos WHERE parent_id='{$Id}' and nombre_completo like '%Recibo_%' and tipo='application/vnd.google-apps.folder'; ";
      return $this->db->query($query);
   }


   //Metodo nuevo para la parte de la actualizacion de la parte de los archivos 
   function updateAllParent($NewValue, $referencia, $referenciaId)
   {
      $sql = "UPDATE documentos SET parent_id='" . $NewValue . "' WHERE file_id IS NULL AND referencia_id='{$referenciaId}'; ";
      $data = $this->db->query($sql);
      return $data;
   }


   function getById($id)
   {
      $sql = "SELECT * from documentos WHERE file_id='" . $id . "'; ";
      $data = $this->db->query($sql);
      return $data->result_array();
   }

   function UpdateDocument($Id, $data)
   {
      return $this->db->where("file_id", $Id)
         ->update('documentos', $data);
   }
   //Existe document by name
   function getDocumentsByName($Name)
   {
      $this->db->select('*');
      $this->db->from('documentos');
      $array = array('nombre_completo' => $Name);
      $this->db->where($array);
      $query = $this->db->get();
      return $query->result_array();
   }

   function getFilesUserByUsuario($usuario_id)
   {

      $rows = array();
      $documento_id = 0;
      $SQLP = null;
      $SQLR = null;
      $SQLRID = null;
      $usuario = -1;

      $SQL_RESULT = "SELECT * FROM capsysV3.documentos WHERE referencia_id=$usuario_id AND TypeDoc='DOCUMENT' AND referencia='CLIENT' and file_id is not null ORDER BY id";

      $query = $this->db->query($SQL_RESULT);

      if ($query->num_rows()  > 0) {
         $rows = $query->result();
      }

      return $rows;
   }

   function getFilesDocumentsByParent($parent_id, $referencia = null, $referenciaId = null, $parentId = null)
   {

      $rows = array();
      $documento_id = 0;
      $SQLP = null;
      $SQLR = null;
      $SQLRID = null;
      $usuario = -1;

      $SQL_RESULT = "SELECT * FROM capsysV3.documentos where parent_id = '{$parent_id}' AND TypeDoc='DOCUMENT' AND referencia='CLIENT' and file_id is not null ORDER BY id";

      $query = $this->db->query($SQL_RESULT);

      if ($query->num_rows()  > 0) {
         $rows = $query->result();
      }

      return $rows;
   }
}
