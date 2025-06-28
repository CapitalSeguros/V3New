import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";

const ModalTable = ({ source, title, callBack, setVisible, show = 0 }) => {
  const [data, setData] = useState([]);

  const getKeys = function() {
    return data.length > 0 ? Object.keys(data[0]) : [];
  };

  const getHeader = function() {
    var keys = getKeys();
    return keys.map((key, index) => {
      return <th key={key}>{key.toUpperCase()}</th>;
    });
  };

  const RenderRow = props => {
    return props.keys.map((key, index) => {
      return <td key={props.data[key]}>{props.data[key]}</td>;
    });
  };

  const getRowsData = function() {
    var items = data;
    var keys = getKeys();
    return items.map((row, index) => {
      return (
        <tr key={index}>
          <RenderRow key={index} data={row} keys={keys} />
        </tr>
      );
    });
  };

  // useEffect(() => {
  //   window.jQuery("#md-modal-table").on("hidden.bs.modal", function(e) {
  //     setVisible(false);
  //   });
  // }, []);

  useEffect(() => {
    if (show > 0) {
      window.jQuery("#md-modal-table").modal("show");
    } else {
      window.jQuery("#md-modal-table").modal("hide");
    }
  }, [show]);

  useEffect(() => {
    setData(source);
  }, [source]);

  return (
    <div
      className="modal fade"
      id="md-modal-table"
      tabIndex="-1"
      role="dialog"
      aria-labelledby="md-modal-table"
    >
      <div className="modal-dialog" role="document">
        <div className="modal-content">
          <div className="modal-header">
            <button
              type="button"
              className="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 className="modal-title" id="myModalLabel">
              {title}
            </h4>
          </div>
          <div className="modal-body">
            <table className="table">
              <thead>
                <tr>{getHeader()}</tr>
              </thead>
              <tbody>{getRowsData()}</tbody>
            </table>
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

ModalTable.propTypes = {
  show: PropTypes.number.isRequired,
  title: PropTypes.string.isRequired,
  source: PropTypes.array.isRequired
};

export default ModalTable;
