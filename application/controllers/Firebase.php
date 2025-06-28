<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Firebase extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}
    $this->config->load('firebase');
  }

  public function getFirebaseConfig()
  {
    $firebaseConfig = $this->config->item('firebase');
    echo json_encode($firebaseConfig);
  }
}
