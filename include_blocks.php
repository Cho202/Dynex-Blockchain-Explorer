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
	echo '<th>TIME</th>';
	echo '<th>BLOCK HASH</th>';
	echo '<th class="text-right">FEES</th>';
	echo '<th class="text-right">REWARD</th>';
	echo '<th class="text-right">SIZE</th>';
	echo '<th class="text-right">MINER UNLOCK</th>';
	echo '<th class="text-right">TRANSACTIONS</th>';
	for ($i = $height; $i >= $height-39; $i--) { //39
		//echo '<pre>Retreiving i='; echo $i; echo '</pre>';
		// -------------------------------------------------------------------------------------------------------------------------------
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $DAEMON_ENDPOINT);
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblockbyheight\",\"params\":{\"blockHeight\":".$i."}}");
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $response = curl_exec($ch);
	    if (curl_errno($ch)) {
	    	echo 'Error:' . curl_error($ch);
		} else {
			// special case, dealing with " in front and end of field blockinfo
			$response_json = json_decode($response,true);
			$data = $response_json['result']['block'];
			$block_id = $data['hash'];
		}
		curl_close($ch);
		//echo '<pre>block_id='; print_r($block_id); echo '</pre>';
		if ($block_id != "") {
			// -------------------------------------------------------------------------------------------------------------------------------
	    	echo '<tr class="border-dark border-bottom" style="border-top: none; border-bottom: none;">';
	    	echo '<td>'.$i.'</td>';
	    	echo '<td>'.gmdate("Y-m-d\TH:i:s\Z", $data['timestamp']).'</td>';
	    	$ago_min = ((time()-$data['timestamp'])/60);
	    	echo '<td>- '.number_format($ago_min,2).' MIN</td>';
	    	echo '<td><a class="text-blue" href="show_block.php?block='.$i.'">'.$block_id.'</a></td>';
	    	$fees = intval($data['totalFeeAmount'])/1000000000;
	    	echo '<td class="text-right">'.number_format($fees,9,'.',',').' DNX</td>';
	    	$reward = intval($data['reward'])/1000000000;
	    	echo '<td class="text-right">'.number_format($reward,2,'.',',').' DNX</td>';
	    	$blockSize = intval($data['blockSize']);
	    	echo '<td class="text-right">'.number_format($blockSize,0,'.',',').' Bytes</td>';
	    	
	    	$until_unlock = $height - $data['transactions'][0]['unlockTime'];
	    	if ($until_unlock>=0) {
	    		$until_unlock_str = '<i class="fa fa-unlock text-green"></i> ';
	    	} else {
	    		$until_unlock_str = '<i class="fa fa-lock text-silver"></i> '.abs($until_unlock).' LEFT';
	    	}
	    	
	    	echo '<td class="text-right">'.$data['transactions'][0]['unlockTime'].' '.$until_unlock_str.'</td>';
	    	echo '<td class="text-right">'.(count($data['transactions'])).'</td>';
	    	echo '</tr>';
    	}
	}
	echo '<table>';
?>