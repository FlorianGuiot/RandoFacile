
<div class="col-xl-3 col-md-12">

<div class="navbackgroundUser rounded-top mt-5 p-3">

    <p class="fs-5 mb-2">Bievenue <strong><?php echo $user->GetPrenom(); ?></strong></p>

    <p class="fs-7">Membre depuis le <strong><?php echo date_format($user->GetDateInscription(), "d/m/Y") ?></strong></p>
    
</div>

<div class="shadow mb-5 rounded-top p-3 rounded-bottom">

    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="lien " href="<?php echo SERVER_URL."/membre/" ?>"><i class="fa-solid fa-user mx-2"></i>Mon compte</a>
        </li>
        <li class="nav-item mb-2">
            <a class="lien" href="<?php echo SERVER_URL."/membre/commandes/" ?>"><i class="fa-solid fa-box mx-2"></i>Mes commandes</a>
        </li>
        <li class="nav-item mb-2">
            <a class="lien" href="<?php echo SERVER_URL."/panier/" ?>"><i class="fa-solid fa-cart-shopping mx-2"></i>Mon panier</a>
        </li>
    </ul>
</div>
</div>