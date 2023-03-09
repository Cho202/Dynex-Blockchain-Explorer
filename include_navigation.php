<nav class="navbar navbar-expand-lg navbar-light border-bottom" style="background-color: #0e0e0e; position: -webkit-sticky; position: sticky; top: 0; z-index: 99;">
  <!-- Navbar content -->
  <a class="navbar-brand" href="https://dynexcoin.org"><img src="assets/images/turingx-square_2.png" style="height: 50px;"></a><div class="fs-16 text-white"><strong>DYNEX BLOCKCHAIN EXPLORER</strong></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      
      <li class="nav-item">
        <a class="nav-link text-white" href="home.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="richlist.php">RICHLIST</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="api_specs.php">API</a>
      </li>
    </ul>

    
    <div class="wd-4 text-right" style="width: 100%;">
      <form action="show_block.php" method="post">
            <div class="form-label">FIND BLOCK NUMBER</div>
            <input class="hostname-box" type="text" name="block" required="" value="">
            <input type="submit" style="margin-top:5px;">
      </form>
    </div>
  
    <div class="wd-4 text-right" style="width: 100%;">
      <form action="show_transaction.php" method="post">
            <div class="form-label">FIND TRANSACTION HASH</div>
            <input class="hostname-box" type="text" name="tx" required="" value="">
            <input type="submit" style="margin-top:5px;">
          </form>
    </div>

  </div>
</nav>




