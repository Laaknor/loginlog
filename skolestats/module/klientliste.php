<?php
include_once 'include.php';
$order = mysql_real_escape_string($_GET['order']);
if(!isset($_GET['order'])) $order = 'navn';

if($_GET['kommune'] == 'Notteroy') {
$qKlientListe = query("SELECT * FROM klienter k JOIN groups g ON k.gruppe=g.ID WHERE g.kommune = 'N' ORDER BY $order DESC");

}
elseif ($_GET['kommune'] == 'Tonsberg') {

$qKlientListe = query("SELECT * FROM klienter k JOIN groups g ON k.gruppe=g.ID WHERE g.kommune = 'T' ORDER BY $order DESC");

}

elseif ($_GET['kommune'] == 'Felles') {
$qKlientListe = query("SELECT * FROM klienter k JOIN groups g ON k.gruppe=g.ID WHERE g.kommune = 'U' ORDER BY $order DESC");

}
else { 

$qSkoleID = query("SELECT ID FROM groups WHERE skole = '".$_SESSION['skole']."'");
$rSkoleID = fetch($qSkoleID);

$qKlientListe = query("SELECT * FROM klienter WHERE gruppe = '$rSkoleID->ID' ORDER BY $order DESC");
}


$content .= '<table>';
$content .=  "<tr><th><a href=?module=klientliste&amp;order=navn>Klientnavn</a></th>";
$content .= "<th><a href=?module=klientliste&amp;order=type>Type</a></th>";
$content .= "<th><a href=?module=klientliste&amp;order=lastseen>Sist brukt</a></th>\n\n";
$content .= "<th>Siste image installert</th></tr>\n\n";

while($rKlientListe = fetch($qKlientListe)) {
	$content .= '<tr><td>';
	$content .= $rKlientListe->navn;
	$content .= '</td><td>';
	if($rKlientListe->type == 1) $content .= "Tynnklient";
	elseif($rKlientListe->type == 2) $content .= "PC";
	$content .= '</td><td>';

	$content .= date("H:i d/m", $rKlientListe->lastseen);
	$content .= "</td><td>";
	if($rKlientListe->type == 2) {
		$qLastImage = query("SELECT navn,restoretime FROM images WHERE navn LIKE '".$rKlientListe->navn."'
			ORDER BY restoretime DESC LIMIT 0,1");

		if(num($qLastImage) != 0) {

			$rLastImage = fetch($qLastImage);
			$content .= date("H:i d/m/Y", $rLastImage->restoretime);
		} // end if num(qLastImage != 0)
	} // end if KlientListe->type = 2
	$content .= "</td></tr>";

} // end while

$content .= '</table>';
