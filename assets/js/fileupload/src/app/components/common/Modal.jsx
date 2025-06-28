import React, { useEffect } from "react";
import PropTypes from "prop-types";

const Modal = ({ titulo, id, show, state, tipo, evento }) => {
  useEffect(() => {
    if (show > 0) {
      window.jQuery(`#${id}`).modal("show");
    } else {
      window.jQuery(`#${id}`).modal("hide");
    }
  }, [show]);

  return (
    <div
      className="modal fade"
      id={id}
      tabIndex="-1"
      role="dialog"
      aria-labelledby={id}
      aria-hidden="true"
    >
      <div className="modal-dialog modal-lg" role="document">
        <div className="modal-content">
          <div className="modal-header">{titulo}</div>
          <div className="modal-body">
            <div className="row">
              <div className="col-md-12">
                {state && state.length === 0 ? (
                  <div className="text-center">Sin registros.</div>
                ) : (
                  <ul className="media-list">
                    {state &&
                      state.map((item, indx) => (
                        <div className="media" key={indx}>
                          <div className="media-body">
                            <h5 className="media-heading">
                              <small className="statuscomentario">
                                <strong>
                                  <i
                                    className="fa fa-user"
                                    aria-hidden="true"
                                  ></i>
                                  &nbsp;
                                  {item.name_complete}
                                </strong>
                              </small>
                              <small className="text-muted pull-right">
                                <i
                                  className="fa fa-clock-o"
                                  aria-hidden="true"
                                />
                                &nbsp;
                                {item.fecha}
                              </small>
                            </h5>
                            <p className="pull-right">
                              <span className="label label-default">
                                {item.estatus}
                              </span>
                            </p>
                            <small>
                              <p>{item.motivo}</p>
                            </small>
                          </div>
                        </div>
                      ))}
                  </ul>
                )}
              </div>
            </div>
          </div>
          <div className="modal-footer">
            <button
              type="button"
              className="btn btn-default"
              data-dismiss="modal"
            >
              Cerrar
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};
Modal.prototype = {
  titulo: PropTypes.string.isRequired,
  id: PropTypes.string.isRequired,
  state: PropTypes.object,
  tipo: PropTypes.any,
  evento: PropTypes.func
};

export default Modal;
