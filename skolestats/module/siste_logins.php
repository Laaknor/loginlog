<?php

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
	ORDER BY ID DESC LIMIT 0,50");
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

$head .= '<meta http-equiv=refresh content="5">';
