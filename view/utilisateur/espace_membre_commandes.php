<?php
use Date\Utils;
use Date\Utils\DateFormatter;
use Number\Utils\NombreFormatter;

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


<div class="container-xl min-vh-100">

    <div class="row">

        <?php

        require_once("./view/navbar/navbar_user.php"); // Navbar menu utilisateur

        ?>
        <div class="col-8 mt-5 offset-1">

            <p class="fs-3 mb-3">Mes commandes</p>

            <div class="shadow mb-5 bg-body rounded p-3 panier-page-container">
                
            <?php
                if($nbCommandes > 0){

                    foreach($lesCommandes as $uneCommande):

                        $lePanier = $uneCommande->GetDetailsCommande()->GetPanier();
                        $leStatut = $uneCommande->GetLeStatut();
                        $dateFormatter = new DateFormatter($uneCommande->GetDate());
                        $date = $dateFormatter->GetDateEcrite();

                        echo

                        '<div class="panierProduit shadow p-1 mb-4">'.
                        '<div class="row">'.
                            '<div class="col-xl-2 col-sm-12">'.
                                '<a href="" ><img height="100" src="'.$lePanier[0]["produit"]->GetLiensImage()[0].'"></a>'.
                            '</div>'.
                            '<div class="col-10">'.
                                '<div class="col-6">'.
                                    '<a href="'.SERVER_URL.'/membre/commande/'.$uneCommande->GetId().'/" class="lien"><p class="fs-4">'.$date.'</p></a>'.
                                '</div>'.
                                '<div class="col-6">'.
                                    '<p class="fs-7">'.NombreFormatter::GetNombreFormatFr($uneCommande->GetDetailsCommande()->GetPrixTotal() + $uneCommande->GetPays()->GetFrais()).' €</p>'.
                                '</div>'.
                                '<div class="col-12">'.
                                    '<div class="row">'.
                                        '<div class="col-xl-12 col-sm-12 d-flex align-items-center">'.
                                            '<p>'.$leStatut['statut']->GetLibelle().'</p>'.
                                        '</div>'.
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '</div>'.
                        '</div>';

                    endforeach;
                }else{

                    echo "<p> Vous n'avez passé aucune commande pour l'instant. </p>";

                }


            ?>
                

            </div>

            <div class="container">
                <div class="row mx-auto">
                    <div class="col-lg-12">
                        <nav aria-label="Navigation de page">
                        <ul class="pagination justify-content-center">

                            <?php


                            //Nombre de page totale.
                            $nombreDePage = ceil($nbCommandes / LIMIT_COMMANDES);
                            
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
                                <a class="page-link" href="<?php echo $lienPage.'/p/'.($params['numPage']-1)."/"?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                                </li>
                            
                                <?php
                                }

                                // Si il reste des pages avant la page précedente masquer les pages qui se trouve entre.
                                if (($page_precedente - $pageVisibleAvantApres) >=0) {

                                    ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo $lienPage.'/p/1/'?>">1</a>
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
                                            <a class="page-link" href="<?php echo $lienPage.'/p/'.($i)."/"?>"><?php echo ($i) ?></a>
                                        </li>
                                    
                                    <?php
                                    }
                                    else{
                                        ?>
                                            <li class="page-item active"><a class="page-link" href="<?php echo $lienPage.'/p/'.$i.'/' ?>"><?php echo $i ?></a></li>
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
                                        <a class="page-link" href="<?php echo $lienPage.'/p/'.$nombreDePage.'/'?>"><?php echo ($nombreDePage) ?></a>
                                    </li>
                                
                                    <?php
                                    }

                                if($params['numPage'] < ($nombreDePage)){ // Afficher la page suivante que en dehors de la dernière page.
                                    ?>

                                    <li class="page-item">
                                    <a class="page-link" href="<?php echo $lienPage.'/p/'.($params['numPage']+1).'/'?>" aria-label="Next">
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

</div>
<?php

    require_once("./view/footer/footer.php"); // Footer

?>

</body>

<?php
}
?>