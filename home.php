<?php
// login check:
include 'include_logincheck.php';
// include head:
include 'include_head.php';
?>

<!-- bg-dark: #343a40  style="background-image: url('assets/images/dashboard_background.png');" #F8F8F8-->
<body class="font-apple-system fs-12" style="background-color: #181818;">

	<!-- Menu -->
	<?php include 'include_navigation.php';?>
	
	<!-- Main AREA -->
	<br>
	<div class="section">
		<div class="container-fluid">	
			<div class="row">	

				<div class="col-md-12" valign="top">
							<div class="p-0" id="coredata" style="background-color: #0e0e0e; border-radius: 25px; border:  0px;"><img src="assets/images/_smarty/loaders/1.gif" style="width: 50px; height: : 50px;">&nbsp;&nbsp;LOADING...
							</div>
				</div>

				
			</div> <!-- row -->

			<div class="row">
				<div class="col-md-12" valign="top">
					<div class="card" id="1" style="background-color: #101010;">	
						<div class="card-header border-bottom border-dark text-white" style="background-color: #0000; color: #fffff;">
							<strong>LATEST TRANSACTIONS</strong>
						</div>
						<div class="card-text p-10" style="background-color: #0e0e0e;">
							<div id="transactions"><img src="assets/images/_smarty/loaders/1.gif" style="width: 50px; height: : 50px;">&nbsp;&nbsp;LOADING...</div>
						</div>
					</div>
				</div>

			</div> <!-- row -->

			<div class="row">
				<div class="col-md-12" valign="top">
					<div class="card" id="1" style="background-color: #101010;">	
						<div class="card-header border-bottom border-dark text-white" style="background-color: #0000; color: #fffff;">
							<strong>TRANSACTIONS IN NODE MEMORY POOL</strong>
						</div>
						<div class="card-text p-10" style="background-color: #0e0e0e;">
							<div id="transactionspool"><img src="assets/images/_smarty/loaders/1.gif" style="width: 50px; height: : 50px;">&nbsp;&nbsp;LOADING...</div>
						</div>
					</div>
				</div>

			</div> <!-- row -->

			<div class="row">
				<div class="col-md-12" valign="top">
					<div class="card" id="1" style="background-color: #101010;">	
						<div class="card-header border-bottom border-gray text-white" style="background-color: #0000; color: #fffff;">
							<strong>LATEST BLOCKS</strong>
						</div>
						<div class="card-text p-10" style="background-color: #0e0e0e;">
							<div id="blocks"><img src="assets/images/_smarty/loaders/1.gif" style="width: 50px; height: : 50px;">&nbsp;&nbsp;LOADING...</div>
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

<script>
	$(document).ready(function(){
	$("#coredata").load("include_coredata.php");
    $("#transactions").load("include_transactions.php");
    $("#transactionspool").load("include_transactions_pool.php");
    $("#blocks").load("include_blocks.php");
	setInterval(function(){
	      $("#coredata").load("include_coredata.php");
	      $("#transactions").load("include_transactions.php");
	      $("#transactionspool").load("include_transactions_pool.php");
	      $("#blocks").load("include_blocks.php");
	}, 60000);
	});
</script>


</body>





</html>