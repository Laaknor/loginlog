<?php
require_once 'config.php';

$skole = $_GET['skole'];
$qG = query("SELECT ID FROM groups WHERE skole = '$skole'");
$rG = fetch($qG);
$editID = $_GET['editID'];

$sID = $rG->ID;
$monthago = time()-(60*60*24*31);
$order = $_GET['order'];
if(!isset($order)) $order = 'navn';
$order = mysql_real_escape_string($order);
$q = query("SELECT * FROM klienter where gruppe = $sID AND lastseen != 0 ORDER BY $order DESC");
echo "<table>\n\n\n";
	echo "<tr><th><a href=?order=navn&skole=$skole>Klientnavn</a></th><th><a href=?order=type&skole=$skole>Type</a></th><th><a href=?order=lastseen&skole=$skole>Sist brukt</a></th><th>Modell</th><th>Bruksmønster</th><th>Kommentar</th></tr>\n\n";
while($r = fetch($q)) {
	echo "<tr><td>";
	echo "<a href=?skole=$skole&order=$order&editID=$r->ID>";
	echo $r->navn;
	echo "</a></td><td>";
	if($r->type == 1) echo "Tynnklient";
	elseif($r->type == 2) echo "PC";
	echo "</td><td>";
	echo date("H:i d/m", $r->lastseen);

	echo "</td><td valign=top>";
	if($editID == $r->ID) {
		echo "<form method=POST action=editklient.php?editID=$editID&skole=$skole&order=$order>\n";

		// First, we begin with modell
		echo "<select name=modell>\n";
		$qModell = query("SELECT * FROM modeller ORDER BY modellnavn");
		while($rModell = fetch($qModell)) {
			echo "<option value=$rModell->ID";
			if($rModell->ID == $r->modell) echo " SELECTED";
			echo ">$rModell->modellnavn";
		} // end while rModell
		echo "</select>";

		echo "</td><td valign=top>";
		echo "<select name=bruk>";
		$qBruk = query("SELECT * FROM bruksmonster ORDER BY bruk");
		while($rBruk = fetch($qBruk)) {
			echo "<option value=$rBruk->ID";
			if($rBruk->ID == $r->bruksmonster) echo " SELECTED";
			echo ">$rBruk->bruk</option>";
		}
		echo "</select>";
		
		echo "</td><td>";
		echo "<textarea name=kommentar cols=40 rows=3>$r->kommentar</textarea>";
		echo "</td><td>";
		echo "<input type=submit value='Lagre'>";
		
	}
	else {
		$rModell = fetch(query("SELECT * FROM modeller WHERE ID = $r->modell"));
		echo $rModell->modellnavn;
		echo "</td><td>";
		$rBruk = fetch(query("SELECT * FROM bruksmonster WHERE ID = $r->bruksmonster"));
		echo $rBruk->bruk;
		echo "</td><td>";
		echo $r->kommentar;
	}
	echo "</td></tr>\n";

}

echo "</table>";
