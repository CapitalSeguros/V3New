<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class listColaboradores extends CI_Controller{

    function __construct(){
        parent::__construct();
    }   
    function index(){
        $result = [];
        $result['first_name'] = "John";
        $result['last_name'] = "Doe";
        echo json_encode($result);
    }
}