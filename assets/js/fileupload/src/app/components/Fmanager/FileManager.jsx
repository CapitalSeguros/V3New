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
import { ShowLoading } from "../../Helpers/FGeneral.js";

const FileManager = forwardRef(({
  selectorAction,
  referencia,
  referenciaId,
  IDCli,
  callBack,
  isTrash,
  Documento,
  UrlServicio = null
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
  const [documents, setDocuments] = useState([]);
  const [childsFilter, setChildFilter] = useState([]);
  const [preview, setPreview] = useState({
    description: "",
    webContentLink: "",
    id: "",
  });
  const [share, setShare] = useState({
    description: "",
    webContentLink: "",
    id: "",
  });

  const [Accion, setAction] = useState('');
  const [ItemSelected, setItemSelected] = useState([]);
  const ModalAcc = useRef(null);
  const [headerBread, setHeaderBread] = useState(null);

  useEffect(() => {
    //getLoad();
  }, []);

  function getPreview(item) {
    setPreview(item);
    window.jQuery("#modal-file-manager-preview").modal("show");
  }

  function getShare(item) {
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
    let documentsTree = [];
    let documents = [];
    let documentsParent = {};

    //breadItems = [];

    setBread([]);
    setChild([]);
    setHeaderBread(null);

    axios
      .get(`${path}filemanager/getV2`, {
        //params: { referencia: ref, referencia_id: refId },
        params: { referencia: referencia, referencia_id: referenciaId, cliente_id: IDCli },
      })
      .then(function (response) {
        if (response.data.code == "200") {
          setChild(response.data.data.child);
          setChildFilter(response.data.data.child);

          documentsTree = response.data.data.documentstree || [];
          documents = response.data.data.documents || [];
          documentsParent = response.data.data.documentsparent || {};
          setDocuments(documentsTree);

        }
        const fil = breadItems.filter(
          (it) => it.id == response.data.data.parent.id
        );
        if (fil.length == 0) {
          setBread([]);
          let _breadItems = [];
          let _parent = {
            id: response.data.data.parent.id,
            name: Documento,
            mimeType: response.data.data.parent.mimeType,
          }
          _breadItems.push(_parent);
          setBread(_breadItems);
          //setBread([...breadItems, response.data.data.parent]);

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

          setBread([]);
          let _breadItems = [];
          let _parent = {
            id: response.data.data.parent.id,
            name: Documento,
            mimeType: response.data.data.parent.mimeType,
          }
          _breadItems.push(_parent);
          setBread(_breadItems);

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
          type: "DOCUMENT",
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
        //console.error(error);
      });
  }

  function handleRestore(file) {
    var data = new FormData();
    data.append("file_id", file.id);
    axios
      .post(`${path}filemanager/restoreFile`, data)
      .then((response) => {
        getFilesByParent();
      })
      .catch((error) => {
        //console.error(error);
      });
  }

  function getFiles(file, index = -1, level = -1, type = "DOCUMENT") {

    setBread([]);
    setChild([]);

    if (type == "CLIENT") {
      setHeaderBread(file.label);
    }
    else {
      setHeaderBread(Documento);
    }

    if (file.mimeType == "application/vnd.google-apps.folder") {
      axios
        .get(`${path}filemanager/getByParent`, {
          params: {
            parent: file.id,
            //referencia: ref,
            //referencia_id: refId,
            referencia: referencia,
            referencia_id: referenciaId,
            type: type,
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
          //console.error(error);
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
            //console.error(error);
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
              type: type,
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
            //console.error(error);
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

  async function generarDocumentos(referenciaId, IDCli) {
    ShowLoading();
    let URL = `${UrlServicio}documents/getdocumentsfromxml/${referenciaId}`;
    axios
      .get(URL, {
        //params: { referencia_id: referenciaId },
      })
      .then(function (response) {
        if (response.status == "200") {
          getData();
          response.data.mensajes && response.data.mensajes.length > 0 ? toastr.success(response.data.mensajes[0]) : toastr.success("Documentos generados correctamente.");
          ShowLoading(false);
        }
        else {
          response.data.mensajes && response.data.mensajes.length > 0 ? toastr.error(response.data.mensajes[0]) : toastr.error("Error, agregar el mensaje que devuelve.");
          ShowLoading(false);
        }
      })
      .catch((error) => {
        toastr.error("Error al generar los documentos, " + error.toString());
        ShowLoading(false);
      });
  }

  function handleDownload(item) {
    if (!item?.ruta_completa) {
      toastr.error("Error, no se ha encontrado el archivo para descargar.");
      return;
    }
    const downloadUrl = item.ruta_completa;
    window.open(downloadUrl, '_blank');
  }

  return (
    <>
      <div className="vicious_library row">
        <div className="col-sm-12">
          {/* <div className="d-grid gap-2 d-md-flex justify-content-md-end">
            <a type="button" className="btn btn-primary"
              onClick={() => generarDocumentos(referenciaId, IDCli)}>
              <i class="fa fa-cloud-download mr-3" aria-hidden="true"></i>
              Descargar Documentos
            </a>
          </div> */}
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
                          getFiles(file, -1, target.treeDepth, "DOCUMENT");
                        } else {
                          getFiles(target, -1, target.treeDepth, "DOCUMENT");
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
                <div className="row">
                  <div className="col-md-12" style={{ fontSize: '12px' }}>
                    <CheckboxTree
                      nodes={documents}
                      onClick={(target) => {
                        if (target.treeDepth > 0) {
                          const file = target.parent.children.find(
                            (i) => i.id == target.value
                          );
                          getFiles(file, -1, target.treeDepth, "CLIENT");
                        } else {
                          getFiles(target, -1, target.treeDepth, "CLIENT");
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
                Documento={headerBread}
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
                        handleDownload={handleDownload}
                        Documento={headerBread}
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
        id={preview.id}
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
