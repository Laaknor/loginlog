<?php
require_once 'config.php';
require_once 'functions.php';

$dir = '/home/lak/applog/';

$opendir = opendir($dir);
#echo $dir;
while($file = readdir($opendir)) {
	if ($file == '.' || $file == '..');
	else {
		$fp = fopen($dir.$file, "r");
		while(!feof($fp)) {
			$line = fgets($fp);
			$split = split('","',$line);
#			print_r($split);
			$date = explode(" ", $split[2]);
			$dato = $date[0];
			$tid = $date[1];
			$datechange = explode(".",$date[0]);
			$unixtime = strtotime($datechange[1]."/".$datechange[0]."/".$datechange[2]." ".$tid);
#			echo $unixtime;
			$userDN = $split[3];
			$appname = $split[6];
			$appSID = $split[7];
			$klientDN = $split[4];
			$klientIP = $split[5];
			if(!empty($userDN)) query("INSERT INTO applog SET
				dato = '$dato',
				tid = '$tid',
				unixtime = '$unixtime',
				userDN = '$userDN',
				appname = '$appname',
				appSID = '$appSID',
				klientDN = '$klientDN',
				klientIP = '$klientIP'
			");
		} // End !feof
		fclose($fp);
		unlink($dir.$file);
	} // End else



} // End while file=readdir
