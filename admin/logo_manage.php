<?php 
ob_start();
require_once('header.php');
//view
$logoName = '';
$imageName = '';
$update = 0;
$final_msg = '';
$uploadImageLogo['status'] = 1;
// Add new logo
if (isset($_POST['add'])) {
    $logo_name = get_safe_value($con, $_POST['name']);
    $image_file_name = get_safe_value($con, basename($_FILES['image_file']['name']));

    if (!empty($logo_name) && !empty($image_file_name)) {
        $uploadImageLogo = uploadImageLogo($_FILES['image_file']['name'], $_FILES['image_file']['tmp_name']);

        if ($uploadImageLogo['status'] == 1) {
            $ins_logo_query = "insert into logo (name, image, set_status) values ('$logo_name', '$image_file_name', '0')";
            mysqli_query($con, $ins_logo_query);
            header('location:logo.php');
        } else {
            $final_msg = $uploadImageLogo['message'][0];
        }
    } else {
        echo 'All fields are mandatory';
    }
}

        
    
if(isset($_GET['id']) && $_GET['id']!=''){
    $update = 1;
    $uploadOk = 1;
    $logoNameOk = 1;
    $logo_id = $_GET['id'];
    $qu = "select * from logo where id ='$logo_id'";
    $res = mysqli_query($con,$qu);
    $value = mysqli_fetch_assoc($res);
    $logoName = $value['name'];
    $imageName = $value['image'];
    
    // Function to check if a field is empty or not set
    function isFieldEmpty($fieldValue) {
        return empty($fieldValue) && !isset($fieldValue);
    }

    // Update
    if (isset($_POST['update'])) {
        $newLogoName = get_safe_value($con, $_POST['name']);
        $newImageName = get_safe_value($con, basename($_FILES['image_file']['name']));
        
        // Check if the user has made changes
        $isNameChanged = !isFieldEmpty($newLogoName) && $newLogoName !== $logoName;
        $isImageChanged = !isFieldEmpty($newImageName) && $newImageName !== $imageName;
       
        // Perform updates for name and image separately if changes were made
        if ($isNameChanged && $newLogoName != '') {
            // Handle name update
            $upQuery = "UPDATE logo SET name = '$newLogoName' WHERE id='$logo_id'";
            mysqli_query($con, $upQuery);
            $logoName = $newLogoName;
           
        }else if($newLogoName != ''){
            $logoNameOk = 1;
        }else{
            $logoNameOk = 0;
        }


        // Perform updates only if changes were made
        if ($newImageName !='') {
            // Handle image upload
            $target_dir = "images/logo/";
            $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            

            // Check if the file is an image
            $checkSize = getimagesize($_FILES['image_file']['tmp_name']);
            if ($checkSize === false) {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            // if (file_exists($target_file)) {
            //     echo "Sorry, file already exists.";
            //     $uploadOk = 0;
            // }

            // Check file size
            if ($_FILES["image_file"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            $allowedExtensions = ["jpg", "jpeg", "png", "webp"];
            if (!in_array($imageFileType, $allowedExtensions)) {
                echo "Sorry, only JPG, JPEG, PNG & WEBP files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                    
                    if ($isImageChanged) {
                        $uploadOk = 1;
                        // Update image if changed
                        $upQuery = "UPDATE logo SET image = '$newImageName' WHERE id='$logo_id'";
                        mysqli_query($con, $upQuery);
                        $imageName = $newImageName;
                    }

                    
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            // No changes were made, display a message
            echo "No changes were made.";
        }
        if ($uploadOk != 0 && $logoNameOk !=0 ) {
        header('location: logo.php');
        }
    }

    
}
?>
    <div class="content pb-0">
    <div class="animated fadeIn">
    <?php if($uploadImageLogo['status'] != 1){?>
    <div class="alert alert-danger" role="alert">
        <?=$final_msg;?>
    </div>
    <?php } ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-header"><strong><?php echo ($update == '1') ? 'UPDATE' : 'ADD'; ?></strong><small> LOGO</small></div>
                <form method="post" name="update_logo" enctype="multipart/form-data">
                <div class="card-body card-block">
                    <div class="form-group"><label for="company" class=" form-control-label">NAME</label><input type="text" id="name" name="name"  placeholder="Enter username" class="form-control" value="<?=$logoName;?>" maxlength="20" required></div>
                    <div class="form-group">
                        <label for="formFileDisabled" class="form-label">UPLOAD IMAGE</label>
                        <input class="form-control" name="image_file" type="file" id="formFileDisabled" value="" />
                    </div>
                    <?php if($update == 1){ ?>
                        <img src="images/logo/<?php echo $imageName; ?>" alt="Current Image" id="currentImage" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        <button id="payment-button" type="submit" name="update" class="btn btn-lg btn-info btn-block">
                        <span id="payment-button-amount">Update Logo</span>
                        </button>
                        
                    <?php }else{ ?>
                        <button id="payment-button" type="submit" name="add" class="btn btn-lg btn-info btn-block">
                        <span id="payment-button-amount">Add Logo</span>
                        </button>
                    <?php } ?>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php require_once('footer.php');?>
<script>
$(document).ready(function() {
    $("form[name='update_logo']").submit(function(e) {
        var nameInput = $("#name");
        var nameValue = nameInput.val().trim();
        var imageInput = $("#formFileDisabled");
        var imageValue = imageInput.val().trim();

        // Client-side validation
        if (nameValue == "") {
            alert("Please enter a name./");
            nameInput.focus();
            e.preventDefault(); // Prevent form submission
        }
        <?php if($update != 1){ ?>
            if (imageValue == "") {
            alert("Please select an image file.");
            e.preventDefault(); // Prevent form submission
        }
        <?php }?>
    });
});
// function validateForm() {
//     // Get the form elements
//     var nameInput = document.getElementById("name");
//     var imageInput = document.getElementById("formFileDisabled");

//     // Get the values of the form elements
//     var nameValue = nameInput.value.trim();
//     var imageValue = imageInput.value.trim();

//     // Perform validation checks
//     if (nameValue === "") {
//         alert("Please enter a name.");
//         nameInput.focus();
//         return false; // Prevent form submission
//     }

//     if (imageValue === "") {
//         alert("Please select an image file.");
//         return false; // Prevent form submission
//     }

//     // Additional validation checks (e.g., file type and size) can be added here
//     var allowedExtensions = ["jpg", "jpeg", "png", "webp"];
//     var maxSizeInBytes = 500000; // 500 KB

//     // Extract the file extension from the file input
//     var fileExtension = imageValue.split(".").pop().toLowerCase();

//     // Check if the file extension is allowed
//     if (allowedExtensions.indexOf(fileExtension) === -1) {
//         alert("Invalid file type. Allowed extensions are: " + allowedExtensions.join(", "));
//         imageInput.value = ""; // Clear the file input
//         return false; // Prevent form submission
//     }

//     // Check if the file size exceeds the allowed limit
//     if (imageInput.files[0].size > maxSizeInBytes) {
//         alert("File size is too large. Maximum allowed size is " + (maxSizeInBytes / 1000) + " KB.");
//         imageInput.value = ""; // Clear the file input
//         return false; // Prevent form submission
//     }

//     // If all validation checks pass, allow form submission
//     return true;
// }
</script>









