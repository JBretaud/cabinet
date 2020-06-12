<?php

?>
<div class="container frame">
    <div class="row">
        <div class="title col-12">
            <h1 style="color:#FFF">CHANGEMENT DE MOT DE PASSE</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-2"></div>
        <div class="col-xl-8 mt-3 col-lg-12">
            <form action="" class="" method="post">
                <div class="form-group w-100 d-flex flex-row">
                    <label for="login" class="w-25">Login :</label>
                    <input type="text" name="login" readonly="readonly" class="w-75 form-control" value=<?=$_SESSION['login']?>>
                </div>
                <div class="form-group w-100 d-flex flex-row">
                    <label for="oldpass" class="w-25">Ancien <span class="text-nowrap">Mot de Passe :</span></label>
                    <input type="text" name="oldpass" class="w-75 form-control" >
                </div>
                
                <div class="form-group w-100 d-flex flex-row">
                    <label for="pass" class="w-25">Nouveau <span class="text-nowrap">Mot de Passe :</span></label>
                    <input type="text" name="pass" class="w-75 form-control">
                </div>
                <div class="form-group w-100 d-flex flex-row">
                    <label class="w-25">Vérification <span class="text-nowrap">Mot de Passe :</span></label>
                    <input type="text" class="w-75 form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100"><b>CHANGER DE MOT DE PASSE</b></button>
            </form>
        </div>
        <div class="col-xl-2"></div>
    </div>
</div>