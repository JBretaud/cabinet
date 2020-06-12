<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Ordonnance.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ordonnanceDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'LigneOrdonnance.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ligneOrdonnanceDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Med.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'medDAO.php';
    $patientDAO=new patientDAO($pdo);
    $praticienDAO=new praticienDAO($pdo);
    $rdvDAO=new rdvDAO($pdo);
    $ordonnanceDAO=new ordonnanceDAO($pdo);
    $ligneOrdonnanceDAO=new ligneOrdonnanceDAO($pdo);
    $medDAO=new medDAO($pdo);
    $months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    
    if ($path[0]==='patient'){
        require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'loggedToObjects.php';
    }else{
        $idPatient=$_GET['idPatient'];
        $patient=$patientDAO->get($idPatient);
        $nom=strtoupper($patient->getNom());
        $prenom=ucfirst($patient->getPrenom());
        $dateNaissance=$patient->getDateNaissance();
        $voie=$patient->getVoie();
        $cp=$patient->getcp();
        $ville=ucfirst($patient->getVille());
        $email=$patient->getEmail();
        $telephone=$patient->getTelephone();
        $telephoneMeF=$telephone;        
        $idPraticien=$patient->getIdPraticien();
        $idUtilisateur=$patient->getIdUtilisateur();
        $emailf="<a href='mailto:".$email."'>".$email."</a>";
    }
    if(!empty($idPraticien)){
        $praticien=$praticienDAO->get($idPraticien);
    }
    if(!empty($idPraticien)){
        $cheminImgProfil=$praticien->getCheminPhoto();
    }else{
        $cheminImgProfil="../src/img/profileVide.jpg";
    }
    $ListePraticiens=$praticienDAO->getListe();
    $ListeRdv=$rdvDAO->getPatient($idPatient);
    $ListeOrdonnance=$ordonnanceDAO->getPatient($idPatient);
    $prochainRdv=$rdvDAO->getNextRdv($idPatient);
    if(!empty($prochainRdv)){
        $date=new DateTime($prochainRdv->getStart());
        $heure=$date->format('H:i');
        $praticien=$praticienDAO->get($prochainRdv->getIdPraticien());
        $praticienRdv=$praticien->getPrenom().' '.$praticien->getNom();
    }
    
    ?>
    <div id="profile" class="container mt-5">
        <div class="row">
            <div class="frame col-xl-12">
                <div class="row">
                    <div class="title col-12">
                        <h1>Données Patient</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="subtitle col-12">
                        <h2>Compte</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="content col-12">
                        <div class="row d-flex flex-row justify-content-center pt-4 pb-2">
                                <a href="/cabinet/account/mdpchange" class="w-75 btn btn-primary">MODIFIER LE MOT DE PASSE</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="subtitle col-12">
                        <h2>Contacts</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="content col-12">
                        <form method="post" action="/cabinet/<?= $path[0] ?>/<?= $path[1] ?>/update<?=($path[0]==='patient') ? "" : "?idPatient={$idPatient}"?>">
                            <input type="hidden" name="nom" value="<?=$nom?>">
                            <input type="hidden" name="prenom" value="<?=$prenom?>">
                            <input type="hidden" name="dateNaissance" value="<?=$dateNaissance?>">
                            <input type="hidden" name="voie" value="<?=$voie?>">
                            <input type="hidden" name="cp" value="<?=$cp?>">
                            <input type="hidden" name="ville" value="<?=$ville?>">
                            <input type="hidden" name="idPraticien" value="<?=$idPraticien?>">
                            <input type="hidden" name="idPatient" value="<?=$idPatient?>">
                            <input type="hidden" name="idUtilisateur" value="<?=$idUtilisateur?>">
                            <div class="row">
                                <label class="col-3"><p>Téléphone :</p></label>
                                <input type="text" name="telephone" class="col-9 form-control" value=<?=$telephone?>></input>
                            </div>
                            <div class="row">
                                <label class="col-3"><p>Adresse email :</p></label>
                                <input class="form-control col-9" name="email" value="<?=$email?>">
                            </div>
                            <div class="row d-flex flex-row justify-content-center pt-4 pb-2">
                                <button type="submit" class="btn btn-primary w-75">ENREGISTRER</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="row">
                    <div class="subtitle col-12">
                        <h2>Coordonnées</h2>
                    </div>
                </div>
                <div class="row">
                
                    <div class="content col-12">
                        <form method="post" action="/cabinet/<?= $path[0] ?>/<?= $path[1] ?>/update<?=($path[0]==='patient') ? "" : "?idPatient={$idPatient}"?>">
                            <input type="hidden" name='email' value="<?=$email?>">
                            <input type="hidden" name='telephone' value="<?=$telephone?>">
                            <input type="hidden" name="idPraticien" value="<?=$idPraticien?>">
                            <input type="hidden" name="idPatient" value="<?=$idPatient?>">
                            <input type="hidden" name="idUtilisateur" value="<?=$idUtilisateur?>">
                            <div class="row">
                                <label class="col-3"><p> Nom :</p></label>
                                <input type="text" class="form-control col-9" name="nom" value="<?=$nom?>">
                            </div>
                            <div class="row">
                                <label class="col-3"><p> Prenom :</p></label>
                                <input type="text" class="form-control col-9" name="prenom" value="<?=$prenom?>">
                            </div>
                            <div class="row">
                                <label class="col-3"><p> Date de Naissance :</p></label>
                                <input type="date" class="form-control col-9" name="dateNaissance" value="<?=$dateNaissance?>">
                            </div>
                            <div class="row">
                                <label class="col-3"><p> N° et Voie :</p></label>
                                <input type="text" class="form-control col-9" name="voie" value="<?=$voie?>">
                            </div>
                            <div class="row">
                                <label class="col-3"><p> Code Postal :</p></label>
                                <input type="text" class="form-control col-9" name="cp" value="<?=$cp?>">
                            </div>
                            <div class="row">
                                <label class="col-3"><p> Ville :</p></label>
                                <input type="text" class="form-control col-9" name="ville" value="<?=$ville?>">
                            </div>
                            <div class="row d-flex flex-row justify-content-center pt-4 pb-2">
                                <button type="submit" class="btn btn-primary w-75">ENREGISTRER</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex flex-row justify-content-around">
            <div class="col-xl-5">
                <div class="row">
                    <div class="col-12 frame">
                        <div class="row">
                            <div class="title L col-12">
                                <h1>Suivi</h1>
                            </div>
                            
                        </div>
                    
                        <div class="row pt-3">
                            
                                <div class="col-4 d-flex flex-column justify-content-center align-items-end">
                                    <img src="<?= $cheminImgProfil?>" class="photoProfil">
                                </div>
                                <div class="col-6 p-0 d-flex flex-column align-items-center justify-content-center">
                            <?php if(!empty($patient->getIdPraticien())):?>
                                <p class="mb-3" style="font-size:1.2em">Dr. <?=$praticien->getPrenom().' '.$praticien->getNom()?></p>
                                <?= (intval($_SESSION['type'])===2) ? "" : "<p><a href=\"mailto:{$praticien->getEmail()}\">- Contacter -</a></p>"; ?>
                                <div class="row">
                                    <div class="suivi col-12">
                                        <a v-if="!show_choixMed" @click.prevent="toggleChoixMed" class="btn btn-primary">MODIFIER LE MEDECIN REFERENT</a>
                                        <div v-if="show_choixMed">
                                            
                                            <form action="/cabinet/<?=$path[0]?>/<?= $path[1] ?>/update" method='post'>
                                                <select name="idPraticien" class="form-control mb-2">
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
                                                <button class="btn btn-primary w-100" type="submit">Déclarer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php else:?>
                            <div class="suivi d-flex flex-column justify-content-center align-items-center">
                                <p class="mb-1 text-center" style="font-size:1.2em">Ce patient ne bénéficie pas d'un suivi</p>
                                <a v-if="!show_choixMed" @click.prevent="toggleChoixMed" class="btn btn-primary">Déclarer un médecin référent</a>
                                <div v-if="show_choixMed">
                                    <form action="/cabinet/<?= $path[0] ?>/<?= $path[1] ?>/update" method='post'>
                                        <select name="idPraticien" class="form-control mb-2">
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
                                        <button class="btn btn-primary w-100" type="submit">Déclarer</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif;?>
                                </div>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="frame col-12">
                        <div class="row">
                            <div class="title L col-12 mb-4">
                                <h1>Documents</h1>
                            </div>
                        </div>
                    <?php if(empty($ListeOrdonnance)): ?>
                        <div class="row">
                            <div class="content col-12">
                                <p><b>Pas d'ordonnance enregistrée...</b></p>
                            </div>
                        </div>
                    <?php else:?>
                    <?php for($i=0;$i<5;$i++):
                        if(isset($ListeOrdonnance[$i])):
                        $ordonnance=$ListeOrdonnance[$i];
                        $pratOrdo=$praticienDAO->get($ordonnance->getIdPraticien());
                        $ordonnance=$ListeOrdonnance[$i];
                        $ArrayDateOrdo=explode("-",$ordonnance->getDateOrdonnance());
                        $DateOrdo=$ArrayDateOrdo[2]." ".$months[intval($ArrayDateOrdo[1])]." ".$ArrayDateOrdo[0];
                        ?>
                        <div class="row my-2 d-flex flex-column align-items-center ">
                            <div class="col-10 d-flex flex-column align-items-center ordo">
                                <div id="titreOrdo<?=$i?>" class="py-2 titreOrdo w-100 text-center">
                                    Ordonnance : <?=$DateOrdo?>
                                </div>
                                <div id="contenuOrdo<?=$i?>" class="w-100 p-3 contenuOrdo" style="display:none;">
                                    <p> Praticien : Dr. <?=$pratOrdo->getPrenom()." ".$pratOrdo->getNom()?> </p>
                                    <?php 
                                    if(!empty($ordonnance->getLignes())):
                                        foreach($ordonnance->getLignes() as $ligne):
                                            
                                         $med=$medDAO->get($ligne->getIdMedicament())?>
                                        <p> <?=$med->getNom()?> : <?= $ligne->getPosologie()?> </p>
                                        <?php endforeach;
                                    endif;?>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php endfor;?>
                    <?php endif; ?>
                    <?php if($_SESSION['type']===2):?>
                        <a class="btn btn-primary w-100" href="/cabinet/praticien/ordonnance/new?idPatient=<?=$idPatient?>">EDITER UNE ORDONNANCE</a>
                    <?php endif;?> 
                    </div>
                    
                </div>
            </div>
        
            <div class="col-xl-5">
                <div class="row">
                    <div class="col-12 frame mb-5" style="padding-bottom:0">
                        <div class="row">
                            <div class="title col-12">
                                <h1>Rendez-vous</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 content">
                                <div class="row">
                                    <div class="col-12 subframe" style="padding-bottom:0">
                                        <div class="row">
                                            <div class="subtitle col-12">
                                                <h3>Prochain Rendez-vous</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="content col-12">
                                            <?php if(!empty($prochainRdv)):?>
                                            <div class="col-12 pt-5 d-flex flex-column justify-content-start align-items-center">
                                                <p>Le <?=$prochainRdv->getDate()." à ".$heure."<br>avec Dr.". $praticienRdv?></p>
                                                <a class="btn btn-primary w-100" href="/cabinet/<?= ($path[0]==="praticien" && $_SESSION['type']===2) ? "praticien" : "secretaire"?>/rdv/new?idPatient=<?=$idPatient?>">PRENDRE RENDEZ-VOUS</a>
                                            </div>
                                            <?php else: ?>
                                                <p class="text-center"><b>Pas de rendez-vous programmé</b></p>
                                                <a class="btn btn-primary w-100" href="/cabinet/<?= ($path[0]==="praticien" && $_SESSION['type']===2) ? "praticien" : "secretaire"?>/rdv/new?idPatient=<?=$idPatient?>">PRENDRE RENDEZ-VOUS</a>
                                                
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                    
                    
                
                                <div class="row">
                                    <div class="col-12 subframe mt-3" style="padding-bottom:0">
                                        <div class="row">
                                            <div class="subtitle col-12">
                                                <h3>Rendez-vous passés</h3>
                                            </div>
                                        </div>
                                    
                                <?php for($i=0;$i<3;$i++):
                                    if(isset($ListeRdv[$i])):
                                        $StartArray=explode(' ',$ListeRdv[$i]->getStart());
                                        $DateArray=explode('-',$StartArray[0]);
                                        $HourArray=explode(':',$StartArray[1]);
                                        $Hour=$HourArray[0]."h".$HourArray[1];
                                        $DateRdv=$DateArray[2]." ".$months[intval($DateArray[1])]." ".$DateArray[0];
                                        $pratRdv=$praticienDAO->get($ListeRdv[$i]->getIdPraticien());
                                        ?>
                                        <div class="row d-flex flex-row justify-content-center">
                                            <div class="col-11 " style="padding-bottom:0">
                                                <div class="row">
                                                    <div class="subsubtitle mt-2 col-12">
                                                        <p style="font-size:1.1em;"><b><?=$DateRdv." - ".$Hour."</b> : Dr. ".$pratRdv->getNom()." ".$pratRdv->getPrenom()?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                <?php endfor; ?>
                                    <div class="row d-flex flex-row justify-content-center">
                                        <div class="col-11 mb-2" style="padding-bottom:0">
                                            <div class="row">
                                                <a class="btn btn-primary w-100">... PLUS DE RENDEZ-VOUS ...</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>


        
        
        
