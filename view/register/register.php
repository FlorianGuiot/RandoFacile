<?php

//Header (css/js)
require_once(ROOT."/view/navbar/header.php");

?>
<body onload="initInscription()">
<div class="navbackgroundInscription mx-auto">

            <div>
                <div class="logoInscription">
                    <a href="index.php"><img src="<?php echo SERVER_URL.'/img/logo.png'; ?>" height="80"></a>
                </div>
            </div>
</div>
<div class="backgroundInscription mx-auto" >     
    <div class="container p-2">
        
        <div class="row  mx-auto">
            <div id="register-container" class="" style="text-align:center;" >

                <form id="form-inscription" action="<?php echo SERVER_URL.'/inscription/2/'; ?>" method="POST">


                    <div id='message_erreur_inscription' class="mx-auto text-danger text-center m-2"></div>


                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group pb-1 pt-2">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" aria-describedby="nomHelp"  placeholder="nom">
                                    <small id="nomHelp" class="form-text text-muted"></small>
                            
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group pb-1 pt-2">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" aria-describedby="prenomHelp"  placeholder="Prénom">
                                    <small id="prenomHelp" class="form-text text-muted"></small>
                            
                            </div>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group pb-1 pt-2">
                                    <label for="prenom">Date de naissance</label>
                                    <input type="date" class="form-control" id="date" name="date" aria-describedby="dateHelp">
                                    <small id="dateHelp" class="form-text text-muted"></small>
                            
                            </div>
                        </div>
                    </div>

                    <div class="form-group pb-1 pt-2">

                            <label for="email">Adresse email</label>
                            <input type="email" class="form-control" id="emailIn" name="email" aria-describedby="IemailHelp" value="<?php echo $_POST['email']; ?>" placeholder="Adresse email" >
                            <small id="IemailHelp" class="form-text text-muted"></small>
                    
                    </div>

                <div class="form-group pt-2 pb-4">

                    <div class="row">

                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control pb-2" id="passwordIn" name="password" aria-describedby="ImdpHelp" value="<?php echo $_POST['password']; ?>" placeholder="Mot de passe">
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                                <label for="password_conf">Confirmer le mot de passe</label>
                                <input type="password" class="form-control pb-2" id="confpasswordIn" name="confpassword" aria-describedby="ImdpHelp" value="<?php echo $_POST['confpassword']; ?>" placeholder="Confirmer le mot de passe">
                        </div>
                                <!--Affichage erreur en cas de validation mot de passe-->
                                <small id="ImdpHelpErreur" class="form-text text-muted pb-2"></small>

                                <!--Affichage de l'aide mot de passe-->
                                <div class="infoPasswordContainer" id="passwordcontainer">
                                    <small id="ImdpHelp" class="form-text text-muted pb-2">Pour la sécurité de votre compte veuillez utiliser un mot de passe contenant:</small>
                                
                                    <small id="ImdpHelpMax" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">entre 8 et 30 caractères.</p></div></small>
                                    <small id="ImdpHelpMaj" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 lettre majuscule.</p></div></small>
                                    <small id="ImdpHelpMin" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 lettre minuscule.</p></div></small>
                                    <small id="ImdpHelpNum" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 chiffre.</p></div></small>
                                    <small id="ImdpHelpSpe" class="form-text text-muted"><div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 caractère spéciale.</p></div></small>
                                </div>

                                <!--Affichage de l'aide confirmation mot de passe-->
                                <small id="ImdpHelpConf" class="form-text text-muted"></small>
                                
                    </div>    

                </div>
                    
                    <button type="submit" name="bouton-inscription" id="bouton-inscription" value="bouton-inscription" onclick='validationInscription(2)' class="btn btn-primary" >S'enregistrer</button>

                </form>

            </div>
        </div>
    </div>
    </div>
</div>

 <!--Footer-->
<?php
require_once(ROOT."/view/footer/footer.php");
?>

<script type="text/javascript" src="./../js/form.js"></script>

</body>
</html>