<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'inicio';
/* $route['default_controller'] = "evaluaciones/Inicio"; */

// $route['ev'] = 'Evaluaciones';
// $route['nuevo'] = 'Evaluaciones/create';
// $route['aplicar'] = 'Evaluaciones/aplicar_evaluacion';
// $route['editar/:id'] = 'Evaluaciones/edit';
// $route['eliminar/:id'] = 'Evaluaciones/delete';

$route["vacation/get/(:num)/(:any)"] = "fastFile/getVacationRequests/$1/$2"; //Dennis Castillo [2022-06-21]
$route["vacation/post"] = "fastFile/createVacationRequest"; //Dennis Castillo [2022-06-21]
$route["vacation/patch/(:num)"] = "fastFile/updateVacation/$1"; //Dennis Castillo [2022-06-21]

$route['personas/perfil/(:any)'] = 'evaluaciones/Personas/perfil/$1';
$route['personas/perfil'] = 'evaluaciones/Personas/perfil';
$route['personas/baja'] = 'evaluaciones/Personas/baja';
$route['personas/get_baja'] = 'evaluaciones/Personas/getBaja';
$route['personas/baja/save'] = 'evaluaciones/Personas/baja_save';
$route['personas/baja/delete'] = 'evaluaciones/Personas/deleteBaja';
$route['personas/baja_empleado'] = 'evaluaciones/Personas/baja_persona';

$route['evaluaciones/tablero/(:any)'] = 'evaluaciones/evaluaciones/listado/$1';
$route['evaluaciones/tableroResultados/(:any)'] = 'evaluaciones/evaluaciones/listado2/$1';

$route['seguimiento/get'] = 'evaluaciones/Seguimiento/getSeguimiento';

$route['incidencias'] = 'evaluaciones/incidencias';
$route['incidencias/getIncidencias'] = 'evaluaciones/incidencias/getIncidencias';
$route['incidencias/datosInicidencia'] = 'evaluaciones/incidencias/datosInicidencia';
$route['incidencias/tipoIncidencia'] = 'evaluaciones/incidencias/tipoIncidencia';
$route['incidencias/postAgregarIncidencia'] = 'evaluaciones/incidencias/postAgregarIncidencia';
$route['incidencias/addTipoIncidencia'] = 'evaluaciones/incidencias/addTipoIncidencia';
$route['incidencias/deleteTipoIncidencia'] = 'evaluaciones/incidencias/deleteTipoIncidencia';
$route['incidencias/gestionIncidencia'] = 'evaluaciones/incidencias/gestionIncidencia';
$route['incidencias/cargar_documento'] = 'evaluaciones/incidencias/postUploadOneMinute';
$route['incidencias/getIncidenciaCatalogo'] = 'evaluaciones/incidencias/getTipoIncidencia';
$route['incidencias/getTipoIncidencia'] = 'evaluaciones/incidencias/getTipoIncidencias';
$route['incidencias/guardarTipoIncidencia'] = 'evaluaciones/incidencias/editarTipoIncidencia';
$route['incidencias/re_procesar'] = 'evaluaciones/incidencias/re_procesar';

/*NOTIFICACIONES */
$route['incidencias/prueba'] = 'evaluaciones/incidencias/prueba';
$route['incidencias/updateChart'] = 'evaluaciones/incidencias/updateChart';
$route['incidencias/pruebaevaluacion'] = 'evaluaciones/incidencias/pruebaevaluacion';

/*IMPLEMENTACION DEL REPORTE(GR�FICOS)*/
$route['tablero'] = 'evaluaciones/tablero/index';
$route['tablero/detallereporte'] = 'evaluaciones/tablero/detallereporte';
$route['reportes/getreporteprueba'] = 'evaluaciones/reportes/getreporteprueba';
$route['incidencias/pruebaReporte'] = 'evaluaciones/incidencias/pruebaReporte';

$route['incidencias/detallereporte'] = 'evaluaciones/incidencias/detallereporte';
$route['incidencias/detallereportepoint'] = 'evaluaciones/incidencias/detallereportepoint';
$route['incidencias/rotacionPersonal'] = 'evaluaciones/incidencias/rotacionPersonal';
$route['incidencias/detallerotacion'] = 'evaluaciones/incidencias/detallerotacion';
$route['incidencias/detalledesempenio'] = 'evaluaciones/incidencias/detalledesempenio';
$route['incidencias/grafica'] = 'evaluaciones/incidencias/grafica';


