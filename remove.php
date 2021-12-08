<?php 
    session_start();
    require "config/config.php";
    $results = [
        "status" => "success",
    ];

    
    if (!isset($_GET['track_id']) || empty($_GET['track_id'])){
        $results['status'] = "Did not retrieve all the necessary data to remove this song";
    }
    else{
        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ( $mysqli->connect_errno ) {
            $results['status'] = $mysqli->connect_error;
            echo json_encode($results);
            exit();
        }
        $track_id = intval($_GET['track_id']);

        $statement = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $statement->bind_param("s", $_SESSION['username']);
        $executed = $statement->execute();
        if(!$executed) {
            $results['status'] = $mysqli->error;
            echo json_encode($results);
            exit();
        } 

        // How prepared statement gets results
        $username_results = $statement->get_result();
        $user_id = intval($username_results->fetch_assoc()['id']);
        


        $statement = $mysqli->prepare("DELETE FROM users_has_songs WHERE users_id = ? AND track_id= ?");
        $statement->bind_param("ii",$user_id,$track_id);
        $executed = $statement->execute();
        if(!$executed) {
            $results['status'] = $mysqli->error;
            echo json_encode($results);
            exit();
        }
        
        // see track count
        $statement = $mysqli->prepare("SELECT * FROM songs WHERE track_id = ?");
        $statement->bind_param("i",$track_id);
        $executed = $statement->execute();
        if(!$executed) {
            $results['status'] = $mysqli->error;
            echo json_encode($results);
            exit();
        }
        $song_result = $statement->get_result();
        $count = $song_result->fetch_assoc()['count'];
        $count = intval($count);
        // $results["status"] = $count;
        
        if($count === 1){
            // delete from database
            $statement = $mysqli->prepare("DELETE FROM songs WHERE track_id = ?");
            $statement->bind_param("i",$track_id);
            $executed = $statement->execute();
            if(!$executed) {
                $results['status'] = $mysqli->error;
                echo json_encode($results);
                exit();
            }

        }
        else{
            //update count by -1
            // $count = $count -1;
            $statement = $mysqli->prepare("UPDATE songs SET count = count-1 WHERE track_id = ?");
            $statement->bind_param("i", $track_id);
            $executed = $statement->execute();
            if(!$executed) {
                $results['status'] = $mysqli->error;
                echo json_encode($results);
                exit();
            
            } 
        }

         
     
        $mysqli->close();

    }




    echo json_encode($results);

?>