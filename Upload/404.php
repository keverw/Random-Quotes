<?php
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/start.php';
$pageTitle = 'Error 404 (Not Found)';
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/includes/header.php';
?>
	404 WILL GO HERE
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/includes/footer.php';
ob_end_flush();
?>