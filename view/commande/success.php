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
                

            <p><?php if(isset($params['erreur_valider'])){echo $params['erreur_valider'];} ?></p>

            </div> <!--Fin Paiement-->
            
            <!-- Info prix -->
            <div id="panier-accepter" class="col-xl-4 col-md-12 d-flex align-items-center justify-content-center">
                
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