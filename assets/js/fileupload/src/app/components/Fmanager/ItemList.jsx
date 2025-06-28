import React, { useState } from "react";
import { filesize } from "filesize";
import FileAccion from "./FileAccion.jsx";

const ItemList = ({
  item,
  full,
  handleDdble,
  handlePreview,
  handleChangeName,
  handleTrash,
  handleRemove,
  handleRestore,
  handleShare,
  handleAccion,
  tree
}) => {
  const Puestousuario = window.jQuery("#Puesto").attr("data-id");
  const Idusuario = window.jQuery("#Empleado_id").attr("data-id");
  const IdSelect = window.jQuery("#buscarIdPuesto").val();
  const PuestosAgregar = [9, 7];


  function OpenClick(item) {
    var ruta = "";
    //console.log("Item",item);
    if (item.id != null && item.iconLink != null) {
      ruta = `https://docs.google.com/viewer?srcid=${item.id}&pid=explorer&efh=false&a=v&chrome=false&embedded=true`;
    } else {
      ruta = item.ruta_completa;
    }
    window.open(ruta, '_blank');
  }


  return (
    <tr
      onDoubleClick={() => { full != undefined ? handleDdble(item) : handleDdble({}) }}
    >
      <td width="100">
        {/*  <button onClick={()=>console.log("iduser",item.employee_id===parseInt(Idusuario))}> Utest</button>
        <button onClick={()=>console.log("iduser",item.permisos.includes(parseInt(Puestousuario)))}> Utest</button> */}
        <img className="media-object" src={item.iconLink} alt={item.name_complete} />
      </td>
      <td className="issue-info">
        <div style={{ width: '200px', overflow: 'hidden' }}>
          <a style={{ cursor: 'pointer' }} onClick={() => { OpenClick(item) }}>{item.name_complete}</a>
          <small>{item.description}</small>
        </div>
      </td>
      {/* <td className="issue-info">
        <a>{item.employee}</a>
      </td> */}
      <td className="issue-info">
        <small>
          Tamaño del archivo: {item.size == null ? "N/A" : filesize(item.size)}
        </small>
        <small>
          Fecha creación: {moment(item.createdTime).format("YYYY.MM.DD")}
        </small>
      </td>
      <td>
        <div style={{ textAlign: "center" }}>
          <div className="dropdown">
            <a
              className="btn btn-link dropdown-toggle"
              type="button"
              id={item.id}
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="true"
            >
              <i className="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
            <ul
              className="dropdown-menu"
              aria-labelledby={item.id}
              style={{ zIndex: "1000" }}
            >
              {item.mimeType !== "application/vnd.google-apps.folder" && (
                <>
                  <li>
                    <a onClick={() => handleAccion("COPY", item)} style={{ cursor: "pointer" }} >
                      Copiar
                    </a>
                  </li>
                  {/* <li>
                    <a onClick={() => handlePreview(item)} style={{ cursor: "pointer" }} >
                      Vista previa
                    </a>
                  </li> */}
                </>
              )}
              <li>
                <a onClick={() => handleAccion("MOVE", item)} style={{ cursor: "pointer" }} >
                  Mover
                </a>
              </li>

              {/* {item.trashed == true && (
                <>
                  <li>
                    <a onClick={() => handleRestore(item)} style={{ cursor: "pointer" }} >
                      Restaurar
                    </a>
                  </li>
                  <li>
                    <a onClick={() => handleRemove(item)} style={{ cursor: "pointer" }} >
                      Eliminar
                    </a>
                  </li>
                </>
              )} */}
              {full != undefined &&
                item.trashed == undefined && (
                  <li>
                    <a onClick={() => handleTrash(item)} style={{ cursor: "pointer" }} >
                      Eliminar
                    </a>
                  </li>
                )}

            </ul>
          </div>
        </div>
      </td>

    </tr>
  );
};
export default ItemList;
