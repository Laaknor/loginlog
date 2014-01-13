<?php

require_once 'config.php';
require_once '/usr/share/php/jpgraph/jpgraph.php';
require_once '/usr/share/php/jpgraph/jpgraph_bar.php';
$action = $_GET['action'];
#$action = "elevprskole";
$now = time();
$lastweek = $now - (60*60*24*7);
if($action == "klienterprskole") {
	$q1 = query("SELECT ID,skole FROM groups WHERE ID != 1 ORDER BY kommune,skole");
	while($skole = fetch($q1)) {
		$q = query("SELECT COUNT(*) AS antall FROM klienter WHERE gruppe = $skole->ID AND type = 1 AND lastseen > $FourWeeksAgo");
		$r = fetch($q);
		$data1y[] = $r->antall;

		$q = query("SELECT COUNT(*) AS antall FROM klienter WHERE gruppe = $skole->ID AND type = 2  AND lastseen > $FourWeeksAgo");
		$r = fetch($q);
		$data2y[] = $r->antall;

		$skoler[] = $skole->skole;


	} // End while

	$graph = new Graph(310*3,200*3,"auto");
	$graph->SetScale("textlin");

	$graph->SetShadow();
	$graph->img->SetMargin(40,120,20,40);

	$b1plot = new BarPlot($data1y);
	$b1plot->SetFillColor("orange");
	$b1plot->SetLegend("Tynnklienter");
#	$b1plot->value->show();

	$b2plot = new BarPlot($data2y);
	$b2plot->SetFillColor("blue");
	$b2plot->SetLegend("PCer");
#	$b2plot->value->Show();


	$gbplot = new AccBarPlot(array($b1plot,$b2plot));

	$graph->Add($gbplot);


	$graph->title->Set("Klienter/PCer ved hver skole");
	$graph->xaxis->title->Set("Skoler");
	$graph->yaxis->title->Set("Antall");

	$graph->xaxis->SetTickLabels($skoler);

	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

	$graph->Stroke();

} // End if action == klienterprskole

elseif($action == "tslast") {
	$q = query("SELECT DISTINCT hostname FROM loginlog WHERE clientname != '' AND unixtime > $lastweek ORDER BY hostname");
	while($r = fetch($q)) {
		$q1 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE clientname != '' AND username LIKE '9%' AND hostname = '$r->hostname' AND unixtime > $lastweek");
		$r1 = fetch($q1);
		$data1y[] = $r1->antall;

		$q2 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE clientname != '' AND username NOT LIKE '9%' AND hostname = '$r->hostname' AND unixtime > $lastweek");
		$r2 = fetch($q2);
		$data2y[] = $r2->antall;

		$tserver[] = $r->hostname;

	} // End while

	$graph = new Graph(310*3,200*3,"auto");
	$graph->SetScale("textlin");

	$graph->SetShadow();
	$graph->img->SetMArgin(40,120,20,40*2);

	$b1plot = new BarPlot($data1y);
	$b1plot->SetFillColor("orange");
	$b1plot->SetLegend("Elever");

	$b2plot = new BarPlot($data2y);
	$b2plot->SetFillColor("blue");
	$b2plot->SetLegend("Pedagoger");
	
	$graph->xaxis->SetTickLabels($tserver);
	$graph->xaxis->SetLabelAngle(90);
	$graph->xaxis->SetLabelMargin(5);

	$gbplot = new AccBarPlot(array($b1plot,$b2plot));

	$graph->Add($gbplot);
	$graph->title->Set("Antall pålogginger pr. terminalserver, siste uke");
	$graph->xaxis->title->Set("Terminalserver");
#	$graph->xaxis->title->Set("Skole");
	$graph->yaxis->title->Set("Innlogginger");
	$graph->Stroke();

} // End if action == tslast

