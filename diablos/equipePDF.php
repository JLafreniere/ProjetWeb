<?php
@ob_start();
session_start();
require_once ("Connexion/Connect.php");
require_once ("Connexion/Connexion.php");
require_once ("Connexion/ExecRequete.php");
require('fpdf/mysql_table.php');
//Date et heure Montréal
setlocale(LC_ALL, 'french-canadian');
date_default_timezone_set('America/Montreal');

class PDF extends PDF_MySQL_Table
{
function Header()
{
    //Title
	if ($this->PageNo() == 1){
    $this->SetFont('Arial','',18);
	$this->Image('Images/diablos.png',null,null,70,20);
    $this->Cell(0,10,utf8_decode('Liste des équipes'.' - '.date('Y/m/d')) ,1,1,'C');
    $this->Ln(10);
    //Ensure table header is output
    parent::Header();
	}
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}                 '.date('Y-m-d H:i'),0,0,'R');
}

}

// création du pdf
$pdf=new PDF();
$pdf->AddPage('L','Legal');
$pdf->AliasNBPages();


// requête
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_select_db($connexion,'diablos'); //$sport     = $_POST['sport'];
$requete = "select nom, sexe, saison  from equipes where extract(year from str_to_date(substring(saison,1,4),'%Y')) <= extract(year from now())";
$pdf->AddCol('nom',80,utf8_decode('Nom'),'L');
$pdf->AddCol('sexe',10,utf8_decode('Sexe'),'L');
$pdf->AddCol('saison',40,'Saison','L');


$pdf->Table($requete);



// sortie du fichier
$pdf->Output('liste_equipes.pdf', 'I');
?>