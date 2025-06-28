<?php  
    $this->load->view('capacita/menu_capacita');
    $idPersona = $this->tank_auth->get_idPersona();
	$CI=&get_instance();
    $CI->load->model("preguntamodel", "tutorial");
    $allTutorial = $CI->tutorial->getTutorialList("capacita");
    $fileurl = "https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/modulos_de_tutoria%2F"; //FPROSPECTO%2F29_julio.mp4?alt=media&token="
    $token = "?alt=media&token=";
    //--------------------------
    function validateUrl($url){
        //var_dump($url);
        $header = get_headers($url);
        $getIndex = explode(" ", $header[0]);

        return $getIndex[1] == "200" ? true : false;
    }
    //-------------------------

	$list = array_reduce($allTutorial, function($acc, $curr) use($fileurl, $token){
		$fileForUpload = "";
		$validateFile = validateUrl($fileurl.strtoupper($curr->modulo)."%2F".$curr->nameDoc);

		if($validateFile){
			$getFileData = json_decode(file_get_contents($fileurl.strtoupper($curr->modulo)."%2F".$curr->nameDoc));
			$fileForUpload = $fileurl.strtoupper($curr->modulo)."%2F".$curr->nameDoc.$token.$getFileData->downloadTokens;
		}

		$acc .= '
			<li role="presentation">
				<a role="menuitem" tabindex="-1" data-title="'.$curr->name.'" data-url="'.$fileForUpload.'" target="_blank" class="text-dark" onclick="VerVideo(this)">
					<div><strong>'.$curr->name.'</strong></div>
					<div><small>'.$curr->description.'</small></div>
				</a>
			</li>
		';
		return $acc;
	}, "");
	
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<style type="text/css">
	.wrap{
		width: 100%;
		margin: 10px auto;
	}
	ul#nav-videos.tabs{
		width: 100%;
		background: #363636;
		list-style: none;
		display: flex;
		padding: 0px;
	}
	ul#nav-videos.tabs li{
		width: 20%;
	}
	ul#nav-videos.tabs li > a, #nav-videos.tabs div > a{
		color: #fff;
		text-decoration: none;
		font-size: 11px;
		text-align: center;
		display: flex;
		justify-content: center;
	    align-items: center;
		padding: 7px 3px;
		height: 100%;
	    max-height: max-content;
	}
	#nav-videos.tabs div > a{
		padding: 7px 15px;
	}
	#nav-videos.tabs >li>a.active, .tabs div>a.active, .tabs div>a:hover, .tabs >li>a:hover, .tabs >li>a:focus {
	    cursor: pointer;
	    background-color: #0984CC;
	    height: 100%;
	    max-height: max-content;
	}
	#nav-videos.tabs div > ul > li {
		width: auto;
	}
	#nav-videos.tabs div > ul > li > a {
		display: flex;
		flex-direction: column;
		font-size: 13px;
		width: 400px;
	    white-space: break-spaces;
	}
	#nav-videos.tabs div > ul > li > a > div > small{
		font-size: 90%;
	}
	#nav-videos.tabs div > a > i{
		margin-top: 1px;
		margin-right: 4px;
	}
	.secciones{
		width: 100%;
		background: #fff;
	}
	.secciones article{
		padding: 10px;
	}
	.secciones article p{
		/*text-align: justify;*/
	}
	#loader {
	    position: fixed;
	    left: 0px;
	    top: 0px;
	    width: 100%;
	    height: 100%;
	    z-index: 1040; /*9999*/
	    background: url('../assets/images/loading.gif') 50% 50% no-repeat rgb(249,249,249);
	    opacity: .8;
	}
	.container{
		width: 90%;
		float: left;
	}
	.column-flex-center {
		display: flex;
    	align-items: center;
    	justify-content: center;
	}
	.column-btn-didactico {
	    margin-top: 5px;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	}
	.column-btn-didactico > a {
		font-size: 11px;
	}
	a.btn.btn-primary {
		color: white;
		font-size: 11px;
		transition: 0.5s;
		display: flex;
    	align-items: center;
    	justify-content: center;
	}
	.btn.btn-primary > i, .tab-text > i, #vt-capacita.dropdown-toggle > i {
		font-size: 13px;
	}
	td > a.btn-btn-primary > i {
		margin-top: 1px;
	}
	a.btn-megusta {
		color: #472380;
    	padding: 2px 3px 3px;
    	border: 1px solid white;
		background: white;
    	border-radius: 5px;
    	text-decoration: none;
	}
	a.btn-megusta:hover {
		color: white;
		text-decoration: none;
		cursor: pointer;
		background: #5457cf;
	}
	a.btn-like {
		color: white;
    	border: 1px solid #5473cf;
    	background: #5473cf;
	}
	.btn-status {
		background-color: #6b6293;
		border-color: #6b6293;
		width: 123%;
	}
	.date-video-view {
		margin: 0px;
	}
	/*Modal*/
	.wide.modal-open {
		overflow: auto;
	}
	.videos-capacita-modal > .modal-dialog.modal-lg {
		max-width: 65%;
		transition: all 0.3s ease 0s;
	}
	.modal-position {
		position: sticky;
	}
	.modal-corner {
		border-radius: 5px;
		border-bottom: 0px;
	}
	.modal-minimize {
		width: 50%;
		margin: 0px 0px 5px 0px;
    	left: 1%;
    	bottom: -92%;
	}
	.modal-body-videos-capacita {
		background: #f9f9f9;
		border-radius: 0px 0px 4px 4px;
	}
	.column-select {
		align-items: center;
		padding: 5px;
	}
	.title-result {
		font-size: 1.3em;
	}
	.column-btn-modal-header {
		height: 30px;
		padding: 0px;
    	display: flex;
    	align-items: flex-end;
    	justify-content: flex-end;
	}
	.btn.btn-default.close-list {
		border: 1px solid #ddd;
    	color: #472380;
	}
	.btn-header-modal {
		margin-top: -10px;
		font-size: 25px;
		color: #8974c6;
		border: none;
		background: transparent;
		outline: none;
		height: inherit;
		transition: 0.3s;
	}
	.btn-header-modal:hover  {
		color: #968eff;
	}
