<?php
if(isset($_GET['POLIZA'])){
	$VALOR = $_GET['POLIZA'];
}
if(isset($_GET['POLIZA_RENOVACION'])){
	$VALOR = $_GET['POLIZA_RENOVACION'];
}

switch($Nivel){ // New Version
//---- Sin Filtro --------------------//				
	case '5': // NIVEL 5
	
		$sqlUsuarioCreacion = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					`vendedores`.`CLAVE` != '0000007979'
				Order BY
					`nombreVendedor` Asc
							  ";
							  
		$sqlListadoVendedores = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					`vendedores`.`CLAVE` != '0000007979'
				Order BY
					`nombreVendedor` Asc
								";
								
		if(!isset($buscaEmpresa)){
			$sqlClientesListado = "
				Select * From
				`empresas`
			Where
				`TIPO_REGISTRO` Like '%CL%'
				And 
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
								  ";
			$sqlProspectosListado = "
				Select * From
				`empresas`
			Where
				`TIPO_REGISTRO` Like '%PR%'
				And
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
									";
		} else {
			$sqlClientesListado = "
				Select * From
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					And 
					`TIPO_REGISTRO` Like '%CL%'
				)
				And 
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc
								  ";
			$sqlProspectosListado = "
				Select * From 
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					And 
					`TIPO_REGISTRO` Like '%PR%'
				)
				And 
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
									";
		}

			$sqlBusquedaPoliza = "
				Select * From 
					`cliramos` Inner Join `empresas`
					On 
					`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
				Where
					`cliramos`.`POLIZA` Like '%$buscaPolCli%'
					Or
					$sqlBusquedaPolCliLikeMatch
				Group By
					`empresas`.`RAZON_SOCIAL`
				Order By
					`empresas`.`RAZON_SOCIAL` Asc
								 ";
								 
			$sqlBusquedaPolizaDiligencia = "
				Select * From 
					`cliramos` Inner Join `empresas`
					On 
					`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
				Where
					`cliramos`.`POLIZA` Like '%$buscaPolCli%'
					Or
					$sqlBusquedaPolCliLikeMatch
					And
					(
						`RAMO` Like '%".strtoupper(urldecode($Ramo))."%'
						And
						`SUBRAMO` Like '%".strtoupper(urldecode($SubRamo))."%'
					)
				Group By
					`empresas`.`RAZON_SOCIAL`
				Order By
					`empresas`.`RAZON_SOCIAL` Asc;
					## 5 --
								 		   ";
			$sqlResponsables = "
						Select 
							`CLAVE`
							,`NOMBRE`
							,`TIPO`
							,`VALOR`
							,`PROMOTOR`
							,`SUCURSAL`
						From 
							`usuarios`
						Order By 
							`TIPO`,`NOMBRE` Desc		
							   ";
	break; // NIVEL 5
				
