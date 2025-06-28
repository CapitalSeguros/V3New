<?php
 
abstract class FileUploader
{
    public function uploadFile($temp_location)
    {
        $url = $this->moveFile($temp_location);
 
        // TODO persist additions to file manager CMS here.
        // may want to have FileUploader extend DataMapper model class
 
        return $url;
    }
 
    abstract public function moveFile($temp_location);
}
?>