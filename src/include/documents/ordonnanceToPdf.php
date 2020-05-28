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
    $praticien=$praticienDAO->get($_SESSION['id']);
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
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'PatientDAO.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Patient.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'Objets'.DIRECTORY_SEPARATOR.'Praticien.php';
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.'praticienDAO.php';
include ("..".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."bdd".DIRECTORY_SEPARATOR."bdd.php");
$praticienDAO=new praticienDAO($pdo);
$praticien=$praticienDAO->get($_SESSION['id']);
$patientDAO=new patientDAO($pdo);
$patient=$patientDAO->get($_GET['idPatient']);
$patientPrenom=ucfirst($patient->getPrenom());
$patientNom=strtoupper($patient->getNom());
$months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
$array=explode("-",$patient->getDateNaissance());
$dateNaissance=$array[0].' '.$months[$array[1]-1].' '.$array[2];

$pdf = new PDF('P','mm','A5');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(48,186,190);

$ajd=new DateTime();
$date=$ajd->format('d').' '.$months[$ajd->format('m')-1].' '.$ajd->format('Y');
$pdf->Cell(120,5,'Nantes, le '.$date.',','',1,'R');
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(10,4,'','',0);
$pdf->Cell(0,4,"{$patient->getNom()} {$patient->getPrenom()}",'',1);
$pdf->Cell(10,4,'','',0);
$pdf->Cell(0,4,utf8_decode('Né le : ').$dateNaissance,'',1);
$pdf->ln(4);
for($i=1;$i<=4;$i++){
    $pdf->Cell(15,8,'','',0);
    $pdf->Cell(60,10,'Medicament '.$i.' :','',0);
    
    $pdf->Cell(0,10,'Conseil '.$i,'',1);
}
$pdf->Output();
?>