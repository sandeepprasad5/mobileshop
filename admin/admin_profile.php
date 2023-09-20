<?php
   require_once('header.php');
   $admin_id = $_SESSION['ADMIN_ID'];
   $qu = "select * from admin_users where id= '$admin_id'";
   $res = mysqli_query($con,$qu);
   

?>

<div class="content pb-0">
<div class="orders">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
            <div class="card-body">
                <h4 class="box-title">Users </h4>
            </div>
            <div class="card-body--">
                <div class="table-stats order-table ov-h">
                    <table class="table ">
                        <thead>
                        <tr>
                            <th class="serial">#</th>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                            <tr>
                            <?php 
                            $i= 0;
                            while($row = mysqli_fetch_assoc($res)){ $i++?>

                                <td class="serial"><?=$i;?>.</td>
                                <td> #<?=$row['id'];?></td>
                                <td> <span class="name"><?=$row['username'];?></span> </td>
                                <td> <span class="product"><?=$row['password'];?></span> </td>
                                <td> <span class="count"><?=$row['status'];?></span></td>
                                <td>
                                    <a href="admin_edit.php?id=<?=$row['id']?>"><span class="badge badge-complete">Edit</span></a>
                                </td>
                            </tr>
                        <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php require_once('footer.php');?>