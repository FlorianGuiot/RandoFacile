<?php
require_once("./view/navbar/navbar.php"); // Navbar

?>

<div class="container p-2">

    <div class="row  mx-auto">

    <div class="tous-nos-produits-titre">
        <p >Nos produits correspondant à votre recherche</p>
    </div>
<?php

if(count($lesProduits) < 1){

    echo "</div class='mx-auto text-center'>Malheureusement aucun produit ne correspond à votre recherche ... </div>";

}else{

    foreach($lesProduits as $unProduit){

        // Lien du produit
        $lienProduit = "./index?controller=Produit&action=read&idProduit=".$unProduit->GetId(); 

        if(!isset($params['recherche'])){

            $lienProduit = $lienProduit."&idCateg=".$unProduit->GetCategorie()->GetId();

        }
        else{

            $lienProduit = $lienProduit."&recherche=".$params['recherche'];
            
        }
?>

        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 pb-2">
            <div class="card text-center mx-auto shadow-lg bg-white rounded">
                <a href="<?php echo $lienProduit ?>"><?php echo "<img class='card-img-top' src= '".$unProduit->GetLiensImage()[0]."'>";?></a>
                <div class="card-body">
                    <a href="<?php echo $lienProduit ?>" class="lien-article"><h5 class="card-title">
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
}

?>

<div class="container">
            <div class="row mx-auto">
                <div class="col-lg-12">
                    <nav aria-label="Navigation de page">
                    <ul class="pagination justify-content-center">

                        <?php


                        //Nombre de page totale.
                        $nombreDePage = ceil($nbrResultatsRecherche / LIMIT_PRODUITS);
                        
                        //Nombre de page affichées au total dans la barre.
                        $pageVisible = 5;

                        //Nombre de page avant et après la page actuelle dans la barre.
                        $pageVisibleAvantApres = 2;

                        $page_precedente = 1; // Par défaut la page précedente est la page 1.
                        $page_suivante = $nombreDePage; // Par défaut équivalant au nombre de page total.

                        if($nombreDePage > 1){

                            
                            // Si il y a plus de page que la limite visible.
                            if($nombreDePage > $pageVisible){

                                if(($params['numPage'] - $pageVisibleAvantApres) > 1){
                                    $page_precedente = $params['numPage'] - $pageVisibleAvantApres;
                                }

                                if(($params['numPage'] + $pageVisibleAvantApres) < $nombreDePage){
                                    $page_suivante = $params['numPage'] + $pageVisibleAvantApres;
                                }
                            }


                            if($params['numPage'] > 1){ // Afficher la page précedente que en dehors de la page 1.
                            ?>

                            <li class="page-item">
                            <a class="page-link" href="<?php echo $lienPage.'&numPage='.($params['numPage']-1)?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                            </li>
                        
                            <?php
                            }

                            // Si il reste des pages avant la page précedente masquer les pages qui se trouve entre.
                            if (($page_precedente - $pageVisibleAvantApres) >=0) {

                                ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $lienPage.'&numPage=1'?>">1</a>
                                </li>
                                <li class="page-item">
                                    <span class="page-link">...</span>
                                </li>
                            
                                <?php
                            }
                            
                            for($i = $page_precedente; $i <= $page_suivante ; $i++){
    
                                if($i != $params['numPage']){
                                    ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo $lienPage.'&numPage='.($i)?>"><?php echo ($i) ?></a>
                                    </li>
                                
                                <?php
                                }
                                else{
                                    ?>
                                        <li class="page-item active"><a class="page-link" href="<?php echo $lienPage.'&numPage='.$i ?>"><?php echo $i ?></a></li>
                                    <?php
                                }


                            }
                            // Si il reste des pages après la page suivante masquer les pages qui se trouve entre.
                            if ($page_suivante != $nombreDePage) {

                                ?>
                                <li class="page-item">
                                    <span class="page-link">...</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $lienPage.'&numPage='.$nombreDePage?>"><?php echo ($nombreDePage) ?></a>
                                </li>
                            
                                <?php
                                }

                            if($params['numPage'] < ($nombreDePage)){ // Afficher la page suivante que en dehors de la dernière page.
                                ?>

                                <li class="page-item">
                                <a class="page-link" href="<?php echo $lienPage.'&numPage='.($params['numPage']+1)?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                </a>
                                </li>
                            
                                <?php
                            }
                        }
                        ?>
                        

                    </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>
<!--Footer-->
<?php
    require_once("./view/footer/footer.php"); // Footer
?>