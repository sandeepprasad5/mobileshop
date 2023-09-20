<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
    <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="menu-title">Menu</li>
            <li class="menu-item-has-children dropdown active" id="navMenus">
                <a href="index.php" >Dashboard </a>
            </li>
            </li>
                <li class="menu-item-has-children dropdown" id="navMenus">
                <a href="admin_profile.php" >My Profile </a>
            </li>
            <li class="menu-item-has-children dropdown" id="navMenus">
                <a href="categories.php" >Categories </a>
            </li>
            <li class="menu-item-has-children dropdown" id="navMenus">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Product
            </a>
                <div class="nav-link dropdown-toggle" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="add_product.php">Add Product</a>
                <a class="dropdown-item" href="products.php">All Product</a>
                <!--<<a class="dropdown-item" href="featured.php">Featured Product</a>-->
                </div>
            </li>

            <li class="menu-item-has-children dropdown" id="navMenus">
                <a href="discount.php" >Discount/Coupon </a>
            </li>
            <li class="menu-item-has-children dropdown" id="navMenus">
                <a href="add_discount.php" >Add Discount/Coupon </a>
            </li>

            <li class="menu-item-has-children dropdown" id="navMenus">
                <a href="logo.php" >Logos </a>
            </li>
            <li class="menu-item-has-children dropdown" id="navMenus">
                <a href="store_users.php" >Store Users</a>
            </li>
            <!--<li class="menu-item-has-children dropdown" id="navMenus">
                <a href="store_user_details.php" >Store User Details</a>
            </li>-->
            <li class="menu-item-has-children dropdown" id="navMenus">
                <a href="orders.php" >Orders</a>
            </li>
        </ul>
    </div>
    </nav>
</aside>
<script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
<script>
    // adding active class
    $(document).ready(function(){
        $('ul li').click(function(){
            //console.log('bob the')
            $('li').removeClass("active");
            $(this).addClass("active");
        });
    });
</script>
