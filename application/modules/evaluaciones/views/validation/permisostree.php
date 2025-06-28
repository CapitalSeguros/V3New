<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> -->
<style>
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative
}
.tree li::before, 
.tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:2px solid #000;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:2px solid #000;
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
   /*  border:2px solid #000; */
    border-radius:3px;
    display:inline-block;
    padding:3px 8px;
    text-decoration:none;
    cursor:pointer;
}
.tree>ul>li::before,
.tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:27px
}
.tree li span:hover {
    /* background: hotpink; */
    /* border:2px solid #94a0b4; */
}


[aria-expanded="false"] > .expanded,
[aria-expanded="true"] > .collapsed {
  display: none;
}
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="title-section-module">Permisos</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 column-flex-bottom">
            <ol class="breadcrumb text-right" style="padding: 8px 15px;">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
            </ol>
        </div>
    </div>
    <hr />
</section>
<div class="col-md-12" style="float: left; width: 100%;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="my-input">Seleccione un puesto</label>
                            <select name="puestos" id="puestos" class="form-control" onchange="getUsers('1')">
                            <option value="">Seleccione uno</option>
                            <?php foreach($puestos as $value): ?>
                                <optgroup label="<?=$value["label"]?>">
                                    <?php foreach($value["options"] as $itm): ?>
                                        <option value="<?=$itm["value"]?>"><?=$itm["label"]?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="my-input">Seleccione un usuario</label>
                            <select name="usuario" id="usuarios" class="form-control" onchange="cambioUsuario()">
                            <option value="">Seleccione uno</option>
                            </select>
                        </div>
                    </div>
</div>
    <div class="col-md-12">
        <div class="panel panel-default segment-sms" style="margin: 0px;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 hidden" id="permisos_copy">
                        <div class="form-group">
                            <button class="btn btn-primary pull-right" onclick="OpenModal()">Copiar permisos</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="border-right: 1px solid #e7dede;">
                  <!--   referencia del la estructura  https://bootsnipp.com/snippets/orp8g-->
                        <div class="tree" style="height: 350px;overflow: auto;">
                            <ul style="margin: 0px;">
                                <li>
                                    <span>
                                        <a style="color:#000; text-decoration:none;" >
                                            <i class="expanded"><i class="fa fa-folder"></i></i> Módulos
                                        </a>
                                    </span>
                                    <div id="Web" class="show collapse in" style="padding-left: 40px; max-height:70vh;" >
                                    <ul>
                                    <?php foreach($modulos as $value): ?>
                                       <!--  <li ><span><i class="fa fa-folder"></i><a> <?=$value["nombre"]?> <input type="checkbox" name="C_<?=$value["nombre"]?>" id="C_<?=$value["nombre"]?>"></a></span></li> -->
                                        <li >
                                            <span data-grupo="grupo" data-nombre="<?=$value["nombre"]?>">
                                                <a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#<?=$value["nombre"]?>" aria-expanded="false" aria-controls="<?=$value["nombre"]?>">
                                            <i class="collapsed"><i class="fa fa-folder"></i></i>
                                                    <i class="expanded" ><i class="fa fa-folder-open"></i></i>
                                                    <input type="checkbox" class="form-check-input checkbox-item check-permisos CH" id="CH_<?=$value["nombre"]?>" data-CH="CH_<?=$value["nombre"]?>" onclick="return false;" style="margin-top: 0px;">
                                                    <?=$value["nombre"]?>
                                                </a> 
                                            </span>
                                            <ul>
                                                <div id="<?=$value["nombre"]?>" class="collapse" style="padding-left: 40px;">
                                                    <?php foreach($value["items"] as $item): ?>
                                                       
                                                        <li onclick='getPermisos("<?=$item["url"]?>","<?=$item["id"]?>","<?=$item["nombre"]?>")'>
                                                            <span data-modulo="modulo" data-nombre="<?=$item["nombre"]?>">
                                                                <i class="fa fa-file"></i>
                                                                <a>
                                                                    <input type="checkbox" class="form-check-input checkbox-item check-permisos CH" id="CH_<?=$item["nombre"]?>" data-CH="<?=$item["nombre"]?>" onclick="return false;" style="margin-top: 0px;">
                                                                    <?=$item["nombre"]?> 
                                                                </a>
                                                            </span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </div>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                        
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 hidden" id="permisos-d" style="height: 350px;overflow: auto;">
                        <div>
                        <h5 id="titulo_permisos">Permisos disponibles</h5>
                        </div>
                        <!-- <br> -->
                        <div class="row">
                            <?php foreach($acciones as $value): ?>
                                <div class="col-xs-6">
                                <div class="checkbox column-flex-center">
                                    <label>
                                        <input type="checkbox" class="form-check-input checkbox-item check-input c-permiso" name="<?=$value["nombre"]?>" id="<?=$value["nombre"]?>" data-clase="<?=$value["clase"]?>"  style="margin-top: 0px;">
                                    </label>
                                    <label class="textLabel" style="padding: 0px 5px;">
                                        <?=$value["nombre"]?>
                                    </label>
                                </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div>
                        <button class="btn btn-primary pull-right" onclick="AccionModulos()">Aplicar</button>
                        </div>
                    </div>
                </div>
            </div><!-- panel-body -->
        </div><!-- panel-default -->
    </div>

