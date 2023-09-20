<?php ob_start();
require_once('header.php');?>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Discount Coupon Management</h2><br>
                <form action="process_coupon.php" method="post">
                    <div class="form-group">
                        <label for="coupon_code">Coupon Code:</label>
                        <input type="text" class="form-control" placeholder="Enter coupon code" id="coupon_code" name="coupon_code" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="discount_type">Discount Type:</label>
                        <select class="form-control" id="discount_type" name="discount_type">
                            <option value="fixed_amount">Fixed Amount</option>
                            <option value="percentage">Percentage</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount_value">Discount Value</label>
                        <input type="number" class="form-control" placeholder="Enter discount value" id="discount_value" name="discount_value" maxlength="2" >
                    </div>
                    <div class="form-group">
                        <label for="product_category">Product Category:</label>
                        <select class="form-control" id="product_category" name="product_category" >
                            <option value="all_products">All Products</option>
                            <option value="product_specific">Product Specific</option>
                        </select>
            
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" min="<?php echo date('Y-m-d'); ?>" >
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" min="<?php echo date('Y-m-d'); ?>" >
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Activate Coupon</label>
                    </div>
                    <button type="submit" name="add_coupon" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
<?php require_once('footer.php');?>
    
<script>
$(document).ready(function() {
    $("form").submit(function(event) {
        var couponCode = $("#coupon_code").val();
        var discountType = $("#discount_type").val();
        var discountValue = $("#discount_value").val();
        var productCategory = $("#product_category").val();
        var startDate = $("#start_date").val();
        var endDate = $("#end_date").val();
        
        // Reset any previous error messages
        $(".error-message").remove();
        
        // Validate Coupon Code (not empty)
        if (couponCode === "") {
            event.preventDefault();
            $("#coupon_code").after('<p class="text-danger error-message">Coupon Code is required</p>');
        }
        
        // Validate Discount Value (not empty and greater than 0)
        if (discountValue === "" || parseFloat(discountValue) <= 0) {
            event.preventDefault();
            $("#discount_value").after('<p class="text-danger error-message">Discount Value must be greater than 0</p>');
        }
        
        // Validate Start Date (not empty and in the future)
        if (startDate === "" || new Date(startDate) < new Date()) {
            event.preventDefault();
            $("#start_date").after('<p class="text-danger error-message">Start Date must be a future date</p>');
        }
        
        // Validate End Date (not empty and greater than Start Date)
        if (endDate === "" || new Date(endDate) <= new Date(startDate)) {
            event.preventDefault();
            $("#end_date").after('<p class="text-danger error-message">End Date must be greater than Start Date</p>');
        }
    });
});
</script>

</html>
