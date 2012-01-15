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
	   
	}
    else if ($_GET['do'] == 'aprove')
	{
	   
    }
    else if ($_GET['do'] == 'unaprove')
	{
	   
    }
    else if ($_GET['do'] == 'delete')
	{
	   
    }
	else
	{
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
				<td><strong>"<?=htmlentities($row['text'])?>"</strong>	
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
                
                <form style="display: inline;" action="/admin?do=aprove" method="post">
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
			echo '<b>ALL APROVED!</b>';
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