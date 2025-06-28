<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo que trabaja con registros de la tabla <clientelealtadpuntos>
 */
class validar_clp_model extends CI_Model
{
    // Tipo de Persona Fiscal
    const FISICA = 0;
    const MORAL = 1;

    function __construct()
    {
        parent::__construct();
        $this->load->library(array("webservice_sicas_soap","role","libreriav3","ws_sicas","FiltrosDeReportesSicas"));
        $this->load->database();
    }

    /**
     * Valida que el objeto sea un array y no este vacio
     */
    private function estaVacio($datos){
        $vacio = TRUE;
        if (is_array($datos) && !empty($datos)) {
            $vacio = FALSE;
        }
        return $vacio;
    }

    /**
     * Crea un nuevo registro en la tabla <clienteleatadpuntos>
     */
    private function crearCliente($idCliente){
        $datosCliente = $this->webservice_sicas_soap->GetClient_forID($idCliente);
        //si los datos del cliente son enviados correctamente procedemos a crearlo en la tabla
        if(!$this->estaVacio($datosCliente) && $datosCliente['cliente'] !== null){
            $insert = array();
            $insert['NombreCompleto']=(string)$datosCliente['cliente']->NombreCompleto;
            $insert['nombreCliente']=(string)$datosCliente['cliente']->NombreCompleto;
            $insert['IDVend']=(int)$datosCliente['cliente']->FieldInt1;
            $insert['IDCli']=(int)$datosCliente['cliente']->IDCli;
            $insert['RFC']=(string)$datosCliente['cliente']->RFC;
            $insert['Sexo']=(int)$datosCliente['cliente']->Sexo;
            $insert['tipoEntidad']=(string)$datosCliente['cliente']->TipoEnt;
            $insert['Telefono1']="";
            $insert['EMail1']="";

            $tipoEntidad = (int)$datosCliente['cliente']->TipoEnt;
            if($tipoEntidad === self::FISICA){
                $insert['ApellidoP']=(string)$datosCliente['cliente']->ApellidoP;
                $insert['ApellidoM']=(string)$datosCliente['cliente']->ApellidoM;
                $insert['Nombre']=(string)$datosCliente['cliente']->Nombre;
            }elseif($tipoEntidad === self::MORAL){
                $insert['RazonSocial']=(string)$datosCliente['cliente']->RazonSocial;
            }

            $this->db->insert('clientelealtadpuntos', $insert);
        }
    }

    /**
     * Valida que exista el cliente en la tabla <clientelealtadpuntos>
     */
    public function validarExistenciaEnTabla($idCliente)
    {
        //verificamos si el cliente existe en la tabla, caso contrario lo creamos
        $consulta = "SELECT EXISTS(SELECT 1 FROM clientelealtadpuntos WHERE IDCli = ".$idCliente.") AS 'existe'";
        $registro = $this->db->query($consulta)->row();
        if(!$registro->existe){ //no existe el cliente y procedemos a crearlo
            $this->crearCliente($idCliente);
        }
    }
}