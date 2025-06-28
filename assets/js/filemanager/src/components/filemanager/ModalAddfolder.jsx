import React, { useState, useEffect } from "react";


function AddFolder({ruta}) {
  
  return (
    <div className="modal" id="AddFolder" role="dialog">
      <div className="modal-dialog modal-md">
        <div className="modal-content">
          <div className="modal-body">
            <button
              type="button"
              className="close"
              onClick={() => $("#AddFolder").modal("hide")}
            >
              &times;
            </button>
            <h4 className="modal-title">Crear nueva carpeta en la ruta: {ruta}</h4>
            <div>
                <input className="form-control" placeholder="Carpeta sin título" type="text" name="carpeta" id=""/>
            </div>
          </div>
          <div className="modal-footer">
            <button
              type="button"
              className="btn btn-default"
              onClick={() => $("#AddFolder").modal("hide")}
            >
              Close
            </button>
            <button
              type="button"
              className="btn btn-primary"
            >
              Crear
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default AddFolder;
