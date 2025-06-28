<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class servicioSistema extends TIC_Controller
{
    public $load;
    function __construct()
    {
        parent::__construct();
        //$this->load->model('gmm_model', 'gmm');
        $this->load->library('session');
        $this->load->library('googledrive');
        $this->load->helper('url');
        $this->lang->load('tank_auth');
        $this->load->model('serviciotic_model', 'ticc');
    }

    function index()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-tcambios.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-fmanager.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-rpago.js'
            )
        ));
        $this->render('servicioSistema/index', $head, $data, $footer);
    }

    public function OrdenTrabajo()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        //$puesto=$this->tank_auth->get_idPersona();
        //$permisos=$this->ticc->getPermisosPuesto($puesto,'OrdenTrabajo');
        $permisos = array();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-tablero.js'
            )
        ));
        $this->render('servicioSistema/OT/indexv2', $head, $data, $footer);
    }

    public function OrdenTrabajo2()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        //$puesto=$this->tank_auth->get_idPersona();
        //$permisos=$this->ticc->getPermisosPuesto($puesto,'OrdenTrabajo');
        $permisos = array();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
        ));
        $this->render('servicioSistema/OT/index2', $head, $data, $footer);
    }

    public function OrdenTrabajoV2()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        //$puesto=$this->tank_auth->get_idPersona();
        //$permisos=$this->ticc->getPermisosPuesto($puesto,'OrdenTrabajo');
        $permisos = array();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-tablero.js'
            )
        ));
        $this->render('servicioSistema/OT/indexv2', $head, $data, $footer);
    }

    public function OrdenTrabajoEdit($id = null)
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["idRegistro"] = $id;
        $data["Usuario"] = $this->tank_auth->get_usernamecomplete();
        $puesto = $this->tank_auth->get_idPersona();
        $permisos = $this->ticc->getPermisosPuesto($puesto, 'OrdenTrabajo');

        if ($id == "") {
            redirect('');
        }

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-capturas.js'
            )
        ));
        $this->render('servicioSistema/OT/Edit', $head, $data, $footer);
    }

    public function OrdenTrabajoNew()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        //$data["idRegistro"] = $id;
        $data["Usuario"] = $this->tank_auth->get_usernamecomplete();
        $puesto = $this->tank_auth->get_idPersona();
        $permisos = $this->ticc->getPermisosPuesto($puesto, 'OrdenTrabajo');

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-capturas.js'
            )
        ));
        $this->render('servicioSistema/OT/Nuevo', $head, $data, $footer);
    }

    public function AccionPestana($id = null, $accion, $modulo)
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["idRegistro"] = $id;
        $data["accion"] = $accion;
        $data["modulo"] = $modulo;
        $data["Usuario"] = $this->tank_auth->get_usernamecomplete();
        $this->load->view('servicioSistema/AccionPestana/index', $data);
    }

    function EstatusDocumento()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/EstatusDocumento/index', $head, $data, $footer);
    }
    function EstatusUsuario()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/EstatusUsuario/index', $head, $data, $footer);
    }

    function Servicio()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Servicio/index', $head, $data, $footer);
    }

    function UsoServicio()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/UsoServicio/index', $head, $data, $footer);
    }

    function Marca()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Marca/index', $head, $data, $footer);
    }

    function SubMarca()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/SubMarca/index', $head, $data, $footer);
    }

    function Color()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Color/index', $head, $data, $footer);
    }

    function Grupo()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Grupo/index', $head, $data, $footer);
    }

    function SubGrupo()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/SubGrupo/index', $head, $data, $footer);
    }

    function TipoFianza()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/TipoFianza/index', $head, $data, $footer);
    }

    function ProductoFianza()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/ProductoFianza/index', $head, $data, $footer);
    }


    function ClasificacionDocumento()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/ClasificacionDocumento/index', $head, $data, $footer);
    }

    function TipoDocumento()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/TipoDocumento/index', $head, $data, $footer);
    }

    function TipoDoc()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/TipoDoc/index', $head, $data, $footer);
    }

    
    function Bancos()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/TipoBanco/index', $head, $data, $footer);
    }


    function Ramo()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Ramo/index', $head, $data, $footer);
    }

    function Moneda()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Moneda/index', $head, $data, $footer);
    }

    function FormaPago()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/FormaPago/index', $head, $data, $footer);
    }

    function EstatusCobro()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/EstatusCobro/index', $head, $data, $footer);
    }

    function LineaNegocio()//LineaCobro
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/LineaCobro/index', $head, $data, $footer);
    }

    function Oficinas()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Oficinas/index', $head, $data, $footer);
    }

    function TipoPago()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/TipoPago/index', $head, $data, $footer);
    }

    function TipoVenta()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/TipoVenta/index', $head, $data, $footer);
    }

    function ConductoCobro()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/ConductoCobro/index', $head, $data, $footer);
    }

    function EstatusRecuperacion()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/EstatusRecuperacion/index', $head, $data, $footer);
    }

    function Departamento()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Departamento/index', $head, $data, $footer);
    }

    function Gerencias()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Gerencias/index', $head, $data, $footer);
    }

    function Direcciones()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Direcciones/index', $head, $data, $footer);
    }

    function Compania()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Compania/index', $head, $data, $footer);
    }

    function CompaniaAdd()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-compania.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Compania/Add', $head, $data, $footer);
    }

    function CompaniaEdit($id = null)
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["idRegistro"] = $id;

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-compania.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Compania/Edit', $head, $data, $footer);
    }

    public function Vendedores()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        //$data["idRegistro"]=$id;

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-compania.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Vendedores/index', $head, $data, $footer);
    }

    public function VendedorAdd()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["Usuario"] = $this->tank_auth->get_usernamecomplete();
        //$data["idRegistro"]='';

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-vendedor.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Vendedores/Add', $head, $data, $footer);
    }

    public function VendedorEdit($id)
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["idRegistro"] = $id;
        $data["Usuario"] = $this->tank_auth->get_usernamecomplete();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-vendedor.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Vendedores/Edit', $head, $data, $footer);
    }

    function SaveDocumentos()
    {
        $result = new \stdClass;
        $result->ok = true;

        //Datos
        $Id = $this->input->post("Id");
        $Modulo = $this->input->post("Modulo");
        $Tipo = $this->input->post("Tipo");

        if (!empty($_FILES)) {
            $keys = array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('Documentos', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('DOC_' . $Id, $padre);
            $count = 0;
            foreach ($_FILES as $file) {
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());

                $this->saveDoc($uploadFile->data, '', 'DOC_', $Id, [], $Modulo,$Tipo );
                $count++;
            }
            $result->ok = true;
        } //fin upload
        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la información", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", []);
        }
    }

    function Fianza()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            /* array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-fianzas.js'
            ) */
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-tablero.js'
            )
        ));
        $this->render('servicioSistema/Fianza/indexv2', $head, $data, $footer);
    }

    public function FianzaV2()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $permisos = array();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-tablero.js'
            )
        ));
        $this->render('servicioSistema/Fianza/indexv2', $head, $data, $footer);
    }

    function FianzaAdd()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $puesto = $this->tank_auth->get_idPersona();
        $permisos = $this->ticc->getPermisosPuesto($puesto, 'Fianza');

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-fianzas.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
        ));
        $this->render('servicioSistema/Fianza/Add', $head, $data, $footer);
    }

    function FianzaEdit($id)
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["idRegistro"] = $id;
        $data["Usuario"] = $this->tank_auth->get_usernamecomplete();
        $puesto = $this->tank_auth->get_idPersona();
        $permisos = $this->ticc->getPermisosPuesto($puesto, 'Fianza');

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-fianzas.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
        ));
        $this->render('servicioSistema/Fianza/Edit', $head, $data, $footer);
    }


    function Endoso()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),

        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Endosos/index', $head, $data, $footer);
    }

    function EndosoAdd($Doc, $Modulo = null)
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["idRegistro"] = null;
        $data["idDoc"] = $Doc;
        $data["Modulo"] = $Modulo;
        $puesto = $this->tank_auth->get_idPersona();
        $permisos = $this->ticc->getPermisosPuesto($puesto, 'Endoso');

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-endoso.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
        ));
        $this->render('servicioSistema/Endosos/Add', $head, $data, $footer);
    }

    function EndosoEdit($Doc, $id = null, $Modulo = null)
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["idRegistro"] = $id;
        $data["idDoc"] = $Doc;
        $data["Modulo"] = $Modulo;
        $puesto = $this->tank_auth->get_idPersona();
        $data["Usuario"] = $this->tank_auth->get_usernamecomplete();
        $permisos = $this->ticc->getPermisosPuesto($puesto, 'Endoso');

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-endoso.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
        ));
        $this->render('servicioSistema/Endosos/Edit', $head, $data, $footer);
    }

    function Despacho()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/Despacho/index', $head, $data, $footer);
    }

    function TipoAgente()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/TipoAgente/index', $head, $data, $footer);
    }

    function TipoCedula()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/TipoCedula/index', $head, $data, $footer);
    }

    function CompaniaClasificacion()
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
        ));
        $this->render('servicioSistema/CompaniaClasificacion/index', $head, $data, $footer);
    }


    //Funciones para almacenar los documentos
    private function createReferenciaFolder($referencia, $referencia_id)
    {
        $finalReference = null;
        $folReferencia = null;
        $folReferenciaId = null;
        $exist_ref = $this->googledrive->searchfile(array("name" => $referencia));

        if (count($exist_ref->data) == 0) {
            $folReferencia = $this->googledrive->createFolder($referencia);

            if ($folReferencia->exito) {
                //$this->saveDoc($folReferencia->data, false, $referencia);
                $folReferencia = $folReferencia->data;
            } else {
                $this->responseJSON("400", $folReferencia->mensaje, null);
                die;
            }
        } else {
            $folReferencia = $exist_ref->data[0];
        }

        if (!empty($referencia_id)) {
            $exist_ref_id = $this->googledrive->searchfile(array("name" => $referencia_id, "parents" => $folReferencia->getId()));
            if (count($exist_ref_id->data) == 0) {
                $folReferenciaId = $this->googledrive->createFolder($referencia_id, $folReferencia->getId());
                if ($folReferenciaId->exito) {
                    //$this->saveDoc($folReferenciaId->data, false, $referencia, $referencia_id);
                    $folReferenciaId = $folReferenciaId->data;
                }
            } else {
                $folReferenciaId = $exist_ref_id->data[0];
            }
        }

        if ($folReferenciaId != null) {
            $finalReference = $folReferenciaId;
        } else {
            $finalReference = $folReferencia;
        }

        return $finalReference;
    }

    //Funcion para añadir los archvios a la DB
    private function saveDoc($file, $privado, $referencia, $referencia_id = 0, $puestos = [], $Modulo, $Tipo)
    {
        $URL = 'http://localhost:8080/V3API/public/index.php/api/';
        $data = array(
            'nombre' => basename($file->getName()), //
            'descripcion' => $file->getDescription(), //
            'ruta' => $file->getWebViewLink(), //
            'ruta_completa' => $file->getWebContentLink(), //
            'tipo' => $file->getMimeType(), //
            'nombre_completo' => $file->getName(), //
            'revision' => '0', //
            'referencia' => $referencia, //
            'referencia_id' => $referencia_id, //
            'usuario_alta_id' => $this->tank_auth->get_idPersona(), //
            'parent_id' => count($file->getParents()) > 0 ? $file->getParents()[0] : "",

            'file_id' => $file->getId(), //
            'tamanio' => $file->getSize(),
            'url_icono' => $file->getIconLink(),
            'url_descargar' => $file->getWebContentLink(),
            'thumbnail_link' => $file->getThumbnailLink(),
            'fecha_alta' => date("Y-m-d H:i:s"), //
            //'privado' => $privado == "true" ? 1 : 0,
            'estado' => 'ACTIVO', //
            'Modulo' => $Modulo
        );
        $this->SendInfoApi($URL, $data, $referencia_id, $Tipo);
        //$result =  $this->documento->saveDocument($data);
    }

    ///funciones para administar los documentos
    function updateDocumentos()
    {
        $inset_id = $this->input->post('id');
        $Modulo = $this->input->post("Modulo");
        $Tipo = $this->input->post("Tipo");
        $result = new \stdClass;
        $result->ok = true;

        if (!empty($_FILES)) {
            $keys = array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('AUTOSI_', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('AUTOSI_' . $inset_id, $padre);
            $count = 0;
            foreach ($_FILES as $file) {
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                $this->saveDoc($uploadFile->data, '', 'AUTOSI_', $inset_id, [], $Modulo,$Tipo);
                $count++;
            }
            $result->ok = true;
        } //fin upload
        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la información", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", []);
        }
    }

    function delete_documento()
    {
        $id_doc = $this->input->post('id_doc');
        $response = $this->googledrive->deleteFile($id_doc);
        $this->autos->delete_doc_drive($id_doc);
        $this->responseJSON("200", "Se realizó con Éxito", []);
    }

    function  SendInfoApi($URL, $data, $id, $Tipo = null)
    {
        $curl = curl_init();

        $dta = array(
            "Id" => $id,
            "data" => $data,
            "Tipo" => $Tipo
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => $URL . 'capture/addDocument',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dta),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        //var_dump($response);

        curl_close($curl);
        //echo $response;
    }

    //Conciliacion
    public function recibos($id = null, $modulo = null)
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["idRegistro"] = $id;
        $data["modulo"] = $modulo;

        $permisos = array();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-tableror.js'
            )
        ));
        $this->render('servicioSistema/Conciliacion/index', $head, $data, $footer);
    }

    public function recibo($id = null, $documento = null, $modulo = null)
    {
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";
        $data["idRegistro"] = $id;
        $data["documento"] = $documento;
        $data["modulo"] = $modulo;
        $data["Usuario"] = $this->tank_auth->get_usernamecomplete();

        $permisos = array();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";" . "const _permisos = " . json_encode($permisos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-recibos.js'
            )
        ));
        $this->render('servicioSistema/Conciliacion/recibo', $head, $data, $footer);
    }

    //Prestamos
    public function Prestamos(){
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-prestamos.js'
            )
        ));
        $this->render('servicioSistema/Prestamos/index', $head, $data, $footer);
    }

    //Honorarios
    public function Honorarios(){
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-honorarios.js'
            )
        ));
        $this->render('servicioSistema/Honorarios/index', $head, $data, $footer);
    }

    public function Comisiones(){
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-comisiones.js'
            )
        ));
        $this->render('servicioSistema/Comisiones/index', $head, $data, $footer);
    }

    public function EstatusCancelacion(){
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-comisiones.js'
            )
        ));
        $this->render('servicioSistema/EstatusCancelacion/index', $head, $data, $footer);
    }

    public function MotivoCancelacion(){
        $head = [];
        $data = [];
        $footer = [];
        $data["tipo"] = "Siniestros";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/style.css'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'CSS',
                'path' => 'gap/css/servicios_api.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode(array()) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-comisiones.js'
            )
        ));
        $this->render('servicioSistema/MotivoCancelacion/index', $head, $data, $footer);
    }
}
