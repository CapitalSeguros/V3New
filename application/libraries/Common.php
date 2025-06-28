<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require("Holiday_librarie.php");
class Common
{
    var $CI;
    function __construct()
    {
        $this->CI = &get_instance();
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
    function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array(), $sabadoHabil = false)
    {
        $diasInhabil = array(6, 7);
        if ($sabadoHabil) {
            $diasInhabil = array(7);
        }
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
            if (!in_array(date('N', $midia), $diasInhabil)) { // DOC: http://www.php.net/manual/es/function.date.php
                // Si no es un dia feriado entonces es habil
                if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                    array_push($diashabiles, date('Y-m-d', $midia));
                }
            }
        }

        return $diashabiles;
    }

    function getDateHoliday($years)
    {
        $arrayHoliday = new Holiday();
        foreach ($years as $year) {
            $holi = $arrayHoliday->getFestivos($year);
            foreach ($holi[$year] as $key1 => $value) {
                $valueMonth = $this->addZeroToDate($key1);
                foreach ($value as $key2 => $value) {
                    $arrayDate[] = $year . "-" . $valueMonth . "-" . $this->addZeroToDate($key2);
                }
            }
        }
        asort($arrayDate, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
        return $arrayDate;
    }

    function addZeroToDate($date)
    {
        $date;
        if ($date < 10) {
            $complete = "0" . $date;
        } else {
            return $date;
        }
        return $complete;
    }

    function last_date($fecha, $periodo = 0)
    {
        if (!empty($periodo)) {
            $periodo = $periodo - 1;
            $lastDate = date("Y-m-t", strtotime("$fecha +$periodo month"));
        } else {
            $lastDate = date("Y-m-t", strtotime($fecha));
        }
        return $lastDate;
    }

    function first_date($fecha)
    {
        $firstDate = date("Y-m-01", strtotime($fecha));
        return $firstDate;
    }  

    function getfechaanual($fecha){
        $firstDate["fecha_inicio_anual"] = date("Y-01-01", strtotime("$fecha"));
        $firstDate["fecha_fin_anual"] = date("Y-12-t", strtotime("$fecha"));
        return $firstDate;
    }

    
    
}
