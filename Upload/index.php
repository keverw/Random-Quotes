<?php
ob_start();
require $_SERVER['DOCUMENT_ROOT'] . '/system/start.php';
$pageTitle = $siteslogan;
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/header.php';

if ($_GET['qid'])
{
	$qid = mysql_real_escape_string($_GET['qid']);
	$checkalreadySQL = mysql_query("SELECT * FROM quotes WHERE id = $qid AND approved = 1");
	if(mysql_num_rows($checkalreadySQL) > 0) //already in database
	{
		$row = mysql_fetch_array($checkalreadySQL);
		$q_id = $row['id'];
		$q_author = $row['author'];
		$q_text = $row['text'];
		$q_time = $row['time'];
	}
	else
	{
		header('Location: ' . $siteurl);
	}
}
else
{
	$Loadrandom = true;
}

if ($Loadrandom)
{
	$getRandomSQL = mysql_query("SELECT id FROM quotes WHERE approved = 1 ORDER BY RAND() limit 1");
	if(mysql_num_rows($getRandomSQL) > 0)
	{
		$rand_row = mysql_fetch_array($getRandomSQL);
		$qid = $rand_row['id'];
		$checkalreadySQL = mysql_query("SELECT * FROM quotes WHERE id = $qid AND approved = 1");
		if(mysql_num_rows($checkalreadySQL) > 0) //already in database
		{
			$row = mysql_fetch_array($checkalreadySQL);
			$q_id = $row['id'];
			$q_author = $row['author'];
			$q_text = $row['text'];
			$q_time = $row['time'];
		}
		else
		{
			$nonefound = true;
		}
	}
	else
	{
		$nonefound = true;
	}
}

if (!$nonefound)
{
	if ($q_time)
	{
		$display_time = date("M j Y g:i A T", $q_time);
	}
	
	$display_url = create_url($siteurl,$q_id,$q_author,$q_text);
	?>
		<div id="quote_block" class="clearfix">
			<div id="quote_text">
				<blockquote>
					<?=htmlentities($q_text)?>
				</blockquote>
			</div>
			<div id="quote_meta" class="clearfix">
				<div id="quote_author">Author: <span><?=htmlentities($q_author)?></span></div>
				<div id="quote_date">Submitted: <span><?=$display_time?></span></div>
			</div>
			<div id="quote_url" class="clearfix"><span>Share this: </span><input type="text" value="<?=$display_url?>" onClick="this.select();">
			</div>
			<div id="quote_socialsharing" class="clearfix">
				<div id="quote_socialsharing_inside">
				<div id="twitter_icon" class="clearfix">
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=$display_url?>"<?php
					if ($siteTwitterUser)
					{
						echo ' data-related="' . $siteTwitterUser . '"';
					}
					?>
					>Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>
					<div id="fb_icon">
						<iframe src="http://www.facebook.com/plugins/like.php?href=<?=$display_url?>&amp;layout=standard&amp;show_faces=false&amp;width=260&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=28" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:260px; height:28px;" allowTransparency="true" class="social_left"></iframe>
					</div>
					<div id="plus_icon" class="clearfix">
						<g:plusone annotation="inline" width="200" href="<?=$display_url?>"></g:plusone>
							<!-- Place this render call where appropriate -->
								<script type="text/javascript">
									(function() {
										var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
										po.src = 'https://apis.google.com/js/plusone.js';
										var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
										  })();
								</script>
					</div>
				</div>
			</div>
		</div>
		<div id="quote_buttons" align="center">
			<input type="button" value="Show me a random quotes" onClick="window.location.href=window.location.href">
		</div>
	<?php
}

if ($nonefound)
{
	?>
		<div id="nonefound_text">
			No quote's found. <a href="/submit">Why not go ahead and submit one?</a>
		</div>
	<?php
}
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/footer.php';
ob_end_flush();
?>