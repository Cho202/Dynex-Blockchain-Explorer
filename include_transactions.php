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
	echo '<table class="fs-12 text-silver" width="100%" style="border-collapse: collapse;">';
	echo '<th>BLOCK</th>';
	echo '<th>TIMESTAMP</th>';
	echo '<th>TRANSACTION</th>';
	echo '<th class="text-right">INPUTS</th>';
	echo '<th class="text-right">#INPUTS</th>';
	echo '<th class="text-right">OUTPUTS</th>';
	echo '<th class="text-right">#OUTPUTS</th>';
	$found_tx = 0;
	$check_block = $height;
	while ($found_tx<20) {
		// -------------------------------------------------------------------------------------------------------------------------------
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $DAEMON_ENDPOINT);
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblock\",\"params\":{\"height\":".$check_block."}}");
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
		// did we found a  block with transactions?
		if (count($data['tx_hashes'])>0) {
			//timestamp:
			$blocktime = gmdate("Y-m-d\TH:i:s\Z", $data['timestamp']);
			// loop through each of them:
			$txs = $data['tx_hashes'];
			$i = 0;
			$amount_total = 0;
			while($i < count($txs))
			{
				$tx = $txs[$i];
				// now output details:
				// -------------------------------------------------------------------------------------------------------------------------------
								$ch2 = curl_init();
							    curl_setopt($ch2, CURLOPT_URL, $DAEMON_ENDPOINT);
							    curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
							    curl_setopt($ch2, CURLOPT_POST, 1);
							    curl_setopt($ch2, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"gettransaction\",\"params\":{\"tx\":\"".$tx."\"}}");	
							    curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
							    curl_setopt($ch2, CURLOPT_ENCODING, 'gzip,deflate');
							    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
							    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
							    $response2 = curl_exec($ch2);
							    if (curl_errno($ch2)) {
							    	echo 'Error:' . curl_error($ch2);
								} else {
									// special case, dealing with " in front and end of field blockinfo
									$response2  =str_replace( '"txinfo":"{"', '"txinfo":{"', $response2 );
									$response2 = str_replace( '}}]}"}}', '}}]}}}', $response2 );
									$response_json2 = json_decode($response2,true);
									$data2 = $response_json2['result']['txinfo'];
								}
								curl_close($ch2);
								// -------------------------------------------------------------------------------------------------------------------------------
								$vin = $data2['vin'];
								$i2 = 0;
								$amount_total_in = 0;
								$vin_count = 0;
								while($i2 < count($vin))
								{
									$amount = $vin[$i2]['value']['amount'];
									$amount_total_in = $amount_total_in + $amount;
									$vin_count = $vin_count + 1;
									$i2++;
								}
								
								$vout = $data2['vout'];
								$i2 = 0;
								$amount_total_out = 0;
								$vout_count = 0;
								while($i2 < count($vout))
								{
									$amount = $vout[$i2]['amount'];
									$amount_total_out = $amount_total_out + $amount;
									$vout_count = $vout_count + 1;
									$i2++;
								}
								echo '<tr class="border-dark border-bottom" style="border-top: none; border-bottom: none;">';
								echo '<td><a class="text-blue" href="show_block.php?block='.$check_block.'">'.$check_block.'</a></td>';
								echo '<td>'.$blocktime.'</td>';
								echo '<td><a class="text-blue" href="show_transaction.php?tx='.$tx.'">'.$tx.'</a></td>';
								echo '<td class="text-right">'.number_format($amount_total_in/1000000000,9,'.',',').' DNX</td>';
								echo '<td class="text-right">'.$vin_count.'</td>';
								echo '<td class="text-right">'.number_format($amount_total_out/1000000000,9,'.',',').' DNX</td>';
								echo '<td class="text-right">'.$vout_count.'</td>';
								echo '</tr>';
				//---
				$i++;
			}
			
	    	$found_tx = $found_tx + count($data['tx_hashes']);
		}
		$check_block = $check_block - 1;
		if ($check_block==0) $found_tx = 99;
    	
	}
	echo '<table>';
?>