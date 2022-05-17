<?php
require_once('abstractDAO.php');
require_once('./model/menu.php');

class menuDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getMenu($menuId){
        $query = 'SELECT * FROM menu_items WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $menuId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $menu = new menu($temp['id'],$temp['name'], $temp['price'], $temp['date_added'], $temp['image']);
            $result->free();
            return $menu;
        }
        $result->free();
        return false;
    }

    public function getMenuItems(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM menu_items');
        $menuItems = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new menu object, and add it to the array.
                $menuItem = new Menu($row['id'], $row['name'], $row['price'], $row['date_added'], $row['image']);
                $menuItems[] = $menuItem;
            }
            $result->free();
            return $menuItems;
        }
        $result->free();
        return false;
    }   
    
    public function addMenu($menu){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO menu_items (name, date_added, price, image) VALUES (?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $name = $menu->getName();
			        $price = $menu->getPrice();
			        $dateAdded = $menu->getDateAdded();
                    $image = $menu->getImage();
                  
			        $stmt->bind_param('ssis', 
				        $name,
				        $price,
				        $dateAdded,
                        $image
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $menu->getName() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   
    public function updatemenu($menu){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE menu_items SET name=?, date_added=?, price=?, image=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $menu->getId();
                    $name = $menu->getName();
			        $price = $menu->getPrice();
			        $dateAdded = $menu->getDateAdded();
                    $image = $menu->getImage();
                  
			        $stmt->bind_param('ssiis', 
				        $name,
				        $price,
				        $dateAdded,
                        $image,
                        $id
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $menu->getName() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deletemenu($menuId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM menu_items WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $menuId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>

