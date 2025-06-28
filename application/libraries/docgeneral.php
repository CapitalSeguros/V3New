<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require('KLogger/vendor/autoload.php');

class docgeneral
{

    //------------------------------------------------------------------------------------------------------------------------
    function __construct()
    {

        $this->CI = &get_instance();
    }

    //funciones view 
    public function slugify($text){
        $divider = '_';
        $text = preg_replace("~[^\pL\d]+~u", $divider, $text);
        $text = iconv("utf-8", "us-ascii//TRANSLIT", $text);
        $text = preg_replace("~[^-\w]+~", '', $text);
        $text = trim($text, $divider);
        $text = preg_replace("~-+~", $divider, $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    public function GetIcon($type)
    {
        $Icon = "";
        switch ($type) {
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            case 'application/vnd.ms-excel':
                $Icon = base_url() . "assets/img/icons/excel.png";
                break;
            case 'application/pdf':
                $Icon = base_url() . "assets/img/icons/pdf.png";

                break;
            case 'application/msword':
                $Icon = base_url() . "assets/img/icons/word.png";
                break;
            default:
                $Icon = base_url() . "assets/img/icons/other.png";
                break;
        }
        return $Icon;
    }
}
