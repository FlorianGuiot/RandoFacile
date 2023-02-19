<?php


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


<div class="container-xl min-vh-75">

    <div class="row">
        <?php

            require_once("./view/navbar/navbar_user.php"); // Navbar menu utilisateur

        ?>
        <div class="col-xl-8  mt-5 offset-xl-1">

            <p class="fs-3 mb-3">Mon compte</p>

            <div class="shadow mb-5 bg-body rounded p-3 ">
                
                <p class="fs-5 mb-3">Mes informations</p>

                <div class="row">

                    <div class="col-xl-3 col-md-6">
                        <p>Prénom</p>
                        <p class="important"><?php echo $user->GetPrenom(); ?></p>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <p>Nom</p>
                        <p class="important"><?php echo $user->GetNom(); ?></p>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <p>Adresse email</p>
                        <p class="important"><?php echo $user->GetEmail(); ?></p>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <p>Date de naissance</p>
                        <p class="important"><?php if($user->GetDateNaissance() != null){echo date_format($user->GetDateNaissance(), "d/m/Y");}else{echo "Non renseigné";} ?></p>
                    </div>

                </div>

                <div class="d-flex justify-content-center mt-3">

                    <a href=<?php echo SERVER_URL."/membre/modifier/informations/"?> class="btn btn-primary">Modifier</a>

                </div>


                

            </div>

            <div class="shadow mb-5 bg-body rounded p-3 ">
                
                <p class="fs-5 mb-3">Mot de passe</p>

                <div class="row">

                    <div class="col-3">
                        <p>Mot de passe</p>
                        <p class="important">******</p>
                    </div>

                </div>

                <div class="d-flex justify-content-center mt-3">

                    <a href=<?php echo SERVER_URL."/membre/modifier/securite/"?> class="btn btn-primary">Modifier</a>

                </div>


                

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