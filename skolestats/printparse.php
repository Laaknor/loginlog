<?php

require_once 'config.php';
require_once 'functions.php';



$dir = 'tmp/printaudit/';

$opendir = opendir($dir);

while($readdir = readdir($opendir)) {
	if($readdir == "." || $readdir == ".." || $readdir == ".svn");
	else {
		$file = fopen($dir.$readdir, "r");
		while(!feof($file)) {
			$line = fgets($file);
			if(strstr($line, "Audit Log Start"));
			elseif(strstr($line, "Job Owner,Printer Name,Date Submitted"));
			elseif(strstr($line, "Total Job Count"));
			elseif(strstr($line, "Audit Log End"));
			else {
				$split = split(",", $line);

				$usercontext = strtr($split[0], "\\", ".");
				$printer = $split[1];
				$datotidstart = $split[2];
				$datotidstop = $split[3];
				$sider = $split[4];
				$storrelse = $split[5];
				$statuskode = $split[6];
				$jobbnavn = $split[7];
				$pdl = $split[8];

			} // End else

			// echo $usercontext.$printer.$sider.$jobbnavn."\n<br>\n";

			if(!empty($usercontext) && $sider > 0) query("INSERT INTO utskrifter SET
				jobowner = '".$usercontext."',
				printer = '".$printer."',
				startdato = '".$datotidstart."',
				stopdato = '".$datotidstop."',
				sider = '".$sider."',
				jobsize = '".$storrelse."',
				statuskode = '".$statuskode."',
				jobname = '".$jobbnavn."',
				PDL = '".$pdl."'
				");
		} // end !feof($file)

	} // end else;


} // end while;
echo "finished?";
