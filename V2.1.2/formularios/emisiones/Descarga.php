<?php
extract($_REQUEST);
	
	$files[]="casa_habitacion.xlsx";
	$files[]="embarcaciones_placer.xlsx";
	$files[]="empresarial.xlsx";
	$files[]="incendio.xlsx";
	$files[]="obra_civil.xlsx";	
	$files[]="obra_civil_cuestionario.xlsx";
	$files[]="rc_equipo_contratista.xlsx";
	$files[]="rc_medico.xlsx";
	$files[]="transporte_especifico.xlsx";

    if(strpos($file,"/")!==false){die("No puedes navegar por otros directorios");}

	if(count($files) > 0){
    if(!in_array($file,$files)){
        die("<b>ERROR!</b> no es posible descargar $file");
    }
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$file\"\n");
    $fp=fopen("$file", "r");
    fpassthru($fp);
	}
?>