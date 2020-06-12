<?php

use App\Date\Month;

require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Date'.DIRECTORY_SEPARATOR.'Month.php';
    $dateString="";
    if($path[2]==="modify"){
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
        $rdvDAO=new rdvDAO($pdo);
        $rdv=$rdvDAO->get($_GET['idRdv']);
        $idPraticien=$rdv->getIdPraticien();
        $idPatient=$rdv->getIdPatient();

        $date=new DateTime($rdv->getStart());
        $month=new Month();
        $mois = $month->months[$date->format('n')-1];
        $dateString = $date->format('d') . " " . $mois . " " . $date->format('Y');

        $buttonLabel="Mettre à Jour";
        if ($_SESSION['type'] === 3){
            $adress="/cabinet/secretaire/rdv/update";
        }elseif ($_SESSION['type'] === 1){
            $adress="/cabinet/patient/rdv/update";
        }elseif($_SESSION['type'] === 2){
            
            $adress="/cabinet/praticien/rdv/update";
        }
    }else{
        $idPatient=$_GET['idPatient'];
        $idPraticien=$_GET['idPraticien'];
        $creneau=$_GET['creneau'];
        $creneau=explode("-",$creneau);
    
        
        $date=new DateTime("{$creneau[0]}-{$creneau[1]}-{$creneau[2]} {$creneau[3]}:{$creneau[4]}");
        $month=new Month();
        $mois = $month->months[$date->format('n')-1];
        $dateString = $date->format('d') . " " . $mois . " " . $date->format('Y');
        if ($_SESSION['type']==3){
            $adress="/cabinet/secretaire/rdv/finalize";
        }elseif ($_SESSION['type']==1){
            $adress="/cabinet/patient/rdv/finalize";
        }elseif($_SESSION['type'] === 2){
            $adress="/cabinet/praticien/rdv/finalize";
        }
        $buttonLabel="Réserver le créneau";
    }
    
    $praticienDAO=new praticienDAO($pdo);
    $praticien=$praticienDAO->get($idPraticien);
    
    
?>
    <div class="w-100 d-flex flex-column align-items-center">
        <form id="formRdv" class="d-flex flex-column align-items-center w-50" action="<?= $adress ?>" method="post">
            <input type="hidden" name="idPatient" value=<?= $idPatient ?>>
            <input type="hidden" name="idPraticien" value=<?= $idPraticien ?>>
            <input type="hidden" name="start" value=<?= $date->format('Y-m-d/H:i') ?>>
            <input type="hidden" name="Date" value="<?= $date->format('Y-m-d') ?>">
            <input type="hidden" value=<?= $date->format('H:i') ?>>
            <div class="d-flex flex-column align-items-center mb-5">
                <h1>Rendez-vous</h1>
                <img class="separator" src='/cabinet/src/img/separator.png'>
            </div>
            <h3 class="mt-5"> Dr. <?=$praticien->getPrenom().' '.$praticien->getNom()?></h3>
            <div class="d-flex flex-row align-items-end mb-4">
                <label class="m-0">Le </label>
                <div type="text" class="date border-0"><?= $dateString ?></div>
                <label class="ml-2 mb-0">à </label>
                <div class="border-0 date hour" ><?= $date->format('H:i')?></div>
            </div>
            <div class="form-group d-flex flex-column align-items-center w-100">
                <label><h3>- Motif du rendez-vous - </h3></label>
                <textarea class="description w-50" name="Description"><?php if(isset($rdv)) echo $rdv->getDescription()?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><?=$buttonLabel?></button>
        </form>
    </div>