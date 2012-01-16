<?php
ob_start();
require $_SERVER['DOCUMENT_ROOT'] . '/system/start.php';
$pageTitle = 'Search';
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/header.php';
if ($_GET['q'] != '')
{
	$searchTermbox = (isset($_GET['q'])) ? htmlspecialchars($_GET['q'], ENT_QUOTES) : '';
	$searchTerm = mysql_real_escape_string($_GET['q']);
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
	<td>
	<?php
	$SQL_search = mysql_query("SELECT * 
FROM quotes 
WHERE text LIKE '%$searchTerm%' 
    OR author LIKE '%$searchTerm%' 
LIMIT 15");
	if(mysql_num_rows($SQL_search) > 0) //already in database
	{
	?>
	<table width="100%" style="margin-top: 20px;margin-left: 125px;">
		<tr>
		<td align="left">
		<?php
		while($row = mysql_fetch_array($SQL_search))
			{
			$display_url = create_url($siteurl,$row['id'],$row['author'],$row['text']);
			?>
			<table>
				<tr>
				<td><b>"<a href="<?=$display_url?>"><?=htmlentities($row['text'])?>"</a></b>	
				</td>
				</tr>
				<tr>
				<td>Author:<b><?=htmlentities($row['author'])?></b></td>
				</tr>
				<tr>
				<td>Submitted: <b><?=date("M j Y g:i A T", $row['time'])?></b></td>
				</tr>
				<tr>
				<td>
				<?=$display_url?>
				</td>
				</tr>
				</table>
				<hr style="width: 725px;">
			<?php
			}
			?>
			</td>
				</tr>
				</table>
			<?php
	}
	else
	{
		?>
		<div align="center"><b>None Found!</b></div>
		<?php
	}
	?>
	</td>
	</tr>
	</table>
	<?php
}
else
{
	?>
	<div align="center">
	<h2>Search</h2>
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