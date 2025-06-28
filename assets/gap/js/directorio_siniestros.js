

$(function(){

});

function getSiniestrosActivos(IDCli){
  console.log("path-test",IDCli);
  const $path = $("#base_url").attr("data-base-url");
  //PeticiÃ³n AJAX: GET
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("GET",`${$path}directorio/getSiniestros?id=${IDCli}`,true);
  xmlhttp.onreadystatechange=function(){
      if(this.readyState==4 && this.status==200){
          var respuesta=JSON.parse(this.responseText);
          var contenido='';
          console.log("r",respuesta);
          for(var elemento in respuesta){
              var date=new Date(respuesta[elemento].inicio_ajuste);
              console.log("parsed",date);
              contenido+=`
                <tr>
                  <th scope="row">${respuesta[elemento].siniestro_id}</th>
                  <td scope="row">${respuesta[elemento].poliza}</td>
                  <td scope="row">${dateToYMD(date)}</td>
                  <td scope="row">${tipoS(respuesta[elemento].tipo_r)}</td>
                  <td>
                    <a class="btn btn-primary" style="background-color: #472380;" href="${getUrl(respuesta[elemento].tipo_r,respuesta[elemento].id)}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp VER</a>
                  </td>
                </tr>
              `;
          }
          $("#siniestro_tabla").html('');
          $("#siniestro_tabla").html(contenido);
          $("#modal_info_siniestros").modal("show");
      }
  }
  xmlhttp.send();
}

//parsear la fecha de los registrps
function dateToYMD(date) {
  var d = date.getDate();
  var m = date.getMonth() + 1; //Month from 0 to 11
  var y = date.getFullYear();
  return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
}

//obtner el tipo de registro
function tipoS(tipo){
  var rTipo='';
  switch (tipo) {
    case 'D':
        rTipo='DAÑOS';
      break;
    case 'G':
      rTipo='GASTOS MÉDICOS';
      break;
    case 'A':
      rTipo='AUTOS INDIVIDUAL';
      break;
  }
  return rTipo;
}

//obtner la url de la vista tipo de registro
function getUrl(tipo,idsiniestro){
  const $path = $("#base_url").attr("data-base-url");
  var rTipo=$path;
  switch (tipo) {
    case 'D':
        rTipo+=`Danos?registro=${idsiniestro}`;
      break;
    case 'G':
      rTipo+=`GMM?registro=${idsiniestro}`;
      break;
    case 'A':
      rTipo+=`Autos?registro=${idsiniestro}`;
      break;
  }
  return rTipo;
}