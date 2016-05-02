<?php



//CONNECTION TO DATABASE
$host = "127.0.0.1";
$user = "grinbergjeff";                     //Your Cloud 9 username
$pass = "";                                  //Remember, there is NO password by default!
$db = "WCP29";                                  //Your database name you want to connect to
$port = 3306;                                //The port #. It is always 3306
    
$con = mysqli_connect($host, $user, $pass, $db, $port)or die(mysqli_error($con));
$connection=mysqli_connect($host, $user, $pass, $db, $port)or die(mysqli_error($con));
    //// JEFF ADDD BELOW
 
$building_clicked = $_GET['building_clicked'];
$floor_clicked = $_GET['floor_clicked'];
$userClicked = $_GET['user_clicked'];
    
    
$destination_feature_id = $_GET['feature_desired'];

    
//HERE IS YOUR FLOOR ID OF FEATURE:
$feature_floor_id = $_GET['featureFloorID'];
   
 
        switch ($building_clicked) {
            case "University Union" :
                $user_building_id = 1;
                break;
            case "Glenn G. Bartle Library" :
                $user_building_id = 2;
                break;
            case "Engineering Building" :
                $user_building_id = 3;
                break;
        }
        switch ($floor_clicked) {
            case "Floor 1" :
                $user_floor_level = "1";
                break;
            case "Floor 2" :
                $user_floor_level = "2";
                break;
            case "Floor 3" :
                $user_floor_level = "3";
        }
        
    $sql = "SELECT id FROM floor WHERE building_id = $user_building_id AND floor_level = $user_floor_level;";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $user_floor_id = $row["id"];
            }
        }
        
        else {
            //echo "0 results";
        }
        
        
      // JS --> $building_clicked  ----> case statement ----> building_id stored as $user_building_id
      // JS --> $floor_clicked ----> case statement ----> floor_level stored as $user_floor_level
      // Query call looking for floor_id where building_id = $user_building_id and floor_level = $user_floor_level
      // $user_floor_id is the FLOOR_ID
      // $userClicked->x = x-coordinate of user mouse press.
      // $userClicked->y = y-coordinate of user mouse press.
      /*
      echo 'You selected building_id: ' , $user_building_id, "\n";
      echo 'You selected floor_level: ' , $user_floor_level,  "\n";
      echo 'This means you selected floor_id: ', $user_floor_id, "\n";
      //echo 'The user click was: ', "\n";
      echo 'X-Cord: ' , $userClicked['x'], "\n";
      echo 'Y-Cord: ' , $userClicked['y'], "\n";
      
      echo "Feature_ID is: " ,$destination_feature_id, "\n";
    
    //HERE IS YOUR FLOOR ID OF FEATURE:
    
     echo "floor_id of selected Feature: " ,$feature_floor_id, "\n";
 
    */  
      
    
    
//SIMPLE DISTANCE formula

function distance_formula($x1,$y1,$x2,$y2)
{
        $distance = sqrt(pow(($y2-$y1),2) + pow(($x2-$x1),2)); 
        return $distance;
}

function vectorize($x1,$y1,$x2,$y2)
{
    $vector_x = $x2-$x1;
    $vector_y=$y2-$y1;
    //echo "Value of vector_x is: ", $vector_x, "\n";
    //echo "Value of vector_y is: ", $vector_y, "\n";
    
    $magnitude = distance_formula($x1,$y1,$x2,$y2);
    //echo "Value of magnitude is:", $magnitude, "\n";
    $normalized_x1=$vector_x/$magnitude;
    $normalized_y1=$vector_y/$magnitude;
  
  
    //echo "Normalized values are: ", $normalized_x1, " ",$normalized_y1,  "\n";
    return array($normalized_x1,$normalized_y1);
}    


function pointOnPath($x3,$y3,$x1,$y1,$x2,$y2) 
{

   $A =  $x3 -  $x1;
   $B =  $y3 - $y1;
   $C =  $x2 -  $x1;
   $D =  $y2 -  $y1;

   $dot =  $A * $C +  $B *  $D;
   $len_sq =  $C *  $C +  $D *  $D;
   $param = -1;
  if ( $len_sq != 0) //in case of 0 length line
  {
       $param =  $dot /  $len_sq;
  }
   $xx=0;
    $yy=0;

  if ( $param < 0) {
     $xx =  $x1;
     $yy =  $y1;
  }
  else if ( $param > 1) {
     $xx =  $x2;
     $yy =  $y2;
  }
  else {
     $xx =  $x1 +  $param *  $C;
     $yy =  $y1 +  $param *  $D;
  }

   $dx = $x3 -  $xx;
   $dy =  $y3 -  $yy;
  $perp=sqrt( $dx *  $dx +   $dy *  $dy);
  //echo "The perpendicular distance is: ", $perp, "\n"; 
  
  return array($xx,$yy);
}



function dotProduct($x1,$y1,$x2,$y2)
{
 
    $dot = ($x1*$x2)+($y1*$y2);
    $magnitude_one = abs(sqrt(($x1*$x1)+($y1*$y1)));
    $magnitude_two= abs(sqrt(($x2*$x2)+($y2*$y2)));
    //$angle = rad2deg(acos($dot/($magnitude_one*$magnitude_two)));
    $dot_angle = acos($dot/($magnitude_one*$magnitude_two));
    $dot_product = $magnitude_one*$magnitude_two*cos($dot_angle);
    
    //echo "Are these two the same value? ", $dot , "  ", $dot_product, "\n";
    //$magnitude_three = sqrt(($x3*$x3)+($y3*$y3));
    //$magnitude_four=sqrt(($x4*$x4)+($y4*$y4));
   
    //echo "The dot product is: ", $dot , "\n";
    //echo "Angle between these two vectors in degrees is: ", rad2deg($dot_angle), "\n";
 
  
    return array($dot_product,$dot_angle);
        
    
}

function crossProduct($x1,$y1,$x2,$y2)
{
    
    
    $magnitude_one = sqrt(($x1*$x1)+($y1*$y1));
    $magnitude_two=sqrt(($x2*$x2)+($y2*$y2));
    $cross = ($x1*$y2) - ($y1*$x2);
    $abs_cross = abs(($x1*$y2) - ($y1*$x2));
    $cross_test = ($x1*$y2)+($x2*$y1);
    
    $angle=asin($cross/($magnitude_one*$magnitude_two));
    $angle_in_degrees=rad2deg(asin(($abs_cross)/($magnitude_one*$magnitude_two))); //added in abs
    //echo "\n","A X B value is: ", $cross, "\n";
    //echo "absolute value is: ", $abs_cross, "\n";
    //echo "cross product found on website: ", $cross_test, "\n";
    //echo "The cross product angle in radians is", $angle, "\n";
    //echo "The cross product angle in degrees is: ", $angle_in_degrees , "\n";
    //echo "\n";
    //echo "cross product is: ", $cross, "\n";
   
    return array($cross,$angle_in_degrees);
    
}



function instructions($dot_product,$dot_angle,$cross,$cross_angle)
{
    
    if ($cross >= 0 and $dot_product > 0)
    {
        if ($cross_angle >= 0 and $cross_angle < 15) // if first instruction... walk towards this node (maybe some feature along it ) and then make the next available right
        {
            $instruction = "Walk towards the right";
            echo "Walk towards the right", "\n" ;        
        }
        else if ($cross_angle >= 15 and $cross_angle < 40)
        {
            
            $instruction = "Turn slight right";
            echo "Turn slight right", "\n";
        }
        else if ($cross_angle >= 40 and $cross_angle < 75)
        {
            $instruction = "Make a sharp right";
            echo "Make a sharp right", "\n";
        
        }
        else if ($cross_angle >= 75 and $cross_angle <= 90)
        {
            $instruction = "Make a right turn";
            echo "Make a right turn", "\n";
        }
    //else($angle == 90)
    }

    else
    {
    //if first instruction.. walk up? or walk towards something in that location?
    
        if ($cross_angle >= 0 and $cross_angle < 15) // if first instruction... walk towards this node (maybe some feature along it ) and then make the next available right
        {
            $instruction = "Walk towards the left";
            echo "Walk towards the left", "\n" ;        
        }
        else if ($cross_angle >= 15 and $cross_angle < 40)
        {
            $instruction = "Turn slight left";
            echo "Turn slight left", "\n";
            
        }
        else if ($cross_angle >= 40 and $cross_angle < 75)
        {   
            $instruction = "Make a sharp left";
            echo "Make a sharp left", "\n";
        }
        else if ($cross_angle >= 75 and $cross_angle <= 90)
        {
            $instruction = "Make a left turn";
            echo "Make a left turn", "\n";
        }
        //else($angle == 90)
        
      
    }
return ($instruction);

}



