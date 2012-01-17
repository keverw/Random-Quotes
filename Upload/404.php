<?php
ob_start();
require_once 'system/start.php';
$pageTitle = 'Error 404 (Not Found)';
require_once 'system/includes/header.php';
?>
	404 WILL GO HERE
<?php
require_once 'system/includes/footer.php';
ob_end_flush();
?>