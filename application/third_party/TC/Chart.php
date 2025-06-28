<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Chart
{
    public $chart;
    public $title;
    public $tooltip;
    public function __construct()
    {
        $this->loadData();
        $this->autoLoader();
    }

    protected function autoLoader()
    {
    }

    protected function loadData()
    {
        $this->chart = new \stdClass();
        $this->chart->type = "line";
        $this->title = new \stdClass();

        $this->title->text = "Generic";
        $this->title->aling = "left";
        
        $this->tooltip = new \stdClass();
        $this->tooltip->enable = true;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }
}