function get_all_path_coorindates($path,$con)
{
        $exit_array=array();
        
        
        foreach($path as  $key => $element )
        {
          
            
          
            if(mysqli_query($con,"select floor_id,x,y from location where id = $element") -> num_rows >0)
            {
                $query =mysqli_query($con,"select floor_id,x,y from location where id = $element");
                $result=mysqli_fetch_assoc($query);
            
                    $obj = new stdClass;
                    $obj->floor_id = $result['floor_id'];
                    $obj->x = $result['x'];
                    $obj->y = $result['y'];
                    $exit_array[] = $obj;
               
                   
              //  $exit_array[] = $result;
               // $exit_array[$key][] = $result['y'];
                
                //echo "The x that just got stored was: ", $instruction_array, "\n";
            }
            
            else if (mysqli_query($con, "select floor_id,x,y from exits where id = $element") -> num_rows >0)
            {
                $query = mysqli_query($con, "select floor_id,x,y from exits where id = $element");
                $result=mysqli_fetch_assoc($query);
                $obj = new stdClass;
                $obj->floor_id = $result['floor_id'];
                $obj->x = $result['x'];
                $obj->y = $result['y'];
                $exit_array[] = $obj;
                /*
                $exit_array[$key][] = $result['x'];
                $exit_array[$key][] = $result['y'];
                */
                
            }
            
            else if (mysqli_query($con, "select floor_id,x,y from feature where id = $element") -> num_rows > 0)
            {
                $query = mysqli_query($con, "select floor_id,x,y from feature where id = $element");
                $result=mysqli_fetch_assoc($query);
                /*
                $exit_array[$key][] = $result['x'];
                $exit_array[$key][] = $result['y'];
                */
                $obj = new stdClass;
                $obj->floor_id= $result['floor_id'];
                $obj->x = $result['x'];
                $obj->y = $result['y'];
                $exit_array[] = $obj;
            }
            
            else if (mysqli_query($con, "select x,y from building_exit where id = $element") -> num_rows > 0)
            {
               //echo "AM I EVER IN HERE? ", "\n";
                $query=mysqli_query($con, "select x,y from building_exit where id = $element");
                $result=mysqli_fetch_assoc($query);
                //echo "Value of x result is ",$result['x'], "\n";
                //echo "Value of y result is ",$result['y'], "\n";
                $obj = new stdClass;
                $obj->floor_id = NULL;
                $obj->x = $result['x'];
                $obj->y = $result['y'];
                $exit_array[] = $obj;
                /*
                $exit_array[$key][] = $result['x'];
                $exit_array[$key][] = $result['y'];
                */
            
            }
        }
        //print_r($exit_array);
        return ($exit_array);
       
}
function path_instruction($path,$con)
{
        $instruction_array=array();
        $one_path_instruction=array();
        $node_array=array();
        $i=0;
        foreach($path as  $key => $element )
        {
          
            static $j = 0;
            
            $query =mysqli_query($con,"select x,y from location where id = $element");
            if($query -> num_rows > 0)
            {
                $result=mysqli_fetch_assoc($query);
            
                
                $instruction_array[$key]['x'] = $result['x'];
                $instruction_array[$key]['y'] = $result['y'];
                //echo "The x that just got stored was: ", $instruction_array, "\n";
            }
            
            else if (mysqli_query($con, "select x,y from exits where id = $element") -> num_rows >0)
            {
                $query = mysqli_query($con, "select x,y from exits where id = $element");
                $result=mysqli_fetch_assoc($query);
                $instruction_array[$key]['x'] = $result['x'];
                $instruction_array[$key]['y'] = $result['y'];
                
            }
            
            else if (mysqli_query($con, "select x,y from feature where id = $element") -> num_rows > 0)
            {
                $query = mysqli_query($con, "select x,y from feature where id = $element");
                $result=mysqli_fetch_assoc($query);
                $instruction_array[$key]['x'] = $result['x'];
                $instruction_array[$key]['y'] = $result['y'];
            
            }
            
            else if (mysqli_query($con, "select x,y from building_exit where id = $element") -> num_rows > 0)
            {
                $query=mysqli_query($con, "select x,y from building_exit where id = $element");
                $result=mysqli_fetch_assoc($query);
                $instruction_array[$key]['x'] = $result['x'];
                $instruction_array[$key]['y'] = $result['y'];
            
            }
            
             else if (mysqli_query($con, "select x,y from feature_point_on_path where id = $element") -> num_rows > 0)
            {
                $query=mysqli_query($con, "select x,y from feature_point_on_path where id = $element");
                $result=mysqli_fetch_assoc($query);
                $instruction_array[$key]['x'] = $result['x'];
                $instruction_array[$key]['y'] = $result['y'];
            
            }
            
             else if (mysqli_query($con, "select x,y from exit_point_on_path where id = $element") -> num_rows > 0)
            {
                $query=mysqli_query($con, "select x,y from exit_point_on_path where id = $element");
                $result=mysqli_fetch_assoc($query);
                $instruction_array[$key]['x'] = $result['x'];
                $instruction_array[$key]['y'] = $result['y'];
            
            }
            else
            {
                
            }
           
                        
            if ($key > 0)
            {
            
            //echo "Value of key is: ", $key , "\n";
            //echo "ID of the two nodes that I put into the vector: ", $path[$key-1], " ", $path[$key], "\n";
            //echo "Values that I'm putting into vectorize function: ", $instruction_array[$key-1]['x'], " ", $instruction_array[$key-1]['y'], " ",$instruction_array[$key]['x'], " ",$instruction_array[$key]['y'], "\n ";
            
            $test=vectorize($instruction_array[$key-1]['x'],$instruction_array[$key-1]['y'],$instruction_array[$key]['x'],$instruction_array[$key]['y']);  //194-195
            $node_array[$key-1]['x']=$test[0];
            $node_array[$key-1]['y']=$test[1];
            $count++;
           
            }
            if ($count > 1) // need at least two $test to perform dot and cross
            {
                static $counter=0;
                $dot_product = dotProduct($node_array[$key-2]['x'],$node_array[$key-2]['y'],$node_array[$key-1]['x'],$node_array[$key-1]['y']);
                $cross_product= crossProduct($node_array[$key-2]['x'],$node_array[$key-2]['y'],$node_array[$key-1]['x'],$node_array[$key-1]['y']);
                $one_path_instruction[$i]=instructions($dot_product[0],$dot_product[1],$cross_product[0],$cross_product[1]);
                $i++;
            }
            
        }
        
        
return $one_path_instruction;

}



    
// finds the closest node to a given x and y which I will use for my exit 
   
function closest_node($x_coordinate,$y_coordinate,$floor_id,$con)
{
      
    
    $shortest_distance = 0;  
  
    $query = "SELECT id,x,y from location WHERE floor_id = $floor_id";
    $result = mysqli_query($con,$query) or  die(mysqli_error($con));
    while ($row1 = mysqli_fetch_assoc($result))
    {
            $x = $row1['x'];
            $y = $row1['y'];
    
            //echo "x is: " . $x;
            //echo "y is:" . $y;
          
            $location_id = $row1['id'];
            $distance = distance_formula($x_coordinate,$y_coordinate,$x,$y);
            //echo "distance is: $distance"; //works 
            //$new_id = $row1['id']; //why did i put this here to solve the bug where if you clickt oo left theres an error?
        
            if ($shortest_distance == 0)
            {
                $shortest_distance = $distance;
                $new_id = $row1['id']; //changed recently
            }
        
            else if($shortest_distance > $distance)
            {
        
                $shortest_distance = $distance;
                //echo "sfafafsaafafafagagadbabababaabaID is: ", $location_id, "\n";
                $new_id = $row1['id'];
                
            
            }
        
            //echo "shortest distance is  " . $shortest_distance;
            //echo "id of node closest is: " . $new_id;
    }
    
    
   return array($new_id,$shortest_distance);     
        
        
}
  
    
    
