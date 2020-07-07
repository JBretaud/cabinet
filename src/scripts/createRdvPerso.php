<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
$rdvDAO = new rdvDAO($pdo);

$start = $_POST['date']." ".$_POST['start'];
$timeArray = explode(' ',$start);
var_dump($_POST);


if(isset($_POST['fullDay']) && $_POST['fullDay'] === 'on'){
    $timeArray = explode(':',$timeArray[1]);
    $duree = (19 - intval($timeArray[0]))*60 + intval($timeArray[1]);
}else{
    if(isset($_POST['duree'])){
        $timeArray = explode(':',$_POST['duree']);
        $duree=intval($timeArray[0])*60 + intval($timeArray[1]);
    }elseif(isset($_POST['end'])){
        $timeArrayStart = explode(':',$timeArray[1]);
        $timeArrayEnd = explode(':',$_POST['end']);
        $duree = (intval($timeArrayEnd[0]) - intval($timeArrayStart[0]))*60 + intval($timeArrayEnd[1]) - intval($timeArrayStart[1]);
    }
}



$idPraticien = $_SESSION['idPraticien'];
$attributes=[
    'idPraticien' => $idPraticien,
    'duree' => $duree,
    'start' => $start,
    'date' => $_POST['date'],
    'label' => $_POST['label'],
];

if( isset ($_POST['description']) ){
    $attributes['description'] = $_POST['description'];
}

$rdvDAO->create( new Rdv($attributes) );

  header('Location: /cabinet/calendar/week');
 exit();


