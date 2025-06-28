<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reportesModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();  
        // $this->load->library('graficos');      
    }

    function getreporteincidencia()
    {
        $row = array();
        $SQL = "SELECT idincidencias,fecha_alta FROM incidencias WHERE estatus ='AUTORIZADO'";
        $query = $this->db->query($SQL);

        if ($query->num_rows() > 0) {
            $row = $query->result();
        }
        return $row;
    }

    function getreporteevaluacion()
    {
        $row = array();
        $SQL = "SELECT id,fecha_inicio FROM evaluacion_periodos WHERE estatus = 'BORRADOR'";
        $query = $this->db->query($SQL);

        if ($query->num_rows() > 0) {
            $row = $query->result();
        }

        return $row;
    }

    function getprueba()
    {
        print_r($this->graficos->getreporte(null, null));
    }
}
