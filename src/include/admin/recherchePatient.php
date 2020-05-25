<?php
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
$patientDAO=new patientDAO($pdo);
$ListePatients=$patientDAO->getListe();
?>
<div id="recherche" class="d-flex flex-column align-items-center" style="width:100%">
    <div class="d-flex flex-column align-items-center">
        <h1> Recherche Patient </h1>
        <img class="separator" src='/cabinet/src/img/separator.png'>
    <div>
    <div class="d-flex flex-row justify-content-center">
        <div class="d-flex flex-column align-items-center mr-2">
            <label for="nom">Nom</label>
            <input type="text" name="nom" v-model="nom">
        </div>
        <div class="d-flex flex-column align-items-center">
            <label for="prenom">Prenom</label>
            <input type="text" name="prenom" v-model="prenom">
        </div>
    </div>
    <div class="d-flex flex-column align-items-center">
        <ul>
            <!-- Render a li element for every entry in the computed filteredArticles array. -->
                
            <li v-for="patient in filteredPatients" class="my-2">
                <a v-bind:href="'/cabinet/admin/fiche?idPatient='+ patient.idPatient" class="d-flex flex-column justify-content-around align-items-center">
                    <p class="nom"><span>{{patient.nom}}</span> {{patient.prenom}}</p>
                    <p class="naissance mb-2">{{patient.dateNaissance}}</p>
                    <div class="px-2" style="text-align:center">
                        <p>{{patient.voie}}</p>
                        <p class="mb-1">{{patient.cp}} {{patient.ville}}</p>
                    </div>
                    
                </a>
                
            </li>
        </ul>
    </div>
</div>