elseif($action == "timeofday") {
	for($i=0;$i<24;$i++) {
		$timeelev[$i] = 0;
		$timeped[$i] = 0;
	} // End for

	$qelev = query("SELECT * FROM loginlog WHERE context NOT LIKE '%Laerer%' AND unixtime != 0");
	while($relev = fetch($qelev)) {
		$timeofday = date("G", $relev->unixtime);
		$timeelev[$timeofday]++;
	}


	$qped = query("SELECT * FROM loginlog WHERE context LIKE '%Laerer%' AND unixtime != 0");
	while($rped = fetch($qped)) {
		$timeofday = date("G", $rped->unixtime);
		$timeped[$timeofday]++;
	}

#	print_r($time);

	$graph = new Graph(310*2,200*2,"auto");
	$graph->SetScale("textlin");

	$graph->SetShadow();
	$graph->img->SetMargin(40,120,20,40);
	$b1plot = new BarPlot($timeelev);
	$b1plot->SetFillColor("orange");
	$b1plot->SetLegend("Elever");

	$b2plot = new BarPlot($timeped);
	$b2plot->SetFillColor("blue");
	$b2plot->SetLegend("Pedagoger");

	$gbplot = new AccBarPlot(array($b1plot, $b2plot));

	$graph->Add($gbplot);

	$graph->title->Set("Antall pålogginger ut i fra når på døgnet");
	$graph->xaxis->title->Set("Time");
	$graph->yaxis->title->Set("Innlogginger");
	$graph->Stroke();


}

elseif($action == "clientusage") {
	$qskole = query("SELECT * FROM groups WHERE kommune in ('T', 'N') ORDER BY kommune,skole");

	while($rskole = fetch($qskole)) {
		$qnavn = query("SELECT * FROM klienter WHERE gruppe = '$rskole->ID' AND lastseen >= $FourWeeksAgo");
		$navnruns = 0;
		$loginwhere = NULL;


		while($rnavn = fetch($qnavn)) {
			if($navnruns == 0);
			else $loginwhere .= ", ";

			$loginwhere .= "'$rnavn->navn'";
			$navnruns = 1;

		} // End while $rnavn

		if($loginwhere == "") $loginwhere = "''";

		$countHOST = query("SELECT COUNT(*) AS antall FROM loginlog WHERE hostname IN ($loginwhere) AND unixtime >= $OneWeekAgo");
		$countCLIENT = query("SELECT COUNT(*) AS antall FROM loginlog where clientname IN ($loginwhere) AND unixtime >= $OneWeekAgo");

		$rcountHOST = fetch($countHOST);
		$rcountCLIENT = fetch($countCLIENT);
		$numHOST = num(query("SELECT * FROM klienter WHERE gruppe = '$rskole->ID' AND lastseen >= $FourWeeksAgo AND type = 2"));
		$numCLIENT = num(query("SELECT * FROM klienter WHERE gruppe = '$rskole->ID' AND lastseen >= $FourWeeksAgo AND type = 1"));

		if(empty($numHOST)) $numHOST = 1;
		$skoler[] = $rskole->skole;
		$HOST = $rcountHOST->antall / $numHOST;
		$CLIENT = $rcountCLIENT->antall / $numCLIENT;
		if($CLIENT < 1) $skoleCLIENT[] = 0;
		else $skoleCLIENT[] = $CLIENT;

		if($HOST < 1) $skoleHOST[] = 0;
		else $skoleHOST[] = $HOST;

	} // End while rskole
/*		print_r($skoler);
		echo "\n<br><br>";
		print_r($skoleHOST);
		echo "\n<br><br>";
		print_r($skoleCLIENT);
		echo "\n<br><br>";
		die(); */
		$graph = new Graph(310*3,200*3,"auto");
		$graph->SetScale("textlin");

		$graph->SetShadow();
		$graph->img->SetMargin(40,120,20,40);
		$b1plot = new BarPlot($skoleCLIENT);
		$b1plot->SetFillColor("orange");
		$b1plot->SetLegend("Tynne klienter");

		$b2plot = new BarPlot($skoleHOST);
		$b2plot->SetFillColor("blue");
		$b2plot->SetLegend("Stasjonære maskiner");

		$graph->xaxis->SetTickLabels($skoler);

#		$gbplot = new AccBarPlot(array($b1plot, $b2plot));
		$gbplot = new GroupBarPlot(array($b1plot, $b2plot));

		$graph->Add($gbplot);

		$graph->title->Set("Gjennomsnittlig pålogginger pr. arbeidsstasjon pr. skole");
		$graph->xaxis->title->Set("Skole");
		//$graph->yaxis->title->Set("Innlogginger");
		$graph->Stroke();

}

