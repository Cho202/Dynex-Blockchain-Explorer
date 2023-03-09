<?php
	include 'include_logincheck.php';
	// GET CURRENT HEIGHT (AGAIN):
	#exit();
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
	echo '<table width="100%" class="text-silver fs-12">';
	echo '<th>TX-HASH</th>';
	echo '<th class="text-right">#INPUTS</th>';
	echo '<th class="text-right">DNX (IN)</th>';
	echo '<th class="text-right">#OUTPUTS</th>';
	echo '<th class="text-right">DNX (OUT)</th>';
	echo '<th class="text-right">FEE</th>';
	echo '<th class="text-right">UNLOCK TIME</th>';
	$found_tx = 0;
	$check_block = $height;
	if ($height = "") exit();
	if ($height > 10000000) exit();
	$rem_block = 0;
	while ($found_tx<20) {
		// -------------------------------------------------------------------------------------------------------------------------------
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $DAEMON_ENDPOINT);
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblockbyheight\",\"params\":{\"blockHeight\":".$check_block."}}");
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
		
		// -------------------------------------------------------------------------------------------------------------------
		// did we found a  block with transactions?
		if (count($data['transactions'])>0) {
			//timestamp:
			$blocktime = gmdate("Y-m-d\TH:i:s\Z", $data['timestamp']);
			// loop through each of them:
			$txs = $data['transactions'];
			$i = 0;
			$amount_total = 0;
			while($i < count($txs))
			{
				$tx = $txs[$i];
				$txs = $data['transactions'];
				$i=0;
				while($i < count($txs))
				{
					$tx = $txs[$i];
					echo '<tr class="border-dark border-bottom">';
					echo '<td class="text-left"><a class="text-green" href="show_transaction.php?tx='.$tx['hash'].'">'.$tx['hash'].'</a></td>';
					echo '<td class="text-right">'.count($tx['inputs']).'</td>';
					$inamount = intval($tx['totalInputsAmount'])/1000000000;
					echo '<td class="text-right">'.number_format($inamount,9,'.',',').'</td>';
					echo '<td class="text-right">'.count($tx['outputs']).'</td>';
					$outamount = intval($tx['totalOutputsAmount'])/1000000000;
					echo '<td class="text-right">'.number_format($outamount,9,'.',',').'</td>';
					$feeamount = intval($tx['fee'])/1000000000;
					echo '<td class="text-right">'.number_format($feeamount,9,'.',',').' DNX</td>';
					echo '<td class="text-right">'.$tx['unlockTime'].'</td>';
					
					echo '</tr>';
					$i = $i + 1;
				}
				$i++;
			}
			
	    	$found_tx = $found_tx + count($data['transactions']);
		}
		$check_block = $check_block - 1;
		if ($check_block==0) $found_tx = 99;
		//echo "<pre>"; echo $check_block; echo "</pre>";
    	
	}
	echo '<table>';
?>