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

    
    $nbrLignes = 0;

    if(isset($_COOKIE['panier'])){

        $nbrLignes = count($_COOKIE['panier']);

    }

    $lignePanier = [
                        'produit' => 1,
                        'qte' => 12

                    ];

    $lignePanier = json_encode($lignePanier);
    setcookie("panier[".$nbrLignes."]",$lignePanier);
    
    var_dump($_COOKIE);

    //Supprimer
    foreach($_COOKIE['panier'] as $name => $value){
        
        $ligne = json_decode($value, true);
        if($ligne['produit'] == 1){
            unset($_COOKIE['panier'][$name]);
        }
    }

    //Afficher le produit
    foreach($_COOKIE['panier'] as $value){
        
        $ligne = json_decode($value, true);
        var_dump($ligne);
        echo  $ligne['produit'];
        // $result = (string)$ligne['qte'];
        // echo $result;
    }

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