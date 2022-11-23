/*
* form.js
* RandoFacile
* 
* 
* Formulaire de connexion et d'inscription
*
* @auteur: F.GUIOT
*/

//Test si l'email placé en parametre est valide

//Retourne un objet contenant un bool et un message d'erreur
function TestEmail(email){


    let mailValide = true,
        error  = "";


    /*Validation mail */

    if(email == ''){ //Si il est vide

        error = '<p>Vous devez obligatoirement remplir ce champ.</p>';
        mailValide = false;

    }

    else if(email.length < 6){ //Si il est trop court 

        error = '<p>Ce champ doit comporter au moins 6 caractères.</p>';
        mailValide = false;

    }

    else if(!/[a-z0-9_\-\.]+@[a-z0-9_\-\.]+\.[a-z]+/i.test(email)){ //Si il n'y a pas de @ et .

        error = '<p>Cette adresse n\'est pas valide. Elle doit contenir un @ et un point.</p>'
        mailValide = false;

    }
    



    return { mailValide, error };
}


//Test si le mot de passe placé en parametre est valide
//Retourne un objet contenant un bool et un message d'erreur
function TestPassword(password){


    let passValide = true,
        error  = "";

    //Validation mot de passe

    /*Test si le mot de passe est vide */
    if(password == ''){

        error = '<p>Vous devez obligatoirement remplir ce champ.</p>';
        passValide = false;
        
    }
    /*Test si le mot de passe contient le bon nombre de caractères*/
    else if(password.length < 8 || password.length >= 30){

        error = '<p>Le mot de passe ne correspond pas aux critères de sécurité.</p>';
        passValide = false;

    }
    /*Test si le mot de passe contient: chiffre, majuscule, minuscule, caractères spéciaux et au moins 8 caractères. */
    else if(!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/.test(password)){

        error = '<p>Le mot de passe ne correspond pas aux critères de sécurité.</p>';
        passValide = false;

    }
    
    



    return { passValide, error };
}


//Test si les mots de passe placés en parametre sont identique
//Retourne un objet contenant un bool et un message d'erreur
function TestConfPassword(password,confPassword){


    let passValide = true,
        error  = "";

    //Validation mots de passe

    if(confPassword != password){

        error = '<p>Les mots de passe ne correspondent pas.</p>';
        passValide = false;

    }
    



    return { passValide, error };
}



function validationConnexion(){

    
    document.querySelector("#bouton-connexion").addEventListener("click", function(event) {  
        event.preventDefault();
        
        
        var email = document.forms["form-connexion"].elements["email"].value;

        var mailValide = false;

        var password = document.forms["form-connexion"].elements["password"].value;

        var mdpValide = false;


        //Test si le champ email est valide
        let emailResult = TestEmail(email);

        //Affiche une erreur si elle existe
        document.getElementById("CemailHelp").innerHTML = emailResult.error;

        //Recupère le resultat du test
        mailValide = emailResult.mailValide;



        /*Validation mot de passe */

        if(password == ''){
            document.getElementById("CmdpHelp").innerHTML = '<p>Vous devez obligatoirement remplir ce champ.</p>';
            mdpValide = false;
        }
        else{
            document.getElementById("CmdpHelp").innerHTML = '';
            mdpValide = true;
        }

        
        /* Envoie */
        //Retourne true si le mot de passe correspond à celui de l'utilisateur
        if(mdpValide == true && mailValide == true){
            
            
            $.ajax({
                url:'index.php?controller=Login&action=connexion',
                type:'post',
                data:{email:email,password:password},
                success:function(response){
                    
                    var msg = "";
                    if(response == true){
                        
                        //Rechargement de la page
                        location.reload();
                        
                        
                    }else{
                        //Message d'erreur
                        msg = "<p class='shake'>Identifiant ou mot de passe incorrect</p>";
                        
                    }
                    $("#message_erreur_connexion").html(msg);
                }
            });
        }

    }, false);

    
}



