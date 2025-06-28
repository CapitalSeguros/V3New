<!-- TipoRamo -->
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
				<label class="labelResponsivo">Ramo:</label>
            </div>
			<div class="col-sm-4 col-md-4">
				<?
					print($SelectRamo);
				?>
            </div>

			<div class="col-sm-2 col-md-2" align="right">
            <?
				if($tipoRamo != ""){
					echo '<label class="labelResponsivo">SubRamo:</label>';
				}
			?>
            </div>
			<div class="col-sm-4 col-md-4">
            <?
				if($tipoRamo != ""){
					print($SelectSubRamo);
				}
			?>                
            </div>
        </div>
<!--* TipoRamo -->

<!-- TipoCliente -->
        <?
		if(
			$tipoActividad != ""
			&&
			$tipoRamo != ""
			&&
			$tipoSubRamo != ""
		){
		?>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Tipo Cliente:</label>
            </div>
			<div class="col-sm-10 col-md-10">
                <? print($SelectCliente); ?>
            </div>
        </div>
        <?
		}
		?>
<!--* TipoCliente -->

<!-- TipoCliente [Nuevo] -->
		<?
		if($tipoCliente == "Nuevo"){
		?>
		<form 
        	class="form-horizontal" role="form" 
            id="formActividadAgregar_clienteNuevo" name="formActividadAgregar_clienteNuevo"
			method="post" enctype="multipart/form-data"
            action="<?=base_url()?>actividades/agregarGuardar"
		>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        	<label class="labelResponsivo">	Tipo Entidad:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <? print($SelectEntidad); ?>
            </div>
        </div>       
        <?
		if($tipoEntidad == "Fisica"){
		?>
<!-- Fisica -->
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Sexo:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <select name="Sexo" id="Sexo">
                	<option value="0">Masculino</option>
                	<option value="1">Femenino</option>
                </select>
            </div>
        </div>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Fecha Nacimiento:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
            	<input 
                	type="text" name="fecha_nacimiento" id="fecha_nacimiento"
                    maxlength="10"
                    required="required"
                />
                <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>

                 <?  //ENLACE PROYECTO 100
                   if( $IDPcien > 0)
                   { 
                 ?>
                 <font color='red'>
                 Enlace Proyecto 100:
                 </font>
                 <input 
                    type="text" name="IDPcien" id="IDPcien"
                    maxlength="10" size="8"
                    readonly=""  value="<? echo $IDPcien  ?>" 
                />

                <?
                 }
                ?>

            </div>



    



        </div>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Apellido Paterno:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="ApellidoP" name="ApellidoP" 
                	type="text"
                    style="width:90%;"
                    required="required" value="<? echo $tipoAPATERNO  ?>" 
                />
      
            </div>
        </div>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Apellido Materno:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="ApellidoM" name="ApellidoM"
                	type="text"
                    style="width:90%;"
                    required="required"  value="<? echo $tipoAMATERNO  ?>"
                />
            </div>
        </div>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Nombre(s):</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="Nombre" name="Nombre"
                	type="text"
                    style="width:90%;"
                    required="required" value="<? echo $tipoNOMBRES  ?>" 
                />
            </div>
        </div>
                        <?php if(isset($estados)) {?>
        <div class="row">
                    <div class="col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                    Estados:
                </label>
            </div> 
             <div class="col-sm-9 col-md-9" align="left">
                <select name="claveEstado" id="claveEstado" required="required"><?php echo(imprimirEstados($estados)); ?></select>
            </div>
        </div>
        <?php } ?>
        <?php if(isset($giroCatalogo)) {?>
        <div class="row">
                    <div class="col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                    Giro:
                </label>
            </div> 
             <div class="col-sm-9 col-md-9" align="left">
                <select name="giroCliente" id="giroCliente" required="required"><?php echo(imprimirGiroCatalogo($giroCatalogo)); ?></select>
                <button onclick="abrirModal(event)">+</button>
            </div>
        </div>
        <div class="row">
                    <div class="col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                   Actividad:
                </label>
            </div> 
             <div class="col-sm-9 col-md-9" align="left">
                <input type="text" name="giroActividad" id="giroActividad" >
            </div>
        </div>
        <?php } ?>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Celular:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="Telefono1" name="Telefono1" 
                	type="tel"
                    style="width:90%;"
                    required="required" value="<? echo $tipoCEL  ?>" 
                />
            </div>
        </div>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Email:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="EMail1" name="EMail1"
                	type="email"
                    style="width:90%;"
                    value="<?  echo $tipoEMAIL;  ?>"
                />
            </div>
        </div>
                               <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Preferencia de comunicacion:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="preferenciaComunicacion" class="form-control input-sm"><option>SMS</option><option>Telefono</option><option>Correo</option><option>Whatsapp</option></select>
        </div>
        </div>

        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Preferencia de horario:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="horarioComunicacion" class="form-control input-sm"><option>Antes de la 9 am</option><option>De 9 a 11 am</option><option>De 12 a 3 pm</option><option>En las tardes 4 a 6 pm</option></select>
         </div>
        </div>


        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Dias de contacto:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="diaComunicacion" class="form-control input-sm"><option>Lunes</option><option>Martes</option><option>Miercoles</option><option>Jueves</option><option>Viernes</option></select>
        </div>
        </div>

        <?php if(isset($pagoFormas)){ ?>
             <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Forma de pago</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select id="pagoFormas" name="pagoFormas" class="form-control input-sm" required="required"><option value="">-- Seleccione --</option><?php 
              foreach($pagoFormas as $value){?>
                <option value="<?php echo($value->idPagoFormas); ?>"><?php echo($value->pagoFormas); ?></option>
              <?php
              }
            ?></select>
        </div>
        </div>
        <?php } ?>
                <?php if(isset($pagoConducto)){ ?>
             <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Conducto de Pago</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select id="pagoConducto" name="pagoConducto" onchange="cambiarConducto(this.value)" class="form-control input-sm" required="required"><option value="">-- Seleccione --</option><?php 
              foreach($pagoConducto as $value){?>
                <option value="<?php echo($value->idPagoConducto); ?>"><?php echo($value->pagoConducto); ?></option>
              <?php
              }
            ?></select>
        </div>
        </div>
        <?php } ?>
                <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <br />
                <label class="labelResponsivo">Datos Tarjeta de Crédito:</label>
            </div>
            <div class="col-sm-10 col-md-10">
            <br />
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        Número de tarjeta
                        <br />
                        <input type="text" id="numeroTarjeta" name="numeroTarjeta" class="form-control input-sm datosTarjeta" placeholder="Ingrese los 16 dígitos de la tarjeta"  />
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Vencimiento
                        <br />
                        <select id="mesTarjeta" name="mesTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="">Mes</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <br />
                        <select id="yearTarjeta" name="yearTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="">Año</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Código de Seguridad
                        <br />
                        <input type="text" id="ccv" name="ccv" class="form-control input-sm datosTarjeta" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-md-4 ">
                        Titular de la tarjeta
                        <br />
                        <input type="text" id="titularTarjeta" name="titularTarjeta" class="form-control input-sm datosTarjeta" placeholder="Como aparece en la tarjeta" />
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Tipo tarjeta
                        <br />
                        <select id="tipoTarjeta" name="tipoTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="Visa">Visa</option>
                            <option value="Master Card">Master Card</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Banco
                        <br />
                        <input type="text" id="bancoTarjeta" name="bancoTarjeta" class="form-control input-sm datosTarjeta" placeholder="Banco emisor" />
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Tipo de pago aplicación
                        <br />
                        <select id="tipoPagoTarjeta" name="tipoPagoTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="Un solo cargo">Un solo cargo</option>
                            <option value="Domiciliada">Domiciliada</option>
                            <option value="Meses sin intereses">Meses sin intereses</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

  <?php if(isset($permisos['polizaVerde'])){ ?>      
        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Poliza verde:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="tarjetaVerde" class="form-control input-sm"><option value="0">No</option><option value="1">Si</option></select>
        </div>
        </div>
  <?php  } ?> 


        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
             <label class="labelResponsivo">Seleccionar companias:</label>
            </div>
            <div class="col-sm-10 col-md-10   " >
            <?php   if(isset($companias)){$opciones='<select name="selectCompania" required="required" class="form-control input-sm">';
                 $opciones=$opciones.'<option value="">-- Seleccione --</option>';
                foreach ($companias as $value) {
                    $opciones=$opciones.'<option class="labelResponsivo" value="'.$value->idPromotoria.'">'.$value->Promotoria.'</option>';
                }
                $opciones=$opciones.'</select>';
                echo($opciones);
            } ?>
        </div>
        </div>
<!--* Fisica -->
        <?
		}
		?>
        
        <?
		if($tipoEntidad == "Moral"){
		?>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		Fecha Constituci&oacute;n:
            </div>
			<div class="col-sm-9 col-md-9" align="left">
            	<input 
                	type="text" name="fecha_constitucion" id="fecha_constitucion"
                    maxlength="10"
                    required="required"
                />
                <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>

                 <?  //enlace proyecto100
                 if( $IDPcien > 0)
                 { 
                 ?>
                 <font color='red'>
                 Enlace Proyecto 100:
                 </font>
                 <input 
                    type="text" name="IDPcien" id="IDPcien"
                    maxlength="10" size="8"
                    readonly=""  value="<? echo $IDPcien  ?>" 
                />

                 <?
                 }
                ?>


            </div>

        </div>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
            	Raz&oacute;n Social
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input 
                	type="text"
                    style="width:90%;"
                    name="Nombre" id="Nombre"
                    required="required" value="<?  echo $Razon;  ?>"
                />
            </div>
        </div>
                        <?php if(isset($estados)) {?>
        <div class="row">
                    <div class="col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                    Estados:
                </label>
            </div> 
             <div class="col-sm-9 col-md-9" align="left">
                <select name="claveEstado" id="claveEstado" required="required"><?php echo(imprimirEstados($estados)); ?></select>
            </div>
        </div>
        <?php } ?>
        <?php if(isset($giroCatalogo)) {?>
        <div class="row">
                    <div class="col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                    Giro:
                </label>
            </div> 
             <div class="col-sm-9 col-md-9" align="left">
                <select name="giroCliente" id="giroCliente" required="required"><?php echo(imprimirGiroCatalogo($giroCatalogo)); ?></select>
                <button onclick="agregarNuevoGiro()">+</button>
            </div>
        </div>
                <div class="row">
                    <div class="col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                   Actividad:
                </label>
            </div> 
             <div class="col-sm-9 col-md-9" align="left">
                <input type="text" name="giroActividad" id="giroActividad" >
            </div>
        </div>
        <?php } ?>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		Celular:
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input 
                	type="text"
                    style="width:90%;"
                    name="Telefono1" id="Telefono1"
                    required="required" value="<? echo $tipoCEL  ?>" 
                />
            </div>
        </div>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		Email:
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input 
                	type="text"
                    style="width:90%;"
                    name="Email1" id="Email1"
                    value="<?  echo $tipoEMAIL;  ?>"
                />
            </div>
        </div>
                         <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Preferencia de comunicacion:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="preferenciaComunicacion" class="form-control input-sm"><option>SMS</option><option>Telefono</option><option>Correo</option><option>Whatsapp</option></select>
        </div>
        </div>

        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Preferencia de horario:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="horarioComunicacion" class="form-control input-sm"><option>Antes de la 9 am</option><option>De 9 a 11 am</option><option>De 12 a 3 pm</option><option>En las tardes 4 a 6 pm</option></select>
         </div>
        </div>


        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Dias de contacto:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="diaComunicacion" class="form-control input-sm"><option>Lunes</option><option>Martes</option><option>Miercoles</option><option>Jueves</option><option>Viernes</option></select>
        </div>
        </div>  
<?php if(isset($pagoFormas)){ ?>
             <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Forma de pago</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select id="pagoFormas" name="pagoFormas" class="form-control input-sm" required="required"><option value="">-- Seleccione --</option><?php 
              foreach($pagoFormas as $value){?>
                <option value="<?php echo($value->idPagoFormas); ?>"><?php echo($value->pagoFormas); ?></option>
              <?php
              }
            ?></select>
        </div>
        </div>
        <?php } ?>
                <?php if(isset($pagoConducto)){ ?>
             <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Conducto de Pago</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select id="pagoConducto" name="pagoConducto" onchange="cambiarConducto(this.value)" class="form-control input-sm" required="required"><option value="">-- Seleccione --</option><?php 
              foreach($pagoConducto as $value){?>
                <option value="<?php echo($value->idPagoConducto); ?>"><?php echo($value->pagoConducto); ?></option>
              <?php
              }
            ?></select>
        </div>
        </div>
        <?php } ?>
                <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <br />
                <label class="labelResponsivo">Datos Tarjeta de Crédito:</label>
            </div>
            <div class="col-sm-10 col-md-10">
            <br />
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        Número de tarjeta
                        <br />
                        <input type="text" id="numeroTarjeta" name="numeroTarjeta" class="form-control input-sm datosTarjeta" placeholder="Ingrese los 16 dígitos de la tarjeta"  />
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Vencimiento
                        <br />
                        <select id="mesTarjeta" name="mesTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="">Mes</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <br />
                        <select id="yearTarjeta" name="yearTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="">Año</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Código de Seguridad
                        <br />
                        <input type="text" id="ccv" name="ccv" class="form-control input-sm datosTarjeta" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        Titular de la tarjeta
                        <br />
                        <input type="text" id="titularTarjeta" name="titularTarjeta" class="form-control input-sm datosTarjeta" placeholder="Como aparece en la tarjeta" />
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Tipo tarjeta
                        <br />
                        <select id="tipoTarjeta" name="tipoTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="Visa">Visa</option>
                            <option value="Master Card">Master Card</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Banco
                        <br />
                        <input type="text" id="bancoTarjeta" name="bancoTarjeta" class="form-control input-sm datosTarjeta" placeholder="Banco emisor" />
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Tipo de pago aplicación
                        <br />
                        <select id="tipoPagoTarjeta" name="tipoPagoTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="Un solo cargo">Un solo cargo</option>
                            <option value="Domiciliada">Domiciliada</option>
                            <option value="Meses sin intereses">Meses sin intereses</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($permisos['polizaVerde'])){ ?>
        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Poliza verde:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="tarjetaVerde" class="form-control input-sm"><option value="0">No</option><option value="1">Si</option></select>
        </div>
        </div>
  <?php  } ?>
 


        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
             <label class="labelResponsivo">Seleccionar companias:</label>
            </div>
            <div class="col-sm-10 col-md-10   " >
            <?php   if(isset($companias)){$opciones='<select name="selectCompania" class="form-control input-sm" required="required">';
                 $opciones=$opciones.'<option value="">-- Seleccione --</option>';
                foreach ($companias as $value) {
                    $opciones=$opciones.'<option class="labelResponsivo" value="'.$value->idPromotoria.'">'.$value->Promotoria.'</option>';
                }
                $opciones=$opciones.'</select>';
                echo($opciones);
            } ?>
        </div>
        </div>    
        <?
		}
		?>
        
        <?
		if($tipoEntidad != ""){
		?>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
            	<label class="labelResponsivo">Vendedor:</label>
            </div>
			<div class="col-sm-9 col-md-9">
            	<? print($SelectVendedor); ?>
            </div>
		</div>

		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            	<label class="labelResponsivo">Datos <?=$tipoActividad?> Expr&eacute;s:</label>
            </div>
        	<div class="col-sm-10 col-md-10">
					<textarea name="datosExpres" id="datosExpres" style="width:100%;">
            		<?=($TextoExpresFormulario != false)?$TextoExpresFormulario->row()->textoExpres_formulario:''?>
                    <?=($idPoliza != "" && isset($idPoliza))?'EMISION DE LA POLIZA: '.$idPoliza:''?>
                    </textarea>
					<?php echo display_ckeditor($ckeditor); ?>
            </div>
        </div>
		<div class="row" style="padding-bottom:-60px;">
        	<div class="col-sm-2 col-md-2" align="right">
            	&nbsp;
            </div>
        	<div class="col-sm-10 col-md-10"> 
				<?=($TextoExpresAsteriscos != false)?$TextoExpresAsteriscos->row()->textoExpres_asteriscos:''?>
            </div>
		</div>
        <div class="row">
            <? $rfcCliente='';
                    if(isset($informacionCliente[0]->RFC)){$rfcCliente=(string)$informacionCliente[0]->RFC;}
                    ?>
			<div class="col-sm-12 col-md-12">
                                  <input type="hidden" name="TipoEnt" id="TipoEnt" value="<?=$informacionCliente->TipoEnt?>" />  
                      <input type="hidden" name="oldValueRFC" value="<?=$rfcCliente?>"  id="oldValueRFC"/>
				<input type="hidden" name="tipoActividad" id="tipoActividad" value="<?=$tipoActividad?>" />
            	<input type="hidden" name="tipoRamo" id="tipoRamo" value="<?=$tipoRamo?>" />
            	<input type="hidden" name="tipoSubRamo" id="tipoSubRamo" value="<?=$this->capsysdre_actividades->SubRamoActivicad($tipoSubRamo)?>" />
            	<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?=$tipoCliente?>" />
            	<input type="hidden" name="TipoEnt" id="TipoEnt" value="<?=$TipoEnt?>" />        
				<input type="hidden" name="IDDir" id="IDDir" value="-1" />
            	<input type="hidden" name="IDAgente" id="IDAgente" value="63" />                                
            	<input type="hidden" name="IDGrupo" id="IDGrupo" value="1" />
                <input type="hidden" name="tipoActividadSicas" id="tipoActividadSicas" value="<?=$tipoActividadSicas?>" />
            	<input type="hidden" name="TipoDocto" id="TipoDocto" value="<?=$TipoDocto?>" /><!-- -->
            	<input type="hidden" name="IDEjecut" id="IDEjecut" value="<?=$IDEjecut?>" /><!-- -->
            	<input type="hidden" name="IDSRamo" id="IDSRamo" value="<?=$tipoSubRamo?>" />
            	<input type="hidden" name="poliza" id="poliza" value="<?=$idPoliza?>" />
                
                <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>" />
                <input type="hidden" name="usuarioResponsable" id="usuarioResponsable" value="<?=$usuarioResponsable?>" />
                <input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<?=$usuarioResponsable?>" />
            </div>
        </div>
              <div class="row" align="right">
                        <center>
                    <label class="labelResponsivo">
                        Emisi&oacute;n Urgente !!!
                    </label>
                    <input 
                        name="actividadUrgente" id="actividadUrgente" 
                        type="checkbox" title="Clic Para Seleccionar" 
                        value="1" class="form-control" 
                    />
                </center>

              <center>
                    <label class="labelResponsivo label label-warning">
                       SE REQUIERE RFC PARA FACTURA
                    </label>
                    <input 
                        name="actividadRequiereFactura" id="actividadRequiereFactura" 
                        type="checkbox"    style="height: 30px; font-size: 12px; width: 20px;"
                     onclick="activaRFCNecesario()"  />
                </center>

            <div class="col-sm-12 col-md-12">                   
                <input type="button" value="Cancelar" onclick="window.open('<?=$urlCancelar?>','_self');" id="cancelarActividad"  />
                <input type="submit" value="<? echo "Guardar ".$this->uri->segment(3); ?>" id="guardarActividad"/>
            </div>
        </div>
  
</form>
        <?
		}
		?>
