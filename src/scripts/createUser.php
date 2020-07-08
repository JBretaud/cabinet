<?php
     require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'idDAO.php';
     $idDAO=new idDAO($pdo);
     var_dump($_POST);
     $idDAO->create($_POST['login'],password_hash($_POST['pass'],PASSWORD_DEFAULT),$_POST['idTypeUtilisateur'],$_POST['email']);
     $idUtilisateur = $pdo->lastInsertId();
     if(intval($_POST['idTypeUtilisateur']) === 2):
     ?>
     <div class="container frame p-0">
        <div class="title">
            <h1 style="color:#fff">Coordonnées Praticien</h1>
        </div>
        <form action="/cabinet/admin/accounts/newPraticien" class="p-3 w-100" method="post">
            <div class="form-group w-100">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" name="nom">
            </div>
            <div class="form-group w-100">
                <label for="prenom">Prenom:</label>
                <input type="text" class="form-control" name="prenom">
            </div>
            <input type="hidden" name="email" value="<?=$_POST['email']?>">
            <input type="hidden" name="idUtilisateur" value="<?=intval($idUtilisateur)?>">
            <input type="hidden" name="login" value="<?=$_POST['login']?>">
            <input type="hidden" name="idTypeUtilisateur" value="<?=$_POST['idTypeUtilisateur']?>">
            <input type="hidden" name="pass" value="<?=password_hash($_POST['pass'],PASSWORD_DEFAULT)?>">
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
     </div>
     <?php else:
        header("Location: /cabinet/admin/accounts/display?alert=createdAccount");
        exit();
    endif;?>