<?php ob_start();
require_once('header.php');

if(isset($_GET['order']) && $_GET['order']!=''){
    $order_id = $_GET['order'];
    $qu = "select * from orders where order_id ='$order_id'";
    $res = mysqli_query($con,$qu);
    $value = mysqli_fetch_assoc($res);

    $user_name = getUserName($value['user_id']);
    $order_date = $value['order_date'];
    $total_amount = $value['total_amount'];
    $status = $value['status'];
    $reason_for_cancellation = $value['reason_for_cancellation'];
    $created_at = $value['created_at'];
}
?>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Details Of User (<?=$order_id;?>)</h2><br>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="coupon_code">User Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=$user_name;?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="coupon_code">Order Date:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=$order_date;?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="coupon_code">Total Amount:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=$total_amount;?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="coupon_code">Status:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=$status;?>" readonly>
                    </div>
                    <?php if($reason_for_cancellation!=''){?>
                    <div class="form-group">
                        <label for="exampleTextarea">Reason For Cancellation</label>
                        <textarea class="form-control" id="exampleTextarea" rows="5" readonly><?=$reason_for_cancellation;?></textarea>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="start_date">Created Date:</label>
                        <input type="text" class="form-control" id="start_date" name="start_date" value="<?=$created_at;?>" readonly>
                    </div>
                    <a href="#" class="btn btn-secondary" onclick="history.go(-1); return false;">Back</a>
                </form>
            </div>
        </div>
    </div>
    <?php require_once('footer.php');?>
</html>
