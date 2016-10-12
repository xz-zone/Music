<?php
	$filename = $_GET['c']; //文件路径
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".basename($filename));
	readfile($filename);
?>