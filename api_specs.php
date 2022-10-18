<?php
// login check:
include 'include_logincheck.php';
// include head:
include 'include_head.php';
?>

<!-- bg-dark: #343a40  style="background-image: url('assets/images/dashboard_background.png');" -->
<body class="font-apple-system fs-12 text-silver" style="background-color: #181818;">

	<!-- Menu -->
	<?php include 'include_navigation.php';?>
	
	<!-- Main AREA -->
	<br>
	<div class="section">
		<div class="container-fluid pl-200 pr-200">	
				<h3 class="text-white">API Specification</h3>

                <p>Information about circulatating coins can be retrieved with our Json API. Retrieve Json data with <a href="https://dynex.dyndns.org/api_supply.php">https://dynex.dyndns.org/api_supply.php</a>. The following blocks and fields are being returned:</p>

                <?php 
                echo '<pre>';
                echo '[already_generated_coins] => 9324215.139675710';
                echo '</pre>';
                ?>
                <br><br>
				<p>Additional information about the blockchain can be retrieved with our Json API. Retrieve Json data with <a href="https://dynex.dyndns.org/api.php">https://dynex.dyndns.org/api.php</a>. The following blocks and fields are being returned:</p>

				<?php
				echo '<pre>';
				echo '[block_header] => Array
        (
            [already_generated_coins] => 9323869.237687634
            [alt_blocks_count] => 0
            [block_major_version] => 1
            [contact] => 
            [cumulative_difficulty] => 11981870408612
            [difficulty] => 2946731178
            [fee_address] => 
            [grey_peerlist_size] => 52
            [height] => 25671
            [incoming_connections_count] => 0
            [last_known_block_index] => 25670
            [min_tx_fee] => 1000000
            [next_reward] => 345901988076
            [outgoing_connections_count] => 8
            [readable_tx_fee] => 0.001000000
            [rpc_connections_count] => 1
            [start_time] => 1666071842
            [status] => OK
            [top_block_hash] => cde5254a72aa6ed89c493c0201ae1f1df94e9e2218e4d9fdb1b8ff4102b2e1a7
            [tx_count] => 12448
            [tx_pool_size] => 15
            [version] => 1.4.0-20221014 (#coreupgrade)
            [version_build] => 20221014
            [version_num] => 1.4.0
            [version_remark] => #coreupgrade
            [white_peerlist_size] => 38
            [hashrate] => 24556093.15
            [max_supply] => 100000000000000000
        )';
				echo '</pre>';

				echo '<pre>';
				echo '[top_block] => Array
        (
            [alreadyGeneratedCoins] => 9323869237687634
            [alreadyGeneratedTransactions] => 38119
            [baseReward] => 345903307592
            [blockSize] => 146
            [cumulativeDifficulty] => 11981870408612
            [depth] => 0
            [difficulty] => 2946295473
            [effectiveSizeMedian] => 20000
            [hash] => cde5254a72aa6ed89c493c0201ae1f1df94e9e2218e4d9fdb1b8ff4102b2e1a7
            [index] => 25670
            [isOrphaned] => 
            [majorVersion] => 1
            [minorVersion] => 0
            [nonce] => 1047315340
            [penalty] => 0
            [prevBlockHash] => dbb30ba1ec6194ab0e36ddfe23f38dbf42c369e1dd389657c62bb8bdc80196aa
            [proofOfWork] => 9a6656ef1bcd1fd04c861bede0b4f5028545d71355b9a7c471d87d6900000000
            [reward] => 345903307592
            [sizeMedian] => 102
            [timestamp] => 1666087621
            [totalFeeAmount] => 0
            [transactions] => Array
                (
                    [0] => Array
                        (
                            [blockHash] => cde5254a72aa6ed89c493c0201ae1f1df94e9e2218e4d9fdb1b8ff4102b2e1a7
                            [blockIndex] => 25670
                            [extra] => Array
                                (
                                    [nonce] => Array
                                        (
                                            [0] => 0
                                            [1] => 0
                                            [2] => 0
                                            [3] => 0
                                            [4] => 57
                                            [5] => 182
                                            [6] => 48
                                            [7] => 43
                                            [8] => 109
                                            [9] => 0
                                            [10] => 0
                                            [11] => 0
                                            [12] => 0
                                            [13] => 0
                                            [14] => 0
                                            [15] => 0
                                            [16] => 0
                                        )

                                    [publicKey] => e35f1ebf55ac9584a00ad9f76464480e0cebaf04f24205dc3ae93ec909fb100a
                                    [raw] => 01e35f1ebf55ac9584a00ad9f76464480e0cebaf04f24205dc3ae93ec909fb100a02110000000039b6302b6d0000000000000000
                                )

                            [fee] => 0
                            [hash] => 848bc791d4b85a4fc7d3b0ec10e2b8f03261abb3e15c4354ca20bed38ad4248c
                            [inBlockchain] => 1
                            [inputs] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => Array
                                                (
                                                    [amount] => 345903307592
                                                    [input] => Array
                                                        (
                                                            [height] => 25670
                                                        )

                                                )

                                            [type] => ff
                                        )

                                )

                            [mixin] => 0
                            [outputs] => Array
                                (
                                    [0] => Array
                                        (
                                            [globalIndex] => 0
                                            [output] => Array
                                                (
                                                    [amount] => 345903307592
                                                    [target] => Array
                                                        (
                                                            [data] => Array
                                                                (
                                                                    [key] => 4ab5ebcdb685e5a841d98b30701f959f754588083b02292863a553c96455f042
                                                                )

                                                            [type] => 02
                                                        )

                                                )

                                        )

                                )

                            [paymentId] => 0000000000000000000000000000000000000000000000000000000000000000
                            [signatures] => Array
                                (
                                )

                            [signaturesSize] => 0
                            [size] => 102
                            [timestamp] => 1666087621
                            [totalInputsAmount] => 0
                            [totalOutputsAmount] => 345903307592
                            [unlockTime] => 25730
                            [version] => 1
                        )

                )

            [transactionsCumulativeSize] => 102
        )

)';
				echo '</pre>';

				

				?>
				<br><br>

		
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







</html>