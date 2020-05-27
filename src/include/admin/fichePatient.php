<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
    $patientDAO=new patientDAO($pdo);
    $praticienDAO=new praticienDAO($pdo);
    $rdvDAO=new rdvDAO($pdo);
    $prochainRdv=$rdvDAO->getNextRdv($_GET['idPatient']);
    if(!empty($prochainRdv)){
        $date=new DateTime($prochainRdv->getStart());
        $heure=$date->format('H:i');
        $praticien=$praticienDAO->get($prochainRdv->getIdPraticien());
        $praticienRdv=$praticien->getPrenom().' '.$praticien->getNom();
    }
    
    $ListePraticiens=$praticienDAO->getListe();
    
    $patient=$patientDAO->get($_GET['idPatient']);
        $nom=strtoupper($patient->getNom());
        $prenom=ucfirst($patient->getPrenom());
        $dateNaissance_Array=explode("-",$patient->getDateNaissance());
        $dateNaissanceMeF=$dateNaissance_Array[2]."/".$dateNaissance_Array[1]."/".$dateNaissance_Array[0];
        $dateNaissance=$patient->getDateNaissance();
        $voie=$patient->getVoie();
        $cp=$patient->getcp();
        $ville=ucfirst($patient->getVille());
        $email=$patient->getEmail();
        $telephone=$patient->getTelephone();
        $telephoneMeF=$telephone;
        if($path[0]!='account'){
            if (strlen($telephone)==10){
                $pos=[8,6,4,2];
                foreach($pos as $i){
                    $telephoneMeF=substr_replace($telephoneMeF,".",$i,0);
                }
            }
        }
        $idPatient=$patient->getIdPatient();
        $idPraticien=$patient->getIdPraticien();
        $idUtilisateur=$patient->getIdUtilisateur();
        $emailf="<a href='mailto:".$email."'>".$email."</a>";
        if(!empty($idPraticien)){
            $praticien=$praticienDAO->get($idPraticien);
        }
        if(empty($nom))$nom="<a href='/cabinet/account/modify?idPatient=".$idPatient."'>Renseigner le nom</a>";
        if(empty($prenom))$prenom="<a href='/cabinet/account/modify?idPatient=".$idPatient."'>Renseigner le prénom</a>";
        if(empty($dateNaissance))$dateNaissance="<a href='/cabinet/account/modify?idPatient=".$idPatient."'>Renseigner la date de naissance</a>";
        if(empty($voie))$voie="<a href='/cabinet/account/modify?idPatient=".$idPatient."'>Renseigner la voie</a>";
        if(empty($cp))$cp="<a href='/cabinet/account/modify?idPatient=".$idPatient."'>Renseigner le code postal</a>";
        if(empty($ville))$ville="<a href='/cabinet/account/modify?idPatient=".$idPatient."'>Renseigner la ville</a>";
        if(empty($email))$emailf="<a href='/cabinet/account/modify?idPatient=".$idPatient."'>Renseigner l'email</a>";
        if(empty($telephone))$telephone="<a href='/cabinet/account/modify?idPatient=".$idPatient."'>Renseigner un numéro de téléphone</a>";
        if(!empty($idPraticien)){
            $cheminImgProfil=$praticien->getCheminPhoto();
        }else{
            $cheminImgProfil="../src/img/profileVide.jpg";
        }
    ?>
    <div id="profile" class="container mt-5">
        <div class="row">
            <div class="col-5">
                <div class="row">
                    <div class="col-12 d-flex flex-column align-items-center">
                        <h1> Données Patient </h1>
                        <img class="separator" src='/cabinet/src/img/separator.png'>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex flex-column align-items-center">
                        <h2>Coordonnées :</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5"><p> Nom :</p></div>
                    <div class="col-7"><p> <?=$nom?></p></div>
                </div>
                <div class="row">
                    <div class="col-5"><p> Prenom :</p></div>
                    <div class="col-7"><p> <?=$prenom?></p></div>
                </div>
                <div class="row">
                    <div class="col-5"><p> Né(e) le :</p></div>
                    <div class="col-7"><p> <?=$dateNaissanceMeF?></p></div>
                </div>
                <div class="row">
                    <div class="col-5"><p> Voie :</p></div>
                    <div class="col-7"><p> <?=$voie?></p></div>
                </div>
                <div class="row">
                    <div class="col-5"><p> Code Postal :</p></div>
                    <div class="col-7"><p> <?=$cp?></p></div>
                </div>
                <div class="row">
                    <div class="col-5"><p> Ville :</p></div>
                    <div class="col-7"><p> <?=$ville?></p></div>
                </div>
                <div class="row">
                    <div class="col-12">
                    <?php if(!empty($prenom)&&!empty($nom)&&!empty($voie)&&!empty($cp)&&!empty($ville)): ?>
                        <div class="link-group">
                            <p><a href="/cabinet/account/modify?idPatient=<?= $idPatient ?>">Modifier les coordonnées</a></p>
                            <img src='/cabinet/src/img/highlight.png'>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex flex-column align-items-center">
                        <h2>Contacts : </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5"><p>Téléphone :</p></div>
                    <div class="col-7"><p><?=$telephoneMeF?></p></div>
                </div>
                <div class="row">
                    <div class="col-5"><p>Adresse email :</p></div>
                    <div class="col-7"><p><?=$emailf?></p></div>
                </div>
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="d-flex flex-column align-items-center col-12">
                        <h1>Suivi Médical</h1>
                        <img class="separator" src='/cabinet/src/img/separator.png'>
                    </div>
                </div>
                <div class="row">
                
                    <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                        <img src="<?= $cheminImgProfil?>" class="photoProfil">
                    </div>
                    <div class="col-4 p-0 d-flex flex-column align-items-center justify-content-center">
                    <?php if(!empty($patient->getIdPraticien())):?>
                        <h3 class="mb-1">Dr. <?=$praticien->getPrenom().' '.$praticien->getNom()?></h3>
                        <p><a href="mailto:<?=$praticien->getEmail()?>">- Contacter -</a></p>
                        <?php else:?>
                    <div class="suivi d-flex flex-column justify-content-center align-items-center">
                        <h3>Ce patient ne bénéficie pas d'un suivi</h3>
                        <a v-if="!show_choixMed" @click.prevent="toggleChoixMed">- Déclarer un médecin référent -</a>
                        <div v-if="show_choixMed">
                            <form action="/cabinet/<?= ($path[0]==="praticien" && $_SESSION['type']===2) ? "praticien" : "admin"?>/fiche/update" method='post'>
                                <select name="idPraticien">
                                    <?php foreach($ListePraticiens as $praticien):?>
                                    <option value=<?=$praticien->getIdPraticien()?>><?=$praticien->getPrenom().' '.$praticien->getNom()?></option>
                                    <?php endforeach;?>
                                </select>
                                <input type="hidden" name="idPatient" value= "<?=$idPatient?>">
                                <input type="hidden" name="nom" value= "<?=$nom?>">
                                <input type="hidden" name="prenom" value= "<?=$prenom?>">
                                <input type="hidden" name="dateNaissance" value= "<?=$dateNaissance?>">
                                <input type="hidden" name="voie" value= "<?=$voie?>">
                                <input type="hidden" name="cp" value= "<?=$cp?>">
                                <input type="hidden" name="ville" value= "<?=$ville?>">
                                <input type="hidden" name="email" value= "<?=$email?>">
                                <input type="hidden" name="idUtilisateur" value= "<?=$idUtilisateur?>">
                                <input type="hidden" name="telephone" value= "<?=$telephone?>">
                                <button class="btn btn-primary" type="submit">Déclarer</button>
                            </form>
                        </div>
                    </div>
                <?php endif;?>
                    </div>
                    <div class="col-2">

                    </div>
                
                </div>
                <div class="row">
                <?php if(!empty($prochainRdv)):?>
                    <div class="col-12 pt-5 d-flex flex-column justify-content-start align-items-center">
                        <h2 class="mb-2">Prochain Rendez-vous :</h2>
                        <p>Le <?=$prochainRdv->getDate()." à ".$heure."<br>avec Dr.". $praticienRdv?></p>
                        <a href="/cabinet/<?= ($path[0]==="praticient" && $_SESSION['type']===2) ? "praticien" : "admin"?>/rdv/new?idPatient=<?=$idPatient?>">- Réserver un rendez-vous -</a>
                    </div>
                    <?php else: ?>
                    <div class="col-12 pt-5 d-flex flex-column justify-content-start align-items-center">
                        <h2 >Prochain rendez-vous :</h2>
                        <h3>Pas de rendez-vous programmé</h3>
                        <div class="link-group">
                            <a href="/cabinet/<?= ($path[0]==="praticient" && $_SESSION['type']===2) ? "praticien" : "admin"?>/rdv/new?idPatient=<?=$idPatient?>">Réserver un créneau</a>
                            <img src='/cabinet/src/img/highlight.png'>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-12 mt-4 d-flex flex-column align-items-center">
                        <h1>Documents:</h1>
                        <img class="separator" src='/cabinet/src/img/separator.png'>
                    </div>
                </div>
            </div>
        </div>

    </div>

        
        
        
