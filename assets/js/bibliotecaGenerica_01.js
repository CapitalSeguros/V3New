
function formatoMoneda(numero)
{numeroFlot=Number(numero).toFixed(2);
 formato=new Intl.NumberFormat(['es-MX'], {style: "currency",currency: "MXN",currencyDisplay: "symbol",maximumFractionDigit: 1}).format(numeroFlot);
 return formato;
}