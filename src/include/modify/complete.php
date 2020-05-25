<?php
    if($_SESSION['type']==3){
        $adress="/cabinet/account/modify?idPatient=".$GET['idPatient'];
    }elseif($_SESSION['type']==1){
        $adress="/cabinet/profil";
    }
?>
<div id="complete"class="d-flex flex-column align-items-center justify-content-center" style="height:calc(100vh - 72px);width:100%;">
    <h1>Votre compte a bien été mis à jour.</h1>
    <a href="/cabinet/patient/profil">&#x21BB Retour au profil</a>
</div>