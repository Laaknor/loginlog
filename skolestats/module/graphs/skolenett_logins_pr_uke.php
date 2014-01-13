<?php
require_once '../../include.php';

#	$q1 = query("SELECT ID,skole FROM groups WHERE ID != 1 ORDER BY kommune,skole");
#	$q1 = query("SELECT kommune FROM groups WHERE kommune IN ('T', 'N') ORDER BY kommune");
	$r1 = fetch(query("SELECT unixtime FROM loginlog ORDER BY unixtime ASC LIMIT 0,1"));
	$run = 0;
	for($i=$r1->unixtime;$i<time();$i=($i+(24*7*60*60))) {
		$weeknumber = date("W", $i);
		$weeks[] = $weeknumber;
		$reverse[$weeknumber] = $run;
		$run++;
	}

	$q = query("SELECT unixtime FROM loginlog ORDER BY unixtime ASC");
	while($logins = fetch($q)) {
#		$q = query("SELECT COUNT(*) AS antall FROM klienter WHERE gruppe = $skole->ID AND type = 1 AND lastseen > $FourWeeksAgo");
#		$r = fetch($q);
#		$data1y[] = $r->antall;

#		$q = query("SELECT COUNT(*) AS antall FROM klienter WHERE gruppe = $skole->ID AND type = 2  AND lastseen > $FourWeeksAgo");
#		$r = fetch($q);
#		$data2y[] = $r->antall;

#		$skoler[] = $skole->skole;
		$week = date("W", $logins->unixtime);
		$datarun = $reverse[$week];
		$data[$datarun]++;
#		$weeks


	} // End while

#print_r($data);
#die();
	$graph = new Graph(310*3,200*3,"auto");
	$graph->SetScale("textlin");

	$graph->SetShadow();
	$graph->img->SetMargin(40,120,20,40);

	$b1plot = new BarPlot($data);
	$b1plot->SetFillColor("orange");
#	$b1plot->SetLegend("Tynnklienter");
	$b1plot->SetLegend("Palogginger");
#	$b1plot->value->show();

#	$b2plot = new BarPlot($data2y);
#	$b2plot->SetFillColor("blue");
#	$b2plot->SetLegend("PCer");
#	$b2plot->value->Show();


#	$gbplot = new AccBarPlot(array($b1plot,$b2plot));

	$graph->Add($b1plot);


	$graph->title->Set("Antall palogginger pr. uke");
	$graph->xaxis->title->Set("Uker");
	$graph->yaxis->title->Set("Antall");

	$graph->xaxis->SetTickLabels($weeks);

	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

	$graph->Stroke();
