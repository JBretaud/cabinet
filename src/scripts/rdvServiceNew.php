<?php

require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'demandeRdvDAO.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'serviceExterneDAO.php';

$demandeRdvDAO = new demandeRdvDAO($pdo);
$serviceExterneDAO = new serviceExterneDAO($pdo);

var_dump($_POST);
$attributes = [];
foreach($_POST as $key => $attribute){
    if($key !== 'Time' && $key !== 'date'){
        $attributes[$key] = $attribute;
    }
}

$date = new DateTime($_POST['date']." ".$_POST['Time']);

$attributes['date']=$date->getTimestamp();

$demandeRdvDAO->create(new DemandeRdv($attributes));

header('Location: /cabinet/praticien/fiche?idPatient='.$_POST['idPatient']);
    exit();

?>