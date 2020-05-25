<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
    $patientDAO=new patientDAO($pdo);
    if(isset($_GET['email'])){
        $patient=$patientDAO->mailExist($_GET['email']);
        $nom='';
        $prenom='';
        $dateNaissance=null;
        $voie='';
        $cp='';
        $ville='';
        $telephone='';
        $idPraticien='';
        $idUtilisateur=$_GET['idUtilisateur'];
        $email=$_GET['email'];
        $Titre='Création de compte';
        $soustitre="Etape 2 / 2";
        $adresseTraite='/cabinet/account/new/etape2R';
    }else{
        require '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'loggedToObjects.php';
        $adresseTraite='/cabinet/account/modify/update';
        if($_SESSION['type']==3)$adresseTraite='/cabinet/admin/fiche/update?idPatient='.$_GET['idPatient'];
        $Titre='Modification de compte';
        $soustitre="";
        if(isset($_GET['idPatient'])){
            $patient=$patientDAO->get($_GET['idPatient']);
            $email=$patient->getEmail();
            $idUtilisateur=$patient->getIdUtilisateur();
            $idPraticien=$patient->getIdPraticien();
        }
    }
    if (!empty($patient)){
        $nom=$patient->getNom();
        $prenom=$patient->getPrenom();
        $dateNaissance=$patient->getDateNaissance();
        $voie=$patient->getVoie();
        $cp=$patient->getcp();
        $ville=$patient->getVille();
        $telephone=$patient->getTelephone();
        $idPatient=$patient->getIdPatient();
        
    }
?>

<div id="formEtape2" class="d-flex flex-column align-items-center w-100">
    <h1> <?=$Titre?> </h1>
    <h2> <?=$soustitre?></h2>
    <form  class="d-flex flex-column" method='post' action='<?= $adresseTraite ?>' >
        <div class="form-group d-flex flex-row justify-content-between">
            <label for="nom">Nom:</label>
            <input required type="text" name="nom" value="<?= $nom?>">
        </div>
        <div class="form-group d-flex flex-row justify-content-between">
            <label for="prenom">Prenom:</label>
            <input required type="text" name="prenom" value="<?= $prenom?>">
        </div>
        <div class="form-group d-flex flex-row justify-content-between">
            <label for="dateNaissance">Date de Naissance:</label>
            <input required type="date" name="dateNaissance" value="<?= $dateNaissance?>">
        </div>
        <div class="form-group d-flex flex-row justify-content-between">
            <label for="voie">Voie:</label>
            <input required type="text" name="voie" value="<?= $voie ?>">
        </div>
        <div class="form-group d-flex flex-row justify-content-between">
            <label for="cp">Code Postal:</label>
            <input required type="text" name="cp" value="<?= $cp?>">
        </div>
        <div class="form-group d-flex flex-row justify-content-between">
            <label for="ville">Ville:</label>
            <input required type="text" name="ville" value="<?= $ville?>">
        </div>
        <div class="mb-5 form-group d-flex flex-row justify-content-between">
            <label for="telephone">Téléphone:</label>
            <input required type="text" name="telephone" value="<?= $telephone?>">
        </div>
        <div class="form-group d-flex flex-row justify-content-between">
            <input type="hidden" value= "<?=$email?>" name="email">
            <input type="hidden" name="idUtilisateur" value= "<?=$idUtilisateur?>">
            <input type="hidden" name="idPraticien" value= "<?=$idPraticien?>">
            <?php if(!empty($patient)): ?>
            <input type="hidden" value= "<?=$idPatient?>" name="idPatient">
            <?php endif;?>
        </div>
        <div class="d-flex flex-row justify-content-end align-items-end" style="width:100%">
            <?php if(isset($_GET['email'])): ?>
                <a href="/cabinet/account/new/abort?idUtilisateur=<?=$idUtilisateur?>&email=<?=$email?>" class="px-3">Passer cette étape </a>
            <?php endif; ?>
                <button type="submit" class ="btn btn-primary px-5">Suivant</button>
        </div>
    </form>
</div>