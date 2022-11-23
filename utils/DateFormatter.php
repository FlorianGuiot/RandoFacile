<?php
namespace Date\Utils;

use DateTime;
use IntlDateFormatter;

class DateFormatter{
    
    private DateTime $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * Retourne la date en Français au format : D dd MM yyyy
     * Ex : Mardi 30 Juin 2002
     * Peut également retourner : hier, aujourd'hui et demain
     * 
     */
    public function GetDateEcrite(){


        setlocale(LC_TIME, "fr_FR","French");
        $formatter = new IntlDateFormatter("fr_FR",IntlDateFormatter::RELATIVE_FULL, IntlDateFormatter::NONE);
        $formatter->setPattern('D dd MM yyyy'); 
    
        return $formatter->format($this->date);

    }

    

     /**
     * Retourne l'heure au format : H "h" mm
     * Ex : 9h05
     * 
     */
    public function GetHeureEcrite(){
    
        return $this->date->format('H')."h".$this->date->format('i');;

    }
}



?>