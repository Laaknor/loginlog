<?php
include_once 'include.php';
$order = mysql_real_escape_string($_GET['order']);
if(!isset($_GET['order'])) $order = 'navn';
$timelimit = time()-(60*60*24*31); // 31 dager

#$qKlientListe = query("SELECT * FROM klienter WHERE gruppe = '$rSkoleID->ID' ORDER BY $order DESC");
$qKlientListe = query("SELECT k.navn,g.skole,k.lastseen,k.type FROM klienter k JOIN groups g ON k.gruppe=g.ID 
WHERE k.navn NOT LIKE '510-%'
AND k.navn NOT LIKE 'TTVO-%'
AND k.navn NOT LIKE '____-OC%'
AND k.navn NOT LIKE '____-OD%'
AND k.navn NOT REGEXP '....-[A-Z]'
AND k.lastseen > $timelimit
AND g.skole != 'IKT'
ORDER BY $order DESC");


$content .= '<table>';
$content .=  "<tr><th><a href=?module=mistenkelige_klienter&amp;order=navn>Klientnavn</a></th>";
$content .= "<th><a href=?module=mistenkelige_klienter&amp;order=type>Type</a></th>";
$content .= "<th><a href=?module=mistenkelige_klienter&amp;order=lastseen>Sist brukt</a></th>\n\n";
$content .= "<th><a href=?module=mistenkelige_klienter&amp;order=skole>Skole</a></th>\n\n";
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
	$content .= $rKlientListe->skole;
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
