<?php

use App\Date\Month;

require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Date'.DIRECTORY_SEPARATOR.'Month.php';
    //DAOs
    $rdvDAO=new rdvDAO($pdo);
    $patientDAO=new patientDAO($pdo);
    $praticienDAO=new praticienDAO($pdo);
    
    
    $rdv = $rdvDAO->get($_GET['idRdv']);
    
    $patient = $patientDAO->get($rdv->getIdPatient());
    $praticien = $praticienDAO->get($rdv->getIdPraticien());
    $date = new DateTime($rdv->getStart());
    $month = new Month();
    $mois = $month->months[$date->format('n')-1];
    $dateString = $date->format('d') . " " . $mois . " " . $date->format('Y');
    if (empty($rdv->getDescription())){
        $description = "Non Renseigné";
    } else {
        $description = $rdv->getDescription();
    }
    // Liens
    if($_SESSION['type']===1){
        $LienModif="/cabinet/patient/rdv/modify?idRdv=".$rdv->getIdRdv();
        $LienAnnule="/cabinet/patient/rdv/cancel?idRdv=".$rdv->getIdRdv();
    }elseif($_SESSION['type']===2){
        $LienModif="/cabinet/praticien/rdv/modify?idRdv=".$rdv->getIdRdv();
        $LienAnnule="/cabinet/praticien/rdv/cancel?idRdv=".$rdv->getIdRdv();
    }elseif($_SESSION['type']===3){
        $LienModif="/cabinet/secretaire/rdv/modify?idRdv=".$rdv->getIdRdv();
        $LienAnnule="/cabinet/secretaire/rdv/cancel?idRdv=".$rdv->getIdRdv();
    }
    

?>
    <div class="w-100 d-flex flex-column align-items-center">
        <div id="formRdv" class="d-flex flex-column align-items-center w-50">
            <div class="d-flex flex-column align-items-center mb-5">
                <h1>Rendez-vous</h1>
                <img class="separator" src='/cabinet/src/img/separator.png'>
            </div>

            <?php if ($_SESSION['type']===1||$_SESSION['type']===3):?>
            <div class="mt-5 d-flex flex-row align-items-end">
                <?php if($_SESSION['type']===3) echo "Praticien : ";?>
                <h3 class="mb-0 ml-2"> Dr. <?=ucfirst($praticien->getPrenom()).' '.strtoupper($praticien->getNom())?></h3>
            </div>

            <?php endif; ?>

            <?php if ($rdv->getLabel() === null && ($_SESSION['type'] === 3 || $_SESSION['type'] === 2) ):?>
            
            <div class="mt-5 d-flex flex-row align-items-end">
                <?php if($_SESSION['type']===3) echo "Patient : ";?>
                <h3 class="mb-0 ml-2"> M. <?=ucfirst($patient->getPrenom())." ".strtoupper($patient->getNom())?></h3>
            </div>
            <?php endif; ?>

            <div class="d-flex flex-row align-items-end mt-2 mb-4">
                <label class="m-0">Le </label>
                <div class="border-0 date"><?= $dateString ?></div>
                <label class="ml-3 mb-0"> à </label>
                <div class="border-0 date hour" ><?= $date->format('H:i') ?></div>
            </div>
            <?php if ($rdv->getLabel() !== null): ?>
            <div class="form-group d-flex flex-column align-items-center w-100">
                <h2><?=$rdv->getLabel()?></h2>
            </div>
            <?php endif; ?>
            <div class="form-group d-flex flex-column align-items-center w-100">
                <label><h3>- Motif du rendez-vous - </h3></label>
                <div class="w-50 description"><?=$description?></div>
            </div>
            <div>
                <a href="<?=$LienModif?>" class="mt-2 btn btn-primary">Modifier la description</a>
                <a href="<?=$LienAnnule?>" class="mt-2 btn btn-alert">Annuler le rendez-vous</a>
            </div>
            <a class="mt-4" href="/cabinet/calendar/month">&#x21BB Retour au calendrier</a>
            
        </div>
    </div>