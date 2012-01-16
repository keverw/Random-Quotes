<?php
ob_start();
require $_SERVER['DOCUMENT_ROOT'] . '/system/start.php';
$pageTitle = 'Admin';
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/header.php';

if ($_GET['do'] == 'logout')
{
	session_destroy();
	header('location: admin');
}

if ($isAdmin)
{
	if ($_GET['do'] == 'edit')
	{
		if ($_POST['qid'])
		{
			$qid = mysql_real_escape_string($_POST['qid']);
		}
		else if ($_SESSION['edit_id'])
		{
			$qid = mysql_real_escape_string($_SESSION['edit_id']);
			$_SESSION['edit_id'] = 0;
		}
		else
		{
			$qid = 0;
		}
		
		$checkalreadySQL = mysql_query("SELECT * FROM quotes WHERE id = $qid");
		if(mysql_num_rows($checkalreadySQL) > 0) //already in database
		{
			$row = mysql_fetch_array($checkalreadySQL);
			?>
				<table width="100%">
		<tr>
		<td align="center">
			<form style="display: inline;" action="/admin?do=save" method="post">
				<table>
				<tr>
				<td><textarea name="text" id="text_input" placeholder="Quotes text here" style="width: 256px;  height: 64px;  resize: none;margin-top: 20px;"><?=$row['text']?></textarea>	
				</td>
				</tr>
				<tr>
				<td><b>Author: </b><input type="text" name="author" id="author_input" placeholder="Author name here" value="<?=$row['author']?>" style="width: 208px;" /></td>
				</tr>
				<tr>
				<td>Submitted: <b><?=date("M j Y g:i A T", $row['time'])?></b></td>
				</tr>
				<tr>
				<td>
				<input type="hidden" name="qid" value="<?=$row['id']?>"/>
				<input type="submit" value="Save" class="blue" />
				</form>
				<form style="display: inline;" action="/admin?do=unapprove" method="post">
				<input type="hidden" name="qid" value="<?=$row['id']?>"/>
				<input type="submit" value="Unapprove" />
				</form>
				<form style="display: inline;" action="/admin?do=delete" method="post">
				<input type="hidden" name="qid" value="<?=$row['id']?>"/>
				<input type="submit" value="Delete" class="red" />
				</form>
				
				</td>
				</tr>
				</table>
				</td>
		</tr>
		</table>
				<hr />
			<?php
		}
		else
		{
			$_SESSION['notfound'] = 1;
			header('location: admin');
		}
	}
	else if ($_GET['do'] == 'approve')
	{
		$qid = mysql_real_escape_string($_POST['qid']);
		$checkalreadySQL = mysql_query("SELECT * FROM quotes WHERE id = $qid");
		if(mysql_num_rows($checkalreadySQL) > 0) //already in database
		{
			$row = mysql_fetch_array($checkalreadySQL);
			if ($row['approved'] == 0)
			{
				if (mysql_query("UPDATE quotes SET approved = 1 WHERE id = $qid"))
				{
					$_SESSION['wasapproved'] = 1;
					header('location: admin');
				}
				else
				{
					$_SESSION['databasewriteerror'] = 1;
					header('location: admin');
				}
			}
			else
			{
				$_SESSION['approvedalready'] = 1;
				header('location: admin');
			}
		}
		else
		{
			$_SESSION['notfound'] = 1;
			header('location: admin');
		}
	}
	else if ($_GET['do'] == 'unapprove')
	{
		$qid = mysql_real_escape_string($_POST['qid']);
		$checkalreadySQL = mysql_query("SELECT * FROM quotes WHERE id = $qid");
		if(mysql_num_rows($checkalreadySQL) > 0) //already in database
		{
			$row = mysql_fetch_array($checkalreadySQL);
			if ($row['approved'] == 1)
			{
				if (mysql_query("UPDATE quotes SET approved = 0 WHERE id = $qid"))
				{
					$_SESSION['wasunapproved'] = 1;
					header('location: admin');
				}
				else
				{
					$_SESSION['databasewriteerror'] = 1;
					header('location: admin');
				}
			}
			else
			{
				$_SESSION['unapprovedalready'] = 1;
				header('location: admin');
			}
		}
		else
		{
			$_SESSION['notfound'] = 1;
			header('location: admin');
		}
	}
	else if ($_GET['do'] == 'delete')
	{
		$qid = mysql_real_escape_string($_POST['qid']);
		$checkalreadySQL = mysql_query("SELECT * FROM quotes WHERE id = $qid");
		if(mysql_num_rows($checkalreadySQL) > 0) //already in database
		{
			if (mysql_query("DELETE FROM quotes WHERE id = $qid"))
			{
				$_SESSION['wasdeleted'] = 1;
				header('location: admin');
			}
			else
			{
				$_SESSION['databasewriteerror'] = 1;
				header('location: admin');
			}
		}
		else
		{
			$_SESSION['notfound'] = 1;
			header('location: admin');
		}
	}
	else if ($_GET['do'] == 'save')
	{
		$qid = mysql_real_escape_string($_POST['qid']);
		$checkalreadySQL = mysql_query("SELECT * FROM quotes WHERE id = $qid");
		if(mysql_num_rows($checkalreadySQL) > 0) //already in database
		{
				$author_name = mysql_real_escape_string(strip_tags($_POST['author']));
				$quote_text = mysql_real_escape_string(strip_tags($_POST['text']));
				if (mysql_query("UPDATE quotes SET text = '$quote_text', author = '$author_name' WHERE id = $qid"))
				{
					$_SESSION['edit_id'] = $qid;
					header('location: admin?do=edit');
				}
				else
				{
					$_SESSION['databasewriteerror'] = 1;
					header('location: admin');
				}
		}
		else
		{
			$_SESSION['notfound'] = 1;
			header('location: admin');
		}
	}
	else
	{
		//Error and wining messages
		if ($_SESSION['notfound'])
		{
			$jsAlert = 'Quote not found!';
			$_SESSION['notfound'] = 0;
		}
		
		if ($_SESSION['approvedalready'])
		{
			$jsAlert = 'Quote was already approved!';
			$_SESSION['approvedalready'] = 0;
		}
		
		if ($_SESSION['unapprovedalready'])
		{
			$jsAlert = 'Quote was already unapproved!';
			$_SESSION['unapprovedalready'] = 0;
		}

		if ($_SESSION['wasunapproved'])
		{
			$jsAlert = 'Quote was unapproved!';
			$_SESSION['wasunapproved'] = 0;
		}
		
		if ($_SESSION['databasewriteerror'])
		{
			$jsAlert = 'Error writing to database!';
			$_SESSION['databasewriteerror'] = 0;
		}
		
		if ($_SESSION['wasapproved'])
		{
			$jsAlert = 'Quote was approved!';
			$_SESSION['wasapproved'] = 0;
		}
		
		if ($_SESSION['wasdeleted'])
		{
			$jsAlert = 'Quote was deleted!';
			$_SESSION['wasdeleted'] = 0;
		}
		
		//Stats
		$pending_sql = mysql_query('SELECT COUNT(*) AS num FROM quotes WHERE approved = 0');
		$pending_row = mysql_fetch_assoc($pending_sql);
		$pending = $pending_row['num'];
		
		$approved_sql = mysql_query('SELECT COUNT(*) AS num FROM quotes WHERE approved = 1');
		$approved_row = mysql_fetch_assoc($approved_sql);
		$approved = $approved_row['num'];
		?>
		<div style="margin-left:20px;margin-top: 10px;">
		<b>Pending:</b> <?=formatMoney($pending)?>
		<br>
		<b>Approved:</b> <?=formatMoney($approved)?>
		<br>
		<?php
		$total = $approved + $pending;
		?>
		<b>Total:</b> <?=formatMoney($total)?>
		</div>
		<br>
		<div align="center"><h1>Unapproved Quotes(Shows 10 at a time)</h1></div>
		<hr />
		<table width="100%">
		<tr>
		<td align="center">
		<?php
		$results = mysql_query("SELECT * FROM quotes WHERE approved = 0 ORDER BY time LIMIT 10");
		if(mysql_num_rows($results) > 0)
		{
			while($row = mysql_fetch_array($results))
			{
				?>
				<table>
				<tr>
				<td><b>"<?=htmlentities($row['text'])?>"</b>	
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
				
				<form style="display: inline;" action="/admin?do=approve" method="post">
				<input type="hidden" name="qid" value="<?=$row['id']?>"/>
				<input type="submit" value="Approve" class="blue" />
				</form>
				<form style="display: inline;" action="/admin?do=edit" method="post">
				<input type="hidden" name="qid" value="<?=$row['id']?>"/>
				<input type="submit" value="edit"/>
				</form>
				<form style="display: inline;" action="/admin?do=delete" method="post">
				<input type="hidden" name="qid" value="<?=$row['id']?>"/>
				<input type="submit" value="Delete" class="red" />
				</form>
				
				</td>
				</tr>
				</table>
				<hr />
				<?php
			}
		}
		else
		{
			echo '<b>All Approved! Great Job!</b>';
		}
		?>
		</td>
		</tr>
		</table>
		<?php
	}
}
else
{
	if ($_GET['do'] == 'login')
	{
		if ($_POST['user'] && $_POST['password'])
		{
			$username = mysql_real_escape_string($_POST['user']);
			$password = mysql_real_escape_string(md5($_POST['password']));
			
			$result = mysql_query("SELECT * FROM admins WHERE user='$username' and pass='$password'");
			
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result);		
				$_SESSION['uid'] = $row['uid'];
				$_SESSION['user'] = $row['user'];
				$_SESSION['pass'] = $row['pass'];
				header('location: admin');
			}
			else
			{
				$jsAlert = 'Wrong Username or Password!';
			}
		}
		else
		{
			$jsAlert = 'You must enter a username and password!';
		}
	}
	?>
	<div align="center" style="margin-top: 15px;">
	<form action="/admin?do=login" method="post">
	<b>Username:</b> <input name="user" type="text" />
	<br />
	<b>Password:</b> <input name="password" type="password" />
	<br />
	<input type="submit" value="Submit" />
	</form>
	</div>
	<?php
}
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/footer.php';
ob_end_flush();
?>