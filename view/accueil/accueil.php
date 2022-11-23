<body>

    <?php
        require_once("./view/navbar/navbar.php"); // Navbar
    ?>
    <!--Banniere-->


    <div class="banniere-container img-responsive">
    <div class="container">
        <div class="row">
            <div class="col-6">
            </div>
            <div class="col-6">
                <h2 class="slogan">C'EST TOUJOURS MIEUX DE PARTIR BIEN <span class="slogan-vert">ÉQUIPÉ</span></h2>
            </div>
        </div>
    </div>
</div>

    <!--Nos nouveautés-->

<div class="nouveautés-background">
    <p >Nos nouveautés</p>
</div>

<!--Articles ordinateur-->
<div class="container p-2 ">

    <div class="row">

<?php

// Affichage des articles
foreach($lesNouveautés as $unProduit){

?>

        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card text-center mx-auto shadow-lg bg-white rounded card-taille">
                <a href=""><?php echo "<img class='card-img-top' src= '".$unProduit->GetLiensImage()[0]."'>";?></a>
                <div class="card-body">
                    <a href="" class="lien-article"><h5 class="card-title">
                        <?php
                            echo $unProduit->GetLibelle();
                        ?>
                    </h5></a>
                    <p class="card-text">
                        <?php
                            echo $unProduit->GetResume();
                        ?>
                    </p>
                    <p class="categorie">
                        <?php
                            echo $unProduit->GetCategorie()->GetLibelle();
                        ?>
                    </p>
                    <p class="prix">
                    <?php
                            echo $unProduit->GetPrixUnitaire()." €";
                        ?> 
                    </p>
                </div>
            </div>
        </div>
<?php
}
?>
 </div>
</div>

    <!--Tous nos produits-->

<div class="tous-nos-produits-titre">
    <p>Tous nos produits</p>
</div>

<div class="container">

    <div class="row">

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 mx-auto p-2">
            <a href="vente.php?id=5"><img class="w-100 img-fluid" src="/ecommerce/img/sacs-à-dos.jpg"></a>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 mx-auto p-2">
            <a href="vente.php?id=3"><img class="w-100 img-fluid" src="/ecommerce/img/vestes.jpg"></a>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 mx-auto p-2">
            <a href="vente.php?id=4"><img class="w-100 img-fluid" src="/ecommerce/img/chaussures.jpg"></a>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-6 mx-auto p-2">
            <a href="vente.php?id=1"><img class="w-100 img-fluid" src="/ecommerce/img/sacs-de-couchage.jpg"></a>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-6 mx-auto p-2">
            <a href="vente.php?id=2"><img class="w-100 img-fluid" src="/ecommerce/img/tentes.jpg"></a>
        </div>

    </div>
</div>

    <!--Rando facile-->

<div class="info">

    <div class="info-titre">
        <h1>RandoFacile</h1>
    </div>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec efficitur, augue a finibus molestie, nisl odio viverra elit, eget ultricies sapien eros id mi. Maecenas tincidunt mi id velit varius, sit amet lobortis arcu eleifend. Sed suscipit velit vitae vehicula accumsan. Vestibulum imperdiet lectus lectus, nec maximus ante porttitor id. Morbi sed metus eu sapien ultricies molestie non in eros. Cras nisi odio, pharetra sit amet elementum congue, cursus ac ante. Nunc sit amet nunc laoreet, cursus massa non, lacinia nulla. Quisque imperdiet, lectus vitae porttitor efficitur, elit diam finibus nisi, quis lobortis lacus tortor quis nulla. Nam rutrum neque a ultrices tincidunt. Suspendisse potenti. Donec sed placerat orci.

Integer faucibus nec ipsum at lacinia. Mauris metus tortor, fringilla ultrices magna eu, tristique sodales urna. Aenean porttitor tempus lectus, ac vulputate purus ultricies vel. Vestibulum euismod erat eros, non eleifend nunc sollicitudin vel. Nullam posuere elit ut magna euismod, et bibendum ante consectetur. Proin non tincidunt augue. Nulla a nisl varius, dapibus nisi quis, maximus mauris. Aliquam vitae elementum neque. Praesent lacinia, ex et interdum dignissim, lectus elit porttitor nisi, auctor tincidunt lacus nisi eu lacus. Pellentesque lobortis varius urna.</p>

</div>

    <!--Footer-->
    <?php
    require_once("./view/footer/footer.php"); // Footer
    ?>
</body>