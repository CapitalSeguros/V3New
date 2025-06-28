<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Agente_model extends CI_Model {

        public function getAgent($id){

            $query = " SELECT 
                    activar_userInfo.id_user,
                    user_miInfo.fotoUser,
                    user_miInfo.emailUser,
                    user_miInfo.nombre,
                    user_miInfo.apellidoP,
                    user_miInfo.cedula_cnsf,
                    activar_userInfo.*,
                    CONCAT('https://www.capsys.com.mx/V3/assets/img/miInfo/userPhotos/', user_miInfo.fotoUser) AS photoUrl
                FROM user_miInfo
                LEFT JOIN activar_userInfo ON activar_userInfo.id_user = user_miInfo.idPersona
                WHERE idPersona = ".$id."
            ";

            //calendario_conf_personal.* INNER JOIN calendario_conf_personal ON calendario_conf_personal.idPersona = user_miInfo.idPersona

            return $this->db->query($query)->row_array();
        }

        public function getAvailable($id){

            $query = "SELECT * FROM calendario_conf_capital WHERE idPersona = ".$id." AND disponible = 1 AND year >= YEAR(NOW())";
            return $this->db->query($query)->result_array();
        }
    }
?> 