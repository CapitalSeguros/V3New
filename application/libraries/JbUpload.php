<?php
/**
 *
 */
class JbUpload
{
  var $instance = null;
  var $physical = '';
  function __construct()
  {
    $this->instance = &get_instance();
    $this->physical = $this->instance->config->item('physical_site');
  }

  function createDirectory($ref,$proye){

    $uploaddir = './uploads/';
    $uploaddir_ref = $uploaddir.$ref.'/';
    $uploaddir_ref_id = $uploaddir_ref.$proye.'/';

    if(!is_dir($this->physical.$uploaddir)){
      if(!mkdir($uploaddir, 0777, true)) {
          die('Fallo al crear las carpetas...');
      }
    }
    if(!is_dir($this->physical.$uploaddir_ref)){
      if(!mkdir($this->physical.$uploaddir_ref, 0777, true)) {
        die('Fallo al crear las carpetas...');
      }
    }
    if(!is_dir($this->physical.$uploaddir_ref_id)){
      if(!mkdir($this->physical.$uploaddir_ref_id, 0777, true)) {
        die('Fallo al crear las carpetas...');
      }
    }
    return $uploaddir_ref_id;
  }

  function moveFile($file, $path, $name){
    return move_uploaded_file($file['tmp_name'],$this->physical.$path.$name);
  }
  function moveFile2($file, $path,$ruta){
    //$path_parts = pathinfo($file);
    $newplace   = $path.$file;
    if(rename($ruta, $newplace))
        return $newplace;
    return true;

  }

}

?>
