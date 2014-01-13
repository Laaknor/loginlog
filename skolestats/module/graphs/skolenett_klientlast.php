<?php

require_once '../../include.php';


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

		$graph->title->Set("Gjennomsnittlig pålogginger pr. arbeidsstasjon pr. skole, siste uke");
		$graph->xaxis->title->Set("Skole");
		//$graph->yaxis->title->Set("Innlogginger");
		$graph->Stroke();
