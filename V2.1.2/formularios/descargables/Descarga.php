<?php
extract($_REQUEST);
	
	$files[]="flotillas.xls";
	$files[]="flotillas.xlsx";
	$files[]="danos_embarcaciones.doc";
	$files[]="danos_embarcaciones.docx";
	$files[]="danos_obra_civil.xls";
	$files[]="danos_obra_civil.xlsx";
	$files[]="danos_protecciones_bienes_empresariales.doc";
	$files[]="danos_protecciones_bienes_empresariales.docx";
	$files[]="danos_rc_equipo_contratistas.xls";
	$files[]="danos_rc_equipo_contratistas.xlsx";
	$files[]="danos_rc_medico.xls";
	$files[]="danos_rc_medico.xlsx";
	$files[]="danos_solicitud_hogar.doc";
	$files[]="danos_solicitud_hogar.docx";
	$files[]="danos_transporte_especifico.xls";
	$files[]="danos_transporte_especifico.xlsx";
	$files[]="automoviles.xlsx";
	$files[]="danos_embarcaciones.xlsx";
	$files[]="danos_protecciones_bienes_empresariales.xlsx";
	$files[]="rc_actividades_inmuebles.xlsx";
	
	
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