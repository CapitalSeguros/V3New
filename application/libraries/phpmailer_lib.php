<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */

//use PHPMailerPHPMailerPHPMailer;
//use PHPMailerPHPMailerException;
class phpmailer_lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        /*require_once APPPATH.'libraries/PHPMailer/src/Exception.php';
        require_once APPPATH.'libraries/PHPMailer/src/PHPMailer.php';
        require_once APPPATH.'libraries/PHPMailer/src/SMTP.php';
        require_once APPPATH.'libraries/PHPMailer/src/OAuth.php';
        require_once APPPATH.'libraries/PHPMailer/src/POP3.php';*/
        //require_once APPPATH.'third_party/PHPMailer/Exception.php';
       // $ruta=require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        //require_once APPPATH.'third_party/PHPMailer/SMTP.php';
         //require_once('PHPMailer/class.phpmailer.php');
        // $this->load->library('PHPMailer.php');
       
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/OAuth.php';
        require_once APPPATH.'third_party/PHPMailer/POP3.php';
        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(APPPATH,TRUE));fclose($fp);
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        return $mail;
    }
}