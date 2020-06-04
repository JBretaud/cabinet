<?php

    

require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'FPDF'.DIRECTORY_SEPARATOR.'fpdf.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'OrdonnancePDF.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
$patientDAO=new patientDAO($pdo);
$patient=$patientDAO->get($_GET['idPatient']);
$praticienDAO=new praticienDAO($pdo);
$praticien=$praticienDAO->get($_SESSION['idPraticien']);
$gets='';
foreach($_GET as $key=>$value){
    
    if(strpos($key, "Medicament") !== false && !empty($value['nom'])){
        $gets.="&{$key}[nom]={$value['nom']}&{$key}[posologie]={$value['posologie']}";
    }
}

$file=new OrdonnancePDF();
if(isset($_GET['button'])){
    if($_GET['button']==='apercu'){
        $file->pdfEdit(false);
    }else{
        if(isset($_SESSION['idOrdonnance'])) unset($_SESSION['idOrdonnance']);
        
        echo "<script>window.top.location.href = \"/cabinet/praticien/fiche?idPatient=".$_GET['idPatient']."&patient=".$patient->toString()."&praticien=".$praticien->toString().$gets."\";</script>";
    }
}else{
    $file->pdfEdit(false);
}
?>