import React, { useState, useEffect, forwardRef, useImperativeHandle, useRef } from "react";
import axios from "axios";
import ItemList from "./ItemList.jsx";
import CheckboxTree from "react-checkbox-tree";
import Breadcrumbs from "./Breadcrumbs.jsx";
import FilePreview from "./FilePreview.jsx";
import FileUpload from "./FileUpload.jsx";
import FileShare from "./FileShare.jsx";
import FileAccion from "./FileAccion.jsx";
import { CallApiPost } from "../../Helpers/Calls.js";
import "react-checkbox-tree/lib/react-checkbox-tree.css";

const FileManager = forwardRef(({
  selectorAction,
  referencia,
  referenciaId,
  IDCli,
  callBack,
  isTrash,
  Documento,
}, ref) => {

  useImperativeHandle(ref, () => {
    return {
      OpenModal: OpenModal
    }
  })
  const full = true;
  const path = window.jQuery("#base_url").attr("data-base-url");
  const Puestousuario = window.jQuery("#Puesto").attr("data-id");
  const Idusuario = window.jQuery("#Empleado_id").attr("data-id");
  //const ref = window.jQuery("#ref").attr("data-id");
  //const refId = window.jQuery("#refId").attr("data-id");
  const IdSelect = window.jQuery("#buscarIdPuesto").val();
  const PuestosAgregar = [9, 7];
  const [expanded, setExpanded] = useState([]);
  const [state, setState] = useState({
    show: false,
    showD: false,
    isFolder: false,
    isPermissions: undefined,
    checked: [],
  });

  const [nodes, setNodes] = useState([]);

  const [puestos, setPuestos] = useState([]);
  const [breadItems, setBread] = useState([]);
  const [childs, setChild] = useState([]);
  const [childsFilter, setChildFilter] = useState([]);
  const [preview, setPreview] = useState({
    description: "",
    webContentLink: "",
    id: "",
    ruta_completa: "",
    iconLink: ""
  });
  const [share, setShare] = useState({
    description: "",
    webContentLink: "",
    id: "",
  });

  const [Accion, setAction] = useState('');
  const [ItemSelected, setItemSelected] = useState([]);
  const ModalAcc = useRef(null);


  useEffect(() => {
    //console.log('test');
    //getLoad();
  }, []);

  function getPreview(item) {
    console.log(item);
    setPreview(item);
    window.jQuery("#modal-file-manager-preview").modal("show");
  }

  function getShare(item) {
    console.log(item);
    setShare(item);
    window.jQuery("#modal-file-share").modal("show");
  }

  function handleSearch(e) {
    const value = e.currentTarget.value;
    const filter = childs.filter((it) =>
      it.name.toLowerCase().includes(value.toLowerCase())
    );
    setChildFilter(filter);
  }

  function getLoad() {
    axios
      .get(`${path}filemanager`)
      .then(function (response) {
        if (response.data.code == "200") {
          setPuestos(response.data.data);
          getData();
        }
      })
      .catch((error) => { });
  }

  function getData() {
    axios
      .get(`${path}filemanager/getV2`, {
        //params: { referencia: ref, referencia_id: refId },
        params: { referencia: referencia, referencia_id: referenciaId },
      })
      .then(function (response) {
        if (response.data.code == "200") {
          setChild(response.data.data.child);
          setChildFilter(response.data.data.child);
        }
        const fil = breadItems.filter(
          (it) => it.id == response.data.data.parent.id
        );
        if (fil.length == 0) {
          setBread([...breadItems, response.data.data.parent]);
          var tnodes = response.data.data.tree;
          if (isTrash != undefined) {
            tnodes.push({
              label: "PAPELERA",
              value: "MAIN-PEPELERA",
              showCheckbox: false,
              employee: "",
              id: "MAIN-PEPELERA",
              name: "MAIN-PEPELERA",
              description: null,
              iconLink:
                "https://drive-thirdparty.googleusercontent.com/16/type/application/vnd.google-apps.folder+48",
              thumbnailLink: null,
              mimeType: "application/vnd.google-apps.folder",
              size: null,
              parent_id: null,
              children: [],
            });
          }

          if (tnodes.length > 0) {
            if (Documento && Documento != null && Documento != undefined) {
              let firstTNode = tnodes[0];
              firstTNode.label = Documento;
            }
          }

          setNodes(tnodes);
        } else {

          var tnodes = response.data.data.tree;
          if (tnodes.length > 0) {
            if (Documento && Documento != null && Documento != undefined) {
              let firstTNode = tnodes[0];
              firstTNode.label = Documento;
            }
          }

          setNodes(tnodes);
        }
      })
      .catch((error) => { });
  }

  function handleUploadClose(model) {
    setState({ ...state, show: false });
  }

  function createFolder() {
    setState({ ...state, show: true, isFolder: false });
  }
  function uploadFile() {
    setState({ ...state, show: true, isFolder: true });
  }

  function getFilesByParent() {
    var current = null;
    var uri = `${path}filemanager/getByParent`;
    current = breadItems[breadItems.length - 1].id;
    if (current == "MAIN-PEPELERA") {
      uri = `${path}filemanager/getTrashed`;
    }
    axios
      .get(uri, {
        params: {
          parent: current,
          //referencia: ref,
          //referencia_id: refId,
          referencia: referencia,
          referencia_id: referenciaId,
        },
      })
      .then((response) => {
        setChild(
          response.data.data.childs == undefined
            ? []
            : response.data.data.childs
        );
        setChildFilter(
          response.data.data.childs == undefined
            ? []
            : response.data.data.childs
        );

        var tnodes = response.data.data.tree;
        if (isTrash != undefined) {
          tnodes.push({
            label: "PAPELERA",
            value: "MAIN-PEPELERA",
            showCheckbox: false,
            employee: "",
            id: "MAIN-PEPELERA",
            name: "MAIN-PEPELERA",
            description: null,
            iconLink:
              "https://drive-thirdparty.googleusercontent.com/16/type/application/vnd.google-apps.folder+48",
            thumbnailLink: null,
            mimeType: "application/vnd.google-apps.folder",
            size: null,
            parent_id: null,
            children: [],
          });
        }
        setNodes(tnodes);
      })
      .catch((error) => {
        //console.log(error);
      });
  }

  function handleRestore(file) {
    var data = new FormData();
    data.append("file_id", file.id);
    axios
      .post(`${path}filemanager/restoreFile`, data)
      .then((response) => {
        //console.log("respuesta",response);
        getFilesByParent();
      })
      .catch((error) => {
        //console.error(error);
      });
  }

  function getFiles(file, index = -1, level = -1) {
    if (file.mimeType == "application/vnd.google-apps.folder") {
      axios
        .get(`${path}filemanager/getByParent`, {
          params: {
            parent: file.id,
            //referencia: ref,
            //referencia_id: refId,
            referencia: referencia,
            referencia_id: referenciaId,
          },
        })
        .then((response) => {
          if (index == -1) {
            if (level > -1) {
              const items = breadItems.filter((i, k) => k < level);
              setBread([
                ...items,
                { id: file.id, name: file.name, mimeType: file.mimeType },
              ]);
            } else {
              setBread([
                ...breadItems,
                { id: file.id, name: file.name, mimeType: file.mimeType },
              ]);
            }
          } else {
            const items = breadItems.filter((i, k) => k <= index);
            setBread(items);
          }

          setChild(response.data.data.childs);
          setChildFilter(response.data.data.childs);
        })
        .catch((error) => {
          //console.log(error);
        });
    } else if (file.value != undefined) {
      if (file.value == "MAIN-PEPELERA") {
        axios
          .get(`${path}filemanager/getTrashed`, {
            params: {
              parent: file.id,
              //referencia: ref,
              //referencia_id: refId,
              referencia: referencia,
              referencia_id: referenciaId,
            },
          })
          .then((response) => {
            const items = breadItems.filter((i, k) => k < level);
            setBread([
              ...items,
              {
                id: file.value,
                name: file.label,
                mimeType: "application/vnd.google-apps.folder",
              },
            ]);
            setChildFilter(response.data.data.files);
            setChild(response.data.data.files);
          })
          .catch((error) => {
            //console.log(error);
          });
      } else {
        axios
          .get(`${path}filemanager/getByParent`, {
            params: {
              parent: file.value,
              //referencia: ref,
              //referencia_id: refId,
              referencia: referencia,
              referencia_id: referenciaId,
            },
          })
          .then((response) => {
            setBread([
              {
                id: file.value,
                name: file.label,
                mimeType: "application/vnd.google-apps.folder",
              },
            ]);
            setChild(response.data.data.childs);
            setChildFilter(response.data.data.childs);
          })
          .catch((error) => {
            //console.log(error);
          });
      }
    }
  }

  function handleChangePermissions(file) {
    axios
      .get(`${path}filemanager/getBy/${file.id}`)
      .then((response) => {
        setState({
          ...state,
          show: true,
          isFolder: false,
          isPermissions: true,
          file: response.data.data,
        });
      })
      .catch((error) => console.error(error));
  }

  function handleSubmitUpload(model) {
    var current = null;

    if (breadItems.length > 0) {
      current = breadItems[breadItems.length - 1].id;
    }
    //console.log(state.isFolder, "teststst")
    if (state.isFolder) {
      if (model.archivos.length == 0) {
        toastr.error("Error, seleccione uno o más artículos.");
      }
    }

    var data = new FormData();
    data.append("id", model.id);
    data.append("padre", current);
    data.append("isFolder", state.isFolder);
    data.append("nombre", model.nombre);
    data.append("descripcion", model.descripcion);
    /* for (let index = 0; index < model.puestos.length; index++) {
      const element = model.puestos[index];
      data.append("puestos[" + index + "]", element.value);
    } */
    data.append("referencia", referencia);
    //data.append("referencia", ref);
    data.append("privado", model.privado);
    data.append("referencia_id", referenciaId);
    data.append("IDCli", IDCli);
    //data.append("referencia_id", refId);
    for (const key in model.archivos) {
      data.append(key, model.archivos[key]);
    }

    axios
      .post(`${path}filemanager/create`, data)
      .then((response) => {
        getFilesByParent();
      })
      .catch((error) => {
        //console.error(error);
      });
  }

  function handleSubmitShare(model) {
    var data = new FormData();
    data.append("id", share.id);
    data.append("file", JSON.stringify(share));
    data.append("descripcion", model.descripcion);
    for (let index = 0; index < model.puestos.length; index++) {
      const element = model.puestos[index];
      data.append("puestos[" + index + "]", element.value);
    }

    axios
      .post(`${path}filemanager/ShareFile`, data)
      .then((response) => {
        getFilesByParent();
      })
      .catch((error) => {
        //console.error(error);
      });
  }

  function handleTrash(file) {
    swal({
      title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
      text: "Una vez eliminado, Se ira a la papelera de la cuenta",
      icon: "warning",
      buttons: ["Cancelar", "Eliminar"],
      dangerMode: true,
    }).then((value) => {
      if (value) {
        var data = new FormData();
        data.append("file_id", file.id);
        axios
          .post(`${path}filemanager/trashed`, data)
          .then((response) => {
            getFilesByParent();
          })
          .catch((error) => {
            // console.error(error);
          });
      }
    });
  }

  function handleRemove(file) {
    swal({
      title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
      text: "Una vez eliminado, !no se podrá recuperar el archivo¡",
      icon: "warning",
      buttons: ["Cancelar", "Eliminar"],
      dangerMode: true,
    }).then((value) => {
      if (value) {
        var data = new FormData();
        data.append("file_id", file.id);
        axios
          .post(`${path}filemanager/delete`, data)
          .then((response) => {
            getFilesByParent();
          })
          .catch((error) => {
            //console.error(error);
          });
      }
    });
  }

  function handleDropdown(e) {
    // console.log(e.currentTarget.attr);
    if (!state.showD) {
      $(e.currentTarget).closest(".input-group-btn").addClass("open");
    } else {
      $(e.currentTarget).closest(".input-group-btn").removeClass("open");
    }
    setState({ ...state, showD: !state.showD });
  }

  function AnyFile() {
    const Files = childsFilter;
    var vacio = 0;
    Files.forEach(elm => {
      if (typeof (elm.permisos) !== 'undefined') {
        elm.permisos.includes(parseInt(Puestousuario)) ||
          elm.employee_id === parseInt(Idusuario) ||
          elm.permisos.length === 0 ||
          elm.permisos.includes(parseInt(IdSelect)) ||
          elm.permisos.includes(parseInt(IdSelect))
          ? vacio++ : vacio + 0
      }

    });
    //console.log("AnyFIlies",vacio);
    return vacio;
  }

  function OpenModal() {
    //alert(`referecnia ${referencia} | referenciaId ${referenciaId}`);
    $('#ModalFileUpload').modal('show');
    getLoad();
  }

  function handleAccion(Action, Item) {
    //alert(`${Action}`)
    setAction(Action);
    setItemSelected(Item);
    ModalAcc.current.OpenAction();
    //$("#ModalAcciones").modal('show');
  }
  async function SendAction(Accion, IdItem, IdPadre) {
    let URL = Accion == "COPY" ? 'filemanager/copy' : 'filemanager/move';
    var data = new FormData();
    data.append("IdDoc", IdItem);
    data.append("IdPadre", IdPadre);
    data.append("ref", referencia);

    axios
      .post(`${path}${URL}`, data)
      .then((response) => {
        //getFilesByParent();
        $("#ModalAcciones").modal('hide');
        toastr.success("Exíto");
        getFilesByParent();
      })
      .catch((error) => {
        $("#ModalAcciones").modal('hide');
        toastr.error(error);
        //console.error(error);
      });

  }


  const ItemsNull = AnyFile();

  return (
    <>
      <div className="vicious_library row">
        <div className="col-sm-12">
          <div className="row background">
            {full != undefined && (
              <div className="col-md-3 tree-view">
                <div className="row">
                  <div className="col-md-12" style={{ fontSize: '12px' }}>
                    <CheckboxTree
                      nodes={nodes}
                      onClick={(target) => {
                        if (target.treeDepth > 0) {
                          const file = target.parent.children.find(
                            (i) => i.id == target.value
                          );
                          getFiles(file, -1, target.treeDepth);
                        } else {
                          getFiles(target, -1, target.treeDepth);
                        }
                      }}
                      showCheckbox={false}
                      checked={state.checked}
                      expanded={expanded}
                      onCheck={(checked) => setState({ ...state, checked })}
                      onExpand={(expanded) => setExpanded(expanded)}
                    />
                  </div>
                </div>
              </div>
            )}

            <div className={full != undefined ? "col-md-9" : "col-md-12"}>
              <Breadcrumbs
                items={breadItems}
                full={full}
                handleDdble={getFiles}
                handleCreate={createFolder}
                handleUpload={uploadFile}
                Documento={Documento}
              />
              <div className="table-list table-wrapper">
                <table className="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>&nbsp;</th>
                      <th>Nombre</th>
                      {/* <th>Propietario</th> */}
                      <th>Información documento</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    {childsFilter.map((it, k) => (
                      <ItemList
                        key={k}
                        item={it}
                        full={full}
                        handleDdble={getFiles}
                        handleTrash={handleTrash}
                        handleRemove={handleRemove}
                        handleRestore={handleRestore}
                        handleChangeName={handleChangePermissions}
                        handlePreview={getPreview}
                        handleShare={getShare}
                        handleAccion={handleAccion}
                      />
                    ))}
                    {childsFilter.length == 0 && (
                      <tr>
                        <td colSpan="6" className="text-center">
                          Sin documentos
                        </td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <FileUpload
        id="modal-file-upload"
        show={state.show}
        file={state}
        isPermissions={state.isPermissions}
        isFolder={state.isFolder}
        eventSubmit={handleSubmitUpload}
        eventClose={handleUploadClose}
        puestos={puestos}
      ></FileUpload>
      <FilePreview
        description={preview.description}
        webContentLink={preview.webContentLink}
        iconLink={preview.iconLink}
        id={preview.id}
        ruta_completa={preview.ruta_completa}
      ></FilePreview>
      <FileShare
        show={state.show}
        file={state}
        isPermissions={state.isPermissions}
        isFolder={state.isFolder}
        eventSubmit={handleSubmitShare}
        eventClose={handleUploadClose}
        puestos={puestos}
      />
      <FileAccion ref={ModalAcc} Accion={Accion} Item={ItemSelected} Tree={nodes} SendAction={SendAction} />
    </>
  );
})

export default FileManager;