//FIND THE POINT ON THE LINE where the FEATURE is supposed to be (perpendicular distance)    
function pointOnLine($x1,$y1,$x2,$y2,$x3,$y3)
{
       $a = $y1-$y2;
       $b=$x2-$x1;
       $c=($x1-$x2)*$y1 + ($y2-$y1)*$x1;
       
      
       $x = ($b*($b*$x3-$a*$y3) - ($a*$c)) / (pow($a,2)+pow($b,2));
       $y = ($a*(-$b*$x3+$a*$y3) - ($b*$c)) / (pow($a,2)+pow($b,2)); 
       
       //echo "This is the x coordinate: $x";
       //echo "This is the y coordinate: $y";
       
       return array($x,$y);
       
       
}
     //$pointOnLine = pointOnLine(46,112.5,107,112.5,110,135.5);
     //echo $pointOnLine[0];    -- x VALUE
     //echo $pointOnLine[1];    -- y VALUE
    

    
function queryAllPathsOnFloor($floor_id,$con)
{
    $i=0;
    $path_array=array();
    $query = mysqli_query($con, "select * from path where floor_id = $floor_id");
    while ($result=mysqli_fetch_assoc($query))
    {
        $a=$result['node_id'];       
        $b=$result['neighbor_id'];   
        $distance=$result['distance'];
        $path_array[$i]=array($a,$b,$distance);
        $i++;
    }
    
    return $path_array;
}

function queryAllPathsOnFloor1($x,$y,$floor_id,$path_id,$con)
{
    $i=0;
    $coordinate_array=array();
    $path_array=array();
    $query = mysqli_query($con, "select * from path where floor_id = $floor_id");
    while ($result=mysqli_fetch_assoc($query))
    {
        if($path_id == $result['id'])
        {
            $node_id = $result['node_id'];
            $neighbor_id=$result['neighbor_id'];   
        }
        $a=$result['node_id'];       
        $b=$result['neighbor_id'];   
        $distance=$result['distance'];
        $path_array[$i]=array($a,$b,$distance);
        $i++;
    }
    
    $query=mysqli_query($con,"select x,y from location where id = $node_id or id=$neighbor_id");
    while($result=mysqli_fetch_assoc($query))
    {
        $coordinate_array[]=$result;    
    }
    
    $node_x=$coordinate_array[0]['x'];
    $node_y=$coordinate_array[0]['y'];
    $neighbor_x=$coordinate_array[1]['x'];
    $neighbor_y=$coordinate_array[1]['y'];
    $perp=pointOnPath($x,$y,$node_x,$node_y,$neighbor_x,$neighbor_y);
    $dist=distance_formula($perp[0],$perp[1],$node_x,$node_y);
    $dist1=distance_formula($perp[0],$perp[1],$neighbor_x,$neighbor_y);
    if($dist < $dist1)
    {
        return array($path_array,$perp[0],$perp[1],$node_id,$dist);
    }
    else
    {
        return array($path_array,$perp[0],$perp[1],$neighbor_id,$dist1);
    }
   
}    
    
//DIJKSTRA'S ALGORITHM     
    
function dijkstra($graph_array, $source, $target) 
{
   
    $vertices = array();
    $neighbours = array();
    foreach ($graph_array as $edge) 
    {
        array_push($vertices, $edge[0], $edge[1]);
        $neighbours[$edge[0]][] = array("end" => $edge[1], "cost" => $edge[2]);
        $neighbours[$edge[1]][] = array("end" => $edge[0], "cost" => $edge[2]);
    }
    
    $vertices = array_unique($vertices);
 
    foreach ($vertices as $vertex) 
    {
        $dist[$vertex] = INF;
        $previous[$vertex] = NULL;
    }
 
    $dist[$source] = 0;
    $Q = $vertices;
    while (count($Q) > 0) 
    {
 
        // TODO - Find faster way to get minimum
        $min = INF;
        foreach ($Q as $vertex)
        {
            if ($dist[$vertex] < $min) 
            {
                $min = $dist[$vertex];
                $u = $vertex;
            }
        }
 
        $Q = array_diff($Q, array($u));
        if ($dist[$u] == INF or $u == $target) 
        {
            break;
        }
 
        if (isset($neighbours[$u])) 
        {
            foreach ($neighbours[$u] as $arr) 
            {
                $alt = $dist[$u] + $arr["cost"];
                if ($alt < $dist[$arr["end"]]) 
                {
                    $dist[$arr["end"]] = $alt;
                    $previous[$arr["end"]] = $u;
                }
            }
        }
    }
    //echo "The total distance traveled HOPEFULLY is ", $alt, "\n";
    $path = array();
    $u = $target;
    while (isset($previous[$u])) 
    {
        array_unshift($path, $u);
        $u = $previous[$u];
    }
    array_unshift($path, $u);
   
    //echo "Amount of times algorithm has been run: ", $i, "\n";
    return $path;
}


//Function returns the closest exit to the point that a person clicked to the nearest door or staircase/elevator
   
function closest_exit($floor_id,$destination_floor_id,$user_or_exit_x,$user_or_exit_y,$con) //$dest is the same as feature floor id,  $floor_id is whatever floor you want the paths from 
{
    
    
    //puts the connect id and id of all the exits on the floor requested into an array  
    $counter=0;
    $exit_array=array();
    $exit_array_connect_id=array();
    $exit_array_id=array();
    $exit_array_x=array();
    $exit_array_y=array();
    $exit_array_floor_id=array();
    $all_exits_value = mysqli_query($con,"select * from exits where floor_id = $floor_id") or  die("This gave me the error4: " . mysqli_error($con)); //$user_floor_id"); //queries all exits on the floor
    while ($all_exits_result = mysqli_fetch_assoc($all_exits_value)){
            $exit_array[] = $all_exits_result;
            $exit_array_connect_id[$counter] = $all_exits_result['connect_id'];  
            $exit_array_id[$counter] = $all_exits_result['id'];           //PUSHED CONNECT ID INTO AN ARRAY
            $exit_array_x[$counter]=$all_exits_result['x'];
            $exit_array_y[$counter]=$all_exits_result['y'];
            $exit_array_floor_id= $all_exits_result['floor_id'];
            //echo "Connect ID is: ", $exit_array_connect_id[$counter] , "\n";
            //echo "EXIT ID is: ", $exit_array_id[$counter] , "\n";
            //echo "The description is: ", $exit_rray_;
            $counter++;
    }
    //print_r($exits_array);
    
    
    //Testing which exit is the closest 
   
    $exit_counter=0;
    $old_exit_distance=100000;
    foreach($exit_array_connect_id as $key => $exit_connect_id){
            if ($floor_id != $destination_floor_id)
        
            {
            $exit_connection_query= mysqli_query($con, "SELECT * FROM exits WHERE connect_id = $exit_connect_id  AND  description = 'door' ") or  die("This gave me the error6: " . mysqli_error($con));
            $result = mysqli_fetch_assoc($exit_connection_query);
            
            }
            
            else{
          
            $exit_connection_query= mysqli_query($con, "SELECT * FROM exits WHERE connect_id = $exit_connect_id  AND floor_id=$destination_floor_id"); 
            }
            
          
          
          
            if ($exit_connection_query->num_rows > 0){  //there are connections then you want to store the distance to the exit with this connection into array 
                $another_query= mysqli_query($con, "SELECT * FROM exits WHERE id= $exit_array_id[$key]")or  die("This gave me the error7: " . mysqli_error($con));
              
                //echo "EXIT ID is: ", $exit_array_id[$key] , "\n";
                //echo "Description is: ", $exit_array
                $exit_connection_result = mysqli_fetch_assoc($another_query);
                $new_exit_distance = distance_formula($user_or_exit_x,$user_or_exit_y,$exit_connection_result['x'],$exit_connection_result['y']);
                //echo "The ID of this exit is ", $exit_array_id[$key], "and the distance from the user click to this exit is: ",$new_exit_distance, "\n";     
                //echo "This is the old exit distance: ", $old_exit_distance, "\n";
                if ($new_exit_distance < $old_exit_distance and $new_exit_distance != 0){
                        $old_exit_distance = $new_exit_distance;
                        $new_path_id= $exit_connection_result['path_id'];
                        $closest_exit_id=$exit_connection_result['id'];
                        $new_x=$exit_connection_result['x'];
                        $new_y=$exit_connection_result['y'];
                        $new_connect_id = $exit_connection_result['connect_id'];
                        $new_floor_id = $result['floor_id'];
                        
                }
            }
           
            $exit_counter++;
            
    }   
    /*
            echo "The user is being guided to this exit on their floor, its path_id is: ", $new_path_id, "\n";
            echo "ID is: ", $closest_exit_id, "\n";
            echo "X is: ", $new_x, "\n";
            echo "Y is: ", $new_y, "\n";
            echo "The distance is: ", $old_exit_distance, "\n";
            echo "The new floor id is: ", $new_floor_id , "\n";
            
       */  
            
            return array($new_path_id,$closest_exit_id,$new_x,$new_y,$new_connect_id,$new_floor_id);
}      



