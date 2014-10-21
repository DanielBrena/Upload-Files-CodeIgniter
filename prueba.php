<?php 

	$url = parse_url("ht2tp://www.google.com");

	var_export($url);

	echo ($url["scheme"] == "http") ? TRUE :FALSE;

	$url2 = parse_url("asdasdasd");

	echo date('Y-m-d H:i:s');

 ?>