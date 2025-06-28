<?php 
function getFormRulesTipo(){
    return  array(
        array(
            "field" => 'Nombre',
            "label" => 'Nombre',
            "rules" => 'required|trim',
            "errors" => array(
                "required" => '*El %s es requerido',
            ),
        ),
        array(
            "field" => 'smsText',
            "label" => 'Comentario',
            "rules" => 'required|trim',
            "errors" => array(
                "required" => '*El %s es requerido',
            ),
        )
    );
}