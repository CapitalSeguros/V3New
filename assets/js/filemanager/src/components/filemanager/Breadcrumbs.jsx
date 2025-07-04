import React from "react";

const Breadcrumbs = ({
  items,
  full,
  handleDdble,
  handleCreate,
  handleUpload,
}) => {
  const Puestousuario = window.jQuery("#Puesto").attr("data-id");
  const Idusuario = window.jQuery("#Empleado_id").attr("data-id");
  const IdSelect=window.jQuery("#buscarIdPuesto").val();
  const PuestosAgregar = [9, 7];
  const numImes =
    items == undefined
      ? 0
      : items.length == 0
      ? items.length
      : items.length - 1;

  return (
    <ul className="breadcrumb">
      {items.map((i, k) =>
        k == numImes ? (
          <li className="dropdown" key={k}>
            <a
              href="#"
              className="dropdown-toggle"
              data-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="false"
            >
              {i.name}
              {full != undefined ? <span className="caret"></span> : ""}
            </a>
            {PuestosAgregar.includes(parseInt(Puestousuario)) ? (
              <ul className="dropdown-menu" aria-labelledby={i.id}>
                <li>
                  <a style={{cursor:"pointer"}}  onClick={() => handleUpload(i)} >
                    <i className="glyphicon glyphicon-cloud-upload"></i> Nuevo
                    archivo
                  </a>
                </li>
                <li>
                  <a style={{cursor:"pointer"}}  onClick={() => handleCreate(i)}>
                    <i className="glyphicon glyphicon-folder-close"></i> Nueva
                    carpeta
                  </a>
                </li>
              </ul>
            ) : (
              ""
            )}
          </li>
        ) : (
          <li key={k} onClick={() => handleDdble(i, k)}>
            <a style={{cursor:"pointer"}} >{i.name}</a>
          </li>
        )
      )}
    </ul>
  );
};

export default Breadcrumbs;
