<?php
//require_once('phpgrid/conf.php');
require_once(APPPATH.'../assets/phpgrid/conf.php');

class CI_phpgrid {
    public function example_method($val = '')
    {
        $dg = new C_DataGrid("SELECT * FROM Orders", $val, "Orders");
        return $dg;
    }
}