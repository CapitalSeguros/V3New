import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import  Contenedor  from "./components/Capacitacion/Contenedores";
import  TodoApp  from "./components/Pruebas/Prueba";
import reportWebVitals from './reportWebVitals';

ReactDOM.render(

  //<Card titulo="Capacitaciones"></Card>
  <Contenedor></Contenedor>
  , document.getElementById("root")
)

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
