function Getpermisos (){
    const $path = $("#base_url").attr("data-base-url");
    var localurl=window.location.href.split('?')[0];
    var replace=localurl.replace($path,'');
    //console.log("replace",replace);
    //console.log("url",window.location.href.split('?')[0]);
    $.ajax({
      type: 'POST',
      url: `${$path}Permisos/getPermisos`,
      data:{
        url:replace
      },
      success: function (data) {
        //console.log("dataPOST",data.data[0]);
        var permisos=data.data.length>0?JSON.parse(data.data[0].permisos):[];
        elementsTags(permisos);
          //datatable.ajax.reload();
      },
      error: function (data) {

      }
    });
}


function elementsTags (data){
  //console.log(data);
  var count=0;
  $("[data-permiso='permiso']").each(function() {
    var permiso=$(this).data('accion-permiso');
    count++;
    //console.log("elm"+count,$(this).data('accion-permiso'));
    const newData = data.filter((item, index) =>item.clase === permiso && item.permiso===true);
    if(newData.length>0){
      //console.log("si tiene permiso");
    }else{
      //console.log("No tiene permiso");
      $(this).remove();
    }
  });
  //console.log('count',count);
}