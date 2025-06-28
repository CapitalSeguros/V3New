import React, { useState, useEffect, useRef, forwardRef, useImperativeHandle } from 'react';
import Paginate from './Paginate.jsx';
import axios from "axios";
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { mapitemsHijosNombre, UpperCaseField } from '../../Helpers/FGeneral.js';
import RfcFacil from 'rfc-facil';




const ModalOpc = forwardRef((props, ref) => {
    useImperativeHandle(ref, () => {
        return {
            Open: Open
        }
    });

    function Open() {
        OpenModal();
    }
    const formikRefC = useRef(null);
    const formikRefD = useRef(null);
    const { UrlServicio, Tipo, OnSelect, Data } = props;
    const itemsPerPage = 10;
    const Inputref = useRef(null);

    useEffect(() => {
        if (Inputref.current)
            Inputref.current.focus();
    }, []);


    //Paginacion
    useEffect(() => {
        // Fetch items from another resources.
        const endOffset = itemOffset + itemsPerPage;
        //setCurrentItems(state.slice(itemOffset, endOffset));
        setPageCount(Math.ceil(state.length / itemsPerPage));
    }, [itemOffset, itemsPerPage]);

    const [itemOffset, setItemOffset] = useState(0);
    const [pageCount, setPageCount] = useState(0);
    const [totalRows, setTotalRows] = useState(0);
    const [adduser, setAddUser] = useState(0);
    const [addDireccion, setAddDirecciones] = useState(0);
    const [singleClient, setSingleUser] = useState([]);
    const [direcciones, setDirecciones] = useState([]);
    const [itemCliente, setItemCliente] = useState({});
    const [anos, setAnos] = useState('');
    const [itemDireccion, setItemDireccion] = useState({});
    const [initial, setInitial] = useState({
        Ejecutivos: [],
        Entidad: [],
        Sexo: [],
        Grupo: [],
        SubGrupo: [],
        TipoDireccion: []
    });
    const [erroresC, setErroresC] = useState([]);
    const [erroresD, setErroresD] = useState([]);
    const [state, setState] = useState([]);
    const validateC = ['TipoEnt_TXT', 'Sexo_TXT'];
    const validateD = ['Calle', 'CPostal'];
    const [inputs, setInputs] = useState({
        Busqueda: ''
    })

    function OpenModal() {
        setAddUser(0);
        setPageCount(0);
        setTotalRows(0);
        setItemCliente({});
        InitialData();
        setState([]);
        setInputs({
            ...state,
            Busqueda: ''
        });
        $("#ModalOpc").modal("show");
    }

    function SetValue(e) {
        OnSelect(e);
        $("#ModalOpc").modal("hide");
    }

    const handlePageClick = (event) => {
        const newOffset = (event.selected * itemsPerPage) % totalRows;
        setItemOffset(newOffset);
        CallData(Tipo, newOffset);
    };

    function handleInput(e) {
        const { value, name } = e.target;
        var parsed = UpperCaseField(value);
        setInputs({ ...state, [name]: parsed });
    }

    function CallData(tipo, offset) {
        if (inputs.Busqueda != '') {
            axios
                .post(`${UrlServicio}capture/ComponenteTabla`, { Tipo: tipo, Offset: offset, Busqueda: inputs.Busqueda })
                .then(function (response) {
                    setState(response.data.Datos);
                    setPageCount(Math.ceil(response.data.Count / itemsPerPage));
                    setTotalRows(response.data.Count);
                    $('#ModalOpc').modal('handleUpdate');
                });
        } else {
            toastr.error(`Error, Ingrese un texto de busqueda.`);
        }
    }

    async function InitialData() {
        //console.log("url Api --->",UrlServicio)
        var complemento = {};
        var URL = `${UrlServicio}capture/initialUsers`;
        const res = await CallApiGet(URL, complemento, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            setInitial({
                ...initial,
                Ejecutivos: res.success.Datos.Ejecutivos,
                Sexo: res.success.Datos.Sexo,
                Entidad: res.success.Datos.Entidad,
                Grupo: res.success.Datos.Grupo,
                SubGrupo: res.success.Datos.SubGrupo,
                TipoDireccion: res.success.Datos.TipoDireccion
            });
        }
    }

    function calculateYears(date) {
        var years = moment().diff(date, 'years');
        //console.log("anos",years);
        setAnos(years)
        //return years;
    }

    async function GetRow(Id) {
        //console.log("url Api --->",UrlServicio)
        var complemento = {};
        var URL = `${UrlServicio}capture/getRowCliente`;
        const res = await CallApiGet(URL, { Id: Id }, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            InitialData();
            setItemCliente(res.success.Datos.Cliente);
            let anos = res.success.Datos.Cliente.FechaNac;
            calculateYears(anos);
            setDirecciones(res.success.Datos.Direcciones);
            setAddUser(1);
        }
    }

    async function Validate(Tipo) {
        //var VForm = Object.keys(Tipo == 1 ? itemCliente : itemDireccion);
        var VForm = Tipo == 1 ? itemCliente : itemDireccion;
        setErroresC([]); setErroresD([]);
        var Errores = [];
        var Check = Tipo == 1 ? validateC : validateD;
        if (Tipo == 1) {
            /* console.log("Tipo",Tipo);
            console.log("TipoEntidad",itemCliente.TipoEnt_TXT); */
            if (itemCliente.TipoEnt_TXT == "Moral") {
                let New = Check.filter(element => element !== 'Sexo_TXT');
                Check = New;
            }
        }
        Check.forEach(element => {
            //console.log("value", element)
            var FindElement = VForm[element] ? VForm[element] : '';
            //console.log("Find", FindElement)
            if (FindElement != null) {
                if (FindElement == "") {
                    Errores.push(element);
                }
            } else {
                Errores.push(element);
            }
        });
        if (Tipo == 1) {
            setErroresC(Errores);
        } else {
            setErroresD(Errores);
        }
        return Errores.length;
    }

    function handleChange(e, isSelect = false, Tipo = 1) {
        Validate(Tipo)
        if (Tipo == 1) {
            if (isSelect) {
                setItemCliente({ ...itemCliente, [e.target.name]: e.target.value });
            } else {
                setItemCliente({ ...itemCliente, [e.target.name]: UpperCaseField(e.target.value) });
            }
        }
        if (Tipo == 2) {
            if (isSelect) {
                setItemDireccion({ ...itemDireccion, [e.target.name]: e.target.value });
            } else {
                setItemDireccion({ ...itemDireccion, [e.target.name]: UpperCaseField(e.target.value) });
            }
        }
    }

    async function GuardarCliente() {
        let Errores = await Validate(1);
        /* console.log("Errores Clientes", Errores);
        console.log("Errpes D", erroresD);
        console.log("Errpes U", erroresC); */
        if (Errores == 0) {
            var URL = `${UrlServicio}capture/saveClient`;
            var dta = { data: itemCliente }
            const res = await CallApiPost(URL, dta, null);
            if (res.status != 200) {
                toastr.error(`Error ${res.error.Mensaje}`);
            } else {
                setItemCliente(res.success.Datos);
                toastr.success("Exíto");
            }
        } else {
            return swal({
                title: "Llenar información",
                text: "Hay campos sin llenar.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#472380"
            });
        }
    }

    async function GuardarDireccion() {
        let Errores = await Validate(2);
        if (Errores == 0) {
            var URL = `${UrlServicio}capture/saveDirClient`;
            var dta = { data: itemDireccion, Cliente: itemCliente.IDCli }
            const res = await CallApiPost(URL, dta, null);
            if (res.status != 200) {
                toastr.error(`Error ${res.error.Mensaje}`);
            } else {
                setItemCliente(res.success.Datos);
                setAddDirecciones(0);
                GetRow(itemCliente.IDCli);
                toastr.success("Exíto");
            }
        }
    }

    function GenerateRFC() {
        let RFC = "";
        var tipo = itemCliente.TipoEnt_TXT;
        if (tipo != null) {


            if (tipo == "Fisica") {
                let Nac = moment(itemCliente.FechaNac, 'YYYY/MM/DD');
                let month = Nac.format('M');
                let day = Nac.format('D');
                let year = Nac.format('YYYY');
                RFC = RfcFacil.forNaturalPerson({
                    name: itemCliente.Nombre ? itemCliente.Nombre : '',
                    firstLastName: itemCliente.ApellidoP ? itemCliente.ApellidoP : '',
                    secondLastName: itemCliente.ApellidoM ? itemCliente.ApellidoM : '',
                    day: day,
                    month: month,
                    year: year
                });
                /* if (TotalArray >= 3) {
                    let Nac = moment(itemCliente.FechaNac, 'YYYY/MM/DD');
                    let day = Nac.format('M');
                    let month = Nac.format('D');
                    let year = Nac.format('YYYY');
                    let Ap1 = Arrayname[TotalArray - 1];
                    let Ap2 = Arrayname[TotalArray - 2];
                    Arrayname.splice(Arrayname.length - 1, 1);
                    Arrayname.splice(Arrayname.length - 1, 1);
                    console.log(`Nombre: ${Arrayname.join(' ')} | Ap1: ${Ap2} | Ap2: ${Ap1} | Nac: ${itemCliente.FechaNac} | dia: ${day}| mes: ${month} | year: ${year}`);
                    let nombre = Arrayname.join(' ');
                    RFC = RfcFacil.forNaturalPerson({
                        name: nombre,
                        firstLastName: Ap2,
                        secondLastName: Ap1,
                        day: day,
                        month: month,
                        year: year
                    });
                } */
            } else {
                let Nombre = itemCliente.NombreCompleto;
                let Arrayname = Nombre.split(' ');
                let TotalArray = Arrayname.length;
                let day = moment(itemCliente.FechaConst).day();
                let month = moment(itemCliente.FechaConst).month();
                let year = moment(itemCliente.FechaConst).year();
                RFC = RfcFacil.forJuristicPerson({
                    name: itemCliente.NombreCompleto,
                    day: day,
                    month: month,
                    year: year
                });
            }
        }
        setItemCliente({
            ...itemCliente,
            RFC: RFC
        })
        //console.log("RFC", RFC);
    }

    return (
        <>
            <div className="input-group">
                <input type="text" className="form-control" value={Data} readOnly={true} />
                <span className="input-group-btn">
                    <a className="btn btn-primary" type="button" onClick={() => OpenModal()}><i className="fa fa-search" aria-hidden="true"></i></a>
                </span>
            </div>
            <div id="ModalOpc" className="modal fade" role="dialog">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">Seleccione una opción</h4>
                            <button type="button" className="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div className="modal-body">
                            {adduser == 0 && (
                                <div className='TablaUsuarios'>
                                    <div className='row mb-4'>
                                        <div className='col-md-6'>
                                            <input
                                                ref={Inputref}
                                                //autoFocus={true}
                                                className="form-control input-sm"
                                                type="text"
                                                name="Busqueda"
                                                id="Busqueda"
                                                placeholder='Elemento a buscar'
                                                //onChange={handleInput}
                                                onChange={(e) => handleInput(e)}
                                                value={inputs.Busqueda ? inputs.Busqueda : ''}
                                            />
                                        </div>
                                        <div className='col-md-3'>
                                            <a className='btn btn-primary btn-sm' onClick={() => CallData(Tipo, 0)}><i className="fa fa-search" aria-hidden="true"></i></a>
                                        </div>
                                        <div className='col-md-3' style={{ textAlign: 'end' }}>
                                            <a className='btn btn-sm btn-primary' data-toggle="tooltip" data-placement="bottom" title="Nuevo" onClick={() => { InitialData(), setItemCliente({}), setAddUser(1) }}><i className="fa fa-plus" aria-hidden="true"></i></a>
                                        </div>

                                    </div>
                                    <div className='row'>
                                        <div className='col-md-12'>
                                            <table className="table table-bordered" id="dataTable" width="100%" cellSpacing="0" style={{ fontSize: 'xx-small' }}>
                                                <thead>
                                                    <tr>
                                                        <th>Cliente</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody style={{ maxHeight: '400px', overflow: 'auto' }}>
                                                    {state.length == 0 && (
                                                        <tr className='text-center'><td colSpan={5}>No hay registros de captura.</td></tr>
                                                    )}
                                                    {state && state.map((item, key) => (
                                                        <tr key={key}>
                                                            <td style={{ cursor: 'pointer' }} onClick={() => SetValue(item)}>{item.Nombre}</td>
                                                            <td>
                                                                <a className='btn btn-sm btn-primary' data-toggle="tooltip" data-placement="bottom" title="Editar" onClick={() => GetRow(item.Id)}><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>
                                                    ))}
                                                </tbody>
                                            </table>
                                        </div>
                                        <div className='col-md-12' style={{ textAlign: 'end' }}>
                                            <Paginate handlePageClick={handlePageClick} pageCount={pageCount} />
                                        </div>
                                    </div>
                                </div>
                            )}
                            {adduser == 1 && (
                                <div className='FormUsuarios'>
                                    <div className='row'>
                                        <div className='col-md-12' style={{ textAlign: 'end' }}>
                                            <a className='btn btn-sm btn-primary' data-toggle="tooltip" data-placement="bottom" title="Regresar" onClick={() => setAddUser(0)}><i className="fa fa-reply" aria-hidden="true"></i></a>
                                            <a className='btn btn-sm btn-primary' data-toggle="tooltip" data-placement="bottom" title="Guardar" onClick={() => GuardarCliente()}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                                            <a className='btn btn-sm btn-primary' data-toggle="tooltip" data-placement="bottom" title="Seleccionar" onClick={() => SetValue({ Id: itemCliente.IDCli, Nombre: itemCliente.NombreCompleto })}  ><i className="fa fa-check" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div className='row pt-4'>
                                        <div className='col-md-3'>
                                            <div className='form-group'>
                                                <label>Tipo Entidad</label>
                                                <select name="TipoEnt_TXT" id="TipoEnt_TXT" onBlur={() => GenerateRFC()} onChange={(e) => {
                                                    handleChange(e, true, 1), setTimeout(() => {
                                                        $('#ModalOpc').modal('handleUpdate')
                                                    }, 100);
                                                }} value={itemCliente.TipoEnt_TXT ? itemCliente.TipoEnt_TXT : ''} className='form-control input-sm'>
                                                    <option value="">Seleccione una opción</option>
                                                    <option value="Fisica">Fisica</option>
                                                    <option value="Moral">Moral</option>
                                                </select>
                                                <span className="help-block">{erroresC.includes('TipoEnt_TXT') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                        {itemCliente.TipoEnt_TXT == "Moral" && (
                                            <div className='col-md-9'>
                                                <div className='form-group'>
                                                    <label>Nombre o Razón Social</label>
                                                    <input onBlur={() => GenerateRFC()} type='text' name="NombreCompleto" id="NombreCompleto" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.NombreCompleto ? itemCliente.NombreCompleto : ''} className='form-control input-sm' />
                                                    <span className="help-block">{erroresC.includes('NombreCompleto') ? 'Requerido' : ''}</span>
                                                </div>
                                            </div>
                                        )}
                                        {itemCliente.TipoEnt_TXT == "Fisica" && (
                                            <>
                                                <div className='col-md-3'>
                                                    <div className='form-group'>
                                                        <label>Nombre</label>
                                                        <input onBlur={() => GenerateRFC()} type='text' name="Nombre" id="Nombre" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.Nombre ? itemCliente.Nombre : ''} className='form-control input-sm' />
                                                        <span className="help-block">{erroresC.includes('Nombre') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-3'>
                                                    <div className='form-group'>
                                                        <label>Apellido Paterno</label>
                                                        <input onBlur={() => GenerateRFC()} type='text' name="ApellidoP" id="ApellidoP" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.ApellidoP ? itemCliente.ApellidoP : ''} className='form-control input-sm' />
                                                        <span className="help-block">{erroresC.includes('ApellidoP') ? 'Requerido' : ''}</span>
                                                    </div>

                                                </div>
                                                <div className='col-md-3'>
                                                    <div className='form-group'>
                                                        <label>Apellido Materno</label>
                                                        <input onBlur={() => GenerateRFC()} type='text' name="ApellidoM" id="ApellidoM" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.ApellidoM ? itemCliente.ApellidoM : ''} className='form-control input-sm' />
                                                        <span className="help-block">{erroresC.includes('ApellidoM') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                            </>
                                        )}
                                    </div>
                                    {itemCliente.TipoEnt_TXT == "Moral" && (
                                        <div className='row'>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Fecha Constitución</label>
                                                    <input onBlur={() => GenerateRFC()} type='date' onChange={(e) => handleChange(e, false, 1)} value={itemCliente.FechaConst ? moment(itemCliente.FechaConst).format('YYYY-MM-DD') : ''} name="FechaConst" id="FechaConst" className='form-control input-sm' />
                                                    <span className="help-block">{erroresC.includes('FechaConst') ? 'Requerido' : ''}</span>
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    {itemCliente.TipoEnt_TXT == "Fisica" && (
                                        <div className='row'>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Sexo</label>
                                                    <select name="Sexo_TXT" onChange={(e) => handleChange(e, true, 1)} value={itemCliente.Sexo_TXT ? itemCliente.Sexo_TXT : ''} id="Sexo_TXT" className='form-control input-sm'>
                                                        <option value="">Seleccione una opción</option>
                                                        {initial.Sexo && initial.Sexo.map((item, key) => (
                                                            <option key={key} value={item.Sexo_TXT}>{item.Sexo_TXT}</option>
                                                        ))}
                                                    </select>
                                                    <span className="help-block">{erroresC.includes('Sexo_TXT') ? 'Requerido' : ''}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Fecha Nacimiento</label>
                                                    <input type='date' name="FechaNac" id="FechaNac" onBlur={(e) => { calculateYears(e.target.value), GenerateRFC() }} onChange={(e) => handleChange(e, false, 1)} value={itemCliente.FechaNac ? moment(itemCliente.FechaNac).format("YYYY-MM-DD") : ''} className='form-control input-sm' />
                                                    <span className="help-block">{erroresC.includes('FechaNac') ? 'Requerido' : ''}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Edad</label>
                                                    <input disabled name="Edad" id="Edad" value={anos} onChange={() => ''} className='form-control input-sm numeric' />
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    <div className='row'>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>Ejecutivo Cuenta</label>
                                                <select name="EjecutNombre" id="EjecutNombre" onChange={(e) => handleChange(e, true, 1)} value={itemCliente.EjecutNombre ? itemCliente.EjecutNombre : ''} className='form-control input-sm'>
                                                    <option value="">Seleccione una opción</option>
                                                    {initial.Ejecutivos && initial.Ejecutivos.map((item, key) => (
                                                        <option key={key} value={item.Nombre}>{item.Nombre}</option>
                                                    ))}
                                                </select>
                                                <span className="help-block">{erroresC.includes('EjecutNombre') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>RFC</label>
                                                <input type='text' name="RFC" id="RFC" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.RFC ? itemCliente.RFC : ''} className='form-control input-sm' />
                                                <span className="help-block">{erroresC.includes('RFC') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>Grupo</label>
                                                <select name="Grupo" id="Grupo" onChange={(e) => handleChange(e, true, 1)} value={itemCliente.Grupo ? itemCliente.Grupo : ''} className='form-control input-sm'>
                                                    <option value="">Seleccione una opción</option>
                                                    {initial.Grupo && initial.Grupo.map((item, key) => (
                                                        <option key={key} value={item.Nombre}>{item.Nombre}</option>
                                                    ))}
                                                </select>
                                                <span className="help-block">{erroresC.includes('Grupo') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div className='row'>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>Ejecutivo Cobranza</label>
                                                <select name="EjcCobranza" id="EjcCobranza" onChange={(e) => handleChange(e, true, 1)} value={itemCliente.EjcCobranza ? itemCliente.EjcCobranza : ''} className='form-control input-sm'>
                                                    <option value="">Seleccione una opción</option>
                                                    {initial.Ejecutivos && initial.Ejecutivos.map((item, key) => (
                                                        <option key={key} value={item.Nombre}>{item.Nombre}</option>
                                                    ))}
                                                </select>
                                                <span className="help-block">{erroresC.includes('EjcCobranza') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>Alias</label>
                                                <input type='text' name="Alias" id="Alias" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.Alias ? itemCliente.Alias : ''} className='form-control input-sm' />
                                                <span className="help-block">{erroresC.includes('Alias') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>SubGrupo</label>
                                                <select name="SubGrupo" id="SubGrupo" onChange={(e) => handleChange(e, true, 1)} value={itemCliente.SubGrupo ? itemCliente.SubGrupo : ''} className='form-control input-sm'>
                                                    <option value="">Seleccione una opción</option>
                                                    {mapitemsHijosNombre(initial.SubGrupo ? initial.SubGrupo : [], itemCliente.Grupo).map((item, key) => (
                                                        <option key={key} value={item.label}>{item.label}</option>
                                                    ))}
                                                </select>
                                                <span className="help-block">{erroresC.includes('SubGrupo') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div className='row'>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>Ejecutivo Reclamaciones</label>
                                                <select name="EjcReclamaciones" id="EjcReclamaciones" onChange={(e) => handleChange(e, true, 1)} value={itemCliente.EjcReclamaciones ? itemCliente.EjcReclamaciones : ''} className='form-control input-sm'>
                                                    <option value="">Seleccione una opción</option>
                                                    {initial.Ejecutivos && initial.Ejecutivos.map((item, key) => (
                                                        <option key={key} value={item.Nombre}>{item.Nombre}</option>
                                                    ))}
                                                </select>
                                                <span className="help-block">{erroresC.includes('EjcReclamaciones') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>Correo 1</label>
                                                <input type='text' name="Email1" id="Email1" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.Email1 ? itemCliente.Email1 : ''} className='form-control input-sm' />
                                                <span className="help-block">{erroresC.includes('Email1') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>SubSubGrupo</label>
                                                <input type='text' name="SSGrupo" id="SSGrupo" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.SSGrupo ? itemCliente.SSGrupo : ''} className='form-control input-sm' />
                                                <span className="help-block">{erroresC.includes('SSGrupo') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div className='row'>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>{itemCliente.TipoEnt_TXT == 'Moral' ? 'Télefono' : 'Celular'}</label>
                                                <input type='text' name="Telefono1" id="Telefono1" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.Telefono1 ? itemCliente.Telefono1 : ''} className='form-control input-sm numeric' />
                                                <span className="help-block">{erroresC.includes('Telefono1') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>Correo 2</label>
                                                <input type='text' name="Email2" id="Email2" onChange={(e) => handleChange(e, false, 1)} value={itemCliente.Email2 ? itemCliente.Email2 : ''} className='form-control input-sm' />
                                                <span className="help-block">{erroresC.includes('Email2') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label>Oficina</label>
                                                <select name="Oficina" id="Oficina" onChange={(e) => handleChange(e, true, 1)} value={itemCliente.Oficina ? itemCliente.Oficina : ''} className='form-control input-sm'></select>
                                                <span className="help-block">{erroresC.includes('Oficina') ? 'Requerido' : ''}</span>
                                            </div>
                                        </div>
                                    </div>
                                    {addDireccion == 0 && (
                                        <>
                                            <div className='row pt-4'>
                                                <div className='col-md-12' style={{ textAlign: 'end' }}>
                                                    {itemCliente.IDTemp && (
                                                        <a className='btn btn-sm btn-primary' data-toggle="tooltip" data-placement="bottom" title="Nuevo" onClick={() => {
                                                            setAddDirecciones(1), setTimeout(() => {
                                                                $('#ModalOpc').modal('handleUpdate')
                                                            }, 100), setItemDireccion({})
                                                        }}><i className="fa fa-plus" aria-hidden="true"></i>
                                                        </a>
                                                    )}
                                                </div>
                                            </div>
                                            <div className='row pt-4'>
                                                <div className='col-md-12'>
                                                    <table className="table table-bordered" id="dataTable" width="100%" cellSpacing="0" style={{ fontSize: 'xx-small' }}>
                                                        <thead>
                                                            <tr>
                                                                <th>Dirección</th>
                                                                <th>Teléfono</th>
                                                                <th>Tipo Dirección</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style={{ maxHeight: '400px', overflow: 'auto' }}>
                                                            {direcciones.length == 0 && (
                                                                <tr className='text-center'><td colSpan={4}>No hay registros de captura.</td></tr>
                                                            )}
                                                            {direcciones && direcciones.map((item, key) => (
                                                                <tr key={key}>
                                                                    <td>{item.Calle}</td>
                                                                    <td>{item.Telefono1}</td>
                                                                    <td>{item.TipoDir}</td>
                                                                    <td>
                                                                        <a className='btn btn-sm btn-primary' onClick={() => {
                                                                            setItemDireccion(item), setAddDirecciones(1), setTimeout(() => {
                                                                                $('#ModalOpc').modal('handleUpdate')
                                                                            }, 100);
                                                                        }}><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                                    </td>
                                                                </tr>
                                                            ))}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </>
                                    )}
                                    {addDireccion == 1 && (
                                        <>
                                            <div className='row pt-4' style={{ textAlign: 'end' }}>
                                                <div className='col-md-12'>
                                                    <a className='btn btn-sm btn-primary' data-toggle="tooltip" data-placement="bottom" title="Regresar" onClick={() => setAddDirecciones(0)}><i className="fa fa-reply" aria-hidden="true"></i></a>
                                                    <a className='btn btn-sm btn-primary' data-toggle="tooltip" data-placement="bottom" title="Guardar" onClick={() => GuardarDireccion()}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                                                    {/* <a onClick={() => {
                                                        console.log('erores', erroresD),
                                                            console.log('item', itemDireccion);
                                                    }}>test</a> */}
                                                </div>
                                            </div>
                                            <div className='row pt-4'>
                                                <div className='col-md-9'>
                                                    <div className='form-group'>
                                                        <label>Dirección</label>
                                                        <input type='text' name="Calle" id="Calle" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Calle ? itemDireccion.Calle : ''} className='form-control input-sm' />
                                                        <span className="help-block">{erroresD.includes('Calle') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-3'>
                                                    <div className='form-group'>
                                                        <label>Código Postal</label>
                                                        <input type='text' maxLength={5} name="CPostal" id="CPostal" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.CPostal ? itemDireccion.CPostal : ''} className='form-control input-sm numeric' />
                                                        <span className="help-block">{erroresD.includes('CPostal') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='row'>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Colonia</label>
                                                        <input type='text' name="Colonia" id="Colonia" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Colonia ? itemDireccion.Colonia : ''} className='form-control input-sm' />
                                                        <span className="help-block">{erroresD.includes('Colonia') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Población</label>
                                                        <input type='text' name="Poblacion" id="Poblacion" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Poblacion ? itemDireccion.Poblacion : ''} className='form-control input-sm' />
                                                        <span className="help-block">{erroresD.includes('Poblacion') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Estado</label>
                                                        <input type='text' name="Ciudad" id="Ciudad" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Ciudad ? itemDireccion.Ciudad : ''} className='form-control input-sm' />
                                                        <span className="help-block">{erroresD.includes('Ciudad') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='row'>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Pais</label>
                                                        {/* <select name="Pais" id="Pais" onChange={(e) => handleChange(e, true, 1)} value={itemDireccion.Pais ? itemDireccion.Pais : ''} className='form-control input-sm'></select> */}
                                                        <input type='text' name="Pais" id="Pais" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Pais ? itemDireccion.Pais : ''} className='form-control input-sm' />
                                                        <span className="help-block">{erroresD.includes('Pais') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Tipo de dirección</label>
                                                        <select name="TipoDir" id="TipoDir" onChange={(e) => handleChange(e, true, 2)} value={itemDireccion.TipoDir ? itemDireccion.TipoDir : ''} className='form-control input-sm'>
                                                            <option value="">Seleccione una opción</option>
                                                            {initial.TipoDireccion && initial.TipoDireccion.map((item, key) => (
                                                                <option key={key} value={item.TipoDir}>{item.TipoDir}</option>
                                                            ))}
                                                        </select>
                                                        <span className="help-block">{erroresD.includes('TipoDir') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Mensajero</label>
                                                        <select name="Pais" id="Pais" className='form-control input-sm'></select>
                                                        <span className="help-block">{erroresD.includes('Pais') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='row'>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Telefono 1</label>
                                                        <input maxLength={10} type='text' name="Telefono1" id="Telefono1" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Telefono1 ? itemDireccion.Telefono1 : ''} className='form-control input-sm numeric' />
                                                        <span className="help-block">{erroresD.includes('Telefono1') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Telefono 2</label>
                                                        <input maxLength={10} type='text' name="Telefono2" id="Telefono2" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Telefono2 ? itemDireccion.Telefono2 : ''} className='form-control input-sm numeric' />
                                                        <span className="help-block">{erroresD.includes('Telefono2') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Telefono 3</label>
                                                        <input maxLength={10} type='text' name="Telefono3" id="Telefono3" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Telefono3 ? itemDireccion.Telefono3 : ''} className='form-control input-sm numeric' />
                                                        <span className="help-block">{erroresD.includes('Telefono3') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='row'>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Telefono 4</label>
                                                        <input maxLength={10} type='text' name="Telefono4" id="Telefono4" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Telefono4 ? itemDireccion.Telefono4 : ''} className='form-control input-sm numeric' />
                                                        <span className="help-block">{erroresD.includes('Telefono4') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Telefono 5</label>
                                                        <input maxLength={10} type='text' name="Telefono5" id="Telefono5" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Telefono5 ? itemDireccion.Telefono5 : ''} className='form-control input-sm numeric' />
                                                        <span className="help-block">{erroresD.includes('Telefono5') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                                <div className='col-md-4'>
                                                    <div className='form-group'>
                                                        <label>Telefono 6</label>
                                                        <input maxLength={10} type='text' name="Telefono6" id="Telefono6" onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Telefono6 ? itemDireccion.Telefono6 : ''} className='form-control input-sm numeric' />
                                                        <span className="help-block">{erroresD.includes('Telefono6') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='row'>
                                                <div className='col-md-12'>
                                                    <div className='form-group'>
                                                        <label>Indicaciones</label>
                                                        <textarea style={{ height: '50px' }} onChange={(e) => handleChange(e, false, 2)} value={itemDireccion.Indicaciones ? itemDireccion.Indicaciones : ''} className='form-control' name="Indicaciones" id="Indicaciones">
                                                            {itemDireccion.Indicaciones ? itemDireccion.Indicaciones : ''}
                                                        </textarea>
                                                        <span className="help-block">{erroresD.includes('Indicaciones') ? 'Requerido' : ''}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </>
                                    )}
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </>


    )
})

export default ModalOpc;
