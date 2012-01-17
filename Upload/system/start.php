<?php
session_start();
mb_language('uni');
mb_internal_encoding('UTF-8');
require 'config.php';

function create_slug($string)
{
	$string = strtolower($string); //make loverspaces
	$string = str_replace('\'s', 's', $string); //replace 's with just s
	$string = preg_replace("/\ $/",'',$string); //remove last space
	$string = preg_replace("/\.$/",'',$string); //remove last period
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string); //convert spaces to dash
	$slug = preg_replace("/\-$/",'',$slug); //remove last dash
	return $slug;
}

function create_url($siteurl,$qid,$author,$text)
{
	$author_slug = create_slug(substr($author, 0, 30));
	$text_slug = create_slug(substr($text, 0, 50));
	return $siteurl . 'q/' . $qid . '/' . $author_slug . '/' . $text_slug . '/';
}

function force_404($siteurl)
{
	header('Location: ' . $siteurl . '404?url=' . $_SERVER['REQUEST_URI']);
	die();
}

function formatMoney($number)
{
	while (true)
	{
		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
		if ($replaced != $number)
		{
			$number = $replaced;
		}
		else 
		{
			break;
		}
	}
	return $number; 
}

if ($_SESSION['uid'])
{
	$uid = $_SESSION['uid'];
	$admin_result = mysql_query("SELECT * FROM admins WHERE uid = $uid "); //kill session if account got deleted it
	if(mysql_num_rows($admin_result) > 0)
	{
		$row = mysql_fetch_array($admin_result);		
		
		if ($_SESSION['uid'] == $row['uid'] && $_SESSION['user'] == $row['user'] && $_SESSION['pass'] == $row['pass']) //check if account details match the same as when they logged in
		{
			$isAdmin = 1;
		}
		else
		{
			session_destroy();
		}
	}
	else
	{
		session_destroy();
	}
}
?>