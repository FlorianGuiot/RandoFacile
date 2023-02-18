<?php 

$user = UserManager::getUserById($_SESSION['iduser']);

$lesCommandes = CommandeManager::GetCommandeByUser($user);

foreach($lesCommandes as $uneCommande){

    echo $uneCommande->GetAdresse();
    echo " : ";

    $lePanierObjet = $uneCommande->GetDetailsCommande();
    $lePanier = $lePanierObjet->GetPanier();
    foreach($lePanier as $unP){

        echo $unP['produit']->GetLibelle();
        echo " x ";
        echo $unP['qte'];
        echo " / ";
    }
    echo "</br>";

    $lesStatuts = $uneCommande->GetLesStatuts();

    foreach($lesStatuts as $unStatut){

        echo $unStatut['statut']->GetLibelle() ." ". $unStatut['date'] ." ";
    }

    $leStatut = $uneCommande->GetLeStatut();

    echo "</br>";
    echo $leStatut['statut']->GetLibelle();
    echo $leStatut['date'];
    echo "</br>";
    echo "</br>";

}



?>