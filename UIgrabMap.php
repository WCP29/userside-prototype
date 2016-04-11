<?php     
///////////////////////////////// USER UI GET CALL
        
         
  //Connect to the database
    $host = "127.0.0.1";
    $user = "grinbergjeff";                     //Your Cloud 9 username
    $pass = "";                                  //Remember, there is NO password by default!
    $db = "WCP29";                                  //Your database name you want to connect to
    $port = 3306;                                //The port #. It is always 3306
    
    $connection = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());
        
   // echo "PHP is connected.";    
    
    $building_clicked = $_GET['building_clicked'];
    $floor_clicked = $_GET['floor_clicked'];
 
        switch ($building_clicked) {
            case "University Union" :
                $building_num = 1;
                break;
            case "Glenn G. Bartle Library" :
                $building_num = 2;
                break;
            case "Engineering Building" :
                $building_num = 3;
                break;
        }
        switch ($floor_clicked) {
            case "Floor 1" :
                $floor_num = "1";
                break;
            case "Floor 2" :
                $floor_num = "2";
                break;
            case "Floor 3" :
                $floor_num = "3";
        }
        
        //$combinename = $tablename . $floorname;
        //echo "'$combinename' \n";
   
   
    $sql = "SELECT id FROM floor WHERE building_id = $building_num AND floor_level = $floor_num;";
    //echo "'$sql' \n";
    //$arrayStored = array();
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //echo "Feature: " . $row["feat_name"]. " Coordinates: " . $row["x_cord"]. ", " . $row["y_cord"]. "\n";
               // $arrayStored = array();
                //$obj = new stdClass;
                $floor_id_selected = $row["id"];
                //print_r($arrayStored);
            }
            $floor_id_selected;
        }
        
        else {
            echo "0 results";
        }
        // Get the features stored in the floor:
       $sql = "SELECT description, x, y FROM feature WHERE floor_id = $floor_id_selected;";
        $arrayStored = array();
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    //echo "Feature: " . $row["feat_name"]. " Coordinates: " . $row["x_cord"]. ", " . $row["y_cord"]. "\n";
                   // $arrayStored = array();
                    $obj = new stdClass;
                    $obj->svg_id = $row["description"];
                    $obj->xCord = $row["x"];
                    $obj->yCord = $row["y"];
                    //$arrayStored[] = $obj;
                    //$arrayStored = array($obj);
                    array_push($arrayStored, $obj);
                    //print_r($arrayStored);
                }
                //echo json_encode($arrayStored);
            }
            
            else {
                echo "0 results";
            }
            
            // Get the exits stored in the floor:
             $sql = "SELECT description, x, y FROM exits WHERE floor_id = $floor_id_selected;";
             $result = $connection->query($sql);
            if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        //echo "Feature: " . $row["feat_name"]. " Coordinates: " . $row["x_cord"]. ", " . $row["y_cord"]. "\n";
                       // $arrayStored = array();
                        $obj = new stdClass;
                        $obj->svg_id = $row["description"];
                        $obj->xCord = $row["x"];
                        $obj->yCord = $row["y"];
                        //$arrayStored[] = $obj;
                        //$arrayStored = array($obj);
                        array_push($arrayStored, $obj);
                        //print_r($arrayStored);
                    }
                    echo json_encode($arrayStored);
                }
                
                else {
                    echo "0 results";
                }
            
            
           
    $connection->close();
    
?>