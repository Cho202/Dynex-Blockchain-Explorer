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
	$top_block = intval($block_header['last_known_block_index']);

	$data = get_block($top_block);
	$output['top_block'] = $data;

	
	//echo '<pre>'; print_r($output); echo '</pre>';


	echo json_encode($output)."\n";

	//echo '<pre>';
	//print_r($output);
	//echo '</pre>';
	
?>
						