<?php


function query($query)
{
        $q = mysql_query($query) or die("Error with query: $query, error returned: ".mysql_error());
        return $q;
}

function fetch($q)
{
        $r = mysql_fetch_object($q);
        return $r;
}


function num ($q)
{
        return mysql_num_rows ($q);
}

function strrrchr($haystack,$needle)
{

   // Returns everything before $needle (inclusive).
   return substr($haystack,0,strpos($haystack,$needle)+0);
  
}
