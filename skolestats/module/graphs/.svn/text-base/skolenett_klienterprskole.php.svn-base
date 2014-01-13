<?php
require_once '../../include.php';

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