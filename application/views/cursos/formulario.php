<?= form_open("") ?>
<?
  $nombre=array('name'=>'nombre',
  	             'placeholder'=>'escribe tu nombre');
  $videos=array('name'=>'videos',
  	             'placeholder'=>'cantidad de videos');
 ?>
 <?= form_label('Nombre:','nombre')?>
 <?= form_input($nombre)?>
 <br><br>
  <?= form_label('Numero de videos:','videos')?>
 <?= form_input($videos)?>
 <?= form_submit('','subir curso')?>
 <?=form_close()?>
 </body>
 </html>