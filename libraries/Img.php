<?php

require_once "autoloader.php";

class Img
{
    public static function imgResize($sizeMax, $content_dir, $src_file)
    {
        // ********************************************************************
        // Recuperation et Resize img
        // ********************************************************************
        if (!empty($src_file)) {

            // declaration des variables
            $name_file = $src_file['name'];
            $type_file = $src_file['type'];
            $size_file = $src_file['size'];
            $tmp_file = $src_file['tmp_name'];
            global $imgurl;

            //je vérifie la taille largeur/hauteur de mon image
            $size_img = getimagesize($tmp_file);

            $largSrc = $size_img[0]; //largeur
            $hautSrc =  $size_img[1]; //hauteur


            // calcule des largeurs et hauteurs par une règle de trois
            if ($largSrc < $hautSrc) {
                // image portrait
                $largDest = ($sizeMax * $largSrc) / $hautSrc;
                $hautDest = $sizeMax;
            } elseif ($largSrc > $hautSrc) {
                // image paysage
                $largDest = $sizeMax;
                $hautDest = ($sizeMax * $hautSrc) / $largSrc;
            } else {
                //image carré
                $largDest = $sizeMax;
                $hautDest = $sizeMax;
            }

            // limitation format image et poid
            // je limite le type de fichier à jpg / jpeg / gif / png 
            if (
                !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg')
                && !strstr($type_file, 'gif') && !strstr($type_file, 'png')
            ) {
                $erreur = "Ce fichier n'est pas une image du type voulu.";
            }
            // je limite la taille du fichier uploadé à 5Mo
            if ($size_file > 5000000) {
                $erreur = "Ce fichier est trop lourd";
            }
            // je test l'upload de l'image en cas d'erreur
            // ??????????? quel filtre pouvez-vous utiliser pour detecter l'erreur
            // if(???????){
            //$erreur = "Une erreur s'est produite lors du chargement de l'image";
            //}
            if (strstr($type_file, 'jpg') || strstr($type_file, 'jpeg')) {
                // Creer un image en jpg
                $img_new = imagecreatefromjpeg($tmp_file);
                $img_new_dest = imagecreatetruecolor($largDest, $hautDest);
                imagecopyresized(
                    $img_new_dest,
                    $img_new,
                    0,
                    0,
                    0,
                    0,
                    $largDest,
                    $hautDest,
                    $largSrc,
                    $hautSrc
                );
                imagejpeg($img_new_dest, $content_dir . "avatar_" . date("YmdHis") . ".jpg", 100);
                $imgurl =  $content_dir . "avatar_" . date("YmdHis") . ".jpg";
            }
            if (strstr($type_file, 'gif')) {
                // Creer un image en gif
                $img_new = imagecreatefromgif($tmp_file);
                $img_new_dest = imagecreatetruecolor($largDest, $hautDest);
                imagecopyresized(
                    $img_new_dest,
                    $img_new,
                    0,
                    0,
                    0,
                    0,
                    $largDest,
                    $hautDest,
                    $largSrc,
                    $hautSrc
                );
                imagegif($img_new_dest, $content_dir . "avatar_" . date("YmdHis") . ".gif");
                $imgurl = $content_dir . "avatar_" . date("YmdHis") . ".gif";
            }
            if (strstr($type_file, 'png')) {
                // Creer un image en png
                $img_new = imagecreatefrompng($tmp_file);
                $img_new_dest = imagecreatetruecolor($largDest, $hautDest);
                imagecopyresized(
                    $img_new_dest,
                    $img_new,
                    0,
                    0,
                    0,
                    0,
                    $largDest,
                    $hautDest,
                    $largSrc,
                    $hautSrc
                );
                imagepng($img_new_dest, $content_dir . "avatar_" . date("YmdHis") . ".png", 0);
                $imgurl = $content_dir . "avatar_" . date("YmdHis") . ".png";
            }
        }
        return $imgurl;
    }
}
