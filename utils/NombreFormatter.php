<?php
namespace Number\Utils;

class NombreFormatter{


    /**
     * Retourne le nombre au format 100 000 000,50
     * 
     */
    public static function GetNombreFormatFr($nombre){

        return number_format((float)$nombre, 2, ',', ' ');

    }


    /**
     * Retourne le nombre avec deux chiffres après la virgule
     * 
     */
    public static function GetNombreDeuxChiffresVirgule($nombre){

        return number_format((float)$nombre, 2, '.', '');

    }

}



?>