$route['Prueba'] = 'evaluaciones/Prueba';
$route['Preguntas'] = 'evaluaciones/Preguntas';
$route['Preguntas/getTipoPregunta'] = 'evaluaciones/Preguntas/getTipoPregunta';
$route['Preguntas/addPregunta'] = 'evaluaciones/Preguntas/addPregunta';
$route['Preguntas/getPregunta'] = 'evaluaciones/Preguntas/getPregunta';
$route['Preguntas/editPregunta'] = 'evaluaciones/Preguntas/editPregunta';
$route['Preguntas/deletePregunta'] = 'evaluaciones/Preguntas/deletePregunta';
$route['Preguntas/getPreguntasTable'] = 'evaluaciones/Preguntas/getPreguntasTable';

$route['Competencias'] = 'evaluaciones/Competencias';
$route['Competencias/getDataPreguntas'] = 'evaluaciones/Competencias/getDataPreguntas';
$route['competencias/get'] = 'evaluaciones/Competencias/getCompetencias';
$route['Competencias/getTablaCompetencias'] = 'evaluaciones/Competencias/getTablaCompetencias';
$route['Competencias/AgregarCompetencia'] = 'evaluaciones/Competencias/AgregarCompetencia';
$route['Competencias/getDataUpdate'] = 'evaluaciones/Competencias/getDataUpdate';
$route['Competencias/postDataPreguntas'] = 'evaluaciones/Competencias/postDataPreguntas';
$route['Competencias/deleteCompetencia'] = 'evaluaciones/Competencias/deleteCompetencia';
$route['Competencias/Comprobacion'] = 'evaluaciones/Competencias/Comprobacion';
$route['Competencias/printJS'] = 'evaluaciones/Competencias/printJS';

/*EVALUACION POR COMPETENCIAS - Modificado por Edwin Marin*/
$route['evaluacionCompetencias'] = 'evaluaciones/evaluacionCompetencias';
$route['evaluacionCompetencias/getInfoCompetencia'] = 'evaluaciones/evaluacionCompetencias/getInfoCompetencia';
$route['evaluacionCompetencias/getInfoResultados'] = 'evaluaciones/evaluacionCompetencias/getInfoResultados';
$route['evaluacionCompetencias/guardarRespuestas'] = 'evaluaciones/evaluacionCompetencias/guardarRespuestas';

$route['PIP/(:any)'] = 'evaluaciones/PIP/index/$1';
$route['PIP/generar'] = 'evaluaciones/PIP/generar';
$route['PIP/postPip'] = 'evaluaciones/PIP/PostPip';
$route['PIP/getdataPIP'] = 'evaluaciones/PIP/getData';
$route['PIP/getdataPIPElement'] = 'evaluaciones/PIP/getdataPIPElement';
$route['PIP/editPIP'] = 'evaluaciones/PIP/editPIP';
$route['PIP/AgregarPIP'] = 'evaluaciones/PIP/AgregarPIP';
$route['PIP/PostEditPIP'] = 'evaluaciones/PIP/PostEditPIP';
$route['PIP/MonitoreoPIP'] = 'evaluaciones/PIP/MonitoreoPIP';
$route['PIP/MonitoreoGet'] = 'evaluaciones/PIP/MonitoreoGet';
$route['PIP/getDataMonitoreo'] = 'evaluaciones/PIP/getDataMonitoreo';
$route['PIP/getTableMonitoreo'] = 'evaluaciones/PIP/getTableMonitoreo';
$route['PIP/getComentarios'] = 'evaluaciones/PIP/getComentarios';
$route['PIP/AddComentario'] = 'evaluaciones/PIP/AddComentarios';
$route['PIP/Cerrar'] = 'evaluaciones/PIP/Cerrar';
$route['PIP/Delete'] = 'evaluaciones/PIP/DeletePIP';

$route['filemanager'] = 'evaluaciones/filemanager';
$route['filemanager/get'] = 'evaluaciones/filemanager/get';
$route['filemanager/getV2'] = 'evaluaciones/filemanager/getV2';
$route['filemanager/create'] = 'evaluaciones/filemanager/create';
$route['filemanager/createV2'] = 'evaluaciones/filemanager/createV2';
$route['filemanager/getTrashed'] = 'evaluaciones/filemanager/Gettrashed';
$route['filemanager/trashed'] = 'evaluaciones/filemanager/trashed';
$route['filemanager/delete'] = 'evaluaciones/filemanager/delete';
$route['filemanager/getBy/(:any)'] = 'evaluaciones/filemanager/getBy/$1';
$route['filemanager/copy'] = 'evaluaciones/filemanager/copy';
$route['filemanager/move'] = 'evaluaciones/filemanager/move';
$route['filemanager/refDocumentos'] = 'evaluaciones/filemanager/refDocumentos';

