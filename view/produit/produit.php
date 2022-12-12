<body>

<?php
use Number\Utils;
use Number\Utils\NombreFormatter;

    require_once("./view/navbar/navbar.php"); // Navbar

//Si le produit existe, affiche le produit
if($page['produitExiste'] == true){
?>

<!--Id Produit pour le Javascript-->
<Produit
  id="info-Produit"
  data-id=<?= $produit->GetId() ?>>
</Produit>


<div class="container-xl mt-2">

    <div class="row">

        <div class="col-12">

            <?php echo $page['lienRetour']; ?>
            
        </div>
        
    </div>

</div>


<!--Container-->
<div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

    <div class="row">

        <div class="col-sm-6 col-md-4  col-lg-3 order-lg-1 order-md-2">

            <!--Image principale-->
            <div class="row d-flex justify-content-center">
                <img href='#' onclick='openImg("<?php echo $produit->GetLiensImage()[0]."\",\"".$produit->GetLibelle(); ?>")' class='img-fluid img-thumbnail produitImage' src="<?php echo $produit->GetLiensImage()[0] ?>">
            </div>
            
            <!--Images secondaires-->
            <div class="row mt-3">
                <?php echo $page['images'];?>
            </div>
            
        </div>


        <div class="col-sm-9 col-sm-8  col-lg-9 order-lg-2 order-md-1">

            <div class="row">
                <div class="col-6">
                    <h3 class="fs-3 text"><?php echo $produit->GetLibelle() ?></h3>
                </div>
                <div class="col-6">
                    <p><?php echo '<span class="rating_checked">'.$produit->GetNoteMoyenne().' </span>' . '<span class="fa fa-star rating_checked"></span> <span class="nbComments">(' . $produit->GetNbrNotes() .'<span class="fa fa-star"></span>, '. count($produit->GetLesCommentaires()) .'<span class="fa fa-message"></span> )</span>' ?></p>
                </div>
            </div>

            <div class="row">
                <p class="fs-6 text"><?php echo $produit->GetCategorie()->GetLibelle() ?></p>
            </div>

            <div class="row">
                <p class="fs-3 text">Description</p>
            </div>

            
            <div class="row">

                <!--Affichage mobile-->
                <div class="accordion d-lg-none m-2" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Description
                        </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="fs-6 text"><?php echo $produit->GetDescription() ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Affichage ordinateur-->
                <div class="col-9">
                    <p class="fs-6 text-justifie text d-none d-none d-lg-block"><?php echo $produit->GetDescription() ?></p>
                </div>
                
                <div class="col-lg-3 col-md-6 order-lg-3 order-md-2">

                    <div class="border text-center">
                        <p class="fs-3 text"><?php echo NombreFormatter::GetNombreFormatFr($produit->GetPrixUnitaire())."€" ?></p>
                        <p class="text"><?php echo $produit->GetAffichageStock() ?></p>
                        <?php if($produit->EstEnStock() != -1){

                            echo '<form id="AjouterPanier">'.
                            '<div class="row mb-3 d-flex justify-content-center">'.
                            '<label for="inputEmail3" class="col-5 col-form-label">Quantité </label>'.
                            '<div class="col-4">'.
                            '<input type="number" id="qteProduit" class="form-control" value="1" max="'.$produit->GetQteEnStock().'" min="1">'.
                            '</div>'.
                            '<small id="qteHelp" class="form-text text-muted"></small>'.
                            '</div>'.
                            '<button id="BtnAjouterPanier" type="submit" class="btn btn-primary">Ajouter au panier</button>'.
                            '</form>';

                        } ?>

                        <a id="BtnRemovePanier" href="" class="BtnRemovePanier linkRemove <?php  if($lePanier->EstDansLePanier($produit)){echo "";}else{ echo "d-none"; } ?>">Retirer l'article du panier</a>
                    </div>
                    
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-9">
            <!--Commentaires-->
            <div class="row">
                <p id="avis" class="fs-3 text">Commentaires</p>
            </div>
            <?php

            //Post commentaire

            if(!isset($_SESSION["iduser"])){

                ?>

                <div class="commentaireBody">
                    <p> <a href="#connexion" data-toggle="modal">Connectez-vous</a> pour laisser un avis. </p>
                </div>

                <?php

            }else{
                ?>
                
                <form id="form-commentaire" action="" >
                    <div class="form-group">
                        <div class="m-2 rating">
                            <span id="rate1" value="1" class="fa fa-star rating_unchecked"></span>
                            <span id="rate2" value="2" class="fa fa-star rating_unchecked"></span>
                            <span id="rate3" value="3" class="fa fa-star rating_unchecked"></span>
                            <span id="rate4" value="4" class="fa fa-star rating_unchecked"></span>
                            <span id="rate5" value="5" class="fa fa-star rating_unchecked"></span>
                        </div>
                        <!--Commentaire-->
                        <div class="m-2">
                            <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                        </div>
                        <small id="CommentaireHelp" class="form-text text-muted"></small>
                        <!--Bouton poster-->
                        <div class="commentaireBoutonContainer">
                            <button class="btn btn-primary" type="submit" name="bouton-commentaire" id="bouton-commentaire" value="poster" >Poster</button>
                        </div>
                    </div>
                </form>
                <?php

            }

            //Affichage des commentaires
            if(count($produit->GetLesCommentaires()) < 1){

                echo "<p>Aucun avis sur cet article.</p>";

            }
            else{

                echo "<p>".count($produit->GetLesCommentaires())." avis sur cet article.</p>";


                for($i = 0; $i <= $params['limiteCommentaires']; $i++){

                    ?>
                    <!--Commentaire-->
                    <div class="commentaire" id="<?php echo $produit->GetLesCommentaires()[$i]->GetId(); ?>">

                        <!--Header-->
                        <div class="commentaireHeader">
                            <p class="pseudo"> <?php echo $produit->GetLesCommentaires()[$i]->GetUser()->GetPrenom(); ?></p>
                            <div>
                                <?php echo $produit->GetLesCommentaires()[$i]->AffichageNote(); ?>
                            </div>
                            <p class="date"> <?php echo $produit->GetLesCommentaires()[$i]->GetDateFormatee()." à ".$produit->GetLesCommentaires()[$i]->GetDateFormateeHeures() ?></p>
                        </div>
                        <!--Body-->
                        <div id="commentaireBody" class="commentaireBody">
                            <p> <?php echo $produit->GetLesCommentaires()[$i]->GetCommentaire();?></p>
                        </div>
                        <!--Footer-->
                        <div class="commentaireFooter">
                            <div class="row">
                                <div class="col-4">
                                    <?php 
                                        if( $produit->GetLesCommentaires()[$i]->EstModifiable()){ echo "<a class='mx-2 editButton' href='#'><i class='fa-solid fa-pen'></i> Modifier</a>";}
                                    ?>
                                </div>
                                <div class="col-4">
                                    <?php
                                        if( $produit->GetLesCommentaires()[$i]->EstModifiable()){ echo "<a class='deleteButton' href='#'><i class='fa-solid fa-trash'></i> Supprimer</a>"; }
                                    ?>
                                </div>
                                <div class="col-4 d-flex justify-content-end">
                                    <?php
                                        if($produit->GetLesCommentaires()[$i]->GetDateLastModification() != null){echo '<p class="date">'.$produit->GetLesCommentaires()[$i]->GetDateLastModificationString().'</p>';};
                                    ?>
                                </div>
                            </div>

                        </div>

                    </div>
                    
                    <?php

                }

                // Bouton afficher plus
                if((count($produit->GetLesCommentaires()) - 1) > ($params['limiteCommentaires'])) {
                                                
                    echo "<div class='afficherPlus'><a href='index.php?controller=produit&action=read&idCateg=".$params["idCateg"]."&idProduit=".$params['idProduit']."&limiteCommentaires=".$params['limiteCommentaires']."#avis'>Afficher plus</a></div>";

                }
            }
            
            ?>
                </div>
            </div>
        

        </div>

        

    </div>

</div><!--Fin Container-->








<?php
//Fin page produit, début erreur
}else{

?>

<!--Container-->
<div class="container-xl shadow p-3 mb-5 bg-body rounded mt-2">

    <div class="row">

        <div class="col-sm-12">
            <div class="d-flex justify-content-center">
                <i class="fa-solid fa-circle-exclamation fa-2xl m-5"></i>
            </div>
        </div>

        <div class="col-sm-12">
            <p class="text-center fs-4 text">Il semblerait que le produit recherché n'existe plus...</p>
        </div>

        <div class="col-sm-12 d-flex justify-content-center">
            <form action="index">
                <button class="btn btn-primary" >Retour à l'accueil</button>
            </form>
        </div>

    </div>

</div><!--Fin Container-->


<?php
    
}
//Fin erreur


    require_once("./view/footer/footer.php"); // footer

?>


</body>