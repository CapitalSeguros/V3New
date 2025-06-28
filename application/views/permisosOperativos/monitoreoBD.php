<link href="https://fonts.googleapis.com/css2?family=Material+Icons"
      rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined"
      rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Icons+Round"
      rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp"
      rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Icons+Two+Tone"
      rel="stylesheet">
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-12">
            <h3 class="title-section-module">Monitore Base de Datos</h3>
        </div>
    </div>
    <hr />
<div style="overflow: scroll;width:100%;height: 400px">
<table class="table">
	<thead style="position: sticky;top: 0px">
		<tr><th colspan="9"><button class="btn btn-info " onclick="traerInfoBD()"><span class="material-icons-outlined">
sync
</span></button></th></tr>
		<tr><th>Id</th><th>User</th><th>Host</th><th>DB</th><th>Command</th><th>Time</th><th>State</th><th>Info</th><th></th></tr>
	</thead>
   <tbody id="monitoreoBDBody"></tbody>
</table>
</div>    
</section>
<script type="text/javascript">
	function  traerInfoBD(datos='')
	{
     if(datos=='')
     {
     	parametros='';
       controlador="permisosOperativos/infoBD/?";
      peticionAJAX(controlador,parametros,'traerInfoBD');
     }
     else
     { 
     	let tr='';
     	datos.procesosList.filter(procesos=>{
            tr+=`<tr><td>${procesos.Id}</td><td>${procesos.User}</td><td>${procesos.Host}</td><td>${procesos.db}</td><td>${procesos.Command}</td><td>${procesos.Time}</td><td>${procesos.State}</td><td>${procesos.Info}</td><td><button class="btn btn-danger bt-sm" onclick="procesoMatar('',${procesos.Id})"><span class="material-icons-outlined">
delete
</span></button></td></tr>`; 
     	})
     	document.getElementById('monitoreoBDBody').innerHTML=tr;
     }
	}

	function procesoMatar(datos='',id)
	{
		if(datos=='')
		{
                 	parametros=`id=${id}`;
       controlador="permisosOperativos/procesoMatar/?";
      peticionAJAX(controlador,parametros,'procesoMatar');
		}
		else
		{
			traerInfoBD('');
		}
	}
</script>