<?php
    $corte = 0;
    $columnas = 3;
    
    $moduloConfiguraciones = "";
    foreach($configModulos as $modulos){
        if($modulos['modulo'] == "tienda" && $modulos['subModulo'] == "surtirPedidos"){ 
            $moduloConfiguraciones.= TRUE;
        } else { 
            $moduloConfiguraciones.= FALSE;
        }
    }
?>
<?php 
    $this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
    $this->load->view('headers/menu');
?>
<!-- End navbar -->
<style>
    .submenu a:hover{
        background-color: #472380 !important;
        color: white;
    }
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Imagenes - Agregar imagenes</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li><a href="<?=base_url()."imagenesMkt"?>">Repositorio imagenes</a></li>
                <li><a href="<?=base_url()."imagenesMkt/imagenesModificar"?>">Repositorio imagenes - Modificar imagenes</a></li>
                <li class="active">Repositorio imagenes - Agregar imagenes</li>
            </ol>
        </div>
    </div>
    <hr /> 
<!-- Menu de Administracion Tienda -->
<?
    if($moduloConfiguraciones){
?>
    <header>
        <nav class="navbar navbar-expand-md navbar-default" style="z-index: 1 !important;">
            <div class="container-fluid menu-navbar">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarImagenes" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbarImagenes"  class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item dropdown" >
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px;">
                              <i class="fa fa-picture-o" aria-hidden="true"></i> Categorias <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu submenu">
                              <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/categoriasAgregar">- Agregar</a>
                              <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/categoriasModificar">- Modificar</a>                       
                            </div>
                         </li>
                         <li class="nav-item dropdown" >
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px;">
                              <i class="fa fa-picture-o" aria-hidden="true"></i> Áreas <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu submenu">
                              <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/areasAgregar">- Agregar</a>
                              <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/areasModificar">- Modificar</a>                     
                            </div>
                         </li>
                         <li class="nav-item dropdown" >
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px;">
                              <i class="fa fa-picture-o" aria-hidden="true"></i> Subcategoria <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu submenu">
                              <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/subcategoriasAgregar">- Agregar</a>
                              <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/subcategoriasModificar">- Modificar</a>                     
                            </div>
                         </li>
                          <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px;">
                              <i class="fa fa-picture-o" aria-hidden="true"></i> Imagenes <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu submenu">
                              <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/imagenesAgregar">- Agregar</a>
                              <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/imagenesModificar">- Modificar</a>  
                          </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

        <?
            }
        ?>
 </section>

 <section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <span style="font-size:22px; text-decoration:underline; font-weight:bold;">
                    Agregar imagenes
                </span>
                <br /><br />
            </div>
        </div>
        <hr />
        <form
            class="form-group" role="form"
            name="formAgregarImagen" id="formAgregarImagen"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>imagenesMkt/AgregarImagenes" 
        >
        <div class="row">
            <div class="col-sm-5 col-md-5">
                <label><b>Categoria:</b></label>
                <br />
                <select
                    class="form-control input-sm"
                    name="idCategoria" id="idCategoria"
                >
                    <?
                        //$this->capsysdre_tienda->EditarCategoriaTienda($EditarArticulosTienda[0]->idCategoria);
                        $sqlListaCategorias = "
                            Select * From 
                                `imagenesMkt_categorias`
                            Where
                                1
                                              ";
                        $query = $this->db->query($sqlListaCategorias);
                        foreach($query->result() as $categoria){
                    ?>
                    <option value="<?=$categoria->idCategoria?>"><?=urldecode($categoria->nombre)?></option>
                    <?
                        }
                    ?>
                </select>

                <label><b>Area:</b></label>
                <br />
                <select
                    class="form-control input-sm"
                    name="idArea" id="idArea"
                >
                <option value="0">Todas</option>
                    <?
                        //$this->capsysdre_tienda->EditarCategoriaTienda($EditarArticulosTienda[0]->idCategoria);
                        $sqlListaAreas = "
                            Select * From 
                                `imagenesMkt_area`
                            Where
                                1
                                              ";
                        $queryArea = $this->db->query($sqlListaAreas);
                        foreach($queryArea->result() as $area){
                    ?>
                    <option value="<?=$area->idArea?>"><?=urldecode($area->nombre)?></option>
                    <?
                        }
                    ?>
                </select>

                <label><b>Subcategoria:</b></label>
                <br />
                <select
                    class="form-control input-sm"
                    name="idSubcategoria" id="idSubcategoria"
                    onchange="habilitarRadio()"
                   >
                    <?
                        //$this->capsysdre_tienda->EditarCategoriaTienda($EditarArticulosTienda[0]->idCategoria);
                        $sqlListaSubcategorias = "
                            Select * From 
                                `imagenesMkt_subcategorias`
                            Where
                                1
                                              ";
                        $query = $this->db->query($sqlListaSubcategorias);
                        foreach($query->result() as $subcategoria){
                    ?>
                    <option value="<?=$subcategoria->idSubcategoria?>"><?=urldecode($subcategoria->nombre)?></option>
                    <?
                        }
                    ?>
                </select>
                
                <label><b>Nombre:</b></label>
                <br />
                <input 
                    type="text" class="form-control input-sm"
                    name="nombre" id="nombre" 
                    placeholder="Nombre" required="required"
                />

                <div id="radioLogo"></div>
                
            </div>
           
            <div class="col-sm-5 col-md-5">
                
                <input
                    type="file"
                    name="imagenMkt" id="imagenMkt"
                    class="form-control input-sm"
                />
            </div>
            <div class="col-sm-1 col-md-1">
                <input 
                    type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
                    onclick="document.formAgregarImagen.submit();"
                />
                <!--
                <input
                    type="submit" 
                    value="Enviar Documento" class="btn btn-primary btn-sm"
                    onclick="document.formEdicionCategoria.submit();"
                />
                -->
            </div>
        </div>
        </form>
    </div>            
</section>

<script>


    function habilitarRadio(){
        var select = document.getElementById('idSubcategoria');
        var selectedOption = select.options[select.selectedIndex];
        if(selectedOption.value==2||selectedOption.value==3){

        document.getElementById("radioLogo").innerHTML='<div class="col-md-6"><label><b>Logo:</b></label><br><input type="radio" name="logo" value=1> Color<br><input type="radio" name="logo" value=2> Blanco</div><div class="col-md-6"><label><b>Posici&oacute;n del logo:</b></label><br><input type="radio" name="logoside" value="izq">A la izquierda<br><input type="radio" name="logoside" value="der">A la derecha</div>';
    } else{
        document.getElementById("radioLogo").innerHTML='';
    }
    }
</script>