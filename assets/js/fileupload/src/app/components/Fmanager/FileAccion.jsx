import React, { forwardRef, useImperativeHandle, useState } from 'react';
import CheckboxTree from "react-checkbox-tree";

const FileAccion = forwardRef((props, ref) => {
    const { Accion, IdDoc, Tree, Item, SendAction } = props;
    const [expanded, setExpanded] = useState([]);
    const [target, setTarget] = useState(null);
    const [state, setState] = useState({
        show: false,
        showD: false,
        isFolder: false,
        isPermissions: undefined,
        checked: [],
    });

    useImperativeHandle(ref, () => {
        return {
            OpenAction: OpenAction
        }
    });

    function Onclose() {
        $("#ModalAcciones").modal("hide");
    }

    function Send() {
        if (target == null) {
            return swal({
                title: "Advertencia",
                text: "Seleccione una ubicación.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#472380"
            });
        }
        if (Accion == "MOVE") {
            if (Item.parent_id == target.value) {
                return swal({
                    title: "Advertencia",
                    text: "No se puede mover en la misma ubicación.",
                    icon: "warning",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#472380"
                });
            }
        }
        SendAction(Accion, Item.id, target.value);
    }

    function OpenAction() {
        setTarget(null);
        setExpanded([]);
        setState({
            show: false,
            showD: false,
            isFolder: false,
            isPermissions: undefined,
            checked: [],
        });
        $("#ModalAcciones").modal("show");
    }

    return (
        <div id="ModalAcciones" className="modal" tabIndex="-1" role="dialog" data-backdrop="false">
            <div className="modal-dialog modal-lg" role="document">
                <div className="modal-content">
                    <div className="modal-header titulos">
                        <h4 className="modal-title" id="exampleModalLabel">
                            {Accion == "COPY" ? 'Copiar' : 'Mover'} el elemento {Item.name}
                        </h4>
                    </div>
                    <div className="modal-body">
                        <div className='col-md-12 pb-2'>
                            <div className='row'>
                                <p><strong> Seleccione una ubicación:</strong> </p>
                              {/*   <a onClick={() => console.log("ferkerner", Item)}>dwdsdfsdfsdfsdf</a> */}
                            </div>
                        </div>
                        <div className='col-md-12'>
                            <div className='row'>
                                <CheckboxTree
                                    nodes={Tree}
                                    onClick={(target) => {
                                        console.log(target);
                                        console.log("Item", Item);
                                        setTarget(target);
                                    }}
                                    showCheckbox={false}
                                    checked={state.checked}
                                    expanded={expanded}
                                    onCheck={(checked) => setState({ ...state, checked })}
                                    onExpand={(expanded) => setExpanded(expanded)}
                                />
                            </div>
                        </div>
                        <div className='col-md-12 pt-5'>
                            <div className='row'>
                                {target != null && (
                                    <p><strong>El documento se movera a : {target.label}</strong></p>
                                )}
                            </div>
                        </div>
                    </div>
                    <div className="modal-footer">
                        <a
                            type="button"
                            id="close"
                            className="btn btn-secondary"
                            onClick={() => Onclose()}
                        >
                            Cerrar
                        </a>
                        <a className="btn btn-primary" onClick={() => Send()}>
                             {Accion == "COPY" ? 'Copiar' : 'Mover'} elemento
                        </a>
                    </div>
                </div>
            </div>
        </div>
    )
})
export default FileAccion;