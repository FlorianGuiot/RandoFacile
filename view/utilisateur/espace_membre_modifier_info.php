<?php


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

        <div class="col-3 mt-5">
            <a href=<?php echo SERVER_URL."/membre/"?> class="btn btn-primary"><i class="fa-solid fa-backward"></i> Retour</a>
        </div>
        
        <div class="col-8 mt-5 offset-1">

            <p class="fs-3 mb-3">Mes informations</p>

            <div class="shadow mb-5 bg-body rounded p-3 ">
                
                <p class="fs-5 mb-3">Mes informations</p>

                <form id="form-inscription" action=<?php echo SERVER_URL."/login/modifier/"?> method="POST">


                    <div id='message_erreur_inscription' class="mx-auto text-danger text-center m-2"><?php if(isset($params['erreur'])){ echo $params['erreur'];}?></div>


                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group pb-1 pt-2">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $user->GetNom(); ?>" aria-describedby="nomHelp"  placeholder="nom">
                                    <small id="nomHelp" class="form-text text-muted"></small>
                            
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group pb-1 pt-2">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $user->GetPrenom(); ?>" aria-describedby="prenomHelp"  placeholder="Prénom">
                                    <small id="prenomHelp" class="form-text text-muted"></small>
                            
                            </div>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group pb-1 pt-2">
                                    <label for="dateNaissance">Date de naissance</label>
                                    <input type="date" value="<?php if($user->GetDateNaissance() != null){echo date_format($user->GetDateNaissance(), "Y-m-d");} ?>" class="form-control" id="dateNaissance" name="dateNaissance" aria-describedby="dateHelp">
                                    <small id="dateHelp" class="form-text text-muted"></small>
                            
                            </div>
                        </div>
                    </div>

                    <div class="form-group pb-1 pt-2">

                            <label for="email">Adresse email</label>
                            <input type="email" class="form-control" id="emailIn" name="email" aria-describedby="IemailHelp" value="<?php echo $user->GetEmail(); ?>" placeholder="Adresse email" >
                            <small id="IemailHelp" class="form-text text-muted"></small>
                    
                    </div>

                    <button type="submit" name="bouton-inscription" id="bouton-inscription" value="bouton-inscription" class="btn btn-primary mt-3" >Modifier</button>

                </form>


                

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