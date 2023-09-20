<?php
   require_once('connection.inc.php');
   require_once('functions.inc.php');
   session_start();
   $login_msg ='';
   if(isset($_POST['submit'])){
      $username = get_safe_value($con,$_POST['username']);
      $password = get_safe_value($con,$_POST['password']);

      $query = "select * from admin_users where username = '$username' AND password = '$password'";
      $result = mysqli_query($con,$query);
      $count = mysqli_num_rows($result);
      $row = mysqli_fetch_assoc($result);

   if($count>0){

      $_SESSION['ADMIN_LOGIN'] = 'yes';
      $_SESSION['ADMIN_USERNAME'] = $username;
      $_SESSION['ADMIN_ID'] = $row['id'];
      header('location:index.php');

   }else{
      
      $login_msg = 'Not verified';
   }

   }

?>
<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Login Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   </head>
   <body class="bg-dark">
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                  <form name="loginForm" method="post">
                     <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="username" required maxlength="25">
                     </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required maxlength="25">
                     </div>
                     <button type="submit" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
					</form>
               <div class="error_login"><?=$login_msg?></div>
               </div>
               
            </div>
         </div>
      </div> 
<script src="assets/js/popper.min.js" type="text/javascript"></script>
<!--<script src="assets/js/plugins.js" type="text/javascript"></script>
<script src="assets/js/main.js" type="text/javascript"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$(document).ready(function () {
   $("form[name='loginForm']").submit(function (event) {
         var username = $.trim($("#username").val());
         var password = $.trim($("#password").val());
         var errorLogin = $(".error_login");
         
         if (username == "") {
            errorLogin.html("Please enter a username.");
            event.preventDefault();
            return false;
         }

         if (password == "") {
            errorLogin.html("Please enter a password.");
            event.preventDefault();
            return false;
         }

         if (username.length > 255) {
            errorLogin.html("Username cannot exceed 255 characters.");
            event.preventDefault();
            return false;
         }

         if (password.length > 255) {
            errorLogin.html("Password cannot exceed 255 characters.");
            event.preventDefault();
            return false;
         }

         // You can add more complex validation here if needed.

         // If all validation passes, the form will be submitted.
   });
});
</script>


</body>
</html>