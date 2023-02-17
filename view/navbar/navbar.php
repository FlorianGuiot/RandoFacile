<body onload="init()">


<?php 
/*
    Navbar
    navbar.php

    @Auteur : Florian

*/

require_once("./view/navbar/header.php"); // Header (CSS,Title,js...)
require_once("./view/navbar/modal.php"); // Modal login et register

// Variables

$error = "";

if(isset($_GET['error'])){

    if($_GET['error'] = "login"){

        $error = '<div class="alert alert-danger"> Mot de passe ou email incorrect. </div> </br>';
        
    }
    require_once("openLogin.php");
}

$recherche = '';

?>

<form id="form-search" action="<?php echo SERVER_URL."/index/" ?>" method="GET" class="navbar-container">
<!--Navbar pour ordinateur-->
<div class="">

    <div class="navbackground">

        <div class="logocontainer">
            <div class="logo">
                <a href=<?php echo SERVER_URL."/" ?>><img src=<?php echo SERVER_URL."/img/logo.png"?> width="30%" height="auto"></a>
            </div>
        </div>
        
        <div class="recherche-container">
            <div class="recherche-barre">
                

                    <?php

                        if (isset($_GET['recherche'])){ // Afficher recherche dans la barre.
                            
                            ?>
                                    <input class="search" type="text" name="searchbar" id="searchbar" value="<?php echo $_GET['recherche']; ?>" placeholder="Rechercher parmi tous nos produits">

                            <?php
                        }
                        else{

                            ?>

                                <input class="search" type="text" name="searchbar" id="searchbar" placeholder="Rechercher parmi tous nos produits">

                            <?php
                        }
                    
                    ?>

                <!--Bouton recherche sur téléphone-->
                <div class="search-button-container d-lg-none">
                    <button type="submit" class="search-button" name="searchbutton" id="searchbutton">
                        <a <?php echo "href='".SERVER_URL."/recherche/'".$recherche;?>>
                            <img class="search-button-img" src="img/loupe.png">
                        </a>
                    </button>
                </div>

            </div>
            
        </div>

        <div class="panierlogin">
            
            <!--Bouton recherche sur ordinateur-->
            <div class="search-button-container d-none d-lg-block">
                <button type="submit" class="search-button" name="searchbutton" id="searchbutton">
                    <a <?php echo "href='".SERVER_URL."/recherche/'".$recherche."/";?>>
                        <img class="search-button-img" src=<?php echo SERVER_URL."/img/loupe.png"?>>
                    </a>
                </button>
            </div>
        
            <div class="connexion">

                <div class="login-img-container">

                    <i class="login-img fa-solid fa-user fa-xl "  data-fa-transform="shrink-8 right-6"></i>
                    
                </div>

                <?php
                    if(!isset($_SESSION["iduser"])){
                ?>
                <div class="connexion2">
                    <div>
                        <a href="#connexion" data-toggle="modal">Connexion</a>
                    </div>
                    <div>
                        <a href="#inscription" data-toggle="modal">Inscription</a>
                    </div>

                </div>
                <?php
                }
                else{
                ?>
                <div class="connexion2">
                    <div>
                        <a href="#connexion" data-toggle="modal">Mon espace</a>
                    </div>
                    <div>
                        <a href="#deconnexion" onclick="disconnect()">Déconnexion</a>
                    </div>

                </div>
                <?php
                }
                ?>
            </div>

            <div class="panier-button-container">
                    <div class="dropdown">
                            <button type="button" id="dropdownMenuPanier" class="panier-button dropdown-toggle" style="color:white;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="panier-button-img" src=<?php echo SERVER_URL."/img/panier.png"?>>
                                <p  id="panierUtilisateurNb" class="panier-texte-nombre <?php echo $_SESSION['panier_nbArticlesVisible'] ?> "><?php echo $_SESSION['panier_nbArticles'];?></p>
                            </button>

                            <div id="panierUtilisateur" class="dropdown-menu" aria-labelledby="dropdownMenuPanier">
                                <?php
                                    echo $_SESSION['panier_liste'];
                                ?>
                            </div>

                    </div>
            </div>
            </div>
        
    </div>
</div>
</form>


<nav class="navbar navbar-expand-lg navbar-dark navbackground2">

    <!--Bouton téléphone-->

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

        <ul class="navbar-nav mx-auto">

            <li class="nav-item">
                <a class="nav-link px-5" href=<?php echo SERVER_URL."/recherche/categorie/4/" ?>>Chaussures</a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-5" href=<?php echo SERVER_URL."/recherche/categorie/3/" ?>>Vestes</a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-5 " href=<?php echo SERVER_URL."/recherche/categorie/5/" ?>>Sacs à dos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-5 " href=<?php echo SERVER_URL."/recherche/categorie/1/" ?>>Sacs de couchage</a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-5 " href=<?php echo SERVER_URL."/recherche/categorie/2/" ?>>Tentes</a>
            </li>

        </ul>
    </div>
</nav>
</body>
