<font style="font-size:12px; font-weight:bold; font-style:italic;">
<?php
	if(isset($POLIZA_RENOVACION) && $POLIZA_RENOVACION != "" ){
		$txtFormulario.= '
			<font style=" font-size:12px; color:#000000; font-weight:bold;">
				<p>
					P&oacute;liza de Referencia: '.$POLIZA_RENOVACION.'
				</p>
			</font>
						 ';
	} else if(isset($POLIZA) && ($POLIZA_RENOVACION == "" && $POLIZA != "")){
		$txtFormulario.= '
			<font style=" font-size:12px; color:#000000; font-weight:bold;">
				<p>
					P&oacute;liza de Referencia: '.$POLIZA.'
				</p>
			</font>
						 ';
	}
	if(isset($SubRamoLocal)){ $SubRamo = $SubRamoLocal; }
	switch($Actividad){
		
		case "Cotizaci%F3n":
			switch($Ramo){

				case "Fianzas":
					$txtAsteriscos = '
						<font style="font-size:12px;">
									 ';
					$txtAsteriscos.= '
						<blockquote>
							<strong>
								<a
									href="https://www.dropbox.com/sh/3txhtwzoketivnz/AAApKkKzhGi5mEk-inumrn7Sa/INFORMACION%20GENERAL/FIANZAS/COTIZADOR%20AFIANZADORAS.xls?dl=0"
									target="new" 
									title="Clic Para Descargar"
								>
									Formato de Solicitud
								</a>
							</strong>
						</blockquote>
									 ';
					$txtAsteriscos.= '
						</font>
									 ';
				break;

				case "Flotillas":
					$txtAsteriscos = '
						<font style="font-size:12px;">
									 ';
					$txtAsteriscos.= '
						<blockquote>
							<strong>
								<a
									href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABpnR7zpQI1kYhL9P9-u38wa/INFORMACION%20GENERAL/FLOTILLAS/SOLICITUD%20COT%20FLOTILLA.xlsx?dl=0"
									target="new" 
									title="Clic Para Descargar"
								>
									Formato de Solicitud
								</a>
							</strong>
						</blockquote>
									 ';
					$txtAsteriscos.= '
						</font>
									 ';
				break;
				
				case "Da%F1os":

					//** SubRamo
					switch($SubRamo){
						case "Hogar":
						case "MULTIPLE FAMILIAR":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AACERtze7j18SNKx9Y2p1idPa/INFORMACION%20GENERAL/DA%C3%91OS/SOLICITUD%20HOGAR.XLSX?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n
											</a>
											<br>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABtu-Zqjv_rQFHGOtTbqpKqa/INFORMACION%20GENERAL/DA%C3%91OS/PAQUETE%201%20COMPARATIVO%20HOGAR.pdf?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Cuadro Comparativo Estandarizado 1
											</a>
											<br>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AAC7B55E5wF9IfOoBcCfvu6La/INFORMACION%20GENERAL/DA%C3%91OS/PAQUETE%202%20COMPARATIVO%20HOGAR.pdf?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Cuadro Comparativo Estandarizado 2
											</a>
										</strong>
									</blockquote>
								</font>
											 ';
						break;
						
						case "Empresarial":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AADlZbZeAwaTYMf4pZDG3QtSa/INFORMACION%20GENERAL/DA%C3%91OS/SOLICITUD%20EMPRESARIAL.xlsx?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n
											</a>
										</strong>
									</blockquote>
								</font>
											 ';
						break;

						case "Responsabilidad+Civil":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABcmOHxiFsgDM3VecHhS9KBa/INFORMACION%20GENERAL/DA%C3%91OS/CUESTIONARIO%20DE%20RC%20GENERAL.xlsx?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n RC General
											</a>
											<br>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AAAuZ25fu2tK591S5Krr8-ZWa/INFORMACION%20GENERAL/DA%C3%91OS/CUESTIONARIO%20RC%20PROFESIONAL%20MEDICO.xlsx?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n RC M&eacute;dico
											</a>
											<br>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AACtqt9liIya-7Cfg2WtyIFia/INFORMACION%20GENERAL/DA%C3%91OS/Cuadro%20Comparativo%20RC%20Medicos.pdf?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Cuadro Comparativo Estandarizado RC M&eacute;dico
											</a>
											<br>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AADTN1hRZGbW5wUgcpPUX19ma/INFORMACION%20GENERAL/DA%C3%91OS/CUESTIONARIO%20RC%20GUARDER%C3%8DAS%20SEDESOL.xlsx?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n RC Guarder&iacute;as
											</a>
											<br>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AAAi_PCfveCMKwbJuQPRU1IWa/INFORMACION%20GENERAL/DA%C3%91OS/SOLICITUD%20EQUIPO%20CONTRATISTA.xlsx?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n RC Contratista
											</a>
										</strong>
									</blockquote>
								</font>
											 ';
						break;
						
						case "Embarcaciones":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABWRb03TEysaotw6Xfdqf8Oa/INFORMACION%20GENERAL/DA%C3%91OS/SOLICITUD%20EMBARCACIONES.xlsx?dl=0"
												target="new"
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n
											</a>
										</strong>
									</blockquote>
								</font>
											 ';
						break;				

						case "Transportes":
						case "TRANSPORTES":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AACgND3DY0m2Tr-HdtssJPdAa/INFORMACION%20GENERAL/DA%C3%91OS/SOLICITUD%20TRANSPORTE%20ANUAL.xlsx?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n Transporte
											</a>
											<br>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABIiTUOh2y7c9hLKnfPh_vRa/INFORMACION%20GENERAL/DA%C3%91OS/SOLICITUD%20TRANSPORTE%20ESPEC%C3%8DFICO.xlsx?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n Transporte Especifico
											</a>
										</strong>
									</blockquote>
								</font>
											 ';
						break;

						case "Equipo+de+Contratistas":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AAAi_PCfveCMKwbJuQPRU1IWa/INFORMACION%20GENERAL/DA%C3%91OS/SOLICITUD%20EQUIPO%20CONTRATISTA.xlsx?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Solicitud de cotizaci&oacute;n
											</a>
										</strong>
									</blockquote>
								</font>
											 ';
						break;
						
						case "Otros":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
											Indicar que tipo de producto y aseguradoras
											<br>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AADF7ghz1Qz9GoH7vprit_oFa/INFORMACION%20GENERAL/DA%C3%91OS/TARIFAS%20MEDIPET.pdf?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Cuadro Comparativo Medipet
											</a>
										</strong>
									</blockquote>
								</font>
											 ';
						break;	

					}
					//!! SubRamo
					
				break;

				case "L%EDneas+Personales":				
					//** SubRamo
					switch($SubRamo){
						case "Vida":
						case "VIDA":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
								Aseguradoras a cotizar:
								<br>
								Suma Asegurada:
								<br>
								Moneda: (Pesos / D&oacute;lares / UDIS)
								<br>
								Forma de Pago: (Anual / Semestral / Trimestral / Mensual)
								<br>
								Tipo de Plan: (Ordinario de Vida / Vida Pagos Limitados / Dotal / Educacional / Retiro)
								<br>
								Periodo de Protecci&oacute;n: (1/5/10/15/20/25/Vitalicio o Edad Alcanzada 60/65)
								<br>
								Plazo de Pago de Primas: (1/5/10/15/20/25/Vitalicio o Edad Alcanzada 60/65)
								<br>
								Nombre, Edad y si fuma o no Titular:
								<br>
								Nombre, Edad Hijo (si es Educacional):
								<br>
								Nombre, Edad y si fuma o no Conyuge (si es vida conjunta):
								<br>
								Exenci&oacute;n de primas por Invalidez: (Si/No)
								<br>
								Pago adicional por Invalidez: (Si/No)
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
											*Indicar si tiene ocupaci&oacute;n riesgosa, si est&aacute; enfermo 
											y 
											si se requiere alguna cobertura adicional
										</strong>
									</blockquote>
								</font>
											 ';
						break;

						case "Gastos+Medicos+Mayores":
						case "Gastos+Medicos":
						case "GASTOS MEDICOS":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
								Asegurados, Edades y parentesco
								<br>
								Aseguradoras a cotizar / Forma de Pago/ Nivel Hospitalario / Ciudad donde reside
								<br>
								Coberturas Adicionales / &iquest;Reconocimiento de Antig&uuml;edad?
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
										</strong>
									</blockquote>
								</font>
											 ';
						break;						

						case "Accidentes+Personales":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
								Asegurados, Edades, Ocupaci&oacute;n y parentesco / Ciudad donde reside
								<br>
								Aseguradoras a cotizar / Forma de Pago/ Tiempo de Cobertura / Si es viaje indicar destino 
								<br>
								Si es Escolar incluir listado o cu&aacute;ntos menores y mayores a 12 a&ntilde;os
								<br>
								Suma Asegurada:
								<br>
								Coberturas a Incluir: (Muerte Accidental / P. Org&aacute;nicas A &oacute; B / Reembolso Gastos M&eacute;dicos)
								<br>
								Coberturas Adicionales:
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
										</strong>
									</blockquote>
								</font>
											 ';
						break;

						case "Inversi%F3n+Financiera+%28OPTIMAXX%29":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
								Asegurado, Edad, si fuma o no
								<br>
								Moneda: (Pesos / D&oacute;lares / UDIS)
								<br>
								Forma de Pago: (Anual / Semestral / Trimestral / Mensual)
								<br>
								Plazo Comprometido: (5 &ndash; 25 a&ntilde;os)
								<br>
								Monto Aportaci&oacute;n:
								<br>
								Portafolio: (Conservador / Balanceado / Din&aacute;mico)
								<br>
								Tipo de Plan: (Inversi&oacute;n / Fideicomiso / Deducible)

											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
										</strong>
									</blockquote>
								</font>
											 ';
						break;				

						case "Otros":
							$txtFormulario.= '
							<font style=" font-size:12px; color:#6F6F6F;">
											 ';
							$txtFormulario.= '
								Indicar que tipo de producto y aseguradoras
											 ';
							$txtFormulario.= '
							</font>
											 ';
							$txtAsteriscos = '
								<font style="font-size:12px;">
									<blockquote>
										<strong>
										</strong>
									</blockquote>
								</font>
											 ';
						break;				


					}
					//!! SubRamo
				break;
				
				case "Autos+Individuales":
				case "AUTOS":
					$txtAsteriscos = '
						<font style="font-size:12px;">
									 ';
					$txtAsteriscos.= '
							Le recordamos que para poder tramitar su cotizaci&oacute;n expr&eacute;s
							<br>
							<blockquote>
								Necesitamos:
								<br>
								<blockquote>
									<strong>
                            			*Marca
										*Descripci&oacute;n 
										*Modelo
										*Forma de Pago
										*Cobertura
										*Codigo Postal
										<br>
										** Tipo de carga solo Pick Up
										<br><br>
										<blockquote>
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABmfknO_mQZaevNDcMBirHMa/INFORMACION%20GENERAL/AUTOS/PORCENTAJE%20DESCUENTOS%20AUTOS.pdf?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Porcentaje Descuentos
											</a>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AAAr3KB4MWCKaIjnlgXlH3vFa/INFORMACION%20GENERAL/AUTOS/CUADROS%20COMPARATIVOS%20CON%20BASICA%20MERIDA.pdf?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Comparativos BASICA Merida
											</a>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a
												href="https://www.dropbox.com/sh/3txhtwzoketivnz/AAC1HCs3BnrZuyuaqITOE8zha/INFORMACION%20GENERAL/AUTOS/CUADROS%20COMPARATIVOS%20ESTANDARIZADOS%20MERIDA.pdf?dl=0"
												target="new" 
												title="Clic Para Descargar"
											>
											Comparativos ESTANDARIZADOS Merida
											</a>
										</blockquote>
									</strong>
								</blockquote>
							</blockquote>
									 ';
					$txtAsteriscos.= '
						</font>
									 ';
				break;
			}
		break;
		
		case "Emisi%F3n":
			switch($Ramo){
				case "Autos+Individuales":
					$txtAsteriscos = '
						<font style="font-size:12px;">
									 ';
					$txtAsteriscos.= '
						<blockquote>
							Datos M&iacute;nimos Obligatorios: 
							<blockquote>
								<strong>
								*Serie de la unidad
								<br>
								*Datos del contratante ( Nombre, RFC o Fecha de Nacimiento, Domicilio, Tel&eacute;fono )
								<br>
								*Contratante Persona Moral incluir Articulo 442
								</strong>
							</blockquote>
							<br>
							Para garantizar la descripci&oacute;n correcta de la unidad asegurada, deber&aacute; entregarse:
							<blockquote>
								<strong>
								*Copia legible del documento fuente oficial con datos de la unidad (Factura o REPUVE de preferencia)
								<br>
								*Tarjeta de circulaci&oacute;n para garantizar el correcto n&uacute;mero de serie
								</strong>
							</blockquote>

						</blockquote>
									 ';
					$txtAsteriscos.= '
						</font>
									 ';
				break;
				
				default:
				break;
			}
		break;
	}
?>
</font>