</style>
<!-- Navbar -->
<body>
<div class="container">
						    			<?php
   								include('modal_vistas.php');
   								?>
	<div id="loader" style="display: none;"></div>
		<h2 class="mt-4 title-capacita"><i class="fa fa-video-camera"></i> Videos - Capacita</h2>
		<hr>
		<input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="wrap">
			<ul class="tabs" id="nav-videos">
			<?php  
			$i=0;
			foreach ($categorias as $categoria){ $i++;?>
				<li><a href="#tab<?php echo $i;?>" onclick="cargarVideos('<?php echo $categoria->id_capacitacion?>','<?php echo $i;?>')"><span class="tab-text"><i class="fa fa-graduation-cap"></i> <?php echo $categoria->tipoCapacitacion;?></span></a></li>
			<?php }?>
			<?php if(!empty($allTutorial)){?>
				<div class="dropdown">
					<a class="dropdown-toggle" id="vt-capacita" data-target="#" href="" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false"><i class="fa fa-graduation-cap"></i> TUTORIALES</a>
					<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="vt-capacita">
						<?=$list?>	
					</ul>
				</div>
			<?php }?>
			</ul>

				<div class="secciones">
					<!--------- Dennis Castillo [2022-01-21] ---------->
					<!--<div class="col-md-2">
						<?php //$this->load->view("permisosOperativos/tutorialButton");?>
					</div>-->
					<!-------------------------------------------------->
					<div class="col-md-12">
						<?php 
						$i=0;
						foreach ($categorias as $categoria){ $i++;?>
						<article id="tab<?php echo $i;?>">
							<h4><?php echo $categoria->tipoCapacitacion;?></h4>
							<div id="videos<?php echo $i;?>"></div>
						</article>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
</div>
<!-- Modal Solicitud evaluacion-->
<div id="solicitar" class="modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
 	<form name="frm_solicitar" method="post" action="<?=base_url()?>capacita/solicitar_evaluacion">
 		<input type="hidden" name="titulo_solicitud" id="titulo_solicitud">
 		<input type="hidden" name="categoria_solicitud" id="categoria_solicitud">
 		<input type="hidden" name="certificacion_solicitud" id="certificacion_solicitud">
 		<input type="hidden" name="fecha" value="<?php echo date('d-m-Y');?>"> 
 		<div class="modal-dialog" style="width: 80%;font-size: 12px;">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h4 class="modal-title"><i class="fa fa-paper-plane"></i>&nbsp;Solitud Evaluación</h4>
      			</div>
      			<div class="modal-body" style="border-radius: 8px;border-style: solid;border-color: silver;border-width: 1px;margin: 5px;">
          			<table border="0" width="100%">
          				<tr>
          				<td colspan="2"><div id="div_titulo" style="text-align: left;"></div></td>
          				</tr>
          				<tr>
          				<td colspan="2"><div id="div_categoria" style="text-align: left;"></div></td>
          				</tr>
          				<tr>
          				<td colspan="2"><div id="div_subcategoria" style="text-align: left;"></div></td>
          				</tr>
          				<tr><td colspan="2"><hr></td></tr>
          				<tr>
          					<td><b>Usuario:</b></td>
          					<td><?php echo $this->tank_auth->get_username();?></td>
          				</tr>
          				<tr>
          					<td><b>Nombre Completo:</b></td>
          					<input type="hidden" name="nombre_solicitud" id="nombre_solicitud" value="<?php echo $this->tank_auth->get_usernamecomplete();?>">
          					<td><?php echo $this->tank_auth->get_usernamecomplete();?></td>
          				</tr>
          				<tr>
          					<td><b>E-mail:</b></td>
          					<input type="hidden" name="email_solicitud" id="email_solicitud" value="<?php echo $this->tank_auth->get_usermail();?>">
          					<td><?php echo $this->tank_auth->get_usermail();?></td>
          				</tr>
          			</table>
      			</div>
      			<div class="modal-footer">
      				<div class="alert alert-info" style="background-color: #F2F2F2;width: 100%;border-style: none;"><h5 class="column-flex-center"><i class="fa fa-info-circle fa-2x"></i>¿Esta usted seguro de solicitar una evalución del curso?</h5>
	      				<div class="column-flex-center">
	      		 			<button type="submit" class="btn btn-primary" style="font-size: 12px;">Aceptar<i class="fa fa-check" style="margin-left: 3px;"></i></button>
	         				<button type="button" class="btn btn-warning" data-dismiss="modal" style="font-size: 12px;">Cancelar<i class="fa fa-times" style="margin-left: 3px;"></i></button>
	         			</div>
      				</div>
    			</div>
  			</div>
 		</div>
	</form>
</div>
<!-- Modal Video Capacita -->
<div class="modal videos-capacita-modal" id="ModalVideoCapacita" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="ContModal">
        <div class="modal-content modal-corner">
            <!-- Se puede usar el modal para otra información pero solo si se desocupa este espacio -->
            <div class="modal-header column-select">
            	<div class="col-md-10">
                	<h4 class="title-result" id="NameVideoCapacita" style="margin:0px;"></h4>
                </div>
                <div class="col-md-2 column-btn-modal-header">
                	<button type="button" class="btn-header-modal" id="WindowModal" style="font-size: 20px;padding-top: 5px;">
                		<i class="fas fa-minus"></i>
                	</button>
                	<div id="cerrarVideo"><button type="button" class="btn-header-modal" id="CloseModal" data-dismiss="modal" aria-label="Close" onclick="registrarVista(this)">
                	    <i class="fa fa-times-circle" aria-hidden="true"></i>
                	</button></div>
                </div>
            </div>
            <div class="modal-body modal-body-videos-capacita" id="BodyVideoCapacita">
            </div>
            <div class="modal-footer hidden" id="FooterVideoCapacita">
                <button type="button" class="btn btn-default close-list" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		//cargarVideos('1','1');

		$('#CloseModal').click(function() {
			$('#NameVideoCapacita').text("");
    		$('#BodyVideoCapacita').html("");
		})
	})

		/* Ajax*/
	function objetoAjax(){
	var oHttp=false;
	        var asParsers=["Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0",
	        "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
	        for (var iCont=0; ((!oHttp) && (iCont<asParsers.length)); iCont++){
	            try{
	                oHttp=new ActiveXObject(asParsers[iCont]);
	            }
	            catch(e){
	                oHttp=false;
	            }
	        }
	        if ((!oHttp) && (typeof XMLHttpRequest!='undefined')){
	        oHttp=new XMLHttpRequest();
	    }
	return oHttp;
	}

	function votar(n){
		const id = $(n).data('id');
		const user = "<?=$idPersona?>";
		const categ = $(n).data('category');
		const like = n.getAttribute('data-like');
		const thumbs = document.getElementById('Like-'+id);
		var url=document.getElementById('base').value;
		url = url+"capacita/votarvideo";

	    $.ajax({
	        type: "POST",
	        dataType: 'html',
	        url: url,
	        data: {
	        	id:id,
	        	us:user,
	        	ct:categ,
	        	lk:like
	        },
	        success: function(resp){
	        	const r = JSON.parse(resp);
	         	//console.log(r);
	        	//swal("¡Muchas gracias!", "Su voto ha sido recibido.", "success");
	        	//alert("Su voto ha sido recibido, Muchas Gracias...!");
	        	if (r != 0) {
	        		for (var a in r) {
	        			const id = r[a].id;
	        			const valoracion = r[a].valoracion;
	        			$('#Valor-'+id).html(Number(valoracion)+' Valoración');
	        			$(thumbs).removeClass('btn-like');
	         			$(thumbs).html('<i class="far fa-thumbs-up"></i> Me gusta');
	         			thumbs.setAttribute('data-like','0');
	        		}
	        	}
	    	    VideosVistos(user,categ);
	    	    //document.getElementById('valor').innerHTML=parseInt(valor)+1+" Valoracion";
	    	}
    	});
	}

	function vistas(n){
		//const id = $(n).data('video');
		//const user = "<?=$idPersona?>";
		//const categ = $(n).data('category');
		const type = $(n).data('type');
		//const view = n.getAttribute('data-view');
		//var url=document.getElementById('base').value;
		//url = url+"capacita/votarvistas";
		//console.log(id,user,view);
		
    	if (type == 1) {
    		VerVideo(n);
    	}

	    /*$.ajax({
	        type: "POST",
	        dataType: 'html',
	        url: url,
	        data: {
	        	id:id,
	        	us:user,
	        	ct:categ,
	        	vw:view
	        },
	        success: function(data){
	        	const r = JSON.parse(data);
	        	//console.log(r);
	        	if (r != 0) {
	        		for (var a in r) {
	        			const id = r[a].id;
	        			const vistas = r[a].vistas;
	        			$('#Vistas-'+id).html('<i class="fas fa-eye"></i> '+Number(vistas)+' Vistas');
	        		}
	        	}
	        	VideosVistos(user,categ);
	        }
    	});*/
    	//href="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/modulos_de_tutoria%2FCAPACITA%2FVID-20220120-WA0002.mp4?alt=media&token=e5c53cd5-81e5-4f95-8f6e-aaf2a9b59ed9"
	}

	function registrarVista(n){
		const id = $(n).data('video');
		const user = "<?=$idPersona?>";
		const categ = $(n).data('category');
		const view = n.getAttribute('data-view');
		var url=document.getElementById('base').value;
		url = url+"capacita/votarvistas";
		var v = document.getElementById("media");
		var promedio = (v.currentTime/v.duration)*100;
		console.log("entró");
		console.log(promedio);
	if(promedio>85.00){
	    $.ajax({
	        type: "POST",
	        dataType: 'html',
	        url: url,
	        data: {
	        	id:id,
	        	us:user,
	        	ct:categ,
	        	vw:view
	        },
	        success: function(data){
	        	const r = JSON.parse(data);
	        	//console.log(r);
	        	if (r != 0) {
	        		for (var a in r) {
	        			const id = r[a].id;
	        			const vistas = r[a].vistas;
	        			$('#Vistas-'+id).html('<i class="fas fa-eye"></i> '+Number(vistas)+' Vistas');
	        		}
	        	}
	        	VideosVistos(user,categ);
	        }
    	});

	}else{
		console.log("No terminó el video")
	}
	

	}
	function verVistas(idvideo, titulo){
		var url=document.getElementById('base').value;
		url = url+"capacita/votarvistasnombres";
		var datos="";
		console.log(url);
		$.ajax({
	        type: "POST",
	        dataType: 'html',
	        url: url,
	        data: {
	        	id:idvideo,
	        },
	        success: function(data){
	        	const r = JSON.parse(data);
	        	//console.log(r);
	        	if (r != 0) {
	        		for (var a in r) {
	        			titulo = r[a].nombre;
	        			const nombre = r[a].nombreCompleto;
	        			const numero = r[a].numero;
	        			datos=datos+'<tr><td>'+nombre+'</td><td>'+numero+'</td></tr>';
	        			//$('#tablabody').html('<tr><td>'+nombre+'</td></tr>');
	        		
	        		}
	        	}
	        	if(datos===""){
	        		document.getElementById('titulovistas').innerHTML=titulo;
	        		document.getElementById('tablabody').innerHTML='<tr><td colspan="2">No hay vistas</td></tr>';
	        	}else{
	        		document.getElementById('titulovistas').innerHTML=titulo;
	        		document.getElementById('tablabody').innerHTML=datos;
	        	}
	        	
	        }
    	});
	}

	function VerVideo(n) {
		const name = $(n).data('title');
		const link = $(n).data('url');
		const id = $(n).data('video');
		const categ = $(n).data('category');
		const view = n.getAttribute('data-view');
		console.log(link);


    	$('#ModalVideoCapacita').removeClass('modal-position');
		$('#NameVideoCapacita').removeClass('title-result');
    	$('#NameVideoCapacita').text(name);
    	$('#ContModal').removeClass('modal-minimize');
    	$('#ContModal .modal-header').removeClass('modal-corner');
		$('#WindowModal i').addClass('fa-minus');
		$('#WindowModal i').removeClass('fa-window-maximize');
		$('#BodyVideoCapacita').removeClass('hidden');
		$('#cerrarVideo').html(`<button type="button" class="btn-header-modal" id="CloseModal" data-dismiss="modal" aria-label="Close" data-video="${id}" data-category="${categ}" data-type="1" data-view="0" onclick="registrarVista(this)">
                	    <i class="fa fa-times-circle" aria-hidden="true"></i>
                	</button>`)
    	$('#BodyVideoCapacita').html(`
    		<video controls="" autoplay="" name="media" id="media" style="width: -webkit-fill-available;">
    			<source src="${link}" type="video/mp4">
    		</video>
    	`);
        $(".videos-capacita-modal").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });

		
		var value = 0;
		$('#WindowModal').click(function() {
			if (value == 0) {
				$('#ModalVideoCapacita').addClass('modal-position');
				$('#NameVideoCapacita').addClass('title-result');
				$('#ContModal').addClass('modal-minimize');
				$('#ContModal .modal-header').addClass('modal-corner');
				$('#WindowModal i').removeClass('fa-minus');
				$('#WindowModal i').addClass('fa-window-maximize');
				$('#BodyVideoCapacita').addClass('hidden');
				value = 1;
			}
			else {
				$('#ModalVideoCapacita').removeClass('modal-position');
				$('#NameVideoCapacita').removeClass('title-result');
				$('#ContModal').removeClass('modal-minimize');
				$('#ContModal .modal-header').removeClass('modal-corner');
				$('#WindowModal i').addClass('fa-minus');
				$('#WindowModal i').removeClass('fa-window-maximize');
				$('#BodyVideoCapacita').removeClass('hidden');
				value = 0;
			}
		})
	}

    function cargarVideos(sub,i){
    	document.getElementById('loader').style.display="block";
    	divResultado = document.getElementById('videos'+i);  
	    ajax=objetoAjax();   
	    var url=document.getElementById('base').value;
	    var URL=url+"capacita/cargarvideos_categoria/"+sub;
	    ajax.open("GET", URL);
	    ajax.onreadystatechange=function() {
	        if (ajax.readyState==4) {
	            divResultado.innerHTML = ajax.responseText;
	            VideosVistos("<?=$idPersona?>",sub);
	            document.getElementById('loader').style.display="none";
	        }
    	 }
     	 ajax.send(null)  
    }

	function VideosVistos(id,categ) {
		var url=document.getElementById('base').value;
		$.ajax({
	        type: "POST",
	        dataType: 'html',
	        url: `${url}capacita/cargarvideo_visto`,
	        data: {
	        	id:id,
	        	ct:categ
	        },
	        success: function(data){
	        	const r = JSON.parse(data);
	        	console.log(r);

	        	//Formato Fechas
    			var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    			var dias = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

	        	for (const a in r) {
	        		const id = r[a].id;
	        		const id_v = r[a].video_id;
	        		const btn = document.getElementById('Btn-'+id_v);
	        		const like = document.getElementById('Like-'+id_v);
	        		const fecha = new Date(r[a].ultimo_acceso);
                    const ult = dias[fecha.getDay()]+" "+fecha.getDate()+" de "+meses[fecha.getMonth()]+" del "+fecha.getFullYear();
                    //console.log("id: "+id+", video_id: "+id_v+", ultimo acceso: "+fecha+", formato: "+ult);
                    switch(r[a].accion) {
                    	case 'ver':
	        				$(btn).addClass('btn-status');
	        				$(btn).html('<i class="far fa-eye"></i>&nbsp;Visto');
	        				$('#FechaVista-'+id_v).text('Último acceso: '+ult);
	        				btn.setAttribute('data-view',id);
	        			break;
	        			case 'calificar':
	        				$(like).addClass('btn-like');
	        				$(like).html('<i class="fas fa-thumbs-up"></i> Te gusta');
	        				like.setAttribute('data-like',id);
	        			break;
	        		}
	        	}
	        }
    	});
	}

    function setTitulo(titulo,categoria,subcategoria){
		document.getElementById('div_titulo').innerHTML="<h3>"+titulo+"</h3>";
		document.getElementById('div_categoria').innerHTML="<b>Categoria: </b>"+categoria;
		document.getElementById('div_subcategoria').innerHTML="<b>Certificación: </b>"+subcategoria;
		document.getElementById('titulo_solicitud').value=titulo;
		document.getElementById('categoria_solicitud').value=categoria;
		document.getElementById('certificacion_solicitud').value=subcategoria;
	}

	$('ul.tabs li a:first').addClass('active');
	$('.secciones article').hide();
	$('.secciones article:first').show();

	$('ul.tabs li a').click(function(){
		$('ul.tabs li a').removeClass('active');
		$(this).addClass('active');
		$('.secciones article').hide();

		var activeTab = $(this).attr('href');
		$(activeTab).show();
		//$('#vt-capacita').dropdown();
		//if(activeTab !== "javascript: void(0)"){
			//$(activeTab).show();
		//}
		return false;
	});
</script>
  <!-- jQuery CDN - Slim version (=without AJAX) -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <!-- Popper.JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script> -->
    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<?php $this->load->view('footers/footer'); ?>