<!--* TipoCliente [Nuevo] -->

<!-- TipoCliente [Existente] -->
        <?
		} else if($tipoCliente == "Existente") {
		?>
		<?
if(!$busquedaClienteProspecto && !$idCliente){
		?>
		<form
			class="form-horizontal" role="form" 
		    id="formActividadAgregar_BuscarClienteProspecto" name="formActividadAgregar_BuscarClienteProspecto" 
		    action="<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>"
		>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
            	Buscar Cliente:
            </div>
			<div class="col-sm-10 col-md-10">
            	<input 
                	type="text"
                    name="busquedaClienteProspecto" id="busquedaClienteProspecto"
                    style="width:100%;"
                />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12" align="right">
                <input 
                	type="submit" name="buttonBuscar" id="btnBuscaClient"  value="Buscar"
                />
            </div>
		</div>
        

		</form>
<?
		} else if(isset($busquedaClienteProspecto) && $busquedaClienteProspecto != ""){
?>

        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
            	Clientes:
            </div>
			<div class="col-sm-10 col-md-10">
            <select
            	name="IDCli" id="IDCli" 
                onDblClick="SeleccionIdCliente(this.value, '<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>')" 
                size="20" style="width:100%;"
            >
            	<?
				if(!empty($ListaClienteProspecto) && count($ListaClienteProspecto) > 0){
					foreach ($ListaClienteProspecto as $Registro){
				?>
					<option value="<?=$Registro->IDCli."-".$Registro->IDCont?>"  title="<?=$this->capsysdre->NombreVendedor($Registro->FieldInt1)?>">
						<?=$Registro->NombreCompleto?>
					</option>
				<?
					}
				} else {
				?>
					<option value="false">
						Cliente No Encontrado !!!
					</option>
                <?
				}
				?>          
            </select>
            </div>
		</div>
        <div class="row">
        	<div class="col-sm-12 col-md-12" align="right">
            <input 
            	type="button"
                onclick="window.open('<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>','_self');"
                value="Buscar Otro" id="buscarOtroClient"
                class="btn btn-primary btn-sm"
            />


            <input 
                type="button"
                onclick="SeleccionIdCliente(document.getElementById('IDCli').value, '<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>')" 
                value="Escoger" id="escogerClient"
                class="btn btn-primary btn-sm"
            />


            </div>
        </div>
<?
		}/*! If-busquedaClientePropecto-idCliente */
?>

<?
		if(isset($idCliente) && $idCliente != ""){
?>
		<form 
        	class="form-horizontal" role="form"
            id="formActividadAgregar_clienteExistente" name="formActividadAgregar_clienteExistente"
            method="post" enctype="multipart/form-data"
            action="<?=base_url()?>actividades/agregarGuardar"
		>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            <label class="labelResponsivo">	Nombre Cliente: </label>
            </div>
        	<div class="col-sm-10 col-md-10">
				<input type="text" value="<?=$informacionCliente[0]->NombreCompleto?>" style="width:100%;"  id="clienteEscogido"  name="nombreCliente"/>       
			</div>
		</div>
                       <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Preferencia de comunicacion:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="preferenciaComunicacion" class="form-control input-sm"><option>SMS</option><option>Telefono</option><option>Correo</option><option>Whatsapp</option></select>
        </div>
        </div>

        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Preferencia de horario:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="horarioComunicacion" class="form-control input-sm"><option>Antes de la 9 am</option><option>De 9 a 11 am</option><option>De 12 a 3 pm</option><option>En las tardes 4 a 6 pm</option></select>
         </div>
        </div>


        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Dias de contacto:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="diaComunicacion" class="form-control input-sm"><option>Lunes</option><option>Martes</option><option>Miercoles</option><option>Jueves</option><option>Viernes</option></select>
        </div>
        </div>
        <?php if(isset($pagoFormas)){ ?>
             <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Forma de pago</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select id="pagoFormas" name="pagoFormas" class="form-control input-sm" required="required"><option value="">-- Seleccione --</option><?php 
              foreach($pagoFormas as $value){?>
                <option value="<?php echo($value->idPagoFormas); ?>"><?php echo($value->pagoFormas); ?></option>
              <?php
              }
            ?></select>
        </div>
        </div>
        <?php } ?>
                <?php if(isset($pagoConducto)){ ?>
             <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Conducto de Pago</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select id="pagoConducto" name="pagoConducto" onchange="cambiarConducto(this.value)" class="form-control input-sm" required="required"><option value="">-- Seleccione --</option><?php 
              foreach($pagoConducto as $value){?>
                <option value="<?php echo($value->idPagoConducto); ?>"><?php echo($value->pagoConducto); ?></option>
              <?php
              }
            ?></select>
        </div>
        </div>
        <?php } ?>

                <div class="row ocultarObjeto" id="divPagoTarjeta">
            <div class="col-sm-2 col-md-2" align="right">
            <br />
                <label class="labelResponsivo">Datos Tarjeta de Crédito:</label>
            </div>
            <div class="col-sm-10 col-md-10">
            <br />
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        Número de tarjeta
                        <br />
                        <input type="text" id="numeroTarjeta" name="numeroTarjeta" class="form-control input-sm datosTarjeta" placeholder="Ingrese los 16 dígitos de la tarjeta"  />
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Vencimiento
                        <br />
                        <select id="mesTarjeta" name="mesTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="">Mes</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <br />
                        <select id="yearTarjeta" name="yearTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="">Año</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Código de Seguridad
                        <br />
                        <input type="text" id="ccv" name="ccv" class="form-control input-sm datosTarjeta" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        Titular de la tarjeta
                        <br />
                        <input type="text" id="titularTarjeta" name="titularTarjeta" class="form-control input-sm datosTarjeta" placeholder="Como aparece en la tarjeta" />
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Tipo tarjeta
                        <br />
                        <select id="tipoTarjeta" name="tipoTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="Visa">Visa</option>
                            <option value="Master Card">Master Card</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Banco
                        <br />
                        <input type="text" id="bancoTarjeta" name="bancoTarjeta" class="form-control input-sm datosTarjeta" placeholder="Banco emisor" />
                    </div>
                    <div class="col-sm-2 col-md-2">
                        Tipo de pago aplicación
                        <br />
                        <select id="tipoPagoTarjeta" name="tipoPagoTarjeta" class="form-control input-sm datosTarjeta">
                            <option value="Un solo cargo">Un solo cargo</option>
                            <option value="Domiciliada">Domiciliada</option>
                            <option value="Meses sin intereses">Meses sin intereses</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


                <?php if(isset($pagoFactura)){ ?>
             <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Factura</label>
           </div>
           <div class="col-sm-2 col-md-2">
            <select name="pagoFactura" class="form-control input-sm" onchange="cambioDatosFactura(this.value)"><?php 
              foreach($pagoFactura as $value){?>
                <option value="<?php echo($value->idPagoFactura); ?>"><?php echo($value->pagoFactura); ?></option>
              <?php
              }
            ?></select>
        </div>
        </div>
        <?php } ?>
                <div class="row ocultarObjeto" align="right" id="divDatosFactura" >
                                <div class="col-sm-2 col-md-2" align="right">
            <br />
                <label class="labelResponsivo">Datos de Factura:</label>
            </div>
                     <div class="col-sm-10 col-md-10" >
                    <div class="col-sm-2 col-md-2" align="left">
                        Direccion

                        <br />
                        <input type="text" id="direccionFactura" name="direccionFactura" class="form-control input-sm" placeholder="Ingrese Direccion"  />                        
                    </div>
                    <? $rfcFactura='';
                    if(isset($informacionCliente[0]->RFC)){$rfcFactura=(string)$informacionCliente[0]->RFC;}
                    ?>
                    <div class="col-sm-2 col-md-2" align="left">
                        RFC
                        <br />
                        <input type="text" id="rfcFactura" name="rfcFactura" class="form-control input-sm" placeholder="Ingrese el RFC"  value="<?=$rfcFactura?>" /> 
                                               
                    </div>
                    <div class="col-sm-2 col-md-2" align="left">
                        CP
                        <br />
                        <input type="text" id="cpFactura" name="cpFactura" class="form-control input-sm" placeholder="Ingrese codigo postal"  />                        
                    </div>  
                    </div>                              
                </div>
           <?php if(isset($permisos['polizaVerde'])){ ?>
        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Poliza verde:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="tarjetaVerde" class="form-control input-sm"><option value="0">No</option><option value="1">Si</option></select>
        </div>
        </div>
  <?php  } ?> 


        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
             <label class="labelResponsivo">Seleccionar compania:</label>
            </div>
            <div class="col-sm-10 col-md-10   " >
            <?php   if(isset($companias)){$opciones='<select name="selectCompania" required="required" class="form-control input-sm">';
              $opciones=$opciones.'<option value="">-- Seleccione --</option>';
                foreach ($companias as $value) {
                    $opciones=$opciones.'<option class="labelResponsivo" value="'.$value->idPromotoria.'">'.$value->Promotoria.'</option>';
                }
                $opciones=$opciones.'</select>';
                echo($opciones);
            } ?>
        </div>
        </div>





        </div>
        

    <!-- Cruce de Cartera [Suemy][2024-06-26] -->
        <div class="row">
            <div class="col-md-2 pd-items-table pd-items-table-top" align="right">
                <label class="labelResponsivo"> Cruce de cartera:</label>
            </div>
            <div class="col-md-10 pd-items-table pd-items-table-top">
                <input type="checkbox" class="form-check-input" name="cruce" id="cruce" value="1">
            </div>
        </div>
    <!-- -->


        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
            	<label class="labelResponsivo">Vendedor:</label>
            </div>
			<div class="col-sm-10 col-md-10">
            	<? print($SelectVendedor); ?>

                  <?  //ENLACE PROYECTO 100
                   if( $IDPcien > 0)
                   { 
                 ?>
                 <font color='red'>
                 Enlace Proyecto 100:
                 </font>
                 <input 
                    type="text" name="IDPcien" id="IDPcien"
                    maxlength="10" size="8"
                    readonly=""  value="<? echo $IDPcien  ?>" 
                />

                <?
                 }
                ?>
                
            </div>

            

		</div>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            <label class="labelResponsivo">	Datos <?=$tipoActividad?> Expr&eacute;s:</label>
            </div>
        	<div class="col-sm-10 col-md-10">
					<textarea name="datosExpres" id="datosExpres" style="width:100%;">
            		<?=($TextoExpresFormulario != false)?$TextoExpresFormulario->row()->textoExpres_formulario:''?>
                    <?=($idPoliza != "" && isset($idPoliza))?'EMISION DE LA POLIZA: '.$idPoliza:''?>
                    </textarea>
					<?php echo display_ckeditor($ckeditor); ?>
            </div>
        </div>
		<div class="row" style="padding-bottom:-60px;">
        	<div class="col-sm-2 col-md-2" align="right">
            	&nbsp;
            </div>
        	<div class="col-sm-10 col-md-10"> 
				<?=($TextoExpresAsteriscos != false)?$TextoExpresAsteriscos->row()->textoExpres_asteriscos:''?>

            </div>
		</div>
        <?
			//include();
        ?>


        <? $rfcCliente='';
                    if(isset($informacionCliente[0]->RFC)){$rfcCliente=(string)$informacionCliente[0]->RFC;}
                    ?>
        <div class="row">
			<div class="col-sm-12 col-md-12">
                                  <input type="hidden" name="TipoEnt" id="TipoEnt" value="<?=$informacionCliente->TipoEnt?>" />  
                      <input type="hidden" name="oldValueRFC" value="<?=$rfcCliente?>"  id="oldValueRFC"/>
				<input type="hidden" name="tipoActividad" id="tipoActividad" value="<?=$tipoActividad?>" />
            	<input type="hidden" name="tipoRamo" id="tipoRamo" value="<?=$tipoRamo?>" />
            	<input type="hidden" name="tipoSubRamo" id="tipoSubRamo" value="<?=$this->capsysdre_actividades->SubRamoActivicad($tipoSubRamo)?>" />                
            	<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?=$tipoCliente?>" />
            	<input type="hidden" name="IDCli" id="IDCli" value="<?=$informacionCliente[0]->IDCli?>" />
            	<input type="hidden" name="IDCont" id="IDCont" value="<?=$informacionCliente[0]->IDCont?>" />        
				<input type="hidden" name="IDDir" id="IDDir" value="-1" />
            	<input type="hidden" name="IDAgente" id="IDAgente" value="63" />                                
            	<input type="hidden" name="IDGrupo" id="IDGrupo" value="1" />
                <input type="hidden" name="tipoActividadSicas" id="tipoActividadSicas" value="<?=$tipoActividadSicas?>" />
            	<input type="hidden" name="TipoDocto" id="TipoDocto" value="<?=$TipoDocto?>" /><!-- -->
            	<input type="hidden" name="IDEjecut" id="IDEjecut" value="<?=$IDEjecut?>" /><!-- -->
            	<input type="hidden" name="IDSRamo" id="IDSRamo" value="<?=$tipoSubRamo?>" />
            	<input type="hidden" name="poliza" id="poliza" value="<?=$idPoliza?>" />
                
				<!-- <input type="" name="IDVend" id="IDVend" value="<?=$IDVend?>" /> -->
                <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>" />
                <input type="hidden" name="usuarioResponsable" id="usuarioResponsable" value="<?=$usuarioResponsable?>" />
                <input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<?=$usuarioResponsable?>" />
            </div>
        </div>
                    <div class="col-sm-2 col-md-2">
    
            </div>
        <div class="row" align="right">
                        <center>
                    <label class="labelResponsivo">
                        Emisi&oacute;n Urgente !!!
                    </label>
                    <input 
                        name="actividadUrgente" id="actividadUrgente" 
                        type="checkbox" title="Clic Para Seleccionar" 
                        value="1" class="form-control"
                    />
                </center>
                <center>
                    <label class="labelResponsivo label label-warning">
                       SE REQUIERE RFC PARA FACTURA
                    </label>
                    <input 
                        name="actividadRequiereFactura" id="actividadRequiereFactura" 
                        type="checkbox"  class="form-control" style="" onclick="activaRFCNecesario()" 
                    />
                </center>
			<div class="col-sm-12 col-md-12">               	
                <input type="button" value="Cancelar" onclick="window.open('<?=$urlCancelar?>','_self');" id="cancelarActividad"  />
                <input type="submit" value="<? echo "Guardar ".$this->uri->segment(3); ?>" id="guardarActividad" onclick="verificarDatos(event,this)"/>
            </div>
        </div>
<?
		}
?>
        <?
		}
		?>
