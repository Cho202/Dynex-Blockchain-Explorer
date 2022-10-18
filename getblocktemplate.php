

<?php
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost:18333/json_rpc");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"gettransactionspool\",\"params\":{\"hash\":\"f670dff3f7b00a4a39133938ad0201a329e997dc008c5046235f540b870e78af\"}}");
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblockbyheight\",\"params\":{\"blockHeight\":10000}}");
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"gettransaction\",\"params\":{\"hash\":\"0b075fa6a72f55f1598977b406bfaa4c744b96e75ef32063fba01b8f35078897\"}}");

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"checktransactionbyviewkey\",\"params\":{\"txid\":\"638f6cf7c3ec876968ee3fa8f19a1dc3906a48981bec61f12eea2cbbbb0b9bee\"}}");	

    
							    

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	} else {
		$response_json = json_decode($response,true);
	}
	curl_close($ch);
	echo '<pre>';
	print_r($response_json);
	echo '</pre>';
?>


