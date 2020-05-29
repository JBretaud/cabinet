<?php
    include_once ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Med.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'MedDAO.php';
    $medDAO=new medDAO($pdo);
    $patientDAO=new patientDAO($pdo);
    
    $patient=$patientDAO->get($_GET['idPatient']);
    $nom=strtoupper($patient->getNom());
    $prenom=ucfirst($patient->getPrenom());
    $dateNaissance=$patient->getDateNaissance();
    
?>

<div class="d-flex flex-column align-items-center w-100" style="background-color:#d3f4f5;">
    <h1> Ordonnance </h1>
    <img class="separator" src='/cabinet/src/img/separator.png'>
</div>
<div class="d-flex flex-row col-12 justify-content-center pt-3" style="height:Calc(95vh - 178.2px);">
    
    <iframe name="iframeForm" class="col-xl-4 border-0" src="/cabinet/ordonnance/form?idPatient=<?= $_GET['idPatient']?>">
    
    </iframe>
    <iframe name="myiframe" class="col-xl-6 border-0" src="/cabinet/ordonnance/display?idPatient=<?= $_GET['idPatient']?>"></iframe>
</div>