<div id="miModalGenerico" class="modalCierraGenerico" ><div id="ModalcontenidoGenerico" class="modal-contenidoGenerico"  ><div class="contenidoModal"><div><button onclick="cerrarModal()" class="botonCierre">X</button></div><div><label>Nuevo giro:<input type="text" id="inputNuevoGiro" class="form-control input-sm"></label></div><div><button onclick="grabaNuevoGiro(null)">Guardar</button></div></div></div></div>

<script>
    function escogerFormaPago()
{

    let valueFP=document.getElementById('pagoFormas');
    let valueCP=document.getElementById('pagoConducto');

    if(valueFP.value==4)
    {
        if(valueCP.value!=3 && valueCP.value!=4){document.getElementById('pagoConducto').value=3;cambiarConducto(3);}
        for (let i = 0; i < valueCP.length; i++) {if(valueCP[i].value==1 || valueCP[i].value==2 ||  valueCP[i].value==''){valueCP[i].setAttribute('disabled','disabled');  }}
    }
    else
    {for (let i = 0; i < valueCP.length; i++) {if(valueCP[i].value==1 || valueCP[i].value==2 ||  valueCP[i].value==''){valueCP[i].removeAttribute('disabled','disabled');  }}}
}
    document.getElementById('pagoFormas').addEventListener("change",function(){cambiarConducto(document.getElementById('pagoConducto').value)})
    document.getElementById('pagoFormas').addEventListener("change",escogerFormaPago)
    document.getElementById('pagoConducto').addEventListener("change",escogerFormaPago)
    function cambiarConducto(valor)
    {        let obj=document.getElementsByClassName('datosTarjeta');
        let cant=obj.length;
        if(valor==3 || valor==4){document.getElementById('divPagoTarjeta').classList.add('verObjeto');document.getElementById('divPagoTarjeta').classList.remove('ocultarObjeto');

       if(document.getElementById('pagoFormas').value==4){for(let i=0;i<cant;i++){obj[i].setAttribute('required','required');}}
       else{for(let i=0;i<cant;i++){obj[i].removeAttribute('required')}}
    }
        else{for(let i=0;i<cant;i++){obj[i].removeAttribute('required')};document.getElementById('divPagoTarjeta').classList.remove('verObjeto');document.getElementById('divPagoTarjeta').classList.add('ocultarObjeto');}
    }
    function cambioDatosFactura(valor){
                if(valor==2 || valor==3){
            document.getElementById('divDatosFactura').classList.add('verObjeto');
            document.getElementById('divDatosFactura').classList.remove('ocultarObjeto');
            document.getElementById('direccionFactura').setAttribute('required','required');
           // document.getElementById('rfcFactura').setAttribute('required','required');
            document.getElementById('cpFactura').setAttribute('required','required');

        }else
        {
            document.getElementById('divDatosFactura').classList.remove('verObjeto');
            document.getElementById('divDatosFactura').classList.add('ocultarObjeto');
             document.getElementById('direccionFactura').removeAttribute("required");
            // document.getElementById('rfcFactura').removeAttribute("required");
             document.getElementById('cpFactura').removeAttribute("required");
        document.getElementById('direccionFactura').value="";
          //   document.getElementById('rfcFactura').value="";
             document.getElementById('cpFactura').value="";

        }
    }
