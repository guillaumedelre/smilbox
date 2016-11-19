<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 18/11/16
 * Time: 22:07
 */

namespace AppBundle\Model\Filter;

class WarholFilter implements FilterInterface
{
    const NAME = 'WARHOL';

    const EFFECT_PARAMS = [
        [0, -100, 0],
        [0, 100, 0],
        [100, 0, -50],
        [-50, 0, 100],
    ];

    /**
     * @param string $filename
     */
    public static function apply($filename)
    {
        $images= [];

        $ratio = .25;

        list($width, $height) = getimagesize($filename);

        // Calcul des nouvelles dimensions
        $newWidth = $width * $ratio;
        $newHeight = $height * $ratio;

        // Redimensionnement
        $images[] = imagecreatetruecolor($newWidth, $newHeight); // LeftTop
        $images[] = imagecreatetruecolor($newWidth, $newHeight); // RightTop
        $images[] = imagecreatetruecolor($newWidth, $newHeight); // LeftBottom
        $images[] = imagecreatetruecolor($newWidth, $newHeight); // RightBottom

        // Chargement image originale
        $image = imagecreatefromjpeg($filename);
        $final = imagecreatetruecolor($width, $height); // Final image

        // Application du filtre sur chaque partie de la future image
        foreach (self::EFFECT_PARAMS as $i => $colorizeSet) {
            imagefilter($image, IMG_FILTER_COLORIZE, $colorizeSet[0], $colorizeSet[1], $colorizeSet[2]);
            imagecopyresampled($images[$i], $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        }

        // Calcul de l'effet sur l'image finale
        imagecopyresampled($final, $images[0],
            0, 0,
            0, 0,
            $width / 2, $height / 2,
            $newWidth, $newHeight
        );

        imagecopyresampled(
            $final, $images[1],
            $width / 2, 0,
            0, 0,
            $width, $height / 2,
            $width / 2, $newHeight
        );

        imagecopyresampled($final, $images[2],
            0, $height / 2,
            0, 0,
            $width / 2 , $height,
            $newWidth, $height / 2
        );

        imagecopyresampled($final, $images[3],
            $width / 2, $height / 2,
            0, 0,
            $width, $height,
            $width / 2, $height / 2
        );

        // Enregistre dans le fichier
        imagejpeg($final, "$filename-warhol.jpg", 100);

        // Supression des ressources
        imagedestroy($image);
        imagedestroy($final);
        foreach ($images as &$_image) {
            imagedestroy($_image);
        }
    }
}