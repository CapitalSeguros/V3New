<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
	<iframe width="100%" height="900px" id="frameSicasUsuario1" src="<?php echo($codeSicas); ?>" allowfullscreen></iframe>


<!--embed src="<?php echo($codeSicas); ?>" type="text/html" width="100%" height="900px"></embed-->
<!--object data="https://www.easycot.net/MainMenu.aspx?CodeAuth=7yETwtq47TLgmLbmQYoX6jtJngDEzwWEgVRPzR4xK4jVNIAruYlK2yZfw5CgpOmKOSJYDXjXtLMP4xzmjhCeh2Rbc8ijlRQTyCuzU5QN5QApESLfIqS9kJwixZQi3L&CodeAuthUser=8SM0QfJoMuR8hQm/AFKCscIVS8GL4BEn5F6fkdSwLOa8ASx08LSQKoTHTKBqmR8L" width="600" height="400">
    <embed src="https://www.easycot.net/MainMenu.aspx?CodeAuth=7yETwtq47TLgmLbmQYoX6jtJngDEzwWEgVRPzR4xK4jVNIAruYlK2yZfw5CgpOmKOSJYDXjXtLMP4xzmjhCeh2Rbc8ijlRQTyCuzU5QN5QApESLfIqS9kJwixZQi3L&CodeAuthUser=8SM0QfJoMuR8hQm/AFKCscIVS8GL4BEn5F6fkdSwLOa8ASx08LSQKoTHTKBqmR8L" width="600" height="400"> </embed>
    Error: Embedded data could not be displayed.
</object-->
<script type="text/javascript">

 
	window.onload=function(){
		abrirEnPestana("<?php echo($codeSicas); ?>");
	}
function abrirEnPestana(url) {
		var a = document.createElement("a");
		a.target = "_blank";
		a.href = url;
		a.click();
	}
 


</script>

