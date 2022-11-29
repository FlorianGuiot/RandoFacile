<?php
    /**
     * Charge les class
     */

    require_once __DIR__.'/autoload.php';
    require_once  __DIR__.'/controller/PanierController.php';


    

     
    //Inscrit l'utilisateur
    // $params['nom'] = 'f';
    // $params['prenom'] = 'test';
    // $params['dateNaissance'] = '2022-08-22';
    // $params['dateNaissance'] = '2022-08-22';
    // $params['email'] = "fdfd";
    // $params['password'] = "d";

    // $add = LoginController::CreateNewUser($params);
    

    // $panier = PanierManager::GetPanierById(59);

    // foreach($panier as $unP){
    //     echo $unP['produit']->GetLibelle();
    //     echo $unP['qte'];
    // }

    
    // //Ajouter un produit au panier
    // $nbrLignes = 0;

    // if(isset($_COOKIE['panier'])){

    //     $nbrLignes = count($_COOKIE['panier']) + 1;

    // }

    // echo count($_COOKIE['panier']);

    // $lignePanier = [
    //                     'idProduit' => 2,
    //                     'qte' => 12

    //                 ];

    // $lignePanier = json_encode($lignePanier);
    // setcookie("panier[".$nbrLignes."]",$lignePanier,time() + (86400 * 15), "/"); //Cookies valable 15 jours.
    
    // var_dump($_COOKIE);

    // //Supprimer un produit du panier
    // if(isset($_COOKIE['panier'])){

    //     foreach($_COOKIE['panier'] as $name => $value){
        
    //         $ligne = json_decode($value, true);
    //         if(isset($ligne['idProduit'] )){
    //             if($ligne['idProduit'] == 1){
                    
    //                 setcookie('panier['.$name.']', false, time() - 3600, '/');
    //                 unset($_COOKIE['panier'][$name]);
        
    //             }
    //         }

    //         if(isset($ligne['produit'] )){
    //             if($ligne['produit'] == 1){
                    
    //                 setcookie('panier['.$name.']', false, time() - 3600, '/'); //
    //                 unset($_COOKIE['panier'][$name]);
        
    //             }
    //         }
    //     }
    

    // }
    
    // //Afficher le produit
    // foreach($_COOKIE['panier'] as $value){
        
    //     $ligne = json_decode($value, true);
    //     var_dump($ligne);
    //     echo  $ligne['produit'];
    //     // $result = (string)$ligne['qte'];
    //     // echo $result;
    // }

    var_dump($_COOKIE);
    
    $lePanier = PanierController::GetPanier();

    var_dump($lePanier);
    
    $leProduit = ProduitsManager::getProduitParId(1);
    $leProduit2 = ProduitsManager::getProduitParId(2);
    $lePanier->AddProduit($leProduit,1,time());
    $lePanier->AddProduit($leProduit2,1,time());
    $lePanier->RemoveProduit($leProduit);

    var_dump($lePanier);

    var_dump($_COOKIE);
?>



<form id="form-connexion"  method="POST" action="index.php?controller=Login&action=connexion">
          <div class="form-group">
                          
              <label for="email">Adresse email</label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="CemailHelp" placeholder="Adresse email">
              <small id="CemailHelp" class="form-text text-muted"></small>
      
          </div>
          <div class="form-group pt-2 pb-4">
      
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control" id="password" name="password" aria-describedby="CmdpHelp" placeholder="Mot de passe">
              <small id="CmdpHelp" class="form-text text-muted"></small>
                  
          </div>
          <button type="submit" name="bouton-connexion" id="bouton-connexion" value="connexion" onclick="validationConnexion()" class="btn btn-primary" >Connexion</button>
        </form>