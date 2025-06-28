<?php
//$PHP_SELF = $_SERVER["PHP_SELF"];
  class basedatos {
        //Variables Privadas
        var $Servidor;
        var $BaseDatos;
        var $PasswordBD;
        var $LoginBD;
        var $Posicion;
        var $NumeroRegistros;
        var $EOF;
        var $Datos;
        var $Result;
        function basedatos(){
                 $this->Servidor = "localhost";
				 $this->BaseDatos = "ptbmx_pbt";
				 $this->LoginBD = "ptbmx_bd";
				 $this->PasswordBD = "pbt23102010";
				/*
                 $this->Servidor = "localhost";
				 $this->BaseDatos = "pbt";
				 $this->LoginBD = "root";
				 $this->PasswordBD = "";
				 */
			 
        }
		function EjecutarInstruccion($CadenaSQL){
                 //Usando ODBC para ejecutar Sentencias				 
				 $this->Conexion = @mysql_connect($this->Servidor, $this->LoginBD, $this->PasswordBD);// or die(mysql_errno().": ".mysql_error()."<br>Error en la conexion");
				if($this->Conexion==NULL) {
					$this->Conexion = mysql_connect($this->Servidor, "ptbmx_bd","ptb23102010") or die(mysql_errno().": ".mysql_error()."<br>Error en la conexion");
				}				 
                 mysql_select_db($this->BaseDatos, $this->Conexion) or die("Error en la seleccion de la base de datos");
                 //Dividimos todos los queries que nos esten enviando
                 $CadenasSQL = explode(";",trim($CadenaSQL));		 
                 //Ejecutamos 1 a 1 las instrucciones
                 $NumeroCadenas = sizeof($CadenasSQL) -1;
                 for ($i = 0; $i < $NumeroCadenas; $i++){
                     $Query = $CadenasSQL[$i] . ";";
                     $Respuesta = mysql_query($Query, $this->Conexion);
                     if ($Respuesta == FALSE)
                         break;
                 }
				// $this->NumeroRegistros = mysql_num_rows($Respuesta);
                 mysql_close($this->Conexion);
                 if ($Respuesta == FALSE){
                     die ("Error al Ejecutar las siguiente instrucción: $Query");
                 }else{
					 $this->Result = $Respuesta;
                     $Respuesta = TRUE;
                 }
                 return $Respuesta;
        }

        function EjecutarConsulta($CadenaSQL){
				$this->Conexion = @mysql_connect($this->Servidor, $this->LoginBD, $this->PasswordBD);// or die(mysql_errno().": ".mysql_error()."<br>Error en la conexion");
				if($this->Conexion==NULL) {
					$this->Conexion = mysql_connect($this->Servidor, "ptbmx_bd","pbt23102010") or die(mysql_errno().": ".mysql_error()."<br>Error en la conexion");
				}	
                 mysql_select_db($this->BaseDatos, $this->Conexion) or die(mysql_errno().": ".mysql_error()."<br>Error en la seleccion de la base de datos");
                 //Inicializamos valores
                 $this->Posicion = 0;
                 $this->NumeroRegistros = 0;

                 //Dividimos todos los queries que nos esten enviando
                 $CadenasSQL = explode(";",trim($CadenaSQL));				 
                 $NumeroCadenas = sizeof($CadenasSQL) -1;
                 for ($i = 0; $i < $NumeroCadenas; $i++){
				 	//Ejecutamos 1 a 1 las instrucciones
                     $Query = $CadenasSQL[$i] . ";";
                     $Respuesta = mysql_query($Query, $this->Conexion) or die (mysql_errno().": ".mysql_error()."<br>Error Conexion <br>. $CadenaSQL");;
                     if ($Respuesta == FALSE)
                         break;
                 }
				 //Retoma el ultimo resultado
                 $this->Result = $Respuesta;
                 $this->NumeroRegistros = mysql_num_rows($this->Result);

                  mysql_close($this->Conexion);
				 if($this->NumeroRegistros > 0){
                    $this->ObtenerRegistro();
                    $this->DatosEnVariables();
                    //Checamos si ya estamos en el final
                    $this->EOF = ($this->NumeroRegistros <= 0) ? TRUE:FALSE;
                    return TRUE;
                 }else{
                    $this->EOF = TRUE;
                    return FALSE;
                 }
        }

        function ObtenerRegistro (){
                 //Colocamos los datos
                 $this->Datos = null;
                 if ($this->Posicion < $this->NumeroRegistros){
                     $Fila = mysql_fetch_array($this->Result);
                     $this->Datos[$this->Posicion] = $Fila;
                 }
        }

        function Siguiente(){
                 if ($this->NumeroRegistros > 0 && $this->Posicion < $this->NumeroRegistros-1){
                     $this->Posicion++;
                     $this->ObtenerRegistro();
                     $this->DatosEnVariables();
                 }else{
                     $this->EOF = TRUE;
                 }
        }

        function Anterior(){
                 if ($this->NumeroRegistros > 0 && $this->Posicion > 0){
                     $this->Posicion--;
                     mysql_data_seek($this->Result, $this->Posicion);
                     $this->ObtenerRegistro();
                     $this->DatosEnVariables();
                     $this->EOF = FALSE;
                 }
        }

        function Fin (){
                 if ($this->NumeroRegistros > 0){
                     $this->Posicion = $this->NumeroRegistros-1;
                     mysql_data_seek($this->Result, $this->Posicion);
                     $this->ObtenerRegistro();
                     $this->DatosEnVariables();
                     $this->EOF = TRUE;
                 }
        }

        function Inicio (){
                 if ($this->NumeroRegistros > 0){
                     $this->Posicion = 0;
                     mysql_data_seek($this->Result, $this->Posicion);
                     $this->ObtenerRegistro();
                     $this->DatosEnVariables();
                     $this->EOF = FALSE;
                 }
        }

        function DatosEnVariables(){

        }

        function Cerrar (){
                 mysql_free_result($this->Result);
                 mysql_close($this->Conexion);
        }
  }
?>