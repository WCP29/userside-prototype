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
    /*    
    echo "building_info is: $building_clicked \n";
    echo "floor_name is: $floor_clicked \n";
    echo "starting query.";
    */
        switch ($building_clicked) {
            case "University Union" :
                $tablename = "Old_Union";
                break;
            case "Glenn G. Bartle Library" :
                $tablename = "Glenn";
                break;
            case "Engineering Building" :
                $tablename = "Engineering_Building";
                break;
        }
        switch ($floor_clicked) {
            case "Floor 1" :
                $floorname = "F1";
                break;
            case "Floor 2" :
                $floorname = "F2";
        }
        
        $combinename = $tablename . $floorname;
        //echo "'$combinename' \n";
    
    $sql = "SELECT id, height, width, y, x from $combinename where feature not like 'hallwayEnd';";
    
    //echo "'$sql' \n";
    $arrayStored = array();
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //echo "Feature: " . $row["feat_name"]. " Coordinates: " . $row["x_cord"]. ", " . $row["y_cord"]. "\n";
               // $arrayStored = array();
                $obj = new stdClass;
                $obj->svg_id = $row["id"];
                $obj->height = $row["height"];
                $obj->width = $row["width"];
                $obj->yCord = $row["y"];
                $obj->xCord = $row["x"];
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