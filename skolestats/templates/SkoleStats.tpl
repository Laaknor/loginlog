<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head><title>{$title}</title>
<link rel=stylesheet href=styles.css type=stylesheet>
{$head}
</head>
<body>
<center><h1>SkoleNett</h1></center>

<!-- I know, I really should learn to program CSS some day... -->
<table>
<tr><td width=10% valign=top>

<div class=menu>
<ul>
{$menu}
</ul>
<br><hr><br>
<ul>
{$submenu}
</ul>
</div>

</td><td>{$content}</td>

</tr>
</table>


</body></html>