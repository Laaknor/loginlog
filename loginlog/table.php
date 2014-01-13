<?php
require_once 'config.php';

echo "<table>";
$q = query("SELECT * FROM loginlog WHERE hostname NOT LIKE 'TS%' LIMIT 0,30");
while($r = fetch($q)) {
	echo "<tr><td>";
	echo $r->ID;
	echo "</td><td>";
	echo $r->username;
	echo "</td><td>";
	echo $r->hostname;
	echo "</td><td>";
	echo $r->unixtime;
	echo "</td><td>";
	echo $r->clientname;
}
