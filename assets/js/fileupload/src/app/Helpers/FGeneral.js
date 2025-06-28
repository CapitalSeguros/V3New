//Constantes

const colourStyles = {
    control: styles => ({
        ...styles,
        backgroundColor: "white",
        borderRadius: "0px",
        minHeight: "30px",
        maxHeight: 30,
        color: '#472380 !important'
    }),
};

const colourStylesCustomRecibos = {
    control: styles => ({
        ...styles,
        backgroundColor: "white",
        borderRadius: "0px",
        minHeight: "30px",
        maxHeight: 30,
        color: '#472380 !important'
    }),
    menuList: styles => ({
        ...styles,
        maxHeight: 150,
        //minHeight: "30px",
        //padding: '0 6px'
    }),
};
const EstatusCerrados = ['Cancelada', 'No Renovada', 'Vencida'];

const Comisiones = [
    {
        Nombre: 'Honorario base o de Neta',
        Id: 1
    },
    {
        Nombre: 'Honorario Adicional',
        Id: 2
    },
    {
        Nombre: 'Honorario Derecho',
        Id: 3
    }//

];


const ComisionesRecibos = [
    {
        Nombre: 'Honorario base o de Neta',
        Id: 1
    },
    {
        Nombre: 'Honorario Adicional',
        Id: 2
    },
    {
        Nombre: 'Honorario Derecho',
        Id: 3
    },
    {
        Nombre: 'Cancelacion',
        Id: 100
    }//

];

const CComisiones = [
    {
        Nombre: 'Comisión Base o de Neta',
        Id: 1
    },
    {
        Nombre: 'Comisión de Recargos',
        Id: 3
    },
    {
        Nombre: 'Comisión de Derechos',
        Id: 4
    },
    {
        Nombre: 'Comisión de Maquila',
        Id: 5
    }
];


const FComisiones = [
    {
        Nombre: 'Honorarios Base o Neta',
        Id: 1
    },
    {
        Nombre: 'Honorario base vend S/comision total',
        Id: 2
    },
    {
        Nombre: 'Honorarios Recargos y Derechos',
        Id: 3
    },
    /* {
        Nombre: 'Honorario Derechos',
        Id: 4
    }, */
    {
        Nombre: 'Honorario Maquila',
        Id: 4
    }
];

const FComisionesP = [
    {
        Nombre: 'Comsion Base o de Neta',
        Id: 1
    },
    {
        Nombre: 'Honorario base vend S/comision total',
        Id: 2
    },
    {
        Nombre: '% Comision Derechos.',//%Comisión Base o Prima Neta.
        Id: 4
    },
    {
        Nombre: '% Comisión Recargos',//%Comisión Base o Prima Neta.
        Id: 3
    },
];

const Sexo = [
    {
        Nombre: 'Femenino',
        Id: 1
    },
    {
        Nombre: 'Masculino',
        Id: 2
    },
];


//Funciones
function mapitems(respuesta, Tipo) {
    const _ps = respuesta.map(i => {
        var obj = {};
        switch (Tipo) {
            default:
                obj = { value: i.Id, label: i.Nombre };
                break;
        }
        return obj;
    });
    return _ps;
}

function mapitemsHijos(respuesta, IdPadre) {
    const nuevo = respuesta;
    const itemspadre = nuevo.filter((item, index) => parseInt(item.IdPadre) === parseInt(IdPadre));
    const _ps = itemspadre.map(i => {
        return { value: i.Id, label: i.Nombre };
    });
    return _ps;
}

function mapitemsHijosNombre(respuesta, IdPadre) {
    const nuevo = respuesta;
    //console.log("aaaa",respuesta)
    const itemspadre = nuevo.filter((item, index) => item.IdPadre === IdPadre);
    const _ps = itemspadre.map(i => {
        return { value: i.Id, label: i.Nombre };
    });
    //console.log("ps",_ps);
    return _ps;
}

function displayitem(Id, array, tipo = null) {
    //console.log("id",Id)
    const _array = array;
    var rArray = [];
    const newData = _array.filter((item, index) => parseInt(item.Id) === parseInt(Id));
    //console.log("NewData", newData);
    newData.forEach(element => {
        rArray.push({ value: element.Id, label: element.Nombre });
    });
    return rArray;
}

