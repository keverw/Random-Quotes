<?php
ob_start();
require $_SERVER['DOCUMENT_ROOT'] . '/system/start.php';
$pageTitle = 'About';
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/header.php';
?>
	CONTENT WILL GO HERE
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/system/includes/footer.php';
ob_end_flush();
?>