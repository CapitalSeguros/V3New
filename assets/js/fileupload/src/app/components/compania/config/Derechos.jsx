import React, { useState, useEffect, useRef } from 'react';
import { CallApiGet, CallApiPost } from '../../../Helpers/Calls.js';
import { mapitems, mapitemsHijos, displayitem, colourStyles } from '../../../Helpers/FGeneral.js';

export default function Derechos(props) {
    const { Url, SubRamo, Empresa, Monedas } = props;
    const [state, Setstate] = useState([]);
    const [ItemM, SetItemM] = useState([]);
    const [clicM, SetIClickM] = useState(0);
    const [item, SetItem] = useState({
        Id: 0,
        Importe: 0
    });

    async function GetDerechos(item) {
        SetItemM(item);
        SetIClickM(item.Id_moneda);
        var params = {
            Id: Empresa,
            Id_SR: SubRamo,
            Id_M: item.Id_moneda,
            Tipo: "DERECHOS"
        };
        const res = await CallApiGet(`${Url}catalogos/getConfiguracionesSR`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            SetItem(res.success.Datos);
        }
    }

    async function SaveDerechos() {
        if(item.Id_moneda==undefined){
            return toastr.error(`Seleccione una moneda.`);
        }

        var params = {
            Id: Empresa,
            Id_SR: SubRamo,
            Id_M: item.Id_moneda,
            Tipo: "DERECHOS",
            Importe: item.Importe,
            IdRow: item.Id
        };
        //console.log("Parametros",params)
        const res = await CallApiPost(`${Url}catalogos/saveConfiguracionesSR`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            toastr.success("Exíto");
            //SetItem(res.success.Datos);
        }
    }

    function changeItem(e) {
        SetItem({
            ...item,
            [e.target.name]: e.target.value
        });
    }

    return (
        <div className='row'>
            <div className='col-md-12'>
                <h4>Configuración de comisiones</h4>
            {/*     <a onClick={()=>console.log(clicM)}>test</a> */}
            </div>
            <div className='col-md-12'>
                <div className='row'>
                    <div className='col-md-4'>
                        <p>Monedas utilizadas</p>
                        <div className='row'>
                            {Monedas && Monedas.map((itm, key) => (
                                <div key={key} className='col-md-12 pt-3 pb-3' style={clicM === itm.Id_moneda ? { backgroundColor: '#5A55A3', color: 'white',cursor: 'pointer' } : { backgroundColor: 'unset',cursor: 'pointer'  }}>
                                    <a onClick={()=>GetDerechos(itm)}>{itm.Moneda}</a>
                                </div>
                            ))}
                        </div>
                    </div>
                    <div className='col-md-8'>
                        <div className='row'>
                            <div className='col-md-12'>
                                <div className='form-group'>
                                    <label htmlFor="">Tipo</label>
                                    <input type="text" className='form-control' name="Tipo" id="Tipo" value={'IMPORTE FIJO'} onChange={() => ''} disabled />
                                </div>
                            </div>
                            <div className='col-md-12'>
                                <div className='form-group'>
                                    <label> Importe</label>
                                    <input type="text" className='form-control' name="Importe" id="Importe" value={item.Importe ? item.Importe : '0'} onChange={(e) => changeItem(e)} />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div className='row'>
                    <div className='col-md-12 text-right'>
                        {/* <a className='btn' onClick={()=>console.log('moneda',ItemM)}>test</a> */}
                        <a className='btn btn-sm btn-primary' onClick={() => SaveDerechos()}>Guardar configuración</a>
                    </div>
                </div>
            </div>
        </div>
    )
}
