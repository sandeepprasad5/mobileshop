<?php ob_start();
require_once('header.php');

if(isset($_GET['view']) && $_GET['view']!=''){
    $user_id = $_GET['view'];
    $qu = "select * from users where user_id ='$user_id'";
    $res = mysqli_query($con,$qu);
    $value = mysqli_fetch_assoc($res);
    $userName = $value['name'];
    $userEmail = $value['email'];
    $userPassword = $value['password'];
    $userAddress = $value['address'];
    $userCreatedAt = $value['created_at'];
}
?>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Details Of User</h2><br>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="coupon_code">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=$userName;?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="discount_value">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" step="0.01" value="<?=$userEmail;?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="discount_value">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" step="0.01" value="<?=$userPassword;?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea">Example Textarea</label>
                        <textarea class="form-control" id="address" name="address" rows="5" step="0.01" readonly><?=$userAddress;?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="start_date">Joined Since:</label>
                        <input type="text" class="form-control" id="start_date" name="start_date" value="<?=$userCreatedAt;?>" readonly>
                    </div>
                    <a href="#" class="btn btn-secondary" onclick="history.go(-1); return false;">Back</a>
                </form>
            </div>
        </div>
    </div>
    <?php require_once('footer.php');?>
</html>
