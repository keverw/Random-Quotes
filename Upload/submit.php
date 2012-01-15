<?php
ob_start();
require $_SERVER['DOCUMENT_ROOT'] . '/system/start.php';
$pageTitle = 'Submit Quote';
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/header.php';
if ($_GET['submitted'] == 1 && $_GET['qid'])
{
	$qid = mysql_real_escape_string($_GET['qid']);
	if ($qid)
	{
		$checkalreadySQL = mysql_query("SELECT * FROM quotes WHERE id = '$qid'");
		if(mysql_num_rows($checkalreadySQL) > 0) //already in database
		{
			$row = mysql_fetch_array($checkalreadySQL);
			$quote_url = create_url($siteurl,$row['id'],$row['author'],$row['text']);
			if ($row['approved'])
			{
				header('Location: ' . $quote_url);
			}
			else
			{
				?>
				<div id="submitted_text">You submitted a quote! An admin should review it soon!
				<br><br>
				<span>If approved you can view it at: <a href="<?=$quote_url?>"><?=$quote_url?></a></div></span>
				<?php
			}
		}
		else
		{
			force_404($siteurl);
            die();
		}
	}
	else
	{
		force_404($siteurl);
            die();
	}
}
else
{
	if ($_POST)
	{
		if ($_POST['author'] && $_POST['text'])
		{
			$author_name = mysql_real_escape_string(strip_tags($_POST['author']));
			$quote_text = mysql_real_escape_string(strip_tags($_POST['text']));
			
			$checkalreadySQL = mysql_query("SELECT * FROM quotes WHERE text = '$quote_text'");
			if(mysql_num_rows($checkalreadySQL) > 0) //already in database
			{
				$row = mysql_fetch_array($checkalreadySQL);
				if ($row['approved'])
				{
					header('Location: ' . create_url($siteurl,$row['id'],$row['author'],$row['text']));
				}
				else
				{
					header('Location: ' . $siteurl . 'submit?submitted=1&qid=' . $row['id']);
				}
			}
			else //Add to database
			{
				$unix_time = time();
				if (mysql_query("INSERT INTO quotes (`text`, `time`, `author`, `approved`) VALUES ('$quote_text', '$unix_time', '$author_name', '0')"))
				{
					$qid = mysql_insert_id();
					
					header('Location: ' . $siteurl . 'submit?submitted=1&qid=' . $qid);
				}
				else
				{
					$jsAlert = 'Database error! Try again later.';
				}
			}
		}
		else
		{
			$jsAlert = 'You must enter the Quote Text and Author.';
		}
	}
	?>        
	<form action="/submit" method="post" id="quotesubmitform">
		<table>
			<td colspan="2">
				<h1>Submit New Quote!</h1>
			</td>
			<tr valign="top">
				<td align="right" valign="top" style="vertical-align: top;"><label for="text_input">Quote Text</label></td>
				<td align="left"><textarea name="text" id="text_input" placeholder="Quotes text here"><?=$_POST['text']?></textarea></td>
			</tr>
			<tr>
				<td align="right"><label for="author_input">Author</label></td>
				<td align="left"><input type="text" name="author" id="author_input" placeholder="Author name here" value="<?=$_POST['author']?>" /></td>
			</tr>
			<tr>
				<td colspan="2">
				<input type="submit" value="Submit" class="blue" style="float: right;">
				</td>
			</tr>
		</table>
	</form>
	<?php
}
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/footer.php';
ob_end_flush();
?>