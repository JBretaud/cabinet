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
<div id="profile" class="frame container" style="background-color:#fff">
    <div class="row">
        <div class="title d-flex flex-column align-items-center w-100 py-3" >
            <h1> Ordonnance </h1>
        </div>
    </div>

    <div class="row pt-3" style="min-height:Calc(92vh - 107.2px);">
        
        <iframe name="iframeForm" class="col-xl-6 border-0" src="/cabinet/ordonnance/form?idPatient=<?= $_GET['idPatient']?>" frameborder="0" scrolling="no" onload="resizeIframe(this)">
        
        </iframe>
        <iframe name="myiframe" class="col-xl-6 border-0" src="/cabinet/ordonnance/display?idPatient=<?= $_GET['idPatient']?>" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
    </div>
</div>
<script>
    function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
    }
</script>