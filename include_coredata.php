<?php
	include 'include_logincheck.php';
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

	// get current supply, hash rate etc:
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://localhost/api.php');
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $ret = curl_exec($ch);
    $ret_json = json_decode($ret,true);
    curl_close($ch);

	//output data:
	echo '<div"><br><table class="fs-12 text-silver" width="100%" style="border:0px;">';
	echo '<tr>';
	echo '<td class="text-center" width="16%">HASH RATE</td>';
	echo '<td class="text-center" width="16%">BLOCK HEIGHT</td>';
	echo '<td class="text-center" width="16%">DIFFICULTY</td>';
	echo '<td class="text-center" width="16%">REWARD</td>';
	echo '<td class="text-center" width="16%">CIRCULATING SUPPLY</td>';
	echo '<td class="text-center" width="16%">LATEST BLOCK</td>';
	
	echo '</tr>';
	
	echo '<tr>';
	$hashrate_k = $ret_json['block_header']['hashrate']/1000;
	echo '<td class="text-center text-white fs-14" width="16%"><strong>'.number_format($hashrate_k,0,".",",").' KH/s</strong></td>';
	echo '<td class="text-center text-white fs-14" width="16%"><strong>'.number_format($data['height'],0,".",",").'</strong></td>';
	echo '<td class="text-center text-white fs-14" width="16%"><strong>'.number_format($data['difficulty'],0,".",",").'</strong></td>';
	echo '<td class="text-center text-white fs-14" width="16%"><strong>'.number_format($data['reward']/1000000000,2,".",",").' DNX</strong></td>';
	$total_supply_m = $ret_json['total_supply']/1000000000;
	echo '<td class="text-center text-white fs-14" width="16%"><strong>'.number_format($total_supply_m,0,".",",").' DNX</strong></td>';

	/*$ago_min = ((time()-$data['timestamp'])/60/60);
	if ($ago_min<1) {$ago = 'LESS THAN 1 MINUTE AGO';}
	if ($ago_min>=1 && $ago_min<2) {$ago = '1 MINUTE AGO';}
	if ($ago_min>=2) {$ago = number_format($ago_min,0).' MINUTES AGO';}*/
	echo '<td class="text-center text-white fs-14" width="16%"><strong>'.gmdate("Y-m-d\TH:i:s\Z", $data['timestamp']).'</strong></td>';

	echo '</tr><table></div>';

	//echo '<pre>';
	//print_r($data);
	//echo '</pre>';
?>