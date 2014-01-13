<?php
#echo strtotime("1/19/2006 13:00");
require_once 'config.php';
#$q = query("SELECT * FROM loginlog WHERE hostname = 'TS16'"); // AND unixtime > ".time()."-7200");

#$q = query("SELEC
#$q = query("SELECT username,clientname FROM loginlog WHERE unixtime < 1137672000 AND unixtime > 1137672000-7200 AND hostname = 'TS14'");

$q = query("SELECT * FROM loginlog WHERE ID = 375784");
$r = fetch($q);

echo "<pre>$r->clientname</pre>";
