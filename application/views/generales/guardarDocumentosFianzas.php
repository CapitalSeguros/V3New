<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fine Uploader New/Modern CSS file
    ====================================================================== -->
    <link href="<?= base_url('assets/plugins/fine-uploader/fine-uploader-new.css'); ?>" rel="stylesheet">

    <!-- Fine Uploader JS file
    ====================================================================== -->
    <script src="<?= base_url('assets/plugins/fine-uploader/fine-uploader.js'); ?>"></script>

    <!-- Fine Uploader Thumbnails template w/ customization
    ====================================================================== -->
    <script type="text/template" id="qq-template-manual-trigger">
		<div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Arrastrar los Archivos o Darle Click al Boton de Agregar">
		
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
			
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
			
            <div class="buttons">
                <div class="qq-upload-button-selector qq-upload-button" title="Click - Agregar Archivos">
                    <div><img src="<?= base_url('assets/images/agregarArchivoIcono.png'); ?>" /></div>
                </div>
                <button type="button" id="trigger-upload" class="btn btn-primary" title="Click - Guardar los Archivos">
                    <!-- <i class="icon-upload icon-white"></i> <div>Subir</div> -->
					<div><img src="<?= base_url('assets/images/guardarArchivo.png'); ?>" /></div>
                </button>
            </div>
			
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Procesando archivos Arrastrados...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    
					<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    
					<span class="qq-upload-file-selector qq-upload-file"></span>
                    
					<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
					<br><br>
					<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
					
					<select tabindex="1">
							<option>-- Seleccione Tipo --</option>
						<?
							foreach($this->catalogos_model->catalog_tipoimg($array=array("tipoDocumento"=>"fianzas")) as $tiposDocumentos){
						?>
							<option value="<?= $tiposDocumentos->nombre ?>"><?= $tiposDocumentos->nombre ?></option>
						<?
							}
						?>
					</select>
					
					<input class="qq-edit-comentario-selector qq-edit-comentario" tabindex="2" type="text">
                    
					<span class="qq-upload-size-selector qq-upload-size"></span>
                    
					<button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancelar</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Reintentar</button>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Borrar</button>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Sí</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancelar</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>

    <style>
        #trigger-upload {
            color: white;
            background-color:#FFFFFF; /* #00ABC7 */
            font-size: 14px;
			/* padding: 7px 20px; */
           /* background-image: none; */
			border: #FFFFFF;
        }

        #fine-uploader-manual-trigger .qq-upload-button {
            margin-right: 15px;
        }

        #fine-uploader-manual-trigger .buttons {
            width: 36%;
        }

        #fine-uploader-manual-trigger .qq-uploader .qq-total-progress-bar-container {
            width: 60%;
        }
    </style>

    <title>Fine Uploader Manual Upload Trigger Demo</title>
</head>

<body>

	<?
//		echo "	<pre>";
//		echo "php zone";
//	$xxx	= $this->catalogos_model->catalog_tipoimg($array=array("tipoDocumento"=>"fianzas"));
//	print_r($xxx);
	?>

    <!-- Fine Uploader DOM Element
    ====================================================================== -->
    <div id="fine-uploader-manual-trigger"></div>

    <!-- Your code to create an instance of Fine Uploader and bind to the DOM/template
    ====================================================================== -->
    <script>
        var manualUploader = new qq.FineUploader({
            element: document.getElementById('fine-uploader-manual-trigger'),
            template: 'qq-template-manual-trigger',
            request: {
                endpoint: '<?= base_url('assets/plugins/fine-uploader/uploads/endpoint.php'); ?>'
            },
			
            thumbnails: {
                placeholders: {
                    waitingPath: '<?= base_url('assets/plugins/fine-uploader/placeholders/waiting-generic.png'); ?>',
                    notAvailablePath: '<?= base_url('assets/plugins/fine-uploader/placeholders/not_available-generic.png'); ?>'
                }
            },
			
            autoUpload: false,
            debug: true
        });

        qq(document.getElementById("trigger-upload")).attach("click", function() {
            manualUploader.uploadStoredFiles();
        });
    </script>
</body>