</script>
<?php
function imprimirEstados($datos){
    $option='<option></option>';
    foreach ($datos as  $value) {$option.='<option value="'.$value->clave.'">'.$value->estado.'</option>';}
    return $option;
}
function imprimirGiroCatalogo($datos){
         $option='<option></option>';
    foreach ($datos as  $value) {$option.='<option value="'.$value->idGiro.'">'.$value->giro.'</option>';}
    return $option;  
}
?>
<style type="text/css">
.botonCierre{background-color: red;color:white;}
.modal-contenidoGenerico{background-color:none  ;width:80%;height:100%;left: 20%;margin: 5% auto;position: relative;z-index: 1000 } 
.modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 10000}
.botonCierre{background-color: red;color:white;}
.contenidoModal{border: solid;background-color: white;width: 50%;height: 60%; position: relative;left: -0%;top: -5%}
</style>
<script type="text/javascript">
     function cerrarModal(){document.getElementById("miModalGenerico").classList.add("modalCierraGenerico");document.getElementById("miModalGenerico").classList.remove("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").classList.remove("verObjeto");document.getElementById("ModalcontenidoGenerico").classList.add("ocultarObjeto");  }
 function abrirModal(e){e.preventDefault();document.getElementById("miModalGenerico").classList.remove("modalCierraGenerico");document.getElementById("miModalGenerico").classList.add("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").classList.add("verObjeto");document.getElementById("ModalcontenidoGenerico").classList.remove("ocultarObjeto");  document.getElementById('inputNuevoGiro').focus()}
