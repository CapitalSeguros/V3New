<?
  foreach($cursos->result() as $curso) { ?>
  <ul>
     <li><?= $curso->nombreCurso;?></li>
  </ul>
<? } ?>
</body>
</html>