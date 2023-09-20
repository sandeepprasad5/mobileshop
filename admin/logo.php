<?php
    ob_start();
    require_once('header.php');
    $qu = "select * from logo";
    $res_logo = mysqli_query($con,$qu);
   
    //ACTIVE THE LOGO SECTION
    if(isset($_GET['set_status']) && $_GET['set_status']!=''){
    $logo_id = $_GET['set_status'];
    $returnActivated = activate_logo($logo_id);
    if($returnActivated== '1'){
        header('location:logo.php');
    }
    }

    if(isset($_GET['delete']) && $_GET['delete']!='' ){
        $delete_id = $_GET['delete'];
        $delCount = deleteById('logo',$delete_id);
        if($delCount >= 1){
            header('location:logo.php');
        }
        
    
    }

?>

<div class="content pb-0">
<div class="orders">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
            <div class="card-body">
                <h4 class="box-title">Logos </h4>
            </div>
            <a class="btn btn-primary" href="logo_manage.php" style="width: 150px;margin-bottom: 5px;">ADD NEW LOGO</a>
            <div class="card-body--">
                <div class="table-stats order-table ov-h">
                    <table class="table ">
                        <thead>
                        <tr>
                            <th class="serial">#</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>STATUS</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                            <tr>
                            <?php 
                            $i= 0;
                            while($row_logo = mysqli_fetch_assoc($res_logo)){ $i++?>

                                <td class="serial"><?=$i;?>.</td>
                                <td> <span class="name"><?=$row_logo['name'];?></span> </td>
                                <td class="avatar pb-0">
                                <div class="round-img">
                                    <a href="#"><img class="rounded-circle" src="images/logo/<?=$row_logo['image']?>" alt=""></a>
                                </div>
                                </td>
                                <?php if($row_logo['set_status']== 1 ){?>
                                <td>
                                <a href="logo.php?set_status=<?=$row_logo['id']?>"><span class="badge badge-complete">ACTIVE</span></a>
                                </td>
                                <?php }else{ ?>
                                <td>
                                <a href="logo.php?set_status=<?=$row_logo['id']?>"><span class="badge badge-complete">DEACTIVE</span></a>
                                </td>
                                <?php } ?>
                                <td>
                                    <a href="logo_manage.php?id=<?=$row_logo['id']?>"><span class="badge badge-complete">Edit</span></a>
                                </td>
                                <td>
                                    <a href="logo.php?delete=<?=$row_logo['id']?>"><span class="badge badge-complete">DELETE</span></a>
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