$query = mysqli_query($con, "SELECT name FROM building WHERE id = $user_building_id");
$result= mysqli_fetch_assoc($query);
echo "User is on floor ",$user_floor_level, " of the ", $result['name'], "\n";



//echo "Now being routed to a ", $feature_result['description'], " on ", $feature_floor_id, " of ", $feature_building_name, "\n";

//First step: Get closest node to point clicked and insert the node-point-clicked relationship into the dijikstra's array 
$node_closest_to_point_clicked=closest_node($userClicked['x'],$userClicked['y'],$user_floor_id,$con);  
//echo "The closest node to the point where the user clicked is: ", $node_closest_to_point_clicked[0], " and the distance is: ", $node_closest_to_point_clicked[1], "\n";


//Second step: Determine if it is going to be floor-floor or building - building 



//finds the building id of the destination feature 

$feature_building_id_query=mysqli_query($con,"SELECT building_id FROM floor where id = $feature_floor_id")or  die("This gave me the error");
$feature_building_id_result=mysqli_fetch_assoc($feature_building_id_query);
$feature_building_id=$feature_building_id_result['building_id'];
//echo "Feature building id is: ", $feature_building_id, "\n"; //works 
$query=mysqli_query($con,"select name from building where id = $feature_building_id");
$result = mysqli_fetch_assoc($query);
$feature_building_name=$result['name'];

//$feature_selected_query = mysqli_query($con,"SELECT * FROM feature WHERE id = $destination_feature_id") or  die("This gave me the error5: " . mysqli_error($con));;
//$feature_result = mysqli_fetch_assoc($feature_selected_query);
//echo "Now being routed to a ", $feature_result['description'], " on ", $feature_floor_id, " of ", $feature_building_name, "\n";





