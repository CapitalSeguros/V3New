import React, { useEffect } from 'react'

export default function AllowElement(props) {
    const { children, PermisoAccion } = props;
    const Permisos = _permisos.length > 0 ? JSON.parse(_permisos[0].permisos) : [];

    //console.log("permisos", Permisos);

    if (Permisos.find((x) => x.clase == PermisoAccion))
        return <>{children}</>;
    else
        return null;
}
