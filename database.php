<?php

$dbconn = pg_connect("host=localhost dbname=dbaccount user=postgres password=12345");
 $getProduct = "SELECT * FROM product ORDER BY productid";
        $product = pg_query($dbconn, $getProduct);
 // Performing SQL query


//ADD
   if(isset($_POST['add'])) {
         $id= $_POST['id'];
         $shopname = $_POST ['shopname'];
        $productname = $_POST['productname'];
          
          $query = "INSERT INTO product (productid, shopname, productname) VALUES 
          ($id, '".$shopname."', '".$productname."')";

          $result = pg_query($dbconn, $query);
    //UPDATE   
    }
    

    //DELETE
      if(isset($_POST['delete'])) {
         $id= $_POST['id3'];
          $query4 = "DELETE FROM product WHERE productid = $id";
          $result4 = pg_query($dbconn, $query4);
         
    }


function DisplayManagementTable($table){
$dbconn = pg_connect("host=localhost dbname=dbaccount user=postgres password=12345");
$num_field = pg_num_fields($table);
$num_row=pg_num_rows($table);

//Styling Table
echo "<div class='table'>";
//TABLE START
echo "<table border='2'>\n";
//TABLE HEADER
$i =0;
echo "<tr>";
while ($i < $num_field)
{
  $fieldName = pg_field_name($table, $i);
  echo '<td>' . $fieldName . '</td>';
  $i = $i + 1;
}
echo "</tr>";
//TABLE CONTENT
  echo "<tr>";
    for ($j=0;$j<$num_row;$j++){
       $row=pg_fetch_array($table,$j);
       if(!isset($_POST['edit'])){
           echo "<form action='' method='post'>";
           //Display Table (With No Input Boxes)
            for ($i=0;$i<$num_field;$i++){
            $field_name = pg_field_name($table,$i);
            $field_value=$row[$field_name];
            echo "<td>".$field_value."</td>";
          }
          echo "<td><input type='submit' value='Edit' name='edit'></td>";
          echo "<td><input type='submit' value='Delete' name=''></td>";
          echo "</form>";

        }
                    
         if(isset($_POST['edit'])){
           for ($k=0;$k<$num_field;$k++){
              $update_field_name = pg_field_name($table,$k);
              $update_value=$row[$update_field_name];

              switch($k){
                case 0:
                $value1 = $update_value;
                break;
                 case 1:
                $value2 = $update_value;
                break;
                 case 2:
                $value3 = $update_value;
                break;
              }
           }
           //Display Table (With Input Boxes)
            echo "<form action='' method='post'>";
            echo "<td><input type='text' name ='id' value =$value1 readonly></td>";
            echo "<td><input type='text' name='shopname' value= $value2></td>";
            echo "<td><input type='text' name='productname' value =$value3></td>";
            echo "<td><input type='submit' value='Confirm' name='update' ></td>";
            echo "<td><input type='submit' value='Delete' name=''></td>";
            echo "</form>";
          }
  echo "</tr>";      
          
}
//TABLE END
 
echo "</table>";
echo "</div>";
   
  }
  DisplayManagementTable($product);

 if(isset($_POST['update'])){
         
         $id= $_POST['id'];
         $shopname = $_POST ['shopname'];
         $productname = $_POST['productname'];
         $updateQuery = "UPDATE product SET shopname = '".$shopname."', productname = '".$productname."' WHERE productid = $id";
         $update = pg_query($dbconn,$updateQuery);
         header('Location: database.php');
    }


// Closing connection
pg_close($dbconn);

?>

<!DOCTYPE html> 
<html>
<head>
  <title>Database</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
  <body>
    <div class ="form-container">
    <!-- ADD -->
    <div class ="container">
       <h1>Add</h1>
     <form action="" method = "post">
      <div class ="id">
    <div><label for="">ID</label></div>
    <div><input type="text" name="id" placeholder="id"></div>
    </div>
    <div class ="shopname">
    <div><label for="">Shop Name</label></div>
    <div><input type="text" name="shopname" placeholder="Shop Name"></div>
    </div>
    <br>
    <div class="shopname">
    <div><label for="">Product Name</label></div>
    <div><input type="text" name="productname" placeholder="Product Name"></div>
    </div>
    <input type="submit" name="add" value="Add">
  </form>
    </div>
   
    <div class ="container">
       <h1>Update</h1>
<!-- UPDATE -->
 <form action="" method = "post">
      <div class ="id">
    <div><label for="">ID</label></div>
    <div><input type="text" name="id2" placeholder="id"></div>
    </div>
    <div class ="shopname">
    <div><label for="">Shop Name</label></div>
    <div><input type="text" name="shopname2" placeholder="Shop Name"></div>
    </div>
    <br>
    <div class="shopname">
    <div><label for="">Product Name</label></div>
    <div><input type="text" name="productname2" placeholder="Product Name"></div>
    </div>
    <input type="submit" name="update" value="Update">
  </form> 
</div>

<div class ="container">
  <h1>Delete</h1>
  <form action="" method = "post">
      <div class ="id">
    <div><label for="">ID</label></div>
    <div><input type="text" name="id3" placeholder="id"></div>
    <input type="submit" name="delete" value="Delete">
  </form> 
  </div>
</div>

  </body>
</html>