function displayitemText(Id, array, tipo = null) {
    //console.log("id",Id)
    const _array = array;
    var rArray = [];
    const newData = _array.filter((item, index) => item.Id === Id);
    //console.log("NewData", newData);
    newData.forEach(element => {
        rArray.push({ value: element.Id, label: element.Nombre });
    });
    return rArray;
}


function displayitemTextNombre(Id, array, tipo = null) {
    //console.log("id",Id)
    const _array = array;
    var rArray = [];
    const newData = _array.filter((item, index) => item.Nombre === Id);
    //console.log("NewData", newData);
    newData.forEach(element => {
        rArray.push({ value: element.Id, label: element.Nombre });
    });
    return rArray;
}

function displayOther(Id, array) {
    const _array = array;
    var rArray = [];
    const newData = _array.filter((item, index) => parseInt(item.Id) === parseInt(Id));
    //console.log("NewData", newData);
    if (newData.length > 0) {
        rArray = newData[0];
    }
    return rArray;
}
function GetName(Id, array) {
    var find = array.find(itm => itm.Id === parseInt(Id));
    if (find) {
        return find.Nombre
    }
    return 'N/A';
}

function RecalcualateTotal(Formula, Porcentaje, Importe, Recargo, Derechos) {
    var percent = parseFloat(Porcentaje) / 100;
    var sum = 0;
    if (parseInt(Formula) == 1) {
        sum = parseFloat(Importe);
    }
    if (parseInt(Formula) == 2) {
        sum = parseFloat(Importe) + parseFloat(Recargo) + parseFloat(Derechos);
    }
    return parseFloat((percent * sum).toFixed(2));
}

function FormatItem(value) {
    if (value == null) {
        value = 0;
    }
    var _return = parseFloat(value);
    return (_return).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })
}

function calculatePagos(FDesde, FHasta, Npagos) {
    //console.log(`FDesde:${FDesde}|Fhasta:${FHasta}`);
    var Action = '';
    var months = moment(FHasta).diff(FDesde, 'months', true);
    var days = 0;
    var Add = months / Npagos;
    //console.log("ADD", Add);
    if (Add >= 1) {
        Action = 'months';
        Add = parseInt(Add);
    } else {
        Action = 'days';
        Add = parseInt(365 / Npagos);
    }
    //console.log('meses', parseInt(months));
    return { Action, Add };
}

const TO_FIXED_MAX = 100;

function truncate(number, decimalsPrecison) {
    // make it a string with precision 1e-100
    number = number.toFixed(TO_FIXED_MAX);

    // chop off uneccessary digits
    const dotIndex = number.indexOf('.');
    number = number.substring(0, dotIndex + decimalsPrecison + 1);

    // back to a number data type (app specific)
    return Number.parseFloat(number);
}

function isEmptyObject(object) {
    //console.log("obejto",object)
    for (var i in object) { return true; }
    return false;
}

function LockEnter(e) {
    if (e.keyCode === 13) {
        e.preventDefault();
    }
}

function round(value, exp) {
    if (typeof exp === 'undefined' || +exp === 0)
        return Math.round(value);

    value = +value;
    exp = +exp;

    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
        return NaN;

    // Shift
    value = value.toString().split('e');
    value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
}

function UpperCaseField(word) {
    //console.log("Mayusculas", word.toUpperCase());
    return word.toUpperCase();
}

const FocusInput = (e) => {
    e.target.select();
}

function ShowLoading(Accion = true) {
    if (Accion)
        $("#upProgressModal").show();
    else
        $("#upProgressModal").hide();
}

function CalculateEdad(FechaNac) {
    var a = moment();
    var b = moment(FechaNac);
    var years = a.diff(b, 'year');
    return years;
}


export { isEmptyObject, truncate, displayitemText,displayitemTextNombre, ShowLoading, displayOther, displayitem, mapitemsHijos, mapitemsHijosNombre, mapitems, GetName, RecalcualateTotal, FormatItem, calculatePagos, LockEnter, round, FocusInput, UpperCaseField,CalculateEdad, EstatusCerrados, colourStyles, Comisiones, FComisiones, FComisionesP, Sexo, colourStylesCustomRecibos, CComisiones, ComisionesRecibos };