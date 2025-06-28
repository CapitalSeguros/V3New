<?php

class Diary_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    //--------------------
    function getEvents($account)
    {

        try {

            $query = "SELECT ev.* FROM diary_event ev
            LEFT JOIN diary_client cli ON  cli.email = ev.organizer
            LEFT JOIN diary_meet me ON ev.id = me.id
            LEFT JOIN diary_guest ge ON ev.id = ge.event
            WHERE ev.active = 1 AND (ev.organizer = '" . $account . "' OR ge.guest = '" . $account . "')
            GROUP BY ev.id
            ORDER BY ev.id ASC";

            return $this->db->query($query)->result_array();
        } catch (Exception $e) {

            $this->sendException($e->getMessage());
        }
    }
    //--------------------
    function insertEvent($json)
    {

        try {

            $this->db->trans_start();
            $this->db->insert("diary_event", $json["event"]);
            $lastId = $this->db->insert_id();

            if (isset($json["client"])) {

                $json["client"]["event"] = $lastId;
                $this->db->insert("diary_client", $json["client"]);
            }

            if (isset($json["meet"])) {

                $json["meet"]["id"] = $lastId;
                $this->db->insert("diary_meet", $json["meet"]);
            }

            if (isset($json["attendes"])) {

                //$data["event"] = $idEvent; //diary_guest
                $attendes = array_map(function ($att) use ($lastId) {
                    $att["event"] = $lastId;
                    return $att;
                }, $json["attendes"]);
                $this->db->insert_batch("diary_guest", $attendes);
            }

            if (isset($json["service"])) {
                $json["service"]["event_id"] = $lastId;
                $this->db->insert("diary_services", $json["service"]);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception($this->db->_error_message());
            }

            return $lastId;
        } catch (Exception $e) {

            $this->db->trans_rollback();
            $this->sendException($e->getMessage());
        }
    }
    //--------------------
    function insertEvent1v($json)
    {

        try {

            $this->db->insert("calendario_citas_asesores", $json);

            return true;
        } catch (Exception $e) {
            //$this->db->trans_rollback();
            $this->sendException($e->getMessage());
        }
    }
    //--------------------
    function insertInCalendar1v($json)
    {

        try {

            $this->db->insert("citascalendar", $json);

            return true;
        } catch (Exception $e) {
            //$this->db->trans_rollback();
            $this->sendException($e->getMessage());
        }
    }
    //--------------------
    function updateEvent($event, $eventData, $isPatch = false)
    {

        try {

            $this->db->trans_start();
            $this->db->update("diary_event", $eventData["event"], array("id" => $event));

            if ($isPatch) {

                if (isset($eventData["meet"])) {

                    $this->db->update("diary_meet", $eventData["meet"], array("id" => $event));
                }

                if (isset($eventData["client"])) {
                    $this->db->update("diary_client", $eventData["client"], array("event" => $event));
                }

                if (isset($eventData["attendes"])) {
                    if (isset($eventData["attendes"]["agree"])) {

                        $this->db->insert_batch("diary_guest", $eventData["attendes"]["agree"]);
                    }

                    if (isset($eventData["attendes"]["delete"])) {
                        $this->db->where("event", $event)
                            ->where_in("guest", $eventData["attendes"]["delete"])
                            ->delete("diary_guest");
                    }
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception($this->db->_error_message());
            }

            return true;
        } catch (Exception $e) {

            $this->db->trans_rollback();
            $this->sendException($e->getMessage());
        }
    }
    //--------------------
    function deleteGuest($event)
    {
        try {

            $this->db->trans_start();
            $this->db->delete("diary_guest", array("event" => $event));

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception($this->db->_error_message());
            }

            return true;
        } catch (Exception $e) {

            $this->db->trans_rollback();
            $this->sendException($e->getMessage());
        }
    }
    //--------------------
    function deleteMeet($event)
    {
        try {

            $this->db->trans_start();
            $this->db->delete("diary_meet", array("id" => $event));

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception($this->db->_error_message());
            }

            return true;
        } catch (Exception $e) {

            $this->db->trans_rollback();
            $this->sendException($e->getMessage());
        }
    }
    //--------------------
    function getEventById($event)
    {

        $query = "SELECT me.id AS idMeet, ev.id AS idEvent, me.active AS meetActive ,ev.*, cli.*, me.*, se.* FROM diary_event ev
        LEFT JOIN diary_client cli ON  cli.event = ev.id
        LEFT JOIN diary_meet me ON ev.id = me.id
        LEFT JOIN diary_services se ON ev.id = se.event_id
        WHERE ev.id = " . $event . "
        ORDER BY ev.id ASC";

        return $this->db->query($query)->row_array();
    }
    //--------------------
    function getAttendes($event)
    {

        $query = "SELECT guest AS id, us.email as guest, participation, pe.nombres, pe.apellidoPaterno, pe.apellidoMaterno, ui.fotoUser,
            IF(
                pe.tipoPersona = 1 OR pe.esAgenteColaborador = 1, 
                    (SELECT colaboradorarea FROM colaboradorarea WHERE idColaboradorArea = pe.idColaboradorArea),
                    idpersonarankingagente
            ) AS area
            FROM diary_guest ge 
            LEFT JOIN users us ON ge.guest = us.idPersona
            LEFT JOIN persona pe ON us.idPersona = pe.idPersona
            LEFT JOIN user_miInfo ui ON pe.idPersona = ui.idPersona
            WHERE ge.event = " . $event . ""; //ca.colaboradorArea LEFT JOIN colaboradorarea ca ON pe.idColaboradorArea = ca.idColaboradorArea

        return $this->db->query($query)->result_array();
    }
    //--------------------
    function getUsers()
    {

        $query = "SELECT p.nombres, p.apellidoPaterno, p.apellidoMaterno, u.email, p.idpersonarankingagente AS AREA_CANAL FROM persona p 
            LEFT JOIN users u ON u.idPersona = p.idPersona
            WHERE u.activated = 1 
            AND u.banned = 0 AND p.bajaPersona = 0 AND p.tipoPersona = 3 AND p.idpersonarankingagente != '' AND p.idpersonarankingagente IS NOT NULL";
        $exec = $this->db->query($query)->result_array();

        $query2 = "SELECT p.nombres, p.apellidoPaterno, p.apellidoMaterno, u.email, UPPER(c.colaboradorArea) AS AREA_CANAL FROM users u 
            LEFT JOIN persona p ON u.idPersona = p.idPersona
            LEFT JOIN colaboradorarea c ON p.idColaboradorArea = c.idColaboradorArea
            WHERE u.activated = 1 
            AND u.banned = 0 AND p.bajaPersona = 0 AND (p.tipoPersona = 1 OR p.esAgenteColaborador = 1)";
        $exec2 = $this->db->query($query2)->result_array();

        return array_merge($exec, $exec2);
    }
    //--------------------
    function validRequestCode($code)
    {

        $query = $this->db->where("token", $code)->get("calendario_citas_asesores")->num_rows();
        return $query > 0;
    }
    //--------------------
    private function sendException($reason)
    {

        $errorResponse = array(
            "code" => 500,
            "status" => "error",
            "message" => "Ha ocurrido un detalle durante el proceso de su petición, favor de contactar al departamente de sistemas para más información",
            "reason" => $reason
        );

        $this->output
            ->set_status_header(500)
            ->set_content_type("application/json", "utf-8")
            ->set_output(
                json_encode(
                    $errorResponse,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                )
            )
            ->_display();
        exit;
    }
    //--------------------
    function takeMyParticipation($json)
    {
        try {

            $this->db->trans_start();
            $this->db->where($json["condition"])->update("diary_guest", ["participation" => $json["participation"]]);

            if ($this->db->trans_status() === FALSE) {
                throw new Exception($this->db->_error_message());
            }

            $this->db->trans_complete();
            return $this->db->trans_status();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->sendException($e->getMessage());
        }
    }
    //--------------------

}
