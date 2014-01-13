<?php

$rSkoleID = fetch(query("SELECT ID,company FROM groups WHERE skole = '".$_SESSION['skole']."'"));
$skoleID = $rSkoleID->ID;

$content .= '<table>';


/* Vis skolen */

$content .= '<tr><th>';
$content .= "Skole";
$content .= "</th><td>";
$content .= $_SESSION['skole'];
$content .= "</td></tr>";


/* Vis tynnklienter */

$content .= "<tr><th>";
$content .= "Antall tynnklienter på skolen/totalt";
$content .= "</th><td>";
$rFindSkoleClients = fetch(query("SELECT COUNT(*) AS antall FROM klienter WHERE
	type = 1 AND gruppe = $skoleID AND lastseen > $ThreeMonthsAgo"));
$rFindTotalClients = fetch(query("SELECT COUNT(*) AS antall FROM klienter WHERE type = 1 AND lastseen > $ThreeMonthsAgo"));

$content .= $rFindSkoleClients->antall." / ".$rFindTotalClients->antall;

$content .= "</td></tr>";


/* Vis PCer */


$content .= "<tr><th>";
$content .= "Antall PC/bærbare på skolen/totalt";
$content .= "</th><td>";
$rFindSkoleClients = fetch(query("SELECT COUNT(*) AS antall FROM klienter WHERE
	type = 2 AND gruppe = $skoleID AND lastseen > $ThreeMonthsAgo"));
$rFindTotalClients = fetch(query("SELECT COUNT(*) AS antall FROM klienter WHERE type = 2 AND lastseen > $ThreeMonthsAgo"));

$content .= $rFindSkoleClients->antall." / ".$rFindTotalClients->antall;

$content .= "</td></tr>";



$content .= '</table>';


$content .= '<table border=1>';
$content .= '<tr><th>Brukernavn</th>
<th>PC/Terminalserver</th>
<th>Tynnklient</th>
<th>Skole</th>
<th>Tittel</th>
<th>Trinn</th>
<th>Klasse</th>
<th>Dato</th>
<th>Tidspunkt</th>
</tr>';

$qLastLogins = query("SELECT username,hostname,clientname,
	company AS skole,
	title,
	department AS trinn,
	location AS klasse,
	dato,
	tid
	FROM loginlog
	WHERE company = '".$rSkoleID->company."'
	ORDER BY ID DESC LIMIT 0,20");
while($rLastLogins = fetch($qLastLogins)) {
		$content .= "<tr><td>\n";
		$content .= $rLastLogins->username;
		$content .= "</td><td>\n";
		$content .= $rLastLogins->hostname;
		$content .= "</td><td>\n";
		$content .= $rLastLogins->clientname;
		$content .= "</td><td>\n";
		$content .= $rLastLogins->skole;
		$content .= "</td><td>\n";
		$content .= $rLastLogins->title;
		$content .= "</td><td>\n";
		$content .= $rLastLogins->trinn;
		$content .= "</td><td>\n";
		$content .= $rLastLogins->klasse;
		$content .= "</td><td>\n";
		$content .= $rLastLogins->dato;
		$content .= "</td><td>\n";
		$content .= $rLastLogins->tid;
		$content .= "</td></tr>\n\n\n";

} // End while rLastLogins

$content .= '</table>';

$head .= '<meta http-equiv=refresh content="60">';
