<? $this->load->view('headers/header'); ?>
<? $this->load->view('headers/menu'); ?>
<?	
	$colorRef[0] = "5";
	$colorRef[1] = "8";
	$colorRef[2] = "11";
	$colorRef[3] = "14";
	$colorRef[4] = "17";
	$colorRef[5] = "20";
	$colorRef[6] = "23";
	$colorRef[7] = "26";
	$colorRef[8] = "29";
	$colorRef[9] = "32";
	$colorRef[10] = "";
	$colorRef[11] = "";
	$colorRef[12] = "";
	$colorRef[13] = "";
	$colorRef[14] = "";

	$graficaRef		= base_url().'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=';
	$graficaBarras	= base_url()."assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=";
	$graficaPastel	= base_url()."assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=";
	$graficaPorcen	= base_url()."assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=";
?>
<section>
<form  action="<?=base_url();?>monitores/verSeguimiento" method="POST" class="form">
    <input type="date" name="fecha_inicial" value="20-11-2016" >
    <input type="date" name="fecha_final"  value="20-11-2016">
	<input type="submit" name="Consulta" id="Consulta" value="Consulta">
</form>	

</section>
<section>
	<?  echo($consulta);
	   if (isset($ConsultaActividades)){
	   //	echo($consulta);
	   	 // 	echo($consulta2);
	   	  var_dump($ConsultaActividades) ;
		foreach ($ConsultaActividades as $key ) {
		echo "bien";
	}
		}  ?>
</section>