<?php 
	function test() {
            echo "You are really a nice person, Have a nice time!";
    }

    function get_last_supply() {
    	//$ret = file_get_contents('data/lastblockheight.txt');
    	//return $ret;
    }

    function save_last_supply($block, $supply) {
    	//$var_str = var_export($text, true);
		//$var = $block.';'.$supply;
		//file_put_contents('data/lastblockheight.txt', $var);
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
	    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblockbyheight\",\"params\":{\"blockHeight\":".$block."}}");	
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
			// error:
			if (isset($response_json['error'])) {
				return 'ERROR';
			}
			$data = $response_json['result']['block'];
		}
		curl_close($ch);
		
	
		return $data;
    }
	
?>
		