//$i=0;
$array = array();
//$array[$i] = array($destination_feature_id,$node_closest_to_point_clicked[0],$node_closest_to_point_clicked[1]);
//$i++;
//$current_floor_array is either $array or $$next_building_array
//which_floor_id is either floor the user is currently on (floor_id_selected) or the floor of the next building ($starting_exit_point_floor_id)
// $user_or_exit_x is userClicked['x'] or $starting_exit_point_x
// $whichbuilding is either $user_building_id or  $ending_building_building_id
//$starting_point is either the ID of the exit you came in from or $node_closest_to_point_clicked[0]
function where_are_you_coming_from(&$starting_point,&$which_building,&$user_or_exit_x,&$user_or_exit_y,&$which_floor_id,&$current_floor_array,$con)
{

global $destination_feature_id;
global $floor_clicked;
global $feature_floor_id;
global $feature_building_name;
global $i;
global $user_building_id;

//echo "Value of destination feature id is: ", $destination_feature_id , "\n";

    //QUERY TO GET ALL THE PATHS INTO AN ARRAY
//print_r($current_floor_array);

   
    
   
    //echo "number of rows: " . $unknown->num_rows;
$someArray = array();
    
    
    //query for selected feature
    //echo "Feature_desired value is: ", $destination_feature_id, "\n";
    $feature_selected_query = mysqli_query($con,"SELECT * FROM feature WHERE id = $destination_feature_id") or  die("This gave me the error5: " . mysqli_error($con));;
    $feature_result = mysqli_fetch_assoc($feature_selected_query);
    $crap=$feature_result['id'];
    
    //echo "Now being routed to a ", $feature_result['description'], " on ", $feature_floor_id, " of ", $feature_building_name, "\n";
    
    //echo "Value of destination feature id is: ", $crap , "\n";
    
    //echo "Destination path_id is: " , $feature_result['path_id'], " and its floor_id is: ", $feature_result['floor_id'], " and its coordinates are: ", $feature_result['x'], " ", $feature_result['y'], "\n";

    //PUSH FEATURE AND CLOSEST NODE CONNECTION INTO ARRAY 
   
    
    
    //Finding Closest exit to the starting point 
    

    if ($which_floor_id != $feature_floor_id) //NEED THIS TO MAKE SURE THAT same building -> same building works, disables finding exits if the feature is on the floor they're currently on 
    { 
    //Putting all ID's and Connect IDs of the exits into an array on the source floor 
        $counter=0;
        $exit_array_connect_id=array();
        $exit_array_id=array();
        $all_exits_value = mysqli_query($con,"select id,x,y,path_id,connect_id from exits where floor_id = $which_floor_id") or  die("This gave me the error4: " . mysqli_error($con)); //$user_floor_id"); //queries all exits on the floor
        while ($all_exits_result = mysqli_fetch_assoc($all_exits_value)){
                $exit_array_connect_id[$counter] = $all_exits_result['connect_id'];  
                $exit_array_id[$counter] = $all_exits_result['id'];           
                /*
                echo "Connect ID is: ", $exit_array_connect_id[$counter] , "\n";
                echo "EXIT ID is: ", $exit_array_id[$counter] , "\n";
                echo "The description is: ", $all_exits_result['description'];
                */
                $counter++;
        }
    
    
    
    //Testing which exit is the closest 
   
        $exit_counter=0;
        $old_exit_distance=1000;
        foreach($exit_array_connect_id as $key => $exit_connect_id){
                $exit_connection_query= mysqli_query($con, "SELECT * FROM exits WHERE connect_id = $exit_connect_id  AND floor_id=$feature_floor_id") or  die("This gave me the error6: " . mysqli_error($con));//$feature_floor_id");
                if ($exit_connection_query->num_rows > 0){  //there are connections then you want to store the distance to the exit with this connection into array 
                    $another_query= mysqli_query($con, "SELECT * FROM exits WHERE id= $exit_array_id[$key]")or  die("This gave me the error7: " . mysqli_error($con));
                    //echo "EXIT ID is: ", $exit_array_id[$key] , "\n";
                    $exit_connection_result = mysqli_fetch_assoc($another_query);
                    $new_exit_distance = distance_formula($user_or_exit_x,$user_or_exit_y,$exit_connection_result['x'],$exit_connection_result['y']);
                    //echo "This is the old exit distance: ", $old_exit_distance, "\n";
                    //echo "The ID of this exit is ", $exit_array_id[$key], " and the distance from the user click to this exit is: ",$new_exit_distance, "\n";     
                  
                    if ($new_exit_distance < $old_exit_distance and $new_exit_distance != 0 and $exit_connection_result['description'] != 'door'){
                            //echo "The description of the exit is: " , $exit_connection_result['description'] , "\n";
                            $old_exit_distance = $new_exit_distance;
                            $new_path_id= $exit_connection_result['path_id'];
                            $closest_exit_id=$exit_connection_result['id'];
                            $new_x=$exit_connection_result['x'];
                            $new_y=$exit_connection_result['y'];
                            $new_connect_id=$exit_connection_result['connect_id'];
                        
                        
                    }
                }
            
        $exit_counter++;
            
        }
        
    //echo "The user is being guided to this exit on their floor, its path_id is: ", $new_path_id, "\n";
    //echo "ID is: ", $closest_exit_id, "\n";
    //echo "X is: ", $new_x, "\n";
    //echo "Y is: ", $new_y, "\n";
    //echo "The distance is: ", $old_exit_distance, "\n";
    
            //echo "$feat"
            
            

    }
    $unknown = mysqli_query($con, "SELECT id FROM floor WHERE floor.building_id = $which_building")or  die("This gave me the error: " . mysqli_error($con));
   
    
    //store values into an array because you can't fetch within a fetch
    while ($rows = mysqli_fetch_assoc($unknown)){
            array_push($someArray, $rows['id'] );
    }
    
    
    //Populate the table with all the paths in the building
            foreach($someArray as $element){
                //echo "Array value is: " . $element . "\n";
                
                $populate_array_query= mysqli_query($con, "SELECT * FROM path WHERE floor_id = $element")or  die("This gave me the error1: " .mysqli_error($con));
                while($populate_result=mysqli_fetch_assoc($populate_array_query)){
                    $perpendicular_array=array();  
                    $a=$populate_result['node_id'];
                    $b=$populate_result['neighbor_id'];
                    $distance=$populate_result['distance'];
                    $path_id=$populate_result['id'];
                    //echo " Count is: " , $i , "\n";
                    //echo "path_id is " . $path_id . "\n";
                   
                    //echo "value of a is: " , $populate_result['id'] , "\n";
                    
                    //Insert the exit/location relationship of the node and the exit
                    //Need to insert the relationship of location and point of EXIT ON THE LOCATION PATH
                    if ($path_id == $new_path_id)
                    {
                        $last_exit_instruction=array();
                       
                        
                        
                        //echo "path_id is " , $path_id , " and exit_value path id is ", $new_path_id , "\n";
                       
                 
                       //echo "am i ever in here?";
                    
                      
                        
                        $query=mysqli_query($con,"SELECT x,y FROM location WHERE id = $a OR id =$b"); 
                        
                        
                        
                        while($location_value = mysqli_fetch_assoc($query))
                        {
                            $perpendicular_array[] = $location_value;
                        }    
                        
                        //echo "This should be the value of the first node: ", $perpendicular_array[0]['x'], "  ", $perpendicular_array[0]['y'], "\n";
                        //echo "This should be the value of the second node: ", $perpendicular_array[1]['x'], "  ", $perpendicular_array[1]['y'], "\n";
                        $exit_point_on_path = pointOnPath($new_x,$new_y,$perpendicular_array[0]['x'],$perpendicular_array[0]['y'],$perpendicular_array[1]['x'],$perpendicular_array[1]['y']);
                        
                        $insert_exit_query= "INSERT IGNORE INTO exit_point_on_path VALUES(NULL,$exit_point_on_path[0],$exit_point_on_path[1],$closest_exit_id)";
                        if(mysqli_query($con,$insert_exit_query) == TRUE)
                        {
                            //echo "New exit record successfully created", "\n";
                        }
                        
                        $exit_point_on_path_id=mysqli_query($con,"select id from exit_point_on_path where exit_id=$closest_exit_id");
                        $perp_exit_id=mysqli_fetch_assoc($exit_point_on_path_id);
                        //echo "Value of fake exit is: ", $perp_exit_id['id'], "\n";
                       
                    
                       
                        
                        //Inserts the relationship fo the node_id and the point on the path that the exit is on
                        
                        $current_floor_array[$i] = array($a,$perp_exit_id['id'],distance_formula($perpendicular_array[0]['x'], $perpendicular_array[0]['y'],$exit_point_on_path[0],$exit_point_on_path[1]));
                        $i++;
                        $current_floor_array[$i] = array($b,$perp_exit_id['id'],distance_formula($perpendicular_array[1]['x'], $perpendicular_array[1]['y'],$exit_point_on_path[0],$exit_point_on_path[1]));
                        $i++;
                        // Inserts the relationship of the exit and its point on the path
                        array_push($last_exit_instruction,$closest_exit_id,$perp_exit_id['id']);
                       
                        //print_r($last_instruction);
                      
                        
                      
                        
                       
                        //$current_floor_array[$i] = array($a,$closest_exit_id,distance_formula($new_x,$new_y,$location_value['x'],$location_value['y']));
                        //$i+=1;
             
                    }
                    
                    // IMPLEMENT IF WE CAN SAVE THE VALUES OF BOTH CLICKS 
                    else if($path_id == $feature_result['path_id']){
                        $last_feature_instruction=array();
                        $perpendicular_array=array();
                        //echo "path_id is " . $path_id . "\n";
                        //echo "feature path id is " . $feature_result['path_id'] . "\n";
                        
                        $query=mysqli_query($con,"SELECT x,y FROM location WHERE id = $a OR id =$b"); 
                        
                        while($location_value = mysqli_fetch_assoc($query))
                        {
                            $perpendicular_array[] = $location_value;
                        }    
                        
                        //echo "This should be the value of the first node: ", $perpendicular_array[0]['x'], "  ", $perpendicular_array[0]['y'], "\n";
                        //echo "This should be the value of the second node: ", $perpendicular_array[1]['x'], "  ", $perpendicular_array[1]['y'], "\n";
                        
                        $feature_point_on_path = pointOnPath($feature_result['x'],$feature_result['y'],$perpendicular_array[0]['x'],$perpendicular_array[0]['y'],$perpendicular_array[1]['x'],$perpendicular_array[1]['y']);
                        
                        $insert_feature_query= "INSERT IGNORE INTO feature_point_on_path VALUES(NULL,$feature_point_on_path[0],$feature_point_on_path[1],$destination_feature_id)";
                      
                        if(mysqli_query($con,$insert_feature_query) == TRUE)
                        {
                            //echo "New feature record successfully created", "\n";
                        }
                        
                        //echo "Value of destination feature id is: ", $crap , "\n";
                        $feature_point_on_path_id=mysqli_query($con,"select id from feature_point_on_path where feature_id=$destination_feature_id");
                        $perp_feature_id=mysqli_fetch_assoc($feature_point_on_path_id);
                        //
                        //echo "Value of fake feature is: ", $perp_feature_id['id'], "\n";
                        
                        
                       
                        $current_floor_array[$i] = array($a,$perp_feature_id['id'],distance_formula($perpendicular_array[0]['x'],$perpendicular_array[0]['y'], $feature_point_on_path[0], $feature_point_on_path[1]));
                        $i++;
                        $current_floor_array[$i] = array($b,$perp_feature_id['id'],distance_formula($perpendicular_array[1]['x'],$perpendicular_array[1]['y'], $feature_point_on_path[0], $feature_point_on_path[1]));
                        $i++;
                        array_push($last_feature_instruction,$destination_feature_id,$perp_feature_id['id']);
                    
                
                        
                        //$current_floor_array[$i] = array($a,$feature_result['id'],distance_formula($location_value['x'],$location_value['y'],$feature_result['x'],$feature_result['y']));
                       
                        //$i+=1;
                        
                    }
                    
                    else
                    {
                    }
                        //echo "The node_id is:  " . $a . " and the neighbor id is:  " . $row['neighbor_id'] . " and the distance is: " . $row['distance'] . "</br>";
                         $current_floor_array[$i] = array($a,$b,$distance);
                         $i+=1;
       
                    
                    
                    
                }
            }
//print_r($current_floor_array);

//echo "This is the exit that you are going to: ", $closest_exit_id , "\n";
//Output from floor to exit    


//Use the exit that the previous exit is connected to and insert it into an array 



// REMEMBER TO IMPLEMENT EXIT/FEATURE ON PATH

if ($which_floor_id != $feature_floor_id)
{
        //echo "i got in here!!", "\n";
    
        $query5 = "SELECT * FROM exits WHERE floor_id = $feature_floor_id and connect_id = $new_connect_id";   
        $result5 = mysqli_query($con,$query5)or  die(mysqli_error($con));
        $destination_exit = mysqli_fetch_assoc($result5);

//Query to select the feature that the user has chose:


        //echo "exit id is: " , $destination_exit['id'], "\n";



//run shortest function to find the closest node
        $closest_node=closest_node($destination_exit['x'],$destination_exit['y'],$feature_result['floor_id'],$con);
        //echo "The distance to the closest node is: " . $closest_node[1] . " and the ID of that node is " . $closest_node[0], "\n";

//Make the relationship that the exit is connected to the node 
    
        $current_floor_array[$i] = array($destination_exit['id'],$closest_node[0],$closest_node[1]);
        //print_r ($current_floor_array);



        //echo "The starting point is: " , $starting_point, " and the exit id you are going to is:", $closest_exit_id, "\n";
        
        //If user was on a different building, you are routing from the entrance to the closest exit
        if ($user_building_id != $which_building)
        {
            $current_floor_path = dijkstra($current_floor_array, $starting_point, $perp_exit_id['id']);
            
            array_push($last_exit_instruction,$current_floor_path[count($current_floor_path)-2]);
            echo "You are now in: ", $feature_building_name, "\n";
            echo "4: This is the path to the next floor: ".implode(", ", $current_floor_path)."\n";
            $current_floor_path_instruction=path_instruction($current_floor_path,$con);
            echo "\n";
            $draw_path_4=get_all_path_coorindates($current_floor_path,$con);
        }
        
        
      
        //path_instruction($array_returned[1],$con);
        
        else
        {
            $current_floor_path = dijkstra($current_floor_array, $starting_point, $perp_exit_id['id']);
            array_push($last_exit_instruction,$current_floor_path[count($current_floor_path)-2]);
            echo "4: This is the path to the next floor on the same building: ".implode(", ", $current_floor_path)."\n";
               $current_floor_path_instruction=path_instruction($current_floor_path,$con);
            echo "\n";
            $draw_path_4=get_all_path_coorindates($current_floor_path,$con);
        }

        $next_floor_path = dijkstra($current_floor_array, $destination_exit['id'], $perp_feature_id['id']);  

        array_push($last_feature_instruction,$next_floor_path[count($next_floor_path)-2]);
        echo "5: This is the path on the next floor to the feature: ".implode(", ", $next_floor_path)."\n"; 
         $next_floor_path_instruction=path_instruction($next_floor_path,$con);
        echo "\n";
        $draw_path_5=get_all_path_coorindates($next_floor_path,$con);
}

    else
    {
    $current_floor_path = dijkstra($current_floor_array, $starting_point, $perp_feature_id['id']);
    
    echo "4: This is the path to the feature on the same floor: ".implode(", ", $current_floor_path)."\n";
    array_push($last_feature_instruction,$current_floor_path[count($current_floor_path)-2]);
    $current_floor_path_instruction=path_instruction($current_floor_path,$con);
    echo "\n";
    $draw_path_4=get_all_path_coorindates($current_floor_path,$con);
    //print_r($draw_path_4);
    }
//echo '<pre>'; print_r(array_values($array)); echo '</pre>';  
//print_r($last_exit_instruction);
//print_r($last_feature_instruction);
return array($current_floor_path,$next_floor_path,$draw_path_4,$draw_path_5,$current_floor_path_instruction,$next_floor_path_instruction);

}




