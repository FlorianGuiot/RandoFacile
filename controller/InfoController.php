<?php


class InfoController{

    /**
     * Affiche la page CGV
     */
    public static function readCGV(){
        
        // Variables
        $params['page_name'] = "CGV";


        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/info/CGV.php"); // Page CGV
    
    

    }


}

?>