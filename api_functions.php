<?php 
	function test() {
            echo "You are really a nice person, Have a nice time!";
    }

    function get_last_supply() {
    	$ret = file_get_contents('data/lastblockheight.txt');
    	return $ret;
    }

    function save_last_supply($block, $supply) {
    	//$var_str = var_export($text, true);
		$var = $block.';'.$supply;
		file_put_contents('data/lastblockheight.txt', $var);

    }

    function get_block_header() {
    	$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, 'http://localhost:18333/getinfo');
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getlastblockheader\",\"params\":{}}");	
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $response = curl_exec($ch);
	    if (curl_errno($ch)) {
	    	echo 'Error:' . curl_error($ch);
		} else {
			$response_json = json_decode($response,true);
			// error:
			if (isset($response_json['error'])) {
				return 'ERROR';
			}
		}
		curl_close($ch);
		$hashrate = $response_json['difficulty']/120;
		$response_json['hashrate'] = $hashrate;
		$response_json['max_supply'] = 100000000000000000;
		
		return $response_json;
    }

    function get_block($block) {
    	// first the block:
    	$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, 'http://localhost:18333/json_rpc');
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblock\",\"params\":{\"height\":".$block."}}");	
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
			// error:
			if (isset($response_json['error'])) {
				return 'ERROR';
			}
			$data = $response_json['result']['blockinfo'];
			$block_id = $response_json['result']['block_id'];
		}
		curl_close($ch);
		// sum up the mined dnx:
		$vout = $data['miner_tx']['vout'];
		$i = 0;
		$amount_total = 0;
		while($i < count($vout))
		{
			$amount = $vout[$i]['amount'];
			$amount_total = $amount_total + $amount;
			$target = $vout[$i]['target']['data']['key'];
			$amount_str = number_format($amount/1000000000,9,'.',',');
			$amount_str = str_pad($amount_str, 20, " ", STR_PAD_LEFT);
			$i++;
		}
		//echo '<br>TOTAL MINING REWARD: '.number_format($amount_total/1000000000,9,'.',',').' DNX<br><br>';
		$data['dnxmined'] = $amount_total;
	
		return $data;
    }
	
?>
		