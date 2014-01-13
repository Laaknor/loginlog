<?php
require_once 'config.php';

$action = $_GET['action'];

#$action = "everydayweek";
if(!isset($action)) {
?>

<br><a href=newgraph.php?action=timeofday>Pålogginger fordelt på når på dagen</a>
<br><a href=?action=dayofweek>Pålogginger fordelt på når i uka</a>
<br><a href=?action=everydayweeks>Pålogginger for hver dag, hver uke, siste år</a> (Virker ikke)
<br><a href=?action=weeks>Pålogginger fordelt på uker, siste år</a>
<br> <a href=newgraph.php?action=tslast>Pågginger pr. terminalserver</a>
<br><a href=newgraph.php?action=klienterprskole>Antall klienter pr. skole</a>
<br><a href=newgraph.php?action=prskole>Antall pålogginger pr. skole</a>
<br><a href=newgraph.php?action=clientusage>Gjennomsnittlig pålogging pr. tynnklient pr. skole</a>

<br><br><br><br>
<a href=admin.php?action=1>Admin tynnklienter</a>
<br><a href=admin.php?action=2>Admin PCer</a>

<br><br><img src=weeks_29_2007.png>
<?php
}



elseif($action == "timeofday") {
	$limit = $_GET['limit'];
	if($limit == 24) $where = "AND unixtime > ".time()-(60*60*24);

	$q = query("SELECT * FROM loginlog WHERE unixtime != 0 $where");

	for($i=0;$i<24;$i++) $data[$i] = 0;
	while($r = fetch($q)) {
		$time = date("G", $r->unixtime);
		$data[$time] = $data[$time] + 1;
#		asort($data);
	}
#	for($i=0;$i<24;$i++) echo $i." == ".$data[$i]."\n";
	$imagetitle = "Palogginger fordelt pa nar pa dognet";
	include_once 'chart.php';

}


elseif($action == "dayofweek") {
	$q = query("SELECT * FROM loginlog WHERE unixtime != 0");
	$days = array(0 => "Sondag", 1 => "Mandag", 2 => "Tirsdag", 3 => "Onsdag", 4 => "Torsdag", 5 => "Fredag", 6 => "Lordag");
	$data = array("Sondag" => 0, "Mandag" => 0, "Tirsdag" => 0, "Onsdag" => 0, "Torsdag" => 0, "Fredag" => 0, "Lordag" => 0);
	while($r = fetch($q)) {
		$day = $days[date("w", $r->unixtime)];
		$data[$day] = $data[$day] +1;
	}
#	echo count($data);
	$imagetitle = "Palogginger fordelt pa nar i uka";
	include_once 'chart.php';
}
elseif($action == "tslast") {
	$now = time();
	$then = $now - (60*60*24*7);
	$q = query("SELECT hostname FROM loginlog WHERE clientname != '' AND unixtime > $then ORDER BY hostname");
	while($r = fetch($q)) {
		$data[$r->hostname]++;
	}
	$imagewidth = 480 * 2;
	$imageheight = 250 * 2;
	$imagetitle = "Innlogginger pr. terminalserver";
	include_once 'chart.php';
}

/*
elseif($action == "everydayweek") {
	$year = time()-(60*60*24*365);
	$q = query("SELECT * FROM loginlog WHERE unixtime > $year");
	while($r = fetch($q)) {
		$week = date("W", $r->unixtime);
		$day = date("w", $r->unxitime);
		$export[$week][$day]++;
	} // End while
		foreach($export as $week => $
} // End action = everydayweek
*/

elseif($action == "weeks") {
	$year = time()-(60*60*24*365);
	$q = query("SELECT * FROM loginlog WHERE unixtime > $year ORDER BY unixtime ASC");
	while($r = fetch($q)) {
		$week = date("W", $r->unixtime);
		$data[$week]++;
	}
	$imagetitle = "Palogginger fordelt pa uker";
	$imagewidth=480*2;
	$imageheight=250*2;
	include_once 'chart.php';
}

elseif($action == "klienterprskole") {
	$q1 = query("SELECT * FROM groups WHERE ID != 1 ORDER BY kommune,skole");
	while($skole = fetch($q1)) {
		$q = query("SELECT COUNT(*) AS antall FROM klienter WHERE gruppe = $skole->ID");
		$r = fetch($q);
		$data[$skole->skole] = $r->antall;
	}
	$imagetitle = "Antall klienter pr. skole";
	$imagewidth = 480*2;
	$imageheight = 250*2;
	include_once 'chart.php';
}