<!-- modal para copiar permisos -->
<div class="modal fade" id="modal_tipos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="false" >
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Copiar permisos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                   
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="my-input">Seleccione un puesto</label>
                                <select name="puestos_c" id="puestos_c" class="form-control" onchange="getUsers('2')">
                                <option value="">Seleccione uno</option>
                                <?php foreach($puestos as $value): ?>
                                    <optgroup label="<?=$value["label"]?>">
                                        <?php foreach($value["options"] as $itm): ?>
                                            <option value="<?=$itm["value"]?>"><?=$itm["label"]?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="my-input">Seleccione un usuario</label>
                                <select name="usuario_c" id="usuarios_c" class="form-control">
                                <option value="">Seleccione uno</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" onclick="SendCopy()">Guardar</button>
                </div>
            </div>
    </div>
</div>
<script>
$(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");
    var id_modulo=0;var id_permisos=0;var id_url=0; var url_string='';
    var nombreM='';

    window.getPermisos=function(url,id_urlg,nombre){
        id_permisos=0;
        url_string=url;
        nombreM=nombre!=''?nombre:nombreM;
        let id_usuario=$("#usuarios").val();
        id_url=id_urlg;
        //console.log('usuario',id_usuario);
        if(id_usuario==''){
            return  toastr.error("Seleccione un usuario");
           
        }
        console.log("url",url);
        $.ajax({
                type: 'POST',
                url: `${$path}Permisos/getPermisosForm`,
                data: {
                    "url": url,
                    "id_usuario":id_usuario
                },
                success: function (data) {
                    //console.log(data);
                    var rdata=[];
                    if(data.data.length>0){
                        id_permisos=data.data[0].id_permiso;
                        rdata=JSON.parse(data.data[0].permisos);
                    }
                    //console.log(rdata);
                    checkPermisos(rdata);
                    $('#permisos-d').removeClass('hidden');
                    $('#titulo_permisos').html('');
                    $('#titulo_permisos').html('<strong>Permisos del módulo:</strong> '+ nombreM);
                },
                error: function (data) {

                }
            });
    }


    window.getUsers=function(tipo){
        //console.log("id_puesto",$("#puestos").val());
        var id=tipo==1?$("#puestos").val():$("#puestos_c").val();
        $.ajax({
                type: 'POST',
                url: `${$path}Permisos/getUsers`,
                data: {
                    "id_puesto": id,
                },
                success: function (data) {
                    var opciones=setEmpleados(data.data);
                    //console.log(opciones);
                    if(tipo==1){
                        $('#usuarios').html('');
                        $('#usuarios').html(opciones);
                    }else{
                        $('#usuarios_c').html('');
                        $('#usuarios_c').html(opciones);
                    }
                },
                error: function (data) {

                }
            });
    }

    window.setEmpleados=function(data){
        var option='<option value="">Seleccione uno</option>';
        data.forEach((element,key)=>{//${element.id==1?"selected":''}
            option+=`<option value="${element.value}" >${element.label}</option>`;
        });
        return option;
    }

    window.checkPermisos=function(data){
        console.log("dtads",data);
        cleanInputs();
        data.forEach(element => {
            console.log("nombre "+element.clase+ " permiso "+ element.permiso)
            //$(`#${element.clase}`).prop('checked', element.permiso);
            $(`[data-clase='${element.clase}']`).prop('checked', element.permiso);
         });
    }

    window.cleanInputs=function(){
        $(".c-permiso").each(function() {
            $(this).prop('checked', false);
        });
    }

    window.cleanUrl=function(){
        $("[data-modulo='modulo']").each(function() {
            $(this).css("background-color", "white");
        });
    }

    window.cleanModulos=function(){
        $("[data-grupo='grupo']").each(function() {
            $(this).css("background-color", "white");
        });
        $(".CH").each(function() {
            $(this).prop('checked', false);
        });
    }

    window.cambioUsuario=function(){
        $('#permisos-d').addClass('hidden');
        getModulos();
        let usr=$('#usuarios').val();
        usr? $('#permisos_copy').removeClass('hidden'): $('#permisos_copy').addClass('hidden');
        /* if(usr){
            $('#permisos_copy').removeClass('hidden')
        }else */

    }


    window.AccionModulos=function(){
        /* if(id_usuario==''){
            return  toastr.error("Seleccione un usuario");
        } */
        //console.log('id_permisos',id_permisos);
        //console.log('id_url',id_url);
        let url=url_string;
        var checkboxarray=[];
            $(".check-input").each(function() {
                if($(this).is(":checked")){
                    checkboxarray.push({
                        nombre:$(this).attr('name'),
                        clase:$(this).data('clase'),
                        permiso:$(this).is(":checked")?true:false
                    });
                }
                //mvar += $(this).html();
        });
        var data={
            id_permiso:id_permisos,
            id_url:id_url,
            id_persona:$("#usuarios").val(),
            acciones:checkboxarray.length>0?JSON.stringify(checkboxarray):''
        }
        //console.log('datasend',data);
        $.ajax({
                type: 'POST',
                url: `${$path}Permisos/Accionespermisos`,
                data: data,
                success: function (response) {
                    getPermisos(url,data.id_url,'');
                    getModulos();
                    toastr.success("Se guardaron los cambios");
                },
                error: function (data) {

                }
            });
        //console.log("url",url);
    }


    window.getModulos= function(){
        var id_usuario=$("#usuarios").val();
        //console.log("id_usuarios",id_usuario);
        $.ajax({
                type: 'POST',
                url: `${$path}Permisos/getModulos`,
                data: {
                    "id_usuario": id_usuario,
                },
                success:  function (data) {
                    checkModulos(data.data);
                    //checkModulosC(data.data);
                    checkURl(data.data);
                    /* data.data.forEach(element => {
                        
                    }); */
                    
                },
                error: function (data) {

                }
            });
    }

    window.checkModulos=function(data){
        cleanModulos();
        $("[data-grupo='grupo']").each(function() {
            var grupo=$(this).data("nombre");
            if(data.length>0){
                //console.log("Data grupo no vacia");
                data.forEach(element => {
                    //console.log("modulo "+element.modulo+ " grupo "+ grupo+ ", cheked-> "+`C_${grupo}`);
                    //element.modulo==grupo?$(this).css("background-color", "#D4AFFF"):'';
                    //element.modulo==grupo?$(`#CH_${grupo}`).prop('checked', true):'';
                    //element.modulo==grupo?$(this).css("font-style", "italic"):'';
                    element.modulo==grupo?$(this).css({"font-style":"italic","font-weight": "bold"}):'';
                    element.modulo==grupo? $(`[data-CH='CH_${grupo}']`).prop('checked', true):'';
                });
            }else{
                //$(this).css("background-color", "white");
                //$(this).css("font-style", "normal");
                $(this).css({"font-style":"normal","font-weight": "unset"});
                $(`[data-CH='${grupo}']`).prop('checked', false);
                //$(`#CH_${grupo}`).prop('checked', false);
            }
            
        });
    }

    window.checkURl=function(data){
        cleanUrl();
        $("[data-modulo='modulo']").each(function() {
            var url=$(this).data('nombre');
            if(data.length>0){
                //console.log("Data url no vacia");
                data.forEach(element => {
                    //console.log("modulo "+element.url+ " url "+ url);
                    //element.url==url?$(this).css("background-color", "#D4AFFF"):'';
                    //element.url==url?$(this).css("font-style", "italic"):'';//
                    element.url==url?$(this).css({"font-style":"italic","font-weight": "bold"}):'';
                    element.url==url? $(`[data-CH='${url}']`).prop('checked', true):'';
                    //element.url==url? $(`#CH_${url}`).prop('checked', true):'';
                });
            }else{
                //console.log("modulo "+element.url+ " url "+ grupo);
                //$(this).css("background-color", "white");
                $(this).css({"font-style":"normal","font-weight": "unset"});
                $(`[data-CH='${url}']`).prop('checked', false);
                //$(`#CH_${url}`).prop('checked', false);
            }
            
        });
    }

    window.OpenModal = function() {
        $('#modal_tipos').modal('show');
        let copyP=document.getElementById('usuarios').selectedOptions[0].text;
        $('#modalLabel').html('');
        $('#modalLabel').html('Copiar permisos del usuario: '+copyP);
        $('#puestos_c').val('');
        $('#usuarios_c').val('');
        //console.log("usuario",copyP);  
    }


    window.SendCopy=function(){
        console.log("copy");
        let usrprincipal=$("#usuarios").val();
        let usrtoCopy=$("#usuarios_c").val();
        if(usrtoCopy==''){
            return toastr.error("Seleccione un usuario");
        }
        if(usrprincipal==usrtoCopy){
            return toastr.error("No se puede seleccionar el mismo usario");
        }

        $.ajax({
                type: 'POST',
                url: `${$path}Permisos/CopyPermisos`,
                data: {
                    "id_usuario": usrprincipal,
                    "id_usuario_copia":usrtoCopy
                },
                success:  function (data) {
                    $('#modal_tipos').modal('hide');
                    toastr.success("Se guardaron los cambios");
                },
                error: function (data) {

                }
            });
    }

    //console.log('puestos',_puestos);
});
</script>