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

<div class="container-xl h-100">






    <div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

        <div class="row">
            <div id="panier-page-container" class="col-xl-12 col-md-12"><!--Paiement-->
                

                <div class="col-sm-12">
                    <div class="d-flex justify-content-center">
                        <p class="text-center fs-1 text">Merci de votre achat !</p>
                    </div>
                </div>

                <div class="col-sm-12">
                    <p class="text-center fs-5 text">Vous allez bientôt recevoir un email contenant le detail de votre commande à l'adresse <strong><?php echo $params['user_email']; ?></strong>.</p>
                </div>

                <div class="col-sm-12 d-flex justify-content-center">
                    <form action=<?php echo SERVER_URL."/membre/"?>>
                        <button class="btn btn-primary" >Suivre ma commande</button>
                    </form>
                </div>

                <a href=<?php echo SERVER_URL."/"?> class="lien d-flex justify-content-center">Retour à l'accueil</a>

            
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