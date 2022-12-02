<body>

<?php

    require_once("./view/navbar/navbar.php"); // Navbar

?>

<!--Container-->
<div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

    <div class="row">

        <div class="col-sm-12">
            <div class="d-flex justify-content-center">
                <p class="text-center fs-1 text">Erreur 404</p>
            </div>
        </div>

        <div class="col-sm-12">
            <p class="text-center fs-4 text">Il semblerait que la page recherchée n'existe plus...</p>
        </div>

        <div class="col-sm-12 d-flex justify-content-center m-2">
            <form action="index">
                <button class="btn btn-primary" >Retour à l'accueil</button>
            </form>
        </div>

        <div class="col-sm-12 d-flex justify-content-center">
            <img src="./img/john-travolta-lost.gif">
        </div>

        <div class="col-sm-12 d-flex justify-content-center">
            <img src="./img/obiwan_404.jpg">
        </div>


    </div>

</div><!--Fin Container-->

<?php

    require_once("./view/footer/footer.php"); // footer

?>
</body>