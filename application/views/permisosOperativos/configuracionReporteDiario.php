<section class="container-fluid breadcrumb-formularios">
	<div class="row">
        <div class="col-md-12">
            <h3 class="title-section-module">Reportes Diarios a Correo - Configuración</h3>
        </div>
    </div>
    <hr/>
</section>
<div class="col-md-12" style="text-align: left;">
	<div class="alert alert-info">
		<i class="fa fa-info-circle"></i>&nbsp; Los correos que seleccione recibirán el reporte un diario de <strong>Lunes a Viernes</strong>
	</div>
</div>
<div class="col-md-12">
    <div class="panel panel-default segment-sms" style="margin: 0px;">
      	<div class="panel-body">
      		<div class="col-md-12" style="margin-bottom: 5px;">
				<input type="hidden" value="<?php echo base_url()?>" id="base">
				<div class="col-md-5 width-ajust">
					<label class="textLabel">Reporte:</label>
					<select class="form-control" id="reporte" onchange="getTableReportEmail(this.value)">
						<?= imprimirReportes($reportes); ?>
					</select>
				</div>
				<div class="col-md-5 width-ajust">
					<label class="textLabel">Filtrar correos de empleados:</label>
					<select class="form-control" id="emailFilter" onchange="emailFilter(this.value)">
						<?= printArea($empleados); ?>
					</select>
				</div>
			</div>
			<div class="col-md-12 column-flex-bottom" style="margin-bottom: 5px;">
				<div class="col-md-9 width-ajust">
					<label class="textLabel">Empleados:</label>
					<select class="form-control" id="correo">
						<?= imprimirCorreos($empleados); ?>
					</select>
				</div>
				<div class="col-md-2 width-ajust">
					<button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
						<i class="fa fa-plus"></i> Agregar Correo
					</button>
				</div>
			</div>
			<!-- Lista-->
			<div class="col-md-12">
				<hr style="border-top: 1px solid #e3e3e3;margin: 5px;">
				<div id="divLista">
					<?php $this->load->view('permisosOperativos/listaReporteDiario');?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function addItem() { //Modificado [Suemy][2024-03-21]
		var correo=document.getElementById('correo').value;
		var reporte=document.getElementById('reporte').value;
		console.log(correo, reporte);
		if(reporte != 0){
			var base=document.getElementById('base').value;
			ajax=objetoAjax();
			divLista=document.getElementById('divLista');
			var URL=base+"fastFile/saveReporteDiario?correo="+correo+"&reporte="+reporte;
			ajax.open("GET", URL);
			ajax.onreadystatechange=function() {
				//console.log(ajax);
			if (ajax.readyState==4) {
				//divLista.innerHTML = ajax.responseText
				getTableReportEmail(reporte);
			  }
			}
			ajax.send(null)

		}
		if(reporte==0){
			swal("Validación","Debe seleccionar un tipo de reporte",'warning');
		}
	}

	function delItem(id,reporte){ //Modificado [Suemy][2024-03-21]
			var base=document.getElementById('base').value;
			ajax=objetoAjax();
			divLista=document.getElementById('divLista')
			var URL=base+"fastFile/delItemReporteDiario?id="+id+"&reporte="+reporte;
			ajax.open("GET", URL);
			ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				//divLista.innerHTML = ajax.responseText
				getTableReportEmail(reporte);
			  }
			}
			ajax.send(null)
	}

	function getTableReportEmail(type) { //Creado [Suemy][2024-03-21]
		if (type != 0) {
			$.ajax({
        	    type: "GET",
        	    url: `<?=base_url()?>permisosOperativos/getSearchReportEmail`,
        	    data: {
        	    	tp: type
        	    },
        	    success: (data) => {
        	        const res = JSON.parse(data);
        	        console.log(res);
        	        let r = res['result'];
        	        let t = res['report'];
        	        var trtd = ``;
        	        if (r != 0) {
        	        	for (const a in r) {
        	        		trtd += `
        	        			<tr>
        	        				<td style="text-align: left">${r[a].correo}</td>
        	        				<td style="text-align: center">
        	        					<a class="btn-delItem" onclick="delItem(${r[a].id},${r[a].tipo})"><i class="fa fa-times-circle"></i></a>
        	        				</td>
        	        			</tr>
        	        		`;
        	        	}
        	        }
        	        else {
        	            trtd = `<tr><td colspan="2"><center><strong>Sin resultados</strong><center></td></tr>`;
        	        }
        	        $('#titleTableDailyReport').html(`<b>Reporte:</b> ${t['titulo']} ${t['informacion']}`);
        	        $('#bodyTableReportEmail').html(trtd);
        	    },
        	    error: (error) => {
        	        console.log(error);
        	        $('#bodyTableReportEmail').html(`<tr><td colspan="2"><center><strong>Sin resultados</strong><center></td></tr>`);
        	    }
        	})
		}
	}

	function emailFilter(value) { //Creado [Suemy][2024-03-21]
		let group = $('#correo optgroup');
		var type = "";
		//console.log(group);
		if (value != "todos") {
			if (value == "1") {
				console.log("Value: " + value + ", Tipo: " + typeof(value) + ", Filtro: Coordinador");
				type = "coord";
			}
			else if (value == "2") {
				console.log("Value: " + value + ", Tipo: " + typeof(value) + ", Filtro: Coordinador Comercial");
				type = "coordcom";
			}
			else {
				console.log("Value: " + value + ", Tipo: " + typeof(value) + ", Filtro: Área");
				type = "filter";
			}
			showEmailByType(value,group,type);
			$('#correo option[value="0"]').prop('selected',true);
		}
		else {
			$('#correo optgroup option').css('display','');
			$(group).css('display','');
		}
	}

	function showEmailByType(value,data,type) { //Creado [Suemy][2024-03-21]
		//console.log($(data).parent());		
		for (let i=0;i<data.length;i++) {
			let option = data[i].children;
			var active = 0;
			//console.log(data[i].children);
			for (let j=0;j<option.length;j++) {
				if (value == option[j].dataset[type]) {
					$(option[j]).css('display','');
					active++;
				}
				else {
					$(option[j]).css('display','none');
				}				
			}
			if (active > 0) {
				$(data[i]).css('display','');
			}
			else {
				$(data[i]).css('display','none');
			}
		}
	}

	<?

		function imprimirCorreos($data) { //Creado [Suemy][2024-03-21]
			$option="<option value='0'>Seleccione un correo</option>";
			foreach ($data as $key1 => $value1) {
				//if ($value1['Name'] == "Operativo") { <-- Solo Para activar operativos
				    $option.='<optgroup data-filter="'.$value1['Name'].'" label="'.$value1['Name'].'">';
				    foreach ($value1['Data'] as $key => $value) {
				    	$comercial = "0";
				    	if ($value['email'] == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || $value['email'] == "COORDINADOR@CAPCAPITAL.COM.MX" || $value['email'] == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || $value['email'] == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM") { $comercial = "2"; }
				    	$nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
				    	$option.='<option value="'.$value['email'].'" data-id="'.$value['idPersona'].'" data-name="'.$nombres.'" data-type="permisosOperativos" data-filter="'.$value1['Name'].'" data-coord="'.$value['esCoordinador'].'" data-coordcom="'.$comercial.'">'.$nombres.' <label>     ('.$value['email'].')</label></option>';
				    }
				    $option.='</optgroup>';
				//}
			}
			return $option;
		}

		function imprimirReportes($data) { //Creado [Suemy][2024-03-21]
			$option = '<option value="0">Seleccione un tipo de Reporte...</option>';
			foreach ($data as $val) {
				$selected = "";
				if ($val->id == 1) { $selected = "selected"; }
				$option .= '<option value="'.$val->id.'" '.$selected.'>'.$val->titulo.' '.$val->informacion.'</option>';
			}
			return $option;
		}

        function printArea($data){ //Creado [Suemy][2024-03-21]
            $option = '<option value="todos">Todos</option><optgroup label="Coordinador"><option value="1">Coordinador</option><option value="2">Coordinador Comercial</option></option></optgroup><optgroup label="Areas">';
            //Con $empleados
            foreach ($data as $key1 => $value1) {
                $option.='<option value="'.$value1['Name'].'">'.$value1['Name'].'</option>';
            }
            //Con $puestos
            // foreach ($data as $key => $val) {
            //     $option.='<option value="'.$val['label'].'">'.$val['label'].'</option>';
            // }
            $option .= '</optgroup>';
            return $option;
        }
	?>
</script>
