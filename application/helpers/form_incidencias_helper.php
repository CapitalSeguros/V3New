<?php 
function getFormRules(){
    return  array(
        array(
            "field" => 'smsText',
            "label" => 'Comentario',
            "rules" => 'required',
            "errors" => array(
                "required" => '*El %s es requerido',
            ),
        ),
        array(
            "field" => 'Tipo',
            "label" => 'Tipo de incidencia',
            "rules" => 'required|trim',
            "errors" => array(
                "required" => '* El %s es requerido',
                //"greater_than[0]"=>'*Seleccione una opción correcta'
            ),
        ),
        array(
            "field" => 'dias',
            "label" => 'Dias',
            "rules" => 'required|trim',
            "errors" => array(
                "required" => '*La %s es requerida',
                //"Callback_is_numeric"=>'El campo solo debe contener valores numericos'
                //"callback_is_start_date_valid"=>'El campo {field} debe estar con formato "yyyy-mm-dd"',
            ),
        ),
        array(
            "field" => 'fechaStart',
            "label" => 'Fecha de inicio',
            "rules" => 'required|trim|callback_is_start_date_valid',
            "errors" => array(
                "required" => '*La %s es requerida',
                //"callback_is_start_date_valid"=>'El campo {field} debe estar con formato "yyyy-mm-dd"',
            ),
        ),
    );
}