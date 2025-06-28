import React from "react";

const HeadMonitoreo = (props) => {
  return (
    <div className="panel-heading" data-toggle="tooltip" title="click para ver contenido">
        <div className="row">
            <div className="col-sm-11"> 
                <h3 className="panel-title" style={{cursor:'pointer'}} /* data-toggle="collapse" data-target={`#panel${props.index}`} */><span className="fa fa-ellipsis-v" aria-hidden="true"></span>  {props.titulo}</h3>
            </div>
            <div className="col-sm-1 btnComentario display">
                <div onClick={()=>props.OpenComentarios(props.Idp,props.item)} className="btnItem" data-toggle="tooltip" title="ver comentarios"><span className="fa fa-comments fa-lg" aria-hidden="true"></span></div>
                {props.estatus!="CERRADO" && (
                  <div onClick={()=>props.OpenModal(props.item)} className="btnItem" data-toggle="tooltip" title="Agregar comentario"><span className="fa fa-plus-circle fa-lg" aria-hidden="true"></span></div>
                )}
            </div>
        </div>
    </div>
  );
};

export default HeadMonitoreo;