<?php
/*
 * Loginlog is copyright Lars Age Kamfjord.
 * October 2005 and for as long as it is programmed
 *
 * Contact me at lars-loginlog (at) kamfjord <dot> org
 */


mysql_connect("localhost", "login", "loginpass") or die(mysql_error());
mysql_select_db("loginlog") or die(mysql_error());

$TwoWeeksAgo = time() - (60*60*24*14);
$FourWeeksAgo = time() - (60*60*24*28);
$OneWeekAgo = time() - (60*60*24*7);



require_once 'functions.php';
