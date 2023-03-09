<?php 
	$DAEMON_ENDPOINT = "http://localhost:18333/json_rpc";
	$DAEMON_RAW_ENDPOINT = "http://localhost:18333";
	$block = 10000;

	include "api_functions.php"; // required functions for API

	$block_header = get_block_header();
	echo $block_header['already_generated_coins'];

?>
						