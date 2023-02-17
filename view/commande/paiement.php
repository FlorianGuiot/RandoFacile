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

<div class="container-xl">
    <!--Retour-->

    <!--Boutons-->
    <form action=<?php echo SERVER_URL."/commande/adresse/"?> method="POST">
    <!--CGV-->
    <input type="hidden" name="checkbox_CGV" value="true" />

    <div class="mt-2">
                    <button id="BtnRetourAdresse" type="submit" class="btn btn-primary"><i class="fa-solid fa-backward"></i> Retour</button>
                </div>

    </form>
</div>






<!-- formulaire -->
<form id="form-paiement" action=<?php echo SERVER_URL."/commande/paiement/valider/"?> method="POST">

    <?php if(isset($params['erreur_valider'])){echo $params['erreur_valider'];} ?>

    <!--Nom-->
    <input type="hidden" name="nom" value=<?php echo $_POST['nom']; ?> />
    <!--Prénom-->
    <input type="hidden" name="prenom" value=<?php echo $_POST['prenom']; ?> />
    <!--Adresse-->
    <input type="hidden" name="adresse" value=<?php echo $_POST['adresse']; ?> />
    <!--Ville-->
    <input type="hidden" name="ville" value=<?php echo $_POST['ville']; ?> />
    <!--CP-->
    <input type="hidden" name="CP" value=<?php echo $_POST['CP']; ?> />
    <!--Pays-->
    <input type="hidden" name="paysSelect" value=<?php echo $_POST['paysSelect']; ?> />
    <!--CGV-->
    <input type="hidden" name="checkbox_CGV" value="true" />

    <div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

        <div class="row">
            <div id="panier-page-container" class="col-xl-8 col-md-12"><!--Paiement-->
                <p class="fs-4 text text-uppercase">2. PAIEMENT</p>
                
                <div class="accordion" id="accordionExample">
                    <div id="accordion-id" class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                        <div class="form-check m-2 fs-4">
                        <input type="radio" class="form-check-input" id="cbRadio" name="cbRadio" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" checked value="paypal">
                        <label class="form-check-label" for="cbRadio">
                            <img alt="Paypal" src=<?php echo SERVER_URL."/img/paypal.png"?> width="15%" height="auto">
                        </label>
                        </div>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            
                            </div>
                        </div>
                    </div>
                    <div id="accordion-id" class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                        <div class="form-check m-2 fs-4">
                        <input type="radio" class="form-check-input" id="cbRadio" name="cbRadio" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" value="CB">
                        <label class="form-check-label" for="cbRadio">
                            Carte de crédit <img src=<?php echo SERVER_URL."/img/visa.png"?> width="15%" height="auto">
                        </label>
                        </div>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="numCarte" class="form-label">Numéro de carte</label>
                                        <input type="text" class="form-control" name="numCarte" id="numCarte"  placeholder="xxxx-xxxx-xxxx-xxxx">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nomCarte" class="form-label">Nom sur la carte</label>
                                        <input type="text" class="form-control" name="nomCarte" id="nomCarte" placeholder="Nom et prénom">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="cvc" class="form-label">CVC</label>
                                        <input type="text" class="form-control" name="cvc" id="cvc" placeholder="xxx">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="dateCarte" class="form-label">Date d'expiration</label>
                                        <input type="text" class="form-control" name="dateCarte" id="dateCarte" placeholder="00/00">
                                    </div>
                                </div>
                            </div>

                            

                           

                        </div>
                        </div>
                    </div>
                    
                </div>



            </div> <!--Fin Paiement-->
            
            <!-- Info prix -->
            <div id="panier-accepter" class="col-xl-4 col-md-12 d-flex align-items-center justify-content-center">
                <div class="border p-5 rounded">
                    <p class="text-center fs-3 text ">Total :</p>
                    <p class="text-center "><span id="prixTotalPanier" data-total="<?php  echo  $lePanier->GetPrixTotal() + $frais_pays; ?>" class="fs-3 prix text"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetPrixTotal() + $frais_pays) ?> € </span><span class="small fs-6">TTC</span></p>
                    <p class="text-center "><span id="prixTotalPanierHT" data-totalht="<?php  echo  $lePanier->GetPrixTotalHT() + $frais_pays ?>" class="prix-ht"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetPrixTotalHT() + $frais_pays) ?> € HT</span></p>
                    
                    <p class="">TVA : <span id="montantTVA" class="prix-ht"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetMontantTVA()) ?> €</span> <span id="montantTVA" class="prix-ht"> ( 20% )</span></p>
                    <div class="text-center m-2">
                        
                        <button id="BtnValiderPaiement" type="submit" class="btn btn-primary">Valider et payer <i class="fa-regular fa-credit-card"></i></button>
                        
                    </div>
                </div>
            </div> <!-- Fin info prix -->

        
        </div>
    </div>
</form> <!-- Fin formulaire -->
<?php

    require_once("./view/footer/footer.php"); // Footer

?>

</body>

<?php
}
?>