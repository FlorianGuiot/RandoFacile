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

<form id="form-search" action="" method="GET" class="navbar-container">
<!--Navbar pour ordinateur-->
<div class="d-none d-lg-block">

    <div class="navbackground">

        <div class="logocontainer">
            <div class="logo">
                <a href="index"><img src="./img/logo.png" width="30%" height="auto"></a>
            </div>
        </div>
        
        <div class="recherche-container">
            

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

            
            
        </div>

        <div class="panierlogin">
            
        <div class="search-button-container">
                    <button type="submit" class="search-button" name="searchbutton" id="searchbutton">
                        <a <?php echo "href='index.php?controller=Recherche&action=read&recherche='".$recherche;?>>
                            <img class="search-button-img" src="img/loupe.png">
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
                                <img class="panier-button-img" src="img/panier.png">
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

<!--Navbar pour téléphone-->
<div class="d-lg-none">

    <div class="navbackgroundtel">

        <div class="logotel mx-auto">

            <a href="index.php"><img class="p-2" src="img/logo.png" height="80"></a>

        </div>

        <div class="recherchetel mx-auto">

            <div class="vide-container-tel">
            </div>

            <div class="search-container-tel">
                <input class="searchtel"  type="text" placeholder="Recherchez parmi tous nos produits">
            </div>

            <div class="panier-search-container-tel">
                
                <div class="search-button-container-tel">
                    <button class="search-button">
                        <img class="search-button-img" src="img/loupe.png">
                    </button>
                </div>

                <div class="panier-button-container-tel">
                    <div class="dropdown dropdown-toggle">
                            <button class="panier-button">
                                <img class="panier-button-img" src="img/panier.png">
                            </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="panierlogintel">
        <?php
            if(!isset($_SESSION["prenom"])){
        ?>
            <a href="#connexion" data-toggle="modal">Connexion</a>
            <p class="px-2"> | </p>
            <a href="#inscription">Inscription</a>
        <?php
            }
            else{
        ?>
            <a href="#connexion" data-toggle="modal">Mon espace</a>
            <p class="px-2"> | </p>
            <a href="index.php?controller=Login&action=disconnect&retour=<?php echo $params['page_name']?>">Déconnexion</a>
        <?php
            }
        ?>
        </div>
        
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark navbackground2">

    <!--Bouton téléphone-->

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

        <ul class="navbar-nav mx-auto">

            <li class="nav-item">
                <a class="nav-link px-5" href="index.php?controller=Recherche&action=read&idCateg=4">Chaussures</a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-5" href="index.php?controller=Recherche&action=read&idCateg=3">Vestes</a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-5 " href="index.php?controller=Recherche&action=read&idCateg=5">Sacs à dos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-5 " href="index.php?controller=Recherche&action=read&idCateg=1">Sacs de couchage</a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-5 " href="index.php?controller=Recherche&action=read&idCateg=2">Tentes</a>
            </li>

        </ul>
    </div>
</nav>
</body>
