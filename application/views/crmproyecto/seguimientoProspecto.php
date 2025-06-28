<?
	//$this->load->view('headers/header');
	$this->load->view('headers/headerReportes');
	
    $this->load->model('crmproyecto_model');
	function estado($estado){
		if($estado=="DIMENSION"){$estado="SUSPECTO";}
		if($estado=="REGISTRADO"){$estado="CONTACTADO";}
		return $estado;
	}
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <style type="text/css">
  .tableP100{width: 100%; height: 300px; overflow: scroll;}
  .tableP100 thead {color: white; background-color: #361866 }
  .tableP100 >thead >tr>th {border: solid black;width: 300px}
 .tableP100 >tbody >tr>td {border: solid black 1px; margin:5em; ;width: 300px}
 .divContTabla{/*height: 400px; width: 100%;overflow: scroll;*/}
 #Mitabla{
 	font-size: 10px;
 }
 .wrap{
	width: 100%;
	display: flex;
  color: white;
  background-color: #363636;
  justify-content: space-between;

}
.wrap a,button{color:white;}
.wrap button{border: none;padding: 3px;background-color: #363636;}
.wrap a:hover:hover{background-color: #0984cc}
.wrap button:hover{background-color: #0984cc}
ul.tabs{
	width: 100%;
	background: #363636;
	list-style: none;
	display: flex;
}
ul.tabs li{	width: 20%;}
ul.tabs li a,button{
	color: #fff;
	text-decoration: none;
	font-size: 11px;
	text-align: center;
	display: block;
	padding: 7px 0px;
}
.active{background: #0984CC;}
ul.tabs li a:hover{background: #0984CC;}
ul.tabs li>form> button:hover{background: #0984CC;}
ul.tabs li a .tab-text{margin-left: 0px;}

#modalGrafico{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;  
}


</style>



<? $totalResultados = count($ListaClientes);?>

<div class="wrap">
        
                <!--div id="div_persona"><a href="#"  onclick="abrir_pestania_persona()">Prospectos Persona</a></div>                
                <div id="div_lead"><a href="<?php echo base_url()?>crmproyecto/prospectos_leads">Prospectos Leads</a></div-->                
                 <div id="div_agentes">
                   
                   <?php
                    if(in_array($this->tank_auth->get_usermail(), $accountsWithPermission)){ ?>
                        <a href="<?php echo base_url()?>crmproyecto/manageFirstProspectiveAgent">Prospectos Agentes</a>
                   <?php } ?>
                    
                </div>
               <div id="li_exportar"><form id="ExportaClientes" method="GET" action="<?=base_url()?>crmproyecto/ExportaClientes"><button>Exporta Clientes</button></form></div>
                <div id="div_guiaTel">    <button  data-toggle="collapse" href="#guion_tel" role="button" aria-expanded="false" aria-controls="guion_tef">Guión telefónico</button></div>                
                <div id="div_persona"><button  onclick="abrir()">Muestra Calendario</button></div> 

                <div id="div_grafico"><button  onclick="abrirGraficoProspeccion(
                '<?php echo $this->tank_auth->get_usermail();?>',
                '<?php echo $casado?>',
                '<?php echo $casado_hijos?>',
                '<?php echo $divorciado?>',
                '<?php echo $divorciado_hijos?>',
                '<?php echo $soltero?>',
                '<?php echo $soltero_hijos?>',
                '<?php echo $unionlibre?>',
                '<?php echo $unionlibre_hijos?>',
                '<?php echo $viudo?>',
                '<?php echo $viudo_hijos?>',
                '<?php echo $MENOSDE18?>',
                '<?php echo $DE19A35?>',
                '<?php echo $DE36A50?>',
                '<?php echo $DE51A65?>',
                '<?php echo $amadecasa?>',
                '<?php echo $ejecutivo?>',
                '<?php echo $empleado?>',
                '<?php echo $empresario?>',
                '<?php echo $gerente?>',
                '<?php echo $negociopropio?>',
                '<?php echo $profesionistaindependiente?>',
                '<?php echo $retirado?>',
                '<?php echo $otrospempleos?>',
                '<?php echo $estudiante?>',
                '<?php echo $AMIGODEESCUELA?>',
                '<?php echo $VECINOS?>',
                '<?php echo $AMIGODEFAMILIA?>',
                '<?php echo $CONOCIDOPASATIEMPOS?>',
                '<?php echo $FAMPROPIAOCONYUGUE?>',
                '<?php echo $CONOCIDOGRUPOSOCIAL?>',
                '<?php echo $CONOCIDOACTIVICOMUNIDAD?>',
                '<?php echo $CONOCIDOANTIGUOEMPLEO?>',
                '<?php echo $PERSONASHACENEGOCIO?>',
                '<?php echo $CENTRODEINFLUENCIA?>',
                '<?php echo $HABILIDADEXCELENTE?>',
                '<?php echo $HABILIDADBUENA?>',
                '<?php echo $HABILIDADREGULAR?>',
                '<?php echo $MENOSDE25000?>',
                '<?php echo $DE25000A60000?>',
                '<?php echo $DE6000A100000?>',
                '<?php echo $MASDE100000?>',
                '<?php echo $FACILMENTE?>',
                '<?php echo $NOMUYDIFICIL?>',
                '<?php echo $CONDIFICULTAD?>',
                '<?php echo $bant_auth1?>',
                '<?php echo $bant_auth2?>',
                '<?php echo $bant_auth3?>',
                '<?php echo $bant_need1?>',
                '<?php echo $bant_need2?>',
                '<?php echo $bant_need3?>',
                '<?php echo $bant_timing_inmediato?>',
                '<?php echo $bant_timing_sin_urgencia?>',
                '<?php echo $bant_timing_largo_plazo?>'
                )"  data-toggle="modal" data-target="#modalGrafico">Grafico Estadistico de Perfilamiento</button></div> 

                <!--div><a href="<?php echo base_url()?>crmproyecto/notificacion">Notificacion</a></div-->

        
</div>




<!--div class="wrap">
        <ul class="tabs">
                <li id="li_persona"><a href="#"  onclick="abrir_pestania_persona()"><span class="tab-text"><i class="fa fa-arrow"></i>Prospectos Persona</span></a></li>
                
                <li id="li_lead"><a href="<?php echo base_url()?>crmproyecto/prospectos_leads"><span class="tab-text"><i class="fa fa-arrow"></i>Prospectos Leads</span></a></li>
                
                 <li id="li_agentes">
                
                   <?php
                    if(in_array($this->tank_auth->get_usermail(), $accountsWithPermission)){ ?>
                        <a href="<?php echo base_url()?>crmproyecto/manageFirstProspectiveAgent"><span class="tab-text"><i class="fa fa-arrow"></i>Prospectos Agentes</span></a>
                   <?php } ?>
                
                </li>
               <li id="li_exportar"><a href="#li_exportar"><form id="ExportaClientes" method="GET" action="<?=base_url()?>crmproyecto/ExportaClientes"><span class="tab-text"><i class="fa fa-arrow"></i>Exporta Clientes</span></a></form>
</span></li>
                
        </ul>
</div-->


<div id="persona"><?php include('prospectos_persona.php');?></div>
<script type="text/javascript">
  function enviarExportarSP(){}
</script>














