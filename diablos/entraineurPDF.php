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
    $this->Cell(0,10,utf8_decode('Liste des entraîneurs'.' - '.date('Y/m/d')) ,1,1,'C');
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
$requete = "select nom, prenom, type, no_embauche from personnes p, entraineurs e where e.id_personne=p.id_personne";
$pdf->AddCol('nom',50,utf8_decode('Nom'),'L');
$pdf->AddCol('prenom',50,utf8_decode('Prénom'),'L');
$pdf->AddCol('type',50,'Type','L');
$pdf->AddCol('no_embauche',50,'# embauche','L');

$pdf->Table($requete);



// sortie du fichier
$pdf->Output('liste_entraineurs.pdf', 'I');
?>