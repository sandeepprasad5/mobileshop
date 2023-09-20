<?php
    ob_start();
    require_once('header.php');
    $que = "select * from products";
    $res_pro = mysqli_query($con,$que);
   
    //ACTIVE THE PRODUCT 
    if(isset($_GET['set_id']) && $_GET['set_id']!=''){
        $prod_id = $_GET['set_id'];
        $prod_status = $_GET['set_status'];

        if($prod_status == 0){
            $prod_set_query = "update products set status = '1' where id='$prod_id'";
            $prod_set_result = mysqli_query($con,$prod_set_query);
            header('location:products.php');
        }else{
            $prod_set_query = "update products set status = '0' where id='$prod_id'";
            $prod_set_result = mysqli_query($con,$prod_set_query);
            header('location:products.php');

        }
    
    }

    //DELETE THE PRODUCT 
    if(isset($_GET['delete']) && $_GET['delete']!='' ){
        $delete_id = $_GET['delete'];
        $delCount = deleteById('products',$delete_id);
        $featCount = deleteFetPro('featured',$delete_id);
        
        if($delCount >= 1 && $featCount>=1){
            header('location:products.php');
        }
        
    
    }

?>

<div class="content pb-0">
<div class="orders">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
            <div class="card-body">
                <h4 class="box-title">Products </h4>
            </div>
            <a class="btn btn-primary" href="add_product.php" style="width: 180px;margin-bottom: 5px;margin-left: 20px;">ADD NEW PRODUCT</a>
            <!--filter product start-->
            <div class="container mt-4">
                <form method="POST" action="filter_products.php" class="mb-3" id="filter-form">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                        <input type="text" name="product_code" class="form-control" placeholder="Product Code">
                        </div>
                        <div class="col-md-4 mb-3">
                        <input type="text" name="product_name" class="form-control" placeholder="Product Name">
                        </div>
                        <div class="col-md-4 mb-3">
                        <select name="product_status" class="form-control">
                            <option value="">-- Select Status --</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        </div>
                        <div class="col-md-12">
                        <button type="submit" name="filter" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--filter product ends-->
            <div class="card-body--">
                <div class="table-stats order-table ov-h">
                    <table class="table ">
                        <thead>
                        <tr>
                            <th class="serial">#</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>IMAGE</th>
                            <th>STATUS</th>
                            <th>FEATURED PRODUCT</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                        </thead>
                        <tbody id="filtered-products">
                        
                            <tr >
                            <?php 
                            $i= 0;
                            while($row_prod = mysqli_fetch_assoc($res_pro)){ $i++?>
                                    
                                <td class="serial" ><?=$i;?>.</td>
                                <td> <span class="name"><?=$row_prod['name'];?></span> </td>
                                <td> <span class="name"><?=$row_prod['sku'];?></span> </td>
                                <td class="avatar pb-0">
                                <div class="round-img">
                                    <a href="#"><img class="rounded-circle" src="images/product/<?=$row_prod['image']?>" alt=""></a>
                                </div>
                                </td>
                                
                                <?php if($row_prod['status']== 1 ){?>
                                <td>
                                <a href="products.php?set_id=<?=$row_prod['id']?>&set_status=<?=$row_prod['status']?>"><span class="badge badge-complete">ACTIVED</span></a>
                                </td>
                                <?php }else{ ?>
                                <td>
                                <a href="products.php?set_id=<?=$row_prod['id']?>&set_status=<?=$row_prod['status']?>"><span class="badge badge-complete">DEACTIVED</span></a>
                                </td>
                                <?php } ?>
                                <td> <span class="name"><?=$row_prod['featured_status'] =='1'?'Yes':'No';?></span> </td>
                                <td>
                                    <a href="add_product.php?id=<?=$row_prod['id']?>"><span class="badge badge-complete">Edit</span></a>
                                </td>
                                <td>
                                    <a href="products.php?delete=<?=$row_prod['id']?>"><span class="badge badge-complete">DELETE</span></a>
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

<script>
    $(document).ready(function() {
      // Submit the filter form using AJAX
      $("#filter-form").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        //alert(formData);
        $.ajax({
          type: "POST",
          url: "filter_products_ajax.php",
          data: formData,
          success: function(response) {
            $("#filtered-products").html(response);
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      });
    });
  </script>