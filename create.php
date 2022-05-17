<?php
// Include menuDAO file
require_once('./dao/menuDAO.php');

 
// Define variables and initialize with empty values
$name = $price = $dateAdded = $image = "";
$name_err = $price_err = $dateAdded_err = $img_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a dish name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
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
      
    // Validate date
    $input_dateAdded = trim($_POST["dateAdded"]);
    if(empty($input_dateAdded)){
        $dateAdded_err = "Please enter a date.";     
    }else {
        $dateAdded = $input_dateAdded;
    }
       
  
    //Validate image
    $imgDir = "imgs/";
    $imgFile = $imgDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $imgFile);
       
    // Check input errors before inserting in database
    if(empty($name_err) && empty($dateAdded_err) && empty($price_err) && empty($img_err)){
        $menuDAO = new menuDAO();    
        $menu = new Menu(0, $name, $dateAdded, $price, $imgFile);
        $addResult = $menuDAO->addMenu($menu);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $menuDAO->getMysqli()->close();
        }
    }

?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add a new menu record to the database.</p>
					
					<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Dish Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <textarea name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>"><?php echo $price; ?></textarea>
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date Added</label>
                            <input type="date" name="dateAdded" class="form-control <?php echo (!empty($dateAdded_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dateAdded; ?>">
                            <span class="invalid-feedback"><?php echo $dateAdded_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Select Image:</label>
                            
                            <input type="file" name="image" class="form-control <?php echo(!empty($img_err)) ? 'is-invalid' : ''; ?>" value=" <?php echo $image; ?>">
                            <span class="invalid-feedback"><?php echo $img_err;?></span>
                        </div>      
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <button type="button" class="btn btn-prrimary" onclick="uploadFile()">Upload</button>
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
        <?include 'footer.php';?>
    </div>
</body>
</html>