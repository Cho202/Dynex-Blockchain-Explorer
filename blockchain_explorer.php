<!--
  // binary handlers
  { "/getblocks.bin", { binMethod<COMMAND_RPC_GET_BLOCKS_FAST>(&RpcServer::on_get_blocks), false } },
  { "/queryblocks.bin", { binMethod<COMMAND_RPC_QUERY_BLOCKS>(&RpcServer::on_query_blocks), false } },
  { "/queryblockslite.bin", { binMethod<COMMAND_RPC_QUERY_BLOCKS_LITE>(&RpcServer::on_query_blocks_lite), false } },
  { "/get_o_indexes.bin", { binMethod<COMMAND_RPC_GET_TX_GLOBAL_OUTPUTS_INDEXES>(&RpcServer::on_get_indexes), false } },
  { "/getrandom_outs.bin", { binMethod<COMMAND_RPC_GET_RANDOM_OUTPUTS_FOR_AMOUNTS>(&RpcServer::on_get_random_outs), false } },
  { "/get_pool_changes.bin", { binMethod<COMMAND_RPC_GET_POOL_CHANGES>(&RpcServer::onGetPoolChanges), false } },
  { "/get_pool_changes_lite.bin", { binMethod<COMMAND_RPC_GET_POOL_CHANGES_LITE>(&RpcServer::onGetPoolChangesLite), false } },

  // json handlers
  { "/getinfo", { jsonMethod<COMMAND_RPC_GET_INFO>(&RpcServer::on_get_info), true } },
  { "/getheight", { jsonMethod<COMMAND_RPC_GET_HEIGHT>(&RpcServer::on_get_height), true } },
  { "/gettransactions", { jsonMethod<COMMAND_RPC_GET_TRANSACTIONS>(&RpcServer::on_get_transactions), false } },
  { "/sendrawtransaction", { jsonMethod<COMMAND_RPC_SEND_RAW_TX>(&RpcServer::on_send_raw_tx), false } },
  { "/start_mining", { jsonMethod<COMMAND_RPC_START_MINING>(&RpcServer::on_start_mining), false } },
  { "/stop_mining", { jsonMethod<COMMAND_RPC_STOP_MINING>(&RpcServer::on_stop_mining), false } },
  { "/stop_daemon", { jsonMethod<COMMAND_RPC_STOP_DAEMON>(&RpcServer::on_stop_daemon), true } },

  // json rpc
  { "/json_rpc", { std::bind(&RpcServer::processJsonRpcRequest, std::placeholders::_1, std::placeholders::_2, std::placeholders::_3), true } }

  static std::unordered_map<std::string, RpcServer::RpcHandler<JsonMemberMethod>> jsonRpcHandlers = {
      { "getblockcount", { makeMemberMethod(&RpcServer::on_getblockcount), true } },
      { "on_getblockhash", { makeMemberMethod(&RpcServer::on_getblockhash), false } },
      { "getblocktemplate", { makeMemberMethod(&RpcServer::on_getblocktemplate), false } },
      { "getcurrencyid", { makeMemberMethod(&RpcServer::on_get_currency_id), true } },
      { "submitblock", { makeMemberMethod(&RpcServer::on_submitblock), false } },
      { "getlastblockheader", { makeMemberMethod(&RpcServer::on_get_last_block_header), false } },
      { "getblockheaderbyhash", { makeMemberMethod(&RpcServer::on_get_block_header_by_hash), false } },
      { "getblockheaderbyheight", { makeMemberMethod(&RpcServer::on_get_block_header_by_height), false } }
    };
-->

<?php

  // RETRIEVE BLOCKCHAIN HEADER:
  echo '<h1>getlastblockheader</h1>';
	//$WALLET_ENDPOINT = "http://localhost:18333/getinfo";
	//$WALLET_ENDPOINT = "http://localhost:18333/getheight";
	//$WALLET_ENDPOINT = "http://localhost:18333/gettransactions";
  $WALLET_ENDPOINT = "http://localhost:18333/json_rpc";
  
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $WALLET_ENDPOINT);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_POST, 1);
    
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"\",\"params\":{}}");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getlastblockheader\"}"); 
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
		//$balance_available = 0;
		//$balance_locked = 0;
		//$balance = 0;
	} else {
		$response_json = json_decode($response,true);
		//$balance_available = $response_json['result']['available_balance'];
		//$balance_locked = $response_json['result']['locked_amount'];
		//$balance = $balance_available + $balance_locked;
	}
	curl_close($ch);

	echo '<pre>';
	print_r($response_json);
	echo '</pre>';

  // SHOW LAST TRANSACTIONS:
  echo '<h1>getblockheaderbyhash</h1>';
  echo '<pre>';
  $height = $response_json['result']['block_header']['height'];
  echo 'height: '.intval($height);
	echo '</pre>';
  $WALLET_ENDPOINT = "http://localhost:18333/json_rpc";
  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $WALLET_ENDPOINT);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblockheaderbyhash\",\"params\":{\"hash\":\"9302e0db19303ae525573ce1cc4925b6b1f328513a01d12baba5c64ba83454d2\"}}");
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblockheaderbyheight\",\"params\":{\"10000\"}}");
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

  // SHOW LAST TRANSACTIONS:
  echo '<h1>getblockheaderbyheight</h1>';
  echo '<pre>';
  $height = $response_json['result']['block_header']['height'];
  echo 'height: '.intval($height);
  echo '</pre>';
  $WALLET_ENDPOINT = "http://localhost:18333/json_rpc";
  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $WALLET_ENDPOINT);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblockheaderbyheight\",\"params\":{\"height\":10611}}");
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblockheaderbyheight\",\"params\":{\"10000\"}}");
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

  // MISSING: IMPLEMENT get_block function!
  // SHOW LAST TRANSACTIONS:
  echo '<pre>';
  echo '<h1>getblock</h1>';
  $height = $response_json['result']['block_header']['height'];
  echo 'height: '.intval($height);
  echo '</pre>';
  $WALLET_ENDPOINT = "http://localhost:18333/json_rpc";
  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $WALLET_ENDPOINT);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"getblock\",\"params\":{\"height\":10611}}");
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
  }
  curl_close($ch);

  echo '<pre>';
  print_r($response_json);
  echo '</pre>';

  


?>