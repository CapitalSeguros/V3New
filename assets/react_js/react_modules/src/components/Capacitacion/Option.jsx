import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";

const Option = (props) => {

    return(
        <option value={props.valor}>{props.texto}</option>
    );

}

export default Option;
