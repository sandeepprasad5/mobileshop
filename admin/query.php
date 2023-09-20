<?php
    require_once('connection.inc.php');
    require_once('functions.inc.php');

    $GLOBALS['con'] = $con;

    //Select query
    function selectQuery($tableName){
        $query = "select * from $tableName";
        $result = mysqli_query($GLOBALS['con'],$query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    //set logo image
    function getLogoImageName(){

    $logo_query = "select * from logo where set_status = '1'";
    $logo_res = mysqli_query($GLOBALS['con'],$logo_query);
    $logo_row = mysqli_fetch_assoc($logo_res);
    return $logo_row['image'];
    }

    //activate logo_section
    function activate_logo($logo_id){

        //$logo_id = $logo_id;

        //$check_status_query = "select * from logo";
        //$check_status_result = mysqli_query($check_status_query);
        

        $logo_set_query = "update logo set set_status = '1' where id='$logo_id'";
        $logo_set_result = mysqli_query($GLOBALS['con'],$logo_set_query);

        $logo_unset_query = "update logo set set_status = '0' where id <> '$logo_id'";
        $logo_unset_result = mysqli_query($GLOBALS['con'],$logo_unset_query);
        
        return 1;
    }

    //delete by id
    function deleteById($table,$delete_id){
        $cat_delete_query = "delete from $table where id = '$delete_id'";
        $cat_delete_result = mysqli_query($GLOBALS['con'],$cat_delete_query);
        return $cat_delete_result; 
    }

    function deleteFetPro($table,$delete_id){
        $cat_delete_query = "delete from $table where product_id = '$delete_id'";
        $cat_delete_result = mysqli_query($GLOBALS['con'],$cat_delete_query);
        return $cat_delete_result; 
    }

    //insert Product Into Table
    function insertIntoProductTable($category,$product_name,$sku,$mrp,$selling_price,$qty,$short_desc,$descr,$image_name,$meta_title,$meta_descr,$meta_key,$featured){
        
        $ins_prd_query = "insert into products (categories_id,name,sku,mrp,selling_price,quantity,short_desc,description,image,meta_title,meta_desc,meta_keyword,status,featured_status) values ('$category','$product_name','$sku','$mrp','$selling_price','$qty','$short_desc','$descr','$image_name','$meta_title','$meta_descr','$meta_key','1',$featured)";
        $ins_prd_result = mysqli_query($GLOBALS['con'],$ins_prd_query);

        $lastInsertedID = mysqli_insert_id($GLOBALS['con']);
        $GLOBALS['lastInsertedID'] = $lastInsertedID;
        return $ins_prd_result;

    }

    function selectedCategory($categories_id){
        $get_cat_name_query = "select * from categories where id = '$categories_id'";
        $get_cat_name_result = mysqli_query($GLOBALS['con'],$get_cat_name_query);
        $get_cat_name_row = mysqli_fetch_assoc($get_cat_name_result);
        return $get_cat_name_row['category'];

    }
    function selectedFeatured($pro_id){
        $get_feat_name_query = "select * from featured where id = '$pro_id'";
        $get_feat_name_result = mysqli_query($GLOBALS['con'],$get_feat_name_query);
        $get_feat_name_row = mysqli_fetch_assoc($get_feat_name_result);
        return $get_feat_name_row['featured_status'];

    }
    function insertIntoFeaturedTable($featured){
        $globalLastInsertedID = $GLOBALS['lastInsertedID'];
        $ins_feat_query = "insert into featured (product_id,featured_status) values ('$globalLastInsertedID','$featured')";
        $ins_feat_result = mysqli_query($GLOBALS['con'],$ins_feat_query);
        
    }

    function updateIntoFeaturedTable($featured,$insertedID){
        $ins_feat_query = "UPDATE `featured` SET `featured_status`='$featured' WHERE `product_id`='$insertedID'";
        $ins_feat_result = mysqli_query($GLOBALS['con'],$ins_feat_query);
        echo $ins_feat_result;
    }


    function getlastFiveDaysDate(){
        $query = "SELECT DATE(order_date) AS order_date, COUNT(*) AS order_count
        FROM orders
        GROUP BY DATE(order_date)
        ORDER BY order_date ASC;";
        $result = mysqli_query($GLOBALS['con'],$query);
        return $result;
    }

    function customerName($id){
        $customerName_query = "select name from users where user_id = '$id'";
        $customerName_res = mysqli_query($GLOBALS['con'],$customerName_query);
        $customerName_row = mysqli_fetch_assoc($customerName_res);
        return $customerName_row['name'];
    }

    
?>