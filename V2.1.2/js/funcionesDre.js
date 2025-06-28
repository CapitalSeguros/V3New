// JavaScript Document
function popFormulario(url) {
	popFormularioWindow = window.open(
		url,'_blank','height=680,width=700,left=10,top=10,screenX=10,screenY=10,direcciones=false,scrollbars=yes')
}

$(document).ready(function(){
// modelo_auto
	$("#marca_auto").change(function(event){
		var marca_auto = $("#marca_auto").val();
		ModelosAuto(marca_auto);
	});	
	function ModelosAuto(marca_auto){
		$.ajax({
				type:"POST",
				url:"formularios/modeloAuto.post.php",
				data:{marca_autoPost:marca_auto},
				success: function(data){ 
					$("#modelo_autoDiv").html(data);
				}
		});
	} // fin hab1AdulNumero	   	
});