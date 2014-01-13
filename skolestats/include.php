<?php

require_once 'config.php';
require_once 'functions.php';

## Setter $_SESSION-stuff
session_start();

if(!empty($_GET['skole'])) {
	// Setter $_SESSION['skole'] til $_GET['skole'];
	$_SESSION['skole'] = $_GET['skole'];
	query("INSERT INTO guestbook SET skole = '".$_GET['skole']."',
		userIP = '".$_SERVER['REMOTE_ADDR']."',
		logintime = ".time());
	header("Location: index.php");
}

if(!empty($_GET['showmeny'])) {
	// Setter $_SESSION['showmeny'] til $_GET'en
	$_SESSION['showmeny'] = $_GET['showmeny'];
	header("Location: index.php");
}

if(empty($_SESSION['skole'])) {
	header("Location: beklager.html");
}
#print_r($_SESSION);



$TwoWeeksAgo = time() - (60*60*24*14);
$FourWeeksAgo = time() - (60*60*24*28);
$OneWeekAgo = time() - (60*60*24*7);
$ThreeMonthsAgo = time() - (60*60*24*30*3);







## Set up Smarty-stuff
require 'includes/smarty/libs/Smarty.class.php';
$smarty = new Smarty();

$smarty->template_dir = 'templates/';
$smarty->compile_dir = 'tmp/templates_compile';
$smarty->config_dir = 'inc/smarty/';
$smarty->cache_dir = 'tmp/templates_cache/';



$s = $_SERVER["SERVER_SOFTWARE"];

if(stristr($s, "PHP/5")) {
	include_once 'includes/JPGraph/jpgraph5/jpgraph.php';
	include_once 'includes/JPGraph/jpgraph5/jpgraph_bar.php';
}
else {
	include_once 'includes/JPGraph/jpgraph4/jpgraph.php';
	include_once 'includes/JPGraph/jpgraph4/jpgraph_bar.php';
}