<?php
require_once 'config.php';

#$q = query("SELECT DISTINCT clientname FROM loginlog WHERE clientname != '' AND unixtime > 1142412176");
$q = query("SELECT * FROM loginlog WHERE clientname IN ('TPUS-OC0161','TPUS-OC0162','TPUS-OC0164', 'TPUS-OC0165', 'TPUS-OC0166', 'TPUS-OC0167', 'TPUS-OC0169', 'TPUS-OC0170', 'TPUS-OC0171', 'TPUS-OC0172', 'TPUS-OC0173', 'TPUS-OC0174', 'TPUS-OC0176', 'TPUS-OC0178', 'TPUS-OC0183', 'TPUS-OC0204') AND unixtime > 1192424144 AND unixtime < 1193079076");


echo "<table><tr>
<th>Klientnavn</th>
<th>Terminalserver</th>
<th>Dato</th>
<th>Tid</th>
<th>Brukernavn</th>
<th>Klasse</th>
<th>Skole</th>";

while($r = fetch($q)) {

	echo "<tr><td>$r->clientname</td><td>\n";
	echo "$r->hostname</td><td>\n";
	echo "$r->dato</td><td>\n";
	echo $r->tid."</td><td>\n";
	echo $r->username."</td><td>";
	echo $r->location."</td><td>\n";
	echo $r->company."</td></tr>\n\n";

}
