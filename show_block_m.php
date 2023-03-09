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
										echo '<pre>';
										echo '<h4>BLOCK '.$block.' NOT FOUND</h4>';
										echo $response_json['error']['message'];
										echo '</pre>';
										echo '<button><a href="home.php">GO BACK</a></button>';
										exit;
									}
									
									$data = $response_json['result']['block'];
									$block_id = $data['hash'];
								}
								curl_close($ch);
								// -------------------------------------------------------------------------------------------------------------------------------
								echo '<div class="section p-25">'; 
								
								echo '<table width="100%" class="text-silver fs-12">';
								echo '<tr class="fs-16 border-silver border-bottom"><td>BLOCK ID:</td><td>'.$block_id.'</td></tr>';
								echo '<tr><td>TIMESTAMP:</td><td>'.gmdate("Y-m-d\TH:i:s\Z", $data['timestamp']).'</td></tr>';

								echo '<tr><td>PROOF-OF-WORK:</td><td>'.$data['proofOfWork'].'</td></tr>';
								
								echo '<tr><td>&nbsp;</td><td></td></tr>';
								echo '<tr><td>BLOCK SIZE:</td><td>'.$data['blockSize'].' BYTES</td></tr>';
								echo '<tr><td>DIFFICULTY:</td><td>'.$data['cumulativeDifficulty'].'</td></tr>';
								echo '<tr><td>&nbsp;</td><td></td></tr>';

								$reward = intval($data['reward'])/1000000000;
								echo '<tr><td><strong>REWARD:</strong></td><td><strong>'.number_format($reward,9,'.',',').' </strong>DNX (UNLOCKS AT BLOCK '.$data['transactions'][0]['unlockTime'].')</td></tr>';
								$fee = intval($data['totalFeeAmount'])/1000000000;
								echo '<tr><td><strong>TOTAL FEES:</strong></td><td><strong>'.number_format($fee,9,'.',',').' </strong>DNX</td></tr>';

								echo '</table>';

								echo '<h4 class="text-white border-silver border-bottom">TRANSACTIONS</h4>';
								echo '<table width="100%" class="text-silver fs-12">';
								echo '<th>TX-HASH & PUBLIC KEY</th>';
								echo '<th class="text-right">#INPUTS</th>';
								echo '<th class="text-right">DNX (IN)</th>';
								echo '<th class="text-right">#OUTPUTS</th>';
								echo '<th class="text-right">DNX (OUT)</th>';
								echo '<th class="text-right">FEE</th>';
								echo '<th class="text-right">UNLOCK TIME</th>';
								
								$txs = $data['transactions'];
								$i=0;
								while($i < count($txs))
								{
									$tx = $txs[$i];
									echo '<tr class="border-dark border-bottom">';
									echo '<td class="text-left"><a class="text-green" href="show_transaction.php?tx='.$tx['hash'].'">'.$tx['hash'].'</a><br>';
									echo 'KEY: '.$tx['extra']['publicKey'].'</td>';
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