//---- Filtra Sucursal --------------------//
	case '4': // NIVEL 4
		$sqlUsuarioCreacion = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					`vendedores`.`CLAVE` != '0000007979'
				Order BY
					`nombreVendedor` Asc
							  ";
							  
			$sqlListadoVendedores = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					`vendedores`.`CLAVE` != '0000007979'
				Order BY
					`nombreVendedor` Asc
									";
	if(!isset($buscaEmpresa)){
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					`SUCURSAL` Like '%".$Sucursal."%'
					And
					`TIPO_REGISTRO` Like '%CL%'
				)
				And
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
							  ";
							  
		$sqlProspectosListado = "
			Select * From
				`empresas`
			Where
				(
					`SUCURSAL` Like '%".$Sucursal."%'
					And
					`TIPO_REGISTRO` Like '%PR%'
				)
				And
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
								";
	} else {
		$sqlClientesListado = "
			Select * From 
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					And
					`SUCURSAL` Like '%".$Sucursal."%'
					And 
					`TIPO_REGISTRO` Like '%CL%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc
							  ";
		$sqlProspectosListado = "
			Select * From 
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					And
					`SUCURSAL` Like '%".$Sucursal."%'
					And 
					`TIPO_REGISTRO` Like '%PR%'
				)
				And
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc
								";
	}
			$sqlBusquedaPoliza = "
				Select * From 
					`cliramos` Inner Join `empresas`
					On 
					`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
				Where
					`empresas`.`SUCURSAL` Like '%$Sucursal%'
					And
					(
					`cliramos`.`POLIZA` Like '%$buscaPolCli%'
					Or
					$sqlBusquedaPolCliLikeMatch
					)
				Group By
					`empresas`.`RAZON_SOCIAL`
				Order By
					`empresas`.`RAZON_SOCIAL` Asc
								 ";
			$sqlBusquedaPolizaDiligencia = "
				Select * From 
					`cliramos` Inner Join `empresas`
					On 
					`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
				Where
					`empresas`.`SUCURSAL` Like '%$Sucursal%'
					And
					(
					`cliramos`.`POLIZA` Like '%$buscaPolCli%'
					Or
					$sqlBusquedaPolCliLikeMatch
					)
				Group By
					`empresas`.`RAZON_SOCIAL`
				Order By
					`empresas`.`RAZON_SOCIAL` Asc
										   ";
					$sqlResponsables = "
						Select 
							`CLAVE`
							,`NOMBRE`
							,`TIPO`
							,`VALOR`
							,`PROMOTOR`
							,`SUCURSAL`
						From 
							`usuarios`
						Where
							`SUCURSAL` Like '%$Sucursal%'
						Order By 
							`TIPO`,`NOMBRE` Desc		
							";
	break;
				
//---- Filtra Vendedor y Promotor --------------------//
	case '3': // NIVEL 3
		$sqlUsuarioCreacion = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					(
					`vendedores`.`TIPO` = '".$Usuario."'
					Or
					`usuarios`.`PROMOTOR` = '".$Usuario."'
					)
					Or
					(
					`usuarios`.`VALOR` = '".$Usuario."'
					)
				Order BY
					`nombreVendedor` Asc
							  ";

			$sqlListadoVendedores = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					(
					`vendedores`.`TIPO` = '".$Usuario."'
					Or
					`usuarios`.`PROMOTOR` = '".$Usuario."'
					)
					Or
					(
					`usuarios`.`VALOR` = '".$Usuario."'
					)
				Order BY
					`nombreVendedor` Asc
									";
	if(!isset($buscaEmpresa)){
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					(
						`VENDEDOR` Like '%".$Vendedor."%' 
						Or 
						`PROMOTOR` Like '%".$Vendedor."%'
					)
					And
					`TIPO_REGISTRO` Like '%CL%'
				)
				And
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc 
							  ";
		$sqlProspectosListado = "
			Select * From
				`empresas`
			Where
				(
					(
						`VENDEDOR` Like '%".$Vendedor."%' 
						Or
						`PROMOTOR` Like '%".$Vendedor."%'
					)
					And
					`TIPO_REGISTRO` Like '%PR%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc 
								";
	} else {
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					And
					(
						`VENDEDOR` Like '%".$Vendedor."%' 
						Or 
						`PROMOTOR` Like '%".$Vendedor."%'
					)
					And
					`TIPO_REGISTRO` Like '%CL%'
				)
				And								
				`estatusCliente` Like '%A%'									
			Order By
				`RAZON_SOCIAL` Asc
							  ";
		$sqlProspectosListado = "
			Select * From
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					And
					(
						`VENDEDOR` Like '%".$Vendedor."%' 
						Or 
						`PROMOTOR` Like '%".$Vendedor."%'
					)
					And
					`TIPO_REGISTRO` Like '%PR%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL`  Asc
								";
	}
			$sqlBusquedaPoliza = "
				Select * From 
					`cliramos` Inner Join `empresas`
					On 
					`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
				Where
					(
					`empresas`.`VENDEDOR` Like '%$Vendedor%'
					Or
					`empresas`.`PROMOTOR` Like '%$Vendedor%'
					)
					And
					(
					`cliramos`.`POLIZA` Like '%$buscaPolCli%'
					Or
					$sqlBusquedaPolCliLikeMatch
					)
				Group By
					`empresas`.`RAZON_SOCIAL`
				Order By
					`empresas`.`RAZON_SOCIAL` Asc
								 ";
			$sqlBusquedaPolizaDiligencia = "
				Select * From 
					`cliramos` Inner Join `empresas`
					On 
					`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
				Where
					(
					`empresas`.`VENDEDOR` Like '%$Vendedor%'
					Or
					`empresas`.`PROMOTOR` Like '%$Vendedor%'
					)
					And
					(
					`cliramos`.`POLIZA` Like '%$buscaPolCli%'
					Or
					$sqlBusquedaPolCliLikeMatch
					)
				Group By
					`empresas`.`RAZON_SOCIAL`
				Order By
					`empresas`.`RAZON_SOCIAL` Asc
										   ";
					$sqlResponsables = "
						Select 
							`CLAVE`
							,`NOMBRE`
							,`TIPO`
							,`VALOR`
							,`PROMOTOR`
							,`SUCURSAL`
						From 
							`usuarios`
						Where
							`PROMOTOR` Like '%$Promotor%'
							And
							`VALOR` Like '%Vendedor%'
						Order By 
							`TIPO`,`NOMBRE` Desc
									   ";
	break;

