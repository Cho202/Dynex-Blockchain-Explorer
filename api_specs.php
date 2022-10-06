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

				<p>Current information about the blockchain can be retrieved with our Json API. Retrieve Json data with <a href="https://dynex.dyndns.org/api.php">https://dynex.dyndns.org/api.php</a>. The following blocks and fields are being returned:</p>

				<?php
				echo '<pre>';
				echo '[block_header] => Array
        (
            [alt_blocks_count] => 0
            [difficulty] => 155875514
            [grey_peerlist_size] => 19
            [height] => 16785
            [incoming_connections_count] => 0
            [last_known_block_index] => 16784
            [outgoing_connections_count] => 7
            [status] => OK
            [tx_count] => 7936
            [tx_pool_size] => 1
            [white_peerlist_size] => 25
            [hashrate] => 1298962.6166667
            [max_supply] => 100000000000000000
        )';
				echo '</pre>';

				echo '<pre>';
				echo '[total_supply] => 0
[total_supply_block] => 0';
				echo '</pre>';

				echo '<pre>';
				echo '[top_block] => Array
        (
            [major_version] => 1
            [miner_tx] => Array
                (
                    [extra] => 0171e334a7f44e2b8249ecc81ebf7718e223f3c18168f49510c7d4531996795a06021100000000274fda3fd60000000000000000
                    [unlock_time] => 16844
                    [version] => 1
                    [vin] => Array
                        (
                            [0] => Array
                                (
                                    [type] => ff
                                    [value] => Array
                                        (
                                            [height] => 16784
                                        )

                                )

                        )

                    [vout] => Array
                        (
                            [0] => Array
                                (
                                    [amount] => 91562
                                    [target] => Array
                                        (
                                            [data] => Array
                                                (
                                                    [key] => 683bce62f540b8e415d46299ee190ad49c296f55dece41dfe716ffec49adedfc
                                                )

                                            [type] => 02
                                        )

                                )

                            [1] => Array
                                (
                                    [amount] => 500000
                                    [target] => Array
                                        (
                                            [data] => Array
                                                (
                                                    [key] => 640555da9cef5f4362e81f148cb360471a9dd8428f73f0a368ca581a4f48685a
                                                )

                                            [type] => 02
                                        )

                                )

                            [2] => Array
                                (
                                    [amount] => 5000000
                                    [target] => Array
                                        (
                                            [data] => Array
                                                (
                                                    [key] => 45573931bdd9b25ea3916f34722d8aad96ee28c3a59145d50c811b6aac7d1876
                                                )

                                            [type] => 02
                                        )

                                )

                            [3] => Array
                                (
                                    [amount] => 10000000
                                    [target] => Array
                                        (
                                            [data] => Array
                                                (
                                                    [key] => d96b079274b99287e3045c4a1ef1d4930be4a97b871b2a7bff35323467a2550e
                                                )

                                            [type] => 02
                                        )

                                )

                            [4] => Array
                                (
                                    [amount] => 800000000
                                    [target] => Array
                                        (
                                            [data] => Array
                                                (
                                                    [key] => a0a96ea2bd65ccac9c07f8b37705d67fe50d5361cb8ae7f277355d7791035f4c
                                                )

                                            [type] => 02
                                        )

                                )

                            [5] => Array
                                (
                                    [amount] => 7000000000
                                    [target] => Array
                                        (
                                            [data] => Array
                                                (
                                                    [key] => 40aea94abb8c7a35e36a6e75312e306bdc6355d9c58b96a9b3721f43326844fc
                                                )

                                            [type] => 02
                                        )

                                )

                            [6] => Array
                                (
                                    [amount] => 50000000000
                                    [target] => Array
                                        (
                                            [data] => Array
                                                (
                                                    [key] => abcbd6e16e2dd2c115969fa82c138e6ca197f3aeb654c0799f7267f3cf73ee8a
                                                )

                                            [type] => 02
                                        )

                                )

                            [7] => Array
                                (
                                    [amount] => 300000000000
                                    [target] => Array
                                        (
                                            [data] => Array
                                                (
                                                    [key] => 99c24c85d2ecfacf6c806e9aa062ddf559ab462f7ecf931df1e697100f46bbb9
                                                )

                                            [type] => 02
                                        )

                                )

                        )

                )

            [minor_version] => 0
            [nonce] => a545f018
            [prev_id] => 594f0dd475a955e372499a42718b843090380d014c6ef1ef41eb460379d7fc4e
            [timestamp] => 1665041845
            [tx_hashes] => Array
                (
                )

            [dnxmined] => 357815591562
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