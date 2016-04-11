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
        
        //Grab all the paths inside the path table that has floor_id
        
        $sql = "SELECT id, node_id, neighbor_id FROM path WHERE floor_id = $floor_id_selected;";
        $result = $connection->query($sql);
         $pathsStored = array();
         $actualPathsArray = array();
       if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $pathID = $row["id"];
                $obj = new stdClass;
                $obj->id = $pathID;
                $obj->node_id = $row["node_id"];
                $obj->neighbor_id = $row["neighbor_id"];
                array_push($pathsStored, $obj);
            }
            //echo $pathsStored;
            //echo json_encode($pathsStored);
        } else {
            echo "0 results";
        }
        // For every path we have found, grab its node_id and neighbor_id
        $tempLocationsStored = array();
        foreach ($pathsStored as $info) {
            $starter = $info->node_id;
            $ender = $info->neighbor_id;
            // Get the X and Y coordinates of the node_id and neighbor_id
            $sql = "SELECT x, y FROM location WHERE id = $starter  OR id = $ender;";
            //echo $sql;
            $result = $connection->query($sql);
           if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $obj = new stdClass;
                    $obj->xCord = $row["x"];
                    $obj->yCord = $row["y"];
                    array_push($tempLocationsStored, $obj);
                }
                //echo json_encode($tempLocationsStored);
                //$actualPathsArray = array();
                $obj = new stdClass;
                $obj->id = $pathID;
                $obj->x1Cord = $tempLocationsStored[0]->xCord;
                $obj->y1Cord = $tempLocationsStored[0]->yCord;
                $obj->x2Cord = $tempLocationsStored[1]->xCord;
                $obj->y2Cord = $tempLocationsStored[1]->yCord;
                array_push($actualPathsArray, $obj);

                //echo json_encode($actualPathsArray);
            } 
            else {
                echo "Didnt find node or neighbor";
            }
        }
       echo json_encode($tempLocationsStored);
       //echo json_encode($actualPathsArray);
           
    $connection->close();
    
?>