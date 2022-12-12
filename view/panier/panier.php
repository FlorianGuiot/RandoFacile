<body>

<?php
use Number\Utils;
use Number\Utils\NombreFormatter;

    require_once("./view/navbar/navbar.php"); // Navbar

?>

<div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

    <div class="row">
        <div id="panier-page-container" class="col-xl-8 col-md-12 panier-page-container"><!--detail panier-->
            <?php
            if(count($lePanierListe) >= 1){
                foreach($lePanierListe as $unP): echo


                    
                    '<div data-id="'.$unP["produit"]->GetId().'" class="panierProduit shadow p-1 mb-4">'.
                        '<div class="row">'.
                            '<div class="col-xl-2 col-sm-12">'.
                                '<a href="'.$unP["produit"]->GetLienProduit().'" ><img height="100" src="'.$unP["produit"]->GetLiensImage()[0].'"></a>'.
                            '</div>'.
                            '<div class="col-10">'.
                                '<div class="col-12">'.
                                    '<a href="'.$unP["produit"]->GetLienProduit().'" class="lien"><p class="fs-4">'.$unP["produit"]->GetLibelle().'</p></a>'.
                                '</div>'.
                                '<div class="col-12">'.
                                    '<div class="row">'.
                                        '<div class="col-xl-2 col-sm-4">'.
                                            '<input  id="qteProduitLignePanier" type="number"  class="form-control qteProduitLignePanier" value="'.$unP['qte'].'" max="'.$unP['produit']->GetQteEnStock().'" min="1">'.
                                        '</div>'.
                                        '<div class="col-xl-9 col-sm-8">'.
                                            '<button id="BtnRemoveLignePanier" class="btn btn-danger BtnRemoveLignePanier"><i class="fa-solid fa-trash"></i></button>   '.
                                        '</div>'.
                                        '<div class="col-xl-12 col-sm-12 d-flex align-items-center">'.
                                            '<p data-prix="'.NombreFormatter::GetNombreFormatFr($unP['produit']->GetPrixUnitaire()).'" data-prixht="'.NombreFormatter::GetNombreFormatFr($unP['produit']->GetPrixUnitaireHT()).'" class = "prixTotalProduit">'.NombreFormatter::GetNombreFormatFr($unP['produit']->CalculerMontant($unP['qte'])).'</p><p>€ TTC </p>'.
                                        '</div>'.
                                        '<div class="col-xl-12 col-sm-12 d-flex align-items-center">'.
                                            '<p class="qteHelp"></p>'.
                                        '</div>'.
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '</div>'.
                    '</div>';

                


                endforeach;
            }else{

                echo '<div class="row"><div class="col-12 d-flex justify-content-center align-items-center"><p class="prix">Votre panier est vide...</p></div>'.
                    '<div class="col-12 d-flex justify-content-center align-items-center"><p class="prix">Il est temps de faire des achats</p></div></div>';

            }

            ?>
        </div> <!--Fin detail panier-->
        
        <div id="panier-accepter" class="col-xl-4 col-md-12 d-flex align-items-center justify-content-center">
            <div class="border p-5 rounded">
                <p class="text-center fs-3 text ">Total :</p>
                <p class="text-center "><span id="prixTotalPanier" class="fs-3 prix text"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetPrixTotal()) ?> € </span><span class="small fs-6">TTC</span></p>
                <p class="text-center "><span id="prixTotalPanierHT" class="prix-ht"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetPrixTotalHT()) ?> € HT</span></p>
                
                <p class="">TVA : <span id="montantTVA" class="prix-ht"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetMontantTVA()) ?> €</span> <span id="montantTVA" class="prix-ht"> ( 20% )</span></p>
                <p class="">Frais de livraison : <span id="montantFraisLivraison" class="prix-ht"><?php  if($lePanier->GetFraisLivraison() == 0){echo "Livraison offerte !"; }else{ echo  NombreFormatter::GetNombreFormatFr($lePanier->GetFraisLivraison()) ." €"; } ?> </p>
                <p class="validerHelp text-danger shake"><?php if (isset($params["erreur_valider"])){ echo $params["erreur_valider"]; } ?></p>
                <form id="validerPanier" action="index.php?controller=Panier&action=Valider" method="POST">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="checkbox_CGV" name="checkbox_CGV" value="true">
                        <label class="form-check-label" for="checkbox_CGV">J'ai lu et j'accepte les <a href='index.php?controller=Info&action=readCGV' class='lien'>conditions générales de vente</a>.</label>
                    </div>
                    <div class="text-center m-2">
                        <button id="BtnValiderPanier" type="submit" class="btn btn-lg btn-primary">Valider et payer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

    require_once("./view/footer/footer.php"); // Footer

?>

</body>