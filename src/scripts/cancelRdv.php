<?php
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'rdvDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Rdv.php';
    $rdvDAO=new rdvDAO($pdo);
    try{
        $rdv=$rdvDAO->get($_GET['idRdv']);
    }catch(\Exception $e){
        $rdv=null;
    }
    var_dump($rdv);
    try{
        $rdvDAO->delete($rdv);
        header("Location: /cabinet/accueil?alert=deleteRdv");
        exit();
    }catch(\Exception $e){
        if($_SESSION['type']===1){
            $address="Location: /cabinet/patient/rdv/display?idRdv=".$rdv->getIdRdv()."&alert=deleteRdvFail";
        }elseif($_SESSION['type']===2){
            $address="Location: /cabinet/praticien/rdv/display?idRdv=".$rdv->getIdRdv()."&alert=deleteRdvFail";
        }elseif($_SESSION['type']===3){
            $address="Location: /cabinet/admin/rdv/display?idRdv=".$rdv->getIdRdv()."&alert=deleteFail";
        }
        header($address);
        exit();
    }
?>
    