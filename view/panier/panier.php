<body>

<?php

    require_once("./view/navbar/navbar.php"); // Navbar

?>

<div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

    <div class="row">
        <div id="panier-page-container" class="col-xl-8 col-md-12 panier-page-container">
            <?php
            foreach($lePanierListe as $unP): echo


                
                '<div data-id="'.$unP["produit"]->GetId().'" class="panierProduit shadow p-1 mb-4">'.
                    '<div class="row">'.
                        '<div class="col-xl-2 col-sm-12">'.
                            '<a href="'.$unP["produit"]->GetLienProduit().'" ><img height="100" src="'.$unP["produit"]->GetLiensImage()[0].'"></a>'.
                        '</div>'.
                        '<div class="col-10">'.
                            '<div class="col-12">'.
                                '<a href="'.$unP["produit"]->GetLienProduit().'" class="lien"><p class="fs-4">'.$unP["produit"]->GetLibelle().'</p></a>'.
                            '</div>'.
                            '<div class="col-12">'.
                                '<div class="row">'.
                                    '<div class="col-xl-2 col-sm-4">'.
                                        '<input  id="qteProduitLignePanier" type="number"  class="form-control qteProduitLignePanier" value="'.$unP['qte'].'" max="'.$unP['produit']->GetQteEnStock().'" min="1">'.
                                    '</div>'.
                                    '<div class="col-xl-9 col-sm-8">'.
                                        '<button id="BtnRemoveLignePanier" class="btn btn-danger BtnRemoveLignePanier"><i class="fa-solid fa-trash"></i></button>   '.
                                    '</div>'.
                                    '<div class="col-xl-12 col-sm-12">'.
                                        '<p>'.$unP['produit']->CalculerMontant($unP['qte']).'€ TTC </p>'.
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>';

            


            endforeach;
            ?>
        </div>
    </div>
</div>
<?php

    require_once("./view/footer/footer.php"); // Footer

?>

</body>