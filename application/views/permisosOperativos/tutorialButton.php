<?php

    $modules = array(
        "seguimientoProspecto" => "prospecto",
        "directorio" => "directorio",
        "actividades" => "actividades",
        "cproyecto" => "seguimiento",
        "muestraProyectos" => "seguimiento",
        "cobranza" => "cobranza",
        "renovacion" => "renovaciones",
        "videos" => "capacita"
    );

    $controller = $this->router->fetch_method() == "index" ? $this->router->fetch_class() : $this->router->fetch_method();
    $CI=&get_instance();
    $CI->load->model("preguntamodel", "tutorial");
    $allTutorial = $CI->tutorial->getTutorialList($modules[$controller]);
    $fileurl = "https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/modulos_de_tutoria%2F"; //FPROSPECTO%2F29_julio.mp4?alt=media&token="
    $token = "?alt=media&token=";
    //--------------------------
    function validateUrl($url){
        //var_dump($url);
        $header = get_headers($url);
        $getIndex = explode(" ", $header[0]);

        return $getIndex[1] == "200" ? true : false;
    }
    //-------------------------
?>
<?php if(!empty($allTutorial)){ ?>
<div class="col-md-12 text-center">
    <div class="dropdown">
        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dpd<?=$modules[$controller]?>" data-toggle="dropdown" aria-expanded="true" aria-haspopup="true">
            Tutoriales
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dpd<?=$modules[$controller]?>">
            <?= array_reduce($allTutorial, function($acc, $curr) use($fileurl, $token){
                $fileForUpload = "";
                $validateFile = validateUrl($fileurl.strtoupper($curr->modulo)."%2F".$curr->nameDoc);

                if($validateFile){
                    $getFileData = json_decode(file_get_contents($fileurl.strtoupper($curr->modulo)."%2F".$curr->nameDoc));
                    $fileForUpload = $fileurl.strtoupper($curr->modulo)."%2F".$curr->nameDoc.$token.$getFileData->downloadTokens;
                }

                $acc .= '
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="'.$fileForUpload.'" target="_blank">
                            <div>'.$curr->name.'</div>
                            <div><small>'.$curr->description.'</small></div>
                        </a>
                    </li>
                ';
                return $acc;
            }, ""); ?>
        </ul>
    </div>
</div>
<?php }?>