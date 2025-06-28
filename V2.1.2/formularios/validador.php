<?php

	require_once('../nusoap-0.9.5-Aba-Personas/lib/nusoap.php');
	$urlCliente = "http://www5.abaseguros.com/PersonaConnect/PCRegistro.svc?wsdl"; // url del WSDL
	$pass = "VIRTUAL1$";
	$user = "WSAGECAP";
	$client = new nusoap_client($urlCliente, true);
/*
	$header = '
    	  <tem:strEntrada>
			&lt;XML&gt;
				&lt;DP&gt;
					&lt;TP&gt;'.$TP.'&lt;/TP&gt; <!-- 1:Moral; 0:fisica; -->
					&lt;FISICA&gt;
						&lt;RFC&gt;'.$RFC.'&lt;/RFC&gt;
						&lt;HCVE&gt;'.$HCVE.'&lt;/HCVE&gt;
						&lt;PNOM&gt;'.$PNOM.'&lt;/PNOM&gt;
						&lt;SNOM&gt;'.$SNOM.'&lt;/SNOM&gt;
						&lt;APP&gt;'.$APP.'&lt;/APP&gt;
						&lt;APM&gt;'.$APM.'&lt;/APM&gt;
						&lt;SEXO&gt;'.$SEXO.'&lt;/SEXO&gt; <!-- 0:Femenino; 1:Masculino; -->
						&lt;EDOCIVIL&gt;'.$EDOCIVIL.'&lt;/EDOCIVIL&gt; <!-- 1:Casado; 2:Soltero; 3:Viudo; 4:Divorciado; -->
					&lt;/FISICA&gt;
					&lt;DOMICILIO&gt;
						&lt;TIPODIR&gt;1&lt;/TIPODIR&gt; <!-- 1:Particular; 2:Domicilio Extranjero; 3:Fiscal; -->
						&lt;CALLE&gt;'.$CALLE.'&lt;/CALLE&gt;
						&lt;NUMEXT&gt;'.$NUMEXT.'&lt;/NUMEXT&gt;
						&lt;NUMINT&gt;'.$NUMINT.'&lt;/NUMINT&gt;
						&lt;COL&gt;'.$COL.'&lt;/COL&gt;
						&lt;CP&gt;'.$CP.'&lt;/CP&gt;
						&lt;POB&gt;'.$POB.'&lt;/POB&gt;
					&lt;/DOMICILIO&gt;
					&lt;TELEFONO&gt;
						&lt;LADA&gt;'.substr($NUMERO_TELEFONO,0,2).'&lt;/LADA&gt;
						&lt;NUMERO&gt;'.substr($NUMERO_TELEFONO,2,8).'&lt;/NUMERO&gt;
					&lt;/TELEFONO&gt;
					&lt;CELULAR&gt;
						&lt;LADA&gt;'.substr($NUMERO_CELULAR,0,2).'&lt;/LADA&gt;
						&lt;NUMERO&gt;'.substr($NUMERO_CELULAR,2,8).'&lt;/NUMERO&gt;
					&lt;/CELULAR&gt;
					&lt;CORREO&gt;'.$CORREO.'&lt;/CORREO&gt;
				&lt;/DP&gt;
			&lt;/XML&gt;
    	  </tem:strEntrada>
    	  <tem:Token>
        	 <abas:password>'.$pass.'</abas:password>
	         <abas:usuario>'.$user.'</abas:usuario>
	      </tem:Token>
			  ';
*/
$header = '    	  <tem:strEntrada>
			&lt;XML&gt;
				&lt;DP&gt;
					&lt;TP&gt;0&lt;/TP&gt; <!-- 1:Moral; 0:fisica; -->
					&lt;FISICA&gt;
						&lt;RFC&gt;SABA790315&lt;/RFC&gt;
						&lt;HCVE&gt;&lt;/HCVE&gt;
						&lt;PNOM&gt;ALEJANDRO&lt;/PNOM&gt;
						&lt;SNOM&gt;&lt;/SNOM&gt;
						&lt;APP&gt;BUENO&lt;/APP&gt;
						&lt;APM&gt;SALDAÑA&lt;/APM&gt;
						&lt;SEXO&gt;1&lt;/SEXO&gt; <!-- 0:Femenino; 1:Masculino; -->
						&lt;EDOCIVIL&gt;2&lt;/EDOCIVIL&gt; <!-- 1:Casado; 2:Soltero; 3:Viudo; 4:Divorciado; -->
					&lt;/FISICA&gt;
					&lt;DOMICILIO&gt;
						&lt;TIPODIR&gt;1&lt;/TIPODIR&gt; <!-- 1:Particular; 2:Domicilio Extranjero; 3:Fiscal; -->
						&lt;CALLE&gt;EL PORVENIR&lt;/CALLE&gt;
						&lt;NUMEXT&gt;1&lt;/NUMEXT&gt;
						&lt;NUMINT&gt;&lt;/NUMINT&gt;
						&lt;COL&gt;ZONA MILITAR&lt;/COL&gt;
						&lt;CP&gt;24000&lt;/CP&gt;
						&lt;POB&gt;CAMPECHE&lt;/POB&gt;
					&lt;/DOMICILIO&gt;
					&lt;TELEFONO&gt;
						&lt;LADA&gt;99&lt;/LADA&gt;
						&lt;NUMERO&gt;99102030&lt;/NUMERO&gt;
					&lt;/TELEFONO&gt;
					&lt;CELULAR&gt;
						&lt;LADA&gt;99&lt;/LADA&gt;
						&lt;NUMERO&gt;99405060&lt;/NUMERO&gt;
					&lt;/CELULAR&gt;
					&lt;CORREO&gt;MESADECONTROL@AGENTECAPITAL.COM&lt;/CORREO&gt;
				&lt;/DP&gt;
			&lt;/XML&gt;
    	  </tem:strEntrada>
    	  <tem:Token>
        	 <abas:password>VIRTUAL1$</abas:password>
	         <abas:usuario>WSAGECAP</abas:usuario>
	      </tem:Token>';
	$client->setHeaders($header);
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;
	$xml = '';

	$client->call('RegistraPersona', '', 'http://tempuri.org/PCRegistro/', 'http://tempuri.org/PCRegistro/RegistraPersona', false, false, false, false);

echo '<h2>Request</h2><pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>';
echo '<h2>Response</h2><pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>';

?>