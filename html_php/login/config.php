<?php


	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '104748210338114',
		'app_secret' => 'b53d6ee825faeb36b45ea930a6746492',
		'default_graph_version' => 'v2.11'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>