elseif($action == "prskole") {
	if($_GET['all'] == 1) $lastweek = -1;
	$q = query("SELECT * FROM groups WHERE ID NOT IN (1,27,28) ORDER BY kommune,skole");
	while($r = fetch($q)) {
		$q2 = query("SELECT * FROM klienter WHERE gruppe = $r->ID AND type = 1");
		$first = TRUE;
		$where1 = NULL;
		while($r2 = fetch($q2)) {
			if(!$first) $where1 .= "OR";
			$where1 .= " clientname LIKE '$r2->navn%' OR hostname LIKE '$r2->hostname'";
			$first = FALSE;
		}
		if($where1 == NULL) $where1 = 0;
		$elevwhere = "context NOT LIKE '%Laerer%'";
		$pedwhere = "context LIKE '%Laerer%'";
		$q3 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE ($elevwhere) AND ($where1) AND unixtime > $lastweek");
		$r3 = fetch($q3);
		$data1y[] = $r3->antall;

		$q4 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE ($pedwhere) AND ($where1) AND unixtime > $lastweek");
		$r4 = fetch($q4);
		$data2y[] = $r4->antall;

		$q5 = query("SELECT * FROM klienter WHERE gruppe = $r->ID AND type = 2");
		$first = TRUE;
		$where2 = NULL;
		while($r5 = fetch($q5)) {
			if(!$first) $where2 .= "OR";
			$where2 .= " hostname LIKE '$r5->navn' ";
			$first = FALSE;
		} // end while fetch(q5);
		if($where2 == NULL) $where2 = 0;
		$q6 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE ($elevwhere) AND ($where2) AND unixtime > $lastweek");
		$r6 = fetch($q6);
		$data3y[] = $r6->antall;

		$q7 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE ($pedwhere) AND ($where2) AND unixtime >$lastweek");
		$r7 = fetch($q7);
		$data4y[] = $r7->antall;

		$skole[] = $r->skole;
	} // End while fetch gruppe

	$graph = new Graph(310*3,200*3,"auto");
	$graph->SetScale("textlin");
	$graph->SetShadow();
	$graph->img->SetMargin(40,120,20,40);

	$b1plot = new BarPlot($data1y);
	$b1plot->SetFillColor("orange");
	$b1plot->SetLegend("Elever TK");

	$b2plot = new BarPlot($data2y);
	$b2plot->SetFillColor("blue");
	$b2plot->SetLegend("Pedagoger TK");

	$b3plot = new BarPlot($data3y);
	$b3plot->SetFillColor("green");
	$b3plot->SetLegend("Elever PC");

	$b4plot = new BarPlot($data4y);
	$b4plot->SetFillColor("red");
	$b4plot->SetLegend("Pedagoger PC");

	$graph->xaxis->SetTickLabels($skole);
	$gbplot = new AccBarPlot(array($b1plot,$b2plot,$b3plot,$b4plot));

	$graph->Add($gbplot);

	$graph->title->Set("Antall pålogginger pr. skole");
	$graph->xaxis->title->Set("Skole");
	$graph->yaxis->title->Set("Innlogginger");
	$graph->Stroke();
} // End if action == prskole