$route['filemanager/restoreFile'] = 'evaluaciones/filemanager/restoreFile';

$route['filemanager/getByParent'] = 'evaluaciones/filemanager/getByParent';
$route['filemanager/ShareFile'] = 'evaluaciones/filemanager/ShareFile';

$route['periodo'] = 'evaluaciones/Periodos';
$route['periodo/getAll'] = 'evaluaciones/Periodos/getAll';
$route['periodo/get'] = 'evaluaciones/Periodos/get';
$route['periodo/save'] = 'evaluaciones/Periodos/save';
$route['periodo/nuevo'] = 'evaluaciones/Periodos/add';
$route['periodo/editar/(:any)'] = 'evaluaciones/Periodos/edit/$1';
$route['periodo/liberar/(:any)'] = 'evaluaciones/Periodos/liberar/$1';
$route['periodo/eliminar/(:any)'] = 'evaluaciones/Periodos/delete/$1';
$route['periodo/cerrar/(:any)'] = 'evaluaciones/Periodos/close/$1';
$route['periodo/clonar/(:any)'] = 'evaluaciones/Periodos/clonarPeriodo/$1';
$route['periodo/beforeLiberar/(:any)'] = 'evaluaciones/Periodos/beforeLiberar/$1';
$route['periodo/getEvaluadores360'] = 'evaluaciones/Periodos/getEvaluadores360';
$route['periodo/addEval360'] = 'evaluaciones/Periodos/addEval360';
$route['periodo/deleteEval360'] = 'evaluaciones/Periodos/deleteEval360';
$route['periodo/testPuesto'] = 'evaluaciones/Periodos/TestpuestoEmpleado';


$route['Bonos'] = 'evaluaciones/Bonos/index';
$route['Bonos/getTableBonos'] = 'evaluaciones/Bonos/getTableBonos';
$route['Bonos/getUsers'] = 'evaluaciones/Bonos/getUsers';
$route['Bonos/postData'] = 'evaluaciones/Bonos/postData';
$route['Bonos/getDataPeticion/(:any)'] = 'evaluaciones/Bonos/getDataPeticion/$1';
$route['Bonos/ValidacionLogeo'] = 'evaluaciones/Bonos/ValidacionLogeo';
$route['Bonos/insertSeguimiento'] = 'evaluaciones/Bonos/insertSeguimiento';
$route['Bonos/getSeguimiento/(:any)'] = 'evaluaciones/Bonos/getSeguimiento/$1';
$route['Bonos/ReplicaBono'] = 'evaluaciones/Bonos/ReplicaBono';
$route['Bonos/bonosreporte'] = 'evaluaciones/Bonos/bonosreporte';

$route['TabuladorBonos'] = 'evaluaciones/TabuladorBonos';
$route['TabuladorBonos/getTableTabuladorBonos'] = 'evaluaciones/TabuladorBonos/getTableTabuladorBonos';
$route['TabuladorBonos/postData'] = 'evaluaciones/TabuladorBonos/postData';
$route['TabuladorBonos/getRegistro/(:any)'] = 'evaluaciones/TabuladorBonos/getRegistro/$1';
$route['TabuladorBonos/seguimiento/(:any)'] = 'evaluaciones/TabuladorBonos/getSeguimiento/$1';
$route['TabuladorBonos/insertSeguimiento'] = 'evaluaciones/TabuladorBonos/insertSeguimiento';
$route['TabuladorBonos/editRegistro'] = 'evaluaciones/TabuladorBonos/editRegistro';
$route['TabuladorBonos/deleteRegistro/(:any)'] = 'evaluaciones/TabuladorBonos/deleteRegistro/$1';


