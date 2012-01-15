<!DOCTYPE html>
<html>
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title><?php
	if ($pageTitle)
	{
		if (($_SESSION['id']) || ($_SESSION['oldpassSess'])) //Logged in
		{
			echo $pageTitle;
		}
		else //Logged out - shows page title only
		{
			echo $mastertitle . ' - ' . $pageTitle;
		}
	}
	else
	{
		echo $mastertitle;
	}
	?></title>
	  <link rel="stylesheet" type="text/css" href="/main.css" />
	</head>
	<body>
		<div id="container">
			<div id="header" class="clearfix">
					<div id="header_left">
						<a href="/" title="<?=$mastertitle?>, <?=$siteslogan?>">
							<img src="/logo.png" alt="<?=$mastertitle?>, <?=$siteslogan?>">
						</a>
					</div>
					<div id="header_right">
					<?php
					if ($isAdmin)
					{
						?>
						<div id="header_top">
							<ul>
								<li><a href="/admin">Admin Panel</a></li>
								<li><a href="/admin?do=logout">Admin Logout</a></li>
							</ul>
						</div>
						<?php
					}
					?>
						<div id="header_bottom">
							<form action="/search">
								<input type="text" name="q" id="header_search_box" placeholder="Search..." />
								<input type="submit" value="Search" />
							</form>
						</div>
					</div>
			</div>
			<div id="headermenu_wrap" class="clearfix">
				<div id="headermenu" class="clearfix">
					<ul>
						<li><a href="/" title="Random Quote">Random Quote</a></li>
						<li><a href="/submit" title="Submit Quote">Submit Quote</a></li>
						<li><a href="/about" title="About">About</a></li>
					</ul>
				</div>
			</div>
			<div id="content" class="clearfix">