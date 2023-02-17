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
        <div class="mt-2">
        <a id="BtnRetourAdresse" href=<?php echo SERVER_URL."/panier/"?> class="btn btn-primary"><i class="fa-solid fa-backward"></i> Retour</a>
        </div>
</div>

<!--Formulaire adresse-->
<form id="form-adresse" action=<?php echo SERVER_URL."/commande/paiement/"?> method="POST">
<div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

    <div class="row">
        <div id="panier-page-container" class="col-xl-8 col-md-12"><!--Adresse-->
            <p class="fs-4 text text-uppercase">1. Adresse de livraison</p>



                <div class="row">

                    <div class="col-6">
                        <!--Prenom-->
                        <div class="mb-3">
                            <div class="form-group pb-1 pt-2">
                                <label for="prenom">Prénom du destinataire</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" aria-describedby="prenomHelp"  value="<?php echo $user->GetPrenom()?>" placeholder="Prénom">
                                <small id="prenomHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>


                    <div class="col-6">
                        <!--Nom-->
                        <div class="mb-3">
                            <div class="form-group pb-1 pt-2">
                                <label for="nom">Nom du destinataire</label>
                                <input type="text" class="form-control" id="nom" name="nom" aria-describedby="nomHelp" value="<?php echo $user->GetNom()?>"  placeholder="Nom">
                                <small id="nomHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-6">
                        <!--Adresse-->
                        <div class="mb-3">
                            <div class="form-group pb-1 pt-2">
                                <label for="adresse">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" aria-describedby="adresseHelp"  placeholder="Adresse">
                                <small id="adresseHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-6">
                        <!--Ville-->
                        <div class="mb-3">
                            <div class="form-group pb-1 pt-2">
                                <label for="ville">Ville</label>
                                <input type="text" class="form-control" id="ville" name="ville" aria-describedby="villeHelp"  placeholder="ville">
                                <small id="villeHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <!--CP-->
                        <div class="mb-3">
                            <div class="form-group pb-1 pt-2">
                                <label for="CP">Code postal</label>
                                <input type="text" class="form-control" id="CP" name="CP" aria-describedby="cpHelp" maxlength="5" placeholder="Code postal">
                                <small id="cpHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>

                    <!--CGV-->
                    <input type="hidden" name="checkbox_CGV" value="true" />

                </div>



                <div class="row">

                    <div class="col-6">
                        <!--Pays-->
                        <div class="mb-3">
                            <label for="paysSelect" class="form-label">Pays</label>
                            <select id="paysSelect" name="paysSelect" class="form-select">
                                <?php 
                                for($i = 0; $i <= count($lesPays) - 1; $i++){

                                    $option = "<option ";

                                    if($i == 0){

                                        $option .= "selected ";
                                    
                                    }

                                    echo $option." data-frais='".$lesPays[$i]->GetFrais()."' value='".$lesPays[$i]->GetId()."'>".$lesPays[$i]->GetLibelle()."</option>";
                                
                                }
                                ?>
                                
                            </select>
                            <small id="paysHelp" class="form-text text-muted"><?php echo $frais_pays ?></small>
                        </div>
                    </div>

                </div>


        </div> <!--Fin detail panier-->
        
        <div id="panier-accepter" class="col-xl-4 col-md-12 d-flex align-items-center justify-content-center">
            <div class="border p-5 rounded">
                <p class="text-center fs-3 text ">Total :</p>
                <p class="text-center "><span id="prixTotalPanier" data-total="<?php  echo  $lePanier->GetPrixTotal(); ?>" class="fs-3 prix text"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetPrixTotal()) ?> € </span><span class="small fs-6">TTC</span></p>
                <p class="text-center "><span id="prixTotalPanierHT" data-totalht="<?php  echo  $lePanier->GetPrixTotalHT() ?>" class="prix-ht"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetPrixTotalHT()) ?> € HT</span></p>
                
                <p class="">TVA : <span id="montantTVA" class="prix-ht"><?php  echo  NombreFormatter::GetNombreFormatFr($lePanier->GetMontantTVA()) ?> €</span> <span id="montantTVA" class="prix-ht"> ( 20% )</span></p>
                <div class="text-center m-2">
                    <button id="BtnValiderAdresse" type="submit" class="btn  btn-primary">Suivant <i class="fa-solid fa-forward"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>


<div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

    <div class="row">
        <div id="" class="col-xl-12"><!--Info Livraison-->
            <p class="fs-4 text text-uppercase">Livraison rapide</p>

            <div class="row w-100">
                <div class="col-6 d-flex justify-content-center">
                    <div class="d-flex align-items-center flex-column">
                        <img src=<?php echo SERVER_URL."/img/france.png"?> width="30%" height="auto">
                        <p>Livré sous 7 jours en france métropolitaine.</p>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <div class="d-flex align-items-center flex-column">
                        <img src=<?php echo SERVER_URL."/img/europe.png"?> width="30%" height="auto">
                        <p>Livré sous 15 jours en Europe.</p>
                    </div>
                </div>
            </div>

        </div> <!--Fin Info Livraison-->
        
    </div>

</div>
<?php

    require_once("./view/footer/footer.php"); // Footer

?>

</body>

<?php
}
?>