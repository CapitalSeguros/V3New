import * as Yup from "yup";

//const allowRamos=[2,3,4];
const allowRamos = [2];
//const allowSRamos = [50];
const allowSRamos = [17, 18, 19, 21];

export const validationSchemaPoliza = Yup.object({
    TipoDocto: Yup.string("Seleccione un Tipo de documento")
        .nullable("Seleccione un Tipo de documento")
        .required("Requerido."),
    FDesde: Yup.date("Ingrese una fecha valida")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    FHasta: Yup.date("Ingrese una fecha valida")
        .min(Yup.ref("FDesde"), "Debe de ser mayor a Desde")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    /* Documento: Yup.string("Ingrese una clave de documento")
        .nullable("Ingrese una clave de documento")
        .required("Requerido."), */
    IDAgente: Yup.number("Seleccione un Agente")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDCli: Yup.number("Seleccione una cliente")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDMon: Yup.number("Seleccione una Moneda")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDFPago: Yup.number("Seleccione una Forma de pago")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDSRamo: Yup.number("Seleccione un Ramo")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDSSRamo: Yup.number("Seleccione un SubRamo")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDVend: Yup.number("Seleccione un Vendedor")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    TipoDocto: Yup.string("Seleccione un Tipo de documento")
        .nullable("Seleccione un Tipo de documento"),
    IDGrupo: Yup.number("Seleccione un Grupo")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDSubGrupo: Yup.number("Seleccione un SubGrupo")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    PrimaNeta: Yup.number("Seleccione un Vendedor")
        .when("TipoDocto", (TipoDocto, schema) => {
            if (TipoDocto == 1)
                return schema.required("Requerido.").moreThan(0, 'Ingrese una cantidad');
            return schema;
        }),
    Serie: Yup.string("Ingrese un número de serie.").when(['IDSRamo', 'IDSSRamo', 'TipoDocto'], (IDSRamo, IDSSRamo, TipoDocto, schema) => {
        //console.log("SUBRAMO",IDSSRamo)
        //console.log("Ramo",IDSRamo)
        if (allowRamos.includes(IDSRamo) && allowSRamos.includes(IDSSRamo) && TipoDocto == "1") {
            return schema.nullable("Requerido.").required("Requerido.").trim().ensure();
        }
        return schema.nullable(true);
    })
});

export const validationSchemaFianza = Yup.object({
    TipoDocto: Yup.string("Seleccione un Tipo de documento")
        .nullable("Seleccione un Tipo de documento")
        .required("Requerido."),
    FDesde: Yup.date("Ingrese una fecha valida")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    FHasta: Yup.date("Ingrese una fecha valida")
        .min(Yup.ref("FDesde"), "Debe de ser mayor a Desde")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    IDAgente: Yup.number("Seleccione un Agente")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDCli: Yup.number("Seleccione una cliente")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDMon: Yup.number("Seleccione una Moneda")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDFPago: Yup.number("Seleccione una Forma de pago")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDSRamo: Yup.number("Seleccione un Ramo")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDSSRamo: Yup.number("Seleccione un SubRamo")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDVend: Yup.number("Seleccione un Vendedor")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDGrupo: Yup.number("Seleccione un Grupo")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    IDSubGrupo: Yup.number("Seleccione un SubGrupo")
        .required("Requerido.")
        .typeError('El campo debe ser un número'),
    Documento: Yup.string("Ingreser un número de fianza")
        .when("TipoDocto", (TipoDocto, schema) => {
            if (TipoDocto == 1)
                return schema.required("Requerido.");
            return schema;
        }),
    PrimaNeta: Yup.number("Seleccione un Vendedor")
        .when("TipoDocto", (TipoDocto, schema) => {
            if (TipoDocto == 1)
                return schema.nullable("Requerido.").required("Requerido.").moreThan(0, 'Ingrese una cantidad');
            return schema;
        }),

});

export const validationSchemaEndoso = Yup.object({
    Tipo: Yup.string("Seleccione un Tipo de endoso")
        .nullable("Seleccione un Tipo de endoso")
        .required("Requerido."),
    FDesde: Yup.date("Ingrese una fecha valida")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    FHasta: Yup.date("Ingrese una fecha valida")
        .min(Yup.ref("FDesde"), "Debe de ser mayor a Desde")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    TipoDocto: Yup.string("Seleccione un Tipo de documento")
        .nullable("Seleccione un Tipo de documento")
        .required("Requerido."),
    PrimaNeta: Yup.number("Seleccione un Vendedor")
        .when("TipoDocto", (TipoDocto, schema) => {
            if (TipoDocto == 1)
                return schema.required("Requerido.");
            return schema;
        })
});



export const validationCliente = Yup.object({
    Tipo: Yup.string("Seleccione un Tipo de entidad")
        .nullable("Seleccione un Tipo de entidad")
        .required("Requerido."),
    NombreCompleto: Yup.string("Ingrese una nombre")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    Sexo: Yup.string("seleccione una nSexoombre")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
});

export const validationDireccion = Yup.object({
    Calle: Yup.string("Ingrese una calle")
        .nullable("Ingrese una calle")
        .required("Requerido."),
});

export const validationPrestamo = Yup.object({
    VendNom: Yup.string("Seleccione un Vendedor.")
        .nullable("Seleccione un Vendedor.")
        .required("Requerido."),
    FPrestamo: Yup.date("Ingrese una fecha valida")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    FCaptura: Yup.date("Ingrese una fecha valida")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    Importe: Yup.number("Ingrese un Importe.")
        .nullable("Requerido.").required("Requerido.")
        .moreThan(0, 'Ingrese una cantidad'),
    Estatus: Yup.string("Seleccione un Estatus.")
        .nullable("Seleccione un Estatus.")
        .required("Requerido."),
    FPago: Yup.string("Seleccione una Forma de pago.")
        .nullable("Seleccione una Forma de pago.")
        .required("Requerido."),
    ImporteFpago: Yup.number("Ingrese un importe de pago.")
        .nullable("Requerido.").required("Requerido.")
        .moreThan(0, 'Ingrese una cantidad').when(["Importe"], (Importe, schema) => {
            if (Importe)
                return schema.max(Importe, "El importe de pago no puede ser mayor al importe del prestamo.");
            return schema;
        }),
    Concepto: Yup.string("Ingrese un Concepto.")
        .nullable("Ingrese un Concepto.")
        .required("Requerido."),
});


export const validacionFormCobranza = Yup.object({
    FDocumento: Yup.date("Ingrese una fecha valida")
        .required("RequeridoFD.")
        .nullable("Seleccione una fecha valida"),
    DocumentoComision: Yup.string("Ingrese un Documento.")
        .nullable("Ingrese un Documento.")
        .required("RequeridoD."),
    Folio: Yup.string("Ingrese un Folio.")
        .nullable("Ingrese un Folio.")
        .required("RequeridoF."),

});



export const validacionPagosEdicion = Yup.object({
    FDocumento: Yup.date("Ingrese una fecha valida")
        .required("Requerido.")
        .nullable("Seleccione una fecha valida"),
    Documento: Yup.string("Ingrese un Documento.")
        .nullable("Ingrese un Documento.")
        .required("Requerido."),
    Folio: Yup.string("Ingrese un Folio.")
        .nullable("Ingrese un Folio.")
        .required("Requerido."),

});
