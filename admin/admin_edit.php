<?php ob_start(); require_once('header.php');
//view
$id = $_GET['id'];
$qu = "select * from admin_users where id='$id'";
$res = mysqli_query($con,$qu);
$value = mysqli_fetch_assoc($res);

//update 
if(isset($_POST['update'])){
    
    $username = get_safe_value($con,$_POST['username']);
    $password = get_safe_value($con,$_POST['password']);
    $status =   get_safe_value($con,$_POST['status']);

    $upQuery = "update admin_users set username = '$username', password= '$password', status= '$status' where id='$id'";
    $resu = mysqli_query($con,$upQuery);
    header('location:admin_profile.php');
}
?>
    <div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-header"><strong>ADMIN</strong><small> USER</small></div>
                <form method="post" name="update_admin">
                <div class="card-body card-block">
                    <div class="form-group"><label for="company" class=" form-control-label">USERNAME</label><input type="text" id="username" name="username"  placeholder="Enter username" class="form-control" value="<?=$value['username'];?>"></div>
                    <div class="form-group"><label for="vat" class=" form-control-label">PASSWORD</label><input type="text" id="password" name="password" placeholder="Enter password" class="form-control" value="<?=$value['password'];?>"></div>
                    <div class="form-group"><label for="street" class=" form-control-label">STATUS</label><input type="text" id="status" name="status" placeholder="Enter status" class="form-control" value="<?=$value['status'];?>"></div>
                    <button id="payment-button" type="submit" name="update" class="btn btn-lg btn-info btn-block">
                    <span id="payment-button-amount">Update</span>
                    </button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php require_once('footer.php');?>