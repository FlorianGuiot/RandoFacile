<?php

require_once ROOT."/view/navbar/header.php";

?>

<body>
<div class="container-connexion">
<div class="container p-2">
    <div class="row  mx-auto">
        <div class="col-lg-4 col-md-4 col-sm-4 mx-auto">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mx-auto" style="text-align:center;">

            <?php
                echo '<div class="alert alert-success mx-auto"><h4 class="alert-heading">Bienvenue '. $_SESSION["prenom"].' !</h4><p>Vous etes connecté</p></div>' ;
            ?>

            <img src="./img/loading.gif">

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 mx-auto">
        </div>
    </div>
</div>
</div>
</body>