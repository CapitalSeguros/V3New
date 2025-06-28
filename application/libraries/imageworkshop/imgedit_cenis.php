<?php 
   //use imageworkshop\PHPImageWorkshop\ImageWorkshop;
    use PHPImageWorkshop\ImageWorkshop;
    require_once(__DIR__.'/imageworkshop/src/Core/ImageWorkshopLayer.php');
    require_once(__DIR__.'/imageworkshop/src/Core/ImageWorkshopLib.php');
    require_once(__DIR__.'/imageworkshop/src/Exception/ImageWorkshopBaseException.php');
    require_once(__DIR__.'/imageworkshop/src/Exception/ImageWorkshopException.php');
    require_once(__DIR__.'/imageworkshop/src/Core/Exception/ImageWorkshopLayerException.php');
    require_once(__DIR__.'/imageworkshop/src/Core/Exception/ImageWorkshopLibException.php');
    require_once(__DIR__.'/imageworkshop/src/ImageWorkshop.php'); //ImageWorkshopLayerException

    define("PATH_FONT", __DIR__."/imageworkshop/fonts");

class Imgedit_cenis {

    function crear_img_edit($array,$d,$m){

        try{

            $meses[1]="enero";
            $meses[2]="febrero";
            $meses[3]="marzo";
            $meses[4]="abril";
            $meses[5]="mayo";
            $meses[6]="junio";
            $meses[7]="julio";
            $meses[8]="agosto";
            $meses[9]="septiembre";
            $meses[10]="octubre";
            $meses[11]="noviembre";
            $meses[12]="diciembre";
            

            $img_a=ImageWorkshop::initFromPath(base_url()."assets/plantillas_hb/plantilla_cumple.jpg");

            $text=ucwords($array->nombres)." ".ucwords($array->apellidoPaterno)." ".ucwords($array->apellidoMaterno); //"Dennis Alberto Castillo Hernandez";
            //var_dump($text);
            $fontPath=PATH_FONT."/comic_sans_ms_bold.ttf";
            $fontSize=15;
            $fontColor="FFFFFF";
            $textRotation=0;
            $backgroundColor="0359AB";

            $text_f=$d.".".ucwords($meses[$m]);
            $fontPath_f=PATH_FONT."/Italic_dd.ttf";
            $fontSize_f=20;
            $fontColor_f="000102";
            $textRotation_f=0;
            $backgroundColor_f="EAECEE";

            //Cumplañero.
            $persona_cumple = ImageWorkshop::initTextLayer($text, $fontPath, $fontSize, $fontColor, $textRotation, $backgroundColor);
            $fecha_cumple = ImageWorkshop::initTextLayer($text_f, $fontPath_f, $fontSize_f, $fontColor_f, $textRotation_f, $backgroundColor_f);

            //Dimensión del texto (sirve de igual manera para ajustar el texto a una dimensión fija);
            $thumbWidth = 250; // px
            $thumbHeight = null;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            
            $persona_cumple->resizeInPixel($thumbWidth, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);

            //Unir las capas en la Img padre.
            $img_a->addLayer(3,$persona_cumple,round($img_a->getWidth()*0.3),round($img_a->getHeight()*0.53));
            $img_a->addLayer(3,$fecha_cumple,round($img_a->getWidth()*0.4),round($img_a->getHeight()*0.57));
            //Generar resultado;
            $image = $img_a->getResult();
            
            //Guardar las imagenes de felicitación en un directorio.
            //$dirPath =$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/assets/plantillas_hb/".$m.$d;
            $dirPath =$_SERVER["DOCUMENT_ROOT"]."/V3/assets/plantillas_hb/".$m.$d;
            $filename = $array->idPersona."_hb.png";
            $createFolders = true;
            $backgroundColor = null; // transparent, only for PNG (otherwise it will be white if set null)
            $imageQuality = 95; // useless for GIF, usefull for PNG and JPEG (0 to 100%)
            
            $img_a->save($dirPath, $filename, $createFolders, $backgroundColor, $imageQuality);

            //header('Content-type: image/png');
            //imagejpeg($image, null, 95);

            //return $dirPath."/".$filename;

        } catch(Exception $e){
            echo "Excepción capturada: \n\n", $e->getMessage(),"\n";
        }
        
    }
    //----------------------
    function createWelcomeTemplate($photo, $id, $name, $initDate, $email, $job ,$_description, $template){

        $principalImg = ImageWorkshop::initFromPath(base_url()."assets/plantillas_ingreso/".$template.".png");
        $photoPerson = ImageWorkshop::initFromPath(base_url()."assets/img/miInfo/userPhotos/".$photo."");
        //$imageSize = imagecreate(200, 500);


        $descriptionTitle = "Objetivo del puesto";
        $description = $_description; //"Atender las necesidades de los agentes asociados en el canal de agentes independientes CAP Capital, con el fin de incrementar la productividad e impulsar el crecimiento de su cartera de clientes siempre velando y respetando la imagen y lineamientos de la empresa. \n\nLogrando ser un vínculo amistoso de gestoría, capacitación  y apoyo en general entre las necesidades del agente con la empresa. Mantener contacto cercano con todos sus agentes para conocer sus motivadores.";
        $fontPathAB = PATH_FONT."/arial_black.ttf";
        $fontPathA = PATH_FONT."/Arial.ttf";
        $textRotation = 0;

        $thumbWidth = 280; // px
        $thumbHeight = 342;
        $conserveProportion = false;
        $positionX = 0; // px
        $positionY = 0; // px
        $position = 'MM';

        $layer = ImageWorkshop::initVirginLayer(350, 300);

        $title_ = ImageWorkshop::initTextLayer($descriptionTitle, $fontPathAB, 16, "17202A", $textRotation);
        $dateAfterTraining = ImageWorkshop::initTextLayer(date("d.m.Y", strtotime($initDate)), $fontPathAB, 14, "2B3E63", $textRotation);
        $newPerson = ImageWorkshop::initTextLayer($name, $fontPathAB, 12, "2B3E63", $textRotation);
        $newJob = ImageWorkshop::initTextLayer($job, $fontPathAB, 12, "2B3E63", $textRotation);
        $newMail = ImageWorkshop::initTextLayer($email, $fontPathAB, 12, "2B3E63", $textRotation);
        $description_ = ImageWorkshop::initTextLayer(wordwrap($description, 60, "\n"), $fontPathA, 14, "17202A", $textRotation, "FDFEFE");
        //$newPerson->resizeInPixel($thumbWidth, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
        $photoPerson->resizeInPixel($thumbWidth, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);

        $principalImg->addLayer(3,$title_,round($principalImg->getWidth()*0.4),round($principalImg->getHeight()*0.23));
        $principalImg->addLayer(3,$description_,round($principalImg->getWidth()*0.4),round($principalImg->getHeight()*0.30));
        $principalImg->addLayer(3,$dateAfterTraining,round($principalImg->getWidth()*0.863),round($principalImg->getHeight()*0.709));
        $principalImg->addLayer(3,$newPerson,round($principalImg->getWidth()*0.03),round($principalImg->getHeight()*0.87));
        $principalImg->addLayer(3,$newJob,round($principalImg->getWidth()*0.03),round($principalImg->getHeight()*0.91));
        $principalImg->addLayer(3,$newMail,round($principalImg->getWidth()*0.03),round($principalImg->getHeight()*0.95));
        $principalImg->addLayer(3,$photoPerson,round($principalImg->getWidth()*0.03),round($principalImg->getHeight()*0.306));
        $image = $principalImg->getResult();
        //header('Content-type: image/png');
        //imagejpeg($image, null, 95);

        //$dirPath =$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/assets/plantillas_ingreso/platillas_nuevas_personas/";
        $dirPath =$_SERVER["DOCUMENT_ROOT"]."/V3/assets/plantillas_ingreso/platillas_nuevas_personas/";
        $filename = "person_".$id.".png";
        $createFolders = true;
        $backgroundColor = null; // transparent, only for PNG (otherwise it will be white if set null)
        $imageQuality = 95; // useless for GIF, usefull for PNG and JPEG (0 to 100%)
            
        $principalImg->save($dirPath, $filename, $createFolders, $backgroundColor, $imageQuality);

        return "assets/plantillas_ingreso/platillas_nuevas_personas/person_".$id.".png";
    }
    //----------------------
}

?>