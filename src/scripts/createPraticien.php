<?php
    // var_dump($_POST);
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'idDAO.php';
    $praticienDAO = new praticienDAO($pdo);
    $praticien = new Praticien($_POST);
    $praticienDAO->create($praticien);
    $idPraticien=$pdo->lastInsertId();
    // var_dump($idPraticien);
    $idDAO = new idDAO($pdo);
    $User = new User($_POST);
    // var_dump($User);
    $User->setIdPraticien($idPraticien);
    $idDAO->update($User);
    header("Location: /cabinet/admin/accounts/display?alert=createdAccount");
    exit();
?>