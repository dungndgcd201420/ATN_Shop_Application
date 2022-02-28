    else if(isset($_POST['edit2'])){
            //Display Table (With No Input Boxes)
             for ($i=0;$i<$num_field;$i++){
            $field_name = pg_field_name($table,$i);
            $field_value=$row[$field_name];
            echo "<td>".$field_value."</td>";
             //Update
            $field_update1 = pg_field_name($table,0);
            $field_update2 = pg_field_name($table,1);
            $field_update3 = pg_field_name($table,2);
            $id= $row[$field_update1];
            $shopname = $row[$field_update2];
            $productname = $row[$field_update3];
            
            $updateQuery = "UPDATE product 
            SET 
            shopname = '".$shopname."', productname = '".$productname."'
            WHERE productid = $id";

            $updateResult = pg_query($dbconn, $updateQuery);
            echo "<td><input type='submit' value='Edit' name='edit2'></td>";;
          }