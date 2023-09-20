<?php 
ob_start();
require_once('header.php');
if (isset($_POST['add'])) {
    $cat_name = get_safe_value($con, $_POST['name']);
    
    // Check if the name is not empty
    if (!empty($cat_name)) {
        $category_query = "INSERT INTO categories (category) VALUES ('$cat_name')";
        $category_result = mysqli_query($con, $category_query);

        if ($category_result) {
            // Successfully added category
            // You can redirect or display a success message here
            header('location: categories.php'); // Redirect to categories page
        } else {
            // Handle the database insertion error here
            echo "Error: " . mysqli_error($con);
        }
    } else {
        // Handle the case where the name is empty
        echo "Category name cannot be empty";
    }
}
$category_select_query = "select * from categories";
$category_select_result = mysqli_query($con,$category_select_query);
//$category_select_row = mysqli_fetch_assoc($category_select_result);
if(isset($_GET['delete']) && $_GET['delete']!='' ){
    $delete_id = $_GET['delete'];
    $delCount = deleteById('categories',$delete_id);
    if($delCount >= 1){
        header('location:categories.php');
    }
    

}

?>
    <div class="content pb-0">
    <div class="animated fadeIn">
    
    <div class="alert alert-danger" role="alert" style="display:none;"></div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-header"><strong>ADD</strong><small> CATEGORIES</small></div>
                <form method="post" name="add_category" id="category_form">
                <div class="card-body card-block">
                    <div class="form-group"><label for="name" class=" form-control-label">NAME</label>
                    <input type="text" id="name" name="name"  placeholder="Add Categories" class="form-control" value="" maxlength="15" required></div>
                    <button id="payment-button" type="submit" name="add" class="btn btn-lg btn-info btn-block">
                    <span id="payment-button-amount">ADD</span>
                    </button>
                    <div class="alert alert-danger" role="alert" style="display:none;"></div>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>


<div class="content pb-0">
<div class="orders">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
            <div class="card-body">
                <h4 class="box-title">Categoris </h4>
            </div>
            <div class="card-body--">
                <div class="table-stats order-table ov-h">
                    <table class="table ">
                        <thead>
                        <tr>
                            <th class="serial">#</th>
                            <th>Name</th>
                            <!--<th>Delete</th>-->
                        </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                            <?php $i=0; while($category_select_row = mysqli_fetch_assoc($category_select_result)){ $i++ ?>
                                <td class="serial"><?=$i;?>.</td>
                                <td> <span class="name"><?=$category_select_row['category'];?></span> </td>
                                <!--<td>
                                <a href="categories.php?delete=<?=$category_select_row['id']?>"><span class="badge badge-complete">DELETE</span></a>
                                </td>-->
                            
                            </tr>
                            <?php } ?>
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
    $(document).ready(function(){
        // Initialize the form validation
        $("#category_form").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 15 // Adjust the maximum length as needed
                }
            },
            messages: {
                name: {
                    required: "Please enter a category name",
                    maxlength: "Category name must not exceed 15 characters"
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo($(".alert-danger")); // Display error messages in the alert div
            },
            submitHandler: function(form) {
                form.submit(); // Submit the form if it's valid
            }
        });
    });
</script>