function grabaNuevoGiro(procesoDatos){
    
    if(procesoDatos==null){
    var datos='';
   if(document.getElementById('inputNuevoGiro').value!=''){  datos="giro="+document.getElementById('inputNuevoGiro').value;mandaAJAX('actividades/nuevoGiro',datos,0);}
   }else{
    var total=procesoDatos.catalogo.length;
    var opciones="";
     for(var i=0;i<total;i++){
        if(procesoDatos.catalogo[i].idGiro==procesoDatos.activo){
      opciones=opciones+'<option value="'+procesoDatos.catalogo[i].idGiro+'" selected>'+procesoDatos.catalogo[i].giro+'</option>'
        }else{
        opciones=opciones+'<option value="'+procesoDatos.catalogo[i].idGiro+'">'+procesoDatos.catalogo[i].giro+'</option>';}      
     }
 
     document.getElementById('giroCliente').innerHTML=opciones;
     cerrarModal();
   }
}
function mandaAJAX(controlador,datos,manejoRespuesta){
    var url="<?=base_url();?>";
    url=url+controlador;
 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {     
      var respuesta=JSON.parse(this.responseText);
      grabaNuevoGiro(respuesta);
    }
  };
  xhttp.open("POST", url, true);
  xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xhttp.send(datos);
}
</script>
<script type="text/javascript">
function activaRFCNecesario()
{
    if(document.getElementById('rfcFactura'))
    {
     if(document.getElementById('actividadRequiereFactura').checked)
     {
        document.getElementById('rfcFactura').setAttribute('required','true');
     }
     else
     {
      document.getElementById('rfcFactura').removeAttribute('required');
     }
   }
}    

