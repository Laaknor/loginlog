<?php
require_once 'config.php';
require_once 'functions.php';


$hostname = $_GET['hostname'];

$time = time();


$qCheckKlient = query("SELECT * FROM klienter WHERE type = 2 AND navn = '".$hostname."'");
if(num($qCheckKlient) > 0) {
	//Klienten er brukt fra før, gjør ingenting
}

else {
	// Klienten har ikke vært i bruk før. Opprett den
	query("INSERT INTO klienter SET type = 2, navn = '".$hostname."', lastseen = ".$time);
}

// Legg inn i loggen at klienten er reinstallert

query("INSERT INTO images SET navn = '".$hostname."', restoretime = $time");