//---- Filtra Vendedor --------------------//
	case '2': // NIVEL 2
		$sqlUsuarioCreacion = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					`vendedores`.`CLAVE` = '".$Usuario."'
					Or
					`usuarios`.`VALOR` = '".$Usuario."'
				Order BY
					`nombreVendedor` Asc
							  ";

			$sqlListadoVendedores = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					`vendedores`.`CLAVE` = '".$Usuario."'
					Or
					`usuarios`.`VALOR` = '".$Usuario."'
				Order BY
					`nombreVendedor` Asc
									";
	if(!isset($buscaEmpresa)){
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					`VENDEDOR` Like '%".$Vendedor."%'
					And
					`TIPO_REGISTRO` Like '%CL%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
							  ";
		$sqlProspectosListado = "
			Select * From
				`empresas`
			Where
				(
					`VENDEDOR` Like '%".$Vendedor."%'
					And
					`TIPO_REGISTRO` Like '%PR%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
								";
	} else {
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					And
					`VENDEDOR` Like '%".$Vendedor."%'
					And 
					`TIPO_REGISTRO` Like '%CL%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
								";
		$sqlProspectosListado = "
			Select * From 
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					And
					`VENDEDOR` Like '%".$Vendedor."%'
					And 
					`TIPO_REGISTRO` Like '%PR%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc
								";
	}
			$sqlBusquedaPoliza = "
				Select * From 
					`cliramos` Inner Join `empresas`
					On 
					`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
				Where
					(
					`empresas`.`VENDEDOR` Like '%$Vendedor%'
					)
					And
					(
					`cliramos`.`POLIZA` Like '%$buscaPolCli%'
					Or
					$sqlBusquedaPolCliLikeMatch
					)
				Group By
					`empresas`.`RAZON_SOCIAL`
				Order By
					`empresas`.`RAZON_SOCIAL` Asc
								 ";
								 
			$sqlBusquedaPolizaDiligencia = "
				Select * From 
					`cliramos` Inner Join `empresas`
					On 
					`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
				Where
					(
					`empresas`.`VENDEDOR` Like '%$Vendedor%'
					)
					And
					(
					`cliramos`.`POLIZA` Like '%$buscaPolCli%'
					Or
					$sqlBusquedaPolCliLikeMatch
					)
				Group By
					`empresas`.`RAZON_SOCIAL`
				Order By
					`empresas`.`RAZON_SOCIAL` Asc					
										   ";
					$sqlResponsables = "
						Select 
							`CLAVE`
							,`NOMBRE`
							,`TIPO`
							,`VALOR`
							,`PROMOTOR`
							,`SUCURSAL`
						From 
							`usuarios`
						Where
							`PROMOTOR` Like '%$Promotor%'
						Order By 
							`TIPO`,`NOMBRE` Desc
							";
	break;
}

?>