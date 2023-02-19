<?php


//Si utilisateur déconnecté
if(!isset($_SESSION['iduser'])){

    header("Location: 404.php");
    exit;

}else{
?>

<body onload="initModifPassword()">

<?php

    require_once("./view/navbar/navbar.php"); // Navbar

?>


<div class="container-xl h-75">

    <div class="row">

        <div class="col-3 mt-5">
            <a href=<?php echo SERVER_URL."/membre/"?> class="btn btn-primary"><i class="fa-solid fa-backward"></i> Retour</a>
        </div>
        
        <div class="col-8 mt-5 offset-1">

            <p class="fs-3 mb-3">Mot de passe</p>

            <div class="shadow mb-5 bg-body rounded p-3 ">
                
                <p class="fs-5 mb-3">Mes informations</p>

                <form id="form-modification" action=<?php echo SERVER_URL."/login/modifier/securite/"?> method="POST">


                    <div id='message_erreur_modification' class="mx-auto text-danger text-center m-2"><?php if(isset($params['erreur'])){ echo $params['erreur'];}?></div>


                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group pb-1 pt-2">

                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control pb-2" id="passwordM" name="password" aria-describedby="MmdpHelp" placeholder="Mot de passe">

                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group pb-1 pt-2">
                                    <label for="password_conf">Confirmer le mot de passe</label>
                                <input type="password" class="form-control pb-2" id="confpasswordM" name="confpassword" aria-describedby="MmdpHelp"  placeholder="Confirmer le mot de passe">
                            
                            </div>
                        </div>
                    </div>  
                    <!--Affichage erreur en cas de validation mot de passe-->
                    <small id="MmdpHelpErreur" class="form-text text-muted pb-2"></small>

                    <!--Affichage de l'aide mot de passe-->
                    <div class="infoPasswordContainer" id="passwordcontainer">
                        <small id="ImdpHelp" class="form-text text-muted pb-2">Pour la sécurité de votre compte veuillez utiliser un mot de passe contenant:</small>

                        <small id="MmdpHelpMax" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">entre 8 et 30 caractères.</p></div></small>
                        <small id="MmdpHelpMaj" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 lettre majuscule.</p></div></small>
                        <small id="MmdpHelpMin" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 lettre minuscule.</p></div></small>
                        <small id="MmdpHelpNum" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 chiffre.</p></div></small>
                        <small id="MmdpHelpSpe" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 caractère spéciale.</p></div></small>
                    </div>

                    <!--Affichage de l'aide confirmation mot de passe-->
                    <small id="MmdpHelpConf" class="form-text text-muted"></small>

                    <button type="submit" name="bouton-modification" id="bouton-modification" value="bouton-modification" class="btn btn-primary mt-3" >Modifier</button>

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