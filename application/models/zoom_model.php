<?php 

class zoom_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function inserta_token($token){

        if($this->db->count_all_results("meeting_token_events")>0){

            //$update=array("token"=>$token);

            /*$this->db->where("idToken",1);
            $this->db->update("meeting_token_events",$token);*/

            $this->db->truncate("meeting_token_events");
            $this->db->insert("meeting_token_events",$token);

        } else{

            $this->db->insert("meeting_token_events",$token);
        }
    }

    function get_access_token(){
    
        $resultado=array();

        $this->db->select("token");
        $this->db->where("idToken",1);
        $query=$this->db->get("meeting_token_events");

        if($query->num_rows()>0){
            $resultado=$query->row_array();
        }

        return json_decode($resultado["token"]);
    }

    function inserta_meeting_para_evento($array){

        $resultado=false;

        $this->db->insert("calendar_zoom_meetings",$array);

        if($this->db->trans_status()===FALSE){
            $this->db->trans_rollback();
        } else{
            $this->db->trans_commit();
            $resultado=true;
        }

        return $resultado;
    }

    function get_zoom_event($id_evento){
        
        $resultado=array();

        $this->db->where("id_evento",$id_evento);
        $query=$this->db->get("calendar_zoom_meetings");

        if($query->num_rows()>0){
            $resultado=$query->row();
        }

        return $resultado;

    }

    //------------------------Fin del metodo---------------------------------
}

?>