import React from 'react';
import Select from "react-select";

export default function CoberturaGMD(props) {
    const { values, state, handleChange, handleKeyDown, handleBlur, setFieldValue, displayitem, mapitems } = props;

    const colourStyles = {
        control: styles => ({
            ...styles,
            backgroundColor: "white",
            borderRadius: "0px",
            minHeight: "30px",
            maxHeight: 30,
            color: '#472380 !important'
        })
    };
    return (
        <div className="tab-pane fade" id="coberturaGMD" role="tabpanel" aria-labelledby="coberturaGMD-tab">
            <div className='row'>
                <div className='col-md-12 unsetPadding'>
                    <h6>Detalle del plan y coberturas</h6>
                    <hr />
                </div>
                <div className='col-md-12'>

                </div>
            </div>
        </div>
    )
}
