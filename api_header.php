<?php 
	header('Content-Type: application/json; charset=utf-8');
	
	
	$DAEMON_ENDPOINT = "http://localhost:18333/json_rpc";
	$DAEMON_RAW_ENDPOINT = "http://localhost:18333";
	$block = 10000;

	include "api_functions.php"; // required functions for API

	//save_last_supply(0,0);

	// create output array:
	$output = array();

	// load block header:
	
	$block_header = get_block_header();
	$output['block_header'] = $block_header;
	
	echo json_encode($output)."\n";

	//print_r($output);
	
?>
						