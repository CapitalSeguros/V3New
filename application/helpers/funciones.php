<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Metodo getDiasHabiles
 * 
 * Permite devolver un arreglo con los dias habiles
 * entre el rango de fechas dado excluyendo los
 * dias feriados dados (Si existen)
 * 
 * @param string $fechainicio Fecha de inicio en formato Y-m-d
 * @param string $fechafin Fecha de fin en formato Y-m-d
 * @param array $diasferiados Arreglo de dias feriados en formato Y-m-d
 * @return array $diashabiles Arreglo definitivo de dias habiles
 */
function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array())
{
    // Convirtiendo en timestamp las fechas
    $fechainicio = strtotime($fechainicio);
    $fechafin = strtotime($fechafin);

    // Incremento en 1 dia
    $diainc = 24 * 60 * 60;

    // Arreglo de dias habiles, inicianlizacion
    $diashabiles = array();

    // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
    for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
        // Si el dia indicado, no es sabado o domingo es habil
        if (!in_array(date('N', $midia), array(6, 7))) { // DOC: http://www.php.net/manual/es/function.date.php
            // Si no es un dia feriado entonces es habil
            if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                array_push($diashabiles, date('Y-m-d', $midia));
            }
        }
    }

    return $diashabiles;
}
