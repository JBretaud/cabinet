<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'User.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'idDAO.php';
    $patient=new Patient($_POST);
    $userDAO=new idDAO($pdo);
    $user=$userDAO->get($_POST['idUtilisateur'],null);
    if (empty($user->getIdPatient())){
        $patientDAO=new patientDAO($pdo);
        $patientDAO->create($patient);
        $idPatient=$patientDAO->getId($patient);
        $user->setIdPatient($idPatient);
        $userDAO->update($user);
    }else{
        header('Location: /cabinet/account/new/error');
        exit();
    }
    
    
    header('Location: /cabinet/account/new/complete');
    exit();
?>