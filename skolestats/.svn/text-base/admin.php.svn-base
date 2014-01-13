<?php
require_once 'config.php';

$action = $_GET['action'];

$andunixtime ="AND unixtime > 1178178217";
if($action == "1" || $action == "2") { // Tynnklient
	//  SELECT DISTINCT clientname FROM loginlog LEFT JOIN klienter ON loginlog.clientname = klienter.navn WHERE klienter.navn IS NULL;
//	$q = query("SELECT DISTINCT clientname FROM loginlog WHERE clientname NOT IN ('SELECT navn FROM klienter') AND clientname != '' ORDER BY RAND() LIMIT 0,10");
#	if($action == 1) $q = query("SELECT DISTINCT clientname FROM loginlog LEFT JOIN klienter ON loginlog.clientname = klienter.navn WHERE klienter.navn IS NULL AND loginlog.clientname != '' $andunixtime ORDER BY clientname DESC LIMIT 0,25");
	if($action == 1) $q = query("SELECT DISTINCT navn FROM klienter WHERE gruppe = 1 AND type = 1 ORDER BY navn ASC LIMIT 0,25");
#	elseif($action == 2) $q = query("SELECT DISTINCT hostname FROM loginlog LEFT join klienter ON loginlog.hostname = klienter.navn WHERE klienter.navn IS NULL and loginlog.clientname = '' $andunixtime ORDER BY hostname DESC LIMIT 0,25");
	elseif($action == 2) $q = query("SELECT DISTINCT navn FROM klienter WHERE gruppe = 1 AND type = 2 ORDER BY navn ASC LIMIT 0,25");



	
	echo "<form method=POST action=admin.php?action=add$action>";
	echo "<table>";
	echo "<tr><th>Maskinnavn</th><th>Skole</th></tr>";
	$i = 0;
	while($r = fetch($q)) {
		echo "<tr><td>";
		if($action == 1) { 
			echo $r->navn;
			echo "<input type=hidden name=post".$i." value='$r->navn'>";
		}
		elseif($action == 2) {
			echo $r->navn;
			echo "<input type=hidden name=post".$i." value='$r->navn'>";
		}
		echo "</td><td>";
		echo "<select name=group$i>";
		$q2 = query("SELECT * FROM groups ORDER BY ID=1 DESC,skole");
		while($r2 = fetch($q2)) {
			echo "<option value=$r2->ID>$r2->skole</option>\n\n";
		} // End whiler2
		echo "</select></td>";
#		$test = query("SELECT * FROM klienter WHERE navn = '$r->clientname'");
#		if(num($test) > 0) echo "<td>Allerede inne!</td>";
		echo "<td>$r->company</td>";
#		echo "<td>$r->username</td>";
		echo "</tr>";
		$i++;
	} // End whiler
	echo "<input type=submit value='Lagre'>";
	echo "</form></table>";

} // End action = 1, tynnklient


elseif($action == "add1") {
	for($i=0;$i<25;$i++) {
		$client = $_POST['post'.$i];
		$group = $_POST['group'.$i];
#		$test = query("SELECT * FROM klienter WHERE navn = '$navn' AND type = 1");
#		if(num($test) == 1) 
			query("UPDATE klienter SET gruppe = $group WHERE navn = '$client' AND type = 1");

	} // End for
	header("Location: admin.php?action=1");
} // end action == add1

elseif($action == "add2") {
	for($i=0;$i<25;$i++) {
		$client = $_POST['post'.$i];
		$group = $_POST['group'.$i];
#		$test = query("SELECT * FROM klienter WHERE navn = '$client' AND type = 2");
#		if(num($test) == 0)
			query("UPDATE klienter SET gruppe = $group WHERE navn = '$client' AND type = 2");
	} // End for
	header("Location: admin.php?action=2");
}

elseif($action == 3) {
#	$q = query("SELECT * FROM klienter WHERE gruppe = 28 AND type = 1");
	$q = query("SELECT * FROM klienter WHERE navn LIKE '%FIB%' OR navn LIKE 'VXL%'");
	echo "<table>";

	while($r = fetch($q)) {
		$q1 = query("SELECT clientname,CONCAT(loginlog.username,'.',loginlog.context) AS usercont, company FROM loginlog WHERE context != '' AND context NOT LIKE '%Laerer%' AND (clientname LIKE '$r->navn' OR clientname LIKE '$r->navn') AND unixtime > 1143186469");
		while($r1 = fetch($q1)) {
			echo "<tr><td>".$r1->clientname."</td><td>".$r1->usercont."</td><td>$r1->company</td></tr>";
		} // End while($1)
	} // while($r)

} // End if action=3
