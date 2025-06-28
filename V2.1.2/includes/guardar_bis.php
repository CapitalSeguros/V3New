<?php


	//--> echo "vamos a crear actividad Emision y Emitir via Ws";
	
	/* busqueda del archivo xml de cotizacion */
	$pathAseguradora = strtolower($rowConsultaCotizacionWs['aseguradora']); // Calculamos el Directorio
	$directorio = opendir("../xmlTodos/$pathAseguradora"); //ruta de la carpeta a analizar
	while($archivo = readdir($directorio)){  //obtenemos un archivo y luego otro sucesivamente
		if(!is_dir($archivo)){//verificamos que no sea un directorio
			if(strstr($archivo,$recId)){ $archivoXmlCotizacion = $archivo; }
		}
	}
	echo $archivoXmlCotizacion;
	/* abrir archivo xml cotizacion y crear xml para emision */
	switch($pathAseguradora){
	
	/*1*/
		case "qualitas":
			//--> echo "entramos a crear emision de qualitas";
			$datosCotizacion  =  simplexml_load_file("../xmlTodos/$pathAseguradora/".$archivoXmlCotizacion); 
			
			if($datosCotizacion){
				//--> echo "Si Cargamos el XML";
				foreach($datosCotizacion->Movimiento as $cotizacion){
					
					echo $cotizacion->DatosAsegurado->Nombre;
					echo "<br>";
					
					//--> Leemos el archivo para sacar los datos y mandarlos al Nuevo XML
					echo "<pre>";
						print_r($cotizacion);
					echo "</pre>";
				}
				
				/* proceso de creacion del XML EMISION */
				
echo "@@@".$NombreCompleto = $cotizacion->DatosAsegurado->Nombre;
echo "<br>@@@".$Direccion = $cotizacion->DatosAsegurado->Direccion;
echo "<br>@@@".$Colonia = $cotizacion->DatosAsegurado->Colonia;
echo "<br>@@@".$Poblacion = $cotizacion->DatosAsegurado->Poblacion;
echo "<br>@@@".$Estado = $cotizacion->DatosAsegurado->Estado;
echo "<br>@@@".$CodigoPostal = $cotizacion->DatosAsegurado->CodigoPostal;
echo "<br>@@@".$NumeroExterior = $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[0]->ValorRegla;
echo "<br>@@@".$Pais = $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[2]->ValorRegla;
echo "<br>@@@".$NombrePrimero = $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[3]->ValorRegla;
echo "<br>@@@".$ApellidoPaterno = $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[4]->ValorRegla;
echo "<br>@@@".$ApellidoMaterno = $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[5]->ValorRegla;
$TipoPersona;
$FechaNacimiento;
$Rfc;
$Telefono;
echo "<br>@@@".$ClaveAmis = $cotizacion->DatosVehiculo->ClaveAmis;
echo "<br>@@@".$Modelo = $cotizacion->DatosVehiculo->Modelo;
echo "<br>@@@".$DescripcionVehiculo = $cotizacion->DatosVehiculo->DescripcionVehiculo;
echo "<br>@@@".$Uso = $cotizacion->DatosVehiculo->Uso;
echo "<br>@@@".$Servicio = $cotizacion->DatosVehiculo->Servicio;
echo "<br>@@@".$Paquete = $cotizacion->DatosVehiculo->Paquete;
echo "<br>@@@".$Motor = $cotizacion->DatosVehiculo->Paquete;
echo "<br>@@@".$Serie = $cotizacion->DatosVehiculo->Paquete;
echo "<br>@@@".$SumaAsegurada;
echo "<br>@@@".$FechaEmision;
echo "<br>@@@".$FechaInicio;
echo "<br>@@@".$FechaTermino;
echo "<br>@@@".$FormaPago;
echo "<br>@@@".$PorcentajeDescuento;

				$XML = '
<?xml version="1.0" encoding="utf-8"?>
<Movimientos>
	<Movimiento TipoMovimiento="3" NoPoliza="" NoCotizacion="" NoEndoso="" TipoEndoso="" NoOTra="" NoNegocio="01970">
		<DatosAsegurado NoAsegurado="">
			<Nombre>'.$NombreCompleto.'</Nombre>
			<Direccion>'.$Direccion.'</Direccion>
			<Colonia>'.$Colonia.'</Colonia>
			<Poblacion>'.$Merida.'</Poblacion>
			<Estado>'.$Estado.'</Estado>
			<CodigoPostal>'.$CodigoPostal.'</CodigoPostal>
			<NoEmpleado/>
			<Agrupador/>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>1</TipoRegla>
				<ValorRegla>'.$NumeroExterior.'</ValorRegla><!-- Numero Exterior -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>3</TipoRegla>
				<ValorRegla>'.$Pais.'</ValorRegla><!-- Pais -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>4</TipoRegla>
				<ValorRegla>'.$NombrePrimero.'</ValorRegla><!-- Nombre_1 Nombre_2 -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>5</TipoRegla>
				<ValorRegla>'.$ApellidoPaterno.'</ValorRegla><!-- Apellido Paterno -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>6</TipoRegla>
				<ValorRegla>'.$ApellidoMaterno.'</ValorRegla><!-- Apellido Materno -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>19</TipoRegla>
				<ValorRegla>'.$TipoPersona.'</ValorRegla><!-- Tipo de Persona (Persona Física:1, Persona Moral:2;) -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>20</TipoRegla>
				<ValorRegla>'.$FechaNacimiento.'</ValorRegla> <!-- Fecha de Nacimiento Formato (dd/mm/aaaa) -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>21</TipoRegla>
				<ValorRegla>1</ValorRegla> <!-- Nacionalidad (Ver Catálogo) -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>23</TipoRegla>
				<ValorRegla>5</ValorRegla><!-- Ocupación (Ver Catálogo) -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>28</TipoRegla>
				<ValorRegla>'.$Rfc.'</ValorRegla> <!-- RFC -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>70</TipoRegla>
				<ValorRegla>'.$Telefono.'</ValorRegla> <!-- Teléfono -->
			</ConsideracionesAdicionalesDA>
		</DatosAsegurado>
		<DatosVehiculo NoInciso="1">
			<ClaveAmis>'.$ClaveAmis.'</ClaveAmis>
			<Modelo>'.$Modelo.'</Modelo>
			<DescripcionVehiculo>'.$DescripcionVehiculo.'</DescripcionVehiculo>
			<Uso>'.$Uso.'</Uso>
			<Servicio>'.$Servicio.'</Servicio>
			<Paquete>'.$Paquete.'</Paquete>
			<Motor>'.$Motor.'</Motor>
			<Serie>'.$Serie.'</Serie>
			<Coberturas NoCobertura="01">
				<SumaAsegurada>0</SumaAsegurada> 
				<TipoSuma>'.$SumaAsegurada.'</TipoSuma> <!-- 0 Valor convenido , 01 Valor factura, 03 Valor comercial -->
				<Deducible>5</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="03">
				<SumaAsegurada>0</SumaAsegurada>
				<TipoSuma>'.$SumaAsegurada.'</TipoSuma> <!-- 0 Valor convenido , 01 Valor factura, 03 Valor comercial -->
				<Deducible>10</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="04">
				<SumaAsegurada>3000000</SumaAsegurada>
				<TipoSuma>0</TipoSuma>
				<Deducible>0</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="05">
				<SumaAsegurada>300000</SumaAsegurada>
				<TipoSuma>0</TipoSuma>
				<Deducible>0</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="07">
				<SumaAsegurada/>
				<TipoSuma>0</TipoSuma>
				<Deducible>0</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="14">
				<SumaAsegurada>0</SumaAsegurada>
				<TipoSuma> 0</TipoSuma>
				<Deducible>0</Deducible>
				<Prima>0</Prima>
			</Coberturas>
		</DatosVehiculo>
		<DatosGenerales>
			<FechaEmision>'.$FechaEmision.'</FechaEmision>
			<FechaInicio>'.$FechaInicio.'</FechaInicio>
			<FechaTermino>'.$FechaTermino.'</FechaTermino>
			<Moneda>0</Moneda>
			<Agente>16413</Agente>
			<FormaPago>'.$FormaPago.'</FormaPago>
			<TarifaValores>linea</TarifaValores>
			<TarifaCuotas>linea</TarifaCuotas>
			<TarifaDerechos>linea</TarifaDerechos>
			<Plazo/>
			<Agencia/>
			<Contrato/>
			<PorcentajeDescuento>'.$PorcentajeDescuento.'</PorcentajeDescuento>
			<ConsideracionesAdicionalesDG NoConsideracion="1">
				<TipoRegla>1</TipoRegla>
				<ValorRegla>7</ValorRegla>
			</ConsideracionesAdicionalesDG>
			<ConsideracionesAdicionalesDG NoConsideracion="4">
				<TipoRegla>1</TipoRegla> <!-- -->
				<ValorRegla>1</ValorRegla> <!-- -->
			</ConsideracionesAdicionalesDG>
		</DatosGenerales>
		<Primas>
			<PrimaNeta/>
			<Derecho>535</Derecho>
			<Recargo/>
			<Impuesto/>
			<PrimaTotal/>
			<Comision/>
		</Primas>
		<CodigoError/>
	</Movimiento>
</Movimientos>
					   ';
			}
		break;
		
	/*2*/
	} // fin del Switch
?>