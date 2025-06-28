<!-- <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>  -->
		<div class="row pull-right">
			<div class="col-sm-12 col-md-12">
<?     $canal=5; //le paso el valor de forma estatica para qeu entre en siniestros
	switch(5){  //le paso el valor de forma estatica para qeu entre en siniestros
		case 1: // Vendedor (Agente)
		break;
		
		case 2: // Supervisor (Coordinador)
		case 3: // Despacho (Sin Usar)
		case 4: // Gerente Canal (Gerente Nacho)
			

		
		case 5: // Siniestros (Alan)

			switch($canal){
				/*case 1:
				?>
				<button
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/agregar/prospecto"?>', '_parent')"
					title="Clic - Capturar Nuevo Prospecto"
                >
                	Nuevo Prospecto
				</button>
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/prospecto"?>', '_parent')"
					title="Clic - Lista Prospecto"
                >
					Lista Prospecto
				</button>
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/siniestro"?>', '_parent')"
					title="Clic - Lista Siniestros"
                >
					Lista Siniestros
				</button>
                <?
				break;
				
				case 2:
				?>
				<button
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/agregar/prospecto"?>', '_parent')"
					title="Clic - Capturar Nuevo Prospecto"
                >
                	Nuevo Prospecto
				</button>
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/prospecto"?>', '_parent')"
					title="Clic - Lista Prospecto"
                >
					Lista Prospecto
				</button>
                <?
				break;
				
				case 3:
				?>
				<button
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/agregar/prospecto"?>', '_parent')"
					title="Clic - Capturar Nuevo Prospecto"
                >
                	Nuevo Prospecto
				</button>
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/prospecto"?>', '_parent')"
					title="Clic - Lista Prospecto"
                >
					Lista Prospecto
				</button>
                <!--
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/agentes"?>', '_parent')"
					title="Clic - Lista Agentes"
                >
					Lista Agentes
				</button>
                -->
                <?
				break;
				
				case 4:
				?>
				<button
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/agregar/prospecto"?>', '_parent')"
					title="Clic - Capturar Nuevo Prospecto"
                >
                	Nuevo Prospecto
				</button>
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/prospecto"?>', '_parent')"
					title="Clic - Lista Prospecto"
                >
					Lista Prospecto
				</button>
                <!--
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/agentes"?>', '_parent')"
					title="Clic - Lista Agentes"
                >
					Lista Agentes
				</button>
                -->
                <?
				break; */
				
				case 5:
				?>
				  <!--<button
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/agregar/prospecto"?>', '_parent')"
					title="Clic - Capturar Nuevo Prospecto"
                >
                	Nuevo Prospecto
				</button>
               
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/prospecto"?>', '_parent')"
					title="Clic - Lista Prospecto"
                >
					Lista Prospecto
				</button>
                -->
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."siniestros/lista/siniestro"?>', '_parent')"
					title="Clic - Lista Siniestros"
                >
					Lista Siniestros
				</button>
                <?
				break;
			}
		break;
		
		/*case 9: // Master (Director)
		?>
				<button
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/agregar/prospecto"?>', '_parent')"
					title="Clic - Capturar Nuevo Prospecto"
                >
                	Nuevo Prospecto
				</button>
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/prospecto"?>', '_parent')"
					title="Clic - Lista Prospecto"
                >
					Lista Prospecto
				</button>
			<!--
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/agregar/seguimiento"?>', '_parent')"
					title="Clic - Capturar Nuevo Seguimiento"
                >
					Nuevo Seguimiento
				</button>
			-->
            <!--
				<button 
                	type="button" 
                    class="btn btn-primary btn-sm"
					onclick="window.open('<?=base_url()."crm/lista/seguimiento"?>', '_parent')"
					title="Clic - Lista Seguimiento"
                >
					Lista Seguimiento
				</button>
			-->
        <?
		break;*/
	}
?>
			</div>
		</div><!-- row -->