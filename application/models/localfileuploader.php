<?php

class localfileuploader extends FileUploader
{
    // ensure your HTTP server instance can write to this path.
    // e.g., for Apache
    //     chmod 0774 assets/upload/images/
    //     chown www-data:www-data assets/upload/images/
    const IMAGE_UPLOAD_DIR = 'assets/files';

    public function __construct()
    {
        $this->_supported_extensions = array('jpg', 'jpeg', 'gif', 'png', 'pdf');
    }

    /**
     * Move uploaded file to the storage directory only if its MIME type is
     * accepted.
     *
     * @param $temp_location $_FILES array entry w/ details of local file.
     * @throws Exception When there are issues moving file to upload directory.
     */
    public function moveFile($temp_location)
    {
        $filename = basename($temp_location['name']);
        $info = pathinfo($filename);
        $ext = strtolower($info['extension']);

        if (isset($temp_location['tmp_name']) &&
            isset($info['extension']) &&
            in_array($ext, $this->_supported_extensions)) {
            $new_file_path = self::IMAGE_UPLOAD_DIR . DIRECTORY_SEPARATOR  . $filename;
            if (!is_dir(self::IMAGE_UPLOAD_DIR) ||
                !is_writable(self::IMAGE_UPLOAD_DIR)) {
                // Attempt to auto-create upload directory.
                if (!is_writable(self::IMAGE_UPLOAD_DIR) ||
                    FALSE === @mkdir(self::IMAGE_UPLOAD_DIR, null , TRUE)) {
                    throw new Exception('Error: File permission issue, ' .
                        'please consult your system administrator');
                }
            }

            if (move_uploaded_file($temp_location['tmp_name'], $new_file_path)) {
                return DIRECTORY_SEPARATOR . $new_file_path;
            }
        }

        throw new Exception('File could not be uploaded.');
    }
}
?>