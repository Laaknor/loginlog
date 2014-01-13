<?php
require_once 'include.php';
$editID = $_GET['editID'];
$modell = $_POST['modell'];
$bruk = $_POST['bruk'];
$kommentar = $_POST['kommentar'];
$order = $_GET['order'];
$skole = $_GET['skole'];



query("UPDATE klienter SET modell = '".$modell."',
	bruksmonster = '".$bruk."',
	kommentar = '".$kommentar."'
	WHERE ID = ".$editID);

header("Location: skoleliste.php?skole=$skole&order=$order");
