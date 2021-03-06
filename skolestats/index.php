<?php

include 'include.php';

if(!empty($_GET['module'])) {
	include_once 'module/'.$_GET['module'].'.php';
}
elseif(empty($_GET['module'])) {
	include_once 'module/main.php';

}


$menu = "<li><a href=index.php>Hovedsiden</a>";
$menu .= "<li><a href=?showmeny=skolenett>SkoleNett</a>\n";
$menu .= "<li><a href=?showmeny=kommune>Kommunen</a>\n";
$menu .= "<li><a href=?showmeny=skolen>Skolen</a>\n";


if($_SESSION['showmeny'] == 'skolenett') {
	// Vi skal vise alt om skolenettet
	#$submenu = '<li>Hele skolenett';
	$submenu = '<li><a href=?module=graphs&amp;graphs=skolenett_logins_pr_uke>P�logginger pr. uke</a>';
	$submenu .= '<li><a href=?module=graphs&amp;graphs=skolenett_klienterprskole>Klienter pr. skole</a>';
	$submenu .= '<li><a href=?module=graphs&amp;graphs=skolenett_klientlast>Belastning pr. maskin pr. skole</a>';
	$submenu .= '<li><a href=?module=graphs&amp;graphs=skolenett_loginsprskole>P�logginger pr. skole</a>';
	if($_SESSION['skole'] == 'IKT') {
		$submenu .= "<hr>";
		$submenu .= "<li><a href=?module=mistenkelige_klienter>Mistenkelige klienter</a>";
		$submenu .= "<li><a href=?module=siste_logins>Siste innlogginger totalt</li>";
	}

}
elseif($_SESSION['showmeny'] == 'kommune') {
	// Vis innen egen kommune
	$submenu = '<li>Bare egen kommune';

}

elseif($_SESSION['showmeny'] == 'skolen') {
	// Vis innen egen skole
	#$submenu = '<li>Bare egen skole';
	$submenu = '<li><a href=?module=klientliste>Liste over skolens maskiner</a>';

}



$smarty_display = 'SkoleStats.tpl';

$smarty->assign("content", $content);
$smarty->assign("Header", 'Hei på deg');
$smarty->assign("menu", $menu);
$smarty->assign("submenu", $submenu);
$smarty->assign("title", "SkoleNett statistikk");
$smarty->assign("head", $head);

$smarty->display($smarty_display);
