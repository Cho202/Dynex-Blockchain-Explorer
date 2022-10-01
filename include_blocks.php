<?php
	include 'include_logincheck.php';
	// GET CURRENT HEIGHT (AGAIN):
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $DAEMON_ENDPOINT);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getlastblockheader\"}"); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	} else {
		$response_json = json_decode($response,true);
		$data = $response_json['result']['block_header'];
	}
	curl_close($ch);
	$height = $data['height'];

	// SHOW LAST 10 BLOCKS:
	echo '<table class="fs-12 text-silver" width="100%">';
	echo '<th>BLOCK</th>';
	echo '<th>TIMESTAMP</th>';
	echo '<th>BLOCK HASH</th>';
	echo '<th>MINER UNLOCK</th>';
	echo '<th class="text-right">TRANSACTIONS</th>';
	for ($i = $height; $i >= $height-19; $i--) {
		// -------------------------------------------------------------------------------------------------------------------------------
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $DAEMON_ENDPOINT);
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblock\",\"params\":{\"height\":".$i."}}");
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $response = curl_exec($ch);
	    if (curl_errno($ch)) {
	    	echo 'Error:' . curl_error($ch);
		} else {
			// special case, dealing with " in front and end of field blockinfo
			$response  =str_replace( '"blockinfo":"{"', '"blockinfo":{"', $response );
			$response = str_replace( '}","status":"OK"', '},"status":"OK"', $response );
			$response_json = json_decode($response,true);
			$data = $response_json['result']['blockinfo'];
			$block_id = $response_json['result']['block_id'];
		}
		curl_close($ch);
		// -------------------------------------------------------------------------------------------------------------------------------
    	echo '<tr class="border-dark border-bottom" style="border-top: none; border-bottom: none;">';
    	echo '<td>'.$i.'</td>';
    	echo '<td>'.gmdate("Y-m-d\TH:i:s\Z", $data['timestamp']).'</td>';
    	echo '<td><a class="text-blue" href="show_block.php?block='.$i.'">'.$block_id.'</a></td>';
    	
    	$until_unlock = $height - $data['miner_tx']['unlock_time'];
    	if ($until_unlock>=0) {
    		$until_unlock_str = '<i class="fa fa-unlock text-green"></i> ';
    	} else {
    		$until_unlock_str = '<i class="fa fa-lock text-silver"></i> '.abs($until_unlock).' LEFT';
    	}
    	
    	echo '<td>'.$data['miner_tx']['unlock_time'].' '.$until_unlock_str.'</td>';
    	echo '<td class="text-right">'.count($data['tx_hashes']).'</td>';
    	echo '</tr>';
	}
	echo '<table>';
?>