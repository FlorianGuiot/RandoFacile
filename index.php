<?php

// Enregistrement de la racine du site
define('ROOT', __DIR__);
define('SERVER_URL', "/Randofacile");
// define('SERVER_URL', $_SERVER["SERVER_NAME"]);
define('DEFAULT_CONTROLLER', "Accueil");
define('DEFAULT_ACTION', "read");

// Auto Chargement des class
require_once(__DIR__.'/autoload.php');

// Session
session_start();



//Panier
require_once __DIR__.'/controller/PanierController.php';
$lePanier = PanierController::GetPanier();
$_SESSION['panier_liste'] = $lePanier->GetAffichagePanier();
$_SESSION['panier_nbArticles'] = $lePanier->GetNbrProduits();

if($_SESSION['panier_nbArticles'] > 0){ $_SESSION['panier_nbArticlesVisible'] = ""; } else{ $_SESSION['panier_nbArticlesVisible'] = "d-none"; }


/*
====================================
Récupération des paramètres de l'URL
====================================

*/

// Page par défaut
if(!isset($_GET['controller'])){
    
    $controller = DEFAULT_CONTROLLER;
    $action = DEFAULT_ACTION;


}else{ // Autre page
 
    $controller = $_GET['controller'];
    $action = $_GET['action'];

}

// Tebleau de parametres
$params = array();
foreach($_GET as $key => $value){

    if(($key != "controller") && ($key != "action")){

        $params[$key] = $value;

    }
}

// Complement du nom du fichier controller (NomController)
$controller .= "Controller";



/*
===================
Appel du controller
===================
*/


$filePath = __DIR__.'/controller/'.$controller.'.php';

if(file_exists($filePath)){
    //Le controller existe
    //Inclut le fichier de class du controller
    require_once(__DIR__.'/controller/'.$controller.'.php');

    if(method_exists($controller, $action)){
        //La methode existe
        //Execution de l'action
        $controller::$action($params);
    }else{

        require_once(__DIR__.'/controller/ErreurController.php');
        ErreurController::read404();

    }

}else{
    
    require_once(__DIR__.'/controller/ErreurController.php');
    ErreurController::read404();
   
}


?>