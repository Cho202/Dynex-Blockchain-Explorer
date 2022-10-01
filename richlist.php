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
				<h3 class="text-white">Dynex is fundamentally private</h3>

				<p>It is based in the Cryptonote protocol. It uses unique one-time addresses for each transaction so that only the receiver knows where the money went. This is good, believe us. And, as if that wasn't enough, it signs the inputs with ring signatures. And this is great because that signature only proves that someone in that group created it. That means only the sender knows where the money came from.
				<br><br>But does this mean I have no way to prove a transaction or my funds to someone else? Glad you asked that, because...
				<li>Dynex is optionally transparent</li>
				<li>By address AND by transaction.</li>
				<br>
				There's this thing called a view key, you know? This is a kind of a read-only access to an address or a given transaction. This way, you may give your account view key to someone so that they may snoop around. Why would you do that? Here's why.<br><br>
				<h4 class="text-white">Untraceable transactions</h4>
				<p>Dynex employs a scheme of fully anonymous transactions satisfying both untraceability and unlinkability conditions. The sender is not required to cooperate with other users or a trusted third party to make his transactions.</p>

				<h4 class="text-white">Unlinkable payments</h4>
				<p>The Dynex protocol allows a user to publish a single address and receive unconditional unlinkable payments. The destination of each output (by default) is a public key, derived from recipient’s address and sender’s random data. Every destination key is unique by default, incoming payments, are unlinkable for a spectator.</p>

				<h4 class="text-white">One-time ring signatures</h4>
				<p>One-time ring signatures allows users to achieve unconditional unlinkability: a user produces a signature which can be checked by a set of public keys rather than a unique public key. The identity of the signer is indistinguishable from the other users whose public keys are in the set until the owner produces a second signature using the same keypair.</p>

				<h4 class="text-white">Great isn't it? Find out more about it here: Dynex - secure, private, untraceable</h4>
				<li><a class="text-blue" href="https://dynexcoin.org/a-new-level-of-privacy/">A New Level of Privacy</a></li>
				<li><a class="text-blue" href="https://dynexcoin.org/full-security-analysis/">Full Security Analalysis</a></li><br><br>

		
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