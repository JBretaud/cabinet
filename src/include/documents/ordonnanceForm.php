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
    $nbMed=1;
    $patient=$patientDAO->get($_GET['idPatient']);
    $nom=strtoupper($patient->getNom());
    $prenom=ucfirst($patient->getPrenom());
    $dateNaissance=$patient->getDateNaissance();
    if (isset($_GET['nbMed'])) {
        $nbMed=$_GET['nbMed'];
    }
    
    if(isset($_GET['posologie'])) {
        $Posologie=$_GET['posologie'];
    }
    if(isset($_GET['idMeds'])) {
        $idMeds=$_GET['idMeds'];
        $Meds=[];
        foreach($idMeds as $Med){
            if(!empty($Med)){
                $Medx=$medDAO->get($Med);
                array_push($Meds,$Medx->getNom());
            }
            
        }
    }
    
    
    $ListeMeds=$medDAO->getListe();
    ?>
        <div class="d-flex flex-column align-items-start pl-3">
            <p>
                A destination de:
            </p>
            <p>
                M. <?=$prenom?> <?=$nom?>
            </p>
        </div>
        <div id="frameForm">
        <form action="/cabinet/ordonnance/create?idPatient=<?= $_GET['idPatient']?>" class="border-0 d-flex flex-column my-2 align-items-end" method="post" target="myiframe" >
            <?php for($i=0;$i<$nbMed;$i++):?>
                <div class="d-flex flex-row w-100 align-items-center my-2">
                    <div class="d-flex flex-column w-25 align-items-center m-0 pt-1 rounded label">
                        <label for="<?="Medicament".($i+1)?>" >Médicament <?=($i+1)?></label>
                        <select v-model="listeMed[<?=$i?>]['idMedicament']" name="<?="Medicament".($i+1)."[idMedicament]"?>" class="form-control" @change="setNom">
                            <option  value=''> </option>
                            <?php foreach($ListeMeds as $Med):?>
                                <option value=<?= $Med->getIdMedicament()?> <?=(isset($_GET['idMeds'][$i])&&!empty($_GET['idMeds'][$i])&&$Meds[$i]===$Med->getIdMedicament()) ? " selected" : "" ;?>><?= $Med->getNom()?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <fieldset class="border border-secondary w-75 p-2 ml-2">
                        <legend class="w-25 text-center" style="font-size:1.1em">Posologie</legend>
                        <textarea class="border-0 w-100" style="resize:none;" v-model="listeMed[<?=$i?>]['posologie']" name="<?="Medicament".($i+1)."[posologie]"?>"></textarea>
                    </fieldset>
                </div>
            <?php endfor;?>
            <div class="pt-4">
                <a href="/cabinet/ordonnance/cancel?idOrdonnance=''" class="btn btn-danger">Annuler</a>
                <button type="submit" class="btn btn-primary">Générer</button>
            </div>
        </form>
        <form class="w-100" method="get" action="/cabinet/ordonnance/form" target="iframeForm">
            <input type="hidden" value=<?= $_GET['idPatient']?> name="idPatient">
            <input type="hidden" value=<?=$nbMed+1?> name="nbMed">
            <?php for($i=0 ; $i<$nbMed ; $i++):?>
                <input type="hidden" :value="listeMed[<?=$i?>]['posologie']" name="posologie[]">
                <input type="hidden" :value="listeMed[<?=$i?>]['idMedicament']" name="idMeds[]">
            <?php endfor;?>
            <button id="boutAjoutMed" type="submit" class="btn btn-secondary" style="margin-top:-84px">Ajouter Médicament</button>
        </form>
        </div>