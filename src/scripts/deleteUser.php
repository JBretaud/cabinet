<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'idDAO.php';
    $idDAO = new idDAO($pdo);
    $idDAO->delete($_GET['idUtilisateur']);
    header("Location: /cabinet/admin/accounts/display?alert=deletedAccount");
    exit();
