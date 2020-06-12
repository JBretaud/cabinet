<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
    $rdvDAO=new rdvDAO($pdo);
    try{
        $rdv=$rdvDAO->get($_GET['idRdv']);
    }catch(\Exception $e){
        $rdv=null;
    }
    
    try{
        $rdvDAO->delete($rdv);
        header("Location: /cabinet/accueil?alert=deleteRdv");
        exit();
    }catch(\Exception $e){
        if($_SESSION['type']===1){
            $address="Location: /cabinet/patient/rdv/display?idRdv=".$_GET['idRdv']."&alert=deleteRdvFail";
        }elseif($_SESSION['type']===2){
            $address="Location: /cabinet/praticien/rdv/display?idRdv=".$_GET['idRdv']."&alert=deleteRdvFail";
        }elseif($_SESSION['type']===3){
            $address="Location: /cabinet/secretaire/rdv/display?idRdv=".$_GET['idRdv']."&alert=deleteFail";
        }
        header($address);
        exit();
    
    }
?>
    