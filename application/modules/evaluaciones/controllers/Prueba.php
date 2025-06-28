<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Prueba extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        echo 'Prueba';
    }

}
