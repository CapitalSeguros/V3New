import React from "react";
import PropTypes from "prop-types";

const ItemMonitoreo = (props) => {
  return (
    <li className="list-group-item">
        <div className="row">
            <div className="col-sm-11">
                <span className="glyphicon glyphicon-bookmark" aria-hidden="true"></span>&nbsp;{props.Titulo}
            </div>
            <div className="col-sm-1 btnComentario">
            <div onClick={()=>props.OpenComentarios(props.Idp,props.item)} className="btnItem" data-toggle="tooltip" title="ver comentarios"><span className="fa fa-comments fa-lg" aria-hidden="true"></span></div>
            {props.estatus!="CERRADO" && (
              <div onClick={()=>props.OpenModal(props.item)} className="btnItem" data-toggle="tooltip" title="Agregar comentario"><span className="fa fa-plus-circle fa-lg" aria-hidden="true"></span></div>
            )}
            </div>
        </div>
    </li>
  );
};
ItemMonitoreo.prototype = {

};

export default ItemMonitoreo;