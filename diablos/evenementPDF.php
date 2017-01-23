<?php
@ob_start();
 
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
    $this->Cell(0,10,utf8_decode('Liste des évènements'.' - '.date('Y/m/d')) ,1,1,'C');
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
//$pdf->SetTitle(utf8_decode('Liste des évènements'));
$pdf->AliasNBPages();


// requête
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_select_db($connexion,'diablos'); //$sport     = $_POST['sport'];
if ($_POST['dateDebutPDF'] <> "" && $_POST['dateFinPDF'] <> ""){
if ($_POST['sport'] <> "-Sport-"){
$requete = "select date, time_format(heure,'%H:%i') as heure, equipeReceveur, equipeVisiteur, endroit, (select t.nom from transporteur t where t.id = e.idTransport) as nom ,(select e.nom from endroit_sejour e where e.id = e.idSejour) as sejour from evenement e where date between cast('".$_POST['dateDebutPDF']."' as date) and cast('".$_POST['dateFinPDF']."' as date) and idSport = ".$_POST['sport']." order by date desc";
}else
$requete = "select date, time_format(heure,'%H:%i') as heure, equipeReceveur, equipeVisiteur, endroit, (select t.nom from transporteur t where t.id = e.idTransport) as nom ,(select e.nom from endroit_sejour e where e.id = e.idSejour) as sejour from evenement e where date between cast('".$_POST['dateDebutPDF']."' as date) and cast('".$_POST['dateFinPDF']."' as date) order by date desc";
} else if ($_POST['sport'] <> "-Sport-"){
$requete = "select date, time_format(heure,'%H:%i') as heure, equipeReceveur, equipeVisiteur, endroit, (select t.nom from transporteur t where t.id = e.idTransport) as nom ,(select e.nom from endroit_sejour e where e.id = e.idSejour) as sejour from evenement e where idSport = ".$_POST['sport']." order by date desc";
}else
$requete = "select date, time_format(heure,'%H:%i') as heure, equipeReceveur, equipeVisiteur, endroit, (select t.nom from transporteur t where t.id = e.idTransport) as nom ,(select e.nom from endroit_sejour e where e.id = e.idSejour) as sejour from evenement e order by date desc";
$pdf->AddCol('date',25,'','L');
$pdf->AddCol('heure',15,'','L');
$pdf->AddCol('equipeReceveur',60,utf8_decode('Équipe locale'),'L');
$pdf->AddCol('equipeVisiteur',60,utf8_decode('Équipe visiteur'),'L');
$pdf->AddCol('endroit',65,'','L');
$pdf->AddCol('nom',60,utf8_decode('Transporteur'),'L');
$pdf->AddCol('sejour',50,utf8_decode('Séjour'),'L');

$pdf->Table($requete);



// sortie du fichier
$pdf->Output('liste_evenements.pdf', 'I');
?>