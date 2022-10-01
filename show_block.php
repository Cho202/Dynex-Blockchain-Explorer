<?php
	// login check:
	include 'include_logincheck.php';
	// include head:
	include 'include_head.php';
	if (isset($_GET['block'])) {
		$block = $_GET['block'];
	}
	//search form?
	if (isset($_POST['block'])) {
		$block = $_POST['block'];
	}
?>

<!-- bg-dark: #343a40  style="background-image: url('assets/images/dashboard_background.png');" -->
<body class="font-apple-system fs-12" style="background-color: #181818;">

	<!-- Menu -->
	<?php include 'include_navigation.php';?>
	
	<!-- Main AREA -->
	<br>
	<div class="section">
		<div class="container-fluid">	
			
			<div class="row">
				<div class="col-md-12" valign="top">
					<div class="card" id="1" style="background-color: #101010;">	
						<div class="card-header border-bottom border-dark text-white" style="background-color: #0000; color: #fffff;">
							<strong>BLOCK <?php echo $block;?></strong>
						</div>
						<div class="card-text p-10" style="background-color: #0e0e0e;">
							<?php 
								// -------------------------------------------------------------------------------------------------------------------------------
								$ch = curl_init();
							    curl_setopt($ch, CURLOPT_URL, $DAEMON_ENDPOINT);
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
										echo '<pre>';
										echo '<h4>BLOCK '.$block.' NOT FOUND</h4>';
										echo $response_json['error']['message'];
										echo '</pre>';
										echo '<button><a href="home.php">GO BACK</a></button>';
										exit;
									}
									
									$data = $response_json['result']['blockinfo'];
									$block_id = $response_json['result']['block_id'];
								}
								curl_close($ch);
								// -------------------------------------------------------------------------------------------------------------------------------
								echo '<div class="section p-25">'; 
								
								echo '<table width="100%" class="text-silver fs-12">';
								echo '<tr class="fs-16"><td>BLOCK IDBLOCK ID:</td><td>'.$block_id.'</td></tr>';
								echo '<tr><td>TIMESTAMP:</td><td>'.gmdate("Y-m-d\TH:i:s\Z", $data['timestamp']).'</td></tr>';
								echo '</table>';

								
								echo '<h4 class="text-white">MINING TRANSACTION</h4>';
								echo '(REWARD UNLOCKS AT BLOCK: '.$data['miner_tx']['unlock_time'].')<br><br>';
								
								echo '<h4 class="text-white">OUTGOING TRANSACTIONS</h4>';
								echo '<table width="100%" class="text-silver fs-12">';
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
									//echo '&nbsp;&nbsp;&nbsp;'.$amount_str.'DNX => KEY-IMAGE '.$target.'<br>';
									echo '<tr class="border-dark border-bottom"><td class="text-right">'.$amount_str.' DNX</td><td> => KEY-IMAGE '.$target.'</td></tr>';
									$i++;
								}
								//echo '<br>TOTAL MINING REWARD: '.number_format($amount_total/1000000000,9,'.',',').' DNX<br><br>';
								echo '<tr><td>&nbsp;</td><td></td></tr><tr class="fs-14 border-dark border-bottom"><td class="text-right">'.number_format($amount_total/1000000000,9,'.',',').' DNX</td><td>&nbsp;</td></tr></table>';

								echo '<h4 class="text-white">TRANSACTIONS</h4>';
								echo '<table width="100%" class="text-silver fs-12">';
								$tx = $data['tx_hashes'];
								$i = 0;
								while($i < count($tx))
								{
									echo '<tr class="border-dark border-bottom"><td><a class="text-blue" href="show_transaction.php?tx='.$tx[$i].'">'.$tx[$i].'</a>'.'</td></tr>';
									$i++;
								}
								echo '</table>';
								
								
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