$route['Siniestros'] = 'evaluaciones/Siniestros/Tablero';
$route['Siniestros/registros'] = 'evaluaciones/Siniestros';
//$route['Siniestros/getJSON'] = 'evaluaciones/Siniestros/getJSON';
$route['Siniestros/filterdates'] = 'evaluaciones/Siniestros/filterdates';
$route['Siniestros/postData'] = 'evaluaciones/Siniestros/postData';
$route['Siniestros/getTable'] = 'evaluaciones/Siniestros/getTable';
$route['Siniestros/manageNote'] = 'evaluaciones/Siniestros/manageNote'; //Dennis Castillo [2022-01-16]
$route['Siniestros/getNotes'] = 'evaluaciones/Siniestros/getNotes'; //Dennis Castillo [2022-01-16]
$route['Siniestros/getNote'] = 'evaluaciones/Siniestros/getNote'; //Dennis Castillo [2022-01-16]
$route['Siniestros/deleteNote'] = 'evaluaciones/Siniestros/deleteNote'; //Dennis Castillo [2022-01-16]
$route['Siniestros/getMyNotes'] = 'evaluaciones/Siniestros/getMyNotes'; //Dennis Castillo [2022-01-16] 
$route['Siniestros/editNoteOfSinister/(:any)/(:any)'] = 'evaluaciones/Siniestros/editNoteOfSinister/$1/$2'; //Dennis Castillo [2022-01-16] //getKpi
$route['Siniestros/getKpi'] = 'evaluaciones/Siniestros/getKpi'; //Dennis Castillo [2022-01-17] 
$route['Siniestros/updateSiniestroWS'] = 'evaluaciones/Siniestros/update_SiniestroWS';
$route['Siniestros/Siniestros_bitacora'] = 'evaluaciones/Siniestros/get_bitacora';
$route['Siniestros/getTabla1'] = 'evaluaciones/Siniestros/tabla1_dasboard';
$route['Siniestros/getTabla2'] = 'evaluaciones/Siniestros/tabla2_dasboard';
$route['Siniestros/getTabla3'] = 'evaluaciones/Siniestros/tabla3_dasboard';
$route['Siniestros/rangos'] = 'evaluaciones/Siniestros/rango_dias'; //(:any)
$route['Siniestros/rangos/getDataRangos/(:any)'] = 'evaluaciones/Siniestros/getDataRangos/$1';
$route['Siniestros/test'] = 'evaluaciones/Siniestros/testarrays';
$route['Siniestros/changeClient'] = 'evaluaciones/Siniestros/changeClient';
$route['Siniestros/seguimiento/(:any)'] = 'evaluaciones/Siniestros/Seguimiento/$1';
$route['Siniestros/getExcel'] = 'evaluaciones/Siniestros/getExcel';
$route['Siniestros/postExcel'] = 'evaluaciones/Siniestros/postExcel';

//nuevos rutas de las cosas
$route['Siniestros/NuevoComentario'] = 'evaluaciones/Siniestros/NuevoComentario';
$route['Siniestros/ChangeEstatus'] = 'evaluaciones/Siniestros/ChangeEstatus';
$route['Siniestros/getpartialTramite'] = 'evaluaciones/Siniestros/GetpartialTramite';
$route['Siniestros/postTramite'] = 'evaluaciones/Siniestros/postTramite';
$route['Siniestros/ChangeEstatusTramite'] = 'evaluaciones/Siniestros/ChangeEstatusTramite';
$route['Siniestros/Reingreso'] = 'evaluaciones/Siniestros/Reingreso';
$route['Siniestros/RegistroAutosC/(:any)'] = 'evaluaciones/Siniestros/RegistroAutosC/$1';
$route['Siniestros/RegistroAutosC'] = 'evaluaciones/Siniestros/RegistroAutosC'; //Nueva ruta
$route['Siniestros/AccionesAutos'] = 'evaluaciones/Siniestros/AccionesAutos';
$route['Siniestros/checkid'] = 'evaluaciones/Siniestros/checkid';
//rutas para administar los documentos
$route['Siniestros/updateDocumentos'] = 'evaluaciones/Siniestros/updateDocumentos';
$route['Siniestros/delete_documento'] = 'evaluaciones/Siniestros/delete_documento';


