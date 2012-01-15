<?php
// database login stuffs.
$db_host = 'localhost';
$db_username = 'root'; 
$db_pass = ''; 
$db_name = 'randomquotes';
// database Connection stuffs.
mysql_connect($db_host,$db_username,$db_pass) or die ('Could not connect to mysql');
mysql_select_db($db_name) or die ('No database');
//Site title
$mastertitle = 'Random Quotes';
$siteslogan = 'Awesome Random Quotes for you!';
$siteurl = 'http://10.0.1.5/';
$siteTwitterUser = 'Keverw';
?>