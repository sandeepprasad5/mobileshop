<!-- header section strats -->
<?php session_start();

if (isset($_POST['logout'])) {
  unset($_SESSION['user_id']); // Unset the session variable
}

?>


<header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="index.php">
          <span>
          MobileShop
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <!--<li class="nav-item">
              <a class="nav-link" href="shop.php">
                Shop
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="why.php">
                Why Us
              </a>
            </li>-->
            <li class="nav-item">
              <a class="nav-link" href="order_history.php">
                My Orders
              </a>
            </li>
            <!--<li class="nav-item">
              <a class="nav-link" href="contact.php">Contact Us</a>
            </li>-->
          </ul>
          <div class="user_option">
          <?php if (isset($_SESSION['user_id'])) : ?>
            <form id="logout-form" method="post">
                <input type="hidden" name="logout" value="1">
                <a href="#" onclick="document.getElementById('logout-form').submit();">LOGOUT</a>
            </form>
          <?php else : ?>
              <a id="proceedToPaymentBtn2" href="#">LOGIN</a>
          <?php endif; ?>
           
            <a href="cart.php" class="cart">
              <i class="fa fa-shopping-bag cart-count total-items-values" aria-hidden="true"><?=isset($_SESSION['cart'])?count($_SESSION['cart']):'0';?></i>
            </a>
           <!-- <form class="form-inline ">
              <button class="btn nav_search-btn" type="submit">
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
            </form>-->
          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->
    <?php require_once('jsfunction.php');?>