//BEGINNING OF Routing algorithm


if($user_building_id != $feature_building_id)   // if true, building-building
{ 
    


//Find closest exit that takes you to the outside
    $building_array = array();
   
    
   
    $nearest_building_exit = mysqli_query($con,"select * from exits where description = 'door' and floor_id = $user_floor_id")or  die("This gave me the error10: " .mysqli_error($con));
    if ($nearest_building_exit->num_rows > 0)
    {// there are exits on this floor 
        //echo " I got inside another loop yay ", "\n";
    

    
        //route to the nearest exit whose description is door
        $shortest_building_exit_distance = 0;
        $current_building_exit_distance=0;
        $door_exits_query=mysqli_query($con,"select * from exits where description = 'door' AND floor_id = $user_floor_id")or  die("This gave me the error123: " .mysqli_error($con));
        $door_exits_result=mysqli_fetch_assoc($door_exits_query);
        while($door_exits_result=mysqli_fetch_assoc($door_exits_query))
        {
            //echo " woo hoo i got to this far";
        
            $current_building_exit_distance=distance_formula($userClicked['x'],$userClicked['y'], $door_exits_result['x'], $door_exits_result['y'] );  
            //echo "this is the current building distance: ", $current_building_exit_distance , "\n";
            if($shortest_building_exit_distance > $current_building_exit_distance or $shortest_building_exit_distance==0){
            
                $shortest_building_exit_distance=$current_building_exit_distance;
                $nearest_building_exit_id = $door_exits_result['id'];
                $nearest_building_exit_x=$door_exits_result['x'];
                $nearest_building_exit_y=$door_exits_result['y'];
                $nearest_building_exit_path_id=$door_exits_result['path_id'];
                //echo " ID of closest exit is ",  $nearest_building_exit_id, " and the x is: ", $nearest_building_exit_x, " and the y is ", $nearest_building_exit_y, "\n" ;
            }
            
            
        }
        
        //FIND POINT ON LINE CODE
        
        
        
        $returned_path_function  = queryAllPathsOnFloor1($nearest_building_exit_x, $nearest_building_exit_y,$user_floor_id,$nearest_building_exit_path_id,$con);
        $closest_exit_array = $returned_path_function[0];
       
        

        $insert_exit_query= "INSERT IGNORE INTO exit_point_on_path VALUES(NULL,$returned_path_function[1],$returned_path_function[2],$nearest_building_exit_id)";
        if(mysqli_query($con,$insert_exit_query) == TRUE)
        {
            //echo "New exit record successfully created", "\n";
        }
        
        $exit_point_on_path_id=mysqli_query($con,"select id from exit_point_on_path where exit_id=$nearest_building_exit_id");
        $perp_exit_id=mysqli_fetch_assoc($exit_point_on_path_id);
        //echo "Value of fake exit is: ", $perp_exit_id['id'], "\n";
        $closest_node_to_exit = closest_node($nearest_building_exit_x,$nearest_building_exit_y,$user_floor_id,$con);
        $closest_exit_array[]=array($perp_exit_id['id'],$returned_path_function[3],$returned_path_function[4]);
        //print_r ($closest_exit_array);
              
       
        //echo "nearest node is: " , $closest_node_to_exit[0], " and the distance is: ", $closest_node_to_exit[1], "\n";
        //$closest_exit_array[] = array($nearest_building_exit_id,$closest_node_to_exit[0],$closest_node_to_exit[1]);

       
     
        //echo "Value of starting node and ending node ID is: ", $node_closest_to_point_clicked[0], " and", $nearest_building_exit_id, "\n";
        //print_r($closest_exit_array);
        
        
        $count=0;
        $closest_node_to_building_query=mysqli_query($con,"select id,x,y,building_id from building_exit where exit_id=$nearest_building_exit_id")or  die("This gave me the error124: " .mysqli_error($con));
        $closest_node_to_building_result=mysqli_fetch_assoc($closest_node_to_building_query);
        $starting_building_id = $closest_node_to_building_result['id'];
        //echo "starting building id is: (should be one or two if UU) ", $starting_building_id;
        $destination_exit_query=mysqli_query($con,"select id,exit_id,building_id from building_exit where building_id= $feature_building_id LIMIT 1") or  die("This gave me the error125: " .mysqli_error($con));
        $destination_exit_result=mysqli_fetch_assoc($destination_exit_query);
        $ending_building_id=$destination_exit_result['id'];
        $ending_building_exit_id=$destination_exit_result['exit_id'];
        $ending_building_building_id=$destination_exit_result['building_id'];
        //echo "destination building id is: (should be 5 or 6 if EB) ", $ending_building_id;
       
    
    
        
        $query = mysqli_query($con,"select * from campus_path")or  die("This gave me the error126: " .mysqli_error($con));
        while($row=mysqli_fetch_assoc($query)){
        
            //echo "am i ever in here", "\n";
        
            $a=$row['node_id'];
            $b=$row['neighbor_id'];
            $distance=$row['distance'];
            $id=$row['building_id'];
        
            //echo "a value is : ", $a, "\n";
        
            $building_array[$count] = array($a,$b,$distance);
            $count++;
        
        }
      

        $next_building_array = array();
        $next_building_floor_query = mysqli_query($con, "select * from exits where id =  $ending_building_exit_id  ");
        $next_building_floor_result=mysqli_fetch_assoc($next_building_floor_query);
        
        $starting_exit_point_id = $next_building_floor_result['id'];
        $starting_exit_point_x = $next_building_floor_result['x'];
        $starting_exit_point_y = $next_building_floor_result['y'];
        $starting_exit_point_floor_id=$next_building_floor_result['floor_id'];
        /*
        echo("Starting point ID is: "), $starting_exit_point_id , "\n";
        echo("Starting point x is: "), $starting_exit_point_x , "\n";
        echo("Starting point y is: "), $starting_exit_point_y , "\n";
        */
        $next_building_floor_node = closest_node($starting_exit_point_x,$starting_exit_point_y,$starting_exit_point_floor_id,$con);
        $i=0;
        //echo("Closest node to exit in the floor is:  "), $next_building_floor_node[0] , "\n";
        $next_building_array[$i] = array($starting_exit_point_id,$next_building_floor_node[0],$next_building_floor_node[1]);
        $i++;
      
       
        
        $closest_exit_path = dijkstra($closest_exit_array, $node_closest_to_point_clicked[0], $perp_exit_id['id']);    //might have to change this a bit 
        echo "2: The path to the closest exit is: ".implode(", ", $closest_exit_path)."\n";
        $closest_exit_path_instruction=path_instruction($closest_exit_path,$con);
        echo "\n";
        $building_path = dijkstra($building_array, $closest_node_to_building_result['id'],  $ending_building_id);    
        echo "3: The building path is: ".implode(", ", $building_path)."\n";
        $building_path_instruction=path_instruction( $building_path,$con);
        echo "\n";
       
        $array_returned=where_are_you_coming_from( $starting_exit_point_id,$ending_building_building_id,$starting_exit_point_x,$starting_exit_point_y,$starting_exit_point_floor_id,$next_building_array,$con);  
        
        
        $big_array=array();
        $draw_path_2=get_all_path_coorindates($closest_exit_path,$con);
        $draw_path_3=get_all_path_coorindates($building_path,$con);
        array_push($big_array,$draw_path_1,$draw_path_2,$draw_path_3,$array_returned[2],$array_returned[3]);
        //echo $string_data;
        file_put_contents("OverallPathXY.txt", $string_data);
        //echo json_encode($big_array);
        
        
        
        
        $big_instruction_array =array();
        array_push($big_instruction_array,$closest_exit_path_instruction,$building_path_instruction,$array_returned[4],$array_returned[5]);
        $string_data1 = serialize($big_instruction_array);
        echo $string_data1;
        file_put_contents("Instruction.txt", $string_data1);
        //echo "Size of big array is: ", 
        //print_r($big_array);
        //$string_data = serialize($big_array);
        //echo $string_data;
        //file_put_contents("OverallPathXY.txt", $string_data);
        //echo json_encode($big_array);
    
    
    }    
    
    
////////////////////////////////////////////////////////////////////////////////////////////////    
    
    
    else{
        $next_floor_array = array();
       
        
        $query = mysqli_query($con,"select * from exits where floor_id = $user_floor_id");
        $result =mysqli_fetch_assoc($query);

        
        $exit_to_use=closest_exit($user_floor_id,$feature_floor_id,$userClicked['x'],$userClicked['y'],$con); 
        $shortest_something=closest_node($exit_to_use[2],$exit_to_use[3],$user_floor_id,$con);
        
        
        $some_value=queryAllPathsOnFloor1($exit_to_use[2],$exit_to_use[3],$user_floor_id,$exit_to_use[0],$con);
     
        //echo "Value of some_value is:", " ",$some_value[1], " ",$some_value[2], " ",$some_value[3], "\n";
        
        
        $insert_exit_query= "INSERT IGNORE INTO exit_point_on_path VALUES(NULL,$some_value[1],$some_value[2],$exit_to_use[1])";
        if(mysqli_query($con,$insert_exit_query) == TRUE)
        {
            //echo "New exit record successfully created", "\n";
        }
        
        $first_id =$exit_to_use[1];
        $exit_point_on_path_id=mysqli_query($con,"select id from exit_point_on_path where exit_id=$first_id");
        $perp_exit_id=mysqli_fetch_assoc($exit_point_on_path_id);
        
        //echo "Value of fake exit is: ", $perp_exit_id['id'], "\n";
        
        
        //ROUTE TO THE EXIT ON THE SAME FLOOR////////////////////////////////
        $closest_exit_array = $some_value[0];
        $closest_exit_array[]= array( $perp_exit_id['id'], $some_value[3],$some_value[4]);
        /////////////////////////////////////////////////////
        
        
        
        
        
        
        
        
        
        
        //return array($new_path_id,$closest_exit_id,$new_x,$new_y,$new_connect_id,$new_floor_id);
       
      
        //echo "New connect id is: ", $exit_to_use[4], "\n";
        //echo "New floor id is: ", $exit_to_use[5], "\n";
        //echo " I got inside another loop yay ", "\n";
        $query=mysqli_query($con, "select * from exits where connect_id = $exit_to_use[4] and floor_id = $exit_to_use[5] and description != 'door'");
        $next_floor_result= mysqli_fetch_assoc($query);
        $next_floor_id = $next_floor_result['id'];
        //echo "The exit ID you are starting at on the next floor is: ",  $next_floor_result['id'], "\n";
        
    
        //route to the door on the next floor
        $shortest_building_exit_distance = 0;
        $current_building_exit_distance=0;
        $door_exits_query=mysqli_query($con,"select * from exits where description = 'door' AND floor_id = $exit_to_use[5]")or  die("This gave me the error123: " .mysqli_error($con));
        while($door_exits_result=mysqli_fetch_assoc($door_exits_query))
        {
            //echo " woo hoo i got to this far";
        
            $current_building_exit_distance=distance_formula($next_floor_result['x'],$next_floor_result['y'], $door_exits_result['x'], $door_exits_result['y'] );  
            //echo "this is the current building distance: ", $current_building_exit_distance , "\n";
            if($shortest_building_exit_distance > $current_building_exit_distance or $shortest_building_exit_distance==0)
            {
            
                $shortest_building_exit_distance=$current_building_exit_distance;
                $nearest_building_exit_id = $door_exits_result['id'];
                $nearest_building_exit_x=$door_exits_result['x'];
                $nearest_building_exit_y=$door_exits_result['y'];
                $nearest_building_exit_path_id=$door_exits_result['path_id'];
                //echo " ID of closest exit is ",  $nearest_building_exit_id, " and the x is: ", $nearest_building_exit_x, " and the y is ", $nearest_building_exit_y, "\n" ;
            }
            
            
        }
        
        $shit_not_again = queryAllPathsOnFloor1($nearest_building_exit_x,$nearest_building_exit_y,$exit_to_use[5],$nearest_building_exit_path_id,$con);
        
        $insert_exit_query= "INSERT IGNORE INTO exit_point_on_path VALUES(NULL,$shit_not_again[1],$shit_not_again[2],$nearest_building_exit_id)";
        if(mysqli_query($con,$insert_exit_query) == TRUE)
        {
            //echo "New exit record successfully created", "\n";
        }
        
        $exit_point_on_path_id=mysqli_query($con,"select id from exit_point_on_path where exit_id=$nearest_building_exit_id");
        $perp_exit_id1=mysqli_fetch_assoc($exit_point_on_path_id);
        //echo "Value of fake exit is: ", $perp_exit_id1['id'], "\n";
 
        
        
        $closest_node_to_next_floor_exit = closest_node($next_floor_result['x'],$next_floor_result['y'],$exit_to_use[5],$con);
        //echo "nearest node is: " , $closest_node_to_next_floor_exit[0], " and the distance is: ", $closest_node_to_next_floor_exit[1], "\n";
        
        $next_floor_array = $shit_not_again[0];
        $next_floor_array[] = array($perp_exit_id1['id'],$shit_not_again[3],$shit_not_again[4]); //inserts into last position
        //print_r($next_floor_array);
        $next_floor_array[] = array($next_floor_id,$closest_node_to_next_floor_exit[0],$closest_node_to_next_floor_exit[1]);
        
     
        //echo "Value of starting node and ending node ID is: ", $closest_node_to_next_floor_exit[0], " and", $nearest_building_exit_id, "\n";
        //print_r($closest_exit_array);
        
        
        $count=0;
        $closest_node_to_building_query=mysqli_query($con,"select id,x,y,building_id from building_exit where exit_id=$nearest_building_exit_id")or  die("This gave me the error124: " .mysqli_error($con));
        $closest_node_to_building_result=mysqli_fetch_assoc($closest_node_to_building_query);
        $starting_building_id = $closest_node_to_building_result['id'];
        //echo "starting building id is: (should be one or two if UU) ", $starting_building_id, "\n";
        $destination_exit_query=mysqli_query($con,"select id,exit_id,building_id from building_exit where building_id= $feature_building_id LIMIT 1") or  die("This gave me the error125: " .mysqli_error($con));
        $destination_exit_result=mysqli_fetch_assoc($destination_exit_query);
        $ending_building_id=$destination_exit_result['id'];
        $ending_building_exit_id=$destination_exit_result['exit_id'];
        $ending_building_building_id=$destination_exit_result['building_id'];
        //echo "destination building id is: (should be 5 or 6 if EB) ", $ending_building_id , "\n";
        
        $query = mysqli_query($con,"select * from campus_path")or  die("This gave me the error126: " .mysqli_error($con));
        while($row=mysqli_fetch_assoc($query)){
        
            //echo "am i ever in here", "\n";
        
            $a=$row['node_id'];
            $b=$row['neighbor_id'];
            $distance=$row['distance'];
            $id=$row['building_id'];
        
            //echo "a value is : ", $a, "\n";
        
            $building_array[$count] = array($a,$b,$distance);
            $count++;
        
        }
      

        $next_building_array = array();
        $next_building_floor_query = mysqli_query($con, "select * from exits where id =  $ending_building_exit_id  ");
        $next_building_floor_result=mysqli_fetch_assoc($next_building_floor_query);
        
        $starting_exit_point_id = $next_building_floor_result['id'];
        $starting_exit_point_x = $next_building_floor_result['x'];
        $starting_exit_point_y = $next_building_floor_result['y'];
        $starting_exit_point_floor_id=$next_building_floor_result['floor_id'];
        /*
        echo("Starting point ID is: "), $starting_exit_point_id , "\n";
        echo("Starting point x is: "), $starting_exit_point_x , "\n";
        echo("Starting point y is: "), $starting_exit_point_y , "\n";
        */
        $next_building_floor_node = closest_node($starting_exit_point_x,$starting_exit_point_y,$starting_exit_point_floor_id,$con);
        $i=0;
        //echo("Closest node to exit in the floor is:  "), $next_building_floor_node[0] , "\n";
        $next_building_array[$i] = array($starting_exit_point_id,$next_building_floor_node[0],$next_building_floor_node[1]);
        $i++;
      
        $closest_node_to_exit = closest_node($nearest_building_exit_x,$nearest_building_exit_y,$exit_to_use[5],$con);
        //echo "nearest node is: " , $closest_node_to_exit[0], " and the distance is: ", $closest_node_to_exit[1], "\n";
        $next_floor_array[] = array($nearest_building_exit_id,$closest_node_to_exit[0],$closest_node_to_exit[1]);
        
        //echo "value of node_closest: ", $node_closest_to_point_clicked[0], "\n";
        $closest_exit_to_floor_with_door=dijkstra($closest_exit_array,$node_closest_to_point_clicked[0],$perp_exit_id['id']);
        echo "1: Since there is no door on this floor, we will route you to the closest floor. The path to the closest exit is: ".implode(", ", $closest_exit_to_floor_with_door)."\n";
        $closest_exit_to_floor_with_door_path_instruction=path_instruction($closest_exit_to_floor_with_door,$con);
        echo "\n";
        $closest_exit_path = dijkstra($next_floor_array, $next_floor_result['id'], $perp_exit_id1['id']);    //might have to change this a bit 
        echo "2: The path to the closest exit is: ".implode(", ", $closest_exit_path)."\n";
        $closest_exit_path_path_instruction=path_instruction($closest_exit_path,$con);
        echo"\n";
        $building_path = dijkstra($building_array, $closest_node_to_building_result['id'],  $ending_building_id);    
        echo "3: The building path is: ".implode(", ", $building_path)."\n";
        $building_path_instruction=path_instruction($building_path,$con);
        echo "\n";
        $array_returned=where_are_you_coming_from($starting_exit_point_id,$ending_building_building_id,$starting_exit_point_x,$starting_exit_point_y,$starting_exit_point_floor_id,$next_building_array,$con);
        
        $big_array=array();
        
        
        
        $draw_path_1=get_all_path_coorindates($closest_exit_to_floor_with_door,$con);
        $draw_path_2=get_all_path_coorindates($closest_exit_path,$con);
        $draw_path_3=get_all_path_coorindates($building_path,$con);
        array_push($big_array,$draw_path_1,$draw_path_2,$draw_path_3,$array_returned[2],$array_returned[3]);
        
       
        //print_r($big_array);
        $string_data = serialize($big_array);
        //echo $string_data;
        file_put_contents("OverallPathXY.txt", $string_data);
        
        
        
        
        $big_instruction_array =array();
        array_push($big_instruction_array,$closest_exit_to_floor_with_door_path_instruction,$closest_exit_path_path_instruction,$building_path_instruction,$array_returned[4],$array_returned[5]);
        $string_data1 = serialize($big_instruction_array);
        //print_r($big_instruction_array);
        //echo $string_data1;
        file_put_contents("Instruction.txt", $string_data1);
        
        }
}

        
  