function disconnect(){

    


        
    /* Envoie la demande de déconnexion et retourne un nom d'utilisateur */
        
        
    $.ajax({
        url:'index.php?controller=Login&action=disconnect',
        type:'get',
        success:function(nom){
            
            
            $('#modal_vide').modal('show');
            
            var titre = "Déconnexion";
            var msg = "<div class='text-center'>Vous êtes déconnecté, à bientot <strong>"+nom+"</strong>."+
                     "<div class='row'><div class='p-5 text-center'><i class='fa-solid fa-user-minus fa-2xl'></i></i></div></div>";
            
            $("#titre_modal").html(titre);
            $("#contenu_modal").html(msg);
            
            //Lorsque l'utilisateur ferme la modal, la page se recharge
            $('#modal_vide').on('hidden.bs.modal', function () {

                //Rechargement de la page
                location.reload();

            })

        }


}, false);


}



function InscriptionInfo(){

        // Lorsque l'utilisateur clique sur le champ mot de passe :
        document.querySelector("#passwordIn").addEventListener("click", function(event) {
            document.getElementById("passwordcontainer").hidden = false; // Afficher le champ d'aide du mot de passe.
            document.getElementById("ImdpHelpConf").hidden = true; // Cacher le message de confirmation du mot de passe.
        }, false);

        // Lorsque l'utilisateur modifie le champ mot de passe :
        document.querySelector("#passwordIn").addEventListener("keyup", function(event) {
            var mdp = document.forms["form-inscription"].elements["passwordIn"].value;

            // Valide le nombre de caractères.
            if(mdp.length >= 8 && mdp.length <= 30){
                document.getElementById("ImdpHelpMax").innerHTML = '<div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">entre 8 et 30 caractères.</p></div>';
            }
            else{
                document.getElementById("ImdpHelpMax").innerHTML = '<div class="infoPassword"><div id="triangleGris"></div><p>entre 8 et 30 caractères.</p></div>';
            }

            // Valide la présence d'une majuscule.
            if(/[A-Z]+/.test(mdp)){
                document.getElementById("ImdpHelpMaj").innerHTML = '<div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 lettre majuscule.</p></div>';
            }
            else{
                document.getElementById("ImdpHelpMaj").innerHTML = '<div class="infoPassword"><div id="triangleGris"></div><p>1 lettre majuscule.</p></div>';
            }

            // Valide la présence d'une minuscule.
            if(/[a-z]+/.test(mdp)){
                document.getElementById("ImdpHelpMin").innerHTML = '<div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 lettre minuscule.</p></div>';
            }
            else{
                document.getElementById("ImdpHelpMin").innerHTML = '<div class="infoPassword"><div id="triangleGris"></div><p>1 lettre minuscule.</p></div>';
            }

            // Valide la présence d'un chiffre.
            if(/[0-9]+/.test(mdp)){
                document.getElementById("ImdpHelpNum").innerHTML = '<div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 chiffre.</p></div>';
            }
            else{
                document.getElementById("ImdpHelpNum").innerHTML = '<div class="infoPassword"><div id="triangleGris"></div><p>1 chiffre.</p></div>';
            }

            // Valide la présence de caractères spéciaux.
            if(/[!@#$%^&,;*]+/.test(mdp)){
                document.getElementById("ImdpHelpSpe").innerHTML = '<div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">1 caractère spéciale.</p></div>';
            }
            else{
                document.getElementById("ImdpHelpSpe").innerHTML = '<div class="infoPassword"><div id="triangleGris"></div><p>1 caractère spéciale.</p></div>';
            }


        }, false);

        //Affichage mots de passe identiques.
        document.querySelector("#confpasswordIn").addEventListener("click", function(event) {
            document.getElementById("passwordcontainer").hidden = true; // Afficher le champ d'aide du mot de passe.
            document.getElementById("ImdpHelpConf").hidden = false; // Cacher le message de confirmation du mot de passe.
        }, false);
        
        document.querySelector("#confpasswordIn").addEventListener("keyup", function(event) {
            var mdp = document.forms["form-inscription"].elements["passwordIn"].value;
            var confmdp = document.forms["form-inscription"].elements["confpasswordIn"].value;
            
            // Valide le nombre de caractères.
            if((mdp == confmdp) && mdp != ""){
                document.getElementById("ImdpHelpConf").innerHTML = '<div class="infoPassword"><div id="triangleVert"></div><p class="valid_password">Mots de passe identiques.</p></div>';
            }
            else{
                document.getElementById("ImdpHelpConf").innerHTML = '<div class="infoPassword"><div id="triangleGris"></div><p>Mots de passe non identiques.</p></div>';
            }
    
    
        }, false);
}



function validationInscription(etape){

    
    document.querySelector("#bouton-inscription").addEventListener("click", function(event) {
        event.preventDefault();

        
        var email = document.forms["form-inscription"].elements["emailIn"].value;
        var mailValide = false;

        var password = document.forms["form-inscription"].elements["passwordIn"].value;
        var confPassword = document.forms["form-inscription"].elements["confpasswordIn"].value;

        var passValide = false;
        
        /*
        Validation email
        */

        //Test si le champ email est valide
        let emailResult = TestEmail(email);

        //Affiche une erreur si elle existe
        document.getElementById("IemailHelp").innerHTML = emailResult.error;

        //Recupère le resultat du test
        mailValide = emailResult.mailValide;


        /*
        Validation mot de passe 
        */

        //Test si le champ password est valide
        let passwordResult = TestPassword(password);

        //Affiche une erreur si elle existe
        document.getElementById("ImdpHelpErreur").innerHTML = passwordResult.error;

        //Recupère le resultat du test
        passValide = passwordResult.passValide;

        if(passValide == true){

            //Test si le champ password est valide
            let confPasswordResult = TestConfPassword(password,confPassword);

            //Affiche une erreur si elle existe
            document.getElementById("ImdpHelpErreur").innerHTML = confPasswordResult.error;

            //Recupère le resultat du test
            passValide = confPasswordResult.passValide;

        }

        
        if(etape == 1){

            /* 
            Envoie 
            */

            if(passValide == true && mailValide == true){

                $.ajax({
                    url:'index.php?controller=Login&action=inscriptionEtape1',
                    type:'post',
                    data:{email:email,password:password,confpassword:confPassword},
                    success:function(response){
                        
                        if(response != ""){

                            var msg = "";
                        
                            //Message d'erreur
                            msg = "<p class='shake'>"+response+"</p>";
                            
                            
                            $("#message_erreur_inscription").html(msg);

                        }else{

                            document.getElementById("form-inscription").submit();
                            
                        }
                        
                    }
                });

            }

        //Etape 2
        }else{

            
            var nom = document.forms["form-inscription"].elements["nom"].value;

            var nomValide = false;

            var prenom = document.forms["form-inscription"].elements["prenom"].value;

            var prenomValide = false;

            //Date du jour
            var today = Date();

            var dateNaissance = document.forms["form-inscription"].elements["date"].value;

            var dateValide = false;

            // Valide la présence de nom.
            if(nom == ""){
                document.getElementById("nomHelp").innerHTML = '<p>Vous devez obligatoirement remplir ce champ.</p>'; 
            }
            else{
                document.getElementById("nomHelp").innerHTML = ''; 
                nomValide = true;
            }

            // Valide la présence de prénom.
            if(prenom == ""){
                document.getElementById("prenomHelp").innerHTML = '<p>Vous devez obligatoirement remplir ce champ.</p>'; 
            }
            else{
                document.getElementById("prenomHelp").innerHTML = ''; 
                prenomValide = true;
            }


            /* 
            Envoie 
            */

            if(nomValide && prenomValide){

                
                $.ajax({
                    url:'index.php?controller=Login&action=inscriptionEtape2',
                    type:'post',
                    data:{email:email,password:password,nom:nom,prenom:prenom,dateNaissance:dateNaissance,confpassword:confPassword},
                    success:function(response){

                        console.log(response);

                        if(response != ""){

                            var msg = "";
                            
                            msg = "<p class='shake'>"+response+"</p>";
                            
                            
                            $("#message_erreur_inscription").html(msg);

                        }else{

                            welcomMSG = '<div class="col-12"><p class="shake text-success m-2" style="font-size: 2rem">Bienvenue '+prenom+' !</p></div>'+
                                        '<div class="col-12"><i class="fa-solid fa-thumbs-up fa-2xl m-2"></i></div>'+
                                        '<div class="col-12"><p class="m-2">Toute l\'équipe de RandoFacile te souhaite la bienvenue. N\'attends plus pour passer commande !</p></div>'+
                                        '<div class="col-12"><button name="bouton-accueil" id="bouton-accueil"  value="accueil" class="btn btn-primary" onclick="window.location.href = \'index\';" >Retour à l\'accueil</button></div>';
                                        
                            document.getElementById("register-container").innerHTML = welcomMSG;                             
                        }
    
                    }

                });

                
            }


        }

      }, false);

    
}


//Permet de check et uncheck les etoiles du système de rating
function CheckStarsRating(){

    // Lorsque l'utilisateur clique sur le bouton modifier d'un commentaire
    $("div.rating").on("click","span", function(event){
        event.preventDefault();

        var val = $(event.target).attr('value');

        //Ajoute les étoiles en dessous de celle cliquée et sur elle meme
        for (let i = 1; i <= val; i++) {
            
       
            $($("#rate"+i)).addClass("rating_checked").removeClass("rating_unchecked");

        }

        //Retire les étoiles au dessus de celle cliquée
        for (let i = 5; i > val; i--) {
            
       
            $($("#rate"+i)).addClass("rating_unchecked").removeClass("rating_checked");

        }

    });

}


//Permet de connaitre la note attribuée a l'article
function GetStarsRating(){

    let i = 5;
    let note = i;
    
    while(($("#rate"+i).attr('class') == "fa fa-star rating_unchecked") && i >= 0){
        
        i--;
        note = i;
        
        
    }

    //Retoure la note
    return note;


}


function CommentaireInfo(){

    const nbrMax = 1024;
    // Lorsque l'utilisateur modifie le champ commentaire :
    document.querySelector("#commentaire").addEventListener("keyup", function(event) {
        var commentaire = document.forms["form-commentaire"].elements["commentaire"].value;

        // Affiche le nombre de caractères.
        if(commentaire.length>nbrMax){
            document.getElementById("CommentaireHelp").innerHTML = '<p style="color:red;">'+commentaire.length+'/'+nbrMax+'</p>';
        }
        else{
            document.getElementById("CommentaireHelp").innerHTML = '<p style="color:grey;">'+commentaire.length+'/'+nbrMax+'</p>';
        }

    
    }, false);


    document.querySelector("#bouton-commentaire").addEventListener("click", function(event) {
        event.preventDefault();
        var commentaire = document.forms["form-commentaire"].elements["commentaire"].value;

        var commentaireValide = false;

        /*Validation commentaire */

        if(commentaire == ''){
            document.getElementById("CommentaireHelp").innerHTML = '<p>Vous devez obligatoirement remplir ce champ.</p>';
            commentaireValide = false;
        }

        else if(commentaire.length > nbrMax){
            document.getElementById("CommentaireHelp").innerHTML = '<p>Vous ne pouvez pas poster un avis de plus de '+nbrMax+' caractères.</p>';
            commentaireValide = false;
        }

        else{
            document.getElementById("CommentaireHelp").innerHTML = '';
            commentaireValide = true;
        }


        /* Envoie */

        if(commentaireValide == true){
            
            const infoProduit = document.querySelector("#info-produit");
            let idProduit = infoProduit.dataset.id;
            let note = GetStarsRating();
           

            $.ajax({
                url:'index.php?controller=Produit&action=PostCommentaire',
                type:'post',
                data:{commentaire:commentaire,idProduit:idProduit,note:note},
                success:function(response){

                    if(response == ""){
                        
                        //Rechargement de la page
                        location.reload();
                        
                        
                    }else{
                        //Message d'erreur
                        $("#CommentaireHelp").html(response);
                        
                    }
                    
                }
            });

        }

      }, false);
}


//Permet de modifier un commentaire
function editButtonCommentaire(){

    // Lorsque l'utilisateur clique sur le bouton modifier d'un commentaire
    $("div.commentaire").on("click","a.editButton", function(event){
        event.preventDefault();
        
        //Retrouve le commentaire associé 
        var parent = $(event.target).parent().parent().parent().parent();

        //Récupère l'id du commentaire
        var id = $(parent).attr('id');
        
        //Récupère le texte du commentaire 
        var commentaire = $(parent).children("#commentaireBody").text();
        commentaire = commentaire.substr(30); //Le commentaire est récupéré avec 30 espaces au début, on les retire
        
        //Formulaire
        const formEdit = '<form id="form-commentaireEdit" action="" >'+
                        '<div class="form-group">'+
                            '<div class="m-2">'+
                                '<textarea class="form-control" id="commentaire" name="commentaire" rows="3">'+commentaire+'</textarea>'+
                            '</div>'+
                            '<small id="CommentaireEditHelp" class="form-text text-muted"></small>'+
                            '<div class="commentaireBoutonContainer">'+
                                '<button class="btn btn-primary" type="submit" name="bouton-commentaireEdit" id="bouton-commentaireEdit" value="modifier" >Modifier</button>'+
                            '</div>'+
                        '</div>'+
                        '</form>';



        //Affiche la modal
        $('#modal_vide').modal('show');
        $("#titre_modal").html('Modifier');
        $("#contenu_modal").html(formEdit);
        $("#footer_modal").html('');


        const nbrMax = 1024;
        // Lorsque l'utilisateur modifie le champ commentaire :
        document.querySelector("#commentaire").addEventListener("keyup", function(event) {
            var commentaire = document.forms["form-commentaireEdit"].elements["commentaire"].value;

            // Affiche le nombre de caractères.
            if(commentaire.length>nbrMax){
                document.getElementById("CommentaireEditHelp").innerHTML = '<p style="color:red;">'+commentaire.length+'/'+nbrMax+'</p>';
            }
            else{
                document.getElementById("CommentaireEditHelp").innerHTML = '<p style="color:grey;">'+commentaire.length+'/'+nbrMax+'</p>';
            }

        
        }, false);


        document.querySelector("#bouton-commentaireEdit").addEventListener("click", function(event) {
            event.preventDefault();
            var commentaire = document.forms["form-commentaireEdit"].elements["commentaire"].value;

            var commentaireValide = false;

            /*Validation commentaire */

            if(commentaire == ''){
                document.getElementById("CommentaireEditHelp").innerHTML = '<p>Vous devez obligatoirement remplir ce champ.</p>';
                commentaireValide = false;
            }

            else if(commentaire.length > nbrMax){
                document.getElementById("CommentaireEditHelp").innerHTML = '<p>Vous ne pouvez pas poster un avis de plus de '+nbrMax+' caractères.</p>';
                commentaireValide = false;
            }

            else{
                document.getElementById("CommentaireEditHelp").innerHTML = '';
                commentaireValide = true;
            }


            /* Envoie */

            if(commentaireValide == true){
                
                $.ajax({
                    url:'index.php?controller=Produit&action=EditCommentaire',
                    type:'post',
                    data:{commentaire:commentaire,id:id},
                    success:function(response){

                        if(response == ""){

                            $('#modal_vide').modal('toggle');
                            //Modification du commentaire
                            $(parent).children("#commentaireBody").html('<p>'+commentaire+'</p>');
                            
                            
                        }else{
                            //Message d'erreur
                            $("#CommentaireHelp").html(response);
                            
                        }
                        
                    }
                });

            }

        }, false);

        
        

    });

}



//Permet de supprimer un commentaire
function DeleteButtonCommentaire(){

    // Lorsque l'utilisateur clique sur le bouton modifier d'un commentaire
    $("div.commentaire").on("click","a.deleteButton", function(event){
        event.preventDefault();

        //Retrouve le commentaire associé 
        var parent = $(event.target).parent().parent().parent().parent();

        //Récupère l'id du commentaire
        var id = $(parent).attr('id');
        
        //Récupère le texte du commentaire 
        var commentaire = $(parent).children("#commentaireBody").text();
        commentaire = commentaire.substr(30); //Le commentaire est récupéré avec 30 espaces au début, on les retire
        
        //Formulaire
        const SupprimerTexte = '<div class="row">'+
                                '<div class="col-12">'+
                                '<p>Êtes vous sûr de vouloir supprimer ce commentaire ?</p>'+
                                '</div>'+
                                '<div class="col-12 border text-white" style="background-color:grey;">'+
                                '<p class="text-truncate">'+commentaire+'</p>'+
                                '</div>';
        
        const boutonsSupprimer = '<div class="row w-100">'+
                                '<div class="col-4 ">'+
                                '<button type="button" id="boutonSupprimer" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Supprimer</button>'+
                                '</div>'+
                                '<div class="col-4">'+
                                '<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>'+
                                '</div>';



        //Affiche la modal
        $('#modal_vide').modal('show');
        $("#titre_modal").html('Supprimer');
        $("#contenu_modal").html(SupprimerTexte);
        $("#footer_modal").html(boutonsSupprimer);


        document.querySelector("#boutonSupprimer").addEventListener("click", function(event) {
            event.preventDefault();

            /* Supprime le commentaire */

            $.ajax({
                url:'index.php?controller=Produit&action=SupprimerCommentaire',
                type:'post',
                data:{id:id},
                success:function(response){

                    if(response == ""){

                        $('#modal_vide').modal('toggle');
                        //Suppression du commentaire
                        $(parent).html('');
                        
                        
                    }else{
                        //Message d'erreur
                        $("#titre_modal").html('Supprimer - Erreur');
                        $("#contenu_modal").html(response);
                        $("#footer_modal").html("");
                        $("#CommentaireHelp").html(response);
                        
                    }
                    
                }
            });

        }, false);

        
        

    });

}



//Récupère les infos d'un produit et ajoute le produit dans le panier 
function GetAddPanierInfo(){

    //Clique sur le bouton ajouter panier sur une page produit
    $("#BtnAjouterPanier").on("click",function(event){
        event.preventDefault();

        const infoProduit = document.querySelector("#info-produit");
        let idProduit = infoProduit.dataset.id; 
        let qte = parseInt($("#qteProduit").val()) ;
        let qteMax = parseInt($("#qteProduit").attr('max'));
        let qteMin= parseInt($("#qteProduit").attr('min'));

        if((qte >= qteMax) || (qte < qteMin) ){

           
            $("#qteHelp").html("La quantité doit être comprise entre 1 et "+qteMax+".");

        }else{

            //Ajoute le produit au panier
            AddPanier(idProduit,qte);

        }
        

    });
    
}


//Ajoute le produit dans le panier 
function AddPanier(idProduit,qte){


    const sucessText =  '<div class="row">'+
                        '<div class="col-12 text-center">'+
                        '<p>Le produit a bien été ajouté au panier !</p>'+
                        '</div>'+
                        '<div class="col-12 m-2 text-center">'+
                        '<i class="fa-solid fa-check fa-2xl" style="color:green;"></i>'+
                        '</div>';

    const errorText =   '<div class="row">'+
                        '<div class="col-12 text-center">'+
                        '<p>Une erreur est survenue lors de l\'ajout de l\'article dans le panier.</p>'+
                        '</div>'+
                        '<div class="col-12 m-2 text-center">'+
                        '<i class="fa-solid fa-circle-exclamation fa-2xl" style="color:red;"></i>'+
                        '</div>';


    $.ajax({
        url:'index.php?controller=Panier&action=AddPanier',
        type:'post',
        data:{idProduit:idProduit,qte:qte},
        success:function(response){
            
            if(response == 1){

                // Met à jour l'affichage du panier       
                $.ajax({
                    url:'index.php?controller=Panier&action=AffichagePanier',
                    type:'get',
                    dataType: 'json',
                    success:function(data){
                        
                        $("#panierUtilisateur").html(data[0]); //Met à jour le contenue
                        $("#panierUtilisateurNb").html(data[1]); //Met à jour le contenue

                        //Affiche la modal 
                        $('#modal_vide').modal('show');
                        $("#titre_modal").html('');
                        $("#contenu_modal").html(sucessText);
                        $("#footer_modal").html("");
                    }
                });

            }else{

                //Affiche la modal 
                $('#modal_vide').modal('show');
                $("#titre_modal").html('Erreur - Panier');
                $("#contenu_modal").html(errorText);
                $("#footer_modal").html("");

            }

            
        }
    });

    
}


function init(){
    validationConnexion();
    validationInscription(1);
    InscriptionInfo();
    editButtonCommentaire();
    DeleteButtonCommentaire();
    GetAddPanierInfo();
    CheckStarsRating();
    CommentaireInfo();
}

function initInscription(){
    InscriptionInfo();
    validationInscription(2);
}