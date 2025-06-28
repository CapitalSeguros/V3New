import React, { useState, useEffect, useRef } from 'react';
import Select from "react-select";
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { mapitems, displayitem, mapitemsHijos, colourStyles } from '../../Helpers/FGeneral.js';
import CurrencyInputField from 'react-currency-input-field';

export default function Honorarios(props) {
  const { Url, Vendedor, Monedas } = props;
  const LoggedUser = window.jQuery("#Usuario").val();
  const Comisiones = [
    {
      Nombre: 'Honorario base o de Neta',
      Id: 1
    },
    {
      Nombre: 'Honorario Adicional',
      Id: 2
    }//Honorario Derecho
    ,
    {
      Nombre: 'Honorario Derecho',
      Id: 3
    }//
  ];

  const FComisiones = [
    {
      Nombre: 'Honorarios base o neta',
      Id: 1
    },
    {
      Nombre: 'Honorario base vend S/comision total',
      Id: 2
    },
    {
      Nombre: 'Honorarios derecho y recargos',
      Id: 3
    },
    {
      Nombre: 'Honorario derecho maquila',
      Id: 4
    }
  ];
  const [state, Setstate] = useState({
    Moneda: '',
    Comsion: '',
    OpcionComision: 0
  });
  const [item, SetItem] = useState({
    Id: 0,
    Importe: 0,
    Tipo: 0,
    Id_moneda: 0,
    Registros: [],
    Vendedores: [],
    SubRamos: [],
    Subgrupos: [],
    Clientes: [],
    AllClientes: [],
    DeleteItems: []
  });

  const [filteredVend, setFilteredVend] = useState([]);
  const [filteredSubRamo, setFilteredSubRamo] = useState([]);
  const [filteredSubgrupos, setFilteredSubgrupos] = useState([]);
  const [filteredClientes, setFilteredClientes] = useState([]);


  useEffect(() => {
    getConfigComisiones();
  }, [state.Moneda, state.Comsion]);

  function ChangeEdit(index, valor) {
    var itms = [...item.Registros];
    itms[index].IsEdit = valor;
    //console.log("Elementos", itms);
    SetItem({ ...item, Registros: itms });
  }
  const FocusInput = (e) => {
    e.target.select();
  }



  function ChangeValueRecibo(index, field, value) {
    const elm = [...item.Registros];
    elm[index][field] = value;
    SetItem({
      ...item,
      Registros: elm
    });
  }

  function NuevoElemento() {
    if (state.Moneda == '') {
      toastr.error(`Seleccione una Moneda.`);
      return;
    }

    if (state.Comsion == '') {
      toastr.error(`Seleccione una Comisión.`);
      return;
    }


    var Items = [...item.Registros];
    Items.push({
      Desde: 0,
      Hasta: 0,
      Porcentaje: 0,
      Formula_Porcentaje: '',
      Formula_Importe: ''
    });
    SetItem({
      ...item,
      Registros: Items,
      Agentes: []
    });
  }

  function deleteItem(key) {
    var Itms = [...item.Registros];
    var Del = [...item.DeleteItems];
    Del.push(Itms[key]);
    Itms.splice(key, 1);
    SetItem({
      ...item,
      Registros: Itms,
      DeleteItems: Del,
      Agentes: []
    });


    setFilteredClientes([]);
    setFilteredSubRamo([]);
    setFilteredSubgrupos([]);
    setFilteredVend([]);

  }

  async function getConfigComisiones() {
    if (state.Moneda != '' && state.Comsion != '') {
      var params = {
        Id: Vendedor,
        Id_M: state.Moneda,
        IdH: state.Comsion,
      };
      const res = await CallApiGet(`${Url}catalogos/getConfigHonorarios`, params, null);
      if (res.status != 200) {
        toastr.error(`Error, intente mas tarde. ${res.error}`);
      } else {
        SetItem({
          ...item,
          Registros: res.success.Datos,
          Agentes: []
        });
        setFilteredSubRamo([]);
        setFilteredVend([]);
        setFilteredSubgrupos([]);
        setFilteredClientes([]);
        //toastr.success("Exíto");
        //SetItem(res.success.Datos);
      }
    }
  }

  async function Guardar() {
    var params = {
      Id: Vendedor,
      Id_M: state.Moneda,
      IdF: state.Comsion,
      IdConfig: state.OpcionComision,
      Items: item.Registros,
      Agentes: item.Vendedores,
      SubRamos: item.SubRamos,
      Subgrupos: item.Subgrupos,
      Clientes: item.AllClientes,
      DeleteItem: item.DeleteItems,
      Usuario: LoggedUser
    };
    const res = await CallApiPost(`${Url}catalogos/saveConfigHonorarios`, params, null);
    if (res.status != 200) {
      console.log(res.error);
      toastr.error(`${res.error.Mensaje}`);
    } else {
      //console.log(res.success.Datos);
      let Cppy = { ...item };
      Cppy.Registros = res.success.Datos;
      //console.log("Copia",Cppy);
      SetItem(Cppy);
      //getAgentes(state.OpcionComision ? state.OpcionComision : null);
      toastr.success("Exíto");
      //SetItem(res.success.Datos);
    }
  }

  async function getAgentes(IdConfig) {
    Setstate({
      ...state,
      OpcionComision: IdConfig
    });

    var params = {
      Id: IdConfig,
      Id_Vend: Vendedor
    };
    const res = await CallApiGet(`${Url}catalogos/getAllInfoHonorarios`, params, null);
    if (res.status != 200) {
      toastr.error(`Error, intente mas tarde. ${res.error}`);
    } else {
      setFilteredVend(res.success.Datos.Vendedores);
      setFilteredSubRamo(res.success.Datos.SubRamos);
      setFilteredSubgrupos(res.success.Datos.Subgrupos);
      //setFilteredClientes(res.success.Datos.Clientes);
      SetItem({
        ...item,
        Vendedores: res.success.Datos.Vendedores,
        SubRamos: res.success.Datos.SubRamos,
        Subgrupos: res.success.Datos.Subgrupos,
        AllClientes: res.success.Datos.Clientes
        //Clientes: res.success.Datos.Clientes
      });
      //toastr.success("Exíto");
    }
  }

  function ChangeEditCheck(index, valor, id) {
    var itms = [...item.SubRamos];
    var itmsF = [...filteredSubRamo];

    var Indx = itms.findIndex(itm => itm.Id === id);
    var IndxF = itmsF.findIndex(itms => itms.Id === id);

    if (itms[Indx].Selected != null) {
      itms[Indx].Selected = null;
    } else {
      itms[Indx].Selected = valor;
    }
    //itms[index].Id_config = valor;
    setFilteredSubRamo(itms);
    SetItem({ ...item, SubRamos: itms });
  }

  function ChangeEditACheck(index, valor, id) {
    var itms = [...item.Vendedores];
    var itmsF = [...filteredVend];

    var Indx = itms.findIndex(itm => itm.IDVend === id);
    var IndxF = itmsF.findIndex(itms => itms.IDVend === id);

    if (itms[Indx].Selected != null) {
      itms[Indx].Selected = null;
    } else {
      itms[Indx].Selected = valor;
    }
    setFilteredVend(itmsF);
    SetItem({ ...item, Vendedores: itms });
  }

  function ChangeEditSub(index, valor, id) {
    var itms = [...item.Subgrupos];
    var itmsF = [...filteredSubgrupos];

    var Indx = itms.findIndex(itm => itm.Id === id);
    var IndxF = itmsF.findIndex(itms => itms.Id === id);

    if (itms[Indx].Selected != null) {
      itms[Indx].Selected = null;
    } else {
      itms[Indx].Selected = valor;
    }
    setFilteredSubgrupos(itmsF);
    SetItem({ ...item, Subgrupos: itms });
  }

  async function ChangeEditClientes(index, valor, id, Accion) {
    var params = {
      Id: valor,
      Cliente: id,
      Accion: Accion
    };
    const res = await CallApiPost(`${Url}catalogos/saveInfoHonCliente`, params, null);
    if (res.status != 200) {
      toastr.error(`Error, intente mas tarde. ${res.error}`);
    } else {
      var itms = [...item.Clientes];
      var itmsF = [...filteredClientes];

      var Indx = itms.findIndex(itm => itm.Id === id);
      var IndxF = itmsF.findIndex(itms => itms.Id === id);

      if (itms[Indx].Selected != null) {
        itms[Indx].Selected = null;
      } else {
        itms[Indx].Selected = valor;
      }
      setFilteredClientes(itmsF);
      SetItem({ ...item, Clientes: itms });
    }

  }

  async function ChangeEditClientesV2(index, valor, id, Accion) {
    var cppy = [...item.AllClientes];
    let Arr = [];
    if (!Accion) {
      Arr = cppy.filter(function (item) {
        return item.IDCliente !== id;
      });
    }
    else {
      Arr = cppy;
      Arr.push({ Id_vendedorhonorario: state.OpcionComision, IDCliente: id });
    }

    SetItem({ ...item, AllClientes: Arr });



  }

  const handleFilter = (event) => {
    const value = event.target.value;
    const filtered = item.Vendedores.filter(user => user.Nombre.toUpperCase().includes(value.toUpperCase()));
    setFilteredVend(filtered);
  };
  const handleFilterS = (event) => {
    const value = event.target.value;
    const filtered = item.SubRamos.filter(user => user.Nombre.toUpperCase().includes(value.toUpperCase()));
    setFilteredSubRamo(filtered);
  };

  const handleFilterSub = (event) => {
    const value = event.target.value;
    const filtered = item.Subgrupos.filter(user => user.Nombre.toUpperCase().includes(value.toUpperCase()));
    setFilteredSubgrupos(filtered);
  };

  const handleFilterCli = async (event) => {
    var params = {
      Id: state.OpcionComision,
      Id_Vend: Vendedor,
      text: event.target.value
    };
    const res = await CallApiGet(`${Url}catalogos/getAllInfoHonorariosClientes`, params, null);
    if (res.status != 200) {
      toastr.error(`Error, intente mas tarde. ${res.error}`);
    } else {
      setFilteredClientes(res.success.Datos);
      SetItem({
        ...item,
        Clientes: res.success.Datos
      });
    }
    //const value = event.target.value;
    //const filtered = item.Clientes.filter(user => user.Nombre.toUpperCase().includes(value.toUpperCase()));
    //setFilteredClientes(filtered);
  };

  function GetFormula(Id) {
    //console.log(Id)
    var find = FComisiones.find(itm => itm.Id === parseInt(Id));
    //console.log(find);
    if (find) {
      return find.Nombre
    }
    return 'N/A';
  }

  function SelectAll(Accion, valor) {
    var ccp = [];
    switch (Accion) {
      case 'SubRamos':
        ccp = [...filteredSubRamo]
        ccp.forEach(element => {
          element.Selected = valor ? state.OpcionComision : null;
        });
        setFilteredSubRamo(ccp);
        break;
      case 'Vendedores':
        ccp = [...filteredVend]
        ccp.forEach(element => {
          element.Selected = valor ? state.OpcionComision : null;
        });
        setFilteredVend(ccp);
        break;
      case 'SubGrupo':
        ccp = [...filteredSubgrupos]
        ccp.forEach(element => {
          element.Selected = valor ? state.OpcionComision : null;
        });
        setFilteredSubgrupos(ccp);
        break;
      case 'Clientes':
        ccp = [...filteredClientes]
        ccp.forEach(element => {
          element.Selected = valor ? state.OpcionComision : null;
        });
        setFilteredClientes(ccp);
        break;
    }
  }

  return (
    <div id="ModalHonorarios" className="modal fade" role="dialog">
      <div className="modalLarge modal-dialog modal-lg ">
        <div className="modal-content">
          <div className='modal-body'>
            <div className='row'>
              <div className='col-md-12'>
                <button type="button" className="close" data-dismiss="modal">&times;</button>
              </div>
              <div className='col-md-12 labelSpecial'>
                <h4 >Configuración de Honorarios</h4>

              </div>
            </div>
            <div className='row'>
              <div className='col-md-2 labelSpecial'>
                <p>Monedas</p>
                <div className='row styleMonedas'>
                  {Monedas && Monedas.map((item, key) => (
                    <div key={key} className={state.Moneda == item.Id ? 'col-md-12 pt-3 pb-3 selectItemGAP' : 'col-md-12 pt-3 pb-3'} style={{ 'cursor': 'pointer' }} onClick={() => Setstate({ ...state, Moneda: item.Id })}>
                      {item.Nombre}
                    </div>
                  ))}
                </div>
              </div>
              <div className='col-md-2 labelSpecial'>
                <p>Comisiones</p>
                <div className='row'>
                  {Comisiones && Comisiones.map((item, key) => (
                    <div key={key} className={state.Comsion == item.Id ? 'col-md-12 pt-3 pb-3 selectItemGAP' : 'col-md-12 pt-3 pb-3'} style={{ 'cursor': 'pointer' }} onClick={() => Setstate({ ...state, Comsion: item.Id })}>
                      {item.Nombre}
                    </div>
                  ))}
                </div>
              </div>
              <div className='col-md-8'>
                <div className='row'>
                  <div className='col-md-6 labelSpecial'>
                    <p>Configuración de Honorarios</p>
                  </div>
                  <div className='col-md-6 text-right'>
                    {/* <a onClick={() => console.log(state)}>test</a> */}
                    <a className='btn btn-xs btn-primary mr-2' onClick={() => NuevoElemento()}><i className="fa fa-plus" aria-hidden="true"></i> Nuevo</a>
                    <a className='btn btn-xs btn-primary' onClick={() => Guardar()}><i className="fa fa-floppy-o" aria-hidden="true"></i> Guardar</a>
                    {/* <a className='btn' onClick={() => console.log(item.Registros)}> etststs</a> */}
                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-12 container_tabla_honorarios_vendedor'>

                    <table className="table StylesTables" id="polizas">
                      <thead style={{ fontSize: '12px' }}>
                        <tr>
                          <th scope="col" style={{ width: '100px' }}>Desde</th>
                          <th scope="col" style={{ width: '100px' }}>Hasta</th>
                          <th scope="col" style={{ width: '100px' }}>Porcentaje</th>
                          <th scope="col" style={{ width: '100px' }}>Formula $</th>
                          <th scope="col" style={{ width: '100px' }}>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        {item.Registros.length == 0 && (
                          <tr>
                            <td className='text-center' colSpan={19}>NO SE HAN REGISTRADO</td>
                          </tr>
                        )}
                        {item.Registros && item.Registros.map((itm, key) => (
                          (itm.IsEdit === true ?
                            <tr key={key} className={state.OpcionComision === itm.Id ? 'selectItemGAP' : ''}>
                              <td>
                                <CurrencyInputField
                                  className='form-control input-sm numeric'
                                  style={{ width: '80px' }}
                                  //onBlur={handleBlur}
                                  min={0}
                                  maxLength={10}
                                  prefix=''
                                  decimalSeparator='.'
                                  groupSeparator=','
                                  onFocus={FocusInput}
                                  allowNegativeValue={false}
                                  value={itm.Desde}
                                  onValueChange={(value, name) => ChangeValueRecibo(key, 'Desde', value)}
                                  id='Desde'
                                  name='Desde'
                                  autoComplete='off'
                                />
                              </td>
                              <td>
                                <CurrencyInputField
                                  className='form-control input-sm numeric'
                                  style={{ width: '80px' }}
                                  //onBlur={handleBlur}
                                  min={0}
                                  maxLength={10}
                                  prefix=''
                                  decimalSeparator='.'
                                  groupSeparator=','
                                  onFocus={FocusInput}
                                  allowNegativeValue={false}
                                  value={itm.Hasta}
                                  onValueChange={(value, name) => ChangeValueRecibo(key, 'Hasta', value)}
                                  id='Hasta'
                                  name='Hasta'
                                  autoComplete='off'
                                />
                              </td>
                              <td>
                                <CurrencyInputField
                                  className='form-control input-sm numeric'
                                  style={{ width: '80px' }}
                                  //onBlur={handleBlur}
                                  min={0}
                                  maxLength={10}
                                  prefix=''
                                  decimalSeparator='.'
                                  groupSeparator=','
                                  onFocus={FocusInput}
                                  allowNegativeValue={false}
                                  value={itm.Porcentaje}
                                  onValueChange={(value, name) => ChangeValueRecibo(key, 'Porcentaje', value)}
                                  id='Cantidad'
                                  name='Cantidad'
                                  autoComplete='off'
                                />
                              </td>
                              <td>
                                <select name="Formula_Importe" id="Formula_Importe" className='form-control' value={itm.Formula_Importe ? itm.Formula_Importe : ''} onChange={(e) => ChangeValueRecibo(key, e.target.name, e.target.value)}>
                                  <option value="">Seleccione una Opción</option>
                                  {FComisiones && FComisiones.map((item, key) => (
                                    <option key={key} value={item.Id}>{item.Nombre}</option>
                                  ))}
                                </select>
                              </td>
                              <td style={{ display: 'inline-flex' }}>
                                <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key, false)} data-toggle="tooltip" data-placement="bottom" title="Cancelar edicion"><i className="fa fa-times" aria-hidden="true"></i></a>
                              </td>
                            </tr> :
                            <tr key={key} className={state.OpcionComision === itm.Id ? 'selectItemGAP' : ''}>
                              <td>{itm.Desde}</td>
                              <td>{itm.Hasta}</td>
                              <td>{itm.Porcentaje}</td>
                              <td>{itm.Formula_Importe ? GetFormula(itm.Formula_Importe) : 'N/A'}</td>
                              <td style={{ display: 'inline-flex' }}>
                                <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key, true)} data-toggle="tooltip" data-placement="bottom" title="Editar"><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                <a className='btn btn-primary btn-sm' onClick={() => deleteItem(key)} data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i className="fa fa-trash-o" aria-hidden="true"></i></a>
                                <a className='btn btn-primary btn-sm' disabled={itm.Id == undefined ? true : false} onClick={() => getAgentes(itm.Id)} data-toggle="tooltip" data-placement="bottom" title="Configuraciones"><i className="fa fa-cogs" aria-hidden="true"></i></a>
                              </td>
                            </tr>)
                        ))}
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
            </div>
            <div className='row'>
              <div className='col-md-6'>
                <div className='row'>
                  <div className='col-md-12' style={{ marginTop: '15px' }}>
                    <div className='row'>
                      <div className='col-md-6 labelSpecial'>
                        <p>Subramos</p>
                      </div>
                      <div className='col-md-6'>
                        <div className='form-goup pb-3'>
                          <input type="text" className='form-control input-sm' disabled={item.Registros.length > 0 ? false : true} placeholder='Buscar' onChange={(e) => handleFilterS(e)} />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className='col-md-12 table-wrapper'>
                    <table className="table" id="polizas">
                      <thead style={{ fontSize: '12px' }}>
                        <tr>
                          <th scope="col" style={{ width: '100px' }}>Nombre</th>
                          <th scope="col" style={{ width: '100px' }}>Acciones <input style={{ marginLeft: '3.5vw' }} type="checkbox" onChange={(e) => SelectAll("SubRamos", e.target.checked)} /></th>
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
                            <td>{item.Nombre}</td>
                            <td className='text-center'>
                              <input type="checkbox" value={item.Selected != null ? item.Selected : ''} checked={item.Selected != null ? true : false} onChange={() => ChangeEditCheck(key, state.OpcionComision, item.Id)} />
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
              <div className='col-md-6'>
                <div className='row'>
                  <div className='col-md-12' style={{ marginTop: '15px' }}>
                    <div className='row'>
                      <div className='col-md-6 labelSpecial'>
                        <p>Vendedores</p>
                      </div>
                      <div className='col-md-6'>
                        <div className='form-goup pb-3'>
                          <input type="text" className='form-control input-sm' disabled={item.Registros.length > 0 ? false : true} placeholder='Buscar' onChange={(e) => handleFilter(e)} />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className='col-md-12 table-wrapper' >
                    <table className="table" id="polizas">
                      <thead style={{ fontSize: '12px' }}>
                        <tr>
                          <th scope="col" style={{ width: '100px' }}>Nombre</th>
                          <th scope="col" style={{ width: '100px' }}>Acciones <input style={{ marginLeft: '3.5vw' }} type="checkbox" onChange={(e) => SelectAll("Vendedores", e.target.checked)} /></th>
                        </tr>
                      </thead>
                      <tbody>
                        {filteredVend.length == 0 && (
                          <tr>
                            <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                          </tr>
                        )}
                        {filteredVend && filteredVend.map((item, key) => (
                          <tr key={key}>
                            <td>{item.Nombre}</td>
                            <td className='text-center'>
                              <input type="checkbox" value={item.Selected != null ? item.Selected : ''} checked={item.Selected != null ? true : false} onChange={() => ChangeEditACheck(key, state.OpcionComision, item.IDVend)} />
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>
            <div className='row'>
              <div className='col-md-6'>
                <div className='row'>
                  <div className='col-md-12' style={{ marginTop: '15px' }}>
                    <div className='row'>
                      <div className='col-md-6 labelSpecial'>
                        <p>Subgrupo</p>
                      </div>
                      <div className='col-md-6'>
                        <div className='form-goup pb-3'>
                          <input type="text" className='form-control input-sm' disabled={item.Registros.length > 0 ? false : true} placeholder='Buscar' onChange={(e) => handleFilterSub(e)} />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className='col-md-12 table-wrapper'>
                    <table className="table" id="polizas">
                      <thead style={{ fontSize: '12px' }}>
                        <tr>
                          <th scope="col" style={{ width: '100px' }}>Nombre</th>
                          <th scope="col" style={{ width: '100px' }}>Acciones <input style={{ marginLeft: '3.5vw' }} type="checkbox" onChange={(e) => SelectAll("SubGrupo", e.target.checked)} /></th>
                        </tr>
                      </thead>
                      <tbody>
                        {filteredSubgrupos.length == 0 && (
                          <tr>
                            <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                          </tr>
                        )}
                        {filteredSubgrupos && filteredSubgrupos.map((item, key) => (
                          <tr key={key}>
                            <td>{item.Nombre}</td>
                            <td className='text-center'>
                              <input type="checkbox" value={item.Selected != null ? item.Selected : ''} checked={item.Selected != null ? true : false} onChange={() => ChangeEditSub(key, state.OpcionComision, item.Id)} />
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
              <div className='col-md-6'>
                <div className='row'>
                  <div className='col-md-12' style={{ marginTop: '15px' }}>
                    <div className='row'>
                      <div className='col-md-6 labelSpecial'>
                        <p>Clientes</p>
                      </div>
                      <div className='col-md-6'>
                        <div className='form-goup pb-3'>
                          <input type="text" className='form-control input-sm' disabled={item.Registros.length > 0 ? false : true} placeholder='Buscar' onChange={(e) => handleFilterCli(e)} />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className='col-md-12 table-wrapper' >
                    {/* <a onClick={() => [console.log(item.AllClientes)]}>tststststst</a> */}
                    <table className="table" id="polizas">
                      <thead style={{ fontSize: '12px' }}>
                        <tr>
                          <th scope="col" style={{ width: '100px' }}>Nombre</th>
                          <th scope="col" style={{ width: '100px' }}>Acciones <input style={{ marginLeft: '3.5vw' }} type="checkbox" onChange={(e) => SelectAll("Clientes", e.target.checked)} /></th>
                        </tr>
                      </thead>
                      <tbody>
                        {filteredClientes.length == 0 && (
                          <tr>
                            <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                          </tr>
                        )}
                        {filteredClientes && filteredClientes.map((itm, key) => (
                          <tr key={key}>
                            <td>{itm.Nombre}</td>
                            <td className='text-center'>
                              {/* <a onClick={() => [console.log("ITEMSEKECT",itm.Id)]}>tststststst</a> */}
                              <input type="checkbox" value={itm.Id != null ? itm.Id : ''} checked={item.AllClientes.find(x => parseInt(x.IDCliente) == parseInt(itm.Id)) ? true : false} onChange={(e) => ChangeEditClientesV2(key, state.OpcionComision, itm.Id, e.target.checked)} />
                              {/*  <input type="checkbox" value={item.Selected != null ? item.Selected : ''} checked={item.Selected != null ? true : false} onChange={(e) => ChangeEditClientes(key, state.OpcionComision, item.Id, e.target.checked)} /> */}
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
