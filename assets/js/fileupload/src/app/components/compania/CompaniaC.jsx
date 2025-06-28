import React, { useState, useEffect, useRef } from 'react';
import Select from "react-select";
import { Form, Formik } from "formik";
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { mapitems, mapitemsHijos, displayitem, colourStyles, ShowLoading } from '../../Helpers/FGeneral.js';
import Agentes from './Agentes.jsx';
import Derechos from './config/Derechos.jsx';
import PrimaMin from './config/PrimaMin.jsx';
import Comisiones from './config/Comisiones.jsx';
import Productos from './config/Productos.jsx';


export default function compania(props) {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const Id = window.jQuery("#idRegistro").val();
  //$("#menu").css("z-index", '-1');
  const { callback, UrlServicio, UrlPagina } = props;
  const formikRef = useRef(null);//getSingleCompania
  const childrenRef = useRef(null);//getSingleCompania

  const [state, setState] = useState({
    InitialData: {
      TipoCompania: [],
      Clasificacion: [],
      Promotoria: [],
      CalReciboPol: [],
      CalReciboEnd: [],
      AplicacionDerechos: [],
      Prioridad: [],
      TipoAgente: [],
      TipoEntidad: [],
      TipoCedula: [],
      Estatus: [],
      Cartera: [],
      SubCartera: [],
      Monedas: [],
      FormaPago: []
    },
    selected: { value: "", label: "" },
  });
  const [empresa, SetEmpresa] = useState({
    Compania: {
      //IDTemp: '',
      //IDCia: '',
    },
    Agentes: [],
    Monedas: [],
    FormaPago: [],
    SubRamos: []
  });

  //Formas de pago
  const [EditFM, SetEditFM] = useState(false);
  const [ConfigFMMon, SetConfigFMMon] = useState([]);
  const [IdFM, SetIdFM] = useState(0);
  const [ItemFM, SetItemFM] = useState({});

  const [SelectedFm, SetSelectedFm] = useState(0);
  const [SelectedM, SetSelectedM] = useState(0);
  const [filteredSubRamo, setFilteredSubRamo] = useState([]);

  //Subramos
  //Formas de pago
  const [EditSR, SetEditSR] = useState(false);
  const [ConfigSR, SetConfigSR] = useState([]);
  const [IdSR, SetIdSR] = useState(0);
  const [ItemSR, SetItemSR] = useState({});
  const [DerechosSR, SetDerechosSR] = useState([]);
  const [RecargosSR, SetRecargosSR] = useState([]);
  const [PrimaMSR, SetPrimaMSR] = useState([]);
  const [ConfigO, SetConfigO] = useState(0);



  useEffect(() => {
    if ($('body div').hasClass('pace')) {
      $("body div").removeClass("pace");
    }
    InitialData();
    if (Id != undefined) {
      InitialDataRegistro();
    }



  }, []);

  useEffect(() => {
    $('#ModalComisiones').on('hidden.bs.modal', function () {
      $("#menu").css("z-index", 'unset');
    })

  });


  async function InitialData() {
    ShowLoading();
    const res = await CallApiGet(`${UrlServicio}catalogos/compania_initial`, {}, null);
    if (res.status != 200) {
      toastr.error(`Error, intente mas tarde. ${res.error}`);
    } else {
      setState({
        ...state,
        InitialData: res.success.Datos
      })
    }
    ShowLoading(false);
  }

  async function InitialDataRegistro() {
    ShowLoading();
    const res = await CallApiGet(`${UrlServicio}catalogos/getSingleCompania/${Id}`, {}, null);
    if (res.status != 200) {
      toastr.error(`Error, intente mas tarde. ${res.error}`);
    } else {
      SetEmpresa(res.success.Datos);//SubRamos
      setFilteredSubRamo(res.success.Datos.SubRamos);
    }
    ShowLoading(false);
  }

  async function SaveData(data) {
    
    ShowLoading();
    var dta = {
      "data": data,
      "Id": Id
    };

    const res = await CallApiPost(`${UrlServicio}catalogos/compania`, dta, null);
    if (res.status != 200) {
      if(res.error && res.error.Mensaje != "")
        toastr.error(`Error. ${res.error.Mensaje}`);
      else
        toastr.error(`Error. Ocurrió un error al guardar el registro.`);
      //toastr.error(`Error, intente mas tarde. ${res.error}`);
    } else {
      toastr.success("Exíto");
      if (Id === undefined) {
        window.location = `${UrlPagina}servicioSistema/CompaniaEdit/${res.success.Datos.IDCia}`;
      }
    }
    ShowLoading(false);
  }

  function UpdateAgentes(value) {
    //const newAgentes = [...empresa.Agentes];
    SetEmpresa({
      ...empresa,
      Agentes: value
    });

  }


  function ChangeCheck(array, index, option, id = null) {
    array[index].Registro = !array[index].Registro;
    if (option == "Monedas") {
      SetEmpresa({
        ...empresa,
        Monedas: array
      });
    }
    if (option == "FormaPago") {
      SetEmpresa({
        ...empresa,
        FormaPago: array
      });
    }
    if (option == "SubRamos") {
      var itms = [...empresa.SubRamos];
      var itmsF = [...filteredSubRamo];
      var Indx = itms.findIndex(itm => itm.Id_SubRamo === id);
      var IndxF = itmsF.findIndex(itms => itms.Id_SubRamo === id);
      itms[Indx].Registro = !itms[Indx].Registro;
      itmsF[IndxF].Registro = !itmsF[IndxF].Registro;

      SetEmpresa({
        ...empresa,
        SubRamos: itms
      });
      setFilteredSubRamo(itmsF);
    }
  }

  async function SaveCatalogs(tipo) {
    ShowLoading();
    var Array = [];
    var Otros = [];
    var Tipo = "";
    var Id_Otro = "";
    switch (tipo) {
      case 'Monedas':
        Array = [...empresa.Monedas];
        Tipo = "Monedas";
        break;
      case 'FormaPago':
        Array = [...empresa.FormaPago];
        Tipo = "FormaPago";
        Otros = [...ConfigFMMon]
        Id_Otro = IdFM;
        break;
      case 'SubRamos':
        Array = [...empresa.SubRamos];
        Tipo = "SubRamos";
        break;
    }
    var dta = {
      "data": Array,
      "Tipo": Tipo,
      "Id": Id,
      "Otros": Otros,
      "Id_Otro": Id_Otro
    };

    const res = await CallApiPost(`${UrlServicio}catalogos/guardarRelacion`, dta, null);
    if (res.status != 200) {
      toastr.error(`Error, intente mas tarde. ${res.error}`);
    } else {
      InitialDataRegistro();
      toastr.success("Exíto");
    }
    ShowLoading(false);
  }

  async function EditConfigFM(item) {
    ShowLoading();
    var params = {
      Id: Id,
      Id_FM: item.Id_formapago
    };
    const res = await CallApiGet(`${UrlServicio}catalogos/getEmpFMMoneda`, params, null);
    if (res.status != 200) {
      toastr.error(`Error, intente mas tarde. ${res.error}`);
    } else {
      SetConfigFMMon(res.success.Datos);
    }
    ShowLoading(false);
    //SelectedFm();
    SetEditFM(true);
    SetIdFM(item.Id_formapago);

  }

  function ChangeValueFM(key, field, value) {
    var Items = [...ConfigFMMon];
    Items[key][field] = value;
    Items[key]['Id_formapago'] = IdFM;
    SetItemFM(Items);
  }

  //Funciones para los SR
  async function EditConfigSR(item) {

    SetEditSR(true);
    SetIdSR(item.IDSRamo);
    SetItemSR(item);

  }


  const handleFilterS = (event) => {
    const value = event.target.value;
    const filtered = empresa.SubRamos.filter(user => user.SubRamo.toUpperCase().includes(value.toUpperCase()));
    setFilteredSubRamo(filtered);
  };


  //variables estaticas
  const Conf1 = [{ Id: 1, Nombre: 'Inicio a Fin' }, { Id: 2, Nombre: 'Fin a Inico' }];
  const Conf2 = [{ Id: 1, Nombre: 'Subsecuentes' }, { Id: 2, Nombre: 'Acumulados' }];
  const Conf3 = [{ Id: 1, Nombre: 'Primer recibo' }, { Id: 2, Nombre: 'Proporcional' }];
  const Conf4 = [{ Id: 1, Nombre: 'Alta' }, { Id: 2, Nombre: 'Baja' }, { Id: 3, Nombre: 'Muy Alta' }, { Id: 4, Nombre: 'Normal' }, { Id: 5, Nombre: 'Opcional' }, { Id: 6, Nombre: 'Sin prioridad' }];



  return (
    <Formik
      innerRef={formikRef}
      initialValues={empresa.Compania}
      enableReinitialize="true"
      onSubmit={(values, actions) => {
        SaveData(values);
      }}
    >
      {({
        values,
        errors,
        status,
        setFieldValue,
        handleBlur,
        handleChange,
        handleSubmit,
        isSubmitting
      }) => (
        <form onSubmit={handleSubmit} className="form" autoComplete="off">
          <div className="row">
            <div className="col-md-12 text-right pt-3">
            </div>
            <div className="col-md-12 bhoechie-tab-container">
              <div className="col-lg-1 col-md-1 col-sm-1 col-xs-1 bhoechie-tab-menu">
                <div className="list-group">
                  <a href="#" className="list-group-item active text-center">
                    <h4 className="glyphicon glyphicon-file"></h4><br />General
                  </a>
                  <a href="#" className="list-group-item text-center" style={Id === undefined ? { pointerEvents: 'none' } : {}}>
                    <h4 className="glyphicon glyphicon-user"></h4><br />Agentes
                  </a>
                  <a href="#" className="list-group-item text-center" style={Id === undefined ? { pointerEvents: 'none' } : {}}>
                    <h4 className="glyphicon glyphicon-usd"></h4><br />Monedas
                  </a>
                  <a href="#" className="list-group-item text-center" style={Id === undefined ? { pointerEvents: 'none' } : {}}>
                    <h4 className="glyphicon glyphicon-credit-card"></h4><br />Formas de pago
                  </a>
                  <a href="#" className="list-group-item text-center" style={Id === undefined ? { pointerEvents: 'none' } : {}}>
                    <h4 className="glyphicon glyphicon-credit-card"></h4><br />SubRamos
                  </a>
                </div>
              </div>
              <div className="col-lg-11 col-md-11 col-sm-11 col-xs-11 bhoechie-tab">

                <div className="bhoechie-tab-content active" style={{ width: '800' }}>
                  <div className='row'>
                    <div className='col-md-12 labelSpecial'>
                      <h4>Datos Generales De La Compañia</h4>
                      <div className='btn_aling_form'>
                        <a className='btn btn-primary btn-s' data-toggle="tooltip" data-placement="bottom" title="Nuevo" onClick={() => { window.location = `${UrlPagina}servicioSistema/CompaniaAdd` }}><i className="fa fa-plus" aria-hidden="true"></i></a>
                        <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Cancelar" onClick={() => { window.location = `${UrlPagina}servicioSistema/Compania` }}><i className="fa fa-times-circle-o" aria-hidden="true"></i></a>
                        <button className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar"><i className="fa fa-floppy-o" aria-hidden="true"></i></button>
                      </div>
                      <hr />
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-6'>
                      <div className='form-group'>
                        <label>Razon Social</label>
                        <input type="text" name='CiaNombre' id='CiaNombre' className='form-control' value={values.CiaNombre ? values.CiaNombre : ''} onChange={handleChange} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Alias</label>
                        <input type="text" name='CiaAbreviacion' id='CiaAbreviacion' className='form-control' value={values.CiaAbreviacion ? values.CiaAbreviacion : ''} onChange={handleChange} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Fecha constitución</label>
                        <input type="date" name='FConstitucion' id='FConstitucion' className='form-control' value={values.FConstitucion ? values.FConstitucion : ''} onChange={handleChange} />
                      </div>
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>RFC</label>
                        <input type="text" name='RFC' id='RFC' className='form-control' value={values.RFC ? values.RFC : ''} onChange={handleChange} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Tipo de compañia</label>
                        <Select
                          placeholder="Selecione"
                          id="TCompania"
                          name="TCompania"
                          styles={colourStyles}
                          onChange={v => { setFieldValue("TCompania", v.value) }}
                          onBlur={handleBlur}
                          value={displayitem(values.TCompania, state.InitialData.TipoCompania)}
                          options={mapitems(state.InitialData.TipoCompania ? state.InitialData.TipoCompania : [], '')}
                          noOptionsMessage={() => "Sin opciones"}
                          title={"Dirección"}
                        />
                      </div>
                    </div>
                    <div className='col-md-3 col-offset-3'>
                      <div className='form-group'>
                        <label>Clasificación</label>
                        <Select
                          placeholder="Selecione"
                          id="Clasificacion"
                          name="Clasificacion"
                          styles={colourStyles}
                          onChange={v => { setFieldValue("Clasificacion", v.value) }}
                          onBlur={handleBlur}
                          value={displayitem(values.Clasificacion, state.InitialData.Clasificacion)}
                          options={mapitems(state.InitialData.Clasificacion ? state.InitialData.Clasificacion : [], '')}
                          noOptionsMessage={() => "Sin opciones"}
                          title={"Dirección"}
                        />
                      </div>
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-6'>
                      <div className='form-group'>
                        <label>Promotoria</label>
                        <Select
                          placeholder="Selecione"
                          id="Promotoria"
                          name="Promotoria"
                          styles={colourStyles}
                          onChange={v => { setFieldValue("Promotoria", v.value) }}
                          onBlur={handleBlur}
                          value={displayitem(values.Promotoria, state.InitialData.Promotoria)}
                          options={mapitems(state.InitialData.Promotoria ? state.InitialData.Promotoria : [], '')}
                          noOptionsMessage={() => "Sin opciones"}
                          title={"Dirección"}
                        />
                      </div>
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-12 labelSpecial'>
                      <h4>Configuración</h4>
                      <hr />
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-6'>
                      <div className='row'>
                        <div className='col-md-12'>
                          <div className='form-group row'>
                            <div className='col-md-3 labelSpecial'>
                              <label>Cálculo recibos de póliza</label>
                            </div>
                            <div className='col-md-9'>
                              <Select
                                placeholder="Selecione"
                                id="CalReciboPoliza"
                                name="CalReciboPoliza"
                                styles={colourStyles}
                                onChange={v => { setFieldValue("CalReciboPoliza", v.value) }}
                                onBlur={handleBlur}
                                value={displayitem(values.CalReciboPoliza, Conf1)}//state.InitialData.CalReciboPol
                                options={mapitems(Conf1 ? Conf1 : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                                title={"Dirección"}

                              />
                            </div>
                          </div>
                          <div className='form-group row'>
                            <div className='col-md-3 labelSpecial'>
                              <label>Cálculo recibos de endoso</label>
                            </div>
                            <div className='col-md-9'>
                              <Select
                                placeholder="Selecione"
                                id="CalReciboEndoso"
                                name="CalReciboEndoso"
                                styles={colourStyles}
                                onChange={v => { setFieldValue("CalReciboEndoso", v.value) }}
                                onBlur={handleBlur}
                                value={displayitem(values.CalReciboEndoso, Conf2)}//state.InitialData.CalReciboEnd
                                options={mapitems(Conf2 ? Conf2 : Conf2, [])}
                                noOptionsMessage={() => "Sin opciones"}
                                title={"Dirección"}

                              />
                            </div>
                          </div>

                          <div className='form-group row'>
                            <div className='col-md-3 labelSpecial'>
                              <label>Aplicación de descuentos</label>
                            </div>
                            <div className='col-md-9'>
                              <Select
                                placeholder="Selecione"
                                id="AplicacionDescuentos"
                                name="AplicacionDescuentos"
                                styles={colourStyles}
                                onChange={v => { setFieldValue("AplicacionDescuentos", v.value) }}
                                onBlur={handleBlur}
                                value={displayitem(values.AplicacionDescuentos, Conf3)}//state.InitialData.CalReciboPol
                                options={mapitems(Conf3 ? Conf3 : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                                //title={"Dirección"}

                              />
                            </div>
                          </div>

                          <div className='form-group row mt-1'>
                            <div className='col-md-3 labelSpecial'>
                              <label>Aplicación de recargos</label>
                            </div>
                            <div className='col-md-9'>
                              <Select
                                placeholder="Selecione"
                                id="AplicacionRecargos"
                                name="AplicacionRecargos"
                                styles={colourStyles}
                                onChange={v => { setFieldValue("AplicacionRecargos", v.value) }}
                                onBlur={handleBlur}
                                value={displayitem(values.AplicacionRecargos, Conf3)}//state.InitialData.CalReciboPol
                                options={mapitems(Conf3 ? Conf3 : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                                //title={"Dirección"}

                              />
                            </div>
                          </div>

                          <div className='form-group row mt-3'>
                            <div className='col-md-3 labelSpecial'>
                              <label>Aplicación de derechos</label>
                            </div>
                            <div className='col-md-9'>
                              <Select
                                placeholder="Selecione"
                                id="AplicacionDerechos"
                                name="AplicacionDerechos"
                                styles={colourStyles}
                                onChange={v => { setFieldValue("AplicacionDerechos", v.value) }}
                                onBlur={handleBlur}
                                value={displayitem(values.AplicacionDerechos, Conf3)}//state.InitialData.CalReciboPol
                                options={mapitems(Conf3 ? Conf3 : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                                title={"Dirección"}

                              />
                            </div>
                          </div>

                          <div className='form-group row mt-3'>
                            <div className='col-md-3 labelSpecial'>
                              <label>Prioriodad</label>
                            </div>
                            <div className='col-md-9'>
                              <Select
                                placeholder="Selecione"
                                id="Prioridad"
                                name="Prioridad"
                                styles={colourStyles}
                                onChange={v => { setFieldValue("Prioridad", v.value) }}
                                onBlur={handleBlur}
                                value={displayitem(values.Prioridad, Conf4)}//state.InitialData.CalReciboPol
                                options={mapitems(Conf4 ? Conf4 : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                                title={"Dirección"}

                              />
                            </div>
                          </div>

                          <div className='form-group row mt-3'>
                            <p></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div className='col-md-6'>
                      <div className='row'>
                        <div className='col-md-12'>
                          <div className='form-group row'>
                            <div className='col-md-6 label_especial'>
                              <label>Dias pago 1er recibo</label>
                            </div>
                            <div className='col-md-3 labelSpecial'>
                              <label>Nueva</label>
                              <input type="text" className='form-control numeric' name='DPPRN' id='DPPRN' value={values.DPPRN ? values.DPPRN : ''} onChange={handleChange} />
                            </div>
                            <div className='col-md-3 labelSpecial'>
                              <label>Renovación</label>
                              <input type="text" className='form-control numeric' name='DPPRR' id='DPPRR' value={values.DPPRR ? values.DPPRR : ''} onChange={handleChange} />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div className='row'>
                        <div className='col-md-12'>
                          <div className='form-group row'>
                            <div className='col-md-6 label_especial_down'>
                              <label>Dias pago subsecuente</label>
                            </div>
                            <div className='col-md-3'>
                              <input type="text" className='form-control numeric' name='DPRSN' id='DPRSN' value={values.DPRSN ? values.DPRSN : ''} onChange={handleChange} />
                            </div>
                            <div className='col-md-3'>
                              <input type="text" className='form-control numeric' name='DPRSR' id='DPRSR' value={values.DPRSR ? values.DPRSR : ''} onChange={handleChange} />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                {/* tab de Agentes */}
                <Agentes UrlServicio={UrlServicio} UpdateAgentes={UpdateAgentes} Agentes={empresa.Agentes} SetEmpresa={SetEmpresa} empresa={empresa} Catalogos={state.InitialData} />

                <div className="bhoechie-tab-content">
                  <div className='row'>
                    <div className='col-md-12 labelSpecial'>
                      <h4>Monedas</h4>
                      <div className='btn_aling_form'>
                        <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar Monedas" onClick={() => SaveCatalogs('Monedas')}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                      </div>
                      <hr />
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-12'>
                      <p>Seleccione la moneda</p>
                    </div>
                    <div className='col-md-12 table-wrapper'>
                      <table className="table" id="polizas">
                        <thead style={{ fontSize: '12px' }}>
                          <tr>
                            <th scope="col" style={{ width: '100px' }}>Nombre</th>
                            <th scope="col" style={{ width: '100px', textAlign: 'center' }}>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          {empresa.Monedas.length == 0 && (
                            <tr>
                              <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                            </tr>
                          )}
                          {empresa.Monedas && empresa.Monedas.map((item, key) => (
                            <tr key={key}>
                              <td>{item.Moneda}</td>
                              <td className='text-center'>
                                <input checked={item.Registro ? true : false} type="checkbox" name={item.Moneda} id={item.Moneda} value={item.Registro ? item.Registro : ''} onChange={() => ChangeCheck(empresa.Monedas, key, 'Monedas')} />
                              </td>
                            </tr>
                          ))}
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div className="bhoechie-tab-content">
                  <div className='row'>
                    <div className='col-md-12 labelSpecial'>
                      <h4>Formas de pagos</h4>
                      <div className='btn_aling_form'>
                        <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar Monedas" onClick={() => SaveCatalogs('FormaPago')}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                      </div>
                      <hr />
                    </div>
                  </div>
                  <div className='row'>

                    <div className='col-md-6' style={{ height: '400px', overflow: 'auto' }}>
                      <div className='col-md-12'>
                        <p>Seleccione las formas de pago</p>
                      </div>
                      <div className='col-md-12 table-wrapper'>
                        <table className="table" id="polizas">
                          <thead style={{ fontSize: '12px' }}>
                            <tr>
                              <th scope="col" style={{ width: '100px' }}>Nombre</th>
                              <th scope="col" style={{ width: '100px', textAlign: 'center' }}>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            {empresa.FormaPago.length == 0 && (
                              <tr>
                                <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                              </tr>
                            )}
                            {empresa.FormaPago && empresa.FormaPago.map((item, key) => (
                              <tr key={key} style={IdFM === item.Id_formapago ? { backgroundColor: '#5A55A3', color: 'white' } : { backgroundColor: 'unset' }}>
                                <td> {item.FormaPago}</td>
                                <td className='text-center'>
                                  <div className='row'>
                                    <div className='col-md-6'>
                                      <input onClick={() => ChangeCheck(empresa.FormaPago, key, 'FormaPago')} type="checkbox" checked={item.Registro ? true : false} name={item.FormaPago} id={item.FormaPago} value={item.Registro ? item.Registro : ''} onChange={() => ''} />
                                    </div>
                                    <div className='col-md-6'>
                                      {item.IDBD && (
                                        <a className='btn btn-xs btn-primary' onClick={() => EditConfigFM(item)}>
                                          <i className="fa fa-cog" aria-hidden="true"></i>
                                        </a>
                                      )}
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            ))}
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div className='col-md-6'>
                      {EditFM && (
                        <div className='row'>
                          <div className='col-md-12'>
                            <p>Configuración formas de pago</p>
                          </div>
                          <div className='col-md-12'>
                            <div className='col-md-4'>
                              <div className='form-group'>
                                <label htmlFor="">Tipo de calculo</label>
                                <input disabled type="text" value={"TRADICIONAL"} className='form-control' onChange={() => ''} />
                              </div>
                            </div>
                            <div className='col-md-8'>
                              <table className="table" id="configFormadePago">
                                <thead style={{ fontSize: '12px' }}>
                                  <tr>
                                    <th scope="col" style={{ width: '100px' }}>MONEDA</th>
                                    <th scope="col" style={{ width: '100px', textAlign: 'center' }}>% Recargos</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  {ConfigFMMon.length == 0 && (
                                    <tr>
                                      <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                                    </tr>
                                  )}
                                  {ConfigFMMon && ConfigFMMon.map((item, key) => (
                                    <tr key={key}>
                                      <td> {item.Moneda}</td>
                                      <td className='text-center'>
                                        <input type="text" className='form-control numeric' name={item.Moneda} id={item.Moneda} value={item.recargo ? item.recargo : '0'} onChange={(e) => ChangeValueFM(key, 'recargo', e.target.value)} />
                                      </td>
                                    </tr>
                                  ))}
                                </tbody>
                              </table>

                            </div>
                          </div>
                        </div>
                      )}
                    </div>
                  </div>
                </div>

                <div className="bhoechie-tab-content">
                  <div className='row'>
                    <div className='col-md-12 labelSpecial'>
                      <h4>Sub Ramos</h4>
                      <div className='btn_aling_form'>
                        <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar Monedas" onClick={() => SaveCatalogs('SubRamos')}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>

                      </div>
                      <hr />
                    </div>
                  </div>
                  <div className='row'>

                    <div className='col-md-6' style={{ height: '400px', overflow: 'auto' }}>
                      <div className='col-md-12'>
                        <p>Seleccione los Sub Ramos</p>
                      </div>
                      <div className='col-md-12' style={{ marginTop: '15px' }}>
                        <div className='row'>
                          <div className='col-md-6 labelSpecial'>
                            <p>Subramos</p>
                          </div>
                          <div className='col-md-6'>
                            <div className='form-goup pb-3'>
                              <input type="text" className='form-control input-sm' placeholder='Buscar' onChange={(e) => handleFilterS(e)} />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div className='col-md-12 table-wrapper'>
                        <table className="table" id="polizas">
                          <thead style={{ fontSize: '12px' }}>
                            <tr>
                              <th scope="col" style={{ width: '100px' }}>Nombre</th>
                              <th scope="col" style={{ width: '100px', textAlign: 'center' }}>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            {filteredSubRamo.length == 0 && (
                              <tr>
                                <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                              </tr>
                            )}
                            {filteredSubRamo && filteredSubRamo.map((item, key) => (
                              <tr key={key}>
                                <td>{item.SubRamo}</td>
                                <td className='text-center'>
                                  <div className='row'>
                                    <div className='col-md-6'>
                                      <input onClick={() => ChangeCheck(filteredSubRamo, key, 'SubRamos', item.Id_SubRamo)} checked={item.Registro ? true : false} type="checkbox" name={item.SubRamo} id={item.SubRamo} value={item.Registro ? item.Registro : ''} onChange={() => ''} />
                                    </div>
                                    <div className='col-md-6'>
                                      {item.IDBD && (
                                        <a className='btn btn-xs btn-primary' onClick={() => EditConfigSR(item)}>
                                          <i className="fa fa-cog" aria-hidden="true"></i>
                                        </a>
                                      )}
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            ))}
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div className='col-md-6'>
                      {EditSR && (
                        <div className='row'>
                          <div className='col-md-12'>
                            <p>Configuracion del Sub Ramos: {ItemSR.SubRamo}</p>
                          </div>
                          <div className='col-md-12'>
                            <a className='btn btn-md btn-primary' onClick={() => SetConfigO(1)}><i className="fa fa-file-o" aria-hidden="true"></i> Derechos</a>
                            <a className='btn btn-md btn-primary' onClick={() => SetConfigO(3)}><i className="fa fa-file-o" aria-hidden="true"></i> Prima mínima</a>
                            <a className='btn btn-md btn-primary' onClick={() => { childrenRef.current.Reload(), $("#menu").css("z-index", '-1'); $('#ModalComisiones').modal('show') }}><i className="fa fa-file-o" aria-hidden="true"></i> Comisiones</a>
                            {values.TCompania == 2 && (
                              <a className='btn btn-md btn-primary' onClick={() => { $('#ModalProductos').modal('show') }}><i className="fa fa-file-o" aria-hidden="true"></i> Productos</a>
                            )}
                          </div>
                          <div className='col-md-12'>
                            {ConfigO == 1 && (
                              <Derechos Url={UrlServicio} SubRamo={ItemSR.Id_SubRamo} Empresa={Id} Monedas={empresa.Monedas} />
                            )}
                            {ConfigO == 3 && (
                              <PrimaMin Url={UrlServicio} SubRamo={ItemSR.Id_SubRamo} Empresa={Id} Monedas={empresa.Monedas} />
                            )}
                            <Comisiones ref={childrenRef} Url={UrlServicio} SubRamo={ItemSR.Id_SubRamo} Empresa={Id} Monedas={empresa.Monedas} />
                            <Productos Url={UrlServicio} SubRamo={ItemSR.Id_SubRamo} Empresa={Id} />
                          </div>
                        </div>
                      )}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      )}
    </Formik>
  )
}
