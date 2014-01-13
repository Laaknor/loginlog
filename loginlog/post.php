<?php
require_once 'config.php';

$action = $_GET['action'];

$importfile = "/opt/log.txt";

$fp = fopen($importfile, "r");
while(!feof($fp)) {
	$line = fgets($fp);
	$ar = explode("::", $line);

	$username = $ar[0];
	$hostname = $ar[1];
	$date = explode(".",$ar[2]);
	$time = substr($ar[3], 0, 8);
#	$clientname = strrrchr($ar[4], "\n");
#	$clientname = strip_tags(nl2br($ar[4]));
	$clientname = str_replace("\n", "", $ar[4]);
	$clientname = str_replace("\r", "",$clientname);
	$toconvert = $date[1]."/".$date[0]."/".$date[2]." ".$time;
#	echo $toconvert;
	$convert = strtotime($toconvert);
	$context = $ar[5];
	$shellversion = $ar[7];
	
	$last = str_replace("\n", "",$ar[8]);
	$last = str_replace("\r", "",$last);

	$company = $ar[6];
	$loginserver = $last;
#	echo $convert;
#	echo $username.$hostname.$time.$clientname.$convert."\n";
	if(!empty($username)) {
		query("INSERT INTO loginlog SET
			username = '".mysql_real_escape_string($username)."',
			hostname = '".mysql_real_escape_string($hostname)."',
			unixtime = $convert,
			clientname = '".mysql_real_escape_string($clientname)."',
			context = '$context',
			company = '$company',
			shellversion = '$shellversion',
			loginserver = '$loginserver',
			addtime = ".time());


#	$convertback = date("d.m.Y G:i:s", $convert);
#	if($convertback != $ar[2]."::".$time) echo $ar[2]."::".$time." konverterte helt feil og ble ".$convertback."\n";

#	echo $username."::".$hostname."::".$convert."::".$clientname."\n";
	} // End if isset($username)

	if(!empty($clientname)) {
		$q = query("SELECT * FROM klienter WHERE type = 1 AND navn LIKE '$clientname'");
		if(num($q) != 0) {
			query("UPDATE klienter SET lastseen = ".time()." WHERE type = 1 AND navn = '$clientname'");
		} // End if num != 0


	} // End if !empty clientname

	if(empty($clientname)) {
		$q = query("SELECT * FROM klienter WHERE type = 2 AND navn LIKE '$hostname'");
		if(num($q) != 0) {
			query("UPDATE klienter SET lastseen = ".time()." WHERE type = 2 AND navn = '$hostname'");
		} // end if num != 0

	} // End if empty clientname
} // end while
fclose($fp);

/*
if(!isset($action)) {
echo "<html><head><title>Legg inn nytt i loggen</title></head>
<body>
<b>Syntax:</b>Brukernavn::Maskinnavn::dd.mm.yyyy::tt:mm:ss,ss::<i>tsclient</i>
<form method=POST action=post.php?action=add>
<textarea name=log rows=20 cols=75></textarea>
<br><input type=submit value='Legg inn i databasen'>
</form>

</body></html>


";

} // End if(!isset($action))

elseif($action == "add") {
	$log = $_POST['log'];

#	echo count($log);


}

*/
