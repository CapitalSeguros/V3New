import React from "react";
const ItemComentario = props => {
  return (
    <div className="media">
      <div className="media-body">
        <h5 className="media-heading">
          <strong>{props.item.name_complete}</strong>
          <small className="text-muted pull-right">
            <i className="fa fa-clock-o" aria-hidden="true" />{" "}
            {props.item.created}
          </small>
        </h5>
        <p>{props.item.comentario}</p>
      </div>
    </div>
  );
};

export default ItemComentario;