$route['Serviciosws/servicioWSAseguradoras'] = 'evaluaciones/Serviciosws/servicioAseguradoras';
$route['Serviciosws/servicioWSClientes'] = 'evaluaciones/Serviciosws/servicioClientes';
$route['Serviciosws/servicio_post/(:any)'] = 'evaluaciones/Serviciosws/servicio_post/$1';
$route['Serviciosws/servicio_postC/(:any)'] = 'evaluaciones/Serviciosws/servicio_postC/$1';
$route['Serviciosws/getTable/(:any)'] = 'evaluaciones/Serviciosws/getTable/$1';
$route['Serviciosws/cliente-ejecutivo'] = 'evaluaciones/Serviciosws/ejecutivo_cliente';
$route['Serviciosws/notificaciones'] = 'evaluaciones/Serviciosws/Notificacionespodias';
$route['Serviciosws/indicadores'] = 'evaluaciones/Serviciosws/Indicadores';
$route['Serviciosws/servicio_postE/(:any)'] = 'evaluaciones/Serviciosws/servicio_postE/$1';
$route['Serviciosws/servicio_postI/(:any)'] = 'evaluaciones/Serviciosws/servicio_postI/$1';
$route['Serviciosws/servicio_postA/(:any)'] = 'evaluaciones/Serviciosws/servicio_postA/$1';
//Nuevas
$route['Serviciosws/notificiacionesc'] = 'evaluaciones/Serviciosws/NotificacionCorreo';
$route['Serviciosws/servicio_postN/(:any)'] = 'evaluaciones/Serviciosws/servicio_postN/$1';

$route['Permisos'] = 'evaluaciones/Permisos';
$route['Permisos/Acciones/(:any)'] = 'evaluaciones/Permisos/Acciones/$1';
$route['Permisos/getPermisos'] = 'evaluaciones/Permisos/getPermisos';
$route['Permisos/getUsers'] = 'evaluaciones/Permisos/getUsers';
$route['Permisos/getPermisosForm'] = 'evaluaciones/Permisos/getPermisosForm'; //Accionespermisos
$route['Permisos/Accionespermisos'] = 'evaluaciones/Permisos/Accionespermisos';
$route['Permisos/getModulos'] = 'evaluaciones/Permisos/getModulos';
$route['Permisos/CopyPermisos'] = 'evaluaciones/Permisos/CopyPermisos';

$route['Notificaciones/(:any)/(:any)/(:any)'] = 'evaluaciones/Notificaciones/index/$1/$2/$3';
$route['Notificaciones/UpdateAll'] = 'evaluaciones/Notificaciones/UpdateAll';
$route['Notificaciones/updateSingle'] = 'evaluaciones/Notificaciones/updateSingle';
//$route['Notificaciones/Redirect']=='evaluaciones/Notificaciones/Redirect';

$route['api/example'] = 'evaluaciones/api/Example';
$route['api/evaluaciones'] = 'evaluaciones/api/Cornjob/evaluaciones';
//$route['api/example'] = 'evaluaciones/api/Products';
$route['Serviciosws/corn'] = 'evaluaciones/Prueba';

$route['erorrPermisos'] = 'evaluaciones/Notificaciones/erorpermisos';

///llamda del metodo de actualizacion de los siniestros
$route['api/ServicioSiniestros'] = 'evaluaciones/api/Cornjob';
$route['api/test'] = 'evaluaciones/api/Cornjob/test';

//ruta de prueba
$route['Siniestros/prueba'] = 'evaluaciones/Siniestros/prueba';
$route['Siniestros/getTablaDT'] = 'evaluaciones/Siniestros/getTablaDT';
$route['Siniestros/fulldata'] = 'evaluaciones/Siniestros/testDatafull';
$route['Siniestros/updatecmp'] = 'evaluaciones/Siniestros/updateCampoTramite';

//Diary API
$route["api/calendar/events/(:num)"] = "Diary/event/$1";
$route["api/calendar/events"] = "Diary/manage";
$route["api/calendar/guest/(:num)/participation"] = "Diary/guest/$1";

//User API
$route["api/user/myUser"] = "usersApi/getMyUser";
$route["api/user/(:num)"] = "usersApi/user/$1";

//Users API
$route["api/users/(:any)/page/(:num)"] = "usersApi/pagination/$1/$2";
$route["api/users/(:any)"] = "usersApi/getDepartment/$1";
$route["api/users"] = "usersApi/manage";

//Agent API
$route["api/agent/(:num)"] = "AgenteApi/getData/$1";
//$route["api/sms"] = "smsMasivo/smsApi";

//SMS API
$route["api/sms/verification"] = "smsMasivo/sendVerificationNumber";

//Prospecter API
$route["api/prospection/client/(:num)"] = "prospeccionAPI/index";

//General API
$route["api/countryCodes"] = "AgenteApi/getCountryCodes";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* End of file routes.php */
/* Location: ./application/config/routes.php */
