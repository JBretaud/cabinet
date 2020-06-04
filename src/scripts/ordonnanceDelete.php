<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ordonnanceDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Ordonnance.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'LigneOrdonnance.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ligneOrdonnanceDAO.php';
if (isset($_SESSION['idOrdonnance'])){
    $ordonnanceDAO=new ordonnanceDAO($pdo);
    $ordonnanceDAO->delete($_SESSION['idOrdonnance']);
    unset($_SESSION['idOrdonnance']);
    header('Location: /cabinet/accueil?alert=OrdonnanceCancel&idPatient='.$_GET['idPatient']);
    exit();
}
header('Location: /cabinet/praticien/fiche?idPatient='.$_GET['idPatient']);
    exit();
