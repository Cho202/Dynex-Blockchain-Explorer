<?php
	include 'include_logincheck.php';
	// GET CURRENT HEIGHT (AGAIN):
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $DAEMON_ENDPOINT);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"gettransactionspool\"}"); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	} else {
		$response_json = json_decode($response,true);
		$data = $response_json['result']['transactions'];
	}
	curl_close($ch);
	//echo '<pre>'; print_r($data); echo '</pre>';
	
	echo '<table width="100%" class="text-silver fs-12">';
	echo '<th>TIMESTAMP</th>';
	echo '<th>HASH</th>';
	echo '<th class="text-right">AMOUNT(OUT)</th>';
	echo '<th class="text-right">FEE</th>';
	echo '<th class="text-right">SIZE</th>';
	
	$i=0;
	while($i < count($data))
	{
		$tx = $data[$i];
		echo '<tr class="border-dark border-bottom" style="border-top: none; border-bottom: none;">';

		echo '<td>'.gmdate("Y-m-d\TH:i:s\Z", $tx['receiveTime']).'</td>';

		echo '<td><a class="text-yellow" href="show_transaction.php?tx='.$tx['hash'].'">'.$tx['hash'].'</a></td>';

		$amount = intval($tx['amount_out'])/1000000000;
		echo '<td class="text-right">'.number_format($amount,9,'.',',').' DNX</td>';
		
		$fee = intval($tx['fee'])/1000000000;
		echo '<td class="text-right">'.number_format($fee,9,'.',',').' DNX</td>';
		
		
		$size = intval($tx['size']);
		echo '<td class="text-right">'.number_format($size,2,'.',',').' BYTE</td>';
		echo '</tr>';

		$i = $i+1;
	}
	
	echo '<table>';
?>