//Same building 
else
{
    $big_array=array();
    $big_instruction_array();
    $array_returned=where_are_you_coming_from($node_closest_to_point_clicked[0],$user_building_id,$userClicked['x'],$userClicked['y'],$user_floor_id,$array,$con);
        
     if ($user_floor_id != $feature_floor_id)
    { 
        array_push($big_array,$array_returned[2],$array_returned[3]);
        //print_r($big_array);
        //echo json_encode($big_array);
        $string_data = serialize($big_array);
        echo $string_data;
        file_put_contents("OverallPathXY.txt", $string_data);
        
        
        
        array_push($big_instruction_array,$array_returned[4],$array_returned[5]);
        $string_data1 = serialize($big_instruction_array);
        echo $string_data1;
        file_put_contents("Instruction.txt", $string_data1);
    
    }
    else
    {
        //echo "i am in here right now", "\n";
        array_push($big_array,$array_returned[2]);
        //print_r($big_array);
        $string_data = serialize($big_array);
        //echo $string_data;
        file_put_contents("OverallPathXY.txt", $string_data);
        
        array_push($big_instruction_array,$array_returned[4]);
        $string_data1 = serialize($big_instruction_array);
        echo $string_data1;
        file_put_contents("Instruction.txt", $string_data1);
    }


}




