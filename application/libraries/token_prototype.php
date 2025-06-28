<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Token_prototype
{

    var $ci;

    function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->library("encrypt");
        //$this->ci->load->helper("cookie");
        $this->setPrototypeToken();
    }

    function setPrototypeToken()
    {

        $data = array(
            "account" => $this->ci->tank_auth->get_usermail(),
            "id" => $this->ci->tank_auth->get_idPersona()
        );

        //$userEncrypt = //json_encode($data);  //$this->ci->encrypt->encode(json_encode($data));
        $userEncrypt = $this->ci->encrypt->encode(json_encode($data));
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($userEncrypt, TRUE));fclose($fp);

        setcookie("login_account", $userEncrypt, time() + 3600, "/");
        //$this->ci->output->set_header("Session-User: " . $userEncrypt);
    }
}
