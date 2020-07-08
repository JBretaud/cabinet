<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Date'.DIRECTORY_SEPARATOR.'Day.php';
$rdvDAO = new rdvDAO($pdo);
$date=new DateTime($_POST['date']);
$ListeRdv=$rdvDAO->getAllDayRdv(new Day(intval($date->format('Y')), intval($date->format('m')), intval($date->format('d'))), $_SESSION['idPraticien']);
// var_dump($ListeRdv);

$start = $_POST['date']." ".$_POST['start'];
$timeArray = explode(' ',$start);
// var_dump($_POST);
$adress='Location: /cabinet/calendar/week';


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
$dateDebut = new DateTime($start);
$dateFin = (clone $dateDebut)->modify("+".$duree."minutes");
$free=true;
foreach($ListeRdv as $rdv){
    $debutRDV = new DateTime($rdv->getStart());
    $finRDV = (clone $debutRDV)->modify("+".$rdv->getDuree()."minutes");
    if (($debutRDV > $dateDebut && $debutRDV < $dateFin) || ($finRDV > $dateDebut && $finRDV < $dateFin) || ($debutRDV < $dateDebut && $finRDV > $dateFin)){
        $free=false;
    }
}

if($free){
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
}
else{
    $adress="Location: /cabinet/praticien/rdvperso/new?alert=RdvPris";
}

header($adress);
exit();


