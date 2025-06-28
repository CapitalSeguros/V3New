<!-- Inicio Navegacion -->
<section class="container-fluid">
        <div class="row">
            <div class="col-sm-7 col-xs-7 col-md-6">
				<ol class="breadcrumb text-left">
				<?
                	//** Nivel 1 -->
					if($this->uri->segment(1)=="crm" && $this->uri->segment(2)==""){
						print('<li class="active"><b>CRM</b></li>');
					} else {
						print('<li><a href="<?=base_url()?>crm">CRM</a></li>');
					}

					//** Nivel 2 -->
					if($this->uri->segment(2)=="agregar"){
						$tipoUrl = $this->uri->segment(3);
						print('<li class="active"><b>Nuevo '.ucfirst($tipoUrl).'</b></li>');
					} else if($this->uri->segment(2)=="lista"){
						$tipoUrl = $this->uri->segment(3);
						print('<li class="active"><b>Lista '.ucfirst($tipoUrl).'</b></li>');
					} else if($this->uri->segment(2)=="editar"){
						$tipoUrl = $this->uri->segment(3);
						print('<li class="active"><b>Editar '.ucfirst($tipoUrl).'</b></li>');
					}
				?>
				</ol>
            </div>
            <div class="col-sm-5 col-xs-5 col-md-6">
            </div>
        </div>
		<hr /> 
</section>
<!-- Fin Navegacion -->