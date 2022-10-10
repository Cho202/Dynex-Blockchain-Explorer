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

	// get last calculated supply:
	$supply = get_last_supply();
	$supply_block = intval(explode(';',$supply)[0]);
	$supply_supply = intval(explode(';',$supply)[1]);
	
	// do we need an update?
	if ($top_block>$supply_block) {
		//then add the missing ones:
		for ($i = $supply_block+1; $i <= $top_block; $i++) {
			$data = get_block($i);
			$mined = intval($data['dnxmined']);
			$supply_block = $i;
			$supply_supply = $supply_supply + $mined;
			//echo 'updated supply for block '.$i.' mined: '.$mined.' total: '.$supply_supply.'<br>';
			usleep(10000);
		}
		save_last_supply($supply_block,$supply_supply);
	}
	
	// add total supply:
	$output['total_supply'] = $supply_supply;
	$output['total_supply_block'] = $supply_block;
	
	$data = get_block($top_block);
	$output['top_block'] = $data;

	
	echo json_encode($output)."\n";

	//echo '<pre>';
	//print_r($output);
	//echo '</pre>';
	
?>
						