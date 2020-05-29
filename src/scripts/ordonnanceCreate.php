<?php

    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ordonnanceDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Ordonnance.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'LigneOrdonnance.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'ligneOrdonnanceDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Med.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'medDAO.php';
    $ordonnanceDAO=new ordonnanceDAO($pdo);
    $medDAO=new medDAO($pdo);
    $lignes=[];
    $attributes=[];
    foreach($_POST as $key=>$value){
        
        if(strpos($key, "Medicament") !== false){
            
            $data['idMedicament']=$value['idMedicament'];
            $data['posologie']=$value['posologie'];
            $Med=$medDAO->get($value['idMedicament']);
            $data['idPraticien']=$_SESSION['idPraticien'];
            array_push($lignes,new LigneOrdonnance($data));
        }
    }
    $attributes['idPraticien']=$_SESSION['idPraticien'];
    $attributes['idPatient']=$_GET['idPatient'];
    $attributes['lignes']=$lignes;
    $ordonnance=new Ordonnance($attributes);
    $ordonnanceDAO->create($ordonnance);
    
    $gets='';
    foreach($_POST as $key=>$value){
        if(strpos($key, "Medicament") !== false){
            $Med=$medDAO->get($value['idMedicament']);
            $nom=$Med->getNom();
            $posologie=$value['posologie'];
            $gets.="&{$key}[nom]={$nom}&{$key}[posologie]={$posologie}";
        }
    }
    //  header('Location: /cabinet/ordonnance/display?idPatient='.$_GET['idPatient'].$gets);
    //  exit();