///// JEEEFFFFFFF TEESSSSTTTTTTTTTT


//This is designed to store the data I need for drawing out the first route if it exists.
/*
if (empty($closest_exit_to_floor_with_door) != TRUE) {
    print_r($closest_exit_to_floor_with_door);
    $ExitPathsArray = array();
    foreach($closest_exit_to_floor_with_door as $key=>$nodeInfo) {
        // For every path we have found, grab its node_id and neighbor_id
        // Get the X and Y coordinates of the node
        $sql = "SELECT id, x, y FROM location WHERE id = $nodeInfo;";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $obj = new stdClass;
                $obj->locID = $row["id"];
                $obj->xCord = $row["x"];
                $obj->yCord = $row["y"];
                array_push($ExitPathsArray, $obj);
            }
        }
        // echo sizeof($closest_exit_to_floor_with_door) - 1);
        //echo "\n";
        if ( $key == sizeof($closest_exit_to_floor_with_door) - 1) {
            echo $key, "\n";
            $sql = "SELECT x, y, path_id FROM exits WHERE id = $nodeInfo;";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        $xCordExit = $row["x"];
                        $yCordExit = $row["y"];
                        $pathConnected = $row["path_id"];
                    }
                    echo "Exit Coords: ", $xCordExit, " , ", $yCordExit, "\n";
            }
            // Take the path it is connected to and find the Xs and Ys of that path
            $sql = "SELECT id, node_id, neighbor_id FROM path WHERE id = $pathConnected;";
            $result = $con->query($sql);
            $pathsStored = array();
            if ($result->num_rows > 0) {
                // output data of each rows
                while($row = $result->fetch_assoc()) {
                    $pathID = $row["id"];
                    $obj = new stdClass;
                    $obj->id = $pathConnected;
                    $obj->node_id = $row["node_id"];
                    $obj->neighbor_id = $row["neighbor_id"];
                    array_push($pathsStored, $obj);
                }
            } 
            else {
                echo "0 results";
            }
            // For every path we have found, grab its node_id and neighbor_id
            foreach ($pathsStored as $info) {
                $starter = $info->node_id;
                $ender = $info->neighbor_id;
                // Get the X and Y coordinates of the node_id and neighbor_id
                $sql = "SELECT id, x, y FROM location WHERE id = $starter  OR id = $ender;";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    $tempLocationsStored = array();
                    while($row = $result->fetch_assoc()) {
                        $obj = new stdClass;
                        $obj->locID = $row["id"];
                        $obj->xCord = $row["x"];
                        $obj->yCord = $row["y"];
                        array_push($tempLocationsStored, $obj);
                    }
                    $x1CordLine = $tempLocationsStored[0]->xCord;
                    $y1CordLine = $tempLocationsStored[0]->yCord;
                    $x2CordLine = $tempLocationsStored[1]->xCord;
                    $y2CordLine = $tempLocationsStored[1]->yCord;
                }
                // At this point, I have the Xs and Ys which the path is connected to and the X,Y of the exit itself.
                // Now perform the right math!
                echo $xCordExit, "\n", $yCordExit, "\n", $x1CordLine, "\n", $y1CordLine, "\n", $x2CordLine, "\n", $y2CordLine, "\n";
                
                $imp = (($y2CordLine - $y1CordLine) * ($xCordExit - $x1CordLine) - ($x2CordLine - $x1CordLine) * ($yCordExit - $y1CordLine) ) / ( pow(($y2CordLine - $y1CordLine),2) + pow(($x2CordLine - $x1CordLine),2) );
    
                $exitOnPathXCord = $xCordExit - $imp * ($y2CordLine - $y1CordLine);
                $exitOnPathYCord = $yCordExit + $imp * ($x2CordLine - $x1CordLine);
                
                echo $imp, "\n", $exitOnPathXCord, "\n", $exitOnPathYCord, "\n";
                // Now I have the X,Y of the feature with respect to the connected path. Store it to the end of the ExitsPathsArray
                $obj = new stdClass;
                $obj->locID = $info->id;
                $obj->xCord = $exitOnPathXCord;
                $obj->yCord = $exitOnPathYCord;
                array_push($ExitPathsArray, $obj);
            }
        }
    }
    //print_r($ExitPathsArray);
}
*/

///////////////////////

?>