import React from 'react';
import CurrencyInputField from 'react-currency-input-field';

export default function TablaRecibos(props) {
    const { Recibos, DeleteRecibo, ChangeValueRecibo, NewChangeValueRecibo,
        handleBlur, FocusInput, ChangeEdit, values, Tipo } = props;


    function FormatItem(value) {
        var _return = parseFloat(value ? value : 0);
        return (_return).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })
    }

    function FormatRandom(value) {
        var SplitVal = value.split('/');
        return `${SplitVal[2]}${SplitVal[1]}${SplitVal[0]}`;
    }

    function ParseItem(value) {
        var check = true;
        if (value == undefined) {
            value = '0000-00-00';
            check = false;
        }

        if (check) {
            return moment(value).format('DD/MM/YYYY');
        } else {
            return 'N/A';
        }
    }

    function GetAllSum(Tipo) {
        var total = 0;
        switch (Tipo) {
            case 'PN':
                Recibos.map((elm, index) => {
                    return total = total + parseFloat(elm.PrimaNeta);
                });
                break;
            case 'PT':

                Recibos.map((elm, index) => {
                    return total = total + parseFloat(elm.PrimaTotal);
                });
                break;
        }
        return total;
    }

    return (
        <div className='row'>
            <div className='col-md-12'>
                <div className='table-responsive'>
                    <table className="table table-condensed" id="polizas">
                        <thead style={{ fontSize: '12px' }}>
                            <tr>
                                <th scope="col" style={{ width: '100px' }}>Creacion</th>
                                <th scope="col" style={{ width: '100px' }}>Desde</th>
                                <th scope="col" style={{ width: '100px' }}>Hasta</th>
                                <th scope="col" style={{ width: '100px' }}>Generacion</th>
                                <th scope="col" style={{ width: '100px' }}>Limite Pago</th>
                                <th scope="col" style={{ width: '100px' }}>Periodo</th>
                                <th scope="col" style={{ width: '100px' }}>Serie</th>
                                <th scope="col" style={{ width: '100px' }}>Prima Neta</th>
                                <th scope="col" style={{ width: '100px' }}>Descuento</th>
                                <th scope="col" style={{ width: '100px' }}>% Descuento</th>
                                {Tipo == "P" && (
                                    <>
                                        <th scope="col" style={{ width: '100px' }}>Recargos</th>
                                        <th scope="col" style={{ width: '100px' }}>% Recargos</th>
                                    </>
                                )}
                                <th scope="col" style={{ width: '100px' }}>Derechos</th>
                                <th scope="col" style={{ width: '100px' }}>SubTotal</th>
                                <th scope="col" style={{ width: '100px' }}>IVA</th>
                                <th scope="col" style={{ width: '100px' }}>% IVA</th>
                                {Tipo == "P" && (
                                    <th scope="col" style={{ width: '100px' }}>Ajuste</th>
                                )}
                                {Tipo == "F" && (
                                    <>
                                        <th scope="col" style={{ width: '100px' }}>Gastos Maq</th>
                                        <th scope="col" style={{ width: '100px' }}>Gastos Adm</th>
                                    </>
                                )}
                                <th scope="col" style={{ width: '100px' }}>Prima Total</th>
                                <th scope="col" style={{ width: '100px' }}></th>
                            </tr>
                        </thead>
                        <tbody>
                            {Recibos.length == 0 && (
                                <tr>
                                    <td className='text-center' colSpan={19}>NO SE HAN GENERADO LOS RECIBOS</td>
                                </tr>
                            )}
                            {Recibos && Recibos.map((item, key) => (
                                <tr key={key}>
                                    <td>{ParseItem(item.FCreacion)}</td>
                                    <td>{ParseItem(item.FDesde)}</td>
                                    <td>{ParseItem(item.FHasta)}</td>
                                    <td>{ParseItem(item.FGeneracion)}</td>
                                    <td>{ParseItem(item.FLimPago)}</td>
                                    <td>{item.Periodo}</td>
                                    <td>{item.Serie}</td>
                                    <td>{FormatItem(item.PrimaNeta)}</td>
                                    <td>{FormatItem(item.Descuento)}</td>
                                    <td>{item.PDescuento ? item.PDescuento : '0'}</td>
                                    {Tipo == "P" && (
                                        <>
                                            <td>{FormatItem(item.Recargos)}</td>
                                            <td>{item.PorRecargos ? item.PorRecargos : '0'}</td>
                                        </>
                                    )}

                                    <td>{FormatItem(item.Derechos)}</td>
                                    <td>{FormatItem(item.SubTotal)}</td>
                                    <td>{FormatItem(item.IVA)}</td>
                                    <td>{item.PorIVA ? item.PorIVA : '0'}</td>
                                    {Tipo == "P" && (
                                        <td>{FormatItem(item.Ajuste)}</td>
                                    )}
                                    {Tipo == "F" && (
                                        <>
                                            <td>{FormatItem(item.GastosMaq)}</td>
                                            <td>{FormatItem(item.GastosAdm)}</td>
                                        </>
                                    )}
                                    <td>{FormatItem(item.PrimaTotal)}</td>
                                    {
                                        item.Status_TXT == "Pendiente" ?
                                            <td style={{ display: 'inline-flex' }}>
                                                <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key)} data-toggle="tooltip" data-placement="bottom" title="Editar recibo"><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a className='btn btn-primary btn-sm' onClick={() => DeleteRecibo(key)} data-toggle="tooltip" data-placement="bottom" title="Elminar recibo"><i className="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                            :
                                            ""
                                    }
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
                {Recibos && Recibos.length > 0 && (
                    <>
                        <div className='col-md-12 pt-4'>
                            <div className='row' style={{ textAlign: 'end' }}>
                                <div className='col-md-6'>

                                </div>
                                <div className='col-md-3'>
                                    <b>Prima Neta :</b> {FormatItem(values.PrimaNeta)}
                                </div>
                                <div className='col-md-3'>
                                    <b>Prima Total :</b> {FormatItem(values.PrimaTotal)}
                                </div>
                            </div>
                        </div>
                        <div className='col-md-12'>
                            <div className='row' style={{ textAlign: 'end' }}>
                                <div className='col-md-6'>
                                </div>
                                <div className='col-md-3'>
                                    <b>Prima Neta Recibos :</b> {FormatItem(GetAllSum('PN'))}
                                </div>
                                <div className='col-md-3'>
                                    <b>Prima Total Recibos :</b> {FormatItem(GetAllSum('PT'))}
                                </div>
                            </div>
                        </div>
                    </>
                )}
            </div>
        </div>
    )
}

