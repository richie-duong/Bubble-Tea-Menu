<?php
// Include employeeDAO file
require_once('./dao/menuDAO.php');
$menuDAO = new menuDAO(); 

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id =  trim($_GET["id"]);
    $menu = $menuDAO->getMenu($id);
            
    if($menu){
        // Retrieve individual field value
        $name = $menu->getName();
        $dateAdded = $menu->getDateAdded();
        $price = $menu->getPrice();
        $image = $menu->getImage();
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name:</label>
                        <p><b><?php echo $name; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Date Added:</label>
                        <p><b><?php echo $dateAdded; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Price:</label>
                        <p><b><?php echo $price; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Image:</label>
                        <img src=<?php echo $image; ?> >
                     </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>