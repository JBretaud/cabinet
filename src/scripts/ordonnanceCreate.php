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
            $data['nolig']=$key;
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
    $ajd=new DateTime();
    $attributes['dateOrdonnance']=$ajd->format('Y-m-d');
    
    if(isset($_SESSION['idOrdonnance'])&&!empty($_SESSION['idOrdonnance'])){
        $attributes['idOrdonnance']=$_SESSION['idOrdonnance'];
    }
    $ordonnance=new Ordonnance($attributes);
    // var_dump($ordonnance);
    if(!isset($_SESSION['idOrdonnance'])){
        $ordonnanceDAO->create($ordonnance);
    }else{
        // var_dump($ordonnance);
        $ordonnanceDAO->update($ordonnance);
    }

    $gets='';
    
    
        foreach($_POST as $key=>$value){
            if(strpos($key, "Medicament") !== false && !empty($value['idMedicament'])){
                $Med=$medDAO->get($value['idMedicament']);
                $nom=$Med->getNom();
                $posologie=$value['posologie'];
                $gets.="&{$key}[nom]={$nom}&{$key}[posologie]={$posologie}";
            }
        }
    
    (isset($_POST['apercu'])) ? $button='&button=apercu' : ((isset($_POST['dl'])) ? $button='&button=dl' :$button='');
    header('Location: /cabinet/ordonnance/display?idPatient='.$_GET['idPatient'].$gets.$button);
    exit();