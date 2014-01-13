<?php

require_once 'config.php';

$q = mysql_query("SELECT username,hostname,clientname,company AS skole,title,department AS trinn,location AS klasse,dato,tid FROM loginlog ORDER BY ID DESC LIMIT 0,50;");


echo '<table>';

$column_count = mysql_num_fields($q);

// Display <th>s
for ($column_num = 0;$column_num < $column_count; $column_num++) {
#while($column_num = 1;$column_num < $column_count ; $column_num++ ) {
	$field_name = mysql_field_name($q, $column_num);
	echo "<th>$field_name</th>";
}
$num_rows = mysql_num_rows($q);
for($i =0; $i<$num_rows; $i++) {
	echo "<tr>";
	for($y=0;$y<$column_count;$y++) {
		$k = mysql_result($q, $i, $y);
		echo "<td>$k</td>";
	} // End for
	$i++;
	echo "</tr>";
} // end while