</script>

<script type="text/javascript">
        function verificarDatos(event,objeto)
        {
            
            let elementos=Array.from(document.getElementsByName('formActividadAgregar_clienteExistente')[0].elements); 
            let entrarRFC=true;
            elementos.forEach(e=>{if(e.required){if(e.value==''){entrarRFC=false;}}})
            if(entrarRFC){
                event.preventDefault();
            if(document.getElementById('rfcFactura').value=='')
            {
                alert('SE REQUIERE UN RFC');
                return 0;
            }
            else
            {  
                if(!document.getElementById('cruce').checked)
                {
                    let text = "¿Esta seguro que esta emision no es un cruce de cartera?\n 1.Si es asi de aceptar y prosiga \n 2.Si no cancele y seleccione cruce de cartera";
                    if (confirm(text) == false) 
                    {
                        return false;
                    }
                } 

                var req = new XMLHttpRequest();
                var   url="<?= base_url();?>actividades/comprobarInfoDelRFC";                
                req.open('POST', url, true);
                req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                let parametros=`rfcCliente=${document.getElementById('rfcFactura').value}&entidad=${document.getElementById('TipoEnt').value}`
                req.onreadystatechange = function (aEvt) 
                 {
   
                  if (req.readyState == 4) 
                   {
        
                    if(req.status == 200)
                      {           
                              let respuesta=JSON.parse(this.responseText);    
                              if(respuesta.infoRFC.esRFC==0)
                              {
                                alert(respuesta.infoRFC.mensaje);
                              }             
                              else
                              {
                                
                                document.getElementsByName('formActividadAgregar_clienteExistente')[0].submit();
                              }
                      }     
                    if(req.status==500){}
      
                 }

            };//FIN PETICION AJAX
            req.send(parametros);
            }//FIN ELSE
          }//ENTRARRCF
        }

    </script>
