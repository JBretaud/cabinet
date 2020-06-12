<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
    
    $rdvDAO=new rdvDAO($pdo);
    $rdv=new Rdv($_POST);
    try{
        $rdvDAO->delete($rdv);
        header("Location: /cabinet/accueil?alert=updateRdv");
        exit();
    }catch(\Exception $e){
        if($_SESSION['type']===1){
            $address="Location: /cabinet/patient/rdv/modify?idRdv=".$rdv->getIdRdv()."&alert=updateRdvFail";
        }elseif($_SESSION['type']===2){
            $address="Location: /cabinet/praticien/rdv/modify?idRdv=".$rdv->getIdRdv()."&alert=deleteRdvFail";
        }elseif($_SESSION['type']===3){
            $address="Location: /cabinet/secretaire/rdv/modify?idRdv=".$rdv->getIdRdv()."&alert=deleteRdvFail";
        }
        header($address);
        exit();
    }
?>
    