<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class estadisticas_marketing extends CI_Controller {
    
    function __construct(){
        parent::__construct();
     }

     function init(){

        $this->data['casado']=$this->getDato('EdoCivil','CASADO');
        $this->data['casado_hijos']=$this->getDato('EdoCivil','CASADOCONHIJOS');
        $this->data['divorciado']=$this->getDato('EdoCivil','DIVORCIADOS');
        $this->data['divorciado_hijos']=$this->getDato('EdoCivil','DIVORCIADOSCONHIJOS');
        $this->data['soltero']=$this->getDato('EdoCivil','SOLTERO');
        $this->data['soltero_hijos']=$this->getDato('EdoCivil','SOLTEROCONHIJOS');
        $this->data['unionlibre']=$this->getDato('EdoCivil','UNIONLIBRE');
        $this->data['unionlibre_hijos']=$this->getDato('EdoCivil','UNIONLIBRECONHIJOS');
        $this->data['viudo']=$this->getDato('EdoCivil','VIUDO');
        $this->data['viudo_hijos']=$this->getDato('EdoCivil','VIUDOCONHIJOS');

        $this->data['MENOSDE18']=$this->getDato('RangodeEdad','MENOSDE18');
        $this->data['DE19A35']=$this->getDato('RangodeEdad','DE19A35');
        $this->data['DE36A50']=$this->getDato('RangodeEdad','DE36A50');
        $this->data['DE51A65']=$this->getDato('RangodeEdad','DE51A65');

        $this->data['amadecasa']=$this->getDato('Ocupacion','AMADECASA');
        $this->data['ejecutivo']=$this->getDato('Ocupacion','EJECUTIVO');
        $this->data['empleado']=$this->getDato('Ocupacion','EMPLEADO');
        $this->data['empresario']=$this->getDato('Ocupacion','EMPRESARIO');
        $this->data['gerente']=$this->getDato('Ocupacion','GERENTE');
        $this->data['negociopropio']=$this->getDato('Ocupacion','NEGOCIOPROPIO');
        $this->data['profesionistaindependiente']=$this->getDato('Ocupacion','PROFESIONISTAINDEPENDIENTE');
        $this->data['retirado']=$this->getDato('Ocupacion','RETIRADO');
        $this->data['otrospempleos']=$this->getDato('Ocupacion','OTROSEMPLEOS');
        $this->data['estudiante']=$this->getDato('Ocupacion','ESTUDIANTE');


        $this->data['AMIGODEESCUELA']=$this->getDato('FuenteProspecto','AMIGODEESCUELA');
        $this->data['VECINOS']=$this->getDato('FuenteProspecto','VECINOS');
        $this->data['AMIGODEFAMILIA']=$this->getDato('FuenteProspecto','AMIGODEFAMILIA');
        $this->data['CONOCIDOPASATIEMPOS']=$this->getDato('FuenteProspecto','CONOCIDOPASATIEMPOS');
        $this->data['FAMPROPIAOCONYUGUE']=$this->getDato('FuenteProspecto','FAMPROPIAOCONYUGUE');
        $this->data['CONOCIDOGRUPOSOCIAL']=$this->getDato('FuenteProspecto','CONOCIDOGRUPOSOCIAL');
        $this->data['CONOCIDOACTIVICOMUNIDAD']=$this->getDato('FuenteProspecto','CONOCIDOACTIVICOMUNIDAD');
        $this->data['CONOCIDOANTIGUOEMPLEO']=$this->getDato('FuenteProspecto','CONOCIDOANTIGUOEMPLEO');
        $this->data['PERSONASHACENEGOCIO']=$this->getDato('FuenteProspecto','PERSONASHACENEGOCIO');
        $this->data['CENTRODEINFLUENCIA']=$this->getDato('FuenteProspecto','CENTRODEINFLUENCIA');

        $this->data['HABILIDADEXCELENTE']=$this->getDato('HabilidadRef','EXCELENTE');
        $this->data['HABILIDADBUENA']=$this->getDato('HabilidadRef','BUENA');
        $this->data['HABILIDADREGULAR']=$this->getDato('HabilidadRef','REGULAR');

        $this->data['MENOSDE25000']=$this->getDato('IngresoMensual','MENOSDE$25000');
        $this->data['DE25000A60000']=$this->getDato('IngresoMensual','DE$25000A$60000');
        $this->data['DE6000A100000']=$this->getDato('IngresoMensual','DE$6000A$100000');
        $this->data['MASDE100000']=$this->getDato('IngresoMensual','MASDE$100000');

        $this->data['FACILMENTE']=$this->getDato('PosibiAcercamiento','FACILMENTE');
        $this->data['NOMUYDIFICIL']=$this->getDato('PosibiAcercamiento','NOMUYDIFICIL');
        $this->data['CONDIFICULTAD']=$this->getDato('PosibiAcercamiento','CONDIFICULTAD');
       
        $this->load->view('crmproyecto/estadisticas_marketing',$this->data);
     }

     function getDato($campo, $valor){
        $ct=0;
        $valor="'".$valor."'";
        $sql="SELECT COUNT(*) as total FROM clientes_actualiza WHERE ".$campo."=".$valor;
        $rs=$this->db->query($sql)->result();
        $ct=$rs[0]->total;
        return $ct;
     }
}
?>