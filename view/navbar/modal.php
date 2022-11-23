<body>


<!--Connexion-->


<div class="modal fade" id="connexion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="connexion">Connexion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>

      <!--Message d'erreur-->
      <div id="message_erreur_connexion" class="mx-auto text-danger text-center m-2"></div>

      <!--Corps-->
      <div class="modal-body">

        <form id="form-connexion"  method="POST">

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
          
          <div class="row">

            <div class="col-3">
              <button type="submit" name="bouton-connexion" id="bouton-connexion" value="connexion" onclick="validationConnexion()" class="btn btn-primary" >Connexion</button>
            </div>

            <div class="col-6">
              <a class="lien" href="#inscription" data-toggle="modal">Toujours pas membre ?</a>
            </div>

          </div>


        </form>
        
      </div>

      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>


<!--Inscription-->



<div class="modal fade" id="inscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inscription">Inscription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>

      <div class="modal-body">
        <!--Message d'erreur-->
        <div id="message_erreur_inscription" class="mx-auto text-danger text-center m-2"></div>

        <form id="form-inscription" action="index.php?controller=Login&action=ReadEtape2" method="POST">
          <div class="form-group pb-2 pt-2">
              
              <div class="row">
                  <div class="col-lg-6">        
                          <label for="email">Adresse email</label>
                          <input type="email" class="form-control" id="emailIn" name="email" aria-describedby="IemailHelp" placeholder="Adresse email">
                          <small id="IemailHelp" class="form-text text-muted"></small>
                  </div>
              </div>    
          </div>

          <div class="form-group pt-2 pb-4">
              <div class="row">
                  <div class="col">
                          <label for="password">Mot de passe</label>
                          <input type="password" class="form-control pb-2" id="passwordIn" name="password" aria-describedby="ImdpHelp" placeholder="Mot de passe">
                  </div>
                  <div class="col">
                          <label for="confpassword">Confirmer le mot de passe</label>
                          <input type="password" class="form-control pb-2" id="confpasswordIn" name="confpassword" aria-describedby="ImdpHelp" placeholder="Confirmer le mot de passe">
                  </div>
                          <!--Affichage erreur en cas de validation mot de passe-->
                          <small id="ImdpHelpErreur" class="form-text text-muted pb-2"></small>

                          <!--Affichage de l'aide mot de passe-->
                          <div class="infoPasswordContainer" id="passwordcontainer">
                              <small id="ImdpHelp" class="form-text text-muted pb-2">Pour la sécurité de votre compte veuillez utiliser un mot de passe contenant:</small>
                          
                              <small id="ImdpHelpMax" class="form-text text-muted"><div class="infoPassword"><div id="triangleGris"></div><p>entre 8 et 30 caractères.</p></div></small>
                              <small id="ImdpHelpMaj" class="form-text text-muted"><div class="infoPassword"><div id="triangleGris"></div><p>1 lettre majuscule.</p></div></small>
                              <small id="ImdpHelpMin" class="form-text text-muted"><div class="infoPassword"><div id="triangleGris"></div><p>1 lettre minuscule.</p></div></small>
                              <small id="ImdpHelpNum" class="form-text text-muted"><div class="infoPassword"><div id="triangleGris"></div><p>1 chiffre.</p></div></small>
                              <small id="ImdpHelpSpe" class="form-text text-muted"><div class="infoPassword"><div id="triangleGris"></div><p>1 caractère spéciale.</p></div></small>
                          </div>

                          <!--Affichage de l'aide confirmation mot de passe-->
                          <small id="ImdpHelpConf" class="form-text text-muted"></small>
                          
                          
              </div>    
          </div>
        
          <div class="row">
              <div class="col-3">
                <button type="submit" name="bouton-inscription" id="bouton-inscription" onclick="validationInscription(1)" value="inscription" class="btn btn-primary" >Suivant</button>
              </div>
          </div>

        </form>
        
      </div>

      <div class="modal-footer">
      
      </div>

    </div>
  </div>
</div>



<!--Modal Vide petite-->
<div class="modal" tabindex="-1" id="modal_vide">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titre_modal"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
          
        </button>
      </div>
      <div class="modal-body" id="contenu_modal">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer" id="footer_modal">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!--Modal Vide large-->
<div class="modal" tabindex="-1" id="modal_vide_large">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titre_modal_large"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
          
        </button>
      </div>
      <div class="modal-body" id="contenu_modal_large">
        <p>Modal body text goes here.</p>
      </div>
    </div>
  </div>
</div>



<!--Notification-->
<div id="notification" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
  <div id="notifitication_header" class="toast-header">
    <img src="..." class="rounded me-2" alt="...">
    <strong class="me-auto">Bootstrap</strong>
    <small class="text-muted">11 mins ago</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div id="notifitication_body" class="toast-body">
    Hello, world! This is a toast message.
  </div>
</div>


<!--Notification succès-->
<div id="notification_success" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
  <div class="d-flex">
    <div id="notifitication_s_body" class="toast-body">
    Hello, world! This is a toast message.
   </div>
    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<!--Javascript des formulaire d'inscription et connexion-->

<script type="text/javascript" src="./js/form.js"></script>

</body>
