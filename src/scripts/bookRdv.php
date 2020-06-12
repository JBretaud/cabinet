<?php

require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';

echo $_POST['start'];
$start=str_replace("/"," ",$_POST['start']);
echo $start;
$rdv=new Rdv($_POST);

$rdvDAO=new rdvDAO($pdo);
$rdvDAO->create($rdv);
if($_SESSION['type'] === 3){
    header('Location: /cabinet/secretaire/fiche?idPatient='.$_POST['idPatient']);
    exit();
}elseif($_SESSION['type'] === 2){
    header('Location: /cabinet/praticien/fiche?idPatient='.$_POST['idPatient']);
    exit();
}elseif($_SESSION['type']==1){
    header('Location: /cabinet/patient/profil');
    exit();
}
?>