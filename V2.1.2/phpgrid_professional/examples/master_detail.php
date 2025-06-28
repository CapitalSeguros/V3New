<?php
require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Master/Detail, Parent/Child PHP Datagrid</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM cobranzapendiente", array("idCobranzaPendiente","poliza"), "cobranzapendiente");

// change column titles
//** $dg->set_col_title("orderNumber", "Order No.");
 
// enable edit
//** $dg->enable_edit("INLINE", "CRUD"); // CRUD || ->C=Create ->R=Review ->U=Update ->D=Delete

// hide a column
//$dg -> set_col_hidden("requiredDate");

// read only columns, one or more columns delimited by comma
//$dg -> set_col_readonly("orderDate, customerNumber");

// required fields
//** $dg -> set_col_required("orderNumber, customerNumber");
                                                                  
// multiple select
$dg -> set_multiselect(true);

// second grid as detail grid. Notice it is just another regular phpGrid with properites.
//** SELECT orderNumber,productCode,quantityOrdered,priceEach FROM orderdetails
$sdg = new C_DataGrid("SELECT * FROM cobranzapendiente_comentarios", array("idComentario", "poliza"), "cobranzapendiente_comentarios");

//** $sdg->set_col_hidden("orderNumber");
/*
$sdg->set_col_title("orderNumber", "Order No.");
$sdg->set_col_title("productCode", "Product Code");
$sdg->set_col_title("quantityOrdered", "Quantity");
$sdg->set_col_title("priceEach", "Unit Price");
$sdg->set_col_dynalink("productCode", "http://www.example.com/", "orderLineNumber", '&foo');
$sdg->set_col_format('orderNumber','integer', array('thousandsSeparator'=>'','defaultValue'=>''));
$sdg->set_col_currency('priceEach','$');
*/

// enable CRUD for detail grid
$sdg->enable_edit("FORM", "CR"); // CRUD || ->C=Create ->R=Review ->U=Update ->D=Delete

$dg->set_masterdetail($sdg, 'poliza');

$dg ->enable_search(true);
$dg->enable_export('EXCEL'); //PDF

$dg->display();
?>
</body>
</html>