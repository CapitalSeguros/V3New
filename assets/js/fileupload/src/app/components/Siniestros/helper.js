import * as Yup from "yup";

export const validationSchema = Yup.object({
  Fechainicio: Yup.date("Ingrese una fecha valida")
    .nullable("Seleccione una fecha valida")
    .required("La Fecha inicio es requerida."),
  FechaFin: Yup.date("Ingrese una fecha valida")
    .min(Yup.ref("Fechainicio"), "Debe de ser mayor a Fecha inicio")
    .required("La Fecha inicio es requerida.")
    .nullable("Seleccione una fecha valida"),
  aseguradora_id:Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  cliente_id:Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número')
});

export const validationExcel = Yup.object({
  aseguradora_id:Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  cliente_id:Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  file:Yup.mixed()
  .required("Se necesita un archivo")

});
 
 export const colourStyles2 = {
    control: styles => ({
      ...styles,
      backgroundColor: "white",
      borderRadius: "0px",
      minHeight: "34px",
      maxHeight: 50,
      borderColor:'#a94442 !important'
    }),
    groupHeading:styles=>({
      ...styles,
      color:'#472380 !important',
      fontWeight:'bold',
      fontSize:'13px'
    })
  };

  export const colourStyles = {
  control: styles => ({
    ...styles,
    groupHeading:'#472380',
    backgroundColor: "white",
    borderRadius: "0px",
    minHeight: "34px",
    maxHeight: 50,
    color:'#472380 !important',
  }),
  groupHeading:styles=>({
    ...styles,
    color:'#472380 !important',
    fontWeight:'bold',
    fontSize:'13px'
  })
};

export function displayitem(id,array){
  const _array=array;
  const newData = _array.filter((item, index) => item.id === id);
  const r=mapitems(newData);
  return r;
}

export function displayitemC(id,array){
  const _array=array;
  const newData = _array.filter((item, index) =>item.aseguradora === id);
  const r=mapitems(newData);
  return r;
}

export function mapitems(respuesta) {
  const _ps = respuesta.map(i => {
    return { value: i.id, label: i.nombre };
  });
  return _ps;
}