import React from "react";
import PropTypes from "prop-types";

const Items = ({ item, Eliminar, index, Tipo, checked, changeItem, auto,RespuestaCorrecta }) => {
  const letras = [
    "A",
    "B",
    "C",
    "D",
    "F",
    "G",
    "H",
    "I",
    "J",
    "K",
    "L",
    "M",
    "O"
  ];
  let id = "ItemTitle";
  const types=["3","4","8"];

  function validate(e) {
    var t = e.target.value;
    t.replace("-", "");
    e.target.value =
      t.indexOf(".") >= 0
        ? t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)
        : t;
  }
  return (
    <li data-id-item={item.id} className="card card-item">
      <div className="card-header">
        <div className="row">
          <div className="col-md-1" style={{ width: 10 }}>
            {Tipo !== "7" ? index + 1 : letras[index]}.-
          </div>
          <div className={Tipo !== "6"&&!types.includes(Tipo) ? "col-md-11" : "col-md-8"}>
            <div className="form-group" style={{ height: 25 }}>
              {/*  <textarea className="form-control" style={{height:40}} defaultValue={item.titulo||''} onBlur={(e)=>changeItem(e,index)} name="ItemTitle"></textarea> */}
              <div
                style={{ height: 40, overflowY: "scroll", overflowX: "hidden" }}
                name="ItemTitle"
                id="ItemTitle"
                contentEditable="true"
                onBlur={e => changeItem(e, index, id)}
                suppressContentEditableWarning={true}
              >
                {" "}
                {item.titulo || ""}
              </div>
            </div>
          </div>
          <div className={types.includes(Tipo) ? "col-md-3" : "col-md-3 hidden"}>
            <div id={'opcionC'+index} className={item.correcta?'circle correct':'circle normal'} onClick={()=>RespuestaCorrecta(index)}>
            </div>
          </div>
          <div className={Tipo !== "6" ? "col-md-3 hidden" : "col-md-3"}>
            <div className="form-group" style={{ height: 25 }}>
              <input
                id={`Itemvalue${index}`}
                disabled={!checked}
                placeholder={!checked ? auto : ""}
                className="form-control"
                type="number"
                min={1}
                style={{ height: 40 }}
                defaultValue={item.valor}
                onBlur={e => changeItem(e, index)}
                name="Itemvalue"
                onInput={validate}
              />
            </div>
          </div>
        </div>
        <a className="remove" onClick={() => Eliminar(index)}>
          <i className="fa fa-times" aria-hidden="true"></i>
        </a>
      </div>
    </li>
  );
};
Items.prototype = {
  item: PropTypes.object.isRequired,
  addToList: PropTypes.func.isRequired
};

export default Items;
