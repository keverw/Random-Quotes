<?php
ob_start();
require 'system/start.php';
$pageTitle = 'About';
require 'system/includes/header.php';
?>
	CONTENT WILL GO HERE
<?php
require 'system/includes/footer.php';
ob_end_flush();
?>