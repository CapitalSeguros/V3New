import React from "react";
import filesize from "filesize";
import moment from "moment";

const ItemList = ({
  item,
  full,
  handleDdble,
  handlePreview,
  handleChangeName,
  handleTrash,
  handleRemove,
  handleRestore,
  handleShare
}) => {
  const Puestousuario=window.jQuery("#Puesto").attr("data-id");
  const Idusuario=window.jQuery("#Empleado_id").attr("data-id");
  const IdSelect=window.jQuery("#buscarIdPuesto").val();
  const PuestosAgregar = [9, 7];
  return (
    <tr
      onDoubleClick={ item.permisos.includes(parseInt(Puestousuario))||item.employee_id===parseInt(Idusuario) ||item.permisos.length===0||item.permisos.includes(parseInt(IdSelect))
        ?
        () =>{full != undefined ? handleDdble(item) : handleDdble({})}:
        ()=>{toastr.error("No tienes permisos de acceso")}
      }
    >
      <td width="100">
       {/*  <button onClick={()=>console.log("iduser",item.employee_id===parseInt(Idusuario))}> Utest</button>
        <button onClick={()=>console.log("iduser",item.permisos.includes(parseInt(Puestousuario)))}> Utest</button> */}
        <img className="media-object" src={item.iconLink} alt={item.name} />
      </td>
      <td className="issue-info">
        <a>{item.name}</a>
        <small>{item.description}</small>
      </td>
      <td className="issue-info">
        <a>{item.employee}</a>
      </td>
      <td className="issue-info">
        <small>
          Tamaño del archivo: {item.size == null ? "" : filesize(item.size)}
        </small>
        <small>
          Fecha creación: {moment(item.createdTime).format("YYYY.MM.DD")}
        </small>
      </td>
      <td>
        <div style={{ textAlign: "center" }}>
          <div className="dropdown">
            <button
              className="btn btn-link dropdown-toggle"
              type="button"
              id={item.id}
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="true"
            >
              <i className="fa fa-ellipsis-v" aria-hidden="true"></i>
            </button>
            { item.permisos.includes(parseInt(Puestousuario))||item.employee_id===parseInt(Idusuario) || item.permisos.length===0 ||item.permisos.includes(parseInt(IdSelect)) ? (
              <ul
              className="dropdown-menu"
              aria-labelledby={item.id}
              style={{ zIndex: "1000" }}
            >
              {item.mimeType !== "application/vnd.google-apps.folder" && (
                <li>
                <a onClick={() => handlePreview(item)} style={{cursor:"pointer"}} >
                  Vista previa
                </a>
              </li>
              )}
              {full != undefined && item.trashed == undefined && PuestosAgregar.includes(parseInt(Puestousuario)) && (
                <>
                  <li>
                    <a onClick={() => handleChangeName(item)} style={{cursor:"pointer"}} >
                      Editar permisos
                    </a>
                  </li>
                  <li>
                  <a style={{cursor:"pointer"}} onClick={() => handleShare(item)}>
                    Compartir
                  </a>
                </li>
                </>
              )}
              {item.trashed == true && PuestosAgregar.includes(parseInt(Puestousuario))&& (
                <>
                  <li>
                    <a onClick={() => handleRestore(item)} style={{cursor:"pointer"}} >
                      Restaurar
                    </a>
                  </li>
                  <li>
                    <a onClick={() => handleRemove(item)} style={{cursor:"pointer"}} >
                      Eliminar
                    </a>
                  </li>
                </>
              )}
              {full != undefined &&
              item.trashed == undefined &&
              item.canDelete  &&  PuestosAgregar.includes(parseInt(Puestousuario))&& (
                <li>
                  <a onClick={() => handleTrash(item)} style={{cursor:"pointer"}} >
                    Eliminar
                  </a>
                </li>
              )}

            </ul>
            ):
            (<ul className="dropdown-menu"
            aria-labelledby={item.id}
            style={{ zIndex: "1000" }}>
              <li><a>Sin opciones</a></li>
            </ul>)
            }
          </div>
        </div>
      </td>
    </tr>
  );
};
export default ItemList;