elseif($action == "weeks") {
	$qFirstWeek = query("SELECT * FROM loginlog ORDER BY unixtime ASC LIMIT 0,1");
	$rFirstWeek = fetch($qFirstWeek);
	$FirstWeek = date("W", $rFirstWeek->unixtime);
	$ThisWeek = date("W");
	$currentWeek = $FirstWeek;
	$space = 0;
	while($currentWeek != $ThisWeek) {
		$weeksarray[$space] = $currentWeek;
		if($currentWeek == 53) $currentWeek = 1;
		else $currentWeek++;
		$reverse[$currentWeek] = $space;
#		print_r($weeksarray);
		$space++;
	}

	$qNKskoler = query("SELECT ID FROM groups WHERE kommune LIKE 'N'");
	while($rNKskoler = fetch($qNKskoler)) {
		if(!empty($NKskoler)) $NKskoler .= ', ';
		$NKskoler .= $rNKskoler->ID;
	}
	$qTBGskoler = query("SELECT ID FROM groups WHERE kommune LIKE 'T'");
	while($rTBGskoler = fetch($qTBGskoler)) {
		if(!empty($TBGskoler)) $TBGskoler .= ', ';
		$TBGskoler .= $rTBGskoler->ID;
	}
#	print_r($TBGskoler);
#	die();
	$qNKklienter = query("SELECT navn FROM klienter WHERE gruppe IN ($NKskoler)");
	while($rNKklienter = fetch($qNKklienter)) {
		if(!empty($NKklienter)) $NKklienter .= ', ';
		$NKklienter .= "'$rNKklienter->navn'";
	}
	$qTBGklienter = query("SELECT navn FROM klienter WHERE gruppe IN ($TBGskoler)");
	while($rTBGklienter = fetch($qTBGklienter)) {
		if(!empty($TBGklienter)) $TBGklienter .= ', ';
		$TBGklienter .= "'$rTBGklienter->navn'";

	}
	//$qNK = query("SELECT * FROM loginlog WHERE company LIKE 'SB%' OR company LIKE 'SU%' ORDER BY unixtime ASC");
	$qNK = query("SELECT unixtime FROM loginlog WHERE clientname IN ($NKklienter) OR hostname IN ($NKklienter) ORDER BY unixtime ASC");
	while($rNK = fetch($qNK)) {
		
		$week = date("W", $rNK->unixtime);
#		$TBGarray[$week] = 0;
		$weekspace = $reverse[$week];
		$NKarray[$weekspace]++;
	}
	$qTBG = query("SELECT unixtime FROM loginlog WHERE clientname IN ($TBGklienter) OR hostname IN ($TBGklienter) ORDER BY unixtime ASC");
//	$qTBG = query("SELECT * FROM loginlog WHERE company NOT LIKE 'SB%' AND company NOT LIKE 'SU%' ORDER BY unixtime ASC");
	while($rTBG = fetch($qTBG)) {
		$week = date("W", $rTBG->unixtime);
		$weekspace = $reverse[$week];
		$TBGarray[$weekspace]++;
	}
/*	print_r($TBGarray);
	echo "<br><br><br><hr><br><br>";
	print_r($NKarray);
	echo "TBG: ".count($TBGarray);
	echo "<br>NK: ".count($NKarray);
	die(); 
*/	$graph = new Graph(310*3, 200*3, "auto");
	$graph->SetScale("textlin");
	$graph->SetShadow();
	$graph->img->SetMargin(40,120,20,40);

	$b1plot = new BarPlot($NKarray);
	$b1plot->SetFillColor("orange");
	$b1plot->SetLegend("Pålogginger NK");

	$b2plot = new BarPlot($TBGarray);
	$b2plot->SetFillColor("blue");
	$b2plot->SetLegend("Pålogginger TBG");
	print_r($b1plot);
	echo "<br><br><br>";
	print_r($b2plot);
	die();
	$graph->xaxis->SetTickLabels($weeksarray);
	$gbplot = new AccBarPlot(array($b1plot, $b2plot));
	$graph->Add($b1plot);
#	$graph->Add($gbplot);
#	$graph->Add($b2plot);
	$graph->title->Set("Antall pålogginger pr. kommune");


	$graph->Stroke();
}

elseif($action == "elevprskole") {
	$ds = ldap_connect($ldapserver);
	if(!$ds) die("Could not connect to LDAP-server");
	$rs = ldap_bind($ds, $ldapuser, $ldappassword) or die("Could not bind");


	$q = query("SELECT * FROM groups WHERE kommune != 'U' ORDER BY kommune,skole");

	while($r = fetch($q)) {
		$skoleCompany = $r->company;
		#$search = "(&(company=$skoleCompany)(title=Elev))";
		$search = "(title=Elev)";
		echo $search;
		$searchElever = ldap_search($ds, "o=VESTFOLD", $search);
		$ldap = ldap_get_entries($searchElever);
		echo $ldap['count'];
		$elever = ldap_count_entries($searchElever);

		echo $skoleCompany . " har $elever elever<br>\n";
	}
	ldap_close($ds);
} // End if action == prskole

