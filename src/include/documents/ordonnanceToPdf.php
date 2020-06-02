<?php

    

require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'FPDF'.DIRECTORY_SEPARATOR.'fpdf.php';

class PDF extends FPDF
{
// Page header
function Header()
{   
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
    require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
    include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
    $praticienDAO=new praticienDAO($pdo);
    $praticien=$praticienDAO->get($_SESSION['idPraticien']);
    $patientDAO=new patientDAO($pdo);
    $patient=$patientDAO->get($_GET['idPatient']);
    $patientPrenom=ucfirst($patient->getPrenom());
    $patientNom=strtoupper($patient->getNom());
    

    $this->SetFont('Arial','',12);
    $this->SetTextColor(48,186,190);
    $this->SetDrawColor(48,186,190);
    $this->Ln(5);
    $this->Cell(5,8,'','',0);
    $this->Cell(25,8,'Dr. '.$praticien->getPrenom().' '.$praticien->getNom(),'',1,'L');
    $this->SetFont('Arial','I',10);
    $this->Cell(5,4,'','',0);
    $this->Cell(0,5,utf8_decode('Médecine Générale'),'',1,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(5,4,'','',0);
    $this->Cell(25,4,utf8_decode('Tel: 02.56.32.65.32'),'',0,'L');
    $this->Cell(55,4,'','',0);
    $this->Cell(35,6,utf8_decode('1, rue de la République'),'',1,'R');
    $this->Cell(85,4,'','',0);
    $this->Cell(35,6,utf8_decode('44000 Nantes'),'',1,'R');    
    $this->Cell(0,7,'','B',1,'L');
    // Logo
    $this->Image('..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'logo_nom.png',95,11,40);
    $chemincode=explode("/",$praticien->getCheminPhoto());
    $cheminsCode=[];
    for($i=1;$i<=2;$i++){
        $chemincodefin="";
        for($j=0;$j<sizeof($chemincode)-1;$j++){
            $chemincodefin.=$chemincode[$j].DIRECTORY_SEPARATOR;
        }

        $chemincodefin.="CB".$i.".jpg";
        array_push($cheminsCode,$chemincodefin);
    }
    
    $this->Image($cheminsCode[0],15,35,20);
    $this->Image($cheminsCode[1],37,35,20);
    $this->ln(10);

}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->SetTextColor(48,186,190);
    $this->SetDrawColor(48,186,190);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}','T',0,'C');
}
}

// Instanciation of inherited class
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
$praticienDAO=new praticienDAO($pdo);
$praticien=$praticienDAO->get($_SESSION['idPraticien']);
$patientDAO=new patientDAO($pdo);
$patient=$patientDAO->get($_GET['idPatient']);
$patientPrenom=ucfirst($patient->getPrenom());
$patientNom=strtoupper($patient->getNom());
$months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
$array=explode("-",$patient->getDateNaissance());
$dateNaissance=$array[2].' '.$months[$array[1]-1].' '.$array[0];
$ListeMeds=[];
foreach($_GET as $key=>$value){
    if(strpos($key, "Medicament") !== false){
        $ListeMeds[$key]=$value;
    }
}




$pdf = new PDF('P','mm','A5');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(48,186,190);

$ajd=new DateTime();
$date=$ajd->format('d').' '.$months[$ajd->format('m')-1].' '.$ajd->format('Y');
$pdf->Cell(120,5,'Nantes, le '.$date.',','',1,'R');

$pdf->SetTextColor(95, 95, 95);
$pdf->SetFont('Arial','B',12);

$pdf->Cell(10,4,'','',0);
$pdf->Cell(0,4,utf8_decode("{$patient->getNom()} {$patient->getPrenom()}"),'',1);
$pdf->Cell(10,4,'','',0);

$pdf->SetFont('Arial','',8);

$pdf->Cell(0,4,utf8_decode('Né le : ').$dateNaissance,'',1);
$pdf->ln(4);
foreach($ListeMeds as $Med){
    $pdf->SetTextColor(95, 95, 95);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(15,8,'','',0);
    $pdf->Cell(30,5,utf8_decode($Med['nom']),'',0);
    $pdf->SetFont('Arial','I',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(0,5,utf8_decode($Med['posologie']));
    $pdf->ln(8);
}
$pdf->Output();
?>