/*
* form.js
* RandoFacile
* 
* 
* Gestion des commentaires.
*
* @auteur: F.GUIOT
*/

function validationCommentaire(){

    document.querySelector("#bouton-commentaire").addEventListener("click", function(event) {
        event.preventDefault();
        var commentaire = document.forms["form-commentaire"].elements["commentaire"].value;

        var commentaireValide = false;

        /*Validation commentaire */

        if(commentaire == ''){
            document.getElementById("CommentaireHelp").innerHTML = '<p>Vous devez obligatoirement remplir ce champ.</p>';
            commentaireValide = false;
        }

        else if(commentaire.length > 1024){
            document.getElementById("CommentaireHelp").innerHTML = '<p>Vous ne pouvez pas poster un avis de plus de 512 caractères.</p>';
            commentaireValide = false;
        }

        else{
            document.getElementById("CommentaireHelp").innerHTML = '';
            commentaireValide = true;
        }


        /* Envoie */

        if(commentaireValide == true){
            document.getElementById("form-commentaire").submit();
        }

      }, false);

    
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
                document.getElementById("CommentaireHelp").innerHTML = '<p>'+commentaire.length+'/'+nbrMax+'</p>';
            }

        
        }, false);
}

function initCommentaire(){
    validationCommentaire();
    CommentaireInfo();
}

