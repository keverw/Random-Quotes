<?php
ob_start();
require $_SERVER['DOCUMENT_ROOT'] . '/system/start.php';
$pageTitle = 'Search';
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/header.php';
if ($_GET['q'] != '')
{
	$searchTermbox = (isset($_GET['q'])) ? htmlspecialchars($_GET['q'], ENT_QUOTES) : '';
	$searchTerm = $_GET['q'];
	?>
	<table style="text-align: left; width: 900px;margin-left: auto;margin-right: auto;margin-top: 10px;" border="0" cellpadding="2" cellspacing="2">
	<tr>
	<td style="vertical-align: top; text-align: center;"  colspan="2"><form method="get" action="/search"> 
	<input name="q" value="<?=$searchTermbox?>" type="text" class="header_search_box">
	<input value="Search" type="submit"><br>
	</form>
	</td>
	</tr>
	<tr>
	<td style="vertical-align: top; text-align: right;"><?=$resultcount?> results</td>
	</tr>
	<tr>
	<td style="vertical-align: top;"><?=$resultshtml?></td>
	</tr>
	</table>
	<?php
}
else
{
	?>
	<div align="center">
	<h1>Search</h1>
	<form method="get" action="/search"> 
	<input name="q" size="30" type="text" class="header_search_box"> 
	<input value="Search" type="submit">
	</form>
	</div>
	<?php
}
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/footer.php';
ob_end_flush();
?>