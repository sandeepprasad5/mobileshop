<?php
    $con = mysqli_connect("localhost","root","","e-commercestore");
    if($con){
      
    }else{
      echo "mysql error: ". mysqli_connect_error();
    }

?>