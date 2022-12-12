<?php

use Number\Utils;
use Number\Utils\NombreFormatter;

if(!isset($params['valider']) || $params['valider'] != true ){

    header("Location: 404.php");
    exit;

}else{
?>

<body>

<?php

    require_once("./view/navbar/navbar.php"); // Navbar

?>

<div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

    <div class="row">
        <div id="panier-page-container" class="col-xl-8 col-md-12 panier-page-container"><!--Adresse-->
            <p class="fs-4 text text-uppercase">1. Adresse de livraison</p>

            <form id="validerPanier" action="index.php?controller=Panier&action=Valider" method="POST">
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox_CGV" name="checkbox_CGV" value="true">
                    <label class="form-check-label" for="checkbox_CGV">J'ai lu et j'accepte les <a href='index.php?controller=Info&action=readCGV' class='lien'>conditions générales de vente</a>.</label>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="text-center m-2">
                            <button id="BtnValiderPanier" type="submit" class="btn btn-primary"><i class="fa-solid fa-backward"></i> Retour</button>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center m-2">
                            <button id="BtnValiderPanier" type="submit" class="btn  btn-primary">Suivant <i class="fa-solid fa-forward"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div> <!--Fin detail panier-->
        
        <div id="panier-accepter" class="col-xl-4 col-md-12 d-flex align-items-center justify-content-center">
            <div class="border p-5 rounded">
                <p class="text-center fs-3 text ">Total :</p>
                <p class="text-center "><span id="prixTotalPanier" class="fs-3 prix text"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetPrixTotal()) ?> € </span><span class="small fs-6">TTC</span></p>
                <p class="text-center "><span id="prixTotalPanierHT" class="prix-ht"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetPrixTotalHT()) ?> € HT</span></p>
                
                <p class="">TVA : <span id="montantTVA" class="prix-ht"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetMontantTVA()) ?> €</span> <span id="montantTVA" class="prix-ht"> ( 20% )</span></p>
                
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