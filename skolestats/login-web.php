<?php
require_once 'config.php';
require_once 'functions.php';

$username = $_GET['username'];
$hostname = $_GET['hostname'];
$date = $_GET['date'];
$fulldate = $date;
$date = explode(".",$date);
$time = $_GET['time'];
$fulltime = $time;
$time = substr($time, 0, 8);
$clientname = $_GET['clientname'];
	$toconvert = $date[1]."/".$date[0]."/".$date[2]." ".$time;
	$convert = strtotime($toconvert);
$context = $_GET['context'];
$shellversion = $_GET['shellversion'];
$loginserver = $_GET['loginserver'];
$title = $_GET['title'];
$location = $_GET['location'];
$department = $_GET['department'];
$company = $_GET['company'];

	if(!empty($username) && !empty($hostname)) {
		query ("INSERT INTO loginlog SET
			username = '$username',
			hostname = '$hostname',
			unixtime = ".time().",
			clientname = '$clientname',
			context = '$context',
			company = '$company',
			loginserver = '$loginserver',
			shellversion = '$shellversion',
			dato = '$fulldate',
			tid = '$fulltime',
			location = '$location',
			title = '$title',
			department = '$department',
			addtime = ".time());


#	echo $username."::".$hostname."::".$convert."::".$clientname."\n";
	} // End if isset($username)

	if(!empty($clientname)) {
		$q = query("SELECT * FROM klienter WHERE type = 1 AND navn LIKE '$clientname'");
		if(num($q) != 0) {
			query("UPDATE klienter SET lastseen = ".time()." WHERE type = 1 AND navn = '$clientname'");
		} // End if num != 0
		elseif(num($q) == 0) {
			query("INSERT INTO klienter SET lastseen = ".time().", type = 1, navn = '$clientname'");

		} // End elseif == 0


	} // End if !empty clientname

	if(empty($clientname)) {
		$q = query("SELECT * FROM klienter WHERE type = 2 AND navn LIKE '$hostname'");
		if(num($q) != 0) {
			query("UPDATE klienter SET lastseen = ".time()." WHERE type = 2 AND navn = '$hostname'");
		} // end if num != 0
		elseif(num($q) == 0) {
			query("INSERT INTO klienter SET lastseen = ".time().", type = 2, navn = '$hostname'");
		} // End elseif == 0

	} // End if empty clientname
