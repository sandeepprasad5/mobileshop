<?php 
    ob_start();
    require_once('header.php'); 
    $update = 0;
    $final_msg = '';
    $value['category'] = ''; 
    $value['name'] = '';
    $value['sku'] = ''; 
    $value['mrp'] = '';
    $value['selling_price'] = '';
    $value['quantity'] = '';
    $value['short_desc'] = ''; 
    $value['description'] = ''; 
    $value['meta_title'] = ''; 
    $value['meta_desc'] = '';
    $value['meta_keyword'] = ''; 

    if(isset($_POST['add'])){
        $category = get_safe_value($con,$_POST['category']);
        $product_name = get_safe_value($con,$_POST['product_name']);
        $product_sku = get_safe_value($con,$_POST['product_sku']);
        $mrp = get_safe_value($con,$_POST['mrp']);
        $selling_price = get_safe_value($con,$_POST['selling_price']);
        $qty = get_safe_value($con,$_POST['qty']);
        $short_desc = get_safe_value($con,$_POST['short_desc']);
        $descr = get_safe_value($con,$_POST['descr']);
        $meta_title = get_safe_value($con,$_POST['meta_title']);
        $meta_descr = get_safe_value($con,$_POST['meta_descr']);
        $image_name = get_safe_value($con,$_FILES['image_file']['name']);
        $meta_key = get_safe_value($con,$_POST['meta_key']);
        $featured = get_safe_value($con,$_POST['featured']);

        if (!empty($image_name)) {
            $uploadProductImage = uploadProductImage($_FILES['image_file']['name'],$_FILES['image_file']['tmp_name']);
            if($uploadProductImage['status'] != 1){
                $final_msg = $uploadProductImage['message'][0];
            }else{
                $result_table = insertIntoProductTable($category,$product_name,$product_sku,$mrp,$selling_price,$qty,$short_desc,$descr,$image_name,$meta_title,$meta_descr,$meta_key,$featured);

                if($result_table == 1){
                    //insert in featured table as well
                    insertIntoFeaturedTable($featured);
                    header('location:products.php');
                }else{
                    echo 'not added'. $result_table;
                }

            }
        }else {
            echo 'Image is mandatory';
        }
    }

    if(isset($_GET['id']) && $_GET['id']!=''){
        $update = 1;
        $pro_id = $_GET['id'];
        $qu = "select * from products where id ='$pro_id'";
        $res = mysqli_query($con,$qu);
        $value = mysqli_fetch_assoc($res);

        $selectedCat = selectedCategory($value['categories_id']);
        //$selectedFeat = selectedFeatured($pro_id);
        
        //update
        if(isset($_POST['update'])){
            
            $category = get_safe_value($con,$_POST['category']);
            $product_name = get_safe_value($con,$_POST['product_name']);
            $product_sku = get_safe_value($con,$_POST['product_sku']);
            $mrp = get_safe_value($con,$_POST['mrp']);
            $selling_price = get_safe_value($con,$_POST['selling_price']);
            $qty = get_safe_value($con,$_POST['qty']);
            $short_desc = get_safe_value($con,$_POST['short_desc']);
            $descr = get_safe_value($con,$_POST['descr']);
            $meta_title = get_safe_value($con,$_POST['meta_title']);
            $meta_descr = get_safe_value($con,$_POST['meta_descr']);
            $image_name = get_safe_value($con,$_FILES['image_file']['name']);
            $meta_key = get_safe_value($con,$_POST['meta_key']);
            $featured  = get_safe_value($con,$_POST['featured']);

            
            if (!empty($image_name)) {
            //upload image 
            $target_dir = "images/product/";
            $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
            $image_name = get_safe_value($con,$_FILES["image_file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            $checkSize = getimagesize($_FILES['image_file']['tmp_name']);
            if($checkSize !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            // Check if file already exists
            // if (file_exists($target_file)) {
            // echo "Sorry, file already exists.";
            // $uploadOk = 0;
            // }
            // Check file size
            if ($_FILES["image_file"]["size"] > 1000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "webp" ) {
            echo "Sorry, only JPG, JPEG, PNG & WEBP files are allowed.";
            $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                        echo "The file ". htmlspecialchars( basename( $_FILES["image_file"]["name"])). " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
            }
            $upImgQuery = "update products set `categories_id`='$category',`image`='$image_name' where id='$pro_id'";
            $resImgu = mysqli_query($con,$upImgQuery);
            
            }
            
            $upQuery = "update products set `categories_id`='$category',`name`='$product_name',`sku`='$product_sku',`mrp`='$mrp',`selling_price`='$selling_price',`quantity`='$qty',`short_desc`='$short_desc',`description`='$descr',`meta_title`='$meta_title',`meta_desc`='$meta_descr',`meta_keyword`='$meta_key',`status`='1',`featured_status`= '$featured' where id='$pro_id'";
            $resu = mysqli_query($con,$upQuery);
            updateIntoFeaturedTable($featured,$pro_id);
            header('location:products.php');
        }
    
        
    }


?>
<div class="content pb-0">
    <div class="animated fadeIn">
    
    <div class="alert" role="alert" style="display:block;">
        <?=$final_msg;?>
    </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-header"><strong>Add</strong><small>Product</small></div>
                <form method="post" name="add_product" enctype="multipart/form-data">
                <div class="card-body card-block">

                    <div class="form-group">
                    <label for="category">Select Product Category:</label>
                    <select class="form-control" id="category" name="category" required>
                        <?php
                        $query = "SELECT * FROM categories";
                        $result = mysqli_query($con, $query);

                        // Check if this is an update
                        if ($update == 1) {
                            // Ensure $selectedCat is properly set
                            if (isset($selectedCat) && !empty($selectedCat)) {
                                echo '<option value="' . $value['categories_id'] . '" selected>' . $selectedCat . '</option>';
                            } else {
                                echo '<option value="">Select Category</option>';
                            }

                            // Loop through other categories
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['id'] != $value['categories_id']) {
                                    echo '<option value="' . $row['id'] . '">' . $row['category'] . '</option>';
                                }
                            }
                        } else {
                            // This is not an update, so display a default "Select Category" option
                            echo '<option value="">Select Category</option>';

                            // Loop through all categories
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['id'] . '">' . $row['category'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    </div>

                    <div class="form-group"><label for="company" class=" form-control-label">Product Name</label><input type="text" id="product_name" name="product_name"  placeholder="Enter product name" class="form-control" value="<?=$value['name']?>" required maxlength="25"></div>

                    <div class="form-group"><label for="company" class=" form-control-label">Product SKU</label><input type="text" id="product_sku" name="product_sku"  placeholder="Enter product SKU" class="form-control" value="<?=$value['sku']?>" required maxlength="10"></div>

                    <div class="form-group"><label for="company" class=" form-control-label">MRP</label><input type="text" id="mrp" name="mrp"  placeholder="Enter MRP" class="form-control" value="<?=$value['mrp']?>" required maxlength="5"></div>

                    <div class="form-group"><label for="company" class=" form-control-label">Selling Price</label><input type="text" id="selling_price" name="selling_price"  placeholder="Enter Selling Price" class="form-control" value="<?=$value['selling_price']?>" required maxlength="5"></div>

                    <div class="form-group"><label for="company" class=" form-control-label">Quantity</label><input type="tel" id="qty" name="qty"  placeholder="Enter Quantity" class="form-control" value="<?=$value['quantity']?>" required maxlength="3"></div>

                    <div class="form-group">
                        <label for="formFileDisabled" class="form-label">Upload Image</label>
                        <input class="form-control" name="image_file" type="file" id="image_file"  />
                    </div>

                    <div class="form-group"><label for="company" class=" form-control-label">Short Description</label><input type="text" id="short_desc" name="short_desc"  placeholder="Enter Short Description" class="form-control" value="<?=$value['short_desc']?>" required maxlength="25"></div>

                    <div class="form-group"><label for="company" class=" form-control-label">Description</label><input type="text" id="descr" name="descr"  placeholder="Enter Description" class="form-control" value="<?=$value['description']?>" required maxlength="50"></div>

                    <div class="form-group"><label for="company" class=" form-control-label">Meta Title</label><input type="text" id="meta_title" name="meta_title"  placeholder="Enter Meta Title" class="form-control" value="<?=$value['meta_title']?>" required maxlength="10"></div>

                    <div class="form-group"><label for="company" class=" form-control-label">Meta Description</label><input type="text" id="meta_descr" name="meta_descr"  placeholder="Enter Meta Description" class="form-control" value="<?=$value['meta_desc']?>" required maxlength="25"></div>

                    <div class="form-group"><label for="company" class=" form-control-label">Meta Keyword</label><input type="text" id="meta_key" name="meta_key"  placeholder="Enter Meta Keyword" class="form-control" value="<?=$value['meta_keyword']?>" required maxlength="10"></div>
                    
                    <div class="form-group">
                    <label for="featured">Select Featured Or Not:</label>
                    <select class="form-control" id="featured" name="featured" required>
                        <?php
                        // Check if this is an update
                        $query = "SELECT * FROM featured where product_id = '$pro_id'";
                        $result = mysqli_query($con, $query);
                        $value = mysqli_fetch_assoc($result);
                        $feat = $value['featured_status'];
                        
                        if ($update == 1) {
                            // Display the current value (1 for Yes, 0 for No, or null for "Select Featured Product")
                            if ($feat === '1') {
                                echo '<option value="1" selected>Yes</option>';
                                echo '<option value="0">No</option>';
                            } elseif ($feat === '0') {
                                echo '<option value="1">Yes</option>';
                                echo '<option value="0" selected>No</option>';
                            } else {
                                echo '<option value="">Select Featured Product</option>';
                                echo '<option value="1">Yes</option>';
                                echo '<option value="0">No</option>';
                            }
                        } else {
                            // This is not an update, so display a default "Select Featured Product" option
                            echo '<option value="">Select Featured Product</option>';
                            echo '<option value="1">Yes</option>';
                            echo '<option value="0">No</option>';
                        }
                        ?>
                    </select>

                    </div>
                    
                    <?php if($update == 1){ ?>
                        <button id="payment-button" type="submit" name="update" class="btn btn-lg btn-info btn-block">
                        <span id="payment-button-amount">Update Product</span>
                        </button>
                    <?php }else{ ?>
                        <button id="payment-button" type="submit" name="add" class="btn btn-lg btn-info btn-block">
                        <span id="payment-button-amount">Add Product</span>
                        </button>
                    <?php } ?>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php require_once('footer.php'); ?>
<script>
    $(document).ready(function() {
        $("form[name='add_product']").submit(function(event) {
            var errorMessages = []; // Array to store error messages

            // Validate each field
            var category = $("#category").val();
            if (category === "") {
                errorMessages.push("Category is required.");
            }

            var product_name = $("#product_name").val();
            if (product_name === "") {
                errorMessages.push("Product name is required.");
            }

            var product_sku = $("#product_sku").val();
            if (product_sku === "") {
                errorMessages.push("Product SKU is required.");
            }

            var mrp = $("#mrp").val();
            if (mrp === "") {
                errorMessages.push("MRP is required.");
            }

            var selling_price = $("#selling_price").val();
            if (selling_price == "") {
                errorMessages.push("Selling price is required.");
            }

            var qty = $("#qty").val();
            if (qty == "") {
                errorMessages.push("Quantity is required.");
            }

            var short_desc = $("#short_desc").val();
            if (short_desc == "") {
                errorMessages.push("Short Description is required.");
            }

            var descr = $("#descr").val();
            if (descr == "") {
                errorMessages.push("Description is required.");
            }

            var meta_title = $("#meta_title").val();
            if (meta_title == "") {
                errorMessages.push("Meta title is required.");
            }

            var meta_descr = $("#meta_descr").val();
            if (meta_descr == "") {
                errorMessages.push("Meta Description is required.");
            }

            var meta_key = $("#meta_key").val();
            if (meta_key == "") {
                errorMessages.push("Meta key is required.");
            }

            var featured = $("#featured").val();
            if (featured == "") {
                errorMessages.push("Featured or not.");
            }
            <?php if($update != 1) {?>
            var image_file = $("#image_file").val();
            if (image_file == "") {
                errorMessages.push("Image is required.");
            }
            <?php } ?>

            // Repeat the above pattern for other form fields
            // ...

            // Check if there are any error messages
            if (errorMessages.length > 0) {
                event.preventDefault(); // Prevent form submission

                // Display the error messages in an alert
                alert("Please fix the following errors:\n\n" + errorMessages.join("\n"));
            }
        });
    });
</script>