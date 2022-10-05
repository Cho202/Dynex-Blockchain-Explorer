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
							    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"id\":\"0\",\"method\":\"gettransaction\",\"params\":{\"tx\":\"".$tx."\"}}");	
							    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
							    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
							    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							    $response = curl_exec($ch);
							    if (curl_errno($ch)) {
							    	echo 'Error:' . curl_error($ch);
								} else {
									// special case, dealing with " in front and end of field blockinfo
									$response  =str_replace( '"txinfo":"{"', '"txinfo":{"', $response );
									$response = str_replace( '}}]}"}}', '}}]}}}', $response );
									$response_json = json_decode($response,true);
									// error:
									if ($response_json['result']['status']!='OK') {

										echo '<pre>';
										echo '<h4>TRANSACTION '.$tx.' NOT FOUND</h4>';
										echo '</pre>';
										echo '<button><a href="home.php">GO BACK</a></button>';
										exit;
									}
									$data = $response_json['result']['txinfo'];
								}
								curl_close($ch);
								// -------------------------------------------------------------------------------------------------------------------------------
								echo '<div class="section p-25">'; 
								
								echo '<table width="100%" class="text-silver fs-12">';
								echo '<tr class="fs-16"><td>TRANSACTION:</td><td>'.$tx.'</td></tr>';
								echo '<tr><td>IN BLOCK:</td><td><a class="text-blue" href="show_block.php?block='.$response_json['result']['height'].'">'.$response_json['result']['height'].'</a></td></tr>';
								echo '<tr><td>CONFIRMATIONS:</td><td>'.$response_json['result']['current_height']-$response_json['result']['height'].'</td></tr>';
								//echo '<tr><td>UNLOCK TIME:</td><td>'.$data['unlock_time'].'</td></tr>';
								echo '<tr><td>EXTRA:</td><td>'.$data['extra'].'</td></tr>';
								echo '</table>';

								echo '<h4 class="text-white">INPUTS</h4>';
								echo '<table width="100%" class="text-silver fs-12">';
								$vin = $data['vin'];
								$i = 0;
								$amount_total = 0;
								while($i < count($vin))
								{
									$amount = $vin[$i]['value']['amount'];
									$amount_total = $amount_total + $amount;
									$target = $vin[$i]['value']['k_image'];
									$amount_str = number_format($amount/1000000000,9,'.',',');
									$amount_str = str_pad($amount_str, 20, " ", STR_PAD_LEFT);
									echo '<tr class="border-dark border-bottom"><td class="text-right">'.$amount_str.' DNX</td><td> => KEY-IMAGE '.$target.'</td></tr>';
									$i++;
								}
								echo '<tr><td>&nbsp;</td><td></td></tr><tr class="fs-14 border-dark border-bottom"><td class="text-right">'.number_format($amount_total/1000000000,9,'.',',').' DNX</td><td>&nbsp;</td></tr></table>';

								echo '<h4 class="text-white">OUTPUTS</h4>';
								echo '<table width="100%" class="text-silver fs-12">';
								$vout = $data['vout'];
								$i = 0;
								$amount_total = 0;
								while($i < count($vout))
								{
									$amount = $vout[$i]['amount'];
									$amount_total = $amount_total + $amount;
									$target = $vout[$i]['target']['data']['key'];
									$amount_str = number_format($amount/1000000000,9,'.',',');
									$amount_str = str_pad($amount_str, 20, " ", STR_PAD_LEFT);
									echo '<tr class="border-dark border-bottom"><td class="text-right">'.$amount_str.' DNX</td><td> => KEY-IMAGE '.$target.'</td></tr>';
									$i++;
								}
								echo '<tr><td>&nbsp;</td><td></td></tr><tr class="fs-14 border-dark border-bottom"><td class="text-right">'.number_format($amount_total/1000000000,9,'.',',').' DNX</td><td>&nbsp;</td></tr></table>';
								
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