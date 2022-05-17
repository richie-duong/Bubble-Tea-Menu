<?php
// Include menuDAO file
require_once('./dao/menuDAO.php');
 
// Define variables and initialize with empty values
$name = $price = $dateAdded = $image = "";
$name_err = $price_err = $dateAdded_err = $img_err = "";
$menuDAO = new menuDAO(); 

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address date
    $input_dateAdded = trim($_POST["dateAdded"]);
    if(empty($input_dateAdded)){
        $dateAdded_err = "Please enter a date.";     
    }else {
        $dateAdded = $input_dateAdded;
    }
    
    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price.";     
    } elseif(!ctype_digit($input_price)){
        $price_err = "Please enter a positive value.";
    } else{
        $price = $input_price;
    }
    
    //Validate images
    $imgdir = "imgs/";
    $imgFile = $imgdir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $imgFile);

    // Check input errors before inserting in database
    if(empty($name_err) && empty($dateAdded_err) && empty($price_err) && empty($img_err)){   
        $menu = new Menu($id, $name, $dateAdded, $price, $imgFile);
        $result = $menuDAO->updateMenu($menu);
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $menuDAO->getMysqli()->close();
    }

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $menu = $menuDAO->getMenu($id);
                
        if($menu){
            // Retrieve individual field value
            $name = $menu->getName();
            $dateAdded = $menu->getdateAdded();
            $price = $menu->getPrice();
        } else{
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $menuDAO->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date Added</label>
                            <textarea name="dateAdded" class="form-control <?php echo (!empty($dateAdded_err)) ? 'is-invalid' : ''; ?>"><?php echo $dateAdded; ?></textarea>
                            <span class="invalid-feedback"><?php echo $dateAdded_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Select Image:</label>
                            <input type="file" name="image" class="form-control <?php echo(!empty($img_err)) ? 'is-invalid' : ''; ?>" value= "<?php echo $image; ?>">
                            <span class="invalid-feedback"><?php echo $img_err;?></span>
                        </div>    
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>