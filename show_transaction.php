<?php
	// login check:
	include 'include_logincheck.php';
	// include head:
	include 'include_head.php';
	
	if (isset($_GET['tx'])) {
		$tx = $_GET['tx'];
	}
	//search form?
	if (isset($_POST['tx'])) {
		$tx = $_POST['tx'];
	}
	//get current height:
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
		$current_height = intval($data['height']);
	}
	curl_close($ch);
	//echo '<pre>'; print_r($response_json); echo '</pre>';
?>

<!-- bg-dark: #343a40  style="background-image: url('assets/images/dashboard_background.png');" -->
<body class="font-apple-system fs-12" style="background-color:  #181818;">

	<!-- Menu -->
	<?php include 'include_navigation.php';?>
	
	<!-- Main AREA -->
	<br>
	<div class="section">
		<div class="container-fluid">	
			
			<div class="row">
				<div class="col-md-12" valign="top">
					<div class="card" id="1" style="background-color: #101010;">	
						<div class="card-header border-bottom border-gray text-white" style="background-color: #0000; color: #fffff;">
							<strong>TRANSACTION <?php echo $tx;?></strong>
						</div>
						<div class="card-text p-10" style="background-color: #0e0e0e;">
							<?php 
								// -------------------------------------------------------------------------------------------------------------------------------
								$ch = curl_init();
							    curl_setopt($ch, CURLOPT_URL, $DAEMON_ENDPOINT);
							    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
							    curl_setopt($ch, CURLOPT_POST, 1);
							    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"gettransaction\",\"params\":{\"hash\":\"".$tx."\"}}");	
							    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
							    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
							    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							    $response = curl_exec($ch);
							    //echo '<pre>'; print_r($response); echo '</pre>';
							    if (curl_errno($ch)) {
							    	echo 'Error:' . curl_error($ch);
								} else {
									// special case, dealing with " in front and end of field blockinfo
									$response_json = json_decode($response,true);
									// error:
									if ($response_json['result']['status']!='OK') {
										echo '<pre>';
										echo '<h4>TRANSACTION '.$tx.' NOT FOUND</h4>';
										echo '</pre>';
										echo '<button><a href="home.php">GO BACK</a></button>';
										exit;
									}
									$data = $response_json['result']['transaction'];
								}
								curl_close($ch);
								// -------------------------------------------------------------------------------------------------------------------------------
								echo '<div class="section p-25">'; 
								
								echo '<table width="100%" class="text-silver fs-12">';
								echo '<tr class="fs-16 border-silver border-bottom"><td>TRANSACTION:</td><td>'.$tx.'</td></tr>';
								echo '<tr><td>PAYMENT ID:</td><td>'.$data['paymentId'].'</td></tr>';
								
								if ($data['blockIndex']!='0') {
									echo '<tr><td>IN BLOCK (HASH):</td><td><a class="text-blue" href="show_block.php?block='.$data['blockIndex'].'">'.$data['blockHash'].'</a></td></tr>';
									echo '<tr><td>IN BLOCK (HEIGHT):</td><td><a class="text-blue" href="show_block.php?block='.$data['blockIndex'].'">'.$data['blockIndex'].'</a></td></tr>';
								} else {
									echo '<tr><td>BLOCK HEIGHT:</td><td class="text-yellow">IN MEMORY POOL</td></tr>';
								}

								if ($data['timestamp']!='0') {
									echo '<tr><td>TIMESTAMP:</td><td class="text-left">'.gmdate("Y-m-d\TH:i:s\Z", $data['timestamp']).'</td></tr>';
								} else {
									echo '<tr><td>TIMESTAMP:</td><td class="text-yellow text-left">IN MEMORY POOL</td></tr>';
								}
								
								// confirmations:
								$blockindex = intval($data['blockIndex']);
								if ($blockindex!=0) {
									echo '<tr><td>CONFIRMATIONS:</td><td>'.$current_height-$blockindex.'</td></tr>';
								} else {
									echo '<tr><td>CONFIRMATIONS:</td><td>PENDING</td></tr>';
								}
								
								echo '<tr><td>UNLOCK TIME:</td><td>'.$data['unlockTime'].'</td></tr>';
								echo '<tr><td>SIZE:</td><td>'.$data['size'].' BYTES</td></tr>';
								echo '<tr><td>&nbsp;</td><td></td></tr>';
								$total_in = intval($data['totalInputsAmount'])/1000000000;
								$total_out = intval($data['totalOutputsAmount'])/1000000000;
								$fee = intval($data['fee'])/1000000000;
								echo '<tr><td><strong>TOTAL IN:</strong></td><td><strong>'.number_format($total_in,9,'.',',').' </strong>DNX</td></tr>';
								echo '<tr><td><strong>TOTAL OUT:</strong></td><td><strong>'.number_format($total_out,9,'.',',').' </strong>DNX</td></tr>';
								echo '<tr><td><strong>FEE:</strong></td><td><strong>'.number_format($fee,9,'.',',').' </strong>DNX</td></tr>';
								

								echo '</table>';

								// inputs:
								echo '<h4 class="text-white border-silver border-bottom">INPUTS</h4>';
								echo '<table class="fs-12 text-silver" width="100%">';
								echo '<th>KEY IMAGE</th>';
								echo '<th>OUT TX-HASH</th>';
								echo '<th class="text-right">MIXIN</th>';
								echo '<th class="text-right">AMOUNT</th>';
								$txs = $data['inputs'];
								$i=0;
								while($i < count($txs))
								{
									$tx = $txs[$i];
									if (isset($tx['data']['input']['k_image'])) {									
										echo '<tr class="border-dark border-bottom">';
										echo '<td class="text-left">'.$tx['data']['input']['k_image'].'<br>';
										echo '<td class="text-left">'.$tx['data']['outputs'][0]['transactionHash'].'<br>';
										echo '<td class="text-right">'.$tx['data']['mixin'].'<br>';
										$amount = intval($tx['data']['input']['amount'])/1000000000;
										echo '<td class="text-right">'.number_format($amount,9,'.',',').' DNX</td>';
										echo '</tr>';
									}
									$i = $i + 1;
								}
								echo '</table>';

								// outputs:
								echo '<h4 class="text-white border-silver border-bottom">OUTPUTS</h4>';
								echo '<table class="fs-12 text-silver" width="100%">';
								echo '<th>KEY</th>';
								echo '<th class="text-right">GLOBAL INDEX</th>';
								echo '<th class="text-right">AMOUNT</th>';
								$txs = $data['outputs'];
								$i=0;
								while($i < count($txs))
								{
									$tx = $txs[$i];
									if (isset($tx['output']['target']['data'])) {
										echo '<tr class="border-dark border-bottom">';
										echo '<td class="text-left">'.$tx['output']['target']['data']['key'].'</td>';
										echo '<td class="text-right">'.$tx['globalIndex'].'<br>';
										$amount = intval($tx['output']['amount'])/1000000000;
										echo '<td class="text-right">'.number_format($amount,9,'.',',').' DNX</td>';
										echo '</tr>';
									}
									$i = $i + 1;
								}
								echo '</table>';

								// signatures:
								echo '<h4 class="text-white border-silver border-bottom">SIGNATURES</h4>';
								echo '<table class="fs-12 text-silver" width="100%">';
								echo '<th class="text-left">FIRST</th>';
								echo '<th class="text-left">SECOND</th>';
								$txs = $data['signatures'];
								$i=0;
								while($i < count($txs))
								{
									$tx = $txs[$i];
									echo '<tr class="border-dark border-bottom">';
									echo '<td class="text-left">'.$tx['first'].'</br>';
									echo '<td class="text-left">'.$tx['second'].'</br>';
									$i = $i + 1;
								}
								echo '</table>';


								// outputs:

								
								//print_r($data);
								echo '</div>';
								echo '<button><a href="home.php">GO BACK</a></button>';
							?>
						</div>
					</div>
				</div>

			</div> <!-- row -->

		</div> <!-- /container-fluid -->

	</div> <!-- /section -->

<!-- Footer -->
<?php include 'footer.php';?>
<!-- Footer -->

<!-- SCROLL TO TOP -->
<a href="#" id="toTop"></a>

</body>
<!-- JAVASCRIPT FILES -->
<script>var plugin_path = 'assets/plugins/';</script>
<script type="text/javascript" src="assets/plugins/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/js/scripts.js"></script>