<?php
    if($path[1]==='modify'){
        $adress='Location: /cabinet/patient/profil?alert=accountUpdated';
    }elseif($path[1]==='new'){
        $adress='Location: /cabinet/accueil?alert=accountUpdated';
    }elseif($path[1]==='profil'&&$path[2]==='update'){
        $adress='Location: /cabinet/patient/profil?alert=accountUpdated';
    }elseif($path[0]=='admin'&&$path[1]=='fiche'&&$path[2]=='update'){
        $adress='Location: /cabinet/admin/fiche?idPatient='.$_POST['idPatient'].'&alert=accountUpdated';
    }elseif($path[0]=='praticien'&&$path[1]=='fiche'&&$path[2]=='update'){
        $adress='Location: /cabinet/praticien/fiche?idPatient='.$_POST['idPatient'].'&alert=accountUpdated';
    }


    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'User.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'idDAO.php';
    
    if(!empty($_POST['idUtilisateur'])){
        $patient=new Patient($_POST);
        $idDAO=new idDAO($pdo);
        $user=$idDAO->get($_POST['idUtilisateur'],null);
        $user->setIdPatient($_POST['idPatient']);
        $idDAO->update($user);
    }else{
        $patient=new Patient($_POST);
    }
    $patientDAO=new patientDAO($pdo);
    $patientDAO->update($patient);
    header($adress);
    exit();