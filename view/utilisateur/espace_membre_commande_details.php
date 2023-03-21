<?php
use Date\Utils;
use Date\Utils\DateFormatter;
use Number\Utils\NombreFormatter;

//Si utilisateur déconnecté
if(!isset($_SESSION['iduser'])){

    header("Location: 404.php");
    exit;

}else{
?>

<body>

<?php

    require_once("./view/navbar/navbar.php"); // Navbar

?>


<div class="container-xl min-vh-100">

    <div class="row">

        <?php

        require_once("./view/navbar/navbar_user.php"); // Navbar menu utilisateur

        ?>
        <div class="col-8 mt-5 offset-1">
            
            <div class="d-flex justify-content-between">

                <p class="fs-3 mb-3">Ma commande</p>
                <p> N° de commande : <strong><?php echo $laCommande->GetId(); ?></strong></p>

            </div>
            

            <div class="shadow mb-5 bg-body rounded p-3 ">
                
                <p class="fs-5 mb-3">Adresse de livraison</p>

                <div class="row">

                    <div class="col-xl-6">
                        <p>Nom</p>
                        <p class="important"><?php echo $laCommande->GetNom(); ?></p>
                    </div>

                    <div class="col-xl-6">
                        <p>Prénom</p>
                        <p class="important"><?php echo $laCommande->GetPrenom(); ?></p>
                    </div>

                    <div class="col-xl-12">
                        <p>Adresse</p>
                        <p class="important"><?php echo $laCommande->GetAdresse(); ?></p>
                    </div>

                    <div class="col-xl-6">
                        <p>Ville</p>
                        <p class="important"><?php echo $laCommande->GetVIlle(); ?></p>
                    </div>

                    <div class="col-xl-3">
                        <p>Code postal</p>
                        <p class="important"><?php echo $laCommande->GetCP(); ?></p>
                    </div>

                    <div class="col-xl-3">
                        <p>Pays</p>
                        <p class="important"><?php echo $laCommande->GetPays()->GetLibelle(); ?></p>
                    </div>


                </div>
     

            </div>


            <div class="shadow mb-5 bg-body rounded p-3 ">
                
                <p class="fs-5 mb-3">Historique</p>
                

                <div class="timeline">
                <?php
                
                $coteGauche = true;

                foreach($laCommande->GetLesStatuts() as $unStatut):

                    if($coteGauche){
                        echo '<div class="container_timeline left">';
                        $coteGauche = false;
                    }else{
                        echo '<div class="container_timeline right">';
                        $coteGauche = true;
                    }

                    $date = new DateTime($unStatut['date']);
                    echo    '<div class="timeline_content">'.
                            '<p class="fs-4">'.date_format($date , "d/m/Y").'</p>'.
                            '<p>'.$unStatut['statut']->GetLibelle().'</p>'.
                            '</div>'.
                            '</div>';


                endforeach;

                ?>
                

            </div>
            </div>


            <div class="shadow mb-5 bg-body rounded p-3 panier-page-container">
            <p class="fs-5 mb-3">Détails</p>
            <p class="fs-6 mb-3">Total : <?php  echo NombreFormatter::GetNombreFormatFr($laCommande->GetDetailsCommande()->GetPrixTotal() + $laCommande->GetPays()->GetFrais()) ?> € TTC</p>
            <?php

                foreach($lePanier as $unP):

                    echo

                    '<div class="panierProduit shadow p-1 mb-4">'.
                    '<div class="row">'.
                        '<div class="col-xl-2 col-sm-12">'.
                            '<a href="'.$unP["produit"]->GetLienProduit().'" ><img height="100" src="'.$unP["produit"]->GetLiensImage()[0].'"></a>'.
                        '</div>'.
                        '<div class="col-10">'.
                            '<div class="col-6">'.
                                '<a href="'.$unP["produit"]->GetLienProduit().'" class="lien"><p class="fs-4">'.$unP['produit']->GetLibelle().'</p></a>'.
                                '<p> x '.$unP['qte'].'</p>'.
                            '</div>'.
                            '<div class="col-6">'.
                                '<p class="fs-7">'.NombreFormatter::GetNombreFormatFr($unP['produit']->CalculerMontant($unP['qte'])).' € TTC</p>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                    '</div>';

                endforeach;


            ?>
                

            </div>
        </div>
    </div>
</div>
<?php

    require_once("./view/footer/footer.php"); // Footer

?>

</body>

<?php
}
?>