<?php
$origen = "R";
$fechaProgramada = $fechaComentario ." ". $hora;
$comentarioMuestra = $comentario;
$comentario = "|".$tipoComentario."|".$fechaProgramada.":00|".$comentario;

			$sqlAgregarActividad = "
				Insert Into `cobranzapendiente_comentarios`
					(		
						`poliza`
						,`tipoComentario`
						,`fechaProgramada`
						,`comentarioMuestra`
						,`comentario`
						,`operador`
						,`origen`
						,`folioActividad`
					)
				Values
					(
						'$poliza'
						,'$tipoComentario'
						,'$fechaProgramada'
						,'$comentarioMuestra'
						,'$comentario'
						,'$IDUsuarioCreacion'
						,'$origen'
						,'$recId'
					)
								   ";	
?>