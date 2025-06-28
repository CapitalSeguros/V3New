<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OT;
use App\Models\Moneda;
use App\Models\Grupo;
use App\Models\SubGrupo;
use App\Models\FormaPago;
use App\Models\Bitacora;
use App\Models\Polizas;
use App\Models\Flotillas;
use App\Models\Recibos;
use App\Models\Fianzas;
use App\Models\Endoso;
use App\Models\Honorarios;
use App\Models\ProductoFianza;
use App\Models\Compania;
use App\Models\Agente;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Libraries\Helpers;
use App\Models\Ramo;
use App\Models\Vendedor;
use App\Models\CargaInicial;
use App\Models\SubRamo;
use SimpleXMLElement;

date_default_timezone_set('America/Merida');

class Capture extends TICC
{

    public function OT(Request $request)
    {
        //Total
        $isfiltered = false;
        //$Query = DB::table('sicas_ot as a');
        $Query = DB::table('ticc_sicas_documentos as a');
        $Query->selectRaw("count(IDTemp) as Id");
        //$Query->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
        //$Query->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
        //$Query->leftjoin('vendedores as d', 'a.IDVend', '=', 'd.IDVend');
        //$Query->leftjoin('sicas_estatus_documento as f', 'a.IDEstatusUsuario', '=', 'f.Id');
        //$Query->where('a.IsNew', 1);
        $Query->where('TipoDocto', 0);
        $Json3 = null;
        $Json = $Query->first();
        //Filterer
        $offset = $request["start"];
        $Query2 = DB::table('ticc_sicas_documentos as a');
        $Query2->where('TipoDocto', 0);
        $Query2->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
        //$Query2->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
        //$Query2->leftjoin('vendedores as d', 'a.IDVend', '=', 'd.IDVend');
        $Query2->leftjoin('ticc_sicas_estatus_documento as f', 'a.IDEstatusUsuario', '=', 'f.Id');
        //Campo de busqueda
        if ($request["search"] != '') {
            $isfiltered = true;
            $Query2->where(function ($query) use ($request) {
                $query->where('a.Solicitud', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('a.Documento', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('b.Nombre', 'LIKE', '%' . $request["search"] . '%')
                    #->orWhere('a.EstatusUsuario', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('a.VendNombre', 'LIKE', '%' . $request["search"] . '%');
            });
        }
        if ($request['Estatus'] != '') {
            $Query2->where('a.Status_TXT', $request['Estatus']);
        }

        $Json3 = clone $Query2;
        $Json3->selectRaw("count(IDTemp) as Id");
        //$Json3->where('TipoDocto',0);
        $check = $Json3->first();
        //return $Json3->toSql();

        //Set Offse
        if (isset($request["start"]))
            $Query2->skip($offset)->take(10);
        else
            $Query2->skip(0)->take(10);

        $Query2->selectRaw("a.IDDocto,f.Nombre EstatusUsuario,b.Nombre Subramo, DATE_FORMAT(a.FDesde,'%Y-%d-%m') FDesde,DATE_FORMAT(a.FHasta,'%Y-%d-%m') FHasta, DATE_FORMAT(a.FCaptura,'%Y-%d-%m %H:%i') FCaptura,a.Solicitud,
        a.VendNombre as Vendedor, '' as Acciones, IF(a.Status=0, DATEDIFF(NOW(),a.FCaptura), DATEDIFF(a.FCaptura, a.FEmision)) as Dias,a.Documento, a.Status_TXT");
        $Query2->orderBy('IDDocto', 'DESC');
        //$Query2->where('TipoDocto',0);
        //$Query2->where('a.IsNew', 1);

        //return $Json2 = $Query2->toSql();
        $Json2 = $Query2->get();


        //$Json2=[];
        return $this->JsonResponseTable(200, $Json, $Json2, $request, $isfiltered, "exito", $check);
    }

    public function OT2(Request $request)
    {
        //Total
        $isfiltered = false;
        //$Query = DB::table('sicas_ot as a');
        $Query = DB::table('ticc_sicas_documentos as a');
        $Query->selectRaw("count(IDTemp) as Id");
        //$Query->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
        //$Query->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
        //$Query->leftjoin('vendedores as d', 'a.IDVend', '=', 'd.IDVend');
        //$Query->leftjoin('sicas_estatus_documento as f', 'a.IDEstatusUsuario', '=', 'f.Id');
        $Query->where('a.IsNew', 1);
        $Json = $Query->first();
        //Filterer
        $offset = $request["start"];
        $Query2 = DB::table('ticc_sicas_documentos as a');
        $Query2->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
        //$Query2->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
        //$Query2->leftjoin('vendedores as d', 'a.IDVend', '=', 'd.IDVend');
        $Query2->leftjoin('sicas_estatus_documento as f', 'a.IDEstatusUsuario', '=', 'f.Id');
        //Campo de busqueda
        if ($request["search"] != '') {
            $isfiltered = true;
            $Query2->where(function ($query) use ($request) {
                $query->where('a.Solicitud', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('b.Nombre', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('a.EstatusUsuario', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('d.NombreCompleto', 'LIKE', '%' . $request["search"] . '%');
            });
        }
        if ($request['Estatus'] != '') {
            $Query2->where('a.Status_TXT', $request['Estatus']);
        }

        //Set Offse
        if (isset($request["start"]))
            $Query2->skip($offset)->take(10);
        else
            $Query2->skip(0)->take(10);

        $Query2->selectRaw("a.IDDocto,f.Nombre EstatusUsuario,b.Nombre Subramo, DATE_FORMAT(a.FDesde,'%Y-%d-%m') FDesde,DATE_FORMAT(a.FHasta,'%Y-%d-%m') FHasta, DATE_FORMAT(a.FCaptura,'%Y-%d-%m %H:%i') FCaptura,a.Solicitud,
        a.VendNombre as Vendedor, '' as Acciones, IF(a.Status=0, DATEDIFF(NOW(),a.FCaptura), DATEDIFF(a.FCaptura, a.FEmision)) as Dias,a.Documento, a.Status_TXT");
        $Query2->orderBy('IDDocto', 'DESC');
        $Query2->where('a.IsNew', 1);
        //$Json2 = $Query2->toSql();
        $Json2 = $Query2->get();
        //$Json2=[];
        return $this->JsonResponseTable(200, $Json, $Json2, $request, $isfiltered, "exito");
    }

    public function OTV2(Request $request)
    {
        $Modulo = $request['Modulo'];
        $Find = $request['Busqueda'];
        $ModuloPadre = $request['ModuloPadre'];
        $TipoDoc = $request['TipoDocumento'];
        $Tabla = "";
        switch ($Modulo) {
            case 'P':
                $Tabla = "ticc_sicas_documentos as a";
                break;
            case 'F':
                $Tabla = "ticc_sicas_documentos as a";
                break;
            case 'E':
                $Tabla = "ticc_sicas_endosos as a";
                break;
        }
        $Query = DB::table($Tabla);
        $QueryCount = DB::table($Tabla);

        $QueryCount->selectRaw('count(*) as Id');

        if ($Modulo != "E") {
            $Query->selectRaw("a.FDesde,a.FHasta,a.FCaptura,a.IDDocto,a.Solicitud,a.Documento,a.Status_TXT,a.NombreCompleto as Cliente,b.Nombre as EstatusUsuario,c.Nombre SubRamo,IF(a.Status=0, DATEDIFF(NOW(),a.FCaptura), DATEDIFF(a.FCaptura, a.FEmision)) as Dias, a.Serie");
        } else {
            $Query->selectRaw('a.FDesde,a.FHasta,a.IDDocto,a.Solicitud,a.Documento,a.IDEnd,a.Status_TXT,b.NombreCompleto as Cliente');
        }
        if ($Find != '') {
            if ($Modulo == "E") {
                $Query->where(function ($query) use ($Find) {
                    $query->where('a.Documento', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Solicitud', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Endoso', 'LIKE', '%' . $Find . '%');
                });
                $QueryCount->where(function ($query) use ($Find) {
                    $query->where('a.Documento', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Solicitud', 'LIKE', '%' . $Find . '%');
                });
            } else {
                $Query->where(function ($query) use ($Find) {
                    $query->where('a.Documento', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Solicitud', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Serie', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.NombreCompleto', 'LIKE', '%' . $Find . '%');
                });
                $QueryCount->where(function ($query) use ($Find) {
                    $query->where('a.Documento', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Solicitud', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Serie', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.NombreCompleto', 'LIKE', '%' . $Find . '%');
                });
            }
        }
        if ($Modulo == "E") {
            if ($ModuloPadre == "P") {
                $Query->join('ticc_sicas_documentos as b', "a.IDDocto", "=", "b.IDDocto");
                $QueryCount->join('ticc_sicas_documentos as b', "a.IDDocto", "=", "b.IDDocto");
            } else {
                $Query->join('ticc_sicas_documentos as b', "a.IDDocto", "=", "b.IDDocto");
                $QueryCount->join('ticc_sicas_documentos as b', "a.IDDocto", "=", "b.IDDocto");
            }
        } else {
            $QueryCount->leftjoin('ticc_sicas_estatus_usuario as b', "a.IDEstatusUsuario", "=", "b.Id");
            $QueryCount->leftjoin('ticc_sicas_catalog_subramos as c', 'a.IDSSRamo', '=', 'c.IDSRamo');
            $Query->leftjoin('ticc_sicas_estatus_usuario as b', "a.IDEstatusUsuario", "=", "b.Id");
            $Query->leftjoin('ticc_sicas_catalog_subramos as c', 'a.IDSSRamo', '=', 'c.IDSRamo');

            if ($Modulo == "P") {
                $QueryCount->where('a.IDSRamo', '<', 5);
                $Query->where('a.IDSRamo', '<', 5);
            } else {
                $QueryCount->where('a.IDSRamo', '>', 4);
                $Query->where('a.IDSRamo', '>', 4);
            }
            $QueryCount->where('IsV3', 0);
            $Query->where('IsV3', 0);
        }

        //Si tipo de documento tiene algo
        if (isset($TipoDoc)) {
            if ($TipoDoc != "") {
                $QueryCount->where('a.TipoDocto', '=', $TipoDoc);
                $Query->where('a.TipoDocto', '=', $TipoDoc);
            }
        }
        $field = "a.IDDocto";
        $order = "DESC";

        $count = $QueryCount->first();
        $Query->skip($request["Offset"])->take(10);
        $Query->orderBy($field, $order);
        $res = $Query->get();
        return $this->JsonResponsev2(200, $res, "exito", $count);
    }

    public function getInitialData(Request $request)
    {
        $Monedas = array();
        $FormaPago = array();
        $Subramo = array();
        $Ramos = array();
        $EstatusCan = array();
        $MotivosCan = array();
        $CoberturasR = array();
        $PlanesR = array();
        $Compania = array();
        $FianzaProducto = array();
        $Productos = array();

        $TiposDocumentos = array(
            array(
                "Id" => 0,
                "Nombre" => "Solicitud"
            ),
            array(
                "Id" => 1,
                "Nombre" => $request['Tipo'] == "P" ? 'Póliza' : 'Fianza'
            ),
        );

        if ($request['Agente'] != 'undefined' || $request['IDAgente'] != 'undefined') {
            $Json = new \stdClass;
            $Json->IDAgente = 0;
            if ($request['Agente'] != 'undefined' && $request['Agente'] != '') {
                //echo 'Agente  ' . $request['Agente'];
                if ($request['Tipo'] == "P") {
                    $Query = DB::table('ticc_sicas_documentos as a');
                    $EstatusCan = DB::table('ticc_sicas_catalog_cancelacion_polizas as a')->where('Cancelar', 1)->get();
                    $MotivosCan = DB::table('ticc_sicas_catalog_cancelacion_motivos as a')->get();
                } else {
                    $Query = DB::table('ticc_sicas_documentos as a');
                    $EstatusCan = DB::table('ticc_sicas_catalog_cancelacion_polizas as a')->where('Cancelar', 1)->get();
                    $MotivosCan = DB::table('ticc_sicas_catalog_cancelacion_motivos as a')->get();
                }
                $Query->selectRaw("a.*");
                $Query->where('IDDocto', $request['Agente']);
                $Json = $Query->first();
                //var_dump($Json);
            }

            if ($request['IDAgente'] != 'undefined' && $request['IDAgente'] != '') {
                //echo 'IDAgente  ' . $request['IDAgente'];
                if ($Json->IDAgente == 0) {
                    $Json->IDAgente = $request['IDAgente'];
                } else {
                    $Json->IDAgente = $request['IDAgente'];
                }
            } /* else {
                $Json->IDAgente = $request['IDAgente'];
            } */
            //echo $Json->IDAgente;
            if ($Json->IDAgente > 0) {

                $Agente = DB::table('ticc_sicas_agentes as a')->selectRaw("b.IDCia")->join('ticc_sicas_companias as b', 'a.CiaNombre', '=', 'b.CiaNombre')->where('a.IDAgente', $Json->IDAgente)->first();
                //var_dump($Agente);
                //var_dump($request['IDAgente']);
                $NewSub = [];
                $_rReturn = [];
                //$Monedas = DB::table('compania_monedas as a')->join('sicas_monedas as b', 'a.Id_moneda', '=', 'b.Id')->where('a.Id_compania', isset($Agente->IDCia) ? $Agente->IDCia : 0)->get(['b.Id', 'b.Moneda as Nombre', 'b.TipoCambio']);
                $FMonedas = DB::table('ticc_sicas_compania_monedas as a')->join('ticc_sicas_monedas as b', 'a.Id_moneda', '=', 'b.Id')->where('a.Id_compania', isset($Agente->IDCia) ? $Agente->IDCia : 0)->get(['b.Id', 'b.Moneda as Nombre', 'b.TipoCambio']);
                foreach ($FMonedas as $key => $value) {
                    $FirstElement = DB::table('ticc_sicas_tipo_cambio_registro as a')->where('a.IdMon', $value->Id)->limit(10)->orderBy('a.Fecha', 'DESC')->first();
                    $_rReturn[] = array(
                        "Id" => $value->Id,
                        "Nombre" => $value->Nombre,
                        "TipoCambio" => isset($FirstElement->Cambio) ? $FirstElement->Cambio : 1,
                    );
                }
                $Monedas = $_rReturn;

                $FormaPago = DB::table('ticc_sicas_compania_formapagos as a')->join('ticc_sicas_formaspago as b', 'a.Id_formapago', '=', 'b.Id')->where('a.Id_compania', isset($Agente->IDCia) ? $Agente->IDCia : 0)->get(['b.Id', 'b.FormaPago as Nombre', 'b.NumPagos as NPagos', 'b.PRecargos']);
                $Subramo = DB::table('ticc_sicas_compania_subramos as a')->join('ticc_sicas_catalog_subramos as b', 'a.Id_subramo', '=', 'b.IDSRamo')->where('a.Id_compania', isset($Agente->IDCia) ? $Agente->IDCia : 0)->get(['b.IDSRamo as Id', 'b.Nombre', 'b.IDRamo as IdPadre', 'b.Flotilla']);
                $NewSub = array_map(function ($elem) {
                    return $elem->IdPadre;
                }, (array)$Subramo);
                //echo $Agente->IDCia;
                $Ramos = DB::table('ticc_sicas_catalog_ramos as a')->whereIn('a.IDRamo', $NewSub)->get(['a.IDRamo as Id', 'a.Nombre']);
                $Compania = Compania::where('IDCia', $Agente->IDCia)->first();
                $Cia = isset($Agente->IDCia) ? $Agente->IDCia : 0;
                $FianzaProducto = DB::table('ticc_sicas_tipofianzas as a')->join('ticc_sicas_fianza_subramo_config as b', 'a.IDTFianza', '=', 'b.IdFianza')
                    ->where('b.IdCompania', isset($Agente->IDCia) ? $Agente->IDCia : 0)->where('b.IdSubramo', 45)->get(['a.IDTFianza as Id', 'a.Nombre as Nombre']);

                $Productos = DB::table('ticc_sicas_catalog_fianzaproductos as a')->leftjoin('ticc_sicas_fianza_producto_config as b', function ($join) use ($Cia) {
                    $join->on('a.Id', '=', 'b.IdProducto');
                    $join->on('b.Compania', '=', DB::raw("'" . $Cia . "'"));
                })->get(['a.Id as Id', 'a.Nombre', 'a.Id_tipofianza as IdPadre']);
            }
        }
        //traer los tipos de plpanes y coberturas
        if (isset($request['Ramo']) &&  $request['Tipo'] == "P") {
            if ($request['Ramo'] != '' && $request['Ramo'] != 'undefined') {
                $PlanesR = DB::table('ticc_sicas_planes as a')->join('ticc_sicas_catalog_ramos as b', 'a.Ramo', '=', 'b.Nombre')->where('b.IDRamo', $request['Ramo'])->get(['a.IDProductoS as Id', 'a.Nombre']);
            }
        }
        $Json = array(
            // "Ramos" => DB::table('ticc_sicas_catalog_ramos as a')->get(['a.IDRamo as Id', 'a.Nombre']),
            //"Monedas" => Moneda::get(['Id', 'Moneda as Nombre', 'TipoCambio']),
            //"FormaPago" => FormaPago::get(['Id', 'FormaPago as Nombre', 'NumPagos as NPagos', 'PRecargos']),
            //"SubRamo" => DB::table('ticc_sicas_catalog_subramos as a')->get(['a.IDSRamo as Id', 'Nombre', 'a.IDRamo as IdPadre', 'a.Flotilla']),
            "Ramos" => $Ramos,
            "FormaPago" => $FormaPago,
            "Monedas" => $Monedas,
            "SubRamo" => $Subramo,
            "Grupo" => Grupo::get(),
            "SubGrupo" => SubGrupo::get(['Id', 'Nombre', 'IdGrupo as IdPadre']),
            "Ejecutivos" => DB::table('ticc_sicas_ejecutivos as a')->get(['IDEjecut as Id', 'EjecutNombre as Nombre']),
            //"Vendedores"=>array(),
            "Vendedores" => DB::table('ticc_sicas_vendedores as a')->where('NombreCompleto', '<>', '')->get(['IDVend as Id', 'NombreCompleto as Nombre', 'Id_despacho', 'Id_gerencia']),
            //"Companias" => DB::table('companias as a')->orderBy('a.CiaNombre', 'ASC')->get(['a.IDCia as Id', 'a.CiaNombre as Nombre']),
            "Agentes" => DB::table('ticc_sicas_agentes as a')->selectRaw("a.IDAgente as Id,concat('(',a.CAgente,') ',a.AgenteNombre) as Nombre,CRecargos,IVA,CNeta,a.CiaNombre")->where('AgenteNombre', '<>', '')->join('ticc_sicas_companias as b', 'a.CiaNombre', '=', 'b.CiaNombre')
                ->where('b.TCompania', $request['Tipo'] == "P" ? 1 : 2)
                ->orderBy('a.AgenteNombre', 'ASC')->get(),
            "EstatusUsurario" => DB::table('ticc_sicas_estatus_usuario as a')->get(['a.Id', 'a.Nombre']),
            "Estatus" => DB::table('ticc_sicas_estatus_documento as a')->get(),
            "EstatusCobro" => DB::table('ticc_sicas_estatuscobro as a')->get(['a.Id', 'a.Estatus as Nombre']),
            "EstatusDoc" => DB::table('ticc_sicas_clasificaciondocumento as a')->get(['a.Id', 'a.Clasificacion as Nombre']),
            "Gerencias" => DB::table('ticc_sicas_gerencias as a')->get(['a.Id', 'a.Nombre']),
            "ConductoCobro" => DB::table('ticc_sicas_conductocobro as a')->get(['a.Id', 'a.ConductoCobro as Nombre']),
            "LineaNegocio" => DB::table('ticc_sicas_lineanegocio as a')->get(['a.Id', 'a.Nombre']),
            //"TipoDocumento" => DB::table('sicas_tipodocumento as a')->get(['a.Id', 'a.Tipo as Nombre']),
            "TipoDocumento" => $TiposDocumentos,
            "TipoPago" => DB::table('ticc_sicas_tipopago as a')->get(['a.Id', 'a.Tipo as Nombre']),
            "TipoVenta" => DB::table('ticc_sicas_tipoventa as a')->get(['a.Id', 'a.Nombre']),
            "Despachos" => DB::table('ticc_sicas_catalog_despacho as a')->get(['a.Id', 'a.RazonSocial as Nombre']),
            "TipoConCobro" => DB::table('ticc_sicas_catalog_tipo_cobro as a')->get(['a.Id', 'a.Nombre']),
            "Marca" => DB::table('ticc_sicas_catalog_marca as a')->get(['a.Id', 'a.Nombre']),
            "SubMarca" => DB::table('ticc_sicas_catalog_submarca as a')->get(['a.Id', 'a.Nombre', 'a.IdMarca as IdPadre']),
            "Transmision" => DB::table('ticc_sicas_catalog_transmision as a')->get(['a.Id', 'a.Nombre']),
            "Cochera" => DB::table('ticc_sicas_catalog_cochera as a')->get(['a.Id', 'a.Nombre']),
            "Color" => DB::table('ticc_sicas_catalog_color as a')->get(['a.Id', 'a.Nombre']),
            "Servicio" => DB::table('ticc_sicas_catalog_servicio as a')->get(['a.Id', 'a.Nombre']),
            "UsoServicio" => DB::table('ticc_sicas_catalog_usoservicio as a')->get(['a.Id', 'a.Nombre']),
            "CiaLocalizacion" => DB::table('ticc_sicas_catalog_cialocalizacion as a')->get(['a.Id', 'a.Nombre']),
            "Inspeccion" => DB::table('ticc_sicas_catalog_inspeccion as a')->get(['a.Id', 'a.Nombre']), //catalog_estados
            "Estados" => DB::table('ticc_sicas_catalog_estados as a')->get(['a.clave as Id', 'a.estado as Nombre']), //
            //"TipoFianza" => DB::table('tipofianzas as a')->get(['a.IDTFianza as Id', 'a.Nombre as Nombre']),
            //"FianzaProducto" => DB::table('catalog_fianzaproductos as a')->get(['a.Id as Id', 'a.Nombre', 'a.Id_tipofianza as IdPadre']),
            "TipoFianza" => $FianzaProducto,
            "FianzaProducto" => $Productos,
            "EstatusCancelacion" => $EstatusCan,
            "MotivosCancelacion" => $MotivosCan,
            "Coberturas" => DB::table('ticc_sicas_tipo_cobertura as a')->get(['a.Id as Id', 'a.Nombre']),
            "Planes" => $PlanesR,
            "Compania" => $Compania
        );
        return $this->JsonResponse(200, $Json, $request, "exito");
    }

    public function getOT(Request $request)
    {
        $ID = $request["Id"];
        $Query = DB::table('ticc_sicas_documentos as a');
        $Query->selectRaw("a.*");
        //$Query->where('IDTemp', $ID);
        $Query->where('IDDocto', $ID);

        $Json = $Query->first();

        $Usuario = null;
        $flotillas = [];
        $Recibos = [];
        $Honorarios = [];
        $Endosos = [];
        $Coberturas = [];
        $Planes = [];
        $MensajesErrores = [];
        //obtnemos el usuario
        if ($Json != null) {
            $Usuario = DB::table('ticc_sicas_clientes as a')->selectRaw("a.IDCli as Id,a.NombreCompleto as Nombre")->where('a.IDCli', $Json->IDCli)
                ->leftjoin('ticc_sicas_direcciones as b', 'a.IDCli', '=', 'b.IDCli')
                ->first();

            $Direcciones = DB::table('ticc_sicas_direcciones as a')->selectRaw("a.IDTemp as Id,concat(a.calle, ' ', a.CPostal, ' ', a.Poblacion, ' ', a.Ciudad ) as Nombre")->where('a.IDCli', $Json->IDCli)
                ->get();

            $flotillas = Flotillas::where('IDDocto', $Json->IDDocto)->orderBy('NumInc', 'DESC')->get();
            $Recibos = Recibos::where('IDDocto', $Json->IDDocto)->where('Documento', $Json->Documento)->whereIN('IDEnd', array(0, -1))->orderBy('Periodo', 'ASC')->get();
            //return $Recibos = Recibos::where('Documento', $Json->Documento)->whereIN('IDEnd', array(0, -1))->Orwhere('Modulo', 'P')->orderBy('Periodo', 'ASC')->toSql();
            //$Recibos = Recibos::where('IDDocto', $Json->IDDocto)->where('Documento', $Json->Documento)->whereIN('IDEnd', array(0, -1))->Orwhere('Modulo', 'P')->orderBy('Periodo', 'ASC')->get();
            //$Honorarios = DB::select('CALL ConfiguracionHonorarios(?,?,?,?)', array($Json->IDVend, $Json->IDMon, $Json->IDSSRamo, $Json->IDDocto));
            //$Honorarios = Honorarios::CreateHonorariosv2($Json->IDMon, $Json->IDVend, $Json->IDSSRamo, $Json->IDSubGrupo, $Json->IDCli, $Json->IDDocto, 'P');
            $Honorarios = Honorarios::CreateHonorariov3($Json->IDMon, $Json->IDVend, $Json->IDSSRamo, $Json->IDSubGrupo, $Json->IDCli, $Json->IDDocto, 'P', ($Json->ComRec + $Json->ComDer));
            //$Comisiones = DB::select('CALL GetListaComisiones(?,?,?)', array($Json->IDMon, $Json->IDSSRamo, $Json->IDAgente));
            $Comisiones = DB::select('CALL GetListaComisionesV2(?,?,?)', array($Json->IDDocto, $Json->Documento, 'P'));
            $Endosos = DB::table('ticc_sicas_endosos as a')->where('IDDocto', $Json->IDDocto)->where('Documento', $Json->Documento)->where('Modulo', 'P')->get();
            $Coberturas = Db::table('ticc_sicas_coberturas as a')->where('IDDocto', $Json->IDDocto)->where('Documento', $Json->Documento)->get();
            $Planes = DB::table('ticc_sicas_planes as a')->join('ticc_sicas_catalog_ramos as b', 'a.Ramo', '=', 'b.Nombre')->where('b.IDRamo', $Json->IDSRamo)->get(['a.IDProductoS as Id', 'a.Nombre']);
        }

        //Checamos los porcentajes
        $participacion = 0;
        $GrupoHon = array();
        //var_dump($Honorarios);
        if ($Json->TipoDocto > 0) {
            foreach ($Honorarios as $key => $value) {
                if (isset($value->Id_formula)) {
                    $GrupoHon[$value->Id_formula] = (isset($GrupoHon[$value->Id_formula]) ? $GrupoHon[$value->Id_formula] : 0) + $value->participacion;
                    if (isset($value->Id_formula)) {
                        if ($value->Id_formula == 1 || $value->Id_formula == 2) {
                            $participacion = $participacion + (isset($value->participacion) ? $value->participacion : 0);
                        }
                    }
                }
            }
        }

        if (empty($Usuario)) {
            $Usuario["Nombre"] = "";
            $Usuario["Id"] = "";
        }
        $data = array(
            "OT" => $Json,
            "Usuario" => array(
                "Info" => $Usuario,
                "Direcciones" => $Direcciones,
            ),
            "Flotillas" => $flotillas,
            "Recibos" => $Recibos,
            "Honorarios" => $Honorarios,
            "Comisiones" => $Comisiones,
            "Endosos" => $Endosos,
            "Coberturas" => $Coberturas,
            "Planes" => $Planes,
            "TotalHonorario" => $participacion,
            "TotalHonorariosGrupo" => $GrupoHon
        );
        return $this->JsonResponse(200, $data, array($Json->IDVend, $Json->IDMon, $Json->IDSSRamo), "exito");
    }

    public function GetConfigValues(Request $request)
    {
        $Compania = $request['Compania'] != 'undefined' ? $request['Compania'] : 0;
        $Moneda = $request['Moneda'] != 'undefined' ? $request['Moneda'] : 0;
        $SubRamo = $request['SubRamo'] != 'undefined' ? $request['SubRamo'] : 0;
        $FormaPago = $request['FormaPago'] != 'undefined' ? $request['FormaPago'] : 0;
        $Agente = $request['Agente'] != 'undefined' ? $request['Agente'] : 0;
        $Vendedor = $request['Vendedor'] != 'undefined' ? $request['Vendedor'] : 0;
        $CIA = DB::table('ticc_sicas_agentes as a')->selectRaw("b.*")->join('ticc_sicas_companias as b', 'a.CiaNombre', '=', 'b.CiaNombre')->where('a.IDAgente',  $Compania)->first();
        $config = DB::select('CALL ConfiguracionComisiones(?,?,?,?,?)', array($CIA ? $CIA->IDCia : 0, $Moneda, $SubRamo, $Compania, $FormaPago));

        //ListaComisiones
        $Listconfig = DB::select('CALL GetListaComisiones(?,?,?)', array($Moneda, $SubRamo, $Compania));
        //$ListaHonorarios = DB::select('CALL ConfiguracionHonorarios(?,?,?)', array($Vendedor, $Moneda, $SubRamo));
        $ListaHonorarios = array();

        $response = array(
            "ConfigComisiones" => count($config) > 0 ? $config[0] : $config,
            "ListaComisiones" => $Listconfig,
            "ListaHonorarios" => $ListaHonorarios,
            "Compania" => $CIA
        );
        return $this->JsonResponse(200, $response, $request, "exito");
    }


    public function AccioneHonorarios(Request $request)
    {
        $Tipo = $request['Tipo'];
        $Data = $request['Data'];
        $response = [];
        switch ($Tipo) {
            case '1':
                $ItemId = $Data['Id'];
                $Update = array(
                    "importe" => $Data['importe'],
                    "Importe_pago" => $Data['Importe_pago'],
                    "Id_formula" => $Data['Id_formula'],
                    "participacion" => $Data['participacion'],
                    "Id_tipo_hon" => $Data['Id_tipo_hon'],
                    "Base" => $Data['Base'],
                );
                $Action = DB::table('ticc_sicas_honorarios')->where('Id', $ItemId)->update($Update);
                break;
            case '2':
                # code...
                break;
        }
        return $this->JsonResponse(200, $response, $request, "exito");
    }

    public function UpdateHonorario(Request $request)
    {
        $Id = $request["Id"];
        $IdF = $request["Formula"];
        $Percent = $request["Porcentaje"];
        //$Hon=DB::table('honorarios1 as a')->where('Id', $Id)->first();
        $Hon = DB::table('ticc_sicas_vendedor_honorario_config as a')
            ->selectRaw("distinct c.NombreCompleto,d.Base,a.Porcentaje, '%' TipoValor,'' FormulaNombre,a.Formula_Importe Formula,c.IDVend as VendH,a.*,d.*")
            ->join('ticc_sicas_vendedor_honorario_vend as b', 'a.Id', '=', 'b.Id_vendedorhonorario')
            ->leftjoin('ticc_sicas_vendedores as c', 'c.IDVend', '=', 'a.Id_vendedor')
            ->leftjoin('ticc_sicas_honorarios as d', 'd.Id', '=', DB::raw("'" . $Id . "'"))->where('d.Id', $Id)->first();
        $Poliza = Polizas::find($Hon->IDDocto);

        $valoresF = array(
            "CBase" => $Poliza->ComNeta,
            "CRecargos" => $Poliza->ComRec,
            "CDerechos" => $Poliza->ComDer
        );
        $Hon->Id_formula = $IdF;
        $Hon->importe = Helpers::TotalFormulaHonorarios($IdF, $valoresF, $Hon->participacion);
        $Hon->Base = Helpers::BaseFormulaHonorarios($IdF, $valoresF);
        $Hon->Porcentaje = $Percent;
        //var_dump($Hon);
        return $this->JsonResponse(200, $Hon, $request, "exito");
    }

    public function GetConfigHonorarios(Request $request)
    {
        $ID = $request['Documento'];
        $Agente = $request['Agente'];
        $Comisiones = [];
        $Honoarios = [];
        $Json = DB::table('ticc_sicas_documentos as a')->selectRaw("a.*, '16' as PorIVA")->where('IDDocto', $ID)->first();
        $CIA = DB::table('ticc_sicas_agentes as a')->selectRaw("b.IDCia")->join('ticc_sicas_companias as b', 'a.CiaNombre', '=', 'b.CiaNombre')->where('a.IDAgente',  $Agente)->first();
        $configComisones = DB::select('CALL ConfiguracionComisiones(?,?,?,?,?)', array($CIA->IDCia, $Json->IDMon, $Json->SubRamo, $Agente, $Json->FormaPago));
    }

    public function CheckNumSerie(Request $request)
    {
        $Id = $request['Id'];
        $NumSerie = $request['NumSerie'];
        $Code = 200;
        $Mensaje = "";
        $exists = 0;

        if (isset($Id)) {
            //echo '1';
            $exists = Polizas::where("Serie", $NumSerie)->where('NumRenovacion', 0)->where('IDDocto', '<>', $Id)->count();
        } else {
            //echo '2 ';
            $exists = Polizas::where("Serie", $NumSerie)->where('NumRenovacion', 0)->count();
        }

        $verify = isset($dta["NumRenovacion"]) ? $dta["NumRenovacion"] : 0;
        if ($verify == 0) {
            $exists++;
        }

        if ($exists > 1) {
            $Code = 400;
            $Mensaje = "Ya existe un registro con la misma serie.";
        }

        return $this->JsonResponse($Code, [], $Mensaje);
    }

    public function IsSaved(Request $request)
    {
        $Id = $request['Id'];
        $Documento = $request['Documento'];
        $Modulo = $request['Modulo'];
        $Code = 200;
        $Mensaje = "";
        $exists = 0;

        $Query = null;
        if ($Modulo == "P") {
            $Query = Polizas::where("Documento", $Documento);
        } else {
            $Query = Fianzas::where("Documento", $Documento);
        }

        if (!empty($Id)) {
            //echo '1';
            $exists = $Query->where('IDDocto', '<>', $Id)->count();
        } else {
            //echo '2';
            $exists = $Query->count();
        }

        $verify = isset($dta["Documento"]) ? $dta["Documento"] : 0;
        if ($verify == 0) {
            $exists++;
        }

        if ($exists > 1) {
            $Code = 400;
            $Mensaje = $Modulo == "P" ? "Ya existe un registro con la misma clave de Documento." : "Ya existe un registro con el mismo No.Fianza.";
        }

        return $this->JsonResponse($Code, [], $Mensaje);
    }

    public function saveOT(Request $request)
    {
        $Code = 200;
        $Message = "Exito";
        $Data = [];

        try {
            DB::beginTransaction(); //Inicio de la transaccion
            $Id = $request["Id"];
            $dta = $request["data"];
            $LoggedUser = $request["User"];

            $addObject = "";
            //$Complemento = $request["Complemento"];
            unset($dta['IDDocto']);

            $OT = "OT-" . date('YmdHsm');

            if (!array_key_exists('Solicitud', $dta)) {
                $dta["Solicitud"] = $OT;
                $dta["IsNew"] = 1;
                $dta["FSolicitud"] = date('Y-m-d');
            }
            if ($dta["Solicitud"] == '') {
                $dta["Solicitud"] = $OT;
            }

            if ($dta['TipoDocto'] == '1') {
                $dta['IsSavedPoliza'] = isset($dta['IsSavedPoliza']) ? $dta['IsSavedPoliza'] : 1;
                $dta['Status_TXT'] = isset($dta['Status_TXT']) ? $dta['Status_TXT'] : "Vigente";
                $dta['Status'] = isset($dta['Status']) ? $dta['Status'] : 1;

                if (isset($dta['FConversion'])) {
                    if ($dta['FConversion'] == '' || is_null($dta['FConversion'])) {
                        //Actualizamos la fecha de coneversion
                        $dta['FConversion'] = date('Y-m-d');
                    }
                } else {
                    $dta['FConversion'] = date('Y-m-d');
                }
            }

            //validamos el numero de serie
            if ($dta['IDSRamo'] == 2) { //Ramo
                if ($dta['IDSSRamo'] != 1) { //SubRamo
                    if (isset($dta['Serie'])) {
                        if ($dta['Serie'] != '') {
                            $exists = 0;
                            if (isset($Id)) {
                                //echo '1';
                                $exists = Polizas::where("Serie", $dta["Serie"])->where('NumRenovacion', 0)->where('IDDocto', '<>', $Id)->count();
                            } else {
                                //echo '2 ' . $dta['IDTemp'];
                                $exists = Polizas::where("Serie", $dta["Serie"])->where('NumRenovacion', 0)->count();
                            }

                            $verify = isset($dta["NumRenovacion"]) ? $dta["NumRenovacion"] : 0;
                            if ($verify == 0) {
                                $exists++;
                            }
                            /*  if ($exists > 1) {
                                return  $this->JsonResponse(400, [], "Ya existe un registro con la misma serie.");
                            } */
                        }
                    }
                }
            }

            //validamo que no exista el documento
            $DocVal = isset($dta['Documento']) ? $dta['Documento'] : null;
            if (!empty($DocVal)) {
                $CheckDocumento = Polizas::where('Documento', $dta['Documento']);
                if ($Id > 0) {
                    $CheckDocumento->where('IDDocto', '<>', $Id);
                }
                $result = $CheckDocumento->get();
                if (count($result) > 0) {
                    $Code = 400;
                    $Message = "Ya existe registro con el mismo valor de documento: \n {$dta['Documento']}, Ingrese otro valor.";
                    return $this->JsonResponse($Code, $Data, $Message);
                }
            }


            //Agregamos informacion extra de campos de descripcion
            $DRamo = Ramo::where('IDRamo', isset($dta['IDSRamo']) ? $dta['IDSRamo'] : 0)->first();
            $DSubRamo = SubRamo::where('IDSRamo', isset($dta['IDSSRamo']) ? $dta['IDSSRamo'] : 0)->first();
            $Vendedor = Vendedor::where('IDVend', isset($dta["IDVend"]) ? $dta["IDVend"] : 0)->first();
            $Agente = Agente::where('IDAgente', isset($dta["IDAgente"]) ? $dta["IDAgente"] : 0)->first();
            $DMoneda = Moneda::where('Id', isset($dta['IDMon']) ? $dta['IDMon'] : 0)->first();
            $Cliente = DB::table('ticc_sicas_clientes')->where('IDCli', isset($dta["IDCli"]) ? $dta["IDCli"] : 0)->first();
            $DGrupo = Grupo::where('Id', isset($dta['IDGrupo']) ? $dta['IDGrupo'] : 0)->first();
            $DSubGrupo = SubGrupo::where('Id', isset($dta['IDSubGrupo']) ? $dta['IDSubGrupo'] : 0)->first();
            $DEjecutivo = DB::table('ticc_sicas_ejecutivos')->where('IDEjecut', isset($dta["IDEjecut"]) ? $dta["IDEjecut"] : 0)->first();
            $dta["NombreCompleto"] = isset($Cliente->NombreCompleto) ? $Cliente->NombreCompleto : null;
            $dta["VendNombre"] = isset($Vendedor->NombreCompleto) ? $Vendedor->NombreCompleto : null;
            $dta["Ramo"] = isset($DSubRamo->Nombre) ? $DSubRamo->Nombre : null;
            $dta["Moneda"] = isset($DMoneda->Moneda) ? $DMoneda->Moneda : null;
            $dta["AgenteNombre"] = isset($Agente->AgenteNombre) ? $Agente->AgenteNombre : null;
            $dta["CAgente"] = isset($Agente->CAgente) ? $Agente->CAgente : null;
            $dta["CiaNombre"] = isset($Agente->CiaNombre) ? $Agente->CiaNombre : null;
            $dta["Grupo"] = isset($DGrupo->Nombre) ? $DGrupo->Nombre : null;
            $dta["SubGrupo"] = isset($DSubGrupo->Nombre) ? $DSubGrupo->Nombre : null;
            $dta["EjecutNombre"] = isset($DEjecutivo->EjecutNombre) ? $DEjecutivo->EjecutNombre : null;



            if ($Id > 0) { //ya existe el documento
                unset($dta['IDTemp']);
                $FindByDocto = DB::table('ticc_sicas_documentos')->where('IDDocto', $Id)->first();
                $FinP = Polizas::find($FindByDocto->IDTemp);
                //actualizamos los recibos en caso de que se modifique el documento
                if ($FinP['attributes']['Documento'] != $dta["Documento"]) {
                    //Actualizamos todas las polizas que tengan s documento
                    //$ActuDocs=Polizas::where();
                    //Actualizamos los recibos
                    $ActRcibos = DB::table('ticc_sicas_recibos')->where('Documento', $FinP['attributes']['Documento'])->where('IDDocto', $Id)->update([
                        "Documento" => $dta["Documento"]
                    ]);
                    //Actualizamos los honorarios
                    $Hon = DB::table('ticc_sicas_honorarios as a')->where('IDDocto', $Id)->where('documento', $FinP['attributes']['Documento'])->update([
                        "Documento" => $dta["Documento"]
                    ]);
                    //Actualizamos las comisiones
                    $Comisiones = DB::table('ticc_sicas_comisiones_documento')->where("Documento", $FinP['attributes']['Documento'])->where("IDDoc",  $Id)->update([
                        "Documento" => $dta["Documento"]
                    ]);
                }
                //Actualizar vendedor
                if ($dta["IDVend"] != $FinP['attributes']['IDVend']) {
                    $Update = Honorarios::UpdateHonorarios(1, 'Cancelado', $Id, $dta["Documento"], $FinP['attributes']['IDVend']);
                }
                //Se crea la bitacora
                Bitacora::addBitacora($Id, $dta, 'P', $LoggedUser);
                //se guarda
                unset($dta['IDPlan']);
                if (isset($dta['TipoDocto'])) {
                    if ($dta['TipoDocto'] > 0) {
                        $dta['isSavedPoliza'] = 1;
                    }
                }
                $addObject = Polizas::where("IDDocto", $Id)->update($dta);
                $addObject = Polizas::where("IDDocto", $Id)->first();
                //echo 'losadosd';
            } else { //Nuevo documento
                if (isset($dta["Documento"])) {
                    $exists = Polizas::where("Documento", $dta["Documento"])->where('TipoDocto', 1)->count();
                    if ($exists > 0) {
                        return  $this->JsonResponse(400, [], "Ya existe un registro con el mismo documento.");
                    }
                }

                if (!isset($dta["Documento"])) {
                    $dta["Documento"] = $OT;
                }

                $dta["IsNew"] = 1;
                //Actualizamos la parte del vendedor y cliente
                $addObject = Polizas::create($dta);
                $dta["IDDocto"] = $addObject->IDTemp;
                unset($dta['IDTemp']);
                unset($dta['IDPlan']);
                if (isset($dta['TipoDocto'])) {
                    if ($dta['TipoDocto'] > 0) {
                        $dta['isSavedPoliza'] = 1;
                    }
                }
                $addObject = Polizas::where("IDTemp", $dta["IDDocto"])->update($dta);
                $addObject = $dta;

                //validamos que no exista los honorarios
                //eliminamos los honoarios en base al documento
            }
            //var_dump($addObject);
            $addObject = (object)$addObject;

            if ($addObject->TipoDocto == 1) {

                $countH = DB::table('ticc_sicas_honorarios')->where("IDDocto", $addObject->IDDocto)
                #->where('Status', 3)->where('Status_TXT', 'Pendiente')
                ->get();
                if (count($countH) == 0) {
                    $Continuo = 0;
                    $Config = array(
                        "IDMon" => isset($addObject->IDMon) ? $addObject->IDMon : 0,
                        "IDVend" => isset($addObject->IDVend) ? $addObject->IDVend : 0,
                        "IDSubramo" => isset($addObject->IDSSRamo) ? $addObject->IDSSRamo : 0,
                        "IDSubgrupo" => isset($addObject->IDSubGrupo) ? $addObject->IDSubGrupo : 0,
                        "IDCliente" => isset($addObject->IDCli) ? $addObject->IDCli : 0,
                        "IDDocto" => isset($addObject->IDDocto) ? $addObject->IDDocto : 0,

                    );
                    //$listado = DB::select('CALL ConfiguracionHonorarios(?,?,?,?)', array($addObject->IDVend, $addObject->IDMon, $addObject->IDSSRamo, $addObject->IDDocto));
                    $listado = Honorarios::CreateHonorariov3($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'P', ($addObject->ComRec + $addObject->ComDer));
                    foreach ($listado as $key => $value) {
                        $valoresF = array(
                            "CBase" => $addObject->ComNeta,
                            "CRecargos" => $addObject->ComRec,
                            "CDerechos" => $addObject->ComDer
                        );
                        $Continuo++;
                        DB::table('ticc_sicas_honorarios')->insert([
                            'Id_vendedor' => $value->VendH,
                            'IDDocto' => $addObject->IDDocto,
                            'Id_tipo_hon' => $value->Id_honorario,
                            'Id_tipo' => 1,
                            'Id_formula' => $value->Formula,
                            'participacion' => $value->Porcentaje,
                            //'importe' => $this->CalculateHonorario($value, $addObject->ComNeta, $addObject->ComRec),
                            'importe' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                            'documento' => $addObject->Documento,
                            'Folio' => 'H' . date('YmdHHssmm') . '' . $Continuo,
                            'Id_moneda_pago' => $addObject->IDMon,
                            'Id_moneda_docto' => $addObject->IDMon,
                            'Tipo_cambio_pago' => $addObject->TipoCambio,
                            'Tipo_cambio_docto' => $addObject->TipoCambio,
                            'Base' => Helpers::BaseFormulaHonorarios($value->Formula, $valoresF),
                            //'Base' => $value->Formula == 1 ? floatval($addObject->ComNeta) : floatval($addObject->ComNeta + $addObject->ComRec),
                            //'Importe_pago' => $this->CalculateHonorario($value, $addObject->ComNeta, $addObject->ComRec),
                            'Importe_pago' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                            'Neta' => $addObject->ComNeta,
                            'Recargo' => $addObject->ComRec,
                            'IDVendGen' => $addObject->IDVend,
                            'Status' => 3,
                            'Status_TXT' => 'Pendiente',
                            'Modulo' => 'P'
                        ]);
                    }
                }

                $counCom = DB::table('ticc_sicas_comisiones_documento')->where("Modulo", 'P')->where("Documento", $addObject->Documento)
                    //->where("Status", 3)
                    ->where("IDDoc", $addObject->IDDocto)->get();
                if (count($counCom) == 0) {
                    $Array = array(
                        "PComNeta" => isset($addObject->PComNeta) ? $addObject->PComNeta : 0,
                        "PComRec" => isset($addObject->PComRec) ? $addObject->PComRec : 0,
                        "PComDer" => isset($addObject->PComDer) ? $addObject->PComDer : 0,
                        "PCGastosMaquila" => isset($addObject->PCGastosMaquila) ? $addObject->PCGastosMaquila : 0,
                    );
                    $ComisionesAgte = Honorarios::ComisionesAgentes($Array, $addObject, 'P');
                }
            }

            $return = $addObject;
            $Data = $addObject;
            //return $this->JsonResponse(200, $addObject, $request, "exito");
            DB::commit(); //Fin trassaccion
        } catch (\Throwable $th) {
            $Code = 400;
            $Data = $th;
            $Message = "Error";
            DB::rollback();
        }

        return $this->JsonResponse($Code, $Data, $Message);
    }

    public function AddCobertura(Request $request)
    {
        $Id = $request["Id"];
        $Doc = $request["Documento"];
        $Data = $request["data"];
        $response = array();

        if (isset($Data['IDTemp'])) {
            $IDItem = $Data['IDTemp'];
            unset($Data['IDTemp']);
            $insert = DB::table('ticc_sicas_coberturas')->where('IDTemp', $IDItem)->update($Data);
        } else {
            $insert = DB::table('ticc_sicas_coberturas')->insert($Data);
        }
        $response = DB::table('ticc_sicas_coberturas')->where('IDDocto', $Id)->where('Documento', $Doc)->get();

        return $this->JsonResponse(200, $response, $request, "exito");
    }

    public function DeleteCobertura(Request $request)
    {
        $Id = $request["Id"];
        $IdDoc = $request["IDDocto"];
        $Doc = $request["Documento"];

        $Deleted = DB::table('ticc_sicas_coberturas')->where('IDTemp', $Id)->delete();

        $response = DB::table('ticc_sicas_coberturas')->where('IDDocto', $IdDoc)->where('Documento', $Doc)->get();

        return $this->JsonResponse(200, $response, $request, "exito");
    }

    function CalculateHonorario($obj, $importe, $recargo, $derechos)
    {
        $rerturn = 0;
        $sum = 0;
        $percent = intval($obj->Porcentaje) / 100;
        if ($obj->Formula == 1) {
            $sum = floatval($importe);
        }
        if ($obj->Formula == 2) {
            $sum = floatval($importe + $recargo + $derechos);
        }
        //echo 'Suma'.$sum.'---- Porcentaje'.$percent;
        return ($percent * $sum);
    }

    public function deleteOT(Request $request)
    {
        $Id = $request["Id"];
        $addObject = Polizas::where("IDDocto", $Id)->delete();
        //Elminar los recibos
        //Eliminar los endosos
        //Eliminar los honorarios
        //Eliminar las comisiones
        return $this->JsonResponse(200, $addObject, $request, "exito");
    }

    public function AccionesPestana(Request $request)
    {
        $Id = $request["Id"];
        $dta = $request["Accion"];
        $Modulo = $request["Modulo"];
        $return = [];

        if ($dta == "DOCUMENT") {
            $return = DB::table('ticc_sicas_documentos')->where('Modulo', $Modulo)->where('IDValuePK', $Id)->whereIn('TypeDestinoCDigital', array('DOCUMENT', 'RECIBO'))->orderBy('Id', 'DESC')->get();
        } else {
            switch ($Modulo) {
                case 'P':
                    $doc = Polizas::find($Id);
                    break;
                case 'F':
                    $doc = Fianzas::find($Id);
                    break;
                case 'E':
                    $doc = Endoso::find($Id);
                    break;
            }
            $return = Bitacora::where('IDDocto', $Id)->where('Modulo', $Modulo)->orderBy('IDBit', 'DESC')->get();
            //$return = Bitacora::where('ClaveBit', $doc->ClaveBit)->where('Modulo', $Modulo)->orderBy('FechaHora', 'DESC')->get();
        }

        return $this->JsonResponse(200, $return, $request, "exito");
    }

    public function DeleteDocument(Request $request)
    {
        $Id = $request["Id"];
        $Delete = DB::table('ticc_sicas_documentos')->where('Id', $Id)->delete();
        return $this->JsonResponse(200, [], $request, "exito");
    }

    public function addBitacora(Request $request)
    {
        $Id = $request["Id"];
        $dta = $request["data"];
        $Modulo = $request["Modulo"];
        $doc = Polizas::find($Id);

        $newBitacora = new Bitacora;
        $newBitacora->FechaHora = date('Y-m-d H:i:sa');
        $newBitacora->UserGen = $dta['Usuario'];
        //$newBitacora->Procedencia = 'OT';
        $newBitacora->Comentario = $dta['Comentario'];
        //$newBitacora->ClaveBit = $doc->ClaveBit;
        $newBitacora->Prioridad = '1';
        $newBitacora->Modulo = $dta['Modulo'];
        $newBitacora->IDDocto = $Id;
        $add = $newBitacora->save();
        return $this->JsonResponse(200, $add, $request, "exito");
    }

    public function addDocument(Request $request)
    {
        $Id = $request["Id"];
        $dta = $request["data"];
        $Tipo = $request["Tipo"];
        //$doc = Polizas::find($Id);
        $add = [];

        DB::table('ticc_sicas_documentos')->insert([
            'TypeDestinoCDigital' => $Tipo, //"DOCUMENT",
            'IDValuePK' => $Id,
            'ActionCDigital' => 1,
            'ListFilesURL' => $dta['ruta_completa'],
            'TipoEntidad' => 1,
            'FolderDestino' => $dta['nombre'],
            'Modulo' => $dta['Modulo']
        ]);

        /*   $newBitacora = new Bitacora;
        $newBitacora->FechaHora = date('Y-m-d H:s:m');
        $newBitacora->UserGen = $dta['Usuario'];
        $newBitacora->Procedencia = 'OT';
        $newBitacora->Comentario = $dta['Comentario'];
        $newBitacora->ClaveBit = $doc->ClaveBit;
        $newBitacora->Prioridad = '1';
        $add = $newBitacora->save(); */
        return $this->JsonResponse(200, $add, $request, "exito");
    }

    //Obtner el catalogo de los clientes
    public function getClientesCatalog(Request $request)
    {
        $isfiltered = false;
        $Query = DB::table('ticc_sicas_clientes as a');
        $Query->selectRaw("*");
        $Json = $Query->get();
        //Filterer
        $offset = $request["start"];
        $Query2 = DB::table('ticc_sicas_clientes as a');
        $Query2->selectRaw("*");
        //Campo de busqueda
        if ($request["search"] != '') {
            $isfiltered = true;
            $Query2->where('NombreCompleto', 'like', '%' . $request["search"] . '%');
        }

        $Query2->skip($offset)->take(10);

        //Set Offse
        /* if (isset($request["start"]))
            $Query2->skip($offset)->take(10); */

        $Query2->orderBy('Nombre', 'ASC');
        $Json2 = $Query2->get();
        //return $this->JsonResponse(200, $result, "exito");
        return $this->JsonResponseTable(200, $Json, $Json2, $request, $isfiltered, "exito");
    }

    public function ComponenteTabla(Request $request)
    {
        $Query = "";
        $returnOPC = [];
        $res = [];
        $field = "";
        $order = "";
        $QueryCount = "";
        switch ($request["Tipo"]) {
            case '1':
                $Query = DB::table('ticc_sicas_clientes as a');
                $QueryCount = DB::table('ticc_sicas_clientes as a');

                $Query->selectRaw("a.IDCli as Id,a.NombreCompleto as Nombre");
                $Query->where('a.NombreCompleto', '<>', '');
                $QueryCount->where('a.NombreCompleto', '<>', '');
                //$returnOPC=['a.IDCli as Id', 'a.NombreCompleto as Nombre'];
                if ($request["Busqueda"] != '') {
                    //$Query->where('NombreCompleto', 'like', '%' . $request["Busqueda"] . '%');
                    //$QueryCount->where('NombreCompleto', 'like', '%' . $request["Busqueda"] . '%');
                    $Query->where(function ($query) use ($request) {
                        $query->where('a.NombreCompleto', 'LIKE', '%' . $request["Busqueda"] . '%')
                            ->orWhere('a.Nombre', 'LIKE', '%' . $request["Busqueda"] . '%')
                            ->orWhere('a.ApellidoP', 'LIKE', '%' . $request["Busqueda"] . '%')
                            ->orWhere('a.ApellidoM', 'LIKE', '%' . $request["Busqueda"] . '%');
                    });

                    $QueryCount->where(function ($query) use ($request) {
                        $query->where('a.NombreCompleto', 'LIKE', '%' . $request["Busqueda"] . '%')
                            ->orWhere('a.Nombre', 'LIKE', '%' . $request["Busqueda"] . '%')
                            ->orWhere('a.ApellidoP', 'LIKE', '%' . $request["Busqueda"] . '%')
                            ->orWhere('a.ApellidoM', 'LIKE', '%' . $request["Busqueda"] . '%');
                    });
                }

                $field = "a.NombreCompleto";
                $order = "ASC";
                break;
            default:
                # code...
                break;
        }
        $count = $QueryCount->get();
        $Query->skip($request["Offset"])->take(10);
        $Query->orderBy($field, $order);
        $res = $Query->get();
        return $this->JsonResponse(200, $res, "exito", $count);
    }

    public function UsuarioDirecciones(Request $request)
    {
        $Query = DB::table('ticc_sicas_direcciones as a');
        $Query->selectRaw("a.IDTemp as Id,concat(a.calle, ' ', a.CPostal, ' ', a.Poblacion, ' ', a.Ciudad ) as Nombre");
        $Query->where('a.IDCli', $request['IDCli']);
        $Json = $Query->get();
        return $this->JsonResponse(200, $Json, $request, "exito");
    }

    public function SaveFlotillas(Request $request)
    {
        $dta = $request["data"];
        //$id=$dta["IDTemp"]
        if ($dta['IDTemp'] > 0) {
            $addObject = Flotillas::where("IDTemp",  $dta['IDTemp'])->update($dta);
        } else {
            if (isset($dta['FAlta'])) {
                $dta['FAlta'] = date('Ymd');
            }
            $addObject = Flotillas::updateOrCreate($dta);
        }
        $Json = Flotillas::where('IDDocto', $dta['IDDocto'])->orderBy('NumInc', 'DESC')->get();
        return $this->JsonResponse(200, $Json, $request, "exito");
    }

    public function DeleteFlotillas(Request $request)
    {
        $Id = $request["Id"];
        $Docto = $request["IDDocto"];
        Flotillas::where("IDTemp", $Id)->delete();
        $Json = Flotillas::where('IDDocto', $Docto)->orderBy('NumInc', 'DESC')->get();
        return $this->JsonResponse(200, $Json, $request, "exito");
    }

    public function SaveRecibos(Request $request)
    {
        $dta = $request["data"];
        //$Modulo = $request["Modulo"];
        foreach ($dta as $key => $value) {
            $IDRecibo = 0;
            //echo 'IdRecibo '.$value["IDTemp"];
            unset($value['IsEdit']);
            $value['Periodo'] = $key + 1;
            $value['Serie'] = "0" . ($key + 1) . "/0" . count($dta);
            $value['Status'] = 5;
            $value['Status_TXT'] = "Pendiente";
            //if ($value["IDTemp"] < 0) {
            if (!isset($value["IDTemp"])) {
                $Find = Recibos::where('IDDocto', $value['IDDocto'])->where('Periodo', $value['Periodo'])->where('IDEnd', isset($value['IDEnd']) ? $value['IDEnd'] : 0)->where('Documento', $value['Documento'])->where('Modulo', $value['Modulo'])->get();
                if (count($Find) == 0) {
                    $inserted = Recibos::insertGetId($value);
                    $IDRecibo = $inserted;
                    $UpdateAfter = Recibos::where("IDTemp", $inserted)->update(array('IDRecibo' => $inserted));
                    //$value = Recibos::where("IDTemp", $inserted)->first();
                }
            } else {
                $IDRecibo = $value["IDTemp"];
                $UpdateAfter = Recibos::where("IDTemp", $value["IDTemp"])->update($value);
                //$value = Recibos::where("IDTemp", $value["IDTemp"])->first();
            }
            //var_dump($value);
            ///Guardar comisiones y honorarios individuales
            //Comisiones
            //$value = (array)$value;
            //var_dump($IDRecibo);
            $FindComisiones = [];
            if ($value["Modulo"] === "E") {
                $FindComisiones = DB::table('ticc_sicas_comisiones_documento')->where('IDDoc', $value['IDEnd'])->where('Documento', $value['Documento'])->where('Modulo', $value['Modulo'])->where('Status', 3)->get();
            } else {
                $FindComisiones = DB::table('ticc_sicas_comisiones_documento')->where('IDDoc', $value['IDDocto'])->where('Documento', $value['Documento'])->where('Modulo', $value['Modulo'])->where('Status', 3)->get();
            }
            //Delete all
            //$DeleteComisiones = DB::table('ticc_sicas_com_recibos')->where('IdRecibo', $IDRecibo)->where('IDDoc', $value['IDDocto'])->where('Documento', $value['Documento'])->where('Modulo', $value['Modulo'])->where('Status', 3)->delete();
            $CountT1 = 0;
            foreach ($FindComisiones as $key => $val) {
                if ($val->Tipo != 1) {
                    $CountT1++;
                }
                $FindElement = DB::table('ticc_sicas_com_recibos')->where('IdRecibo', $IDRecibo)->where('Documento', $val->Documento)->where('Agente', $val->Agente)->where('Tipo', $val->Tipo)->where('Modo', 'A')->first();
                $val->Importe = (round($val->Importe / count($dta), 4)) /* * ($val->Participacion) */;
                $val->CNeta = (round($val->CNeta / count($dta), 4)) /* * ($val->Participacion) */;
                $val->PNeta = (round($val->PNeta / count($dta), 4)) /* * ($val->Participacion) */;
                $val->IVA = (round($val->IVA / count($dta), 4)) /* * ($val->Participacion) */;
                $val->Ptotal = (round($val->PNeta + $val->IVA, 4)) /* * ($val->Participacion) */;
                $val->{'IdRecibo'} =  $IDRecibo; //$IDRecibo
                $val->{'Modo'} = 'A';
                unset($val->{'Id'});
                if ($FindElement != null) {
                    $Inserted = DB::table('ticc_sicas_com_recibos')->where('Id', $FindElement->Id)->update((array)$val);
                } else {
                    $Inserted = DB::table('ticc_sicas_com_recibos')->insertGetId((array)$val);
                }
                //$Inserted = DB::table('ticc_sicas_com_recibos')->insertGetId((array)$val);
                /* if ($CountT1 > 1) {
                    $Inserted = DB::table('ticc_sicas_com_recibo')->insertGetId((array)$val);
                } */
            }
            if ($value["Modulo"] === "E") {
                $FindHon = DB::table('ticc_sicas_honorarios')->where('IDDocto', $value['IDEnd'])->where('documento', $value['Documento'])->where('Modulo', $value['Modulo'])->where('Status', 3)->get();
            } else {
                $FindHon = DB::table('ticc_sicas_honorarios')->where('IDDocto', $value['IDDocto'])->where('documento', $value['Documento'])->where('Modulo', $value['Modulo'])->where('Status', 3)->get();
            }

            //$DeleteHon = DB::table('ticc_sicas_hon_recibos')->where('IdRecibo', $IDRecibo)->where('IDDocto', $value['IDDocto'])->where('documento', $value['Documento'])->where('Modulo', $value['Modulo'])->where('Status', 3)->delete();
            foreach ($FindHon as $key => $val) {
                $FindInd = DB::table('ticc_sicas_hon_recibos')->where('Id_vendedor', $val->Id_vendedor)->where('IdRecibo', $IDRecibo)->where('IDDocto', $val->IDDocto)->where('documento', $val->documento)->where('Modulo', $val->Modulo)->where('Id_formula', $val->Id_formula)->where('Modo', 'A')->first();
                $val->{'IdRecibo'} = $IDRecibo;
                $val->importe = (round($val->Neta / count($dta), 4) / 100) * ($val->participacion);
                $val->Importe_pago = (round($val->Neta / count($dta), 4) / 100) * ($val->participacion);
                $val->Neta = (round($val->Neta / count($dta), 4));
                $val->Base = (round($val->Neta, 4));
                $val->{'Modo'} = 'A';
                if ($FindInd != null) {
                    unset($val->{'Id'});
                    $Inserted = DB::table('ticc_sicas_hon_recibos')->where('Id', $FindInd->Id)->update((array)$val);
                } else {
                    unset($val->{'Id'});
                    $Inserted = DB::table('ticc_sicas_hon_recibos')->insertGetId((array)$val);
                }
            }
        }
        return $this->JsonResponse(200, [], $request, "exito");
    }

    public function RenovarPoliza(Request $request)
    {
        $Id = $request["Id"];
        $FindByIDDOCTO = DB::table('ticc_sicas_documentos')->where('IDDocto', $Id)->first();
        $Find = Polizas::find($FindByIDDOCTO->IDTemp);
        $OT = "OT-" . date('YmdHsm');
        $docU = Polizas::where('IDDocto', $Id)->update(["Status" => '1', "Status_TXT" => 'Renovada']);
        $SetDocumento = empty($Find->Documento) ? $Find->Solicitud : $Find->Documento;
        $IsPosterior = !empty($Find->DPosterior) ? $Find->DPosterior : $SetDocumento . '-' . ($Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1);
        $copy = $Find->replicate()->fill(
            [
                //'DAnterior' => $Find->Documento,
                'TipoDocto' => $Find->TipoDocto,
                'Status' => 1,
                'Status_TXT' => "Vigente",
                'IsNew' => 1,
                'IsSavedPoliza' => 1,
                'NumRenovacion' => $Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1,
                'FDesde' => $Find->FHasta,
                'FHasta' => date("Y-m-d", strtotime('+1 year', strtotime($Find->FHasta))),
                'PrimaNeta' => 0,
                'Descuento' => 0,
                'Recargos' => 0,
                'Derechos' => 0,
                'STotal' => 0,
                'IVA' => 0,
                'Ajuste' => 0,
                'PrimaTotal' => 0,
                'ComNeta' => 0,
                'ComRec' => 0,
                'ComDer' => 0,
                'Especial' => 0,
                'Documento' => $IsPosterior
                //'Documento' => $SetDocumento . '-' . ($Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1)
                //'IDDocto' => $copy->IDTemp,
            ]
        );
        $Find->DPosterior = $copy->Documento;
        $Find->save();
        unset($copy->DAnterior);
        unset($copy->DPosterior);
        $DOCC = $Find['attributes']['Documento'] != "" ? $Find['attributes']['Documento'] : $Find['attributes']['Solicitud'];
        $Explode = explode("-", $DOCC);
        //var_dump($copy);
        $copy->save();
        $copy->IsSavedPoliza = null;
        //$copy->DAnterior = $Find->Documento;
        $copy->DAnterior = $SetDocumento;
        $copy->Solicitud = $OT;
        $copy->IDDocto = $copy['attributes']['IDTemp'];
        $copy->save();
        //$addObject = $copy['attributes'];
        $addObject = Polizas::find($copy->IDDocto);

        $Config = array(
            "IDMon" => isset($addObject->IDMon) ? $addObject->IDMon : 0,
            "IDVend" => isset($addObject->IDVend) ? $addObject->IDVend : 0,
            "IDSubramo" => isset($addObject->IDSSRamo) ? $addObject->IDSSRamo : 0,
            "IDSubgrupo" => isset($addObject->IDSubGrupo) ? $addObject->IDSubGrupo : 0,
            "IDCliente" => isset($addObject->IDCli) ? $addObject->IDCli : 0,
            "IDDocto" => isset($addObject->IDDocto) ? $addObject->IDDocto : 0,

        );
        //$listado = DB::select('CALL ConfiguracionHonorarios(?,?,?,?)', array($addObject->IDVend, $addObject->IDMon, $addObject->IDSSRamo, $addObject->IDDocto));
        //$listado = Honorarios::CreateHonorariosv2($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'P');
        /* $listado = Honorarios::CreateHonorariov3($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'P', ($addObject->ComRec + $addObject->ComDer));
        $Continuo = 0;
        foreach ($listado as $key => $value) {
            $valoresF = array(
                "CBase" => $addObject->ComNeta,
                "CRecargos" => $addObject->ComRec,
                "CDerechos" => $addObject->ComDer
            );
            $Continuo++;
            DB::table('honorarios1')->insert([
                'Id_vendedor' => $value->VendH,
                'IDDocto' => $addObject->IDDocto,
                'Id_tipo_hon' => $value->Id_tipo_hon,
                //'Id_tipo_hon' => $value->Id_honorario,
                'Id_tipo' => 1,
                'Id_formula' => $value->Formula,
                'participacion' => $value->Porcentaje,
                //'importe' => $this->CalculateHonorario($value, $addObject->ComNeta, $addObject->ComRec),
                'importe' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                'documento' => $addObject->Documento,
                'Folio' => 'H' . date('YmdHHssmm') . '' . $Continuo,
                'Id_moneda_pago' => $addObject->IDMon,
                'Id_moneda_docto' => $addObject->IDMon,
                'Tipo_cambio_pago' => $addObject->TipoCambio,
                'Tipo_cambio_docto' => $addObject->TipoCambio,
                'Base' => Helpers::BaseFormulaHonorarios($value->Formula, $valoresF),
                //'Base' => $value->Formula == 1 ? floatval($addObject->ComNeta) : floatval($addObject->ComNeta + $addObject->ComRec),
                //'Importe_pago' => $this->CalculateHonorario($value, $addObject->ComNeta, $addObject->ComRec),
                'importe' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                'Neta' => $addObject->ComNeta,
                'Recargo' => $addObject->ComRec,
                'IDVendGen' => $addObject->IDVend,
                'Status' => 3,
                'Status_TXT' => 'Pendiente',
                'Modulo' => 'P'
            ]);
        }

        $counCom = DB::table('ticc_sicas_comisiones_documento')->where("Modulo", 'P')->where("Documento", $addObject->Documento)
            ->where("Status", 3)
            ->where("IDDoc", $addObject->IDDocto)->get();
        if (count($counCom) == 0) {
            $Array = array(
                "PComNeta" => isset($addObject->PComNeta) ? $addObject->PComNeta : 0,
                "PComRec" => isset($addObject->PComRec) ? $addObject->PComRec : 0,
                "PComDer" => isset($addObject->PComDer) ? $addObject->PComDer : 0,
                "PCGastosMaquila" => isset($addObject->PCGastosMaquila) ? $addObject->PCGastosMaquila : 0,
            );
            $ComisionesAgte = Honorarios::ComisionesAgentes($Array, $addObject, 'P');
        } */


        return $this->JsonResponse(200, $addObject, $request, "exito");
    }

    public function SaveFlotillasFile(Request $request)
    {
        $Id = $request["IDDocto"];
        $Doc = $request["Documento"];
        if ($request->hasFile('myFile')) {
            $name = "/flotillas.xlsx";
            $filename = __DIR__ . $name;
            move_uploaded_file($_FILES['myFile']['tmp_name'], $filename);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
            $worksheet = $spreadsheet->setActiveSheetIndex(0);
            $arr = $worksheet->toArray();
            if (count($arr) == 1) {
                return $this->JsonResponse(400, [], $request, "No tiene informacion el documento cargado.");
            }
            for ($i = 1; $i < count($arr); $i++) {
                $newFlotilla = new Flotillas();
                $newFlotilla->IDDocto = $Id;
                $newFlotilla->Documento = $Doc;
                $newFlotilla->NumInc = $arr[$i][0];
                //$newFlotilla->EndosoA = $arr[$i][1];
                //$newFlotilla->EndosoB = $arr[$i][1];
                $newFlotilla->FAlta = date('Y-m-d');
                //$newFlotilla->FBaja = $arr[$i][1];
                //$newFlotilla->Status = $arr[$i][1];
                $newFlotilla->Certificado = $arr[$i][2];
                //$newFlotilla->Referencia = $arr[$i][1];
                $newFlotilla->NumEco = $arr[$i][1];
                //$newFlotilla->GrupoGMV = $arr[$i][1];
                //$newFlotilla->NombrePlan = $arr[$i][1];
                //$newFlotilla->NombreSubPlan = $arr[$i][1];
                //$newFlotilla->AsegNombreCompleto = $arr[$i][1];
                //$newFlotilla->AsegApellidoP = $arr[$i][1];
                //$newFlotilla->AsegApellidoM = $arr[$i][1];
                //$newFlotilla->AsegNombre = $arr[$i][1];
                //$newFlotilla->AsegTitulo = $arr[$i][1];
                //$newFlotilla->AsegFechaNac = $arr[$i][1];
                //$newFlotilla->AsegTelefono1 = $arr[$i][1];
                //$newFlotilla->AsegTelefono2 = $arr[$i][1];
                //$newFlotilla->AsegTelefono3 = $arr[$i][1];
                //$newFlotilla->AsegTelefono4 = $arr[$i][1];
                $newFlotilla->PrimaNeta = $arr[$i][39];
                $newFlotilla->Descuento = $arr[$i][40];
                $newFlotilla->PorDesc = $arr[$i][41];
                //$newFlotilla->PorExtraP = $arr[$i][1];
                $newFlotilla->Recargos = $arr[$i][42];
                $newFlotilla->PorRecargos = $arr[$i][43];
                $newFlotilla->Derechos = $arr[$i][44];
                $newFlotilla->IVA = $arr[$i][45];
                $newFlotilla->PorIVA = $arr[$i][46];
                $newFlotilla->PrimaTotal = $arr[$i][48];
                $newFlotilla->Marca = $arr[$i][5];
                $newFlotilla->Tipo = $arr[$i][7];
                $newFlotilla->Transmision = $arr[$i][8];
                $newFlotilla->Puertas = $arr[$i][9];
                $newFlotilla->Modelo = $arr[$i][11];
                $newFlotilla->Serie = $arr[$i][13];
                $newFlotilla->Motor = $arr[$i][14];
                $newFlotilla->Repuve = $arr[$i][15];
                $newFlotilla->Placas = $arr[$i][12];
                $newFlotilla->EstadoCircula = $arr[$i][17];
                $newFlotilla->Color = $arr[$i][18];
                $newFlotilla->Ocupantes = $arr[$i][19];
                $newFlotilla->Servicio = $arr[$i][20];
                $newFlotilla->UsoVehiculo = $arr[$i][21];
                $newFlotilla->TipoCarga = $arr[$i][23];
                $newFlotilla->Tonelaje = $arr[$i][24];
                $newFlotilla->EqEsp = $arr[$i][27];
                $newFlotilla->EqEspSAseg = $arr[$i][28];
                $newFlotilla->Adap = $arr[$i][29];
                $newFlotilla->AdapSAseg = $arr[$i][30];
                //$newFlotilla->DoctoAlta = $arr[$i][1];
                //$newFlotilla->DoctoBaja = $arr[$i][1];
                $newFlotilla->CiaLocalizacion = $arr[$i][25];
                $newFlotilla->RDescripcion = $arr[$i][31];
                $newFlotilla->RMarca = $arr[$i][32];
                $newFlotilla->RTipo = $arr[$i][33];
                $newFlotilla->RClave = $arr[$i][35];
                $newFlotilla->RPlacas = $arr[$i][36];
                $newFlotilla->RSerie = $arr[$i][37];
                $newFlotilla->RSumaAsegurada = $arr[$i][38];
                //$newFlotilla->SubTotal = $arr[$i][1];
                $newFlotilla->Conductor = $arr[$i][3];
                $newFlotilla->Direccion = $arr[$i][4];
                $newFlotilla->SubMarca = $arr[$i][6];
                //$newFlotilla->flotillavehiccol = $arr[$i][1];
                $newFlotilla->Clave = $arr[$i][11];
                $newFlotilla->Cochera = $arr[$i][16];
                $newFlotilla->Inspeccion = $arr[$i][22];
                $newFlotilla->SerieLocalizador = $arr[$i][26];
                $newFlotilla->RModelo = $arr[$i][34];
                $newFlotilla->Ajuste = $arr[$i][47];
                //var_dump($newFlotilla);
                $add = $newFlotilla->save();
            }
            $Json = Flotillas::where('IDDocto', $Id)->orderBy('NumInc', 'DESC')->get();
            return $this->JsonResponse(200, $Json, $request, "exito");
        } else {
            return $this->JsonResponse(200, [], $request, "Error en el servicio");
        }
    }

    public function DocPolizas(Request $request)
    {
        try {
            $Query = DB::table('ticc_sicas_documentos as a');
            $Query->selectRaw("a.IDDocto,a.Status,a.FDesde,a.FHasta,a.Solicitud,a.Documento,b.Nombre as Subramo, a.VendNombre as Vendedor");
            //$Query->leftjoin('sicas_subramo as b', 'a.IDSRamo', '=', 'b.Id');
            // $Query->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDTemp');
            $Query->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
            //$Query->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
            //$Query->leftjoin('vendedores as d', 'a.IDVend', '=', 'd.IDVend');
            if ($request["search"] != '') {
                $isfiltered = true;
                $Query->where(function ($query) use ($request) {
                    $query->where('a.Solicitud', 'LIKE', '%' . $request["search"] . '%')
                        ->orWhere('b.Nombre', 'LIKE', '%' . $request["search"] . '%')
                        ->orWhere('a.Documento', 'LIKE', '%' . $request["search"] . '%')
                        ->orWhere('a.Serie', 'LIKE', '%' . $request["search"] . '%')
                        //->orWhere('a.EstatusUsuario', 'LIKE', '%' . $request["search"] . '%')
                        ->orWhere('a.VendNombre', 'LIKE', '%' . $request["search"] . '%');
                });
            }
            //$Query->where('a.IsNew', 1);
            //$Query->where('TipoDocto', 0);
            $Json = $Query->get();
            //return $Json = $Query->toSql();



            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FF34D614',
                    ],
                    'endColor' => [
                        'argb' => 'FF34D614',
                    ],
                ],
            ];
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:H1')->applyFromArray($styleArray);
            $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->setTitle('Registros');
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("A1", "IDDocto")
                ->setCellValue("B1", "Estatus")
                ->setCellValue("C1", "SubRamo")
                ->setCellValue("D1", "FDesde")
                ->setCellValue("E1", "FHasta")
                ->setCellValue("F1", "Solicitud")
                ->setCellValue("G1", "Documento")
                ->setCellValue("H1", "Vendedor");
            $start = 2;

            foreach ($Json as $key => $val) {
                //$styleC++;
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("A{$start}", $val->IDDocto);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("B{$start}", $val->Status);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$start}", $val->Subramo);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$start}", $val->FDesde);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$start}", $val->FHasta);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("F{$start}", $val->Solicitud);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("G{$start}", $val->Documento);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("H{$start}", $val->Vendedor);

                //$spreadsheet->setActiveSheetIndex(0)->getStyle("A{$start}:F{$start}")->applyFromArray($this->isPar($styleC) ? $stylePar : $styleImpar);
                $start++;
            }

            $spreadsheet->setActiveSheetIndex(0);
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(__DIR__ . "/Registros.xlsx");
            $headers = array(
                'Content-Type: application/xlsx',
            );

            return response()->download(__DIR__ . "/Registros.xlsx", "Registros.xlsx", $headers);
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    #region Fianzas
    public function Fianzas(Request $request)
    {
        //Total
        $isfiltered = false;
        $Query = DB::table('ticc_sicas_documentos as a');
        //$Query->selectRaw("*");
        $Query->selectRaw("count(IDTemp) as Id");

        //$Query->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
        //$Query->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
        //$Query->leftjoin('vendedores as d', 'a.IDVend', '=', 'd.IDVend');
        //$Query->leftjoin('sicas_estatus_documento as f', 'a.IDEstatusUsuario', '=', 'f.Id');
        //$Query->where('a.IsNew', 1);
        //$Json = $Query->get();
        $Query->where('TipoDocto', 0);
        $Json = $Query->first();
        //Filterer
        $offset = $request["start"];
        $Query2 = DB::table('ticc_sicas_documentos as a');
        $Query2->where('TipoDocto', 0);
        $Query2->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
        //$Query2->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
        //$Query2->leftjoin('vendedores as d', 'a.IDVend', '=', 'd.IDVend');
        $Query2->leftjoin('ticc_sicas_estatus_documento as f', 'a.IDEstatusUsuario', '=', 'f.Id');
        //Campo de busqueda
        if ($request["search"] != '') {
            $isfiltered = true;
            $Query2->where(function ($query) use ($request) {
                $query->where('a.Solicitud', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('b.Nombre', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('a.EstatusUsuario', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('a.VendNombre', 'LIKE', '%' . $request["search"] . '%');
            });
        }
        if ($request['Estatus'] != '') {
            $Query2->where('a.Status_TXT', $request['Estatus']);
        }

        $Json3 = clone $Query2;
        $Json3->selectRaw("count(IDTemp) as Id");
        $check = $Json3->first();


        //Set Offse
        if (isset($request["start"]))
            $Query2->skip($offset)->take(10);
        else
            $Query2->skip(0)->take(10);

        $Query2->selectRaw("a.IDDocto,f.Nombre EstatusUsuario,b.Nombre Subramo, DATE_FORMAT(a.FDesde,'%Y-%d-%m') FDesde,DATE_FORMAT(a.FHasta,'%Y-%d-%m') FHasta, DATE_FORMAT(a.FCaptura,'%Y-%d-%m %H:%i') FCaptura,a.Solicitud,
        a.VendNombre as Vendedor, '' as Acciones, IF(a.Status=0, DATEDIFF(NOW(),a.FCaptura), DATEDIFF(a.FCaptura, a.FEmision)) as Dias,a.Documento,a.Status_TXT");
        $Query2->orderBy('IDDocto', 'DESC');
        //$Query2->where('a.IsNew', 1);
        //return $Json2 = $Query2->toSql();
        $Json2 = $Query2->get();
        //var_dump($Json);
        return $this->JsonResponseTable(200, $Json, $Json2, $request, $isfiltered, "exito", $check);
    }

    public function SingleFianza(Request $request)
    {
        $ID = $request["Id"];
        $Query = DB::table('ticc_sicas_documentos as a');
        $Query->selectRaw("a.*");
        $Query->where('IDDocto', $ID);

        $Json = $Query->first();

        $Usuario = null;
        $flotillas = [];
        $Recibos = [];
        $Recibos = [];
        $Honorarios = [];
        $Endosos = [];
        //obtnemos el usuario
        if ($Json != null) {
            $Usuario = DB::table('ticc_sicas_clientes as a')->selectRaw("a.IDCli as Id,a.NombreCompleto as Nombre")->where('a.IDCli', $Json->IDCli)
                ->leftjoin('ticc_sicas_direcciones as b', 'a.IDCli', '=', 'b.IDCli')
                ->first();

            $Direcciones = DB::table('ticc_sicas_direcciones as a')->selectRaw("a.IDTemp as Id,concat(a.calle, ' ', a.CPostal, ' ', a.Poblacion, ' ', a.Ciudad ) as Nombre")->where('a.IDCli', $Json->IDCli)
                ->get();

            //$flotillas = Flotillas::where('IDDocto', $Json->IDDocto)->orderBy('NumInc', 'DESC')->get();
            //$Recibos = Recibos::where('IDDocto', $Json->IDDocto)->where('Documento', $Json->Documento)->where('IDEnd', 0)->where('Modulo', 'F')->orderBy('Periodo', 'ASC')->get();
            $Recibos = Recibos::where('IDDocto', $Json->IDDocto)->where('Documento', $Json->Documento)->where('IDEnd', 0)->orderBy('Periodo', 'ASC')->get();
            //$Honorarios = DB::select('CALL ConfiguracionHonorarios(?,?,?,?)', array($Json->IDVend, $Json->IDMon, $Json->IDSSRamo, $Json->IDDocto));
            //$Honorarios = Honorarios::CreateHonorariosv2($Json->IDMon, $Json->IDVend, $Json->IDSSRamo, $Json->IDSubGrupo, $Json->IDCli, $Json->IDDocto, 'F');
            $Honorarios = Honorarios::CreateHonorariov3($Json->IDMon, $Json->IDVend, $Json->IDSSRamo, $Json->IDSubGrupo, $Json->IDCli, $Json->IDDocto, 'F', ($Json->CGastosMaquila + $Json->ComDer));
            //$Comisiones = DB::select('CALL GetListaComisiones(?,?,?)', array($Json->IDMon, $Json->IDSSRamo, $Json->IDAgente));
            //$Comisiones = DB::select('CALL ListaHonorarios(?,?,?)', array($Json->IDDocto, $Json->Documento, 'F'));
            $Comisiones = DB::select('CALL GetListaComisionesV2(?,?,?)', array($Json->IDDocto, $Json->Documento, 'F'));
            $Endosos = DB::table('ticc_sicas_endosos as a')->where('IDDocto', $Json->IDDocto)->where('Documento', $Json->Documento)->where('Modulo', 'F')->get();
        }

        if (empty($Usuario)) {
            $Usuario["Nombre"] = "";
            $Usuario["Id"] = "";
        }

        $participacion = 0;
        //return $Honorarios;
        /*  foreach ($Honorarios as $key => $value) {
            $participacion = $participacion + isset($value->participacion) ? $value->participacion : 0;
        } */
        $GrupoHon = array();
        foreach ($Honorarios as $key => $value) {
            if (isset($value->Id_formula)) {
                $GrupoHon[$value->Id_formula] = (isset($GrupoHon[$value->Id_formula]) ? $GrupoHon[$value->Id_formula] : 0) + $value->participacion;
                if (isset($value->Id_formula)) {
                    if ($value->Id_formula == 1 || $value->Id_formula == 2) {
                        $participacion = $participacion + (isset($value->participacion) ? $value->participacion : 0);
                    }
                }
            }
        }

        $data = array(
            "OT" => $Json,
            "Usuario" => array(
                "Info" => $Usuario,
                "Direcciones" => $Direcciones,
            ),
            //"Flotillas" => $flotillas,
            "Recibos" => $Recibos,
            "Honorarios" => $Honorarios,
            "Comisiones" => $Comisiones,
            "Endosos" => $Endosos,
            "TotalHonorario" => $participacion,
            "TotalHonorariosGrupo" => $GrupoHon
        );
        return $this->JsonResponse(200, $data, $request, "exito");
    }

    public function SaveFianzas(Request $request)
    {
        $Code = 200;
        $Message = "Exito";
        $Data = [];

        try {
            DB::beginTransaction(); //Inicio de la transaccion
            $Id = $request["Id"];
            $dta = $request["data"];
            $LoggedUser = $request["User"];
            unset($dta['IDDocto']);

            $OT = "OT-" . date('YmdHsm');

            if (!array_key_exists('Solicitud', $dta)) {
                $dta["Solicitud"] = $OT;
                $dta["IsNew"] = 1;
                $dta["FSolicitud"] = date('Y-m-d');
            }
            if ($dta["Solicitud"] == '') {
                $dta["Solicitud"] = $OT;
            }

            if ($dta['TipoDocto'] == '1') {
                $dta['IsSavedPoliza'] = isset($dta['IsSavedPoliza']) ? $dta['IsSavedPoliza'] : 1;
                $dta['Status_TXT'] = isset($dta['Status_TXT']) ? $dta['Status_TXT'] : "Vigente";
                $dta['Status'] = isset($dta['Status']) ? $dta['Status'] : 1;
                if (isset($dta['FConversion'])) {
                    if ($dta['FConversion'] == '' || is_null($dta['FConversion'])) {
                        //Actualizamos la fecha de coneversion
                        $dta['FConversion'] = date('Y-m-d');
                    }
                } else {
                    $dta['FConversion'] = date('Y-m-d');
                }
            }

            //poner los nombres
            $Vendedor = Vendedor::where('IDVend', $dta["IDVend"])->first();
            $Cliente = DB::table('ticc_sicas_clientes')->where('IDCli', $dta["IDCli"])->first();
            $dta["NombreCompleto"] = isset($Cliente->NombreCompleto) ? $Cliente->NombreCompleto : null;
            $dta["VendNombre"] = isset($Vendedor->VendNombre) ? $Vendedor->VendNombre : null;


            //validamo que no exista el documento
            if (isset($dta['Documento'])) {
                $CheckDocumento = Fianzas::where('Documento', $dta['Documento']);
                if ($Id > 0) {
                    $CheckDocumento->where('IDDocto', '<>', $Id);
                }
                $result = $CheckDocumento->get();
                if (count($result) > 0) {
                    $Code = 400;
                    $Message = "Ya existe registro con el mismo valor de documento: \n {$dta['Documento']}, Ingrese otro valor.";
                    return $this->JsonResponse($Code, $Data, $Message);
                }
            }



            if ($Id > 0) {
                unset($dta['IDTemp']);
                $FindByDocto = DB::table('ticc_sicas_documentos')->where('IDDocto', $Id)->first();
                $FinP = Fianzas::find($FindByDocto->IDTemp);
                if ($FinP['attributes']['Documento'] != $dta["Documento"]) {
                    //Actualizamos los recibos
                    $ActRcibos = DB::table('ticc_sicas_recibos')->where('Documento', $FinP['attributes']['Documento'])->where('IDDocto', $Id)->update([
                        "Documento" => $dta["Documento"]
                    ]);
                    //Actualizamos los honorarios
                    $Hon = DB::table('ticc_sicas_honorarios as a')->where('IDDocto', $Id)->where('documento', $FinP['attributes']['Documento'])->update([
                        "Documento" => $dta["Documento"]
                    ]);
                    //Actualizamos las comisiones
                    $Comisiones = DB::table('ticc_sicas_comisiones_documento')->where("Documento", $FinP['attributes']['Documento'])->where("IDDoc",  $Id)->update([
                        "Documento" => $dta["Documento"]
                    ]);
                }

                if ($dta["IDVend"] != $FinP['attributes']['IDVend']) {
                    $Update = Honorarios::UpdateHonorarios(1, 'Cancelado', $Id, $dta["Documento"], $FinP['attributes']['IDVend']);
                }
                //Agrreamos la bitacora
                Bitacora::addBitacora($Id, $dta, 'F', $LoggedUser);

                if (isset($FindByDocto->TipoDocto)) {
                    if ($FindByDocto->TipoDocto > 0) {
                        $dta['IsSavedFianza'] = 1;
                    }
                }

                $addObject = Fianzas::where("IDDocto", $Id)->update($dta);
                $addObject = Fianzas::where("IDDocto", $Id)->first();
            } else {
                $dta["IsNew"] = 1;
                if (!isset($dta["Documento"])) {
                    $dta["Documento"] = $OT;
                }
                $addObject = Fianzas::create($dta);
                $dta["IDDocto"] = $addObject->IDTemp;
                if (isset($addObject->TipoDocto)) {
                    if ($addObject->TipoDocto > 0) {
                        $dta['isSavedPoliza'] = 1;
                    }
                }
                unset($dta['IDTemp']);
                $addObject = Fianzas::where("IDTemp", $dta["IDDocto"])->update($dta);
                $addObject = $dta;
                $addObject = Fianzas::where("IDDocto", $dta["IDDocto"])->first();
            }

            //$return = $addObject;

            $addObject = (object)$addObject;

            //var_dump($addObject);


            if ($addObject->TipoDocto == 1) {

                //$countH = DB::table('honorarios1')->where("IDDocto", $addObject->IDDocto)->get();
                $countH = DB::table('ticc_sicas_honorarios')->where("IDDocto", $addObject->IDDocto)->where('Status', 3)->where('documento', $addObject->Documento)->get();
                if (count($countH) == 0) {
                    $Continuo = 0;
                    //$listado = DB::select('CALL ConfiguracionHonorarios(?,?,?,?)', array($addObject->IDVend, $addObject->IDMon, $addObject->IDSSRamo, $addObject->IDDocto));
                    $Config = array(
                        "IDMon" => isset($addObject->IDMon) ? $addObject->IDMon : 0,
                        "IDVend" => isset($addObject->IDVend) ? $addObject->IDVend : 0,
                        "IDSubramo" => isset($addObject->IDSSRamo) ? $addObject->IDSSRamo : 0,
                        "IDSubgrupo" => isset($addObject->IDSubGrupo) ? $addObject->IDSubGrupo : 0,
                        "IDCliente" => isset($addObject->IDCli) ? $addObject->IDCli : 0,
                        "IDDocto" => isset($addObject->IDDocto) ? $addObject->IDDocto : 0,

                    );
                    //var_dump($Config);
                    //$listado = DB::select('CALL ConfiguracionHonorarios(?,?,?,?)', array($addObject->IDVend, $addObject->IDMon, $addObject->IDSSRamo, $addObject->IDDocto));
                    //$listado = Honorarios::CreateHonorariosv2($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'F');
                    $listado = Honorarios::CreateHonorariov3($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'F', ($addObject->CGastosMaquila + $addObject->ComDer));
                    //return $listado;
                    foreach ($listado as $key => $value) {
                        $Continuo++;
                        $valoresF = array(
                            "CBase" => $addObject->ComNeta,
                            "CRecargos" => $addObject->ComRec,
                            "CDerechos" => $addObject->CGastosMaquila
                        );
                        DB::table('ticc_sicas_honorarios')->insert([
                            'Id_vendedor' => $value->VendH,
                            'IDDocto' => $addObject->IDDocto,
                            //'Id_tipo_hon' => $value->Id_honorario,
                            'Id_tipo_hon' => $value->Id_tipo_hon,
                            'Id_tipo' => 1,
                            'Id_formula' => $value->Formula,
                            'participacion' => $value->Porcentaje,
                            'importe' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                            //'importe' => $this->CalculateHonorario($value, $addObject->ComNeta, $addObject->ComRec, $addObject->ComDer),
                            'documento' => $addObject->Documento,
                            'Folio' => 'H' . date('YmdHHssmm') . '' . $Continuo,
                            'Id_moneda_pago' => $addObject->IDMon,
                            'Id_moneda_docto' => $addObject->IDMon,
                            'Tipo_cambio_pago' => $addObject->TipoCambio,
                            'Tipo_cambio_docto' => $addObject->TipoCambio,
                            //'Base' => $value->Formula == 1 ? floatval($addObject->ComNeta) : floatval($addObject->ComNeta + $addObject->ComRec),
                            'Base' => Helpers::BaseFormulaHonorarios($value->Formula, $valoresF),
                            'Importe_pago' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                            'Neta' => $addObject->ComNeta,
                            'Recargo' => $addObject->ComRec,
                            'Derechos' => $addObject->ComDer,
                            'IDVendGen' => $addObject->IDVend,
                            'GtosMaq' => $addObject->CGastosMaquila,
                            'Status' => 3,
                            'Status_TXT' => 'Pendiente',
                            'Modulo' => 'F'
                        ]);
                    }
                }

                $counCom = DB::table('ticc_sicas_comisiones_documento')->where("Modulo", 'F')->where("Documento", $addObject->Documento)
                    ->where("Status", 3)
                    ->where("IDDoc", $addObject->IDDocto)->get();
                if (count($counCom) == 0) {
                    $Array = array(
                        "PComNeta" => isset($addObject->PComNeta) ? $addObject->PComNeta : 0,
                        "PComRec" => isset($addObject->PComRec) ? $addObject->PComRec : 0,
                        "PComDer" => isset($addObject->PComDer) ? $addObject->PComDer : 0,
                        "PCGastosMaquila" => isset($addObject->PCGastosMaquila) ? $addObject->PCGastosMaquila : 0,
                    );
                    $ComisionesAgte = Honorarios::ComisionesAgentes($Array, $addObject, 'F');
                }
            }
            $Data = $addObject;
            //return $this->JsonResponse(200, $addObject, $request, "exito");
            DB::commit(); //Fin trassaccion
        } catch (\Throwable $th) {
            $Code = 400;
            $Data = $th;
            $Message = "Error";
            DB::rollback();
        }
        return $this->JsonResponse($Code, $Data, $Message);
    }

    public function RenovarFianza(Request $request)
    {
        $Id = $request["Id"];
        $FindByIDDOCTO = DB::table('ticc_sicas_documentos')->where('IDDocto', $Id)->first();
        $Find = Fianzas::find($FindByIDDOCTO->IDTemp);
        $OT = "OT-" . date('YmdHsm');
        $docU = Fianzas::where('IDDocto', $Id)->update(["Status" => '1', "Status_TXT" => 'Renovada']);
        $SetDocumento = empty($Find->Documento) ? $Find->Solicitud : $Find->Documento;
        $IsPosterior = !empty($Find->DPosterior) ? $Find->DPosterior : $SetDocumento . '-' . ($Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1);
        //$NFind = $Find->replicate();
        $copy = $Find->replicate()->fill(
            [
                //'DAnterior' => $Find->DAnterior,
                'TipoDocto' => $Find->TipoDocto,
                'Status' => 1,
                'Status_TXT' => "Vigente",
                'IsNew' => 1,
                'IsSavedFianza' => 1,
                'NumRenovacion' => $Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1,
                'FDesde' => $Find->FHasta,
                'FHasta' => date("Y-m-d", strtotime('+1 year', strtotime($Find->FHasta))),
                //'IDDocto' => $copy->IDTemp,
                'PrimaNeta' => 0,
                'Descuento' => 0,
                'Derechos' => 0,
                'GastosMaquila' => 0,
                'GastosAdmin' => 0,
                'STotal' => 0,
                'IVA' => 0,
                //'Ajuste' => 0,
                'PrimaTotal' => 0,
                'ComNeta' => 0,
                'CGastosMaquila' => 0,
                'CGastosAdmin' => 0,
                'ComDer' => 0,
                'Especial' => 0,
                'Documento' => $IsPosterior
                //'Documento' => $Find->Documento . '-' . ($Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1)
            ]
        );

        unset($copy->DAnterior);
        unset($copy->DPosterior);
        $DOCC = $Find['attributes']['Documento'] != "" ? $Find['attributes']['Documento'] : $Find['attributes']['Solicitud'];
        $Explode = explode("-", $DOCC);
        $Find->DPosterior = $copy->Documento;
        $Find->save();
        //var_dump($copy);
        $copy->save();
        $copy->IsSavedFianza = null;
        $copy->DAnterior = $Find->Documento;
        $copy->Solicitud = $OT;
        $copy->IDDocto = $copy['attributes']['IDTemp'];
        $copy->save();
        //$addObject = $copy['attributes'];
        $addObject = Fianzas::find($copy->IDDocto);

        $Config = array(
            "IDMon" => isset($addObject->IDMon) ? $addObject->IDMon : 0,
            "IDVend" => isset($addObject->IDVend) ? $addObject->IDVend : 0,
            "IDSubramo" => isset($addObject->IDSSRamo) ? $addObject->IDSSRamo : 0,
            "IDSubgrupo" => isset($addObject->IDSubGrupo) ? $addObject->IDSubGrupo : 0,
            "IDCliente" => isset($addObject->IDCli) ? $addObject->IDCli : 0,
            "IDDocto" => isset($addObject->IDDocto) ? $addObject->IDDocto : 0,

        );
        //$listado = DB::select('CALL ConfiguracionHonorarios(?,?,?,?)', array($addObject->IDVend, $addObject->IDMon, $addObject->IDSSRamo, $addObject->IDDocto));
        //$listado = Honorarios::CreateHonorariosv2($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'F');
        /* $listado = Honorarios::CreateHonorariov3($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'F', ($addObject->ComRec + $addObject->ComDer));
        $Continuo = 0;
        //var_dump($listado);
        foreach ($listado as $key => $value) {
            $valoresF = array(
                "CBase" => $addObject->ComNeta,
                "CRecargos" => $addObject->ComRec,
                "CDerechos" => $addObject->ComDer
            );
            $Continuo++;
            DB::table('honorarios1')->insert([
                'Id_vendedor' => $value->VendH,
                'IDDocto' => $addObject->IDDocto,
                //'Id_tipo_hon' => $value->Id_honorario,#Id_tipo_hon
                'Id_tipo_hon' => $value->Id_tipo_hon,
                'Id_tipo' => 1,
                'Id_formula' => $value->Id_formula,
                'participacion' => $value->Porcentaje,
                //'importe' => $this->CalculateHonorario($value, $addObject->ComNeta, $addObject->ComRec),
                'importe' => Helpers::TotalFormulaHonorarios($value->Id_formula, $valoresF, $value->Porcentaje),
                'documento' => $addObject->Documento,
                'Folio' => 'H' . date('YmdHHssmm') . '' . $Continuo,
                'Id_moneda_pago' => $addObject->IDMon,
                'Id_moneda_docto' => $addObject->IDMon,
                'Tipo_cambio_pago' => $addObject->TipoCambio,
                'Tipo_cambio_docto' => $addObject->TipoCambio,
                'Base' => Helpers::BaseFormulaHonorarios($value->Formula, $valoresF),
                //'Base' => $value->Formula == 1 ? floatval($addObject->ComNeta) : floatval($addObject->ComNeta + $addObject->ComRec),
                //'Importe_pago' => $this->CalculateHonorario($value, $addObject->ComNeta, $addObject->ComRec),
                'importe' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                'Neta' => $addObject->ComNeta,
                'Recargo' => $addObject->ComRec,
                'IDVendGen' => $addObject->IDVend,
                'Status' => 3,
                'Status_TXT' => 'Pendiente',
                'Modulo' => 'F'
            ]);
        }

        $counCom = DB::table('ticc_sicas_comisiones_documento')->where("Modulo", 'F')->where("Documento", $addObject->Documento)
            ->where("Status", 3)
            ->where("IDDoc", $addObject->IDDocto)->get();
        if (count($counCom) == 0) {
            $Array = array(
                "PComNeta" => isset($addObject->PComNeta) ? $addObject->PComNeta : 0,
                "PComRec" => isset($addObject->PComRec) ? $addObject->PComRec : 0,
                "PComDer" => isset($addObject->PComDer) ? $addObject->PComDer : 0,
                "PCGastosMaquila" => isset($addObject->PCGastosMaquila) ? $addObject->PCGastosMaquila : 0,
            );
            $ComisionesAgte = Honorarios::ComisionesAgentes($Array, $addObject, 'F');
        } */


        return $this->JsonResponse(200, $addObject, $request, "exito");
    }

    public function DeleteFianza(Request $request)
    {
        $Id = $request["Id"];
        $addObject = Fianzas::where("IDTemp", $Id)->delete();
        return $this->JsonResponse(200, $addObject, $request, "exito");
    }


    public function DocFianzas(Request $request)
    {
        try {
            $Query = DB::table('ticc_sicas_documentos as a');
            $Query->selectRaw("a.IDDocto,a.Status,a.FDesde,a.FHasta,a.Solicitud,a.Documento,b.Nombre as Subramo, a.VendNombre as Vendedor");
            //$Query->leftjoin('sicas_subramo as b', 'a.IDSRamo', '=', 'b.Id');
            // $Query->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDTemp');
            $Query->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
            #$Query->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
            $Query->leftjoin('ticc_sicas_vendedores as d', 'a.IDVend', '=', 'd.IDVend');
            if ($request["search"] != '') {
                $isfiltered = true;
                $Query->where(function ($query) use ($request) {
                    $query->where('a.Solicitud', 'LIKE', '%' . $request["search"] . '%')
                        ->orWhere('b.Nombre', 'LIKE', '%' . $request["search"] . '%')
                        ->orWhere('a.Documento', 'LIKE', '%' . $request["search"] . '%')
                        //->orWhere('a.EstatusUsuario', 'LIKE', '%' . $request["search"] . '%')
                        ->orWhere('d.NombreCompleto', 'LIKE', '%' . $request["search"] . '%');
                });
            }
            //$Query->where('a.IsNew', 1);
            $Query->where('TipoDocto', 0);
            $Json = $Query->get();

            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FF34D614',
                    ],
                    'endColor' => [
                        'argb' => 'FF34D614',
                    ],
                ],
            ];
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:H1')->applyFromArray($styleArray);
            $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->setTitle('Registros');
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("A1", "IDDocto")
                ->setCellValue("B1", "Estatus")
                ->setCellValue("C1", "SubRamo")
                ->setCellValue("D1", "FDesde")
                ->setCellValue("E1", "FHasta")
                ->setCellValue("F1", "Solicitud")
                ->setCellValue("G1", "Documento")
                ->setCellValue("H1", "Vendedor");
            $start = 2;

            foreach ($Json as $key => $val) {
                //$styleC++;
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("A{$start}", $val->IDDocto);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("B{$start}", $val->Status);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$start}", $val->Subramo);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$start}", $val->FDesde);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$start}", $val->FHasta);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("F{$start}", $val->Solicitud);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("G{$start}", $val->Documento);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("H{$start}", $val->Vendedor);

                //$spreadsheet->setActiveSheetIndex(0)->getStyle("A{$start}:F{$start}")->applyFromArray($this->isPar($styleC) ? $stylePar : $styleImpar);
                $start++;
            }

            $spreadsheet->setActiveSheetIndex(0);
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(__DIR__ . "/RegistrosFianzas.xlsx");
            $headers = array(
                'Content-Type: application/xlsx',
            );

            return response()->download(__DIR__ . "/RegistrosFianzas.xlsx", "RegistrosFianzas.xlsx", $headers);
        } catch (\Throwable $th) {
            echo $th;
        }
    }


    #endregion

    //eliminamos losrecibos
    public function DeleteRecibos(Request $request)
    {
        $Id = $request["Id"];
        $addObject = Recibos::where("IDTemp", $Id)->delete();
        return $this->JsonResponse(200, $addObject, $request, "exito");
    }

    public function ConfigEspecial(Request $request)
    {
        $Producto = $request["Producto"];
        $TFianza = $request["TipoFianza"];
        $SubRamo = $request["SubRamo"];
        $AgenteCompania = $request["Agente"];

        $Find = Agente::find($AgenteCompania);
        $Compania = DB::table('ticc_sicas_companias as a')->where('CiaNombre', $Find->CiaNombre)->first();

        $resultado = ProductoFianza::GetComisiones($SubRamo, $Compania->IDCia, $Producto, $TFianza);
        $data = array(
            "Comisiones" => $resultado['Comisiones'],
            "Tarifa" => $resultado['Tarifa']
        );

        return $this->JsonResponse(200, $data, $request, "exito");
    }

    #region Endosos
    public function Endosos(Request $request)
    {
        //Total
        $Documento = $request["search"];

        $isfiltered = false;
        //$Query = DB::table('sicas_ot as a');
        $Query = DB::table('ticc_sicas_endosos as a');
        $Query->selectRaw("*");

        $Query->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
        $Query->leftjoin('ticc_sicas_documentos as x', 'a.IDDocto', '=', 'x.IDDocto');
        $Query->leftjoin('ticc_sicas_clientes as c', 'x.IDCli', '=', 'c.IDCli');
        $Query->leftjoin('ticc_sicas_vendedores as d', 'x.IDVend', '=', 'd.IDVend');
        //$Query->leftjoin('sicas_estatus_documento as f', 'a.IDEstatusUsuario', '=', 'f.Id');
        $Query->where('a.IsNew', 1);
        $Json = $Query->get();
        //Filterer
        $offset = $request["start"];
        $Query2 = DB::table('ticc_sicas_endosos as a');
        $Query2->leftjoin('ticc_sicas_catalog_subramos as b', 'a.IDSSRamo', '=', 'b.IDSRamo');
        $Query2->leftjoin('ticc_sicas_documentos as x', 'a.IDDocto', '=', 'x.IDDocto');
        $Query2->leftjoin('ticc_sicas_clientes as c', 'x.IDCli', '=', 'c.IDCli');
        $Query2->leftjoin('ticc_sicas_vendedores as d', 'x.IDVend', '=', 'd.IDVend');
        //$Query2->leftjoin('sicas_estatus_documento as f', 'a.IDEstatusUsuario', '=', 'f.Id');
        //Campo de busqueda
        if ($request["search"] != '') {
            $isfiltered = true;
            $Query2->where(function ($query) use ($request) {
                $query->where('a.Solicitud', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('b.Nombre', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('a.EstatusUsuario', 'LIKE', '%' . $request["search"] . '%')
                    ->orWhere('d.NombreCompleto', 'LIKE', '%' . $request["search"] . '%');
            });
        }

        //Set Offse
        if (isset($request["start"]))
            $Query2->skip($offset)->take(10);

        //$Query2->selectRaw("a.IDDocto,'ACTIVO' EstatusUsuario,b.Nombre Subramo, DATE_FORMAT(a.FDesde,'%Y-%d-%m') FDesde,DATE_FORMAT(a.FHasta,'%Y-%d-%m') FHasta, DATE_FORMAT(a.FCaptura,'%Y-%d-%m %H:%i') FCaptura,a.Solicitud,d.NombreCompleto as Vendedor, '' as Acciones, IF(a.Status=0, DATEDIFF(NOW(),a.FCaptura), DATEDIFF(a.FCaptura, a.FEmision)) as Dias");
        $Query2->selectRaw("a.IDDocto,'ACTIVO' EstatusUsuario,b.Nombre Subramo, DATE_FORMAT(a.FDesde,'%Y-%d-%m') FDesde,2 as Dias");
        $Query2->orderBy('IDDocto', 'DESC');
        $Query2->where('a.IsNew', 1);
        $Json2 = $Query2->get();
        return $this->JsonResponseTable(200, $Json, $Json2, $request, $isfiltered, "exito");
    }

    public function GetInitialendoso(Request $request)
    {
        $IdDoc = $request['IdDoc'];
        $Id = $request['IdRegistro'];
        $Modulo = $request['Tipo'];
        $Documento = array();
        $TiposDocumentos = array(
            array(
                "Id" => 0,
                "Nombre" => "Solicitud"
            ),
            array(
                "Id" => 1,
                "Nombre" => "Endoso"
            ),
        );
        $ComisionesA = array();
        // echo 'Polizas';
        if ($Modulo == 'P') {
            $Documento = Polizas::where('IDDocto', $IdDoc)->first();
            //echo 'Polizas';
            $Referencia = DB::table('ticc_sicas_documentos as a')
                ->selectRaw("a.*,c.NombreCompleto as Cliente,c.RFC, CONCAT('(',e.CAgente,') ', e.AgenteNombre) AgenteNombre,e.CiaNombre,f.Nombre as Ramo,g.Nombre as Grupo, h.Nombre as SubGrupo,i.Moneda,i.TipoCambio as TCambio")
                ->leftjoin('ticc_sicas_clientes as c', 'a.IDCli', '=', 'c.IDCli')
                ->leftjoin('ticc_sicas_vendedores as d', 'a.IDVend', '=', 'd.IDVend')
                ->leftjoin('ticc_sicas_agentes as e', 'a.IDAgente', '=', 'e.IDAgente')
                ->leftjoin('ticc_sicas_catalog_ramos as f', 'a.IDSRamo', '=', 'f.IDRamo')
                ->leftjoin('ticc_sicas_grupo as g', 'a.IDGrupo', '=', 'g.Id')
                ->leftjoin('ticc_sicas_subgrupo as h', 'a.IDSubGrupo', '=', 'h.Id')
                ->leftjoin('ticc_sicas_monedas as i', 'a.IDMon', '=', 'i.Id')
                ->where('a.IDDocto', $IdDoc)
                ->first();
        } else {
            $Documento = Fianzas::where('IDDocto', $IdDoc)->first();
            $Referencia = DB::table('ticc_sicas_documentos as a')
                ->selectRaw("a.*,c.NombreCompleto as Cliente,c.RFC, CONCAT('(',e.CAgente,') ', e.AgenteNombre) AgenteNombre,e.CiaNombre,f.Nombre as Ramo,g.Nombre as Grupo, h.Nombre as SubGrupo,i.Moneda,i.TipoCambio as TCambio")
                ->leftjoin('ticc_sicas_clientes as c', 'a.IDCli', '=', 'c.IDCli')
                ->leftjoin('ticc_sicas_vendedores as d', 'a.IDVend', '=', 'd.IDVend')
                ->leftjoin('ticc_sicas_agentes as e', 'a.IDAgente', '=', 'e.IDAgente')
                ->leftjoin('ticc_sicas_catalog_ramos as f', 'a.IDSRamo', '=', 'f.IDRamo')
                ->leftjoin('ticc_sicas_grupo as g', 'a.IDGrupo', '=', 'g.Id')
                ->leftjoin('ticc_sicas_subgrupo as h', 'a.IDSubGrupo', '=', 'h.Id')
                ->leftjoin('ticc_sicas_monedas as i', 'a.IDMon', '=', 'i.Id')
                ->where('a.IDDocto', $IdDoc)
                ->first();
        }
        //Anexasmos las comisiones
        $ComisionesA = array(
            "PComN" => $Referencia->PComNeta,
            "PComR" => $Referencia->PComRec,
            "PComD" => $Referencia->PComDer,
            "PComEsp" => $Referencia->PEspecial,
            "PCGastosMaquila" => isset($Referencia->PCGastosMaquila) ? $Referencia->PCGastosMaquila : 0,
            "PCGastosAdmin" => isset($Referencia->PCGastosAdmin) ? $Referencia->PCGastosAdmin : 0,
            "PorIVA" => isset($Referencia->PorIVA) ? $Referencia->PorIVA : 0,
            "PDerecho" => isset($Referencia->PDerecho) ? $Referencia->PDerecho : 0,
            "PorRecargos" => isset($Referencia->PorRecargos) ? $Referencia->PorRecargos : 0,
            "GastosMaquila" => isset($Referencia->GastosMaquila) ? $Referencia->GastosMaquila : 0,
        );
        //Total de recibos
        $TotalRecibos = DB::table('ticc_sicas_recibos as a')->where('IDDocto', $IdDoc)->where('Documento', $Documento->Documento)->where('Status', 5)->whereIn('IDEnd', array(-1, 0))->get();
        $EstatusCan = DB::table('ticc_sicas_catalog_cancelacion_polizas as a')->where('Cancelar', 1)->get();
        $MotivosCan = DB::table('ticc_sicas_catalog_cancelacion_motivos as a')->get();
        $Compania = DB::table('ticc_sicas_agentes as a')->selectRaw('b.*')->leftjoin('ticc_sicas_companias as b', 'a.CiaNombre', '=', 'b.CiaNombre')->where('a.IDAgente', $Documento->IDAgente)->first();
        $Json = array(
            "TipoDocumento" => $TiposDocumentos,
            "TipoEndoso" => DB::table('ticc_sicas_catalog_tipo_endoso as a')->get(['a.Id', 'a.Nombre', 'a.Tipo']),
            "Referencia" => $Referencia,
            "EstatusUsuario" => DB::table('ticc_sicas_estatus_usuario as a')->get(['a.Id', 'a.Nombre']),
            "TotalRecibos" => $TotalRecibos,
            "EstatusCancelacion" => $EstatusCan,
            "MotivosCancelacion" => $MotivosCan,
            "Comisiones" => $ComisionesA,
            "Compania" => $Compania

        );
        return $this->JsonResponse(200, $Json, $request, "exito");
    }

    public function SingleEndoso(Request $request)
    {
        $ID = $request["Id"];
        $IDDoc = $request["IdDoc"];
        $Modulo = $request["Modulo"];
        $Query = DB::table('ticc_sicas_endosos as a');
        $Query->selectRaw("a.*, '16' as PorIVA");
        $Query->leftjoin('ticc_sicas_documentos as b', function ($join) {
            $join->on('a.IDDocto', '=', 'b.IDDocto');
            $join->on('a.Documento', '=', 'b.Documento');
        });
        $Query->where('a.IDEnd', $ID)->where('a.IDDocto', $IDDoc);

        $Json = $Query->first();

        $Usuario = null;
        $flotillas = [];
        $Recibos = [];
        $Honorarios = [];
        $Comisiones = [];
        $InfoRecibos = [];

        $Documento = [];
        if ($Modulo == 'P') {
            $FindByDocto = DB::table('ticc_sicas_documentos')->where('IDDocto', $IDDoc)->first();
            $Documento = Polizas::Find($FindByDocto->IDTemp);
            //$Documento = Polizas::Find($IDDoc);
        } else {
            $FindByDocto = DB::table('ticc_sicas_documentos')->where('IDDocto', $IDDoc)->first();
            $Documento = Fianzas::Find($FindByDocto->IDTemp);
            //$Documento = Fianzas::Find($IDDoc);
        }
        //obtnemos el usuario

        if (empty($Usuario)) {
            $Usuario["Nombre"] = "";
            $Usuario["Id"] = "";
        }
        if ($Json != null) {
            $Recibos = Recibos::where('IDDocto', $IDDoc)->where('Documento', $Documento->Documento)->where('IDEnd', $ID)->where('Modulo', 'E')->orderBy('Periodo', 'ASC')->get();
            $InfoRecibos = DB::table($Modulo == "P" ? 'ticc_sicas_documentos as a' : 'ticc_sicas_documentos as a')
                ->selectRaw('b.EjecutNombre as Ejecutivo,c.NombreCompleto as Cliente, d.NombreCompleto as Vendedor, e.EjecutNombre as EjecutivoCobranza,f.Nombre as Ramo, g.AgenteNombre as Agente, g.CiaNombre, a.FPago as FormaPago')
                ->leftjoin('ticc_sicas_ejecutivos as b', 'a.IDEjecut', '=', 'b.IDEjecut')
                ->leftjoin('ticc_sicas_clientes as c', 'a.IDCli', '=', 'c.IDCli')
                ->leftjoin('ticc_sicas_vendedores as d', 'a.IDVend', '=', 'd.IDVend')
                ->leftjoin('ticc_sicas_ejecutivos as e', 'a.IDEjecutCobranza', '=', 'e.IDEjecut')
                ->leftjoin('ticc_sicas_catalog_ramos as f', 'a.IDSRamo', '=', 'f.IDRamo')
                ->leftjoin('ticc_sicas_agentes as g', 'a.IDAgente', '=', 'g.IDAgente')
                ->where('IDDocto', $IDDoc)
                ->first();

            $Config = array(
                "IDMon" => isset($Documento['attributes']['IDMon']) ? $Documento['attributes']['IDMon'] : 0,
                "IDVend" => isset($Documento['attributes']['IDVend']) ? $Documento['attributes']['IDVend'] : 0,
                "IDSubramo" => isset($Documento['attributes']['IDSSRamo']) ? $Documento['attributes']['IDSSRamo'] : 0,
                "IDSubgrupo" => isset($Documento['attributes']['IDSubGrupo']) ? $Documento['attributes']['IDSubGrupo'] : 0,
                "IDCliente" => isset($Documento['attributes']['IDCli']) ? $Documento['attributes']['IDCli'] : 0,
                "IDDocto" => isset($ID) ? $ID : 0,

            );
            $Honorarios = Honorarios::CreateHonorariosv2($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'E');
            //$Comisiones = DB::select('CALL GetListaComisiones(?,?,?)', array($Config['IDMon'], $Config['IDSubramo'], $Documento['attributes']['IDAgente']));
            //var_dump(array($ID, $Json->Documento, 'E'));
            $Comisiones = DB::select('CALL GetListaComisionesV2(?,?,?)', array($ID, $Json->Documento, 'E'));
        }
        $participacion = 0;
        /* foreach ($Honorarios as $key => $value) {
            $participacion = $participacion + isset($value->participacion) ? $value->participacion : 0;
        } */
        $GrupoHon = array();
        foreach ($Honorarios as $key => $value) {
            if (isset($value->Id_formula)) {
                $GrupoHon[$value->Id_formula] = (isset($GrupoHon[$value->Id_formula]) ? $GrupoHon[$value->Id_formula] : 0) + $value->participacion;
                if (isset($value->Id_formula)) {
                    if ($value->Id_formula == 1 || $value->Id_formula == 2) {
                        $participacion = $participacion + (isset($value->participacion) ? $value->participacion : 0);
                    }
                }
            }
        }

        $data = array(
            "OT" => $Json,
            "Recibos" => $Recibos,
            "InfoRecibos" => $InfoRecibos,
            "Honorarios" => $Honorarios,
            "Comisiones" => $Comisiones,
            "TotalHonorario" => $participacion,
            "TotalHonorariosGrupo" => $GrupoHon
        );
        return $this->JsonResponse(200, $data, $data, "exito");
    }


    public function SaveEndoso(Request $request)
    {
        $Code = 200;
        $Message = "Exito";
        $Data = [];
        try {
            DB::beginTransaction(); //Inicio de la transaccion
            $Id = $request["Id"];
            $IDDocto = $request["IDDocto"];
            $Modulo = $request["Modulo"];
            $dta = $request["data"];
            $LoggedUser = $request["User"];
            $LoggedUser = $request["User"];
            unset($dta['IDDocto']);

            $OT = "OT-" . date('YmdHsm');


            if (!array_key_exists('Solicitud', $dta)) {
                $dta["Solicitud"] = $OT;
                $dta["IsNew"] = 1;
                $dta["FSolicitud"] = date('Y-m-d');
            }
            if ($dta["Solicitud"] == '') {
                $dta["Solicitud"] = $OT;
            }

            if ($dta['TipoDocto'] == '1') {
                $dta['IsSaved'] = 1;
            }

            if (isset($dta['FConversion'])) {
                if ($dta['FConversion'] == '' || is_null($dta['FConversion'])) {
                    $dta['FConversion'] = date('Y-m-d');
                }
            } else {
                $dta['FConversion'] = date('Y-m-d');
            }

            if (isset($dta['FCaptura'])) {
                if ($dta['FCaptura'] == '' || is_null($dta['FCaptura'])) {
                    $dta['FCaptura'] = date('Y-m-d');
                }
            } else {
                $dta['FCaptura'] = date('Y-m-d');
            }

            if ($dta['TipoDocto'] == '1') {
                if (isset($dta['FEmision'])) {
                    if ($dta['FEmision'] == '' || is_null($dta['FEmision'])) {
                        $dta['FEmision'] = date('Y-m-d');
                    }
                } else {
                    $dta['FEmision'] = date('Y-m-d');
                }
            }

            //Llenamos la informacion restante
            $dta['IDDocto'] = $IDDocto;
            $Documento = [];
            if ($Modulo == 'P') {
                $FindByDocto = DB::table('ticc_sicas_documentos')->where('IDDocto', $IDDocto)->first();
                $Documento = Polizas::Find($FindByDocto->IDTemp);
                //$Documento = Polizas::Find($IDDoc);
            } else {
                $FindByDocto = DB::table('ticc_sicas_documentos')->where('IDDocto', $IDDocto)->first();
                $Documento = Fianzas::Find($FindByDocto->IDTemp);
                //$Documento = Fianzas::Find($IDDoc);
            }
            /* if ($Modulo == 'P') {
                $Documento = Polizas::Find($IDDocto);
            } else {
                $Documento = Fianzas::Find($IDDocto);
            } */
            $dta['Documento'] = $Documento['Documento'];
            $dta['IDAgente'] = $Documento['IDAgente'];

            $addObject = [];
            if ($Id > 0) {
                //echo 'update';
                unset($dta['IDTemp']);
                unset($dta['IDEnd']);
                unset($dta['IDDocto']);
                $dta["Modulo"] = $Modulo;

                //bitacora
                Bitacora::addBitacora($Id, $dta, 'E', $LoggedUser);

                //$dta["IDAgente"] = $Modulo;
                $addObject = Endoso::where("IDEnd", $Id)->update($dta);
                $addObject = Endoso::where("IDEnd", $Id)->first();
            } else {
                //echo 'crea';
                $dta["IsNew"] = 1;
                $addObject = Endoso::create($dta);
                $dta["IDEnd"] = $addObject->IDTemp;
                $dta["Modulo"] = $Modulo;
                unset($dta['IDTemp']);
                $addObject = Endoso::where("IDTemp", $dta["IDEnd"])->where('IDDocto', $IDDocto)->update($dta);
                //$addObject = $dta;
                $addObject = Endoso::where("IDEnd",   $dta["IDEnd"])->first();
            }

            //$return = $addObject;

            $addObject = (object)$addObject;
            //var_dump($addObject);

            if ($addObject->TipoDocto == 1) {

                $countH = DB::table('ticc_sicas_honorarios')->where("IDDocto", $addObject->IDEnd)->where('Documento', $addObject->Documento)->where('Modulo', 'E')->get();
                $Config = array(
                    "IDMon" => isset($Documento['attributes']['IDMon']) ? $Documento['attributes']['IDMon'] : 0,
                    "IDVend" => isset($Documento['attributes']['IDVend']) ? $Documento['attributes']['IDVend'] : 0,
                    "IDSubramo" => isset($Documento['attributes']['IDSSRamo']) ? $Documento['attributes']['IDSSRamo'] : 0,
                    "IDSubgrupo" => isset($Documento['attributes']['IDSubGrupo']) ? $Documento['attributes']['IDSubGrupo'] : 0,
                    "IDCliente" => isset($Documento['attributes']['IDCli']) ? $Documento['attributes']['IDCli'] : 0,
                    "IDDocto" => isset($addObject->IDEnd) ? $addObject->IDEnd : 0,

                );
                //var_dump($Config);
                if (count($countH) == 0) {
                    $Continuo = 0;
                    //return var_dump(($Modulo == "F" ? $addObject->CGastosMaquila : $addObject->ComR) + $addObject->ComDer );
                    $listado = Honorarios::CreateHonorariov3($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'E', (($Modulo == "F" ? $addObject->CGastosMaquila : $addObject->ComR) + $addObject->ComDer));
                    foreach ($listado as $key => $value) {
                        $Continuo++;
                        $valoresF = array(
                            "CBase" => $addObject->ComN,
                            "CRecargos" => $addObject->ComR,
                            "CDerechos" => $Modulo = "P" ? $addObject->ComD : $addObject->CGastosMaquila
                        );
                        DB::table('ticc_sicas_honorarios')->insert([
                            'Id_vendedor' => $value->VendH,
                            'IDDocto' => $addObject->IDEnd,
                            'Id_tipo_hon' => $value->Id_honorario,
                            'Id_tipo' => 1,
                            'Id_formula' => $value->Formula,
                            'participacion' => $value->Porcentaje,
                            'importe' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                            //'importe' => $this->CalculateHonorario($value, $addObject->ComN, $addObject->ComR),
                            'documento' => $addObject->Documento,
                            'Folio' => 'H' . date('YmdHHssmm') . '' . $Continuo,
                            'Id_moneda_pago' =>  $Documento['attributes']['IDMon'],
                            'Id_moneda_docto' =>  $Documento['attributes']['IDMon'],
                            'Tipo_cambio_pago' => $Documento['attributes']['TipoCambio'],
                            'Tipo_cambio_docto' =>  $Documento['attributes']['TipoCambio'],
                            //'Base' => $value->Formula == 1 ? floatval($addObject->ComN) : floatval($addObject->ComN + $addObject->ComR),
                            'Base' => Helpers::BaseFormulaHonorarios($value->Formula, $valoresF),
                            'Importe_pago' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                            //'Importe_pago' => $this->CalculateHonorario($value, $addObject->ComN, $addObject->ComR),
                            'Neta' => $addObject->ComN,
                            'Recargo' => $addObject->ComR,
                            'IDVendGen' => $Documento['attributes']['IDVend'],
                            //'GtosMaq' => $addObject->CGastosMaquila,
                            'Status' => 3,
                            'Status_TXT' => 'Pendiente',
                            'Modulo' => 'E'
                        ]);
                    }
                }
                //var_dump($addObject["attributes"]);
                $counCom = DB::table('ticc_sicas_comisiones_documento')->where("Modulo", 'E')->where("Documento", $addObject->Documento)
                    ->where("Status", 3)
                    ->where("IDDoc", $addObject["attributes"]["IDEnd"])->get();
                if (count($counCom) == 0) {
                    //var_dump("llega");
                    $Array = array(
                        "PComNeta" => isset($addObject->PComN) ? $addObject->PComN : 0,
                        "PComRec" => isset($addObject->PComR) ? $addObject->PComR : 0,
                        "PComDer" => isset($addObject->PComD) ? $addObject->PComD : 0,
                        "PCGastosMaquila" => isset($addObject->PCGastosMaquila) ? $addObject->PCGastosMaquila : 0,
                    );
                    $ComisionesAgte = Honorarios::ComisionesAgentes($Array, $addObject, 'E');
                }
            }
            $Data = $addObject;
            DB::commit(); //Fin trassaccion
        } catch (\Throwable $th) {
            $Code = 400;
            $Data = $th;
            $Message = "Error";
            DB::rollback();
        }
        return $this->JsonResponse($Code, $Data, $Message);
    }

    public function RenovarEndoso(Request $request)
    {
        $Id = $request["Id"];
        $Modulo = $request["Modulo"];
        $FindByIDDOCTO = DB::table('ticc_sicas_endosos')->where('IDDocto', $Id)->first();
        $Find = Endoso::find($FindByIDDOCTO->IDTemp);
        //$Find = Polizas::find($FindByIDDOCTO->IDTemp);


        $OT = "OT-" . date('YmdHsm');

        $Documento = [];
        if ($Modulo == 'P') {
            $Documento = Polizas::Find($Find->IDDocto);
        } else {
            $Documento = Fianzas::Find($Find->IDDocto);
        }
        $dta['Documento'] = $Documento['Documento'];

        $docU = Endoso::where('IDDocto', $Id)->update(["Status" => '1', "Status_TXT" => 'Renovada']);
        //$NFind = $Find->replicate();
        $copy = $Find->replicate()->fill(
            [
                //'DAnterior' => $Find->DAnterior,
                'TipoDocto' => $Find->TipoDocto,
                'Status' => 1,
                'Status_TXT' => "Vigente",
                'IsNew' => 1,
                'FDesde' => $Find->FHasta,
                'FHasta' => date("Y-m-d", strtotime('+1 year', strtotime($Find->FHasta))),
                //'NumRenovacion' => $Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1
                //'IDDocto' => $copy->IDTemp,
                'PrimaNeta' => 0,
                'Descuento' => 0,
                'Derechos' => 0,
                'GastosMaquila' => 0,
                'GastosAdmin' => 0,
                'STotal' => 0,
                'IVA' => 0,
                'Recargos' => 0,

                //'Ajuste' => 0,
                'PrimaTotal' => 0,
                'ComNeta' => 0,
                'CGastosMaquila' => 0,
                'CGastosAdmin' => 0,
                'ComD' => 0,
                'Especial' => 0,
                //Individual
                'RPrimaNeta' => 0,
                'RDescuento' => 0,
                'RDerechos' => 0,
                'RGastosMaquila' => 0,
                'RGatsosAdm' => 0,
                'RSubTotal' => 0,
                'RIVA' => 0,
                'RPrimaTotal' => 0,
                'RRecargos' => 0,


            ]
        );
        $copy->save();
        //$copy->IsSavedPoliza = null;
        $SetDocumento = empty($Find->Documento) ? $Find->Solicitud : $Find->Documento;
        $IsPosterior = !empty($Find->DPosterior) ? $Find->DPosterior : $SetDocumento . '-' . ($Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1);
        //$copy->Documento = $Find->Documento . '-';
        $copy->Documento = $IsPosterior;
        $copy->Solicitud = $OT;
        $copy->IDDocto = $copy['attributes']['IDTemp'];
        $copy->save();
        //$addObject = $copy['attributes'];
        //$addObject = $Documento['attributes'];
        $addObject = Endoso::find($copy->IDDocto);

        $Config = array(
            "IDMon" => isset($Documento->IDMon) ? $Documento->IDMon : 0,
            "IDVend" => isset($Documento->IDVend) ? $Documento->IDVend : 0,
            "IDSubramo" => isset($Documento->IDSSRamo) ? $Documento->IDSSRamo : 0,
            "IDSubgrupo" => isset($Documento->IDSubGrupo) ? $Documento->IDSubGrupo : 0,
            "IDCliente" => isset($Documento->IDCli) ? $Documento->IDCli : 0,
            "IDDocto" => isset($Documento->IDDocto) ? $Documento->IDDocto : 0,

        );
        //$listado = DB::select('CALL ConfiguracionHonorarios(?,?,?,?)', array($addObject->IDVend, $addObject->IDMon, $addObject->IDSSRamo, $addObject->IDDocto));
        //$listado = Honorarios::CreateHonorariosv2($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'E');
        //$listado = Honorarios::CreateHonorariov3($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'E', ($addObject->ComRec + $addObject->ComDer));
        /* $listado = Honorarios::CreateHonorariov3($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], 'E', ($addObject->ComRec + $addObject->ComDer));
        $Continuo = 0;
        foreach ($listado as $key => $value) {
            $valoresF = array(
                "CBase" => $addObject->ComNeta,
                "CRecargos" => $addObject->ComRec,
                "CDerechos" => $addObject->ComDer
            );
            $Continuo++;
            DB::table('honorarios1')->insert([
                'Id_vendedor' => $value->VendH,
                'IDDocto' => $addObject->IDDocto,
                'Id_tipo_hon' => $value->Id_honorario,
                'Id_tipo' => 1,
                'Id_formula' => $value->Formula,
                'participacion' => $value->Porcentaje,
                //'importe' => $this->CalculateHonorario($value, $addObject->ComNeta, $addObject->ComRec),
                'importe' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                'documento' => $addObject->Documento,
                'Folio' => 'H' . date('YmdHHssmm') . '' . $Continuo,
                'Id_moneda_pago' => $addObject->IDMon,
                'Id_moneda_docto' => $addObject->IDMon,
                'Tipo_cambio_pago' => $addObject->TipoCambio,
                'Tipo_cambio_docto' => $addObject->TipoCambio,
                'Base' => Helpers::BaseFormulaHonorarios($value->Formula, $valoresF),
                //'Base' => $value->Formula == 1 ? floatval($addObject->ComNeta) : floatval($addObject->ComNeta + $addObject->ComRec),
                //'Importe_pago' => $this->CalculateHonorario($value, $addObject->ComNeta, $addObject->ComRec),
                'importe' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                'Neta' => $addObject->ComNeta,
                'Recargo' => $addObject->ComRec,
                'IDVendGen' => $addObject->IDVend,
                'Status' => 3,
                'Status_TXT' => 'Pendiente',
                'Modulo' => 'E'
            ]);
        }

        $counCom = DB::table('ticc_sicas_comisiones_documento')->where("Modulo", 'E')->where("Documento", $addObject->Documento)
            ->where("Status", 3)
            ->where("IDDoc", $addObject["attributes"]["IDEnd"])->get();
        if (count($counCom) == 0) {
            //var_dump("llega");
            $Array = array(
                "PComNeta" => isset($addObject->PComN) ? $addObject->PComN : 0,
                "PComRec" => isset($addObject->PComR) ? $addObject->PComR : 0,
                "PComDer" => isset($addObject->PComD) ? $addObject->PComD : 0,
                "PCGastosMaquila" => isset($addObject->PCGastosMaquila) ? $addObject->PCGastosMaquila : 0,
            );
            $ComisionesAgte = Honorarios::ComisionesAgentes($Array, $addObject, 'E');
        } */


        return $this->JsonResponse(200, $addObject, $request, "exito");
    }

    public function DeleteEnsoso(Request $request)
    {
        $Id = $request["Id"];
        $addObject = Endoso::where("IDEnd", $Id)->delete();
        return $this->JsonResponse(200, $addObject, $request, "exito");
    }




    #endegion

    #region Acciones Documentos
    public function CancelarDocumento(Request $request)
    {
        $Id = $request['IDDocto'];
        $Documento = $request['Documento'];
        $Modulo = $request['Modulo'];
        $Info = $request['Data'];
        switch ($Modulo) {
            case 'P':
                //Se cancela el documento
                $Doc = Polizas::where('IDDocto', $Id)->where('Documento', $Documento)->update($Info);
                unset($Info['IDMotivo']);
                //Cancelamos los recibos
                $Recibos = Recibos::where('IDDocto', $Id)->where('Documento', $Documento)->where('IDEnd', -1)->orWhere('IDEnd', 0)->where('Modulo', $Modulo)->update(["Status" => 2, "Status_TXT" => "Cancelada"]);
                //Cancelamos los honorarios
                $Honorarios = DB::table('ticc_sicas_honorarios')->where('IDDocto', $Id)->where('documento', $Documento)->update($Info);
                //Cancelamos las comisiones
                $Comisiones = DB::table('ticc_sicas_comisiones_documento')->where('Modulo', $Modulo)->where('IDDoc', $Id)->where('Documento', $Documento)->update(["Status" => 2, "Status_TXT" => "Cancelada"]);

                break;
            case 'F':
                $Doc = Fianzas::where('IDDocto', $Id)->where('Documento', $Documento)->update($Info);
                unset($Info['IDMotivo']);
                //Cancelamos los recibos
                $Recibos = Recibos::where('IDDocto', $Id)->where('Documento', $Documento)->where('IDEnd', -1)->where('Modulo', $Modulo)->update($Info);
                //Cancelamos los honorarios
                $Honorarios = DB::table('ticc_sicas_honorarios')->where('IDDocto', $Id)->where('documento', $Documento)->update($Info);
                $Comisiones = DB::table('ticc_sicas_comisiones_documento')->where('Modulo', $Modulo)->where('IDDoc', $Id)->where('Documento', $Documento)->update(["Status" => 2, "Status_TXT" => "Cancelada"]);
                break;

            case 'E':
                $Doc = Endoso::where('Documento', $Documento)->where('IDEnd', $Id)->update($Info);
                unset($Info['IDMotivo']);
                //Cancelamos los recibos
                $Recibos = Recibos::where('Documento', $Documento)->where('IDEnd', $Id)->update($Info);
                //Cancelamos los honorarios
                $Honorarios =  DB::table('ticc_sicas_honorarios')->where('IDDocto', $Id)->where('Documento', $Documento)->where('IDEnd', -1)->where('Modulo', $Modulo)->update($Info);
                $Comisiones = DB::table('ticc_sicas_comisiones_documento')->where('Modulo', $Modulo)->where('IDDoc', $Id)->where('Documento', $Documento)->update(["Status" => 2, "Status_TXT" => "Cancelada"]);
                break;
            default:
                # code...
                break;
        }
        return $this->JsonResponse(200, [], $request, "exito");
    }

    public function RehabilitarDocumento(Request $request)
    {
        $Id = $request['IDDocto'];
        $Documento = $request['Documento'];
        $Modulo = $request['Modulo'];
        $Info = $request['Data'];
        $Recibos = $request['Recibos'];
        $Endosos = $request['Endosos'];

        $Code = 200;
        $Data = [];
        $Message = "Exito";

        try {
            DB::beginTransaction(); //Inicio de la transaccion
            switch ($Modulo) {
                case 'P':
                    //Se cancela el documento
                    $Doc = Polizas::where('IDDocto', $Id)->where('Documento', $Documento)->update([
                        "Status_TXT" => "Vigente",
                        "Status" => "1",
                    ]);
                    //Cancelamos los recibos del documento
                    if ($Recibos) {
                        $Recibos = Recibos::where('IDDocto', $Id)->where('Documento', $Documento)->where('IDEnd', -1)->where('Modulo', $Modulo)->update([
                            "Status_TXT" => "Pendiente"
                        ]);
                    }
                    //Habilitamos los endosos
                    if ($Endosos) {
                        $AllEndosos = DB::table('ticc_sicas_endosos as a')->where('IDDocto', $Id)->where('Documento', $Documento)->get();
                        foreach ($AllEndosos as $key => $Item) {
                            //Cambiar el estatado del documento
                            $updateEndosos = DB::table('ticc_sicas_endosos as a')->where('IDTemp', $Item->IDTemp)->update([
                                "Status_TXT" => "Pendiente",
                            ]);

                            $Honorarios = DB::table('ticc_sicas_honorarios')->where('IDDocto', $Item->IDEnd)->where('Status_TXT', 'Cancelada')->where('documento', $Item->Documento)->update([
                                "Status_TXT" => "Pendiente",
                                "Status" => 3
                            ]);
                            $Comisiones = DB::table('ticc_sicas_comisiones_documento')->where('Status_TXT', 'Cancelada')->where('IDDoc', $Item->IDEnd)->where('Documento', $Item->Documento)->update(["Status" => 3, "Status_TXT" => "Pendiente"]);

                            if ($Recibos) {
                                //Cambiar el estatado de los recibos
                                $RecibosEndosos = Recibos::where('IDDocto', $Id)->where('Documento', $Documento)->where('IDEnd', -1)->orWhere('IDEnd', 0)->update([
                                    "Status_TXT" => "Pendiente"
                                ]);
                            }
                        }
                    }

                    //Cancelamos los honorarios
                    $Honorarios = DB::table('ticc_sicas_honorarios')->where('IDDocto', $Id)->where('documento', $Documento)->update([
                        "Status_TXT" => "Pendiente",
                        "Status" => 3
                    ]);
                    //Cancelamos las comisiones
                    $Comisiones = DB::table('ticc_sicas_comisiones_documento')->where('Modulo', $Modulo)->where('IDDoc', $Id)->where('Documento', $Documento)->update(["Status" => 3, "Status_TXT" => "Pendiente"]);

                    break;
                case 'F':
                    $Doc = Fianzas::where('IDDocto', $Id)->where('Documento', $Documento)->update([
                        "Status_TXT" => "Vigente",
                        "Status" => "1",
                    ]);
                    if ($Recibos) {
                        $Recibos = Recibos::where('IDDocto', $Id)->where('Documento', $Documento)->where('IDEnd', -1)->where('Modulo', $Modulo)->update([
                            "Status_TXT" => "Pendiente"
                        ]);
                    }
                    //Habilitamos los endosos
                    //Habilitamos los endosos
                    if ($Endosos) {
                        $AllEndosos = DB::table('ticc_sicas_endosos as a')->where('IDDocto', $Id)->where('Documento', $Documento)->get();
                        foreach ($AllEndosos as $key => $Item) {
                            //Cambiar el estatado del documento
                            $updateEndosos = DB::table('ticc_sicas_endosos as a')->where('IDTemp', $Item->IDTemp)->update([
                                "Status_TXT" => "Pendiente",
                            ]);

                            $Honorarios = DB::table('ticc_sicas_honorarios')->where('IDDocto', $Item->IDEnd)->where('documento', $Item->Documento)->update([
                                "Status_TXT" => "Pendiente",
                                "Status" => 3
                            ]);
                            $Comisiones = DB::table('ticc_sicas_comisiones_documento')->where('IDDocto', $Item->IDEnd)->where('Documento', $Item->Documento)->update(["Status" => 3, "Status_TXT" => "Pendiente"]);

                            if ($Recibos) {
                                //Cambiar el estatado de los recibos
                                $RecibosEndosos = Recibos::where('IDDocto', $Id)->where('Documento', $Documento)->where('IDEnd', -1)->orWhere('IDEnd', 0)->update([
                                    "Status_TXT" => "Pendiente"
                                ]);
                            }
                        }
                    }

                    //Cancelamos los honorarios
                    $Honorarios = DB::table('ticc_sicas_honorarios')->where('IDDocto', $Id)->where('documento', $Documento)->update([
                        "Status_TXT" => "Pendiente",
                        "Status" => 3
                    ]);
                    //Cancelamos las comisiones
                    $Comisiones = DB::table('ticc_sicas_comisiones_documento')->where('Modulo', $Modulo)->where('IDDoc', $Id)->where('Documento', $Documento)->update(["Status" => 3, "Status_TXT" => "Pendiente"]);

                    break;

                case 'E':
                    break;
                default:
                    # code...
                    break;
            }
            DB::commit(); //Fin trassaccion
        } catch (\Throwable $th) {
            $Code = 400;
            $Data = $th;
            $Message = "Error";
            DB::rollback();
        }
        return $this->JsonResponse($Code, $Data, $Message);
    }


    public function CopiarDocumento(Request $request)
    {
        $Id = $request['IDDocto'];
        $Documento = $request['Documento'];
        $Modulo = $request['Modulo'];
        $ObjectCopy = [];
        $OT = "OT-" . date('YmdHsm');
        switch ($Modulo) {
            case 'P':
                $FindByDocto = DB::table('ticc_sicas_documentos')->where('IDDocto', $Id)->first();
                $Find = Polizas::find($FindByDocto->IDTemp);
                $SetDocumento = empty($Find->Documento) ? $Find->Solicitud : $Find->Documento;
                $IsPosterior = !empty($Find->DPosterior) ? $Find->DPosterior : $SetDocumento . '-' . ($Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1);
                //$Find = Polizas::find($Id);
                //$NFind = $Find->replicate();
                $copy = $Find->replicate()->fill(
                    [
                        //'Documento' => $OT,
                        'Documento' => $IsPosterior,
                        'Solicitud' => $OT,
                        //'DAnterior' => $Find->DAnterior,
                        'DAnterior' => $Find->Documento,
                        'TipoDocto' => 0,
                        'Status' => 0,
                        'Status_TXT' => null,
                        //'DPosterior' => $Find->DAnterior,
                        //'IDDocto' => $copy->IDTemp,
                    ]
                );
                $copy->save();
                $copy->IsSavedPoliza = null;
                $copy->Documento = $OT;
                $copy->Solicitud = $OT;
                $copy->IDDocto = $copy['attributes']['IDTemp'];
                $copy->save();
                $ObjectCopy = $copy['attributes'];
                Polizas::where('IDTemp', $Id)->update(array("DPosterior" => $IsPosterior));
                //var_dump($copy);


                # code...
                break;
            case 'F':
                $Find = Fianzas::find($Id);
                $SetDocumento = empty($Find->Documento) ? $Find->Solicitud : $Find->Documento;
                $IsPosterior = !empty($Find->DPosterior) ? $Find->DPosterior : $SetDocumento . '-' . ($Find->NumRenovacion > 0 ? $Find->NumRenovacion + 1 : 1);
                //$NFind = $Find->replicate();
                $copy = $Find->replicate()->fill(
                    [
                        //'Documento' => $OT,
                        'Documento' => $IsPosterior,
                        'Solicitud' => $OT,
                        //'DAnterior' => $Find->DAnterior,
                        'DAnterior' => $Find->Documento,
                        'TipoDocto' => 0,
                        'Status' => 0,
                        'Status_TXT' => null,
                        //'IDDocto' => $copy->IDTemp,
                    ]
                );
                $copy->save();
                $copy->IsSavedFianza = null;
                $copy->Documento = $OT;
                $copy->Solicitud = $OT;
                $copy->IDDocto = $copy['attributes']['IDTemp'];
                $copy->save();
                $ObjectCopy = $copy['attributes'];
                ///actualizamos el psterior
                Fianzas::where('IDTemp', $Id)->update(array("DPosterior" => $IsPosterior));
                # code...
                break;
            case 'E':
                $Find = Endoso::find($Id);
                //$NFind = $Find->replicate();
                $copy = $Find->replicate()->fill(
                    [
                        'Documento' => $OT,
                        'Solicitud' => $OT,
                        //'DAnterior' => $Find->DAnterior,
                        'TipoDocto' => 0,
                        'Status' => 0,
                        'Status_TXT' => null,
                        //'IDDocto' => $copy->IDTemp,
                    ]
                );
                $copy->save();
                $copy->IsSaved = null;
                $copy->Documento = $OT;
                $copy->Solicitud = $OT;
                $copy->IDDocto = $copy['attributes']['IDTemp'];
                $copy->save();
                $ObjectCopy = $copy['attributes'];
                break;

            default:
                # code...
                break;
        }
        return $this->JsonResponse(200, $ObjectCopy, $request, "exito");
    }

    public function FindDocumento(Request $request)
    {
        $Modulo = $request['Modulo'];
        $Find = $request['Busqueda'];
        $ModuloPadre = $request['ModuloPadre'];
        $Tabla = "";
        switch ($Modulo) {
            case 'P':
                $Tabla = "ticc_sicas_documentos as a";
                break;
            case 'F':
                $Tabla = "ticc_sicas_documentos as a";
                break;
            case 'E':
                $Tabla = "ticc_sicas_endosos as a";
                break;
        }
        $Query = DB::table($Tabla);
        $QueryCount = DB::table($Tabla);

        $QueryCount->selectRaw('count(*) as Id');

        if ($Modulo != "E") {
            $Query->selectRaw("a.FDesde,a.FHasta,a.IDDocto,a.Solicitud,a.Documento,a.Status_TXT,a.NombreCompleto as Cliente");
            //$Query->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
            //$QueryCount->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
        } else {
            $Query->selectRaw('a.FDesde,a.FHasta,a.IDDocto,a.Solicitud,a.Documento,a.IDEnd,a.Status_TXT,b.NombreCompleto as Cliente');
            //$Query->selectRaw("a.*,case when Modulo ='P' THEN (select c.NombreCompleto from polizas p inner join clientes c on p.IDCli=c.IDCli where p.Documento=a.Documento and p.IDDocto=a.IDDocto ) when Modulo ='F' THEN (select c.NombreCompleto from fianzas p inner join clientes c on p.IDCli=c.IDCli where p.Documento=a.Documento and p.IDDocto=a.IDDocto ) end as Cliente");
            //$Query->leftjoin('clientes as c', 'a.IDCli', '=', 'c.IDCli');
        }
        if ($Find != '') {
            if ($Modulo == "E") {
                $Query->where(function ($query) use ($Find) {
                    $query->where('a.Documento', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Solicitud', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Endoso', 'LIKE', '%' . $Find . '%');
                    /*                         //->orWhere('c.NombreCompleto', 'LIKE', '%' . $Find . '%')
                        ->orWhere(DB::raw('case 
                            when Modulo ="P" THEN (select c.NombreCompleto from polizas p inner join clientes c on p.IDCli=c.IDCli where p.Documento=a.Documento and p.IDDocto=a.IDDocto )
                            when Modulo ="F" THEN (select c.NombreCompleto from fianzas p inner join clientes c on p.IDCli=c.IDCli where p.Documento=a.Documento and p.IDDocto=a.IDDocto )
                            end ' . 'LIKE' . "'%" . $Find . "%'")); */
                });
                $QueryCount->where(function ($query) use ($Find) {
                    $query->where('a.Documento', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Solicitud', 'LIKE', '%' . $Find . '%');
                    //->orWhere('c.NombreCompleto', 'LIKE', '%' . $Find . '%')
                    /* ->orWhere(DB::raw('case 
                            when Modulo ="P" THEN (select c.NombreCompleto from polizas p inner join clientes c on p.IDCli=c.IDCli where p.Documento=a.Documento and p.IDDocto=a.IDDocto )
                            when Modulo ="F" THEN (select c.NombreCompleto from fianzas p inner join clientes c on p.IDCli=c.IDCli where p.Documento=a.Documento and p.IDDocto=a.IDDocto )
                           end ' . 'LIKE' . "'%" . $Find . "%'")); */
                });
            } else {
                $Query->where(function ($query) use ($Find) {
                    $query->where('a.Documento', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Solicitud', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.NombreCompleto', 'LIKE', '%' . $Find . '%');
                });
                $QueryCount->where(function ($query) use ($Find) {
                    $query->where('a.Documento', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.Solicitud', 'LIKE', '%' . $Find . '%')
                        ->orWhere('a.NombreCompleto', 'LIKE', '%' . $Find . '%');
                });
            }
            //$Query->where('Documento', 'like', '%' . $Find . '%');
            //$QueryCount->where('Solicitud', 'like', '%' . $Find . '%');
        }
        if ($Modulo == "E") {
            if ($ModuloPadre == "P") {
                $Query->join('ticc_sicas_documentos as b', "a.IDDocto", "=", "b.IDDocto");
                $QueryCount->join('ticc_sicas_documentos as b', "a.IDDocto", "=", "b.IDDocto");
            } else {
                $Query->join('ticc_sicas_documentos as b', "a.IDDocto", "=", "b.IDDocto");
                $QueryCount->join('ticc_sicas_documentos as b', "a.IDDocto", "=", "b.IDDocto");
            }
        }
        //$Query->where('IsNew', 1);
        //$QueryCount->where('IsNew', 1);

        $field = "a.IDDocto";
        $order = "DESC";

        $count = $QueryCount->first();
        //$count = $QueryCount->get();
        //$count = $QueryCount->toSql();
        $Query->skip($request["Offset"])->take(10);
        $Query->orderBy($field, $order);
        $res = $Query->get();
        //$res = $Query->toSql();
        /*  return array(
            "q1"=>$count,
            "q2"=>$res
        ); */
        return $this->JsonResponsev2(200, $res, "exito", $count);
    }

    public function FindEndoso(Request $request)
    {
        $Find = $request['Busqueda'];
        $IDDocto = $request['IDDocto'];
        $Modulo = $request['Modulo'];
        $Documento = $request['Documento'];
        $Tabla = "ticc_sicas_endosos as a";
        $Query = DB::table($Tabla);
        $QueryCount = DB::table($Tabla);
        $FindDoc = [];

        $QueryCount->selectRaw('count(*) as Id');
        $Query->selectRaw('a.FDesde,a.FHasta,a.IDDocto,a.Solicitud,a.Documento,a.Endoso,a.IDEnd,a.Status_TXT,"" as Cliente');

        //query de busqueda
        if ($Find != "") {
            $Query->where(function ($query) use ($Find) {
                //->where('a.Documento', 'LIKE', '%' . $Find . '%')
                $query->Where('a.Solicitud', 'LIKE', '%' . $Find . '%')
                    ->orWhere('a.Endoso', 'LIKE', '%' . $Find . '%');;
            });
            $QueryCount->where(function ($query) use ($Find) {
                //->where('a.Documento', 'LIKE', '%' . $Find . '%')
                $query->Where('a.Solicitud', 'LIKE', '%' . $Find . '%')
                    ->orWhere('a.Endoso', 'LIKE', '%' . $Find . '%');
            });
        }

        //asignamos l padre
        $Query->where('IDDocto', $IDDocto)->where('Documento', $Documento);
        $QueryCount->where('IDDocto', $IDDocto)->where('Documento', $Documento);

        /* if($Modulo=="P"){
            $FindDoc=Polizas::where('IDDocto', $IDDocto)->first();
        }else{
            $FindDoc=Fianzas::where('IDDocto', $IDDocto)->first();
        } */

        $field = "a.FDesde";
        $order = "DESC";


        $count = $QueryCount->first();
        $Query->skip($request["Offset"])->take(10);
        $Query->orderBy($field, $order);
        $res = $Query->get();
        return $this->JsonResponsev2(200, $res, "exito", $count);
    }

    public function ReloadHonorarios(Request $request)
    {
        $Code = 200;
        $Message = "Exito";
        $Data = [];
        try {
            DB::beginTransaction(); //Inicio de la transaccion
            $Id = $request["Id"]; //Id del documento
            $Modulo = $request["Modulo"];
            $addObject = array();
            $Continuo = 0;
            $Endoso = array();

            switch ($Modulo) {
                case 'P':
                    $addObject = Polizas::where("IDDocto", $Id)->first();
                    break;
                case 'F':
                    $addObject = Fianzas::where("IDDocto", $Id)->first();
                    break;
                case 'E':
                    $Endoso = Endoso::where("IDEnd", $Id)->first();
                    $addObject = $request["SubModulo"] == "P" ? Polizas::where("IDDocto", $request["SubId"])->first() : Fianzas::where("IDDocto", $request["SubId"])->first();
                    break;
            }

            //Info del armado
            $Config = array(
                "IDMon" => isset($addObject->IDMon) ? $addObject->IDMon : 0,
                "IDVend" => isset($addObject->IDVend) ? $addObject->IDVend : 0,
                "IDSubramo" => isset($addObject->IDSSRamo) ? $addObject->IDSSRamo : 0,
                "IDSubgrupo" => isset($addObject->IDSubGrupo) ? $addObject->IDSubGrupo : 0,
                "IDCliente" => isset($addObject->IDCli) ? $addObject->IDCli : 0,
                //"IDDocto" => $Modulo == "E" ? $addObject->IDEnd : isset($addObject->IDDocto) ? $addObject->IDDocto : 0,
            );
            if ($Modulo == "E") {
                $Config["IDDocto"] = $Endoso->IDEnd;
            } else {
                $Config["IDDocto"] = isset($addObject->IDDocto) ? $addObject->IDDocto : 0;
            }

            //Cancelamos los honorarios
            $FindH = DB::table('ticc_sicas_honorarios')->where('IDDocto', $Id)->where('Status', 3)->where('Status_TXT', 'Pendiente')->where('Modulo', $Modulo)
                ->update(["Status" => 2, "Status_TXT" => "Cancelada"]);


            //llamamos los nuevos
            $valoresF = array();
            $Maquila = 0;
            $Derechos = 0;
            if ($Modulo == "F") {
                $Maquila = $addObject->CGastosMaquila;
                $Derechos = $addObject->ComDer;
            } elseif ($Modulo == "E") {
                $Maquila = $Endoso["attributes"]["CGastosMaquila"];
                $Derechos = $Endoso["attributes"]["ComD"];
            } else {
                $Maquila = $addObject->ComRec;
                $Derechos = $addObject->ComDer;
            }



            $listado = Honorarios::CreateHonorariov3($Config['IDMon'], $Config['IDVend'], $Config['IDSubramo'],  $Config['IDSubgrupo'], $Config['IDCliente'], $Config['IDDocto'], $Modulo, ($Maquila + $Derechos));
            foreach ($listado as $key => $value) {
                if ($Modulo != "E") {
                    $valoresF = array(
                        "CBase" => $addObject->ComNeta,
                        "CRecargos" => $addObject->ComRec,
                        "CDerechos" => $Modulo == "F" ? $addObject->CGastosMaquila : $addObject->ComDer
                    );
                } else {
                    $valoresF = array(
                        "CBase" => $Endoso["attributes"]["ComN"], //ComN
                        "CRecargos" => $Endoso["attributes"]["ComR"], //ComR
                        "CDerechos" => $request["SubModulo"] == "F" || $request["SubModulo"] == "E" ? $Endoso["attributes"]["CGastosMaquila"] : $Endoso["attributes"]["ComD"]
                    );
                }

                //return $valoresF;
                $Continuo++;
                DB::table('ticc_sicas_honorarios')->insert([
                    'Id_vendedor' => $value->VendH,
                    'IDDocto' => $Modulo == "E" ? $Endoso->IDEnd : $addObject->IDDocto,
                    'Id_tipo_hon' => $value->Id_honorario,
                    'Id_tipo' => 1,
                    'Id_formula' => $value->Formula,
                    'participacion' => $value->Porcentaje,
                    'importe' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                    'documento' => $addObject->Documento,
                    'Folio' => 'H' . date('YmdHHssmm') . '' . $Continuo,
                    'Id_moneda_pago' => $addObject->IDMon,
                    'Id_moneda_docto' => $addObject->IDMon,
                    'Tipo_cambio_pago' => $addObject->TipoCambio,
                    'Tipo_cambio_docto' => $addObject->TipoCambio,
                    'Base' => Helpers::BaseFormulaHonorarios($value->Formula, $valoresF),
                    'Importe_pago' => Helpers::TotalFormulaHonorarios($value->Formula, $valoresF, $value->Porcentaje),
                    'Neta' => $addObject->ComNeta,
                    'Recargo' => $addObject->ComRec,
                    'IDVendGen' => $addObject->IDVend,
                    'Status' => 3,
                    'Status_TXT' => 'Pendiente',
                    'Modulo' => $Modulo
                ]);
            }


            ///Metemos las comisiones
            $FindH = DB::table('ticc_sicas_comisiones_documento')->where('IDDoc', $Id)->where('Status', 3)->where('Status_TXT', 'Pendiente')->where('Modulo', $Modulo)
                ->update(["Status" => 2, "Status_TXT" => "Cancelada"]);
            $Array = array(
                "PComNeta" => isset($addObject->PComNeta) ? $addObject->PComNeta : 0,
                "PComRec" => isset($addObject->PComRec) ? $addObject->PComRec : 0,
                "PComDer" => isset($addObject->PComDer) ? $addObject->PComDer : 0,
                "PCGastosMaquila" => isset($addObject->PCGastosMaquila) ? $addObject->PCGastosMaquila : 0,
            );
            $Documento = $Modulo == "E" ? $Endoso["attributes"] : $addObject;
            $ComisionesAgte = Honorarios::ComisionesAgentes($Array, (object)$Documento, $Modulo);

            DB::commit(); //Fin trassaccion
        } catch (\Throwable $th) {
            $Code = 400;
            $Data = $th;
            $Message = "Error";
            DB::rollback();
        }

        return $this->JsonResponse($Code, $Data, $Message);
    }

    //Metodos del control de usuarios
    public function InitialUsers(Request $request)
    {
        $Code = 200;
        $Message = "Exito";
        $Data = [];

        $response = array(
            "Entidad" => DB::table('ticc_sicas_clientes')->select('TipoEnt_TXT')->distinct('TipoEnt_TXT')->whereNotNull('TipoEnt_TXT')->get(),
            "Sexo" => DB::table('ticc_sicas_clientes')->select('Sexo_TXT')->distinct('Sexo_TXT')->whereNotNull('Sexo_TXT')->get(),
            "Grupo" => Grupo::get(),
            "SubGrupo" => SubGrupo::join('ticc_sicas_grupo as b', "ticc_sicas_subgrupo.IdGrupo", "=", "b.Id")->get(['ticc_sicas_subgrupo.Id', 'ticc_sicas_subgrupo.Nombre', 'b.Nombre as IdPadre']),
            "Ejecutivos" => DB::table('ticc_sicas_ejecutivos as a')->get(['IDEjecut as Id', 'EjecutNombre as Nombre']),
            "TipoDireccion" => DB::table('ticc_sicas_direcciones')->select('TipoDir')->distinct('TipoDir')->whereNotNull('TipoDir')->get()
        );

        return $this->JsonResponse($Code, $response, $Message);
    }

    public function GetRowCliente(Request $request)
    {
        $Code = 200;
        $Message = "Exito";
        $Data = [];
        $Id = $request["Id"];

        $response = array(
            "Cliente" => DB::table('ticc_sicas_clientes')->where('IDCli', $Id)->first(),
            "Direcciones" => DB::table('ticc_sicas_direcciones')->where('IDCli', $Id)->get(),
        );

        return $this->JsonResponse($Code, $response, $Message);
    }

    public function SaveClient(Request $request)
    {
        $dta = $request["data"];
        $Code = 200;
        $Message = "Exito";
        $Data = [];

        if ($dta != null) {
            if (isset($dta['IDTemp'])) {
                $Id = $dta['IDTemp'];
                unset($dta['IDTemp']);
                $Data = DB::table('ticc_sicas_clientes')->where("IDTemp", $Id)->update($dta);
                $Data = DB::table('ticc_sicas_clientes')->where("IDTemp", $Id)->first();
            } else {
                $ArrComplete = [];
                if ($dta['TipoEnt_TXT'] == 'Fisica') {
                    if (isset($dta['Nombre'])) {
                        if (!empty($dta['Nombre'])) {
                            $ArrComplete[] = $dta['Nombre'];
                        }
                    }
                    if (isset($dta['ApellidoP'])) {
                        if (!empty($dta['ApellidoP'])) {
                            $ArrComplete[] = $dta['ApellidoP'];
                        }
                    }
                    if (isset($dta['ApellidoM'])) {
                        if (!empty($dta['ApellidoM'])) {
                            $ArrComplete[] = $dta['ApellidoM'];
                        }
                    }

                    if (count($ArrComplete) > 0) {
                        $dta['NombreCompleto'] = implode(' ', $ArrComplete);
                    }
                }
                $DataID = DB::table('ticc_sicas_clientes')->insertGetId($dta);
                $dta["IDCli"] = $DataID;
                unset($dta['IDTemp']);
                $Data = DB::table('ticc_sicas_clientes')->where("IDTemp", $dta["IDCli"])->update($dta);
                //$data['IDTemp']=$DataID;
                $Data = $Data = DB::table('ticc_sicas_clientes')->where("IDCli", $DataID)->first();
            }
        }

        return $this->JsonResponse($Code, $Data, $Message);
    }


    public function SaveDirClient(Request $request)
    {
        $dta = $request["data"];
        $Cliente = $request["Cliente"];
        $Code = 200;
        $Message = "Exito";
        $Data = [];

        if ($dta != null) {
            if (isset($dta['IDTemp'])) {
                $Id = $dta['IDTemp'];
                unset($dta['IDTemp']);
                $dta['IDCli'] = $Cliente;
                $Data = DB::table('ticc_sicas_direcciones')->where("IDTemp", $Id)->update($dta);
                $Data = DB::table('ticc_sicas_direcciones')->where("IDTemp", $Id)->first();
            } else {
                $DataID = DB::table('ticc_sicas_direcciones')->insertGetId($dta);
                //var_dump($Data);
                $dta["IDDir"] = $DataID;
                $dta['IDCli'] = $Cliente;
                unset($dta['IDTemp']);
                $Data = DB::table('ticc_sicas_direcciones')->where("IDTemp", $DataID)->update($dta);
                //$data['IDTemp']=$DataID;
                $Data = $Data = DB::table('ticc_sicas_direcciones')->where("IDCli", $Cliente)->get();
            }
        }

        return $this->JsonResponse($Code, $Data, $Message);
    }


    #region Pruebas.
    public function PruebasHon(Request $request)
    {
        /* $Array1=array(
            "SubRamos"=>array("Id"=>12,"Id"=>10)
        );

        $Array2=array(
            "SubRamos"=>array("Id"=>12,"Id"=>11)
        );
        var_dump($Array1["SubRamos"]); */

        //$test = Bitacora::GetConfigHon(1, "Miguel", 2);


        //Bitacora::BitacoraConfHon($Array1,$Array2);
        return $this->JsonResponse(200, [], "exito");
    }

    public function OthersMethod(Request $request)
    {
        //echo ':v';
        //$Init=CargaInicial::LoadSubramos();
        //$Init=CargaInicial::LoadAllDocs();
        //$Init = CargaInicial::LoadAllDocsP();
        //$Init = CargaInicial::LoadAllDocs();
        //$Init = CargaInicial::LoadDocs2025();
        //$Init=CargaInicial::LoadFianzaDocs2025();
        //$Init=CargaInicial::UpdateHonorarios();
        //$Init=CargaInicial::UpdateVendedores2025();
        $Init = CargaInicial::UpdateClientes2025();
        //$Init = CargaInicial::ComisionesFianzasCompania();
        //$Init = CargaInicial::UpdatePolizasExcel();
        //$Init = CargaInicial::updateFianzaExcel();
        //$Init = CargaInicial::LoadHonorariosFianzas();
        //$Init=CargaInicial::LoadHonorarios();
        //$Init=CargaInicial::ConvertDate("13/07/2020");
        //var_dump($Init);
        //$Init = CargaInicial::UpdateVend();
        return  $this->JsonResponse(200, $Init, "exito");
        //
        //$Init = CargaInicial::Updatepolizas();
        //$Init=CargaInicial::UpdateVendedores();
    }

    public function test()
    {
        $Data = DB::table('documentos_sicasv5')->limit(1000)->get();
        return $this->JsonResponse(200, $Data, "Exito");
    }

    public function ConvertXML()
    {
        $arrayPruebas = DB::table('ticc_sicas_documentos')->limit(1000)->get();
        $test = array();
        foreach ($arrayPruebas as $key => $value) {
            $test[] = (array)$value;
        }
        //$Xml=Helpers::arrayToXML($arrayPruebas,new SimpleXMLElement('<root/>'), 'child_name_to_replace_numeric_integers');

        $Xml = Helpers::array2xml($test, null);
        return $this->JsonResponse(200, $Xml, "Exito");
    }
    #endregion

    #endregion


}
