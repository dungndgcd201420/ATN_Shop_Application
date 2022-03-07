<?php
session_start(); 
$page = $_SERVER['PHP_SELF'];
  echo "<div class ='header-container'>";
  echo "<h1>Welcome to The Database Management System!</h1>";
  echo "</div>";
 if(isset($_POST['submit_time'])) {
      $_SESSION["refresh"] = $_POST["refresh_time"];
    }
if(isset($_POST['submit_shop'])) {
      $_SESSION["selected_shop"] = $_POST["shop"];
    }
 $getrole = $_SESSION["role"];

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel='stylesheet' type='text/css' href='style.css'>
<!DOCTYPE html> 
<html>
<head>
  <meta http-equiv="refresh" content="<?php echo $_SESSION["refresh"];?> ;URL='<?php echo $page?>'">
  <title>Database</title>  
  <link rel="stylesheet" type="text/css" href="style.css">
  <?php
   if($getrole=="ADMIN"){
  ?>
  <form action='' method='post'>
    <select name = 'shop'>
      <option value ='SHOP_A'> SHOP A </option>
      <option value ='SHOP_B'> SHOP B </option>
      <option value ='ALL_SHOP' selected> ALL SHOP </option>
    </select>
    <input type = 'submit' value = 'Select Shop' name='submit_shop'>
  </form>
  <?php
}
  ?>
  <form action="" method="post">
    <select name = "refresh_time">
      <option value ="5"> 5 Seconds </option>
      <option value ="10"> 10 Seconds </option>
      <option value ="30"> 30 Seconds </option>
    </select>
     <input type = "submit" value = "Refresh" name="submit_time">
  </form>
    <label>
        <?php
            echo "Current refresh time is ".$_SESSION["refresh"]." seconds";
        ?>
    </label>
</head>
</html>
<?php
$dbconn = pg_connect("host=ec2-35-175-68-90.compute-1.amazonaws.com dbname=d1vup106c5v9qv user=ckcnruxsyyzsze password=7564fb08fadd71d9afaf47c548dd9b4c13b62237676e2196a9484d9486bffee1");
$getrole = $_SESSION["role"];

if ($getrole == "ADMIN"){
  $selected_shop = $_SESSION["selected_shop"];
  if($selected_shop == "ALL_SHOP"){
    $getProduct = "SELECT * FROM product ORDER BY product_id";
  }
  else{
    $getProduct = "SELECT * FROM product WHERE shop_name = '$selected_shop' ORDER BY product_id";
  }
}
else{
  $getProduct = "SELECT * FROM product WHERE shop_name= '$getrole' ORDER BY product_id";
}

$product = pg_query($dbconn, $getProduct);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
//ADD
   if(isset($_POST['add'])) {
        $productprice= $_POST['productprice'];
         $quantity = $_POST['productquantity'];
         $shopname = $_POST['shopname'];
         $productname = $_POST['productname'];
         $id = $_POST['productid'];
          $query = "INSERT INTO product (shop_name ,product_id,product_name,product_price,quantity) VALUES 
          ('".$shopname."','".$id."', '".$productname."', '".$productprice."','".$quantity."')";

          $result = pg_query($dbconn, $query);
          header('Location: database.php');
    //UPDATE   
    }
    
if(isset($_POST['update'])){
         
         $productprice= $_POST['productprice'];
         $quantity = $_POST['productquantity'];
         $shopname = $_POST['shopname'];
         $productname = $_POST['productname'];
         $id = $_POST['productid'];
         $updateQuery = "UPDATE product SET product_name = '".$productname."', product_price = 
         '".$productprice."', quantity= '".$quantity."' WHERE product_id = '".$id."' ";
         $update = pg_query($dbconn,$updateQuery);
         header('Location: database.php');
    }
 //DELETE

      if(isset($_POST['delete'])) {
         $id= $_POST['id'];
          $delete = "DELETE FROM product WHERE productid = $id";
          $deleteResult = pg_query($dbconn, $delete);
         header('Location: database.php');
    }
  }
   

function DisplayManagementTable($table){
$dbconn = pg_connect("host=ec2-35-175-68-90.compute-1.amazonaws.com dbname=d1vup106c5v9qv user=ckcnruxsyyzsze password=7564fb08fadd71d9afaf47c548dd9b4c13b62237676e2196a9484d9486bffee1");
$num_field = pg_num_fields($table);
$num_row=pg_num_rows($table);
$getrole = $_SESSION["role"];
//Styling Table
echo "<div class='table'>";
//TABLE START
echo "<table border='1'>\n";

//TABLE HEADER
echo "<thead class='thead-dark'>";
$i =0;
echo "<tr>";
while ($i < $num_field )
{
  $fieldName = pg_field_name($table, $i);
  echo '<th>' . $fieldName . '</th>';
  $i = $i + 1;
}
echo "</tr>";
echo " </thead>";
//TABLE CONTENT

  echo "<tr>";
    for ($j=0;$j<$num_row;$j++){
       $row=pg_fetch_array($table,$j);
       if(!isset($_POST['edit'])){
           echo "<form action='' method='post'>";
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
                case 3:
                $value4 = $update_value;
                break;
                case 4:
                $value5 = $update_value;
                break;
              }
           }
           //Display Table (With No Input Boxes)
              echo "<td><input type='text' name ='shopname' value =$value1 readonly></td>";
             echo "<td><input type='text' name='productid' value =$value2 readonly></td>";
            echo "<td><input type='text' name='productname' value=\"" . $value3 . "\"readonly></td>";
            echo "<td><input type='text' name='productprice' value =$value4 readonly></td>";
            echo "<td><input type='text' name='productquantity' value =$value5 readonly></td>";
            echo "<th><input type='submit' value='  Edit  ' name='edit'></th>";
            echo "<th><input type='submit' value='Delete' name='delete'></th>";
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
                case 3:
                $value4 = $update_value;
                break;
                case 4:
                $value5 = $update_value;
                break;
              }
           }
           //Display Table (With Input Boxes)
             echo "<td><input type='text' name ='shopname' value =$value1 readonly></td>";
            echo "<td><input type='text' name='productid' value =$value2 readonly></td>";
            echo "<td><input type='text' name='productname' value=\"" . $value3 . "\"</td>";
            echo "<td><input type='text' name='productprice' value =$value4 ></td>";
            echo "<td><input type='text' name='productquantity' value =$value5 ></td>";
            echo "<th><input type='submit' value='  Confirm  ' name='update'></th>";
            echo "<th><input type='submit' value='Delete' name='delete'></th>";
            echo "</form>";
          }
       
    echo "</tr>";      
  }

  
//TABLE END
  echo "<tr>";
          echo "<form action='' method='post'>"; 
          if($getrole == "ADMIN"){
          echo "<td><input type='text' name ='shopname' value='' readonly></td>";
          } 
          else{
            echo "<td><input type='text' name ='shopname' value=$getrole readonly></td>";
          }            
            echo "<td><input type='text' name='productname' ></td>";
            echo "<td><input type='text' name='productprice'></td>";
            echo "<td><input type='text' name='productquantity'></td>";
            echo "<td><input type='text' name='productid'></td>";
          echo "<td><input type='submit' value='Insert ' name='add'></td>";
          echo "</form>";
    echo "</tr>";      
echo "</table>";
echo "</div>";  
}
  DisplayManagementTable($product);
//Update Data Real Time + Drop Down List
   

// Closing connection
pg_close($dbconn);

?>
