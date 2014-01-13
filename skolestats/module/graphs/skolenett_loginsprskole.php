<?php

require_once '../../include.php';

if($_GET['all'] == 1) $lastweek = -1;
	$q = query("SELECT * FROM groups WHERE ID NOT IN (1,27,28) ORDER BY kommune,skole");
	while($r = fetch($q)) {
		$q2 = query("SELECT * FROM klienter WHERE gruppe = $r->ID AND type = 1");
		$first = TRUE;
		$where1 = NULL;
		while($r2 = fetch($q2)) {
			if(!$first) $where1 .= " OR";
			#$where1 .= " clientname LIKE '$r2->navn' OR hostname LIKE '$r2->hostname'";
			$where1 .= " clientname LIKE '$r2->navn'";
			$first = FALSE;
		}
		if($where1 == NULL) $where1 = 0;
		$elevwhere = "context NOT LIKE '%Laerer%'";
		$pedwhere = "context LIKE '%Laerer%'";
		$q3 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE ($elevwhere) AND ($where1) AND unixtime > $OneWeekAgo");
		$r3 = fetch($q3);
		$data1y[] = $r3->antall;

		$q4 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE ($pedwhere) AND ($where1) AND unixtime > $OneWeekAgo");
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
		$q6 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE ($elevwhere) AND ($where2) AND unixtime > $OneWeekAgo");
		$r6 = fetch($q6);
		$data3y[] = $r6->antall;

		$q7 = query("SELECT COUNT(*) AS antall FROM loginlog WHERE ($pedwhere) AND ($where2) AND unixtime >$OneWeekAgo");
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

	$graph->title->Set("Antall pålogginger pr. skole siste uke");
	$graph->xaxis->title->Set("Skole");
	$graph->yaxis->title->Set("Innlogginger");
	$graph->Stroke();