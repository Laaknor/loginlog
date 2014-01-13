<?php /* Smarty version 2.6.18, created on 2008-02-19 10:07:03
         compiled from SkoleStats.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head><title><?php echo $this->_tpl_vars['title']; ?>
</title>
<link rel=stylesheet href=styles.css type=stylesheet>
<?php echo $this->_tpl_vars['head']; ?>

</head>
<body>
<center><h1>SkoleNett</h1></center>

<!-- I know, I really should learn to program CSS some day... -->
<table>
<tr><td width=10% valign=top>

<div class=menu>
<ul>
<?php echo $this->_tpl_vars['menu']; ?>

</ul>
<br><hr><br>
<ul>
<?php echo $this->_tpl_vars['submenu']; ?>

</ul>
</div>

</td><td><?php echo $this->_tpl_vars['content']; ?>
</td>

</tr>
</table>


</body></html>